<?php
/**
 * Created by PhpStorm.
 * User: Liu
 * Date: 2016/3/26
 * Time: 21:05
 */
include_once "../dao/getNode.php";
include_once "../dao/getLink.php";
function getDomainNodesAndTheirPatternCounts(){
    $result=getAllDomainNodes();
    $list=array();

    while($row=mysql_fetch_array($result)){
        $tempList=array();
        $linksArray=getLinksArrayByNid($row['nid']);
        $count=0;
        foreach($linksArray as $key=>$value){
            if(!isDomainNode($value)){
                $count++;
            }
        }

        array_push($tempList,$row['nid']);
        array_push($tempList,$count);
        array_push($list,$tempList);

    }
    return $list;
}
$list=getDomainNodesAndTheirPatternCounts();
//print_r(getAllNullDomainNodes());
foreach($list as $key=>$value){
    echo $value[1]."<br>";
}
?>