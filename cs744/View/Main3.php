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
function getDomainNodesAndTheirPatternCounts(){
    $result=getAllDomainNodes();
    $list=array();

    while($row=mysql_fetch_array($result)){
        $tempList=array();
        $linksArray=getLinksArrayByNid($row['nid']);
        $count=0;
        foreach($linksArray as $key=>$value){
            if(!isDomainNode($value)){
                $count++;
            }
        }

        array_push($tempList,$row);
        array_push($tempList,$count);
        array_push($list,$tempList);

    }
    return $list;
}
$nodeResult=getAllNodes();
$linkResult=getAllLinks();
$startNodeList=getAllNullDomainNodesOrderByNid();
$destinationNodeList=getAllNullDomainNodesOrderByNid();
$reActivateNodeList=getAllNodes();

?>
<!doctype html>
<html>
<head>
<?php include_once "viewStructureHead.php";?>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#newDomain').multiselect();
            $('#newDomain').multiselect("disable");
            $('#nextNode').multiselect();
            $('#domains').multiselect();
            $('#domains').multiselect("disable");
            $('#existingNodeConnectors').multiselect();
            $('#existingNodeConnectors').multiselect("disable");            
            $('#inactiveNodeList').multiselect();
            $('#activeNodeList').multiselect();            
        });
    </script>
</head>
<?php include_once "viewStructureBody.php";?>
<div style="z-index: -1" class="container" id="firstContainer" align="center">
    <div style="margin: 0 auto" id="buttonSection" class="well bs-component">
        <input type="button" class="side-btn btn btn-danger" value="send Message" onclick="displayDiv('sendMessage')">
        <input type="button" class="side-btn btn btn-info" value="reset Nodes" onclick="resetAllNodesStabilize()">
        <input type="button" class="side-btn btn btn-warning" value="show Message Log" onclick="showMessages()">
        <input type="button" class="side-btn btn btn-success" value="show Message By Node ID" onclick="displaySingleNodeMessages()">
        <input type="button" class="side-btn btn btn-primary" value="Re-Activate" onclick="displayActiveNodeDiv()">
        <input type="button" class="side-btn btn btn-default" value="Add node" onclick="displayDiv('addNode')">
        <input type="button" class="side-btn btn btn-danger" value="Add edge(s)" onclick="readyNodes()">
        <br>
        <br>
        <label id="newPatternLabel">Inactivation Frequency</label>
        <form action="#" method="post" id="sliderForm">
            <input id="sliderSetting" name="sliderSetting" value="<?php echo getSetting();?>" type="range" min="0" max="100" step="20" onchange="postValue()" />
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
        <div id="addEdge" class="container">
            <form style="margin-top: 20px; margin-bottom: 20px" id="edgeForm" method="post" class="form-signin">
                <label id="startingNodes">Please select a node</label>
                <br>
                <select onchange="getRelatedNodes()" class="form-control" name="startNode" id="startNode">
                    <option disabled selected> -- select an option -- </option>
                </select>
                <div style="display: none" id="nextNodeDiv">
                    <br>
                    <label id="nextNodes">Please select a node(s) to connect with</label>
                    <br>
                    <select onchange="displayDiv('addEdgeDiv')" multiple="multiple" class="form-signin" name="nextNode[]" id="nextNode"></select>
                </div>
                <div style="display: none" id="addEdgeDiv">
                    <br>
                    <button class="btn btn-lg btn-primary" type="button" onclick="edgeSubmit()">Add Edge</button>
                    <button class="btn btn-lg btn-warning" type="reset">Reset</button>
                </div>
            </form>
            <input style="margin-bottom: 20px" type="button" class="btn btn-default" value="Hide" onclick="hideDiv('addEdge')">
        </div>
        <div id="addNode" class="container">
            <form style="margin-top: 20px; margin-bottom: 20px" action="../ser/addNode.php" id="form" method="post" class="form-signin">
                <label id="newDomainLabel">Would you like to create a new domain?</label>
                <br>
                <select id="isDomain" name="isDomain" class="form-signin" onchange="enableDomainDrop()">
                    <option disabled selected> -- select an option -- </option>
                    <option value="0">Yes</option>
                    <option value="1">No</option>
                </select>
                <br>
                <div style="display: none" id="domainDiv">
                    <label id="DomainLabel">Please select the domain(s) with which to connect</label>
                    <br>
                    <select onclick="getDomainNodes()" multiple="multiple" class="form-signin" name="domains[]" id="domains"></select>
                </div>
                <div style="display: none" id="existingPatternChoiceDiv">    
                    <br>
                    <label id="newPatternLabel">Would you like to create a new pattern?</label>
                    <br>
                    <select id="isConnector" name="isConnector" disabled class="form-signin" onchange="enableDrop()">
                        <option disabled selected> -- select an option -- </option>
                        <option value="0">Yes</option>
                        <option value="1">No</option>
                    </select>
                </div>
                <div style="display:none" id="patternDiv">
                    <br>
                    <label id="patternLabel">Please select an existing pattern to connect with</label>
                    <br>
                    <select onchange="getNodesFromPattern()" disabled class="form-control" name="pid" id="existingPatternConnector">
                        <option disabled selected> -- select an option -- </option>
