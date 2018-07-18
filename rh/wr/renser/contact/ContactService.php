<?php
include_once('ContactUtil.php');
class ContactService {

	function sendEmailAndSms_registration_old($name,$vfc,$contactNumber,$emailid)
	{
		$emailMessage = '<body>
<p>Welcome  '.$name.',</p>
<p>Thanks for joining <a href="renewalhelp.com" target="_blank" >renewalhelp.com</a>.</p>
<p>Your health is valuable for us .</p>
<p>We hope this place will help you to take right decision for your health.</p>
<p>We wish you good health and happiness in life.</p>
<p>Please login to your account to manage your health reports.</p>
<p>You need to activate your account by submitting verification code just after your first login.<br />
    <br />
  Your verification code is '.$vfc.' .<br />
</p>
<p>Thanks and regards,<br />
  renewalhelp.com</p>
<p>&nbsp;</p>
<p>Note: You have received this mail because you have been registered on <a href="renewalhelp.com" target="_blank" >renewalhelp.com</a>.</p>
<p>If you are not registered your e-Mail id then please send us mail to our support  &quot;support@renewalhelp.com&quot; with subject &quot;Not registered&quot; .</p>
<p>&nbsp; </p>
</body>';
		
		$emailSubject = 'Welcome to renewalhelp.com !';
		$smsMessage = 'Dear '.$name. '! Welcome to renewalhelp.com. Your verification code is '.$vfc.'';
				
				
		$contactUtil = new ContactUtil();
		//if($contactNumber!=null && $contactNumber!=""){
		//	$contactUtil->sendSMS($contactNumber,$smsMessage);
		//}
		
		if($emailid!=null && $emailid!=""){
			//$contactUtil->sendMail($name, $emailid,$emailSubject, $emailMessage);
			$contactUtil->sendMail_sendMailWithSwift($name, $emailid,$emailSubject, $emailMessage);
		}
	}
	
	function sendEmailAndSms_registration($name,$vfc,$contactNumber,$emailid)
	{
		$emailMessage = '<body>
<p>Welcome  '.$name.',</p>
<p>Thanks for joining <a href="renewalhelp.com" target="_blank" >renewalhelp.com</a>.</p>
<p>Your health is valuable for us .</p>
<p>We hope this place will help you to take right decision for your health.</p>
<p>We wish you good health and happiness in life.</p>
<p>Please login to your account to manage your health reports.</p>
<p>You need to activate your account by submitting verification code just after your first login.<br />
    <br />
  Your verification code is '.$vfc.' .<br />
</p>
<p>Thanks and regards,<br />
  renewalhelp.com</p>
<p>&nbsp;</p>
<p>Note: You have received this mail because you have been registered on <a href="renewalhelp.com" target="_blank" >renewalhelp.com</a>.</p>
<p>If you are not registered your e-Mail id then please send us mail to our support  &quot;support@renewalhelp.com&quot; with subject &quot;Not registered&quot; .</p>
<p>&nbsp; </p>
</body>';
	
		$emailSubject = 'Welcome to renewalhelp.com !';
		$smsMessage = 'Dear '.$name. '! Welcome to renewalhelp.com. Your verification code is '.$vfc.'';
	
	
		$contactUtil = new ContactUtil();
		if($contactNumber!=null && $contactNumber!=""){
			//$contactUtil->sendSMS($contactNumber,$smsMessage);
		}
	
		if($emailid!=null && $emailid!=""){
			//$contactUtil->sendMail($name, $emailid,$emailSubject, $emailMessage);
// 			$contactUtil->sendMail_sendMailWithSwift($name, $emailid,$emailSubject, $emailMessage);
			$contactUtil->sendMail_WelcomeToUserWithSwift($name, $emailid, $emailSubject);
		}
	}
	
	
	function sendEmailAndSms_registrationCompany($name,$vfc,$contactNumber,$emailid)
	{
		$emailMessage = '<body>
<p>Welcome  '.$name.',</p>
<p>Thanks for joining <a href="renewalhelp.com" target="_blank" >renewalhelp.com</a>.</p>
<p>Your health is valuable for us .</p>
<p>We hope this place will help you to take right decision for your health.</p>
<p>We wish you good health and happiness in life.</p>
<p>Please login to your account to manage your health reports.</p>
<p>You need to activate your account by submitting verification code just after your first login.<br />
    <br />
  Your verification code is '.$vfc.' .<br />
</p>
<p>Thanks and regards,<br />
  renewalhelp.com</p>
<p>&nbsp;</p>
<p>Note: You have received this mail because you have been registered on <a href="renewalhelp.com" target="_blank" >renewalhelp.com</a>.</p>
<p>If you are not registered your e-Mail id then please send us mail to our support  &quot;support@renewalhelp.com&quot; with subject &quot;Not registered&quot; .</p>
<p>&nbsp; </p>
</body>';
	
		$emailSubject = 'Welcome to renewalhelp.com !';
		$smsMessage = 'Dear '.$name. '! Welcome to renewalhelp.com. Your verification code is '.$vfc.'';
	
	
		$contactUtil = new ContactUtil();
		if($contactNumber!=null && $contactNumber!=""){
			//$contactUtil->sendSMS($contactNumber,$smsMessage);
		}
	
		if($emailid!=null && $emailid!=""){
			//$contactUtil->sendMail($name, $emailid,$emailSubject, $emailMessage);
			// 			$contactUtil->sendMail_sendMailWithSwift($name, $emailid,$emailSubject, $emailMessage);
			$contactUtil->sendMail_WelcomeToComapnyWithSwift($name, $emailid, $emailSubject);
		}
	}
	
