<div class="container" ng-init="getRenewalEmailAccounts();">
	<div class="row">
    	<div class="col-sm-10  toppad" style="margin-left: -15px" >
        	<div class="panel panel-default" style="width:1115px;">
            	<div class="panel-heading">
              		<h5 class="panel-title text-left" style="font-size:18px;">
						<b>Email Accounts</b>	
					</h5>
            	</div>
            	<div class="panel-body">
				
					<div class="row text-left" style="padding: 10px">
					<p>Here you can add Email IDs without RenewalHelp account and they can receive reminder mails.</p>
					</div>
              		<div class="row text-right" style="padding: 20px">
              			<a title="Add New Email Account" type="button" id="vMenuAddEmailAccountId" ng-click="addActiveClass('vMenuAddEmailAccountId');changeScreen('addemailaccount');hideAlert('addEmailAccountAlert'); resetRenewalEmailAccount();resetNewEmailAccount();" class="btn btn-info btn-primary">Add Email Account</a>
              			<hr>
              		</div>
              		<div id="emailAccountAlertMsg" class="ng-hide"></div>
              		<div class="row">
              			<div class="table-responsive">
							<table id="renserGridId2" class="table table-bordered"  style="width: 100%; max-width: 250%;">
								<thead>
									<tr class="header">
										<th>Remove</th>
										<th>Edit</th>
										<th>ID</th>
									    <th>First Name</th>
										<th>Last Name</th>
										<th>Designation</th>
										<th>Email ID</th>
									</tr>
								</thead>
								<tr data-ng-repeat="renewalEmailAccount in renewalEmailAccountsList" id="emailAccountTableRow_{{renewalEmailAccount.id}}" class="text-left">
									<td >
										<a class="label label-danger" href="" ng-click="deleteEmailAccount(renewalEmailAccount,renewalEmailAccount.id);"><span class="glyphicon glyphicon-remove"></span> Delete</a>
										<span class="ng-hide">Not deleted</span>
									</td>
									<td> 
										<a title="Edit" ng-show="!renewalUserDetails.showEdit" data-toggle="tooltip" type="button" ng-click="renewalUserDetails.showEdit = !renewalUserDetails.showEdit;validateRenewalUser=false;" class="btn btn-xs btn-info glyphicon glyphicon-edit"></a>
	                                    <a style="cursor:pointer;  color: green; " title="Save" ng-show="renewalUserDetails.showEdit" ng-click="renewalUserDetails.showEdit = !renewalUserDetails.showEdit;updateRenewalEmailAccount(renewalEmailAccount,renewalEmailAccount.id);" class="btn btn-xs btn-primary glyphicon glyphicon-ok-circle"></a>                  
         	    	                    <a style="cursor:pointer; ; color: red; " title="Cancel" ng-show="renewalUserDetails.showEdit"  ng-click="renewalUserDetails.showEdit = !renewalUserDetails.showEdit; " class="btn btn-xs btn-warning glyphicon glyphicon-remove-circle"></a>
                                    </td>
									<td>
										<span ng-bind="renewalEmailAccount.id" id="userNo_{{renewalEmailAccount.id}}"></span>
									</td>
									<td>
										<span ng-show="!renewalUserDetails.showEdit" ng-bind="renewalEmailAccount.firstName"></span>
										<input ng-show="renewalUserDetails.showEdit" type="text" class="form-control" ng-model="renewalEmailAccount.firstName" id="firstName_{{renewalEmailAccount.id}}">
									</td>
									<td>
										<span ng-show="!renewalUserDetails.showEdit" ng-bind="renewalEmailAccount.lastName"></span>
										<input ng-show="renewalUserDetails.showEdit" type="text" class="form-control" ng-model="renewalEmailAccount.lastName" id="lastName_{{renewalEmailAccount.id}}">
									</td>
									<td>
										<span ng-show="!renewalUserDetails.showEdit" ng-bind="renewalEmailAccount.designation"></span>
										<input ng-show="renewalUserDetails.showEdit" type="text" class="form-control" ng-model="renewalEmailAccount.designation" id="designation_{{renewalEmailAccount.id}}">
									</td>
									<td>
										<span ng-show="!renewalUserDetails.showEdit" ng-bind="renewalEmailAccount.emailId"></span>
										<input ng-show="renewalUserDetails.showEdit" type="text" class="form-control" ng-model="renewalEmailAccount.emailId" id="emailId_{{renewalEmailAccount.id}}">
									</td>
								</tr>
							</table>
						</div>
              		</div>
            	</div>
          	</div>
        </div>
   	</div>
</div>