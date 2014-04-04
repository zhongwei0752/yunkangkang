<?php
include_once( 'weibo/config.php' );
require_once '../common.php';
require_once 'wx_common.php';
include_once( CONNECT_ROOT.'/saetv2.ex.class.php' );
require_once CONNECT_ROOT."/common/jtee.inc.php";
require_once CONNECT_ROOT."/common/siteUserRegister.class.php";
require_once('Weixin.class.php');

	$rst = $_SGLOBAL['db']->query("SELECT * FROM ".tname('space')." WHERE wxkey='$_GET[wxkey]'");
	$row = $_SGLOBAL['db']->fetch_array($rst);
	if($row){
		loaducenter();
			
		$user = uc_get_user($row['uid'], 1); 
		uc_user_synlogin($row['uid']);
		$auth = setSession($user[0],$user[1]);
		$weixinuid=$_GET['uid'];
		$m_auth=rawurlencode($auth);
		$friendurl = "http://v5.home3d.cn/home/capi/cp.php?ac=friend&op=add&uid=$weixinuid&gid=0&addsubmit=true&note=微信用户关注&m_auth=$m_auth";
        $friend = file_get_contents($friendurl,0,null,null);
        $friend_output = json_decode($friend);
		
		
}else{

	$username = $_GET['wxkey'];
	$name = $_GET['wxkey'];
	$password = "weixin";

	$email = isemail($_REQUEST['email']) ? $_REQUEST['email'] : $username."@v5.com.cn";

	$data = array();


	 require_once CONNECT_ROOT."/common/siteUserRegister.class.php";
		 $regClass = new siteUserRegister();
		$uid = $regClass->reg($username, $email, $password);
		if (empty($uid))wxshowmessage("授权失败");
		$msg = '';
		switch($uid){
			case -1:
				$msg = '用户名无效';
				wxshowmessage($msg);
				break;
			case -2:
				$msg = '用户名包含敏感词';
				wxshowmessage($msg);
				break;
			case -3:
				$msg = '用户名已经存在';
				wxshowmessage($msg);
				break;
			case -4:
				$msg = '邮箱格式不正确';
				wxshowmessage($msg);
				break;
			case -5:
				$msg = '此网站邮箱注册受限';
				wxshowmessage($msg);
				break;
			case -6:
				$msg = '邮箱已经存在';
				wxshowmessage($msg);
				break;
			case -7:
				$msg = '发生未知错误';	
				wxshowmessage($msg);
				break;
			default:
				$sql = "SELECT * FROM ".tname('space')." WHERE `wxkey`='".$_GET['wxkey']."'";  
				$user = $_SGLOBAL['db']->fetch_array($_SGLOBAL['db']->query($sql));
				if($user){
					$sinauid=$uid_get['uid'];
					wxshowmessage("已绑定", "http://v5.home3d.cn/home/index.php");
					
				}
				$d = get_obj_by_xiaoquid($uid);
					$info = $d->getNewWXUser();	
					$setarr = array(
						'name' => $info['nickName'],
						'fakeid'=>$info['fakeId'],
						'namestatus' => '1',
						'wxkey' => $_GET['wxkey']
					);
					updatetable('space', $setarr, array('uid'=>$uid ));
				
				}
				loaducenter();
			
				$user = uc_get_user($uid, 1); 
				uc_user_synlogin($uid);
				$weixinuid=$_GET['uid'];
				$auth = setSession($user[0],$user[1]);
				$m_auth=rawurlencode($auth);
				$friendurl = "http://v5.home3d.cn/home/capi/cp.php?ac=friend&op=add&uid=$weixinuid&gid=0&addsubmit=true&note=微信用户关注&m_auth=$m_auth";
        		$friend = file_get_contents($friendurl,0,null,null);
        		$friend_output = json_decode($friend);

}	
$result = 0;

/*$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('space')." WHERE wxkey='$_GET[wxkey]'");

if ($_SGLOBAL['db']->fetch_array($query)){
	$result = 1;
}else{
	if (isset($_COOKIE['uchome_m_auth'])) 
	{
		$result = 1;
	}else{
		$result = 0;
	}
}*/

if ($_GET["op"]=="add"){

	include_once S_ROOT.'./uc_client/client.php';

	$username = empty($_POST['username']) ? '' : trim($_POST['username']);
	$password = empty($_POST['password']) ? '' : trim($_POST['password']);


	if(empty($username) || empty($password)) {
		// showmessage('users_were_not_empty_please_re_login',  'wx.php?do=bind&wxkey='.$_POST['wxkey']);
		$result = -1;
		include_once template("./wx/template/bind");
		exit;
	}

	// 登陆验证
	if(!$passport = getpassport($username, $password)) {
		
		// showmessage('login_failure_please_re_login',  'wx.php?do=bind&wxkey='.$_POST['wxkey']);
		$result = -1;
		include_once template("./wx/template/bind");
		exit;
	}
	if($row['uid']){
	$newid=	$row['uid'];
	}else{
	$newid=	$uid;
	}
	
	$newquery = $_SGLOBAL['db']->query("SELECT * FROM ".tname('space')." WHERE uid='$newid'");
	$newvalue = $_SGLOBAL['db']->fetch_array($newquery);
	// unbind
	updatetable('space', array('wxkey'=>$newvalue['wxkey'],'userstatus'=>'3','fakeid'=>$newvalue['fakeid']), array('uid'=>$passport['uid']));
	$query2=$_SGLOBAL['db']->query("DELETE FROM ".tname('space')." WHERE uid='$newid'");
	$value2 = $_SGLOBAL['db']->fetch_array($query2);
	$result = 1;

}

include_once template("./wx/template/bind");

?>