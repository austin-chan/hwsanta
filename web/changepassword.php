<?php

	include('site/connect.php');


if(!empty($_POST)){
	$passwordhash = mysql_real_escape_string($_POST['passwordhash']);
	$password = mysql_real_escape_string($_POST['password']);
	
	$setupquery = mysql_query("SELECT * FROM setup WHERE password='$passwordhash'");
	
	if(mysql_num_rows($setupquery) != 0){
		$row = mysql_fetch_array($setupquery);
		$newpasswordhash = hash("sha256", $row['username'].$password);
		mysql_query("UPDATE setup SET password='$newpasswordhash' WHERE password='$passwordhash'");
		
		header("Location:http://hwsanta.com/changedpassword.php");
	}else{

	}
}else if(!empty($_GET)){
	
	$passwordhash = mysql_real_escape_string($_GET['change']);
	
	$singleuserresult = mysql_query("SELECT * FROM setup WHERE password='$passwordhash'");
	if(mysql_num_rows($singleuserresult) == 0){
		die ("Sorry, your account was not fully set up.  We cannot change your password");
	}
	$singleuserrow = mysql_fetch_array($singleuserresult);
}else{
	die('error');
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

	</style>
</head>
<body>
	<div id="mid">
		<img id="websitelogo" src="img/website-logo.png">
		<div id="rest">

		<h3>Change your password.</h3>
		<form method="post">
			<h5><?=$singleuserrow['username']?>@hwemail.com</h5>
			<div class='fielditem'><h5>New password:</h5><input name="password" type="password"></div>

			<input type="hidden" name="passwordhash" value="<?=$singleuserrow['password']?>" />
			<input type="submit" id="submit" class="button ml-button-10" value="Change password">
		</form>
		</div>
	</div>

<script>
</script>

</body>
</html>