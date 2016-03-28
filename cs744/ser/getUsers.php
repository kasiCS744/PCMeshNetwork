<?php
/**
 * Created by ChenguangBai
 * Date: 2016/3/3
 */


include_once "../dao/DBHelper.php";
include_once "../dao/getUsers.php";

$page = $_GET['page'];
$maxSize = $_GET['maxSize'];

$result = getUsers($page-1, $maxSize);
$users = array();

while ($row = mysql_fetch_array($result)) {
	$temp = array();
	$temp['uid'] = $row['uid'];
	$temp['userName'] = $row['username'];
	$temp['firstName'] = $row['firstName'];
	$temp['lastName'] = $row['lastName'];

	array_push($users, $temp);
}
echo json_encode($users);

?>