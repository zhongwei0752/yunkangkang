<?php
/*
	[UCenter Home] (C) 2007-2008 Comsenz Inc.
	$Id: cp_booking.php 13026 2009-08-06 02:17:33Z liguode $
*/

if(!defined('IN_UCHOME')) {
	exit('Access Denied');
}

//¼ì²éÐÅÏ¢
$bookingid = empty($_REQUEST['booking'])?0:intval($_REQUEST['booking']);
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

$booking = array();
if($bookingid) {
	$query = $_SGLOBAL['db']->query("SELECT bf.*, b.* FROM ".tname('booking')." b 
		LEFT JOIN ".tname('bookingfield')." bf ON bf.booking=b.booking 
		WHERE b.booking='$bookingid'");
	$booking = $_SGLOBAL['db']->fetch_array($query);
}

//È¨ÏÞ¼ì²é
if(empty($booking)) {
	/*if(!checkperm('allowbooking')) {
		ckspacelog();
		capi_showmessage_by_data('no_authority_to_add_log');
	}
	*/
	//ÊµÃûÈÏÖ¤
	ckrealname('booking');
	
	//ÊÓÆµÈÏÖ¤
	ckvideophoto('booking');
	
	//ÐÂÓÃ»§¼ûÏ°
	cknewuser();
	
	//ÅÐ¶ÏÊÇ·ñ·¢²¼Ì«¿ì
	$waittime = interval_check('post');
	if($waittime > 0) {
		capi_showmessage_by_data('operating_too_fast','',1,array($waittime));
	}
	
	//½ÓÊÕÍâ²¿±êÌâ
	$booking['subject'] = empty($_REQUEST['subject'])?'':getstr($_REQUEST['subject'], 80, 1, 0);
	$booking['message'] = empty($_REQUEST['message'])?'':getstr($_REQUEST['message'], 5000, 1, 0);
	
} else {
	
	if($_SGLOBAL['supe_uid'] != $booking['uid'] && !checkperm('managebooking')) {
		capi_showmessage_by_data('no_authority_operation_of_the_log');
	}
}

//Ìí¼Ó±à¼­²Ù×÷
if(submitcheck('bookingsubmit')) {

	if(empty($booking['booking'])) {
		$booking = array();
	} else {
		if(!checkperm('allowbooking')) {
			ckspacelog();
			capi_showmessage_by_data('no_authority_to_add_log');
		}
	}
	
	//ÑéÖ¤Âë
	if(checkperm('seccode') && !ckseccode($_REQUEST['seccode'])) {
		capi_showmessage_by_data('incorrect_code');
	}

	include_once(S_ROOT.'./source/function_booking.php');
	/*if($_REQUEST['bookingsubmit'])
	{
		$bookingarr = array()
		{
			'subject' => $_REQUEST['subject'],
			'starttime' => $_REQUEST['starttime'],
		    'endtime' => $_REQUEST['endtime'],
		    'location' => $POST['location'],
		    'people' => $POST['people'],
		    'doctor' => $_REQUEST['doctor']
		}
	}*/


	if($newbooking = booking_post($_REQUEST, $booking)) {
		if(empty($booking) && $newbooking['topicid']) {
			$url = 'space.php?do=topic&topicid='.$newbooking['topicid'].'&view=booking';
		} else {
			$url = 'space.php?uid='.$newbooking['uid'].'&do=booking&id='.$newbooking['booking'];
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
		if(deletebookings(array($bookingid))) {
			capi_showmessage_by_data('do_success', "space.php?uid=$booking[uid]&do=booking&view=me");
		} else {
			capi_showmessage_by_data('failed_to_delete_operation');
		}
	}
	
} elseif($_REQUEST['op'] == 'goto') {
	
	$id = intval($_REQUEST['id']);
	$uid = $id?getcount('booking', array('booking'=>$id), 'uid'):0;

	capi_showmessage_by_data('do_success', "space.php?uid=$uid&do=booking&id=$id", 0);
	
} elseif($_REQUEST['op'] == 'edithot') {
	//È¨ÏÞ
	if(!checkperm('managebooking')) {
		capi_showmessage_by_data('no_privilege');
	}
	
	if(submitcheck('hotsubmit')) {
		$_REQUEST['hot'] = intval($_REQUEST['hot']);
		updatetable('booking', array('hot'=>$_REQUEST['hot']), array('booking'=>$booking['booking']));
		if($_REQUEST['hot']>0) {
			include_once(S_ROOT.'./source/function_feed.php');
			feed_publish($booking['booking'], 'booking');
		} else {
			updatetable('feed', array('hot'=>$_REQUEST['hot']), array('id'=>$booking['booking'], 'idtype'=>'booking'));
		}
		
		capi_showmessage_by_data('do_success', "space.php?uid=$booking[uid]&do=booking&id=$booking[booking]", 0);
	}
	
} else {

	//Ìí¼Ó±à¼­
	//»ñÈ¡¸öÈË·ÖÀà
	//$classarr = $booking['uid']?getclassbookingarr($booking['uid']):getclassbookingarr($_SGLOBAL['supe_uid']);
	//»ñÈ¡Ïà²á

	$albums = getalbums($_SGLOBAL['supe_uid']);
	
	$tags = empty($booking['tag'])?array():unserialize($booking['tag']);
	$booking['tag'] = implode(' ', $tags);
	
	$booking['target_names'] = '';
	
	$friendarr = array($booking['friend'] => ' selected');
	
	$passwordstyle = $selectgroupstyle = 'display:none';
	if($booking['friend'] == 4) {
		$passwordstyle = '';
	} elseif($booking['friend'] == 2) {
		$selectgroupstyle = '';
		if($booking['target_ids']) {
			$names = array();
			$query = $_SGLOBAL['db']->query("SELECT username FROM ".tname('space')." WHERE uid IN ($booking[target_ids])");
			while ($value = $_SGLOBAL['db']->fetch_array($query)) {
				$names[] = $value['username'];
			}
			$booking['target_names'] = implode(' ', $names);
		}
	}
	
	
	$booking['message'] = str_replace('&amp;', '&amp;amp;', $booking['message']);
	$booking['message'] = shtmlspecialchars($booking['message']);
	
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
		$actives = array('booking' => ' class="active"');
	}
	
	//²Ëµ¥¼¤»î
	$menuactives = array('space'=>' class="active"');
}

include_once template("cp_booking");

?>