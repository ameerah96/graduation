<?php 
 
 require_once( "functions.php" );
 
 ?>
  
  
  <ul class="nav nav-tabs">
  <li class="active">
  <a data-toggle="tab" href="#tab_info">Student information </a></li>
  <li><a data-toggle="tab" href="#tab_schedule">Student schedule</a></li>
  <li><a data-toggle="tab" href="#tab_courses">Student courses</a></li>
  <li><a data-toggle="tab" href="#tab_plan">Student plan</a></li>
  <li><a data-toggle="tab" href="#tab_forms">Student forms</a></li>
  
  
</ul>

<div class="tab-content">

<div   id="div_info"> </div>
  <div id="tab_info" class="tab-pane fade in active">
    <p>
    <?php echo  get_student_info($_GET[s_id]) ; ?> 
    </p>
  </div>
  <div id="tab_schedule" class="tab-pane fade">
    
    <p><?php echo  get_student_schedule($_GET[s_id]) ; ?></p>
  </div>
  
  <div id="tab_courses" class="tab-pane fade">
     
    <p><?php echo  get_student_courses_list($_GET[s_id]) ; ?></p>
  </div>
  
  
  <div id="tab_plan" class="tab-pane fade">
     
    <p><?php 
		$st_plan_id = get_by_id('students' , 'plan_id' , 'student_id' , $_GET[s_id]) ; 
	echo  get_plan_courses_list($st_plan_id) ; ?></p>
  </div>
  
  <div id="tab_forms" class="tab-pane fade">
     
    <p><?php echo  get_adv_all_forms_for_student($_GET[s_id]) ; ?></p>
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


function fn_adv_Approval(form_id,form_type_id)
{
	
	 var confirm_message=confirm("Are you sure you want to approve") ; 
		if (confirm_message==true)
		{
			var advisor_note = $('#advisor_note'+form_id).val() ; 
			var url= 'ajax_actions.php?advisor_Approval=1&form_id='+form_id+'&advisor_note='+advisor_note+'&form_type_id='+form_type_id
			$.ajax({url: url, success: function(result){
			
			
			var message = '<div class="alert alert-info">'+result+'</div>';
				$('#div_info').html(message) ; 
		}}); 
		}
	
}

function fn_adv_DisApproval(form_id,form_type_id)
{
	
	var confirm_message=confirm("Are you sure you want to disapprove");
		if (confirm_message==true)
		{
	var advisor_note = $('#advisor_note'+form_id).val() ; 
	
	var url= 'ajax_actions.php?advisor_DisApproval=1&form_id='+form_id+'&advisor_note='+advisor_note+'&form_type_id='+form_type_id
		$.ajax({url: url, success: function(result){
			
			 
			var message = '<div class="alert alert-info">'+result+'</div>';
				$('#div_info').html(message) ; 
		}}); 
		}
}


</script>
