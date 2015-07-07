<?php

include ("../site/connect.php");

$userid = $_SESSION['userid'];
if(empty($userid)){
	die('error. login');
}

$query = "SELECT userid FROM notpickedyet WHERE userid<>'$userid'";
$result = mysql_query($query);
$query2 = "SELECT userid FROM isselecting";
$result2 = mysql_query($query2);

if(mysql_num_rows($result) < 5 && mysql_num_rows($result2) > 0){
	$error = ('wait');
}

if(empty($error)){

$query = "SELECT * FROM hasntpickedyet WHERE userid='$userid'";
$me = mysql_query($query);

if(mysql_num_rows($me) == 0){
	die("You already gotten your chance to choose.");
}

$row = mysql_fetch_array($me);
$myuserid = $row['userid'];
$myname = $row['name'];
mysql_query("DELETE FROM hasntpickedyet WHERE userid='$userid'");
$result = mysql_query("SELECT grade FROM setup WHERE userid='$userid'");
$row = mysql_fetch_array($result);
$mygrade = $row['grade'];

$query = "INSERT INTO isselecting (userid, name) VALUES ('$userid','$myname')";
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

}

?>




<!DOCTYPE html>
<html>
<head>
	<link href="../css/style.css" rel="stylesheet" />
	<link href="../css/common.css" rel="stylesheet" />

	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js"></script>
	<script src="../js/jquery.easing.1.3.js"></script>
	<script src="../js/custommodernizr.js"></script>
	<script src="../js/jquery.dropdown.js"></script>
	<style>
		h1{
			font-size: 42px;
		}
		#rules{
			padding-left:30px;
			font-size:24px;
			width:800px;
		}
		input.button{
			width:300px;
			margin-top:250px;
		}
		.cd-dropdown{
			float:left;
			margin:30px 140px 30px 0px;
		}
		.cd-dropdown, .cd-select{

		}
		.cd-dropdown > span,
		.cd-dropdown ul li:nth-last-child(-n+3) span {
			box-shadow: 0 1px 1px rgba(0,0,0,0.1);
		}
		
		.cd-dropdown ul {
			position: absolute;
			top: 0px;
			width: 100%;
		}
		
		.cd-dropdown ul li {
			position: absolute;
			width: 100%;
		}
		
		.cd-active.cd-dropdown > span {
			color: black;
		}
		
		.cd-active.cd-dropdown > span,
		.cd-active.cd-dropdown ul li span {
			box-shadow: 0 1px 1px rgba(0,0,0,0.1);
			color:#777;
		}
		
		.cd-active.cd-dropdown ul li span {
			-webkit-transition: all 0.2s linear 0s;
			-moz-transition: all 0.2s linear 0s;
			-ms-transition: all 0.2s linear 0s;
			-o-transition: all 0.2s linear 0s;
			transition: all 0.2s linear 0s;
		}
		
		.cd-active.cd-dropdown ul li span:hover {
			background: #4d8c9d;
			color: #fff;
		}
	</style>
</head>
<body>
	<div id="wrapper">
		<div id='mainbar'>
		<h1>5. Select Your Recipient!</h1>
<?php
if(empty($error)){
?>
		<form id="selectform" method="post" action="selected.php">
		<select name="selected" id="selection" class="cd-select">
		    <option value="-1" selected>Choose Christmas Target</option>
<?php
			foreach($arr as $option){
				$name = $option['name'];
				$grade = $option['grade'];
				$userid = $option['userid'];
				echo "<option value='$userid'>$name ($grade)</option>";
			}

?>
		</select>
			<input type="hidden" name="userid" id="userid" />
			<input type="hidden" name="unselected" id="unselected" />
			<input type="submit" id="submit" class="button ml-button-10" value="Click to Continue">

		</form>
<?php
	}else{
		echo "Too many other people are currently selecting. Try again in a few seconds";
	}
?>
			
		</div>
	</div>
	<div id='sidebar'>
		<div class="tab">
			<a href="http://hwsanta.com/">
				<img id="dalogo" src="../img/dalogo.png" />
			</a>
		</div>
		<div class="tab">
			<img class="number" src="../img/numbersbw/1.png" />
			<p>The Rules</p>
			<div class="clear"></div>
		</div>
		<div class="tab">
			<img class="number" src="../img/numbersbw/2.png" />
			<p>Confirm Email</p>
			<div class="clear"></div>
		</div>
		<div class="tab">
			<img class="number" src="../img/numbersbw/3.png" />
			<p>Who are you?</p>
			<div class="clear"></div>
		</div>
		<div class="tab">
			<img class="number" src="../img/numbersbw/4.png" />
			<p>Tell your friends</p>
			<div class="clear"></div>
		</div>
		<div class="tab">
			<img class="number" src="../img/numbers/5.png" />
			<p>Choose gift recipient</p>
			<div class="clear"></div>
		</div>
	</div>
	<script>
				$("#selection").dropdown( {
					gutter : 5,
					delay : 100,
					random : true
				} );
	
	
	
		var userid = <?=$_SESSION['userid']?>;
		var submitted = false;
		var choices = [];
		var unselected = "";
<?php

		foreach($arr as $option){
?>
			choices.push("<?=$option['userid']?>");
<?php
		}

?>
			$("#selection").dropdown( {
					gutter : 5,
					delay : 100,
					random : true
				} );
				
			$("#selectform").submit(function(){
				var selected = $("#selection").val();
				if($("#selection").val() == -1){
					return false;
				}
				submitted = true;
				
				for(var x = 0; x < choices.length; x++){
					var choiceID = choices[x];
					if(choiceID != selected){
						unselected += choices[x] + ',';
					}
				}
				$("#userid").val(userid);
				$("#unselected").val(unselected);
				return true;
			});
				
				
			$(window).bind('beforeunload', function(){
				if(!submitted){
					return "DON'T LEAVE OR REFRESH! You must choose now or you'll mess the process up!";
				}
			});
			
	</script>
</body>
</html>