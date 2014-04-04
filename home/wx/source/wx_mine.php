<?php
	$uid=$_GET['uid'];
	$id=$_GET['id'];
	$count2 = $_SGLOBAL['db']->result($_SGLOBAL['db']->query("SELECT COUNT(*) FROM ".tname('goodscod')."  WHERE viewuid='$uid'"),0);
	$query2 = $_SGLOBAL['db']->query("SELECT * FROM ".tname('goodscod')." WHERE viewuid='$uid'");
	while($value2=$_SGLOBAL['db']->fetch_array($query2)){
		$wei2[]=$value2;
	}
	showmessage($uid);
?>
