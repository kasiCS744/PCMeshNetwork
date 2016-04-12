<?php
/**
 * Created by PhpStorm.
 * User: Liu
 * Date: 2016/2/9
 * Time: 2:33
 */
include_once "DBHelper.php";
include_once "getNode.php";
function insertLink($nid1,$nid2){
    $sql="insert into link VALUES ('".$nid1."','".$nid2."')";
    mysql_query($sql);
}
function linkExists($nid1, $nid2)  {
    $sql="select count(*) from link where (nid1='".$nid1."' and nid2='".$nid2."') or (nid1='".$nid2."' and nid2='".$nid1."')";
    return mysql_fetch_array(mysql_query($sql))[0];
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
function deleteLinksByNid($nid){
    $sql="delete from link where nid1='".$nid."' or nid2='".$nid."'";
    mysql_query($sql);
}
function getLinksArrayByNid($nid){
    $sql="select nid2 from link where nid1='".$nid."'";
    $linkList=array();
    $result=mysql_query($sql);
    while($row=mysql_fetch_array($result)){

            array_push($linkList, $row['nid2']);
    }
    $sql="select nid1 from link where nid2='".$nid."'";
    $result=mysql_query($sql);
    while($row=mysql_fetch_array($result)){
        array_push($linkList,$row['nid1']);
    }
    return $linkList;
}
function getActiveLinksArrayByNid($nid){
    $sql="select nid2 from link where nid1='".$nid."'";
    $linkList=array();
    $result=mysql_query($sql);
    while($row=mysql_fetch_array($result)){
        if(checkNodeisActiveByNid($row['nid2'])) {
            array_push($linkList, $row['nid2']);
        }
    }
    $sql="select nid1 from link where nid2='".$nid."'";
    $result=mysql_query($sql);
    while($row=mysql_fetch_array($result)){
        if(checkNodeisActiveByNid($row['nid1'])) {
            array_push($linkList,$row['nid1']);
        }
    }
    return $linkList;
}
?>