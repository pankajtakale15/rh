
	<nav class="navbar navbar-default navbar-fixed-top" style="height: 100px; background-color: #fff" >
		<div class="container">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse"
					data-target="#myNavbar">
					<span class="icon-bar"></span> <span class="icon-bar"></span> <span
						class="icon-bar"></span>
				</button>
		<!--  <a class="navbar-brand" href="#headerId" style="padding: 2px 15px;
			 margin-left: -100px;"><img src="../img/RenewalHelp_Final_logo.png" height="100px" width="300px"></a> -->	

				
			</div>
			
			 <div class="collapse navbar-collapse" id="myNavbar" style="position: fixed; margin-left: 100px;">
			
				<!--  <ul class="nav navbar-nav navbar-right">
					<li><a href="#about" title="About">ABOUT</a></li>
					<li><a href="#services" title="Services">SERVICES</a></li>
					<li><a href="#product" title="Product">PRODUCT</a></li>
					<li><a href="#pricing" title="Pricing">PRICING</a></li>
					<li><a href="#contact" title="Contact us">CONTACT</a></li>
				</ul>-->
			</div>
			<div><li>
			 <ul class="nav navbar-nav navbar-right" style="margin-top:20px;">
			  <!--  data-amount="250000" -->
			  <li style="padding-left:10px;"> <form method="POST">
<!-- Note that the amount is in paise = 50 INR -->
<!--
<script
    src="https://checkout.razorpay.com/v1/checkout.js"
    data-key="rzp_live_l9ScRfFcpQDQ7i"
    data-display_currency= ""
    data-amount= ""
    data-buttontext="Buy Now"
    data-name="Renewal HELP"
    data-description="Buy Now"
    data-image="../img/RenewalHelp_Final_logo.png"
    data-prefill.name="<?php echo $userObject1->name?>"
    data-prefill.email="<?php echo $userObject1->loginId?>"
    data-theme.color="#F37254"
></script>
<input type="hidden" value="Hidden Element" name="hidden"> -->
 </form>
        <li style="padding-left:10px;"><a href="#" ng-click="logout();"><span class="glyphicon glyphicon-log-out" style="color:blue"></span><span style="color:blue"><b> Logout</b></span></a></li>
      </ul>
    </div>
		</div>
	</nav>