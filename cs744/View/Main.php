<?php
/**
 * Created by PhpStorm.
 * User: Liu
 * Date: 2016/2/9
 * Time: 1:06
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
echo "Welcome ".$row['firstName']." ".$row['lastName']."<br><br>";
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
    <meta charset="utf-8">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <link href="../css/bootstrap.css" rel="stylesheet">
    <link href="../css/loginScreen.css" rel="stylesheet">
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
                    <a id="logout" href="../logout.php"> Logout</a>
                </li>
            </u1>
        </div>
    </div>
    <div id="node" style="display: none" class="container" align="center">

    <form action="displayNode.php" id="form" method="post" class="form-signin">
<!--        Node ID:<input type="text" name="nid"><br>-->
        <div class="form-group">
            <label> Is this node connector?</label>
            <div class="form-signin">
        Yes:<input type="radio" value="1" name="isConnector">
        No:<input type="radio" value="0" name="isConnector"></div></div>
            <label>  Pattern belongs</label>
       <input type="text" name="pid" class="form-control" placeholder="Pattern belongs">
        <label>  X position </label>
       <input type="text" name="x" class="form-control" placeholder="X position" required>
        <label>  Y position </label>
        <input type="text" name="y" class="form-control" placeholder="Y position" required>
        <label>  Link to other nodes(write node id)?</label><br>
        First node:<input type="text" name="link1" class="form-control"><br>
        Second node: <input type="text" name="link2" class="form-control" placeholder="Optional"><br>
        Third node: <input type="text" name="link3" class="form-control" placeholder="Optional"><br>
        <input type="button" value="Submit" onclick="submit()">
        <input type="reset" value="Clear">
    </form>
</div>
</body>
<script>
    function showWindow(){
       document.getElementById("node").style.display="block";
    }
    function submit(){
        document.getElementById("form").submit();
    }
</script>
</html>