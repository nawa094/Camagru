<?php
	session_start();
	$_SESSION = array();
	session_destroy();
	echo "<script>alert('You have been logged out successfully')</script>";
	echo "<script>window.open('../index.php', '_self')</script>";
?>