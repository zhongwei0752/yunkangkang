<?php
/*
	[UCenter Home] (C) 2007-2008 Comsenz Inc.
	$Id: space_talk.php 12998 2009-08-05 03:29:54Z liguode $
*/

if(!defined('IN_UCHOME')) {
	exit('Access Denied');
}
//各模块小logo
$do=$_REQUEST['do'];
$query4 = $_SGLOBAL['db']->query("SELECT * FROM ".tname('menuset')." WHERE english='$do'");
$value4 = $_SGLOBAL['db']->fetch_array($query4);
$wei1=$value4;
//·ÖÒ³
$perpage = 20;
$perpage = mob_perpage($perpage);

$page = empty($_REQUEST['page'])?0:intval($_REQUEST['page']);
if($page<1) $page=1;
$start = ($page-1)*$perpage;

//¼ì²é¿ªÊ¼Êý
ckstart($start, $perpage);

$dolist = array();
$count = 0;

if(empty($_REQUEST['view']) && ($space['friendnum']<$_SCONFIG['showallfriendnum'])) {
	$_REQUEST['view'] = 'all';//Ä¬ÈÏÏÔÊ¾
}
	
//´¦Àí²éÑ¯
$f_index = '';
if($_REQUEST['view'] == 'all') {
	
	$wheresql = "1";
	$theurl = "space.php?uid=$space[uid]&do=$do&view=all";
	$f_index = 'USE INDEX(dateline)';
	$actives = array('all'=>' class="active"');
	
} else {
	
	if(empty($space['feedfriend'])) $_REQUEST['view'] = 'me';
	
	if($_REQUEST['view'] == 'me') {
		$wheresql = "uid='$space[uid]'";
		$theurl = "space.php?uid=$space[uid]&do=$do&view=me";
		$actives = array('me'=>' class="active"');
	} else {
		$wheresql = "uid IN ($space[feedfriend],$space[uid])";
		$theurl = "space.php?uid=$space[uid]&do=$do&view=we";
		$f_index = 'USE INDEX(dateline)';
		$actives = array('we'=>' class="active"');
	}
}

$doid = empty($_REQUEST['doid'])?0:intval($_REQUEST['doid']);
if($doid) {
	$count = 1;
	$f_index = '';
	$wheresql = "doid='$doid'";
	$theurl .= "&doid=$doid";
}


$doids = $clist = $newdoids = array();
if(empty($count)) {
	$count = $_SGLOBAL['db']->result($_SGLOBAL['db']->query("SELECT COUNT(*) FROM ".tname('talk')." WHERE $wheresql"), 0);
	//¸üÐÂÍ³¼Æ
	if($wheresql == "uid='$space[uid]'" && $space['talknum'] != $count) {
		updatetable('space', array('talknum' => $count), array('uid'=>$space['uid']));
	}
}
if($count) {
	$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('talk')." $f_index
		WHERE $wheresql
		ORDER BY dateline DESC
		LIMIT $start,$perpage");
	while ($value = $_SGLOBAL['db']->fetch_array($query)) {
		realname_set($value['uid'], $value['username']);
		$query1 = $_SGLOBAL['db']->query("SELECT * FROM ".tname('talkcomment')." 
		WHERE doid='$value[doid]' ORDER BY dateline DESC LIMIT $start,$perpage");
		while ($value1 = $_SGLOBAL['db']->fetch_array($query1)) {
		$value['comment'][]=$value1;
		}

		$doids[] = $value['doid'];
		$dolist[] = $value;
	}
}
capi_showmessage_by_data("rest_success", 0, array('talk'=>$dolist, 'count'=>$count));
//µ¥Ìõ´¦Àí
if($doid) {
	$dovalue = empty($dolist)?array():$dolist[0];
	if($dovalue) {
		if($dovalue['uid'] == $_SGLOBAL['supe_uid']) {
			$actives = array('me'=>' class="active"');
		} else {
			$space = getspace($dovalue['uid']);//¶Ô·½µÄ¿Õ¼ä
			$actives = array('all'=>' class="active"');
		}
	}
}

//»Ø¸´
if($doids) {
	
	include_once(S_ROOT.'./source/class_tree.php');
	$tree = new tree();
	
	$values = array();
	$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('talkcomment')." USE INDEX(dateline) WHERE doid IN (".simplode($doids).") ORDER BY dateline");
	while ($value = $_SGLOBAL['db']->fetch_array($query)) {
		realname_set($value['uid'], $value['username']);
		$newdoids[$value['doid']] = $value['doid'];
		if(empty($value['upid'])) {
			$value['upid'] = "do$value[doid]";
		}
		$tree->setNode($value['id'], $value['upid'], $value);
	}
}

foreach ($newdoids as $cdoid) {
	$values = $tree->getChilds("do$cdoid");
	foreach ($values as $key => $id) {
		$one = $tree->getValue($id);
		$one['layer'] = $tree->getLayer($id) * 2 - 2;
		$one['style'] = "padding-left:{$one['layer']}em;";
		if($_REQUEST['highlight'] && $one['id'] == $_REQUEST['highlight']) {
			$one['style'] .= 'color:red;font-weight:bold;';
		}
		$clist[$cdoid][] = $one;
	}
}

//·ÖÒ³
$multi = multi($count, $perpage, $page, $theurl);

//Í¬ÐÄÇéµÄ
$moodlist = array();
if($space['mood'] && empty($start)) {
	$query = $_SGLOBAL['db']->query("SELECT s.uid,s.username,s.name,s.namestatus,s.mood,s.updatetime,s.groupid,sf.note,sf.sex
		FROM ".tname('space')." s
		LEFT JOIN ".tname('spacefield')." sf ON sf.uid=s.uid
		WHERE s.mood='$space[mood]' ORDER BY s.updatetime DESC LIMIT 0,13");
	while ($value = $_SGLOBAL['db']->fetch_array($query)) {
		if($value['uid'] != $space['uid']) {
			realname_set($value['uid'], $value['username'], $value['name'], $value['namestatus']);
			$moodlist[] = $value;
			if(count($moodlist)==12) break;
		}
	}
}

$upid = 0;

//ÊµÃû
realname_get();

$_TPL['css'] = 'talk';
include_once template("space_talk");

?>