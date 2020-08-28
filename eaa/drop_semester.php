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
            <h3>Drop semester Form </h3>
          </center>
        </div>
      </div>
      <div class="panel-body"> <?php echo get_form( $_SESSION["current_student_id"]  , 2) ;  ?> </div>
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
							    echo  get_drop_semester_form($_SESSION["current_agenda_id"] , $_SESSION[current_semester_id]); 
							   
							   ?>
      </div>
    </div>
  </div>
</div>
<script>




function get_ckecked() {
                var a = [];
                $(".selected_courses:checked").each(function() {
                    a.push(this.value);
				});
                return a;
            }

function fn_drop_semester()
{
	
	 	var fd = new FormData($('#req_form')[0])   ; 
		 var url= 'ajax_actions.php?drop_semester=1' ;  
		  $.ajax({
		  url: url,
		  data: fd,
		  processData: false,
		  contentType: false,
		  type: 'POST',
		  
		  success: function(result){
			 var res = result.split('|');
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

function view_enroll_info(e_id)
{
	var url= 'ajax_actions.php?view_enroll_info=1&e_id='+e_id ; 
		$.ajax({url: url, success: function(result){
			$('#div_enroll_info').html(result) ; 
		}}); 
	
}
</script> 