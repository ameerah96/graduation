<?php 
require_once( "functions.php" );
$form_type_id = $_GET["form_type_id"] ; 
$advisor_id = $_SESSION["Current_advisor_id"] ; 

?>
            <div class="row">
                <div class="col-lg-11 col-md-11">
                    <div class="panel panel-info ">
                        <div class="panel-heading">
                            <div class="row">
                         <center> <h3> Forms of <font color="blue" ><?=get_by_id('form_types' , 'form_type_name' , 'form_type_id' , $form_type_id)?>  </font> list  waiting to approve / disapprove</h3> </center>
                            </div>
                        </div>
                         
                         <div class="panel-body">
                               <?php echo get_adv_forms_list($form_type_id ,$advisor_id ) ; ?>
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


function fn_adv_Approval(form_id,form_type_id)
{
	
	 var confirm_message=confirm("Are you sure you want to approve!") ; 
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
	
	var confirm_message=confirm("Are you sure you want to disapprove!");
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