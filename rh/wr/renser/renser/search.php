<?php 
session_start ();

$user = $_SESSION ["user"];

$userObject2 = json_decode ( $user );

?>

<script src="../js/Chart.bundle.js"></script>
<script src="../js/utils.js"></script>
<style>
    /* The Modal (background) */
.backGroundRed {
    background: red;
}
.modal1 {
    display: none; /* Hidden by default */
    position: fixed; /* Stay in place */
    z-index: 1; /* Sit on top */
    padding-top: 100px; /* Location of the box */
    left: 0;
    top: 0;
    width: 100%; /* Full width */
    height: 100%; /* Full height */
    overflow: auto; /* Enable scroll if needed */
    background-color: rgb(0,0,0); /* Fallback color */
    background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
}

/* Modal Content */
.modal1-content {
    position: relative;
    background-color: #fefefe;
    margin: auto;
    padding: 0;
    border: 1px solid #888;
    width: 70%;
    box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2),0 6px 20px 0 rgba(0,0,0,0.19);
    -webkit-animation-name: animatetop;
    -webkit-animation-duration: 0.4s;
    animation-name: animatetop;
    animation-duration: 0.4s
}

/* Add Animation */
@-webkit-keyframes animatetop {
    from {top:-300px; opacity:0} 
    to {top:0; opacity:1}
}

@keyframes animatetop {
    from {top:-300px; opacity:0}
    to {top:0; opacity:1}
}

/* The Close Button */
.close {
    color: black;
    float: right;
    font-size: 28px;
    font-weight: bold;
}

.close:hover,
.close:focus {
    color: red;
    text-decoration: none;
    cursor: pointer;
}

.modal1-header {
    padding: 2px 16px;
    background-color: skyblue;
    color: white;
    text-align: center;
}
.modal1-footer {
    padding: 2px 16px;
    background-color: white;
    color: white;
}
.modal1-body {padding: 2px 16px;}

    
</style>
<script>
    function setInputType()
    {
        var val = document.getElementById("searchType").value;
        if(val == "expiry"){
            document.getElementById("textSearch").style.display = "none";
            document.getElementById("expirySearch").style.display = "none";
        }else{
            document.getElementById("textSearch").style.display = "block";
        }
    }
</script>
<script>
function isNumberKey(evt){
	var charCode = (evt.which) ? evt.which : event.keyCode;
	if (charCode > 31 && (charCode < 48 || charCode > 57))
    	return false;
	return true;
}
</script>

