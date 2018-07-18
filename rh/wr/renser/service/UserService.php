<?php
include_once ('../common/user.php');
include_once( '../contact/ContactService.php' );
include_once ('../common/Encryption.php');
include_once ('../common/DB.php');

class UserService {
	// register
	public $config;
	function __construct($config) {
		$this->config = $config;
	}
	
	function companyRegistration($userInfo){
		$configInfo = $this->config;
		// print_r($configInfo);
		$user_type = $configInfo->userTypeCompany;
		$company_name = "";
		return $this->register($userInfo, $user_type, $company_name);
	}
	function companyUserRegistration($userInfo,$company_no){
		$configInfo = $this->config;
		// print_r($configInfo);
		$user_type = $configInfo->userTypeCompanyUser;
		$userInfo ['countryName'] = "";
		$userInfo ['pin'] = "000000";
		$userInfo ['userpassword'] = "xxx";
		
		
		return $this->register($userInfo, $user_type, $company_no);
	}
	
	function userRegistration($userInfo){
		$configInfo = $this->config;
		// print_r($configInfo);
		$user_type = $configInfo->userTypeCustomer;
		
		$company_name = "";
		
		return $this->register($userInfo, $user_type, $company_name);
	}
	
	function register($userInfo,$user_type,$company_name) {
		try {
			
			$email = addslashes ( trim ( $userInfo ['email'] ) );
			
			// $login_id = addslashes ( trim ( $userInfo ['loginId'] ) );
			$login_id = $email;
			
			if ($this->isLoginIdExist ( $login_id )) {
				return "exist";
			}
			
			$user_no = "";
			// $user_type = addslashes ( trim ( $userInfo ['userType'] ) );
			// $user_type = "customer";
			
			$first_name = addslashes ( trim ( $userInfo ['firstName'] ) );
			$last_name = addslashes ( trim ( $userInfo ['lastName'] ) );
			//$company_name = addslashes ( trim ( $userInfo ['cmpName'] ) );
			
			// $address = addslashes ( trim ( $userInfo ['addressLine'] ) );
			$address = "";
			$country = addslashes ( trim ( $userInfo ['countryName'] ) );
			// $state = addslashes ( trim ( $userInfo ['state'] ) );
			// $city = addslashes ( trim ( $userInfo ['city'] ) );
			$state = addslashes ( trim ($userInfo ['state']));
			$city = addslashes ( trim ($userInfo['city']));
			$pin = addslashes ( trim ( $userInfo ['pin'] ) );
			// $email = addslashes ( trim ( $userInfo ['email'] ) );
			$mobile = addslashes ( trim ( $userInfo ['mobileNo'] ) );
			// $landline = addslashes ( trim ( $userInfo ['landlineNo'] ) );
			$gstNo = addslashes ( trim ($userInfo ['gst']));
	
			$landline = "";
			$isdeleted = 0;
			$version = 1;
			$isactive = 1;
			// $vfc = addslashes ( trim ( $data ['emailid'] ) );
			$password = addslashes ( trim ( $userInfo ['userpassword'] ) );
			
			date_default_timezone_set ( "UTC" );
			$time = date ( "l jS \of F Y h:i:s A" );
			
			$registered_on = $time;
			$updated_on = $time;
			
			$date = new DateTime (); // echo "5";
			$imgDir = $date->format ( 'Y-m-d H:i:s' ); // echo "6";
			$imgDir = $this->clean ( $imgDir );
			
			$vfc = uniqid ();
// 			$status = "notapproved";
			$status = "approved";
			$profilepic = "../img/users_user_icon.png";
			
			$dbutil = new DBUtil ();
			$conn = $dbutil->getPDOConnection ();
		
			$login_id_encoded = hash ( 'sha256' , $email);
			$confirmed_user = "";
			
			$stmt = $conn->prepare ( "insert into user ( user_no , user_type , gst_no , first_name , last_name , company_name , login_id , 
		registered_on , updated_on , address , country , state , city , pin , email , mobile , landline , isdeleted ,
		version , isactive , vfc , password , img_dir , status , profile_img , login_id_encoded , confirmed_user) 
		values (:user_no, :user_type  , :gst_no , :first_name  , :last_name  , :company_name  ,
				:login_id  , :registered_on  , :updated_on  , :address  , :country  ,
				:state  , :city  , :pin  , :email  , :mobile  , :landline  , :isdeleted  ,
				:version  , :isactive  , :vfc,:password, :img_dir,:status,:profilepic,:loginid_encoded,:conf_user)" );
			
			$stmt->bindParam ( ':user_no', $user_no );
			$stmt->bindParam ( ':user_type', $user_type );
			$stmt->bindParam ( ':gst_no' , $gstNo);
			$stmt->bindParam ( ':first_name', $first_name );
			$stmt->bindParam ( ':last_name', $last_name );
			$stmt->bindParam ( ':company_name', $company_name );
			$stmt->bindParam ( ':login_id', $login_id );
			$stmt->bindParam ( ':registered_on', $registered_on );
			$stmt->bindParam ( ':updated_on', $updated_on );
			
			$stmt->bindParam ( ':address', $address );
			$stmt->bindParam ( ':country', $country );
			$stmt->bindParam ( ':state', $state );
			$stmt->bindParam ( ':city', $city );
			$stmt->bindParam ( ':pin', $pin );
			$stmt->bindParam ( ':email', $email );
			$stmt->bindParam ( ':mobile', $mobile );
			$stmt->bindParam ( ':landline', $landline );
			$stmt->bindParam ( ':isdeleted', $isdeleted );
			$stmt->bindParam ( ':version', $version );
			$stmt->bindParam ( ':isactive', $isactive );
			$stmt->bindParam ( ':vfc', $vfc );
			$stmt->bindParam ( ':password', $password );
			$stmt->bindParam ( ':img_dir', $imgDir );
			$stmt->bindParam ( ':status', $status );
			$stmt->bindParam ( ':profilepic', $profilepic );
			$stmt->bindParam ( ':loginid_encoded', $login_id_encoded);
		    $stmt->bindParam ( ':conf_user', $confirmed_user);
			
			$stmt->execute ();
			$stmt = null; 
			
			$selectStmt = $conn->prepare ( 'SELECT id FROM user WHERE login_id = :login_id' );
			$selectStmt->bindParam ( ':login_id', $login_id, PDO::PARAM_STR );
			$selectStmt->execute ();
		
			$user_no = 21 * 5;
			while ( $userInfo = $selectStmt->fetch () ) {
				$userId = $userInfo ['id'];
				// $userId = $userInfo[0]['id'];
				$user_no = 21 * $userId + 5;
			}
			
			$selectStmt = null;
			
			$updateStmt = $conn->prepare ( "UPDATE user SET user_no=:user_no where login_id = :login_id" );
			$updateStmt->bindParam ( ":user_no", $user_no, PDO::PARAM_STR );
			$updateStmt->bindParam ( ':login_id', $login_id, PDO::PARAM_STR );
			$updateStmt->execute ();
			
			$updateStmt = null;
			
			$noOfYear = 0;
			$customer_type = "T";
			$no_of_records = 200;
			$no_of_months = 0;
			$remaining_days = 0;
			$insertStmt = $conn->prepare ( "insert into user_payment_status (updated_on,no_of_year,user,no_of_months,remaining_days,no_of_records,user_type) values(:updated_on,:no_of_year,:user,:no_of_months,:remaining_days,:no_of_records,:customer_type)" );
			$insertStmt->bindParam ( ":updated_on", $registered_on, PDO::PARAM_STR );
			$insertStmt->bindParam ( ':no_of_year', $noOfYear, PDO::PARAM_INT );
			$insertStmt->bindParam ( ':user', $user_no, PDO::PARAM_STR );
			$insertStmt->bindParam ( ':no_of_months', $no_of_months, PDO::PARAM_STR );
			$insertStmt->bindParam ( ':remaining_days', $remaining_days, PDO::PARAM_STR );
			$insertStmt->bindParam ( ':no_of_records', $no_of_records, PDO::PARAM_STR );
			$insertStmt->bindParam ( ':customer_type', $customer_type, PDO::PARAM_STR );
			$insertStmt->execute ();
				
			$insertStmt = null;
			$conn = null;
			
			$contactService = new ContactService();
			$configInfo = $this->config;
			
			if($user_type==$configInfo->userTypeCustomer){
				$msg = $contactService->sendEmailAndSms_registration($user_name, $vfc, $mobile, $email);
				$msgText = "Dear subscriber, thank you for subscribing with us. Now you can use the service.";
				//$contactService->sendSMS($mobile,$msgText);
			}else if($user_type==$configInfo->userTypeCompanyUser){
				$converter = new Encryption();
				$company_name = $converter->encode($company_name);
				//echo "encode:".$company_name;
				$msg = $contactService->sendEmailAndSms_registrationCompanyUser($user_name, $vfc, $mobile, $email,$company_name);
			}else if($user_type==$configInfo->userTypeCompany){
				$msg = $contactService->sendEmailAndSms_registrationCompany($user_name, $vfc, $mobile, $email);
			}
			
			return "success";
		} catch ( PDOException $e ) {
			$conn = null;
			print $e->getMessage ();
			return "failed";
		}
	}
	
