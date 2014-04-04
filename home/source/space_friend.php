<?php
/*
	[UCenter Home] (C) 2007-2008 Comsenz Inc.
	$Id: space_friend.php 12880 2009-07-24 07:20:24Z liguode $
*/

if(!defined('IN_UCHOME')) {
	exit('Access Denied');
}
if($_SGLOBAL['supe_uid']) {
if ($space['profilestatus']=='0'&&$space['namestatus']=='0'){
		showmessage('enter_the_space', 'cp.php?ac=profile', 0);
	}
	if($space['profilestatus']!='0'&&$space['namestatus']=='0'&&$space['alreadyreg']=='0'){
		showmessage('enter_the_space', './template/default/post_ok.htm', 0);
	}
	if($space['profilestatus']=='0'&&$space['namestatus']=='1'&&empty($zhong1)){
		showmessage('enter_the_space', 'space.php?do=menuset&view=me', 0);
	}

}else{
	showmessage('未登录', 'index.php', 0);
}

if($_POST['friendreply']){
	require_once './wx/wx_common.php';
	require_once('./wx/Weixin.class.php');
	$uid=$_POST['uid'];
	$fakeid=$_POST['fakeid'];
	$message=$_POST['message'];
	$d = get_obj_by_xiaoquid($uid);
	$info = $d->sendWXSingleMsg($fakeid,$message);	
	if($info){
		showmessage("回复成功","space.php?do=friend");
	}
}	
$count2 = $_SGLOBAL['db']->result($_SGLOBAL['db']->query("SELECT COUNT(*) FROM ".tname('space')." where recomendman='$_SGLOBAL[supe_uid]'"), 0);
//·ÖÒ³
$perpage = 24;
$perpage = mob_perpage($perpage);

$list = $ols = $fuids = array();
$count = 0;
$page = empty($_GET['page'])?0:intval($_GET['page']);
if($page<1) $page = 1;
$start = ($page-1)*$perpage;

//¼ì²é¿ªÊ¼Êý
ckstart($start, $perpage);

