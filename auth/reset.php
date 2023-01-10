<?php

	if (isset($_POST['passwdreset']))
	{
		session_start();
		require "../db_con/config.php";
		$passwd = $_POST['passwd'];
		$cpasswd = $_POST['cnewpass'];
		if ($passwd === $cpasswd)
		{
			$user = $_GET['username'];
			$newpass = hash("whirlpool", $_POST['passwd']);
			$sql = "UPDATE users SET passwd='$newpass' WHERE username='$user'";
			$conn->exec($sql);
			echo "<script>alert('Success!')</script>";
			$_SESSION['pass'] = $newpass;
			header('Location: login.php');
		}
		else
		{
			echo "<script>alert('Passwords do not match')</script>";
		}
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Document</title>
</head>
<body>
	Reset Password: <br>
	<div style="margin-top: 80px;">
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
	
</body>
</html>