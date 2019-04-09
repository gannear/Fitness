<?php 
	global $wpdb;
    $results=$wpdb->get_results("select * from cp_questions ORDER BY ques_display_order ASC"); 

    define('DESCRIPTIVE', '1');   
    define('TRUE_FALSE', '2');   
    define('MULTIPLE', '3');   
    define('YES_NO', '4');  
	define('SMALL_TEXT', '5'); 

?>

<?php 
/* 
 * For Questionnaire frontend 
 */
class Questionnaire {

	//return Question type
	public function getQuestionType($qtype_id){
		$type = '';
		switch($qtype_id){

		    case SMALL_TEXT:
				$type = 'text';
				break;
			case DESCRIPTIVE:
				$type = 'textarea';
				break;
			case TRUE_FALSE:
				$type = 'radio';
				break;
			case MULTIPLE:
				$type = 'checkbox';
				break;
			case YES_NO:
				$type = 'radio';
				break;
			default :
				$type = 'textarea';
		}
		return $type;
	}

	//return answers options html element
	public function _answerHtml($qtype_id, $ans_id, $label,$qid,$user_ques_answer){
      
		$type = $this->getQuestionType($qtype_id, $ans_id);
		
	    if($type == 'text'){
			
			echo "<input type=$type name='ques_$qid' id='ques_$qid' value='$user_ques_answer' >";

		}elseif($type == 'radio'){

             

             //print_r($user_ques_answer);
  
             $main_data_array=explode(",",$user_ques_answer);
             $wwpt = explode("=",$main_data_array[0]);
             //echo $wwpt[1];


             if($ans_id =='41')
             {
              echo"<input type=$type name='ques_$qid' id='ques_$qid' value='$label' ";
              if($label==$wwpt[1])
              	echo " checked='checked' ";

              echo ">$label</input>";

              // .(($label==$wwpt[1])? checked='checked':''). ">$label</input>"; 
             }
             else if($ans_id =='42')
             {
             	 
             	echo "<input type=$type name='ques_$qid' id='ques_$qid' value='$label'";

                 if($label==$wwpt[1])
              	echo " checked='checked' ";

                echo ">$label</input>";


 
             }
             else if($ans_id =='43')
             {
             	 
             	echo "<input type=$type name='ques_$qid' id='ques_$qid' value='$label'";

                 if($label==$wwpt[1])
              	echo " checked='checked' ";

                echo ">$label</input>";


 
             }
              else if($ans_id =='44')
             {
             	 
             	echo "<input type=$type name='ques_$qid' id='ques_$qid' value='$label'";

                 if($label==$wwpt[1])
              	echo " checked='checked' ";

                echo ">$label</input>";


 
             }
              else if($ans_id =='45')
             {
             	 
             	echo "<input type=$type name='ques_$qid' id='ques_$qid' value='$label'";

                 if($label==$user_ques_answer)
              	echo " checked='checked' ";

                echo ">$label</input>";


 
             }
              else if($ans_id =='46' || $ans_id =='61' || $ans_id =='62' || $ans_id =='50' || $ans_id =='51' )
             {
             	 
             	echo "<input type=$type name='ques_$qid' id='ques_$qid' value='$label'";

                 if($label==$user_ques_answer)
              	echo " checked='checked' ";

                echo ">$label</input>";


 
             }




             else
             {

             	 //echo "hi";
           	     //echo $user_ques_answer;

             	 
             	echo "<input type=$type name='ques_$qid' id='ques_$qid' value='$label' if($label==$user_ques_answer){ checked='checked'} >$label</input>";
		

             }

		
			
		}elseif($type == 'checkbox')
		{
			//echo "question id".$qid;
		    //echo "answerid".$ans_id;

           if($ans_id =='38'|| $ans_id=='39' || $ans_id=='40'|| $ans_id=='56' || $ans_id=='63' || $ans_id=='64' )
           {
           	   
                echo "<option value='default_ans_$ans_id'>$label</option>";

           }

           else if ($ans_id=='52' || $ans_id=='53' || $ans_id=='54')
           {

           	
             echo "<input type=radio class='checkBoxClass' name='pain_level' id='pain_level_id' value='$label'";
               if($label==$user_ques_answer)
              echo " checked='checked' "; 
              echo">$label</input>";

           }

           else
           {
             //print_r($user_ques_answer);
             $helatqarra = explode(',',$user_ques_answer);
            
           	  
			echo "<input type=$type class='checkBoxClass' name='default_ans_$ans_id' id='default_ans_$ans_id' value='$label'";
                for($i=0;$i<sizeof($helatqarra);$i++)
                {
                  if($label==$helatqarra[$i])
                   echo " checked='checked' "; 
                 }
			    echo ">$label</input>";
            }


            }
		else
			echo "<textarea cols=100 rows=5>$user_ques_answer</textarea>";	
	}
}

