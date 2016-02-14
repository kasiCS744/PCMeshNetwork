<?php
/**
 * Created by PhpStorm.
 * User: Liu
 * Date: 2016/2/9
 * Time: 1:52
 */
include_once "DBHelper.php";
function insertNode($isConnector,$pid,$x,$y){
    $sql="insert into node(isConnector,pid,x,y) VALUES ('".$isConnector."','".$pid."','".$x."','".$y."')";
   // echo $sql;
    mysql_query($sql);
}
function getMaxNid(){
    $sql="select Max(nid) from node";
    $result=mysql_query($sql);
    return mysql_fetch_array($result)[0];
}
function getAllNodes(){
    $sql="select * from node";
    return mysql_query($sql);
}
function getNodeByNid($nid){
    $sql="select * from node where nid='".$nid."'";
    //echo $sql;
    return mysql_fetch_array(mysql_query($sql));
}
function getNodesByPid($pid){
    $sql="select * from node where pid='".$pid."'";
    //echo $sql;
    return mysql_query($sql);
}
function getCountByPid($pid){
    $sql="select count(*) from node where pid='".$pid."'";
    //echo $sql;
    return mysql_fetch_array(mysql_query($sql))[0];
}
function getConnectorByPid($pid){
    $sql="select * from node where pid='".$pid."' and isConnector='1'";
    return  mysql_fetch_array(mysql_query($sql));
}
function checkNodeisActiveByNid($nid){
    $sql="select isActive from node where nid='".$nid."'";
    if(mysql_fetch_array( mysql_query($sql))[0]=="yes"){
        return true;
    }else{
        return false;
    }
}
function getPidByNid($nid){
    $sql="select pid from node where nid='".$nid."'";
    return mysql_fetch_array(mysql_query($sql))[0];
}
function deleteNodesByNid($nid){
    $sql="delete from node where nid='".$nid."'";
    mysql_query($sql);

}
?>