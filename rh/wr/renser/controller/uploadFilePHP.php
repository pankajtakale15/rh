<?php

$guiConfigs = include('../common/guiCommon.php');

 require(  $guiConfigs->basePath.'service/RenewalSerService.php' );
 require(  $guiConfigs->basePath.'service/UserService.php' );

session_start();


 if (isset($_FILES) && isset($_POST['renewalServices']) && isset($_POST['daysDiff']))
 {
    $user = $_SESSION["user"];
 	$userObj = json_decode($user);
 	
 	$renSer = new RenewalSerService();
//  	$fileNames = "";
 	$renewalServices = $_POST['renewalServices'];
 	$daysDiff = $_POST['daysDiff'];
 	
 	$daysDiff = json_decode($daysDiff);
    $renewalServices = json_decode($renewalServices);
 	
 	$result = $renSer->insertServices($_FILES,$renewalServices,$daysDiff,$userObj);
 	
 	echo $result;

 }
 if (isset($_FILES) && isset($_POST['task']))
 {
 	$recordid = $_POST['reportId'];
 	$entity = $_POST['entity'];
 	$description = $_POST['description'];
 	$model = $_POST['model'];
 	$gst = $_POST['gst'];
 	$supplierName = $_POST['supplierName'];
 	$amount = $_POST['amount'];
 	$supplierEmail = $_POST['supplierEmail'];
 	$supplierContact = $_POST['supplierContact'];
 	$location = $_POST['location'];
 	$purchaseDate = $_POST['purchaseDate'];
 	$expiryDate = $_POST['expiryDate'];
 	$contractNo = $_POST['contractNo'];
 	$reminderBefore = $_POST['reminderBefore'];
 	$escalationMail = $_POST['escalationEmail'];
 	$escalationStart = $_POST['escalationStart'];
 	$fileName = $_POST['fileName'];
 	$fileAttached = $_POST['fileAttached'];
 	$daysDiff = $_POST['daysDiff'];
 	
 	$user = $_SESSION["user"];
 	$userObj = json_decode($user);
 	
 	$renSer = new RenewalSerService();	
 	$result = $renSer->updateRecord($_FILES,$recordid,$entity,$description,$model,$supplierName,$amount,$gst,
 												$supplierEmail,$supplierContact,$location,$purchaseDate,$expiryDate,
 												$contractNo,$reminderBefore,$escalationMail,$escalationStart,$fileAttached,$fileName,$daysDiff,$userObj);
 												
 	echo $result;
 }
 if(isset($_POST['isProfilePic'])){
 	$user = $_SESSION["user"];
 	
 	$userObj = json_decode($user);
 	$userVersion = $_POST['userVersion'];

 	$userSer = new UserService($guiConfigs);
 	$userSer->updateUserProfile($_FILES, $userObj,$userVersion);
 }


?>