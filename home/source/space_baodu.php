                                                                           
<?php
/*
	[UCenter Home] (C) 2007-2008 Comsenz Inc.
	$Id: space_feed.php 10661 2008-12-12 02:39:36Z zhengqingpeng $
*/

if(!defined('IN_UCHOME')) {
	exit('Access Denied');
}

$baoduid = isset($_GET['id']) ? intval($_GET['id']) : 0;
$view = isset($_GET['view']) ? $_GET['view'] : "all";
// �����
if(!@include_once(S_ROOT.'./data/data_baoduclass.php')) {
	include_once(S_ROOT.'./source/function_cache.php');
	baoduclass_cache();
}

if($baoduid){// ��ʾ�����

	if($view=="me"){//�ų���space.php�Զ���ӵ�$_GET[view]=me
		$view = "all";
	}
	
	// ���Ϣ
	$query = $_SGLOBAL['db']->query("SELECT e.*, ef.* FROM ".tname("baodu")." e LEFT JOIN ".tname("baodufield")." ef ON e.baoduid=ef.baoduid WHERE e.baoduid='$baoduid'");
	$baodu = $_SGLOBAL['db']->fetch_array($query);
	$baodu['replynum'] = $_SGLOBAL['db']->result($_SGLOBAL['db']->query("SELECT COUNT(*) FROM ".tname('comment')." WHERE $csql id='$baoduid' AND idtype='baoduid'"),0);
	
	if(! $baodu){
		showmessage("baodu_does_not_exist"); // ������ڻ����ѱ�ɾ��
	}
	if($baodu['grade'] == 0 && $baodu['uid'] != $_SGLOBAL['supe_uid'] && !checkperm('managebaodu')){
		showmessage('baodu_under_verify');// ����������
	}
	realname_set($baodu['uid'], $baodu['username']);
	$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname("userbaodu")." WHERE baoduid='$baoduid' AND uid='$_SGLOBAL[supe_uid]'");
	$value = $_SGLOBAL['db']->fetch_array($query);
	if($value){
		$_SGLOBAL['supe_userbaodu'] = $value;
	} else {
		$_SGLOBAL['supe_userbaodu'] = array();
	}
	$allowmanage = false; // �����Ȩ��
	if($value['status'] >= 3 || checkperm('managebaodu')){
		$allowmanage = true;
	}

	// ˽�ܻ�����Ѳμӻ���˺��й���Ȩ�޵��˻���������˿ɼ�
	
	#判断是否公开
	if($baodu['public'] == 0 && $_SGLOBAL['supe_userbaodu']['status'] < 2 && !$allowmanage){
		$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname("baoduinvite")." WHERE baoduid = '$baoduid' AND touid = '$_SGLOBAL[supe_uid]' LIMIT 1");
		$value = $_SGLOBAL['db']->fetch_array($query);
		if(empty($value)){
			showmessage("baodu_not_public"); // ����һ��˽�ܻ����Ҫͨ��������ܲ鿴
		}
	}

	if($view == "thread" && !$baodu['tagid']) {
		$view = "all";
	}
	// ���鿴���ݲ�ͬ����ȡ��ͬ���
	if($view == "member"){
		// �鿴��Ա
		$status = isset($_GET['status']) ? intval($_GET['status']) : 2;
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
		if($_GET['key']){
			$_GET['key'] = stripsearchkey($_GET['key']);
			$filter = " AND ue.username LIKE '%$_GET[key]%'";
		}

		$perpage = 5;
		$page = empty($_GET['page'])?1:intval($_GET['page']);
		if($page<1) $page=1;
		$start = ($page-1)*$perpage;

		//��鿪ʼ��
		ckstart($start, $perpage);
		$count = $_SGLOBAL['db']->result($_SGLOBAL['db']->query("SELECT count(*) FROM ".tname("baodugo")." WHERE eid = '$baoduid'"),0);
		$members = $fuids = array();
		if($count){
			$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname("baodugo")." WHERE eid = '$baoduid' LIMIT $start, $perpage");
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
		if($_SGLOBAL['supe_userbaodu']['status'] >= 3){
			if($status == 0){
				$verifynum = count($members);
			} else {
				$verifynum = $_SGLOBAL['db']->result($_SGLOBAL['db']->query("SELECT count(*) FROM ".tname("userbaodu")." WHERE baoduid = '$baoduid' AND status=0"), 0);
			}
		}

		$multi = multi($count, $perpage, $page, "space.php?do=baodu&id=$baoduid&view=member&status=$status");

	} elseif($view == "pic") {

		$picid = isset($_GET['picid']) ? intval($_GET['picid']) : 0;

		// ��Ƭ����
		$piccount = $_SGLOBAL['db']->result($_SGLOBAL['db']->query("SELECT COUNT(*) FROM ".tname("baodupic")." WHERE baoduid = '$baoduid'"), 0);

		if ($picid) {

			$_GET['id'] = 0;

			//����ͼƬ
			$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('pic')." WHERE picid='$picid' LIMIT 1");
			$pic = $_SGLOBAL['db']->fetch_array($query);
			realname_set($pic['uid'], $pic['username']);			
			
			include_once(S_ROOT.'./source/space_album.php');

		} else {
			// �鿴���Ƭ�б�
			$photolist = array();

			//��ҳ
			$perpage = 12;
			$page = empty($_GET['page'])?1:intval($_GET['page']);
			if($page<1) $page=1;
			$start = ($page-1)*$perpage;

			//��鿪ʼ��
			ckstart($start, $perpage);

			//�����ѯ
			$theurl = "space.php?do=baodu&id=$baoduid&view=pic";

			$badpicids = array();
			$query = $_SGLOBAL['db']->query("SELECT pic.*, ep.* FROM ".tname("baodupic")." ep LEFT JOIN ".tname("pic")." pic ON ep.picid=pic.picid WHERE ep.baoduid='$baoduid' ORDER BY ep.picid DESC LIMIT $start, $perpage");
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
				$_SGLOBAL['db']->query("DELETE FROM ".tname("baodupic")." WHERE baoduid='$baoduid' AND picid IN (".simplode($badpicids).")");
			}

			if($piccount != $baodu['picnum']) {//������Ŀ
				updatetable("baodu", array("picnum"=>$piccount),array("baoduid"=>$baoduid));
			}

			//��ҳ
			$multi = multi($piccount, $perpage, $page, $theurl);
		}

	} elseif($view == "thread") {
		//�����
		//��ҳ
		$perpage = 20;
		$page = empty($_GET['page'])?1:intval($_GET['page']);
		if($page<1) $page=1;
		$start = ($page-1)*$perpage;

		//��鿪ʼ��
		ckstart($start, $perpage);
		//�����ѯ
		$theurl = "space.php?do=baodu&id=$baoduid&view=thread";

		$threadlist = array();
		$count = $_SGLOBAL['db']->result($_SGLOBAL['db']->query("SELECT COUNT(*) FROM ".tname('thread')." WHERE baoduid='$baoduid'"),0);
		if($count) {
			$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('thread')." WHERE baoduid='$baoduid' ORDER BY lastpost DESC LIMIT $start,$perpage");
			while ($value = $_SGLOBAL['db']->fetch_array($query)) {
				realname_set($value['uid'], $value['username']);
				$threadlist[] = $value;
			}
		}

		if($count != $baodu['threadnum']) {
			updatetable("baodu", array("threadnum"=>$count), array("baoduid"=>$baoduid));
		}

		//��ҳ
		$multi = multi($count, $perpage, $page, $theurl);

	} elseif($view == "comment") {
		//�����
		//��ҳ
		$perpage = 20;
		$page = empty($_GET['page'])?1:intval($_GET['page']);
		if($page<1) $page=1;
		$start = ($page-1)*$perpage;

		//��鿪ʼ��
		ckstart($start, $perpage);

		//�����ѯ
		$theurl = "space.php?do=baodu&id=$baoduid&view=comment";
		$cid = empty($_GET['cid'])?0:intval($_GET['cid']);
		$csql = $cid?"cid='$cid' AND":'';

		$comments = array();
		$count = $_SGLOBAL['db']->result($_SGLOBAL['db']->query("SELECT COUNT(*) FROM ".tname('comment')." WHERE $csql id='$baoduid' AND idtype='baoduid'"),0);
		if($count) {
			$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('comment')." WHERE $csql id='$baoduid' AND idtype='baoduid' ORDER BY dateline DESC LIMIT $start,$perpage");
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
		$baodu['detail'] = blog_bbcode($baodu['detail']);

		// ����
		if($baodu['poster']){
			$baodu['pic'] = pic_get($baodu['poster'], $baodu['thumb'], $baodu['remote'], 0);
		} else {
			$baodu['pic'] = $_SGLOBAL['baoduclass'][$baodu['classid']]['poster'];
		}

		// ���֯��
		$relateduids = array();//���ҲμӴ˻�ĳ�ԱҲ�μӵĻ��
		$admins = array();
		$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname("userbaodu")." WHERE baoduid = '$baoduid' AND status IN ('3', '4') ORDER BY status DESC");
		while($value = $_SGLOBAL['db']->fetch_array($query)){
			realname_set($value['uid'], $value['username']);
			$admins[] = $value;
			$relateduids[] = $value['uid'];
		}
		
		
		$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname("baodugo")." WHERE eid = '$baoduid'");
			while($value = $_SGLOBAL['db']->fetch_array($query)){
				$value1['username']=$value['username'];
				$value1['tel']=$value['tel'];
				$members[] = $value1;
				$fuids[] = $value['uid'];
			}
			
			
		// ����Ȥ��
		$follows = array();
		$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname("userbaodu")." WHERE baoduid='$baoduid' AND status=1 ORDER BY dateline DESC LIMIT 12");
		while($value = $_SGLOBAL['db']->fetch_array($query)){
			realname_set($value['uid'], $value['username']);
			$follows[] = $value;
		}

		// ���������
		$verifynum = 0;
		if($_SGLOBAL['supe_userbaodu']['status'] >= 3){
			$verifynum = $_SGLOBAL['db']->result($_SGLOBAL['db']->query("SELECT count(*) FROM ".tname("userbaodu")." WHERE baoduid = '$baoduid' AND status=0"),0);
		}

		// �μ���������Ҳ�μ�����Щ�
		$relatedbaodus = array();
		if($relateduids){
			$query = $_SGLOBAL['db']->query("SELECT e.*, ue.* FROM ".tname("userbaodu")." ue LEFT JOIN ".tname("baodu")." e ON ue.baoduid=e.baoduid WHERE ue.uid IN (".simplode($relateduids).") ORDER BY ue.dateline DESC LIMIT 0,8");
			while ($value = $_SGLOBAL['db']->fetch_array($query)) {
				$relatedbaodus[$value['baoduid']] = $value;
			}
		}

		// ����ԣ�ȡ20��
		$comments = array();
		$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('comment')." WHERE id='$baoduid' AND idtype='baoduid' ORDER BY dateline DESC LIMIT 20");
		while ($value = $_SGLOBAL['db']->fetch_array($query)) {
			realname_set($value['authorid'], $value['author']);
			$comments[] = $value;
		}

		// ���Ƭ
		$photolist = $badpicids = array();
		$query = $_SGLOBAL['db']->query("SELECT pic.*, ep.* FROM ".tname("baodupic")." ep LEFT JOIN ".tname("pic")." pic ON ep.picid = pic.picid WHERE ep.baoduid='$baoduid' ORDER BY ep.picid DESC LIMIT 10");
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
			$_SGLOBAL['db']->query("DELETE FROM ".tname("baodupic")." WHERE baoduid='$baoduid' AND picid IN (".simplode($badpicids).")");
		}

		//�����
		$threadlist = array();
		if($baodu['tagid']) {
			$count = $_SGLOBAL['db']->result($_SGLOBAL['db']->query("SELECT COUNT(*) FROM ".tname('thread')." WHERE baoduid='$baoduid'"),0);
			if($count) {
				$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('thread')." WHERE baoduid='$baoduid' ORDER BY lastpost DESC LIMIT 10");
				while ($value = $_SGLOBAL['db']->fetch_array($query)) {
					realname_set($value['uid'], $value['username']);
					$threadlist[] = $value;
				}
			}
		}

		// ��鿴��� 1
		if($baodu['uid'] != $_SGLOBAL['supe_uid']){
			$_SGLOBAL['db']->query("UPDATE ".tname("baodu")." SET viewnum=viewnum+1 WHERE baoduid='$baoduid'");
			$baodu['viewnum'] += 1;
		}

		//���ʼ����ʱ
		if($baodu['starttime'] > $_SGLOBAL['timestamp']) {
			$countdown = intval((mktime(0,0,0,gmdate('m',$baodu['starttime']),gmdate('d',$baodu['starttime']),gmdate('Y',$baodu['starttime'])) -
						mktime(0,0,0,gmdate('m',$_SGLOBAL['timestamp']),gmdate('d',$_SGLOBAL['timestamp']),gmdate('Y',$_SGLOBAL['timestamp']))) / 86400);
		}
	}


	//����ȵ�
	$topic = topic_get($baodu['topicid']);

	realname_get();

	$menu = array($view => ' class="active"');

	$_TPL['css'] = 'baodu';
	$perpage = 20;
		$page = empty($_GET['page'])?1:intval($_GET['page']);
		if($page<1) $page=1;
		$start = ($page-1)*$perpage;

		//��鿪ʼ��
		ckstart($start, $perpage);
		//�����ѯ
		$theurl = "space.php?do=baodu&id=$baoduid&view=thread";

		$threadlist = array();
		$count = $baodu['replynum'];
		
		//��ҳ
		$multi = multi($count, $perpage, $page, $theurl);
	include template("space_baodu_view1");

} else {// ��б�

	if(!in_array($view, array("friend","me","all","recommend","city"))){
		$view = "all";
	}
	if($view == "friend" && !$space['friendnum']) {
		$view = "me";
	}
	if($view == "all" || $view == "city") {
		$type = $_GET['type'] == "over" ? $_GET['type'] : "going";
	} elseif($view == "me" || $view == "friend") {
		$type = in_array($_GET['type'], array("join", "follow", "org", "self")) ? $_GET['type'] : "all";
	} elseif($view == "recommend") {
		$type = $_GET['type'] == "admin" ? $_GET['type'] : "hot";
	}

	//ͬ�ǻ���
	if($view=="city") {
		if(empty($_GET['province'])) {
			$_GET['province'] = $space['resideprovince'];
			$_GET['city'] = $space['residecity'];
			if(empty($_GET['province'])) {
				$menu = array($view => ' class="active"');
				$submenus[$type] = array($type=>' class="active"');
				
				$_TPL['css'] = 'baodu';
				include_once template('space_baodu_list');
				exit();
			}
		}
	}

	// �Ƽ��
	$recommendbaodus = array();
	if($view == "all"){
		// ֻ��ȫ�������ʾ
		$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname("baodu")." WHERE grade = 2 ORDER BY recommendtime DESC LIMIT 4");
		while($value = $_SGLOBAL['db']->fetch_array($query)){
			if($value['deadline'] > $_SGLOBAL['timestamp']){
				if($value['poster']){
					$value['pic'] = pic_get($value['poster'], $value['thumb'], $value['remote']);
				} else {
					$value['pic'] = $_SGLOBAL['baoduclass'][$value['classid']]['poster'];
				}
				$recommendbaodus[] = $value;
			}
		}
	}
	
	// ���Ż
	$hotbaodus = array();
	if($view == 'friend') {
		$query = $_SGLOBAL['db']->query('SELECT * FROM '.tname('baodu')." WHERE endtime > '$_SGLOBAL[timestamp]' ORDER BY membernum LIMIT 6");
		while($value = $_SGLOBAL['db']->fetch_array($query)){
			$hotbaodus[] = $value;
			realname_set($value['uid'], $value['username']);
		}
	}

	// ��ȡ���ѲμӵĻ
	$friendbaodus = array();
	if($space['feedfriend'] && $view != "friend" && $view != "me"){
		$query = $_SGLOBAL['db']->query("SELECT ue.*, e.*, ue.uid as fuid, ue.username as fusername FROM ".tname("userbaodu")." ue LEFT JOIN ".tname("baodu")." e ON ue.baoduid=e.baoduid WHERE ue.uid IN ($space[feedfriend]) AND ue.status >= 2 ORDER BY ue.dateline DESC LIMIT 6");
		while($value = $_SGLOBAL['db']->fetch_array($query)){
			if(isset($friendbaodus[$value['baoduid']])){
				$friendbaodus[$value['baoduid']]['friends'][] = $value['fuid'];
			} else {
				$friendbaodus[$value['baoduid']] = $value;
				$friendbaodus[$value['baoduid']]['friends'] = array($value['fuid']);
				realname_set($value['fuid'], $value['fusername']);
			}
		}
	}

	// �ҹ�ע�Ļ
	$followbaodus = array();
	if($view != "me"){
		// ���ҵĻ��ǩ�²���ʾ
		$query = $_SGLOBAL['db']->query("SELECT ue.*, e.* FROM ".tname("userbaodu")." ue LEFT JOIN ".tname("baodu")." e ON ue.baoduid=e.baoduid WHERE ue.uid = '$_SGLOBAL[supe_uid]' AND ue.status = 1 ORDER BY ue.dateline LIMIT 6");
		while($value = $_SGLOBAL['db']->fetch_array($query)){
			$followbaodus[] = $value;
			realname_set($value['uid'], $value['username']);
		}
	}	

	// ��ҳ
	$perpage = 10;
	$page = empty($_GET['page'])?1:intval($_GET['page']);
	$start = ($page - 1) * $perpage;
	$uid = $_GET['uid'] ? $_GET['uid'] : $_SGLOBAL['supe_uid'];
	$theurl = "space.php?uid=$uid&do=baodu&view=$view";
	//��鿪ʼ��
	ckstart($start, $perpage);

	$wherearr = array();
	$fromsql = $joinsql = $orderby = '';
	
	$needquery = true;

	if($view=="recommend") {
		$fromsql = tname("baodu")." e";
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
		$fromsql = tname("baodu")." e";
		if($type=="over") {
			$wherearr[] = "e.endtime < '$_SGLOBAL[timestamp]'";
			$orderby = "e.baoduid DESC";
			$theurl .= "&type=over";
		} else {
			$wherearr[] = "e.endtime >= '$_SGLOBAL[timestamp]'";
			$orderby = " e.baoduid DESC";
			$theurl .= "&type=going";
		}
	} elseif($view == 'friend') {
		$sql = 'SELECT DISTINCT(baoduid) FROM '.tname('userbaodu')." WHERE uid IN ($space[feedfriend])";
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
			$sql .= " ORDER BY baoduid DESC LIMIT $start, $perpage";
			$query = $_SGLOBAL['db']->query($sql);
			$ids = array();
			while($value = $_SGLOBAL['db']->fetch_array($query)) {
				$ids[] = $value['baoduid'];
			}
			
			$fromsql = tname('baodu').' e';
			$joinsql = 'LEFT JOIN '.tname('userbaodu').' ue ON e.baoduid = ue.baoduid';
			$wherearr[] = 'e.baoduid IN ('.simplode($ids).')';
			$orderby = " e.baoduid DESC";
			$sql = "SELECT e.*, ue.uid as fuid, ue.username as fusername, ue.status FROM $fromsql $joinsql WHERE ".implode(" AND ", $wherearr);
		}
		$needquery = false;
		
	} elseif($view == "me") {
		$fromsql = tname("userbaodu")." ue";
		$joinsql = "LEFT JOIN ".tname('baodu')." e ON e.baoduid=ue.baoduid";
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
			$count = getcount('baodu', array('uid'=>$space['uid']));
			
			//����ͳ��
			if($space['baodunum'] != $count) {
				updatetable('space', array('baodunum' => $count), array('uid'=>$space['uid']));
			}
	
			$sql = "SELECT * FROM ".tname('baodu')." e WHERE e.uid='$space[uid]' ORDER BY e.dateline DESC LIMIT $start, $perpage";
		}

		if($_GET['classid'] || $_GET['date'] || $_GET['province'] || $_GET['city']) {
			$fromsql = tname("userbaodu")." ue, ".tname('baodu')." e";
			$wherearr[] = " ue.baoduid = e.baoduid";
			$joinsql = "";
		}
	}

	//�����
	if($_GET['classid']){
		$_GET['classid'] = intval($_GET['classid']);
		$wherearr[] = "e.classid = '$_GET[classid]'";
		$theurl .= "&classid=$_GET[classid]";
	}

	//�ʱ��
	if($_GET['date']){
		$daystart = sstrtotime($_GET['date']);
		$dayend = $daystart + 86400;
		$wherearr[] = "e.starttime <= '$dayend' AND e.endtime >= '$daystart'";
		$theurl .= "&date=$_GET[date]";
	}

	//�����
	if($_GET['province']) {
		$_GET['province'] = getstr($_GET['province'], 20, 1, 1);
		$wherearr[] = "e.province = '$_GET[province]'";
		$theurl .= "&province=$_GET[province]";
	}
	if($_GET['city']) {
		$_GET['city'] = getstr($_GET['city'], 20, 1, 1);
		$wherearr[] = "e.city = '$_GET[city]'";
		$theurl .= "&city=$_GET[city]";
	}

	$submenus = array($type=>' class="active"');

	//����
	if($searchkey = stripsearchkey($_GET['searchkey'])) {
		$wherearr = $submenus = array();
		$wherearr[] = "e.title LIKE '%$searchkey%'";
		$theurl .= "&searchkey=$_GET[searchkey]";
		cksearch($theurl);
	}

	$baodulist = $fbaodus = array();
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
		while($baodu = $_SGLOBAL['db']->fetch_array($query)){
			if($baodu['poster']){
				$baodu['pic'] = pic_get($baodu['poster'], $baodu['thumb'], $baodu['remote']);
			} else {
				$baodu['pic'] = $_SGLOBAL['baoduclass'][$baodu['classid']]['poster'];
			}
			realname_set($baodu['uid'], $baodu['username']);
			if($view=="friend"){
				realname_set($baodu['fuid'], $baodu['fusername']);
				$fbaodus[$baodu['baoduid']][] = array("fuid"=>$baodu['fuid'], "fusername"=>$baodu['fusername'], "status"=>$baodu['status']);
			}
			$baodulist[$baodu['baoduid']] = $baodu;
		}
	}
	//var_dump($baodulist);
	realname_get();

	$multi = multi($count, $perpage, $page, $theurl);
	$menu = array($view => ' class="active"');

	$_TPL['css'] = 'baodu';
	include template("space_baodu_list1");
}

?>                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    