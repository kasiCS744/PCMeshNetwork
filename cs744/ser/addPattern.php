<?php

	include_once "../dao/getNode.php";
	include_once "../dao/getLink.php";

	$pName="";
	$nName="";
	$nid=getMaxNid()+1;
	$did=$_POST['did'];
	$pid=getMaxPatternID()+1;

	$domains=$_POST['nodes1'];

	insertNode($nid, 1, $pid, $pName, $nName, "yes", $did);
    foreach ($domains as $key => $value) {
        insertLink($nid, $value);
    }

	echo "success";
?>