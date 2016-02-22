<?php
/**
 * Created by PhpStorm.
 * User: Liu
 * Date: 2016/2/18
 * Time: 23:51
 */
include_once "../dao/getMessage.php";
$result=getAllMessages();
$returnList=array();
while($row=mysql_fetch_array($result)){
    $list=array();
    $list['nid']=$row['nid'];
    $list['destination']=$row['destination'];
    $list['messageContext']=$row['messageContext'];
    $list['state']=$row['state'];
    array_push($returnList,$list);
}
echo json_encode($returnList);
?>