<?php
/*
	[UCenter Home] (C) 2007-2008 Comsenz Inc.
	$Id: space.php 13003 2009-08-05 06:46:06Z liguode $
*/

include_once('./common.php');
include_once(S_ROOT.'./data/data_magic.php');


//ÊÇ·ñ¹Ø±ÕÕ¾µã
checkclose();

//´¦Àírewrite
if($_SCONFIG['allowrewrite'] && isset($_GET['rewrite'])) {
	$rws = explode('-', $_GET['rewrite']);
	if($rw_uid = intval($rws[0])) {
		$_GET['uid'] = $rw_uid;
	} else {
		$_GET['do'] = $rws[0];
	}
	if(isset($rws[1])) {
		$rw_count = count($rws);
		for ($rw_i=1; $rw_i<$rw_count; $rw_i=$rw_i+2) {
			$_GET[$rws[$rw_i]] = empty($rws[$rw_i+1])?'':$rws[$rw_i+1];
		}
	}
	unset($_GET['rewrite']);
}

//ÔÊÐí¶¯×÷
$dos = array('feed', 'doing','booking','explaining','phychtest','explain','baodu', 'mood', 'blog', 'album','xexe', 'thread', 'mtag', 'friend', 'wall', 'tag', 'notice', 'share', 'topic', 'home', 'pm', 'event', 'poll', 'top', 'info', 'videophoto',
	'introduce','product','development','industry','text','cases','branch','job','talk','menuset','check','showmenuset','wei','orderid','recommend','moblie','goods','goweixin','book','newname','myweixin','communicate','weixinmenu',
	'highmenuset','dialog','ajax','ajax1','ajax2','showmenuset1','order','auction','code','dial','seckill','stratch','debate','reservation','xitie','fenlei');

//»ñÈ¡±äÁ¿
$isinvite = 0;
$uid = empty($_GET['uid'])?0:intval($_GET['uid']);
$username = empty($_GET['username'])?'':$_GET['username'];
$domain = empty($_GET['domain'])?'':$_GET['domain'];
$do = (!empty($_GET['do']) && in_array($_GET['do'], $dos))?$_GET['do']:'index';

if($do == 'home') {
	$do = 'feed';
} elseif ($do == 'index') {
	//ÑûÇëºÃÓÑ
	$invite = empty($_GET['invite'])?'':$_GET['invite'];
	$code = empty($_GET['code'])?'':$_GET['code'];
	$reward = getreward('invitecode', 0);
	if($code && !$reward['credit']) {
		$isinvite = -1;
	} elseif($invite) {
		$isinvite = $_SGLOBAL['db']->result($_SGLOBAL['db']->query("SELECT id FROM ".tname('invite')." WHERE uid='$uid' AND code='$invite' AND fuid='0'"), 0);
	}
}

//ÊÇ·ñ¹«¿ª
if(empty($isinvite) && empty($_SCONFIG['networkpublic'])) {
	checklogin();//ÐèÒªµÇÂ¼
}

//»ñÈ¡¿Õ¼ä
if($uid) {
	$space = getspace($uid, 'uid');
} elseif ($username) {
	$space = getspace($username, 'username');
} elseif ($domain) {
	$space = getspace($domain, 'domain');
} elseif ($_SGLOBAL['supe_uid']) {
	$space = getspace($_SGLOBAL['supe_uid'], 'uid');
}

