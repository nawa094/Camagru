<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Verify</title>
</head>
<body>
	<?php
	session_start();
		
		require "../db_con/config.php";
		$username = $_GET['username'];
		$_SESSION['username'] = $username;
		$code = $_GET['code'];
		$sql = "SELECT * FROM users WHERE username = '$username'";
		$ret = $conn->query($sql);
		if ($ret->fetchColumn() > 0)
		{
			foreach ($conn->query($sql) as $res)
			{
				$check = $res['passwd'];
				if ($code === $res['confirmcode'])
				{
					$sql = "UPDATE users SET `confirmed`=1 WHERE username = '$username'";
					$conn->exec($sql);
					$sql = "UPDATE users SET `confirmcode`=0 WHERE username = '$username'";
					$conn->exec($sql);
					header("location: ../home/home.php?access=$check");
				}
				else
				{
					echo "username and code don't match";
				}
			}
		}
		else
			echo "username not found";
	?>	
</body>
</html>