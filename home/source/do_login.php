<?php
/*
	[UCenter Home] (C) 2007-2008 Comsenz Inc.
	$Id: do_login.php 13210 2009-08-20 07:09:06Z liguode $
*/

if(!defined('IN_UCHOME')) {
	exit('Access Denied');
}

include_once(S_ROOT.'./source/function_cp.php');


if($_SGLOBAL['supe_uid']) {
	if ($space['profilestatus']=='0'&&$space['namestatus']=='0'){
		showmessage('enter_the_space', 'cp.php?ac=profile', 0);
	}elseif($space['profilestatus']!='0'&&$space['namestatus']=='0'){
		showmessage('enter_the_space', './template/default/post_ok.htm', 0);
	}elseif($space['profilestatus']=='0'&&$space['namestatus']=='1'&&empty($zhong1)){
		showmessage('enter_the_space', 'space.php?do=menuset', 0);
	}else{
		showmessage('enter_the_space', 'space.php?do=home', 0);
}
}

$refer = empty($_GET['refer'])?rawurldecode($_SCOOKIE['_refer']):$_GET['refer'];
preg_match("/(admincp|do|cp)\.php\?ac\=([a-z]+)/i", $refer, $ms);
if($ms) {
	if($ms[1] != 'cp' || $ms[2] != 'sendmail') $refer = '';
}
if(empty($refer)) {
	$refer = 'space.php?do=home';
}

//ºÃÓÑÑûÇë
$uid = empty($_GET['uid'])?0:intval($_GET['uid']);
$code = empty($_GET['code'])?'':$_GET['code'];
$app = empty($_GET['app'])?'':intval($_GET['app']);
$invite = empty($_GET['invite'])?'':$_GET['invite'];
$invitearr = array();
$reward = getreward('invitecode', 0);
if($uid && $code && !$reward['credit']) {
	$m_space = getspace($uid);
	if($code == space_key($m_space, $app)) {//ÑéÖ¤Í¨¹ý
		$invitearr['uid'] = $uid;
		$invitearr['username'] = $m_space['username'];
	}
	$url_plus = "uid=$uid&app=$app&code=$code";
} elseif($uid && $invite) {
	include_once(S_ROOT.'./source/function_cp.php');
	$invitearr = invite_get($uid, $invite);
	$url_plus = "uid=$uid&invite=$invite";
}

//Ã»ÓÐµÇÂ¼±íµ¥
$_SGLOBAL['nologinform'] = 1;

