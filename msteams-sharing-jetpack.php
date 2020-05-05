<?php
/*
 * Plugin Name: Microsoft Teams Sharing for Jetpack
 * Plugin URI: https://dev.commons.hwdsb.on.ca
 * Description: Add a Microsoft Teams button to the Jetpack Sharing module
 * Author: mrjarbenne
 * Version: 1.0
 * Author URI: https://mrjarbenne.ca
 * License: GPL2+
 * Text Domain: mstjp
 */

class MSTeams_Button {
	private static $instance;

	static function get_instance() {
		if ( ! self::$instance )
			self::$instance = new MSTeams_Button;

		return self::$instance;
	}

	private function __construct() {
		// Check if Jetpack and the sharing module is active
		if ( class_exists( 'Jetpack' ) && Jetpack::is_module_active( 'sharedaddy' ) ) {
			add_action( 'plugins_loaded', array( $this, 'setup' ) );
		} else {
			add_action( 'admin_notices',  array( $this, 'install_jetpack' ) );
		}
	}

	public function setup() {
		add_filter( 'sharing_services', array( $this, 'inject_service' ) );
	}

	// Add the Microsoft Teams Button to the list of services in Sharedaddy
	public function inject_service ( $services ) {
		include_once 'class.msteams-sharing-jetpack.php';
		if ( class_exists( 'Share_MSTeams' ) ) {
			$services['msteams'] = 'Share_MSTeams';
		}
		return $services;
	}

	// Prompt to install Jetpack
	public function install_jetpack() {
		echo '<div class="error"><p>';
		printf(__( 'To use the Microsoft Teams Sharing plugin, you\'ll need to install and activate <a href="%1$s">Jetpack</a> first, and <a href="%2$s">activate the Sharing module</a>.'),
		'plugin-install.php?tab=search&s=jetpack&plugin-search-input=Search+Plugins',
		'admin.php?page=jetpack_modules',
		'mstjp'
		);
		echo '</p></div>';
	}

}
// And boom.
MSTeams_Button::get_instance();
