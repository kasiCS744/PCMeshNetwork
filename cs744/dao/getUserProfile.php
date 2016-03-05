<?php
/**
 * Created by Chenguang Bai.
 * Date: 2016/2/27
 */
include_once "DBHelper.php";
include_once "getUser.php";

session_start();
$uid = $_SESSION['uid'];
$result = getUserByUid($uid);

echo json_encode(mysql_fetch_array($result));
?>