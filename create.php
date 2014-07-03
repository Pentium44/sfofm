<?php
include_once "config.php";
$validation_key = $config_var[0];

if($_POST['filezusername']!="" && $_POST['filezpassword']!="" && $_POST['filezpasswordagain']!="")
{
	$username = stripcslashes(htmlentities(str_replace($badchars, '', $_POST['filezusername'])));
	$password = $_POST['filezpassword'];
	$password_again = $_POST['filezpasswordagain'];
	//$validation_input = $_POST['filezvalidation'];
	if($password == $password_again)
	{
		if($password!="")
		{
			if($username!="")
			{
				if(!file_exists("users/$username.php"))
				{
					//if($validation_key==$validation_input)
					//{
						mkdir("users/$username", 0777);
						file_put_contents("users/$username/index.html", "<html><meta http-equiv='refresh' content='0;url=/'></html>");
						file_put_contents("users/$username.php", "<?php\n \$user_password = \"$password\";\n ?>\n");
						file_put_contents("users/$username.usage", "0");
						exec("ln -s /opt/eeze/users/$username /opt/eezeusers/$username"); // create symlink to web server
						header("Location: login.php");
					//}	
					//else
					//{
					//	header("Location: register.php?error=5");
					//}
				}
				else
				{
					header("Location: register.php?error=4");
				}
				
			}
			else
			{
				header("Location: register.php?error=1");
			}
		}
		else
		{
			header("Location: register.php?error=2");
		}
	}
	else
	{
		header("Location: register.php?error=3");
	}
}
else 
{
	header("Location: register.php?error=8");
}

?>
