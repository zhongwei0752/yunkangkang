<?php
/*
	[UCenter Home] (C) 2007-2008 Comsenz Inc.
	$Id: space_menuset.php 13208 2009-08-20 06:31:35Z liguode $
*/

if(!defined('IN_UCHOME')) {
	exit('Access Denied');
}
$query1 = $_SGLOBAL['db']->query("SELECT bf.message, bf.target_ids, bf.magiccolor, b.* FROM ".tname('menuset')." b $f_index
				LEFT JOIN ".tname('menusetfield')." bf ON bf.menusetid=b.menusetid
				ORDER BY dateline DESC LIMIT 0,10");
while ($value1 = $_SGLOBAL['db']->fetch_array($query1)) {
			
				$list[] = $value1;
			}
if($_POST){

foreach($_POST as $p => $o){
	$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('appset')." WHERE num='$o'");
	$value = $_SGLOBAL['db']->fetch_array($query);
	if(empty($value)){
inserttable("appset", array('num'=>$o, 'uid'=>$_SGLOBAL['supe_uid']));
}

}
showmessage("定制成功","space.php?do=check");
}

	include_once template("space_menuset");

?>