<!--                            --><?php //while($row=mysql_fetch_array($nodeResult)) : ?>
<!--                                --><?php //if($row['isConnector']==1)  {?>
<!--                                    <option value="--><?php //echo $row['pid'];?><!--">--><?php //echo $row['pid'];?><!--</option>-->
<!--                                --><?php //}?>
<!--                            --><?php //endwhile; ?>
<!--                            --><?php //$nodeResult = getAllNodesByPid();
//                        ?>
                    </select>
                    <br>
                    <label id="existingLabel">Please select one or more nodes from the pattern to connect with</label>
                    <br>
                    <select multiple="multiple" class="form-signin" name="nodes0[]" id="existingNodeConnectors"></select>
                </div>
                <div style="display: none" id="connectorDiv">
                    <br>
                    <label id="patternLabel">Which domain would you like to add the pattern?</label>
                    <br>
                    <select onchange="getNodesFromDomain()" disabled class="form-control" name="did" id="existingDomain">
                        <option disabled selected> -- select an option -- </option>
                            <?php while($row=mysql_fetch_array($nodeResult)) : ?>
                                <?php if($row['isConnector']==2)  {?>
                                    <option value="<?php echo $row['did'];?>"><?php echo $row['did'];?></option>
                                <?php }?>
                            <?php endwhile; ?>
                            <?php $nodeResult = getAllNullDomainNodes();
                        ?>
                    </select>
                    <br>
                    <label id="domainLabel">Select any additional connector nodes in the domain to connect to?</label>
                    <br>
                    <select multiple="multiple" class="form-signin" name="nodes1[]" id="newDomain"></select>
                </div>
                <div style="display: none" id="addNodeDiv">
                    <br>
                    <button class="btn btn-lg btn-primary" type="button" onclick="differentSubmit()">Add Node</button>
                    <button class="btn btn-lg btn-warning" type="reset">Reset</button>
                </div>            
            </form>
            <input style="margin-bottom: 20px" type="button" class="btn btn-default" value="Hide" onclick="hideDiv('addNode')">
        </div>
    </div>
    <div id="sendMessage" class="container">
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
    <div style="margin-bottom: 50px; margin-left: 200px; width: 90%" align="center">
        <div style="width: 80%" id="mynetwork"></div>
    </div>
    <div id="messageDiv" class="container">
        <div style='overflow: auto; height: 400px' id="showMessage"></div>
        <div align="right">
            <input type="button" class="btn btn-default" value="Hide" onclick="hideMessageDiv()" >
        </div>
    </div>
    <div id="singleMessageDiv" class="container">
        Please select the Node:
        <select id="singleMessage" class="form-control" onchange="document.getElementById('singleMessageTable').innerHTML=''">
        </select>
        <div align="right">
            <table id="singleMessageTable" class='table table-bordered'></table>
            <input type="button" value="Confirm" class="btn btn-primary" onclick="receivedMessages()">

            <input type="button" class="btn btn-default" value="Hide" onclick="hideDiv('singleMessageDiv')">
        </div>
    </div>
    <div id="activeNodeDiv" class="container">
        <h4> Please select a Node:</h4>
        <select id="activeNode" class="form-control">
        </select>
        <input type="button" class="btn btn-primary" value="submit" onclick="activeNode()">
        <input type="button" class="btn btn-default" value="Hide" onclick="hideDiv('activeNodeDiv')">
    </div>    
