<?php

$do = $_REQUEST['op'];
$dialogid = $_REQUEST['dialog'];

if($do == "delete"){
	if(submitcheck('deletesubmit')) {
		include_once(S_ROOT.'./source/function_delete.php');
		if(deletedialog($dialogid)) {
			showmessage('do_success', "space.php?do=communicate");
		} else {
			showmessage('failed_to_delete_operation');
		}
	}	
	
	include_once template("cp_dialog");
}elseif($do == "ask"){
	
		$subject = $_REQUEST['subject'];
		$q_uid = $_REQUEST['q_uid'];
		$askid =  $_REQUEST['askid'];
		$question['subject'] = $subject;
		$question['detail']  = $detail;
		$question['q_uid']   = $q_uid;
		$question['askid']   = $askid;
		$question['q_dateline'] = $_SGLOBAL['timestamp'];
		//var_dump($question);
		$id=inserttable("questions",$question,1);
		include_once(S_ROOT.'./wx/wx_common.php');
		include_once(S_ROOT.'./wx/Weixin.class.php');
		$wei=getspace($askid);
		$weifakeid=$wei['service'];
		$zhong=getspace($weifakeid);
		$fakeid=$zhong['fakeid'];
		$message="有客户向你留言 
		$subject,
		<a href='http://v5.home3d.cn/home/wx/wx.php?do=detail&id=$id&uid=$askid&viewuid=$q_uid&cheak=1&idtype=dialogid&type=dialog'>点此进行回复</a>";
		$d = get_obj_by_xiaoquid($askid);
		$info = $d->sendWXSingleMsg($fakeid,$message);
		echo "ok";
		
	//include_once template("cp_dialog");
}
else{
	$uid = $_REQUEST['uid'];
	$rid = $_REQUEST['rid'];
	$mes = $_REQUEST['message'];
	$dialogid = $_REQUEST['dialogid'];
	$dateline = $_SGLOBAL['timestamp'];
	
	$ip = getonlineip();
	
	$status=$_REQUEST['status'];
	if($status=='1'){
	$dialogArr['nameuid'] = $uid;
	}elseif($status=='2'){
	$dialogArr['nameuid'] = $rid;
	$dialogArr['cheak'] = '1';
	}elseif($status=='4'){
	$dialogArr['nameuid'] = $uid;	
	}else{
	$dialogArr['nameuid'] = '3';		
	
	}
	$dialogArr['status'] = $status;
	$dialogArr['uid'] = $uid;
	$dialogArr['rid'] = $rid;
	$dialogArr['message'] = $mes;
	$dialogArr['dialogid'] = $dialogid;
	$dialogArr['dialog_dateline'] = $_SGLOBAL['timestamp']+8*60*60;
	$dialogArr['ip'] = $ip;
	//echo "string";
	inserttable("dialog",$dialogArr);
	$status=$_REQUEST['status'];
	if($status=='1'){
		include_once(S_ROOT.'./wx/wx_common.php');
		include_once(S_ROOT.'./wx/Weixin.class.php');
		$wei=getspace($rid);
		$weifakeid=$wei['service'];
		$zhong=getspace($weifakeid);
		$fakeid=$zhong['fakeid'];
		$zhongwei=getspace($uid);
		$message="【$zhongwei[name]回复】
		$mes
		<a href='http://v5.home3d.cn/home/wx/wx.php?do=detail&id=$dialogid&uid=$rid&wxkey=$zhong[wxkey]&viewuid=$uid&cheak=1&idtype=dialogid&type=dialog'>点此进行回复</a>";
		$d = get_obj_by_xiaoquid($rid);
		$info = $d->sendWXSingleMsg($fakeid,$message);	
	}
	if($status=='2'){
		include_once(S_ROOT.'./wx/wx_common.php');
		include_once(S_ROOT.'./wx/Weixin.class.php');
		$zhong=getspace($uid);
		$fakeid=$zhong['fakeid'];
		$zhongwei=getspace($rid);
		$message="【$zhongwei[name]回复】
		$mes
		<a href='http://v5.home3d.cn/home/wx/wx.php?do=detail&id=$dialogid&uid=$rid&wxkey=$zhong[wxkey]&viewuid=$uid&cheak=1&idtype=dialogid&type=dialog'>点此进行回复</a>";
		$d = get_obj_by_xiaoquid($rid);
		$info = $d->sendWXSingleMsg($fakeid,$message);	
	}
}
?>