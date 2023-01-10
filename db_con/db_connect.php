<?php
	$username = root;
	$password = "123abc";
	$servername = "localhost";
	try 
	{
		$conn = new PDO("mysql:host=$servername", $username, $password);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "CREATE DATABASE IF NOT EXISTS camagru";
		$select = "USE camagru";
		$conn->exec($sql);
		$conn->exec($select);
		$sql = "CREATE TABLE IF NOT EXISTS users (
			id INT(5) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
			firstname VARCHAR(30) NOT NULL,
			lastname VARCHAR(30) NOT NULL,
			email VARCHAR(50),
			username VARCHAR(20),
			passwd VARCHAR(500)
		)";
		$conn->exec($sql);
		$sql = "CREATE TABLE IF NOT EXISTS media (
			id INT(5) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
			username VARCHAR(20),
			upload_time DATETIME,
			caption TEXT(150),
			picture TEXT(200),
			likes INT(200) NOT NULL DEFAULT 0
		)";
		$conn->exec($sql);
	}
	catch (PDOException $e)
	{
		echo $sql . "<br>" . $e->getMessage();
	}
?>