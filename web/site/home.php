<?php

include("connect.php");

if(empty($_SESSION)){
	header("Location:http://hwsanta.com/login.php");
}

$userid = $_SESSION['userid'];

$userrow = mysql_fetch_array(mysql_query("SELECT * FROM setup WHERE userid='$userid'"));
$name = $userrow['first'].' '.$userrow['last'];


//Check Santa

$result = mysql_query("SELECT santa FROM relationships WHERE child='$userid'");
if(mysql_num_rows($result) == 0){
	
}
$row = mysql_fetch_array($result);
$santaID = $row['santa'];

$result = mysql_query("SELECT first, last FROM setup WHERE userid='$santaID'");
$santarow = mysql_fetch_array($result);
$santaname = $santarow['first'].' '.$santarow['last'];

//Check Recipient

$result = mysql_query("SELECT child FROM relationships WHERE santa='$userid'");
if(mysql_num_rows($result) == 0){
	die("DF");	
}
$row = mysql_fetch_array($result);
$childID = $row['child'];

$result = mysql_query("SELECT first, last FROM setup WHERE userid='$childID'");
$childrow = mysql_fetch_array($result);
$childname = $childrow['first'].' '.$childrow['last'];



?>


<!DOCTYPE html>
<html>
<head>
	<title>HW Santa - Home</title>
	<link href="../css/style.css" rel="stylesheet" />
	<link href="../css/common.css" rel="stylesheet" />
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js"></script>
	<script src="../js/jquery.easing.1.3.js"></script>
	<script src="../js/custommodernizr.js"></script>
	<script src="../js/jquery.dropdown.js"></script>
	<style>
		#sidebar .tab{
			padding:10px 5px;
			transition:all .1s;
			-o-transition:all .1s;
			-moz-transition:all .1s;
			-webkit-transition:all .1s;
		}
		#sidebar .tab p{
			float:none;
			text-align: center;
			cursor:pointer;
			text-decoration:none;
		}
		#sidebar .tab.current{
			background: rgb(0,89,3);
		}
		#sidebar .tab:hover{
			background: rgb(163,0,0);
		}
		.countdown{
			font-size: 24px;
		}
		.red{
			font-size: 60px;
		}
		.card{
			width:400px;
			height:140px;
			box-sizing: border-box;
			-moz-box-sizing: border-box;
			background: white;
			box-shadow: 1px 0px 5px black;
			
			padding:15px;
		}
		.cardtitle{
			text-align: center;
			font-weight: 100;
		}
		.cardbody{
			text-align: center;
			display: block;
		}
		
	</style>
</head>
<body>
	<div id="wrapper">
		<div id='mainbar'>
			<h1 id="greeting">Welcome Back, <?=$name?>.</h1>
			<div class="countdown">
				<span class="red">3</span> days left to Santageddon.
			</div>
			<br/>
			<br/>
			<div class="card card1">
				<h3 class="cardtitle">You are secret santa for:</h3>
				<strong class="cardbody"><?=$childname?></strong>
			</div>
			<br/>
			<br/>
			<div class="card card1">
				<h3 class="cardtitle">Your secret santa is:</h3>
				<strong class="cardbody">???</strong>
			</div>
		</div>
	</div>
	<div id='sidebar'>
		<a class="tab" href="http://hwsanta.com/">
			<img id="dalogo" src="../img/dalogo.png" />
		</a>
		<a class="tab current" href="home.php">
			<p>Home</p>
			<div class="clear"></div>
		</a>
		<a class="tab" href="rules.php">
			<p>The Rules</p>
			<div class="clear"></div>
		</a>
		<a class="tab" href="recipient.php">
			<p>Chat w/ Recipient</p>
			<div class="clear"></div>
		</a>
		<a class="tab" href="santa.php">
			<p>Chat w/ Santa</p>
			<div class="clear"></div>
		</a>
<!--
		<a class="tab" href="donate.php">
			<p>Donate</p>
			<div class="clear"></div>
		</a>
-->
	</div>
	<script>

	</script>
</body>
</html>