<div class="container w3-collapse">
  
  <div class="tab-content" style="margin-right:40px; margin-left:-10px;">
    
    <div id="searchRecord" class="tab-pane fade  in active">
	     <div class="panel panel-default" style="border-top: none;border-color: #eee;">
			
			<div class="panel-body">
				<div class="row renewalMarginBottom" style="margin-top: 20px">
					<div class="col-md-12 "  frame="box" style="background-color: white;border-right: 1px solid #e3e3e3;">
						<div id="searchReportAlertMsg" class="ng-hide"></div>
						
						<div class="row">
						    <div class="col-md-6">
						        <select class="form-control" id="searchType" onchange="setInputType();">
								    <option value="default1">Select category to search</option>
								    <option value="cat">By category</option>
								    <option value="subcat">By sub-category</option>
								    <option value="description">By description</option>
								    <option value="supplier">By supplier</option>
							    </select>
							</div>
						</div>
						
						<div class="row" style="margin-top:10px;" id="textSearch">
						    <div class="col-md-4">
						        <input type="text" id="searchQuery" name="searchQuery" class="form-control" placeholder="Enter your query..."/>
						    </div>
						    <div class="col-md-2">
						        <button class="btn btn-primary" id="searchBtn" name="searchBtn" ng-click="searchRecord();" style="background-color:#006064">Search</button>
						    </div>
						</div>
						<div class="row" style="margin-top:10px; display:none" id="expirySearch">
						    <div class="col-md-6">
						        <div class="input-group">
						        <input type="text" id="searchdate"
									class="form-control"
									ng-model="renewalService.expiryDate" 
									ng-change="searchRecord();" datepicker></input>
									<span   class="input-group-addon" id="basic-addon5"> 
									    <span class="glyphicon glyphicon-calendar"></span></span>
								</div>
						    </div>
						</div>
						
						<br><br>
						<div class="table-responsive">
							<table id="renserGridId2" class="table table-bordered"  style="width: 250%; max-width: 250%;">
								<thead>
									<tr class="header">
									<th>Status</th>
									<th>Delete</th>
									    <th>Edit</th>
									    <th>Current Process Status</th>
										<th>Update Process Status</th>
										<th>Category<span style="color:red">*</span></th>
										<th>Sub category<span style="color:red">*</span></th>
										<th>Description<span style="color:red">*</span></th>
										<th>Model</th>
										<th>Amount</th>
										<th>GST</th>
										<th>Supplier Name</th>
										<th>Supplier Email</th>
										<th>Supplier Contact</th>
										<th>Location</th>
										<th>Contract Number</th>
										<th>Purchase Date<span style="color:red">*</span></th>
										<th>Expiry Date<span style="color:red">*</span></th>
										<th>Set Reminder<span style="color:red">*</span></th>
										<th>Remaining Days</th>
										<th>File</th>
										<th>Submited On</th>
										<!--  <th>Look vendor</th> -->
									<!--	<th>Extend Period of Record</th> -->
									</tr>
								</thead>
								<tr data-ng-repeat="renewalService in searchedServicesList" id="reportTableRow_{{renewalService.id}}">
								<td class="text-center"><span class="glyphicon glyphicon-record" title="{{renewalService.remainingDays < 1 ? 'Deactive' : 'Active'}}" ng-class="renewalService.remainingDays < 1 ? 'serviceDeactive' : 'serviceActive'"></span>
								<span class="ng-hide">{{renewalService.remainingDays < 1 ? 'Deactive' : 'Active'}}</span>
								</td>
									<td class="text-center"><a class="label label-danger" href="" ng-click="deleteReport(renewalService,renewalService.id,renewalService.category,renewalService.subcategory);getUserInfo();getDashboardInfo();"><span class="glyphicon glyphicon-remove"></span> Delete
									</a>
									<span class="ng-hide">Not deleted</span>
									</td>
									<td class="text-center"> 
									<a title="Edit" ng-show="!renewalServiceDetails.showEdit" data-toggle="tooltip" type="button" ng-click="renewalServiceDetails.showEdit = !renewalServiceDetails.showEdit;validateRenewalService=false;" class="btn btn-xs btn-info glyphicon glyphicon-edit"></a>
                                    
                                    <a style="cursor:pointer;  color: green; " title="Save" ng-show="renewalServiceDetails.showEdit" ng-click="renewalServiceDetails.showEdit = !renewalServiceDetails.showEdit;updateRenewalService(renewalService,renewalService.id);" class="btn btn-xs btn-primary glyphicon glyphicon-ok-circle"></a>
                      
                                    <a style="cursor:pointer; ; color: red; " title="Cancel" ng-show="renewalServiceDetails.showEdit"  ng-click="renewalServiceDetails.showEdit = !renewalServiceDetails.showEdit; " class="btn btn-xs btn-warning glyphicon glyphicon-remove-circle"></a>
                                    </td>
                                    <td><span ng-bind="renewalService.currentStatus" id="currentStatus_{{renewalService.id}}"></span></td>
                                    <td><select ng-model="renewalService.updateStatus" id="updateProcessStatus_{{renewalService.id}}" ng-change="updateProcessStatus(renewalService.id)" class="form-control">
											<option value="OPEN" selected="selected">OPEN</option>
											<option value="IN PROGRESS">IN PROGRESS</option>
											<option value="CLOSE">CLOSE</option>
										</select>
									</td>
									<td><span ng-bind="renewalService.category" id="cat_{{renewalService.id}}"></span></td>
									<td><span ng-bind="renewalService.subcategory" id="subcat_{{renewalService.id}}"></span></td>
									<td><span ng-show="!renewalServiceDetails.showEdit">{{renewalService.description}}</span>
									<input ng-show="renewalServiceDetails.showEdit" type="text" class="form-control" ng-model="renewalService.description" id="description_{{renewalService.id}}"></td>
									<td><span ng-show="!renewalServiceDetails.showEdit">{{renewalService.model}}</span>
									<input ng-show="renewalServiceDetails.showEdit" type="text" class="form-control" ng-model="renewalService.model" id="model_{{renewalService.id}}"></td>
									<td class="text-center"><span ng-show="!renewalServiceDetails.showEdit">{{renewalService.amount}}</span>
									<input ng-show="renewalServiceDetails.showEdit" type="text" class="form-control" ng-model="renewalService.amount" id="amount_{{renewalService.id}}" onkeypress="return isNumberKey(event)"></td>
									<td class="text-center"><span ng-show="!renewalServiceDetails.showEdit">{{renewalService.gst}}</span>
									<input ng-show="renewalServiceDetails.showEdit" type="text" class="form-control" ng-model="renewalService.gst" id="gst_{{renewalService.id}}"></td>
									<td><span ng-show="!renewalServiceDetails.showEdit">{{renewalService.supplierName}}</span>
									<input ng-show="renewalServiceDetails.showEdit" type="text" class="form-control" ng-model="renewalService.supplierName" id="supplierName_{{renewalService.id}}"></td>
									<td><span ng-show="!renewalServiceDetails.showEdit">{{renewalService.supplierEmail}}</span>
									<input ng-show="renewalServiceDetails.showEdit" type="text" class="form-control" ng-model="renewalService.supplierEmail" id="supplierEmail_{{renewalService.id}}"></td>
									<td class="text-center"><span ng-show="!renewalServiceDetails.showEdit">{{renewalService.supplierContact}}</span>
									<input ng-show="renewalServiceDetails.showEdit" type="text" class="form-control" ng-model="renewalService.supplierContact" id="supplierContact_{{renewalService.id}}" onkeypress="return isNumberKey(event)"></td>
									<td><span ng-show="!renewalServiceDetails.showEdit">{{renewalService.location}}</span>
									<input ng-show="renewalServiceDetails.showEdit" type="text" class="form-control" ng-model="renewalService.location" id="location_{{renewalService.id}}"></td>
									<td class="text-center"><span ng-show="!renewalServiceDetails.showEdit">{{renewalService.contractNo}}</span>
									<input ng-show="renewalServiceDetails.showEdit" type="text" class="form-control" ng-model="renewalService.contractNo" id="contractNo_{{renewalService.id}}"></td>
									<td class="text-center"><span ng-show="!renewalServiceDetails.showEdit">{{renewalService.purchaseDate.slice(0, 10)}}</span>
									    <div class="input-group" ng-show="renewalServiceDetails.showEdit">
										    <input type="text" id="purchaseDate_{{renewalService.id}}" ng-show="renewalServiceDetails.showEdit"
												class="form-control"
											    ng-model="renewalService.purchaseDate" datepicker></input><span ng-show="renewalServiceDetails.showEdit"
												class="input-group-addon" id="basic-addon1"><span ng-show="renewalServiceDetails.showEdit"
												class="glyphicon glyphicon-calendar"></span>
									</div></td>
									<td class="text-center"><span ng-show="!renewalServiceDetails.showEdit">{{renewalService.expiryDate.slice(0, 10)}}</span>
									    <div class="input-group" ng-show="renewalServiceDetails.showEdit">
										    <input type="text" id="expiryDate_{{renewalService.id}}" ng-show="renewalServiceDetails.showEdit"
												class="form-control"
											    ng-model="renewalService.expiryDate" ng-change="calDiffUpdateRecord(renewalService.expiryDate, renewalService.id);" datepicker></input><span ng-show="renewalServiceDetails.showEdit"
												class="input-group-addon" id="basic-addon1"><span ng-show="renewalServiceDetails.showEdit"
												class="glyphicon glyphicon-calendar"></span>
									</div></td>
									<!-- <td><span ng-bind="renewalService.comment"></span></td>-->
									<td class="text-center"><span ng-show="!renewalServiceDetails.showEdit">{{renewalService.reminderBefore}}</span>
									<select ng-show="renewalServiceDetails.showEdit" ng-model="renewalService.reminderBefore" class="form-control" id="reminderBefore_{{renewalService.id}}">
											<option value="">Select Reminder</option>
											<option ng-repeat="reminderObj in reminderList" value="{{reminderObj.id}}" ng-hide="dayDifference < {{reminderObj.id}}">{{reminderObj.id}}</option>
									</select></td>
									<td class="text-center"><span ng-bind="renewalService.remainingDays"></span></td>
									<td><a ng-hide="renewalService.filepath==''" class="glyphicon glyphicon-download-alt btn btn-default"
									 style="font:16px;color: white;" title="{{renewalService.filepath}}" 
									 href="../controller/downloadFile1.php?name={{renewalService.filepath}}&filepath=uploads/<?php echo $userObject2->imgDir;?>"> </a>
								    </td>
								    <td>{{renewalService.submitedOn}}</td>
								    <!--<td><button class="btn btn-primary" id="getVendor" ng-click="vendoreModal(renewalService.id)" name="getVendor">Get Vendor</button></td>-->
		                         <!--   <td><button class="btn btn-success" id="extendPeriod" ng-click="extendPeriod(renewalService.id)" name="extendPeriod">Extend</button></td> -->
								</tr>
							</table>
							</div>
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
    
   <!-- <div id="searchRecord" class="tab-pane fade">
	     <div class="panel panel-default" style="border-top: none;border-color: #eee;">
			
			<div class="panel-body">
				<div class="row renewalMarginBottom" style="margin-top: 20px">
					<div class="col-md-12"  frame="box" style="background-color: white;border-right: 1px solid #e3e3e3;">
						<div id="searchReportAlertMsg" class="ng-hide"></div>
						<div id="reportAlertMsg" class="ng-hide"></div>
						<div class="row">
						    <div class="col-md-6">
						        <select class="form-control" id="searchType" onchange="setInputType()">
								    <option value="default1">Select search category</option>
								    <option value="cat">By category</option>
								    <option value="subcat">By sub-category</option>
								    <option value="description">By description</option>
								    <option value="supplier">By supplier</option>
							    </select>
							</div>
						</div>
						<div class="row" style="margin-top:10px;display:none" id="textSearch">
						    <div class="col-md-4">
						        <input type="text" id="searchQuery" name="searchQuery" class="form-control" placeholder="Enter your query..."/>
						    </div>
						    <div class="col-md-2">
						        <button class="btn btn-primary" id="searchBtn" name="searchBtn" ng-click="searchRecord();" style="background-color:#006064">Search</button>
						    </div>
						</div>
						<div class="row" style="margin-top:10px; display:none" id="expirySearch">
						    <div class="col-md-6">
						        <div class="input-group">
						        <input type="text" id="searchdate"
									class="form-control"
									ng-model="renewalService.expiryDate" 
									ng-change="searchRecord();" datepicker></input>
									<span   class="input-group-addon" id="basic-addon5"> 
									    <span class="glyphicon glyphicon-calendar"></span></span>
								</div>
						    </div>
						</div>
							
							<div class="table-responsive" style="margin-top:15px">
							<table id="renserGridId2" class="table table-bordered" style="width: 250%; max-width: 250%;" >
								<thead>
									<tr class="header">
									<th>Status</th>
									<th>Delete</th>
									    <th>Edit</th>
									    <th>Current Process Status</th>
										<th>Update Process Status</th>
										<th>Category</th>
										<th>Sub category</th>
										<th>Description</th>
										<th>Model</th>
										<th>Amount</th>
										<th>GST</th>
										<th>Supplier Name</th>
										<th>Supplier Email</th>
										<th>Supplier Contact</th>
										<th>Location</th>
										<th>Contract Number</th>
										<th>Purchase Date</th>
										<th>Expiry Date</th>
										<!--  <th>Comment</th>
										<th>Set Reminder</th>
										<th>Remaining Days</th>
										<th>File</th>
										<th>Look vendor</th>
									</tr>
								</thead>
								<tr data-ng-repeat="renewalService in searchedServicesList" id="reportTableRow_{{renewalService.id}}">
								<td><span class="glyphicon glyphicon-record" title="{{renewalService.remainingDays < 1 ? 'Deactive' : 'Active'}}" ng-class="renewalService.remainingDays < 1 ? 'serviceDeactive' : 'serviceActive'"></span>
								<span class="ng-hide">{{renewalService.remainingDays < 1 ? 'Deactive' : 'Active'}}</span>
								</td>
									<td ><button class="label label-danger" ng-click="deleteReport(renewalService,renewalService.id,renewalService.category,renewalService.subcategory);getUserInfo();" ng-disabled="deletePermission == 'NO'"><span class="glyphicon glyphicon-remove"></span> Delete
									</button>
									<span class="ng-hide">Not deleted</span>
									</td>
									<td> 
									<a title="Edit" ng-show="!renewalServiceDetails.showEdit" data-toggle="tooltip" type="button" ng-click="renewalServiceDetails.showEdit = !renewalServiceDetails.showEdit;validateRenewalService=false;" class="btn btn-xs btn-info glyphicon glyphicon-edit"></a>
                                    
                                    <a style="cursor:pointer;  color: green; " title="Save" ng-show="renewalServiceDetails.showEdit" ng-click="renewalServiceDetails.showEdit = !renewalServiceDetails.showEdit;updateRenewalService(renewalService,renewalService.id);" class="btn btn-xs btn-primary glyphicon glyphicon-ok-circle"></a>
                      
                                    <a style="cursor:pointer; ; color: red; " title="Cancel" ng-show="renewalServiceDetails.showEdit"  ng-click="renewalServiceDetails.showEdit = !renewalServiceDetails.showEdit; " class="btn btn-xs btn-warning glyphicon glyphicon-remove-circle"></a>
                                    </td>
                                    <td><span ng-bind="renewalService.currentStatus" id="currentStatusSearch_{{renewalService.id}}"></span></td>
                                    <td><select ng-model="renewalService.updateStatus" id="updateProcessStatusSearch_{{renewalService.id}}" ng-change="updateProcessStatusSearch(renewalService.id)" class="form-control">
											<option value="OPEN" selected="selected">OPEN</option>
											<option value="IN PROGRESS">IN PROGRESS</option>
											<option value="CLOSE">CLOSE</option>
										</select>
									</td>
									<td><span ng-bind="renewalService.category" id="cat_{{renewalService.id}}"></span></td>
									<td><span ng-bind="renewalService.subcategory" id="subcat_{{renewalService.id}}"></span></td>
									<td><span ng-show="!renewalServiceDetails.showEdit">{{renewalService.description}}</span>
									<input ng-show="renewalServiceDetails.showEdit" type="text" class="form-control" ng-model="renewalService.description" id="description_{{renewalService.id}}"></td>
									<td><span ng-show="!renewalServiceDetails.showEdit">{{renewalService.model}}</span>
									<input ng-show="renewalServiceDetails.showEdit" type="text" class="form-control" ng-model="renewalService.model" id="model_{{renewalService.id}}"></td>
									<td><span ng-show="!renewalServiceDetails.showEdit">{{renewalService.amount}}</span>
									<input ng-show="renewalServiceDetails.showEdit" type="text" class="form-control" ng-model="renewalService.amount" id="amount_{{renewalService.id}}"></td>
									<td><span ng-show="!renewalServiceDetails.showEdit">{{renewalService.gst}}</span>
									<input ng-show="renewalServiceDetails.showEdit" type="text" class="form-control" ng-model="renewalService.gst" id="gst_{{renewalService.id}}"></td>
									<td><span ng-show="!renewalServiceDetails.showEdit">{{renewalService.supplierName}}</span>
									<input ng-show="renewalServiceDetails.showEdit" type="text" class="form-control" ng-model="renewalService.supplierName" id="supplierName_{{renewalService.id}}"></td>
									<td><span ng-show="!renewalServiceDetails.showEdit">{{renewalService.supplierEmail}}</span>
									<input ng-show="renewalServiceDetails.showEdit" type="text" class="form-control" ng-model="renewalService.supplierEmail" id="supplierEmail_{{renewalService.id}}"></td>
									<td><span ng-show="!renewalServiceDetails.showEdit">{{renewalService.supplierContact}}</span>
									<input ng-show="renewalServiceDetails.showEdit" type="text" class="form-control" ng-model="renewalService.supplierContact" id="supplierContact_{{renewalService.id}}"></td>
									<td><span ng-show="!renewalServiceDetails.showEdit">{{renewalService.location}}</span>
									<input ng-show="renewalServiceDetails.showEdit" type="text" class="form-control" ng-model="renewalService.location" id="location_{{renewalService.id}}"></td>
									<td><span ng-show="!renewalServiceDetails.showEdit">{{renewalService.contractNo}}</span>
									<input ng-show="renewalServiceDetails.showEdit" type="text" class="form-control" ng-model="renewalService.contractNo" id="contractNo_{{renewalService.id}}"></td>
									<td><span ng-show="!renewalServiceDetails.showEdit">{{renewalService.purchaseDate.slice(0, 10)}}</span>
									    <div class="input-group" ng-show="renewalServiceDetails.showEdit">
										    <input type="text" id="purchaseDate_{{renewalService.id}}" ng-show="renewalServiceDetails.showEdit"
												class="form-control"
											    ng-model="renewalService.purchaseDate" datepicker></input><span ng-show="renewalServiceDetails.showEdit"
												class="input-group-addon" id="basic-addon1"><span ng-show="renewalServiceDetails.showEdit"
												class="glyphicon glyphicon-calendar"></span>
									</div></td>
									<td><span ng-show="!renewalServiceDetails.showEdit">{{renewalService.expiryDate.slice(0, 10)}}</span>
									    <div class="input-group" ng-show="renewalServiceDetails.showEdit">
										    <input type="text" id="expiryDate_{{renewalService.id}}" ng-show="renewalServiceDetails.showEdit"
												class="form-control"
											    ng-model="renewalService.expiryDate" ng-change="calDiff(renewalService.expiryDate,{{$index}});" datepicker></input><span ng-show="renewalServiceDetails.showEdit"
												class="input-group-addon" id="basic-addon1"><span ng-show="renewalServiceDetails.showEdit"
												class="glyphicon glyphicon-calendar"></span>
									</div></td>
									<!-- <td><span ng-bind="renewalService.comment"></span></td>
									<td><span ng-show="!renewalServiceDetails.showEdit">{{renewalService.reminderBefore}}</span>
									<select ng-show="renewalServiceDetails.showEdit" id="setReminder_{{index}}" ng-model="renewalService.reminderBefore" class="form-control" id="reminderBefore_{{renewalService.id}}">
											<option value="">Select Reminder</option>
											<option ng-repeat="reminderObj in reminderList" value="{{reminderObj.id}}">{{reminderObj.id}}</option>
									</select></td>
									<td><span ng-bind="renewalService.remainingDays"></span></td>
									<td><a ng-hide="renewalService.filepath==''" class="glyphicon glyphicon-download-alt btn btn-default"
									 style="font:16px;color: blue;" title="{{renewalService.filepath}}" 
									 href="../controller/downloadFile1.php?name={{renewalService.filepath}}&filepath=uploads/<?php echo $userObject2->imgDir;?>"> </a>
								    </td>
								    <td><button class="btn btn-primary" id="getVendor" ng-click="vendoreModal(renewalService.id)" name="getVendre">Get Vendor</button></td>
		
								</tr>
							</table>
							</div>
					</div>
				</div>
			</div>
	    </div>
    </div> -->
