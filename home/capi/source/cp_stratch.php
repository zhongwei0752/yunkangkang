<?php
/*
	[UCenter Home] (C) 2007-2008 Comsenz Inc.
	$Id: cp_debate.php 10978 2009-01-14 02:39:06Z liguode $
*/
if(!defined('IN_UCHOME')) {
	exit('Access Denied');
}

//检查信息
$stratchid = empty($_REQUEST['stratchid'])?0:intval($_REQUEST['stratchid']);
$op = empty($_REQUEST['op'])?'':$_REQUEST['op'];

$stratch = array();
if($stratchid) {
	$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('stratch')." 
		WHERE stratchid='$stratchid'");
	$stratch = $_SGLOBAL['db']->fetch_array($query);
	$stratch['endtime']=sgmdate('Y-m-d H:i',$stratch['endtime']);
}

//统计是否已参加该辩论 add by xianyima 2009.4.16
//	$query = $_SGLOBAL['db']->query("SELECT uid,jstratchid FROM ".tname('stratch_concern')." WHERE uid ='$_SGLOBAL[supe_uid]'");
  //  $joined=$_SGLOBAL['db']->fetch_array($query);

//权限检查
if(empty($stratch)) {
	
	/*if(!checkperm('allowstratch')) {
		capi_showmessage_by_data('你没有发布的权限');
	}*/
	
	//实名认证
	ckrealname('blog');
	
	//新用户见习
	cknewuser();
	
	//判断是否发布太快
	$waittime = interval_check('post');
	if($waittime > 0) {
		capi_showmessage_by_data('operating_too_fast','',1,array($waittime));
	}
	$stratch['umpire']=$_SGLOBAL['supe_username'];
	
	//接收外部标题
	$stratch['subject'] = empty($_REQUEST['subject'])?'':getstr($_REQUEST['subject'], 150, 1, 0);
	$stratch['message'] = empty($_REQUEST['message'])?'':getstr($_REQUEST['message'], 5000, 1, 0);
	
} 



//添加编辑操作
if(submitcheck('stratchsubmit')) {
	if(empty($stratch['stratchid'])) $stratch = array();
	
	//验证码
	if(checkperm('seccode') && !ckseccode($_REQUEST['seccode'])) {
		capi_showmessage_by_data('incorrect_code');
	}
	
	//结束时间
	if(!$stratchid){
	if(sstrtotime($_REQUEST['endtime'])<$_SGLOBAL['timestamp']) {
		capi_showmessage_by_data('结束时间不能小于当前时间');
	}
	}
	
	include_once(S_ROOT.'./source/function_stratch.php');
	if($stratch = stratch_post($_REQUEST, $stratch)) {
		capi_showmessage_by_data('do_success', 'space.php?uid='.$stratch['uid'].'&do=stratch&id='.$stratch['stratchid'], 0);
	} else {
		capi_showmessage_by_data('that_should_at_least_write_things');
	}
}


if($_REQUEST['op'] == 'delete') {
	//删除
	
	if(submitcheck('deletesubmit')) {
		include_once(S_ROOT.'./source/function_delete.php');
		if(deletestratchs(array($stratchid))) {
			capi_showmessage_by_data('do_success', "space.php?uid=$stratch[uid]&do=stratch&view=me");
		} else {
			capi_showmessage_by_data('failed_to_delete_operation');
		}
	}
	
}else {
	//添加编辑
	//获取相册
	$albums = getalbums($_SGLOBAL['supe_uid']);
	$stratch['message'] = str_replace('&amp;', '&amp;amp;', $stratch['message']);
	$stratch['message'] = shtmlspecialchars($stratch['message']);
	
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

include_once template("cp_stratch");

?>