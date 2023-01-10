<?php
	include("../db_con/config.php");	
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Upload: Camagru</title>
		<link rel="stylesheet" href="../css/main.css">
	</head>
	<body bgcolor="skyblue">
	<header>
		<a href="<?php session_start(); echo 'home.php?access='.$_SESSION['pass'];?>"><img src="../img/home_icon.png" alt="home" id="header_link"></a>
		<a href="insert.php"><img src="../img/add_icon.png" alt="search" id="header_link"></a>
		<a href="camera.php"><img src="../img/camera_icon.png" alt="likes" id="header_link"></a>
		<a href="logout.php"><img src="../img/logout_icon.png" alt="logout" id="header_link"></a>
		<a href="profile.php"><img src="../img/profile_icon.png" alt="profile" id="header_link"></a>
		<p style="text-align: center;font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;">You are logged in as: <?php echo $_SESSION['username'];?></p>
	</header>
		<div id="insert-text">
			<h1>Please Upload Your Post</h1>
		</div>
		<form action="insert.php" method="post" enctype="multipart/form-data">
			<table align="center" width="1000px" class="insert-table">
				<tr>
				</tr>
				<tr>
					<td align="center">Add Caption</td>
					<td><input type="text" name="caption" required></td>
				</tr>					
				<tr>
					<td align="center">Image</td>
					<td><input type="file" name="pic" id="input" required/></td>
				</tr>
				<tr>
					<td align="center">Add a sticker</td>
					<td>
						<select id="photo-filter" name="sticker-insert">
							<option value="">Normal</option>
							<option value="../stickers/black.png">Black Panther</option>
							<option value="../stickers/ironman.png">Ironman</option>
							<option value="../stickers/mustache.png">Mustache</option>
							<option value="../stickers/punisher.png">Punisher</option>
							<option value="../stickers/starlord.png">Starlord</option>
							<option value="../stickers/vegeta.png">Vegeta</option>
							<option value="../stickers/monkey.png">Monkey</option>
						</select></td>
				</tr>
				<tr>
					<td align="center">Add another sticker</td>
					<td>
						<select id="photo-filter2" name="sticker-insert2">
							<option value="">Normal</option>
							<option value="../stickers/black.png">Black Panther</option>
							<option value="../stickers/ironman.png">Ironman</option>
							<option value="../stickers/mustache.png">Mustache</option>
							<option value="../stickers/punisher.png">Punisher</option>
							<option value="../stickers/starlord.png">Starlord</option>
							<option value="../stickers/vegeta.png">Vegeta</option>
							<option value="../stickers/monkey.png">Monkey</option>
						</select></td>
				</tr>
				<tr>
					<td align="center">Keywords</td>
					<td><input type="text" name="keywords" size="50" required/></td>
				</tr>
				<tr>
					<td><input align="center" type="submit" name="insert_post" value="Post!" /></td>
				</tr>
			</table>
					<input type="hidden" name="url" id="url" value="">
					<canvas id="canvas" style="display: none;"></canvas>
					</form>
					<footer style="width: 100%; height: 300px;background: gray;margin-top: 7%;">
		<p id="logintext" style="margin-top: 80px;text-align:center;">"Footer"</p><br>
	</footer>
	</body>
	<script>
		var input = document.getElementById('input');
		
		input.addEventListener('change', handleFiles, false);

	function handleFiles(e) {
    	var ctx = document.getElementById('canvas').getContext('2d');
		var img = new Image;

    	img.src = URL.createObjectURL(e.target.files[0]);
    	
		img.onload = function() {
		canvas.width = this.naturalWidth;
		canvas.height = this.naturalHeight;
        
		ctx.drawImage(img, 0, 0);
		const imgURL = canvas.toDataURL('image/png', 0);
		console.log(imgURL)
		var pic = document.getElementById('url');
		pic.setAttribute('value', imgURL);
    }
}
	</script>
</html>
<?php
	session_start();
	if (isset($_POST['insert_post']))
	{
		if (isset($_POST['sticker-insert']))
		{
			$data = $_POST["url"];
			if (empty($data))
				die();
			$capt = $_POST['caption'];
			$user = $_SESSION['username'];
			$dest = imagecreatefrompng($data);
			$src = imagecreatefrompng($_POST['sticker-insert']);
			
			$filename = rand().$_SESSION['username'].".png";
			$path = "images/".basename($filename);
			imagecopy($dest, $src, 0, 0, 0, 0, 300, 300);
			imagepng($dest, $filename, 0);
			if (isset($_POST['sticker-insert2']))
			{
				$dest2 = imagecreatefrompng($filename);
				$src = imagecreatefrompng($_POST['sticker-insert2']);
				list($width, $height) = getimagesize($filename);
				imagecopy($dest2, $src, $width - 300, 0, 0, 0, 300, 300);
				imagepng($dest2, $filename, 0);
				imagedestroy($dest);
				imagedestroy($dest2);
				imagedestroy($src);
				$sql = ("INSERT INTO media (username, upload_time, caption, picture) VALUES ('$user', NOW(), '$capt', '$path')");
				$conn->exec($sql);
				if (rename($filename, "images/$filename"))
			{
				echo "<script>alert('Your Post has been uploaded successfully')</script>";
			}
				else
			{
				echo "<script>alert('Sticker error 2 bro')</script>";
				echo "<script>window.open('insert.php', '_self')</script>";
				$sql = "DELETE FROM media WHERE username = '$user' AND picture = '$path' AND caption = '$capt'";
				$conn->exec($sql);
			}
				header( "Refresh:1; url=camera.php", true, 303);
			die();
			}
			$sql = ("INSERT INTO media (username, upload_time, caption, picture) VALUES ('$user', NOW(), '$capt', '$path')");
			$conn->exec($sql);
			if (rename($filename, $path))
			{
				echo "<script>alert('Your Post has been uploaded successfully')</script>";
			}
			else
			{
				echo "<script>alert('Sticker error bro')</script>";
				$sql = "DELETE FROM media WHERE username = '$user' AND picture = '$path' AND caption = '$capt'";
				$conn->exec($sql);
			}
			header( "Refresh:1; url=camera.php", true, 303);
			die();
		}
		$path = "images/".basename($_FILES['pic']['name']);
		$caption = $_POST['caption'];
		$message = "";
		$username = $_SESSION['username'];
		$keywords = $_POST['keywords'];
		$image = $_FILES['pic']['name'];
		$image_tmp = $_FILES['pic']['tmp_name'];
		$sql = ("INSERT INTO media (username, upload_time, caption, picture) VALUES ('$username', NOW(), '$caption', '$path')");
		$conn->exec($sql);
		if (move_uploaded_file($_FILES['pic']['tmp_name'], $path))
		{
			echo "<script>alert('Your Post has been uploaded successfully')</script>";
		}
		else
		{
			echo "<script>alert('There was an error uploading your post')</script>";
			echo "<script>window.open('insert.php', '_self')</script>";
		}
	}
?>