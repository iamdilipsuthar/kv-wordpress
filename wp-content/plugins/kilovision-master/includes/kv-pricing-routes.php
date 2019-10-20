<?php 

if( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if( ! class_exists('kvp_pricing_routes') ) :


class kvp_pricing_routes extends kvp_user_routes{
    private $response;
    function __construct() {
        $this->response = array();
        add_action( 'rest_api_init' , array($this, 'kvp_pricing_routes') );
    }
    function kvp_pricing_routes(){
        register_rest_route( 
            'kvp/v1',
            '/general_pricing',
            array(
                'methods' => 'GET',
                'callback' => array($this, 'kvp_general_pricing'),
            )
        );
    }
    function kvp_get_option($match){
		$options = wp_load_alloptions();
		$new_list = array();
		foreach($options as $key => $value){
			if (strpos($key, "kvp_$match") !== false) {
				$new_list[$key] = unserialize($value);
			}
		}
		return $new_list;
    }
    
    function kvp_general_pricing($request){
        $token = $this->validate_token(false);
        // return $token;
        if (is_wp_error($token)) {
            if ($token->get_error_code() == 'jwt_auth_no_auth_header') {
                /** If there is a error, store it to show it after see rest_pre_dispatch */
                return new WP_REST_Response( array(
                    'status' => false,
                    'message' => 'Authorization header not found.'
                ) , 503);      
            }
        }else{
            $user_id = $token->data->user->id;
            // return $token;
            if($user_id != ''){
                return new WP_REST_Response( $this->get_pricing($user_id) , 200);  
            }else{
                return new WP_REST_Response( $this->jwt_error , 200);  
            }
        }
    }
    function kvp_get_user_role($id){
        $user_info = get_userdata($id);
        if(!empty($user_info->roles)){
            return $user_info->roles[0];
        }else{
            return null;
        }
    }
    function get_pricing_data($role){
        // return "kvp_{$role}_{$ptype}";
        $pricing = get_option("kvp_{$role}");
        return $pricing;
    }
    function get_pricing($user){
        
        $role = $this->kvp_get_user_role($user);
        $pricing = $this->kvp_get_option($role);
        // return $role;
        if(count($pricing) > 0){
            $this->response = array($pricing);
            
        }else{
            $this->response = array(null);
            
        }
        return new WP_REST_Response($this->response , 200);  
    }
    
}

$kvp_pricing_routes = new kvp_pricing_routes();

endif; // class_exists check

?>