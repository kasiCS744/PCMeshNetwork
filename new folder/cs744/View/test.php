<html>
<body>
<input type="button" value="test" onclick="mmm()">
<p id="x"></p>
<script>
    var y=0;
    var i=0;
    function mmm(){
        i=window.setInterval("sendMessage()",1000);
    }
    function sendMessage(){
      //  if(y<5){
            document.getElementById("x").innerHTML+="hello ";
        y++;
    //    }
//        else{
//            clearInterval(i);
//        }
    }
</script>
</body>
</html>