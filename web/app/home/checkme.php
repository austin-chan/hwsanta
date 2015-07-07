<?php

include("../connect.php");

$userid = mysql_real_escape_string($_GET['userid']);

$result = mysql_query("SELECT first, last FROM setup WHERE userid='$userid'");
$row = mysql_fetch_array($result);
echo $row['first'].' '.$row['last'];

?>