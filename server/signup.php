<?php

//*** Registry user
include("DBconnect.php");

session_start();

$uname = $_REQUEST["username"];
$email = $_REQUEST["signupemail"];
$passwd = $_REQUEST["initialpasswd"];
$role = $_REQUEST["role"];

$dbc = new DBconnect();
$dbc->connect();
//insert the new user into the table users
$query = "INSERT INTO USERS VALUES ('$email', SHA('$passwd'), '$uname', NULL, '$role')";
$dbc->execute_query($query);

// sucessfully sign up. record the session information
$_SESSION['name'] = $uname;
$_SESSION['email'] = $email;
$_SESSION['role'] = $role;


//redirect to dashboard page
header("Location: http://localhost/sbls/");
$dbc->disconnect();
?>
