<!DOCTYPE html>
<html>
	<script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.4.8/angular.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
<link href="../css/securityQuestion.css" rel="stylesheet">
<link href="../css/bootstrap.css" rel="stylesheet">
<link href="../css/loginScreen.css" rel="stylesheet">
<head> <?php include_once "viewStructureHead.php"; ?></head>
<body>
<?php
session_start();
$uid=$_SESSION['uid'];
include_once "viewStructureBody.php";?>
<br>
<br><br><br><br><br>

<div class="container" ng-app="myApp" ng-controller="customersCtrl" style="width:600px;background:#fff;">
	
	<h2 class="col-md-10">Profile</h3></br></br></br>
	
		<div style="margin-bottom:20px;">
			<label class="col-md-4">User Name: </label>
			<input type="text" readonly="true" value="{{user.username}}">
		</div>
		<div style="margin-bottom:20px;">
			<label class="col-md-4">First Name: </label>
			<input type="text" readonly="true" value="{{user.firstName}}">
		</div>
		<div style="margin-bottom:20px;">
			<label class="col-md-4">Last Name: </label>
			<input type="text" readonly="true" value="{{user.lastName}}">
		</div>
		<div style="margin-bottom:20px;" name="passwordData">
			<label class="col-md-4">Password: </label>
			<input type="password" ng-model="password" name="data" required>			
		</div>
		<div style="margin-bottom:20px;">
			<label class="col-md-4">New Password: </label>
			<input type="password" ng-model="newPassword">	
		</div>
		<div>
			<label class="col-md-4">Confirm Password: </label>
			<input type="password" ng-model="confirmPassword">
			<label style="color:red;" ng-show="checkTwoPassword()">password not match</label>
		</div>
		
	
		<div>
			<button type="button" class="btn btn-success col-md-3" 
				style="margin-top:50px;margin-bottom:50px;" ng-click="saveProfile()" 
				ng-disabled="checkButton()">Save</button>
			<label class="col-md-2"></label>
			<button type="button" class="btn btn-danger col-md-3" 
				style="margin-top:50px;margin-bottom:50px;" ng-click="cancel()">Cancel</button>
		</div>
	
</div>



<script>
var app = angular.module('myApp', []);
app.controller('customersCtrl', function($scope, $http, $location, $window) {	
	
	$scope.password = "";
	$scope.newPassword = ""
	$scope.confirmPassword = "";


	$scope.checkButton = function(){
		if($scope.user.username == "admin"){
			return true;
		}
		if($scope.password != "" && $scope.password != null){
			if($scope.newPassword != "" && $scope.newPassword != null && !$scope.checkTwoPassword()){
				return false;
			}
		}
		return true;
	}

	$scope.checkTwoPassword = function(){
		if($scope.newPassword == $scope.confirmPassword){
			return false;
		}
		return true;
	}

	$scope.saveProfile = function(){
		if($scope.user.password == $scope.password){
			if($scope.checkNewPassword()){
				$.ajax({
                        type: 'POST',
                        url: '../ser/updatePassword.php',
                        data: {
                            "password":$scope.newPassword
                        },
                        success: function(response) {                         	
                             if(response == "success"){
                             	alert(response);
                                window.location.href = "Main.php";
                             }
                         }
                    });     
			}else{
				alert("new password is invalid!");
			}
		}else{
			alert("old password is wrong!");
		}			
	}

	$scope.checkNewPassword = function(){
		console.log("com in check")
		var passwordRE = "^[A-z0-9~!@#$%^&*?]{5,}";
		if($scope.newPassword.match(passwordRE)){
			if($scope.newPassword == $scope.confirmPassword){
				return true;	
			}			
		}
		return false;
	}

	$scope.cancel = function(){
		window.location.href = "Main.php";
	}
	
   	$http.get("../dao/getUserProfile.php")
   	.then(function (response) {
		   $scope.user = response.data;			 
	   	});
});
 

</script>

</body>
</html>