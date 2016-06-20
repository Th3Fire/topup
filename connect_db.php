<?php

	$serverName = "localhost";
	$userName	= "root";
	$userPassword = "";
	$dbName		= "facebook";
	$con = mysqli_connect($serverName,$userName,$userPassword,$dbName);
	mysqli_set_charset($con,"utf8");
	if(mysqli_connect_errno())
	{
		echo "DataBase connect Failed: " .mysqli_connect_error();
		exit();
	}
	
?>
