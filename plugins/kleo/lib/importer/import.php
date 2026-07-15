<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/** ---------------------------------------------------------------------------
 * Import Demo Data
 * @author SeventhQueen
 * @version 1.0
 * ---------------------------------------------------------------------------- */
class kleoImport {

	private static $instance;
	private static $pages_data = array();
	public $error = '';
	public $messages = array();
	public $session = '';
	public $data_imported = false;

	/**
	 * Array with pages imported
	 *
	 * @var array
	 */

	public $posts_imported = array();

	/**
	 * Save mapping for search and replace
	 * @var array
	 */
	private $url_remap = array();

	/**
	 * Keep track of images imported
	 *
	 * @var array
	 */

	public $images_imported = array();
	/**
	 * Save the images that will be imported
	 * @var array
	 */

	public $total_images = array();
	/**
	 * Keep a history of all imported images on the site
	 * @var null
	 */

	public $image_history = null;
	/**
	 * Save images from post content for later import
	 * @var array
	 */
	public $content_images = array();
	/**
	 * Save attached posts images for later import
	 * @var array
	 */
	public $attached_images = array();
	/**
	 * Save slide media images for later import
	 * @var array
	 */
	public $slide_meta_images = array();
	/**
	 * Save featured images for later import
	 * @var array
	 */
	public $featured_images = array();
	/**
	 * Save external id and url for image import
	 * @var array
	 */
	public $remote_images = array();
	public $remote_url_base = '';
	public $local_url_base = '';
	public $processes = 0;
	public $done_processes = 0;
	public $progress_pid = null;

	/**
	 * Constructor
	 */
	public function __construct() {
		add_action( 'admin_menu', array( $this, 'init' ) );

		add_action( 'admin_init', array( $this, 'do_import' ), 12 );

		$this->add_initial_demo_sets();

		add_action( 'admin_enqueue_scripts', array( $this, 'import_assets' ) );

		add_action( 'wp_ajax_sq_single_import', array( $this, 'do_ajax' ) );
		add_action( 'wp_ajax_sq_set_as_home', array( $this, 'set_as_homepage' ) );

		if( isset( $_GET['sq_single_import'] ) && $_GET['sq_single_import'] ) {
			if (defined('DOING_AJAX') && DOING_AJAX) {
				add_filter('wp_redirect', function () {
					return false;
				});
			}
		}

	}

