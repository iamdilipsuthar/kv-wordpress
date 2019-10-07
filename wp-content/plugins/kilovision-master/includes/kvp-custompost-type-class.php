<?php


if( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if( ! class_exists('kvp_admin_posttype') ) :

class kvp_admin_posttype {
	
	function __construct() {
	
		// actions
    add_action('init', 			array($this, 'register_post_types_orders'));
    add_action('init', 			array($this, 'register_post_types_beats'));
    add_action('init', 			array($this, 'register_post_types_events'));
    add_action('init', 			array($this, 'register_post_types_tracks'));
		// add_action('admin_enqueue_scripts',	array($this, 'admin_enqueue_scripts'), 0);
  }
    

       
	
	function register_post_types_beats() {
    $labels = array(
      'name'                => _x( 'Beats', 'Post Type General Name', 'kilovision' ),
      'singular_name'       => _x( 'Beat', 'Post Type Singular Name', 'kilovision' ),
      'menu_name'           => __( 'Beats', 'kilovision' ),
      'parent_item_colon'   => __( 'Parent Beat', 'kilovision' ),
      'all_items'           => __( 'All Beats', 'kilovision' ),
      'view_item'           => __( 'View Beat', 'kilovision' ),
      'add_new_item'        => __( 'Add New Beat', 'kilovision' ),
      'add_new'             => __( 'Add New', 'kilovision' ),
      'edit_item'           => __( 'Edit Beat', 'kilovision' ),
      'update_item'         => __( 'Update Beat', 'kilovision' ),
      'search_items'        => __( 'Search Beat', 'kilovision' ),
      'not_found'           => __( 'Not Found', 'kilovision' ),
      'not_found_in_trash'  => __( 'Not found in Trash', 'kilovision' ),
    );

    // Set other options for Custom Post Type

    $args = array(
      'label'               => __( 'beats', 'kilovision' ),
      'description'         => __( 'Beat news and reviews', 'kilovision' ),
      'labels'              => $labels,
      // Features this CPT supports in Post Editor
      'supports'            => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'revisions', 'custom-fields', ),
      // You can associate this CPT with a taxonomy or custom taxonomy. 
      'taxonomies'          => array( 'genres' ),
      /* A hierarchical CPT is like Pages and can have
      * Parent and child items. A non-hierarchical CPT
      * is like Posts.
      */ 
      'hierarchical'        => false,
      'public'              => true,
      'show_ui'             => true,
      'show_in_menu'        => true,
      'show_in_nav_menus'   => true,
      'show_in_admin_bar'   => true,
      'menu_position'       => 5,
      'can_export'          => true,
      'has_archive'         => true,
      'exclude_from_search' => false,
      'publicly_queryable'  => true,
      'capability_type'     => 'page',
      'menu_icon' => 'dashicons-playlist-audio'
    );
    register_post_type( 'beats', $args );
	}
	function register_post_types_events() {
    $labels = array(
      'name'                => _x( 'Events', 'Post Type General Name', 'kilovision' ),
      'singular_name'       => _x( 'Event', 'Post Type Singular Name', 'kilovision' ),
      'menu_name'           => __( 'Events', 'kilovision' ),
      'parent_item_colon'   => __( 'Parent Event', 'kilovision' ),
      'all_items'           => __( 'All Events', 'kilovision' ),
      'view_item'           => __( 'View Event', 'kilovision' ),
      'add_new_item'        => __( 'Add New Event', 'kilovision' ),
      'add_new'             => __( 'Add New', 'kilovision' ),
      'edit_item'           => __( 'Edit Event', 'kilovision' ),
      'update_item'         => __( 'Update Event', 'kilovision' ),
      'search_items'        => __( 'Search Event', 'kilovision' ),
      'not_found'           => __( 'Not Found', 'kilovision' ),
      'not_found_in_trash'  => __( 'Not found in Trash', 'kilovision' ),
    );
    // Set other options for Custom Post Type
    $args = array(
      'label'               => __( 'events', 'kilovision' ),
      'description'         => __( 'Event news and reviews', 'kilovision' ),
      'labels'              => $labels,
      // Features this CPT supports in Post Editor
      'supports'            => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'revisions', 'custom-fields', ),
      // You can associate this CPT with a taxonomy or custom taxonomy. 
      'taxonomies'          => array( 'genres' ),
      /* A hierarchical CPT is like Pages and can have
      * Parent and child items. A non-hierarchical CPT
      * is like Posts.
      */ 
      'hierarchical'        => false,
      'public'              => true,
      'show_ui'             => true,
      'show_in_menu'        => true,
      'show_in_nav_menus'   => true,
      'show_in_admin_bar'   => true,
      'menu_position'       => 5,
      'can_export'          => true,
      'has_archive'         => true,
      'exclude_from_search' => false,
      'publicly_queryable'  => true,
      'capability_type'     => 'page',
      'menu_icon' => 'dashicons-megaphone'
    );

    // Registering your Custom Post Type
    register_post_type( 'events', $args );
		// wp_enqueue_style( 'acf-global' );
		
  }
  function register_post_types_orders() {
    
    $labels = array(
      'name'                => _x( 'Orders', 'Post Type General Name', 'kilovision' ),
      'singular_name'       => _x( 'Order', 'Post Type Singular Name', 'kilovision' ),
      'menu_name'           => __( 'Orders', 'kilovision' ),
      'parent_item_colon'   => __( 'Parent Order', 'kilovision' ),
      'all_items'           => __( 'All Orders', 'kilovision' ),
      'view_item'           => __( 'View Order', 'kilovision' ),
      'add_new_item'        => __( 'Add New Order', 'kilovision' ),
      'add_new'             => __( 'Add New', 'kilovision' ),
      'edit_item'           => __( 'Edit Order', 'kilovision' ),
      'update_item'         => __( 'Update Order', 'kilovision' ),
      'search_items'        => __( 'Search Order', 'kilovision' ),
      'not_found'           => __( 'Not Found', 'kilovision' ),
      'not_found_in_trash'  => __( 'Not found in Trash', 'kilovision' ),
      );
  
      // Set other options for Custom Post Type
  
      $args = array(
      'label'               => __( 'orders', 'kilovision' ),
      'description'         => __( 'Order news and reviews', 'kilovision' ),
      'labels'              => $labels,
      // Features this CPT supports in Post Editor
      'supports'            => array('comments', 'custom-fields', ),
      // You can associate this CPT with a taxonomy or custom taxonomy. 
      'taxonomies'          => array( 'genres' ),
      /* A hierarchical CPT is like Pages and can have
      * Parent and child items. A non-hierarchical CPT
      * is like Posts.
      */ 
      'hierarchical'        => false,
      'public'              => true,
      'show_ui'             => true,
      'show_in_menu'        => true,
      'show_in_nav_menus'   => true,
      'show_in_admin_bar'   => true,
      'menu_position'       => 8,
      'can_export'          => true,
      'has_archive'         => true,
      'exclude_from_search' => false,
      'publicly_queryable'  => true,
      'capability_type'     => 'page',
      'menu_icon' => 'dashicons-networking'
      );
      register_post_type( 'orders', $args );
  }
  function register_post_types_tracks() {
    
    $labels = array(
      'name'                => _x( 'Tracks', 'Post Type General Name', 'kilovision' ),
      'singular_name'       => _x( 'Track', 'Post Type Singular Name', 'kilovision' ),
      'menu_name'           => __( 'Tracks', 'kilovision' ),
      'parent_item_colon'   => __( 'Parent Track', 'kilovision' ),
      'all_items'           => __( 'All Tracks', 'kilovision' ),
      'view_item'           => __( 'View Track', 'kilovision' ),
      'add_new_item'        => __( 'Add New Track', 'kilovision' ),
      'add_new'             => __( 'Add New', 'kilovision' ),
      'edit_item'           => __( 'Edit Track', 'kilovision' ),
      'update_item'         => __( 'Update Track', 'kilovision' ),
      'search_items'        => __( 'Search Track', 'kilovision' ),
      'not_found'           => __( 'Not Found', 'kilovision' ),
      'not_found_in_trash'  => __( 'Not found in Trash', 'kilovision' ),
      );
  
      // Set other options for Custom Post Type
  
      $args = array(
      'label'               => __( 'tracks', 'kilovision' ),
      'description'         => __( 'Track news and reviews', 'kilovision' ),
      'labels'              => $labels,
      // Features this CPT supports in Post Editor
      'supports'            => array('comments', 'custom-fields', 'title', 'author'),
      // You can associate this CPT with a taxonomy or custom taxonomy. 
      'taxonomies'          => array( 'genres' ),
      /* A hierarchical CPT is like Pages and can have
      * Parent and child items. A non-hierarchical CPT
      * is like Posts.
      */ 
      'hierarchical'        => false,
      'public'              => true,
      'show_ui'             => true,
      'show_in_menu'        => true,
      'show_in_nav_menus'   => true,
      'show_in_admin_bar'   => true,
      'menu_position'       => 8,
      'can_export'          => true,
      'has_archive'         => true,
      'exclude_from_search' => false,
      'publicly_queryable'  => true,
      'menu_icon' => 'dashicons-controls-play',
      'capability_type'     => array('track','tracks'),
      'map_meta_cap'        => true,
      );
      register_post_type( 'tracks', $args );
  }
}

// initialize
$newPostTypes = new kvp_admin_posttype();

endif; // class_exists check

