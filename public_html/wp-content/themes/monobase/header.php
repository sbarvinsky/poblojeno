<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Monobase
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">
    <a class="skip-link screen-reader-text"
       href="#primary"><?php esc_html_e( 'Skip to content', 'monobase' ); ?></a>

    <header id="masthead" class="site-header">

        <div class="branding">
	        <?php monobase_site_logo(); ?>
            <p class="title"><?php bloginfo( 'name' ); ?></p>
        </div>

        <button id="menu-toggle" class="menu-toggle button" aria-expanded="false" aria-controls="sidebar" aria-label="<?php esc_attr_e( 'Toggle menu"', 'monobase' ); ?>">
            <span class="mb-icon mb-icon-menu" aria-hidden="true"></span>
            <span class="mb-icon mb-icon-plus" aria-hidden="true"></span>
        </button>

    </header>
