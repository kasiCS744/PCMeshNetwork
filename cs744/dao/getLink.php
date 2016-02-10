<?php
/**
 * Created by PhpStorm.
 * User: Liu
 * Date: 2016/2/9
 * Time: 2:33
 */
include_once "DBHelper.php";
function insertLink($nid1,$nid2){
    $sql="insert into link VALUES ('".$nid1."','".$nid2."')";
    mysql_query($sql);
}
function getAllLinks(){
    $sql="select * from link";
    return mysql_query($sql);
}
function getLinkCountByNid($nid){
    $sql="select count(*) from link where nid1='".$nid."'";
    $count=mysql_fetch_array(mysql_query($sql))[0];
    $sql="select count(*) from link where nid2='".$nid."'";
    $count+=mysql_fetch_array(mysql_query($sql))[0];
    return $count;
}
?>