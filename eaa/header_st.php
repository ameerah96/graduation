<?php

if(!($_SESSION["user_type_id"]==3))
{
	echo "<META HTTP-EQUIV='Refresh' Content='1;URL=login.php'>";	
	exit() ;	
}


?>

<body>
<div id="wrapper">

<!-- Navigation -->
<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
  <div class="navbar-header" >
    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
    </a> </div>
  <!-- /.navbar-header -->
  
  <ul class="nav navbar-top-links navbar-left ">
    <li> <img src="img/logo.jpg" width="250" height="175" alt=""/></li>
    <li>
      <h1> E-ACADEMIC ADVISOR </h1>
    </li>
  </ul>
   
    <ul class="nav navbar-top-links navbar-right">
    <li> <a href="index.php"><i class="fa fa-home" aria-hidden="true"></i> Home </a> </li>
    <li> <a href="#" onClick="load_page('program_plan.php')"><i class="fa fa-folder-open-o fa-fw"></i> Program plan</a> </li>
      <li> <a href="#" onClick="load_page('stuent_plan.php')"><i class="fa fa-folder-open-o fa-fw"></i> My plan</a> </li>
      <li> <a href="#" onClick="load_page('st_forms_history.php')" ><i class="fa fa-form" aria-hidden="true"></i> Forms history </a> </li>
        
      
       
      <li  id="li_notifications" class="dropdown"> 
      
      <?php echo load_notifications($_SESSION[CurrentUserId]) ; ?>
      
      </li>
      <li> <?php echo date("d-m-Y") ?> </li>
    </ul>
 
  <!-- /.navbar-top-links --> 
  <br>
  <br>
  <br>
  <br>
  <br>
  <br>
  <div class="navbar-default sidebar" role="navigation">
    <div class="sidebar-nav navbar-collapse">
      <ul class="nav" id="side-menu">
        <li> <a href="#" onClick="load_page('student_schedule.php')"><i class="fa fa-table  fa-fw"></i> My schedule</a> </li>
        <li> <a href="#" onClick="load_page('student_appointments.php')"><i class="fa fa-clock-o  fa-fw"></i> Appointments</a> </li>
        
        
        <li> <a href="#" onClick="load_page('enroll_course.php')"><i class="fa fa-plus fa-fw"></i> Enroll course</a> </li>
        <li> <a href="#" onClick="load_page('drop_course.php')"><i class="fa fa-times" aria-hidden="true"></i> Drop Course</a> </li>
        <li> <a href="#" onClick="load_page('delete_course.php')"><i class="fa fa-minus   fa-fw"></i> Delete course</a> </li>
        <li> <a href="#" onClick="load_page('drop_semester.php')"><i class="fa fa-trash fa-fw"></i>Drop semester</a> </li>
        <li> <a href="redirectUser.php?action=logout"><i class="fa fa-sign-out fa-fw"></i> Logout</a> </li>
      </ul>
    </div>
    <!-- /.sidebar-collapse --> 
  </div>
</nav>

<script>

setInterval(function (){ load_notifications();}, 60000);

function load_notifications()
{
var url= 'ajax_actions.php?load_notifications=1' ; 
		$.ajax({url: url, success: function(result){
			$('#li_notifications').html(result) ; 
		}}); 	
	
}
</script>