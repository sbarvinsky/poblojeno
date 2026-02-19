<?php
/**
 * Theme Info
 *
 * Adds a simple Theme Info page to the Appearance section of the WordPress Dashboard.
 *
 * @package monobase
 */

/**
 * Add Theme Info page to admin menu
 */
function monobase_theme_info_menu_link() {

	// Get theme details.
	$theme = wp_get_theme();

	add_theme_page(
		sprintf( __( 'Welcome to %1$s %2$s', 'monobase' ), $theme->display( 'Name' ), $theme->display( 'Version' ) ),
		__( 'Theme Settings', 'monobase' ),
		'edit_theme_options',
		'monobase',
		'monobase_theme_info_page',
		1
	);
}

add_action( 'admin_menu', 'monobase_theme_info_menu_link' );

/**
 * Display Theme Info page
 */
function monobase_theme_info_page() {

	// Get theme details.
	$theme = wp_get_theme();
	?>

    <div class="wowp wrap theme-info-wrap">

        <h1><?php printf( __( 'Welcome to %1$s %2$s', 'monobase' ), $theme->display( 'Name' ), $theme->display( 'Version' ) ); ?></h1>

        <div class="theme-description"><?php echo esc_html( $theme->display( 'Description' ) ); ?></div>

        <hr>
        <div class="important-links clearfix">
            <p><strong><?php esc_html_e( 'Theme Links', 'monobase' ); ?>:</strong>
                <a href="https://themes.wow-company.com/monobase-pro/"
                   target="_blank"><?php esc_html_e( 'PRO Demo', 'monobase' ); ?></a>

                <a href="https://wordpress.org/support/theme/monobase/reviews/" target="_blank">
                    <?php esc_html_e( 'Rate this theme', 'monobase' ); ?>
                </a>
                <a href="https://support.wow-company.com/" target="_blank">
		            <?php esc_html_e( 'Support', 'monobase' ); ?>
                </a>

            </p>
        </div>
        <hr>

        <div id="getting-started">

            <h3><?php printf( __( 'Getting Started with %s', 'monobase' ), $theme->display( 'Name' ) ); ?></h3>

            <div class="columns-wrapper clearfix">

                <div class="column column-half clearfix">

                    <div class="section">
                        <h4><?php esc_html_e( 'Theme Documentation', 'monobase' ); ?></h4>

                        <p class="about">
							<?php esc_html_e( 'You need help to setup and configure this theme? We got you covered with an extensive theme documentation on our website.', 'monobase' ); ?>
                        </p>
                        <p>
                            <a href="https://wow-estore.com/documentations/monobase/"
                               target="_blank" class="button button-secondary">
								<?php printf( __( 'View %s Documentation', 'monobase' ), 'Monobase' ); ?>
                            </a>
                        </p>
                    </div>

                    <div class="section">
                        <h4><?php esc_html_e( 'Theme Options', 'monobase' ); ?></h4>

                        <p class="about">
							<?php printf( __( '%s makes use of the Customizer for all theme settings. Click on "Customize Theme" to open the Customizer now.', 'monobase' ), $theme->display( 'Name' ) ); ?>
                        </p>
                        <p>
                            <a href="<?php echo wp_customize_url(); ?>"
                               class="button button-primary"><?php esc_html_e( 'Customize Theme', 'monobase' ); ?></a>
                        </p>
                    </div>

                </div>

                <div class="column column-half clearfix">

                    <img src="<?php echo esc_url( get_template_directory_uri() ); ?>/screenshot.png"/>

                </div>

            </div>

        </div>

        <hr>

        <div id="more-features">

			<?php if ( ! class_exists( '\Monobase\WOWP_Plugin' ) ): ?>

                <h3><?php esc_html_e( 'Get more features', 'monobase' ); ?></h3>

                <div class="columns-wrapper clearfix">

                    <div class="column column-half clearfix">

                        <div class="section">
                            <h4><?php esc_html_e( 'Pro Version Add-on', 'monobase' ); ?></h4>

                            <p class="about">
								<?php printf( __( 'Purchase the %s Pro Add-on and get additional features and advanced customization options.', 'monobase' ), 'monobase' ); ?>
                            </p>
                            <p>
                                <a href=" https://wow-estore.com/item/monobase-pro/ "
                                   target="_blank" class="button button-secondary">
									<?php printf( __( 'Learn more about %s Pro', 'monobase' ), 'Monobase' ); ?>
                                </a>
                            </p>
                        </div>

                    </div>
                </div>
			<?php else:
				do_action( 'monobase_theme_info_page_after_pro_features' );
				?>

			<?php endif; ?>

        </div>

        <hr>

        <div id="theme-author">
            <p>
				<?php printf( __( '%1$s is proudly brought to you by %2$s. If you like this theme, %3$s :)', 'monobase' ),
					$theme->display( 'Name' ),
					'<a target="_blank" href="https://profiles.wordpress.org/wpcalc/" title="Wow-Company">Wow-Company</a>',
					'<a target="_blank" href="https://wordpress.org/support/theme/monobase/reviews/" title="' . esc_attr__( 'Review IKnowledgeBase', 'monobase' ) . '">' . esc_html__( 'rate it', 'monobase' ) . '</a>'
				); ?>
            </p>

        </div>

    </div>

	<?php
}

/**
 * Enqueues CSS for Theme Info page
 *
 * @param int $hook Hook suffix for the current admin page.
 */
function monobase_theme_info_page_css( $hook ) {

	// Load styles and scripts only on theme info page.
	if ( 'appearance_page_monobase' !== $hook ) {
		return;
	}

	// Embed theme info css style.
	wp_enqueue_style( 'monobase-theme-info-css', get_template_directory_uri() . '/assets/css/theme-info.css' );

}

add_action( 'admin_enqueue_scripts', 'monobase_theme_info_page_css' );
