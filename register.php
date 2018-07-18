<?php
try {
	$configs = include ('wr/renser/common/guiCommon.php');
	// echo $configs->appName;
} catch ( Exception $e ) {
	print $e;
}

?>
<!DOCTYPE html>
<html lang="en">

    <head>
   
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Welcome to RenewalHelp</title>

        <!-- CSS -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,400">
        <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Montserrat:700,400">
        <link rel="stylesheet" href="wr/assets/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="wr/assets/elegant-font/code/style.css">
        <link rel="stylesheet" href="wr/assets/css/animate.css">
        <link rel="stylesheet" href="wr/assets/css/magnific-popup.css">
        <link rel="stylesheet" href="wr/assets/flexslider/flexslider.css">
        <link rel="stylesheet" href="wr/assets/css/form-elements.css">
        <link rel="stylesheet" href="wr/assets/css/style.css">
        <link rel="stylesheet" href="wr/assets/css/media-queries.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
			
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->

        <!-- Favicon and touch icons -->
        <link rel="shortcut icon" href="wr/assets/ico/renewalhelpofflinelogo-0.png">
        <link rel="apple-touch-icon-precomposed" sizes="144x144" href="wr/assets/ico/renewalhelpofflinelogo-3.png">
        <link rel="apple-touch-icon-precomposed" sizes="114x114" href="wr/assets/ico/renewalhelpofflinelogo-2.png">
        <link rel="apple-touch-icon-precomposed" sizes="72x72" href="wr/assets/ico/renewalhelpofflinelogo-1.png">
        <link rel="apple-touch-icon-precomposed" href="wr/assets/ico/renewalhelpofflinelogo-4.png">

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/angularjs/1.3.14/angular.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.3.14/angular-messages.min.js"></script>
    </head>

    <body id="headerId" ng-app="renserApp" data-spy="scroll"
		data-target=".navbar" data-offset="60">

		<!-- Login -->
        <div class="services-container" id="login">
	        <div class="container">
	        	<div class="row">
		            <div class="col-sm-12 work-title wow fadeIn">
		                <h3>Register as First User!</h3>
		                <p style="color:#000;" id="noUser" style="display:block">There are no users found in th system!</p>
		                <a href="login.php" id="loginPage" style="display:none">Login from Here!</a><br>
		                <h1 class="fa fa-angle-double-down" style="font-size: 32px; margin-top: -5px; margin-bottom: -10px;"></h1>
		                <hr>
		            </div>
	            </div>
	            
	            <div id="login" class="text-center"
					ng-controller="loginCtrl" ng-init="recaptcha();">
				
					<div class= "row contact">
						<div id="loginbox" class="col-md-4 logincornerhighlight col-centered panel price-panel"
							style="margin-top: 10px; margin-bottom: 50px; width: 500px;">
							<div class="form-login">
								<div id="loginFormMsg" class="ng-hide"></div>
								<form name="userloginForm" method="post"
									enctype="multipart/form-data">
									<div style="margin-bottom: 25px" class="input-group">
										<span class="input-group-addon"><i
												class="glyphicon glyphicon-user"></i></span> 
										<input id="firstName"
												name="firstName" ng-model="loginForm.firstName" type="text"
												class="form-control" placeholder="First Name" ng-required="true">
									</div>
									<div style="margin-bottom: 25px" class="input-group">
										<span class="input-group-addon"><i
												class="glyphicon glyphicon-user"></i></span> 
										<input id="lastName"
												name="lastName" ng-model="loginForm.lastName" type="text"
												class="form-control" placeholder="Last Name" ng-required="true">
									</div>
									<div style="margin-bottom: 25px" class="input-group">
										<span class="input-group-addon"><i
												class="glyphicon glyphicon-education"></i></span> 
										<input id="designation"
												name="designation" ng-model="loginForm.designation" type="text"
												class="form-control" placeholder="Designation" ng-required="true">
									</div>
									<div style="margin-bottom: 25px" class="input-group">
										<span class="input-group-addon"><i
												class="glyphicon glyphicon-user"></i></span> 
										<input id="userName"
												name="userName" ng-model="loginForm.userName" type="text"
												class="form-control" placeholder="Username" ng-required="true">
									</div>
									<div style="margin-bottom: 25px" class="input-group">
										<span class="input-group-addon"><i
												class="glyphicon glyphicon-envelope"></i></span> 
										<input id="emailId"
												name="emailId" ng-model="loginForm.emailId" type="text"
												class="form-control" placeholder="Email Id" ng-required="true">
									</div>
									<div style="margin-bottom: 25px" class="input-group">
										<span class="input-group-addon"><i
												class="glyphicon glyphicon-lock"></i></span> 
										<input type="password" class="form-control" id="userPassword"
												name="userPassword" ng-model="loginForm.userPassword"
												placeholder="Password" ng-required="true">
									</div>
									<p style="color: #000;">*This user will hold the admin access!
									<div class="wrapper">
										<span class="group-btn loginBtn">
											{{loginForm.$invalid}}
											<button ng-disabled="userloginForm.$invalid"
												ng-click="firstRegistration()"
												title="Login" class="btn btn-primary btn-md">
												Register <i class="fa fa-sign-in"></i>
											</button>
										</span>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		
        <!-- Javascript -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/angularjs/1.3.14/angular.min.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.3.14/angular-messages.min.js"></script>
        <script src="wr/assets/js/jquery-1.11.1.min.js"></script>
        <script src="wr/assets/bootstrap/js/bootstrap.min.js"></script>
        <script src="wr/assets/js/bootstrap-hover-dropdown.min.js"></script>
        <script src="wr/assets/js/wow.min.js"></script>
        <script src="wr/assets/js/retina-1.1.0.min.js"></script>
        <script src="wr/assets/js/jquery.magnific-popup.min.js"></script>
        <script src="wr/assets/flexslider/jquery.flexslider-min.js"></script>
        <script src="wr/assets/js/jflickrfeed.min.js"></script>
        <script src="wr/assets/js/masonry.pkgd.min.js"></script>
        <script src="http://maps.google.com/maps/api/js?sensor=true"></script>
        <script src="wr/assets/js/jquery.ui.map.min.js"></script>
        <script src="wr/assets/js/scripts.js"></script>
        <script src="wr/assets/js/sliderMnger.js"></script>
        <script src="wr/assets/js/smoothscroll.js"></script>
        <script type="text/javascript" src="wr/renser/js/common.js"></script>
        <script type="text/javascript" src="wr/renser/js/userCntrl.js"></script>
        <script type="text/javascript" src="wr/renser/js/v_count.js"></script>
       
    </body>

</html>