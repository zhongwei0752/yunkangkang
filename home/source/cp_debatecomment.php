<?php
/*
	[UCenter Home] (C) 2007-2008 Comsenz Inc.
	$Id: cp_comment.php 8338 2008-08-04 06:09:51Z liguode $
*/

if(!defined('IN_UCHOME')) {
	exit('Access Denied');
}

include_once(S_ROOT.'./source/function_bbcode.php');


//共用变量
$tospace = $debate = array();

if(submitcheck('commentsubmit')) {

	if(!checkperm('allowcomment')) {
		showmessage('no_privilege');
	}
	//实名认证
	ckrealname('comment');

	//判断是否发布太快
	$waittime = interval_check('post');
	if($waittime > 0) {
		showmessage('operating_too_fast','',1,array($waittime));
	}

	$message = getstr($_POST['message'], 0, 1, 1, 1, 2);
	if(strlen($message) < 2) {
		showmessage('content_is_too_short');
	}

	//摘要
	$summay = getstr($message, 150, 1, 1, 0, 0, -1);

	$id = intval($_POST['id']);

	//引用评论
	$cid = empty($_POST['cid'])?0:intval($_POST['cid']);
	$comment = array();
	if($cid) {
		$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('debate_comment')." WHERE cid='$cid' AND debateid='$id' AND debatetype='$_POST[debatetype]'");
		$comment = $_SGLOBAL['db']->fetch_array($query);
		if($comment && $comment['authorid'] != $_SGLOBAL['supe_uid']) {
			//实名
			realname_set($comment['authorid'], $comment['username']);
			realname_get();
			$comment['message'] = preg_replace("/\<div class=\"quote\"\>\<span class=\"q\"\>.*?\<\/span\>\<\/div\>/is", '', $comment['message']);
			//bbcode转换
			$comment['message'] = html2bbcode($comment['message']);
			$message = addslashes("<div class=\"quote\"><span class=\"q\"><b>".$_SN[$comment['authorid']]."</b>: ".getstr($comment['message'], 150, 0, 0, 0, 2).'</span></div>').$message;
		} else {
			$comment = array();
		}
	}

	//读取辩论
		$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('debate')."  WHERE debateid='$id'");
			$debate = $_SGLOBAL['db']->fetch_array($query);
			//辩论不存在
			if(empty($debate)) {
				showmessage('view_to_info_debateid_not_exist');
			}
			//检索空间
			$tospace = getspace($debate['uid']);
			
	//更新辩论
	 $obvoteuids=empty($debate['obvoteuids'])?array():explode(',',$debate['obvoteuids']);
	 $revoteuids=empty($debate['revoteuids'])?array():explode(',',$debate['revoteuids']);
	 if(in_array($_SGLOBAL['supe_uid'],$revoteuids)){
	 $debatetype=1;
	 }elseif(in_array($_SGLOBAL['supe_uid'],$obvoteuids)){
	 $debatetype=0;
	 }else{
	 $debatetype = empty($_POST['debatetype'])?0:intval($_POST['debatetype']);
	 }
			
	//读取关注表数据
     $query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('debate_concern')."  WHERE uid='$_SGLOBAL[supe_uid]'");
	 $concern = $_SGLOBAL['db']->fetch_array($query);
	//事件信息
	$fs = array();
	$fs['icon'] = 'comment';
	$fs['target_ids'] = $fs['friend'] = '';
			//更新评论统计
			if($debatetype){
			$_SGLOBAL['db']->query("UPDATE ".tname('debate')." SET rereplynum=rereplynum+1 WHERE debateid='$id'");
			}else{
			$_SGLOBAL['db']->query("UPDATE ".tname('debate')." SET obreplynum=obreplynum+1 WHERE debateid='$id'");
			}
			
			//事件
			$fs['title_template'] = cplang('feed_comment_blog');
			$fs['title_data'] = array('touser'=>"<a href=\"space.php?uid=$tospace[uid]\">".$_SN[$tospace['uid']]."</a>", 'blog'=>"<a href=\"space.php?uid=$tospace[uid]&do=debate&id=$id\">$blog[subject]</a>");
			$fs['body_template'] = '';
			$fs['body_data'] = array();
			$fs['body_general'] = '';

	$setarr = array(
		'uid' => $tospace['uid'],
		'debateid' => $id,
		'debatetype' => $debatetype,
		'authorid' => $_SGLOBAL['supe_uid'],
		'author' => $_SGLOBAL['supe_username'],
		'dateline' => $_SGLOBAL['timestamp'],
		'message' => $message,
	);
	//评论入库
	$cid = inserttable('debate_comment', $setarr, 1);
	
	
	 if($debatetype){
	    if(!in_array($_SGLOBAL['supe_uid'],$revoteuids)){
	      array_push($revoteuids,$_SGLOBAL['supe_uid']);
	      $votearr=array(
	       'revote'=>$debate['revote']+1,
	       'revoteuids'=>implode(',',$revoteuids)
	         );
	     }else{
	       $votearr=array(
	      'revote'=>$debate['revote']
	       );
	      } 
	 }elseif(!$debatetype){
	    if(!in_array($_SGLOBAL['supe_uid'],$obvoteuids)){
	      array_push($obvoteuids,$_SGLOBAL['supe_uid']);
	      $votearr=array(
	      'obvote'=>$debate['obvote']+1,
	      'obvoteuids'=>implode(',',$obvoteuids)
	       );
	      }else{
	        $votearr=array(
	        'obvote'=>$debate['obvote']
	      );
	       }
	  }
	  updatetable('debate', $votearr,array('debateid'=>$id));	
	 if(!$concern['uid']){
	  inserttable('debate_concern', array('uid'=>$_SGLOBAL['supe_uid'],'jdebateid'=>$id));
	 }else{
	  $jdebateids=empty($concern['jdebateid'])?array():explode(',',$concern['jdebateid']);
	  if(!in_array($id,$jdebateids)){
      array_push($jdebateids,$id);
      updatetable('debate_concern', array('jdebateid'=>implode(',',$jdebateids)),array('uid'=>$_SGLOBAL['supe_uid']));
	 }
	 }
	
	//通知信息
			$n_url = "space.php?uid=$tospace[uid]&do=debate&id=$id&cid=$cid";
			$note_type = 'blogcomment';
			$note = cplang('note_blog_comment', array($n_url, $debate['subject']));
			$q_note = cplang('note_blog_comment_reply', array($n_url));
			$msg = 'do_success';
			$magvalues = array();
			$msgtype = 'blog_comment';
			
	//发送邮件通知
	$touid = empty($comment['authorid']) ? $tospace['uid'] : $comment['authorid'];
	smail($touid, '', cplang($msgtype, array($_SGLOBAL['supe_username'])));

	if(empty($comment)) {
		//非引用评论
		if($tospace['uid'] != $_SGLOBAL['supe_uid']) {
			//事件发布
			if(ckprivacy('comment', 1)) {
				feed_add($fs['icon'], $fs['title_template'], $fs['title_data'], $fs['body_template'], $fs['body_data'], $fs['body_general'],$fs['images'], $fs['image_links'], $fs['target_ids'], $fs['friend']);
			}
			//发送通知
			notification_add($tospace['uid'], $note_type, $note);
			//留言发送短消息
			if($_POST['idtype'] == 'uid' && $tospace['updatetime'] == $tospace['dateline']) {
				include_once S_ROOT.'./uc_client/client.php';
				uc_pm_send($_SGLOBAL['supe_uid'], $tospace['uid'], cplang('wall_pm_subject'), cplang('wall_pm_message', array(addslashes(getsiteurl().$n_url))), 1, 0, 0);
			}
		}
	} elseif($comment['authorid'] != $_SGLOBAL['supe_uid']) {
		notification_add($comment['authorid'], $note_type, $q_note);
	}

	//财富
	if($tospace['uid'] != $_SGLOBAL['supe_uid']) {
		updatespacestatus('get', 'comment');
	}

	showmessage($msg, $_POST['refer'], 0, $magvalues);
}

