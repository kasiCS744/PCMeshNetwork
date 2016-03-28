<?php
/**
 * Created by PhpStorm.
 * User: Liu
 * Date: 2016/3/1
 * Time: 20:06
 */
include_once "../dao/getNode.php";
$result = getInactiveNodes();
$list = array();
while($row=mysql_fetch_array($result))  {
    array_push($list, $row['nid']);
}
echo json_encode($list);
?>