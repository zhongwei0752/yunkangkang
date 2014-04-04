<?php
/*
	[UCenter Home] (C) 2007-2008 Comsenz Inc.
	$Id: admincp_space.php 13174 2009-08-14 08:41:39Z zhengqingpeng $
*/

if(!defined('IN_UCHOME') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}

include_once(S_ROOT.'./uc_client/client.php');
include_once(S_ROOT.'./data/data_usergroup.php');
@include_once(S_ROOT.'./data/data_profilefield.php');
$profilefields = empty($_SGLOBAL['profilefield'])?array():$_SGLOBAL['profilefield'];

//È¨ÏÞ
$managename = checkperm('managename');
$managespacegroup = checkperm('managespacegroup');
$managespaceinfo = checkperm('managespaceinfo');
$managespacecredit = checkperm('managespacecredit');
$managespacenote = checkperm('managespacenote');
$manageconfig = checkperm('manageconfig');
$managedelspace = checkperm('managedelspace');

$noprivilege = !$managename && !$managespacegroup && !$managespaceinfo && !$managespacecredit && !$managespacenote && !$managedelspace;
if($noprivilege) {
	cpmessage('no_authority_management_operation');
}

$uid = empty($_GET['uid'])?0:intval($_GET['uid']);
$result = '';
if($uid) {
	$query = $_SGLOBAL['db']->query("SELECT s.*, sf.* FROM ".tname('space')." s
		LEFT JOIN ".tname('spacefield')." sf ON sf.uid=s.uid
		WHERE s.uid='$uid'");
	if(!$member = $_SGLOBAL['db']->fetch_array($query)) {
		cpmessage('designated_users_do_not_exist');
	}
	$member['addsize'] = intval($member['addsize']/(1024*1024));
	$member['ip'] = strlen($member['ip'])<9?'-':intval(substr($member['ip'], 0, 3)).'.'.intval(substr($member['ip'], 3, 3)).'.'.intval(substr($member['ip'], 6, 3)).'.1~255';
	//ÊÓÆµ
	if($_SCONFIG['videophoto'] && $member['videopic'] && $member['videostatus']) {
		include_once(S_ROOT.'./source/function_cp.php');
		$videopic = getvideopic($member['videopic']);
	} else {
		$member['videostatus'] = 0;
	}
}
if($uid != $_SGLOBAL['supe_uid']) {
	//´´Ê¼ÈË
	if(ckfounder($uid)) {
		cpmessage('not_have_permission_to_operate_founder');
	}
}

if(submitcheck('usergroupsubmit')) {

	if($noprivilege || empty($member)) {
		cpmessage('no_authority_management_operation');
	}
	
	$credit = 0;
	if($managespacecredit) {
		$setarr = array(
			'addsize' => intval($_POST['addsize'])*1024*1024,
			'credit'=>intval($_POST['credit']),
			'experience'=>intval($_POST['experience'])
		);
	} else {
		$setarr = array(
			'credit'=>intval($member['credit']),
			'experience'=>intval($member['experience'])
		);
	}

	if($managespaceinfo) {
		//ÊÓÆµÈÏÖ¤ÕÕÆ¬
		if($_FILES['newvideopic']['size']) {
			include_once(S_ROOT.'./source/function_cp.php');
			if($newvideopic = videopic_upload($_FILES['newvideopic'], $uid)) {
				//É¾³ýÔ­À´µÄ
				if($member['videopic']) {
					@unlink(S_ROOT.'./'.getvideopic($member['videopic']));
				}
				$member['videopic'] = $newvideopic;
			}
		}
		if(empty($member['videopic'])) $_POST['videostatus'] = 0;
		$setarr['videostatus'] = intval($_POST['videostatus']);
	
		$email = getstr($_POST['email'], 100, 1, 1);
		$emailcheck = intval($_POST['emailcheck']);
		
		//¼¤»îÓÊÏä½±Àø»ý·Ö
		if($emailcheck && $email) {
			$reward = getreward('realemail', 0, $uid, '', 0);
			if($reward['credit']) {
				$setarr['credit'] += $reward['credit'];
			}
			if($reward['experience']) {
				$setarr['experience'] += $reward['experience'];
			}
		}
		
		$setarr['domain'] = trim($_POST['domain']);
		$setarr['addfriend'] = intval($_POST['addfriend']);
	}

	if($managespacegroup) {
		//É¾³ý±£»¤
		if($member['flag'] != -1) {
			include_once(S_ROOT.'./uc_client/client.php');
			if($_POST['flag'] == 1) {
				$result = uc_user_addprotected(array($member['username']), $_SGLOBAL['supe_username']);
			} else {
				$_POST['flag'] = 0;
				$result = uc_user_deleteprotected(array($member['username']), $_SGLOBAL['supe_username']);
			}
			if($result) {
				$setarr['flag'] = $_POST['flag'];
			}
		}
		if($uid != $_SGLOBAL['supe_uid'] || ckfounder($_SGLOBAL['supe_uid'])) {
			if(empty($_POST['groupid'])) {
				$_POST['groupid'] = getgroupid($_POST['experience'], 0);
			} else {
				$expiration = $_POST['expiration'] ? sstrtotime($_POST['expiration']) : 0;
				if($expiration && $expiration <= $_SGLOBAL['timestamp']) {
					showmessage('time_expired_error');
				}
			}
			
			include_once(S_ROOT.'./data/data_usergroup_'.$_POST['groupid'].'.php');
			$group = $_SGLOBAL['usergroup'][$_POST['groupid']];
			if($group['manageconfig'] && !ckfounder($_SGLOBAL['supe_uid'])) {
				cpmessage('no_authority_management_operation');
			}
			
			//ÓÐÐ§ÆÚ
			if($expiration) {
				$setlogarr = array(
					'uid' => $member['uid'],
					'username' => addslashes($member['username']),
					'opuid' => $_SGLOBAL['supe_uid'],
					'opusername' => $_SGLOBAL['supe_username'],
					'expiration' => $expiration,
					'dateline' => $_SGLOBAL['timestamp'],
					'flag' => 1
				);
				inserttable('spacelog', $setlogarr, 0, true);
			}
	
			$setarr['groupid'] = intval($_POST['groupid']);
		}
	}
	
	//ÊµÃû¹ÜÀíÈ¨ÏÞ
	if($managename) {
		
		$setarr['name'] = getstr($_POST['name'], 20, 1, 1);
		$setarr['namestatus'] = intval($_POST['namestatus']);
		
		//ÊµÃûÈÏÖ¤Í¨¹ý½±Àø»ý·Ö
		if($setarr['namestatus'] && $setarr['name']) {
			$reward = getreward('realname', 0, $uid, '', 0);
			if($reward['credit']) {
				$setarr['credit'] += $reward['credit'];
			}
			if($reward['experience']) {
				$setarr['experience'] += $reward['experience'];
			}
		}

	}
	
	if($setarr) {
		updatetable('space', $setarr, array('uid'=>$uid));
	}
	

	if($managespaceinfo) {
		//¸½Êô±í
		

		$setarr = array(
			'email' => $email,
			'emailcheck' => $emailcheck,
			'qq' => getstr($_POST['qq'], 20, 1, 1),
			'msn' => getstr($_POST['msn'], 80, 1, 1),
			'idcard'=>getstr($_POST['idcard'], 60, 1, 1),
			'businessnum'=>getstr($_POST['businessnum'], 60, 1, 1),
			'mobile'=>getstr($_POST['mobile'], 60, 1, 1),
			'businessaddress'=>getstr($_POST['businessaddress'], 60, 1, 1),
			'business'=>getstr($_POST['business'], 60, 1, 1),
			'resideprovince'=>getstr($_POST['resideprovince'], 60, 1, 1),
			'residecity'=>getstr($_POST['residecity'], 60, 1, 1),
			'telephone'=>getstr($_POST['telephone'], 60, 1, 1),
			'companyintroduce'=>getstr($_POST['companyintroduce'], 60, 1, 1),
			'limitnum'=>getstr($_POST['limitnum'], 60, 1, 1)


		);
		$setarr1= array(
		'name'=>getstr($_POST['name'], 60, 1, 1),
		'linkman'=>getstr($_POST['linkman'], 60, 1, 1)
		
			);
		foreach ($profilefields as $field => $value) {
			if($value['formtype'] == 'select') $value['maxsize'] = 255;
			$setarr['field_'.$field] = getstr($_POST['field_'.$field], $value['maxsize'], 1, 1);
		}
		
		//Çå¿Õ
		if($_POST['clearcss']) $setarr['css'] = '';
		
		updatetable('spacefield', $setarr, array('uid'=>$uid));
		
	}
	if($setarr1){
		updatetable('space', $setarr1, array('uid'=>$uid));
	}

	//Éú³ÉÓÃ»§±ä¸üÈÕÖ¾
	if($_SCONFIG['my_status']) inserttable('userlog', array('uid'=>$uid, 'action'=>'update', 'dateline'=>$_SGLOBAL['timestamp']), 0, true);

	cpmessage('do_success', "admincp.php?ac=space&op=manage&uid=$uid");

} elseif (submitcheck('listsubmit')) {

	if(!$noprivilege && !in_array($_POST['optype'], array(1,2,3,4,5,6,7))) {
		$_POST['optype'] = 0;
	}
	if($_POST['uids'] && is_array($_POST['uids']) && $_POST['optype']) {
		$createlog = false;
		$url = "admincp.php?ac=$ac&perpage=$_GET[perpage]&page=$_GET[page]";
		switch ($_POST['optype']) {

			case '1':
				if($managename) {
					//Í¨¹ýÊµÃûÈÏÖ¤
					$url .= 'namestatus=0';
					foreach($_POST['uids'] as $key => $uid) {
						$reward = getreward('realname', 0, $uid, '', 0);
						$_SGLOBAL['db']->query("UPDATE ".tname('space')." SET namestatus='1', profilestatus='0',alreadyreg='1', credit=credit+$reward[credit], experience=experience+$reward[experience] WHERE uid='$uid' ");
					}
					$createlog = true;
				}
				break;
			case '2':
				if($managename) {
					//È¡ÏûÊµÃûÈÏÖ¤
					$_SGLOBAL['db']->query("UPDATE ".tname('space')." SET namestatus='0' WHERE uid IN (".simplode($_POST['uids']).")");
					$url .= 'namestatus=1';
					$createlog = true;
				}
				break;
			case '3':
				if($managename) {
					//Çå¿ÕÐÕÃû
					$_SGLOBAL['db']->query("UPDATE ".tname('space')." SET name='',namestatus='0' WHERE uid IN (".simplode($_POST['uids']).")");
				}
				break;
			case '4':
				if($managespacenote) {
					//·¢ËÍÓÊ¼þÍ¨Öª
					//ÅúÁ¿·¢ËÍÓÊ¼þ
					$uids = implode(',', $_POST['uids']);
					include template('admin/tpl/space_manage');
					exit();
				}
				break;
			case '5':
				if($managespacenote) {
					//ÅúÁ¿´òÕÐºô
					$uids = implode(',', $_POST['uids']);
					include template('admin/tpl/space_manage');
					exit();
				}
				break;
			case '6':
				if($managespaceinfo) {
					//Çå¿ÕÓÃ»§¸öÐÔÉèÖÃ
					$_SGLOBAL['db']->query("UPDATE ".tname('spacefield')." SET css='' WHERE uid IN (".simplode($_POST['uids']).")");
					$createlog = true;
				}
				break;
			case '7':
				if($manageconfig) {
					//ÔùËÍµÀ¾ß
					$uids = implode(',', $_POST['uids']);
					include_once(S_ROOT.'./data/data_magic.php');
					include template('admin/tpl/space_manage');
					exit();
				}
				break;
		}
		if($createlog) {
			$comma = '';
			foreach($_POST['uids'] as $key => $uid) {
				$uid = intval($uid);
				$values .= "$comma('$uid', 'update', '$_SGLOBAL[timestamp]')";
				$comma = ',';
			}
			if($_SCONFIG['my_status']) $_SGLOBAL['db']->query("REPLACE INTO ".tname('userlog')." (uid, action, dateline) VALUES $values");
		}

	}
	cpmessage('do_success', $url);

} elseif (submitcheck('sendemailsubmit')) {

	if(!$managespacenote) {
		cpmessage('no_authority_management_operation');
	}
	$touids = empty($_POST['uids'])?array():explode(',', $_POST['uids']);
	$subject = trim($_POST['subject']);
	$message = trim($_POST['message']);
	if(empty($subject) && empty($message)) $touids = array();

	if($touids) {
		include_once(S_ROOT.'./source/function_cp.php');
		$query = $_SGLOBAL['db']->query("SELECT email, emailcheck FROM ".tname('spacefield')." WHERE uid IN (".simplode($touids).")");
		while ($value = $_SGLOBAL['db']->fetch_array($query)) {
			if($value['email']) {
				smail(0, $value['email'], $subject, $message);
			}
		}
	}
	cpmessage('do_success', "admincp.php?ac=$ac&perpage=$_GET[perpage]&page=$_GET[page]");

} elseif (submitcheck('pokesubmit')) {
	if(!$managespacenote) {
		cpmessage('no_authority_management_operation');
	}
	//´òÕÐºô
	$touids = empty($_POST['uids'])?array():explode(',', $_POST['uids']);
	$note = getstr($_POST['note'], 50, 1, 1);
	$uids = array();
	if($touids) {
		$replaces = array();
		foreach ($touids as $touid) {
			if($touid && $touid != $_SGLOBAL['supe_uid']) {
				$replaces[] = "('$touid','$_SGLOBAL[supe_uid]','$_SGLOBAL[supe_username]','$note','$_SGLOBAL[timestamp]')";
				$uids[$touid] = $touid;
			}
		}
		if($replaces) {
			$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('poke')." WHERE uid IN (".simplode($uids).") AND fromuid='$_SGLOBAL[supe_uid]'");
			while($value = $_SGLOBAL['db']->fetch_array($query)) {
				unset($uids[$value['uid']]);
			}
			$_SGLOBAL['db']->query("REPLACE INTO ".tname('poke')." (uid,fromuid,fromusername,note,dateline) VALUES ".implode(',', $replaces));
			//Ôö¼Ó´òÕÐºôÊý
			if($uids) {
				$_SGLOBAL['db']->query("UPDATE ".tname('space')." SET pokenum=pokenum+1 WHERE uid IN(".simplode($uids).")");
			}
		}
	}
	cpmessage('do_success', "admincp.php?ac=$ac&perpage=$_GET[perpage]&page=$_GET[page]");
	
} elseif (submitcheck('magicsubmit')) {
	
	if(!$manageconfig) {
		cpmessage('no_authority_management_operation');
	}
	
	//ÔùËÍµÀ¾ß
	$touids = empty($_POST['uids'])?array():explode(',', $_POST['uids']);
	$presents = $mids = array();
	foreach ($_POST['magicaward'] as $value) {
		list($mid, $count) = explode(',', $value);
		$count = intval($count);
		$presents[$mid] = $count;
		$mids[] = $mid;
	}
	if($touids && $mids) {
		$owns = $names = array();
		$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('usermagic')." WHERE uid IN (".simplode($touids).") AND mid IN (".simplode($mids).")");
		while($value = $_SGLOBAL['db']->fetch_array($query)) {
			$owns[$value['uid']][$value['mid']] = $value['count'];
		}
		$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('member')." WHERE uid IN (".simplode($touids).")");
		while($value = $_SGLOBAL['db']->fetch_array($query)) {
			$names[$value['uid']] = saddslashes($value['username']);
		}
		$inserts = $note_inserts = $log_inserts = array();
		include_once(S_ROOT.'./data/data_magic.php');
		foreach ($touids as $touid) {
			$note_presents = array();
			foreach ($presents as $mid=>$count) {
				$note_presents[] = '<a href="cp.php?ac=magic&view=me&mid='.$mid.'" target="_blank">'.$_SGLOBAL['magic'][$mid].'</a>('.$count.cplang('magicunit').')';
				$log_inserts[] = "('$touid', '$names[$touid]', '$mid', '$count', 2, '$_SGLOBAL[supe_uid]', 0, '$_SGLOBAL[timestamp]')";
				$count = $count + $owns[$touid][$mid];
				$inserts[] = "('$touid', '$names[$touid]', '$mid', '$count')";
			}
			$note = cplang('present_user_magics', array(implode('; ',$note_presents)));
			$note_inserts[] = "('$touid', 'system', 1, 0, '', '$note', '$_SGLOBAL[timestamp]')";
		}
		$_SGLOBAL['db']->query("REPLACE INTO ".tname('usermagic')." (uid, username, mid, count) VALUES ".implode(',', $inserts));
		$_SGLOBAL['db']->query("INSERT INTO ".tname('magicinlog')." (uid, username, mid, count, type, fromid, credit, dateline) VALUES ".implode(',', $log_inserts));
		$_SGLOBAL['db']->query("INSERT INTO ".tname('notification')." (uid, type, new, authorid, author, note, dateline) VALUES ".implode(',', $note_inserts));
		$_SGLOBAL['db']->query("UPDATE ".tname('space')." SET notenum = notenum + 1 WHERE uid IN (".simplode($touids).")");
	}
	cpmessage('do_success', "admincp.php?ac=$ac&perpage=$_GET[perpage]&page=$_GET[page]");
}

