<?php
/*
	[UCenter Home] (C) 2007-2008 Comsenz Inc.
	$Id: space_development.php 13208 2009-08-20 06:31:35Z liguode $
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
$query5 = $_SGLOBAL['db']->query("SELECT bf.*, b.* FROM ".tname('appset')." bf $f_index
				LEFT JOIN ".tname('menuset')." b ON bf.num=b.menusetid
				WHERE bf.uid='$_SGLOBAL[supe_uid]' and bf.appstatus='1' and b.english='$do'
				ORDER BY b.dateline ASC");
$value5 = $_SGLOBAL['db']->fetch_array($query5);
$zhong2=$value5;
if(empty($zhong2)){
	showmessage("未购买应用，请购买后再使用！","space.php?do=menuset&view=all");
}

$minhot = $_SCONFIG['feedhotmin']<1?3:$_SCONFIG['feedhotmin'];

$page = empty($_GET['page'])?1:intval($_GET['page']);
if($page<1) $page=1;
$id = empty($_GET['id'])?0:intval($_GET['id']);
$classid = empty($_GET['classid'])?0:intval($_GET['classid']);

//±íÌ¬·ÖÀà
@include_once(S_ROOT.'./data/data_click.php');
$clicks = empty($_SGLOBAL['click']['developmentid'])?array():$_SGLOBAL['click']['developmentid'];

if($id) {

	//¶ÁÈ¡ÈÕÖ¾
	$query = $_SGLOBAL['db']->query("SELECT bf.*, b.* FROM ".tname('development')." b LEFT JOIN ".tname('developmentfield')." bf ON bf.developmentid=b.developmentid WHERE b.developmentid='$id' AND b.uid='$space[uid]'");
	$development = $_SGLOBAL['db']->fetch_array($query);
	//ÈÕÖ¾²»´æÔÚ
	if(empty($development)) {
		showmessage('view_to_info_did_not_exist');
	}

	//¼ì²éºÃÓÑÈ¨ÏÞ
	if(!ckfriend($development['uid'], $development['friend'], $development['target_ids'])) {
		//Ã»ÓÐÈ¨ÏÞ
		include template('space_privacy');
		exit();
	} elseif(!$space['self'] && $development['friend'] == 4) {
		//ÃÜÂëÊäÈëÎÊÌâ
		$cookiename = "view_pwd_development_$development[developmentid]";
		$cookievalue = empty($_SCOOKIE[$cookiename])?'':$_SCOOKIE[$cookiename];
		if($cookievalue != md5(md5($development['password']))) {
			$invalue = $development;
			include template('do_inputpwd');
			exit();
		}
	}

	//ÕûÀí
	$development['tag'] = empty($development['tag'])?array():unserialize($development['tag']);

	//´¦ÀíÊÓÆµ±êÇ©
	include_once(S_ROOT.'./source/function_development.php');

	$development['message'] = development_bbcode($development['message']);

	$otherlist = $newlist = array();

	//ÓÐÐ§ÆÚ
	if($_SCONFIG['uc_tagrelatedtime'] && ($_SGLOBAL['timestamp'] - $development['relatedtime'] > $_SCONFIG['uc_tagrelatedtime'])) {
		$development['related'] = array();
	}
	if($development['tag'] && empty($development['related'])) {
		@include_once(S_ROOT.'./data/data_tagtpl.php');

		$b_tagids = $b_tags = $development['related'] = array();
		$tag_count = -1;
		foreach ($development['tag'] as $key => $value) {
			$b_tags[] = $value;
			$b_tagids[] = $key;
			$tag_count++;
		}
		if(!empty($_SCONFIG['uc_tagrelated']) && $_SCONFIG['uc_status']) {
			if(!empty($_SGLOBAL['tagtpl']['limit'])) {
				include_once(S_ROOT.'./uc_client/client.php');
				$tag_index = mt_rand(0, $tag_count);
				$development['related'] = uc_tag_get($b_tags[$tag_index], $_SGLOBAL['tagtpl']['limit']);
			}
		} else {
			//×ÔÉíTAG
			$tag_developmentids = array();
			$query = $_SGLOBAL['db']->query("SELECT DISTINCT developmentid FROM ".tname('tagdevelopment')." WHERE tagid IN (".simplode($b_tagids).") AND developmentid<>'$development[developmentid]' ORDER BY developmentid DESC LIMIT 0,10");
			while ($value = $_SGLOBAL['db']->fetch_array($query)) {
				$tag_developmentids[] = $value['developmentid'];
			}
			if($tag_developmentids) {
				$query = $_SGLOBAL['db']->query("SELECT uid,username,subject,developmentid FROM ".tname('development')." WHERE developmentid IN (".simplode($tag_developmentids).")");
				while ($value = $_SGLOBAL['db']->fetch_array($query)) {
					realname_set($value['uid'], $value['username']);//ÊµÃû
					$value['url'] = "space.php?uid=$value[uid]&do=development&id=$value[developmentid]";
					$development['related'][UC_APPID]['data'][] = $value;
				}
				$development['related'][UC_APPID]['type'] = 'UCHOME';
			}
		}
		if(!empty($development['related']) && is_array($development['related'])) {
			foreach ($development['related'] as $appid => $values) {
				if(!empty($values['data']) && $_SGLOBAL['tagtpl']['data'][$appid]['template']) {
					foreach ($values['data'] as $itemkey => $itemvalue) {
						if(!empty($itemvalue) && is_array($itemvalue)) {
							$searchs = $replaces = array();
							foreach (array_keys($itemvalue) as $key) {
								$searchs[] = '{'.$key.'}';
								$replaces[] = $itemvalue[$key];
							}
							$development['related'][$appid]['data'][$itemkey]['html'] = stripslashes(str_replace($searchs, $replaces, $_SGLOBAL['tagtpl']['data'][$appid]['template']));
						} else {
							unset($development['related'][$appid]['data'][$itemkey]);
						}
					}
				} else {
					$development['related'][$appid]['data'] = '';
				}
				if(empty($development['related'][$appid]['data'])) {
					unset($development['related'][$appid]);
				}
			}
		}
		updatetable('developmentfield', array('related'=>addslashes(serialize(sstripslashes($development['related']))), 'relatedtime'=>$_SGLOBAL['timestamp']), array('developmentid'=>$development['developmentid']));//¸üÐÂ
	} else {
		$development['related'] = empty($development['related'])?array():unserialize($development['related']);
	}

	//×÷ÕßµÄÆäËû×îÐÂÈÕÖ¾
	$otherlist = array();
	$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('development')." WHERE uid='$space[uid]' ORDER BY dateline DESC LIMIT 0,6");
	while ($value = $_SGLOBAL['db']->fetch_array($query)) {
		if($value['developmentid'] != $development['developmentid'] && empty($value['friend'])) {
			$otherlist[] = $value;
		}
	}

	//×îÐÂµÄÈÕÖ¾
	$newlist = array();
	$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('development')." WHERE hot>=3 ORDER BY dateline DESC LIMIT 0,6");
	while ($value = $_SGLOBAL['db']->fetch_array($query)) {
		if($value['developmentid'] != $development['developmentid'] && empty($value['friend'])) {
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

	$count = $development['replynum'];

	$list = array();
	if($count) {
		$cid = empty($_GET['cid'])?0:intval($_GET['cid']);
		$csql = $cid?"cid='$cid' AND":'';

		$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('comment')." WHERE $csql id='$id' AND idtype='developmentid' ORDER BY dateline LIMIT $start,$perpage");
		while ($value = $_SGLOBAL['db']->fetch_array($query)) {
			realname_set($value['authorid'], $value['author']);//ÊµÃû
			$list[] = $value;
		}
	}

	//·ÖÒ³
	$multi = multi($count, $perpage, $page, "space.php?uid=$development[uid]&do=$do&id=$id", '', 'content');

	//·ÃÎÊÍ³¼Æ
	if(!$space['self'] && $_SCOOKIE['view_developmentid'] != $development['developmentid']) {
		$_SGLOBAL['db']->query("UPDATE ".tname('development')." SET viewnum=viewnum+1 WHERE developmentid='$development[developmentid]'");
		inserttable('log', array('id'=>$space['uid'], 'idtype'=>'uid'));//ÑÓ³Ù¸üÐÂ
		ssetcookie('view_developmentid', $development['developmentid']);
	}

	//±íÌ¬
	$hash = md5($development['uid']."\t".$development['dateline']);
	$id = $development['developmentid'];
	$idtype = 'developmentid';

	foreach ($clicks as $key => $value) {
		$value['clicknum'] = $development["click_$key"];
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
	$topic = topic_get($development['topicid']);

	//ÊµÃû
	realname_get();

	$_TPL['css'] = 'development';
	include_once template("space_development_view");

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

		$count = $_SGLOBAL['db']->result($_SGLOBAL['db']->query("SELECT COUNT(*) FROM ".tname('clickuser')." c WHERE c.uid='$space[uid]' AND c.idtype='developmentid' $wheresql"),0);
		if($count) {
			$query = $_SGLOBAL['db']->query("SELECT b.*, bf.message, bf.target_ids, bf.magiccolor FROM ".tname('clickuser')." c
				LEFT JOIN ".tname('development')." b ON b.developmentid=c.id
				LEFT JOIN ".tname('developmentfield')." bf ON bf.developmentid=c.id
				WHERE c.uid='$space[uid]' AND c.idtype='developmentid' $wheresql
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

				$theurl = "space.php?uid=$space[uid]&do=development&view=all&orderby=$_GET[orderby]";
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
				$query = $_SGLOBAL['db']->query("SELECT classid, classname FROM ".tname('classdevelopment')." WHERE uid='$space[uid]' or uid='0'");
				while ($value = $_SGLOBAL['db']->fetch_array($query)) {
					$classarr[$value['classid']] = $value['classname'];
				}
			} else {
				$wheresql = "b.uid IN ($space[feedfriend])";
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

		$count = $_SGLOBAL['db']->result($_SGLOBAL['db']->query("SELECT COUNT(*) FROM ".tname('development')." b WHERE $wheresql"),0);
		//¸üÐÂÍ³¼Æ
		if($wheresql == "b.uid='$space[uid]'" && $space['developmentnum'] != $count) {
			updatetable('space', array('developmentnum' => $count), array('uid'=>$space['uid']));
		}
		if($count) {
			$query = $_SGLOBAL['db']->query("SELECT bf.message, bf.target_ids, bf.magiccolor, b.* FROM ".tname('development')." b $f_index
				LEFT JOIN ".tname('developmentfield')." bf ON bf.developmentid=b.developmentid
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

	//·ÖÒ³
	$multi = multi($count, $perpage, $page, $theurl);

	//ÊµÃû
	realname_get();

	$_TPL['css'] = 'development';
	include_once template("space_development_list");
}

?>