<?php
/**
 * Created by Chenguangbai
 * Date: 2016/3/3
 */

include_once "DBHelper.php";
function deleteUser($uid){
	$sql = "delete from user where uid='".$uid."'";
    mysql_query($sql);

    $securitySql = "delete from user_security where uid='".$uid."'";
    mysql_query($securitySql);
}

?>