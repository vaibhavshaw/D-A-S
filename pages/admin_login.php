<?php

include "db_connect.php";
session_start();
//fetchdata
$username=$_POST['username'];
$password=$_POST['password'];


if(hash('ripemd160', $username) == "7dd12f3a9afa0282a575b8ef99dea2a0c1becb51" && hash('sha256', $password) == "5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8")
{
	$_SESSION['name']="admin";
	header('location: viewdatabase.php');
}
else
{
	header('location: adminlogin.html');
}
?>

