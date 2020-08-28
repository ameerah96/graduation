<?php
include_once('header.php') ;
?>

<?php
if(isset($_SESSION["user_type_id"]))   
{
	if($_SESSION["user_type_id"]==1)
	{	
		
		include_once('admin_home.php') ;
	
	}
	else if($_SESSION["user_type_id"]==2)
	{
		
		include_once('adv_page.php') ;
	}
	else if($_SESSION["user_type_id"]==3)
	{
		
		include_once('st_page.php') ;
	}
	else
	{  
	
		include_once('main_page.php') ;
	}
		
	
}
else
	{  
		
		include_once('main_page.php') ;
	}


 	
?>
 
  
<?php

include_once('footer.php') ;
?> 