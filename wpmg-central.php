<?php
/**
 * Plugin Name: WP Meetups Germany - Central
 * Description: Zetrales WP Meetup Verzeichnis.
 * Author: Simon Kraft (wpFRA.de)
 * Version: 0.1.2
 * Author URI: https://krafit.de
 * Text Domain: wpmg_central
 * Domain Path: languages
 * GitHub Plugin URI: https://github.com/wpFRA/wpmg-central
 * GitHub Branch: master
 *
 */

/**
 * Register Custom Post Type
 *
 * @since   0.1
 *
 */
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
		'supports'            => array( 'title', 'editor', 'thumbnail', 'revisions', 'excerpt' ),
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
  		'show_in_rest'       => true,
  		'rest_base'          => 'meetup',
  		'rest_controller_class' => 'WP_REST_Posts_Controller',
		'capability_type'     => 'post',
	);
	register_post_type( 'meetup', $args );

}

/**
 * Hook into the 'init' action
 */
add_action( 'init', 'wpmg_meetup', 0 );


/**
 * Register Custom Taxonomy
 *
 * @since   0.1
 */
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
		'choose_from_most_used'      => __( 'Most used', 'wpmg_meta_box_callback' ),
		'popular_items'              => __( 'Popular', 'wpmg_central' ),
		'search_items'               => __( 'Search status', 'wpmg_central' ),
		'not_found'                  => __( 'Not found', 'wpmg_central' ),
	);
	$capabilities = array(
		'manage_terms'               => 'wpmg_manage_status',
		'edit_terms'                 => 'wpmg_edit_status',
		'delete_terms'               => 'wpmg_delete_status',
		'assign_terms'               => 'edit_posts',
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => false,
		'show_tagcloud'              => false,
		'capabilities'               => $capabilities,
  		'show_in_rest'               => true,
  		'rest_base'                  => 'status',
  		'rest_controller_class'      => 'WP_REST_Terms_Controller',
	);
	register_taxonomy( 'meetup_status', array( 'meetup' ), $args );

}

/**
 * Hook into the 'init' action
 */
add_action( 'init', 'wpmg_meetup_status', 0 );

/**
 * Load Textdomain
 *
 * @since	0.1
 */
function wpmg_load_translations() {
	load_plugin_textdomain( 'wpmg_central', false, apply_filters ( 'wpmg_central_translationpath', dirname( plugin_basename( __FILE__ )) . '/languages/' ) );
}

/**
 * Hook into 'plugins_loaded' action
 */
add_action( 'plugins_loaded', 'wpmg_load_translations' );


/**
 * Add Metaboxes
 *
 * @since	0.1
 */
function wpmg_add_meta_boxes() {
	add_meta_box(
		'wpmg_metadata_id',
		__( 'Meetup Metadata', 'wpmg_meta_box_callback' ),
		'wpmg_meta_box_callback',
		"meetup"
	);
}

/**
 * Hook into 'add_meta_boxes_ action
 */
add_action( 'add_meta_boxes', 'wpmg_add_meta_boxes');

/**
 *
 * Adds Metafields for Meetup
 *
 *
 * wpmg_twitter - URL des Meetup Twitter Accounts
 * wpmg_facebook - URL der Meetup Facebook Seite/Gruppe
 * wpmg_gplus - URL der Meetup Google+ Seite / Community
 * wpmg_meetupcom - URL der Meetup Gruppe auf Meetup.com
 * wpmg_slack - URL des Meetup Slack-Channels auf dewp.slack.com / URL auf eines Slack-Team
 * wpmg_xing - URL der Meetup Xing-Community
 * wpmg_wptv - URL der Meetup Event-Seite auf wp.tv
 * wpmg_home - URL der Meetup Webseite
 * wpmg_mail - E-Mailadresse für Rückfragen/Kontakt
 * wpmg_mailinglist - URL der Meetup Mailingliste
 * wpmg_rotation - Freitextfeld für Meetup Turnus
 *
 */
