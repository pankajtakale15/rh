<div class="container">
	<div class="row">
    	<div class="col-sm-10  toppad" style="margin-left: -15px" >
        	<div class="panel panel-default" style="margin-left: 140px;" >
            	<div class="panel-heading">
              		<h5 class="panel-title text-left" style="font-size:18px;">
						<b>Add Email Account</b>	
					</h5>
            	</div>
            	<div class="panel-body">
            		<div class="row text-left" style="margin-left: 20px;">
            			<div class="col-sm-6 text-left">
            				<h3>Add new email account here...</h3>
            			</div>
            			<div class="col-sm-6 text-right">
            				<a href="#" title="Go Back" type="button" id="vMenuEmailAccountsId" ng-click="addActiveClass('vMenuEmailAccountsId');changeScreen('emailaccounts');getRenewalEmailAccounts();resetNewEmailAccount();"> &lt;&lt; Go Back</a>
            			</div>
            		</div>
            		<hr/>
            		<div  id="addEmailAccountAlert" class="alert col-sm-12">
					</div>
              		<div class="row" style="margin-left: 20px;">
              			<div class="col-sm-6 text-center">
              				<input type="text" id="firstName" style="width:100%;" name="firstName" placeholder="Enter first name"/><br><br>
              				<input type="text" id="lastName" style="width:100%;" name="lastName" placeholder="Enter last name"/><br><br>
              				<input type="text" id="designation" style="width:100%;" name="designatio" placeholder="Enter designation"/><br><br>
              				<input type="text" id="emailId" style="width:100%;" name="emailId" placeholder="Enter email address"/><br><br>
              			</div>
              		</div>
              		<hr/>
              		<div class="row">
              			<div class="col-sm-6 text-right">
              				<a href="#" title="Go Back" type="button" id="vMenuEmailAccountsId" ng-click="addActiveClass('vMenuEmailAccountsId');changeScreen('emailaccounts');getRenewalEmailAccounts();resetNewEmailAccount();" class="btn btn-info btn-primary">Cancel</a>
              			</div>
              			<div class="xol-sm-6 text-left">
              				<a href="#" title="Add Email Account" type="button" id="addEmailAccountBtn" ng-click="validateDataAddNewEmailAccount();" class="btn btn-info btn-primary">Submit</a>
              			</div>
              		</div>
            	</div>
          	</div>
        </div>
   	</div>
</div>