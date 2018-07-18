<?php
include_once( '../contact/ContactService.php' );
include_once( '../contact/ContactUtil.php' );
include_once( '../service/RenewalSerService.php' );

try{
	set_time_limit(0);
	$renewalSer = new RenewalSerService();
	$renewalSerList = $renewalSer->getAllRenewalServices();

	$renewalSerArr = $renewalSerList["renewalServices"];
	$contactService = new ContactService();

	$length = count($renewalSerArr);
	$custList = "";
	echo "LEngth:".$length;
	for($i = 0; $i<$length;$i++){
		
		
		$category = $renewalSerArr[$i] ["category"];
		$subcategory = $renewalSerArr[$i]  ["subcategory"];
		$supplierName = $renewalSerArr[$i]  ["supplierName"];
		$supplierEmail = $renewalSerArr[$i]  ["supplierEmail"];
		$expirydate = $renewalSerArr[$i]  ["expiryDate"];
		$contractNo = $renewalSerArr[$i]  ["contractNo"];
		$reminderBefore = $renewalSerArr[$i] ["reminderBefore"];
		$userName = $renewalSerArr[$i]  ["user"];
		$dateRemaining = $renewalSerArr[$i]  ["remainingDays"];
		$useremail = $renewalSerArr[$i]  ["email"];
		$mobile = $renewalSerArr[$i] ["mobile"];
		$mailToSupplier = $renewalSerArr[$i] ["mailtosupplier"];
		$userNo = $renewalSerArr[$i] ["userNo"];
		$custList = $custList . $userName."::" .$useremail." <br> ";
		//echo $dateRemaining ."".$useremail;
		
		if($dateRemaining <= $reminderBefore)
		{
		    if($dateRemaining==90 || $dateRemaining==65 || $dateRemaining ==45 ||$dateRemaining==25
			    	||$dateRemaining==10||$dateRemaining==5||$dateRemaining==3||$dateRemaining==1){
			
			    $userType = $renewalSer->getUserType($userNo);
			    
			    if($userType == "E")
			    {
			        
			    }
			    else
			    {
			        $msgText = "Dear ".$userName.", your record of category-".$category." and subcategory-".$subcategory." is going to expire on ".$expirydate."";
			        echo $dateRemaining;
			        $contactService->sendEmail_reminder($useremail, "Reminder",$userName,$category,$subcategory,$expirydate,
					                   $dateRemaining,$supplierName,$supplierEmail,$contractNo,$mailToSupplier);
					$contactService->sendSMS($mobile,$msgText);
			    }
	        }
		}
		
	}
	}catch (Exception $e){
	echo "Error:".$e->getMessage();
}


