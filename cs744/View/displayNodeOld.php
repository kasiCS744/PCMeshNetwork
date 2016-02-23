<?php
/**
 * Created by PhpStorm.
 * User: Liu
 * Date: 2016/2/9
 * Time: 1:37
 */
//$nid=$_POST['nid'];
$pid=$_POST['pid'];
$x=$_POST['x'];
$y=$_POST['y'];
$isConnector=$_POST['isConnector'];
$link1=$_POST['link1'];
$link2=$_POST['link2'];
$link3=$_POST['link3'];
$method=$_GET['method'];
include_once "../dao/getNode.php";
include_once "../dao/getLink.php";
function insertNodeAndLinks($pid,$x,$y,$isConnector,$link1,$link2,$link3){
    insertNode($isConnector,$pid,$x,$y);
    $nid1=getMaxNid();
    if($link1!=null){
        insertLink($nid1,$link1);
    }
    if($link2!=null){
        insertLink($nid1,$link2);
    }
    if($link3!=null){
        insertLink($nid1,$link3);
    }
}
function checkAddNode($pid,$isConnector,$link1,$link2,$link3){
    $count=getCountByPid($pid);
    if($count>=6){
        return "Pattern is full";
    }
    if($isConnector==1) {
        if (getConnectorByPid($pid)!=null) {
        return "already exist a connector in this pattern";
        }
    }elseif($isConnector==0){
        if(getConnectorByPid($pid)==null){
            return "This pattern do not exist,please create a connector for it";
        }
        if($link1==null&&$link2==null&&$link3==null){
            return "A normal node must need to connect to the other node(s)";
        }

    }
    if(getLinkCountByNid($link1)>=3){
        return "Can not connect to Node".$link1." because it has already connected with three nodes";
    }
    if(getLinkCountByNid($link2)>=3){
        return "Can not connect to Node".$link2." because it has already connected with three nodes";
    }
    if(getLinkCountByNid($link3)>=3){
        return "Can not connect to Node".$link3." because it has already connected with three nodes";
    }
    return "true";
}
if($method!="view") {
    if ($pid != null && $isConnector != null && $y != null) {
        $returnMessage = checkAddNode($pid, $isConnector, $link1, $link2, $link3);
        if ($returnMessage == "true") {

            insertNodeAndLinks($pid, $x, $y, $isConnector, $link1, $link2, $link3);
        } else {
            header("location:Main.php?errorMessage=" . $returnMessage);
        }
    } else {
        header("location:Main.php?errorMessage=some value is empty");
    }
}
$nodeResult=getAllNodes();
$linkResult=getAllLinks();
$linkPair=array();
while($row=mysql_fetch_array($linkResult)){
    $tempLinkPair=array();
    $x1=getNodeByNid($row['nid1'])['X'];
    $y1=getNodeByNid($row['nid1'])['Y'];
    $x2=getNodeByNid($row['nid2'])['X'];
    $y2=getNodeByNid($row['nid2'])['Y'];
    $tempLinkPair[0]=$x1;
    $tempLinkPair[1]=$y1;
    $tempLinkPair[2]=$x2;
    $tempLinkPair[3]=$y2;
    array_push($linkPair,$tempLinkPair);
}
?>

<!DOCTYPE>
<html>

<body>
<div align="center">
<canvas id="myCanvas" width="1000" height="1000"></canvas>
</div>
<script>
//    var canvas = document.getElementById('myCanvas');
//    var cxt = canvas.getContext('2d');
var c=document.getElementById("myCanvas");
var ctx=c.getContext("2d");
    <?php
    while($row=mysql_fetch_array($nodeResult)){

    ?>
    //alert(<?php echo $row['X'];?>);

    ctx.beginPath();
    ctx.arc(<?php echo $row['X'];?>,<?php echo $row['Y'];?>,10,0,2*Math.PI);
    <?php if($row['isConnector']==0){?>
    ctx.fillStyle = 'green';
<?php }else{?>
ctx.fillStyle = 'blue';
<?php }?>
    ctx.fill();
    ctx.stroke();
        ctx.fillText("<?php echo "Node".$row['nid'];?>", <?php echo $row['X'];?>, <?php echo $row['Y']-10;?>);
    <?php }
    for($i=0;$i<count($linkPair);$i++){
    $currentPair=$linkPair[$i];
    ?>
ctx.beginPath();
ctx.moveTo(<?php echo $currentPair[0];?>,<?php echo $currentPair[1];?>);
ctx.lineTo(<?php echo $currentPair[2];?>,<?php echo $currentPair[3];?>);
ctx.strokeStyle='green';
ctx.stroke();
    <?php
    }
    ?>

</script>
</body>

</html>