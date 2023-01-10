<?php
	include "setup.php";
	$DB_DSN = "mysql:host=localhost";
	$DB_USER = 'root';
	$DB_PASSWORD = "123abc";
	try 
	{
		$conn = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}
	catch (PDOException $e)
	{
		echo $sql . "<br>" . $e->getMessage();
	}
	setup($conn);
?>