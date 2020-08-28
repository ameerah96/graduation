
   
<?php
include_once('header.php') ;

if(isset($_POST[btn_resetPassword])&& isset($_POST[email]))
{
	
	
	$sql_ck = "SELECT * FROM `users` WHERE  `email` = '".$_POST[email]."' LIMIT 1" ; 
	$r_ck = mysql_query($sql_ck) ; 
	$q_ck = mysql_fetch_array($r_ck) ; 
	if($q_ck[email] !='' &&filter_var($q_ck[email], FILTER_VALIDATE_EMAIL)&&$q_ck[username] !='' )
	{
		$new_password = randomkeys(6) ; 
		$password = md5($new_password) ; 
		
		if( mysql_query("update users set password = '".$password."' where user_id =".$q_ck[user_id].""))
		{
			$message = '<h4 > Username: '.$q_ck[username].'  <br>
			  Password:  '.$new_password.'  </h4>' ; 
			  
			  $subject = 'new Password (E-ACADEMIC ADVISOR)  ';
			  send_mail($q_ck[email],$subject,$message) ; 
			  
			  $resetMessage = '<div class="alert alert-success" role="alert">
								  <strong>Well done!</strong> Your password has been sent to your email address.
								</div>' ;   
			
		}
	}
	else
	{
		$resetMessage = '<div class="alert alert-danger" role="alert">
								  <strong>Error!</strong> Your email address is not registered.
								</div>' ;   
		
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



<body style="background-image: url('img/5bf59d39-ba3e-4e6e-9583-03bb16076ef4.jpg'); min-height: 60vh;background-size: cover;">


 <?php
					if(isset($_GET[forgotPassword]))
					{
					?>
                    
                     <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                        <h3 >Reset Password</h3>
                    </div>
                    <div class="panel-body">
                    
                   
                    
                    
                       <form role="form" method="post" action="login.php"> 
                            <fieldset>
                                <div class="form-group">
                                Enter Your Email  
                                    <input type="email" class="form-control" placeholder="email" name="email" type="text" required autofocus>
                                </div>
                               
                                
                                <input type="submit" name="btn_resetPassword" id="btn_resetPassword" class="btn btn-lg btn-primary btn-block" value="Go">  
                            </fieldset>
                            
                           
                        </form>
                        
                          <p>
                         
                        
                        </p>
                        
                        <p>
                        <hr>
                      
                        
                        </p>
                    </div>
                    <div class="panel-footer">
                       
                    </div>
                </div>
            </div>
        </div>
    </div>
               
                    
                    <?php	
					}
					else
					{
					?>

    <div class="container">
       
  <style type="text/css">
    img{  border-radius: 20%; margin-left: 50px}

  </style>
        <div class="row">
            <div class="col-md-4 col-md-offset-4">

                <div class="login-panel panel panel-default">

                    <div class="panel-heading">
                        <h3 ><img src="img/logo.jpg" width="200" height="175" alt="" align="middle" /></h3>
                    </div>
                    <div class="panel-body">
                    
                   
                    <?=$resetMessage?>
                    
                        <form role="form" method="post" action="redirectUser.php?action=login"> 
                            <fieldset>
                                <div class="form-group">
                                Username 
                                    <input class="form-control" placeholder="username" name="username" type="text" required autofocus>
                                </div>
                                <div class="form-group">
                                Password
                                    <input class="form-control" placeholder="password" name="password" type="password" value="">
                                </div>
                                
                                <!-- Change this to a button or input when using this as a form -->
                                <input type="submit" name="login" id="login" class="btn btn-lg btn-primary btn-block" value="Login">  
                            </fieldset>
                       
                        </form>
                    </div>
                    <div class="panel-footer">
                       
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php }  ?> 
    
</body>

</html>
<?php include_once('footer.php') ; ?>