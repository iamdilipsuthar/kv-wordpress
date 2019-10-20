<?php 

use \Firebase\JWT\JWT;


if( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if( ! class_exists('kvp_user_routes') ) :
    
class kvp_user_routes {

    private $response;
    function __construct() {
        $this->response = array();
        add_action( 'rest_api_init' , array($this, 'wpshout_register_routes') );
    }
    function kvp_get_about_page(){

        if(is_array($this->response)){
            return new WP_REST_Response( $this->response, 200);  
        }
    }
    function kvp_member_plan($role){
        $settings = get_option('option_tree_settings');
        $return_item = array();
        $items = $settings['settings'];
        foreach($items as $item) {
                if($item['section'] == $role){
                    $return_item[$item['section']][$item['id']] = $item;
                }
        }
        return $return_item;
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
            '/about-us',
            array(
                'methods' => 'GET',
                'callback' => array($this, 'kvp_get_about_page'),
            )
        );
        register_rest_route( 
            'kvp/v1',
            '/contact-us',
            array(
                'methods' => 'GET',
                'callback' => array($this, 'kvp_get_contact_page'),
            )
        );
        register_rest_route( 
            'kvp/v1',
            '/current_user',
            array(
                'methods' => 'GET',
                'callback' => array($this, 'kvp_get_current_user'),
            )
        );
        register_rest_route( 
            'kvp/v1',
            '/register',
            array(
                'methods'=> 'POST',
                'callback' => array($this, 'kvp_register'),
            )
        );
        
        register_rest_route( 
            'kvp/v1',
            '/social_login',
            array(
                'methods' => 'POST',
                'callback' => array($this, 'kvp_social_login'),
            )
        );

    }
    function get_user_login($social_id, $email){

        $flag = array(
            'email' =>  email_exists($email),
            'social' =>  username_exists($social_id),
        );
        return $flag;
    }
    function kvp_social_login($request){
        $social_id = $request->get_param('social_id');
        $name = $request->get_param('name');
        $email = $request->get_param('email');
        $login_type = $request->get_param('login_type');
        $avatar = $request->get_param('avatar');

        $user = $this->get_user_login($social_id, $social_id);

        // return $user;
        if($user['social'] != false){
            $token = get_user_meta($user['social'], 'access_token', true);
            $this->response = array(
                'token' => $token,
                'success' => true
            );
        }elseif($user['email'] != false){
            $token = get_user_meta($user['email'], 'access_token', true);
            $this->response = array(
                'token' => $token,
                'success' => true
                            
            );
        }else{
            $user = wp_create_user( $social_id, $social_id , $email );
            $this->set_default_role($user);
            $token = $this->get_access_token($social_id, $social_id );
            add_user_meta($user, 'display_username', $request->get_param('name'));
            add_user_meta($user, 'access_token', $token);
            // add_user_meta($user, 'social_id', $social_id);
            add_user_meta($user, 'login_type', $login_type);
            add_user_meta($user, 'avatar_url', $avatar);
            if($token != ''){
                $this->response = array(
                    'token' => $token,
                    'success' => true
                );
            }else{
                $this->response = array(
                    'token' => 'Access token not found.',
                    'success' => false
                );
            }
        }
        return new WP_REST_Response( $this->response , 200);  
    }
    function get_user_social_id($id){
       return username_exists($id);
    }
    function get_role_cap_text($role){
        $name = strtoupper(str_replace('_', ' ', $role));
        return $name;
    }
    public function validate_token($output = true){
        /*
         * Looking for the HTTP_AUTHORIZATION header, if not present just
         * return the user.
         */
        $auth = isset($_SERVER['HTTP_AUTHORIZATION']) ? $_SERVER['HTTP_AUTHORIZATION'] : false;

        /* Double check for different auth header string (server dependent) */
        if (!$auth) {
            $auth = isset($_SERVER['REDIRECT_HTTP_AUTHORIZATION']) ? $_SERVER['REDIRECT_HTTP_AUTHORIZATION'] : false;
        }

        if (!$auth) {
            return new WP_Error(
                'jwt_auth_no_auth_header',
                'Authorization header not found.',
                array(
                    'status' => 403,
                )
            );
        }

        /*
         * The HTTP_AUTHORIZATION is present verify the format
         * if the format is wrong return the user.
         */
        list($token) = sscanf($auth, 'Bearer %s');
        if (!$token) {
            return new WP_Error(
                'jwt_auth_bad_auth_header',
                'Authorization header malformed.',
                array(
                    'status' => 403,
                )
            );
        }

        /** Get the Secret Key */
        $secret_key = defined('JWT_AUTH_SECRET_KEY') ? JWT_AUTH_SECRET_KEY : false;
        if (!$secret_key) {
            return new WP_Error(
                'jwt_auth_bad_config',
                'JWT is not configurated properly, please contact the admin',
                array(
                    'status' => 403,
                )
            );
        }

        /** Try to decode the token */
        try {
            $token = JWT::decode($token, $secret_key, array('HS256'));
            /** The Token is decoded now validate the iss */
            if ($token->iss != get_bloginfo('url')) {
                /** The iss do not match, return error */
                return new WP_Error(
                    'jwt_auth_bad_iss',
                    'The iss do not match with this server',
                    array(
                        'status' => 403,
                    )
                );
            }
            /** So far so good, validate the user id in the token */
            if (!isset($token->data->user->id)) {
                /** No user id in the token, abort!! */
                return new WP_Error(
                    'jwt_auth_bad_request',
                    'User ID not found in the token',
                    array(
                        'status' => 403,
                    )
                );
            }
            /** Everything looks good return the decoded token if the $output is false */
            if (!$output) {
                return $token;
            }
            /** If the output is true return an answer to the request to show it */
            return array(
                'code' => 'jwt_auth_valid_token',
                'data' => array(
                    'status' => 200,
                ),
            );
        } catch (Exception $e) {
            /** Something is wrong trying to decode the token, send back the error */
            return new WP_Error(
                'jwt_auth_invalid_token',
                $e->getMessage(),
                array(
                    'status' => 403,
                )
            );
        }
    }
    function kvp_get_user_role($id){
        $user_info = get_userdata($id);
        if(!empty($user_info->roles)){
            return ucwords(str_replace('_', ' ', $user_info->roles[0]));
        }else{
            return null;
        }
    }
    function get_user($id){
        $user = get_user_by( 'ID', $id);
        $user_obj = array(
            'email' => $user->user_email,
            'display_username' => $user->display_username,
            'role' => $this->kvp_get_user_role($id),
            'avatar' =>get_user_meta($id, 'avatar_url' ,true),
            'total_booking'  => 1,
            'total_events'  => 2,
            'total_tracks'  => 3,
            'total_beats'  => 4,
        );

        return $user_obj;
    }
    function get_user_by_social_id($id){
        // $user = get_user_by( '', $id);
        $user_obj = array(
            'email' => $user->user_email,
            'display_username' => $user->display_username,
            'role' => $this->kvp_get_user_role($id),
            'total_booking'  => 1,
            'total_events'  => 2,
            'total_tracks'  => 3,
            'total_beats'  => 4,
        );

        return $user_obj;
    }
    function kvp_get_current_user(){
        
        // $member = new Members();
        // return $member->get_current_user_plan();

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
                return new WP_REST_Response( $this->get_user($user_id) , 200);  
            }else{
                return new WP_REST_Response( $this->jwt_error , 200);  
            }
        }
        
        /** Everything is ok, return the user ID stored in the token*/
        
    }
    function get_nopass_token($user){
        $issuedAt = time();
        $notBefore = apply_filters('jwt_auth_not_before', $issuedAt, $issuedAt);
        $expire = apply_filters('jwt_auth_expire', $issuedAt + (DAY_IN_SECONDS * 7), $issuedAt);
        $token = array(
            'iss' => get_bloginfo('url'),
            'iat' => $issuedAt,
            'nbf' => $notBefore,
            'exp' => $expire,
            'data' => array(
                'user' => array(
                    'id' => $user,
                ),
            ),
        );

        /** Let the user modify the token data before the sign. */
        $token = JWT::encode(apply_filters('jwt_auth_token_before_sign', $token, $user), $secret_key);
        return $token;
    }
    function set_default_role($id){
        $user = new WP_User($id);
        $user->set_role('none_member');
    }
    function get_access_token($username, $password){
        $secret_key = defined('JWT_AUTH_SECRET_KEY') ? JWT_AUTH_SECRET_KEY : false;
        $user = wp_authenticate($username, $password);
        if (is_wp_error($user)) {
            $error_code = $user->get_error_code();
            return new WP_Error(
                '[jwt_auth] ' . $error_code,
                $user->get_error_message($error_code),
                array(
                    'status' => 403,
                )
            );
        }
        $issuedAt = time();
        $notBefore = apply_filters('jwt_auth_not_before', $issuedAt, $issuedAt);
        $expire = apply_filters('jwt_auth_expire', $issuedAt + (DAY_IN_SECONDS * 7), $issuedAt);
        $token = array(
            'iss' => get_bloginfo('url'),
            'iat' => $issuedAt,
            'nbf' => $notBefore,
            'exp' => $expire,
            'data' => array(
                'user' => array(
                    'id' => $user->data->ID,
                ),
            ),
        );

        /** Let the user modify the token data before the sign. */
        $token = JWT::encode(apply_filters('jwt_auth_token_before_sign', $token, $user), $secret_key);
        return $token;
    }
    function kvp_register($request){
        $useremail = $request->get_param('email');
        $user_exist = email_exists($useremail);
        if(!$user_exist){
            $username = $request->get_param('username').time() ? $request->get_param('username').time() : null;
            $userpass = $request->get_param('password') ? $request->get_param('password') : null;
            $user = wp_create_user( $username, $userpass , $useremail );
            $token = $this->get_access_token( $username, $userpass);
            add_user_meta($user, 'display_username', $request->get_param('username'));
            add_user_meta($user, 'access_token', $token);
            if(is_wp_error($user)){
                $this->response = array(
                    'message' => 'Something went wrong try again.',
                    'success' => false
                );  
            }else{
                $this->set_default_role($user);
                // get user by id
                $this->response = array(
                    // 'data' => $this->get_user($user),
                    'token' => $token,
                    'success' => true

                );
            }
        }else{
            $this->response = array(
                'message' => 'Email already exists!',
                'success' => false
            );
        }
        if(is_array($this->response)){
            return new WP_REST_Response( $this->response, 200);  
        }
    }
    function kvp_login($request){
        // return $request->get_param('password');
        
        $username = $request->get_param('email') ? $request->get_param('email') : null;
        $userpass = $request->get_param('password') ? $request->get_param('password') : null;

        $token = $this->get_access_token( $username, $userpass);
        if(!is_wp_error($token)){
            $this->response = array(
                'token' => $token,
                'success' => true
            );
        }else{
            $this->response = array(
                'message' => 'Invalid username and password.',
                'success' => false
            );
        }
        
        return new WP_REST_Response( $this->response , 200);
        // $creds = array(
        //     'user_login'    => $request['email'],
        //     'user_password' => $request['password'],
        // );
        
        // $user = wp_signon( $creds, false );
        // if ( is_wp_error( $user ) ) {
        //     $this->response = array(
        //         'message' => 'Username or password is wrong!',
        //         'success' => false
        //     );
        // }else{
        //     $this->response = array(
        //         'data' => $this->get_user($user->id),
        //         'success' => true
        //     );
        // }
        // return new WP_REST_Response( $this->response, 200);  
    }
    
    
}

$kvp_user_routes = new kvp_user_routes();

endif; // class_exists check

?>