if(submitcheck('loginsubmit')) {

	$password = $_POST['password'];
	$username = trim($_POST['username']);
	$cookietime = intval($_POST['cookietime']);
	
	$cookiecheck = $cookietime?' checked':'';
	$membername = $username;
	
	if(empty($_POST['username'])) {
		showmessage('users_were_not_empty_please_re_login', 'do.php?ac='.$_SCONFIG['login_action']);
	}
	
	if($_SCONFIG['seccode_login']) {
		include_once(S_ROOT.'./source/function_cp.php');
		if(!ckseccode($_POST['seccode'])) {
			$_SGLOBAL['input_seccode'] = 1;
			include template('do_login');
			exit;
		}
	}

	//Í¬²½»ñÈ¡ÓÃ»§Ô´
	if(!$passport = getpassport($username, $password)) {
		showmessage('login_failure_please_re_login', 'index.php');
	}
	
	$setarr = array(
		'uid' => $passport['uid'],
		'username' => addslashes($passport['username']),
		'password' => md5("$passport[uid]|$_SGLOBAL[timestamp]")//±¾µØÃÜÂëËæ»úÉú³É
	);
	
	include_once(S_ROOT.'./source/function_space.php');
	//¿ªÍ¨¿Õ¼ä
	$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('space')." WHERE uid='$setarr[uid]'");
	if(!$space = $_SGLOBAL['db']->fetch_array($query)) {
		$space = space_open($setarr['uid'], $setarr['username'], 0, $passport['email']);
	}
	
	$_SGLOBAL['member'] = $space;
	
	//ÊµÃû
	realname_set($space['uid'], $space['username'], $space['name'], $space['namestatus']);
	
	//¼ìË÷µ±Ç°ÓÃ»§
	$query = $_SGLOBAL['db']->query("SELECT password FROM ".tname('member')." WHERE uid='$setarr[uid]'");
	if($value = $_SGLOBAL['db']->fetch_array($query)) {
		$setarr['password'] = addslashes($value['password']);
	} else {
		//¸üÐÂ±¾µØÓÃ»§¿â
		inserttable('member', $setarr, 0, true);
	}

	//ÇåÀíÔÚÏßsession
	insertsession($setarr);
	
	//ÉèÖÃcookie
	ssetcookie('auth', authcode("$setarr[password]\t$setarr[uid]", 'ENCODE'), $cookietime);
	ssetcookie('loginuser', $passport['username'], 31536000);
	ssetcookie('_refer', '');
	
	//Í¬²½µÇÂ¼
	if($_SCONFIG['uc_status']) {
		include_once S_ROOT.'./uc_client/client.php';
		$ucsynlogin = uc_user_synlogin($setarr['uid']);
	} else {
		$ucsynlogin = '';
	}
	
	//ºÃÓÑÑûÇë
	if($invitearr) {
		//³ÉÎªºÃÓÑ
		invite_update($invitearr['id'], $setarr['uid'], $setarr['username'], $invitearr['uid'], $invitearr['username'], $app);
	}
	$_SGLOBAL['supe_uid'] = $space['uid'];
	//ÅÐ¶ÏÓÃ»§ÊÇ·ñÉèÖÃÁËÍ·Ïñ
	$reward = $setarr = array();
	$experience = $credit = 0;
	$avatar_exists = ckavatar($space['uid']);
	if($avatar_exists) {
		if(!$space['avatar']) {
			//½±Àø»ý·Ö
			$reward = getreward('setavatar', 0);
			$credit = $reward['credit'];
			$experience = $reward['experience'];
			if($credit) {
				$setarr['credit'] = "credit=credit+$credit";
			}
			if($experience) {
				$setarr['experience'] = "experience=experience+$experience";
			}
			$setarr['avatar'] = 'avatar=1';
			$setarr['updatetime'] = "updatetime=$_SGLOBAL[timestamp]";
		}
	} else {
		if($space['avatar']) {
			$setarr['avatar'] = 'avatar=0';
		}
	}
	
	if($setarr) {
		$_SGLOBAL['db']->query("UPDATE ".tname('space')." SET ".implode(',', $setarr)." WHERE uid='$space[uid]'");
	}
	if($space['namestatus']){
	$query2 = $_SGLOBAL['db']->query("SELECT * FROM ".tname('appset')." where uid=$space[uid] and appstatus='1'");
	$value2 = $_SGLOBAL['db']->fetch_array($query2);
	if(empty($value2)){
	$_POST['refer'] = 'space.php?do=menuset';
	}else{
	$_POST['refer'] = 'space.php?do=home';	
}
}else{
	$_POST['refer'] = 'cp.php?ac=profile';
}
	if(empty($_POST['refer'])) {
		$_POST['refer'] = 'space.php?do=home';
	}
	
	realname_get();
	if ($space['profilestatus']=='0'&&$space['namestatus']=='0'){
		showmessage('login_success', "cp.php?ac=profile", 1, array($ucsynlogin));
	}elseif($space['profilestatus']!='0'&&$space['namestatus']=='0'&&$space['alreadyreg']=='0'){
		showmessage('login_success', "./template/default/post_ok.htm", 1, array($ucsynlogin));
	}elseif($space['profilestatus']=='0'&&$space['namestatus']=='1'&&empty($value2)){
		showmessage('login_success', "space.php?do=menuset", 1, array($ucsynlogin));
	}else{
		//重定向浏览器 
		header("Location: space.php?do=home"); 
		//确保重定向后，后续代码不会被执行 
		exit;
	//showmessage('login_success', $app?"userapp.php?id=$app":$_POST['refer'], 1, array($ucsynlogin));
}
}

$membername = empty($_SCOOKIE['loginuser'])?'':sstripslashes($_SCOOKIE['loginuser']);
$cookiecheck = ' checked';

include template('do_login');

?>