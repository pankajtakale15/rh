<?php
require_once '../lib/swift_required.php';
define("SEND_SMS", "FALSE");
define("SEND_EMAIL", "TRUE");

class ContactUtil {
	

	function sendMail($name,$email,$subject,$bodyMessage)
	{
		
		if(SEND_EMAIL!="TRUE"){
			return false;
		}
		
		$ccMailId3 = 'Renewalhelp<helpdesk@renewalhelp.com>';
		
		$headerMIMEVersion = "MIME-Version: 1.0" . "\r\n";
		$headerContentType = "Content-type:text/html;charset=UTF-8" . "\r\n";
		
		$emailTo = $name.' <'.$email.'>' . "\r\n";
		$headerFrom = 'From: '.$ccMailId3 ."\r\n";
		
		$headers = $headerMIMEVersion . $headerContentType . $headerFrom ;
		
		$retval = mail($emailTo,$subject,$bodyMessage,$headers);
		
		if( $retval == true ) {
			return true;
			}else {
				return false;
			}
	}
	
	function sendMail_sendMailWithSwift($name,$email,$subject,$message){
		// 		$name = addslashes(trim($name));
		// 		$email = addslashes(trim($email));
		// 		$message = htmlentities(addslashes(trim($message)));
	
		// Mail Transport
		$transport = Swift_SmtpTransport::newInstance('ssl://mail.renewalhelp.com', 465)
		->setUsername('contactus@renewalhelp.com') // Your Gmail Username
		->setPassword('Arcorp@321'); // Your Gmail Password
	
		// Mailer
		$mailer = Swift_Mailer::newInstance($transport);
	
		// Create a message
		$message = Swift_Message::newInstance($subject)
		->setContentType("text/html")
		->setFrom(array('contactus@renewalhelp.com' => 'Renewalhelp.com')) // can be $_POST['email'] etc...
		->setTo(array($email => $name)) // your email / multiple supported.
		->setBody($message);
		date_default_timezone_set ( 'UTC' );
		if($mailer->send($message))
		{
			echo "success";
		}
		else {
			echo 'failed';
		}
	}
	
	function sendMail_ContactUs($name,$email,$subject,$message)
	{
		
		if(SEND_EMAIL!="TRUE"){
			return false;
		}
	
		$ccMailId3 = 'RenewalHelp<contactus@renewalHelp.com>';
	
		$headerMIMEVersion = "MIME-Version: 1.0" . "\r\n";
		$headerContentType = "Content-type:text/html;charset=UTF-8" . "\r\n";
	
		$emailTo = $name.' <'.$email.'>' . "\r\n";
		$headerFrom = 'From: '.$ccMailId3 ."\r\n";
	
		$headers = $headerMIMEVersion . $headerContentType . $headerFrom ;
	
		$retval = mail($emailTo,$subject,$message,$headers);
	
		if( $retval == true ) {
			return true;
		}else {
			return false;
		}
	}
	
