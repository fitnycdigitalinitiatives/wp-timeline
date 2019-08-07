<?php
/**
 * Template part for displaying posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WP_Bootstrap_Starter
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<header class="entry-header">
		<?php if ( is_single() ) : ?>
			<h1 class="mb-4 entry-title">
				<?php the_title() ?>
				<?php if (get_post_meta( $post->ID, 'start_date', true )): ?>
				<?php $start_year =  date("Y", strtotime(get_post_meta( $post->ID, 'start_date', true ))); ?>
				<br>
				<small class="text-muted">
					<?php
					if (get_post_meta( $post->ID, 'end_date', true )):
						$end_year =  date("Y", strtotime(get_post_meta( $post->ID, 'end_date', true )));
						if ($start_year == $end_year):
							echo date("F j", strtotime(get_post_meta( $post->ID, 'start_date', true ))) . ' - ' . date("F j, Y", strtotime(get_post_meta( $post->ID, 'end_date', true )));
						else:
							echo date("F j, Y", strtotime(get_post_meta( $post->ID, 'start_date', true ))) . ' - ' . date("F j, Y", strtotime(get_post_meta( $post->ID, 'end_date', true )));
						endif;
					else:
						echo date("F j, Y", strtotime(get_post_meta( $post->ID, 'start_date', true )));
					endif;
					?>
				</small>
				<?php endif; ?>
			</h1>
		<?php else : ?>
			<h2 class="mb-4 entry-title">
				<a href="<?php esc_url( get_permalink() ); ?>" rel="bookmark">
					<?php the_title() ?>
				</a>
				<?php if (get_post_meta( $post->ID, 'start_date', true )): ?>
				<?php $start_year =  date("Y", strtotime(get_post_meta( $post->ID, 'start_date', true ))); ?>
				<br>
				<small class="text-muted">
					<?php
					if (get_post_meta( $post->ID, 'end_date', true )):
						$end_year =  date("Y", strtotime(get_post_meta( $post->ID, 'end_date', true )));
						if ($start_year == $end_year):
							echo date("F j", strtotime(get_post_meta( $post->ID, 'start_date', true ))) . ' - ' . date("F j, Y", strtotime(get_post_meta( $post->ID, 'end_date', true )));
						else:
							echo date("F j, Y", strtotime(get_post_meta( $post->ID, 'start_date', true ))) . ' - ' . date("F j, Y", strtotime(get_post_meta( $post->ID, 'end_date', true )));
						endif;
					else:
						echo date("F j, Y", strtotime(get_post_meta( $post->ID, 'start_date', true )));
					endif;
					?>
				</small>
				<?php endif; ?>
			</h2>
		<?php endif; ?>
	</header><!-- .entry-header -->
	<div class="entry-content">
		<?php
        if ( is_single() ) :
			the_content();
        else :
            the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'timeline-theme' ) );
        endif;

			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'timeline-theme' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->

	<div class="entry-footer">
		<?php wp_bootstrap_starter_entry_footer(); ?>
	</div><!-- .entry-footer -->
</article><!-- #post-## -->
