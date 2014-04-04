<?php
/*
	[UCenter Home] (C) 2007-2008 Comsenz Inc.
	$Id: space_blog.php 10785 2008-12-22 08:22:13Z liguode $
*/

if(!defined('IN_UCHOME')) {
	exit('Access Denied');
}


$page = empty($_GET['page'])?1:intval($_GET['page']);
if($page<1) $page=1;
$id = empty($_GET['id'])?0:intval($_GET['id']);
$view = empty($_GET['view'])?'we':$_GET['view'];
$activearr = array('reservation'=>'  class="aa"');
$op=empty($_GET['op'])?'':$_GET['op'];
$uid=$_SGLOBAL['supe_uid'];


if($id) {
	//读取日志
	$query = $_SGLOBAL['db']->query("SELECT bf.*, b.* FROM ".tname('reservation')." b 
		LEFT JOIN ".tname('reservationfield')." bf ON bf.reservationid=b.reservationid 
		WHERE b.reservationid='$id' ");
	$reservation = $_SGLOBAL['db']->fetch_array($query);
	//日志不存在
	if(empty($reservation)) {
		showmessage('view_to_info_did_not_exist');
	}

	//整理
	//$reservation['pic'] = mkpicurl($reservation);
	
	//处理视频标签
	/*include_once(S_ROOT.'./source/function_reservation.php');
	$reservation['message'] = blog_bbcode($reservation['message']);*/


	//评论
	$perpage = 10;
	$start = ($page-1)*$perpage;

	//检查开始数
	ckstart($start, $perpage);

	$count = $reservation['replynum'];
	
	$list = array();
	if($count) {
		$cid = empty($_GET['cid'])?0:intval($_GET['cid']);
		$csql = $cid?"cid='$cid' AND":'';

		$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('reservation_comment')." WHERE $csql reservationid='$id' ORDER BY dateline DESC LIMIT $start,$perpage");
		while ($value = $_SGLOBAL['db']->fetch_array($query)) {
			realname_set($value['authorid'], $value['author']);//实名
			$list[] = $value;
		}
	}
	//分页
	$multi = multi($count, $perpage, $page, "space.php?uid=$reservation[uid]&do=$do&id=$id");


	//访问统计
	//if($reservation['uid']!=$_SGLOBAL['supe_uid']) {
		$_SGLOBAL['db']->query("UPDATE ".tname('reservation')." SET viewnum=viewnum+1 WHERE reservationid='$reservation[reservationid]'");
		inserttable('log', array('id'=>$space['uid'], 'idtype'=>'uid'));//延迟更新
	//}

	//实名
	realname_get();
	include_once template("space_reservation_view");
	

}else {
	//分页
	$perpage = 5;
	$start = ($page-1)*$perpage;
	//检查开始数
	ckstart($start, $perpage);
	$theurl = "space.php?do=reservation";
	$wheresql=" WHERE uid='$uid'";
	
	//摘要截取
	$summarylen = 200;

	$list = array();
	$userlist = array();
	$count =  0;
	
	$count = $_SGLOBAL['db']->result($_SGLOBAL['db']->query("SELECT COUNT(*) FROM ".tname('reservation')."   $wheresql  ORDER BY dateline DESC"),0);	
	if($count) {
		$query=$_SGLOBAL['db']->query("SELECT * FROM ".tname('reservation')." WHERE uid='$uid' ORDER BY dateline DESC LIMIT $start,$perpage");	
		while ($value = $_SGLOBAL['db']->fetch_array($query)) {
				realname_set($value['uid'], $value['username']);
				$query1=$_SGLOBAL['db']->query("SELECT * FROM ".tname('reservationfield')." WHERE reservationid='$value[reservationid]'");
				$value1=$_SGLOBAL['db']->fetch_array($query1);
				$value['message'] = preg_replace("/(\<div\>|\<\/div\>|\s|\&nbsp\;|\<br\>|\<p\>|\<\/p\>|<img>)+/is", '', $value1['message']);
				$value['message'] = $value['friend']==4?'':getstr($value['message'], $summarylen, 0, 0, 0, 0, -1);
				//$value['pic'] = mkpicurl($value,1,0);
				$list[] = $value;
		}
	}
	//分页
	$multi = multi($count, $perpage, $page, $theurl);

	//实名
	realname_get();
	
	 //获取个人分类
	/* include_once(S_ROOT.'./source/function_cp.php');
	$classarr = $reservation['xiaoquidid']?getreservationarr($reservation['xiaoquid']):getreservationarr($space['xiaoquid']);
	*/
	include_once template("space_reservation_list");
	
}

?>