<?php
	session_start();
	if (empty($_SESSION['username']))
		header("Location: ../auth/login.php");
?>
<!doctype <!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>The ops watching</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" media="screen" href="../css/main.css" />
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
	<div class="container">
	<video id="video"></video>
	<img src="" id="filter" ><br>
	<img src="" id="filter2" ><br>
	<canvas id="canvas" style="display: none;"></canvas>
	<button onclick="snap();" name="snap">Snap</button>
	<form method="post" action="example.php">
	<select id="photo-filter" name="sticker">
		<option value="">Normal</option>
		<option value="../stickers/black.png">Black Panther</option>
		<option value="../stickers/ironman.png">Ironman</option>
		<option value="../stickers/mustache.png">Mustache</option>
		<option value="../stickers/punisher.png">Punisher</option>
		<option value="../stickers/starlord.png">Starlord</option>
		<option value="../stickers/vegeta.png">Vegeta</option>
		<option value="../stickers/monkey.png">Monkey</option>
	</select>
	<select id="photo-filter2" name="sticker-insert3">
		<option value="">Normal</option>
		<option value="../stickers/black.png">Black Panther</option>
		<option value="../stickers/ironman.png">Ironman</option>
		<option value="../stickers/mustache.png">Mustache</option>
		<option value="../stickers/punisher.png">Punisher</option>
		<option value="../stickers/starlord.png">Starlord</option>
		<option value="../stickers/vegeta.png">Vegeta</option>
		<option value="../stickers/monkey.png">Monkey</option>
	</select>
	<input type="hidden" name="url" id="url" value="">
	<input type="submit" name="hello" id="camera-submit">
	<p id="logintext">Caption: </p><input type="text" name="caption2" required>
	<div id="photos" class="photo-preview"><p id = "logintext">Don't worry. If you added stickers your upload will have stickers:)</p></div>
</form>
	<h2 id="logintext" style="padding: 10px;margin-top: 10px;">Your previous uploads</h2>
		<?php	
		require "../db_con/config.php";
		$user = $_SESSION['username'];
		$sql = "SELECT * FROM media WHERE username = '$user'";
		$ret = $conn->query($sql);
		if ($ret->fetchColumn() > 0)
		{
			foreach ($conn->query($sql) as $res)
			{
				$src = $res['picture'];
				$user = $res['username'];
				$cap = trim($res['caption']);
				$likes = $res['likes'];
				$id = $res['id'];
				?>
				<img src="<?php echo $src; ?>" alt="your image" style="height: 300px;width: 300px;padding: 10px;border: 2px solid black;">
				<?php
			}
		}
	?>
	</div>
	
	<script type="text/javascript">
		var video = document.getElementById('video');
		var canvas = document.getElementById('canvas');
		var context = canvas.getContext('2d');
		const photoFilter = document.getElementById('photo-filter');
		const photoFilter2 = document.getElementById('photo-filter2');
		const image = document.getElementById('filter');
		const image2 = document.getElementById('filter2');
		const photos = document.getElementById('photos');

		navigator.getUserMedia = navigator.getUserMedia || navigator.webkitGetUserMedia || navigator.mozGetUserMedia || navigator.oGetUserMedia || navigator.msGetUserMedia;
		if (navigator.getUserMedia)
		{
			navigator.getUserMedia({video:true}, streamWebCam, throwError);
		}
		function streamWebCam (stream) {
			video.src = window.URL.createObjectURL(stream);
			video.play();
		}
		function throwError (e) {
			alert(e.name);
		}
		function snap () {
			canvas.width = video.clientWidth;
			canvas.height = video.clientHeight;
			context.drawImage(video, 0, 0);

			const imgURL = canvas.toDataURL('image/png');
			const img = document.createElement('img');
			img.setAttribute('src', imgURL);
			photos.appendChild(img);
			// document.getElementById('userimage').setAttribute('value', imgURL);

			var pic = document.getElementById('url');
			pic.setAttribute('value', imgURL);

		}
		photoFilter.addEventListener('change', function(e) {
			filter = e.target.value;
			image.setAttribute('src', filter);
			image.setAttribute('style', "top: 90px;left: 10px;position: absolute;width: 300px; height: 300px;")
			image.style
			e.preventDefault();
			console.log(filter);
		})
		photoFilter2.addEventListener('change', function(a) {
			filter2 = a.target.value;
			image2.setAttribute('src', filter2);
			image2.setAttribute('style', "top: 90px;left: 300px;position: absolute;width: 300px; height: 300px;")
			image2.style
			a.preventDefault();
			console.log(filter2);
		})
	</script>
	<footer class="footer">
		<p id="logintext" style="margin-top: 80px;text-align:center;">"Footer"</p><br>
	</footer>
</body>
</html>