function wpmg_meta_box_callback( $post ) {
	wp_nonce_field( 'wpmg_meta_box', 'wpmg_meta_box_nonce' );

	/*
	 * Use get_post_meta() to retrieve an existing value
	 * from the database and use the value for the form.
	 */
	
	$wpmg_home 			= get_post_meta( $post->ID, 'wpmg_home', true );
	$wpmg_mail 			= get_post_meta( $post->ID, 'wpmg_mail', true );
	$wpmg_mailinglist 	= get_post_meta( $post->ID, 'wpmg_mailinglist', true );
	$wpmg_meetupcom 	= get_post_meta( $post->ID, 'wpmg_meetupcom', true );
	$wpmg_wptv 			= get_post_meta( $post->ID, 'wpmg_wptv', true );
	$wpmg_twitter 		= get_post_meta( $post->ID, 'wpmg_twitter', true );
	$wpmg_facebook 		= get_post_meta( $post->ID, 'wpmg_facebook', true );
	$wpmg_gplus			= get_post_meta( $post->ID, 'wpmg_gplus', true );
	$wpmg_slack 		= get_post_meta( $post->ID, 'wpmg_slack', true );
	$wpmg_xing 			= get_post_meta( $post->ID, 'wpmg_xing', true );
	$wpmg_rotation 		= get_post_meta( $post->ID, 'wpmg_rotation', true );


	// home
    echo '<div class="wpmg wpmg-home">';
	echo '<label for="wpmg_home">';
    echo '<span class="dashicons dashicons-wordpress"></span> ';
	_e( 'Meetup Homepage URL', 'wpmg_central' );
	echo '</label> ';
    echo '<br/>';
	echo '<input type="text" id="wpmg_home" name="wpmg_home" value="' . esc_attr( $wpmg_home ) . '" size="25" />';
	echo '</div>';

	// mail
    echo '<div class="wpmg wpmg-mail">';
	echo '<label for="wpmg_mail">';
    echo '<span class="dashicons dashicons-email"></span> ';
	_e( 'Contact EMail', 'wpmg_central' );
	echo '</label> ';
    echo '<br/>';
	echo '<input type="text" id="wpmg_mail" name="wpmg_mail" value="' . esc_attr( $wpmg_mail ) . '" size="25" />';
	echo '</div>';

	// mailinglist
    echo '<div class="wpmg wpmg-mailinglist">';
	echo '<label for="wpmg_mailinglist">';
    echo '<span class="dashicons dashicons-megaphone"></span> ';
	_e( 'Mailiglist URL', 'wpmg_central' );
	echo '</label> ';
    echo '<br/>';
	echo '<input type="text" id="wpmg_mailinglist" name="wpmg_mailinglist" value="' . esc_attr( $wpmg_mailinglist ) . '" size="25" />';
	echo '</div>';

	// meetupcom
    echo '<div class="wpmg wpmg-meetupcom">';
	echo '<label for="wpmg_meetupcom">';
    echo '<span class="dashicons dashicons-nametag"></span> ';
	_e( 'Meetup.com URL', 'wpmg_central' );
	echo '</label> ';
    echo '<br/>';
	echo '<input type="text" id="wpmg_meetupcom" name="wpmg_meetupcom" value="' . esc_attr( $wpmg_meetupcom ) . '" size="25" />';
	echo '</div>';

	// wptv
    echo '<div class="wpmg wpmg-wptv">';
	echo '<label for="wpmg_wptv">';
    echo '<span class="dashicons dashicons-format-video"></span> ';
	_e( 'WordPress.TV URL', 'wpmg_central' );
	echo '</label> ';
    echo '<br/>';
	echo '<input type="text" id="wpmg_wptv" name="wpmg_wptv" value="' . esc_attr( $wpmg_wptv ) . '" size="25" />';
	echo '</div>';

	// twitter
    echo '<div class="wpmg wpmg-twitter">';
	echo '<label for="wpmg_twitter">';
    echo '<span class="dashicons dashicons-twitter"></span> ';
	_e( 'Twitter URL', 'wpmg_central' );
	echo '</label> ';
    echo '<br/>';
	echo '<input type="text" id="wpmg_twitter" name="wpmg_twitter" value="' . esc_attr( $wpmg_twitter ) . '" size="25" />';
	echo '</div>';

	// facebook
    echo '<div class="wpmg wpmg-facebook">';
	echo '<label for="wpmg_facebook">';
    echo '<span class="dashicons dashicons-facebook"></span> ';
	_e( 'Facebook URL', 'wpmg_central' );
	echo '</label> ';
    echo '<br/>';
	echo '<input type="text" id="wpmg_facebook" name="wpmg_facebook" value="' . esc_attr( $wpmg_facebook ) . '" size="25" />';
	echo '</div>';

	// gplus
    echo '<div class="wpmg wpmg-gplus">';
	echo '<label for="wpmg_gplus">';
    echo '<span class="dashicons dashicons-googleplus"></span> ';
	_e( 'Google+ URL', 'wpmg_central' );
	echo '</label> ';
    echo '<br/>';
	echo '<input type="text" id="wpmg_gplus" name="wpmg_gplus" value="' . esc_attr( $wpmg_gplus ) . '" size="25" />';
	echo '</div>';

	// slack
    echo '<div class="wpmg wpmg-slack">';
	echo '<label for="wpmg_slack">';
    echo '<img src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiPz48IURPQ1RZUEUgc3ZnIFBVQkxJQyAiLS8vVzNDLy9EVEQgU1ZHIDEuMS8vRU4iICJodHRwOi8vd3d3LnczLm9yZy9HcmFwaGljcy9TVkcvMS4xL0RURC9zdmcxMS5kdGQiPjxzdmcgdmVyc2lvbj0iMS4xIiBpZD0ic3ZnMiIgeG1sbnM6c3ZnPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIiB4bWxuczpjYz0iaHR0cDovL2NyZWF0aXZlY29tbW9ucy5vcmcvbnMjIiB4bWxuczpkYz0iaHR0cDovL3B1cmwub3JnL2RjL2VsZW1lbnRzLzEuMS8iIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiIHg9IjBweCIgeT0iMHB4IiB3aWR0aD0iMTdweCIgaGVpZ2h0PSIxN3B4IiB2aWV3Qm94PSIyNjcuMDY5IDcyLjA3NSAxNyAxNyIgZW5hYmxlLWJhY2tncm91bmQ9Im5ldyAyNjcuMDY5IDcyLjA3NSAxNyAxNyIgeG1sOnNwYWNlPSJwcmVzZXJ2ZSI+PGcgaWQ9ImcxMiIgdHJhbnNmb3JtPSJzY2FsZSgwLjEsMC4xKSI+PHBhdGggaWQ9InBhdGgyNCIgZmlsbD0iIzQ0NDQ0NCIgZD0iTTI3NDAuODEsNzk4LjMzN2w3LjEwNCwyMS4yMTFsMjIuMDQxLTcuMzczbC03LjEwOS0yMS4yMTZMMjc0MC44MSw3OTguMzM3Ii8+PHBhdGggaWQ9InBhdGgyNiIgZmlsbD0iIzQ0NDQ0NCIgZD0iTTI3NDAuODEsNzk4LjMzN2w3LjEwNCwyMS4yMTFsMjIuMDQxLTcuMzczbC03LjEwOS0yMS4yMTZMMjc0MC44MSw3OTguMzM3Ii8+PHBhdGggaWQ9InBhdGgyOCIgZmlsbD0iIzQ0NDQ0NCIgZD0iTTI4MDIuMjgsODE5LjM3MmwtMTAuNjkzLDMuNTg0bDMuNzExLDExLjA1NWMxLjUwNCw0LjQ3My0wLjkxOCw5LjMxNi01LjM5MSwxMC44MmMtMC45NzcsMC4zMjItMS45NzMsMC40NjktMi45MzksMC40NDljLTMuNDg2LTAuMDk4LTYuNzA5LTIuMzQ0LTcuODgxLTUuODRsLTMuNzA2LTExLjA1NWwtMjIuMDM2LDcuMzgzbDMuNzA2LDExLjA1NWMxLjQ5OSw0LjQ3My0wLjkxOCw5LjMxNi01LjM5MSwxMC44MmMtMC45NzcsMC4zMjItMS45NjgsMC40NjktMi45NDQsMC40MzljLTMuNDg2LTAuMDg4LTYuNzA0LTIuMzI0LTcuODgxLTUuODRsLTMuNzAxLTExLjA0NWwtMTAuNjg4LDMuNTc0Yy0wLjk3NywwLjMyMi0xLjk2MywwLjQ2OS0yLjkzOSwwLjQ0OWMtMy40ODYtMC4wOTgtNi43MDktMi4zMzQtNy44ODEtNS44NGMtMS41MDQtNC40OTIsMC45MTMtOS4zMjYsNS4zOTYtMTAuODNsMTAuNjc5LTMuNTc0bC03LjEtMjEuMjExbC0xMC42ODgsMy41ODRjLTAuOTcyLDAuMzIyLTEuOTYzLDAuNDU5LTIuOTM1LDAuNDM5Yy0zLjQ5MS0wLjA4OC02LjcxNC0yLjMzNC03Ljg4Ni01LjgzYy0xLjQ5OS00LjQ4MiwwLjkxOC05LjMyNiw1LjM5MS0xMC44MjVsMTAuNjg0LTMuNTg0bC0zLjcwMS0xMS4wNTVjLTEuNDk5LTQuNDc4LDAuOTEzLTkuMzIxLDUuMzk2LTEwLjgyNWM0LjQ3OC0xLjQ5NCw5LjMxNiwwLjkxOCwxMC44MTUsNS4zOTZsMy43MDYsMTEuMDZsMjIuMDM2LTcuMzc4bC0zLjcwNi0xMS4wNTVjLTEuNDk5LTQuNDgyLDAuOTE4LTkuMzMxLDUuMzkxLTEwLjgyNWM0LjQ3OC0xLjUwNCw5LjMyMSwwLjkwOCwxMC44Myw1LjM4NmwzLjY5NiwxMS4wNmwxMC42OTMtMy41NzRjNC40NzMtMS41MDQsOS4zMTYsMC45MTMsMTAuODIsNS4zOTFjMS41MDQsNC40NzMtMC45MTgsOS4zMTYtNS4zOTEsMTAuODJsLTEwLjY5MywzLjU3OWw3LjEwOSwyMS4yMTZsMTAuNjg0LTMuNTg0YzQuNDczLTEuNDk0LDkuMzE2LDAuOTE4LDEwLjgyLDUuMzkxUzI4MDYuNzUzLDgxNy44NjksMjgwMi4yOCw4MTkuMzcyTDI4MDIuMjgsODE5LjM3MnogTTI4MzAuOTQyLDc4Mi41OGMtMTcuMDAyLTU2LjY3LTQxLjU2Mi02OS44ODgtOTguMjMyLTUyLjg5MWMtNTYuNjcsMTcuMDA3LTY5Ljg5Myw0MS41NjItNTIuODkxLDk4LjIyOGMxNy4wMDcsNTYuNjcsNDEuNTU4LDY5LjkwMiw5OC4yMzIsNTIuOUMyODM0LjcyMSw4NjMuODE2LDI4NDcuOTU0LDgzOS4yNTUsMjgzMC45NDIsNzgyLjU4Ii8+PC9nPjwvc3ZnPg=="> ';
	_e( 'Slack (channel on dewp.slack.com or slack team URL)', 'wpmg_central' );
	echo '</label> ';
    echo '<br/>';
	echo '<input type="text" id="wpmg_slack" name="wpmg_slack" value="' . esc_attr( $wpmg_slack ) . '" size="25" />';
	echo '</div>';

	// xing
    echo '<div class="wpmg wpmg-xing">';
	echo '<label for="wpmg_xing">';
    echo '<img src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiPz48IURPQ1RZUEUgc3ZnIFBVQkxJQyAiLS8vVzNDLy9EVEQgU1ZHIDEuMS8vRU4iICJodHRwOi8vd3d3LnczLm9yZy9HcmFwaGljcy9TVkcvMS4xL0RURC9zdmcxMS5kdGQiPjxzdmcgdmVyc2lvbj0iMS4xIiBpZD0ic3ZnMiIgeG1sbnM6c3ZnPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIiB4bWxuczpjYz0iaHR0cDovL2NyZWF0aXZlY29tbW9ucy5vcmcvbnMjIiB4bWxuczpkYz0iaHR0cDovL3B1cmwub3JnL2RjL2VsZW1lbnRzLzEuMS8iIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiIHg9IjBweCIgeT0iMHB4IiB3aWR0aD0iMTdweCIgaGVpZ2h0PSIxN3B4IiB2aWV3Qm94PSIyNjcuMDY5IDcyLjA3NSAxNyAxNyIgZW5hYmxlLWJhY2tncm91bmQ9Im5ldyAyNjcuMDY5IDcyLjA3NSAxNyAxNyIgeG1sOnNwYWNlPSJwcmVzZXJ2ZSI+PHBhdGggZmlsbD0iIzQ0NDQ0NCIgZD0iTTI2OS44NDEsNzUuNTk2Yy0wLjE0MywwLTAuMjYzLDAuMDUtMC4zMjQsMC4xNDhjLTAuMDYyLDAuMTAyLTAuMDUzLDAuMjMyLDAuMDEzLDAuMzY0bDEuNjA1LDIuNzc4YzAuMDAzLDAuMDA1LDAuMDAzLDAuMDA5LDAsMC4wMTRsLTIuNTIyLDQuNDUxYy0wLjA2NiwwLjEzMS0wLjA2MywwLjI2MiwwLDAuMzYzYzAuMDYxLDAuMDk4LDAuMTY3LDAuMTYyLDAuMzEsMC4xNjJoMi4zNzRjMC4zNTUsMCwwLjUyNi0wLjIzOSwwLjY0Ny0wLjQ1OGMwLDAsMi40NjYtNC4zNjMsMi41NjItNC41MzJjLTAuMDA5LTAuMDE2LTEuNjMyLTIuODQ2LTEuNjMyLTIuODQ2Yy0wLjExOS0wLjIxLTAuMjk2LTAuNDQ1LTAuNjYxLTAuNDQ1SDI2OS44NDF6Ii8+PHBhdGggaWQ9InBhdGgxOTM3NSIgZmlsbD0iIzQ0NDQ0NCIgZD0iTTI3OS44MTMsNzIuMzQ2Yy0wLjM1NCwwLTAuNTA4LDAuMjI0LTAuNjM2LDAuNDUyYzAsMC01LjExMyw5LjA2OC01LjI4Miw5LjM2OGMwLjAwOSwwLjAxNiwzLjM3Myw2LjE4NywzLjM3Myw2LjE4N2MwLjExOCwwLjIxLDAuMywwLjQ1MiwwLjY2NCwwLjQ1MmgyLjM3YzAuMTQzLDAsMC4yNTUtMC4wNTQsMC4zMTUtMC4xNTFjMC4wNjItMC4xMDEsMC4wNjItMC4yMzUtMC4wMDUtMC4zNjZsLTMuMzQ2LTYuMTE0Yy0wLjAwMy0wLjAwNS0wLjAwMy0wLjAxMSwwLTAuMDE3bDUuMjU1LTkuMjkyYzAuMDY2LTAuMTMxLDAuMDY3LTAuMjY1LDAuMDA0LTAuMzY2Yy0wLjA1OS0wLjA5OC0wLjE3Mi0wLjE1Mi0wLjMxNC0wLjE1MkgyNzkuODEzeiIvPjwvc3ZnPg=="> ';
	_e( 'Xing URL', 'wpmg_central' );
	echo '</label> ';
    echo '<br/>';
	echo '<input type="text" id="wpmg_xing" name="wpmg_xing" value="' . esc_attr( $wpmg_xing ) . '" size="25" />';
	echo '</div>';

	// rotation
    echo '<div class="wpmg wpmg-rotation">';
	echo '<label for="wpmg_rotation">';
    echo '<span class="dashicons dashicons-calendar-alt"></span> ';
	_e( 'Rotation', 'wpmg_central' );
	echo '</label> ';
    echo '<br/>';
	echo '<input type="text" id="wpmg_rotation" name="wpmg_rotation" value="' . esc_attr( $wpmg_rotation ) . '" size="25" />';
	echo '</div>';
}



