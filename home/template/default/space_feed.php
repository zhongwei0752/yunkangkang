<?php
/*
	[UCenter Home] (C) 2007-2008 Comsenz Inc.
	$Id: space_feed.php 13194 2009-08-18 07:44:40Z liguode $
*/

if(!defined('IN_UCHOME')) {
	exit('Access Denied');
}
if ($space['profilestatus']=='0'&&$space['namestatus']=='0'){
		showmessage('enter_the_space', 'cp.php?ac=profile', 0);
	}
	if($space['namestatus']=='0'&&$space['alreadyreg']=='0'){
		showmessage('enter_the_space', './template/default/post_ok.htm', 0);
	}
	if($space['profilestatus']=='0'&&$space['namestatus']=='1'&&empty($zhong1)){
		showmessage('enter_the_space', 'space.php?do=menuset', 0);
	}

//ÏÔÊ¾È«Õ¾¶¯Ì¬µÄºÃÓÑÊý
if(empty($_SCONFIG['showallfriendnum']) || $_SCONFIG['showallfriendnum']<1) $_SCONFIG['showallfriendnum'] = 10;
//Ä¬ÈÏÈÈµãÌìÊý
if(empty($_SCONFIG['feedhotday'])) $_SCONFIG['feedhotday'] = 2;

//ÍøÕ¾½ü¿ö
$isnewer = $space['friendnum']<$_SCONFIG['showallfriendnum']?1:0;
if(empty($_GET['view']) && $space['self'] && $isnewer) {
	$_GET['view'] = 'all';//Ä¬ÈÏÏÔÊ¾
}

//·ÖÒ³
$perpage = $_SCONFIG['feedmaxnum']<50?50:$_SCONFIG['feedmaxnum'];
$perpage = mob_perpage($perpage);

if($_GET['view'] == 'hot') {
	$perpage = 50;
}

$start = empty($_GET['start'])?0:intval($_GET['start']);
//¼ì²é¿ªÊ¼Êý
ckstart($start, $perpage);

//½ñÌìÊ±¼ä¿ªÊ¼Ïß
$_SGLOBAL['today'] = sstrtotime(sgmdate('Y-m-d'));

//×îÉÙÈÈ¶È
$minhot = $_SCONFIG['feedhotmin']<1?3:$_SCONFIG['feedhotmin'];
$_SGLOBAL['gift_appid'] = '1027468';

if($_GET['view'] == 'all') {

	$wheresql = "1";//Ã»ÓÐÒþË½
	$ordersql = "dateline DESC";
	$theurl = "space.php?uid=$space[uid]&do=$do&view=all";
	$f_index = '';

} elseif($_GET['view'] == 'hot') {

	$wheresql = "hot>='$minhot'";
	$ordersql = "dateline DESC";
	$theurl = "space.php?uid=$space[uid]&do=$do&view=hot";
	$f_index = '';

} else {

	if(empty($space['feedfriend'])) $_GET['view'] = 'me';
	
	if( $_GET['view'] == 'me') {
		$wheresql = "uid='$space[uid]'";
		$ordersql = "dateline DESC";
		$theurl = "space.php?uid=$space[uid]&do=$do&view=me";
		$f_index = '';
		
	} else {
		$wheresql = "uid IN ('0',$space[feedfriend])";
		$ordersql = "dateline DESC";
		$theurl = "space.php?uid=$space[uid]&do=$do&view=we";
		$f_index = 'USE INDEX(dateline)';
		$_GET['view'] = 'we';
		//²»ÏÔÊ¾Ê±¼ä
		$_TPL['hidden_time'] = 1;
	}
}

//¹ýÂË
$appid = empty($_GET['appid'])?0:intval($_GET['appid']);
if($appid) {
	$wheresql .= " AND appid='$appid'";
}
$icon = empty($_GET['icon'])?'':trim($_GET['icon']);
if($icon) {
	$wheresql .= " AND icon='$icon'";
}
$filter = empty($_GET['filter'])?'':trim($_GET['filter']);
if($filter == 'site') {
	$wheresql .= " AND appid>0";
} elseif($filter == 'myapp') {
	$wheresql .= " AND appid='0'";
}

