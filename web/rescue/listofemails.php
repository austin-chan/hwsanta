<?php

include ("../site/connect.php");

$query = mysql_query("SELECT username FROM setup");

while($row = mysql_fetch_array($query)){
	echo $row['username']."@hwemail.com,";
}

?>