	function add_initial_demo_sets() {

		$remote_path = 'https://seventhqueen.com/support/files/kleo/importer/';
		$pages_data  = array();

		$connected_fields = array(
			array(
				'field_group_id' => '1',
				'name'           => 'Skills',
				'can_delete'     => 1,
				'is_required'    => false,
				'type'           => 'selectbox',
				'options'        => array(
					'Web Designer',
					'PHP Developer',
					'SEO Guru',
					'Java Programmer',
				),
			),
			array(
				'field_group_id' => '1',
				'name'           => 'Country',
				'can_delete'     => 1,
				'is_required'    => false,
				'type'           => 'selectbox',
				'options'        => array(
					'USA',
					'United Kingdom',
					'India',
					'France',
					'Spain',
					'Romania',
					'Germany',
					'Other',
				),
			),
			array(
				'field_group_id' => '1',
				'name'           => 'Price rate',
				'can_delete'     => 1,
				'is_required'    => false,
				'type'           => 'textbox',
			),
		);

		$pages_data['home-travel'] = array(
			'name'    => 'Travel Destination (v4.2)',
			'slug'    => 'travel-destination',
			'img'     => $remote_path . 'img/home-travel-destination.jpg',
			'page'    => 'pages/home-travel-destination',
			'extra'   => array(

				array(
					'id'      => 'testimonials',
					'data'    => 'content/testimonials',
					'name'    => 'Import Dummy Testimonials',
					'checked' => true,
				),
			),
			'attach'  => 'yes',
			'plugins' => array( 'js_composer', 'k-elements', 'mailchimp-for-wp' ),
			//'details' => '',
			'link'    => 'https://seventhqueen.com/themes/kleo/travel-destination/',
		);

		$pages_data['home-sport'] = array(
			'name'    => 'Sport/Fitness (v4.2)',
			'slug'    => 'home-sport',
			'img'     => $remote_path . 'img/home-sport.jpg',
			'page'    => 'pages/home-sport',
			'attach'  => 'yes',
			'plugins' => array( 'js_composer', 'k-elements' ),
			'options' => 'home-sport',
			'link'    => 'https://seventhqueen.com/themes/kleo/sport/',
		);

		$pages_data['home-medical'] = array(
			'name'      => 'Home Medical (v4.2)',
			'slug'      => 'home-medical',
			'img'       => $remote_path . 'img/home-medical.jpg',
			'page'      => 'pages/home-medical',
			'attach'    => 'yes',
			'plugins'   => array( 'js_composer', 'k-elements', 'revslider', 'contact-form-7' ),
			'revslider' => 'kleo_medical',
			'options'   => 'home-medical',
			'extra'     => array(
				array(
					'id'      => 'menu',
					'name'    => 'Import Menu',
					'slug'    => 'kleo-medical',
					'data'    => 'content/menu-medical',
					'checked' => true,
				),
				array(
					'id'      => 'posts',
					'name'    => 'Import Posts',
					'data'    => 'content/posts-medical',
					'checked' => true,
				),
			),
			'link'      => 'http://seventhqueen.com/themes/kleo/medical/',
		);
		$pages_data['home-company'] = array(
			'name'    => 'Home Company (v4.0)',
			'slug'    => 'home-company',
			'img'     => $remote_path . 'img/home-company.jpg',
			'page'    => 'pages/home-company',
			'attach'  => 'yes',
			'plugins' => array( 'js_composer', 'k-elements', 'mailchimp-for-wp' ),
			//'revslider' => '',
			'link'    => 'http://seventhqueen.com/themes/kleo/company/',
		);
		$pages_data['home-food']    = array(
			'name'   => 'Home Food (v4.0)',
			'slug'   => 'home-food',
			'img'    => $remote_path . 'img/home-food.jpg',
			'page'   => 'pages/home-food',
			'attach' => 'yes',
			'plugins' => array( 'js_composer', 'k-elements' ),
			//'revslider' => '',
			'link'   => 'http://seventhqueen.com/themes/kleo/food/',
		);

		$pages_data['home-register'] = array(
			'name'   => 'Home Register Landing Page (v4.0)',
			'slug'   => 'home-register',
			'img'    => $remote_path . 'img/home-register.jpg',
			'page'   => 'pages/home-register',
			'attach' => 'yes',
			'plugins' => array( 'js_composer', 'k-elements' ),
			//'revslider' => '',
			'link'   => 'http://seventhqueen.com/themes/kleo/home-register/',
		);

		$pages_data['home-community']              = array(
			'name'             => 'Home Default(Community)',
			'slug'             => 'home-community',
			'img'              => $remote_path . 'img/home-community.jpg',
			'page'             => 'pages/home-community',
			//'attach' => 'yes',
			'widgets'          => 'widget_data',
			'widgets_sidebars' => true,
			'plugins'          => array( 'js_composer', 'k-elements', 'revslider', 'buddypress' ),
			'revslider'        => 'HomeFullwidth',
			'extra'            => array(
				array(
					'id'      => 'menu',
					'name'    => 'Import Menu',
					'slug'    => 'kleonavmenu',
					'data'    => 'content/menu-community',
					'checked' => true,
				),
				array(
					'id'      => 'clients',
					'data'    => 'content/clients',
					'name'    => 'Import Clients',
					'checked' => true,
				),
			),
			'link'             => 'http://seventhqueen.com/themes/kleo/home-default/',
		);
		$pages_data['home-pinterest']              = array(
			'name'  => 'Home Pinterest',
			'slug'  => 'home-pinterest',
			'img'   => $remote_path . 'img/home-pinterest.jpg',
			'page'  => 'pages/home-pinterest',
			//'attach' => 'yes',
			'plugins'          => array( 'js_composer', 'k-elements' ),
			//'revslider' => '',
			'extra' => array(
				array(
					'id'      => 'posts',
					'data'    => 'content/posts',
					'name'    => 'Import Posts',
					'checked' => true,
				),
			),
			'link'  => 'http://seventhqueen.com/themes/kleo/pinterest/',
		);
		$pages_data['home-news-magazine']          = array(
			'name'      => 'Home News Magazine',
			'slug'      => 'news-magazine',
			'img'       => $remote_path . 'img/home-news-magazine.jpg',
			'page'      => 'pages/home-news-magazine',
			'extra'     => array(
				array(
					'id'      => 'menu',
					'name'    => 'Import Menu',
					'slug'    => 'kleonavmenu',
					'data'    => 'content/menu-community',
					'checked' => true,
				),
			),
			'attach'    => 'yes',
			'plugins'   => array( 'js_composer', 'k-elements', 'revslider' ),
			'revslider' => 'news-magazine',
			'link'      => 'http://seventhqueen.com/themes/kleo/news-magazine/',
		);
		$pages_data['home-material']               = array(
			'name'      => 'Home Material Design',
			'slug'      => 'home-material-design',
			'img'       => $remote_path . 'img/home-material-design.jpg',
			'page'      => 'pages/home-material',
			'attach'    => 'yes',
			'extra'     => array(
				array(
					'id'      => 'testimonials',
					'data'    => 'content/testimonials',
					'name'    => 'Import Dummy Testimonials',
					'checked' => true,
				),
			),
			'plugins'   => array( 'js_composer', 'k-elements', 'revslider' ),
			'revslider' => 'material-design',
			'options'   => 'home-material-design',
			'link'      => 'http://seventhqueen.com/themes/kleo/material-design-colors/',
		);
		$pages_data['home-get-connected']          = array(
			'name'       => 'Home Get Connected',
			'slug'       => 'get-connected',
			'img'        => $remote_path . 'img/home-get-connected.jpg',
			'page'       => 'pages/home-get-connected',
			'attach'     => 'yes',
			'plugins'    => array( 'js_composer', 'k-elements', 'buddypress', 'bp-profile-search' ),
			'bp_fields'  => $connected_fields,
			'post_types' => array( 'bps_form' ),
			//'revslider' => '',
			//'details' => '',
			'link'       => 'http://seventhqueen.com/themes/kleo/get-connected',
		);
		$pages_data['home-get-connected-vertical'] = array(
			'name'       => 'Home Get Connected Vertical',
			'slug'       => 'get-connected-vertical-form',
			'img'        => $remote_path . 'img/home-get-connected-vertical.jpg',
			'page'       => 'pages/home-get-connected-vertical',
			'attach'     => 'yes',
			'plugins'    => array( 'js_composer', 'k-elements', 'buddypress', 'bp-profile-search' ),
			'bp_fields'  => $connected_fields,
			'post_types' => array( 'bps_form' ),
			'link'       => 'http://seventhqueen.com/themes/kleo/get-connected-vertical-form/',
		);
		$pages_data['home-product-landing']        = array(
			'name'    => 'Home Product Landing Page',
			'slug'    => 'product-landing-page',
			'img'     => $remote_path . 'img/home-product-landing-page.jpg',
			'page'    => 'pages/home-product-landing',
			'attach'  => 'yes',
			'plugins' => array( 'js_composer', 'k-elements', 'woocommerce' ),
			'link'    => 'http://seventhqueen.com/themes/kleo/product-landing-page/',
		);
		$pages_data['home-mobile-app']             = array(
			'name'      => 'Home Mobile APP',
			'slug'      => 'home-mobile-app',
			'img'       => $remote_path . 'img/home-mobile-app.jpg',
			'page'      => 'pages/home-mobile-app',
			'attach'    => 'yes',
			'plugins'   => array( 'js_composer', 'k-elements', 'revslider' ),
			'revslider' => 'mobile-app',
			'link'      => 'http://seventhqueen.com/themes/kleo/mobile-app/',
		);
		$pages_data['home-resume']                 = array(
			'name'   => 'Home Resume',
			'slug'   => 'home-resume',
			'img'    => $remote_path . 'img/home-resume.jpg',
			'page'   => 'pages/home-resume',
			'attach' => 'yes',
			'plugins'   => array( 'js_composer', 'k-elements' ),
			//'revslider' => 'mobile-app',
			'link'   => 'http://seventhqueen.com/themes/kleo/resume/',
		);
		$pages_data['home-sensei']                 = array(
			'name'      => 'Home Sensei',
			'slug'      => 'home-sensei',
			'img'       => $remote_path . 'img/home-sensei.jpg',
			'page'      => 'pages/home-sensei',
			'attach'    => 'yes',
			'plugins'   => array(  'js_composer', 'k-elements', 'revslider', 'sensei', 'mailchimp-for-wp' ),
			'revslider' => 'elearning_homepage',
			'extra'     => array(
				array(
					'id'      => 'courses',
					'data'    => 'content/sensei',
					'name'    => 'Import Sample Courses, Lessons and Quizzes',
					'checked' => true,
				),
			),
			'details'   => '',
			'link'      => 'http://seventhqueen.com/themes/kleo/sensei-e-learning/',
		);
		$pages_data['home-elearning']              = array(
			'name'      => 'Home e-Learning',
			'slug'      => 'home-e-learning',
			'img'       => $remote_path . 'img/home-elearning.jpg',
			'page'      => 'pages/home-elearning',
			'attach'    => 'yes',
			'plugins'   => array(  'js_composer', 'k-elements', 'revslider', 'mailchimp-for-wp' ),
			'revslider' => 'elearning_homepage',
			'extra'     => array(
				array(
					'id'      => 'posts',
					'data'    => 'content/posts',
					'name'    => 'Import Sample Posts',
					'checked' => true,
				),
				array(
					'id'      => 'testimonials',
					'data'    => 'content/testimonials',
					'name'    => 'Import Sample Testimonials',
					'checked' => true,
				),
			),
			'link'      => 'http://seventhqueen.com/themes/kleo/e-learning-home/',
		);
		$pages_data['home-geodirectory']           = array(
			'name'    => 'Home Geodirectory',
			'slug'    => 'directory',
			'img'     => $remote_path . 'img/home-geodirectory.jpg',
			'page'    => 'pages/home-geodirectory',
			'widgets' => 'widget_data_geodirectory',
			//'attach' => 'yes',
			'plugins' => array( 'geodirectory' ),
			//'revslider' => '',
			'details' => 'Please read the <a target="_blank" href="http://seventhqueen.com/support/documentation/kleo#geo-directory">documentation</a>',
			'link'    => 'http://seventhqueen.com/themes/kleo/business-directory/',
		);
		$pages_data['home-portfolio-full']         = array(
			'name'      => 'Home Portfolio Full-Width',
			'slug'      => 'portfolio-fullwidth-overlay',
			'img'       => $remote_path . 'img/home-portfolio-full.jpg',
			'page'      => 'pages/home-portfolio-full',
			'extra'     => array(
				array(
					'id'      => 'portfolio',
					'data'    => 'content/portfolio',
					'name'    => 'Import Portfolio posts',
					'checked' => true,
				),
			),
			//'widgets' => 'yes',
			//'attach' => 'yes',
			'plugins'   => array(  'js_composer', 'k-elements', 'revslider' ),
			'revslider' => 'HomeFullwidth',
			'link'      => 'http://seventhqueen.com/themes/kleo/portfolio-full-width/',
		);
		$pages_data['home-shop']                   = array(
			'name'             => 'Home Shop',
			'slug'             => 'home-shop',
			'img'              => $remote_path . 'img/home-shop.jpg',
			'page'             => 'pages/home-shop',
			'extra'            => array(
				array(
					'id'   => 'products',
					'data' => 'content/products-dummy',
					'name' => 'Import Dummy Products',
				),
			),
			'widgets'          => 'widget_data',
			'widgets_sidebars' => true,
			'attach'           => 'yes',
			'plugins'          => array( 'js_composer', 'k-elements', 'revslider', 'woocommerce' ),
			'revslider'        => 'HomeFullwidth',
			//'details' => 'Woocommerce plugin required.',
			'link'             => 'http://seventhqueen.com/themes/kleo/default-shop/',
		);
		$pages_data['home-stylish-woo']            = array(
			'name'    => 'Home Stylish Woocommerce',
			'slug'    => 'stylish-woocommerce',
			'img'     => $remote_path . 'img/home-stylish-woo.jpg',
			'page'    => 'pages/home-stylish-woo',
			'extra'   => array(
				array(
					'id'      => 'clients',
					'data'    => 'content/clients',
					'name'    => 'Import Dummy clients',
					'checked' => true,
				),
				array(
					'id'      => 'portfolio',
					'data'    => 'content/portfolio',
					'name'    => 'Import Portfolio posts',
					'checked' => true,
				),
				array(
					'id'      => 'products',
					'data'    => 'content/products-dummy',
					'name'    => 'Import Dummy Products',
					'checked' => true,
				),

			),
			'attach'  => 'yes',
			'plugins' => array( 'js_composer', 'k-elements', 'woocommerce', 'mailchimp-for-wp' ),
			//'details' => '',
			'link'    => 'http://seventhqueen.com/themes/kleo/stylish-woocommerce/',
		);
		$pages_data['home-agency']                 = array(
			'name'      => 'Home Agency',
			'slug'      => 'home-agency',
			'img'       => $remote_path . 'img/home-agency.jpg',
			'page'      => 'all-agency',
			'extra'     => array(
				array(
					'id'      => 'posts',
					'data'    => 'content/posts',
					'name'    => 'Import Sample Posts',
					'checked' => true,
				),
				array(
					'id'      => 'clients',
					'data'    => 'content/clients',
					'name'    => 'Import Dummy clients',
					'checked' => true,
				),
			),
			//'widgets' => 'yes',
			'attach'    => 'yes',
			'plugins'   => array( 'js_composer', 'k-elements', 'revslider', 'mailchimp-for-wp', 'contact-form-7' ),
			'revslider' => array( 'agency-home', 'agency-careers', 'agency-services' ),
			'link'      => 'http://seventhqueen.com/themes/kleo/demo-agency/',
		);
		$pages_data['home-simple']                 = array(
			'name'      => 'Home Simple',
			'slug'      => 'home-simple',
			'img'       => $remote_path . 'img/home-simple.jpg',
			'page'      => 'pages/home-simple',
			'extra'     => array(
				array(
					'id'      => 'clients',
					'data'    => 'content/clients',
					'name'    => 'Import Dummy clients',
					'checked' => true,
				),
				array(
					'id'      => 'menu',
					'name'    => 'Import Menu',
					'slug'    => 'kleonavmenu',
					'data'    => 'content/menu-community',
					'checked' => true,
				),
			),
			//'widgets' => 'yes',
			'attach'    => 'yes',
			'plugins'   => array( 'js_composer', 'k-elements', 'revslider' ),
			'revslider' => 'home-simple',
			'link'      => 'http://seventhqueen.com/themes/kleo/home/',
		);
		$pages_data['home-onepage']                = array(
			'name'      => 'Home OnePage - KLEO demo (v2)',
			'img'       => $remote_path . 'img/home-onepage.jpg',
			'page'      => 'pages/home-onepage',
			'extra'     => array(
				array(
					'id'      => 'menu',
					'slug'    => 'one-page-menu',
					'data'    => 'content/menu-onepage',
					'name'    => 'Import Menu',
					'checked' => true,
				),
			),
			//'widgets' => 'yes',
			'attach'    => 'yes',
			'plugins'   => array( 'js_composer', 'k-elements', 'revslider' ),
			'revslider' => 'lp-home-full-screen',
			'link'      => 'http://seventhqueen.com/themes/kleo/one-page-presentation/',
		);
		$pages_data['home-onepage-v3']             = array(
			'name'      => 'Home OnePage - KLEO demo (v3)',
			'img'       => $remote_path . 'img/rev-onepage-v3.jpg',
			//'page' => 'pages/home-onepage',
			//'widgets' => 'yes',
			//'attach' => 'yes',
			'revslider' => 'landingpage_v3_0_beta',
			'link'      => 'https://seventhqueen.com/themes/kleo/connecting-people-slider/',
			'details'   => 'Just Revslider to import.',
		);


		self::add_demo_sets( $pages_data );
	}

	/**
	 * Add multiple demo sets
	 */
	static function add_demo_sets( $data ) {
		self::$pages_data = self::$pages_data + $data;
	}

	public static function getInstance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Add a demo set
	 */
	static function add_demo_set( $slug, $data ) {
		self::$pages_data[ $slug ] = $data;
	}

	/** ---------------------------------------------------------------------------
	 * Add theme Page
	 * ---------------------------------------------------------------------------- */
	function init() {

		add_theme_page(
			'KLEO Demo Data',
			'KLEO Demo Data',
			'edit_theme_options',
			'kleo_import',
			array( $this, 'import' )
		);

	}

