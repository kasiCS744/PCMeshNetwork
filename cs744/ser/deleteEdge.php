<?php
/**
 * Created by PhpStorm.
 * User: Liu
 * Date: 2016/2/12
 * Time: 6:31
 */
include_once "findPath.php";
include_once "../dao/getNode.php";
include_once "../dao/getLink.php";

function isConnector($nid){
    $row=getNodeByNid($nid);
    if($row['isConnector']==1){
        return true;
    }else{
        return false;
    }
}
function deletePatternByConnectorId($nid){
   // echo $nid;
   $pid=getPidByNid($nid);
    $result=getNodesByPid($pid);
    while($row=mysql_fetch_array($result)){
       // echo $row['nid'];
        deleteLinksByNid($row['nid']);
        deleteNodesByNid($row['nid']);
    }
}
function countPatternNodes($pid){
    $result=getNodesByPid($pid);
    $count=0;
    while($row=mysql_fetch_array($result)){
        $count++;
    }
    return $count;
}

function deleteEdge($nid1, $nid2){
    
    $result1 = getNodeByNid($nid1);
    $result2 = getNodeByNid($nid2);

    if($result1['isConnector']+$result2['isConnector']==3){
        return "failed";
    }else{
        $list = array();
    //first delete edge from two nodes
    deleteEdgeBetweenNodes($nid1, $nid2);
    deleteEdgeBetweenNodes($nid2, $nid1);

    //send message from node1 to node2 to check if msg can be sent
    if(count(sendMessageIgnoreInactive($nid1,$nid2,$list))==0){
        addEdgeBetweenNodes($nid1, $nid2);
        return "failed";
    }else{
        return "success";
    } 
    }
    
}

$nid1=$_POST['node1'];
$nid2 = $_POST['node2'];    
// $nid1 = 3;
// $nid2 = 4;

echo deleteEdge($nid1, $nid2);

?>