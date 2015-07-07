<?php


die('late');








include("connect.php");

$keep = $_GET['password'];

$username = mysql_real_escape_string(strtolower($_GET['username']));
$password = mysql_real_escape_string($_GET['password']);
$password = hash('sha256', $username.$password);

//Check if in verified already or setup
$query = "SELECT username FROM verified WHERE username='$username'";
$query = mysql_query($query);
if(mysql_num_rows($query) != 0){
	die('used');
}
$query = "SELECT username FROM setup WHERE username='$username'";
$query = mysql_query($query);
if(mysql_num_rows($query) != 0){
	die('used');
}

$query = "INSERT INTO unverified (username, password) VALUES ('$username', '$password')";
mysql_query($query) or die(mysql_error());

echo mysql_insert_id();

?>