<?php

	$serverName = "localhost";
	$userName	= "root";
	$userPassword = "Wuttinunt__1994";
	$dbName		= "facebook";
	$con = mysqli_connect($serverName,$userName,$userPassword,$dbName);
	mysqli_set_charset($con,"utf8");
	if(mysqli_connect_errno())
	{
		echo "DataBase connect Failed: " .mysqli_connect_error();
		exit();
	}
	//***** Auto logout when user AFK
	//$intRejectTime = 20;
	//$sql = "UPDATE member SET LoginStatus = '0', LasteUpdate = '0000-00-00 00:00:00' WHERE 1 AND date_add(LasteUpdate,interval $intRejectTime MINUTE) <= NOW() ";
	//$query = mysqli_query($con,$sql);
?>