<div id="myModal" class="modal1">

  <!-- Modal content -->
  <div class="modal1-content">
    <div class="modal1-header">
      <span class="close">&times;</span>
      <h2>Partners</h2>
    </div>
    <div class="modal1-body">
        <div class="row" style="display:none" id="oops">
            <h3 class="text-center">Opps! No vendor found in your area!</h3>
        </div>
        <div class="row" id="success" style="display:none">
            <h3>We found {{totalVendores}} of our partners in your area of code {{pinCode}}.</h3>
            <hr/>
            <div data-ng-repeat="vendoreInfo in vendoreInfoList" class="row">
                <div class="row panel panel-default" style="padding:10px; width:60%; margin-left:180px; margin-top:10px">
                    <h3 class="panel-heading" style="font-size:16px;text-align:left;margin:-10px -10px -10px -10px;height:20px"><span style="margin-top: -30px"><b>{{vendoreInfo.company}}</b></span></h3>
                    <div class="row" style="margin-top:20px">
                        <div class="col-sm-8 text-left">
                                    <div id="mailS_{{vendoreInfo.vno}}" class="alert alert-success" style="display:none;"></div>
                                    <div id="mailF_{{vendoreInfo.vno}}" class="alert alert-warning" style="display:none;"></div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <span>Company Name :</span>
                                        </div><div class="col-sm-6">
                                            <span>{{vendoreInfo.company}}</span>
                                        </div>
                                    </div> 
                                
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <span>Contact Person :</span>
                                        </div><div class="col-sm-6">
                                            <span>{{vendoreInfo.name}}</span>
                                        </div>
                                    </div> 
                                
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <span>Contact No :</span>
                                        </div><div class="col-sm-6">
                                            <span>{{vendoreInfo.mobile}}</span>
                                        </div>
                                    </div> 
                                
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <span>Email ID :</span>
                                        </div><div class="col-sm-6">
                                            <span><a href="mailto:{{vendoreInfo.email}}">{{vendoreInfo.email}}</a></span>
                                        </div>
                                    </div> 
                               
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <span>Website Address :</span>
                                        </div><div class="col-sm-6">
                                            <span>{{vendoreInfo.website}}</span>
                                        </div>
                                    </div> 
                                
                        </div>
                        <div class="col-sm-4 text-right">
                            <button class="btn btn-success" ng-click="mailMe(vendoreInfo.vno)">Mail Me</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <hr/>
    <div class="modal1-footer">
      <div class="row" style="padding: 10px;">
          <div class="col-sm-5 text-right">
              <span id="mailVendore"></span>
          </div>
          <div class="col-sm-7 text-left">
              <button class="btn btn-primary" id="clsModal">Close</button>
          </div>
      </div>
    </div>
  </div>