	/** ---------------------------------------------------------------------------
	 * Enqueue scripts
	 * ---------------------------------------------------------------------------- */

	public function import_assets() {
		if ( isset( $_GET['page'] ) && ( 'kleo_import' == $_GET['page'] || 'kleo-panel' == $_GET['page'] ) ) {

			wp_enqueue_script( 'jquery-ui-tooltip' );

			wp_enqueue_style( 'kleo-import-css', KLEO_LIB_URI . '/importer/assets/import.css', array(), KLEO_THEME_VERSION );
			wp_enqueue_script( 'kleo-import-js', KLEO_LIB_URI . '/importer/assets/import.js', array(
				'jquery',
				'jquery-ui-tooltip'
			), KLEO_THEME_VERSION, true );
		}

	}

	public function set_as_homepage() {
		if ( session_id() ) {
			session_write_close();
		}
		check_ajax_referer( 'import_nonce', 'security' );

		if ( ! current_user_can( 'manage_options' ) ) {
			wp_send_json_error( array(
				'message' => __( 'We&apos;re sorry, something went wrong.', 'kleo_framework' ),
			) );
			exit;
		}

		if ( isset( $_POST['pid'] ) ) {
			$post_id = $_POST['pid'];
			if ( get_post_status( $post_id ) == 'publish' ) {
				if ( 'page' == get_post_type( $post_id ) ) {
					update_option( 'page_on_front', $post_id );
					update_option( 'show_on_front', 'page' );
					wp_send_json_success( array(
						'message' => __( 'Successfully set as homepage!', 'kleo_framework' ),
					) );
					exit;
				}
			}
		}
		wp_send_json_success( array(
			'message' => __( 'An error occurred setting the page as home!!!', 'kleo_framework' ),
		) );
		exit;

	}

	function do_ajax() {
		if ( session_id() ) {
			session_write_close();
		}

		check_ajax_referer( 'import_nonce', 'security' );

		if ( ! current_user_can( 'manage_options' ) ) {
			wp_send_json_error( array(
				'message' => $this->set_error_message( __( 'We&apos;re sorry, the demo failed to import.', 'kleo_framework' ) ),
			) );
			exit;
		}

		if ( ! isset( $_POST['options'] ) ) {
			wp_send_json_error( array(
				'message' => $this->set_error_message( __( 'Something went wrong. Please try again.', 'kleo_framework' ) ),
			) );
			exit;
		}

		$data = array();

		parse_str( $_POST['options'], $data );

		if ( ! isset( $data['import_demo'] ) ) {
			wp_send_json_error( array(
				'message' => $this->set_error_message( __( 'Something went wrong with the data sent. Please try again.', 'kleo_framework' ) ),
			) );
			exit;
		}

		$demo_sets   = self::get_demo_sets();
		$current_set = $data['import_demo'];

		if ( ! array_key_exists( $current_set, $demo_sets ) ) {
			wp_send_json_error( array(
				'message' => $this->set_error_message( __( 'Something went wrong with the data sent. Please try again.', 'kleo_framework' ) ),
			) );
			exit;
		}

		$set_data     = $demo_sets[ $current_set ];
		$progress_pid = intval( $_POST['pid'] );

		/* if we are checking progress */
		if ( isset( $_POST['check_progress'] ) ) {
			$progress = $this->get_progress( $progress_pid );
			if ( $progress ) {

				/* Some fix for Revslider error on install */
				$plugin = 'revslider';
				if ( isset( $progress[ $plugin ] ) ) {
					if ( in_array( $plugin, $progress['plugins'] ) ) {
						if ( ! class_exists( 'SQ_Addons_Manager' ) ) {
							require_once( KLEO_PANEL_DIR . '/class-addons-manager.php' );
						}

						if (  SQ_Addons_Manager()->is_plugin_installed( $plugin ) &&
						      ! SQ_Addons_Manager()->is_plugin_active( $plugin )) {

							SQ_Addons_Manager()->do_plugin_activate( $plugin, false );
						}
					}
				}

				wp_send_json_success( array(
					'message'  => $progress['text'],
					'progress' => $progress['progress'],
				) );
			}
			exit;
		}

		$response = $this->process_import( array(
			'set_data' => $set_data,
			'pid'      => $progress_pid,
			'data'     => $data,
		) );

		if ( is_wp_error( $response ) ) {
			wp_send_json_error( array(
				'message' => $this->set_error_message(
					__( 'There was an error in the import process. Try to do the import once again!', 'kleo_framework' ) .
					'<br>' . $response->get_error_message()
				),
				'debug'   => implode( ',', $this->messages ),
			) );
			exit;
		}

		/* make sure we are regenerating theme dynamic file */
		kleo_write_dynamic_css_file();

		$response['debug']   = implode( ',', $this->messages );
		$response['message'] = $this->set_success_message( $response['message'] );

		wp_send_json_success( $response );

	}

	private function set_error_message( $msg ) {
		$header = '<div class="bg-msg fail-msg"><span class="dashicons dashicons-warning"></span></div>';

		return $header . $msg;
	}

	/**
	 * Retrieve the demo sets
	 */
	static function get_demo_sets() {
		return self::$pages_data;
	}

	public function get_progress( $pid ) {
		$data = get_transient( 'sq_import_' . floatval( $pid ) );

		return $data;
	}

	/**
	 * Process all the import steps
	 *
	 * @param array $options
	 *
	 * @return array|WP_Error
	 */
	public function process_import( $options ) {

		$imported         = false;
		$content_imported = false;

		$set_data           = $options['set_data'];
		$progress_pid       = $options['pid'];
		$this->progress_pid = $progress_pid;
		$data               = $options['data'];

		// Importer classes
		if ( ! defined( 'WP_LOAD_IMPORTERS' ) ) {
			define( 'WP_LOAD_IMPORTERS', true );
		}

		if ( ! class_exists( 'WP_Importer' ) ) {
			require_once ABSPATH . 'wp-admin/includes/class-wp-importer.php';
		}

		if ( ! class_exists( 'WP_Import' ) ) {
			require_once KLEO_LIB_DIR . '/importer/wordpress-importer.php';
		}

		if ( ! class_exists( 'WP_Importer' ) || ! class_exists( 'WP_Import' ) ) {
			return new WP_Error( '__k__', __( 'Something went wrong. Please try again.', 'kleo_framework' ) );
		}

		$this->processes      = count( $data ) + 1;
		$this->done_processes = 0;

		//activate required plugins
		if ( isset( $data['activate_plugins'] ) ) {

			$this->processes += count( $set_data['plugins'] ) - 1;

			$this->set_progress( $progress_pid, array(
				'text' => 'Activating any required plugins...',
				'plugins' =>  isset( $set_data['plugins'] ) && ! empty( $set_data['plugins'] ) ? $set_data['plugins'] : array(),
			) );

			$this->activate_plugins( $set_data );
			$this->done_processes ++;
		}

		//post type requirements
		$this->set_progress( $progress_pid, array(
			'text' => 'Performing extra import checks...',
		) );
		$this->post_type_check( $set_data );
		$this->done_processes ++;

		//import pages xml
		if ( isset( $data['import_page'] ) && isset( $set_data['page'] ) ) {

			$this->set_progress( $progress_pid, array(
				'text' => 'Importing page and images...',
			) );

			$imported         = true;
			$content_imported = true;

			if ( is_array( $data['import_page'] ) ) {
				$the_page = $data['import_page'][0];
			} else {
				$the_page = $data['import_page'];
			}
			$the_page = ucwords( str_replace( array( '-', '_' ), ' ', $the_page ) );

			$file_path = $set_data['page'] . '.xml.gz';
			$this->import_content( $file_path, true );

			$this->save_main_imported_pages();

			$this->messages[] = sprintf( esc_html__( 'Installed page: %s', 'kleo_framework' ), $the_page );
			$this->done_processes ++;
		}

		//import widgets
		if ( isset( $data['import_widgets'] ) && isset( $set_data['widgets'] ) ) {

			$imported = true;

			$this->set_progress( $progress_pid, array(
				'text' => 'Importing widgets...',
			) );

			$widget_path = $set_data['widgets'];

			if ( isset( $set_data['widgets_sidebars'] ) && $set_data['widgets_sidebars'] ) {
				$this->import_sidebars( KLEO_LIB_URI . '/importer/demo/sidebar_data.txt' );
			}

			//widgets
			$file_path = KLEO_LIB_DIR . '/importer/demo/' . $widget_path . '.txt';
			if ( file_exists( $file_path ) ) {
				$file_data = sq_fs_get_contents( $file_path );
				if ( $file_data ) {
					$this->import_widget_data( $file_data );

					$this->messages[] = esc_html__( 'Imported widgets', 'kleo_framework' );
				}
			}
			$this->done_processes ++;
		}

		//check options
		if ( isset( $data['import_options'] ) && isset( $set_data['options'] ) ) {

			$imported = true;

			$this->set_progress( $progress_pid, array(
				'text' => esc_html__( 'Importing Theme Options...', 'kleo_framework' ),
			) );

			$this->import_options( $set_data['options'] );

			$this->messages[] = esc_html__( 'Imported Theme options', 'kleo_framework' );
			$this->done_processes ++;
		}

		//check revslider
		if ( isset( $data['import_revslider'] ) && isset( $set_data['revslider'] ) ) {

			$imported = true;

			$this->set_progress( $progress_pid, array(
				'text' => 'Importing Revolution slider...',
			) );

			global $kleo_config;
			$file_path = $kleo_config['upload_basedir'] . '/slider_imports';
			$sliders   = (array) $set_data['revslider'];
			if ( ! empty( $sliders ) ) {
				foreach ( $sliders as $file_name ) {
					/* if a slider doesn't already exist */
					if ( $this->check_existing_slider( $file_name ) ) {

						/* Download the file and import it */
						if ( $this->check_revslider_file( $file_path, $file_name . '.zip' ) ) {
							//file name provided without extension
							$this->import_revslider( $file_path, $file_name );
							$this->messages[] = sprintf( esc_html__( 'Imported Revslider %s', 'kleo_framework' ), $file_name );
						}
					}
				}
			}
			$this->done_processes ++;
		}

		//check extra
		if ( isset( $set_data['extra'] ) && is_array( $set_data['extra'] ) ) {

			foreach ( $set_data['extra'] as $extra ) {
				if ( ! isset( $data[ 'import_' . $extra['id'] ] ) || ! isset( $extra['id'] ) ) {
					continue;
				}
				$imported = true;

				if ( 'menu' != $extra['id'] ) {
					$content_imported = true;
				}

				$this->set_progress( $progress_pid, array(
					'text' => 'Importing ' . ucfirst( $extra['id'] ) . '...',
				) );

				$ok_to_import = true;
				if ( 'menu' == $extra['id'] ) {
					if ( isset( $extra['slug'] ) && is_nav_menu( $extra['slug'] ) ) {
						$ok_to_import = false;
					}
				}
				if ( $ok_to_import ) {
					$file_path = $extra['data'] . '.xml.gz';
					$this->import_content( $file_path, true );
					$this->messages[] = sprintf( esc_html__( '%s complete', 'kleo_framework' ), $extra['name'] );
				}

				if ( 'menu' == $extra['id'] ) {
					$this->import_menu_location();
				}


				$this->done_processes ++;
			}
		}

		//check bp profile fields
		if ( isset( $data['import_bp_fields'] ) && isset( $set_data['bp_fields'] ) ) {

			$imported = true;

			$this->set_progress( $progress_pid, array(
				'text' => 'Importing BuddyPress profile fields',
			) );

			$this->import_bp_fields( $set_data['bp_fields'] );
			$this->messages[] = esc_html__( 'Imported BuddyPress profile fields', 'kleo_framework' );
			$this->done_processes ++;
		}

		//replace imported image URLs with self hosted images
		if ( $content_imported ) {
			$this->processes ++;
			$this->post_process_posts();
			$this->done_processes ++;
		}

		$success_message = '<h3>' . __( 'Awesome. Your import is ready!!!', 'kleo_framework' ) . '</h3>';

		$posts_summary = '';
		if ( ! empty( $this->posts_imported ) ) {
			$this->posts_imported = array_reverse( $this->posts_imported, true );
			foreach ( $this->posts_imported as $pid => $item ) {
				$posts_summary .= get_the_title( $pid );
				$posts_summary .= '<a href="#" title="' . __( 'Set as HomePage', 'kleo_framework' ) . '" class="sq-set-as-home" data-pid="' . $pid . '">' .
				                  '<span class="dashicons dashicons-admin-home"></span> ' .
				                  '</a>' .
				                  '<a target="_blank" href="' . get_permalink( $pid ) . '" title="' . esc_html__( 'View Page', 'kleo_framework' ) . '">' .
				                  '<span class="dashicons dashicons-visibility"></span>' .
				                  '</a>' .
				                  '<a target="_blank" title="' . esc_html__( 'Edit Page', 'kleo_framework' ) . '" href="' . get_admin_url( null, 'post.php?post=' . $pid . '&action=edit' ) . '">' .
				                  '<span class="dashicons dashicons-edit"></span>' .
				                  '</a><br><br>' .
				                  '<span class="dashicons dashicons-video-alt3"></span> ' .
				                  '<a target="_blank" href="https://www.youtube.com/watch?v=wa6Rn5GSGXI">' . __('KLEO Setup Tutorial', 'kleo_framework') . '</a>' .
				                  '&nbsp;&nbsp;<span class="dashicons dashicons-video-alt3"></span> ' .
				                  '<a target="_blank" href="https://www.youtube.com/watch?v=aiTIrxGT4Dk">' . __('WPBakery Builder', 'kleo_framework') . '</a>';
			}
		} else {
			if ( isset( $data['import_page'] ) ) {
				$success_message = esc_html__( 'Your selected page already exists. Please check also Trash!', 'kleo_framework' );
			}
		}

		if ( $posts_summary ) {
			$success_message .= '<p class="import-summary">' .
			                    __( 'Imported Pages:', 'kleo_framework' ) . '<br>' .
			                    $posts_summary .
			                    '</p>';
		}

		if ( ! $imported ) {
			$this->error .= __( 'Nothing was selected for import!!!', 'kleo_framework' );
		}

		//sleep( 30 ); exit( 'I slept a bit. Sorry master!!!' );

		if ( '' == $this->error ) {
			return array(
				'message' => $success_message,
			);
		} else {
			return new WP_Error( '__k__', $this->error );
		}
	}

