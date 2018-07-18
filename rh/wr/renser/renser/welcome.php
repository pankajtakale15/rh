<?php include_once('../service/UserService.php');
      include_once('../common/DB.php');
$configs = include('../common/guiCommon.php');

$useragent=$_SERVER['HTTP_USER_AGENT'];
if(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4)))
    header('Location: https://renewalhelp.com/mobile/renser/renser/welcome');

session_start ();

if(isset($_SESSION['user']) != true)
{
    header("Location: ../../../login.php");
    exit;
}

$user = $_SESSION ["user"];
$userObject1 = json_decode($user);

?>
<!DOCTYPE html>
<html lang="en">
<head>

<title><?php echo $configs->appName; ?></title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="icon" href="../img/favicon.png" type="image/png">
<link rel="stylesheet"
	href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link href="https://fonts.googleapis.com/css?family=Montserrat"
	rel="stylesheet" type="text/css">
<link href="https://fonts.googleapis.com/css?family=Lato"
	rel="stylesheet" type="text/css">
<link href="../css/style.css" rel="stylesheet" type="text/css">
<link href="../css/w3.css" rel="stylesheet" type="text/css">
<link href='https://fonts.googleapis.com/css?family=Diplomata SC'
	rel='stylesheet'>

<link href='https://fonts.googleapis.com/css?family=Courgette'
	rel='stylesheet'>

<link href='https://fonts.googleapis.com/css?family=Faster One'
	rel='stylesheet'>

<link href='https://fonts.googleapis.com/css?family=Great Vibes'
	rel='stylesheet'>

<link href='https://fonts.googleapis.com/css?family=Londrina Shadow'
	rel='stylesheet'>

<link href='https://fonts.googleapis.com/css?family=Sofia' rel='stylesheet'>
<link href="../css/datepicker.css" rel="stylesheet">
<link href="../css/font-awesome.css" rel="stylesheet">
<!-- <link href="../css/font-awesome.min.css" rel="stylesheet"> -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script
	src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script type="text/javascript"
	src="https://ajax.googleapis.com/ajax/libs/angularjs/1.3.14/angular.min.js"></script>
<script
	src="https://ajax.googleapis.com/ajax/libs/angularjs/1.3.14/angular-messages.min.js"></script>
<script
	src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" ></script>
	
<script type="text/javascript" src="../js/common.js"></script>
<script type="text/javascript" src="../js/userCntrl.js"></script>
<script type="text/javascript" src="../js/extendPeriodJS.js"></script>
<script type="text/javascript" src="../js/circle.js"></script>
<script type="text/javascript" src="../js/datentime.js"></script>
<script type="text/javascript" src="../js/amcharts.js"></script>
<script type="text/javascript" src="../js/light.js"></script>
<script type="text/javascript" src="../js/serial.js"></script>
<script src="../js/bootstrap-datepicker.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular.min.js"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script src="scripts/plugin.js"></script>		  
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script type="text/javascript">
    function makePayment()
    {
        var recordId = parseInt(document.getElementById("recId").innerHTML);
        var name = "<?php echo $userObject1->name;?>";
        var loginId = "<?php echo $userObject1->loginId;?>"
        payAmount(name,loginId,recordId);
    }
</script>
<!-- Start Alexa Certify Javascript -->
<script type="text/javascript">
_atrk_opts = { atrk_acct:"+T5vp1IW1d10O7", domain:"renewalhelp.com",dynamic: true};
(function() { var as = document.createElement('script'); as.type = 'text/javascript'; as.async = true; as.src = "https://d31qbv1cthcecs.cloudfront.net/atrk.js"; var s = document.getElementsByTagName('script')[0];s.parentNode.insertBefore(as, s); })();
</script>
<noscript><img src="https://d5nxst8fruw4z.cloudfront.net/atrk.gif?account=+T5vp1IW1d10O7" style="display:none" height="1" width="1" alt="" /></noscript>
<!-- End Alexa Certify Javascript --> 

<style>

/* Remove the navbar's default margin-bottom and rounded borders */
.navbar {
	margin-bottom: 0;
	border-radius: 0;
}

/* Set height of the grid so .sidenav can be 100% (adjust as needed) */
.row.content {
	height: 545px;
}

/* Set gray background color and 100% height */
.sidenav {
	padding-top: 0px;
	background-color: #f1f1f1;
	height: 100%;
}

/* Set black background color, white text and some padding */
footer {
	background-color: #555;
	color: white;
	padding: 0px;
}

