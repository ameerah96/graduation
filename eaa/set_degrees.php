<?php 
require_once( "functions.php" );
 

?>
            <div class="row">
                <div class="col-lg-11 col-md-11">
                    <div class="panel panel-info ">
                        <div class="panel-heading">
                            <div class="row">
                          <div class="col-lg-4 col-md-4">
                         <h4> Select course to enter the student's grades: </h4>
                          </div>
                           <div class="col-lg-6 col-md-6 " style="text-align:left" >
						 <select name="courses" id="courses" class="form-control" onChange="load_degree_form(this.value) ; ">
                         <option value="0" >  ----   Select course ----</option>
                         <?php 
						 
						 $where = " where course_id in (select course_id from enroll_course where status_id = 1 and agenda_id =1 and semester_id = 1 )" ; 
						 myOptions ("course_id" , "  CONCAT('(',course_name, ') ', description)  ","courses","" , $where ) ; 
						 
						 ?> 
                         </select>
                          </div>
                            
                        </div>
                         
                         <div class="panel-body" id="div_form">
                               
                            </div>
                            <div class="panel-footer">
                              <div   id="div_info"> </div>
                            </div>
                         
                    </div>
                </div>
                
                
                
                <div class="row">
                
                
               </div>
<script>

function load_degree_form(course_id)
{
	//alert(course_id) ; 
	
var url= 'ajax_actions.php?load_degree_form=1&course_id='+course_id ; 
		$.ajax({url: url, success: function(result){
			$('#div_form').html(result) ; 
		}}); 
		
	
}

function save_degree()
{
	  
	  
	  var fd = new FormData($('#abs_form')[0])   ; 
		 var url= 'ajax_actions.php?save_degree=1' ;  
		  $.ajax({
		  url: url,
		  data: fd,
		  processData: false,
		  contentType: false,
		  type: 'POST',
		  
		  success: function(result){
			  
			  $('#div_info').html(result) ; 
			  
			  }
		});
	
 
		
	
}
 



</script>               