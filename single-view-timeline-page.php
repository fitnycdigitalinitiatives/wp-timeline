<?php
/**
* Template Name: Single View Timeline
*
* @package WordPress
* @subpackage Timeline Theme
*/

get_header(); ?>

<?php // get all posts
$posts = get_posts(array(
	'posts_per_page'	=> -1,
	'orderby' => 'meta_value',
	'meta_key' => 'start_date',
	'order' => 'ASC'
));
$prev_decade = '';
if( $posts ):
?>

	<div class="container-fluid">
		<div class="row align-items-center" id="single-viewport">
	    <div class="owl-carousel" id="single-carousel">
				<?php	foreach ( $posts as $post ) : ?>
					<?php
					setup_postdata( $post );
					if (get_post_meta( $post->ID, 'start_date', true )):
						$start_year =  date("Y", strtotime(get_post_meta( $post->ID, 'start_date', true )));
						$current_decade = substr_replace($start_year,'0s',3);
					else:
						$start_year = 'undated';
						$current_decade = 'undated';
					endif;
					?>

					<div class="card text-white shadow" data-dateStart="<?php echo $start_year; ?>" data-hash="<?php echo urlencode(the_title($before = '', $after = '', $echo = false)); ?>">
						<?php	if ( $current_decade != $prev_decade ) : ?>
						<h2 class="decade text-dark font-italic"><?php echo $current_decade; ?></h2>
						<?php endif; ?>
						<?php if ($media = get_attached_media( 'image' )) :
							$image = reset($media);
						?>
							<?php echo wp_get_attachment_image($image->ID, $size = 'full', $icon = false, $attr = array( 'class' => 'card-img' )); ?>
						<?php elseif (has_post_thumbnail()) : ?>
							<?php the_post_thumbnail( $size = 'full', array( 'class' => 'card-img' ) ); ?>
						<?php else: ?>
						<svg class="card-img" width="400px" height="400px" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img" aria-label="Placeholder: Event image">
							<title>Placeholder</title>
							<rect width="100%" height="100%" fill="#868e96"></rect>
						</svg>
						<?php endif; ?>

						<div class="card-img-overlay d-flex justify-content-end align-items-center rounded">
		          <div class="col-12 col-md-9 col-lg-7 col-xl-6">
								<?php if (get_post_meta( $post->ID, 'start_date', true )): ?>
		            <h2 class="event-date mb-0">
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
		            </h2>
								<?php endif; ?>
		            <h1 class="event-title d-none d-md-block text-break">
		              <?php echo wp_trim_words(the_title($before = '', $after = '', $echo = false), 7); ?>
		            </h1>
		            <div class="d-none d-md-block event-description">
		              <?php the_excerpt(); ?>
		            </div>
	              <a class="text-white" href="<?php echo get_permalink(); ?>">
									<p class="d-none d-md-block">
	                	Continue reading
									</p>
									<h1 class="event-title d-md-none text-break">
			            	<?php echo wp_trim_words(the_title($before = '', $after = '', $echo = false), 7); ?>
			            </h1>
	              </a>
		          </div>
		        </div>
					</div>
					<?php	$prev_decade = substr_replace($start_year,'0s',3);; ?>
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
				<div class="w-100" id="range-slider"></div>
			</div>
		</div>

	</div>
<?php endif; ?>
<?php
get_footer();
