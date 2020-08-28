<?php 
session_start() ;
include "common_db.inc";
error_reporting(0);
$link_id = db_connect();
if(!$link_id) die(sql_error());




 function get_survey_q($survey_id)
 {
	$qs = mysql_fetch_array(mysql_query("SELECT * FROM `survey` where survey_id=".$survey_id)) ; 
	$tbl = '<div class="panel panel-primary">
                        <div class="panel-heading">
                            '.$qs[survey_name].'
                        </div>
						<div class="panel-footer">
                             '.$qs[survey_description].'
                        </div>
                        <div class="panel-body" id="div1">
                            ' ; 
	 
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
			  while($qa=mysql_fetch_array($ra))
	 			{
					$tbl .= '<p> &nbsp;&nbsp;&nbsp; <input required    type="radio" name="q_'.$qq[question_id].'" id="q_'.$qq[question_id].'" value="'.$qa[answer_id].'"> &nbsp;'.$qa[answer_text].' </p> '  ;
				}
			  } 
			  
		  }
		  else if($qq[answer_type_id]==2)
		  {
			  $tbl .= '<p> &nbsp;&nbsp;&nbsp; <input  required   type="radio" name="q_'.$qq[question_id].'" value="Yes"> &nbsp;Yes </p> '  ;
			  $tbl .= '<p> &nbsp;&nbsp;&nbsp; <input required   type="radio" name="q_'.$qq[question_id].'" value="No"> &nbsp;No </p> '  ;
		  }
		  else if($qq[answer_type_id]==3)
		  {
			  $tbl .= '<p>  <textarea name="q_'.$qq[question_id].'" class="form-control x" required > </textarea> </p> '  ;
		  }
		     
		 
	 }
							
							
      $tbl .= '	</div> 
	  		  </div>' ;  
			  
	  return $tbl ; 
	 
 }
 		
function createDateRangeArray($strDateFrom,$strDateTo)
{
    date_default_timezone_set('UTC');

    $aryRange=array();

    $iDateFrom=mktime(1,0,0,substr($strDateFrom,5,2),     substr($strDateFrom,8,2),substr($strDateFrom,0,4));
    $iDateTo=mktime(1,0,0,substr($strDateTo,5,2),     substr($strDateTo,8,2),substr($strDateTo,0,4));

    if ($iDateTo>=$iDateFrom)
    {
        array_push($aryRange,date('Y-m-d',$iDateFrom)); // first entry
        while ($iDateFrom<$iDateTo)
        {
            $iDateFrom+=86400; // add 24 hours
			array_push($aryRange,date('Y-m-d',$iDateFrom));
        }
    }
    return $aryRange;
}

function createDateRangeArray_days($strDateFrom,$count_days)
{
    date_default_timezone_set('UTC');

    $aryRange=array();

    $iDateFrom=mktime(1,0,0,substr($strDateFrom,5,2),     substr($strDateFrom,8,2),substr($strDateFrom,0,4));
   

    if ($iDateTo>=$iDateFrom)
     
        array_push($aryRange,date('Y-m-d',$iDateFrom)); // first entry
        while ($count_days > 0 )
        {
            $count_days-- ; 
			$iDateFrom+=86400; // add 24 hours
			array_push($aryRange,date('Y-m-d',$iDateFrom));
        }
     
    return $aryRange;
}



