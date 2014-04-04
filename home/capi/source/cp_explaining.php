<?php
/*
	[UCenter Home] (C) 2007-2008 Comsenz Inc.
	$Id: cp_explaining.php 13026 2009-08-06 02:17:33Z liguode $
*/

if(!defined('IN_UCHOME')) {
	exit('Access Denied');
}

//¼ì²éÐÅÏ¢
$explainingid = empty($_REQUEST['explaining'])?0:intval($_REQUEST['explaining']);
$op = empty($_REQUEST['op'])?'':$_REQUEST['op'];

//各模块小logo
$ac=$_REQUEST['ac'];
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
	capi_showmessage_by_data("未购买应用，请购买后再使用！","space.php?do=menuset&view=all");
}*/

$explaining = array();
if($explainingid) {
	$query = $_SGLOBAL['db']->query("SELECT bf.*, b.* FROM ".tname('explaining')." b 
		LEFT JOIN ".tname('explainingfield')." bf ON bf.explaining=b.explaining 
		WHERE b.explaining='$explainingid'");
	$explaining = $_SGLOBAL['db']->fetch_array($query);
}

//È¨ÏÞ¼ì²é
if(empty($explaining)) {
	/*if(!checkperm('allowexplaining')) {
		ckspacelog();
		capi_showmessage_by_data('no_authority_to_add_log');
	}
	*/
	//ÊµÃûÈÏÖ¤
	ckrealname('explaining');
	
	//ÊÓÆµÈÏÖ¤
	ckvideophoto('explaining');
	
	//ÐÂÓÃ»§¼ûÏ°
	cknewuser();
	
	//ÅÐ¶ÏÊÇ·ñ·¢²¼Ì«¿ì
	$waittime = interval_check('post');
	if($waittime > 0) {
		capi_showmessage_by_data('operating_too_fast','',1,array($waittime));
	}
	
	//½ÓÊÕÍâ²¿±êÌâ
	$explaining['subject'] = empty($_REQUEST['subject'])?'':getstr($_REQUEST['subject'], 80, 1, 0);
	$explaining['message'] = empty($_REQUEST['message'])?'':getstr($_REQUEST['message'], 5000, 1, 0);
	
} else {
	
	if($_SGLOBAL['supe_uid'] != $explaining['uid'] && !checkperm('manageexplaining')) {
		capi_showmessage_by_data('no_authority_operation_of_the_log');
	}
}

//Ìí¼Ó±à¼­²Ù×÷
if(submitcheck('explainingsubmit')) {

	if(empty($explaining['explaining'])) {
		$explaining = array();
	} else {
		if(!checkperm('allowexplaining')) {
			ckspacelog();
			capi_showmessage_by_data('no_authority_to_add_log');
		}
	}
	
	//ÑéÖ¤Âë
	if(checkperm('seccode') && !ckseccode($_REQUEST['seccode'])) {
		capi_showmessage_by_data('incorrect_code');
	}

	include_once(S_ROOT.'./source/function_explaining.php');
	/*if($_REQUEST['explainingsubmit'])
	{
		$explainingarr = array()
		{
			'subject' => $_REQUEST['subject'],
			'starttime' => $_REQUEST['starttime'],
		    'endtime' => $_REQUEST['endtime'],
		    'location' => $POST['location'],
		    'people' => $POST['people'],
		    'doctor' => $_REQUEST['doctor']
		}
	}*/


	if($newexplaining = explaining_post($_REQUEST, $explaining)) {
		if(empty($explaining) && $newexplaining['topicid']) {
			$url = 'space.php?do=topic&topicid='.$newexplaining['topicid'].'&view=explaining';
		} else {
			$url = 'space.php?uid='.$newexplaining['uid'].'&do=explaining&id='.$newexplaining['explaining'];
		}
		capi_showmessage_by_data('do_success', $url, 0);
	} else {
		capi_showmessage_by_data('that_should_at_least_write_things');
	}
}




if($_REQUEST['op'] == 'delete') {
	//É¾³ý
	if(submitcheck('deletesubmit')) {
		include_once(S_ROOT.'./source/function_delete.php');
		if(deleteexplainings(array($explainingid))) {
			capi_showmessage_by_data('do_success', "space.php?uid=$explaining[uid]&do=explaining&view=me");
		} else {
			capi_showmessage_by_data('failed_to_delete_operation');
		}
	}
	
} elseif($_REQUEST['op'] == 'goto') {
	
	$id = intval($_REQUEST['id']);
	$uid = $id?getcount('explaining', array('explaining'=>$id), 'uid'):0;

	capi_showmessage_by_data('do_success', "space.php?uid=$uid&do=explaining&id=$id", 0);
	
} elseif($_REQUEST['op'] == 'edithot') {
	//È¨ÏÞ
	if(!checkperm('manageexplaining')) {
		capi_showmessage_by_data('no_privilege');
	}
	
	if(submitcheck('hotsubmit')) {
		$_REQUEST['hot'] = intval($_REQUEST['hot']);
		updatetable('explaining', array('hot'=>$_REQUEST['hot']), array('explaining'=>$explaining['explaining']));
		if($_REQUEST['hot']>0) {
			include_once(S_ROOT.'./source/function_feed.php');
			feed_publish($explaining['explaining'], 'explaining');
		} else {
			updatetable('feed', array('hot'=>$_REQUEST['hot']), array('id'=>$explaining['explaining'], 'idtype'=>'explaining'));
		}
		
		capi_showmessage_by_data('do_success', "space.php?uid=$explaining[uid]&do=explaining&id=$explaining[explaining]", 0);
	}
	
} else {

	//Ìí¼Ó±à¼­
	//»ñÈ¡¸öÈË·ÖÀà
	//$classarr = $explaining['uid']?getclassexplainingarr($explaining['uid']):getclassexplainingarr($_SGLOBAL['supe_uid']);
	//»ñÈ¡Ïà²á

	$albums = getalbums($_SGLOBAL['supe_uid']);
	
	$tags = empty($explaining['tag'])?array():unserialize($explaining['tag']);
	$explaining['tag'] = implode(' ', $tags);
	
	$explaining['target_names'] = '';
	
	$friendarr = array($explaining['friend'] => ' selected');
	
	$passwordstyle = $selectgroupstyle = 'display:none';
	if($explaining['friend'] == 4) {
		$passwordstyle = '';
	} elseif($explaining['friend'] == 2) {
		$selectgroupstyle = '';
		if($explaining['target_ids']) {
			$names = array();
			$query = $_SGLOBAL['db']->query("SELECT username FROM ".tname('space')." WHERE uid IN ($explaining[target_ids])");
			while ($value = $_SGLOBAL['db']->fetch_array($query)) {
				$names[] = $value['username'];
			}
			$explaining['target_names'] = implode(' ', $names);
		}
	}
	
	
	$explaining['message'] = str_replace('&amp;', '&amp;amp;', $explaining['message']);
	$explaining['message'] = shtmlspecialchars($explaining['message']);
	
	$allowhtml = checkperm('allowhtml');
	
	//ºÃÓÑ×é
	$groups = getfriendgroup();
	
	//²ÎÓëÈÈµã
	$topic = array();
	$topicid = $_REQUEST['topicid'] = intval($_REQUEST['topicid']);
	if($topicid) {
		$topic = topic_get($topicid);
	}
	if($topic) {
		$actives = array('explaining' => ' class="active"');
	}
	
	//²Ëµ¥¼¤»î
	$menuactives = array('space'=>' class="active"');
}

include_once template("cp_explaining");

?>