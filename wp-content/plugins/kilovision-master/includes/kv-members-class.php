<?php


class Kvp_member_routes{

    private $response;

    function __construct() {
        $this->response = array();
        add_action( 'rest_api_init' , array($this, 'wpshout_register_members_routes') );
    }

    function wpshout_register_members_routes(){
        register_rest_route( 
            'kvp/v1',
            '/member_plans',
            array(
                'methods' => 'POST',
                'callback' => array($this, 'kvp_member_plans'),
            )
        );
        
    }
    function kvp_member_plans($request){
        $optionTree = get_option('site_url');
        
    }
}
$Kvp_member_routes = new Kvp_member_routes();