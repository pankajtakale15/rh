<?php
include_once( '../common/DB.php' );
include_once( '../contact/ContactService.php' );

class RenewalSerService {

	function insertServices($_FILESArr,$renewalServices,$daysDiff,$user){
		
		$this->uploadFiles($_FILESArr,$user->imgDir);
		$result = $this->addRenewalServices($renewalServices,$daysDiff,$user);
		return $result;
	}
	
	function addRenewalServices($renewalServices,$daysDiff,$user){
		$result = "";
		$size = sizeof($renewalServices);
		for ($i=0;$i<$size;$i++){
			$result = $this->addRenewalService($renewalServices[$i],$daysDiff[$i],$user);
		}
	    /*$result = $this->checkAllotment($daysDiff,$user);
	    if($result == "NO")
        {
            return "NO";
        }else if($result == "YES")
        {
             for ($i=0;$i<$size;$i++){
			   $this->addRenewalService($renewalServices[$i],$daysDiff[$i],$user);
		    }
		    
		    //return "success";
        }*/
		return $result;
	}
	
	function confirmEmail($data)
	{
	     $usermail = $data;
	     
     	$dbutil = new DBUtil ();
	    $conn = $dbutil->getPDOConnection ();
	    
	    $selectStmt = $conn->prepare ( 'SELECT login_id FROM user WHERE login_id_encoded = :login_id' );
	    $selectStmt->bindParam ( ':login_id', $usermail, PDO::PARAM_STR );
		$selectStmt->execute ();
		
 		while($userInfo = $selectStmt->fetch())
		{
		    $email = $userInfo['login_id'];
		}
	
	   return $email;

	}
	
	function getIndianCurrencyInWords($number)
    {
        $decimal = round($number - ($no = floor($number)), 2) * 100;
        $hundred = null;
        $digits_length = strlen($no);
        $i = 0;
        $str = array();
        $words = array(0 => '', 1 => 'One', 2 => 'Two',
            3 => 'Three', 4 => 'Four', 5 => 'Five', 6 => 'Six',
            7 => 'Seven', 8 => 'Eight', 9 => 'Nine',
            10 => 'Ten', 11 => 'Eleven', 12 => 'Twelve',
            13 => 'Thirteen', 14 => 'Fourteen', 15 => 'Fifteen',
            16 => 'Sixteen', 17 => 'Seventeen', 18 => 'Eighteen',
            19 => 'Nineteen', 20 => 'Twenty', 30 => 'Thirty',
            40 => 'Forty', 50 => 'Fifty', 60 => 'Sixty',
            70 => 'Seventy', 80 => 'Eighty', 90 => 'Ninety');
        $digits = array('', 'Hundred','Thousand','Lakh', 'Crore');
        while( $i < $digits_length ) {
            $divider = ($i == 2) ? 10 : 100;
            $number = floor($no % $divider);
            $no = floor($no / $divider);
            $i += $divider == 10 ? 1 : 2;
            if ($number) {
                $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
                $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
                $str [] = ($number < 21) ? $words[$number].' '. $digits[$counter]. $plural.' '.$hundred:$words[floor($number / 10) * 10].' '.$words[$number % 10]. ' '.$digits[$counter].$plural.' '.$hundred;
            } 
            else $str[] = null;
        }
        $Rupees = implode('', array_reverse($str));
        $paise = ($decimal) ? "." . ($words[$decimal / 10] . " " . $words[$decimal % 10]) . ' Paise' : '';
        return ($Rupees ? $Rupees . 'Rupees ' : '') . $paise;
    }
	
	function validPeriodToUpdate ($recordId , $daysDiff)
	{
	
		$remaingDays = 0;
	    $dbutil = new DBUtil ();
	    $conn = $dbutil->getPDOConnection ();   
	    
	    $stmt = $conn->prepare ( "select remaining_days from user_records_info where alloted=:alloted");
		$stmt->bindParam ( ':alloted',$recordId);
		$stmt->execute();
		
		while ($row = $stmt->fetch())
		{
		    $remainingDays = $row ['remaining_days'];
		}
		
		if ($remainingDays > $daysDiff)
		{
		    return "AVAIL";
		}
		else
		{
		    return "NTAVAIL";
		}
	}
	
	function checkAllotment($daysDiff,$user)
	{
	    $dbutil = new DBUtil ();
	    $conn = $dbutil->getPDOConnection ();   
	    
	    $stmt = $conn->prepare ( "select user_type from user_payment_status where user=:user_no");
		$stmt->bindParam ( ':user_no',$user->userNo);
		$stmt->execute();
				
		while($row = $stmt->fetch())
		{
		    $userType = $row ['user_type'];
		}
				
		$stmt = null;
				
		if($userType == "P")
		{
			$stmt = null;
		    $alloted = 0;
		    $temp = 0;
		    $size = sizeof($daysDiff);
		    
		    for($i=0;$i<$size;$i++)
		    {
		        $stmt = null;
			    $stmt = $conn->prepare ( "select * from user_records_info where user_no=:user_no and alloted=:alloted and temp=:temp");
			    $stmt->bindParam ( ':user_no',$user->userNo);
			    $stmt->bindParam ( ':alloted',$alloted );
			    $stmt->bindParam ( ':temp',$temp );
			    $stmt->execute ();
			    
			    if($stmt->fetchColumn()<1)
			    {
			        return "NO";
			    }
			    while($row = $stmt->fetch())
			    {
			        $remDays = $row ['remaining_days'];
    	            if($daysDiff[$i] < $remDays)
			        {
    	                $rowId = $row ['id'];
    	                $temp = 1;
    	                $updateStmt = $conn->prepare ( "update `user_records_info` set temp=:temp where id=:row_id");
		                $updateStmt->bindParam ( ':temp' , $temp );
		                $updateStmt->bindParam ( ':row_id' , $rowId );
			            $updateStmt->execute ();
		                $updateStmt=null;
		            }
		            else
		            {
		                $temp = 0;
		                $updateStmt = $conn->prepare ( "update `user_records_info` set temp=:temp");
		                $updateStmt->bindParam ( ':temp' , $temp );
			            $updateStmt->execute ();
		                $updateStmt=null;
		                return "NO";
		                exit;
		            }
			    }
		    }
		    return "YES";
		}
		else if($userType == "T")
		{
		    return "YES";
		}
	}
	
