<?php $role='accountant';?>
<script type="text/javascript">
$(document).ready(function() {
	$('#staff_form').validationEngine();
	$.fn.datepicker.defaults.format =" <?php echo get_option('gmgt_datepicker_format');?>";
      $('#birth_date').datepicker({
     endDate: '+0d',
        autoclose: true
   }); 
} );
</script>
     <?php 	
	if($active_tab == 'add_accountant')
	{
        	$accountant_id=0;
			$edit=0;
			if(isset($_REQUEST['accountant_id']))
				$accountant_id=$_REQUEST['accountant_id'];
			if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit')
			{
					
				$edit=1;
				$user_info = get_userdata($accountant_id);
				
			}?>
        <div class="panel-body">
			<form name="staff_form" action="" method="post" class="form-horizontal" id="staff_form">	
				<?php $action = isset($_REQUEST['action'])?$_REQUEST['action']:'insert';?>
				<input type="hidden" name="action" value="<?php echo $action;?>">
				<input type="hidden" name="role" value="<?php echo $role;?>"  />
				<input type="hidden" name="user_id" value="<?php echo $accountant_id;?>"  />
				<div class="form-group">
					<label class="col-sm-2 control-label" for="first_name"><?php _e('First Name','gym_mgt');?><span class="require-field">*</span></label>
					<div class="col-sm-8">
						<input id="first_name" class="form-control validate[required,custom[onlyLetterSp]] text-input" maxlength="50" type="text" value="<?php if($edit){ echo $user_info->first_name;}elseif(isset($_POST['first_name'])) echo $_POST['first_name'];?>" name="first_name">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label" for="middle_name"><?php _e('Middle Name','gym_mgt');?></label>
					<div class="col-sm-8">
						<input id="middle_name" class="form-control validate[custom[onlyLetterSp]] " type="text" maxlength="50"  value="<?php if($edit){ echo $user_info->middle_name;}elseif(isset($_POST['middle_name'])) echo $_POST['middle_name'];?>" name="middle_name">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label" for="last_name"><?php _e('Last Name','gym_mgt');?><span class="require-field">*</span></label>
					<div class="col-sm-8">
						<input id="last_name" class="form-control validate[required,custom[onlyLetterSp]] text-input" maxlength="50" type="text"  value="<?php if($edit){ echo $user_info->last_name;}elseif(isset($_POST['last_name'])) echo $_POST['last_name'];?>" name="last_name">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label" for="gender"><?php _e('Gender','gym_mgt');?><span class="require-field">*</span></label>
					<div class="col-sm-8">
					<?php $genderval = "male"; if($edit){ $genderval=$user_info->gender; }elseif(isset($_POST['gender'])) {$genderval=$_POST['gender'];}?>
						<label class="radio-inline">
						 <input type="radio" value="male" class="tog validate[required]" name="gender"  <?php  checked( 'male', $genderval);  ?>/><?php _e('Male','gym_mgt');?>
						</label>
						<label class="radio-inline">
						  <input type="radio" value="female" class="tog validate[required]" name="gender"  <?php  checked( 'female', $genderval);  ?>/><?php _e('Female','gym_mgt');?> 
						</label>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label" for="birth_date"><?php _e('Date of birth','gym_mgt');?><span class="require-field">*</span></label>
					<div class="col-sm-8">
						<input id="birth_date" class="form-control validate[required]" data-date-format="<?php echo gmgt_bootstrap_datepicker_dateformat(get_option('gmgt_datepicker_format'));?>" type="text"  name="birth_date" 
						value="<?php if($edit){ echo getdate_in_input_box($user_info->birth_date);}elseif(isset($_POST['birth_date'])) echo $_POST['birth_date'];?>">
					</div>
				</div>	
				
				<div class="form-group">
					<label class="col-sm-2 control-label" for="address"><?php _e('Home Town Address','gym_mgt');?><span class="require-field">*</span></label>
					<div class="col-sm-8">
						<input id="address" class="form-control validate[required]" maxlength="150" type="text"  name="address" 
						value="<?php if($edit){ echo $user_info->address;}elseif(isset($_POST['address'])) echo $_POST['address'];?>">
					</div>
				</div>
				
				
				<div class="form-group">
					<label class="col-sm-2 control-label" for="city_name"><?php _e('City','gym_mgt');?><span class="require-field">*</span></label>
					<div class="col-sm-8">
						<input id="city_name" class="form-control validate[required,custom[onlyLetterSp]]" maxlength="50" type="text"  name="city_name" 
						value="<?php if($edit){ echo $user_info->city_name;}elseif(isset($_POST['city_name'])) echo $_POST['city_name'];?>">
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
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label " for="phone"><?php _e('Phone','gym_mgt');?></label>
					<div class="col-sm-8">
						<input id="phone" class="form-control validate[,custom[phone]] text-input phone_validation" type="text" minlength="10" maxlength="15"   name="phone" 
						value="<?php if($edit){ echo $user_info->phone;}elseif(isset($_POST['phone'])) echo $_POST['phone'];?>">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label " for="email"><?php _e('Email','gym_mgt');?><span class="require-field">*</span></label>
					<div class="col-sm-8">
						<input id="email" class="form-control validate[required,custom[email]] text-input" maxlength="50" type="text"  name="email" 
						value="<?php if($edit){ echo $user_info->user_email;}elseif(isset($_POST['email'])) echo $_POST['email'];?>">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label" for="username"><?php _e('User Name','gym_mgt');?><span class="require-field">*</span></label>
					<div class="col-sm-8">
						<input id="username" class="form-control validate[required] space_validation" type="text" maxlength="30"  name="username" 
						value="<?php if($edit){ echo $user_info->user_login;}elseif(isset($_POST['username'])) echo $_POST['username'];?>" <?php if($edit) echo "readonly";?>>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label" for="password"><?php _e('Password','gym_mgt');?><?php if(!$edit) {?><span class="require-field">*</span><?php }?></label>
					<div class="col-sm-8">
						<input id="password" class="form-control space_validation <?php if(!$edit) echo 'validate[required]';?>" type="password" minlength="8" maxlength="12"  name="password" value="">
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
									<img alt="" src="<?php echo get_option( 'gmgt_system_logo' ); ?>">
									<?php }
									else {
										?>
									<img style="max-width:100%;" src="<?php if($edit)echo esc_url( $user_info->gmgt_user_avatar ); ?>" />
									<?php 
									}
									}
									else {
										?>
										<img alt="" src="<?php echo get_option( 'gmgt_system_logo' ); ?>">
										<?php 
									}?>
							</div>
				 </div>
				</div>
				<div class="col-sm-offset-2 col-sm-8">
					<input type="submit" value="<?php if($edit){ _e('Save','gym_mgt'); }else{ _e('Add Accountant','gym_mgt');}?>" name="save_staff" class="btn btn-success"/>
				</div>
			</form>
        </div>
     <?php 
	}
?>