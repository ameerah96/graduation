 <?php session_start() ; ?>
 <script src="js/gijgo.min.js" type="text/javascript"></script>
    <link href="css/gijgo.min.css" rel="stylesheet" type="text/css" />              
  <div class="col-sm-3 col-md-3">  
 <form role="form" id="book_form" name="book_form" method="post" action="" enctype="multipart/form-data" class="form-horizontal">
<input type="hidden" name="advisor_id" id="advisor_id" value="<?=$_SESSION["Current_advisor_id"]?>">

<div class="col-xs-12">
  <div class="input-field">
    From: <?=$_SESSION["Current_advisor_id"]?>
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

<div class="col-sm-9 col-md-9" id="div_a_schedule">   

</div> 
            
                 

<script>


function viw_adv_schedule()
{
	var fd = new FormData($('#book_form')[0])   ; 
		 var url= 'ajax_actions.php?viw_adv_schedule=1' ;  
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



function load_page(url)
{
	$( "#div_page" ).load(url);	
	
}

</script>