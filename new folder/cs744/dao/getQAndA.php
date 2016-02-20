<?php
/**
 * Created by ChenguangBai
 * Date: 2016/2/18
 * Time: 23:32
 */

include_once "DBHelper.php";
include_once "getUser_Security.php";
include_once "getSecurity.php";

session_start();
$uid = $_SESSION['uid'];

$user_security = getUser_SecurityByUid($uid);

$data = array();
while($row = mysql_fetch_array($user_security)){
	$answer = $row['answer'];
	$sid = $row['sid'];
	$security = getSecurityBySid($sid);
	$securityRow = mysql_fetch_array($security);
	$question = $securityRow['question'];

	$temp = array();
	$temp['sid'] = $sid;
	$temp['question'] = $question;
	$temp['answer'] = $answer;
	array_push($data, $temp);
}
$sql = "select * from security where sid!='".$data[0]['sid']."' 
	and sid!='".$data[1]['sid']."' and sid!='".$data[2]['sid']."'";

$res = mysql_query($sql);

while($row = mysql_fetch_array($res)){
	$temp = array();
	$temp['sid'] = $row['sid'];
	$temp['question'] = $row['question'];
	$temp['answer'] = "";
	array_push($data, $temp);
}
	
echo json_encode($data);

?>
