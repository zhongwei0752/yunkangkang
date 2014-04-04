<?php
/*
	[UCenter Home] (C) 2007-2008 Comsenz Inc.
	$Id: class_tree.php 8006 2008-07-09 05:59:42Z liguode $
*/

if(!defined('IN_UCHOME')) {
	exit('Access Denied');
}

$eventid = isset($_GET['id']) ? intval($_GET['id']) : 0;
$op = empty($_GET['op']) ? "edit" : $_GET['op'];

$menus = array();
$menus[$op] = " class='active'";

// ��֤��Ƿ���ڼ���ǰ�û����Ĺ�ϵ
$allowmanage=  false; // �����Ȩ��
if($eventid){
	$query = $_SGLOBAL['db']->query("SELECT e.*, ef.* FROM ".tname("event")." e LEFT JOIN ".tname("eventfield")." ef ON e.eventid=ef.eventid WHERE e.eventid='$eventid'");
	$event = $_SGLOBAL['db']->fetch_array($query);
	if(! $event){
		showmessage("event_does_not_exist"); // ������ڻ����ѱ�ɾ��
	}
	if(($event['grade']==-1 || $event['grade'] == 0) && $event['uid'] != $_SGLOBAL['supe_uid'] && !checkperm('manageevent')){
		showmessage('event_under_verify');// ����������
	}
	$query = $_SGLOBAL['db']->query("SELECT * FROM " . tname("userevent") . " WHERE eventid='$eventid' AND uid='$_SGLOBAL[supe_uid]'");
	$value = $_SGLOBAL['db']->fetch_array($query);
	$_SGLOBAL['supe_userevent'] = $value ? $value : array();	
	if($value['status'] >= 3 || checkperm('manageevent')){
		$allowmanage = true; // �����Ȩ��
	}
}

// ��ȡ�������Ϣ
if(!@include_once(S_ROOT.'./data/data_eventclass.php')) {
	include_once(S_ROOT.'./source/function_cache.php');
	eventclass_cache();
}

// ����/�༭�
if(submitcheck('eventsubmit')) {
	
	//��֤��
	if(checkperm('seccode') && !ckseccode($_POST['seccode'])) {
		showmessage('incorrect_code');
	}
	
	// ����Ϣ
	$arr1 = array(
		"title" => getstr($_POST['title'], 80, 1, 1, 1),
		"subject" => getstr($_POST['title'], 80, 1, 1, 1),
		"password" => getstr($_POST['password'], 20, 1, 1),
		"classid" => intval($_POST['classid']),
		"province" => getstr($_POST['province'], 20, 1, 1),
		"city" => getstr($_POST['city'], 20, 1, 1),
		"location" => getstr($_POST['location'], 80, 1, 1, 1),
		"starttime" => sstrtotime($_POST['starttime']),
		"endtime" => sstrtotime($_POST['endtime']),
		"deadline" => sstrtotime($_POST['deadline']),
		"public" => intval($_POST['public'])
	);
	// ��չ��Ϣ
	$arr2 = array(
		"detail" => getstr($_POST['detail'], '', 1, 1, 1, 0, 1),
		"message" => getstr($_POST['detail'], '', 1, 1, 1, 0, 1),
		"message1" => getstr($_POST['detail'], '', 1, 1, 1, 0, 1),
		"limitnum" => intval($_POST['limitnum']),
		"verify" => intval($_POST['verify']),
		"allowpost" => intval($_POST['allowpost']),
		"allowpic" => intval($_POST['allowpic']),
		"allowfellow" => intval($_POST['allowfellow']),
		"allowinvite" => intval($_POST['allowinvite']),
		"template" => getstr($_POST['template'], 255, 1, 1, 1)
	);
	
	//�������
	if(empty($arr1['title'])){
		showmessage('event_title_empty');
	} elseif(empty($arr1['classid'])){
		showmessage('event_classid_empty');
	} elseif(empty($arr1['password'])){
		showmessage('event_password_empty');
	}elseif(empty($arr1['city'])) {
		showmessage('event_city_empty');
	} elseif(empty($arr2['detail'])) {
		showmessage('event_detail_empty');
	} elseif($arr1['endtime']-$arr1['starttime']>60 * 24 * 3600) {
		showmessage('event_bad_time_range');		
	} elseif($arr1['endtime']<$arr1['starttime']) {
		showmessage('event_bad_endtime');
	} elseif($arr1['deadline']>$arr1['endtime']) {
		showmessage('event_bad_deadline');
	} elseif(!$eventid && $arr1['starttime']<$_SGLOBAL['timestamp']) {
		showmessage('event_bad_starttime');
	}
	
	// ���?��
	$pic = array();
	if($_FILES['poster']['tmp_name']){
		// �浽Ĭ�����
		$pic = pic_save($_FILES['poster'], -1, $arr1['title']);
		if(is_array($pic) && $pic['filepath']){// �ϴ��ɹ�
			$arr1['poster'] = $pic['filepath'];
			$arr1['thumb'] = $pic['thumb'];
			$arr1['remote'] = $pic['remote'];
		}
	}
	
	//����Ⱥ��
	if($_POST['tagid'] && (!$eventid || $event['uid']==$_SGLOBAL['supe_uid']) && $_POST['tagid'] != $event['tagid']) {
		$_POST['tagid'] = intval($_POST['tagid']);
		$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname("tagspace")." WHERE tagid='$_POST[tagid]' AND uid='$_SGLOBAL[supe_uid]' LIMIT 1");
		if($value=$_SGLOBAL['db']->fetch_array($query)) {
			if($value['grade'] == 9) {
				$arr1['tagid'] = $value['tagid'];
			}
		}
	}

	if($eventid){// �޸����л
		if($allowmanage){
			//�����δͨ����˻�޸��ˣ�����Ϊ�����
			if($event['grade']==-1 && $event['uid'] == $_SGLOBAL['supe_uid']) {
				$arr1['grade'] = 0;
			}
			updatetable("event", $arr1, array("eventid"=>$eventid));
			updatetable("eventfield", $arr2, array("eventid"=>$eventid));
			// ���?��
			if($_POST['sharepic'] && !empty($pic['picid'])){
				$arr = array(
					"eventid"=>$eventid,
					"picid"=>$pic['picid'],
					"uid"=>$_SGLOBAL['supe_uid'],
					"username"=>$_SGLOBAL['supe_username'],
					"dateline"=>$_SGLOBAL['timestamp']
				);
				inserttable("eventpic", $arr);
			}
			showmessage('do_success', 'space.php?do=event&id='.$eventid, 0);			
		} else {
			showmessage('no_privilege_edit_event');
		}

	} else {// ����µĻ
	
		//ʵ����֤
		ckrealname('event');
		
		//��Ƶ��֤
		ckvideophoto('event');
		
		//���û���ϰ
		cknewuser();
	
		$_POST['topicid'] = topic_check($_POST['topicid'], 'event');
		$arr1['topicid'] = $_POST['topicid'];
		
		// ������
		$arr1['uid'] = $_SGLOBAL['supe_uid'];
		$arr1['username'] = $_SGLOBAL['supe_username'];
		// ����ʱ��
		$arr1['dateline'] = $_SGLOBAL['timestamp'];
		$arr1['updatetime'] = $_SGLOBAL['timestamp'];
		
		//����
		$arr1['membernum'] = 1;
		
		// �Ƿ���Ҫ���
		$arr1['grade'] = checkperm("verifyevent") ? 0 : 1;

		// ���� ���event�� ��
		$eventid = inserttable("event", $arr1, 1);
		if (! $eventid){
			showmessage("event_create_failed"); // �����ʧ�ܣ����������������
		}
		// ���Ϣ
		$arr2['eventid'] = $eventid;
		inserttable("eventfield", $arr2);
		// ���?��
		if($_POST['sharepic'] && !empty($pic['picid'])){
			$arr = array(
				"eventid"=>$eventid,
				"picid"=>$pic['picid'],
				"uid"=>$_SGLOBAL['supe_uid'],
				"username"=>$_SGLOBAL['supe_username'],
				"dateline"=>$_SGLOBAL['timestamp']
				);
			inserttable("eventpic", $arr);
		}
		$arr3 = array(
			"eventid" => $eventid,
			"uid" => $_SGLOBAL['supe_uid'],
			"username" => $_SGLOBAL['supe_username'],
			"status" => 4,  // ������
			"fellow" => 0,
			"template" => $arr1['template'],
			"dateline" => $_SGLOBAL['timestamp']
		   );
		// ���� �û����userevent�� ��
		inserttable("userevent", $arr3);
		if($arr1['grade'] > 0){
			//�¼�
			if($_POST['makefeed']) {
				include_once(S_ROOT.'./source/function_feed.php');
				feed_publish($eventid, 'eventid', 1);
			}
		}
		
		//ͳ��
		updatestat('event');
		
		//�����û�ͳ��
		if(empty($space['eventnum'])) {
			$space['eventnum'] = getcount('event', array('uid'=>$space['uid']));
			$eventnumsql = "eventnum=".$space['eventnum'];
		} else {
			$eventnumsql = 'eventnum=eventnum+1';
		}
		
		//���
		$reward = getreward('createevent', 0);
		$_SGLOBAL['db']->query("UPDATE ".tname('space')." SET {$eventnumsql}, lastpost='$_SGLOBAL[timestamp]', updatetime='$_SGLOBAL[timestamp]', credit=credit+$reward[credit], experience=experience+$reward[experience] WHERE uid='$_SGLOBAL[supe_uid]'");
			
		if($_POST['topicid']) {
			topic_join($_POST['topicid'], $_SGLOBAL['supe_uid'], $_SGLOBAL['supe_username']);
			$url = 'space.php?do=topic&topicid='.$_POST['topicid'].'&view=event';
		} else {
			$url = 'space.php?do=event&id='.$eventid;
		}
		
		showmessage('do_success', $url, 0); // �鿴�
	}
}

