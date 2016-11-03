<?php
/*
Plugin Name: Chemistry Set Plugin
Plugin URI:
Description: Custom functionality
Version: 0.1
Author: Josiah Spence
Author Email: spencejosiah@gmail.com
License:

  Copyright 2016 Josiah Spence (spencejosiah@gmail.com)

  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License, version 2, as
  published by the Free Software Foundation.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program; if not, write to the Free Software
  Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA

*/
///////////////////////////////////////////
// Include Plugin Partials
///////////////////////////////////////////
// Prevent loading this file directly
defined( 'ABSPATH' ) || exit;

// Plugin paths, for including files
if ( ! defined( 'CHEMSET_DIR' ) ) {
  define( 'CHEMSET_DIR', plugin_dir_path( __FILE__ ) );
  define( 'CHEMSET_INC_DIR', trailingslashit( CHEMSET_DIR . 'includes' ) );
}

// enqueue admin CSS and JS
add_action('admin_init', 'chemset_admin_init');

function chemset_admin_init() {

  wp_register_style('chemset_admin_css', plugins_url( 'admin.css', __FILE__ ));
  wp_enqueue_style('chemset_admin_css');

  wp_register_script('chemset_admin_js', plugins_url( 'admin-scripts.js', __FILE__ ));
  wp_enqueue_script('chemset_admin_js');
}

require_once CHEMSET_INC_DIR . 'admin-tweaks.php';
require_once CHEMSET_INC_DIR . 'post-types-taxonomies.php';
require_once CHEMSET_INC_DIR . 'meta-boxes.php';
require_once CHEMSET_INC_DIR . 'contextual-help.php';
?>