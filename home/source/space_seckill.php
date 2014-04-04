<?php
/*
	[UCenter Home] (C) 2007-2008 Comsenz Inc.
	$Id: space_seckill.php 13208 2009-08-20 06:31:35Z liguode $
*/

if(!defined('IN_UCHOME')) {
	exit('Access Denied');
}

//各模块小logo
$do=$_GET['do'];
$query4 = $_SGLOBAL['db']->query("SELECT * FROM ".tname('menuset')." WHERE english='$do'");
$value4 = $_SGLOBAL['db']->fetch_array($query4);
$wei1=$value4;

//页面标题
$newname1 = $_SGLOBAL['db']->query("SELECT bf.*, b.* FROM ".tname('appset')." bf $f_index
				LEFT JOIN ".tname('menuset')." b ON bf.num=b.menusetid
				WHERE bf.uid='$_SGLOBAL[supe_uid]' and b.english='$do' and bf.appstatus='1'
				ORDER BY bf.orderid ASC ");
$newname = $_SGLOBAL['db']->fetch_array($newname1);
if($newname['newname']){
	$newname['subject']=$newname['newname'];
}

//判断是否购买
/*$query5 = $_SGLOBAL['db']->query("SELECT bf.*, b.* FROM ".tname('appset')." bf $f_index
				LEFT JOIN ".tname('menuset')." b ON bf.num=b.menusetid
				WHERE bf.uid='$_SGLOBAL[supe_uid]' and bf.appstatus='1' and b.english='$do'
				ORDER BY b.dateline ASC");
$value5 = $_SGLOBAL['db']->fetch_array($query5);
$zhong2=$value5;
if(empty($zhong2)){
	showmessage("未购买应用，请购买后再使用！","space.php?do=menuset&view=all");
}*/

$minhot = $_SCONFIG['feedhotmin']<1?3:$_SCONFIG['feedhotmin'];

$page = empty($_GET['page'])?1:intval($_GET['page']);
if($page<1) $page=1;
$id = empty($_GET['id'])?0:intval($_GET['id']);
$classid = empty($_GET['classid'])?0:intval($_GET['classid']);

//±íÌ¬·ÖÀà
@include_once(S_ROOT.'./data/data_click.php');
$clicks = empty($_SGLOBAL['click']['seckillid'])?array():$_SGLOBAL['click']['seckillid'];

if($id) {

	//¶ÁÈ¡ÈÕÖ¾
	$query = $_SGLOBAL['db']->query("SELECT bf.*, b.* FROM ".tname('seckill')." b LEFT JOIN ".tname('seckillfield')." bf ON bf.seckillid=b.seckillid WHERE b.seckillid='$id' AND b.uid='$space[uid]'");
	$seckill = $_SGLOBAL['db']->fetch_array($query);
	//查看有多少个人参与秒杀
	$seckillsum=$_SGLOBAL['db']->result($_SGLOBAL['db']->query("SELECT COUNT(*) FROM ".tname('seckillbuy')."  WHERE gid='$id' "),0);
	//ÈÕÖ¾²»´æÔÚ
	if(empty($seckill)) {
		showmessage('view_to_info_did_not_exist');
	}
	$seckill['sum']=$seckillsum;
	//¼ì²éºÃÓÑÈ¨ÏÞ
	if(!ckfriend($seckill['uid'], $seckill['friend'], $seckill['target_ids'])) {
		//Ã»ÓÐÈ¨ÏÞ
		include template('space_privacy');
		exit();
	} elseif(!$space['self'] && $seckill['friend'] == 4) {
		//ÃÜÂëÊäÈëÎÊÌâ
		$cookiename = "view_pwd_seckill_$seckill[seckillid]";
		$cookievalue = empty($_SCOOKIE[$cookiename])?'':$_SCOOKIE[$cookiename];
		if($cookievalue != md5(md5($seckill['password']))) {
			$invalue = $seckill;
			include template('do_inputpwd');
			exit();
		}
	}

	//ÕûÀí
	$seckill['tag'] = empty($seckill['tag'])?array():unserialize($seckill['tag']);

	//´¦ÀíÊÓÆµ±êÇ©
	include_once(S_ROOT.'./source/function_seckill.php');

	$seckill['message'] = seckill_bbcode($seckill['message']);

	$otherlist = $newlist = array();

	//ÓÐÐ§ÆÚ
	if($_SCONFIG['uc_tagrelatedtime'] && ($_SGLOBAL['timestamp'] - $seckill['relatedtime'] > $_SCONFIG['uc_tagrelatedtime'])) {
		$seckill['related'] = array();
	}
	
	if($seckill['tag'] && empty($seckill['related'])) {
		@include_once(S_ROOT.'./data/data_tagtpl.php');

		$b_tagids = $b_tags = $seckill['related'] = array();
		$tag_count = -1;
		foreach ($seckill['tag'] as $key => $value) {
			$b_tags[] = $value;
			$b_tagids[] = $key;
			$tag_count++;
		}
		if(!empty($_SCONFIG['uc_tagrelated']) && $_SCONFIG['uc_status']) {
			if(!empty($_SGLOBAL['tagtpl']['limit'])) {
				include_once(S_ROOT.'./uc_client/client.php');
				$tag_index = mt_rand(0, $tag_count);
				$seckill['related'] = uc_tag_get($b_tags[$tag_index], $_SGLOBAL['tagtpl']['limit']);
			}
		} else {

			//×ÔÉíTAG
			$tag_seckillids = array();
			$query = $_SGLOBAL['db']->query("SELECT DISTINCT seckillid FROM ".tname('tagseckill')." WHERE tagid IN (".simplode($b_tagids).") AND seckillid<>'$seckill[seckillid]' ORDER BY seckillid DESC LIMIT 0,10");
			while ($value = $_SGLOBAL['db']->fetch_array($query)) {
				$tag_seckillids[] = $value['seckillid'];
			}
			if($tag_seckillids) {
				$query = $_SGLOBAL['db']->query("SELECT uid,username,subject,seckillid FROM ".tname('seckill')." WHERE seckillid IN (".simplode($tag_seckillids).")");
				while ($value = $_SGLOBAL['db']->fetch_array($query)) {
					realname_set($value['uid'], $value['username']);//ÊµÃû
					$value['url'] = "space.php?uid=$value[uid]&do=seckill&id=$value[seckillid]";
					$seckill['related'][UC_APPID]['data'][] = $value;
				}
				$seckill['related'][UC_APPID]['type'] = 'UCHOME';
			}
		}
		if(!empty($seckill['related']) && is_array($seckill['related'])) {
			foreach ($seckill['related'] as $appid => $values) {
				if(!empty($values['data']) && $_SGLOBAL['tagtpl']['data'][$appid]['template']) {
					foreach ($values['data'] as $itemkey => $itemvalue) {
						if(!empty($itemvalue) && is_array($itemvalue)) {
							$searchs = $replaces = array();
							foreach (array_keys($itemvalue) as $key) {
								$searchs[] = '{'.$key.'}';
								$replaces[] = $itemvalue[$key];
							}
							$seckill['related'][$appid]['data'][$itemkey]['html'] = stripslashes(str_replace($searchs, $replaces, $_SGLOBAL['tagtpl']['data'][$appid]['template']));
						} else {
							unset($seckill['related'][$appid]['data'][$itemkey]);
						}
					}
				} else {
					$seckill['related'][$appid]['data'] = '';
				}
				if(empty($seckill['related'][$appid]['data'])) {
					unset($seckill['related'][$appid]);
				}
			}
		}
		updatetable('seckillfield', array('related'=>addslashes(serialize(sstripslashes($seckill['related']))), 'relatedtime'=>$_SGLOBAL['timestamp']), array('seckillid'=>$seckill['seckillid']));//¸üÐÂ
	} else {
		$seckill['related'] = empty($seckill['related'])?array():unserialize($seckill['related']);
	}

	//×÷ÕßµÄÆäËû×îÐÂÈÕÖ¾
	$otherlist = array();
	$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('seckill')." WHERE uid='$space[uid]' ORDER BY dateline DESC LIMIT 0,6");
	while ($value = $_SGLOBAL['db']->fetch_array($query)) {
		if($value['seckillid'] != $seckill['seckillid'] && empty($value['friend'])) {
			$otherlist[] = $value;
		}
	}

	//×îÐÂµÄÈÕÖ¾
	$newlist = array();
	$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('seckill')." WHERE hot>=3 ORDER BY dateline DESC LIMIT 0,6");
	while ($value = $_SGLOBAL['db']->fetch_array($query)) {
		if($value['seckillid'] != $seckill['seckillid'] && empty($value['friend'])) {
			realname_set($value['uid'], $value['username']);
			$newlist[] = $value;
		}
	}

	//ÆÀÂÛ
	$perpage = 5;
	$perpage = mob_perpage($perpage);
	
	$start = ($page-1)*$perpage;

	//¼ì²é¿ªÊ¼Êý
	ckstart($start, $perpage);

	$count = $seckill['replynum'];

	$list = array();
	if($count) {
		$cid = empty($_GET['cid'])?0:intval($_GET['cid']);
		$csql = $cid?"cid='$cid' AND":'';

		$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('comment')." WHERE $csql id='$id' AND idtype='seckillid' ORDER BY dateline LIMIT $start,$perpage");
		while ($value = $_SGLOBAL['db']->fetch_array($query)) {
			realname_set($value['authorid'], $value['author']);//ÊµÃû
			$list[] = $value;
		}
	}
	$query1 = $_SGLOBAL['db']->query("SELECT * FROM ".tname('seckillbuy')." WHERE gid='$id' AND viewuid='$space[uid]' ORDER BY id DESC LIMIT $start,$perpage");
		while ($value1 = $_SGLOBAL['db']->fetch_array($query1)) {
					$seckillbuy1[] = $value1;
		}

	//·ÖÒ³
	$multi = multi($count, $perpage, $page, "space.php?uid=$seckill[uid]&do=$do&id=$id", '', 'content');

	//·ÃÎÊÍ³¼Æ
	if(!$space['self'] && $_SCOOKIE['view_seckillid'] != $seckill['seckillid']) {
		$_SGLOBAL['db']->query("UPDATE ".tname('seckill')." SET viewnum=viewnum+1 WHERE seckillid='$seckill[seckillid]'");
		inserttable('log', array('id'=>$space['uid'], 'idtype'=>'uid'));//ÑÓ³Ù¸üÐÂ
		ssetcookie('view_seckillid', $seckill['seckillid']);
	}

	//±íÌ¬
	$hash = md5($seckill['uid']."\t".$seckill['dateline']);
	$id = $seckill['seckillid'];
	$idtype = 'seckillid';

	foreach ($clicks as $key => $value) {
		$value['clicknum'] = $seckill["click_$key"];
		$value['classid'] = mt_rand(1, 4);
		if($value['clicknum'] > $maxclicknum) $maxclicknum = $value['clicknum'];
		$clicks[$key] = $value;
	}

	//µãÆÀ
	$clickuserlist = array();
	$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('clickuser')."
		WHERE id='$id' AND idtype='$idtype'
		ORDER BY dateline DESC
		LIMIT 0,18");
	while ($value = $_SGLOBAL['db']->fetch_array($query)) {
		realname_set($value['uid'], $value['username']);//ÊµÃû
		$value['clickname'] = $clicks[$value['clickid']]['name'];
		$clickuserlist[] = $value;
	}

	//ÈÈµã
	$topic = topic_get($seckill['topicid']);

	//ÊµÃû
	realname_get();
	$time=$seckill['starttime0']*1000-$_SGLOBAL['timestamp']*1000;
	$time1=$seckill['endtime']*1000-$_SGLOBAL['timestamp']*1000;
	$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('seckillbuy')."
		WHERE viewuid='$space[uid]' AND gid='$id' order by id DESC");
	$seckillbuy = $_SGLOBAL['db']->fetch_array($query);
	$_TPL['css'] = 'seckill';
	include_once template("space_seckill_view");

} else {
	//·ÖÒ³
	$perpage = 5;
	$perpage = mob_perpage($perpage);
	
	$start = ($page-1)*$perpage;

	//¼ì²é¿ªÊ¼Êý
	ckstart($start, $perpage);

	//ÕªÒª½ØÈ¡
	$summarylen = 300;

	$classarr = array();
	$list = array();
	$userlist = array();
	$count = $pricount = 0;

	$ordersql = 'b.dateline';

	if(empty($_GET['view']) && ($space['friendnum']<$_SCONFIG['showallfriendnum'])) {
		$_GET['view'] = 'me';//Ä¬ÈÏÏÔÊ¾
	}

	//´¦Àí²éÑ¯
	$f_index = '';
	if($_GET['view'] == 'click') {
		//²È¹ýµÄÈÕÖ¾
		$theurl = "space.php?uid=$space[uid]&do=$do&view=click";
		$actives = array('click'=>' class="active"');

		$clickid = intval($_GET['clickid']);
		if($clickid) {
			$theurl .= "&clickid=$clickid";
			$wheresql = " AND c.clickid='$clickid'";
			$click_actives = array($clickid => ' class="current"');
		} else {
			$wheresql = '';
			$click_actives = array('all' => ' class="current"');
		}

		$count = $_SGLOBAL['db']->result($_SGLOBAL['db']->query("SELECT COUNT(*) FROM ".tname('clickuser')." c WHERE c.uid='$space[uid]' AND c.idtype='seckillid' $wheresql"),0);
		if($count) {
			$query = $_SGLOBAL['db']->query("SELECT b.*, bf.message, bf.target_ids, bf.magiccolor FROM ".tname('clickuser')." c
				LEFT JOIN ".tname('seckill')." b ON b.seckillid=c.id
				LEFT JOIN ".tname('seckillfield')." bf ON bf.seckillid=c.id
				WHERE c.uid='$space[uid]' AND c.idtype='seckillid' $wheresql
				ORDER BY c.dateline DESC LIMIT $start,$perpage");
		}
	} else {
		
		if($_GET['view'] == 'all') {
			//´ó¼ÒµÄÈÕÖ¾
			$wheresql = '1';

			$actives = array('all'=>' class="active"');

			//ÅÅÐò
			$orderarr = array('dateline','replynum','viewnum','hot');
			foreach ($clicks as $value) {
				$orderarr[] = "click_$value[clickid]";
			}
			if(!in_array($_GET['orderby'], $orderarr)) $_GET['orderby'] = '';

			//Ê±¼ä
			$_GET['day'] = intval($_GET['day']);
			$_GET['hotday'] = 7;

			if($_GET['orderby']) {
				$ordersql = 'b.'.$_GET['orderby'];

				$theurl = "space.php?uid=$space[uid]&do=seckill&view=all&orderby=$_GET[orderby]";
				$all_actives = array($_GET['orderby']=>' class="current"');

				if($_GET['day']) {
					$_GET['hotday'] = $_GET['day'];
					$daytime = $_SGLOBAL['timestamp'] - $_GET['day']*3600*24;
					$wheresql .= " AND b.dateline>='$daytime'";

					$theurl .= "&day=$_GET[day]";
					$day_actives = array($_GET['day']=>' class="active"');
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
			
			if(empty($space['feedfriend']) || $classid) $_GET['view'] = 'me';
			
			if($_GET['view'] == 'me') {
				//²é¿´¸öÈËµÄ
				$wheresql = "b.uid='$space[uid]'";
				$theurl = "space.php?uid=$space[uid]&do=$do&view=me";
				$actives = array('me'=>' class="active"');
				//ÈÕÖ¾·ÖÀà
				$query = $_SGLOBAL['db']->query("SELECT classid, classname FROM ".tname('classseckill')." WHERE uid='$space[uid]' or uid='0'");
				while ($value = $_SGLOBAL['db']->fetch_array($query)) {
					$classarr[$value['classid']] = $value['classname'];
				}
			} else {
				$wheresql = "b.uid IN ($space[uid])";
				$theurl = "space.php?uid=$space[uid]&do=$do&view=we";
				$f_index = 'USE INDEX(dateline)';
	
				$fuid_actives = array();
	
				//²é¿´Ö¸¶¨ºÃÓÑµÄ
				$fusername = trim($_GET['fusername']);
				$fuid = intval($_GET['fuid']);
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
	
				//ºÃÓÑÁÐ±í
				$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('friend')." WHERE uid='$space[uid]' AND status='1' ORDER BY num DESC, dateline DESC LIMIT 0,500");
				while ($value = $_SGLOBAL['db']->fetch_array($query)) {
					realname_set($value['fuid'], $value['fusername']);
					$userlist[] = $value;
				}
			}
		}

		//·ÖÀà
		if($classid) {
			$wheresql .= " AND b.classid='$classid'";
			$theurl .= "&classid=$classid";
		}

		//ÉèÖÃÈ¨ÏÞ
		$_GET['friend'] = intval($_GET['friend']);
		if($_GET['friend']) {
			$wheresql .= " AND b.friend='$_GET[friend]'";
			$theurl .= "&friend=$_GET[friend]";
		}

		//ËÑË÷
		if($searchkey = stripsearchkey($_GET['searchkey'])) {
			$wheresql .= " AND b.subject LIKE '%$searchkey%'";
			$theurl .= "&searchkey=$_GET[searchkey]";
			cksearch($theurl);
		}

		$count = $_SGLOBAL['db']->result($_SGLOBAL['db']->query("SELECT COUNT(*) FROM ".tname('seckill')." b WHERE $wheresql"),0);
		//¸üÐÂÍ³¼Æ
		if($wheresql == "b.uid='$space[uid]'" && $space['seckillnum'] != $count) {
			updatetable('space', array('seckillnum' => $count), array('uid'=>$space['uid']));
		}
		if($count) {
			$query = $_SGLOBAL['db']->query("SELECT bf.message, bf.target_ids, bf.magiccolor, b.* FROM ".tname('seckill')." b $f_index
				LEFT JOIN ".tname('seckillfield')." bf ON bf.seckillid=b.seckillid
				WHERE $wheresql
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
					$value['message'] = getstr($value['message'], 210, 0, 0, 0, 0, -1);
				}
				if($value['pic']) $value['pic'] = pic_cover_get($value['pic'], $value['picflag']);
				$list[] = $value;
			} else {
				$pricount++;
			}
		}
	}
	//showmessage($count);
	//·ÖÒ³
	$multi = multi($count, $perpage, $page, $theurl);

	//ÊµÃû
	realname_get();

	$_TPL['css'] = 'seckill';
	include_once template("space_seckill_list");
}

?>