</div>

<div id="extendModal" class="modal1">

  <!-- Modal content -->
  <div class="modal1-content">
    <div class="modal1-header">
      <span class="close" id="closeExtend" >&times;</span>
      <h2>Extend Period of Record</h2>
    </div>
    <div class="modal1-body">
        <div class="row" style="display:none;margin-top:40px;margin-bottom:40px" id="extendSuccess">
            <span class="alert alert-success">Your record of id {{extendPeriodFor}} is extend successfully!</span>
        </div>
        <div class="row" id="paymentBlock" style="display:block">
            <h3>Extend period of the record (id : <span id="recId">{{extendPeriodFor}}</span>) for month of: </h3>
            <div class="row" style="padding:10px; width:60%; margin-left:180px; margin-top:10px">
                <div class="row" style="margin-top:20px">
                    <div class="col-sm-1">
                            
                    </div>
                    <div class="col-sm-4">
                        <p>Number of months: </p>
                    </div>
                    <div class="col-sm-4">
                        <input type="text" class="pc-input" id="totalMonths" name="totalMonths" disabled="disabled" value="1"/>
                    </div>
                    <div class="col-sm-1">
 						<button onclick="incrementMonth();getTotal();" class="btn btn-primary" style="height:40px;width:40px;margin-bottom:5px;">+</button>
                    </div>
                    <div class="col-sm-1">
 						<button onclick="decrimentMonth();getTotal();" class="btn btn-primary" style="height:40px;width:40px;margin-bottom:5px;">-</button>
                    </div>
                    <div class="col-sm-1">
                           
                    </div>
                </div>
                <br>
                <h3>Amount per record : Rs. 10 / Record</h3>
                <br>
                <h2>Total Amount : Rs. <span id="totalAmount"> 10</span></h2>
                <br>
                <button class="btn btn-success" onClick="makePayment();">Make Payment</button>
            </div>
        </div>
    </div>
    <hr/>
    <div class="modal1-footer" style="display:none">
      <div class="row" style="padding: 10px;">
          <div class="col-sm-5 text-right">
              <span id="mailVendore"></span>
          </div>
          <div class="col-sm-7 text-left">
              <button class="btn btn-primary" id="clsExtendModal">Close</button>
          </div>
      </div>
    </div>
  </div>

