<?php 
require_once( "functions.php" );


?>
<div class="row">
  <div class="col-lg-4 col-md-4">
    <div class="panel panel-primary">
      <div class="panel-heading">
        <div class="row">
          <center>
            <h3>Current enrolled courses </h3>
          </center>
        </div>
      </div>
      <div class="panel-body" id="div_current_list"> <?php echo   get_student_courses_list_by_status($_SESSION["current_student_id"] ,'1,5' ) ; ?> </div>
      <div class="panel-footer" id="div_enroll_info"> </div>
    </div>
  </div>
  <div class="col-lg-8 col-md-8">
    <div class="panel panel-primary">
      <div class="panel-heading">
        <div class="row">
          <center>
            <h3>Course dropping form </h3>
          </center>
        </div>
      </div>
      <div class="panel-body"> <?php echo get_form( $_SESSION["current_student_id"]  , 1) ;  ?> </div>
      <div class="panel-footer" id="div_Possible_courses">
        <?php 
				 echo  '<h4> Note:'.$_SESSION[drop_dates].'</h4>' ;			        
							 /*  if($_SESSION[can_withdraw]==1)
							   echo  get_Possible_courses_drop($_SESSION["current_student_id"]); 
							   else
							   echo  '<h3>'.$_SESSION[drop_dates].'</h3>' ; 
							    */
								
					?>
        <div   id="div_info"> </div>
        <?php
					echo '<h4><span class="label label-primary">Choose a course to be dropped</span></h4>' ; 		   
							    echo  get_Possible_courses_drop($_SESSION["current_student_id"]); 
							   
							   ?>
      </div>
    </div>
  </div>
</div>
<script>

function view_new_hours(ch_id,credits_hours)
{
	var current_val = parseInt($('#hf_total_hours').val()) ; 
	var course_id = $('#'+ch_id).val() ; 
	var origenal_val =  parseInt($('#hf_origenal_hours').val()) 
	
	if ($('#'+ch_id).is(':checked'))
	{
		
		  var group = "input:checkbox[name='selected_courses']";
		   $(group).prop("checked", false);
    		$('#'+ch_id).prop("checked", true);
			
		  current_val  = origenal_val - parseInt(credits_hours) ; 
		  
		  $('#hf_total_hours').val(current_val) ; 
		  
		 
		
		
		var url= 'ajax_actions.php?get_count_drop_course=1' ; 
		$.ajax({url: url, success: function(result){
			if(result == 0)
			{
				 
var message = '<div class="alert alert-info">This is the first time to drop this course. <br> <strong>Update!</strong> Your new credit hours:'+ current_val+'</div>';
				$('#div_info').html(message) ; 
			}
			else
			{
				if(result>=<?=$_SESSION[max_drop_course]?>)
				{
					
					var message = '<div class="alert alert-danger"><strong>You can not drop this course!</strong>  You have droped this course ' + result +' times before.</div>';
				$('#div_info').html(message) ; 
					 
					$('#'+ch_id).removeAttr('checked');
					
				}
				else
				{
				
				var message = '<div class="alert alert-info">You have dropped this course '+ result +' times before/div> <br> <strong>Update!</strong> Your new credit hours:'+ current_val+'</div>';
				$('#div_info').html(message) ; 
				}
			}
			 
		}}); 
	}
	else
	{
		
		
		 $('#'+ch_id).prop("checked", false);
			current_val = origenal_val ; 
		 $('#hf_total_hours').val(current_val) ;
		var message = '<div class="alert alert-info"><strong>Update!</strong> Your new credit hours  : ' + current_val+'.</div>';
	$('#div_info').html(message) ; 
	}

	
	
}

function check_empty()
{
var isFormValid = true;

$(".x").each(function(){
	
	//alert($(this).val()) ; 
    if ($.trim($(this).val()).length == 0){
        $(this).addClass("highlight");
        isFormValid = false;
        $(this).focus();
    }
    else{
        $(this).removeClass("highlight");
    }
});

  return isFormValid;
 }  


function check_answers() {
    var checked = $("#div1 :radio:checked");
    var groups = [];
    $("#div1 :radio").each(function() {
        if (groups.indexOf(this.name) < 0) {
            groups.push(this.name);
        }
    });
    if (groups.length == checked.length) {
      return true;
    }
    else {
        return false ;
    }

}


function get_ckecked() {
                var a = [];
                $(".selected_courses:checked").each(function() {
                    a.push(this.value);
				});
                return a;
            }

function fn_drop_courses()
{
	if(check_empty() && check_answers())
	{
		 
	 
	
	var couses_id = get_ckecked() ; 
	
	 if(couses_id=='')
	 {
		  var message = '<div class="alert alert-danger"><strong>Warning!</strong> You must choose at least one course</div>';
			$('#div_info').html(message) ;
	 }
	 else
	 {
	 
	 
	 	var fd = new FormData($('#req_form')[0])   ; 
		 var url= 'ajax_actions.php?drop_courses=1&couses_id='+couses_id ;  
		  $.ajax({
		  url: url,
		  data: fd,
		  processData: false,
		  contentType: false,
		  type: 'POST',
		  
		  success: function(result){
			  
		 	 //  alert(result) ; 
			  
			  
			 var res = result.split('|');
			  if(res[0]==0)
			 {
				 var message = '<div class="alert alert-danger"><strong>Warning!</strong> ' + res[1]+'.</div>';
				 $('#div_info').html(message) ; 
			 }
			 else
			 {
				  var message = '<div class="alert alert-info">' + res[1]+'.</div>';
				 $('#div_page').html(message) ; 
			 }
			 
		  }
		});
		 
	 }
	}
	else
	{
		alert('You must answer all the questions !') ; 
		return false ; 
	}
}

function view_enroll_info(e_id)
{
	var url= 'ajax_actions.php?view_enroll_info=1&e_id='+e_id ; 
		$.ajax({url: url, success: function(result){
			$('#div_enroll_info').html(result) ; 
		}}); 
	
}
</script> 