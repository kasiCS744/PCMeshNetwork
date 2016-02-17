<?php
/**
 * Created by PhpStorm.
 * User: Liu
 * Date: 2016/2/11
 * Time: 20:15
 */
include_once "findPath.php";
$list=array();
//$list[0]=11;
//$list[1]=12;
//$list[2]=13;
//$list[3]=10;
//$list=findNodeNeighbour(11,$list);
//print_r($list);
//find(11,13,$list);
print_r(find(15,18,$list));
//$list=array();
//function add(){
//   global $list;
//    if(count($list)>5){
//        print_r($list);
//    }else {
//        array_push($list, 1);
//        // print_r($list);
//        add();
//    }
//}
//function addAgain(){
//    global $list;
//    array_push($list,1);
//}
//add();
//print_r($list);

?>