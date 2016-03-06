<?php
/**
 * Created by PhpStorm.
 * User: Liu
 * Date: 2016/3/1
 * Time: 21:27
 */
include_once "../dao/getNode.php";
$nid=$_POST['nid'];
updateIsActiveToYesByNid($nid);
echo json_encode(getNodeByNid($nid));

?>