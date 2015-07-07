<?php

include('connect.php');
include('plugins/Mail.php');
$userid = mysql_real_escape_string($_GET['userid']);

$query = "SELECT username, password FROM unverified WHERE userid='$userid'";
$query = mysql_query($query);

if($row = mysql_fetch_array($query)){

	$user = $row['username'];
	$pw = $row['password'];
	
	$to = $user."@hwemail.com";
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
	$mail = $smtp->send($to, $headers, $message);
	
	
}else{
	die("error");
}



?>