<?php
/*
	[UCenter Home] (C) 2007-2008 Comsenz Inc.
	$Id: space_menuset.php 13208 2009-08-20 06:31:35Z liguode $
*/

if(!defined('IN_UCHOME')) {
	exit('Access Denied');
}
if(empty($space['namestatus'])){
	showmessage("请先进行实名验证","cp.php?ac=profile");
}
$menusetid = empty($_GET['menusetid'])?0:intval($_GET['menusetid']);
if($_GET['op']=='delete'){
	updatetable('appset', array('appstatus' => '0','cheak' => '1'), array('num'=>$menusetid));
	showmessage("删除成功","space.php?do=menuset&view=me");
}
if($_GET['op']=='add'){
	updatetable('appset', array('appstatus' => '1','cheak' => '0'), array('num'=>$menusetid));
	showmessage("添加成功","space.php?do=menuset&view=me");
}
$minhot = $_SCONFIG['feedhotmin']<1?3:$_SCONFIG['feedhotmin'];

$page = empty($_GET['page'])?1:intval($_GET['page']);
if($page<1) $page=1;
$id = empty($_GET['id'])?0:intval($_GET['id']);
$classid = empty($_GET['classid'])?0:intval($_GET['classid']);

//±íÌ¬·ÖÀà
@include_once(S_ROOT.'./data/data_click.php');
$clicks = empty($_SGLOBAL['click']['menusetid'])?array():$_SGLOBAL['click']['menusetid'];

