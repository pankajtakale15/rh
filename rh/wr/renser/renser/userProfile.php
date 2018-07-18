<div class="container" ng-init="">
	<div class="row">
     	<div class="col-sm-10  toppad" style="margin-left: 65px;" >
			 <div class="panel panel-default">
            	<div class="panel-heading">
              		<h5 class="panel-title text-left" style="font-size:18px;">
						<b>User Profile</b>	
					</h5>
            	</div>
            	<div class="panel-body">
            		<div  id="profileMsg" class="alert ng-hide"></div>
             		<div class="row">
                		<!--<div class="col-md-4 col-lg-4 " align="center"> <img alt="User Pic" src="" data-toggle="modal" 
                 			class="img-rounded img-responsive"   height="200px" width="400px"> 
              			  </div>-->
               	 		<div class="col-sm-6 col-md-6 col-lg-6"> 
							<h3>Profile</h3>
                  			<table class="table table-user-information text-left" style="color:black;">
                    			<tbody style="margin-left: 40px">
                      				<tr>
                          				<td>User ID : </td>
                          				<td><span>{{userProfileDetail.userNo}}</span></td>
                      				</tr>
                      				<tr>
                        				<td>First Name:</td>
                        				<td><span ng-show="!userProfileDetail.showEdit">{{userProfileDetail.firstName}}</span>
                        					<input ng-show="userProfileDetail.showEdit" type="text" class="form-control" ng-model="userProfileDetail.firstName" >
                        				</td>
                      				</tr>
                      				<tr>
                        				<td>Last Name:</td>
                        				<td><span ng-show="!userProfileDetail.showEdit">{{userProfileDetail.lastName}}</span>
                        					<input ng-show="userProfileDetail.showEdit" type="text" class="form-control" ng-model="userProfileDetail.lastName" >
                        				</td>
                      				</tr>
                      				<tr>
                        				<td>Username:</td>
                        				<td><span ng-show="!userProfileDetail.showEdit">{{userProfileDetail.userName}}</span>
                        					<input ng-show="userProfileDetail.showEdit" type="text" class="form-control" ng-model="userProfileDetail.userName" >
                        				</td>
                      				</tr>
                      				<tr>
                        				<td>Designation:</td>
                        				<td><span ng-show="!userProfileDetail.showEdit">{{userProfileDetail.designation}}</span>
                        					<input ng-show="userProfileDetail.showEdit" type="text" class="form-control" ng-model="userProfileDetail.designation" >
                        				</td>
                      				</tr>
                      				<tr>
                        				<td>Email:</td>
                        				<td><span ng-show="!userProfileDetail.showEdit">{{userProfileDetail.email}}</span>
                        					<input ng-show="userProfileDetail.showEdit" type="text" class="form-control" ng-model="userProfileDetail.email" >
                        				</td>
                      				</tr>
                      				<tr>
                        				<td>Password:</td>
                       					<td><span ng-show="!userProfileDetail.showEdit">**********</span>
                        					<input ng-show="userProfileDetail.showEdit" type="password" class="form-control" ng-model="userProfileDetail.password">
                        				</td>
                      				</tr>
                      				<hr/>
                    			</tbody>
                  			</table>
                		</div>
               
                		<div class="col-sm-6 col-md-6 sol-lg-6">
                			<h3>Permissions</h3><hr>
                			<table class="table table-user-information text-left" style="color:black;">
                				<tbody style="margin-left: 40px;">
                					<tr>
                						<td><input type="checkbox" id="isAdminProfile" name="isAdminProfile" ng-checked="isAdminPermission == 'YES'" disabled></input></td>
                						<td>Admin</td>
                					</tr>
                					<tr>
                						<td><input type="checkbox" id="viewPermissionProfile" name="viewPermissionProfile" checked="true" disabled></td>
                						<td>View Permission</td>
                					</tr>
                					<tr>
                						<td><input type="checkbox" id="insertPermissionProfile" name="insertPermissionProfile" ng-checked="insertPermission == 'YES'" disabled></td>
                						<td>Insert Permission</td>
                					</tr>
                					<tr>
                						<td><input type="checkbox" id="updatePermissionProfile" name="updatePermissionProfile" ng-checked="updatePermission == 'YES'" disabled></td>
                						<td>Update Permission</td>
                					</tr>
                					<tr>
                						<td><input type="checkbox" id="deletePermissionProfile" name="deletePermissionProfile" ng-checked="deletePermission == 'YES'" disabled></td>
                						<td>Delete Permission</td>
                					</tr>
                					<tr>
                						<td><input type="checkbox" id="mailPermissionProfile" name="mailPermissionProfile" ng-checked="mailPermission == 'YES'" disabled></td>
                						<td>Mail Permission</td>
                					</tr>
                				</tbody>
                			</table>	
                		</div>
              		</div>
            	</div>
            	<div class="panel-footer">
            		<a title="Edit" ng-show="!userProfileDetail.showEdit" data-toggle="tooltip" type="button" ng-click="userProfileDetail.showEdit = !userProfileDetail.showEdit;validateProfile=false;" class="btn btn-info btn-primary">Edit</a>
                	<a style="cursor:pointer;" title="Save" ng-show="userProfileDetail.showEdit" ng-click="userProfileDetail.showEdit = !userProfileDetail.showEdit; updateProfile()" class="btn btn-success">Save</a>
                	<a style="cursor:pointer;" title="Cancel" ng-show="userProfileDetail.showEdit"  ng-click="userProfileDetail.showEdit = !userProfileDetail.showEdit; " class="btn btn-warning">Cancel</a>        
             	</div>
         	 </div>
       	 </div>
      </div>
   </div>