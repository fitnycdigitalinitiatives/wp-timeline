<?php
/**
 * Timeline Theme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package WP_Bootstrap_Starter
 */

if ( ! function_exists( 'wp_bootstrap_starter_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function wp_bootstrap_starter_setup() {

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 450, 450, true );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary', 'timeline-theme' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'comment-form',
		'comment-list',
		'caption',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'wp_bootstrap_starter_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

    function wp_boostrap_starter_add_editor_styles() {
        add_editor_style( 'custom-editor-style.css' );
    }
    add_action( 'admin_init', 'wp_boostrap_starter_add_editor_styles' );

}
endif;
add_action( 'after_setup_theme', 'wp_bootstrap_starter_setup' );

/**
 * Enqueue scripts and styles.
 */
function wp_bootstrap_starter_scripts() {
	// load bootstrap css
	wp_enqueue_style( 'timeline-theme-bootstrap-css', 'https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css' );
  // materialicons cdn
  wp_enqueue_style( 'timeline-theme-material-icons', 'https://fonts.googleapis.com/icon?family=Material+Icons' );
	// fontawesome
  wp_enqueue_style( 'timeline-theme-fontawesome', 'https://use.fontawesome.com/releases/v5.5.0/css/all.css' );
	// load Timeline Theme styles
	wp_enqueue_style( 'halyard', get_template_directory_uri() . '/inc/assets/fonts/halyard.css' );
	wp_enqueue_style( 'timeline-theme-style', get_stylesheet_uri() );
	if ( is_home() ) {
		wp_enqueue_style( 'owl-style', get_template_directory_uri() . '/inc/assets/js/owl/owl.carousel.min.css' );
		wp_enqueue_style( 'nouislider-style', get_template_directory_uri() . '/inc/assets/js/nouislider/nouislider.min.css' );
	}
	if ( is_page_template( 'single-view-timeline-page.php' ) ) {
		wp_enqueue_style( 'owl-style', get_template_directory_uri() . '/inc/assets/js/owl/owl.carousel.min.css' );
		wp_enqueue_style( 'nouislider-style', get_template_directory_uri() . '/inc/assets/js/nouislider/nouislider.min.css' );
	}
	if ( is_page_template( 'grid-view-timeline-page.php' ) ) {
		wp_enqueue_style( 'owl-style', get_template_directory_uri() . '/inc/assets/js/owl/owl.carousel.min.css' );
	}
    // Internet Explorer HTML5 support
    wp_enqueue_script( 'html5hiv',get_template_directory_uri().'/inc/assets/js/html5.js', array(), '3.7.0', false );
    wp_script_add_data( 'html5hiv', 'conditional', 'lt IE 9' );

	wp_enqueue_script('jquery');
	// load bootstrap js
  wp_enqueue_script('timeline-theme-popper', 'https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js', array(), '', true );
	wp_enqueue_script('timeline-theme-bootstrapjs', 'https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js', array(), '', true );
	wp_enqueue_script( 'timeline-theme-skip-link-focus-fix', get_template_directory_uri() . '/inc/assets/js/skip-link-focus-fix.min.js', array(), '20151215', true );
	if ( is_home() ) {
		wp_enqueue_script('timeline-theme-owljs', get_template_directory_uri() . '/inc/assets/js/owl/owl.carousel.min.js', array(), '', true );
		wp_enqueue_script('timeline-theme-nouislider', get_template_directory_uri() . '/inc/assets/js/nouislider/nouislider.min.js', array(), '', true );
		wp_enqueue_script('timeline-theme-timelineowl', get_template_directory_uri() . '/inc/assets/js/timeline-owl.js', array(), '', true );
		wp_enqueue_script('timeline-theme-tagowl', get_template_directory_uri() . '/inc/assets/js/tag-owl.js', array(), '', true );
	}
	if ( is_page_template( 'single-view-timeline-page.php' ) ) {
		wp_enqueue_script('timeline-theme-owljs', get_template_directory_uri() . '/inc/assets/js/owl/owl.carousel.min.js', array(), '', true );
		wp_enqueue_script('timeline-theme-nouislider', get_template_directory_uri() . '/inc/assets/js/nouislider/nouislider.min.js', array(), '', true );
		wp_enqueue_script('timeline-theme-singleowl', get_template_directory_uri() . '/inc/assets/js/single-owl.js', array(), '', true );
	}
	if ( is_page_template( 'grid-view-timeline-page.php' ) ) {
		wp_enqueue_script('timeline-theme-owljs', get_template_directory_uri() . '/inc/assets/js/owl/owl.carousel.min.js', array(), '', true );
		wp_enqueue_script('timeline-theme-tagowl', get_template_directory_uri() . '/inc/assets/js/tag-owl.js', array(), '', true );
	}

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'wp_bootstrap_starter_scripts' );


