<?php
/**
 * Created by PhpStorm.
 * User: Liu
 * Date: 2016/2/8
 * Time: 23:34
 */
//include_once "../dao/getUser_Security.php";
//include_once "../dao/getSecurity.php";
//include_once "../dao/DBHelper.php";
$con=mysql_connect("localhost:3306","root","");
if(!$con){
    die('Could not connect: ' . mysql_error());
}
mysql_select_db("cs744",$con);

function getQuestionAndAnswerPairByUid($uid){
    $result=getUser_SecurityByUid($uid);
    $returnResult=array();
    $randList=array(0,1,2);
    while($row=mysql_fetch_array($result)){
        $answer=$row['answer'];
        //echo $answer;
        $temp=getSecurityBySid($row['sid']);
        $question=mysql_fetch_array($temp)['question'];
        $localResult=array();
        $localResult['question']=$question;
        $localResult['answer']=$answer;
        $i=rand(0,count($randList)-1);
       // echo $i;
      //  echo $randList[$i];
        $returnResult[$randList[$i]]=$localResult;
        array_splice($randList,$i,1);
        //array_push($returnResult,$localResult);

    }

    return $returnResult;
}
function getUser_SecurityByUid($uid){
    $sql="select * from user_security where uid='".$uid."'";
   // echo $sql;
    return mysql_query($sql);
}
function getSecurityBySid($sid){
    $sql="select * from security where sid='".$sid."'";
    return mysql_query($sql);
}
?>