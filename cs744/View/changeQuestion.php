<!DOCTYPE html>
<html>
<script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.4.8/angular.min.js"></script>
<!--<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
<!--<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>-->
<link href="../css/securityQuestion.css" rel="stylesheet">
<script type="text/javascript" src="../js/vis.js"></script>
<link href="css/vis.css" rel="stylesheet" type="text/css" />
<link href="../css/bootstrap.css" rel="stylesheet">
<link href="../css/loginScreen.css" rel="stylesheet">
<link href="../css/nodeDisplay.css" rel="stylesheet">
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
<br><br>

<div class="container" id="firstSmallContainer" align="center">
    <div class="containers" ng-app="myApp" ng-controller="customersCtrl">

        <h3>Change Security Questions</h3></br>

        <div>
            <div class="div_qanda" ng-repeat="val in values">
                <label class="lab_question col-md-8">{{ val.question }}</label>
                <input type="text" class="col-md-3" ng-model="val.answer">
            </div>
            <div class="div_button">
                <button type="button" class="btn btn-success" ng-click="saveQuestions()">Save</button>
                <button type="button" class="btn btn-danger" ng-click="cancel()">Cancel</button>
            </div>
        </div>
    </div>
</div>



<script>
    var app = angular.module('myApp', []);
    app.controller('customersCtrl', function($scope, $http, $location, $window) {

        $scope.hasSelected = [];
        $scope.disabled = false;

        $scope.saveQuestions = function(){
            angular.forEach($scope.values, function(val){
                if(val.answer != null && val.answer != ""){
                    $scope.hasSelected.push(val);
                }
            });
            console.log("size: "+$scope.hasSelected.length);

            if($scope.hasSelected.length != 3){
                alert("you must choose 3 questions");
                $scope.hasSelected = [];
            }else{
                $.ajax({
                    type: 'POST',
                    url: '../ser/updateQuestions.php',
                    data: {'values': $scope.hasSelected},
                    success: function(msg) {
                        alert("success");
                        window.location.href = "Main.php";
                    }
                });
            };

        }

        $scope.cancel = function(){
            window.location.href = "Main.php";
        }

        $http.get("../dao/getQAndA.php")
            .then(function (response) {
                //  alert(response.data);
                $scope.values = response.data;
                console.log($scope.values);
            });
    });


</script>

</body>
</html>