var fileContentTemp;

app.directive("ngFileSelect", function() {

	return {
		link : function($scope, el) {

			el.bind("change", function(e) {

				$scope.file = (e.srcElement || e.target).files[0];
				$scope.getFile();
			})

		}

	}

})

app.directive('fileModel', [ '$parse', function($parse) {
	return {
		restrict : 'A',
		link : function(scope, element, attrs) {
			var model = $parse(attrs.fileModel);
			var modelSetter = model.assign;

			element.bind('change', function() {
				scope.$apply(function() {
					modelSetter(scope, element[0].files[0]);
				});
			});
		}
	};
} ]);

app.directive('ngFileModel', [ '$parse', function($parse) {
	return {
		restrict : 'A',
		link : function(scope, element, attrs) {
			var model = $parse(attrs.ngFileModel);
			var isMultiple = attrs.multiple;
			var modelSetter = model.assign;
			element.bind('change', function() {
				var values = [];
				angular.forEach(element[0].files, function(item) {
					var value = {
						// File Name
						name : item.name,						// File Size
						size : item.size,
						// File URL to view
						url : URL.createObjectURL(item),
						// File Input Value
						_file : item
					};
					values.push(value);
				});
				scope.$apply(function() {
					if (isMultiple) {
						modelSetter(scope, values);
					} else {
						modelSetter(scope, values[0]);
					}
				});
			});
		}
	};
} ]);