if($op == 'invite') {
	
	// �ǻ��Ա���߲��������������·���֯��û������Ȩ��
	if((!$event['allowinvite'] && $_SGLOBAL['supe_userevent']['status'] < 3) || ($_SGLOBAL['supe_userevent']['status'] < 2)){
		showmessage("no_privilege_do_eventinvite");
	}
	
	if(submitcheck('invitesubmit')){
		$arr = array("uid"=>$_SGLOBAL['supe_uid'], "username"=>$_SGLOBAL['supe_username'], "eventid"=>$eventid, "dateline"=>$_SGLOBAL['timestamp']);
		$inserts = array();
		$touids = array();
		for($i=0, $L=sizeof($_POST['ids']); $i<$L; $i++){
			$arr['touid'] = intval($_POST['ids'][$i]);
			$arr['tousername'] = getstr($_POST['names'][$i], 15, 1, 1);
			$inserts[] = "(".simplode($arr).")";
			$touids[] = $arr['touid'];
		}
		if($inserts) {
			$_SGLOBAL['db']->query("INSERT INTO ".tname("eventinvite")."(uid, username, eventid, dateline, touid, tousername) VALUES ".implode(",", $inserts));
			$_SGLOBAL['db']->query("UPDATE ".tname('space')." SET eventinvitenum=eventinvitenum+1 WHERE uid IN (".simplode($touids).")");
		}
		$_GET['group'] = isset($_GET['group']) ? intval($_GET['group']) : -1;
		$_GET['page'] = empty($_GET['page'])?0:intval($_GET['page']);
		showmessage("do_success", "cp.php?ac=event&op=invite&id=$eventid&group=$_GET[group]&page=$_GET[page]", 2);
	}

	//��ҳ
	$perpage = 21;
	$page = empty($_GET['page'])?0:intval($_GET['page']);
	if($page<1) $page = 1;
	$start = ($page-1)*$perpage;
	//��鿪ʼ��
	ckstart($start, $perpage);

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
	$list = array();
	if($count) {
		$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('friend')." WHERE uid='$_SGLOBAL[supe_uid]' AND status='1' $sql ORDER BY num DESC, dateline DESC LIMIT $start,$perpage");
		while ($value = $_SGLOBAL['db']->fetch_array($query)) {
			realname_set($value['fuid'], $value['fusername']);
			$list[] = $value;
			$fuids[] = $value['fuid'];
		}
	}

	//�Ƿ��Ѽ���
	$joins = array();
	$query = $_SGLOBAL['db']->query("SELECT uid FROM ".tname('userevent')." WHERE eventid='$eventid' AND uid IN (".simplode($fuids).") AND status > 1");
	while ($value = $_SGLOBAL['db']->fetch_array($query)) {
		$joins[$value['uid']] = $value['uid'];
	}

	//�Ƿ�����
	$query = $_SGLOBAL['db']->query("SELECT touid FROM ".tname('eventinvite')." WHERE eventid='$eventid' AND touid IN (".simplode($fuids).")");
	while ($value = $_SGLOBAL['db']->fetch_array($query)) {
		$joins[$value['touid']] = $value['touid'];
	}

	//�û���
	$groups = getfriendgroup();
	$groupselect = array($_GET['group'] => ' selected');

	$multi = multi($count, $perpage, $page, "cp.php?ac=event&op=invite&id=$eventid&group=$_GET[group]&key=$_GET[key]");

} elseif($op == 'members') {
	// ��Ա����

	if($_SGLOBAL['supe_userevent']['status'] < 3){
		showmessage('no_privilege_manage_event_members');//��û��Ȩ�޹�����Ա
	}

	if(submitcheck("memberssubmit")){
		
		$_POST['status'] = intval($_POST['status']);
		
		if($_POST['ids'] && verify_eventmembers($_POST['ids'], $_POST['status'])){
			showmessage("do_success", "cp.php?ac=event&op=members&id=$eventid&status=$_GET[status]", 2);
		} else {
			showmessage("choose_right_eventmember", "cp.php?ac=event&op=members&id=$eventid&status=$_GET[status]", 5);
		}
	}
	
	//��ҳ
	$perpage = 24;
	$start = empty($_GET['start'])?0:intval($_GET['start']);
	$list = array();
	$count = 0;

	//����
	$wheresql = '';	
	if($_GET['key']) {
		$_GET['key'] = stripsearchkey($_GET['key']);
		$wheresql = " AND username LIKE '%$_GET[key]%' ";
	} else {
		$_GET['status'] = intval($_GET['status']);
		$wheresql = " AND status='$_GET[status]'";		
	}

	//��鿪ʼ��
	ckstart($start, $perpage);
	
	$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('userevent')." WHERE eventid='$eventid' $wheresql LIMIT $start,$perpage");
	while ($value = $_SGLOBAL['db']->fetch_array($query)) {
		realname_set($value['uid'], $value['username']);
		$list[] = $value;
		$count++;
	}
	
	if($_GET['key']){
		$_GET['status'] = $list[0]['status'];
	}

	$multi = smulti($start, $perpage, $count, "cp.php?ac=event&op=members&id=$eventid&status=$_GET[status]&key=$_GET[key]");

} elseif($op == 'member'){
	// ���õ�����Ա

	if($_SGLOBAL['supe_userevent']['status'] < 3){
		showmessage('no_privilege_manage_event_members');//��û��Ȩ�޹�����Ա
	}

	if(submitcheck("membersubmit")){
		$_POST['status'] = intval($_POST['status']);
		if($_POST['uid'] && verify_eventmembers(array($_POST['uid']), $_POST['status'])){
			$refer = empty($_POST['refer']) ? "space.php?do=event&id=$eventid&view=member&status=$_POST[status]" : $_POST['refer'];
			showmessage("do_success", $refer , 0);	
		} else {
			showmessage("choose_right_eventmember");
		}
	}
	
	$_GET['uid'] = intval($_GET['uid']);
	$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname("userevent")." WHERE uid='$_GET[uid]' AND eventid='$eventid'");
	$userevent = $_SGLOBAL['db']->fetch_array($query);
	if(empty($userevent)){
		showmessage("choose_right_eventmember");
	}
	$userevent['template'] = nl2br(getstr($userevent['template'], 255, 1, 0, 1));

} elseif($op == 'comment') {// �����
	
	if(!$allowmanage){
		showmessage("no_privilege_manage_event_comment");
	}

	showmessage("redirect", "admincp.php?ac=comment&idtype=eventid&id=$eventid", 0);

} elseif($op == 'pic') {// ���Ƭ

	if(!$allowmanage){
		showmessage("no_privilege_manage_event_pic");
	}

	if(submitcheck("deletepicsubmit")){
		if(! empty($_POST['ids'])) {
			$query = $_SGLOBAL['db']->query("DELETE FROM " . tname("eventpic") . " WHERE eventid='$eventid' AND picid IN (".simplode($_POST['ids']).")");
			$_SGLOBAL['db']->query("UPDATE ".tname("event")." SET picnum = (SELECT COUNT(*) FROM ".tname("eventpic")." WHERE eventid='$eventid') WHERE eventid = '$eventid'");
			showmessage("do_success", "cp.php?ac=event&op=pic&id=$eventid", 0);
		} else {
			showmessage("choose_event_pic");
		}
	}

	//��ҳ
	$perpage = 16;
	$page = empty($_GET['page'])?1:intval($_GET['page']);
	if($page<1) $page=1;
	$start = ($page-1)*$perpage;

	//��鿪ʼ��
	ckstart($start, $perpage);

	//�����ѯ
	$theurl = "cp.php?ac=event&id=$eventid&op=pic";

	$photolist = array();
	$count = $_SGLOBAL['db']->result($_SGLOBAL['db']->query("SELECT COUNT(*) FROM ".tname("eventpic")." WHERE eventid = '$eventid'"), 0);
	if($count) {
		$query = $_SGLOBAL['db']->query("SELECT pic.* FROM ".tname("eventpic")." ep LEFT JOIN ".tname("pic")." pic ON ep.picid=pic.picid WHERE ep.eventid='$eventid' ORDER BY ep.picid DESC LIMIT $start, $perpage");
		while($value = $_SGLOBAL['db']->fetch_array($query)){
			$value['pic'] = pic_get($value['filepath'], $value['thumb'], $value['remote']);
			$photolist[] = $value;
		}
	}

	//��ҳ
	$multi = multi($count, $perpage, $page, $theurl);

} elseif($op == 'thread') {//�����
	
	if(!$allowmanage){
		showmessage("no_privilege_manage_event_thread");
	}
	if(!$event['tagid']) {
		showmessage('event_has_not_mtag');//�û�й���Ⱥ��
	}
	
	if(submitcheck('delthreadsubmit')) {
		if(!empty($_POST['ids'])) {
			$_SGLOBAL['db']->query("DELETE FROM ".tname("thread")." WHERE eventid='$eventid' AND tid IN (".simplode($_POST['ids']).")");
			$_SGLOBAL['db']->query("UPDATE ".tname("event")." SET threadnum = (SELECT COUNT(*) FROM ".tname("thread")." WHERE eventid='$eventid') WHERE eventid = '$eventid'");
			showmessage('do_success',"cp.php?ac=event&id=$eventid&op=thread",0);
		} else {
			showmessage('choose_event_thread');
		}
	}
	
	//��ҳ
	$perpage = 20;
	$page = empty($_GET['page'])?1:intval($_GET['page']);
	if($page<1) $page=1;
	$start = ($page-1)*$perpage;

	//��鿪ʼ��
	ckstart($start, $perpage);
	$threadlist = array();
	$count = $_SGLOBAL['db']->result($_SGLOBAL['db']->query("SELECT COUNT(*) FROM ".tname("thread")." WHERE eventid = '$eventid'"), 0);
	if($count) {
		$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname("thread")." WHERE eventid='$eventid' ORDER BY lastpost DESC LIMIT $start, $perpage");
		while($value = $_SGLOBAL['db']->fetch_array($query)){
			realname_set($value['uid'], $value['username']);
			realname_set($value['lastauthorid'], $value['lastauthor']);
			$threadlist[] = $value;
		}
	}

	//��ҳ
	$multi = multi($count, $perpage, $page, $theurl);	
	
} elseif($op == 'join') {// ����һ������޸ı�����Ϣ
	
	if(isblacklist($event['uid'])) {
		$_GET['popupmenu_box'] = true;//�����ر�
		showmessage('is_blacklist');//����
	}
	//�³�Ա���룬����������
	if(empty($_SGLOBAL['supe_userevent'])){
		$_GET['popupmenu_box'] = true;//�����ر�
		if($_SGLOBAL['timestamp'] > $event['endtime']){	
			showmessage('event_is_over');// ��Ѿ�����
		}
		
		if($_SGLOBAL['timestamp'] > $event['deadline']){
			showmessage("event_meet_deadline"); // ��Ѿ���ֹ����
		}
		
		if($event['limitnum']>0 && $event['membernum']>=$event['limitnum']){
			showmessage('event_already_full');//���������
		}
		
		// �ǹ��������Ҫ������ܼ���
		if($event['public'] < 2){
			$query = $_SGLOBAL['db']->query("SELECT * FROM " . tname("eventinvite") . " WHERE eventid = '$event[eventid]' AND touid = '$_SGLOBAL[supe_uid]' LIMIT 1");
			$value = $_SGLOBAL['db']->fetch_array($query);
			if(empty($value)){				
				showmessage("event_join_limit"); // �˻ֻ��ͨ��������ܼ���
			}
		}
	}

	if(submitcheck("joinsubmit")){
		// ���״̬�����޸ı�����Ϣ
		if(!empty($_SGLOBAL['supe_userevent']) && $_SGLOBAL['supe_userevent']['status'] == 0){
			$arr = array();

			if(isset($_POST['fellow'])){
				$arr['fellow'] = intval($_POST['fellow']);// �޸�Я������
			}
			if($_POST['template']){// ������Ϣ
				$arr['template'] = getstr($_POST['template'], 255, 1, 1, 1);
			}
			if($arr){
				updatetable("userevent", $arr, array("eventid"=>$eventid, "uid"=>$_SGLOBAL['supe_uid']));
			}
			showmessage("do_success", "space.php?do=event&id=$eventid", 2);
		}

		// �Ѿ��μӻ���ˣ��޸ı�����Ϣ
		if(!empty($_SGLOBAL['supe_userevent']) && $_SGLOBAL['supe_userevent']['status'] > 1){
			$arr = array();
			$num = 0; // ���������仯

			if(isset($_POST['fellow'])){// �޸�Я������
				$_POST['fellow'] = intval($_POST['fellow']);
				$arr['fellow'] = $_POST['fellow'];// �޸Ĳμ�����
				$num = $_POST['fellow'] - $_SGLOBAL['supe_userevent']['fellow'];
				// �������
				if ($event['limitnum'] > 0 && $num + $event['membernum'] > $event['limitnum']){
					showmessage("event_already_full");
				}
			}
			if($_POST['template']){// ������Ϣ
				$arr['template'] = $_POST['template'];
			}
			if($arr){
				updatetable("userevent", $arr, array("eventid"=>$eventid, "uid"=>$_SGLOBAL['supe_uid']));
			}
			if($num){
				$_SGLOBAL['db']->query("UPDATE " . tname("event") . " SET membernum = membernum + ($num) WHERE eventid=$eventid");
			}
			showmessage("do_success", "space.php?do=event&id=$eventid", 0);
		}
		
		// �û����Ϣ
		$arr = array(
			"eventid" => $eventid,
			"uid" => $_SGLOBAL['supe_uid'],
			"username" => $_SGLOBAL['supe_username'],
			"status" => 2,
			"template" => $event['template'],
			"fellow" => 0,
			"dateline" => $_SGLOBAL['timestamp']
		   );
		// �����仯
		$num = 1;
		$numsql = "";

		if($_POST['fellow']){
			$arr['fellow'] = intval($_POST['fellow']);
			$num += $arr['fellow'];
		}
		if($_POST['template']){// ������Ϣ
			$arr['template'] = getstr($_POST['template'], 255, 1, 1, 1);
		}
		
		if ($event['limitnum'] > 0 && $num + $event['membernum'] > $event['limitnum']){
			showmessage("event_will_full");
		}
		$numsql = " membernum = membernum + ($num) ";
		
		// ����Ƿ��л����
		$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname("eventinvite")." WHERE eventid='$eventid' AND touid='$_SGLOBAL[supe_uid]'");
		$eventinvite = $_SGLOBAL['db']->fetch_array($query);
		// ��Ҫ���
		if($event['verify'] && !$eventinvite){			
			$arr['status'] = 0; // �����
		}

		// ���� �û����userevent�� ��		
		if($_SGLOBAL['supe_userevent']['status'] == 1){
			// ��ע�߲μӣ���ע�����1
			updatetable("userevent", $arr, array("uid"=>$_SGLOBAL['supe_uid'], "eventid"=>$eventid));
			$numsql .= ",follownum = follownum - 1 ";
		} else {
			// ֱ�Ӳμ�
			inserttable("userevent", $arr, 0);
		}

		// �����μ�/��ע���޸�
		if($arr['status'] == 2){
			$_SGLOBAL['db']->query("UPDATE " . tname("event") . " SET $numsql WHERE eventid = '$eventid'");
			if(ckprivacy('join')){
				realname_set($event['uid'], $event['username']);
				realname_get();				
				feed_add('event', cplang('event_join'), array('title'=>$event['title'], "eventid"=>$event['eventid'], "uid"=>$event['uid'], "username"=>$_SN[$event['uid']]));
			}
		} elseif($arr['status'] == 0){
			if($_SGLOBAL['supe_userevent']['status'] == 1){
				//��ע�����1
				$_SGLOBAL['db']->query("UPDATE " . tname("event") . " SET follownum = follownum - 1 WHERE eventid = '$eventid'");
			}
			//����֯�߷������֪ͨ
			$note_inserts = array();
			$note_ids = array();
			$note_msg = cplang('event_join_verify', array("space.php?do=event&id=$event[eventid]", $event['title'], "cp.php?ac=event&id=$event[eventid]&op=members&status=0&key=$arr[username]"));
			$query = $_SGLOBAL['db']->query("SELECT ue.*, sf.* FROM ".tname("userevent")." ue LEFT JOIN ".tname("spacefield")." sf ON ue.uid=sf.uid WHERE ue.eventid='$eventid' AND ue.status >= 3");
			while($value=$_SGLOBAL['db']->fetch_array($query)){
				$value['privacy'] = empty($value['privacy']) ? array() : unserialize($value['privacy']);
				$filter = empty($value['privacy']['filter_note'])?array():array_keys($value['privacy']['filter_note']);
				if(cknote_uid(array("type"=>"eventmember","authorid"=>$_SGLOBAL['supe_uid']),$filter)){
					$note_ids[] = $value['uid'];
					$note_inserts[] = "('$value[uid]', 'eventmember', '1', '$_SGLOBAL[supe_uid]', '$_SGLOBAL[supe_username]', '".addslashes($note_msg)."', '$_SGLOBAL[timestamp]')";
				}
			}
			if($note_inserts){
				$_SGLOBAL['db']->query("INSERT INTO ".tname('notification')." (`uid`, `type`, `new`, `authorid`, `author`, `note`, `dateline`) VALUES ".implode(',', $note_inserts));
				$_SGLOBAL['db']->query("UPDATE ".tname('space')." SET notenum=notenum+1 WHERE uid IN (".simplode($note_ids).")");
			}
			
			//�ʼ�����
			smail($event['uid'], '', $note_msg, 'event');
		}
		
		//������
		getreward('joinevent', 1, 0, $eventid);
		
		//ͳ��
		updatestat('eventjoin');
		
		//��������
		if($eventinvite){
			$_SGLOBAL['db']->query("DELETE FROM ".tname("eventinvite")." WHERE eventid='$eventid' AND touid='$_SGLOBAL[supe_uid]'");
			$_SGLOBAL['db']->query("UPDATE ".tname('space')." SET eventinvitenum=eventinvitenum-1 WHERE uid = '$_SGLOBAL[supe_uid]' AND eventinvitenum>0");
		}
		
		showmessage("do_success", "space.php?do=event&id=$eventid", 0); // �����ɹ�
	}

} elseif($op == "quit") {
	// �˳�
	if(! $eventid){
		showmessage("event_does_not_exist"); // ������ڻ����ѱ�ɾ��
	}

	if(submitcheck("quitsubmit")){

		$tourl = "space.php?do=event&id=$eventid";
		$uid = $_SGLOBAL['supe_uid'];
		$userevent = $_SGLOBAL['supe_userevent'];

		// �Ѿ������ķǴ�����
		if(! empty($userevent) && $event['uid'] != $uid){
			$_SGLOBAL['db']->query("DELETE FROM " . tname("userevent") . " WHERE eventid='$eventid' AND uid='$uid'");
			if($userevent['status']>=2){
				// �޸Ļ����
				$num = 1 + $userevent['fellow'];
				$_SGLOBAL['db']->query("UPDATE " . tname("event") . " SET membernum = membernum - $num WHERE eventid='$eventid'");
			}
			showmessage("do_success", $tourl, 0);
		} else {
			showmessage("cannot_quit_event", $tourl, 2); // �㲻���˳����ԭ�����㻹û�м����������������ķ����ˡ�
		}
	}

} elseif($op == "follow") {
	// ��ע
	if(! $eventid){
		showmessage("event_does_not_exist"); // ������ڻ����ѱ�ɾ��
	}
	
	if(!empty($_SGLOBAL['supe_userevent'])){
		$_GET['popupmenu_box'] = true;//�����ر�
		if($_SGLOBAL['supe_userevent']['status']<=1) {
			showmessage("event_has_followed");//���Ѿ���ע�˴˻
		} else {
			showmessage("event_has_joint");//���Ѿ������˴˻
		}
	}
	
	//[to do:����Ѿ��μӻ���ˣ����ȼ�����]
	if(submitcheck("followsubmit")){

		$arr = array(
			"eventid" => $eventid,
			"uid" => $_SGLOBAL['supe_uid'],
			"username" => $_SGLOBAL['supe_username'],
			"status" => 1,
			"fellow" => 0,
			"template" => $event['template']
		   );
		inserttable("userevent", $arr);

		$_SGLOBAL['db']->query("UPDATE " . tname("event") . " SET follownum = follownum + 1 WHERE eventid='$eventid'");
		showmessage("do_success", "space.php?do=event&id=$eventid", 0);
	}

} elseif($op == "cancelfollow") {
	// ȡ���ע
	if(! $eventid){
		showmessage("event_does_not_exist"); // ������ڻ����ѱ�ɾ��
	}

	if(submitcheck("cancelfollowsubmit")){

		if($_SGLOBAL['supe_userevent']['status'] == 1){
			$_SGLOBAL['db']->query("DELETE FROM " . tname("userevent") . " WHERE uid='$_SGLOBAL[supe_uid]' AND eventid='$eventid'");
			$_SGLOBAL['db']->query("UPDATE " . tname("event") . " SET follownum = follownum - 1 WHERE eventid='$eventid'");
		}
		showmessage("do_success", "space.php?do=event&id=$eventid", 0);
	}

} elseif($op == 'eventinvite') {
	
	if($_GET['r']) {// �ܾ�
		$tourl = "cp.php?ac=event&op=eventinvite" . (isset($_GET['page']) ? "&page=" . intval($_GET['page']) : "");	
		if($eventid) {// �����˻id
			$_SGLOBAL['db']->query("DELETE FROM ". tname("eventinvite") . " WHERE eventid = '$eventid' AND touid = '$_SGLOBAL[supe_uid]'");
			$_SGLOBAL['db']->query("UPDATE ".tname('space')." SET eventinvitenum=eventinvitenum-1 WHERE uid = '$_SGLOBAL[supe_uid]' AND eventinvitenum>0");
		} else {// ����
			$_SGLOBAL['db']->query("DELETE FROM ". tname("eventinvite") . " WHERE touid = '$_SGLOBAL[supe_uid]'");
			$_SGLOBAL['db']->query("UPDATE ".tname('space')." SET eventinvitenum=0 WHERE uid = '$_SGLOBAL[supe_uid]'");
		}
	
		showmessage("do_success", $tourl, 0);
	}

	//��ҳ
	$perpage = 20;
	$page = empty($_GET['page'])?1:intval($_GET['page']);
	if($page<1) $page=1;
	$start = ($page-1)*$perpage;

	//��鿪ʼ��
	ckstart($start, $perpage);

	//�����ѯ
	$theurl = "cp.php?ac=event&op=eventinvite";
	$count = getcount("eventinvite", array("touid"=>$_SGLOBAL['supe_uid']));
	
	//����ͳ��
	if($count != $space['eventinvitenum']) {
		updatetable('space', array('eventinvitenum'=>$count), array('uid'=>$space['uid']));
	}
		
	$eventinvites = array();
	if($count > 0) {
		// δ��������
		$query = $_SGLOBAL['db']->query("SELECT ei.*, e.*, ei.dateline as invitetime FROM ".tname("eventinvite")." ei LEFT JOIN ".tname("event")." e ON ei.eventid=e.eventid WHERE ei.touid='$_SGLOBAL[supe_uid]' limit $start, $perpage");
		while($value = $_SGLOBAL['db']->fetch_array($query)){
			realname_set($value['uid'], $value['username']);
			if($value['poster']){
				$value['pic'] = pic_get($value['poster'], $value['thumb'], $value['remote']);
			} else {
				$value['pic'] = $_SGLOBAL['eventclass'][$value['classid']]['poster'];
			}
			$eventinvites[] = $value;
		}
	}

	//��ҳ
	$multi = multi($count, $perpage, $page, $theurl);

} elseif($op == 'acceptinvite') {
	//��������	
	if(! $eventid){
		showmessage("event_does_not_exist"); // ������ڻ����ѱ�ɾ��
	}
	
	$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname("eventinvite")." WHERE eventid='$eventid' AND touid='$_SGLOBAL[supe_uid]' LIMIT 1");
	$eventinvite = $_SGLOBAL['db']->fetch_array($query);
	
	if(!$eventinvite) {
		showmessage('eventinvite_does_not_exist');//��û�иû�Ļ����
	}
	
	$_SGLOBAL['db']->query("DELETE FROM ".tname("eventinvite")." WHERE eventid='$eventid' AND touid='$_SGLOBAL[supe_uid]'");
	$_SGLOBAL['db']->query("UPDATE ".tname('space')." SET eventinvitenum=eventinvitenum-1 WHERE uid = '$_SGLOBAL[supe_uid]' AND eventinvitenum>0");
		
	if(isblacklist($event['uid'])) {
		showmessage('is_blacklist');//����
	}	
	if($_SGLOBAL['timestamp'] > $event['endtime']){	
		showmessage('event_is_over');// ��Ѿ�����
	}
	if($_SGLOBAL['timestamp'] > $event['deadline']){
		showmessage("event_meet_deadline"); // ��Ѿ���ֹ����
	}	
	if($event['limitnum']>0 && $event['membernum']>=$event['limitnum']){
		showmessage('event_already_full');//���������
	}
	
	$numsql = "membernum = membernum + 1";	
	if(empty($_SGLOBAL['supe_userevent'])){		
		$arr = array(
			"eventid" => $eventid,
			"uid" => $_SGLOBAL['supe_uid'],
			"username" => $_SGLOBAL['supe_username'],
			"status" => 2,
			"template" => $event['template'],
			"fellow" => 0,
			"dateline" => $_SGLOBAL['timestamp']
		   );
		inserttable("userevent", $arr, 0);
		$_SGLOBAL['db']->query("UPDATE " . tname("event") . " SET $numsql WHERE eventid = '$eventid'");
		if(ckprivacy('join')){
			realname_set($event['uid'], $event['username']);
			realname_get();
			feed_add('event', cplang('event_join'), array('title'=>$event['title'], "eventid"=>$event['eventid'], "uid"=>$event['uid'], "username"=>$_SN[$event['uid']]));
		}
	} elseif($_SGLOBAL['supe_userevent'] && $_SGLOBAL['supe_userevent'] < 2) {
		$arr = array("status"=>2);
		if($_SGLOBAL['supe_userevent']['status'] == 1) {
			$numsql .= ",follownum = follownum - 1 ";
		}
		if($event['limitnum'] > 0 && $event['membernum'] + $_SGLOBAL['supe_userevent']['fellow'] > $event['limitnum']) {
			$arr['fellow'] = 0;
		}
		updatetable("userevent", $arr, array("uid"=>$_SGLOBAL['supe_uid'], "eventid"=>$eventid));
		$_SGLOBAL['db']->query("UPDATE " . tname("event") . " SET $numsql WHERE eventid = '$eventid'");
		if(ckprivacy('join')){
			feed_add('event', cplang('event_join'), array('title'=>$event['title'], "eventid"=>$event['eventid'], "uid"=>$event['uid'], "username"=>$event['username']));
		}
	}
	
	showmessage(cplang('event_accept_success', array("space.php?do=event&id=$event[eventid]")));

} elseif('delete'==$op) {
	// ɾ��/ȡ�� �

	if(! $eventid){
		showmessage("event_does_not_exist"); // ������ڻ����ѱ�ɾ��
	}
	
	if(!$allowmanage){
		showmessage('no_privilege');
	}
	
	if(submitcheck("deletesubmit")){
		include_once(S_ROOT.'./source/function_delete.php');
		deleteevents(array($eventid));
		showmessage("do_success", "space.php?do=event", 2);
	}	

} elseif("print"==$op) {
	// ��ӡǩ����

	if(! $eventid){
		showmessage("event_does_not_exist"); // ������ڻ����ѱ�ɾ��
	}

	if(submitcheck("printsubmit")){

		$members=array();
		$uids=array();
		if($_POST['admin']){
			$query = $_SGLOBAL['db']->query("SELECT * FROM " . tname("userevent") . " WHERE eventid='$eventid' AND status > 1 ORDER BY status DESC, dateline ASC");
		} else {
			$query = $_SGLOBAL['db']->query("SELECT * FROM " . tname("userevent") . " WHERE eventid='$eventid' AND status = 2 ORDER BY dateline ASC");
		}
		while($value=$_SGLOBAL['db']->fetch_array($query)){
			$members[] = $value;
			realname_set($value['uid'], $value['username']);
		}
		realname_get();

		include template('cp_event_sheet');
		exit();
	}
	
} elseif($op == 'close') {//�رջ
	
	if(!$eventid) {
		showmessage("event_does_not_exist"); // ������ڻ����ѱ�ɾ��
	}
	
	if(!$allowmanage){
		showmessage('no_privilege');
	}
	
	if($event['grade'] < 1 || $event['endtime'] > $_SGLOBAL['timestamp']) {
		showmessage('event_can_not_be_closed');
	}
	
	if(submitcheck('closesubmit')){
		updatetable('event', array('grade'=>-2), array('eventid'=>$eventid));
		showmessage('do_success', 'space.php?do=event&id='.$eventid, 0);		
	}

} elseif($op == 'open') {//�����رյĻ

	if(!$eventid) {
		showmessage("event_does_not_exist"); // ������ڻ����ѱ�ɾ��
	}
	
	if(!$allowmanage){
		showmessage('no_privilege');
	}
	
	if($event['grade'] != -2 || $event['endtime'] > $_SGLOBAL['timestamp']) {
		showmessage('event_can_not_be_opened');
	}
	
	if(submitcheck('opensubmit')){
		updatetable('event', array('grade'=>1), array('eventid'=>$eventid));
		showmessage('do_success', 'space.php?do=event&id='.$eventid, 0);		
	}
	
} elseif($op == 'calendar') {//��б�����
	$match = array();
	if(!$_GET['month'] && preg_match("/^(\d{4}-\d{1,2})/", $_GET['date'], $match)) {
		$_GET['month'] = $match[1];
	}
	if(preg_match("/^(\d{4})-(\d{1,2})$/", $_GET['month'], $match)){
		$year = intval($match[1]);
		$month = intval($match[2]);
	} else {
		$year = intval(sgmdate("Y"));
		$month = intval(sgmdate("m"));
	}
	if($month==12) {
		$nextmonth = ($year + 1)."-"."1";
		$premonth = $year."-11";
	} elseif ($month==1) {
		$nextmonth = $year."-2";
		$premonth = ($year-1)."-12";
	} else {
		$nextmonth = $year."-".($month+1);
		$premonth = $year."-".($month-1);
	}
	
	$daystart = mktime(0,0,0,$month,1,$year);	
	$week = sgmdate("w",$daystart);//���µ�һ�����ܼ�: 0-6	
	$dayscount = sgmdate("t",$daystart);//��������
	$dayend = mktime(0,0,0,$month,$dayscount,$year) + 86400;
	$days = array();
	for($i=1; $i<=$dayscount; $i++) {
		$days[$i] = array("count"=>0, "events"=>array(), "class"=>'');
	}
	
	//���»
	$events = array();
	$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname("event")." WHERE starttime < $dayend AND endtime > $daystart ORDER BY eventid DESC LIMIT 100");//���ֻȡ100
	while($value=$_SGLOBAL['db']->fetch_array($query)) {
		if($value['public']<1 || $value['grade'] == 0 || $value['grade'] == -1){
			continue;
		}
		$start = $value['starttime'] < $daystart ? 1 : intval(date("j", $value['starttime']));
		$end = $value['endtime'] > $dayend ? $dayscount : intval(date("j", $value['endtime']));
		for($i=$start; $i<=$end; $i++) {
			if($days[$i]['count'] < 10) {//���ֻ��ʾ10���/ÿ��
				$days[$i]['events'][] = $value;
				$days[$i]['count'] += 1;
				$days[$i]['class'] = " on_link";
			}
		}
	}
	unset($events);
	
	if($month == intval(sgmdate("m")) && $year == intval(sgmdate("Y"))) {
		$d = intval(sgmdate("j"));
		$days[$d]['class'] = "on_today";
	}
	
	if($_GET['date']) {
		$t = sstrtotime($_GET['date']);
		if($month == intval(sgmdate("m",$t)) && $year == intval(sgmdate("Y",$t))) {
			$d = intval(sgmdate("j",$t));
			$days[$d]['class'] = "on_select";
		}
	}
	
	//����
	$url = $_GET['url'] ? preg_replace("/date=[\d\-]+/", '', $_GET['url']) : "space.php?do=event";
	
} elseif($_GET['op'] == 'edithot') {
	//Ȩ��
	if(!checkperm('manageevent')) {
		showmessage('no_privilege');
	}
	
	if(submitcheck('hotsubmit')) {
		$_POST['hot'] = intval($_POST['hot']);
		updatetable('event', array('hot'=>$_POST['hot']), array('eventid'=>$eventid));
		
		if($_POST['hot']>0) {
			include_once(S_ROOT.'./source/function_feed.php');
			feed_publish($eventid, 'eventid');
		} else {
			updatetable('feed', array('hot'=>$_POST['hot']), array('id'=>$eventid, 'idtype'=>'eventid'));
		}
		showmessage('do_success', "space.php?uid=$event[uid]&do=event&id=$eventid", 0);
	}
	
} elseif($op == 'edit'){// �������༭һ���»
	
	if($eventid) {
		// ���Ȩ��			
		if(!$allowmanage){
			showmessage("no_privilege_edit_event");
		}
	} else {
		//����û������鷢�Ȩ��
		if(! checkperm("allowevent")){
		   showmessage('no_privilege_add_event');
		}
		
		//ʵ����֤
		ckrealname('event');
		
		//��Ƶ��֤
		ckvideophoto('event');
		
		//���û���ϰ
		cknewuser();
		
		// �»Ĭ���� [to do: վ���������ûĬ������ȼ�����]
		$event = array();
		$event['eventid'] = '';
		$event['starttime'] = ceil($_SGLOBAL['timestamp'] / 3600) * 3600 + 7200; // ���ʼʱ�䣺��Сʱ��
		$event['endtime'] = $event['starttime'] + 14400; // �����ʱ�䣺��ʼʱ�����Сʱ
		$event['deadline'] = $event['starttime']; // �����ֹ����ʼʱ��
		$event['allowinvite'] = 1; // �Ƿ������������
		$event['allowpost'] = 1; // �Ƿ����?������
		$event['allowpic'] = 1; // �Ƿ����?����Ƭ
		$event['allowfellow'] = 0; // �Ƿ�����Я������
		$event['verify'] = 0;  // �Ƿ���Ҫ���
		$event['public'] = 2;  // �Ƿ񹫿������ȫ����
		$event['limitnum'] = 0;  // ���Ʋμ���������
		$event['province'] = $space['resideprovince'];  // ����У����������ڳ���
		$event['city'] = $space['residecity'];
		
		//�����ȵ�
		$topic = array();
		$topicid = $_GET['topicid'] = intval($_GET['topicid']);
		if($topicid) {
			$topic = topic_get($topicid);
		}
		if($topic) {
			$actives = array('event' => ' class="active"');
		}
	}
	
	//����Ⱥ��
	$mtags = array();
	if(!$eventid || $event['uid']==$_SGLOBAL['supe_uid']) {
		$query = $_SGLOBAL['db']->query("SELECT mtag.* FROM ".tname("tagspace")." st LEFT JOIN ".tname("mtag")." mtag ON st.tagid=mtag.tagid WHERE st.uid='$_SGLOBAL[supe_uid]' AND st.grade=9");
		while($value=$_SGLOBAL['db']->fetch_array($query)) {
			$mtags[] = $value;
		}
	}
	
	if($_GET['tagid'] && !$event['tagid']) {
		$event['tagid'] = intval($_GET['tagid']);		
	}
	
}