function wp_bootstrap_starter_password_form() {
    global $post;
    $label = 'pwbox-'.( empty( $post->ID ) ? rand() : $post->ID );
    $o = '<form action="' . esc_url( site_url( 'wp-login.php?action=postpass', 'login_post' ) ) . '" method="post">
    <div class="d-block mb-3">' . __( "To view this protected post, enter the password below:", "timeline-theme" ) . '</div>
    <div class="form-group form-inline"><label for="' . $label . '" class="mr-2">' . __( "Password:", "timeline-theme" ) . ' </label><input name="post_password" id="' . $label . '" type="password" size="20" maxlength="20" class="form-control mr-2" /> <input type="submit" name="Submit" value="' . esc_attr__( "Submit", "timeline-theme" ) . '" class="btn btn-primary"/></div>
    </form>';
    return $o;
}
add_filter( 'the_password_form', 'wp_bootstrap_starter_password_form' );


/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Need to create custom meta boxes for event dates.
 */
require get_template_directory() . '/inc/event-metadata.php';

/**
 * Load custom WordPress nav walker.
 */
if ( ! class_exists( 'wp_bootstrap_navwalker' )) {
    require_once(get_template_directory() . '/inc/wp_bootstrap_navwalker.php');
}




function oembed_youtube_add_wrapper($return, $data, $url) {
    if ($data->provider_name == 'YouTube') {
        return "<div class='embed-responsive embed-responsive-16by9'>{$return}</div>";
    } else {
        return $return;
    }
}
add_filter('oembed_dataparse','oembed_youtube_add_wrapper',10,3);

function timeline_remove_sections( $wp_customize ) {
    $wp_customize->remove_section( 'typography' );
		$wp_customize->remove_section( 'header_image' );
		$wp_customize->remove_section( 'title_tagline' );
}
add_action( 'customize_register', 'timeline_remove_sections' );

function timeline_customizer_register($wp_customize) {
	//TIMELINE DIVIDER
	function timeline_sanitize_divider( $input ) {
	    $valid = array(
	        'Year' => 'Year',
	        'Decade' => 'Decade'
	    );

	    if ( array_key_exists( $input, $valid ) ) {
	        return $input;
	    } else {
	        return '';
	    }
	}

	//ADD GENERAL SECTION
	$wp_customize->add_section( 'timeline_customizer_timeline_section', array(
		'title' => __( 'Timeline Settings', 'timeline' ),
		'priority' => 1
	));

	//TIMELINE DIVIDER
	$wp_customize->add_setting('timeline_customizer_divider', array(
			'capability'     => 'edit_theme_options',
			'default'        => 'Decade',
			'sanitize_callback' => 'timeline_sanitize_divider'
	));
	$wp_customize->add_control( 'timeline_customizer_divider', array(
			'label'   => __('Timeline Divider','timeline'),
			'section' => 'timeline_customizer_timeline_section',
			'type'    => 'select',
			'choices' => array('Year' => 'Year','Decade' => 'Decade'),
			'settings' => 'timeline_customizer_divider',
			'priority' => 1
	));
}

add_action( 'customize_register', 'timeline_customizer_register' );
