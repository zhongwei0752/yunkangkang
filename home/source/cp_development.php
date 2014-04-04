<?php
/*
	[UCenter Home] (C) 2007-2008 Comsenz Inc.
	$Id: cp_development.php 13026 2009-08-06 02:17:33Z liguode $
*/

if(!defined('IN_UCHOME')) {
	exit('Access Denied');
}

//¼ì²éÐÅÏ¢
$developmentid = empty($_GET['developmentid'])?0:intval($_GET['developmentid']);
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

$development = array();
if($developmentid) {
	$query = $_SGLOBAL['db']->query("SELECT bf.*, b.* FROM ".tname('development')." b 
		LEFT JOIN ".tname('developmentfield')." bf ON bf.developmentid=b.developmentid 
		WHERE b.developmentid='$developmentid'");
	$development = $_SGLOBAL['db']->fetch_array($query);
}

//È¨ÏÞ¼ì²é
if(empty($development)) {
	if(!checkperm('allowdevelopment')) {
		ckspacelog();
		showmessage('no_authority_to_add_log');
	}
	
	//ÊµÃûÈÏÖ¤
	ckrealname('development');
	
	//ÊÓÆµÈÏÖ¤
	ckvideophoto('development');
	
	//ÐÂÓÃ»§¼ûÏ°
	cknewuser();
	
	//ÅÐ¶ÏÊÇ·ñ·¢²¼Ì«¿ì
	$waittime = interval_check('post');
	if($waittime > 0) {
		showmessage('operating_too_fast','',1,array($waittime));
	}
	
	//½ÓÊÕÍâ²¿±êÌâ
	$development['subject'] = empty($_GET['subject'])?'':getstr($_GET['subject'], 80, 1, 0);
	$development['message'] = empty($_GET['message'])?'':getstr($_GET['message'], 5000, 1, 0);
	
} else {
	
	if($_SGLOBAL['supe_uid'] != $development['uid'] && !checkperm('managedevelopment')) {
		showmessage('no_authority_operation_of_the_log');
	}
}

//Ìí¼Ó±à¼­²Ù×÷
if(submitcheck('developmentsubmit')) {

	if(empty($development['developmentid'])) {
		$development = array();
	} else {
		if(!checkperm('allowdevelopment')) {
			ckspacelog();
			showmessage('no_authority_to_add_log');
		}
	}
	
	//ÑéÖ¤Âë
	if(checkperm('seccode') && !ckseccode($_POST['seccode'])) {
		showmessage('incorrect_code');
	}
	
	include_once(S_ROOT.'./source/function_development.php');
	if($newdevelopment = development_post($_POST, $development)) {
		if(empty($development) && $newdevelopment['topicid']) {
			$url = 'space.php?do=topic&topicid='.$newdevelopment['topicid'].'&view=development';
		} else {
			$url = 'space.php?uid='.$newdevelopment['uid'].'&do=development&id='.$newdevelopment['developmentid'];
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
		if(deletedevelopments(array($developmentid))) {
			showmessage('do_success', "space.php?uid=$development[uid]&do=development&view=me");
		} else {
			showmessage('failed_to_delete_operation');
		}
	}
	
} elseif($_GET['op'] == 'goto') {
	
	$id = intval($_GET['id']);
	$uid = $id?getcount('development', array('developmentid'=>$id), 'uid'):0;

	showmessage('do_success', "space.php?uid=$uid&do=development&id=$id", 0);
	
} elseif($_GET['op'] == 'edithot') {
	//È¨ÏÞ
	if(!checkperm('managedevelopment')) {
		showmessage('no_privilege');
	}
	
	if(submitcheck('hotsubmit')) {
		$_POST['hot'] = intval($_POST['hot']);
		updatetable('development', array('hot'=>$_POST['hot']), array('developmentid'=>$development['developmentid']));
		if($_POST['hot']>0) {
			include_once(S_ROOT.'./source/function_feed.php');
			feed_publish($development['developmentid'], 'developmentid');
		} else {
			updatetable('feed', array('hot'=>$_POST['hot']), array('id'=>$development['developmentid'], 'idtype'=>'developmentid'));
		}
		
		showmessage('do_success', "space.php?uid=$development[uid]&do=development&id=$development[developmentid]", 0);
	}
	
} else {

	//Ìí¼Ó±à¼­
	//»ñÈ¡¸öÈË·ÖÀà
	$classarr = $development['uid']?getclassdevelopmentarr($development['uid']):getclassdevelopmentarr($_SGLOBAL['supe_uid']);
	//»ñÈ¡Ïà²á

	$albums = getalbums($_SGLOBAL['supe_uid']);
	
	$tags = empty($development['tag'])?array():unserialize($development['tag']);
	$development['tag'] = implode(' ', $tags);
	
	$development['target_names'] = '';
	
	$friendarr = array($development['friend'] => ' selected');
	
	$passwordstyle = $selectgroupstyle = 'display:none';
	if($development['friend'] == 4) {
		$passwordstyle = '';
	} elseif($development['friend'] == 2) {
		$selectgroupstyle = '';
		if($development['target_ids']) {
			$names = array();
			$query = $_SGLOBAL['db']->query("SELECT username FROM ".tname('space')." WHERE uid IN ($development[target_ids])");
			while ($value = $_SGLOBAL['db']->fetch_array($query)) {
				$names[] = $value['username'];
			}
			$development['target_names'] = implode(' ', $names);
		}
	}
	
	
	$development['message'] = str_replace('&amp;', '&amp;amp;', $development['message']);
	$development['message'] = shtmlspecialchars($development['message']);
	
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
		$actives = array('development' => ' class="active"');
	}
	
	//²Ëµ¥¼¤»î
	$menuactives = array('space'=>' class="active"');
}

include_once template("cp_development");

?>