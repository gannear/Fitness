<script>
var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";
var urlRand = new Date().getTime();

function approve(staff_id){
	//ert(staff_id);
	
	var data = {
            action: 'approve_trainer',
            staff_id : staff_id,
            urlRand :urlRand           
        };

	jQuery.ajax({ 
				 type:'POST', 
				 url:ajaxurl,
				 data,
				 success:function(html){ 

				 	$("#tapprove_"+staff_id).text('Approved');
				 	$('.triner_approve').addClass('disabled');

				 	
					//jQuery('#msg').html("User Register successfully");
					//var url = 'http://fitness.php-dev.in/success'; 
					//setTimeout(function () {
					//window.location.href = url;
				    //	}, 1000);
					
				 }
				}); 

//;
}

</script>


<?php 
$obj_user=new MJ_Gmgtmember;
$active_tab = isset($_GET['tab'])?$_GET['tab']:'staff_memberlist';
?>
<!-- POP up code -->
<div class="popup-bg" style="min-height:1631px !important">
    <div class="overlay-content">
		<div class="modal-content">
			<div class="category_list">
			 </div>
        </div>
    </div> 
</div>
<!-- End POP-UP Code -->
<div class="page-inner" style="min-height:1631px !important">
	<div class="page-title">
			<h3><img src="<?php echo get_option( 'gmgt_system_logo' ) ?>" class="img-circle head_logo" width="40" height="40" /><?php echo get_option( 'gmgt_system_name' );?></h3>
	</div>
	
	<?php 
	if(isset($_POST['save_staff']))
	{
		if(isset($_REQUEST['action'])&& $_REQUEST['action']=='edit')
		{
			$txturl=$_POST['gmgt_user_avatar'];
			$ext=check_valid_extension($txturl);
			if(!$ext == 0)
			{
				$result=$obj_user->gmgt_add_user($_POST);
		
				if($result)
				{
					wp_redirect ( admin_url() . 'admin.php?page=gmgt_staff&tab=staff_memberlist&message=2');
				}
			}			
			else
			{ ?>
				<div id="message" class="updated below-h2 ">
				<p>
					<?php _e('Sorry, only JPG, JPEG, PNG & GIF And BMP files are allowed.','gym_mgt');?>
				</p></div>				 
				<?php 
			}	
		}
		else
		{
			if( !email_exists( $_POST['email'] ) && !username_exists( $_POST['username'] ))
			{
				$txturl=$_POST['gmgt_user_avatar'];
				$ext=check_valid_extension($txturl);
				if(!$ext == 0)
				{
					$result=$obj_user->gmgt_add_user($_POST);
						
					if($result)
					{
						wp_redirect ( admin_url() . 'admin.php?page=gmgt_staff&tab=staff_memberlist&message=1');
					}
				}			
				else
				{ ?>
					<div id="message" class="updated below-h2 ">
					<p>
						<?php _e('Sorry, only JPG, JPEG, PNG & GIF And BMP files are allowed.','gym_mgt');?>
					</p></div>				 
					<?php 
				}	
			}
			else
			{?>
						<div id="message" class="updated below-h2">
						<p><p><?php _e('Username Or Email id exists already.','gym_mgt');?></p></p>
						</div>
						
	  <?php }
		}
			
	}
	
	if(isset($_REQUEST['action'])&& $_REQUEST['action']=='delete')
	{
		
		$result=$obj_user->delete_usedata($_REQUEST['staff_member_id']);
		if($result)
		{
			wp_redirect ( admin_url() . 'admin.php?page=gmgt_staff&tab=staff_memberlist&message=3');
		}
	}
	if(isset($_REQUEST['message']))
	{
		$message =$_REQUEST['message'];
		if($message == 1)
		{?>
				<div id="message" class="updated below-h2 ">
				<p>
				<?php 
					_e('Record inserted successfully','gym_mgt');
				?></p></div>
				<?php 
			
		}
		elseif($message == 2)
		{?><div id="message" class="updated below-h2 "><p><?php
					_e("Record updated successfully",'gym_mgt');
					?></p>
					</div>
				<?php 
			
		}
		elseif($message == 3) 
		{?>
		<div id="message" class="updated below-h2"><p>
		<?php 
			_e('Record deleted successfully','gym_mgt');
		?></div></p><?php
				
		}
	}
		
	?>
	<div id="main-wrapper">
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-white">
					<div class="panel-body">
						<h2 class="nav-tab-wrapper">
							<a href="?page=gmgt_staff&tab=staff_memberlist" class="nav-tab <?php echo $active_tab == 'staff_memberlist' ? 'nav-tab-active' : ''; ?>">
							<?php echo '<span class="dashicons dashicons-menu"></span> '.__('Trainer List', 'gym_mgt'); ?></a>
							
							<?php  if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit')
							{?>
							<a href="?page=gmgt_staff&tab=add_staffmember&&action=edit&staff_member_id=<?php echo $_REQUEST['staff_member_id'];?>" class="nav-tab <?php echo $active_tab == 'add_staffmember' ? 'nav-tab-active' : ''; ?>">
							<?php _e('Edit Trainer', 'gym_mgt'); ?></a>  
							<?php 
							}
							else
							{?>
								<a href="?page=gmgt_staff&tab=add_staffmember" class="nav-tab <?php echo $active_tab == 'add_staffmember' ? 'nav-tab-active' : ''; ?>">
							<?php echo '<span class="dashicons dashicons-plus-alt"></span> '.__('Add Trainer', 'gym_mgt'); ?></a>  
							<?php  }?>
						   
						</h2>
						 <?php 
						//Report 1 
						if($active_tab == 'staff_memberlist')
						{ ?>	
						<script type="text/javascript">
							$(document).ready(function()
							{
							 jQuery('#staff_list').DataTable({
								"responsive": true,
								 "order": [[ 1, "asc" ]],
								 "aoColumns":[
											  {"bSortable": false},
											  {"bSortable": true},
											  {"bSortable": true},
											  {"bSortable": true},
											  {"bVisible": true},	                 
											  {"bSortable": false}
										   ]
								 
								});
							
							} );
					    </script>
						<form name="wcwm_report" action="" method="post">
							<div class="panel-body">
									<div class="table-responsive">
										<table id="staff_list" class="display" cellspacing="0" width="100%">
											<thead>
												<tr>
													<th style="width: 50px;height:50px;"><?php  _e( 'Photo', 'gym_mgt' ) ;?></th>
													<th><?php _e( 'Trainer Name', 'gym_mgt' ) ;?></th>
													<th><?php _e( 'Role', 'gym_mgt' ) ;?></th>
													<th> <?php _e( 'Trainer  Email', 'gym_mgt' ) ;?></th>
													<th> <?php _e( 'Mobile No', 'gym_mgt' ) ;?></th>
													<th> <?php _e( 'Certificates', 'gym_mgt' ) ;?></th>
													<th> <?php _e( 'Application Status', 'gym_mgt' ) ;?></th>
													<th><?php  _e( 'Action', 'gym_mgt' ) ;?></th>
												</tr>
										    </thead>
											<tfoot>
												<tr>
													<th><?php  _e( 'Photo', 'gym_mgt' ) ;?></th>
													<th><?php _e( 'Trainer  Name', 'gym_mgt' ) ;?></th>
													<th><?php _e( 'Role', 'gym_mgt' ) ;?></th>
													<th> <?php _e( 'Trainer  Email', 'gym_mgt' ) ;?></th>
													<th> <?php _e( 'Mobile No', 'gym_mgt' ) ;?></th>
													<th> <?php _e( 'Certificates', 'gym_mgt' ) ;?></th>
													<th> <?php _e( 'Application Status', 'gym_mgt' ) ;?></th>
													<th><?php  _e( 'Action', 'gym_mgt' ) ;?></th>
												</tr>
											</tfoot>
											<tbody>
												 <?php 
												 //$nursedata=get_usersdata('nurse');
												 $get_staff = array('role' => 'Staff_member');
													$staffdata=get_users($get_staff);
													//print_r($staffdata);
												if(!empty($staffdata))
												{
													foreach ($staffdata as $retrieved_data){
												 ?>
													<tr>
														<td class="user_image"><?php $uid=$retrieved_data->ID;
																	$userimage=get_user_meta($uid, 'gmgt_user_avatar', true);
																if(empty($userimage))
																{
																				echo '<img src='.get_option( 'gmgt_system_logo' ).' height="50px" width="50px" class="img-circle" />';
																}
																else
																	echo '<img src='.$userimage.' height="50px" width="50px" class="img-circle"/>';
														?></td>
														<td class="name"><a href="?page=gmgt_staff&tab=add_staffmember&action=edit&staff_member_id=<?php echo $retrieved_data->ID;?>"><?php echo $retrieved_data->user_login;?></a></td>
														<td class="department"><?php 
														$postdata=get_post($retrieved_data->role_type);
														if(isset($postdata))
															echo $postdata->post_title;?>
														</td>
														<td class="email"><?php echo $retrieved_data->user_email;?></td>
														<td class="mobile"><?php echo $retrieved_data->Phone_number;?></td>

                                                        <td class="Certificates">
                                                        <?php
                                                         $uid=$retrieved_data->ID;
                                                        
                                                        $target_path = 'http://fitness.php-dev.in/wp-content/uploads/custom/';
                                                         $userdoc=get_user_meta($uid, 'documents', true);
                                                         //echo"==".$userdoc;
                                                         $userdocarr=explode(",", $userdoc);
                                                         if(count($userdocarr) > 1){
                                                        // print_r($userdocarr);
                                                         $cnt=1;
                                                          for($doc=0;$doc<sizeof($userdocarr); $doc++){
                                                         ?>
                                                         <a href="<?php echo $target_path. $userdocarr[$doc]; ?>" target="_blank">Certificate<?php echo $cnt; ?></a>&nbsp;&nbsp;
                                                          
                                                          <?php $cnt++; } } ?>

                                                         </td>

               <?php
               $complete_reg=get_user_meta($uid, 'complete_reg', true );
               if($complete_reg=='complete_reg')
               {
               ?>
               <td>complete</td>
               <?php } else {
               	?>
               	<td>Incomplete</td>
               	<?php
               }
               ?>

														<td class="action">
                                                        <input type="hidden"
                                                        name="t_id" id="t_id"
                                                        class="t_id" value="<?php echo $retrieved_data->ID;?>">
                            <!-- <button class="btn btn-info" disabled>test</button> --> 
                            <?php if($retrieved_data->trainer_status == '1') { ?>
                               <button class="btn btn-info" disabled>Approved</button>  
                            <?php } else { ?>
                              
                                <a href="javascript:void(0);" id="tapprove_<?php echo $retrieved_data->ID; ?>"   class="btn btn-info triner_approve " onclick="approve(<?php echo $retrieved_data->ID; ?>)" >Approve Trainer</a>
                              
                            <?php } ?>                    


                             <!-- <a id="tapprove_<?php echo $retrieved_data->ID; ?>" href="#"  class="btn btn-info triner_approve " onclick="approve(<?php echo $retrieved_data->ID; ?>)" > <?php if($retrieved_data->user_status == '0') { ?>Approved <?php } else {?> Approve Trainer <?php } ?></a> -->

														 <a href="?page=gmgt_staff&tab=add_staffmember&action=edit&staff_member_id=<?php echo $retrieved_data->ID;?>" class="btn btn-info"> <?php _e('Edit', 'gym_mgt' ) ;?></a>
															<a href="?page=gmgt_staff&tab=staff_memberlist&action=delete&staff_member_id=<?php echo $retrieved_data->ID;?>" class="btn btn-danger" 
															onclick="return confirm('<?php _e('Do you really want to delete this record?','gym_mgt');?>');">
															<?php _e( 'Delete', 'gym_mgt' ) ;?> </a>
														</td>
													   
													</tr>
													<?php } 
												}?>
											</tbody>
										</table>
								    </div>
							</div>
					    </form>
						 <?php 
						}
						if($active_tab == 'add_staffmember')
						{
						   require_once GMS_PLUGIN_DIR. '/admin/staff-members/add_staff.php';
						}
						?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>


<?php //} ?>