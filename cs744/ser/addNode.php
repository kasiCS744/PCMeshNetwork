<?php
/**
 * Created by PhpStorm.
 * User: Liu
 * Date: 2016/2/21
 * Time: 15:22
 */
include_once "../dao/getNode.php";
include_once "../dao/getLink.php";
$isConnector=$_POST['isConnector'];
$pid = $_POST['pid'];
$did = getDomainIDByPid($pid);
$pName="";
$nName="";
$nid=getMaxNid()+1;

$flag=true;
if($isConnector==0){

    $pid=getMaxPatternID()+1;
    $nodes1=$_POST['nodes1'];
    if($nodes1==null){
        echo "You need to connect to at least one node\n";
        $flag=false;
       // return;
    }
    if(count($nodes1)<1){
        echo "You need to connect to at least one node\n";
        $flag=false;
    }
    if($flag){
        insertNode($nid, 1, $pid, $pName, $nName, "yes", $did);
        foreach ($nodes1 as $key => $value) {
            insertLink($nid, $value);
        }
        echo "success";
    }

}else{
    $pid=$_POST['pid'];
    $count=getCountByPid($pid);
    if($count>=6){
        echo "The pattern is full\n";
        $flag=false;
    }
    $nodes0=$_POST['nodes0'];
    if($nodes0==null){
        echo "You need to connect to at least one node\n";
        $flag=false;
    }
    if(count($nodes0)==0){
        echo "You need to connect to at least one node\n";
        $flag=false;
    }
    if(count($nodes0)>3){
        echo "Please select at most three nodes\n";
        $flag=false;
    }




        foreach ($nodes0 as $key => $value) {
            if(getNodeByNid($value)['isConnector']==1){
                $links=getLinksArrayByNid($value);
                foreach($links as $key1=>$value1){
                    if(getNodeByNid($value1)['isConnector']==1 || getNodeByNid($value1)['isConnector']==2){
                        unset($links[$key1]);
                    }
                }
                if(count($links)>=3){
                    echo "Can not connect to Node" . $value . " because it is already connected with three nodes\n";
                    $flag=false;
                    break;
                }
            }else {
                if (getLinkCountByNid($value) >= 3) {
                    echo "Can not connect to Node" . $value . " because it is already connected with three nodes\n";
                    $flag = false;
                    break;
                }
            }
        }
    if($flag) {
        foreach ($nodes0 as $key => $value) {
            insertLink($nid, $value);
        }

        insertNode($nid, 0, $pid, $pName, $nName, "yes", $did);
        echo "success";
    }
}
?>