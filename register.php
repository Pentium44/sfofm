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

echo "<div id='ptitle'>$title - Register</div>\n<link rel='stylesheet' href='style.css' type='text/css' />\n\n";

if(isset($_GET['error']))
{
	$error = $_GET['error'];
	if($error=="1") { echo "Error: No username provided."; }
	if($error=="2") { echo "Error: No password provided."; }
	if($error=="3") { echo "Error: Passwords provided did not mach."; }
	if($error=="4") { echo "Error: Username in use."; }
	//if($error=="5") { echo "Error: Invalid validation code"; }
	if($error=="6") { echo "Error: No email provided."; }
	if($error=="7") { echo "Error: Not a valid email address."; }
	if($error=="8") { echo "Error: Register form not completely filled out."; }
	if($error=="9") { echo "Error: VPS package not available at this time."; }
	if($error=="10") { echo "Error: The provided email has already been registered with EEZE Host."; }
}
/*else if(isset($_GET['vps'])) {
	print <<<EOD
	<div class="form">
		<form method="post" action="create.php?vps">
		<table>
		<tr>
			<td>Email:</td>
			<td><input type="text" name="email"></td>
		</tr>
		<tr>
			<td>Username:</td>
			<td><input type="text" name="username"></td>
		</tr>
		<tr>
			<td>Password:</td>
			<td><input type="password" name="password"></td>
		</tr>
		<tr>
			<td>Confirm Password:</td>
			<td><input type="password" name="passwordagain"></td>
		</tr>
		<tr>
			<td>VPS Package:</td>
			<td>
				<select name="package">
				<option value="1">VPS Package 1</option>
				</select>
			</td>
		</tr>
		<tr>
			<td>Terms Of Service:</td>
			<td>By signing up for this service, you are <br>agreeing to the <a href='terms.php'>Terms Of Service</a></td>
		</tr>
		<tr>
			<td>Go!</td>
			<td><input type="submit" value="Get Your VPS"></td>
		</tr>
		</table>
		</form>
	</div>
EOD;
}*/ 
else if(isset($_GET['webhost'])) {
	print <<<EOD
	<div class="form">
		<form method="post" action="create.php">
		<table>
		<tr>
			<td>Username:</td>
			<td><input type="text" name="filezusername"></td>
		</tr>
		<tr>
			<td>Password:</td>
			<td><input type="password" name="filezpassword"></td>
		</tr>
		<tr>
			<td>Confirm Password:</td>
			<td><input type="password" name="filezpasswordagain"></td>
		</tr>
		<tr>
			<td>Terms Of Service:</td>
			<td>By signing up for this service, you are <br>agreeing to the <a href='terms.php'>Terms Of Service</a></td>
		</tr>
		<tr>
			<td>Go!</td>
			<td><input type="submit" value="Get Your Webspace"></td>
		</tr>
		</table>
		</form>
	</div>
EOD;
} else {
	print <<<EOD
	<div class="indexl">
		<a href="register.php?webhost">Webhost Signup</a> <!--&bull;
		<a href="register.php?vps">VPS Signup</a>-->
	</div>
EOD;

}

//include_once("../data/footer.php");

$footer = file_get_contents("footer.txt");
echo $footer;
?>