	public function set_progress( $pid, $data ) {
		if ( $pid ) {
			if ( ! isset( $data['progress'] ) ) {
				if ( 0 == $this->done_processes ) {
					$data['progress'] = 1;
				} else {
					$data['progress'] = floor( $this->done_processes / $this->processes * 100 );
				}
			}
			set_transient( 'sq_import_' . floatval( $pid ), $data, 60 * 60 );
		}
	}

	public function activate_plugins( $set_data ) {
		if ( isset( $set_data['plugins'] ) && ! empty( $set_data['plugins'] ) ) {
			foreach ( $set_data['plugins'] as $plugin ) {
				if ( ! class_exists( 'SQ_Addons_Manager' ) ) {
					require_once( KLEO_PANEL_DIR . '/class-addons-manager.php' );
				}
				$msg = '';
				$plugin_nice_name = ucfirst( str_replace( array( '_','-' ), ' ', $plugin ) );

				$this->set_progress( $this->progress_pid, array(
					'text' => sprintf( esc_html__( 'Installing plugin: %s', 'kleo_framework' ), $plugin_nice_name ),
					'plugins' => $set_data['plugins'],
				) );

				if ( ! SQ_Addons_Manager()->is_plugin_installed( $plugin ) ) {
					$install = SQ_Addons_Manager()->do_plugin_install( $plugin, false );
					if ( isset( $install['error'] ) ) {
						$this->error .= '<br>' . $plugin_nice_name . ': ' . $install['error'];
					}
					$msg = sprintf( esc_html__( 'Installed plugin %s', 'kleo_framework' ), $plugin_nice_name );
					$this->messages[] = $msg;
				}

				if ( ! SQ_Addons_Manager()->is_plugin_active( $plugin ) ) {
					$activate = SQ_Addons_Manager()->do_plugin_activate( $plugin, false );
					if ( isset( $activate['error'] ) ) {
						$this->error .= '<br>' . $plugin_nice_name . ': ' .  $activate['error'];
					}
					$msg = sprintf( esc_html__( 'Activated plugin %s', 'kleo_framework' ), $plugin_nice_name );
					$this->messages[] = $msg;
				}

				if ( $msg ) {
					$this->set_progress( $this->progress_pid, array(
						'text' => $msg,
						'plugins' => $set_data['plugins'],
					) );
				}
				$this->done_processes ++;
			}
		}
	}

	public function post_type_check( $data ) {

		if ( isset( $data['post_types'] ) ) {
			$post_types = $data['post_types'];
		} else {
			return;
		}

		if ( in_array( 'bps_form', $post_types ) && ! post_type_exists( 'bps_form' ) ) {

			$args = array(
				'labels'          => array(
					'name'               => __( 'Profile Search Forms', 'bp-profile-search' ),
					'singular_name'      => __( 'Profile Search Form', 'bp-profile-search' ),
					'all_items'          => __( 'Profile Search', 'bp-profile-search' ),
					'add_new'            => __( 'Add New', 'bp-profile-search' ),
					'add_new_item'       => __( 'Add New Form', 'bp-profile-search' ),
					'edit_item'          => __( 'Edit Form', 'bp-profile-search' ),
					'not_found'          => __( 'No forms found.', 'bp-profile-search' ),
					'not_found_in_trash' => __( 'No forms found in Trash.', 'bp-profile-search' ),
				),
				'show_ui'         => true,
				'show_in_menu'    => 'users.php',
				'supports'        => array( 'title' ),
				'rewrite'         => false,
				'map_meta_cap'    => true,
				'capability_type' => 'bps_form',
				'query_var'       => false,
			);

			register_post_type( 'bps_form', $args );
		}
	}

	/** ---------------------------------------------------------------------------
	 * Import | Content
	 *
	 * @param string $file
	 * @param bool $force_attachments
	 *
	 * ---------------------------------------------------------------------------- */
	function import_content( $file = 'all.xml.gz', $force_attachments = false ) {
		$import = new WP_Import();
		$xml    = KLEO_LIB_DIR . '/importer/demo/' . $file;
		//print_r($xml);

		if ( true == $force_attachments ) {
			$import->fetch_attachments = true;
		} else {
			$import->fetch_attachments = ( $_POST && array_key_exists( 'attachments', $_POST ) && $_POST['attachments'] ) ? true : false;
		}

		ob_start();
		$import->import( $xml );
		ob_end_clean();
	}

	function import_sidebars( $path ) {
		//add any extra sidebars
		$sidebars_file_data = wp_remote_get( $path );
		if ( ! is_wp_error( $sidebars_file_data ) ) {
			$sidebars_data = unserialize( wp_remote_retrieve_body( $sidebars_file_data ) );
			$old_sidebars  = get_option( 'sbg_sidebars' );
			if ( ! empty( $old_sidebars ) ) {
				$sidebars_data = array_merge( $sidebars_data, $old_sidebars );
			}
			update_option( 'sbg_sidebars', $sidebars_data );
		}
	}

	/** ---------------------------------------------------------------------------
	 * Parse JSON import file
	 *
	 * @param $json_data
	 * http://wordpress.org/plugins/widget-settings-importexport/
	 * ---------------------------------------------------------------------------- */
	function import_widget_data( $json_data ) {

		$json_data    = json_decode( $json_data, true );
		$sidebar_data = $json_data[0];
		$widget_data  = $json_data[1];

		// prepare widgets table
		$widgets = array();
		foreach ( $widget_data as $k_w => $widget_type ) {
			if ( $k_w ) {
				$widgets[ $k_w ] = array();
				foreach ( $widget_type as $k_wt => $widget ) {
					if ( is_int( $k_wt ) ) {
						$widgets[ $k_w ][ $k_wt ] = 1;
					}
				}
			}
		}
		//print_r($widgets);

		// sidebars
		foreach ( $sidebar_data as $title => $sidebar ) {
			$count = count( $sidebar );
			for ( $i = 0; $i < $count; $i ++ ) {
				$widget               = array();
				$widget['type']       = trim( substr( $sidebar[ $i ], 0, strrpos( $sidebar[ $i ], '-' ) ) );
				$widget['type-index'] = trim( substr( $sidebar[ $i ], strrpos( $sidebar[ $i ], '-' ) + 1 ) );
				if ( ! isset( $widgets[ $widget['type'] ][ $widget['type-index'] ] ) ) {
					unset( $sidebar_data[ $title ][ $i ] );
				}
			}
			$sidebar_data[ $title ] = array_values( $sidebar_data[ $title ] );
		}

		// widgets
		foreach ( $widgets as $widget_title => $widget_value ) {
			foreach ( $widget_value as $widget_key => $widget_value ) {
				$widgets[ $widget_title ][ $widget_key ] = $widget_data[ $widget_title ][ $widget_key ];
			}
		}

		$sidebar_data = array( array_filter( $sidebar_data ), $widgets );
		$this->parse_import_data( $sidebar_data );
	}

