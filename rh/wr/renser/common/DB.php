<?php

class DBUtil{

// 	function getConnection(){

// 		$host=$dbConfigs["host"];
// 		$user=$dbConfigs["username"];
// 		$pass=$dbConfigs["pass"];
// 		$db=$dbConfigs["database"];

// 		$con = mysqli_connect($host, $user, $pass,$db) or die(mysqli_error() . 'Oops! there is a problem connecting to database');
// 		mysqli_select_db($con,$db) or die('Error selecting database '. mysqli_error());

// 		return $con;
// 	}

	function getPDOConnection(){
		$dbConfigs = include('dbConf.php');
		
		$host=$dbConfigs->host;
		$user=$dbConfigs->username;
		$pass=$dbConfigs->pass;
		$db=$dbConfigs->database;
		

	 $conn = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
	 // set the PDO error mode to exception
	 $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	 return $conn;
	}
}
