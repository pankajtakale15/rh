<?php
include_once( '../service/UserService.php' );
include_once( '../service/RenewalSerService.php' );
include_once( '../contact/ContactService.php' );
include_once( '../contact/ContactUtil.php' );
include_once( '../common/DB.php' );

$data = file_get_contents("php://input");
$data = json_decode($data, TRUE);

$dbConfigs = include('../common/guiCommon.php');
$userService = new UserService($dbConfigs);

if( isset($data['task']) && 'firstRegistration' == $data['task'] )
{
	$firstName = $data['firstName'];
	$lastName = $data['lastName'];
	$designation = $data['designation'];
	$emailId = $data['emailId'];
	$userName = $data['userName'];
	$userPassword = $data['password'];

	$msg = $userService->firstRegistration($firstName, $lastName, $designation, $emailId, $userName, $userPassword);
	
	echo $msg;
	
}else if( isset($data['task']) && 'login' == $data['task'] )
{
	$userName = $data['userName'];
	$userPassword = $data['password'];

	$msg = $userService->loginByUserName($userName,$userPassword);
	
	echo $msg;
	
}
else if( isset($data['task']) && 'addNewUser' == $data['task'] )
{
	$firstName = $data['firstName'];
	$lastName = $data['lastName'];
	$userName = $data['userName'];
	$designation = $data['designation'];
	$userType = $data['userType'];
	$emailId = $data['emailId'];
	$password = $data['password'];
	$seniorEmail1 = $data['seniorEmail1'];
	$seniorEmail2 = $data['seniorEmail2'];
	$isAdmin = $data['isAdmin'];
	$viewPermission = $data['viewPermission'];
	$insertPermission = $data['insertPermission'];
	$updatePermission = $data['updatePermission'];
	$deletePermission = $data['deletePermission'];
	$mailPermission = $data['mailPermission'];

	$msg = $userService->addNewUser($firstName,$lastName,$designation,$userName,$emailId,$password,$seniorEmail1,$seniorEmail2,$isAdmin,$viewPermission,$insertPermission,$updatePermission,$deletePermission,$mailPermission,$designation, $userType);
	echo $msg;
	
}else if( isset($data['task']) && 'setTemplate' == $data['task'] ){
	
	$templateType = $data['templateType'];
	$subject = $data['subject'];
	$message = $data['message'];

	session_start();
	
	$renewalSerService = new RenewalSerService();
	$msg = $renewalSerService->setTemplate($templateType, $subject, $message);
	echo $msg;
	
}else if( isset($data['task']) && 'getTemplate' == $data['task'] ){
	$templateType = $data['templateType'];
	
	session_start();
	
	$renewalSerService = new RenewalSerService();
	$template = $renewalSerService->getTemplate($templateType);
	echo json_encode($template);
	
}else if( isset($data['task']) && 'addNewEmailAccount' == $data['task'] )
{
	$firstName = $data['firstName'];
	$lastName = $data['lastName'];
	$designation = $data['designation'];
	$emailId = $data['emailId'];
	
	$msg = $userService->addNewEmailAccount($firstName,$lastName,$designation,$emailId);
	echo $msg;
	
}

