<?php

include("connect.php");
$getuserid = mysql_real_escape_string($_GET['userid']);

$query = "SELECT userid FROM verified WHERE userid='$getuserid'";
$result = mysql_query($query);

if(mysql_num_rows($result) == 1){
	die("verified");
}

die("unverified");

?>