<?php
/*
	[UCenter Home] (C) 2007-2008 Comsenz Inc.
	$Id: space_menuset.php 13208 2009-08-20 06:31:35Z liguode $
*/

if(!defined('IN_UCHOME')) {
	exit('Access Denied');
}
$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('space')." where fatheruid ='$_SGLOBAL[supe_uid]'");

		while ($value = $_SGLOBAL['db']->fetch_array($query)) {
				$query1 = $_SGLOBAL['db']->query("SELECT m.* FROM ".tname('appset')." a LEFT JOIN ".tname('menuset')." m ON a.num=m.menusetid where a.childrenid ='$value[uid]'");	
				while ($value1 = $_SGLOBAL['db']->fetch_array($query1)) {
					$value['wei'][]=$value1;
					}
					$list[] = $value;
				}

include_once template("space_myweixin");

?>