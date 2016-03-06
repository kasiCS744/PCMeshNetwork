<?php
/**
 * Created by PhpStorm.
 * User: Liu
 * Date: 2016/2/10
 * Time: 18:30
 */
include_once "../dao/getNode.php";
include_once "../dao/getLink.php";
include_once "../dao/getSetting.php";
session_start();
$uid=$_SESSION['uid'];
if($uid==null){
    header("location:../Login.html");
}
$nodeResult=getAllNodes();
$linkResult=getAllLinks();
$startNodeList=getAllNodes();
$destinationNodeList=getAllNodes();
$reActivateNodeList=getAllNodes();

?>
<!doctype html>
<html>
<head>
<?php include_once "viewStructureHead.php";?>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#newPatternConnectors').multiselect();
            $('#newPatternConnectors').multiselect("disable");
            $('#existingNodeConnectors').multiselect();
            $('#existingNodeConnectors').multiselect("disable");            
            $('#inactiveNodeList').multiselect();
            $('#activeNodeList').multiselect();            
        });
    </script>
</head>
<body>
<?php include_once "viewStructureBody.php";?>
<div class="container" id="firstContainer" align="center">
    <div style="width: 60%" id="buttonSection" class="well bs-component">
        <input type="button" class="btn btn-success" value="send Message" onclick="displayDiv('sendMessage')">
        <input type="button" class="btn btn-info" value="reset Nodes" onclick="resetAllNodesStabilize()">
        <input type="button" class="btn btn-default" value="show Message Log" onclick="showMessages()">
        <input type="button" class="btn btn-success" value="show Message By Node ID" onclick="displaySingleNodeMessages()">
        <input type="button" class="btn btn-info" value="Re-Activate" onclick="displayActiveNodeDiv()">
        <input type="button" class="btn btn-warning" value="Add node" onclick="displayDiv('addNode')">
        <div style="display: none; position: absolute; border: 5px; left: 30%; top: 30%; z-index: 9; background:#e6f9ff; width: 40%" id="addNode" class="container">
            <form style="margin-top: 20px; margin-bottom: 20px" action="../ser/addNode.php" id="form" method="post" class="form-signin">
                <label id="newPatternLabel">Would you like to add the node to an existing pattern?</label>
                <select id="isConnector" name="isConnector" class="form-signin" onchange="enableDrop()">
                    <option disabled selected> -- select an option -- </option>
                    <option value="0">Yes</option>
                    <option value="1">No</option>
                </select>
                <br>
                <label id="patternLabel">Please select an existing pattern to connect with</label>
                <br>
                <select onchange="getNodesFromPattern()" disabled class="form-control" name="pid" id="existingPatternConnector">
                    <option disabled selected> -- select an option -- </option>
                        <?php while($row=mysql_fetch_array($nodeResult)) : ?>
                            <?php if($row['isConnector']==1)  {?>
                                <option value="<?php echo $row['pid'];?>"><?php echo $row['pid'];?></option>
                            <?php }?>
                        <?php endwhile; ?>
                        <?php $nodeResult = getAllNodesByPid();
                    ?>
                </select>
                <br>
                <label id="existingLabel">Please select one or more nodes from the pattern to connect with</label>
                <br>
                <select multiple="multiple" class="form-signin" name="nodes0[]" id="existingNodeConnectors"></select>
                <br>
                <label id="connectorLabel">Please select the connector node with which to connect</label>
                <br>
                <select multiple="multiple" class="form-signin" name="nodes1[]" id="newPatternConnectors">
                    <?php while($row=mysql_fetch_array($nodeResult)) : ?>
                        <?php if($row['isConnector']==1)  {?>
                            <option><?php echo $row['nid'];?></option>
                        <?php }?>
                    <?php endwhile; ?>
                    <?php $nodeResult = getAllNodesByPid(); ?>
                </select>
                <br>
                <br>
                <button class="btn btn-lg btn-primary" type="button" onclick="differentSubmit()">Add Node</button>
                <button class="btn btn-lg btn-warning" type="reset">Reset</button>            
            </form>
            <input type="button" class="btn btn-default" value="Hide" onclick="hideDiv('addNode')">
        </div>
    </div>
    <div style="display: none; position: absolute; left: 25%;top: 30%; z-index: 9;background:#e6f9ff;width: 50%" id="sendMessage" class="container">
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
    <div style="margin-bottom: 50px" align="center">
        <div style="width: 80%" id="mynetwork"></div>
    </div>
    <div style="display: none; position: absolute; left: 35%;top: 30%;z-index: 9;background: #e6f9ff;width: auto" id="messageDiv" class="container">
        <div id="showMessage"></div>
        <div align="right">
            <input type="button" class="btn btn-default" value="Hide" onclick="hideMessageDiv()" >
        </div>
    </div>
    <form action="#" method="post" id="sliderForm">
        <input id="sliderSetting" name="sliderSetting" value="<?php echo getSetting();?>" type="range" min="0" max="100" step="20" onchange="beforeInactivateNode()" />
        <div style="display: none">
            <select multiple="multiple" class="form-signin" name="activeNodes[]" id="activeNodeList">
                <?php while($row=mysql_fetch_array($activeNodes)) : ?>
                <?php if($row['isActive']=="yes")  {?>
                    <option><?php echo $row['nid'];?></option>
                <?php }?>
                <?php endwhile; ?>
            </select>
        </div> 
    </form>
    <div style="display: none;position: absolute;left: 35%;top: 30%;z-index: 9;background: #ffffff;width: auto" id="singleMessageDiv" class="container">
        Please select the Node:
        <select id="singleMessage" class="form-control">
        </select>
        <div align="right">
            <input type="button" value="Confirm" class="btn btn-submit" onclick="receivedMessages()">
            <input type="button" class="btn btn-default" value="Hide" onclick="hideDiv('singleMessageDiv')">
        </div>
    </div>
    <div style="display: none;position: absolute;left: 45%;top: 40%;z-index: 9; background: #ffffff;width: auto" id="activeNodeDiv" class="container">
        <h4> Please select a Node:</h4>
        <select id="activeNode" class="form-control">
        </select>
        <input type="button" class="btn btn-submit" value="submit" onclick="activeNode()">
        <input type="button" class="btn btn-default" value="Hide" onclick="hideDiv('activeNodeDiv')">
    </div>    
