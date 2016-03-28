<?php
/**
 * Created by ChenguangBai
 * Date: 2016/3/3
 */


include_once "../dao/DBHelper.php";

$sql = "select count(*) from user where username!='admin'";
$temp = mysql_query($sql);
$res = mysql_fetch_row($temp);

echo $res[0];

?>