<?php
require "../db_con/config.php";

if (isset($_POST["hello"]))
{
	session_start();
	$data = $_POST["url"];
	if (empty($data))
	{
		echo "<script>alert('Please snap a picture before submitting')</script>";
		echo "<script>window.open('camera.php', '_self')</script>";
	}
	$capt = $_POST['caption2'];
	$user = $_SESSION['username'];
	$dest = imagecreatefrompng($data);
	$src = imagecreatefrompng($_POST['sticker']);

	$filename = rand().$_SESSION['username'].".png";
	$path = "images/".basename($filename);

	imagecopy($dest, $src, 0, 0, 0, 0, 300, 300);
	imagepng($dest, $filename);
	if (isset($_POST['sticker-insert3']))
			{
				$dest2 = imagecreatefrompng($filename);
				$src = imagecreatefrompng($_POST['sticker-insert3']);
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
	imagedestroy($dest);
	imagedestroy($src);

	$sql = ("INSERT INTO media (username, upload_time, caption, picture) VALUES ('$user', NOW(), '$capt', '$path')");
	$conn->exec($sql);
	if (rename($filename, $path))
		{
			echo "<script>alert('Your Post has been uploaded successfully')</script>";
		}
		else
		{
			echo "<script>alert('There was an error uploading your post')</script>";
			echo "<script>window.open('insert.php', '_self')</script>";
		}
		header( "Refresh:1; url=camera.php", true, 303);
}