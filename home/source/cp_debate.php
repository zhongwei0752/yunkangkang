<?php
/*
	[UCenter Home] (C) 2007-2008 Comsenz Inc.
	$Id: cp_debate.php 10978 2009-01-14 02:39:06Z liguode $
*/

if(!defined('IN_UCHOME')) {
	exit('Access Denied');
}

//检查信息
$debateid = empty($_GET['debateid'])?0:intval($_GET['debateid']);
$op = empty($_GET['op'])?'':$_GET['op'];

$debate = array();
if($debateid) {
	$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('debate')." 
		WHERE debateid='$debateid'");
	$debate = $_SGLOBAL['db']->fetch_array($query);
	$debate['endtime']=sgmdate('Y-m-d H:i',$debate['endtime']);
	$obvoteuids=empty($debate['obvoteuids'])?array():explode(',',$debate['obvoteuids']);
	$revoteuids=empty($debate['revoteuids'])?array():explode(',',$debate['revoteuids']);
}
//统计是否已参加该辩论 add by xianyima 2009.4.16
	$query = $_SGLOBAL['db']->query("SELECT uid,jdebateid FROM ".tname('debate_concern')." WHERE uid ='$_SGLOBAL[supe_uid]'");
    $joined=$_SGLOBAL['db']->fetch_array($query);

//权限检查
if(empty($debate)) {
	/*if(!checkperm('allowdebate')) {
		showmessage('你没有发布辩论的权限');
	}*/
	
	//实名认证
	ckrealname('blog');
	
	//新用户见习
	cknewuser();
	
	//判断是否发布太快
	$waittime = interval_check('post');
	if($waittime > 0) {
		showmessage('operating_too_fast','',1,array($waittime));
	}
	$debate['umpire']=$_SGLOBAL['supe_username'];
	
	//接收外部标题
	$debate['subject'] = empty($_GET['subject'])?'':getstr($_GET['subject'], 150, 1, 0);
	$debate['message'] = empty($_GET['message'])?'':getstr($_GET['message'], 5000, 1, 0);
	
} else {
	if($_GET['op'] != 'opvote' && $_GET['op'] != 'revote' && $_SGLOBAL['supe_uid'] != $debate['uid'] && !checkperm('managedebate')) {
		showmessage('no_authority_operation_of_the_log');
	}
}

//添加编辑操作
if(submitcheck('debatesubmit')) {
	if(empty($debate['debateid'])) $debate = array();
	
	//验证码
	if(checkperm('seccode') && !ckseccode($_POST['seccode'])) {
		showmessage('incorrect_code');
	}
	//结束时间
	if(!$debateid){
	if(sstrtotime($_POST['endtime'])<$_SGLOBAL['timestamp']) {
		showmessage('结束时间不能小于当前时间');
	}
	}
	
	//裁判
	$umpire=getstr(trim($_POST['umpire']), 16, 1, 1, 1);
	if($umpire) {
	  $count = $_SGLOBAL['db']->result($_SGLOBAL['db']->query("SELECT COUNT(*) FROM ".tname('space')." where username='$umpire'"),0);
	  if(!$count){
		showmessage('裁判不能是非注册会员！');
		}
	}
	
	include_once(S_ROOT.'./source/function_debate.php');
	if($debate = debate_post($_POST, $debate)) {
		showmessage('do_success', 'space.php?uid='.$debate['uid'].'&do=debate&id='.$debate['debateid'], 0);
	} else {
		showmessage('that_should_at_least_write_things');
	}
}


