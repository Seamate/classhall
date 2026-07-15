<?php
/**
 * Plugin Name: Classhall Forum Compatibility
 * Description: Lightweight replacement for the old DW Question & Answer display layer.
 * Version: 1.0.17
 * Author: Classhall
 * Text Domain: classhall-forum
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

final class Classhall_Forum_Compatibility {
    const VERSION       = '1.0.17';
    const QUESTION_TYPE = 'dwqa-question';
    const ANSWER_TYPE   = 'dwqa-answer';
    const CATEGORY_TAX  = 'dwqa-question_category';

    private static $instance = null;

    public static function instance() {
        if ( null === self::$instance ) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    private function __construct() {
        add_action( 'init', array( $this, 'register_content_types' ), 20 );
        add_action( 'init', array( $this, 'maybe_flush_rewrites' ), 99 );
        add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_assets' ), 1000 );
        add_action( 'wp_head', array( $this, 'print_sidebar_style_override' ), 999 );
        add_action( 'template_redirect', array( $this, 'handle_posts' ) );
        add_filter( 'request', array( $this, 'prefer_dwqa_question_for_legacy_urls' ), 1 );
        add_filter( 'the_content', array( $this, 'replace_single_question_content' ), 20 );
        add_filter( 'comments_open', array( $this, 'disable_answer_comments' ), 10, 2 );
        add_shortcode( 'dwqa-list-questions', array( $this, 'questions_shortcode' ) );
        add_shortcode( 'dwqa-submit-question-form', array( $this, 'submit_question_shortcode' ) );
        add_shortcode( 'classhall_forum_topics', array( $this, 'questions_shortcode' ) );
        add_shortcode( 'classhall_ask_question', array( $this, 'submit_question_shortcode' ) );
        add_shortcode( 'anspress', '__return_empty_string' );
    }

    public static function activate() {
        self::instance()->register_content_types();
        self::instance()->ensure_legacy_pages();
        update_option( 'classhall_forum_rewrite_version', self::VERSION, false );
        flush_rewrite_rules();
    }

    public static function deactivate() {
        flush_rewrite_rules();
    }

    public function register_content_types() {
        register_post_type(
            self::QUESTION_TYPE,
            array(
                'labels'        => array(
                    'name'          => __( 'Forum Topics', 'classhall-forum' ),
                    'singular_name' => __( 'Forum Topic', 'classhall-forum' ),
                    'add_new_item'  => __( 'Add Forum Topic', 'classhall-forum' ),
                    'edit_item'     => __( 'Edit Forum Topic', 'classhall-forum' ),
                ),
                'public'        => true,
                'show_ui'       => true,
                'show_in_menu'  => true,
                'show_in_rest'  => true,
                'menu_icon'     => 'dashicons-format-chat',
                'supports'      => array( 'title', 'editor', 'author', 'comments' ),
                'has_archive'   => 'topics',
                'rewrite'       => array(
                    'slug'       => $this->get_question_slug(),
                    'with_front' => false,
                ),
                'capability_type' => 'post',
            )
        );

        register_post_type(
            self::ANSWER_TYPE,
            array(
                'labels'              => array(
                    'name'          => __( 'Forum Answers', 'classhall-forum' ),
                    'singular_name' => __( 'Forum Answer', 'classhall-forum' ),
                    'edit_item'     => __( 'Edit Forum Answer', 'classhall-forum' ),
                ),
                'public'              => false,
                'show_ui'             => true,
                'show_in_menu'        => 'edit.php?post_type=' . self::QUESTION_TYPE,
                'show_in_rest'        => true,
                'supports'            => array( 'editor', 'author' ),
                'capability_type'     => 'post',
                'exclude_from_search' => true,
            )
        );

        register_taxonomy(
            self::CATEGORY_TAX,
            self::QUESTION_TYPE,
            array(
                'labels'       => array(
                    'name'          => __( 'Subjects', 'classhall-forum' ),
                    'singular_name' => __( 'Subject', 'classhall-forum' ),
                ),
                'public'       => true,
                'show_ui'      => true,
                'show_in_rest' => true,
                'hierarchical' => true,
                'rewrite'      => array(
                    'slug'       => $this->get_category_slug(),
                    'with_front' => false,
                ),
            )
        );

        foreach ( $this->get_question_slugs() as $slug ) {
            add_rewrite_rule(
                '^' . preg_quote( $slug, '/' ) . '/([^/]+)/?$',
                'index.php?post_type=' . self::QUESTION_TYPE . '&name=$matches[1]',
                'top'
            );
        }

        foreach ( array( 'topics', 'questions' ) as $archive_slug ) {
            add_rewrite_rule(
                '^' . $archive_slug . '/?$',
                'index.php?post_type=' . self::QUESTION_TYPE,
                'top'
            );
        }
    }

    public function maybe_flush_rewrites() {
        if ( self::VERSION !== get_option( 'classhall_forum_rewrite_version' ) ) {
            update_option( 'classhall_forum_rewrite_version', self::VERSION, false );
            flush_rewrite_rules();
        }
    }

    public function enqueue_assets() {
        wp_enqueue_style(
            'classhall-forum',
            plugins_url( 'assets/classhall-forum.css', __FILE__ ),
            array(),
            self::VERSION
        );
    }

    public function print_sidebar_style_override() {
        ?>
        <style id="classhall-forum-sidebar-override">
            .widget:has(.classhall-forum),
            .widget:has(.dwqa-questions-list),
            .widget:has(.dwqa-popular-questions),
            .widget:has(.related-questions),
            aside:has(.classhall-forum),
            aside:has(.dwqa-questions-list),
            aside:has(.dwqa-popular-questions),
            aside:has(.related-questions),
            .sidebar .widget:has(.classhall-forum),
            .sidebar .widget:has(.dwqa-questions-list),
            .sidebar .widget:has(.dwqa-popular-questions),
            .sidebar .widget:has(.related-questions) {
                background: transparent !important;
                border: 0 !important;
                box-shadow: none !important;
                padding: 0 !important;
            }

            .widget:has(.classhall-forum) .widget-title,
            .widget:has(.classhall-forum) .widgettitle,
            .widget:has(.dwqa-questions-list) .widget-title,
            .widget:has(.dwqa-questions-list) .widgettitle,
            .widget:has(.dwqa-popular-questions) .widget-title,
            .widget:has(.dwqa-popular-questions) .widgettitle,
            .widget:has(.related-questions) .widget-title,
            .widget:has(.related-questions) .widgettitle,
            .widget:has(.classhall-forum) h3:first-child,
            .widget:has(.dwqa-questions-list) h3:first-child,
            .widget:has(.dwqa-popular-questions) h3:first-child,
            .widget:has(.related-questions) h3:first-child,
            .widget:has(.classhall-forum) h4:first-child,
            .widget:has(.dwqa-questions-list) h4:first-child,
            .widget:has(.dwqa-popular-questions) h4:first-child,
            .widget:has(.related-questions) h4:first-child,
            aside:has(.classhall-forum) .widget-title,
            aside:has(.classhall-forum) .widgettitle,
            aside:has(.dwqa-questions-list) .widget-title,
            aside:has(.dwqa-questions-list) .widgettitle,
            aside:has(.dwqa-popular-questions) .widget-title,
            aside:has(.dwqa-popular-questions) .widgettitle,
            aside:has(.related-questions) .widget-title,
            aside:has(.related-questions) .widgettitle {
                background: #f5f5f5 !important;
                border: 1px solid #e5e5e5 !important;
                border-radius: 2px !important;
                color: #222222 !important;
                display: block !important;
                font-size: 16px !important;
                font-weight: 400 !important;
                line-height: 1.3 !important;
                margin: 0 0 10px !important;
                padding: 11px 14px !important;
            }

            .widget .classhall-forum,
            aside .classhall-forum,
            .sidebar .classhall-forum,
            .widget .dwqa-questions-list,
            aside .dwqa-questions-list,
            .sidebar .dwqa-questions-list,
            .widget .dwqa-popular-questions ul,
            aside .dwqa-popular-questions ul,
            .sidebar .dwqa-popular-questions ul,
            .widget .related-questions ul,
            aside .related-questions ul,
            .sidebar .related-questions ul {
                background: #ffffff !important;
                border: 1px solid #e5e5e5 !important;
                border-radius: 2px !important;
                list-style: none !important;
                margin: 0 !important;
                padding: 0 !important;
            }

            .widget .dwqa-questions-list .dwqa-question-item,
            aside .dwqa-questions-list .dwqa-question-item,
            .sidebar .dwqa-questions-list .dwqa-question-item,
            .widget .classhall-forum .dwqa-question-item,
            aside .classhall-forum .dwqa-question-item,
            .sidebar .classhall-forum .dwqa-question-item,
            .widget .dwqa-popular-questions ul li,
            aside .dwqa-popular-questions ul li,
            .sidebar .dwqa-popular-questions ul li,
            .widget .related-questions ul li,
            aside .related-questions ul li,
            .sidebar .related-questions ul li {
                background: #ffffff !important;
                border: 0 !important;
                border-bottom: 1px solid #eeeeee !important;
                border-radius: 0 !important;
                box-shadow: none !important;
                list-style: none !important;
                margin: 0 !important;
                padding: 12px 14px !important;
            }

            .widget .dwqa-questions-list .dwqa-question-item:last-child,
            aside .dwqa-questions-list .dwqa-question-item:last-child,
            .sidebar .dwqa-questions-list .dwqa-question-item:last-child,
            .widget .classhall-forum .dwqa-question-item:last-child,
            aside .classhall-forum .dwqa-question-item:last-child,
            .sidebar .classhall-forum .dwqa-question-item:last-child,
            .widget .dwqa-popular-questions ul li:last-child,
            aside .dwqa-popular-questions ul li:last-child,
            .sidebar .dwqa-popular-questions ul li:last-child,
            .widget .related-questions ul li:last-child,
            aside .related-questions ul li:last-child,
            .sidebar .related-questions ul li:last-child {
                border-bottom: 0 !important;
            }

            .widget .dwqa-questions-list .dwqa-question-title,
            .widget .dwqa-questions-list .dwqa-question-title a,
            .widget .dwqa-question-title,
            .widget .dwqa-question-title a,
            .widget .dwqa-questions-list .dwqa-question-item a,
            aside .dwqa-questions-list .dwqa-question-title,
            aside .dwqa-questions-list .dwqa-question-title a,
            aside .dwqa-question-title,
            aside .dwqa-question-title a,
            aside .dwqa-questions-list .dwqa-question-item a,
            .sidebar .dwqa-questions-list .dwqa-question-title,
            .sidebar .dwqa-questions-list .dwqa-question-title a,
            .sidebar .classhall-forum .dwqa-question-title,
            .sidebar .classhall-forum .dwqa-question-title a,
            .sidebar .dwqa-question-title,
            .sidebar .dwqa-question-title a,
            .sidebar .dwqa-questions-list .dwqa-question-item a,
            .dwqa-popular-questions ul li a.question-title,
            .dwqa-popular-questions ul li a,
            .related-questions ul li a.question-title,
            .related-questions ul li a,
            .classhall-forum-compact .dwqa-question-title,
            .classhall-forum-compact .dwqa-question-title a,
            .classhall-forum-compact .dwqa-question-item a,
            .classhall-forum-compact-item a,
            .classhall-forum-compact-item .dwqa-question-title a {
                color: #222222 !important;
                display: inline !important;
                font-size: 14px !important;
                font-weight: 400 !important;
                line-height: 1.4 !important;
                text-decoration: none !important;
            }

            .widget .dwqa-questions-list .dwqa-question-title,
            aside .dwqa-questions-list .dwqa-question-title,
            .sidebar .dwqa-questions-list .dwqa-question-title,
            .widget .classhall-forum .dwqa-question-title,
            aside .classhall-forum .dwqa-question-title,
            .sidebar .classhall-forum .dwqa-question-title,
            .classhall-forum-compact .dwqa-question-title {
                margin: 0 !important;
                padding: 0 !important;
            }

            .widget .dwqa-question-meta,
            .widget .dwqa-question-stats,
            .widget .dwqa-ask-question,
            .widget .classhall-forum-pagination,
            .widget .dwqa-page-numbers,
            aside .dwqa-question-meta,
            aside .dwqa-question-stats,
            aside .dwqa-ask-question,
            aside .classhall-forum-pagination,
            aside .dwqa-page-numbers,
            .sidebar .dwqa-question-meta,
            .sidebar .dwqa-question-stats,
            .sidebar .dwqa-ask-question,
            .sidebar .classhall-forum-pagination,
            .sidebar .dwqa-page-numbers,
            .classhall-forum-compact .dwqa-question-meta,
            .classhall-forum-compact .dwqa-question-stats,
            .classhall-forum-compact .dwqa-ask-question,
            .classhall-forum-compact .classhall-forum-pagination,
            .classhall-forum-compact .dwqa-page-numbers {
                display: none !important;
            }
        </style>
        <?php
    }

    public function prefer_dwqa_question_for_legacy_urls( $query_vars ) {
        if ( empty( $query_vars['name'] ) ) {
            return $query_vars;
        }

        $slugs = $this->get_question_slugs();
        $requested_post_type = isset( $query_vars['post_type'] ) ? $query_vars['post_type'] : '';

        if ( self::QUESTION_TYPE === $requested_post_type ) {
            return $query_vars;
        }

        if ( isset( $query_vars[ self::QUESTION_TYPE ] ) || in_array( $requested_post_type, $slugs, true ) || 'question' === $requested_post_type ) {
            $topic = get_page_by_path( sanitize_title_for_query( $query_vars['name'] ), OBJECT, self::QUESTION_TYPE );

            if ( $topic ) {
                $query_vars['post_type'] = self::QUESTION_TYPE;
            }
        }

        return $query_vars;
    }

    public function handle_posts() {
        if ( ! empty( $_POST['classhall_forum_action'] ) && 'ask_question' === $_POST['classhall_forum_action'] ) {
            $this->handle_question_submission();
        }

        if ( ! empty( $_POST['classhall_forum_action'] ) && 'post_answer' === $_POST['classhall_forum_action'] ) {
            $this->handle_answer_submission();
        }
    }

    private function handle_question_submission() {
        if ( ! is_user_logged_in() ) {
            $this->redirect_with_message( 'login_required' );
        }

        check_admin_referer( 'classhall_forum_ask_question', 'classhall_forum_nonce' );

        $title   = isset( $_POST['classhall_forum_title'] ) ? sanitize_text_field( wp_unslash( $_POST['classhall_forum_title'] ) ) : '';
        $content = isset( $_POST['classhall_forum_content'] ) ? wp_kses_post( wp_unslash( $_POST['classhall_forum_content'] ) ) : '';

        if ( '' === $title || '' === wp_strip_all_tags( $content ) ) {
            $this->redirect_with_message( 'missing_fields' );
        }

        $question_id = wp_insert_post(
            array(
                'post_type'    => self::QUESTION_TYPE,
                'post_status'  => 'publish',
                'post_title'   => $title,
                'post_content' => $content,
                'post_author'  => get_current_user_id(),
            ),
            true
        );

        if ( is_wp_error( $question_id ) ) {
            $this->redirect_with_message( 'not_saved' );
        }

        if ( ! empty( $_POST['classhall_forum_category'] ) ) {
            wp_set_object_terms( $question_id, absint( $_POST['classhall_forum_category'] ), self::CATEGORY_TAX );
        }

        wp_safe_redirect( get_permalink( $question_id ) );
        exit;
    }

    private function handle_answer_submission() {
        if ( ! is_user_logged_in() ) {
            $this->redirect_with_message( 'login_required' );
        }

        check_admin_referer( 'classhall_forum_post_answer', 'classhall_forum_nonce' );

        $question_id = isset( $_POST['classhall_forum_question_id'] ) ? absint( $_POST['classhall_forum_question_id'] ) : 0;
        $question    = $question_id ? get_post( $question_id ) : null;
        $content     = isset( $_POST['classhall_forum_answer'] ) ? wp_kses_post( wp_unslash( $_POST['classhall_forum_answer'] ) ) : '';

        if ( ! $question || self::QUESTION_TYPE !== $question->post_type || '' === wp_strip_all_tags( $content ) ) {
            $this->redirect_with_message( 'missing_fields' );
        }

        $answer_id = wp_insert_post(
            array(
                'post_type'    => self::ANSWER_TYPE,
                'post_status'  => 'publish',
                'post_parent'  => $question_id,
                'post_title'   => sprintf( 'Answer to: %s', get_the_title( $question_id ) ),
                'post_content' => $content,
                'post_author'  => get_current_user_id(),
            ),
            true
        );

        if ( is_wp_error( $answer_id ) ) {
            $this->redirect_with_message( 'not_saved' );
        }

        wp_safe_redirect( add_query_arg( 'forum_message', 'answer_posted', get_permalink( $question_id ) ) . '#answers' );
        exit;
    }

    private function redirect_with_message( $message ) {
        $fallback = wp_get_referer() ? wp_get_referer() : home_url( '/' );
        wp_safe_redirect( add_query_arg( 'forum_message', sanitize_key( $message ), $fallback ) );
        exit;
    }

    public function replace_single_question_content( $content ) {
        if ( ! is_singular( self::QUESTION_TYPE ) || ! in_the_loop() || ! is_main_query() ) {
            return $content;
        }

        return $this->render_single_question( get_the_ID() );
    }

    public function disable_answer_comments( $open, $post_id ) {
        if ( self::ANSWER_TYPE === get_post_type( $post_id ) ) {
            return false;
        }

        return $open;
    }

    public function questions_shortcode( $atts ) {
        $atts = shortcode_atts(
            array(
                'per_page' => 12,
                'category' => '',
                'compact'  => '',
            ),
            $atts,
            'dwqa-list-questions'
        );

        $is_compact = $this->is_compact_shortcode_context( $atts );
        $paged      = $is_compact ? 1 : max( 1, get_query_var( 'paged' ), get_query_var( 'page' ) );
        $args  = array(
            'post_type'      => self::QUESTION_TYPE,
            'post_status'    => 'publish',
            'posts_per_page' => max( 1, absint( $atts['per_page'] ) ),
            'paged'          => $paged,
            'orderby'        => 'date',
            'order'          => 'DESC',
        );

        if ( ! empty( $atts['category'] ) ) {
            $args['tax_query'] = array(
                array(
                    'taxonomy' => self::CATEGORY_TAX,
                    'field'    => 'slug',
                    'terms'    => sanitize_title( $atts['category'] ),
                ),
            );
        }

        $query = new WP_Query( $args );

        ob_start();
        ?>
        <div class="dwqa-container classhall-forum<?php echo $is_compact ? ' classhall-forum-compact' : ''; ?>">
            <?php $this->render_message(); ?>
            <div class="dwqa-questions-list">
                <?php if ( $query->have_posts() ) : ?>
                    <?php
                    while ( $query->have_posts() ) :
                        $query->the_post();
                        ?>
                        <?php echo $is_compact ? $this->render_compact_question_list_item( get_the_ID() ) : $this->render_question_list_item( get_the_ID() ); ?>
                    <?php endwhile; ?>
                    <?php wp_reset_postdata(); ?>
                <?php else : ?>
                    <p class="classhall-forum-empty"><?php esc_html_e( 'No forum topics found.', 'classhall-forum' ); ?></p>
                <?php endif; ?>
            </div>
            <?php if ( ! $is_compact ) : ?>
                <?php
                $pagination = paginate_links(
                    array(
                        'total'   => $query->max_num_pages,
                        'current' => $paged,
                        'type'    => 'list',
                    )
                );

                if ( $pagination ) :
                    ?>
                    <div class="dwqa-page-numbers classhall-forum-pagination"><?php echo wp_kses_post( $pagination ); ?></div>
                <?php endif; ?>
            <?php endif; ?>
            <?php if ( ! $is_compact && is_user_logged_in() ) : ?>
                <p class="dwqa-ask-question"><a class="dwqa-btn dwqa-btn-primary" href="<?php echo esc_url( $this->get_ask_link() ); ?>"><?php esc_html_e( 'Post a question', 'classhall-forum' ); ?></a></p>
            <?php endif; ?>
        </div>
        <?php

        return ob_get_clean();
    }

    private function is_compact_shortcode_context( $atts ) {
        if ( ! empty( $atts['compact'] ) && in_array( strtolower( (string) $atts['compact'] ), array( '1', 'true', 'yes', 'sidebar' ), true ) ) {
            return true;
        }

        foreach ( array( 'widget_text', 'widget_text_content', 'widget_block_content', 'widget_custom_html_content' ) as $filter ) {
            if ( doing_filter( $filter ) ) {
                return true;
            }
        }

        return false;
    }

    public function submit_question_shortcode() {
        ob_start();
        ?>
        <div class="dwqa-container classhall-forum">
            <?php $this->render_message(); ?>
            <?php if ( ! is_user_logged_in() ) : ?>
                <p class="classhall-forum-notice"><?php esc_html_e( 'Please log in to post a question.', 'classhall-forum' ); ?></p>
                <?php wp_login_form(); ?>
            <?php else : ?>
                <form class="classhall-forum-form" method="post">
                    <?php wp_nonce_field( 'classhall_forum_ask_question', 'classhall_forum_nonce' ); ?>
                    <input type="hidden" name="classhall_forum_action" value="ask_question">
                    <p>
                        <label for="classhall_forum_title"><?php esc_html_e( 'Question title', 'classhall-forum' ); ?></label>
                        <input id="classhall_forum_title" type="text" name="classhall_forum_title" required>
                    </p>
                    <p>
                        <label for="classhall_forum_content"><?php esc_html_e( 'Details', 'classhall-forum' ); ?></label>
                        <textarea id="classhall_forum_content" name="classhall_forum_content" rows="8" required></textarea>
                    </p>
                    <?php $categories = get_terms( array( 'taxonomy' => self::CATEGORY_TAX, 'hide_empty' => false ) ); ?>
                    <?php if ( ! is_wp_error( $categories ) && ! empty( $categories ) ) : ?>
                        <p>
                            <label for="classhall_forum_category"><?php esc_html_e( 'Subject', 'classhall-forum' ); ?></label>
                            <select id="classhall_forum_category" name="classhall_forum_category">
                                <option value=""><?php esc_html_e( 'Select subject', 'classhall-forum' ); ?></option>
                                <?php foreach ( $categories as $category ) : ?>
                                    <option value="<?php echo esc_attr( $category->term_id ); ?>"><?php echo esc_html( $category->name ); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </p>
                    <?php endif; ?>
                    <p><button class="dwqa-btn dwqa-btn-primary" type="submit"><?php esc_html_e( 'Post a question', 'classhall-forum' ); ?></button></p>
                </form>
            <?php endif; ?>
        </div>
        <?php

        return ob_get_clean();
    }

    private function render_single_question( $question_id ) {
        $this->increment_views( $question_id );

        ob_start();
        ?>
        <div class="dwqa-container classhall-forum single-dwqa-question">
            <?php $this->render_message(); ?>
            <article class="dwqa-question-item">
                <div class="dwqa-question-meta">
                    <?php echo $this->render_author_line( $question_id, __( 'asked', 'classhall-forum' ) ); ?>
                </div>
                <div class="dwqa-question-content">
                    <?php echo wp_kses_post( wpautop( do_shortcode( get_post_field( 'post_content', $question_id ) ) ) ); ?>
                </div>
            </article>

            <section id="answers" class="dwqa-answers">
                <h2 class="dwqa-answers-title"><?php echo esc_html( sprintf( _n( '%s Answer', '%s Answers', $this->answer_count( $question_id ), 'classhall-forum' ), number_format_i18n( $this->answer_count( $question_id ) ) ) ); ?></h2>
                <div class="dwqa-answers-list">
                    <?php
                    $answers = $this->get_answers( $question_id );
                    if ( $answers ) :
                        foreach ( $answers as $answer ) :
                            ?>
                            <article class="dwqa-answer-item">
                                <div class="dwqa-answer-meta"><?php echo $this->render_author_line( $answer->ID, __( 'answered', 'classhall-forum' ) ); ?></div>
                                <div class="dwqa-answer-content"><?php echo wp_kses_post( wpautop( do_shortcode( $answer->post_content ) ) ); ?></div>
                            </article>
                            <?php
                        endforeach;
                    else :
                        ?>
                        <p class="classhall-forum-empty"><?php esc_html_e( 'No answers yet.', 'classhall-forum' ); ?></p>
                    <?php endif; ?>
                </div>
            </section>

            <?php echo $this->render_answer_form( $question_id ); ?>
        </div>
        <?php

        return ob_get_clean();
    }

    private function render_answer_form( $question_id ) {
        ob_start();
        ?>
        <div class="classhall-forum-answer-form">
            <?php if ( ! is_user_logged_in() ) : ?>
                <p class="classhall-forum-notice"><?php esc_html_e( 'Please log in to reply.', 'classhall-forum' ); ?></p>
            <?php else : ?>
                <form method="post">
                    <?php wp_nonce_field( 'classhall_forum_post_answer', 'classhall_forum_nonce' ); ?>
                    <input type="hidden" name="classhall_forum_action" value="post_answer">
                    <input type="hidden" name="classhall_forum_question_id" value="<?php echo esc_attr( $question_id ); ?>">
                    <p>
                        <label for="classhall_forum_answer"><?php esc_html_e( 'Your answer', 'classhall-forum' ); ?></label>
                        <textarea id="classhall_forum_answer" name="classhall_forum_answer" rows="7" required></textarea>
                    </p>
                    <p><button class="dwqa-btn dwqa-btn-primary" type="submit"><?php esc_html_e( 'Post Answer', 'classhall-forum' ); ?></button></p>
                </form>
            <?php endif; ?>
        </div>
        <?php

        return ob_get_clean();
    }

    private function render_question_list_item( $question_id ) {
        $answer_count = $this->answer_count( $question_id );
        $views        = absint( get_post_meta( $question_id, '_dwqa_views', true ) );

        ob_start();
        ?>
        <article class="dwqa-question-item">
            <div class="dwqa-question-title"><a href="<?php echo esc_url( get_permalink( $question_id ) ); ?>"><?php echo esc_html( get_the_title( $question_id ) ); ?></a></div>
            <div class="dwqa-question-meta">
                <?php echo $this->render_author_line( $question_id, __( 'asked', 'classhall-forum' ) ); ?>
                <?php echo get_the_term_list( $question_id, self::CATEGORY_TAX, '<span class="dwqa-question-category"> &bull; ', ', ', '</span>' ); ?>
            </div>
            <div class="dwqa-question-stats">
                <span class="dwqa-views-count"><strong><?php echo esc_html( number_format_i18n( $views ) ); ?></strong> <?php esc_html_e( 'views', 'classhall-forum' ); ?></span>
                <span class="dwqa-answers-count"><strong><?php echo esc_html( number_format_i18n( $answer_count ) ); ?></strong> <?php esc_html_e( 'answers', 'classhall-forum' ); ?></span>
            </div>
        </article>
        <?php

        return ob_get_clean();
    }

    private function render_compact_question_list_item( $question_id ) {
        ob_start();
        ?>
        <article class="dwqa-question-item classhall-forum-compact-item" style="padding:12px 14px !important; margin:0 !important; border-bottom:1px solid #eeeeee;">
            <div class="dwqa-question-title" style="margin:0 !important; line-height:1.4 !important;">
                <a href="<?php echo esc_url( get_permalink( $question_id ) ); ?>" style="font-size:14px !important; font-weight:400 !important; line-height:1.4 !important; text-decoration:none;">
                    <?php echo esc_html( get_the_title( $question_id ) ); ?>
                </a>
            </div>
        </article>
        <?php

        return ob_get_clean();
    }

    private function render_author_line( $post_id, $verb ) {
        $author_id = absint( get_post_field( 'post_author', $post_id ) );
        $name      = $author_id ? get_the_author_meta( 'display_name', $author_id ) : __( 'Anonymous', 'classhall-forum' );
        $url       = $author_id ? get_author_posts_url( $author_id ) : '';
        $time      = human_time_diff( get_post_time( 'U', true, $post_id ), current_time( 'timestamp', true ) );

        if ( $url ) {
            $author = sprintf( '<a href="%s">%s%s</a>', esc_url( $url ), get_avatar( $author_id, 48 ), esc_html( $name ) );
        } else {
            $author = esc_html( $name );
        }

        return sprintf(
            '<span>%1$s %2$s %3$s ago</span>',
            $author,
            esc_html( $verb ),
            esc_html( $time )
        );
    }

    private function get_answers( $question_id ) {
        return get_posts(
            array(
                'post_type'      => self::ANSWER_TYPE,
                'post_status'    => array( 'publish', 'private' ),
                'post_parent'    => $question_id,
                'posts_per_page' => 100,
                'orderby'        => 'date',
                'order'          => 'ASC',
            )
        );
    }

    private function answer_count( $question_id ) {
        $counts = wp_count_posts( self::ANSWER_TYPE );
        $answers = get_posts(
            array(
                'post_type'      => self::ANSWER_TYPE,
                'post_status'    => array( 'publish', 'private' ),
                'post_parent'    => $question_id,
                'fields'         => 'ids',
                'posts_per_page' => -1,
                'no_found_rows'  => true,
            )
        );

        return is_array( $answers ) ? count( $answers ) : 0;
    }

    private function increment_views( $question_id ) {
        if ( is_user_logged_in() && absint( get_post_field( 'post_author', $question_id ) ) === get_current_user_id() ) {
            return;
        }

        $views = absint( get_post_meta( $question_id, '_dwqa_views', true ) );
        update_post_meta( $question_id, '_dwqa_views', $views + 1 );
    }

    private function render_message() {
        if ( empty( $_GET['forum_message'] ) ) {
            return;
        }

        $messages = array(
            'login_required' => __( 'Please log in before posting.', 'classhall-forum' ),
            'missing_fields' => __( 'Please complete the required fields.', 'classhall-forum' ),
            'not_saved'      => __( 'Your post could not be saved. Please try again.', 'classhall-forum' ),
            'answer_posted'  => __( 'Your answer has been posted.', 'classhall-forum' ),
        );

        $key = sanitize_key( wp_unslash( $_GET['forum_message'] ) );

        if ( isset( $messages[ $key ] ) ) {
            echo '<p class="classhall-forum-message">' . esc_html( $messages[ $key ] ) . '</p>';
        }
    }

    private function get_question_slug() {
        $options = get_option( 'dwqa_options', array() );

        if ( ! empty( $options['question-rewrite'] ) ) {
            return sanitize_title( $options['question-rewrite'] );
        }

        return 'topic';
    }

    private function get_question_slugs() {
        $slugs = array( $this->get_question_slug(), 'topic', 'topics', 'question', 'questions' );
        $slugs = array_filter( array_map( 'sanitize_title', $slugs ) );

        return array_values( array_unique( $slugs ) );
    }

    private function get_category_slug() {
        $options = get_option( 'dwqa_options', array() );

        if ( ! empty( $options['question-category-rewrite'] ) ) {
            return sanitize_title( $options['question-category-rewrite'] );
        }

        return 'question-category';
    }

    private function get_ask_link() {
        $options = get_option( 'dwqa_options', array() );

        if ( ! empty( $options['pages']['submit-question'] ) && get_post( absint( $options['pages']['submit-question'] ) ) ) {
            return get_permalink( absint( $options['pages']['submit-question'] ) );
        }

        $page = get_page_by_path( 'dwqa-ask-question' );

        return $page ? get_permalink( $page ) : admin_url( 'post-new.php?post_type=' . self::QUESTION_TYPE );
    }

    private function ensure_legacy_pages() {
        $options = get_option( 'dwqa_options', array() );

        if ( ! is_array( $options ) ) {
            $options = array();
        }

        if ( empty( $options['pages'] ) || ! is_array( $options['pages'] ) ) {
            $options['pages'] = array();
        }

        if ( empty( $options['pages']['archive-question'] ) || ! get_post( absint( $options['pages']['archive-question'] ) ) ) {
            $page = get_page_by_path( 'dwqa-questions' );

            if ( ! $page ) {
                $page_id = wp_insert_post(
                    array(
                        'post_title'   => __( 'DWQA Questions', 'classhall-forum' ),
                        'post_type'    => 'page',
                        'post_status'  => 'publish',
                        'post_content' => '[dwqa-list-questions]',
                    )
                );
            } else {
                $page_id = $page->ID;
            }

            if ( ! empty( $page_id ) && ! is_wp_error( $page_id ) ) {
                $options['pages']['archive-question'] = absint( $page_id );
            }
        }

        if ( empty( $options['pages']['submit-question'] ) || ! get_post( absint( $options['pages']['submit-question'] ) ) ) {
            $page = get_page_by_path( 'dwqa-ask-question' );

            if ( ! $page ) {
                $page_id = wp_insert_post(
                    array(
                        'post_title'   => __( 'Post a Question', 'classhall-forum' ),
                        'post_type'    => 'page',
                        'post_status'  => 'publish',
                        'post_content' => '[dwqa-submit-question-form]',
                    )
                );
            } else {
                $page_id = $page->ID;
            }

            if ( ! empty( $page_id ) && ! is_wp_error( $page_id ) ) {
                $options['pages']['submit-question'] = absint( $page_id );
            }
        }

        update_option( 'dwqa_options', $options, false );
    }
}

Classhall_Forum_Compatibility::instance();
register_activation_hook( __FILE__, array( 'Classhall_Forum_Compatibility', 'activate' ) );
register_deactivation_hook( __FILE__, array( 'Classhall_Forum_Compatibility', 'deactivate' ) );

if ( ! function_exists( 'dwqa_question_answers_count' ) ) {
    function dwqa_question_answers_count( $question_id = 0 ) {
        $question_id = $question_id ? absint( $question_id ) : get_the_ID();

        return count(
            get_posts(
                array(
                    'post_type'      => Classhall_Forum_Compatibility::ANSWER_TYPE,
                    'post_status'    => array( 'publish', 'private' ),
                    'post_parent'    => $question_id,
                    'fields'         => 'ids',
                    'posts_per_page' => -1,
                    'no_found_rows'  => true,
                )
            )
        );
    }
}
