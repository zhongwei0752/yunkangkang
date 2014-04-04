<?
/*
	[UCenter Home] (C) 2007-2008 Comsenz Inc.
	$Id: home.php 12078 2009-05-04 08:28:37Z zhengqingpeng $
*/

if(!defined('IN_UCHOME')) {
	exit('Access Denied');
}

$ip=getonlineip();
$query = $_SGLOBAL['db']->query("SELECT * FROM  ".tname('ipcheak')." WHERE  ip='$ip'"); 
$value = $_SGLOBAL['db']->fetch_array($query);
if($value){
	$ipcheak='1';
}else{
	inserttable("ipcheak",array('ip'=>$ip));
}
include_once template("home");