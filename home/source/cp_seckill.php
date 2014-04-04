<?php
/*
	[UCenter Home] (C) 2007-2008 Comsenz Inc.
	$Id: cp_seckill.php 13026 2009-08-06 02:17:33Z liguode $
*/

if(!defined('IN_UCHOME')) {
	exit('Access Denied');
}

//¼ì²éÐÅÏ¢
$seckillid = empty($_GET['seckillid'])?0:intval($_GET['seckillid']);
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

$seckill = array();
if($seckillid) {
	$query = $_SGLOBAL['db']->query("SELECT bf.*, b.* FROM ".tname('seckill')." b 
		LEFT JOIN ".tname('seckillfield')." bf ON bf.seckillid=b.seckillid 
		WHERE b.seckillid='$seckillid'");
	$seckill = $_SGLOBAL['db']->fetch_array($query);
}

//È¨ÏÞ¼ì²é
if(empty($seckill)) {

	//判断是否可以发布秒杀
	/*if(!checkperm('allowseckill')) {
		ckspacelog();
		showmessage('no_authority_to_add_log');
	}*/
	
	//ÊµÃûÈÏÖ¤
	ckrealname('seckill');
	
	//ÊÓÆµÈÏÖ¤
	ckvideophoto('seckill');
	
	//ÐÂÓÃ»§¼ûÏ°
	cknewuser();
	
	//ÅÐ¶ÏÊÇ·ñ·¢²¼Ì«¿ì
	$waittime = interval_check('post');
	if($waittime > 0) {
		showmessage('operating_too_fast','',1,array($waittime));
	}
	
	//½ÓÊÕÍâ²¿±êÌâ
	$seckill['subject'] = empty($_GET['subject'])?'':getstr($_GET['subject'], 80, 1, 0);
	$seckill['message'] = empty($_GET['message'])?'':getstr($_GET['message'], 5000, 1, 0);
	
} else {
	
	if($_SGLOBAL['supe_uid'] != $seckill['uid'] && !checkperm('manageseckill')) {
		showmessage('no_authority_operation_of_the_log');
	}
}

//Ìí¼Ó±à¼­²Ù×÷
if(submitcheck('seckillsubmit')) {

	if(empty($seckill['seckillid'])) {
		$seckill = array();
	} /*else {
		if(!checkperm('allowseckill')) {
			ckspacelog();
			showmessage('no_authority_to_add_log');
		}
	}*/
	
	//ÑéÖ¤Âë
	if(checkperm('seccode') && !ckseccode($_POST['seccode'])) {
		showmessage('incorrect_code');
	}

	include_once(S_ROOT.'./source/function_seckill.php');
	if($newseckill = seckill_post($_POST, $seckill)) {
		if(empty($seckill) && $newseckill['topicid']) {
			$url = 'space.php?do=topic&topicid='.$newseckill['topicid'].'&view=seckill';
		} else {
			$url = 'space.php?uid='.$newseckill['uid'].'&do=seckill&id='.$newseckill['seckillid'];
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

		if(deleteseckills(array($seckillid))) {
			showmessage('do_success', "space.php?uid=$seckill[uid]&do=seckill&view=me");
		} else {
			showmessage('failed_to_delete_operation');
		}
	}
	
} elseif($_GET['op'] == 'goto') {
	
	$id = intval($_GET['id']);
	$uid = $id?getcount('seckill', array('seckillid'=>$id), 'uid'):0;

	showmessage('do_success', "space.php?uid=$uid&do=seckill&id=$id", 0);
	
} elseif($_GET['op'] == 'edithot') {
	//È¨ÏÞ
	/*if(!checkperm('seckill')) {
		showmessage('no_privilege');
	}*/
	
	if(submitcheck('hotsubmit')) {
		$_POST['hot'] = intval($_POST['hot']);
		updatetable('seckill', array('hot'=>$_POST['hot']), array('seckillid'=>$seckill['seckillid']));
		if($_POST['hot']>0) {
			include_once(S_ROOT.'./source/function_feed.php');
			feed_publish($seckill['seckillid'], 'seckillid');
		} else {
			updatetable('feed', array('hot'=>$_POST['hot']), array('id'=>$seckill['seckillid'], 'idtype'=>'seckillid'));
		}
		
		showmessage('do_success', "space.php?uid=$seckill[uid]&do=seckill&id=$seckill[seckillid]", 0);
	}
	
} else {

	//Ìí¼Ó±à¼­
	//»ñÈ¡¸öÈË·ÖÀà
	//$classarr = $seckill['uid']?getclassseckillarr($seckill['uid']):getclassseckillarr($_SGLOBAL['supe_uid']);
	//»ñÈ¡Ïà²á

	$albums = getalbums($_SGLOBAL['supe_uid']);
	$allowhtml = checkperm('allowhtml');
	$tags = empty($seckill['tag'])?array():unserialize($seckill['tag']);
	$seckill['tag'] = implode(' ', $tags);
	
	$seckill['target_names'] = '';
	
	$friendarr = array($seckill['friend'] => ' selected');
	
	$passwordstyle = $selectgroupstyle = 'display:none';
	if($seckill['friend'] == 4) {
		$passwordstyle = '';
	} elseif($seckill['friend'] == 2) {
		$selectgroupstyle = '';
		if($seckill['target_ids']) {
			$names = array();
			$query = $_SGLOBAL['db']->query("SELECT username FROM ".tname('space')." WHERE uid IN ($seckill[target_ids])");
			while ($value = $_SGLOBAL['db']->fetch_array($query)) {
				$names[] = $value['username'];
			}
			$seckill['target_names'] = implode(' ', $names);
		}
	}
	
	
	$seckill['message'] = str_replace('&amp;', '&amp;amp;', $seckill['message']);
	$seckill['message'] = shtmlspecialchars($seckill['message']);
	
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
		$actives = array('seckill' => ' class="active"');
	}
	
	//²Ëµ¥¼¤»î
	$menuactives = array('space'=>' class="active"');
}

include_once template("cp_seckill");

?>