</div>
    
<div id="recordByCat" class="tab-pane fade">
    <div class="panel panel-default" style="padding:1%;border-top: none;border-color: #eee;">
    <br>
    <div id="reportAlertMsg" class="ng-hide"></div>
     <div class="panel-group round-corner">
	<div class="panel panel-default">
		<div class="panel-heading" style="padding: 10px;">
		
			<h4 class="panel-title text-left">
				<a href="#"
					ng-click="getRenewalServices('all',-999,15,100);addActiveClassForReminder('15');">All<span > ({{totalServices}})</span></a>
				 <a  style="float: right" href="" class="glyphicon glyphicon-triangle-top" ng-click="colapseThisReportDiv('reportDivId_100');"></a>
			</h4>
		</div>
		<div id="reportDivId_100" class="panel-collapse collapse">
			<div class="panel-body">
				<div class="col-sm-12 col-md-12 col-lg-12 renewalMarginBottom">
				<div class="col-sm-12 text-left">
				<a  href="" ng-click="exportToExcel('#renserGridId3')"> <i class="glyphicon glyphicon-download-alt" style="color:black;font-size:15px;"></i>&nbsp;Excel</a> &nbsp;&nbsp;
					<a  href="" ng-click="printData('#renserGridId3')"> <i class="glyphicon glyphicon-print" style="color:black;font-size:15px;"></i>&nbsp;Print</a> 
					</div>
					<table  class="table table-bordered ">
						<thead>
							<tr>
								<th class="btn-duereport"
									ng-class="{'btn-duerportactive' : activeReportClass15}"
									ng-click="getRenewalServices('all',-999,15,100);"><span
									ng-model="activeReportClass15"
									ng-click="addActiveClassForReminder('15');">Due in 15 days</span></th>
								<th class="btn-duereport"
									ng-class="{'btn-duerportactive' : activeReportClass30}"
									ng-click="getRenewalServices('all',15,30,100);"><span
									ng-model="activeReportClass30"
									ng-click="addActiveClassForReminder('30');;">Due in 30 days</span></th>
								<th class="btn-duereport"
									ng-class="{'btn-duerportactive' : activeReportClass60}"
									ng-click="getRenewalServices('all',30,60,100);"><span
									ng-model="activeReportClass60"
									ng-click="addActiveClassForReminder('60');">Due in 60 days</span></th>
								<th class="btn-duereport"
									ng-class="{'btn-duerportactive' : activeReportClass90}"
									ng-click="getRenewalServices('all',60,100000,100);"><span
									ng-model="activeReportClass90"
									ng-click="addActiveClassForReminder('90');"> > 60 days</span></th>

							</tr>
						</thead>
					</table>
					<div class="table-responsive">
					<table id="renserGridId3" class="table table-bordered " style="width: 250%; max-width: 250%;" >
						<thead>
							<tr class="header">
							<th>Status</th>
								<th>Delete</th>
								<th>Category</th>
								<th>Sub category</th>
								<th>Description</th>
								<th>Model</th>
								<th>Amount</th>
								<th>GST</th>
								<th>Supplier Name</th>
								<th>Supplier Email</th>
								<th>Supplier Contact</th>
								<th>Location</th>
								<th>Contract Number</th>
								<th>Purchase Date</th>
								<th>Expiry Date</th>
								 <!-- <th>Comment</th>-->
								<th>Set Reminder</th>
								<th>Remaining Days</th>
								<th>File</th>
								<th>Submited On</th>
							</tr>
						</thead>
						<tr data-ng-repeat="renewalService in renewalServicesList">
						<td class="text-center"><span class="glyphicon glyphicon-record" title="{{renewalService.remainingDays < 1 ? 'Deactive' : 'Active'}}" ng-class="renewalService.remainingDays < 1 ? 'serviceDeactive' : 'serviceActive'"></span></td>
							<td class="text-center"><a class="label label-danger" href="" ng-click="deleteReport(renewalService,renewalService.id,renewalService.category,renewalService.subcategory)"><span class="glyphicon glyphicon-remove"></span> Delete
									</a>
									<span class="ng-hide">Not deleted</span>
									</td>
									
							<td><span ng-bind="renewalService.category"></span></td>
							<td><span ng-bind="renewalService.subcategory"></span></td>
							<td><span ng-bind="renewalService.description"></span></td>
							<td><span ng-bind="renewalService.model"></span></td>
							<td class="text-center"><span ng-bind="renewalService.amount"></span></td>
							<td class="text-center"><span ng-bind="renewalService.gst"></span></td>
							<td><span ng-bind="renewalService.supplierName"></span></td>
							<td><span ng-bind="renewalService.supplierEmail"></span></td>
							<td class="text-center"><span ng-bind="renewalService.supplierContact"></span></td>
							<td><span ng-bind="renewalService.location"></span></td>
							<td class="text-center"><span ng-bind="renewalService.contractNo"></span></td>
							<td class="text-center"><span ng-bind="renewalService.purchaseDate.slice(0, 10)"></span></td>
							<td class="text-center"><span ng-bind="renewalService.expiryDate.slice(0, 10)"></span></td>
							<!-- <td><span ng-bind="renewalService.comment"></span></td> -->
							<td class="text-center"><span ng-bind="renewalService.reminderBefore"></span></td>
							<td class="text-center"><span ng-bind="renewalService.remainingDays"></span></td>
							<td><a ng-hide="renewalService.filepath==''" class="glyphicon glyphicon-download-alt btn btn-default"
									 style="font:16px;color: white;" title="{{renewalService.filepath}}" 
									 href="../controller/downloadFile1.php?name={{renewalService.filepath}}&filepath=uploads/<?php echo $userObject2->imgDir;?>"> </a>
														
									
							</td>
							
							<td><span ng-bind="renewalService.submitedOn"></span></td>

						</tr>

					</table>
					</div>
				</div>

			</div>
		</div>
	</div>