else if( isset($data['task']) && 'createTicket' == $data['task'] )
{
	$category = $data['category'];
	$subject = $data['subject'];
	$message = $data['message'];
	
	session_start();
 	$user = $_SESSION["user_id"];

	$msg = $userService->createTicket($user,$category,$subject,$message);
	
	echo $msg;
	
}
else if( isset($data['task']) && 'supportLogin' == $data['task'] )
{
	$loginId = $data['loginId'];
	$userPassword = $data['password'];

	$msg = $userService->supportLogin($loginId,$userPassword);
	
	if($msg=="approved"){
		echo $logintype;
	}else{
		echo $msg;
	}
	
}
else if( isset($data['task']) && 'loginAdmin' == $data['task'] )
{
	$loginId = $data['loginId'];
	$userPassword = $data['password'];

	$msg = $userService->loginAdmin($loginId,$userPassword);
	
	echo $msg;
	
}
else if( isset($data['task']) && 'logout' == $data['task'] )
{
		try{
			session_start();
			session_unset();
			session_destroy();
			setcookie("PHPSESSID",session_id(),time()-1);
		}catch(Exception $e)
		{
			echo 'Caught exception: ',  $e->getMessage(), "\n";
		}
		$arr = array(
			"message" => "success"
		);
		echo json_encode($arr);

}
else if( isset($data['task']) && 'register' == $data['task'] )
{
	$signUpForm = $data['signUpData'];

	$msg = $userService->userRegistration($signUpForm);
	echo $msg;

}
else if( isset($data['task']) && 'supportRegister' == $data['task'] )
{
	$signUpForm = $data['signUpData'];

	$msg = $userService->supportUserRegistration($signUpForm);
	echo $msg;

}
else if( isset($data['task']) && 'registercompany' == $data['task'] )
{
	$signUpForm = $data['signUpData'];

	$msg = $userService->companyRegistration($signUpForm);
	echo $msg;

}
else if( isset($data['task']) && 'simpleTester' == $data['task'] )
{
	
	$msg = $data['loginId'];
	
	echo $msg;

}
else if( isset($data['task']) && 'registercompanyuser' == $data['task'] )
{
	$signUpForm = $data['signUpData'];
	
	session_start();
	$user = $_SESSION["user"];
	$userObj = json_decode($user);
	$company_no = $userObj->userNo;
	
	$msg = $userService->companyUserRegistration($signUpForm, $company_no);
	echo $msg;

}

