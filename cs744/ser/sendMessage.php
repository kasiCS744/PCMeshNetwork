<?php
/**
 * Created by PhpStorm.
 * User: Liu
 * Date: 2016/2/13
 * Time: 20:45
 */
include_once "findPath.php";
include_once "../dao/getMessage.php";
function blockMessage($from,$to,$messageContext){
    insertMessage($from,$to,$messageContext);
}
$from=$_POST['from'];
$to=$_POST['to'];
$messageContext=$_POST['messageContext'];
$result=array();
$result=sendMessage($from,$to,array());
if(count($result)==0){
    blockMessage($from,$to,$messageContext);
}
echo json_encode($result);





?>