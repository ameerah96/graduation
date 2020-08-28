<?php 
require_once( "functions.php" );
$form_type_id = $_GET["form_type_id"] ; 
$advisor_id = $_SESSION["Current_student_id"] ; 

?>
            <div class="row">
                <div class="col-lg-11 col-md-11">
                    <div class="panel panel-info ">
                        <div class="panel-heading">
                            <div class="row">
                         <center> <h3> Forms of <font color="blue" ><?=get_by_id('form_types' , 'form_type_name' , 'form_type_id' , $form_type_id)?>  </font> list </h3> </center>
                            </div>
                        </div>
                         
                         <div class="panel-body">
                               <?php echo get_st_forms_list_h($form_type_id ,$advisor_id ) ; ?>
                            </div>
                            <div class="panel-footer">
                              <div   id="div_info"> </div>
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