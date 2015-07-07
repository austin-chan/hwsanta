<?php
die('df');
include('site/connect.php');
include('app/plugins/Mail.php');
error_reporting(E_ERROR);


$listresult = mysql_query("SELECT * FROM setup ORDER BY userid");
$count = 0;

while($row = mysql_fetch_array($listresult)){
	$count++;
	if($count < 100) continue;

	
	
	
	$userid = $row['userid'];
	$name = $row['first'];
	$email = $row['username'];
	
	$relationshipquery = mysql_query("SELECT child FROM relationships WHERE santa='$userid'");
	$row = mysql_fetch_array($relationshipquery);
	$childid = $row['child'];
	$childresult = mysql_query("SELECT first, last FROM setup WHERE userid='$childid'");
	$childrow = mysql_fetch_array($childresult);
	$childname = $childrow['first'].' '.$childrow['last'];
	
	$to = "$email@hwemail.com";
	$subject = "HW Santa Here";
	$message = <<<HEREDOC
Dear $name,<br/>
<br/>
You have a beautiful smile. And your laugh always makes me feel warm and cozy inside.
<br/><br/>
Just a reminder. You are secret Santa for <strong>$childname</strong> and you better be nice and get them a gift this week. You can download the iPhone App ("HW Santa" on the App Store) or visit hwsanta.com to check for messages from your recipient or from your santa.  And remember, your gift can't be more than $20 and has to be school-appropriate. Baked goods are always great :)<br/>
<br/>
Cheers,<br/>
HW Santa
	
HEREDOC;
	
	

	
	$headers['MIME-Version'] =  '1.0';
	$headers['Content-type'] = 'text/html; charset=iso-8859-1';
	$headers['To'] = "<$email@hwemail.com>";
	$headers['From'] = "HW Santa <santa@hwsanta.com>";
	$headers['Subject'] = $subject;
	
	$host = "mail.hwsanta.com";
	$authuser = "santa@hwsanta.com";
	$authpass = "hudnut";
	
	$smtp = Mail::factory('smtp',
		array ('host' => $host,
			'auth' => true,
			'username' => $authuser,
			'password' => $authpass)
		);
	$mail = $smtp->send($to, $headers, $message);

}
die($count);

?>