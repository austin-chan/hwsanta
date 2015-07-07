<?php

include("../site/connect.php");

$query = "SELECT * FROM setup WHERE pickedalready='0'";
$result = mysql_query($query) or die(mysql_error());

while($row = mysql_fetch_array($result)){
	$userid = $row['userid'];
	$name = $row['first'] . ' ' . $row['last'];

	$query2 = "INSERT INTO hasntpickedyet (userid, name) VALUES ('$userid', '$name')";
	$result2 = mysql_query($query2) or die(mysql_error());
}

?>