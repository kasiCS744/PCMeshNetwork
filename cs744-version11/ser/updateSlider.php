<?php 
	include_once "../dao/DBHelper.php";
	include_once "../dao/getSetting.php";

	$sliderSetting = $_POST['sliderSetting'];
	updateSetting($sliderSetting);
?>