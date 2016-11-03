<?php
// Help Tab
add_action( "admin_head", 'add_contextual_help_tab' );
function add_contextual_help_tab() {
	global $post;
	$screen = get_current_screen();

	if( isset($_GET['post_type']) ) $post_type = $_GET['post_type'];
	else $post_type = get_post_type( $post->ID );
	$slug = $post->post_name;

	switch ($post_type) {

		// Issue Post Type
		case "post":
			$screen->add_help_tab( array(
					 'id'       => 'settings_help'
					,'title'    => __( 'Basis Post Help', 'basis' )
					,'content'  => "<h3>Body Content</h3>

								<p>Use the primary editor to add body text.</p>"
				) );
			break;

		// Everything Else
		default:
			$screen->add_help_tab( array(
					 'id'       => 'settings_help'
					,'title'    => __( 'Basis Help', 'basis' )
					,'content'  => "<h3>News Posts</h3>

								<p>News posts can be added or edited in the <a href='".admin_url( 'edit.php' )."'>Posts</a> section.</p>

								<h3>Pages</h3>

								<p>All other pages can be individually edited in the <a href='".admin_url( 'edit.php?post_type=page' )."'>Pages</a> section. Each page has customized controls based on the content of that page.</p>

								<h3>Menus</h3>

								<p>To change the content of the Primary Menu or Footer Menu, go to Appearance > <a href='".admin_url( 'nav-menus.php' )."'>Menus</a>.</p>"
				) );
			break;
		}
}
?>