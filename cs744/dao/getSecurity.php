<?php
/**
 * Created by PhpStorm.
 * User: Liu
 * Date: 2016/2/8
 * Time: 23:32
 */
include_once "DBHelper.php";
function getSecurityBySid($sid){
    $sql="select * from security where sid='".$sid."'";
    return mysql_query($sql);
}
?>