/* On small screens, set height to 'auto' for sidenav and grid */
@media screen and (max-width: 767px) {
	.sidenav {
		height: 100%;
		padding: 0px;
	}
	.row.content {
		height: auto;
	}
}
#chartdiv {
  width: 535px;
  height: 350px;
}
</style>
<script>
	var myVar = setInterval(myTimer, 500);
	var res = false;
	function myTimer() {
    	var d = new Date();
    	if (res == false)
    	{
        	var val = document.getElementById("notQnt").innerHTML;
        	if (parseInt(val) > 0){
        		document.getElementById("bell").style.color = "red";
    			document.getElementById("notQnt").style.color = "red";
    			res = true;
        	}
    	}else{
    		var val = document.getElementById("notQnt").innerHTML;
        	if (parseInt(val) > 0){
    			document.getElementById("bell").style.color = "white";
    			document.getElementById("notQnt").style.color = "white";
    			res = false;
        	}
        }
	}
</script>
</head>

<body onload="startTime()" id="headerId" ng-app="renserApp" ng-controller="userCtrl" ng-init="getProfileInfo();getDashboardInfo();getDashboardUserInfo();showPieChart();" style="background-color:#78909C;;">
  
<div class="container-fluid">
		<div class="row content">
			<div class="col-sm-2">
			<nav class="w3-sidebar w3-collapse w3-white w3-animate-left" style="z-index:3;width:210px;" id="mySidebar"><br>
  <div class="w3-container">
    <a href="#" onclick="w3_close()" class="w3-hide-large w3-right w3-jumbo w3-padding w3-hover-grey" title="close menu">
      <i class="fa fa-remove"></i>
    </a>
    <!--<img src="../img/avatar_g2.jpg" style="width:60%;" class="w3-round"> -->
  </div>
  <div class="w3-bar-block">
	<h3 class="w3-bar-item w3-padding" style="font-size:20px;">
		Welcome 	<b><i>{{userProfileDetail.firstName}}</i></b>
	</h3>
	<ul style="padding:0px;margin-top:-20px;">
		<li class="w3-bar-item" style="color: #34e00d;"> <span id="userTypeTitle"></span> (User ID - {{userProfileDetail.userNo}})</li>
	</ul>
	<hr>
	<a href="#" id="vMenuHomeId" ng-click="addActiveClass('vMenuHomeId');changeScreen('home');getRenewalServicesCount();getRenewalServices('all',1,15,100);initGraph();getDashboardInfo();getDashboardUserInfo();showBarChart();showPieChart();" onclick="w3_close()" class="w3-bar-item w3-button w3-padding w3-text-teal active"><i class="fa fa-th-large fa-fw w3-margin-right"></i>DASHBOARD</a> 
	<a href="#" id="vMenuNewRecordId" ng-click="addActiveClass('vMenuNewRecordId');changeScreen('newrecord');hideAlerts('addRenewalServiceAlert');" onclick="w3_close()" class="w3-bar-item w3-button w3-padding"><i class="fa fa-plus-square fa-fw w3-margin-right"></i>NEW RECORD</a> 
    <a href="#" id="vMenuReportId" ng-click="addActiveClass('vMenuReportId');changeScreen('report');getRenewalServicesCount();getRenewalServices('all',1,15,100);initGraph();hideAlerts('reportAlertMsg');" onclick="w3_close()" class="w3-bar-item w3-button w3-padding"><i class="fa fa-bar-chart fa-fw w3-margin-right"></i>REPORT</a> 
    <a href="#" id="vMenuSearchId" ng-click="AddActiveClass('vMenuSearchId'); changeScreen('search'); hideAlerts('searchReportAlertMsg');resetSearchRecord();" onclick="w3_close()" class="w3-bar-item w3-button w3-padding"><i class="fa fa-search fa-fw w3-margin-right"></i>SEARCH</a>
    <a href="#" id="vMenuTemplateId" ng-click="addActiveClass('vMenuTemplateId'); changeScreen('template');getUserTemplate();hideAlerts('templateAlertMsg1');" onclick="w3_close()" class="w3-bar-item w3-button w3-padding"><i class="fa fa-clone fa-fw w3-margin-right"></i>MAIL TEMPLATES</a>   
	<hr>
	<div id="adminBlock" style="display: block">
		<p style="margin-left:20px; color:teal;">ADMIN</P>
		<a href="#" id="vMenuUsersId" ng-click="addActiveClass('vMenuUsersId');changeScreen('users'); getRenewalUsers(); hideAlert('userAlertMsg');resetRenewalUser();" onclick="w3_close()" class="w3-bar-item w3-button w3-padding"><i class="fa fa-user-circle-o fa-fw w3-margin-right"></i>USERS</a> 
		<a href="#" id="vMenuEmailAccountsId" ng-click="addActiveClass('vMenuEmailAccountsId');changeScreen('emailaccounts'); getRenewalEmailAccounts();resetRenewalEmailAccount();" class="w3-bar-item w3-button w3-padding"><i class="fa fa-envelope-o fa-fw w3-margin-right"></i>EMAILS</a> 
		<a href="#" id="vMenuLogsId" ng-click="addActiveClass('vMenuLogsId'); changeScreen('logs');hideAlert('logsAlertMsg');" onclick="w3_close()" class="w3-bar-item w3-button w3-padding"><i class="fa fa-calendar fa-fw w3-margin-right"></i>LOGS</a> 
  		<hr>
	</div>
	
	<a href="#" id="vMenuSupportId" ng-click="addActiveClass('vMenuSupportId'); changeScreen('support');" onclick="w3_close()" class="w3-bar-item w3-button w3-padding"><i class="fa fa-support fa-fw w3-margin-right"></i>SUPPORT</a> 
	<!--<a href="#" id="vMenuContactId" ng-click="addActiveClass('vMenuContactId'); changeScreen('contact');" onclick="w3_close()" class="w3-bar-item w3-button w3-padding"><i class="fa fa-envelope fa-fw w3-margin-right"></i>CONTACT</a>-->
  </div>
