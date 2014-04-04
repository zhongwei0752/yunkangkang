<?php
require_once('./wx/Weixin.class.php');
if($_POST["alreadyweixin"]=="1"){
	
	$username=$_POST['weixinusername'];
	$password=$_POST['weixinpassword'];
	if(empty($username)||empty($password)){
		showmessage("登陆帐号密码不能为空","space.php?do=menuset");
	}
	$d = new Weixin("$username", "$password");
	$info = $d->getUser();
	$token = $d->GetId();
	$usermore=$d->get_userinfo_by_fakeid($info);
	if(empty($token[0])){
		showmessage("未能正确获取到微信公众号信息，请确认帐号密码是否填写正确.","space.php?do=menuset");
	}else{	
	$token[0]=trim($token[0]);
	updatetable("space", array('fakeid'=>$info,'weixinname'=>$usermore['NickName'],'weixinhao'=>$usermore['Username'],'wxkey'=>$token[0],'weixinusername'=>$username,'weixinpassword'=>$password),array('uid'=>$_SGLOBAL['supe_uid']));
	showmessage("提交成功","space.php?do=menuset");
	}
}
if($_POST["newweixin"]=="1"){

		$username=$_POST['username'];
		$password=$_POST['password'];
		$fakeid=$_POST['fakeid'];
		$wxkey=$_POST['wxkey'];
		$id=$_POST['id'];
		updatetable("space", array('weixinusername'=>$username,'weixinpassword'=>$password,'fakeid'=>$fakeid,'wxkey'=>$wxkey),array('uid'=>$_SGLOBAL['supe_uid']));
		updatetable("weixin", array('cheakid'=>'0'),array('id'=>$id));
		showmessage("提交成功","space.php?do=menuset");
}
		

?>