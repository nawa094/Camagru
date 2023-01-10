<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<link rel="stylesheet" href="../css/like_comment.css">
	<title>The ops watching</title>
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
	<div class="sure">Are you sure you want to delete this?</div>
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
		?>" alt="image">
		<hr>
		<div class="input">
			<form method="post">
				<input type="submit" name="delete_that_shit" value="DELETE" id = "delete">
				<input type="submit" name="nah" value="Whoops, Don't Delete" id = "nah">
			</form>
			<?php
			if (isset($_POST['delete_that_shit']))
			{
				$u = $_GET['user'];
				$ident = $_GET['id'];
				$sql = "DELETE FROM media WHERE username = '$u' AND id = '$ident'";
				$conn->exec($sql);
				echo "<script>alert('Deleted that shit fam')</script>";
				$url = 'home.php?access='.$_SESSION['pass'];
				header( "Refresh:1; url=$url", true, 303);
			}
			else if (isset($_POST['nah']))
			{
				echo "<script>alert('SMH lemme take you back, give me a sec.')</script>";
				$url = 'home.php?access='.$_SESSION['pass'];
				header( "Refresh:1; url=$url", true, 303);
			}
			?>
		</div>
</body>
</html>