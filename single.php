<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package WP_Bootstrap_Starter
 */

get_header(); ?>

	<div class="container mt-5">
		<div class="row justify-content-center">
			<div class="col-md-10 col-lg-8">

			<?php
			while ( have_posts() ) : the_post();

				get_template_part( 'template-parts/content', get_post_format() );

				// If comments are open or we have at least one comment, load up the comment template.
				if ( comments_open() || get_comments_number() ) :
					comments_template();
				endif;

			endwhile; // End of the loop.
			?>
			</div><!-- .col -->
		</div><!-- .row -->
	</div><!-- .container -->

<?php
get_footer();
