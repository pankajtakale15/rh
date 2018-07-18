<?php
include_once ('../common/user.php');
include_once('../common/DB.php');
include_once( '../contact/ContactService.php' );
include_once ('../common/Encryption.php');

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
			$login_id_encoded = hash ('sha256',$login_id);
			
			if ($this->isLoginIdExist ( $login_id )) {
				return "exist";
			}
			
			$user_no = "";
			// $user_type = addslashes ( trim ( $userInfo ['userType'] ) );
			// $user_type = "customer";
			
			$user_name = addslashes ( trim ( $userInfo ['name'] ) );
			//$company_name = addslashes ( trim ( $userInfo ['cmpName'] ) );
			
			// $address = addslashes ( trim ( $userInfo ['addressLine'] ) );
			$address = "";
			$country = addslashes ( trim ( $userInfo ['countryName'] ) );
			// $state = addslashes ( trim ( $userInfo ['state'] ) );
			// $city = addslashes ( trim ( $userInfo ['city'] ) );
			$state = "";
			$city = "";
			$pin = addslashes ( trim ( $userInfo ['pin'] ) );
			// $email = addslashes ( trim ( $userInfo ['email'] ) );
			$mobile = addslashes ( trim ( $userInfo ['mobileNo'] ) );
			// $landline = addslashes ( trim ( $userInfo ['landlineNo'] ) );
			$landline = "";
			$isdeleted = 0;
			$version = 1;
			$isactive = 1;
			// $vfc = addslashes ( trim ( $data ['emailid'] ) );
			$password = addslashes ( trim ( $userInfo ['userpassword'] ) );
			$password = hash ( 'sha256', $password );
			
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
			
			$stmt = $conn->prepare ( "insert into user ( user_no, user_type , user_name , company_name , login_id , 
		registered_on , updated_on , address , country , state , city , pin , email , mobile , landline , isdeleted ,
		version , isactive , vfc ,password,img_dir,status,profile_img) 
		values (:user_no, :user_type  , :user_name  , :company_name  ,
				:login_id  , :registered_on  , :updated_on  , :address  , :country  ,
				:state  , :city  , :pin  , :email  , :mobile  , :landline  , :isdeleted  ,
				:version  , :isactive  , :vfc,:password, :img_dir,:status,:profilepic,:loginidencoded)" );
			
			$stmt->bindParam ( ':user_no', $user_no );
			$stmt->bindParam ( ':user_type', $user_type );
			$stmt->bindParam ( ':user_name', $user_name );
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
			
			$updateStmt = $conn->prepare ( "UPDATE `user` SET user_no=:user_no where login_id = :login_id" );
			$updateStmt->bindParam ( ":user_no", $user_no, PDO::PARAM_STR );
			$updateStmt->bindParam ( ':login_id', $login_id, PDO::PARAM_STR );
			$updateStmt->execute ();
			
			$updateStmt = null;
			
			$noOfYear = 0;
			$insertStmt = $conn->prepare ( "insert into `user_payment_status` (updated_on,no_of_year,user) values(:updated_on,:no_of_year,:user)" );
			$insertStmt->bindParam ( ":updated_on", $registered_on, PDO::PARAM_STR );
			$insertStmt->bindParam ( ':no_of_year', $noOfYear, PDO::PARAM_INT );
			$insertStmt->bindParam ( ':user', $user_no, PDO::PARAM_STR );
			$insertStmt->execute ();
				
			$insertStmt = null;
			$conn = null;
			
			$contactService = new ContactService();
			$configInfo = $this->config;
			
			if($user_type==$configInfo->userTypeCustomer){
				$msg = $contactService->sendEmailAndSms_registration($user_name, $vfc, $mobile, $email);
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
	
	
	function updateUser($userInfo) {
		try {
			$email = addslashes ( trim ( $userInfo ['email'] ) );
			
			$user_no = addslashes ( trim ( $userInfo ['userNo'] ) );
			// $user_type = addslashes ( trim ( $userInfo ['userType'] ) );
			// $user_type = "customer";
			$configInfo = $this->config;
			// print_r($configInfo);
			$user_name = addslashes ( trim ( $userInfo ['name'] ) );
// 			$company_name = addslashes ( trim ( $userInfo ['cmpName'] ) );
				
			// $address = addslashes ( trim ( $userInfo ['addressLine'] ) );
			$address = "";
			$country = addslashes ( trim ( $userInfo ['country'] ) );
			// $state = addslashes ( trim ( $userInfo ['state'] ) );
			// $city = addslashes ( trim ( $userInfo ['city'] ) );
			$state = "";
			$city = "";
			$pin = addslashes ( trim ( $userInfo ['pin'] ) );
			// $email = addslashes ( trim ( $userInfo ['email'] ) );
			$mobile = addslashes ( trim ( $userInfo ['mobile'] ) );
			$version = addslashes ( trim ( $userInfo ['version'] ) );
			// $landline = addslashes ( trim ( $userInfo ['landlineNo'] ) );
// 			$landline = "";
// 			$isdeleted = 0;
 			
// 			$isactive = 1;
			// $vfc = addslashes ( trim ( $data ['emailid'] ) );
// 			$password = addslashes ( trim ( $userInfo ['userpassword'] ) );
// 			$password = hash ( 'sha256', $password );
				
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
				
			$updateStmt = $conn->prepare ( "UPDATE `user` SET user_name=:user_name,
					updated_on=:updated_on,address=:address,country=:country,state=:state,city=:city , pin=:pin , email=:email ,
					mobile=:mobile ,version=:version
					where user_no=:user_no" );
				
 			$updateStmt->bindParam ( ':user_no', $user_no );
// 			$updateStmt->bindParam ( ':user_type', $user_type );
			$updateStmt->bindParam ( ':user_name', $user_name );
// 			$updateStmt->bindParam ( ':company_name', $company_name );
			//$updateStmt->bindParam ( ':login_id', $login_id );
			$updateStmt->bindParam ( ':updated_on', $updated_on );
				
			$updateStmt->bindParam ( ':address', $address );
			$updateStmt->bindParam ( ':country', $country );
			$updateStmt->bindParam ( ':state', $state );
			$updateStmt->bindParam ( ':city', $city );
			$updateStmt->bindParam ( ':pin', $pin );
			$updateStmt->bindParam ( ':email', $email );
			$updateStmt->bindParam ( ':mobile', $mobile );
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
		
			$updateStmt = $conn->prepare ( "UPDATE `user` SET 
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
			$dbutil = new DBUtil ();
			
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
	function login($loginId,$userPassword,$logintype) {
		$login_id = addslashes ( trim ( $loginId ) );
		$password = addslashes ( trim ( $userPassword ) );
		$password = hash ( 'sha256', $password );
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
				
				return $userInfo ["status"];
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
			
			$query = "select user_no, user_type , user_name , company_name , login_id , 
		registered_on , updated_on , address , country , state , city , pin , email , mobile , landline , isdeleted ,
		version , isactive , vfc ,img_dir,profile_img from user WHERE user_no = :user_no";
			
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
						"name" => $row ["user_name"],
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
						"profilePic" => $row ["profile_img"]
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
	function getUserByLoginId($login_id) {
		$login_id = addslashes ( trim ( $login_id ) );
		try {
			$dbutil = new DBUtil ();
			
			$conn = $dbutil->getPDOConnection ();
			
			$query = "select user_no, user_type , user_name , company_name , login_id ,
		registered_on , updated_on , address , country , state , city , pin , email , mobile , landline , isdeleted ,
		version , isactive , vfc ,img_dir,status,profile_img from user WHERE login_id = :login_id";
			
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
						"name" => $row ["user_name"],
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
						"profilePic" => $row ["profile_img"]
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
			
			$userPassword = hash ( 'sha256', $userPassword );
			
			$dbutil = new DBUtil ();
			
			$conn = $dbutil->getPDOConnection ();
			
			$updateStmt = $conn->prepare ( "UPDATE `user` SET password=:password where login_id_encoded = :login_id" );
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
	
	function getEmployeeList($companyid){
		$companyid = addslashes ( trim ( $companyid ) );
		
// 		$converter = new Encryption();
// 		$companyid = $converter->decode($companyid);
		
		try {
			$dbutil = new DBUtil ();
				
			$conn = $dbutil->getPDOConnection ();
				
			$query = "select user_no, user_type , user_name , company_name , login_id ,
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
						"name" => $row ["user_name"],
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
	
			$query = "select   user_name ,registered_on  , address , country , state ,
			city , pin , email , mobile , landline ,user_no from user";
	
			$selectStmt = $conn->prepare ( $query );
	
			$selectStmt->execute ();
	
			$userArr = array ();
			$count = 0;
				
			while ( $row = $selectStmt->fetch () ) {
				
				$user = array (
						"name" => $row ["user_name"],
						"regDate" => $row ["registered_on"],
						"addLine" => $row ["address"],
						"country" => $row ["country"],
						"state" => $row ["state"],
						"city" => $row ["city"],
						"pin" => $row ["pin"],
						"email" => $row ["email"],
						"mobile" => $row ["mobile"],
						"landline" => $row ["landline"],
						"userNo" => $row ["user_no"]
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
	
	function getPaymentStatusForUser($user){

		try {
			$dbutil = new DBUtil ();
		
			$conn = $dbutil->getPDOConnection ();
			
			$query = "select no_of_year ,updated_on from user_payment_status where user=:user";
			
			$status = "";
		
			$selectStmt = $conn->prepare ( $query );
			$selectStmt->bindParam ( ':user', $user, PDO::PARAM_INT );
				
			$selectStmt->execute ();
		
			while ( $row = $selectStmt->fetch () ) {
				$noOfYear = $row ["no_of_year"];
				$updatedOn = $row ["updated_on"];
				
				//$datearr=date_parse_from_format("l js \of F Y h:i:s A", $updatedOn);
				$datearr = explode(" ", $updatedOn);
				$period = $this->getRemainingPeriod($datearr);
				//echo "Perioad::".$period;
				if($noOfYear == 0 && $period>30){
					$status = "freeUserExpired";
				}else if ($noOfYear == 0 && $period>25 && $period<30){
					$status = "freeUserNearToExpire";
				}else if ($noOfYear > 0){
					$totalDays = $noOfYear*365;
					if($period>$totalDays){
						$status = "paidUserExpired";
					}else if ($period>($totalDays-5) && $period<($totalDays)){
						$status = "paidUserNearToExpire";
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