	/** ---------------------------------------------------------------------------
	 * Import widgets
	 * http://wordpress.org/plugins/widget-settings-importexport/
	 * ---------------------------------------------------------------------------- */
	function parse_import_data( $import_array ) {
		$sidebars_data = $import_array[0];
		$widget_data   = $import_array[1];

		$current_sidebars = get_option( 'sidebars_widgets' );
		$new_widgets      = array();

		foreach ( $sidebars_data as $import_sidebar => $import_widgets ) :

			$current_sidebars[ $import_sidebar ] = array();

			foreach ( $import_widgets as $import_widget ) :
				//if the sidebar exists
				if ( isset( $current_sidebars[ $import_sidebar ] ) ) :

					$title               = trim( substr( $import_widget, 0, strrpos( $import_widget, '-' ) ) );
					$index               = trim( substr( $import_widget, strrpos( $import_widget, '-' ) + 1 ) );
					$current_widget_data = get_option( 'widget_' . $title );
					$new_widget_name     = self::get_new_widget_name( $title, $index );
					$new_index           = trim( substr( $new_widget_name, strrpos( $new_widget_name, '-' ) + 1 ) );
					if ( ! empty( $new_widgets[ $title ] ) && is_array( $new_widgets[ $title ] ) ) {
						while ( array_key_exists( $new_index, $new_widgets[ $title ] ) ) {
							$new_index ++;
						}
					}
					if (! $current_widget_data ) {
						$current_widget_data = array();
					}

					$current_sidebars[ $import_sidebar ][] = $title . '-' . $new_index;
					if ( array_key_exists( $title, $new_widgets ) ) {
						$new_widgets[ $title ][ $new_index ] = $widget_data[ $title ][ $index ];
						$multiwidget                         = $new_widgets[ $title ]['_multiwidget'];
						unset( $new_widgets[ $title ]['_multiwidget'] );
						$new_widgets[ $title ]['_multiwidget'] = $multiwidget;
					} else {
						$current_widget_data[ $new_index ] = $widget_data[ $title ][ $index ];
						$current_multiwidget               = isset( $current_widget_data['_multiwidget'] ) ? $current_widget_data['_multiwidget'] : '';
						$new_multiwidget                   = isset( $widget_data[ $title ]['_multiwidget'] ) ? $widget_data[ $title ]['_multiwidget'] : false;
						$multiwidget                       = ( $current_multiwidget != $new_multiwidget ) ? $current_multiwidget : 1;
						unset( $current_widget_data['_multiwidget'] );
						$current_widget_data['_multiwidget'] = $multiwidget;
						$new_widgets[ $title ]               = $current_widget_data;
					}
				endif;
			endforeach;
		endforeach;
		if ( isset( $new_widgets ) && isset( $current_sidebars ) ) {
			update_option( 'sidebars_widgets', $current_sidebars );
			foreach ( $new_widgets as $title => $content ) {
				$content = apply_filters( 'widget_data_import', $content, $title );
				update_option( 'widget_' . $title, $content );
			}

			return true;
		}

		return false;
	}

	/** ---------------------------------------------------------------------------
	 * Get new widget name
	 * http://wordpress.org/plugins/widget-settings-importexport/
	 * ---------------------------------------------------------------------------- */
	function get_new_widget_name( $widget_name, $widget_index ) {
		$current_sidebars = get_option( 'sidebars_widgets' );
		$all_widget_array = array();
		foreach ( $current_sidebars as $sidebar => $widgets ) {
			if ( ! empty( $widgets ) && is_array( $widgets ) && $sidebar != 'wp_inactive_widgets' ) {
				foreach ( $widgets as $widget ) {
					$all_widget_array[] = $widget;
				}
			}
		}
		while ( in_array( $widget_name . '-' . $widget_index, $all_widget_array ) ) {
			$widget_index ++;
		}
		$new_widget_name = $widget_name . '-' . $widget_index;

		return $new_widget_name;
	}

	/**
	 * Import theme options
	 *
	 * @param string $file
	 */
	function import_options( $file = '' ) {
		if ( '' == $file ) {
			return;
		}

		$file_path = KLEO_LIB_DIR . '/importer/demo/options/' . $file . '.txt';
		$file_data = sq_fs_get_contents( $file_path );
		$options   = get_option( 'kleo_' . KLEO_DOMAIN );
		if ( $file_data ) {
			if ( $data = json_decode( $file_data, true ) ) {

				foreach ( $data as $k => $v ) {
					$options[ $k ] = $v;
				}
				$options['stime'] = time();
				update_option( 'kleo_' . KLEO_DOMAIN, $options );

				kleo_write_dynamic_css_file();

			}
		}

	}

	/**
	 * Check if a Revslider with the given name exists
	 *
	 * @param string $name
	 *
	 * @return bool
	 */
	public function check_existing_slider( $name ) {

		if ( ! class_exists( 'RevSlider' ) ) {
			$this->error = 'Please activate Revolution slider and do the import again!';

			return false;
		}
		$revslider = new RevSlider();
		$sliders   = $revslider->getArrSliders();

		foreach ( $sliders as $slider ) {
			if ( $name == $slider->getAlias() ) {
				return false;
			}
		}

		return true;
	}

	public function check_revslider_file( $file_path, $file_name ) {

		$file_final_path = trailingslashit( $file_path ) . $file_name;

		if ( ! file_exists( $file_final_path ) || 0 < filesize( $file_final_path ) ) {

			if ( ! is_dir( $file_path ) ) {
				wp_mkdir_p( $file_path );
			}

			// Get remote file
			$response = wp_remote_get( 'http://seventhqueen.com' . '/support/files/kleo/revslider/' . $file_name );

			// Check for error
			if ( is_wp_error( $response ) ) {
				$this->error = 'Revolution slider could not be imported. Import manually from WP admin - Revolution Slider';
				$this->error .= '<br><small>Details: ' . $response->get_error_code() . '</small>';

				return false;
			}

			// Parse remote HTML file
			$file_contents = wp_remote_retrieve_body( $response );

			// Check for error
			if ( is_wp_error( $file_contents ) ) {
				$this->error = 'Revolution slider could not be imported. Import manually from WP admin - Revolution Slider';

				return false;
			}

			if ( ! sq_fs_put_contents( $file_final_path, $file_contents ) ) {
				$this->error = 'Revolution slider could not be written to disk. Check file permissions with hosting provider. Import manually from WP admin - Revolution Slider';

				return false;
			}
		}

		return true;
	}

	/** ---------------------------------------------------------------------------
	 * Import | RevSlider
	 *
	 * @param string $path
	 * @param string $name
	 * ---------------------------------------------------------------------------- */
	function import_revslider( $path, $name = '' ) {

		if ( class_exists( 'RevSlider' ) ) {

			ob_start();
			//filename provided without extension
			$full_path = trailingslashit( $path ) . $name . '.zip';

			if ( $this->check_existing_slider( $name ) && file_exists( $full_path ) ) {
				$slider = new RevSlider();
				$slider->importSliderFromPost( true, true, $full_path );
			}
			$this->messages[] = ob_get_clean();
		}

	}

	public function import_bp_fields( $bp_fields, $extra_replace = true ) {
		if ( ! function_exists( 'bp_is_active' ) || ! bp_is_active( 'xprofile' ) ) {
			return;
		}

		$imported_ids = array();
		$existing_ids = array();
		$i            = 0;
		foreach ( $bp_fields as $field ) {

			$i ++;
			if ( ! $existing_ids[] = xprofile_get_field_id_from_name( $field['name'] ) ) {
				$id             = xprofile_insert_field(
					array(
						'field_group_id' => 1,
						'name'           => $field['name'],
						'can_delete'     => $field['can_delete'],
						'field_order'    => $i,
						'is_required'    => $field['is_required'],
						'type'           => $field['type'],
					)
				);
				$imported_ids[] = $id;

				if ( $id && isset( $field['options'] ) && ! empty( $field['options'] ) ) {
					$j = 0;
					foreach ( $field['options'] as $option ) {
						$j ++;
						xprofile_insert_field( array(
							'field_group_id' => 1,
							'parent_id'      => $id,
							'type'           => $field['type'],
							'name'           => $option,
							'option_order'   => $j,
						) );
					}
				}
			}
		}

		if ( $extra_replace ) {

			$ids = array_merge( $imported_ids, $existing_ids );
			$this->replace_bps_data( $ids, 'Main page form' );

		}


	}

	public function replace_bps_data( $ids, $page_title ) {
		if ( ! empty( $ids ) ) {

			$field_code = array();
			foreach ( $ids as $id ) {
				$field_code[] = 'field_' . $id;
			}

			//Main page form
			//bps_form
			$args  = array(
				'post_type'  => 'bps_form',
				'title'      => $page_title,
				'meta_key'   => 'sq_import',
				'meta_value' => '1',
			);
			$query = new WP_Query( $args );
			$posts = $query->posts;

			if ( ! empty( $posts ) && is_array( $posts ) ) {
				foreach ( $posts as $post ) {

					$form_values = get_post_meta( $post->ID, 'bps_options' );
					foreach ( $form_values as $form_value ) {
						if ( isset( $form_value['field_name'] ) ) {
							$new_option_value               = $form_value;
							$new_option_value['field_name'] = $ids;
							$new_option_value['field_code'] = $field_code;

							delete_post_meta( $post->ID, 'bps_options' );
							update_post_meta( $post->ID, 'bps_options', $new_option_value );

							update_post_meta( $post->ID, '_sq_imported', '1' );

							break;
						}
					}
				}
			}


			/* Restore original Post Data */
			wp_reset_postdata();
		}
	}

	private function get_imported_posts() {
		$args  = array(
			'post_type'  => array( 'post', 'page', 'portfolio', 'kleo-testimonials', 'kleo_clients' ),
			'meta_query' => array(
				array(
					'key'   => 'sq_import',
					'value' => '1',
				),
				array(
					'key'     => '_sq_imported',
					'compare' => 'NOT EXISTS',
				),
			),
		);
		$query = new WP_Query( $args );

		return $query->posts;
	}

