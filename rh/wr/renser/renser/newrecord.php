<script>
function isNumberKey(evt){
	var charCode = (evt.which) ? evt.which : event.keyCode;
	if (charCode > 31 && (charCode < 48 || charCode > 57))
    	return false;
	return true;
}
</script>
<div class="tab-pane active" id="general" >
					<div class="panel panel-default">
						<div class="panel-heading">
							<h5 class="panel-title text-left" style="font-size:18px;">
								<b>Add New Records Here..</b>	
					            <span id="checkAllot"></span>
							</h5>
						</div>
						<div class="panel-body" >
								<div class="row">
										<form role="form" method="post" enctype="multipart/form-data">
											<div class="form-horizontal">
												<div class="col-sm-12 col-md-12 col-lg-12 renewalMarginBottom">
												<div id="addRenewalServiceAlert" class="ng-hide"></div>
												    <div class="row" style="display:none;">
														<div class="col-sm-3 col-md-6 col-lg-4">
														  <select ng-model="selectedCategory" class="col-sm-2 form-control"
																ng-change="setSelectedSubCat(selectedCategory , {{$index}});setCustomeCat();setSelectedCategoryToColumn();" id="cat">
																<option value="">Select Category</option>
																<option ng-repeat="option in catgory | orderBy:'name'"
																	value="{{option.id}}">{{option.name}}</option>
															    </select>
														</div>
														<div class="col-sm-3 col-md-6 col-lg-4">
														 <select ng-model="selectedSubCategory" class="col-sm-2 form-control" ng-change="setCustomeSubCat();setSelectedSubCategoryToColumn();" id="subcat">
															<option value="">Select Sub category</option>
															<option ng-repeat="subOption in subCategoryJsonArray"
																	value="{{subOption.id}}">{{subOption.name}}</option>
														</select> 
														</div>
														<div class="col-sm-3 col-md-6 col-lg-4" style="float:right;">
														<a href="buyPlan.php"><span style="font-size:25px;color:green;float:right;cursor: pointer;" id="addRenewalServiceRow" title="Add Records"
																	class="glyphicon glyphicon-plus-sign text-right"></span></a> 
														</div>
													</div>
													<div class="row" style="margin-top:10px;display:none;">
														<div class="col-sm-3 col-md-6 col-lg-4">
														    <input ng-model="selectedCustomeCategory1" ng-change=" setSelectedCategoryToColumn();" class="col-sm-2 form-control" id="customeCategory1" name="customeCategory1" placeholder="Enter custome category"></input>
														</div>
														    <div class="col-sm-3 col-md-6 col-lg-4">
														        <input ng-model="selectedCustomeSubCategory1" ng-change="setSelectedSubCategoryToColumn();" class="col-sm-2 form-control" id="customeSubCategory1" name="customeSubCategory1" placeholder="Enter custome sub-category"></input>
														    </div>
														<div class="col-sm-3 col-md-6 col-lg-4" style="float:right;">
								
														</div>
														</div>
													</div>
													<br>
												<div class="col-sm-12 col-md-12 col-lg-12 table-responsive renewalMarginBottom">
													<table id="renserGridId" class="table table-bordered " style="width:250%;max-width: 250%">
														<thead>
															<tr class="header">
																<th>Category<span style="color:red; font-size:18px;">*</span></th>
																<th>Sub-Category<span style="color:red; font-size:18px;">*</span></th>
																<th>Entity</th>
																<th>Description<span style="color:red; font-size:18px;">*</span></th>
																<th>Model</th>
																<th>Amount</th>
																<th>GST</th>
																<th>Supplier Name</th>
																<th>Supplier Email</th>
																<th>Supplier Contact</th>
																<th>Email supplier</th>
																<th>Location</th>
																<th>Contract Number</th>
																<th>Purchase Date<span style="color:red; font-size:18px;">*</span></th>
																<th>Expiry Date<span style="color:red; font-size:18px;">*</span></th>
																<!--<th>Comment</th>-->
																<th>Set Reminder<span style="color:red; font-size:18px;">*</span></th>
																<th>Escalation Mail</th>
																<th>Set Escalation</th>
																<th>Start Escalation</th>
																<th>Upload Doc</th>
															</tr>
														</thead>
														<tbody>
															<tr  data-ng-repeat="renewalService in renewalServices" >
																
																<td><select ng-model="renewalService.categoryId" class="form-control"
																        ng-change="setSelectedSubCat(renewalService.categoryId , {{$index}});" id="cat_{{$index}}">
																            <option value="">Select Category</option>
																            <option ng-repeat="option in catgory | orderBy:'name'"
																	                value="{{option.id}},{{option.name}}">{{option.name}}</option>
															        </select></td>
															   <!--  <td><select ng-model="renewalService.subCategoryId" class="form-control" id="subcat_{{$index}}">
															            <option value="">Select Sub category</option>
															            <option ng-repeat="subOption in subCategoryJsonArray_0 | orderBy:'name'"
																	            value="{{subOption.name}}">{{subOption.name}}</option>
														            </select> 
															     </td> -->
															     <td><select ng-model="renewalService.subCategoryId" class="form-control" id="subcat_{{$index}}">
															            <option value="">Select Sub category</option>
														            </select> 
															     </td>
															     <td><input type="text" placeholder="100 charactors only" class="form-control"
																	ng-model="renewalService.entity" id="entity_{{$index}}">
																</td>
																<td><input type="text" placeholder="250 charactors only" class="form-control"
																	ng-model="renewalService.description" id="description_{{$index}}">
																<!--	<input type="hidden" ng-bind="renewalService.categoryId">
																<input type="hidden" ng-bind="renewalService.subCategoryId"> -->
																	</td>
																<td><input type="text" placeholder="20 charactors only" class="form-control"
																	ng-model="renewalService.model" id="model_{{$index}}"></td>
																<td><input type="text" class="form-control"
																	ng-model="renewalService.amount" onkeypress="return isNumberKey(event)"></td>
																<td><input type="text" class="form-control"
																	ng-model="renewalService.gst" id="gst_{{$index}}"></td>
																<td><input type="text" placeholder="100 charactors only" class="form-control"
																	ng-model="renewalService.supplierName" id="supplierName_{{$index}}"></td>
																<td><input type="text" class="form-control"
																	ng-model="renewalService.supplierEmail"></td>
																<td><input type="text" class="form-control"
																	ng-model="renewalService.supplierContact" onkeypress="return isNumberKey(event)" id="supplierContact_{{$index}}"></td>
																<td><input type="checkbox" ng-click="enterEmail();" title="Please enter supplier email to use this function." class="form-control" 
																	ng-disabled="!renewalService.supplierEmail" ng-model="renewalService.sendMailToSupplier"></td>
																<td><input type="text" placeholder="20 charactors only" class="form-control"
																	ng-model="renewalService.location" id="location_{{$index}}"></td>
																<td><input type="text" placeholder="12 charactors only" class="form-control"
																	ng-model="renewalService.contactNumber" id="contactNumber_{{$index}}"></td>
																<td><div class="input-group">
																		<input type="text" id="purchaseDate"
																			class="form-control"
																			ng-model="renewalService.purchaseDate" datepicker></input><span
																			class="input-group-addon" id="basic-addon1"><span
																			class="glyphicon glyphicon-calendar"></span>
																	
																	</div></td>
																<td><div class="input-group">
																		<input type="text" id="expiryDate"
																			class="form-control"
																			ng-model="renewalService.expiryDate" ng-change="calDiff(renewalService.expiryDate, {{$index}});" datepicker></input><span
																			class="input-group-addon" id="basic-addon1"><span
																			class="glyphicon glyphicon-calendar"></span>
																	
																	</div></td>
																<!--  <td><input type="text" class="form-control"
																	ng-model="renewalService.comment"></td>-->
																<td> <!-- <select ng-model="renewalService.reminder" ng-change="" class="form-control">
																		<option value=""></option>
																		<option ng-selected="selected" value="15">15</option>
																		<option value="30">30</option>
																		<option value="60">60</option>
																	</select>  -->
																	<select ng-model="renewalService.reminder" class="form-control" id="setReminder_{{$index}}">
																		<option value="">Select Reminder</option>
																		<!--<option  ng-repeat="reminderObj in reminderList_{{$index}}" value="{{reminderObj.id}}">{{reminderObj.id}}</option>-->
																	</select>
																	
																	</td>
																<!-- <td>
																	<input class="form-control " ng-model="renewalService.fileName"
																	 type="file" file-model="renewalService.fileName" name="myFile" multiple  ng-file-select="onFileSelect(files);" >
																	
																	</td> -->	
																	<td>
																		<input type="text" class="form-control" ng-model="renewalService.escalationEmail" id="escalationMail_{{$index}}">
																	</td>
																	<td>
																		<input type="checkbox" title="Enter Escalation Email!" class="form-control" 
																			ng-disabled="!renewalService.escalationEmail" ng-model="renewalService.setEscalation" id="setEscalation_{{$index}}">
																	</td>
																	<td>
																		<input type="text" class="form-control" ng-model="renewalService.startEscalation" onkeypress="return isNumberKey(event)" id="startEscalation_{{$index}}">
																	</td>
																	 <td>
																		<input type="file" ng-file-model="files" ng-click="setCurrentIndex($index)"  onchange="angular.element(this).scope().setFile(this)" multiple   />
																	</td>
																
															</tr>
														</tbody>
													</table>
													</div>
														<div class="col-sm-12 col-md-12 col-lg-12 ">
															<div class="col-sm-12 col-md-12 col-lg-12 ">
															    <label for="massUpdateFile text-left" >Upload CSV file</label>
															    <div class="row">
															   		<div class="col-sm-3">
															    		<input type="file" file-reader="fileContent" style="margin-top: 10px;"/>
															    	</div>
															    	<div class="col-sm-1">
															    		<a class="btn btn-info " ng-click="readCSV(fileContent)">Upload</a>
															    	</div>
															    	<div class="col-sm-8 text-right">
															    		<button class="btn" ng-click="addRenewalService();getProfileInfo();getDashboardInfo();" id="addRecordBtn" ng-disabled="insertPermission == 'NO'">Submit</button>
															    	</div>
															    </div>
															    <div class="row" style="margin-top: 15px; margin-left:4px;">
																	<a class="glyphicon glyphicon-download-alt btn btn-default" style="font:16px;color: white;" title="Download CSV" href="../sample/bulk_upload_sample.csv"> </a> &nbsp;Download Sample CSV
																</div>
															</div>
														<!--<div class="col-sm-3 col-md-3 col-lg-3 text-right">
															<!--    <a href="../sample/bulk_upload_sample.csv">Download sample</a> -->
															</div>
															<div class="col-sm-3 col-md-3 col-lg-3 text-right">
																<!--  <button class="btn" ng-click="addRenewalService();getProfileInfo();" id="addRecordBtn" ng-disabled="insertPermission == 'NO'">Submit</button>
															</div> -->
														</div>
														
														<!-- <div class="col-sm-12 col-md-12 col-lg-12 text-left">
															<a class="glyphicon glyphicon-download-alt btn btn-default" style="font:16px;color: blue;" title="Download CSV" href="../controller/downloadFile.php?name=sample.csv&filepath=sample"> </a> &nbsp;Download Sample CSV
														</div> -->
											
											</div>
										</form>
							</div>
						</div>
						
					</div>
					<!-- panel -->
				</div> 