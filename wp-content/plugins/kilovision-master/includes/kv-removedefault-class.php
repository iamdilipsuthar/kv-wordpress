<?php 

if( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if( ! class_exists('kvp_admin') ) :

class kvp_admin {
	
	private $options_general;
	
	function __construct() {

		add_action('admin_menu', 			array($this, 'kvp_admin_menu'));
		add_action( 'admin_init', array( $this, 'kv_options_init' ) );
		
		add_action( 'login_enqueue_scripts', array( $this, 'kv_change_admin_logo' ) );
		add_action( 'login_headerurl', array( $this, 'kv_change_admin_logo_url' ),1,10 );
		
	}
	function kv_change_admin_logo_url($url){
		return site_url();
	}
    function kv_change_admin_logo(){
		$logopath = KVP_URL . 'assets/kilo.jpg';
		?>
		<style type="text/css"> 
			body.login div#login h1 a {
			background-image: url(<?php echo $logopath; ?>);  //Add your own logo image in this url 
			padding-bottom: 30px; 
			} 
		</style>
		<?php
	}
	function kvp_admin_menu() {

		// remove_menu_page('edit.php');
		// remove_menu_page('edit.php?post_type=page');
		remove_menu_page('themes.php');
		add_submenu_page( "users.php" , "Role values" , "Role values", 'manage_options', 'role_values', array( $this , 'kvp_role_setting_template' ));

	}
	
	function kvp_role_setting_template() {
		$this->options_general = get_option( 'kvp_general' );
		?>
        <div class="wrap">
            <h1>Role value settings</h1>
            <h2 class="nav-tab-wrapper">
							<a href="<?php echo admin_url( 'admin.php?page=role_values&tab=general' ); ?>" class="nav-tab nav-tab-active"><?php esc_html_e( 'General' ); ?></a>
						</h2>
        	 <form method="post" action="options.php"><?php 
								settings_fields( 'kvp_general' );
								do_settings_sections( 'kvp-setting-general' );
								submit_button();
							?>
						</form>
        </div> <?php
	}
	public function kv_options_init() { 
		register_setting(
				'kvp_general', // Option group 
				'kvp_general', // Option name
				array( $this, 'sanitize' ) // Sanitize
		);
		add_settings_section(
			'general_settings_sec', // ID
			'General Settings', // Title
			array( $this, 'print_section_info' ), // Callback
			'kvp-setting-general' // Page
		); 
		add_settings_field(
				'logo_image', 
				'Logo Image', 
				array( $this, 'logo_image_callback' ), 
				'kvp-setting-general', // Page
				'general_settings_sec' // Section id
		);  


	}
	public function print_section_info(){
	//your code...
		echo 'Note';
		print_r(get_option( 'kvp_general' ));
		
	}
	public function logo_image_callback() {
		printf(
				'<input type="text" name="kvp_general[logo_image]" id="logo_image" value="%s"> <a href="#" id="logo_image_url" class="button" > Select </a>',
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

// initialize
kvp()->admin = new kvp_admin();

endif; // class_exists check

?>