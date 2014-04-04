<?php
/*
	[UCenter Home] (C) 2007-2008 Comsenz Inc.
	$Id: space_feed.php 10661 2008-12-12 02:39:36Z zhengqingpeng $
*/

if(!defined('IN_UCHOME')) {
	exit('Access Denied');
}

$eventid = isset($_REQUEST['id']) ? intval($_REQUEST['id']) : 0;
$view = isset($_REQUEST['view']) ? $_REQUEST['view'] : "all";

// �����
if(!@include_once(S_ROOT.'./data/data_eventclass.php')) {
	include_once(S_ROOT.'./source/function_cache.php');
	eventclass_cache();
}

if($eventid){// ��ʾ�����
	$page = empty($_REQUEST['page'])?1:intval($_REQUEST['page']);
	if($page<1) $page=1;
	$perpage = $_REQUEST['perpage'];

	
	$start = ($page-1)*$perpage;

	//¼ì²é¿ªÊ¼Êý

	if($view=="me"){//�ų���space.php�Զ���ӵ�$_REQUEST[view]=me
		$view = "all";
	}

	// ���Ϣ
	
	$query = $_SGLOBAL['db']->query("SELECT e.*, ef.* FROM ".tname("event")." e LEFT JOIN ".tname("eventfield")." ef ON e.eventid=ef.eventid WHERE e.eventid='$eventid'");
	$event = $_SGLOBAL['db']->fetch_array($query);
	$count1 = $_SGLOBAL['db']->result($_SGLOBAL['db']->query("SELECT COUNT(*) FROM ".tname('eventgo')."  WHERE uid='$_REQUEST[uid]' and eid='$_REQUEST[id]'"),0);
	$query1 = $_SGLOBAL['db']->query("SELECT * FROM ".tname('eventgo')."
		WHERE eid='$_REQUEST[id]' order by dateline DESC");
	while ($value1 = $_SGLOBAL['db']->fetch_array($query1)) {
		$query2 = $_SGLOBAL['db']->query("SELECT bf.message,bf.message1, b.* FROM ".tname('event')." b 
				LEFT JOIN ".tname('eventfield')." bf ON bf.eventid=b.eventid
				WHERE b.eventid='$value1[eid]'");
		$value2 = $_SGLOBAL['db']->fetch_array($query2);
		
		$value1['more']=$value2;

		realname_set($value1['uid'], $value1['username']);
		$eventgo[] = $value1;
	}
	capi_showmessage_by_data("rest_success", 0, array('event'=>$event,'eventgo'=>$eventgo,'count1'=>$count1, 'count'=>count($event)));
	
	$event["message1"] = htmlspecialchars($event["message1"]);
	include_once(S_ROOT.'./source/function_event.php');
	$event['message1'] = event_bbcode($event['message1']);
	
	if(! $event){
		capi_showmessage_by_data("event_does_not_exist"); // ������ڻ����ѱ�ɾ��
	}
	if($event['grade'] == 0 && $event['uid'] != $_SGLOBAL['supe_uid'] && !checkperm('manageevent')){
		capi_showmessage_by_data('event_under_verify');// ����������
	}
	realname_set($event['uid'], $event['username']);
	$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname("userevent")." WHERE eventid='$eventid' AND uid='$_SGLOBAL[supe_uid]'");
	$value = $_SGLOBAL['db']->fetch_array($query);
	if($value){
		$_SGLOBAL['supe_userevent'] = $value;
	} else {
		$_SGLOBAL['supe_userevent'] = array();
	}
	$allowmanage = false; // �����Ȩ��
	if($value['status'] >= 3 || checkperm('manageevent')){
		$allowmanage = true;
	}

	// ˽�ܻ�����Ѳμӻ���˺��й���Ȩ�޵��˻���������˿ɼ�
	
	#判断是否公开
	if($event['public'] == 0 && $_SGLOBAL['supe_userevent']['status'] < 2 && !$allowmanage){
		$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname("eventinvite")." WHERE eventid = '$eventid' AND touid = '$_SGLOBAL[supe_uid]' LIMIT 1");
		$value = $_SGLOBAL['db']->fetch_array($query);
		if(empty($value)){
			capi_capi_showmessage_by_data_by_data("event_not_public"); // ����һ��˽�ܻ����Ҫͨ��������ܲ鿴
		}
	}

	if($view == "thread" && !$event['tagid']) {
		$view = "all";
	}
	// ���鿴���ݲ�ͬ����ȡ��ͬ���
	if($view == "member"){
		// �鿴��Ա
		$status = isset($_REQUEST['status']) ? intval($_REQUEST['status']) : 2;
		$submenus = array();
		if($status>1){
			$submenus['member']='class="active"';
		}elseif($status>0){
			$submenus['follow']=' class="active"';
		}elseif($status==0){
			$submenus['verify']=' class="active"';
		}

		$statussql = "";
		$orderby = " ORDER BY ue.dateline ASC";
		if($status >= 2){
			$statussql = " AND ue.status >= 2";// ����֯��
			$orderby = " ORDER BY ue.status DESC";
		} else {
			$statussql = " AND ue.status = '$status'";
		}

		$filter = "";
		if($_REQUEST['key']){
			$_REQUEST['key'] = stripsearchkey($_REQUEST['key']);
			$filter = " AND ue.username LIKE '%$_REQUEST[key]%'";
		}

		$perpage = 10;
		$page = empty($_REQUEST['page'])?1:intval($_REQUEST['page']);
		if($page<1) $page=1;
		$start = ($page-1)*$perpage;

		//��鿪ʼ��
		ckstart($start, $perpage);
		$count = $_SGLOBAL['db']->result($_SGLOBAL['db']->query("SELECT count(*) FROM ".tname("userevent")." ue WHERE ue.eventid = '$eventid' $statussql $filter"),0);
		$members = $fuids = array();
		if($count){
			$query = $_SGLOBAL['db']->query("SELECT ue.*, sf.* FROM ".tname("userevent")." ue LEFT JOIN ".tname("spacefield")." sf ON ue.uid = sf.uid WHERE ue.eventid = '$eventid' $statussql $filter $orderby LIMIT $start, $perpage");
			while($value = $_SGLOBAL['db']->fetch_array($query)){
				realname_set($value['uid'], $value['username']);
				$members[] = $value;
				$fuids[] = $value['uid'];
			}
		}

		//����״̬
		$ols = array();
		if($fuids) {
			$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('session')." WHERE uid IN (".simplode($fuids).")");
			while ($value = $_SGLOBAL['db']->fetch_array($query)) {
				if(!$value['magichidden']) {
					$ols[$value['uid']] = $value['lastactivity'];
				}
			}
		}

		// ���������
		$verifynum = 0;
		if($_SGLOBAL['supe_userevent']['status'] >= 3){
			if($status == 0){
				$verifynum = count($members);
			} else {
				$verifynum = $_SGLOBAL['db']->result($_SGLOBAL['db']->query("SELECT count(*) FROM ".tname("userevent")." WHERE eventid = '$eventid' AND status=0"), 0);
			}
		}

		$multi = multi($count, $perpage, $page, "space.php?do=event&id=$eventid&view=member&status=$status");

	} elseif($view == "pic") {

		$picid = isset($_REQUEST['picid']) ? intval($_REQUEST['picid']) : 0;

		// ��Ƭ����
		$piccount = $_SGLOBAL['db']->result($_SGLOBAL['db']->query("SELECT COUNT(*) FROM ".tname("eventpic")." WHERE eventid = '$eventid'"), 0);

		if ($picid) {

			$_REQUEST['id'] = 0;

			//����ͼƬ
			$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('pic')." WHERE picid='$picid' LIMIT 1");
			$pic = $_SGLOBAL['db']->fetch_array($query);
			realname_set($pic['uid'], $pic['username']);			
			
			include_once(S_ROOT.'./source/space_album.php');

		} else {
			// �鿴���Ƭ�б�
			$photolist = array();

			//��ҳ

			$page = empty($_REQUEST['page'])?1:intval($_REQUEST['page']);
			if($page<1) $page=1;
			$start = ($page-1)*$perpage;

			//��鿪ʼ��
			ckstart($start, $perpage);

			//�����ѯ
			$theurl = "space.php?do=event&id=$eventid&view=pic";

			$badpicids = array();
			$query = $_SGLOBAL['db']->query("SELECT pic.*, ep.* FROM ".tname("eventpic")." ep LEFT JOIN ".tname("pic")." pic ON ep.picid=pic.picid WHERE ep.eventid='$eventid' ORDER BY ep.picid DESC LIMIT $start, $perpage");
			while($value = $_SGLOBAL['db']->fetch_array($query)){
				if(!$value['filepath']){//��Ƭ�Ѿ���ɾ��
					$badpicids[] = $value['picid'];
					continue;
				}
				realname_set($value['uid'], $value['username']);
				$value['pic'] = pic_get($value['filepath'], $value['thumb'], $value['remote']);
				$photolist[] = $value;
			}

			if($badpicids) {
				$piccount = $piccount - count($badpicids);
				$_SGLOBAL['db']->query("DELETE FROM ".tname("eventpic")." WHERE eventid='$eventid' AND picid IN (".simplode($badpicids).")");
			}

			if($piccount != $event['picnum']) {//������Ŀ
				updatetable("event", array("picnum"=>$piccount),array("eventid"=>$eventid));
			}

			//��ҳ
			$multi = multi($piccount, $perpage, $page, $theurl);
		}

	} elseif($view == "thread") {
		//�����
		//��ҳ
		$perpage = 20;
		$page = empty($_REQUEST['page'])?1:intval($_REQUEST['page']);
		if($page<1) $page=1;
		$start = ($page-1)*$perpage;

		//��鿪ʼ��
		ckstart($start, $perpage);
		//�����ѯ
		$theurl = "space.php?do=event&id=$eventid&view=thread";

		$threadlist = array();
		$count = $_SGLOBAL['db']->result($_SGLOBAL['db']->query("SELECT COUNT(*) FROM ".tname('thread')." WHERE eventid='$eventid'"),0);
		if($count) {
			$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('thread')." WHERE eventid='$eventid' ORDER BY lastpost DESC LIMIT $start,$perpage");
			while ($value = $_SGLOBAL['db']->fetch_array($query)) {
				realname_set($value['uid'], $value['username']);
				$threadlist[] = $value;
			}
		}

		if($count != $event['threadnum']) {
			updatetable("event", array("threadnum"=>$count), array("eventid"=>$eventid));
		}

		//��ҳ
		$multi = multi($count, $perpage, $page, $theurl);

	} elseif($view == "comment") {
		//�����
		//��ҳ
		$perpage = 20;
		$page = empty($_REQUEST['page'])?1:intval($_REQUEST['page']);
		if($page<1) $page=1;
		$start = ($page-1)*$perpage;

		//��鿪ʼ��
		ckstart($start, $perpage);

		//�����ѯ
		$theurl = "space.php?do=event&id=$eventid&view=comment";
		$cid = empty($_REQUEST['cid'])?0:intval($_REQUEST['cid']);
		$csql = $cid?"cid='$cid' AND":'';

		$comments = array();
		$count = $_SGLOBAL['db']->result($_SGLOBAL['db']->query("SELECT COUNT(*) FROM ".tname('comment')." WHERE $csql id='$eventid' AND idtype='eventid'"),0);
		if($count) {
			$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('comment')." WHERE $csql id='$eventid' AND idtype='eventid' ORDER BY dateline DESC LIMIT $start,$perpage");
			while ($value = $_SGLOBAL['db']->fetch_array($query)) {
				realname_set($value['authorid'], $value['author']);
				$comments[] = $value;
			}
		}

		//��ҳ
		$multi = multi($count, $perpage, $page, $theurl, '', 'comment_ul');

	} else {
		// �鿴��ۺ�
		// ��������
		include_once(S_ROOT.'./source/function_blog.php');
		$event['detail'] = blog_bbcode($event['detail']);

		// ����
		if($event['poster']){
			$event['pic'] = pic_get($event['poster'], $event['thumb'], $event['remote'], 0);
		} else {
			$event['pic'] = $_SGLOBAL['eventclass'][$event['classid']]['poster'];
		}

		// ���֯��
		$relateduids = array();//���ҲμӴ˻�ĳ�ԱҲ�μӵĻ��
		$admins = array();
		$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname("userevent")." WHERE eventid = '$eventid' AND status IN ('3', '4') ORDER BY status DESC");
		while($value = $_SGLOBAL['db']->fetch_array($query)){
			realname_set($value['uid'], $value['username']);
			$admins[] = $value;
			$relateduids[] = $value['uid'];
		}

		// ���Ա
		$members = array();
		$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname("userevent")." WHERE eventid = '$eventid' AND status=2 ORDER BY dateline DESC LIMIT 14");
		while($value = $_SGLOBAL['db']->fetch_array($query)){
			realname_set($value['uid'], $value['username']);
			$members[] = $value;
			$relateduids[] = $value['uid'];
		}

		// ����Ȥ��
		$follows = array();
		$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname("userevent")." WHERE eventid='$eventid' AND status=1 ORDER BY dateline DESC LIMIT 12");
		while($value = $_SGLOBAL['db']->fetch_array($query)){
			realname_set($value['uid'], $value['username']);
			$follows[] = $value;
		}

		// ���������
		$verifynum = 0;
		if($_SGLOBAL['supe_userevent']['status'] >= 3){
			$verifynum = $_SGLOBAL['db']->result($_SGLOBAL['db']->query("SELECT count(*) FROM ".tname("userevent")." WHERE eventid = '$eventid' AND status=0"),0);
		}

		// �μ���������Ҳ�μ�����Щ�
		$relatedevents = array();
		if($relateduids){
			$query = $_SGLOBAL['db']->query("SELECT e.*, ue.* FROM ".tname("userevent")." ue LEFT JOIN ".tname("event")." e ON ue.eventid=e.eventid WHERE ue.uid IN (".simplode($relateduids).") ORDER BY ue.dateline DESC LIMIT 0,8");
			while ($value = $_SGLOBAL['db']->fetch_array($query)) {
				$relatedevents[$value['eventid']] = $value;
			}
		}

		// ����ԣ�ȡ20��
		$comments = array();
		$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('comment')." WHERE id='$eventid' AND idtype='eventid' ORDER BY dateline DESC LIMIT 20");
		while ($value = $_SGLOBAL['db']->fetch_array($query)) {
			realname_set($value['authorid'], $value['author']);
			$comments[] = $value;
		}

		// ���Ƭ
		$photolist = $badpicids = array();
		$query = $_SGLOBAL['db']->query("SELECT pic.*, ep.* FROM ".tname("eventpic")." ep LEFT JOIN ".tname("pic")." pic ON ep.picid = pic.picid WHERE ep.eventid='$eventid' ORDER BY ep.picid DESC LIMIT 10");
		while($value = $_SGLOBAL['db']->fetch_array($query)){
			if(!$value['filepath']){//��Ƭ�Ѿ���ɾ��
				$badpicids[] = $value['picid'];
				continue;
			}
			realname_set($value['uid'], $value['username']);
			$value['pic'] = pic_get($value['filepath'], $value['thumb'], $value['remote']);
			$photolist[] = $value;
		}

		if($badpicids) {
			$_SGLOBAL['db']->query("DELETE FROM ".tname("eventpic")." WHERE eventid='$eventid' AND picid IN (".simplode($badpicids).")");
		}

		//�����
		$threadlist = array();
		if($event['tagid']) {
			$count = $_SGLOBAL['db']->result($_SGLOBAL['db']->query("SELECT COUNT(*) FROM ".tname('thread')." WHERE eventid='$eventid'"),0);
			if($count) {
				$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('thread')." WHERE eventid='$eventid' ORDER BY lastpost DESC LIMIT 10");
				while ($value = $_SGLOBAL['db']->fetch_array($query)) {
					realname_set($value['uid'], $value['username']);
					$threadlist[] = $value;
				}
			}
		}

		// ��鿴��� 1
		if($event['uid'] != $_SGLOBAL['supe_uid']){
			$_SGLOBAL['db']->query("UPDATE ".tname("event")." SET viewnum=viewnum+1 WHERE eventid='$eventid'");
			$event['viewnum'] += 1;
		}

		//���ʼ����ʱ
		if($event['starttime'] > $_SGLOBAL['timestamp']) {
			$countdown = intval((mktime(0,0,0,gmdate('m',$event['starttime']),gmdate('d',$event['starttime']),gmdate('Y',$event['starttime'])) -
						mktime(0,0,0,gmdate('m',$_SGLOBAL['timestamp']),gmdate('d',$_SGLOBAL['timestamp']),gmdate('Y',$_SGLOBAL['timestamp']))) / 86400);
		}
	}


	//����ȵ�
	$topic = topic_get($event['topicid']);

	realname_get();

	$menu = array($view => ' class="active"');
	$query3=$_SGLOBAL['db']->result($_SGLOBAL['db']->query("SELECT COUNT(*) FROM ".tname('eventgo')."  WHERE eid='$eventid' "),0);
	$perpage =$query3;
	$page = empty($_REQUEST['page'])?1:intval($_REQUEST['page']);
	if($page<1) $page=1;
	$start = ($page-1)*$perpage;
	$_TPL['css'] = 'event';
	//include template("space_event_view1");
	$event['dateline'] = date("Y-m-d h:i:s",$event['dateline']);
	$event['starttime'] = date("Y-m-d h:i:s",$event['starttime']);
	$event['endtime'] = date("Y-m-d h:i:s",$event['endtime']);
	$event['deadline'] = date("Y-m-d h:i:s",$event['deadline']);
	$event['name']=$_SN[$event[uid]];
	$event['class']=$_SGLOBAL[eventclass][$event[classid]][classname];
	$query1 = $_SGLOBAL['db']->query("SELECT * FROM ".tname('eventgo')."
		WHERE eid='$_REQUEST[id]'");
	while ($value1 = $_SGLOBAL['db']->fetch_array($query1)) {
		//realname_set($value1['uid'], $value1['username']);
		$eventlist1[] = $value1;
	}
	capi_showmessage_by_data("rest_success", 0, array('eventlist'=>$event,'eventgo'=>$eventlist1));
} else {// ��б�

	if(!in_array($view, array("friend","me","all","recommend","city"))){
		$view = "all";
	}
	if($view == "friend" && !$space['friendnum']) {
		$view = "me";
	}
	if($view == "all" || $view == "city") {
		$type = $_REQUEST['type'] == "over" ? $_REQUEST['type'] : "going";
	} elseif($view == "me" || $view == "friend") {
		$type = in_array($_REQUEST['type'], array("join", "follow", "org", "self")) ? $_REQUEST['type'] : "all";
	} elseif($view == "recommend") {
		$type = $_REQUEST['type'] == "admin" ? $_REQUEST['type'] : "hot";
	}

	//ͬ�ǻ���
	if($view=="city") {
		if(empty($_REQUEST['province'])) {
			$_REQUEST['province'] = $space['resideprovince'];
			$_REQUEST['city'] = $space['residecity'];
			if(empty($_REQUEST['province'])) {
				$menu = array($view => ' class="active"');
				$submenus[$type] = array($type=>' class="active"');
				
				$_TPL['css'] = 'event';
				include_once template('space_event_list');
				exit();
			}
		}
	}

	// �Ƽ��
	$recommendevents = array();
	if($view == "all"){
		// ֻ��ȫ�������ʾ
		$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname("event")." WHERE grade = 2 ORDER BY recommendtime DESC LIMIT 4");
		while($value = $_SGLOBAL['db']->fetch_array($query)){
			if($value['deadline'] > $_SGLOBAL['timestamp']){
				if($value['poster']){
					$value['pic'] = pic_get($value['poster'], $value['thumb'], $value['remote']);
				} else {
					$value['pic'] = $_SGLOBAL['eventclass'][$value['classid']]['poster'];
				}
				$recommendevents[] = $value;
			}
		}
	}
	
	// ���Ż
	$hotevents = array();
	if($view == 'friend') {
		$query = $_SGLOBAL['db']->query('SELECT * FROM '.tname('event')." WHERE endtime > '$_SGLOBAL[timestamp]' ORDER BY membernum LIMIT 6");
		while($value = $_SGLOBAL['db']->fetch_array($query)){
			$hotevents[] = $value;
			realname_set($value['uid'], $value['username']);
		}
	}

	// ��ȡ���ѲμӵĻ
	$friendevents = array();
	if($space['feedfriend'] && $view != "friend" && $view != "me"){
		$query = $_SGLOBAL['db']->query("SELECT ue.*, e.*, ue.uid as fuid, ue.username as fusername FROM ".tname("userevent")." ue LEFT JOIN ".tname("event")." e ON ue.eventid=e.eventid WHERE ue.uid IN ($space[feedfriend]) AND ue.status >= 2 ORDER BY ue.dateline DESC LIMIT 6");
		while($value = $_SGLOBAL['db']->fetch_array($query)){
			if(isset($friendevents[$value['eventid']])){
				$friendevents[$value['eventid']]['friends'][] = $value['fuid'];
			} else {
				$friendevents[$value['eventid']] = $value;
				$friendevents[$value['eventid']]['friends'] = array($value['fuid']);
				realname_set($value['fuid'], $value['fusername']);
			}
		}
	}

	// �ҹ�ע�Ļ
	$followevents = array();
	if($view != "me"){
		// ���ҵĻ��ǩ�²���ʾ
		$query = $_SGLOBAL['db']->query("SELECT ue.*, e.* FROM ".tname("userevent")." ue LEFT JOIN ".tname("event")." e ON ue.eventid=e.eventid WHERE ue.uid = '$_SGLOBAL[supe_uid]' AND ue.status = 1 ORDER BY ue.dateline LIMIT 6");
		while($value = $_SGLOBAL['db']->fetch_array($query)){
			$followevents[] = $value;
			realname_set($value['uid'], $value['username']);
		}
	}	

	// ��ҳ
	$perpage = 10;
	$page = empty($_REQUEST['page'])?1:intval($_REQUEST['page']);
	$start = ($page - 1) * $perpage;
	$uid = $_REQUEST['uid'] ? $_REQUEST['uid'] : $_SGLOBAL['supe_uid'];
	$theurl = "space.php?uid=$uid&do=event&view=$view";
	//��鿪ʼ��
	ckstart($start, $perpage);

	$wherearr = array();
	$fromsql = $joinsql = $orderby = '';
	
	$needquery = true;

	if($view=="recommend") {
		$fromsql = tname("event")." e";
		if($type=="admin"){
			$wherearr[] = "e.grade = 2";
			$orderby = "e.recommendtime DESC";
			$theurl .= "&type=admin";
		} else {
			$wherearr[] = "e.endtime > '$_SGLOBAL[timestamp]'";
			$orderby = "e.membernum DESC";
			$theurl .= "&type=hot";
		}
	} elseif($view=="city" || $view=="all") {
		$fromsql = tname("event")." e";
		if($type=="over") {
			$wherearr[] = "e.endtime < '$_SGLOBAL[timestamp]'";
			$orderby = "e.eventid DESC";
			$theurl .= "&type=over";
		} else {
			$wherearr[] = "e.endtime >= '$_SGLOBAL[timestamp]'";
			$orderby = " e.eventid DESC";
			$theurl .= "&type=going";
		}
	} elseif($view == 'friend') {
		$sql = 'SELECT DISTINCT(eventid) FROM '.tname('userevent')." WHERE uid IN ($space[feedfriend])";
		if($type=="follow") {
			$sql .= ' AND status IN (0,1)';
			$theurl .= "&type=follow";
		} elseif($type=="org") {
			$sql .= ' AND status IN (3,4)';
			$theurl .= "&type=org";
		} elseif($type=="join") {
			$sql .= ' AND status IN (2,3,4)';
			$theurl .= "&type=join";
		}
		$query = $_SGLOBAL['db']->query($sql);
		$count = $_SGLOBAL['db']->num_rows($query);
		if($count) {		
			$sql .= " ORDER BY eventid DESC LIMIT $start, $perpage";
			$query = $_SGLOBAL['db']->query($sql);
			$ids = array();
			while($value = $_SGLOBAL['db']->fetch_array($query)) {
				$ids[] = $value['eventid'];
			}
			
			$fromsql = tname('event').' e';
			$joinsql = 'LEFT JOIN '.tname('userevent').' ue ON e.eventid = ue.eventid';
			$wherearr[] = 'e.eventid IN ('.simplode($ids).')';
			$orderby = " e.eventid DESC";
			$sql = "SELECT e.*, ue.uid as fuid, ue.username as fusername, ue.status FROM $fromsql $joinsql WHERE ".implode(" AND ", $wherearr);
		}
		$needquery = false;
		
	} elseif($view == "me") {
		$fromsql = tname("userevent")." ue";
		$joinsql = "LEFT JOIN ".tname('event')." e ON e.eventid=ue.eventid";
		$orderby = "ue.dateline DESC";
		if($view=="friend" && $space['feedfriend']) {
			$wherearr[] = "ue.uid IN ($space[feedfriend])";
		} else {
			$wherearr[] = "ue.uid = '$space[uid]'";
		}
		if($type=="follow") {
			$wherearr[] = "ue.status IN (0,1)";
			$theurl .= "&type=follow";
		} elseif($type=="org") {
			$wherearr[] = "ue.status IN (3,4)";
			$theurl .= "&type=org";
		} elseif($type=="join") {
			$wherearr[] = "ue.status IN (2,3,4)";
			$theurl .= "&type=join";
		} elseif($type=="self") {
			$needquery = false;
			$count = getcount('event', array('uid'=>$space['uid']));
			
			//����ͳ��
			if($space['eventnum'] != $count) {
				updatetable('space', array('eventnum' => $count), array('uid'=>$space['uid']));
			}
	
			$sql = "SELECT * FROM ".tname('event')." e WHERE e.uid='$space[uid]' ORDER BY e.dateline DESC LIMIT $start, $perpage";
		}

		if($_REQUEST['classid'] || $_REQUEST['date'] || $_REQUEST['province'] || $_REQUEST['city']) {
			$fromsql = tname("userevent")." ue, ".tname('event')." e";
			$wherearr[] = " ue.eventid = e.eventid";
			$joinsql = "";
		}
	}

	//�����
	if($_REQUEST['classid']){
		$_REQUEST['classid'] = intval($_REQUEST['classid']);
		$wherearr[] = "e.classid = '$_REQUEST[classid]'";
		$theurl .= "&classid=$_REQUEST[classid]";
	}

	//�ʱ��
	if($_REQUEST['date']){
		$daystart = sstrtotime($_REQUEST['date']);
		$dayend = $daystart + 86400;
		$wherearr[] = "e.starttime <= '$dayend' AND e.endtime >= '$daystart'";
		$theurl .= "&date=$_REQUEST[date]";
	}

	//�����
	if($_REQUEST['province']) {
		$_REQUEST['province'] = getstr($_REQUEST['province'], 20, 1, 1);
		$wherearr[] = "e.province = '$_REQUEST[province]'";
		$theurl .= "&province=$_REQUEST[province]";
	}
	if($_REQUEST['city']) {
		$_REQUEST['city'] = getstr($_REQUEST['city'], 20, 1, 1);
		$wherearr[] = "e.city = '$_REQUEST[city]'";
		$theurl .= "&city=$_REQUEST[city]";
	}

	$submenus = array($type=>' class="active"');

	//����
	if($searchkey = stripsearchkey($_REQUEST['searchkey'])) {
		$wherearr = $submenus = array();
		$wherearr[] = "e.title LIKE '%$searchkey%'";
		$theurl .= "&searchkey=$_REQUEST[searchkey]";
		cksearch($theurl);
	}

	$eventlist = $fevents = array();
	if(empty($wherearr)) $wherearr = array('1');

	if($needquery) {// ���ѵĻ���ر���
		$sql = "SELECT COUNT(*) FROM $fromsql WHERE ".implode(" AND ", $wherearr);
		$count = $_SGLOBAL['db']->result($_SGLOBAL['db']->query($sql),0);
	}
	if($count){
		if($needquery) {
			$sql = "SELECT e.* FROM $fromsql $joinsql WHERE uid='$uid' AND ".implode(" AND ", $wherearr) ." ORDER BY $orderby LIMIT $start, $perpage";
		}
		$query = $_SGLOBAL['db']->query($sql);
		while($event = $_SGLOBAL['db']->fetch_array($query)){
			if($event['poster']){
				$event['pic'] = pic_get($event['poster'], $event['thumb'], $event['remote']);
			} else {
				$event['pic'] = $_SGLOBAL['eventclass'][$event['classid']]['poster'];
			}
			realname_set($event['uid'], $event['username']);
			if($view=="friend"){
				realname_set($event['fuid'], $event['fusername']);
				$fevents[$event['eventid']][] = array("fuid"=>$event['fuid'], "fusername"=>$event['fusername'], "status"=>$event['status']);
			}
			$eventlist[] = $event;
		}
	}
	//var_dump($eventlist);
	
	capi_showmessage_by_data("rest_success", 0, array('eventlist'=>$eventlist));
	realname_get();
	
	$multi = multi($count, $perpage, $page, $theurl);
	$menu = array($view => ' class="active"');

	$_TPL['css'] = 'event';
	//include template("space_event_list1");
}

?>