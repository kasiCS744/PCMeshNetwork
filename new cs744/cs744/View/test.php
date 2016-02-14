<?php
/**
 * Created by PhpStorm.
 * User: Liu
 * Date: 2016/2/10
 * Time: 18:30
 */
include_once "../dao/getNode.php";
include_once "../dao/getLink.php";
include_once "../ser/findPath.php";
//include_once "../ser/deleteNode.php";
$nodeResult=getAllNodes();
$linkResult=getAllLinks();
$messageNodes=array();
//echo delete(18);
$messageNodes=sendMessage(17,14,array());
//$messageNodes=sendMessage(15,11,array());
?>
<!doctype html>
<html>
<head>
    <title>Network | Basic usage</title>

    <script type="text/javascript" src="../js/vis.js"></script>
    <link href="../css/vis.css" rel="stylesheet" type="text/css" />

    <style type="text/css">
        #mynetwork {
            width: 800px;
            height: 800px;
            border: 1px solid lightgray;
        }

        p {
            max-width:700px;
        }
    </style>
</head>
<body>
<input type="button" value="deleteNode" onclick="deleteNode()">
<div style="display: none;border: double" align="center" id="delete">
    <form action="../ser/deleteNode.php" method="post">
        <label>Which node you want delete<input type="text" name="nid"></label>
    <input type="submit" value="submit">
    <input type="button" value="close" onclick="hideDelete()">
    </form>
</div>
<div id="mynetwork"></div>

<script type="text/javascript">
    // create an array with nodes
    var nodes = new vis.DataSet([
        <?php
        while($row=mysql_fetch_array($nodeResult)){?>
        <?php
        $color="";
        if(in_array($row['nid'],$messageNodes)){
        $color="red";
        }else{
        if($row['isConnector']==1){
        $color="rgb(255,168,7)";
        }else{
        $color="#7BE141";
        }}?>
        {id: <?php echo $row['nid'];?>, label:'<?php echo "Node".$row['nid']?>', color: '<?php echo $color;?>'},
        <?php }?>
//        {id: 3, label:'hex color', color: '#7BE141'},
//        {id: 4, label:'rgba color', color: 'rgba(97,195,238,0.5)'},
//        {id: 5, label:'colorObject', color: {background:'pink', border:'purple'}},
//        {id: 6, label:'colorObject + highlight', color: {background:'#F03967', border:'#713E7F',highlight:{background:'red',border:'black'}}},
//        {id: 7, label:'colorObject + highlight + hover', color: {background:'cyan', border:'blue',highlight:{background:'red',border:'blue'},hover:{background:'white',border:'red'}}}
    ])

    // create an array with edges
    var edges = new vis.DataSet([
        <?php
           while($row=mysql_fetch_array($linkResult)){?>
        {from: <?php echo $row['nid1'];?>,to:<?php echo $row['nid2'];?>},
        <?php }?>
//        {from: 1, to: 2},
//        {from: 2, to: 4},
//        {from: 2, to: 5},
//        {from: 2, to: 6},
//        {from: 4, to: 7},
    ]);

    // create a network
    var container = document.getElementById('mynetwork');
    var data = {
        nodes: nodes,
        edges: edges
    };
    var options = {
        nodes: {shape:'dot',borderWidth: 2},
        interaction: {hover: true}
    }
    var network = new vis.Network(container, data, options);
</script>
<script>
    function deleteNode(){
       // alert(1);
        document.getElementById("delete").style.display="block";
    }
    function hideDelete(){
        document.getElementById("delete").style.display="none";
    }
</script>
<script src="../js/googleAnalytics.js"></script>
</body>
</html>
