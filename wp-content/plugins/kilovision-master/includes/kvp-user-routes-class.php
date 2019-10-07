<?php 

if( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if( ! class_exists('kvp_user_routes') ) :

class kvp_user_routes {

    private $response;
    function __construct() {
        $this->response = array();
        add_action( 'rest_api_init' , array($this, 'wpshout_register_routes') );
    }
    function wpshout_register_routes(){
        register_rest_route( 
            'kvp/v1',
            '/login',
            array(
                'methods' => 'GET',
                'callback' => array($this, 'kvp_login'),
            )
        );
        register_rest_route( 
            'kvp/v1',
            '/register',
            array(
                'methods' => 'GET',
                'callback' => array($this, 'kvp_register'),
            )
        );

    }
    function kvp_register($request){

        $username = $request['username'];
        $user_exist = username_exists($username);
        if(!$user_exist){
            $pass = $request['password'];
            $email = $request['email'];
            $user_id = wp_create_user( $username, $pass , $email );
            if(is_wp_error($user_id)){
                $this->response = array(
                    'message' => 'Email already exists!',
                    'success' => false
                );    
            }else{
                $this->response = array(
                    'message' => 'Registered successfully.',
                    'success' => true
                );    
            }
        }else{
            $this->response = array(
                'message' => 'Username already exists!',
                'success' => false
            );
        }
        return $this->response;
        
    }
    function kvp_login($request){
        $creds = array(
            'user_login'    => $request['username'],
            'user_password' => $request['password'],
        );
        $user = wp_signon( $creds, false );
        if ( is_wp_error( $user ) ) {
            $this->response = array(
                'message' => 'Username or password is wrong!',
                'success' => false
            );
        }else{
            $this->response = array(
                'message' => 'Logged',
                'success' => true
            );
        }
        return $this->response;
    }
}

$kvp_user_routes = new kvp_user_routes();

endif; // class_exists check

?>