<!DOCTYPE html>
<html>
<link href="../css/securityQuestion.css" rel="stylesheet">
<head> <?php include_once "viewStructureHead.php"; ?></head>
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
                <label class="lab_question col-md-9">{{ val.question }}</label>
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
                if($scope.checkAnswer()){
                    $.ajax({
                    type: 'POST',
                    url: '../ser/updateQuestions.php',
                    data: {'values': $scope.hasSelected},
                    success: function(msg) {
                        alert("success");
                        window.location.href = "Main.php";
                    }
                });
                }else{
                   $scope.hasSelected = []; 
                }
                
            };

        }
    $scope.checkAnswer = function(){
        var monthReg = "^[1-9]$|^1[0-2]$";
        var otherReg = "^\\d{4}$";      
        for(var i=0;i<$scope.hasSelected.length;i++){
            var val = $scope.hasSelected[i];
            console.log("answer", val.answer);
            if(val.question.indexOf("month")>=0 && !val.answer.match(monthReg)){
                alert("the month answer must be an integer between 1 to 12");
                return false;               
            }
            if(val.question.indexOf("year")>=0 && !val.answer.match(otherReg)){
                alert("the year answer must be typed as a four digit integer");
                return false;               
            }
            if(val.question.indexOf("phone number")>=0 && !val.answer.match(otherReg)){
                alert("the phone number answer must be a four-digit integer");
                return false;               
            }
        }       
        return true;        
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