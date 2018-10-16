<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Find Address Index Page</title>
	<meta name="description" content="Web Api for finding an address">
	<meta name="keywords" content="HTML,PHP">
	<meta name="author" content="Stathis Liampas">	
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<link rel="icon" type="image/png" href="icons/google_icon.png">
</head>
<body>
<?php 
	//anoikse to arxeio ini kai pare tin  teleutaia epilogh tou xristi gia ton tropo anazitisis 
	$myfile = fopen("findAddress.ini", "r") or die("Unable to open file!");
	$page  = fgets($myfile);
	fclose($myfile);
	$sec = "0";
	header("Refresh: $sec; url=$page");
?>	
</body>
</html>