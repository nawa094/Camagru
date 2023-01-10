<?php
	function setup($conn)
	{
		$sql = "CREATE DATABASE IF NOT EXISTS camagru";
		$select = "USE camagru";
		$conn->exec($sql);
		$conn->exec($select);
		$sql = "CREATE TABLE IF NOT EXISTS users (
			id INT(5) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
			firstname VARCHAR(30) NOT NULL,
			lastname VARCHAR(30) NOT NULL,
			email VARCHAR(50),
			confirmed INT(11),
			confirmcode INT(11),
			notif INT(11) NOT NULL DEFAULT 1,
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
		$sql = "CREATE TABLE IF NOT EXISTS comments (
			cid INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
			pid int(5),
			user VARCHAR(128) NOT NULL,
			commentor VARCHAR(128) NOT NULL,
			ctime datetime NOT NULL,
			comment TEXT NOT NULL			
		)";
		$conn->exec($sql);
	}
?>