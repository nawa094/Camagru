<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Home Page: Camagru</title>
	<link rel="stylesheet" href="../css/main.css">
</head>
<body>
<?php
	session_start();
	require "../db_con/config.php";
	unset($check);
		$check = $_GET['access'];
		if (empty($check))
			header("Location: ../auth/login.php");
		$check1 = $_SESSION['username'];
		$sql = "SELECT * FROM users WHERE `username`='$check1'";
		$ret = $conn->query($sql);
		if ($ret->fetchColumn() > 0)
		{
			foreach ($conn->query($sql) as $tum)
			{
				$pass = $tum['passwd'];
			}
		}
		if ($_GET['access'] != $pass)
		{
			echo "<script>alert('You shouldn't be here')</script>";
			header("../index.php");
			die();
		}
		$_SESSION['pass'] = $pass;
		date_default_timezone_set('Africa/Johannesburg');
?>
	<header>
		<a href="<?php echo 'home.php?access='.$pass?>"><img src="../img/home_icon.png" alt="home" id="header_link"></a>
		<a href="insert.php"><img src="../img/add_icon.png" alt="search" id="header_link"></a>
		<a href="camera.php"><img src="../img/camera_icon.png" alt="likes" id="header_link"></a>
		<a href="logout.php"><img src="../img/logout_icon.png" alt="logout" id="header_link"></a>
		<a href="profile.php"><img src="../img/profile_icon.png" alt="profile" id="header_link"></a>
		<p style="text-align: center;font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;">You are logged in as: <?php echo $_SESSION['username'];?></p>
		<div class="pagination">
		Pages:<?php
			
				$sql = "SELECT * FROM media";
				$results_per_page = 10;
				$result = $conn->query($sql);
				$number_of_results = $result->rowCount();
				$number_of_pages = ceil($number_of_results/$results_per_page);
				$page = 1;
				while ($page<=$number_of_pages)
				{
					echo "<a href=home.php?access=" . $pass . "&page=" . $page . ">" ." " . $page ."</a>";
					$page++;
				}
				if (!isset($_GET['page']))
			{
				$page = 1;
			} else {
				$page = $_GET['page'];
			}
			?>
			</div>
	</header>
	<section class="container">
	<?php
		require_once "../db_con/config.php";
		$starting_page_limit = ($page - 1) * $results_per_page;
		$sql = "SELECT * FROM media LIMIT " .$starting_page_limit. "," .$results_per_page;
		$res = $conn->query($sql);
		if ($res->fetchColumn() > 0)
		{
			foreach ($conn->query($sql) as $res)
			{
				$src = $res['picture'];
				$user = $res['username'];
				$cap = trim($res['caption']);
				$likes = $res['likes'];
				$id = $res['id'];
				?>
		<div class="card">
			<div class="card-header">
				<div class="profile"><?php 
				echo $user;
				$eish = $_SESSION['username'];
						if ($user == $eish)
						{
							echo "<div class='delete'><a href='delete.php?user=$user&id=$id'><img src='../img/bin.png'></div></a>";
						}			
				?></div>
			</div>
		<div class="media">
		<a href="like_comment.php?user=<?php echo $user;?>&id=<?php echo $id?>"><img src="<?php echo $src?>" style="text-align: center;width: 570px;height: 425px;"/></a>
		</div>
		<div class="card-footer"> 
			<p id="user-comment" style="text-align:center;font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;"><?php echo "@".$user."'s Caption:"." ".$cap;?></p>
			<p style="text-align: center;font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;"><?php echo "likes: ".$likes?></p>
			<?php
				$sql = "SELECT * FROM comments WHERE user = '$user' AND pid = '$id'";
				$result = $conn->query($sql);
				$num = $result->rowCount();
				?>
			<p style="text-align: center;font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;margin-top: -2%;">Comments: <?php echo $num ?></p>
		</div>
		</div><br /><br />
		<?php
			}
		}
		else
		{
			?>
			<div class="no_content">We don't have any posts yet:(</div>
			<?php
		}
	?>
		<hr>
	</section>			
</body>
</html>