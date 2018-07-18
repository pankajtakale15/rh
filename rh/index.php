<?php 
include_once( 'wr/renser/common/DB.php' );

$dbutil = new DBUtil ();
$conn = $dbutil->getPDOConnection ();

//creating renewalservice table
try{
	$createStmt = $conn->prepare ( "CREATE TABLE renewalservice (
										id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
										category VARCHAR(50) NOT NULL,
										subcategory VARCHAR(50) NOT NULL,
										entity VARCHAR(100),
										description VARCHAR(250) NOT NULL,
										model VARCHAR(20),
										supplier_name VARCHAR(50),
										amount VARCHAR(20),
										gst VARCHAR(20),
										supplier_email VARCHAR(50),
										supplier_contact VARCHAR(50),
										location VARCHAR(50),
										purchase_date DATETIME NOT NULL,
										expiry_date DATETIME NOT NULL,
										contract_no VARCHAR(100),
										comment VARCHAR(250),
										reminder_before INT(11) NOT NULL,
										filepath VARCHAR(250),
										isdeleted TINYINT(4),
										version INT(11),
										user VARCHAR(50) NOT NULL,
										submited_on VARCHAR(50) NOT NULL,
										mail_to_supplier INT(2),
										username VARCHAR(50) NOT NULL,
										mail_sent_to_senior VARCHAR(10) NOT NULL,
										current_status VARCHAR(20) NOT NULL,
										is_escalation INT(10) NOT NULL,
										escalation_mail VARCHAR(50),
										escalation_start INT(3)
									) ");
	$createStmt->execute();
}catch (PDOException $e){
	echo $e->getMessage ();
}

//creating users table
try{
	$createStmt = $conn->prepare ( "CREATE TABLE user (
										id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
										user_no VARCHAR(20) NOT NULL,
										user_type VARCHAR(20) NOT NULL,
										gst_no VARCHAR(20),
										first_name VARCHAR(100) NOT NULL,
										last_name VARCHAR(100) NOT NULL,
										company_name VARCHAR(100),
										login_id VARCHAR(50) NOT NULL,
										registered_on VARCHAR(50) NOT NULL,
										updated_on VARCHAR(50) NOT NULL,
										address VARCHAR(200),
										country VARCHAR(20),
										state VARCHAR(20),
										city VARCHAR(20),
										pin VARCHAR(10),
										email VARCHAR(50) NOT NULL,
										mobile VARCHAR(15),
										landline VARCHAR(15),
										isdeleted TINYINT(1),
										version SMALLINT(6) NOT NULL,
										isactive TINYINT(1) NOT NULL,
										vfc VARCHAR(20) NOT NULL,
										img_dir VARCHAR(20) NOT NULL,
										password VARCHAR(300) NOT NULL,
										status VARCHAR(20) NOT NULL,
										profile_img VARCHAR(200) NOT NULL,
										login_id_encoded VARCHAR(300) NOT NULL,
										confirmed_user VARCHAR(10) NOT NULL,
										is_admin VARCHAR(10) NOT NULL,
										view_permission VARCHAR(10) NOT NULL,
										insert_permission VARCHAR(10) NOT NULL,
										update_permission VARCHAR(10) NOT NULL,
										delete_permission VARCHAR(10) NOT NULL,			
										mail_permission VARCHAR(10) NOT NULL,
										designation VARCHAR(50) NOT NULL,
										username VARCHAR(50) NOT NULL,
										senior_email1 VARCHAR(50),
										senior_email2 VARCHAR(50)
									) ");
	$createStmt->execute();
}catch (PDOException $e){
	echo $e->getMessage ();
}

//creating user_logs table
try{
	$createStmt = $conn->prepare ( "CREATE TABLE user_logs (
										id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
										log_date VARCHAR(200) NOT NULL,
										log_activity VARCHAR(30) NOT NULL,
										log_activity_id INT(10) NOT NULL,
										log_description VARCHAR(1000) NOT NULL,
										log_user VARCHAR(100) NOT NULL
									) ");
	$createStmt->execute();
}catch (PDOException $e){
	echo $e->getMessage ();
}

//creating template table
try{
	$createStmt = $conn->prepare ( "CREATE TABLE template (
										id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
										template_type VARCHAR(20) NOT NULL,
										template_subject VARCHAR(200) NOT NULL,
										template_message VARCHAR(1000) NOT NULL
									) ");
	$createStmt->execute();
}catch (PDOException $e){
	echo $e->getMessage ();
}

//creating linkedUsers table
try{
	$createStmt = $conn->prepare ( "CREATE TABLE linkedusers (
										id BIGINT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
										username_1 varchar(50) NOT NULL,
										username_2 varchar(50) NOT NULL
									) ");
	$createStmt->execute();
}catch (PDOException $e){
	echo $e->getMessage ();
}

//creating software validator table
try{
	$createStmt = $conn->prepare ( "CREATE TABLE validator (
										startdate VARCHAR(50) NOT NULL
										) ");
	$createStmt->execute();
	$createStmt = null;
	
	$tDate = date("d-m-Y");
	$createStmt = $conn->prepare ("INSERT INTO validator(startdate) VALUES(:tDate)");
	$createStmt->bindParam(":tDate", $tDate);
	$createStmt->execute ();
	
}catch (PDOException $e){
	echo $e->getMessage ();
}

//creating email accounts table
try{
	$createStmt = $conn->prepare ( "CREATE TABLE emailaccounts (
										id BIGINT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
										firstName VARCHAR(20) NOT NULL,
										lastName VARCHAR(20) NOT NULL,
										designation VARCHAR(20),
										email_id VARCHAR(50)
										) ");
	$createStmt->execute();
	
}catch (PDOException $e){
	echo $e->getMessage ();
}


//creating trash table
try{
	$createStmt = $conn->prepare ( "CREATE TABLE trashtable (
                    					action_user VARCHAR(50) NOT NULL,
                    					action_date VARCHAR(50) NOT NULL,
                    					action_type VARCHAR(50) NOT NULL,
                    					id BIGINT NOT NULL,
                    					category VARCHAR(50) NOT NULL,
                    					subcategory VARCHAR(50) NOT NULL,
                    					description VARCHAR(1000) NOT NULL,
                    					model VARCHAR(50),
                    					supplier_name VARCHAR(50),
                    					supplier_email VARCHAR(50),
                    					supplier_contact VARCHAR(50),
                    					amount VARCHAR(50),
                    					gst VARCHAR(50),
                    					location VARCHAR(50),
                    					purchased_date VARCHAR(50),
                    					expiry_date VARCHAR(50) NOT NULL,
                    					contract_no VARCHAR(50),
                    					user_name VARCHAR(50)
                    				)");
	$createStmt->execute();
}catch (PDOException $e){
	echo $e->getMessage ();
}

//confirming users availability
try{
	$selectStmt = $conn->prepare ( "SELECT COUNT(*) FROM user");
	$selectStmt->execute();
	
	$noOfUsers = $selectStmt->fetchColumn();
	
	if ($noOfUsers > 0){
		echo "<br><br>Users are available!";
		header("Location: login.php");
	}else{
		echo "<br><br>Users are not available!";
		header("Location: register.php");
	}
	
}catch (PDOException $e){
	echo $e->getMessage ();
}

?>