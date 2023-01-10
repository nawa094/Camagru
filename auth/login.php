<?php
	include_once "../db_con/config.php";
	session_start();
	if (isset($_POST['login_btn']))
	{
		$user = $_POST["username"];
		$password = $_POST["passwd"];

		$hash = hash("whirlpool", $password);
		$sql = "SELECT * FROM users WHERE username='$user' AND passwd='$hash'";
		$result = $conn->query($sql);
		if ($result->fetchColumn() > 0)
		{
			foreach($conn->query($sql) as $res)
			{
				$check = $res['passwd'];
				if ($res['confirmed'] == 1)
				{
					$_SESSION['message'] = "You are now logged in";
					$_SESSION['username'] = $user;
					header("Location: ../home/home.php?access=$check");
				}
				else
				{
					echo "<script>alert('Please Verify your account before logging in')</script>";
					echo "<script>window.open('login.php', '_self')</script>";
					die();
				}
			}
		}
		else
		{
			$_SESSION['message'] = "Username/Password incorrect";
		}
	}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Please Login</title>
	<link rel="stylesheet" href="../css/main.css">
</head>
<body>
	<div class="loginform">
	<form method="post" action="login.php">
				<p id="logintext">Username: </p>
				<input type="text" name="username" class="textInput">
				<p id="logintext">Password: </p>
				<input type="password" name="passwd" class="textInput"><br>
				<input type="submit" name="login_btn" value="login">
				<a href="../home/forgot.php"><p id="logintext">Forgot Password</p></a>
		</form>
	</div>
</body>
</html>