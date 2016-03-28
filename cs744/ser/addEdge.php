<?php

	include_once "../dao/getNode.php";
	include_once "../dao/getLink.php";

	$from = $_POST['startNode'];
	$to = $_POST['nextNode'];

	$connector = getNodeConnector($from);
	$result = "success";
	if ($connector != 0)  {
		foreach($to as $key=>$value){
			$isConnector = getNodeConnector($value);
			if ($isConnector != 0)  {
				insertLink($from, $value);
			}
			if ($isConnector == 0 && getLinkCountByNid($value) < 3)  {
        		insertLink($from, $value);
			}
			else  {
				$result = "failure";
			}
    	}
	}
	$count = getLinkCountByNid($from);
	if ($connector == 0 && getLinkCountByNid($from) < 3)  {
		foreach($to as $key=>$value){
			$isConnector = getNodeConnector($value);
			if ($isConnector != 0)  {
				insertLink($from, $value);
			}
			if ($isConnector == 0 && getLinkCountByNid($value) < 3)  {
        		insertLink($from, $value);
			}
			else  {
				$result = "failure";
			}
    	}
    }
    else  {
		$result = "failure";
	}
    echo $result;
?>