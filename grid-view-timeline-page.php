<?php
/**
* Template Name: Grid View
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
if( $posts ):
?>

	<div class="container-fluid">
		<div class="row align-items-center justify-content-around" id="tag-viewport">
			<div class="col-auto d-none d-md-block order-first">
				<button type="button" class="btn btn-light px-3" id="previous-tag">
					<i class="fas fa-chevron-left text-dark"></i>
					<span class="sr-only">Previous tags</span>
				</button>
			</div>
			<div class="col-auto d-none d-md-block order-last">
				<button type="button" class="btn btn-light px-3" id="next-tag">
					<i class="fas fa-chevron-right text-dark"></i>
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

	<div class="container" id="grid-view">
				<?php
				$postGroups = array();
				foreach ( $posts as $post ) :
					setup_postdata( $post );
					if (get_post_meta( $post->ID, 'start_date', true )):
						$start_year =  date("Y", strtotime(get_post_meta( $post->ID, 'start_date', true )));
						$current_decade = substr_replace($start_year,'0s',3);
					else:
						$start_year = 'undated';
						$current_decade = 'undated';
					endif;
					$postGroups[$current_decade][] = $post;
				endforeach;
				wp_reset_postdata();
				?>
				<?php	foreach ($postGroups as $group_decade => $group) : ?>
					<h1>
						<?php echo $group_decade; ?>
					</h1>
					<div class="card-deck pt-3">
					<?php
					foreach ($group as $post) :
					setup_postdata( $post );
					?>
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
										<h2 class="text-center mb-0 text-break"><?php echo wp_trim_words(the_title($before = '', $after = '', $echo = false), 7); ?></h2>
									</div>
							</a>
					<?php
					endforeach;
					wp_reset_postdata();
					?>
					</div>
				<?php	endforeach; ?>

	</div>
<?php endif; ?>
<?php
get_footer();
