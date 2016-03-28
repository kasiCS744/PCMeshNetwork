<?php
/**
 * Created by Chenguangbai
 * Date: 2016/2/28
 */

include_once "DBHelper.php";
function createUser($userName, $firstName, $lastName, $password){
	$sql = "insert into user (username, firstName, lastName, password) values 
		('".$userName."','".$firstName."','".$lastName."','".$password."')";
    return mysql_query($sql);
}

?>