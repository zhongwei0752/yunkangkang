<?php
/*
	[UCenter Home] (C) 2007-2008 Comsenz Inc.
	$Id: cp_code.php 13026 2009-08-06 02:17:33Z liguode $
*/

if(!defined('IN_UCHOME')) {
	exit('Access Denied');
}

//¼ì²éÐÅÏ¢
$codeid = empty($_GET['codeid'])?0:intval($_GET['codeid']);
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

$query9 = $_SGLOBAL['db']->query("SELECT * FROM ".tname('goods')." WHERE uid='$space[uid]'");
	while ($value = $_SGLOBAL['db']->fetch_array($query9)) {
				$list[]=$value;


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

$code = array();
if($codeid) {
	$query = $_SGLOBAL['db']->query("SELECT bf.*, b.* FROM ".tname('code')." b 
		LEFT JOIN ".tname('codefield')." bf ON bf.codeid=b.codeid 
		WHERE b.codeid='$codeid'");
	$code = $_SGLOBAL['db']->fetch_array($query);
}

//È¨ÏÞ¼ì²é
if(empty($code)) {
	if(!checkperm('allowcode')) {
		ckspacelog();
		showmessage('no_authority_to_add_log');
	}
	
	//ÊµÃûÈÏÖ¤
	ckrealname('code');
	
	//ÊÓÆµÈÏÖ¤
	ckvideophoto('code');
	
	//ÐÂÓÃ»§¼ûÏ°
	cknewuser();
	
	//ÅÐ¶ÏÊÇ·ñ·¢²¼Ì«¿ì
	$waittime = interval_check('post');
	if($waittime > 0) {
		showmessage('operating_too_fast','',1,array($waittime));
	}
	
	//½ÓÊÕÍâ²¿±êÌâ
	$code['subject'] = empty($_GET['subject'])?'':getstr($_GET['subject'], 80, 1, 0);
	$code['message'] = empty($_GET['message'])?'':getstr($_GET['message'], 5000, 1, 0);
	
} else {
	
	if($_SGLOBAL['supe_uid'] != $code['uid'] && !checkperm('managecode')) {
		showmessage('no_authority_operation_of_the_log');
	}
}

//Ìí¼Ó±à¼­²Ù×÷
if(submitcheck('codesubmit')) {

	if(empty($code['codeid'])) {
		$code = array();
	} else {
		if(!checkperm('allowcode')) {
			ckspacelog();
			showmessage('no_authority_to_add_log');
		}
	}
	
	//ÑéÖ¤Âë
	if(checkperm('seccode') && !ckseccode($_POST['seccode'])) {
		showmessage('incorrect_code');
	}

	include_once(S_ROOT.'./source/function_code.php');
	if($newcode = code_post($_POST, $code)) {
		if(empty($code) && $newcode['topicid']) {
			$url = 'space.php?do=topic&topicid='.$newcode['topicid'].'&view=code';
		} else {
			$url = 'space.php?uid='.$newcode['uid'].'&do=code&id='.$newcode['codeid'];
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

		if(deletecodes(array($codeid))) {
			showmessage('do_success', "space.php?uid=$code[uid]&do=code&view=me");
		} else {
			showmessage('failed_to_delete_operation');
		}
	}
	
} elseif($_GET['op'] == 'goto') {
	
	$id = intval($_GET['id']);
	$uid = $id?getcount('code', array('codeid'=>$id), 'uid'):0;

	showmessage('do_success', "space.php?uid=$uid&do=code&id=$id", 0);
	
} elseif($_GET['op'] == 'edithot') {
	//È¨ÏÞ
	if(!checkperm('managecode')) {
		showmessage('no_privilege');
	}
	
	if(submitcheck('hotsubmit')) {
		$_POST['hot'] = intval($_POST['hot']);
		updatetable('code', array('hot'=>$_POST['hot']), array('codeid'=>$code['codeid']));
		if($_POST['hot']>0) {
			include_once(S_ROOT.'./source/function_feed.php');
			feed_publish($code['codeid'], 'codeid');
		} else {
			updatetable('feed', array('hot'=>$_POST['hot']), array('id'=>$code['codeid'], 'idtype'=>'codeid'));
		}
		
		showmessage('do_success', "space.php?uid=$code[uid]&do=code&id=$code[codeid]", 0);
	}
	
} else {

	//Ìí¼Ó±à¼­
	//»ñÈ¡¸öÈË·ÖÀà
	//$classarr = $code['uid']?getclasscodearr($code['uid']):getclasscodearr($_SGLOBAL['supe_uid']);
	//»ñÈ¡Ïà²á

	$albums = getalbums($_SGLOBAL['supe_uid']);
	
	$tags = empty($code['tag'])?array():unserialize($code['tag']);
	$code['tag'] = implode(' ', $tags);
	
	$code['target_names'] = '';
	
	$friendarr = array($code['friend'] => ' selected');
	
	$passwordstyle = $selectgroupstyle = 'display:none';
	if($code['friend'] == 4) {
		$passwordstyle = '';
	} elseif($code['friend'] == 2) {
		$selectgroupstyle = '';
		if($code['target_ids']) {
			$names = array();
			$query = $_SGLOBAL['db']->query("SELECT username FROM ".tname('space')." WHERE uid IN ($code[target_ids])");
			while ($value = $_SGLOBAL['db']->fetch_array($query)) {
				$names[] = $value['username'];
			}
			$code['target_names'] = implode(' ', $names);
		}
	}
	
	
	$code['message'] = str_replace('&amp;', '&amp;amp;', $code['message']);
	$code['message'] = shtmlspecialchars($code['message']);
	
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
		$actives = array('code' => ' class="active"');
	}
	
	//²Ëµ¥¼¤»î
	$menuactives = array('space'=>' class="active"');
}

include_once template("cp_code");

?>