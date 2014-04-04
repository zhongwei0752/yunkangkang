<?php
/*
	[UCenter Home] (C) 2007-2008 Comsenz Inc.
	$Id: space_blog.php 10785 2008-12-22 08:22:13Z liguode $
*/

if(!defined('IN_UCHOME')) {
	exit('Access Denied');
}

$obpage = empty($_REQUEST['obpage'])?1:intval($_REQUEST['obpage']);
$repage = empty($_REQUEST['repage'])?1:intval($_REQUEST['repage']);
$page = empty($_REQUEST['page'])?1:intval($_REQUEST['page']);
if($obpage<1) $obpage=1;
if($repage<1) $repage=1;
if($page<1) $page=1;
$id = empty($_REQUEST['id'])?0:intval($_REQUEST['id']);
if($id) {
	//��ȡ����
	$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('debate')." WHERE debateid='$id'");
	$debate = $_SGLOBAL['db']->fetch_array($query);
	$obvoteuids=empty($debate['obvoteuids'])?array():explode(',',$debate['obvoteuids']);
	$revoteuids=empty($debate['revoteuids'])?array():explode(',',$debate['revoteuids']);
	$obvotenum=count($obvoteuids);
	$revotenum=count($revoteuids);
	//���۲�����
	if(empty($debate)) {
		capi_showmessage_by_data('view_to_info_debateid_not_exist');
	}
	//ͳ���Ƿ��ѹ�ע�ı��� add by xianyima 2009.4.16
	$query = $_SGLOBAL['db']->query("SELECT debateid FROM ".tname('debate_concern')." WHERE uid ='$_SGLOBAL[supe_uid]'");
    $concern=$_SGLOBAL['db']->fetch_array($query);
	$debateids=explode(',',$concern['debateid']);
	//����
	//$debate['pic'] = mkpicurl($debate);

	//������Ƶ��ǩ
	include_once(S_ROOT.'./source/function_debate.php');
	$debate['message'] = debate_bbcode($debate['message']);
	
	//����
	$perpage = 5;
	$obstart = ($obpage-1)*$perpage;
	$restart = ($repage-1)*$perpage;

	//��鿪ʼ��
	ckstart($obstart, $perpage);
	ckstart($restart, $perpage);

	$obcount = $debate['obreplynum'];
	$recount = $debate['rereplynum'];
	$replynum=$debate['obreplynum']+$debate['rereplynum'];
	$debate['replynum']=$debate['obreplynum']+$debate['rereplynum'];

	$oblist = $relist = array();
	if($obcount) {
		$cid = empty($_REQUEST['cid'])?0:intval($_REQUEST['cid']);
		$csql = $cid?"cid='$cid' AND":'';

		$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('debate_comment')." WHERE  debateid='$id' AND debatetype=0 ORDER BY dateline DESC LIMIT $obstart,$perpage");
		while ($value = $_SGLOBAL['db']->fetch_array($query)) {

			$value['voteids']=empty($value['voteids'])?array():explode(',',$value['voteids']);
			$oblist[] = $value;
		}
	}
	if($recount) {
		$cid = empty($_REQUEST['cid'])?0:intval($_REQUEST['cid']);
		$csql = $cid?"cid='$cid' AND":'';

		$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('debate_comment')." WHERE debateid='$id' AND debatetype=1 ORDER BY dateline DESC LIMIT $restart,$perpage");
		while ($value = $_SGLOBAL['db']->fetch_array($query)) {

			$value['voteids']=empty($value['voteids'])?array():explode(',',$value['voteids']);
			$relist[] = $value;
		}
	}
	//��ҳ
	$obmulti = multi1($obcount, $perpage, $obpage, "space.php?uid=$debate[uid]&do=$do&id=$id");
	$remulti = multi2($recount, $perpage, $repage, "space.php?uid=$debate[uid]&do=$do&id=$id");


	//����ͳ��
	if(!$space['self']) {
		$_SGLOBAL['db']->query("UPDATE ".tname('debate')." SET viewnum=viewnum+1 WHERE debateid='$debate[debateid]'");
		inserttable('log', array('id'=>$space['uid'], 'idtype'=>'uid'));//�ӳٸ���
	}

	capi_showmessage_by_data("rest_success", 0, array('obdebate'=>$oblist,'redebate'=>$relist));

} else {
	$_REQUEST['view'] = $_REQUEST['view'] ? trim($_REQUEST['view']) : 'all';
	//��ҳ
	$perpage = 4;
	//$perpage =$_REQUEST['perpage'];
	$start = ($page-1)*$perpage;
	
	//��鿪ʼ��
	ckstart($start, $perpage);

	//ժҪ��ȡ
	$summarylen = 300;

	$list =  array();
	$userlist = array();
	$debateids = array();
	$count = 0;
    
	//��ѯ��ע�Ͳμӵı���
	 $query = $_SGLOBAL['db']->query("SELECT debateid,jdebateid FROM ".tname('debate_concern')." WHERE uid ='$_SGLOBAL[supe_uid]'");
     $concern=$_SGLOBAL['db']->fetch_array($query);
	 
	//�����ѯ
	$f_index = '';
	   if($_REQUEST['view'] == 'all') {
			//��ҵı���
			$wheresql = " 1 ";
			$theurl = "space.php?uid=$space[uid]&do=$do&view=all";
			$actives = array('all'=>' class="active"');

		}elseif($_REQUEST['view'] == 'concern' && !empty($concern['debateid'])){
		    $wheresql = "debateid IN ($concern[debateid])";
		    $theurl = "space.php?uid=$space[uid]&do=$do";
		    $f_index = 'USE INDEX(dateline)';
		    $actives = array('concern'=>' class="active"');
		}elseif($_REQUEST['view'] == 'joined' && !empty($concern['jdebateid'])){
		    $wheresql = "debateid IN ($concern[jdebateid])";
		    $theurl = "space.php?uid=$space[uid]&do=$do";
		    $f_index = 'USE INDEX(dateline)';
		    $actives = array('joined'=>' class="active"');
		}elseif(empty($space['feedfriend'])) {
			$wheresql = "uid='$space[uid]'";
			$theurl = "space.php?uid=$space[uid]&do=$do&view=me";
			$actives = array('me'=>' class="active"');
			
		} else {
			$wheresql = "uid IN ($space[feedfriend])";
			$theurl = "space.php?uid=$space[uid]&do=$do";
			$f_index = 'USE INDEX(dateline)';
			$actives = array('we'=>' class="active"');
		}

		

		$count = $_SGLOBAL['db']->result($_SGLOBAL['db']->query("SELECT COUNT(*) FROM ".tname('debate')." WHERE $wheresql"),0);
		if($count) {
			$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('debate')." $f_index WHERE $wheresql ORDER BY dateline DESC LIMIT $start,$perpage");
		}

	if($count) {
		while ($value = $_SGLOBAL['db']->fetch_array($query)) {
				realname_set($value['uid'], $value['username']);
				$value['message'] = $value['friend']==4?'':getstr($value['message'], $summarylen, 0, 0, 0, 0, -1);
				//$value['pic'] = mkpicurl($value);
				$list[] = $value;
				$userlist[$value['uid']] = $value['username'];
		}
	}

	//��ҳ
	$multi = multi($count, $perpage, $page, $theurl);

	//ʵ��
	realname_get();
	capi_showmessage_by_data("rest_success", 0, array('debate'=>$list,'count'=>$count));
	$_TPL['css'] = 'debate';
}

?>