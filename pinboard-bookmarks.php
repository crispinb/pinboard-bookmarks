<?php
/*
 * Plugin Name: Pinboard Bookmarks
 * Description:  Publish Pinboard bookmarks on your WordPress blog.
 * Plugin URI: http://dev.aldolat.it/projects/pinboard-bookmarks/
 * Author: Aldo Latino
 * Author URI: http://www.aldolat.it/
 * Version: 1.6.0
 * License: GPLv3 or later
 * Text Domain: pinboard-bookmarks
 * Domain Path: /languages/
 */

/*
 * Copyright (C) 2016-2017  Aldo Latino  (email : aldolat@gmail.com)
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 */

 /**
  * Prevent direct access to this file.
  *
  * @since 1.0
  */
 if ( ! defined( 'WPINC' ) ) {
 	exit( 'No script kiddies please!' );
 }

 /**
  * Launch Pinboard Bookmarks.
  *
  * @since 1.0
  */
 add_action( 'plugins_loaded', 'pinboard_bookmarks_setup' );

function pinboard_bookmarks_setup() {
	/*
	 * Define the version of the plugin.
	 */
	define( 'PINBOARD_BOOKMARKS_PLUGIN_VERSION', '1.6.0' );

	/*
	 * Load the translation.
	 *
	 * @since 1.0
	 */
	load_plugin_textdomain( 'pinboard-bookmarks', false, dirname( plugin_basename( __FILE__ ) ) . '/languages');

	/*
	 * Include all necessary PHP files.
	 *
	 * @since 1.0
	 */
    // Load the core functions.
    require_once( plugin_dir_path( __FILE__ ) . 'inc/pinboard-bookmarks-core.php' );
	// Load the functions.
	require_once( plugin_dir_path( __FILE__ ) . 'inc/pinboard-bookmarks-functions.php' );
	// Load the shortcode.
	require_once( plugin_dir_path( __FILE__ ) . 'inc/pinboard-bookmarks-shortcode.php' );
	// Load the widget's form functions.
	require_once( plugin_dir_path( __FILE__ ) . 'inc/pinboard-bookmarks-widget-form-functions.php' );
	// Load the widget's PHP file.
	require_once( plugin_dir_path( __FILE__ ) . 'inc/pinboard-bookmarks-widget.php' );

	/*
	 * Load Pinboard Bookmarks' widgets.
	 *
	 * @since 1.0
	 */
	add_action( 'widgets_init', 'pinboard_bookmarks_load_widget' );

    /*
	 * Load the script.
	 *
	 * @since 1.0
	 */
	add_action( 'admin_enqueue_scripts', 'pinboard_bookmarks_load_scripts' );

	/*
	 * Add links to plugins list line.
	 *
	 * @since 1.0
	 */
	add_filter( 'plugin_row_meta', 'pinboard_bookmarks_add_links', 10, 2 );
}

/**
 * Add links to plugins list line.
 *
 * @since 1.0
 */
function pinboard_bookmarks_add_links( $links, $file ) {
	if ( $file == plugin_basename( __FILE__ ) ) {
		$rate_url = 'https://wordpress.org/support/plugin/' . basename( dirname( __FILE__ ) ) . '/reviews/#new-post';
		$links[] = '<a target="_blank" href="' . $rate_url . '">' . esc_html__( 'Rate this plugin', 'pinboard-bookmarks' ) . '</a>';
	}
	return $links;
}

/***********************************************************************
 *                            CODE IS POETRY
 ***********************************************************************/
