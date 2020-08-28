<?php
require_once("functions.php") ;

if(isset($_GET[current_list]) &&$_GET[current_list]==1)
{
	echo   get_student_courses_list_by_status($_SESSION["current_student_id"] , '1,5' ) ;
}
if(isset($_GET[Possible_courses]) &&$_GET[Possible_courses]==1)
{
	echo   get_Possible_courses_list($_SESSION["current_student_id"]);
}





if(isset($_GET[do_app_book]) &&$_GET[do_app_book]==1)
{
	extract($_GET) ; 
	 
//	print_r($_GET) ; 
 
	 
	 $sql = "INSERT INTO `appointments` (`appointment_id`, `ap_date`, `period_id`, `advisor_id`, `student_id`) VALUES (NULL, '$ap_date', '$period_id', '$advisor_id', '$student_id'); " ;
	
	//echo $sql ; 
	
	if(mysql_query($sql))
	echo "You have booked an appointment with your academic advisor, be there on time!" ; 
	
	
	
    
}



if(isset($_GET[viw_adv_schedule]) &&$_GET[viw_adv_schedule]==1)
{
	extract($_POST) ; 
	
	if (isset($_POST['date_start']) && isset($_POST['date_end']))
	{
		 $d1 = ($_POST['date_start']);
	     $d2 = ($_POST['date_end']);
		 
		$d1 =   date("Y-m-d", strtotime($d1) );
		$d2 =   date("Y-m-d", strtotime($d2) );
		
		$today = date("Y-m-d") ;  
		$today =   date("Y-m-d", strtotime($today) );
		 
	 	$dayes = createDateRangeArray($d1,$d2) ; 	
	   
	   echo '<h3>From : ' .   $d1 . ' To : ' .$d2 .'</h3>'; 
		
		?>
        
        <table  class="table table-bordered table-striped table-hover"  >
        <thead>
          <tr  class="bg-primary">
          <th> Date / periods </th>
            <?php 
			$s = "select * from periods order by period_id" ;
			$r = mysql_query($s) ; 
			while($q=mysql_fetch_array($r))
			{
				echo "<th>".$q[p_name]."</th>" ; 	
			}
		
		 
			?>
            
            
            
          </tr>
        </thead>
          <tbody>
        
        <?php 
		foreach ($dayes as $day) {
   
   
   			$nameOfDay = date('D', strtotime($day));
			 if($nameOfDay !='Fri' && $nameOfDay !='Sat')
			 {
   
    ?>
    
    
    <tr  >
          <th class="bg-primary" >
          
          <?php 
echo $nameOfDay .'<br> ' . $day;
?>
          
             </th>
            <?php 
			for($i=1;$i<=4;$i++)
			{
				$sql = "select count(*) as count_app  , student_id from appointments  where ap_date ='".$day."' 
									 	and period_id =".$i . " and advisor_id = ".$advisor_id  ;
										
				
				$res = mysql_query($sql) ;
				$qres = mysql_fetch_array($res) ;  
				if ($qres[count_app]>0 )
				{
					
					?><td  class="alert-info" align="center"> <?=get_by_id('students','student_name','student_id',$qres[student_id])?>  </td><?php
				}
				else
				{
					
						?><td  >   </td><?php
						
				}
				
			}
			?>
          </tr>
    <?php 
			 }
}
       
       ?>
				
 
         
 
			 
        
			  
          </tbody>
        
      </table>
      
        
        <?php
		
	}
	
	
	
    
}

if(isset($_GET[booking_app]) &&$_GET[booking_app]==1)
{
	extract($_POST) ; 
	
	if (isset($_POST['date_start']) && isset($_POST['date_end']))
	{
		 $d1 = ($_POST['date_start']);
	     $d2 = ($_POST['date_end']);
		 
		$d1 =   date("Y-m-d", strtotime($d1) );
		$d2 =   date("Y-m-d", strtotime($d2) );
		
		$today = date("Y-m-d") ;  
		$today =   date("Y-m-d", strtotime($today) );
		 
	 	$dayes = createDateRangeArray($d1,$d2) ; 	
	   
	   echo '<h3>From : ' .   $d1 . ' To : ' .$d2 .'</h3>'; 
		
		?>
        
        <table  class="table table-bordered table-striped table-hover"  >
        <thead>
          <tr  class="bg-primary">
          <th> Date / periods </th>
            <?php 
			$s = "select * from periods order by period_id" ;
			$r = mysql_query($s) ; 
			while($q=mysql_fetch_array($r))
			{
				echo "<th>".$q[p_name]."</th>" ; 	
			}
		
		 
			?>
            
            
            
          </tr>
        </thead>
          <tbody>
        
        <?php 
		foreach ($dayes as $day) {
   
   
   			$nameOfDay = date('D', strtotime($day));
			 if($nameOfDay !='Fri' && $nameOfDay !='Sat')
			 {
   
    ?>
    
    
    <tr  >
          <th class="bg-primary" >
          
          <?php 
echo $nameOfDay .'<br> ' . $day;
?>
          
             </th>
            <?php 
			for($i=1;$i<=4;$i++)
			{
				$sql = "select count(*) as count_app from appointments  where ap_date ='".$day."' 
									 	and period_id =".$i . " and advisor_id = ".$advisor_id  ;
				$res = mysql_query($sql) ;
				$qres = mysql_fetch_array($res) ;  
				if ($qres[count_app]>0 )
				{
					
					?><td  class="alert-danger" align="center"> reserved  </td><?php
				}
				else
				{
					if($today<=$day)
					{
					
					?> <td class="alert-info" > <a href="#" onClick="do_app_book('<?=$day?>',<?=$advisor_id?>,<?=$student_id?>,<?=$i?>)"> Book </a> </td> <?php
					}
					else
					{
						?><td bgcolor="#948E8F" align="center"> x  </td><?php
						
					}
				}
					
				
			}
			?>
          </tr>
    <?php 
			 }
}
       
       ?>
				
 
         
 
			 
        
			  
          </tbody>
        
      </table>
      
        
        <?php
		
	}
	
	
	
    
}


