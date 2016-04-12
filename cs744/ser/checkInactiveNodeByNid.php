<?php
/**
 * Created by PhpStorm.
 * User: Liu
 * Date: 2016/3/10
 * Time: 15:20
 */
include_once "../dao/getNode.php";
$nid=$_POST['nid'];
$result=getInactiveNodes();
$list=array();
while($row=mysql_fetch_array($result)){
    array_push($list,$row['nid']);
}
if(in_array($nid,$list)){
    echo "inactive";
}else{
    echo "active";
}
?>