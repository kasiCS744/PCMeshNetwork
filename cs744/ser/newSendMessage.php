<?php
/**
 * Created by PhpStorm.
 * User: Liu
 * Date: 2016/2/13
 * Time: 20:45
 */
//include_once "findPath.php";
include_once "findShortestPath.php";
include_once "../dao/getMessage.php";
include_once "../dao/getNode.php";
function checkActive($from){
    if(getNodeByNid($from)['isActive']=="yes"){
        return true;
    }else{
        return false;
    }
}
function blockMessage($from,$to,$messageContext,$state){
    insertMessage($from,$to,$messageContext,$state);
}
$from=$_POST['from'];
$to=$_POST['to'];
$messageContext=$_POST['messageContext'];
$original=$_POST['original'];
if(!checkActive($from)){
    echo "fail";
}else{
if($from==$to){
    blockMessage($original, $to, $messageContext,"received");
    echo "success";
}else {
    $result = array();
    $result = sendMessage($from, $to, array(), array());
    if (count($result) == 0) {
        blockMessage($from, $to, $messageContext, "blocked");
        echo "fail";
    } else {
        if (count($result) > 1) {
            echo $result[count($result) - 2];
        } else {
            blockMessage($original, $to, $messageContext, "received");
            echo "success";
        }
    }
}
}





?>