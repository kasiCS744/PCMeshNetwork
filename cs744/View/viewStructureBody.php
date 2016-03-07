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
if ($user['username'] != "admin")  { ?>
    <body style ="background-image: url('../css/login_background.jpg'); background-attachment: fixed">
<?php } else  {?>
    <body style ="background-image: url('../css/admin_background.gif'); background-attachment: fixed">
<?php } ?>
    <div class="navbar navbar-default navbar-fixed-top">
        <?php if ($user['username'] != "admin")  { ?>
            <div align="center" style="background-image: url('../css/login_background.jpg')">
                <img src="../css/titleImage.PNG" align="middle" style="height:50px; width: 40%">
            </div>
        <?php } else  {?>
            <div align="center" style="background-image: url('../css/admin_background.gif')">
                <img src="../css/titleImage.PNG" align="middle" style="height:50px; width: 40%">
            </div>
        <?php } ?>
        <div class="container">
            <div class="navbar-header">
                <a class="navbar-brand" href="Main.php">Home</a>
            </div>
            <u1 class="nav navbar-nav">
                <u1 class="nav navbar-nav">
                    <?php 
                        if ($user['username'] != "admin")  {
                    ?>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Account Settings <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                        <li><a href="changeQuestion.php">Update Security Questions</a></li>
                        <li><a href="ChangePassword.php">Change Password</a></li>
                        </ul>
                    </li>
                    <?php 
                        }
                    ?>
                    <?php 
                        if ($user['username'] == "admin")  {
                    ?>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Admin Settings <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                        <li><a href="createUser.php">Create User</a></li>
                        <li><a href="allUsers.php">View/Delete User</a></li>
                        </ul>
                    </li>
                    <?php 
                        }
                    ?>
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