	function sendEmailAndSms_registrationCompanyUser($name,$vfc,$contactNumber,$emailid,$company_name)
	{
		$emailMessage = '<body>
<p>Welcome  '.$name.',</p>
<p>Thanks for joining <a href="renewalhelp.com" target="_blank" >renewalhelp.com</a>.</p>
<p>Your health is valuable for us .</p>
<p>We hope this place will help you to take right decision for your health.</p>
<p>We wish you good health and happiness in life.</p>
<p>Please login to your account to manage your health reports.</p>
<p>You need to activate your account by submitting verification code just after your first login.<br />
    <br />
  Your verification code is '.$vfc.' .<br />
</p>
<p>Thanks and regards,<br />
  renewalhelp.com</p>
<p>&nbsp;</p>
<p>Note: You have received this mail because you have been registered on <a href="renewalhelp.com" target="_blank" >renewalhelp.com</a>.</p>
<p>If you are not registered your e-Mail id then please send us mail to our support  &quot;support@renewalhelp.com&quot; with subject &quot;Not registered&quot; .</p>
<p>&nbsp; </p>
</body>';
	
		$emailSubject = 'Welcome to renewalhelp.com !';
		$smsMessage = 'Dear '.$name. '! Welcome to renewalhelp.com. Your verification code is '.$vfc.'';
	
	
		$contactUtil = new ContactUtil();
		if($contactNumber!=null && $contactNumber!=""){
			//$contactUtil->sendSMS($contactNumber,$smsMessage);
		}
	
		if($emailid!=null && $emailid!=""){
			//$contactUtil->sendMail($name, $emailid,$emailSubject, $emailMessage);
			// 			$contactUtil->sendMail_sendMailWithSwift($name, $emailid,$emailSubject, $emailMessage);
			$contactUtil->sendMail_WelcomeToComapnyUserWithSwift($name, $emailid, $emailSubject,$company_name);
		}
	}
	
	function sendEmailAndSms_resetPassword($contactNumber,$emailid){
		
		
		$emailMessage = '

<body>
<p>Dear ,</p>
<p>You have successfully reset your password for <a href="renewalhelp.com" target="_blank"> renewalhelp.com </a>.</p>
<p>Please reply back if you have not initiate this activity.</p>
<p>Thanks and regards,<br />
  renewalhelp.com</p>
<p>&nbsp;</p>
<p>Note: You have received this mail because you have been registered on <a href="renewalhelp.com" target="_blank" >renewalhelp.com</a>.</p>
<p>If you are not registered your e-Mail id then please send us mail to our support  &quot;support@renewalhelp.com&quot; with subject &quot;Not registered&quot; .</p>
<p>&nbsp; </p>
</body>';
		
		$emailSubject = 'Password reset successfully !';
		
		$smsMessage = 'Dear, You have successfully reset your password on renewalhelp.com ';
		
		
// 		$contactUtil->sendMail($name, $emailid, "Hello, User ! You have updated your password ");
// 		$contactUtil->sendSMS($contactNumber, "Hello, User ! You have updated your password ");
		
		$contactUtil = new ContactUtil();
		if($contactNumber!=null && $contactNumber!=""){
			//$contactUtil->sendSMS($contactNumber,$smsMessage);
		}
		
		if($emailid!=null && $emailid!=""){
			$contactUtil->sendMail("", $emailid,$emailSubject, $emailMessage);
		}
		
		
		
	}
	