</div>
<script type="text/javascript">

    // create an array with nodes
    nodesArray= [
        <?php
        $point=-1;
            $pid=-1;
            $x=0;
            $y=0;
            $count=0;
            $remainder=0;
            $quotient=0;
        while($row=mysql_fetch_array($nodeResult)){?>
        <?php
        $color="";
        if($row['isConnector'] ==1)  {
            $color = "rgb(255,168,7)";
            if($row['isActive']=="no"){
                $color='gray';
            }
        }
        else  {
            $color = "#7BE141";
            if ($row['isActive'] == "no")  {
                $color = 'gray';
            }  
        }
        if($point!=$row['pid']){
            $count=0;
            $pid++;
            $point=$row['pid'];
            $remainder=$pid%4;
            $quotient=(int)($pid/4);
        }
        $x1=((int)($pid/4)%2*(-1)*15);
        switch($count){
        case 0:
            $x=120+300*$remainder+$x1;
            $y=70+300*$quotient+($pid%2*(-1)*15);
            $count++;
            break;
        case 1:
            $x=180+300*$remainder+$x1;
            $y=70+300*$quotient+($pid%2*(-1)*15);
            $count++;
            break;
        case 2:
            $x=60+300*$remainder+$x1;
            $y=140+300*$quotient+($pid%2*(-1)*15);
            $count++;
            break;
        case 3:
            $x=240+300*$remainder+$x1;
            $y=140+300*$quotient+($pid%2*(-1)*15);
            $count++;
            break;
        case 4:
            $x=120+300*$remainder+$x1;
            $y=210+300*$quotient+($pid%2*(-1)*15);
            $count++;
            break;
        case 5:
            $x=180+300*$remainder+$x1;
            $y=210+300*$quotient+($pid%2*(-1)*15);
            $count++;
            break;
        }?>
         {id: <?php echo $row['nid'];?>, label:'<?php echo "N".$row['nid']; if($row['isConnector']==1){echo ",P".$row['pid'];}?>', color: '<?php echo $color;?>',x:<?php echo $x;?>,y:<?php echo $y;?>},
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
        physics:false,
        nodes: {shape:'dot',borderWidth: 1,size:15,fixed:false},
        edges:{},
        interaction: {hover: true}
    };
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
    function activeNode(){
       // alert(1);
        var nid=document.getElementById("activeNode").value;

        if(nid==null||nid==undefined){
            return;
        }
        //alert(1);
        $.post("../ser/activeNodesByNid.php",{nid: nid},function(result){
            //alert(1);
            //alert(result);
            //result=eval(result);
            result=JSON.parse(result);
           // alert(result.isConnector);
            if(result.isConnector==1){
               // alert(1);
                nodes.update([{id: result.nid, color:"rgb(255,168,7)"}]);
            }else if(result.isConnector==0){
              //  alert(0);
                nodes.update([{id: result.nid, color:"#7BE141"}]);
            }

        });
    }
    function displaySingleNodeMessages(){
        document.getElementById('singleMessageDiv').style.display='block';
       // alert(1);
        $.post("../ser/getAllNodesId.php", function(result){
           // alert(result);
           // $("#div1").html(result);
            result=eval(result);
           // alert(document.getElementById("singleMessage").innerHTML);
            document.getElementById("singleMessage").innerHTML="";
            for(var i=0;i<result.length;i++){
               // alert(i);
                document.getElementById("singleMessage").innerHTML+="<option value='"+result[i]+"'>"+result[i]+"</option>";
            }
        });
    }
    function resetAllNodesStabilize() {
        resetAllNodes();
        // network.stabilize();
    }

    var global;
    var from;
    var to;
    var message;

    function postValue()  {

        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {

            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                result=xmlhttp.responseText;
                //alert(result);
            }
        };
        xmlhttp.open("POST", "/cs744/static/timerManagement.php", true);
        xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xmlhttp.send("sliderSetting="+document.getElementById('sliderSetting').value);     
    }
    function beforeSendMessage(start,end,messageContext){
        hideDiv("sendMessage");
        resetAllNodes();
        from=start;
        to=end;
        message=messageContext;
        global=setInterval("sendMessage()",1500);
    }
    function receivedMessages(){
        var nid=document.getElementById("singleMessage").value;
      //  alert(nid);
        $.post("../ser/getMessageByNid.php",{nid: nid},function(result){
          var string="";
            result=eval(result);
            for(var i=0;i<result.length;i++){
                string+=(i+1)+". "+result[i]+"\n";
            }
            if(string==""){
                alert("No message received for this node");
            }else {
                alert(string);
            }
        });
    }
    function displayActiveNodeDiv(){
        document.getElementById('activeNodeDiv').style.display='block';
        $.post("../ser/getInactiveNodes.php", function(result){
            // alert(result);
            // $("#div1").html(result);
            result=eval(result);
            // alert(document.getElementById("singleMessage").innerHTML);
            document.getElementById("activeNode").innerHTML="";
            for(var i=0;i<result.length;i++){
                // alert(i);
                document.getElementById("activeNode").innerHTML+="<option value='"+result[i]+"'>"+result[i]+"</option>";
            }
        });
    }
    function beforeInactivateNode(){
        setInterval("postValue()",10000);
    }

    // function reActivateNodes()  {

    //     if ($('#inactiveNodeList').val() == "NONE SELECTED")  {
    //         $.ajax({
    //             cache: true,
    //             type: "POST",
    //             url:"../ser/reActivateNode.php",
    //             data:$('#form2').serialize(),
    //             async: false,
    //             error: function(request) {
    //                 alert("Connection error");
    //             },
    //             success: function(data) {
    //                 window.location="Main.php";
    //             }
    //         });
    //     }
    //     else  {
    //         alert("Please select at least one node to re-activate");
    //     }
    // }
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
    function enableDrop(){
        if (document.getElementById("isConnector").value == "0")  {
            $('option', $('#newPatternConnectors')).each(function(element) {
                $(this).removeAttr('selected').prop('selected', false);
            });
            $('#newPatternConnectors').multiselect("refresh");
            $('#newPatternConnectors').multiselect("disable");
            document.getElementById("existingPatternConnector").disabled = false;
            $('#existingNodeConnectors').multiselect("enable");
        }
        else  {
            $('#newPatternConnectors').multiselect("enable");
            document.getElementById("existingPatternConnector").disabled = true;
            $('#existingPatternConnector').prop('selectedIndex',0);
            $('option', $('#existingNodeConnectors')).each(function(element) {
                $(this).removeAttr('selected').prop('selected', false);
            });
            $('#existingNodeConnectors').multiselect("refresh");
            $('#existingNodeConnectors').multiselect("disable");
        }
    }
    function differentSubmit(){
        if (document.getElementById("isConnector").value == "0")  {
            if ($('#existingPatternConnector').val() != null)  {
                if ($('#existingNodeConnectors').val() != null)  {
                    var numberOfConnectedNodes = $('#existingNodeConnectors').val().length
                    if (numberOfConnectedNodes <= 3)  {
                       // document.getElementById("form").submit();
                        $.ajax({
                            cache: true,
                            type: "POST",
                            url:"../ser/addNode.php",
                            data:$('#form').serialize(),// 你的formid
                            async: false,
                            error: function(request) {
                                alert("Connection error");
                            },
                            success: function(data) {
                                if(data!="success"){ alert(data);
                                }else{
                                    window.location="Main.php";
                                }
                                // $("#commonLayout_appcreshi").parent().html(data);
                            }
                        });
                        // alert("success");
                    }
                    else  {
                        alert("Please select at most three nodes to connect to");
                    }
                }
                else  {
                    alert("Please connect to at least one node in the pattern");
                }
            }
            else  {
                alert("Please enter a pattern to connect to");
            }
        }
        else if (document.getElementById("isConnector").value == "1")  {
            if ($('#newPatternConnectors').prop("options")[0] == undefined)  {
                $.ajax({
                    cache: true,
                    type: "POST",
                    url:"../ser/addFirstPattern.php",
                    data:$('#form').serialize(),
                    async: false,
                    error: function(request) {
                        alert("Connection error");
                    },
                    success: function(data) {
                       if(data!="success"){ alert(data);
                       }else{
                           window.location="Main.php";
                       }
                       // $("#commonLayout_appcreshi").parent().html(data);
                    }
                });                
            }
            else  {
                if ($('#newPatternConnectors').val() != null)  {
                $.ajax({
                    cache: true,
                    type: "POST",
                    url:"../ser/addNode.php",
                    data:$('#form').serialize(),// 你的formid
                    async: false,
                    error: function(request) {
                        alert("Connection error");
                    },
                    success: function(data) {
                       if(data!="success"){ alert(data);
                       }else{
                           window.location="Main.php";
                       }
                       // $("#commonLayout_appcreshi").parent().html(data);
                    }
                });
              //  document.getElementById("form").submit();
                // alert("success");
                }
                else  {
                    alert("Please select at least one connector node to be connected with");
                }
            }
        }
        else  {
            alert("Please select whether or not you would like to add a node to an existing pattern");
        }
        // document.getElementById("form").submit();
    }
    function getNodesFromPattern(){
        var patternID = document.getElementById('existingPatternConnector').value;
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function () {

            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                var result = xmlhttp.responseText;
                // alert(result);
                result=eval(result);
                document.getElementById("existingNodeConnectors").innerHTML = "";
                for (var i = 0; i < result.length; i++)  {
                    document.getElementById("existingNodeConnectors").innerHTML += "<option>"+result[i].nid+"</option>";
                }
                $('#existingNodeConnectors').multiselect("rebuild");
            }
        };
        xmlhttp.open("POST", "/cs744/ser/getNodes.php", true);
        xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xmlhttp.send("pid=" + patternID);
    }
</script>
<script src="../js/googleAnalytics.js"></script>
</body>
</html>
