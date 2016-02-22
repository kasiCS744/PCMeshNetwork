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
$pName="";
$nName="";
$nid=getMaxNid()+1;
//$values = $_POST['yyy'];
//print_r($values);
////
////foreach ($values as $a){
////    echo $a;
////}
//print_r($nodes1);
$flag=true;
if($isConnector==1){

    $pid=getMaxPatternID()+1;
    $nodes1=$_POST['nodes1'];
    if($nodes1==null){
        echo "need connect at least one node\n";
        $flag=false;
       // return;
    }
    if(count($nodes1)<1){
        echo "need connect at least one node\n";
       // return;
        $flag=false;
    }
    if($flag){
      //  $pid=$_POST['pid'];

        insertNode($nid, 1, $pid, $pName, $nName, "yes");
        foreach ($nodes1 as $key => $value) {
            insertLink($nid, $value);
        }
        echo "success";
    }

}else{
    $pid=$_POST['pid'];
    $count=getCountByPid($pid);
    if($count>=6){
        echo "Pattern is full\n";
       // return;
        $flag=false;
    }
    $nodes0=$_POST['nodes0'];
    if($nodes0==null){
        echo "need connect at least one node\n";
       // return;
        $flag=false;
    }
    if(count($nodes0)==0){
        echo "need connect at least one node\n";
       // return;
        $flag=false;
    }
    if(count($nodes0)>3){
        echo "must select less or equal three nodes\n";
      //  return;
        $flag=false;
    }

        $pid = $_POST['pid'];


        foreach ($nodes0 as $key => $value) {
            if(getNodeByNid($value)['isConnector']==1){
                $links=getLinksArrayByNid($value);
                foreach($links as $key1=>$value1){
                    if(getNodeByNid($value1)['isConnector']==1){
                        unset($links[$key1]);
                    }
                }
                if(count($links)>=3){
                    echo "Can not connect to Node" . $value . " because it has already connected with three nodes\n";
                    $flag=false;
                    break;
                }
            }else {
                if (getLinkCountByNid($value) >= 3) {
                    echo "Can not connect to Node" . $value . " because it has already connected with three nodes\n";
                    // return;
                    $flag = false;
                    break;
                }
            }
        }
    if($flag) {
        foreach ($nodes0 as $key => $value) {
            insertLink($nid, $value);
        }

        insertNode($nid, 0, $pid, $pName, $nName, "yes");
        echo "success";
    }
}
?>