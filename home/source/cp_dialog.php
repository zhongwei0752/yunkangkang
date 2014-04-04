<?php

$do = $_GET['op'];
$dialogid = $_GET['dialog'];
//echo $do;
if($do == "delete"){
	if(submitcheck('deletesubmit')) {
		include_once(S_ROOT.'./source/function_delete.php');
		if(deletedialog($dialogid)) {
			showmessage('do_success', "space.php?do=dialog");
		} else {
			showmessage('failed_to_delete_operation');
		}
	}	
	
	include_once template("cp_dialog");

}elseif($do == "delete1"){
	if(submitdelete('deletedial')) {
		include_once(S_ROOT.'./source/function_delete.php');
		if(deletedialogs($dialogid)) {
			showmessage('do_success', "space.php?do=dialog");
		} else {
			showmessage('failed_to_delete_operation');
		}
	}
	else{
		showmessage("wrong");
	}	

	include_once template("cp_dialog");

}elseif($do == "ask"){
	if(submitcheck('dialogsubmit')) {
		$subject = $_POST['subject'];
		$detail = $_POST['message'];
		$askid =  $_GET['askid'];
		$question['subject'] = $subject;
		$question['detail']  = $detail;
		$question['q_uid']   = $space['uid'];
		$question['askid']   = $askid;
		$question['q_dateline'] = time();
		inserttable("questions",$question);
		showmessage("do_success","space.php?do=dialog");
	}	
	include_once template("cp_dialog");
}
else{

	$uid = $_POST['uid'];
	$rid = $_POST['rid'];
	$mes = $_POST['message'];
	$dialogid = $_POST['dialogid'];
	$dateline = time();
	
	$ip = getonlineip();
	
	
	$dialogArr['uid'] = $uid;
	$dialogArr['rid'] = $rid;
	$dialogArr['message'] = $mes;
	$dialogArr['dialogid'] = $dialogid;
	$dialogArr['dialog_dateline'] = $dateline;
	$dialogArr['ip'] = $ip;
	
	inserttable("dialog",$dialogArr);
}
?>