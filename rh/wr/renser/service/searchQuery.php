<?php
include_once ('../common/user.php');
include_once( '../contact/ContactService.php' );
include_once ('../common/Encryption.php');
include_once ('../common/DB.php');

$dbutil = new DBUtil ();
$conn = $dbutil->getPDOConnection ();

$search = "%er%";
$selectStmt = $conn->prepare("select * from renewalservice where category like :search");
$selectStmt->bindParam(":search", $search, PDO::PARAM_STR);
$selectStmt->execute();

while ($row = $selectStmt->fetch()){
	echo $row['category'];
}

?>