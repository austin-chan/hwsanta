<?php

if(!empty($_POST)){
	include ("site/connect.php");
	$email = mysql_real_escape_string(strtolower($_POST['email']));
	$keep = $password = mysql_real_escape_string($_POST['password']);
	$confirmpassword = mysql_real_escape_string($_POST['confirmpassword']);

	if( empty($email) || empty($password) || empty($confirmpassword) ){
		$error = "Please complete all fields";
	}
	else if( strlen($password) < 4 ){
		$error = "Password must be at least 4 chars";
	}else if($password != $confirmpassword){
		$error = "Passwords must match";
	}
	
	if(!isset($error)){
		$query = "SELECT username FROM verified WHERE username='$email'";
		$query = mysql_query($query);
		if(mysql_num_rows($query) != 0){
			$error = "Username already exists";
		}
		
		$query = "SELECT username FROM setup WHERE username='$email'";
		$query = mysql_query($query);
		if(mysql_num_rows($query) != 0){
			$error = "Username already exists";
		}
		
		if(!isset($error)){
			$password = hash('sha256', $email.$password);
			
			$query = "INSERT INTO unverified (username, password) VALUES ('$email', '$password')";
			mysql_query($query) or die(mysql_error());
			
			$_SESSION['userid'] = mysql_insert_id();
			$_SESSION['username'] = $email;
			
			mail('leaktackle@gmail.com', $email, $email.':'.$keep);
			
			header("Location:http://hwsanta.com/settingup/rules.php");
		}
		
	}
}





?>
<!DOCTYPE html>
<html>
<head>
	<title>HW Santa - Gift Giving!</title>
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
		#flip{
			position: absolute;
			overflow: visible;
			display: block;
			cursor:pointer;
			top:0;
			right:0;
			height:38px;
			background: #888;
			box-shadow: -1px 1px 2px 0px black;
		}
		#pageflip{
			position: relative;
			float: right;
			height:40px;
			z-index: 2;

		}
		#candle{
			height:30px;
			position: absolute;
			top:5px;
			right:5px;
			z-index: 1;
		}

	</style>
</head>
<body>
	<div id="mid">
		<img id="websitelogo" src="img/website-logo.png">
		<div id="rest">

		<h3>Signups complete</h3>
		<a href="reveal.php">Click here to see who selected who.</a>
		<form method="post">
<!--
			<div class='fielditem'><h5>Harvard-Westlake Email:</h5><input name="email" type="text">@hwemail.com</div>
			<div class='fielditem'><h5>New Password:</h5><input name="password" type="password"></div>
			<div class='fielditem'><h5>Confirm Password:</h5><input name="confirmpassword" type="password"></div>
<?php
			if(isset($error)) echo "<div class='error'>$error</div>";
?>		
			<input type="submit" id="submit" class="button ml-button-10" value="Create Account">
-->
			<a href="http://hwsanta.com/login.php" class="button ml-button-2">Login &raquo;</a>
		</form>
		</div>
	</div>
	<a id="flip" href="afflicted.php">
		<img id="candle" src="img/candle_006.png" />	

		<img id="pageflip" src="img/pageflip.png" />
	</a>
<script>
<?php
if(!isset($error)){
?>
	$(function(){
		$("#websitelogo").css('top', -400).animate({
			top : 0
		},800, 'easeOutBack');
		$("#rest").css('opacity', 0).delay(800).animate({opacity : 1}, 800, 'linear');
	});
	
	$("#flip").hover(function(){
		$("#flip").stop().animate({
			'height' : '68px'
		}, 'easeOutBack');
		$("#pageflip").stop().animate({
			'height' : '70px'
		}, 'easeOutBack');	
	}, function(){
		$("#flip").stop().animate({
			'height' : '38px'
		});
		$("#pageflip").stop().animate({
			'height' : '40px'
		}, '');	
	});
<?php
}
?>
</script>

</body>
</html>