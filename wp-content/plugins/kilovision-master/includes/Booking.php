<?php 

namespace Kvp;
use WP_List_Table;

if ( ! class_exists( 'WP_List_Table' ) ) {
    require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

class Booking extends WP_List_Table{
    function booking_list_table(){
    //    var_dump(class_exists( 'WP_List_Table' ));
        ?>
        <p>FORMATE</p>
        <?php
    }
}