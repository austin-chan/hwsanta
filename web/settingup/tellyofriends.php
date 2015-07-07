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
	h3{
		width:400px;
	}
	a.button{
		width:300px;
	}
	</style>
</head>
<body>
	<div id="fb-root"></div>
	<script>(function(d, s, id) {
	  var js, fjs = d.getElementsByTagName(s)[0];
	  if (d.getElementById(id)) return;
	  js = d.createElement(s); js.id = id;
	  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
	  fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));</script>
	<div id="wrapper">
		<div id='mainbar'>
			<h1>4. Tell yo friends</h1>
			<h3>Get your friends to join before it's too late.  Share HW Santa! More gifts!</h3>
			<h3>After registration ends this weekend, we'll start the selection process.  Then you'll be able to pick your gift-recipient from 5 choices!</h3>
			<br/>
			<br/>
			<div class="fb-like" data-href="http://www.facebook.com/pages/HW-Santa/494324190611560" data-send="false" data-width="450" data-show-faces="true"></div>
			<br/>
			<br/>
			<a class="button ml-button-2" href="select.php">Selection Process will begin soon</a>
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
			<img class="number" src="../img/numbers/4.png" />
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