function get_adv_schedual($advisor_id , $noOfDayes)
{
		$today = date("Y-m-d") ;  
		$today =   date("Y-m-d", strtotime($today) );
		 
	 	$dayes = createDateRangeArray_days($today,$noOfDayes) ; 	
	   
	   
		
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
				$sql = "select count(*) as count_app , student_id from appointments  where ap_date ='".$day."' 
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
	
	
	
    	
	
 


function get_all_notification($user_id )
{
	 $sql = 'SELECT * FROM notifications  where user_id='.$user_id.' order by n_date DESC , is_readed ASC ' ;  
		
   $tbl = ' <div class="panel-group" id="accordion"> '  ; 
    
	
	$res = mysql_query($sql) ; 
	while($q=mysql_fetch_array($res) )
	{
		 extract($q);
			
					
		$tbl .='
<div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="panel-title"> 
	  <a data-toggle="collapse" data-parent="#accordion" href="#collapse'.$notification_id.'" aria-expanded="false" class="collapsed">
	  '.$subject.'  <span class="badge">'.$n_date.'</span>   
	  
	  </a> </h4>
    </div>
    <div id="collapse'.$notification_id.'" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
      <div class="panel-body">
	  '.str_replace('***',"'", $message).'
	  
	   </div>
    </div>
  </div>
  ' ; 
		   	
		
		
		
	}
	
$tbl .='</div>	' ; 


  
  echo $tbl ;
 
 
 
 ?>
 
	
	
	
</div>
 <?php
 
   
}

function view_notification($n_id)
{
			mysql_query('update notifications set is_readed = 1   where notification_id ='.$n_id) ;
		  $sql = 'SELECT * FROM notifications  where notification_id ='.$n_id ;  
		  $RESULT = mysql_query($sql) ;
		  $q=mysql_fetch_array($RESULT) ; 
			 
				 $s_list = '<div class="row">
								 
								<div class="col-lg-12">
								 <h1>
								  '. $q[subject] .'    <span class="badge">'.$q[n_date].'</span> 
								 
								</h1>	   
								</div>
								<div class="col-lg-12">
								<p>
								</p>
									<p class="h3"> '. str_replace("***","'", $q[message]) .' </p>    
								</div>
                 
					</div>' ; 	
					 
				
				
		return 	$s_list ; 
	
}



function load_notifications($user_id)
{
	  $where = ' where user_id ='.$_SESSION[CurrentUserId] . ' and is_readed = 0 '  ;  
	   $new_note_count = get_count('notifications' , $where) ;  
	   if($new_note_count>0) 
	   $new_notes = '<button type="button" class="btn btn-info btn-circle">'.$new_note_count.'</button> '  ;  
	   else
	   $new_note_count = ''  ; 
	   
	   $li = '<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bell"></i> 
      '.$new_notes.' </a>
        <ul class="dropdown-menu alert-dropdown">
          '.get_notification_list($user_id).' 
          <li class="divider"></li>
          <li> <a href="#" onClick="load_page(\'view_all_notifications.php\')" >View all</a> </li>
        </ul>' ; 
		
		return $li ; 
	
}


function get_notification_list($user_id)
{
	 $s_list = '' ; 
		  $sql = 'SELECT * FROM notifications  where user_id='.$user_id.' order by n_date DESC , is_readed ASC limit 0,10' ;  
		//  echo $sql ; 
		  $RESULT = mysql_query($sql) ;
				
				while ($q=mysql_fetch_array($RESULT))
				{
					
					 
					
					if($q[is_readed]==0)
					$s_list .='<li class="list-group-item-info">  <a href="#"  onClick="load_page(\'view_notifications.php?n_id='.$q[notification_id].'\')">'.$q[subject].'  <span class="badge">new</span>  </a> </li>' ;
					else
					 
					$s_list .='<li>  <a href="#" onClick="load_page(\'view_notifications.php?n_id='.$q[notification_id].'\')">'.$q[subject].'</a>  </li>' ;
					
					  	
				}
				 
				
		return 	$s_list ; 
	
}
function get_student_info($student_id)
{
	$sql = "select * , (select count(*) from droped_semesters where student_id = ".$student_id.") as droped_semesters , 
						(select count(*) from droped_courses  where student_id = ".$student_id.") as droped_courses  
				from students s 
				inner join advisor a on s.advisor_id = a.advisor_id where s.student_id = ".$student_id ; 
				
	//echo $sql ; 
 
  	 $RESULT = mysql_query($sql) ; 
	 $q=mysql_fetch_array($RESULT) ; 
	  $rem = $_SESSION[max_drop_semesters]  - $q[droped_semesters] ; 
	  $rem_c = $_SESSION[max_drop_course]  - $q[droped_courses] ; 
	  $tbl = '  <h4>
<table width="98%"    border="0"   align="center" >
   <tr>
    <th height="30">Student name : <font color="#2872B3">'.$q[student_name]. '</font> 
    </th>
    <th>Advisor name :<font color="#2872B3"> '.$q[advisor_name]. '</font></th>
    
  </tr>
  <tr>
    <th height="30">ID : <font color="#2872B3">'.$q[student_id].'</font> 
    </th>
      <th> Current semester: <font color="#2872B3"> '.$_SESSION[current_agenda_name]. ' ' . $_SESSION[current_semester_name]. '</font>
      </th>
  </tr>
  <tr>
    <th height="30"> GPA :<font color="#2872B3">'.$q[GPA].'</font></th>
    <th> </th>
  </tr>
  <tr>
    <th height="30">  Level :<font color="#2872B3">'.$q[level_id]. '</font> 
       
    </th>
    <th> </th>
  </tr>
  <tr>
    <th colspan="2"><hr></th>
  </tr>
</table>
								</h4>
								<hr>
									' ; 
	
	return $tbl  ;  
	
	
}




function get_form_type_adv_menu()
{
	/* $sql = "select *  from form_types" ; 
	$r = mysql_query($sql);
	while($q=mysql_fetch_array($r))
	{
		echo '<li><a href="#" onClick="load_page(\'adv_student_form.php?form_type_id='.$q[form_type_id].'\')">'.$q[form_type_name].'</a>  </li>' ; 
		
	
	}
	*/
	?>
    <li> <a href="#" onClick="load_page('adv_student_form.php?form_type_id=3')"><i class="fa fa-plus fa-fw"></i> Enroll course</a> </li>
    <li> <a href="#" onClick="load_page('adv_student_form.php?form_type_id=1')"><i class="fa fa-times" aria-hidden="true"></i> Drop course</a> 
    </li>
    <li> <a href="#" onClick="load_page('adv_student_form.php?form_type_id=4')"><i class="fa fa-minus   fa-fw"></i> Delete course</a> </li>
    <li> <a href="#" onClick="load_page('adv_student_form.php?form_type_id=2')"><i class="fa fa-trash fa-fw"></i>Drop semester</a> </li>
    
        <?php
}

function get_form_type_admin_menu()
{
	/* $sql = "select *  from form_types" ; 
	$r = mysql_query($sql);
	while($q=mysql_fetch_array($r))
	{
		echo '<li><a href="#" onClick="load_page(\'admin_student_form.php?form_type_id='.$q[form_type_id].'\')">'.$q[form_type_name].'</a>  </li>' ; 
		
	
	}
	*/
	
	?>
    <li> <a href="#" onClick="load_page('admin_student_form.php?form_type_id=3')"><i class="fa fa-plus fa-fw"></i> Enroll course</a> </li>
    <li> <a href="#" onClick="load_page('admin_student_form.php?form_type_id=1')"><i class="fa fa-times" aria-hidden="true"></i> Drop course</a> 
    </li>
    <li> <a href="#" onClick="load_page('admin_student_form.php?form_type_id=4')"><i class="fa fa-minus   fa-fw"></i> Delete course</a> </li>
    <li> <a href="#" onClick="load_page('admin_student_form.php?form_type_id=2')"><i class="fa fa-trash fa-fw"></i>Drop semester</a> </li>
    
        <?php
}

function get_admin_forms_list($form_type_id)
{
	$sql = "SELECT * FROM `forms` f 
						INNER JOIN users u on u.user_id = f.`created_by` 
						INNER JOIN students s on s.student_id = u.student_id 
						where `form_type_id` = ".$form_type_id." and `form_status_id` = 2   "  ; 
		
	
	 
   $tbl = ' <div class="panel-group" id="accordion"> '  ; 
    
	
	$res = mysql_query($sql) ; 
	while($q=mysql_fetch_array($res) )
	{
		 extract($q);
			
					
		$tbl .='
<div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="panel-title"> 
	  <a data-toggle="collapse" data-parent="#accordion" href="#collapse'.$form_id.'" aria-expanded="false" class="collapsed">
	 STUDENT ID:<font color="#2872B3"> '.$student_id.' </font> NAME: <font color="#2872B3">'.$student_name.' </font>  DATE: <font color="#2872B3">'.$created_date.' </font> 
	  
	  </a> </h4>
    </div>
    <div id="collapse'.$form_id.'" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
      <div class="panel-body">
	  '.get_admin_form($student_id , $form_type_id , $form_id ,  $student_note , $advisor_note ,  $course_ids , $system_note , $student_survey).'
	  
	   </div>
    </div>
  </div>
  ' ; 
		   	
		
		
		
	}
	
$tbl .='</div>	' ; 


  
  echo $tbl ;
 
 
 
 ?>
 
	
	
	
</div>
 <?php
 
   
}




function get_adv_all_forms_for_student($student_id )
{
	$sql = "SELECT * FROM `forms` f 
						INNER JOIN form_status fs on fs.form_status_id = f.form_status_id 
						INNER JOIN form_types ft on ft.form_type_id = f.form_type_id 
						INNER JOIN users u on u.user_id = f.`created_by` 
						INNER JOIN students s on s.student_id = u.student_id 
						where  s.student_id = ".$student_id ; 
		
	
	 
   $tbl = ' <div class="panel-group" id="accordion"> '  ; 
    
	
	$res = mysql_query($sql) ; 
	while($q=mysql_fetch_array($res) )
	{
		 extract($q);
			
					
		$tbl .='
<div class="panel panel-default">
    <div class="panel-heading">
      <h5 class="panel-title"> 
	  <a data-toggle="collapse" data-parent="#accordion" href="#collapse'.$form_id.'" aria-expanded="false" class="collapsed">
	Form type :<font color="#2872B3"> '.$form_type_name.'   .</font> Form date: <font color="#2872B3">'.$created_date.'. </font> 
	  Form status: <font color="#2872B3">'.$form_status_name.'. </font> 
	  
	  </a> </h5>
    </div>
    <div id="collapse'.$form_id.'" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
      <div class="panel-body">
	  ';
	  
	  
	  if($form_status_id==1)
	  {
		 
		$tbl .=    get_adv_form($student_id , $form_type_id , $form_id ,  $student_note , $course_ids, $system_note  , $student_survey) ;
		  
	  }
	  else
	  {
		  $tbl .= get_form_info($student_id , $form_type , $form_id ,  $student_note , $course_ids , $advisor_note , $admin_note ,  $system_note  , $student_survey);
	  }
	 
	 
	 $tbl .=' 
	   </div>
    </div>
  </div>
  ' ; 
		   	
		
		
		
	}
	
$tbl .='</div>	' ; 


  
  echo $tbl ;
 
 
 
 ?>
 
	
	
	
</div>
 <?php
 
   
}

function get_st_forms_list_h($form_type_id ,$advisor_id  )
{
	$sql = "SELECT * FROM `forms` f 
						INNER JOIN users u on u.user_id = f.`created_by` 
						INNER JOIN students s on s.student_id = u.student_id
						INNER JOIN form_status a on f.form_status_id = a.form_status_id
						where `form_type_id` = ".$form_type_id."   and created_by = ".$_SESSION["CurrentUserId"]; 
		
	
	 
   $tbl = ' <div class="panel-group" id="accordion"> '  ; 
    
	
	$res = mysql_query($sql) ; 
	while($q=mysql_fetch_array($res) )
	{
		 extract($q);
			
					
		$tbl .='
<div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="panel-title"> 
	  <a data-toggle="collapse" data-parent="#accordion" href="#collapse'.$form_id.'" aria-expanded="false" class="collapsed">
	 STUDENT ID:<font color="#2872B3"> '.$student_id.' </font> NAME: <font color="#2872B3">'.$student_name.' </font>  DATE: <font color="#2872B3">'.$created_date.' </font> STATUS: <font color="#2872B3">'.$form_status_name.' </font>
	  
	  </a> </h4>
    </div>
    <div id="collapse'.$form_id.'" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
      <div class="panel-body">
	  '.get_form_info($student_id , $form_type , $form_id ,  $student_note , $course_ids , $advisor_note , $admin_note ,  $system_note  , $student_survey).'
	  
	   </div>
    </div>
  </div>
  ' ; 
		   	
		
		
		
	}
	
$tbl .='</div>	' ; 


  
  echo $tbl ;
 
 
 
 ?>
 
	
	
	
</div>
 <?php
 
   
}
function get_adv_forms_list_h($form_type_id ,$advisor_id  )
{
	$sql = "SELECT * FROM `forms` f 
						INNER JOIN users u on u.user_id = f.`created_by` 
						INNER JOIN students s on s.student_id = u.student_id 
						INNER JOIN form_status a on f.form_status_id = a.form_status_id
						where `form_type_id` = ".$form_type_id."   and s.advisor_id = ".$advisor_id ; 
		
	
	 
   $tbl = ' <div class="panel-group" id="accordion"> '  ; 
    
	
	$res = mysql_query($sql) ; 
	while($q=mysql_fetch_array($res) )
	{
		 extract($q);
			
					
		$tbl .='
<div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="panel-title"> 
	  <a data-toggle="collapse" data-parent="#accordion" href="#collapse'.$form_id.'" aria-expanded="false" class="collapsed">
	 STUDENT ID:<font color="#2872B3"> '.$student_id.' </font> NAME: <font color="#2872B3">'.$student_name.' </font>  DATE: <font color="#2872B3">'.$created_date.' </font> STATUS: <font color="#2872B3">'.$form_status_name.' </font>
	  
	  </a> </h4>
    </div>
    <div id="collapse'.$form_id.'" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
      <div class="panel-body">
	  '.get_form_info($student_id , $form_type , $form_id ,  $student_note , $course_ids , $advisor_note , $admin_note ,  $system_note  , $student_survey).'
	  
	   </div>
    </div>
  </div>
  ' ; 
		   	
		
		
		
	}
	
$tbl .='</div>	' ; 


  
  echo $tbl ;
 
 
 
 ?>
 
	
	
	
</div>
 <?php
 
   
}
function get_adv_forms_list($form_type_id ,$advisor_id  )
{
	$sql = "SELECT * FROM `forms` f 
						INNER JOIN users u on u.user_id = f.`created_by` 
						INNER JOIN students s on s.student_id = u.student_id 
						where `form_type_id` = ".$form_type_id." and `form_status_id` = 1 and s.advisor_id = ".$advisor_id ; 
		
	
	 
   $tbl = ' <div class="panel-group" id="accordion"> '  ; 
    
	
	$res = mysql_query($sql) ; 
	while($q=mysql_fetch_array($res) )
	{
		 extract($q);
			
					
		$tbl .='
<div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="panel-title"> 
	  <a data-toggle="collapse" data-parent="#accordion" href="#collapse'.$form_id.'" aria-expanded="false" class="collapsed">
	 STUDENT ID:<font color="#2872B3"> '.$student_id.' </font> NAME: <font color="#2872B3">'.$student_name.' </font>  DATE: <font color="#2872B3">'.$created_date.' </font> 
	  
	  </a> </h4>
    </div>
    <div id="collapse'.$form_id.'" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
      <div class="panel-body">
	  '.get_adv_form($student_id , $form_type_id , $form_id ,  $student_note , $course_ids , $system_note , $student_survey).'
	  
	   </div>
    </div>
  </div>
  ' ; 
		   	
		
		
		
	}
	
$tbl .='</div>	' ; 


  
  echo $tbl ;
 
 
 
 ?>
 
	
	
	
</div>
 <?php
 
   
}


function view_files($form_id)
{
	$sql = "select *  from form_files where form_id = ".$form_id ; 
  
  	 $RESULT = mysql_query($sql) ; 
	 $files = '' ; 
	 while($qs=mysql_fetch_array($RESULT) )
	{
		$files .= '<a href="upfiles/'.$qs[file_url].'" target="_blank"> '.$qs[file_url].' </a> ' . ' &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;'  ; 
	}	
	return $files ; 
}



function get_admin_form($student_id , $form_type , $form_id ,  $student_note , $advisor_note , $course_ids , $system_note , $student_survey)
{
	$sql = "select * , (select count(*) from droped_semesters where student_id = ".$student_id.") as droped_semesters ,
						(select count(*) from droped_courses where student_id = ".$student_id.") as droped_courses 
				from students s 
				inner join advisor a on s.advisor_id = a.advisor_id where s.student_id = ".$student_id ; 
 
  	 $RESULT = mysql_query($sql) ; 
	 $q=mysql_fetch_array($RESULT) ; 
	 $rem = $_SESSION[max_drop_semesters]  - $q[droped_semesters] ; 
	 $rem_c = $_SESSION[max_drop_course]  - $q[droped_courses] ; 
	 
	  $tbl = '  
	  			<table width="98%"    border="0"   align="center" >
   <tr>
    <th height="30">Student name : <font color="#2872B3">'.$q[student_name]. '</font> 
    </th>
    <th>Advisor name :<font color="#2872B3"> '.$q[advisor_name]. '</font></th>
    
  </tr>
  <tr>
    <th height="30">ID : <font color="#2872B3">'.$q[student_id].'</font> 
    </th>
      <th> Current semester: <font color="#2872B3"> '.$_SESSION[current_agenda_name]. ' ' . $_SESSION[current_semester_name]. '</font>
      </th>
  </tr>
  <tr>
    <th height="30"> GPA :<font color="#2872B3">'.$q[GPA].'</font></th>
    ' ; 
	if($form_type==1)
	{ $tbl .=' <th>Chanced to drop course  are :<font color="#2872B3">'.  $rem_c.'</font></th>' ; }
	else if($form_type==2)
	{
	 $tbl .=' <th>Chanced to drop semesters are :<font color="#2872B3">'.  $rem.'</font></th>' ; 
	}
	
	else
	{
		 $tbl .=' <th></th>' ; 
	}
	
  $tbl .='  
  </tr>
  <tr>
    <th height="30">  Level :<font color="#2872B3">'.$q[level_id]. '</font> 
       
    </th>
   ' ; 
	if($form_type==1)
	{ $tbl .=' <th>Number of droped course  are :<font color="#2872B3">'.  $q[droped_courses].'</font></th>' ; }
	else if($form_type==2)
	{
	 $tbl .=' <th>Number of droped semesters :<font color="#2872B3"> '.$q[droped_semesters]. '</font></th>' ; 
	}
	
	else
	{
		 $tbl .=' <th></th>' ; 
	}
	
  $tbl .='  
  </tr>
									
	<tr>
		<th colspan="2"><hr></th>
		 
	</tr>
	<tr>
	' ; 
									
									if($form_type !=2)
									$tbl .= '	<th colspan="2"><h3> Courses: </h3>
										<br>
											<ul>
												'. get_c_list($course_ids).'
											
											</ul>
											' ; 
									else
									$tbl .= ' <th colspan="2"><h3> Drop Current semester  </h3> '  ; 
									  
									  $tbl .= '
										<hr>
										<b> Some notes: </b>
										
											<ul>
												'. get_by_id( 'form_types' , 'form_type_notes' , 'form_type_id' , $form_type).'
											
											</ul>' ; 
						
						if($student_note!='')
						$tbl .='
										Student note:
						<textarea id="student_note" disabled name="student_note" class="form-control" >'.$student_note.'</textarea>
						<br>
						' ; 
						
						if($system_note!='')
						$tbl .='
						<div class="alert alert-danger"><strong>System notes!</strong> <br> '.$system_note.'</div> '  ; 
						
						if($student_survey!='')
						$tbl .='
						
						<div class="alert alert-info"><strong>Student survey!</strong> <br> '.$student_survey.'</div>
						
						'  ; 
						
						if($advisor_note!='')
						$tbl .='
										Advisor Note:
						<textarea id="student_note" disabled name="advisor_note" class="form-control" >'.$advisor_note.'</textarea> '  ; 
						
						$tbl .='
										<hr>
									<u>Form Files:</u> &nbsp;&nbsp;&nbsp;&nbsp;	'.view_files($form_id).' 
						
						
				<form name="req_form'.$form_id.'" id="req_form'.$form_id.'" enctype="multipart/form-data"  action="">
	  					
				<br>
				Your Note:
				<textarea id="admin_note'.$form_id.'"  name="admin_note'.$form_id.'" class="form-control" ></textarea>
				
				<hr>
<input type="button" value="Approval" name="btn_App" onClick="fn_admin_Approval('.$form_id.' , '.$form_type.')" class="btn btn-success">
<input type="button" value="DisApproval" name="btn_disApp" onClick="fn_admin_DisApproval('.$form_id.' , '.$form_type.')" class="btn btn-danger">
	
				  
				   </form>
										
										
										</th>
									 	 
									</tr>
									
									
								</table>
								<hr>
									' ; 
	
	return $tbl  ;  
	
	
}


function get_form_info($student_id , $form_type , $form_id ,  $student_note , $course_ids,$advisor_note , $admin_note ,$system_note , $student_survey)
{
	$sql = "select * , (select count(*) from droped_semesters where student_id = ".$student_id.") as droped_semesters  ,
						(select count(*) from droped_courses where student_id = ".$student_id.") as droped_courses 
				from students s 
				inner join advisor a on s.advisor_id = a.advisor_id where s.student_id = ".$student_id ; 
 
  	 $RESULT = mysql_query($sql) ; 
	 $q=mysql_fetch_array($RESULT) ; 
	 $rem = $_SESSION[max_drop_semesters]  - $q[droped_semesters] ; 
	 $rem_c = $_SESSION[max_drop_course]  - $q[droped_courses] ; 
	 
	  $tbl = '  
	  			<table width="98%"    border="0"   align="center" >
   <tr>
    <th height="30">Student name : <font color="#2872B3">'.$q[student_name]. '</font> 
    </th>
    <th>Advisor name :<font color="#2872B3"> '.$q[advisor_name]. '</font></th>
    
  </tr>
  <tr>
    <th height="30">ID : <font color="#2872B3">'.$q[student_id].'</font> 
    </th>
      <th> Current semester: <font color="#2872B3"> '.$_SESSION[current_agenda_name]. ' ' . $_SESSION[current_semester_name]. '</font>
      </th>
  </tr>
  <tr>
    <th height="30"> GPA :<font color="#2872B3">'.$q[GPA].'</font></th>
    ' ; 
	if($form_type==1)
	{ $tbl .=' <th>Chanced to drop course  are :<font color="#2872B3">'.  $rem_c.'</font></th>' ; }
	else if($form_type==2)
	{
	 $tbl .=' <th>Chanced to drop semesters are :<font color="#2872B3">'.  $rem.'</font></th>' ; 
	}
	
	else
	{
		 $tbl .=' <th></th>' ; 
	}
	
  $tbl .='  
  </tr>
  <tr>
    <th height="30">  Level :<font color="#2872B3">'.$q[level_id]. '</font> 
       
    </th>
   ' ; 
	if($form_type==1)
	{ $tbl .=' <th>Number of droped course  are :<font color="#2872B3">'.  $q[droped_courses].'</font></th>' ; }
	else if($form_type==2)
	{
	 $tbl .=' <th>Number of droped semesters :<font color="#2872B3"> '.$q[droped_semesters]. '</font></th>' ; 
	}
	
	else
	{
		 $tbl .=' <th></th>' ; 
	}
	
  $tbl .='  
  </tr>						
									<tr>
										<th colspan="2"><hr></th>
									 	 
									</tr>
									<tr>
									' ; 
									
									if($form_type !=2)
									$tbl .= '	<th colspan="2"><h3> Courses: </h3>
										<br>
											<ul>
												'. get_c_list($course_ids).'
											
											</ul>
											' ; 
									else
									$tbl .= ' <th colspan="2"><h3> Drop Current semester  </h3> '  ; 
									  
									  $tbl .= '
										<hr>
										<b> Some notes: </b>
										
											<ul>
												'. get_by_id( 'form_types' , 'form_type_notes' , 'form_type_id' , $form_type).'
											
											</ul>
						' ; 
						if($student_note!='')
						$tbl .='	
										Student note:
						<textarea id="student_note" disabled name="student_note" class="form-control" >'.$student_note.'</textarea>
										<br> '  ; 
							if($system_note!='')
						$tbl .='			
								<div class="alert alert-danger"><strong>System notes!</strong> <br> '.$system_note.'</div> ' ; 
							if($student_survey!='')
						$tbl .='
								<div class="alert alert-info"><strong>Student survey!</strong> <br> '.$student_survey.'</div> ' ; 
								
								
								
								$tbl .='	<u>Form Files:</u> &nbsp;&nbsp;&nbsp;&nbsp;	'.view_files($form_id).' 
						
						
				
				<br> ' ; 
				if($advisor_note!='')
						$tbl .='
				Advisor note  :
				<textarea id="advisor_note'.$form_id.'" disabled name="advisor_note'.$form_id.'" class="form-control" > '.$advisor_note.'</textarea> ' ;  
				
		if($admin_note!='')
						$tbl .='		<br>
				Admin note  :
				<textarea id="advisor_note'.$form_id.'" disabled name="advisor_note'.$form_id.'" class="form-control" > '.$admin_note.'</textarea>
				' ; 
										
					$tbl .='					
										</th>
									 	 
									</tr>
									
									
								</table>
								<hr>
									' ; 
	
	return $tbl  ;  
	
	
}

function get_adv_form($student_id , $form_type , $form_id ,  $student_note , $course_ids , $system_note , $student_survey)
{
	$sql = "select * , (select count(*) from droped_semesters where student_id = ".$student_id.") as droped_semesters  ,
						(select count(*) from droped_courses where student_id = ".$student_id.") as droped_courses  
				from students s 
				inner join advisor a on s.advisor_id = a.advisor_id where s.student_id = ".$student_id ; 
 
  	 $RESULT = mysql_query($sql) ; 
	 $q=mysql_fetch_array($RESULT) ; 
	 $rem = $_SESSION[max_drop_semesters]  - $q[droped_semesters] ; 
	 
	  $tbl = '  
	  			<table width="98%"    border="0"   align="center" >
   <tr>
    <th height="30">Student name : <font color="#2872B3">'.$q[student_name]. '</font> 
    </th>
    <th>Advisor name :<font color="#2872B3"> '.$q[advisor_name]. '</font></th>
    
  </tr>
  <tr>
    <th height="30">ID : <font color="#2872B3">'.$q[student_id].'</font> 
    </th>
      <th> Current semester: <font color="#2872B3"> '.$_SESSION[current_agenda_name]. ' ' . $_SESSION[current_semester_name]. '</font>
      </th>
  </tr>
  <tr>
    <th height="30"> GPA :<font color="#2872B3">'.$q[GPA].'</font></th>
    ' ; 
	if($form_type==1)
	{ $tbl .=' <th>Chanced to drop course  are :<font color="#2872B3">'.  $rem_c.'</font></th>' ; }
	else if($form_type==2)
	{
	 $tbl .=' <th>Chanced to drop semesters are :<font color="#2872B3">'.  $rem.'</font></th>' ; 
	}
	
	else
	{
		 $tbl .=' <th></th>' ; 
	}
	
  $tbl .='  
  </tr>
  <tr>
    <th height="30">  Level :<font color="#2872B3">'.$q[level_id]. '</font> 
       
    </th>
   ' ; 
	if($form_type==1)
	{ $tbl .=' <th>Number of droped course  are :<font color="#2872B3">'.  $q[droped_courses].'</font></th>' ; }
	else if($form_type==2)
	{
	 $tbl .=' <th>Number of droped semesters :<font color="#2872B3"> '.$q[droped_semesters]. '</font></th>' ; 
	}
	
	else
	{
		 $tbl .=' <th></th>' ; 
	}
	
  $tbl .='  
  </tr>						
									<tr>
										<th colspan="2"><hr></th>
									 	 
									</tr>
									<tr>
									' ; 
									
									if($form_type !=2)
									$tbl .= '	<th colspan="2"><h3> Courses: </h3>
										<br>
											<ul>
												'. get_c_list($course_ids).'
											
											</ul>
											' ; 
									else
									$tbl .= ' <th colspan="2"><h3> Drop Current semester  </h3> '  ; 
									  
									  $tbl .= '
										<hr>
										<b> Some notes: </b>
										
											<ul>
												'. get_by_id( 'form_types' , 'form_type_notes' , 'form_type_id' , $form_type).'
											
											</ul>
						' ; 
						
						if($student_note!='')
						$tbl .='					
										Student note:
						<textarea id="student_note" disabled name="student_note" class="form-control" >'.$student_note.'</textarea>
										<br> ' ; 
						if($system_note!='')
						$tbl .='	
									 
										<div class="alert alert-danger"><strong>System notes!</strong> <br> '.$system_note.'</div> ' ; 
						if($student_survey!='')
						$tbl .='
										
										<div class="alert alert-info"><strong>Student survey!</strong> <br> '.$student_survey.'</div> '  ; 
										
						$tbl .='				
										 
									<u>Form Files:</u> &nbsp;&nbsp;&nbsp;&nbsp;	'.view_files($form_id).' 
						
						
				<form name="req_form'.$form_id.'" id="req_form'.$form_id.'" enctype="multipart/form-data"  action="">
	  					
				<br>
				Your Note:
				<textarea id="advisor_note'.$form_id.'"  name="advisor_note'.$form_id.'" class="form-control" ></textarea>
				
				<hr>
<input type="button" value="Approval" name="btn_App" onClick="fn_adv_Approval('.$form_id.' , '.$form_type.')" class="btn btn-success">
<input type="button" value="DisApproval" name="btn_disApp" onClick="fn_adv_DisApproval('.$form_id.' , '.$form_type.')" class="btn btn-danger">
	
				  
				   </form>
										
										
										</th>
									 	 
									</tr>
									
									
								</table>
								<hr>
									' ; 
	
	return $tbl  ;  
	
	
}

function get_form($student_id , $form_type)
{
	$sql = "select * , (select count(*) from droped_semesters where student_id = ".$student_id.") as droped_semesters ,
						(select count(*) from droped_courses where student_id = ".$student_id.") as droped_courses 
				from students s 
				inner join advisor a on s.advisor_id = a.advisor_id where s.student_id = ".$student_id ; 
 
  	 $RESULT = mysql_query($sql) ; 
	 $q=mysql_fetch_array($RESULT) ; 
	 $rem = $_SESSION[max_drop_semesters]  - $q[droped_semesters] ; 
	 $rem_c = $_SESSION[max_drop_course]  - $q[droped_courses] ; 
	 
	  $tbl = '  <form name="req_form" id="req_form" enctype="multipart/form-data"  action="">
	  			<input type="hidden" id="hf_form_type_id" name="hf_form_type_id" value="'.$form_type.'">
	  			<table width="98%"    border="0"   align="center" >
   <tr>
    <th height="30">Student name : <font color="#2872B3">'.$q[student_name]. '</font> 
    </th>
    <th>Advisor name :<font color="#2872B3"> '.$q[advisor_name]. '</font></th>
    
  </tr>
  <tr>
    <th height="30">ID : <font color="#2872B3">'.$q[student_id].'</font> 
    </th>
      <th> Current semester: <font color="#2872B3"> '.$_SESSION[current_agenda_name]. ' ' . $_SESSION[current_semester_name]. '</font>
      </th>
  </tr>
  <tr>
    <th height="30"> GPA :<font color="#2872B3">'.$q[GPA].'</font></th>
	' ; 
	if($form_type==1)
	{ $tbl .=' <th>Chanced to drop course  are :<font color="#2872B3">'.  $rem_c.'</font></th>' ; }
	else if($form_type==2)
	{
	 $tbl .=' <th>Chanced to drop semesters are :<font color="#2872B3">'.  $rem.'</font></th>' ; 
	}
	
	else
	{
		 $tbl .=' <th></th>' ; 
	}
	
  $tbl .='  
  </tr>
  <tr>
    <th height="30">  Level :<font color="#2872B3">'.$q[level_id]. '</font> 
       
    </th>
	
	' ; 
	if($form_type==1)
	{ $tbl .=' <th>Number of droped course  are :<font color="#2872B3">'.  $q[droped_courses].'</font></th>' ; }
	else if($form_type==2)
	{
	 $tbl .=' <th>Number of droped semesters :<font color="#2872B3"> '.$q[droped_semesters]. '</font></th>' ; 
	}
	
	else
	{
		 $tbl .=' <th></th>' ; 
	}
	
  $tbl .='  
	
	
    
  </tr>						
									<tr>
										<th colspan="2"><hr></th>
									 	 
									</tr>
									<tr>
										<th colspan="2"><b> Some notes: </b>
										
											<ul>
												'. get_by_id( 'form_types' , 'form_type_notes' , 'form_type_id' , $form_type).'
											
											</ul>
										<hr>
										why do you want to '. get_by_id( 'form_types' , 'form_type_name' , 'form_type_id' , $form_type) .'
										
										
										? Please write your justification
										<textarea id="student_note" name="student_note" class="form-control" ></textarea>
										<br>
										
										<input type="file" name="file_att" id="file_att" value="" class="form-control"  />
										</th>
									 	 
									</tr>
									
									
								</table>
								<hr>
								
								
			
									' ; 
			$f_s = $form_type ; 
									
			/*
			if($form_type = 4)
				$f_s = 1  ; 
				*/
										
			$sql_su = "SELECT survey_id FROM `survey` where form_type_id=".$f_s." LIMIT 1 " ; 
									
		 	$r_su = mysql_query($sql_su) ;
			$n = mysql_num_rows($r_su) ; 
			
			$surv = '' ; 
			if($n>0)
			{
				$q_su = mysql_fetch_array($r_su) ; 
				$surv = get_survey_q($q_su[survey_id]) ;
				/* if($form_type = 4)
				 {
					$surv = str_replace(' drop ',' delete ' , $surv) ;  
				 }
				 */
				
			}
			$tbl .= $surv ; 
	
	return $tbl  ;  
	
	
}


function get_general_settings()
{
	
	$ss = "SELECT * FROM `settings`" ; 
	$rs = mysql_query($ss) ; 
	while($qs=mysql_fetch_array($rs) )
	{
		$s_name = $qs[setting_name] ; 
		$_SESSION[$s_name] = $qs[setting_value] ; 
	}
	
	
	$sql_agenda = "select * from agenda where is_current_agenda = 1 LIMIT 0,1 " ; 
	$r_agenda = mysql_query($sql_agenda) ; 
	$q_agenda = mysql_fetch_array($r_agenda) ; 

$_SESSION["current_agenda_id"]  = $q_agenda[agenda_id] ;
$_SESSION["current_agenda_name"]  = $q_agenda[agenda_name] ; 

 

$today = strtotime(date("Y-m-d"));

$start_f_semester = strtotime($q_agenda[start_f_semester]);
$end_f_semester = strtotime($q_agenda[end_f_semester]);

 
if($today >= $start_f_semester && $today <= $end_f_semester )
{
	$_SESSION[current_semester_id] = 1  ;  
	
	$start_admission =  strtotime($q_agenda[start_admission_f_semester]);
	$end_admission =  strtotime($q_agenda[end_admission_f_semester]);
	$start_withdraw =  strtotime($q_agenda[start_withdraw_f_semester]);
	$end_withdraw =  strtotime($q_agenda[end_withdraw_f_semester]); 
	
	$_SESSION[admission_dates] = '<font color="red"> you can enroll courses between   '.$q_agenda[start_admission_f_semester].'  and '.$q_agenda[end_admission_f_semester].'  only </font>'  ; 
	
	$_SESSION[drop_dates] = '<font color="red"> you can withdraw courses or drop semester   between   '.$q_agenda[start_withdraw_f_semester].'  and '.$q_agenda[end_withdraw_f_semester].'  only </font>'  ; 
		
}
else
{
	$start_s_semester = strtotime($q_agenda[start_s_semester]);
	$end_s_semester = strtotime($q_agenda[end_s_semester]);
	if($today >= $start_s_semester && $today <= $end_s_semester )
	{
		$_SESSION[current_semester_id] = 2  ;  
		
		$start_admission =  strtotime($q_agenda[start_admission_s_semester]);
		$end_admission =  strtotime($q_agenda[end_admission_s_semester]);
		$start_withdraw =  strtotime($q_agenda[start_withdraw_s_semester]);
		$end_withdraw =  strtotime($q_agenda[end_withdraw_s_semester]); 
		
		$_SESSION[admission_dates] = 'you can enroll or Delete courses between   '.$q_agenda[start_admission_s_semester].'  and '.$q_agenda[end_admission_s_semester].'  only'  ; 
	
	$_SESSION[drop_dates] = 'you can withdraw courses or drop semester   between   '.$q_agenda[start_withdraw_s_semester].'  and '.$q_agenda[end_withdraw_s_semester].'  only'  ; 
			
	}
}

$_SESSION[current_semester_name] = get_by_id("semesters","semester_name","semester_id",$_SESSION[current_semester_id]) ; 

if($today >= $start_admission && $today <= $end_admission)
 	$_SESSION[can_add] = 1  ;
else
	$_SESSION[can_add] = 0  ;
	
if($today >= $start_withdraw && $today <= $end_withdraw)
 	$_SESSION[can_withdraw] = 1  ;
else
	$_SESSION[can_withdraw] = 0  ;
 

	
	
}

function get_max_credit_hours($gpa)
{
	if($gpa >2 && $gpa <=2.50  )
		return 15 ;
	else if($gpa >2.50 && $gpa <=3  )
		return 16 ;
	else if($gpa >3 && $gpa <=3.50  )
		return 17 ;
	else if($gpa >3.50 && $gpa <=4  )
		return 18 ;
	else if($gpa >4 && $gpa <=4.50  )
		return 19 ; 
	else if($gpa >4.50 && $gpa <=5  )
		return 20 ; 
	
}


function get_by_id($TableName , $ColName , $IdName , $IdVal)
  {
		$sql="select $ColName as COLVALUE from $TableName where $IdName = $IdVal ";
		$RESULT = mysql_query($sql) ; 
		$q=mysql_fetch_array($RESULT) ; 
		return $q['COLVALUE'];
	
  }
  
  function get_count($TableName , $where)
  {
		$sql="select count(*) as COLVALUE from $TableName " . $where;
		$RESULT = mysql_query($sql) ; 
		$q=mysql_fetch_array($RESULT) ; 
		return $q['COLVALUE'];
	
  }
   function get_sum($TableName ,$col, $where)
  {
		$sql="select sum(".$col.") as COLVALUE from $TableName " . $where;
		$RESULT = mysql_query($sql) ; 
		$q=mysql_fetch_array($RESULT) ; 
		return $q['COLVALUE'];
	
  }
function get_max($TableName ,$col, $where)
  {
		$sql="select max(".$col.") as COLVALUE from $TableName " . $where;
		$RESULT = mysql_query($sql) ; 
		$q=mysql_fetch_array($RESULT) ; 
		return $q['COLVALUE'];
	
  }
  function get_min($TableName ,$col, $where)
  {
		$sql="select min(".$col.") as COLVALUE from $TableName " . $where;
		$RESULT = mysql_query($sql) ; 
		$q=mysql_fetch_array($RESULT) ; 
		return $q['COLVALUE'];
	
  }


function get_student_courses_list_by_status($student_id , $status_id )
{
	 
	  $sql = 'SELECT * FROM enroll_course ec 
	  						INNER JOIN courses c on c.course_id = ec.course_id
							INNER JOIN course_status cs on cs.status_id = ec.status_id
							 
							where 
							ec.status_id in( '.$status_id . ') 
							and ec.student_id = '.$student_id.'
							order by ec.status_id ' 
							
							; 
	 
	 $RESULT = mysql_query($sql) ; 
	 
	 
	 $tbl = ' <table width="100%" class="table table-striped table-bordered table-hover"  >
                                <thead>
                                    <tr>
									<th> # </th>
									<th>Course name</th>
									<th>credits hours </th>
									<th>status </th>
									
									
									</tr>
								</thead>
								 <tbody>
									' ; 
		 
  
		 
		 		$sum_hours = 0 ;   
				$i = 0 ; 
				while ($q=mysql_fetch_array($RESULT))
				{
					$i++ ;
					$sum_hours += $q[credits_hours]  ; 
					
					$tbl .='<tr>
							<td>'.$i.'</td>
							<td > <a href="#" onClick="view_enroll_info('.$q[enroll_course_id].')" >'.$q[course_name].'
							 </a>
							 '.$q[description].'
							 </td>
							<td>'.$q[credits_hours].'</td>
							<td>'.$q[status_name].'</td>
							
						   </tr>' ; 	
				}
				$tbl .= '
				
				<tr><th colspan=2>Total credits hours: </th> <td colspan=2>'.$sum_hours.'
				<input type="hidden" id="hf_origenal_hours" name="hf_origenal_hours" value="'.$sum_hours.'">
				<input type="hidden" id="hf_total_hours" name="hf_total_hours" value="'.$sum_hours.'">

				</td></tr>
				
				</tbody></table>' ; 
				
				$_SESSION[sum_hours] = $sum_hours ; 
		return 	$tbl ; 
	
}


function get_values_As_Text($TableName , $ColName , $where)
   {
		
		 $sql="SELECT DISTINCT $ColName as val from $TableName " . $where . " order by  $ColName  ";
		
         $Result = mysql_query($sql);
    
        while($q=mysql_fetch_array($Result))
        {             
              $txt .= $q[val].",";
		}   
		$txt = rtrim($txt,",") ; 
		
	
	  return $txt   ;   
   }


function get_day_schedule($day_id , $course_ids)
{
	$sql = " select s.* , c.course_name from sections s
			 inner join  courses c on c.course_id = s.course_id
			where day_id=".$day_id." and s.course_id in(".$course_ids.")
			and agenda_id = ".$_SESSION[current_agenda_id]."  and semester_id = ".$_SESSION[current_semester_id]."
			
			 order by s.start_time " ; 
			 
			 
			 
	$r = mysql_query($sql) ; 
	
	$tbl = '' ;  
	while($q=mysql_fetch_array($r) )
	{
		extract ($q) ; 
		$tbl .= '<b> <font color="#2872B3" size="+1"   >'.$course_name.' </font> </b><b> &nbsp;&nbsp;&nbsp;from:'.$start_time.'&nbsp;&nbsp;&nbsp; to:'
					 .$end_time.'&nbsp;&nbsp;&nbsp;Room:'.$room_no.'</b><hr>' ;  
		
	}
	$tbl = rtrim($tbl,"<hr>'") ; 
	return $tbl ; 
			
	
}




function get_student_appointments($student_id)
{

$tbl = '<div class="table-responsive" >
        <table  class="table table-bordered      "   >
         
          <tr  class="alert-info"  >
          <th> Date </th><th> Time </th> <th> Advisor </th> <th> 
         
          </tr>
          
          
           ' ; 
		
			 $sql = "select a.* , p.p_name , d.advisor_name from appointments a 
				inner join advisor d on d.advisor_id = a.advisor_id
				inner join periods p on p.period_id = a.period_id
				where a.student_id = " .$student_id ;  
		
			//echo $sql ; 
		$result = mysql_query($sql) ; 
			while($row=mysql_fetch_array($result) )
			{
				
				$tbl .= '
                <tr> <td> '.$row[ap_date].' </td><td> '.$row[p_name].' </td> <td> '.$row[advisor_name].' </td> </tr>
                
                ' ; 
				 	
			}
		
		 
		 
            
                
                          
     
       $tbl .= ' </table>
        
    </div>	' ; 
	
	return $tbl ; 

}

function get_student_schedule($student_id)
{
	
	$date = date('d-m-Y');
	$dayofweek = date('w', strtotime($date)) +1 ;
							 
$where = " where student_id=".$student_id." and status_id = 1 "  ;    	 
$course_ids = get_values_As_Text("enroll_course" , "course_id" , $where) ; 
	  
$sql_days = "select * from study_days order by day_id" ; 
$RESULT = mysql_query($sql_days) ; 
	 
	 
	 $tbl = ' <table width="100%" class="table table-striped table-bordered table-hover"  >
                                <thead>
                                    <tr class="info"> <th>#</th>' ; 
		$c = 0 ; 
		while ($q=mysql_fetch_array($RESULT))
				{
					$c++ ; 				
					$tbl .='<th>'.$q[day_name].'</th>' ; 	
				}							
		 		$sum_hours = 0 ;   
				$i = 0 ; 
				
				$tbl .= '<tr><thead>
				' ; 
				
				$min_time = get_min("sections","start_time","") ;
				$max_time = get_max("sections","end_time","") ; 
				
				$min_day = get_min("study_days","day_id","") ;
				$max_day = get_max("study_days","day_id","") ; 
				
				for($t=$min_time ; $t<=$max_time;$t++)
				{
					$tbl .= '<tr>' ; 
					$next_t = $t+1 ;
					$tbl .= '<th class="info"> <b><h4>' . $t.':00 to '.$next_t.':00 </h4></b></th>';
					
					for($d=$min_day ; $d<=$max_day;$d++)
					{
						 
						$sql = " select s.* , c.course_name from sections s
									 inner join  courses c on c.course_id = s.course_id
									where day_id=".$d." and s.course_id in(".$course_ids.")
									and agenda_id = ".$_SESSION[current_agenda_id]."  and semester_id = ".$_SESSION[current_semester_id]."
									and ((   (start_time >= ".$t.") and (start_time < ".$next_t." )) or ((end_time <= ".$next_t." ) and (end_time > ".$t."))  )
									 order by s.start_time " ; 
						$r = mysql_query($sql) ;
						$qs = mysql_fetch_array($r) ; 
						$day_class = '' ; 
						if($dayofweek==$d)
						$day_class = ' class="danger" ' ;
						
						if($qs[course_name]!='')
							$value = '<span class="badge">'. $qs[start_time].':00  '.$qs[end_time].':00	</span><br> 
							
							 <h4>' . $qs[course_name].'</h4>' ; 
							else
							$value = ''  ; 
						
						 $tbl .= '<td '.$day_class.' >'.$value.'</td>';
					
					}
					
					
					
					$tbl .= '</tr>' ; 
					
				}
				
			$tbl .='</table>' ; 	
		return 	$tbl ; 
	
}


function get_student_schedule_old($student_id)
{
	 
$where = " where student_id=".$student_id." and status_id = 1 "  ;    	 
$course_ids = get_values_As_Text("enroll_course" , "course_id" , $where) ; 
	  
$sql_days = "select * from study_days order by day_id" ; 
$RESULT = mysql_query($sql_days) ; 
	 
	 
	 $tbl = ' <table width="100%" class="table table-striped table-bordered table-hover"  >
                                <thead>
                                    <tr>
									<th>Day Name</th>
									<th>Schedule  </th>
									</tr>
								</thead>
								 <tbody>
									' ; 
		 		$sum_hours = 0 ;   
				$i = 0 ; 
				while ($q=mysql_fetch_array($RESULT))
				{
									
					$tbl .='<tr>
							<td > '.$q[day_name].'</td>
							<td>  '.get_day_schedule($q[day_id] , $course_ids).' </td>
							 
						   </tr>' ; 	
				}
				$tbl .= '
				</tbody></table>' ; 
				
		return 	$tbl ; 
	
}



function get_student_courses_list($student_id)
{
	 
	  $sql = 'SELECT * FROM enroll_course ec 
	  						INNER JOIN courses c on c.course_id = ec.course_id
							INNER JOIN course_status cs on cs.status_id = ec.status_id
							 
							where  ec.student_id = '.$student_id ; 
	 
	 $RESULT = mysql_query($sql) ; 
	 
	 
	 $tbl = ' <table width="100%" class="table table-striped table-bordered table-hover"  >
                                <thead>
                                    <tr>
									<th> # </th>
									<th>Course name</th>
									<th>Credits hours </th>
									<th>Status </th>
									
									</tr>
								</thead>
								 <tbody>
									' ; 
		 
  
		 
		 		$sum_hours = 0 ;   
				$i = 0 ; 
				while ($q=mysql_fetch_array($RESULT))
				{
					$i++ ;
					
					if($q[status_id]!=3)
					$sum_hours += $q[credits_hours]  ; 
					
					
					if($q[status_id]==3)
					{
						$class = ' style="background-color:#FD4D52;" ' ; 	
					}
					else
					{
						$class = '' ;  	
					}
					 
                     
					$tbl .='<tr '.$class.' >
							<td>'.$i.'</td>
							<td > <a href="#" onClick="view_enroll_info('.$q[enroll_course_id].')" >'.$q[course_name].'
							 </a>
							 '.$q[description].'
							 </td>
							<td>'.$q[credits_hours].'</td>
							<td>'.$q[status_name].'</td>
						   </tr>' ; 	
				}
				$tbl .= '
				
				<tr><th colspan=2>Total credits hours: </th> <td colspan=2>'.$sum_hours.'</td></tr>
				
				</tbody></table>' ; 
				
		return 	$tbl ; 
	
}

 
 
 
  function get_drop_semester_form($agenda_id , $semester_id)
{
	 
	  $where = " where student_id =".$_SESSION["current_student_id"]   ;  
	 $count_drop = get_count("droped_semesters",$where) ; 
	 $form = '<b><ul> <li> The maximum chance to drop semeter is:<font color="#2872B3">'. $_SESSION[max_drop_semesters].'</font></li>' ; 
	 
	
	 $form .= '<li> You are droped semester <font color="#2872B3">'. $count_drop .'</font> times before </li>' ; 
	 
	 $form .= '</ul>' ; 
	 
	 if($count_drop < $_SESSION[max_drop_semesters])
	$form .= '<p>
				<input type="button" onClick="fn_drop_semester();" value="Drop semester"  name="btn_submit" class="btn btn-primary" >
				 </p>
				</form>
				' ; 
		else
		$form .= '<p>
				  <font color="red">	Your request can not be placed because you have exceeded the limit </font>
				 </p>
				 </b>
				</form>
				' ; 	
		
				
		return 	$form ; 
	
}
 
 function get_Possible_courses_drop($student_id)
{
	 
	  $plan_id =  $_SESSION["st_plan_id"] ; 
	  
	  $sql = 'SELECT * FROM `plan_courses` pc 
							INNER JOIN courses c on c.course_id = pc.course_id 
							where 
							c.course_id  in (select course_id from enroll_course where (status_id = 1 ) and student_id = '.$student_id.' )
							
							
							and pc.plan_id = '.$plan_id ; 
	 
	 $RESULT = mysql_query($sql) ; 
	 
	 
	 $tbl = ' <table width="100%" class="table table-striped table-bordered table-hover"  >
                                <thead>
                                    <tr>
									<th> select </th>
									<th>Course name</th>
									<th>credits hours </th>
									<th>pre-requisite </th>
									<th>co-requisite </th>
									</tr>
								</thead>
								 <tbody>
									' ; 
		 
  
		 
		 		      
				
				while ($q=mysql_fetch_array($RESULT))
				{
					 
					 $check = '<input type="checkbox" value="'.$q[course_id].'" id="ch_'.$q[course_id].'" name="selected_courses" class="selected_courses" onClick="view_new_hours(this.id,'.$q[credits_hours].')">'  ;
					 
					 
					$tbl .='<tr>
							<td> '.$check.'</td>
							<td title="'.$q[description].'">'.$q[course_name].'</td>
							<td>'.$q[credits_hours].'</td>
							<td>'.get_c_list($q['pre-requisite_courses_ids']).'</td>
							<td>'.get_c_list($q['co-requisite_courses_ids']).'</td>
							
							</tr>' ; 	
				}
				$tbl .= '
				
				<tr><td colspan=5> 
				
				<br>
				
				<input type="button" onClick="fn_drop_courses();" value="Drop selected courses"  name="btn_submit" class="btn btn-primary" >
				 </td></tr>
				
				</tbody></table>
				
				
				</form>
				' ; 
				
		return 	$tbl ; 
	
}
 
function get_Possible_courses_list($student_id)
{
	 
	  $plan_id =  $_SESSION["st_plan_id"] ; 
	  
	  $sql = 'SELECT * FROM `plan_courses` pc 
							INNER JOIN courses c on c.course_id = pc.course_id 
							where 
							c.course_id not in (select course_id from enroll_course where (status_id = 1 or status_id = 2 or status_id = 5) and student_id = '.$student_id.' )
							
							
							and pc.plan_id = '.$plan_id ; 
	 
	 $RESULT = mysql_query($sql) ; 
	 
	 
	 $tbl = ' <table width="100%" class="table table-striped table-bordered table-hover"  >
                                <thead>
                                    <tr>
									<th>  </th>
									<th>Course name</th>
									<th>credits hours </th>
									<th>pre-requisite </th>
									<th>co-requisite </th>
									</tr>
								</thead>
								 <tbody>
									' ; 
		 
  
		 
		 		      
				
				while ($q=mysql_fetch_array($RESULT))
				{
									 
					if($q['pre-requisite_courses_ids']!='') 
						{
 $check = '<input type="checkbox" value="'.$q[course_id].'" id="ch_'.$q[course_id].'" name="selected_courses" class="selected_courses" onClick="view_new_hours(this.id,'.$q[credits_hours].')">'  ;
 
 							$pre_requisite = get_c_list($q['pre-requisite_courses_ids']) ; 
							
							$pre_array = 	explode(',',$q['pre-requisite_courses_ids']) ; 
							for($i=0;$i< count($pre_array);$i++)
							{
								$where  = " where student_id = ".$student_id . " and course_id = " . $pre_array[$i] . " and status_id = 2" ; 
								//if(get_count("enroll_course",$where)==0 )
								//$check ='' ; 
							}
						
						}
					else
					{ 
						$pre_requisite = '' ; 
 $check = '<input type="checkbox" value="'.$q[course_id].'" id="ch_'.$q[course_id].'" name="selected_courses" class="selected_courses" onClick="view_new_hours(this.id,'.$q[credits_hours].')">'  ;					}
					 
					 
					$tbl .='<tr>
							<td align="right"> '.$check.'</td>
							<td  align="left" title="'.$q[description].'">'.$q[course_name].'</td>
							<td>'.$q[credits_hours].'</td>
							<td>'.get_c_list($q['pre-requisite_courses_ids']).'</td>
							<td>'.get_c_list($q['co-requisite_courses_ids']).'</td>
							
							</tr>' ; 	
				}
				$tbl .= '
				
				<tr><td colspan=5> 
				<input type="button" onClick="fn_enroll_courses();" value="Enroll  Selected courses"  name="btn_submit" class="btn btn-primary" >
				 </td></tr>
				
				</tbody></table>
				
				</form>
				' ; 
				
		return 	$tbl ; 
	
}
function get_plan_courses_list($plan_id)
{
	 
	  $sql = 'SELECT * FROM plans p 
	  						INNER JOIN `plan_courses` pc on pc.plan_id = p.plan_id 
							INNER JOIN courses c on c.course_id = pc.course_id 
							where p.plan_id = '.$plan_id ; 
	 
	 $RESULT = mysql_query($sql) ; 
	 
	 
	 $tbl = ' <table width="100%" class="table table-striped table-bordered table-hover"  >
                                <thead>
                                    <tr>
									<th> # </th>
									<th>Course name</th>
									<th>credits hours </th>
									<th>pre-requisite </th>
									<th>co-requisite </th>
									</tr>
								</thead>
								 <tbody>
									' ; 
		 
  
		 
		 		$sum_hours = 0 ;   
				$i = 0 ; 
				while ($q=mysql_fetch_array($RESULT))
				{
					$i++ ;
					$sum_hours += $q[credits_hours]  ; 
					
					 
					if($q['pre-requisite_courses_ids']!='') 
					$pre_requisite = get_c_list($q['pre-requisite_courses_ids']) ; 
					else
					 $pre_requisite = '' ; 
					 
					 if($q['co-requisite_courses_ids']!='') 
					$co_requisite = get_c_list($q['co-requisite_courses_ids']) ; 
					else
					 $co_requisite = '' ; 
					 
					 
					$tbl .='<tr>
							<td>'.$i.'</td>
							<td > <a href="#" >'.$q[course_name].'
							 </a>
							 '.$q[description].'
							 </td>
							<td>'.$q[credits_hours].'</td>
							<td>'.$pre_requisite.'</td>
							<td>'.$co_requisite.'</td>
							
							</tr>' ; 	
				}
				$tbl .= '
				
				<tr><th colspan=2>Total credits hours: </th> <td colspan=3>'.$sum_hours.'</td></tr>
				
				</tbody></table>' ; 
				
		return 	$tbl ; 
	
}

function get_c_list($c_list)
{
	 $s_list = '' ; 
		  $sql = 'SELECT  DISTINCT course_name FROM courses where course_id in ('. $c_list.') ' ;  
		//  echo $sql ; 
		  $RESULT = mysql_query($sql) ;
				
				while ($q=mysql_fetch_array($RESULT))
				{
					$s_list .=''.$q[course_name].',' ; 	
				}
				
				$s_list = rtrim($s_list,',') ; 
		return 	$s_list ; 
	
}

function send_mail($to,$subject,$message)
{
	 
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
$headers .= 'From: <info@e-academicadvisor.com>' . "\r\n";
$headers .= 'Cc: shadenmhd@windowslive.com' . "\r\n";

if(mail($to,$subject,$message,$headers))
return true ;   
else
return false ; 	
	
	
}

function myOptions ($id , $displayFiled,$tableName,$val , $where )
{
  

$sql = " SELECT $id , $displayFiled from $tableName  " . $where  . " order by ". $id ;
   echo $sql  ; 
   $r = mysql_query($sql) ; 	 
			 
				while($query_data = mysql_fetch_array($r))
				{             
					 ?>
<option value = '<?=$query_data[$id]?>' <?php if($val== $query_data[$id] ) echo "SELECTED" ; ?> >
<?php
					echo  $query_data[1]; 
					echo" </option>";
				}
}



function get_mail_by_user($user_id)
{
	$sql = ' select email from users where user_id ='.$user_id  ; 
	$r = mysql_query($sql) ; 
	$q =  mysql_fetch_array($r) ;
	return $q[email] ;  	
	
}


function upload_file($dir,$file_att)
{


$types = array("image/png","image/x-png","image/gif","image/jpeg","image/pjpeg","audio/rm","audio/ram","audio/mp3","application/swf");
$fullpath = "$dir/";

//echo "fullpath : ".$fullpath."<br>" ; 

if (!empty($_FILES['file_att']['name'])) {
//echo "file_ext :  ". getFileExt($_FILES["file_att"]["name"]);

$file_type = getFileExt($_FILES["file_att"]["name"]);  

	
	$file_att_tmp_name = $_FILES['file_att']['tmp_name']; 
	$file_att_new_name = $_FILES['file_att']['name']; 
	$file_att_clean_name = substr($file_att_new_name, -4);
	$file_att_date = randomkeys(10);
	$file_att = $file_att_date . $file_att_clean_name;
	
		if(move_uploaded_file($file_att_tmp_name, $fullpath . $file_att))
		{
		
		$file_type = $file_type ; 
		return $file_att ; 
		}
	 else {
		$message  = '<b>Error:</b> ';
		die($message);
		return null ; 
	}
}

}



function randomkeys($length)
{
	$pattern = "1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ";
	for($i=0;$i<$length;$i++) {
		$key .= $pattern{rand(0,35)};
	}
	return $key;
}

function getFileExt($file)
{
    $ext;
    $baseName = basename( $file );
    $dot = strrpos($baseName, '.');
    
    if($dot===false)
    {
       echo "no extension found. ";
       $dot = NULL;
    }
    else
    {
        if(strlen($file)>3)
        {
            $ext = substr($baseName,$dot+1);
        }
    }
    return $ext;
}



function upload_img($dir,$pic)
{



$types = array("image/png","image/x-png","image/gif","image/jpeg","image/pjpeg","audio/rm","audio/ram","audio/mp3","application/swf","swf","SWF");
$fullpath = "$dir/";



if (!empty($_FILES['pic']['name'])) {


	if ($_FILES['pic']['size'] == 0) {
		$message  = '<b>Error:</b> Image (0 byte) <p>&laquo; <a href="javascript:history.go(-1)">Go back!</a></p>';
		die($message);
	} elseif ($_FILES['pic']['size'] > 524288) {
		$message  = '<b>Error:</b> Image (Max.: 512 k.byte)<p>&laquo; <a href="javascript:history.go(-1)">Go back!</a></p>';
		die($message);
	}
	$pic_tmp_name = $_FILES['pic']['tmp_name']; 
	$pic_new_name = $_FILES['pic']['name']; 
	$pic_clean_name = substr($pic_new_name, -4);
	$pic_date = randomkeys(10);
	$pic = $pic_date . $pic_clean_name;
	
		move_uploaded_file($pic_tmp_name, $fullpath . $pic);
		return $pic ; 
		
	
}

}
?>
