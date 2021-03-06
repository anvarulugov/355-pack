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


class TClick_pack {

	public $configs;

	/**
	 * Class construction
	 */
	public function __construct() {
		// Options class configs
		$this->configs = array(
			'plugin_slug' => 'tclick-pack',
			'plugin_name' => 'TC 355 Pack',
		);
		// Initiating the Options class to generate plugin options page
		new AUS_tb_options( $this->configs );
		add_action( 'init', array( $this, 'init' ) );
	}



	public function init() {
		add_shortcode( 'tc-ac-modes', array( $this, 'accessibility_shortcode' ) );
		add_filter('widget_text', 'do_shortcode');
	}

	public function scripts() {

	}

	public function widgets_load() {

	}

	public function activate() {
		$defaults = array(
			'language_page_id' => '',
			'rss_page_id' => '',
			'voice_type' => '',
			'voice_page_id' => '',
			'bootstrap_style_page_id' => '',
			'position_language' => '',
			'language_uz' => '',
			'language_show' => '',
			'language_ru' => '',
			'language_en' => '',
			'accessibility_plugin_position' => '',
//			'voice_page_id' => '',
			'mobile_page_id' => '',
			'sitemap_page_id' => '',
			'contact_page_id' => '',
			'blind_mode' => '',
			'search_page_id_check' => '',
		);
		$options = get_option( $this->configs['plugin_slug'] . '_plugin_options' );
		if ( empty( $options )) {
			update_option( $this->configs['plugin_slug'] . '_plugin_options', $defaults );
		}
	}


	public function accessibility_shortcode($item=null) {
		$aus_accessibility_object = new AUS_tb_options($this->configs);
		if ($item) {
			return $aus_accessibility_object->display_aus_accessibility_item($item['item']);
		}else {
			return $aus_accessibility_object->display_aus_accessibility();
		}
	}

}

$r =  new TClick_pack();
