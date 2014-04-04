<?php
include_once( 'weibo/config.php' );
require_once '../common.php';
require_once 'wx_common.php';
include_once( CONNECT_ROOT.'/saetv2.ex.class.php' );
require_once CONNECT_ROOT."/common/jtee.inc.php";
require_once CONNECT_ROOT."/common/siteUserRegister.class.php";

	$rst = $_SGLOBAL['db']->query("SELECT * FROM ".tname('space')." WHERE wxkey='$_GET[wxkey]'");
	$row = $_SGLOBAL['db']->fetch_array($rst);
	if($row){
		loaducenter();
			
		$user = uc_get_user($row['uid'], 1); 
		uc_user_synlogin($row['uid']);
		$auth = setSession($user[0],$user[1]);
		$weixinuid=$_GET['uid'];
		$m_auth=rawurlencode($auth);
		$friendurl = "http://v5.home3d.cn/v5/v5/home/capi/cp.php?ac=friend&op=add&uid=$weixinuid&gid=0&addsubmit=true&note=微信用户关注&m_auth=$m_auth";
        $friend = file_get_contents($friendurl,0,null,null);
        $friend_output = json_decode($friend);
		wxshowmessage("快捷登录成功","http://v5.home3d.cn/v5/v5/home/wx/wx.php?do=home&uid=$weixinuid");
}else{

	$username = $_GET['wxkey'];
	$name = "微信用户".$_GET['wxkey'];
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
				$sql = "SELECT uid FROM ".tname('space')." WHERE `wxkey`='".$_GET['wxkey']."'";  
				$user = $_SGLOBAL['db']->fetch_array($_SGLOBAL['db']->query($sql));
				if($user){
					$sinauid=$uid_get['uid'];
					wxshowmessage("已绑定", "http://v5.home3d.cn/v5/v5/home/index.php");
				}
				
				
			$setarr = array(
						'name' => getstr($name, 30, 1, 1, 1),
						'namestatus' => $_SCONFIG['namecheck']?0:1,
						'wxkey' => $_GET['wxkey']
					);
					updatetable('space', $setarr, array('uid'=>$uid ));
				}
				$weixinuid=$_GET['uid'];
				$auth = setSession($user[0],$user[1]);
				$m_auth=rawurlencode($auth);
				$friendurl = "http://v5.home3d.cn/v5/v5/home/capi/cp.php?ac=friend&op=add&uid=$weixinuid&gid=0&addsubmit=true&note=微信用户关注&m_auth=$m_auth";
        		$friend = file_get_contents($friendurl,0,null,null);
        		$friend_output = json_decode($friend);
				wxshowmessage("快捷注册成功","http://v5.home3d.cn/v5/v5/home/wx/wx.php?do=home&uid=$weixinuid");

}
?>