if($_GET['view'] == 'online') {
	$theurl = "space.php?uid=$space[uid]&do=friend&view=online";
	$actives = array('me'=>' class="active"');

	$wheresql = '';
	if($_GET['type']=='near') {
		$theurl = "space.php?uid=$space[uid]&do=friend&view=online&type=near";
		$wheresql = " WHERE main.ip='".getonlineip(1)."'";
	} elseif($_GET['type']=='friend' && $space['feedfriend']) {
		$theurl = "space.php?uid=$space[uid]&do=friend&view=online&type=friend";
		$wheresql = " WHERE main.uid IN ($space[feedfriend])";
	} else {
		$_GET['type']=='all';
		$theurl = "space.php?uid=$space[uid]&do=friend&view=online&type=all";
		$wheresql = ' WHERE 1';
	}

	$count = $_SGLOBAL['db']->result($_SGLOBAL['db']->query("SELECT COUNT(*) FROM ".tname('session')." main $wheresql"), 0);
	if($count) {
		$query = $_SGLOBAL['db']->query("SELECT f.resideprovince, f.residecity, f.sex, f.note, f.spacenote, main.*
			FROM ".tname('session')." main
			LEFT JOIN ".tname('spacefield')." f ON f.uid=main.uid
			$wheresql
			ORDER BY main.lastactivity DESC
			LIMIT $start,$perpage");
		while ($value = $_SGLOBAL['db']->fetch_array($query)) {			
			if($value['magichidden']) {
				$count = $count - 1;
				continue;
			}
			if($_GET['type']=='near') {
				if($value['uid'] == $space['uid']) {
					$count = $count-1;
					continue;
				}
			}
			realname_set($value['uid'], $value['username']);
			$value['p'] = rawurlencode($value['resideprovince']);
			$value['c'] = rawurlencode($value['residecity']);
			$value['isfriend'] = ($value['uid']==$space['uid'] || ($space['friends'] && in_array($value['uid'], $space['friends'])))?1:0;
			$ols[$value['uid']] = $value['lastactivity'];			
			$value['note'] = getstr($value['note'], 35, 0, 0, 0, 0, -1);
			$list[$value['uid']] = $value;
		}
	}
	$multi = multi($count, $perpage, $page, $theurl);

} elseif($_GET['view'] == 'visitor' || $_GET['view'] == 'trace') {

	$theurl = "space.php?uid=$space[uid]&do=friend&view=$_GET[view]";
	$actives = array('me'=>' class="active"');

	if($_GET['view'] == 'visitor') {//·Ã¿Í
		$count = $_SGLOBAL['db']->result($_SGLOBAL['db']->query("SELECT COUNT(*) FROM ".tname('visitor')." main WHERE main.uid='$space[uid]'"), 0);
		$query = $_SGLOBAL['db']->query("SELECT f.resideprovince, f.residecity, f.note, f.spacenote, f.sex, main.vuid AS uid, main.vusername AS username, main.dateline
			FROM ".tname('visitor')." main
			LEFT JOIN ".tname('spacefield')." f ON f.uid=main.vuid
			WHERE main.uid='$space[uid]'
			ORDER BY main.dateline DESC
			LIMIT $start,$perpage");
	} else {//×ã¼£
		$count = $_SGLOBAL['db']->result($_SGLOBAL['db']->query("SELECT COUNT(*) FROM ".tname('visitor')." main WHERE main.vuid='$space[uid]'"), 0);
		$query = $_SGLOBAL['db']->query("SELECT s.username, s.name, s.namestatus, s.groupid, f.resideprovince, f.residecity, f.note, f.spacenote, f.sex, main.uid AS uid, main.dateline
			FROM ".tname('visitor')." main
			LEFT JOIN ".tname('space')." s ON s.uid=main.uid
			LEFT JOIN ".tname('spacefield')." f ON f.uid=main.uid
			WHERE main.vuid='$space[uid]'
			ORDER BY main.dateline DESC
			LIMIT $start,$perpage");
	}
	if($count) {
		while ($value = $_SGLOBAL['db']->fetch_array($query)) {
			realname_set($value['uid'], $value['username'], $value['name'], $value['namestatus']);
			$value['p'] = rawurlencode($value['resideprovince']);
			$value['c'] = rawurlencode($value['residecity']);
			$value['isfriend'] = ($value['uid']==$space['uid'] || ($space['friends'] && in_array($value['uid'], $space['friends'])))?1:0;
			$fuids[] = $value['uid'];
			$value['note'] = getstr($value['note'], 28, 0, 0, 0, 0, -1);
			$list[$value['uid']] = $value;
		}
	}
	$multi = multi($count, $perpage, $page, $theurl);

}elseif($_GET['view'] == 'lastlogin') {

	$theurl = "space.php?uid=$space[uid]&do=friend&view=$_GET[view]";
	$actives = array('me'=>' class="active"');

	if($space['friendnum']) {
		if($wheresql) {
			$count = $_SGLOBAL['db']->result($_SGLOBAL['db']->query("SELECT COUNT(*) FROM ".tname('friend')." main WHERE main.uid='$space[uid]' AND main.status='1' $wheresql"), 0);
		} else {
			$count = $space['friendnum'];
		}
	if($count) {
		$query = $_SGLOBAL['db']->query("SELECT s.*, f.resideprovince, f.residecity, f.note, f.spacenote, f.sex, main.gid, main.num
				FROM ".tname('friend')." main
				LEFT JOIN ".tname('space')." s ON s.uid=main.fuid
				LEFT JOIN ".tname('spacefield')." f ON f.uid=main.fuid
				WHERE main.uid='$space[uid]' AND main.status='1' $wheresql
				ORDER BY s.lastlogin DESC
				LIMIT $start,$perpage");
		while ($value = $_SGLOBAL['db']->fetch_array($query)) {
				$query1 = $_SGLOBAL['db']->query("SELECT * FROM ".tname('feed')." where uid='$value[uid]' ORDER BY dateline DESC");
				while($value1 = $_SGLOBAL['db']->fetch_array($query1)){
				realname_set($value['uid'], $value['username'], $value['name'], $value['namestatus']);

				$value['feed'][]=mkfeed($value1);
				}
				realname_set($value['uid'], $value['username'], $value['name'], $value['namestatus']);
				$value['p'] = rawurlencode($value['resideprovince']);
				$value['c'] = rawurlencode($value['residecity']);
				$value['group'] = $groups[$value['gid']];
				$value['isfriend'] = 1;
				$fuids[] = $value['uid'];
				$value['note'] = getstr($value['note'], 28, 0, 0, 0, 0, -1);
				$list[$value['uid']] = $value;
			}
		}
	}
	$multi = multi($count, $perpage, $page, $theurl);

}elseif($_GET['view'] == 'free'){
	$query = $_SGLOBAL['db']->query("SELECT s.* FROM  ".tname('space')." s 
				LEFT JOIN ".tname('spacefield')." f ON s.uid=f.uid
				WHERE s.recomendman='$_SGLOBAL[supe_uid]' and s.buystatus='0'
				ORDER BY s.lastlogin DESC
				LIMIT $start,$perpage");
	while ($value = $_SGLOBAL['db']->fetch_array($query)) {
				realname_set($value['uid'], $value['username'], $value['name'], $value['namestatus']);
				$value['p'] = rawurlencode($value['resideprovince']);
				$value['c'] = rawurlencode($value['residecity']);
				$value['group'] = $groups[$value['gid']];
				$value['isfriend'] = 1;
				$fuids[] = $value['uid'];
				$value['note'] = getstr($value['note'], 28, 0, 0, 0, 0, -1);
				$list[$value['uid']] = $value;
			}
			$multi = multi($count, $perpage, $page, $theurl);
	
	}elseif($_GET['view'] == 'case'){
	$query = $_SGLOBAL['db']->query("SELECT s.* FROM  ".tname('space')." s 
				LEFT JOIN ".tname('spacefield')." f ON s.uid=f.uid
				WHERE s.recomendman='$_SGLOBAL[supe_uid]' and s.buystatus='1' and s.groupid='12'
				ORDER BY s.lastlogin DESC
				LIMIT $start,$perpage");
	while ($value = $_SGLOBAL['db']->fetch_array($query)) {
				realname_set($value['uid'], $value['username'], $value['name'], $value['namestatus']);
				$value['p'] = rawurlencode($value['resideprovince']);
				$value['c'] = rawurlencode($value['residecity']);
				$value['group'] = $groups[$value['gid']];
				$value['isfriend'] = 1;
				$fuids[] = $value['uid'];
				$value['note'] = getstr($value['note'], 28, 0, 0, 0, 0, -1);
				$list[$value['uid']] = $value;
			}
			$multi = multi($count, $perpage, $page, $theurl);
	}elseif($_GET['view'] == 'highcase'){
	$query = $_SGLOBAL['db']->query("SELECT s.* FROM  ".tname('space')." s 
				LEFT JOIN ".tname('spacefield')." f ON s.uid=f.uid
				WHERE s.recomendman='$_SGLOBAL[supe_uid]' and s.buystatus='1' and s.groupid='13'
				ORDER BY s.lastlogin DESC
				LIMIT $start,$perpage");
	while ($value = $_SGLOBAL['db']->fetch_array($query)) {
				realname_set($value['uid'], $value['username'], $value['name'], $value['namestatus']);
				$value['p'] = rawurlencode($value['resideprovince']);
				$value['c'] = rawurlencode($value['residecity']);
				$value['group'] = $groups[$value['gid']];
				$value['isfriend'] = 1;
				$fuids[] = $value['uid'];
				$value['note'] = getstr($value['note'], 28, 0, 0, 0, 0, -1);
				$list[$value['uid']] = $value;
			}
			$multi = multi($count, $perpage, $page, $theurl);
	}elseif($_GET['view'] == 'hot') {

	$theurl = "space.php?uid=$space[uid]&do=friend&view=$_GET[view]";
	$actives = array('me'=>' class="active"');

	if($space['friendnum']) {
		if($wheresql) {
			$count = $_SGLOBAL['db']->result($_SGLOBAL['db']->query("SELECT COUNT(*) FROM ".tname('friend')." main WHERE main.uid='$space[uid]' AND main.status='1' $wheresql"), 0);
		} else {
			$count = $space['friendnum'];
		}
	if($count) {
		$query = $_SGLOBAL['db']->query("SELECT s.*, f.resideprovince, f.residecity, f.note, f.spacenote, f.sex, main.gid, main.num
				FROM ".tname('friend')." main
				LEFT JOIN ".tname('space')." s ON s.uid=main.fuid
				LEFT JOIN ".tname('spacefield')." f ON f.uid=main.fuid
				WHERE main.uid='$space[uid]' AND main.status='1' $wheresql
				ORDER BY s.introducenum+s.productnum+s.developmentnum+s.industrynum+s.casesnum+s.branchnum+s.jobnum DESC
				LIMIT $start,$perpage");
		while ($value = $_SGLOBAL['db']->fetch_array($query)) {
				$query1 = $_SGLOBAL['db']->query("SELECT * FROM ".tname('feed')." where uid='$value[uid]' ORDER BY dateline DESC");
				while($value1 = $_SGLOBAL['db']->fetch_array($query1)){
				realname_set($value['uid'], $value['username'], $value['name'], $value['namestatus']);

				$value['feed'][]=mkfeed($value1);
				}
				realname_set($value['uid'], $value['username'], $value['name'], $value['namestatus']);
				$value['p'] = rawurlencode($value['resideprovince']);
				$value['c'] = rawurlencode($value['residecity']);
				$value['group'] = $groups[$value['gid']];
				$value['isfriend'] = 1;
				$fuids[] = $value['uid'];
				$value['note'] = getstr($value['note'], 28, 0, 0, 0, 0, -1);
				$list[$value['uid']] = $value;
			}
		}
	}
	$multi = multi($count, $perpage, $page, $theurl);

}elseif($_GET['view'] == 'blacklist') {

	$theurl = "space.php?uid=$space[uid]&do=friend&view=$_GET[view]";
	$actives = array('me'=>' class="active"');

	$count = $_SGLOBAL['db']->result($_SGLOBAL['db']->query("SELECT COUNT(*) FROM ".tname('blacklist')." main WHERE main.uid='$space[uid]'"), 0);
	if($count) {
		$query = $_SGLOBAL['db']->query("SELECT s.username, s.name, s.namestatus, s.groupid, main.dateline, main.buid AS uid
			FROM ".tname('blacklist')." main
			LEFT JOIN ".tname('space')." s ON s.uid=main.buid
			WHERE main.uid='$space[uid]'
			ORDER BY main.dateline DESC
			LIMIT $start,$perpage");
		while ($value = $_SGLOBAL['db']->fetch_array($query)) {
			$value['isfriend'] = 0;
			realname_set($value['uid'], $value['username'], $value['name'], $value['namestatus']);
			$fuids[] = $value['uid'];
			$list[$value['uid']] = $value;
		}
	}
	$multi = multi($count, $perpage, $page, $theurl);

} else {

	//´¦Àí²éÑ¯
	$theurl = "space.php?uid=$space[uid]&do=$do";
	$actives = array('me'=>' class="active"');
	
	$_GET['view'] = 'me';

	//ºÃÓÑ·Ö×é
	$wheresql = '';
	if($space['self']) {
		$groups = getfriendgroup();
		$group = !isset($_GET['group'])?'-1':intval($_GET['group']);
		if($group > -1) {
			$wheresql = "AND main.gid='$group'";
			$theurl .= "&group=$group";
		}
	}
	if($_GET['searchkey']) {
		$wheresql = "AND main.fusername='$_GET[searchkey]'";
		$theurl .= "&searchkey=$_GET[searchkey]";
	}
	realname_get();
	if($space['friendnum']) {
		if($wheresql) {
			$count = $_SGLOBAL['db']->result($_SGLOBAL['db']->query("SELECT COUNT(*) FROM ".tname('friend')." main WHERE main.uid='$space[uid]' AND main.status='1' $wheresql"), 0);
		} else {
			$count = $space['friendnum'];
		}

		if($count) {
			$query = $_SGLOBAL['db']->query("SELECT s.*, f.resideprovince, f.residecity, f.note, f.spacenote, f.sex, main.gid, main.num
				FROM ".tname('friend')." main
				LEFT JOIN ".tname('space')." s ON s.uid=main.fuid
				LEFT JOIN ".tname('spacefield')." f ON f.uid=main.fuid
				WHERE main.uid='$space[uid]' AND main.status='1' $wheresql
				ORDER BY main.dateline DESC
				LIMIT $start,$perpage");
			while ($value = $_SGLOBAL['db']->fetch_array($query)) {
				$query1 = $_SGLOBAL['db']->query("SELECT * FROM ".tname('feed')." where uid='$value[uid]' ORDER BY dateline DESC");
				while($value1 = $_SGLOBAL['db']->fetch_array($query1)){
				realname_set($value['uid'], $value['username'], $value['name'], $value['namestatus']);

				$value['feed'][]=mkfeed($value1);
				}
				realname_set($value['uid'], $value['username'], $value['name'], $value['namestatus']);
				$value['p'] = rawurlencode($value['resideprovince']);
				$value['c'] = rawurlencode($value['residecity']);
				$value['group'] = $groups[$value['gid']];
				$value['isfriend'] = 1;
				$fuids[] = $value['uid'];
				$value['note'] = getstr($value['note'], 28, 0, 0, 0, 0, -1);
				$list[$value['uid']] = $value;
			}
		}

		//·ÖÒ³
		$multi = multi($count, $perpage, $page, $theurl);
		$friends = array();
		//È¡100ºÃÓÑÓÃ»§Ãû
		$query = $_SGLOBAL['db']->query("SELECT f.fusername, s.name, s.namestatus, s.groupid FROM ".tname('friend')." f
			LEFT JOIN ".tname('space')." s ON s.uid=f.fuid
			WHERE f.uid=$_SGLOBAL[supe_uid] AND f.status='1' ORDER BY f.num DESC, f.dateline DESC LIMIT 0,100");
		while ($value = $_SGLOBAL['db']->fetch_array($query)) {
			$fusername = ($_SCONFIG['realname'] && $value['name'] && $value['namestatus'])?$value['name']:$value['fusername'];
			$friends[] = addslashes($fusername);
		}
		$friendstr = implode(',', $friends);
	}

	if($space['self']) {
		$groupselect = array($group => ' class="current"');

		//ºÃÓÑ¸öÊý
		$maxfriendnum = checkperm('maxfriendnum');
		if($maxfriendnum) {
			$maxfriendnum = checkperm('maxfriendnum') + $space['addfriend'];
		}
	}
}

//ÔÚÏß×´Ì¬
if($fuids) {
	$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('session')." WHERE uid IN (".simplode($fuids).")");
	while ($value = $_SGLOBAL['db']->fetch_array($query)) {
		if(!$value['magichidden']) {
			$ols[$value['uid']] = $value['lastactivity'];
		} elseif($list[$value['uid']] && !in_array($_GET['view'], array('me', 'trace', 'blacklist'))) {
			unset($list[$value['uid']]);
			$count = $count - 1;
		}
	}
}






realname_get();

if(empty($_GET['view']) || $_GET['view'] == 'all') $_GET['view'] = 'me';
$a_actives = array($_GET['view'].$_GET['type'] => ' class="current"');

include_once template("space_friend");

?>