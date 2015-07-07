<?php

include('connect.php');
$verify = mysql_real_escape_string($_GET['verify']);

$query = "SELECT * FROM unverified WHERE password='$verify'";
$query = mysql_query($query);

if($row = mysql_fetch_array($query)){
	
	$query = "INSERT INTO verified (userid, username, password) VALUES ('".$row['userid']."', '".$row['username']."', '".$row['password']."')";
	mysql_query($query);

	mysql_query("DELETE FROM unverified WHERE password='$verify'");
?>
<html>
<head>
<title>Successfully Verified</title>
</head>
<body>
	A success!<br/>
	-Santa Claus
</body>
</html>
<?php
	die("");
}else{

	$query = "SELECT userid FROM verified WHERE password='$verify'";
	$query = mysql_query($query);
	
	if($row = mysql_fetch_array($query)){
		die("Already verified!");
	}
}

?>