	function sendMail_ContactUsToOwnerWithSwift($name,$email,$subject,$messageBody){
		// 		$name = addslashes(trim($name));
		// 		$email = addslashes(trim($email));
		// 		$message = htmlentities(addslashes(trim($message)));
	
		// Mail Transport
		//
// 		$transport = Swift_SmtpTransport::newInstance('ssl://sg2plcpnl0099.prod.sin2.secureserver.net', 465)
		
		$transport = Swift_SmtpTransport::newInstance('ssl://mail.renewalhelp.com', 465)
		->setUsername('contactus@renewalhelp.com') // Your Gmail Username
		->setPassword('Arcorp@321'); // Your Gmail Password
	
		// Mailer
		$mailer = Swift_Mailer::newInstance($transport);
		// 			$message = '<html><body>Hello '.$username.',<br><br>
		// 				<img  src=\"'.$this->embed(Swift_Image::fromPath('https://upload.wikimedia.org/wikipedia/commons/e/e0/JPEG_example_JPG_RIP_050.jpg')).'\" /> sample img
		// 				We appreciate that you have taken the time to write us. We will get back to you very soon.<br>
		// 				Your advice and suggestions will help us to improve our application.<br>
		// 				Please come back and see us often. <br><br>
		// 				From<br>
		// 				Renewalhelp.com <br><br></body></html>';
			
		// Create a message
		$message = Swift_Message::newInstance($subject)
		->setContentType("text/html")
		->setFrom(array('contactus@renewalhelp.com' => 'Renewalhelp.com')) // can be $_POST['email'] etc...
		->setTo(array($email => $name)) // your email / multiple supported.
		->setBody($messageBody);
		date_default_timezone_set ( 'UTC' );
		if($mailer->send($message))
		{
			echo "success";
		}
		else {
			echo 'failed';
		}
	}
	
	
	function sendMail_ContactUsToUserWithSwift($name,$email,$subject){
// 		$name = addslashes(trim($name));
// 		$email = addslashes(trim($email));
// 		$message = htmlentities(addslashes(trim($message)));
	
		// Mail Transports166-62-86-121.secureserver.net
		$transport = Swift_SmtpTransport::newInstance('ssl://mail.renewalhelp.com', 465)
		->setUsername('contactus@renewalhelp.com') // Your Gmail Username
		->setPassword('Arcorp@321'); // Your Gmail Password
		
			// Mailer
			$mailer = Swift_Mailer::newInstance($transport);
// 			$message = '<html><body>Hello '.$username.',<br><br>
// 				<img  src=\"'.$this->embed(Swift_Image::fromPath('https://upload.wikimedia.org/wikipedia/commons/e/e0/JPEG_example_JPG_RIP_050.jpg')).'\" /> sample img
// 				We appreciate that you have taken the time to write us. We will get back to you very soon.<br>
// 				Your advice and suggestions will help us to improve our application.<br>
// 				Please come back and see us often. <br><br>
// 				From<br>
// 				Renewalhelp.com <br><br></body></html>';
			
			// Create a message
			$message = Swift_Message::newInstance($subject);
// 			$img = $message->embed(Swift_Image::fromPath('https://upload.wikimedia.org/wikipedia/commons/e/e0/JPEG_example_JPG_RIP_050.jpg','image/jpeg')
// 			->setDisposition('inline'));
			
			$message->setContentType("text/html")
			->setFrom(array('contactus@renewalhelp.com' => 'Renewalhelp.com')) // can be $_POST['email'] etc...
			->setTo(array($email => $name)) // your email / multiple supported.
			->setBody('<html><body>
					<img  src="'.$message->embed(Swift_Image::fromPath('../img/RenewalHelp_Final_logo.png')).'" height="75px"/>
					<br><br>Dear '.$name.',<br><br>
					Greetings from renewalHELP !,<br><br>
					Thank you for contacting us. <br><br>
					Our representatives will be contacting you soon to discuss on your requirement.<br><br>
					Sincerely,
				<p>RenewalHelp.com</p> <br><br></body></html>');
			date_default_timezone_set ( 'UTC' );
			if($mailer->send($message))
			{
				echo "success";
			}
			else {
				echo 'failed';
			}
	}
	
	function sendEmail_ForgotPasswordWithSwift($useremail, $userpassword, $subject){
		// Mail Transport
		$transport = Swift_SmtpTransport::newInstance('ssl://mail.renewalhelp.com', 465)
		->setUsername('contactus@renewalhelp.com') // Your Gmail Username
		->setPassword('Arcorp@321'); // Your Gmail Password
	
		// Mailer
		$mailer = Swift_Mailer::newInstance($transport);
			
		// Create a message
		$message = Swift_Message::newInstance($subject);
			
		$message->setContentType("text/html")
		->setFrom(array('contactus@renewalhelp.com' => 'Renewalhelp.com')) // can be $_POST['email'] etc...
		->setTo(array($useremail => "")) // your email / multiple supported.
		->setBody('<html><body>
					<img  src="'.$message->embed(Swift_Image::fromPath('../img/RenewalHelp_Final_logo.png')).'" height="75px"/>
					<br><br>Dear User,<br><br>
					We have a request from you to change your password.<br><br>
					Use following temporary password to get logged in your account and from there you can change your password.<br><br><br>
					Temporary Password: <b>'.$userpassword.'</b><br><br>
					Sincerely,
				<p>RenewalHelp.com</p> <br><br></body></html>');
		date_default_timezone_set ( 'UTC' );
		if($mailer->send($message))
		{
			echo "success";
		}
		else {
			echo 'failed';
		}
	}

	function sendEmail_reminder($useremail, $subject,$userName,$category,$subcategory,$expirydate,
			$dateRemaining,$supplierName,$supplierEmail,$contractNo,$mailToSupplier){
		// Mail Transport
		$transport = Swift_SmtpTransport::newInstance('ssl://mail.renewalhelp.com', 465)
		->setUsername('alert@renewalhelp.com') // Your Gmail Username
		->setPassword('Arcorp@321'); // Your Gmail Password
	
		// Mailer
		$mailer = Swift_Mailer::newInstance($transport);
			
		// Create a message
		$message = Swift_Message::newInstance($subject);
		
		$message->setContentType("text/html")
		  ->setFrom(array('alert@renewalhelp.com' => 'Renewalhelp.com')) // can be $_POST['email'] etc...
		  ->setTo(array($useremail=>"")) // your email / multiple supported.
		  ->setBody('<html><body>
			    <img  src="'.$message->embed(Swift_Image::fromPath('../img/RenewalHelp_Final_logo.png')).'" height="75px"/>
				<br><br>Dear '.$userName.',<br><br>
			    Some of your contract are due for renewal please renew them before they are expired.<br><br>
				<table border="1" style="border:1px solid black">
				<tr style="background-color: #e6e6e6;text-align: center;"><td>Category</td><td>Sub Category</td><td>Expiry Date</td><td>Days Remained</td><td>Supplier Name</td><td>Supplier Email</td><td>Contract No</td>
				</tr>
				<tr><td>'.$category.'</td><td>'.$subcategory.'</td><td>'.$expirydate.'</td><td>'.$dateRemaining.'</td><td>'.$supplierName.'</td><td>'.$supplierEmail.'</td><td>'.$contractNo.'</td>
				</tr>
				</table><br><br>
				Click here to login to your control panel and renew your contract status.<br>
				<a href="https://renewalhelp.com/renser/index.php#login">Login</a> <br><br><br>
				
				<p style="text-align:center">This is an auto generated e-mail. Please do not reply.</p> <br><br>
				
				Sincerely,
				<p>RenewalHelp.com</p> <br><br>
				</body></html>');
		    date_default_timezone_set ( 'UTC' );
		    if($mailer->send($message))
		    {
			    echo "success";
		    }
		    else {
			    echo 'failed';
		    }    
	}
	
	function sendEmail_expiryOfVendorBeforeOneDay($vendorName , $vendorEmail , $days , $subject){
		// Mail Transport
		$transport = Swift_SmtpTransport::newInstance('ssl://mail.renewalhelp.com', 465)
		->setUsername('alert@renewalhelp.com') // Your Gmail Username
		->setPassword('Arcorp@321'); // Your Gmail Password
	
		// Mailer
		$mailer = Swift_Mailer::newInstance($transport);
			
		// Create a message
		$message = Swift_Message::newInstance($subject);
		
		$message->setContentType("text/html")
		  ->setFrom(array('alert@renewalhelp.com' => 'Renewalhelp.com')) // can be $_POST['email'] etc...
		  ->setTo(array($vendorEmail=>"")) // your email / multiple supported.
		  ->setBody('<html><body>
			    <img  src="'.$message->embed(Swift_Image::fromPath('../img/RenewalHelp_Final_logo.png')).'" height="75px"/>
				<br><br>Dear '.$vendorName.',<br><br>
			    Your Annual Subscription of Partner Enrollment is going to expire <b> tommorrow. </b><br><br>
			    
			    Renew your subscription to maintaine your partnership with renewalhelp. <br><br>
			    
			    You can contact us (contactus@renewalhelp.com) to renew your subscription. <br><br>
			    
			    <p style="text-align:center">This is an auto generated e-mail. Please do not reply.</p> <br><br>
				
				Sincerely,
				<p>RenewalHelp.com</p> <br><br>
				</body></html>');
		    date_default_timezone_set ( 'UTC' );
		    if($mailer->send($message))
		    {
			    echo "success";
		    }
		    else {
			    echo 'failed';
		    }    
	}
	
	function sendEmail_expiryOfVendor($vendorName , $vendorEmail , $days , $subject){
		// Mail Transport
		$transport = Swift_SmtpTransport::newInstance('ssl://mail.renewalhelp.com', 465)
		->setUsername('alert@renewalhelp.com') // Your Gmail Username
		->setPassword('Arcorp@321'); // Your Gmail Password
	
		// Mailer
		$mailer = Swift_Mailer::newInstance($transport);
			
		// Create a message
		$message = Swift_Message::newInstance($subject);
		
		$message->setContentType("text/html")
		  ->setFrom(array('alert@renewalhelp.com' => 'Renewalhelp.com')) // can be $_POST['email'] etc...
		  ->setTo(array($vendorEmail=>"")) // your email / multiple supported.
		  ->setBody('<html><body>
			    <img  src="'.$message->embed(Swift_Image::fromPath('../img/RenewalHelp_Final_logo.png')).'" height="75px"/>
				<br><br>Dear '.$vendorName.',<br><br>
			    Your Annual Subscription of Partner Enrollment is going to expire in <b> '.$days.' days. </b><br><br>
			    
			    Please renew your subscription before it get expire or after to maintaine your partnership with RenewalHelp.. <br><br>
			    
			    <p style="text-align:center">This is an auto generated e-mail. Please do not reply.</p> <br><br>
				
				Sincerely,
				<p>RenewalHelp.com</p> <br><br>
				</body></html>');
		    date_default_timezone_set ( 'UTC' );
		    if($mailer->send($message))
		    {
			    echo "success";
		    }
		    else {
			    echo 'failed';
		    }    
	}
	
	function sendMail_invoiceToCustomer($subject,$userName , $userLastName , $location , $userEmail , $userAddress , $bill_no , $todayDate , 
                                        $totalRecords , $pricePerRecord , $totalAmount , $tax_type_1 , 
                                        $tax_type_2 , $tax_rate_1 , $tax_rate_2 , $tax_amount_1 , $tax_amount_2 , $tax_total_amount , $bill_amount , 
                                        $tax_total_amount_in_words , $bill_amount_in_words){
		// Mail Transport
		$transport = Swift_SmtpTransport::newInstance('ssl://mail.renewalhelp.com', 465)
		->setUsername('billing@renewalhelp.com') // Your Gmail Username
		->setPassword('Arcorp@321'); // Your Gmail Password
	
		// Mailer
		$mailer = Swift_Mailer::newInstance($transport);
			
		// Create a message
		$message = Swift_Message::newInstance($subject);
		
		$message->setContentType("text/html")
		  ->setFrom(array('billing@renewalhelp.com' => 'Renewalhelp.com')) // can be $_POST['email'] etc...
		  ->setTo(array($userEmail=>"")) // your email / multiple supported.
		  ->setBody('<html>
		        <head>
                    <style>
                        table, th, td {
                            border: 1px solid black;
                            border-collapse: collapse;
                        }
                        th, td {
                            padding: 5px;
                            text-align: left;    
                        }
                    </style>
                </head>
		        <body>
			    <img  src="'.$message->embed(Swift_Image::fromPath('../img/RenewalHelp_Final_logo.png')).'" height="75px"/>
				<br><br>Dear '.$userName.',<br><br>
			    Kindly find here your invoice for your todays purchase at RenewalHelp, <br><br>
			    
			    <img src="http://api.page2images.com/directlink?p2i_url=http://renewalhelp.com/renser/renser/invoiceCustomer.php&p2i_key=b0560d5a252435e7"> <br>
			    
				Sincerely,
				<p>RenewalHelp.com</p> <br><br></body></html>');
		    date_default_timezone_set ( 'UTC' );
		    if($mailer->send($message))
		    {
			    echo "success";
		    }
		    else {
			    echo 'failed';
		    }    
	}
	function sendMail_invoiceToVendor($subject,$userName , $userLastName , $location , $userEmail , $userAddress , $bill_no , $todayDate , 
                                        $totalRecords , $pricePerRecord , $totalAmount , $tax_type_1 , 
                                        $tax_type_2 , $tax_rate_1 , $tax_rate_2 , $tax_amount_1 , $tax_amount_2 , $tax_total_amount , $bill_amount , 
                                        $tax_total_amount_in_words , $bill_amount_in_words){
		// Mail Transport
		$transport = Swift_SmtpTransport::newInstance('ssl://mail.renewalhelp.com', 465)
		->setUsername('billing@renewalhelp.com') // Your Gmail Username
		->setPassword('Arcorp@321'); // Your Gmail Password
	
		// Mailer
		$mailer = Swift_Mailer::newInstance($transport);
			
		// Create a message
		$message = Swift_Message::newInstance($subject);
		
		$message->setContentType("text/html")
		  ->setFrom(array('billing@renewalhelp.com' => 'Renewalhelp.com')) // can be $_POST['email'] etc...
		  ->setTo(array($userEmail=>"")) // your email / multiple supported.
		  ->setBody('<html>
		        <head>
                    <style>
                        table, th, td {
                            border: 1px solid black;
                            border-collapse: collapse;
                        }
                        th, td {
                            padding: 5px;
                            text-align: left;    
                        }
                    </style>
                </head>
		        <body>
			    <img  src="'.$message->embed(Swift_Image::fromPath('../img/RenewalHelp_Final_logo.png')).'" height="75px"/>
				<br><br>Dear '.$userName.',<br><br>
			    Kindly find invoice for your todays purchase at RenewalHelp, <br><br>
			    
			    <img src="http://api.page2images.com/directlink?p2i_url=http://renewalhelp.com/renser/renser/invoiceVendor.php&p2i_key=b0560d5a252435e7"> <br>
			    
				Sincerely,
				<p>RenewalHelp.com</p> <br><br></body></html>');
		    date_default_timezone_set ( 'UTC' );
		    if($mailer->send($message))
		    {
			    echo "success";
		    }
		    else {
			    echo 'failed';
		    }    
	}
/*	
	function sendMail_invoiceToCustomer($subject,$userName , $userLastName , $location , $userEmail , $userAddress , $bill_no , $todayDate , 
                                        $totalRecords , $pricePerRecord , $totalAmount , $tax_type_1 , 
                                        $tax_type_2 , $tax_rate_1 , $tax_rate_2 , $tax_amount_1 , $tax_amount_2 , $tax_total_amount , $bill_amount , 
                                        $tax_total_amount_in_words , $bill_amount_in_words){
		// Mail Transport
		$transport = Swift_SmtpTransport::newInstance('ssl://mail.renewalhelp.com', 465)
		->setUsername('billing@renewalhelp.com') // Your Gmail Username
		->setPassword('Arcorp@321'); // Your Gmail Password
	
		// Mailer
		$mailer = Swift_Mailer::newInstance($transport);
			
		// Create a message
		$message = Swift_Message::newInstance($subject);
		
		$message->setContentType("text/html")
		  ->setFrom(array('billing@renewalhelp.com' => 'Renewalhelp.com')) // can be $_POST['email'] etc...
		  ->setTo(array($userEmail=>"")) // your email / multiple supported.
		  ->setBody('<html>
		        <head>
                    <style>
                        table, th, td {
                            border: 1px solid black;
                            border-collapse: collapse;
                        }
                        th, td {
                            padding: 5px;
                            text-align: left;    
                        }
                    </style>
                </head>
		        <body>
			    <img  src="'.$message->embed(Swift_Image::fromPath('../img/RenewalHelp_Final_logo.png')).'" height="75px"/>
				<br><br>Dear '.$userName.',<br><br>
			    Kindly find here your invoice for your toadays purchase at RenewalHelp, <br><br>
			    <h2 style="text-align:center">Tax Invoice</h2>
                <table style="width:100%;">
                    <tr>
                        <th colspan="4">A R Corporation (From 1-Apr-2017)<br>
    	                                203, Sankalp Siddhi, Lane No. B/32, <br>
                                        Dhayari, Pune-411041, <br>
                                        GSTIN/UIN: 27AKFPG0004R1ZB
                        </th>
                        <td colspan="2">Invoice No <br>
    	                                '.$bill_no.'
                        </td>
                        <td colspan="2">Dated <br>
    	                                '.$todayDate.'
                        </td>
                    </tr>
                    <tr>
                        <th colspan="8">Buyer<br>
                                        '.$userName.' '.$userLastName.' <br>
                                        '.$userAddress.'
                        </th>
                    </tr>

                    <tr>
  	                    <th>Sl. No.</th>
                        <th>Description</th>
                        <th>HSN/SAC</th>
                        <th>GST Rate</th>
                        <th>Quantity</th>
                        <th>Rate</th>
                        <th>Per</th>
                        <th>Amount</th>
                    </tr>
                    <tr>
  	                    <td>1</td>
                        <td>Subscription fees for Renewalhelp</td>
                        <td></td>
                        <td>18%</td>
                        <td>'.$totalRecords.'</td>
                        <td>'.$pricePerRecord.'</td>
                        <td>Nos</td>
                        <td>'.$totalAmount.'</td>
                    </tr>
                    <tr>
  	                    <td></td>
                        <td colspan="4">'.$tax_type_1 .' <br>
    				                    '.$tax_type_2 .' <br>
                        </td>
                        <td> '.$tax_rate_1.' <br>
    	                     '.$tax_rate_2.' <br>
                        </td>
                        <td></td>
                        <td> '.$tax_amount_1.' <br>
    	                    '.$tax_amount_2.' <br>
                        </td>
                    </tr>
                    <tr>
  	                    <th colspan="7" style="text-align: center">Total</th>
                        <td>'.$bill_amount.'</td>
                    </tr>
                    <tr>
  	                    <th colspan="8">Amount Chargable (in words) <br>
    	                                INR '.$bill_amount_in_words.' Only
                        </th>
                    </tr>
                    <tr>
  	                    <th rowspan="2">HSN/SAC</th>
                        <th rowspan="2">Taxable Value</th>
                        <th colspan="2">Central Tax</th>
                        <th colspan="2">State Tax</th>
                        <th colspan="2" rowspan="2">Total Tax Amount</th>
                    </tr>
                    <tr>
                        <td>Rate</td>
                        <td>Amount</td>
                        <td>Rate</td>
                        <td>Amount</td>
                    </tr>
                    <tr>
  	                    <td>6767</td>
                        <td>'.$totalAmount.'</td>
                        <td>'.$tax_rate_1.'</td>
                        <td>'.$tax_amount_1.'</td>
                        <td>'.$tax_rate_2.'</td>
                        <td>'.$tax_amount_2.'</td>
                        <td colspan="2">'.$tax_total_amount.'</td>
                    </tr>
                    <tr>
  	                    <th colspan="6" style="text-align: center">Total</th>
                        <th colspan="2">'.$tax_total_amount.'</th> 
                    </tr>
                    <tr>
  	                    <th colspan="8">Tax Amount (in words) 
    	                                INR '.$tax_total_amount_in_words.' Only
                        </th>
                    </tr>
                    <tr>
  	                    <td colspan="8">
    	                    <br><br>
                            Companys PAN : AKFPG0004R <br><br>
                            <u>Declairation</u><br>
                                We declare that this invoice shows the actual price of the records described and that all particulars are true and correct.
                        </td>
                    </tr>
                </table>
                <h3 style="text-align: center; margin-top:0px">SUBJECT TO PUNE JURIDICTION</h3>
                <p style="text-align: center; margin-top:-15px">This is computer generated invoice.</p>
			    
			    
				Sincerely,
				<p>RenewalHelp.com</p> <br><br></body></html>');
		    date_default_timezone_set ( 'UTC' );
		    if($mailer->send($message))
		    {
			    echo "success";
		    }
		    else {
			    echo 'failed';
		    }    
	}  
	
    function sendMail_invoiceToVendor($subject,$userName , $userLastName , $location , $userEmail , $userAddress , $bill_no , $todayDate , 
                                        $totalRecords , $pricePerRecord , $totalAmount , $tax_type_1 , 
                                        $tax_type_2 , $tax_rate_1 , $tax_rate_2 , $tax_amount_1 , $tax_amount_2 , $tax_total_amount , $bill_amount , 
                                        $tax_total_amount_in_words , $bill_amount_in_words){
		// Mail Transport
		$transport = Swift_SmtpTransport::newInstance('ssl://mail.renewalhelp.com', 465)
		->setUsername('billing@renewalhelp.com') // Your Gmail Username
		->setPassword('Arcorp@321'); // Your Gmail Password
	
		// Mailer
		$mailer = Swift_Mailer::newInstance($transport);
			
		// Create a message
		$message = Swift_Message::newInstance($subject);
		
		$message->setContentType("text/html")
		  ->setFrom(array('billing@renewalhelp.com' => 'Renewalhelp.com')) // can be $_POST['email'] etc...
		  ->setTo(array($userEmail=>"")) // your email / multiple supported.
		  ->setBody('<html>
		        <head>
                    <style>
                        table, th, td {
                            border: 1px solid black;
                            border-collapse: collapse;
                        }
                        th, td {
                            padding: 5px;
                            text-align: left;    
                        }
                    </style>
                </head>
		        <body>
			    <img  src="'.$message->embed(Swift_Image::fromPath('../img/RenewalHelp_Final_logo.png')).'" height="75px"/>
				<br><br>Dear '.$userName.',<br><br>
			    Kindly find here your invoice for your toadays purchase at RenewalHelp, <br><br>
			    <h2 style="text-align:center">Tax Invoice</h2>
                <table style="width:100%;">
                    <tr>
                        <th colspan="4">A R Corporation (From 1-Apr-2017)<br>
    	                                203, Sankalp Siddhi, Lane No. B/32, <br>
                                        Dhayari, Pune-411041, <br>
                                        GSTIN/UIN: 27AKFPG0004R1ZB
                        </th>
                        <td colspan="2">Invoice No <br>
    	                                '.$bill_no.'
                        </td>
                        <td colspan="2">Dated <br>
    	                                '.$todayDate.'
                        </td>
                    </tr>
                    <tr>
                        <th colspan="8">Buyer<br>
                                        '.$userName.' '.$userLastName.' <br>
                                        '.$userAddress.'
                        </th>
                    </tr>

                    <tr>
  	                    <th>Sl. No.</th>
                        <th>Description</th>
                        <th>HSN/SAC</th>
                        <th>GST Rate</th>
                        <th>Quantity</th>
                        <th>Rate</th>
                        <th>Per</th>
                        <th>Amount</th>
                    </tr>
                    <tr>
  	                    <td>1</td>
                        <td>Annual subscription charges for partner enrollment</td>
                        <td></td>
                        <td>18%</td>
                        <td>'.$totalRecords.'</td>
                        <td>'.$pricePerRecord.'</td>
                        <td>Nos</td>
                        <td>'.$totalAmount.'</td>
                    </tr>
                    <tr>
  	                    <td></td>
                        <td colspan="4">'.$tax_type_1 .' <br>
    				                    '.$tax_type_2 .' <br>
                        </td>
                        <td> '.$tax_rate_1.' <br>
    	                     '.$tax_rate_2.' <br>
                        </td>
                        <td></td>
                        <td> '.$tax_amount_1.' <br>
    	                    '.$tax_amount_2.' <br>
                        </td>
                    </tr>
                    <tr>
  	                    <th colspan="7" style="text-align: center">Total</th>
                        <td>'.$bill_amount.'</td>
                    </tr>
                    <tr>
  	                    <th colspan="8">Amount Chargable (in words) <br>
    	                                INR '.$bill_amount_in_words.' Only
                        </th>
                    </tr>
                    <tr>
  	                    <th rowspan="2">HSN/SAC</th>
                        <th rowspan="2">Taxable Value</th>
                        <th colspan="2">Central Tax</th>
                        <th colspan="2">State Tax</th>
                        <th colspan="2" rowspan="2">Total Tax Amount</th>
                    </tr>
                    <tr>
                        <td>Rate</td>
                        <td>Amount</td>
                        <td>Rate</td>
                        <td>Amount</td>
                    </tr>
                    <tr>
  	                    <td>6767</td>
                        <td>'.$totalAmount.'</td>
                        <td>'.$tax_rate_1.'</td>
                        <td>'.$tax_amount_1.'</td>
                        <td>'.$tax_rate_2.'</td>
                        <td>'.$tax_amount_2.'</td>
                        <td colspan="2">'.$tax_total_amount.'</td>
                    </tr>
                    <tr>
  	                    <th colspan="6" style="text-align: center">Total</th>
                        <th colspan="2">'.$tax_total_amount.'</th> 
                    </tr>
                    <tr>
  	                    <th colspan="8">Tax Amount (in words) 
    	                                INR '.$tax_total_amount_in_words.' Only
                        </th>
                    </tr>
                    <tr>
  	                    <td colspan="8">
    	                    <br><br>
                            Companys PAN : AKFPG0004R <br><br>
                            <u>Declairation</u><br>
                                We declare that this invoice shows the actual price of the records described and that all particulars are true and correct.
                        </td>
                    </tr>
                </table>
                <h3 style="text-align: center; margin-top:0px">SUBJECT TO PUNE JURIDICTION</h3>
                <p style="text-align: center; margin-top:-15px">This is computer generated invoice.</p>
			    
			    
				Sincerely,
				<p>RenewalHelp.com</p> <br><br></body></html>');
		    date_default_timezone_set ( 'UTC' );
		    if($mailer->send($message))
		    {
			    echo "success";
		    }
		    else {
			    echo 'failed';
		    }    
	} */
	
	function mailMe($userEmail, $v_name, $v_company, $v_email,$v_mobile,$v_website,$subject){
		// Mail Transport
		$transport = Swift_SmtpTransport::newInstance('ssl://mail.renewalhelp.com', 465)
		->setUsername('contactus@renewalhelp.com') // Your Gmail Username
		->setPassword('Arcorp@321'); // Your Gmail Password
	
		// Mailer
		$mailer = Swift_Mailer::newInstance($transport);
			
		// Create a message
		$message = Swift_Message::newInstance($subject);
		
		$message->setContentType("text/html")
		  ->setFrom(array('contactus@renewalhelp.com' => 'Renewalhelp.com')) // can be $_POST['email'] etc...
		  ->setTo(array($userEmail=>"")) // your email / multiple supported.
		  ->setBody('<html><body>
			    <img  src="'.$message->embed(Swift_Image::fromPath('../img/RenewalHelp_Final_logo.png')).'" height="75px"/>
				<br><br>Dear member,<br><br>
			          Below is the information of vendore you requested.
				Sincerely,
				<p>RenewalHelp.com</p> <br><br></body></html>');
		    date_default_timezone_set ( 'UTC' );
		    if($mailer->send($message))
		    {
			    echo "success";
		    }
		    else {
			    echo 'failed';
		    }    
	}
	
	function sendEmail_reminder_supplier($useremail, $subject,$userName,$category,$subcategory,$expirydate,
			$dateRemaining,$supplierName,$supplierEmail,$contractNo,$mailToSupplier){
		// Mail Transport
		$transport = Swift_SmtpTransport::newInstance('ssl://mail.renewalhelp.com', 465)
		->setUsername('alert@renewalhelp.com') // Your Gmail Username
		->setPassword('Arcorp@321'); // Your Gmail Password
	
		// Mailer
		$mailer = Swift_Mailer::newInstance($transport);
			
		// Create a message
		$message = Swift_Message::newInstance($subject);
		
		$message->setContentType("text/html")
		  ->setFrom(array('alert@renewalhelp.com' => 'Renewalhelp.com, On Behalf Of '.$userName.'')) // can be $_POST['email'] etc...
		  ->setTo(array($supplierEmail=>"")) // your email / multiple supported.
		  ->setBody('<html><body>
			    <img  src="'.$message->embed(Swift_Image::fromPath('../img/RenewalHelp_Final_logo.png')).'" height="75px"/>
				<br><br>Hello,<br><br>
				Greetings from Renewalhelp.com...! <br><br>
				(On Behalf Of : '.$userName.')
			    Your client\'s contract is due for renewal please contact your client and renew them before they are expired.<br><br>
				<table border="1" style="border:1px solid black">
				<tr style="background-color: #e6e6e6;text-align: center;"><td>Category</td><td>Sub Category</td><td>Expiry Date</td><td>Days Remained</td><td>Client Name</td><td>Client Email</td><td>Contract No</td>
				</tr>
				<tr><td>'.$category.'</td><td>'.$subcategory.'</td><td>'.$expirydate.'</td><td>'.$dateRemaining.'</td><td>'.$userName.'</td><td>'.$useremail.'</td><td>'.$contractNo.'</td>
				</tr>
				</table><br><br>
				Sincerely,
				<p>RenewalHelp.com</p> <br><br></body></html>');
		    date_default_timezone_set ( 'UTC' );
		    if($mailer->send($message))
		    {
			    echo "success";
		    }
		    else {
			    echo 'failed';
		    }    
	}
	
	function sendEmail_reminder_to_owner($useremail, $subject,$userName,$custlist){
				// Mail Transport
				//mail.renewalhelp.com
				//$transport = Swift_SmtpTransport::newInstance('ssl://sg2plcpnl0099.prod.sin2.secureserver.net', 465)
		$transport = Swift_SmtpTransport::newInstance('ssl://mail.renewalhelp.com', 465)
				->setUsername('contactus@renewalhelp.com') // Your Gmail Username
				->setPassword('Arcorp@321'); // Your Gmail Password
	
				// Mailer
				$mailer = Swift_Mailer::newInstance($transport);
					
				// Create a message
				$message = Swift_Message::newInstance($subject);
					
				$message->setContentType("text/html")
				->setFrom(array('contactus@renewalhelp.com' => 'Renewalhelp.com')) // can be $_POST['email'] etc...
				->setTo(array($useremail => "")) // your email / multiple supported.
				->setBody('<html><body>
					<img  src="'.$message->embed(Swift_Image::fromPath('../img/RenewalHelp_Final_logo.png')).'" height="75px"/>
					<br><br>Dear '.$userName.',<br><br>
				Customer List ,<br><br>
				'.$custlist.'
				     <br>
					<a href="https://renewalhelp.com/renser/index.php#login">Login</a> <br><br>
					Sincerely,
				<p>RenewalHelp.com</p> <br><br></body></html>');
				date_default_timezone_set ( 'UTC' );
				if($mailer->send($message))
				{
					echo "success";
				}
				else {
					echo 'failed';
				}
	}
	
	
	function sendMail_WelcomeToUserWithSwift($name,$email,$subject){
		
		$emailEncoded = hash ( 'sha256' , $email);
		
		$transport = Swift_SmtpTransport::newInstance('ssl://mail.renewalhelp.com', 465)
		->setUsername('contactus@renewalhelp.com') // Your Gmail Username
		->setPassword('Arcorp@321'); // Your Gmail Password
	
		// Mailer
		$mailer = Swift_Mailer::newInstance($transport);
		
		// Create a message
		$message = Swift_Message::newInstance($subject);
		// 			
			
		$message->setContentType("text/html")
		->setFrom(array('contactus@renewalhelp.com' => 'Renewalhelp.com')) // can be $_POST['email'] etc...
		->setTo(array($email => $name)) // your email / multiple supported.
		->setBody('<html><body>
					<img  src="'.$message->embed(Swift_Image::fromPath('../img/RenewalHelp_Final_logo.png')).'" height="75px"/>
					<br><br>Dear '.$name.',<br><br>
	
				Welcome to renewalHelp.<br><br>
				
				Thank you for creating renewalHELP account, you will now have access to manage and track <br> your renewal online.<br><br>
				
				To access your account , you must be the verified user of Renewalhelp.com. <br><br>
				
				To verify your account please <a href="https://renewalhelp.com/renser/renser/confirmuser.php?ue='.$emailEncoded.'" >Click here. </a> <br><br>
				
				Thank you for joining renewalHelp. <br><br>
				Sincerely,
				<p>RenewalHelp.com</p> <br><br></body></html>');
		
		date_default_timezone_set ( 'UTC' );
		if($mailer->send($message))
		{
			echo "success";
		}
		else {
			echo 'failed';
		}
	}
	
	function sendEmail_WelcomeToConfirmedUser($userName,$email,$subject){
		
		$transport = Swift_SmtpTransport::newInstance('ssl://mail.renewalhelp.com', 465)
		->setUsername('contactus@renewalhelp.com') // Your Gmail Username
		->setPassword('Arcorp@321'); // Your Gmail Password
	
		// Mailer
		$mailer = Swift_Mailer::newInstance($transport);
		
		// Create a message
		$message = Swift_Message::newInstance($subject);
		// 			
			
		$message->setContentType("text/html")
		->setFrom(array('contactus@renewalhelp.com' => 'Renewalhelp.com')) // can be $_POST['email'] etc...
		->setTo(array($email => "On Behalf Of Pankaj Takale")) // your email / multiple supported.
		->setBody('<html><body>
					<img  src="'.$message->embed(Swift_Image::fromPath('../img/RenewalHelp_Final_logo.png')).'" height="75px"/>
					<br><br>Hey '.$userName.'!<br><br>
	
				Welcome to the RenewalHelp many of business and individual are using RenewalHelp service to store,track and manage records.<br><br>
				
				RenewalHelp is user friendly easy to use ,track and remind you on time through email and SMS.<br><br>
				
				No need to maintain any spreadsheet or purchase any hardware or software for any expiration reminder.<br><br>
				
				If you have any technical issue in using the RenewalHelp , feel free to reach us out .<br><br>
				
				Our renewal help expert will reach out to you soon to check how are you doing with you trail version.<br><br>
				
				Thanks,<br>
				<p>RenewalHelp.com</p> <br><br></body></html>');
		
		date_default_timezone_set ( 'UTC' );
		if($mailer->send($message))
		{
			echo "success";
		}
		else {
			echo 'failed';
		}
	}
	
	function sendMail_aboutPaymentConfirmation($name,$email,$totalRecords,$totalMonths,$expiryDate,$remainedDays,$razorpayPaymentId,$subject){
		
		$emailEncoded = hash ( 'sha256' , $email);
		
		$transport = Swift_SmtpTransport::newInstance('ssl://mail.renewalhelp.com', 465)
		->setUsername('contactus@renewalhelp.com') // Your Gmail Username
		->setPassword('Arcorp@321'); // Your Gmail Password
	
		// Mailer
		$mailer = Swift_Mailer::newInstance($transport);
		
		// Create a message
		$message = Swift_Message::newInstance($subject);
		// 			
			
		$message->setContentType("text/html")
		->setFrom(array('contactus@renewalhelp.com' => 'Renewalhelp.com')) // can be $_POST['email'] etc...
		->setTo(array($email => "")) // your email / multiple supported.
		->setBody('<html><body>
					<img  src="'.$message->embed(Swift_Image::fromPath('../img/RenewalHelp_Final_logo.png')).'" height="75px"/>
					<br><br>Dear '.$name.',<br><br>
	
				Greetings from Renewalhelp.com...!<br><br>
				
				Your payment has been confirmed by renewalhelp.com and details are as bellow:<br><br>
				
				<table border="1" style="border:1px solid black">
				<tr style="background-color: #e6e6e6;text-align: center;"><td>Payment ID</td><td>No of Records</td><td>No of Months</td><td>Expiry Date</td><td>Days Remained</td>
				</tr>
				<tr><td>'.$razorpayPaymentId.'</td><td>'.$totalRecords.'</td><td>'.$totalMonths.'</td><td>'.$expiryDate.'</td><td>'.$remainedDays.'</td>
				</tr>
				</table><br><br>
				
				Your invoice copy will be sent to you by email soon.
				
				Thank you for joining renewalHelp. <br><br>
				Sincerely,
				<p>RenewalHelp.com</p> <br><br></body></html>');
		
		date_default_timezone_set ( 'UTC' );
		if($mailer->send($message))
		{
			echo "success";
		}
		else {
			echo 'failed';
		}
	}
	
	function sendMail_aboutPaymentConfirmationVendore($name,$email,$paymentId,$subject){
		
		$transport = Swift_SmtpTransport::newInstance('ssl://mail.renewalhelp.com', 465)
		->setUsername('billing@renewalhelp.com') // Your Gmail Username
		->setPassword('Arcorp@321'); // Your Gmail Password
	
		// Mailer
		$mailer = Swift_Mailer::newInstance($transport);
		
		// Create a message
		$message = Swift_Message::newInstance($subject);
		// 			
			
		$message->setContentType("text/html")
		->setFrom(array('billing@renewalhelp.com' => 'Renewalhelp.com')) // can be $_POST['email'] etc...
		->setTo(array($email => "")) // your email / multiple supported.
		->setBody('<html><body>
					<img  src="'.$message->embed(Swift_Image::fromPath('../img/RenewalHelp_Final_logo.png')).'" height="75px"/>
					<br><br>Dear '.$name.',<br><br>
	
				Welcome to RenewalHelp.com!<br><br>
				
				You have been successfuly registerd with RenewalHelp!<br><br>
				
				<table border="1" style="border:1px solid black">
				<tr style="background-color: #e6e6e6;text-align: center;"><td>Payment ID</td><td>No of Years</td><td>Amount</td>
				</tr>
				<tr><td>'.$paymentId.'</td><td>1</td><td>Rs. 2950</td>
				</tr>
				</table><br><br>
				
				Your invoice copy will be sent to you by email soon.
				
				For any help or query please fill free to contact us at contactus@renewalhelp.com <br><br>
				
				Thank you for registering at RenewalHelp. <br><br>
				
				Sincerely,
				<p>RenewalHelp.com</p> <br><br></body></html>');
		
		date_default_timezone_set ( 'UTC' );
		if($mailer->send($message))
		{
			echo "success";
		}
		else {
			echo 'failed';
		}
	}
	
	function sendMail_WelcomeToComapnyWithSwift($name,$email,$subject){
	
		$transport = Swift_SmtpTransport::newInstance('ssl://mail.renewalhelp.com', 465)
		->setUsername('contactus@renewalhelp.com') // Your Gmail Username
		->setPassword('Arcorp@321'); // Your Gmail Password
	
		// Mailer
		$mailer = Swift_Mailer::newInstance($transport);
	
		// Create a message
		$message = Swift_Message::newInstance($subject);
		//
			
		$message->setContentType("text/html")
		->setFrom(array('contactus@renewalhelp.com' => 'Renewalhelp.com')) // can be $_POST['email'] etc...
		->setTo(array($email => $name)) // your email / multiple supported.
		->setBody('<html><body>
					<img  src="'.$message->embed(Swift_Image::fromPath('../img/RenewalHelp_Final_logo.png')).'" height="75px"/>
					<br><br>Dear '.$name.',<br><br>
	
				Welcome to renewalHelp.<br>
				Thank you for creating renewalHELP account, you will now have access to manage and track <br> your renewal online.
	
				To access your account , click <a href="https://www.renewalhelp.com/renser/renser/corporateLogin.php?email='.$email.'" >Access Account </a> <br><br>
				Thank you for joining renewalHelp. <br><br>
				Sincerely,
				<p>RenewalHelp.com</p> <br><br></body></html>');
	
		date_default_timezone_set ( 'UTC' );
		if($mailer->send($message))
		{
			echo "success";
		}
		else {
			echo 'failed';
		}
	}
	

	function sendMail_WelcomeToComapnyUserWithSwift($name,$email,$subject,$company_name){
	
		$transport = Swift_SmtpTransport::newInstance('ssl://mail.renewalhelp.com', 465)
		->setUsername('contactus@renewalhelp.com') // Your Gmail Username
		->setPassword('Arcorp@321'); // Your Gmail Password
	
		// Mailer
		$mailer = Swift_Mailer::newInstance($transport);
	
		// Create a message
		$message = Swift_Message::newInstance($subject);
		//
			
		$message->setContentType("text/html")
		->setFrom(array('contactus@renewalhelp.com' => 'Renewalhelp.com')) // can be $_POST['email'] etc...
		->setTo(array($email => $name)) // your email / multiple supported.
		->setBody('<html><body>
					<img  src="'.$message->embed(Swift_Image::fromPath('../img/RenewalHelp_Final_logo.png')).'" height="75px"/>
					<br><br>Dear '.$name.',<br><br>
	
				Welcome to renewalHelp.<br>
				Thank you for creating renewalHELP account, you will now have access to manage and track <br> your renewal online.
	
				To access your account , click <a href="https://www.renewalhelp.com/renser/renser/corporateEmployeeLogin.php?cn='.$company_name.'&email='.$email.'" >Access Account </a> <br><br>
				Thank you for joining renewalHelp. <br><br>
				Sincerely,
				<p>RenewalHelp.com</p> <br><br></body></html>');
	
		date_default_timezone_set ( 'UTC' );
		if($mailer->send($message))
		{
			echo "success";
		}
		else {
			echo 'failed';
		}
	}
	
	
	
/*	function  sendSMS($mobileNo,$msg){
		
		if(SEND_SMS!="TRUE"){
			return false;
		}
		
		 //    $requestUrl = "http://www.smszone.in/sendsms.asp?page=SendSmsBulk&username=".
		 //   "917798981353"."&password="."1Trupti@".
		 //   "&number=".$mobileNo."&message=".urlencode(utf8_encode($msg));
	    
	            $requestUrl = "http://www.smszone.in/sendsms.asp?page=SendSmsBulk&username=".
		        "919096016308"."&password="."C5B7".
		        "&number=".$mobileNo."&message=".urlencode(utf8_encode($msg));
	    	 
		     
		try {
		
			    // create a new cURL resource
			    $ch = curl_init();
			    
			    // set URL and other appropriate options
			    curl_setopt($ch, CURLOPT_URL, $requestUrl);
			    curl_setopt($ch, CURLOPT_HEADER, 0);
			    
			    // grab URL and pass it to the browser
			    curl_exec($ch);
			    
			    // close cURL resource, and free up system resources
			    curl_close($ch);
			    return true;
			} catch (Exception $e) {
				return false;
		}
	} */
	
	function sendSMS ($mobileNo , $msg)
	{
	    //header("Location: http://198.24.149.4/API/pushsms.aspx?loginID=takale15&password=123456&mobile=" . $mobileNo . "&text=" . $msg . "&senderid=RNWHLP&route_id=2&Unicode=0");
	    //exit;
	    $location = "http://198.24.149.4/API/pushsms.aspx?loginID=takale15&password=123456&mobile=". $mobileNo ."&text=".$msg."&senderid=RNWHLP&route_id=2&Unicode=0";
	    ?>
	    <script type="text/javascript">
	        var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                         
                }
            };
            xmlhttp.open("POST","<?php echo $location; ?>",true);
            xmlhttp.send();
        </script>
	    <?php
	}
	
	function sendEmailAndSms_delRecord($userName,$userEmail,$catagory,$subCat,$subject){
		
	$transport = Swift_SmtpTransport::newInstance('ssl://mail.renewalhelp.com', 465)
		->setUsername('contactus@renewalhelp.com') // Your Gmail Username
		->setPassword('Arcorp@321'); // Your Gmail Password
	
		// Mailer
		$mailer = Swift_Mailer::newInstance($transport);
	
		// Create a message
		$message = Swift_Message::newInstance($subject);
		//
			
		$message->setContentType("text/html")
		->setFrom(array('contactus@renewalhelp.com' => 'Renewalhelp.com')) // can be $_POST['email'] etc...
		->setTo(array($userEmail => $userName)) // your email / multiple supported.
		->setBody('<html><body>
					<img  src="'.$message->embed(Swift_Image::fromPath('../img/RenewalHelp_Final_logo.png')).'" height="75px"/>
					<br><br>Dear '.$userName.',<br><br>
	
				You have successfully deleted following record.<br><br>
				Category :: '.$catagory.'<br>
				Sub Category :: '.$subCat.'<br>
				 <br><br>
				Sincerely,
				<p>RenewalHelp.com</p> <br><br></body></html>');
	
		date_default_timezone_set ( 'UTC' );
		if($mailer->send($message))
		{
			echo "success";
		}
		else {
			echo 'failed';
		}
	}
	
	function sendEmail_UserNearToExpired($userName,$userEmail,$subject){
		$transport = Swift_SmtpTransport::newInstance('ssl://mail.renewalhelp.com', 465)
		->setUsername('contactus@renewalhelp.com') // Your Gmail Username
		->setPassword('Arcorp@321'); // Your Gmail Password
		
		// Mailer
		$mailer = Swift_Mailer::newInstance($transport);
		
		// Create a message
		$message = Swift_Message::newInstance($subject);
		//
			
		$message->setContentType("text/html")
		->setFrom(array('contactus@renewalhelp.com' => 'Renewalhelp.com')) // can be $_POST['email'] etc...
		->setTo(array($userEmail => $userName)) // your email / multiple supported.
		->setBody('<html><body>
					<img  src="'.$message->embed(Swift_Image::fromPath('../img/RenewalHelp_Final_logo.png')).'" height="75px"/>
					<br><br>Dear '.$userName.',<br><br>
		
				Your subscription is going to expired kindly purchase the subscription to enjoy uninterrupted services. <br><br>
				Login to <a href="https://renewalhelp.com/renser/index.php#login" >RenewalHELP</a><br><br>
				
				Sincerely,
				<p>RenewalHelp.com</p> <br><br></body></html>');
		
		date_default_timezone_set ( 'UTC' );
		if($mailer->send($message))
		{
			echo "success";
		}
		else {
			echo 'failed';
		}
	}
	function sendEmail_UserExpired($userName,$userEmail,$subject){
		$transport = Swift_SmtpTransport::newInstance('ssl://mail.renewalhelp.com', 465)
		->setUsername('contactus@renewalhelp.com') // Your Gmail Username
		->setPassword('Arcorp@321'); // Your Gmail Password
		
		// Mailer
		$mailer = Swift_Mailer::newInstance($transport);
		
		// Create a message
		$message = Swift_Message::newInstance($subject);
		//
			
		$message->setContentType("text/html")
		->setFrom(array('contactus@renewalhelp.com' => 'Renewalhelp.com')) // can be $_POST['email'] etc...
		->setTo(array($userEmail => $userName)) // your email / multiple supported.
		->setBody('<html><body>
					<img  src="'.$message->embed(Swift_Image::fromPath('../img/RenewalHelp_Final_logo.png')).'" height="75px"/>
					<br><br>Dear '.$userName.',<br><br>
		
				Your subscription is being expired kindly purchase the subscription. <br><br>
				Login to <a href="https://renewalhelp.com/renser/index.php#login" >RenewalHELP</a><br><br>
				
				Sincerely,
				<p>RenewalHelp.com</p> <br><br></body></html>');
		
		date_default_timezone_set ( 'UTC' );
		if($mailer->send($message))
		{
			echo "success";
		}
		else {
			echo 'failed';
		}
	}
	function sendEmail_3days($userName,$userEmail,$subject){
		$transport = Swift_SmtpTransport::newInstance('ssl://mail.renewalhelp.com', 465)
		->setUsername('contactus@renewalhelp.com') // Your Gmail Username
		->setPassword('Arcorp@321'); // Your Gmail Password
		
		// Mailer
		$mailer = Swift_Mailer::newInstance($transport);
		
		// Create a message
		$message = Swift_Message::newInstance($subject);
		//
			
		$message->setContentType("text/html")
		->setFrom(array('contactus@renewalhelp.com' => 'Renewalhelp.com')) // can be $_POST['email'] etc...
		->setTo(array($userEmail => $userName)) // your email / multiple supported.
		->setBody('<html><body>
					<img  src="'.$message->embed(Swift_Image::fromPath('../img/RenewalHelp_Final_logo.png')).'" height="75px"/>
					<br><br>Hello '.$userName.',<br><br>
		
				Its RenewalHelp expert. I noticed that you still haven’t added any expirations to your account yet. If you need some help, reach <br><br>
				us out on support@renewalhelp.com<br><br>
				We want to make sure you get all information and help from our side to get the renewalhelp started for you and you don’t miss <br><br>
				any renewal.<br><br>
				We are not far away from you, just send a email on our support@renewalhelp.com and we are with you for any questions or<br><br>
				concerns.<br><br>
				
				Thanks,
				<p>RenewalHelp.com</p> <br><br></body></html>');
		
		date_default_timezone_set ( 'UTC' );
		if($mailer->send($message))
		{
			echo "success";
		}
		else {
			echo 'failed';
		}
	}
	
	function sendEmail_7days($userName,$userEmail,$subject){
		$transport = Swift_SmtpTransport::newInstance('ssl://mail.renewalhelp.com', 465)
		->setUsername('contactus@renewalhelp.com') // Your Gmail Username
		->setPassword('Arcorp@321'); // Your Gmail Password
		
		// Mailer
		$mailer = Swift_Mailer::newInstance($transport);
		
		// Create a message
		$message = Swift_Message::newInstance($subject);
		//
			
		$message->setContentType("text/html")
		->setFrom(array('contactus@renewalhelp.com' => 'Renewalhelp.com')) // can be $_POST['email'] etc...
		->setTo(array($userEmail => $userName)) // your email / multiple supported.
		->setBody('<html><body>
					<img  src="'.$message->embed(Swift_Image::fromPath('../img/RenewalHelp_Final_logo.png')).'" height="75px"/>
					<br><br>Hey '.$userName.',<br><br>
		
				Well it seems you haven’t had a chance to get into more details of Renewalhelp.<br><br>
				We are here to offer you to support your business and remind you in advance on your renewal before the expiry with <br><br>
				renewalhelp you can save your time, follow-up ,late fees and penalties.<br><br>
				This is your’s centralized place to manage,monitor & track all your renewal ,so lets get started with adding the next renewal date.<br><br>
				Happy to assist you if you need anything help or information.<br><br>
				Feel free to reach us out on support@renewalhelp.com.<br><br>
				
				Thanks,
				<p>RenewalHelp.com</p> <br><br></body></html>');
		
		date_default_timezone_set ( 'UTC' );
		if($mailer->send($message))
		{
			echo "success";
		}
		else {
			echo 'failed';
		}
	}
	
	function sendEmail_13days($userName,$userEmail,$subject){
		$transport = Swift_SmtpTransport::newInstance('ssl://mail.renewalhelp.com', 465)
		->setUsername('contactus@renewalhelp.com') // Your Gmail Username
		->setPassword('Arcorp@321'); // Your Gmail Password
		
		// Mailer
		$mailer = Swift_Mailer::newInstance($transport);
		
		// Create a message
		$message = Swift_Message::newInstance($subject);
		//
			
		$message->setContentType("text/html")
		->setFrom(array('contactus@renewalhelp.com' => 'Renewalhelp.com')) // can be $_POST['email'] etc...
		->setTo(array($userEmail => $userName)) // your email / multiple supported.
		->setBody('<html><body>
					<img  src="'.$message->embed(Swift_Image::fromPath('../img/RenewalHelp_Final_logo.png')).'" height="75px"/>
					<br><br>Hey '.$userName.',<br><br>
		
				I  wanted to remind you that your renewalhelp trial period is about to expire.<br><br>
				Do not lose access renewal and expirations and do not let those reminders to stop going out.<br><br>
				Would you like to upgrade your renewalhelp subscription now so you can continue to track renewals efficiently!<br><br>
				
				<a href="https://renewalhelp.com/renser/index.php#login"> Login to upgrade.</a> 
				Thanks,
				<p>RenewalHelp.com</p> <br><br></body></html>');
		
		date_default_timezone_set ( 'UTC' );
		if($mailer->send($message))
		{
			echo "success";
		}
		else {
			echo 'failed';
		}
	}
}