	function setTemplate($templateType,$subject,$message){
		try{
			$templateType = addslashes ( trim ( $templateType ) );
			$subject = addslashes ( trim ( $subject ) );
			$message = addslashes ( trim ( $message ) );
			
			$dbutil = new DBUtil ();
			$conn = $dbutil->getPDOConnection ();
			
			$selectStmt = $conn->prepare ( "select * from template where template_type = :templateType" );
			$selectStmt->bindParam ( ':templateType', $templateType );
			$selectStmt->execute();
			
			$isAvail = $selectStmt->fetchColumn();
			
			if ($isAvail > 0){
				$stmt = $conn->prepare ( "UPDATE template SET template_subject=:templateSubject, template_message=:templateMessage WHERE template_type=:templateType" );
				$stmt->bindParam ( ':templateType', $templateType );
				$stmt->bindParam ( ':templateSubject', $subject );
				$stmt->bindParam ( ':templateMessage', $message );
				$stmt->execute();
			}else if ($isAvail == 0){
				$stmt = $conn->prepare ( "insert into template (template_type,template_subject,template_message)
				values(:templateType,:templateSubject,:templateMessage)" );
				
				$stmt->bindParam ( ':templateType', $templateType );
				$stmt->bindParam ( ':templateSubject', $subject );
				$stmt->bindParam ( ':templateMessage', $message );
				$stmt->execute ();
			}
			
			return "success";
			
		} catch ( PDOException $e ) {
			$conn = null;
			print $e->getMessage ();
			return "failed";
		}
	}
	
	function getTemplate($templateType){
		try{
			$templateType = addslashes ( trim ( $templateType ) );
			
			$subject = "";
			$message = "";
			
			$dbutil = new DBUtil ();
			$conn = $dbutil->getPDOConnection ();
			
			$selectStmt = $conn->prepare ( "select * from template where template_type = :templateType" );
			$selectStmt->bindParam ( ':templateType', $templateType );
			$selectStmt->execute();
			
			while($row = $selectStmt->fetch()){
				$subject = $row['template_subject'];
				$message = $row['template_message'];
			}
			
			$template = array(
				"result" =>"success",
				"subject" => $subject,
				"message" => $message 
			);
			
			return $template;
			
		} catch ( PDOException $e ) {
			$conn = null;
			print $e->getMessage ();
			return "failed";
		}
	}
	
	function createLog($logUser,$logActivity,$logActivityId,$logDescription){
		try{
		
			$logUser = addslashes ( trim ( $logUser ) );
			$logActivity = addslashes ( trim ( $logActivity ) );
			$logActivityId = addslashes ( trim ( $logActivityId ) );
			$logDescription = addslashes ( trim ( $logDescription ) );
			date_default_timezone_set ( "UTC" );
			$logDate = date("d-m-Y");
			
			$dbutil = new DBUtil ();
			$conn = $dbutil->getPDOConnection ();
				
			$stmt = $conn->prepare ( "insert into user_logs (log_date,log_activity,log_activity_id,log_description,log_user)
				values(:logDate,:logActivity,:logActivityId,:logDescription,:logUser)" );
				
			$stmt->bindParam ( ':logDate', $logDate );
			$stmt->bindParam ( ':logActivity', $logActivity);
			$stmt->bindParam ( ':logActivityId', $logActivityId);
			$stmt->bindParam ( ':logDescription', $logDescription);
			$stmt->bindParam ( ':logUser', $logUser);
			$stmt->execute ();
			
			return "success";
			
		} catch ( PDOException $e ) {
			$conn = null;
			print $e->getMessage ();
			return "failed";
		}
	}
	
	function addRenewalService($renewalService,$daysDiff,$user) {
		try {	
		
			//echo $renewalService->description;
			$description = addslashes ( trim ( $renewalService->description) );

			//echo $description;
			if ($description != "") {
				
				$category = addslashes ( trim ( $renewalService ->categoryId) );
				$len = strlen($category);
				$pos = strpos($category,",");
				$category = substr($category,$pos+1,$len);
				$subcategory = addslashes ( trim ( $renewalService ->subCategoryId) );
				$entity = addslashes ( trim ($renewalService ->entity));
				$model = addslashes ( trim ($renewalService ->model) );
				$supplier_name = addslashes ( trim ( $renewalService->supplierName) );
			    $location = addslashes ( trim ($renewalService ->location) );
				$amount = addslashes ( trim ( $renewalService->amount ) );
				$gst = addslashes ( trim ( $renewalService->gst ) );
				$supplier_email = addslashes ( trim ( $renewalService->supplierEmail ) );
				$supplier_contact = addslashes ( trim ( $renewalService->supplierContact ) );
				$sendMailTo_Supplier = $renewalService->sendMailToSupplier;
				
				if($sendMailTo_Supplier != 1)
				{
				    $sendMailTo_Supplier = 0;
				}
				$purchase_date = addslashes ( trim ($renewalService->purchaseDate));
				$expiry_date = addslashes ( trim ( $renewalService->expiryDate ) );
				date_default_timezone_set('UTC');
// 				$dtime = DateTime::createFromFormat("!d/m/y", $expiry_date);
// 				echo "dtime".$dtime>format('U');
// 				$date = DateTime::createFromFormat('!d-m-Y', '22-09-2008');
// 				echo $dateTime->format('U');
				//$expiry_date = $dtime->getTimestamp();
				//$expiry_date = date("m/d/Y", strtotime($expiry_date));
				$purchase_date = strtotime($purchase_date);
				$expiry_date = strtotime($expiry_date);
				
// 				$expiry_date = FROM_UNIXTIME($expiry_date);
 				//echo "expiry_date::".$expiry_date;
				$contract_no = addslashes ( trim ( $renewalService->contactNumber ) );
			//	$comment = addslashes ( trim ( $renewalService->comment) );
				$comment = "";
				$setEscalation = "";
				$escalationMail = "";
				$startEscalation = "";
				$reminder_before = addslashes ( trim ( $renewalService->reminder ) );
				$escalationMail = addslashes ( trim ( $renewalService->escalationEmail));
				$startEscalation = addslashes ( trim ( $renewalService->startEscalation));
				if ($startEscalation == 1){
				}else {
					$startEscalation = 0;
				}
				$setEscalation = addslashes ( trim ( $renewalService->setEscalation));
				$filepath = addslashes ( trim ( $renewalService->fileName) );

				if ($setEscalation != 1){
					$setEscalation = 0;
				}
				
				$isdeleted = 0;
				$version = 1;
				$temp = 0;
				
				date_default_timezone_set ( "UTC" );
				$time = date ( "l jS \of F Y h:i:s A" );
				
				$submited_on = $time;
				
				$mailSentToSenior = "NO";
				$currentStatus = "OPEN";
				
				$dbutil = new DBUtil ();
				$conn = $dbutil->getPDOConnection ();
				
				/*$registeredDate = "";
				$selectStmt = $conn->prepare("select * from validator");
				$selectStmt->execute();
				
			 	while ($row = $selectStmt->fetch()){
			 		$registeredDate = $row ["startdate"];
			 	}
				
				$datetime1 = new DateTime($registeredDate);
				$datetime2 = new DateTime();
				$interval = $datetime1->diff($datetime2);
				$days =  $interval->format('%a');
				if ($days > 15){
					return "expired";
				} */
				
				
				$stmt = $conn->prepare ( "insert into renewalservice (category,subcategory,entity,description,model,supplier_name,
					amount,gst,supplier_email,supplier_contact,location,purchase_date,expiry_date,contract_no,comment,reminder_before,filepath,isdeleted,version,user,submited_on,mail_to_supplier,username,mail_sent_to_senior,current_status,is_escalation,escalation_mail, escalation_start)
		values (:category,:subcategory,:entity,:description,:model,:supplier_name,:amount,:gst,
					:supplier_email,:supplier_contact,:location,FROM_UNIXTIME(:purchase_date),FROM_UNIXTIME(:expiry_date),:contract_no,:comment,:reminder_before,
					:filepath,:isdeleted,:version,:user,:submited_on,:mailtosupplier,:username,:mailSentToSenior,:currentStatus,:isEscalation,:escalationMail,:escalationStart)" );
				
				$stmt->bindParam ( ':category', $category );
				$stmt->bindParam ( ':subcategory', $subcategory );
				$stmt->bindParam ( ':entity', $entity );
				$stmt->bindParam ( ':description', $description );
				$stmt->bindParam ( ':model', $model);
				$stmt->bindParam ( ':supplier_name', $supplier_name );
				$stmt->bindParam ( ':amount', $amount );
				$stmt->bindParam ( ':gst', $gst );
				$stmt->bindParam ( ':supplier_email', $supplier_email );
				$stmt->bindParam ( ':supplier_contact', $supplier_contact);
				$stmt->bindParam ( ':location', $location);
				$stmt->bindParam ( ':purchase_date', $purchase_date);
				$stmt->bindParam ( ':expiry_date',  $expiry_date );
				$stmt->bindParam ( ':contract_no', $contract_no );
				$stmt->bindParam ( ':comment', $comment );
				$stmt->bindParam ( ':reminder_before', $reminder_before );
				$stmt->bindParam ( ':filepath', $filepath );
				$stmt->bindParam ( ':isdeleted', $isdeleted );
				$stmt->bindParam ( ':version', $version );
				$stmt->bindParam ( ':user', $user->userNo );
				$stmt->bindParam ( ':submited_on', $submited_on );
				$stmt->bindParam ( ':mailtosupplier', $sendMailTo_Supplier );
				$stmt->bindParam ( ':username', $user->userName );
				$stmt->bindParam ( ':mailSentToSenior', $mailSentToSenior );
				$stmt->bindParam ( ':currentStatus', $currentStatus );
				$stmt->bindParam ( ':isEscalation', $setEscalation );
				$stmt->bindParam ( ':escalationMail', $escalationMail );
				$stmt->bindParam ( ':escalationStart', $startEscalation );
				$stmt->execute ();
				
				$stmt = null;
				
				$recordId = 0;
				$query = "select * from renewalservice";
				$selectStmt = $conn->prepare ( $query );
				$selectStmt->execute ();
	
				while ( $row = $selectStmt->fetch () ) {
					// $user = array();
					$recordId = $row ["id"];	
				}
				
				$this->createLog($user->userNo,"RcrdInserted",$recordId,"Record has been inserted!");
				
				return "success";
			}
		} catch ( PDOException $e ) {
			$conn = null;
			print $e->getMessage ();
			return "failed";
		}
	}

    function spaceAllotment()
    {
        $dbutil = new DBUtil ();
		$conn = $dbutil->getPDOConnection ();
	    
	    
    }

	function uploadFiles($_FILESArr,$imgDir){
		
		for ($i = 0; $i < count($_FILESArr); $i++) {
			$file = $_FILESArr['file'.$i];
			$this->uploadFile($file,$imgDir);
		}
	}
	
	function uploadFile($_FILESArr,$imgDir){
		
		$errors= array();
		$file_name = $_FILESArr['name'];

// 		if ($this->isFileExist($userNo.$file_name)){
// 			return "exist";
// 		}
			
		$file_size = $_FILESArr['size'];
		$file_tmp = $_FILESArr['tmp_name'];
		$file_type = $_FILESArr['type'];
			
		$fileVar = explode('.',$_FILESArr['name']);
		
		$file_ext=strtolower(end($fileVar));

		//$expensions= array("jpeg","jpg","png");
		
// 		if(in_array($file_ext,$expensions)=== false){
// 			$errors[]="extension not allowed, please choose a JPEG or PNG file.";
// 		}
		
// 		if($file_size > 2097152) {
// 			$errors[]='File size must be excately 2 MB';
// 		}
		
		if(empty($errors)==true) {
			//echo "uploads/".$imgDir."/".$file_name;
			date_default_timezone_set('UTC');
			//date("Y-m-d")
			$dirPath = "../uploads/".$imgDir;
				
			if (!file_exists($dirPath)) {
				mkdir($dirPath, 0777, true);
			}
		
			if (file_exists($dirPath."/".$file_name)) {
				return "exist";
			}
		
			//$status = $this->updateFileInDB($file_name,$dirPath,$userNo,$description);
		
// 			if($status=="success")
// 			{
//echo $file_tmp,$dirPath."/".$file_name;
				move_uploaded_file($file_tmp,$dirPath."/".$file_name);
					
				return "success";
					
// 			}else {
// 				return "failed";
// 			}
		
			//return "Success";
			// echo "<img src='uploads/.$file_name'>";
		}else{
			print_r($errors);
		}
	}
	
// 	function searchRenewalServices($catagory,$user,$reminder){
	function searchRenewalServices($catagory,$user,$userType,$dueFrom,$dueTo){
	
		$catagory = addslashes ( trim ( $catagory ) );
		$user = addslashes ( trim ( $user ) );
		$userType = addslashes ( trim ( $userType ) );
// 		$reminder = addslashes ( trim ( $reminder ) );
		$dueFrom = addslashes ( trim ( $dueFrom ) );
		$dueTo = addslashes ( trim ( $dueTo ) );
// 		echo $catagory;
// 		echo $user;
// 		echo $reminder;
		try {
			$dbutil = new DBUtil ();
		
			$conn = $dbutil->getPDOConnection ();
		
// 			$query = "select category,subcategory,description,supplier_name,
// 					amount,supplier_email,expiry_date,contract_no,comment,reminder_before,filepath,isdeleted,version,user,submited_on
// 					from renewalservice WHERE datediff(expiry_date,CURDATE())  <= reminder_before and
// 					reminder_before = :reminder_before and user=:user and category=:category";
// 			$query = "select category,subcategory,description,supplier_name,
// 					amount,supplier_email,expiry_date,contract_no,comment,reminder_before,datediff(expiry_date,CURDATE())as 
// 					remainingdays,filepath,isdeleted,version,user,submited_on
// 					from renewalservice WHERE datediff(expiry_date,CURDATE())  >= :reminder_before and user=:user and category=:category";
			
			
			if ($userType == "admin"){
			
				if ($catagory == "closed"){
					$currentStatus = "CLOSE";
					$query = "select id,category,subcategory,entity,description,model,supplier_name,
						amount,gst,supplier_email,supplier_contact,location,purchase_date,expiry_date,contract_no,comment,reminder_before,datediff(expiry_date,CURDATE())as
						remainingdays,filepath,isdeleted,version,user,submited_on, mail_sent_to_senior, current_status, escalation_mail, escalation_start 
						from renewalservice WHERE current_status = :currentStatus and datediff(expiry_date,CURDATE())  BETWEEN :dueFrom AND :dueTo";

					$selectStmt = $conn->prepare ( $query );
					$selectStmt->bindParam ( ':currentStatus', $currentStatus, PDO::PARAM_STR);
					$selectStmt->bindParam ( ':dueFrom', $dueFrom, PDO::PARAM_STR );
					$selectStmt->bindParam ( ':dueTo', $dueTo, PDO::PARAM_STR );
				
				}else{
					$currentStatus = "CLOSE";
					$query = "select id,category,subcategory,entity,description,model,supplier_name,
						amount,gst,supplier_email,supplier_contact,location,purchase_date,expiry_date,contract_no,comment,reminder_before,datediff(expiry_date,CURDATE())as
						remainingdays,filepath,isdeleted,version,user,submited_on, mail_sent_to_senior, current_status, escalation_mail, escalation_start
						from renewalservice WHERE not current_status = :currentStatus and datediff(expiry_date,CURDATE())  BETWEEN :dueFrom AND :dueTo";

					if($catagory != "all"){
						$query = $query . " and category=:category";
					}
			
					$selectStmt = $conn->prepare ( $query );
					$selectStmt->bindParam ( ':currentStatus', $currentStatus, PDO::PARAM_STR);
					$selectStmt->bindParam ( ':dueFrom', $dueFrom, PDO::PARAM_STR );
					$selectStmt->bindParam ( ':dueTo', $dueTo, PDO::PARAM_STR );
			
					if($catagory != "all"){
						$selectStmt->bindParam ( ':category', $catagory, PDO::PARAM_STR );
					}
				}
				
			}else{
			if ($catagory == "closed"){
					$currentStatus = "CLOSE";
					$query = "select id,category,subcategory,entity,description,model,supplier_name,
						amount,gst,supplier_email,supplier_contact,location,purchase_date,expiry_date,contract_no,comment,reminder_before,datediff(expiry_date,CURDATE())as
						remainingdays,filepath,isdeleted,version,user,submited_on, mail_sent_to_senior, current_status, escalation_mail, escalation_start
						from renewalservice WHERE current_status = :currentStatus and datediff(expiry_date,CURDATE())  BETWEEN :dueFrom AND :dueTo  and user=:user";

					$selectStmt = $conn->prepare ( $query );
					$selectStmt->bindParam ( ':currentStatus', $currentStatus, PDO::PARAM_STR);
					$selectStmt->bindParam ( ':dueFrom', $dueFrom, PDO::PARAM_STR );
					$selectStmt->bindParam ( ':dueTo', $dueTo, PDO::PARAM_STR );
					$selectStmt->bindParam ( ':user', $user, PDO::PARAM_STR );
				
				}else{
					$currentStatus = "CLOSE";
					$query = "select id,category,subcategory,entity,description,model,supplier_name,
						amount,gst,supplier_email,supplier_contact,location,purchase_date,expiry_date,contract_no,comment,reminder_before,datediff(expiry_date,CURDATE())as
						remainingdays,filepath,isdeleted,version,user,submited_on, mail_sent_to_senior, current_status, escalation_mail, escalation_start
						from renewalservice WHERE not current_status = :currentStatus and datediff(expiry_date,CURDATE())  BETWEEN :dueFrom AND :dueTo AND user=:user";

					if($catagory != "all"){
						$query = $query . " and category=:category";
					}
			
					$selectStmt = $conn->prepare ( $query );
					$selectStmt->bindParam ( ':currentStatus', $currentStatus, PDO::PARAM_STR);
					$selectStmt->bindParam ( ':dueFrom', $dueFrom, PDO::PARAM_STR );
					$selectStmt->bindParam ( ':dueTo', $dueTo, PDO::PARAM_STR );
					$selectStmt->bindParam ( ':user', $user, PDO::PARAM_STR );
			
					if($catagory != "all"){
						$selectStmt->bindParam ( ':category', $catagory, PDO::PARAM_STR );
					}
				}
			}
		
			$selectStmt->execute ();
		
			$renewalServiceArr = array ();
			$count = 0;
			
			while ( $row = $selectStmt->fetch () ) {
				// $user = array();
			$upDescription = "description_"+$row['id'];
			$upSupplierName = "supplierName_"+$row['id'];
			$upSupplierEmail = "supplierEmail_"+$row['id'];
				$renewalService = array (
						"id" => $row ["id"],
						"category" => $row ["category"],
						"subcategory" => $row ["subcategory"],
						"entity" => $row['entity'],
						"description" => $row ["description"],
						"model" => $row ["model"],
						"supplierName" => $row ["supplier_name"],
						"amount" => $row ["amount"],
						"gst" => $row ["gst"],
						"supplierEmail" => $row ["supplier_email"],
						"supplierContact" => $row["supplier_contact"],
						"location" => $row ["location"],
						"purchaseDate" => $row ["purchase_date"],
						"expiryDate" => $row ["expiry_date"],
						"contractNo" => $row ["contract_no"],
						"comment" => $row ["comment"],
						"reminderBefore" => $row ["reminder_before"],
						"filepath" => $row ["filepath"],
						"isdeleted" => $row ["isdeleted"],
						"version" => $row ["version"],
						"user" => $row ["user"],
						"submitedOn" => $row ["submited_on"],
						"mailSentToSenior" => $row["mail_sent_to_senior"],
						"currentStatus" => $row["current_status"],
						"escalationEmail" => $row["escalation_mail"],
						"escalationStart" => $row["escalation_start"],
						"remainingDays" => $row ["remainingdays"],
						"upDescription" => $upDescription,
						"upSupplierName" => $upSupplierName,
						"upAmount" => "amount_"+$row["id"],
						"upSupplierEmail" => $upSupplierEmail,
						"upExpiryDate" => "expiryDate_"+$row["id"],
						"upContractNo" => "contractNo_"+$row["id"],
						"upReminderBefore" => "reminderBefore_"+$row["id"],
					);
		
				$renewalServiceArr[$count] = $renewalService;
				$count++;
			}
		
			$conn = null;
			$selectStmt = null;
		
			$allrenewalServiceArr = array (
					"renewalServices" => $renewalServiceArr,
					"message" => "success"
			);
			
			return $allrenewalServiceArr;
			
		} catch ( PDOException $e ) {
			$conn = null;
			$selectStmt = null;
			print $e->getMessage ();
			return null;
		}
	}
	
	function searchRenewalServicesNoUser(){
		
		try {
		
			$dbutil = new DBUtil ();
		
			$conn = $dbutil->getPDOConnection ();
			
			$query = "select id,category,subcategory,entity,description,model,supplier_name,
						amount,gst,supplier_email,supplier_contact,location,purchase_date,expiry_date,contract_no,comment,reminder_before,datediff(expiry_date,CURDATE())as
						remainingdays,filepath,isdeleted,version,user,submited_on, mail_sent_to_senior, current_status, escalation_mail, escalation_start
						from renewalservice";

			$selectStmt = $conn->prepare ( $query );
			$selectStmt->execute ();
		
			$renewalServiceArr = array ();
			$count = 0;
			
			while ( $row = $selectStmt->fetch () ) {
				// $user = array();
			
				$selectStmt1 = $conn->prepare ("select count(*) from user where user_no = :userNo");
				$selectStmt1->bindParam(":userNo", $row['user'], PDO::PARAM_STR);
				$selectStmt1->execute();
			
				if ($selectStmt1->fetchColumn() > 0){
			
				}else{
					$upDescription = "description_"+$row['id'];
					$upSupplierName = "supplierName_"+$row['id'];
					$upSupplierEmail = "supplierEmail_"+$row['id'];
					$renewalService = array (
						"id" => $row ["id"],
						"category" => $row ["category"],
						"subcategory" => $row ["subcategory"],
						"entity" => $row["entity"],
						"description" => $row ["description"],
						"model" => $row ["model"],
						"supplierName" => $row ["supplier_name"],
						"amount" => $row ["amount"],
						"gst" => $row ["gst"],
						"supplierEmail" => $row ["supplier_email"],
						"supplierContact" => $row["supplier_contact"],
						"location" => $row ["location"],
						"purchaseDate" => $row ["purchase_date"],
						"expiryDate" => $row ["expiry_date"],
						"contractNo" => $row ["contract_no"],
						"comment" => $row ["comment"],
						"reminderBefore" => $row ["reminder_before"],
						"filepath" => $row ["filepath"],
						"isdeleted" => $row ["isdeleted"],
						"version" => $row ["version"],
						"user" => $row ["user"],
						"submitedOn" => $row ["submited_on"],
						"mailSentToSenior" => $row["mail_sent_to_senior"],
						"currentStatus" => $row["current_status"],
						"escalationEmail" => $row["escalation_mail"],
						"escalationStart" => $row["escalation_start"],
						"remainingDays" => $row ["remainingdays"],
						"upDescription" => $upDescription,
						"upSupplierName" => $upSupplierName,
						"upAmount" => "amount_"+$row["id"],
						"upSupplierEmail" => $upSupplierEmail,
						"upExpiryDate" => "expiryDate_"+$row["id"],
						"upContractNo" => "contractNo_"+$row["id"],
						"upReminderBefore" => "reminderBefore_"+$row["id"],
					);
		
					$renewalServiceArr[$count] = $renewalService;
					$count++;
				}
			
			
			}
		
			$conn = null;
			$selectStmt = null;
		
			$allrenewalServiceArr = array (
					"renewalServices" => $renewalServiceArr,
					"message" => "success"
			);
			
			return $allrenewalServiceArr;
			
		} catch ( PDOException $e ) {
			$conn = null;
			$selectStmt = null;
			print $e->getMessage ();
			return null;
		}
	}
	
	function getRenewalLogs($category, $from, $to){
		$category = addslashes ( trim ( $category ) );
		
		try {
		
			
			$dbutil = new DBUtil ();
		
			$conn = $dbutil->getPDOConnection ();
			$query = "select * from user_logs";
			$selectStmt = $conn->prepare ( $query );
			$selectStmt->execute ();
			$count = 0;
			$rcount = 0;
				
			while ( $row = $selectStmt->fetch () ) {
				if ($count >= $from && $count < $to){
					
					$userName = "";
					$selectStmt1 = $conn->prepare("select username from user where user_no = :id");
					$selectStmt1->bindParam(":id", $row['log_user']);
					$selectStmt1->execute();
					
					while ($row1 = $selectStmt1->fetch()){
						$userName = $row1['username'];	
					}
					
					$renewalLogs = array (
						"id" => $row ["id"],
						"logDate" => $row ["log_date"],
						"logActivity" => $row ["log_activity"],
						"logActivityId" => $row ["log_activity_id"],
						"logDescription" => $row ["log_description"],
						"performedBy" => $userName		
					);
					$renewalLogArr[$rcount] = $renewalLogs;
					$rcount = $rcount + 1;
				}
				$count++;
			}
		
			$conn = null;
			$selectStmt = null;
		
			$allrenewalLogArr = array (
					"renewalLogs" => $renewalLogArr,
					"logs" => $rcount, 
					"message" => "success"
			);
			
			return $allrenewalLogArr;
			
		} catch ( PDOException $e ) {
			$conn = null;
			$selectStmt = null;
			print $e->getMessage ();
			return null;
		}
	}
	
	function getRenewalLogsByUser($user, $from, $to){
		$user = addslashes ( trim ( $user ) );
		
		try {
		
			
			$dbutil = new DBUtil ();
		
			$conn = $dbutil->getPDOConnection();
			$query = "select * from user_logs where log_user=:user_no";
			$selectStmt = $conn->prepare ( $query );
			$selectStmt->bindParam(":user_no",$user,PDO::PARAM_STR);
			$selectStmt->execute ();
			$count = 0;
			$rcount = 0;
			$rrcount = 0;
			$renewalLogArr = array();	
			while ( $row = $selectStmt->fetch () ) {
				if ($count >= $from && $count < $to ){
					
					$renewalLogs = array (
						"id" => $row ["id"],
						"logDate" => $row ["log_date"],
						"logActivity" => $row ["log_activity"],
						"logActivityId" => $row ["log_activity_id"],
						"logDescription" => $row ["log_description"],
						"performedBy" => $row ["log_user"]			
					);
					$renewalLogArr[$rcount] = $renewalLogs;
					$rcount = $rcount + 1;
				}
				$count++;
			}
		
			$conn = null;
			$selectStmt = null;
		
			$allrenewalLogArr = array (
				"renewalLogs" => $renewalLogArr,
				"logs" => $rcount,
				"message" => "success"
			);
			
			return $allrenewalLogArr;
			
		} catch ( PDOException $e ) {
			$conn = null;
			$selectStmt = null;
			print $e->getMessage ();
			return null;
		}
	}
	
	function getRenewalLogsByDate($searchDate, $from, $to){

		$searchDate = addslashes ( trim ( $searchDate ) );
		$searchDate = date("d-m-Y", strtotime($searchDate));
		
		try {

			
			$dbutil = new DBUtil ();
		
			$conn = $dbutil->getPDOConnection();
			$query = "select * from user_logs where log_date=:log_date";
			$selectStmt = $conn->prepare ( $query );
			$selectStmt->bindParam(":log_date",$searchDate,PDO::PARAM_STR);
			$selectStmt->execute ();
			$count = 0;
			$rcount = 0;
			$renewalLogArr = array();
			
			$number_of_rows = $selectStmt->fetchColumn ();
			
			if ($number_of_rows > 0){
				$selectStmt->execute();
				while ( $row = $selectStmt->fetch () ) {
					if ($count >= $from && $count < $to){
						$renewalLogs = array (
							"id" => $row ["id"],
							"logDate" => $row ["log_date"],
							"logActivity" => $row ["log_activity"],
							"logActivityId" => $row ["log_activity_id"],
							"logDescription" => $row ["log_description"],
							"performedBy" => $row ["log_user"]			
						);
						$renewalLogArr[$count] = $renewalLogs;
						$rcount = $rcount + 1;
					}
					
					$count++;
				}
		
				$conn = null;
				$selectStmt = null;
		
				$allrenewalLogArr = array (
					"renewalLogs" => $renewalLogArr,
					"logs" => $rcount,
					"message" => "success"
				);
			}else{
				$allrenewalLogArr = array (
					"message" => "nolog"
				);
			}
			
			return $allrenewalLogArr;
			
		} catch ( PDOException $e ) {
			$conn = null;
			$selectStmt = null;
			print $e->getMessage ();
			return null;
		}
	}
	
	function searchRenewalUsers(){
		try {
		
			$counter = 0;
			$dbutil = new DBUtil ();
			
			$conn = $dbutil->getPDOConnection ();
			
			$query = "select user_no, user_type , first_name , last_name, company_name , login_id ,
		registered_on , updated_on , address , country , state , city , pin , email , mobile , landline , isdeleted ,
		version , isactive , vfc ,img_dir,status,profile_img,login_id_encoded,confirmed_user, is_admin, view_permission, insert_permission, 
		update_permission, delete_permission, mail_permission, designation, username, senior_email1, senior_email2 from user";
			
			$selectStmt = $conn->prepare ( $query );
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
						"firstName" => $row ["first_name"],
						"lastName" => $row ["last_name"],
						"companyName" => $company_name,
						"designation" => $row ["designation"],
						"userName" => $row ["username"],
						"seniorEmail1" => $row["senior_email1"],
						"seniorEmail2" => $row["senior_email2"],
						"isAdmin" => $row ["is_admin"],
						"viewPermission" => $row ["view_permission"],
						"insertPermission" => $row ["insert_permission"],
						"updatePermission" => $row ["update_permission"],
						"deletePermission" => $row ["delete_permission"],
						"mailPermission" => $row ["mail_permission"],
						"loginId" => $row ["email"],
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
				
				$userArr[$counter] = $user;
				$counter++;
			}
			
			$conn = null;
			$selectStmt = null;
		
			$allrenewalUserArr = array (
					"renewalUsers" => $userArr,
					"message" => "success"
			);
			
			return $allrenewalUserArr;

		} catch ( PDOException $e ) {
			$conn = null;
			$selectStmt = null;
			print $e->getMessage ();
			return null;
		}	
	}
	
function searchRenewalEmailAccounts(){
		try {
		
			$counter = 0;
			$dbutil = new DBUtil ();
			
			$conn = $dbutil->getPDOConnection ();
			
			$query = "select * from emailaccounts";
			
			$selectStmt = $conn->prepare ( $query );
			$selectStmt->execute ();
			
			$emailAccountsArr = array ();
			
			while ( $row = $selectStmt->fetch () ) {
				// $user = array();
				
				$emailAccount = array (
						"id" => $row ["id"],
						"firstName" => $row["firstName"],
						"lastName" => $row["lastName"],
						"designation" => $row["designation"],
						"emailId" => $row["email_id"]
						);
				
				$emailAccountsArr[$counter] = $emailAccount;
				$counter++;
			}
			
			$conn = null;
			$selectStmt = null;
		
			$allrenewalEmailAccountsArr = array (
					"renewalEmailAccounts" => $emailAccountsArr,
					"message" => "success"
			);
			
			return $allrenewalEmailAccountsArr;

		} catch ( PDOException $e ) {
			$conn = null;
			$selectStmt = null;
			print $e->getMessage ();
			return null;
		}	
	}
	
	function searchRecords($user,$userType,$searchCatagory,$query1){
		try {
		
			$dbutil = new DBUtil ();
	
			$conn = $dbutil->getPDOConnection ();
			
			$query = "%".$query1."%";
			
			if ($userType == "admin"){
				if($searchCatagory == "catagory")
	        	{
	            	$queryStr = "select id,category,subcategory,description,model,supplier_name,
						amount,gst,supplier_email,supplier_contact,location,purchase_date,expiry_date,contract_no,comment,reminder_before,datediff(expiry_date,CURDATE())as
						remainingdays,submited_on,mail_to_supplier,filepath,user,username,mail_sent_to_senior,current_status from renewalservice WHERE category like :query";
	        	}
	        	else if($searchCatagory == "subcatagory")
	        	{
	             	$queryStr = "select id,category,subcategory,description,model,supplier_name,
						amount,gst,supplier_email,supplier_contact,location,purchase_date,expiry_date,contract_no,comment,reminder_before,datediff(expiry_date,CURDATE())as
						remainingdays,submited_on,mail_to_supplier,filepath,user,username,mail_sent_to_senior,current_status from renewalservice WHERE subcategory like :query";
	        	}
	        	else if($searchCatagory == "description")
	        	{
	             	$queryStr = "select id,category,subcategory,description,model,supplier_name,
						amount,gst,supplier_email,supplier_contact,location,purchase_date,expiry_date,contract_no,comment,reminder_before,datediff(expiry_date,CURDATE())as
						remainingdays,submited_on,mail_to_supplier,filepath,user,username,mail_sent_to_senior,current_status from renewalservice WHERE description like :query";
	        	}
	        	else if($searchCatagory == "supplier")
	        	{
	             	$queryStr = "select id,category,subcategory,description,model,supplier_name,
						amount,gst,supplier_email,supplier_contact,location,purchase_date,expiry_date,contract_no,comment,reminder_before,datediff(expiry_date,CURDATE())as
						remainingdays,submited_on,mail_to_supplier,filepath,user,username,mail_sent_to_senior,current_status from renewalservice WHERE supplier_name like :query";
	        	}
	        	else if($searchCatagory == "expirydate")
	        	{
	            	// $query = addslashes ( trim ( $query ) );
					// date_default_timezone_set('UTC');
	            	// $query = strtotime($query);   
	             	$queryStr = "select id,category,subcategory,description,model,supplier_name,
						amount,gst,supplier_email,supplier_contact,location,purchase_date,expiry_date,contract_no,comment,reminder_before,datediff(expiry_date,CURDATE())as
						remainingdays,submited_on,mail_to_supplier,filepath,user,username,mail_sent_to_senior,current_status from renewalservice WHERE expiry_date like :query";
	        	}
	        	
				$selectStmt = $conn->prepare ( $queryStr );
				$selectStmt->bindParam(":query",$query,PDO::PARAM_STR);
			}else{
				if($searchCatagory == "catagory")
	        	{
	            
			    	$queryStr = "select id,category,subcategory,description,model,supplier_name,
						amount,gst,supplier_email,supplier_contact,location,purchase_date,expiry_date,contract_no,comment,reminder_before,datediff(expiry_date,CURDATE())as
						remainingdays,submited_on,mail_to_supplier,filepath,user,username,mail_sent_to_senior,current_status from renewalservice WHERE  user=:user_no and category like :query";
	        	}
	        	else if($searchCatagory == "subcatagory")
	        	{
	            	 $queryStr = "select id,category,subcategory,description,model,supplier_name,
						amount,gst,supplier_email,supplier_contact,location,purchase_date,expiry_date,contract_no,comment,reminder_before,datediff(expiry_date,CURDATE())as
						remainingdays,submited_on,mail_to_supplier,filepath,user,username,mail_sent_to_senior,current_status from renewalservice WHERE  user=:user_no and subcategory like :query";
	        	}
	        	else if($searchCatagory == "description")
	        	{
	            	 $queryStr = "select id,category,subcategory,description,model,supplier_name,
						amount,gst,supplier_email,supplier_contact,location,purchase_date,expiry_date,contract_no,comment,reminder_before,datediff(expiry_date,CURDATE())as
						remainingdays,submited_on,mail_to_supplier,filepath,user,username,mail_sent_to_senior,current_status from renewalservice WHERE  user=:user_no and description like :query";
	        	}
	        	else if($searchCatagory == "supplier")
	        	{
	             	$queryStr = "select id,category,subcategory,description,model,supplier_name,
						amount,gst,supplier_email,supplier_contact,location,purchase_date,expiry_date,contract_no,comment,reminder_before,datediff(expiry_date,CURDATE())as
						remainingdays,submited_on,mail_to_supplier,filepath,user,username,mail_sent_to_senior,current_status from renewalservice WHERE  user=:user_no and supplier_name like :query";
	        	}
	        	else if($searchCatagory == "expirydate")
	        	{
	            	// $query = addslashes ( trim ( $query ) );
					// date_default_timezone_set('UTC');
	            	// $query = strtotime($query);   
	             	$queryStr = "select id,category,subcategory,description,model,supplier_name,
						amount,gst,supplier_email,supplier_contact,location,purchase_date,expiry_date,contract_no,comment,reminder_before,datediff(expiry_date,CURDATE())as
						remainingdays,submited_on,mail_to_supplier,filepath,user,username,mail_sent_to_senior,current_status from renewalservice WHERE  user=:user_no and expiry_date like :query";
	        	}
			
				$selectStmt = $conn->prepare ( $queryStr );
				$selectStmt->bindParam(":user_no",$user,PDO::PARAM_STR);
				$selectStmt->bindParam(":query",$query,PDO::PARAM_STR);			
			}
	
			$selectStmt->execute ();
	
			$renewalServiceArr = array ();
			$count = 0;
				
			while ( $row = $selectStmt->fetch () ) {
				// $user = array();
				$exe = $row['expiry_date'];
				$renewalService = array (
						"id" => $row ["id"],
						"category" => $row ["category"],
						"subcategory" => $row ["subcategory"],
						"description" => $row ["description"],
						"model" => $row ["model"],
						"supplierName" => $row ["supplier_name"],
						"amount" => $row ["amount"],
						"gst" => $row["gst"],
						"supplierEmail" => $row ["supplier_email"],
						"supplierContact" => $row["supplier_contact"],
						"expiryDate" => $row ["expiry_date"],
						"location" => $row ["location"],
						"contractNo" => $row ["contract_no"],
						"comment" => $row ["comment"],
						"reminderBefore" => $row ["reminder_before"],
						"filepath" => $row ["filepath"],
						"submitedOn" => $row ["submited_on"],
						"remainingDays" => $row ["remainingdays"],
						"mailtosupplier" => $row ["mail_to_supplier"],
						"mailSentToSenior" => $row["mail_sent_to_senior"],
						"currentStatus" => $row["current_status"],
						"userNo" => $row ["user"]
	
				);
	
				$renewalServiceArr[$count] = $renewalService;
				$count++;
			}
	
			$conn = null;
			$selectStmt = null;
	
			$allrenewalServiceArr = array (
					"renewalServices" => $renewalServiceArr,
					"message" => "success"
			);
				
		    return $allrenewalServiceArr;
				
		} catch ( PDOException $e ) {
			$conn = null;
			$selectStmt = null;
			print $e->getMessage ();
			return null;
		}
	}
	
	function getAllRenewalServices(){
		try {
		
			$dbutil = new DBUtil ();
	
			$conn = $dbutil->getPDOConnection ();
	
			$query = "select category,subcategory,description,model,supplier_name,
					amount,supplier_email,location,purchase_date,expiry_date,contract_no,comment,reminder_before,user,datediff(expiry_date,CURDATE())as
					remainingdays,filepath,first_name,email,mobile,submited_on,mail_to_supplier
					from renewalservice as r join user as u on u.user_no = r.user  WHERE datediff(expiry_date,CURDATE()) ";
			
			// 		echo $query;
			$selectStmt = $conn->prepare ( $query );
	
			$selectStmt->execute ();
	
			$renewalServiceArr = array ();
			$count = 0;
				
			while ( $row = $selectStmt->fetch () ) {
				// $user = array();
				$renewalService = array (
						"category" => $row ["category"],
						"subcategory" => $row ["subcategory"],
						"description" => $row ["description"],
						"model" => $row ["model"],
						"supplierName" => $row ["supplier_name"],
						"amount" => $row ["amount"],
						"supplierEmail" => $row ["supplier_email"],
						"location" => $row ["location"],
						"purchaseDate" => $row ["purchase_date"],
						"expiryDate" => $row ["expiry_date"],
						"contractNo" => $row ["contract_no"],
						"comment" => $row ["comment"],
						"reminderBefore" => $row ["reminder_before"],
						"filepath" => $row ["filepath"],
						"user" => $row ["first_name"],
						"submitedOn" => $row ["submited_on"],
						"remainingDays" => $row ["remainingdays"],
						"email" => $row ["email"],
						"mobile" => $row ["mobile"],
						"mailtosupplier" => $row ["mail_to_supplier"],
						"userNo" => $row ["user"]
	
				);
	
				$renewalServiceArr[$count] = $renewalService;
				$count++;
			}
	
			$conn = null;
			$selectStmt = null;
	
			$allrenewalServiceArr = array (
					"renewalServices" => $renewalServiceArr,
					"message" => "success"
			);
				
			return $allrenewalServiceArr;
				
		} catch ( PDOException $e ) {
			$conn = null;
			$selectStmt = null;
			print $e->getMessage ();
			return null;
		}
	}
	
	function getUserType ($userNo)
	{
	
	    $dbutil = new DBUtil ();
	
		$conn = $dbutil->getPDOConnection ();
	
		$query = "select user_type from user_payment_status WHERE user=:user";
	
		$selectStmt = $conn->prepare ( $query );
	
		$selectStmt->bindParam ( ':user', $userNo, PDO::PARAM_STR );
				
		$selectStmt->execute ();
		
		while ($row = $selectStmt->fetch())
		{
		    $userType = $row ["user_type"];
		}
		
		return $userType;
	}
	
	function getAllRenewalServicesCount($user,$userType){
	
		$user = addslashes ( trim ( $user ) );
	
		try {
		
			$dbutil = new DBUtil ();
	
			$conn = $dbutil->getPDOConnection ();
	
			if ($userType == "admin"){
				$query = "select count(*) as total, category from renewalservice group by category ";
				$selectStmt = $conn->prepare ( $query );
			}else{
				$query = "select count(*) as total, category from renewalservice WHERE user=:user group by category ";
				$selectStmt = $conn->prepare ( $query );
				$selectStmt->bindParam ( ':user', $user, PDO::PARAM_STR );
			}
				
			$selectStmt->execute ();
	
			$renewalServiceArr = array ();
			$count = 0;
			$totalServices = 0;
			
			while ( $row = $selectStmt->fetch () ) {
				// $user = array();
				$total = $row ["total"];
				$renewalService = array (
						"count" => $total,
						"category" => $row ["category"]
						
				);
				$totalServices = $totalServices + $total;
				$renewalServiceArr[$count] = $renewalService;
				$count++;
			}
	
			$conn = null;
			$selectStmt = null;
	

			$allrenewalServiceArr = array (
					"renewalServices" => $renewalServiceArr,
					"totalServices" => $totalServices,
					"message" => "success"
			);
				
			return $allrenewalServiceArr;
		} catch ( PDOException $e ) {
			$conn = null;
			$selectStmt = null;
			print $e->getMessage ();
			return null;
		}
	}
	
	function searchServicesByDate(){
		
// 		select expiry_date,CURDATE(), datediff(expiry_date,CURDATE() ) AS DAYS from renewalservice
// 		select expiry_date,CURDATE(),  reminder_before,datediff(expiry_date,CURDATE()) from renewalservice where datediff(expiry_date,CURDATE())  <= reminder_before and reminder_before = 15
// 		select expiry_date,CURDATE(),  reminder_before,datediff(expiry_date,CURDATE()) from renewalservice where datediff(expiry_date,CURDATE())  <= reminder_before and reminder_before = 15
	// input page no, limit
	}
	
	
	function deleteRecord($recordid){
		try {
		
			$dbutil = new DBUtil ();
		
			$conn = $dbutil->getPDOConnection ();
		
			$query = "delete  FROM renewalservice where id=:id ";
		
			$deleteStmt = $conn->prepare ( $query );
		
			$deleteStmt->bindParam ( ':id', $recordid, PDO::PARAM_STR );
		
			$deleteStmt->execute ();
			
			return "success";
		}
		catch ( PDOException $e ) {
			$conn = null;
			$selectStmt = null;
			print $e->getMessage ();
			return "failed";
		}
	}
	
	function deleteRecord1($recordid,$userName,$userEmail,$userNo,$catagory,$subCat){
		try {
		    $alloted = 0;
			$dbutil = new DBUtil ();		
			
			$conn = $dbutil->getPDOConnection ();
			
				/*$registeredDate = "";
				$selectStmt = $conn->prepare("select * from validator");
				$selectStmt->execute();
				
			 	while ($row = $selectStmt->fetch()){
			 		$registeredDate = $row ["startdate"];
			 	}
				
				$datetime1 = new DateTime($registeredDate);
				$datetime2 = new DateTime();
				$interval = $datetime1->diff($datetime2);
				$days =  $interval->format('%a');
				if ($days > 15){
					return "expired";
				} */
	
			$query = "delete  FROM renewalservice where id=:id ";
	
			$deleteStmt = $conn->prepare ( $query );
	
			$deleteStmt->bindParam ( ':id', $recordid, PDO::PARAM_STR );
	
			$deleteStmt->execute ();
			
			$this->createLog($userNo,"RcrdDeleted",$recordid,"Record has been deleted!");
			
			//$contactService = new ContactService();
			//$msg = $contactService->sendEmailAndSms_delRecord($userName,$userEmail,$catagory,$subCat);
				
				
			return "success";
		}
		catch ( PDOException $e ) {
			$conn = null;
			$selectStmt = null;
			print $e->getMessage ();
			return "failed";
		}
	}
	function deleteUser($userId,$user){
		try {
		
			$dbutil = new DBUtil ();
	
			$conn = $dbutil->getPDOConnection ();
			
			if ($userId == $user->userNo)
			{
				return "currentUser";
			}
	
			$query = "delete FROM user where user_no=:userNo ";
	
			$deleteStmt = $conn->prepare ( $query );
	
			$deleteStmt->bindParam ( ':userNo', $userId, PDO::PARAM_STR );
	
			$deleteStmt->execute ();
			
			$this->createLog($user->userNo,"UserDeleted",$userId,"User has been removed!");
			
			return "success";
		}
		catch ( PDOException $e ) {
			$conn = null;
			$selectStmt = null;
			print $e->getMessage ();
			return "failed";
		}
	}
	function deleteEmailAccount($emailAccountId,$user){
		try {
			$dbutil = new DBUtil ();
	
			$conn = $dbutil->getPDOConnection ();
	
			$query = "delete FROM emailaccounts where id=:id ";
	
			$deleteStmt = $conn->prepare ( $query );
	
			$deleteStmt->bindParam ( ':id', $emailAccountId, PDO::PARAM_STR );
	
			$deleteStmt->execute ();
			
			$this->createLog($user->userNo,"EmailAccountDeleted",$emailAccountId,"Email Account has been removed!");
			
			return "success";
		}
		catch ( PDOException $e ) {
			$conn = null;
			$selectStmt = null;
			print $e->getMessage ();
			return "failed";
		}
	}
	function updateRecord($_FILESArr,$recordid,$entity,$description1,$model1,$supplierName1,$amount1,$gst1,$supplierEmail1,$supplierContact1,$location1,$purchaseDate1,$expiryDate1,$contractNo1,$reminderBefore1,$escalationMail,$escalationStart,$fileAttached1,$fileName1,$daysDiff1,$user){
		try {
		
			$this->uploadFiles($_FILESArr,$user->imgDir);
		    $recordId = $recordid;
		    /*$daysDiff = $daysDiff1;
		    $result = $this->validPeriodToUpdate ($recordId , $daysDiff);
		    if($result == "NTAVAIL")
		    {
		        return "NO";
		        exit;
		    }*/
		    
		    $entity = addslashes ( trim ($entity) );
		    $description = addslashes ( trim ($description1));
		    $model = addslashes ( trim ($model1));
		    $supplierName = addslashes ( trim ($supplierName1));
		    $supplierEmail = addslashes ( trim ($supplierEmail1));
		    $supplierContact = addslashes ( trim ($supplierContact1) );
		    $amount = addslashes ( trim ($amount1));
		    $gst = addslashes ( trim ($gst1) );
		    $location = addslashes ( trim ($location1));
		    $purchaseDate = addslashes ( trim ($purchaseDate1));
		    $expiryDate = addslashes ( trim ($expiryDate1));
		    $contractNo = addslashes ( trim ($contractNo1));
		    $reminderBefore = addslashes ( trim ($reminderBefore1));
		    $escalationMail = addslashes ( trim ($escalationMail) );
		    $escalationStart = addslashes ( trim ($escalationStart) );
		    date_default_timezone_set('UTC');
		    $purchase_date = strtotime($purchaseDate);
		    $expiry_date = strtotime($expiryDate);
		    
			$dbutil = new DBUtil ();
	
			$conn = $dbutil->getPDOConnection ();
			
				/*$registeredDate = "";
				$selectStmt = $conn->prepare("select * from validator");
				$selectStmt->execute();
				
			 	while ($row = $selectStmt->fetch()){
			 		$registeredDate = $row ["startdate"];
			 	}
				
				$datetime1 = new DateTime($registeredDate);
				$datetime2 = new DateTime();
				$interval = $datetime1->diff($datetime2);
				$days =  $interval->format('%a');
				if ($days > 15){
					return "expired";
				} */
			if ($fileAttached1 == "YES"){
				$query = "UPDATE renewalservice SET entity=:entity, description=:description, model=:model, 
													supplier_name=:supplierName, amount=:amount, gst=:gst, 
													supplier_email=:supplierEmail, supplier_contact=:supplierContact, location=:location, purchase_date=FROM_UNIXTIME(:purchaseDate), expiry_date=FROM_UNIXTIME(:expiryDate), 
													contract_no=:contractNo, reminder_before=:reminderBefore, escalation_mail=:escalationMail, escalation_start=:escalationStart, filepath=:filepath where id=:id ";
	
				$updateStmt = $conn->prepare ($query);
	
				$updateStmt->bindParam ( ':id', $recordId, PDO::PARAM_STR );
				$updateStmt->bindParam ( ':entity', $entity, PDO::PARAM_STR);
				$updateStmt->bindParam ( ':description', $description, PDO::PARAM_STR );
				$updateStmt->bindParam ( ':model', $model, PDO::PARAM_STR );
				$updateStmt->bindParam ( ':supplierName', $supplierName, PDO::PARAM_STR );
				$updateStmt->bindParam ( ':amount', $amount, PDO::PARAM_STR );
				$updateStmt->bindParam ( ':gst', $gst, PDO::PARAM_STR );
				$updateStmt->bindParam ( ':supplierEmail', $supplierEmail, PDO::PARAM_STR );
				$updateStmt->bindParam ( ':supplierContact', $supplierContact, PDO::PARAM_STR );
				$updateStmt->bindParam ( ':location', $location, PDO::PARAM_STR );
				$updateStmt->bindParam ( ':purchaseDate', $purchase_date, PDO::PARAM_STR );
				$updateStmt->bindParam ( ':expiryDate', $expiry_date, PDO::PARAM_STR );
				$updateStmt->bindParam ( ':contractNo', $contractNo, PDO::PARAM_STR );
				$updateStmt->bindParam ( ':reminderBefore', $reminderBefore, PDO::PARAM_STR );
				$updateStmt->bindParam ( ':escalationMail', $escalationMail, PDO::PARAM_STR);
				$updateStmt->bindParam ( ':escalationStart', $escalationStart, PDO::PARAM_STR);
				$updateStmt->bindParam ( ':filepath', $fileName1, PDO::PARAM_STR);
			}else{
				$query = "UPDATE renewalservice SET entity=:entity, description=:description, model=:model, 
													supplier_name=:supplierName, amount=:amount, gst=:gst, 
													supplier_email=:supplierEmail, supplier_contact=:supplierContact, location=:location, purchase_date=FROM_UNIXTIME(:purchaseDate), expiry_date=FROM_UNIXTIME(:expiryDate), 
													contract_no=:contractNo, reminder_before=:reminderBefore, escalation_mail=:escalationMail, escalation_start=:escalationStart where id=:id ";
	
				$updateStmt = $conn->prepare ($query);
	
				$updateStmt->bindParam ( ':id', $recordId, PDO::PARAM_STR );
				$updateStmt->bindParam ( ':entity', $entity, PDO::PARAM_STR);
				$updateStmt->bindParam ( ':description', $description, PDO::PARAM_STR );
				$updateStmt->bindParam ( ':model', $model, PDO::PARAM_STR );
				$updateStmt->bindParam ( ':supplierName', $supplierName, PDO::PARAM_STR );
				$updateStmt->bindParam ( ':amount', $amount, PDO::PARAM_STR );
				$updateStmt->bindParam ( ':gst', $gst, PDO::PARAM_STR );
				$updateStmt->bindParam ( ':supplierEmail', $supplierEmail, PDO::PARAM_STR );
				$updateStmt->bindParam ( ':supplierContact', $supplierContact, PDO::PARAM_STR );
				$updateStmt->bindParam ( ':location', $location, PDO::PARAM_STR );
				$updateStmt->bindParam ( ':purchaseDate', $purchase_date, PDO::PARAM_STR );
				$updateStmt->bindParam ( ':expiryDate', $expiry_date, PDO::PARAM_STR );
				$updateStmt->bindParam ( ':contractNo', $contractNo, PDO::PARAM_STR );
				$updateStmt->bindParam ( ':reminderBefore', $reminderBefore, PDO::PARAM_STR );
				$updateStmt->bindParam ( ':escalationMail', $escalationMail, PDO::PARAM_STR);
				$updateStmt->bindParam ( ':escalationStart', $escalationStart, PDO::PARAM_STR);
			}
						
			if($updateStmt->execute ())
			{
				$this->createLog($user->userNo,"RcrdUpdated",$recordId,"Record has been updated!");
			    return "success";    
			}
			else
			{
			    return "failed";    
			}
			
		}
		catch ( PDOException $e ) {
			$conn = null;
			$selectStmt = null;
			print $e->getMessage ();
			return "failed";
		}
	}
	
	function updateProcessStatus($recordid,$status){
		try {
		
		    $recordId = $recordid;
		    $status = $status;
		    
			$dbutil = new DBUtil ();
	
			$conn = $dbutil->getPDOConnection ();
	
			$query = "UPDATE renewalservice SET current_status=:currentStatus where id=:id ";
	
			$updateStmt = $conn->prepare ($query);
	
			$updateStmt->bindParam ( ':id', $recordId, PDO::PARAM_STR );
			$updateStmt->bindParam ( ':currentStatus', $status, PDO::PARAM_STR );
	
			if($updateStmt->execute ())
			{
				return "success";    
			}
			else
			{
			    return "failed";    
			}
			
		}
		catch ( PDOException $e ) {
			$conn = null;
			$selectStmt = null;
			print $e->getMessage ();
			return "failed";
		}
	}
	
	function updateEmailAccount($user,$firstName,$lastName,$designation,$emailId,$emailAccountId){
		try {
		
		    $emailAccountId = $emailAccountId;
		    
		    $firstName = addslashes ( trim ($firstName));
		    $lastName = addslashes ( trim ($lastName));
		    $designation = addslashes ( trim ($designation));
		    $emailId = addslashes ( trim ($emailId));
		    
			$dbutil = new DBUtil ();
	
			$conn = $dbutil->getPDOConnection ();
	
			$query = "UPDATE emailaccounts SET firstName=:firstName, lastName=:lastName, 
			email_id=:emailId, designation=:designation WHERE id=:id";
	
			$updateStmt = $conn->prepare ($query);
	
			$updateStmt->bindParam ( ':firstName', $firstName, PDO::PARAM_STR );
			$updateStmt->bindParam ( ':lastName', $lastName, PDO::PARAM_STR );
			$updateStmt->bindParam ( ':designation', $designation, PDO::PARAM_STR );
			$updateStmt->bindParam ( ':emailId', $emailId, PDO::PARAM_STR );
			$updateStmt->bindParam ( ':id', $emailAccountId, PDO::PARAM_STR );
	
			if($updateStmt->execute ())
			{
				$this->createLog($user->userNo,"EmailAccountUpdated",$emailAccountId,"Email Account has been updated!");
			    return "success";    
			}
			else
			{
			    return "failed";    
			}
			
		}
		catch ( PDOException $e ) {
			$conn = null;
			$selectStmt = null;
			print $e->getMessage ();
			return "failed";
		}
	}
	
	function updateUserProfile($userId,$firstName,$lastName,$userName,$seniorEmail1,$seniorEmail2,$designation,$emailId,$isAdminU,$insertPermissionU,$deletePermissionU,$updatePermissionU,$mailPermissionU){
		try {
		
		    $userId = $userId;
		    
		    $firstName = addslashes ( trim ($firstName));
		    $lastName = addslashes ( trim ($lastName));
		    $userName = addslashes ( trim ($userName));
		    $seniorEmail1 = addslashes ( trim ($seniorEmail1) );
		    $seniorEmail2 = addslashes ( trim ($seniorEmail2));
		    $designation = addslashes ( trim ($designation));
		    $emailId = addslashes ( trim ($emailId));
		    $isAdmin = addslashes ( trim ($isAdminU));
		    $insertPermission = addslashes ( trim ($insertPermissionU));
		    $deletePermission = addslashes ( trim ($deletePermissionU));
		    $updatePermission = addslashes ( trim ($updatePermissionU));
		    $mailPermission = addslashes ( trim ($mailPermissionU));
		    
		    if ($this->isUserNameExistUpdate($userName, $userId)){
		    	return "exist";
		    }
		    
			$dbutil = new DBUtil ();
	
			$conn = $dbutil->getPDOConnection ();
	
			$query = "UPDATE user SET first_name=:firstName, last_name=:lastName, 
			email=:emailId, username=:userName,designation=:designation, is_admin=:isAdmin, insert_permission=:insertPermission,
			 delete_permission=:deletePermission, update_permission=:updatePermission, mail_permission=:updatePermission, senior_email1=:seniorEmail1, senior_email2=:seniorEmail2 WHERE user_no=:userNo";
	
			$updateStmt = $conn->prepare ($query);
	
			$updateStmt->bindParam ( ':firstName', $firstName, PDO::PARAM_STR );
			$updateStmt->bindParam ( ':lastName', $lastName, PDO::PARAM_STR );
			$updateStmt->bindParam ( ':userName', $userName, PDO::PARAM_STR );
			$updateStmt->bindParam ( ':designation', $designation, PDO::PARAM_STR );
			$updateStmt->bindParam ( ':emailId', $emailId, PDO::PARAM_STR );
			$updateStmt->bindParam ( ':isAdmin', $isAdmin, PDO::PARAM_STR );
			$updateStmt->bindParam ( ':insertPermission', $insertPermission, PDO::PARAM_STR );
			$updateStmt->bindParam ( ':deletePermission', $deletePermission, PDO::PARAM_STR );
			$updateStmt->bindParam ( ':updatePermission', $updatePermission, PDO::PARAM_STR );
			$updateStmt->bindParam ( ':mailPermission', $mailPermission, PDO::PARAM_STR );
			$updateStmt->bindParam ( ':seniorEmail1', $seniorEmail1, PDO::PARAM_STR );
			$updateStmt->bindParam ( ':seniorEmail2', $seniorEmail2, PDO::PARAM_STR );
			$updateStmt->bindParam ( ':userNo', $userId, PDO::PARAM_STR );
	
			if($updateStmt->execute ())
			{
				$this->createLog($userId,"UserUpdated",$userId,"User has been updated!");
			    return "success";    
			}
			else
			{
			    return "failed";    
			}
			
		}
		catch ( PDOException $e ) {
			$conn = null;
			$selectStmt = null;
			print $e->getMessage ();
			return "failed";
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
	
	function isUserNameExistUpdate($user_name, $user_id) {
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
				
				if ($noOfRows == 1){
					$isUserNameExistStmt = $con->prepare ( 'SELECT count(*) FROM user WHERE username = :username and user_no = :user_no' );
					$isUserNameExistStmt->bindParam ( ':username', $user_name, PDO::PARAM_STR );
					$isUserNameExistStmt->bindParam ( ':user_no', $user_id, PDO::PARAM_STR);
					$isUserNameExistStmt->execute ();
					
					$noOfRows1 = $isUserNameExistStmt->fetchColumn ();
					
					if ($noOfRows1 == 1){
						return False;
					}
					
				}else{
					return true;
				}
				
				$con = null;
			} else {
				$isUserNameExistStmt = null;
				$con = null;
				return false;
			}
		} catch ( PDOException $e ) {
			return false;
		}
	}
	
	function exportInExcel(){
		
	
		$file_ending = "xls";
		//header info for browser
		header("Content-Type: application/xls");
		header("Content-Disposition: attachment; filename=$filename.xls");
		header("Pragma: no-cache");
		header("Expires: 0");
		/*******Start of Formatting for Excel*******/
		//define separator (defines columns in excel & tabs in word)
		$sep = "\t"; //tabbed character
		//start of printing column names as names of MySQL fields
		for ($i = 0; $i < mysql_num_fields($result); $i++) {
			echo mysql_field_name($result,$i) . "\t";
		}
		print("\n");
		//end of printing column names
		//start while loop to get data
		while($row = mysql_fetch_row($result))
		{
			$schema_insert = "";
			for($j=0; $j<mysql_num_fields($result);$j++)
			{
				if(!isset($row[$j]))
					$schema_insert .= "NULL".$sep;
					elseif ($row[$j] != "")
					$schema_insert .= "$row[$j]".$sep;
					else
						$schema_insert .= "".$sep;
			}
			$schema_insert = str_replace($sep."$", "", $schema_insert);
			$schema_insert = preg_replace("/\r\n|\n\r|\n|\r/", " ", $schema_insert);
			$schema_insert .= "\t";
			print(trim($schema_insert));
			print "\n";
		}
		
	}
}