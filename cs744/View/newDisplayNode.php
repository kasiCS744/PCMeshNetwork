<?php
/**
 * Created by PhpStorm.
 * User: Liu
 * Date: 2016/2/10
 * Time: 18:30
 */
session_start();
$uid=$_SESSION['uid'];
$errorMessage=null;
$errorMessage=$_GET['errorMessage'];
if($uid==null){
    header("location:../Login.html");
}
include_once "../dao/getUser.php";
$row=mysql_fetch_array(getUserByUid($uid));
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
    <link href="css/vis.css" rel="stylesheet" type="text/css" />
    <link href="../css/bootstrap.css" rel="stylesheet">
    <link href="../css/loginScreen.css" rel="stylesheet">
    <link href="../css/nodeDisplay.css" rel="stylesheet">
</head>
<body>
    <div class="navbar navbar-default navbar-fixed-top">
        <div class="container">
            <div class="navbar-header">
                <a class="navbar-brand" href="newDisplayNode.php">Home</a>
            </div>
            <u1 class="nav navbar-nav">
                <u1 class="nav navbar-nav">
                    <li>
                        <a href="Main.php">Add Node</a>
                    </li>
                </u1>
            </u1>
            <u1 class="nav navbar-nav navbar-right">
                <li>
                    <p class="navbar-text">Logged in as <?php echo "".$row['firstName']." ".$row['lastName'];?></p>
                </li>
                <li>
                    <a id="logout" href="../ser/logout.php"> Logout</a>
                </li>
            </u1>
        </div>
    </div>
    <div class="container" id="firstContainer" align="center">
        <div class="well bs-component">
            <button class="btn btn-success" type="button" onclick="displayDiv('sendMessage')">Send Message</button>
            <button class="btn btn-info" type="reset" onclick="resetAllNodesStabilize()">Reset Nodes</button>
            <div style="display: none" id="sendMessage">
                <div class="well bs-component" id="innerWell">
                    <form action="#" method="post" id="secondContainer" id="messageForm">
                        <label>Select a starting node</label>
                        <select class="form-control" id="from" onchange="displayDest('destLabel','to')">
                            <?php while($row=mysql_fetch_array($nodeResult)) : ?>
                                <option id="firstSelection"><?php echo $row['nid'];?></option>
                            <?php endwhile; ?>
                            <?php $nodeResult = getAllNodes(); ?>
                        </select>
                        <br>
                        <label id="destLabel" style="display: none">Select a destination node</label>
                        <select class="form-control" id="to" style="display: none" onchange="displayDest('messageLabel','messageContext')">
                            <?php while($row=mysql_fetch_array($nodeResult)) : ?>
                                <option><?php echo $row['nid'];?></option>
                            <?php endwhile; ?>
                            <?php $nodeResult = getAllNodes(); ?>
                        </select>
                        <br>
                            <p id="messageLabel" style="display: none">Message Context</p>
                        <br>
                        <label><textarea onchange="displayDiv('submitButton')" style="display: none" rows="4" cols="30" name="messageContext" id="messageContext"></textarea></label>
                        <br>
                        <button id="submitButton" style="display: none" class="btn btn-success" type="button" onclick="sendMessage('sendMessage', 'destLabel', 'to', 'messageLabel', 'messageContext', 'submitButton')">Submit</button>
                        <button class="btn btn-info" type="reset" onclick="hideDiv('sendMessage', 'destLabel', 'to', 'messageLabel', 'messageContext', 'submitButton') ">Hide</button>
                    </form>
                </div>    
            </div>
        </div>
    </div>
    <div class="container" id="thirdContainer" align="center">    
        <div id="mynetwork"></div>
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
        function resetAllNodesStabilize() {
            resetAllNodes();
            network.stabilize();
        }
        function sendMessage(id1, id2, id3, id4, id5, id6){
            resetAllNodesStabilize();
            var from=document.getElementById("from").value;
            var to=document.getElementById("to").value;
            var messageContext=document.getElementById("messageContext").value;
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {

                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    var result=xmlhttp.responseText;
                    result=eval(result);
                    if(result.length==0){
                        alert("No path is found");
                    }else {
                        for (var i = 0; i < result.length; i++) {
                            nodes.update([{id: result[i], color: {background: 'red'}}]);
                        }
                    }
                    document.getElementById("sendMessage").style.display="none";
                }
            };
            document.getElementById(id1).style.display="none";
            document.getElementById(id2).style.display="none";
            document.getElementById(id3).style.display="none";
            document.getElementById(id4).style.display="none";
            document.getElementById(id5).style.display="none";
            document.getElementById(id6).style.display="none";
            xmlhttp.open("POST", "/cs744/ser/sendMessage.php", true);
            xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xmlhttp.send("from="+from+"&&to="+to+"&&messageContext="+messageContext);
        }
        function displayDiv(id){
            document.getElementById(id).style.display="block";
        }
        function hideDiv(id1, id2, id3, id4, id5, id6){
            document.getElementById(id1).style.display="none";
            document.getElementById(id2).style.display="none";
            document.getElementById(id3).style.display="none";
            document.getElementById(id4).style.display="none";
            document.getElementById(id5).style.display="none";
            document.getElementById(id6).style.display="none";
        }
        function displayDest(id1, id2)  {
            document.getElementById(id1).style.display="block";
            document.getElementById(id2).style.display="block";
        }
        network.on("doubleClick", function (params) {
            if(params.nodes==""){
               return;
            }
            if(confirm("Are you sure you want to delete node "+params.nodes +"?")) {
                params.event = "[original event]";
                //var nodeId=JSON.stringify(params.nodes, null, 4);
                var nodeId = params.nodes;
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function () {

                    if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                        var result = xmlhttp.responseText;
                        // alert(result);
                        if (result == "fail") {
                            alert("You can not delete this node because it is associated with one or more nodes in its pattern!");
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
    <script src="../js/googleAnalytics.js"></script>
</body>
</html>
