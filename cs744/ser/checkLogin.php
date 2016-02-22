<?php
/**
 * Created by ChenguangBai
 * Date: 2016/2/14
 */
include_once "../dao/DBHelper.php";

$username=$_POST['username'];
$password=$_POST['password'];

$sql = "select * from user where username='".$username."'";
$result = mysql_query($sql);
if($result == null){
    echo 0;
}else{
    $row = mysql_fetch_array($result);
    if($row['password'] == $password){

        session_start();
        $_SESSION['uid'] = $row['uid'];

        if($row['state'] == 0){
            echo 1;
        }else{
            echo 2;
        }
    }else{
        echo 0;
    }
}
?>