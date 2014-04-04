<?php
/*
	[UCenter Home] (C) 2007-2008 Comsenz Inc.
	$Id: cp_poll.php 13245 2009-08-25 02:01:40Z liguode $
*/

if(!defined('IN_UCHOME')) {
	exit('Access Denied');
}

//�����Ϣ
$pollid = empty($_GET['pollid'])?0:intval($_GET['pollid']);
$op = empty($_GET['op'])?'':$_GET['op'];

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
		showmessage('no_authority_to_add_poll');
	}

	//ʵ����֤
	ckrealname('poll');
	
	//��Ƶ��֤
	ckvideophoto('poll');

	//���û���ϰ
	cknewuser();
	
	//�ж��Ƿ񷢲�̫��
	$waittime = interval_check('post');
	if($waittime > 0) {
		showmessage('operating_too_fast','',1,array($waittime));
	}
} else {
	if(!in_array($op, array('vote', 'get', 'invite')) && $_SGLOBAL['supe_uid'] != $poll['uid'] && !checkperm('managepoll')) {
		showmessage('no_authority_operation_of_the_poll');
	}
}

include_once(S_ROOT.'./source/function_bbcode.php');

if(submitcheck('pollsubmit')){

	$_POST['topicid'] = topic_check($_POST['topicid'], 'poll');
	
	//验证码
	if(checkperm('seccode') && !ckseccode($_POST['seccode'])) {
		showmessage('incorrect_code');
	}
	
	//�������20��
	$maxoption = 20;
	$newoption = $preview = $optionarr = $setarr = array();
	$_POST['subject'] = getstr(trim($_POST['subject']), 80, 1, 1, 1);
	if(strlen($_POST['subject']) < 2) showmessage('title_not_too_little');
	//����ͶƱ��
	$_POST['option'] = array_unique($_POST['option']);
	foreach($_POST['option'] as $key => $val) {
		$option = getstr(trim($val), 80, 1, 1, 1);
		if(strlen($option) && count($newoption) < $maxoption) {
			$newoption[] = $option;
			if(count($preview) < 2 ) {
				$preview[] = $option;
			}
		}
	}

	$maxoption = count($newoption);

	if(count($newoption)<2) {
		showmessage('add_at_least_two_further_options');
	}
	
	$_POST['credit'] = intval($_POST['credit']);
	$_POST['percredit'] = intval($_POST['percredit']);
	//��֤�����ܶ�����
	if($_POST['credit'] > $space['credit']) {
		showmessage('the_total_reward_should_not_overrun', '', 1, array($space['credit']));
	} elseif($_POST['credit'] < $_POST['percredit']) {
		showmessage('wrong_total_reward');
	} elseif($_POST['credit'] || $_POST['percredit']) {
		if(!$_POST['credit']) {
			showmessage('the_total_reward_should_not_be_empty');
		} elseif(!$_POST['percredit']) {
			showmessage('average_reward_should_not_be_empty');
		}
	}
	//��֤�������
	if($_POST['percredit'] && $_POST['percredit'] > $_SCONFIG['maxreward']) {
		showmessage('average_reward_can_not_exceed', '', 1, array($_SCONFIG['maxreward']));
	}
	
	//$_POST['message'] = getstr(trim($_POST['message']), 0, 1, 1, 1, 2);
	$maxchoice = $_POST['maxchoice'] < $maxoption ? intval($_POST['maxchoice']) : $maxoption;
	$expiration = 0;
	if($_POST['expiration']) {
		$expiration = sstrtotime(trim($_POST['expiration']).' 23:59:59');
		if($expiration <= $_SGLOBAL['timestamp']) {
			showmessage('time_expired_error');
		}
	}
	$setarr = array(
		'uid' => $_SGLOBAL['supe_uid'],
		'username' => $_SGLOBAL['supe_username'],
		'subject' => $_POST['subject'],
		'multiple' => $maxchoice > 1 ? 1 : 0,
		'maxchoice' => $maxchoice,
		'sex' => intval($_POST['sex']),
		'noreply' => intval($_POST['noreply']),
		'credit' => $_POST['credit'],
		'percredit' => $_POST['percredit'],
		'expiration' => $expiration,
		'dateline' => $_SGLOBAL['timestamp'],
		'topicid' => $_POST['topicid']
	);
	$pollid = inserttable('poll', $setarr, 1);
	$settarr = array(
		'pollid' => $pollid,
		'message' => $_POST['message'],
		'option' => saddslashes(serialize($preview))
	);
	inserttable('pollfield', $settarr);
	include("./source/upload.class.php");
  	$image= new upload;
  	$image->upload_file($pollid,"poll");
	foreach($newoption as $key => $value) {
		$optionarr[] = "('$pollid', '$value')";
	}
	//����ѡ��ֵ
	$id=$_SGLOBAL['db']->query("INSERT INTO ".tname('polloption')." (`pollid`, `option`) VALUES ".implode(',', $optionarr),1);

	//将选项的图片传入数据库
	include("./source/upload.class7.php");
	$yan=$_SGLOBAL['db']->query("SELECT * FROM ".tname('polloption')." WHERE pollid='$pollid' ORDER BY oid ASC");
	$i=1;
  	while($zong=$_SGLOBAL['db']->fetch_array($yan))
  	{
  		$img=new upload7($i++);
  		$img->upload_file($zong['oid']);
  	}
	$i=1;
	//�����û�ͳ��
	if(empty($space['pollnum'])) {
		$space['pollnum'] = getcount('poll', array('uid'=>$space['uid']));
		$pollnumsql = "pollnum=".$space['pollnum'];
	} else {
		$pollnumsql = 'pollnum=pollnum+1';
	}
	
	//���
	$reward = getreward('createpoll', 0);
	$updatecredit = $reward['credit'];
	//�ж��Ƿ�����
	if($_POST['credit']) {
		$updatecredit = $updatecredit - $_POST['credit'];
	}
	$_SGLOBAL['db']->query("UPDATE ".tname('space')." SET {$pollnumsql}, lastpost='$_SGLOBAL[timestamp]', updatetime='$_SGLOBAL[timestamp]', credit=credit+$updatecredit, experience=experience+$reward[experience] WHERE uid='$_SGLOBAL[supe_uid]'");
	
	//Feed
	if($_POST['makefeed']) {
		include_once(S_ROOT.'./source/function_feed.php');
		feed_publish($pollid, 'pollid', 1);
	}

	if($_POST['topicid']) {
		topic_join($_POST['topicid'], $_SGLOBAL['supe_uid'], $_SGLOBAL['supe_username']);
		$url = 'space.php?do=topic&topicid='.$_POST['topicid'].'&view=poll';
	} else {
		$url = 'space.php?uid='.$space['uid'].'&do=poll&pollid='.$pollid;
	}

	showmessage('do_success','space.php?uid='.$space['uid'].'&do=poll&pollid='.$pollid,0);

}

