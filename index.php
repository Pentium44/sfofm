<?php
session_start();
include_once "config.php";

function tomb($size, $precision = 2)
{
    $base = log($size) / log(1024);
    $suffixes = array('', 'KB', 'MB', 'GB', 'TB');   

    return round(pow(1024, $base - floor($base)), $precision) . $suffixes[floor($base)];
}

$title = $config_var[3];
$desc = $config_var[4];
$webspace = tomb($config_var[1]);
$max_upload = tomb($config_var[2]);

$header = file_get_contents("header.txt");
echo $header;

print <<<EOD
	<div id='ptitle'>$title</div>
	<div style="text-align:center;">
		$desc
	</div>
		<table style="margin:auto;">
			<tr>
				<td>
					<div id="packages">
					<b>Web Package 1</b><br>
						Web Space: $webspace<br>
						Max Upload: $max_upload<br>
						Upload Methods: Online Upload<br>
					</div>
				</td>
			</tr>
		</table>
EOD;


$footer = file_get_contents("footer.txt");
echo $footer;
?>
