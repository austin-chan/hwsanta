<?php

include("connect.php");
$setupcomplete = "go";

$username = mysql_real_escape_string( strtolower($_GET['username']));
$password = mysql_real_escape_string($_GET['password']);
$password = hash('sha256', $username.$password);

//verification, setup, setupComplete, selectPrep, selectNow, tabs

$result = mysql_query("SELECT * FROM setup WHERE username='$username' AND password='$password'");
$result2 = mysql_query("SELECT * FROM verified WHERE username='$username' AND password='$password'");
if(mysql_num_rows($result) == 0 && mysql_num_rows($result2) == 0){
	die( json_encode( array("exists" => "no") ) );
}
//setup already
$stage = "";
$userid = "";

if(mysql_num_rows($result) == 1){
	$row = mysql_fetch_array($result);
	$userid = $row['userid'];
	$pickedalready = $row['pickedalready'];
	if($pickedalready == "1"){
		$stage = "tabs";
	}else{
		if($setupcomplete == "early"){
			$stage = "setupComplete";
		}else{
			$stage = "selectPrep";
		}
	}
}else{
	$row = mysql_fetch_array($result2);
	$userid = $row['userid'];
	$stage = "setup";
}




$arr = array(
	"stage" => $stage,
	"userid" => $userid
);
echo json_encode($arr);




?>