<?php 
	include_once "DBHelper.php";

	function updateSetting($sliderSetting)  {

		$sql = "update slider set setting='".$sliderSetting."'";
		mysql_fetch_array(mysql_query($sql));
	}
	function getSetting()  {
		$sql = "select * from slider";
		return mysql_fetch_array(mysql_query($sql))[0];
	}

?>