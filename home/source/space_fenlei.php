<?php
/*
	[UCenter Home] (C) 2007-2008 Comsenz Inc.
	$Id: space_goods.php 13208 2009-08-20 06:31:35Z liguode $
*/
if(!defined('IN_UCHOME')) {
	exit('Access Denied');
}
$op=$_GET['op'];
$id=$_GET['id'];
if($op=='delete'){
		$_SGLOBAL['db']->query("DELETE FROM ".tname('fenlei')." WHERE id ='$id'");
		showmessage("删除成功","space.php?do=fenlei");
}	
$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('fenlei')." WHERE uid='$_SGLOBAL[supe_uid]'");
while($value = $_SGLOBAL['db']->fetch_array($query)){
	$list[]=$value;
}
	include_once template("space_fenlei");
?>