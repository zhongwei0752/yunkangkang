<?php
/*
	[UCenter Home] (C) 2007-2008 Comsenz Inc.
	$Id: cp_moblie.php 13026 2009-08-06 02:17:33Z liguode $
*/

if(!defined('IN_UCHOME')) {
	exit('Access Denied');
}

//¼ì²éÐÅÏ¢
$moblieid = empty($_GET['moblieid'])?0:intval($_GET['moblieid']);
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

$moblie = array();
if($moblieid) {
	$query = $_SGLOBAL['db']->query("SELECT bf.*, b.* FROM ".tname('moblie')." b 
		LEFT JOIN ".tname('mobliefield')." bf ON bf.moblieid=b.moblieid 
		WHERE b.moblieid='$moblieid'");
	$moblie = $_SGLOBAL['db']->fetch_array($query);
}

//È¨ÏÞ¼ì²é
if(empty($moblie)) {
	//if(!checkperm('allowmoblie')) {
		//ckspacelog();
		//showmessage('no_authority_to_add_log');
	//}
	
	//ÊµÃûÈÏÖ¤
	ckrealname('moblie');
	
	//ÊÓÆµÈÏÖ¤
	ckvideophoto('moblie');
	
	//ÐÂÓÃ»§¼ûÏ°
	cknewuser();
	
	//ÅÐ¶ÏÊÇ·ñ·¢²¼Ì«¿ì
	$waittime = interval_check('post');
	if($waittime > 0) {
		showmessage('operating_too_fast','',1,array($waittime));
	}
	
	//½ÓÊÕÍâ²¿±êÌâ
	$moblie['subject'] = empty($_GET['subject'])?'':getstr($_GET['subject'], 80, 1, 0);
	$moblie['message'] = empty($_GET['message'])?'':getstr($_GET['message'], 5000, 1, 0);
	
} else {
	
	if($_SGLOBAL['supe_uid'] != $moblie['uid'] && !checkperm('managemoblie')) {
		showmessage('no_authority_operation_of_the_log');
	}
}

//Ìí¼Ó±à¼­²Ù×÷
if(submitcheck('mobliesubmit')) {

	if(empty($moblie['moblieid'])) {
		$moblie = array();
	} else {
		if(!checkperm('allowmoblie')) {
			ckspacelog();
			showmessage('no_authority_to_add_log');
		}
	}

	//ÑéÖ¤Âë
	if(checkperm('seccode') && !ckseccode($_POST['seccode'])) {
		showmessage('incorrect_code');
	}
	
	include_once(S_ROOT.'./source/function_moblie.php');
	if($newmoblie = moblie_post($_POST, $moblie)) {
		if(empty($moblie) && $newmoblie['topicid']) {
			$url = 'space.php?do=topic&topicid='.$newmoblie['topicid'].'&view=moblie';
		} else {
			$url = 'space.php?uid='.$newmoblie['uid'].'&do=moblie&id='.$newmoblie['moblieid'];
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
		if(deletemoblies(array($moblieid))) {
			showmessage('do_success', "space.php?uid=$moblie[uid]&do=moblie&view=me");
		} else {
			showmessage('failed_to_delete_operation');
		}
	}
	
} elseif($_GET['op'] == 'goto') {
	
	$id = intval($_GET['id']);
	$uid = $id?getcount('moblie', array('moblieid'=>$id), 'uid'):0;

	showmessage('do_success', "space.php?uid=$uid&do=moblie&id=$id", 0);
	
} elseif($_GET['op'] == 'edithot') {
	//È¨ÏÞ
	if(!checkperm('managemoblie')) {
		showmessage('no_privilege');
	}
	
	if(submitcheck('hotsubmit')) {
		$_POST['hot'] = intval($_POST['hot']);
		updatetable('moblie', array('hot'=>$_POST['hot']), array('moblieid'=>$moblie['moblieid']));
		if($_POST['hot']>0) {
			include_once(S_ROOT.'./source/function_feed.php');
			feed_publish($moblie['moblieid'], 'moblieid');
		} else {
			updatetable('feed', array('hot'=>$_POST['hot']), array('id'=>$moblie['moblieid'], 'idtype'=>'moblieid'));
		}
		
		showmessage('do_success', "space.php?uid=$moblie[uid]&do=moblie&id=$moblie[moblieid]", 0);
	}
	
} else {
	//Ìí¼Ó±à¼­
	//»ñÈ¡¸öÈË·ÖÀà

	$classarr = $moblie['uid']?getclassmobliearr($moblie['uid']):getclassmobliearr($_SGLOBAL['supe_uid']);
	//»ñÈ¡Ïà²á
	$albums = getalbums($_SGLOBAL['supe_uid']);
	
	$tags = empty($moblie['tag'])?array():unserialize($moblie['tag']);
	$moblie['tag'] = implode(' ', $tags);
	
	$moblie['target_names'] = '';
	
	$friendarr = array($moblie['friend'] => ' selected');
	
	$passwordstyle = $selectgroupstyle = 'display:none';
	if($moblie['friend'] == 4) {
		$passwordstyle = '';
	} elseif($moblie['friend'] == 2) {
		$selectgroupstyle = '';
		if($moblie['target_ids']) {
			$names = array();
			$query = $_SGLOBAL['db']->query("SELECT username FROM ".tname('space')." WHERE uid IN ($moblie[target_ids])");
			while ($value = $_SGLOBAL['db']->fetch_array($query)) {
				$names[] = $value['username'];
			}
			$moblie['target_names'] = implode(' ', $names);
		}
	}
	
	
	$moblie['message'] = str_replace('&amp;', '&amp;amp;', $moblie['message']);
	$moblie['message'] = shtmlspecialchars($moblie['message']);
	
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
		$actives = array('moblie' => ' class="active"');
	}
	
	//²Ëµ¥¼¤»î
	$menuactives = array('space'=>' class="active"');
}
include_once template("cp_moblie");

?>