if($space) {
	
	//ÑéÖ¤¿Õ¼äÊÇ·ñ±»Ëø¶¨
	if($space['flag'] == -1) {
		showmessage('space_has_been_locked');
	}
	
	//ÒþË½¼ì²é
	if(empty($isinvite) || ($isinvite<0 && $code != space_key($space, $_GET['app']))) {
		//ÓÎ¿Í
		if(empty($_SCONFIG['networkpublic'])) {
			checklogin();//ÐèÒªµÇÂ¼
		}
		if(!ckprivacy($do)) {
			include template('space_privacy');
			exit();
		}
	}
	
	//±ðÈËÖ»²é¿´×Ô¼º
	if(!$space['self']) {
		$_GET['view'] = 'me';
	} else if(empty($space['feedfriend']) && empty($_GET['view'])) {
		$_GET['view'] = 'all';
	}
	if ($_GET['view'] == 'me') {
		$space['feedfriend'] = '';
	}
	
} elseif($uid) {

	//ÅÐ¶Ïµ±Ç°ÓÃ»§ÊÇ·ñÉ¾³ý
	$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('spacelog')." WHERE uid='$uid' AND flag='-1'");
	if($value = $_SGLOBAL['db']->fetch_array($query)) {
		showmessage('the_space_has_been_closed');
	}
	
	//Î´¿ªÍ¨¿Õ¼ä
	include_once(S_ROOT.'./uc_client/client.php');
	if($user = uc_get_user($uid, 1)) {
		$space = array('uid' => $user[0], 'username' => $user[1], 'dateline'=>$_SGLOBAL['timestamp'], 'friends'=>array());
		$_SN[$space['uid']] = $space['username'];
	}
}

//ÓÎ¿Í
if(empty($space)) {
	$space = array('uid'=>0, 'username'=>'guest', 'self'=>1);
	if($do == 'index') $do = 'feed';
}

//¸üÐÂ»î¶¯session
if($_SGLOBAL['supe_uid']) {
	
	getmember(); //»ñÈ¡µ±Ç°ÓÃ»§ÐÅÏ¢
	
	if($_SGLOBAL['member']['flag'] == -1) {
		showmessage('space_has_been_locked');
	}
	
	//½ûÖ¹·ÃÎÊ
	if(checkperm('banvisit')) {
		ckspacelog();
		showmessage('you_do_not_have_permission_to_visit');
	}
	
	updatetable('session', array('lastactivity' => $_SGLOBAL['timestamp']), array('uid'=>$_SGLOBAL['supe_uid']));
}

//¼Æ»®ÈÎÎñ
if(!empty($_SCONFIG['cronnextrun']) && $_SCONFIG['cronnextrun'] <= $_SGLOBAL['timestamp']) {
	include_once S_ROOT.'./source/function_cron.php';
	runcron();
}
$zhong = $_SGLOBAL['db']->query("SELECT bf.*, b.* FROM ".tname('appset')." bf $f_index
				LEFT JOIN ".tname('menuset')." b ON bf.num=b.menusetid
				WHERE bf.uid='$_SGLOBAL[supe_uid]' and bf.appstatus='1' and b.style='1'
				ORDER BY bf.orderid ASC ");
while ($wei = $_SGLOBAL['db']->fetch_array($zhong)) {
	
	if($wei['newname']){
				$wei['subject']=$wei['newname'];
			}
			$zhongwei[]=$wei;
}
$zhong1 = $_SGLOBAL['db']->query("SELECT bf.*, b.* FROM ".tname('appset')." bf $f_index
				LEFT JOIN ".tname('menuset')." b ON bf.num=b.menusetid
				WHERE bf.uid='$_SGLOBAL[supe_uid]' and bf.appstatus='1' and b.style='2'
				ORDER BY bf.orderid ASC ");
while ($wei1 = $_SGLOBAL['db']->fetch_array($zhong1)) {
	
	if($wei1['newname']){
				$wei1['subject']=$wei1['newname'];
			}
			$zhongwei1[]=$wei1;
}


	if(empty($_SGLOBAL['supe_uid'])){
		showmessage("请登录后查看","network.php");
	}
//隐藏侧边栏
	$query4 = $_SGLOBAL['db']->query("SELECT * FROM ".tname('appset')." WHERE uid='$_SGLOBAL[supe_uid]' and appstatus='1'");
	$value4 = $_SGLOBAL['db']->fetch_array($query4);
	$zhong1=$value4;


//´¦Àí
include_once(S_ROOT."./source/space_{$do}.php");

?>