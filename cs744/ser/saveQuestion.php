<?php
/**
 * Created by ChenguangBai
 * Date: 2016/2/14
 */
include_once "../dao/DBHelper.php";

$datas = $_POST['values'];
session_start();
$uid = $_SESSION['uid'];

foreach ($datas as $val) {
    $sql = "insert into user_security (uid, sid, answer) values 
        ('".$uid."','".$val['sid']."','".$val['answer']."')";
    $result = mysql_query($sql);
    mysql_fetch_array($result);
}

//update state of user
$sql = "update user set state=1 where uid='".$uid."'";
mysql_fetch_array(mysql_query($sql));

echo "success";

?>