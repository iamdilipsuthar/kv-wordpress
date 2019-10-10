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
                'methods' => 'POST',
                'callback' => array($this, 'kvp_login'),
            )
        );
        register_rest_route( 
            'kvp/v1',
            '/register',
            array(
                'methods' => 'POST',
                'callback' => array($this, 'kvp_register'),
            )
        );
        register_rest_route( 
            'kvp/v1',
            '/sociallogin',
            array(
                'methods' => 'POST',
                'callback' => array($this, 'kvp_social_login'),
            )
        );
        register_rest_route( 
            'kvp/v1',
            '/forgotpassword',
            array(
                'methods' => 'POST',
                'callback' => array($this, 'kvp_forgotpassword'),
            )
        );
    }
    function kvp_send_resetpassword($id){
        $password = get_user_meta($id, 'forgot_password', true);

        $to = get_user_meta($id, 'user_email', true);

        wp_mail( $to, 'Forgot password request', 'Your password : '.$password);
        
    }
    function kvp_forgotpassword($request){
        $email = $request['email'];
        $user = email_exists($email);
        if($user){
            $this->kvp_send_resetpassword($id);
            $this->response = array(
                'message' => 'Check your email to get your password.',
                'success' => true
            );
            return new WP_REST_Response( $this->response, 200);
        }else{
            $this->response = array(
                'message' => 'Email not exists!',
                'success' => false
            );
        }   
        return new WP_REST_Response( $this->response, 302);
    }
    function kvp_social_login($request){
        $login_media = $request['social_obj'];

    }
    function get_user($id){
        $user = get_user_by( 'id', $id );
        return array(
            'email' => $user->user_email,
            'display_username' => $user->display_username,
            'role' => $user->roles[0],
            'total_booking'  => 1,
            'total_events'  => 2,
            'total_tracks'  => 3,
            'total_beats'  => 4,
        );
    }
    function set_default_role($id){
        $user = new WP_User($id);
        $user->set_role('none_member');
    }
    // function get_new_username($username){
    //     if(username_exists($username)){
    //         return $username.time();
    //     }else{
    //         return $username;
    //     }
    // }
    function kvp_register($request){

        $email = $request['email'];
        $user_exist = email_exists($email);
        if(!$user_exist){
            $useremail = $request['email'] ? $request['email'] : null;
            $username = $request['username'].time() ? $request['username'].time() : null;
            $userpass = $request['password'] ? $request['password'] : null;
            $user = wp_create_user( $username, $userpass , $useremail );
            add_user_meta($user, 'display_username', $request['username']);
            add_user_meta($user, 'forgot_password', $request['password']);
            if(is_wp_error($user)){
                $this->response = array(
                    'message' => 'Something went wrong try again.',
                    'success' => false
                );  
            }else{
                $this->set_default_role($user);
                // get user by id
                $this->response = array(
                    'data' => $this->get_user($user),
                    'success' => true
                );
            }
        }else{
            $this->response = array(
                'message' => 'Email already exists!',
                'success' => false
            );
        }
        return new WP_REST_Response( $this->response, 200);  
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