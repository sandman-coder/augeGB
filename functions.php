<?php
/**
 * auge functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package auge
 */

if ( ! function_exists( 'auge_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function auge_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on auge, use a find and replace
		 * to change 'auge' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'auge', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'primary' => esc_html__( 'Primary', 'auge' ),
		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'auge_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support( 'custom-logo', array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		) );
	}
endif;
add_action( 'after_setup_theme', 'auge_setup' );

function auge_add_editor_style() {
	add_editor_style('dist/css/editor-style.css');
}
add_action('admin_init', 'auge_add_editor_style');

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function auge_content_width() {
	// This variable is intended to be overruled from themes.
	// Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
	$GLOBALS['content_width'] = apply_filters( 'auge_content_width', 1140 );
}
add_action( 'after_setup_theme', 'auge_content_width', 0 );



/**
 * Enqueue scripts and styles.
 */
function auge_scripts() {

	wp_enqueue_style('auge-bs-css' , get_template_directory_uri() .
	'/dist/css/editor-style.css');

	wp_enqueue_style('auge-bs-css' , get_template_directory_uri() .
	'/dist/css/bootstrap.css');

	wp_enqueue_style('auge-fontawesome' , get_template_directory_uri() .
	'/fonts/font-awesome/css/font-awesome.min.css' );

	wp_enqueue_style( 'auge-style', get_stylesheet_uri() );

	wp_register_script('popper',
	'https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.15.0/umd/popper.min.js', false, '', true);

	wp_enqueue_script('popper');

	wp_enqueue_script( 'auge-tether', get_template_directory_uri() .
	'/src/js/tether.min.js', array(), '20170115', true );

	wp_enqueue_script( 'auge-bootstrap', get_template_directory_uri() .
	'/src/js/bootstrap.min.js', array('jquery'), '20170195', true );

	wp_enqueue_script( 'auge-bootstrap-hover', get_template_directory_uri() .
	'/src/js/bootstrap-hover.js', array('jquery'), '20170115', true );

	wp_enqueue_script( 'auge-nav-scroll', get_template_directory_uri() .
	'/src/js/nav-scroll.js', array('jquery'), '20170195', true );

	wp_enqueue_script( 'auge-skip-link-focus-fix', get_template_directory_uri() .
	'/src/js/skip-link-focus-fix.js', array(), '20151215', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'auge_scripts' );

function auge_header_video_dequeue_script() {
	wp_dequeue_script( 'wp-custom-header' );
	wp_deregister_script( 'wp-custom-header' );
	wp_enqueue_script('wp-custom-header' , get_template_directory_uri() .
	'/dist/js/wp-custom-header.js', array(), '', 'true');
}
add_action( 'wp_print_scripts', 'auge_header_video_dequeue_script', 100);

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Widgets File.
 */
require get_template_directory() . '/inc/widgets.php';

/**
 * Bootstrap Navwalker File.
 */
require get_template_directory() . '/inc/bootstrap-wp-navwalker.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

/**
 * Load WooCommerce compatibility file.
 */
if ( class_exists( 'WooCommerce' ) ) {
	require get_template_directory() . '/inc/woocommerce.php';
}
