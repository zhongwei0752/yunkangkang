<?php
/*
	[UCenter Home] (C) 2007-2008 Comsenz Inc.
	$Id: space_wall.php 12880 2009-07-24 07:20:24Z liguode $
*/

if(!defined('IN_UCHOME')) {
	exit('Access Denied');
}
	$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('menuset')." ");
	while($value = $_SGLOBAL['db']->fetch_array($query)){
		$a='8';
		$wei=explode(",",$value['apptag']);
		
		if(in_array("$a", $wei)){
		$list[] = $value;
	}
	}

    

include_once template("space_wei");

?>