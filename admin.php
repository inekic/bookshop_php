<?php 
	#include 'vars.php';

	#if ($_SESSION['user']['valid'] == 'true') {
	if ($admin or $editor) {
		if (!isset($action)) { $action = 1; }
		print '
		<div class="centered">
		<h1>Administration</h1>
		
			
			
			<ul>
			
				';
				if ($admin)	{
						
						print'
							<li><a href="index.php?menu=8&amp;action=1">Users</a></li>';}
				print'
				<li><a href="index.php?menu=8&amp;action=2">Reviews</a></li>
			</ul>';
			# Admin Users
			if (($_GET['action']  == 1) && $admin) { include("admin/users.php"); }
			
			# Admin Reviews
	else if ($_GET['action'] == 2) { include("admin/reviews.php"); }
		print '
		</div>';
	}
	else {
		$_SESSION['message'] = '<p>Please register or login using your credentials!</p>';
		header("Location: index.php?menu=6");
	}
?>