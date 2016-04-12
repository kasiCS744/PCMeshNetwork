<?php
	include_once "../dao/DBHelper.php";

	$selectionOfNodes=$_POST['activeNodes'];
	foreach ($selectionOfNodes as $key => $value) {
		$sql = "update node set isActive='no' where nid='".$value."'";
		mysql_fetch_array(mysql_query($sql));
	}
	echo "success";
?>