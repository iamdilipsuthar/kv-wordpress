<?php 

if( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if( ! class_exists('kvp_admin') ) :

class kvp_admin extends kvp_user_routes{
	
	private $options_general;
	private $roles;
	function __construct() {

		add_action('admin_menu', 			array($this, 'kvp_admin_menu'));
		add_action( 'admin_init', array( $this, 'kv_options_init' ) );
		
		add_action( 'login_enqueue_scripts', array( $this, 'kv_change_admin_logo' ) );
		add_action( 'login_headerurl', array( $this, 'kv_change_admin_logo_url' ),1,10 );
		add_filter('manage_users_columns',array($this, 'kvp_remove_users_columns' ),11,1);
		
		// add_action( 'rest_api_init' , array($this, 'pricing_register_routes') );
		$this->roles = array(
			'silver' => 'Silver',
			'gold' => 'Gold',
			'bronze' => 'Bronze',
			'platinum' => 'Platinum'
		);
	}
	function kvp_remove_users_columns($column){
		// unset($column['username']);
		// unset($column['name']);
		unset($column['posts']);
		// $column['DisplayName']
		return $column;
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
	function remove_admin_logo() {
		global $wp_admin_bar;
		$wp_admin_bar->remove_menu( 'wp-logo' );
	}
	
	function kvp_admin_menu() {
		remove_menu_page('edit.php');
		remove_menu_page('edit.php?post_type=page');
		remove_menu_page('themes.php');
		add_submenu_page( "users.php" , "Pricing" , "Pricing", 'manage_options', 'pricing', array( $this , 'kvp_role_setting_template' ));
		add_action( 'wp_before_admin_bar_render', array($this, 'remove_admin_logo'));
		add_filter( 'admin_footer_text', '__return_empty_string', 11 );
		add_filter( 'update_footer',     '__return_empty_string', 11 );
	}
	function kvp_role_setting_template() {
		$this->options_general = get_option( 'kvp_general_prices' ); 
		$tab = isset($_GET['tab']) ? $_GET['tab'] : 'silver';
		?>
		<style>
		#namediv.stuffbox .editcomment input {
				width: auto;
		}
		#namediv {
			width:30%;
		}
		#namediv input {
			width:auto;
		}
		</style>
        <div class="wrap">
            <h1><?php _e('Member pricing', 'kilovision'); ?></h1>
            <h2 class="nav-tab-wrapper">
			
			<?php foreach($this->roles as $key => $value) : ?>

				<a href="<?php echo admin_url( 'admin.php?page=pricing&tab='.$key ); ?>" class="nav-tab <?php echo $tab == $key ? 'nav-tab-active' : ''; ?>"><?php esc_html_e( $value ); ?></a>
			<?php endforeach;?>
			
			</h2>
			<div id="poststuff">
				<div id="namediv" class="stuffbox">
					<div class="inside">
						
						<form method="post" action="options.php">
							<?php settings_fields( "kvp_{$tab}" ); do_settings_sections( "kvp_{$tab}" ); ?>
							<fieldset>
								<table class="form-table editcomment" role="presentation" style="width:auto;">
									<!-- POINTS -->
									<tr>
										<td><?php _e( 'POINTS per 2 hour', 'kilovision'); ?></td>
										<td>
											<input type="text" name="<?php echo "kvp_{$tab}_points"; ?>" 
											value="<?php echo get_option("kvp_{$tab}_points"); ?>"
											size="40"></td>
									</tr>
									
									<!-- STUDIO RATES -->
									<tr>
										<td><?php _e( 'STUDIO Photoshoot rate', 'kilovision'); ?></td>
										<td>
											<input type="text" name="<?php echo "kvp_{$tab}_studio[videoshoot]"; ?>" 
											value="<?php echo get_option("kvp_{$tab}_studio")['videoshoot']; ?>"
											size="40"></td>
									</tr>
									<tr>
										<td><?php _e( 'STUDIO Videoshoot rate', 'kilovision'); ?></td>
										<td>
											<input type="text" name="<?php echo "kvp_{$tab}_studio[photoshoot]"; ?>" 
											value="<?php echo get_option("kvp_{$tab}_studio")['photoshoot']; ?>"
											size="40"/></td>
									</tr>

									<!-- % OFF ON PHOTOS & VID -->
									
									<!-- LIVE PROJECT TRACKING -->
									
									<!-- UNLIMITED FILE ACCESS -->
									
									<!-- % OFF BEATS -->

									<!-- FREE SHOOTS -->
									
									<!-- FREE BEATS -->
								
									<!-- COMP DRINKS -->
								
									<!-- FIRST FOR EVENTS AND OFFERS -->

									<tr>
										<td><input type="submit" name="submit" id="submit" class="button button-primary" value="Save Changes"></td>
									</tr>
									</tbody>
								</table>
							</fieldset>
							
						</form>
					</div>
				</div>
			</div>
        </div> 
		
		<?php
	}
	public function kv_options_init() { 
		foreach($this->roles as $key => $value) :
			register_setting(
					"kvp_{$key}", // Option group 
					"kvp_{$key}_studio" // Option names
			);
			register_setting(
				"kvp_{$key}", // Option group 
				"kvp_{$key}_points" // Option names
		);
			
	
		endforeach;
	}
}

// initialize
kvp()->admin = new kvp_admin();

endif; // class_exists check

?>