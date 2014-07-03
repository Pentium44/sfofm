<?php
session_start();

if(isset($_SESSION['hostz-user']) && isset($_SESSION['hostz-passwd'])) { header("Location: ctrl.php"); }
if(isset($_SESSION['hostz-vpspanel-user']) && isset($_SESSION['hostz-vpspanel-passwd'])) { header("Location: vps-panel.php"); }

//$header = file_get_contents("header.txt");
//echo $header;

//$page_title = "Drive";
//$indir = "true";
//include_once("../data/header.php");

include_once("config.php");

$header = file_get_contents("header.txt");
echo $header;

$title = $config_var[3];

echo "<div id='ptitle'>$title - Login</div>\n<link rel='stylesheet' href='style.css' type='text/css' />\n\n";

if(isset($_GET['action']))
{
	$action = $_GET['action'];
	if($action=="dowebhost")
	{
		if($_POST['hostzusername']!="" && $_POST['hostzpassword']!="")
		{
			$username = $_POST['hostzusername'];
			if(file_exists("users/$username.php"))
			{
				$password = $_POST['hostzpassword'];
				include("users/$username.php");
				if($user_password==$password)
				{
					$_SESSION['hostz-user'] = $_POST['hostzusername'];
					$_SESSION['hostz-passwd'] = $_POST['hostzpassword'];
					echo "Logged in, <a href=\"ctrl.php\">Redirecting to control panel in 3 seconds</a><meta http-equiv='refresh' content='3;url=ctrl.php'>";
				}
				else
				{
					echo "Error: Wrong password";
				}
			}
			else
			{
				echo "Error: User not found.";
			}
		}
		else
		{
			echo "Error: No username or password provided";
		}
	}
	
	/*if($action=="dovps")
	{
		if($_POST['vpsusername']!="" && $_POST['vpspassword']!="")
		{
			$username = $_POST['vpsusername'];
			if(file_exists("vpsusers/$username.php"))
			{
				$password = md5(sha1($_POST['vpspassword']));
				include("vpsusers/$username.php");
				if($user_password==$password)
				{
					$_SESSION['hostz-vpspanel-user'] = $_POST['vpsusername'];
					$_SESSION['hostz-vpspanel-passwd'] = $password;
					echo "Logged in, <a href=\"vps-panel.php\">Redirecting to VPS panel in 3 seconds</a><meta http-equiv='refresh' content='3;url=vps-panel.php'>";
				}
				else
				{
					echo "Error: Wrong password";
				}
			}
			else
			{
				echo "Error: User not found.";
			}
		}
		else
		{
			echo "Error: No username or password provided";
		}
	}*/
}
/*else if(isset($_GET['vps'])) {
	print <<<EOD
	<div class="form">
		<form method="post" action="login.php?action=dovps">
		<table>
		<tr>
			<td>Username:</td>
			<td><input type="text" name="vpsusername"></td>
		</tr>
		<tr>
			<td>Password:</td>
			<td><input type="password" name="vpspassword"></td>
		</tr>
		<tr>
			<td>Go!</td>
			<td><input type="submit" value="Login"></td>
		</tr>
		</table>
		</form>
	</div>
EOD;
}*/
else if(isset($_GET['webhost'])) {
	print <<<EOD
	<div class="form">
		<form method="post" action="login.php?action=dowebhost">
		<table>
		<tr>
			<td>Username:</td>
			<td><input type="text" name="hostzusername"></td>
		</tr>
		<tr>
			<td>Password:</td>
			<td><input type="password" name="hostzpassword"></td>
		</tr>
		<tr>
			<td>Go!</td>
			<td><input type="submit" value="Login"></td>
		</tr>
		</table>
		</form>
	</div>
EOD;
} else {
	print <<<EOD
	<div class="indexl">
		<a href="login.php?webhost">Webhost Login</a><!-- &bull;
		<a href="login.php?vps">VPS Login</a>-->
	</div>
EOD;

}

//include_once("../data/footer.php");

$footer = file_get_contents("footer.txt");
echo $footer;
?>
