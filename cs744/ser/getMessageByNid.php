<?php
/**
 * Created by PhpStorm.
 * User: Liu
 * Date: 2016/3/1
 * Time: 20:22
 */
include_once "../dao/getMessage.php";
$id=$_POST['nid'];
$result=getMessagesByDestinationID($id);
$list=array();
while($row=mysql_fetch_array($result)){
    array_push($list,$row['messageContext']);
}
echo json_encode($list);

?>