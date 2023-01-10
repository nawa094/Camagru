<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<link rel="stylesheet" href="css/main.css">
	<title>Camagru</title>
</head>
	<body>
	<header>
		<a href="auth/login.php"><img src="img/login.png" alt="search" id="header_link2"></a>
		<a href="auth/register.php"><img src="img/register.png" alt="likes" id="header_link2"></a>
		<p style="text-align: center;font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;">Please Login or Register</p>
		<div class="pagination">
		Pages:<?php
				require "db_con/config.php";	
				$sql = "SELECT * FROM media";
				
				$results_per_page = 10;
				$result = $conn->query($sql);
				$number_of_results = $result->rowCount();
				$number_of_pages = ceil($number_of_results/$results_per_page);
				$page = 1;
				while ($page<=$number_of_pages)
				{
					echo "<a href=index.php?page=" . $page . ">" ." " . $page ."</a>";
					$page++;
				}
				if (!isset($_GET['page']))
			{
				$page = 1;
			} else {
				$page = $_GET['page'];
			}
			?>
			</header>
			<section class="container">
	<?php
		$starting_page_limit = ($page - 1) * $results_per_page;
		$sql = "SELECT * FROM media LIMIT " .$starting_page_limit. "," .$results_per_page;
		$res = $conn->query($sql);
		if ($res->fetchColumn() > 0)
		{
			foreach ($conn->query($sql) as $res)
			{
				$src = "home/".$res['picture'];
				$user = $res['username'];
				$cap = trim($res['caption']);
				$likes = $res['likes'];
				$id = $res['id'];
				?>
		<div class="card">
			<div class="card-header">
				<div class="profile"></div>
			</div>
		<div class="media">
		<img src="<?php echo $src?>" style="text-align: center;width: 570px;height: 425px;"/>
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