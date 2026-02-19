<?php
/**
 * The sidebar with the Side menu
 *
 * @package Monobase
 */

$monobase_site_description = get_bloginfo( 'description', 'display' );
$monobase_site_blogname    = get_bloginfo( 'name', 'display' );
?>

<div class="site-sidebar" id="sidebar">

    <?php
    wp_nav_menu( [
            'theme_location'       => 'side-menu',
//			'depth'                => 2,
            'container'            => 'nav',
            'container_class'      => 'navigation',
            'container_aria_label' => monobase_side_menu_container_aria_label(),
            'menu_id'              => 'site-menu',
            'menu_class'           => 'site-menu',
            'walker'               => new Mono_Walker_Side_Menu(),
            'fallback_cb'          => false,
    ] ); ?>

    <footer id="colophon" class="site-footer">

        <div class="footer-box">

            <?php monobase_site_logo(); ?>

            <div class="footer-info">
                <?php if ( $monobase_site_blogname ) : ?>
                    <div class="footer-blog-name">
                        <a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php echo esc_html( $monobase_site_blogname ); ?></a>
                    </div>
                <?php endif; ?>

                <?php if ( $monobase_site_description ) : ?>
                    <div class="footer-text">
                        <?php echo wp_kses_post( $monobase_site_description ); ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <?php do_action( 'monobase_footer_menu' ); ?>

    </footer>
</div>
