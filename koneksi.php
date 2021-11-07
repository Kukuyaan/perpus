<?php 
 
$hostname = "localhost";
$username = "root";
$password = "";
$database = "pepe";
 
$koneksi = mysqli_connect($hostname, $username, $password, $database) or die("Database connetion failed");
?>