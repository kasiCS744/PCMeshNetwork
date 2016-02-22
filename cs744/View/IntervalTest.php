<!-- <html>
<body>

<input type="text" id="clock" size="35" />
<script language=javascript>
    var count=0;
    var global=0;
    function start(){
        global=self.setInterval("clock()",1000);

    }
    function clock()
    {
        document.getElementById("xxx").innerHTML+="hello";
        count++;
        if(count>5){
//alert(count);
            window.clearInterval(global);
        }
    }
</script>
<button onclick="start()">start</button>
<div id="xxx">

</div>

</body>
</html>
-->
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
$startNodeList=getAllNodes();
$destinationNodeList=getAllNodes();
?>
<!doctype html>
<html>
<head>
    <title>Network | Basic usage</title>
    <link href="http://libs.baidu.com/bootstrap/3.0.3/css/bootstrap.min.css" rel="stylesheet">
    <script src="http://libs.baidu.com/jquery/2.0.0/jquery.min.js"></script>
    <script src="http://libs.baidu.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="../js/vis.js"></script>
    <link href="../css/vis.css" rel="stylesheet" type="text/css" />

    <style type="text/css">
        #mynetwork {
            width: 1800px;
            height: 800px;
            border: 1px solid lightgray;


        }

        p {
            max-width:700px;
        }
    </style>
</head>
<body>
<input type="button" value="sendMessage" onclick="displayDiv('sendMessage')">
<input type="button" value="reset Nodes" onclick="resetAllNodesStabilize()">
<div style="display: none;position: absolute;left: 35%;top: 30%;border: double;z-index: 9;background: #ffffff;width: 400px" id="sendMessage" class="container">
    <form action="#" method="post" id="messageForm">
       <h4 > Start Node</h4> <select name="from" id="from" class="form-control" style="width: 80%">

                <?php
                while($row1=mysql_fetch_array($startNodeList)){
                    echo "<option value='".$row1['nid']."'>Node".$row1['nid']."</option>";
                }?>
            </select>
        <h4>Destination Node</h4><select name="to" id="to" class="form-control" style="width: 80%">
                <?php
                while($row1=mysql_fetch_array($destinationNodeList)){
                    echo "<option value='".$row1['nid']."'>Node".$row1['nid']."</option>";
                }?>
            </select><br>
<!--        <label>Start Node<input type="text" name="from" id="from"></label>-->
<!--        <label>Destination Node<input type="text" name="to" id="to"></label><br>-->
       <h4> Message Context<br></h4><label><textarea rows="4" cols="50" name="messageContext" id="messageContext" class="form-control"></textarea></label><br>
        <div align="center"><input type="button" value="Submit" class="btn btn-primary" onclick="sendMessage(document.getElementById('from').value,
        document.getElementById('to').value,document.getElementById('messageContext').value)">
        <input type="button" class="btn btn-default" value="Hide" onclick="hideDiv('sendMessage')">
        </div><br>
    </form>