/**
 * @param 	$post_id
 * @since	0.1
 */
function wpmg_save_meta_box_data( $post_id ) {

	/*
	 * We need to verify this came from our screen and with proper authorization,
	 * because the save_post action can be triggered at other times.
	 */

	// Check if our nonce is set.
	if ( ! isset( $_POST['wpmg_meta_box_nonce'] ) ) {
		return;
	}

	// Verify that the nonce is valid.
	if ( ! wp_verify_nonce( $_POST['wpmg_meta_box_nonce'], 'wpmg_meta_box' ) ) {
		return;
	}

	// If this is an autosave, our form has not been submitted, so we don't want to do anything.
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	// Check the user's permissions.
	if ( isset( $_POST['post_type'] ) && 'meetup' == $_POST['post_type'] ) {

		if ( ! current_user_can( 'edit_page', $post_id ) ) {
			return;
		}

	} else {

		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}
	}

	/* OK, it's safe for us to save the data now. */

	// Make sure that it is set.
	if ( ! isset( $_POST['wpmg_twitter'] ) ||
         ! isset( $_POST['wpmg_facebook'] ) ||
         ! isset( $_POST['wpmg_gplus'] ) ||
         ! isset( $_POST['wpmg_meetupcom'] ) ||
         ! isset( $_POST['wpmg_slack'] ) ||
         ! isset( $_POST['wpmg_xing'] ) ||
         ! isset( $_POST['wpmg_wptv'] ) ||
         ! isset( $_POST['wpmg_home'] ) ||
         ! isset( $_POST['wpmg_mail'] ) ||
         ! isset( $_POST['wpmg_mailinglist'] ) ||
         ! isset( $_POST['wpmg_rotation']
    ) ) {
		return;
	}

    update_post_meta( $post_id, 'wpmg_twitter',     sanitize_text_field( $_POST['wpmg_twitter'] ) );
    update_post_meta( $post_id, 'wpmg_facebook',    sanitize_text_field( $_POST['wpmg_facebook'] ) );
    update_post_meta( $post_id, 'wpmg_gplus',       sanitize_text_field( $_POST['wpmg_gplus'] ) );
    update_post_meta( $post_id, 'wpmg_meetupcom',   sanitize_text_field( $_POST['wpmg_meetupcom'] ) );
    update_post_meta( $post_id, 'wpmg_slack',       sanitize_text_field( $_POST['wpmg_slack'] ) );
    update_post_meta( $post_id, 'wpmg_xing',        sanitize_text_field( $_POST['wpmg_xing'] ) );
    update_post_meta( $post_id, 'wpmg_wptv',        sanitize_text_field( $_POST['wpmg_wptv'] ) );
    update_post_meta( $post_id, 'wpmg_home',        sanitize_text_field( $_POST['wpmg_home'] ) );
    update_post_meta( $post_id, 'wpmg_mail',        sanitize_email( $_POST['wpmg_mail'] ) );
    update_post_meta( $post_id, 'wpmg_mailinglist', sanitize_text_field( $_POST['wpmg_mailinglist'] ) );
    update_post_meta( $post_id, 'wpmg_rotation',    sanitize_text_field( $_POST['wpmg_rotation'] ) );
}

