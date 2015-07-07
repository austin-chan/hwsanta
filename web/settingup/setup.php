<?php

include("../site/connect.php");

if(!empty($_POST)){
	
	$first = mysql_real_escape_string( $_POST['first'] );
	$last = mysql_real_escape_string( $_POST['last'] );
	$gender = mysql_real_escape_string( $_POST['gender']);
	$grade =mysql_real_escape_string($_POST['grade']);
	$userid = $_SESSION['userid'];
	
	if(empty($first) || empty($last) || empty($gender) || empty($grade) ){
		$error = "Please complete all fields";
	}else{
		$query = "SELECT * FROM verified WHERE userid='$userid'";
		$result = mysql_query($query);
		
		if(mysql_num_rows($result) == 0){
			die("error");
		}
		$row = mysql_fetch_array($result);
		
		$username = $row['username'];
		$password = $row['password'];
		$pickedalready = 0;
		$assignedalready = 0;
		
		
		$query = "INSERT INTO setup (userid, first, last, gender, grade, username, password, pickedalready, assignedalready) VALUES ('$userid', '$first', '$last', '$gender', '$grade', '$username', '$password', '$pickedalready', '$assignedalready')";
		mysql_query($query);
		
		$query = "DELETE FROM verified WHERE userid='$userid'";
		$result = mysql_query($query);
		
		$query = "DELETE FROM verified WHERE userid='$userid'";
		
		header("Location:http://hwsanta.com/settingup/tellyofriends.php");
		
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
			<h1>3. Who are you?</h1>
<?php
if($error)echo $error."<br/>";
?>
			<form method="post">
			<div>
				First Name:<input name="first" type="text" />
				Last Name:<input name="last" type="text" />
				<br/>
				<select name="grade" id="gradedropdown" class="cd-select">
				    <option value="-1" selected>Choose Grade</option>
				    <option value="Sophomore">Sophomore</option>
				    <option value="Junior">Junior</option>
				    <option value="Senior">Senior</option>
				</select>
				<select name="gender" id="genderdropdown" class="cd-select">
				    <option value="-1" selected>Choose Gender</option>
				    <option value="Male">Male</option>
				    <option value="Female">Female</option>
				</select>
			</div>
			<input type="submit" id="submit" class="button ml-button-10" value="Click to Continue">
			</form>
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
			<img class="number" src="../img/numbers/3.png" />
			<p>Who are you?</p>
			<div class="clear"></div>
		</div>
		<div class="tab">
			<img class="number" src="../img/numbersbw/4.png" />
			<p>Tell your friends</p>
			<div class="clear"></div>
		</div>
		<div class="tab">
			<img class="number" src="../img/numbersbw/5.png" />
			<p>Choose gift recipient</p>
			<div class="clear"></div>
		</div>
	</div>
	<script>
		$("#gradedropdown").dropdown( {
					gutter : 5,
					delay : 100,
					random : true
				} );
		$("#genderdropdown").dropdown( {
					gutter : 5,
					delay : 100,
					random : true
				} );
		
	</script>
</body>
</html>