<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<link rel="stylesheet" href="../css/like_comment.css">
	<title>Likes and Comments</title>
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
	<div class="display_image">
		<img src="<?php
			require "../db_con/config.php";
			$u = $_GET['user'];
			$ident = $_GET['id'];
			$sql = "SELECT * FROM media WHERE username = '$u' AND id = '$ident'";
			$res = $conn->query($sql);
			if ($res->fetchColumn() > 0)
			{
				foreach ($conn->query($sql) as $res)
			{
				$src = $res['picture'];
				$likes = $res['likes'];
			}
		}
			echo $src;		
		?>" alt="image" style="height:480px;width:640px;">
		<div class="like-btn">
			<img src="../img/love.png">
			<form method="post">
				<input type="submit" name="like_post" value="LIKE!">
			</form>
			<?php
				if (isset($_POST['like_post']))
				{
					$update = $likes + 1;
					$sql = "UPDATE media SET likes = '$update' WHERE username = '$u' AND id = '$ident'";
					$conn->exec($sql);
					$u = $_GET['user'];
					$sql = "SELECT * FROM users WHERE username = '$u'";
					$res = $conn->query($sql);
					if ($res->fetchColumn() > 0)
					{
						foreach ($conn->query($sql) as $result)
						{
							$notif = $result['notif'];
							$email = $result['email'];
						}
						if ($notif == 1)
						{
							$who = $_SESSION['username'];
							$to      = $email;
							$message = "$who Just liked one of your Posts!";
							$subject = "Camagru: Someone liked your post";
							$headers = 'Content-Type: text/html; charset=ISO-8859-1';

							$mail = mail($to, $subject, $message, $headers);
						}
					}
					echo "<script>alert('You Just Liked This Post')</script>";	
				}
			?>
		</div>
	</div>
	<div class="comments-section">
		<hr><h2>Comment Section</h2>
		<hr>
		<div class="comment-box">
			<form method="post">
				<textarea name="comment" cols="90" rows="10" style="resize:none;" placeholder="Be nice..." required></textarea>
				<input type="submit" name="sub_comment" value="Comment!">
			</form>
			<?php
				if (isset($_POST['sub_comment']))
				{
					$commentor = $_SESSION['username'];
					$comment = $_POST['comment'];
					$sql = "INSERT INTO comments (pid, user, commentor, ctime, comment) VALUES ('$ident', '$u', '$commentor', NOW(), '$comment')";
					$conn->exec($sql);
					echo "<script>alert('Your comment was posted')</script>";
				}
			?> <hr>
		</div>
		<?php
			$sql = "SELECT * FROM comments WHERE user = '$u' AND pid = '$ident'";
			$result = $conn->query($sql);
			if ($result->fetchColumn() > 0)
		{
			foreach ($conn->query($sql) as $res)
			{
				$comment = $res['comment'];
				$who = $res['commentor'];
				?>
			<div class="comments">
				<p><?php echo "@".$who.":"." ".$comment?>
				<hr>
			</div>
			<?php } }?>

	</div>

</body>
</html>