<?php
include_once( 'weibo/config.php' );
require_once '../common.php';
require_once 'wx_common.php';
include_once( CONNECT_ROOT.'/saetv2.ex.class.php' );
require_once CONNECT_ROOT."/common/jtee.inc.php";
require_once CONNECT_ROOT."/common/siteUserRegister.class.php";
require_once('Weixin.class.php');
if($_GET['wxkey']){
	$rst = $_SGLOBAL['db']->query("SELECT * FROM ".tname('wxkey')." WHERE wxkey='$_GET[wxkey]'");
	$row = $_SGLOBAL['db']->fetch_array($rst);
	$rst1 = $_SGLOBAL['db']->query("SELECT * FROM ".tname('space')." WHERE wxkey='$_GET[wxkey]'");
	$row1 = $_SGLOBAL['db']->fetch_array($rst1);
	if($row){
		loaducenter();
		//showmessage("$row[uid]");
		//include_once(S_ROOT.'./source/function_cp.php');
		//updateuserstat('hot');	
		$user = uc_get_user($row['uid'], 1); 
		uc_user_synlogin($row['uid']);
		$auth = setSession($user[0],$user[1]);
		$viewuid=$row['uid'];
		ssetcookie('viewuid',$viewuid, 31536000);			
		
	}elseif($row1){
		loaducenter();
		//showmessage("$row[uid]");
		//include_once(S_ROOT.'./source/function_cp.php');
		//updateuserstat('hot');	
		$user = uc_get_user($row1['uid'], 1); 
		uc_user_synlogin($row1['uid']);
		$auth = setSession($user[0],$user[1]);
		$viewuid=$row1['uid'];
		ssetcookie('viewuid',$viewuid, 31536000);	
	}
}
 $m_auth = getAuth();

 	$uid=$_GET['uid'];
	$table=$_GET['idtype'];

$query1 = $_SGLOBAL['db']->query("SELECT bf.*, b.* FROM ".tname('appset')." bf 
				LEFT JOIN ".tname('menuset')." b ON bf.num=b.menusetid
				WHERE b.english='$table' and bf.uid='$uid'");
			$value1 = $_SGLOBAL['db']->fetch_array($query1);
			if($value1['newname']){
			$appname=$value1['newname'];
			}else{
			$appname=$value1['subject'];

			}
	
$zhong = $_SGLOBAL['db']->query("SELECT bf.*, b.* FROM ".tname('appset')." bf 
				LEFT JOIN ".tname('menuset')." b ON bf.num=b.menusetid
				WHERE bf.uid='$uid' and bf.appstatus='1' and b.style='1'
				ORDER BY bf.orderid ASC ");
while ($wei = $_SGLOBAL['db']->fetch_array($zhong)) {
	if($wei['newname']){
		$wei['subject']=$wei['newname'];
	}
	$zhongwei[]=$wei;

}
$zhong1 = $_SGLOBAL['db']->query("SELECT bf.*, b.* FROM ".tname('appset')." bf 
				LEFT JOIN ".tname('menuset')." b ON bf.num=b.menusetid
				WHERE bf.uid='$uid' and bf.appstatus='1' and b.english='goods' and b.style='2'
				ORDER BY bf.orderid ASC ");
while ($wei1 = $_SGLOBAL['db']->fetch_array($zhong1)) {
	if($wei1['newname']){
		$wei1['subject']=$wei1['newname'];
	}
	$zhongwei1[]=$wei1;

}	
	if($table=="dialog"){
		$zhongwei2=="1";
		$abc = $_SGLOBAL['db']->query("SELECT * FROM ".tname('space')." WHERE uid='$uid'");
		$bac = $_SGLOBAL['db']->fetch_array($abc);
		if($bac['moblieclicknum']=="0"||$bac['moblieclicknum']=="1"||$bac['moblieclicknum']=="3"||$bac['moblieclicknum']=="4"||$bac['moblieclicknum']=="5"||$bac['moblieclicknum']=="6"||$bac['moblieclicknum']=="7"){
		include_once template("./wx/template/dialog");
		}else{
		include_once template("./wx/template/$bac[moblieclicknum]/dialog");
	}
	}elseif($table=="dial"){
		$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('dial')." d LEFT JOIN ".tname('dialfield')." df ON d.dialid=df.dialid where d.status='1' ORDER BY d.dateline DESC");
		$dial = $_SGLOBAL['db']->fetch_array($query);
		$query1 = $_SGLOBAL['db']->query("SELECT * FROM ".tname('dialbuy')." where dialid='$dial[dialid]' ORDER BY dateline DESC");
		while($value1 = $_SGLOBAL['db']->fetch_array($query1)){
			$dialbuy[]=$value1;
		}
		$query2 = $_SGLOBAL['db']->query("SELECT * FROM ".tname('dialbuy')." where dialid='$dial[dialid]' and viewuid='$_COOKIE[uchome_viewuid]'");
		$dialbuy1 = $_SGLOBAL['db']->fetch_array($query2);
		$abc = $_SGLOBAL['db']->query("SELECT * FROM ".tname('space')." WHERE uid='$uid'");
		$bac = $_SGLOBAL['db']->fetch_array($abc);
		if($bac['moblieclicknum']=="0"||$bac['moblieclicknum']=="1"||$bac['moblieclicknum']=="3"||$bac['moblieclicknum']=="4"||$bac['moblieclicknum']=="5"||$bac['moblieclicknum']=="6"||$bac['moblieclicknum']=="7"){
		include_once template("./wx/template/dial");
		}else{
		include_once template("./wx/template/$bac[moblieclicknum]/dial");
	}
	}else{
	$abc = $_SGLOBAL['db']->query("SELECT * FROM ".tname('space')." WHERE uid='$uid'");
	$bac = $_SGLOBAL['db']->fetch_array($abc);
	if($bac['moblieclicknum']=="0"||$bac['moblieclicknum']=="1"||$bac['moblieclicknum']=="3"||$bac['moblieclicknum']=="4"||$bac['moblieclicknum']=="5"||$bac['moblieclicknum']=="6"||$bac['moblieclicknum']=="7"){
		include_once template("./wx/template/feed");
	}else{
		include_once template("./wx/template/$bac[moblieclicknum]/feed");
}
}
?>