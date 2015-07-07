<?php

include("../site/connect.php");

$userid = mysql_real_escape_string($_POST['userid']);
$selected = mysql_real_escape_string($_POST['selected']);
$unselected = mysql_real_escape_string($_POST['unselected']);

$unselected = explode(",", rtrim($unselected,','));

foreach($unselected as $unselectedID){
	if($unselectedID == $selected){
		continue;
	}
	$query = "SELECT * FROM inselectionpool WHERE userid='$unselectedID'";
	$result = mysql_query($query);
	$row = mysql_fetch_array($result);
	
	$var1 = $row['userid'];
	$var2 = $row['name'];
	$var3 = $row['grade'];
	$query = "INSERT INTO notpickedyet (userid, name, grade) VALUES ('$var1', '$var2', '$var3')";
	mysql_query($query);
	
	$query = "DELETE FROM inselectionpool WHERE userid='$unselectedID'";
	mysql_query($query);
}

mysql_query("DELETE FROM isselecting WHERE userid='$userid'");

$query = "DELETE FROM inselectionpool WHERE userid='$selected'";
mysql_query($query);

$query = "INSERT INTO relationships (santa, child) VALUES ('$userid', '$selected')";
mysql_query($query);

mysql_query("UPDATE setup SET pickedalready='1' WHERE userid='$userid'");
mysql_query("UPDATE setup SET assignedalready='1' WHERE userid='$selected'");

header("Location:http://hwsanta.com/site/home.php");

?>