<?php
/*
	[UCenter Home] (C) 2007-2008 Comsenz Inc.
	$Id: cp_industry.php 13026 2009-08-06 02:17:33Z liguode $
*/

if(!defined('IN_UCHOME')) {
	exit('Access Denied');
}

//¼ì²éÐÅÏ¢
$industryid = empty($_GET['industryid'])?0:intval($_GET['industryid']);
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

$industry = array();
if($industryid) {
	$query = $_SGLOBAL['db']->query("SELECT bf.*, b.* FROM ".tname('industry')." b 
		LEFT JOIN ".tname('industryfield')." bf ON bf.industryid=b.industryid 
		WHERE b.industryid='$industryid'");
	$industry = $_SGLOBAL['db']->fetch_array($query);
}

//È¨ÏÞ¼ì²é
if(empty($industry)) {
	if(!checkperm('allowindustry')) {
		ckspacelog();
		showmessage('no_authority_to_add_log');
	}
	
	//ÊµÃûÈÏÖ¤
	ckrealname('industry');
	
	//ÊÓÆµÈÏÖ¤
	ckvideophoto('industry');
	
	//ÐÂÓÃ»§¼ûÏ°
	cknewuser();
	
	//ÅÐ¶ÏÊÇ·ñ·¢²¼Ì«¿ì
	$waittime = interval_check('post');
	if($waittime > 0) {
		showmessage('operating_too_fast','',1,array($waittime));
	}
	
	//½ÓÊÕÍâ²¿±êÌâ
	$industry['subject'] = empty($_GET['subject'])?'':getstr($_GET['subject'], 80, 1, 0);
	$industry['message'] = empty($_GET['message'])?'':getstr($_GET['message'], 5000, 1, 0);
	
} else {
	
	if($_SGLOBAL['supe_uid'] != $industry['uid'] && !checkperm('manageindustry')) {
		showmessage('no_authority_operation_of_the_log');
	}
}

//Ìí¼Ó±à¼­²Ù×÷
if(submitcheck('industrysubmit')) {

	if(empty($industry['industryid'])) {
		$industry = array();
	} else {
		if(!checkperm('allowindustry')) {
			ckspacelog();
			showmessage('no_authority_to_add_log');
		}
	}
	
	//ÑéÖ¤Âë
	if(checkperm('seccode') && !ckseccode($_POST['seccode'])) {
		showmessage('incorrect_code');
	}

	include_once(S_ROOT.'./source/function_industry.php');
	if($newindustry = industry_post($_POST, $industry)) {
		if(empty($industry) && $newindustry['topicid']) {
			$url = 'space.php?do=topic&topicid='.$newindustry['topicid'].'&view=industry';
		} else {
			$url = 'space.php?uid='.$newindustry['uid'].'&do=industry&id='.$newindustry['industryid'];
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
		if(deleteindustrys(array($industryid))) {
			showmessage('do_success', "space.php?uid=$industry[uid]&do=industry&view=me");
		} else {
			showmessage('failed_to_delete_operation');
		}
	}
	
} elseif($_GET['op'] == 'goto') {
	
	$id = intval($_GET['id']);
	$uid = $id?getcount('industry', array('industryid'=>$id), 'uid'):0;

	showmessage('do_success', "space.php?uid=$uid&do=industry&id=$id", 0);
	
} elseif($_GET['op'] == 'edithot') {
	//È¨ÏÞ
	if(!checkperm('manageindustry')) {
		showmessage('no_privilege');
	}
	
	if(submitcheck('hotsubmit')) {
		$_POST['hot'] = intval($_POST['hot']);
		updatetable('industry', array('hot'=>$_POST['hot']), array('industryid'=>$industry['industryid']));
		if($_POST['hot']>0) {
			include_once(S_ROOT.'./source/function_feed.php');
			feed_publish($industry['industryid'], 'industryid');
		} else {
			updatetable('feed', array('hot'=>$_POST['hot']), array('id'=>$industry['industryid'], 'idtype'=>'industryid'));
		}
		
		showmessage('do_success', "space.php?uid=$industry[uid]&do=industry&id=$industry[industryid]", 0);
	}
	
} else {

	//Ìí¼Ó±à¼­
	//»ñÈ¡¸öÈË·ÖÀà
	$classarr = $industry['uid']?getclassindustryarr($industry['uid']):getclassindustryarr($_SGLOBAL['supe_uid']);
	//»ñÈ¡Ïà²á

	$albums = getalbums($_SGLOBAL['supe_uid']);
	
	$tags = empty($industry['tag'])?array():unserialize($industry['tag']);
	$industry['tag'] = implode(' ', $tags);
	
	$industry['target_names'] = '';
	
	$friendarr = array($industry['friend'] => ' selected');
	
	$passwordstyle = $selectgroupstyle = 'display:none';
	if($industry['friend'] == 4) {
		$passwordstyle = '';
	} elseif($industry['friend'] == 2) {
		$selectgroupstyle = '';
		if($industry['target_ids']) {
			$names = array();
			$query = $_SGLOBAL['db']->query("SELECT username FROM ".tname('space')." WHERE uid IN ($industry[target_ids])");
			while ($value = $_SGLOBAL['db']->fetch_array($query)) {
				$names[] = $value['username'];
			}
			$industry['target_names'] = implode(' ', $names);
		}
	}
	
	
	$industry['message'] = str_replace('&amp;', '&amp;amp;', $industry['message']);
	$industry['message'] = shtmlspecialchars($industry['message']);
	
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
		$actives = array('industry' => ' class="active"');
	}
	
	//²Ëµ¥¼¤»î
	$menuactives = array('space'=>' class="active"');
}

include_once template("cp_industry");

?>