<?php
/**
 * Plugin Name:       SQ Sidebar Generator
 * Plugin URI:        http://seventhqueen.com
 * Description:       This plugin generates as many sidebars as you need. Then allows you to place them on any page you wish.
 * Version:           1.2.2
 * Author:            SeventhQueen
 * Author URI:
 * Text Domain:       sq-sidebar-generator
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path:       /languages
 */
/* Forked from:  Kyle Getson */

if ( ! class_exists( 'sq_sidebar_generator' ) ) {
	class sq_sidebar_generator {

		public function __construct() {
			add_action( 'init', array( $this, 'init' ) );
			add_action( 'admin_menu', array( 'sq_sidebar_generator', 'admin_menu' ) );
			add_action( 'admin_print_scripts', array( 'sq_sidebar_generator', 'admin_print_scripts' ) );

			add_action( 'add_meta_boxes', [ $this, 'add_meta_boxes' ] );

			//save posts/pages
			add_action( 'save_post', array( 'sq_sidebar_generator', 'save_form' ), 10, 2 );

		}

		public static function init() {

			// Register AJAX hooks
			if ( current_user_can( 'manage_options' ) ) {
				add_action( 'wp_ajax_add_sidebar', array( 'sq_sidebar_generator', 'add_sidebar' ) );
				add_action( 'wp_ajax_remove_sidebar', array( 'sq_sidebar_generator', 'remove_sidebar' ) );
			}


			//go through each sidebar and register it
			$sidebars = self::get_sidebars();

			global $wp_registered_sidebars;

			if ( is_array( $sidebars ) ) {
				foreach ( $sidebars as $sidebar ) {
					$sidebar_class = self::name_to_class( $sidebar );
					$i             = count( $wp_registered_sidebars ) + 1;

					register_sidebar( array(
						'name'          => $sidebar,
						'id'            => 'sidebar-' . $i,
						'before_widget' => '<div id="%1$s" class="widget clearfix %2$s">',
						'after_widget'  => '</div>',
						'before_title'  => apply_filters( 'sq_ms_before_title', '<h4>' ),
						'after_title'   => apply_filters( 'sq_ms_after_title', '</h4>' ),
					) );
				}
			}
		}

		public function add_meta_boxes() {
			$post_types = get_post_types();
			add_meta_box( 'sq_sidebar_generator', 'Sidebar Generator',  array( 'sq_sidebar_generator', 'edit_form' ), $post_types );
		}

		public static function admin_print_scripts() {
			wp_print_scripts( array( 'sack' ) );
			?>
			<script>
				function add_sidebar(sidebar_name) {

					var mysack = new sack("<?php echo esc_url( admin_url( 'admin-ajax.php' ) ); ?>");

					mysack.execute = 1;
					mysack.method = 'POST';
					mysack.setVar("action", "add_sidebar");
					mysack.setVar("sidebar_name", sidebar_name);
					mysack.setVar("sidebar_generator_nonce", "<?php echo wp_create_nonce( 'add_sidebar' )?>");
					mysack.encVar("cookie", document.cookie, false);
					mysack.onError = function () {
						alert('Ajax error. Cannot add sidebar')
					};
					mysack.runAJAX();
					return true;
				}

				function remove_sidebar(sidebar_name, num) {

					var mysack = new sack("<?php echo esc_url( admin_url( 'admin-ajax.php' ) ); ?>");

					mysack.execute = 1;
					mysack.method = 'POST';
					mysack.setVar("action", "remove_sidebar");
					mysack.setVar("sidebar_name", sidebar_name);
					mysack.setVar("sidebar_generator_nonce", "<?php echo wp_create_nonce( 'remove_sidebar' )?>");
					mysack.setVar("row_number", num);
					mysack.encVar("cookie", document.cookie, false);
					mysack.onError = function () {
						alert('<?php esc_html_e( 'Ajax error. Cannot add sidebar', 'sq-sidebar-generator' ); ?>')
					};
					mysack.runAJAX();
					//alert('hi!:::'+sidebar_name);
					return true;
				}
			</script>
			<?php
		}

		public static function add_sidebar() {
			check_admin_referer( 'add_sidebar', 'sidebar_generator_nonce' );

			$sidebars = self::get_sidebars();
			$name     = str_replace( array( "\n", "\r", "\t" ), '', $_POST['sidebar_name'] );
			//$id       = self::name_to_class( $name );
			$id = sanitize_title( $name );
			if ( isset( $sidebars[ $id ] ) ) {
				die( "alert('" . esc_html__( 'Sidebar already exists, please use a different name.', 'sq-sidebar-generator' ) . "')" );
			}

			$sidebars[ $id ] = $name;
			self::update_sidebars( $sidebars );

			$js = "
			var tbl = document.getElementById('sbg_table');
			var lastRow = tbl.rows.length;
			// if there's no header row in the table, then iteration = lastRow + 1
			var iteration = lastRow;
			var row = tbl.insertRow(lastRow);
			
			// left cell
			var cellLeft = row.insertCell(0);
			var textNode = document.createTextNode('" . esc_js( $name ) . "');
			cellLeft.appendChild(textNode);
			
			//middle cell
			var cellLeft = row.insertCell(1);
			var textNode = document.createTextNode('" . esc_js( $id ) . "');
			cellLeft.appendChild(textNode);
			
			//var cellLeft = row.insertCell(2);
			//var textNode = document.createTextNode('[<a href=\'javascript:void(0);\' onclick=\'return remove_sidebar_link($name);\'>Remove</a>]');
			//cellLeft.appendChild(textNode)
			
			var cellLeft = row.insertCell(2);
			removeLink = document.createElement('a');
      		linkText = document.createTextNode('remove');
			removeLink.setAttribute('onclick', 'remove_sidebar_link(\'" . esc_js( $name ) . "\')');
			removeLink.setAttribute('href', '#');
        
      		removeLink.appendChild(linkText);
      		cellLeft.appendChild(removeLink);

			
		";


			die( "$js" );
		}

		public static function remove_sidebar() {
			check_admin_referer( 'remove_sidebar', 'sidebar_generator_nonce' );

			$sidebars = self::get_sidebars();
			$name     = str_replace( array( "\n", "\r", "\t" ), '', $_POST['sidebar_name'] );
			$id       = sanitize_title( $name );
			if ( ! isset( $sidebars[ $id ] ) ) {
				$id = self::name_to_class( $name );

				if ( ! isset( $sidebars[ $id ] ) ) {
					die( "alert('Sidebar does not exist.')" );
				}
			}
			$row_number = (int) $_POST['row_number'];
			unset( $sidebars[ $id ] );
			self::update_sidebars( $sidebars );
			$js = "var tbl = document.getElementById('sbg_table');tbl.deleteRow($row_number)";

			die( $js );
		}

		public static function admin_menu() {
			add_theme_page(
				esc_html__( 'Sidebars', 'sq-sidebar-generator' ),
				esc_html__( 'Sidebars', 'sq-sidebar-generator' ),
				'manage_options',
				'sq_sidebars', array(
				'sq_sidebar_generator',
				'admin_page',
			) );

		}

		public static function admin_page() {
			?>
			<script>
				function remove_sidebar_link(name, num) {
					answer = confirm("Are you sure you want to remove " + name + "?\nThis will remove any widgets you have assigned to this sidebar.");
					if (answer) {
						remove_sidebar(name, num);
					} else {
						return false;
					}
				}
				function add_sidebar_link() {
					var sidebar_name = prompt("Sidebar Name:", "");
					add_sidebar(sidebar_name);
				}
			</script>
			<div class="wrap">
				<h2>Sidebars</h2>
				<br/>
				<table class="widefat page" id="sbg_table" style="width:600px;">
					<tr>
						<th>Sidebar Name</th>
						<th>CSS class</th>
						<th>Remove</th>
					</tr>
					<?php
					$sidebars = self::get_sidebars();
					if ( is_array( $sidebars ) && ! empty( $sidebars ) ) {
						$cnt = 0;
						foreach ( $sidebars as $sidebar ) {
							$alt = ( 0 == $cnt % 2 ? 'alternate' : '' );
							?>
							<tr class="<?php echo esc_attr( $alt ) ?>">
								<td><?php echo esc_html( $sidebar ); ?></td>
								<td><?php echo sanitize_title( $sidebar ); ?></td>
								<td><a href="javascript:void(0);"
								       onclick="return remove_sidebar_link('<?php echo esc_attr( $sidebar ); ?>',<?php echo (int) ( $cnt + 1 ); ?>);"
								       title="Remove this sidebar">remove</a></td>
							</tr>
							<?php
							$cnt ++;
						}
					} else {
						?>
						<tr>
							<td colspan="3">No Sidebars defined</td>
						</tr>
						<?php
					}
					?>
				</table>
				<br/><br/>

				<div class="add_sidebar">
					<a href="javascript:void(0);" onclick="return add_sidebar_link()" title="Add a sidebar"
					   class="button-primary">+ Add New Sidebar</a>

				</div>

			</div>
			<?php
		}

		/**
		 * for saving the pages/post
		 *
		 * @param integer $post_id
		 *
		 * @return void
		 */
		public static function save_form( $post_id, $post ) {

			if ( isset( $_POST['sbg_edit'] ) && ! empty( $_POST['sbg_edit'] ) ) {
				delete_post_meta( $post_id, 'sbg_selected_sidebar' );
				delete_post_meta( $post_id, 'sbg_selected_sidebar_replacement' );
				add_post_meta( $post_id, 'sbg_selected_sidebar', $_POST['sidebar_generator'] );
				add_post_meta( $post_id, 'sbg_selected_sidebar_replacement', $_POST['sidebar_generator_replacement'] );
			}
		}

		public static function edit_form() {
			global $post;
			$post_id = $post;
			if ( is_object( $post_id ) ) {
				$post_id = $post_id->ID;
			}
			$selected_sidebar = get_post_meta( $post_id, 'sbg_selected_sidebar', true );
			if ( ! is_array( $selected_sidebar ) ) {
				$tmp                 = $selected_sidebar;
				$selected_sidebar    = array();
				$selected_sidebar[0] = $tmp;
			}
			$selected_sidebar_replacement = get_post_meta( $post_id, 'sbg_selected_sidebar_replacement', true );
			if ( ! is_array( $selected_sidebar_replacement ) ) {
				$tmp                             = $selected_sidebar_replacement;
				$selected_sidebar_replacement    = array();
				$selected_sidebar_replacement[0] = $tmp;
			}
			?>

			<div id='sbg-sortables' class='meta-box-sortables'>
				<div id="sbg_box" class="postbox ">
					<div class="handlediv" title="Click to toggle"><br/></div>
					<h3 class='hndle'><span>Sidebar</span></h3>

					<div class="inside">
						<div class="sbg_container">
							<input name="sbg_edit" type="hidden" value="sbg_edit"/>

							<p>Please select the sidebar you would like to display on this page. <strong>Note:</strong>
								You must first create the sidebar under Appearance > Sidebars.
							</p>
							<ul>
								<?php
								global $wp_registered_sidebars;
								for ( $i = 0; $i < 1; $i ++ ) { ?>
									<li>
										<select name="sidebar_generator[<?php echo $i ?>]" style="display: none;">
											<option value="0"<?php if ( $selected_sidebar[ $i ] == '' ) {
												echo " selected";
											} ?>>WP Default Sidebar
											</option>
											<?php
											$sidebars = $wp_registered_sidebars;// sidebar_generator::get_sidebars();
											if ( is_array( $sidebars ) && ! empty( $sidebars ) ) {
												foreach ( $sidebars as $sidebar ) {
													if ( $selected_sidebar[ $i ] == $sidebar['name'] ) {
														echo "<option value='" . esc_attr( $sidebar['name'] ) . "' selected>" . esc_html( $sidebar['name'] ) . "</option>\n";
													} else {
														echo "<option value='" . esc_attr( $sidebar['name'] ) . "'>" . esc_html( $sidebar['name'] ) . "</option>\n";
													}
												}
											}
											?>
										</select>
										<select name="sidebar_generator_replacement[<?php echo $i ?>]">
											<option value="0"<?php if ( '' == $selected_sidebar_replacement[ $i ] ) {
												echo ' selected';
											} ?>>None
											</option>
											<?php

											$sidebar_replacements = $wp_registered_sidebars;//sidebar_generator::get_sidebars();
											if ( is_array( $sidebar_replacements ) && ! empty( $sidebar_replacements ) ) {
												foreach ( $sidebar_replacements as $sidebar ) {
													if ( $selected_sidebar_replacement[ $i ] == $sidebar['name'] ) {
														echo "<option value='{$sidebar['name']}' selected>{$sidebar['name']}</option>\n";
													} else {
														echo "<option value='{$sidebar['name']}'>{$sidebar['name']}</option>\n";
													}
												}
											}
											?>
										</select>

									</li>
								<?php } ?>
							</ul>
						</div>
					</div>
				</div>
			</div>

			<?php
		}

		/**
		 * called by the action get_sidebar. this is what places this into the theme
		 *
		 * @param string $name
		 */
		public static function get_sidebar( $name = '0' ) {

			if ( 'sidebar-1' == $name ) {
				$name = '0';
			}
			if ( ! ( is_singular() || is_home() ) ) {
				if ( '0' != $name ) {
					dynamic_sidebar( $name );
				} else {
					dynamic_sidebar();
				}

				return;//do not do anything
			}

			global $wp_query;
			$post = $wp_query->get_queried_object();
			/*if ( ! $post ) {
				dynamic_sidebar();

				return;
			}*/


			if ( ! is_object( $post ) ) {

				if ( function_exists( 'sq_bp_get_page_id' ) && bp_is_blog_page() && sq_bp_get_page_id() ) {
					$post_id = sq_bp_get_page_id();
				} elseif ( is_home() && get_option( 'page_for_posts' ) ) {
					$post_id = get_option( 'page_for_posts' );
				} else {
					if ( '0' != $name ) {
						dynamic_sidebar( $name );
					} else {
						dynamic_sidebar();
					}

					return;
				}
			} else {
				$post_id = $post->ID;
			}



			$selected_sidebar             = get_post_meta( $post_id, 'sbg_selected_sidebar', true );
			$selected_sidebar_replacement = get_post_meta( $post_id, 'sbg_selected_sidebar_replacement', true );
			$did_sidebar                  = false;
			//this page uses a generated sidebar

			if ( ! empty( $selected_sidebar_replacement ) && ( isset( $selected_sidebar_replacement ) && '0' !== $selected_sidebar_replacement[0] ) ) {

				if ( function_exists( 'is_woocommerce' ) ) {
					if ( is_woocommerce() ) {
						$shop_sidebar = 'shop-1';

						if ( $name == $shop_sidebar ) {
							$selected_sidebar = array( $shop_sidebar );
						}
					}
				}
			}

			if ( '' != $selected_sidebar && '0' != $selected_sidebar ) {
				echo '';
				if ( is_array( $selected_sidebar ) && ! empty( $selected_sidebar ) ) {
					for ( $i = 0; $i < sizeof( $selected_sidebar ); $i ++ ) {

						if ( '0' == $name && '0' == $selected_sidebar[ $i ] && '0' == $selected_sidebar_replacement[ $i ] ) {
							//echo "\n\n<!-- [called $name selected {$selected_sidebar[$i]} replacement {$selected_sidebar_replacement[$i]}] -->";
							dynamic_sidebar();//default behavior
							$did_sidebar = true;

							break;
						} elseif ( '0' == $name && '0' == $selected_sidebar[ $i ] ) {
							//we are replacing the default sidebar with something
							//echo "\n\n<!-- [called $name selected {$selected_sidebar[$i]} replacement {$selected_sidebar_replacement[$i]}] -->";
							dynamic_sidebar( $selected_sidebar_replacement[ $i ] );//default behavior
							$did_sidebar = true;

							break;
						} elseif ( $selected_sidebar[ $i ] == $name ) {
							//we are replacing this $name
							//echo "\n\n<!-- [called $name selected {$selected_sidebar[$i]} replacement {$selected_sidebar_replacement[$i]}] -->";
							$did_sidebar = true;
							dynamic_sidebar( $selected_sidebar_replacement[ $i ] );//default behavior
							break;
						}

						//echo "<!-- called=$name selected={$selected_sidebar[$i]} replacement={$selected_sidebar_replacement[$i]} -->\n";
					}
				}
				if ( true == $did_sidebar ) {
					echo '';

					return;
				}
				//go through without finding any replacements, lets just send them what they asked for
				if ( '0' != $name ) {
					dynamic_sidebar( $name );
				} else {
					dynamic_sidebar();
				}
				echo '';

				return;
			} else {
				if ( '0' != $name ) {
					dynamic_sidebar( $name );
				} else {
					dynamic_sidebar();
				}
			}
		}

		/**
		 * replaces array of sidebar names
		 */
		public static function update_sidebars( $sidebar_array ) {
			$sidebars = update_option( 'sbg_sidebars', $sidebar_array );
		}

		/**
		 * gets the generated sidebars
		 */
		public static function get_sidebars() {
			$sidebars = get_option( 'sbg_sidebars' );

			return $sidebars;
		}

		public static function name_to_class( $name ) {
			$class = str_replace( array(
				' ',
				',',
				'.',
				'"',
				"'",
				'/',
				"\\",
				'+',
				'=',
				')',
				'(',
				'*',
				'&',
				'^',
				'%',
				'$',
				'#',
				'@',
				'!',
				'~',
				'`',
				'<',
				'>',
				'?',
				'[',
				']',
				'{',
				'}',
				'|',
				':',
			), '', $name );

			return $class;
		}

	}
}
$sbg = new sq_sidebar_generator;

function generated_dynamic_sidebar( $name = '0' ) {
	sq_sidebar_generator::get_sidebar( $name );

	return true;
}
