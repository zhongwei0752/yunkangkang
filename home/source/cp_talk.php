<?php
/*
	[UCenter Home] (C) 2007-2008 Comsenz Inc.
	$Id: cp_talk.php 13245 2009-08-25 02:01:40Z liguode $
*/

if(!defined('IN_UCHOME')) {
	exit('Access Denied');
}

$doid = empty($_GET['doid'])?0:intval($_GET['doid']);
$id = empty($_GET['id'])?0:intval($_GET['id']);
if(empty($_POST['refer'])) $_POST['refer'] = "space.php?do=talk&view=me";

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
if(empty($zhong2)){
	showmessage("未购买应用，请购买后再使用！","space.php?do=menuset&view=all");
}

if(submitcheck('addsubmit')) {

	$add_talk = 1;
	if(empty($_POST['spacenote'])) {
		if(!checkperm('allowtalk')) {
			ckspacelog();
			showmessage('no_privilege');
		}
		
		//ÊµÃûÈÏÖ¤
		ckrealname('talk');
		
		//ÊÓÆµÈÏÖ¤
		ckvideophoto('talk');
		
		//ÐÂÓÃ»§¼ûÏ°
		cknewuser();
	
		//ÑéÖ¤Âë
		if(checkperm('seccode') && !ckseccode($_POST['seccode'])) {
			showmessage('incorrect_code');
		}
	
		//ÅÐ¶ÏÊÇ·ñ²Ù×÷Ì«¿ì
		$waittime = interval_check('post');
		if($waittime > 0) {
			showmessage('operating_too_fast', '', 1, array($waittime));
		}
	} else {
		if(!checkperm('allowtalk')) {
			$add_talk = 0;
		}

		//ÊµÃû
		if(!ckrealname('talk', 1)) {
			$add_talk = 0;
		}
		//ÊÓÆµ
		if(!ckvideophoto('talk', array(), 1)) {
			$add_talk = 0;
		}
		//ÐÂÓÃ»§
		if(!cknewuser(1)) {
			$add_talk = 0;
		}
		$waittime = interval_check('post');
		if($waittime > 0) {
			$add_talk = 0;
		}
	}
	
	//»ñÈ¡ÐÄÇé
	$mood = 0;
	preg_match("/\[em\:(\d+)\:\]/s", $_POST['message'], $ms);
	$mood = empty($ms[1])?0:intval($ms[1]);

	$message = getstr($_POST['message'], 200, 1, 1, 1);
	//Ìæ»»±íÇé
	$message = preg_replace("/\[em:(\d+):]/is", "<img src=\"image/face/\\1.gif\" class=\"face\">", $message);
	$message = preg_replace("/\<br.*?\>/is", ' ', $message);
	
	if(strlen($message) < 1) {
		showmessage('should_write_that');
	}
	$subject=$_POST['subject'];
	if(strlen($subject) < 1) {
		showmessage('should_write_that');
	}
	if(strlen($subject) > 25) {
		showmessage('标题太长了！');
	}
	
	if($add_talk) {
		$setarr = array(
			'uid' => $_SGLOBAL['supe_uid'],
			'username' => $_SGLOBAL['supe_username'],
			'dateline' => $_SGLOBAL['timestamp'],
			'message' => $message,
			'subject'=>$subject,
			'mood' => $mood,
			'ip' => getonlineip()
		);
		//Èë¿â
		$newdoid = inserttable('talk', $setarr, 1);
	}
	
	//¸üÐÂ¿Õ¼änote
	$setarr = array('note'=>$message);
	$credit = $experience = 0;
	if(!empty($_POST['spacenote'])) {
		$reward = getreward('updatemood', 0);
		$setarr['spacenote'] = $message;
	} else {
		$reward = getreward('talk', 0);
	}
	updatetable('spacefield', $setarr, array('uid'=>$_SGLOBAL['supe_uid']));
	
	if($reward['credit']) {
		$credit = $reward['credit'];
	}
	if($reward['experience']) {
		$experience = $reward['experience'];
	}
	$setarr = array(
		'mood' => "mood='$mood'",
		'updatetime' => "updatetime='$_SGLOBAL[timestamp]'",
		'credit' => "credit=credit+$credit",
		'experience' => "experience=experience+$experience",
		'lastpost' => "lastpost='$_SGLOBAL[timestamp]'"
	);
	if($add_talk) {
		if(empty($space['talknum'])) {//µÚÒ»´Î
			$talknum = getcount('talk', array('uid'=>$space['uid']));
			$setarr['talknum'] = "talknum='$talknum'";
		} else {
			$setarr['talknum'] = "talknum=talknum+1";
		}
	}
	$_SGLOBAL['db']->query("UPDATE ".tname('space')." SET ".implode(',', $setarr)." WHERE uid='$_SGLOBAL[supe_uid]'");
	
	//ÊÂ¼þfeed
	if($add_talk && ckprivacy('talk', 1)) {
		$feedarr = array(
			'appid' => UC_APPID,
			'icon' => 'talk',
			'uid' => $_SGLOBAL['supe_uid'],
			'username' => $_SGLOBAL['supe_username'],
			'dateline' => $_SGLOBAL['timestamp'],
			'title_template' => cplang('feed_talk_title'),
			'title_data' => saddslashes(serialize(sstripslashes(array('message'=>$message)))),
			'body_template' => '',
			'body_data' => '',
			'id' => $newdoid,
			'idtype' => 'doid'
		);
		$feedarr['hash_template'] = md5($feedarr['title_template']."\t".$feedarr['body_template']);//Ï²ºÃhash
		$feedarr['hash_data'] = md5($feedarr['title_template']."\t".$feedarr['title_data']."\t".$feedarr['body_template']."\t".$feedarr['body_data']);//ºÏ²¢hash
		inserttable('feed', $feedarr);
	}

	//Í³¼Æ
	updatestat('talk');
	
	showmessage('do_success', $_POST['refer'], 0);

} elseif (submitcheck('commentsubmit')) {
	
	if(!checkperm('allowtalk')) {
		ckspacelog();
		showmessage('no_privilege');
	}
	
	//ÊµÃûÈÏÖ¤
	ckrealname('talk');
	
	//ÐÂÓÃ»§¼ûÏ°
	cknewuser();
	
	//ÅÐ¶ÏÊÇ·ñ²Ù×÷Ì«¿ì
	$waittime = interval_check('post');
	if($waittime > 0) {
		showmessage('operating_too_fast', '', 1, array($waittime));
	}
	
	$message = getstr($_POST['message'], 200, 1, 1, 1);
	//Ìæ»»±íÇé
	$message = preg_replace("/\[em:(\d+):]/is", "<img src=\"image/face/\\1.gif\" class=\"face\">", $message);
	$message = preg_replace("/\<br.*?\>/is", ' ', $message);
	if(strlen($message) < 1) {
		showmessage('should_write_that');
	}

	$updo = array();
	if($id) {
		$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('talkcomment')." WHERE id='$id'");
		$updo = $_SGLOBAL['db']->fetch_array($query);
	}
	if(empty($updo) && $doid) {
		$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('talk')." WHERE doid='$doid'");
		$updo = $_SGLOBAL['db']->fetch_array($query);
	}
	if(empty($updo)) {
		showmessage('talkcomment_error');
	} else {
		//ºÚÃûµ¥
		if(isblacklist($updo['uid'])) {
			showmessage('is_blacklist');
		}
	}
	
	$updo['id'] = intval($updo['id']);
	$updo['grade'] = intval($updo['grade']);
	
	$setarr = array(
		'doid' => $updo['doid'],
		'upid' => $updo['id'],
		'uid' => $_SGLOBAL['supe_uid'],
		'username' => $_SGLOBAL['supe_username'],
		'dateline' => $_SGLOBAL['timestamp'],
		'message' => $message,
		'ip' => getonlineip(),
		'grade' => $updo['grade']+1
	);
	
	//×î¶à²ã¼¶
	if($updo['grade'] >= 3) {
		$setarr['upid'] = $updo['upid'];//¸üÄ¸Ò»¸ö¼¶±ð
	}

	$newid = inserttable('talkcomment', $setarr, 1);
	
	//¸üÐÂ»Ø¸´Êý
	$_SGLOBAL['db']->query("UPDATE ".tname('talk')." SET replynum=replynum+1 WHERE doid='$updo[doid]'");
	
	//Í¨Öª
	if($updo['uid'] != $_SGLOBAL['supe_uid']) {
		$note = cplang('note_talk_reply', array("space.php?do=talk&doid=$updo[doid]&highlight=$newid"));
		notification_add($updo['uid'], 'talk', $note);
		//½±Àø»ý·Ö
		getreward('comment',1, 0, 'talk'.$updo['doid']);
	}
	
	//Í³¼Æ
	updatestat('talkcomment');
		
	showmessage('do_success', $_POST['refer'], 0);

}

