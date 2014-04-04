<?php
/*
	[UCenter Home] (C) 2007-2008 Comsenz Inc.
	$Id: space_blog.php 10785 2008-12-22 08:22:13Z liguode $
*/

if(!defined('IN_UCHOME')) {
	exit('Access Denied');
}

$page = empty($_REQUEST['page'])?1:intval($_REQUEST['page']);
if($page<1) $page=1;
$id = empty($_REQUEST['id'])?0:intval($_REQUEST['id']);
if($id) {
	//读取活动
	$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('stratch')." WHERE stratchid='$id'");
	$stratch = $_SGLOBAL['db']->fetch_array($query);
	//活动不存在
	if(empty($stratch)) {
		capi_showmessage_by_data('view_to_info_stratchid_not_exist');
	}
	//统计是否已关注改辩论 add by xianyima 2009.4.16
	/*$query = $_SGLOBAL['db']->query("SELECT stratchid FROM ".tname('stratch_concern')." WHERE uid ='$_SGLOBAL[supe_uid]'");
    $concern=$_SGLOBAL['db']->fetch_array($query);
	$stratchids=explode(',',$concern['stratchid']);*/
	//整理
	$stratch['pic'] = mkpicurl($stratch);

	//处理视频标签
	include_once(S_ROOT.'./source/function_stratch.php');
	$stratch['message'] = stratch_bbcode($stratch['message']);
	
	//辩论
	$perpage = 5;



	//访问统计
	if(!$space['self']) {
		$_SGLOBAL['db']->query("UPDATE ".tname('stratch')." SET viewnum=viewnum+1 WHERE stratchid='$stratch[stratchid]'");
		inserttable('log', array('id'=>$space['uid'], 'idtype'=>'uid'));//延迟更新
	}

	//实名
	realname_get();
	capi_showmessage_by_data("rest_success", 0, array('stratchcontent'=>$stratch));

} else {
	$_REQUEST['view'] = $_REQUEST['view'] ? trim($_REQUEST['view']) : 'all';
	//分页
	$perpage = 4;
	$start = ($page-1)*$perpage;
	
	//检查开始数
	ckstart($start, $perpage);

	//摘要截取
	$summarylen = 300;

	$list =  array();
	$userlist = array();
	$stratchids = array();
	$count = 0;
    
	//查询关注和参加的辩论
	 /*$query = $_SGLOBAL['db']->query("SELECT stratchid,jstratchid FROM ".tname('stratch_concern')." WHERE uid ='$_SGLOBAL[supe_uid]'");
     $concern=$_SGLOBAL['db']->fetch_array($query);*/
	 
	 
	//处理查询
	$f_index = '';
	   if($_REQUEST['view'] == 'all') {
			//大家的辩论
			$wheresql = " 1 ";
			$theurl = "space.php?uid=$space[uid]&do=$do&view=all";
			$actives = array('all'=>' class="active"');

		}elseif($_REQUEST['view'] == 'concern' && !empty($concern['stratchid'])){
		    $wheresql = "stratchid IN ($concern[stratchid])";
		    $theurl = "space.php?uid=$space[uid]&do=$do";
		    $f_index = 'USE INDEX(dateline)';
		    $actives = array('concern'=>' class="active"');
		}elseif($_REQUEST['view'] == 'joined' && !empty($concern['jstratchid'])){
		    $wheresql = "stratchid IN ($concern[jstratchid])";
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

		
	
		$count = $_SGLOBAL['db']->result($_SGLOBAL['db']->query("SELECT COUNT(*) FROM ".tname('stratch')." WHERE uid ='$_GET[uid]' "),0);
		if($count) {
			$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('stratch')." WHERE uid ='$_$_GET[uid]' ORDER BY dateline DESC LIMIT $start,$perpage");
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
	capi_showmessage_by_data("rest_success", 0, array('stratch'=>$list));
}

?>