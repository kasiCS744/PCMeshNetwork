<?php

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
          //get all neighbors of this domain, includes one connector node
          //$tempDid = $neighbourList[0];
          //echo "did ".$tempDid."</br>";                  
          $tempNeighbourList = findNodeNeighbour($domainId);          

          $tempCount = 0;
          $srcDid = getDidByNid($domainId);
          for($i=0;$i<count($tempNeighbourList);$i++){
                $tempNode = $tempNeighbourList[$i];  
                $tempDid = getDidByNid($tempNode);                
                if($srcDid == $tempDid){
                    $tempCount++;
                } 
          }          

          if($tempCount>=1){
              deleteNodesByNid($row['nid']);
              deleteLinksByNid($row['nid']);
              return "connectorSuccess";
          }else{
            $domainNeighborList = findNodeNeighbour($domainId);
              $domainNeighborsCount = count($domainNeighborList);
              if($domainNeighborsCount>=2){                
                  $list[0]=$domainId;
                  iniRecordList($list);   
                  for($i=0;$i<$domainNeighborsCount;$i++){
                    for($j=0;$j<$domainNeighborsCount;$j++){
                      if($domainNeighborList[$i] != $domainNeighborList[$j]){                        
                         if(count(sendMessageIgnoreInactive($domainNeighborList[$i],$domainNeighborList[$j],$list))==0){
                           return "fail";
                          }
                      }
                    }
                  }   

              }
              deleteNodesByNid($domainId);
              deleteLinksByNid($domainId);

              deleteNodesByNid($row['nid']);
              deleteLinksByNid($row['nid']);

              return $domainId;   
          }                             
        }        
              
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

$nid=$_POST['nid'];
//$nid = 7;

echo delete($nid);

?>