if($op == 'addopt') {

	//��֤�Ƿ񳬹����ͶƱ��
	$count = $_SGLOBAL['db']->result($_SGLOBAL['db']->query("SELECT COUNT(*) FROM ".tname('polloption')." p WHERE pollid='$pollid'"),0);
	if($count >= 20) {
		showmessage("option_exceeds_the_maximum_number_of", $_POST['refer']);
	}
	if(submitcheck('addopt')) {
		$newoption = getstr(trim($_POST['newoption']), 80, 1, 1, 1);
		if(strlen($newoption) < 1) {
			showmessage("added_option_should_not_be_empty");
		}
		$setarr = array(
			'pollid' => $pollid,
			'option' => $newoption
		);
		inserttable('polloption', $setarr);
		showmessage('do_success', $_POST['refer'], 0);
	}
	
} elseif($op == 'delete') {
	
	//ɾ��ͶƱ
	if(submitcheck('deletesubmit')) {

		include_once(S_ROOT.'./source/function_delete.php');
		if(deletepolls(array($pollid))) {
			showmessage('do_success', "space.php?uid=$poll[uid]&do=poll&view=me");
		} else {
			showmessage('failed_to_delete_operation');
		}
	}
	
} elseif($op == 'modify') {
	
	//修改投票时间
	if(submitcheck('modifysubmit')) {
		$expiration = 0;
		if($_POST['expiration']) {
			$expiration = sstrtotime(trim($_POST['expiration']).' 23:59:59');
			if($expiration <= $_SGLOBAL['timestamp']) {
				showmessage('time_expired_error', $_POST['refer']);
			}
		}
		updatetable('poll', array('expiration' => $expiration), array('pollid' => $_POST['pollid']));
		showmessage('do_success', 'space.php?uid='.$space['uid'].'&do=poll&pollid='.$_POST['pollid'], 0);
	}
	
} elseif($op == 'summary') {
	
	//ддͶƱ�ܽ�
	if(submitcheck('summarysubmit')) {
		
		$summary = getstr($_POST['summary'], 0, 1, 1, 1, 2);
		updatetable('pollfield', array('summary' => $summary), array('pollid' => $pollid));
		showmessage('do_success', 'space.php?uid='.$space['uid'].'&do=poll&pollid='.$pollid, 0);
	}
	//bbcodeת��
	$poll['summary'] = html2bbcode(str_replace('<br/>', "\n",$poll['summary']));//��ʾ��
	
} elseif($op == 'vote') {
	
	//��Ʊ
	if(submitcheck('votesubmit')) {
		if(empty($poll)) {
			showmessage("voting_does_not_exist");
		}
		//��֤�Ա�
		if($poll['sex'] && $poll['sex'] != $space['sex']) {
			showmessage('no_privilege');
		}
		//��֤�Ƿ�Ͷ��Ʊ
		$count = $_SGLOBAL['db']->result($_SGLOBAL['db']->query("SELECT COUNT(*) FROM ".tname('polluser')." WHERE uid='$_SGLOBAL[supe_uid]' AND pollid='$pollid'"),0);
		if($count) {
			showmessage("already_voted");
		}
		$list = $optionarr = $setarr = array();
		foreach($_POST['option'] as $key => $val) {
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
			showmessage('please_select_items_to_vote');
		}
		//�ۼ�ͶƱ��
		$_SGLOBAL['db']->query("UPDATE ".tname('polloption')." SET votenum=votenum+1 WHERE oid IN ('".implode("','", $optionarr)."') AND pollid='$pollid'");
		$setarr = array(
			'uid' => $_SGLOBAL['supe_uid'],
			'username' => $_POST['anonymous'] ? '': $_SGLOBAL['supe_username'],
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
		realname_get();
		if($poll['uid'] != $_SGLOBAL['supe_uid']) {
			//���ͻ��
			getreward('joinpoll', 1, 0, $pollid);
		}
		
		
		//�ȵ�
		if($poll['uid'] != $_SGLOBAL['supe_uid']) {
			hot_update('pollid', $poll['pollid'], $poll['hotuser']);
		}
		
		//ͳ��
		updatestat('pollvote');

		//�¼�feed
		
		if(!isset($_POST['anonymous']) && $_SGLOBAL['supe_uid']!=$poll['uid'] && ckprivacy('joinpoll', 1)) {
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
	
		showmessage('do_success', 'space.php?uid='.$poll['uid'].'&do=poll&pollid='.$pollid.($poll['percredit'] ? '&reward='.$poll['percredit'] : ''), 0);
	}
	
} elseif($op == 'endreward') {
	
	//��ֹ����
	if(submitcheck('endrewardsubmit')) {
		updatetable('poll', array('credit' => 0, 'percredit' => 0), array('pollid' => $pollid));
		$_SGLOBAL['db']->query("UPDATE ".tname('space')." SET credit=credit+$poll[credit] WHERE uid='$poll[uid]'");
		showmessage('do_success', 'space.php?uid='.$poll['uid'].'&do=poll&pollid='.$pollid, 0);
	}
} elseif($op == 'addreward') {
	
	//׷������
	if(submitcheck('addrewardsubmit')) {
		$credit = $_POST['addcredit'] ? intval($_POST['addcredit']) : 0;
		$percredit = $_POST['addpercredit'] ? intval($_POST['addpercredit']) : 0;

		if(!$credit && !$percredit) {
			showmessage('fill_in_at_least_an_additional_value');
		} elseif($credit > $space['credit']) {
			showmessage('the_total_reward_should_not_overrun', '', 1, array($space['credit']));
		} elseif(($credit+$poll['credit']) < ($percredit+$poll['percredit'])) {
			showmessage('wrong_total_reward');
		}
		
		//��֤�������
		if($percredit && ($percredit+$poll['percredit']) > $_SCONFIG['maxreward']) {
			showmessage('average_reward_can_not_exceed', '', 1, array($_SCONFIG['maxreward']));
		}
		if($credit) {
			$_SGLOBAL['db']->query("UPDATE ".tname('space')." SET credit=credit-$credit WHERE uid='$_SGLOBAL[supe_uid]'");
		}
		$_SGLOBAL['db']->query("UPDATE ".tname('poll')." SET credit=credit+$credit,percredit=percredit+$percredit WHERE pollid='$pollid'");
		showmessage('do_success', 'space.php?uid='.$poll['uid'].'&do=poll&pollid='.$pollid, 0);
	}
	$maxreward = $_SCONFIG['maxreward']-$poll['percredit'];
	
} elseif($op == 'get') {
	
	$perpage = 20;
	$page = empty($_GET['page'])?0:intval($_GET['page']);
	if($page<1) $page=1;
	$start = ($page-1)*$perpage;
	//��鿪ʼ��
	ckstart($start, $perpage);

	//ȡ��ͶƱ��¼
	$_GET['filtrate'] = empty($_GET['filtrate']) ? 'new' : trim($_GET['filtrate']);
	
	$wherearr = $voteresult = array();
	$multi = '';
	
	if($_GET['filtrate'] == 'we') {
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
		$multi = multi($count, $perpage, $page, "cp.php?ac=poll&op=get&pollid=$pollid&filtrate=".$_GET['filtrate'], 'showvoter');
		//ʵ��
		realname_get();
	}
	
} elseif($op == 'invite') {
	//����
	
	$uidarr = explode(',', $poll['invite']);
	//��ת����
	$newuid = array_flip($uidarr);
	if(submitcheck('invitesubmit')) {
		$ids = empty($_POST['ids'])?array():$_POST['ids'];
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
		showmessage('do_success', 'space.php?uid='.$poll['uid'].'&do=poll&pollid='.$pollid);
	}
	
	//��ҳ
	$perpage = 20;
	$page = empty($_GET['page'])?0:intval($_GET['page']);
	if($page<1) $page = 1;
	$start = ($page-1)*$perpage;
		
	//��鿪ʼ��
	ckstart($start, $perpage);
		
	$list = array();

	$wherearr = array();
	$_GET['key'] = stripsearchkey($_GET['key']);
	if($_GET['key']) {
		$wherearr[] = " fusername LIKE '%$_GET[key]%' ";
	}
		
	$_GET['group'] = isset($_GET['group'])?intval($_GET['group']):-1;
	if($_GET['group'] >= 0) {
		$wherearr[] = " gid='$_GET[group]'";
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
	
	realname_get();
		
	//�û���
	$groups = getfriendgroup();
	$groupselect = array($_GET['group'] => ' selected');
		
	$multi = multi($count, $perpage, $page, "cp.php?ac=poll&op=invite&pollid=$poll[pollid]&group=$_GET[group]&key=$_GET[key]");
	
} elseif($_GET['op'] == 'edithot') {
	//Ȩ��
	if(!checkperm('managepoll')) {
		showmessage('no_privilege');
	}
	
	if(submitcheck('hotsubmit')) {
		$_POST['hot'] = intval($_POST['hot']);
		updatetable('poll', array('hot'=>$_POST['hot']), array('pollid'=>$pollid));
		if($_POST['hot']>0) {
			include_once(S_ROOT.'./source/function_feed.php');
			feed_publish($pollid, 'pollid');
		} else {
			updatetable('feed', array('hot'=>$_POST['hot']), array('id'=>$pollid, 'idtype'=>'pollid'));
		}
		
		showmessage('do_success', "space.php?uid=$poll[uid]&do=poll&pollid=$pollid", 0);
	}
	
} else {
	
	//�����ȵ�
	$topic = array();
	$topicid = $_GET['topicid'] = intval($_GET['topicid']);
	if($topicid) {
		$topic = topic_get($topicid);
	}
	if($topic) {
		$actives = array('poll' => ' class="active"');
	}
	
}

include_once template("cp_poll");

?>