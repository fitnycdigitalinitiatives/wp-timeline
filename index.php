<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WP_Bootstrap_Starter
 */

get_header(); ?>

<?php // get all posts
$posts = get_posts(array(
	'posts_per_page'	=> -1,
	'orderby' => 'meta_value',
	'meta_key' => 'start_date',
	'order' => 'ASC'
));
$prev_divider = '';
$timelineDivider = get_theme_mod('timeline_customizer_divider','Decade');
if( $posts ):
?>

	<div class="container-fluid">
		<div class="row align-items-center justify-content-around" id="tag-viewport">
			<div class="col-auto d-none d-md-block order-first">
				<button type="button" class="btn btn-light px-3" id="previous-tag">
					<span class="fas fa-chevron-left text-dark"></span>
					<span class="sr-only">Previous tags</span>
				</button>
			</div>
			<div class="col-auto d-none d-md-block order-last">
				<button type="button" class="btn btn-light px-3" id="next-tag">
					<span class="fas fa-chevron-right text-dark"></span>
					<span class="sr-only">Next tags</span>
				</button>
			</div>
			<div class="col overflow-hidden">
				<div class="owl-carousel" id="tag-carousel">
					<?php	$tags = get_tags(array('orderby' => 'count', 'order'   => 'DESC')); ?>
					<?php	foreach ( $tags as $tag ) : ?>
						<div class="tag p-2 bg-light small rounded d-inline-block">
							<a href="<?php echo get_term_link($tag); ?>" class="text-dark">
								<?php echo $tag->name; ?>
							</a>
						</div>
					<?php	endforeach; ?>
					<?php	$categories = get_categories(array('orderby' => 'count', 'order'   => 'DESC')); ?>
					<?php	foreach ( $categories as $category ) : ?>
						<div class="tag p-2 bg-light small rounded d-inline-block">
							<a href="<?php echo get_term_link($category); ?>" class="text-dark">
								<?php echo $category->name; ?>
							</a>
						</div>
					<?php	endforeach; ?>
				</div>
			</div>
		</div>

		<div class="row align-items-center" id="timeline-viewport">
			<div class="owl-carousel" id="event-carousel">
				<?php	foreach ( $posts as $post ) : ?>
					<?php
					setup_postdata( $post );
					if (get_post_meta( $post->ID, 'start_date', true )):
						$start_year =  date("Y", strtotime(get_post_meta( $post->ID, 'start_date', true )));
						if ($timelineDivider == 'Decade'):
							$current_divider = substr_replace($start_year,'0s',3);
						elseif ($timelineDivider == 'Year'):
							$current_divider = $start_year;
						endif;
					else:
						$start_year = 'undated';
						$current_divider = 'undated';
					endif;
					?>
					<div class="card text-white shadow" data-dateStart="<?php echo $start_year; ?>" data-hash="<?php echo urlencode(the_title($before = '', $after = '', $echo = false)); ?>">
						<?php	if ( $current_divider != $prev_divider ) : ?>
						<h2 class="decade text-dark font-italic"><?php echo $current_divider; ?></h2>
						<?php endif; ?>
						<?php if (has_post_thumbnail()) : ?>
							<?php the_post_thumbnail( $size = 'post-thumbnail', array( 'class' => 'card-img' ) ); ?>
						<?php else: ?>
						<svg class="card-img" width="400px" height="400px" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img" aria-label="Placeholder: Event image">
							<title>Placeholder</title>
							<rect width="100%" height="100%" fill="#868e96"></rect>
						</svg>
						<?php endif; ?>

						<div class="card-img-overlay d-flex justify-content-center align-items-center rounded">
							<h1 class="mb-0 text-center event-title text-break">
								<a href="<?php echo get_permalink(); ?>" class="text-white">
									<?php echo wp_trim_words(the_title($before = '', $after = '', $echo = false), 7); ?>
								</a>
							</h1>
							<?php if (get_post_meta( $post->ID, 'start_date', true )): ?>
							<p class="small event-date position-absolute mb-0">
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
							</p>
							<?php endif; ?>
						</div>
					</div>
					<?php
					if ($timelineDivider == 'Decade'):
						$prev_divider = substr_replace($start_year,'0s',3);
					elseif ($timelineDivider == 'Year'):
						$prev_divider = $start_year;
					endif;
					?>
				<?php	endforeach; ?>
				<?php	wp_reset_postdata(); ?>
			</div>
		</div>
		<div class="row align-items-center justify-content-center py-3" id="slider-nav-viewport">
			<div class="col-auto d-none d-md-block order-first">
				<button type="button" class="btn btn-gold px-3 text-white" id="previous">
					<span class="fas fa-chevron-left text-white"></span>
					<span class="sr-only">Previous slide</span>
				</button>
			</div>
			<div class="col-auto d-none d-md-block order-last">
				<button type="button" class="btn btn-gold px-3 text-white" id="next">
					<span class="fas fa-chevron-right text-white"></span>
					<span class="sr-only">Next slide</span>
				</button>
			</div>
			<div class="col mx-2 mx-md-0">
				<div class="w-100" id="range-slider" aria-hidden="true"></div>
			</div>
		</div>

	</div>
<?php endif; ?>
<?php
get_footer();
