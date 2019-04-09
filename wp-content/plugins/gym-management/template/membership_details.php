<?php
$payment_method = get_option('pm_payment_method');
$obj_membership=new MJ_Gmgtmembership;
$obj_activity=new MJ_Gmgtactivity;
 //var_dump($_POST);
if(isset($_REQUEST['membership_id'])){		
	$retrieved_data=$obj_membership->get_single_membership($_REQUEST['membership_id']);	
}
else{
	_e('Membership not selected.','gym_mgt');
}

if(isset($_POST['buy_confirm_paypal'])){
	
	$obj_member=new MJ_Gmgtmember; 
	$payment ="no";
	if (! is_user_logged_in ()) 
	{
		if(isset($_POST['member_id']))
		{
			$payment = "yes";
			//require_once GMS_PLUGIN_DIR. '/lib/paypal/buy_membership_process.php';	
		}
		else
		{		
			$page_id = get_option ( 'gmgt_login_page' );
			wp_redirect ( home_url () . "?page_id=" . $page_id);
		}
	}
	else
	{
		$payment = "yes";			
	}
	
	if($payment=="yes")
	{
		
		if($payment_method == "Skrill"){
			require_once PM_PLUGIN_DIR. '/lib/skrill/skrill.php';
		}
		elseif($payment_method == "Stripe"){
			require_once PM_PLUGIN_DIR. '/lib/stripe/index.php';
		}
		elseif($payment_method == "Instamojo"){
			require_once PM_PLUGIN_DIR. '/lib/instamojo/instamojo.php';
		}
		elseif($payment_method == "PayUMony"){
			require_once PM_PLUGIN_DIR. '/lib/OpenPayU/payuform.php';
		}
		elseif($payment_method == "2CheckOut"){
			require_once PM_PLUGIN_DIR. '/lib/2checkout/index.php';
		}
		elseif($payment_method == "iDeal"){
			require_once PM_PLUGIN_DIR. '/lib/ideal/ideal.php';
		}
		else{
			require_once GMS_PLUGIN_DIR. '/lib/paypal/buy_membership_process.php';
		}
	}
}
if(!empty($retrieved_data))
{ ?>
	<div class="wpgym-detail-box col-md-12">
		<div class="wpgym-border-box">
			<form name="membership_buy_form" method="post" action="">
				<div class="wpgym-box-title">
					<span class="wpgym-membershiptitle">
						<?php echo $retrieved_data->membership_label;?>
					</span>
				</div>
				<div class="wpgym-course-lession-list">
				<?php //echo $retrieved_data->membership_description;
				?>
				</div>
				<table>
				<tbody>
				<tr>	
					<th><?php _e('Membership Period','gym_mgt');?></th>
					<td><?php echo round($retrieved_data->membership_length_id/30)." Months";?></td>
				</tr>				
				
				<tr>	
					<th><?php _e('Membership Price','gym_mgt');?></th>
					<td><?php echo gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' ))."".$retrieved_data->membership_amount;?></td>
				</tr>
				
				</tbody>
				</table>
				<input type="hidden" name="amount" value="<?php echo $retrieved_data->membership_amount;?>">
				<input type="hidden" name="member_id" value="<?php if(isset($_REQUEST['user_id'])){ echo $_REQUEST['user_id'];} else { echo get_current_user_id(); }?>">
				<input type="hidden" name="mp_id" value="<?php echo $retrieved_data->membership_id;?>">
				<input type="hidden" name="where_payment" value="front_end">
				<!--<input type="hidden" name="txn_id" value="<?php echo '7d5s8f5ds5';?>">
				<input type="hidden" name="custom" value="<?php echo get_current_user_id()."_".$retrieved_data->membership_id;?>">
				<input type="hidden" name="mc_gross_1" value="<?php echo $retrieved_data->membership_amount;?>">-->
				<!--<span class="wpgym-btn-buynow">
				<?php echo gmgt_get_currency_symbol(get_option( 'gmgt_currency_code' ))."".$retrieved_data->membership_amount;?></span>-->
				<input type="submit" name="buy_confirm_paypal" value="<?php  echo __('Pay By','gym_mgt').' '.$payment_method;?>">
				</form>
			</div>	
		</div>
<?php } ?>