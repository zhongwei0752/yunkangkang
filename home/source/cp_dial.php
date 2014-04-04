<?php
/*
	[UCenter Home] (C) 2007-2008 Comsenz Inc.
	$Id: cp_dial.php 13026 2009-08-06 02:17:33Z liguode $
*/

if(!defined('IN_UCHOME')) {
	exit('Access Denied');
}

//¼ì²éÐÅÏ¢
$dialid = empty($_GET['dialid'])?0:intval($_GET['dialid']);
$op = empty($_GET['op'])?'':$_GET['op'];

//各模块小logo
$ac=$_GET['ac'];
$query4 = $_SGLOBAL['db']->query("SELECT * FROM ".tname('menuset')." WHERE english='$ac'");
$value4 = $_SGLOBAL['db']->fetch_array($query4);
$wei1=$value4;

//页面标题
$newname1 = $_SGLOBAL['db']->query("SELECT bf.*, b.* FROM ".tname('appset')." bf $f_index
				LEFT JOIN ".tname('menuset')." b ON bf.num=b.menusetid
				WHERE bf.uid='$_SGLOBAL[supe_uid]' and b.english='$ac' and bf.appstatus='1'
				ORDER BY bf.orderid ASC ");
$newname = $_SGLOBAL['db']->fetch_array($newname1);
if($newname['newname']){
	$newname['subject']=$newname['newname'];
}

//判断是否购买
/*$query5 = $_SGLOBAL['db']->query("SELECT bf.*, b.* FROM ".tname('appset')." bf $f_index
				LEFT JOIN ".tname('menuset')." b ON bf.num=b.menusetid
				WHERE bf.uid='$_SGLOBAL[supe_uid]' and bf.appstatus='1' and b.english='$ac'
				ORDER BY b.dateline ASC");
$value5 = $_SGLOBAL['db']->fetch_array($query5);
$zhong2=$value5;
if(empty($zhong2)){
	showmessage("未购买应用，请购买后再使用！","space.php?do=menuset&view=all");
}*/

$dial = array();
if($dialid) {
	$query = $_SGLOBAL['db']->query("SELECT bf.*, b.* FROM ".tname('dial')." b 
		LEFT JOIN ".tname('dialfield')." bf ON bf.dialid=b.dialid 
		WHERE b.dialid='$dialid'");
	$dial = $_SGLOBAL['db']->fetch_array($query);
}

//È¨ÏÞ¼ì²é
if(empty($dial)) {
	if(!checkperm('allowdial')) {
		ckspacelog();
		showmessage('no_authority_to_add_log');
	}
	
	//ÊµÃûÈÏÖ¤
	ckrealname('dial');
	
	//ÊÓÆµÈÏÖ¤
	ckvideophoto('dial');
	
	//ÐÂÓÃ»§¼ûÏ°
	cknewuser();
	
	//ÅÐ¶ÏÊÇ·ñ·¢²¼Ì«¿ì
	$waittime = interval_check('post');
	if($waittime > 0) {
		showmessage('operating_too_fast','',1,array($waittime));
	}
	
	//½ÓÊÕÍâ²¿±êÌâ
	$dial['subject'] = empty($_GET['subject'])?'':getstr($_GET['subject'], 80, 1, 0);
	$dial['message'] = empty($_GET['message'])?'':getstr($_GET['message'], 5000, 1, 0);
	
} else {
	
	if($_SGLOBAL['supe_uid'] != $dial['uid'] && !checkperm('managedial')) {
		showmessage('no_authority_operation_of_the_log');
	}
}

//Ìí¼Ó±à¼­²Ù×÷
if(submitcheck('dialsubmit')) {

	if(empty($dial['dialid'])) {
		$dial = array();
	} else {
		if(!checkperm('allowdial')) {
			ckspacelog();
			showmessage('no_authority_to_add_log');
		}
	}

	//ÑéÖ¤Âë
	if(checkperm('seccode') && !ckseccode($_POST['seccode'])) {
		showmessage('incorrect_code');
	}
	
	include_once(S_ROOT.'./source/function_dial.php');
	if($newdial = dial_post($_POST, $dial)) {
		if(empty($dial) && $newdial['topicid']) {
			$url = 'space.php?do=topic&topicid='.$newdial['topicid'].'&view=dial';
		} else {
			$url = 'space.php?uid='.$newdial['uid'].'&do=dial&id='.$newdial['dialid'];
		}
		showmessage('do_success', $url, 0);
	} else {
		showmessage('that_should_at_least_write_things');
	}
}

if($_GET['op'] == 'delete') {
	//É¾³ý
	if(submitcheck('deletesubmit')) {
		include_once(S_ROOT.'./source/function_delete.php');
		if(deletedials(array($dialid))) {
			showmessage('do_success', "space.php?uid=$dial[uid]&do=dial&view=me");
		} else {
			showmessage('failed_to_delete_operation');
		}
	}
	
} elseif($_GET['op'] == 'goto') {
	
	$id = intval($_GET['id']);
	$uid = $id?getcount('dial', array('dialid'=>$id), 'uid'):0;

	showmessage('do_success', "space.php?uid=$uid&do=dial&id=$id", 0);
	
} elseif($_GET['op'] == 'edithot') {
	//È¨ÏÞ
	if(!checkperm('managedial')) {
		showmessage('no_privilege');
	}
	
	if(submitcheck('hotsubmit')) {
		$_POST['hot'] = intval($_POST['hot']);
		updatetable('dial', array('hot'=>$_POST['hot']), array('dialid'=>$dial['dialid']));
		if($_POST['hot']>0) {
			include_once(S_ROOT.'./source/function_feed.php');
			feed_publish($dial['dialid'], 'dialid');
		} else {
			updatetable('feed', array('hot'=>$_POST['hot']), array('id'=>$dial['dialid'], 'idtype'=>'dialid'));
		}
		
		showmessage('do_success', "space.php?uid=$dial[uid]&do=dial&id=$dial[dialid]", 0);
	}
	
} else {

	//Ìí¼Ó±à¼­
	//»ñÈ¡¸öÈË·ÖÀà
	//$classarr = $dial['uid']?getclassdialarr($dial['uid']):getclassdialarr($_SGLOBAL['supe_uid']);
	//»ñÈ¡Ïà²á

	$albums = getalbums($_SGLOBAL['supe_uid']);
	
	$tags = empty($dial['tag'])?array():unserialize($dial['tag']);
	$dial['tag'] = implode(' ', $tags);
	
	$dial['target_names'] = '';
	
	$friendarr = array($dial['friend'] => ' selected');
	
	$passwordstyle = $selectgroupstyle = 'display:none';
	if($dial['friend'] == 4) {
		$passwordstyle = '';
	} elseif($dial['friend'] == 2) {
		$selectgroupstyle = '';
		if($dial['target_ids']) {
			$names = array();
			$query = $_SGLOBAL['db']->query("SELECT username FROM ".tname('space')." WHERE uid IN ($dial[target_ids])");
			while ($value = $_SGLOBAL['db']->fetch_array($query)) {
				$names[] = $value['username'];
			}
			$dial['target_names'] = implode(' ', $names);
		}
	}
	
	
	$dial['message'] = str_replace('&amp;', '&amp;amp;', $dial['message']);
	$dial['message'] = shtmlspecialchars($dial['message']);
	
	$allowhtml = checkperm('allowhtml');
	
	//ºÃÓÑ×é
	$groups = getfriendgroup();
	
	//²ÎÓëÈÈµã
	$topic = array();
	$topicid = $_GET['topicid'] = intval($_GET['topicid']);
	if($topicid) {
		$topic = topic_get($topicid);
	}
	if($topic) {
		$actives = array('dial' => ' class="active"');
	}
	
	//²Ëµ¥¼¤»î
	$menuactives = array('space'=>' class="active"');
}

include_once template("cp_dial");

?>