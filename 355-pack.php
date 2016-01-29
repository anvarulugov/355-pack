<?php 
/***************************************************************************
Plugin Name:  355 Pack
Plugin URI:   http://termiz.click
Description:  Utilities pack for the 355st decision about the websites of the Republic of Uzbekistan
Version:      1.0.0
Author:       Dilshod Uktamov, Anvar Ulugov
Author URI:   http://termiz.click
License:      GPLv2 or later
**************************************************************************/

defined( 'ABSPATH' ) or die( "No script kiddies please!" );
/*
 * Define plugin absolute path and url
 */
define( 'AUSAY_DIR', rtrim( plugin_dir_path( __FILE__ ), '/' ) );
define( 'AUSAY_URL', rtrim( plugin_dir_url( __FILE__ ), '/' ) );
include( AUSAY_DIR . '/class-options.php' );



$causay_configs = array(
	'plugin_slug' => 'aus_accessibility',
	'plugin_name' => '№ 355 - Accessibility',
);
$aus_accessibility_object = new AUS_tb_options( $causay_configs );




add_shortcode('aus_accessibility', function ($item=null) {
	global $aus_accessibility_object;

	if ($item) {
		return $aus_accessibility_object->display_aus_accessibility_item($item['item']);
	}else {
		return $aus_accessibility_object->display_aus_accessibility();
	}
});