	private function save_main_imported_pages() {
		$posts = $this->get_imported_posts();
		foreach ( $posts as $post ) {

			//save the imported page
			if ( 'page' == get_post_type( $post->ID ) ) {
				$this->posts_imported[ $post->ID ] = $post;
			}
		}
	}

	private function post_process_posts() {

		$upload_dir = wp_upload_dir();
		if ( is_ssl() ) {
			if ( strpos( $upload_dir['baseurl'], 'https://' ) === false ) {
				$upload_dir['baseurl'] = str_ireplace( 'http', 'https', $upload_dir['baseurl'] );
			}
		}
		$this->local_url_base = trailingslashit( $upload_dir['baseurl'] );

		$posts = $this->get_imported_posts();

		foreach ( $posts as $post ) {

			$import_base = '';
			/* set import domain */
			if ( get_post_meta( $post->ID, 'sq_base', true ) ) {
				$import_base = get_post_meta( $post->ID, 'sq_base', true );
			}

			//set import remote base
			if ( $import_base ) {
				$this->remote_url_base = trailingslashit( $import_base );
			}

			do_action( 'sq_import_before_process', $post, $this );

			/* Fetch images for import */
			$this->get_images_from_post( $post );

			/* Try to convert VC Grid ids */
			$this->process_vc_grids( $post );

			/* Set Geodirectory homepage to imported page */
			$this->set_geodir_home( $post );

			if ( $featured_image = get_post_meta( $post->ID, '_thumbnail_id', true ) ) {
				$this->featured_images[ $post->ID ] = $featured_image;
			}

			do_action( 'sq_import_after_process', $post, $this );

			add_post_meta( $post->ID, '_sq_imported', 1 );

		}
		/* Restore original Post Data */
		wp_reset_postdata();

		/* Import images from content */
		$this->process_post_images();

		//set featured images
		$this->remap_featured_images();

		//replace any found images
		$this->replace_attachment_urls();

		//delete meta from imported content
		$this->delete_import_data();

		if ( ! empty( $this->image_history ) ) {
			update_option( 'sq_image_history', $this->image_history );
		}
	}

	// return the difference in length between two strings

	public function get_images_from_post( $post ) {

		/* get attached images */
		if ( $attached_images = get_post_meta( $post->ID, 'sq_attach', true ) ) {
			if ( ! empty( $attached_images ) ) {
				$this->attached_images[ $post->ID ] = $attached_images;
				foreach ( $attached_images as $attached_image ) {
					$this->total_images[ md5( $attached_image ) ] = $attached_image;
				}
			}
		}

		$img_data = get_post_meta( $post->ID, 'sq_img_data', true );

		/* Get images from VC single image and VC gallery */
		if ( ! empty( $img_data ) && preg_match_all( '/(images="[0-9,]+")|(include="[0-9,]+")|(image="[0-9]+")/i', $post->post_content, $matches ) ) {

			foreach ( $matches[0] as $match ) {

				//get image links by ids
				$img_id = str_replace( array( 'image="', 'include="', 'images="', '"' ), '', $match );

				if ( isset( $img_data[ $img_id ] ) ) {
					$img_url = $img_data[ $img_id ];


					$img_id_array  = explode( ',', $img_id );
					$img_url_array = explode( ',', $img_url );

					$this->content_images[] = array(
						'post_id'   => $post->ID,
						'id_array'  => $img_id_array,
						'url_array' => $img_url_array,
						'match'     => $match,
						'new_match' => str_replace( $img_id, $img_url, $match ),
					);
					foreach ( $img_url_array as $img_url ) {
						$this->total_images[ md5( $img_url ) ] = $img_url;
					}
				}
			}
		}

		/* Get images from media slider */
		if ( $meta = get_post_meta( $post->ID, '_kleo_slider', true ) ) {

			if ( ! empty( $meta ) ) {
				$this->slide_meta_images[ $post->ID ] = $meta;
				foreach ( $meta as $m ) {
					$this->total_images[ md5( $m ) ] = $m;
				}
			}
		}

		return false;

	}

	public function process_vc_grids( $post ) {
		$grid_data = get_post_meta( $post->ID, 'sq_vc_grids', true );

		/* Get images from VC single image and VC gallery */
		if ( ! empty( $grid_data ) && preg_match_all( '/item="[0-9]+"/i', $post->post_content, $matches ) ) {

			foreach ( $matches[0] as $match ) {

				//get image links by ids
				$grid_id = str_replace( array( 'item="', '"' ), '', $match );
				if ( isset( $grid_data[ $grid_id ] ) ) {
					$grid_name = $grid_data[ $grid_id ];

					if ( $query = $this->get_post_by_slug( $grid_name ) ) {
						$current_grid              = get_post( $query );
						$this->url_remap[ $match ] = 'item="' . $current_grid->ID . '"';
					}
				}
			}
		}
	}

	public function get_post_by_slug( $slug ) {
		global $wpdb;

		return $wpdb->get_var( $wpdb->prepare( "SELECT ID FROM $wpdb->posts WHERE post_name = %s", $slug ) );
	}

	public function set_geodir_home( $post ) {
		if ( $meta = get_post_meta( $post->ID, '_kleo_header_content', true ) ) {
			if ( strpos( $meta, '[gd_homepage_' ) !== false ) {
				update_option( 'geodir_home_page', $post->ID );
			}
		}
	}

	function process_post_images() {

		$old_base_no_http = str_replace( array( 'http://', 'https://' ), '', $this->remote_url_base );

		//attached images
		if ( ! empty( $this->attached_images ) ) {
			foreach ( $this->attached_images as $post_id => $attached_images ) {
				if ( ! empty( $attached_images ) ) {

					foreach ( $attached_images as $k => $v ) {
						$this->remote_images[ $k ] = $v;
						$this->import_image( $v, $post_id );
					}
				}
			}
		}

		//content images
		if ( ! empty( $this->content_images ) ) {

			foreach ( $this->content_images as $content_image ) {
				$post_id       = $content_image['post_id'];
				$img_id_array  = $content_image['id_array'];
				$img_url_array = $content_image['url_array'];
				$match         = $content_image['match'];
				$new_match     = $content_image['new_match'];

				$count = 0;
				foreach ( $img_url_array as $remote_url ) {

					$this->remote_images[ $img_id_array[ $count ] ] = $remote_url;

					$new_image = $this->import_image( $remote_url, $post_id );
					if ( ! empty( $new_image ) && isset( $new_image['id'] ) ) {
						$new_match = str_replace( $remote_url, $new_image['id'], $new_match );
					}

					$count ++;
				}
				$this->url_remap[ $match ] = $new_match;

			}
			//failsafe domain replace
			$this->url_remap[ 'http://' . $old_base_no_http ]  = $this->local_url_base;
			$this->url_remap[ 'https://' . $old_base_no_http ] = $this->local_url_base;
		}

		//Media slider images
		if ( ! empty( $this->slide_meta_images ) ) {
			foreach ( $this->slide_meta_images as $post_id => $slide_meta_image ) {
				$updated = false;
				foreach ( $slide_meta_image as $key => $slide ) {
					$image = $this->import_image( $slide, $post_id );
					if ( ! empty( $image ) && isset( $image['id'] ) ) {
						$slide_meta_image[ $key ] = $image['url'];
						$updated                  = true;
					}
				}
				if ( $updated ) {
					update_post_meta( $post_id, '_kleo_slider', $slide_meta_image );
				}
			}
		}

		return false;
	}

	/**
	 * Import remote image
	 *
	 * @param string $link
	 * @param integer $post_id
	 *
	 * @return string|bool;
	 */
	private function import_image( $link = '', $post_id = null, $add_count = false ) {

		$imported_image = array();
		if ( ! $post_id || '' == $link ) {
			return $imported_image;
		}
		$local_url = $this->remote_to_local_url( $link, $post_id );

		//$this->messages[] = 'Importing image: ' . $link;

		$total_images = count( $this->total_images );
		if ( $total_images > 0 ) {
			$this->set_progress( $this->progress_pid, array(
				'text' => 'Importing Images ' . count( $this->images_imported ) . '/' . $total_images,
			) );
		}

		if ( null == $this->image_history ) {
			$this->image_history = get_option( 'sq_image_history', array() );
		}

		/* Look in imported images history */
		if ( ! empty( $this->image_history ) ) {
			foreach ( $this->image_history as $item ) {
				if ( $link == $item['remote'] ) {
					$local_url = $item['local'];
				}
			}
		}

		if ( $img_id = attachment_url_to_postid( $local_url ) ) {
			$imported_image['id']             = $img_id;
			$imported_image['url']            = $local_url;
			$this->images_imported[ $img_id ] = $link;

			//$this->messages[] = 'Image already uploaded.';

			return $imported_image;
		}

		//if image is not found locally, continue the quest
		require_once( ABSPATH . 'wp-admin/includes/media.php' );
		require_once( ABSPATH . 'wp-admin/includes/file.php' );
		require_once( ABSPATH . 'wp-admin/includes/image.php' );

		$new_image = media_sideload_image( $link, $post_id, null, 'src' );
		if ( ! is_wp_error( $new_image ) ) {

			//$this->messages[] = 'Image just uploaded.';

			$img_id                = attachment_url_to_postid( $new_image );
			$imported_image['id']  = $img_id;
			$imported_image['url'] = $new_image;

			$this->images_imported[ $img_id ]    = $link;
			$this->image_history[ md5( $link ) ] = array(
				'remote' => $link,
				'local'  => $new_image,
			);
			if ( $add_count ) {
				$this->total_images[ md5( $link ) ] = $link;
			}
		} else {
			//$this->messages[] = 'Failed to upload: ' . $new_image->get_error_message();
		}

		return $imported_image;
	}

	public function remote_to_local_url( $url, $post_id ) {
		$remote_base_no_protocol = str_replace( array( 'http://', 'https://' ), '', $this->remote_url_base );
		$url_no_protocol         = str_replace( array( 'http://', 'https://' ), '', $this->local_url_base );

		if ( false !== strpos( $url_no_protocol, $remote_base_no_protocol ) ) {
			$local_url = str_replace( 'https://' . $remote_base_no_protocol, $this->local_url_base, $url );
			$local_url = str_replace( 'http://' . $remote_base_no_protocol, $this->local_url_base, $local_url );
		} else {
			$time = current_time( 'mysql' );
			if ( $post = get_post( $post_id ) ) {
				if ( substr( $post->post_date, 0, 4 ) > 0 ) {
					$time = $post->post_date;
				}
			}
			$uploads   = wp_upload_dir( $time );
			$name      = basename( $url );
			$filename  = wp_unique_filename( $uploads['path'], $name );
			$local_url = $uploads['path'] . "/$filename";
		}

		return $local_url;
	}

