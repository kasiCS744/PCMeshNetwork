<?php

	include_once "../dao/getNode.php";
	include_once "../dao/getLink.php";

	$pName="";
	$nName="";
	$nid=getMaxNid()+1;
	$did=getMaxDid()+1;
	$nid2=getMaxNid()+2;
	$pid=getMaxPatternID()+1;

	insertNode($nid, 2, 0, $pName, $nName, "yes", $did);
	insertNode($nid2, 1, $pid, $pName, $nName, "yes", $did);
	insertLink($nid, $nid2);

	echo "success";
?>