<?php
//////////////////////////////////////////////
//Add Post Type Archives To Wordpress Menus
//////////////////////////////////////////////
add_action( 'admin_head-nav-menus.php', 'inject_cpt_archives_menu_meta_box');
function inject_cpt_archives_menu_meta_box( $object ) {
	add_meta_box( 'add-cpt', __( 'CPT Archives' ), 'wp_nav_menu_cpt_archives_meta_box', 'nav-menus', 'side', 'default' );
	return $object; /* pass */
  }

  /* render custom post type archives meta box */
  function wp_nav_menu_cpt_archives_meta_box() {

	/* get custom post types with archive support */
	$post_types = get_post_types( array( 'show_in_nav_menus' => true, 'has_archive' => true ), 'object' );

	/* hydrate the necessary object properties for the walker */
	foreach ( $post_types as &$post_type ) {
		$post_type->classes = array();
		$post_type->type = $post_type->name;
		$post_type->object_id = $post_type->name;
		$post_type->title = $post_type->labels->name . ' ' . __( 'Archive', 'default' );
		$post_type->object = 'cpt-archive';
	}

	$walker = new Walker_Nav_Menu_Checklist( array() );
	?>

	<div id="cpt-archive" class="posttypediv">
	  <div id="tabs-panel-cpt-archive" class="tabs-panel tabs-panel-active">
		<ul id="ctp-archive-checklist" class="categorychecklist form-no-clear">
		  <?php
			echo walk_nav_menu_tree( array_map('wp_setup_nav_menu_item', $post_types), 0, (object) array( 'walker' => $walker) );
		  ?>
		</ul>
	  </div><!-- /.tabs-panel -->
	</div>

	<p class="button-controls">
	  <span class="add-to-menu">
		<input type="submit"<?php disabled( $nav_menu_selected_id, 0 ); ?> class="button-secondary submit-add-to-menu" value="<?php esc_attr_e('Add to Menu'); ?>" name="add-ctp-archive-menu-item" id="submit-cpt-archive" />
	  </span>
	</p>

	<?php
  }

  add_filter( 'wp_get_nav_menu_items', 'cpt_archive_menu_filter', 10, 3 );

  function cpt_archive_menu_filter( $items, $menu, $args ) {

	/* alter the URL for cpt-archive objects */
	foreach ( $items as &$item ) {
	  if ( $item->object != 'cpt-archive' ) continue;
	  $item->url = get_post_type_archive_link( $item->type );
	}

	return $items;
  }

//////////////////////////////////////////////
//Remove Admin Menu Items
//////////////////////////////////////////////
function remove_menu_items() {
  global $menu;
  $restricted = array(__('Links'));
  end ($menu);
  while (prev($menu)){
	$value = explode(' ',$menu[key($menu)][0]);
	if(in_array($value[0] != NULL?$value[0]:"" , $restricted)){
	  unset($menu[key($menu)]);}
	}
  }

add_action('admin_menu', 'remove_menu_items');

//////////////////////////////////////////////
//Remove Admin Bar Items
//////////////////////////////////////////////
function mytheme_admin_bar_render() {
	global $wp_admin_bar;
	// or we can remove a submenu, like New Link.
	$wp_admin_bar->remove_menu('new-link', 'new-content');
	//$wp_admin_bar->remove_menu('new-post', 'new-content');
}

add_action( 'wp_before_admin_bar_render', 'mytheme_admin_bar_render' );

///////////////////////////////////////////
// Add Instructions to Featured Image Box
///////////////////////////////////////////
add_filter( 'admin_post_thumbnail_html', 'add_featured_image_instruction');
function add_featured_image_instruction( $content ) {
	$screen = get_current_screen();
	if( is_admin() && 'post' == get_post_type() ){

		return $content = '<p>Minimum Size: 500px x 370px</p>'.$content;

	} else {

		return $content = '<p>Minimum Size: 250px x 155px</p>'.$content;
	}

}
?>