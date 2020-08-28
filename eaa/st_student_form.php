<?php 
require_once( "functions.php" );

 
?>
<div class="row">            
 <div class="col-lg-3 col-md-3">
 
 <li> <a href="#" onClick="load_s_page('adv_student_form_h.php?form_type_id=3')"><i class="fa fa-plus fa-fw"></i> Enroll course</a> </li>
    <li> <a href="#" onClick="load_s_page('adv_student_form_h.php?form_type_id=1')"><i class="fa fa-times" aria-hidden="true"></i> Drop course</a> 
    </li>
    <li> <a href="#" onClick="load_s_page('adv_student_form_h.php?form_type_id=4')"><i class="fa fa-minus   fa-fw"></i> Delete course</a> </li>
    <li> <a href="#" onClick="load_s_page('adv_student_form_h.php?form_type_id=2')"><i class="fa fa-trash fa-fw"></i> Drop semester</a> </li>
    
 
 </div>          
 <div class="col-lg-9 col-md-9" id="div_st_page">           
               
                
               
              
              
</div>              
      </div>
            

<script>




function load_s_page(url)
{
	$( "#div_st_page" ).load(url);	
	
}

function load_page(url)
{
	$( "#div_page" ).load(url);	
	
}

</script>