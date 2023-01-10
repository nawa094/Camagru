<?php
	require "../db_con/config.php";
	if (isset($_POST['reset']))
	{
		$loser = $_POST['user'];
		$sql = "SELECT * FROM users WHERE username='$loser'";
		$query = $conn->query($sql);
		if ($query->fetchColumn() > 0)
		{
			try
			{
				$q = "SELECT email FROM users WHERE username='$loser'";
				$ret = $conn->query($q);
				foreach ($conn->query($q) as $ret)
				{
					$mail = $ret['email'];
				}
			$message = "
				please click the following link to reset your password 'localhost:8080/Camagru/auth/reset.php?username=$loser'
			";
			$to = $mail;
			$subject = 'Camagru: Password reset';
			$headers = 'From: camagru@WTC.co.za' . "\r\n" .
    		'Reply-To: DoNotReply@WTC.com' . "\r\n" .
    		'Content-Type: text/html; charset=ISO-8859-1\r\n';

			$mail = mail($to, $subject, $message, $headers);
			if ($mail)
				echo "Registered successfully";
			else
				echo "email Not Sent ".$email;
			}
			catch (PDOException $exception)
			{
				echo $exception->getMessage();
			}
		}
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Reset My Shit</title>
</head>
<body>
	<div>
		<form method="post">
			Please enter username: <input type="text" name="user">
			<input type="submit" name="reset" value="reset">
		</form>
	</div>
	
</body>
</html>