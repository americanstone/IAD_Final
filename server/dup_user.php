<?php

//*** check if a given user is signed up 
include("DBconnect.php");

session_start();

$email = $_REQUEST["email"];

$dbc = new DBconnect();
$dbc->connect();

$query = "SELECT COUNT(*) NUM FROM USERS WHERE EMAIL = '$email'";
$dbc->execute_query($query);
$result = $dbc->fetch_array();

if($result[0]['NUM'] > 0)
	print("true");
else
	print("false");
	
$dbc->disconnect();

?>