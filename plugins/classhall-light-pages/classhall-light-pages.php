<?php
/**
 * Plugin Name: Classhall Light Pages
 * Description: Lightweight shortcode-based page sections to replace simple Elementor pages.
 * Version: 1.0.6
 * Author: Classhall
 * Text Domain: classhall-light-pages
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

final class Classhall_Light_Pages {
    const VERSION = '1.0.6';

    private static $instance = null;

    public static function instance() {
        if ( null === self::$instance ) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    private function __construct() {
        add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_assets' ) );
        add_filter( 'the_content', array( $this, 'maybe_render_elementor_content' ), 8 );

        add_shortcode( 'ch_page', array( $this, 'page' ) );
        add_shortcode( 'ch_hero', array( $this, 'hero' ) );
        add_shortcode( 'ch_section', array( $this, 'section' ) );
        add_shortcode( 'ch_grid', array( $this, 'grid' ) );
        add_shortcode( 'ch_card', array( $this, 'card' ) );
        add_shortcode( 'ch_button', array( $this, 'button' ) );
        add_shortcode( 'ch_features', array( $this, 'features' ) );
        add_shortcode( 'ch_feature', array( $this, 'feature' ) );
        add_shortcode( 'ch_cta', array( $this, 'cta' ) );
        add_shortcode( 'ch_pricing', array( $this, 'pricing' ) );
        add_shortcode( 'ch_price', array( $this, 'price' ) );
        add_shortcode( 'ch_faq', array( $this, 'faq' ) );
        add_shortcode( 'ch_question', array( $this, 'question' ) );
        add_shortcode( 'ch_subjects', array( $this, 'subjects' ) );
        add_shortcode( 'ch_elementor_page', array( $this, 'elementor_page' ) );
    }

    public function enqueue_assets() {
        if ( is_admin() || ! is_singular() ) {
            return;
        }

        $post = get_post();

        if ( ! $post ) {
            return;
        }

        $has_light_shortcodes = $this->content_has_classhall_shortcodes( $post->post_content );
        $needs_elementor_lite = $this->post_has_elementor_data( $post->ID ) && ! $this->is_elementor_active();
        $preview_light        = current_user_can( 'edit_post', $post->ID ) && isset( $_GET['ch_light_pages'] );

        if ( ! $has_light_shortcodes && ! $needs_elementor_lite && ! $preview_light ) {
            return;
        }

        wp_enqueue_style(
            'classhall-light-pages',
            plugins_url( 'assets/classhall-light-pages.css', __FILE__ ),
            array(),
            self::VERSION
        );
    }

    private function content_has_classhall_shortcodes( $content ) {
        if ( empty( $content ) ) {
            return false;
        }

        return (bool) preg_match( '/\[\/?ch_(page|hero|section|grid|card|button|features|feature|cta|pricing|price|faq|question|subjects|elementor_page)\b/i', $content );
    }

    private function image_html( $image, $class = '', $priority = false ) {
        $image = trim( (string) $image );

        if ( '' === $image ) {
            return '';
        }

        if ( ctype_digit( $image ) ) {
            return wp_get_attachment_image(
                absint( $image ),
                'large',
                false,
                array(
                    'class'         => $class,
                    'loading'       => $priority ? 'eager' : 'lazy',
                    'fetchpriority' => $priority ? 'high' : 'auto',
                    'decoding'      => 'async',
                )
            );
        }

        return '<img class="' . esc_attr( $class ) . '" src="' . esc_url( $image ) . '" alt="" loading="' . esc_attr( $priority ? 'eager' : 'lazy' ) . '" fetchpriority="' . esc_attr( $priority ? 'high' : 'auto' ) . '" decoding="async">';
    }

    private function clean_content( $content ) {
        return do_shortcode( shortcode_unautop( trim( (string) $content ) ) );
    }

    public function page( $atts, $content = '' ) {
        $atts = shortcode_atts(
            array(
                'width' => 'wide',
            ),
            $atts,
            'ch_page'
        );

        return '<div class="chp chp-page chp-page-' . esc_attr( sanitize_html_class( $atts['width'] ) ) . '">' . $this->clean_content( $content ) . '</div>';
    }

    public function hero( $atts ) {
        $atts = shortcode_atts(
            array(
                'eyebrow'        => '',
                'title'          => '',
                'text'           => '',
                'image'          => '',
                'primary_text'   => '',
                'primary_url'    => '',
                'secondary_text' => '',
                'secondary_url'  => '',
            ),
            $atts,
            'ch_hero'
        );

        $image = $this->image_html( $atts['image'], 'chp-hero-image', true );

        ob_start();
        ?>
        <section class="chp-hero">
            <div class="chp-hero-copy">
                <?php if ( '' !== $atts['eyebrow'] ) : ?><p class="chp-eyebrow"><?php echo esc_html( $atts['eyebrow'] ); ?></p><?php endif; ?>
                <?php if ( '' !== $atts['title'] ) : ?><h1><?php echo esc_html( $atts['title'] ); ?></h1><?php endif; ?>
                <?php if ( '' !== $atts['text'] ) : ?><p class="chp-lead"><?php echo esc_html( $atts['text'] ); ?></p><?php endif; ?>
                <?php if ( '' !== $atts['primary_text'] || '' !== $atts['secondary_text'] ) : ?>
                    <div class="chp-actions">
                        <?php if ( '' !== $atts['primary_text'] ) : ?>
                            <a class="chp-button chp-button-primary" href="<?php echo esc_url( $atts['primary_url'] ); ?>"><?php echo esc_html( $atts['primary_text'] ); ?></a>
                        <?php endif; ?>
                        <?php if ( '' !== $atts['secondary_text'] ) : ?>
                            <a class="chp-button chp-button-secondary" href="<?php echo esc_url( $atts['secondary_url'] ); ?>"><?php echo esc_html( $atts['secondary_text'] ); ?></a>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>
            <?php if ( $image ) : ?><div class="chp-hero-media"><?php echo wp_kses_post( $image ); ?></div><?php endif; ?>
        </section>
        <?php
        return ob_get_clean();
    }

    public function section( $atts, $content = '' ) {
        $atts = shortcode_atts(
            array(
                'eyebrow' => '',
                'title'   => '',
                'intro'   => '',
                'tone'    => 'white',
            ),
            $atts,
            'ch_section'
        );

        ob_start();
        ?>
        <section class="chp-section chp-section-<?php echo esc_attr( sanitize_html_class( $atts['tone'] ) ); ?>">
            <?php if ( '' !== $atts['eyebrow'] || '' !== $atts['title'] || '' !== $atts['intro'] ) : ?>
                <header class="chp-section-head">
                    <?php if ( '' !== $atts['eyebrow'] ) : ?><p class="chp-eyebrow"><?php echo esc_html( $atts['eyebrow'] ); ?></p><?php endif; ?>
                    <?php if ( '' !== $atts['title'] ) : ?><h2><?php echo esc_html( $atts['title'] ); ?></h2><?php endif; ?>
                    <?php if ( '' !== $atts['intro'] ) : ?><p><?php echo esc_html( $atts['intro'] ); ?></p><?php endif; ?>
                </header>
            <?php endif; ?>
            <?php echo $this->clean_content( $content ); ?>
        </section>
        <?php
        return ob_get_clean();
    }

    public function grid( $atts, $content = '' ) {
        $atts = shortcode_atts(
            array(
                'columns' => 3,
            ),
            $atts,
            'ch_grid'
        );

        $columns = min( 4, max( 1, absint( $atts['columns'] ) ) );

        return '<div class="chp-grid chp-grid-' . esc_attr( $columns ) . '">' . $this->clean_content( $content ) . '</div>';
    }

    public function card( $atts, $content = '' ) {
        $atts = shortcode_atts(
            array(
                'title'  => '',
                'meta'   => '',
                'image'  => '',
                'url'    => '',
                'button' => '',
            ),
            $atts,
            'ch_card'
        );

        $image = $this->image_html( $atts['image'], 'chp-card-image' );
        $title = '' !== $atts['url'] ? '<a href="' . esc_url( $atts['url'] ) . '">' . esc_html( $atts['title'] ) . '</a>' : esc_html( $atts['title'] );

        ob_start();
        ?>
        <article class="chp-card">
            <?php if ( $image ) : ?><div class="chp-card-media"><?php echo wp_kses_post( $image ); ?></div><?php endif; ?>
            <div class="chp-card-body">
                <?php if ( '' !== $atts['meta'] ) : ?><p class="chp-card-meta"><?php echo esc_html( $atts['meta'] ); ?></p><?php endif; ?>
                <?php if ( '' !== $atts['title'] ) : ?><h3><?php echo wp_kses_post( $title ); ?></h3><?php endif; ?>
                <?php if ( '' !== trim( (string) $content ) ) : ?><div class="chp-card-text"><?php echo $this->clean_content( $content ); ?></div><?php endif; ?>
                <?php if ( '' !== $atts['button'] && '' !== $atts['url'] ) : ?><a class="chp-card-link" href="<?php echo esc_url( $atts['url'] ); ?>"><?php echo esc_html( $atts['button'] ); ?></a><?php endif; ?>
            </div>
        </article>
        <?php
        return ob_get_clean();
    }

    public function button( $atts ) {
        $atts = shortcode_atts(
            array(
                'text'  => '',
                'url'   => '',
                'style' => 'primary',
            ),
            $atts,
            'ch_button'
        );

        if ( '' === $atts['text'] ) {
            return '';
        }

        return '<a class="chp-button chp-button-' . esc_attr( sanitize_html_class( $atts['style'] ) ) . '" href="' . esc_url( $atts['url'] ) . '">' . esc_html( $atts['text'] ) . '</a>';
    }

    public function features( $atts, $content = '' ) {
        return '<div class="chp-features">' . $this->clean_content( $content ) . '</div>';
    }

    public function feature( $atts, $content = '' ) {
        $atts = shortcode_atts(
            array(
                'title' => '',
                'icon'  => '',
            ),
            $atts,
            'ch_feature'
        );

        return '<article class="chp-feature"><span class="chp-feature-icon">' . esc_html( $atts['icon'] ) . '</span><h3>' . esc_html( $atts['title'] ) . '</h3><div>' . $this->clean_content( $content ) . '</div></article>';
    }

    public function cta( $atts ) {
        $atts = shortcode_atts(
            array(
                'title'       => '',
                'text'        => '',
                'button_text' => '',
                'button_url'  => '',
            ),
            $atts,
            'ch_cta'
        );

        return '<section class="chp-cta"><h2>' . esc_html( $atts['title'] ) . '</h2><p>' . esc_html( $atts['text'] ) . '</p>' . $this->button( array( 'text' => $atts['button_text'], 'url' => $atts['button_url'], 'style' => 'primary' ) ) . '</section>';
    }

    public function pricing( $atts, $content = '' ) {
        return '<div class="chp-pricing">' . $this->clean_content( $content ) . '</div>';
    }

    public function price( $atts ) {
        $atts = shortcode_atts(
            array(
                'name'        => '',
                'price'       => '',
                'period'      => '',
                'badge'       => '',
                'features'    => '',
                'excluded'    => '',
                'button_text' => '',
                'button_url'  => '',
            ),
            $atts,
            'ch_price'
        );

        $features = array_filter( array_map( 'trim', explode( '|', $atts['features'] ) ) );
        $excluded = array_filter( array_map( 'trim', explode( '|', $atts['excluded'] ) ) );

        ob_start();
        ?>
        <article class="chp-price">
            <?php if ( '' !== $atts['badge'] ) : ?><span class="chp-price-badge"><?php echo esc_html( $atts['badge'] ); ?></span><?php endif; ?>
            <h3><?php echo esc_html( $atts['name'] ); ?></h3>
            <p class="chp-price-value"><?php echo esc_html( $atts['price'] ); ?><?php if ( '' !== $atts['period'] ) : ?><span><?php echo esc_html( $atts['period'] ); ?></span><?php endif; ?></p>
            <ul>
                <?php foreach ( $features as $feature ) : ?><li><?php echo esc_html( $feature ); ?></li><?php endforeach; ?>
                <?php foreach ( $excluded as $feature ) : ?><li class="chp-muted"><?php echo esc_html( $feature ); ?></li><?php endforeach; ?>
            </ul>
            <?php if ( '' !== $atts['button_text'] ) : ?><?php echo $this->button( array( 'text' => $atts['button_text'], 'url' => $atts['button_url'], 'style' => 'primary' ) ); ?><?php endif; ?>
        </article>
        <?php
        return ob_get_clean();
    }

    public function faq( $atts, $content = '' ) {
        return '<div class="chp-faq">' . $this->clean_content( $content ) . '</div>';
    }

    public function question( $atts, $content = '' ) {
        $atts = shortcode_atts(
            array(
                'question' => '',
            ),
            $atts,
            'ch_question'
        );

        return '<details class="chp-question"><summary>' . esc_html( $atts['question'] ) . '</summary><div>' . $this->clean_content( $content ) . '</div></details>';
    }

    public function subjects( $atts ) {
        $atts = shortcode_atts(
            array(
                'limit' => 6,
            ),
            $atts,
            'ch_subjects'
        );

        $query = new WP_Query(
            array(
                'post_type'           => 'course',
                'post_status'         => 'publish',
                'posts_per_page'      => max( 1, absint( $atts['limit'] ) ),
                'no_found_rows'       => true,
                'ignore_sticky_posts' => true,
            )
        );

        if ( ! $query->have_posts() ) {
            return '';
        }

        ob_start();
        ?>
        <div class="chp-grid chp-grid-3">
            <?php
            while ( $query->have_posts() ) :
                $query->the_post();
                ?>
                <article class="chp-card chp-subject-card">
                    <?php if ( has_post_thumbnail() ) : ?><div class="chp-card-media"><?php the_post_thumbnail( 'medium_large', array( 'class' => 'chp-card-image', 'loading' => 'lazy', 'decoding' => 'async' ) ); ?></div><?php endif; ?>
                    <div class="chp-card-body">
                        <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                    </div>
                </article>
            <?php endwhile; ?>
        </div>
        <?php
        wp_reset_postdata();

        return ob_get_clean();
    }

    public function maybe_render_elementor_content( $content ) {
        if ( is_admin() || ! is_singular() || ! in_the_loop() || ! is_main_query() ) {
            return $content;
        }

        $post_id = get_the_ID();

        if ( ! $post_id || ! $this->post_has_elementor_data( $post_id ) ) {
            return $content;
        }

        $preview_light = current_user_can( 'edit_post', $post_id ) && isset( $_GET['ch_light_pages'] );

        if ( $this->is_elementor_active() && ! $preview_light ) {
            return $content;
        }

        $rendered = $this->render_elementor_post( $post_id );

        if ( '' === trim( $rendered ) ) {
            return $content;
        }

        $built_with_elementor = 'builder' === get_post_meta( $post_id, '_elementor_edit_mode', true );

        if ( '' !== trim( wp_strip_all_tags( $content ) ) && ! $preview_light && ! $built_with_elementor ) {
            return $content;
        }

        return $rendered;
    }

    public function elementor_page( $atts ) {
        $atts = shortcode_atts(
            array(
                'id' => 0,
            ),
            $atts,
            'ch_elementor_page'
        );

        $post_id = absint( $atts['id'] );

        if ( ! $post_id ) {
            $post_id = get_the_ID();
        }

        return $post_id ? $this->render_elementor_post( $post_id ) : '';
    }

    private function is_elementor_active() {
        return did_action( 'elementor/loaded' ) || class_exists( '\Elementor\Plugin' );
    }

    private function post_has_elementor_data( $post_id ) {
        return '' !== trim( (string) get_post_meta( $post_id, '_elementor_data', true ) );
    }

    private function render_elementor_post( $post_id ) {
        $data = get_post_meta( $post_id, '_elementor_data', true );

        if ( '' === trim( (string) $data ) ) {
            return '';
        }

        if ( is_string( $data ) ) {
            $data = json_decode( $data, true );

            if ( ! is_array( $data ) ) {
                $data = json_decode( wp_unslash( get_post_meta( $post_id, '_elementor_data', true ) ), true );
            }
        }

        if ( ! is_array( $data ) ) {
            return '';
        }

        return '<div class="chp chp-page chp-elementor-lite">' . $this->render_elementor_elements( $data ) . '</div>';
    }

    private function render_elementor_elements( $elements ) {
        $html = '';

        foreach ( (array) $elements as $element ) {
            if ( ! is_array( $element ) ) {
                continue;
            }

            $html .= $this->render_elementor_element( $element );
        }

        return $html;
    }

    private function render_elementor_element( $element ) {
        $type     = isset( $element['elType'] ) ? $element['elType'] : '';
        $widget   = isset( $element['widgetType'] ) ? $element['widgetType'] : '';
        $settings = isset( $element['settings'] ) && is_array( $element['settings'] ) ? $element['settings'] : array();
        $children = isset( $element['elements'] ) && is_array( $element['elements'] ) ? $element['elements'] : array();

        if ( 'widget' === $type ) {
            return $this->render_elementor_widget( $widget, $settings );
        }

        $classes = array( 'chp-el', 'chp-el-' . sanitize_html_class( $type ) );

        $style = '';

        if ( 'section' === $type ) {
            $classes[] = 'chp-el-section';
        } elseif ( 'column' === $type ) {
            $classes[] = 'chp-el-column';
            $style = $this->elementor_column_style( $settings );
        } elseif ( 'container' === $type ) {
            $classes[] = 'chp-el-container';
        }

        return '<div class="' . esc_attr( implode( ' ', array_filter( $classes ) ) ) . '"' . $style . '>' . $this->render_elementor_elements( $children ) . '</div>';
    }

    private function render_elementor_widget( $widget, $settings ) {
        switch ( $widget ) {
            case 'heading':
                return $this->render_elementor_heading( $settings );

            case 'text-editor':
                return $this->render_elementor_text( $settings );

            case 'image':
                return $this->render_elementor_image( $settings );

            case 'button':
                return $this->render_elementor_button( $settings );

            case 'icon-list':
                return $this->render_elementor_icon_list( $settings );

            case 'accordion':
            case 'toggle':
                return $this->render_elementor_accordion( $settings );

            case 'shortcode':
                return $this->render_elementor_shortcode( $settings );

            case 'html':
                return $this->render_elementor_html( $settings );

            case 'divider':
                return '<hr class="chp-divider">';

            case 'spacer':
                return '<div class="chp-spacer" aria-hidden="true"></div>';

            case 'video':
                return $this->render_elementor_video( $settings );

            case 'image-box':
            case 'icon-box':
                return $this->render_elementor_box( $settings, $widget );

            case 'call-to-action':
                return $this->render_elementor_call_to_action( $settings );
        }

        return $this->render_elementor_unknown_widget( $settings );
    }

    private function elementor_column_style( $settings ) {
        $size = 0;

        foreach ( array( '_column_size', '_inline_size', 'content_width' ) as $key ) {
            if ( isset( $settings[ $key ] ) && is_numeric( $settings[ $key ] ) ) {
                $size = (float) $settings[ $key ];
                break;
            }
        }

        if ( $size <= 0 || $size > 100 ) {
            return '';
        }

        $size = round( $size, 4 );

        return ' style="flex-basis:' . esc_attr( $size ) . '%;max-width:' . esc_attr( $size ) . '%;"';
    }

    private function elementor_link_url( $link ) {
        if ( is_array( $link ) ) {
            return isset( $link['url'] ) ? trim( (string) $link['url'] ) : '';
        }

        return trim( (string) $link );
    }

    private function elementor_link_attrs( $link ) {
        $url = $this->elementor_link_url( $link );

        if ( '' === $url ) {
            return '';
        }

        $attrs = ' href="' . esc_url( $url ) . '"';

        if ( is_array( $link ) && ! empty( $link['is_external'] ) ) {
            $attrs .= ' target="_blank"';
        }

        $rel = array();

        if ( is_array( $link ) && ! empty( $link['nofollow'] ) ) {
            $rel[] = 'nofollow';
        }

        if ( is_array( $link ) && ! empty( $link['is_external'] ) ) {
            $rel[] = 'noopener';
        }

        if ( ! empty( $rel ) ) {
            $attrs .= ' rel="' . esc_attr( implode( ' ', array_unique( $rel ) ) ) . '"';
        }

        return $attrs;
    }

    private function render_elementor_heading( $settings ) {
        $title = isset( $settings['title'] ) ? $settings['title'] : '';
        $tag   = isset( $settings['header_size'] ) ? strtolower( $settings['header_size'] ) : 'h2';
        $link  = isset( $settings['link'] ) ? $settings['link'] : array();

        if ( '' === trim( wp_strip_all_tags( $title ) ) ) {
            return '';
        }

        if ( ! in_array( $tag, array( 'h1', 'h2', 'h3', 'h4', 'h5', 'h6' ), true ) ) {
            $tag = 'h2';
        }

        $title = wp_kses_post( $title );

        if ( $this->elementor_link_url( $link ) ) {
            $title = '<a' . $this->elementor_link_attrs( $link ) . '>' . $title . '</a>';
        }

        return '<' . tag_escape( $tag ) . ' class="chp-el-heading">' . $title . '</' . tag_escape( $tag ) . '>';
    }

    private function render_elementor_text( $settings ) {
        $editor = isset( $settings['editor'] ) ? $settings['editor'] : '';

        if ( '' === trim( wp_strip_all_tags( $editor ) ) ) {
            return '';
        }

        return '<div class="chp-el-text">' . wpautop( do_shortcode( wp_kses_post( $editor ) ) ) . '</div>';
    }

    private function render_elementor_image( $settings ) {
        $image = isset( $settings['image'] ) && is_array( $settings['image'] ) ? $settings['image'] : array();
        $id    = isset( $image['id'] ) ? absint( $image['id'] ) : 0;
        $url   = isset( $image['url'] ) ? $image['url'] : '';
        $link  = isset( $settings['link'] ) ? $settings['link'] : array();

        if ( $id ) {
            $html = wp_get_attachment_image( $id, 'large', false, array( 'class' => 'chp-el-image', 'loading' => 'lazy', 'decoding' => 'async' ) );
        } elseif ( $url ) {
            $html = '<img class="chp-el-image" src="' . esc_url( $url ) . '" alt="" loading="lazy" decoding="async">';
        } else {
            return '';
        }

        if ( $this->elementor_link_url( $link ) ) {
            $html = '<a class="chp-el-image-link"' . $this->elementor_link_attrs( $link ) . '>' . $html . '</a>';
        }

        return $html;
    }

    private function render_elementor_button( $settings ) {
        $text = isset( $settings['text'] ) ? $settings['text'] : '';
        $url  = isset( $settings['link'] ) ? $settings['link'] : array();

        if ( '' === trim( (string) $text ) || ! $this->elementor_link_url( $url ) ) {
            return '';
        }

        return '<a class="chp-button chp-button-primary"' . $this->elementor_link_attrs( $url ) . '>' . esc_html( $text ) . '</a>';
    }

    private function render_elementor_icon_list( $settings ) {
        $items = isset( $settings['icon_list'] ) && is_array( $settings['icon_list'] ) ? $settings['icon_list'] : array();

        if ( empty( $items ) ) {
            return '';
        }

        $html = '<ul class="chp-el-icon-list">';

        foreach ( $items as $item ) {
            $text = isset( $item['text'] ) ? $item['text'] : '';
            $link = isset( $item['link'] ) ? $item['link'] : array();

            if ( '' === trim( wp_strip_all_tags( $text ) ) ) {
                continue;
            }

            $label = wp_kses_post( $text );

            if ( $this->elementor_link_url( $link ) ) {
                $label = '<a' . $this->elementor_link_attrs( $link ) . '>' . $label . '</a>';
            }

            $html .= '<li>' . $label . '</li>';
        }

        return $html . '</ul>';
    }

    private function render_elementor_accordion( $settings ) {
        $items = array();

        if ( isset( $settings['tabs'] ) && is_array( $settings['tabs'] ) ) {
            $items = $settings['tabs'];
        } elseif ( isset( $settings['toggle'] ) && is_array( $settings['toggle'] ) ) {
            $items = $settings['toggle'];
        }

        if ( empty( $items ) ) {
            return '';
        }

        $html = '<div class="chp-faq">';

        foreach ( $items as $item ) {
            $title   = isset( $item['tab_title'] ) ? $item['tab_title'] : '';
            $content = isset( $item['tab_content'] ) ? $item['tab_content'] : '';

            if ( '' === trim( wp_strip_all_tags( $title ) ) ) {
                continue;
            }

            $html .= '<details class="chp-question"><summary>' . esc_html( $title ) . '</summary><div>' . wpautop( do_shortcode( wp_kses_post( $content ) ) ) . '</div></details>';
        }

        return $html . '</div>';
    }

    private function render_elementor_shortcode( $settings ) {
        $shortcode = isset( $settings['shortcode'] ) ? $settings['shortcode'] : '';

        if ( '' === trim( $shortcode ) ) {
            return '';
        }

        return '<div class="chp-el-shortcode">' . do_shortcode( $shortcode ) . '</div>';
    }

    private function render_elementor_html( $settings ) {
        $html = isset( $settings['html'] ) ? $settings['html'] : '';

        if ( '' === trim( (string) $html ) ) {
            return '';
        }

        return '<div class="chp-el-html">' . wp_kses_post( do_shortcode( $html ) ) . '</div>';
    }

    private function render_elementor_video( $settings ) {
        $url = isset( $settings['youtube_url'] ) ? $settings['youtube_url'] : '';

        if ( ! $url && isset( $settings['vimeo_url'] ) ) {
            $url = $settings['vimeo_url'];
        }

        if ( ! $url ) {
            return '';
        }

        $embed = wp_oembed_get( esc_url_raw( $url ) );

        return $embed ? '<div class="chp-el-video">' . $embed . '</div>' : '';
    }

    private function render_elementor_box( $settings, $widget ) {
        $title       = isset( $settings['title_text'] ) ? $settings['title_text'] : '';
        $description = isset( $settings['description_text'] ) ? $settings['description_text'] : '';
        $link        = isset( $settings['link'] ) ? $settings['link'] : array();
        $image_html  = '';

        if ( 'image-box' === $widget && isset( $settings['image'] ) && is_array( $settings['image'] ) ) {
            $image_id  = isset( $settings['image']['id'] ) ? absint( $settings['image']['id'] ) : 0;
            $image_url = isset( $settings['image']['url'] ) ? $settings['image']['url'] : '';

            if ( $image_id ) {
                $image_html = wp_get_attachment_image( $image_id, 'medium_large', false, array( 'class' => 'chp-el-box-image', 'loading' => 'lazy', 'decoding' => 'async' ) );
            } elseif ( $image_url ) {
                $image_html = '<img class="chp-el-box-image" src="' . esc_url( $image_url ) . '" alt="" loading="lazy" decoding="async">';
            }
        }

        if ( '' === trim( wp_strip_all_tags( $title . $description . $image_html ) ) ) {
            return '';
        }

        $title_html = '' !== trim( wp_strip_all_tags( $title ) ) ? '<h3>' . wp_kses_post( $title ) . '</h3>' : '';

        if ( $title_html && $this->elementor_link_url( $link ) ) {
            $title_html = '<h3><a' . $this->elementor_link_attrs( $link ) . '>' . wp_kses_post( $title ) . '</a></h3>';
        }

        if ( $image_html && $this->elementor_link_url( $link ) ) {
            $image_html = '<a class="chp-el-box-image-link"' . $this->elementor_link_attrs( $link ) . '>' . $image_html . '</a>';
        }

        return '<article class="chp-card chp-el-box"><div class="chp-card-body">' . $image_html . $title_html . '<div class="chp-card-text">' . wpautop( wp_kses_post( $description ) ) . '</div></div></article>';
    }

    private function render_elementor_call_to_action( $settings ) {
        $title       = isset( $settings['title'] ) ? $settings['title'] : '';
        $description = isset( $settings['description'] ) ? $settings['description'] : '';
        $button      = isset( $settings['button'] ) ? $settings['button'] : '';
        $link        = isset( $settings['link'] ) ? $settings['link'] : array();

        if ( '' === trim( wp_strip_all_tags( $title . $description . $button ) ) ) {
            return '';
        }

        $button_html = '';

        if ( '' !== trim( (string) $button ) && $this->elementor_link_url( $link ) ) {
            $button_html = '<a class="chp-button chp-button-primary"' . $this->elementor_link_attrs( $link ) . '>' . esc_html( $button ) . '</a>';
        }

        return '<section class="chp-cta"><div><h2>' . esc_html( $title ) . '</h2><p>' . esc_html( $description ) . '</p></div>' . $button_html . '</section>';
    }

    private function render_elementor_unknown_widget( $settings ) {
        $preferred_keys = array(
            'title',
            'title_text',
            'text',
            'editor',
            'html',
            'content',
            'description',
            'description_text',
            'number',
            'ending_number',
            'starting_number',
        );

        foreach ( $preferred_keys as $key ) {
            if ( ! isset( $settings[ $key ] ) || is_array( $settings[ $key ] ) ) {
                continue;
            }

            $value = trim( (string) $settings[ $key ] );

            if ( '' === $value || '' === trim( wp_strip_all_tags( $value ) ) ) {
                continue;
            }

            return '<div class="chp-el-text chp-el-fallback">' . wpautop( wp_kses_post( do_shortcode( $value ) ) ) . '</div>';
        }

        $values = array();

        foreach ( $settings as $key => $value ) {
            if ( is_array( $value ) || is_object( $value ) ) {
                continue;
            }

            $key = (string) $key;

            if ( ! preg_match( '/(^|_)(title|text|content|editor|html|number|label|name|week|prefix|suffix)$/i', $key ) ) {
                continue;
            }

            if ( preg_match( '/(url|link|color|size|width|height|margin|padding|align|typography|font|animation|css|id|class)/i', $key ) ) {
                continue;
            }

            $value = trim( (string) $value );

            if ( '' === $value || '' === trim( wp_strip_all_tags( $value ) ) ) {
                continue;
            }

            $values[] = $value;
        }

        $values = array_values( array_unique( $values ) );

        if ( empty( $values ) ) {
            return '';
        }

        return '<div class="chp-el-text chp-el-fallback">' . wpautop( wp_kses_post( do_shortcode( implode( "\n", $values ) ) ) ) . '</div>';

        return '';
    }
}

Classhall_Light_Pages::instance();
