<?php 
require_once( "functions.php" );

echo view_notification($_GET[n_id]) ;   


?>

            
                
                
                
                
               
<script>

function view_enroll_info(e_id)
{
	var url= 'ajax_actions.php?view_enroll_info=1&e_id='+e_id ; 
		$.ajax({url: url, success: function(result){
			$('#div_enroll_info').html(result) ; 
		}}); 
	
}
</script>               