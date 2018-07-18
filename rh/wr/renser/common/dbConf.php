<?php

$servername = "localhost";
$username = "root";
$password = "";

// Create connection
$conn = new mysqli($servername, $username, $password);
// Check connection
if ($conn->connect_error) {
   die("Connection failed: " . $conn->connect_error);
} 

$sql = "CREATE DATABASE renser";
if ($conn->query($sql) === TRUE) {
} else {
}
	
 return (object) array(
 		'host' => 'localhost',
 		'username' => 'root',
		'pass' => '',
 		'database' => 'renser'
 );
 ?>
