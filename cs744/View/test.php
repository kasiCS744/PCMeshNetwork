<html>
<body>
<form action="../ser/addNode.php" method="post">
    <select name="yyy[]" multiple="multiple">
        <option value="Option 1" >Option 1</option>
        <option value="Option 2">Option 2</option>
        <option value="Option 3">Option 3</option>
        <option value="Option 4">Option 4</option>
        <option value="Option 5">Option 5</option>
    </select>
    <input type="submit">
</form>
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