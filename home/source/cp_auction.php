<?php
/*
	[UCenter Home] (C) 2007-2008 Comsenz Inc.
	$Id: cp_auction.php 13026 2009-08-06 02:17:33Z liguode $
*/

if(!defined('IN_UCHOME')) {
	exit('Access Denied');
}

//¼ì²éÐÅÏ¢
$auctionid = empty($_GET['auctionid'])?0:intval($_GET['auctionid']);
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

$auction = array();
if($auctionid) {
	$query = $_SGLOBAL['db']->query("SELECT bf.*, b.* FROM ".tname('auction')." b 
		LEFT JOIN ".tname('auctionfield')." bf ON bf.auctionid=b.auctionid 
		WHERE b.auctionid='$auctionid'");
	$auction = $_SGLOBAL['db']->fetch_array($query);
}

//È¨ÏÞ¼ì²é
if(empty($auction)) {
	if(!checkperm('allowauction')) {
		ckspacelog();
		showmessage('no_authority_to_add_log');
	}
	
	//ÊµÃûÈÏÖ¤
	ckrealname('auction');
	
	//ÊÓÆµÈÏÖ¤
	ckvideophoto('auction');
	
	//ÐÂÓÃ»§¼ûÏ°
	cknewuser();
	
	//ÅÐ¶ÏÊÇ·ñ·¢²¼Ì«¿ì
	$waittime = interval_check('post');
	if($waittime > 0) {
		showmessage('operating_too_fast','',1,array($waittime));
	}
	
	//½ÓÊÕÍâ²¿±êÌâ
	$auction['subject'] = empty($_GET['subject'])?'':getstr($_GET['subject'], 80, 1, 0);
	$auction['message'] = empty($_GET['message'])?'':getstr($_GET['message'], 5000, 1, 0);
	
} else {
	
	if($_SGLOBAL['supe_uid'] != $auction['uid'] && !checkperm('manageauction')) {
		showmessage('no_authority_operation_of_the_log');
	}
}

//Ìí¼Ó±à¼­²Ù×÷
if(submitcheck('auctionsubmit')) {

	if(empty($auction['auctionid'])) {
		$auction = array();
	} else {
		if(!checkperm('allowauction')) {
			ckspacelog();
			showmessage('no_authority_to_add_log');
		}
	}
	
	//ÑéÖ¤Âë
	if(checkperm('seccode') && !ckseccode($_POST['seccode'])) {
		showmessage('incorrect_code');
	}

	include_once(S_ROOT.'./source/function_auction.php');
	if($newauction = auction_post($_POST, $auction)) {
		if(empty($auction) && $newauction['topicid']) {
			$url = 'space.php?do=topic&topicid='.$newauction['topicid'].'&view=auction';
		} else {
			$url = 'space.php?uid='.$newauction['uid'].'&do=auction&id='.$newauction['auctionid'];
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

		if(deleteauctions(array($auctionid))) {
			showmessage('do_success', "space.php?uid=$auction[uid]&do=auction&view=me");
		} else {
			showmessage('failed_to_delete_operation');
		}
	}
	
} elseif($_GET['op'] == 'goto') {
	
	$id = intval($_GET['id']);
	$uid = $id?getcount('auction', array('auctionid'=>$id), 'uid'):0;

	showmessage('do_success', "space.php?uid=$uid&do=auction&id=$id", 0);
	
} elseif($_GET['op'] == 'edithot') {
	//È¨ÏÞ
	if(!checkperm('manageauction')) {
		showmessage('no_privilege');
	}
	
	if(submitcheck('hotsubmit')) {
		$_POST['hot'] = intval($_POST['hot']);
		updatetable('auction', array('hot'=>$_POST['hot']), array('auctionid'=>$auction['auctionid']));
		if($_POST['hot']>0) {
			include_once(S_ROOT.'./source/function_feed.php');
			feed_publish($auction['auctionid'], 'auctionid');
		} else {
			updatetable('feed', array('hot'=>$_POST['hot']), array('id'=>$auction['auctionid'], 'idtype'=>'auctionid'));
		}
		
		showmessage('do_success', "space.php?uid=$auction[uid]&do=auction&id=$auction[auctionid]", 0);
	}
	
} else {

	//Ìí¼Ó±à¼­
	//»ñÈ¡¸öÈË·ÖÀà
	//$classarr = $auction['uid']?getclassauctionarr($auction['uid']):getclassauctionarr($_SGLOBAL['supe_uid']);
	//»ñÈ¡Ïà²á

	$albums = getalbums($_SGLOBAL['supe_uid']);
	
	$tags = empty($auction['tag'])?array():unserialize($auction['tag']);
	$auction['tag'] = implode(' ', $tags);
	
	$auction['target_names'] = '';
	
	$friendarr = array($auction['friend'] => ' selected');
	
	$passwordstyle = $selectgroupstyle = 'display:none';
	if($auction['friend'] == 4) {
		$passwordstyle = '';
	} elseif($auction['friend'] == 2) {
		$selectgroupstyle = '';
		if($auction['target_ids']) {
			$names = array();
			$query = $_SGLOBAL['db']->query("SELECT username FROM ".tname('space')." WHERE uid IN ($auction[target_ids])");
			while ($value = $_SGLOBAL['db']->fetch_array($query)) {
				$names[] = $value['username'];
			}
			$auction['target_names'] = implode(' ', $names);
		}
	}
	
	
	$auction['message'] = str_replace('&amp;', '&amp;amp;', $auction['message']);
	$auction['message'] = shtmlspecialchars($auction['message']);
	
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
		$actives = array('auction' => ' class="active"');
	}
	
	//²Ëµ¥¼¤»î
	$menuactives = array('space'=>' class="active"');
}

include_once template("cp_auction");

?>