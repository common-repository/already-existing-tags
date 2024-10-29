<?php
/*
Plugin Name: Already Existing Tags
Plugin URI: https://digitalemphasis.com/wordpress-plugins/already-existing-tags/
Description: Looks for already existing tags within your posts.
Version: 2.4
Author: digitalemphasis
Author URI: https://digitalemphasis.com/
License: GPLv2 or later
*/

defined( 'ABSPATH' ) || die( 'Cannot access pages directly.' );
defined( 'AET_PLUGIN_VER' ) || define( 'AET_PLUGIN_VER', '2.4' );

function aet_register_the_settings() {
	register_setting( 'aet-settings-group', 'aet_turn_on' );
	register_setting( 'aet-settings-group', 'aet_block_manually_added_tags' );
	register_setting( 'aet-settings-group', 'aet_examine_post_title' );
	register_setting( 'aet-settings-group', 'aet_examine_post_content' );
	register_setting( 'aet-settings-group', 'aet_filter_by_category' );
	register_setting( 'aet-settings-group', 'aet_included_categories' );
	register_setting( 'aet-settings-group', 'aet_clean_uninstall' );
}
add_action( 'admin_init', 'aet_register_the_settings' );

function aet_enqueue_assets() {
	wp_enqueue_style( 'aet-admin-css', plugins_url( 'admin/already-existing-tags-admin.css', __FILE__ ), array(), AET_PLUGIN_VER );
	wp_enqueue_script( 'aet-admin-js', plugins_url( 'admin/already-existing-tags-admin.js', __FILE__ ), array( 'jquery' ), AET_PLUGIN_VER, true );
}
add_action( 'admin_enqueue_scripts', 'aet_enqueue_assets' );

function aet_settings_page() {
	require 'admin/already-existing-tags-admin.php';
}

function aet_submenu() {
	add_submenu_page( 'edit.php', 'Already Existing Tags', 'Already Existing Tags', 'manage_options', 'already-existing-tags', 'aet_settings_page' );
}
add_action( 'admin_menu', 'aet_submenu' );

function aet_add_settings_link( $links ) {
	$settings_link = '<a href="edit.php?page=already-existing-tags">Settings</a>';
	array_unshift( $links, $settings_link );
	return $links;
}
add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'aet_add_settings_link' );

function aet_update_db_check() {
	if ( get_option( 'aet_automatic_tagging_included_categories' ) !== false ) {
		add_option( 'aet_included_categories', get_option( 'aet_automatic_tagging_included_categories' ) );
		delete_option( 'aet_automatic_tagging_included_categories' );
	}
	if ( get_option( 'aet_automatic_tagging' ) !== false ) {
		add_option( 'aet_turn_on', get_option( 'aet_automatic_tagging' ) );
		delete_option( 'aet_automatic_tagging' );
	}
}
add_action( 'plugins_loaded', 'aet_update_db_check' );

function aet_activation() {
	add_option( 'aet_turn_on', '' );
	add_option( 'aet_block_manually_added_tags', '' );
	add_option( 'aet_examine_post_title', '' );
	add_option( 'aet_examine_post_content', '1' );
	add_option( 'aet_filter_by_category', '1' );
	add_option( 'aet_included_categories', '' );
	add_option( 'aet_clean_uninstall', '1' );
}

function aet_deactivation() {
	unregister_setting( 'aet-settings-group', 'aet_turn_on' );
	unregister_setting( 'aet-settings-group', 'aet_block_manually_added_tags' );
	unregister_setting( 'aet-settings-group', 'aet_examine_post_title' );
	unregister_setting( 'aet-settings-group', 'aet_examine_post_content' );
	unregister_setting( 'aet-settings-group', 'aet_filter_by_category' );
	unregister_setting( 'aet-settings-group', 'aet_included_categories' );
	unregister_setting( 'aet-settings-group', 'aet_clean_uninstall' );
}

function aet_uninstall() {
	if ( get_option( 'aet_clean_uninstall' ) ) {
		delete_option( 'aet_turn_on' );
		delete_option( 'aet_block_manually_added_tags' );
		delete_option( 'aet_examine_post_title' );
		delete_option( 'aet_examine_post_content' );
		delete_option( 'aet_filter_by_category' );
		delete_option( 'aet_included_categories' );
		delete_option( 'aet_clean_uninstall' );
	}
}

register_activation_hook( __FILE__, 'aet_activation' );
register_deactivation_hook( __FILE__, 'aet_deactivation' );
register_uninstall_hook( __FILE__, 'aet_uninstall' );

require 'already-existing-tags-core.php';