</nav>
</div>
		
			<!--<div class="col-sm-2 sidenav" style="padding-top:7px; padding-right:7px; padding-left:20px; height:100%;">

				<div  align="center"> 
[[					<img alt="User Pic" src="{{userProfileDetail.profilePic}}" class="profilePicHeight img-circle img-responsive" > 
                </div>
				<ul class="nav nav-pills nav-stacked vMenu">
					<li id="vMenuHomeId" class="active" ng-click="addActiveClass('vMenuHomeId');">
						<a href="#" class="glyphicon glyphicon-home" ng-click="changeScreen('home');getProfileInfo();" title="Home">&nbsp;Home</a>
					</li>
					<li id="vMenuReportId" ng-click="addActiveClass('vMenuReportId');">
						<a href="#" class="glyphicon glyphicon-list-alt" ng-click="changeScreen('report');getRenewalServicesCount();getRenewalServices('all',1,15,100);initGraph();" title="Reports">&nbsp;Report</a>
					</li>
					
					<li id="vMenuProfileId" ng-click="addActiveClass('vMenuProfileId');">
						<a href="#" class="glyphicon glyphicon-user" ng-click="changeScreen('profile');getProfileInfo();" title="Profile">&nbsp;Profile</a>
					</li>
					<li id="vMenuUsersId" ng-click="addActiveClass('vMenuUsersId');">
						<a href="#" class="glyphicon glyphicon-picture" ng-click="changeScreen('users'); getRenewalUsers();" title="Users">&nbsp;Users</a>
					</li>
					<li id="vMenuEmailAccountsId" ng-click="addActiveClass('vMenuEmailAccountsId');">
						<a href="#" class="glyphicon glyphicon-envelope" ng-click="changeScreen('emailaccounts'); getRenewalEmailAccounts();" title="Email Accounts">&nbsp;Emails</a>
					</li>
					<li id="vMenuLogsId" ng-click="addActiveClass('vMenuLogsId');">
						<a href="#" class="glyphicon glyphicon-picture" ng-click="changeScreen('logs');" title="Logs">&nbsp;Logs</a>
					</li>
				</ul>
				<br>
				<div id="freeUserExpired" class="ng-hide"> <span style="color: red"> </span> 

				</div>
				<div id="freeUserNearToExpire" class="ng-hide"> <span style="color: red"> </span> 

				</div>
				
				<br>
			</div> -->

			<div class="col-sm-10  tab-content" style="background-color:#78909C;">                                                        
				<header id="portfolio">
					<div class="w3-container">
						<div class="row">
							<div class="col-sm-4">
								<img src="../img/RenewalHelp_Final_logo.png" alt="" width="400px" height="125px" STYLE="MARGIN-TOP:7PX;"/>
							</div>
							<div class="col-sm-3"></div>
							<div class="col-sm-5">
								<div id="clockdate">
									<div class="clockdate-wrapper" style="margin-top:20px; margin-right:20px;">
										<div id="clock"></div>
										<div id="date"></div>
									</div>
								</div>
							</div>
						</div>
						<div class="w3-section w3-bottombar w3-padding-16">
							<button class="w3-button w3-black" id="notificationBtn" ng-click="addActiveClass('vMenuReportId');changeScreen('report');getRenewalServicesCount();getRenewalServices('all',1,15,100);initGraph();"><i class="fa fa-bell fa-fw" id="bell" style="margin-right:10px;"></i><span id="notQnt">{{dashboardExpireInFifteen}}</span></button>
							<button ng-click="changeScreen('profile'); getProfileInfo();" class="w3-button w3-white w3-hide-small"><i class="fa fa-user" style="margin-right:10px;"></i>PROFILE</button>
							<button ng-click="logout();"class="w3-button w3-white w3-hide-small"><i class="fa fa-external-link" style="margin-right:10px;"></i>LOGOUT</button>
						<!--	<button class="w3-button w3-white w3-hide-small"><i class="glyphicon glyphicon-question-sign" style="margin-right:10px;"></i>FAQ</button> -->
						</div>
					</div>
				</header>
				
				<div class="tab-pane active" id="general" ng-show="screenVisible['home'].value">
					<div class="container">
						<div id="noRecordAlert" class="ng-hide" style="width:50%; margin-left:-13px;"></div>
						<!-- Chart Section is started from here -->
    					<div class="row" style="margin-left:-30px;margin-right:35px;">
    						<div class="col-sm-6">
								<div id="piechart_3d" style="width: 535px; height: 350px;"></div><br>
							</div>
							<div class="col-sm-6">
								<!-- <div id="columnchart_values"></div><br>-->
								<div id="chartdiv" style="margin-right:30px; background-color:white;"></div>
							</div>
						</div>
						<!-- Chart Section ends at here -->
						
						<div class="row" style="margin-left:-30px; margin-right:35px;">
							<div class="col-sm-2">
								<div class="panel-group">
									<div class="panel panel-default text-center">
										<div class="panel-body" style="background-color:#006064; height:150px; color:#ffffff;"><b style="font-size:30px; margin-bottom:20px;"><span id="gTotalRecords">{{dashboardTotalRecords}}</span></b><br><span style="margin-top:20px; font-size:20px;"> Total Records</span></div>
									</div>
								</div>
							</div>
							<div class="col-sm-2">
								<div class="panel-group">
									<div class="panel panel-default text-center">
										<div class="panel-body" style="background-color:#006064; height:150px; color:#ffffff;"><b style="font-size:30px; margin-bottom:20px;"><span id="gOpenRecords">{{dashboardOpen}}</span></b><br><span style="margin-top:20px; font-size:20px;"> Open Records</span></div>
									</div>
								</div>
							</div>
							<div class="col-sm-2">
								<div class="panel-group">
									<div class="panel panel-default text-center">
										<div class="panel-body" style="background-color:#006064; height:150px; color:#ffffff;"><b style="font-size:30px; margin-bottom:20px;"><span id="gInProgressRecords">{{dashboardInProgress}}</span></b><br><span style="margin-top:20px; font-size:20px;"> In Progress Records</span></div>
									</div>
								</div>
							</div>
							<div class="col-sm-2">
								<div class="panel-group">
									<div class="panel panel-default text-center">
										<div class="panel-body" style="background-color:#006064; height:150px; color:#ffffff;"><b style="font-size:30px; margin-bottom:20px;"><span id="gClosedRecords">{{dashboardClosed}}</span></b><br><span style="margin-top:20px; font-size:20px;"> Closed Records</span></div>
									</div>
								</div>
							</div>
							<div class="col-sm-2">
								<div class="panel-group">
									<div class="panel panel-default text-center">
										<div class="panel-body" style="background-color:#006064; height:150px; color:#ffffff;"><b style="font-size:30px; margin-bottom:20px;">{{dashboardExpireInFifteen}}</b><br><span style="margin-top:20px; font-size:20px;"> Due in 15 days</span></div>
									</div>
								</div>
							</div>
							<div class="col-sm-2">
								<div class="panel-group">
									<div class="panel panel-default text-center">
										<div class="panel-body" style="background-color:#006064; height:150px; color:#ffffff;"><b style="font-size:30px; margin-bottom:20px;">{{dashboardExpiredRecords}}</b><br><span style="margin-top:20px; font-size:20px;"> Expired Records</span></div>
									</div>
								</div>
							</div>
							
							<!--<div class="col-sm-3">
								<div class="panel-group">
									<div class="panel panel-default text-center">
										<div class="panel-heading">No action on Escalation</div>
										<div class="panel-body" style="background-color:#ffffff; height:150px; color:#000000;"><b style="font-size:30px; margin-bottom:15px;">{User Name}</b><br><span style="margin-top:20px; font-size:20px;"> who have not taken action on escalation.</span></div>
									</div>
								</div>
							</div> -->
						</div>	
					</div>
						<div id="userBlock" class="vContainer">
							<div class="row">
								<div class="col-sm-12">
									<div class="panel-group">
										<div class="panel panel-default text-left">
											<div class="panel-heading" style="font-size:15px;"><b>User Details</b></div>
											<div class="panel-body" style="color:#000000;"> 
												<table>
													<tr>
														<th>Sr No</th>
														<th>User Name</th>
														<th>Total Records</th>
														<th>Open</th>
														<th>In Progress</th>
														<th>Closed</th>
														<th>Expired</th>
													</tr>
													<tr data-ng-repeat="dashUser in dashUsers">
														<td>{{$index + 1}}</td>
														<td>{{dashUser.userName}}</td>
														<td>{{dashUser.totalRecords}}</td>
														<td>{{dashUser.openRecords}}</td>
														<td>{{dashUser.inProgressRecords}}</td>
														<td>{{dashUser.closedRecords}}</td>
														<td>{{dashUser.expiredRecords}}</td>
													</tr>
												</table>
											</div>
										</div>
									</div>	 
								</div>	
							</div>
						</div>
						
				</div> 
				<div ng-show="screenVisible['newrecord'].value">
					<div ng-include="'newrecord.php'"></div>
				</div>
				<div ng-show="screenVisible['report'].value">
					<div ng-include="'report.php'"></div>
				</div>
				<div ng-show="screenVisible['users'].value">
					<div ng-include="'users.php'"></div>
				</div>
				<div ng-show="screenVisible['emailaccounts'].value">
					<div ng-include="'email_accounts.php'"></div>
				</div>
				<div ng-show="screenVisible['addemailaccount'].value">
					<div ng-include="'new-emailAccount.php'"></div>
				</div>
				<div ng-show="screenVisible['addUser'].value">
					<div ng-include="'new-user.php'"></div>
				</div>
				<div ng-show="screenVisible['logs'].value">
					<div ng-include="'logs.php'"></div>
				</div>
				<div ng-show="screenVisible['search'].value">
					<div ng-include="'search.php'"></div>
				</div>
				<div ng-show="screenVisible['extract'].value">
					<div ng-include="'extract.php'"></div>
				</div>
				<div ng-show="screenVisible['support'].value">
					<div ng-include="'support.php'"></div>
				</div>
				<div ng-show="screenVisible['template'].value">
					<div ng-include="'template.php'"></div>
				</div>
				<div ng-show="screenVisible['contact'].value">
					<div ng-include="'contact.php'"></div>
				</div>
				<div ng-show="screenVisible['profile'].value">
					<div ng-include="'userProfile.php'"></div>
				</div>
				<div ng-show="screenVisible['downloadninstall'].value">
					<div ng-include="'downloadninstall.php'"></div>
				</div>	
						<div id="myModalprofilePic" class="modal fade" 
											role="dialog" style="padding-top: 15%;">
											<div class="modal-dialog">

												<!-- Modal content-->
												<div class="modal-content">
													<div class="modal-header">
														<button type="button" class="close" 
															data-dismiss="modal">&times;</button>
														<h4 class="modal-title" style="color: black;">Profile
															Picture</h4>
													</div>
													<div class="modal-body">
														<div  id="uploadProfilePicSuccessMSG" ></div>
														<form method="post" enctype="multipart/form-data"
															name="uploaduserprofilePic" required>
															<span style="background: #ccc"
																class="btn btn-default btn-file"> Browse <input
																type="file" file-model="userProfilePic"
																name="userProfilePic" valid-file
																ng-file-select="onFileSelect($files);"
																accept="image/jpg, image/JPG,image/JPEG, image/jpeg"
																required />
															</span> <input ng-click="updateProfilePic();"
																type="submit" value="Upload File"
																class="btn btn-primary start"
																style="height: 60px; width: 150px" />
															<button type="button" class="close" data-dismiss="modal"
																>Close</button>

														</form>
													</div>
												</div>
											</div>
						</div>
				</div>
			</div>

		</div>
</div>

</body>
</html>