//Object for Questionnaire 
$obj = new Questionnaire; 
?>
<!-- Tab-3 content i.e. Questionnaire in frontend registration -->
<div id="tabs-3">
	
	<!-- first group of question start  -->	
	
	<div class="each-que" style="display:block;" id="first_ques_group" >
		<?php 
		
		  global $user_ID;

		  if(!empty($results)) :?>
			<?php foreach($results as $result) :?>
			<?php 

			//echo"<pre>";
			//print_r($result);
			
			$answers=$wpdb->get_results("SELECT * FROM cp_question_answers WHERE ques_id=$result->qid"); 

			// Fetching user's answer cp_ques_user_ans

			$user_ques_ans=$wpdb->get_results("SELECT * FROM cp_ques_user_ans WHERE ques_id=$result->qid AND user_id =$user_ID"); 

			$user_ques_answer = $user_ques_ans[0]->ques_ans; 

		 
						
			?>
			
			<div class="next-border-b" id="qid_"<?php echo $result->qid; ?> >
				<div class="question"><?php echo "$result->ques_display_order"; ?>.<?php echo "$result->question"; ?> </div>

				<?php if($result->ques_display_order==2){
					?>
					<div id='msg1' style="display: none;"></div>
               <?php
				}
				?>

				<?php if(!empty($answers)) : ?>
				<div class="answers">					
					<?php foreach($answers as $answer) :?>
						<div id="ans_"<?php echo $answer->id; ?> >
							<?php $obj->_answerHtml($result->qtype_id, $answer->id, $answer->ques_answer,$result->qid,$user_ques_answer); ?>
						</div>
					<?php endforeach; ?>
				</div>
				<?php else: ?>
					<div class="no-answers" style="border:0px solid red; margin-top:10; padding:0;">		<input type="textarea" cols="80" rows="1" name="input_ques_<?php echo $result->qid; ?>"  id="input_ques_<?php echo $result->qid; ?>" value="<?php echo $user_ques_answer; ?>"></textarea>
						<!-- <input type="button" name="btn_ques_<?php echo $result->qid; ?>" id="btn_ques_<?php echo $result->qid; ?>" value="Add" class="btnAdd"> -->
						<label id="label_input_ques_<?php echo $result->qid; ?>" ></label>
					</div>
					 
				<?php endif; ?>
				
			</div>
			</hr>
				
			<?php 
			
			if($result->ques_display_order==4){ break;  }
			
			endforeach; ?>




		<?php else: ?>
			<div class="next-border-b" id="no-questions" ?> >
				<?php _e('No Questions Found'); ?>
			</div>
		<?php endif; ?>

		<input type="button" id="next" name="next" class="nexttab btn btn-primary" value="Next">

	</div>

	<!-- first group of questions ends  -->

	<!-- Second group of question start  -->

		<div class="each-que" id="second_ques_group" style="display:none;">
		<?php if(!empty($results)) :?>
			<?php foreach($results as $result) :
			//echo "<pre>";
			//print_r($results);
           
            


			


			
			if($result->ques_display_order > 4 && $result->ques_display_order <= 6){

				$user_ques_ans2=$wpdb->get_results("SELECT * FROM cp_ques_user_ans WHERE ques_id=$result->qid AND user_id =$user_ID"); 

			   $user_ques_answer2 = $user_ques_ans2[0]->ques_ans;

			//echo "<pre>";
			//print_r($user_ques_answer2);

			
			?>

			<?php $answers=$wpdb->get_results("SELECT * FROM cp_question_answers WHERE ques_id=$result->qid"); ?>
			
			<div class="next-border-b" id="qid_"<?php echo $result->qid; ?> >
				<div class="question"><?php echo "$result->ques_display_order"; ?>.<?php echo "$result->question"; ?> </div>

				<?php if(!empty($answers)) : ?>
				<div class="answers">					
					 <select name="ques_<?php echo $result->qid; ?>" id="ques_<?php echo $result->qid; ?>">
					  <?php foreach($answers as $answer) :?>
						 <option value="<?php echo $answer->ques_answer; ?>" <?php if($answer->ques_answer == $user_ques_answer2) { ?> selected='selected' <?php } ?>><?php echo $answer->ques_answer; ?></option>
					<?php endforeach; ?>
					 </select>
				</div>
				<?php else: ?>
					<div class="no-answers" style="border:0px solid red; margin-top:10; padding:0;">		<input textarea cols="80" rows="5" name="input_ques_<?php echo $result->qid; ?>"  id="input_ques_<?php echo $result->qid; ?>" ></textarea>
						<!-- <input type="button" name="btn_ques_<?php echo $result->qid; ?>" id="btn_ques_<?php echo $result->qid; ?>" value="Add" class="btnAdd"> -->
						<label id="label_input_ques_<?php echo $result->qid; ?>" ></label>
					</div>
					 
				<?php endif; ?>
				
			</div>
			</hr>
				
			<?php 
			
		    }
			
			endforeach; ?>




		<?php else: ?>
			<div class="next-border-b" id="no-questions" ?> >
				<?php _e('No Questions Found'); ?>
			</div>
		<?php endif; ?>
		<input type="button" id="back1" name="back1" class="nexttab btn btn-primary" value="Back">
		<input type="button" id="next2" name="next2" class="nexttab btn btn-primary" value="Next">

	</div>

	<!-- Second group of question ends  -->

	<!-- third group of question start  -->

	<div class="each-que" id="third_ques_group" style="display:none;">
    
     <?php
			$logged_in_user_id = get_current_user_id();
             $get_data=$wpdb->get_results("SELECT * FROM cp_ques_user_ans WHERE ques_id='22' AND user_id=".$logged_in_user_id);
             
             $dvpersonal_trainer_data_main = $get_data[0]->ques_ans;
             $main_data_array=explode(",",$dvpersonal_trainer_data_main);
             
             $yes_no1 = explode("=", $main_data_array[0]);
             $name1 = explode("=", $main_data_array[1]);
             $phone1 = explode("=", $main_data_array[2]);
             $email1 = explode("=", $main_data_array[3]);
             $gym1 = explode("=", $main_data_array[4]);
             $addr1 = explode("=", $main_data_array[5]);



             $logged_in_user_id = get_current_user_id();
             $get_data_past=$wpdb->get_results("SELECT * FROM cp_ques_user_ans WHERE ques_id='24' AND user_id=".$logged_in_user_id);
             
             $dvpersonal_trainer_data_main_past = $get_data_past[0]->ques_ans;
             $main_data_array_past=explode(",",$dvpersonal_trainer_data_main_past);
             
             $yes_no2 = explode("=", $main_data_array_past[0]);
             $name2 = explode("=", $main_data_array_past[1]);
             $phone2 = explode("=", $main_data_array_past[2]);
             $email2 = explode("=", $main_data_array_past[3]);
             $gym2 = explode("=", $main_data_array_past[4]);
             $addr2 = explode("=", $main_data_array_past[5]);

             
			?>


		<?php if(!empty($results)) : //echo "<pre>"; print_r($results);?>
			<?php foreach($results as $result) :
			
			if($result->ques_display_order > 6 && $result->ques_display_order <= 9){

		  //echo "SELECT * FROM cp_ques_user_ans WHERE ques_id=$result->qid AND user_id =$user_ID";


            $user_ques_ans=$wpdb->get_results("SELECT * FROM cp_ques_user_ans WHERE ques_id=$result->qid AND user_id =$user_ID"); 

			$user_ques_answer = $user_ques_ans[0]->ques_ans;

			//echo "<pre>";
			//print_r($user_ques_answer2);

			 
			
			?>

			

			<?php $answers=$wpdb->get_results("SELECT * FROM cp_question_answers WHERE ques_id=$result->qid"); ?>
			
			<div class="next-border-b" id="qid<?php echo $result->qid; ?>" 
			
			<?php if($result->ques_display_order==7){ ?> style="display:block;" <?php } else { ?>   
			 style="display:none;"
			 <?php }?> 
			   			   
			   >
				<div class="question"><?php echo "$result->ques_display_order"; ?>.<?php echo "$result->question"; ?> </div>

				<?php if(!empty($answers)) : ?>
				<div class="answers">					
					<?php foreach($answers as $answer) :?>
						<div id="ans_"<?php echo $answer->id; ?> >
							<?php $obj->_answerHtml($result->qtype_id, $answer->id, $answer->ques_answer,$result->qid,$user_ques_answer); ?>
						</div>
					<?php endforeach; ?>
				</div>
				<?php else: ?>
					<div class="no-answers" style="border:0px solid red; margin-top:10; padding:0;">		<input textarea cols="80" rows="5" name="input_ques_<?php echo $result->qid; ?>"  id="input_ques_<?php echo $result->qid; ?>" ></textarea>
						<!-- <input type="button" name="btn_ques_<?php echo $result->qid; ?>" id="btn_ques_<?php echo $result->qid; ?>" value="Add" class="btnAdd"> -->
						<label id="label_input_ques_<?php echo $result->qid; ?>" ></label>
					</div>
					 
				<?php endif; ?>
				
			</div>

			
			

			</hr>
				
			<?php 
			
		    }
			
			endforeach; ?>

			

			<div id="dvpersonal_trainer" style="display: none;">
			 <table>
			   <tr>
			   <td>Name :</td>
			   <td><input type="text" name="ptrainer" id="ptrainer" value="<?php echo $name1[1]; ?> "></td>
			   </tr>
			   <tr>
			   <td>Phone number :</td>
			   <td><input type="text" name="pphnumber" id="pphnumber" value="<?php echo $phone1[1]; ?>"></td>
			   </tr>
			   <tr>
			   <td>Email address :</td>
			   <td><input type="text" name="pemail" id="pemail1" value="<?php echo $email1[1]; ?>"></td>
			   </tr>
			   <tr>
			   <td>Name of the Gym :</td>
			   <td><input type="text" name="pgym_name" id="pgym_name" value="<?php echo $gym1[1]; ?>"></td>
			   </tr>
			   <tr>
			   <td>Address : </td>
			   <td><textarea name="paddress" id="paddress1"><?php echo $addr1[1]; ?></textarea></td>
			   </tr>
			   </table>
				
			</div>

            <div id="dvpersonal_trainer_past" style="display: none;">
			   <table>
			   <tr>
			   <td>Name :</td>
			   <td><input type="text" name="pasttrainer" id="pasttrainer" value="<?php echo $name2[1]; ?> "></td>
			   </tr>
			   <tr>
			   <td>Phone number :</td>
			   <td><input type="text" name="pastphnumber" id="pastphnumber" value="<?php echo $phone2[1]; ?>"></td>
			   </tr>
			   <tr>
			   <td>Email address :</td>
			   <td><input type="text" name="pastemail" id="pastemail" value="<?php echo $email2[1]; ?>"></td>
			   </tr>
			   <tr>
			   <td>Name of the Gym :</td>
			   <td><input type="text" name="pastgym_name" id="pastgym_name" value="<?php echo $gym2[1]; ?>"></td>
			   </tr>
			   <tr>
			   <td>Address : </td>
			   <td><textarea name="pastaddress" id="pastaddress"><?php echo $addr2[1]; ?></textarea></td>
			   </tr>
			   </table>
			
			</div>


		<?php else: ?>
			<div class="next-border-b" id="no-questions" ?> >
				<?php _e('No Questions Found'); ?>
			</div>
		<?php endif; ?>
		<input type="button" id="back2" name="back2" class="nexttab btn btn-primary" value="Back">
		<input type="button" id="next3" name="next3" class="nexttab btn btn-primary" value="Next">

	</div>

	<!-- third group of question ends  -->


	<!-- Forth group of question start  -->

		<div class="each-que" id="forth_ques_group" style="display:none;">
		<?php if(!empty($results)) :?>
			<?php foreach($results as $result) :
			
			if($result->ques_display_order > 10 && $result->ques_display_order <= 19){


               $user_ques_ans=$wpdb->get_results("SELECT * FROM cp_ques_user_ans WHERE ques_id=$result->qid AND user_id =$user_ID"); 

			   $user_ques_answer = $user_ques_ans[0]->ques_ans;

			//echo "<pre>";
			//print_r($user_ques_answer);

          
			
			?>


			<?php $answers=$wpdb->get_results("SELECT * FROM cp_question_answers WHERE ques_id=$result->qid"); 

            //$user_ques_ans=$wpdb->get_results("SELECT * FROM cp_ques_user_ans WHERE ques_id=$result->qid AND user_id =$user_ID"); 

           // echo "<pre>";
            //print_r($user_ques_ans);


			//$user_ques_answer = $user_ques_ans[0]->ques_ans;

			?>
			<div class="next-border-b" id="qid_<?php echo $result->qid; ?>"

            
             <?php if($result->ques_display_order==11){ ?> style="display:block;" <?php } else { ?>   
			 style="display:none;"
			 <?php }?>


			 >

			 <?php if($result->ques_display_order==14){
					?>
					<div style="display: none;" id="doc_msg1">Please seek doctor’s advice before starting this program</div>
               <?php
				}
				?>
                <?php if($result->ques_display_order==19){
					?>
				<div style="display: none;color: red;" id="doc_msg2">You must have a doctor’s release to participate in this program.</div>

				<div style="display: none;color: red;" id="doc_msg3" >Warning, Please seek doctor’s advice before starting this program</div>
                 <?php
				}
				?>


				<div class="question"><?php echo "$result->ques_display_order"; ?>.<?php echo "$result->question"; ?> </div>

				 <?php
				 if($result->ques_display_order==19){
				 ?>
				<!-- <input type="checkbox" name="ckbCheckAll" id="ckbCheckAll" style="display:none;" /> -->
				 <?php } ?>

				<?php if(!empty($answers)) : ?>

                 

				<div class="answers">					
					<?php foreach($answers as $answer) :?>
						<div id="ans_<?php echo $answer->id; ?> ">
							<?php $obj->_answerHtml($result->qtype_id, $answer->id, $answer->ques_answer,$result->qid,$user_ques_answer); ?>
						</div>
					<?php endforeach; ?>
				</div>
				<?php else: ?>
					<div class="no-answers" style="border:0px solid red; margin-top:10; padding:0;">		<textarea cols="80" rows="5" name="input_ques_<?php echo $result->qid; ?>"  id="input_ques_<?php echo $result->qid; ?>" ><?php echo $user_ques_answer;?></textarea>
						 
						 
					</div>
					 
				<?php endif; ?>
				
			</div>
			</hr>
				
			<?php 
			
		    }
            ?>
		    
			<?php
			endforeach; ?>	




		<?php else: ?>
			<div class="next-border-b" id="no-questions" ?> >
				<?php _e('No Questions Found'); ?>
			</div>
		<?php endif; ?>
         
            
             

             <div style="display: none;" id="limitations">
             	<table>
             	<tr>
             	<td>limitations :</td>
             	<td><textarea name="limitations" id="limit" rows="5" cols="45"></textarea></td>
             	</tr>
             	</table>

             </div>


		<input type="button" id="back3" name="back3" class="nexttab btn btn-primary" value="Back">
		<input type="button" id="next4" name="next4" class="nexttab btn btn-primary" value="Next">

	</div>

	<!-- Forth group of question ends  -->
   
    

		 
	 