add_action( 'save_post', 'wpmg_save_meta_box_data' );

/**
 * Delete plugindata after plugin deinstall
 *
 * @since   0.1
 */
function wpmg_uninstall() {
    global $wpdb;
    $terms = get_terms( 'meetup_status', array( 'fields' => 'ids', 'hide_empty' => false ) );
    foreach ( $terms as $value ) {
        wp_delete_term( $value, 'meetup_status' );
    }

    $wpdb->query( "DELETE FROM $wpdb->postmeta WHERE meta_key like 'wpmg_%';" );
    $wpdb->query( "DELETE FROM $wpdb->posts WHERE post_type = 'meetup';" );

}

register_uninstall_hook( __FILE__,  'wpmg_uninstall' );


function wpmg_meetup_query( $query ){
    if( ! is_admin()
        && $query->is_post_type_archive( 'meetup' )
        && $query->is_main_query() ){
            $query->set( 'posts_per_page', 25 );
	        $query->set( 'orderby', 'title' );
	        $query->set( 'order', 'ASC' );
    }
}
add_action( 'pre_get_posts', 'wpmg_meetup_query' );




/**
 * Register admin styles
 *
 * @since   0.1
 */
function wpmg_custom_styles() {

    wp_register_style( 'wpmg_style', plugins_url( 'css/wpmg-admin.css', __FILE__ ), false, false );
    wp_enqueue_style( 'wpmg_style' );

}

add_action( 'admin_enqueue_scripts', 'wpmg_custom_styles', 50 );


/**
 * Remove aditional category, if the Radio Buttons for Taxonomies Plugin is active
 * 
 * @link https://wordpress.org/plugins/radio-buttons-for-taxonomies/faq/
 * @since   0.1
 */
if (class_exists('Radio_Buttons_for_Taxonomies')) {
	add_filter( "radio-buttons-for-taxonomies-no-term-meetup_status", "__return_FALSE" );
}


