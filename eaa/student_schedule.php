<?php 
require_once( "functions.php" );


?>
            <div class="row">
             
                <div class="row">
                <div class="col-lg-11 col-md-10">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="row">
                         <center> <h3> My Schedule  </h3> </center>
                            </div>
                        </div>
                         
                         <div class="panel-body">
                               <?php echo  get_student_schedule($_SESSION["current_student_id"]) ; ?>
                            </div>
                            <div class="panel-footer" id="div_enroll_info">
                               
                            </div>
                         
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