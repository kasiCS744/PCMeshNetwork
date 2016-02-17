<?php
/**
 * Created by PhpStorm.
 * User: Liu
 * Date: 2016/2/13
 * Time: 22:45
 */
include_once "DBHelper.php";
function insertMessage($nid,$destination,$messageContext){
    $sql="insert into message(nid,destination,messageContext)VALUES ('".$nid."','".$destination."','".$messageContext."')";
    mysql_query($sql);
}
?>