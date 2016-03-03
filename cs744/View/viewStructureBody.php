<?php
/**
 * Created by PhpStorm.
 * User: Liu
 * Date: 2016/2/18
 * Time: 21:56
 */
$uid=$_SESSION['uid'];
include_once "../dao/getUser.php";
$firstName="";
$lastName="";
if($uid!=null){
    $user=mysql_fetch_array(getUserByUid($uid));
    $firstName=$user['firstName'];
    $lastName=$user['lastName'];
}
?>
<div class="navbar navbar-default navbar-fixed-top">
    <div align="center" style="background-image: url('../css/login_background.jpg')">
        <img src="../css/titleImage.PNG" align="middle" style="height:100px; width: 50%">
    </div>
    <div class="container">
        <div class="navbar-header">
            <a class="navbar-brand" href="Main.php">Home</a>
        </div>
        <u1 class="nav navbar-nav">
            <u1 class="nav navbar-nav">
                <li>
                    <a href="changeQuestion.php">Account settings</a>
                </li>
            </u1>
        </u1>
        <u1 class="nav navbar-nav navbar-right">
            <li>
                <p class="navbar-text">Logged in as <?php echo "".$firstName." ".$lastName;?></p>
            </li>
            <li>
                <a id="logout" href="../ser/logout.php"> Logout</a>
            </li>
        </u1>
    </div>
</div>