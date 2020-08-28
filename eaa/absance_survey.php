<?php 
require_once( "functions.php" );


?>
<style>

.highlight
{
    border: 1px solid red !important;
}
</style>
<div class="row">
<div class="col-lg-11 col-md-11">
  <form  name="abs_form" id="abs_form" method="post" >
    <div class="panel panel-info ">
      <div class="panel-heading">
        <div class="row">
          <center>
            <h3> Absence survey</h3>
          </center>
        </div>
      </div>
      <div class="panel-body" id="s_body">
        <?php  
						$mes = '<b>Urgent:</b> Absence hours percentage is close to 25% of 
  absence hours in '.$_GET[course_name].' is '. $_GET[h] .'  absence percentage is :'. $_GET[ratio].'%.
' ;  	
							
							$subject = ' absence hours in '.$_GET[course_name].' is '. $_GET[h] .'  absence percentage is :'. $_GET[ratio].'%.
' ;  	
							echo '<div class="alert alert-danger">'. $mes.'</div><br>' ;
							 
							echo get_survey_q(2) ; 
							
							  ?>
      </div>
      <div class="panel-footer">
      <input type="hidden" value="<?=$subject?>" name="hf_subject" id="hf_subject">
        <input type="button"    value="Save"  name="form_submit_btn" id="form_submit_btn"  class="btn btn-primary" >
      </div>
    </div>
  </form>
</div>
<div class="row"> </div>
<script>

function view_enroll_info(e_id)
{
	var url= 'ajax_actions.php?view_enroll_info=1&e_id='+e_id ; 
		$.ajax({url: url, success: function(result){
			$('#div_enroll_info').html(result) ; 
		}}); 
	
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


$('#form_submit_btn').click(function(){
	
	if(check_empty() && check_answers())
	{
		var fd = new FormData($('#abs_form')[0])   ; 
		 var url= 'ajax_actions.php?save_survey=1&survey_id=2' ;  
		  $.ajax({
		  url: url,
		  data: fd,
		  processData: false,
		  contentType: false,
		  type: 'POST',
		  
		  success: function(result){
			  
		 	  $('#s_body').html(result) ; 
			
		  }
		});
	}
	else
	{
		alert('You must answer all the questions !') ; 
		return false ; 
		
	}
	
	
	});



</script> 