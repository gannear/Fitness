<?php 
class MJ_Gym_management
{
	public $member;
	public $staff_member;
	public $role;
	public $notice;
	function __construct($user_id = NULL)
	{		
		if($user_id)
		{			
			$this->role=$this->get_current_user_role();
			$this->notice = $this->notice_board($this->get_current_user_role());
		}
	}
	//get current user role
	private function get_current_user_role ()
	{
		global $current_user;
		$user_roles = $current_user->roles;
		$user_role = array_shift($user_roles);
		return $user_role;
	}
	//get weight report
	public function get_weight_report($report_type,$user_id)
	{
		$report_type_array = array();
		global $wpdb;
		$table_name = $wpdb->prefix."gmgt_measurment";
		$q="SELECT * From $table_name where user_id=".$user_id;
		$result=$wpdb->get_results($q);
		foreach($result as $retrive)
		{		
			$all_data[$retrive->result_measurment][]=array('result'=>$retrive->result,'date'=>$retrive->result_date);
		}
		if($report_type == 'Weight')
		{
			$report_type_array = array();
			$report_type_array[] = array('date','weight	');
			if(isset($all_data['Weight']) && !empty($all_data['Weight']))
			foreach($all_data['Weight'] as $r)
			{
				$report_type_array[]=array($r['date'],(float)$r['result']);				
			
			}
		}
		if($report_type == 'Thigh')
		{			
			$report_type_array = array();
			$report_type_array[] = array('Date','Thigh');
			if(isset($all_data['Thigh']) && !empty($all_data['Thigh']))
			foreach($all_data['Thigh'] as $r)
			{
				$report_type_array[]=array($r['date'],(float)$r['result']);				
			
			}
		}
		if($report_type == 'Height')
		{
			$report_type_array = array();
			$report_type_array[] = array('Date','Height');
			if(isset($all_data['Height']) && !empty($all_data['Height']))
			foreach($all_data['Height'] as $r)
			{
				$report_type_array[]=array($r['date'],(float)$r['result']);
			}
		}
		if($report_type == 'Chest')
		{
			$report_type_array = array();
			$report_type_array[] = array('Date','Chest');
			if(isset($all_data['Chest']) && !empty($all_data['Chest']))
			foreach($all_data['Chest'] as $r)
			{
				$report_type_array[]=array($r['date'],(float)$r['result']);
			}
		}
		if($report_type == 'Waist')
		{
			$report_type_array = array();
			$report_type_array[] = array('Date','Waist');
			if(isset($all_data['Waist']) && !empty($all_data['Waist']))
			foreach($all_data['Waist'] as $r)
			{
				$report_type_array[]=array($r['date'],(float)$r['result']);
			}
		}
		if($report_type == 'Arms')
		{
			$report_type_array = array();
			$report_type_array[] = array('Date','Arms');
			if(isset($all_data['Arms']) && !empty($all_data['Arms']))
			foreach($all_data['Arms'] as $r)
			{
				$report_type_array[]=array($r['date'],(float)$r['result']);
			}
		}
		if($report_type == 'Fat')
		{
			$report_type_array = array();
			$report_type_array[] = array('Date','Fat');
			if(isset($all_data['Fat']) && !empty($all_data['Fat']))
			foreach($all_data['Fat'] as $r)
			{
				$report_type_array[]=array($r['date'],(int)$r['result']);
			}
		}		
		return $report_type_array;
	}
	//report option
	public function report_option($report_type)
	{
		$report_title = '';
		$htitle = "";
		$ytitle = "";
		if($report_type == 'Weight')
		{
			$report_title = __('Weight Report','gym_mgt');
			$htitle = __('Day','gym_mgt');
			$vtitle = get_option( 'gmgt_weight_unit' );//__('Kg','gym_mgt');
		}
		if($report_type == 'Thigh')
		{
			$report_title = __('Thigh Report','gym_mgt');
			$htitle = __('Day','gym_mgt');
			$vtitle = get_option( 'gmgt_thigh_unit' );//__('Inches','gym_mgt');
		}
		if($report_type == 'Height')
		{
			$report_title = __('Height Report','gym_mgt');
			$htitle = __('Day','gym_mgt');
			$vtitle = get_option( 'gmgt_height_unit' );//__('Centimeter','gym_mgt');
		}
		if($report_type == 'Chest')
		{
			$report_title = __('Chest Report','gym_mgt');
			$htitle = __('Day','gym_mgt');
			$vtitle = get_option( 'gmgt_chest_unit' );//__('Inches','gym_mgt');
		}
		if($report_type == 'Waist')
		{
			$report_title = __('Waist Report','gym_mgt');
			$htitle = __('Day','gym_mgt');
			$vtitle = get_option( 'gmgt_waist_unit' );//__('Inches','gym_mgt');
		}
		if($report_type == 'Arms')
		{
			$report_title = __('Arms Report','gym_mgt');
			$htitle = __('Day','gym_mgt');
			$vtitle = get_option( 'gmgt_arms_unit' );//__('Inches','gym_mgt');
		}
		if($report_type == 'Fat')
		{
			$report_title = __('Fat Report','gym_mgt');
			$htitle = __('Day','gym_mgt');
			$vtitle = get_option( 'gmgt_fat_unit' );
		}
		$options = Array(
				'title' => $report_title,
				'titleTextStyle' => Array('color' => '#66707e','fontSize' => 16,'bold'=>true,'italic'=>false,'fontName' =>'open sans'),
				'legend' =>Array('position' => 'right',
						'textStyle'=> Array('color' => '#66707e','fontSize' => 14,'bold'=>true,'italic'=>false,'fontName' =>'open sans')),
		
				'hAxis' => Array(
						'title' => $htitle,
						'titleTextStyle' => Array('color' => '#66707e','fontSize' => 14,'bold'=>true,'italic'=>false,'fontName' =>'open sans'),
						'textStyle' => Array('color' => '#66707e','fontSize' => 11),
						'maxAlternation' => 2
				),
				'vAxis' => Array(
						'title' => $vtitle,
						'minValue' => 0,
						'maxValue' => 5,
						'format' => '#',
						'titleTextStyle' => Array('color' => '#66707e','fontSize' => 14,'bold'=>true,'italic'=>false,'fontName' =>'open sans'),
						'textStyle' => Array('color' => '#66707e','fontSize' => 11)
				),
				'colors' => array('#E14444')
			);
		return $options;
				
		
	}
	//notice board
	public function notice_board($role,$limit = -1)
	{
		$args['post_type'] = 'gmgt_notice';
		$args['posts_per_page'] = $limit;
		$args['post_status'] = 'public';
		$args['orderby'] = 'date';
		$args['order'] = 'DESC';
		$args['meta_query'] = array(
									'relation' => 'OR',
							        array(
							            'key' => 'notice_for',
							            'value' =>"all",						           
							        ),
									array(
											'key' => 'notice_for',
											'value' =>"$role",
									)
							   );
		$q = new WP_Query();
		
		$retrieve_notice = $q->query( $args );
		return $retrieve_notice;		
	}
	//get today workout
	public function get_today_workout($user_id)
	{
		global $wpdb;
		$table_name = $wpdb->prefix."gmgt_assign_workout";
		$table_gmgt_workout_data = $wpdb->prefix."gmgt_workout_data";
		$date = date('Y-m-d');
		
		$day_name = date('l', strtotime($date));
		
		$sql = "Select * From $table_name as workout,$table_gmgt_workout_data as workoutdata where  workout.user_id = $user_id 
		AND  workout.workout_id = workoutdata.workout_id 
		AND workoutdata.day_name = '$day_name'
		AND CURDATE() between workout.Start_date and workout.End_date ";
		
		$result = $wpdb->get_results($sql);
		return $result;
	}
}
?>