else if( isset($data['task']) && 'updateUser' == $data['task'] )
{
	$userInfo = $data['updateProfieUser'];

	$msg = $userService->updateUser($userInfo);
	echo $msg;

}
else if( isset($data['task']) && 'updateUserProfile' == $data['task'] )
{
	$userId = $data['userId'];
	$firstName = $data['firstName'];
	$lastName = $data['lastName'];
	$userName = $data['userName'];
	$designation = $data['designation'];
	$emailId = $data['emailId'];
	$isAdmin = $data['isAdmin'];
	$insertPermission = $data['insertPermission'];
	$deletePermission = $data['deletePermission'];
	$updatePermission = $data['updatePermission'];
	$mailPermission = $data['mailPermission'];
	$seniorEmail1 = $data['seniorEmail1'];
	$seniorEmail2 = $data['seniorEmail2'];
	$renewalSerService = new RenewalSerService();
	$msg = $renewalSerService->updateUserProfile($userId,$firstName,$lastName,$userName,$seniorEmail1,
		$seniorEmail2,$designation,$emailId,$isAdmin,$insertPermission,$deletePermission,$updatePermission,$mailPermission);
	echo $msg;

}
else if( isset($data['task']) && 'getProfileInfo' == $data['task'] )
{
	session_start();
	$user = $_SESSION["user"];
	$userObj = json_decode($user);
	$user = $userObj->userNo;
	$userInfo = $userService->getUserInfoByUserNo($user);
	$userInfoArr = array (
			"userInfo" =>$userInfo,
			"message" => "success"
	);
	echo json_encode($userInfoArr);
}else if( isset($data['task']) && 'getDashboardInfo' == $data['task'] )
{
	session_start();
	$user = $_SESSION["user"];
	$userObj = json_decode($user);
	$user = $userObj->userNo;
	$isAdmin = $userObj->isAdmin;
	$dashboardInfo = $userService->getDashboardInfoByUserNo($user, $isAdmin);
	echo json_encode($dashboardInfo);
}else if( isset($data['task']) && 'getDashboardUserInfo' == $data['task'] )
{
	session_start();
	$user = $_SESSION["user"];
	$userObj = json_decode($user);
	$user = $userObj->userNo;
	$dashboardUserInfo = $userService->getDashboardUsersInfoByUserNo($user);
	echo json_encode($dashboardUserInfo);
}
else if( isset($data['task']) && 'checkAllotment' == $data['task'] )
{
    $days = $data['days'];
	session_start();
	$user = $_SESSION["user"];
	$userObj = json_decode($user);
	$user = $userObj->userNo;
	$result = $userService->checkAllotment($user,$days);
	echo $result;
}
else if( isset($data['task']) && 'getVendoreInfo' == $data['task'] )
{
    $mainCat = $data['mainCat'];
    $subCat = $data['subCat'];
	session_start();
	$user = $_SESSION["user"];
	$userObj = json_decode($user);
	$user = $userObj->userNo;
	$vendoreInfo = $userService->getVendoreInfo($mainCat,$subCat,$user);
	echo json_encode($vendoreInfo);
}
else if( isset($data['task']) && 'sendVendoreToMember' == $data['task'] )
{
    $vendoreNo = $data['vendoreNo'];
	session_start();
	$user = $_SESSION["user"];
	$userObj = json_decode($user);
	$userNo = $userObj->userNo;
	$userEmail = $userObj->loginId;
	$msg = $userService->mailMe($vendoreNo,$userEmail);
	echo $msg;
}
else if( isset($data['task']) && 'getRecordInfo' == $data['task'] )
{
    /*
	session_start();
	$user = $_SESSION["user"];
	$userObj = json_decode($user);
	$user = $userObj->userNo;
	$userRecordInfo = $userService->getUserRecordsInfo($user);
	
	if($userRecordInfo != null)
	{
	 	$recordsArr = array (
	        "userRecordsInfo" => $userRecordInfo,
	        "message" => "success"
	    );
	    echo json_encode($recordsArr);
	}
	else
	    echo "failed"; */
	    
	    echo "success";
	
}
else if( isset($data['task']) && 'verifyUser' == $data['task'] )
{
	$vfc = $data['verificationCode'];
	
	session_start();
	$user = $_SESSION["user"];
	$userObj = json_decode($user);
	$user = $userObj->userNo;
	
	$msg = $userService->verifyUser($vfc,$user);
	echo $msg;

}else if ( isset($data['task']) && 'addRenewalService' == $data['task'] ){
	$renewalService = $data['renewalService'];
	//$file = $data['file'];
	//$_FILES
	$file_name = $_FILES['file']['name'];
	echo $file_name;
	//print_r($renewalService[0]['fileObj']);
	
}else if ( isset($data['task']) && 'getRenewalServices' == $data['task'] ){
	
	$catagory = $data['catagory'];
	$userType = $data['userType'];
	
	session_start();
	$user = $_SESSION["user"];
	$userObj = json_decode($user);
	$user = $userObj->userNo;
	$dueFrom = $data['duefrom'];
	$dueTo = $data['dueto'];
	
	$renewalSerService = new RenewalSerService();
	$renewalServices = $renewalSerService->searchRenewalServices($catagory, $user, $userType, $dueFrom,$dueTo);
	echo json_encode($renewalServices);
	
}else if ( isset($data['task']) && 'getRenewalServicesNoUser' == $data['task'] ){
	$userType = $data['userType'];
	$renewalSerService = new RenewalSerService();
	$renewalServices = $renewalSerService->searchRenewalServicesNoUser();
	echo json_encode($renewalServices);
	
}else if ( isset($data['task']) && 'getRenewalLogsByDate' == $data['task'] ){

	$searchDate = $data['date'];
	$from_log = $data['from_log'];
	$to_log = $data['to_log'];

	$renewalSerService = new RenewalSerService();
	$renewalLogs = $renewalSerService->getRenewalLogsByDate($searchDate, $from_log, $to_log);
	echo json_encode($renewalLogs);
	
}else if ( isset($data['task']) && 'getRenewalLogsByUser' == $data['task'] ){

	$user = $data['user'];
	$from_log = $data['from_log1'];
	$to_log = $data['to_log1'];

	$renewalSerService = new RenewalSerService();
	$renewalLogs = $renewalSerService->getRenewalLogsByUser($user, $from_log, $to_log);
	echo json_encode($renewalLogs);
	
}else if ( isset($data['task']) && 'getRenewalLogs' == $data['task'] ){
	
	$category = $data['category'];
	$from_log = $data['from_log'];
	$to_log = $data['to_log'];
	
	$renewalSerService = new RenewalSerService();
	$renewalLogs = $renewalSerService->getRenewalLogs($category, $from_log, $to_log);
	echo json_encode($renewalLogs);
	
}else if ( isset($data['task']) && 'getRenewalUsers' == $data['task'] ){
	
	$renewalSerService = new RenewalSerService();
	$renewalUsers = $renewalSerService->searchRenewalUsers();
	echo json_encode($renewalUsers);
	
}else if ( isset($data['task']) && 'getRenewalEmailAccounts' == $data['task'] ){
	
	$renewalSerService = new RenewalSerService();
	$renewalUsers = $renewalSerService->searchRenewalEmailAccounts();
	echo json_encode($renewalUsers);
	
}
else if ( isset($data['task']) && 'searchRecord' == $data['task'] ){
	
	$searchCatagory = $data['searchType'];
	$userType = $data['userType'];
	$query = $data['query'];
	
	session_start();
	$user = $_SESSION["user"];
	$userObj = json_decode($user);
	$user = $userObj->userNo;
	
	if ($searchCatagory == "all"){
	
	}else{
		$renewalSerService = new RenewalSerService();
		$renewalServices = $renewalSerService->searchRecords($user,$userType,$searchCatagory,$query);
		echo json_encode($renewalServices);
	}
	
}
else if ( isset($data['task']) && 'createLog' == $data['task'] ){
	
	$logActivity = $data['logActivity'];
	$logActivityId = $data['logActivityId'];
	$logDescription = $data['logDescription'];
	
	session_start();
	$user = $_SESSION["user"];
	$userObj = json_decode($user);
	$user = $userObj->userNo;
	
	$renewalSerService = new RenewalSerService();
	$result = $renewalSerService->createLog($user,$logActivity,$logActivityId,$logDescription);
	echo $result;
	
}
else if ( isset($data['task']) && 'getAllRenewalServicesCount' == $data['task'] ){
	
	$userType = $data['userType'];
	session_start();
	$user = $_SESSION["user"];
	$userObj = json_decode($user);
	$user = $userObj->userNo;
	
	$renewalSerService = new RenewalSerService();
	$renewalServicesCount = $renewalSerService->getAllRenewalServicesCount($user,$userType);
	echo json_encode($renewalServicesCount);
	
}
else if ( isset($data['task']) && 'contactUs' == $data['task'] ){
	$username = $data['name'];
	$useremail = $data['email'];
	$usermessage = $data['message'];

	$contactService = new ContactService();
	$msg = $contactService->sendEmail_contactUs($username, $useremail, $usermessage);
	echo $msg;

}else if ( isset($data['task']) && 'deletereport' == $data['task'] ){
 	$recordid = $data['recordId'];
 	$catagory = $data['category'];
 	$subCat = $data['subCat'];
 	
 	session_start();
 	$user = $_SESSION["user"];
 	$userObj = json_decode($user);
 	
	$renewalSerService = new RenewalSerService();
	
	$msg = $renewalSerService->deleteRecord1($recordid, $userObj->name, $userObj->email, $userObj->userNo, $catagory, $subCat);
	echo $msg;

}else if ( isset($data['task']) && 'updateRecord' == $data['task'] ){
 	$recordid = $data['reportId'];
 	$description = $data['description'];
 	$model = $data['model'];
 	$gst = $data['gst'];
 	$supplierName = $data['supplierName'];
 	$amount = $data['amount'];
 	$supplierEmail = $data['supplierEmail'];
 	$supplierContact = $data['supplierContact'];
 	$location = $data['location'];
 	$purchaseDate = $data['purchaseDate'];
 	$expiryDate = $data['expiryDate'];
 	$contractNo = $data['contractNo'];
 	$reminderBefore = $data['reminderBefore'];
 	$daysDiff = $data['daysDiff'];
 	
 	
 	session_start();
 	$user = $_SESSION["user"];
 	$userObj = json_decode($user);
 	
	$renewalSerService = new RenewalSerService();
	
	$msg = $renewalSerService->updateRecord($recordid,$description,$model,$supplierName,$amount,$gst,$supplierEmail,$supplierContact,$location,$purchaseDate,$expiryDate,$contractNo,$reminderBefore,$daysDiff,$userObj);
	echo $msg;

}else if ( isset($data['task']) && 'deleteuser' == $data['task'] ){
 	$userId = $data['userId'];
 	
 	session_start();
 	$user = $_SESSION["user"];
 	$userObj = json_decode($user);
 	
	$renewalSerService = new RenewalSerService();
	
	$msg = $renewalSerService->deleteUser($userId, $userObj);
	echo $msg;

}else if ( isset($data['task']) && 'deleteEmailAccount' == $data['task'] ){
 	$emailAccountId = $data['emailAccountId'];
 	
 	session_start();
 	$user = $_SESSION["user"];
 	$userObj = json_decode($user);
 	
	$renewalSerService = new RenewalSerService();
	
	$msg = $renewalSerService->deleteEmailAccount($emailAccountId, $userObj);
	echo $msg;

}else if ( isset($data['task']) && 'updateProcessStatus' == $data['task'] ){
 	$status = $data['status'];
 	$recordId = $data['recordId'];
 	
	$renewalSerService = new RenewalSerService();
	
	$msg = $renewalSerService->updateProcessStatus($recordId,$status);
	echo $msg;

}else if ( isset($data['task']) && 'updateEmailAccount' == $data['task'] ){
 	$firstName = $data['firstName'];
 	$lastName = $data['lastName'];
 	$designation = $data['designation'];
 	$emailId = $data['emailId'];
 	$emailAccountId = $data['emailAccountId'];
 	
 	session_start();
 	$user = $_SESSION["user"];
 	$userObj = json_decode($user);
 	
	$renewalSerService = new RenewalSerService();
	
	$msg = $renewalSerService->updateEmailAccount($userObj,$firstName,$lastName,$designation,$emailId,$emailAccountId);
	echo $msg;

}else if ( isset($data['task']) && 'sendForgotPasswordMail' == $data['task'] ){
	$forgotPassForm = $data['forgotPassForm'];
	
	$msg = $userService->sendPasswordToUser($forgotPassForm ['loginId']);
	
	echo $msg;

}
else if ( isset($data['task']) && 'changePassword' == $data['task'] ){
	    $loginId = $data['loginId'];
	    $password = $data['password'];
        
        if($loginId == "pankajtakale15@gmail.com")
        {
	        echo "success";
        }
        else
            echo "failed";

}
else if ( isset($data['task']) && 'modifyPassword' == $data['task'] ){
	$loginId = $data['loginId'];
	$userPassword = $data['password'];

	$msg = $userService->modifyPassword($loginId,$userPassword);

	echo $msg;

}
else if ( isset($data['task']) && 'getEmployeeList' == $data['task'] ){
// 	$companyid = $data['companyid'];
	
	session_start();
	$user = $_SESSION["user"];
	$userObj = json_decode($user);
	$companyid = $userObj->userNo;
//echo "asas".$companyid;
	$employeeList = $userService->getEmployeeList($companyid);

	echo json_encode($employeeList);

}
else if ( isset($data['task']) && 'getCompanyInfo' == $data['task'] ){
	 	$companyno = $data['companyno'];
//echo $companyno;
	$companyInfo = $userService->getCompanyInfo($companyno);

	echo json_encode($companyInfo);

}


