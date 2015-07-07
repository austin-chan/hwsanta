<!DOCTYPE html>
<html>
<head>
<title>HW Santa - In Memoriam</title>
<link href="css/style.css" rel="stylesheet" />
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js"></script>
<script src="js/jquery.easing.1.3.js"></script>
<style>
	body{
		background: #000;
	}
	#memoriam{
		position: fixed;
		height:720px;
		left:50%;
		margin-left:-278px;
		display: block;
		margin-top:-60px;
	}
	#back{
		position: fixed;
		top:10px;
		left:20px;
		width:200px;
		font-weight: 100;
		opacity: .45;
	}
	#back:hover{
		opacity:.8;
	}
	#lifeup{
		width:100%;
		height:570px;
		position: relative;
		background: url('http://subtlepatterns.subtlepatterns.netdna-cdn.com/patterns/debut_dark.png');
		z-index: 10;
		border-top:1px solid #444;
		top:100%;
	}
	#lifetext{
		width:600px;
		font-size: 20px;
		margin:0 auto;
		padding-top:50px;
		color:#efefef;
		text-shadow: 1px 0px 2px black;
	}
</style>


</head>
<body>
	<a id="back" href="http://hwsanta.com/" class="button ml-button-4">&laquo; Back to HW Santa</a>
	<img id="memoriam" src="http://i.imgur.com/zgBzf.jpg" title="Designed by GnothiSeauton_Fool"/>
	<div id="lifeup">
		<div id="lifetext">
		"The majority of those who died today were children - beautiful, little kids between the ages of 5 and 10 years old. They had their entire lives ahead of them - birthdays, graduations, weddings, kids of their own. Among the fallen were also teachers, men and women who devoted their lives to helping our children fulfill their dreams.<br/>...<br/><br/>This evening, Michelle and I will do what I know every parent in America will do, which is hug our children a little tighter, and we'll tell them that we love them, and we'll remind each other how deeply we love one another. But there are families in Connecticut who cannot do that tonight, and they need all of us right now. In the hard days to come, that community needs us to be at our best as Americans, and I will do everything in my power as president to help, because while nothing can fill the space of a lost child or loved one, all of us can extend a hand to those in need, to remind them that we are there for them, that we are praying for them, that the love they felt for those they lost endures not just in their memories, but also in ours."<br/><br/>
		- President Obama (12/14/12)
		</div>
	</div>
	<script>
		$(window).scroll(function(){
			var scroll = $(this).scrollTop();
			
			$("#memoriam").css("opacity",  Math.max(0, (400 - scroll)/400) );
		});
	</script>
</body>
</html>