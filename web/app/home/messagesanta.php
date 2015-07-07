<?php

include('../connect.php');

$userid = mysql_real_escape_string($_GET['userid']);
$message = mysql_real_escape_string($_GET['message']);

$result = mysql_query("SELECT * FROM relationships WHERE child='$userid'");
if(mysql_num_rows($result) == 0){
	die("empty");

}

$row = mysql_fetch_array($result);
$santaid = $row['santa'];

$result = mysql_query("SELECT first, last FROM setup WHERE userid='$userid' LIMIT 1");
$row = mysql_fetch_array($result);
$username = $row['first'].' '.$row['last'];

$result = mysql_query("SELECT first, last FROM setup WHERE userid='$santaid' LIMIT 1");
$row = mysql_fetch_array($result);
$santaname = $row['first'].' '.$row['last'];

mysql_query("INSERT INTO messages (fromid, toid, fromname, toname, message, roleofsender) VALUES ('$userid', '$santaid', '$username', '$santaname', '$message', 'child')") ;

?>