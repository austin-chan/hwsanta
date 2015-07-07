<?php

include("../connect.php");

$query = "SELECT * FROM setup";
$result = mysql_query($query) or die(mysql_error());

while($row = mysql_fetch_array($result)){
	$userid = $row['userid'];
	$name = $row['first'] . ' ' . $row['last'];
	$grade = $row['grade'];

	$query2 = "INSERT INTO notpickedyet (userid, name, grade) VALUES ('$userid', '$name', '$grade')";
	$result2 = mysql_query($query2) or die(mysql_error());
}

?>