<?php
/*
	[UCenter Home] (C) 2007-2008 Comsenz Inc.
	$Id: space_blog.php 10785 2008-12-22 08:22:13Z liguode $
*/
if(!defined('IN_UCHOME')) {
	exit('Access Denied');
}

$page = empty($_GET['page'])?1:intval($_GET['page']);
if($obpage<1) $obpage=1;
if($repage<1) $repage=1;
if($page<1) $page=1;
$id = empty($_GET['id'])?0:intval($_GET['id']);
if($id) {
	//读取活动
	$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('stratch')." WHERE stratchid='$id' AND uid='$space[uid]'");
	$stratch = $_SGLOBAL['db']->fetch_array($query);
	
	//辩论不存在
	if(empty($stratch)) {
		showmessage('view_to_info_stratchid_not_exist');
	}
	//统计是否已关注改辩论 add by xianyima 2009.4.16
	/*$query = $_SGLOBAL['db']->query("SELECT stratchid FROM ".tname('stratch_concern')." WHERE uid ='$_SGLOBAL[supe_uid]'");
    $concern=$_SGLOBAL['db']->fetch_array($query);
	$stratchids=explode(',',$concern['stratchid']);*/
	//整理
	//$stratch['pic'] = mkpicurl($stratch);

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

	include_once template("space_stratch_view");

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
	$stratchids = array();
	$count = 0;
    
	//查询关注和参加的辩论
	 /*$query = $_SGLOBAL['db']->query("SELECT stratchid,jstratchid FROM ".tname('stratch_concern')." WHERE uid ='$_SGLOBAL[supe_uid]'");
     $concern=$_SGLOBAL['db']->fetch_array($query);*/
	 
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

		

		$count = $_SGLOBAL['db']->result($_SGLOBAL['db']->query("SELECT COUNT(*) FROM ".tname('stratch')." WHERE uid ='$_SGLOBAL[supe_uid]' "),0);
		if($count) {
			$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('stratch')." $f_index WHERE stratchid>0 AND uid ='$_SGLOBAL[supe_uid]' ORDER BY dateline DESC LIMIT $start,$perpage");
		}


	if($count) {
		while ($value = $_SGLOBAL['db']->fetch_array($query)) {
				realname_set($value['uid'], $value['username']);
				$value['message'] = $value['friend']==4?'':getstr($value['message'], $summarylen, 0, 0, 0, 0, -1);
				//$value['pic'] = mkpicurl($value);
				$query2 = $_SGLOBAL['db']->query("SELECT * FROM ".tname('stratch_content')." WHERE stratchid='$value[stratchid]'");
				$value2 = $_SGLOBAL['db']->fetch_array($query2);
				$value['open']=$value2['open'];
				$list[] = $value;
				$userlist[$value['uid']] = $value['username'];
		}
	}
	$value2 = array();
	
	
	//分页
	$multi = multi($count, $perpage, $page, $theurl);

	//实名
	realname_get();

	include_once template("space_stratch_list");
}

?>