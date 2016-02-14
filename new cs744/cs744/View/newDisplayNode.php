<?php
/**
 * Created by PhpStorm.
 * User: Liu
 * Date: 2016/2/10
 * Time: 18:30
 */
include_once "../dao/getNode.php";
include_once "../dao/getLink.php";
$nodeResult=getAllNodes();
$linkResult=getAllLinks();
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
<input type="button" value="change Script" onclick="change()">
<div id="mynetwork"></div>

<script type="text/javascript">
    // create an array with nodes
    nodes = new vis.DataSet([
        <?php
        while($row=mysql_fetch_array($nodeResult)){?>
        <?php
        $color="";
        if($row['isConnector']==1){
        $color="rgb(255,168,7)";
        }else{
        $color="#7BE141";
        }?>
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
    function change(){
       // nodes=1;
       // alert(nodes);
        nodes.update([{id:10, color:'rgb(255,255,7)'}]);

    }
//    network.on("click", function (params) {
//        params.event = "[original event]";
//        var n=params.nodes[0];
//        alert(n);
//       // alert(JSON.stringify(params, null, 4));
//        // document.getElementById('eventSpan').innerHTML = '<h2>Click event:</h2>' + JSON.stringify(params, null, 4);
//    })
</script>
<script type="javascript">

</script>
<script src="../js/googleAnalytics.js"></script>
</body>
</html>
