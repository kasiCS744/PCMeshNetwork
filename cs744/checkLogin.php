<?php
/**
 * Created by PhpStorm.
 * User: Liu
 * Date: 2016/2/8
 * Time: 22:45
 */
include_once "dao/DBHelper.php";
include "bootstrap.min.css";
$username=$_POST['username'];
$password=$_POST['password'];
if(isUsernameAndPasswordMatches($username,$password)){
   // echo 1;
    session_start();
    $_SESSION['uid']=getUidByUsername($username);
    header("location:answerSecurityQuestion.php");
}else{
    header("location:Login.html");
}


function getUidByUsername($username){
    $sql="select uid from user where username='".$username."'";
    return mysql_fetch_array(mysql_query($sql))[0];
}
function isUsernameAndPasswordMatches($username,$password)
{
    $sql = "select * from user where username='" . $username . "' and password='" . $password . "'";
   // echo $sql;
    $result = mysql_query($sql);
    if (mysql_fetch_array($result) == null) {
        return false;
    } else {
        return true;
    }
}


?>