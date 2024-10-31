<?php
/*
Plugin Name: Saksh Callback Request Form
Version:  1.0
Plugin URI: #
Author: susheelhbti
Author URI: http://www.aistore2030.com/
Description: Inspired by zerodha, Kotek Mahidra bank, JIO fibre lead generation form I setup this form it first ask users email ID and mobile number and then send OTP and verify and once verify it ask further details like name, address etc.
*/


add_action('init', 'aistore_wpdocs_load_callback_request_from');



function aistore_wpdocs_load_callback_request_from() {
    load_plugin_textdomain('aistore', FALSE, basename(dirname(__FILE__)) . '/languages/');
    
}


function aistore_scripts_method()
{
   
    wp_enqueue_style('aistore', plugins_url('/css/custom.css', __FILE__), array());
    wp_enqueue_script('aistore', plugins_url('/js/custom.js', __FILE__), array(
        'jquery'
    ));
     wp_localize_script( 'aistore', 'ajaxurl', admin_url( 'admin-ajax.php' ) );
}



add_action('wp_enqueue_scripts', 'aistore_scripts_method');

include_once dirname(__FILE__) . '/AistoreCallbackRequestForm.class.php';

include_once dirname(__FILE__) . '/AdminReport.php';


add_shortcode('SakshCallbackRequestForm', array('AistoreCallbackRequestForm', 'aistore_request_callback_form'));




function aistore_plugin_table_install() {
    
    global $wpdb;
    $table_customer_form = "CREATE TABLE    IF NOT EXISTS  " . $wpdb->prefix . "saksh_callback_request  (
  id int(100) NOT NULL  AUTO_INCREMENT,
  mobile varchar(100) NOT NULL,
   message  text   NULL,
   name  varchar(100)  NULL, 
   subject  varchar(100)  NULL,
    otp int(100) NOT NULL,
     mobile_otp int(100) NOT NULL,
  email  varchar(100)   NOT NULL,
   created_at  timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (id)
) ";
    
    require_once (ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($table_customer_form);
   
   
}

 register_activation_hook(__FILE__, 'aistore_plugin_table_install'); 