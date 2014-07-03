<?php
session_start();

if(isset($_SESSION['hostz-user']) && isset($_SESSION['hostz-passwd']))
{
	$_SESSION['hostz-user'] = null;
	$_SESSION['hostz-passwd'] = null;
}

if(isset($_SESSION['hostz-vpspanel-user']) && isset($_SESSION['hostz-vpspanel-passwd']))
{
	$_SESSION['hostz-vpspanel-user'] = null;
	$_SESSION['hostz-vpspanel-passwd'] = null;	
}

header("Location: index.php");


?>