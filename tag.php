<?php
/**
 * The template for displaying archive pages
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WP_Bootstrap_Starter
 */

get_header(); ?>

<?php if ( have_posts() ) : ?>
	<div class="container mt-5" id="grid-view">

		<header class="page-header">
			<h1>
				<?php single_tag_title(); ?>
			</h1>
		</header><!-- .page-header -->

		<div class="card-deck pt-3">

			<?php /* Start the Loop */ while ( have_posts() ) : the_post(); ?>
				<a href="<?php the_permalink(); ?>" class="card text-white">
	        <?php if (has_post_thumbnail()): ?>
	          <?php the_post_thumbnail('post-thumbnail', array('class' => 'card-img')); ?>
					<?php else: ?>
						<svg class="card-img" width="400px" height="400px" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img" aria-label="Placeholder: Event image">
							<title>Placeholder</title>
							<rect width="100%" height="100%" fill="#868e96"></rect>
						</svg>
	        <?php endif; ?>
	          <div class="card-img-overlay d-flex justify-content-center align-items-end rounded">
	            <h2 class="text-center mb-0"><?php echo wp_trim_words(the_title($before = '', $after = '', $echo = false), 7); ?></h2>
	          </div>
	      </a>
			<?php endwhile; ?>

		</div>

		<?php the_posts_navigation(array('prev_text' => __( 'Next' ), 'next_text' => __( 'Previous' ))); ?>

	</div><!-- .container -->

<?php else : ?>

	<div class="container mt-5">
		<div class="row justify-content-center">

			<?php get_template_part( 'template-parts/content', 'none' ); ?>

		</div><!-- .row -->
	</div><!-- .container -->

<?php endif; ?>


<?php
get_footer();