if(isset($_GET[advisor_Approval]) &&$_GET[advisor_Approval]==1&&$_GET[form_id]!='' )
{
	extract($_GET) ; 
	
	if(mysql_query("UPDATE `forms` SET `advisor_note` = '".$advisor_note."', `form_status_id` = '2', `modified_by` = '".$_SESSION[CurrentUserId]."', `modified_date` = NOW() WHERE `form_id` = ".$form_id." "))
	{
			$sql = "select * from  forms f inner join form_types ft on ft.form_type_id = f.form_type_id
					
			 where `form_id` = ".$form_id ;
			$r = mysql_query($sql) ;  
			$q = mysql_fetch_array($r) ;
			
			$subject =  $q[form_type_name].' Approval' ; 
			$message =  'Your '  .$q[form_type_name].' form no #'.$form_id.'# is approved by your advisor , and waiting approval from admin. ' ;
			mysql_query("INSERT INTO `notifications` (`notification_id`, `user_id`, `n_date`, `subject`, `message`, `is_readed`) 
					VALUES (NULL, '".$q[created_by]."', NOW(), '".$subject."', '".$message."', '0')" ) ; 
				
				
			$admin_subject =  $q[form_type_name].' Waiting for your Approval' ; 
			$admin_message =  'The '  .$q[form_type_name].' form no #'.$form_id.'# is approved by your advisor , and waiting for your approval. ' ;		
			mysql_query("INSERT INTO `notifications` (`notification_id`, `user_id`, `n_date`, `subject`, `message`, `is_readed`) 
					VALUES (NULL, '1', NOW(), '".$admin_subject."', '".$admin_message."', '0')" ) ; 
		echo "Approved!" ; 
	}
	else
	echo "Error in Approval!" ;  ;  
	    
	
}

if(isset($_GET[advisor_DisApproval]) &&$_GET[advisor_DisApproval]==1&&$_GET[form_id]!='' )
{
	extract($_GET) ; 
	
	if(mysql_query("UPDATE `forms` SET `advisor_note` = '".$advisor_note."', `form_status_id` = '4', `modified_by` = '".$_SESSION[CurrentUserId]."', `modified_date` = NOW() WHERE `form_id` = ".$form_id." "))
	{
			$sql = "select * from  forms f inner join form_types ft on ft.form_type_id = f.form_type_id
					
			 where `form_id` = ".$form_id ;
			$r = mysql_query($sql) ;  
			$q = mysql_fetch_array($r) ;
			
			$subject =  $q[form_type_name].' Disapprove' ; 
			$message =  'Your '  .$q[form_type_name].' form no #'.$form_id.'# is disapproved by your advisor. ' ;
			mysql_query("INSERT INTO `notifications` (`notification_id`, `user_id`, `n_date`, `subject`, `message`, `is_readed`) 
					VALUES (NULL, '".$q[created_by]."', NOW(), '".$subject."', '".$message."', '0')" ) ; 
		echo "Disapproved!" ; 
	}
	else
	echo "Error in Disapproval" ;  ;  
	    
	
}




if(isset($_GET[admin_Approval]) &&$_GET[admin_Approval]==1&&$_GET[form_id]!='' )
{
	extract($_GET) ; 
	
	 
	
	$sf = "select   modified_by as advisor_id from  forms  where `form_id` = ".$form_id  ; 
	$qf = mysql_fetch_array(mysql_query($sf)) ; 
	$advisor_user_id = $qf[advisor_id] ; 
	$sql_update_form = "UPDATE `forms` SET `admin_note` = '".$admin_note."', `form_status_id` = '3', `modified_by` = '".$_SESSION[CurrentUserId]."', `modified_date` = NOW() WHERE `form_id` = ".$form_id ; 
	
	
	if(mysql_query($sql_update_form))
	{
			
			
			$sql = "select * from forms f 
						inner join form_types ft on ft.form_type_id = f.form_type_id 
						inner JOIN users u on u.user_id = f.created_by
						where `form_id` =".$form_id ;
			
			$r = mysql_query($sql) ;  
			$q = mysql_fetch_array($r) ;
			
			$student_id = get_by_id('users' , "student_id" , "user_id" , $q[created_by]) ; 
			
			if($form_type_id==3)			
				mysql_query("update enroll_course set status_id = 1   where form_id=".$form_id) ;
			else  if( $form_type_id==4 )			
				mysql_query("delete from  enroll_course  where course_id in (".$q[course_ids].") and student_id=".$student_id) ;
			else  if($form_type_id==1)
			{
			 $sql_update_enroll = "update enroll_course set status_id = 3  , form_id=".$form_id."  where course_id in (" . $q[course_ids] .") and student_id =" . $student_id  ; 
			
			 
			mysql_query($sql_update_enroll);
			
				$sql_d = "select  DISTINCT course_id from  enroll_course where status_id = 3 and form_id=".$form_id ; 
				$r_d = mysql_query($sql_d) ;
				while($qd=mysql_fetch_array($r_d))
				{
					mysql_query("INSERT INTO `droped_courses` (`drop_id`, `course_id`, `agenda_id`, `semester_id`, `student_id`, `drop_date`) 
						VALUES (NULL, '".$qd[course_id]."','".$_SESSION[current_agenda_id]."', '".$_SESSION[current_semester_id]."', '".$student_id."', NOW());") ; 
						 
					
				}
				
			}
			
			else if($form_type_id==2)
			{
				$student_id = get_by_id("users","student_id" , "user_id" ,$q[created_by]) ;  
				
				mysql_query("delete from  enroll_course  where agenda_id=".$_SESSION[current_agenda_id]." and semester_id = ".$_SESSION[current_semester_id]." and student_id=".$student_id) ;
				
				mysql_query("INSERT INTO `droped_semesters` (`drop_id`, `agenda_id`, `semester_id`, `student_id`, `drop_date`) 
						VALUES (NULL, '".$_SESSION[current_agenda_id]."', '".$_SESSION[current_semester_id]."', '".$student_id."', NOW());") ; 
				
			}
			
			
			
			$subject =  $q[form_type_name].' Approval' ; 
			$message =  'Your '  .$q[form_type_name].' form no #'.$form_id.'# is approved by the deanship of adminstration and registration. ' ;
			mysql_query("INSERT INTO `notifications` (`notification_id`, `user_id`, `n_date`, `subject`, `message`, `is_readed`) 
					VALUES (NULL, '".$q[created_by]."', NOW(), '".$subject."', '".$message."', '0')" ) ; 
					
					
			$subject2 =  $q[form_type_name].' Approval' ; 
			$message2 =  'The '  .$q[form_type_name].' form no #'.$form_id.'# is approved by the deanship of adminstration and registration. ' ;
			mysql_query("INSERT INTO `notifications` (`notification_id`, `user_id`, `n_date`, `subject`, `message`, `is_readed`) 
					VALUES (NULL, '".$advisor_user_id."', NOW(), '".$subject2."', '".$message2."', '0')" ) ; 
		echo "Approved!" ; 
	}
	else
	echo "Error in Approval!" ;    
	    
	
}


if(isset($_GET[admin_DisApproval]) &&$_GET[admin_DisApproval]==1&&$_GET[form_id]!='' )
{
	extract($_GET) ; 
	
	$sf = "select modified_by as advisor_id from  forms  where `form_id` = ".$form_id  ; 
	$qf = mysql_fetch_array(mysql_query($sf)) ; 
	$advisor_user_id = $qf[advisor_id] ; 
	
	if(mysql_query("UPDATE `forms` SET `admin_note` = '".$admin_note."', `form_status_id` = '4', `modified_by` = '".$_SESSION[CurrentUserId]."', `modified_date` = NOW() WHERE `form_id` = ".$form_id." "))
	{
						
			mysql_query("update enroll_course set status_id = 6   where form_id=".$form_id) ; 
			
			$sql = "select * from  forms f inner join form_types ft on ft.form_type_id = f.form_type_id
					
			 where `form_id` = ".$form_id ;
			$r = mysql_query($sql) ;  
			$q = mysql_fetch_array($r) ;
			
			$subject =  $q[form_type_name].' Disapprove' ; 
			$message =  'Your '  .$q[form_type_name].' form no #'.$form_id.'# is disapproved by the deanship of adminstration and registration. ' ;
			mysql_query("INSERT INTO `notifications` (`notification_id`, `user_id`, `n_date`, `subject`, `message`, `is_readed`) 
					VALUES (NULL, '".$q[created_by]."', NOW(), '".$subject."', '".$message."', '0')" ) ; 
					
					
			$subject2 =  $q[form_type_name].' Disapprove' ; 
			$message2 =  'The '  .$q[form_type_name].' form no #'.$form_id.'# is disapproved by the deanship of adminstration and registration. ' ;
			mysql_query("INSERT INTO `notifications` (`notification_id`, `user_id`, `n_date`, `subject`, `message`, `is_readed`) 
					VALUES (NULL, '".$advisor_user_id."', NOW(), '".$subject2."', '".$message2."', '0')" ) ; 
		echo "Disapproved!" ; 
	}
	else
	echo "Error in Disapproval!" ;    
	    
	
}





if(isset($_GET[get_count_drop_course]) &&$_GET[get_count_drop_course]==1 )
{
	$couses_id = 	$_GET[couses_id] ; 
	$where = " where student_id=".$_SESSION["current_student_id"]    ; 
	$count  = get_count('droped_courses' , $where)	 ; 
	echo $count ; 
	
}




if(isset($_GET[drop_semester]) &&$_GET[drop_semester]==1)
{
	
	 
	extract($_POST) ; 
				$s_form = " INSERT INTO `forms` 
										(`form_id`, `created_by`, `created_date`, `form_type_id`, `course_ids`, `semester_id`, 
										`student_note`, `advisor_note`, `admin_note`, `form_status_id`, `modified_by`, `modified_date`) 
								VALUES (NULL, '".$_SESSION[CurrentUserId]."', NOW(), '".$hf_form_type_id."', '', 
								'".$_SESSION[current_semester_id]."', '".$student_note."', '', '', '1', '', '')" ; 
		
		
		if(mysql_query($s_form))
		{
						
				$q_form_id = mysql_fetch_array(mysql_query("select max(form_id) as form_id  from forms")) ; 
				$form_id = $q_form_id[form_id] ; 
				
				
				
			$adv_subject =  ' Drop semester form waiting your approval' ; 
			$adv_message =  'The Drop semester form no #'.$form_id.'# is waiting for your approval. ' ;		
			mysql_query("INSERT INTO `notifications` (`notification_id`, `user_id`, `n_date`, `subject`, `message`, `is_readed`) 
					VALUES (NULL, '".$_SESSION["st_advisor_user_id"]."', NOW(), '".$adv_subject."', '".$adv_message."', '0')" ) ; 
				
				$upload_File = "" ; 
		
			if (!empty($_FILES['file_att']['name'])) 
				$upload_File = upload_file("upfiles",$file_att) ; 
			else
				$upload_File = "" ;
				
			if($upload_File != "")
				mysql_query("INSERT INTO `form_files` (`form_file_id`, `form_id`, `file_url`) VALUES (NULL, '".$form_id."', '".$upload_File."')") ; 
				
				
			echo '1|Your form number is: '.$form_id.'.  This form has been sent to your academic advisor ' ; 				
			
		}
		else 
		echo '0|Error in database'  ;  
				
				
		
			
	
	exit ; 
}



if(isset($_GET[del_courses]) &&$_GET[del_courses]==1&&$_GET[couses_id]!='' )
{
	
	 // print_r($_POST) ; exit  ; 
	extract($_POST) ; 
	
	
		$selected_array = 	explode(',',$_GET[couses_id]) ; 
		
		$system_note = '' ; 
		$sql = "select * from courses where course_id in (".$_GET[couses_id].") " ; 
		$RESULT = mysql_query($sql) ;
		while ($q=mysql_fetch_array($RESULT))
				{
									 
					if($q['co-requisite_courses_ids']!='') 
						{
							$co_array = 	explode(',',$q['co-requisite_courses_ids']) ; 
							for($i=0;$i< count($co_array);$i++)
							{
								$where  = " where student_id = ".$student_id . " and course_id = " . $co_array[$i] . " and status_id = 2" ; 
								if(get_count("enroll_course",$where)==0 )
								{
									if (!(in_array($co_array[$i], $selected_array))) 
									{
										$system_note .=' Student must choose '
												.get_by_id("courses", 'course_name' , 'course_id' , $co_array[$i]) 
												. ' with ' . $q[course_name] .'<br>'  ; 
									}
								}
								 
							}
						
						}
					
				} 
				
			
				
				
				
				$s_form = " INSERT INTO `forms` 
										(`form_id`, `created_by`, `created_date`, `form_type_id`, `course_ids`, `semester_id`, 
										`student_note`, `advisor_note`, `admin_note`, `system_note`, `form_status_id`, `modified_by`, `modified_date`) 
								VALUES (NULL, '".$_SESSION[CurrentUserId]."', NOW(), '".$hf_form_type_id."', '".$_GET[couses_id]."', 
								'".$_SESSION[current_semester_id]."', '".$student_note."', '', '', '".$system_note."', '1', '', '')" ; 
		
		
		if(mysql_query($s_form))
		{
						
				$q_form_id = mysql_fetch_array(mysql_query("select max(form_id) as form_id  from forms")) ; 
				$form_id = $q_form_id[form_id] ; 
				
				$adv_subject =  ' Delete courses form waiting your approval' ; 
			$adv_message =  'The delete courses form no #'.$form_id.'# is waiting for your approval. ' ;		
			mysql_query("INSERT INTO `notifications` (`notification_id`, `user_id`, `n_date`, `subject`, `message`, `is_readed`) 
					VALUES (NULL, '".$_SESSION["st_advisor_user_id"]."', NOW(), '".$adv_subject."', '".$adv_message."', '0')" ) ; 
					
					
				$upload_File = "" ; 
		
			if (!empty($_FILES['file_att']['name'])) 
				$upload_File = upload_file("upfiles",$file_att) ; 
			else
				$upload_File = "" ;
				
			if($upload_File != "")
				mysql_query("INSERT INTO `form_files` (`form_file_id`, `form_id`, `file_url`) VALUES (NULL, '".$form_id."', '".$upload_File."')") ; 
				
				/*  ---- save survey answers  
				$tbl = '' ; 
				$result = mysql_query("SELECT * FROM `questions` where survey_id=1")	 ; 
		 		while($qq=mysql_fetch_array($result))
				 {
					  $tbl .= '<p> <b> '.$qq[question_text].'</b></p> '  ;
					  if($qq[answer_type_id]==1)
					  {
						  
						 $sql =  "SELECT * FROM `answers_questions` where question_id=".$qq[question_id] ; 
						  $ra  =mysql_query($sql) ; 
						  if($ra)
						  {
							 mysql_query("INSERT INTO `student_answers` (`student_answer_id`, `student_id`, `question_id`, `answer_id`, `answer_text`, `answer_date`, `form_id` , `survey_id`) VALUES (NULL, ".$_SESSION['current_student_id'].", ".$qq[question_id].", ".$_POST['q_'.$qq[question_id]].", NULL, NOW(), ".$form_id." , 1 );") ;  
							 
						  while($qa=mysql_fetch_array($ra))
							{
							
								if($_POST['q_'.$qq[question_id]] == $qa[answer_id])
									$checked = ' checked ' ; 
								else
									$checked = '' ; 
								$tbl .= '<p> &nbsp;&nbsp;&nbsp; <input disabled '. $checked .' type="radio" name="q_'.$qq[question_id].'" value="'.$qa[answer_id].'"> &nbsp;'.$qa[answer_text].' </p> '  ;
							}
						  } 
						  
					  }
					  else if($qq[answer_type_id]==2)
					  {
						  
						   mysql_query("INSERT INTO `student_answers` (`student_answer_id`, `student_id`, `question_id`, `answer_id`, `answer_text`, `answer_date`, `form_id` , `survey_id`) VALUES (NULL, ".$_SESSION['current_student_id'].", ".$qq[question_id].",  NULL,".$_POST['q_'.$qq[question_id]].", NOW(), ".$form_id." ,  1 );") ;  
						  
						  if($_POST['q_'.$qq[question_id]] == 'Yes')
									$checked = ' checked ' ; 
								else
									$checked = '' ; 
						  
						  $tbl .= '<p> &nbsp;&nbsp;&nbsp; <input disabled  '. $checked .' type="radio" name="q_'.$qq[question_id].'" value="Yes"> &nbsp;Yes </p> '  ;
						  
						  if($_POST['q_'.$qq[question_id]] == 'No')
									$checked = ' checked ' ; 
								else
									$checked = '' ; 
						  $tbl .= '<p> &nbsp;&nbsp;&nbsp; <input  disabled  '. $checked .' type="radio" name="q_'.$qq[question_id].'" value="No"> &nbsp;No </p> '  ;
					  }
					  else if($qq[answer_type_id]==3)
					  {
						   mysql_query("INSERT INTO `student_answers` (`student_answer_id`, `student_id`, `question_id`, `answer_id`, `answer_text`, `answer_date`, `form_id` , `survey_id`) VALUES (NULL, ".$_SESSION['current_student_id'].", ".$qq[question_id].",  NULL,".$_POST['q_'.$qq[question_id]].", NOW(), ".$form_id." ,  1);") ;  
						  
						  $tbl .= '<p>  <textarea disabled name="q_'.$qq[question_id].'" > '.$_POST['q_'.$qq[question_id]] .' </textarea> </p> '  ;
					  }
						 
					 
				 }
				*/
				$msg = '' ;   
				if($system_note!='')
				$msg = ' With the following system notes: <br>'.$system_note ; 
				
				echo '1|Your form number is: '.$form_id.'. This form has been sent to your academic advisor'.$msg ; 
				
				
			//	mysql_query("update forms set student_survey='".$tbl."' where form_id=".$form_id) ; 
				
			
		}
		else 
		{
			if($system_note!='')
			 echo '0|Error in database ' . ' <br> System notes: ' . $system_note;
			else
			 echo '0|Error in database ' ; 
		
		}
				
				
		 
		
	
	
	exit ; 
}


if(isset($_GET[drop_courses]) &&$_GET[drop_courses]==1&&$_GET[couses_id]!='' )
{
	
	 // print_r($_POST) ; exit  ; 
	extract($_POST) ; 
	
	
		$selected_array = 	explode(',',$_GET[couses_id]) ; 
		
		$system_note = '' ; 
		$sql = "select * from courses where course_id in (".$_GET[couses_id].") " ; 
		$RESULT = mysql_query($sql) ;
		while ($q=mysql_fetch_array($RESULT))
				{
									 
					if($q['co-requisite_courses_ids']!='') 
						{
							$co_array = 	explode(',',$q['co-requisite_courses_ids']) ; 
							for($i=0;$i< count($co_array);$i++)
							{
								$where  = " where student_id = ".$student_id . " and course_id = " . $co_array[$i] . " and status_id = 2" ; 
								if(get_count("enroll_course",$where)==0 )
								{
									if (!(in_array($co_array[$i], $selected_array))) 
									{
										$system_note .=' Student must choose '
												.get_by_id("courses", 'course_name' , 'course_id' , $co_array[$i]) 
												. ' with ' . $q[course_name] .'<br>'  ; 
									}
								}
								 
							}
						
						}
					
				} 
				
			
				
				
				
				$s_form = " INSERT INTO `forms` 
										(`form_id`, `created_by`, `created_date`, `form_type_id`, `course_ids`, `semester_id`, 
										`student_note`, `advisor_note`, `admin_note`, `system_note`, `form_status_id`, `modified_by`, `modified_date`) 
								VALUES (NULL, '".$_SESSION[CurrentUserId]."', NOW(), '".$hf_form_type_id."', '".$_GET[couses_id]."', 
								'".$_SESSION[current_semester_id]."', '".$student_note."', '', '', '".$system_note."', '1', '', '')" ; 
		
		
		if(mysql_query($s_form))
		{
						
				$q_form_id = mysql_fetch_array(mysql_query("select max(form_id) as form_id  from forms")) ; 
				$form_id = $q_form_id[form_id] ; 
				
				$adv_subject =  ' Drop Courses form waiting your approval' ; 
			$adv_message =  'The drop Courses form no #'.$form_id.'# is waiting for your approval. ' ;		
			mysql_query("INSERT INTO `notifications` (`notification_id`, `user_id`, `n_date`, `subject`, `message`, `is_readed`) 
					VALUES (NULL, '".$_SESSION["st_advisor_user_id"]."', NOW(), '".$adv_subject."', '".$adv_message."', '0')" ) ; 
					
					
				$upload_File = "" ; 
		
			if (!empty($_FILES['file_att']['name'])) 
				$upload_File = upload_file("upfiles",$file_att) ; 
			else
				$upload_File = "" ;
				
			if($upload_File != "")
				mysql_query("INSERT INTO `form_files` (`form_file_id`, `form_id`, `file_url`) VALUES (NULL, '".$form_id."', '".$upload_File."')") ; 
				
				//---- save survey answers  
				$tbl = '' ; 
				$result = mysql_query("SELECT * FROM `questions` where survey_id=1")	 ; 
		 		while($qq=mysql_fetch_array($result))
				 {
					  $tbl .= '<p> <b> '.$qq[question_text].'</b></p> '  ;
					  if($qq[answer_type_id]==1)
					  {
						  
						 $sql =  "SELECT * FROM `answers_questions` where question_id=".$qq[question_id] ; 
						  $ra  =mysql_query($sql) ; 
						  if($ra)
						  {
							 mysql_query("INSERT INTO `student_answers` (`student_answer_id`, `student_id`, `question_id`, `answer_id`, `answer_text`, `answer_date`, `form_id` , `survey_id`) VALUES (NULL, ".$_SESSION['current_student_id'].", ".$qq[question_id].", ".$_POST['q_'.$qq[question_id]].", NULL, NOW(), ".$form_id." , 1 );") ;  
							 
						  while($qa=mysql_fetch_array($ra))
							{
							
								if($_POST['q_'.$qq[question_id]] == $qa[answer_id])
									$checked = ' checked ' ; 
								else
									$checked = '' ; 
								$tbl .= '<p> &nbsp;&nbsp;&nbsp; <input disabled '. $checked .' type="radio" name="q_'.$qq[question_id].'" value="'.$qa[answer_id].'"> &nbsp;'.$qa[answer_text].' </p> '  ;
							}
						  } 
						  
					  }
					  else if($qq[answer_type_id]==2)
					  {
						  
						   mysql_query("INSERT INTO `student_answers` (`student_answer_id`, `student_id`, `question_id`, `answer_id`, `answer_text`, `answer_date`, `form_id` , `survey_id`) VALUES (NULL, ".$_SESSION['current_student_id'].", ".$qq[question_id].",  NULL,".$_POST['q_'.$qq[question_id]].", NOW(), ".$form_id." ,  1 );") ;  
						  
						  if($_POST['q_'.$qq[question_id]] == 'Yes')
									$checked = ' checked ' ; 
								else
									$checked = '' ; 
						  
						  $tbl .= '<p> &nbsp;&nbsp;&nbsp; <input disabled  '. $checked .' type="radio" name="q_'.$qq[question_id].'" value="Yes"> &nbsp;Yes </p> '  ;
						  
						  if($_POST['q_'.$qq[question_id]] == 'No')
									$checked = ' checked ' ; 
								else
									$checked = '' ; 
						  $tbl .= '<p> &nbsp;&nbsp;&nbsp; <input  disabled  '. $checked .' type="radio" name="q_'.$qq[question_id].'" value="No"> &nbsp;No </p> '  ;
					  }
					  else if($qq[answer_type_id]==3)
					  {
						   mysql_query("INSERT INTO `student_answers` (`student_answer_id`, `student_id`, `question_id`, `answer_id`, `answer_text`, `answer_date`, `form_id` , `survey_id`) VALUES (NULL, ".$_SESSION['current_student_id'].", ".$qq[question_id].",  NULL,".$_POST['q_'.$qq[question_id]].", NOW(), ".$form_id." ,  1);") ;  
						  
						  $tbl .= '<p>  <textarea disabled name="q_'.$qq[question_id].'" > '.$_POST['q_'.$qq[question_id]] .' </textarea> </p> '  ;
					  }
						 
					 
				 }
				
				$msg = '' ;   
				if($system_note!='')
				$msg = ' With the following system notes: <br>'.$system_note ; 
				
				echo '1|Your form number is: '.$form_id.'. This form has been sent to your academic advisor'.$msg . ' <br> Student Survey: ' . $tbl; 
				
				
				mysql_query("update forms set student_survey='".$tbl."' where form_id=".$form_id) ; 
				
			
		}
		else 
		{
			if($system_note!='')
			echo '0|Error in database ' . ' <br> System notes: ' . $system_note;
			else
			echo '0|Error in database ' ; 
			 
		
		}
				
				
		 
		
	
	
	exit ; 
}

if(isset($_GET[enroll_courses]) &&$_GET[enroll_courses]==1&&$_GET[couses_id]!='' )
{
	
	 
	extract($_POST) ; 
	
	// - chech 
	$max_credit_hours = get_max_credit_hours($_SESSION["st_GPA"] ) ; 
	$where = " where course_id in (".$_GET[couses_id].") "; 
	
	$sum_selected =  get_sum("courses" ,"credits_hours", $where) ; 	
	$sum_current = $_SESSION[sum_hours] ; 
	$total_hours = $sum_selected + $sum_current ; 
	
	$system_note = '' ; 
	if($total_hours > $max_credit_hours)
	{
		$system_note .=' Student can not enroll all selected courses! The new credit hours exceeds the maximum credit hours allowed based on the student\'s GPA<br>'; 
		 

	}
	
		$selected_array = 	explode(',',$_GET[couses_id]) ; 
		
		
		$sql = "select * from courses where course_id in (".$_GET[couses_id].") " ; 
		$RESULT = mysql_query($sql) ;
		while ($q=mysql_fetch_array($RESULT))
				{
									 
					if($q['co-requisite_courses_ids']!='') 
						{
							$co_array = 	explode(',',$q['co-requisite_courses_ids']) ; 
							for($i=0;$i< count($co_array);$i++)
							{
								$where  = " where student_id = ".$student_id . " and course_id = " . $co_array[$i] . " and status_id = 2" ; 
								if(get_count("enroll_course",$where)==0 )
								{
									if (!(in_array($co_array[$i], $selected_array))) 
									{
										$system_note .='  student must choose '
												.get_by_id("courses", 'course_name' , 'course_id' , $co_array[$i]) 
												. ' with ' . $q[course_name] .'<br>'  ; 
									}
								}
								 
							}
						
						}
						
						
						
					if($q['pre-requisite_courses_ids']!='') 
						{
 
 
 							$pre_requisite = get_c_list($q['pre-requisite_courses_ids']) ; 
							
							$pre_array = 	explode(',',$q['pre-requisite_courses_ids']) ; 
							for($i=0;$i< count($pre_array);$i++)
							{
								$where  = " where student_id = ".$student_id . " and course_id = " . $pre_array[$i] . " and status_id = 2" ; 
								if(get_count("enroll_course",$where)==0 )
								{
									$system_note .='  Student must pass  '
												.get_by_id("courses", 'course_name' , 'course_id' , $pre_array[$i]) 
												. ' before ' . $q[course_name] .'<br>'  ; 	
								}
								
							}
						
						}
					
				} 
				
			
				
				
				
				$s_form = " INSERT INTO `forms` 
										(`form_id`, `created_by`, `created_date`, `form_type_id`, `course_ids`, `semester_id`, 
										`student_note`, `advisor_note`, `admin_note`,`system_note` ,`form_status_id`, `modified_by`, `modified_date`) 
								VALUES (NULL, '".$_SESSION[CurrentUserId]."', NOW(), '".$hf_form_type_id."', '".$_GET[couses_id]."', 
								'".$_SESSION[current_semester_id]."', '".$student_note."', '', '', '".$system_note."','1', '', '')" ; 
		
		
		if(mysql_query($s_form))
		{
						
				$q_form_id = mysql_fetch_array(mysql_query("select max(form_id) as form_id  from forms")) ; 
				$form_id = $q_form_id[form_id] ; 
				
				$adv_subject =  ' Enroll courses form waiting your approval' ; 
			$adv_message =  'The Enroll course form no #'.$form_id.'# is waiting for your approval. ' ;		
			mysql_query("INSERT INTO `notifications` (`notification_id`, `user_id`, `n_date`, `subject`, `message`, `is_readed`) 
					VALUES (NULL, '".$_SESSION["st_advisor_user_id"]."', NOW(), '".$adv_subject."', '".$adv_message."', '0')" ) ; 
					
				
				
				$upload_File = "" ; 
		
			if (!empty($_FILES['file_att']['name'])) 
				$upload_File = upload_file("upfiles",$file_att) ; 
			else
				$upload_File = "" ;
				
			if($upload_File != "")
				mysql_query("INSERT INTO `form_files` (`form_file_id`, `form_id`, `file_url`) VALUES (NULL, '".$form_id."', '".$upload_File."')") ; 
				
				
				
				for($i=0;$i< count($selected_array);$i++)
				{
					$course_id = $selected_array[$i] ; 
					$agenda_id = $_SESSION["current_agenda_id"] ;
					$semester_id = $_SESSION["current_semester_id"] ; 
					$student_id = $_SESSION["current_student_id"] ; 
					
					$sql = "INSERT INTO `enroll_course` 
					(`enroll_course_id`, `agenda_id`, `semester_id`, `course_id`, `student_id`, `enroll_date`, `absence_hours-week4`,
					 `absence_hours-week8`, `absence_hours-week12`, `midterm_degree_1`, `midterm_degree_2`, `fail_attempts`,
					  `dropped_attempts`, `status_id` , `form_id`) 	
					VALUES
					( NULL , ".$agenda_id.", ".$semester_id.", ".$course_id.", ".$student_id.", NOW(), 0, 0, 0, 0, 0, 0, 0, 5 , ".$form_id.")" ; 
					
					mysql_query($sql) ; 
					 
					
				}
				$msg = '' ;   
				if($system_note!='')
				$msg = ' with the following system notes: <br>'.$system_note ; 
				
				echo '1|Your form number is: '.$form_id.'.  This form has been sent to your academic advisor '.$msg . ' <br> System notes: ' . $system_note; 
				
			
		}
		else 
		echo '0|Error in database '  . ' <br> System notes: ' . $system_note;  
				
				
		
		

	
	exit ; 
}



if(isset($_GET[load_notifications]) &&$_GET[load_notifications]==1 )
{
	echo load_notifications($_SESSION[CurrentUserId]) ;
	
	exit ;  
	
}

if(isset($_GET[view_enroll_info]) &&$_GET[view_enroll_info]==1&&$_GET[e_id]>0 )
{
	
	 
	
	$sql = 'SELECT * FROM enroll_course ec 
	  						INNER JOIN courses c on c.course_id = ec.course_id
							INNER JOIN course_status cs on cs.status_id = ec.status_id
							 
							where ec.enroll_course_id = '.$_GET[e_id] ; 
	 
	 $RESULT = mysql_query($sql) ; 
	 $q=mysql_fetch_array($RESULT) ; 
	 
	  $tbl = ' <hr>
	  			<table width="100%" class="table table-striped table-bordered table-hover"  >
                                
                                    <tr><th>Course name</th> <td> '.$q[course_name].'  ( ' . $q[description] . ' ) </td></tr>
									 <tr>   <th>Credit hours </th> <td>'.$q[credits_hours].'</td></tr>
									<tr><th>Status </th> <td>'.$q[status_name].'</td></tr>
									<tr><th>Absence hours by week4	 </th> <td>'.$q["absence_hours-week4"].'</td></tr>
									<tr><th>Absence hours by week8	 </th> <td>'.$q["absence_hours-week8"].'</td></tr>
									<tr><th>Absence hours by week12	 </th> <td>'.$q["absence_hours-week12"].'</td></tr>
									<tr><th>Midterm 1 grade  </th> <td>'.$q[midterm_degree_1].'</td></tr>
									<tr><th>Midterm 2 grade  </th> <td>'.$q[midterm_degree_2].'</td></tr>
									<tr><th>Failure attempts </th> <td>'.$q[fail_attempts].'</td></tr>
									<tr><th>Drop attempts </th> <td>'.$q[dropped_attempts].'</td></tr>
									
								</table>
									' ; 
		 echo $tbl ; 
	exit ;  
	
}

if(isset($_GET[load_degree_form]) &&$_GET[load_degree_form]==1&&$_GET[course_id]>0 )
{
	
	 
	
	$sql = 'SELECT *  ,  (select user_id from users u where u.advisor_id = s.advisor_id LIMIT 1) as st_advisor_user_id
					 ,  (select user_id from users u where u.student_id = s.student_id LIMIT 1) as st_user_id FROM enroll_course ec 
	  						INNER JOIN courses c on c.course_id = ec.course_id
							INNER JOIN students  s on s.student_id = ec.student_id
							 
							where ec.course_id = '.$_GET[course_id] ; 
	//  echo $sql  ; 
	 $RESULT = mysql_query($sql) ; 
	 $tbl = '<form  name="abs_form" id="abs_form" method="post" >
	 
	 
	 <table width="100%" class="table table-striped table-bordered table-hover"  >
	  <tr >
			<th >Student name</th>
			<th>Midterm 1 grade	</th>
			<th>Midterm 2 grade</th>
			 
			
			
									
		</tr>
	 ' ;  
	 while($q=mysql_fetch_array($RESULT) )
	 { 
	 
	  $tbl .= ' 
       <input type="hidden"  name="ecid[]"    value="'.$q[enroll_course_id].'">
	   <input type="hidden"  name="maxh"   id="maxh" value="'.$q["lecture_hours"].'">
	   <input type="hidden"  name="stId_'.$q[enroll_course_id].'"  id="stId_'.$q[enroll_course_id].'" value="'.$q["student_id"].'">
	   <input type="hidden"  name="stName_'.$q[enroll_course_id].'"  id="stName_'.$q[enroll_course_id].'" value="'.$q["student_name"].'">
	   <input type="hidden"  name="coursName_'.$q[enroll_course_id].'"  id="coursName_'.$q[enroll_course_id].'" value="'.$q["course_name"].'">
	    <input type="hidden"  name="advId_'.$q[enroll_course_id].'"  id="advId_'.$q[enroll_course_id].'" value="'.$q["st_advisor_user_id"].'">
		<input type="hidden"  name="st_user_id_'.$q[enroll_course_id].'"  id="st_user_id_'.$q[enroll_course_id].'" value="'.$q["st_user_id"].'">
		
		
		
		<tr class="primary">
		<th>'.$q[student_name].' </th>
	<td><input type="number" min="0"   name="m1_'.$q[enroll_course_id].'"  id="m1_'.$q[enroll_course_id].'" value="'.$q["midterm_degree_1"].'"> </td>
	<td><input type="number" min="0"   name="m2_'.$q[enroll_course_id].'"  id="m2_'.$q[enroll_course_id].'" value="'.$q["midterm_degree_2"].'"> </td>
				
				</tr>
									
								
		' ; 
	 }
	 
	 $tbl .=' 
	 
	  <tr >
			<th>&nbsp;</th>
			<th colspan="3"><button type="button" class="btn btn-info " onClick="save_degree()"> Save  </button>  </th> 
									
		</tr>
	 
	 </table> </form>' ; 
		 echo $tbl ; 
	exit ;  
	
}

if(isset($_GET[save_degree]) &&$_GET[save_degree]==1 )
{

 //print_r($_POST) ; 
extract($_POST) ; 	
$system_note = '' ; 
foreach ($ecid as &$enroll_course_id) {
	
	
	$student_name  =  $_POST['stName_'.$enroll_course_id] ;
	$st_user_id    =  $_POST['st_user_id_'.$enroll_course_id] ;
	$adv_user_id    =  $_POST['advId_'.$enroll_course_id] ;
	$course_name    =  $_POST['coursName_'.$enroll_course_id] ;
			
	
	
	$m1 = $_POST['m1_'.$enroll_course_id] ;
	$m2 = $_POST['m2_'.$enroll_course_id] ; 
	 
    
	 
	
	$sql_abs = "update enroll_course set 
	`midterm_degree_1` = ".$m1 .",
	`midterm_degree_2` = ".$m2 ." 
	 
	where enroll_course_id = ".$enroll_course_id ; 
	
	//echo $sql_abs ; 
	 
	 mysql_query($sql_abs)  ; 
	 
	 
	
}

echo "Entering grades is done ... "   ; 
exit ; 
}

if(isset($_GET[load_absance_form]) &&$_GET[load_absance_form]==1&&$_GET[course_id]>0 )
{
	
	 
	
	$sql = 'SELECT *  ,  (select user_id from users u where u.advisor_id = s.advisor_id LIMIT 1) as st_advisor_user_id
					 ,  (select user_id from users u where u.student_id = s.student_id LIMIT 1) as st_user_id FROM enroll_course ec 
	  						INNER JOIN courses c on c.course_id = ec.course_id
							INNER JOIN students  s on s.student_id = ec.student_id
							 
							where ec.course_id = '.$_GET[course_id] ; 
	//  echo $sql  ; 
	 $RESULT = mysql_query($sql) ; 
	 $tbl = '<form  name="abs_form" id="abs_form" method="post" >
	 
	 
	 <table width="100%" class="table table-striped table-bordered table-hover"  >
	  <tr >
			<th >Student name</th>
			<th>Absence hours by week 4	</th>
			<th>Absence hours by week 8 </th>
			<th>Absence hours by week 12</th> 
			<th>Lecture overall hours</th> 
			
			
									
		</tr>
	 ' ;  
	 while($q=mysql_fetch_array($RESULT) )
	 { 
	 
	  $tbl .= ' 
       <input type="hidden"  name="ecid[]"    value="'.$q[enroll_course_id].'">
	   <input type="hidden"  name="maxh"   id="maxh" value="'.$q["lecture_hours"].'">
	   <input type="hidden"  name="stId_'.$q[enroll_course_id].'"  id="stId_'.$q[enroll_course_id].'" value="'.$q["student_id"].'">
	   <input type="hidden"  name="stName_'.$q[enroll_course_id].'"  id="stName_'.$q[enroll_course_id].'" value="'.$q["student_name"].'">
	   <input type="hidden"  name="coursName_'.$q[enroll_course_id].'"  id="coursName_'.$q[enroll_course_id].'" value="'.$q["course_name"].'">
	    <input type="hidden"  name="advId_'.$q[enroll_course_id].'"  id="advId_'.$q[enroll_course_id].'" value="'.$q["st_advisor_user_id"].'">
		<input type="hidden"  name="st_user_id_'.$q[enroll_course_id].'"  id="st_user_id_'.$q[enroll_course_id].'" value="'.$q["st_user_id"].'">
		
		
		
		<tr class="primary">
		<th>'.$q[student_name].' </th>
	<td><input type="number" onChange="check_val(this.id,this.value , '.$q[lecture_hours].')" min="0" max="'.$q["lecture_hours"].'"  name="n4_'.$q[enroll_course_id].'"  id="n4_'.$q[enroll_course_id].'" value="'.$q["absence_hours-week4"].'"> </td>
	<td><input type="number"  onChange="check_val(this.id,this.value , '.$q[lecture_hours].')" min="0" max="'.$q["lecture_hours"].'"  name="n8_'.$q[enroll_course_id].'"  id="n8_'.$q[enroll_course_id].'" value="'.$q["absence_hours-week8"].'"> </td>
	<td><input type="number"  onChange="check_val(this.id,this.value , '.$q[lecture_hours].')"  min="0" max="'.$q["lecture_hours"].'"  name="n12_'.$q[enroll_course_id].'"  id="n12_'.$q[enroll_course_id].'" value="'.$q["absence_hours-week12"].'"> </td> 
				
				<th>'.$q[lecture_hours].' </th>
				
				</tr>
									
								
		' ; 
	 }
	 
	 $tbl .=' 
	 
	  <tr >
			<th>&nbsp;</th>
			<th colspan="3"><button type="button" class="btn btn-info " onClick="save_abs()"> Save  </button>  </th> 
									
		</tr>
	 
	 </table> </form>' ; 
		 echo $tbl ; 
	exit ;  
	
}
if(isset($_GET[save_abs]) &&$_GET[save_abs]==1 )
{

 //print_r($_POST) ; 
extract($_POST) ; 	
$system_note = '' ; 
foreach ($ecid as &$enroll_course_id) {
	
	
	$student_name  =  $_POST['stName_'.$enroll_course_id] ;
	$st_user_id    =  $_POST['st_user_id_'.$enroll_course_id] ;
	$adv_user_id    =  $_POST['advId_'.$enroll_course_id] ;
	$course_name    =  $_POST['coursName_'.$enroll_course_id] ;
			
	
	
	$n4 = $_POST['n4_'.$enroll_course_id] ;
	$n8 = $_POST['n8_'.$enroll_course_id] ; 
	$n12 = $_POST['n12_'.$enroll_course_id] ; 
    
	$rn4 = ($n4/$maxh) * 100 ;
	$rn8 = ($n8/$maxh) * 100 ;
	$rn12 = ($n12/$maxh) * 100 ;
	
	$sql_abs = "update enroll_course set 
	`absence_hours-week4` = ".$n4 .",
	`absence_hours-week8` = ".$n8 .",
	`absence_hours-week12` = ".$n12 ."
	where enroll_course_id = ".$enroll_course_id ; 
	
	//echo $sql_abs ; 
	 
	if(mysql_query($sql_abs))
	{
		// 4 --> 12 % , 8 --> 19 % , 12 --> 23 %
		
		if($rn12 >= 23)
		{
			$mes_adv = '<b>Urgent:</b> Absence hours percentage is close to 25% of 
<b>('.$student_name.')</b> absence hours in '.$course_name.' is '. $n12 .'  absence percentage is :'. number_format($rn12,2).'%.
' ;  

$ratio = number_format($rn12,2) ; 

$course_name = trim($course_name) ;
$ratio = trim($ratio) ; 
$n12 = trim($n12) ; 
			$mes_st = '<b>Urgent:</b> Absence hours percentage is close to 25%  
 your current absence hours in ('.$course_name.') is '. $n12  .'  absence percentage is :'. number_format($rn12,2).'%.
If you miss ( 25 % ) of the overall lectures you will banned from taking the final exam and you will get an F in this course. 
For more information read the CCIS Academic Advising Guide  <a href="http://ccis.ksu.edu.sa/sites/ccis.ksu.edu.sa/files/imce_images/it_msc-student_guide_2015_final_1.pdf" target="_blank" > Here </a>
<p>
You are advised to do the following:
<br>
1.  Attend all upcoming lectures/labs. <br>
2.  Provide the course instructor with all your official documents that show your absence excuse. (Medical excuse, Sick …etc.) <br>
3.  Book an appointment with your Academic Advisor ( Academic Advisor name) from the Appointments Tab, to explain your reasons and provide you with the help you need. <br>
4.  Answer the following survey please.<a href="#" onClick="load_page(***absance_survey.php?course_name='.$course_name.'&ratio='.$ratio.'&h='.$n12.'***);" > Here </a>

</p>

' ; 


	$subject = 'Absence close to 25% '  ; 	
		$s_st  = "INSERT INTO `notifications` (`notification_id`, `user_id`, `n_date`, `subject`, `message`, `is_readed`) 
					VALUES (NULL, '".$st_user_id."', NOW(), '".$subject."', '".$mes_st."', '0')" ; 
	mysql_query($s_st) ; 
		$s_adv  = 	"INSERT INTO `notifications` (`notification_id`, `user_id`, `n_date`, `subject`, `message`, `is_readed`) 
					VALUES (NULL, '".$adv_user_id."', NOW(), '".$subject."', '".$mes_adv."', '0')"  ; 		
	mysql_query($s_adv) ; 
		
			$system_note .='<br>'.$mes_adv ; 
			
			
		}
		else if($rn8 >= 19)
		{
			
			$mes_adv = '<b>Urgent:</b> Absence hours percentage is close to 25%
<b>'.$student_name.'</b>\'s absence hours in '.$course_name.' is '. $n8 .'  absence percentage is :'. number_format($rn8,2).'%.
' ; 
	$ratio = number_format($rn8,2) ; 
	
	$course_name = trim($course_name) ;
	$ratio = trim($ratio) ; 
	$n8 = trim($n8) ; 
			
			$mes_st = '<b>Urgent:</b> Absence hours percentage is close to 25%  
your current absence hours  in '.$course_name.' is '. $n8  .'  absence percentage is :'. number_format($rn8,2).'%.
If you miss ( 25 % ) of the overall lectures you will banned from taking the final exam and you will get an F in this course. 
For more information read the CCIS Academic Advising Guide  <a href="http://ccis.ksu.edu.sa/sites/ccis.ksu.edu.sa/files/imce_images/it_msc-student_guide_2015_final_1.pdf" target="_blank" > Here </a>
<p>
You are advised to do the following:
<br>
1.  Attend all upcoming lectures/labs. <br>
2.  Provide the course instructor with all your official documents that show your absence excuse. (Medical excuse, Sick …etc.) <br>
3.  Book an appointment with your Academic Advisor ( Academic Advisor name) from the Appointments Tab, to explain your reasons and provide you with the help you need. <br>
4.  Answer the following survey please.<a href="#" onClick="load_page(\'absance_survey.php?course_name='.$course_name.'&ratio='.$ratio.'&h='.$n8.'\');" > Here </a>

</p>

' ; 


	$subject = 'Absence close to 25% '  ; 	
		
	mysql_query("INSERT INTO `notifications` (`notification_id`, `user_id`, `n_date`, `subject`, `message`, `is_readed`) 
					VALUES (NULL, '".$st_user_id."', NOW(), '".$subject."', '".$mes_st."', '0')" ) ; 
					
	mysql_query("INSERT INTO `notifications` (`notification_id`, `user_id`, `n_date`, `subject`, `message`, `is_readed`) 
					VALUES (NULL, '".$adv_user_id."', NOW(), '".$subject."', '".$mes_adv."', '0')" ) ; 
		
		$system_note .='<br>'.$mes_adv ; 	
		}
		else if($rn4 >= 12)
		{
			//student page
			$mes_st = '<b>Urgent:</b> Absence hours percentage is close to 25% (First Warning)
You current absence hours in '.$course_name.' is '. $n4  .'  absence percentage is :'. number_format($rn4,2).'% <br>
If You miss ( 25 % ) of the overall lectures by week 4, you will receive a litter call from the Academic Affair in week 6 regarding your first warning for exceeding 25% of half term. 
For more information read the CCIS Academic Advising Guide  <a href="http://ccis.ksu.edu.sa/sites/ccis.ksu.edu.sa/files/imce_images/it_msc-student_guide_2015_final_1.pdf" target="_blank" > Here </a>
' ; 

$mes_adv = '<b>Urgent:</b> Absence close to 25% (First Warning) of 
'.$student_name.'\'s current absence percentage in course '.$course_name.' is '. number_format($rn4,2) .'.
' ; 
	$subject = 'Absence close to 25% (First Warning)'  ; 	
		
	mysql_query("INSERT INTO `notifications` (`notification_id`, `user_id`, `n_date`, `subject`, `message`, `is_readed`) 
					VALUES (NULL, '".$st_user_id."', NOW(), '".$subject."', '".$mes_st."', '0')" ) ; 
					
	mysql_query("INSERT INTO `notifications` (`notification_id`, `user_id`, `n_date`, `subject`, `message`, `is_readed`) 
					VALUES (NULL, '".$adv_user_id."', NOW(), '".$subject."', '".$mes_adv."', '0')" ) ; 
		
			$system_note .='<br>'.$mes_adv ; 
		}
		
	}
	 
	
}

echo "Done!" . $system_note ; 
}




if(isset($_GET[save_survey]) &&$_GET[save_survey]==1 )
{
	extract($_POST) ; 
	$survey_id = $_GET[survey_id] ; 
	//---- save survey answers  
		$tbl = '' ; 
		$result = mysql_query("SELECT * FROM `questions` where survey_id=".$survey_id)	 ; 
		while($qq=mysql_fetch_array($result))
		 {
			  $tbl .= '<p> <b> '.$qq[question_text].'</b></p> '  ;
			  if($qq[answer_type_id]==1)
			  {
				  
				 $sql =  "SELECT * FROM `answers_questions` where question_id=".$qq[question_id] ; 
				  $ra  =mysql_query($sql) ; 
				  if($ra)
				  {
					 mysql_query("INSERT INTO `student_answers` (`student_answer_id`, `student_id`, `question_id`, `answer_id`, `answer_text`, `answer_date`, `form_id` , `survey_id`) VALUES (NULL, ".$_SESSION['current_student_id'].", ".$qq[question_id].", ".$_POST['q_'.$qq[question_id]].", NULL, NOW(), ".$form_id." , 1 );") ;  
					 
				  while($qa=mysql_fetch_array($ra))
					{
					
						if($_POST['q_'.$qq[question_id]] == $qa[answer_id])
							$checked = ' checked ' ; 
						else
							$checked = '' ; 
						$tbl .= '<p> &nbsp;&nbsp;&nbsp; <input disabled '. $checked .' type="radio" name="q_'.$qq[question_id].'" value="'.$qa[answer_id].'"> &nbsp;'.$qa[answer_text].' </p> '  ;
					}
				  } 
				  
			  }
			  else if($qq[answer_type_id]==2)
			  {
				  
				   mysql_query("INSERT INTO `student_answers` (`student_answer_id`, `student_id`, `question_id`, `answer_id`, `answer_text`, `answer_date`, `form_id` , `survey_id`) VALUES (NULL, ".$_SESSION['current_student_id'].", ".$qq[question_id].",  NULL,".$_POST['q_'.$qq[question_id]].", NOW(), ".$form_id." ,  1 );") ;  
				  
				  if($_POST['q_'.$qq[question_id]] == 'Yes')
							$checked = ' checked ' ; 
						else
							$checked = '' ; 
				  
				  $tbl .= '<p> &nbsp;&nbsp;&nbsp; <input disabled  '. $checked .' type="radio" name="q_'.$qq[question_id].'" value="Yes"> &nbsp;Yes </p> '  ;
				  
				  if($_POST['q_'.$qq[question_id]] == 'No')
							$checked = ' checked ' ; 
						else
							$checked = '' ; 
				  $tbl .= '<p> &nbsp;&nbsp;&nbsp; <input  disabled  '. $checked .' type="radio" name="q_'.$qq[question_id].'" value="No"> &nbsp;No </p> '  ;
			  }
			  else if($qq[answer_type_id]==3)
			  {
				   mysql_query("INSERT INTO `student_answers` (`student_answer_id`, `student_id`, `question_id`, `answer_id`, `answer_text`, `answer_date`, `form_id` , `survey_id`) VALUES (NULL, ".$_SESSION['current_student_id'].", ".$qq[question_id].",  NULL,".$_POST['q_'.$qq[question_id]].", NOW(), ".$form_id." ,  1);") ;  
				  
				  $tbl .= '<p>  <textarea disabled name="q_'.$qq[question_id].'" > '.$_POST['q_'.$qq[question_id]] .' </textarea> </p> '  ;
			  }
				 
			 
		 }	
		 
		 $subject = ' student answers for absence  survey :'.$hf_subject ;   
		  $mes_adv = $tbl ;   
		mysql_query("INSERT INTO `notifications` (`notification_id`, `user_id`, `n_date`, `subject`, `message`, `is_readed`) 
					VALUES (NULL, '".$_SESSION["st_advisor_user_id"] ."', NOW(), '".$subject."', '".$mes_adv."', '0')" ) ; 
					
		echo  ' Yours the following answers sent to your advisor : <br> '.$tbl ; 

exit ; 
}

?>
