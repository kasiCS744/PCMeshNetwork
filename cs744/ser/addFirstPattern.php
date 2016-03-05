<?php

include_once "../dao/getNode.php";

$pName="";
$nName="";
$nid=getMaxNid()+1;
$pid=getMaxPatternID()+1;
insertNode($nid, 1, $pid, $pName, $nName, "yes");
echo "success";
?>