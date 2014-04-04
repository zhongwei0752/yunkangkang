<?
/*
	[UCenter Home] (C) 2007-2008 Comsenz Inc.
	$Id: home.php 12078 2009-05-04 08:28:37Z zhengqingpeng $
*/
header("Content-Type: text/html; charset=utf-8");
if(!defined('IN_UCHOME')) {
	exit('Access Denied');
}

$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('xitie')." WHERE type='ly'");
while ($value = $_SGLOBAL['db']->fetch_array($query)) {
	$ly[]=$value;
}
$query1 = $_SGLOBAL['db']->query("SELECT * FROM ".tname('xitie')." WHERE type='zf'");
while ($value1 = $_SGLOBAL['db']->fetch_array($query1)) {
	$zf[]=$value1;
}
echo "赴宴：<br/>";
foreach($ly as $a=>$b){

	echo"姓名：$b[username]-电话：$b[telephone]-人数：$b[count]<br/>";
}
echo "<hr/>";
echo "留言：<br/>";
foreach($zf as $c=>$d){

	echo"姓名：$d[username]-电话：$d[telephone]-内容：$d[content]<br/>";
}

?>