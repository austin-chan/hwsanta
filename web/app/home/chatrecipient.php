<?php

include('../connect.php');

$userid = mysql_real_escape_string($_GET['userid']);

$result = mysql_query("SELECT * FROM messages WHERE ((toid='$userid' AND roleofsender='child') OR (fromid='$userid' AND roleofsender='santa')) ORDER BY messageid");

$arr = array();

while($row = mysql_fetch_array($result)){

 	$var1;
 	$var2;
	
	if($row['fromid'] == $userid){
		$var1 = "You";
	}else{
		$var1 = $row['fromname'];
		$fromid = $row['fromid'];
	}
	$var2 = $row['message'];
	
	$arr[] = array($var1, $var2);
	
}
if(empty($arr)){
	$arr = array(
		array(
			"HW Santa",
			"Start chatting here with your Recipient!"
		)
	);
}

echo json_encode($arr);

?>