</div>


<div class="content"
	data-ng-repeat="categoryCountObj in renewalServicesCountList">
	<div class="panel-group round-corner">
		<div class="panel panel-default">
			<div class="panel-heading" style="padding: 10px;">
				<h4 class="panel-title text-left">
					<a href="#"
						ng-click="getRenewalServices(categoryCountObj.category,-999,15,$index);addActiveClassForReminder('15');">{{categoryCountObj.category}}<span > ({{categoryCountObj.count}})</span></a>
					 <a  style="float: right" href="" class="glyphicon glyphicon-triangle-top" ng-click="colapseThisReportDiv('reportDivId_'+$index);"></a>
				</h4>
			</div>
			<div id="reportDivId_{{$index}}" class="panel-collapse collapse">
				<div class="panel-body">
					<div class="col-sm-12 col-md-12 col-lg-12 renewalMarginBottom">
					<div class="col-sm-12 text-left">
					<a  href="" ng-click="exportToExcel('#renserGridId4')"><i class="glyphicon glyphicon-download-alt" style="color:black;font-size:15px;"></i> &nbsp;Excel</a> &nbsp;&nbsp;
					<a  href="" ng-click="printData('#renserGridId4')"> <i class="glyphicon glyphicon-print" style="color:black;font-size:15px;"></i>&nbsp; Print</a> 
						</div>
						
						<table class="table table-bordered ">
							<thead>
								<tr>
									<th class="btn-duereport"
										ng-class="{'btn-duerportactive' : activeReportClass15}"
										ng-click="getRenewalServices(categoryCountObj.category,-999,15,$index);"><span
										ng-model="activeReportClass15"
										ng-click="addActiveClassForReminder('15');">Due in 15 days</span></th>
									<th class="btn-duereport"
										ng-class="{'btn-duerportactive' : activeReportClass30}"
										ng-click="getRenewalServices(categoryCountObj.category,15,30,$index);"><span
										ng-model="activeReportClass30"
										ng-click="addActiveClassForReminder('30');;">Due in 30 days</span></th>
									<th class="btn-duereport"
										ng-class="{'btn-duerportactive' : activeReportClass60}"
										ng-click="getRenewalServices(categoryCountObj.category,30,60,$index);"><span
										ng-model="activeReportClass60"
										ng-click="addActiveClassForReminder('60');">Due in 60 days</span></th>
									<th class="btn-duereport"
											ng-class="{'btn-duerportactive' : activeReportClass90}"
											ng-click="getRenewalServices(categoryCountObj.category,60,100000,$index);"><span
											ng-model="activeReportClass90"
											ng-click="addActiveClassForReminder('90');"> > 60 days</span></th>

								</tr>
							</thead>
						</table>
						<div class="table-responsive">
						<table id="renserGridId4" class="table table-bordered" style="width: 250%; max-width: 250%;">
							<thead>
								<tr class="header">
								    <th>Status</th>
								    <th>Delete</th>
									<th>Category</th>
									<th>Sub category</th>
									<th>Description</th>
									<th>Model</th>
									<th>Amount</th>
									<th>GST</th>
									<th>Supplier Name</th>
									<th>Supplier Email</th>
									<th>Supplier Contact</th>
									<th>Location</th>
									<th>Purchase Date</th>
									<th>Expiry Date</th>
									<th>Contact Number</th>
									<!-- <th>Comment</th> -->
									<th>Set Reminder</th>
									<th>Remaining Days</th>
									<th>File</th>
									<th>Submited On</th>
								</tr>
							</thead>
							<tr data-ng-repeat="renewalService in renewalServicesList">
							   <td class="text-center"><span class="glyphicon glyphicon-record" title="{{renewalService.remainingDays < 1 ? 'Deactive' : 'Active'}}" ng-class="renewalService.remainingDays < 1 ? 'serviceDeactive' : 'serviceActive'"></span></td>
								<td class="text-center"><a class="label label-danger" href="" ng-click="deleteReport(renewalService,renewalService.id,renewalService.category,renewalService.subcategory)"><span class="glyphicon glyphicon-remove"></span> Delete
									</a>
									<span class="ng-hide">Not deleted</span>
									</td>
								<td><span ng-bind="renewalService.category"></span></td>
								<td><span ng-bind="renewalService.subcategory"></span></td>
								<td><span ng-bind="renewalService.description"></span></td>
								<td><span ng-bind="renewalService.model"></span></td>
								<td class="text-center"><span ng-bind="renewalService.amount"></span></td>
								<td class="text-center"><span ng-bind="renewalService.gst"></span></td>
								<td><span ng-bind="renewalService.supplierName"></span></td>
								<td><span ng-bind="renewalService.supplierEmail"></span></td>
								<td class="text-center"><span ng-bind="renewalService.supplierContact"></span></td>
								<td><span ng-bind="renewalService.location"></span></td>
								<td class="text-center"><span ng-bind="renewalService.purchaseDate"></span></td>
								<td class="text-center"><span ng-bind="renewalService.expiryDate.slice(0, 10)"></span></td>
								<td class="text-center"><span ng-bind="renewalService.contractNo"></span></td>
								<!-- <td><span ng-bind="renewalService.comment"></span></td> -->
								<td class="text-center"><span ng-bind="renewalService.reminderBefore"></span></td>
								<td class="text-center"><span ng-bind="renewalService.remainingDays"></span></td>
								<td><a ng-hide="renewalService.filepath==''" class="glyphicon glyphicon-download-alt btn btn-default"
									 style="font:16px;color: white;" title="{{renewalService.filepath}}" 
									 href="../controller/downloadFile1.php?name={{renewalService.filepath}}&filepath=uploads/<?php echo $userObject2->imgDir;?>"> </a>
								</td>
								<td><span ng-bind="renewalService.submitedOn"></span></td>
							</tr>

						</table>
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






