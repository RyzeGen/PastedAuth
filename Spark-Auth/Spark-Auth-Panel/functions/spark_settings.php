<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "Sparkauth";

$conn = mysqli_connect($host, $user, $pass, $db);
mysqli_query($conn, "SET NAMES UTF8") or die(mysqli_error($conn));
date_default_timezone_set('UTC');
error_reporting(E_ALL);

if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}