<?php
/**
 * Created by ChenguangBai
 * Date: 2016/2/28
 * return data:
 *				0 --> insert user successfully
 *				1 --> has already exist this user name
 */
include_once "../dao/DBHelper.php";
include_once "../dao/getUser.php";
include_once "../dao/createUser.php";
$userName = $_POST['userName'];
$firstName = $_POST['firstName'];
$lastName = $_POST['lastName'];
$password = $_POST['password'];
$user = mysql_fetch_array(getUserByUserName($userName));
if($user == null){
	$result = createUser($userName, $firstName, $lastName, $password);
	if($result){
		echo 0;
	}
}else{
	echo 1;
}
?>