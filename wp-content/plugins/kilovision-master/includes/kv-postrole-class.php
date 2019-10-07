<?php 

if( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if( ! class_exists('kvp_posttype_role') ) :

class kvp_posttype_role {

    protected $kvp_roles;

    function __construct() {
        $this->kvp_roles = array( 'gold', 'silver', 'platinum', 'bronze' );
        // add_action( 'admin_init' , array($this, 'kvp_roles_on_plugin_activation') );
    }
    
    function kvp_roles_on_plugin_activation() {
        $roles = $this->kvp_roles;
        foreach( $roles as $role){
            remove_role( $role, ucfirst($role) );
        }
    }
    function kvp_add_role_capability(){
        // $roles = $this->kvp_roles;
        // foreach( $roles as $role){
        //     $admins = get_role( $role );
        //     $admins->remove_cap( 'edit_tracks' ); 
        //     $admins->remove_cap( 'create_track' ); 
        //     $admins->remove_cap( 'publish_tracks' ); 
        //     $admins->remove_cap( 'delete_published_tracks' ); 
        //     $admins->remove_cap( 'edit_published_tracks' ); 
        //     $admins->remove_cap( 'delete_track' ); 
        //     $admins->remove_cap( 'publish_track' ); 
        // unset($admins);
        // }
    }
    public function kv_options_init() { 
        register_setting(
           'vaajo_general', // Option group
           'vaajo_general', // Option name
           array( $this, 'sanitize' ) // Sanitize
       );

       add_settings_section(
           'setting_section_id', // ID
           'All Settings', // Title
           array( $this, 'print_section_info' ), // Callback
           'vaajo-setting-admin' // Page
       ); 
        add_settings_field(
           'logo_image', 
           'Logo Image', 
           array( $this, 'logo_image_callback' ), 
           'vaajo-setting-admin', 
           'setting_section_id'
       );  
       
       
       register_setting(
           'vaajo_social', // Option group
           'vaajo_social', // Option name
           array( $this, 'sanitize' ) // Sanitize
       );
       add_settings_section(
           'setting_section_id', // ID
           'Social Settings', // Title
           array( $this, 'print_section_info' ), // Callback
           'vaajo-setting-social' // Page
       );  
       
        add_settings_field(
           'fb_url', // ID
           'Facebook URL', // Title 
           array( $this, 'fb_url_callback' ), // Callback
           'vaajo-setting-social', // Page
           'setting_section_id' // Section           
       );
       
       
       register_setting(
           'vaajo_footer', // Option group
           'vaajo_footer', // Option name
           array( $this, 'sanitize' ) // Sanitize
       );
       add_settings_section(
           'setting_section_id', // ID
           'Footer Details', // Title
           array( $this, 'print_section_info' ), // Callback
           'vaajo-setting-footer' // Page
       );         

       add_settings_field(
           'hide_more_themes', 
           'Hide Find more themes at Kvcodes.com', 
           array( $this, 'hide_more_themes_callback' ), 
           'vaajo-setting-footer', 
           'setting_section_id'
       );
   }


   public function print_section_info(){
           //your code...
   }


   public function fb_url_callback() {
       printf(
           '<input type="text" id="fb_url" name="vaajo_social[fb_url]" value="%s" />',
           isset( $this->options_social['fb_url'] ) ? esc_attr( $this->options_social['fb_url']) : ''
       );
   }

   public function hide_more_themes_callback(){
       printf(
           '<input type="checkbox" id="hide_more_themes" name="vaajo_footer[hide_more_themes]" value="yes" %s />',
           (isset( $this->options_footer['hide_more_themes'] ) && $this->options_footer['hide_more_themes'] == 'yes') ? 'checked' : ''
       );
   }

   public function logo_image_callback() {
       printf(
           '<input type="text" name="vaajo_general[logo_image]" id="logo_image" value="%s"> <a href="#" id="logo_image_url" class="button" > Select </a>',
           isset( $this->options_general['logo_image'] ) ? esc_attr( $this->options_general['logo_image']) : ''
            );
   }

  public function sanitize( $input )  {
       $new_input = array();
       if( isset( $input['fb_url'] ) )
           $new_input['fb_url'] = sanitize_text_field( $input['fb_url'] );
     
       if( isset( $input['hide_more_themes'] ) )
           $new_input['hide_more_themes'] = sanitize_text_field( $input['hide_more_themes'] );
      
       if( isset( $input['logo_image'] ) )
           $new_input['logo_image'] = sanitize_text_field( $input['logo_image'] );

       return $new_input;
   }
	
}

// $kvp_posttype_role = new kvp_posttype_role();

add_action( 'admin_init', array($kvp_posttype_role, 'kvp_add_role_capability'));


endif; // class_exists check

?>