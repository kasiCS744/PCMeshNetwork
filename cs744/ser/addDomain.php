<?php

	include_once "../dao/getNode.php";
	include_once "../dao/getLink.php";

	$pName="";
	$nName="";
	$nid=getMaxNid()+1;
	$nid2=getMaxNid()+2;
	$did=getMaxDid()+1;
	$pid=getMaxPatternID()+1;

	$domains=$_POST['domains'];

	insertNode($nid, 2, -1, $pName, $nName, "yes", $did);
    foreach ($domains as $key => $value) {
        insertLink($nid, $value);
    }

	insertNode($nid2, 1, $pid, $pName, $nName, "yes", $did);
	insertLink($nid, $nid2);

	echo "success";
?>