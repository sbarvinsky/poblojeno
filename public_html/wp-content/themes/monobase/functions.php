<?php
/**
 * Monobase functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Monobase
 */

if ( ! defined( 'MONOBASE_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( 'MONOBASE_VERSION', '1.1' );
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function monobase_setup() {
	/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on Monobase, use a find and replace
		* to change 'monobase' to the name of your theme in all the template files.
		*/
	load_theme_textdomain( 'monobase', get_template_directory() . '/languages' );

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
	register_nav_menus(
		array(
			'homepage'  => esc_html__( 'Home Page', 'monobase' ),
			'side-menu' => esc_html__( 'Side menu', 'monobase' ),
		)
	);

	/*
		* Switch default core markup for search form, comment form, and comments
		* to output valid HTML5.
		*/
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	add_theme_support( 'responsive-embeds' );

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);
}

add_action( 'after_setup_theme', 'monobase_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function monobase_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'monobase_content_width', 640 );
}

add_action( 'after_setup_theme', 'monobase_content_width', 0 );

/**
 * Enqueue scripts and styles.
 */
function monobase_scripts() {
	wp_enqueue_style( 'monobase-style', get_stylesheet_uri(), array(), MONOBASE_VERSION );
	wp_style_add_data( 'monobase-style', 'rtl', 'replace' );

	wp_enqueue_style( 'monobase-icon', get_template_directory_uri() . '/assets/icon/css/icons.css', array(), MONOBASE_VERSION );

	wp_enqueue_script( 'monobase', get_template_directory_uri() . '/js/script.js', array(), MONOBASE_VERSION, true );

	do_action( 'monobase_enqueue_scripts' );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}

add_action( 'wp_enqueue_scripts', 'monobase_scripts' );

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
 * Custom Menu Walker.
 */
require get_template_directory() . '/inc/class-mono-walker-side-menu.php';

// Include Theme Info page.
require get_template_directory() . '/inc/theme-info.php';
