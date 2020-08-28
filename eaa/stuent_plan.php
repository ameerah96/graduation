<?php 
require_once( "functions.php" );
?>
<div class="row">
  <div class="col-lg-12">
    <h2 class="page-header"> This Page display  All courses in your Plan  and  current enrolled courses in the current semester</h2>
  </div>
  <!-- /.col-lg-12 --> 
</div>
<div class="row">
  <div class="col-lg-6 col-md-6">
    <div class="panel panel-primary">
      <div class="panel-heading">
        <div class="row">
          <center>
            <h3> My  courses list </h3>
          </center>
        </div>
      </div>
      <div class="panel-body"> <?php echo  get_student_courses_list($_SESSION["current_student_id"]) ; ?> </div>
      <div class="panel-footer" id="div_enroll_info"> </div>
    </div>
  </div>
  <div class="col-lg-6 col-md-6">
    <div class="panel panel-primary">
      <div class="panel-heading">
        <div class="row">
          <center>
            <h3>
              <?=get_by_id('plans' , 'plan_name' , 'plan_id' , $_SESSION["st_plan_id"])?>
              courses list </h3>
          </center>
        </div>
      </div>
      <div class="panel-footer"> <?php echo  get_plan_courses_list($_SESSION["st_plan_id"]) ; ?> </div>
    </div>
  </div>
</div>
<script>

function view_enroll_info(e_id)
{
	var url= 'ajax_actions.php?view_enroll_info=1&e_id='+e_id ; 
		$.ajax({url: url, success: function(result){
			$('#div_enroll_info').html(result) ; 
		}}); 
	
}
</script> 