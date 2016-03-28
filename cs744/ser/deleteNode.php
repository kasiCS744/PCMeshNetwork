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
function delete($nid){
    $row=getNodeByNid($nid);
    // $row['isActive']="no";

    //delete the whole pattern
    $list=array();
    $list[0]=$row['nid'];
    iniRecordList($list);

    if($row['isConnector'] == 2){
        return "domainFail";
    }else if($row['isConnector']==1){
        if(countPatternNodes($row['pid'])>1){
            return "patternFail";
        }

        $neighbourList=findNodeNeighbour($row['nid']);

        $did = getDidByNid($nid);
        $domainId = getDomainByDid($did)['nid'];

        if(count($neighbourList) > 1){
            for($i=0;$i<count($neighbourList);$i++){
                if($neighbourList[$i]!=$domainId){
                    if(count(sendMessageIgnoreInactive($neighbourList[$i],$domainId,$list))==0){
                        return "fail";
                    }
                }
            }
            deleteNodesByNid($row['nid']);
            deleteLinksByNid($row['nid']);
            return "connectorSuccess";
        }else{
            //return "delete domain node";
            deleteNodesByNid($domainId);
            deleteLinksByNid($domainId);
            deleteNodesByNid($row['nid']);
            deleteLinksByNid($row['nid']);
            return $domainId;
        }
//        deleteNodesByNid($row['nid']);
//        deleteLinksByNid($row['nid']);

//        return "connectorSuccess";
    }else{

        $neighbourList=findNodeNeighbour($row['nid']);
        $pid=getPidByNid($nid);
        //  echo $pid;
        $connectorId=getConnectorByPid($pid)['nid'];
        // echo $connectorId;
        for($i=0;$i<count($neighbourList);$i++){
            // echo $neighbourList[$i];
            if($neighbourList[$i]==$connectorId){

            }else{
                if(count(sendMessageIgnoreInactive($neighbourList[$i],$connectorId,$list))==0){
                    return "fail";
                }
            }

        }
        deleteLinksByNid($row['nid']);
        deleteNodesByNid($row['nid']);
        return "normalSuccess";

    }
}
//function delete($nid){
//    $row=getNodeByNid($nid);
//   // $row['isActive']="no";
//
//        //delete the whole pattern
//        $list=array();
//        $list[0]=$row['nid'];
//        iniRecordList($list);
//    if($row['isConnector']==1){
//       if(countPatternNodes($row['pid'])>1){
//           return "patternFail";
//       }
//   $neighbourList=findNodeNeighbour($row['nid']);
//        foreach($neighbourList as $key=>$value){
//            if(!isConnector($value)){
//                unset($neighbourList[$key]);
//            }
//        }
//        $newNeighbourList=array();
//        foreach($neighbourList as $value){
//            array_push($newNeighbourList,$value);
//        }
//        //print_r($newNeighbourList);
//        //check after deleting this node,can the other node still meaningful
//        //if one if fail then return fail.
//        //else do the delete operations
//        for($i=1;$i<count($newNeighbourList);$i++){
//            if(count(sendMessage($newNeighbourList[0],$newNeighbourList[$i],$list))==0){
//                return "fail";
//            }
//        }
//        //do delete operation
//        deletePatternByConnectorId($nid);
//        return "connectorSuccess";
//   // print_r($newNeighbourList);
//    }else{
//
//        $neighbourList=findNodeNeighbour($row['nid']);
//        //print_r($neighbourList);
//        $pid=getPidByNid($nid);
//      //  echo $pid;
//        $connectorId=getConnectorByPid($pid)['nid'];
//       // echo $connectorId;
//        for($i=0;$i<count($neighbourList);$i++){
//           // echo $neighbourList[$i];
//            if($neighbourList[$i]==$connectorId){
//
//            }else{
//                if(count(sendMessageIgnoreInactive($neighbourList[$i],$connectorId,$list))==0){
//                    return "fail";
//                }
//            }
//
//        }
//        deleteLinksByNid($row['nid']);
//        deleteNodesByNid($row['nid']);
//        return "normalSuccess";
//
//    }
//}
$nid=$_POST['nid'];
 echo delete($nid);
//header("location:../View/test.php");
?>