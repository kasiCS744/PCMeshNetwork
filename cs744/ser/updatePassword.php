<?php
/**
 * Created by ChenguangBai
 * Date: 2016/2/27
 */
include_once "../dao/DBHelper.php";

$password = $_POST['password'];
session_start();
$uid = $_SESSION['uid'];

$sql = "update user set password='".$password."' where uid='".$uid."'";
mysql_query($sql);

echo "success";
?>