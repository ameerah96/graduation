<?php 
require_once( "functions.php" );
$sql = "select * from students where advisor_id =".$_GET[a_id] . ' order by student_id' ; 
$RESULT = mysql_query($sql) ; 

?>
<div class="row">            
 <div class="col-lg-3 col-md-3">
 <?php
 while($qs=mysql_fetch_array($RESULT))
 {
	 
	 
	 
	echo'<p> <a href="#" onClick="load_s_page(\'view_student_info.php?s_id='.$qs[student_id].'\')" >'.$qs[student_id].' ' . $qs[student_name].'</a> </p> ' ;  }
 ?>
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