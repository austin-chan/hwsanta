<?php

include("site/connect.php");
$setupcomplete = "early";

if(!empty($_POST)){
	$email = mysql_real_escape_string( ($_POST['email']) );
	$password = mysql_real_escape_string( $_POST['password'] );
	
	if(empty($email) || empty($password)){
		$error = "Please complete all fields";
	}else{
	
		$password = hash('sha256', $email.$password);
		$result = mysql_query("SELECT * FROM setup WHERE username='$email' AND password='$password'");
		$result2 = mysql_query("SELECT * FROM verified WHERE username='$email' AND password='$password'");
		if(mysql_num_rows($result) == 0 && mysql_num_rows($result2) == 0){
			$error = "Sorry, we could not log you in. Incorrect combination";
		}else{
			//setup already
			$stage = "";
			$userid = "";

			
			if(mysql_num_rows($result) == 1){
				$row = mysql_fetch_array($result);
				$_SESSION['userid'] = $row['userid'];
				$_SESSION['username'] = $row['username'];
				$userid = $row['userid'];
				$pickedalready = $row['pickedalready'];
				if($pickedalready == "1"){
					header("Location:http://hwsanta.com/site/home.php");
				}else{
					if($setupcomplete == "early"){
						header("Location:http://hwsanta.com/settingup/tellyofriends.php");
					}else{
						$stage = "selectPrep";
					}
				}
			}else{
				$row = mysql_fetch_array($result2);
				$_SESSION['userid'] = $row['userid'];
				$_SESSION['username'] = $row['username'];

				//$stage = "setup";
				header("Location:http://hwsanta.com/settingup/setup.php");
			}	
		}
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
		.fielditem{
			margin:15px 0px;
		}
		h2{
			font-weight: 400;
			font-size:32px;
		}
		h3{
			font-weight:100;
		}
		h5{
			display:inline;
			margin-right:20px;
		}
		input[type=text],input[type=password]{
			padding:5px;
		}
		a.button, input[type=submit]{
			width:250px;
		}
		input[type=submit]{
			padding-bottom: 33px;
		}
		#change{
			font-size: 12px;
		}
		#change a {
			text-decoration: none;
		}
	</style>
</head>
<body>
	<div id="mid">
		<img id="websitelogo" src="img/website-logo.png">
		<div id="rest">

		<h3>Login here.</h3>
		<form method="post">
			<div class='fielditem'><h5>Harvard-Westlake Email:</h5><input name="email" type="text">@hwemail.com</div>
			<div class='fielditem'><h5>Password:</h5><input name="password" type="password"></div>
<?php
			if(isset($error)) echo "<div class='error'>$error</div>";
?>
			<p id="change"><a href="willchangepassword.php">Change your password</a></p>
			<a href="http://hwsanta.com/" class="button ml-button-2">&laquo; Sign Up</a>
			<input type="submit" id="submit" class="button ml-button-10" value="Login">
		</form>
		</div>
	</div>

<script>
</script>

</body>
</html>