<?php

include('../site/connect.php');

if(!empty($_GET)){
	$request = $_GET['v'];
	
	if($request = "continue"){

		$getuserid = $_SESSION['userid'];
		
		$query = "SELECT userid FROM verified WHERE userid='$getuserid'";
		$result = mysql_query($query);
		
		if(mysql_num_rows($result) == 1){
		
		
			header("Location:http://hwsanta.com/settingup/setup.php");
		}
		$continue = "Sorry, you have not verified your account yet";
	}
}else{
	include('../app/plugins/Mail.php');
	$userid = $_SESSION['userid'];
	
	$query = "SELECT username, password FROM unverified WHERE userid='$userid'";
	$query = mysql_query($query);
	
	if($row = mysql_fetch_array($query)){
	
		$user = $row['username'];
		$pw = $row['password'];
		
		$to = $user."@hwemail.com";/* "auscwork@gmail.com"; */
		$subject = "HW Santa Verification";
		$message = "Please click the following link to verify your account: <a href='http://hwsanta.com/app/verify.php?verify=$pw'>http://hwsanta.com/app/verify.php?verify=$pw</a>";
		
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
		$mail = @$smtp->send($to, $headers, $message);
		
		
	}else{
		die("error");
	}
}





?>
<!DOCTYPE html>
<html>
<head>
	<link href="../css/style.css" rel="stylesheet" />
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js"></script>
	<script src="../js/jquery.easing.1.3.js"></script>
	<style>
		h1{

			font-size: 42px;
		}
		#rules{
			padding-left:30px;
			font-size:24px;
			width:800px;
		}
		a.button{
			width:300px;
		}
	</style>
</head>
<body>
	<div id="wrapper">
		<div id='mainbar'>
			<h1>2. Confirm Email</h1>
			<div>
				Check your email: <?=$_SESSION['username']?>@hwemail.com
			</div>
<?php
if(isset($continue)) echo "<p class='error'>$continue</p>";
?>
			<br/>

			<a class="button ml-button-10" href="?v=continue">Click To Continue</a>
			<a class="button ml-button-13" href="?">Send Email Again</a>
		</div>
	</div>
	<div id='sidebar'>
		<div class="tab">
			<a href="http://hwsanta.com/">
				<img id="dalogo" src="../img/dalogo.png" />
			</a>
		</div>
		<div class="tab">
			<img class="number" src="../img/numbersbw/1.png" />
			<p>The Rules</p>
			<div class="clear"></div>
		</div>
		<div class="tab">
			<img class="number" src="../img/numbers/2.png" />
			<p>Confirm Email</p>
			<div class="clear"></div>
		</div>
		<div class="tab">
			<img class="number" src="../img/numbersbw/3.png" />
			<p>Who are you?</p>
			<div class="clear"></div>
		</div>
		<div class="tab">
			<img class="number" src="../img/numbersbw/4.png" />
			<p>Tell your friends</p>
			<div class="clear"></div>
		</div>
		<div class="tab">
			<img class="number" src="../img/numbersbw/5.png" />
			<p>Choose gift recipient</p>
			<div class="clear"></div>
		</div>
	</div>
</body>
</html>