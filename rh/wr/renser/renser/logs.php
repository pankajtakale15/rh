<?php 
session_start ();

$user = $_SESSION ["user"];

$userObject2 = json_decode ( $user );

?>

<script src="../js/Chart.bundle.js"></script>
<script src="../js/utils.js"></script>
<div class="container" ng-init="getRenewalLogs('All', 0, 15)" style="margin-left: -10px;">
  
  <ul class="nav nav-tabs" style="width:1110px;">
    <li  class="active"><a data-toggle="tab" href="#allLogs" ng-click="initGraph();getRenewalLogs('All');hideAlert('reportAlertMsg');" style="color:black;"><b>All Logs</b></a></li>
    <li><a data-toggle="tab" href="#byUser" ng-click="initGraph();getRenewalUsers();hideAlert('reportAlertMsg2');resetLogsRecordByUser();" style="color:black;"><b>Logs By User</b></a></li>
    <li><a data-toggle="tab" href="#byDate" ng-click="initGraph();hideAlert('reportAlertMsg3');resetLogsRecordByDate();" style="color:black;"><b>Logs By Date</b></a></li>
  </ul>
  <div class="tab-content" style="width:1110px;">
    <div id="allLogs" class="tab-pane fade  in active" style="width:1110px;">
	     <div class="panel panel-default" style="border-top: none;border-color: #eee;">
			
			<div class="panel-body">
				<div class="row renewalMarginBottom" style="margin-top: 20px">
					<div class="col-md-12 "  frame="box" style="background-color: white;border-right: 1px solid #e3e3e3;">
						<div id="logsAlertMsg" class="ng-hide"></div>
							
							<div class="table-responsive">
								<div class="row text-right" style="margin-right: 15px;">
									<p><span id="log_from1">0</span> - <span id="log_to1">15</span></p>
								</div>
							<table id="renserGridId2" class="table table-bordered"  style="width: 100%; max-width: 250%;">
								<thead>
									<tr class="header">
									<th>Log Id</th>
									<th>Log Date</th>
									    <th>Log Activity</th>
										<th>Log Activity Id</th>
										<th>Log Description</th>
										<th>Performed By</th>
									<!--	<th>Extend Period of Record</th> -->
									</tr>
								</thead>
								<tr data-ng-repeat="renewalLog in renewalLogsList" id="reportTableRow_{{renewalService.id}}">
									<td class="text-center"><span ng-show="!renewalServiceDetails.showEdit">{{renewalLog.id}}</span>
									<td class="text-center" style="text-align:left;"><span ng-show="!renewalServiceDetails.showEdit">{{renewalLog.logDate}}</span>
									<td style="text-align:left;"><span ng-show="!renewalServiceDetails.showEdit">{{renewalLog.logActivity}}</span>
									<td class="text-center"><span ng-show="!renewalServiceDetails.showEdit">{{renewalLog.logActivityId}}</span>
									<td style="text-align:left;"><span ng-show="!renewalServiceDetails.showEdit">{{renewalLog.logDescription}}</span>
									<td class="text-center"><span ng-show="!renewalServiceDetails.showEdit">{{renewalLog.performedBy}}</span>
								</tr>
							</table>
							</div>
							
							<button id="prev_btn" ng-click="loadPrevLogs()">Previous</button>
							<button id="next_btn" ng-click="loadNextLogs()">Next</button>
							
					</div>
				<!--	<div class="col-md-3">
					
						<canvas id="chart-area" />
						<span>* Data in %</span> 
						<table frame="border" style="width: 250px;" >
						<tr style="border-bottom: 1px; border-spacing: 10px; text-align: left;" ng-repeat="bg in backgroundClrAndCat"> <td width="20px" height="5px" align="right" style="background-color: {{bg[1]}}">
						
						</td>
						<td>
						 - {{bg[0]}}
						</td>
						</tr>
						</table>
       					
					</div> -->
				
				</div>
			</div>
	    </div>
    </div>
    
    <div id="byUser" class="tab-pane fade">
	     <div class="panel panel-default" style="border-top: none;border-color: #eee;">
			
			<div class="panel-body">
				<div class="row renewalMarginBottom" style="margin-top: 20px">
					<div class="col-md-12 "  frame="box" style="background-color: white;border-right: 1px solid #e3e3e3;">
						<div id="reportAlertMsg2" class="ng-hide"></div>
						
						<div class="row" style="margin-top:10px;" id="textSearch">
						    <div class="col-md-4">
						        <select id="logUserList" class="form-control">
									<option value="">Select User</option>
									<option  ng-repeat="logUser in renewalUsersList" value="{{logUser.userNo}}" >{{logUser.userName}}</option>
								</select>
						    </div>
						    <div class="col-md-2">
						        <button class="btn btn-primary" id="searchBtn" name="searchBtn" ng-click="getRenewalLogsByUser(0, 15);getRenewalLogsByUser();">Search</button>
						    </div>
						</div>
						<hr>	
						<div class="table-responsive">
							<div class="row text-right" style="margin-right: 15px;">
								<p><span id="log_from2">0</span> - <span id="log_to2">0</span></p>
							</div>
							<table id="renserGridId2" class="table table-bordered"  style="width: 100%; max-width: 250%;">
								<thead>
									<tr class="header">
									<th>Log Id</th>
									<th>Log Date</th>
									    <th>Log Activity</th>
										<th>Log Activity Id</th>
										<th>Log Description</th>
										<th>Performed By</th>
									<!--	<th>Extend Period of Record</th> -->
									</tr>
								</thead>
								<tr data-ng-repeat="renewalLogByUser in renewalLogsByUserList" id="reportTableRow_{{renewalService.id}}">
									<td class="text-center"><span ng-show="!renewalServiceDetails.showEdit">{{renewalLogByUser.id}}</span>
									<td class="text-center" style="text-align:left;"><span ng-show="!renewalServiceDetails.showEdit">{{renewalLogByUser.logDate}}</span>
									<td style="text-align:left;"><span ng-show="!renewalServiceDetails.showEdit">{{renewalLogByUser.logActivity}}</span>
									<td class="text-center"><span ng-show="!renewalServiceDetails.showEdit">{{renewalLogByUser.logActivityId}}</span>
									<td style="text-align:left;"><span ng-show="!renewalServiceDetails.showEdit">{{renewalLogByUser.logDescription}}</span>
									<td class="text-center"><span ng-show="!renewalServiceDetails.showEdit">{{renewalLogByUser.performedBy}}</span>
								</tr>
							</table>
							</div>
							
							<button id="prev_btn1" ng-click="loadPrevLogsByUser()">Previous</button>
							<button id="next_btn1" ng-click="loadNextLogsByUser()">Next</button>
					</div>
				</div>
			</div>
	    </div>
    </div>
    
    <div id="byDate" class="tab-pane fade">
	     <div class="panel panel-default" style="border-top: none;border-color: #eee;">
			
			<div class="panel-body">
				<div class="row renewalMarginBottom" style="margin-top: 20px">
					<div class="col-md-12"  frame="box" style="background-color: white;border-right: 1px solid #e3e3e3;">
						<div id="reportAlertMsg3" class="ng-hide"></div>
							
							<div class="row" style="margin-top:10px;" id="textSearch">
						    	<div class="col-md-4">
						        	<div class="input-group">
									<input type="text" id="searchDate"
										class="form-control"
										ng-model="renewalService.searchDate" datepicker></input><span
										class="input-group-addon" id="basic-addon1"><span
										class="glyphicon glyphicon-calendar"></span>
									
									
										<!--<input type="text" id="searchDate"
												class="form-control" placeholder="MM/DD/YYYY"></input><span
												class="input-group-addon"><span
												class="glyphicon glyphicon-calendar"></span> -->
									</div>
						    	</div>
						    	<div class="col-md-2">
						       		<button class="btn btn-primary" id="searchBtn" name="searchBtn" ng-click="getRenewalLogsByDate(0, 15);">Search</button>
						    	</div>
							</div>
							<hr>	
							
							<div class="table-responsive">
								<div class="row text-right" style="margin-right: 15px;">
									<p><span id="log_from3">0</span> - <span id="log_to3">0</span></p>
								</div>
							<table id="renserGridId2" class="table table-bordered"  style="width: 100%; max-width: 250%;">
								<thead>
									<tr class="header">
									<th>Log Id</th>
									<th>Log Date</th>
									    <th>Log Activity</th>
										<th>Log Activity Id</th>
										<th>Log Description</th>
										<th>Performed By</th>
									<!--	<th>Extend Period of Record</th> -->
									</tr>
								</thead>
								<tr data-ng-repeat="renewalLogByDate in renewalLogsByDateList" id="reportTableRow_{{renewalService.id}}">
									<td class="text-center"><span ng-show="!renewalServiceDetails.showEdit">{{renewalLogByDate.id}}</span>
									<td class="text-center" style="text-align:left;"><span ng-show="!renewalServiceDetails.showEdit">{{renewalLogByDate.logDate}}</span>
									<td style="text-align:left;"><span ng-show="!renewalServiceDetails.showEdit">{{renewalLogByDate.logActivity}}</span>
									<td class="text-center"><span ng-show="!renewalServiceDetails.showEdit">{{renewalLogByDate.logActivityId}}</span>
									<td style="text-align:left;"><span ng-show="!renewalServiceDetails.showEdit">{{renewalLogByDate.logDescription}}</span>
									<td class="text-center"><span ng-show="!renewalServiceDetails.showEdit">{{renewalLogByDate.performedBy}}</span>
								</tr>
							</table>
							</div>
							
							<button id="prev_btn2" ng-click="loadPrevLogsByDate()">Previous</button>
							<button id="next_btn2" ng-click="loadNextLogsByDate()">Next</button>
					</div>
				</div>
			</div>
	    </div>
    </div>
    
    </div>
   </div>