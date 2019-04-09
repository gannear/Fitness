<?php

/*** Child Theme Function  ***/

function topfit_mikado_child_enqueue_styles() {
    $parent_style = 'topfit_mikado_default_style';

    wp_enqueue_style($parent_style, get_template_directory_uri() . '/style.css');

    wp_enqueue_style('childstyle',
        get_stylesheet_directory_uri() . '/style.css',
        array($parent_style),
        wp_get_theme()->get('Version')
    );
}

define("FREE_MEMBERSHIP", 6);

	
add_action('wp_enqueue_scripts', 'topfit_mikado_child_enqueue_styles');


//ADD SHORTCODE FOR MEMBER REGISTRATION

add_shortcode('gmgt_custom_memberreg', 'gmgt_custom_memberregistration_');

function gmgt_custom_memberregistration_(){ ?>


<script>
var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";
jQuery(document).ready(function(){

    jQuery('#age').change(function(){
        var age =jQuery("#age").val();
        if(age < 18 && age!=''){
            jQuery('#parent_details').css('display','block');
        }
        else
        {
          jQuery('#parent_details').css('display','none');  
        }
    });

    jQuery("input[name='school']").click(function(){
    if(jQuery('input:radio[name=school]:checked').val() == "yes"){
         jQuery('#school_details').css('display','block');
        }
    else
    {
        jQuery('#school_details').css('display','none');
    }
});

	

	jQuery('#Country').on('change',function(){ 
		var countryID = jQuery(this).val();
	    if(countryID){
			jQuery.ajax({ 
				type:'POST', 
				url:ajaxurl,
				data:'country_id='+countryID+"&action=state_frontend",
				success:function(html){ 
					jQuery('#state').html(html); 
				}
			}); 
		}else{ 
		 jQuery('#state').html('<option value="">Select country first</option>'); 			 
		} 
	});


 	jQuery('#state').on('change',function(){ 
		var stateID = jQuery(this).val();		 
	    if(stateID){
			jQuery.ajax({ 
				type:'POST', 
				url:ajaxurl,
				data:'state_id='+stateID+"&action=city_frontend",
				success:function(html){ 
					//alert(html);
					jQuery('#City').html(html); 

				}
			}); 
		}else{ 
			jQuery('#City').html('<option value="">Select state first</option>'); 			 
		} 
	});

	jQuery("#btn_register").click(function(){

		//user registration form validation
		if (!user_validation())	
			return;	

		var first_name=jQuery("#member_name").val();
		var Phone_number = jQuery("#Phone_number" ).val();
		var password1=jQuery("#password1").val();
		var password2=jQuery("#password2").val();
		var email = jQuery("#email").val();

		var Country = jQuery("#Country").val();
		var State = jQuery("#state").val();
		var City = jQuery("#City").val();
		var Sport = jQuery("#Sport").val();
		var cstatus = jQuery("#cstatus1").val();
		var membership_id = jQuery("#membership_id").val();
        var pname = jQuery("#pname").val();
        var paddress = jQuery("#paddress").val();
        var pphone = jQuery("#pphone").val();
        var pemail = jQuery("#pemail").val(); 
        var age = jQuery("#age").val();
        var school = jQuery('input:radio[name=school]:checked').val();
        var school_name = jQuery("#school_name").val();
        var school_city = jQuery("#school_city").val();
        var school_state = jQuery("#school_state").val();
        var coach_name = jQuery("#coach_name").val();


		// form submit  
        var data = {
            action: 'register_member',
            first_name: first_name,
            Phone_number:Phone_number,
            password1:password1,
            password2:password2,
            email:email,
            Country:Country,
            State:State,
            City:City,
            Sport:Sport,
            cstatus:cstatus,
            membership_id:membership_id,
            age:age,
            pname:pname,
            paddress:paddress,
            pphone:pphone,
            pemail:pemail,
            school:school,
            school_name:school_name,
            school_city:school_city,
            school_state:school_state,
            coach_name:coach_name
        };

        console.log(ajaxurl);

		jQuery.ajax({ 
			type:'POST', 
			url:ajaxurl,
			data,

			beforeSend: function(){
				// Show image container
				jQuery("#loader-payment").show();
			},

			success:function(html){ console.log(html);

			    //alert(html);

		 		var obj = jQuery.parseJSON(html);
				if(obj.url != undefined) {
					var url=obj.url;
					//alert(url);
					setTimeout(function () {
						window.location.href = url;
					}, 1000);
				} else {
					if( obj.membership == "<?php echo FREE_MEMBERSHIP; ?>" ) {
						if(!obj.error) {

						var user = obj.user_id;

                        //var url ='http://fitness.php-dev.in/registration/?id='+user+'#tabs-3';
                        
                        var url ='http://fitness.php-dev.in/registration/';
                        //alert("hi");

                        setTimeout(function () {
						window.location.href = url;
					     }, 1000);


							// jQuery("#msg .msg-success").text("User registered successfully. You will receive the activation link and once you activate it you will able to login on website.");
							// var active = jQuery( "#tabs" ).tabs( "option", "active" );
							// jQuery("#tabs").tabs({disabled: false });
							// jQuery("#tabs").tabs("option", "active", active + 1);
							// jQuery("#tabs").tabs("option", "disabled", [0, 1, 2, 3]);
						} else {
							jQuery("#msg .msg-error").text("Invalid User");
						}
					}
				}

			},

			complete:function(data){
				// Hide image container
				jQuery("#loader-payment").hide();
			}
		}); 
    });

  
	/*check existing user usremail */
	jQuery("#email").on("blur", function(){
		
		var useremail = jQuery("#email").val();
		if(useremail!=""){
			jQuery.ajax({
				url: ajaxurl,
				type: 'post',
				dataType: 'json',
				data: "useremail="+useremail+"&action=check_existing_user_email",
				success: function(result) { 						
					if(result['success'] == true){
						jQuery("#email_label").text('');	
					//alert(result['success']);
				    //jQuery("input[name='usrconfirmemail']").focus();
					} else {
						//alert(result['error']);
						//generateNotification(result['error'], "error");
						jQuery("#email_label").text("Email already exists");										
						jQuery("#email_label").css("color","red");
						jQuery("#email").css("border-color","red");

						jQuery("input[name='email']").focus();

						return false;
					}
						    	
				}
			});
		}

	});


});

</script>
 
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
 <script src="https://unpkg.com/jquery-input-mask-phone-number@1.0.4/dist/jquery-input-mask-phone-number.js"></script>

<?php 
if(!empty($_GET) && isset($_GET['id'])){
	//required field
	$user_info = get_userdata($_GET['id']);
	// print_r($user_info);
	$uid 		= $user_info->ID;
    $username 	= $user_info->user_login;
    $useremail 	= $user_info->user_email;

    $membershipId = get_user_meta($uid, 'membership_id');
}
?>
<script>
function phnfunction() {

  var Phone_number = jQuery("#Phone_number" ).val();
  //alert(Phone_number.length);
  if(Phone_number.length < 14){
  	jQuery('#Phone_number').val('');
  }
   
}
	function user_validation() {

		var active = jQuery( "#tabs" ).tabs( "option", "active" );
		var is_error = false;
		var tab = 0;
		jQuery(".error").remove();

		var first_name=jQuery("#member_name").val();
		var Phone_number = jQuery("#Phone_number" ).val();
		var password1=jQuery("#password1").val();
		var password2=jQuery("#password2").val();
		var email = jQuery("#email").val();

		var Country = jQuery("#Country").val();
		var State = jQuery("#state").val();
		var City = jQuery("#City").val();
		var Sport = jQuery("#Sport").val();
		var cstatus = jQuery("#cstatus1").val();
		var membership_id = jQuery("#membership_id").val();
        var age = jQuery("#age").val();
        var school = jQuery('input:radio[name=school]:checked').val();




		if (first_name.length < 1) {
	      	jQuery('#fn_label').html('<span class="error">This field is required</span>');
	      	is_error = true;

	    }
	    if(Phone_number.length >=1){

	    	        
            

			var phone = jQuery("#Phone_number" ).val();
			phone = phone.replace(')','');
			phone = phone.replace('(','');
			phone = phone.replace('-','');
			phone = phone.replace(/\s/g,'');
			if(!phone.match(/^[-()0-9]+$/)) {
				jQuery("#phone_msg").html('<span class="error">Please enter numbers only.</span>');
				is_error = true;
			} else {
				var formated_phone = '';
		        char = { 0: '(', 3: ') ', 6: '-' };
		            
		        for (var i = 0; i < phone.length; i++) {
		            formated_phone += (char[i] || '') + phone[i];
		        }
		        jQuery("#Phone_number").val(formated_phone);
			}
		}
	    if (email.length < 1) {
	      	jQuery('#email_label').html('<span class="error">This field is required</span>');
	      	is_error = true; 
	    } else if (!validateEmail(email) ) {
	    	jQuery('#email_label').html('<span class="error">Invalid Email id</span>');
	      	is_error = true; 
	    }

        if (age.length < 1) {
            jQuery('#age_label').html('<span class="error">This field is required</span>');

            is_error = true;

        }


	<?php if(empty($uid)){  ?>
		    if (password1.length < 1) {
		      	jQuery('#pwd_label').html('<span class="error">This field is required</span>');
		      	is_error = true; 	
		    } else if (password1.length < 8) {
		    	jQuery('#pwd_label').html('<span class="error">Password should be at least 8 characteres long</span>');
		      	is_error = true; 
		    }

		    if (password2.length < 1) {
		      	jQuery('#cpwd_label').html('<span class="error">This field is required</span>'); 
		      	is_error = true;	
		    } else if (password2.length < 8) {
		    	jQuery('#cpwd_label').html('<span class="error">Password should be at least 8 characteres long</span>');
		      	is_error = true; 
		    }

			if(password1 != password2)
			{
				jQuery('#cpwd_label').html('<span class="error">Please confirm password</span>');
		      	is_error = true;		
			}
	<?php } ?>
		if(active == 1) { // Tab - Payment
			if (membership_id.length < 1) {
				jQuery('#Membership_label').html('<span class="error">This field is required</span>');
		      	is_error = true;	
		      	if(is_error) tab = 1;
			}
			
		}
		if(is_error) { 

			jQuery( "#tabs" ).tabs( "option", "active", tab);
			jQuery("html, body").animate({ scrollTop: 200 }, "slow");

			return false;
		} else { 
			if(active != 1) { // Tab - Payment 
				
				var disable_tab = [0, 1, 2, 3];	 
				disable_tab.splice(disable_tab.indexOf(active + 1), 1);
				
				jQuery("#tabs").tabs({disabled: false });
				jQuery("#tabs").tabs("option", "active", active + 1);
				jQuery("#tabs").tabs("option", "disabled", disable_tab);
				jQuery("html, body").animate({ scrollTop: 200 }, "slow");

		    }
		    
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


	jQuery( function() {

		jQuery('#Phone_number').usPhoneFormat({
                    format: '(xxx) xxx-xxxx',
                });
		
	    jQuery("#tabs").tabs();
		<?php if(!empty($uid)){  ?>
			jQuery("#tabs").tabs("option", "disabled", [0, 1, 3]);
		<?php } else { ?>
			jQuery("#tabs").tabs("option", "disabled", [1, 2, 3]);
		<?php } ?>
	    jQuery(".nexttab").click(function() { 
	    	user_validation();
	    });	

		
		/* show questionnaaire tab needs to visible inside member's login */

		<?php global $wpdb, $user_ID;  if(!empty($user_ID)){  ?>
			jQuery("#tabs").tabs("option", "disabled", [0, 1, 3]);
		  jQuery("#tabs").tabs("option", "active",2);
		<?php } ?>

	});

 	
</script>
<?php
    global $wpdb, $user_ID;  
  // if (!$user_ID) { 

 /* To access questionarie tab I have allowed to access Registration link even after user logged in */
    $questionnaire = true;

    if($questionnaire == true){ 

		$error= '';
		$success = '';
	 
		global $wpdb, $PasswordHash, $current_user, $user_ID;
?>

<div id="msg" class="alignleft2">
	<div class="msg-success"><?php if(!empty($_SESSION ['success'])){ echo $_SESSION ['success']; } unset($_SESSION ['success']); ?></div>
	<div class="msg-error"><?php if(!empty($_SESSION ['error'])){ echo $_SESSION ['error']; } unset($_SESSION ['error']); ?></div>
</div>	

<!--<form method="post">-->
<div id="tabs">
	<ul>
		<li><a href="#tabs-1">Registration details</a></li>
		<li><a href="#tabs-2">Payment Page</a></li>
		<li><a href="#tabs-3">Questionnaire</a></li>
		<li><a href="#tabs-4">Fitness Program Level</a></li>
	</ul>
	<div id="tabs-1">
	<!-- <div class="col-md-6"> -->
		<p>
			<label>Name</label><span class="required"> * </span>
			<label id="fn_label"></label></p>
		<p>
			<input type="text" value="<?php if(!empty($username)){ echo $username; } ?>" name="member_name" id="member_name" size="20" class="form-control"/>
		</p>
		<p><label>Phone number</label>&nbsp;&nbsp;&nbsp;&nbsp;<label id="phone_msg"></label></p>
		<p><input type="text" value="<?php if(!empty($uid) && !empty(get_user_meta($uid, 'Phone_number'))){ echo get_user_meta($uid, 'Phone_number') ; } ?>" name="Phone_number" id="Phone_number" class="form-control" placeholder="(xxx) xxx--xxxx" onblur="phnfunction()" /></p>

		<p>
			<label>Email ID</label><span class="required"> * </span>
			<label id="email_label"></label></p>
		<p><input type="text" value="<?php if(!empty($useremail)){ echo $useremail; } ?>" name="email" id="email" class="form-control" /></p>

        <p>
            <label>Age</label><span class="required"> * </span>
            <label id="age_label"></label></p>
        <p><input type="text" value="<?php if(!empty($age)){ echo $age; } ?>" name="age" id="age" class="form-control" /></p>
        <fieldset>
            <div id="parent_details" style="display: none;">
            
             <legend>Parent's Information:</legend>
                <p><label>Parent Name</label></p> 
                <p><input type="text" value="" name="pname" id="pname" class="form-control" /></p>
                <p><label>Parent Address</label></p>
                <p><textarea name="paddress" id="paddress" style="width: 722px; height: 94px;"></textarea></p>
                <p><label>Parent Phone Number</label></p>
                <p><input type="text" value="" name="pphone" id="pphone" class="form-control" /></p>
                <p><label>Parent Email</label></p>
                <p><input type="text" value="" name="pemail" id="pemail" class="form-control" /></p>
           
            </div>
         </fieldset>

        <p>
           <label>Are you in school?</label><span class="required"> * </span>
           <label id="school_label"></label></p>
           <p><input type="radio" value="yes" name="school" id="schhol" />Yes</p>
           <p><input type="radio" value="no" name="school" id="schhol" checked="checked" />No</p>

        <fieldset>
            <div id="school_details" style="display: none;">
            
             <legend>School Information:</legend>
                <p><label>School Name</label></p> 
                <p><input type="text" value="" name="school_name" id="school_name" class="form-control" /></p>
                <p><label>City</label></p>
                <p><input type="text" name="school_city" id="school_city" class="form-control"/>
                </p>
                <p><label>State</label></p>
                <p><input type="text" value="" name="school_state" id="school_state" class="form-control" /></p>
                <p><label>Name of Coach or Trainer</label></p>
                <p><input type="text" value="" name="coach_name" id="coach_name" class="form-control" /></p>
           
            </div>
         </fieldset>


		<p><label>Password</label><span class="required"> * </span>
			<label id="pwd_label"></label></p>
		<p><input type="password" <?php if(!empty($uid)){ echo "disabled=true"; } ?> value="" name="password1" id="password1" class="form-control" /></p>
		<p><label>Confirm password</label><span class="required"> * </span><label id="cpwd_label"></label></p>
		<p><input type="password" <?php if(!empty($uid)){ echo "disabled=true"; } ?> value="" name="password2" id="password2" class="form-control" /></p>

		<p><label>Country</label></p>
		<p>
		<select name="Country" id="Country" class="dropdown">
			<!--<option value="">Select Country</option>-->
			<option <?php if(!empty($uid) &&  !empty(get_user_meta($uid, 'Country'))){ echo "selected=selected"; } ?> value="231">United States</option>
            <?php
            global $wpdb;
            $results=$wpdb->get_results("select * from wp_countries");                                               
            foreach($results as $result){													
			?>
				<option <?php if(!empty($uid) &&  !empty(get_user_meta($uid, 'Country'))){ echo "selected=selected"; } ?> value="<?php echo $result->id;?>"><?php echo $result->name;?></option>
			<?php
			}                                                
            ?>
        </select>

		</p>

		<p><label>State</label></p>
		<p>
			
		<select name="State" id="state">
		<?php
		$results=$wpdb->get_results("select * from wp_states where country_id=231");
		foreach($results as $result){ 
		?>
		<option <?php if(!empty($uid) &&  !empty(get_user_meta($uid, 'State'))){ echo "selected=selected"; } ?> value="<?php echo $result->id;?>"><?php echo $result->name;?></option>
		<?php } ?>	
		 </select>
		 </p>
		<p><label>City</label></p>
		<p>
		<select name="City" id="City">
		<?php
		global $wpdb;
				$results=$wpdb->get_results("select * from cities where state_id=3919");
				foreach($results as $result){ 
		?>
		<option <?php if(!empty($uid) && !empty(get_user_meta($uid, 'city'))){ echo "selected=selected"; } ?> value="<?php echo $result->id;?>"><?php echo $result->name;?></option>
		<?php } ?>	
		 </select>
		 </p>

		<p><label>Sport(s)</label></p>
		<p><input type="text" value="<?php if(!empty($uid) && !empty(get_user_meta($uid, 'Sport'))){ echo get_user_meta($uid, 'Sport'); } ?>" name="Sport" id="Sport" class="form-control" /></p>

		<p><label>Current status </label></p>
		<p class="radio">
			<input type="radio" name="cstatus" id="cstatus1" value="Playing">Playing  &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;
			<input type="radio" name="cstatus" id="cstatus2" value="Not playing">Not playing</p>

		<input type="button" name="" class="nexttab btn btn-primary" value="next">

	</div>

	<div id="tabs-2">
	<p><label>Membership</label><span class="required"> * </span>&nbsp;&nbsp;&nbsp;&nbsp;<label id="Membership_label"></label></p>
	<p>
	<select name="membership_id" id="membership_id">
	<option value="">Select Membership</option>
	<?php
	global $wpdb;
	$results=$wpdb->get_results("select * from cp_gmgt_membershiptype");
	foreach($results as $result){		
	?>
	<option value="<?php echo $result->membership_id;?>" <?php if(!empty($membershipId)){ echo "selected=selected"; }?>><?php echo $result->membership_label;?></option>
	<?php } ?>
	</select>
	</p>

	<button type="submit" name="btn_register" id="btn_register" class="btn btn-primary" >Register</button>
	<input type="hidden" name="task" value="register" />
	<div id='loader-payment' style='display: none;padding-top: 30px;'>
	  <img src='<?php echo site_url();?>/wp-content/uploads/2018/11/loader.gif' width='32px' height='32px'>
	</div>
	</div>
	<?php include ("function-question.php"); ?>
	<!-- <div id="tabs-3">
	<p>Questionnaire data</p>
	<input type="button" name="" class="nexttab btn btn-primary" value="next">

	</div> -->
	<div id="tabs-4">
	<p>Membership Type Selected Automatically</p>
	<input type="button" name="" class="nexttab btn btn-primary" value="next">
	</div>
	<!-- Image loader -->

	<div id='loader' style='display: none;padding-top: 30px;padding-left: 30px;'>
	  <img src='<?php echo site_url();?>/wp-content/uploads/2018/11/loader.gif' width='32px' height='32px'>
	</div>
<!-- Image loader -->
</div>

<?php
    } else {  
	   wp_redirect( home_url() ); exit;  
	}  
}



//ADD SHORTCODE FOR Trainers REGISTRATION

add_shortcode('gmgt_custom_trainerreg', 'gmgt_custom_trainerregistration_');

function gmgt_custom_trainerregistration_(){

?>

<script>

function phnfunction() {
  var Phone_number = jQuery("#Phone_number" ).val();
  //alert(Phone_number.length);
  if(Phone_number.length < 14){
  	jQuery('#Phone_number').val('');
  }
   
}

var file_counter = 1;
var total_file = 1;

var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";

function onFileSelectForMulti(curr_file_ele, file_number) {
 
	             console.log(curr_file_ele);

				if (curr_file_ele.value == '') {
					jQuery("#upload" + file_number).html("No file chosen");
				} else {
					jQuery("#upload" + file_number).html(curr_file_ele.value.replace(/C:\\fakepath\\/i, ''));
				}
			}



jQuery(document).ready(function() { 

	jQuery("#btn_add_more").click(function (e) {
		//alert(file_counter);
		file_counter++;
		total_file++;
		jQuery('#fields_wrapper').append('<div class="input-group" id="file_group' + file_counter + '"><div class="input-group-btn"><span class="fileUpload btn btn-success"><span class="upl" id="upload' + file_counter + '">Upload Your Certificates</span><input type="file" class="upload up" name="certificates[]" id="certificates_'+file_counter+'" class="certificates1" data-multiple-caption="{count} files selected" onchange="javascript: onFileSelectForMulti(this,' + file_counter + ');"/></span> </div><a href="javascript:removeFile(' + file_counter + ');">Remove</a></div>');
		console.log("after add - " + file_counter);					
	}); 

	jQuery('#Country').on('change',function(){ 
		var countryID = jQuery(this).val();
		//alert(countryID);
		if(countryID){
			jQuery.ajax({ 
				type:'POST', 
				url:ajaxurl,
				data:'country_id='+countryID+"&action=state_frontend",
				success:function(html){ 
				 //alert(html);
				 jQuery('#state').html(html); 

				}
			}); 
		}else{ 
			jQuery('#state').html('<option value="">Select country first</option>'); 	
		} 
	});


 	jQuery('#state').on('change',function(){ 
		var stateID = jQuery(this).val();		 
	    if(stateID){
			jQuery.ajax({ 
				type:'POST', 
				url:ajaxurl,
				data:'state_id='+stateID+"&action=city_frontend",
				success:function(html){ 
				 jQuery('#City').html(html); 

				}
			}); 
		}else{ 
			jQuery('#City').html('<option value="">Select state first</option>'); 	
		} 
	});


	jQuery("#btnregistertrainer").click(function(){

		//trainner registration form validation
		if (!trainer_validation())	
			return;	
		    	 
		var first_name=jQuery("#member_name").val();
		var Phone_number = jQuery("#Phone_number" ).val();
		var password1=jQuery("#password1").val();
		var password2=jQuery("#password2").val();
		var email = jQuery("#email").val();

		var Country = jQuery("#Country").val();
		var State = jQuery("#state").val();
		var City = jQuery("#City").val();
		var Sport = jQuery("#Sport").val();
		var username = jQuery("#member_name").val();

		var Gym_name = jQuery("#Gym_name").val();
		var Location = jQuery("#Location").val();
		var Training_specialties = jQuery("#Training_specialties").val();
		var trainer_type = jQuery("#trainer_type").val();
		var time_slot = jQuery("#time_slot").val();		 

		// alert(file_counter);

		// var j;
		// var file_data =[];
		// var form_data = new FormData();

		// for(j=1;j<= file_counter; j++ ) {

		// 	var file_data_new = jQuery("#certificates_"+j).prop("files");
		// 	console.log(file_data_new);

		// 	form_data.append("file"+j, file_data_new[j]);

		// 	//file_data.push(file_data_new);
			

		// }
		//console.log(form_data);
		//alert(file_data.length);
		// alert(input);

		//var file_data = $("#certificates_1").prop("files")[0];


        var j;

  		/*var file_data = jQuery("#certificates_2").prop("files");
   		var i;
		var filelist =[];
		var form_data = new FormData();

		for (i = 0; i < file_data.length; i++) {
			//filelist.push(file_data[i]);
			alert("hi");
			 form_data.append("file"+i, file_data[i]);
		}*/
        
		var form_data = new FormData();
		$('[id^=certificates]').each(function(index, value){
			form_data.append("file"+index, $(value).prop("files")[0]);
		});
	 

		//console.log(form_data);

		form_data.append("action", 'trainer_up_cv');

		//alert(form_data);
		$.ajax({
			url: ajaxurl,
			dataType: 'script',
			cache: false,
			contentType: false,
			processData: false,
			data: form_data,                         
			type: 'post',
			success: function(){
			   // alert("works"); 
			}
		});
		 
	       

		var form_datanew = new FormData();

        $('[id^=certificates]').each(function(index, value){
			form_datanew.append("file"+index, $(value).prop("files")[0]);
		});

		// var j;
		// for (j = 0; j < file_data.length; j++) {
		// 	form_datanew.append("filedata"+j, file_data[j]);
		// }

		form_datanew.append("action", 'register_trainer');
		form_datanew.append("first_name", first_name);
		form_datanew.append("Phone_number", Phone_number);
		form_datanew.append("password1", password1);
		form_datanew.append("password2", password2);
		form_datanew.append("email", email);
		form_datanew.append("Country", Country);

		form_datanew.append("State", State);
		form_datanew.append("Country", Country);
		form_datanew.append("City", City);
		form_datanew.append("Sport", Sport);
		form_datanew.append("Gym_name", Gym_name);
		form_datanew.append("Location", Location);
		form_datanew.append("Training_specialties", Training_specialties);
		form_datanew.append("trainer_type", trainer_type);
		form_datanew.append("time_slot", time_slot);

		// console.log(form_datanew);
	      

		//form submit 
        // var data = {
        //     action: 'register_trainer',
        //     first_name: first_name,
        //     Phone_number:Phone_number,
        //     password1:password1,
        //     password2:password2,
        //     email:email,
        //     Country:Country,
        //     State:State,
        //     City:City,
        //     Sport:Sport,
        //     Gym_name:Gym_name,
        //     Location:Location,
        //     Training_specialties:Training_specialties,
        //     trainer_type:trainer_type,
        //     time_slot:time_slot,
        //     form_datanew:form_datanew
        // };

        // console.log(data);

        
		jQuery.ajax({ 
			type:'POST', 
			url:ajaxurl,
			data: form_datanew,
			processData: false,
			contentType: false,

			beforeSend: function(){
				// Show image container
				jQuery("#loader").show();
			},
			success:function(html){ 
				//jQuery('#msg').html("Trainer Register successfully");
				 var url = 'http://fitness.php-dev.in/trainer-success'; 
				 setTimeout(function () {
				 window.location.href = url;
				 	}, 1000); 
			},
			complete:function(data){
				// Hide image container
				jQuery("#loader").hide();
			}
		}); 
	});


	/*check existing user usremail */
	jQuery("#email").on("blur", function(){	
		var useremail = jQuery("#email").val();
		if(useremail!=""){
			jQuery.ajax({
				url: ajaxurl,
				type: 'post',
				dataType: 'json',
				data: "useremail="+useremail+"&action=check_existing_user_email",
				success: function(result) { 						
					if(result['success'] == true){
						jQuery("#email_label").text('');
						//alert(result['success']);
					    //jQuery("input[name='usrconfirmemail']").focus();
					} else {
					//alert(result['error']);
					//generateNotification(result['error'], "error");
					jQuery("#email_label").text("Email already exists");										
					jQuery("#email_label").css("color","red");
					jQuery("#email").css("border-color","red");

					jQuery("input[name='email']").focus();

					return false;
					}
				}
			});
		}
	});
	 
  });

</script>

 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

 <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
 <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
 <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
 <script src="https://unpkg.com/jquery-input-mask-phone-number@1.0.4/dist/jquery-input-mask-phone-number.js"></script>
 <script>
 	function trainer_validation() {

		var active = jQuery( "#tabs" ).tabs( "option", "active" );
		var is_error = false;
		var tab = 0;
		jQuery(".error").remove();

		var first_name=jQuery("#member_name").val();
		var Phone_number = jQuery("#Phone_number" ).val();
		var password1=jQuery("#password1").val();
		var password2=jQuery("#password2").val();
		var email = jQuery("#email").val();
		var trainer_type = jQuery("#trainer_type").val();
		var time_slots = jQuery("#time_slot").val();
		var Country = jQuery("#Country").val();
		var State = jQuery("#state").val();
		var City = jQuery("#City").val();
		

		if (first_name.length < 1) {
	      	jQuery('#fn_label').html('<span class="error">This field is required</span>');
	      	is_error = true;

	    }
	    if(Phone_number.length >=1){

			var phone = jQuery("#Phone_number" ).val();
			//alert(phone);
			phone = phone.replace(')','');
			phone = phone.replace('(','');
			phone = phone.replace('-','');
			phone = phone.replace(/\s/g,'');
			if(!phone.match(/^[-()0-9]+$/)) {
				jQuery("#phone_msg").html('<span class="error">Please enter numbers only.</span>');
				is_error = true;
			} else {
				var formated_phone = '';
		        char = { 0: '(', 3: ') ', 6: '-' };
		            
		        for (var i = 0; i < phone.length; i++) {
		            formated_phone += (char[i] || '') + phone[i];
		        }
		        jQuery("#Phone_number").val(formated_phone);
			}
		}
	    if (email.length < 1) {
	      	jQuery('#email_label').html('<span class="error">This field is required</span>');
	      	is_error = true; 
	    } else if (!validateEmail(email) ) {
	    	jQuery('#email_label').html('<span class="error">Invalid Email id</span>');
	      	is_error = true; 
	    }
	<?php if(empty($uid)){  ?>
		    if (password1.length < 1) {
		      	jQuery('#pwd_label').html('<span class="error">This field is required</span>');
		      	is_error = true; 	
		    } else if (password1.length < 8) {
		    	jQuery('#pwd_label').html('<span class="error">Password should be at least 8 characteres long</span>');
		      	is_error = true; 
		    }

		    if (password2.length < 1) {
		      	jQuery('#cpwd_label').html('<span class="error">This field is required</span>'); 
		      	is_error = true;	
		    } else if (password2.length < 8) {
		    	jQuery('#cpwd_label').html('<span class="error">Password should be at least 8 characteres long</span>');
		      	is_error = true; 
		    }

			if(password1 != password2)
			{
				jQuery('#cpwd_label').html('<span class="error">Please confirm password</span>');
		      	is_error = true;		
			}
	<?php } ?>

		if (trainer_type.length < 1) {
	      	jQuery('#trainer_type_label').html('<span class="error">This field is required. Please choose option.</span>');
	      	is_error = true; 
	    } 

	    if (time_slots.length < 1) {
	      	jQuery('#time_slot_label').html('<span class="error">This field is required. Please choose option.</span>');
	      	is_error = true; 
	    } 

		if(is_error) { 

			jQuery( "#tabs" ).tabs( "option", "active", tab);
			//jQuery("html, body").animate({ scrollTop: 200 }, "slow");

			return false;
		} else {  
			var disable_tab = [0, 1];	
			disable_tab.splice(disable_tab.indexOf(active + 1), 1);			
			jQuery("#tabs").tabs({disabled: false });
			jQuery("#tabs").tabs("option", "active", active + 1);
			jQuery("#tabs").tabs("option", "disabled", disable_tab);
			//jQuery("html, body").animate({ scrollTop: 200 }, "slow");		    
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
	jQuery( function() {
		jQuery('#Phone_number').usPhoneFormat({
                    format: '(xxx) xxx-xxxx' ,
                });
		jQuery("#tabs").tabs();
		jQuery("#tabs").tabs("option", "disabled", [1]);
		jQuery(".nexttab").click(function() {
			trainer_validation();
			// var active = jQuery( "#tabs" ).tabs( "option", "active" );
		 //    jQuery( "#tabs" ).tabs( "option", "active", active + 1 );
		});	
	} );

  function removeFile(file_number) {
	//alert("hi");
				console.log("before-" + total_file);
				jQuery('#file_group' + file_number).remove();
				total_file--;
				console.log("after-" + total_file);
			}
  </script>

 <?php

    global $wpdb, $user_ID;  
    if (!$user_ID) { 


	$error= '';
	$success = '';
 
	global $wpdb, $PasswordHash, $current_user, $user_ID;
 	 
    
	?>

<div id="msg" class="alignleft1"><p><?php if($success != "") { echo $success; } ?> <?php if($error!= "") { echo $error; } ?></p></div>	

<div id="tabs">
  <ul>
    <li><a href="#tabs-1">Personal Information</a></li>
    <li><a href="#tabs-2">Other Information</a></li>
    
  </ul>
 <div id="tabs-1">
<form method="post" id="frmregtrainer" enctype="multipart/form-data">

<p><label>Name</label><span class="required"> * </span><label id="fn_label"></label></p>
<p><input type="text" value="" name="member_name" id="member_name" size="20" class="form-control" /></p>
<p><label>Phone number</label><label id="phone_msg"></label></p>
<p><input type="text" value="" name="Phone_number" id="Phone_number" class="form-control" placeholder="(xxx) xxx--xxxx" onblur="phnfunction()" /></p>
<p><label>Email ID</label><span class="required"> * </span><label id="email_label"></label></p>
<p><input type="text" value="" name="email" id="email" class="form-control"/></p>
<p><label>Password</label><span class="required"> * </span><label id="pwd_label"></label></p>
<p><input type="password" value="" name="password1" id="password1" class="form-control" /></p>
<p><label>Confirm password</label><span class="required"> * </span><label id="cpwd_label"></label></p>
<p><input type="password" value="" name="password2" id="password2" class="form-control" /></p>

<p><label>Type of trainer</label><span class="required"> * </span><label id="trainer_type_label"></label></p>
<p>
<select name="trainer_type" id="trainer_type">
	<option value="">Select Trainer Type</option>
	<option value="personal">Personal Trainer</option>
	<option value="remote">Remote Trainer</option>
	<option value="Either">Either</option>
	
</select>
</p>

<p><label>Time Slots</label><span class="required"> * </span><label id="time_slot_label"></label></p>
<p>
<select name="time_slot" id="time_slot">
	<option value="">Select Time Slots</option>
	 <option value="HST">HST (Hawaii Standard Time)</option>
	 <option value="AKST">AKST (Alaska Standard Time)</option>
	 <option value="PST">PST (Pacific Standard Time)</option>
	 <option value="MST">MST (Mountain Standard Time)</option>
	 <option value="CST">CST (Central Standard Time)</option>
	 <option value="EST">EST (Eastern Standard Time)</option>
	<!-- <option value="1">5 am to 6 am</option>
	<option value="2">6 am to 7 am</option>
	<option value="3">7 am to 8 am</option>
	<option value="4">8 am to 9 am</option> -->
</select>
</p>

<p><label>Country</label></p>
<!--<p><input type="text" value="" name="Country" id="Country" class="form-control" /></p>-->
<p>
<select name="Country" id="Country" class="dropdown">
	<!--<option value="">Select Country</option>-->
	<option value="231">United States</option>
    <?php
    global $wpdb;
    $results=$wpdb->get_results("select * from wp_countries");                                                
    foreach($results as $result){													
	?>
		<option value="<?php echo $result->id;?>"><?php echo $result->name;?></option>
	<?php
	}                                                
    ?>
</select>

</p>

<p><label>State</label></p>
<p>
<select name="State" id="state">
<?php
$results=$wpdb->get_results("select * from wp_states where country_id=231");
foreach($results as $result){ 
?>
<option value="<?php echo $result->id;?>"><?php echo $result->name;?></option>
<?php
}                                                
?>	
 </select>
 </p>

<p><label>City</label></p>
<p>
<select name="City" id="City">
<?php
global $wpdb;
		$results=$wpdb->get_results("select * from cities where state_id=3919");
		foreach($results as $result){ 
?>
<option value="<?php echo $result->id;?>"><?php echo $result->name;?></option>
<?php } ?>	
 </select>
 </p>

 <input type="button" name="" class="nexttab btn btn-primary" value="next">
</div>

<div id="tabs-2">
<p><label>Gym name</label></p>
<p><input type="text" value="" name="Gym_name" id="Gym_name" class="form-control" /></p>

<p><label>Address</label></p>
<p><input type="text" value="" name="Location" id="Location" class="form-control" /></p>

<p><label>Sport(s)</label></p>
<p><input type="text" value="" name="Sport" id="Sport" class="form-control" /></p>

<p><label>Training specialties </label></p>
<p><p><input type="text" value="" name="Training_specialties" id="Training_specialties" class="form-control" /></p>

 <!-- <p><label>Certificates </label></p>
<p><input type="file" name="certificates[]" id="certificates" class="form-control" multiple="multiple" /></p>  -->

<div class="col-sm-12 col-xs-12">
   <div class="form-group" id="fields_wrapper">
    
      <div class="input-group">										  
        <div class="input-group-btn" >											
            <span class="fileUpload btn btn-success">												 
              <span class="upl" id="upload1">Upload Your Certificates</span>
              <input type="file" class="upload up" class="certificates1" name="certificates[]" id="certificates_1" data-multiple-caption="{count} files selected" onchange="javascript: onFileSelectForMulti(this, 1);"/>
            </span><!-- btn-orange -->


         </div><!-- btn -->                                         
          <!--  <a href="#"><i class="fa fa-remove"></i></a>  -->
     </div><!-- group -->        
   	</div><!-- form-group -->
    	<a class="add_file"  id="btn_add_more"  data-hover="Add More" href="javascript:void(0)">Add another file</a>
	</div> 

<button type="button" name="btnregister" id="btnregistertrainer" class="btn btn-primary" >Register</button>
<input type="hidden" name="task" value="register" />
<!-- Image loader -->
<div id='loader' style='display: none;padding-top: 30px;padding-left: 30px;'>
  <img src='<?php echo site_url();?>/wp-content/uploads/2018/11/loader.gif' width='32px' height='32px'>
</div>
<!-- Image loader -->
</div>
</div>

</form>
  <?php
    }
    else {  
   wp_redirect( home_url() ); exit;  
}  
}




/* The function that handles the AJAX request */
function state_frontend() {
 
	if(isset($_POST["country_id"])){
		$country_id=$_POST['country_id'];
		global $wpdb;
		$results=$wpdb->get_results("select * from wp_states where country_id=$country_id"); 
		                                             
		echo '<option value="">Select state</option>';
		if(isset($_POST['stateid'])){
			$sid=$_POST['stateid'];
			foreach($results as $result){
				$state_id=$result->id;
				$state_name=$result->name;	
			?>			
				<option value="<?php echo $state_id;?>" <?php if($sid==$state_name){echo 'selected';}?>><?php echo $state_name; ?></option>";
			<?php
			}		
		}else{
			foreach($results as $result){
				$state_id=$result->id;
				$state_name=$result->name;
				echo "<option value='$state_id'>$state_name</option>";
			}
			
		}
		
	}
    
}

add_action('wp_ajax_state_frontend', 'state_frontend');
add_action('wp_ajax_nopriv_state_frontend', 'state_frontend');

/* 26-11-2018 code started  */


/* The function that handles the AJAX request */

// function add_ques_answ(){
 	 
// 	//$ques_id = $_POST['ques_id'];
	
// 	$ques_16_ans = $_POST['ques_16_ans'];
// 	$ques_17_ans = $_POST['ques_17_ans'];
// 	$ques_18_ans = $_POST['ques_18_ans'];
// 	$ques_19_ans = $_POST['ques_19_ans'];

// 	$logged_in_user_id = get_current_user_id();  

// 	if($ques_16_ans!='' && $ques_17_ans!='' && $ques_18_ans!=''){
	
// 		global $wpdb;
// 		$cp_ques_user_ans = $wpdb->prefix.'ques_user_ans';	

// 		$already_present = $wpdb->get_row( "SELECT * FROM $cp_ques_user_ans WHERE user_id = $logged_in_user_id AND ques_id =16 ", ARRAY_A );
		
// 		$already_present =false;

// 		//if(count($already_present)>0){

// 		if($already_present){
		
// 			echo "Already Answered";

// 		}else{
// 			//
				
// 				$already_present_16 = $wpdb->get_row( "SELECT * FROM $cp_ques_user_ans WHERE user_id = $logged_in_user_id AND ques_id =16 ", ARRAY_A );

// 				if(false){
				
				
// 				}else{
				
// 					$is_inserted_16 =$wpdb->insert($cp_ques_user_ans,array('user_id' => $logged_in_user_id ,'ques_id' => 16 ,'ques_ans' => "$ques_16_ans"), 
// 					array('%d', '%d','%s'));
				
// 				}

				
// 				$already_present_17 = $wpdb->get_row( "SELECT * FROM $cp_ques_user_ans WHERE user_id = $logged_in_user_id AND ques_id =17 ", ARRAY_A );
				
// 				if(false){ 
				
// 				}else{
			
// 				$is_inserted_17 =$wpdb->insert($cp_ques_user_ans,array('user_id' => $logged_in_user_id ,'ques_id' => 17 ,'ques_ans' => "$ques_17_ans"), 
// 				array('%d', '%d','%s'));
				
// 				}



// 				$is_inserted_18 =$wpdb->insert($cp_ques_user_ans,array('user_id' => $logged_in_user_id ,'ques_id' => 18 ,'ques_ans' => "$ques_18_ans"), 
// 				array('%d', '%d','%s'));

// 				$is_inserted_19 =$wpdb->insert($cp_ques_user_ans,array('user_id' => $logged_in_user_id ,'ques_id' => 19 ,'ques_ans' => "$ques_19_ans"), 
// 				array('%d', '%d','%s'));

// 			if($is_inserted_16 && $is_inserted_17 && $is_inserted_18 && $is_inserted_19){  }else{ echo 'Problem in add'; }

// 			//
// 		}
	
// 	}else{
	
// 	 echo 'All Values are not present';

// 	}



// 	die();
    
// }


function add_ques_answ(){

	//echo "added";
     	 
	$ques_id = $_POST['ques_id'];
	
	$ques_16_ans = $_POST['ques_16_ans'];
	$ques_17_ans = $_POST['ques_17_ans'];
	$ques_18_ans = $_POST['ques_18_ans'];
	$ques_19_ans = $_POST['ques_19_ans'];

	$logged_in_user_id = get_current_user_id(); 

	$question_array = array('16','17','18','19');
	$anser_array = array ($ques_16_ans,$ques_17_ans,$ques_18_ans,$ques_19_ans);

	//print_r($anser_array);
	global $wpdb;
	$cp_ques_user_ans = $wpdb->prefix.'ques_user_ans';	

    $wpdb->delete( 'cp_ques_user_ans', array( 'ques_id' => 16 , 'user_id' => $logged_in_user_id ), array( '%d','%d' ) );
	$wpdb->delete( 'cp_ques_user_ans', array( 'ques_id' => 17,'user_id' => $logged_in_user_id ), array( '%d','%d' ) );
	$wpdb->delete( 'cp_ques_user_ans', array( 'ques_id' => 18,'user_id' => $logged_in_user_id ), array( '%d','%d' ) );
	$wpdb->delete( 'cp_ques_user_ans', array( 'ques_id' => 19,'user_id' => $logged_in_user_id ), array( '%d','%d' ) );


    for($i=0;$i<sizeof($question_array);$i++)
	{
        
		$is_inserted =$wpdb->insert($cp_ques_user_ans,array('user_id' => $logged_in_user_id ,'ques_id' => $question_array[$i] ,'ques_ans' =>$anser_array[$i] ), 
  				array('%d', '%d','%s'));
	}

	die();

	} 

add_action('wp_ajax_add_ques_answ', 'add_ques_answ');
add_action('wp_ajax_nopriv_add_ques_answ', 'add_ques_answ');


/* 26-11-2018 code ended  */

// 27th Nov 2018 code started

function add_ques_answ_2(){
 	 
	//$ques_id = $_POST['ques_id'];
	
	$ques_20_ans = $_POST['ques_20_ans'];
	$ques_21_ans = $_POST['ques_21_ans'];

	echo $ques_20_ans;
	echo $ques_21_ans;

	//exit;

	$logged_in_user_id = get_current_user_id();  

	if($ques_20_ans!='' && $ques_21_ans!=''){
	
		global $wpdb;
		$cp_ques_user_ans = $wpdb->prefix.'ques_user_ans';	

		$already_present = $wpdb->get_row( "SELECT * FROM $cp_ques_user_ans WHERE user_id = $logged_in_user_id AND ques_id =20 ", ARRAY_A );

		
		 $wpdb->delete( 'cp_ques_user_ans', array( 'ques_id' => 20,'user_id' => $logged_in_user_id ), array( '%d','%d' ) );
		 $wpdb->delete( 'cp_ques_user_ans', array( 'ques_id' => 21,'user_id' => $logged_in_user_id), array( '%d','%d') );
		 
			$is_inserted_16 =$wpdb->insert($cp_ques_user_ans,array('user_id' => $logged_in_user_id ,'ques_id' => 20 ,'ques_ans' => "$ques_20_ans"), 
				array('%d', '%d','%s'));

				$is_inserted_17 =$wpdb->insert($cp_ques_user_ans,array('user_id' => $logged_in_user_id ,'ques_id' => 21 ,'ques_ans' => "$ques_21_ans"), 
				array('%d', '%d','%s'));
		
		  
	
	}else{
	
	 echo 'All Values are not present';

	}



	die();
    
}

add_action('wp_ajax_add_ques_answ_2', 'add_ques_answ_2');
add_action('wp_ajax_nopriv_add_ques_answ_2', 'add_ques_answ_2');

function add_ques_answ_3(){
//print_r($_POST);

//exit;

$ques_22_ans = $_POST['ques_22_ans'];
$ques_24_ans = $_POST['ques_24_ans'];

$logged_in_user_id = get_current_user_id();

//print_r($ques_22_ans);
//print_r($ques_24_ans);

global $wpdb;

$wpdb->delete( 'cp_ques_user_ans', array( 'ques_id' => 22,'user_id' => $logged_in_user_id ), array( '%d','%d' ) );
$wpdb->delete( 'cp_ques_user_ans', array( 'ques_id' => 24,'user_id' => $logged_in_user_id ), array( '%d','%d' ) );

$is_inserted_22 =$wpdb->insert('cp_ques_user_ans',array('user_id' => $logged_in_user_id ,'ques_id' => 22 ,'ques_ans' => "$ques_22_ans"), 
				array('%d', '%d','%s'));

$is_inserted_24 =$wpdb->insert('cp_ques_user_ans',array('user_id' => $logged_in_user_id ,'ques_id' => 24 ,'ques_ans' => "$ques_24_ans"), 
				array('%d', '%d','%s')); 


die();
}


add_action('wp_ajax_add_ques_answ_3', 'add_ques_answ_3');
add_action('wp_ajax_nopriv_add_ques_answ_3', 'add_ques_answ_3');


function fn_injury_frm_sbmt_yes()
{
	//echo"<pre>";
	//print_r($_POST['boxarra']);
    
    $question_26_ans = $_POST['Question_26_ans'];
    $question_31_ans = $_POST['Question_31_ans'];
    $question_27_ans = $_POST['Question_27_ans'];
    $question_34_ans = $_POST['Question_34_ans'];
    $question_28_ans = $_POST['Question_28_ans'];
    $question_29_ans = $_POST['Question_29_ans'];
    $question_35_ans = $_POST['Question_35_ans'];
    $question_30_ans = $_POST['Question_30_ans'];

    $health_questions = $_POST['boxarra'];

    
	$logged_in_user_id = get_current_user_id();

	global $wpdb;

     $wpdb->delete( 'cp_ques_user_ans', array( 'ques_id' => 26 , 'user_id' => $logged_in_user_id ), array( '%d','%d' ) );
     $wpdb->delete( 'cp_ques_user_ans', array( 'ques_id' => 31 , 'user_id' => $logged_in_user_id ), array( '%d','%d' ) );
     $wpdb->delete( 'cp_ques_user_ans', array( 'ques_id' => 27 , 'user_id' => $logged_in_user_id ), array( '%d','%d' ) );
     $wpdb->delete( 'cp_ques_user_ans', array( 'ques_id' => 34 , 'user_id' => $logged_in_user_id ), array( '%d','%d' ) );
     $wpdb->delete( 'cp_ques_user_ans', array( 'ques_id' => 28 , 'user_id' => $logged_in_user_id ), array( '%d','%d' ) );
     $wpdb->delete( 'cp_ques_user_ans', array( 'ques_id' => 29 , 'user_id' => $logged_in_user_id ), array( '%d','%d' ) );
     $wpdb->delete( 'cp_ques_user_ans', array( 'ques_id' => 35 , 'user_id' => $logged_in_user_id ), array( '%d','%d' ) );
     $wpdb->delete( 'cp_ques_user_ans', array( 'ques_id' => 30 , 'user_id' => $logged_in_user_id ), array( '%d','%d' ) );
    
     $wpdb->delete( 'cp_ques_user_ans', array( 'ques_id' => 32 , 'user_id' => $logged_in_user_id ), array( '%d','%d' ) );




	$is_inserted_26 =$wpdb->insert('cp_ques_user_ans',array('user_id' => $logged_in_user_id ,'ques_id' => 26 ,'ques_ans' => "$question_26_ans"), 
				array('%d', '%d','%s'));



	 if($question_26_ans == 'Yes')
        {
     
	$is_inserted_31 =$wpdb->insert('cp_ques_user_ans',array('user_id' => $logged_in_user_id ,'ques_id' => 31 ,'ques_ans' => "$question_31_ans"), 
				array('%d', '%d','%s'));

	$is_inserted_27 =$wpdb->insert('cp_ques_user_ans',array('user_id' => $logged_in_user_id ,'ques_id' => 27 ,'ques_ans' => "$question_27_ans"), 
				array('%d', '%d','%s'));

	$is_inserted_34 =$wpdb->insert('cp_ques_user_ans',array('user_id' => $logged_in_user_id ,'ques_id' => 34 ,'ques_ans' => "$question_34_ans"), 
				array('%d', '%d','%s'));

	$is_inserted_28 =$wpdb->insert('cp_ques_user_ans',array('user_id' => $logged_in_user_id ,'ques_id' => 28 ,'ques_ans' => "$question_28_ans"), 
				array('%d', '%d','%s'));

	$is_inserted_29 =$wpdb->insert('cp_ques_user_ans',array('user_id' => $logged_in_user_id ,'ques_id' => 29 ,'ques_ans' => "$question_29_ans"), 
				array('%d', '%d','%s'));

	$is_inserted_35 =$wpdb->insert('cp_ques_user_ans',array('user_id' => $logged_in_user_id ,'ques_id' => 35 ,'ques_ans' => "$question_35_ans"), 
				array('%d', '%d','%s'));

	$is_inserted_30 =$wpdb->insert('cp_ques_user_ans',array('user_id' => $logged_in_user_id ,'ques_id' => 30 ,'ques_ans' => "$question_30_ans"), 
				array('%d', '%d','%s'));

}
else
{
   //print_r($health_questions);

   $health_str = implode(",",$health_questions);

   $is_inserted_32 =$wpdb->insert('cp_ques_user_ans',array('user_id' => $logged_in_user_id ,'ques_id' => 32 ,'ques_ans' => "$health_str"), 
				array('%d', '%d','%s'));


}



	die();
}

add_action('wp_ajax_injury_frm_sbmt_yes', 'fn_injury_frm_sbmt_yes');
add_action('wp_ajax_nopriv_injury_frm_sbmt_yes', 'injury_frm_sbmt_yes');












// 27th Nov code ended 

/* The function that handles the AJAX request */
function city_frontend() {
 
	if(isset($_POST["state_id"])){
		$state_id=$_POST['state_id'];
		global $wpdb;
		$results=$wpdb->get_results("select * from cities where state_id=$state_id"); 
		                                             
		echo '<option value="">Select city</option>';
		if(isset($_POST['state_id'])){
			$sid=$_POST['state_id'];
			foreach($results as $result){
				$city_id=$result->id;
				$city_name=$result->name;	
			?>			
				<option value="<?php echo $city_id;?>" <?php if($sid==$city_name){echo 'selected';}?>><?php echo $city_name; ?></option>";
			<?php
			}		
		}else{
			foreach($results as $result){
				$city_id=$result->id;
				$city_name=$result->name;
				echo "<option value='$state_id'>$city_name</option>";
			}
			
		}
		
	}
    
}

add_action('wp_ajax_city_frontend', 'city_frontend');
add_action('wp_ajax_nopriv_city_frontend', 'city_frontend');


// The function that handles the AJAX request user registration

function register_user_frontend() {
 global $wpdb; 

       $first_name = $wpdb->escape(trim($_POST['first_name']));
       $Phone_number = $wpdb->escape(trim($_POST['Phone_number']));
       $email = $wpdb->escape(trim($_POST['email']));
	   $password1 = $wpdb->escape(trim($_POST['password1']));
	   $password2 = $wpdb->escape(trim($_POST['password2']));
       $Country = $wpdb->escape(trim($_POST['Country']));
       $State = $wpdb->escape(trim($_POST['State']));
       $City = $wpdb->escape(trim($_POST['City']));
       $Sport = $wpdb->escape(trim($_POST['Sport']));
       $cstatus = $wpdb->escape(trim($_POST['cstatus']));
       $username = $wpdb->escape(trim($_POST['member_name']));
       $membership_id = $wpdb->escape(trim($_POST['membership_id']));
       $age = $wpdb->escape(trim($_POST['age']));
       $pname = $wpdb->escape(trim($_POST['pname']));
       $paddress = $wpdb->escape(trim($_POST['paddress']));
       $pphone = $wpdb->escape(trim($_POST['pphone']));
       $pemail = $wpdb->escape(trim($_POST['pemail']));

       $school = $wpdb->escape(trim($_POST['school']));
       $school_name = $wpdb->escape(trim($_POST['school_name']));
       $school_city = $wpdb->escape(trim($_POST['school_city']));
       $school_state = $wpdb->escape(trim($_POST['school_state']));
       $coach_name = $wpdb->escape(trim($_POST['coach_name']));

       // $time_slot = $wpdb->escape(trim($_POST['time_slot']));
       // $trainer_type = $wpdb->escape(trim($_POST['trainer_type']));

      // echo $password1;

       $userdata = array(
         'user_login' => $first_name,
		 'user_pass' => sanitize_text_field($_POST['password1']), 
		 'user_email' => $email,
		 'role' => 'member'
		 );

       $metas = array( 
			'Phone_number'   => $Phone_number,
			'Country' => $Country, 
			'State'  => $State ,
			'city'       => $City ,
			'Sport'     => $Sport,
			'cstatus'       => $cstatus, 
			'membership_id' => $membership_id,
            'age'=> $age,
            'parent_name' => $pname,
            'parent_address' => $paddress,
            'parent_phone' => $pphone,
            'parent_email' => $pemail,
            'school'=> $school,
            'school_name'=> $school_name,
            'school_city'=> $school_city,
            'school_state'=> $school_state,
            'coach_name'=> $coach_name
		);

    if($membership_id == FREE_MEMBERSHIP) { // For Free Trial Membership

    	$user_id = wp_insert_user($userdata); 
        foreach($metas as $key => $value) {
            update_user_meta( $user_id, $key, $value );
        }
		$code = sha1( $user_id . time() );    
		global $wpdb;  

		$wpdb->update( 
			'cp_users', 
			array( 
				'user_activation_key' => $code	// string			
			), 
			array( 'ID' => $user_id ), 
			array( '%s') 
		);


        $activation_link = add_query_arg( array( 'key' => $code, 'user' => $user_id ), get_permalink(16093));

         $user_info = get_userdata($user_id);
         $full_name =$user_info->user_login;
         $template_html_in_db = get_post_field('post_content',16144);
         $placeholder =array("{{FULLNAME}}","{{ACTIVATION_CODE}}");
         $value = array($full_name,$activation_link);
          

         $message_template = str_replace($placeholder, $value, $template_html_in_db );



        /* fetching email content from custom post type mail  */
               
         $headers[] = "MIME-Version: 1.0" . "\r\n";
        $headers[] = "Content-type:text/html;charset=utf-8" . "\r\n"; 
       
		

        $mail_sent = wp_mail($email,'User Activation',$message_template,$headers);  
 
		
		if($mail_sent){
			define('BASE_PATH', get_site_url());

			if($user_id){
				$result['error'] = false;
				$_SESSION ['success'] = "User registered successfully. You will receive the activation link and once you activate it you will able to login on website.";
				$result['message'] = "User registered successfully You will receive the activation link and once you activate it you will able log in on website";
				$result['user_id'] = $user_id;
				//header("Location: ".BASE_PATH."/registration/?id=".$user_id."#tabs-3");
				//die();
				
			} else {
				$result['error'] = true;
				$result['message'] = "Problem in adding user in system.";
			}

		}else{
		
			$result['error'] = true;
			$result['message'] = "Problem in Mail sending..";
		}
		//$result['redirect_to'] = get_home_url().'/registration';
		$result['membership'] = $membership_id;
		echo json_encode($result);
		die();
		   
    } else {
     
	    define('BASE_PATH', get_site_url());

	    //fetch paypal details

	    global $wpdb;
	    $result_payment=$wpdb->get_results("select * from cp_payment_mode where status='Active'");


	    $paypalUser		 = $result_payment[0]->username;
		$paypalPassword  = $result_payment[0]->password ;
		$paypalSignature = $result_payment[0]->signature;
		$paypalAppId     = $result_payment[0]->appkey ; 
		$paypalAccount['mode'] = $result_payment[0]->mode;

		$receiver ='sharad.kolhe-facilitator@gmail.com';


		/*$paypalUser		 = 'sharad.kolhe-facilitator_api1.gmail.com';
		$paypalPassword  = 'LGBWZ77ANP8HRZMK';
		$paypalSignature = 'AiPC9BjkCyDFQXbSkoZcgqH3hpacAr.VjudkRZkFqLBT8s.fbQk04iZo';
		$paypalAppId     = 'APP-80W284485P519543T'; 
		$paypalAccount['mode'] = 'SANDBOX';
		$receiver ='sharad.kolhe-facilitator@gmail.com';*/


		//get membership amount by membership id

		$membership_amt=$wpdb->get_results("select * from cp_gmgt_membershiptype where membership_id=".$membership_id);

		$item_amount = $membership_amt[0]->membership_amount;

	     //$item_amount = 0.1;

	    $_SESSION['amount']   = $item_amount;
	     
	     

		$_SESSION['receiver'] = $receiver;

        if($result_payment[0]->mode =='SANDBOX')
        {

		 $url = 'https://svcs.sandbox.paypal.com/AdaptivePayments/Pay';
		}
		else
		{
		 $url = 'https://svcs.paypal.com/AdaptivePayments/Pay';
		}
		$fields = array(
			'actionType'						=> 'PAY',
			'clientDetails.applicationId' 		=> $paypalAppId,
			'clientDetails.ipAddress' 	  		=> $_SERVER['REMOTE_ADDR'],				
			'currencyCode'				  		=> 'USD',
			'receiverList.receiver(0).amount' 	=> $item_amount,
			'receiverList.receiver(0).email'  	=> $receiver,				
			'requestEnvelope.errorLanguage'	  	=> 'en_US',
			'cancelUrl'						  	=> BASE_PATH.'paypal_parallel/cancel.php',
			'returnUrl'							=> BASE_PATH.'/success',
		);
		$fields_string = '';
		//url-ify the data for the POST
		foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
		rtrim($fields_string, '&');
		
		$headers = array('X-PAYPAL-SECURITY-USERID: '.$paypalUser.'',
						 'X-PAYPAL-SECURITY-PASSWORD: '.$paypalPassword.'',
						 'X-PAYPAL-SECURITY-SIGNATURE: '.$paypalSignature.'',
						 'X-PAYPAL-REQUEST-DATA-FORMAT: NV',
						 'X-PAYPAL-RESPONSE-DATA-FORMAT: NV',
						 'X-PAYPAL-APPLICATION-ID: '.$paypalAppId.'');
		//open connection
		$ch = curl_init();
		
		curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);
		curl_setopt($ch,CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch,CURLOPT_POST, count($fields));
		curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
		
		
		//execute post
		$res = curl_exec($ch);
		
		$info = curl_errno($ch);  //echo $info; echo "<br>";
			
		$err = curl_error($ch);   //echo $err; echo "<br>";
		
		//close connection
		curl_close($ch);
		
		 
		$res_arr = explode("&",$res);	
		 

	    $resp_arr_pay_key  = explode("=",$res_arr[4]); 
		
	    $resp_arr2  = explode("=",$res_arr[1]);
		
		$_SESSION['pay_key'] = $resp_arr_pay_key[1];
		
		$_SESSION['usrid']   = $user_id;
		$_SESSION['email']   = $email;

		$_SESSION['userdata'] = $userdata;
		$_SESSION['usermeta'] = $metas;

		$_SESSION['membership_id'] = $membership_id;

	    if($resp_arr2[1] == 'Success'){

        if($result_payment[0]->mode =='SANDBOX')
        {

	   	$redirect_url = 'https://www.sandbox.paypal.com/cgi-bin/webscr?cmd=_ap-payment&paykey='.$resp_arr_pay_key[1];
	    }
	    else
	    {
	    	$redirect_url = 'https://www.paypal.com/cgi-bin/webscr?cmd=_ap-payment&paykey='.$resp_arr_pay_key[1];;
	    	
	    }
	   	
	   	$result['url'] = $redirect_url;
		   	$result['error'] = false;

		echo json_encode($result);
	   	// echo $redirect_url;

	   }
	}
 exit;
}


add_action('wp_ajax_register_member', 'register_user_frontend');
add_action('wp_ajax_nopriv_register_member', 'register_user_frontend');





// The function that handles the AJAX request trainer registration

function register_trainer_frontend() {
 global $wpdb; 
   
      //print_r($_FILES);
       

       $first_name = $wpdb->escape(trim($_POST['first_name']));
       $Phone_number = $wpdb->escape(trim($_POST['Phone_number']));
       $email = $wpdb->escape(trim($_POST['email']));
	   $password1 = $wpdb->escape(trim($_POST['password1']));
	   $password2 = $wpdb->escape(trim($_POST['password2']));
       $Country = $wpdb->escape(trim($_POST['Country']));
       $State = $wpdb->escape(trim($_POST['State']));
       $City = $wpdb->escape(trim($_POST['City']));
       $Sport = $wpdb->escape(trim($_POST['Sport']));
       $username = $wpdb->escape(trim($_POST['member_name']));

       $Gym_name = $wpdb->escape(trim($_POST['Gym_name']));
       $Location = $wpdb->escape(trim($_POST['Location']));
       $Training_specialties = $wpdb->escape(trim($_POST['Training_specialties']));
       $trainer_type = $wpdb->escape(trim($_POST['trainer_type']));
       $time_slot = $wpdb->escape(trim($_POST['time_slot']));

       //echo $first_name;


       $file_array=array();

        for($i=0;$i<sizeof($_FILES);$i++)
        {

            array_push($file_array,$_FILES['file'.$i]['name']);

             
        }

        $file_name_str = implode(",",$file_array);

        

      // echo $password1;

        $userdata = array(
         'user_login' => $first_name,
		 'user_pass' => sanitize_text_field($_POST['password1']), 
		 'user_email' => $email,
		 'role' => 'staff_member'
		 );

        $user_id = wp_insert_user($userdata); 



     if ( $user_id && !is_wp_error( $user_id ) ) {
 
         $code = sha1( $user_id . time() );    
         global $wpdb;  
         
        $wpdb->update( 
			'cp_users', 
			array( 
				'user_activation_key' => $code	// string
				
			), 
			array( 'ID' => $user_id ), 
			array( 
				'%s'	// value1
				
			) 
        );

        $stat ='0';

        $wpdb->update( 
			'cp_users', 
			array( 
				'user_status' => $stat	// string 
				
			), 
			array( 'ID' => $user_id ), 
			array( 
				'%s'	// value1
				
			) 
        );

        //get user name from user id

         $user_info = get_userdata($user_id);
         $username = $user_info->user_login;


         $activation_link = add_query_arg( array( 'key' => $code, 'user' => $user_id ), get_permalink(16100)); 

         //sending notification to user

         //$message = 'Hi, '.$username.' Your registration in progress  submitted for approval please click on activation link : '.$activation_link;
        
         $user_info = get_userdata($user_id);
         $full_name =$user_info->user_login;
         $template_html_in_db = get_post_field('post_content',16146);
         $placeholder =array("{{FULLNAME}}");
         $value = array($full_name);
          

         $message_template = str_replace($placeholder, $value, $template_html_in_db );



        /* fetching email content from custom post type mail  */
               
         $headers[] = "MIME-Version: 1.0" . "\r\n";
        $headers[] = "Content-type:text/html;charset=utf-8" . "\r\n"; 
       
        

        $mail_sent = wp_mail($email,'User Activation',$message_template,$headers);  





         

       //  $message = 'Hi, '.$username.' Please Login to complete your profile ';

          //wp_mail( $email, 'User Activation', 'Activation link : ' . $activation_link );
        // wp_mail( $email, 'User Activation', $message );

         //sending notification to admin for aaproval

          $adminemail = get_option('admin_email');

          //$adminemail ='neogannear@gmail.com';

          
          $template_html_in_db_new = get_post_field('post_content',16147);
          $placeholder_new =array("{{USERNAME}}");
          $value_new = array($full_name);
          $message_template_new = str_replace($placeholder_new, $value_new, $template_html_in_db_new );

          $headers1[] = "MIME-Version: 1.0" . "\r\n";
          $headers1[] = "Content-type:text/html;charset=utf-8" . "\r\n"; 
       
        

        $mail_sent = wp_mail($adminemail,'New Trainer Registration',$message_template_new,$headers1);  


         // $admmessage = 'Hi, New trainer '.$username.' has been registered.';
    
         //wp_mail( $adminemail, 'New Trainer Registration', $admmessage );

      }

 
     $metas = array( 
		    'Phone_number'   => $Phone_number,
		    'Country' => $Country, 
		    'State'  => $State ,
		    'city'       => $City ,
		    'Sport'     => $Sport,
		    'Gym_name'       => $Gym_name,
		    'Location'       => $Location,
		    'Training_specialties'       => $Training_specialties,
		    'trainer_type' => $trainer_type,
		    'time_slot' => $time_slot,
		    'documents' => $file_name_str

		   	);

       foreach($metas as $key => $value) {
            update_user_meta( $user_id, $key, $value );
        }


        //save lat long in datbase for trainer location

    $address = $Location;
    $siteKey = 'AIzaSyB55KEoT15-q2rte2P67iL4wC05RTSuyUA';
    $returnValue = array();
    $resultData = array();
    $green = 0;
    $red = 0;
    $orange = 0;
         
  if (isset($address) && (!empty($address)))
    {
     $address = preg_replace('/\s+/', '+', $address);
     $url = "https://maps.googleapis.com/maps/api/geocode/json?address=" . $address . "&key=" . $siteKey . "";
        // Get cURL resource
        $curl = curl_init();
        // Set some options - we are passing in a useragent too here
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => $url,
            CURLOPT_USERAGENT => ''
        ));
        // Send the request & save response to $resp
        $server_output = curl_exec($curl);
        $http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        if ($http_status == 200) {
            $output = json_decode($server_output, true);
            //print_r($output);
             if (isset($output) && (!empty($output))) {
                $formatted_address = $output['results'][0]['formatted_address'];
                $latitude = $output['results'][0]['geometry']['location']['lat'];
                $longitude = $output['results'][0]['geometry']['location']['lng'];

                echo $latitude; echo "<br/>";
                echo $longitude;

                 $wpdb->insert( 
			'cp_user_location', 
			array( 
				'user_id' => $user_id,
				'latitude' => $latitude,
				'longitude' => $longitude
			), 
			array( 
				'%d',
				'%d',
				'%d' 
				 
			) 
		);



             }
         }
    }

   
 

 exit;
}


add_action('wp_ajax_register_trainer', 'register_trainer_frontend');
add_action('wp_ajax_nopriv_register_trainer', 'register_trainer_frontend');


function register_trainer_upcv_frontend()
{
	
	echo"<pre>";
	print_r($_POST);
	print_r($_FILES);
	 
	//print_r($_POST);;
	$upload_dir = wp_upload_dir();
	$temp_name = $_FILES['file']['tmp_name'];
    $target_path = $upload_dir["basedir"]."/custom/";
    $upload_path = $upload_dir['baseurl'];
     //echo $target_path;
  
    for($i=0;$i<sizeof($_FILES);$i++)
    {

     $target_path = $upload_dir["basedir"]."/custom/";

    $target_path = $target_path . basename( $_FILES['file'.$i]['name']); 

		if(move_uploaded_file($_FILES['file'.$i]['tmp_name'], $target_path)) {
		    
		    $target_path ='';
		} else{
		    //echo "There was an error uploading the file, please try again!";
		}



     }
	die();

    
}

add_action('wp_ajax_trainer_up_cv', 'register_trainer_upcv_frontend');
add_action('wp_ajax_nopriv_trainer_up_cv', 'register_trainer_upcv_frontend');





/*gmgt_custom_grievancesform shortcode */


add_shortcode('gmgt_custom_grievancesfrm', 'gmgt_custom_grievances');

function gmgt_custom_grievances(){
	?>

	<script>
		  var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";
		  jQuery(document).ready(function(){
		  jQuery("#btnsumnitgrievnces").click(function(){
         
          var title=jQuery("#title").val();
          var description=jQuery("#description").val();


          if(title=='')
			{
			
			jQuery("#title").css("border-color","red");
			jQuery("#fn_label").text("Please Enter Name");
			jQuery("#fn_label").css("color","red");
			return false;	                                      
																									
			}
			else{

				jQuery("#title").css("border-color","#8d8d8d");
				jQuery("#fn_label").empty();
				}

			if(description=='')
			{
			
			jQuery("#description").css("border-color","red");
			jQuery("#desc_label").text("Please Enter Description");
			jQuery("#desc_label").css("color","red");
			return false;	                                      
																									
			}
			else{

				jQuery("#description").css("border-color","#8d8d8d");
				jQuery("#desc_label").empty();
				}

            var data = {
            action: 'grievence_frm_sbmt',
            title: title,
            description:description
           
           };

        
		 jQuery.ajax({ 
				 type:'POST', 
				 url:ajaxurl,
				 data,
				 success:function(html){ 
					jQuery('#msg').html("Form Submitted successfully"); 
					
				 }
				}); 


		  
		    });

			 
		  });
</script>
     
<div id="msg" class="alignleft1"><p><?php if($success != "") { echo $success; } ?> <?php if($error!= "") { echo $error; } ?></p></div>	

     <p><label>Name</label><span style="color:red;"> * </span>&nbsp;&nbsp;&nbsp;&nbsp;<label id="fn_label"></label></p>
     <p><input type="text" value="" name="title" id="title" size="20" class="form-control" /></p>
     <p><label>Description</label><span style="color:red;"> * </span>&nbsp;&nbsp;&nbsp;&nbsp;<label id="desc_label"></label></p>
     <p><textarea name="description" id ="description" rows="5" cols="40" ></textarea></p>
     <button type="submit" name="btnsumnitgrievnces" id="btnsumnitgrievnces" class="btn btn-primary" >Submit</button>


<?php

}


function grievence_frontend(){
      global $wpdb; 
	   $name = $wpdb->escape(trim($_POST['title']));
       $description = $wpdb->escape(trim($_POST['description']));

       $uid = get_current_user_id();


       $post = array(
		  'post_title'    => $name,
		  'post_content'  => $description,
		  'post_type'     =>'grievence',
		  'post_status'   => 'publish',
		  'post_author'   => 1
		);

       $post_id = wp_insert_post( $post, $wp_error='' );

       update_post_meta($post_id,'description',$description);
       update_post_meta($post_id,'userid',$uid);
   
       exit;

}


add_action('wp_ajax_grievence_frm_sbmt', 'grievence_frontend');
add_action('wp_ajax_nopriv_grievence_frm_sbmt', 'grievence_frontend');

/*Custom post type grievence*/

function create_post_type() {
  register_post_type( 'grievence',
    array(
      'labels' => array(
        'name' => __( 'Grievances' ),
        'singular_name' => __( 'Grievances' )
      ),
      'public' => true,
      'has_archive' => true,
    )
  );
}
add_action( 'init', 'create_post_type' );

function hd_add_box() {
  global $submenu;
  unset($submenu['edit.php?post_type=grievence'][10]);
}


add_action('admin_menu', 'hd_add_box');


// Add the custom columns to the book post type:


add_filter( 'manage_grievence_posts_columns', 'set_custom_edit_grievence_columns' );
function set_custom_edit_grievence_columns($columns) {
     $columns = array(
        'cb' => '&lt;input type="checkbox" />',
        'Title' => __( 'Title' ),
        'description' => __( 'Description' ),
        'submitted' => __( 'Submitted By' ),
        'date' => __( 'Date' )
    );
   

    return $columns;
}

 
add_action( 'manage_grievence_posts_custom_column' , 'custom_grievence_column', 10, 2 );
function custom_grievence_column( $column, $post_id ) {
    switch ( $column ) {

        
        case 'description' :
            echo get_post_meta( $post_id , 'description' , true ); 
            break;
        case 'submitted' :
            $uid = get_post_meta( $post_id , 'userid' , true );
            $udata = get_userdata( $uid ); 
            echo $udata->user_login;
            break;

    }
}


//aprove triner by admin from backend 
 

function approve_trainer()
{
    echo $_POST['staff_id'];
    global $wpdb;
     $wpdb->update( 
			'cp_users', 
			array( 
				//'user_status' => 0	// string
				'trainer_status' => 1	// string
				
			), 
			array( 'ID' => $_POST['staff_id'] ), 
			array( 
				'%d'	// value1
				
			) 
        );

      $update_status = update_user_meta($_POST['staff_id'],'trainer_status','1');

      $data = get_userdata($_POST['staff_id']); 

      $email = $data->user_email;
      $name = $data->user_login;

      //$msg = 'Hi, '.$name.' Your account has been approved to access to 4th Power Performance.';

      //send email to the triner about approval

    //wp_mail( $email, 'Request Approved', $msg );

      $headers[] = "MIME-Version: 1.0" . "\r\n";
      $headers[] = "Content-type:text/html;charset=utf-8" . "\r\n"; 
      $sendemail='ganesh.nehulkar@wwindia.com';
      $template_html_in_db = get_post_field('post_content',16160);
      $user_info = get_userdata($user_id);
      $username = $user_info->user_login;
      $placeholder =array("{{TRAINER}}");
      $value = array($name);
          

      $message_template = str_replace($placeholder, $value, $template_html_in_db );
                    
       
	  $mail_sent = wp_mail($email,'Request Approved',$message_template,$headers); 



    exit;
}


add_action('wp_ajax_approve_trainer', 'approve_trainer');
add_action('wp_ajax_approve_trainer', 'approve_trainer');



// The function that handles the AJAX request
function check_existing_user_email() {
 $useremail = sanitize_email($_POST['useremail']);
 $user = get_user_by('email', $useremail);
 if ($user) {
 $result['error'] = "Email already Exists. Please try another email.";
 //$result['userdata'] = $user;
 $result['success'] = false;
 } else {
 $result['message'] = "User not exists.";
 $result['success'] = true;
 }
 echo json_encode($result);
 exit;
}

add_action('wp_ajax_check_existing_user_email', 'check_existing_user_email');
add_action('wp_ajax_nopriv_check_existing_user_email', 'check_existing_user_email');



$capability ='manage_options';

// Add to admin_menu function
// add_menu_page(__('Question Type'), __('Question Type'), 'edit_themes', 'question_type', 'questiontype_render', '', 7); 

//  add_submenu_page( 'question_type', ' ', ' ',$capability, 'edit_question_typesss', 'edit_question_type');


// add_menu_page('Questionnaire', 'Questionnaire', 'manage_options', 'questionnaire');
// add_submenu_page( 'questionnaire', 'Question Type', 'Question Type',
//     'manage_options', 'questionnaire' ,'render_question_type');
//  add_submenu_page( 'questionnaire', 'My Custom Submenu Page', 'My Custom Submenu Page',
//     'manage_options', 'edit_question_type','edit_question_type');

// function test()
// {
// 	echo "hi";
// }






// add_menu_page('Question-Type', 'Question Type', $capability, 'Question-Type', 'render_question_type','','7');
// add_submenu_page( 'question_type', ' ', ' ', $capability, 'edit_question_type', 'edit_question_type');





 
function render_question_type() {
    global $title;
    ?>
        <h2><?php echo $title;?></h2>

        <!-- <h3><a href="<?php echo home_url(); ?>/wp-admin/admin.php?page=edit_question_type">Add Question-Type</a></h3> -->
        
        <?php
        global $wpdb;
        $results=$wpdb->get_results("select * from cp_question_type");
        ?>
        <table border="1" width="100%" style="border-collapse: collapse;">
        <tr>
        <th>Id</th>
        <th>Question Type</th>
        <th>Status</th>
        <th>Action</th>
        </tr>
        <?php
        foreach($results as $result){
        ?>
        <tr>
        <td><?php echo $result->id; ?></td>
        <td><?php echo $result->qtype; ?></td>
        <td><?php if($result->status=='1') { ?> Active  <?php }else { ?>Inactive <?php } ?></td>
        <td><a href="<?php echo home_url(); ?>/wp-admin/admin.php?page=edit_question_type&q_id=<?php echo $result->id;?>">Edit</a>&nbsp;<!-- <a  href="<?php echo home_url(); ?>/wp-admin/admin.php?page=edit_question_type&action=delete&q_id=<?php echo $result->id;?>">Delete</a> --></td>
        </tr>
        <?php
         }
         ?>
         </table>

<?php        	

}

function edit_question_type()
{
	global $wpdb;

     
	 
  	 if($_GET['q_id']!='' && $_GET['action']=='delete')
      {
      	$wpdb->delete( 'cp_question_type', array( 'id' => $_GET['q_id'] ), array( '%d' ) );
          


    	header('Location:/wp-admin/admin.php?page=render_question_type');
      }
  	
  

  if(isset($_POST['submit']))
  {
  	 $qtype = $_POST['qtype'];
  	 $status = $_POST['status'];
 
     if($_GET['q_id']!='')

     {

      $wpdb->update( 
			'cp_question_type', 
			array( 
				'qtype' => $qtype,
				'status' =>$status	// string
				
			), 
			array( 'id' => $_GET['q_id'] ), 
			array( 
				'%s',
				'%d'	// value1
				
			) 
        );

     	

  	}
  	else
  	{
  		//echo $qtype;
  		//exit;
         $wpdb->insert( 
			'cp_question_type', 
			array( 
				'qtype' => $qtype,
				'status' =>$status
			), 
			array( 
				'%s',
				'%d' 
				 
			) 
		);

  	}

  	header('Location:/wp-admin/admin.php?page=render_question_type');
  }

   $results=$wpdb->get_results("select * from cp_question_type where id='".$_GET['q_id']."'");

   if($_GET['action']!='delete')
   {
  ?>

 
  <div style="padding-top: 30px;">

  <?php if($_GET['q_id']) { ?> <h2>Edit Question Type </h2><?php } else { ?> <h2>Add Question Type</h2> <?php } ?>
  


  <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.18.0/jquery.validate.js'></script>
  <script type="text/javascript">
  	jQuery(document).ready(function () {
      jQuery('#frmeditqtype').validate({ // initialize the plugin
   errorElement: "div",
        rules: {
            qtype:{
                  required: true
			       },
			status: {
                  required: true
			       }
		  },

		messages:{

			 qtype:{
                  required:"Please enter question type"
			  },
			 status:{
                  required:"Please select the status"
			  } 


        }
    });

});
</script>

  <form name="frmeditqtype" id="frmeditqtype" method="post" action="">
  <table border="1" width="50%" style="border-collapse: collapse;">
  <tr>
  <td>Question Type</td>
  <td><input type="text" name="qtype" id="qtype" value="<?php echo $results[0]->qtype; ?>" style="width:400px;"></td>
  </tr>
  <tr>
  <td>Status</td>
  <td>
  <select name="status" id="status">
  	<option value="">Select the Status</option>
  	<option value="1" <?php if($results[0]->status == '1') { ?> selected='selected' <?php } ?>>Active</option>
  	<option value="0" <?php if($results[0]->status == '0') { ?> selected='selected' <?php } ?>>Inactive</option>
  </select>

  </td>
  </tr>
  <tr>
  <td>&nbsp;</td>
  <td><input type="submit" name="submit" id="submit" <?php if($_GET['q_id']) { ?> value="Update" <?php } else { ?> value="Add" <?php } ?> ></td>
  </tr>
  </table>
  <div style="padding-top: 20px;padding-left:10px;"><a href='javascript:history.back(1);'>Back</a></div>
  </form>
  </div>

<?php

}
}
/*------------------------end of question type-------------------*/

/*------------------------Add question -------------------*/

add_menu_page('Questionarie', 'Questionarie', $capability, 'Questionarie', 'render_question', 'dashicons-admin-generic', '120');
	add_submenu_page( 'Questionarie', 'Question', 'Question', $capability, 'render_question', 'render_question');
		add_submenu_page( 'question', ' ', ' ', $capability, 'edit_question', 'edit_question');

	add_submenu_page( 'Questionarie', 'Question Type', 'Question Type', $capability, 'render_question_type', 'render_question_type');
		add_submenu_page( 'question_type', ' ', ' ', $capability, 'edit_question_type', 'edit_question_type');



// add_menu_page('Question', 'Question', $capability, 'Question', 'render_question');
// add_submenu_page( 'question', ' ', ' ', $capability, 'edit_question', 'edit_question');

function render_question()
{

	global $title;
    ?>
        <h2><?php echo $title;?></h2>

        <?php
        if(isset($_GET['error_type']) && $_GET['error_type'] == '2'){ ?>

        <div>Two Answers for True False OR Yes No type are already present in database</div>

        <?php } elseif (isset($_GET['error_type']) && $_GET['error_type'] == '1') {
          ?>
        	 <div> Answers already present in database</div>
       <?php
        }

         ?>

        <h3><a href="<?php echo home_url(); ?>/wp-admin/admin.php?page=edit_question">Add Question</a></h3>

        <script language="JavaScript" type="text/javascript">
			jQuery(document).ready(function(){
			    jQuery("a.delete").click(function(e){
			        if(!confirm('Are you sure to delete the question?')){
			            e.preventDefault();
			            return false;
			        }
			        return true;
			    });
			});
      </script>

        
        <?php
        global $wpdb;
        $results=$wpdb->get_results("select * from cp_questions as q LEFT JOIN cp_question_type as qt ON q.qtype_id=qt.id");
        ?>
        <table border="1" width="100%" style="border-collapse: collapse;">
        <tr>
        <th>Id</th>
        <th>Question Type</th>
        <th>Question Description</th>
        <th>Action</th>
        </tr>
        <?php
        $i=1;
        foreach($results as $result){
        ?>
        <tr>
        <td><?php echo $i; ?></td>
        <td><?php echo $result->qtype; ?></td>
        <td><?php echo $result->question; ?></td>
        <td><a href="<?php echo home_url(); ?>/wp-admin/admin.php?page=edit_question&q_id=<?php echo $result->qid;?>">Edit</a>&nbsp; | &nbsp;<a class="delete" href="<?php echo home_url(); ?>/wp-admin/admin.php?page=edit_question&action=delete&q_id=<?php echo $result->qid;?>">Delete</a>&nbsp; | &nbsp;<a href="<?php echo home_url(); ?>/wp-admin/admin.php?page=edit_question&action=answer&q_id=<?php echo $result->qid;?>&type_id=<?php echo $result->qtype_id;?>"> Add Answers </a> &nbsp; | &nbsp;<a href="<?php echo home_url(); ?>/wp-admin/admin.php?page=edit_question&action=Viewanswer&q_id=<?php echo $result->qid;?>">View Answers</a></td>
        </tr>
        <?php
        $i++;
         }
         ?>
         </table>



<?php        	
}

function edit_question()
{


global $wpdb;
$resultsqt=$wpdb->get_results("select * from cp_question_type");

if($_GET['q_id']!='' && $_GET['action']=='delete')
      {
      	$wpdb->delete( 'cp_questions', array( 'qid' => $_GET['q_id'] ), array( '%d' ) );

      	$wpdb->delete( 'cp_question_answers', array( 'ques_id' => $_GET['q_id'] ), array( '%d' ) );
    	header('Location:/wp-admin/admin.php?page=render_question');
      }

 if($_GET['ansid']!='' && $_GET['action']=='delete')
      {

         $wpdb->delete( 'cp_question_answers', array( 'id' => $_GET['ansid'] ), array( '%d' ) ); 
        header('Location:/wp-admin/admin.php?page=render_question');
      }

if($_GET['q_id']!='' && $_GET['action']=='Viewanswer')
      {
      	 
         $get_que_ans = $wpdb->get_results("select * from cp_question_answers as qans LEFT JOIN cp_questions as q ON
             qans.ques_id = q.qid           
             where ques_id=".$_GET['q_id']);
         

          $i=1;

       ?> 
           <h2 style="margin-top: 30px;">Edit Answers for specific question.</h2>

          <script language="JavaScript" type="text/javascript">
			jQuery(document).ready(function(){
			    jQuery("a.delete").click(function(e){
			        if(!confirm('Are you sure to delete the answer?')){
			            e.preventDefault();
			            return false;
			        }
			        return true;
			    });
			});
      </script>


           <table border="1" width="100%" style="border-collapse: collapse;">
	        <tr>
	        <th>Id</th>
	        <!--<th>Question Type</th>-->
	        <th>Question Description</th>
	        <th>Answer</th>
	        <th>Action</th>
	        </tr>

     <?php

         foreach($get_que_ans as $result){
         ?>
         <tr>
         <td><?php echo $i; ?></td>
         <td><?php echo $result->question;?></td>
         <td><?php echo $result->ques_answer;?></td>
         <td><a href="<?php echo home_url(); ?>/wp-admin/admin.php?page=edit_question&action=editans&ansid=<?php echo $result->id;?>&qtype_id=<?php echo $result->qtype_id;?>">Edit</a>&nbsp; | &nbsp;<a class="delete"  href="<?php echo home_url(); ?>/wp-admin/admin.php?page=edit_question&action=delete&ansid=<?php echo $result->id;?>">Delete</a></td>
         </tr>
         <?php
         $i++;
         }
         ?>
         </table>
         <div style="padding-top: 20px;padding-left:10px;"><a href='javascript:history.back(1);'>Back</a></div>
         <?php



      }

      
      if($_GET['ansid']!='' && $_GET['action']=='editans')
      {
          $getqustion = $wpdb->get_results("select * from cp_question_answers as qans LEFT JOIN cp_questions as q ON
               qans.ques_id = q.qid           
              where id=".$_GET['ansid']);
          // print_r($getqustion);

          if(isset($_POST['submiteditanswer']))
          {

          	$ques_answer= $_POST['ques_answer'];
          	$is_default = $_POST['is_default'];

          	//print_r($_POST);
          	//echo "===".$is_default;
          	//die();

          	$wpdb->update( 
			'cp_question_answers', 
			array( 
				'ques_answer' => $ques_answer,
				'is_default'  => $is_default
				
				
			), 
			array( 'id' => $_GET['ansid'] ), 
			array( 
				'%s'  
				
			) 
        );

          	header('Location:/wp-admin/admin.php?page=render_question');

          }

      	?>

      	  <form name="editanswer" method="post" action="">
         
           <div style="padding-top: 20px;"><b>Question Desc : </b><?php echo $getqustion[0]->question; ?></div>

           <?php
         
          if($_GET['qtype_id']=='1') {
          	?>
         
         <div style="padding-top: 20px;">
	         <textarea rows="5" cols="60" name="ques_answer" id="ques_answer"><?php echo $getqustion[0]->ques_answer; ?> </textarea>
         </div>
         <?php } else if($_GET['qtype_id']=='2' || $_GET['qtype_id']=='4') { ?>
         
             <div style="padding-top: 20px;">
	         <input name="ques_answer" value="True" type="radio" <?php if($getqustion[0]->ques_answer == 'True') { ?> checked <?php } ?>>True
	         <input name="ques_answer" value="false" <?php if($getqustion[0]->ques_answer == 'false') { ?> checked <?php } ?> type="radio">False
         </div>

             <div style="padding-top: 20px;">
          <input name="is_default" value="1" <?php if($getqustion[0]->is_default == 1) { ?> checked <?php } ?> type="checkbox">Is Default Answer </div>

         <?php }
         
          else if ($_GET['qtype_id']=='3') {
          	?>
          	<div style="padding-top: 20px;">
            <textarea rows="5" cols="60" name="ques_answer" id="ques_answer"><?php echo $getqustion[0]->ques_answer; ?> </textarea>
            </div>
          <?php 	 
          }
          
          ?>


         <div style="padding-top: 20px;">
          <input type="submit" name="submiteditanswer" value="Edit Answer" ></div>
         
         </form>

         <div style="padding-top: 20px;padding-left:10px;"><a href='javascript:history.back(1);'>Back</a></div>


     <?php 	 
      }
     


	if($_GET['q_id']!='' && $_GET['action']=='answer')
	  {

	  	$getquestion_data = $wpdb->get_results("select *,qt.id as type from cp_questions as q LEFT JOIN cp_question_type as qt ON q.qtype_id=qt.id where qid='".$_GET['q_id']."'");
          
       // print_r($getquestion_data);

        if(isset($_POST['submitanswer']))
        {
        	global $wpdb;
            $is_default = $_POST['is_default'];
            $ques_answer = $_POST['ques_answer'];
            $question_id = $_GET['q_id'];

            $check_enrty =  $wpdb->get_results("select * from cp_question_answers where ques_id='".$_GET['q_id']."'");

             if($_GET['type_id'] == '2' || $_GET['type_id'] == '4'){

                       

             if($wpdb->num_rows == '2')
             {
             	$error_type2='2';
              ?>
              
            <?php
             }
             else
             {


				            $wpdb->insert( 
							'cp_question_answers', 
							array( 
								'ques_answer' => $ques_answer,
								'ques_id'=> $question_id,
								'is_default' => $is_default

							), 
							array( 
								'%s',
				                '%d',
				                '%s'

								 
							) 
						   );
             }

            }
            else if($_GET['type_id'] == '1')
              {

                   
                if($wpdb->num_rows == '1')
                  {
                  	 
                  	$error_type2='1';
              ?>
              
                <?php
		             }
		             else
		             {

                         $wpdb->insert( 
							'cp_question_answers', 
							array( 
								'ques_answer' => $ques_answer,
								'ques_id'=> $question_id,
								'is_default' => $is_default

							), 
							array( 
								'%s',
				                '%d',
				                '%s'

								 
							) 
						   );

                       }
         

                }
                else if($_GET['type_id'] == '3')
                {
                        $wpdb->insert( 
							'cp_question_answers', 
							array( 
								'ques_answer' => $ques_answer,
								'ques_id'=> $question_id 

							), 
							array( 
								'%s',
				                '%d' 

								 
							) 
						   );

                }
    
  
        header('Location:/wp-admin/admin.php?page=render_question&error_type='.$error_type2);

        }

	  	
       ?>
        <h2>Add Answers for specific question.</h2>
        <div><b>Question Type : </b><?php echo $getquestion_data[0]->qtype; ?></div>
        <div style="padding-top: 20px;"><b>Question Desc : </b><?php echo $getquestion_data[0]->question; ?></div>
 
        <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.18.0/jquery.validate.js'></script>
		  <script type="text/javascript">
		  	jQuery(document).ready(function () {
		      jQuery('#addnanswer').validate({ // initialize the plugin
		   errorElement: "div",
		        rules: {
		            ques_answer:{
		                  required: true
					       } 
				  },

				messages:{

					 ques_answer:{
		                  required:"Please enter the answer"
					  }
		        }
		    });

		});
		</script>



        <form name="addnanswer" id="addnanswer" method="post" action="">

         <?php
         if($getquestion_data[0]->type == '1' )
         {
         ?>
         <div style="padding-top: 20px;">
	         <textarea rows="5" cols="60" name="ques_answer" id="ques_answer"></textarea>
         </div>
         <?php
          }
         
         else if($getquestion_data[0]->type == '2' )
         {

         ?>
         <div style="padding-top: 20px;">
	         <input name="ques_answer" value="True" type="radio">True
	         <input name="ques_answer" value="false" type="radio">False
         </div>
         <?php	 
         }
         else if($getquestion_data[0]->type=='4')
         {
          ?>
           <div style="padding-top: 20px;">
		         <input name="ques_answer" value="True" type="radio">Yes
		         <input name="ques_answer" value="false" type="radio">No
         </div>
          <?php
         }
         
         else if($getquestion_data[0]->type=='3')
         {
          ?>
            <div style="padding-top: 20px;">
            <textarea rows="5" cols="60" name="ques_answer" id="ques_answer"></textarea>
            </div>

          <?php
           }
          if($getquestion_data[0]->type =='2' || $getquestion_data[0]->type =='4')
          {
         ?>
         <div style="padding-top: 20px;">
          <input name="is_default" value="1" type="checkbox">Is Default Answer </div>
         <?php } ?>

         <div style="padding-top: 20px;">
          <input type="submit" name="submitanswer" value="Add Answer" ></div>

         </form> 

         <div style="padding-top: 20px;padding-left:10px;"><a href='javascript:history.back(1);'>Back</a></div>

      <?php

	  }

  if(isset($_POST['submit']))
  {

    $qtype_id = $_POST['qtype_id'];
    $question  = $_POST['question'];

     if($_GET['q_id']!='')

     {

      $wpdb->update( 
			'cp_questions', 
			array( 
				'question' => $question,
				'qtype_id'=> $qtype_id	// string
				
			), 
			array( 'qid' => $_GET['q_id'] ), 
			array( 
				'%s',
				'%d'	// value1
				
			) 
        );

     	

  	}
  	else
  	{
  		//echo $qtype;
  		//exit;
         $wpdb->insert( 
			'cp_questions', 
			array( 
				'question' => $question,
				'qtype_id'=> $qtype_id

			), 
			array( 
				'%s',
                '%d'

				 
			) 
		);

  	}

  	header('Location:/wp-admin/admin.php?page=render_question');

  }

$resultsedit=$wpdb->get_results("select * from cp_questions where qid='".$_GET['q_id']."'");

   if($_GET['action']!='delete'&& $_GET['action']!='answer' && $_GET['action']!='Viewanswer' && $_GET['action']!='editans' )
   {


  ?>



<div style="padding-top: 30px;">

  <?php if($_GET['q_id']) { ?> <h2>Edit Question </h2> <?php } else { ?> <h2>Add Question </h2> <?php } ?>

  <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.18.0/jquery.validate.js'></script>
  <script type="text/javascript">
  	jQuery(document).ready(function () {
      jQuery('#frmeditqtype').validate({ // initialize the plugin
   errorElement: "div",
        rules: {
            qtype_id:{
                  required: true
			       },
			question: {
                  required: true
			       }
		  },

		messages:{

			 qtype_id:{
                  required:"Please select question type"
			  },
			 question:{
                  required:"Please enter the question"
			  } 


        }
    });

});
</script>


  <form name="frmeditqtype" id="frmeditqtype" method="post" action="">
  <table border="1" width="50%">
  <tr>
  <td>Question Type</td>
  <td>
  <select name="qtype_id" id="qtype_id">
  <option value="">Select Question Type</option>
  <?php
  foreach ($resultsqt as $resultqt) {
  	?>
   <option value="<?php echo $resultqt->id; ?>" <?php if($resultqt->id == $resultsedit[0]->qtype_id) { ?> selected='selected' <?php } ?>><?php echo $resultqt->qtype; ?></option>
  <?php
  }
  ?>
  </select>
  </td>
  <tr>
  <td>Question</td>
  <td><textarea rows="5" cols="60" name="question" id="question"><?php echo $resultsedit[0]->question; ?></textarea></td>
  </tr>
  <tr>
  <td>&nbsp;</td>
  <td><input type="submit" name="submit" id="submit" <?php if($_GET['q_id']) { ?> value="Update" <?php } else { ?> value="Add" <?php } ?> ></td>
  </tr>
  </table>
  </form>
  </div>
  <div style="padding-top: 20px;padding-left:10px;"><a href='javascript:history.back(1);'>Back</a></div> 
  <?php
}
}


//create a shortcode for trainer search

add_shortcode('gmgt_custom_search', 'gmgt_custom_search_trainer');

function gmgt_custom_search_trainer(){
 ?>
 <script type="text/javascript">
var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";
jQuery(document).ready(function(){
jQuery('#trainer_type').on('change',function(){ 
		var trainer_type = jQuery(this).val();
		//alert(trainer_type);
		jQuery.ajax({ 
				 type:'POST', 
				 url:ajaxurl,
				 data:'trainer_type='+trainer_type+"&action=get_search_option",
				 success:function(html){ 
					 //alert(html);
					 jQuery('#main_search_option').html(html); 
					
				 }
				}); 
	});

jQuery(document).on('click', '#search_trainer', function(){

	//alert("hi");
	var speciality=jQuery("#speciality").val();
    var timeslot = jQuery("#timeslot" ).val();
    var ttype = jQuery("#trainer_type" ).val();
    var address = jQuery("#member_adderess" ).val();
    var time_zone = jQuery("#time_zone" ).val();

    var data = {
            action: 'trainerlist',
            speciality: speciality,
            timeslot:timeslot,
            ttype:ttype,
            address:address,
            time_zone:time_zone
            
        };
    jQuery.ajax({ 
				  type:'POST', 
				  url:ajaxurl,
				  data,
				 success:function(data){ 
					 //alert(html);
					 jQuery('#trainer_list').html(data); 
					
				 }
				}); 


});

jQuery(document).on('click', '#assigntrainer', function(){

var chktrainer = jQuery("#chktrainer").val();

 var val = [];
        $(':checkbox:checked').each(function(i){
          val[i] = $(this).val();
        });

// alert(val);

        var data = {
            action: 'assign_tran_to_member',
            val: val
            
        };
    jQuery.ajax({ 
				  type:'POST', 
				  url:ajaxurl,
				  data,
				 success:function(data){ 
					 //alert(html);
					 jQuery('#succmsg').html(data); 
					
				 }
				}); 


}); 

  
});
</script>
 <table border="1" style="border-collapse: collapse; width: 50%">
		 <tr>
		 <td>Trainer Type</td>
		 <td>
		 	<select name="trainer_type" id="trainer_type" class="wgtmsr">
				<option value="">Select Trainer Type</option>
				<option value="personal">Personal Trainer</option>
				<option value="remote">Remote Trainer</option>
			</select>
		 </td>	
		 </tr>
		</table>
		 <div id="main_search_option"></div> 
		  <div id="trainer_list"></div>  
         
 <?php
}

function fn_get_search_option()
{
    // print_r($_POST);

    global $wpdb;
    $speciality_data=$wpdb->get_results("SELECT * FROM cp_usermeta WHERE meta_key='Training_specialties'");
    $timezone_data=$wpdb->get_results("SELECT * FROM cp_usermeta WHERE meta_key='time_zone'");
    //print_r($speciality_data);

 ?>


  <table border="1" style="border-collapse: collapse;width: 50%">
  	<?php if($_POST['trainer_type']=='personal'){ ?>
  	<tr>
  	<td>Speciality</td>
  	<td>
  	<select name="speciality" id="speciality">
    <option value="">---select speciality---</option>
    <?php
    foreach($speciality_data as $result){													
			?>
	<option value="<?php echo $result->meta_value;?>"><?php echo $result->meta_value;?></option>
	<?php
		}    
		?>
  	
    </select>	
  	</td>
  	</tr>
  <?php } ?>
  	<tr>
  	<td>Time Slot</td>
  	<td><select name="timeslot" id="timeslot" class="wgtmsr">
	<option value="">Select Time Slots</option>
	 <option value="HST">HST (Hawaii Standard Time)</option>
	 <option value="AKST">AKST (Alaska Standard Time)</option>
	 <option value="PST">PST (Pacific Standard Time)</option>
	 <option value="MST">MST (Mountain Standard Time)</option>
	 <option value="CST">CST (Central Standard Time)</option>
	 <option value="EST">EST (Eastern Standard Time)</option>
	<!-- <option value="1">5 am to 6 am</option>
	<option value="2">6 am to 7 am</option>
	<option value="3">7 am to 8 am</option>
	<option value="4">8 am to 9 am</option> -->
    </select>
    </td>
    </tr>
    <?php if($_POST['trainer_type']=='remote'){ ?>
    <tr>
    <td>Time Zone</td>
    <td>
    <select name="time_zone" id="time_zone">
    	<option value="">---Select Timezone---</option>
    	<?php
    foreach($timezone_data as $result){													
			?>
	<option value="<?php echo $result->meta_value;?>"><?php echo $result->meta_value;?></option>
	<?php
		}    
		?>
    </select>	
    </td>
    </tr>
    <?php } ?>
    <?php if($_POST['trainer_type']=='personal'){ ?>
    <tr>
    <td>Address</td>
    <td><input type="text" id="member_adderess" name="member_adderess"></td>
    </tr>
    <?php } ?>
    <tr>
    <td>&nbsp;</td>
    <td><input type="button" name="search_trainer" id="search_trainer" value="Search Trainer"></td>
    </tr>
  </table>

   

<?php

 
    exit;
}

add_action('wp_ajax_get_search_option', 'fn_get_search_option');
add_action('wp_ajax_nopriv_get_search_option', 'fn_get_search_option');


function fn_get_trainer_list()
{
   //print_r($_POST);
   $speciality = $_POST['speciality'];
   $timeslot = $_POST['timeslot'];
   $ttype = $_POST['ttype'];
   $address = $_POST['address'];
   $time_zone = $_POST['time_zone'];
   global $wpdb;

   if($speciality!="" AND $timeslot!="")
   {
       //echo"both";

    $args = array( 'meta_query' => array( 'relation' => 'AND', array( 'key' => 'time_slot', 'value' => $timeslot, 'compare' => '=' ), array( 'key' => 'trainer_type', 'value' => $ttype, 'compare' => '=' ), array( 'key' => 'Training_specialties', 'value' => $speciality, 'compare' => '=' ),array( 'key' => 'trainer_status', 'value' => '1', 'compare' => '=' )) ); 

   }

   else if($ttype!="" AND $time_zone!="")
   {
     $args = array( 'meta_query' => array( 'relation' => 'AND', array( 'key' => 'trainer_type', 'value' => $ttype, 'compare' => '=' ), array( 'key' => 'time_zone', 'value' => $time_zone, 'compare' => '=' ) ,array( 'key' => 'trainer_status', 'value' => '1', 'compare' => '=' )) ); 

   }

   elseif($ttype!="" AND $address!=""){
     $address = $_POST['address'];

    // echo $address;
   
  // 	$address = "80 Lynch Street, Hawthorn VIC, Australia";
   	//$address ="SNo173 Hinjawadi Rajiv Gandhi Infotech Park Hinjawadi Blue Ridge,pune";
    $siteKey = 'AIzaSyB55KEoT15-q2rte2P67iL4wC05RTSuyUA';
    $returnValue = array();
    $resultData = array();
    $green = 0;
    $red = 0;
    $orange = 0;
         
  if (isset($address) && (!empty($address)))
    {
     $address = preg_replace('/\s+/', '+', $address);
     $url = "https://maps.googleapis.com/maps/api/geocode/json?address=" . $address . "&key=" . $siteKey . "";
        // Get cURL resource
        $curl = curl_init();
        // Set some options - we are passing in a useragent too here
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => $url,
            CURLOPT_USERAGENT => ''
        ));
        // Send the request & save response to $resp
        $server_output = curl_exec($curl);
        $http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        if ($http_status == 200) {
            $output = json_decode($server_output, true);
            //print_r($output);
             if (isset($output) && (!empty($output))) {
                $formatted_address = $output['results'][0]['formatted_address'];
                $latitude = $output['results'][0]['geometry']['location']['lat'];
                $longitude = $output['results'][0]['geometry']['location']['lng'];

              //  echo $latitude; echo "<br/>";
              //  echo $longitude;
              
                 if (isset($latitude) && (!empty($latitude)) && ($longitude) && ($longitude)) {

                 	$totalRecords = 0;
                    $result = array();

                     global $wpdb;
                


                    // $p = "SELECT user_id,latitude,longitude, ( 3959 * acos( cos( radians(" . $latitude . ") ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians(" . $longitude . ") ) + sin( radians(" . $latitude . ") ) * sin( radians( latitude ) ) ) ) AS mile_distance FROM cp_user_location";
                    

                   // $presu = $wpdb->get_results($p);
                   // print_r($presu);


                    $q = "SELECT display_name,user_email, user_id,latitude,longitude,u.ID, ( 3959 * acos( cos( radians(" . $latitude . ") ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians(" . $longitude . ") ) + sin( radians(" . $latitude . ") ) * sin( radians( latitude ) ) ) ) AS mile_distance FROM cp_user_location as ul LEFT JOIN cp_users AS u ON ul.user_id=u.ID HAVING mile_distance < 40.2336 ORDER BY mile_distance";
                    

	                    $users = $wpdb->get_results($q);
	                   // print_r($users);


                 }


             }
         }
    }


     

}

  

   elseif($speciality!="")
   {
       //echo "speciality";

       $args = array( 'meta_query' => array( 'relation' => 'AND', array( 'key' => 'Training_specialties', 'value' => $speciality, 'compare' => '=' ), array( 'key' => 'trainer_type', 'value' => $ttype, 'compare' => '=' ),array( 'key' => 'trainer_status', 'value' => '1', 'compare' => '=' ) ) ); 

   }
   elseif($timeslot!="")
   {
   	 //echo "timeslot";

     $args = array( 'meta_query' => array( 'relation' => 'AND', array( 'key' => 'time_slot', 'value' => $timeslot, 'compare' => '=' ), array( 'key' => 'trainer_type', 'value' => $ttype, 'compare' => '=' ),array( 'key' => 'trainer_status', 'value' => '1', 'compare' => '=' ) ) ); 

   }

   elseif($ttype!="")
   {

     $args = array( 'meta_query' => array( 'relation' => 'AND', array( 'key' => 'trainer_type', 'value' => $ttype, 'compare' => '=' ),array( 'key' => 'trainer_status', 'value' => '1', 'compare' => '=' ) ) ); 


   	 //echo "trainer type";

     /*$args = array( 'meta_key' => 'trainer_type', 'meta_value' => $ttype , 'fields' => 'all' );*/

   }
   elseif($adress!="")
   {
      echo $address;

   }

   

   	$user_query = new WP_User_Query($args);

   	 

    if($ttype!="" AND $address!="")
   	 {
   	 	
   	 	$users = $wpdb->get_results($q);
   	 	 
   	 }
     else
     {
     $users = $user_query->get_results(); 
    }



 ?>

 <table border="1" style="border-collapse: collapse;width: 50%">
 <tr>
 <th></th>
 <th>Id</th>
 <th>Trainer Name</th>
 <th>Email</th>
 </tr>
 <?php 
if($users)
{
 $cnt=1; foreach ($users as $user){  ?>
 <tr>
 <td><input type="checkbox" name="chktrainer[]" id="chktrainer" value="<?php echo $user->ID; ?>"></td>
 <td><?php echo $cnt++; ?></td>
 <td><?php echo $user->user_login; ?></td>
 <td><?php echo $user->user_email; ?></td>
 
 </tr>
 <?php }}else{ ?>
 <tr><td>No Trainer data found...</td></tr>
 <?php } ?>
 </table>

 <input type="button" name="assigntrainer" id="assigntrainer" value="Assign Trainer" style="margin-top: 30px;">

 <div id="succmsg"></div>

<?php
   exit;

}


add_action('wp_ajax_trainerlist', 'fn_get_trainer_list');
add_action('wp_ajax_nopriv_trainerlist', 'fn_get_trainer_list');


function fn_assign_tran_to_member()
{
  
  $trainer_id = implode(",",$_POST['val']);
  $user_id =get_current_user_id();
  update_user_meta($user_id, 'staff_id', $trainer_id);
  echo "Trainer Assign successfully";
  exit;

}

add_action('wp_ajax_assign_tran_to_member', 'fn_assign_tran_to_member');
add_action('wp_ajax_nopriv_assign_tran_to_member', 'fn_assign_tran_to_member');


//fitness level add here

add_menu_page('Fitness Level', 'Fitness Level', $capability, 'Fitness_Level', 'render_fitness_level','','121');
add_submenu_page( 'Fitness Level', ' ', ' ', $capability, 'edit_fitness_level', 'edit_fitness_level');

function render_fitness_level()
{
 	global $title;
    ?>
        <h2><?php echo $title;?></h2>

        

        <h3><a href="<?php echo home_url(); ?>/wp-admin/admin.php?page=edit_fitness_level">Add Fitness Level</a></h3>

        <script language="JavaScript" type="text/javascript">
			jQuery(document).ready(function(){
			    jQuery("a.delete").click(function(e){
			        if(!confirm('Are you sure to delete the fitness level?')){
			            e.preventDefault();
			            return false;
			        }
			        return true;
			    });
			});
      </script>

        
        <?php
        global $wpdb;
        $results=$wpdb->get_results("select * from cp_fitness_level");
        //print_r($results);
        ?>
        <table border="1" width="100%" style="border-collapse: collapse;">
        <tr>
        <th>Id</th>
        <th>Fitness Level</th>
        <th>Action</th>
        </tr>
        <?php
        $i=1;
        foreach($results as $result){
        ?>
        <tr>
        <td><?php echo $i; ?></td>
        <td><?php echo $result->fitness_level_name; ?></td>
        <td><a href="<?php echo home_url(); ?>/wp-admin/admin.php?page=edit_fitness_level&fid=<?php echo $result->id;?>">Edit</a>&nbsp; | &nbsp;<a class="delete" href="<?php echo home_url(); ?>/wp-admin/admin.php?page=edit_fitness_level&action=delete&fid=<?php echo $result->id;?>">Delete</a></td>
        </tr>
        <?php
        $i++;
         }
         ?>
         </table>
<?php
}
?>
<?php
function edit_fitness_level()
{
	 if($_GET['fid']!="")
    {
    	global $wpdb;
		$result_fitness=$wpdb->get_results("select * from cp_fitness_level where id='".$_GET['fid']."'");
		 
    }

    if($_GET['fid']!='' && $_GET['action']=='delete')
      {
      	global $wpdb;
      	$wpdb->delete( 'cp_fitness_level', array( 'id' => $_GET['fid'] ), array( '%d' ) );
       	header('Location:/wp-admin/admin.php?page=Fitness_Level');
      }

	if(isset($_POST['submit']))
    {

    $fitness_level_name = $_POST['fitness_level_name'];
    if($_GET['fid']!='')

     {
       global $wpdb;
     	echo "update";

      $wpdb->update( 
			'cp_fitness_level', 
			array( 
				'fitness_level_name' => $fitness_level_name
				
				
			), 
			array( 'id' => $_GET['fid'] ), 
			array( 
				'%s'
				
			) 
        );
 
     header('Location:/wp-admin/admin.php?page=Fitness_Level');
     	

  	}
  	else
  	{
  	    global $wpdb;
  		$wpdb->insert( 
			'cp_fitness_level', 
			array( 
				'fitness_level_name' => $fitness_level_name


			), 
			array( 
				'%s'
                				 
			) 
		);
   
     header('Location:/wp-admin/admin.php?page=Fitness_Level');

  	}
}

?>
 <div style="padding-top: 30px;">

  <?php if($_GET['fid']) { ?> <h2>Edit Fitness level </h2><?php } else { ?> <h2>Add Fitness level</h2> <?php } ?>

 <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.18.0/jquery.validate.js'></script>
  <script type="text/javascript">
  	jQuery(document).ready(function () {
      jQuery('#frmfitnesslevel').validate({ // initialize the plugin
   errorElement: "div",
        rules: {
            fitness_level_name:{
                  required: true
			       } 
		  },

		messages:{

			 fitness_level_name:{
                  required:"Please enter fitness level"
			  } 


        }
    });

});
</script>


 <form name="frmfitnesslevel" id="frmfitnesslevel" method="post" action="" >
  <table border="1" width="50%">
  <tr>
  <td>Fitness Level Name</td>
  <td>
   <input type="text" name="fitness_level_name" id="fitness_level_name" value="<?php echo $result_fitness[0]->fitness_level_name; ?>">
  </td>
  </tr>
  <tr>
  <td>&nbsp;</td>
  <td><input type="submit" name="submit" id="submit" <?php if($_GET['fid']) { ?> value="Update" <?php } else { ?> value="Add" <?php } ?> ></td>
  </tr>
  </table>
  </form>
  </div>
  <div style="padding-top: 20px;padding-left:10px;"><a href='javascript:history.back(1);'>Back</a></div> 
  <?php
}


//user questionnarie data view start

add_menu_page('User Questionarie Data', 'User Questionarie Data', $capability, 'user_questionarie_data', 'render_user_questionarie_data','','121');
add_submenu_page( 'User Questionarie Data', ' ', ' ', $capability, 'view_data', 'view_data');

function render_user_questionarie_data()
{
   global $title;
    ?>
        <h2><?php echo $title;?></h2>
        <?php
        global $wpdb;
        $results=$wpdb->get_results("SELECT * FROM `cp_ques_user_ans`, cp_users where cp_ques_user_ans.user_id = cp_users.ID GROUP BY user_id");
        //echo"<pre>";
        //print_r($results);
        ?>
        <table border="1" width="100%" style="border-collapse: collapse;">
        <tr>
        <th>Id</th>
        <th>Username</th>
        <th>Action</th>
        </tr>
        <?php
        $i=1;
        foreach($results as $result){
        ?>
        <tr>
        <td><?php echo $i; ?></td>
        <td><?php echo $result->user_login; ?></td>
        <td><a href="<?php echo home_url(); ?>/wp-admin/admin.php?page=view_data&uid=<?php echo $result->user_id;?>">View</a></td>
        </tr>
        <?php
        $i++;
         }
         ?>
         </table>

<?php
}

function view_data()
{
  
global $wpdb;

$get_username=$wpdb->get_results("select * from cp_users where ID='".$_GET['uid']."'");
//echo"===".$get_username[0]->user_login;

$get_height=$wpdb->get_results("select * from cp_ques_user_ans where ques_id='16' AND user_id='".$_GET['uid']."'");
$get_weight=$wpdb->get_results("select * from cp_ques_user_ans where ques_id='17' AND user_id='".$_GET['uid']."'");
$get_heart_rate=$wpdb->get_results("select * from cp_ques_user_ans where ques_id='18' AND user_id='".$_GET['uid']."'");
$get_bp=$wpdb->get_results("select * from cp_ques_user_ans where ques_id='19' AND user_id='".$_GET['uid']."'");
        echo"<pre>";
$get_workout=$wpdb->get_results("select * from cp_ques_user_ans where ques_id='20' AND user_id='".$_GET['uid']."'");
 $get_last_workout=$wpdb->get_results("select * from cp_ques_user_ans where ques_id='21' AND user_id='".$_GET['uid']."'");    

 $get_personal_trainer_work = $wpdb->get_results("select * from cp_ques_user_ans where ques_id='22' AND user_id='".$_GET['uid']."'");   

 $get_personal_trainer_work_past = $wpdb->get_results("select * from cp_ques_user_ans where ques_id='24' AND user_id='".$_GET['uid']."'"); 
 $get_injury = $wpdb->get_results("select * from cp_ques_user_ans where ques_id='26' AND user_id='".$_GET['uid']."'");   
$get_injury_mechanism=$wpdb->get_results("select * from cp_ques_user_ans where ques_id='31' AND user_id='".$_GET['uid']."'");  

$get_injury_date = $wpdb->get_results("select * from cp_ques_user_ans where ques_id='27' AND user_id='".$_GET['uid']."'");
$get_injury_limitation = $wpdb->get_results("select * from cp_ques_user_ans where ques_id='34' AND user_id='".$_GET['uid']."'"); 

$get_prev_injury = $wpdb->get_results("select * from cp_ques_user_ans where ques_id='29' AND user_id='".$_GET['uid']."'"); 
$get_injury_pain_level = $wpdb->get_results("select * from cp_ques_user_ans where ques_id='30' AND user_id='".$_GET['uid']."'");
$get_health_question = $wpdb->get_results("select * from cp_ques_user_ans where ques_id='32' AND user_id='".$_GET['uid']."'");

$get_expalin_limitation = $wpdb->get_results("select * from cp_ques_user_ans where ques_id='28' AND user_id='".$_GET['uid']."'");

$get_explain_prev_injury = $wpdb->get_results("select * from cp_ques_user_ans where ques_id='35' AND user_id='".$_GET['uid']."'");

 $get_personal_trainer_work_explo=explode(",",$get_personal_trainer_work[0]->ques_ans);

 $get_personal_trainer_work_explo_past=explode(",",$get_personal_trainer_work_past[0]->ques_ans);

 
 $get_personal_trainer_yes_no = explode("=",$get_personal_trainer_work_explo[0]);

 $get_personal_trainer_yes_no_past = explode("=",$get_personal_trainer_work_explo_past[0]);


  $height = $get_height[0]->ques_ans;
  $weight = $get_weight[0]->ques_ans;
  $heart_rate = $get_heart_rate[0]->ques_ans;
  $bp = $get_bp[0]->ques_ans;
  $workout = $get_workout[0]->ques_ans;
  $last_workout = $get_last_workout[0]->ques_ans;
  $injury = $get_injury[0]->ques_ans;
  $mechanism = $get_injury_mechanism[0]->ques_ans;
  $date_injury = $get_injury_date[0]->ques_ans;
  $limition_injury = $get_injury_limitation[0]->ques_ans;
  $prev_injury = $get_prev_injury[0]->ques_ans;
  $injury_pain_level = $get_injury_pain_level[0]->ques_ans;
  $health_question = $get_health_question[0]->ques_ans;
  $expalin_limitation = $get_expalin_limitation[0]->ques_ans;
  $expalin_prev_injury =$get_explain_prev_injury[0]->ques_ans;
?>
<h3><?php echo $get_username[0]->user_login; ?></h3>
<table border="1" width="100%" style="border-collapse: collapse;">
<tr>
<td>What is your height ?</td>
<td><?php echo $height; ?> </td>
</tr>
<tr>
<td>What is your weight ?</td>
<td><?php echo $weight; ?> </td>
</tr>
<tr>
<td>What is your resting heart rate ?</td>
<td><?php echo $heart_rate; ?> </td>
</tr>
<tr>
<td>What is your Blood pressure, if known ?</td>
<td><?php echo $bp; ?> </td>
</tr>
<tr>
<td>How often do you work out?</td>
<td><?php echo $workout; ?> </td>
</tr>
<tr>
<td>When did you last work out?</td>
<td><?php echo $last_workout; ?> </td>
</tr>
<tr>
<td>Do you work out with a personal trainer?
</td>
<td><?php echo $get_personal_trainer_yes_no[1]; ?> 
 <table>
 <tr><td><?php echo $get_personal_trainer_work_explo[1]; ?></td></tr>
 <tr><td><?php echo ucfirst($get_personal_trainer_work_explo[2]); ?></td></tr>
 <tr><td><?php echo ucfirst($get_personal_trainer_work_explo[3]); ?></td></tr>
 <tr><td><?php echo ucfirst($get_personal_trainer_work_explo[4]); ?></td></tr>
 <tr><td><?php echo ucfirst($get_personal_trainer_work_explo[5]); ?></td></tr>
 </table>
</td>
</tr>
<tr>
<td>Work with a personal trainer the past?
</td>
<td><?php echo $get_personal_trainer_yes_no_past[1]; ?> 
 <table>
 <tr><td><?php echo $get_personal_trainer_work_explo_past[1]; ?></td></tr>
 <tr><td><?php echo ucfirst($get_personal_trainer_work_explo_past[2]); ?></td></tr>
 <tr><td><?php echo ucfirst($get_personal_trainer_work_explo_past[3]); ?></td></tr>
 <tr><td><?php echo ucfirst($get_personal_trainer_work_explo_past[4]); ?></td></tr>
 <tr><td><?php echo ucfirst($get_personal_trainer_work_explo_past[5]); ?></td></tr>
 </table>
</td>
</tr>
<tr>
<td>Do you have any injuries?</td>
<td><?php echo $injury; ?> </td>
</tr>
<?php
if($injury=='Yes')
{
?>
<tr>
<td>What was the mechanism of the injury?</td>
<td><?php echo $mechanism; ?> </td>
</tr>
<tr>
<td>What was the approximate date of the injury?</td>
<td><?php echo $date_injury; ?> </td>
</tr>
<tr>
<td>Do you have any limitations due to the injury?</td>
<td><?php echo $limition_injury; ?> </td>
</tr>
<?php
if($limition_injury=='Yes')
{
?>
<tr>
<td>Please explain your limitation?</td>
<td><?php echo $expalin_limitation; ?> </td>
</tr>
<?php } ?>
<tr>
<td>Did you aggravate a previous injury?</td>
<td><?php echo $prev_injury; ?> </td>
</tr>
<?php
if($prev_injury=='Yes')
{
?>

<tr>
<td>Explain the previous injury?</td>
<td><?php echo $expalin_prev_injury; ?> </td>
</tr>
<?php } ?>
<tr>
<td>What is your pain level from the injury?</td>
<td><?php echo $injury_pain_level; ?> </td>
</tr>
<?php } else { ?>
<tr>
<td>Health Questions – Have you ever had any of the following?</td>
<td><?php echo $health_question; ?> </td>
</tr>

<?php } ?>
</table>

<?php
}


//end user questionnarie data view start
function fn_delete_file()
{
  $uid =$_POST['uid'];
  $file_name = $_POST['file_name'];
  $userdoc=get_user_meta($uid, 'documents', true);
 // echo $userdoc;
  $new_arra=array();
  $strarra = explode(",",$userdoc);
  for($i=0;$i<sizeof($strarra);$i++)
  {
  	if($strarra[$i]!=$file_name)
  	{
      array_push($new_arra,$strarra[$i]);
  	}
  }

 $finalstr = implode(",",$new_arra);
 // print_r($new_arra);

  //$updated_str = str_replace($file_name, '', $userdoc);
  update_user_meta( $uid, 'documents', $finalstr);

  $new_data =get_user_meta($uid, 'documents', true); 
  $userdocarr=explode(",", $new_data);
  ?>
  <div style="margin-top: 130px;margin-bottom: 30px;" id="show">
                                <table>
                                <tr>
                                <th>Uploaded Documents</th>
                                 <th></th>
                                </tr>
   
   <?php
  for($doc=0;$doc<sizeof($userdocarr); $doc++){

   $without_extension = pathinfo($userdocarr[$doc], PATHINFO_FILENAME);
   ?>
     

    <tr>
     <td  class="Certificates">
                                 
                                                         <a href="<?php echo $target_path. $userdocarr[$doc]; ?>" target="_blank"><!-- Certificate --><?php echo $without_extension; ?></a>&nbsp;&nbsp; <a href="javascript:removeFileuploaded('<?php echo $userdocarr[$doc]; ?>' ,'<?php echo $uid; ?>');"><i class="fa fa-remove"></i></a>
                                                          
                                                          

                                                         </td>
                                                           </tr>
                                                         <?php } ?>
                                                        </table>
                                                        </div>
                                                         <?php
  
  //echo "File Deleted successfully";
  exit;

}

add_action('wp_ajax_delete_file', 'fn_delete_file');
add_action('wp_ajax_nopriv_delete_file', 'fn_delete_file');


/* Start custom post type for email content from backend */

function create_email_post_type() {
  register_post_type( 'email',
    array(
      'labels' => array(
        'name' => __( 'Email' ),
        'singular_name' => __( 'Email' )
      ),
      'public' => true,
      'has_archive' => true,
    )
  );
}
add_action( 'init', 'create_email_post_type' );

/* End custom post type for email content from backend */

/*function custom_blockusers_init() {
  if ( is_user_logged_in() && is_admin() && !current_user_can( 'administrator' ) && (defined( 'DOING_AJAX' ) && !DOING_AJAX) ) ) {
    wp_redirect( home_url() );
    exit;
  }
}
add_action( 'init', 'custom_blockusers_init' ); // Hook into 'init'

*/


function my_login_redirect( $redirect_to, $request, $user ) {
    //is there a user to check?
    if (isset($user->roles) && is_array($user->roles)) {
         
         //check for memeber
        if (in_array('member', $user->roles)) {
            // redirect them to another URL, in this case, the homepage 
            $redirect_to =  home_url('/registration/');
        }
    }

    return $redirect_to;
}

add_filter( 'login_redirect', 'my_login_redirect', 10, 3 );




function fn_contact_form_smbt()
{
	//print_r($_POST);
    global $wpdb;

    $name = $_POST['cont_name'];
    $email = $_POST['cont_email'];
    $phone = $_POST['cont_phone'];
    $message = $_POST['message'];

   
  $wpdb->insert('cp_contact_us_data', 
							array( 
								'name' => $name,
								'email'=> $email,
								'phone' => $phone,
								'message' => $message

							), 
							array( 
								'%s',
				                '%s',
				                '%d',
				                '%s'

								 
							) 
						   ); 

$template_html_in_db = get_post_field('post_content',16156);
$placeholder =array("{{NAME}}","{{PHONE}}","{{EMAIL}}","{{MESSAGE}}");
$value = array($name,$phone,$email,$message);
 

$message_template = str_replace($placeholder, $value, $template_html_in_db );



/* fetching email content from custom post type mail  */
            
$headers[] = "MIME-Version: 1.0" . "\r\n";
$headers[] = "Content-type:text/html;charset=utf-8" . "\r\n"; 

$toemail='johnpaullay@gmail.com';

$mail_sent = wp_mail($toemail,'Contact us',$message_template,$headers);  

if($mail_sent)
{
    echo "Mail send successfully.";
}
else
{
	echo "Error in sending mail.";
}

	die();
}


add_action('wp_ajax_contact_form_smbt', 'fn_contact_form_smbt');
add_action('wp_ajax_nopriv_contact_form_smbt', 'fn_contact_form_smbt');

//Add payment mode

add_menu_page('Payment Details', 'Payment Details', $capability, 'payment_details', 'render_Payment_Details','','121');
add_submenu_page( 'Payment Details', ' ', ' ', $capability, 'edit_payment_details', 'edit_payment_details');

function render_Payment_Details()
{
 	
     global $title;
    ?>
        <h2><?php echo $title;?></h2>

        <?php
        global $wpdb;
        $results=$wpdb->get_results("select * from cp_payment_mode");
        //print_r($results);
        ?>
        <table border="1" width="100%" style="border-collapse: collapse;">
        <tr>
        <th>Payment id</th>
        <th>Username</th>
        <th>status</th>
        <th>Mode</th>
        <th>Action</th>
        </tr>
        <?php
        $i=1;
        foreach($results as $result){
        ?>
        <tr>
        <td style="text-align: center;"><?php echo $i; ?></td>
        <td style="text-align: center;"><?php echo $result->username; ?></td>
        <td style="text-align: center;"><?php echo $result->status; ?></td>
        <td style="text-align: center;"><?php echo $result->mode; ?></td>
        <td style="text-align: center;"><a href="<?php echo home_url(); ?>/wp-admin/admin.php?page=edit_payment_details&pid=<?php echo $result->id;?>">Edit</a></td>
        </tr>
        <?php
        $i++;
         }
         ?>
         </table>

<?php
}
function edit_payment_details()
{
	 if($_GET['pid']!="")
    {
    	global $wpdb;
		$result_payment=$wpdb->get_results("select * from cp_payment_mode where id='".$_GET['pid']."'");
		 
    }

    

	if(isset($_POST['submit']))
    {

    $username = $_POST['username'];
    $password = $_POST['password'];
    $signature = $_POST['signature'];
    $appkey = $_POST['appkey'];
    $status = $_POST['status'];

    if($_GET['pid']!='')

     {
       global $wpdb;
     	echo "update";

      $wpdb->update( 
			'cp_payment_mode', 
			array( 
				'username' => $username,
				'password' => $password,
				'signature' => $signature,
				'appkey' => $appkey,
				'status' => $status
	
			), 
			array( 'id' => $_GET['pid'] ), 
			array( 
				'%s',
				'%s',
				'%s',
				'%s',
				'%s',
			
			) 
        );
 
     header('Location:/wp-admin/admin.php?page=payment_details');
     	

  	}
  	 
}

?>
 <div style="padding-top: 30px;">

  <?php if($_GET['pid']) { ?> <h2>Edit Payment Details </h2><?php } else { ?> <h2></h2> <?php } ?>

 <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.18.0/jquery.validate.js'></script>
  <script type="text/javascript">
  	jQuery(document).ready(function () {
      jQuery('#frmpayment_details').validate({ // initialize the plugin
   errorElement: "div",
        rules: {
            username:{
                  required: true
			       },
			password:{
                  required: true
			       },
			signature:{
                  required: true
			       },
			appkey:{
                  required: true
			       },
			status:{
                  required: true
			       } 
		  },

		messages:{

			 username:{
                  required:"Please enter username"
			  },

			  password:{
                  required:"Please enter password"
			  },
			  signature:{
                  required:"Please enter signature"
			  },
			  appkey:{
                  required:"Please enter appkey"
			  },
			  status:{
                  required:"Please select status"
			  } 


        }
    });

});
</script>


 <form name="frmpayment_details" id="frmpayment_details" method="post" action="" >
  <table border="1" width="50%">
  <tr>
  <td>Username</td>
  <td>
   <input type="text" size="60" name="username" id="username" value="<?php echo $result_payment[0]->username; ?>">
  </td>
  </tr>
  <tr>
  <td>Password</td>
  <td>
   <input type="text" size="60" name="password" id="password" value="<?php echo $result_payment[0]->password; ?>">
  </td>
  </tr>
  <tr>
  <td>signature</td>
  <td>
   <input type="text" size="60" name="signature" id="signature" value="<?php echo $result_payment[0]->signature; ?>">
  </td>
  </tr>
  <tr>
  <td>App key</td>
  <td>
   <input type="text" size="60" name="appkey" id="appkey" value="<?php echo $result_payment[0]->appkey; ?>">
  </td>
  </tr>
  <tr>
  <td>Status</td>
  <td>
  <select name="status" id="status">
  <option value="">--select status--</option>
  <option value="Active" <?php if($result_payment[0]->status =='Active') { ?> selected='selected' <?php } ?> >Active</option>
  <option value="Inactive" <?php if($result_payment[0]->status =='Inactive') { ?> selected='selected' <?php } ?>>Inactive</option>
  </select>
   
  </td>
  </tr>
  <tr>
  <td>&nbsp;</td>
  <td><input type="submit" name="submit" id="submit" <?php if($_GET['pid']) { ?> value="Update" <?php } else { ?> value="Add" <?php } ?> ></td>
  </tr>
  </table>
  </form>
  </div>
  <div style="padding-top: 20px;padding-left:10px;"><a href='javascript:history.back(1);'>Back</a></div> 
  <?php
}
?>