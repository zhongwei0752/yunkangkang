<?
/*
	[UCenter buy] (C) 2007-2008 Comsenz Inc.
	$Id: buy.php 12078 2009-05-04 08:28:37Z zhengqingpeng $
*/

if(!defined('IN_UCHOME')) {
	exit('Access Denied');
}
$ordersql="b.dateline";
$query1 = $_SGLOBAL['db']->query("SELECT bf.message, bf.target_ids, bf.magiccolor, b.* FROM ".tname('menuset')." b $f_index
				LEFT JOIN ".tname('menusetfield')." bf ON bf.menusetid=b.menusetid
				ORDER BY $ordersql ASC ");
			while ($value1 = $_SGLOBAL['db']->fetch_array($query1)) {
				$wei=explode("，",$value1['apptag']);
				if(in_array("普通", $wei)){
				$putong[] = $value1;
				}
			}
			$query2 = $_SGLOBAL['db']->query("SELECT bf.message, bf.target_ids, bf.magiccolor, b.* FROM ".tname('menuset')." b $f_index
				LEFT JOIN ".tname('menusetfield')." bf ON bf.menusetid=b.menusetid
				ORDER BY $ordersql ASC ");
			while ($value2 = $_SGLOBAL['db']->fetch_array($query2)) {
				$wei=explode("，",$value2['apptag']);
				if(in_array("高级", $wei)){
				$gaoji[] = $value2;
				}
			}
			$query3 = $_SGLOBAL['db']->query("SELECT bf.message, bf.target_ids, bf.magiccolor, b.* FROM ".tname('menuset')." b $f_index
				LEFT JOIN ".tname('menusetfield')." bf ON bf.menusetid=b.menusetid
				ORDER BY $ordersql ASC ");
			while ($value3 = $_SGLOBAL['db']->fetch_array($query3)) {
				$wei=explode("，",$value3['apptag']);
				if(in_array("免费", $wei)){
				$mianfei[] = $value3;
				}
			}
include_once template("cp_menusetchoice");