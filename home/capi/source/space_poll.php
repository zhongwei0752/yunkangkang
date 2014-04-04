<?php
/*
	[UCenter Home] (C) 2007-2008 Comsenz Inc.
	$Id: space_poll.php 13206 2009-08-20 02:31:30Z liguode $
*/

if(!defined('IN_UCHOME')) {
	exit('Access Denied');
}
$page = empty($_REQUEST['page'])?1:intval($_REQUEST['page']);
if($page<1) $page=1;
$pollid = empty($_REQUEST['id'])?0:intval($_REQUEST['id']);
$uid=empty($_GET['uid'])?0:intval($_GET['uid']);

if($pollid) {
	$newpoll = $hotpoll = $poll = $option = array();
	$query = $_SGLOBAL['db']->query("SELECT pf.*, p.* FROM ".tname('poll')." p LEFT JOIN ".tname('pollfield')." pf ON pf.pollid=p.pollid WHERE p.pollid='$pollid'");
	$poll = $_SGLOBAL['db']->fetch_array($query);
	if(empty($poll)) {
		capi_showmessage_by_data('view_to_info_did_not_exist');
	}
	
	if($poll['credit'] && $poll['percredit'] && $poll['credit'] < $poll['percredit']) {
		$poll['percredit'] = $poll['credit'];
	}
	realname_set($poll['uid'], $poll['username']);//???
	$allowedvote = true;
	
	if(!empty($poll['sex']) && $poll['sex'] != $_SGLOBAL['member']['sex']) {
		$allowedvote = false;
	}
	$expiration = false;
	if($poll['expiration'] && $poll['expiration'] < $_SGLOBAL['timestamp']) {
		$allowedvote = false;
		$expiration = true;
		if(empty($poll['summary']) && !$poll['notify']) {
			@include_once(S_ROOT.'./source/function_cp.php');
			$note = cplang('note_poll_finish', array("space.php?uid=$poll[uid]&do=poll&pollid=$poll[pollid]", $poll['subject']));
			$supe_uid = $_SGLOBAL['supe_uid'];
			$supe_username = $_SGLOBAL['supe_username'];
			$_SGLOBAL['supe_uid'] = 0;
			$_SGLOBAL['supe_username'] = '';
			notification_add($poll['uid'], 'poll', $note);
			$_SGLOBAL['supe_uid'] = $supe_uid;
			$_SGLOBAL['supe_username'] = $supe_username;
			updatetable('pollfield', array('notify'=>1), array('pollid'=>$poll['pollid']));
		}
	}
	
	$hasvoted = $_SGLOBAL['db']->result($_SGLOBAL['db']->query("SELECT COUNT(*) FROM ".tname('polluser')."  WHERE uid='$_SGLOBAL[supe_uid]' AND pollid='$pollid' "),0);
	//??????
	$allvote = 0;
	//???????????
	$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('polloption')." WHERE pollid='$pollid' ORDER BY oid");
	while($value = $_SGLOBAL['db']->fetch_array($query)) {
		$allvote += intval($value['votenum']);
		$option[] = $value;
	}
	//???????
	foreach($option as $key => $value) {
		if($value['votenum'] && $allvote) {
			$value['percent'] = round($value['votenum']/$allvote, 2);
			$value['width'] = round($value['percent']*160);
			$value['percent'] = $value['percent']*100;
		} else {
			$value['width'] = $value['percent'] = 0;
		}
		$option[$key] = $value;
	}
	$isfriend = 1;
	if($poll['noreply']) {
		//??????
		$isfriend = $space['self'];
		if($space['friends'] && in_array($_SGLOBAL['supe_uid'], $space['friends'])) {
			$isfriend = 1;//?????
		}
	}
	if($isfriend) {
		//????
		$count = $poll['replynum'];
		$list = array();
		if($count) {
			$cid = empty($_REQUEST['cid'])?0:intval($_REQUEST['cid']);
			$csql = $cid?"cid='$cid' AND":'';
	
			$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('comment')." WHERE $csql id='$pollid' AND idtype='pollid' ORDER BY dateline LIMIT $start,$perpage");
			while ($value = $_SGLOBAL['db']->fetch_array($query)) {
				realname_set($value['authorid'], $value['author']);//???
				$list[] = $value;
			}
		}
		//???
		$multi = multi($count, $perpage, $page, "space.php?uid=$poll[uid]&do=$do&pollid=$pollid", '', 'div_main_content');
	}
	//?????????
	$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('poll')." ORDER BY dateline DESC LIMIT 0, 10");
	while($value = $_SGLOBAL['db']->fetch_array($query)) {
		realname_set($value['uid'], $value['username']);//???
		$newpoll[] = $value;
	}
	
	//??????????
	$timerange = $_SGLOBAL['timestamp']-2592000;
	$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('poll')." WHERE lastvote >= '$timerange' ORDER BY voternum DESC LIMIT 0, 10");
	while($value = $_SGLOBAL['db']->fetch_array($query)) {
		realname_set($value['uid'], $value['username']);//???
		$hotpoll[] = $value;
	}
	
	//??????
	$topic = topic_REQUEST($poll['topicid']);
	
	//???
	realname_REQUEST();
	
	$_TPL['css'] = 'poll';
	
} else {
	
	$_REQUEST['view'] = $_REQUEST['view'] ? trim($_REQUEST['view']) : 'new';
	if($_REQUEST['view'] == 'all') $_REQUEST['view'] = 'new';
	//???
	$perpage = 5;
	$start = ($page-1)*$perpage;
	
	//??????
	ckstart($start, $perpage);
	
	$wherearr = $list = array();
	$userlist = array();
	$count = $pricount = 0;
	$wheresql = $indexsql = $leftsql = '';
	$ordersql = 'p.dateline';
	$counttable = tname('poll').' p ';
	
	if($_REQUEST['view'] == 'new') {
		
		$indexsql = 'USE INDEX (dateline)';
		$theurl = "space.php?uid=$space[uid]&do=$do&view=new";
		
	} elseif($_REQUEST['view'] == 'hot') {
		
		$_REQUEST['filtrate'] = empty($_REQUEST['filtrate']) ? 'all' : trim($_REQUEST['filtrate']);
		$indexsql = 'USE INDEX (voternum)';
		$ordersql = 'p.voternum';
		$timerange = 0;
		if($_REQUEST['filtrate']=='week') {
			$timerange = $_SGLOBAL['timestamp']-604800;
		} elseif($_REQUEST['filtrate']=='month') {
			$timerange = $_SGLOBAL['timestamp']-2592000;
		}
		if($timerange) {
			$wherearr[] = "p.lastvote >= '$timerange'";
		}
		$filtrate = array($_REQUEST['filtrate']=>' class="active"');
		$theurl = "space.php?uid=$space[uid]&do=$do&view=hot";
		
	} elseif($_REQUEST['view'] == 'friend') {
		
		$indexsql = 'USE INDEX (dateline)';
		$wherearr[] = "p.uid IN ($space[feedfriend])";
		$theurl = "space.php?uid=$space[uid]&do=$do&view=friend";
		
	} elseif($_REQUEST['view'] == 'reward') {
		
		$indexsql = 'USE INDEX (percredit)';
		$ordersql = 'p.percredit DESC, p.dateline';
		$wherearr[] = "p.percredit > 0";
		$theurl = "space.php?uid=$space[uid]&do=$do&view=reward";
		
	} else {
		
		$_REQUEST['filtrate'] = empty($_REQUEST['filtrate']) ? 'me' : trim($_REQUEST['filtrate']);
		
		if($_REQUEST['filtrate'] == 'join') {
			$leftsql = tname('polluser')." pu LEFT JOIN ";
			
			$indexsql = ' ON p.pollid=pu.pollid ';
			
			$wherearr[] = "pu.uid='$space[uid]'";
			$ordersql = 'pu.dateline';
			$counttable = tname('polluser').' pu ';

		} elseif($_REQUEST['filtrate'] == 'expiration') {
			$counttable = tname('polluser').' pu, '.tname('poll').' p';
			$ordersql = 'pu.dateline';
			$wherearr[] = "pu.uid='$space[uid]' AND pu.pollid=p.pollid  AND p.expiration>0 AND p.expiration<='$_SGLOBAL[timestamp]'";
		} else {
			$wherearr[] = "p.uid='$space[uid]'";
		}
		
		$filtrate = array($_REQUEST['filtrate']=>' class="active"');
		$theurl = "space.php?uid=$space[uid]&do=$do&view=me&filtrate=".$_REQUEST['filtrate'];
		
	}
	
	//????
	if($searchkey = stripsearchkey($_REQUEST['searchkey'])) {
		$wherearr[] = "p.subject LIKE '%$searchkey%'";
		$theurl .= "&searchkey=$_REQUEST[searchkey]";
		cksearch($theurl);
	}
		
	if($wherearr) {
		$wheresql = ' WHERE '.implode(' AND ', $wherearr);
		
	}
	$wheresql=" WHERE uid='$uid'";
	$count = $_SGLOBAL['db']->result($_SGLOBAL['db']->query("SELECT COUNT(*) FROM $counttable $wheresql"),0);

	//???????
	if($wheresql == "p.uid='$space[uid]'" && $space['pollnum'] != $count) {
		updatetable('space', array('pollnum' => $count), array('uid'=>$space['uid']));
	}
		
	if($count) {
		if($_REQUEST['filtrate'] == 'expiration') {
			$query = $_SGLOBAL['db']->query("SELECT p.*,pf.* FROM ".tname('polluser')." pu, ".tname('poll')." p,".tname('pollfield')." pf $wheresql AND p.pollid=pf.pollid	ORDER BY $ordersql DESC LIMIT $start,$perpage");
		} else {
			$query = $_SGLOBAL['db']->query("SELECT p.*,pf.* FROM $leftsql ".tname('poll')." p $indexsql
					LEFT JOIN ".tname('pollfield')." pf ON pf.pollid=p.pollid
					$wheresql
					ORDER BY $ordersql DESC LIMIT $start,$perpage");
		}
		while ($value = $_SGLOBAL['db']->fetch_array($query)) {
			if($value['credit'] && $value['percredit'] && $value['credit'] < $value['percredit']) {
				$value['percredit'] = $value['credit'];
			}
			realname_set($value['uid'], $value['username']);
			$value['option'] = unserialize($value['option']);
			$list[] = $value;
			$userlist[$value['uid']] = $value['username'];
		}
	}
	
	//???
	$multi = multi($count, $perpage, $page, $theurl);
	
	$actives = array($_REQUEST['view']=>' class="active"');
	
	$_TPL['css'] = 'poll';
	capi_showmessage_by_data("rest_success",0,array('poll'=>$list));
}

?>