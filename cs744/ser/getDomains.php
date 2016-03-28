<?php
	include_once "../dao/getNode.php"; 
	$did = $_POST['did'];
	$result = getNodesByDid($did);
	$list = array();
	while($row=mysql_fetch_array($result))  {
		array_push($list, $row);
	}
	echo json_encode($list);
?>