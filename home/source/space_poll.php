<?php
/*
	[UCenter Home] (C) 2007-2008 Comsenz Inc.
	$Id: space_poll.php 13206 2009-08-20 02:31:30Z liguode $
*/
if(!defined('IN_UCHOME')) {
	exit('Access Denied');
}

$page = empty($_GET['page'])?1:intval($_GET['page']);
if($page<1) $page=1;
$pollid = empty($_GET['pollid'])?0:intval($_GET['pollid']);
$uid=$_SGLOBAL['supe_uid'];

if($pollid) {
	
	
	$perpage = 20;
	$start = ($page-1)*$perpage;
	//��鿪ʼ��
	ckstart($start, $perpage);
		
	$newpoll = $hotpoll = $poll = $option = array();
	$query = $_SGLOBAL['db']->query("SELECT pf.*, p.* FROM ".tname('poll')." p LEFT JOIN ".tname('pollfield')." pf ON pf.pollid=p.pollid WHERE p.pollid='$pollid'");
	$poll = $_SGLOBAL['db']->fetch_array($query);
	if(empty($poll)) {
		showmessage('view_to_info_did_not_exist');
	}
	
	if($poll['credit'] && $poll['percredit'] && $poll['credit'] < $poll['percredit']) {
		$poll['percredit'] = $poll['credit'];
	}
	realname_set($poll['uid'], $poll['username']);//ʵ��
	//����ͶƱ
	$allowedvote = true;
	
	if(!empty($poll['sex']) && $poll['sex'] != $_SGLOBAL['member']['sex']) {
		$allowedvote = false;
	}
	$expiration = false;
	//����ͬ���ֹͶƱ
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
	//��ͶƱ��
	$allvote = 0;
	//ȡ������ͶƱ��
	$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('polloption')." WHERE pollid='$pollid' ORDER BY oid");
	while($value = $_SGLOBAL['db']->fetch_array($query)) {
		$allvote += intval($value['votenum']);
		$option[] = $value;
	}
	//����ٷֱ�
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
		//�Ƿ����
		$isfriend = $space['self'];
		if($space['friends'] && in_array($_SGLOBAL['supe_uid'], $space['friends'])) {
			$isfriend = 1;//�Ǻ���
		}
	}
	if($isfriend) {
		//����
		$count = $poll['replynum'];
		$list = array();
		if($count) {
			$cid = empty($_GET['cid'])?0:intval($_GET['cid']);
			$csql = $cid?"cid='$cid' AND":'';
	
			$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('poll_comment')." WHERE pollid='$pollid' ORDER BY dateline LIMIT $start,$perpage");
			while ($value = $_SGLOBAL['db']->fetch_array($query)) {
				//realname_set($value['authorid'], $value['author']);//ʵ��
				$list[] = $value;
			}
		}
		//��ҳ
		$multi = multi($count, $perpage, $page, "space.php?uid=$poll[uid]&do=$do&pollid=$pollid", '', 'div_main_content');
	}
	//ȡ������ͶƱ
	$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('poll')." ORDER BY dateline DESC LIMIT 0, 10");
	while($value = $_SGLOBAL['db']->fetch_array($query)) {
		realname_set($value['uid'], $value['username']);//ʵ��
		$newpoll[] = $value;
	}
	
	//ȡ�����ȵ�ͶƱ
	$timerange = $_SGLOBAL['timestamp']-2592000;
	$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('poll')." WHERE lastvote >= '$timerange' ORDER BY voternum DESC LIMIT 0, 10");
	while($value = $_SGLOBAL['db']->fetch_array($query)) {
		realname_set($value['uid'], $value['username']);//ʵ��
		$hotpoll[] = $value;
	}
	
	//����ȵ�
	$topic = topic_get($poll['topicid']);
	//ʵ��
	realname_get();
	
	$_TPL['css'] = 'poll';
	include_once template("space_poll_view");
	
} 
else {
	

	$_GET['view'] = $_GET['view'] ? trim($_GET['view']) : 'new';
	if($_GET['view'] == 'all') $_GET['view'] = 'new';
	//��ҳ
	$perpage = 5;
	$start = ($page-1)*$perpage;
	
	//��鿪ʼ��
	ckstart($start, $perpage);
	
	$wherearr = $list = array();
	$userlist = array();
	$count = $pricount = 0;
	$wheresql = $indexsql = $leftsql = '';
	$ordersql = 'p.dateline';
	$counttable = tname('poll').' p ';
	
	if($_GET['view'] == 'new') {
		
		$indexsql = 'USE INDEX (dateline)';
		$theurl = "space.php?uid=$space[uid]&do=$do&view=new";
		
	} elseif($_GET['view'] == 'hot') {
		
		$_GET['filtrate'] = empty($_GET['filtrate']) ? 'all' : trim($_GET['filtrate']);
		$indexsql = 'USE INDEX (voternum)';
		$ordersql = 'p.voternum';
		$timerange = 0;
		if($_GET['filtrate']=='week') {
			$timerange = $_SGLOBAL['timestamp']-604800;
		} elseif($_GET['filtrate']=='month') {
			$timerange = $_SGLOBAL['timestamp']-2592000;
		}
		if($timerange) {
			$wherearr[] = "p.lastvote >= '$timerange'";
		}
		$filtrate = array($_GET['filtrate']=>' class="active"');
		$theurl = "space.php?uid=$space[uid]&do=$do&view=hot";
		
	} elseif($_GET['view'] == 'friend') {
		
		$indexsql = 'USE INDEX (dateline)';
		$wherearr[] = "p.uid IN ($space[feedfriend])";
		$theurl = "space.php?uid=$space[uid]&do=$do&view=friend";
		
	} elseif($_GET['view'] == 'reward') {
		
		$indexsql = 'USE INDEX (percredit)';
		$ordersql = 'p.percredit DESC, p.dateline';
		$wherearr[] = "p.percredit > 0";
		$theurl = "space.php?uid=$space[uid]&do=$do&view=reward";
		
	} else {
		
		$_GET['filtrate'] = empty($_GET['filtrate']) ? 'me' : trim($_GET['filtrate']);
		
		if($_GET['filtrate'] == 'join') {
			$leftsql = tname('polluser')." pu LEFT JOIN ";
			
			$indexsql = ' ON p.pollid=pu.pollid ';
			
			$wherearr[] = "pu.uid='$space[uid]'";
			$ordersql = 'pu.dateline';
			$counttable = tname('polluser').' pu ';

		} elseif($_GET['filtrate'] == 'expiration') {
			$counttable = tname('polluser').' pu, '.tname('poll').' p';
			$ordersql = 'pu.dateline';
			$wherearr[] = "pu.uid='$space[uid]' AND pu.pollid=p.pollid  AND p.expiration>0 AND p.expiration<='$_SGLOBAL[timestamp]'";
		} else {
			$wherearr[] = "p.uid='$space[uid]'";
		}
		
		$filtrate = array($_GET['filtrate']=>' class="active"');
		$theurl = "space.php?uid=$space[uid]&do=$do&view=me&filtrate=".$_GET['filtrate'];
		
	}
	
	//����
	if($searchkey = stripsearchkey($_GET['searchkey'])) {
		$wherearr[] = "p.subject LIKE '%$searchkey%'";
		$theurl .= "&searchkey=$_GET[searchkey]";
		cksearch($theurl);
	}
		
	if($wherearr) {
		$wheresql = ' WHERE '.implode(' AND ', $wherearr);
		
	}
	$wheresql="WHERE uid='$uid'";
	$count = $_SGLOBAL['db']->result($_SGLOBAL['db']->query("SELECT COUNT(*) FROM $counttable $wheresql"),0);

	//����ͳ��
	if($wheresql == "p.uid='$space[uid]'" && $space['pollnum'] != $count) {
		updatetable('space', array('pollnum' => $count), array('uid'=>$space['uid']));
	}
		
	if($count) {
		if($_GET['filtrate'] == 'expiration') {
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
	
	//��ҳ
	$multi = multi($count, $perpage, $page, $theurl);

	//ʵ��
	realname_get();
	
	$actives = array($_GET['view']=>' class="active"');
	
	$_TPL['css'] = 'poll';
	include_once template("space_poll_list");
}

?>