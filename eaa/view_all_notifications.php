<?php 
require_once( "functions.php" );


?>
<div class="row">
                <div class="col-lg-11 col-md-11">
                    <div class="panel panel-info ">
                        <div class="panel-heading">
                            <div class="row">
                         <center> <h3> All Notifications</h3> </center>
                            </div>
                        </div>
                         
                         <div class="panel-body">
                            <?php  echo   get_all_notification($_SESSION[CurrentUserId]  ) ;  ?>
                            </div>
                            <div class="panel-footer">
                               
							   
							   
							   
							  
                            </div>
                         
                    </div>
                </div>
                
                
                
                <div class="row">
                
                
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