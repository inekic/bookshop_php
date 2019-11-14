<?php
	# Database connection
	include ("dbconn.php");
print '
<!DOCTYPE HTML>
<html>
	<head>
		<link rel="stylesheet" href="style.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<link href="https://fonts.googleapis.com/css?family=DM+Serif+Text&display=swap" rel="stylesheet"><title>Bookshelf</title>
		<meta http-equiv="content-type" content="text/html; charset=UTF-8">
		<meta name="description" content="">
		<meta name="keywords" content="books, bookshelf, reading, blog">
		<meta name="author" content="Iva Nekic">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="shortcut icon" type="image/x-icon" href="img/favicon.ico">
	</head>
<body>
	<header>
		<div class="banner"></div>
		<nav>';
			include("menu.php");
			print '
		
		</nav>
	</header>
	
	<main>';
	
	# Homepage
	if (!isset($_GET['menu']) || $_GET['menu'] == 1) { include("home.php"); }
	
	# News
	else if ($_GET['menu'] == 2) { include("new_reviews.php"); }
	
	# Contact
	else if ($_GET['menu'] == 3) { include("contact.php"); }
	
	# About us
	else if ($_GET['menu'] == 4) { include("about_us.php"); }
	
	# Gallery
	else if ($_GET['menu'] == 5) { include("gallery.php"); }	
	
	# Register
	else if ($_GET['menu'] == 6) { include("register.php"); }
	
	# Signin
	else if ($_GET['menu'] == 7) { include("signin.php"); }
	
	# Admin webpage
	else if ($_GET['menu'] == 8) { include("admin.php"); }
	
	
	print '
	</main>
	


<footer>
	<div>
		
		<a href="#" class="fa fa-facebook"></a>
		<a href="#" class="fa fa-twitter"></a>
		<a href="#" class="fa fa-instagram"></a>
		<p>Bookshelf, established - October,2019. Iva Nekić </p>	
	</div>

</footer>
</body>
</html>';
?>