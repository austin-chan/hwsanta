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
		#rules{
			padding-left:30px;
			font-size:24px;
			width:800px;
		}
		
	</style>
</head>
<body>
	<div id="wrapper">
		<div id='mainbar'>
			<h1 id="greeting">Rules</h1>
			<div id="rules">
				<p>
				I commit to giving a gift to my assigned person on or before Friday, Dec. 21.
				</p>
				<p>
				The gift will not cost more than $20 and must be appropriate for school. Would your English teacher be okay with your gift?
				</p>
				<p>
				Any inappropriate gifts may be subject to disciplinary action.  Ask Mr. Church if you aren't sure about your gift.
				</p>
				<p>
				I will not forget to give a gift to my assigned person because forgetting to give a gift after making a promise to give one is incredibly lame.
				</p>
				<p>
				I will use the communication features of HW Santa responsibly.  Any inappropriate messages may be subject to disciplinary action.
				</p>
			</div>
		</div>
	</div>
	<div id='sidebar'>
		<a class="tab" href="http://hwsanta.com/">
			<img id="dalogo" src="../img/dalogo.png" />
		</a>
		<a class="tab" href="home.php">
			<p>Home</p>
			<div class="clear"></div>
		</a>
		<a class="tab current" href="rules.php">
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