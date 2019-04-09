<?php 
//This is Dashboard at admin side
$role='staff_member';
?>
<script type="text/javascript">
$(document).ready(function() {
	 $('#staff_form').validationEngine();	 
	$('#specialization').multiselect();	
	  /* $(".specialization").click(function()
		{	
			checked = $(".multiselect_validation_specialization .dropdown-menu input:checked").length;
			if(!checked)
			{
			  alert("Please select atleast one specialization");
			  return false;
			}	
		}); */
		$.fn.datepicker.defaults.format =" <?php echo get_option('gmgt_datepicker_format');?>";
		$('#birth_date').datepicker(
		{
			endDate: '+0d',
			autoclose: true
		}); 
} );
</script>

    <?php 	
	if($active_tab == 'add_staffmember')
	{
        	$staff_member_id=0;
			$edit=0;
			if(isset($_REQUEST['staff_member_id']))
				$staff_member_id=$_REQUEST['staff_member_id'];
			if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit')
			{
				$edit=1;
				$user_info = get_userdata($staff_member_id);
			}?>
		<style>
		.btn-group-vertical {
			position: relative !important;
			display: inline-block !important;
		}
		</style>
        <div class="panel-body">
			<form name="staff_form" action="" method="post" class="form-horizontal" id="staff_form">	
				<?php $action = isset($_REQUEST['action'])?$_REQUEST['action']:'insert';?>
				<input type="hidden" name="action" value="<?php echo $action;?>">
				<input type="hidden" name="role" value="<?php echo $role;?>"  />
				<input type="hidden" name="user_id" value="<?php echo $staff_member_id;?>"  />
				<div class="header">	
					<h3><?php _e('Personal Information','gym_mgt');?></h3>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label" for="first_name"><?php _e('Name','gym_mgt');?><span class="require-field">*</span></label>
					<div class="col-sm-8">
						<input id="first_name" class="form-control validate[required,custom[onlyLetterSp]] text-input"  maxlength="50" type="text" value="<?php if($edit){ echo $user_info->user_login;}elseif(isset($_POST['first_name'])) echo $_POST['first_name'];?>" name="first_name" <?php if($edit) echo "readonly";?>>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label" for="first_name"><?php _e('Trainer Type','gym_mgt');?><span class="require-field">*</span></label>
					<div class="col-sm-8">
						 <select name="trainer_type" id="trainer_type" class="form-control validate[required]">
						<option value="">Select Trainer Type</option>
						<option value="personal">Personal Trainer</option>
						<option value="remote">Remote Trainer</option>
						<option value="Either">Either</option>
	
						</select>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label" for="first_name"><?php _e('Time Slots','gym_mgt');?><span class="require-field">*</span></label>
					<div class="col-sm-8">
						<select name="time_slot" id="time_slot" class="form-control validate[required]">
						<option value="">Select Time Slots</option>
						 <option value="HST">HST (Hawaii Standard Time)</option>
						 <option value="AKST">AKST (Alaska Standard Time)</option>
						 <option value="PST">PST (Pacific Standard Time)</option>
						 <option value="MST">MST (Mountain Standard Time)</option>
						 <option value="CST">CST (Central Standard Time)</option>
						 <option value="EST">EST (Eastern Standard Time)</option>
						 
					</select>
					</div>
				</div>
				<!-- <div class="form-group">
					<label class="col-sm-2 control-label" for="middle_name"><?php _e('Middle Name','gym_mgt');?></label>
					<div class="col-sm-8">
						<input id="middle_name" class="form-control validate[custom[onlyLetterSp]] text-input"  maxlength="50" type="text"  value="<?php if($edit){ echo $user_info->middle_name;}elseif(isset($_POST['middle_name'])) echo $_POST['middle_name'];?>" name="middle_name">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label" for="last_name"><?php _e('Last Name','gym_mgt');?><span class="require-field">*</span></label>
					<div class="col-sm-8">
						<input id="last_name" class="form-control validate[required,custom[onlyLetterSp]] text-input"  maxlength="50" type="text"  value="<?php if($edit){ echo $user_info->last_name;}elseif(isset($_POST['last_name'])) echo $_POST['last_name'];?>" name="last_name">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label" for="gender"><?php _e('Gender','gym_mgt');?><span class="require-field">*</span></label>
					<div class="col-sm-8">
					<?php $genderval = "male"; if($edit){ $genderval=$user_info->gender; }elseif(isset($_POST['gender'])) {$genderval=$_POST['gender'];}?>
						<label class="radio-inline">
						 <input type="radio" value="male" class="tog validate[required] radio_class_member" name="gender"  <?php  checked( 'male', $genderval);  ?>/><?php _e('Male','gym_mgt');?>
						</label>
						<label class="radio-inline">
						  <input type="radio" value="female" class="tog validate[required]" name="gender"  <?php  checked( 'female', $genderval);  ?>/><?php _e('Female','gym_mgt');?> 
						</label>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label" for="birth_date"><?php _e('Date of birth','gym_mgt');?><span class="require-field">*</span></label>
					<div class="col-sm-8">
						<input id="birth_date" class="form-control validate[required]" type="text" data-date-format="<?php echo gmgt_bootstrap_datepicker_dateformat(get_option('gmgt_datepicker_format'));?>" name="birth_date" 
						value="<?php if($edit){ 
						echo getdate_in_input_box($user_info->birth_date);}
						elseif(isset($_POST['birth_date'])) echo $_POST['birth_date'];?>">
					</div>
				</div>	
				<div class="form-group">
					<label class="col-sm-2 control-label" for="role_type"><?php _e('Assign Role','gym_mgt');?><span class="require-field">*</span></label>
					<div class="col-sm-8">
						<select  class="form-control validate[required]" name="role_type" id="role_type">
							<option value=""><?php _e('Select Role','gym_mgt');?></option>
							<?php 
							
							if(isset($_REQUEST['role_type']))
								$category =$_REQUEST['role_type'];  
							elseif($edit)
								$category =$user_info->role_type;
							else 
								$category = "";
							
							$role_type=gmgt_get_all_category('role_type');
							if(!empty($role_type))
							{
								foreach ($role_type as $retrive_data)
								{
									echo '<option value="'.$retrive_data->ID.'" '.selected($category,$retrive_data->ID).'>'.$retrive_data->post_title.'</option>';
								}
							}
							?>
						</select>
					</div>
					<div class="col-sm-2"><button id="addremove" model="role_type"><?php _e('Add Or Remove','gym_mgt');?></button></div>
				</div>
				
				<div class="form-group">
					<label class="col-sm-2 control-label" for="specialization"><?php _e('Specialization','gym_mgt');?><span class="require-field">*</span></label>
					<div class="col-sm-8 multiselect_validation_specialization">
						<select class="form-control"  name="specialization[]" id="specialization"  multiple="multiple" >
						<?php 
							if($edit)
								$category =json_decode($user_info->specialization);
							elseif(isset($_REQUEST['specialization']))
								$category =$_REQUEST['specialization'];  
							else 
								$category = array();
							
							$specialization=gmgt_get_all_category('specialization');
							if(!empty($specialization))
							{
								foreach ($specialization as $retrive_data)
								{
									$selected = "";
									if(in_array($retrive_data->ID,$category))
										$selected = "selected";
									echo '<option value="'.$retrive_data->ID.'"'.$selected.'>'.$retrive_data->post_title.'</option>';
								}
							}?>
						</select>
						<button id="addremove" model="specialization"><?php _e('Add Or Remove','gym_mgt');?></button>
					</div>	
				</div> -->
				<?php
                global $wpdb;
                if (is_numeric($user_info->Country))
					{
                $result_country=$wpdb->get_results("SELECT * FROM wp_countries where id='".$user_info->Country."'",ARRAY_A);

                $Country = $result_country[0]['name']; 
                }
                else
                {
                	$Country = $user_info->Country; 
                }
				?>
				<div class="header">	<hr>
					<h3><?php _e('Contact Information','gym_mgt');?></h3>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label" for="address"><?php _e('Country','gym_mgt');?></label>
					<div class="col-sm-8">
						<input id="Country" class="form-control" type="text" maxlength="150"  name="Country" 
						value="<?php if($edit){ echo $Country;}elseif(isset($_POST['Country'])) echo $_POST['Country'];?>">
					</div>
				</div>
				<?php
                global $wpdb;
                if (is_numeric($user_info->city))
					{
                $result_city=$wpdb->get_results("SELECT * FROM cities where id='".$user_info->city."'",ARRAY_A);
                $city =  $result_city[0]['name'];
                 }
                 else
                 {
                 	$city =  $user_info->city;
                 }
				?>
				<div class="form-group">
					<label class="col-sm-2 control-label" for="city_name"><?php _e('City','gym_mgt');?></label>
					<div class="col-sm-8">
						<input id="city" class="form-control" type="text" maxlength="50"  name="city" 
						value="<?php if($edit){ echo $city;}elseif(isset($_POST['City'])) echo $_POST['City'];?>">
					</div>
				</div>
				<?php
                global $wpdb;
                if (is_numeric($user_info->State))
					{
                $result_state=$wpdb->get_results("SELECT * FROM wp_states where id='".$user_info->State."'",ARRAY_A);

                $State =  $result_state[0]['name'];
                  }
                  else
                  {
                  	$State =  $user_info->State;
                  }
               
				?>
				<div class="form-group">
					<label class="col-sm-2 control-label" for="state_name"><?php _e('State','gym_mgt');?></label>
					<div class="col-sm-8">
						<input id="State" class="form-control" maxlength="50" type="text"  name="State" 
						value="<?php if($edit){ echo $State;}elseif(isset($_POST['State'])) echo $_POST['State'];?>">
					</div>
				</div>
				<!-- <div class="form-group">
					<label class="col-sm-2 control-label" for="zip_code"><?php _e('Zip Code','gym_mgt');?><span class="require-field">*</span></label>
					<div class="col-sm-8">
						<input id="zip_code" class="form-control validate[required,custom[onlyLetterNumber]]" maxlength="10" type="text"  name="zip_code" 
						value="<?php if($edit){ echo $user_info->zip_code;}elseif(isset($_POST['zip_code'])) echo $_POST['zip_code'];?>">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label " for="mobile"><?php _e('Mobile Number','gym_mgt');?><span class="require-field">*</span></label>
					<div class="col-sm-1">
					<input type="text" readonly value="+<?php echo gmgt_get_countery_phonecode(get_option( 'gmgt_contry' ));?>"  class="form-control" name="phonecode">
					</div>
					<div class="col-sm-7">
						<input id="mobile" class="form-control validate[required] text-input phone_validation" type="text" name="mobile" minlength="10" maxlength="15"
						value="<?php if($edit){ echo $user_info->mobile;}elseif(isset($_POST['mobile'])) echo $_POST['mobile'];?>">
					</div>
				</div> -->
				<div class="form-group">
					<label class="col-sm-2 control-label " for="phone"><?php _e('Phone','gym_mgt');?></label>
					<div class="col-sm-8">
						<input id="Phone_number" class="form-control text-input phone_validation" minlength="10" maxlength="15"  type="text"  name="Phone_number" 
						value="<?php if($edit){ echo $user_info->Phone_number;}elseif(isset($_POST['Phone_number'])) echo $_POST['Phone_number'];?>">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label " for="email"><?php _e('Email','gym_mgt');?><span class="require-field">*</span></label>
					<div class="col-sm-8">
						<input id="email" class="form-control validate[required,custom[email]] text-input" type="text" maxlength="50"  name="email" 
						value="<?php if($edit){ echo $user_info->user_email;}elseif(isset($_POST['email'])) echo $_POST['email'];?>">
					</div>
				</div>
				<div class="header">	<hr>
					<h3><?php _e('Login Information','gym_mgt');?></h3>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label" for="username"><?php _e('User Name','gym_mgt');?><span class="require-field">*</span></label>
					<div class="col-sm-8">
						<input id="username" class="form-control validate[required] space_validation" type="text"  name="username" maxlength="30" 
						value="<?php if($edit){ echo $user_info->user_login;}elseif(isset($_POST['username'])) echo $_POST['username'];?>" <?php if($edit) echo "readonly";?>>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label" for="password"><?php _e('Password','gym_mgt');?><?php if(!$edit) {?><span class="require-field">*</span><?php }?></label>
					<div class="col-sm-8">
						<input id="password" class="form-control space_validation <?php if(!$edit) echo 'validate[required]';?> " type="password" minlength="8" maxlength="12"  name="password" value="">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label" for="photo"><?php _e('Image','gym_mgt');?></label>
					<div class="col-sm-2">
						<input type="text" id="gmgt_user_avatar_url" class="form-control" name="gmgt_user_avatar"  
						value="<?php if($edit)echo esc_url( $user_info->gmgt_user_avatar );elseif(isset($_POST['gmgt_user_avatar'])) echo $_POST['gmgt_user_avatar']; ?>" />
					</div>	
					<div class="col-sm-3">
							 <input id="upload_user_avatar_button" type="button" class="button" value="<?php _e( 'Upload image', 'gym_mgt' ); ?>" />
							 <span class="description"><?php _e('Upload image', 'gym_mgt' ); ?></span>
					
					</div>
					<div class="clearfix"></div>
					<div class="col-sm-offset-2 col-sm-8">
							<div id="upload_user_avatar_preview" >
								 <?php if($edit) 
									{
										if($user_info->gmgt_user_avatar == "")
										{?>
										<img alt=""  style="max-width:100%;" src="<?php echo get_option( 'gmgt_system_logo' ); ?>">
										<?php }
										else {
											?>
										<img style="max-width:100%;" src="<?php if($edit)echo esc_url( $user_info->gmgt_user_avatar ); ?>" />
										<?php 
										}
									}
									else {
										?>
										<img alt="" style="max-width:100%;" src="<?php echo get_option( 'gmgt_system_logo' ); ?>">
										<?php 
									}?>
							</div>
					</div>
				</div>
				<div class="col-sm-offset-2 col-sm-8">
					<input type="submit" value="<?php if($edit){ _e('Save','gym_mgt'); }else{ _e('Add Trainer','gym_mgt');}?>" name="save_staff"  class="btn btn-success specialization"/>
				</div>
			</form>
        </div>
        
<?php 
    }
?>