$feed_list = $appfeed_list = $hiddenfeed_list = $filter_list = $hiddenfeed_num = $icon_num = array();
$count = $filtercount = 0;
$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('feed')." $f_index
	WHERE $wheresql
	ORDER BY $ordersql
	LIMIT $start,$perpage");

if($_GET['view'] == 'me' || $_GET['view'] == 'hot') {
	//¸öÈË¶¯Ì¬
	while ($value = $_SGLOBAL['db']->fetch_array($query)) {
		if(ckfriend($value['uid'], $value['friend'], $value['target_ids'])) {
			realname_set($value['uid'], $value['username']);
			$feed_list[] = $value;
		}
		$count++;
	}
} else {
	//ÒªÕÛµþµÄ¶¯Ì¬
	$hidden_icons = array();
	if($_SCONFIG['feedhiddenicon']) {
		$_SCONFIG['feedhiddenicon'] = str_replace(' ', '', $_SCONFIG['feedhiddenicon']);
		$hidden_icons = explode(',', $_SCONFIG['feedhiddenicon']);
	}
	$space['filter_icon'] = empty($space['privacy']['filter_icon'])?array():array_keys($space['privacy']['filter_icon']);
	while ($value = $_SGLOBAL['db']->fetch_array($query)) {
		if(empty($feed_list[$value['hash_data']][$value['uid']])) {
			if(ckfriend($value['uid'], $value['friend'], $value['target_ids'])) {
				realname_set($value['uid'], $value['username']);
				if(ckicon_uid($value)) {
					$ismyapp = is_numeric($value['icon'])?1:0;
					if($_SCONFIG['my_showgift'] && $value['icon'] == $_SGLOBAL['gift_appid']) $ismyapp = 0;
					if((($ismyapp && in_array('myop', $hidden_icons)) || in_array($value['icon'], $hidden_icons)) && !empty($icon_num[$value['icon']])) {
						$hiddenfeed_num[$value['icon']]++;
						$hiddenfeed_list[$value['icon']][] = $value;
					} else {
						if($ismyapp) {
							$appfeed_list[$value['hash_data']][$value['uid']] = $value;
						} else {
							$feed_list[$value['hash_data']][$value['uid']] = $value;
						}
					}
					$icon_num[$value['icon']]++;
				} else {
					$filtercount++;
					$filter_list[] = $value;
				}
			}
		}
		$count++;
	}
}

$olfriendlist = $visitorlist = $task = $ols = $birthlist = $myapp = $hotlist = $guidelist = array();
$oluids = array();
$topiclist = array();
$newspacelist = array();

