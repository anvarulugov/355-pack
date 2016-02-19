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

	/**
	 * Class init
	 * @return [initiating] [Fires on Wordpress init stage]
	 */
	public function init() {
		add_shortcode( 'tc-ac-modes', array( $this, 'accessibility_shortcode' ) );
//		add_shortcode('show_languages', function () {
//			global $q_config;
////			echo "<pre>";
////			print_r($q_config);
////			exit;
//			if (is_404()) {
//				$url = get_option('home');
//			}else{ $url = '';}
//			$flag_location = qtranxf_flag_location();
//			$html = "";
//			foreach ($qtranxf_getSortedLanguages() as $language) {
//				$classes = ['lang-' . $language];
//				if ($language == $q_config['language']) {
//					$classes[] = 'active';
//				}
//				$html .= '<a class="' . implode('', $classes) . '" href="' . $qtranxf_convertURL($url, $language, false, true) . '"
//							 hreflang="' . $language . '" title="' . $q_config['language_name'][$language] . '">
//							 <img src="' . $flag_location . $q_config['flag'][$language] . '" alt="' . $q_config['language_name'][$language] . '" />
//						  </a>';
//			}
//			return $html;
//		});
	}

	public function scripts() {

	}

	public function widgets_load() {

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

//
//add_shortcode( 'aus_accessibility',function($item=null){
//
//	$causay_configs = array(
//		'plugin_slug' => 'tclick-pack',
//		'plugin_name' => 'TC 355 Pack',
//	);
//	$aus_accessibility_objecte = new AUS_tb_options($causay_configs);
//	if ($item) {
//
//		return $aus_accessibility_objecte->display_aus_accessibility_item($item['item']);
//	}else {
//		return $aus_accessibility_objecte->display_aus_accessibility();
//	}
//} );