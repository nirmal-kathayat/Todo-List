<?php

$host = "localhost";
$dbname = "login_db";
$username = "root";
$password = "";
//connection with mysql
$db = new mysqli($host, $username, $password, $dbname);

//checking the connection
if ($db->connect_error) {
      die("Connection failed: " . $db->connect_error);
}