<?php

//$header = file_get_contents("header.txt");
//echo $header;

//$page_title = "Drive";
//$indir = "true";
//include_once("../data/header.php");

include_once("config.php");

$title = $config_var[3];

$header = file_get_contents("header.txt");
echo $header;

	print <<<EOD
	<div id='ptitle'>$title - Terms of Service</div>
		<table>
		<tr>
			<td>
				1: Copyrighted content is strictly forbidden!
			</td>
		</tr>
		<tr>
			<td>
				2: Patching ".." into the control panel url is forbidden, and your external IP address will be logged.
			</td>
		</tr>
		<tr>
			<td>
				3: Registering for multiple VPS packages is strictly forbidden!
			</td>
		</tr>
		<tr>
			<td>
				4: Explicit content is forbidden.
			</td>
		</tr>
		<tr>
			<td>
				5: Information that is not directly linked to you and is reported to us is forbidden. Be respectful to others.
			</td>
		</tr>
		<tr>
			<td>
				6: Crawlers are forbidden.
			</td>
		</tr>
		<tr>
			<td>
				7: P2P is strictly forbidden.
			</td>
		</tr>
		<tr>
			<td>
				If these rules are not followed, your account will be removed without warning.
			</td>
		</tr>
		</table>
EOD;

//include_once("../data/footer.php");

$footer = file_get_contents("footer.txt");
echo $footer;
?>
