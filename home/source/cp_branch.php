<?php
/*
	[UCenter Home] (C) 2007-2008 Comsenz Inc.
	$Id: cp_branch.php 13026 2009-08-06 02:17:33Z liguode $
*/

if(!defined('IN_UCHOME')) {
	exit('Access Denied');
}

//¼ì²éÐÅÏ¢
$branchid = empty($_GET['branchid'])?0:intval($_GET['branchid']);
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
//if(empty($zhong2)){
	//showmessage("未购买应用，请购买后再使用！","space.php?do=menuset&view=all");
//}

$branch = array();
if($branchid) {
	$query = $_SGLOBAL['db']->query("SELECT bf.*, b.* FROM ".tname('branch')." b 
		LEFT JOIN ".tname('branchfield')." bf ON bf.branchid=b.branchid 
		WHERE b.branchid='$branchid'");
	$branch = $_SGLOBAL['db']->fetch_array($query);
}

//È¨ÏÞ¼ì²é
if(empty($branch)) {
	//if(!checkperm('allowbranch')) {
	//	ckspacelog();
	//	showmessage('no_authority_to_add_log');
	//}
	
	//ÊµÃûÈÏÖ¤
	ckrealname('branch');
	
	//ÊÓÆµÈÏÖ¤
	ckvideophoto('branch');
	
	//ÐÂÓÃ»§¼ûÏ°
	cknewuser();
	
	//ÅÐ¶ÏÊÇ·ñ·¢²¼Ì«¿ì
	$waittime = interval_check('post');
	if($waittime > 0) {
		showmessage('operating_too_fast','',1,array($waittime));
	}
	
	//½ÓÊÕÍâ²¿±êÌâ
	$branch['subject'] = empty($_GET['subject'])?'':getstr($_GET['subject'], 80, 1, 0);
	$branch['message'] = empty($_GET['message'])?'':getstr($_GET['message'], 5000, 1, 0);
	
} else {
	
	if($_SGLOBAL['supe_uid'] != $branch['uid'] && !checkperm('managebranch')) {
		showmessage('no_authority_operation_of_the_log');
	}
}

//Ìí¼Ó±à¼­²Ù×÷
if(submitcheck('branchsubmit')) {

	if(empty($branch['branchid'])) {
		$branch = array();
	} else {
		if(!checkperm('allowbranch')) {
			ckspacelog();
			showmessage('no_authority_to_add_log');
		}
	}
	
	//ÑéÖ¤Âë
	if(checkperm('seccode') && !ckseccode($_POST['seccode'])) {
		showmessage('incorrect_code');
	}
	
	include_once(S_ROOT.'./source/function_branch.php');
	if($newbranch = branch_post($_POST, $branch)) {
		if(empty($branch) && $newbranch['topicid']) {
			$url = 'space.php?do=topic&topicid='.$newbranch['topicid'].'&view=branch';
		} else {
			$url = 'space.php?uid='.$newbranch['uid'].'&do=branch&id='.$newbranch['branchid'];
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
		if(deletebranchs(array($branchid))) {
			showmessage('do_success', "space.php?uid=$branch[uid]&do=branch&view=me");
		} else {
			showmessage('failed_to_delete_operation');
		}
	}
	
} elseif($_GET['op'] == 'goto') {
	
	$id = intval($_GET['id']);
	$uid = $id?getcount('branch', array('branchid'=>$id), 'uid'):0;

	showmessage('do_success', "space.php?uid=$uid&do=branch&id=$id", 0);
	
} elseif($_GET['op'] == 'edithot') {
	//È¨ÏÞ
	if(!checkperm('managebranch')) {
		showmessage('no_privilege');
	}
	
	if(submitcheck('hotsubmit')) {
		$_POST['hot'] = intval($_POST['hot']);
		updatetable('branch', array('hot'=>$_POST['hot']), array('branchid'=>$branch['branchid']));
		if($_POST['hot']>0) {
			include_once(S_ROOT.'./source/function_feed.php');
			feed_publish($branch['branchid'], 'branchid');
		} else {
			updatetable('feed', array('hot'=>$_POST['hot']), array('id'=>$branch['branchid'], 'idtype'=>'branchid'));
		}
		
		showmessage('do_success', "space.php?uid=$branch[uid]&do=branch&id=$branch[branchid]", 0);
	}
	
} else {

	//Ìí¼Ó±à¼­
	//»ñÈ¡¸öÈË·ÖÀà
	$classarr = $branch['uid']?getclassbrancharr($branch['uid']):getclassbrancharr($_SGLOBAL['supe_uid']);
	//»ñÈ¡Ïà²á

	$albums = getalbums($_SGLOBAL['supe_uid']);
	
	$tags = empty($branch['tag'])?array():unserialize($branch['tag']);
	$branch['tag'] = implode(' ', $tags);
	
	$branch['target_names'] = '';
	
	$friendarr = array($branch['friend'] => ' selected');
	
	$passwordstyle = $selectgroupstyle = 'display:none';
	if($branch['friend'] == 4) {
		$passwordstyle = '';
	} elseif($branch['friend'] == 2) {
		$selectgroupstyle = '';
		if($branch['target_ids']) {
			$names = array();
			$query = $_SGLOBAL['db']->query("SELECT username FROM ".tname('space')." WHERE uid IN ($branch[target_ids])");
			while ($value = $_SGLOBAL['db']->fetch_array($query)) {
				$names[] = $value['username'];
			}
			$branch['target_names'] = implode(' ', $names);
		}
	}
	
	
	$branch['message'] = str_replace('&amp;', '&amp;amp;', $branch['message']);
	$branch['message'] = shtmlspecialchars($branch['message']);
	
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
		$actives = array('branch' => ' class="active"');
	}
	
	//²Ëµ¥¼¤»î
	$menuactives = array('space'=>' class="active"');
}

include_once template("cp_branch");

?>