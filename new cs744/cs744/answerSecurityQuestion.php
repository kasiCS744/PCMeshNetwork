<?php
/**
 * Created by PhpStorm.
 * User: Liu
 * Date: 2016/2/8
 * Time: 22:49
 */
//include_once "checkLogin.php";
//include_once "dao/getSecurity.php";
include_once "ser/securitySer.php";
session_start();
$uid=$_SESSION['uid'];
//echo $uid;
$list=getQuestionAndAnswerPairByUid($uid);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <link href="css/signin.css" rel="stylesheet">
</head>
<body>
<div class="container" align="center">
    <h3 class="form-signin-heading">Please answer security questions</h3>
    <div id="question">
<?php

                ?>
    <?php
    echo "Question:".$list[0]['question'];
    ?>
        </div><br>
    <input type="hidden" value="<?php echo $list[0]['question']?>" id="Question1">
    <input type="hidden" value="<?php echo $list[0]['answer']?>" id="Answer1">
    <input type="hidden" value="<?php echo $list[1]['question']?>" id="Question2">
    <input type="hidden" value="<?php echo $list[1]['answer']?>" id="Answer2">
    <input type="hidden" value="<?php echo $list[2]['question']?>" id="Question3">
    <input type="hidden" value="<?php echo $list[2]['answer']?>" id="Answer3">

    Answer:<input type="text" id="answer"><br>
    <div style="display: none" id="errorMessage">
       <p style="color: red" id="message"> Your security question answer is not correct!</p>
    </div>
    <input type="button" value="submit" id="submit" onclick="checkSecurity()">

</div>
</body>
<script>
    var count=0;
    function checkSecurity(){
        var answer;
        if(count==0){
            answer=document.getElementById("Answer1");
        }else if(count==1){
            answer=document.getElementById("Answer2");
        }else if(count==2){
            answer=document.getElementById("Answer3");
        }
        var currentAnswer=document.getElementById("answer");
        if(currentAnswer.value==answer.value){
            window.location.href="View/Main.php";
        }else{
            currentAnswer.value="";
            document.getElementById("errorMessage").style.display="block";
            count++;
            if(count>=3){
                document.getElementById("message").innerHTML="Your three security questions are all wrong, your account is not available!";
            }
            var question="Question"+(count+1);
            //alert(question);
            document.getElementById("question").innerHTML=document.getElementById(question).value;

        }
    }
</script>
</html>
