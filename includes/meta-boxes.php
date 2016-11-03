<?php
################################################################################
/*
Meta Boxes:

I prefer to use the excellent Meta Boxes plugin (http://wordpress.org/plugins/meta-box/) by Rilwis to create custom meta boxes and custom fields. Everything currently in this file merely serves as a brief demo with some commonly used field types. Nothing here will work unless the Meta Box plugin is installed.

If you prefer to use another method to create your custom fields and meta boxes, simply delete all of the current code in this f le and replace it with your own. If you do not need custom fields and meta boxes, you may remove ths file entirely, but be sure to also remove the reference to it in functions.php.
*/
################################################################################

/**
 * Registering meta boxes
 *
 * You also should read the changelog to know what has been changed before updating.
 *
 * For more information, please visit:
 * @link http://www.deluxeblogtips.com/2010/04/how-to-create-meta-box-wordpress-post.html
 */

/********************* META BOX DEFINITIONS ***********************/

/**
 * Prefix of meta keys (optional)
 * Use underscore (_) at the beginning to make keys hidden
 * Alt.: You also can make prefix empty to disable it
 */
add_filter( 'rwmb_meta_boxes', 'chemset_register_meta_boxes' );
function chemset_register_meta_boxes( $meta_boxes ) {

$built_boxes = array();

$prefix = 'chemset_';

// Post box
$built_boxes[] = array(
	'id'		=> 'postinfo',
	'title'		=> 'Meta Box',
	'pages'		=> array( 'post'),

	'fields'	=> array(
		// Text
		array(
			'name'  => __( 'Text', 'chemset' ),
			'id'    => "{$prefix}text",
			'desc'  => __( 'Text description', 'chemset' ),
			'type'  => 'text',
			'std'   => __( 'Default text value', 'chemset' ),
			'clone' => true,
		),
		// CHECKBOX
		array(
			'name' => __( 'Checkbox', 'chemset' ),
			'id'   => "{$prefix}checkbox",
			'type' => 'checkbox',
			// Value can be 0 or 1
			'std'  => 1,
		),
		// RADIO BUTTONS
		array(
			'name'    => __( 'Radio', 'chemset' ),
			'id'      => "{$prefix}radio",
			'type'    => 'radio',
			// Array of 'value' => 'Label' pairs for radio options.
			// Note: the 'value' is stored in meta field, not the 'Label'
			'options' => array(
				'value1' => __( 'Label1', 'chemset' ),
				'value2' => __( 'Label2', 'chemset' ),
			),
		),
		// SELECT BOX
		array(
			'name'     => __( 'Select', 'chemset' ),
			'id'       => "{$prefix}select",
			'type'     => 'select',
			// Array of 'value' => 'Label' pairs for select box
			'options'  => array(
				'value1' => __( 'Label1', 'chemset' ),
				'value2' => __( 'Label2', 'chemset' ),
			),
			// Select multiple values, optional. Default is false.
			'multiple' => false,
			'std'	=> __( 'Select an Item', 'chemset' ),
		),
		// TEXTAREA
		array(
			'name' => __( 'Textarea', 'chemset' ),
			'desc' => __( 'Textarea description', 'chemset' ),
			'id'   => "{$prefix}textarea",
			'type' => 'textarea',
			'cols' => 20,
			'rows' => 3,
		),
	)
);

//2nd Post box
$built_boxes[] = array(
	'id'		=> 'pageinfo',
	'title'		=> 'Meta Box',
	'pages'		=> array( 'page'),

	'fields'	=> array(
		// DATE
				array(
					'name' => __( 'Date picker', 'chemset' ),
					'id'   => "{$prefix}date",
					'type' => 'date',

					// jQuery date picker options. See here http://api.jqueryui.com/datepicker
					'js_options' => array(
						'appendText'      => __( '(yyyy-mm-dd)', 'chemset' ),
						'dateFormat'      => __( 'yy-mm-dd', 'chemset' ),
						'changeMonth'     => true,
						'changeYear'      => true,
						'showButtonPanel' => true,
					),
				),
		// WYSIWYG/RICH TEXT EDITOR
		array(
			'name' => __( 'WYSIWYG / Rich Text Editor', 'chemset' ),
			'id'   => "{$prefix}wysiwyg",
			'type' => 'wysiwyg',
			// Set the 'raw' parameter to TRUE to prevent data being passed through wpautop() on save
			'raw'  => false,
			'std'  => __( 'WYSIWYG default value', 'chemset' ),

			// Editor settings, see wp_editor() function: look4wp.com/wp_editor
			'options' => array(
				'textarea_rows' => 4,
				'teeny'         => true,
				'media_buttons' => false,
			),
		),
	)
);

///////////////////////////////////
// Conditional Stuff
//////////////////////////////////

// Grab variables for current page
if ( isset( $_GET['post'] ) ) {
	$post_id = $_GET['post'];
}
elseif ( isset( $_POST['post_ID'] ) ) {
	$post_id = $_POST['post_ID'];
}
else {
	$post_id = false;
}

$post_id = (int) $post_id;
$post    = get_post( $post_id );
$post_slug = $post->post_name;

// For each box, crun conditionals
foreach ($built_boxes as $meta_box) {

	// Is the only-on conditional set?
	if ( isset( $meta_box['only_on'] ) ) {

		// Is this a regular Slug conditional?
		if ( isset( $meta_box['only_on']['slug'] ) ) {

			// Grab slug
			$v = $meta_box['only_on']['slug'];

			// Make sure it's an array
			if ( ! is_array( $v ) ) {
					$v = array( $v );
				}

			// If the post slug is in the array, pass the box to meta boxes
			if ( in_array( $post_slug, $v ) ) {
				$meta_boxes[] = $meta_box;
			}

		// Is this a Not-Slug conditional?
		} elseif ( isset( $meta_box['only_on']['not-slug'] ) ) {

			// Grab slug
			$v = $meta_box['only_on']['not-slug'];

			// Make sure it's an array
			if ( ! is_array( $v ) ) {
					$v = array( $v );
				}

			// If the post slug isn't in the array, pass the box to meta boxes
			if ( !in_array( $post_slug, $v ) ) {
				$meta_boxes[] = $meta_box;
			}

		// For some reason, there's nothing in the Only On
		} else {
			$meta_boxes[] = $meta_box;
		}


	// If the conditional isn't set, go ahead and pass the box to meta boxes
	} else {
		$meta_boxes[] = $meta_box;
	}
}


return $meta_boxes;

}