realname_get();
$actived = array(
	'members'=>'class = "link_back_bread grid_3"',
	'edit'=>'class = "link_back_bread grid_3"'
);
$actived[$op] = 'class = "bread_actived grid_1"';

include template("cp_event");


// ��˻��Ա�����á�ȡ����֯��
// [to do: �ɼ�������ܣ�ֻ���statusΪ-2���ڽ���ʱ��鼴�ɡ����ȼ�����]
function verify_eventmembers($uids, $status){
	global $_SGLOBAL, $event;	

	if($_SGLOBAL['supe_userevent']['status'] < 3){
		showmessage('no_privilege_manage_event_members');
	}
	$eventid = $_SGLOBAL['supe_userevent']['eventid'];
	if($eventid != $event['eventid']){
		$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname("event")." WHERE eventid='$eventid'");
		$event = $_SGLOBAL['db']->fetch_array($query);
	}
	
	$status = intval($status);
	if($status < -1 || $status > 3){
		showmessage("bad_userevent_status"); // ��ѡ����ȷ�Ļ��Ա״̬
	}
	if($event['verify'] == 0 && $status == 0){
		showmessage("event_not_set_verify");
	}
	if($status == 3 && $_SGLOBAL['supe_uid'] != $event['uid']){
		showmessage("only_creator_can_set_admin"); // ֻ�д����߿��������Ա
	}
	
	$newids = $actions = $userevents = array();
	$num = 0; // �����仯
	$query = $_SGLOBAL['db']->query("SELECT ue.*, sf.* FROM " . tname("userevent") . " ue LEFT JOIN ".tname("spacefield")." sf ON ue.uid=sf.uid WHERE ue.uid IN (".simplode($uids).") AND ue.eventid='$eventid'");
	while($value = $_SGLOBAL['db']->fetch_array($query)){
		if($value['status'] == $status || $event['uid'] == $value['uid'] || $value['status'] == 1){
			// ��ͬ status �ߣ������ߣ���ע�� ������
			continue;
		}
		if($status == 2) {//��Ϊ��ͨ��Ա
			$newids[] = $value['uid'];
			$userevents[$value['uid']] = $value;
			if($value['status'] == 0){// ����
				$actions[$value['uid']] = "set_verify";
				$num += ($value['fellow'] + 1);
			} elseif ($value['status'] == 3) { // ȡ����֯�����
				$actions[$value['uid']] = "unset_admin";
			}
		} elseif($status == 3) {//��Ϊ��֯��
			$newids[] = $value['uid'];
			$userevents[$value['uid']] = $value;
			$actions[$value['uid']] = "set_admin";
			if($value['status'] == 0){
				$num += ($value['fellow'] + 1);
			}
		} elseif($status == 0) {//��Ϊ�����
			$newids[] = $value['uid'];
			$userevents[$value['uid']] = $value;
			$actions[$value['uid']] = "unset_verify";
			if($value['status'] >= 2){
				$num -= ($value['fellow'] + 1);
			}
		} elseif($status == -1) {//ɾ���Ա
			$newids[] = $value['uid'];
			$userevents[$value['uid']] = $value;
			$actions[$value['uid']] = "set_delete";
			if($value['status'] >= 2){
				$num -= ($value['fellow'] + 1);
			}
		}
	}
	
	if(empty($newids)) return array();
	if($event['limitnum'] > 0 && $event['membernum'] + $num > $event['limitnum']){
		// �������
		showmessage("event_will_full");
	}
	
	$note_inserts = $note_ids = $feed_inserts = array();
	$feedarr = array(
		'appid' => UC_APPID,
		'icon' => 'event',
		'uid' => '',
		'username' => '',
		'dateline' => $_SGLOBAL['timestamp'],
		'title_template' => cplang('event_join'), 
		'title_data' => array('title'=>$event['title'], "eventid"=>$event['eventid'], "uid"=>$event['uid'], "username"=>$event['username']),
		'body_template' => '',
		'body_data' => array(),
		'body_general' => '',
		'image_1' => '',
		'image_1_link' => '',
		'image_2' => '',
		'image_2_link' => '',
		'image_3' => '',
		'image_3_link' => '',
		'image_4' => '',
		'image_4_link' => '',
		'target_ids' => '',
		'friend' => ''
	);
	$feedarr = sstripslashes($feedarr);//ȥ��ת��
	$feedarr['title_data'] = serialize(sstripslashes($feedarr['title_data']));//����ת��
	$feedarr['body_data'] = serialize(sstripslashes($feedarr['body_data']));//����ת��
	$feedarr['hash_template'] = md5($feedarr['title_template']."\t".$feedarr['body_template']);//ϲ��hash
	$feedarr['hash_data'] = md5($feedarr['title_template']."\t".$feedarr['title_data']."\t".$feedarr['body_template']."\t".$feedarr['body_data']);//�ϲ�hash
	$feedarr = saddslashes($feedarr);//����ת��

	foreach ($newids as $id){
		if($status > 1 && $userevents[$id]['status'] ==0){
			// ͨ����˲μ��˻�������μӻfeed
			$feedarr['uid'] = $userevents[$id]['uid'];
			$feedarr['username'] = $userevents[$id]['username'];
			$feed_inserts[] = "('$feedarr[appid]', 'event', '$feedarr[uid]', '$feedarr[username]', '$feedarr[dateline]', '0', '$feedarr[hash_template]', '$feedarr[hash_data]', '$feedarr[title_template]', '$feedarr[title_data]', '$feedarr[body_template]', '$feedarr[body_data]', '$feedarr[body_general]', '$feedarr[image_1]', '$feedarr[image_1_link]', '$feedarr[image_2]', '$feedarr[image_2_link]', '$feedarr[image_3]', '$feedarr[image_3_link]', '$feedarr[image_4]', '$feedarr[image_4_link]')";
		}
		$userevents[$id]['privacy'] = empty($userevents[$id]['privacy']) ? array() : unserialize($userevents[$id]['privacy']);
		$filter = empty($userevents[$id]['privacy']['filter_note'])?array():array_keys($userevents[$id]['privacy']['filter_note']);
		if(cknote_uid(array("type"=>"eventmemberstatus","authorid"=>$_SGLOBAL['supe_uid']),$filter)){
			$note_ids[] = $id;
			$note_msg = cplang('eventmember_'.$actions[$id], array("space.php?do=event&id=".$event['eventid'], $event['title']));
			$note_inserts[] = "('$id', 'eventmemberstatus', '1', '$_SGLOBAL[supe_uid]', '$_SGLOBAL[supe_username]', '".addslashes($note_msg)."', '$_SGLOBAL[timestamp]')";
		}
	}
	
	if($note_ids) {
		$_SGLOBAL['db']->query("INSERT INTO ".tname('notification')." (`uid`, `type`, `new`, `authorid`, `author`, `note`, `dateline`) VALUES ".implode(',', $note_inserts));
		$_SGLOBAL['db']->query("UPDATE ".tname('space')." SET notenum=notenum+1 WHERE uid IN (".simplode($note_ids).")");
	}
	if($feed_inserts){
		$_SGLOBAL['db']->query("INSERT INTO ".tname('feed')." (`appid` ,`icon` ,`uid` ,`username` ,`dateline` ,`friend` ,`hash_template` ,`hash_data` ,`title_template` ,`title_data` ,`body_template` ,`body_data` ,`body_general` ,`image_1` ,`image_1_link` ,`image_2` ,`image_2_link` ,`image_3` ,`image_3_link` ,`image_4` ,`image_4_link`) VALUES ".implode(',', $feed_inserts));
	}

	if($status == -1){// ɾ��		
		$_SGLOBAL['db']->query("DELETE FROM ".tname("userevent")." WHERE uid IN (".simplode($newids).") AND eventid='$eventid'");
	} else {// ����״̬		
		$_SGLOBAL['db']->query("UPDATE ".tname("userevent")." SET status='$status' WHERE uid IN (".simplode($newids).") AND eventid='$eventid'");
	}
	// �޸Ļ����
	if($num != 0){
		$_SGLOBAL['db']->query("UPDATE ".tname("event")." SET membernum = membernum + ($num) WHERE eventid='$eventid'");
	}
	return $newids;
}


?>
