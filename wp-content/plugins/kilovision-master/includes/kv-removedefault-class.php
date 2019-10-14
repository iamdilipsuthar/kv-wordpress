<?php 

if( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if( ! class_exists('kvp_admin') ) :

class kvp_admin {
	
	private $options_bronze;
	private $options_gold;
	private $options_silver;
	private $options_platinum;
	
	function __construct() {

		add_action('admin_menu', 			array($this, 'kvp_admin_menu'));
		add_action( 'admin_init', array( $this, 'kv_options_init' ) );
		
		add_action( 'login_enqueue_scripts', array( $this, 'kv_change_admin_logo' ) );
		add_action( 'login_headerurl', array( $this, 'kv_change_admin_logo_url' ),1,10 );
		// add_action( 'admin_enqueue_scripts', array( $this, 'kvp_admin_style'));
		
	}
	function kvp_admin_style(){
		wp_enqueue_style( 'my_custom_style', KVP_URL . 'assets/custom-admin.css', array(), '1.0' );
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
		add_submenu_page( "users.php" , "Member settings" , "Member settings", 'manage_options', 'member_settings', array( $this , 'kvp_role_setting_template' ));

	}
	function get_active_tab_cls($active_tab,$tab){
		return $active_tab == $tab ? 'nav-tab-active' : '' ;
	}
	function kvp_role_setting_template() {
		$tab = $_GET['tab'] ? $_GET['tab'] : 'bronze';
		$this->options_bronze = get_option( 'kvp_bronze' );
		$this->options_silver = get_option( 'kvp_silver' );
		$this->options_gold = get_option( 'kvp_gold' );
		$this->options_platinum = get_option( 'kvp_platinum' );
		?>
        <div class="wrap">
            <h1><?php _e('Member setting values','kilovision'); ?></h1>
            <h2 class="nav-tab-wrapper">
							<a href="<?php echo admin_url( 'admin.php?page=member_settings&tab=bronze' ); ?>" class="nav-tab member-bronze <?php echo $this->get_active_tab_cls($tab, 'bronze'); ?>"><?php esc_html_e( 'Bronze' ); ?></a>
							<a href="<?php echo admin_url( 'admin.php?page=member_settings&tab=silver' ); ?>" class="nav-tab member-silver <?php echo $this->get_active_tab_cls($tab, 'silver'); ?>"><?php esc_html_e( 'Silver' ); ?></a>
							<a href="<?php echo admin_url( 'admin.php?page=member_settings&tab=gold' ); ?>" class="nav-tab member-gold <?php echo $this->get_active_tab_cls($tab, 'gold'); ?>"><?php esc_html_e( 'Gold' ); ?></a>
							<a href="<?php echo admin_url( 'admin.php?page=member_settings&tab=platinum' ); ?>" class="nav-tab member-platinum <?php echo $this->get_active_tab_cls($tab, 'platinum'); ?>"><?php esc_html_e( 'Platinum' ); ?></a>
						</h2>
					 <form method="post" action="options.php"><?php 
								 
								 if(isset($tab)){
									 settings_fields( 'kvp_'.$tab );
									 do_settings_sections( 'kvp-setting-'.$tab );
									 submit_button();
								 }
							?>
						</form>
        </div> <?php
	}
	public function kv_options_init() { 
		add_settings_section(
			'bronze_settings_sec', // ID
			null, // Title
			null,
			'kvp-setting-bronze' // Page
		); 

		register_setting(
				'kvp_bronze', // Option group 
				'kvp_bronze', // Option name
				array( $this, 'sanitize' ) // Sanitize
		);
		add_settings_field(
			'logo_image', 
			'Logo Image', 
			array( $this, 'logo_image_callback' ), 
			'kvp-setting-bronze', // Page
			'bronze_settings_sec' // Section id
		);  
		
	

	}
	public function logo_image_callback() {
		printf(
				'<input type="text" name="kvp_bronze[logo_image]" id="logo_image" value="%s"> <a href="#" id="logo_image_url" class="button" > Select </a>',
				isset( $this->options_bronze['logo_image'] ) ? esc_attr( $this->options_bronze['logo_image']) : ''
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