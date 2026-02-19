<?php
/**
 * The sidebar with posts
 *
 * @package Monobase
 */

?>

<aside class="sidebar-posts" id="sidebar-posts">
    <section class="search-section" aria-label="<?php esc_attr_e('Site search','monobase'); ?>">
	    <?php get_search_form(); ?>

        <button class="toggle-posts button is-ghost is-action switcher" aria-controls="sidebar-posts" aria-label="<?php monobase_button_switcher_aria_label();?>">
	        <?php if ( is_front_page() && is_home() ) : ?>
                <span class="toggle-posts-text"><?php esc_html_e('Page', 'monobase');?></span>
	        <?php else : ?>
                <span class="toggle-posts-text"><?php esc_html_e('Category', 'monobase');?></span>
	        <?php endif; ?>
            <span class="mb-icon mb-icon-arrow-bar-to-left mb-icon-flip-x"></span>
        </button>

    </section>

        <div id="posts-box" class="posts-box">
            <ul class="post-list" role="list">
		        <?php

		        if ( is_singular( 'post' ) ) {
			        monobase_loop_single_sidebar();
		        } elseif ( is_home() || is_front_page() ) {
			        monobase_loop_home_sidebar();
		        } else {
			        monobase_loop_archive_sidebar();
		        }
		        ?>
            </ul>
        </div>

        <div class="sidebar-posts-footer" aria-label="<?php esc_attr_e( 'Posts pagination', 'monobase' ); ?>">
			<?php
			the_posts_pagination( [
				'mid_size'           => 1,
				'end_size'           => 0,
				'prev_text'          => '<span class="mb-icon mb-icon-chevron-right mb-icon-rotate-180" aria-hidden="true"></span><span class="screen-reader-text">' . esc_html__( 'Previous', 'monobase' ) . '</span>',
				'next_text'          => '<span class="mb-icon mb-icon-chevron-right" aria-hidden="true"></span><span class="screen-reader-text">' . esc_html__( 'Next', 'monobase' ) . '</span>',
				'type'               => 'list',
				'screen_reader_text' => ' ',
			] );
			?>
        </div>

	<?php do_action( 'monobase_sidebar_posts_after' ); ?>

</aside>
