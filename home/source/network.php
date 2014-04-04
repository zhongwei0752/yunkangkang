<?
/*
	[UCenter Home] (C) 2007-2008 Comsenz Inc.
	$Id: network_album.php 12078 2009-05-04 08:28:37Z zhengqingpeng $
*/

if(!defined('IN_UCHOME')) {
	exit('Access Denied');
}

//ÊÇ·ñ¹«¿ª
if(empty($_SCONFIG['networkpublic'])) {
	checklogin();//ÐèÒªµÇÂ¼
}

include_once(S_ROOT.'./data/data_network.php');

//ÈÕÖ¾
$cachefile = S_ROOT.'./data/cache_network_blog.txt';
if(check_network_cache('blog')) {
	$bloglist = unserialize(sreadfile($cachefile));
} else {
	$sqlarr = mk_network_sql('blog',
		array('blogid', 'uid'),
		array('hot','viewnum','replynum'),
		array('dateline'),
		array('dateline','viewnum','replynum','hot')
	);
	extract($sqlarr);

	//ÒþË½
	$wherearr[] = "main.friend='0'";
	
	//ÏÔÊ¾ÊýÁ¿
	$shownum = 6;
	
	$query = $_SGLOBAL['db']->query("SELECT main.*, field.* 
		FROM ".tname('blog')." main
		LEFT JOIN ".tname('blogfield')." field ON field.blogid=main.blogid
		WHERE ".implode(' AND ', $wherearr)."
		ORDER BY main.{$order} $sc LIMIT 0,$shownum");
	$bloglist = array();
	while ($value = $_SGLOBAL['db']->fetch_array($query)) {
		$value['message'] = getstr($value['message'], 86, 0, 0, 0, 0, -1);
		$value['subject'] = getstr($value['subject'], 50, 0, 0, 0, 0, -1);
		$bloglist[] = $value;
	}
	if($_SGLOBAL['network']['blog']['cache']) {
		swritefile($cachefile, serialize($bloglist));
	}
}
foreach($bloglist as $key => $value) {
	realname_set($value['uid'], $value['username']);
	$bloglist[$key] = $value;
}

//Í¼Æ¬
$cachefile = S_ROOT.'./data/cache_network_pic.txt';
if(check_network_cache('pic')) {
	$piclist = unserialize(sreadfile($cachefile));
} else {
	$sqlarr = mk_network_sql('pic',
		array('picid', 'uid'),
		array('hot'),
		array('dateline'),
		array('dateline','hot')
	);
	extract($sqlarr);

	//ÏÔÊ¾ÊýÁ¿
	$shownum = 28;
	
	$piclist = array();
	$query = $_SGLOBAL['db']->query("SELECT album.albumname, album.friend, space.username, space.name, space.namestatus, main.* 
		FROM ".tname('pic')." main
		LEFT JOIN ".tname('album')." album ON album.albumid=main.albumid
		LEFT JOIN ".tname('space')." space ON space.uid=main.uid
		WHERE ".implode(' AND ', $wherearr)."
		ORDER BY main.{$order} $sc LIMIT 0,$shownum");
	while ($value = $_SGLOBAL['db']->fetch_array($query)) {
		if(empty($value['friend'])) {
			$value['pic'] = pic_get($value['filepath'], $value['thumb'], $value['remote']);
			$piclist[] = $value;
		}
	}
	if($_SGLOBAL['network']['pic']['cache']) {
		swritefile($cachefile, serialize($piclist));
	}
}
foreach($piclist as $key => $value) {
	realname_set($value['uid'], $value['username'], $value['name'], $value['namestatus']);
	$piclist[$key] = $value;
}

//»°Ìâ
$cachefile = S_ROOT.'./data/cache_network_thread.txt';
if(check_network_cache('thread')) {
	$threadlist = unserialize(sreadfile($cachefile));
} else {
	$sqlarr = mk_network_sql('thread',
		array('tid', 'uid'),
		array('hot','viewnum','replynum'),
		array('dateline','lastpost'),
		array('dateline','viewnum','replynum','hot')
	);
	extract($sqlarr);

	//ÏÔÊ¾ÊýÁ¿
	$shownum = 10;
	
	$threadlist = array();
	$query = $_SGLOBAL['db']->query("SELECT main.*, m.tagname
		FROM ".tname('thread')." main
		LEFT JOIN ".tname('mtag')." m ON m.tagid=main.tagid
		WHERE ".implode(' AND ', $wherearr)."
		ORDER BY main.{$order} $sc LIMIT 0,$shownum");
	while ($value = $_SGLOBAL['db']->fetch_array($query)) {
		$value['tagname'] = getstr($value['tagname'], 20);
		$value['subject'] = getstr($value['subject'], 50);
		$threadlist[] = $value;
	}
	if($_SGLOBAL['network']['thread']['cache']) {
		swritefile($cachefile, serialize($threadlist));
	}
}
foreach($threadlist as $key => $value) {
	realname_set($value['uid'], $value['username']);
	$threadlist[$key] = $value;
}


//»î¶¯
include_once(S_ROOT.'./data/data_eventclass.php');
$cachefile = S_ROOT.'./data/cache_network_event.txt';
if(check_network_cache('event')) {
	$eventlist = unserialize(sreadfile($cachefile));
} else {
	$sqlarr = mk_network_sql('event',
		array('eventid', 'uid'),
		array('hot','membernum','follownum'),
		array('dateline'),
		array('dateline','membernum','follownum','hot')
	);
	extract($sqlarr);

	//ÏÔÊ¾ÊýÁ¿
	$shownum = 4;
	
	$eventlist = array();
	$query = $_SGLOBAL['db']->query("SELECT main.*
		FROM ".tname('event')." main
		WHERE ".implode(' AND ', $wherearr)."
		ORDER BY main.{$order} $sc LIMIT 0,$shownum");
	while ($value = $_SGLOBAL['db']->fetch_array($query)) {
		$value['title'] = getstr($value['title'], 45);
		if($value['poster']){
			$value['pic'] = pic_get($value['poster'], $value['thumb'], $value['remote']);
		} else {
			$value['pic'] = $_SGLOBAL['eventclass'][$value['classid']]['poster'];
		}
		$eventlist[] = $value;
	}
	if($_SGLOBAL['network']['event']['cache']) {
		swritefile($cachefile, serialize($eventlist));
	}
}
foreach($eventlist as $key => $value) {
	realname_set($value['uid'], $value['username']);
	$eventlist[$key] = $value;
}


//Í¶Æ±
$cachefile = S_ROOT.'./data/cache_network_poll.txt';
if(check_network_cache('poll')) {
	$polllist = unserialize(sreadfile($cachefile));
} else {
	$sqlarr = mk_network_sql('poll',
		array('pid', 'uid'),
		array('hot','voternum','replynum'),
		array('dateline'),
		array('dateline','voternum','replynum','hot')
	);
	extract($sqlarr);

	//ÏÔÊ¾ÊýÁ¿
	$shownum = 9;
	
	$polllist = array();
	$query = $_SGLOBAL['db']->query("SELECT main.*
		FROM ".tname('poll')." main
		WHERE ".implode(' AND ', $wherearr)."
		ORDER BY main.{$order} $sc LIMIT 0,$shownum");
	while ($value = $_SGLOBAL['db']->fetch_array($query)) {
		realname_set($value['uid'], $value['username']);
		$polllist[] = $value;
	}
	if($_SGLOBAL['network']['poll']['cache']) {
		swritefile($cachefile, serialize($polllist));
	}
}
foreach($polllist as $key => $value) {
	realname_set($value['uid'], $value['username']);
	$polllist[$key] = $value;
}

//¼ÇÂ¼
$dolist = array();
$query = $_SGLOBAL['db']->query("SELECT *
	FROM ".tname('doing')."
	ORDER BY dateline DESC LIMIT 0,5");
while ($value = $_SGLOBAL['db']->fetch_array($query)) {
	realname_set($value['uid'], $value['username']);
	$value['title'] = getstr($value['message'], 0, 0, 0, 0, 0, -1);
	$dolist[] = $value;
}

//Õ¾³¤ÍÆ¼ö
$star = array();
$starlist = array();
if($_SCONFIG['spacebarusername']) {
	$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('space')." WHERE username IN (".simplode(explode(',', $_SCONFIG['spacebarusername'])).")");
	while ($value = $_SGLOBAL['db']->fetch_array($query)) {
		realname_set($value['uid'], $value['username'], $value['name'], $value['namestatus']);
		$starlist[] = $value;
	}
}
if($starlist) {
	$star = sarray_rand($starlist, 1);
}

//¾º¼ÛÅÅÃû
$showlist = array();
$query = $_SGLOBAL['db']->query("SELECT sh.note, s.* FROM ".tname('show')." sh
	LEFT JOIN ".tname('space')." s ON s.uid=sh.uid
	ORDER BY sh.credit DESC LIMIT 0,23");
while ($value = $_SGLOBAL['db']->fetch_array($query)) {
	realname_set($value['uid'], $value['username'], $value['name'], $value['namestatus']);
	$value['note'] = addslashes(getstr($value['note'], 80, 0, 0, 0, 0, -1));
	$showlist[$value['uid']] = $value;
}
if(empty($star) && $showlist) {
	$star = sarray_rand($showlist, 1);
}

//ÔÚÏßÓÃ»§
$onlinelist = array();
$query = $_SGLOBAL['db']->query("SELECT s.*, sf.note FROM ".tname('session')." s
	LEFT JOIN ".tname('spacefield')." sf ON sf.uid=s.uid
	ORDER BY s.lastactivity DESC LIMIT 0,12");
while ($value = $_SGLOBAL['db']->fetch_array($query)) {
	if(!$value['magichidden']) {
		$value['note'] = shtmlspecialchars(strip_tags($value['note']));
		realname_set($value['uid'], $value['username']);
		$onlinelist[$value['uid']] = $value;
	}
}
if(empty($star) && $onlinelist) {
	$star = sarray_rand($onlinelist, 1);
}
//已开通企业
$openlist = array();
$query = $_SGLOBAL['db']->query("SELECT main.*, field.* FROM ".tname('space')." main USE INDEX (updatetime)
		LEFT JOIN ".tname('spacefield')." field ON field.uid=main.uid
		ORDER BY main.friendnum DESC limit 0,13");
while ($value = $_SGLOBAL['db']->fetch_array($query)) {
		realname_set($value['uid'], $value['username']);
		$openlist[$value['uid']] = $value;
}
if(empty($star) && $openlist) {
	$star = sarray_rand($openlist, 1);
}
//未登录页展示大图
$query2 = $_SGLOBAL['db']->query("SELECT * FROM ".tname('image')." where style='bigimage'");
$bigimage = $_SGLOBAL['db']->fetch_array($query2);
//未登录页商家logo展示页
$logoimage=array();
$query3 = $_SGLOBAL['db']->query("SELECT * FROM ".tname('image')." where style='logoimage' order by id DESC");
while ($value3 = $_SGLOBAL['db']->fetch_array($query3)) {
	$logoimage[]=$value3;
	}


//ÔÚÏßÈËÊý
$olcount = getcount('session', array());

//Ó¦ÓÃ
$myappcount = 0;
$myapplist = array();
if($_SCONFIG['my_status']) {
	$myappcount = $_SGLOBAL['db']->result($_SGLOBAL['db']->query("SELECT COUNT(*) FROM ".tname('myapp')." WHERE flag>='0'"), 0);
	if($myappcount) {
		$query = $_SGLOBAL['db']->query("SELECT appid,appname FROM ".tname('myapp')." WHERE flag>=0 ORDER BY flag DESC, displayorder LIMIT 0,7");
		while ($value = $_SGLOBAL['db']->fetch_array($query)) {
			$myapplist[] = $value;
		}
	}
}

//·ÖÏí
$sharelist = array();
$query = $_SGLOBAL['db']->query("SELECT *
	FROM ".tname('share')."
	ORDER BY dateline DESC LIMIT 0,11");
while ($value = $_SGLOBAL['db']->fetch_array($query)) {
	realname_set($value['uid'], $value['username']);
	$sharelist[] = $value;
}

realname_get();

//×îºóµÇÂ¼Ãû
$membername = empty($_SCOOKIE['loginuser'])?'':sstripslashes($_SCOOKIE['loginuser']);
$wheretime = $_SGLOBAL['timestamp']-3600*24*30;

$_TPL['css'] = 'network';
include_once template("network");

//¼ì²é»º´æ
function check_network_cache($type) {
	global $_SGLOBAL;
	
	if($_SGLOBAL['network'][$type]['cache']) {
		$cachefile = S_ROOT.'./data/cache_network_'.$type.'.txt';
		$ftime = filemtime($cachefile);
		if($_SGLOBAL['timestamp'] - $ftime < $_SGLOBAL['network'][$type]['cache']) {
			return true;
		}
	}
	return false;
}

//»ñµÃSQL
function mk_network_sql($type, $ids, $crops, $days, $orders) {
	global $_SGLOBAL;
	
	$nt = $_SGLOBAL['network'][$type];
	
	$wherearr = array('1');
	//Ö¸¶¨
	foreach ($ids as $value) {
		if($nt[$value]) {
			$wherearr[] = "main.{$value} IN (".$nt[$value].")";
		}
	}
	
	//·¶Î§
	foreach ($crops as $value) {
		$value1 = $value.'1';
		$value2 = $value.'2';
		if($nt[$value1]) {
			$wherearr[] = "main.{$value} >= '".$nt[$value1]."'";
		}
		if($nt[$value2]) {
			$wherearr[] = "main.{$value} <= '".$nt[$value2]."'";
		}
	}
	//Ê±¼ä
	foreach ($days as $value) {
		if($nt[$value]) {
			$daytime = $_SGLOBAL['timestamp'] - $nt[$value]*3600*24;
			$wherearr[] = "main.{$value}>='$daytime'";
		}
	}
	//ÅÅÐò
	$order = in_array($nt['order'], $orders)?$nt['order']:array_shift($orders);
	$sc = in_array($nt['sc'], array('desc','asc'))?$nt['sc']:'desc';
	
	return array('wherearr'=>$wherearr, 'order'=>$order, 'sc'=>$sc);
}

?>