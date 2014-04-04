<?php
/*
	[UCenter Home] (C) 2007-2008 Comsenz Inc.
	$Id: space_auction.php 13208 2009-08-20 06:31:35Z liguode $
*/

if(!defined('IN_UCHOME')) {
	exit('Access Denied');
}

//各模块小logo
$do=$_REQUEST['do'];
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

$page = empty($_REQUEST['page'])?1:intval($_REQUEST['page']);
if($page<1) $page=1;
$id = empty($_REQUEST['id'])?0:intval($_REQUEST['id']);
$classid = empty($_REQUEST['classid'])?0:intval($_REQUEST['classid']);

//±íÌ¬·ÖÀà
@include_once(S_ROOT.'./data/data_click.php');
$clicks = empty($_SGLOBAL['click']['auctionid'])?array():$_SGLOBAL['click']['auctionid'];

if($id) {
	$perpage = $_REQUEST['perpage'];
	$perpage = mob_perpage($perpage);
	
	$start = ($page-1)*$perpage;

	//¼ì²é¿ªÊ¼Êý
	ckstart($start, $perpage);
	//¶ÁÈ¡ÈÕÖ¾
	$query = $_SGLOBAL['db']->query("SELECT bf.*, b.* FROM ".tname('auction')." b LEFT JOIN ".tname('auctionfield')." bf ON bf.auctionid=b.auctionid WHERE b.auctionid='$id' AND b.uid='$space[uid]'");
	$auction = $_SGLOBAL['db']->fetch_array($query);
	$count1 = $_SGLOBAL['db']->result($_SGLOBAL['db']->query("SELECT COUNT(*) FROM ".tname('auctionbuy')."  WHERE gid='$_REQUEST[id]'"),0);
	$query1 = $_SGLOBAL['db']->query("SELECT * FROM ".tname('auctionbuy')."
		WHERE gid='$_REQUEST[id]' order by dateline DESC");
	while ($value1 = $_SGLOBAL['db']->fetch_array($query1)) {
		$auctionbuy[] = $value1;
	}
	capi_showmessage_by_data("rest_success", 0, array('auction'=>$auction,'auctionbuy'=>$auctionbuy,'count1'=>$count1, 'count'=>count($auction)));
	
	//ÈÕÖ¾²»´æÔÚ
	if(empty($auction)) {
		showmessage('view_to_info_did_not_exist');
	}

	//¼ì²éºÃÓÑÈ¨ÏÞ
	if(!ckfriend($auction['uid'], $auction['friend'], $auction['target_ids'])) {
		//Ã»ÓÐÈ¨ÏÞ
		include template('space_privacy');
		exit();
	} elseif(!$space['self'] && $auction['friend'] == 4) {
		//ÃÜÂëÊäÈëÎÊÌâ
		$cookiename = "view_pwd_auction_$auction[auctionid]";
		$cookievalue = empty($_SCOOKIE[$cookiename])?'':$_SCOOKIE[$cookiename];
		if($cookievalue != md5(md5($auction['password']))) {
			$invalue = $auction;
			include template('do_inputpwd');
			exit();
		}
	}

	//ÕûÀí
	$auction['tag'] = empty($auction['tag'])?array():unserialize($auction['tag']);

	//´¦ÀíÊÓÆµ±êÇ©
	include_once(S_ROOT.'./source/function_auction.php');

	$auction['message'] = auction_bbcode($auction['message']);

	$otherlist = $newlist = array();

	//ÓÐÐ§ÆÚ
	if($_SCONFIG['uc_tagrelatedtime'] && ($_SGLOBAL['timestamp'] - $auction['relatedtime'] > $_SCONFIG['uc_tagrelatedtime'])) {
		$auction['related'] = array();
	}
	
	if($auction['tag'] && empty($auction['related'])) {
		@include_once(S_ROOT.'./data/data_tagtpl.php');

		$b_tagids = $b_tags = $auction['related'] = array();
		$tag_count = -1;
		foreach ($auction['tag'] as $key => $value) {
			$b_tags[] = $value;
			$b_tagids[] = $key;
			$tag_count++;
		}
		if(!empty($_SCONFIG['uc_tagrelated']) && $_SCONFIG['uc_status']) {
			if(!empty($_SGLOBAL['tagtpl']['limit'])) {
				include_once(S_ROOT.'./uc_client/client.php');
				$tag_index = mt_rand(0, $tag_count);
				$auction['related'] = uc_tag_get($b_tags[$tag_index], $_SGLOBAL['tagtpl']['limit']);
			}
		} else {

			//×ÔÉíTAG
			$tag_auctionids = array();
			$query = $_SGLOBAL['db']->query("SELECT DISTINCT auctionid FROM ".tname('tagauction')." WHERE tagid IN (".simplode($b_tagids).") AND auctionid<>'$auction[auctionid]' ORDER BY auctionid DESC LIMIT 0,10");
			while ($value = $_SGLOBAL['db']->fetch_array($query)) {
				$tag_auctionids[] = $value['auctionid'];
			}
			if($tag_auctionids) {
				$query = $_SGLOBAL['db']->query("SELECT uid,username,subject,auctionid FROM ".tname('auction')." WHERE auctionid IN (".simplode($tag_auctionids).")");
				while ($value = $_SGLOBAL['db']->fetch_array($query)) {
					realname_set($value['uid'], $value['username']);//ÊµÃû
					$value['url'] = "space.php?uid=$value[uid]&do=auction&id=$value[auctionid]";
					$auction['related'][UC_APPID]['data'][] = $value;
				}
				$auction['related'][UC_APPID]['type'] = 'UCHOME';
			}
		}
		if(!empty($auction['related']) && is_array($auction['related'])) {
			foreach ($auction['related'] as $appid => $values) {
				if(!empty($values['data']) && $_SGLOBAL['tagtpl']['data'][$appid]['template']) {
					foreach ($values['data'] as $itemkey => $itemvalue) {
						if(!empty($itemvalue) && is_array($itemvalue)) {
							$searchs = $replaces = array();
							foreach (array_keys($itemvalue) as $key) {
								$searchs[] = '{'.$key.'}';
								$replaces[] = $itemvalue[$key];
							}
							$auction['related'][$appid]['data'][$itemkey]['html'] = stripslashes(str_replace($searchs, $replaces, $_SGLOBAL['tagtpl']['data'][$appid]['template']));
						} else {
							unset($auction['related'][$appid]['data'][$itemkey]);
						}
					}
				} else {
					$auction['related'][$appid]['data'] = '';
				}
				if(empty($auction['related'][$appid]['data'])) {
					unset($auction['related'][$appid]);
				}
			}
		}
		updatetable('auctionfield', array('related'=>addslashes(serialize(sstripslashes($auction['related']))), 'relatedtime'=>$_SGLOBAL['timestamp']), array('auctionid'=>$auction['auctionid']));//¸üÐÂ
	} else {
		$auction['related'] = empty($auction['related'])?array():unserialize($auction['related']);
	}

	//×÷ÕßµÄÆäËû×îÐÂÈÕÖ¾
	$otherlist = array();
	$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('auction')." WHERE uid='$space[uid]' ORDER BY dateline DESC LIMIT 0,6");
	while ($value = $_SGLOBAL['db']->fetch_array($query)) {
		if($value['auctionid'] != $auction['auctionid'] && empty($value['friend'])) {
			$otherlist[] = $value;
		}
	}

	//×îÐÂµÄÈÕÖ¾
	$newlist = array();
	$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('auction')." WHERE hot>=3 ORDER BY dateline DESC LIMIT 0,6");
	while ($value = $_SGLOBAL['db']->fetch_array($query)) {
		if($value['auctionid'] != $auction['auctionid'] && empty($value['friend'])) {
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

	$count = $auction['replynum'];

	$list = array();
	if($count) {
		$cid = empty($_REQUEST['cid'])?0:intval($_REQUEST['cid']);
		$csql = $cid?"cid='$cid' AND":'';

		$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('comment')." WHERE $csql id='$id' AND idtype='auctionid' ORDER BY dateline LIMIT $start,$perpage");
		while ($value = $_SGLOBAL['db']->fetch_array($query)) {
			realname_set($value['authorid'], $value['author']);//ÊµÃû
			$list[] = $value;
		}
	}
	capi_showmessage_by_data("rest_success", 0, array('auction'=>$list,'count'=>$count));
	//·ÖÒ³
	$multi = multi($count, $perpage, $page, "space.php?uid=$auction[uid]&do=$do&id=$id", '', 'content');

	//·ÃÎÊÍ³¼Æ
	if(!$space['self'] && $_SCOOKIE['view_auctionid'] != $auction['auctionid']) {
		$_SGLOBAL['db']->query("UPDATE ".tname('auction')." SET viewnum=viewnum+1 WHERE auctionid='$auction[auctionid]'");
		inserttable('log', array('id'=>$space['uid'], 'idtype'=>'uid'));//ÑÓ³Ù¸üÐÂ
		ssetcookie('view_auctionid', $auction['auctionid']);
	}

	//±íÌ¬
	$hash = md5($auction['uid']."\t".$auction['dateline']);
	$id = $auction['auctionid'];
	$idtype = 'auctionid';

	foreach ($clicks as $key => $value) {
		$value['clicknum'] = $auction["click_$key"];
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
	$topic = topic_get($auction['topicid']);

	//ÊµÃû
	realname_get();
	$time=$auction['starttime']*1000-$_SGLOBAL['timestamp']*1000;
	$time1=$auction['endtime']*1000-$_SGLOBAL['timestamp']*1000;
	$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('auctionbuy')."
		WHERE uid='$space[uid]' AND typeid='$id' order by money DESC");
	$auctionbuy = $_SGLOBAL['db']->fetch_array($query);
	$_TPL['css'] = 'auction';
	include_once template("space_auction_view");

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

	if(empty($_REQUEST['view']) && ($space['friendnum']<$_SCONFIG['showallfriendnum'])) {
		$_REQUEST['view'] = 'me';//Ä¬ÈÏÏÔÊ¾
	}

	//´¦Àí²éÑ¯
	$f_index = '';
	if($_REQUEST['view'] == 'click') {
		//²È¹ýµÄÈÕÖ¾
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

		$count = $_SGLOBAL['db']->result($_SGLOBAL['db']->query("SELECT COUNT(*) FROM ".tname('clickuser')." c WHERE c.uid='$space[uid]' AND c.idtype='auctionid' $wheresql"),0);
		if($count) {
			$query = $_SGLOBAL['db']->query("SELECT b.*, bf.message, bf.target_ids, bf.magiccolor FROM ".tname('clickuser')." c
				LEFT JOIN ".tname('auction')." b ON b.auctionid=c.id
				LEFT JOIN ".tname('auctionfield')." bf ON bf.auctionid=c.id
				WHERE c.uid='$space[uid]' AND c.idtype='auctionid' $wheresql
				ORDER BY c.dateline DESC LIMIT $start,$perpage");
		}
	} else {
		
		if($_REQUEST['view'] == 'all') {
			//´ó¼ÒµÄÈÕÖ¾
			$wheresql = '1';

			$actives = array('all'=>' class="active"');

			//ÅÅÐò
			$orderarr = array('dateline','replynum','viewnum','hot');
			foreach ($clicks as $value) {
				$orderarr[] = "click_$value[clickid]";
			}
			if(!in_array($_REQUEST['orderby'], $orderarr)) $_REQUEST['orderby'] = '';

			//Ê±¼ä
			$_REQUEST['day'] = intval($_REQUEST['day']);
			$_REQUEST['hotday'] = 7;

			if($_REQUEST['orderby']) {
				$ordersql = 'b.'.$_REQUEST['orderby'];

				$theurl = "space.php?uid=$space[uid]&do=auction&view=all&orderby=$_REQUEST[orderby]";
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
				//²é¿´¸öÈËµÄ
				$wheresql = "b.uid='$space[uid]'";
				$theurl = "space.php?uid=$space[uid]&do=$do&view=me";
				$actives = array('me'=>' class="active"');
				//ÈÕÖ¾·ÖÀà
				$query = $_SGLOBAL['db']->query("SELECT classid, classname FROM ".tname('classauction')." WHERE uid='$space[uid]' or uid='0'");
				while ($value = $_SGLOBAL['db']->fetch_array($query)) {
					$classarr[$value['classid']] = $value['classname'];
				}
			} else {
				$wheresql = "b.uid IN ($space[feedfriend])";
				$theurl = "space.php?uid=$space[uid]&do=$do&view=we";
				$f_index = 'USE INDEX(dateline)';
	
				$fuid_actives = array();
	
				//²é¿´Ö¸¶¨ºÃÓÑµÄ
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
		$_REQUEST['friend'] = intval($_REQUEST['friend']);
		if($_REQUEST['friend']) {
			$wheresql .= " AND b.friend='$_REQUEST[friend]'";
			$theurl .= "&friend=$_REQUEST[friend]";
		}

		//ËÑË÷
		if($searchkey = stripsearchkey($_REQUEST['searchkey'])) {
			$wheresql .= " AND b.subject LIKE '%$searchkey%'";
			$theurl .= "&searchkey=$_REQUEST[searchkey]";
			cksearch($theurl);
		}

		$count = $_SGLOBAL['db']->result($_SGLOBAL['db']->query("SELECT COUNT(*) FROM ".tname('auction')." b WHERE $wheresql"),0);
		//¸üÐÂÍ³¼Æ
		if($wheresql == "b.uid='$space[uid]'" && $space['auctionnum'] != $count) {
			updatetable('space', array('auctionnum' => $count), array('uid'=>$space['uid']));
		}
		if($count) {
			$query = $_SGLOBAL['db']->query("SELECT bf.message, bf.target_ids, bf.magiccolor, b.* FROM ".tname('auction')." b $f_index
				LEFT JOIN ".tname('auctionfield')." bf ON bf.auctionid=b.auctionid
				WHERE b.uid='$_REQUEST[uid]' and b.endtime>$_SGLOBAL[timestamp]
				ORDER BY $ordersql DESC LIMIT $start,$_REQUEST[perpage]");
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
				$time=$value['starttime']*1000-$_SGLOBAL['timestamp']*1000;
				$time1=$value['endtime']*1000-$_SGLOBAL['timestamp']*1000;
				if($time>0){
					$value['time']="$time";
				}
				if($time<0&&$time1>0){
					$value['time1']="$time1";
				}
				if($time1<0){
					$value['time2']='1';
				}
				$list[] = $value;
			} else {
				$pricount++;
			}
		}
	}

	//·ÖÒ³
	$multi = multi($count, $perpage, $page, $theurl);

	//ÊµÃû
	realname_get();
	capi_showmessage_by_data("rest_success", 0, array('auction'=>$list,'count'=>$count));
	$_TPL['css'] = 'auction';
	include_once template("space_auction_list");
}

?>