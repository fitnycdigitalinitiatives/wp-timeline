<?php

$meta_boxes = array(

'start-event-metadata' => array(
	'key' => 'start_date',
	'title' => __('Start Date','wp-timeline'),
	'description' => __('At least a starting date is required.','wp-timeline')
),
'end-event-metadata' => array(
	'key' => 'end_date',
	'title' => __('End Date','wp-timeline'),
	'description' => null
)


);
function create_meta_box() {
	if( function_exists( 'add_meta_box' ) ) {
		add_meta_box( 'new-meta-boxes', __('Event Metadata','wp-timeline'), 'display_meta_box', 'post', 'side', 'high' );
	}
}
function display_meta_box() {
	global $post, $meta_boxes;
?>
<div class="form-wrap">
<input type="hidden" name="not_quick_edit" value="true" />
<?php wp_nonce_field( plugin_basename( __FILE__ ), 'event_metadata_wpnonce', false, true );
foreach($meta_boxes as $meta_box) {
	$data = get_post_meta($post->ID, $meta_box['key'], true);
?>
<div class="form-field form-required">
	<label for="<?php echo $meta_box[ 'key' ]; ?>"><?php echo $meta_box[ 'title' ]; ?></label>
	<input type="date" name="<?php echo $meta_box[ 'key' ]; ?>" value="<?php if(isset($data)){echo htmlspecialchars( $data );} ?>" />
	<?php if ($meta_box[ 'description' ]): ;?>
		<p><?php echo $meta_box[ 'description' ]; ?></p>
	<?php endif ;?>
</div>
<?php } ?>
</div>
<?php
}
function save_meta_box( $post_id ) {
	global $post, $meta_boxes;
	// Only do this if our custom flag is present
  if (isset($_POST['not_quick_edit'])) {
		foreach( $meta_boxes as $meta_box ) {
			$data = isset($_POST[$meta_box[ 'key' ] ]) ? $_POST[$meta_box[ 'key' ] ] : '';
			if ( !isset($_POST['event_metadata_wpnonce']) || !wp_verify_nonce( $_POST['event_metadata_wpnonce'], plugin_basename(__FILE__) ))
			if ( !current_user_can( 'edit_post', $post_id ))
			return $post_id;
			update_post_meta( $post_id, $meta_box[ 'key' ], $data );
		}
	}
}
add_action( 'admin_menu', 'create_meta_box' );
add_action( 'save_post', 'save_meta_box' );