if($_GET['op'] == 'delete') {

	if(!$managedelspace) {
		cpmessage('no_authority_management_operation');
	}

	include_once(S_ROOT.'./source/function_delete.php');
	$_GET['uid'] = intval($_GET['uid']);
	if(!empty($_GET['uid']) && deletespace($_GET['uid'])) {
		cpmessage('do_success', 'admincp.php?ac=space');
	} else {
		cpmessage('choose_to_delete_the_space', 'admincp.php?ac=space');
	}
} elseif($_GET['op'] == 'close') {
	if(!$managespaceinfo) {
		cpmessage('no_authority_management_operation');
	}
	$flag = $member['flag'] == -1 ? 0 : -1;
	$_SGLOBAL['db']->query("UPDATE ".tname('space')." SET flag='$flag' WHERE uid='$uid'");
	cpmessage('do_success', 'admincp.php?ac=space&op=manage&uid='.$uid);
	
} elseif($_GET['op'] == 'deleteavatar') {
	if(!$managespaceinfo) {
		cpmessage('no_authority_management_operation');
	}
	$uid = intval($_GET['uid']);
	uc_user_deleteavatar($uid);
	$reward = getreward('delavatar', 0);
	$_SGLOBAL['db']->query("UPDATE ".tname('space')." SET avatar='0', credit=credit-$reward[credit], experience=experience-$reward[experience] WHERE uid='$uid'");
	cpmessage('do_success', 'admincp.php?ac=space&op=manage&uid='.$uid);
	
} elseif($_GET['op'] == 'zujian') {
	if($_GET['action']=='open'){
		$menusetid=$_GET['id'];
		$menusetuid=$_GET['uid'];
		$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('appset')." WHERE num='$menusetid' and uid='$menusetuid' and appstatus='1'");
		$value = $_SGLOBAL['db']->fetch_array($query);
		if(empty($value)){
			inserttable("appset",array('uid'=>$menusetuid,'num'=>$menusetid,'appstatus'=>'1'));
		}else{
			updatetable("appset",array('appstatus'=>'1'),array('uid'=>$menusetuid,'num'=>$menusetid));
		}
		showmessage("开通成功","admincp.php?ac=space&op=manage&uid=$menusetuid");
	}elseif($_GET['action']=='close'){
		$menusetid=$_GET['id'];
		$menusetuid=$_GET['uid'];
		$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('appset')." WHERE num='$menusetid' and uid='$menusetuid'");
		$value = $_SGLOBAL['db']->fetch_array($query);
		if($value){
			$query = $_SGLOBAL['db']->query("DELETE from ".tname('appset')." where num='$menusetid' and uid='$menusetuid'");
			$value = $_SGLOBAL['db']->fetch_array($query);
		}
		showmessage("关闭成功","admincp.php?ac=space&op=manage&uid=$menusetuid");
	}

}elseif($_GET['op'] == 'manage') {

	if($managespaceinfo) {
		//ÐÔ±ð
		$sexarr = array($member['sex']=>' checked');
	
		//ÉúÈÕ:Äê
		$birthyeayhtml = '';
		$nowy = sgmdate('Y');
		for ($i=0; $i<80; $i++) {
			$they = $nowy - $i;
			$selectstr = $they == $member['birthyear']?' selected':'';
			$birthyeayhtml .= "<option value=\"$they\"$selectstr>$they</option>";
		}
		//ÉúÈÕ:ÔÂ
		$birthmonthhtml = '';
		for ($i=1; $i<13; $i++) {
			$selectstr = $i == $member['birthmonth']?' selected':'';
			$birthmonthhtml .= "<option value=\"$i\"$selectstr>$i</option>";
		}
		//ÉúÈÕ:ÈÕ
		$birthdayhtml = '';
		for ($i=1; $i<32; $i++) {
			$selectstr = $i == $member['birthday']?' selected':'';
			$birthdayhtml .= "<option value=\"$i\"$selectstr>$i</option>";
		}
		//ÑªÐÍ
		$bloodhtml = '';
		foreach (array('A','B','O','AB') as $value) {
			$selectstr = $value == $member['blood']?' selected':'';
			$bloodhtml .= "<option value=\"$value\"$selectstr>$value</option>";
		}
		//»éÒö
		$marryarr = array($member['marry'] => ' selected');
	
		//À¸Ä¿±íµ¥
		$profilefields = array();
		$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('profilefield')." ORDER BY displayorder");
		while ($value = $_SGLOBAL['db']->fetch_array($query)) {
			$fieldid = $value['fieldid'];
			$value['formhtml'] = '';
	
			if($value['formtype'] == 'text') {
				//input¿ò³¤¶È
				$value['note'] = empty($value['note'])?'':$value['note'];
				$value['formhtml'] = "<input type=\"text\" name=\"field_$fieldid\" value=\"".$member["field_$fieldid"]."\" class=\"t_input\">";
			} else {
				$value['formhtml'] .= "<select name=\"field_$fieldid\">";
				if(empty($value['required'])) {
					$value['formhtml'] .= "<option value=\"\">---</option>";
				}
				$optionarr = explode("\n", $value['choice']);
				foreach ($optionarr as $ov) {
					$ov = trim($ov);
					if($ov) {
						$selectstr = $member["field_$fieldid"]==$ov?' selected':'';
						$value['formhtml'] .= "<option value=\"$ov\"$selectstr>$ov</option>";
					}
				}
				$value['formhtml'] .= "</select>";
			}
	
			$profilefields[$value['fieldid']] = $value;
		}
	
		$videostatusarr = array($member['videostatus'] => ' checked');
	}
	
	if($managespacegroup) {
		
		$member['expiration'] = '';
		$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('spacelog')." WHERE uid='$member[uid]'");
		if($value = $_SGLOBAL['db']->fetch_array($query)) {
			$member['expiration'] = $value['expiration']?sgmdate('Y-m-d H:i', $value['expiration']):'';
		}
		
		//ÓÃ»§×é
		$usergroups = array();
		$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('usergroup')." WHERE system!='0'");
		while ($value = $_SGLOBAL['db']->fetch_array($query)) {
			$usergroups[] = $value;
		}
		$groupidarr = array($member['groupid'] => ' selected');
	}
		$query1 = $_SGLOBAL['db']->query("SELECT m.*,mf.* FROM ".tname('menuset')." m LEFT JOIN ".tname('menusetfield')." mf ON m.menusetid=mf.menusetid");
		while ($value1 = $_SGLOBAL['db']->fetch_array($query1)) {
			$menuset[] = $value1;
		}
		$query2 = $_SGLOBAL['db']->query("SELECT m.*,mf.* FROM ".tname('appset')." m LEFT JOIN ".tname('menuset')." mf ON m.num=mf.menusetid WHERE m.uid='$member[uid]'and m.appstatus='0'");
		while ($value2 = $_SGLOBAL['db']->fetch_array($query2)) {
			$menuset1[] = $value2;
		}
		$query3 = $_SGLOBAL['db']->query("SELECT m.*,mf.* FROM ".tname('appset')." m LEFT JOIN ".tname('menuset')." mf ON m.num=mf.menusetid WHERE m.uid='$member[uid]' and m.appstatus='1'");
		while ($value3 = $_SGLOBAL['db']->fetch_array($query3)) {
			$menuset2[] = $value3;
		}
	include template('admin/tpl/space_manage');
	exit();
}

