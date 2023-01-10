<?php

	if (isset($_POST['passwdreset']))
	{
		session_start();
		require "../db_con/config.php";
		$passwd = $_POST['passwd'];
		$cpasswd = $_POST['cnewpass'];
		if ($passwd === $cpasswd)
		{
			$user = $_SESSION['username'];
			$newpass = hash("whirlpool", $_POST['passwd']);
			$sql = "UPDATE users SET passwd='$newpass' WHERE username='$user'";
			$conn->exec($sql);
			echo "<script>alert('Success! Password changed')</script>";
			$_SESSION['pass'] = $newpass;
		}
		else
		{
			echo "<script>alert('Passwords do not match $passwd $cpasswd')</script>";
		}
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<link rel="stylesheet" type="text/css" media="screen" href="../css/main.css" />
	<title>Profile</title>
</head>
<body>
<header>
		<a href="<?php session_start(); echo 'home.php?access='.$_SESSION['pass'];?>"><img src="../img/home_icon.png" alt="home" id="header_link"></a>
		<a href="insert.php"><img src="../img/add_icon.png" alt="search" id="header_link"></a>
		<a href="camera.php"><img src="../img/camera_icon.png" alt="likes" id="header_link"></a>
		<a href="logout.php"><img src="../img/logout_icon.png" alt="logout" id="header_link"></a>
		<a href="profile.php"><img src="../img/profile_icon.png" alt="profile" id="header_link"></a>
		<p style="text-align: center;font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;">You are logged in as: <?php echo $_SESSION['username'];?></p>
	</header>
	<br>
	<div style="margin-top: 80px;">
	<h2>Change password</h2>
	<form method="post">
		New Password:<input type="password" name="passwd" id="passwd2" class="textInput" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" required><br />
		Confirm Password:<input type="password" name="cnewpass" id="passwd2"><br />
		<input type="submit" name="passwdreset" value="Reset">
	</form>
	</div>
<script>
	var myInput = document.getElementById("passwd2");
	var letter = document.getElementById("letter");
	var capital = document.getElementById("capital");
	var number = document.getElementById("number");
	var length = document.getElementById("length");
	myInput.onkeyup = function() {
  	var lowerCaseLetters = /[a-z]/g;
  	if(myInput.value.match(lowerCaseLetters)) { 
    	letter.classList.remove("invalid");
    	letter.classList.add("valid");
  	} else {
    	letter.classList.remove("valid");
    	letter.classList.add("invalid");
	}
	}
	var upperCaseLetters = /[A-Z]/g;
  	if(myInput.value.match(upperCaseLetters)) { 
    capital.classList.remove("invalid");
    capital.classList.add("valid");
  	} else {
    capital.classList.remove("valid");
    capital.classList.add("invalid");
  }
  var numbers = /[0-9]/g;
  if(myInput.value.match(numbers)) { 
    number.classList.remove("invalid");
    number.classList.add("valid");
  } else {
    number.classList.remove("valid");
    number.classList.add("invalid");
  }
  if(myInput.value.length >= 8) {
    length.classList.remove("invalid");
    length.classList.add("valid");
  } else {
    length.classList.remove("valid");
    length.classList.add("invalid");
  }
}
</script>
<hr>
<div class="user-change">
	<h2>Change Username</h2>
	<form method="post">
		New Username: <input type="text" name="newusername" required><br />
		<input type="submit" name="changeuser" value="change Username!">
		<?php
		require "../db_con/config.php";
			if (isset($_POST['changeuser']))
			{
				$newme = $_POST['newusername'];
				$oldme = $_SESSION['username'];
				$sql = "UPDATE users SET username='$newme' WHERE username='$oldme'";
				$conn->exec($sql);
				$sql = "UPDATE media SET username='$newme' WHERE username='$oldme'";
				$conn->exec($sql);
				$_SESSION['username'] = $newme;
				echo "<script>alert('You are now $newme')</script>";
			}
		?>
	</form>
</div>
<hr>
<div class="changemail">
	<h2>Change your email adress</h2>
	<form method="post">
			Change your email: <input type="text" name="newemail"><br />
			<input type="submit" name="change_email" value="change!">
			<?php
				if (isset($_POST['change_email']))
				{
					$user = $_SESSION['username'];
					$newemail = $_POST['newemail'];
					$sql = "UPDATE users SET email='$newemail' WHERE username='$user'";
					$conn->exec($sql);
					echo "<script>alert('Your email has been changed to $newemail')</script>";
				}
			?>
	</form>
</div>
<hr>
<div class="changenotif">
	<h2>Change Notification Settings</h2>
	<?php
		$user = $_SESSION['username'];
		$sql = "SELECT notif FROM users WHERE username='$user'";
		$ret = $conn->query($sql);
		if ($ret->fetchColumn() > 0)
		{
			foreach ($conn->query($sql) as $res)
			{
				$check = $res['notif'];
			}
		}
		if ($check == 1)
		{
			?>
			<div class="notifOn">
			<h4>You will recieve email notifications, to turn off please click: </h4>
				<form method="post"><input type="submit" name="turnoff" value="No email"></form>
			</div>
			<?php
				if (isset($_POST['turnoff']))
				{
					$user = $_SESSION['username'];
					$sql = "UPDATE users SET notif=0 WHERE username='$user'";
					$conn->exec($sql);
					echo "<script>alert('You will no longer recieve email notifications')</script>";
					echo "<script>location.reload();</script>";
				}
			?>
			<?php
		}
		else if ($check == 0)
		{
			?>
			<div class="notifOff">
			<h4>You will not recieve email notifications, to turn on please click: </h4>
				<form method="post"><input type="submit" name="turnon" value="Yes email"></form>
			</div>
			<?php
				if (isset($_POST['turnon']))
				{
					$sql = "UPDATE users SET notif=1 WHERE username='$user'";
					$conn->exec($sql);
					echo "<script>alert('You will now recieve email notifications')</script>";
					echo "<script>location.reload();</script>";
				}
		}
	?>
</div>
</body>
</html>