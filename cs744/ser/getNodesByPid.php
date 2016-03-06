<?php
	include_once "../dao/getNode.php"; 
	$pid = $_POST['pid'];
	$result = getNonConnectorByPid($pid);
	$list = array();
	while($row=mysql_fetch_array($result))  {
		array_push($list, $row);
	}
	echo json_encode($list);
?>