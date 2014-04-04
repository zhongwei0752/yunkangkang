<?php
/*
	[UCenter Home] (C) 2007-2008 Comsenz Inc.
	$Id: cp_recommend.php 13026 2009-08-06 02:17:33Z liguode $
*/

if(!defined('IN_UCHOME')) {
	exit('Access Denied');
}

//¼ì²éÐÅÏ¢
$recommendid = empty($_GET['recommendid'])?0:intval($_GET['recommendid']);
$op = empty($_GET['op'])?'':$_GET['op'];

//各模块小logo
$ac=$_GET['ac'];
$query4 = $_SGLOBAL['db']->query("SELECT * FROM ".tname('menuset')." WHERE english='$ac'");
$value4 = $_SGLOBAL['db']->fetch_array($query4);
$wei1=$value4;

//判断是否购买
$query5 = $_SGLOBAL['db']->query("SELECT bf.*, b.* FROM ".tname('appset')." bf $f_index
				LEFT JOIN ".tname('menuset')." b ON bf.num=b.menusetid
				WHERE bf.uid='$_SGLOBAL[supe_uid]' and bf.appstatus='1' and b.english='$ac'
				ORDER BY b.dateline ASC");
$value5 = $_SGLOBAL['db']->fetch_array($query5);
$zhong2=$value5;
//if(empty($zhong2)){
//	showmessage("未购买应用，请购买后再使用！","space.php?do=menuset&view=all");
//}

$recommend = array();
if($recommendid) {
	$query = $_SGLOBAL['db']->query("SELECT bf.*, b.* FROM ".tname('recommend')." b 
		LEFT JOIN ".tname('recommendfield')." bf ON bf.recommendid=b.recommendid 
		WHERE b.recommendid='$recommendid'");
	$recommend = $_SGLOBAL['db']->fetch_array($query);
}

//È¨ÏÞ¼ì²é
if(empty($recommend)) {
	//if(!checkperm('allowrecommend')) {
		//ckspacelog();
		//showmessage('no_authority_to_add_log');
	//}
	
	//ÊµÃûÈÏÖ¤
	ckrealname('recommend');
	
	//ÊÓÆµÈÏÖ¤
	ckvideophoto('recommend');
	
	//ÐÂÓÃ»§¼ûÏ°
	cknewuser();
	
	//ÅÐ¶ÏÊÇ·ñ·¢²¼Ì«¿ì
	$waittime = interval_check('post');
	if($waittime > 0) {
		showmessage('operating_too_fast','',1,array($waittime));
	}
	
	//½ÓÊÕÍâ²¿±êÌâ
	$recommend['subject'] = empty($_GET['subject'])?'':getstr($_GET['subject'], 80, 1, 0);
	$recommend['message'] = empty($_GET['message'])?'':getstr($_GET['message'], 5000, 1, 0);
	
} else {
	
	if($_SGLOBAL['supe_uid'] != $recommend['uid'] && !checkperm('managerecommend')) {
		showmessage('no_authority_operation_of_the_log');
	}
}

//Ìí¼Ó±à¼­²Ù×÷
if(submitcheck('recommendsubmit')) {

	if(empty($recommend['recommendid'])) {
		$recommend = array();
	} else {
		if(!checkperm('allowrecommend')) {
			ckspacelog();
			showmessage('no_authority_to_add_log');
		}
	}

	//ÑéÖ¤Âë
	if(checkperm('seccode') && !ckseccode($_POST['seccode'])) {
		showmessage('incorrect_code');
	}
	
	include_once(S_ROOT.'./source/function_recommend.php');
	if($newrecommend = recommend_post($_POST, $recommend)) {
		if(empty($recommend) && $newrecommend['topicid']) {
			$url = 'space.php?do=topic&topicid='.$newrecommend['topicid'].'&view=recommend';
		} else {
			$url = 'space.php?uid='.$newrecommend['uid'].'&do=recommend&id='.$newrecommend['recommendid'];
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
		if(deleterecommends(array($recommendid))) {
			showmessage('do_success', "space.php?uid=$recommend[uid]&do=recommend&view=me");
		} else {
			showmessage('failed_to_delete_operation');
		}
	}
	
} elseif($_GET['op'] == 'goto') {
	
	$id = intval($_GET['id']);
	$uid = $id?getcount('recommend', array('recommendid'=>$id), 'uid'):0;

	showmessage('do_success', "space.php?uid=$uid&do=recommend&id=$id", 0);
	
} elseif($_GET['op'] == 'edithot') {
	//È¨ÏÞ
	if(!checkperm('managerecommend')) {
		showmessage('no_privilege');
	}
	
	if(submitcheck('hotsubmit')) {
		$_POST['hot'] = intval($_POST['hot']);
		updatetable('recommend', array('hot'=>$_POST['hot']), array('recommendid'=>$recommend['recommendid']));
		if($_POST['hot']>0) {
			include_once(S_ROOT.'./source/function_feed.php');
			feed_publish($recommend['recommendid'], 'recommendid');
		} else {
			updatetable('feed', array('hot'=>$_POST['hot']), array('id'=>$recommend['recommendid'], 'idtype'=>'recommendid'));
		}
		
		showmessage('do_success', "space.php?uid=$recommend[uid]&do=recommend&id=$recommend[recommendid]", 0);
	}
	
} else {
	//Ìí¼Ó±à¼­
	//»ñÈ¡¸öÈË·ÖÀà

	$classarr = $recommend['uid']?getclassrecommendarr($recommend['uid']):getclassrecommendarr($_SGLOBAL['supe_uid']);
	//»ñÈ¡Ïà²á
	$albums = getalbums($_SGLOBAL['supe_uid']);
	
	$tags = empty($recommend['tag'])?array():unserialize($recommend['tag']);
	$recommend['tag'] = implode(' ', $tags);
	
	$recommend['target_names'] = '';
	
	$friendarr = array($recommend['friend'] => ' selected');
	
	$passwordstyle = $selectgroupstyle = 'display:none';
	if($recommend['friend'] == 4) {
		$passwordstyle = '';
	} elseif($recommend['friend'] == 2) {
		$selectgroupstyle = '';
		if($recommend['target_ids']) {
			$names = array();
			$query = $_SGLOBAL['db']->query("SELECT username FROM ".tname('space')." WHERE uid IN ($recommend[target_ids])");
			while ($value = $_SGLOBAL['db']->fetch_array($query)) {
				$names[] = $value['username'];
			}
			$recommend['target_names'] = implode(' ', $names);
		}
	}
	
	
	$recommend['message'] = str_replace('&amp;', '&amp;amp;', $recommend['message']);
	$recommend['message'] = shtmlspecialchars($recommend['message']);
	
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
		$actives = array('recommend' => ' class="active"');
	}
	
	//²Ëµ¥¼¤»î
	$menuactives = array('space'=>' class="active"');
}
include_once template("cp_recommend");

?>