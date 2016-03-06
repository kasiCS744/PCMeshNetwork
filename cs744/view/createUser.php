<!DOCTYPE html>
<html>
<link href="../css/securityQuestion.css" rel="stylesheet">
<head> <?php include_once "viewStructureHead.php"; ?></head>
<body>
<?php
session_start();
$uid=$_SESSION['uid'];
include_once "../dao/getUser.php";
$firstName="";
$lastName="";
if($uid!=null){
    $user=mysql_fetch_array(getUserByUid($uid));
    $firstName=$user['firstName'];
    $lastName=$user['lastName'];
}
?>
<?php include_once "viewStructureBody.php";?>
<br>
<br><br><br><br><br>

<div class="container" ng-app="myApp" ng-controller="customersCtrl" style="width:600px;background:#fff;">
	
	<h2 class="col-md-10">Create User</h3></br></br></br>
		<div style="margin-left: 20px;margin-top: 20px;">
			<div style="margin-bottom:20px;">			
			<label class="col-md-4">User Name: </label>
			<input type="text" ng-model="userName">
		</div>
		<div style="margin-bottom:20px;">
			<label class="col-md-4">First Name: </label>
			<input type="text" ng-model="firstName">
		</div>
		<div style="margin-bottom:20px;">
			<label class="col-md-4">Last Name: </label>
			<input type="text" ng-model="lastName">
		</div>
		<div style="margin-bottom:20px;">
			<label class="col-md-4">Password: </label>
			<input type="password" ng-model="password">			
		</div>
		<div style="margin-bottom:20px;">
			<label class="col-md-4">Confirm Password: </label>
			<input type="password" ng-model="confirmPassword">	
			<label style="color:red;" ng-show="checkTwoPassword()">password not match</label>		
		</div>	
		<div>
			<button type="button" class="btn btn-success col-md-3" 
				style="margin-top:50px;margin-bottom:50px;" ng-click="createUser()" 
				ng-disabled="checkButton()">Save</button>
			<label class="col-md-2"></label>
			<button type="button" class="btn btn-danger col-md-3" 
				style="margin-top:50px;margin-bottom:50px;" ng-click="cancel()">Cancel</button>
		</div>
		</div>
		
	
</div>



<script>
var app = angular.module('myApp', []);
app.controller('customersCtrl', function($scope, $http, $location, $window) {	

	$scope.checkButton = function(){
		if($scope.userName == "" || $scope.userName == null){
			return true;
		}
		if($scope.firstName == "" || $scope.firstName == null){
			return true;
		}
		if($scope.lastName == "" || $scope.lastName == null){
			return true;
		}
		if($scope.password == "" || $scope.password == null){
			return true;
		}
		if($scope.confirmPassword == "" || $scope.confirmPassword == null){
			return true;
		}
		return false;
	}

	$scope.createUser = function(){

		var userNameRE = '^[A-Z][A-z0-9]{5,}$';
        if($scope.userName.match(userNameRE)){
        	var passwordRE = "^[A-z0-9~!@#$%^&*?]{5,}";
	 	if($scope.password.match(passwordRE)){
	 		$.ajax({
                        type: 'POST',
                        url: '../ser/createUser.php',
                        data: {
                        	"userName" : $scope.userName,
                        	"firstName" : $scope.firstName,
                        	"lastName" : $scope.lastName,
                            "password" : $scope.password
                        },
                        success: function(response) {                     	
                             if(response == "0"){
                             	alert("create user successfully");
                                window.location.href = "Main.php";
                             }else if(response == "1"){
                             	alert("userName has already exist!");
                             }
                         }
                    });  
	 	}else{
	 		alert("invalid password!");
	 	}
        }else{
        	alert("invalid userName!");
        }
		
	}
	$scope.cancel = function(){
		window.location.href = "Main.php";
	}

	$scope.checkTwoPassword = function(){
		if($scope.password == $scope.confirmPassword){
			return false;
		}
		return true;
	}

});
 

</script>

</body>
</html>