if($space['self'] && empty($start)) {

	//¶ÌÏûÏ¢
	$space['pmnum'] = $_SGLOBAL['member']['newpm'];

	//¾Ù±¨¹ÜÀí
	if(checkperm('managereport')) {
		$space['reportnum'] = $_SGLOBAL['db']->result($_SGLOBAL['db']->query("SELECT COUNT(*) FROM ".tname('report')." WHERE new='1'"), 0);
	}

	//ÉóºË»î¶¯
	if(checkperm('manageevent')) {
		$space['eventverifynum'] = $_SGLOBAL['db']->result($_SGLOBAL['db']->query("SELECT COUNT(*) FROM ".tname('event')." WHERE grade='0'"), 0);
	}

	//µÈ´ýÊµÃûÈÏÖ¤
	if($_SCONFIG['realname'] && checkperm('managename')) {
		$space['namestatusnum'] = $_SGLOBAL['db']->result($_SGLOBAL['db']->query("SELECT COUNT(*) FROM ".tname('space')." WHERE namestatus='0' AND profilestatus='1'"), 0);
	}
	
	//»¶Ó­ÐÂ³ÉÔ±
	if($_SCONFIG['newspacenum']>0) {
		$newspacelist = unserialize(data_get('newspacelist'));
		if(!is_array($newspacelist)) $newspacelist = array();
		foreach ($newspacelist as $value) {
			$oluids[] = $value['uid'];
			realname_set($value['uid'], $value['username'], $value['name'], $value['namestatus']);
		}
	}

	//×î½ü·Ã¿ÍÁÐ±í
	$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('visitor')." WHERE uid='$space[uid]' ORDER BY dateline DESC LIMIT 0,12");
	while ($value = $_SGLOBAL['db']->fetch_array($query)) {
		realname_set($value['vuid'], $value['vusername']);
		$visitorlist[$value['vuid']] = $value;
		$oluids[] = $value['vuid'];
	}

	//·Ã¿ÍÔÚÏß
	if($oluids) {
		$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('session')." WHERE uid IN (".simplode($oluids).")");
		while ($value = $_SGLOBAL['db']->fetch_array($query)) {
			if(!$value['magichidden']) {
				$ols[$value['uid']] = 1;
			} elseif ($visitorlist[$value['uid']]) {
				unset($visitorlist[$value['uid']]);
			}
		}
	}

	$oluids = array();
	$olfcount = 0;
	if($space['feedfriend']) {
		//ÔÚÏßºÃÓÑ
		$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('session')." WHERE uid IN ($space[feedfriend]) ORDER BY lastactivity DESC LIMIT 0,15");
		while ($value = $_SGLOBAL['db']->fetch_array($query)) {
			if(!$value['magichidden']) {
				realname_set($value['uid'], $value['username']);
				$olfriendlist[] = $value;
				$ols[$value['uid']] = 1;
				$oluids[$value['uid']] = $value['uid'];
				$olfcount++;
			}
		}
	}
	if($olfcount < 15) {
		//ÎÒµÄºÃÓÑ
		$query = $_SGLOBAL['db']->query("SELECT fuid AS uid, fusername AS username, num FROM ".tname('friend')." WHERE uid='$space[uid]' AND status='1' ORDER BY num DESC, dateline DESC LIMIT 0,30");
		while ($value = $_SGLOBAL['db']->fetch_array($query)) {
			if(empty($oluids[$value['uid']])) {
				realname_set($value['uid'], $value['username']);
				$olfriendlist[] = $value;
				$olfcount++;
				if($olfcount == 15) break;
			}
		}
	}

	//»ñÈ¡ÈÎÎñ
	include_once(S_ROOT.'./source/function_space.php');
	$task = gettask();

	//ºÃÓÑÉúÈÕ
	if($space['feedfriend']) {
		list($s_month, $s_day) = explode('-', sgmdate('n-j', $_SGLOBAL['timestamp']-3600*24*3));//¹ýÆÚ3Ìì
		list($n_month, $n_day) = explode('-', sgmdate('n-j', $_SGLOBAL['timestamp']));
		list($e_month, $e_day) = explode('-', sgmdate('n-j', $_SGLOBAL['timestamp']+3600*24*7));
		if($e_month == $s_month) {
			$wheresql = "sf.birthmonth='$s_month' AND sf.birthday>='$s_day' AND sf.birthday<='$e_day'";
		} else {
			$wheresql = "(sf.birthmonth='$s_month' AND sf.birthday>='$s_day') OR (sf.birthmonth='$e_month' AND sf.birthday<='$e_day' AND sf.birthday>'0')";
		}
		$query = $_SGLOBAL['db']->query("SELECT s.uid,s.username,s.name,s.namestatus,s.groupid,sf.birthyear,sf.birthmonth,sf.birthday
			FROM ".tname('spacefield')." sf
			LEFT JOIN ".tname('space')." s ON s.uid=sf.uid
			WHERE (sf.uid IN ($space[feedfriend])) AND ($wheresql)");
		while ($value = $_SGLOBAL['db']->fetch_array($query)) {
			realname_set($value['uid'], $value['username'], $value['name'], $value['namestatus']);
			$value['istoday'] = 0;
			if($value['birthmonth'] == $n_month && $value['birthday'] == $n_day) {
				$value['istoday'] = 1;
			}
			$key = sprintf("%02d", $value['birthmonth']).sprintf("%02d", $value['birthday']);
			$birthlist[$key][] = $value;
			ksort($birthlist);
		}
	}

	//»ý·Ö
	$space['star'] = getstar($space['experience']);

	//ÓòÃû
	$space['domainurl'] = space_domain($space);

	//ÈÈµã
	if($_SCONFIG['feedhotnum'] > 0 && ($_GET['view'] == 'we' || $_GET['view'] == 'all')) {
		$hotlist_all = array();
		$hotstarttime = $_SGLOBAL['timestamp'] - $_SCONFIG['feedhotday']*3600*24;
		$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('feed')." USE INDEX(hot) WHERE dateline>='$hotstarttime' ORDER BY hot DESC LIMIT 0,10");
		while ($value = $_SGLOBAL['db']->fetch_array($query)) {
			if($value['hot']>0 && ckfriend($value['uid'], $value['friend'], $value['target_ids'])) {
				realname_set($value['uid'], $value['username']);
				if(empty($hotlist)) {
					$hotlist[$value['feedid']] = $value;
				} else {
					$hotlist_all[$value['feedid']] = $value;
				}
			}
		}
		$nexthotnum = $_SCONFIG['feedhotnum'] - 1;
		if($nexthotnum > 0) {
			if(count($hotlist_all)> $nexthotnum) {
				$hotlist_key = array_rand($hotlist_all, $nexthotnum);
				if($nexthotnum == 1) {
					$hotlist[$hotlist_key] = $hotlist_all[$hotlist_key];
				} else {
					foreach ($hotlist_key as $key) {
						$hotlist[$key] = $hotlist_all[$key];
					}
				}
			} else {
				$hotlist = $hotlist_all;
			}
		}
	}
	
	//ÈÈÄÖ
	$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('topic')." ORDER BY lastpost DESC LIMIT 0,1");
	while ($value = $_SGLOBAL['db']->fetch_array($query)) {
		$value['pic'] = $value['pic']?pic_get($value['pic'], $value['thumb'], $value['remote']):'';
		$topiclist[] = $value;
	}


	//ÌáÐÑ×ÜÊý
	$space['allnum'] = 0;
	foreach (array('notenum', 'addfriendnum', 'mtaginvitenum', 'eventinvitenum', 'myinvitenum', 'pokenum', 'reportnum', 'namestatusnum', 'eventverifynum') as $value) {
		$space['allnum'] = $space['allnum'] + $space[$value];
	}
}

