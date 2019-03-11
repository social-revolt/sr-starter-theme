<?php
	
	add_action( 'after_setup_theme', 'srStarter_setup' );
	
	function srStarter_setup() {
		load_theme_textdomain( 'srStarter', get_template_directory() . '/languages' );
		add_theme_support( 'title-tag' );
		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'html5', array( 'search-form' ) );
		global $content_width;
		
		if ( ! isset( $content_width ) ) { $content_width = 1920; }
			register_nav_menus( array( 'main-menu' => esc_html__( 'Main Menu', 'srStarter' ) ) );
		}
		
		add_action( 'wp_enqueue_scripts', 'srStarter_load_scripts' );
		
		function srStarter_load_scripts() {
			wp_enqueue_style( 'srStarter-style', get_stylesheet_uri() );
			wp_enqueue_script( 'jquery' );
		}

		add_action( 'wp_footer', 'srStarter_footer_scripts' );
		
		function srStarter_footer_scripts() {

		}
		
		add_filter( 'document_title_separator', 'srStarter_document_title_separator' );
		function srStarter_document_title_separator( $sep ) {
			$sep = '|';
			return $sep;
		}
	
		add_filter( 'the_title', 'srStarter_title' );
		function srStarter_title( $title ) {
			if ( $title == '' ) {
				return '...';
			} else {
				return $title;
			}
		}

		add_filter( 'the_content_more_link', 'srStarter_read_more_link' );
		function srstarter_read_more_link() {
			if ( ! is_admin() ) {
				return ' <a href="' . esc_url( get_permalink() ) . '" class="more-link">...</a>';
			}
		}

		add_filter( 'excerpt_more', 'srStarter_excerpt_read_more_link' );
		function srStarter_excerpt_read_more_link( $more ) {
			if ( ! is_admin() ) {
				global $post;
				return ' <a href="' . esc_url( get_permalink( $post->ID ) ) . '" class="more-link">...</a>';
			}
		}

		add_filter( 'intermediate_image_sizes_advanced', 'srStarter_image_insert_override' );
		function srStarter_image_insert_override( $sizes ) {
			unset( $sizes['medium_large'] );
			return $sizes;
		}

		add_action( 'widgets_init', 'srStarter_widgets_init' );
		function srStarter_widgets_init() {
			register_sidebar( array(
				'name' => esc_html__( 'Sidebar Widget Area', 'srStarter' ),
				'id' => 'primary-widget-area',
				'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
				'after_widget' => '</li>',
				'before_title' => '<h3 class="widget-title">',
				'after_title' => '</h3>',
			) );
		}

		add_action( 'wp_head', 'srStarter_pingback_header' );
		function srStarter_pingback_header() {
			if ( is_singular() && pings_open() ) {
				printf( '<link rel="pingback" href="%s" />' . "\n", esc_url( get_bloginfo( 'pingback_url' ) ) );
			}
		}

		add_action( 'comment_form_before', 'srStarter_enqueue_comment_reply_script' );
		function srStarter_enqueue_comment_reply_script() {
			if ( get_option( 'thread_comments' ) ) {
				wp_enqueue_script( 'comment-reply' );
			}
		}

		add_filter( 'get_comments_number', 'srStarter_comment_count', 0 );
		function srStarter_comment_count( $count ) {
			if ( ! is_admin() ) {
				global $id;
				$get_comments = get_comments( 'status=approve&post_id=' . $id );
				$comments_by_type = separate_comments( $get_comments );
				return count( $comments_by_type['comment'] );
			} else {
				return $count;
			}
		}