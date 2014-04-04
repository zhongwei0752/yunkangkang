<?php
/*
	[UCenter Home] (C) 2007-2008 Comsenz Inc.
	$Id: space_blog.php 10785 2008-12-22 08:22:13Z liguode $
*/

if(!defined('IN_UCHOME')) {
	exit('Access Denied');
}


$obpage = empty($_GET['obpage'])?1:intval($_GET['obpage']);
$repage = empty($_GET['repage'])?1:intval($_GET['repage']);
$page = empty($_GET['page'])?1:intval($_GET['page']);
if($obpage<1) $obpage=1;
if($repage<1) $repage=1;
if($page<1) $page=1;
$id = empty($_GET['id'])?0:intval($_GET['id']);
if($id) {
	//读取辩论
	$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('debate')." WHERE debateid='$id'");
	$debate = $_SGLOBAL['db']->fetch_array($query);
	$obvoteuids=empty($debate['obvoteuids'])?array():explode(',',$debate['obvoteuids']);
	$revoteuids=empty($debate['revoteuids'])?array():explode(',',$debate['revoteuids']);
	$obvotenum=count($obvoteuids);
	$revotenum=count($revoteuids);
	
	//辩论不存在
	if(empty($debate)) {
		showmessage('view_to_info_debateid_not_exist');
	}
	//统计是否已关注改辩论 add by xianyima 2009.4.16
	$query = $_SGLOBAL['db']->query("SELECT debateid FROM ".tname('debate_concern')." WHERE uid ='$_SGLOBAL[supe_uid]'");
    $concern=$_SGLOBAL['db']->fetch_array($query);
	$debateids=explode(',',$concern['debateid']);
	//整理
	//$debate['pic'] = mkpicurl($debate);

	//处理视频标签
	include_once(S_ROOT.'./source/function_debate.php');
	$debate['message'] = debate_bbcode($debate['message']);
	
	//辩论
	$perpage = 5;
	$obstart = ($obpage-1)*$perpage;
	$restart = ($repage-1)*$perpage;

	//检查开始数
	ckstart($obstart, $perpage);
	ckstart($restart, $perpage);

	$obcount = $debate['obreplynum'];
	$recount = $debate['rereplynum'];
	$debate['replynum']=$debate['obreplynum']+$debate['rereplynum'];

	$oblist = $relist = array();
	if($obcount) {
		$cid = empty($_GET['cid'])?0:intval($_GET['cid']);
		$csql = $cid?"cid='$cid' AND":'';

		$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('debate_comment')." WHERE $csql debateid='$id' AND debatetype=0 ORDER BY dateline LIMIT $obstart,$perpage");
		while ($value = $_SGLOBAL['db']->fetch_array($query)) {
			realname_set($value['authorid'], $value['username']);//实名
			$value['voteids']=empty($value['voteids'])?array():explode(',',$value['voteids']);
			$oblist[] = $value;
		}
	}
	if($recount) {
		$cid = empty($_GET['cid'])?0:intval($_GET['cid']);
		$csql = $cid?"cid='$cid' AND":'';

		$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('debate_comment')." WHERE $csql debateid='$id' AND debatetype=1 ORDER BY dateline LIMIT $restart,$perpage");
		while ($value = $_SGLOBAL['db']->fetch_array($query)) {
			realname_set($value['authorid'], $value['username']);//实名
			$value['voteids']=empty($value['voteids'])?array():explode(',',$value['voteids']);
			$relist[] = $value;
		}
	}
	//分页
	$obmulti = multi1($obcount, $perpage, $obpage, "space.php?uid=$debate[uid]&do=$do&id=$id");
	$remulti = multi2($recount, $perpage, $repage, "space.php?uid=$debate[uid]&do=$do&id=$id");

	//访问统计
	if(!$space['self']) {
		$_SGLOBAL['db']->query("UPDATE ".tname('debate')." SET viewnum=viewnum+1 WHERE debateid='$debate[debateid]'");
		inserttable('log', array('id'=>$space['uid'], 'idtype'=>'uid'));//延迟更新
	}

	//实名
	realname_get();

	include_once template("space_debate_view");

} else {
	$_GET['view'] = $_GET['view'] ? trim($_GET['view']) : 'all';
	//分页
	$perpage = 5;
	$start = ($page-1)*$perpage;
	
	//检查开始数
	ckstart($start, $perpage);

	//摘要截取
	$summarylen = 300;

	$list =  array();
	$userlist = array();
	$debateids = array();
	$count = 0;
    
	//查询关注和参加的辩论
	 $query = $_SGLOBAL['db']->query("SELECT debateid,jdebateid FROM ".tname('debate_concern')." WHERE uid ='$_SGLOBAL[supe_uid]'");
     $concern=$_SGLOBAL['db']->fetch_array($query);
	 
	//处理查询
	$f_index = '';
	   if($_GET['view'] == 'all') {
			//大家的辩论
			$wheresql = " 1 ";
			$theurl = "space.php?uid=$space[uid]&do=$do&view=all";
			$actives = array('all'=>' class="active"');

		}elseif($_GET['view'] == 'concern' && !empty($concern['debateid'])){
		    $wheresql = "debateid IN ($concern[debateid])";
		    $theurl = "space.php?uid=$space[uid]&do=$do";
		    $f_index = 'USE INDEX(dateline)';
		    $actives = array('concern'=>' class="active"');
		}elseif($_GET['view'] == 'joined' && !empty($concern['jdebateid'])){
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

	//分页
	$multi = multi($count, $perpage, $page, $theurl);

	//实名
	realname_get();

	include_once template("space_debate_list");
}

?>