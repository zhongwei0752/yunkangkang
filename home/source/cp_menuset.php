<?php
/*
	[UCenter Home] (C) 2007-2008 Comsenz Inc.
	$Id: cp_menuset.php 13026 2009-08-06 02:17:33Z liguode $
*/

if(!defined('IN_UCHOME')) {
	exit('Access Denied');
}

//¼ì²éÐÅÏ¢
$menusetid = empty($_GET['menusetid'])?0:intval($_GET['menusetid']);
$op = empty($_GET['op'])?'':$_GET['op'];

$menuset = array();
if($menusetid) {
	$query = $_SGLOBAL['db']->query("SELECT bf.*, b.* FROM ".tname('menuset')." b 
		LEFT JOIN ".tname('menusetfield')." bf ON bf.menusetid=b.menusetid 
		WHERE b.menusetid='$menusetid'");
	$menuset = $_SGLOBAL['db']->fetch_array($query);
}

//È¨ÏÞ¼ì²é
if(empty($menuset)) {
	if(!checkperm('allowmenuset')) {
		ckspacelog();
		showmessage('no_authority_to_add_log');
	}
	
	//ÊµÃûÈÏÖ¤
	ckrealname('menuset');
	
	//ÊÓÆµÈÏÖ¤
	ckvideophoto('menuset');
	
	//ÐÂÓÃ»§¼ûÏ°
	cknewuser();
	
	//ÅÐ¶ÏÊÇ·ñ·¢²¼Ì«¿ì
	$waittime = interval_check('post');
	if($waittime > 0) {
		showmessage('operating_too_fast','',1,array($waittime));
	}
	
	//½ÓÊÕÍâ²¿±êÌâ
	$menuset['subject'] = empty($_GET['subject'])?'':getstr($_GET['subject'], 80, 1, 0);
	$menuset['message'] = empty($_GET['message'])?'':getstr($_GET['message'], 5000, 1, 0);
	
} else {
	
	
}

//Ìí¼Ó±à¼­²Ù×÷
if(submitcheck('menusetsubmit')) {

	if(empty($menuset['menusetid'])) {
		$menuset = array();
	} else {
		if(!checkperm('allowmenuset')) {
			ckspacelog();
			showmessage('no_authority_to_add_log');
		}
	}
	
	//ÑéÖ¤Âë
	if(checkperm('seccode') && !ckseccode($_POST['seccode'])) {
		showmessage('incorrect_code');
	}
	
	include_once(S_ROOT.'./source/function_menuset.php');
	if($newmenuset = menuset_post($_POST, $menuset)) {
		if(empty($menuset) && $newmenuset['topicid']) {
			$url = 'space.php?do=topic&topicid='.$newmenuset['topicid'].'&view=menuset';
		} else {
			$url = 'space.php?uid='.$newmenuset['uid'].'&do=menuset&id='.$newmenuset['menusetid'];
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
		if(deletemenusets(array($menusetid))) {
			showmessage('do_success', "space.php?uid=$menuset[uid]&do=menuset&view=me");
		} else {
			showmessage('failed_to_delete_operation');
		}
	}
	
} elseif($_GET['op'] == 'goto') {
	
	$id = intval($_GET['id']);
	$uid = $id?getcount('menuset', array('menusetid'=>$id), 'uid'):0;

	showmessage('do_success', "space.php?uid=$uid&do=menuset&id=$id", 0);
	
} elseif($_GET['op'] == 'edithot') {
	//È¨ÏÞ
	if(!checkperm('managemenuset')) {
		showmessage('no_privilege');
	}
	
	if(submitcheck('hotsubmit')) {
		$_POST['hot'] = intval($_POST['hot']);
		updatetable('menuset', array('hot'=>$_POST['hot']), array('menusetid'=>$menuset['menusetid']));
		if($_POST['hot']>0) {
			include_once(S_ROOT.'./source/function_feed.php');
			feed_publish($menuset['menusetid'], 'menusetid');
		} else {
			updatetable('feed', array('hot'=>$_POST['hot']), array('id'=>$menuset['menusetid'], 'idtype'=>'menusetid'));
		}
		
		showmessage('do_success', "space.php?uid=$menuset[uid]&do=menuset&id=$menuset[menusetid]", 0);
	}
	
}elseif($_GET['op'] == 'buy') {
	//È¨ÏÞ
	
	
	if(submitcheck('buysubmit')) {
		$_POST['buy'] = intval($_POST['buy']);
		$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('appset')." WHERE num='$menuset[menusetid]' and uid=$_SGLOBAL[supe_uid]");
		$value = $_SGLOBAL['db']->fetch_array($query);
		if(empty($value)){
			inserttable("appset", array('num'=>$menuset['menusetid'],'dateline1' => $_SGLOBAL['timestamp'],'month'=>$_POST['buy'],'endtime'=>$_SGLOBAL['timestamp']+$_POST['buy']*2592000, 'uid'=>$_SGLOBAL['supe_uid']));
		}else{
			updatetable('appset', array('month'=>$value['month']+$_POST['buy'],'endtime'=>$value['dateline1']+$value['month']*2592000+$_POST['buy']*2592000), array('num'=>$menuset['menusetid']));
		}
		$query1 = $_SGLOBAL['db']->query("SELECT * FROM ".tname('menuset')." WHERE menusetid='$menuset[menusetid]'");
		$value1 = $_SGLOBAL['db']->fetch_array($query1);
		if($value1['money']){
			if($space['namestatus']){
		showmessage("你所选择的应用包含付费应用，现在为你跳转到支付页面。","space.php?do=showmenuset");
	}else{
		showmessage("你所选择的应用包含付费应用，须先进行实名验证","cp.php?ac=profile");
	}
}else{
showmessage('do_success', "space.php?uid=$menuset[uid]&do=menuset&id=$menuset[menusetid]", 1);
}
	}
	
} else {
	//Ìí¼Ó±à¼­
	//»ñÈ¡¸öÈË·ÖÀà
	$classarr = $menuset['uid']?getclassmenusetarr($menuset['uid']):getclassmenusetarr($_SGLOBAL['supe_uid']);
	//»ñÈ¡Ïà²á
	$albums = getalbums($_SGLOBAL['supe_uid']);
	
	$tags = empty($menuset['tag'])?array():unserialize($menuset['tag']);
	$menuset['tag'] = implode(' ', $tags);
	
	$menuset['target_names'] = '';
	
	$friendarr = array($menuset['friend'] => ' selected');
	
	$passwordstyle = $selectgroupstyle = 'display:none';
	if($menuset['friend'] == 4) {
		$passwordstyle = '';
	} elseif($menuset['friend'] == 2) {
		$selectgroupstyle = '';
		if($menuset['target_ids']) {
			$names = array();
			$query = $_SGLOBAL['db']->query("SELECT username FROM ".tname('space')." WHERE uid IN ($menuset[target_ids])");
			while ($value = $_SGLOBAL['db']->fetch_array($query)) {
				$names[] = $value['username'];
			}
			$menuset['target_names'] = implode(' ', $names);
		}
	}
	
	
	$menuset['message'] = str_replace('&amp;', '&amp;amp;', $menuset['message']);
	$menuset['message'] = shtmlspecialchars($menuset['message']);
	
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
		$actives = array('menuset' => ' class="active"');
	}
	
	//²Ëµ¥¼¤»î
	$menuactives = array('space'=>' class="active"');
}

include_once template("cp_menuset");

?>