	function sendEmailAndSms_sendVerificationCode($name,$vfc,$contactNumber,$emailid){

		$emailMessage = '
		<body>
<p>Dear '.$name. ' ,</p>
<p>Your verification code to activate your account on <a href="renewalhelp.com" target="_blank"> renewalhelp.com </a> is '.$vfc.' </p>
<p>Please reply back if you have not initiate this activity.</p>
<p>Thanks and regards,<br />
  renewalhelp.com</p>
<p>&nbsp;</p>
<p>Note: You have received this mail because you have been registered on <a href="renewalhelp.com" target="_blank" >renewalhelp.com</a>.</p>
<p>If you are not registered your e-Mail id then please send us mail to our support  &quot;support@renewalhelp.com&quot; with subject &quot;Not registered&quot; .</p>
<p>&nbsp; </p>
</body>';
		
		$emailSubject = 'Verification code !';
		
		//$smsMessage = 'Dear '.$name. '! Your verification code to activate your account on <a href="renewalhelp.com" target="_blank"> renewalhelp.com </a> is '.$vfc.' ';
		$smsMessage = 'Dear '.$name. '! Your verification code to activate your account on www.renewalhelp.com is '.$vfc.' ';
		
		
		// 		$contactUtil->sendMail($name, $emailid, "Hello, User ! You have updated your password ");
		// 		$contactUtil->sendSMS($contactNumber, "Hello, User ! You have updated your password ");
		
		$contactUtil = new ContactUtil();
		if($contactNumber!=null && $contactNumber!=""){
			//$contactUtil->sendSMS($contactNumber,$smsMessage);
		}
		
		if($emailid!=null && $emailid!=""){
			$contactUtil->sendMail($name, $emailid,$emailSubject, $emailMessage);
		}
		
	}
	
	function sendSMS ($contactNumber,$smsMessage)
	{
	    $contactUtil = new ContactUtil();
		$contactUtil->sendSMS($contactNumber,$smsMessage);
		
	}
	
	function sendEmail_contactUs($username,$useremail,$usermessage){
	
		$usermessage = htmlentities(addslashes(trim($usermessage)));
		
		$subjectToUser = 'Thank you for contacting us.';
		$subjectToRenewalHelp = 'New message from user '.$username.' ('.$useremail.')';
		
		
		
		$contactUtil = new ContactUtil();
		
		if($useremail!=null && $useremail!=""){
// 			$contactUtil->sendMail_ContactUs("Renewalhelp", "contactus@renewal.com", $subjectToRenewalHelp, $usermessage);
// 			$contactUtil->sendMail_ContactUs($name, $useremail, $subjectToUser, $message);
 	//	$contactUtil->sendMail_ContactUsToOwnerWithSwift("Renewalhelp", "contactus@renewalhelp.com", $subjectToRenewalHelp, $usermessage);
			$contactUtil->sendMail_ContactUsToOwnerWithSwift("Renewalhelp", "avinash.shrivastav26@gmail.com", $subjectToRenewalHelp, $usermessage);
			$contactUtil->sendMail_ContactUsToUserWithSwift($username, $useremail, $subjectToUser);
			
		}
	
	}
	
