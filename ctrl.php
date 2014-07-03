<?php
session_start();

include_once("config.php");

if(!isset($_SESSION['hostz-user']) or !isset($_SESSION['hostz-passwd'])) { header("Location: index.php"); }
$user_max_webspace = $config_var[1];
$user_max_upload = $config_var[2];

$link = $config_var[3];

$username = $_SESSION['hostz-user'];
$password = $_SESSION['hostz-passwd'];

//$page_title = "Drive";
//$indir = "true";
//include_once("../data/header.php");

$header = file_get_contents("header.txt");
echo $header;

include("users/$username.php");
if($password!=$user_password)
{
	$_SESSION['hostz-user'] = null;
	$_SESSION['hostz-passwd'] = null;
	header("Location: index.php");
}

// Check to see if someone is backtracking in pathfinder
if(isset($_GET['p']))
{
	$path = $_GET['p'];
	if(stristr($path, "..") == true)
	{
		header("Location: ctrl.php?action=backtracking_error");
	}
}
// Check if usage is below 0, then set to 0
$user_usage = file_get_contents("users/$username.usage");
if($user_usage<0)
{
	file_put_contents("users/$username.usage", "0");
}

if(isset($_GET['f']))
{
	$file = $_GET['f'];
	if(isset($_GET['p']))
	{
		$path = $_GET['p'];
		header("Location: users/$username/$path/$file");
	}
	else
	{
		header("Location: users/$username/$file");
	}
}

//
// Format Bytes to KBytes, MBytes, GBytes //
//
function tomb($size, $precision = 2)
{
    $base = log($size) / log(1024);
    $suffixes = array('', 'KB', 'MB', 'GB', 'TB');   

    return round(pow(1024, $base - floor($base)), $precision) . $suffixes[floor($base)];
}


//
//
// MAIN LOOP //
//
//

