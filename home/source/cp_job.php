<?php
/*
	[UCenter Home] (C) 2007-2008 Comsenz Inc.
	$Id: cp_job.php 13026 2009-08-06 02:17:33Z liguode $
*/

if(!defined('IN_UCHOME')) {
	exit('Access Denied');
}

//¼ì²éÐÅÏ¢
$jobid = empty($_GET['jobid'])?0:intval($_GET['jobid']);
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

$job = array();
if($jobid) {
	$query = $_SGLOBAL['db']->query("SELECT bf.*, b.* FROM ".tname('job')." b 
		LEFT JOIN ".tname('jobfield')." bf ON bf.jobid=b.jobid 
		WHERE b.jobid='$jobid'");
	$job = $_SGLOBAL['db']->fetch_array($query);
}

//È¨ÏÞ¼ì²é
if(empty($job)) {
	if(!checkperm('allowjob')) {
		ckspacelog();
		showmessage('no_authority_to_add_log');
	}
	
	//ÊµÃûÈÏÖ¤
	ckrealname('job');
	
	//ÊÓÆµÈÏÖ¤
	ckvideophoto('job');
	
	//ÐÂÓÃ»§¼ûÏ°
	cknewuser();
	
	//ÅÐ¶ÏÊÇ·ñ·¢²¼Ì«¿ì
	$waittime = interval_check('post');
	if($waittime > 0) {
		showmessage('operating_too_fast','',1,array($waittime));
	}
	
	//½ÓÊÕÍâ²¿±êÌâ
	$job['subject'] = empty($_GET['subject'])?'':getstr($_GET['subject'], 80, 1, 0);
	$job['message'] = empty($_GET['message'])?'':getstr($_GET['message'], 5000, 1, 0);
	
} else {
	
	if($_SGLOBAL['supe_uid'] != $job['uid'] && !checkperm('managejob')) {
		showmessage('no_authority_operation_of_the_log');
	}
}

//Ìí¼Ó±à¼­²Ù×÷
if(submitcheck('jobsubmit')) {

	if(empty($job['jobid'])) {
		$job = array();
	} else {
		if(!checkperm('allowjob')) {
			ckspacelog();
			showmessage('no_authority_to_add_log');
		}
	}
	
	//ÑéÖ¤Âë
	if(checkperm('seccode') && !ckseccode($_POST['seccode'])) {
		showmessage('incorrect_code');
	}
	
	include_once(S_ROOT.'./source/function_job.php');
	if($newjob = job_post($_POST, $job)) {
		if(empty($job) && $newjob['topicid']) {
			$url = 'space.php?do=topic&topicid='.$newjob['topicid'].'&view=job';
		} else {
			$url = 'space.php?uid='.$newjob['uid'].'&do=job&id='.$newjob['jobid'];
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
		if(deletejobs(array($jobid))) {
			showmessage('do_success', "space.php?uid=$job[uid]&do=job&view=me");
		} else {
			showmessage('failed_to_delete_operation');
		}
	}
	
} elseif($_GET['op'] == 'goto') {
	
	$id = intval($_GET['id']);
	$uid = $id?getcount('job', array('jobid'=>$id), 'uid'):0;

	showmessage('do_success', "space.php?uid=$uid&do=job&id=$id", 0);
	
} elseif($_GET['op'] == 'edithot') {
	//È¨ÏÞ
	if(!checkperm('managejob')) {
		showmessage('no_privilege');
	}
	
	if(submitcheck('hotsubmit')) {
		$_POST['hot'] = intval($_POST['hot']);
		updatetable('job', array('hot'=>$_POST['hot']), array('jobid'=>$job['jobid']));
		if($_POST['hot']>0) {
			include_once(S_ROOT.'./source/function_feed.php');
			feed_publish($job['jobid'], 'jobid');
		} else {
			updatetable('feed', array('hot'=>$_POST['hot']), array('id'=>$job['jobid'], 'idtype'=>'jobid'));
		}
		
		showmessage('do_success', "space.php?uid=$job[uid]&do=job&id=$job[jobid]", 0);
	}
	
} else {

	//Ìí¼Ó±à¼­
	//»ñÈ¡¸öÈË·ÖÀà
	$classarr = $job['uid']?getclassjobarr($job['uid']):getclassjobarr($_SGLOBAL['supe_uid']);
	//»ñÈ¡Ïà²á

	$albums = getalbums($_SGLOBAL['supe_uid']);
	
	$tags = empty($job['tag'])?array():unserialize($job['tag']);
	$job['tag'] = implode(' ', $tags);
	
	$job['target_names'] = '';
	
	$friendarr = array($job['friend'] => ' selected');
	
	$passwordstyle = $selectgroupstyle = 'display:none';
	if($job['friend'] == 4) {
		$passwordstyle = '';
	} elseif($job['friend'] == 2) {
		$selectgroupstyle = '';
		if($job['target_ids']) {
			$names = array();
			$query = $_SGLOBAL['db']->query("SELECT username FROM ".tname('space')." WHERE uid IN ($job[target_ids])");
			while ($value = $_SGLOBAL['db']->fetch_array($query)) {
				$names[] = $value['username'];
			}
			$job['target_names'] = implode(' ', $names);
		}
	}
	
	
	$job['message'] = str_replace('&amp;', '&amp;amp;', $job['message']);
	$job['message'] = shtmlspecialchars($job['message']);
	
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
		$actives = array('job' => ' class="active"');
	}
	
	//²Ëµ¥¼¤»î
	$menuactives = array('space'=>' class="active"');
}

include_once template("cp_job");

?>