<?php
/*
	[UCenter Home] (C) 2007-2008 Comsenz Inc.
	$Id: cp_myweixin.php 13026 2009-08-06 02:17:33Z liguode $
*/
require_once ('./wx/common/jtee.inc.php');
if(!defined('IN_UCHOME')) {
	exit('Access Denied');
}

if($_POST['myweixinsubmit']){
	if(empty($_POST['username'])){
		showmessage("登录名不能为空");
	}
	if(empty($_POST['password'])){
		showmessage("密码不能为空");
	}
	if(empty($_POST['content'])){
		showmessage("选择内容不能为空");
	}
	
	$username = $_POST['username'];
	$name = $_POST['name'];
	$password = $_POST['password'];

	$email = isemail($_REQUEST['email']) ? $_REQUEST['email'] : $username."@v5.com.cn";

	$data = array();

	require_once('./source/siteUserRegister.class.php');

		 $regClass = new siteUserRegister();

		$uid = $regClass->reg($username, $email, $password);

		if (empty($uid))showmessage("授权失败");
		$msg = '';
		switch($uid){
			case -1:
				$msg = '用户名无效';
				showmessage($msg);
				break;
			case -2:
				$msg = '用户名包含敏感词';
				showmessage($msg);
				break;
			case -3:
				$msg = '用户名已经存在';
				showmessage($msg);
				break;
			case -4:
				$msg = '邮箱格式不正确';
				showmessage($msg);
				break;
			case -5:
				$msg = '此网站邮箱注册受限';
				showmessage($msg);
				break;
			case -6:
				$msg = '邮箱已经存在';
				showmessage($msg);
				break;
			case -7:
				$msg = '发生未知错误';	
				showmessage($msg);
				break;
			default:
				
					$setarr = array(
						'name' => $name,
						'namestatus' => '1',
						'userstatus' => '3',
						'fatheruid' => $_SGLOBAL['supe_uid']
					);
					updatetable('space', $setarr, array('uid'=>$uid ));
				
				}
			
				$user = uc_get_user($uid, 1); 
				$friendurl = "http://v5.home3d.cn/home/capi/cp.php?ac=friend&op=add&uid=$_SGLOBAL[supe_uid]&gid=0&addsubmit=true&note=客服";
        		$friend = file_get_contents($friendurl,0,null,null);
        		$friend_output = json_decode($friend);

	
	$a=array();
	$a=$_POST['content'];
	foreach ($a as $k=>$v){ 
	$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('menuset')." where english='$v'");
	$value = $_SGLOBAL['db']->fetch_array($query);
	if($value){

	updatetable('appset',array('childrenid'=>$uid), array('uid'=>$_SGLOBAL['supe_uid'],'num'=>$value['menusetid']));

	}
	
} 
showmessage("添加成功","space.php?do=myweixin&view=me");
}
$query2 = $_SGLOBAL['db']->query("SELECT a.*, m.* FROM ".tname('appset')." a LEFT JOIN ".tname('menuset')." m ON a.num=m.menusetid where a.uid='$_SGLOBAL[supe_uid]' and (m.style='1' || m.english='goods')");
while($value2 = $_SGLOBAL['db']->fetch_array($query2)){
	$list[]=$value2;
}
include_once template("cp_myweixin");

?>