	function sendEmail_ForgotPassword($useremail,$userpassword){
	
		$subjectToUser = 'Forgot password.';
	
		$contactUtil = new ContactUtil();
	
		if($useremail!=null && $useremail!=""){
		    $msg = 	$contactUtil->sendEmail_ForgotPasswordWithSwift($useremail, $userpassword, $subjectToUser);
			return $msg;	
		}
	
	}
	function mailMe($userEmail, $v_name, $v_company, $v_email,$v_mobile,$v_website){
	
		$subjectToUser = 'Vendor Information.';
	
		$contactUtil = new ContactUtil();
	
		if($userEmail!=null && $userEmail!=""){
		    $msg = 	$contactUtil->mailMe($userEmail, $v_name, $v_company, $v_email,$v_mobile,$v_website,$subjectToUser);
			return $msg;	
		}
	
	}
	
	
	function sendEmail_invoiceToCustomer($userName , $userLastName , $location , $userEmail , $userAddress , $bill_no , $todayDate , 
                                        $totalRecords , $pricePerRecord , $totalAmount , $tax_type_1 , 
                                        $tax_type_2 , $tax_rate_1 , $tax_rate_2 , $tax_amount_1 , $tax_amount_2 , $tax_total_amount , $bill_amount , $tax_total_amount_in_words , $bill_amount_in_words)
	{
	    $subjectToUser = 'Invoice';
	    
	    $contactUtil = new ContactUtil();
	    
	    if($userEmail != null && $userEmail != "")
	    {
	        $msg = $contactUtil->sendMail_invoiceToCustomer($subjectToUser , $userName , $userLastName , $location , $userEmail , $userAddress , $bill_no , $todayDate , 
                                                        $totalRecords , $pricePerRecord , $totalAmount , $tax_type_1 , 
                                                        $tax_type_2 , $tax_rate_1 , $tax_rate_2 , $tax_amount_1 , $tax_amount_2 , $tax_total_amount , $bill_amount , $tax_total_amount_in_words , $bill_amount_in_words);
	        return $msg;
	    }
	}
	
    function sendEmail_invoiceToVendor($userName , $userLastName , $location , $userEmail , $userAddress , $bill_no , $todayDate , 
                                        $totalRecords , $pricePerRecord , $totalAmount , $tax_type_1 , 
                                        $tax_type_2 , $tax_rate_1 , $tax_rate_2 , $tax_amount_1 , $tax_amount_2 , $tax_total_amount , $bill_amount , $tax_total_amount_in_words , $bill_amount_in_words)
	{
	    $subjectToUser = 'Invoice';
	    
	    $contactUtil = new ContactUtil();
	    
	    if($userEmail != null && $userEmail != "")
	    {
	        $msg = $contactUtil->sendMail_invoiceToVendor($subjectToUser , $userName , $userLastName , $location , $userEmail , $userAddress , $bill_no , $todayDate , 
                                                        $totalRecords , $pricePerRecord , $totalAmount , $tax_type_1 , 
                                                        $tax_type_2 , $tax_rate_1 , $tax_rate_2 , $tax_amount_1 , $tax_amount_2 , $tax_total_amount , $bill_amount , $tax_total_amount_in_words , $bill_amount_in_words);
	        return $msg;
	    }
	}
	
	function sendEmail_paymentConfirmation($userName,$userEmail,$totalRecords,$totalMonths,$remainedDays,$expiryDate,$razorpayPaymentId)
	{
	    $subjectToUser = 'Payment Confirmation';
	    
	    $contactUtil = new ContactUtil();
	    
	    if($userEmail != null && $userEmail != "")
	    {
	        $msg = $contactUtil->sendMail_aboutPaymentConfirmation($userName,$userEmail,$totalRecords,$totalMonths,$expiryDate,$remainedDays,$razorpayPaymentId,$subjectToUser);
	        return $msg;
	    }
	}
	function sendEmail_paymentConfirmationVendore($name,$email,$paymentId)
	{
	    $subjectToVendore = 'Payment Confirmation';
	    
	    $contactUtil = new ContactUtil();
	    
	    if($email != null && $email != "")
	    {
	        $msg = $contactUtil->sendMail_aboutPaymentConfirmationVendore($name,$email,$paymentId,$subjectToVendore);
	        echo $msg;
	    }
	}
	
