<?php

//*** Registry user
include("DBconnect.php");

session_start();

$email = $_REQUEST["email"];
$passwd = $_REQUEST["passwd"];

// get encrypted password
$query = "SELECT SHA('$passwd') PASS";
$dbc = new DBconnect();
$dbc->connect();
$dbc->execute_query($query);

$passwd = $dbc->fetch_array();

$query = "SELECT PASSWORD, NAME, ROLE FROM USERS WHERE EMAIL = '$email'";
$dbc->execute_query($query);
$result = $dbc->fetch_array();

if(isset($result) && $result[0]['PASSWORD'] == $passwd[0]['PASS']){
	$_SESSION['name'] = $result[0]['NAME'];
	$_SESSION['role'] = $result[0]['ROLE'];
	$_SESSION['email'] = $email;
	//redirect to dashboard page
	//header("Location: http://localhost/sbls/dashboard.php");
	print("true");
} else {
	//To do 
	print("false");
}

$dbc->disconnect();
?>