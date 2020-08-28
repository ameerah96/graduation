<?php
session_start() ;
include_once('header.php') ;

if(isset ($_SESSION["user_id"]) && $_SESSION["user_id"]!='' )
{
	if($_SESSION[lang]=='ar')	
						$message = 'عذرا ! قم بتسجيل الخروج أولا   ' ; 
						else
						$message = 'sory ! logout .' ; 
						
			echo "<script>alert('".$message." ') ;</script>" ;
			echo "<META HTTP-EQUIV='Refresh' Content='1;URL=index.php'>";
}

if(isset($_POST[Register]))
 {
	extract($_POST) ; 
	
	$sql_check = "select count(*) as userCount from users where username = '".$username."'" ;
		$r_check = mysql_query($sql_check) ; 
		$q_check = mysql_fetch_array($r_check) ;  
		if($q_check[userCount] > 0 )
		{
			
			if($_SESSION[lang]=='ar')	
						$message = 'لا يمكن استخدام هذا الاسم  .لأنه مستخدم من قبل ' ; 
						else
						$message = 'This username is not available because it is already used.' ; 
						
			echo "<script>alert('".$message." ') ;</script>" ;
			 
		}
		else
		{
	$password = md5($password) ; 
	$sql = "INSERT INTO `users` (`user_id`, `username`, `password`, `user_type_id`, `full_name`, `mobile`, `email`) 
									VALUES (NULL, '$username', '$password', '3', '$fullname', '$mobile', '$email');" ;
	if(mysql_query($sql))
			{
				echo "<script>alert('Successfully Registered') ;</script>" ;
				
				$s = "SELECT * FROM users  WHERE  `username` = '$username' " ; 
				 	 
					 $r_user = mysql_query($s) or die(mysql_error());
				
				if(mysql_num_rows($r_user)>0)
				{
					
						$query_data = mysql_fetch_array($r_user) ; 
						
						$_SESSION["CurrentUserId"] 		= $query_data[user_id];
						$_SESSION["user_id"] 		= $query_data[user_id];
						$_SESSION['username'] 			= $query_data[username];
						$_SESSION["user_type_id"] 		= $query_data[user_type_id];
						$_SESSION["NAME"] 				= $query_data[full_name];
						$_SESSION["email"] 				= $query_data[email];
						$_SESSION["mobile"] 			= $query_data[mobile];
						
						
						echo "<META HTTP-EQUIV='Refresh' Content='1;URL=index.php'>";
										
				}
				
				 
			}	
 }
	
 }


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

   
</head>

<body background="img/admin-bg.png">

    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                        <h3 >Register</h3>
                    </div>
                    <div class="panel-body">
                        <form  name="form1" id="form1" method="post" action="Register.php" onSubmit="return validate();" > 
                            <fieldset>
                                <div class="form-group">
                                Username 
                                    <input class="form-control"  required  placeholder="username" <?=$username?> name="username" type="text" required autofocus>
                                </div>
                                <div class="form-group">
                                Password
                                    <input class="form-control" required placeholder="password" id="password" <?=$password?> name="password" type="password" value="">
                                </div>
                                
                                <div class="form-group">
                               Confirm Password
                                    <input class="form-control" required placeholder=" Confirm password" <?=$repassword?> id="repassword" name="repassword" type="password" value="">
                                </div>
                                
                                 <div class="form-group">
                                Name 
                                    <input class="form-control" placeholder="Name" name="fullname" <?=$fullname?> id="fullname" type="text" required >
                                </div>
                                
                                 <div class="form-group">
                                Mobile 
                                    <input class="form-control" placeholder="mobile" maxlength="10" name="mobile" <?=$mobile?> id="mobile" type="tel" required >
                                </div>
                                
                                <div class="form-group">
                                E-mail 
                                    <input class="form-control" placeholder="email" <?=$email?> name="email" id="email" type="email" required >
                                </div>
                                
                                                             
                                
                                
                                <input type="submit" name="Register" id="Register" class="btn btn-lg btn-success btn-block" value="Register">  
                            </fieldset>
                        </form>
                        
                         
                        
                        
                    </div>
                    <div class="panel-footer">
                       <h4><a href="index.php"> Home </a></h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
</body>

</html>
<?php include_once('footer.php') ; ?>