if($id) {
	//¶ÁÈ¡ÈÕÖ¾
	$query = $_SGLOBAL['db']->query("SELECT bf.*, b.* FROM ".tname('menuset')." b LEFT JOIN ".tname('menusetfield')." bf ON bf.menusetid=b.menusetid WHERE b.menusetid='$id' AND b.uid='$space[uid]'");
	$menuset = $_SGLOBAL['db']->fetch_array($query);
	//ÈÕÖ¾²»´æÔÚ
	if(empty($menuset)) {
		showmessage('view_to_info_did_not_exist');
	}
	//¼ì²éºÃÓÑÈ¨ÏÞ
	if(!ckfriend($menuset['uid'], $menuset['friend'], $menuset['target_ids'])) {
		//Ã»ÓÐÈ¨ÏÞ
		include template('space_privacy');
		exit();
	} elseif(!$space['self'] && $menuset['friend'] == 4) {
		//ÃÜÂëÊäÈëÎÊÌâ
		$cookiename = "view_pwd_menuset_$menuset[menusetid]";
		$cookievalue = empty($_SCOOKIE[$cookiename])?'':$_SCOOKIE[$cookiename];
		if($cookievalue != md5(md5($menuset['password']))) {
			$invalue = $menuset;
			include template('do_inputpwd');
			exit();
		}
	}

	//ÕûÀí
	$menuset['tag'] = empty($menuset['tag'])?array():unserialize($menuset['tag']);

	//´¦ÀíÊÓÆµ±êÇ©
	include_once(S_ROOT.'./source/function_menuset.php');
	$menuset['message'] = menuset_bbcode($menuset['message']);

	$otherlist = $newlist = array();

	//ÓÐÐ§ÆÚ
	if($_SCONFIG['uc_tagrelatedtime'] && ($_SGLOBAL['timestamp'] - $menuset['relatedtime'] > $_SCONFIG['uc_tagrelatedtime'])) {
		$menuset['related'] = array();
	}
	if($menuset['tag'] && empty($menuset['related'])) {
		@include_once(S_ROOT.'./data/data_tagtpl.php');

		$b_tagids = $b_tags = $menuset['related'] = array();
		$tag_count = -1;
		foreach ($menuset['tag'] as $key => $value) {
			$b_tags[] = $value;
			$b_tagids[] = $key;
			$tag_count++;
		}
		if(!empty($_SCONFIG['uc_tagrelated']) && $_SCONFIG['uc_status']) {
			if(!empty($_SGLOBAL['tagtpl']['limit'])) {
				include_once(S_ROOT.'./uc_client/client.php');
				$tag_index = mt_rand(0, $tag_count);
				$menuset['related'] = uc_tag_get($b_tags[$tag_index], $_SGLOBAL['tagtpl']['limit']);
			}
		} else {
			//×ÔÉíTAG
			$tag_menusetids = array();
			$query = $_SGLOBAL['db']->query("SELECT DISTINCT menusetid FROM ".tname('tagmenuset')." WHERE tagid IN (".simplode($b_tagids).") AND menusetid<>'$menuset[menusetid]' ORDER BY menusetid DESC LIMIT 0,10");
			while ($value = $_SGLOBAL['db']->fetch_array($query)) {
				$tag_menusetids[] = $value['menusetid'];
			}
			if($tag_menusetids) {
				$query = $_SGLOBAL['db']->query("SELECT uid,username,subject,menusetid FROM ".tname('menuset')." WHERE menusetid IN (".simplode($tag_menusetids).")");
				while ($value = $_SGLOBAL['db']->fetch_array($query)) {
					realname_set($value['uid'], $value['username']);//ÊµÃû
					$value['url'] = "space.php?uid=$value[uid]&do=menuset&id=$value[menusetid]";
					$menuset['related'][UC_APPID]['data'][] = $value;
				}
				$menuset['related'][UC_APPID]['type'] = 'UCHOME';
			}
		}
		if(!empty($menuset['related']) && is_array($menuset['related'])) {
			foreach ($menuset['related'] as $appid => $values) {
				if(!empty($values['data']) && $_SGLOBAL['tagtpl']['data'][$appid]['template']) {
					foreach ($values['data'] as $itemkey => $itemvalue) {
						if(!empty($itemvalue) && is_array($itemvalue)) {
							$searchs = $replaces = array();
							foreach (array_keys($itemvalue) as $key) {
								$searchs[] = '{'.$key.'}';
								$replaces[] = $itemvalue[$key];
							}
							$menuset['related'][$appid]['data'][$itemkey]['html'] = stripslashes(str_replace($searchs, $replaces, $_SGLOBAL['tagtpl']['data'][$appid]['template']));
						} else {
							unset($menuset['related'][$appid]['data'][$itemkey]);
						}
					}
				} else {
					$menuset['related'][$appid]['data'] = '';
				}
				if(empty($menuset['related'][$appid]['data'])) {
					unset($menuset['related'][$appid]);
				}
			}
		}
		updatetable('menusetfield', array('related'=>addslashes(serialize(sstripslashes($menuset['related']))), 'relatedtime'=>$_SGLOBAL['timestamp']), array('menusetid'=>$menuset['menusetid']));//¸üÐÂ
	} else {
		$menuset['related'] = empty($menuset['related'])?array():unserialize($menuset['related']);
	}

	//×÷ÕßµÄÆäËû×îÐÂÈÕÖ¾
	$otherlist = array();
	$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('menuset')." WHERE uid='$space[uid]' ORDER BY dateline DESC LIMIT 0,6");
	while ($value = $_SGLOBAL['db']->fetch_array($query)) {
		if($value['menusetid'] != $menuset['menusetid'] && empty($value['friend'])) {
			$otherlist[] = $value;
		}
	}

	//×îÐÂµÄÈÕÖ¾
	$newlist = array();
	$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('menuset')." WHERE hot>=3 ORDER BY dateline DESC LIMIT 0,6");
	while ($value = $_SGLOBAL['db']->fetch_array($query)) {
		if($value['menusetid'] != $menuset['menusetid'] && empty($value['friend'])) {
			realname_set($value['uid'], $value['username']);
			$newlist[] = $value;
		}
	}

	//ÆÀÂÛ
	$perpage = 30;
	$perpage = mob_perpage($perpage);
	
	$start = ($page-1)*$perpage;

	//¼ì²é¿ªÊ¼Êý
	ckstart($start, $perpage);

	$count = $menuset['replynum'];

	$list = array();
	if($count) {
		$cid = empty($_GET['cid'])?0:intval($_GET['cid']);
		$csql = $cid?"cid='$cid' AND":'';

		$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('comment')." WHERE $csql id='$id' AND idtype='menusetid' ORDER BY dateline LIMIT $start,$perpage");
		while ($value = $_SGLOBAL['db']->fetch_array($query)) {
			realname_set($value['authorid'], $value['author']);//ÊµÃû
			$list[] = $value;
		}
	}

	//·ÖÒ³
	$multi = multi($count, $perpage, $page, "space.php?uid=$menuset[uid]&do=$do&id=$id", '', 'content');

	//·ÃÎÊÍ³¼Æ
	if(!$space['self'] && $_SCOOKIE['view_menusetid'] != $menuset['menusetid']) {
		$_SGLOBAL['db']->query("UPDATE ".tname('menuset')." SET viewnum=viewnum+1 WHERE menusetid='$menuset[menusetid]'");
		inserttable('log', array('id'=>$space['uid'], 'idtype'=>'uid'));//ÑÓ³Ù¸üÐÂ
		ssetcookie('view_menusetid', $menuset['menusetid']);
	}

	//±íÌ¬
	$hash = md5($menuset['uid']."\t".$menuset['dateline']);
	$id = $menuset['menusetid'];
	$idtype = 'menusetid';

	foreach ($clicks as $key => $value) {
		$value['clicknum'] = $menuset["click_$key"];
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
	$topic = topic_get($menuset['topicid']);

	//ÊµÃû
	realname_get();

	$_TPL['css'] = 'menuset';
	include_once template("space_menuset_view");

} else {
	//·ÖÒ³
	$perpage = 10;
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
		$_GET['view'] = 'all';//Ä¬ÈÏÏÔÊ¾
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

		$count = $_SGLOBAL['db']->result($_SGLOBAL['db']->query("SELECT COUNT(*) FROM ".tname('clickuser')." c WHERE c.uid='$space[uid]' AND c.idtype='menusetid' $wheresql"),0);
		if($count) {
			$query = $_SGLOBAL['db']->query("SELECT b.*, bf.message, bf.target_ids, bf.magiccolor FROM ".tname('clickuser')." c
				LEFT JOIN ".tname('menuset')." b ON b.menusetid=c.id
				LEFT JOIN ".tname('menusetfield')." bf ON bf.menusetid=c.id
				WHERE c.uid='$space[uid]' AND c.idtype='menusetid' $wheresql
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

				$theurl = "space.php?uid=$space[uid]&do=menuset&view=all&orderby=$_GET[orderby]";
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

				$wheresql .= "1";
				$all_actives = array('all'=>' class="current"');
				$day_actives = array();
			}


		} else {
			
			if(empty($space['feedfriend']) || $classid) $_GET['view'] = 'me';
			
			if($_GET['view'] == 'me') {
				//²é¿´¸öÈËµÄ
				$wheresql = "bf.uid='$space[uid]'";
				$theurl = "space.php?uid=$space[uid]&do=$do&view=me";
				$actives = array('me'=>' class="active"');
				//ÈÕÖ¾·ÖÀà
				$query = $_SGLOBAL['db']->query("SELECT classid, classname FROM ".tname('class')." WHERE uid='$space[uid]'");
				while ($value = $_SGLOBAL['db']->fetch_array($query)) {
					$classarr[$value['classid']] = $value['classname'];
				}
			} else {
				$wheresql = "b.uid IN ($space[feedfriend])";
				$theurl = "space.php?uid=$space[uid]&do=$do&view=we";
				$f_index = '';
	
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

		if($_GET['view'] != 'me') {

		$count = $_SGLOBAL['db']->result($_SGLOBAL['db']->query("SELECT COUNT(*) FROM ".tname('menuset')." b WHERE $wheresql"),0);
		//¸üÐÂÍ³¼Æ
		if($wheresql == "b.uid='$space[uid]'" && $space['menusetnum'] != $count) {
			updatetable('space', array('menusetnum' => $count), array('uid'=>$space['uid']));
		}
		if($count) {
			$query = $_SGLOBAL['db']->query("SELECT bf.message, bf.target_ids, bf.magiccolor, b.* FROM ".tname('menuset')." b $f_index
				LEFT JOIN ".tname('menusetfield')." bf ON bf.menusetid=b.menusetid where b.style='2'
				ORDER BY $ordersql ASC LIMIT $start,$perpage");
		}
	}
			if($_GET['view'] == 'me') {

		$count = $_SGLOBAL['db']->result($_SGLOBAL['db']->query("SELECT COUNT(*) FROM ".tname('appset')." bf WHERE $wheresql"),0);
		//¸üÐÂÍ³¼Æ
		if($wheresql == "b.uid='$space[uid]'" && $space['menusetnum'] != $count) {
			updatetable('space', array('menusetnum' => $count), array('uid'=>$space['uid']));
		}
		if($count) {
			$query = $_SGLOBAL['db']->query("SELECT bf.*, b.* FROM ".tname('appset')." bf 
				LEFT JOIN ".tname('menuset')." b ON bf.num=b.menusetid
				WHERE $wheresql and bf.appstatus='1'
				ORDER BY $ordersql ASC LIMIT $start,$perpage");
		}
	}
}
if($_GET['view'] == 'me') {
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
				if($value['newname']){
				$value['subject']=$value['newname'];
				}
				$list[] = $value;
			} else {
				$pricount++;
			}
		}
	}
}
if($_GET['view'] != 'me') {
	if($count) {
		while ($value = $_SGLOBAL['db']->fetch_array($query)) {
			if(ckfriend($value['uid'], $value['friend'], $value['target_ids'])) {
				realname_set($value['uid'], $value['username']);
				if($value['friend'] == 4) {
					$value['message'] = $value['pic'] = '';
				} else {
						$value['message1'] = $value['message'];
					$value['message'] = getstr($value['message'], 20, 0, 0, 0, 0, -1);
				}
				if($value['pic']) $value['pic'] = pic_cover_get($value['pic'], $value['picflag']);
				//识别标签，只出现符合标签的应用
				$query2 = $_SGLOBAL['db']->query("SELECT * FROM ".tname('spacefield')." 
				WHERE uid='$space[uid]' ORDER BY uid  ASC LIMIT $start,$perpage");
				$value2=$_SGLOBAL['db']->fetch_array($query2);
				$a=$value2['business'];
				$wei=explode("，",$value['apptag']);
			if(in_array("$a", $wei)){
				$query1 = $_SGLOBAL['db']->query("SELECT bf.*, b.* FROM ".tname('appset')." bf 
				LEFT JOIN ".tname('menuset')." b ON bf.num=b.menusetid
				WHERE bf.uid='$space[uid]' and bf.num=$value[menusetid] and bf.appstatus='1'
				ORDER BY b.dateline ASC LIMIT $start,$perpage");
				$value1=$_SGLOBAL['db']->fetch_array($query1);
				$query2 = $_SGLOBAL['db']->query("SELECT bf.*, b.* FROM ".tname('appset')." bf 
				LEFT JOIN ".tname('menuset')." b ON bf.num=b.menusetid
				WHERE bf.uid='$space[uid]' and bf.num=$value[menusetid]
				ORDER BY b.dateline ASC LIMIT $start,$perpage");
				$value2=$_SGLOBAL['db']->fetch_array($query2);
				$value['zhong'] = $value2;
				if($value2['newname']){
				$value['subject']=$value2['newname'];
				}
				$list[] = $value;
			}
			} else {
				$pricount++;
			}
		}
	}
}
	//·ÖÒ³
	$multi = multi($count, $perpage, $page, $theurl);

	//ÊµÃû
	realname_get();
	//如果未购买，则隐藏侧边栏；
	$query4 = $_SGLOBAL['db']->query("SELECT * FROM ".tname('appset')." WHERE uid='$space[uid]' and appstatus='1'");
	$value4 = $_SGLOBAL['db']->fetch_array($query4);
	$zhong1=$value4;

	if($_POST){
		foreach($_POST as $p => $o){
	$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('appset')." WHERE num='$p' and uid=$_SGLOBAL[supe_uid]");
	$value = $_SGLOBAL['db']->fetch_array($query);
	if(empty($value)){
		$query2 = $_SGLOBAL['db']->query("SELECT * FROM ".tname('menuset')."  WHERE menusetid='$p'");
		$value2 = $_SGLOBAL['db']->fetch_array($query2);
		if($value2['money']){
		inserttable("appset", array('month'=>$o,'dateline1' => $_SGLOBAL['timestamp'],'orderid'=>$value2['menusetid'],'endtime'=> $_SGLOBAL['timestamp']+$o*2592000*12,'uid'=>$_SGLOBAL['supe_uid'],'num'=>$p));
		$showmessage='你所选择的应用包含付费应用，现在为你跳转到支付页面。';
		$showlink="space.php?do=showmenuset";	
		}else{
		inserttable("appset", array('month'=>'0','dateline1' => '0','endtime'=>'0','orderid'=>$value2['menusetid'],'uid'=>$_SGLOBAL['supe_uid'],'num'=>$p,'appstatus'=>'1'));	
		$showmessage1='订制成功。';
		$showlink1="space.php?do=menuset&view=me";
		}
	}else{
	$query2 = $_SGLOBAL['db']->query("SELECT bf.*, b.* FROM ".tname('appset')." bf 
				LEFT JOIN ".tname('menuset')." b ON bf.num=b.menusetid WHERE bf.num='$p' and bf.uid=$_SGLOBAL[supe_uid]");
	$value2 = $_SGLOBAL['db']->fetch_array($query2);
	if($value2['money']){
		if($value2['appstatus']=='0'){
			updatetable("appset", array('month'=>$value2['month']+$o,'endtime'=>$value2['dateline']+$value2['month']*2592000*12+$o*2592000*12),array('uid'=>$_SGLOBAL['supe_uid'],'num'=>$p));
			$showmessage='你所选择的应用包含付费应用，现在为你跳转到支付页面。';
			$showlink="space.php?do=showmenuset";
		}else{
			updatetable("appset", array('addmonth'=>$value2['addmonth']+$o),array('uid'=>$_SGLOBAL['supe_uid'],'num'=>$p));	
			$showmessage='你所选择的应用包含付费应用，现在为你跳转到支付页面。';
			$showlink="space.php?do=showmenuset";
		}
}else{
	updatetable("appset", array('month'=>'0','endtime'=>'0','cheak'=>'0'),array('uid'=>$_SGLOBAL['supe_uid'],'num'=>$p));
	updatetable("appset", array('appstatus'=>'1'),array('uid'=>$_SGLOBAL['supe_uid'],'num'=>$p));
	$showmessage1='订制成功。';
	$showlink1="space.php?do=menuset&view=me";
}
}
}
$query3 = $_SGLOBAL['db']->query("SELECT  SUM(money) as wei FROM ".tname('appset')." bf LEFT JOIN ".tname('menuset')." b ON bf.num=b.menusetid WHERE bf.uid=$_SGLOBAL[supe_uid]");
$value3 = $_SGLOBAL['db']->fetch_array($query3);

	if($value3['wei']){
	showmessage("你所选择的应用包含付费应用，现在为你跳转到支付页面。","space.php?do=showmenuset");
}else{
	include"./template/default/allcomplete.htm";
}
}
$query4 = $_SGLOBAL['db']->query("SELECT * FROM ".tname('appset')." WHERE uid='$space[uid]' and appstatus='1'");
$value4 = $_SGLOBAL['db']->fetch_array($query4);
$zhong1=$value4;
if(empty($zhong1)){
$query4 = $_SGLOBAL['db']->query("SELECT * FROM ".tname('weixin')." where cheakid='1' limit 0,1");
$newweixin = $_SGLOBAL['db']->fetch_array($query4);


}

	


	//删除过期的应用
	$query3 = $_SGLOBAL['db']->query("SELECT * FROM ".tname('appset')."");
	while($value3 = $_SGLOBAL['db']->fetch_array($query3)){
		if($value3['endtime']){
		if($value3['endtime']<$_SGLOBAL['timestamp']){
			$num=$value3['num'];
			$uid=$value3['uid'];
			$query = $_SGLOBAL['db']->query("delete FROM ".tname('appset')." WHERE num='$num' and uid='$uid'");
			$value = $_SGLOBAL['db']->fetch_array($query);

		}
	}
	}

	$_TPL['css'] = 'menuset';
	include_once template("space_highmenuset_list");
}

?>