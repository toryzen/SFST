<html>
<head>
	<title>Error</title>
    <meta charset="UTF-8" />
</head>
<style>
	h1{color:red}
	.mainpannel{
		padding: 10px 0 30px 0 ;
		width:60%;
		margin-left:auto;
		margin-right:auto;
		text-align:center;
		-webkit-box-shadow:2px 2px 5px #333333;
	}
	.show{
		text-align:center;
		padding:25px;
		width:80%;
		margin-left:auto;
		margin-right:auto;
		-webkit-box-shadow:2px 2px 5px #333333;
	}
	hr{width:90%}
</style>
<body>

<p>
<div class="mainpannel">
	<h1>TZN Framework Error</h1>
	<hr/>
	<h2>TZN framework has stopped working !</h2>
	<div class="show">
		<?php echo $errinfo; ?>
	</div>
	<br/>
	
</div>
</p>

</body>
</html>