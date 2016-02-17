<?php
/**
 * Created by PhpStorm.
 * User: Liu
 * Date: 2016/2/8
 * Time: 23:32
 */
include_once "DBHelper.php";
function getUser_SecurityByUid($uid){
    $sql="select * from user_security where uid='".$uid."'";
    echo $sql;
    return mysql_query($sql);
}
?>