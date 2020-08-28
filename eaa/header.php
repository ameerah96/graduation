<?php 
include "functions.php" ;



?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>E-ACADEMIC ADVISOR</title>

    <!-- Bootstrap Core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="vendor/morrisjs/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

</head>


<?php 
if(isset($_SESSION["user_type_id"]))   
{
	if($_SESSION["user_type_id"]==1)
		include_once('header_admin.php') ;
	else if($_SESSION["user_type_id"]==2)
		include_once('header_adv.php') ;
	else if($_SESSION["user_type_id"]==3)
		include_once('header_st.php') ;
	else  
		include_once('header_main.php') ;
		
	
}
else
{
	 include_once('header_main.php') ;
}
 
?>