app
		.controller(
				'userCtrl',
				[
						'Excel',
						'$timeout',
						'$scope',
						'$rootScope',
						'$http',
						'alertService',
						'fileReader',
						function(Excel,$timeout, $scope, $rootScope, $http, alertService,fileReader) {

							$scope.name = 'World';
							$scope.files = [];
							$scope.upload = function() {
								// alert($scope.files.length+" files selected
								// ... Write your Upload Code");
								// alert($scope.files[0].name+" files selected
								// ... Write your Upload Code");

							};

							$scope.mobileNoRegex = /^[\+]?[(]?[0-9]{3}[)]?[-\s\.]?[0-9]{3}[-\s\.]?[0-9]{4,6}$/;
							$scope.passRegex = /^(?=.*[A-Za-z])(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{6,12}$/;
							$scope.emailRegex = /^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,63}$/;

							$scope.selectedCatName = "";

							$scope.screenVisible = {
								"home" : {
									"value" : true
								},
								"report" : {
									"value" : false
								},
								"profile" : {
									"value" : false
								},
								"users" : {
									"value" : false
								},
								"emailaccounts" : {
									"value" : false
								},
								"addUser" : {
									"value" : false
								},
								"addemailaccount" : {
									"value" : false
								},
								"logs" : {
									"value" : false
								},
								"search" : {
									"value" : false
								},
								"support" : {
									"value" : false
								},
								"template" : {
									"value" : false
								},
								"contact" : {
									"value" : false
								},
								"newrecord" : {
									"value" : false
								},
								"downloadninstall" : {
									"value" : false
								}
								
							};
							
							$scope.showAnswer = function(ans) {
								if(ans == 1){
									
									if(document.getElementById("a_1").style.display == "none"){
										document.getElementById("a_1").style.display = "block";
									
									}
									else {
										document.getElementById("a_1").style.display = "none";
									}
								}
								if(ans == 2){
									
									if(document.getElementById("a_2").style.display == "none"){
										document.getElementById("a_2").style.display = "block";
									
									}
									else {
										document.getElementById("a_2").style.display = "none";
									}
								}
								if(ans == 3){
									
									if(document.getElementById("a_3").style.display == "none"){
										document.getElementById("a_3").style.display = "block";
									
									}
									else {
										document.getElementById("a_3").style.display = "none";
									}
								}
								if(ans == 4){
									
									if(document.getElementById("a_4").style.display == "none"){
										document.getElementById("a_4").style.display = "block";
									
									}
									else {
										document.getElementById("a_4").style.display = "none";
									}
								}
								if(ans == 5){
									
									if(document.getElementById("a_5").style.display == "none"){
										document.getElementById("a_5").style.display = "block";
									
									}
									else {
										document.getElementById("a_5").style.display = "none";
									}
								}
								if(ans == 6){
									
									if(document.getElementById("a_6").style.display == "none"){
										document.getElementById("a_6").style.display = "block";
									
									}
									else {
										document.getElementById("a_6").style.display = "none";
									}
								}
								if(ans == 7){
									
									if(document.getElementById("a_7").style.display == "none"){
										document.getElementById("a_7").style.display = "block";
									
									}
									else {
										document.getElementById("a_7").style.display = "none";
									}
								}
								if(ans == 8){
									
									if(document.getElementById("a_8").style.display == "none"){
										document.getElementById("a_8").style.display = "block";
									
									}
									else {
										document.getElementById("a_8").style.display = "none";
									}
								}
								if(ans == 9){
									
									if(document.getElementById("a_9").style.display == "none"){
										document.getElementById("a_9").style.display = "block";
									
									}
									else {
										document.getElementById("a_9").style.display = "none";
									}
								}
								if(ans == 10){
									
									if(document.getElementById("a_10").style.display == "none"){
										document.getElementById("a_10").style.display = "block";
									
									}
									else {
										document.getElementById("a_10").style.display = "none";
									}
								}
								if(ans == 11){
									
									if(document.getElementById("a_11").style.display == "none"){
										document.getElementById("a_11").style.display = "block";
									
									}
									else {
										document.getElementById("a_11").style.display = "none";
									}
								}
								if(ans == 12){
									
									if(document.getElementById("a_12").style.display == "none"){
										document.getElementById("a_12").style.display = "block";
									
									}
									else {
										document.getElementById("a_12").style.display = "none";
									}
								}
								if(ans == 13){
									
									if(document.getElementById("a_13").style.display == "none"){
										document.getElementById("a_13").style.display = "block";
									
									}
									else {
										document.getElementById("a_13").style.display = "none";
									}
								}
								if(ans == 14){
									
									if(document.getElementById("a_14").style.display == "none"){
										document.getElementById("a_14").style.display = "block";
									
									}
									else {
										document.getElementById("a_14").style.display = "none";
									}
								}
								if(ans == 15){
									
									if(document.getElementById("a_15").style.display == "none"){
										document.getElementById("a_15").style.display = "block";
									
									}
									else {
										document.getElementById("a_15").style.display = "none";
									}
								}
								if(ans == 16){
									
									if(document.getElementById("a_16").style.display == "none"){
										document.getElementById("a_16").style.display = "block";
									
									}
									else {
										document.getElementById("a_16").style.display = "none";
									}
								}
								if(ans == 17){
									
									if(document.getElementById("a_17").style.display == "none"){
										document.getElementById("a_17").style.display = "block";
									
									}
									else {
										document.getElementById("a_17").style.display = "none";
									}
								}
								if(ans == 18){
									
									if(document.getElementById("a_18").style.display == "none"){
										document.getElementById("a_18").style.display = "block";
									
									}
									else {
										document.getElementById("a_18").style.display = "none";
									}
								}
								if(ans == 19){
									
									if(document.getElementById("a_19").style.display == "none"){
										document.getElementById("a_19").style.display = "block";
									
									}
									else {
										document.getElementById("a_19").style.display = "none";
									}
								}
								if(ans == 20){
									
									if(document.getElementById("a_20").style.display == "none"){
										document.getElementById("a_20").style.display = "block";
									
									}
									else {
										document.getElementById("a_20").style.display = "none";
									}
								}
								if(ans == 21){
									
									if(document.getElementById("a_21").style.display == "none"){
										document.getElementById("a_21").style.display = "block";
									
									}
									else {
										document.getElementById("a_21").style.display = "none";
									}
								}
							}
							
							$scope.validateDataAddNewEmailAccount = function(){
								var firstName = document.getElementById("firstName").value;
								var lastName = document.getElementById("lastName").value;
								var designation = document.getElementById("designation").value;
								var emailId = document.getElementById("emailId").value;
								
								if(firstName.length <= 0){
									var message = "Please enter first name!";
									alertService
									.showFail(
											'addUserAlert',
											message);
									exit();
								}else if(lastName.length <= 0) {
									var message = "Please enter last name!";
									alertService
									.showFail(
											'addUserAlert',
											message);
									exit();
								}else if(designation.length <= 0) {
									var message = "Please enter designation!";
									alertService
									.showFail(
											'addUserAlert',
											message);
									exit();
								}else if(emailId.length <= 0){
									var message = "Please enter email address!";
									alertService
									.showFail(
											'addUserAlert',
											message);
									exit();
								}
								
								$scope.addNewEmailAccount();
							}
							
							$scope.resetNewEmailAccount = function (){
								alertService.cleanMsg("addEmailAccountAlert");
							}
							
							$scope.addNewEmailAccount = function() {
								waitingDialog.show();
							    var firstName = document.getElementById("firstName").value;
								var lastName = document.getElementById("lastName").value;
								var designation = document.getElementById("designation").value;
								var emailId = document.getElementById("emailId").value;
								var data = {
									'firstName' : firstName,
									'lastName' : lastName,
									'designation' : designation,
									'emailId' : emailId,
									'task' : 'addNewEmailAccount'
								};
								
								var config = {
									headers : {
										'Content-Type' : 'application/x-www-form-urlencoded;charset=utf-8;'
									}
								};
								try {

									$http
											.post("../controller/UserController.php",
													data, config)
											.success(
													function(data, status,
															headers, config) {
														waitingDialog.hide();	
														if (data == "failed") {
															var message = "Error : Something went wrong, please try later!";
															alertService
																	.showFail(
																			'addEmailAccountAlert',
																			message);
														} else if (data == "success"
																|| data == "SUCCESSsuccess") {
															var message = "Email Account created successfully!";
															alertService
																	.showSuccess(
																			'addEmailAccountAlert',
																			message);
															document.getElementById("firstName").value = "";
															document.getElementById("lastName").value = "";
															document.getElementById("designation").value = "";
															document.getElementById("emailId").value = "";
														}else if (data == "exist") {
															var message = "Exist : This email account is already exist!";
															alertService
																	.showFail(
																			'addEmailAccountAlert',
																			message);

														}else if (data == "expired") {
															var message = "You can not add email account! Your trial period is finished!";
															alertService
																	.showFail(
																			'addEmailAccountAlert',
																			message);

														}

													}).error(
													function(data, status,
															header, config) {
														console.log("error"
																+ data);
																
                                                        waitingDialog.hide();
                                                        alert(data);
													});
								} catch (e) {
									console.log(e.message);
									alert(e.message);
								}
							}

							
							$scope.validateDataAddNewUser = function(){
								
								var firstName = document.getElementById("firstname1").value;
								var lastName = document.getElementById("lastname1").value;
								var designation = document.getElementById("designation1").value;
								var userName = document.getElementById("username1").value;
								var emailId = document.getElementById("emailid1").value;
								var password = document.getElementById("password1").value;
								
								if(firstName.length <= 0){
									var message = "Please enter first name!";
									alertService
									.showFail(
											'addUserAlert',
											message);
									exit();
								}
								if(lastName.length <= 0) {
									var message = "Please enter last name!";
									alertService
									.showFail(
											'addUserAlert',
											message);
									exit();
								}
								if(designation.length <= 0) {
									var message = "Please enter designation!";
									alertService
									.showFail(
											'addUserAlert',
											message);
									exit();
								}
								if(userName.length <= 0){
									var message = "Please enter username!";
									alertService
									.showFail(
											'addUserAlert',
											message);
									exit();
								}
								if(emailId.length <= 0){
									var message = "Please enter email address!";
									alertService
									.showFail(
											'addUserAlert',
											message);
									exit();
								}
								if(password.length <= 0){
									var message = "Please enter password!";
									alertService
									.showFail(
											'addUserAlert',
											message);
									exit();
								}
								
								$scope.addNewUser();
							}
														
							$scope.userType = "Ordinary";
							$scope.isAdmin = "NO";
							$scope.viewPermission = "YES";
							$scope.insertPermission = "NO";
							$scope.updatePermission = "NO";
							$scope.deletePermission = "NO";
							$scope.mailPermission = "NO";
							$scope.isAdminClicked = function(){
								if($scope.isAdmin == "NO"){
									$scope.isAdmin = "YES";
									$scope.userType = "Admin";
									$scope.insertPermission = "YES";
									$scope.updatePermission = "YES";
									$scope.deletePermission = "YES";
									$scope.mailPermission = "YES";
									document.getElementById("insertPermission").checked = true;
									document.getElementById("updatePermission").checked = true;
									document.getElementById("deletePermission").checked = true;
									document.getElementById("mailPermission").checked = true;
									document.getElementById("insertPermission").disabled = true;
									document.getElementById("updatePermission").disabled = true;
									document.getElementById("deletePermission").disabled = true;
									document.getElementById("mailPermission").disabled = true;
								}else if($scope.isAdmin == "YES") {
									$scope.isAdmin = "NO";
									$scope.userType = "Ordinary";
									$scope.insertPermission = "NO";
									$scope.updatePermission = "NO";
									$scope.deletePermission = "NO";
									$scope.mailPermission = "NO";
									document.getElementById("insertPermission").checked = false;
									document.getElementById("updatePermission").checked = false;
									document.getElementById("deletePermission").checked = false;
									document.getElementById("mailPermission").checked = false;
									document.getElementById("insertPermission").disabled = false;
									document.getElementById("updatePermission").disabled = false;
									document.getElementById("deletePermission").disabled = false;
									document.getElementById("mailPermission").disabled = false;
								}
							}
							$scope.insertPermissionClicked = function(){
								if($scope.insertPermission == "NO")
									$scope.insertPermission = "YES";
								else
									$scope.insertPermission = "NO";
							}
							$scope.updatePermissionClicked = function(){
								if($scope.updatePermission == "NO")
									$scope.updatePermission = "YES";
								else
									$scope.updatePermission = "NO";
							}
							$scope.deletePermissionClicked = function(){
								if($scope.deletePermission == "NO")
									$scope.deletePermission = "YES";
								else
									$scope.deletePermission = "NO";
							}
							$scope.mailPermissionClicked = function (){
								if($scope.mailPermission == "NO")
									$scope.mailPermission = "YES";
								else
									$scope.mailPermission = "NO";
							}
							
							$scope.hideAlerts = function (divId){
								alertService.cleanMsg(divId);
							}
							
							$scope.setTemplate = function(templateType) {
								
							    var subject  = "";
							    var message = "";
							    
							    if (templateType == "user"){
							    	subject  = document.getElementById("subForUser").value;
									message = document.getElementById("msgForUser").value;
									
									if(subject.length <= 0 || message.length <= 0 ){
										var message = "All fields are mandatory!";
										alertService
												.showFail(
														'templateAlertMsg1',
														message);
										return;
									}
									
							    }else if(templateType == "escalation"){
							    	subject  = document.getElementById("subForEscalation").value;
									message = document.getElementById("msgForEscalation").value;
									
									if(subject.length <= 0 || message.length <= 0 ){
										var message = "All fields are mandatory!";
										alertService
												.showFail(
														'templateAlertMsg2',
														message);
										return;
									}
									
							    }else if(templateType == "vendore"){
							    	subject  = document.getElementById("subForVendore").value;
									message = document.getElementById("msgForVendore").value;
									
									if(subject.length <= 0 || message.length <= 0 ){
										var message = "All fields are mandatory!";
										alertService
												.showFail(
														'templateAlertMsg3',
														message);
										return;
									}
									
							    }
							    waitingDialog.show();
								var data = {
									'templateType' : templateType,
									'subject' : subject,
									'message' : message,
									'task' : 'setTemplate'
								};
								
								var config = {
									headers : {
										'Content-Type' : 'application/x-www-form-urlencoded;charset=utf-8;'
									}
								};
								try {

									$http
											.post("../controller/UserController.php",
													data, config)
											.success(
													function(data, status,
															headers, config) {
														waitingDialog.hide();
														alert(data);
														if (data == "failed") {
															
															if(templateType == "user"){
																var message = "Error : Something went wrong, please try later!";
																alertService
																		.showFail(
																				'templateAlertMsg1',
																				message);
															}else if(templateType = "escalation"){
																var message = "Error : Something went wrong, please try later!";
																alertService
																		.showFail(
																				'templateAlertMsg2',
																				message);
															}else if(templateType == "vendore"){
																var message = "Error : Something went wrong, please try later!";
																alertService
																		.showFail(
																				'templateAlertMsg3',
																				message);
															}
															
														} else if (data == "success"
																|| data == "SUCCESSsuccess") {
															
															if(templateType == "user"){
																var message = "Template saved successfully!";
																alertService
																		.showSuccess(
																				'templateAlertMsg1',
																				message);
															}else if(templateType == "escalation"){
																var message = "Template saved successfully!";
																alertService
																		.showSuccess(
																				'templateAlertMsg2',
																				message);
																
															}else if(templateType == "vendore"){
																var message = "Template saved successfully!";
																alertService
																		.showSuccess(
																				'templateAlertMsg3',
																				message);
															}
															
														}
													}).error(
													function(data, status,
															header, config) {
														console.log("error"
																+ data);
																
                                                        waitingDialog.hide();
													});
								} catch (e) {
									console.log(e.message);
								}
							}
							
							$scope.getUserTemplate = function() {
								
								$scope.subject = "";
								$scope.message = "";
								
								var data = {
									'templateType' : "user",
									'task' : 'getTemplate'
								};
								
								var config = {
									headers : {
										'Content-Type' : 'application/x-www-form-urlencoded;charset=utf-8;'
									}
								};
								try {

									$http
											.post("../controller/UserController.php",
													data, config)
											.success(
													function(data, status,
															headers, config) {
														if (data.result == "failed") {
															
														} else if (data.result == "success"
																|| data == "SUCCESSsuccess") {
															$scope.subject = data.subject;
															$scope.message = data.message;
														}
													}).error(
													function(data, status,
															header, config) {
														console.log("error"
																+ data);
																
													});
								} catch (e) {
									console.log(e.message);
								}
							}
							
							$scope.getEscalationTemplate = function() {
								
								$scope.subject = "";
								$scope.message = "";
								
								var data = {
									'templateType' : "escalation",
									'task' : 'getTemplate'
								};
								
								var config = {
									headers : {
										'Content-Type' : 'application/x-www-form-urlencoded;charset=utf-8;'
									}
								};
								try {

									$http
											.post("../controller/UserController.php",
													data, config)
											.success(
													function(data, status,
															headers, config) {
														if (data.result == "failed") {
															
														} else if (data.result == "success"
																|| data == "SUCCESSsuccess") {
															document.getElementById("subForEscalation").value = data.subject;
															document.getElementById("msgForEscalation").value = data.message;
														}
													}).error(
													function(data, status,
															header, config) {
														console.log("error"
																+ data);
																
													});
								} catch (e) {
									console.log(e.message);
								}
							}
							
							$scope.getVendoreTemplate = function() {
								
								$scope.subject = "";
								$scope.message = "";
								
								var data = {
									'templateType' : "vendore",
									'task' : 'getTemplate'
								};
								
								var config = {
									headers : {
										'Content-Type' : 'application/x-www-form-urlencoded;charset=utf-8;'
									}
								};
								try {

									$http
											.post("../controller/UserController.php",
													data, config)
											.success(
													function(data, status,
															headers, config) {
														if (data.result == "failed") {
															
														} else if (data.result == "success"
																|| data == "SUCCESSsuccess") {
															document.getElementById("subForVendore").value = data.subject;
															document.getElementById("msgForVendore").value = data.message;
														}
													}).error(
													function(data, status,
															header, config) {
														console.log("error"
																+ data);
																
													});
								} catch (e) {
									console.log(e.message);
								}
							}
							$scope.resetAddNewUser = function (){
								alertService.cleanMsg("addUserAlert");
							}
							$scope.addNewUser = function(logintype) {
								
								if (document.getElementById("isAdmin").checked){
									$scope.isAdmin = "YES";
								}else{
									$scope.isAdmin = "NO";
								}
								if (document.getElementById("insertPermission").checked){
									$scope.insertPermission = "YES";
								}else{
									$scope.insertPermission = "NO";
								}
								if (document.getElementById("updatePermission").checked){
									$scope.updatePermission = "YES";
								}else{
									$scope.updatePermission = "NO";
								}
								if (document.getElementById("deletePermission").checked){
									$scope.deletePermission = "YES";
								}else {
									$scope.deletePermission = "NO";
								}
								if (document.getElementById("mailPermission").checked){
									$scope.mailPermission = "YES";
								}else{
									$scope.mailPermission = "NO";
								}
								$scope.viewPermission = "YES";
								
								waitingDialog.show();
							    var firstName = document.getElementById("firstname1").value;
								var lastName = document.getElementById("lastname1").value;
								var designation = document.getElementById("designation1").value;
								var userName = document.getElementById("username1").value;
								var emailId = document.getElementById("emailid1").value;
								var password = document.getElementById("password1").value;
								var seniorEmail1 = document.getElementById("seniorEmail1").value;
								var seniorEmail2 = document.getElementById("seniorEmail2").value;
								
							    var data = {
									'firstName' : firstName,
									'lastName' : lastName,
									'designation' : designation,
									'userType' : $scope.userType,
									'userName' : userName,
									'emailId' : emailId,
									'password' : password,
									'seniorEmail1' : seniorEmail1,
									'seniorEmail2' : seniorEmail2,
									'isAdmin' : $scope.isAdmin, 
									'viewPermission' : $scope.viewPermission,
									'insertPermission' : $scope.insertPermission,
									'updatePermission' : $scope.updatePermission,
									'deletePermission' : $scope.deletePermission,
									'mailPermission' : $scope.mailPermission,

									'task' : 'addNewUser'
								};
								
								var config = {
									headers : {
										'Content-Type' : 'application/x-www-form-urlencoded;charset=utf-8;'
									}
								};
								try {

									$http
											.post("../controller/UserController.php",
													data, config)
											.success(
													function(data, status,
															headers, config) {
														waitingDialog.hide();
														if (data == "failed") {
															var message = "Error : Something went wrong, please try later!";
															alertService
																	.showFail(
																			'addUserAlert',
																			message);
														} else if (data == "success"
																|| data == "SUCCESSsuccess") {
															var message = "User created successfully!";
															alertService
																	.showSuccess(
																			'addUserAlert',
																			message);
															
															document.getElementById("firstname1").value = "";
															document.getElementById("lastname1").value = "";
															document.getElementById("designation1").value = "";
															document.getElementById("username1").value = "";
															document.getElementById("emailid1").value = "";
															document.getElementById("password1").value = "";
															document.getElementById("seniorEmail1").value = "";
															document.getElementById("seniorEmail2").value = "";
															
															document.getElementById("isAdmin").checked = false;
															document.getElementById("insertPermission").checked = false;
															document.getElementById("updatePermission").checked = false;
															document.getElementById("deletePermission").checked = false;
															document.getElementById("mailPermission").checked = false;
															
															
														}else if (data == "exist") {
															var message = "Exist : User with this details is already exist!";
															alertService
																	.showFail(
																			'addUserAlert',
																			message);

														}else if (data == "expired") {
															var message = "You can not add user! Your trial period is finished!";
															alertService
																	.showFail(
																			'addUserAlert',
																			message);

														}

													}).error(
													function(data, status,
															header, config) {
														console.log("error"
																+ data);
																
                                                        waitingDialog.hide();
                                                        alert(data);
													});
								} catch (e) {
									console.log(e.message);
									alert(e.message);
								}
							}
							
							$scope.deleteUser = function(renewalUser,userNo) {
								var r = confirm("Do you want to delete this report?");
							    if (r == true) {
							    	waitingDialog.show();
							    	var data = {
							    			'userId' : userNo,
							    			'task' : 'deleteuser'
							    	};
								
							    	var config = {
							    			headers : {
												'Content-Type' : 'application/x-www-form-urlencoded;charset=utf-8;'
										}
							    	};
							    	try {

							    		$http
							    			.post("../controller/UserController.php",
													data, config)
											.success(
													function(data, status,
															headers, config) {
														waitingDialog.hide();	
														if (data == "failed") {
															var message = "Error : Something went wrong, please try later!";
															alertService
																	.showFail(
																			'addUserAlert',
																			message);
														}else if (data == "currentUser"){
															alert("You can not delete currently active user!");
															var message = "You can not delete currently active user!";
															alertService
																	.showFail(
																			'addUserAlert',
																			message);
														}else if (data == "success"
																|| data == "SUCCESSsuccess") {
															
															var index=$scope.renewalUsersList.indexOf(renewalUser);
															$scope.renewalUsersList.splice(index,1);

															$('#usersTableRow_'+userNo).remove();
															
															var message = "User deleted successfully!";
															alertService
																	.showSuccess(
																			'userAlertMsg',
																			message);	
															
														}

													}).error(
													function(data, status,
															header, config) {
														console.log("error"
																+ data);
																
                                                        waitingDialog.hide();
                                                        alert(data);
													});
							    	} catch (e) {
							    		console.log(e.message);
							    		alert(e.message);
							    	}
							    }
							}
							
							$scope.extendPeriod = function(recordId){
					            //alert(subCat);
					            var modal = document.getElementById("extendModal");
					            modal.style.display = "block";
					            
					            //var mailBtn = document.getElementById("mailVendore");
					            //mailBtn.disabled = true;
					            
					            var btn = document.getElementById("clsExtendModal");
					            btn.onclick = function() {
                                    modal.style.display = "none";
                                }
                                
                                var span = document.getElementById("closeExtend");
                                span.onclick = function() {
                                    modal.style.display = "none";
                                }
                                
                                window.onclick = function(event) {
                                    if (event.target == modal) {
                                        modal.style.display = "none";
                                    }
                                }
                                
                                $scope.extendPeriodFor = recordId;
						    }
							$scope.closeAddUserModal = function(){
								var modal = document.getElementById("addUserModal");
					            modal.style.display = "none";
							}
							$scope.addUserModal = function(){
								//alert(subCat);
					            var modal = document.getElementById("addUserModal");
					            modal.style.display = "block";
					            
					            var btn = document.getElementById("clsModal");
					            btn.onclick = function() {
                                    modal.style.display = "none";
                                }
                                
                                var span = document.getElementsByClassName("close")[0];
                                span.onclick = function() {
                                    modal.style.display = "none";
                                }
							}
						    $scope.vendoreModal = function(recordId){
					            //alert(subCat);
					            var modal = document.getElementById("myModal");
					            modal.style.display = "block";
					            
					            //var mailBtn = document.getElementById("mailVendore");
					            //mailBtn.disabled = true;
					            
					            var btn = document.getElementById("clsModal");
					            btn.onclick = function() {
                                    modal.style.display = "none";
                                }
                                
                                var span = document.getElementsByClassName("close")[0];
                                span.onclick = function() {
                                    modal.style.display = "none";
                                }
                                
                                window.onclick = function(event) {
                                    if (event.target == modal) {
                                        modal.style.display = "none";
                                    }
                                }
                                
                                var mainCat = document.getElementById("cat_"+recordId).innerHTML;
                                var subCat = document.getElementById("subcat_"+recordId).innerHTML;
                                var data = {
                                    'mainCat' : mainCat,
                                    'subCat' : subCat,
									'task' : 'getVendoreInfo'
								};

								var config = {
									headers : {
										'Content-Type' : 'application/x-www-form-urlencoded;charset=utf-8;'
									}
								};

								try {

									$http
											.post("../controller/UserController.php",
													data, config)
											.success(
													function(data, status,
															headers, config) {
														try {
															if (data.message == "success") {
															    document.getElementById("oops").style.display = "none";
															    document.getElementById("success").style.display = "block";
															    var vendoreInfo = data.vendoreInfo;
															    $scope.vendoreInfoList = vendoreInfo;
															    var count = data.count;
															    $scope.totalVendores = count;
															    var zipCode = data.zipCode;
															    $scope.pinCode = zipCode;
															}
															else if(data.message == "not found")
															{
															    document.getElementById("success").style.display = "none";
															    document.getElementById("oops").style.display = "block";
															}
														} catch (e) {
															console
																	.log(e.message);
														}

													}).error(
													function(data, status,
															header, config) {
														// alert("logout
														// error
														// data
														// ::
														// "+data);
													});
								} catch (e) {
									console.log(e.message);
								}
					            
						    }
						    
						    $scope.mailMe = function (vendoreId){
						        waitingDialog.show();
						        var data = {
                                    'vendoreNo' : vendoreId,
									'task' : 'sendVendoreToMember'
								};

								var config = {
									headers : {
										'Content-Type' : 'application/x-www-form-urlencoded;charset=utf-8;'
									}
								};

								try {

									$http
											.post("../controller/UserController.php",
													data, config)
											.success(
													function(data, status,
															headers, config) {
															    waitingDialog.hide();
														try {
															if (data == "success") 
															{
															    document.getElementById("mailF_"+vendoreId).style.display = "none";
															    document.getElementById("mailS_"+vendoreId).style.display = "block";
															    document.getElementById("mailS_"+vendoreId).innerHTML = "Mail sent successfully!";
															}
															else
															{
															    document.getElementById("mailS_"+vendoreId).style.display = "none";
															    document.getElementById("mailF_"+vendoreId).style.display = "block";
															    document.getElementById("mailF_"+vendoreId).innerHTML = "Error: Please try later.";
															}
														} catch (e) {
															console
																	.log(e.message);
														}

													}).error(
													function(data, status,
															header, config) {
														// alert("logout
														// error
														// data
														// ::
														// "+data);
													});
								} catch (e) {
									console.log(e.message);
								}
						    }
						    
						    $scope.setCustomeCat = function () {
						        var val = document.getElementById("cat");
                                var selectedText = val.options[val.selectedIndex].text;
                                document.getElementById("customeCategory1").value = selectedText;
						    }
						    $scope.setCustomeSubCat = function () {
						        var val = document.getElementById("subcat");
                                var selectedText = val.options[val.selectedIndex].text;
                                document.getElementById("customeSubCategory1").value = selectedText;
						    }
                            $scope.calDiff = function(expiryDate, index){
							    
                            	var todayDate;
                            	var i = 0;
							    var date = new Date();
							    var day = date.getDate();
							    var month = date.getMonth();
							    month++;
							    var year = date.getFullYear();
							   
							    if(month < 10){
							    	month = "0" + month;
							    }
							    
							    todayDate = month+'/'+day+'/'+year;
							    var date2 = new Date($scope.formatString(expiryDate));
							    var date1 = new Date($scope.formatString(todayDate));
                                var timeDiff = date2.getTime() - date1.getTime();   
                                $scope.dayDifference = Math.ceil(timeDiff / (1000 * 3600 * 24));
                                $scope.allotResult = "";
                                //$scope.dayDifference  = $scope.dayDifference + 2;
                                
                                document.getElementById("setReminder_" + index).options.length = 0;
                                
                                for (i = 0; i < $scope.dayDifference; i++){
                                	var x = document.getElementById("setReminder_" + index );
                                    var option = document.createElement("option");
                                    option.text = i + 1;
                                    option.value = i + 1;
                                    x.add(option);	
                                }
                                
                                return $scope.dayDifference;
                                
							}
                            
                            $scope.calDiffUpdateRecord = function(expiryDate, id){
							    
                            	var todayDate;
                            	var i = 0;
							    var date = new Date();
							    var day = date.getDate();
							    var month = date.getMonth();
							    month++;
							    var year = date.getFullYear();
							   
							    if(month < 10){
							    	month = "0" + month;
							    }
							    
							    todayDate = month+'/'+day+'/'+year;
							    var date2 = new Date($scope.formatString(expiryDate));
							    var date1 = new Date($scope.formatString(todayDate));
                                var timeDiff = date2.getTime() - date1.getTime();   
                                $scope.dayDifference = Math.ceil(timeDiff / (1000 * 3600 * 24));
                                $scope.allotResult = "";
                                //$scope.dayDifference  = $scope.dayDifference + 2;
                                
                                document.getElementById("reminderBefore_" + id).options.length = 0;
                                
                                for (i = 0; i < $scope.dayDifference; i++){
                                	var x = document.getElementById("reminderBefore_" + id );
                                    var option = document.createElement("option");
                                    option.text = i + 1;
                                    option.value = i + 1;
                                    x.add(option);	
                                }
                                
                                return $scope.dayDifference;
                                
							}
							
							$scope.enterEmail = function () {
							    alert("Please enter supplier email to use this function.")
							}
							
							$scope.formatString = function(format) {
                                    
                                    var day   = parseInt(format.substring(3,5));
                                    var month  = parseInt(format.substring(0,2));
                                    var year   = parseInt(format.substring(6,10));
                                    var date = new Date(2017, month-1, day);
                                    return date;
                            }
                           
    						$scope.addActiveClass = function(currentId) {
								$('.vMenu li').removeClass("active");
								$('#' + currentId).addClass("active");
							}
							
							$scope.invisibleAllScreens = function() {

								for ( var i in $scope.screenVisible) {
									$scope.screenVisible[i].value = false;

								}
							}

							$scope.changeScreen = function(screenName) {
								$scope.invisibleAllScreens();
								$scope.screenVisible[screenName].value = true;

							}

							$scope.fileList = [];
							$scope.curFile;
							$scope.ImageProperty = {
								file : ''
							}
							$scope.currentIndex = "";
							$scope.setCurrentIndex = function(index) {
								$scope.currentIndex = index;
							}
							$scope.setFile = function(element) {
								// $scope.fileList = [];
								// get the files
								// alert($scope.currentIndex);
								var files = element.files;
								for (var i = 0; i < files.length; i++) {
									// $scope.renewalServices[$scope.currentIndex].fileObj
									// = files[i];
									$scope.renewalServices[$scope.currentIndex].fileName = files[i].name;
									$scope.fileList.push(files[i]);
									// $scope.ImageProperty = {};
									$scope.$apply();
								}
							}
						/*	$scope.renewalServices = [ {
								categoryId : '',
								subCategoryId : '',
								description : '',
								supplierName : '',
								amount : '',
								supplierEmail : '',
								expiryDate : '',
								contactNumber : '',
								comment : '',
								reminder : '15',
								fileName : ''
							}, {
								categoryId : '',
								subCategoryId : '',
								description : '',
								supplierName : '',
								amount : '',
								supplierEmail : '',
								expiryDate : '',
								contactNumber : '',
								comment : '',
								reminder : '15',
								fileName : ''
							}, {
								categoryId : '',
								subCategoryId : '',
								description : '',
								supplierName : '',
								amount : '',
								supplierEmail : '',
								expiryDate : '',
								contactNumber : '',
								comment : '',
								reminder : '15',
								fileName : ''
							}, {
								categoryId : '',
								subCategoryId : '',
								description : '',
								supplierName : '',
								amount : '',
								supplierEmail : '',
								expiryDate : '',
								contactNumber : '',
								comment : '',
								reminder : '15',
								fileName : ''
							}, {
								categoryId : '',
								subCategoryId : '',
								description : '',
								supplierName : '',
								amount : '',
								supplierEmail : '',
								expiryDate : '',
								contactNumber : '',
								comment : '',
								reminder : '15',
								fileName : ''
							} ]; */
							
						/*	$scope.addRenewalServiceRow = function() {
                                    alert($scope.recordsQty);
								    var item = {
									    categoryId : $scope.selectedCatName,
									    subCategoryId : $scope.selectedSubCatName,
									    description : '',
									    supplierName : '',
									    amount : '',
									    supplierEmail : '',
									    expiryDate : '',
									    contactNumber : '',
									    comment : '',
									    reminder : '15'
								    };
								    $scope.renewalServices.unshift(item);
							} */
							
							$scope.getNameByIdOfArray = function(id,
									currentArray) {
								for (var i = 0; i < currentArray.length; i++) {

									if (currentArray[i].id == id) {
										return currentArray[i].name;
									}
								}
							}

							$scope.setSelectedCategoryToColumn = function() {
								//$scope.selectedCatName = $scope
								//		.getNameByIdOfArray(id, currentArray);
								$scope.selectedCatName = document.getElementById("customeCategory1").value;
								for (var i = 0; i < $scope.renewalServices.length; i++) {
									$scope.renewalServices[i].categoryId = $scope.selectedCatName;
								}

							}

							$scope.setSelectedSubCategoryToColumn = function() {
								//$scope.selectedSubCatName = $scope
								//		.getNameByIdOfArray(id, currentArray);
								$scope.selectedSubCatName = document.getElementById("customeSubCategory1").value;
								for (var i = 0; i < $scope.renewalServices.length; i++) {
									$scope.renewalServices[i].subCategoryId = $scope.selectedSubCatName;
								}

							}

							$scope.initHome = function() {
								$scope.renewalServices = [ {
									categoryId : '',
									subCategoryId : '',
									entity : '',
									description : '',
									model : '',
									amount : '',
									gst : '',
									supplierName : '',
									supplierEmail : '',
									supplierContact : '',
									sendMailToSupplier : '',
									location : '',
									contactNumber : '',
									purchaseDate : '',
									expiryDate : '',
									reminder : '15',
									escalationEmail : '',
									setEscalation : '',
									startEscalation : '',
									fileName : ''
								}, {
									categoryId : '',
									subCategoryId : '',
									entity : '',
									description : '',
									model : '',
									amount : '',
									gst : '',
									supplierName : '',
									supplierEmail : '',
									supplierContact : '',
									sendMailToSupplier : '',
									location : '',
									contactNumber : '',
									purchaseDate : '',
									expiryDate : '',
									reminder : '15',
									escalationEmail : '',
									setEscalation : '',
									startEscalation : '',
									fileName : ''
								}, {
									categoryId : '',
									subCategoryId : '',
									entity : '',
									description : '',
									model : '',
									amount : '',
									gst : '',
									supplierName : '',
									supplierEmail : '',
									supplierContact : '',
									sendMailToSupplier : '',
									location : '',
									contactNumber : '',
									purchaseDate : '',
									expiryDate : '',
									reminder : '15',
									escalationEmail : '',
									setEscalation : '',
									startEscalation : '',
									fileName : ''
								}, {
									categoryId : '',
									subCategoryId : '',
									entity : '',
									description : '',
									model : '',
									amount : '',
									gst : '',
									supplierName : '',
									supplierEmail : '',
									supplierContact : '',
									sendMailToSupplier : '',
									location : '',
									contactNumber : '',
									purchaseDate : '',
									expiryDate : '',
									reminder : '15',
									escalationEmail : '',
									setEscalation : '',
									startEscalation : '',
									fileName : ''
								}, {
									categoryId : '',
									subCategoryId : '',
									entity : '',
									description : '',
									model : '',
									amount : '',
									gst : '',
									supplierName : '',
									supplierEmail : '',
									supplierContact : '',
									sendMailToSupplier : '',
									location : '',
									contactNumber : '',
									purchaseDate : '',
									expiryDate : '',
									reminder : '15',
									escalationEmail : '',
									setEscalation : '',
									startEscalation : '',
									fileName : ''
								} ];
								alertService.cleanMsg('addRenewalServiceAlert');
							}

							$scope.initGraph = function(){
								alertService.cleanMsg('reportAlertMsg');
								$scope.activeReportClass15 = true;
								$scope.activeReportClass30 = false;
								$scope.activeReportClass60 = false;
								$scope.activeReportClass90 = false;
								
							}
							$scope.initRecordByCategory = function(){
								alertService.cleanMsg('reportAlertMsg1');
								$scope.colapseReportDiv();
								
							}
							function checkAllotment()
							{
							    var days = $scope.dayDifference;
							    var param = "days="+days;
							    var xmlhttp = new XMLHttpRequest();
                                xmlhttp.onreadystatechange = function() {
                                    if (this.readyState == 4 && this.status == 200) {
                                        
                                         this.responseText;
                                    }
                                };
                                xmlhttp.open("POST","../controller/checkAllotment.php?"+param,true);
                                xmlhttp.send();
							}
						/*	$scope.checkAllotment = function() {
						    res();
								var data = {
								    'days' : $scope.dayDifference,
									'task' : 'checkAllotment'
								};

								var config = {
									headers : {
										'Content-Type' : 'application/x-www-form-urlencoded;charset=utf-8;'
									}
								};

								try {

									$http
											.post(
													baseUrl
															+ "renser/controller/UserController.php",
													data, config)
											.success(
													function(data, status,
															headers, config) {
														
													})
											.error(
													function(data, status,
															header, config) {
														alert("logout error data :: "
																+ data);
													});
								} catch (e) {
									console.log(e.message);
								}    
                                
							} */
							$scope.addRenewalService = function() {
							
								var i = 0;
								for (i = 0; i < $scope.renewalServices.length; i++){
									
									var description = document.getElementById("description_"+i).value;
									if (description.length > 250){
										var message = "Description has limit of 250 characters only.";
										alertService
												.showFail(
														'addRenewalServiceAlert',
														message);
										return;
									}
									
									var entity = document.getElementById("entity_"+i).value;
									if (entity.length > 100){
										var message = "Enity has limit of 100 characters only.";
										alertService
												.showFail(
														'addRenewalServiceAlert',
														message);
										return;
									}
									
									var model = document.getElementById("model_"+i).value;
									if (model.length > 20){
										var message = "Model has limit of 20 characters only.";
										alertService
												.showFail(
														'addRenewalServiceAlert',
														message);
										return;
									}
									
									var supplierName = document.getElementById("supplierName_"+i).value;
									if (supplierName.length > 100){
										var message = "Supplier Name has limit of 100 characters only.";
										alertService
												.showFail(
														'addRenewalServiceAlert',
														message);
										return;
									}
									
									var location = document.getElementById("location_"+i).value;
									if (location.length > 20){
										var message = "Location has limit of 20 characters only.";
										alertService
												.showFail(
														'addRenewalServiceAlert',
														message);
										return;
									}
										
								}
								
								var renewalServicesArray = $scope.renewalServices;
								$scope.tempRenewalServices = $scope.renewalServices;
								
								var tempRenewalServicesModified=[];
								var daysDiff=[];
								var isValid = true;
								var count = 0;
								var validRecords = 0;
								var ct = 0;
								var ese = "";
								for (var i = 0; i < renewalServicesArray.length; i++) {
									var currentRenewal = renewalServicesArray[i];
									var index = renewalServicesArray.indexOf(currentRenewal);
									if(currentRenewal.categoryId!="" && currentRenewal.categoryId!=undefined ){										
										if(currentRenewal.expiryDate!=undefined && currentRenewal.expiryDate!="" ){
										    daysDiff[count] = $scope.calDiff(currentRenewal.expiryDate, 1);
											tempRenewalServicesModified[count] = currentRenewal;
											count++;
										}
									}
								}
								
								if(tempRenewalServicesModified.length==0){
									var message = "Please provide record information .";
									alertService
											.showFail(
													'addRenewalServiceAlert',
													message);
								}else{
								waitingDialog.show();
								var fd = new FormData();
								for (var i = 0; i < $scope.fileList.length; i++) {
									fd.append('file' + i, $scope.fileList[i]);
								}
								fd.append('renewalServices', JSON
										.stringify(tempRenewalServicesModified));
								fd.append('daysDiff', JSON
										.stringify(daysDiff));
								// var obj = {
								// renewalServices: $scope.renewalServices,
								//									     
								// file: fd
								// };
								// var newObj = JSON.stringify(obj);
								
								var data = {
									'renewalService' : $scope.renewalServices,
									'daysDiff' : daysDiff,
									'task' : 'addRenewalService'
								};
								// alert("data::"+data );
								var config = {
									headers : {
										'Content-Type' : 'application/x-www-form-urlencoded;charset=utf-8;'
									}
								};
								
								try {
									// alert("dotFolderLevel::"+dotFolderLevel);
									// waitingDialog.show();

									$http
											.post("../controller/uploadFilePHP.php",
													fd,
													{
														transformRequest : angular.identity,
														headers : {
															'Content-Type' : undefined
														}
													})
											.success(
													function(data, status,
															headers, config) {
														$scope.selectedCategory = "";
														$scope.selectedSubCategory = "";
														waitingDialog.hide();
														if (data == "success") {
															var message = "Record added successfully.";
															alertService
																	.showSuccess(
																			'addRenewalServiceAlert',
																			message);
                                                            $scope.getProfileInfo();
                                                            $scope.getDashboardInfo();
														}
														if (data == "failed") {
															$scope.validate = true;
															var message = "Error : Opps something went wrong. Please contact helpdesk for details.";
															alertService
																	.showFail(
																			'addRenewalServiceAlert',
																			message);

														}
														if (data == "expired") {
															$scope.validate = true;
															var message = "You can not add records. Your trail period is finished!";
															alertService
																	.showFail(
																			'addRenewalServiceAlert',
																			message);

														}
														if(data == "NO") {
														    $scope.validate = true;
															var message = "Error : The slot is not available for the date you entered, please check your date and try again.";
															alertService
																	.showFail(
																			'addRenewalServiceAlert',
																			message);
														}

													}).error(
													function(data, status,
															header, config) {
														// waitingDialog.hide();
													});
								} catch (e) {
									// waitingDialog.hide();
									console.log(e.message);
								}
								}
							}
							
							
							$scope.openProfilePicModal = function(){
								$('#myModalprofilePic1').css("display","block");
							}
							
							$scope.closeProfilePicModal = function(){
								$('#myModalprofilePic1').css("display","none");
							}
							
							
//						    $scope.reminderList = [
//						        {id : '15', name : "15"},
//						        {id : '30', name : "30"},
//						        {id : '60', name : "60"}
//						    ];
							
							 $scope.reminderList = [];
						
							
							 $scope.getFile = function () {
							        $scope.progress = 0;
							        fileReader.readAsDataUrl($scope.file, $scope)
							                      .then(function(result) {
							                          $scope.imageSrc = result;
							                      });
							    };
							    
							$scope.updateProfilePic = function() {
								// alert($scope.renewalServices);
								 waitingDialog.show();
								var fd = new FormData();
								var file = $scope.userProfilePic;
								fd.append('file', file);
								fd.append('isProfilePic', 'true');
								fd.append('userVersion', $scope.userProfileDetail.version);
													        
								

								try {
									// alert("dotFolderLevel::"+dotFolderLevel);
									// waitingDialog.show();

									$http
											.post("../controller/uploadFilePHP.php",
													fd,
													{
														transformRequest : angular.identity,
														headers : {
															'Content-Type' : undefined
														}
													})
											.success(
													function(data, status,
															headers, config) {
														 waitingDialog.hide();

														if (data == "success") {
															var message = "Profile updated successfully .";
															alertService
																	.showSuccess(
																			'uploadProfilePicSuccessMSG',
																			message);
															
															$scope.userProfileDetail.profilePic = "../uploads/"+$scope.userProfileDetail.imgDir+"/profile/"+file.name;

														}
														if (data == "failed") {
															$scope.validate = true;
															var message = "Error : Opps something went wrong. Please contact helpdesk for details.";
															alertService
																	.showFail(
																			'uploadProfilePicSuccessMSG',
																			message);

														}

													}).error(
													function(data, status,
															header, config) {
														// waitingDialog.hide();
													});
								} catch (e) {
									// waitingDialog.hide();
									console.log(e.message);
								}

							}

							$scope.catgory = [ {
								"id" : "cat_0",
								"name" : "Hardware"
							}, {
								"id" : "cat_1",
								"name" : "Software"
							}, {
								"id" : "cat_2",
								"name" : "Network"
							}, {
								"id" : "cat_3",
								"name" : "Machinery"
							}, {
								"id" : "cat_4",
								"name" : "Legal"
							}, {
								"id" : "cat_5",
								"name" : "Payment"
							}, {
								"id" : "cat_6",
								"name" : "Tax"
							}, {
								"id" : "cat_7",
								"name" : "Lease agreement"
							}, {
								"id" : "cat_8",
								"name" : "Non disclosure agreement"
							}, {
								"id" : "cat_9",
								"name" : "Permit"
							}, {
								"id" : "cat_10",
								"name" : "Passport"
							}, {
								"id" : "cat_11",
								"name" : "Purchase order"
							}, {
								"id" : "cat_12",
								"name" : "Professional services"
							}, {
								"id" : "cat_13",
								"name" : "Insurance"
							}, {
								"id" : "cat_14",
								"name" : "Servicing"
							}, {
								"id" : "cat_15",
								"name" : "Food"
							}, {
								"id" : "cat_16",
								"name" : "Medical"
							}, {
								"id" : "cat_17",
								"name" : "Others"
							}, {
							    "id" : "cat_18",
							    "name" : "Driving License"
							}, {
							    "id" : "cat_19",
							    "name" : "Visa"
							}, {
							    "id" : "cat_20",
							    "name" : "White Goods"
							}];
							$scope.harwareSubType = [ {
								"id" : "subCat_0",
								"name" : "Desktop"
							}, {
								"id" : "subCat_1",
								"name" : "Server"
							}, {
								"id" : "subCat_2",
								"name" : "Storage"
							}, {
								"id" : "subCat_3",
								"name" : "Router"
							}, {
								"id" : "subCat_4",
								"name" : "Switches"
							}, {
								"id" : "subCat_5",
								"name" : "Modem"
							}, {
								"id" : "subCat_6",
								"name" : "Gateway"
							}, {
								"id" : "subCat_7",
								"name" : "Misc"
							}, {
								"id" : "subCat_8",
								"name" : "Laptop"
							}, {
								"id" : "subCat_9",
								"name" : "Printer"
							}];
							
							$scope.softwareSubType = [ {
								"id" : "subCat_0",
								"name" : "License"
							}, {
								"id" : "subCat_1",
								"name" : "Subscription"
							}, {
								"id" : "subCat_2",
								"name" : "Misc"
							} ];

							$scope.networkSubType = [ {
								"id" : "subCat_0",
								"name" : "Internet"
							}, {
								"id" : "subCat_1",
								"name" : "Toll Free"
							}, {
								"id" : "subCat_2",
								"name" : "OSP"
							}, {
								"id" : "subCat_3",
								"name" : "Misc"
							} ];

							$scope.machinarySubType = [ {
								"id" : "subCat_0",
								"name" : "HVAC"
							}, {
								"id" : "subCat_1",
								"name" : "UPS"
							}, {
								"id" : "subCat_2",
								"name" : "Battery"
							}, {
								"id" : "subCat_3",
								"name" : "Misc"
							} ];

							$scope.legalSubType = [ {
								"id" : "subCat_0",
								"name" : "Misc"
							} ];

							$scope.paymentSubType = [ {
								"id" : "subCat_0",
								"name" : "One time"
							}, {
								"id" : "subCat_1",
								"name" : "Recurring"
							}, {
								"id" : "subCat_2",
								"name" : "Misc"
							} ];

							$scope.taxSubType = [ {
								"id" : "subCat_0",
								"name" : "Income tax"
							}, {
								"id" : "subCat_1",
								"name" : "Audit Tax"
							}, {
								"id" : "subCat_2",
								"name" : "Service Tax"
							}, {
								"id" : "subCat_3",
								"name" : "GST Tax"
							}, {
								"id" : "subCat_4",
								"name" : "EXIM Tax"
							}, {
								"id" : "subCat_5",
								"name" : "Misc"
							}, {
								"id" : "subCat_6",
								"name" : "Professional Tax"
							}, {
								"id" : "subCat_7",
								"name" : "Form 16"
							}, {
								"id" : "subCat_8",
								"name" : "Property Tax"
							} ];

							$scope.legalAggrementSubType = [ {
								"id" : "subCat_0",
								"name" : "Shop"
							}, {
								"id" : "subCat_1",
								"name" : "Flat"
							}, {
								"id" : "subCat_2",
								"name" : "Land"
							}, {
								"id" : "subCat_3",
								"name" : "Machinery"
							}, {
								"id" : "subCat_4",
								"name" : "Misc"
							}, {
								"id" : "subCat_5",
								"name" : "Car"
							} ];

							$scope.discloseAggrementSubType = [ {
								"id" : "subCat_0",
								"name" : "IP"
							}, {
								"id" : "subCat_1",
								"name" : "Trademarks"
							}, {
								"id" : "subCat_2",
								"name" : "Copyrights"
							}, {
								"id" : "subCat_3",
								"name" : "Misc"
							} , {
								"id" : "subCat_3",
								"name" : "Vendor"
							} , {
								"id" : "subCat_3",
								"name" : "Customer"
							} ];

							$scope.licenseSubType = [ {
								"id" : "subCat_0",
								"name" : "Permits"
							}, {
								"id" : "subCat_1",
								"name" : "Vehicles"
							}, {
								"id" : "subCat_2",
								"name" : "hotel"
							}, {
								"id" : "subCat_3",
								"name" : "shop"
							}, {
								"id" : "subCat_4",
								"name" : "Foods & drugs"
							}, {
								"id" : "subCat_5",
								"name" : "Bar"
							}, {
								"id" : "subCat_6",
								"name" : "Misc"
							} ];

							$scope.professionalServSubType = [ {
								"id" : "subCat_0",
								"name" : "Contractor"
							}, {
								"id" : "subCat_1",
								"name" : "Temp resource"
							}, {
								"id" : "subCat_2",
								"name" : "Outsourcing"
							}, {
								"id" : "subCat_3",
								"name" : "Employement contract"
							}, {
								"id" : "subCat_4",
								"name" : "Misc"
							}, {
								"id" : "subCat_4",
								"name" : "Travel"
							}, {
								"id" : "subCat_4",
								"name" : "Canteen"
							} ];

							$scope.licenseSubType = [ {
								"id" : "subCat_0",
								"name" : "Car"
							}, {
								"id" : "subCat_1",
								"name" : "Health"
							}, {
								"id" : "subCat_2",
								"name" : "Mediclaim"
							}, {
								"id" : "subCat_3",
								"name" : "Home"
							}, {
								"id" : "subCat_4",
								"name" : "Property"
							}, {
								"id" : "subCat_5",
								"name" : "Misc"
							} ];

							$scope.servicingSubType = [ {
								"id" : "subCat_0",
								"name" : "Car"
							}, {
								"id" : "subCat_1",
								"name" : "Mobile"
							}, {
								"id" : "subCat_2",
								"name" : "Home"
							}, {
								"id" : "subCat_3",
								"name" : "Microwave"
							}, {
								"id" : "subCat_4",
								"name" : "Washing Machine"
							}, {
								"id" : "subCat_5",
								"name" : "Collers"
							}, {
								"id" : "subCat_6",
								"name" : "Aquaguard"
							}, {
								"id" : "subCat_7",
								"name" : "Bike"
							}, {
								"id" : "subCat_8",
								"name" : "Cycle"
							} , {
								"id" : "subCat_8",
								"name" : "Fridge"
							} , {
								"id" : "subCat_8",
								"name" : "T.V"
							} ];
							
							$scope.medicleSubType = [ {
								"id" : "subCat_0",
								"name" : "Medicine"
							}, {
								"id" : "subCat_1",
								"name" : "Surgicial devices"
							}, {
								"id" : "subCat_1",
								"name" : "Health Checkup"
							}];
							
							$scope.foodSubType = [{
							    "id" : "subCat_0",
							    "name" : "Dairy"
							}, {
							    "id" : "subCat_1",
							    "name" : "Eggs"
							}, {
							    "id" : "subCat_2",
							    "name" : "Fish"
							}, {
							    "id" : "subCat_3",
							    "name" : "Fruits"
							}, {
							    "id" : "subCat_4",
							    "name" : "Beverages"
							}, {
							    "id" : "subCat_5",
							    "name" : "Grains"
							}, {
							    "id" : "subCat_6",
							    "name" : "Bears"
							}, {
							    "id" : "subCat_7",
							    "name" : "Nuts"
							}, {
							    "id" : "subCat_8",
							    "name" : "Seeds"
							}, {
							    "id" : "subCat_9",
							    "name" : "Beet"
							}, {
							    "id" : "subCat_10",
							    "name" : "Fork"
							}];
							$scope.perchaseOrderSubType = [{
							    "id" : "subCat_0",
							    "name" : "Blanket"
							}, {
							    "id" : "subCat_1",
							    "name" : "Standard"
							}];
							
							$scope.passportSubType = [{
								"id" : "subCat_0",
								"name" : "Renewal"
							}];
							
							$scope.othersSubType = [ {
								"id" : "subCat_0",
								"name" : "Others"
							}];
                
                            $scope.drivingLicenseSubType = [ {
                                "id" : "subCat_0",
                                "name" : "Car"
                            }, {
                                "id" : "subCat_1",
                                "name" : "Bike"
                            }, {
                                "id" : "subCat_2",
                                "name" : "Motor"
                            }, {
                                "id" : "subCat_3",
                                "name" : "Truck"
                            }, {
                                "id" : "subCat_4",
                                "name" : "Cycle"
                            }];
                            
                            $scope.whiteGoodsSubType = [{
							    "id" : "subCat_0",
							    "name" : "A / C"
							}, {
							    "id" : "subCat_1",
							    "name" : "Aqua Guard"
							}, {
							    "id" : "subCat_2",
							    "name" : "Fridge"
							}, {
							    "id" : "subCat_3",
							    "name" : "Iron"
							}, {
							    "id" : "subCat_4",
							    "name" : "Washing Machine"
							}, {
							    "id" : "subCat_5",
							    "name" : "Mixer"
							}, {
							    "id" : "subCat_6",
							    "name" : "Blender"
							}, {
							    "id" : "subCat_7",
							    "name" : "Juicer"
							}, {
							    "id" : "subCat_8",
							    "name" : "Dish washing machine"
							}, {
							    "id" : "subCat_9",
							    "name" : "Microwave Oven"
							}];
							
							$scope.visaSubType = [];
							
							$scope.subCatgoryArrayList = [ {
								"id" : "cat_0",
								"name" : $scope.harwareSubType
							}, {
								"id" : "cat_1",
								"name" : $scope.softwareSubType
							}, {
								"id" : "cat_2",
								"name" : $scope.networkSubType
							}, {
								"id" : "cat_3",
								"name" : $scope.machinarySubType
							}, {
								"id" : "cat_4",
								"name" : $scope.legalSubType
							}, {
								"id" : "cat_5",
								"name" : $scope.paymentSubType
							}, {
								"id" : "cat_6",
								"name" : $scope.taxSubType
							}, {
								"id" : "cat_7",
								"name" : $scope.legalAggrementSubType
							}, {
								"id" : "cat_8",
								"name" : $scope.discloseAggrementSubType
							}, {
								"id" : "cat_9",
								"name" : $scope.licenseSubType
							}, {
								"id" : "cat_10",
								"name" : $scope.passportSubType
							},
							   {
								"id" : "cat_11",
								"name" : $scope.perchaseOrderSubType
							}, {
								"id" : "cat_12",
								"name" : $scope.professionalServSubType
							}, {
								"id" : "cat_13",
								"name" : $scope.licenseSubType
							}, {
								"id" : "cat_14",
								"name" : $scope.servicingSubType
							} , {
								"id" : "cat_15",
								"name" : $scope.foodSubType
							} , {
								"id" : "cat_16",
								"name" : $scope.medicleSubType
							}, {
								"id" : "cat_17",
								"name" : $scope.othersSubType
							}, {
							    "id" : "cat_18",
							    "name" : $scope.drivingLicenseSubType
							}, {
							    "id" : "cat_19",
							    "name" : $scope.visaSubType
							}, {
							    "id" : "cat_20",
							    "name" : $scope.whiteGoodsSubType
							} ];

							$scope.setSelectedSubCat = function(
									selectedCategoryMix , id) {	    
									    
								var length = selectedCategoryMix.length;
								var pos = selectedCategoryMix.search(",");
								var selectedCategory = selectedCategoryMix.slice(0,pos);
								var subCategoryArray = [];
								var names = [];
								var count = 0;
								for (var i = 0; i < $scope.subCatgoryArrayList.length; i++) {
									$scope.subCatgory = $scope.subCatgoryArrayList[i];

									if ($scope.subCatgory.id == selectedCategory) {
									    subCategoryArray = $scope.subCatgory.name
									    count++;
									}
								}
								var length = subCategoryArray.length;
								
								for (var i = 0; i < length; i++)
								{
								    names[i] = subCategoryArray[i]["name"];
								}
								
		                        var options = '';
		                        for (var i = 0; i < names.length; i++) {
                                    options += '<option value="' + names[i]+ '">' + names[i] + '</option>';
                                }
                                $("#subcat_" + id).html(options);
							}
//							 $scope.close_window=function() {
//								  if (confirm("You have been logged out.Please click ok to close Window")) {
//								    window.close();
//								  }
//								}
							
							$scope.logout = function() {
								// alert("in logout");
								$scope.validate = false;

								var data = {
									'task' : 'logout'
								};

								var config = {
									headers : {
										'Content-Type' : 'application/x-www-form-urlencoded;charset=utf-8;'
									}
								};

								try {

									$http
											.post("../controller/UserController.php",
													data, config)
											.success(
													function(data, status,
															headers, config) {
														// alert("logout
														// success
														// data
														// ::
														// "+data);
														// if(data=="success" ||
														// data=="SUCCESSsuccess"){
														var dataMsg = data.message;
														if (dataMsg == "success") {
															$scope = null;
															var newUrl = "../../../login.php";
//															location.reload();
															location
																	.assign(newUrl);
															//

														}

													})
											.error(
													function(data, status,
															header, config) {
														alert("logout error data :: "
																+ data);
													});
								} catch (e) {
									console.log(e.message);
								}
							}

							$scope.expandReportDiv = function(
									currentReportDivId) {
								$scope.colapseReportDiv();
								$('#' + currentReportDivId).show();
							}

							$scope.colapseReportDiv = function() {
								for (var i = 0; i < $scope.renewalServicesCountList.length; i++) {
									var id = 'reportDivId_' + i;
									$('#' + id).hide();
								}
								$('#reportDivId_100').hide();
							}
							
							$scope.colapseThisReportDiv = function(divId) {
								$('#' + divId).hide();
							}

							$scope.addActiveClassForReminder = function(value) {
								$scope.activeReportClass15 = false;
								$scope.activeReportClass30 = false;
								$scope.activeReportClass60 = false;
								$scope.activeReportClass90 = false;
								$scope.activeReportClass0 = false;
								$scope.activeReportClass00 = false;
								if (value == '15') {
									$scope.activeReportClass15 = true;
								}
								if (value == '30') {
									$scope.activeReportClass30 = true;
								}
								if (value == '60') {
									$scope.activeReportClass60 = true;
								}
								if (value == '90') {
									$scope.activeReportClass90 = true;
								}
								if (value == '0') {
								    $scope.activeReportClass0 = true;
								}
								if (value == '00') {
									$scope.activeReportClass00 = true;
								}
							}
                            $scope.updateRenewalService = function(reportService,reportId) {
                            	if($scope.updatePermission == "NO"){
                            		var message = "You don't have permission to edit records!";
								    alertService
									    	.showFail(
										    		'reportAlertMsg',
											    	message);
								    return;
                            	}
                            	
                            	 var entity = document.getElementById("entity_"+reportId).value;
								 var description = document.getElementById("description_"+reportId).value;
								 var model = document.getElementById("model_"+reportId).value;
								 var amount = document.getElementById("amount_"+reportId).value;
								 var gst = document.getElementById("gst_"+reportId).value;
								 var supplierName = document.getElementById("supplierName_"+reportId).value;
								 var supplierEmail = document.getElementById("supplierEmail_"+reportId).value;
								 var supplierContact = document.getElementById("supplierContact_"+reportId).value;
								 var location = document.getElementById("location_"+reportId).value;
								 var purchaseDate = document.getElementById("purchaseDate_"+reportId).value;
								 var expiryDate = document.getElementById("expiryDate_"+reportId).value;
								 var contractNo = document.getElementById("contractNo_"+reportId).value;
								 var reminderBefore = document.getElementById("reminderBefore_"+reportId).value;
								 var escalationMail = document.getElementById("escalationEmail_"+reportId).value;
								 var escalationStart = document.getElementById("escalationStart_"+reportId).value;
								 var daysDiff = $scope.calDiff(expiryDate, 1);
								 
								 if (entity > 100){
									 var message = "Entity has limit of 100 characters only.";
									    alertService
										    	.showFail(
											    		'reportAlertMsg',
												    	message);
									    return;
								 }
								 
								 if (description > 250){
									 var message = "Description has limit of 250 characters only.";
									    alertService
										    	.showFail(
											    		'reportAlertMsg',
												    	message);
									    return;
								 }
								 
								 if (model > 20){
									 var message = "Model has limit of 20 characters only.";
									    alertService
										    	.showFail(
											    		'reportAlertMsg',
												    	message);
									    return;
								 }
								 
								 if (supplierName > 100){
									 var message = "Supplier Name has limit of 100 characters only.";
									    alertService
										    	.showFail(
											    		'reportAlertMsg',
												    	message);
									    return;
								 }
								 
								 if (supplierContact > 12){
									 var message = "Supplier Contact has limit of 12 characters only.";
									    alertService
										    	.showFail(
											    		'reportAlertMsg',
												    	message);
									    return;
								 }
								 
								 if (location > 20){
									 var message = "Location has limit of 20 characters only.";
									    alertService
										    	.showFail(
											    		'reportAlertMsg',
												    	message);
									    return;
								 }
								 
								 var r = confirm("Do you want to update this report?");
								 if(r == true)
								 {
								    var fd = new FormData();
								    for (var i = 0; i < $scope.fileList.length; i++) {
										fd.append('file' + i, $scope.fileList[i]);
									}
									fd.append('reportId', reportId);
									fd.append('entity', entity);
									fd.append('description', description);
									fd.append('model', model);
									fd.append('supplierName', supplierName);
									fd.append('amount', amount);
									fd.append('gst', gst);
									fd.append('supplierEmail', supplierEmail);
									fd.append('supplierContact', supplierContact);
									fd.append('location', location);
									fd.append('purchaseDate', purchaseDate);
									fd.append('expiryDate', expiryDate);
									fd.append('contractNo', contractNo);
									fd.append('reminderBefore', reminderBefore);
									fd.append('escalationEmail', escalationMail);
									fd.append('escalationStart', escalationStart);
									
									if (parseInt($scope.currentIndex) > 0){
										fd.append('fileAttached', "YES");
										fd.append('fileName', $scope.renewalServices[$scope.currentIndex].fileName);
									}else{
										fd.append('fileAttached', "NO");
										fd.append('fileName', "");
									}
									fd.append('daysDiff', reminderBefore);
									fd.append('task', 'updateRecord');

								    var config = {
									    headers : {
										    'Content-Type' : 'application/x-www-form-urlencoded;charset=utf-8;'
									    }
								    };

								    try {

									    $http
										    	.post("../controller/uploadFilePHP.php",
										    			fd,
														{
															transformRequest : angular.identity,
															headers : {
																'Content-Type' : undefined
															}
														})
											    .success(
												    	function(data, status,
													    		headers, config) {
														    try {
															    if (data == "success") {
																    var message = "You have updated renewal record successfully!";
																    alertService
																	    	.showSuccess(
																		    		'reportAlertMsg',
																			    	message);

															    }
															    else if (data == "failed") {
																    var message = "Error : Opps something went wrong. Please contact helpdesk for details.";
																    alertService
																	    	.showFail(
																		    		'reportAlertMsg',
																			    	message);

															    }
															    else if(data == "NO")
															    {
															        var message = "No Slot : Oopps you don't have slot with that much of period. You need to extend date of your records.";
																    alertService
																	    	.showFail(
																		    		'reportAlertMsg',
																			    	message);
															    }
															    else if(data == "expired")
															    {
															        var message = "You can not update record! Your trial period is finished!";
																    alertService
																	    	.showFail(
																		    		'reportAlertMsg',
																			    	message);
															    }
															    else {
															         var message = "Please confirm that you filled all the fields correctly! Don't forgot to select expiry date and set reminder option to get on time reminder!";
																    alertService
																	    	.showFail(
																		    		'reportAlertMsg',
																			    	message);
															    }

														    } catch (e) {
															    console
																    	.log(e.message);
														    }

													    }).error(
													    function(data, status,
														    	header, config) {
														    // alert("logout
														    // error
														    // data
														    // ::
														    // "+data);
													    });
								    } catch (e) {
									    console.log(e.message);
								    }
								 }
								 else
								 {
								    
								 }
							}
							
							$scope.resetRenewalUser = function (){
								alertService.cleanMsg("userAlertMsg");
							}
                            
                            $scope.updateRenewalUser = function(user,userId) {
                            	
                            	if($scope.updatePermission == "NO"){
                            		var message = "You don't have permission to edit records!";
								    alertService
									    	.showFail(
										    		'reportAlertMsg',
											    	message);
								    return;
                            	}
                            	
								 var userName = document.getElementById("userName_" + userId).value;
								 var firstName = document.getElementById("firstName_" + userId).value;
								 var lastName = document.getElementById("lastName_" + userId).value;
								 var designation = document.getElementById("designation_" + userId).value;
								 var emailId = document.getElementById("emailId_" + userId).value;
								 var isAdminU = document.getElementById("isAdmin_" + userId).value;
								 var insertPermissionU = document.getElementById("insertPermission_" + userId).value;
								 var deletePermissionU = document.getElementById("deletePermission_" + userId).value;
								 var updatePermissionU = document.getElementById("updatePermission_" + userId).value;
								 var mailPermissionU = document.getElementById("mailPermission_" + userId).value;
								 var seniorEmail1 = document.getElementById("seniorEmail1_" + userId).value;
								 var seniorEmail2 = document.getElementById("seniorEmail2_" + userId).value;
								 
								 if (userName.length <= 0 || firstName.length <= 0 || lastName.length <= 0 || designation.length <= 0 || 
										 emailId.length <= 0 || isAdminU.length <= 0 || insertPermissionU.length <= 0 || deletePermissionU.length <= 0 ||
										 updatePermissionU.length <= 0 || mailPermissionU.length <= 0){
									 var message = "All fields are mandatory! Please fill all the details!";
									    alertService
										    	.showFail(
											    		'userAlertMsg',
												    	message);
									    return;
								 }
								 
								 if (isAdminU == "YES" || isAdminU == "NO") {
									 
								 }else{
									 var message = "Invalid values! Permission can be only YES or NO! Admin";
									    alertService
										    	.showFail(
											    		'userAlertMsg',
												    	message);
									    return;
								 }
								 
								 if(insertPermissionU == "YES" || insertPermissionU == "NO"){
									 
								 }else{
									 var message = "Invalid values! Permission can be only YES or NO! Insert";
									    alertService
										    	.showFail(
											    		'userAlertMsg',
												    	message);
									    return;
								 }
								 
								 if(deletePermissionU == "YES" || deletePermissionU == "NO"){
									 
								 }else{
									 var message = "Invalid values! Permission can be only YES or NO! Delete";
									    alertService
										    	.showFail(
											    		'userAlertMsg',
												    	message);
									    return;
								 }
								 
								 if(updatePermissionU == "YES" || updatePermissionU == "NO"){
									 
								 }else{
									 var message = "Invalid values! Permission can be only YES or NO! Update";
									    alertService
										    	.showFail(
											    		'userAlertMsg',
												    	message);
									    return;
								 }
								 
								 if(mailPermissionU == "YES" || mailPermissionU == "NO"){
									 
								 }else{
									 var message = "Invalid values! Permission can be only YES or NO! Mail";
									    alertService
										    	.showFail(
											    		'userAlertMsg',
												    	message);
									    return;
								 }
								  
								 var r = confirm("Do you want to update this user's details!");
								 if(r == true)
								 {
								    var data = {
									    'userId' : userId,
									    'firstName' : firstName,
									    'lastName' : lastName,
									    'userName' : userName,
									    'designation' : designation,
									    'emailId' : emailId,
									    'isAdmin' : isAdminU,
									    'insertPermission' : insertPermissionU,
									    'deletePermission' : deletePermissionU,
									    'updatePermission' : updatePermissionU,
									    'mailPermission' : mailPermissionU,
									    'seniorEmail1' : seniorEmail1,
									    'seniorEmail2' : seniorEmail2,
									    'task' : 'updateUserProfile'
								    };

								    var config = {
									    headers : {
										    'Content-Type' : 'application/x-www-form-urlencoded;charset=utf-8;'
									    }
								    };

								    try {

									    $http
										    	.post("../controller/UserController.php",
													    data, config)
											    .success(
												    	function(data, status,
													    		headers, config) {
														    try {
															    if (data == "success") {
																    var message = "User details are updated successfully!";
																    alertService
																	    	.showSuccess(
																		    		'userAlertMsg',
																			    	message);

															    }
															    else if (data == "failed") {
																    var message = "Error : Opps something went wrong. Please contact helpdesk for details.";
																    alertService
																	    	.showFail(
																		    		'userAlertMsg',
																			    	message);

															    }
															    else if(data == "exist")
															    {
															        var message = "This username is already alloted to another user. Please try another.";
																    alertService
																	    	.showFail(
																		    		'userAlertMsg',
																			    	message);
															    }
															    else {
															    	var message = "Error : Opps something went wrong. Please contact helpdesk for details.";
																    alertService
																	    	.showFail(
																		    		'userAlertMsg',
																			    	message);
															    }

														    } catch (e) {
															    console
																    	.log(e.message);
														    }

													    }).error(
													    function(data, status,
														    	header, config) {
														    // alert("logout
														    // error
														    // data
														    // ::
														    // "+data);
													    });
								    } catch (e) {
									    console.log(e.message);
								    }
								 }
								 else
								 {
								    
								 }
							}
							$scope.resetRenewalEmailAccount = function (){
								alertService.cleanMsg("emailAccountAlertMsg");
							}
                            $scope.updateRenewalEmailAccount = function(emailAccount,emailAccountId) {
                            	
								 var firstName = document.getElementById("firstName_" + emailAccountId).value;
								 var lastName = document.getElementById("lastName_" + emailAccountId).value;
								 var designation = document.getElementById("designation_" + emailAccountId).value;
								 var emailId = document.getElementById("emailId_" + emailAccountId).value;
								   
								 var r = confirm("Do you want to update this email account details!");
								 if(r == true)
								 {
								    var data = {
									    'firstName' : firstName,
									    'lastName' : lastName,
									    'designation' : designation,
									    'emailId' : emailId,
									    'emailAccountId' : emailAccountId,
									    'task' : 'updateEmailAccount'
								    };

								    var config = {
									    headers : {
										    'Content-Type' : 'application/x-www-form-urlencoded;charset=utf-8;'
									    }
								    };

								    try {

									    $http
										    	.post("../controller/UserController.php",
													    data, config)
											    .success(
												    	function(data, status,
													    		headers, config) {
														    try {
															
															    if (data == "success") {
																    var message = "Email Account details are updated successfully!";
																    alertService
																	    	.showSuccess(
																		    		'emailAccountAlertMsg',
																			    	message);

															    }
															    else if (data == "failed") {
																    var message = "Error : Opps something went wrong. Please contact helpdesk for details.";
																    alertService
																	    	.showFail(
																		    		'emailAccountAlertMsg',
																			    	message);

															    }
															    else {
															    	var message = "Error : Opps something went wrong. Please contact helpdesk for details.";
																    alertService
																	    	.showFail(
																		    		'emailAccountAlertMsg',
																			    	message);
															    }

														    } catch (e) {
															    console
																    	.log(e.message);
														    }

													    }).error(
													    function(data, status,
														    	header, config) {
														    // alert("logout
														    // error
														    // data
														    // ::
														    // "+data);
													    });
								    } catch (e) {
									    console.log(e.message);
								    }
								 }
								 else
								 {
								    
								 }
							}
                            
                            $scope.resetSearchRecord = function (){
                            	$scope.searchedServicesList = "";
                            	document.getElementById("searchQuery").value = "";
                            	document.getElementById("searchType").selectedIndex = 0;
                            }
                            
							$scope.searchRecord = function() {
								// alert("in logout");
								waitingDialog.show();
                                var searchType = document.getElementById("searchType").value;
                                
                                if ($scope.isAdminPermission == "YES"){
                                	if(searchType == "cat")
                                    {
                                        var query = document.getElementById("searchQuery").value;
                                        var data = {
                                            'searchType' : "catagory",
                                            'query' : query,
                                            'userType' : 'admin',
    									    'task' : 'searchRecord'
    								    };   
                                    }
                                    else if(searchType == "subcat")
                                    {
                                        var query = document.getElementById("searchQuery").value;
                                        var data = {
                                            'searchType' : "subcatagory",
                                            'query' : query,
                                            'userType' : 'admin',
    									    'task' : 'searchRecord'
    								    };
                                    }
                                    else if(searchType == "description")
                                    {
                                        var query = document.getElementById("searchQuery").value;
                                        var data = {
                                            'searchType' : "description",
                                            'query' : query,
                                            'userType' : 'admin',
    									    'task' : 'searchRecord'
    								    };
                                    }
                                    else if(searchType == "supplier")
                                    {
                                        var query = document.getElementById("searchQuery").value;
                                        var data = {
                                            'searchType' : "supplier",
                                            'query' : query,
                                            'userType' : 'admin',
    									    'task' : 'searchRecord'
    								    };
                                    }
                                    else if(searchType == "expiry")
                                    {
                                        var query = document.getElementById("searchdate").value;
                                        var data = {
                                            'searchType' : "expirydate",
                                            'query' : query,
                                            'userType' : 'admin',
    									    'task' : 'searchRecord'
    								    };
                                    }
                                    else if(searchType == "all"){
                                    	var query = document.getElementById("searchQuery").value;
                                        var data = {
                                            'searchType' : "all",
                                            'query' : query,
                                            'userType' : 'admin',
    									    'task' : 'searchRecord'
    								    };
                                    }
                                }else{
                                	if(searchType == "cat")
                                    {
                                        var query = document.getElementById("searchQuery").value;
                                        var data = {
                                            'searchType' : "catagory",
                                            'query' : query,
                                            'userType' : 'ordinary',
    									    'task' : 'searchRecord'
    								    };   
                                    }
                                    else if(searchType == "subcat")
                                    {
                                        var query = document.getElementById("searchQuery").value;
                                        var data = {
                                            'searchType' : "subcatagory",
                                            'query' : query,
                                            'userType' : 'ordinary',
    									    'task' : 'searchRecord'
    								    };
                                    }
                                    else if(searchType == "description")
                                    {
                                        var query = document.getElementById("searchQuery").value;
                                        var data = {
                                            'searchType' : "description",
                                            'query' : query,
                                            'userType' : 'ordinary',
    									    'task' : 'searchRecord'
    								    };
                                    }
                                    else if(searchType == "supplier")
                                    {
                                        var query = document.getElementById("searchQuery").value;
                                        var data = {
                                            'searchType' : "supplier",
                                            'query' : query,
                                            'userType' : 'ordinary',
    									    'task' : 'searchRecord'
    								    };
                                    }
                                    else if(searchType == "expiry")
                                    {
                                        var query = document.getElementById("searchdate").value;
                                        var data = {
                                            'searchType' : "expirydate",
                                            'query' : query,
                                            'userType' : 'ordinary',
    									    'task' : 'searchRecord'
    								    };
                                    }
                                    else if(searchType == "all"){
                                    	var query = document.getElementById("searchQuery").value;
                                        var data = {
                                            'searchType' : "all",
                                            'query' : query,
                                            'userType' : 'ordinary',
    									    'task' : 'searchRecord'
    								    };
                                    }
                                }                               
                                $scope.validate = false;
								var config = {
									headers : {
										'Content-Type' : 'application/x-www-form-urlencoded;charset=utf-8;'
									}
								};

								try {

									$http
											.post("../controller/UserController.php",
													data, config)
											.success(
													function(data, status,
															headers, config) {
														try {
														    waitingDialog.hide();
															if (data.message == "success") {
															    
															    var searchedServices = data.renewalServices;
																$scope.searchedServicesList = searchedServices;
															} else {
																var msg = "Oops something went wrong. Please contact support team!";
																alertService
																		.showFail(
																				'searchReportAlertMsg',
																				msg);
															}
														} catch (e) {
															console
																	.log(e.message);
														}

													}).error(
													function(data, status,
															header, config) {
														// alert("logout
														// error
														// data
														// ::
														// "+data);
													});
								} catch (e) {
									console.log(e.message);
								}
							}
							
							$scope.createLog = function (logActivity, logActivityId){
								var logDescription = "";
								if (logActivity == "RcrdInserted"){
									logDescription = "Record has been inserted!";
								}else if(logActivity == "RcrdDeleted"){
									logDescription = "Record has been deleted!";
								}else if(logActivity == "RcrdUpdated"){
									logDescription = "Record has been updated!";
								}else if(logActivity == "UsrInserted"){
									logDescription = "New user has been inserted!";
								}else if(logActivity == "UsrDeleted"){
									logDescription = "User has been deleted!";
								}else if(logActivity == "UsrUpdated"){
									logDescription = "User has been updated!";
								}
								
								var data = {
										'logActivity' : logActivity,
										'logDescription' : logDescription,
										'logActivityId' : logActivityId,
										'task' : 'createLog'
									};
								
								var config = {
										headers : {
											'Content-Type' : 'application/x-www-form-urlencoded;charset=utf-8;'
										}
									};
								
								try {

									$http
											.post("../controller/UserController.php",
													data, config)
											.success(
													function(data, status,
															headers, config) {
														try {
															alert(data);
															if (data == "success") {

															} else {
															
															}
														} catch (e) {
															console
																	.log(e.message);
														}

													}).error(
													function(data, status,
															header, config) {
														// alert("logout
														// error
														// data
														// ::
														// "+data);
													});
								} catch (e) {
									console.log(e.message);
								}
							}
							
							$scope.updateProcessStatus = function(recordId){
								var e = document.getElementById("updateProcessStatus_" + recordId);
								var processStatus = e.options[e.selectedIndex].value;
								
								var data = {
									'status' : processStatus,
									'recordId' : recordId,
									'task' : 'updateProcessStatus'
								};
								var config = {
									headers : {
										'Content-Type' : 'application/x-www-form-urlencoded;charset=utf-8;'
									}
								};

								try {

									$http
											.post("../controller/UserController.php",
													data, config)
											.success(
													function(data, status,
															headers, config) {
														try {
															if (data == "success") {
																var message = "Record process status updated successfully .";
																alertService
																		.showSuccess(
																				'reportAlertMsg',
																				message);
																document.getElementById("currentStatus_" + recordId).innerHTML = processStatus;
															}
															if (data == "failed") {
																var message = "Error : Opps something went wrong. Please contact helpdesk for details.";
																alertService
																		.showFail(
																				'profileMsg',
																				message);

															}

														} catch (e) {
															console
																	.log(e.message);
														}

													}).error(
													function(data, statuss,
															header, config) {
														// alert("logout
														// error
														// data
														// ::
														// "+data);
													});
								} catch (e) {
									console.log(e.message);
								}
								
							}
							
							$scope.updateProcessStatusSearch = function(recordId){
								var e = document.getElementById("updateProcessStatusSearch_" + recordId);
								var processStatus = e.options[e.selectedIndex].value;
								
								var data = {
									'status' : processStatus,
									'recordId' : recordId,
									'task' : 'updateProcessStatus'
								};
								var config = {
									headers : {
										'Content-Type' : 'application/x-www-form-urlencoded;charset=utf-8;'
									}
								};
								try {

									$http
											.post("../controller/UserController.php",
													data, config)
											.success(
													function(data, status,
															headers, config) {
														try {
															if (data == "success") {
																var message = "Record process status updated successfully .";
																alertService
																		.showSuccess(
																				'searchReportAlertMsg',
																				message);
																document.getElementById("currentStatusSearch_" + recordId).innerHTML = processStatus;
															}
															if (data == "failed") {
																var message = "Error : Opps something went wrong. Please contact helpdesk for details.";
																alertService
																		.showFail(
																				'searchReportAlertMsg',
																				message);

															}

														} catch (e) {
															console
																	.log(e.message);
														}

													}).error(
													function(data, statuss,
															header, config) {
														// alert("logout
														// error
														// data
														// ::
														// "+data);
													});
								} catch (e) {
									console.log(e.message);
								}
								
							}
							
							$scope.getRenewalServices = function(catagory,
									duefrom, dueto, index) {
								
								$scope.validate = false;
								if($scope.isAdminPermission == "YES"){
									var data = {
										'catagory' : catagory,
										// 'reminder' : reminder,
										'duefrom' : duefrom,
										'dueto' : dueto,
										'userType' : 'admin',
										'task' : 'getRenewalServices'
									};
								}else{
									var data = {
										'catagory' : catagory,
										// 'reminder' : reminder,
										'duefrom' : duefrom,
										'dueto' : dueto,
										'userType' : 'ordinary',
										'task' : 'getRenewalServices'
									};
								}

								var config = {
									headers : {
										'Content-Type' : 'application/x-www-form-urlencoded;charset=utf-8;'
									}
								};

								try {

									$http
											.post("../controller/UserController.php",
													data, config)
											.success(
													function(data, status,
															headers, config) {
														try {
															if (data.message == "success") {

																var renewalServices = data.renewalServices;
																$scope.renewalServicesList = renewalServices;
																$scope
																		.expandReportDiv('reportDivId_'
																				+ index);
															} else {
																var msg = "Oops something went wrong. Please contact support team!";
																alertService
																		.showFail(
																				'renewalServiceSuccessMsg',
																				msg);
															}
														} catch (e) {
															console
																	.log(e.message);
														}

													}).error(
													function(data, status,
															header, config) {
														// alert("logout
														// error
														// data
														// ::
														// "+data);
													});
								} catch (e) {
									console.log(e.message);
								}
							}
							
							$scope.getRenewalServicesNoUser = function() {
								
								$scope.validate = false;
								if($scope.isAdminPermission == "YES"){
									var data = {
										'userType' : 'admin',
										'task' : 'getRenewalServicesNoUser'
									};
								}

								var config = {
									headers : {
										'Content-Type' : 'application/x-www-form-urlencoded;charset=utf-8;'
									}
								};

								try {

									$http
											.post("../controller/UserController.php",
													data, config)
											.success(
													function(data, status,
															headers, config) {
														try {
															if (data.message == "success") {

																var renewalServicesNoUser = data.renewalServices;
																$scope.renewalServicesListNoUser = renewalServicesNoUser;
																$scope
																		.expandReportDiv('reportDivId_'
																				+ index);
															} else {
																var msg = "Oops something went wrong. Please contact support team!";
																alertService
																		.showFail(
																				'renewalServiceSuccessMsg',
																				msg);
															}
														} catch (e) {
															console
																	.log(e.message);
														}

													}).error(
													function(data, status,
															header, config) {
														// alert("logout
														// error
														// data
														// ::
														// "+data);
													});
								} catch (e) {
									console.log(e.message);
								}
							}
							
							$scope.loadNextLogs = function (){
								var log_from = document.getElementById("log_from1").innerHTML;
								var log_to = document.getElementById("log_to1").innerHTML;
								
								log_from = parseInt(log_from) + 15;
								log_to = parseInt(log_to) + 15;
								$scope.getRenewalLogs('All', log_from, log_to);
								
							}
							
							$scope.loadPrevLogs = function (){
								var log_from = document.getElementById("log_from1").innerHTML;
								var log_to = document.getElementById("log_to1").innerHTML;
								
								if (parseInt(log_from) == 0 && parseInt(log_to) == 15){
									
								}else{
									log_from = parseInt(log_from) - 15;
									log_to = parseInt(log_to) - 15;
									$scope.getRenewalLogs('All', log_from, log_to);
								}
							}
							
							$scope.loadNextLogsByUser = function (){
								var log_from = document.getElementById("log_from2").innerHTML;
								var log_to = document.getElementById("log_to2").innerHTML;
								
								log_from = parseInt(log_from) + 15;
								log_to = parseInt(log_to) + 15;
								$scope.getRenewalLogsByUser(log_from, log_to);
								
							}
							
							$scope.loadPrevLogsByUser = function (){
								var log_from = document.getElementById("log_from2").innerHTML;
								var log_to = document.getElementById("log_to2").innerHTML;
								
								if (parseInt(log_from) == 0 && parseInt(log_to) == 15){
									
								}else{
									log_from = parseInt(log_from) - 15;
									log_to = parseInt(log_to) - 15;
									$scope.getRenewalLogsByUser(log_from, log_to);
								}
							}
							
							$scope.loadNextLogsByDate = function (){
								var log_from = document.getElementById("log_from3").innerHTML;
								var log_to = document.getElementById("log_to3").innerHTML;
								
								log_from = parseInt(log_from) + 15;
								log_to = parseInt(log_to) + 15;
								$scope.getRenewalLogsByDate(log_from, log_to);
								
							}
							
							$scope.loadPrevLogsByDate = function (){
								var log_from = document.getElementById("log_from3").innerHTML;
								var log_to = document.getElementById("log_to3").innerHTML;
								
								if (parseInt(log_from) == 0 && parseInt(log_to) == 15){
									
								}else{
									log_from = parseInt(log_from) - 15;
									log_to = parseInt(log_to) - 15;
									$scope.getRenewalLogsByDate(log_from, log_to);
								}
							}
							
							$scope.getRenewalLogs = function(category, from, to) {
								// alert("in logout");
								waitingDialog.show();
								var data = {
										'category' : category,
										'from_log': from,
										'to_log' : to,
										'task' : 'getRenewalLogs'
									};

								var config = {
									headers : {
										'Content-Type' : 'application/x-www-form-urlencoded;charset=utf-8;'
									}
								};

								try {

									$http
											.post("../controller/UserController.php",
													data, config)
											.success(
													function(data, status,
															headers, config) {
														try {
															waitingDialog.hide();
															if (data.message == "success" && data.logs > 0) {
																
																if (data.logs > 0){
																	
																	document.getElementById("log_from1").innerHTML = from;
																	document.getElementById("log_to1").innerHTML = to;
																	
																	var renewalLogs = data.renewalLogs;
																	$scope.renewalLogsList = renewalLogs;
																	$scope
																			.expandReportDiv('reportDivId_'
																					+ index);
																}else{
																	var msg = "There are no more logs to show!";
																	alertService
																			.showFail(
																					'logsAlertMsg',
																					msg);
																}
																
															} else if (data.logs <= 0) {
																var msg = "There are no more logs to show!";
																alertService
																		.showFail(
																				'logsAlertMsg',
																				msg);
															}
														} catch (e) {
															console
																	.log(e.message);
														}

													}).error(
													function(data, status,
															header, config) {
														// alert("logout
														// error
														// data
														// ::
														// "+data);
													});
								} catch (e) {
									console.log(e.message);
								}
							}
							
							 $scope.resetLogsRecordByUser = function (){
                            	$scope.renewalLogsByUserList = "";
								document.getElementById("logUserList").value = "";
								alertService.cleanMsg("reportAlertMsg2");
                            }
							
							
							$scope.getRenewalLogsByUser = function(from1, to) {
								// alert("in logout");
								waitingDialog.show();
								var e = document.getElementById("logUserList");
								var userNo = e.options[e.selectedIndex].value;
								if (userNo.length <= 0){
									var msg = "Please select username to proceed!";
									alertService
											.showFail(
													'reportAlertMsg2',
													msg);
									return;
								}
								
								var data = {
										'user' : userNo,
										'from_log1': from1,
										'to_log1': to,
										'task' : 'getRenewalLogsByUser'
									};

								var config = {
									headers : {
										'Content-Type' : 'application/x-www-form-urlencoded;charset=utf-8;'
									}
								};

								try {

									$http
											.post("../controller/UserController.php",
													data, config)
											.success(
													function(data, status,
															headers, config) {
														try {
															waitingDialog.hide();
															if (data.message == "success") {
																if (data.logs > 0){
																	document.getElementById("log_from2").innerHTML = from1;
																	document.getElementById("log_to2").innerHTML = to;
																	
																	var renewalLogsByUser = data.renewalLogs;
																	$scope.renewalLogsByUserList = renewalLogsByUser;
																	var msg = "Logs are loaded!";
																	alertService
																			.showSuccess(
																					'reportAlertMsg2',
																					msg);
																}
																else{
																	var msg = "No log found for this user!";
																	alertService
																			.showFail(
																					'reportAlertMsg2',
																					msg);
																	$scope.renewalLogsByUserList = "";
																}
															} else if (data.message == "nolog"){
																$scope.renewalLogsByUserList = null;
																var msg = "No log found for this user!";
																alertService
																		.showFail(
																				'reportAlertMsg2',
																				msg);
																				
																$scope.renewalLogsByUserList = "";
															} 
														} catch (e) {
															console
																	.log(e.message);
														}

													}).error(
													function(data, status,
															header, config) {
														// alert("logout
														// error
														// data
														// ::
														// "+data);
													});
								} catch (e) {
									console.log(e.message);
								}
							}
							
							  $scope.resetLogsRecordByDate = function (){
                            	$scope.renewalLogsByDateList = "";
								document.getElementById("searchDate").value = "";
								alertService.cleanMsg("reportAlertMsg3");
                            }
							
							$scope.getRenewalLogsByDate = function(from1, to) {
								// alert("in logout");
								waitingDialog.show();
								var searchDate = document.getElementById("searchDate").value;	
								if (searchDate.length <= 0){
									var msg = "Please enter date to proceed!";
									alertService
											.showFail(
													'reportAlertMsg3',
													msg);
									return;
								}
								var data = {
										'date' : searchDate,
										'from_log': from1,
										'to_log': to,
										'task' : 'getRenewalLogsByDate'
									};

								var config = {
									headers : {
										'Content-Type' : 'application/x-www-form-urlencoded;charset=utf-8;'
									}
								};

								try {

									$http
											.post("../controller/UserController.php",
													data, config)
											.success(
													function(data, status,
															headers, config) {
														try {
															waitingDialog.hide();
															
															if (data.message == "success") {
																if (data.logs > 0){
																	document.getElementById("log_from3").innerHTML = from1;
																	document.getElementById("log_to3").innerHTML = to;
																	var renewalLogsByDate = data.renewalLogs;
																	$scope.renewalLogsByDateList = renewalLogsByDate;
																	var msg = "Logs are loaded!";
																	alertService
																			.showSuccess(
																					'reportAlertMsg3',
																					msg);
																}else{
																	var msg = "There is no log on this date!";
																	alertService
																		.showFail(
																				'reportAlertMsg3',
																				msg);
																	$scope.renewalLogsByDateList = "";
																}
																
															}else if (data.message = "nolog"){
																var msg = "There is no log on this date!";
																	alertService
																		.showFail(
																				'reportAlertMsg3',
																				msg);
																	$scope.renewalLogsByDateList = "";
															}else {
																var msg = "Oops something went wrong. Please contact support team!";
																alertService
																		.showFail(
																				'reportAlertMsg3',
																				msg);
															}
														} catch (e) {
															console
																	.log(e.message);
														}

													}).error(
													function(data, status,
															header, config) {
														// alert("logout
														// error
														// data
														// ::
														// "+data);
													});
								} catch (e) {
									console.log(e.message);
								}
							}
							
							$scope.getRenewalUsers = function() {
								
								
								var data = {
									'task' : 'getRenewalUsers'
								};

								var config = {
									headers : {
										'Content-Type' : 'application/x-www-form-urlencoded;charset=utf-8;'
									}
								};

								try {

									$http
											.post("../controller/UserController.php",
													data, config)
											.success(
													function(data, status,
															headers, config) {
														try {
															if (data.message == "success") {
																
																var renewalUsers = data.renewalUsers;
																$scope.renewalUsersList = renewalUsers;
																$scope
																		.expandReportDiv('reportDivId_'
																				+ index);
															} else {
																var msg = "Oops something went wrong. Please contact support team!";
																alertService
																		.showFail(
																				'renewalServiceSuccessMsg',
																				msg);
															}
														} catch (e) {
															console
																	.log(e.message);
														}

													}).error(
													function(data, status,
															header, config) {
														// alert("logout
														// error
														// data
														// ::
														// "+data);
													});
								} catch (e) {
									console.log(e.message);
								}
							}
							
							$scope.getRenewalEmailAccounts = function() {
								
								var data = {
									'task' : 'getRenewalEmailAccounts'
								};

								var config = {
									headers : {
										'Content-Type' : 'application/x-www-form-urlencoded;charset=utf-8;'
									}
								};

								try {

									$http
											.post("../controller/UserController.php",
													data, config)
											.success(
													function(data, status,
															headers, config) {
														try {
															if (data.message == "success") {
																
																var renewalEmailAccounts = data.renewalEmailAccounts;
																$scope.renewalEmailAccountsList = renewalEmailAccounts;
																$scope
																		.expandReportDiv('reportDivId_'
																				+ index);
															} else {
																var msg = "Oops something went wrong. Please contact support team!";
																alertService
																		.showFail(
																				'renewalServiceSuccessMsg',
																				msg);
															}
														} catch (e) {
															console
																	.log(e.message);
														}

													}).error(
													function(data, status,
															header, config) {
														// alert("logout
														// error
														// data
														// ::
														// "+data);
													});
								} catch (e) {
									console.log(e.message);
								}
							}
                            
							$scope.getRenewalServicesCount = function() {
								// alert("in logout");
								$scope.validate = false;

								if ($scope.isAdminPermission == "YES"){
									var data = {
											'userType' : 'admin',
											'task' : 'getAllRenewalServicesCount'
										};
								}else{
									var data = {
											'userType' : 'ordinary',
											'task' : 'getAllRenewalServicesCount'
										};
								}

								var config = {
									headers : {
										'Content-Type' : 'application/x-www-form-urlencoded;charset=utf-8;'
									}
								};

								try {

									$http
											.post("../controller/UserController.php",
													data, config)
											.success(
													function(data, status,
															headers, config) {
														try {
															if (data.message == "success") {
																// window.onload
																// =
																// function()
																// {
																var renewalServices = data.renewalServices;
																var totalCount = data.totalServices;
																$scope.totalServices = totalCount;
																$scope.renewalServicesCountList = renewalServices;
																var countArray = [];
																var categoryArray = [];
																var countInPerc = [];

																var backgroundClrAndCat = [];

//																var backgroundColorArr = [
//																					        window.chartColors.blue,
//																							window.chartColors.orange,
//																							window.chartColors.yellow,
//																							window.chartColors.green,
//																							window.chartColors.red,
//																							window.chartColors.black,
//																							window.chartColors.gray,
//																							window.chartColors.purple,
//																							window.chartColors.pink,
//																							window.chartColors.gold,
//																							window.chartColors.aqua,
//																							window.chartColors.blueViolet,
//																							window.chartColors.brown,
//																							window.chartColors.darkCyan,
//																							window.chartColors.darkMagenta,
//																							window.chartColors.indigo ];
																var backgroundColorArr = [
																        "#CD5C5C",
																        window.chartColors.blue,
																		window.chartColors.orange,
																		window.chartColors.red,
																		window.chartColors.green,
																		window.chartColors.yellow,
																		"#F08080",
																		"#FA8072",
																		"#E9967A",
																		"#FFA07A",
																		"#F9E79F",
																		"#85C1E9",
																		"#A3E4D7",
																		"#B2BABB",
																		"#D98880",
																		"#AF7AC5",
																		"#7FB3D5",
																		"#48C9B0",
																		"#52BE80",
																		"#F4D03F",
																		"#EDBB99",
																		"#85929E",
																		"#0E6251",
																		"#784212",
																		"#4A235A",
																		"#1A5276"
																		
																		];

																for (var i = 0; i < renewalServices.length; i++) {
																	var count = renewalServices[i].count;
																	countArray[i] = count;
																	categoryArray[i] = renewalServices[i].category;
																	
																	var valueInPer = (100 * count)/ totalCount;
																	
																	countInPerc[i] = valueInPer.toFixed(2);

																	dataArray = new Array(
																			categoryArray[i],
																			backgroundColorArr[i]);
																	backgroundClrAndCat[i] = dataArray;
																}
																$scope.backgroundClrAndCat = backgroundClrAndCat;
																var config = {
																	type : 'pie',
																	data : {
																		datasets : [ {
																			data : countArray,
																			backgroundColor : backgroundColorArr,
																			label : 'Dataset 1'
																		} ],
																		labels : categoryArray
																	},
																	options : {
																		title : {
																			display : true,
																			text : 'Reports'
																		}
																	// responsive:
																	// true
																	}
																};
																// var ctx =
																// document.getElementById("chart-area").getContext("2d");
																// window.myPie
																// = new
																// Chart(ctx,
																// config);
																$scope
																		.setPieChart(
																				countInPerc,
																				backgroundColorArr,
																				categoryArray);
																// };
																$scope.activeReportClass15 = true;
															} else {
																var msg = "Oops something went wrong. Please contact support team!";
																alertService
																		.showFail(
																				'renewalServiceSuccessMsg',
																				msg);
															}
														} catch (e) {
															console
																	.log(e.message);
														}

													}).error(
													function(data, status,
															header, config) {
														// alert("logout
														// error
														// data
														// ::
														// "+data);
													});
								} catch (e) {
									console.log(e.message);
								}
							}

							$scope.setPieChart = function(pieData,
									backgroundColor, categoryArray) {

								var canvas;
								var ctx;
								var lastend = 0;
								// var pieColor =
								// ["#ECD078","#D95B43","#C02942","#542437","#53777A"];
								// var pieData = [10,30,20,60,40];
								// var pieTotal = 10 + 30 + 20 + 60 + 40; //
								// done manually for demo
								var pieTotal = 100;
								var pieColor = backgroundColor;
								var pieData = pieData;
								canvas = document.getElementById("chart-area");
								ctx = canvas.getContext("2d");

								// ctx.clearRect(0, 0, canvas.width,
								// canvas.height);

								var hwidth = ctx.canvas.width / 2;
								var hheight = ctx.canvas.height / 2;

								for (var i = 0; i < pieData.length; i++) {
									ctx.fillStyle = pieColor[i];
									ctx.beginPath();
									ctx.moveTo(hwidth, hheight);
									ctx
											.arc(
													hwidth,
													hheight,
													hheight,
													lastend,
													lastend
															+ (Math.PI * 2 * (pieData[i] / pieTotal)),
													false);

									ctx.lineTo(hwidth, hheight);
									ctx.fill();

									// Labels on pie slices
									// (fully transparent
									// circle within outer
									// pie circle, to get
									// middle of pie slice)
									// ctx.fillStyle =
									// "rgba(255, 255, 255,
									// 0.5)"; //uncomment
									// for debugging
									// ctx.beginPath();
									// ctx.moveTo(hwidth,hheight);
									// ctx.arc(hwidth,hheight,hheight/1.25,lastend,lastend+
									// (Math.PI*(pieData[i]/pieTotal)),false);
									// //uncomment for debugging

									var radius = hheight / 1.5; // use
									// suitable
									// radius
									var endAngle = lastend
											+ (Math.PI * (pieData[i] / pieTotal));
									var setX = hwidth + Math.cos(endAngle)
											* radius;
									var setY = hheight + Math.sin(endAngle)
											* radius;
									ctx.fillStyle = "#ffffff";
									ctx.font = '14px Calibri';
									// var textToFill =
									// categoryArray[i] + "
									// : " + pieData[i];
									ctx.fillText(pieData[i], setX, setY);

									// ctx.lineTo(hwidth,hheight);
									// ctx.fill();
									// //uncomment for
									// debugging

									lastend += Math.PI * 2
											* (pieData[i] / pieTotal);
								}
							}
							$scope.updateProfile = function() {
								var firstName = $scope.userProfileDetail.firstName;
								var lastName = $scope.userProfileDetail.lastName;
								var designation = $scope.userProfileDetail.designation;
								var userName = $scope.userProfileDetail.userName;
								var password = $scope.userProfileDetail.password;
								var emailId = $scope.userProfileDetail.email;
							
								if (firstName.length <= 0 || lastName.length <= 0 || designation.length <= 0 || userName.length <= 0 || password.length <= 0 || emailId.length <= 0){
									var message = "Error : All fields are mandatory.";
									alertService
											.showFail(
													'profileMsg',
													message);
									return;
								}
								
								var data = {
									'updateProfieUser' : $scope.userProfileDetail,
									'task' : 'updateUser'
								};

								var config = {
									headers : {
										'Content-Type' : 'application/x-www-form-urlencoded;charset=utf-8;'
									}
								};

								try {

									$http
											.post("../controller/UserController.php",
													data, config)
											.success(
													function(data, status,
															headers, config) {
														try {
															if (data == "success") {
																var message = "User profile updated successfully .";
																alertService
																		.showSuccess(
																				'profileMsg',
																				message);

															}
															if (data == "failed") {
																var message = "Error : Opps something went wrong. Please contact helpdesk for details.";
																alertService
																		.showFail(
																				'profileMsg',
																				message);

															}

														} catch (e) {
															console
																	.log(e.message);
														}

													}).error(
													function(data, statuss,
															header, config) {
														// alert("logout
														// error
														// data
														// ::
														// "+data);
													});
								} catch (e) {
									console.log(e.message);
								}
							}

							$scope.getProfileInfo = function() {
								var data = {
									'task' : 'getProfileInfo'
								};

								var config = {
									headers : {
										'Content-Type' : 'application/x-www-form-urlencoded;charset=utf-8;'
									}
								};

								try {

									$http
											.post("../controller/UserController.php",
													data, config)
											.success(
													function(data, status,
															headers, config) {
														try {
															if (data.message == "success") {
																
																$scope.userProfileDetail = data.userInfo.userInfo;
																$scope.isAdminPermission = $scope.userProfileDetail.isAdmin;
																$scope.insertPermission = $scope.userProfileDetail.insertPermission;
																$scope.updatePermission = $scope.userProfileDetail.updatePermission;
																$scope.deletePermission = $scope.userProfileDetail.deletePermission;
																$scope.mailPermission = $scope.userProfileDetail.mailPermission;
																
																if($scope.isAdminPermission == "NO"){
																	document.getElementById("userBlock").style.display = "none";
																	document.getElementById("adminBlock").style.display = "none";
																	document.getElementById("vMenuUsersId").style.display = "none";
																	document.getElementById("vMenuLogsId").style.display = "none";
																	document.getElementById("vMenuEmailAccountsId").style.display = "none";
																	document.getElementById("userTypeTitle").innerHTML = "Client User";
																}else{
																	document.getElementById("userTypeTitle").innerHTML = "Admin";
																}
																$scope.noOfRecords = 5;
																if($scope.noOfRecords >= 5)
																{
																	$scope.renewalServices = [ {
								                                        categoryId : '',
								                                        subCategoryId : '',
								                                        entity : '',
								                                        description : '',
								                                        model : '',
								                                        amount : '',
								                                        gst : '',
								                                        supplierName : '',
								                                        supplierEmail : '',
								                                        supplierContact : '',
								                                        sendMailToSupplier : 0,
								                                        location : '',
								                                        purchaseDate : '',
								                                        expiryDate : '',
								                                        contactNumber : '',
								                                        reminder : '15',
								                                        escalationEmail : '',
								                                        setEscalation : '',
								                                        startEscalation : '',
								                                        fileName : ''
							                                        }, {
							                                        	categoryId : '',
								                                        subCategoryId : '',
								                                        entity : '',
								                                        description : '',
								                                        model : '',
								                                        amount : '',
								                                        gst : '',
								                                        supplierName : '',
								                                        supplierEmail : '',
								                                        supplierContact : '',
								                                        sendMailToSupplier : 0,
								                                        location : '',
								                                        purchaseDate : '',
								                                        expiryDate : '',
								                                        contactNumber : '',
								                                        reminder : '15',
								                                        escalationEmail : '',
								                                        setEscalation : '',
								                                        startEscalation : '',
								                                        fileName : ''
							                                        }, {
							                                        	categoryId : '',
								                                        subCategoryId : '',
								                                        entity : '',
								                                        description : '',
								                                        model : '',
								                                        amount : '',
								                                        gst : '',
								                                        supplierName : '',
								                                        supplierEmail : '',
								                                        supplierContact : '',
								                                        sendMailToSupplier : 0,
								                                        location : '',
								                                        purchaseDate : '',
								                                        expiryDate : '',
								                                        contactNumber : '',
								                                        reminder : '15',
								                                        escalationEmail : '',
								                                        setEscalation : '',
								                                        startEscalation : '',
								                                        fileName : ''
							                                        }, {
							                                        	categoryId : '',
								                                        subCategoryId : '',
								                                        entity : '',
								                                        description : '',
								                                        model : '',
								                                        amount : '',
								                                        gst : '',
								                                        supplierName : '',
								                                        supplierEmail : '',
								                                        supplierContact : '',
								                                        sendMailToSupplier : 0,
								                                        location : '',
								                                        purchaseDate : '',
								                                        expiryDate : '',
								                                        contactNumber : '',
								                                        reminder : '15',
								                                        escalationEmail : '',
								                                        setEscalation : '',
								                                        startEscalation : '',
								                                        fileName : ''
							                                        }, {
							                                        	categoryId : '',
								                                        subCategoryId : '',
								                                        entity : '',
								                                        description : '',
								                                        model : '',
								                                        amount : '',
								                                        gst : '',
								                                        supplierName : '',
								                                        supplierEmail : '',
								                                        supplierContact : '',
								                                        sendMailToSupplier : 0,
								                                        location : '',
								                                        purchaseDate : '',
								                                        expiryDate : '',
								                                        contactNumber : '',
								                                        reminder : '15',
								                                        escalationEmail : '',
								                                        setEscalation : '',
								                                        startEscalation : '',
								                                        fileName : ''
							                                        }];
								            					}
															}
														} catch (e) {
															console
																	.log(e.message);
														}

													}).error(
													function(data, status,
															header, config) {
														// alert("logout
														// error
														// data
														// ::
														// "+data);
													});
								} catch (e) {
									console.log(e.message);
								}
							}
							
							$scope.getDashboardInfo = function() {
								var data = {
									'task' : 'getDashboardInfo'
								};

								var config = {
									headers : {
										'Content-Type' : 'application/x-www-form-urlencoded;charset=utf-8;'
									}
								};

								try {

									$http
											.post("../controller/UserController.php",
													data, config)
											.success(
													function(data, status,
															headers, config) {
														try {
															if (data.message == "success") {
																
																alertService.cleanMsg("noRecordAlert");
																document.getElementById("piechart_3d").style.display="block";
																document.getElementById("chartdiv").style.display="block";
																
																$scope.dashboardTotalRecords = data.totalRecords;
																$scope.dashboardInProgress = data.inProgressRecords;
																$scope.dashboardOpen = data.openRecords;
																$scope.dashboardClosed = data.closedRecords;
																$scope.dashboardExpireInFifteen = data.expireInFifteen;
																$scope.dashboardExpireInThirty = data.expireInThirty;
																$scope.dashboardExpireInSixty = data.expireInSixty;
																$scope.dashboardExpireInGSixty = data.expireInGSixty;
																$scope.dashboardExpiredRecords = data.expiredRecords;
																if($scope.dashboardTotalRecords == 0){
																	var message = "There are no Records Available!";															var message = "Error : Opps something went wrong. Please contact helpdesk for details.";
																	alertService
																		.showFail(
																				'noRecordAlert',
																				"There Are No Records Available! Please Add New Records.");

																	document.getElementById("piechart_3d").style.display="none";
																	document.getElementById("chartdiv").style.display="none";
																}
																$scope.getDashboardInfo();	
															}
														} catch (e) {
															console
																	.log(e.message);
														}

													}).error(
													function(data, status,
															header, config) {
														// alert("logout
														// error
														// data
														// ::
														// "+data);
													});
								} catch (e) {
									console.log(e.message);
								}
							}
							
							$scope.getDashboardUserInfo = function() {
								
								var data = {
									'task' : 'getDashboardUserInfo'
								};

								var config = {
									headers : {
										'Content-Type' : 'application/x-www-form-urlencoded;charset=utf-8;'
									}
								};

								try {

									$http
											.post("../controller/UserController.php",
													data, config)
											.success(
													function(data, status,
															headers, config) {
														try {
															if (data.message == "success") {
																var dashUser = data.users; 
																$scope.dashUsers = dashUser;
																$scope.getDashboardUserInfo();
															}
														} catch (e) {
															console
																	.log(e.message);
														}

													}).error(
													function(data, status,
															header, config) {
														// alert("logout
														// error
														// data
														// ::
														// "+data);
													});
								} catch (e) {
									console.log(e.message);
								}
							}
							
							$scope.showPieChart = function(){
								google.charts.load("current", {packages:["corechart"]});
			      				google.charts.setOnLoadCallback(drawChart);
			      				function drawChart() {
			      					var total = parseInt(document.getElementById("gTotalRecords").innerHTML);
									var open = parseInt(document.getElementById("gOpenRecords").innerHTML); 
									var	inProgress = parseInt(document.getElementById("gInProgressRecords").innerHTML); 
									var	closed = parseInt(document.getElementById("gClosedRecords").innerHTML);
									var open_recs = Math.round(open/total*100);
									var inProgress_rec = Math.round(inProgress/total*100);
									var closed_rec = Math.round(closed/total*100);
			        				var data = google.visualization.arrayToDataTable([
			          					['Records', 'Percentage'],
			          					['Open Records', open_recs,],
			          					['In Progress Records', inProgress_rec,],
			          					['Closed Records', closed_rec,],
			          					
			        				]);

			        				var options = {
			          					title: 'Chart view in Percentage (%) by its status',
			          					is3D: true,
			        				};
			        				var chart = new google.visualization.PieChart(document.getElementById('piechart_3d'));
			       				 	chart.draw(data, options);
			      				}
								setTimeout(function(){ $scope.showBarChart(); }, 1000);
							}
							
							$scope.showBarChart= function (){
								var due15 = parseInt($scope.dashboardExpireInFifteen);
								var due30 = parseInt($scope.dashboardExpireInThirty);
								var due60 = parseInt($scope.dashboardExpireInSixty);
								var dueg60 = parseInt($scope.dashboardExpireInGSixty);
								var expired = parseInt($scope.dashboardExpiredRecords);
								var chart = AmCharts.makeChart("chartdiv", {
									"theme": "light",
									"type": "serial",
									"startDuration": 2,
									"dataProvider": [{
													"country": "Due in 15 days",
													"visits": due15,
													"color": "#04D215"
									}, 				
													{
													"country": "Due in 30 days",
													"visits": due30,
													"color": "#2A0CD0"
									}, 		
													{
													"country": "Due in 60 days",
													"visits": due60,
													"color": "#db3dd8"
									},			
													{
													"country": "Due in >60 days",
													"visits": dueg60,
													"color": "#4fdbe2"
									},
													{
													"country": "Expired",
													"visits": expired,
													"color": "#FF0F00"
									}],
													"valueAxes": [{
													"position": "left",
													"title": "No. of Records"
									}],
													"graphs": [{
													"balloonText": "[[category]]: <b>[[value]]</b>",
													"fillColorsField": "color",
													"fillAlphas": 1,
													"lineAlpha": 0.1,
													"type": "column",
													"valueField": "visits"
									}],
													"depth3D": 69,
													"angle": 33.82,
													"chartCursor": {
													"categoryBalloonEnabled": false,
													"cursorAlpha": 0,
													"zoomable": false
													},
													"categoryField": "country",
													"categoryAxis": {
													"gridPosition": "start",
													"labelRotation": 90
												},
												"export": {
												"enabled": true
												}

								});
							}

							$scope.exportToExcel = function(tableId) { // ex:
								// '#my-table'
								$scope.exportHref = Excel.tableToExcel(tableId,'Report');
								$timeout(function() {
									var link = document.createElement('a');
									link.download = "Report.xls";
									link.href = $scope.exportHref;
									link.click();
									// location.href=$scope.exportHref;
								}, 100); // trigger
								// download
							}
							
						   $scope.printData = function(tableId)
						   {
							   var divToPrint=$(tableId);
							   newWin= window.open("");
							   
//							   //Get the HTML of whole page
//						        var oldPage = document.body.innerHTML;
//						        //Reset the page's HTML with div's HTML only
//						        var divElements = 
//						        document.body.innerHTML = divToPrint.html();
//						          "<html><head><title></title></head><body>" + 
//						          divElements + "</body>";
//						        //Print Page
//						        window.print();
//						        //Restore orignal HTML
//						        document.body.innerHTML = oldPage;
//							   window.print();
							   var htmlCode = "<html><head><title></title></head><body><table border='1' style='border:1px; border-collapse: collapse;border: 1px solid black;'>" + divToPrint.html() + "</table></body></html>";
							   newWin.document.write(htmlCode);
							   newWin.print();
							   newWin.close();
						   }
						   
						   
						   $scope.readCSV = function(fileContent) {
								var lines = [];
								var numOfRecords = fileContent.length - 1;
								$scope.renewalServices.splice(0,$scope.noOfRecords);
								for ( var i = 0; i < fileContent.length; i++) {
									var data = fileContent[i].split(',');
									lines.push(data);
								}
							   
								for(var i=0;i<lines.length;i++){
										if("Category (Max 50 Charactors)" ==  lines[i][0]){
											continue;
										}
										var item = {categoryId : lines[i][0],
											subCategoryId : lines[i][1],
											entity : lines[i][2],
											description : lines[i][3],
											model : lines[i][4],
											amount : lines[i][5],
											gst : lines[i][6],
											supplierName : lines[i][7],
											supplierEmail : lines[i][8],
											supplierContact : lines[i][9],
											sendMailToSupplier : lines[i][10],
											location : lines[i][11],
											contactNumber : lines[i][12],
											purchaseDate : lines[i][13],
											expiryDate : lines[i][14],
											reminder : lines[i][15],
											escalationEmail : lines[i][16],
											setEscalation : lines[i][17],
											startEscalation : lines[i][18],	
											fileName : ''
										};
										$scope.renewalServices.push(item);
									
								}
								
							}

							$scope.processData = function(allText) {
								// split content based on new line
								var allTextLines = allText.split(/\r\n|\n/);
								var headers = allTextLines[0].split(',');
								var lines = [];

								for ( var i = 0; i < allTextLines.length; i++) {
									// split content based on comma
									var data = allTextLines[i].split(',');
									if (data.length == headers.length) {
										var tarr = [];
										for ( var j = 0; j < headers.length; j++) {
											tarr.push(data[j]);
										}
										lines.push(tarr);
									}
								}
								$scope.data = lines;
							};
							
							$scope.deleteReport = function(reportService,reportId,category,subCat){
								
								if($scope.deletePermission == "NO"){
									var message = "You don't have permission to delete records!";
									alertService
									.showFail(
											'reportAlertMsg',
											message);
									return;
								}
								
								var r = confirm("Do you want to delete this report?");
								    if (r == true) {
								    	var data = {
												'task' : 'deletereport',
												'recordId' : reportId,
												'category' : category,
												'subCat' : subCat
											};

											var config = {
												headers : {
													'Content-Type' : 'application/x-www-form-urlencoded;charset=utf-8;'
												}
											};

											try {

												$http
														.post("../controller/UserController.php",
																data, config)
														.success(
																function(data, status,
																		headers, config) {
																	try {
																	
																		if (data == "success" || data == "successsuccess") {
																			
																			var index=$scope.renewalServicesList.indexOf(reportService);
																			$scope.renewalServicesList.splice(index,1);

																			$('#reportTableRow_'+reportId).remove();
																			
																			var message = "Record deleted successfuly!";
																			alertService
																			.showSuccess(
																					'reportAlertMsg',
																					message);
																			
																			//$scope.userProfileDetail = data.userInfo;

																		}
																	} catch (e) {
																		console
																				.log(e.message);
																	}

																}).error(
																function(data, status,
																		header, config) {
																	
																});
											} catch (e) {
												console.log(e.message);
											}
								    } else {
								        
								    }
								
							}
							$scope.deleteEmailAccount = function(renewalEmailAccount,emailAccountId){
								
								var r = confirm("Do you really want to remove this email account?");
								    if (r == true) {
								    	var data = {
												'task' : 'deleteEmailAccount',
												'emailAccountId' : emailAccountId
											};

											var config = {
												headers : {
													'Content-Type' : 'application/x-www-form-urlencoded;charset=utf-8;'
												}
											};

											try {

												$http
														.post("../controller/UserController.php",
																data, config)
														.success(
																function(data, status,
																		headers, config) {
																	try {
																		if (data == "success" || data == "successsuccess") {
																			
																			var index=$scope.renewalEmailAccountsList.indexOf(renewalEmailAccount);
																			$scope.renewalEmailAccountsList.splice(index,1);

																			$('#emailAccountTableRow_'+emailAccountId).remove();
																			
																			var message = "Email account removed successfuly!";
																			alertService
																			.showSuccess(
																					'emailAccountAlertMsg',
																					message);
																			
																			//$scope.userProfileDetail = data.userInfo;

																		}
																	} catch (e) {
																		console
																				.log(e.message);
																	}

																}).error(
																function(data, status,
																		header, config) {
																	
																});
											} catch (e) {
												console.log(e.message);
											}
								    } else {
								        
								    }
								
							}
							$scope.getEmployeeList = function(){
								
								    	var data = {
												'task' : 'getEmployeeList'

											};

											var config = {
												headers : {
													'Content-Type' : 'application/x-www-form-urlencoded;charset=utf-8;'
												}
											};

											try {

												$http
														.post("../controller/UserController.php",
																data, config)
														.success(
																function(data, status,
																		headers, config) {
																	try {
																		if (data.message == "success") {

																			$scope.employeeList = data.employees;

																		}
																	} catch (e) {
																		console
																				.log(e.message);
																	}


																}).error(
																function(data, status,
																		header, config) {
																	
																});
											} catch (e) {
												console.log(e.message);
											}
								   
								
							}
							
							$scope.clearRegisterForm = function() {
								// $scope.signupFormInfo={};
								$scope.signupFormInfo.pin = '';
								$scope.signupFormInfo.countryName = '';
								$scope.signupFormInfo.mobileNo = '';
								$scope.signupFormInfo.confirmpassword = '';
								$scope.signupFormInfo.userpassword = '';
								$scope.signupFormInfo.name = '';
								$scope.signupFormInfo.email = '';

							}
							$scope.empsignupFormInfo={};
							$scope.registercompanyuser = function() {

								waitingDialog.show();

								var data = {
									'signUpData' : $scope.empsignupFormInfo,
//									'companyno' : $scope.companyno,
									'task' : 'registercompanyuser'
								};
								// alert("data::"+data );
								var config = {
									headers : {
										'Content-Type' : 'application/x-www-form-urlencoded;charset=utf-8;'
									}
								};

								try {
									// alert("dotFolderLevel::"+dotFolderLevel);
									// waitingDialog.show();
									$http
											.post("../controller/UserController.php",
													data, config)
											.success(
													function(data, status,
															headers, config) {
														waitingDialog.hide();

														if (data == "failed") {
															$scope.validate = true;
															var message = "Error : Opps something went wrong. Please contact helpdesk for details.";
															alertService
																	.showFail(
																			'signupalert',
																			message);

														} else if (data == "success"
																|| data == "SUCCESSsuccess"
																|| data == "successsuccess") {
															// $('#signupbox')
															// .css(
															// "display",
															// "none");
															// $('#loginbox').css(
															// "display",
															// "block");
//															$('#loginbox')
//																	.toggle();
															$('#employeetable').show();
															$('#signupbox')
																	.hide();
															$scope.getEmployeeList();

															var message = "Congratulations! New employee is registered successfully. "
															$scope.validate = true;
															alertService
																	.showSuccess(
																			'addemplmsg',
																			message);
														} else if (data == "exist") {
															// alert("in
															// Exist else");
															var message = "Login id is already exist!";
															alertService
																	.showFail(
																			'signupalert',
																			message);
															$scope.validate = true;

														} else {
															$scope.validate = true;
															var message = "Error while Sign Up! Please contact support team!";
															alertService
																	.showFail(
																			'signupalert',
																			message);
														}

													}).error(
													function(data, status,
															header, config) {

														waitingDialog.hide();
													});
								} catch (e) {
									waitingDialog.hide();
									console.log(e.message);
								}
							}
							

						} ]);