//ÊµÃû´¦Àí
realname_get();

//feedºÏ²¢
$list = array();

if($_GET['view'] == 'hot') {
	//ÈÈµã
	foreach ($feed_list as $value) {
		$value = mkfeed($value);
		$list['today'][] = $value;
	}
} elseif($_GET['view'] == 'me') {
	//¸öÈË
	foreach ($feed_list as $value) {
		if($hotlist[$value['feedid']]) continue;
		$value = mkfeed($value);
		if($value['dateline']>=$_SGLOBAL['today']) {
			$list['today'][] = $value;
		} elseif ($value['dateline']>=$_SGLOBAL['today']-3600*24) {
			$list['yesterday'][] = $value;
		} else {
			$theday = sgmdate('Y-m-d', $value['dateline']);
			$list[$theday][] = $value;
		}
	}
} else {
	//ºÃÓÑ¡¢È«Õ¾
	foreach ($feed_list as $values) {
		$actors = array();
		$a_value = array();
		foreach ($values as $value) {
			if(empty($a_value)) {
				$a_value = $value;
			}
			$actors[] = "<a href=\"space.php?uid=$value[uid]\">".$_SN[$value['uid']]."</a>";
		}
		if($hotlist[$a_value['feedid']]) continue;
		$a_value = mkfeed($a_value, $actors);
		if($a_value['dateline']>=$_SGLOBAL['today']) {
			$list['today'][] = $a_value;
		} elseif ($a_value['dateline']>=$_SGLOBAL['today']-3600*24) {
			$list['yesterday'][] = $a_value;
		} else {
			$theday = sgmdate('Y-m-d', $a_value['dateline']);
			$list[$theday][] = $a_value;
		}
	}
	//Ó¦ÓÃ
	foreach ($appfeed_list as $values) {
		$actors = array();
		$a_value = array();
		foreach ($values as $value) {
			if(empty($a_value)) {
				$a_value = $value;
			}
			$actors[] = "<a href=\"space.php?uid=$value[uid]\">".$_SN[$value['uid']]."</a>";
		}
		$a_value = mkfeed($a_value, $actors);
		$list['app'][] = $a_value;
	}
}

