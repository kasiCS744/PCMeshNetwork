<?php
/**
 * Created by Chenguangbai.
 * Date: 2016/3/2
 */
include_once "DBHelper.php";

function getUsers($page, $maxSize){
	$offset = $page*$maxSize;
    $sql="select * from user where username != 'admin' LIMIT $maxSize OFFSET $offset";
    return mysql_query($sql);
}

?>