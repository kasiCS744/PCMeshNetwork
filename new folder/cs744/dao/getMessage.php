<?php
/**
 * Created by PhpStorm.
 * User: Liu
 * Date: 2016/2/13
 * Time: 22:45
 */
include_once "DBHelper.php";
function insertMessage($nid,$destination,$messageContext,$state){
    $sql="insert into message(nid,destination,messageContext,state)VALUES ('".$nid."','".$destination."','".$messageContext."','".$state."')";
    mysql_query($sql);
}
function getAllMessages(){
    $sql="select * from message";
    return mysql_query($sql);
}
?>