<?php

/*
	[UCenter Home] (C) 2007-2008 Comsenz Inc.
	$Id: index.php 13003 2009-08-05 06:46:06Z liguode $
*/

include_once('./common.php');
if(is_numeric($_SERVER['QUERY_STRING'])) {
	showmessage('enter_the_space', "space.php?uid=$_SERVER[QUERY_STRING]", 0);
}
showmessage("12");
//¶þ¼¶ÓòÃû
if(!isset($_GET['do']) && $_SCONFIG['allowdomain']) {
	$hostarr = explode('.', $_SERVER['HTTP_HOST']);
	$domainrootarr = explode('.', $_SCONFIG['domainroot']);
	if(count($hostarr) > 2 && count($hostarr) > count($domainrootarr) && $hostarr[0] != 'www' && !isholddomain($hostarr[0])) {
		showmessage('enter_the_space', $_SCONFIG['siteallurl'].'space.php?domain='.$hostarr[0], 0);
	}
}
//隐藏侧边栏
	$query4 = $_SGLOBAL['db']->query("SELECT * FROM ".tname('appset')." WHERE uid='$_SGLOBAL[supe_uid]' and appstatus='1'");
	$value4 = $_SGLOBAL['db']->fetch_array($query4);
	$zhong1=$value4;

if($_SGLOBAL['supe_uid']) {
$query3 = $_SGLOBAL['db']->query("SELECT * FROM ".tname('space')." where uid=".$_SGLOBAL['supe_uid']);
$space = $_SGLOBAL['db']->fetch_array($query3);
if ($space['profilestatus']=='0'&&$space['namestatus']=='0'){
		showmessage('enter_the_space', 'cp.php?ac=profile', 0);
	}elseif($space['profilestatus']!='0'&&$space['namestatus']=='0'&&$space['alreadyreg']=='0'){
		showmessage('enter_the_space', './template/default/post_ok.htm', 0);
	}elseif($space['profilestatus']=='0'&&$space['namestatus']=='1'&&empty($zhong1)){
		showmessage('enter_the_space', 'space.php?do=menuset&view=me', 0);
	}else{
		showmessage('enter_the_space', 'space.php?do=home', 0);
		//include("./space.php");
}
}

if(empty($_SCONFIG['networkpublic'])) {
	
	$cachefile = S_ROOT.'./data/cache_index.txt';
	$cachetime = @filemtime($cachefile);
	
	$spacelist = array();
	if($_SGLOBAL['timestamp'] - $cachetime > 900) {
		//20Î»ÈÈÃÅÓÃ»§
		$query = $_SGLOBAL['db']->query("SELECT s.*, sf.resideprovince, sf.residecity
			FROM ".tname('space')." s
			LEFT JOIN ".tname('spacefield')." sf ON sf.uid=s.uid
			ORDER BY s.friendnum DESC LIMIT 0,20");
		while ($value = $_SGLOBAL['db']->fetch_array($query)) {
			$spacelist[] = $value;
		}
		swritefile($cachefile, serialize($spacelist));
	} else {
		$spacelist = unserialize(sreadfile($cachefile));
	}
	
	//Ó¦ÓÃ
	$myappcount = 0;
	$myapplist = array();
	if($_SCONFIG['my_status']) {
		$myappcount = $_SGLOBAL['db']->result($_SGLOBAL['db']->query("SELECT COUNT(*) FROM ".tname('myapp')." WHERE flag>='0'"), 0);
		if($myappcount) {
			$query = $_SGLOBAL['db']->query("SELECT appid,appname FROM ".tname('myapp')." WHERE flag>=0 ORDER BY flag DESC, displayorder LIMIT 0,7");
			while ($value = $_SGLOBAL['db']->fetch_array($query)) {
				$myapplist[] = $value;
			}
		}
	}
		
	//ÊµÃû
	foreach ($spacelist as $key => $value) {
		realname_set($value['uid'], $value['username'], $value['name'], $value['namestatus']);
	}
	realname_get();
	
	$_TPL['css'] = 'network';
	include_once template("index");
} else {
	include_once(S_ROOT.'./source/network.php');
}

?>