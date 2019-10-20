<?php


if( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if( ! class_exists('kvp_admin_posttype') ) :

class kvp_admin_posttype {
	
	function __construct() {
    // add_action('init', 			array($this, 'register_post_types_beats'));
    add_action('init', 			array($this, 'register_post_types_booking'));
    add_action('init', 			array($this, 'register_post_types_events'));
    // add_action('init', 			array($this, 'register_post_types_tracks'));
  }
	function register_post_types_beats() {
    $args = array(
      'public' => true,
      'show_in_rest' => true,
      'label' => 'Beats',
      'menu_icon' => 'dashicons-playlist-audio',
    );
    register_post_type( 'beat', $args );
	}
	function register_post_types_events() {
   
    $args = array(
      'public' => true,
      'show_in_rest' => true,
      'label' => 'Event',
      'labels' => array( 
                'singular_name' => 'Event',
                'name' => 'Events',
                'add_new_item' => 'Add new event'
              ),
      'menu_icon' => 'dashicons-megaphone'
    );
    register_post_type( 'event', $args );
  }
  function register_post_types_booking() {
      $args = array(
        'public' => true,
        'show_in_rest' => true,
        'label' => 'Bookings',
        'labels' => array( 
          'singular_name' => 'Booking',
          'name' => 'Bookings',
          'add_new_item' => 'Add new booking'
        ),
        'supports' => array('title', 'custom-fields', 'author'),
        'menu_icon' => 'dashicons-networking',
      );
      register_post_type( 'booking', $args );
  }
  function register_post_types_tracks() {
      $args = array(
        'public' => true,
        'show_in_rest' => true,
        'label' => 'Tracks',
        'menu_icon' => 'dashicons-controls-play',
      );
      register_post_type( 'track', $args );
  }
}

// initialize
$newPostTypes = new kvp_admin_posttype();

endif; // class_exists check