$cid = empty($_GET['cid'])?0:intval($_GET['cid']);

//编辑
if($_GET['op'] == 'obedit' || $_GET['op'] == 'reedit') {

	$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('debate_comment')." WHERE cid='$cid' AND authorid='$_SGLOBAL[supe_uid]'");
	if(!$comment = $_SGLOBAL['db']->fetch_array($query)) {
		showmessage('no_privilege');
	}
	//提交编辑
	if(submitcheck('editsubmit')) {

		$message = getstr($_POST['message'], 0, 1, 1, 1, 2);
		if(strlen($message) < 2) showmessage('content_is_too_short');

		updatetable('debate_comment', array('message'=>$message), array('cid'=>$comment['cid']));

		showmessage('do_success', $_POST['refer'], 0);
	}

	//bbcode转换
	$comment['message'] = html2bbcode($comment['message']);//显示用

} elseif($_GET['op'] == 'obdelete' || $_GET['op'] == 'redelete') {
	if(submitcheck('deletesubmit')) {
	 if($cid) {
		$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('debate_comment')." WHERE cid='$cid'");
		$comment = $_SGLOBAL['db']->fetch_array($query);
		
	 if($_GET['op'] == 'redelete'){
	  $_SGLOBAL['db']->query("update ".tname('debate')." set rereplynum=rereplynum-1,revote=revote-1 where debateid=$comment[debateid]");
	 }elseif($_GET['op'] == 'obdelete'){
	  $_SGLOBAL['db']->query("update ".tname('debate')." set obreplynum=obreplynum-1,obvote=obvote-1 where debateid=$comment[debateid]");
	 }
	  $_SGLOBAL['db']->query("delete from ".tname('debate_comment')." where cid=$cid");
	 showmessage('do_success', $_POST['refer'], 0);	
	 }
	 }
}elseif($_GET['op'] == 'obvoted' || $_GET['op'] == 'revoted') {
       $query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('debate_comment')." WHERE cid='$cid' ");
	if(!$comment = $_SGLOBAL['db']->fetch_array($query)) {
		showmessage('no_privilege');
	}
	  $comment['voteids']=empty($comment['voteids'])?array():explode(',',$comment['voteids']);
	 $query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('debate')." WHERE debateid='$comment[debateid]' ");
	 if($debate = $_SGLOBAL['db']->fetch_array($query)) {
	 $obvoteuids=empty($debate['obvoteuids'])?array():explode(',',$debate['obvoteuids']);
	 $revoteuids=empty($debate['revoteuids'])?array():explode(',',$debate['revoteuids']);		
	}
	  
	if(submitcheck('votesubmit')) { 
	 if(!in_array($_SGLOBAL['supe_uid'],$comment['voteids'])){
     array_push($comment['voteids'],$_SGLOBAL['supe_uid']);
     updatetable('debate_comment', array('voteids'=>implode(',',$comment['voteids']),'vote'=>$comment['vote']+1),array('cid'=>$cid));
	}
	if(!$concern['uid']){
	  inserttable('debate_concern', array('uid'=>$_SGLOBAL['supe_uid'],'jdebateid'=>$comment['debateid']));
	 }else{
	  $jdebateids=array_filter(empty($concern['jdebateid'])?array():explode(',',$concern['jdebateid']));
      array_push($jdebateids,$comment['debateid']);
      updatetable('debate_concern', array('jdebateid'=>implode(',',$jdebateids)),array('uid'=>$_SGLOBAL['supe_uid']));
	 }
    if(!in_array($_SGLOBAL['supe_uid'],$revoteuids) && !in_array($_SGLOBAL['supe_uid'],$obvoteuids)){
	 if($comment['debatetype'] && !in_array($_SGLOBAL['supe_uid'],$revoteuids)){
	   array_push($revoteuids,$_SGLOBAL['supe_uid']);
	  $votearr=array(
	  'revote'=>$debate['revote']+1,
	  'revoteuids'=>implode(',',$revoteuids)
	  );
	 }elseif(!$comment['debatetype'] && !in_array($_SGLOBAL['supe_uid'],$obvoteuids)){
	 array_push($obvoteuids,$_SGLOBAL['supe_uid']);
	 $votearr=array(
	  'obvote'=>$debate['obvote']+1,
	  'obvoteuids'=>implode(',',$obvoteuids)
	  );
	  }
	  updatetable('debate', $votearr,array('debateid'=>$comment['debateid']));
	 }
	  showmessage('do_success', $_POST['refer'], 0);	
	 }

} elseif($_GET['op'] == 'obreply' || $_GET['op'] == 'rereply') {

	$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('debate_comment')." WHERE cid='$cid'");
	if(!$comment = $_SGLOBAL['db']->fetch_array($query)) {
		showmessage('comments_do_not_exist');
	}

} else {
	showmessage('no_privilege');
}
include template('cp_debatecomment');

	if(empty($tospace)) {
		showmessage('space_does_not_exist');
	}
	//黑名单
	if(isblacklist($tospace['uid'])) {
		showmessage('is_blacklist');
	}
?>