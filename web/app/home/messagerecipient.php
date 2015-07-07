<?php

include('../connect.php');

$userid = mysql_real_escape_string($_GET['userid']);
$message = mysql_real_escape_string($_GET['message']);

$result = mysql_query("SELECT * FROM relationships WHERE santa='$userid'");
if(mysql_num_rows($result) == 0){
	die("empty");

}

$row = mysql_fetch_array($result);
$childid = $row['child'];

$result = mysql_query("SELECT first, last FROM setup WHERE userid='$userid' LIMIT 1");
$row = mysql_fetch_array($result);
$username = $row['first'].' '.$row['last'];

$result = mysql_query("SELECT first, last FROM setup WHERE userid='$childid' LIMIT 1");
$row = mysql_fetch_array($result);
$childname = $row['first'].' '.$row['last'];

mysql_query("INSERT INTO messages (fromid, toid, fromname, toname, message, roleofsender) VALUES ('$userid', '$childid', '$username', '$childname', '$message', 'santa')") ;

?>