</div>

<!-- End of Tab-3 content -->
<script type="text/javascript">
var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";
   
    jQuery( function() {
    jQuery( "#ques_27" ).datepicker();
  } );
   
	// 26th Nov

	jQuery(document).ready(function() {
  
      jQuery("#ckbCheckAll").click(function () {
        jQuery(".checkBoxClass").prop('checked',
         jQuery(this).prop('checked'));

        
    });

     

          
    jQuery("#input_ques_17").keypress(function(){

    	var weight = jQuery("#input_ques_17").val();
    	var height = jQuery("#input_ques_16").val(); 
 
        var bmi =(703*weight)/height;

        //alert(bmi);

        if(bmi > 30){

    	jQuery("#msg1").css("display","block");

         jQuery("#msg1").html("Warning,your BMI exceeds 30. Please seek doctor’s dvice before starting this program.");
         //$("#msg1").delay(500).fadeTo("slow", 0.6);
         }
         else
         {
         	jQuery("#msg1").html(" ");
         }
    });
    
 





		jQuery(".btnAdd").click(function(){

			var btn_id = this.id; 
			var ques_id  = btn_id.slice(-2);
			var input_id =  'input_ques_'+ques_id;		
			
			var input_ques_answer = jQuery("#"+input_id).val();

			//user registration form validation
			if (!questionnaire_validation(input_id))	
				return;	
			
			if(ques_id){

				jQuery.ajax({ 
					type:'POST', 
					url:ajaxurl,
					data:'input_ques_answer='+input_ques_answer+'&ques_id='+ques_id+"&action=add_ques_answ",
					success:function(html){
                        
						alert('Inside success');

						jQuery("#first_ques_group").css({"display":"none"});
						jQuery("#second_ques_group").css({"display":"block"});

						//jQuery("#label_"+input_id).html(html);
						//jQuery("#label_"+input_id).css({"color": "green"});

						//jQuery('#City').html(html); gree

					}
				}); 

			}else{ 
		
			} 
		});

		// 27th Nov 2018 

        




		// step -1 process

		jQuery("#next").click(function(){

			//alert("hi");
			//exit;

			var btn_id = this.id; 
			var ques_id  = btn_id.slice(-2);
			var input_id =  'input_ques_'+ques_id;		
			
			//var input_ques_answer = jQuery("#"+input_id).val();

			var ques_16_ans = jQuery("#input_ques_16").val();
			var ques_17_ans = jQuery("#input_ques_17").val();
			var ques_18_ans = jQuery("#input_ques_18").val();
			var ques_19_ans = jQuery("#input_ques_19").val();

			var frmData ='ques_16_ans='+ques_16_ans+'&ques_17_ans='+ques_17_ans+'&ques_18_ans='+ques_18_ans+'&ques_19_ans='+ques_19_ans+'&ques_id='+ques_id+'&action=add_ques_answ';

			//user registration form validation
			if(!questionnaire_validation('input_ques_16') || !questionnaire_validation('input_ques_17') || !questionnaire_validation('input_ques_18'))	
				return;	


		
				jQuery.ajax({ 
					type:'POST', 
					url:ajaxurl,
					data:frmData,
					success:function(html){ 
					
					//alert(html);

					jQuery("#first_ques_group").css({"display":"none"});
					jQuery("#second_ques_group").css({"display":"block"});
					
					  //alert('success html');

					// jQuery("#label_"+input_id).html(html);
					 //jQuery("#label_"+input_id).css({"color": "green"});

					 //jQuery('#City').html(html); gree

					}
				}); 




		});

		// step 2 process


		jQuery("#back1").click(function(){

			jQuery("#first_ques_group").css({"display":"block"});
			jQuery("#second_ques_group").css({"display":"none"});

		});

		jQuery("#next2").click(function(){

			//var input_ques_answer = jQuery("#"+input_id).val();
			
			//alert(jQuery("#default_ans_38").val());
			//alert(jQuery("#default_ans_39").val());

			var ques_20 = jQuery('#ques_20').val();
			var ques_21 = jQuery('#ques_21').val();

			var ques_20_38_ans = jQuery("#default_ans_38").prop('checked')?'yes':'no';
			var ques_20_39_ans = jQuery("#default_ans_39").prop('checked')?'yes':'no';
			var ques_20_55_ans = jQuery("#default_ans_55").prop('checked')?'yes':'no';
			var ques_20_56_ans = jQuery("#default_ans_56").prop('checked')?'yes':'no';
			var ques_20_57_ans = jQuery("#default_ans_57").prop('checked')?'yes':'no';
			var ques_20_58_ans = jQuery("#default_ans_58").prop('checked')?'yes':'no';
			var ques_20_59_ans = jQuery("#default_ans_59").prop('checked')?'yes':'no';
			var ques_20_60_ans = jQuery("#default_ans_60").prop('checked')?'yes':'no';
			

			var ques_20_ans = '38='+ques_20_38_ans+',39='+ques_20_39_ans+',55='+ques_20_55_ans+',56='+ques_20_56_ans+',57='+ques_20_57_ans+',58='+ques_20_58_ans+',59='+ques_20_59_ans+',60='+ques_20_60_ans;

			var ques_21_ans = jQuery("#default_ans_40").prop('checked')?'yes':'no';

			/*var frmData ='ques_20_ans='+ques_20_ans+'&ques_21_ans='+ques_21_ans+'&action=add_ques_answ_2';*/

			var frmData ='ques_20_ans='+ques_20+'&ques_21_ans='+ques_21+'&action=add_ques_answ_2';

			//user registration form validation
			//if(!questionnaire_validation('input_ques_20') || !questionnaire_validation('input_ques_21'))	
			//	return;	
			
			jQuery.ajax({ 
				type:'POST', 
				url:ajaxurl,
				data:frmData,
				success:function(html){ 					 
					jQuery("#second_ques_group").css({"display":"none"});
					jQuery("#third_ques_group").css({"display":"block"});
				
				}
			}); 


			

		});

        
        jQuery("#next3").click(function(){

         var Question_id = '22';
         var yes_no_val_22 = jQuery('input[name=ques_22]:checked').val();

          
        
        // alert(yes_no_val_22);

         var ptrainer = jQuery('#ptrainer').val();
         var pphnumber = jQuery('#pphnumber').val();
         var pemail = jQuery('#pemail1').val();
         var pgym_name = jQuery('#pgym_name').val();
         var paddress = jQuery('#paddress1').val();

        //alert(pemail);
        //alert(paddress);

         var yes_no_val_24 = jQuery('input[name=ques_24]:checked').val();

         

         //alert(yes_no_val_24);

         var pasttrainer = jQuery('#pasttrainer').val();
         var pastphnumber = jQuery('#pastphnumber').val();
         var pastemail = jQuery('#pastemail').val();
         var pastgym_name = jQuery('#pastgym_name').val();
         var pastaddress = jQuery('#pastaddress').val();

         if(yes_no_val_22 =='Yes')
         {
           var ques_22_ans = 'work_with_personal_trainer='+yes_no_val_22+',Name='+ptrainer+',phone='+pphnumber+',email='+pemail+',gym_name='+pgym_name+',address='+paddress;

           //alert(ques_22_ans);

            
         }
         else
         {
         	var ques_22_ans = 'work_with_personal_trainer='+yes_no_val_22

         	 
         }

 
         if(yes_no_val_24 =='Yes')
         {
           var ques_24_ans = 'work_with_personal_trainer_past='+yes_no_val_24+',Name='+pasttrainer+',phone='+pastphnumber+',email='+pastemail+',gym_name='+pastgym_name+',address='+pastaddress;
               
         }
         else
         {
         	var ques_24_ans = 'work_with_personal_trainer_past='+yes_no_val_24
         	 
         }


         var frmData ='ques_22_ans='+ques_22_ans+'&ques_24_ans='+ques_24_ans+'&action=add_ques_answ_3';
         
         jQuery.ajax({ 
				type:'POST', 
				url:ajaxurl,
				data:frmData,
				success:function(html){ 					 
					jQuery("#third_ques_group").css({"display":"none"});
					jQuery("#forth_ques_group").css({"display":"block"});
				
				}
			}); 

        });

        jQuery("#next4").click(function(){
            

           var Question_id_26 = '26';
           var Question_26_ans = jQuery('input[name=ques_26]:checked').val();
           
           var Question_id_31 = '31';
           var Question_31_ans = jQuery('#input_ques_31').val();
           var Question_id_27 = '27';
           var Question_27_ans = jQuery('#ques_27').val();

           var Question_id_34 = '34';  
           var Question_34_ans = jQuery('input[name=ques_34]:checked').val();


           var Question_id_28 = '28';  
           var Question_28_ans = jQuery('#input_ques_28').val();
           var Question_id_29 = '29';  
           var Question_29_ans = jQuery('input[name=ques_29]:checked').val();  
           var Question_id_35 = '35';  
           var Question_35_ans = jQuery('#input_ques_35').val();
           
           var Question_id_30 = '30';  
           var Question_30_ans = jQuery('input[name=pain_level]:checked').val() 

           var boxarra = new Array();

           jQuery("input:checkbox[class=checkBoxClass]:checked").each(function(){
         boxarra.push(jQuery(this).val());
         });

           //console.log(boxarra);

           if(Question_26_ans=='Yes')
           {

           var frmData = {
            action: 'injury_frm_sbmt_yes',
            Question_id_26: Question_id_26,
            Question_26_ans:Question_26_ans,
            Question_id_31 : Question_id_31,
            Question_31_ans :Question_31_ans,
            Question_id_27:Question_id_27,
            Question_27_ans:Question_27_ans,
            Question_id_34:Question_id_34,
            Question_34_ans:Question_34_ans,
            Question_id_28:Question_id_28,
            Question_28_ans:Question_28_ans,
            Question_id_29:Question_id_29,
            Question_29_ans:Question_29_ans,
            Question_id_35:Question_id_35,
            Question_35_ans:Question_35_ans,
            Question_id_30:Question_id_30,
            Question_30_ans:Question_30_ans
          
           };
       }
       else
       {
             var frmData = {
             action: 'injury_frm_sbmt_yes',
             Question_id_26: Question_id_26,
             Question_26_ans:Question_26_ans,
             boxarra:boxarra
          
             };

       }
         
         jQuery.ajax({ 
				type:'POST', 
				url:ajaxurl,
				data:frmData,
				success:function(html){ 					 
					jQuery("#third_ques_group").css({"display":"none"});
					jQuery("#forth_ques_group").css({"display":"block"});
				
				}
			}); 

        });


		jQuery(window).load(function() {
			changeEvent();
			changeevent2();
			changeevent3();
			changeevent4();
			changeevent5();
        });

		jQuery('input[type=radio][name=ques_22]').change(function() {
			changeEvent();
		});

		function changeEvent()
		{
			var p_trainer = jQuery('input[name=ques_22]:checked').val();

			if(p_trainer=='Yes'){
				//jQuery("#qid_23").css({"display":"block"});
				
				jQuery("#dvpersonal_trainer").css({"display":"block"});
				jQuery("#qid24").css({"display":"none"});
			}

			if(p_trainer=='No'){
				jQuery("#qid24").css({"display":"block"});
				jQuery("#dvpersonal_trainer").css({"display":"none"});
				//jQuery("#qid_23").css({"display":"none"});
			}
		}


        function changeevent2()
        {

          var past_trainer = jQuery('input[name=ques_24]:checked').val();

			if(past_trainer=='Yes'){

				//jQuery("#qid_25").css({"display":"block"});
				//jQuery("#qid_26").css({"display":"none"});
				jQuery("#dvpersonal_trainer_past").css({"display":"block"});
			}

			if(past_trainer=='No'){
				//jQuery("#qid_26").css({"display":"block"});
				jQuery("#dvpersonal_trainer_past").css({"display":"none"});
				//jQuery("#qid_25").css({"display":"none"});
			}

        }



		jQuery('input[type=radio][name=ques_24]').change(function() {

			changeevent2();
           
		});




        function changeevent3(){
 
          var injured = jQuery('input[name=ques_26]:checked').val();

			if(injured=='Yes'){

				//alert(injured);
								
				jQuery("#qid_31").css({"display":"block"});
				jQuery("#qid_27").css({"display":"block"});
				jQuery("#qid_34").css({"display":"block"});
				jQuery("#qid_29").css({"display":"block"});
				jQuery("#qid_30").css({"display":"block"});
				jQuery("#qid_32").css({"display":"none"});
				jQuery("#ckbCheckAll").css({"display":"none"});
			}

			if(injured=='No'){
				//alert(injured);
				jQuery("#qid_31").css({"display":"none"});
				jQuery("#qid_27").css({"display":"none"});
				jQuery("#qid_34").css({"display":"none"});
				jQuery("#qid_29").css({"display":"none"});
				jQuery("#qid_30").css({"display":"none"});
				jQuery("#qid_35").css({"display":"none"});
				jQuery("#qid_32").css({"display":"block"});
				jQuery("#qid_28").css({"display":"none"});
				jQuery("#ckbCheckAll").css({"display":"block"});
				
			}



        }

		jQuery('input[type=radio][name=ques_26]').change(function() {

			changeevent3();

		});


       
        function changeevent4()
        {
               var limitations = jQuery('input[name=ques_34]:checked').val();

			if(limitations=='Yes'){

				//alert(injured);
								
				jQuery("#doc_msg1").css({"display":"block"});
				//jQuery("#limitations").css({"display":"block"});
				jQuery("#qid_28").css({"display":"block"});
				
				 
				 
			}

			if(limitations=='No'){
				//alert(injured);
				//jQuery("#qid_31").css({"display":"none"});
				jQuery("#doc_msg1").css({"display":"none"});
				//jQuery("#limitations").css({"display":"none"});
				jQuery("#qid_28").css({"display":"none"});
			}


        }



		jQuery('input[type=radio][name=ques_34]').change(function() {

			changeevent4();
			
		});


          function changeevent5(){

              var prev_injury = jQuery('input[name=ques_29]:checked').val();

			if(prev_injury=='Yes'){

				//alert(injured);
				jQuery("#qid_35").css({"display":"block"});
								
				 
				
				 
				 
			}

			if(prev_injury=='No'){
				 
				jQuery("#qid_35").css({"display":"none"});
			}

          }


		jQuery('input[type=radio][name=ques_29]').change(function() {

			changeevent5();
			

		});


	/*jQuery('input[type=checkbox][name=default_ans_24]').change(function() {

	 var prev_injury1 = jQuery('input[name=default_ans_24]:checked').val();
         
     alert(prev_injury1)
			 

		});*/

   jQuery('input[type=checkbox][name=ckbCheckAll]').change(function() {

   	
        if (jQuery(this).is(":checked")) {
            	//alert("yes");
                jQuery("#doc_msg2").show();
                jQuery("#doc_msg3").show();
            } else {
                jQuery("#doc_msg2").hide();
                jQuery("#doc_msg3").hide();
               // alert("no");
            }
        });



	jQuery('input[type=checkbox][name=default_ans_24]').change(function() {

         //   var $inputs = jQuery('input:checkbox')
	        // if(jQuery(this).is(':checked')){
	        //    $inputs.not(this).prop('disabled',true); // <-- disable all but checked one
	        //    jQuery("#default_ans_38").prop('disabled',false);
	           
	        // }else{
	        //    $inputs.prop('disabled',false); // <--
	        // }


            if (jQuery(this).is(":checked")) {
            	//alert("yes");
                jQuery("#doc_msg2").show();
            } else {
                jQuery("#doc_msg2").hide();
               // alert("no");
            }
        });
   jQuery('input[type=checkbox][name=default_ans_25]').change(function() {

         //   var $inputs = jQuery('input:checkbox')
	        // if(jQuery(this).is(':checked')){
	        //    $inputs.not(this).prop('disabled',true); // <-- disable all but checked one
	        // }else{
	        //    $inputs.prop('disabled',false); // <--
	        // }

            if (jQuery(this).is(":checked")) {
            	//alert("yes");
                jQuery("#doc_msg3").show();
            } else {
                jQuery("#doc_msg3").hide();
               // alert("no");
            }
        });
   jQuery('input[type=checkbox][name=default_ans_26]').change(function() {

         //   var $inputs = jQuery('input:checkbox')
	        // if(jQuery(this).is(':checked')){
	        //    $inputs.not(this).prop('disabled',true); // <-- disable all but checked one
	        // }else{
	        //    $inputs.prop('disabled',false); // <--
	        // }

            if (jQuery(this).is(":checked")) {
            	//alert("yes");
                jQuery("#doc_msg3").show();
            } else {
                jQuery("#doc_msg3").hide();
               // alert("no");
            }
        });
   jQuery('input[type=checkbox][name=default_ans_27]').change(function() {

         //    var $inputs = jQuery('input:checkbox')
	        // if(jQuery(this).is(':checked')){
	        //    $inputs.not(this).prop('disabled',true); // <-- disable all but checked one
	        // }else{
	        //    $inputs.prop('disabled',false); // <--
	        // }

            if (jQuery(this).is(":checked")) {
            	//alert("yes");
                jQuery("#doc_msg2").show();
            } else {
                jQuery("#doc_msg2").hide();
               // alert("no");
            }
        });

 jQuery('input[type=checkbox][name=default_ans_28]').change(function() {
           
         //   var $inputs = jQuery('input:checkbox')
	        // if(jQuery(this).is(':checked')){
	        //    $inputs.not(this).prop('disabled',true); // <-- disable all but checked one
	        // }else{
	        //    $inputs.prop('disabled',false); // <--
	        // }

            if (jQuery(this).is(":checked")) {
            	//alert("yes");
                jQuery("#doc_msg2").show();
            } else {
                jQuery("#doc_msg2").hide();
               // alert("no");
            }
        });

 jQuery('input[type=checkbox][name=default_ans_29]').change(function() {

         //    var $inputs = jQuery('input:checkbox')
	        // if(jQuery(this).is(':checked')){
	        //    $inputs.not(this).prop('disabled',true); // <-- disable all but checked one
	        // }else{
	        //    $inputs.prop('disabled',false); // <--
	        // }

            if (jQuery(this).is(":checked")) {
            	//alert("yes");
                jQuery("#doc_msg3").show();
            } else {
                jQuery("#doc_msg3").hide();
               // alert("no");
            }
        });
 jQuery('input[type=checkbox][name=default_ans_30]').change(function() {

         //    var $inputs = jQuery('input:checkbox')
	        // if(jQuery(this).is(':checked')){
	        //    $inputs.not(this).prop('disabled',true); // <-- disable all but checked one
	        // }else{
	        //    $inputs.prop('disabled',false); // <--
	        // }

            if (jQuery(this).is(":checked")) {
            	//alert("yes");
                jQuery("#doc_msg3").show();
            } else {
                jQuery("#doc_msg3").hide();
               // alert("no");
            }
        });
 jQuery('input[type=checkbox][name=default_ans_31]').change(function() {

         //    var $inputs = jQuery('input:checkbox')
	        // if(jQuery(this).is(':checked')){
	        //    $inputs.not(this).prop('disabled',true); // <-- disable all but checked one
	        // }else{
	        //    $inputs.prop('disabled',false); // <--
	        // }

            if (jQuery(this).is(":checked")) {
            	//alert("yes");
                jQuery("#doc_msg3").show();
            } else {
                jQuery("#doc_msg3").hide();
               // alert("no");
            }
        });
 jQuery('input[type=checkbox][name=default_ans_32]').change(function() {

 	       //  var $inputs = jQuery('input:checkbox')
	        // if(jQuery(this).is(':checked')){
	        //    $inputs.not(this).prop('disabled',true); // <-- disable all but checked one
	        // }else{
	        //    $inputs.prop('disabled',false); // <--
	        // }

            if (jQuery(this).is(":checked")) {
            	//alert("yes");
                jQuery("#doc_msg3").show();
            } else {
                jQuery("#doc_msg3").hide();
               // alert("no");
            }
        });
 jQuery('input[type=checkbox][name=default_ans_33]').change(function() {
 	       //  var $inputs = jQuery('input:checkbox')
	        // if(jQuery(this).is(':checked')){
	        //    $inputs.not(this).prop('disabled',true); // <-- disable all but checked one
	        // }else{
	        //    $inputs.prop('disabled',false); // <--
	        // }

            if (jQuery(this).is(":checked")) {
            	//alert("yes");
                jQuery("#doc_msg3").show();
            } else {
                jQuery("#doc_msg3").hide();
               // alert("no");
            }
        });
 jQuery('input[type=checkbox][name=default_ans_34]').change(function() {
 	       //  var $inputs = jQuery('input:checkbox')
	        // if(jQuery(this).is(':checked')){
	        //    $inputs.not(this).prop('disabled',true); // <-- disable all but checked one
	        // }else{
	        //    $inputs.prop('disabled',false); // <--
	        // }

            if (jQuery(this).is(":checked")) {
            	//alert("yes");
                jQuery("#doc_msg3").show();
            } else {
                jQuery("#doc_msg3").hide();
               // alert("no");
            }
        });
 jQuery('input[type=checkbox][name=default_ans_35]').change(function() {
 	       //  var $inputs = jQuery('input:checkbox')
	        // if(jQuery(this).is(':checked')){
	        //    $inputs.not(this).prop('disabled',true); // <-- disable all but checked one
	        // }else{
	        //    $inputs.prop('disabled',false); // <--
	        // }

            if (jQuery(this).is(":checked")) {
            	//alert("yes");
                jQuery("#doc_msg3").show();
            } else {
                jQuery("#doc_msg3").hide();
               // alert("no");
            }
        });


 jQuery('input[type=checkbox][name=default_ans_36]').change(function() {
 	       //  var $inputs = jQuery('input:checkbox')
	        // if(jQuery(this).is(':checked')){
	        //    $inputs.not(this).prop('disabled',true); // <-- disable all but checked one
	        // }else{
	        //    $inputs.prop('disabled',false); // <--
	        // }

            if (jQuery(this).is(":checked")) {
            	//alert("yes");
                jQuery("#doc_msg2").show();
            } else {
                jQuery("#doc_msg2").hide();
               // alert("no");
            }
        });

jQuery('input[type=checkbox][name=default_ans_37]').change(function() {
	        // var $inputs = jQuery('input:checkbox')
	        // if(jQuery(this).is(':checked')){
	        //    $inputs.not(this).prop('disabled',true); // <-- disable all but checked one
	        // }else{
	        //    $inputs.prop('disabled',false); // <--
	        // }

            if (jQuery(this).is(":checked")) {
            	//alert("yes");
                jQuery("#doc_msg3").show();
            } else {
                jQuery("#doc_msg3").hide();
               // alert("no");
            }
        });


		// 27 th Nov 2018 

		// 28 th Nov 2018

		 



		jQuery(function(){

	  //   jQuery("#ques_27").datepicker({
			// 	dateFormat: "mm-dd-yy"
			// }).val();



		var input = jQuery("#ques_27").val();

        var today = new Date();
		var dd = today.getDate();

		var mm = today.getMonth()+1; 
		var yyyy = today.getFullYear();
		if(dd<10) 
		{
		    dd='0'+dd;
		} 

		if(mm<10) 
		{
		    mm='0'+mm;
		} 

        var today = mm+'-'+dd+'-'+yyyy;

		
		

          
            var date1 = new Date(input);
			var date2 = new Date(today);
			var timeDiff = Math.abs(date2.getTime() - date1.getTime());
			var diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24)); 
			 
			if(diffDays < 30) {
				//alert("Please seek doctor’s advice before starting this program.")
			}

           

		});

		// 28th Nov 2018


		// step 3 process


		jQuery("#back2").click(function(){

			jQuery("#second_ques_group").css({"display":"block"});
			jQuery("#third_ques_group").css({"display":"none"});

		});

		jQuery("#next3").click(function(){
			jQuery("#forth_ques_group").css({"display":"block"});
			jQuery("#third_ques_group").css({"display":"none"});
           
		});

		jQuery("#back3").click(function(){

			jQuery("#third_ques_group").css({"display":"block"});
			jQuery("#forth_ques_group").css({"display":"none"});

		});


	});



	function questionnaire_validation(input_id){

		//var input_ques_answer =jQuery("#input_ques_16").val();

		var input_ques_answer = jQuery("#"+input_id).val();

		if(input_ques_answer.length < 1){
		
			jQuery("#"+input_id).css({"border": "1px solid red"});
			jQuery("#"+input_id).css({"border": "1px solid red"});
			jQuery("#label_"+input_id).html("Please fill data in textbox") 
			jQuery("#label_"+input_id).css({"color": "red"});

			return false;

		}else{
			
			jQuery("#"+input_id).css({"border": "1px solid #dddddd"});
			jQuery("#label_"+input_id).empty();
			return true;
		}	
	
	}

</script>

<?php


function add_ques_ans(){
   
   /*
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
		'membership_id' => $membership_id
	);

    if($membership_id == FREE_MEMBERSHIP) { // For Free Trial Membership

    	$user_id = wp_insert_user($userdata); 
        foreach($user_meta as $key => $value) {
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

		$mail_sent = wp_mail( $email, 'User Activation', 'Activation link : ' . $activation_link );
		
		if($mail_sent){

			if($user_id){
				$result['error'] = false;
				$result['message'] = "User registered successfully You will receive the activation link and once you activate it you will able log in on website";
				$result['user_id'] = $user_id;
				
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
     

	}

	*/

	echo "Inside add ques ans"; 

    die();

}

add_action('wp_ajax_add_ques_ans', 'add_ques_ans');
add_action('wp_ajax_nopriv_add_ques_ans', 'add_ques_ans');

