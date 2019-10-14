<?php

// http://nitinsawant.com/timeslotpicker/
if( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if( ! class_exists('kvp_admin_posttype') ) :

class kvp_admin_posttype {
	
	function __construct() {
    add_action('init', 			array($this, 'register_post_types_beats'));
    add_action('init', 			array($this, 'register_post_types_bookings'));
    add_action('init', 			array($this, 'register_post_types_events'));
    add_action('init', 			array($this, 'register_post_types_tracks'));
  }
	function register_post_types_beats() {
    $args = array(
      'public' => true,
      'show_in_rest' => true,
      'publicly_queryable' => false,
      'label' => 'Beats',
      'menu_icon' => 'dashicons-playlist-audio',
      'capability_type'     => array('beat','beats'),
      'supports' => array( 'editor', 'title', 'thumbnail', 'comments'),
      'map_meta_cap'        => true,
    );
    register_post_type( 'beat', $args );
	}
	function register_post_types_events() {
   
    $args = array(
      'public' => true,
      'show_in_rest' => true,
      'publicly_queryable' => false,
      'label' => 'Events',
      'menu_icon' => 'dashicons-megaphone',
      'capability_type'     => array('event','events'),
      'map_meta_cap'        => true,
    );
    register_post_type( 'event', $args );
  }
  function register_post_types_bookings() {
      $args = array(
        'public' => true,
        'label' => 'Bookings',
        'show_in_rest' => true,
        'publicly_queryable' => false,
        'capability_type'     => array('booking','bookings'),
        'supports' => array('author', 'title'),
        'map_meta_cap'        => true,
      );
      register_post_type( 'booking', $args );
  }
  function register_post_types_tracks() {
      $args = array(
        'public' => true,
        'show_in_rest' => true,
        'publicly_queryable' => false,
        'label' => 'Tracks',
        'menu_icon' => 'dashicons-controls-play',
        'capability_type'     => array('track','tracks'),
        'supports' => array('author', 'editor', 'title', 'thumbnail'),
        'map_meta_cap'        => true,
      );
      register_post_type( 'track', $args );
  }
}

// initialize
$newPostTypes = new kvp_admin_posttype();

endif; // class_exists check

