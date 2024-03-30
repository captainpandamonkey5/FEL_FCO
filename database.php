<?php

$host = "localhost";
$dbusername = "root";
$dbpassword = "";
$database = "ajcbikeshope_db";

$conn = mysqli_connect($host, $dbusername, $dbpassword, $database);

if (!$conn) {
    die("Something went wrong!");
}
?>