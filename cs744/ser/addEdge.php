<?php

include_once "../dao/getNode.php";
include_once "../dao/getLink.php";

$from = $_POST['startNode'];
$to = $_POST['nextNode'];

$connector = getNodeConnector($from);
$result = "success";
if ($connector != 0)  {
    foreach($to as $key=>$value){
//        $linkCount=getLinkCountByNid($value);
//        $receiver = getNodeConnector($value);
//        if ($receiver != 0)  {
//            if (linkExists($from, $value) == 0)  {
//                insertLink($from, $value);
//            }
//            else  {
//                $result = "Link already exists";
//            }
//        }
//        if ($receiver == 0 && $linkCount < 3)  {
            if (linkExists($from, $value) == 0)  {
                insertLink($from, $value);
            }
//            else  {
//                $result = "Link already exists";
//            }
//        }
//        if ($receiver == 0 && $linkCount == 3)  {
//            echo "111";
//            $result = "failure";
//        }
    }
}
$count = getLinkCountByNid($from);
if ($connector == 0 && $count < 3)  {
    foreach($to as $key=>$value){
        $linkCount=getLinkCountByNid($value);
        $receiver = getNodeConnector($value);
        if ($receiver != 0)  {
            if (linkExists($from, $value) == 0)  {
                insertLink($from, $value);
            }
            else  {
                $result = "Link already exists";
            }
        }
        if ($receiver == 0 && $linkCount < 3)  {
            if (linkExists($from, $value) == 0)  {
                insertLink($from, $value);
            }
            else  {
                $result = "Link already exists";
            }
        }
        if ($receiver == 0 && $linkCount == 3)  {
            echo "222";
            $result = "failure";
        }
    }
}
else if ($connector == 0 && $count == 3)  {
    echo "333";
    $result = "failure";
}
echo $result;
?>