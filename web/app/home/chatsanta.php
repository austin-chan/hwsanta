<?php

include('../connect.php');

$userid = mysql_real_escape_string($_GET['userid']);

$result = mysql_query("SELECT * FROM messages WHERE (toid='$userid' AND roleofsender='santa') OR (fromid='$userid' AND roleofsender='child') ORDER BY messageid");
$arr = array();

while($row = mysql_fetch_array($result)){
 	$var1;
 	$var2;
	
	if($row['fromid'] == $userid){
		$var1 = "You";
	}else{
		$var1 = $row['fromname'];
		$var1 = "Your Secret Santa";
	}
	$var2 = $row['message'];
	
	$arr[] = array($var1, $var2);
	
}
if(empty($arr)){
	$arr = array(
		array(
			"HW Santa",
			"Start chatting here with your Santa!"
		)
	);
}


/*
$arr = array(
	array(
		"Your Santa",
		"Haha you!"
	),
	array(
		"You",
		"Hi.."
	),
	array(
		"Your Santa",
		"It's Tara!"
	),
	array(
		"You",
		"Hey you!"
	),
	array(
		"Your Santa",
		"Austin, I miss you :("
	),
	array(
		"You",
		"I miss you too, we should do something this weekend!"
	)
);
*/

echo json_encode($arr);

?>