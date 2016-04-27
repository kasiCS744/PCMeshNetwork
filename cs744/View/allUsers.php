<!DOCTYPE html>
<html>
<script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.4.8/angular.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<script src="http://angular-ui.github.io/bootstrap/ui-bootstrap-tpls-1.2.1.js"></script>
<link href="../css/securityQuestion.css" rel="stylesheet">
<link href="../css/loginScreen.css" rel="stylesheet">
<link href="../css/bootstrap.css" rel="stylesheet">
<?php session_start();
	$uid=$_SESSION['uid']; 
	include_once "viewStructureBody.php";
?>
<br>
<br><br><br><br><br>

<div class="container" ng-app="myApp" ng-controller="customersCtrl" style="width:600px;background:#fff;">
	
	<h2 class="col-md-10">Users</h3></br></br></br>
	<table class="table table-striped">
			<thead>
			<tr>
				<th>user name</th>
				<th>uid</th>
				<th>first name</th>
				<th>last name</th> 
				<th>action</th>
			</tr>
			</thead>
			<tbody>
			<tr ng-repeat="user in users">
				<td><a ng-click="userInfo(user)"  style="cursor:pointer;height:24px;">
					{{user.userName}}</a></td>
				<td>{{user.uid}}</td>
				<td>{{user.firstName}}</td>
				<td>{{user.lastName}}</td>
				<td>				
				<button type="button" class="btn btn-danger" ng-click="deleteUser(user)">Delete</button>
				</td>
			</tr>
			</tbody>
		</table> 
		<div>
			<uib-pagination total-items="totalItems" ng-model="currentPage" 
				max-size="maxSize" class="pagination-sm" boundary-links="true" 
				num-pages="numPages" items-per-page="maxSize" ng-change="pageChanged()">
			</uib-pagination>	
		</div>			
</div>



<script>
var app = angular.module('myApp', ['ui.bootstrap']);
app.controller('customersCtrl', function($scope, $http, $location, $window) {			

  	$scope.currentPage = 2;
	$scope.maxSize = 8;  	
  	$scope.numPages = 0;

  $scope.pageChanged = function() {
    $scope.getUsers();
  };

	$scope.deleteUser = function(user){
		console.log("delete user: "+user.uid);
		if(confirm("Are you sure you would like to delete " + user.userName + "?"))  {
			$.ajax({
                type: 'post',
                url: '../ser/deleteUser.php',
                data: {
                    "uid" : user.uid
                },
                success: function(response) {                           
                    if(response == "0"){
                        alert("delete user successfully!"); 
                        $scope.getCount();
						$scope.getUsers();                              
                    }else{
                        alert("delete user failed!");
                    }
                }
            }); 
		}
	}

	$scope.getUsers = function(){		
		$http({
    		url: "../ser/getUsers.php", 
    		method: "GET",
    		params: {
    			page: $scope.currentPage,
    			maxSize : $scope.maxSize
   			}})
		.then(function (response) {
		   $scope.users = response.data;	      		   	
	   	});
	}	
	
	$scope.getCount = function(){
  		$http.get("../ser/getCount.php")
   		.then(function (response) {   			
		   $scope.totalItems = response.data;		  		      		   	
		   console.log("response: "+$scope.totalItems);		   
	   	});
  	}

  	$scope.getPages = function(){
  		$scope.numPages = Math.ceil($scope.totalItems/$scope.maxSize);
  		return $scope.numPages;
  	}

	$scope.getCount();	
	$scope.getUsers();			
});

</script>
</body>
</html>