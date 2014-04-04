<?php
/*
	[UCenter Home] (C) 2007-2008 Comsenz Inc.
	$Id: cp_cases.php 13026 2009-08-06 02:17:33Z liguode $
*/

if(!defined('IN_UCHOME')) {
	exit('Access Denied');
}

//¼ì²éÐÅÏ¢
$casesid = empty($_GET['casesid'])?0:intval($_GET['casesid']);
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
$query5 = $_SGLOBAL['db']->query("SELECT bf.*, b.* FROM ".tname('appset')." bf $f_index
				LEFT JOIN ".tname('menuset')." b ON bf.num=b.menusetid
				WHERE bf.uid='$_SGLOBAL[supe_uid]' and bf.appstatus='1' and b.english='$ac'
				ORDER BY b.dateline ASC");
$value5 = $_SGLOBAL['db']->fetch_array($query5);
$zhong2=$value5;
if(empty($zhong2)){
	showmessage("未购买应用，请购买后再使用！","space.php?do=menuset&view=all");
}

$cases = array();
if($casesid) {
	$query = $_SGLOBAL['db']->query("SELECT bf.*, b.* FROM ".tname('cases')." b 
		LEFT JOIN ".tname('casesfield')." bf ON bf.casesid=b.casesid 
		WHERE b.casesid='$casesid'");
	$cases = $_SGLOBAL['db']->fetch_array($query);
}

//È¨ÏÞ¼ì²é
if(empty($cases)) {
	if(!checkperm('allowcases')) {
		ckspacelog();
		showmessage('no_authority_to_add_log');
	}
	
	//ÊµÃûÈÏÖ¤
	ckrealname('cases');
	
	//ÊÓÆµÈÏÖ¤
	ckvideophoto('cases');
	
	//ÐÂÓÃ»§¼ûÏ°
	cknewuser();
	
	//ÅÐ¶ÏÊÇ·ñ·¢²¼Ì«¿ì
	$waittime = interval_check('post');
	if($waittime > 0) {
		showmessage('operating_too_fast','',1,array($waittime));
	}
	
	//½ÓÊÕÍâ²¿±êÌâ
	$cases['subject'] = empty($_GET['subject'])?'':getstr($_GET['subject'], 80, 1, 0);
	$cases['message'] = empty($_GET['message'])?'':getstr($_GET['message'], 5000, 1, 0);
	
} else {
	
	if($_SGLOBAL['supe_uid'] != $cases['uid'] && !checkperm('managecases')) {
		showmessage('no_authority_operation_of_the_log');
	}
}

//Ìí¼Ó±à¼­²Ù×÷
if(submitcheck('casessubmit')) {

	if(empty($cases['casesid'])) {
		$cases = array();
	} else {
		if(!checkperm('allowcases')) {
			ckspacelog();
			showmessage('no_authority_to_add_log');
		}
	}
	
	//ÑéÖ¤Âë
	if(checkperm('seccode') && !ckseccode($_POST['seccode'])) {
		showmessage('incorrect_code');
	}
	
	include_once(S_ROOT.'./source/function_cases.php');
	if($newcases = cases_post($_POST, $cases)) {
		if(empty($cases) && $newcases['topicid']) {
			$url = 'space.php?do=topic&topicid='.$newcases['topicid'].'&view=cases';
		} else {
			$url = 'space.php?uid='.$newcases['uid'].'&do=cases&id='.$newcases['casesid'];
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
		if(deletecasess(array($casesid))) {
			showmessage('do_success', "space.php?uid=$cases[uid]&do=cases&view=me");
		} else {
			showmessage('failed_to_delete_operation');
		}
	}
	
} elseif($_GET['op'] == 'goto') {
	
	$id = intval($_GET['id']);
	$uid = $id?getcount('cases', array('casesid'=>$id), 'uid'):0;

	showmessage('do_success', "space.php?uid=$uid&do=cases&id=$id", 0);
	
} elseif($_GET['op'] == 'edithot') {
	//È¨ÏÞ
	if(!checkperm('managecases')) {
		showmessage('no_privilege');
	}
	
	if(submitcheck('hotsubmit')) {
		$_POST['hot'] = intval($_POST['hot']);
		updatetable('cases', array('hot'=>$_POST['hot']), array('casesid'=>$cases['casesid']));
		if($_POST['hot']>0) {
			include_once(S_ROOT.'./source/function_feed.php');
			feed_publish($cases['casesid'], 'casesid');
		} else {
			updatetable('feed', array('hot'=>$_POST['hot']), array('id'=>$cases['casesid'], 'idtype'=>'casesid'));
		}
		
		showmessage('do_success', "space.php?uid=$cases[uid]&do=cases&id=$cases[casesid]", 0);
	}
	
} else {

	//Ìí¼Ó±à¼­
	//»ñÈ¡¸öÈË·ÖÀà
	$classarr = $cases['uid']?getclasscasesarr($cases['uid']):getclasscasesarr($_SGLOBAL['supe_uid']);
	//»ñÈ¡Ïà²á

	$albums = getalbums($_SGLOBAL['supe_uid']);
	
	$tags = empty($cases['tag'])?array():unserialize($cases['tag']);
	$cases['tag'] = implode(' ', $tags);
	
	$cases['target_names'] = '';
	
	$friendarr = array($cases['friend'] => ' selected');
	
	$passwordstyle = $selectgroupstyle = 'display:none';
	if($cases['friend'] == 4) {
		$passwordstyle = '';
	} elseif($cases['friend'] == 2) {
		$selectgroupstyle = '';
		if($cases['target_ids']) {
			$names = array();
			$query = $_SGLOBAL['db']->query("SELECT username FROM ".tname('space')." WHERE uid IN ($cases[target_ids])");
			while ($value = $_SGLOBAL['db']->fetch_array($query)) {
				$names[] = $value['username'];
			}
			$cases['target_names'] = implode(' ', $names);
		}
	}
	
	
	$cases['message'] = str_replace('&amp;', '&amp;amp;', $cases['message']);
	$cases['message'] = shtmlspecialchars($cases['message']);
	
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
		$actives = array('cases' => ' class="active"');
	}
	
	//²Ëµ¥¼¤»î
	$menuactives = array('space'=>' class="active"');
}

include_once template("cp_cases");

?>