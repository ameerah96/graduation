<?php 
require_once( "functions.php" );


?>
    <script src="js/gijgo.min.js" type="text/javascript"></script>
    <link href="css/gijgo.min.css" rel="stylesheet" type="text/css" />
    
<ul class="nav nav-tabs">
  <li class="active">
  <a data-toggle="tab" href="#tab_a_list">Appointments list</a></li>
  <li><a data-toggle="tab" href="#tab_add">Add appointment</a></li>
  
  
  
</ul>

<div class="tab-content">

<div   id="div_info"> </div>
  <div id="tab_a_list" class="tab-pane fade in active">
    <p>
   <?php echo  get_student_appointments($_SESSION["current_student_id"]) ; ?>
    </p>
  </div>
  <div id="tab_add" class="tab-pane fade">
    
    <p>
  <div class="col-sm-4 col-md-4">  
    <form role="form" id="book_form" name="book_form" method="post" action="" enctype="multipart/form-data" class="form-horizontal">
<input type="hidden" name="advisor_id" id="advisor_id" value="<?=$_SESSION[st_advisor_id]?>">
<input type="hidden" name="st_advisor_user_id" id="advisor_id" value="<?=$_SESSION[st_advisor_user_id]?>">
<input type="hidden" name="student_id" id="student_id" value="<?=$_SESSION[current_student_id]?>">
<div class="col-xs-12">
  <div class="input-field">
    From:
    <br>
    <input type="text" class="form-control" name="date_start" id="date_start" placeholder="mm/dd/yyyy" width="200"/>
    <script>
        $('#date_start').datepicker({
            uiLibrary: 'bootstrap'
        });
    </script>
  </div>
</div>
<div class="col-xs-12">
  <div class="input-field">
    To:
    <br>
    <input type="text" class="form-control" name="date_end" id="date_end" placeholder="mm/dd/yyyy" width="200"/>
    <script>
        $('#date_end').datepicker({
            uiLibrary: 'bootstrap'
        });
    </script>
  </div>
</div>
<div class="col-xs-12">



<br>
  <input type="button" class="btn btn-primary " value="View Schedule" onClick="viw_adv_schedule()">
</div>
</form>
</div>

<div class="col-sm-8 col-md-8" id="div_a_schedule">   

</div> 
    
    </p>
  </div>
  
   
  
   
  
  
</div>
           



           
<script>


 

function do_app_book(ap_date,advisor_id,student_id,period_id)
{
	var url= 'ajax_actions.php?do_app_book=1&ap_date='+ap_date+'&period_id='+period_id+'&advisor_id='+advisor_id+'&student_id='+student_id ; 
		$.ajax({url: url, success: function(result){
			 
			 
			 
			 var message = '<div class="alert alert-info">' + result +'.</div>';
				 $('#div_info').html(message) ; 
				 
				 viw_adv_schedule() ; 
		}}); 
	
}



function viw_adv_schedule()
{
	var fd = new FormData($('#book_form')[0])   ; 
		 var url= 'ajax_actions.php?booking_app=1' ;  
		  $.ajax({
		  url: url,
		  data: fd,
		  processData: false,
		  contentType: false,
		  type: 'POST',
		  
		  success: function(result){
			  
			  $('#div_a_schedule').html(result) ; 
			  
			  }
		});
	
}
</script>               