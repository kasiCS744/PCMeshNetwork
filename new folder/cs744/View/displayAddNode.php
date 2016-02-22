<?php
///**
// * Created by PhpStorm.
// * User: Liu
// * Date: 2016/2/9
// * Time: 1:06
// */
//session_start();
//$uid=$_SESSION['uid'];
//if($uid==null){
//    header("location:../Login.html");
//}
//include_once "../dao/getUser.php";
//include_once "../dao/getNode.php";
//$row=mysql_fetch_array(getUserByUid($uid));
//$nodeResult=getAllNodes();
//?>
<!--<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">-->
<!--<html>-->
<!--<head>-->
<!--    <meta charset="utf-8">-->
<!--    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>-->
<!--    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>-->
<!--    <link href="../css/bootstrap.css" rel="stylesheet">-->
<!--    <link href="../css/loginScreen.css" rel="stylesheet">-->
<!--    <link href="../css/addNode.css" rel="stylesheet">-->
<!--    <link rel="stylesheet" href="../css/bootstrap-multiselect.css" type="text/css">-->
<!--    <script type="text/javascript" src="../js/bootstrap-multiselect.js"></script>-->
<!---->
<!--    <script type="text/javascript">-->
<!--        $(document).ready(function() {-->
<!--            $('#newPatternConnectors').multiselect();-->
<!--            $('#newPatternConnectors').multiselect("disable");-->
<!--            $('#existingNodeConnectors').multiselect();-->
<!--            $('#existingNodeConnectors').multiselect("disable");-->
<!--        });-->
<!--    </script>-->
<!--</head>-->
<!--<body>-->
<?php //include_once "viewStructureBody.php";?>
<!--    <div id="nodeContainer" class="container" align="center">-->
<!--        <div class="well bs-component">-->
<!--            <form action="../ser/addNode.php" id="form" method="post" class="form-signin">-->
<!--                <label id="newPatternLabel">Would you like to add the node to an existing pattern?</label>-->
<!--                <select id="isConnector" class="form-signin" onchange="enableDrop()">-->
<!--                    <option disabled selected> -- select an option -- </option>-->
<!--                    <option>Yes</option>-->
<!--                    <option>No</option>-->
<!--                </select>-->
<!--                <br>-->
<!--                <label id="patternLabel">Please select an existing pattern to connect with</label>-->
<!--                <br>-->
<!--                <select onchange="getNodesFromPattern()" disabled class="form-control" name="pid" id="existingPatternConnector">-->
<!--                <option disabled selected> -- select an option -- </option>-->
<!--                    --><?php //while($row=mysql_fetch_array($nodeResult)) : ?>
<!--                        --><?php //if($row['isConnector']==1)  {?>
<!--                            <option value="--><?php //echo $row['pid'];?><!--">--><?php //echo $row['pid'];?><!--</option>-->
<!--                        --><?php //}?>
<!--                    --><?php //endwhile; ?>
<!--                    --><?php //$nodeResult = getAllNodes();
//                    ?>
<!--                </select>-->
<!--                <br>-->
<!--                <label id="existingLabel">Please select one or more nodes from the pattern to connect with</label>-->
<!--                <br>-->
<!--                <select multiple="multiple" class="form-signin" name="nodes0[]" id="existingNodeConnectors"></select>-->
<!--                <br>-->
<!--                <label id="connectorLabel">Please select the connector node with which to connect</label>-->
<!--                <br>-->
<!--                <select multiple="multiple" class="form-signin" name="nodes1[]" id="newPatternConnectors">-->
<!--                    --><?php //while($row=mysql_fetch_array($nodeResult)) : ?>
<!--                        --><?php //if($row['isConnector']==1)  {?>
<!--                            <option value="--><?php //echo $row['nid'];?><!--">--><?php //echo $row['nid'];?><!--</option>-->
<!--                        --><?php //}?>
<!--                    --><?php //endwhile; ?>
<!--                    --><?php//// $nodeResult = getAllNodes(); ?>
<!--                </select>-->
<!--                <br>-->
<!--                <br>-->
<!--                <input type="button" value="Submit" onclick="differentSubmit()">-->
<!--                <input type="reset" value="Clear">-->
<!--            </form>-->
<!--        </div>-->
<!--    </div>-->
<!--</body>-->
<!--<script type="text/javascript">-->
<!--    function enableDrop(){-->
<!--        if (document.getElementById("isConnector").value == "Yes")  {-->
<!--            $('option', $('#newPatternConnectors')).each(function(element) {-->
<!--                $(this).removeAttr('selected').prop('selected', false);-->
<!--            });-->
<!--            $('#newPatternConnectors').multiselect("refresh");-->
<!--            $('#newPatternConnectors').multiselect("disable");-->
<!--            document.getElementById("existingPatternConnector").disabled = false;-->
<!--            $('#existingNodeConnectors').multiselect("enable");-->
<!--        }-->
<!--        else  {-->
<!--            $('#newPatternConnectors').multiselect("enable");-->
<!--            document.getElementById("existingPatternConnector").disable = true;-->
<!--            $('#existingPatternConnector').prop('selectedIndex',0);-->
<!--            $('option', $('#existingNodeConnectors')).each(function(element) {-->
<!--                $(this).removeAttr('selected').prop('selected', false);-->
<!--            });-->
<!--            $('#existingNodeConnectors').multiselect("refresh");-->
<!--            $('#existingNodeConnectors').multiselect("disable");-->
<!--        }-->
<!--    }-->
<!--    function differentSubmit(){-->
<!--        if ($('#existingPatternConnector').val() != null)  {-->
<!--            if ($('#existingNodeConnectors').val() != null)  {-->
<!--                var numberOfConnectedNodes = $('#existingNodeConnectors').val().length;-->
<!--                if (numberOfConnectedNodes <= 3)  {-->
<!--                    //alert("success");-->
<!--                    document.getElementById("form").submit();-->
<!--                }-->
<!--                else  {-->
<!--                    alert("Please select at most three nodes to connect to");-->
<!--                }-->
<!--            }-->
<!--            else  {-->
<!--                alert("Please connect to at least one node in the pattern");-->
<!--            }-->
<!--        }-->
<!--        else  {-->
<!--            alert("Please enter a pattern to connect to");-->
<!--        }-->
<!---->
<!--        // document.getElementById("form").submit();-->
<!--    }-->
<!--    function getNodesFromPattern(){-->
<!--        var patternID = document.getElementById('existingPatternConnector').value;-->
<!--            var xmlhttp = new XMLHttpRequest();-->
<!--            xmlhttp.onreadystatechange = function () {-->
<!---->
<!--                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {-->
<!--                    var result = xmlhttp.responseText;-->
<!--                    // alert(result);-->
<!--                    result=eval(result);-->
<!--                    document.getElementById("existingNodeConnectors").innerHTML = "";-->
<!--                    for (var i = 0; i < result.length; i++)  {-->
<!--                        document.getElementById("existingNodeConnectors").innerHTML += "<option value='"+result[i].nid+"'>"+result[i].nid+"</option>";-->
<!--                    }-->
<!--                    $('#existingNodeConnectors').multiselect("rebuild");-->
<!--                }-->
<!--            };-->
<!--            xmlhttp.open("POST", "/cs744/ser/getNodes.php", true);-->
<!--            xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");-->
<!--            xmlhttp.send("pid=" + patternID);-->
<!--    }-->
<!--</script>-->
<!--</html>-->
<?php
/**
 * Created by PhpStorm.
 * User: Liu
 * Date: 2016/2/9
 * Time: 1:06
 */
