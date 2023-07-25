<?php
// Assuming the form data is submitted via POST method
// print_r($_POST);

$host = "localhost";
$dbname = "login_db";
$username = "root";
$password = "";
//connection with sql
$db = new mysqli($host, $username, $password, $dbname);

//check the connection
if ($db->connect_error) {
          die("Connection failed: " . $db->connect_error);
}
