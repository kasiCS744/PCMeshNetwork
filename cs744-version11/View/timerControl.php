<?php
/**
 * Created by PhpStorm.
 * User: Liu
 * Date: 2016/2/10
 * Time: 18:30
 */
include_once "../dao/getNode.php";

ignore_user_abort(true);
set_time_limit(0);

$activeNodes=getAllNodes();

?>
<!doctype html>
<html>
<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="../css/bootstrap-multiselect.css" type="text/css">
<script type="text/javascript" src="../js/bootstrap-multiselect.js"></script>
<?php include_once "viewStructureHead.php";?>

<script type="text/javascript">
    $(document).ready(function() {
        $('#activeNodeList').multiselect();
    }); 
</script>

</head>
<body>
<?php include_once "viewStructureBody.php";?>
    <div class="container" id="firstContainer" align="center">
        <div style="width: 60%" id="buttonSection" class="well bs-component">
            <label id="reactivationLabel">Start inactivation of node</label>
            <br>
            <form action="../static/timerManagement.php" id="form" method="post" class="form-signin">
                <select multiple="multiple" class="form-signin" name="activeNodes[]" id="activeNodeList">
                    <?php while($row=mysql_fetch_array($activeNodes)) : ?>
                        <?php if($row['isActive']=="yes")  {?>
                            <option><?php echo $row['nid'];?></option>
                        <?php }?>
                    <?php endwhile; ?>
                </select> 
                <br>
                <br>
                <div align="center">
                    <input type="button" value="Submit" class="btn btn-primary" onclick="beforeSendMessage()">
                </div>
            </form>
        </div>
    </div>
    <script type="text/javascript">

        $('option', $('#activeNodeList').multiselect()).each(function(element) {
            $('#activeNodeList').multiselect('select', $(this).val());
        });   
        function beforeSendMessage(start,end,messageContext){
            setInterval("inactivateNodes()",1000);
        }
        function inactivateNodes()  {
            $.ajax({
                cache: true,
                type: "POST",
                url:"../static/timerManagement.php",
                data:$('#form').serialize(),
                async: false,
                error: function(request) {
                    alert("Connection error");
                },
                success: function(data) {
                    window.location="../static/timerManagement.php";
                }
            });
        }
    </script>
</body>
</html>