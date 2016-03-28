<?php
/**
 * Created by PhpStorm.
 * User: Liu
 * Date: 2016/3/10
 * Time: 14:36
 */
include_once "findShortestPath.php";
include_once "../dao/getMessage.php";
$type=$_POST['type'];
$from=$_POST['from'];
//$next=$_POST['next'];
$message=$_POST['message'];
$to=$_POST['to'];
if($type=="first"){
    $path=sendMessage($from,$to,array());
    if(count($path)==0){
        if($from==$to){
            insertMessage($from,$to,$message,"received");
            echo "received";
        }else {
            $path = sendMessageIgnoreInactive($from, $to, array());
            echo json_encode($path);
        }
    }else{
//        if($from==$to){
//            insertMessage($from,$to,$message,"received");
//            echo "received";
//        }else {
            echo json_encode($path);
//        }
    }
}else if($type=="second"){
    $path=sendMessage($from,$to,array());
    if(count($path)==0){
        echo "blocked";
    }else{
        echo json_encode($path);
    }
}else if($type=="third"){
    insertMessage($from,$to,$message,"received");
}
?>