</div>
<script type="text/javascript">

    $("#addEdge").draggable();
    $("#addEdge").resizable();
    $("#addNode").draggable();
    $("#addNode").resizable();
    $("#sendMessage").draggable();
    $("#sendMessage").resizable();
    $("#messageDiv").draggable();
    $("#messageDiv").resizable();
    $("#singleMessageDiv").draggable();
    $("#singleMessageDiv").resizable();
    $("#activeNodeDiv").draggable();
    $("#activeNodeDiv").resizable();

   // var blockedMessages;
    setInterval("getNewestData()",5000);

    // create an array with nodes
    nodesArray= [
        <?php
        $list=getDomainNodesAndTheirPatternCounts();
        $pointer=0;
        foreach($list as $key=>$value){
            $domainColor="blue";
             if($value[0]['isActive']=="no"){
                $domainColor="gray";
            }
        ?>
        {id: <?php echo $value[0]['nid'];?>, label:'D<?php echo $value[0]['did']; echo ",N".$value[0]['nid']?>', shape:'diamond',color: '<?php echo $domainColor;?>',x:<?php echo ($pointer%4)*300;?>,y:<?php echo ((int)($pointer/4))*300;?>},
    <?php
    $pointer+=$value[1];
        }
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
         {id: <?php echo $row['nid'];?>, label:'<?php if($row['isConnector']==1){echo "P".$row['pid'].",";}echo "N".$row['nid']; ?>', color: '<?php echo $color;?>',x:<?php echo $x;?>,y:<?php echo $y;?>},
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
            {from: <?php echo $row['nid1'];?>,to:<?php echo $row['nid2'];?>,color:'black'},
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
    function reSet(){

        for(var i=0;i<nodes.length;i++){
            // alert(1);
            //alert(nodes.get(nodesArray[i].id).color.toString());
            if(nodes.get(nodesArray[i].id).color.toString()!="red"){
                nodesArray[i].color=nodes.get(nodesArray[i].id).color;
            }
        }
    }
   var blockedMessages=new Array();
   var a=true;
   var resendCount=0;
   var sendList=new Array();
    function resetAllNodes() {
        //location.reload();
        for(var i=0;i<nodesArray.length;i++){
            //alert(nodesArray[i]);
            nodes.update(nodesArray[i]);
        }
       // nodes=nodesArray;
    }
   function readyNodes()  {
       document.getElementById('addEdge').style.display='block';
       $.post("../ser/getAllNodes.php", function(result){
           result=eval(result);
           document.getElementById("startNode").innerHTML="";
           document.getElementById("startNode").innerHTML += "<option disabled selected> -- select an option -- </option>";
           for(var i=0;i<result.length;i++){
               document.getElementById("startNode").innerHTML+="<option value='"+result[i]+"'>"+result[i]+"</option>";
           }
       });
   }
   function edgeSubmit()  {
       $.ajax({
           cache: true,
           type: "POST",
           url:"../ser/addEdge.php",
           data:$('#edgeForm').serialize(),
           async: false,
           error: function(request) {
               alert("Connection error");
           },
           success: function(data) {
               if(data!="success"){ alert(data);
               }else{
                   window.location="Main.php";
               }
           }
       });
   }
   function getRelatedNodes()  {
        document.getElementById("addEdge").style.height = "45%";
       displayDiv('nextNodeDiv');
       hideDiv('addEdgeDiv');
       var nodeID = document.getElementById('startNode').value;
       var xmlhttp = new XMLHttpRequest();
       xmlhttp.onreadystatechange = function () {

           if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
               var result = xmlhttp.responseText;
               //alert(result);
               result=eval(result);
               document.getElementById("nextNode").innerHTML = "";
               for (var i = 0; i < result.length; i++)  {
                   document.getElementById("nextNode").innerHTML += "<option>"+result[i].nid+"</option>";
               }
               $('#nextNode').multiselect("rebuild");
           }
       };
       xmlhttp.open("POST", "/cs744/ser/getRelatedNodes.php", true);
       xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
       xmlhttp.send("startNode=" + nodeID);
   }
    function hideMessageDiv(){
        document.getElementById('messageDiv').style.display='none';
    }
   function checkHasBlockedMessages(nid){
       for(var i=0;i<blockedMessages.length;i++){
           if(blockedMessages[i][1]==nid){
               return true;
           }
       }
       return false;
   }
   function sleep(){

   }

   function resendMessage(nid){
       //alert(1);
       resendCount=0;
       sendList=new Array();
       //alert(blockedMessages.length);
       for(var i=0;i<blockedMessages.length;i++){
           if(blockedMessages[i][1]==nid){
               sendList.push(blockedMessages[i]);
           }
       }
       a=false;
       beforeSendMessage(sendList[resendCount][0],sendList[resendCount][2],sendList[resendCount][3]);
      // var length=sendList.length;
       //alert(length);
     //  alert(sendList[count][0]+sendList[count][2]+sendList[count][3]+a);
//       while(count<length){
//           if(a==true){
//
//               a=false;
//               count++;
//           }else{
//               setTimeout("sleep()",1500);
//           }
//       }

   }
    function activeNode(){
       // alert(1);
        var nid=document.getElementById("activeNode").value;

        if(nid==null||nid==undefined){
            return;
        }
        //alert(1);
        $.post("../ser/activeNodesByNid.php",{nid: nid},function(result){
            result=JSON.parse(result);
          //  alert(result.nid);
            if(result.isConnector==1){
               // alert(1);
                nodes.update([{id: result.nid, color:"rgb(255,168,7)"}]);
            }else if(result.isConnector==0){
              //  alert(0);
                nodes.update([{id: result.nid, color:"#7BE141"}]);
            }else if(result.isConnector==2){
                 nodes.update([{id: result.nid, color:"blue"}]);
            }
            reSet();
            if(checkHasBlockedMessages(result.nid)){
                document.getElementById("activeNodeDiv").style.display="none";
                setTimeout("resendMessage("+result.nid+")",0);
            }

        });
        displayActiveNodeDiv();
        //document.refresh($("#activeNode"));
        $("#activeNode").show();


    }
    function displaySingleNodeMessages(){
        document.getElementById('singleMessageDiv').style.display='block';
        document.getElementById('singleMessageTable').innerHTML="";
       // alert(1);
        $.post("../ser/getAllNodesId.php", function(result){
            result=eval(result);
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
    function checkResend(){
        if(a==false){
          //  var point;
            for(var i=0;i<blockedMessages.length;i++){
                if(blockedMessages[i][0]==sendList[resendCount][0]&&blockedMessages[i][2]==sendList[resendCount][2]&&blockedMessages[i][3]==sendList[resendCount][3]){
                    blockedMessages.splice(i,1);
                    break;
                }
            }
            resendCount++;
            if(resendCount<sendList.length){
                beforeSendMessage(sendList[resendCount][0],sendList[resendCount][2],sendList[resendCount][3])
            }else{
                resendCount=0;
                sendList=new Array();
                a=true;
            }
        }
    }
    function getNewestData()  {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {

            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                result=xmlhttp.responseText;
                result = eval(result);
                for (var i =0; i < result.length; i++)  {
                    nodes.update([{id: result[i], color:"gray"}]);
                }
                reSet();
            }
        };
        xmlhttp.open("POST", "/cs744/ser/getInactiveNodes.php", true);
        xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xmlhttp.send();  
    }
    function postValue()  {

        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {

            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                result=xmlhttp.responseText;
                //alert(result);
            }
        };
        xmlhttp.open("POST", "/cs744/ser/updateSlider.php", true);
        xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xmlhttp.send("sliderSetting="+document.getElementById('sliderSetting').value);     
    }
    function beforeSendMessage(start,end,messageContext){
       // alert(messageContext);
        hideDiv("sendMessage");
        resetAllNodes();
        //resetAllNodesStabilize();
        from=start;
        to=end;
        message=messageContext;
        //alert(message);
        flag=0;
//        alert(from+to);
        //  alert(from);
        $.ajax({url:'../ser/checkInactiveNodeByNid.php',data:{from:from,fnid:from},async:true,type:'post',
            success:function(result){
                if(result=="inactive"){
                    alert("Can not send message because it is not activate");
                    checkResend();
                }else{
                    $.ajax({url:'../ser/newSendMessage2.php',
                        data:{from:from,to:to,type:'first',message:message},
                        async:false,
                        type:'POST',
                        success:function(result){
                            //  alert(result);
                            if(result=="received"){
                                nodes.update([{id: from, color: 'red'}]);
                                alert(result);
                                checkResend();
                            }else {
                               // alert(message);
                                path = eval(result);
                                nodes.update([{id: from, color: 'red'}]);
                                //  alert(path[0]);
                                //sendMessage();
                                global = setInterval("sendMessage()", 1500);
                            }
                        }});

                }
            }});

    }
    function receivedMessages(){
        var nid=document.getElementById("singleMessage").value;
      //  alert(nid);
        $.post("../ser/getMessageByNid.php",{nid: nid},function(result){
          var string="";
            result=eval(result);
            document.getElementById("singleMessageTable").innerHTML="<tr><th>No.</th><th>Message</th><th>State</th><th>Destination<br>(If blocked)</th></tr>";
            for(var i=0;i<result.length;i++){
                document.getElementById("singleMessageTable").innerHTML+="<tr><td>"+(i+1)+"</td><td>"+result[i]+"</td><td>Received</td><td></td></tr>";
                //string+=(i+1)+". "+result[i]+"\n";
            }
            for(i=0;i<blockedMessages.length;i++){
                if(blockedMessages[i][0]==nid){
                    document.getElementById("singleMessageTable").innerHTML+="<tr><td>"+(i+1+result.length)+"</td><td>"+blockedMessages[i][3]+"</td><td>Blocked</td><td>"+blockedMessages[i][2]+"</td></tr>";
                }
            }
//            if(string==""){
//                alert("No message received for this node");
//            }else {
//                alert(string);
//            }
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

    function showMessages(){
        var xmlhttp = new XMLHttpRequest();
        var result="";
        xmlhttp.onreadystatechange = function() {

            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
               result=eval(xmlhttp.responseText);
                var table="<table class='table table-bordered'><thead><tr style='border: 3px solid black'><td style='border: 3px solid black'>Start Node</td><td style='border: 3px solid black'>End Node</td><td style='border: 3px solid black'>MessageContext</td><td style='border: 3px solid black'>State</td></tr></thead>";
                for(var i=0;i<result.length;i++){
                    table+="<tr style='border: 3px solid black'><td style='border: 3px solid black'>";
                    table+="Node"+result[i].nid+"</td><td style='border: 3px solid black'>";
                    table+="Node"+result[i].destination+"</td><td style='border: 3px solid black'>";
                    table+=result[i].messageContext+"</td><td style='border: 3px solid black'>";
                    table+=result[i].state;
                    table+="</td></tr>";
                }
                table+="</table>";
                //alert(table);
                document.getElementById("showMessage").innerHTML=table;
                document.getElementById("messageDiv").style.display="block";
            }
        };
        xmlhttp.open("POST", "/cs744/ser/messageList.php", false);
        xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xmlhttp.send();

    }
    function sendMessage(){
        var next=path[path.length-2-flag];
      //  alert(message);
        // alert(next);
        $.ajax({
            url: '../ser/checkInactiveNodeByNid.php', data: {from:path[path.length-1-flag],nid: next}, async: false, type: 'post',
            success:function(result){
                //  alert(result);
                if(result=="active"){
                    //   alert(to+"xxx"+next);
                    if(next==to){
                        nodes.update([{id: next, color: 'red'}]);
                        $.ajax({url:'../ser/newSendMessage2.php',
                            data:{from:from,to:to,type:'third',message:message},
                            type:'POST',
                            success:function(result){
                                alert("Received");
                                checkResend();
                            }});
                        clearInterval(global);
                    }else {
                        nodes.update([{id: next, color: 'red'}]);
                        flag++;
                    }
                }else{
                    $.ajax({url:'../ser/newSendMessage2.php',
                        data:{from:path[path.length-1-flag],to:to,type:'second',message:message},
                        async:false,
                        type:'POST',
                        success:function(result){
                            //  alert(result);
                            if(result=="blocked"){
                                var m=[path[path.length-1-flag],path[path.length-2-flag],to,message];
                                blockedMessages.push(m);
                                alert("Blocked at Node"+path[path.length-1-flag]);
                             //   alert(m);
                                checkResend();
                              //  alert(blockedMessages[blockedMessages.length-1][1]);
                                clearInterval(global);
                            }else if(result=="messageLost"){
                                alert("Destination node is deleted, message lost");
                                clearInterval(global);
                            }
                            else {
                                // alert(x);
                                path = eval(result);
                                flag = 0;
                            }
                            //  nodes.update([{id: from, color: {background: 'red'}}]);
                            //  alert(path[0]);
                            //  sendMessage();
                            //   global=setInterval("sendMessage()",1500);
                        }});
                }
            }
        });
    }
    function displayDiv(id){
        if(id!="sendMessage") {
            document.getElementById(id).style.display = "block";
        }else{
            if(a==true){
                document.getElementById(id).style.display = "block";
            }
        }
    }
    function hideDiv(id){
        if (id == "addEdge")  {
            $('option', $('#nextNode')).each(function(element) {
                $(this).removeAttr('selected').prop('selected', false);
            });
            $('#nextNode').multiselect("refresh");
        }
        document.getElementById(id).style.display="none";
    }
    network.on("doubleClick", function (params) {
        if(params.nodes==""){
            if(params.edges!=null){
                if(confirm("Are you sure you would like to delete an edge")) {
                    var tempnodes = network.getConnectedNodes(params.edges);                    

                    $.ajax({
                        cache: true,
                        type: "POST",
                        url:"../ser/deleteEdge.php",
                        data:{node1:tempnodes[0], node2:tempnodes[1]},
                        async: false,
                        error: function(request) {
                            alert("delete error");
                        },
                        success: function(data) {
                            if(data=="failed"){ 
                                alert("cannot delete this edge, because one or more nodes rely on it");
                            }else{
                                edges.remove(params.edges);
                            }
                        }    
                    });
                } 
            }    
        }else{
            if(confirm("Are you sure you would like to delete Node"+params.nodes)) {
            params.event = "[original event]";
            //var nodeId=JSON.stringify(params.nodes, null, 4);
            var nodeId = params.nodes;
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function () {

                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    var result = xmlhttp.responseText;
                   //  alert(result);
                    if (result == "fail") {
                        alert("Cannot delete this node because one or more nodes rely on it");
                    }else if(result=="patternFail"){
                        alert("This connector node can not be deleted because there are still normal node(s) in its pattern");

                    } else if (result == "normalSuccess") {
                        nodes.remove({id: nodeId});
                        nodesArray=nodes;
                        //alert(document.getElementById("from"+nodeId));
                    } else if (result == "connectorSuccess") {
                      //  window.location.reload();
                        nodes.remove({id: nodeId});
                        nodesArray=nodes;
                    }else if(result=="domainFail"){
                          //  alert(1);
                        alert("Can not delete a domain node directly");
                    }else{
                        nodes.remove({id: nodeId});
                        nodes.remove({id: result});
                        nodesArray=nodes;

                    }

                }
            };
            xmlhttp.open("POST", "/cs744/ser/deleteNode.php", true);
            xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xmlhttp.send("nid=" + nodeId);
        }
        }

        
        // alert(nodeId);
        // document.getElementById('eventSpan').innerHTML = '<h2>doubleClick event:</h2>' + JSON.stringify(params, null, 4);
    });
    function enableDrop(){

        document.getElementById("addNode").style.height = "80%";    
        if (document.getElementById("isConnector").value == "1")  {
            document.getElementById("existingPatternConnector").disabled = false;

            document.getElementById("existingDomain").disabled = true;
            $('#existingDomain').prop('selectedIndex',0);

            $('#existingNodeConnectors').multiselect("enable");

            $('option', $('#newDomain')).each(function(element) {
                $(this).removeAttr('selected').prop('selected', false);
            });
            $('#newDomain').multiselect("refresh");
            $('#newDomain').multiselect("disable");

            displayDiv('patternDiv');
            displayDiv('addNodeDiv');
            hideDiv('connectorDiv');
            getExistingPattern();
        }
        else  {
            document.getElementById("existingPatternConnector").disabled = true;
            $('#existingPatternConnector').prop('selectedIndex',0);

            document.getElementById("existingDomain").disabled = false;

            $('option', $('#existingNodeConnectors')).each(function(element) {
                $(this).removeAttr('selected').prop('selected', false);
            });
            $('#existingNodeConnectors').multiselect("refresh");
            $('#existingNodeConnectors').multiselect("disable");

            $('#newDomain').multiselect("enable");

            displayDiv('connectorDiv');
            displayDiv('addNodeDiv');           
            hideDiv('patternDiv');
        }
    }
    function enableDomainDrop(){
        document.getElementById("addNode").style.height= "50%";
        if (document.getElementById("isDomain").value == "0")  {
            document.getElementById("existingPatternConnector").disabled = true;
            $('#existingPatternConnector').prop('selectedIndex',0);

            $('option', $('#existingNodeConnectors')).each(function(element) {
                $(this).removeAttr('selected').prop('selected', false);
            });
            $('#existingNodeConnectors').multiselect("refresh");
            $('#existingNodeConnectors').multiselect("disable");

            $('#isConnector').prop('selectedIndex',0);
            document.getElementById("isConnector").disabled = true;

            $('#domains').multiselect("enable");

            displayDiv('addNodeDiv');
            displayDiv('domainDiv');
            hideDiv('existingPatternChoiceDiv');            
            hideDiv('connectorDiv');
            hideDiv('patternDiv');

            getDomainNodes();
        }
        else  {
            $('option', $('#domains')).each(function(element) {
                $(this).removeAttr('selected').prop('selected', false);
            });
            $('#domains').multiselect("refresh");
            $('#domains').multiselect("disable");

            hideDiv('domainDiv');
            hideDiv('connectorDiv');
            hideDiv('patternDiv');
            displayDiv('addNodeDiv');
            displayDiv('existingPatternChoiceDiv');

            allowNodeSelection();            
        }
    }
    function differentSubmit(){
        if (document.getElementById("isDomain").value == "1")  {
            if (document.getElementById("isConnector").value == "1")  {
                if ($('#existingPatternConnector').val() != null)  {
                    if ($('#existingNodeConnectors').val() != null)  {
                        var numberOfConnectedNodes = $('#existingNodeConnectors').val().length;
                        if (numberOfConnectedNodes <= 3)  {
                            $.ajax({
                                cache: true,
                                type: "POST",
                                url:"../ser/addNode.php",
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
                                }
                            });
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
            else if (document.getElementById("isConnector").value == "0")  {
                if ($('#existingDomain').val() != null)  {
                    $.ajax({
                        cache: true,
                        type: "POST",
                        url:"../ser/addPattern.php",
                        data:$('#form').serialize(),
                        async: false,
                        error: function(request) {
                            alert("Connection error");
                        },
                        success: function(data) {
                            window.location="Main.php";
                        }
                    });
                }
                else  {
                    alert("Please select a domain to add the pattern");
                }
            }
            else  {
                alert("Please select whether or not you would like to add a node to an existing pattern");
            }
        }
        else if (document.getElementById("isDomain").value == "0")  {
            if ($('#domains').prop("options")[0] == undefined)  {
                $.ajax({
                    cache: true,
                    type: "POST",
                    url:"../ser/addFirstDomain.php",
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
                    }
                });                
            }
            else  {
                if ($('#domains').val() != null)  {
                    $.ajax({
                        cache: true,
                        type: "POST",
                        url:"../ser/addDomain.php",
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
                        }
                    });
                }
                else  {
                    alert("Please select at least one domain to be connected with");
                }
            }                
        }
        else  {
            alert("Please select whether or not you would like to add a node to an existing domain");
        }
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
   function getExistingPattern()  {
       var xmlhttp = new XMLHttpRequest();
       xmlhttp.onreadystatechange = function () {

           if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
               var result = xmlhttp.responseText;
               // alert(result);
               result=eval(result);
               document.getElementById("existingPatternConnector").innerHTML = "";
               document.getElementById("existingPatternConnector").innerHTML += "<option disabled selected> -- select an option -- </option>";
               for (var i = 0; i < result.length; i++)  {
                   document.getElementById("existingPatternConnector").innerHTML += "<option>"+result[i].pid+"</option>";
               }
               //$('#existingPatternConnector').multiselect("rebuild");
           }
       };
       xmlhttp.open("POST", "/cs744/ser/getPatterns.php", true);
       xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
       xmlhttp.send("");
   }
    function getNodesFromDomain(){
        var patternID = document.getElementById('existingDomain').value;
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function () {

            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                var result = xmlhttp.responseText;
                // alert(result);
                result=eval(result);
                document.getElementById("newDomain").innerHTML = "";
                for (var i = 0; i < result.length; i++)  {
                    document.getElementById("newDomain").innerHTML += "<option>"+result[i].nid+"</option>";
                }
                $('#newDomain').multiselect("rebuild");
            }
        };
        xmlhttp.open("POST", "/cs744/ser/getDomains.php", true);
        xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xmlhttp.send("did=" + patternID);
    }
    function getDomainNodes(){
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function () {

            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                var result = xmlhttp.responseText;
                // alert(result);
                result=eval(result);
                document.getElementById("domains").innerHTML = "";
                for (var i = 0; i < result.length; i++)  {
                    document.getElementById("domains").innerHTML += "<option>"+result[i].nid+"</option>";
                }
                $('#domains').multiselect("rebuild");
            }
        };
        xmlhttp.open("POST", "/cs744/ser/getDomainsInit.php", true);
        xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xmlhttp.send("");
    }
    function allowNodeSelection(){
        document.getElementById("isConnector").disabled = false;
    }
</script>
<script src="../js/googleAnalytics.js"></script>
</body>
</html>