</div>
<div id="mynetwork"></div>
<script type="text/javascript">
    // create an array with nodes
    nodesArray= [
        <?php
        while($row=mysql_fetch_array($nodeResult)){?>
        <?php
        $color="";
        if($row['isConnector']==1){
        $color="rgb(255,168,7)";
        if($row['isActive']=="no"){
        $color='gray';
        }
        }else
        {
         $color="#7BE141";
        if($row['isActive']=="no"){
        $color='gray';
        }
        }?>
        {id: <?php echo $row['nid'];?>, label:'<?php echo "Node".$row['nid']?>', color: '<?php echo $color;?>'},
        <?php }?>
//        {id: 3, label:'hex color', color: '#7BE141'},
//        {id: 4, label:'rgba color', color: 'rgba(97,195,238,0.5)'},
//        {id: 5, label:'colorObject', color: {background:'pink', border:'purple'}},
//        {id: 6, label:'colorObject + highlight', color: {background:'#F03967', border:'#713E7F',highlight:{background:'red',border:'black'}}},
//        {id: 7, label:'colorObject + highlight + hover', color: {background:'cyan', border:'blue',highlight:{background:'red',border:'blue'},hover:{background:'white',border:'red'}}}
    ];
    nodes = new vis.DataSet(nodesArray);

    // create an array with edges
    edgesArray=
        [
            <?php
               while($row=mysql_fetch_array($linkResult)){?>
            {from: <?php echo $row['nid1'];?>,to:<?php echo $row['nid2'];?>},
            <?php }?>
        ];
    var edges = new vis.DataSet(edgesArray);

    // create a network
    var container = document.getElementById('mynetwork');
    var data = {
        nodes: nodes,
        edges: edges
    };
    var options = {
        nodes: {shape:'dot',borderWidth: 1},
        interaction: {hover: true}
    }
    var network = new vis.Network(container, data, options);
    function change(){
        nodes.update([{id:10, color:'rgb(255,255,7)'}]);

    }
    function resetAllNodes() {
        for(var i=0;i<nodesArray.length;i++){
            //alert(nodesArray[i]);
            nodes.update(nodesArray[i]);
        }
    }

    function resetAllNodesStabilize() {
        resetAllNodes();
        network.stabilize();
    }
    var global;
    var length;
    var result;
    function isActive(nid){
        var xmlhttp = new XMLHttpRequest();
        var x="";
        xmlhttp.onreadystatechange = function() {

            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                x=xmlhttp.responseText;
            }
        }
        xmlhttp.open("POST", "/cs744/ser/checkNodeIsActive.php", false);
        xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xmlhttp.send("nid="+nid);
        return x;

    }
    function next(){
       // length=length-1;
        if(isActive(result[length-1])=="success") {
            nodes.update([{id: result[length - 1], color: {background: 'red'}}]);
            if(length<=1){

                window.clearInterval(global);
                //alert(1);
             //  window.setTimeout(alert("Node"+result[length-1]+" received the message\n:"+document.getElementById("messageContext").value),7000);
              //  setTimeout(xxx(),7000);
            }else {
                length--;
            }
        }else{
            window.clearInterval(global);
          //  sendMessage(result[length],result[0],"x");
        }
       // length--;

    }
    function sendMessage(from,to,messageContext){
        hideDiv("sendMessage");
        resetAllNodesStabilize();
      //  var from=document.getElementById("from").value;
      //  var to=document.getElementById("to").value;
      //  var messageContext=document.getElementById("messageContext").value;
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {

            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                 result=xmlhttp.responseText;
                result=eval(result);
                if(result.length==0){
                    alert("Can not find a way to send this message");
                }else {
                  //  for (var i = 0; i < result.length; i++) {
                    length=result.length-1;
                        nodes.update([{id: result[length], color: {background: 'red'}}]);
                    if(length>0){
                        global=self.setInterval("next()",1500);
                    }
                   // alert(1);

                //    }
                }
               // document.getElementById("sendMessage").style.display="none";
            }
        };
        xmlhttp.open("POST", "/cs744/ser/sendMessage.php", true);
        xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xmlhttp.send("from="+from+"&&to="+to+"&&messageContext="+messageContext);
    }
    function displayDiv(id){
        document.getElementById(id).style.display="block";
    }
    function hideDiv(id){
        document.getElementById(id).style.display="none";
    }
    network.on("doubleClick", function (params) {
        if(params.nodes==""){
            return;
        }
        if(confirm("Confirm delete Node"+params.nodes)) {
            params.event = "[original event]";
            //var nodeId=JSON.stringify(params.nodes, null, 4);
            var nodeId = params.nodes;
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function () {

                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    var result = xmlhttp.responseText;
                    // alert(result);
                    if (result == "fail") {
                        alert("Can not delete this node because one or more nodes are rely on it");
                    } else if (result == "normalSuccess") {
                        nodes.remove({id: nodeId});
                    } else if (result = "connectorSuccess") {
                        window.location.reload();
                    }

                }
            };
            xmlhttp.open("POST", "/cs744/ser/deleteNode.php", true);
            xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xmlhttp.send("nid=" + nodeId);
        }
        // alert(nodeId);
        // document.getElementById('eventSpan').innerHTML = '<h2>doubleClick event:</h2>' + JSON.stringify(params, null, 4);
    });
</script>
<script type="text/javascript">

</script>
<script src="../js/googleAnalytics.js"></script>
</body>
</html>
