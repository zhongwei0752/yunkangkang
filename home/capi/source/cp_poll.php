<?php
/*
	[UCenter Home] (C) 2007-2008 Comsenz Inc.
	$Id: cp_poll.php 13245 2009-08-25 02:01:40Z liguode $
*/

if(!defined('IN_UCHOME')) {
	exit('Access Denied');
}

//�����Ϣ
$pollid = empty($_REQUEST['pollid'])?0:intval($_REQUEST['pollid']);
$op = empty($_REQUEST['op'])?'':$_REQUEST['op'];

$poll = array();
$_SCONFIG['maxreward'] = $_SCONFIG['maxreward'] < 2 ? 10 : $_SCONFIG['maxreward'];

if($pollid) {
	$query = $_SGLOBAL['db']->query("SELECT pf.*, p.* FROM ".tname('poll')." p 
		LEFT JOIN ".tname('pollfield')." pf ON pf.pollid=p.pollid 
		WHERE p.pollid='$pollid'");
	$poll = $_SGLOBAL['db']->fetch_array($query);
	realname_set($poll['uid'], $poll['username']);
}

//Ȩ�޼��
if(empty($poll)) {
	
	if(!checkperm('allowpoll')) {
		ckspacelog();
		capi_showmessage_by_data('no_authority_to_add_poll');
	}

	//ʵ����֤
	ckrealname('poll');
	
	//��Ƶ��֤
	ckvideophoto('poll');

	//���û���ϰ
	cknewuser();
	
	//�ж��Ƿ񷢲�̫��
	$waittime = interval_check('REQUEST');
	if($waittime > 0) {
		capi_showmessage_by_data('operating_too_fast','',1,array($waittime));
	}
	
} else {
	if(!in_array($op, array('vote', 'REQUEST', 'invite')) && $_SGLOBAL['supe_uid'] != $poll['uid'] && !checkperm('managepoll')) {
		capi_showmessage_by_data('no_authority_operation_of_the_poll');
	}
}

include_once(S_ROOT.'./source/function_bbcode.php');

if(submitcheck('pollsubmit')) {
	
	$_REQUEST['topicid'] = topic_check($_REQUEST['topicid'], 'poll');
	
	//��֤��
	if(checkperm('seccode') && !ckseccode($_REQUEST['seccode'])) {
		capi_showmessage_by_data('incorrect_code');
	}
	
	//�������20��
	$maxoption = 20;
	$newoption = $preview = $optionarr = $setarr = array();
	$_REQUEST['subject'] = REQUESTstr(trim($_REQUEST['subject']), 80, 1, 1, 1);
	if(strlen($_REQUEST['subject']) < 2) capi_showmessage_by_data('title_not_too_little');
	
	//����ͶƱ��
	$_REQUEST['option'] = array_unique($_REQUEST['option']);
	foreach($_REQUEST['option'] as $key => $val) {
		$option = REQUESTstr(trim($val), 80, 1, 1, 1);
		if(strlen($option) && count($newoption) < $maxoption) {
			$newoption[] = $option;
			if(count($preview) < 2 ) {
				$preview[] = $option;
			}
		}
	}

	$maxoption = count($newoption);

	if(count($newoption)<2) {
		capi_showmessage_by_data('add_at_least_two_further_options');
	}
	
	$_REQUEST['credit'] = intval($_REQUEST['credit']);
	$_REQUEST['percredit'] = intval($_REQUEST['percredit']);
	//��֤�����ܶ�����
	if($_REQUEST['credit'] > $space['credit']) {
		capi_showmessage_by_data('the_total_reward_should_not_overrun', '', 1, array($space['credit']));
	} elseif($_REQUEST['credit'] < $_REQUEST['percredit']) {
		capi_showmessage_by_data('wrong_total_reward');
	} elseif($_REQUEST['credit'] || $_REQUEST['percredit']) {
		if(!$_REQUEST['credit']) {
			capi_showmessage_by_data('the_total_reward_should_not_be_empty');
		} elseif(!$_REQUEST['percredit']) {
			capi_showmessage_by_data('average_reward_should_not_be_empty');
		}
	}
	//��֤�������
	if($_REQUEST['percredit'] && $_REQUEST['percredit'] > $_SCONFIG['maxreward']) {
		capi_showmessage_by_data('average_reward_can_not_exceed', '', 1, array($_SCONFIG['maxreward']));
	}
	
	$_REQUEST['message'] = REQUESTstr(trim($_REQUEST['message']), 0, 1, 1, 1, 2);
	$maxchoice = $_REQUEST['maxchoice'] < $maxoption ? intval($_REQUEST['maxchoice']) : $maxoption;
	$expiration = 0;
	if($_REQUEST['expiration']) {
		$expiration = sstrtotime(trim($_REQUEST['expiration']).' 23:59:59');
		if($expiration <= $_SGLOBAL['timestamp']) {
			capi_showmessage_by_data('time_expired_error');
		}
	}
	$setarr = array(
		'uid' => $_SGLOBAL['supe_uid'],
		'username' => $_SGLOBAL['supe_username'],
		'subject' => $_REQUEST['subject'],
		'multiple' => $maxchoice > 1 ? 1 : 0,
		'maxchoice' => $maxchoice,
		'sex' => intval($_REQUEST['sex']),
		'noreply' => intval($_REQUEST['noreply']),
		'credit' => $_REQUEST['credit'],
		'percredit' => $_REQUEST['percredit'],
		'expiration' => $expiration,
		'dateline' => $_SGLOBAL['timestamp'],
		'topicid' => $_REQUEST['topicid']
	);
	
	$pollid = inserttable('poll', $setarr, 1);
	$setarr = array(
		'pollid' => $pollid,
		'message' => $_REQUEST['message'],
		'option' => saddslashes(serialize($preview))
	);
	inserttable('pollfield', $setarr);
	include("./source/upload.class.php");
  	$image= new upload;
  	$image->upload_file($pollid,"poll");
	
	foreach($newoption as $key => $value) {
		$optionarr[] = "('$pollid', '$value')";
	}
	
	//����ѡ��ֵ
	$_SGLOBAL['db']->query("INSERT INTO ".tname('polloption')." (`pollid`, `option`) VALUES ".implode(',', $optionarr));
	
	//ͳ��
	updatestat('poll');
	
	//�����û�ͳ��
	if(empty($space['pollnum'])) {
		$space['pollnum'] = REQUESTcount('poll', array('uid'=>$space['uid']));
		$pollnumsql = "pollnum=".$space['pollnum'];
	} else {
		$pollnumsql = 'pollnum=pollnum+1';
	}
	
	//���
	$reward = REQUESTreward('createpoll', 0);
	$updatecredit = $reward['credit'];
	//�ж��Ƿ�����
	if($_REQUEST['credit']) {
		$updatecredit = $updatecredit - $_REQUEST['credit'];
	}
	$_SGLOBAL['db']->query("UPDATE ".tname('space')." SET {$pollnumsql}, lastREQUEST='$_SGLOBAL[timestamp]', updatetime='$_SGLOBAL[timestamp]', credit=credit+$updatecredit, experience=experience+$reward[experience] WHERE uid='$_SGLOBAL[supe_uid]'");
	
	//Feed
	if($_REQUEST['makefeed']) {
		include_once(S_ROOT.'./source/function_feed.php');
		feed_publish($pollid, 'pollid', 1);
	}

	if($_REQUEST['topicid']) {
		topic_join($_REQUEST['topicid'], $_SGLOBAL['supe_uid'], $_SGLOBAL['supe_username']);
		$url = 'space.php?do=topic&topicid='.$_REQUEST['topicid'].'&view=poll';
	} else {
		$url = 'space.php?uid='.$space['uid'].'&do=poll&pollid='.$pollid;
	}

	capi_showmessage_by_data('do_success', $url, 0);

}

if($op == 'addopt') {

	//��֤�Ƿ񳬹����ͶƱ��
	$count = $_SGLOBAL['db']->result($_SGLOBAL['db']->query("SELECT COUNT(*) FROM ".tname('polloption')." p WHERE pollid='$pollid'"),0);
	if($count >= 20) {
		capi_showmessage_by_data("option_exceeds_the_maximum_number_of", $_REQUEST['refer']);
	}
	if(submitcheck('addopt')) {
		$newoption = REQUESTstr(trim($_REQUEST['newoption']), 80, 1, 1, 1);
		if(strlen($newoption) < 1) {
			capi_showmessage_by_data("added_option_should_not_be_empty");
		}
		$setarr = array(
			'pollid' => $pollid,
			'option' => $newoption
		);
		inserttable('polloption', $setarr);
		capi_showmessage_by_data('do_success', $_REQUEST['refer'], 0);
	}
	
} elseif($op == 'delete') {
	
	//ɾ��ͶƱ
	if(submitcheck('deletesubmit')) {

		include_once(S_ROOT.'./source/function_delete.php');
		if(deletepolls(array($pollid))) {
			capi_showmessage_by_data('do_success', "space.php?uid=$poll[uid]&do=poll&view=me");
		} else {
			capi_showmessage_by_data('failed_to_delete_operation');
		}
	}
	
} elseif($op == 'modify') {
	
	//�޸Ľ���ʱ��
	if(submitcheck('modifysubmit')) {
		$expiration = 0;
		if($_REQUEST['expiration']) {
			$expiration = sstrtotime(trim($_REQUEST['expiration']).' 23:59:59');
			if($expiration <= $_SGLOBAL['timestamp']) {
				capi_showmessage_by_data('time_expired_error', $_REQUEST['refer']);
			}
		}
		updatetable('poll', array('expiration' => $expiration), array('pollid' => $pollid));
		capi_showmessage_by_data('do_success', 'space.php?uid='.$space['uid'].'&do=poll&pollid='.$pollid, 0);
	}
	
} elseif($op == 'summary') {
	
	//ддͶƱ�ܽ�
	if(submitcheck('summarysubmit')) {
		
		$summary = REQUESTstr($_REQUEST['summary'], 0, 1, 1, 1, 2);
		updatetable('pollfield', array('summary' => $summary), array('pollid' => $pollid));
		capi_showmessage_by_data('do_success', 'space.php?uid='.$space['uid'].'&do=poll&pollid='.$pollid, 0);
	}
	//bbcodeת��
	$poll['summary'] = html2bbcode(str_replace('<br/>', "\n",$poll['summary']));//��ʾ��
	
} elseif($op == 'vote') {
	
	//��Ʊ
	if(submitcheck('votesubmit')) {
		if(empty($poll)) {
			capi_showmessage_by_data("voting_does_not_exist");
		}
		//��֤�Ա�
		if($poll['sex'] && $poll['sex'] != $space['sex']) {
			capi_showmessage_by_data('no_privilege');
		}
		//��֤�Ƿ�Ͷ��Ʊ
		$count = $_SGLOBAL['db']->result($_SGLOBAL['db']->query("SELECT COUNT(*) FROM ".tname('polluser')." WHERE uid='$_SGLOBAL[supe_uid]' AND pollid='$pollid'"),0);
		if($count) {
			capi_showmessage_by_data("already_voted");
		}
		$list = $optionarr = $setarr = array();
		foreach($_REQUEST['option'] as $key => $val) {
			$optionarr[] = intval($val);
			if(count($optionarr) >= $poll['maxchoice']) {
				break;
			}
		}
		
		$query = $_SGLOBAL['db']->query("SELECT `option` FROM ".tname('polloption')." WHERE oid IN ('".implode("','", $optionarr)."') AND pollid='$pollid'");
		while($value = $_SGLOBAL['db']->fetch_array($query)) {
			$list[] = saddslashes($value['option']);
		}
		if(empty($list)) {
			capi_showmessage_by_data('please_select_items_to_vote');
		}
		//�ۼ�ͶƱ��
		$_SGLOBAL['db']->query("UPDATE ".tname('polloption')." SET votenum=votenum+1 WHERE oid IN ('".implode("','", $optionarr)."') AND pollid='$pollid'");
		$setarr = array(
			'uid' => $_SGLOBAL['supe_uid'],
			'username' => $_REQUEST['anonymous'] ? '': $_SGLOBAL['supe_username'],
			'pollid' => $pollid,
			'option' => saddslashes('"'.implode(cplang('poll_separator'), $list).'"'),
			'dateline' => $_SGLOBAL['timestamp']
		);
		inserttable('polluser', $setarr);
		
		$sql = '';
		//�ж��Ƿ�����
		if($poll['credit'] && $poll['percredit'] && $poll['uid'] != $_SGLOBAL['supe_uid']) {
			if($poll['credit'] <= $poll['percredit']) {
				$poll['percredit'] = $poll['credit'];
				$sql = ',percredit=0';
			}
			$_SGLOBAL['db']->query("UPDATE ".tname('space')." SET credit=credit+$poll[percredit] WHERE uid='$_SGLOBAL[supe_uid]'");
		} else {
			$poll['percredit'] = 0;
		}
		
		$_SGLOBAL['db']->query("UPDATE ".tname('poll')." SET voternum=voternum+1, lastvote='$_SGLOBAL[timestamp]', credit=credit-$poll[percredit] $sql WHERE pollid='$pollid'");
		
		//ʵ��
		realname_REQUEST();
		if($poll['uid'] != $_SGLOBAL['supe_uid']) {
			//���ͻ��
			REQUESTreward('joinpoll', 1, 0, $pollid);
		}
		
		
		//�ȵ�
		if($poll['uid'] != $_SGLOBAL['supe_uid']) {
			hot_update('pollid', $poll['pollid'], $poll['hotuser']);
		}
		
		//ͳ��
		updatestat('pollvote');

		//�¼�feed
		
		if(!isset($_REQUEST['anonymous']) && $_SGLOBAL['supe_uid']!=$poll['uid'] && ckprivacy('joinpoll', 1)) {
			$fs = array();
			$fs['icon'] = 'poll';

			$fs['images'] = $fs['image_links'] = array();
				
			$fs['title_template'] = cplang('take_part_in_the_voting');
			$fs['title_data'] = array(
				'touser' => "<a href=\"space.php?uid=$poll[uid]\">".$_SN[$poll['uid']]."</a>",
				'url' => "space.php?uid=$poll[uid]&do=poll&pollid=$pollid",
				'subject' => $poll['subject'],
				'reward' => $poll['percredit'] ? cplang('reward') : ''
			);
	
			$fs['body_template'] = '';
			$fs['body_data'] = array();
			include_once(S_ROOT.'./source/function_cp.php');
			feed_add($fs['icon'], $fs['title_template'], $fs['title_data'], $fs['body_template'], $fs['body_data']);
		}
	
		capi_showmessage_by_data('do_success', 'space.php?uid='.$poll['uid'].'&do=poll&pollid='.$pollid.($poll['percredit'] ? '&reward='.$poll['percredit'] : ''), 0);
	}
	
} elseif($op == 'endreward') {
	
	//��ֹ����
	if(submitcheck('endrewardsubmit')) {
		updatetable('poll', array('credit' => 0, 'percredit' => 0), array('pollid' => $pollid));
		$_SGLOBAL['db']->query("UPDATE ".tname('space')." SET credit=credit+$poll[credit] WHERE uid='$poll[uid]'");
		capi_showmessage_by_data('do_success', 'space.php?uid='.$poll['uid'].'&do=poll&pollid='.$pollid, 0);
	}
} elseif($op == 'addreward') {
	
	//׷������
	if(submitcheck('addrewardsubmit')) {
		$credit = $_REQUEST['addcredit'] ? intval($_REQUEST['addcredit']) : 0;
		$percredit = $_REQUEST['addpercredit'] ? intval($_REQUEST['addpercredit']) : 0;

		if(!$credit && !$percredit) {
			capi_showmessage_by_data('fill_in_at_least_an_additional_value');
		} elseif($credit > $space['credit']) {
			capi_showmessage_by_data('the_total_reward_should_not_overrun', '', 1, array($space['credit']));
		} elseif(($credit+$poll['credit']) < ($percredit+$poll['percredit'])) {
			capi_showmessage_by_data('wrong_total_reward');
		}
		
		//��֤�������
		if($percredit && ($percredit+$poll['percredit']) > $_SCONFIG['maxreward']) {
			capi_showmessage_by_data('average_reward_can_not_exceed', '', 1, array($_SCONFIG['maxreward']));
		}
		if($credit) {
			$_SGLOBAL['db']->query("UPDATE ".tname('space')." SET credit=credit-$credit WHERE uid='$_SGLOBAL[supe_uid]'");
		}
		$_SGLOBAL['db']->query("UPDATE ".tname('poll')." SET credit=credit+$credit,percredit=percredit+$percredit WHERE pollid='$pollid'");
		capi_showmessage_by_data('do_success', 'space.php?uid='.$poll['uid'].'&do=poll&pollid='.$pollid, 0);
	}
	$maxreward = $_SCONFIG['maxreward']-$poll['percredit'];
	
} elseif($op == 'REQUEST') {
	
	$perpage = 20;
	$page = empty($_REQUEST['page'])?0:intval($_REQUEST['page']);
	if($page<1) $page=1;
	$start = ($page-1)*$perpage;
	//��鿪ʼ��
	ckstart($start, $perpage);

	//ȡ��ͶƱ��¼
	$_REQUEST['filtrate'] = empty($_REQUEST['filtrate']) ? 'new' : trim($_REQUEST['filtrate']);
	
	$wherearr = $voteresult = array();
	$multi = '';
	
	if($_REQUEST['filtrate'] == 'we') {
		if(empty($space['feedfriend']))	$space['feedfriend'] = 0;	//���ؿ�����
		$wherearr[] = "uid IN ($space[feedfriend])";
	}
	$wherearr[] = "pollid='$pollid'";
	$wheresql = ' WHERE '.implode(' AND ', $wherearr);

	$count = $_SGLOBAL['db']->result($_SGLOBAL['db']->query("SELECT COUNT(*) FROM ".tname('polluser')." $wheresql"),0);
	if($count) {
		$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('polluser')." $wheresql ORDER BY dateline DESC LIMIT $start,$perpage");
		while($value = $_SGLOBAL['db']->fetch_array($query)) {
			realname_set($value['uid'], $value['username']);//ʵ��
			$voteresult[] = $value;
		}
		$multi = multi($count, $perpage, $page, "cp.php?ac=poll&op=REQUEST&pollid=$pollid&filtrate=".$_REQUEST['filtrate'], 'showvoter');
		//ʵ��
		realname_REQUEST();
	}
	
} elseif($op == 'invite') {
	//����
	
	$uidarr = explode(',', $poll['invite']);
	//��ת����
	$newuid = array_flip($uidarr);
	if(submitcheck('invitesubmit')) {
		$ids = empty($_REQUEST['ids'])?array():$_REQUEST['ids'];
		if($ids) {
			//������������û�
			foreach($ids as $key => $uid) {
				if(isset($newuid[$uid])) {
					unset($ids[$key]);
				} else {
					$ids[$key] = intval($uid);
				}
			}
			
			//��֤�û�����ʵ��
			$query = $_SGLOBAL['db']->query("SELECT uid FROM ".tname('space')." WHERE uid IN (".simplode($ids).")");
			$ids = array();
			while($value = $_SGLOBAL['db']->fetch_array($query)) {
				$ids[$value['uid']] = $value['uid'];
			}
			
			//������ͶƱ���û�
			$query = $_SGLOBAL['db']->query("SELECT uid FROM ".tname('polluser')." WHERE uid IN (".simplode($ids).") AND pollid='$pollid'");
			while($value = $_SGLOBAL['db']->fetch_array($query)) {
				unset($ids[$value['uid']]);
			}
			//�ϲ�������
			$newinvite = array_merge($uidarr, $ids);
			
			//������ݿ�
			if($newinvite) {
				$_SGLOBAL['db']->query("UPDATE ".tname('pollfield')." SET invite='".implode(',', $newinvite)."' WHERE pollid='$pollid'");
			}
			//֪ͨ
			$note = cplang('note_poll_invite', array("space.php?uid=$poll[uid]&do=poll&pollid=$poll[pollid]", $poll['subject'], $poll['percredit']?cplang('reward'):''));
			foreach($ids as $key => $uid) {
				if($uid && $uid != $_SGLOBAL['supe_uid']) {
					notification_add($uid, 'pollinvite', $note);
				}
			}
		}
		capi_showmessage_by_data('do_success', 'space.php?uid='.$poll['uid'].'&do=poll&pollid='.$pollid);
	}
	
	//��ҳ
	$perpage = 20;
	$page = empty($_REQUEST['page'])?0:intval($_REQUEST['page']);
	if($page<1) $page = 1;
	$start = ($page-1)*$perpage;
		
	//��鿪ʼ��
	ckstart($start, $perpage);
		
	$list = array();

	$wherearr = array();
	$_REQUEST['key'] = stripsearchkey($_REQUEST['key']);
	if($_REQUEST['key']) {
		$wherearr[] = " fusername LIKE '%$_REQUEST[key]%' ";
	}
		
	$_REQUEST['group'] = isset($_REQUEST['group'])?intval($_REQUEST['group']):-1;
	if($_REQUEST['group'] >= 0) {
		$wherearr[] = " gid='$_REQUEST[group]'";
	}

	$sql = $wherearr ? 'AND'.implode(' AND ', $wherearr) : '';
		
	$count = $_SGLOBAL['db']->result($_SGLOBAL['db']->query("SELECT COUNT(*) FROM ".tname('friend')." WHERE uid='$_SGLOBAL[supe_uid]' AND status='1' $sql"), 0);
		
	$fuids = array();
	if($count) {
		$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('friend')." WHERE uid='$_SGLOBAL[supe_uid]' AND status='1' $sql ORDER BY num DESC, dateline DESC LIMIT $start,$perpage");
		while ($value = $_SGLOBAL['db']->fetch_array($query)) {
			realname_set($value['fuid'], $value['fusername']);
			$list[] = $value;
			$fuids[] = $value['fuid'];
		}
	}
	$invitearr = array();
	
	//�Ѿ�����ͶƱ
	$query = $_SGLOBAL['db']->query("SELECT uid FROM ".tname('polluser')." WHERE uid IN (".simplode($fuids).") AND pollid='$pollid'");
	while ($value = $_SGLOBAL['db']->fetch_array($query)) {
		$invitearr[$value['uid']] = $value['uid'];
	}
	
	//������
	foreach($uidarr as $key => $uid) {
		$invitearr[$uid] = $uid;
	}
	
	realname_REQUEST();
		
	//�û���
	$groups = REQUESTfriendgroup();
	$groupselect = array($_REQUEST['group'] => ' selected');
		
	$multi = multi($count, $perpage, $page, "cp.php?ac=poll&op=invite&pollid=$poll[pollid]&group=$_REQUEST[group]&key=$_REQUEST[key]");
	
} elseif($_REQUEST['op'] == 'edithot') {
	//Ȩ��
	if(!checkperm('managepoll')) {
		capi_showmessage_by_data('no_privilege');
	}
	
	if(submitcheck('hotsubmit')) {
		$_REQUEST['hot'] = intval($_REQUEST['hot']);
		updatetable('poll', array('hot'=>$_REQUEST['hot']), array('pollid'=>$pollid));
		if($_REQUEST['hot']>0) {
			include_once(S_ROOT.'./source/function_feed.php');
			feed_publish($pollid, 'pollid');
		} else {
			updatetable('feed', array('hot'=>$_REQUEST['hot']), array('id'=>$pollid, 'idtype'=>'pollid'));
		}
		
		capi_showmessage_by_data('do_success', "space.php?uid=$poll[uid]&do=poll&pollid=$pollid", 0);
	}
	
} else {
	
	//�����ȵ�
	$topic = array();
	$topicid = $_REQUEST['topicid'] = intval($_REQUEST['topicid']);
	if($topicid) {
		$topic = topic_REQUEST($topicid);
	}
	if($topic) {
		$actives = array('poll' => ' class="active"');
	}
	
}

include_once template("cp_poll");

?>