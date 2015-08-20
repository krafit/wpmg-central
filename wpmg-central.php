<?php
/**
 * Plugin Name: WP Meetups Germany - Central
 * Description: Zetrales WP Meetup Verzeichnis.
 * Author: Simon Kraft (wpFRA.de)
 * Version: 0.1
 * Author URI: https://krafit.de
 * Text Domain: wpmg_central
 * Domain Path: languages
 *
 */


// Register Custom Post Type
function wpmg_meetup() {

	$labels = array(
		'name'                => _x( 'Meetups', 'Post Type General Name', 'wpmg_central' ),
		'singular_name'       => _x( 'Meetup', 'Post Type Singular Name', 'wpmg_central' ),
		'menu_name'           => __( 'Meetups', 'wpmg_central' ),
		'name_admin_bar'      => __( 'Meetup', 'wpmg_central' ),
		'parent_item_colon'   => __( 'Parent Meetup', 'wpmg_central' ),
		'all_items'           => __( 'All Meetups', 'wpmg_central' ),
		'add_new_item'        => __( 'Add new Meetup', 'wpmg_central' ),
		'add_new'             => __( 'Add new', 'wpmg_central' ),
		'new_item'            => __( 'New Meetup', 'wpmg_central' ),
		'edit_item'           => __( 'Edit Meetup', 'wpmg_central' ),
		'update_item'         => __( 'Update Meetup', 'wpmg_central' ),
		'view_item'           => __( 'View Meetup', 'wpmg_central' ),
		'search_items'        => __( 'Search Meetup', 'wpmg_central' ),
		'not_found'           => __( 'Not found', 'wpmg_central' ),
		'not_found_in_trash'  => __( 'Not found in trash', 'wpmg_central' ),
	);
	$args = array(
		'label'               => __( 'single_meetup', 'wpmg_central' ),
		'description'         => __( 'Meetup Groups', 'wpmg_central' ),
		'labels'              => $labels,
		'supports'            => array( 'title', 'editor', 'thumbnail', 'revisions', 'custom-fields', ),
		'taxonomies'          => array( 'meetup_status' ),
		'hierarchical'        => true,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'menu_position'       => 5,
		'menu_icon'           => 'dashicons-groups',
		'show_in_admin_bar'   => true,
		'show_in_nav_menus'   => true,
		'can_export'          => true,
		'has_archive'         => true,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'capability_type'     => 'post',
	);
	register_post_type( 'meetup', $args );

}

// Hook into the 'init' action
add_action( 'init', 'wpmg_meetup', 0 );


// Register Custom Taxonomy
function wpmg_meetup_status() {

	$labels = array(
		'name'                       => _x( 'Meetup status', 'Taxonomy General Name', 'wpmg_central' ),
		'singular_name'              => _x( 'Meetup status', 'Taxonomy Singular Name', 'wpmg_central' ),
		'menu_name'                  => __( 'Status', 'wpmg_central' ),
		'all_items'                  => __( 'Status', 'wpmg_central' ),
		'parent_item'                => __( 'Parent status', 'wpmg_central' ),
		'parent_item_colon'          => __( 'Parent status', 'wpmg_central' ),
		'new_item_name'              => __( 'New status', 'wpmg_central' ),
		'add_new_item'               => __( 'Add new status', 'wpmg_central' ),
		'edit_item'                  => __( 'Edit status', 'wpmg_central' ),
		'update_item'                => __( 'Update status', 'wpmg_central' ),
		'view_item'                  => __( 'View status', 'wpmg_central' ),
		'separate_items_with_commas' => __( 'Separate items with commas', 'wpmg_central' ),
		'add_or_remove_items'        => __( 'Add or remove status', 'wpmg_central' ),
		'choose_from_most_used'      => __( 'Most used', 'wpmg_central' ),
		'popular_items'              => __( 'Popular', 'wpmg_central' ),
		'search_items'               => __( 'Search status', 'wpmg_central' ),
		'not_found'                  => __( 'Not found', 'wpmg_central' ),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => false,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => false,
		'show_tagcloud'              => false,
	);
	register_taxonomy( 'meetup_status', array( 'single_meetup' ), $args );

}

// Hook into the 'init' action
add_action( 'init', 'wpmg_meetup_status', 0 );

/**
 * Load Textdomain
 *
 * @since	0.1
 */
function wpmg_load_translations() {
	load_plugin_textdomain( 'wpmg_central', false, apply_filters ( 'wpmg_central_translationpath', dirname( plugin_basename( __FILE__ )) . '/languages/' ) );
}

// Hook into 'plugins_loaded' action
add_action( 'plugins_loaded', 'wpmg_load_translations' );

