<?php
header("Content-Type:text/html;charset=utf-8");
	$status=$_GET['status'];
	$a=explode(",",$status);
	$money=$a['1'];
	$dateline=$a['0'];
 	$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('order')." WHERE uid='$_COOKIE[uchome_uid]'");
	$value = $_SGLOBAL['db']->fetch_array($query);
	if($value){
		$email="$value[username]";
	}else{
		$email="huangjb@koalac.com";
	}
	include_once template("./wx/template/pay");
?>