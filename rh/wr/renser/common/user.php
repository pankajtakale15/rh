<?php
class User {
	
	var $userNo;
	var $userType;
	var $name;
	var $imgDir;
	var $loggedin;
	//var $profilePic;
	
	function User($userNo, $userType,$name,$imgDir,$loggedin)
	{
		$this->userNo = $userNo;
		$this->userType = $userType;
		$this->name = $name;
		$this->loggedin = $loggedin;
		$this->imgDir = $imgDir;
		//$this->profilePic = $profilePic;
	}
	
	
	
}