app.directive('datepicker', function() {
	return {
		restrict : 'A',
		require : 'ngModel',
		link : function(scope, element, attrs, ngModelCtrl) {
			$(function() {
				element.datepicker({
					dateFormat : 'dd/mm/yyyy',
					onSelect : function(date) {
						ngModelCtrl.$setViewValue(date);
						scope.$apply();
					}
				});
			});
		}
	}
});

app.controller('ImageUploadMultipleCtrl', function($scope) {

	$scope.fileList = [];
	$scope.curFile;
	$scope.ImageProperty = {
		file : ''
	}

	$scope.setFile = function(element) {
		// $scope.fileList = [];
		// get the files
		var files = element.files;
		for (var i = 0; i < files.length; i++) {
			$scope.ImageProperty.file = files[i];

			$scope.fileList.push($scope.ImageProperty);
			$scope.ImageProperty = {};
			$scope.$apply();

		}
	}

});

app.directive('fileReader', function() {
	  return {
	    scope: {
	      fileReader:"="
	    },
	    link: function(scope, element) {
	      $(element).on('change', function(changeEvent) {
	        var files = changeEvent.target.files;
	        if (files.length) {
	          var r = new FileReader();
	          r.onload = function(e) {
	              var contents = e.target.result;
	              scope.$apply(function () {
//	                scope.fileReader = contents;
	            	  
	            	// split content based on new line
						var allTextLines = contents.split(/\r\n|\n/);
					
						scope.fileReader = allTextLines;
	              });
	          };

	          r.readAsText(files[0]);
	        }
	      });
	    }
	  };
	});
