<?php
	include_once "../db_con/config.php";
	session_start();
	if (isset($_POST['register_btn']))
	{
		$user = trim($_POST["username"]);
		$name = trim($_POST["firstname"]);
		$sname = trim($_POST["lastname"]);
		$email = $_POST["email"];
		$password = $_POST["passwd"];
		$confirm = $_POST["cpasswd"];
		$sql = "SELECT * FROM users";
		$check = $conn->query($sql);
		if ($check->fetchColumn() > 0)
		{
			foreach($conn->query($sql) as $res)
			{
				if ($user == $res['username'])
				{
					echo "<script>alert('Username already exists')</script>";
					echo "<script>window.open('register.php', '_self')</script>";
					die();
				}
			}
		}
		if ($password == $confirm)
		{
			$confirmcode = rand();
			$message = "
				<!DOCTYPE html>
				<html>
				<body>
					Please click the link to verify your account <a href='http://localhost:8080/Camagru/auth/verify.php?username=$user&code=$confirmcode'>here</a>
				</body>
				</html>
			";
			$hashpass = hash("whirlpool", $password);
			$sql = "INSERT INTO users (firstname, lastname, email, confirmed, confirmcode, username, passwd) VALUES ('$name', '$sname', '$email', 0, '$confirmcode', '$user', '$hashpass')";
			$conn->exec($sql);
			$_SESSION['username'] = $user;
			$to      = $email;
			$subject = 'Camagru: Account Verification';
			$headers = 'Content-Type: text/html; charset=ISO-8859-1';

			$mail = mail($to, $subject, $message, $headers);
			if ($mail)
				echo "<div><p id='logintext' class='successful-register'>Registered successfully, Please check email and confirm account</div>";
			else
				echo "email Not Sent ".$email;
		}
		else
		{
			$error = "The two passwords do not match";
			echo "<script>alert('$error')</script>";
		}
	}
	
?>
<!DOCTYPE <!DOCTYPE html>
<html>
<head>
	<title>User Registration</title>
	<link rel="stylesheet" href="../css/main.css">
</head>
<body>
	<div class="header">
		<h1 id="register-welcome">Welcome, please register</h1>
	</div>
	<div class="register-form">
	<form method="post">
		<p id="logintext">Username: </p>
		<input type="text" name="username" class="textInput">
		<p id="logintext">First Name: </p>
		<input type="text" name="firstname" class="textInput">
		<p id="logintext">Last Name: </p>
		<p id="logintext"><input type="text" name="lastname" class="textInput"></p>
		<p id="logintext">Email: </p>
		<input type="text" name="email" class="textInput"></p>
		<p id="logintext">Password: </p>
		<input type="password" name="passwd" id="passwd" class="textInput" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" required>
		<p id="logintext">Confirm Password: </p>
		<input type="password" name="cpasswd" class="textInput"><br>
		<input type="submit" name="register_btn" value="register" style="padding: 10px;margin-top: 7px;">
	</form>
	</div>
<script>
	var myInput = document.getElementById("passwd");
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