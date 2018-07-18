<?php

include_once('../common/DB.php');
include_once( '../contact/ContactService.php' );
include_once('../service/RenewalSerService.php');

$url = "https://renewalhelp.com/renser/renser/paymentSuccess.php";

session_start();
$user = $_SESSION["user"];
$userObj = json_decode($user);
$userNo = $userObj->userNo;
$userName = $userObj->name;
$userLastName = $userObj->surname;
$userEmail = $userObj->loginId;
$userPinCode = $userObj->pin;
$userAdd = $userObj->addLine;
$userCity = $userObj->city;
$userState = $userObj->state;
$userCountry = $userObj->country;
$userAddress = $userAdd . ", " . $userCity . " - " . $userPinCode . ", " . $userState . ", " . $userCountry; 
if(isset($_REQUEST['totalRecords']) && isset($_REQUEST['totalDays']) && isset($_REQUEST['razorpayPaymentId']) && isset($_REQUEST['todayDate']) && isset($_REQUEST['deleteInfo']) && isset($_REQUEST['pricePerRecord']) && isset($_REQUEST['totalAmount']))
{
    $totalRecords = addslashes ( trim ($_REQUEST['totalRecords']));
    $totalRecordsDuplicate = $totalRecords;
    $totalDays = addslashes ( trim ($_REQUEST['totalDays']));
    $totalMonths = $totalDays / 30;
    $razorpayPaymentId = addslashes ( trim ($_REQUEST['razorpayPaymentId']));
    $deleteInfo = $_REQUEST['deleteInfo'];
    $pricePerRecord = $_REQUEST['pricePerRecord'];
    $totalAmount = $_REQUEST['totalAmount'];
    $userType = "P";
    date_default_timezone_set ( "UTC" );
	$time = date ( "l jS \of F Y h:i:s A" );
	$todayDate = $time;
	$alloted = 0;
	$temp = 0;
    //$expiryDate = strtotime($expiryDate);
    //$todayDate = strtotime($todayDate);
    $dbutil = new DBUtil ();
    $conn = $dbutil->getPDOConnection ();
    
    ////////////////////////////////////////////////////////////////////////////
    ///////////////////////// Billing Part Goes Here ///////////////////////////
    ////////////////////////////////////////////////////////////////////////////
    
    $location = "";
    $bill_no = 0;
    $maha_tax_1 = "CGST @ 9% OUTPUT";
    $maha_tax_2 = "SGST @ 9% OUTPUT";
    $all_ind_tax = "IGST @ 18% OUTPUT";
    
    $selectStmt = $conn->prepare("select gst_no from user where user_no=:userNo");
    $selectStmt->bindParam ( ':userNo' , $userNo , PDO::PARAM_STR);
    $selectStmt->execute();
    
    while ( $row = $selectStmt->fetch())
    {
        $gst = $row ['gst_no'];
    }
    
//    $selectStmt  = $conn->prepare("select state from pincodes where pincode = :pinCode");
//    $selectStmt->bindParam ( ":pinCode" , $userPinCode , PDO::PARAM_STR);
//    $selectStmt->execute();
    
//    while ( $row = $selectStmt->fetch())
//    {
//        $state = $row ['state'];
//    }
    
    if( $gst == "" || $gst == null)
    {
        $tax_type_1 = $maha_tax_1;
        $tax_type_2 = $maha_tax_2;
        $tax_rate_1 = 9;
        $tax_rate_2 = 9;
        $tax_amount_1 = $totalAmount * 9 / 100;
        $tax_amount_2 = $totalAmount * 9 / 100;
        $tax_total_amount = $tax_amount_1 + $tax_amount_2;
        $bill_amount = $totalAmount + $tax_total_amount;
    }
    else
    {
        if ($gst[0] == 2 && $gst[1] == 7)
        {
            $tax_type_1 = $maha_tax_1;
            $tax_type_2 = $maha_tax_2;
            $tax_rate_1 = 9;
            $tax_rate_2 = 9;
            $tax_amount_1 = $totalAmount * 9 / 100;
            $tax_amount_2 = $totalAmount * 9 / 100;
            $tax_total_amount = $tax_amount_1 + $tax_amount_2;
            $bill_amount = $totalAmount + $tax_total_amount;   
        }
        else
        {
            $tax_type_1 = $all_ind_tax;
            $tax_type_2 = " ";
            $tax_rate_1 = 18;
            $tax_rate_2 = 0;
            $tax_amount_1 = $totalAmount * 18 / 100;
            $tax_amount_2 = 0;
            $tax_total_amount = $tax_amount_1 + $tax_amount_2;
            $bill_amount = $totalAmount + $tax_total_amount;
            $location = "OUTMAHA";   
        }
    }
   
    $renewalSerServices = new RenewalSerService();
    $tax_total_amount_in_words = $renewalSerServices->getIndianCurrencyInWords($tax_total_amount);
    $bill_amount_in_words = $renewalSerServices->getIndianCurrencyInWords($bill_amount);
                                                        
    $insertStmt = $conn->prepare("insert into `billing` (bill_no , user_no , bill_date , records_qty , 
                                  rate_per_record , total_amount , tax_type_1 , tax_type_2 , tax_rate_1 , 
                                  tax_rate_2 , tax_amount_1 , tax_amount_2 , tax_total_amount , bill_amount) 
                                  values(:billNo , :userNo , :billDate , :recordsQty , :ratePerRecord , :totalAmount , 
                                  :taxType1 , :taxType2 , :taxRate1 , :taxRate2 , :taxAmount1 , :taxAmount2 , :taxTotalAmount , :billAmount , :paymentId)");
    $insertStmt->bindParam ( ':billNo' , $bill_no , PDO::PARAM_STR);
    $insertStmt->bindParam ( ':userNo' , $userNo , PDO::PARAM_STR);
    $insertStmt->bindParam ( ':billDate' , $todayDate , PDO::PARAM_STR);
    $insertStmt->bindParam ( ':recordsQty' , $totalRecords , PDO::PARAM_STR);
    $insertStmt->bindParam ( ':ratePerRecord' , $pricePerRecord , PDO::PARAM_STR);
    $insertStmt->bindParam ( ':totalAmount' , $totalAmount , PDO::PARAM_STR);
    $insertStmt->bindParam ( ':taxType1' , $tax_type_1 , PDO::PARAM_STR);
    $insertStmt->bindParam ( ':taxType2' , $tax_type_2 , PDO::PARAM_STR);
    $insertStmt->bindParam ( ':taxRate1' , $tax_rate_1 , PDO::PARAM_STR);
    $insertStmt->bindParam ( ':taxRate2' , $tax_rate_2 , PDO::PARAM_STR);
    $insertStmt->bindParam ( ':taxAmount1' , $tax_amount_1 , PDO::PARAM_STR);
    $insertStmt->bindParam ( ':taxAmount2' , $tax_amount_2 , PDO::PARAM_STR);
    $insertStmt->bindParam ( ':taxTotalAmount' , $tax_total_amount , PDO::PARAM_STR);
    $insertStmt->bindParam ( ':billAmount' , $bill_amount , PDO::PARAM_STR);
    $insertStmt->bindParam ( ':paymentId' , $razorpayPaymentId , PDO::PARAM_STR);
    $insertStmt->execute();
    
    $selectStmt = $conn->prepare ("select * from billing");
    $selectStmt->execute();
    $i = 0;
    $bills = array();
    while ($row = $selectStmt->fetch())
    {
        $bills[$i] = $row ['bill_no'];
        $id = $row ['id'];
        $i++;
    }
    $len = sizeof($bills);
    $bill_no = $bills[$len-2];
    $bill_no = $bill_no + 1; 
    
    $updateStmt = $conn->prepare ("UPDATE `billing` SET bill_no=:billNo where id=:id");
    $updateStmt->bindParam ( ":billNo" , $bill_no , PDO::PARAM_STR);
    $updateStmt->bindParam ( ":id" , $id , PDO::PARAM_STR);
    $updateStmt->execute();
    
    if($tax_rate_2 == 0 && $tax_amount == 0)
    {
        $tax_rate_2 = "";
        $tax_amount_2 = "";
    }
    
    ////////////////////////////////////////////////////////////////////////////
    ///////////////////////// Billing Part Ends Here ///////////////////////////
    ////////////////////////////////////////////////////////////////////////////
    
    $i = 0;

    $selectStmt = $conn->prepare( "select user_type from user_payment_status where user=:user_no");
    $selectStmt->bindParam ( ":user_no" , $userNo , PDO::PARAM_STR);
    $selectStmt->execute();
    
    while($row = $selectStmt->fetch())
    {
        $u_type = $row ['user_type'];
    }

    if($u_type == "T")
    {
        if($deleteInfo == "delete")
        {
            $deleteStmt = $conn->prepare( "delete from renewalservice where user=:user_no");
            $deleteStmt->bindParam ( ":user_no" , $userNo , PDO::PARAM_STR);
            $deleteStmt->execute();
        }
        else if($deleteInfo == "not delete")
        {
            $query = "select id , datediff(expiry_date,CURDATE()) as
					remainingdays from renewalservice WHERE user = :user_no";
			
			$selectStmt = $conn->prepare ( $query );
			//echo $query;
			$selectStmt->bindParam ( ':user_no', $userNo, PDO::PARAM_STR );
			$selectStmt->execute ();
			
			$recordsQty = 0;
			$i = 0;
			$allDays = array();
			$allId = array();
			while ( $row = $selectStmt->fetch () ) {
				// $user = array();
				$allDays[$i] = $row ['remainingdays'];
				$allId[$i] = $row ['id'];
				$i++;
			}
			$totalDays =  max($allDays);
			$totalMonths = $totalDays / 30;
			$totalRecords = $i;
			$i =0 ;
        }
    }

    for($i = 0; $i < $totalRecords; $i++)
    {
        if($deleteInfo == "not delete")
        {
            $day_s = $allDays[$i];
            $recordId = $allId[$i];
            $alloted = $recordId;
            $reminder = $day_s % 30;
            if($reminder == 0)
            {
                $insertStmt = $conn->prepare ( "insert into `user_records_info` (user_no,updated_on,remaining_days,alloted,temp) values(:userno,:updatedon,:remainingdays,:alloted,:temp)" );
	            $insertStmt->bindParam ( ':userno', $userNo, PDO::PARAM_STR );
                $insertStmt->bindParam ( ':updatedon', $todayDate, PDO::PARAM_STR );
                $insertStmt->bindParam ( ':remainingdays', $day_s, PDO::PARAM_STR );
                $insertStmt->bindParam ( ':alloted', $alloted, PDO::PARAM_STR );
                $insertStmt->bindParam ( ':temp', $temp, PDO::PARAM_STR );
	            $insertStmt->execute ();
            }
            else
            {
                while($reminder != 0)
                {
                    $day_s++;
                    $reminder = $day_s % 30;
                }
                $insertStmt = $conn->prepare ( "insert into `user_records_info` (user_no,updated_on,remaining_days,alloted,temp) values(:userno,:updatedon,:remainingdays,:alloted,:temp)" );
	            $insertStmt->bindParam ( ':userno', $userNo, PDO::PARAM_STR );
                $insertStmt->bindParam ( ':updatedon', $todayDate, PDO::PARAM_STR );
                $insertStmt->bindParam ( ':remainingdays', $day_s, PDO::PARAM_STR );
                $insertStmt->bindParam ( ':alloted', $alloted, PDO::PARAM_STR );
                $insertStmt->bindParam ( ':temp', $temp, PDO::PARAM_STR );
	            $insertStmt->execute ();
            }
        }
        else
        {
            $insertStmt = $conn->prepare ( "insert into `user_records_info` (user_no,updated_on,remaining_days,alloted,temp) values(:userno,:updatedon,:remainingdays,:alloted,:temp)" );
	        $insertStmt->bindParam ( ':userno', $userNo, PDO::PARAM_STR );
            $insertStmt->bindParam ( ':updatedon', $todayDate, PDO::PARAM_STR );
            $insertStmt->bindParam ( ':remainingdays', $totalDays, PDO::PARAM_STR );
            $insertStmt->bindParam ( ':alloted', $alloted, PDO::PARAM_STR );
            $insertStmt->bindParam ( ':temp', $temp, PDO::PARAM_STR );
	        $insertStmt->execute ();
        }
    }
    
    //select records from user_payment_status and add new plus old record and update data.
    $selectStmt = $conn->prepare ("SELECT no_of_records FROM user_payment_status WHERE user=:user_no");
    $selectStmt->bindParam ( ':user_no', $userNo, PDO::PARAM_STR );
    $selectStmt->execute();
    
    while($row = $selectStmt->fetch())
    {
        $noOfRecords = $row ['no_of_records'];
    }
    
    if($u_type == "P")
    {
        $totalRecords = $totalRecords + $noOfRecords;
    }
    
    $stmt = $conn->prepare ( "UPDATE `user_payment_status` SET updated_on=:today_date, no_of_months=:total_months, remaining_days=:total_days, 
			no_of_records=:total_records, user_type=:user_type where user=:user_no " );
			
	$stmt->bindParam ( ':today_date', $todayDate, PDO::PARAM_STR );
	$stmt->bindParam ( ':total_months', $totalMonths, PDO::PARAM_STR );
	$stmt->bindParam ( ':total_days', $totalDays, PDO::PARAM_STR );
	$stmt->bindParam ( ':total_records', $totalRecords, PDO::PARAM_STR );
    $stmt->bindParam ( ':user_no', $userNo, PDO::PARAM_STR );
    $stmt->bindParam ( ':user_type', $userType, PDO::PARAM_STR );
    
    if($stmt->execute ())
	{   
	        $contactService = new ContactService();
		    $msg1 = $contactService->sendEmail_paymentConfirmation($userName,$userEmail,$totalRecords,$totalMonths,$totalDays,$expiryDate,$razorpayPaymentId);
		    $msg = $contactService->sendEmail_invoiceToCustomer($userName , $userLastName, $location , $userEmail , $userAddress , $bill_no , $todayDate , 
                                                        $totalRecordsDuplicate , $pricePerRecord , $totalAmount , $tax_type_1 , 
                                                        $tax_type_2 , $tax_rate_1 , $tax_rate_2 , $tax_amount_1 , $tax_amount_2 , $tax_total_amount , $bill_amount , $tax_total_amount_in_words , $bill_amount_in_words);
    
		    echo $msg;
	}
	else
	{
	    echo "failed";	   
	}
	
}
else
    echo "Request No Set!";

?>