//»ñµÃ¸öÐÔÄ£°å
$templates = $default_template = array();
$tpl_dir = sreaddir(S_ROOT.'./template');
foreach ($tpl_dir as $dir) {
	if(file_exists(S_ROOT.'./template/'.$dir.'/style.css')) {
		$tplicon = file_exists(S_ROOT.'./template/'.$dir.'/image/template.gif')?'template/'.$dir.'/image/template.gif':'image/tlpicon.gif';
		$tplvalue = array('name'=> $dir, 'icon'=>$tplicon);
		if($dir == $_SCONFIG['template']) {
			$default_template = $tplvalue;
		} else {
			$templates[$dir] = $tplvalue;
		}
	}
}
$_TPL['templates'] = $templates;
$_TPL['default_template'] = $default_template;

//±êÇ©¼¤»î
$my_actives = array(in_array($_GET['filter'], array('site','myapp'))?$_GET['filter']:'all' => ' class="active"');
$actives = array(in_array($_GET['view'], array('me','all','hot'))?$_GET['view']:'we' => ' class="active"');

$myapp = $_SGLOBAL['db']->query("SELECT bf.*, b.* FROM ".tname('appset')." bf 
				LEFT JOIN ".tname('menuset')." b ON bf.num=b.menusetid
				WHERE bf.uid='$_SGLOBAL[supe_uid]' and bf.appstatus='1'
				ORDER BY b.dateline ASC ");
		while ($myvalue = $_SGLOBAL['db']->fetch_array($myapp)) {
			//$a=$_SGLOBAL['db']->result($_SGLOBAL['db']->query("SELECT * FROM ".tname($myvalue['english'])."  WHERE uid='$myvalue[uid]'"), 0);
			$a[$myvalue['menusetid']]= $_SGLOBAL['db']->result($_SGLOBAL['db']->query("SELECT count(*) FROM ".tname($myvalue['english'])."  WHERE uid='$space[uid]'"), 0);
			$b[$myvalue['menusetid']]= $_SGLOBAL['db']->result($_SGLOBAL['db']->query("SELECT sum(viewnum) AS viewnum FROM ".tname($myvalue['english'])."  WHERE uid='$space[uid]'"), 0);
			$c[$myvalue['menusetid']]= $_SGLOBAL['db']->result($_SGLOBAL['db']->query("SELECT sum(replynum) AS replynum FROM ".tname($myvalue['english'])."  WHERE uid='$space[uid]'"), 0);
			$d = $_SGLOBAL['db']->query("SELECT * FROM ".tname($myvalue['english'])."  WHERE uid='$space[uid]' ORDER BY dateline DESC LIMIT 0,1");
			$myself[]=$myvalue;
		}

//showmessage($a);

//$b = array_sum($a);
if(empty($cp_mode)) include_once template("space_feed");


//É¸Ñ¡
function ckicon_uid($feed) {
	global $_SGLOBAL, $space, $_SCONFIG;

	if($space['filter_icon']) {
		$key = $feed['icon'].'|0';
		if(in_array($key, $space['filter_icon'])) {
			return false;
		} else {
			$key = $feed['icon'].'|'.$feed['uid'];
			if(in_array($key, $space['filter_icon'])) {
				return false;
			}
		}
	}
	return true;
}

//ÍÆ¼öÀñÎï
function my_showgift() {
	global $_SGLOBAL, $space, $_SCONFIG;
	if($_SCONFIG['my_showgift'] && $_SGLOBAL['my_userapp'][$_SGLOBAL['gift_appid']]) {
		echo '<script language="javascript" type="text/javascript" src="http://gift.manyou-apps.com/recommend.js"></script>';
	}
}

?>