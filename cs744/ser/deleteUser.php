<?php
/**
 * Created by ChenguangBai
 * Date: 2016/3/3
 */
include_once "../dao/DBHelper.php";
include_once "../dao/deleteUser.php";

$uid = $_POST['uid'];

$result = deleteUser($uid);

echo 0;

?>