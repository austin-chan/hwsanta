<?php


if(!empty($_POST)){
	include ("site/connect.php");
	include('app/plugins/Mail.php');
	error_reporting(E_ERROR | E_PARSE);

	$email = mysql_real_escape_string($_POST['email']);
	
	$query = "SELECT username, password FROM setup WHERE username='$email'";
	$query = mysql_query($query);

	if($row = mysql_fetch_array($query)){	
		$user = $row['username'];
		$pw = $row['password'];
		
		$to = $email."@hwemail.com";
		$subject = "HW Santa Change Password";
		$message = "Change your password here: <a href='http://hwsanta.com/changepassword.php?change=$pw'>http://hwsanta.com/changepassword.php?change=$pw</a>";
		
		$headers['MIME-Version'] =  '1.0';
		$headers['Content-type'] = 'text/html; charset=iso-8859-1';
		$headers['To'] = "<$user@hwemail.com>";
		$headers['From'] = "HW Santa <santa@hwsanta.com>";
		$headers['Subject'] = $subject;
		
		$host = "mail.hwsanta.com";
		$authuser = "santa@hwsanta.com";
		$authpass = "hudnut";
		
		$smtp = Mail::factory('smtp',
			array ('host' => $host,
				'auth' => true,
				'username' => $authuser,
				'password' => $authpass)
			);
		$mail = $smtp->send($to, $headers, $message);
		
		$sent = "Message sent";
	}else{
		$sent = "Sorry, your account was never fully set up.  We can't change your password";
	}
}

?>
<!DOCTYPE html>
<html>
<head>
	<link href="css/style.css" rel="stylesheet" />
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js"></script>
	<script src="js/jquery.easing.1.3.js"></script>
	<style>
		#mid{
			margin:0 auto;
			width:600px;
			padding-top:50px;
		}
		#websitelogo{
			position:relative;
		}
		a.button{
			width:200px;
		}
		#submit{
			width:300px;
		}
		h5{
			display: inline;
			
		}
	</style>
</head>
<body>
	<div id="mid">
		<img id="websitelogo" src="img/website-logo.png">
		<div id="rest">

			<h3>Change your password.  Enter your email:</h3>
<?php
	if(!empty($sent)) echo $sent;
?>
			
			<form method="post">
				<div class='fielditem'><h5>Harvard-Westlake Email:</h5><input name="email" type="text">@hwemail.com</div>
				<a href="http://hwsanta.com/login.php" class="button ml-button-2">&laquo; Back to Login</a>
				<input type="submit" id="submit" class="button ml-button-10" value="Send email to change password">
			</form>
		</div>
	</div>

<script>
</script>

</body>
</html>