	function addNewUser($firstName,$lastName,$designation, $userName, $emailId, $password, $seniorEmail1, $seniorEmail2, $isAdmin, $viewPermission, $insertPermission, $updatePermission, $deletePermission, $mailPermission, $designation, $userType) {
		try {

			$firstName = addslashes ( trim ($firstName) );
			$lastName = addslashes ( trim ($lastName) );
			$designation = addslashes ( trim ($designation) );
			$userName = addslashes ( trim ($userName) );
			$emailId = addslashes ( trim ($emailId) );
			$password = addslashes ( trim ($password) );
			$seniorEmail1 = addslashes ( trim ($seniorEmail1) );
			$seniorEmail2 = addslashes ( trim ($seniorEmail2) );
			$designation = addslashes ( trim ($designation) );
			$login_id = $emailId;
			$user_type = $userType;
			
			if ($this->isUserNameExist ( $userName)) {
				return "exist";
			}
			
			$user_no = "";
			
			$address = "";
			$country = "";
			// $state = addslashes ( trim ( $userInfo ['state'] ) );
			// $city = addslashes ( trim ( $userInfo ['city'] ) );
			$state = "";
			$city = "";
			$pin = "";
			// $email = addslashes ( trim ( $userInfo ['email'] ) );
			$mobile = "";
			// $landline = addslashes ( trim ( $userInfo ['landlineNo'] ) );
			$gstNo = "";
	
			$landline = "";
			$isdeleted = 0;
			$version = 1;
			$isactive = 1;
			
			date_default_timezone_set ( "UTC" );
			$time = date ( "l jS \of F Y h:i:s A" );
			
			$registered_on = $time;
			$updated_on = $time;
			
			$date = new DateTime (); // echo "5";
			$imgDir = $date->format ( 'Y-m-d H:i:s' ); // echo "6";
			$imgDir = $this->clean ( $imgDir );
			
			$vfc = uniqid ();
// 			$status = "notapproved";
			$status = "approved";
			$profilepic = "../img/users_user_icon.png";
			
			$dbutil = new DBUtil ();
			$conn = $dbutil->getPDOConnection ();
		
				/*$registeredDate = "";
				$selectStmt = $conn->prepare("select * from validator");
				$selectStmt->execute();
				
			 	while ($row = $selectStmt->fetch()){
			 		$registeredDate = $row["startdate"];
			 	}
				
				$datetime1 = new DateTime($registeredDate);
				$datetime2 = new DateTime();
				$interval = $datetime1->diff($datetime2);
				$days =  $interval->format('%a');
				if ($days > 15){
					return "expired";
				} */
			
			$login_id_encoded = hash ( 'sha256' , $emailId);
			$confirmed_user = "";
			
			$stmt = $conn->prepare ( "insert into user ( user_no , user_type , gst_no , first_name , last_name , company_name , login_id , 
		registered_on , updated_on , address , country , state , city , pin , email , mobile , landline , isdeleted ,
		version , isactive , vfc , password , img_dir , status , profile_img , login_id_encoded , confirmed_user, is_admin, view_permission, insert_permission, update_permission, delete_permission, mail_permission, designation, username, senior_email1, senior_email2) 
		values (:user_no, :user_type  , :gst_no , :first_name  , :last_name  , :company_name  ,
				:login_id  , :registered_on  , :updated_on  , :address  , :country  ,
				:state  , :city  , :pin  , :email  , :mobile  , :landline  , :isdeleted  ,
				:version  , :isactive  , :vfc,:password, :img_dir,:status,:profilepic,:loginid_encoded,:conf_user,:is_admin,:view_permission,:insert_permission,:update_permission,:delete_permission,:mail_permission,:designation,:username,:senior_email1,:senior_email2)" );
			
			$stmt->bindParam ( ':user_no', $user_no );
			$stmt->bindParam ( ':user_type', $user_type );
			$stmt->bindParam ( ':gst_no' , $gstNo);
			$stmt->bindParam ( ':first_name', $firstName );
			$stmt->bindParam ( ':last_name', $lastName );
			$stmt->bindParam ( ':company_name', $company_name );
			$stmt->bindParam ( ':login_id', $login_id );
			$stmt->bindParam ( ':registered_on', $registered_on );
			$stmt->bindParam ( ':updated_on', $updated_on );
			
			$stmt->bindParam ( ':address', $address );
			$stmt->bindParam ( ':country', $country );
			$stmt->bindParam ( ':state', $state );
			$stmt->bindParam ( ':city', $city );
			$stmt->bindParam ( ':pin', $pin );
			$stmt->bindParam ( ':email', $emailId );
			$stmt->bindParam ( ':mobile', $mobile );
			$stmt->bindParam ( ':landline', $landline );
			$stmt->bindParam ( ':isdeleted', $isdeleted );
			$stmt->bindParam ( ':version', $version );
			$stmt->bindParam ( ':isactive', $isactive );
			$stmt->bindParam ( ':vfc', $vfc );
			$stmt->bindParam ( ':password', $password );
			$stmt->bindParam ( ':img_dir', $imgDir );
			$stmt->bindParam ( ':status', $status );
			$stmt->bindParam ( ':profilepic', $profilepic );
			$stmt->bindParam ( ':loginid_encoded', $login_id_encoded);
		    $stmt->bindParam ( ':conf_user', $confirmed_user);
		    $stmt->bindParam ( ':is_admin', $isAdmin);
		    $stmt->bindParam ( ':view_permission', $viewPermission);
		    $stmt->bindParam ( ':insert_permission', $insertPermission);
		    $stmt->bindParam ( ':update_permission', $updatePermission);
		    $stmt->bindParam ( ':delete_permission', $deletePermission);
		    $stmt->bindParam ( ':mail_permission', $mailPermission);
		    $stmt->bindParam ( ':designation', $designation);
		    $stmt->bindParam ( ':username', $userName);
		    $stmt->bindParam ( ':senior_email1', $seniorEmail1);
		    $stmt->bindParam ( ':senior_email2', $seniorEmail2);
			
			$stmt->execute ();
			$stmt = null; 
			
			$selectStmt = $conn->prepare ( 'SELECT id FROM user WHERE login_id = :login_id' );
			$selectStmt->bindParam ( ':login_id', $login_id, PDO::PARAM_STR );
			$selectStmt->execute ();
		
			$user_no = 21 * 5;
			while ( $userInfo = $selectStmt->fetch () ) {
				$userId = $userInfo ['id'];
				// $userId = $userInfo[0]['id'];
				$user_no = 21 * $userId + 5;
			}
			
			$selectStmt = null;
			
			$updateStmt = $conn->prepare ( "UPDATE user SET user_no=:user_no where login_id = :login_id" );
			$updateStmt->bindParam ( ":user_no", $user_no, PDO::PARAM_STR );
			$updateStmt->bindParam ( ':login_id', $login_id, PDO::PARAM_STR );
			$updateStmt->execute ();
			
			$updateStmt = null;
	
			return "success";
		} catch ( PDOException $e ) {
			$conn = null;
			print $e->getMessage ();
			return "failed";
		}
	}
	
