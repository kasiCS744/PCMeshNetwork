<?php
	include_once "../dao/DBHelper.php";
	include_once "../dao/getNode.php";
	include_once "../dao/getSetting.php";

	ignore_user_abort(true);
	set_time_limit(0);	

	while(1)  {

    	// if(connection_status() != CONNECTION_NORMAL)  {
     //    	break;
    	// }
		$random = rand(1, 100);
		$nodes = array();
		$result = getAllActiveNodes();
		while($row=mysql_fetch_array($result))  {
			array_push($nodes, $row);
		}
		$nodeArraySize = count($nodes);
		$randomNode = $nodes[rand(0, ($nodeArraySize - 1))];
		$randomNode = $randomNode['nid'];
		switch (getSetting()) {
			case 0:
				//do nothing
				break;
			case 20:
				if (($random >= 1) && ($random <= 20))  {
					$sql = "update node set isActive='no' where nid='".$randomNode."'";
					mysql_query($sql);
				}
				break;
			case 40:
				if (($random >= 1) && ($random <= 40))  {
					$sql = "update node set isActive='no' where nid='".$randomNode."'";
					mysql_query($sql);
				}
				break;
			case 60:
				if (($random >= 1) && ($random <= 60))  {
					$sql = "update node set isActive='no' where nid='".$randomNode."'";
					mysql_query($sql);
				}
				break;
			case 80:
				if (($random >= 1) && ($random <= 80))  {
					$sql = "update node set isActive='no' where nid='".$randomNode."'";
					mysql_query($sql);
				}
				break;
			case 100:
				if (($random >= 1) && ($random <= 100))  {
					$sql = "update node set isActive='no' where nid='".$randomNode."'";
					mysql_query($sql);
				}
				break;	

		default:
			# code...
			break;
		}
	    sleep(5);
	}
?>