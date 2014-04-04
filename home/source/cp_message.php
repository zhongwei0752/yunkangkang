<?php
/*
	[UCenter Home] (C) 2007-2008 Comsenz Inc.
	$Id: cp_message.php 13149 2009-08-13 03:11:26Z liguode $
*/

if(!defined('IN_UCHOME')) {
	exit('Access Denied');
}
if(!in_array($_GET['op'], array('base','contact','edu','work','info'))) {
	$_GET['op'] = 'base';
}


$theurl = "cp.php?ac=message&op=$_GET[op]";

if($_GET['op'] == 'base') {

	if(submitcheck('messagesubmit') || submitcheck('nextsubmit')) {
		$namechange=$_GET['namechange'];
		if($namechange=='1'){
			updatetable('space',array('namestatus'=>'0'), array('uid'=>$_SGLOBAL['supe_uid']));
		}

		if(!@include_once(S_ROOT.'./data/data_messagefield.php')) {

			include_once(S_ROOT.'./source/function_cache.php');
			messagefield_cache();

		}

		$messagefields = empty($_SGLOBAL['messagefield'])?array():$_SGLOBAL['messagefield'];
	
		//Ìá½»¼ì²é
			
			if($_POST['resideprovince']){
				$setarr['resideprovince'] = getstr($_POST['resideprovince'], 20, 1, 1);
			}
			if($_POST['residecity']){
				$setarr['residecity'] = getstr($_POST['residecity'], 20, 1, 1);
			}
			if($_POST['weixin']){
				$setarr['weixin'] = getstr($_POST['weixin'], 50, 1, 1);
			}
			if($_POST['businessname']){
				$setarr['businessname'] = getstr($_POST['businessname'], 40, 1, 1);
			}
			if($_POST['businessaddress']){
				$setarr['businessaddress'] = getstr($_POST['businessaddress'], 100, 1, 1);
			}
			if($_POST['business']){
				$setarr['business'] = getstr($_POST['business'], 20, 1, 1);
			}
			if($_POST['telephone']){
				$setarr['telephone'] = getstr($_POST['telephone'], 20, 1, 1);
			}
			if($_POST['businesstelephone']){
				$setarr['businesstelephone'] = getstr($_POST['businesstelephone'], 20, 1, 1);
			}
			if($_POST['businessqq']){
				$setarr['businessqq'] = getstr($_POST['businessqq'], 20, 1, 1);
			}
			if($_POST['businessemail']){
				$setarr['businessemail'] = getstr($_POST['businessemail'], 20, 1, 1);
			}
			if($_POST['companyintroduce']){
				$setarr['companyintroduce'] = getstr($_POST['companyintroduce'], 100, 1, 1);
			}
			
			
			

		//企业LOGO图片上传处理
			if($_FILES["file"]["name"]){
			include("./source/upload3.class.php");
  			$image= new upload;
  			$image->upload_file($_SGLOBAL['supe_uid'],"spacefield");
  		}
		//ÐÔ±ð
		$_POST['sex'] = intval($_POST['sex']);
		if($_POST['sex'] && empty($space['sex'])) $setarr['sex'] = $_POST['sex'];
	
		foreach ($messagefields as $field => $value) {
			if($value['formtype'] == 'select') $value['maxsize'] = 255;
			$setarr['field_'.$field] = getstr($_POST['field_'.$field], $value['maxsize'], 1, 1);
			if($value['required'] && empty($setarr['field_'.$field])) {
				showmessage('field_required', '', 1, array($value['title']));
			}
		}
		
		if(empty($setarr)){
			
			}else{
				updatetable('spacefield', $setarr, array('uid'=>$_SGLOBAL['supe_uid']));
				updatetable('space',array('profilestatus'=>'1'), array('uid'=>$_SGLOBAL['supe_uid']));//更新提交状态
			}
		if($_POST['name']){
				$setarr1['name'] = getstr($_POST['name'], 10, 1, 1);
				updatetable('space', $setarr1, array('uid'=>$_SGLOBAL['supe_uid']));
			}
		if($_POST['linkman']){
				$setarr1['linkman'] = getstr($_POST['linkman'], 10, 1, 1);
				updatetable('space', $setarr1, array('uid'=>$_SGLOBAL['supe_uid']));
			}
		

		//±ä¸ü¼ÇÂ¼
		if($_SCONFIG['my_status']) {
			inserttable('userlog', array('uid'=>$_SGLOBAL['supe_uid'], 'action'=>'update', 'dateline'=>$_SGLOBAL['timestamp'], 'type'=>0), 0, true);
		}
		
	
	
		if(submitcheck('nextsubmit')) {
			$url = 'cp.php?ac=avatar';
		} else {
			$url = 'cp.php?ac=message&op=base';
		}
		showmessage('update_on_successful_individuals', $url);
	}


	


} elseif ($_GET['op'] == 'contact') {
	
	if($_GET['resend']) {
		//ÖØÐÂ·¢ËÍÓÊÏäÑéÖ¤
		$toemail = $space['newemail']?$space['newemail']:$space['email'];
		emailcheck_send($space['uid'], $toemail);
		showmessage('do_success', "cp.php?ac=message&op=contact");
	}
	
	if(submitcheck('messagesubmit') || submitcheck('nextsubmit')) {
		//Ìá½»¼ì²é
		$setarr = array(
			'mobile' => getstr($_POST['mobile'], 40, 1, 1),
			'qq' => getstr($_POST['qq'], 20, 1, 1),
			'msn' => getstr($_POST['msn'], 80, 1, 1),
		);
		
		//ÓÊÏäÎÊÌâ
		$newemail = isemail($_POST['email'])?$_POST['email']:'';
		if(isset($_POST['email']) && $newemail != $space['email']) {
			
			//¼ì²éÓÊÏäÎ¨Ò»ÐÔ
			if($_SCONFIG['uniqueemail']) {
				if(getcount('spacefield', array('email'=>$newemail, 'emailcheck'=>1))) {
					showmessage('uniqueemail_check');
				}
			}
			
			//ÑéÖ¤ÃÜÂë
			if(!$passport = getpassport($_SGLOBAL['supe_username'], $_POST['password'])) {
				showmessage('password_is_not_passed');
			}
			
			//ÓÊÏäÐÞ¸Ä
			if(empty($newemail)) {
				//ÓÊÏäÉ¾³ý
				$setarr['email'] = '';
				$setarr['emailcheck'] = 0;
			} elseif($newemail != $space['email']) {
				//Ö®Ç°ÒÑ¾­ÑéÖ¤
				if($space['emailcheck']) {
					//·¢ËÍÓÊ¼þÑéÖ¤£¬²»ÐÞ¸ÄÓÊÏä
					$setarr['newemail'] = $newemail;
				} else {
					//ÐÞ¸ÄÓÊÏä
					$setarr['email'] = $newemail;
				}
				emailcheck_send($space['uid'], $newemail);
			}
		}
		
		updatetable('spacefield', $setarr, array('uid'=>$_SGLOBAL['supe_uid']));
		
		//ÒþË½
		$inserts = array();
		foreach ($_POST['friend'] as $key => $value) {
			$value = intval($value);
			$inserts[] = "('contact','$key','$space[uid]','$value')";
		}
		if($inserts) {
			$_SGLOBAL['db']->query("DELETE FROM ".tname('spaceinfo')." WHERE uid='$space[uid]' AND type='contact'");
			$_SGLOBAL['db']->query("INSERT INTO ".tname('spaceinfo')." (type,subtype,uid,friend)
				VALUES ".implode(',', $inserts));
		}

		//±ä¸ü¼ÇÂ¼
		if($_SCONFIG['my_status']) {
			inserttable('userlog', array('uid'=>$_SGLOBAL['supe_uid'], 'action'=>'update', 'dateline'=>$_SGLOBAL['timestamp'], 'type'=>2), 0, true);
		}
		
		//²úÉúfeed
		if(ckprivacy('message', 1)) {
			feed_add('message', cplang('feed_message_update_contact'));
		}
		
		if(submitcheck('nextsubmit')) {
			$url = 'cp.php?ac=message&op=edu';
		} else {
			$url = 'cp.php?ac=message&op=contact';
		}
		showmessage('update_on_successful_individuals', $url);
	}
	
	//ÒþË½
	$friendarr = array();
	$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('spaceinfo')." WHERE uid='$space[uid]' AND type='contact'");
	while ($value = $_SGLOBAL['db']->fetch_array($query)) {
		$friendarr[$value['subtype']][$value['friend']] = ' selected';
	}
	
} elseif ($_GET['op'] == 'edu') {
	
	if($_GET['subop'] == 'delete') {
		$infoid = intval($_GET['infoid']);
		if($infoid) {
			$_SGLOBAL['db']->query("DELETE FROM ".tname('spaceinfo')." WHERE infoid='$infoid' AND uid='$space[uid]' AND type='edu'");
		}
	}
	
	if(submitcheck('messagesubmit') || submitcheck('nextsubmit')) {
		//Ìá½»¼ì²é
		$inserts = array();
		foreach ($_POST['title'] as $key => $value) {
			$value = getstr($value, 100, 1, 1);
			if($value) {
				$subtitle= getstr($_POST['subtitle'][$key], 20, 1, 1);
				$startyear = intval($_POST['startyear'][$key]);
				$friend = intval($_POST['friend'][$key]);
				$inserts[] = "('$space[uid]','edu','$value','$subtitle','$startyear','$friend')";
			}
		}
		if($inserts) {
			$_SGLOBAL['db']->query("INSERT INTO ".tname('spaceinfo')."(uid,type,title,subtitle,startyear,friend) VALUES ".implode(',', $inserts));
		}
		
		//±ä¸ü¼ÇÂ¼
		if($_SCONFIG['my_status']) {
			inserttable('userlog', array('uid'=>$_SGLOBAL['supe_uid'], 'action'=>'update', 'dateline'=>$_SGLOBAL['timestamp'], 'type'=>2), 0, true);
		}
		
		//²úÉúfeed
		if(ckprivacy('message', 1)) {
			feed_add('message', cplang('feed_message_update_edu'));
		}

		if(submitcheck('nextsubmit')) {
			$url = 'cp.php?ac=message&op=work';
		} else {
			$url = 'cp.php?ac=message&op=edu';
		}
		showmessage('update_on_successful_individuals', $url);
	}
	
	//µ±Ç°ÒÑ¾­ÉèÖÃµÄÑ§Ð£
	$list = array();
	$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('spaceinfo')." WHERE uid='$space[uid]' AND type='edu'");
	while ($value = $_SGLOBAL['db']->fetch_array($query)) {
		$value['title_s'] = urlencode($value['title']);
		$list[] = $value;
	}
	
} elseif ($_GET['op'] == 'work') {
	
	
	if($_GET['subop'] == 'delete') {
		$infoid = intval($_GET['infoid']);
		if($infoid) {
			$_SGLOBAL['db']->query("DELETE FROM ".tname('spaceinfo')." WHERE infoid='$infoid' AND uid='$space[uid]' AND type='work'");
		}
	}
	
	if(submitcheck('messagesubmit') || submitcheck('nextsubmit')) {
		//Ìá½»¼ì²é
		$inserts = array();
		foreach ($_POST['title'] as $key => $value) {
			$value = getstr($value, 100, 1, 1);
			if($value) {
				$subtitle= getstr($_POST['subtitle'][$key], 20, 1, 1);
				$startyear = intval($_POST['startyear'][$key]);
				$startmonth = intval($_POST['startmonth'][$key]);
				$endyear = intval($_POST['endyear'][$key]);
				$endmonth = $endyear?intval($_POST['endmonth'][$key]):0;
				$friend = intval($_POST['friend'][$key]);
				$inserts[] = "('$space[uid]','work','$value','$subtitle','$startyear','$startmonth','$endyear','$endmonth','$friend')";
			}
		}
		if($inserts) {
			$_SGLOBAL['db']->query("INSERT INTO ".tname('spaceinfo')."
				(uid,type,title,subtitle,startyear,startmonth,endyear,endmonth,friend)
				VALUES ".implode(',', $inserts));
		}

		//±ä¸ü¼ÇÂ¼
		if($_SCONFIG['my_status']) {
			inserttable('userlog', array('uid'=>$_SGLOBAL['supe_uid'], 'action'=>'update', 'dateline'=>$_SGLOBAL['timestamp'], 'type'=>2), 0, true);
		}
		
		//²úÉúfeed
		if(ckprivacy('message', 1)) {
			feed_add('message', cplang('feed_message_update_work'));
		}


		if(submitcheck('nextsubmit')) {
			$url = 'cp.php?ac=message&op=info';
		} else {
			$url = 'cp.php?ac=message&op=work';
		}
		showmessage('update_on_successful_individuals', $url);
	}
	
	//µ±Ç°ÒÑ¾­ÉèÖÃ
	$list = array();
	$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('spaceinfo')." WHERE uid='$space[uid]' AND type='work'");
	while ($value = $_SGLOBAL['db']->fetch_array($query)) {
		$value['title_s'] = urlencode($value['title']);
		$list[] = $value;
	}
	
} elseif ($_GET['op'] == 'info') {
	
	if(submitcheck('messagesubmit')) {
		
		$inserts = array();
		foreach ($_POST['info'] as $key => $value) {
			$value = getstr($value, 500, 1, 1);
			$friend = intval($_POST['info_friend'][$key]);
			$inserts[] = "('$space[uid]','info','$key','$value','$friend')";
		}
		
		if($inserts) {
			$_SGLOBAL['db']->query("DELETE FROM ".tname('spaceinfo')." WHERE uid='$space[uid]' AND type='info'");
			$_SGLOBAL['db']->query("INSERT INTO ".tname('spaceinfo')."
				(uid,type,subtype,title,friend)
				VALUES ".implode(',', $inserts));
		}
	
		//±ä¸ü¼ÇÂ¼
		if($_SCONFIG['my_status']) {
			inserttable('userlog', array('uid'=>$_SGLOBAL['supe_uid'], 'action'=>'update', 'dateline'=>$_SGLOBAL['timestamp'], 'type'=>2), 0, true);
		}
		
		//²úÉúfeed
		if(ckprivacy('message', 1)) {
			feed_add('message', cplang('feed_message_update_info'));
		}


		$url = 'cp.php?ac=message&op=info';
		showmessage('update_on_successful_individuals', $url);
	}
	
	//ÒþË½
	$list = $friends = array();
	$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('spaceinfo')." WHERE uid='$space[uid]' AND type='info'");
	while ($value = $_SGLOBAL['db']->fetch_array($query)) {
		$list[$value['subtype']] = $value;
		$friends[$value['subtype']][$value['friend']] = ' selected';
	}
	
}

$cat_actives = array($_GET['op'] => ' class="active"');


if($_GET['op'] == 'edu' || $_GET['op'] == 'work') {
	$yearhtml = '';
	$nowy = sgmdate('Y');
	for ($i=0; $i<50; $i++) {
		$they = $nowy - $i;
		$yearhtml .= "<option value=\"$they\">$they</option>";
	}
	
	$monthhtml = '';
	for ($i=1; $i<13; $i++) {
		$monthhtml .= "<option value=\"$i\">$i</option>";
	}
}

include template("cp_message");

?>