if($_GET['op'] == 'delete') {
	//删除
	
	if(submitcheck('deletesubmit')) {
		include_once(S_ROOT.'./source/function_delete.php');
		if(deletedebates(array($debateid))) {
			showmessage('do_success', "space.php?uid=$debate[uid]&do=debate&view=me");
		} else {
			showmessage('failed_to_delete_operation');
		}
	}
	
}elseif($_GET['op'] == 'opvote') {
	//支持正方
  if(submitcheck('opvotesubmit')) {
	 if(!in_array($_SGLOBAL['supe_uid'],$obvoteuids)){
     array_push($obvoteuids,$_SGLOBAL['supe_uid']);
     updatetable('debate', array('obvoteuids'=>implode(',',$obvoteuids),'obvote'=>$debate['obvote']+1),array('debateid'=>$debateid));
	}
	if(!$joined['uid']){
	  inserttable('debate_concern', array('uid'=>$_SGLOBAL['supe_uid'],'jdebateid'=>$debateid));
	 }else{
	  $jdebateids=array_filter(explode(',',$joined['jdebateid']));
      array_push($jdebateids,$debateid);
      updatetable('debate_concern', array('jdebateid'=>implode(',',$jdebateids)),array('uid'=>$_SGLOBAL['supe_uid']));
	 }
	showmessage('do_success', $_POST['refer'], 0);
	}
} elseif($_GET['op'] == 'revote') {
	//支持反方
	if(submitcheck('revotesubmit')) {
	 if(!in_array($_SGLOBAL['supe_uid'],$revoteuids)){
     array_push($revoteuids,$_SGLOBAL['supe_uid']);
     updatetable('debate', array('revoteuids'=>implode(',',$revoteuids),'revote'=>$debate['revote']+1),array('debateid'=>$debateid));
	}
	 if(!$joined['uid']){
	  inserttable('debate_concern', array('uid'=>$_SGLOBAL['supe_uid'],'jdebateid'=>$debateid));
	 }else{
	  $jdebateids=array_filter(explode(',',$joined['jdebateid']));
      array_push($jdebateids,$debateid);
      updatetable('debate_concern', array('jdebateid'=>implode(',',$jdebateids)),array('uid'=>$_SGLOBAL['supe_uid']));
	 }
	showmessage('do_success', $_POST['refer'], 0);
	}
	
}elseif($_GET['op'] == 'judgedebate') {
	//裁判点评
	$debatear = array();
	$query = $_SGLOBAL['db']->query("select author,sum(vote) as vote from ".tname('debate_comment')." where debateid='$debateid' group by authorid order by vote");
	while($value=$_SGLOBAL['db']->fetch_array($query)){
	  $debatear[]=$value;
	}
   if(submitcheck('judgedebatesubmit')) {
    $judge=intval($_POST['judge']);
    $debater=getstr(trim($_POST['debater']), 16, 1, 1, 1);
	//内容
	$umpirepoint= checkhtml($_POST['umpirepoint']);
	$umpirepoint= getstr($umpirepoint, 0, 1, 0, 1, 0, 1);
	$umpirepoint = preg_replace("/\<div\>\<\/div\>/i", '', $umpirepoint);	
	$umpirepoint = addslashes($umpirepoint);
	$debatearr=array(
	'umpirepoint'=>$umpirepoint
	);
	if($judge){
	$debatearr['judge']=$judge;
	}
	if($debater){
	$debatearr['debater']=$debater;
	}
	updatetable('debate',$debatearr,array('debateid'=>$debateid));
	showmessage('do_success', $_POST['refer'], 0);
    }
	
}else {
	//添加编辑
	//获取相册
	$albums = getalbums($_SGLOBAL['supe_uid']);
	$debate['message'] = str_replace('&amp;', '&amp;amp;', $debate['message']);
	$debate['message'] = shtmlspecialchars($debate['message']);
	
	$allowhtml = checkperm('allowhtml');

	//菜单激活
	$menuactives = array('space'=>' class="active"');
}


//屏蔽html
function checkhtml($html) {
	$html = stripslashes($html);
	if(!checkperm('allowhtml')) {
		
		preg_match_all("/\<([^\<]+)\>/is", $html, $ms);

		$searchs[] = '<';
		$replaces[] = '&lt;';
		$searchs[] = '>';
		$replaces[] = '&gt;';
		
		if($ms[1]) {
			$allowtags = 'img|a|font|div|table|tbody|caption|tr|td|br|p|b|strong|i|u|em|span|ol|ul|li|blockquote|object|param|embed';//允许的标签
			$ms[1] = array_unique($ms[1]);
			foreach ($ms[1] as $value) {
				$searchs[] = "&lt;".$value."&gt;";
				$value = shtmlspecialchars($value);
				$value = str_replace(array('\\','/*'), array('.','/.'), $value);
				$value = preg_replace(array("/(javascript|script|eval|behaviour|expression)/i", "/(\s+|&quot;|')on/i"), array('.', ' .'), $value);
				if(!preg_match("/^[\/|\s]?($allowtags)(\s+|$)/is", $value)) {
					$value = '';
				}
				$replaces[] = empty($value)?'':"<".str_replace('&quot;', '"', $value).">";
			}
		}
		$html = str_replace($searchs, $replaces, $html);
	}
	$html = addslashes($html);
	
	return $html;
}

include_once template("cp_debate");

?>