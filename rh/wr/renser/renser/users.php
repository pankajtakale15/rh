<div class="container" ng-init="getRenewalUsers();" style="margin-left:5px;">
	<div class="row">
    	<div class="col-sm-10  toppad" style="margin-left: -15px;" >
        	<div class="panel panel-default" style="width:1110px;">
            	<div class="panel-heading">
              		<h5 class="panel-title text-left" style="font-size:18px;">
						<b>Users</b>	
					</h5>
            	</div>
            	<div class="panel-body">
              		<div class="row text-right" style="padding: 20px">
              			<a title="Add New User" type="button" id="vMenuAddUserId" ng-click="addActiveClass('vMenuAddUserId');changeScreen('addUser');hideAlert('addUserAlert');resetRenewalUser();resetAddNewUser();" class="btn btn-info btn-primary">Add User</a>
              			<hr>
              		</div>
              		<div id="userAlertMsg" class="ng-hide"></div>
              		<div class="row">
              			<div class="table-responsive">
							<table id="renserGridId2" class="table table-bordered"  style="width: 250%; max-width: 250%;">
								<thead>
									<tr class="header">
										<th>Remove</th>
										<th>Edit</th>
										<th>User No</th>
										<th>User Name</th>
									    <th>First Name</th>
										<th>Last Name</th>
										<th>Designation</th>
										<th>Email ID</th>
										<th>Senior Email (Level 1)</th>
										<th>Senior Email (Level 2)</th>
										<th>Registered On</th>
										<th>Is Admin</th>
										<th>View Permission</th>
										<th>Insert Permission</th>
										<th>Update Permission</th>
										<th>Delete Permission</th>
										<th>Mail Permission</th>
									</tr>
								</thead>
								<tr data-ng-repeat="renewalUser in renewalUsersList" id="usersTableRow_{{renewalUser.userNo}}" class="text-left">
									<td >
										<a class="label label-danger" href="" ng-click="deleteUser(renewalUser,renewalUser.userNo);"><span class="glyphicon glyphicon-remove"></span> Delete</a>
										<span class="ng-hide">Not deleted</span>
									</td>
									<td> 
										<a title="Edit" ng-show="!renewalUserDetails.showEdit" data-toggle="tooltip" type="button" ng-click="renewalUserDetails.showEdit = !renewalUserDetails.showEdit;validateRenewalUser=false;" class="btn btn-xs btn-info glyphicon glyphicon-edit"></a>
	                                    <a style="cursor:pointer;  color: green; " title="Save" ng-show="renewalUserDetails.showEdit" ng-click="renewalUserDetails.showEdit = !renewalUserDetails.showEdit;updateRenewalUser(renewalUser,renewalUser.userNo);" class="btn btn-xs btn-primary glyphicon glyphicon-ok-circle"></a>                  
         	    	                    <a style="cursor:pointer; ; color: red; " title="Cancel" ng-show="renewalUserDetails.showEdit"  ng-click="renewalUserDetails.showEdit = !renewalUserDetails.showEdit; " class="btn btn-xs btn-warning glyphicon glyphicon-remove-circle"></a>
                                    </td>
									<td>
										<span ng-bind="renewalUser.userNo" id="userNo_{{renewalUser.userNo}}"></span>
									</td>
									<td>
										<span ng-show="!renewalUserDetails.showEdit" ng-bind="renewalUser.userName"></span>
										<input ng-show="renewalUserDetails.showEdit" type="text" class="form-control" ng-model="renewalUser.userName" id="userName_{{renewalUser.userNo}}">
									</td>
									<td>
										<span ng-show="!renewalUserDetails.showEdit" ng-bind="renewalUser.firstName"></span>
										<input ng-show="renewalUserDetails.showEdit" type="text" class="form-control" ng-model="renewalUser.firstName" id="firstName_{{renewalUser.userNo}}">
									</td>
									<td>
										<span ng-show="!renewalUserDetails.showEdit" ng-bind="renewalUser.lastName"></span>
										<input ng-show="renewalUserDetails.showEdit" type="text" class="form-control" ng-model="renewalUser.lastName" id="lastName_{{renewalUser.userNo}}">
									</td>
									<td>
										<span ng-show="!renewalUserDetails.showEdit" ng-bind="renewalUser.designation"></span>
										<input ng-show="renewalUserDetails.showEdit" type="text" class="form-control" ng-model="renewalUser.designation" id="designation_{{renewalUser.userNo}}">
									</td>
									<td>
										<span ng-show="!renewalUserDetails.showEdit" ng-bind="renewalUser.loginId"></span>
										<input ng-show="renewalUserDetails.showEdit" type="text" class="form-control" ng-model="renewalUser.loginId" id="emailId_{{renewalUser.userNo}}">
									</td>
									<td>
										<span ng-show="!renewalUserDetails.showEdit" ng-bind="renewalUser.seniorEmail1"></span>
										<input ng-show="renewalUserDetails.showEdit" type="text" class="form-control" ng-model="renewalUser.seniorEmail1" id="seniorEmail1_{{renewalUser.userNo}}">
									</td>
									<td>
										<span ng-show="!renewalUserDetails.showEdit" ng-bind="renewalUser.seniorEmail2"></span>
										<input ng-show="renewalUserDetails.showEdit" type="text" class="form-control" ng-model="renewalUser.seniorEmail2" id="seniorEmail2_{{renewalUser.userNo}}">
									</td>
									<td>
										<span ng-bind="renewalUser.updatedOn"></span>
									</td>
									<td>
										<span ng-show="!renewalUserDetails.showEdit" ng-bind="renewalUser.isAdmin"></span>
										<input ng-show="renewalUserDetails.showEdit" type="text" class="form-control" ng-model="renewalUser.isAdmin" id="isAdmin_{{renewalUser.userNo}}">
									</td>
									<td>
										<span ng-bind="renewalUser.viewPermission" id="viewPermission_{{renewalService.userNo}}"></span>
									</td>
									<td>
										<span ng-show="!renewalUserDetails.showEdit" ng-bind="renewalUser.insertPermission"></span>
										<input ng-show="renewalUserDetails.showEdit" type="text" class="form-control" ng-model="renewalUser.insertPermission" id="insertPermission_{{renewalUser.userNo}}">
									</td>
									<td>
										<span ng-show="!renewalUserDetails.showEdit" ng-bind="renewalUser.updatePermission"></span>
										<input ng-show="renewalUserDetails.showEdit" type="text" class="form-control" ng-model="renewalUser.updatePermission" id="updatePermission_{{renewalUser.userNo}}">
									</td>
									<td>
										<span ng-show="!renewalUserDetails.showEdit" ng-bind="renewalUser.deletePermission"></span>
										<input ng-show="renewalUserDetails.showEdit" type="text" class="form-control" ng-model="renewalUser.deletePermission" id="deletePermission_{{renewalUser.userNo}}">
									</td>
									<td>
										<span ng-show="!renewalUserDetails.showEdit" ng-bind="renewalUser.mailPermission"></span>
										<input ng-show="renewalUserDetails.showEdit" type="text" class="form-control" ng-model="renewalUser.mailPermission" id="mailPermission_{{renewalUser.userNo}}">
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