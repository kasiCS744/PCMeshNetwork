<?php
/**
 * Created by PhpStorm.
 * User: Liu
 * Date: 2016/2/11
 * Time: 15:22
 */
include_once "../dao/getLink.php";
$recordList=array();
function findNodeActiveNeighbour($start){
    global $recordList;
    $linkList=getActiveLinksArrayByNid($start);
    //print_r($linkList);
    //print_r($recordList);
    $count=count($linkList);
    for($i=0;$i<$count;$i++){
        if(in_array($linkList[$i],$recordList)){
            //   array_splice($linkList,$i,1);
            // echo "true".$i." ";
            unset($linkList[$i]);
        }
    }
    $resultLink=array();
    foreach($linkList as $value){
        array_push($resultLink,$value);
    }
    //print_r($resultLink);

    return $resultLink;
}
function findNodeNeighbour($start){
    global $recordList;
$linkList=getLinksArrayByNid($start);
    //print_r($linkList);
    //print_r($recordList);
    $count=count($linkList);
for($i=0;$i<$count;$i++){
    if(in_array($linkList[$i],$recordList)){
     //   array_splice($linkList,$i,1);
       // echo "true".$i." ";
        unset($linkList[$i]);
    }
}
    $resultLink=array();
    foreach($linkList as $value){
        array_push($resultLink,$value);
    }
    //print_r($resultLink);

    return $resultLink;
}
//if($start==$destination){
//    //if so, return this node
//    array_push($returnList,$start);
//    return $returnList;
//}
//Suppose the start node is different from the destination node
function iniRecordList($requireList){
    global $recordList;
    $recordList=array();
    foreach($requireList as $value){
        array_push($recordList,$value);
    }

}
function sendMessage($start,$destination,$requireList,$recordList){
    iniRecordList($requireList);
    return find($start,$destination,0,$recordList);
}
function sendMessageIgnoreInactive($start,$destination,$requireList){
    iniRecordList($requireList);
    return find($start,$destination,1);
}
function find($start,$destination,$active){
    global $recordList;
  //  print_r($recordList);
    $nullList=array();
   // static $recordList;
 //   $returnList=array();
   // $recordList=array();
  //  $neighbourList=array();
    //find the neighbour of start node first
    array_push($recordList,$start);
    if($active==0) {
        $neighbourList = findNodeActiveNeighbour($start);
    }else{
        $neighbourList = findNodeNeighbour($start);
    }
//    print_r($neighbourList);
//    echo "<br>";
   // print_r($recordList);
    //check if the start node has neighbour
    //if it do not have neighbours, return null means the search is end
    //if it has neighbours,check whether their neighbour is destination node or not
    //if the eighbour is not the destination node,change the start node to its neighbour to see whether they can find the destination node or not
        if (count($neighbourList)==0||$neighbourList==null) {
            return $nullList;
        }
        else {
            //the node already searched has recorded to a list so they won't be searched again

            //then check all the neighbours to see it is a destination node or not
            $listList=array();
            $min=0;
            $minArray=array();
            for ($i = 0; $i < count($neighbourList); $i++) {
                array_push($recordList,$neighbourList[$i]);
            }
            for ($i = 0; $i < count($neighbourList); $i++) {
                //if yes, add this node to return list,then return the returnList

                if ($neighbourList[$i] == $destination) {
                    //echo $neighbourList[$i]."xx";
                    //array_push($recordList,$destination);
                    $result = array();
                    $result[0] = $neighbourList[$i];
                    $result[1]=$start;
                    return $result;
                }
            }

            for ($i = 0; $i < count($neighbourList); $i++) {

                    $tempList=find($neighbourList[$i],$destination,$active);
                        array_push($tempList,$start);
//                        print_r($tempList);
//                        echo "<br>";
                    if($i==0){
                            $min = count($tempList);
                            $minArray = $tempList;
                        }else{
//                        $tempList=find($neighbourList[$i],$destination,$active);
//                        array_push($tempList,$start);
//                        print_r($tempList);
//                        echo "<br>";
                        if($min<=1){
                            $min = count($tempList);
                            $minArray = $tempList;
                        }else {
                            if(count($tempList)>1) {
                                if (count($tempList) < $min) {
                                    $minArray = $tempList;
                                    $min = count($tempList);
                                }
                            }
                        }
                    }

                }

            if($min>1){
                return $minArray;
            }else{

                return $nullList;
            }

    }
}
?>
