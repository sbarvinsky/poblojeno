<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package Monobase
 */

add_filter( 'get_the_archive_title', static function ( $title ) {
	return preg_replace( '~^[^:]+: ~', '', $title );
} );

add_filter( 'get_the_archive_description', static function ( $desc ) {
	return do_shortcode( $desc ); // run shortcodes on any archive description
}, 12 );


add_filter( 'body_class', static function ( $classes ) {
	$appearance = get_theme_mod( 'monobase_appearance' );
	$mode       = $appearance['theme_mode'] ?? 'light';
	if ( $mode === 'dark' ) {
		$classes[] = 'theme-dark';
	}

	if ( isset($_COOKIE['theme-mode']) ) {

		if($_COOKIE['theme-mode'] === 'dark') {
			$classes[] = 'theme-dark';
		} else {
			$classes = array_diff( $classes, ['theme-dark'] );
		}
	}

	return $classes;
} );
