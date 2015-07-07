<?php

include("connect.php");

if(empty($_SESSION)){
	header("Location:http://hwsanta.com/login.php");
}

$userid = $_SESSION['userid'];

$userrow = mysql_fetch_array(mysql_query("SELECT * FROM setup WHERE userid='$userid'"));
$name = $userrow['first'].' '.$userrow['last'];






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
		#chatbox{
			position: relative;
			background: #a8d2c2;
			height:500px;
			width:500px;
			border:1px solid #777;
			border-radius: 5px;
			-moz-border-radius: 5px;
		}
		#chatarea{
			width:478px;
			height:400px;
			overflow:scroll;
			border:1px solid #777;
			margin:10px 0px 0px 11px;
			box-shadow: inset 0px -3px 2px rgba(0,0,0,.5);
		}
		#message{
			position: absolute;
			font-size: 18px;
			padding:10px;
			bottom:10px;
			left:10px;
			height:50px;
			width:458px;
		}
		.chatitem{
			padding:15px;
			border-bottom: 1px solid #444;
			border-top:1px solid #ccc;
		}
		.chatitem.you{
			background: rgb(209,209,209);
		}
		.chatitem.notyou{
			background: rgb(232,178,179);
		}
		.chattitle{
			font-weight: bold;
		}
		.chatbody{
			margin-top:5px;
		}
		
	</style>
</head>
<body>
	<div id="wrapper">
		<div id='mainbar'>
			<h1 id="greeting">Chat with your Santa</h1>
			<div id="chatbox">
				<div id="chatarea">

				</div>
				<form id="theform">
				<textarea name="message" id="message" placeholder="yo what up"></textarea>
				<input type="hidden" id="userid" value="<?=$userid?>" />
				</form>
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
		<a class="tab" href="rules.php">
			<p>The Rules</p>
			<div class="clear"></div>
		</a>
		<a class="tab" href="recipient.php">
			<p>Chat w/ Recipient</p>
			<div class="clear"></div>
		</a>
		<a class="tab current" href="santa.php">
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
		var userid = $("#userid").val();
		var isReloading = false;
		
		$(document).keypress(function(e) {
		    if(e.which == 13) {
	            var message = $("#message").val();
	            $("#message").val('');
				$.ajax({
			        url: "http://hwsanta.com/app/home/messagesanta.php?userid="+userid+"&message="+message,
			        type: "post",
			        dataType: 'html',
			        // callback handler that will be called on success
			        success: function(response, textStatus, jqXHR){
				        if(response == "empty"){
					        alert("Sorry, you have not been selected yet. Check back soon to chat with your santa!");
				        }
			            $("#message").html("");
			            refresh();
			        }
			    });
		    }
		});	
	
		function refresh(){
			if(isReloading)return;
			isReloading = true;
			
			$.ajax({
		        url: "http://hwsanta.com/app/home/chatsanta.php?userid="+userid,
		        type: "post",
		        dataType: 'json',
		        // callback handler that will be called on success
		        success: function(response, textStatus, jqXHR){
		            // log a message to the console
		           
		           reload(response);
		        }
		    });
		}
		
		function reload(data){

			var chatarea = $("#chatarea").html("")
			for(var x = 0; x < data.length; x ++){
				var message = data[x];
				var wrap,title, message;
				
				if(message[0] == 'you'){
					wrap = $("<div></div>").addClass('chatitem you');
				}else{
					wrap = $("<div></div>").addClass('chatitem notyou');
				}
				title = $("<div></div>").addClass('chattitle').html(message[0]);
				wrap.append(title);
				
				message = $("<div></div>").addClass('chatbody').html(message[1]);
				wrap.append(message);
				
				chatarea.append(wrap);
			}
			isReloading = false;
		}
		setInterval(refresh, 7000);
		refresh();
	</script>
</body>
</html>