$mpurl = 'admincp.php?ac='.$ac;

$pre = 's.';
//´¦ÀíËÑË÷
$intkeys = array('uid', 'groupid', 'namestatus', 'avatar', 'videostatus', 'opuid', 'flag');
$strkeys = array('username', 'opusername');
$randkeys = array(array('sstrtotime','dateline'), array('sstrtotime','updatetime'), array('sstrtotime','lastpost'), array('sstrtotime','lastlogin'), array('intval','credit'), array('intval', 'experience'));
$likekeys = array('name');
$results = getwheres($intkeys, $strkeys, $randkeys, $likekeys, $pre);
$wherearr = $results['wherearr'];
$wheresql = empty($wherearr)?'1':implode(' AND ', $wherearr);
$mpurl .= '&'.implode('&', $results['urls']);

if(isset($_GET['namestatus']) && $_GET['namestatus']=='0') {
	$wheresql.="and profilestatus='1'";
}



//¼¤»î
$actives = array($_GET['tab'] => ' class="active"');
if(!isset($_GET['tab'])) {
	$actives = array('all' => ' class="active"');
} else {
	$mpurl .= '&tab='.$_GET['tab'];
}

//ÅÅÐò
$orders = getorders(array('dateline', 'updatetime', 'friendnum', 'credit', 'viewnum', 'experience'), 'uid', $pre);
$ordersql = $orders['sql'];
if($orders['urls']) $mpurl .= '&'.implode('&', $orders['urls']);
$orderby = array($_GET['orderby']=>' selected');
$ordersc = array($_GET['ordersc']=>' selected');

