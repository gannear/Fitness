<?php
/*
Template Name:Contact Us
 
*/
 
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script type="text/javascript">
var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";
jQuery(document).ready(function(){
jQuery('#submit').on('click',function(){
       // alert("hi");
        if (!user_validation())	
			return;	

		var cont_name=jQuery("#cont_name").val();
		var cont_email = jQuery("#cont_email" ).val();
		var cont_phone=jQuery("#cont_phone").val();
		var message = jQuery("#message").val();

		 var data = {
            action: 'contact_form_smbt',
            cont_name:cont_name,
            cont_email:cont_email,
            cont_phone:cont_phone,
            message:message
            
          };

		jQuery.ajax({ 
				 type:'POST', 
				 url:ajaxurl,
				 data,
				 success:function(html){ 
					 //alert(html);
					 jQuery('#show').html(html); 
					
				 }
				}); 
         
	});


 
  
});
</script>
<script>
	function user_validation() {

		var is_error = false;
		
		var cont_name=jQuery("#cont_name").val();
		var cont_email = jQuery("#cont_email" ).val();
		var cont_phone=jQuery("#cont_phone").val();

		if (cont_name.length < 1) {
	      	jQuery('#fn_label').html('<span class="error">This field is required</span>');
	      	is_error = true;

	    }
	    if (cont_email.length < 1) {
	      	jQuery('#email_label').html('<span class="error">This field is required</span>');
	      	is_error = true; 
	    } else if (!validateEmail(cont_email) ) {
	    	jQuery('#email_label').html('<span class="error">Invalid Email id</span>');
	      	is_error = true; 
	    }

        if (cont_phone.length < 1) {
            jQuery('#phone_msg').html('<span class="error">This field is required</span>');

            is_error = true;

        }

        if(is_error) {

        	return false;
           }else
        	{
               return true;
        	}

         
	}
	function validateEmail(sEmail) {
	    var filter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
	    if (filter.test(sEmail)) {
	        return true;
	    }
	    else {
	        return false;
	    }
	}
</script>

  
<?php get_header(); ?>
<?php topfit_mikado_get_title(); ?>

<div class="mkd-full-width">
		<div class="mkd-full-width-inner" style="padding-left: 140px;">
		<div id="show" style="color: green;"></div>
		 
		 <div class="col-md-6">
		<p>
			<label>Name</label><span class="required"> * </span>
			<label id="fn_label"></label></p>
		<p>
			<input type="text" name="cont_name" id="cont_name" size="30" class="form-control"/>
		</p>
		<p><label>Phone number</label><span class="required"> * </span>&nbsp;&nbsp;&nbsp;&nbsp;<label id="phone_msg"></label></p>
		<p><input type="text" name="cont_phone" id="cont_phone" class="form-control" size="30" /></p>

		<p>
			<label>Email ID</label><span class="required"> * </span>
			<label id="email_label"></label></p>
		<p><input type="text" size="30"  name="cont_email" id="cont_email" class="form-control" /></p>
		<p>
			<label>Message</label> 
			</p>
		<p><textarea name="message" id="message" rows="5" cols="45"></textarea></p>
		<p>
		<button type="submit" name="submit" id="submit" class="btn btn-primary" >Submit</button>
		</p>
         </div>
       </div>
 </div>
  
<?php get_footer(); ?>