if(isset($_GET['action']))
{
	$action = $_GET['action'];
	if($action=="backtracking_error")
	{
		$ip = $_SERVER['REMOTE_ADDR'];
		if(file_exists("data/log.txt"))
		{
			$oldcontent = file_get_contents("data/log.txt");
		}
		else
		{
			$oldcotent = "";
		}
		file_put_contents("data/log.txt", $oldcontent . "Backtracking: $ip\n");
		
		echo "<div id='ptitle'>Control Panel - $username</div>\n";
		
		print <<<EOD
		
		<h2>Error!</h2>
		This system has found backtracking slashes in the URL. Your IP has been reported to the system administrator. Account suspension could be nessesary.
EOD;
	}
	
	if($action=="upload") {
		print <<<CSS
			<style>
			.progress { position:relative; width:400px; border: 1px solid #ddd; padding: 1px; border-radius: 3px; margin: auto; }
			.bar { background-color: #008000; width:0%; height:20px; border-radius: 3px; }
			.percent { position:absolute; display:inline-block; top:1px; left:48%; vertical-align: center; }
			#status { text-align: center; padding: 4px; }
			</style>	
CSS;
		
		if(isset($_GET['p']))
		{
			$path = $_GET['p'];
			if(stristr($path, "..") == true)
			{
				header("Location: ctrl.php?action=backtracking_error");
			}
			else
			{
				print <<<EOD
				<div id='ptitle'>Upload - $username</div>
				<div class="progress">
					<div class="bar"></div >
					<div class="percent">0%</div >
				</div>
				<div id="status"></div>
				<table style="margin:auto;">
				
				<form action="upload.php?p=$path" method="post" enctype="multipart/form-data">
				<tr>
					<td>
					<input type="file" name="file[]" id="file" multiple><br>
					</td>
					<td>
					<input type="submit" name="submit" value="Upload">
					</td>
				</tr>
				</form>
				
				</table>
			
			<script src="data/jquery.1.7.js"></script>
			<script src="data/jquery.form.js"></script>
			<script>
			(function() {
    
			var bar = $('.bar');
			var percent = $('.percent');
			var status = $('#status');
   
			$('form').ajaxForm({
			
			beforeSend: function() {
			status.empty();
    			    var percentVal = '0%';
    			    bar.width(percentVal)
    			    percent.html(percentVal);
   			},
			
			uploadProgress: function(event, position, total, percentComplete) {
			        var percentVal = percentComplete + '%';
			        bar.width(percentVal)
			        percent.html(percentVal);
			},
    		
    		success: function() {
    			    var percentVal = '100%';
    			    bar.width(percentVal)
    			    percent.html(percentVal);
    		},
	
			complete: function(xhr) {
					status.html(xhr.responseText);
			}
			
			}); 

			})();       
			</script>
EOD;
			}
		}
		else
		{
			print <<<EOD
			
			<div id='ptitle'>Upload - $username</div>
			<div style='text-align:center;'><a href="ctrl.php">Back to /</a></div>
			<div class="progress">
				<div class="bar"></div >
				<div class="percent">0%</div >
			</div>
			<div id="status"></div>
			<table style="margin:auto;">
				
				<form action="upload.php" method="post" enctype="multipart/form-data">
				<tr>
					<td>
					<input type="file" name="file[]" id="file" multiple><br>
					</td>
					<td>
					<input type="submit" name="submit" value="Upload">
					</td>
				</tr>
				</form>
				
				</table>
			
			<script src="data/jquery.1.7.js"></script>
			<script src="data/jquery.form.js"></script>
			<script>
			(function() {
    
			var bar = $('.bar');
			var percent = $('.percent');
			var status = $('#status');
   
			$('form').ajaxForm({
			
			beforeSend: function() {
			status.empty();
    			    var percentVal = '0%';
    			    bar.width(percentVal)
    			    percent.html(percentVal);
   			},
			
			uploadProgress: function(event, position, total, percentComplete) {
			        var percentVal = percentComplete + '%';
			        bar.width(percentVal)
			        percent.html(percentVal);
			},
    		
    		success: function() {
    			    var percentVal = '100%';
    			    bar.width(percentVal)
    			    percent.html(percentVal);
    		},
	
			complete: function(xhr) {
					status.html(xhr.responseText);
			}
			
			}); 

			})();       
			</script>
			
EOD;
			
			
		}
	}
	
	// Create a new directory
	if($action=="newdir")
	{
		if(isset($_GET['p']))
		{
			$path = $_GET['p'];
			if(stristr($path, "..") == true)
			{
				header("Location: ctrl.php?action=backtracking_error");
			}
			else
			{
				print <<<EOD
				<div id='ptitle'>New Directory - $username</div>
				<div class="form">
					<form action="ctrl.php?action=donewdir&p=$path" method="post">
					<label for="file">Directory Name:</label>
					<input type="text" name="dirname" id="dirname"><br>
					<input type="submit" name="submit" value="Create">
					</form>
				</div>
EOD;
			}
		}
		else
		{
			print <<<EOD
			<div id='ptitle'>New Directory - $username</div>
			<div class="form">
				<form action="ctrl.php?action=donewdir" method="post">
				<label for="file">Directory Name:</label>
				<input type="text" name="dirname" id="dirname"><br>
				<input type="submit" name="submit" value="Create">
				</form>
			</div>
EOD;
		}
	}
	if($action=="donewdir")
	{
		if($_POST['dirname']!="")
		{
			if(isset($_GET['p']))
			{
				$path = $_GET['p'];
				if(stristr($path, "..") == true)
				{
					header("Location: ctrl.php?action=backtracking_error");
				}
				else
				{
					$dirname = $_POST['dirname'];
					$badchars = array("*", "'", "\"", "(", ")", "[", "]", "#", "$", "@", "!", "%", "^", "|", "+", "&", "=");
					$dirname = stripslashes(htmlentities(str_replace($badchars, '', $dirname)));
					if(file_exists("users/$username/$path/$dirname"))
					{
						echo "Error: Directory exists.";
					}
					else
					{
						mkdir("users/$username/$path/$dirname", 0777);
						file_put_contents("users/$username/$path/$dirname/index.html", "<html><meta http-equiv='refresh' content='o;url=/'></html>");
						header("Location: ctrl.php");
					}
				}
			}
			else
			{
				$dirname = $_POST['dirname'];
				$badchars = array("*", "'", "\"", "(", ")", "[", "]", "#", "$", "@", "!", "%", "^", "|", "+", "&", "=");
				$dirname = stripslashes(htmlentities(str_replace($badchars, '', $dirname)));
				if(file_exists("users/$username/$dirname"))
				{
					echo "Error: Directory exists.";
				}
				else
				{
					mkdir("users/$username/$dirname", 0777);
					file_put_contents("users/$username/$dirname/index.html", "<html><meta http-equiv='refresh' content='o;url=/'></html>");
					header("Location: ctrl.php");
				}
			}
		}
		else
		{
			echo "Error: No directory name specified.";
		}
	}
	
	// Remove file methods
	if($action=="remove") {
		if(isset($_GET['p']))
		{
			$path = $_GET['p'];
			if(stristr($path, "..") == true)
			{
				header("Location: ctrl.php?action=backtracking_error");
			}
			else
			{
				if(is_dir("users/$username/$path")) {
				if(isset($_GET['rf']))
				{
					$file = $_GET['rf'];
					if(stristr($file, "..") == true)
					{
						header("Location: ctrl.php?action=backtracking_error");
					}
					else
					{
						$filesize = filesize("users/$username/$path/$file");
						$usage = file_get_contents("users/$username.usage");
						$usage = $usage - $filesize;
						if(file_exists("users/$username/$path/$file"))
						{
							file_put_contents("users/$username.usage", $usage);
							unlink("users/$username/$path/$file");
							header("Location: ctrl.php");
						}	
						else
						{
							echo "Error: File does not exist";
						}
					}
				} else {
					echo "Error: No file specified\n";
				}// Close rf check //
				
				}// Close is_dir check //
				header("Location: ctrl.php");
			}
			header("Location: ctrl.php");
		}
		else
		{
			if(isset($_GET['rf']))
			{
				$file = $_GET['rf'];
				if(stristr($file, "..") == true)
				{
					header("Location: ctrl.php?action=backtracking_error");
				}
				else
				{
					$filesize = filesize("users/$username/$file");
					$usage = file_get_contents("users/$username.usage");
					$usage = $usage - $filesize;
					if(file_exists("users/$username/$file"))
					{
						file_put_contents("users/$username.usage", $usage); // Remove file usage
																	// Form database
						unlink("users/$username/$file"); // remove file //
					} // Close if, on to else //
					else
					{
						echo "Error: File does not exist"; // Report no file //
					}
					header("Location: ctrl.php"); // Redirect //
				} // END of else bracket //
			} // Close rf check //
		} // END of else bracket //
	}
	
	if($action=="removedir") {
		if(isset($_GET['d']))
		{
			$dir = $_GET['d'];
			if(stristr($dir, "..") == true)
			{
				header("Location: ctrl.php?action=backtracking_error");
			}
			else
			{
				if(is_dir("users/$username/$dir"))
				{
					$dircontent = opendir("users/$username/$dir");
					while(false!==($getfile = readdir($dircontent)))
					{
						if($getfile!=".." && $getfile!=".")
						{
							$filesize = filesize("users/$username/$dir/$getfile");
							$usage = file_get_contents("users/$username.usage");
							$usage = $usage - $filesize;
							file_put_contents("users/$username.usage", $usage);
							unlink("users/$username/$dir/$getfile");
						}
					}
					rmdir("users/$username/$dir"); 
					header("Location: ctrl.php"); // Redirect to main //
				} else {
					echo "Error: specified path is not a real directory\n";
				}// END of is_dir check //
			} // END of else //
		}
		else
		{
			echo "Error: No directory specified.";
		}
	}
}
else
{
	echo "<div id='ptitle'>Control Panel - $username</div>\n\n";
	echo "<div id='ctrlnav'>\n";
	if(isset($_GET['p']))
	{
		$path = $_GET['p'];
		echo "<a href='ctrl.php?action=upload&p=$path'>Upload</a> &bull; \n";
		echo "<a href='ctrl.php?action=newdir&p=$path'>Create Directory</a> &bull; \n";
	}
	else
	{
		echo "<a href='ctrl.php?action=upload'>Upload</a> &bull; \n";
		echo "<a href='ctrl.php?action=newdir'>Create Directory</a> &bull; \n";
	}

	echo "<a href='url.php'>Your Website</a> &bull; \n";
	echo "<a href='logout.php'>Logout</a><br> \n";
	$size = file_get_contents("users/$username.usage");
	$size = tomb($size);
	$user_max_webspace = tomb($user_max_webspace);
	echo "Usage: $size / $user_max_webspace";
	echo "</div><div id='filelist'>\n";
	echo "<u>Your virtual disk files:</u><br>";

	if(isset($_GET['p']))
	{
		if(is_dir("users/$username/" . $_GET['p']))
		{
			$path = $_GET['p'];
			$userdb = opendir("users/$username/$path");
		}
		else
		{
			$undefined_var = "";
		}
	}
	else
	{
		$userdb = opendir("users/$username");
	}
	if(isset($userdb))
	{
		if(isset($path)) { echo "<img src='data/img/folder.png' style='padding-right: 4px;' alt='Folder' /><a href='ctrl.php'>Home Directory</a><br />\n"; }
		
		while(false !== ($file = readdir($userdb)))
		{
			if(isset($path))
			{
				if(is_dir("users/$username/$path/$file") && $file!=".." && $file!=".")
				{
					echo "<img src='data/img/folder.png' style='padding-right: 4px;' alt='Folder' /><a href='ctrl.php?p=$path/$file'>$file</a><a style='padding-left: 35px; float:right;' href='ctrl.php?action=removedir&d=$path/$file'>Delete Directory</a><br />\n";
				}
				else if($file!=".." && $file!="." && $file!="index.html")
				{
					echo "<img src='data/img/file.png' style='padding-right: 4px;' alt='File' /><a href='ctrl.php?f=$path/$file'>$file</a><a style='padding-left: 35px; float:right;' href='ctrl.php?action=remove&rf=$path/$file'>Delete File</a><br />\n";
				}
			}
			else
			{
				if(is_dir("users/$username/$file") && $file!=".." && $file!=".")
				{
					echo "<img src='data/img/folder.png' style='padding-right: 4px;' alt='Folder' /><a href='ctrl.php?p=$file'>$file</a><a style='padding-left: 35px; float:right;' href='ctrl.php?action=removedir&d=$file'>Delete Directory</a><br />\n";
				}
				else if($file!=".." && $file!="." && $file!="index.html")
				{
					echo "<img src='data/img/file.png' style='padding-right: 4px;' alt='File' /><a href='ctrl.php?f=$file'>$file</a><a style='padding-left: 35px; float:right;' href='ctrl.php?action=remove&rf=$file'>Delete File</a><br />\n";
				}
			}
		}
	}
	else
	{
		echo "Error: Directory not found";
	}
	echo "\n</div>\n";
}

$footer = file_get_contents("footer.txt");
echo $footer;
?>