	public function remap_featured_images() {
		if ( ! empty( $this->featured_images ) ) {
			foreach ( $this->featured_images as $post_id => $image_id ) {
				if ( isset( $this->remote_images[ $image_id ] ) ) {

					$remote_url = $this->remote_images[ $image_id ];
					$new_image  = $this->import_image( $remote_url, $post_id );
					if ( ! empty( $new_image ) && isset( $new_image['id'] ) ) {
						update_post_meta( $post_id, '_thumbnail_id', $new_image['id'] );
					}
				}
			}
		}
	}

	function replace_attachment_urls() {
		global $wpdb;

		if ( empty( $this->url_remap ) ) {
			return;
		}

		// make sure we do the longest urls first, in case one is a substring of another
		uksort( $this->url_remap, array( $this, 'cmpr_strlen' ) );

		foreach ( $this->url_remap as $from_url => $to_url ) {
			// remap urls in post_content
			$wpdb->query( $wpdb->prepare( "UPDATE {$wpdb->posts} SET post_content = REPLACE(post_content, %s, %s)", $from_url, $to_url ) );
			// remap enclosure urls
			$result = $wpdb->query( $wpdb->prepare( "UPDATE {$wpdb->postmeta} SET meta_value = REPLACE(meta_value, %s, %s) WHERE meta_key='enclosure'", $from_url, $to_url ) );
		}
	}

	/**
	 * Delete post meta required by import logic
	 */
	function delete_import_data() {
		delete_post_meta_by_key( 'sq_img_data' );
		delete_post_meta_by_key( 'sq_attach' );
		delete_post_meta_by_key( 'sq_vc_grids' );
		delete_post_meta_by_key( 'sq_domain' );
		delete_post_meta_by_key( 'sq_base' );
		delete_post_meta_by_key( 'sq_import' );
	}

	private function set_success_message( $msg ) {
		$header = '<div class="bg-msg success-msg"><span class="dashicons dashicons-yes"></span></div>';

		return $header . $msg;
	}

	function cmpr_strlen( $a, $b ) {
		return strlen( $b ) - strlen( $a );
	}

	public function do_import() {
		if ( array_key_exists( 'kleo_import_nonce', $_POST ) ) {

			if ( wp_verify_nonce( $_POST['kleo_import_nonce'], 'import_nonce' ) ) {

				/* DEMO Sets */
				if ( isset( $_POST['import_demo'] ) ) {

					$demo_sets   = self::get_demo_sets();
					$current_set = $_POST['import_demo'];
					$set_data    = $demo_sets[ $current_set ];

					if ( ! array_key_exists( $current_set, $demo_sets ) ) {
						$this->error .= __( 'Something went wrong with the data sent. Please try again.', 'kleo_framework' );
					}

					$data = array();
					foreach ( $_POST as $k => $v ) {
						if ( is_array( $v ) && in_array( $current_set, $v ) ) {
							$data[ $k ][] = $current_set;
						}
					}

					$response = $this->process_import( array(
						'set_data' => $set_data,
						'pid'      => false,
						'data'     => $data,
					) );

					if ( is_wp_error( $response ) ) {
						$this->error .= $response->get_error_message();
					} else {
						$this->data_imported = true;
					}
				} else {

					// Importer classes
					if ( ! defined( 'WP_LOAD_IMPORTERS' ) ) {
						define( 'WP_LOAD_IMPORTERS', true );
					}

					if ( ! class_exists( 'WP_Importer' ) ) {
						require_once ABSPATH . 'wp-admin/includes/class-wp-importer.php';
					}

					if ( ! class_exists( 'WP_Import' ) ) {
						require_once KLEO_LIB_DIR . '/importer/wordpress-importer.php';
					}

					if ( class_exists( 'WP_Importer' ) && class_exists( 'WP_Import' ) ) {
						switch ( $_POST['import'] ) {

							case 'all':
								// Full Demo Data ---------------------------------
								$this->import_content();
								$this->import_menu_location();
								$this->import_widget();

								// set home & blog page
								$home = get_page_by_title( 'Home Default' );
								$blog = get_page_by_title( 'Blog' );
								if ( $home->ID && $blog->ID ) {
									update_option( 'show_on_front', 'page' );
									update_option( 'page_on_front', $home->ID ); // Front Page
									update_option( 'page_for_posts', $blog->ID ); // Blog Page
								}
								break;

							case 'all-geodirectory':
								// Geo Directory Demo Data ---------------------------------
								$this->import_content( 'pages/home-geodirectory.xml.gz' );

								//widgets
								$file_path = KLEO_LIB_URI . '/importer/demo/widget_data_geodirectory.txt';
								$file_data = wp_remote_get( $file_path );
								$data      = $file_data['body'];
								$this->import_widget_data( $data );

								// set home & blog page
								$home = get_page_by_title( 'Home Business Directory' );
								if ( $home->ID && $blog->ID ) {
									update_option( 'show_on_front', 'page' );
									update_option( 'page_on_front', $home->ID ); // Front Page
								}
								break;

							case 'all-agency':
								// Full Agency Demo Data ---------------------------------
								$this->import_content( 'all-agency.xml.gz' );
								//$this->import_menu_location();
								$this->import_widget();

								// set home & blog page
								$home = get_page_by_title( 'Home' );
								$blog = get_page_by_title( 'Blog' );
								if ( $home->ID && $blog->ID ) {
									update_option( 'show_on_front', 'page' );
									update_option( 'page_on_front', $home->ID ); // Front Page
									update_option( 'page_for_posts', $blog->ID ); // Blog Page
								}
								break;

							case 'all-news':
								// Full News Demo Data ---------------------------------
								$this->import_content( 'all-news.xml.gz' );

								// set home & blog page
								$home = get_page_by_title( 'Home News Magazine' );

								if ( $home->ID ) {
									update_option( 'show_on_front', 'page' );
									update_option( 'page_on_front', $home->ID ); // Front Page
								}
								break;

							case 'content':
								if ( $_POST['content'] ) {
									$_POST['content'] = htmlspecialchars( stripslashes( $_POST['content'] ) );
									$file             = 'content/' . $_POST['content'] . '.xml.gz';
									$this->import_content( $file );

									if ( $_POST['content'] == 'pages' ) {
										// set home & blog page
										$home = get_page_by_title( 'Home Default' );
										$blog = get_page_by_title( 'Blog' );
										if ( $home->ID && $blog->ID ) {
											update_option( 'show_on_front', 'page' );
											update_option( 'page_on_front', $home->ID ); // Front Page
											update_option( 'page_for_posts', $blog->ID ); // Blog Page
										}
									}

								} else {
									$this->import_content();
								}
								break;

							case 'page':
								// page ---------------------------------------
								$_POST['page'] = htmlspecialchars( stripslashes( $_POST['page'] ) );
								$file          = 'pages/' . $_POST['page'] . '.xml.gz';
								$this->import_content( $file );
								break;

							case 'menu':
								// Menu -------------------------------------------
								$this->import_content( 'menu.xml.gz' );
								$this->import_menu_location();
								break;

							case 'widgets':
								// Widgets ----------------------------------------
								$this->import_widget();
								break;

							case 'widgets-geodirectory':
								// Widgets ----------------------------------------
								$file_path = KLEO_LIB_URI . '/importer/demo/widget_data_geodirectory.txt';
								$file_data = wp_remote_get( $file_path );
								$data      = $file_data['body'];
								$this->import_widget_data( $data );
								break;

							default:
								// Empty select.import
								$this->error = __( 'Please select data to import.', 'kleo_framework' );
								break;
						}
					}
					$this->data_imported = true;
				}
			}
		}
	}

	/**
	 * Import | Menu - Locations
	 *
	 * @param array $locations Menu locations and names
	 */
	function import_menu_location( $locations = array() ) {

		if ( ! $locations ) {
			$data = array(
				'primary' => 'kleonavmenu',
				'top'     => 'kleotopmenu',
			);
		}
		$menus = wp_get_nav_menus();

		foreach ( $data as $key => $val ) {
			foreach ( $menus as $menu ) {
				if ( $menu->slug == $val ) {
					$data[ $key ] = absint( $menu->term_id );
				}
			}
		}
		set_theme_mod( 'nav_menu_locations', $data );
	}

	/** ---------------------------------------------------------------------------
	 * Import | Widgets
	 * @return bool
	 * ---------------------------------------------------------------------------- */
	function import_widget() {

		//add any extra sidebars
		$this->import_sidebars( KLEO_LIB_URI . '/importer/demo/sidebar_data.txt' );

		//widgets
		$file_path = KLEO_LIB_URI . '/importer/demo/widget_data.txt';
		$file_data = wp_remote_get( $file_path );
		if ( is_wp_error( $file_data ) ) {
			return false;
		}
		$data = wp_remote_retrieve_body( $file_data );
		$this->import_widget_data( $data );

		return true;
	}

