<?php
/*
	[UCenter Home] (C) 2007-2008 Comsenz Inc.
	$Id: space_job.php 13208 2009-08-20 06:31:35Z liguode $
*/

if(!defined('IN_UCHOME')) {
	exit('Access Denied');
}

$minhot = $_SCONFIG['feedhotmin']<1?3:$_SCONFIG['feedhotmin'];

$page = empty($_REQUEST['page'])?1:intval($_REQUEST['page']);
if($page<1) $page=1;
$id = empty($_REQUEST['id'])?0:intval($_REQUEST['id']);
$classid = empty($_REQUEST['classid'])?0:intval($_REQUEST['classid']);

//表态分类
@include_once(S_ROOT.'./data/data_click.php');
$clicks = empty($_SGLOBAL['click']['jobid'])?array():$_SGLOBAL['click']['jobid'];

if($id) {

	//读取日志
	$query = $_SGLOBAL['db']->query("SELECT bf.*, b.* FROM ".tname('job')." b LEFT JOIN ".tname('jobfield')." bf ON bf.jobid=b.jobid WHERE b.jobid='$id' AND b.uid='$space[uid]'");
	$job = $_SGLOBAL['db']->fetch_array($query);
	$job["message"] = capi_fhtml($job["message"]);
	capi_showmessage_by_data("rest_success", 0, array('job'=>$job, 'count'=>count($job)));
	//日志不存在
	if(empty($job)) {
		capi_showmessage_by_data('view_to_info_did_not_exist');
	}

	//检查好友权限
	if(!ckfriend($job['uid'], $job['friend'], $job['target_ids'])) {
		//没有权限
		include template('space_privacy');
		exit();
	} elseif(!$space['self'] && $job['friend'] == 4) {
		//密码输入问题
		$cookiename = "view_pwd_job_$job[jobid]";
		$cookievalue = empty($_SCOOKIE[$cookiename])?'':$_SCOOKIE[$cookiename];
		if($cookievalue != md5(md5($job['password']))) {
			$invalue = $job;
			include template('do_inputpwd');
			exit();
		}
	}

	//整理
	$job['tag'] = empty($job['tag'])?array():unserialize($job['tag']);

	//处理视频标签
	include_once(S_ROOT.'./source/function_job.php');

	$job['message'] = job_bbcode($job['message']);

	$otherlist = $newlist = array();

	//有效期
	if($_SCONFIG['uc_tagrelatedtime'] && ($_SGLOBAL['timestamp'] - $job['relatedtime'] > $_SCONFIG['uc_tagrelatedtime'])) {
		$job['related'] = array();
	}
	if($job['tag'] && empty($job['related'])) {
		@include_once(S_ROOT.'./data/data_tagtpl.php');

		$b_tagids = $b_tags = $job['related'] = array();
		$tag_count = -1;
		foreach ($job['tag'] as $key => $value) {
			$b_tags[] = $value;
			$b_tagids[] = $key;
			$tag_count++;
		}
		if(!empty($_SCONFIG['uc_tagrelated']) && $_SCONFIG['uc_status']) {
			if(!empty($_SGLOBAL['tagtpl']['limit'])) {
				include_once(S_ROOT.'./uc_client/client.php');
				$tag_index = mt_rand(0, $tag_count);
				$job['related'] = uc_tag_get($b_tags[$tag_index], $_SGLOBAL['tagtpl']['limit']);
			}
		} else {
			//自身TAG
			$tag_jobids = array();
			$query = $_SGLOBAL['db']->query("SELECT DISTINCT jobid FROM ".tname('tagjob')." WHERE tagid IN (".simplode($b_tagids).") AND jobid<>'$job[jobid]' ORDER BY jobid DESC LIMIT 0,10");
			while ($value = $_SGLOBAL['db']->fetch_array($query)) {
				$tag_jobids[] = $value['jobid'];
			}
			if($tag_jobids) {
				$query = $_SGLOBAL['db']->query("SELECT uid,username,subject,jobid FROM ".tname('job')." WHERE jobid IN (".simplode($tag_jobids).")");
				while ($value = $_SGLOBAL['db']->fetch_array($query)) {
					realname_set($value['uid'], $value['username']);//实名
					$value['url'] = "space.php?uid=$value[uid]&do=job&id=$value[jobid]";
					$job['related'][UC_APPID]['data'][] = $value;
				}
				$job['related'][UC_APPID]['type'] = 'UCHOME';
			}
		}
		if(!empty($job['related']) && is_array($job['related'])) {
			foreach ($job['related'] as $appid => $values) {
				if(!empty($values['data']) && $_SGLOBAL['tagtpl']['data'][$appid]['template']) {
					foreach ($values['data'] as $itemkey => $itemvalue) {
						if(!empty($itemvalue) && is_array($itemvalue)) {
							$searchs = $replaces = array();
							foreach (array_keys($itemvalue) as $key) {
								$searchs[] = '{'.$key.'}';
								$replaces[] = $itemvalue[$key];
							}
							$job['related'][$appid]['data'][$itemkey]['html'] = stripslashes(str_replace($searchs, $replaces, $_SGLOBAL['tagtpl']['data'][$appid]['template']));
						} else {
							unset($job['related'][$appid]['data'][$itemkey]);
						}
					}
				} else {
					$job['related'][$appid]['data'] = '';
				}
				if(empty($job['related'][$appid]['data'])) {
					unset($job['related'][$appid]);
				}
			}
		}
		updatetable('jobfield', array('related'=>addslashes(serialize(sstripslashes($job['related']))), 'relatedtime'=>$_SGLOBAL['timestamp']), array('jobid'=>$job['jobid']));//更新
	} else {
		$job['related'] = empty($job['related'])?array():unserialize($job['related']);
	}

	//作者的其他最新日志
	$otherlist = array();
	$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('job')." WHERE uid='$space[uid]' ORDER BY dateline DESC LIMIT 0,6");
	while ($value = $_SGLOBAL['db']->fetch_array($query)) {
		if($value['jobid'] != $job['jobid'] && empty($value['friend'])) {
			$otherlist[] = $value;
		}
	}

	//最新的日志
	$newlist = array();
	$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('job')." WHERE hot>=3 ORDER BY dateline DESC LIMIT 0,6");
	while ($value = $_SGLOBAL['db']->fetch_array($query)) {
		if($value['jobid'] != $job['jobid'] && empty($value['friend'])) {
			realname_set($value['uid'], $value['username']);
			$newlist[] = $value;
		}
	}

	//评论
	$perpage = 30;
	$perpage = mob_perpage($perpage);
	
	$start = ($page-1)*$perpage;

	//检查开始数
	ckstart($start, $perpage);

	$count = $job['replynum'];

	$list = array();
	if($count) {
		$cid = empty($_REQUEST['cid'])?0:intval($_REQUEST['cid']);
		$csql = $cid?"cid='$cid' AND":'';

		$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('comment')." WHERE $csql id='$id' AND idtype='jobid' ORDER BY dateline LIMIT $start,$perpage");
		while ($value = $_SGLOBAL['db']->fetch_array($query)) {
			realname_set($value['authorid'], $value['author']);//实名
			$list[] = $value;
		}
	}

	//分页
	$multi = multi($count, $perpage, $page, "space.php?uid=$job[uid]&do=$do&id=$id", '', 'content');

	//访问统计
	if(!$space['self'] && $_SCOOKIE['view_jobid'] != $job['jobid']) {
		$_SGLOBAL['db']->query("UPDATE ".tname('job')." SET viewnum=viewnum+1 WHERE jobid='$job[jobid]'");
		inserttable('log', array('id'=>$space['uid'], 'idtype'=>'uid'));//延迟更新
		ssetcookie('view_jobid', $job['jobid']);
	}

	//表态
	$hash = md5($job['uid']."\t".$job['dateline']);
	$id = $job['jobid'];
	$idtype = 'jobid';

	foreach ($clicks as $key => $value) {
		$value['clicknum'] = $job["click_$key"];
		$value['classid'] = mt_rand(1, 4);
		if($value['clicknum'] > $maxclicknum) $maxclicknum = $value['clicknum'];
		$clicks[$key] = $value;
	}

	//点评
	$clickuserlist = array();
	$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('clickuser')."
		WHERE id='$id' AND idtype='$idtype'
		ORDER BY dateline DESC
		LIMIT 0,18");
	while ($value = $_SGLOBAL['db']->fetch_array($query)) {
		realname_set($value['uid'], $value['username']);//实名
		$value['clickname'] = $clicks[$value['clickid']]['name'];
		$clickuserlist[] = $value;
	}

	//热点
	$topic = topic_get($job['topicid']);

	//实名
	realname_get();

	$_TPL['css'] = 'job';
	include_once template("space_job_view");

} else {
	//分页
	$perpage = 10;
	$perpage = mob_perpage($perpage);
	
	$start = ($page-1)*$perpage;

	//检查开始数
	ckstart($start, $perpage);

	//摘要截取
	$summarylen = 300;

	$classarr = array();
	$list = array();
	$userlist = array();
	$count = $pricount = 0;

	$ordersql = 'b.dateline';

	if(empty($_REQUEST['view']) && ($space['friendnum']<$_SCONFIG['showallfriendnum'])) {
		$_REQUEST['view'] = 'me';//默认显示
	}

	//处理查询
	$f_index = '';
	if($_REQUEST['view'] == 'click') {
		//踩过的日志
		$theurl = "space.php?uid=$space[uid]&do=$do&view=click";
		$actives = array('click'=>' class="active"');

		$clickid = intval($_REQUEST['clickid']);
		if($clickid) {
			$theurl .= "&clickid=$clickid";
			$wheresql = " AND c.clickid='$clickid'";
			$click_actives = array($clickid => ' class="current"');
		} else {
			$wheresql = '';
			$click_actives = array('all' => ' class="current"');
		}

		$count = $_SGLOBAL['db']->result($_SGLOBAL['db']->query("SELECT COUNT(*) FROM ".tname('clickuser')." c WHERE c.uid='$space[uid]' AND c.idtype='jobid' $wheresql"),0);
		if($count) {
			$query = $_SGLOBAL['db']->query("SELECT b.*, bf.message, bf.target_ids, bf.magiccolor FROM ".tname('clickuser')." c
				LEFT JOIN ".tname('job')." b ON b.jobid=c.id
				LEFT JOIN ".tname('jobfield')." bf ON bf.jobid=c.id
				WHERE c.uid='$space[uid]' AND c.idtype='jobid' $wheresql
				ORDER BY c.dateline DESC LIMIT $start,$perpage");
		}
	} else {
		
		if($_REQUEST['view'] == 'all') {
			//大家的日志
			$wheresql = '1';

			$actives = array('all'=>' class="active"');

			//排序
			$orderarr = array('dateline','replynum','viewnum','hot');
			foreach ($clicks as $value) {
				$orderarr[] = "click_$value[clickid]";
			}
			if(!in_array($_REQUEST['orderby'], $orderarr)) $_REQUEST['orderby'] = '';

			//时间
			$_REQUEST['day'] = intval($_REQUEST['day']);
			$_REQUEST['hotday'] = 7;

			if($_REQUEST['orderby']) {
				$ordersql = 'b.'.$_REQUEST['orderby'];

				$theurl = "space.php?uid=$space[uid]&do=job&view=all&orderby=$_REQUEST[orderby]";
				$all_actives = array($_REQUEST['orderby']=>' class="current"');

				if($_REQUEST['day']) {
					$_REQUEST['hotday'] = $_REQUEST['day'];
					$daytime = $_SGLOBAL['timestamp'] - $_REQUEST['day']*3600*24;
					$wheresql .= " AND b.dateline>='$daytime'";

					$theurl .= "&day=$_REQUEST[day]";
					$day_actives = array($_REQUEST['day']=>' class="active"');
				} else {
					$day_actives = array(0=>' class="active"');
				}
			} else {

				$theurl = "space.php?uid=$space[uid]&do=$do&view=all";

				$wheresql .= " AND b.hot>='$minhot'";
				$all_actives = array('all'=>' class="current"');
				$day_actives = array();
			}


		} else {
			
			if(empty($space['feedfriend']) || $classid) $_REQUEST['view'] = 'me';
			
			if($_REQUEST['view'] == 'me') {
				//查看个人的
				$wheresql = "b.uid='$space[uid]'";
				$theurl = "space.php?uid=$space[uid]&do=$do&view=me";
				$actives = array('me'=>' class="active"');
				//日志分类
				$query = $_SGLOBAL['db']->query("SELECT classid, classname FROM ".tname('classjob')." WHERE uid='$space[uid]' or uid='0'");
				while ($value = $_SGLOBAL['db']->fetch_array($query)) {
					$classarr[$value['classid']] = $value['classname'];
				}
			} else {
				$wheresql = "b.uid IN ($space[feedfriend])";
				$theurl = "space.php?uid=$space[uid]&do=$do&view=we";
				$f_index = 'USE INDEX(dateline)';
	
				$fuid_actives = array();
	
				//查看指定好友的
				$fusername = trim($_REQUEST['fusername']);
				$fuid = intval($_REQUEST['fuid']);
				if($fusername) {
					$fuid = getuid($fusername);
				}
				if($fuid && in_array($fuid, $space['friends'])) {
					$wheresql = "b.uid = '$fuid'";
					$theurl = "space.php?uid=$space[uid]&do=$do&view=we&fuid=$fuid";
					$f_index = '';
					$fuid_actives = array($fuid=>' selected');
				}
	
				$actives = array('we'=>' class="active"');
	
				//好友列表
				$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('friend')." WHERE uid='$space[uid]' AND status='1' ORDER BY num DESC, dateline DESC LIMIT 0,500");
				while ($value = $_SGLOBAL['db']->fetch_array($query)) {
					realname_set($value['fuid'], $value['fusername']);
					$userlist[] = $value;
				}
			}
		}

		//分类
		if($classid) {
			$wheresql .= " AND b.classid='$classid'";
			$theurl .= "&classid=$classid";
		}

		//设置权限
		$_REQUEST['friend'] = intval($_REQUEST['friend']);
		if($_REQUEST['friend']) {
			$wheresql .= " AND b.friend='$_REQUEST[friend]'";
			$theurl .= "&friend=$_REQUEST[friend]";
		}

		//搜索
		if($searchkey = stripsearchkey($_REQUEST['searchkey'])) {
			$wheresql .= " AND b.subject LIKE '%$searchkey%'";
			$theurl .= "&searchkey=$_REQUEST[searchkey]";
			cksearch($theurl);
		}

		$count = $_SGLOBAL['db']->result($_SGLOBAL['db']->query("SELECT COUNT(*) FROM ".tname('job')." b WHERE b.uid='$_REQUEST[uid]'"),0);
		//更新统计
		if($wheresql == "b.uid='$space[uid]'" && $space['jobnum'] != $count) {
			updatetable('space', array('jobnum' => $count), array('uid'=>$space['uid']));
		}
		if($count) {
			$query = $_SGLOBAL['db']->query("SELECT bf.message, bf.target_ids, bf.magiccolor, b.* FROM ".tname('job')." b $f_index
				LEFT JOIN ".tname('jobfield')." bf ON bf.jobid=b.jobid
				WHERE b.uid='$_REQUEST[uid]'
				ORDER BY $ordersql DESC LIMIT $start,$perpage");
		}
	}

	if($count) {
		while ($value = $_SGLOBAL['db']->fetch_array($query)) {
			if(ckfriend($value['uid'], $value['friend'], $value['target_ids'])) {
				realname_set($value['uid'], $value['username']);
				if($value['friend'] == 4) {
					$value['message'] = $value['pic'] = '';
				} else {
					$value['message'] = getstr($value['message'], $summarylen, 0, 0, 0, 0, -1);
				}
				if($value['pic']) $value['pic'] = pic_cover_get($value['pic'], $value['picflag']);
				$list[] = $value;
			} else {
				$pricount++;
			}
		}
	}

	//分页
	$multi = multi($count, $perpage, $page, $theurl);
	capi_showmessage_by_data("rest_success", 0, array('job'=>$list, 'count'=>$count));
	//实名
	realname_get();

	$_TPL['css'] = 'job';
	include_once template("space_job_list");
}

?>