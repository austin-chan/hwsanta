<?php

include ("connect.php");

$userid = mysql_real_escape_string($_GET['userid']);

$query = "SELECT userid FROM notpickedyet WHERE userid<>'$userid'";
$result = mysql_query($query);
$query2 = "SELECT userid FROM isselecting";
$result2 = mysql_query($query2);

if(mysql_num_rows($result) < 5 && mysql_num_rows($result2) > 0){
	die('wait');
}

$query = "SELECT * FROM hasntpickedyet WHERE userid='$userid'";
$me = mysql_query($query);
$row = mysql_fetch_array($me);
$myuserid = $row['userid'];
$myname = $row['name'];
mysql_query("DELETE FROM hasntpickedyet WHERE userid='$userid'");
$result = mysql_query("SELECT grade FROM setup WHERE userid='$userid'");
$row = mysql_fetch_array($result);
$mygrade = $row['grade'];

$query = "INSERT INTO isselecting (userid, name) VALUES ('$myuserid','$myname')";
mysql_query($query);



$arr = array();
$query = "SELECT userid FROM notpickedyet WHERE userid<>'$userid' AND userid<>'0' AND grade='$mygrade' ORDER BY RAND() LIMIT 5";
$list = mysql_query($query);
while($row = mysql_fetch_array($list)){
	$choiceID = $row['userid'];
	$query = "SELECT * FROM setup WHERE userid='$choiceID'";
	$result = mysql_query($query);
	
	$row = mysql_fetch_array($result);
	$arr[] = array(
		"name" => $row['first'].' '.$row['last'],
		"gender" => $row['gender'],
		"grade" => $row['grade'],
		"userid" => $row['userid']
	);
	
	$him = mysql_fetch_array(mysql_query("SELECT * FROM notpickedyet WHERE userid='$choiceID'"));
	mysql_query("DELETE FROM notpickedyet WHERE userid='$choiceID'");
	mysql_query("INSERT INTO inselectionpool (userid, name, grade) VALUES ('".$him['userid']."', '".$him['name']."', '".$him['grade']."')");
}

if(count($arr) < 5){
	$query = "SELECT userid FROM notpickedyet WHERE userid<>'$userid' AND userid<>'0' AND grade<>'$mygrade' ORDER BY RAND() LIMIT ".(5 - count($arr));
	$list = mysql_query($query);
	while($row = mysql_fetch_array($list)){
		$choiceID = $row['userid'];
		$query = "SELECT * FROM setup WHERE userid='$choiceID'";
		$result = mysql_query($query);
		
		$row = mysql_fetch_array($result);
		$arr[] = array(
			"name" => $row['first'].' '.$row['last'],
			"gender" => $row['gender'],
			"grade" => $row['grade'],
			"userid" => $row['userid']
		);
		
		$him = mysql_fetch_array(mysql_query("SELECT * FROM notpickedyet WHERE userid='$choiceID'"));
		mysql_query("DELETE FROM notpickedyet WHERE userid='$choiceID'");
		mysql_query("INSERT INTO inselectionpool (userid, name) VALUES ('".$him['userid']."', '".$him['name']."')");
	}

}


/*
$arr = array(
		"0" => array(
			"name" => "User 1",
			"gender" => "Female",
			"grade" => "Junior",
			"userid" => 19
		),
		"1" => array(
			"name" => "User 2",
			"gender" => "Male",
			"grade" => "Senior",
			"userid" => 20
		),
		"2" => array(
			"name" => "User 3",
			"gender" => "Male",
			"grade" => "Sophomore",
			"userid" => 21
		),
		"3" => array(
			"name" => "User 4",
			"gender" => "Female",
			"grade" => "Sophomore",
			"userid" => 22
		),
		"4" => array(
			"name" => "User 5",
			"gender" => "Female",
			"grade" => "Senior",
			"userid" => 23
		)
);
*/

echo json_encode($arr);

?>