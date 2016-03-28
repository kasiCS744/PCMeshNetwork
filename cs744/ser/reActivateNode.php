<?php
	include_once "../dao/DBHelper.php";

	$selectionOfNodes=$_POST['inactiveNodes'];
	foreach ($selectionOfNodes as $key => $value) {
		$sql = "update node set isActive='yes' where nid='".$value."'";
		mysql_fetch_array(mysql_query($sql));
	}
	echo "success";
?>