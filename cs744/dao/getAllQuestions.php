<?php
/**
 * Created by ChenguangBai
 * Date: 2016/2/18
 * Time: 23:32
 */

include_once "DBHelper.php";

session_start();
$uid = $_SESSION['uid'];

$sql="select * from security";
$result = mysql_query($sql);

$questions = array();

while($row = mysql_fetch_array($result)){	
	$val = array();
	$val['sid'] = $row['sid'];
	$val['question'] = $row['question'];	
	array_push($questions, $val);
}
$data = array();
$data['records'] = $questions;
echo json_encode($data);

?>
