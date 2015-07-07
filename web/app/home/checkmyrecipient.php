<?php

include("../connect.php");

$userid = mysql_real_escape_string($_GET['userid']);

$result = mysql_query("SELECT child FROM relationships WHERE santa='$userid'");

$row = mysql_fetch_array($result);
$childID = $row['child'];

$result = mysql_query("SELECT first, last FROM setup WHERE userid='$childID'");
$row = mysql_fetch_array($result);
echo $row['first'].' '.$row['last'];

?>