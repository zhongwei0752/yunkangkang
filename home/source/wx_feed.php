<?php

include_once( 'weibo/config.php' );
require_once '../common.php';
require_once 'wx_common.php';
require_once "Weixin.class.php";
include_once( CONNECT_ROOT.'/saetv2.ex.class.php' );
require_once CONNECT_ROOT."/common/jtee.inc.php";
require_once CONNECT_ROOT."/common/siteUserRegister.class.php";


	
	$rst = $_SGLOBAL['db']->query("SELECT * FROM ".tname('space')." WHERE wxkey='$_GET[wxkey]'");
	$row = $_SGLOBAL['db']->fetch_array($rst);
	if($row){
		/*$sql = "SELECT uid FROM ".tname('space')." WHERE `wxkey`='".$_GET['wxkey']."'";  
				$user = $_SGLOBAL['db']->fetch_array($_SGLOBAL['db']->query($sql));
				if($user){
					$sinauid=$uid_get['uid'];
					$d = get_obj_by_xiaoquid($user);
					$info = $d->getNewWXUser();
					wxshowmessage("$info[nickname]", "http://v5.home3d.cn/v5/v5/home/index.php");*/
				
			
		loaducenter();
			
		$user = uc_get_user($row['uid'], 1); 
		uc_user_synlogin($row['uid']);
		$auth = setSession($user[0],$user[1]);
		$weixinuid=$_GET['uid'];
		$m_auth=rawurlencode($auth);
		$friendurl = "http://v5.home3d.cn/v5/v5/home/capi/cp.php?ac=friend&op=add&uid=$weixinuid&gid=0&addsubmit=true&note=微信用户关注&m_auth=$m_auth";
       $friend = file_get_contents($friendurl,0,null,null);
        $friend_output = json_decode($friend);

        $d = get_obj_by_xiaoquid($row['uid']);

		$info = $d->getNewWXUser();
		wxshowmessage("123");
       

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

					
					
				}
				
				$d = get_obj_by_xiaoquid($user);

					$info = $d->getNewWXUser();
print_r($info);
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

}	
 $m_auth = getAuth();

 	$uid=$_GET['uid'];
	$table=$_GET['idtype'];
$query1 = $_SGLOBAL['db']->query("SELECT * FROM ".tname('menuset')."
				WHERE english='$table'");
$value1 = $_SGLOBAL['db']->fetch_array($query1);
$appname=$value1['subject'];
	
$zhong = $_SGLOBAL['db']->query("SELECT bf.*, b.* FROM ".tname('appset')." bf 
				LEFT JOIN ".tname('menuset')." b ON bf.num=b.menusetid
				WHERE bf.uid='$uid' and bf.appstatus='1'
				ORDER BY bf.orderid ASC ");
while ($wei = $_SGLOBAL['db']->fetch_array($zhong)) {
	$zhongwei[]=$wei;

}	




	/*$abc = $_SGLOBAL['db']->query("SELECT * FROM ".tname('space')." WHERE uid='$uid'");
	$bac = $_SGLOBAL['db']->fetch_array($abc);
	if($bac['moblieclicknum']=='1'){
		include_once template("./wx/template/1/feed");
	}else{
	include_once template("./wx/template/feed");
}*/

//根据小区id获得微信类的实例对象。此函数一般是为了被其他函数调用
function get_obj_by_xiaoquid($xiaoquid){
	global $_SGLOBAL;
	$query = $_SGLOBAL['db']->query("select * from ".tname('space')." where uid='$xiaoquid'  ");
	$value = $_SGLOBAL['db']->fetch_array($query);
	if($value){
		//$d = new Weixin($value['weixin_account'], $value['weixin_pwd']);
		
		$d = new Weixin("623610577@qq.com", "2316663");
		 
		if($d)return $d;
	}
	return false;
}

?>