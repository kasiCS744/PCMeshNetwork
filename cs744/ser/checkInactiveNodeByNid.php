<?php
/**
 * Created by PhpStorm.
 * User: Liu
 * Date: 2016/3/10
 * Time: 15:20
 */
include_once "../dao/getNode.php";
include_once "../dao/getLink.php";
$nid=$_POST['nid'];
$startNid=$_POST['from'];
//$nid=1;
$node=getNodeByNid($nid);
if($node==null||$node==Array()){
    echo "inactive";
}else{
$result=getInactiveNodes();
$list=array();
while($row=mysql_fetch_array($result)){
    array_push($list,$row['nid']);
}
if(in_array($nid,$list)){
    echo "inactive";
}else{
    if($nid!=$startNid) {
        if (linkExists($startNid, $nid)) {
            echo "active";
        } else {
            echo "inactive";
        }
    }else{
        echo "active";
    }
}
}
?>