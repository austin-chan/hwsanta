<?php

include("../connect.php");

$userid = mysql_real_escape_string($_GET['userid']);

$result = mysql_query("SELECT santa FROM relationships WHERE child='$userid'");
if(mysql_num_rows($result) == 0){
	die('???');
}


$row = mysql_fetch_array($result);
$santaID = $row['santa'];

$result = mysql_query("SELECT first, last FROM setup WHERE userid='$santaID'");
$row = mysql_fetch_array($result);

//echo $row['first'].' '.$row['last'];

echo "???";

?>