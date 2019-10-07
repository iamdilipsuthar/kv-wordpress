<?php

function kvp_orders_template() {
    ?>
    
   <?php
}

function ilc_save_theme_settings() {
    global $pagenow;
    $settings = get_option( "ilc_theme_settings" );
 
    if ( $pagenow == 'themes.php' && $_GET['page'] == 'theme-settings' ){
       if ( isset ( $_GET['tab'] ) )
            $tab = $_GET['tab'];
        else
            $tab = 'homepage';
 
        switch ( $tab ){
            case 'general' :
          $settings['ilc_tag_class'] = $_POST['ilc_tag_class'];
       break;
            case 'footer' :
          $settings['ilc_ga'] = $_POST['ilc_ga'];
       break;
       case 'homepage' :
          $settings['ilc_intro'] = $_POST['ilc_intro'];
       break;
        }
    }
    //code to filter html goes here
    $updated = update_option( "ilc_theme_settings", $settings );
 }

 
function kvp_role_setting_template() {
    $tabs = array( 'homepage' => 'Home Settings', 'general' => 'General', 'footer' => 'Footer' );
    echo '<div id="icon-themes" class="icon32"><br></div>';
    echo '<h2 class="nav-tab-wrapper">';
    foreach( $tabs as $tab => $name ){
        $class = ( $tab == $current ) ? ' nav-tab-active' : '';
        echo "<a class='nav-tab$class' href='?page=theme-settings&tab=$tab'>$name</a>";
    }
    echo '</h2>';
}


  