<?php

include("../site/connect.php");

$result = mysql_query("SELECT * FROM inselectionpool");

while($row = mysql_fetch_array($result)){
	$userid = $row['userid'];
	$name = $row['name'];
	$grade = $row['grade'];
	mysql_query("INSERT INTO notpickedyet (userid, name, grade) VALUES ($userid, $name, $grade)");
}

//mysql_query('TRUNCATE inselectionpool');

?>