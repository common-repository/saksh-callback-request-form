


"$use strict";


jQuery(document).ready(function($) {
   
    $("#formstep11").on("submit", function(event){
        

        event.preventDefault();
 
 var email = $("#email").val();
 var mobile = $("#mobile").val();

    $.ajax({
    type: "post",
    url: ajaxurl,
    data: {
        action  : 'saksh_form_step1',  
    email:email,
    mobile:mobile
         
    },
 success: function(data){
       
            $("#result").html(data);
     
             var email = $("#email").val();
              var mobile = $("#mobile").val();
                     var str1 = $('#email_otp').val(email);
                            var str2 = $('#mobile_otp').val(mobile);
             
            // $("#formstep1").addClass("hide");

             
             $("#formstep2").removeClass("hide");
        }   
        });
             

    });
    
    
      $("#formstep12").on("submit", function(event){

      event.preventDefault();
    
  var email = $("#email_otp").val();
 var mobile = $("#mobile_otp").val();
   var otp = $("#otp").val();
 var mobile_otp1 = $("#mobile_otp1").val();

    $.ajax({
    type: "post",
    url: ajaxurl,
    data: {
        action  : 'saksh_form_step2',     
        email:email,
        mobile:mobile,
         otp:otp,
        mobile_otp1:mobile_otp1,
    },
 success: function(data){
    
       if(data==0)
       {
           // $("#result").html(data);
                
             $("#formstep2").addClass("hide");
              $("#formstep1").addClass("hide");
             $("#formstep3").removeClass("hide");
             
       }
       else
       {
           
            $("#result").html("Please provide correct OTP");
                
       }
 }   
        });
    });
    
    
    
    
    
    $("#formstep13").on("submit", function(event){
        
    
        event.preventDefault();
 
 
 var email = $("#email").val();
 
   var name = $("#name").val();
  var message = $("#message").val();
   var subject = $("#subject").val();
    
    
    
    $.ajax({
    type: "post",
    url: ajaxurl,
    data: {
        action : 'saksh_form_step3',  
         email:email,
         subject:subject,
         name:name,
         message:message,
    },
    
     success: function(data){
            $("#result").html(data);
            
           //  $("#formstep3").addClass("hide");
             
        
 }
       
    });
    
    
    
    
    
});
    
    


});