	/** ---------------------------------------------------------------------------
	 * Import
	 * ---------------------------------------------------------------------------- */
	function import() {

		$this->show_message();

		?>

		<div id="kleo-wrapper" class="kleo-import wrap">

			<h2><?php echo esc_html( get_admin_page_title() ); ?></h2>


			<h3 style="margin-bottom: 0;">Please read:</h3>
			<p>
				<strong>Not all images are imported</strong> so you need to add your own. See also <a target="_blank"
				                                                                                      href="http://seventhqueen.com/support/documentation/kleo#section-background">Changing
					Section backgrounds</a> documentation.<br>
			</p>


			<form class="kleo-import-form" action="" method="post"
			      onSubmit="if(!confirm('Really import the data?')){return false;}">

				<input type="hidden" name="kleo_import_nonce" value="<?php echo wp_create_nonce( 'import_nonce' ); ?>"/>

				<h3>Import Specific Demo page</h3>

				<?php $this->generate_boxes_html(); ?>

				<div class="clear clearfix"></div>


				<h3>Advanced data import</h3>

				<p>
					<strong>Please note:</strong><br>
					- Don't do the import twice since <strong>it will duplicate all your content</strong>.<br>
					- Importing Widgets will remove any existing widgets assigned to your sidebars.<br>
					- Importing All the demo content will take some time so be patient. A better option is to import by
					content type or just what pages you need.<br>
					- <strong>Revolution Sliders are not imported in this advanced section</strong>. Activate the plugin
					and click Import Slider from <a target="_blank"
					                                href="<?php echo admin_url(); ?>/admin.php?page=revslider">Revolution
						Slider</a>.<br>
					Exported sliders can be found in the package downloaded inside the Demo content folder<br><br>

					<strong>Note on some page demos:</strong><br>
					- News Magazine <br>
					&nbsp;&nbsp;&nbsp;&nbsp; - Import Revolution Slider: news-magazine.zip. <br>
					&nbsp;&nbsp;&nbsp;&nbsp; - Please edit the imported slider template and <strong>choose your post
						categories</strong> for it to work.<br>
					- Get Connected demos &nbsp;>>&nbsp; It requires BP Profile Search plugin<br>
					- Material Design Colors &nbsp;>>&nbsp; We used: Theme options - Styling options - Header - Color
					Preset - Deep Purple/Amber<br>
					- Home Sensei eLearning &nbsp;>>&nbsp; Uses Sensei plugin and MailChimp for WordPress plugin for the
					bottom form.<br>
					- GeoDirectory: Please read the <a target="_blank"
					                                   href="http://seventhqueen.com/support/documentation/kleo#geo-directory">documentation</a>.
				</p>

				<table class="form-table">

					<tr class="row-import">
						<th scope="row">
							<label for="import">Import</label>
						</th>
						<td>
							<select name="import" class="import">
								<option value="">-- Select --</option>
								<option data-attach="yes" value="all">All from Main Demo</option>
								<option data-attach="yes" value="all-agency">All from Agency MultiSite</option>
								<option data-attach="yes" value="all-news">All from News Magazine(Home page + posts)
								</option>
								<option value="all-geodirectory">All from GeoDirectory(Home + widgets)</option>
								<option value="content">By content type</option>
								<option value="page">Specific Page</option>
								<option value="widgets">Widgets</option>
								<option value="widgets-geodirectory">Widgets - Geodirectory</option>
								<option value="menu">Menu</option>
							</select>
						</td>
					</tr>

					<tr class="row-content hide hidden">
						<th scope="row">
							<label for="content">Content</label>
						</th>
						<td>
							<select name="content">
								<option value="">-- All --</option>
								<option data-attach="yes" value="pages">Pages</option>
								<option value="posts">Posts</option>
								<option value="clients">Clients</option>
								<option value="portfolio">Portfolio</option>
								<option value="testimonials">Testimonials</option>
								<option value="products-dummy">Woocommerce Products</option>
							</select>
						</td>
					</tr>

					<tr class="row-homepage hide hidden">
						<th scope="row">
							<label for="page">Homepage</label>
						</th>
						<td>
							<select name="page">
								<option value="home-community">Home Default(Community)</option>
								<option value="home-pinterest">Home Pinterest</option>
								<option data-attach="yes" value="home-news-magazine">Home News Magazine</option>
								<option data-attach="yes" value="home-material">Home Material Design</option>
								<option data-attach="yes" value="home-get-connected">Home Get Connected</option>
								<option data-attach="yes" value="home-get-connected-vertical">Home Get Connected
									Vertical
								</option>
								<option data-attach="yes" value="home-product-landing">Home Product Landing Page
								</option>
								<option data-attach="yes" value="home-mobile-app">Home Mobile App</option>
								<option data-attach="yes" value="home-resume">Home Resume</option>
								<option data-attach="yes" value="home-sensei">Home Sensei e-Learning</option>
								<option value="home-company" data-attach="yes">Home Company(v4.0)</option>
								<option value="home-geodirectory">Home Business Directory</option>
								<option value="home-elearning">Home e-Learning</option>
								<option value="home-portfolio-full">Home Portfolio Full-Width</option>
								<option value="home-shop">Home Shop</option>
								<option value="home-stylish-woo">Home Stylish Woocommerce</option>
								<option value="home-black-friday">Home Black Friday</option>
								<option value="home-onepage">Home One Page Website</option>
								<option value="home-simple">Home Simple</option>
								<option value="home-xmas">Merry Christmas</option>
								<option value="home-new-year">Happy New Year</option>
								<option value="happy-halloween">Happy Halloween</option>
								<option value="spooky-halloween">Spooky Halloween</option>
								<option value="contact-us">Contact us</option>
								<option value="no-breadcrumb">No Breadcrumb Page</option>
								<option value="poi-pins">POIs and Pins</option>
							</select>
						</td>
					</tr>

					<tr class="row-attachments hide hidden">
						<th scope="row">Attachments</th>
						<td>
							<fieldset>
								<label for="attachments"><input type="checkbox" value="1" id="attachments"
								                                name="attachments">Import attachments</label>
								<p class="description">Download all attachments from the demo may take a while. Please
									be patient.</p>
							</fieldset>
						</td>
					</tr>

				</table>

				<input type="submit" name="submit" class="button button-primary advanced" value="Import demo data"/>

			</form>

		</div>
		<?php
	}

	public function show_message() {
		// message box
		if ( $this->error ) {
			echo '<div class="error settings-error">';
			echo '<p><strong>' . $this->error . '</strong></p>';
			echo '</div>';
		} elseif ( $this->data_imported ) {
			echo '<div class="updated settings-error">';
			echo '<p><strong>' . __( 'Import successful. Have fun!', 'kleo_framework' ) . '</strong></p>';
			echo '</div>';
		}
	}

	public function generate_boxes_html() {
		?>
		<div class="demos-wrapper">

			<?php
			$demo_sets = self::get_demo_sets();

			?>

			<?php foreach ( $demo_sets as $k => $v ) : ?>

				<div class="import-demo">
					<div class="demo-wrapper" <?php if ( isset( $v['slug'] ) ) {
						echo 'data-slug="' . $v['slug'] . '"';
					} ?>>
						<?php if ( isset( $v['slug'] ) && $this->get_post_by_slug( $v['slug'] ) ) : ?>
							<div class="sq-imported-label"></div>
						<?php endif; ?>
						<div class="img-wrapper">
							<img src="<?php echo $v['img']; ?>">
							<span class="solid-bg"></span>
							<a href="<?php echo $v['link']; ?>" target="_blank">
								<span class="preview-btn">
									<span
										class="dashicons dashicons-visibility"></span> <?php esc_html_e( 'PREVIEW', 'kleo_framework' ); ?>
								</span>
							</a>
						</div>
						<div class="demo-options">
							<div class="to-left">
								<span class="demo-title"><?php echo $v['name']; ?></span>
								<div class="demo-checkboxes">
									<?php if ( isset( $v['page'] ) ) : ?>
										<label><input type="checkbox" name="import_page[]" checked
										              value="<?php echo $k; ?>"
										              class="check-page"> <?php esc_html_e( 'Import Page', 'kleo_framework' ); ?>
										</label>
										<br>
									<?php endif; ?>

									<?php if ( isset( $v['extra'] ) && ! empty( $v['extra'] ) ) : ?>
										<?php foreach ( $v['extra'] as $extra ) : ?>
											<?php
											if ( isset( $extra['checked'] ) && $extra['checked'] ) {
												$checked = ' checked="checked"';
											} else {
												$checked = '';
											}
											?>
											<label>
												<input type="checkbox" name="import_<?php echo $extra['id']; ?>[]"
												       value="<?php echo $k; ?>"
												       class="check-page"<?php echo $checked; ?>> <?php echo $extra['name']; ?>
											</label>
											<br>
										<?php endforeach; ?>
									<?php endif; ?>

									<?php if ( isset( $v['widgets'] ) ) : ?>
										<label><input type="checkbox" name="import_widgets[]" checked
										              value="<?php echo $k; ?>"> <?php esc_html_e( 'Import Widgets', 'kleo_framework' ); ?>
										</label>
										<br>
									<?php endif; ?>

									<?php if ( isset( $v['revslider'] ) ) : ?>
										<label><input type="checkbox" name="import_revslider[]" checked
										              value="<?php echo $k; ?>"> <?php esc_html_e( 'Import Revolution Slider', 'kleo_framework' ); ?>
										</label>
										<br>
									<?php endif; ?>

									<?php if ( isset( $v['bp_fields'] ) ) : ?>
										<label><input type="checkbox" name="import_bp_fields[]" checked
										              value="<?php echo $k; ?>"> <?php esc_html_e( 'Import Dummy Profile fields', 'kleo_framework' ); ?>
										</label>
										<br>
									<?php endif; ?>

									<?php if ( isset( $v['options'] ) ) : ?>
										<label><input type="checkbox" name="import_options[]" checked
										              value="<?php echo $v['options']; ?>"> <?php esc_html_e( 'Import Theme options', 'kleo_framework' ); ?>
										</label>
										<?php
										$extra_options_data = esc_html__( 'This will change some of your theme options. Make sure to export them first.', 'kleo_framework' );
										echo ' <span class="dashicons dashicons-editor-help tooltip-me" title="' . $extra_options_data . '"></span>';
										?>
										<br>
									<?php endif; ?>

									<?php if ( isset( $v['plugins'] ) && ! empty( $v['plugins'] ) ) : ?>
										<label>
											<input type="checkbox" name="activate_plugins[]" checked
											       value="<?php echo $k; ?>">
											<?php echo esc_html__( 'Activate required plugins', 'kleo_framework' ); ?>
										</label>
										<?php
										$extra_plugin_data = ucwords( str_replace( '-', ' ', implode( ', ', $v['plugins'] ) ) );
										echo ' <span class="dashicons dashicons-editor-help tooltip-me" title="' . $extra_plugin_data . '"></span>';
										?>
										<br>
									<?php endif; ?>

									<?php
									$extra_data = isset( $v['details'] ) ? $v['details'] : '';
									if ( '' != $extra_data ) : ?>
										<span class="demo-detail">Extra notes: <?php echo $extra_data; ?></span>
									<?php endif; ?>
									<br>
									<small>It is recommended to leave all options checked to reproduce our demo.</small>
									<br>
								</div>
							</div>
							<button type="submit" name="import_demo" value="<?php echo $k; ?>"
							        class="button button-primary import-demo-btn">Import
							</button>
							<div class="clear clearfix"></div>
						</div>
					</div>
				</div>

			<?php endforeach; ?>

		</div>
		<?php
	}

}

kleoImport::getInstance();
