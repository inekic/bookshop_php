<?php 
	include 'vars.php';
	print '
<ul>
	<li><a href="index.php?menu=1">Home</a></li>
	<li><a href="index.php?menu=2">New Reviews</a></li>
	<li><a href="index.php?menu=3">Contact</a></li>
	<li><a href="index.php?menu=4">About</a></li>
	<li><a href="index.php?menu=5">Gallery</a></li>
	';
	//session_start();
	
		if (!$user and !$admin and !$editor) {
			print '
			<li><a href="index.php?menu=6">Register</a></li>
			<li><a href="index.php?menu=7">Sign In</a></li>';
		}
		
		if ($admin or $editor) {
			print '
			<li><a href="index.php?menu=8&action=1">Administration</a></li>';
		}
		
		if ($user or $admin or $editor) {
			print '
			
			<li><a href="signout.php">Sign Out</a></li>';
		}
		
				
		print '
</ul>';
?>