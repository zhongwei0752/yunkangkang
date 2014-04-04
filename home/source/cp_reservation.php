<?php
/*
	[UCenter Home] (C) 2007-2008 Comsenz Inc.
	$Id: cp_reservation.php 13026 2009-08-06 02:17:33Z liguode $
*/

if(!defined('IN_UCHOME')) {
	exit('Access Denied');
}

//?ì2éD??￠
$reservationid = empty($_GET['reservationid'])?0:intval($_GET['reservationid']);
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


$reservation = array();
if($reservationid) {
	$query = $_SGLOBAL['db']->query("SELECT bf.*, b.* FROM ".tname('reservation')." b 
		LEFT JOIN ".tname('reservationfield')." bf ON bf.reservationid=b.reservationid 
		WHERE b.reservationid='$reservationid'");
	$reservation = $_SGLOBAL['db']->fetch_array($query);
}

//è¨?T?ì2é
if(empty($reservation)) {

	//êμ??è??¤
	ckrealname('reservation');
	
	//êó?μè??¤
	ckvideophoto('reservation');
	
	//D?ó??§???°
	cknewuser();
	
	//?D??ê?·?·￠2?ì??ì
	$waittime = interval_check('post');
	if($waittime > 0) {
		showmessage('operating_too_fast','',1,array($waittime));
	}
	
	//?óê?ía2?±êìa
	$reservation['subject'] = empty($_GET['subject'])?'':getstr($_GET['subject'], 80, 1, 0);
	$reservation['message'] = empty($_GET['message'])?'':getstr($_GET['message'], 5000, 1, 0);
	
} else {
	
	if($_SGLOBAL['supe_uid'] != $reservation['uid'] && !checkperm('managereservation')) {
		showmessage('no_authority_operation_of_the_log');
	}
}

//ìí?ó±à?-2ù×÷
if(submitcheck('reservationsubmit')) {

	if(empty($reservation['reservationid'])) {
		$reservation = array();
	} /*else {
		if(!checkperm('allowreservation')) {
			ckspacelog();
			showmessage('no_authority_to_add_log');
		}
	}*/
	
	//?é?¤??
	if(checkperm('seccode') && !ckseccode($_POST['seccode'])) {
		showmessage('incorrect_code');
	}

	include_once(S_ROOT.'./source/function_reservation.php');
	if($newreservation = reservation_post($_POST, $reservation)) {
		if(empty($reservation) && $newreservation['topicid']) {
			$url = 'space.php?do=topic&topicid='.$newreservation['topicid'].'&view=reservation';
		} else {
			$url = 'space.php?uid='.$newreservation['uid'].'&do=reservation&id='.$newreservation['reservationid'];
		}
		showmessage('do_success', $url, 0);
	} else {
		showmessage('that_should_at_least_write_things');
	}
}

if($_GET['op'] == 'delete') {
	//é?3y
	if(submitcheck('deletesubmit')) {
		include_once(S_ROOT.'./source/function_delete.php');

		if(deletereservations(array($reservationid))) {
			showmessage('do_success', "space.php?uid=$reservation[uid]&do=reservation&view=me");
		} else {
			showmessage('failed_to_delete_operation');
		}
	}
	
} elseif($_GET['op'] == 'goto') {
	
	$id = intval($_GET['id']);
	$uid = $id?getcount('reservation', array('reservationid'=>$id), 'uid'):0;

	showmessage('do_success', "space.php?uid=$uid&do=reservation&id=$id", 0);
	
} elseif($_GET['op'] == 'edithot') {
	//è¨?T
	/*if(!checkperm('reservation')) {
		showmessage('no_privilege');
	}*/
	
	if(submitcheck('hotsubmit')) {
		$_POST['hot'] = intval($_POST['hot']);
		updatetable('reservation', array('hot'=>$_POST['hot']), array('reservationid'=>$reservation['reservationid']));
		if($_POST['hot']>0) {
			include_once(S_ROOT.'./source/function_feed.php');
			feed_publish($reservation['reservationid'], 'reservationid');
		} else {
			updatetable('feed', array('hot'=>$_POST['hot']), array('id'=>$reservation['reservationid'], 'idtype'=>'reservationid'));
		}
		
		showmessage('do_success', "space.php?uid=$reservation[uid]&do=reservation&id=$reservation[reservationid]", 0);
	}
	
} else {

	//ìí?ó±à?-
	//??è???è?·?àà
	//$classarr = $reservation['uid']?getclassreservationarr($reservation['uid']):getclassreservationarr($_SGLOBAL['supe_uid']);
	//??è??à2á

	$albums = getalbums($_SGLOBAL['supe_uid']);
	$allowhtml = checkperm('allowhtml');
	$tags = empty($reservation['tag'])?array():unserialize($reservation['tag']);
	$reservation['tag'] = implode(' ', $tags);
	
	$reservation['target_names'] = '';
	
	$friendarr = array($reservation['friend'] => ' selected');
	
	$passwordstyle = $selectgroupstyle = 'display:none';
	if($reservation['friend'] == 4) {
		$passwordstyle = '';
	} elseif($reservation['friend'] == 2) {
		$selectgroupstyle = '';
		if($reservation['target_ids']) {
			$names = array();
			$query = $_SGLOBAL['db']->query("SELECT username FROM ".tname('space')." WHERE uid IN ($reservation[target_ids])");
			while ($value = $_SGLOBAL['db']->fetch_array($query)) {
				$names[] = $value['username'];
			}
			$reservation['target_names'] = implode(' ', $names);
		}
	}
	
	
	$reservation['message'] = str_replace('&amp;', '&amp;amp;', $reservation['message']);
	$reservation['message'] = shtmlspecialchars($reservation['message']);
	
	$allowhtml = checkperm('allowhtml');
	
	//o?ó?×é
	$groups = getfriendgroup();
	
	//2?ó?èèμ?
	$topic = array();
	$topicid = $_GET['topicid'] = intval($_GET['topicid']);
	if($topicid) {
		$topic = topic_get($topicid);
	}
	if($topic) {
		$actives = array('reservation' => ' class="active"');
	}
	
	//2?μ￥?¤??
	$menuactives = array('space'=>' class="active"');
}

include_once template("cp_reservation");

?>