session_start();
$uid=$_SESSION['uid'];
if($uid==null){
    header("location:../Login.html");
}
include_once "../dao/getUser.php";
include "../dao/getNode.php";
$row=mysql_fetch_array(getUserByUid($uid));
$nodeResult=getAllNodes();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
    <meta charset="utf-8">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <link href="../css/bootstrap.css" rel="stylesheet">
    <link href="../css/loginScreen.css" rel="stylesheet">
    <link href="../css/addNode.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/bootstrap-multiselect.css" type="text/css">
    <script type="text/javascript" src="../js/bootstrap-multiselect.js"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#newPatternConnectors').multiselect();
            $('#newPatternConnectors').multiselect("disable");
            $('#existingNodeConnectors').multiselect();
            $('#existingNodeConnectors').multiselect("disable");
        });
    </script>
</head>
<body>
<?php include_once "viewStructureBody.php" ?>
<!--<div class="navbar navbar-default navbar-fixed-top">-->
<!--    <div class="container">-->
<!--        <div class="navbar-header">-->
<!--            <a class="navbar-brand" href="Main.php">Home</a>-->
<!--        </div>-->
<!--        <u1 class="nav navbar-nav">-->
<!--            <u1 class="nav navbar-nav">-->
<!--                <li>-->
<!--                    <a href="displayAddNode.php">Add Node</a>-->
<!--                </li>-->
<!--            </u1>-->
<!--        </u1>-->
<!--        <u1 class="nav navbar-nav navbar-right">-->
<!--            <li>-->
<!--                <p class="navbar-text">Logged in as --><?php //echo "".$row['firstName']." ".$row['lastName'];?><!--</p>-->
<!--            </li>-->
<!--            <li>-->
<!--                <a id="logout" href="../ser/logout.php"> Logout</a>-->
<!--            </li>-->
<!--        </u1>-->
<!--    </div>-->
<!--</div>-->
<div id="nodeContainer" class="container" align="center">
    <div class="well bs-component">
        <form action="../ser/addNode.php" id="form" method="post" class="form-signin">
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
                <?php $nodeResult = getAllNodes();
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
                <?php $nodeResult = getAllNodes(); ?>
            </select>
            <br>
            <br>
            <input type="button" value="Submit" onclick="differentSubmit()">
            <input type="reset" value="Clear">
        </form>
    </div>
</div>
</body>
<script type="text/javascript">
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
            document.getElementById("existingPatternConnector").disable = true;
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
</html>