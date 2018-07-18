<div class="container">
	<div class="row">
    	<div class="col-sm-10  toppad" style="margin-left: -15px" >
        	<div class="panel panel-default" style="margin-left: 140px"> 
            	<div class="panel-heading">
              		<h5 class="panel-title text-left" style="font-size:18px;">
						<b>Add User</b>	
					</h5>
            	</div>
            	<div class="panel-body">
            		<div class="row text-left" style="margin-left: 20px;">
            			<div class="col-sm-6 text-left">
            				<h3>Add new user here...</h3>
            			</div>
            			<div class="col-sm-6 text-right">
            				<a href="#" title="Go Back" type="button" id="vMenuUsersId" ng-click="addActiveClass('vMenuUsersId');changeScreen('users');getRenewalUsers();resetAddNewUser();"> &lt;&lt; Go Back</a>
            			</div>
            		</div>
            		<hr/>
            		<div  id="addUserAlert" class="alert col-sm-12">
					</div>
              		<div class="row" style="margin-left: 20px;">
              			<div class="col-sm-6 text-center">
              				<input type="text" id="firstname1" style="width:100%;" name="firstname1" placeholder="Enter first name"/><br><br>
              				<input type="text" id="lastname1" style="width:100%;" name="lastname1" placeholder="Enter last name"/><br><br>
              				<input type="text" id="designation1" style="width:100%;" name="designation1" placeholder="Enter designation"/><br><br>
              				<input type="text" id="username1" style="width:100%;" name="username1" placeholder="Enter username"/><br><br>
              				<input type="text" id="emailid1" style="width:100%;" name="emailid1" placeholder="Enter email address"/><br><br>
              				<input type="password" id="password1" style="width:100%;" name="password1" placeholder="Enter password"/><br><br>
              				<input type="text" id="seniorEmail1" style="width:100%;" name="seniorEmail1" placeholder="Enter senior emailId (Level 1)"/><br><br>
              				<input type="text" id="seniorEmail2" style="width:100%;" name="seniorEmail2" placeholder="Enter senior emailId (Level 2)"/><br><br>
              			</div>
              			<div class="col-sm-6 text-left">
              				<input type="checkbox" id="isAdmin" name="isAdmin" ng-click="isAdminClicked()"> Admin</input><br><br>
              				<input type="checkbox" id="viewPermission" name="viewPermission" checked="true" disabled> View Permission</input><br><br>
              				<input type="checkbox" id="insertPermission" name="insertPermission" ng-click="insertPermissionClicked()"> Insert Permission</input><br><br>
              				<input type="checkbox" id="updatePermission" name="updatePermission" ng-click="updatePermissionClicked()"> Update Permission</input><br><br>
              				<input type="checkbox" id="deletePermission" name="deletePermission" ng-click="deletePermissionClicked()"> Delete Permission</input><br><br>
              				<input type="checkbox" id="mailPermission" name="mailPermission" ng-click="mailPermissionClicked()"> Mail Permission</input><br><br>
              			</div>
              		</div>
              		<hr/>
              		<div class="row">
              			<div class="col-sm-6 text-right">
              				<a href="#" title="Go Back" type="button" id="vMenuUsersId" ng-click="addActiveClass('vMenuUsersId');changeScreen('users');getRenewalUsers();resetAddNewUser();" class="btn btn-info btn-primary">Cancel</a>
              			</div>
              			<div class="xol-sm-6 text-left">
              				<a href="#" title="Add User" type="button" id="addUserBtn" ng-click="validateDataAddNewUser();" class="btn btn-info btn-primary">Submit</a>
              			</div>
              		</div>
            	</div>
          	</div>
        </div>
   	</div>
</div>