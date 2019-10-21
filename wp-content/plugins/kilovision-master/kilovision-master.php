<?php
/**
 * Plugin Name:     Kilovision Api Master
 * Description:     All custom api code stays here!
 * Author:          Kilovision
 * Text Domain:     kilovision
 * Domain Path:     /languages
 * Version:         0.2                                                                                             .0
 *
 */

use Kvp\Jwtauth;

if( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if(file_exists(dirname( __FILE__ ).'/vendor/autoload.php')){
	require_once dirname( __FILE__ ).'/vendor/autoload.php';
}

if( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if( ! class_exists('Kvpmain') ) :


class Kvpmain {

	var $version = '1.0';

	var $settings = array();

	var $data = array();

	function run_jwt_auth()
	{
		$plugin = new Kvp\Jwtauth();
		$plugin->run();
		
	
	}
	function __construct() { 
		register_activation_hook(__FILE__, array($this, 'kvp_posttype_role'));
		// add_action( 'init' , array($this, 'kvp_posttype_role'));
	}

	function initialize() {
		// vars
		$version = $this->version;
		$basename = plugin_basename( __FILE__ );
		$path = plugin_dir_path( __FILE__ );
		$url = plugin_dir_url( __FILE__ );
		$slug = dirname($basename);
		// settings
		$this->settings = array(
			
			// basic
			'name'				=> __('Kilo vision', 'kvp'),
			'version'			=> $version,
						
			// urls
			'file'				=> __FILE__,
			'basename'			=> $basename,
			'path'				=> $path,
			'url'				=> $url,
			'slug'				=> $slug,
			
			// options
			'show_admin'				=> true,
			'show_updates'				=> true,
			'stripslashes'				=> false,
			'local'						=> true,
			'json'						=> true,
			'save_json'					=> '',
			'load_json'					=> array(),
			'default_language'			=> '',
			'current_language'			=> '',
			'capability'				=> 'manage_options',
			'uploader'					=> 'wp',
			'autoload'					=> false,
			'l10n'						=> true,
			'l10n_textdomain'			=> '',
			'google_api_key'			=> '',
			'google_api_client'			=> '',
			'enqueue_google_maps'		=> true,
			'enqueue_select2'			=> true,
			'enqueue_datepicker'		=> true,
			'enqueue_datetimepicker'	=> true,
			'select2_version'			=> 4,
			'row_index_offset'			=> 1,
			'remove_wp_meta_box'		=> true
		);
		
		
		// constants
		$this->define( 'KVP', 			true );
		$this->define( 'KVP_VERSION', 	$version );
		$this->define( 'KVP_PATH', 		$path );
		$this->define( 'KVP_URL', 		$url );
		
		// Include utility functions.
		// include_once( KVP_PATH . 'includes/default-config.php');
		include_once( KVP_PATH . 'includes/kvp-user-routes-class.php');
		include_once( KVP_PATH . 'includes/kv-pricing-routes.php');
		// die();
		include_once( KVP_PATH . 'includes/kv-members-class.php');
		include_once( KVP_PATH . 'includes/kvp-custompost-type-class.php');
		include_once( KVP_PATH . 'includes/kv-removedefault-class.php');
		if( is_admin() ) {
			include_once( KVP_PATH . 'includes/kv-admin-functions.php');
			
		}
		
		// actions

		add_action('init',	array($this, 'init'), 5);
		
	}

	function kvp_posttype_role(){
		// include_once( KVP_PATH . 'includes/kv-postrole-class.php');
	}
	function init(){
		
		// Registering your Custom Post Type
		
	}
	function define( $name, $value = true ) {
		if( !defined($name) ) {
			define( $name, $value );
		}
	}
}

function kvp() {
	global $kvp;
	if( !isset($kvp) ) {
		$kvp = new Kvpmain();
		$kvp->initialize();
	}
	return $kvp;
}
// initialize
kvp();
endif; // class_exists check

add_filter('logout_url', 'kvp_logout_url', 10, 2);

function kvp_logout_url( $logout_url, $redirect ) {
    return home_url('/wp-login.php' . $redirect);
}



?>