//ÓÃ»§×é
$usergroups = array();
$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('usergroup'));
while ($value = $_SGLOBAL['db']->fetch_array($query)) {
	$usergroups[$value['gid']] = $value;
} 

//ÏÔÊ¾·ÖÒ³
$perpage = empty($_GET['perpage'])?0:intval($_GET['perpage']);
if(!in_array($perpage, array(20,50,100))) $perpage = 20;
$mpurl .= '&perpage='.$perpage;
$perpages = array($perpage => ' selected');

$page = empty($_GET['page'])?1:intval($_GET['page']);
if($page<1) $page = 1;
$start = ($page-1)*$perpage;
//¼ì²é¿ªÊ¼Êý
ckstart($start, $perpage);

$list = array();
$uids = array();

$count = $_SGLOBAL['db']->result($_SGLOBAL['db']->query("SELECT COUNT(*) FROM ".tname('space')." s WHERE $wheresql"), 0);
if($count) {
	$query = $_SGLOBAL['db']->query("SELECT s.* FROM ".tname('space')." s WHERE $wheresql $ordersql LIMIT $start,$perpage");
	while ($value = $_SGLOBAL['db']->fetch_array($query)) {
		$value['grouptitle'] = $usergroups[$value['groupid']]['grouptitle'];
		$value['addsize'] = formatsize($value['addsize']);
		$value['attachsize'] = formatsize($value['attachsize']);
		$uids[] = $value['uid'];
		$list[] = $value;
	}
	$multi = multi($count, $perpage, $page, $mpurl);
}

//ÌØÊâÓÃ»§
$fusers = array();
$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('spacelog')." WHERE uid IN (".simplode($uids).")");
while ($value = $_SGLOBAL['db']->fetch_array($query)) {
	$value['expiration'] = sgmdate('Y-m-d H:i', $value['expiration']);
	$fusers[$value['uid']] = $value;
}

?>