//É¾³ý
if($_GET['op'] == 'delete') {
	
	if(submitcheck('deletesubmit')) {
		if($id) {
			$allowmanage = checkperm('managetalk');
			$query = $_SGLOBAL['db']->query("SELECT dc.*, d.uid as duid FROM ".tname('talkcomment')." dc, ".tname('talk')." d WHERE dc.id='$id' AND dc.doid=d.doid");
			if($value = $_SGLOBAL['db']->fetch_array($query)) {
				if($allowmanage || $value['uid'] == $_SGLOBAL['supe_uid'] || $value['duid'] == $_SGLOBAL['supe_uid'] ) {
					//¸üÐÂÄÚÈÝ
					updatetable('talkcomment', array('uid'=>0, 'username'=>'', 'message'=>''), array('id'=>$id));
					if($value['uid'] != $_SGLOBAL['supe_uid'] && $value['duid'] != $_SGLOBAL['supe_uid']) {
						//¿Û³ý»ý·Ö
						getreward('delcomment', 1, $value['uid']);
					}
				}
			}
		} else {
			include_once(S_ROOT.'./source/function_delete.php');
			deletetalks(array($doid));
		}
		
		showmessage('do_success', $_POST['refer'], 0);
	}
	
} elseif ($_GET['op'] == 'getcomment') {
	
	include_once(S_ROOT.'./source/class_tree.php');
	$tree = new tree();
	
	$list = array();
	$highlight = 0;
	$count = 0;
	
	if(empty($_GET['close'])) {
		$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('talkcomment')." WHERE doid='$doid' ORDER BY dateline");
		while ($value = $_SGLOBAL['db']->fetch_array($query)) {
			realname_set($value['uid'], $value['username']);
			$tree->setNode($value['id'], $value['upid'], $value);
			$count++;
			if($value['authorid'] = $space['uid']) $highlight = $value['id'];
		}
	}
	
	if($count) {
		$values = $tree->getChilds();
		foreach ($values as $key => $vid) {
			$one = $tree->getValue($vid);
			$one['layer'] = $tree->getLayer($vid) * 2;
			$one['style'] = "padding-left:{$one['layer']}em;";
			if($one['id'] == $highlight && $one['uid'] == $space['uid']) {
				$one['style'] .= 'color:red;font-weight:bold;';
			}
			$list[] = $one;
		}
	}
	
	realname_get();
	
}

include template('cp_talk');

?>