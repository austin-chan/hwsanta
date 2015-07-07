<?php
	include('site/connect.php');
?>
<!DOCTYPE html>
<html>
<head>
	<link href="css/style.css" rel="stylesheet" />
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js"></script>
	<script src="js/jquery.easing.1.3.js"></script>
	<style>
		#mid{
			margin:0 auto;
			width:600px;
			padding-top:50px;
		}
		#websitelogo{
			position:relative;
		}
		.fielditem{
			margin:15px 0px;
		}
		h2{
			font-weight: 400;
			font-size:32px;
		}
		h3{
			font-weight:100;
		}
		h5{
			display:inline;
			margin-right:20px;
		}
		input[type=text],input[type=password]{
			padding:5px;
		}
		a.button, input[type=submit]{
			width:250px;
		}
		input[type=submit]{
			padding-bottom: 33px;
		}
		#change{
			font-size: 12px;
		}
		#change a {
			text-decoration: none;
		}
		.pair{
			width:600px;
			padding:10px 0px;
		}
		.left{
			width:300px;
			float:left;
		}
		.right{
			width:300px;
			float:right;
		}
	</style>
</head>
<body>
	<div id="mid">
		<div id="rest">

		<h3>HW Santa Assignments.</h3>
		<div class="pair">
			<div class="left">
				<strong>Santa</strong>
			</div>
			<div class="right">
				<strong>Recipient</strong>
			</div>
		</div>
<?php

$relationshipsquery = mysql_query("SELECT * FROM relationships");
while($row = mysql_fetch_array($relationshipsquery) ){

$santaid = $row['santa'];
$childid = $row['child'];

$santaquery = mysql_query("SELECT first, last FROM setup WHERE userid='$santaid'");
$santarow = mysql_fetch_array($santaquery);

$childquery = mysql_query("SELECT first, last FROM setup WHERE userid='$childid'");
$childrow = mysql_fetch_array($childquery);

?>
<hr/>
		<div class="pair">
			<div class="left">
				<?=$santarow['first'].' '.$santarow['last']?>
			</div>
			<div class="right">
				<?=$childrow['first'].' '.$childrow['last']?>
			</div>
		</div>

<?php
}

?>
	</div>

<script>
</script>

</body>
</html>