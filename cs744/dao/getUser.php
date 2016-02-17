<?php
/**
 * Created by PhpStorm.
 * User: Liu
 * Date: 2016/2/8
 * Time: 23:32
 */
include_once "DBHelper.php";
function getUserByUid($uid){
    $sql="select * from user where uid='".$uid."'";
    return mysql_query($sql);
}
?>