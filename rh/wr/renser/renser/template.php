<?php 
session_start ();

$user = $_SESSION ["user"];

$userObject2 = json_decode ( $user );

?>

<script src="../js/Chart.bundle.js"></script>
<script src="../js/utils.js"></script>
<div class="container" ng-init="getRenewalLogs('All')">
  
  <ul class="nav nav-tabs" style="margin-right:200px;">
    <li  class="active" ng-click="getUserTemplate();hideAlerts('templateAlertMsg1');"><a data-toggle="tab" href="#forUser" style="color:#000000; font-size:15px"><b>For User</b></a></li>
    <li ng-click="getEscalationTemplate();hideAlerts('templateAlertMsg2');"><a data-toggle="tab" href="#forEscalation" style="color:#000000"><b>For Escalation</b></a></li>
    <li ng-click="getVendoreTemplate();hideAlerts('templateAlertMsg3');"><a data-toggle="tab" href="#forVendore" style="color:#000000"><b>For Vendor</b></a></li>
  </ul>
  <div class="tab-content" style="margin-right:200px;">
    <div id="forUser" class="tab-pane fade  in active">
	     <div class="panel panel-default" style="border-top: none;border-color: #eee;">
			
			<div class="panel-body">
				<div class="row renewalMarginBottom" style="margin-top: 20px">
					<div class="col-md-12 "  frame="box" style="background-color: white;border-right: 1px solid #e3e3e3;">
						<div id="templateAlertMsg1" class="ng-hide"></div>
						<div class="row">
							<div class="col-sm-1">
							</div>
							<div class="col-sm-8">
								<h2 style="margin-bottom:20px;">Mail Template for User</h2>
							</div>	
						</div>
						<div class="row">
							<div class="col-sm-1">
							</div>
							<div class="col-sm-8">
								<input type="text" id="subForUser" style="width:100%;" name="subForUser" placeholder="Enter subjet" ng-model="subject"/><br><br>
								<textarea id="msgForUser" style="width:100%;" name="msgForUser" placeholder="Enter message" ng-model="message"/><br><br>
								<div class="row text-right">
									<a href="#" title="Set Template" type="button" id="setTemplateForUser" ng-click="setTemplate('user');" class="btn btn-info btn-primary">Set Templates</a>
								</div>
							</div>	
						</div>	
					</div>
				</div>
			</div>
	    </div>
    </div>
    
    <div id="forEscalation" class="tab-pane fade">
	     <div class="panel panel-default" style="border-top: none;border-color: #eee;">
			
			<div class="panel-body">
				<div class="row renewalMarginBottom" style="margin-top: 20px">
					<div class="col-md-12 "  frame="box" style="background-color: white;border-right: 1px solid #e3e3e3;">
						<div id="templateAlertMsg2" class="ng-hide"></div>
						<div class="row">
							<div class="col-sm-1">
							</div>
							<div class="col-sm-8">
								<h2 style="margin-bottom:20px;">Mail Template for Escalation</h2>
							</div>	
						</div>
						<div class="row">
							<div class="col-sm-1">
							</div>
							<div class="col-sm-8">
								<input type="text" id="subForEscalation" style="width:100%;" name="subForEscalation" placeholder="Enter subjet" ng-model="subject"/><br><br>
								<textarea id="msgForEscalation" style="width:100%;" name="msgForEscalation" placeholder="Enter message" ng-model="message"/><br><br>
								<div class="row text-right">
									<a href="#" title="Set Template" type="button" id="setTemplateForEscalation" ng-click="setTemplate('escalation');" class="btn btn-info btn-primary">Set Templates</a>
								</div>
							</div>	
						</div>	
					</div>
				</div>
			</div>
	    </div>
    </div>
    
    <div id="forVendore" class="tab-pane fade">
	     <div class="panel panel-default" style="border-top: none;border-color: #eee;">
			<div class="panel-body">
				<div class="row renewalMarginBottom" style="margin-top: 20px">
					<div class="col-md-12 "  frame="box" style="background-color: white;border-right: 1px solid #e3e3e3;">
						<div id="templateAlertMsg3" class="ng-hide"></div>
						<div class="row">
							<div class="col-sm-1">
							</div>
							<div class="col-sm-8">
								<h2 style="margin-bottom:20px;">Mail Template for Vendor</h2>
							</div>	
						</div>
						<div class="row">
							<div class="col-sm-1">
							</div>
							<div class="col-sm-8">
								<input type="text" id="subForVendore" style="width:100%;" name="subForVendore" placeholder="Enter subjet" value=""/><br><br>
								<textarea id="msgForVendore" style="width:100%;" name="msgForVendore" placeholder="Enter message" value=""/><br><br>
								<div class="row text-right">
									<a href="#" title="Set Template" type="button" id="setTemplateForVendore" ng-click="setTemplate('vendore');" class="btn btn-info btn-primary">Set Templates</a>
								</div>
							</div>	
						</div>	
					</div>
				</div>
			</div>
	    </div>
    </div>
    
    </div>
   </div>