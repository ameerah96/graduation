<?php 
require_once('functions.php');

if(isset($_GET['action']))
{
$action =  $_GET['action'] ;
if ($action=="login"){
	 
		if(isset($_POST[login])&& $_POST[login] != "")	
			{
				
				$password = md5($_POST[password]) ; 
				
				
				$s = "SELECT * 
							FROM users  WHERE  username='$_POST[username]' and password='$password' and is_active = 1  " ; 
				$r_user = mysql_query($s) or die(mysql_error());
				
				if(mysql_num_rows($r_user)>0)
				{
						
						get_general_settings() ; 
						
						$query_data = mysql_fetch_array($r_user) ; 
								 
						 $user_type_id = $query_data[user_type_id] ;
						 
						 switch ($user_type_id) {
								case 1:
										$sql =  "select admin_name as full_name from admin where admin_id=".$query_data[admin_id];
										$result = mysql_query($sql) ; 
										$query = mysql_fetch_array($result) ; 
										break;
								case 2:
										$sql =  "select advisor_name as full_name from advisor where advisor_id=".$query_data[advisor_id];
										$result = mysql_query($sql) ; 
										$query = mysql_fetch_array($result) ; 
										$_SESSION["Current_advisor_id"] 		= $query_data[advisor_id];
										
										break;
								case 3:
										$sql =  "select student_name as full_name , level_id  , plan_id , GPA , advisor_id ,
										(select user_id from users u where u.advisor_id = s.advisor_id LIMIT 1) as st_advisor_user_id
										  from students s   where s.student_id=".$query_data[student_id];
										
										
										$result = mysql_query($sql) ; 
										$query = mysql_fetch_array($result) ; 
										
										$_SESSION["st_level_id"] 				= $query[level_id];
										$_SESSION["st_plan_id"] 				= $query[plan_id];
										$_SESSION["st_GPA"] 					= $query[GPA];
										$_SESSION["st_advisor_id"] 				= $query[advisor_id];
										$_SESSION["st_advisor_user_id"] 				= $query[st_advisor_user_id];
										$_SESSION["current_student_id"] 		= $query_data[student_id];
										
										
										break;
								 
							}
						  
						
						
						$_SESSION["CurrentUserId"] 		= $query_data[user_id];
						$_SESSION["user_id"] 		= $query_data[user_id];
						$_SESSION['username'] 			= $query_data[username];
						$_SESSION["user_type_id"] 		= $query_data[user_type_id];
						$_SESSION["NAME"] 				= $query[full_name];
						$_SESSION["email"] 				= $query_data[email];
						$_SESSION["mobile"] 			= $query_data[mobile];
						
					
					 	echo "<META HTTP-EQUIV='Refresh' Content='1;URL=index.php'>";
						exit() ;		
				}
                else
                {
					$message = 'The username or password you have entered is invalid.' ; 
					
                    ?><script>alert('<?=$message?>'); history.go(-1)</script><?php 	exit() ;
                    
                }
			}
   
    
	 

}

else if ($action=="logout")
{
	
		session_destroy();
		echo "<META HTTP-EQUIV='Refresh' Content='1;URL=login.php'>";	
		exit() ;
}

}
	
?>