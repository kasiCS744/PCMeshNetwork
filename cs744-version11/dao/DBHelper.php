<?php
/**
 * Created by PhpStorm.
 * User: Liu
 * Date: 2016/2/8
 * Time: 22:55
 */
$con=mysql_connect("localhost:3306","root","");
if(!$con){
    die('Could not connect: ' . mysql_error());
}
mysql_select_db("cs744",$con);
?>