	function addNewEmailAccount($firstName,$lastName,$designation,$emailId) {
		try {
		
			$firstName = addslashes ( trim ($firstName) );
			$lastName = addslashes ( trim ($lastName) );
			$designation = addslashes ( trim ($designation) );
			$emailId = addslashes ( trim ($emailId) );
			
			if ($this->isEmailAccountExist ( $emailId )) {
				return "exist";
			}
			
			$dbutil = new DBUtil ();
			$conn = $dbutil->getPDOConnection ();
		
			/*	$registeredDate = "";
				$selectStmt = $conn->prepare("select * from validator");
				$selectStmt->execute();
				
			 	while ($row = $selectStmt->fetch()){
			 		$registeredDate = $row["startdate"];
			 	}
				
				$datetime1 = new DateTime($registeredDate);
				$datetime2 = new DateTime();
				$interval = $datetime1->diff($datetime2);
				$days =  $interval->format('%a');
				if ($days > 15){
					return "expired";
				} */
			
			
			$stmt = $conn->prepare ( "insert into emailaccounts ( firstName , lastName , designation, email_id) 
					values (:first_name,:last_name,:designation,:emailId)" );
			
			$stmt->bindParam ( ':first_name', $firstName );
			$stmt->bindParam ( ':last_name', $lastName );
			$stmt->bindParam ( ':designation', $designation);
		    $stmt->bindParam ( ':emailId', $emailId);
			$stmt->execute ();
			$stmt = null; 
			
			return "success";
		} catch ( PDOException $e ) {
			$conn = null;
			print $e->getMessage ();
			return "failed";
		}
	}
	
	function firstRegistration($firstName, $lastName, $designation, $emailId, $userName, $userPassword) {
		try {
		
			$firstName = addslashes ( trim ($firstName) );
			$lastName = addslashes ( trim ($lastName) );
			$designation = addslashes ( trim ($designation) );
			$userName = addslashes ( trim ($userName) );
			$emailId = addslashes ( trim ($emailId) );
			$seniorEmail1 = "";
			$seniorEmail2 = "";
			$password = addslashes ( trim ($userPassword) );
			$login_id = $emailId;
			$user_type = "Customer";
			
			$isAdmin = "YES";
			$viewPermission = "YES";
			$insertPermission = "YES";
			$updatePermission = "YES";
			$deletePermission = "YES";
			$mailPermission = "YES";
			
			if ($this->isUserNameExist ( $userName )) {
				return "exist";
			}
			
			$user_no = "";
			
			$address = "";
			$country = "";
			// $state = addslashes ( trim ( $userInfo ['state'] ) );
			// $city = addslashes ( trim ( $userInfo ['city'] ) );
			$state = "";
			$city = "";
			$pin = "";
			// $email = addslashes ( trim ( $userInfo ['email'] ) );
			$mobile = "";
			// $landline = addslashes ( trim ( $userInfo ['landlineNo'] ) );
			$gstNo = "";
	
			$landline = "";
			$isdeleted = 0;
			$version = 1;
			$isactive = 1;
			
			date_default_timezone_set ( "UTC" );
			$time = date ( "l jS \of F Y h:i:s A" );
			
			$registered_on = $time;
			$updated_on = $time;
			
			$date = new DateTime (); // echo "5";
			$imgDir = $date->format ( 'Y-m-d H:i:s' ); // echo "6";
			$imgDir = $this->clean ( $imgDir );
			
			$vfc = uniqid ();
// 			$status = "notapproved";
			$status = "approved";
			$profilepic = "../img/users_user_icon.png";
			
			$dbutil = new DBUtil ();
			$conn = $dbutil->getPDOConnection ();
			
			$selectStmt = $conn->prepare("SELECT COUNT(*) FROM user");
			$selectStmt->execute();
			
			$noOfUsers = $selectStmt->fetchColumn();
			
			if ($noOfUsers > 0 ){
				return "usersAvailable";
			}
		
			$login_id_encoded = hash ( 'sha256' , $emailId);
			$confirmed_user = "";
			
			$stmt = $conn->prepare ( "insert into user ( user_no , user_type , gst_no , first_name , last_name , company_name , login_id , 
		registered_on , updated_on , address , country , state , city , pin , email , mobile , landline , isdeleted ,
		version , isactive , vfc , password , img_dir , status , profile_img , login_id_encoded , confirmed_user, is_admin, view_permission, insert_permission, update_permission, delete_permission, mail_permission, designation, username, senior_email1, senior_email2) 
		values (:user_no, :user_type  , :gst_no , :first_name  , :last_name  , :company_name  ,
				:login_id  , :registered_on  , :updated_on  , :address  , :country  ,
				:state  , :city  , :pin  , :email  , :mobile  , :landline  , :isdeleted  ,
				:version  , :isactive  , :vfc,:password, :img_dir,:status,:profilepic,:loginid_encoded,:conf_user,:is_admin,:view_permission,:insert_permission,:update_permission,:delete_permission,:mail_permission,:designation,:username,:seniorEmail1,:seniorEmail2)" );
			
			$stmt->bindParam ( ':user_no', $user_no );
			$stmt->bindParam ( ':user_type', $user_type );
			$stmt->bindParam ( ':gst_no' , $gstNo);
			$stmt->bindParam ( ':first_name', $firstName );
			$stmt->bindParam ( ':last_name', $lastName );
			$stmt->bindParam ( ':company_name', $company_name );
			$stmt->bindParam ( ':login_id', $login_id );
			$stmt->bindParam ( ':registered_on', $registered_on );
			$stmt->bindParam ( ':updated_on', $updated_on );
			
			$stmt->bindParam ( ':address', $address );
			$stmt->bindParam ( ':country', $country );
			$stmt->bindParam ( ':state', $state );
			$stmt->bindParam ( ':city', $city );
			$stmt->bindParam ( ':pin', $pin );
			$stmt->bindParam ( ':email', $emailId );
			$stmt->bindParam ( ':mobile', $mobile );
			$stmt->bindParam ( ':landline', $landline );
			$stmt->bindParam ( ':isdeleted', $isdeleted );
			$stmt->bindParam ( ':version', $version );
			$stmt->bindParam ( ':isactive', $isactive );
			$stmt->bindParam ( ':vfc', $vfc );
			$stmt->bindParam ( ':password', $password );
			$stmt->bindParam ( ':img_dir', $imgDir );
			$stmt->bindParam ( ':status', $status );
			$stmt->bindParam ( ':profilepic', $profilepic );
			$stmt->bindParam ( ':loginid_encoded', $login_id_encoded);
		    $stmt->bindParam ( ':conf_user', $confirmed_user);
		    $stmt->bindParam ( ':is_admin', $isAdmin);
		    $stmt->bindParam ( ':view_permission', $viewPermission);
		    $stmt->bindParam ( ':insert_permission', $insertPermission);
		    $stmt->bindParam ( ':update_permission', $updatePermission);
		    $stmt->bindParam ( ':delete_permission', $deletePermission);
		    $stmt->bindParam ( ':mail_permission', $mailPermission);
		    $stmt->bindParam ( ':designation', $designation);
		    $stmt->bindParam ( ':username', $userName);
		    $stmt->bindParam ( ':seniorEmail1', $seniorEmail1);
		    $stmt->bindParam ( ':seniorEmail2', $seniorEmail2);
			
			$stmt->execute ();
			$stmt = null; 
			
			$selectStmt = $conn->prepare ( 'SELECT id FROM user WHERE login_id = :login_id' );
			$selectStmt->bindParam ( ':login_id', $login_id, PDO::PARAM_STR );
			$selectStmt->execute ();
		
			$user_no = 21 * 5;
			while ( $userInfo = $selectStmt->fetch () ) {
				$userId = $userInfo ['id'];
				// $userId = $userInfo[0]['id'];
				$user_no = 21 * $userId + 5;
			}
			
			$selectStmt = null;
			
			$updateStmt = $conn->prepare ( "UPDATE user SET user_no=:user_no where login_id = :login_id" );
			$updateStmt->bindParam ( ":user_no", $user_no, PDO::PARAM_STR );
			$updateStmt->bindParam ( ':login_id', $login_id, PDO::PARAM_STR );
			$updateStmt->execute ();
			
			$updateStmt = null;
	
			return "success";
		} catch ( PDOException $e ) {
			$conn = null;
			print $e->getMessage ();
			return "failed";
		}
	}
	
	function supportUserRegistration($userInfo){
		$configInfo = $this->config;
		
		$company_name = "";
		
		return $this->supportRegister($userInfo);
	}
	
	function supportRegister($userInfo) {
		try {

			$email = addslashes ( trim ( $userInfo ['email'] ) );
			$corporationName = addslashes ( trim ($userInfo ['corporationname']) );
			
			if ($this->supportIsLoginIdExist ( $email )) {
				return "exist";
			}
			
			$user_no = "";
			// $user_type = addslashes ( trim ( $userInfo ['userType'] ) );
			// $user_type = "customer";
			
			// $vfc = addslashes ( trim ( $data ['emailid'] ) );
			$password = addslashes ( trim ( $userInfo ['userpassword'] ) );
			
			date_default_timezone_set ( "UTC" );
			$time = date ( "l jS \of F Y h:i:s A" );
			
			$registered_on = $time;
			$updated_on = $time;
			
			$date = new DateTime (); // echo "5";
			$imgDir = $date->format ( 'Y-m-d H:i:s' ); // echo "6";
			$imgDir = $this->clean ( $imgDir );
			
			$vfc = uniqid ();
// 			$status = "notapproved";
		
			$dbutil = new DBUtil ();
			$conn = $dbutil->getPDOConnection ();
			
			$stmt = $conn->prepare ( "insert into support_users ( user_email , user_corporation , user_password, registered_date) 
		values (:user_email, :user_corporation, :user_password, :registered_date)");
			
			$stmt->bindParam ( ':user_email', $email );
			$stmt->bindParam ( ':user_corporation', $corporationName );
			$stmt->bindParam ( ':user_password' , $password);
			$stmt->bindParam ( ':registered_date' , $registered_on);
			
			$stmt->execute ();
			$stmt = null; 
			
			return "success";
		} catch ( PDOException $e ) {
			$conn = null;
			print $e->getMessage ();
			return "failed";
		}
	}
	
	function updateUser($userInfo) {
		try {
			
			$email = addslashes ( trim ( $userInfo ['email'] ) );
			
			$password  = addslashes ( trim ( $userInfo ['password']));
			
			$user_no = addslashes ( trim ( $userInfo ['userNo'] ) );
			// $user_type = addslashes ( trim ( $userInfo ['userType'] ) );
			// $user_type = "customer";
			$configInfo = $this->config;
			// print_r($configInfo);
			$first_name = addslashes ( trim ( $userInfo ['firstName'] ) );
			$last_name = addslashes ( trim ( $userInfo ['lastName'] ) );
			$user_name = addslashes ( trim ( $userInfo ['userName'] ) );
			$designation = addslashes ( trim ( $userInfo ['designation'] ) );
			$version = addslashes ( trim ( $userInfo ['version'] ) );
			
			date_default_timezone_set ( "UTC" );
			$time = date ( "l jS \of F Y h:i:s A" );
				
// 			$registered_on = $time;
			$updated_on = $time;
				
// 			$date = new DateTime (); // echo "5";
// 			$imgDir = $date->format ( 'Y-m-d H:i:s' ); // echo "6";
// 			$imgDir = $this->clean ( $imgDir );
				
// 			$vfc = uniqid ();
// 			$status = "notapproved";	
			
			$dbutil = new DBUtil ();
			$conn = $dbutil->getPDOConnection ();
				
			$updateStmt = $conn->prepare ( "UPDATE user SET first_name=:first_name, last_name=:last_name,
					updated_on=:updated_on,email=:email , password=:password, version=:version, username=:username, designation=:designation where user_no=:user_no" );
				
 			$updateStmt->bindParam ( ':user_no', $user_no );
			$updateStmt->bindParam ( ':first_name', $first_name );
			$updateStmt->bindParam ( ':last_name', $last_name );
			$updateStmt->bindParam ( ':updated_on', $updated_on );
			$updateStmt->bindParam ( ':email', $email );
			$updateStmt->bindParam ( ':version', $version );
			$updateStmt->bindParam ( ':username', $user_name );
			$updateStmt->bindParam ( ':designation', $designation );
			$updateStmt->bindParam ( ':password', $password);
				
			$updateStmt->execute ();
			$updateStmt = null;
			
			$conn = null;
		
			return "success";
		} catch ( PDOException $e ) {
			$conn = null;
			print $e->getMessage ();
			return "failed";
		}
	}
	
	
	function updateUserProfile($_FILESArr,$user,$userVersion) {

		if(isset($_FILESArr['file'])){
		
			//echo "33";
			$errors= array();
			//$description = $_FILESArr['description'];
			$file_name = $_FILESArr['file']['name'];
		
			$file_size = $_FILESArr['file']['size'];
			$file_tmp = $_FILESArr['file']['tmp_name'];
			$file_type = $_FILESArr['file']['type'];
		
			$fileVar = explode('.',$_FILESArr['file']['name']);
		
			$file_ext=strtolower(end($fileVar));
			//echo "22";
			$expensions= array("jpeg","jpg","png");
		
			if(in_array($file_ext,$expensions)=== false){
				$errors[]="extension not allowed, please choose a JPEG or PNG file.";
			}// echo "23";
		
			if($file_size > 2097152) {
				$errors[]='File size must be excately 2 MB';
			}
		
			if(empty($errors)==true) {
				//echo "uploads/".$imgDir."/".$file_name;
				date_default_timezone_set('UTC');
				
				//date("Y-m-d")
				$dirPath = "../uploads/".$user->imgDir."/profile";
					
				if (!file_exists($dirPath)) {
					mkdir($dirPath, 0777, true);
				}
		
				$status = $this->updateProfilePicInDB($dirPath."/".$file_name, $user,$userVersion);
		
				if($status=="success")
				{
					if (!file_exists($dirPath."/".$file_name)) {
						move_uploaded_file($file_tmp,$dirPath."/".$file_name);
					}
						
					echo "success";
		
				}else {
					echo "failed";
				}
		
				//return "Success";
				// echo "<img src='uploads/.$file_name'>";
			}else{
				print_r($errors);
			}
		}
		
	}
	
	function updateProfilePicInDB($profilePic, $userInfo,$userVersion) {
		try {

			$configInfo = $this->config;
			$version =$userVersion+1;
			$user_no = $userInfo ->userNo;
			
			date_default_timezone_set ( "UTC" );
			$time = date ( "l jS \of F Y h:i:s A" );
		
			$updated_on = $time;
		
			$dbutil = new DBUtil ();
			$conn = $dbutil->getPDOConnection ();
		
			$updateStmt = $conn->prepare ( "UPDATE user SET 
					updated_on=:updated_on,version=:version,profile_img=:profile_img
					where user_no=:user_no" );
		
			$updateStmt->bindParam ( ':user_no', $user_no );
		
			$updateStmt->bindParam ( ':updated_on', $updated_on );
			$updateStmt->bindParam ( ':profile_img', $profilePic );
		
			// 			$updateStmt->bindParam ( ':landline', $landline );
			$updateStmt->bindParam ( ':version', $version );
		
		
			$updateStmt->execute ();
			$updateStmt = null;
				
			$conn = null;
		
			return "success";
		} catch ( PDOException $e ) {
			$conn = null;
			print $e->getMessage ();
			return "failed";
		}
	}
	
	
	function isLoginIdExist($login_id) {
		try {
			$dbutil = new DBUtil();
			
			$con = $dbutil->getPDOConnection ();
			
			$isLoginIdExistStmt = $con->prepare ( 'SELECT count(*) FROM user WHERE login_id = :login_id' );
			
			$isLoginIdExistStmt->bindParam ( ':login_id', $login_id, PDO::PARAM_STR );
			$isLoginIdExistStmt->execute ();
			
			$noOfRows = $isLoginIdExistStmt->fetchColumn ();
			
			// $noOfRows = $isLoginIdExistStmt->rowCount ();
			
			if ($noOfRows > 0) {
				$isLoginIdExistStmt = null;
				$con = null;
				return true;
			} else {
				$isLoginIdExistStmt = null;
				$con = null;
				return false;
			}
		} catch ( PDOException $e ) {
			return false;
		}
	}
	
	function isUserNameExist($user_name) {
		try {
			
		
			$dbutil = new DBUtil();
			$con = $dbutil->getPDOConnection ();
			
			$isUserNameExistStmt = $con->prepare ( 'SELECT count(*) FROM user WHERE username = :username' );
			
			$isUserNameExistStmt->bindParam ( ':username', $user_name, PDO::PARAM_STR );
			$isUserNameExistStmt->execute ();
			
			$noOfRows = $isUserNameExistStmt->fetchColumn ();
			
			// $noOfRows = $isLoginIdExistStmt->rowCount ();
			
			if ($noOfRows > 0) {
				$isUserNameExistStmt = null;
				$con = null;
				return true;
			} else {
				$isUserNameExistStmt = null;
				$con = null;
				return false;
			}
		} catch ( PDOException $e ) {
			return false;
		}
	}
	
	function isEmailAccountExist($email_account) {
		try {
		
		
			$dbutil = new DBUtil();
			
			$con = $dbutil->getPDOConnection ();
			
			$isEmailAccountExistStmt = $con->prepare ( 'SELECT count(*) FROM emailaccounts WHERE email_id = :emailId' );
			
			$isEmailAccountExistStmt->bindParam ( ':emailId', $email_account, PDO::PARAM_STR );
			$isEmailAccountExistStmt->execute ();
			
			$noOfRows = $isEmailAccountExistStmt->fetchColumn ();
			
			// $noOfRows = $isLoginIdExistStmt->rowCount ();
			
			if ($noOfRows > 0) {
				$isEmailAccountExistStmt = null;
				$con = null;
				return true;
			} else {
				$isEmailAccountExistStmt = null;
				$con = null;
				return false;
			}
		} catch ( PDOException $e ) {
			return false;
		}
	}
	
	function supportIsLoginIdExist($user_email) {
		try {
			$dbutil = new DBUtil();
			
			$con = $dbutil->getPDOConnection ();
			
			$isLoginIdExistStmt = $con->prepare ( 'SELECT count(*) FROM support_users WHERE user_email = :user_email' );
			
			$isLoginIdExistStmt->bindParam ( ':user_email', $user_email, PDO::PARAM_STR );
			$isLoginIdExistStmt->execute ();
			
			$noOfRows = $isLoginIdExistStmt->fetchColumn ();
			
			// $noOfRows = $isLoginIdExistStmt->rowCount ();
			
			if ($noOfRows > 0) {
				$isLoginIdExistStmt = null;
				$con = null;
				return true;
			} else {
				$isLoginIdExistStmt = null;
				$con = null;
				return false;
			}
		} catch ( PDOException $e ) {
			return false;
		}
	}
	function isConfirmedUser($login_id) {
		try {
			$dbutil = new DBUtil();
			
			$con = $dbutil->getPDOConnection ();
			
			$isConfirmedUserStmt = $con->prepare ( 'SELECT confirmed_user FROM user WHERE login_id = :login_id' );
			
			$isConfirmedUserStmt->bindParam ( ':login_id', $login_id, PDO::PARAM_STR );
			$isConfirmedUserStmt->execute ();
			
			$result = "";
			
			while($row = $isConfirmedUserStmt->fetch())
			{
			    $result = $row["confirmed_user"];
			}
			
			if($result == "Confirmed")
			{
			    return "done";
			}
			else
			{
			    return "fail";
			}
		
		} catch ( PDOException $e ) {
			return "fail";
		}
	}
	function login($loginId,$userPassword,$logintype) {
		$login_id = addslashes ( trim ( $loginId ) );
		$password = addslashes ( trim ( $userPassword ) );
		$logintype = addslashes ( trim ( $logintype ) );
		try {
		
			$dbutil = new DBUtil ();
			
			$conn = $dbutil->getPDOConnection ();
			
			$query = "SELECT count(*)  from user WHERE login_id = :login_id and password=:password and user_type=:logintype";
			
			$selectStmt = $conn->prepare ( $query );
			
			$selectStmt->bindParam ( ':login_id', $login_id, PDO::PARAM_STR );
			$selectStmt->bindParam ( ':password', $password, PDO::PARAM_STR );
			$selectStmt->bindParam ( ':logintype', $logintype, PDO::PARAM_STR );
			
			$selectStmt->execute ();
			$number_of_rows = $selectStmt->fetchColumn ();
			
			$conn = null;
			$selectStmt = null;
			
			if ($number_of_rows == 1) {
				$userInfo = $this->getUserByLoginId ( $login_id );

				session_start ();
				// $user = new User($userInfo['user_no'], $userInfo['user_type'],$userInfo['name'],$userInfo['img_dir'],"true");
				$_SESSION ["loggedin"] = "true";
				$userJson = json_encode ( $userInfo );
				// echo $userJson;
				$_SESSION ['sid'] = session_id ();
				$_SESSION ["user"] = $userJson;
				$_SESSION ["user_dup"] = $userInfo;
				
				//return $userInfo ["status"];
				if($userInfo ["isconfirmed"] == "confirmed")
				{
				    return "confirmed";    
				}
				else
				{
				    return "fail";
				} 
				
			} else {
				return "failed";
			}
		} catch ( PDOException $e ) {
			print $e;
		}
	}
	
	function loginByUserName($userName,$userPassword) {
		$userName = addslashes ( trim ( $userName ) );
		$password = addslashes ( trim ( $userPassword ) );
		try {
		
			$dbutil = new DBUtil ();
			
			$conn = $dbutil->getPDOConnection ();
			
			$query = "SELECT count(*)  from user WHERE username = :user_name and password=:password";
			
			$selectStmt = $conn->prepare ( $query );
			
			$selectStmt->bindParam ( ':user_name', $userName, PDO::PARAM_STR );
			$selectStmt->bindParam ( ':password', $password, PDO::PARAM_STR );
			
			$selectStmt->execute ();
			$number_of_rows = $selectStmt->fetchColumn ();
			
			$conn = null;
			$selectStmt = null;
			
			if ($number_of_rows == 1) {
				$userInfo = $this->getUserByUserName( $userName );
				session_start();
				// $user = new User($userInfo['user_no'], $userInfo['user_type'],$userInfo['name'],$userInfo['img_dir'],"true");
				$_SESSION ["loggedin"] = "true";
				$userJson = json_encode ( $userInfo );
				// echo $userJson;
				$_SESSION ['sid'] = session_id ();
				$_SESSION ["user"] = $userJson;
				$_SESSION ["user_dup"] = $userInfo;
				return "confirmed";     
			} else {
				return "failed";
			}
		} catch ( PDOException $e ) {
			print $e;
		}
	}
	
	function supportLogin($loginId,$userPassword) {
		$login_id = addslashes ( trim ( $loginId ) );
		$password = addslashes ( trim ( $userPassword ) );
		
		try {
			$dbutil = new DBUtil ();
			
			$conn = $dbutil->getPDOConnection ();
			
			$query = "SELECT count(*)  from support_users WHERE user_email = :user_email and user_password=:password";
			
			$selectStmt = $conn->prepare ( $query );
			
			$selectStmt->bindParam ( ':user_email', $login_id, PDO::PARAM_STR );
			$selectStmt->bindParam ( ':password', $password, PDO::PARAM_STR );
			
			$selectStmt->execute ();
			
			$number_of_rows = $selectStmt->fetchColumn ();
			
			$conn = null;
			$selectStmt = null;
			
			if ($number_of_rows == 1) {
				$userInfo = $this->getSupportUserByEmailId ( $login_id );

				session_start ();
				// $user = new User($userInfo['user_no'], $userInfo['user_type'],$userInfo['name'],$userInfo['img_dir'],"true");
				$_SESSION ["loggedin"] = "true";
				$_SESSION ["user_id"] = $userInfo['user_id'];
				$_SESSION ["user_email"] = $userInfo ['user_email'];
				$_SESSION ["user_corporation"] = $userInfo ['user_corporation'];
				$_SESSION ["registered_on"] = $userInfo ['registered_on'];
				//$userJson = json_encode ( $userInfo );
				// echo $userJson;
				//$_SESSION ['sid'] = session_id ();
				//$_SESSION ["user"] = $userJson;
				//$_SESSION ["user_dup"] = $userInfo;
				
				return "success";
				
			} else {
				return "failed";
			}
		} catch ( PDOException $e ) {
			print $e;
		}
	}
	
	function loginAdmin($loginId,$userPassword) {
		$login_id = addslashes ( trim ( $loginId ) );
		$password = addslashes ( trim ( $userPassword ) );
		
		try {
			$dbutil = new DBUtil ();
			
			$conn = $dbutil->getPDOConnection ();
			
			$query = "SELECT count(*)  from admin WHERE login_id = :login_id and password=:password";
			
			$selectStmt = $conn->prepare ( $query );
			
			$selectStmt->bindParam ( ':login_id', $login_id, PDO::PARAM_STR );
			$selectStmt->bindParam ( ':password', $password, PDO::PARAM_STR );
			
			$selectStmt->execute ();
			
			$number_of_rows = $selectStmt->fetchColumn ();
			
			$conn = null;
			$selectStmt = null;
			
			if ($number_of_rows == 1) {
			    session_start();
			    $_SESSION['user'] = $login_id;
			    return "success";
				
			} else {
				return "failed";
			}
		} catch ( PDOException $e ) {
			print $e;
		}
	}
	
	function verifyUser($vfc,$user) {
		
		$vfc = addslashes ( trim ( $vfc ) );
		
		try {
			$dbutil = new DBUtil ();
			
			$conn = $dbutil->getPDOConnection ();
			
			$query = "SELECT count(*)  from user WHERE vfc = :vfc and user_no=:user_no";
				
			$selectStmt = $conn->prepare ( $query );
				
			$selectStmt->bindParam ( ":vfc", $vfc, PDO::PARAM_STR );
			$selectStmt->bindParam ( ':user_no', $user, PDO::PARAM_STR );
			$selectStmt->execute ();
				
			$number_of_rows = $selectStmt->fetchColumn ();
// 				echo $user;
// 				echo  $vfc
// 			$conn = null;
			$selectStmt = null;
				
			if ($number_of_rows == 1) {
				
				$status = "approved";
				//echo $status;
				
				$updateStmt = $conn->prepare ( "UPDATE `user` SET status=:status where user_no = :user_no" );
				$updateStmt->bindParam ( ":user_no", $user, PDO::PARAM_STR );
				$updateStmt->bindParam ( ':status', $status, PDO::PARAM_STR );
				$updateStmt->execute ();
					
				$updateStmt = null;
				$conn = null;
					
				return "success";
			}else{
				return "failed";
			}
			
		} catch ( PDOException $e ) {
			print $e;
		}
	}
	function getUserInfoByUserNo($userNo) {
		try {
		
			$dbutil = new DBUtil ();
			
			$conn = $dbutil->getPDOConnection ();
			
			$query = "select user_no, user_type , first_name , last_name , company_name , login_id , 
		registered_on , updated_on , address , country , state , city , pin , email , mobile , landline , isdeleted ,
		version , isactive , vfc ,img_dir,profile_img,login_id_encoded,confirmed_user,is_admin,view_permission,insert_permission,update_permission,delete_permission,mail_permission,designation,username from user WHERE user_no = :user_no";
			
			$selectStmt = $conn->prepare ( $query );
			//echo $query;
			$selectStmt->bindParam ( ':user_no', $userNo, PDO::PARAM_STR );
			$selectStmt->execute ();
			
			$userArr = array ();
			
			while ( $row = $selectStmt->fetch () ) {
				// $user = array();
				$user = array (
						"userNo" => $row ["user_no"],
						"userType" => $row ["user_type"],
						"firstName" => $row ["first_name"],
						"lastName" => $row ["last_name"],
						"companyName" => $row ["company_name"],
						"loginId" => $row ["login_id"],
						"regDate" => $row ["registered_on"],
						"updatedOn" => $row ["updated_on"],
						"addLine" => $row ["address"],
						"country" => $row ["country"],
						"state" => $row ["state"],
						"city" => $row ["city"],
						"pin" => $row ["pin"],
						"email" => $row ["email"],
						"mobile" => $row ["mobile"],
						"landline" => $row ["landline"],
						"isdeleted" => $row ["isdeleted"],
						"version" => $row ["version"],
						"isactive" => $row ["isactive"],
						"vfc" => $row ["vfc"],
						"imgDir" => $row ["img_dir"],
						"profilePic" => $row ["profile_img"],
						"login_id_encoded" => $row ["login_id_encoded"],
						"isconf" => $row ["confirmed_user"],
						"isAdmin" => $row ["is_admin"],
						"viewPermission" => $row ["view_permission"],
						"insertPermission" => $row ["insert_permission"],
						"updatePermission" => $row ["update_permission"],
						"deletePermission" => $row ["delete_permission"],
						"mailPermission" => $row ["mail_permission"],
						"designation" => $row ["designation"],
						"userName" => $row ["username"]
				);
				
				$userArr = $user;
			}
			
			$conn = null;
			$selectStmt = null;
			
			$userInfoArr = array (
					"userInfo" => $userArr,
					"message" => "success"
			);
			
			return $userInfoArr;
		} catch ( PDOException $e ) {
			$conn = null;
			$selectStmt = null;
			print $e->getMessage ();
			return null;
		}
	}
	
	function getDashboardInfoByUserNo($userNo, $isAdmin) {
		try {
		
			$totalRecords = "";
			$inProgressRecords = "";
			$openRecords = "";
			$expireInFifteenDays = "";
			$expiredInThirtyDays = "";
			$expiredInSixtyDays = "";
			$expiredInGSixtyDays = "";
			$expiredRecords = "";
			$closedRecords = "";
		
			$dbutil = new DBUtil ();
			$conn = $dbutil->getPDOConnection ();
			
			if ($isAdmin == "YES"){
				$query = "select count(*) from renewalservice";
			$selectStmt = $conn->prepare ( $query );
			$selectStmt->execute ();
			$totalRecords = $selectStmt->fetchColumn();
			$selectStmt = null;
			
			$dueFrom = 0;
			$dueTo = 15;
			$currentStatus1 = "CLOSE";
			$query = "select count(*) from renewalservice where not current_status = :currentStatus1 and datediff(expiry_date,CURDATE())  BETWEEN :dueFrom and :dueTo";
			$selectStmt = $conn->prepare ( $query );
			$selectStmt->bindParam ( ':currentStatus1', $currentStatus1, PDO::PARAM_STR);
			$selectStmt->bindParam ( ':dueFrom', $dueFrom, PDO::PARAM_STR);
			$selectStmt->bindParam ( ':dueTo', $dueTo, PDO::PARAM_STR );
			$selectStmt->execute ();
			$expireInFifteenDays = $selectStmt->fetchColumn();
			$selectStmt = null;
			
			$dueFrom = 15;
			$dueTo = 30;
			$currentStatus1 = "CLOSE";
			$query = "select count(*) from renewalservice where not current_status = :currentStatus1 and datediff(expiry_date,CURDATE())  BETWEEN :dueFrom and :dueTo";
			$selectStmt = $conn->prepare ( $query );
			$selectStmt->bindParam ( ':currentStatus1', $currentStatus1, PDO::PARAM_STR);
			$selectStmt->bindParam ( ':dueFrom', $dueFrom, PDO::PARAM_STR);
			$selectStmt->bindParam ( ':dueTo', $dueTo, PDO::PARAM_STR );
			$selectStmt->execute ();
			$expiredInThirtyDays = $selectStmt->fetchColumn();
			$selectStmt = null;
			
			$dueFrom = 30;
			$dueTo = 60;
			$currentStatus1 = "CLOSE";
			$query = "select count(*) from renewalservice where not current_status = :currentStatus1 and datediff(expiry_date,CURDATE())  BETWEEN :dueFrom and :dueTo";
			$selectStmt = $conn->prepare ( $query );
			$selectStmt->bindParam ( ':currentStatus1', $currentStatus1, PDO::PARAM_STR);
			$selectStmt->bindParam ( ':dueFrom', $dueFrom, PDO::PARAM_STR);
			$selectStmt->bindParam ( ':dueTo', $dueTo, PDO::PARAM_STR );
			$selectStmt->execute ();
			$expiredInSixtyDays = $selectStmt->fetchColumn();
			$selectStmt = null;
			
			$dueFrom = 60;
			$dueTo = 9999;
			$currentStatus1 = "CLOSE";
			$query = "select count(*) from renewalservice where not current_status = :currentStatus1 and datediff(expiry_date,CURDATE())  BETWEEN :dueFrom and :dueTo";
			$selectStmt = $conn->prepare ( $query );
			$selectStmt->bindParam ( ':currentStatus1', $currentStatus1, PDO::PARAM_STR);
			$selectStmt->bindParam ( ':dueFrom', $dueFrom, PDO::PARAM_STR);
			$selectStmt->bindParam ( ':dueTo', $dueTo, PDO::PARAM_STR );
			$selectStmt->execute ();
			$expiredInGSixtyDays = $selectStmt->fetchColumn();
			$selectStmt = null;
			
			$dueFrom = -999;
			$dueTo = 0;
			$currentStatus1 = "CLOSE";
			$query = "select count(*) from renewalservice where not current_status = :currentStatus1 and datediff(expiry_date,CURDATE())  BETWEEN :dueFrom and :dueTo";
			$selectStmt = $conn->prepare ( $query );
			$selectStmt->bindParam ( ':dueFrom', $dueFrom, PDO::PARAM_STR);
			$selectStmt->bindParam ( ':currentStatus1', $currentStatus1, PDO::PARAM_STR);
			$selectStmt->bindParam ( ':dueTo', $dueTo, PDO::PARAM_STR );
			$selectStmt->execute ();
			$expiredRecords = $selectStmt->fetchColumn();
			$selectStmt = null;
			
			$dueFrom = 0;
			$dueTo = 9999;
			$currentStatus = "IN PROGRESS";
			$query = "select count(*) from renewalservice where current_status = :currentStatus and datediff(expiry_date,CURDATE())  BETWEEN :dueFrom and :dueTo";
			$selectStmt = $conn->prepare ( $query );
			$selectStmt->bindParam ( ':currentStatus', $currentStatus, PDO::PARAM_STR );
			$selectStmt->bindParam ( ':dueFrom', $dueFrom, PDO::PARAM_STR);
			$selectStmt->bindParam ( ':dueTo', $dueTo, PDO::PARAM_STR);
			$selectStmt->execute ();
			$inProgressRecords = $selectStmt->fetchColumn();
			$selectStmt = null;
			
			$dueFrom = 0;
			$dueTo = 9999;
			$currentStatus = "OPEN";
			$query = "select count(*) from renewalservice where current_status = :currentStatus and datediff(expiry_date,CURDATE())  BETWEEN :dueFrom and :dueTo";
			$selectStmt = $conn->prepare ( $query );
			$selectStmt->bindParam ( ':currentStatus', $currentStatus, PDO::PARAM_STR );
			$selectStmt->bindParam ( ':dueFrom', $dueFrom, PDO::PARAM_STR);
			$selectStmt->bindParam ( ':dueTo', $dueTo, PDO::PARAM_STR);
			$selectStmt->execute ();
			$openRecords = $selectStmt->fetchColumn();
			$selectStmt = null;
			
			$currentStatus = "CLOSE";
			$query = "select count(*) from renewalservice where current_status = :currentStatus";
			$selectStmt = $conn->prepare ( $query );
			$selectStmt->bindParam ( ':currentStatus', $currentStatus, PDO::PARAM_STR );
			$selectStmt->execute ();
			$closedRecords = $selectStmt->fetchColumn();
			$selectStmt = null;
			
			}else {
				$query = "select count(*) from renewalservice where user = :user_no";
			$selectStmt = $conn->prepare ( $query );
			$selectStmt->bindParam ( ':user_no', $userNo, PDO::PARAM_STR );
			$selectStmt->execute ();
			$totalRecords = $selectStmt->fetchColumn();
			$selectStmt = null;
			
			$dueFrom = 0;
			$dueTo = 15;
			$currentStatus1 = "CLOSE";
			$query = "select count(*) from renewalservice where user = :user_no and not current_status = :currentStatus1 and datediff(expiry_date,CURDATE())  BETWEEN :dueFrom and :dueTo";
			$selectStmt = $conn->prepare ( $query );
			$selectStmt->bindParam ( ':user_no', $userNo, PDO::PARAM_STR );
			$selectStmt->bindParam ( ':currentStatus1', $currentStatus1, PDO::PARAM_STR);
			$selectStmt->bindParam ( ':dueFrom', $dueFrom, PDO::PARAM_STR);
			$selectStmt->bindParam ( ':dueTo', $dueTo, PDO::PARAM_STR );
			$selectStmt->execute ();
			$expireInFifteenDays = $selectStmt->fetchColumn();
			$selectStmt = null;
			
			$dueFrom = 15;
			$dueTo = 30;
			$currentStatus1 = "CLOSE";
			$query = "select count(*) from renewalservice where user = :user_no and not current_status = :currentStatus1 and datediff(expiry_date,CURDATE())  BETWEEN :dueFrom and :dueTo";
			$selectStmt = $conn->prepare ( $query );
			$selectStmt->bindParam ( ':user_no', $userNo, PDO::PARAM_STR );
			$selectStmt->bindParam ( ':currentStatus1', $currentStatus1, PDO::PARAM_STR);
			$selectStmt->bindParam ( ':dueFrom', $dueFrom, PDO::PARAM_STR);
			$selectStmt->bindParam ( ':dueTo', $dueTo, PDO::PARAM_STR );
			$selectStmt->execute ();
			$expiredInThirtyDays = $selectStmt->fetchColumn();
			$selectStmt = null;
			
			$dueFrom = 30;
			$dueTo = 60;
			$currentStatus1 = "CLOSE";
			$query = "select count(*) from renewalservice where user = :user_no and not current_status = :currentStatus1 and datediff(expiry_date,CURDATE())  BETWEEN :dueFrom and :dueTo";
			$selectStmt = $conn->prepare ( $query );
			$selectStmt->bindParam ( ':user_no', $userNo, PDO::PARAM_STR );
			$selectStmt->bindParam ( ':currentStatus1', $currentStatus1, PDO::PARAM_STR);
			$selectStmt->bindParam ( ':dueFrom', $dueFrom, PDO::PARAM_STR);
			$selectStmt->bindParam ( ':dueTo', $dueTo, PDO::PARAM_STR );
			$selectStmt->execute ();
			$expiredInSixtyDays = $selectStmt->fetchColumn();
			$selectStmt = null;
			
			$dueFrom = 60;
			$dueTo = 9999;
			$currentStatus1 = "CLOSE";
			$query = "select count(*) from renewalservice where user = :user_no and not current_status = :currentStatus1 and datediff(expiry_date,CURDATE())  BETWEEN :dueFrom and :dueTo";
			$selectStmt = $conn->prepare ( $query );
			$selectStmt->bindParam ( ':user_no', $userNo, PDO::PARAM_STR );
			$selectStmt->bindParam ( ':currentStatus1', $currentStatus1, PDO::PARAM_STR);
			$selectStmt->bindParam ( ':dueFrom', $dueFrom, PDO::PARAM_STR);
			$selectStmt->bindParam ( ':dueTo', $dueTo, PDO::PARAM_STR );
			$selectStmt->execute ();
			$expiredInGSixtyDays = $selectStmt->fetchColumn();
			$selectStmt = null;
			
			$dueFrom = -999;
			$dueTo = 0;
			$currentStatus1 = "CLOSE";
			$query = "select count(*) from renewalservice where user = :user_no and not current_status = :currentStatus1 and datediff(expiry_date,CURDATE())  BETWEEN :dueFrom and :dueTo";
			$selectStmt = $conn->prepare ( $query );
			$selectStmt->bindParam ( ':user_no', $userNo, PDO::PARAM_STR );
			$selectStmt->bindParam ( ':currentStatus1', $currentStatus1, PDO::PARAM_STR);
			$selectStmt->bindParam ( ':dueFrom', $dueFrom, PDO::PARAM_STR);
			$selectStmt->bindParam ( ':dueTo', $dueTo, PDO::PARAM_STR );
			$selectStmt->execute ();
			$expiredRecords = $selectStmt->fetchColumn();
			$selectStmt = null;
			
			$dueFrom = 0;
			$dueTo = 9999;
			$currentStatus = "IN PROGRESS";
			$query = "select count(*) from renewalservice where user = :user_no and current_status = :currentStatus and datediff(expiry_date,CURDATE())  BETWEEN :dueFrom and :dueTo";
			$selectStmt = $conn->prepare ( $query );
			$selectStmt->bindParam ( ':user_no', $userNo, PDO::PARAM_STR );
			$selectStmt->bindParam ( ':currentStatus', $currentStatus, PDO::PARAM_STR );
			$selectStmt->bindParam ( ':dueFrom', $dueFrom, PDO::PARAM_STR);
			$selectStmt->bindParam ( ':dueTo', $dueTo, PDO::PARAM_STR);
			$selectStmt->execute ();
			$inProgressRecords = $selectStmt->fetchColumn();
			$selectStmt = null;
			
			$dueFrom = 0;
			$dueTo = 9999;
			$currentStatus = "OPEN";
			$query = "select count(*) from renewalservice where user = :user_no and current_status = :currentStatus and datediff(expiry_date,CURDATE())  BETWEEN :dueFrom and :dueTo";
			$selectStmt = $conn->prepare ( $query );
			$selectStmt->bindParam ( ':user_no', $userNo, PDO::PARAM_STR );
			$selectStmt->bindParam ( ':currentStatus', $currentStatus, PDO::PARAM_STR );
			$selectStmt->bindParam ( ':dueFrom', $dueFrom, PDO::PARAM_STR);
			$selectStmt->bindParam ( ':dueTo', $dueTo, PDO::PARAM_STR);
			$selectStmt->execute ();
			$openRecords = $selectStmt->fetchColumn();
			$selectStmt = null;
			
			$currentStatus = "CLOSE";
			$query = "select count(*) from renewalservice where user = :user_no and current_status = :currentStatus";
			$selectStmt = $conn->prepare ( $query );
			$selectStmt->bindParam ( ':user_no', $userNo, PDO::PARAM_STR );
			$selectStmt->bindParam ( ':currentStatus', $currentStatus, PDO::PARAM_STR );
			$selectStmt->execute ();
			$closedRecords = $selectStmt->fetchColumn();
			$selectStmt = null;
			}
			
			
			
			$userInfoArr = array (
					"totalRecords" => $totalRecords,
					"inProgressRecords" => $inProgressRecords,
					"openRecords" => $openRecords,
					"expireInFifteen" => $expireInFifteenDays,
					"expireInThirty" => $expiredInThirtyDays,
					"expireInSixty" => $expiredInSixtyDays,
					"expireInGSixty" => $expiredInGSixtyDays,
					"expiredRecords" => $expiredRecords,
					"closedRecords" => $closedRecords,
					"message" => "success"
			);
			
			return $userInfoArr;
		} catch ( PDOException $e ) {
			$conn = null;
			$selectStmt = null;
			print $e->getMessage ();
			return null;
		}
	}
	
	function getDashboardUsersInfoByUserNo($userNo) {
		try {
		
			$userName = "";
			$totalRecords = "";
			$inProgressRecords = "";
			$openRecords = "";
			$expireInFifteenDays = "";
			$expiredRecords = "";
			$closedRecords = "";
			$dashUserArr = array();
			$count = 0;
			$isAdmin = "";
		
			$dbutil = new DBUtil ();
			$conn = $dbutil->getPDOConnection ();
			
			$selectStmt1 = $conn->prepare("select * from user where user_no = :user_no");
			$selectStmt1->bindParam ( ':user_no', $userNo, PDO::PARAM_STR);
			$selectStmt1->execute ();
			
			while ($row = $selectStmt1->fetch()){
				$isAdmin = $row['is_admin'];
			}
			$selectStmt1 = null;
			
			if ($isAdmin == "NO"){
				return;
			}
			
			$query = "select * from user";
			$selectStmt1 = $conn->prepare ($query);
			$selectStmt1->execute();
			
			while ($row = $selectStmt1->fetch()){
	
				$userNo = $row['user_no'];
				$userName = $row['username'];
				
				$query = "select count(*) from renewalservice where user = :user_no";
				$selectStmt = $conn->prepare ( $query );
				$selectStmt->bindParam ( ':user_no', $userNo, PDO::PARAM_STR );
				$selectStmt->execute ();
				$totalRecords = $selectStmt->fetchColumn();
				$selectStmt = null;
			
				$dueFrom = 0;
				$dueTo = 15;
				$currentStatus1 = "CLOSE";
 				$query = "select count(*) from renewalservice where user = :user_no and not current_status = :currentStatus1 and datediff(expiry_date,CURDATE())  BETWEEN :dueFrom and :dueTo";
				$selectStmt = $conn->prepare ( $query );
				$selectStmt->bindParam ( ':user_no', $userNo, PDO::PARAM_STR );
				$selectStmt->bindParam ( ':currentStatus1', $currentStatus1, PDO::PARAM_STR);
				$selectStmt->bindParam ( ':dueFrom', $dueFrom, PDO::PARAM_STR);
				$selectStmt->bindParam ( ':dueTo', $dueTo, PDO::PARAM_STR );
				$selectStmt->execute ();
				$expireInFifteenDays = $selectStmt->fetchColumn();
				$selectStmt = null;
			
				$dueFrom = -999;
				$dueTo = 0;
				$currentStatus1 = "CLOSE";
				$query = "select count(*) from renewalservice where user = :user_no and not current_status = :currentStatus1 and datediff(expiry_date,CURDATE())  BETWEEN :dueFrom and :dueTo";
				$selectStmt = $conn->prepare ( $query );
				$selectStmt->bindParam ( ':user_no', $userNo, PDO::PARAM_STR );
				$selectStmt->bindParam ( ':currentStatus1', $currentStatus1, PDO::PARAM_STR);
				$selectStmt->bindParam ( ':dueFrom', $dueFrom, PDO::PARAM_STR);
				$selectStmt->bindParam ( ':dueTo', $dueTo, PDO::PARAM_STR );
				$selectStmt->execute ();
				$expiredRecords = $selectStmt->fetchColumn();
				$selectStmt = null;
			
				$dueFrom = 0;
				$dueTo = 9999;
				$currentStatus = "IN PROGRESS";
				$query = "select count(*) from renewalservice where user = :user_no and current_status = :currentStatus and datediff(expiry_date,CURDATE())  BETWEEN :dueFrom and :dueTo";
				$selectStmt = $conn->prepare ( $query );
				$selectStmt->bindParam ( ':user_no', $userNo, PDO::PARAM_STR );
				$selectStmt->bindParam ( ':currentStatus', $currentStatus, PDO::PARAM_STR );
				$selectStmt->bindParam ( ':dueFrom', $dueFrom, PDO::PARAM_STR);
				$selectStmt->bindParam ( ':dueTo', $dueTo, PDO::PARAM_STR);
				$selectStmt->execute ();
				$inProgressRecords = $selectStmt->fetchColumn();
				$selectStmt = null;
			
				$dueFrom = 0;
				$dueTo = 9999;
				$currentStatus = "OPEN";
				$query = "select count(*) from renewalservice where user = :user_no and current_status = :currentStatus and datediff(expiry_date,CURDATE())  BETWEEN :dueFrom and :dueTo";
				$selectStmt = $conn->prepare ( $query );
				$selectStmt->bindParam ( ':user_no', $userNo, PDO::PARAM_STR );
				$selectStmt->bindParam ( ':currentStatus', $currentStatus, PDO::PARAM_STR );
				$selectStmt->bindParam ( ':dueFrom', $dueFrom, PDO::PARAM_STR);
				$selectStmt->bindParam ( ':dueTo', $dueTo, PDO::PARAM_STR);
				$selectStmt->execute ();
				$openRecords = $selectStmt->fetchColumn();
				$selectStmt = null;
				
				$currentStatus = "CLOSE";
				$query = "select count(*) from renewalservice where user = :user_no and current_status = :currentStatus";
				$selectStmt = $conn->prepare ( $query );
				$selectStmt->bindParam ( ':user_no', $userNo, PDO::PARAM_STR );
				$selectStmt->bindParam ( ':currentStatus', $currentStatus, PDO::PARAM_STR );
				$selectStmt->execute ();
				$closedRecords = $selectStmt->fetchColumn();
				$selectStmt = null;
			
				$userInfoArr = array (
						"userName" => $userName,
						"totalRecords" => $totalRecords,
						"inProgressRecords" => $inProgressRecords,
						"openRecords" => $openRecords,
						"closedRecords" => $closedRecords,
						"expireInFifteen" => $expireInFifteenDays,
						"expiredRecords" => $expiredRecords,
				);
				
				$dashUserArr[$count] = $userInfoArr;
				$count = $count + 1;
			}
			
			$arrToSend = array(
				"users" => $dashUserArr,
				"message" => "success"
			);
			
			return $arrToSend;
		} catch ( PDOException $e ) {
			$conn = null;
			$selectStmt = null;
			print $e->getMessage ();
			return null;
		}
	}
	
	function getUserRecordsInfo($userNo) {
		try {
		
			$dbutil = new DBUtil ();
			
			$conn = $dbutil->getPDOConnection ();
			
			$query = "select datediff(expiry_date,CURDATE()) as
					remainingdays from renewalservice WHERE user = :user_no";
			
			$selectStmt = $conn->prepare ( $query );
			//echo $query;
			$selectStmt->bindParam ( ':user_no', $userNo, PDO::PARAM_STR );
			$selectStmt->execute ();
			
			$recordsQty = 0;
			$i = 0;
			while ( $row = $selectStmt->fetch () ) {
				// $user = array();
				$userRecordArr[$i] = $row['remainingdays'];
				$recordsQty++;
				$i++;
			}
			$remainedDays =  max($userRecordArr);
			
			$bindedArr = array (
			        "remainedDays" => $remainedDays,
			        "totalRecords" => $recordsQty
			    );
			
			return $bindedArr;
		} catch ( PDOException $e ) {
			$conn = null;
			$selectStmt = null;
			print $e->getMessage ();
			return "failed";
		}
	}
/*
	function checkAllotment($userNo,$days) {
		try {
			$dbutil = new DBUtil ();
			$conn = $dbutil->getPDOConnection ();
			$alloted = 0;
			$userType = "";
			
			$query = "select user_type from user_payment_status WHERE user = :user_no";
			$selectStmt = $conn->prepare ( $query );
			$selectStmt->bindParam ( ':user_no', $userNo, PDO::PARAM_STR );
			$selectStmt->execute ();
			
			while($row = $selectStmt->fetch())
			{
			    $userType = $row ['user_type'];
			}
			
			if($userType == "P")
			{
			    $selectStmt = null;
			    $query = "select id , remaining_days from user_records_info WHERE user_no = :user_no AND alloted = :alloted";
			
			    $selectStmt = $conn->prepare ( $query );
			    //echo $query;
			    $selectStmt->bindParam ( ':user_no', $userNo, PDO::PARAM_STR );
			    $selectStmt->bindParam ( ':alloted', $alloted, PDO::PARAM_STR );
			    $selectStmt->execute ();
			
			    while ( $row = $selectStmt->fetch () ) {
			        $abc = $row ['remaining_days'];
			        if($days <=  $abc)
			        {
			            echo "YES";
			            exit;
			        }
			    }
			    
			    echo "NO";
			    exit;
			}
			echo "YES";
		} catch ( PDOException $e ) {
			$conn = null;
			$selectStmt = null;
			print $e->getMessage ();
			return "failed";
		}
	}    */
	
	function getUserByLoginId($login_id) {
		$login_id = addslashes ( trim ( $login_id ) );
		try {
		
			
			$dbutil = new DBUtil ();
			
			$conn = $dbutil->getPDOConnection ();
			
			$query = "select user_no, user_type , first_name , last_name, company_name , login_id ,
		registered_on , updated_on , address , country , state , city , pin , email , mobile , landline , isdeleted ,
		version , isactive , vfc ,img_dir,status,profile_img,login_id_encoded,confirmed_user from user WHERE login_id = :login_id";
			
			$selectStmt = $conn->prepare ( $query );
			
			$selectStmt->bindParam ( ':login_id', $login_id, PDO::PARAM_STR );
			$selectStmt->execute ();
			
			$userArr = array ();
			
			while ( $row = $selectStmt->fetch () ) {
				// $user = array();
				$company_name = $row ["company_name"];
				
				$converter = new Encryption();
				$company_name = $converter->encode($company_name);
				
				$user = array (
						"userNo" => $row ["user_no"],
						"userType" => $row ["user_type"],
						"name" => $row ["first_name"],
						"surname" => $row ["last_name"],
						"companyName" => $company_name,
						"loginId" => $row ["login_id"],
						"regDate" => $row ["registered_on"],
						"updatedOn" => $row ["updated_on"],
						"addLine" => $row ["address"],
						"country" => $row ["country"],
						"state" => $row ["state"],
						"city" => $row ["city"],
						"pin" => $row ["pin"],
						"email" => $row ["email"],
						"mobile" => $row ["mobile"],
						"landline" => $row ["landline"],
						"isdeleted" => $row ["isdeleted"],
						"version" => $row ["version"],
						"isactive" => $row ["isactive"],
						"vfc" => $row ["vfc"],
						"imgDir" => $row ["img_dir"],
						"status" => $row ["status"] ,
						"profilePic" => $row ["profile_img"],
						"login_id_encoded" => $row ["login_id_encoded"],
						"isconfirmed" => $row ["confirmed_user"]
				);
				$userArr = $user;
			}
			
			$conn = null;
			$selectStmt = null;
			
			return $userArr;
		} catch ( PDOException $e ) {
			$conn = null;
			$selectStmt = null;
			print $e->getMessage ();
			return null;
		}
	}
	
function getUserByUserName($userName) {
		$userName = addslashes ( trim ( $userName) );
		try {
		
			$dbutil = new DBUtil ();
			
			$conn = $dbutil->getPDOConnection ();
			
			$query = "select user_no, user_type , first_name , last_name, company_name , login_id ,
		registered_on , updated_on , address , country , state , city , pin , email , mobile , landline , isdeleted ,
		version , isactive , vfc ,img_dir,status,profile_img,login_id_encoded,confirmed_user,is_admin,view_permission,insert_permission,update_permission,delete_permission,mail_permission,designation,username from user WHERE username = :username";
			
			$selectStmt = $conn->prepare ( $query );
			
			$selectStmt->bindParam ( ':username', $userName, PDO::PARAM_STR );
			$selectStmt->execute ();
			
			$userArr = array ();
			
			while ( $row = $selectStmt->fetch () ) {
				// $user = array();
				$company_name = $row ["company_name"];
				
				$converter = new Encryption();
				$company_name = $converter->encode($company_name);
				
				$user = array (
						"userNo" => $row ["user_no"],
						"userType" => $row ["user_type"],
						"name" => $row ["first_name"],
						"surname" => $row ["last_name"],
						"companyName" => $company_name,
						"loginId" => $row ["login_id"],
						"regDate" => $row ["registered_on"],
						"updatedOn" => $row ["updated_on"],
						"addLine" => $row ["address"],
						"country" => $row ["country"],
						"state" => $row ["state"],
						"city" => $row ["city"],
						"pin" => $row ["pin"],
						"email" => $row ["email"],
						"mobile" => $row ["mobile"],
						"landline" => $row ["landline"],
						"isdeleted" => $row ["isdeleted"],
						"version" => $row ["version"],
						"isactive" => $row ["isactive"],
						"vfc" => $row ["vfc"],
						"imgDir" => $row ["img_dir"],
						"status" => $row ["status"] ,
						"profilePic" => $row ["profile_img"],
						"login_id_encoded" => $row ["login_id_encoded"],
						"isconfirmed" => $row ["confirmed_user"],
						"isAdmin" => $row ["is_admin"],
						"viewPermission" => $row["view_permission"],
						"insertPermission" => $row["insert_permission"],
						"updatePermission" => $row["update_permission"],
						"deletePermission" => $row["delete_permission"],
						"mailPermission" => $row["mail_permission"],
						"designation" => $row["designation"],
						"userName" => $row["username"]
				);
				$userArr = $user;
			}
			
			$conn = null;
			$selectStmt = null;
			
			return $userArr;
		} catch ( PDOException $e ) {
			$conn = null;
			$selectStmt = null;
			print $e->getMessage ();
			return null;
		}
	}
	function getSupportUserByEmailId($email_id) {
		try {
			$dbutil = new DBUtil ();
			
			$conn = $dbutil->getPDOConnection ();
			
			$query = "select * from support_users WHERE user_email = :email_id";
			
			$selectStmt = $conn->prepare ( $query );
			
			$selectStmt->bindParam ( ':email_id', $email_id, PDO::PARAM_STR );
			$selectStmt->execute ();
			
			$userArr = array ();
			
			while ( $row = $selectStmt->fetch () ) {
				// $user = array();
				
				$user = array (
						"user_id" => $row ["user_id"],
						"user_email" => $row ["user_email"],
						"user_corporation" => $row ["user_corporation"],
						"registered_date" => $row ["registered_on"]
						
				);
				
				$userArr = $user;
			}
			
			$conn = null;
			$selectStmt = null;
			
			return $userArr;
		} catch ( PDOException $e ) {
			$conn = null;
			$selectStmt = null;
			print $e->getMessage ();
			return null;
		}
	}
	function getVerificationCode() {
		// insert and send to email
	}
	function getLoginIdByMobile() {
		// Send to email
	}
	function getLoginIdByEmail() {
		// Send to email
	}
	function updateVerificationCode() {
	}
	function checkVerificationAndActiveUser() {
	}
	function clean($string) {
		// echo "11";
		$string = str_replace ( ' ', '-', $string ); // Replaces all spaces with hyphens.
		                                             // echo "12";
		return preg_replace ( '/[^A-Za-z0-9\-]/', '', $string ); // Removes special chars.
	}
	function addRenewalServices($renewalServices) {
		$size = sizeof ( $renewalServices );
		
		for($i = 0; $i < $size; $i ++) {
			$this->addRenewalService ( $renewalService );
		}
	}
	function addRenewalService($renewalService) {
		if (isset ( $_FILESArr ['file'] )) {
			
			// echo "33";
			$errors = array ();
			// $description = $_FILESArr['description'];
			$file_name = $_FILESArr ['file'] ['name'];
			// echo $userNo.$file_name;
			
			// $userNo.$file_name
			
			if ($this->isFileExist ( $userNo . $file_name )) {
				return "exist";
			}
			
			$file_size = $_FILESArr ['file'] ['size'];
			$file_tmp = $_FILESArr ['file'] ['tmp_name'];
			$file_type = $_FILESArr ['file'] ['type'];
			
			$fileVar = explode ( '.', $_FILESArr ['file'] ['name'] );
			
			$file_ext = strtolower ( end ( $fileVar ) );
			// echo "22";
			$expensions = array (
					"jpeg",
					"jpg",
					"png" 
			);
			
			if (in_array ( $file_ext, $expensions ) === false) {
				$errors [] = "extension not allowed, please choose a JPEG or PNG file.";
			} // echo "23";
			
			if ($file_size > 2097152) {
				$errors [] = 'File size must be excately 2 MB';
			}
			
			if (empty ( $errors ) == true) {
				// echo "uploads/".$imgDir."/".$file_name;
				date_default_timezone_set ( 'UTC' );
				// date("Y-m-d")
				$dirPath = "uploads/" . $imgDir . "/" . date ( "Y-m-d" );
				
				if (! file_exists ( $dirPath )) {
					mkdir ( $dirPath, 0777, true );
				}
				
				if (file_exists ( $dirPath . "/" . $file_name )) {
					return "exist";
				}
				
				$status = $this->updateFileInDB ( $file_name, $dirPath, $userNo, $description );
				
				if ($status == "success") {
					move_uploaded_file ( $file_tmp, $dirPath . "/" . $file_name );
					
					return "success";
				} else {
					return "failed";
				}
				
				// return "Success";
				// echo "<img src='uploads/.$file_name'>";
			} else {
				print_r ( $errors );
			}
		}
	}
	
	function modifyPassword($loginId,$userPassword){
		try {
			
			$loginId = addslashes ( trim ( $loginId ) );
			$userPassword = addslashes ( trim ( $userPassword ) );
			
			$dbutil = new DBUtil ();
			
			$conn = $dbutil->getPDOConnection ();
			
			$updateStmt = $conn->prepare ( "UPDATE `user` SET password=:password where login_id = :login_id" );
			$updateStmt->bindParam ( ":login_id", $loginId, PDO::PARAM_STR );
			$updateStmt->bindParam ( ':password', $userPassword, PDO::PARAM_STR );
			$updateStmt->execute ();
			
			$updateStmt = null;
			$conn = null;
			
			return "success";
			
		} catch ( PDOException $e ) {
			print $e;
			return "failed";
		}
	}
	
	function sendPasswordToUser($loginId){
		try {
		    
			$loginId = addslashes ( trim ( $loginId ) );
			
		    $dbutil = new DBUtil ();
			
			$conn = $dbutil->getPDOConnection ();
			
			$selectStmt = $conn->prepare ( "select COUNT(*) from user where login_id = :login_id" );
			$selectStmt->bindParam ( ":login_id" , $loginid , PDO::PARAM_STR);
			$selectStmt->execute();
			
			if ( $selectStmt->fetchColumn() < 1)
			{
			    return "NFOUND";
			    exit;
			}
			
			$userPassword_1 = mt_rand();
			$userPassword_2 = $userPassword_1;
			
			$userPassword = $userPassword_1;
			
			$updateStmt = $conn->prepare ( "UPDATE `user` SET password=:password where login_id = :login_id" );
			$updateStmt->bindParam ( ":login_id", $loginId, PDO::PARAM_STR );
			$updateStmt->bindParam ( ':password', $userPassword, PDO::PARAM_STR );
			$updateStmt->execute ();
			
			$updateStmt = null;
			$conn = null;
			
			$contactService = new ContactService();
			$msg = $contactService -> sendEmail_ForgotPassword($loginId,$userPassword_2);
			
			return $msg;
			
		} catch ( PDOException $e ) {
			print $e;
			return "failed";
		}
	}
	
	function getEmployeeList($companyid){
		$companyid = addslashes ( trim ( $companyid ) );
		
// 		$converter = new Encryption();
// 		$companyid = $converter->decode($companyid);
		
		try {
			$dbutil = new DBUtil ();
				
			$conn = $dbutil->getPDOConnection ();
				
			$query = "select user_no, user_type , first_name , company_name , login_id ,
		registered_on , updated_on , address , country , state , city , pin , email , mobile , landline , isdeleted ,
		version , isactive , vfc ,img_dir,status,profile_img from user WHERE company_name = :company_id";

			$selectStmt = $conn->prepare ( $query );
				
			$selectStmt->bindParam ( ':company_id', $companyid, PDO::PARAM_STR );
			
			$selectStmt->execute ();
				
			$userArr = array ();
			$count = 0;
			
			while ( $row = $selectStmt->fetch () ) {
				// $user = array();
				$user = array (
						"userNo" => $row ["user_no"],
						"userType" => $row ["user_type"],
						"name" => $row ["first_name"],
						"companyName" => $row ["company_name"],
						"loginId" => $row ["login_id"],
						"regDate" => $row ["registered_on"],
						"updatedOn" => $row ["updated_on"],
						"addLine" => $row ["address"],
						"country" => $row ["country"],
						"state" => $row ["state"],
						"city" => $row ["city"],
						"pin" => $row ["pin"],
						"email" => $row ["email"],
						"mobile" => $row ["mobile"],
						"landline" => $row ["landline"],
						"isdeleted" => $row ["isdeleted"],
						"version" => $row ["version"],
						"isactive" => $row ["isactive"],
						"vfc" => $row ["vfc"],
						"imgDir" => $row ["img_dir"],
						"status" => $row ["status"] ,
						"profilePic" => $row ["profile_img"]
				);
		
				$userArr[$count++] = $user;
			}
				
			$conn = null;
			$selectStmt = null;
				
			$userArrReturn = array (
					"employees" =>$userArr,
					"message" =>"success"
					);
					
			return $userArrReturn;
		} catch ( PDOException $e ) {
			$conn = null;
			$selectStmt = null;
			print $e->getMessage ();
			return null;
		}
	}
	
	function getCompanyInfo($companyno){
		$companyno = addslashes ( trim ( $companyno ) );
		
		$converter = new Encryption();
		$companyno = $converter->decode($companyno);
		
		//echo "//Ecr::".$companyno;
		return $this->getUserInfoByUserNo($companyno);
	}
	
	function getAllUserList(){
		
		try {
		
			
			$dbutil = new DBUtil ();
	
			$conn = $dbutil->getPDOConnection ();
	
			$query = "select   first_name ,registered_on  , address , country , state ,
			city , pin , email , mobile , landline , user_no , confirmed_user from user";
	
			$selectStmt = $conn->prepare ( $query );
	
			$selectStmt->execute ();
	
			$userArr = array ();
			$count = 0;
				
			while ( $row = $selectStmt->fetch () ) {
				
				$user = array (
						"name" => $row ["first_name"],
						"regDate" => $row ["registered_on"],
						"addLine" => $row ["address"],
						"country" => $row ["country"],
						"state" => $row ["state"],
						"city" => $row ["city"],
						"pin" => $row ["pin"],
						"email" => $row ["email"],
						"mobile" => $row ["mobile"],
						"landline" => $row ["landline"],
						"userNo" => $row ["user_no"],
						"confirmed_user" => $row ["confirmed_user"]
				);
	
				$userArr[$count++] = $user;
			}
	
			$conn = null;
			$selectStmt = null;
	
			$userArrReturn = array (
					"users" =>$userArr,
					"message" =>"success"
			);
				
			return $userArrReturn;
		} catch ( PDOException $e ) {
			$conn = null;
			$selectStmt = null;
			print $e->getMessage ();
			return null;
		}
	}
	
	function getAllPartnerList(){
		
		try {
		
		
			$dbutil = new DBUtil ();
	
			$conn = $dbutil->getPDOConnection ();
	
			$query = "select vendore_no , gst_no , vendore_firstName , vendore_lastName , company_name , company_website , vendore_email ,
			            vendore_mobile , updated_on , payment , vendore_address , vendore_city , vendore_state , vendore_country from vendore";
	
			$selectStmt = $conn->prepare ( $query );
	
			$selectStmt->execute ();
	
			$userArr = array ();
			$count = 0;
				
			while ( $row = $selectStmt->fetch () ) {
				
				$user = array (
				        "vendorNo" => $row ["vendore_no"],
				        "gstNo" => $row ["gst_no"],
						"firstName" => $row ["vendore_firstName"],
						"lastName" => $row ["vendore_lastName"],
						"companyName" => $row ["company_name"],
						"companyWebsite" => $row ["company_website"],
						"vendorEmail" => $row ["vendore_email"],
						"vendorMobile" => $row ["vendore_mobile"],
						"updatedOn" => $row ["updated_on"],
						"payment" => $row ["payment"],
						"vendorAddress" => $row ["vendore_address"],
						"vendorCity" => $row ["vendore_city"],
						"vendorState" => $row ["vendore_state"],
						"vendorCountry" => $row ["vendore_country"]
				);
	
				$userArr[$count++] = $user;
			}
	
			$conn = null;
			$selectStmt = null;
	
			$userArrReturn = array (
					"users" =>$userArr,
					"message" =>"success"
			);
				
			return $userArrReturn;
		} catch ( PDOException $e ) {
			$conn = null;
			$selectStmt = null;
			print $e->getMessage ();
			return null;
		}
	}
	
/*	function getVendoreInfo($mainCat , $subCat , $userNo){
		
		try {
			$dbutil = new DBUtil ();
	
			$conn = $dbutil->getPDOConnection ();
			
			$selectStmt = $conn->prepare ( "select pin from user where user_no=:userNo" );
			$selectStmt->bindParam ( ':userNo' , $userNo , PDO::PARAM_STR);
			$selectStmt->execute ();
			
			while($row = $selectStmt->fetch())
			{
			    $user_zip_code = $row ['pin'];
			}

			$query = "select vendore_no from vendore_services where vendore_mainService=:mainCat and vendore_subService=:subCat and zip_code=:zipCode";
			$selectStmt = $conn->prepare ( $query );
			$selectStmt->bindParam ( ':mainCat' , $mainCat , PDO::PARAM_STR);
			$selectStmt->bindParam ( ':subCat' , $subCat , PDO::PARAM_STR);
			$selectStmt->bindParam ( ':zipCode' , $user_zip_code , PDO::PARAM_STR);
	
			$selectStmt->execute ();
			
			while($row = $selectStmt->fetch())
			{
			    $vendore_no = $row ['vendore_no'];
			}
			
	        $query = "select vendore_firstName , vendore_lastName , company_name , vendore_email , vendore_mobile from vendore where vendore_no=:vendoreNo";
			$selectStmt = $conn->prepare ( $query );
			$selectStmt->bindParam ( ':vendoreNo' , $vendore_no , PDO::PARAM_STR);     
	        $selectStmt->execute();    
				
			
			$count = 0;	
			while ( $row = $selectStmt->fetch () ) {
				$firstName = $row ['vendore_firstName'];
				$lastName = $row ['vendore_lastName'];
				$name = $firstName . " " . $lastName;
				$company = $row ['company_name'];
				$email = $row ['vendore_email'];
				$mobile = $row ['vendore_mobile'];
				$count++;
			}
	
	        if($name == "" )
	        {
	            $vendoreArr = array (
					"message" =>"not found"
			    );
	        }
	        else 
	        {
			    $vendoreArr = array (
					"name" =>$name,
					"company"=>$company,
					"email"=>$email,
					"mobile"=>$mobile,
					"message" =>"success"
			    );
	        }
			
			return $vendoreArr;
		} catch ( PDOException $e ) {
			$conn = null;
			$selectStmt = null;
			print $e->getMessage ();
			return null;
		}
	} */
	
	function getVendoreInfo($mainCat , $subCat , $userNo){
		
		try {
			$dbutil = new DBUtil ();
	
			$conn = $dbutil->getPDOConnection ();
			
			$selectStmt = $conn->prepare ( "select pin from user where user_no=:userNo" );
			$selectStmt->bindParam ( ':userNo' , $userNo , PDO::PARAM_STR);
			$selectStmt->execute ();
			
			while($row = $selectStmt->fetch())
			{
			    $user_zip_code = $row ['pin'];
			}

			$query = "select vendore_no from vendore_services where vendore_mainService=:mainCat and vendore_subService=:subCat and zip_code=:zipCode";
			$selectStmt = $conn->prepare ( $query );
			$selectStmt->bindParam ( ':mainCat' , $mainCat , PDO::PARAM_STR);
			$selectStmt->bindParam ( ':subCat' , $subCat , PDO::PARAM_STR);
			$selectStmt->bindParam ( ':zipCode' , $user_zip_code , PDO::PARAM_STR);
			$selectStmt->execute ();
			
			$noOfRows = $selectStmt->rowCount();
			if($noOfRows <= 0)
			{
			    $finalArr = array (
			        "message"=>"not found"
			    );
			    return $finalArr;
			    exit;
			}
			
			$vendore_nos = array();
			$count = 0;
			while($row = $selectStmt->fetch())
			{
			    $vendore_nos[$count] = $row ['vendore_no'];
			    $count++;
			}
			
			$noOfVendores = $count;
			$allVendoreInfo = array ();
			$i = 0;
			for($count = 0; $count < $noOfVendores; $count++ )
			{
	            $query = "select vendore_firstName , vendore_lastName , company_name , company_website , vendore_email , vendore_mobile from vendore where vendore_no=:vendoreNo";
			    $selectStmt = $conn->prepare ( $query );
			    $selectStmt->bindParam ( ':vendoreNo' , $vendore_nos[$count] , PDO::PARAM_STR);     
	            $selectStmt->execute();
	            
			    while ( $row = $selectStmt->fetch () ) {
			        $name = $row ['vendore_firstName'] . " " . $row ['vendore_lastName'];
			        $company = $row ['company_name'];
				    $vendoreArr = array (
				            "name"=>$name,
				            "company"=>$row ['company_name'],
				            "email"=>$row ['vendore_email'],
				            "mobile"=>$row ['vendore_mobile'],
				            "website"=>$row ['company_website'],
				            "vno"=>$vendore_nos[$count]
				        );
			    }
			    $allVendoreInfo[$i] = $vendoreArr;
			    $i++;
			}
			$count = sizeof($allVendoreInfo);
			$finalArr = array (
			        "vendoreInfo"=>$allVendoreInfo,
			        "count"=>$count,
			        "zipCode"=>$user_zip_code,
			        "message"=>"success"
			    );
			return $finalArr;
		} catch ( PDOException $e ) {
			$conn = null;
			$selectStmt = null;
			print $e->getMessage ();
			return null;
		}
	}
	
	function mailMe ($vendoreNo , $userEmail)
	{
	    $dbutil = new DBUtil ();
		$conn = $dbutil->getPDOConnection ();
			
		$query = "select vendore_firstName , vendore_lastName , company_name , company_website , vendore_email , vendore_mobile from vendore where vendore_no=:vendoreNo";
		$selectStmt = $conn->prepare ( $query );
		$selectStmt->bindParam ( ':vendoreNo' , $vendoreNo , PDO::PARAM_STR);     
	    $selectStmt->execute();
	            
		while ( $row = $selectStmt->fetch () ) {
			$v_name = $row ['vendore_firstName'] . " " . $row ['vendore_lastName'];
			$v_company = $row ['company_name'];
			$v_email = $row ['vendore_email'];
			$v_mobile = $row ['vendore_mobile'];
			$v_website = $row ['company_website'];
	    }
	    
	    $contactService = new ContactService();
		$msg = $contactService->mailMe($userEmail, $v_name, $v_company, $v_email,$v_mobile,$v_website);
		return $msg;
	}
	
	function getPaymentStatusForUser($user){

		try {
			$dbutil = new DBUtil ();
		
			$conn = $dbutil->getPDOConnection ();
			
			$query = "select updated_on, no_of_months, user_type from user_payment_status where user=:user";
			
			$status = "";
		
			$selectStmt = $conn->prepare ( $query );
			$selectStmt->bindParam ( ':user', $user, PDO::PARAM_INT );
				
			$selectStmt->execute ();
		
			while ( $row = $selectStmt->fetch () ) {
				$updatedOn = $row ["updated_on"];
				$noOfMonths = $row ["no_of_months"];
				$userType = $row ["user_type"];
				
				//$datearr=date_parse_from_format("l js \of F Y h:i:s A", $updatedOn);
				$datearr = explode(" ", $updatedOn);
				$period = $this->getRemainingPeriod($datearr);
				
				if($userType == "P")
				{
				    $totalDays = $noOfMonths * 30;
				    $remainedDays = $totalDays - $period;
				    
				    if($remainedDays <= 14)
				    {
				        $status = "paidUserNearToExpire";
				    }
				    else if($remainedDays <= 0)
				    {
				        $status = "paidUserExpired";
				    }
				}
				else if($userType == "T")
				{
				    if($period > 14)
				    {
					    $status = "freeUserExpired";
				    }
				    else if ($period > 10 && $period < 30)
				    {
					    $status = "freeUserNearToExpire";
				    }
				}
			}
		
			$conn = null;
			$selectStmt = null;
		
			return $status;
		} catch ( PDOException $e ) {
			$conn = null;
			$selectStmt = null;
			print $e->getMessage ();
			return null;
		}
	}
	
	function getRecordsStatus($user){

		try {
			$dbutil = new DBUtil ();
		
			$conn = $dbutil->getPDOConnection ();
			
			$query = "select no_of_records, user_type from user_payment_status where user=:user";
			
			$status = "";
		
			$selectStmt = $conn->prepare ( $query );
			$selectStmt->bindParam ( ':user', $user, PDO::PARAM_INT );
				
			$selectStmt->execute ();
		
			while ( $row = $selectStmt->fetch () ) {
				$noOfRecords = $row ["no_of_records"];
				$userType = $row ["user_type"];
			}
			
			$query = "select * from renewalservice where user=:user";
			
			$status = "";
		
			$selectStmt = $conn->prepare ( $query );
			$selectStmt->bindParam ( ':user', $user, PDO::PARAM_INT );
				
			$selectStmt->execute ();
		
		    $total_records = $selectStmt->rowCount();
		    
		    $remained_records = $noOfRecords - $total_records;
		
			$conn = null;
			$selectStmt = null;
			
			return $remained_records;
		} catch ( PDOException $e ) {
			$conn = null;
			$selectStmt = null;
			print $e->getMessage ();
			return null;
		}
	}
function getRemainingPeriod($datearr){
	date_default_timezone_set ( "UTC" );
	
	$year = $datearr[4];
	$month = $datearr[3];
	$day = substr($datearr[1], 0,2);
	
	$monthNo = date("m",strtotime($month));

	$updatedOn = $year.'-'.$monthNo.'-'.$day;
	
	$today = (new DateTime())->format('Y-m-d'); //use format whatever you are using
	$expiry = (new DateTime($updatedOn))->format('Y-m-d');
	
	$period=($today-$expiry);
	$today=strtotime($today);
	$expiry=strtotime($expiry);
	
	$period=(($today-$expiry)/(60*60*24));
	
	
// 	date_default_timezone_set ( "UTC" );
// 	$temp_date=date('Y/m/d',mktime(0,0,0,$datearr['month'],$datearr['day'],$datearr['year']));
// 	$registered_timestamp=strtotime($temp_date);
	
// 	$today=date("l js \of F Y h:i:s A");
// 	$datearr=date_parse_from_format("l js \of F Y h:i:s A", $today);
// 	$current_date=date('Y/m/d',mktime(0,0,0,$datearr['month'],$datearr['day'],$datearr['year']));
	
// 	$today_timestamp=strtotime($current_date);
// 	$period=(($today_timestamp-$registered_timestamp)/(60*60*24));
	return $period;
}
}