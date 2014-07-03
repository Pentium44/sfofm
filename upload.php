<?php

session_start();

if(!isset($_SESSION['hostz-user']) or !isset($_SESSION['hostz-passwd'])) { exit(1); }

$username = $_SESSION['hostz-user'];
$password = $_SESSION['hostz-passwd'];

// check if user is valid
include_once("users/$username.php");

// config variables
include_once("config.php");
$user_max_webspace = $config_var[1];
$user_max_upload = $config_var[2];

// get filesize for uploaded files
function tomb($size, $precision = 2)
{
    $base = log($size) / log(1024);
    $suffixes = array('', 'KB', 'MB', 'GB', 'TB');   

    return round(pow(1024, $base - floor($base)), $precision) . $suffixes[floor($base)];
}

if($password!=$user_password)
{
	$_SESSION['hostz-user'] = null;
	$_SESSION['hostz-passwd'] = null;
	exit(1);
}
echo "<html>";
for($i=0; $i<count($_FILES["file"]["name"]); $i++)
{
			
	$allowedExts = array("gif", "jpeg", "jpg", "png", "bmp", "ico", "swf", "txt", "html", "htm", "css", "js", "c", "cpp", "lua", "py", "tar", "zip", "rar", "gz", "7z", "bz2", "tgz", "mp3", "mp4", "ogg", "wav", "ogv", "flv", "webm");
	$temp = explode(".", $_FILES["file"]["name"][$i]);
	$extension = end($temp);
	if ((($_FILES["file"]["type"][$i] == "image/gif")
	|| ($_FILES["file"]["type"][$i] == "image/x-gif")
	|| ($_FILES["file"]["type"][$i] == "image/jpeg")
	|| ($_FILES["file"]["type"][$i] == "image/x-jpeg")
	|| ($_FILES["file"]["type"][$i] == "image/x-jpg")
	|| ($_FILES["file"]["type"][$i] == "image/jpg")
	|| ($_FILES["file"]["type"][$i] == "image/pjpeg")
	|| ($_FILES["file"]["type"][$i] == "image/x-png")
	|| ($_FILES["file"]["type"][$i] == "image/bmp")
	|| ($_FILES["file"]["type"][$i] == "image/x-icon")
	|| ($_FILES["file"]["type"][$i] == "text/css")
	|| ($_FILES["file"]["type"][$i] == "application/octet-stream")
	|| ($_FILES["file"]["type"][$i] == "text/html")
	|| ($_FILES["file"]["type"][$i] == "text/htm")
	|| ($_FILES["file"]["type"][$i] == "text/plain")
	|| ($_FILES["file"]["type"][$i] == "application/octet-stream")
	|| ($_FILES["file"]["type"][$i] == "application/x-gunzip")
	|| ($_FILES["file"]["type"][$i] == "application/x-gzip-compressed")
	|| ($_FILES["file"]["type"][$i] == "application/x-rar-compressed")
	|| ($_FILES["file"]["type"][$i] == "application/x-rar")
	|| ($_FILES["file"]["type"][$i] == "application/octet-stream")
	|| ($_FILES["file"]["type"][$i] == "application/x-7z-compressed")
	|| ($_FILES["file"]["type"][$i] == "application/x-7z")
	|| ($_FILES["file"]["type"][$i] == "application/x-compress")
	|| ($_FILES["file"]["type"][$i] == "application/x-compressed")
	|| ($_FILES["file"]["type"][$i] == "application/x-tar")
	|| ($_FILES["file"]["type"][$i] == "application/x-tar-compressed")
	|| ($_FILES["file"]["type"][$i] == "application/x-gtar")
	|| ($_FILES["file"]["type"][$i] == "application/x-tgz")
	|| ($_FILES["file"]["type"][$i] == "application/tgz")
	|| ($_FILES["file"]["type"][$i] == "application/tar")
	|| ($_FILES["file"]["type"][$i] == "application/gzip")
	|| ($_FILES["file"]["type"][$i] == "application/x-gzip")
	|| ($_FILES["file"]["type"][$i] == "application/x-zip")
	|| ($_FILES["file"]["type"][$i] == "application/zip")
	|| ($_FILES["file"]["type"][$i] == "application/x-zip-compressed")
	|| ($_FILES["file"]["type"][$i] == "text/c")
	|| ($_FILES["file"]["type"][$i] == "text/cpp")
	|| ($_FILES["file"]["type"][$i] == "text/lua")
	|| ($_FILES["file"]["type"][$i] == "text/py")
	|| ($_FILES["file"]["type"][$i] == "text/x-lua")
	|| ($_FILES["file"]["type"][$i] == "text/x-c")
	|| ($_FILES["file"]["type"][$i] == "audio/mp3")
	|| ($_FILES["file"]["type"][$i] == "audio/x-mp3")
	|| ($_FILES["file"]["type"][$i] == "audio/mpeg")
	|| ($_FILES["file"]["type"][$i] == "audio/x-mpeg")
	|| ($_FILES["file"]["type"][$i] == "audio/mpeg3")
	|| ($_FILES["file"]["type"][$i] == "audio/x-mpeg3")
	|| ($_FILES["file"]["type"][$i] == "audio/wav")
	|| ($_FILES["file"]["type"][$i] == "audio/wave")
	|| ($_FILES["file"]["type"][$i] == "audio/x-wav")
	|| ($_FILES["file"]["type"][$i] == "audio/ogg")
	|| ($_FILES["file"]["type"][$i] == "audio/x-ogg")
	|| ($_FILES["file"]["type"][$i] == "audio/mp4")
	|| ($_FILES["file"]["type"][$i] == "video/ogg")
	|| ($_FILES["file"]["type"][$i] == "video/webm")
	|| ($_FILES["file"]["type"][$i] == "video/x-flv")
	|| ($_FILES["file"]["type"][$i] == "video/mp4v-es")
	|| ($_FILES["file"]["type"][$i] == "application/x-python")
	|| ($_FILES["file"]["type"][$i] == "text/x-python")
	|| ($_FILES["file"]["type"][$i] == "text/python")
	|| ($_FILES["file"]["type"][$i] == "application/x-compressed")
	|| ($_FILES["file"]["type"][$i] == "text/javascript")
	|| ($_FILES["file"]["type"][$i] == "application/x-javascript")
	|| ($_FILES["file"]["type"][$i] == "application/bzip2")
	|| ($_FILES["file"]["type"][$i] == "application/x-bzip")
	|| ($_FILES["file"]["type"][$i] == "application/x-bz2")
	|| ($_FILES["file"]["type"][$i] == "application/octet")
	|| ($_FILES["file"]["type"][$i] == "application/octet-stream")
	|| ($_FILES["file"]["type"][$i] == "application/force-download")		
	|| ($_FILES["file"]["type"][$i] == "image/png")
	|| ($_FILES["file"]["type"][$i] == ""))
	&& ($_FILES["file"]["size"][$i] < $user_max_upload)
	&& in_array($extension, $allowedExts))
	{
		if ($_FILES["file"]["error"][$i] > 0)
		{
			echo $_FILES["file"]["name"][$i] . " - Return Code: " . $_FILES["file"]["error"][$i] . "<br>";
		}
		else
		{
			if(isset($_GET['p']))
			{
				$path = $_GET['p'];
				if(stristr($path, "../") == true)
				{
					echo "<meta http-equiv='refresh' content='0;url=ctrl.php?action=backtracking_error'>";
				}
				else if (file_exists("users/$username/$path/" . $_FILES["file"]["name"][$i]))
				{
					echo "Error:" . $_FILES["file"]["name"][$i] . " file exists.<br>";
				}
				else
				{
					$usage = file_get_contents("users/$username.usage");
					$usage = $usage + $_FILES["file"]["size"][$i];
					if($usage > $user_max_webspace) {							
						echo "Error: Exceeding max webspace usage.<br>";
					}							
					else
					{
						$filelist = file_get_contents("users/$username.files");
						file_put_contents("users/$username.usage", $usage);
						move_uploaded_file($_FILES["file"]["tmp_name"][$i],
						"users/$username/$path/" . $_FILES["file"]["name"][$i]);
						file_put_contents("users/$username.files", $_FILES["file"]["name"][$i] . "<br />\n" . $filelist);
						echo "Success: " . $_FILES["file"]["name"][$i] . " Uploaded! Size: " . tomb($_FILES["file"]["size"][$i]) . "<br>";
					}
				}
			}
			else
			{
				if (file_exists("users/$username/" . $_FILES["file"]["name"][$i]))
				{
					echo "Error: " . $_FILES["file"]["name"][$i] . " exists.<br>";
				}
				else
				{
					$usage = file_get_contents("users/$username.usage");
					$usage = $usage + $_FILES["file"]["size"][$i];
					if($usage > $user_max_webspace) {
						echo "Error: Exceeding max webspace usage.<br>";
					}
					else
					{
						file_put_contents("users/$username.usage", $usage);
						move_uploaded_file($_FILES["file"]["tmp_name"][$i],
						"users/$username/" . $_FILES["file"]["name"][$i]);
						echo "Success: " . $_FILES["file"]["name"][$i] . " Uploaded! Size: " . tomb($_FILES["file"]["size"][$i]) . "<br>";						
					}
				}
			}
		}
	}
	else
	{
		echo "Error: " . $_FILES["file"]["name"][$i] . " is too large, or is a invalid filetype";
	}
}
echo "</html>";
?>
