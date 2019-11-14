<?php

	session_start();
	$admin = $_SESSION['user']['valid'] == 'true' && $_SESSION['user']['access']=='admin';
	$editor = $_SESSION['user']['valid'] == 'true' && $_SESSION['user']['access']=='editor';
	$user = $_SESSION['user']['valid'] == 'true' && $_SESSION['user']['access']=='user';
?>