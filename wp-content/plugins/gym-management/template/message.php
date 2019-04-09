<?php 
$obj_gym = new MJ_Gym_management(get_current_user_id());
$obj_message= new MJ_Gmgt_message;
$active_tab = isset($_GET['tab'])?$_GET['tab']:'inbox';
//access right
$user_access=get_userrole_wise_page_access_right_array();
if (isset ( $_REQUEST ['page'] ))
{	
	if($user_access['view']=='0')
	{	
		access_right_page_not_access_message();
		die;
	}
	if (isset ( $_REQUEST ['page'] ) && $_REQUEST ['page'] == $user_access['page_link'] && ($_REQUEST['action']=='edit'))
	{
		if($user_access['edit']=='0')
		{	
			access_right_page_not_access_message();
			die;
		}			
	}
	if (isset ( $_REQUEST ['page'] ) && $_REQUEST ['page'] == $user_access['page_link'] && ($_REQUEST['action']=='delete'))
	{
		if($user_access['delete']=='0')
		{	
			access_right_page_not_access_message();
			die;
		}	
	}
	if (isset ( $_REQUEST ['page'] ) && $_REQUEST ['page'] == $user_access['page_link'] && ($_REQUEST['action']=='insert'))
	{
		if($user_access['add']=='0')
		{	
			access_right_page_not_access_message();
			die;
		}	
	}
}
?>
<div id="main-wrapper">
<div class="row mailbox-header">
                                <div class="col-md-2 col-sm-3 col-xs-4">   
								<?php
								if($user_access['add']=='1')
								{
								?>	
									<a class="btn btn-success btn-block" href="?dashboard=user&page=message&tab=compose">
                                    <?php _e("Compose","gym_mgt");?></a>        	
								<?php
								}
								?>	
                                </div>
                                <div class="col-md-10 col-sm-9 col-xs-8">
                                    <h2>
                                    <?php
									if(!isset($_REQUEST['tab']) || ($_REQUEST['tab'] == 'inbox'))
                                    echo esc_html( __( 'Inbox', 'gym_mgt' ) );
									else if(isset($_REQUEST['page']) && $_REQUEST['tab'] == 'sentbox')
									echo esc_html( __( 'Sent Item', 'gym_mgt' ) );
									else if(isset($_REQUEST['page']) && $_REQUEST['tab'] == 'compose')
										echo esc_html( __( 'Compose', 'gym_mgt' ) );
									else if(isset($_REQUEST['page']) && $_REQUEST['tab'] == 'view_message')
										echo esc_html( __( 'View Message', 'gym_mgt' ) );
									?>
								
                                    
                                    </h2>
                                </div>
                               
                            </div>
						<div class="col-md-2">
                            <ul class="list-unstyled mailbox-nav">
 								<li <?php if(!isset($_REQUEST['tab']) || ($_REQUEST['tab'] == 'inbox')){?>class="active"<?php }?>>
 									<a href="?dashboard=user&page=message&tab=inbox">
 										<i class="fa fa-inbox"></i><?php _e("Inbox","gym_mgt");?> <span class="badge badge-success pull-right">
 										<?php echo count(gmgt_count_inbox_item(get_current_user_id()));?></span>
 									</a>
 								</li> 							
                                <li <?php if(isset($_REQUEST['tab']) && $_REQUEST['tab'] == 'sentbox'){?>class="active"<?php }?>><a href="?dashboard=user&page=message&tab=sentbox"><i class="fa fa-sign-out"></i><?php _e("Sent","gym_mgt");?></a></li>
                                                           
                            </ul>
                        </div>
 <div class="col-md-10">
 <?php  
 	if($active_tab == 'sentbox')
 		require_once GMS_PLUGIN_DIR. '/template/message/sendbox.php';
 	if($active_tab == 'inbox')
 		require_once GMS_PLUGIN_DIR. '/template/message/inbox.php';
 	if($active_tab == 'compose')
 		require_once GMS_PLUGIN_DIR. '/template/message/composemail.php';
 	if($active_tab == 'view_message')
 		require_once GMS_PLUGIN_DIR. '/template/message/view_message.php';
 	
 	?>
 </div>
</div><!-- Main-wrapper -->
<?php ?>