	function sendEmail_WelcomeConfirmedUser($userName,$userEmail){
	
		$subjectToUser = 'Lets get started with Renewalhelp!';
	
		$contactUtil = new ContactUtil();
	
		if($userEmail!=null && $userEmail!=""){
			$msg = $contactUtil->sendEmail_WelcomeToConfirmedUser($userName,$userEmail, $subjectToUser);
			return $msg;
		}
	
	}
	
	
	function sendEmail_reminder($useremail, $subject,$userName,$category,$subcategory,$expirydate,
			$dateRemaining,$supplierName,$supplierEmail,$contractNo,$mailToSupplier){
	
		$subjectToUser = 'Reminder';
	
		$contactUtil = new ContactUtil();
	
		if($useremail!=null && $useremail!=""){
			$contactUtil->sendEmail_reminder($useremail, $subject,$userName,$category,$subcategory,$expirydate,
			$dateRemaining,$supplierName,$supplierEmail,$contractNo,$mailToSuppllier);
	
		}
		
		if($mailToSupplier == 1)
		{
		    $contactUtil->sendEmail_reminder_supplier($useremail, $subject,$userName,$category,$subcategory,$expirydate,
			$dateRemaining,$supplierName,$supplierEmail,$contractNo,$mailToSuppllier);
		}
	
	}
	
	function sendEmail_expiryOfVendor($vendorName , $vendorEmail , $days){
	
		$subjectToUser = 'Expiry Alert';
	
		$contactUtil = new ContactUtil();
	
		if($vendorEmail != null && $vendorEmail != ""){
		
		        if ( $days == 1 )
		        {
		            $msg = $contactUtil->sendEmail_expiryOfVendorBeforeOneDay($vendorName , $vendorEmail , $days , $subjectToUser);
	                return $msg;      
		        }
		        else
		        {
		            $msg = $contactUtil->sendEmail_expiryOfVendor($vendorName , $vendorEmail , $days , $subjectToUser);
	                return $msg;
		        }
			   
		}
	}
	
	function sendEmail_reminder_to_owner($useremail, $subject,$userName,$custlist){
	
				$subjectToUser = 'Reminder';
	
				$contactUtil = new ContactUtil();
	
				if($useremail!=null && $useremail!=""){
					$contactUtil->sendEmail_reminder_to_owner($useremail, $subject,$userName,$custlist);
	
				}
	
	}
	

	function sendEmailAndSms_delRecord($userName,$userEmail,$catagory,$subCat){
		$subjectToUser = 'Record Deleted';
		
		$contactUtil = new ContactUtil();
		
		if($userEmail!=null && $userEmail!=""){
			$contactUtil->sendEmailAndSms_delRecord($userName,$userEmail,$catagory,$subCat,$subjectToUser);
		
		}
	}
	
	function sendEmail_UserExpired($userName,$userEmail){
		$subjectToUser = 'Renew Account';
	
		$contactUtil = new ContactUtil();
	
		if($userEmail!=null && $userEmail!=""){
			$contactUtil->sendEmail_UserExpired($userName,$userEmail,$subjectToUser);
	
		}
	}
	
	function sendEmail_UserNearToExpired($userName,$userEmail){
		$subjectToUser = 'Renew Account';
	
		$contactUtil = new ContactUtil();
	
		if($userEmail!=null && $userEmail!=""){
			$contactUtil->sendEmail_UserNearToExpired($userName,$userEmail,$subjectToUser);
	
		}
	}
	
	function sendEmail_3days($userName,$userEmail){
		$subjectToUser = 'Renew Account';
	
		$contactUtil = new ContactUtil();
	
		if($userEmail!=null && $userEmail!=""){
			$contactUtil->sendEmail_3days($userName,$userEmail,$subjectToUser);
	
		}
	}
	
	function sendEmail_7days($userName,$userEmail){
		$subjectToUser = 'Renew Account';
	
		$contactUtil = new ContactUtil();
	
		if($userEmail!=null && $userEmail!=""){
			$contactUtil->sendEmail_7days($userName,$userEmail,$subjectToUser);
	
		}
	}
	
	function sendEmail_13days($userName,$userEmail){
		$subjectToUser = 'Renew Account';
	
		$contactUtil = new ContactUtil();
	
		if($userEmail!=null && $userEmail!=""){
			$contactUtil->sendEmail_13days($userName,$userEmail,$subjectToUser);
	
		}
	}

}