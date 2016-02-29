<?php
/**
 * Created by PhpStorm.
 * User: Liu
 * Date: 2016/2/10
 * Time: 18:30
 */
include_once "../dao/getNode.php";
include_once "../dao/getLink.php";
session_start();
$uid=$_SESSION['uid'];
if($uid==null){
    header("location:../Login.html");
}
$nodeResult=getAllNodes();
$linkResult=getAllLinks();
$startNodeList=getAllNodes();
$destinationNodeList=getAllNodes();
?>
<!doctype html>
<html>
<head>
<!--    <title>Network | Basic usage</title>-->
<!--    <link href="http://libs.baidu.com/bootstrap/3.0.3/css/bootstrap.min.css" rel="stylesheet">-->
<!--    <script src="http://libs.baidu.com/jquery/2.0.0/jquery.min.js"></script>-->
<!--    <script src="http://libs.baidu.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>-->
<!--    <script type="text/javascript" src="../js/vis.js"></script>-->
<!--    <link href="../css/vis.css" rel="stylesheet" type="text/css" />-->
<?php include_once "viewStructureHead.php";?>
    <style type="text/css">
        #mynetwork {
            width: 1200px;
            height: 700px;
            border: 1px solid lightgray;


        }

        p {
            max-width:700px;
        }
    </style>
</head>
<body>
<?php include_once "viewStructureBody.php";?>
<div class="container" id="firstContainer" align="center">
    <div class="well bs-component">
        <input type="button" class="btn btn-success" value="send Message" onclick="displayDiv('sendMessage')">
        <input type="button" class="btn btn-info" value="reset Nodes" onclick="resetAllNodesStabilize()">
        <input type="button" class="btn btn-default" value="show Message Log" onclick="showMessages()">
    </div>
    <div style="display: none;position: absolute;left: 35%;top: 30%;z-index: 9;background:#ffffff;width: auto" id="sendMessage" class="container">
        <form action="#" method="post" id="messageForm">
            <h4 > Start Node</h4> 
                <select name="from" id="from" class="form-control" style="width: 80%">
                    <?php
                        while($row1=mysql_fetch_array($startNodeList)){
                        echo "<option value='".$row1['nid']."' id='from".$row1['nid']."'>Node".$row1['nid']."</option>";
                    }?>
                </select>
            <h4>Destination Node</h4>
                <select name="to" id="to" class="form-control" style="width: 80%">
                    <?php
                        while($row1=mysql_fetch_array($destinationNodeList)){
                        echo "<option value='".$row1['nid']."' id='to".$row1['nid']."'>Node".$row1['nid']."</option>";
                    }?>
                </select><br>
        <!--        <label>Start Node<input type="text" name="from" id="from"></label>-->
        <!--        <label>Destination Node<input type="text" name="to" id="to"></label><br>-->
            <h4> Message Context<br></h4>
            <label>
                <textarea rows="4" cols="50" name="messageContext" id="messageContext" class="form-control"></textarea>
            </label>
            <br>
            <div align="center">
                <input type="button" value="Submit" class="btn btn-primary" onclick="beforeSendMessage(document.getElementById('from').value, document.getElementById('to').value,document.getElementById('messageContext').value)">
                <input type="button" class="btn btn-default" value="Hide" onclick="hideDiv('sendMessage')">
            </div>
            <br>
        </form>
    </div>
    <div align="center">
        <div id="mynetwork"></div>
    </div>
    <div style="display: none;position: absolute;left: 35%;top: 30%;z-index: 9;background: #ffffff;width: auto" id="messageDiv" class="container">
        <div id="showMessage"></div>
        <div align="right">
            <input type="button" class="btn btn-default" value="Hide" onclick="hideMessageDiv()" >
        </div>
    </div>
</div>
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
function hideMessageDiv(){
    document.getElementById('messageDiv').style.display='none';
}
    function resetAllNodesStabilize() {
        resetAllNodes();
        network.stabilize();
    }
    var global;
    var from;
    var to;
    var message;
    function beforeSendMessage(start,end,messageContext){
        hideDiv("sendMessage");
        resetAllNodesStabilize();
        from=start;
        to=end;
        message=messageContext;
        global=setInterval("sendMessage()",1500);
    }
    function showMessages(){
        var xmlhttp = new XMLHttpRequest();
        var result="";
        xmlhttp.onreadystatechange = function() {

            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
               result=eval(xmlhttp.responseText);
                var table="<table class='table table-bordered'><tr><td>Start Node</td><td>End Node</td><td>MessageContext</td><td>State</td></tr>";
                for(var i=0;i<result.length;i++){
                    table+="<tr><td>";
                    table+="Node"+result[i].nid+"</td><td>";
                    table+="Node"+result[i].destination+"</td><td>";
                    table+=result[i].messageContext+"</td><td>";
                    table+=result[i].state;
                    table+="</td></tr>";
                }
                table+="</table>";
                //alert(table);
                document.getElementById("showMessage").innerHTML=table;
                document.getElementById("messageDiv").style.display="block";
            }
        }
        xmlhttp.open("POST", "/cs744/ser/messageList.php", false);
        xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xmlhttp.send();

    }
    function sendMessage(){
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {

            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                result=xmlhttp.responseText;
               // result=eval(result);
                if(result=="fail"){
                    alert("Cannot find a path to send this message");
                    clearInterval(global);

                }else if(result=="success"){
                    nodes.update([{id: from, color: {background: 'red'}}]);
                    alert("Node "+to+" received the message\nContent is:"+message);
                    clearInterval(global);
                }else {
                    nodes.update([{id: from, color: {background: 'red'}}]);
                    from=result;

                }
            }
        };
        xmlhttp.open("POST", "/cs744/ser/newSendMessage.php", false);
        xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xmlhttp.send("from="+from+"&&to="+to+"&&messageContext="+message+"&&original="+document.getElementById("from").value);
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
        if(confirm("Are you sure you would like to delete Node"+params.nodes)) {
            params.event = "[original event]";
            //var nodeId=JSON.stringify(params.nodes, null, 4);
            var nodeId = params.nodes;
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function () {

                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    var result = xmlhttp.responseText;
                    // alert(result);
                    if (result == "fail") {
                        alert("Cannot delete this node because one or more nodes rely on it");
                    }else if(result=="patternFail"){
                        alert("This connector node can not be deleted because there are still normal node(s) in its pattern");

                    } else if (result == "normalSuccess") {
                        nodes.remove({id: nodeId});
                        nodesArray=nodes;
                        //alert(document.getElementById("from"+nodeId));
                    } else if (result = "connectorSuccess") {
                      //  window.location.reload();
                        nodes.remove({id: nodeId});
                        nodesArray=nodes;
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
