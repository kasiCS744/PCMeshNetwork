<?php
include_once "../dao/getNode.php";
$eid = $_POST['startNode'];

$isConnector = getNodeConnector($eid);
$result=null;
switch ($isConnector) {
    case 0:
        $patternID = getPatternID($eid);
        $result = getNodesByPidExceptMe($eid, $patternID);
        break;
    case 1:
        $domainID = getDomainID($eid);
        $result = getNodesByDidExceptMe($eid, $domainID);
        break;
    case 2:        
        $result = getAllDomainNodesExceptMe($eid);
        break;
    default:
        break;
}

$list = array();
while($row=mysql_fetch_array($result))  {
    array_push($list, $row);
}
echo json_encode($list);
?>