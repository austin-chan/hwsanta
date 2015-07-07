<?php

include ("connect.php");

$userid = mysql_real_escape_string($_GET['userid']);
$first = mysql_real_escape_string($_GET['first']);
$last = mysql_real_escape_string($_GET['last']);
$gender = mysql_real_escape_string($_GET['gender']);
$grade = mysql_real_escape_string($_GET['grade']);

$query = "SELECT * FROM verified WHERE userid='$userid'";
$result = mysql_query($query);

if(mysql_num_rows($result) == 0){
	die("error");
}
$row = mysql_fetch_array($result);

$username = $row['username'];
$password = $row['password'];
$pickedalready = 0;
$assignedalready = 0;


$query = "INSERT INTO setup (userid, first, last, gender, grade, username, password, pickedalready, assignedalready) VALUES ('$userid', '$first', '$last', '$gender', '$grade', '$username', '$password', '$pickedalready', '$assignedalready')";
mysql_query($query);

$query = "DELETE FROM verified WHERE userid='$userid'";
$result = mysql_query($query);



?>