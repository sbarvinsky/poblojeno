<?php
/**
 * Template part for displaying results in search pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Monobase
 */


?>

<div class="page-content" id="primary">
    <section class="search-section" aria-label="<?php esc_attr_e( 'Site search', 'monobase' ); ?>">
		<?php get_search_form(); ?>
    </section>

	<?php if ( have_posts() ) : ?>
        <div id="posts-box" class="posts-box">
            <ul class="post-list" role="list">
				<?php while ( have_posts() ) : the_post(); ?>
                    <li class="post-item<?php if ( monobase_post_has_date() ) {
						echo ' has-date';
					} ?>" role="listitem">
                        <a href="<?php the_permalink(); ?>"
                           class="post-link" <?php if ( is_singular() && get_the_ID() === get_queried_object_id() ) {
							echo ' aria-current="page"';
						} ?> aria-label="<?php echo esc_attr( get_the_title() ); ?>"></a>
                        <span class="post-title"><?php the_title(); ?></span>
						<?php if ( monobase_post_has_date() ) : ?>
                            <time class="post-time" datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>">
								<?php echo esc_html( get_the_date() ); ?>
                            </time>
						<?php endif; ?>
                        <div class="post-description"><?php echo wp_kses_post( get_the_excerpt() ); ?></div>
                        <span class="post-icon mb-icon mb-icon-chevron-right" aria-hidden="true"></span>

                    </li>
				<?php endwhile; ?>
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

	<?php else : ?>
		<?php get_template_part( 'template-parts/content', 'none' ); ?>
	<?php endif; ?>

</div>