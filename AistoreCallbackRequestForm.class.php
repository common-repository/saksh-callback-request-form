<?php
if (!defined('ABSPATH')) exit;


class AistoreCallbackRequestForm{
   
    
    
    // create 
    public static function aistore_request_callback_form() {
          ob_start();
        ?>

 

    <div class="loginblock" id="formstep1" >
    <form id="formstep11" class="form-group">
       <input type="hidden" name="action" value="saksh_form_step1">
            <label><?php _e('Email', 'aistore'); ?>:</label>    <br>
            <input type="email" size="50" name="email" id="email" class="form-control">
     
        <br>    <br>
      
            <label><?php _e('Mobile', 'aistore'); ?>:</label>    <br>    
            <input type="number" size="50" name="mobile" id="mobile" class="form-control">
       
      <br>    <br>
        <input type="submit" value="Submit" class="btn btn-primary comment-submit fusion-button wpcf7-form-control wpcf7-submit" >
      
    </form></div>
    
    
    
       <div class="loginblock  hide" id="formstep2">
 <form id="formstep12" class="form-group">
            <input type="hidden" name="action" value="saksh_form_step2">
         
                 
            <label><?php _e('Email OTP', 'aistore'); ?>:</label>  <br>
            <input type="number" name="otp" size="50" id="otp" class="form-control">  <br>       <br>       <br>     
            
            <label><?php _e('Mobile OTP', 'aistore'); ?>:</label>  <br>
            <input type="number" name="mobile_otp1" size="50" id="mobile_otp1" class="form-control">
            
     <br>       <br>     
            
            
              <input type="hidden" name="mobile_otp" value="" id="mobile_otp">
               <input type="hidden" name="email_otp" value="" id="email_otp">
               
   
      <br>     
        <input type="submit" value="Verify" class="btn btn-primary comment-submit fusion-button  wpcf7-form-control wpcf7-submit">
    </form></div>
   
   
   
    <div class="loginblock hide" id="formstep3" >
    <form id="formstep13" class="form-group">
       
        <input type="hidden" name="action" value="saksh_form_step3">
             <input type="hidden" name="email3" value="" id="email3">
     
            <label><?php _e('Name', 'aistore'); ?>:</label>  <br>
            <input type="text" name="name" size="50" id="name" class="form-control">
     
           <br>  <br>       <br>     
      
            <label><?php _e('Subject', 'aistore'); ?>:</label>  <br>
            <input type="text" name="subject" size="50" id="subject" class="form-control">
       
            <br>  <br>       <br>     
       
       <label><?php _e('Message', 'aistore'); ?>:</label>  <br>
            <textarea type="text" name="message" size="50" id="message"class="form-control wpcf7-form-control wpcf7-textarea"></textarea>
       
         <br>  <br>       <br>     
       
        <input type="submit" value="Submit" class="btn btn-primary comment-submit fusion-button  wpcf7-form-control wpcf7-submit">
    </form></div>
    
    
    
    
    <div id="result"></div>

<?php
return ob_get_clean();
    }
    



 

public static function saksh_form_step1() {

 
	global $wpdb; // this is how you get access to the database


$email = sanitize_text_field($_POST["email"]);
	
	$mobile = sanitize_text_field($_POST["mobile"]);
	
	


 $otp_verify = $wpdb->get_var($wpdb->prepare("SELECT otp from {$wpdb->prefix}saksh_callback_request where email  = %s order by id desc" , sanitize_text_field($_POST["email"] )));
 
 
if($otp_verify > 1)
$otp=$otp_verify;
else
 $otp = rand(100000,999999);
 
 
 
  $mobile_otp = $otp ;
  
 
  
        ?>
             <div><h6><?php _e('OTP Send Successfully on registered Email', 'aistore'); ?> </h6></div>  
             <?php
                $wpdb->query($wpdb->prepare("INSERT INTO {$wpdb->prefix}saksh_callback_request ( email, mobile ,otp ,mobile_otp) VALUES ( %s, %d  ,%d,%d)", array( $email,  $mobile,$otp,$mobile_otp)));
                
               
                
                $to = $email;
                $subject = 'Customer Callback Request Verification';
               
                $body = "Hello, <br>
 
     <h2>Your otp is:  " . $otp."</h2>";
                $body.= "<br /> If you are not registered in the portal kindly visit my account page and register.";
                $headers = array('Content-Type: text/html; charset=UTF-8');
                wp_mail($to, $subject, $body, $headers);
                
     
            
wp_die();
}


 

function saksh_form_step2() {
    

	global $wpdb; // this is how you get access to the database
	$email = sanitize_text_field($_POST["email"]);
	
	$mobile = sanitize_text_field($_POST["mobile"]);
	
	
 

 $otp_verify = $wpdb->get_var($wpdb->prepare("SELECT otp from {$wpdb->prefix}saksh_callback_request where email  = %s order by id desc" , sanitize_text_field($_POST["email"] )));
                

$mobile_otp_verify = $wpdb->get_var($wpdb->prepare("SELECT mobile_otp from {$wpdb->prefix}saksh_callback_request where mobile  = %s order by id desc" , sanitize_text_field($_POST["mobile"] )));
                
     
$eotp=sanitize_text_field($_POST["otp"]);
$motp=sanitize_text_field($_POST["mobile_otp1"]);
$ar=array();

 if($eotp==$otp_verify && $motp==$mobile_otp_verify)
 
 {
     
    return false;
 }
  else
 {
     return true;
 }
                
wp_die();
}


 

function saksh_form_step3() {

   
	global $wpdb;  
	$email= sanitize_text_field($_POST["email"]) ;
	$name= sanitize_text_field($_POST["name"]) ;
	$subject= sanitize_text_field($_POST["subject"]) ;
	$message= sanitize_text_field($_POST["message"]) ;
 

 $wpdb->query($wpdb->prepare("UPDATE {$wpdb->prefix}saksh_callback_request
    SET name = '%s' , message= '%s' ,subject= '%s' WHERE email = '%s'",$name,$subject,$message, $email));?>
    
    <div><p><?php _e('Form submitted Successfully', 'aistore'); ?> </p></div>
    
     <?php
	wp_die();
}



}


add_action( 'wp_ajax_saksh_form_step3', array('AistoreCallbackRequestForm', 'saksh_form_step3') );
add_action( 'wp_ajax_nopriv_saksh_form_step3','saksh_form_step3');

add_action( 'wp_ajax_saksh_form_step2', array('AistoreCallbackRequestForm', 'saksh_form_step2')  );
add_action( 'wp_ajax_nopriv_saksh_form_step2', 'saksh_form_step2' );
    
add_action( 'wp_ajax_saksh_form_step1', array('AistoreCallbackRequestForm', 'saksh_form_step1') );
add_action( 'wp_ajax_nopriv_saksh_form_step1', 'saksh_form_step1' );