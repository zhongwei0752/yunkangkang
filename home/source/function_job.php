<?php
/*
	[UCenter Home] (C) 2007-2008 Comsenz Inc.
	$Id: function_job.php 13245 2009-08-25 02:01:40Z liguode $
*/

if(!defined('IN_UCHOME')) {
	exit('Access Denied');
}

//��Ӳ���
function job_post($POST, $olds=array()) {
	global $_SGLOBAL, $_SC, $space;
	
	//�����߽�ɫ�л�
	$isself = 1;
	if(!empty($olds['uid']) && $olds['uid'] != $_SGLOBAL['supe_uid']) {
		$isself = 0;
		$__SGLOBAL = $_SGLOBAL;
		$_SGLOBAL['supe_uid'] = $olds['uid'];
		$_SGLOBAL['supe_username'] = addslashes($olds['username']);
	}

	//����
	$POST['subject'] = getstr(trim($POST['subject']), 80, 1, 1, 1);
	if(strlen($POST['subject'])<1) $POST['subject'] = sgmdate('Y-m-d');
	$POST['friend'] = intval($POST['friend']);
	
	//��˽
	$POST['target_ids'] = '';
	if($POST['friend'] == 2) {
		//�ض�����
		$uids = array();
		$names = empty($_POST['target_names'])?array():explode(' ', str_replace(cplang('tab_space'), ' ', $_POST['target_names']));
		if($names) {
			$query = $_SGLOBAL['db']->query("SELECT uid FROM ".tname('space')." WHERE username IN (".simplode($names).")");
			while ($value = $_SGLOBAL['db']->fetch_array($query)) {
				$uids[] = $value['uid'];
			}
		}
		if(empty($uids)) {
			$POST['friend'] = 3;//���Լ��ɼ�
		} else {
			$POST['target_ids'] = implode(',', $uids);
		}
	} elseif($POST['friend'] == 4) {
		//����
		$POST['password'] = trim($POST['password']);
		if($POST['password'] == '') $POST['friend'] = 0;//����
	}
	if($POST['friend'] !== 2) {
		$POST['target_ids'] = '';
	}
	if($POST['friend'] !== 4) {
		$POST['password'] == '';
	}

	$POST['tag'] = shtmlspecialchars(trim($POST['tag']));
	$POST['tag'] = getstr($POST['tag'], 500, 1, 1, 1);	//�������

	//����
	if($_SGLOBAL['mobile']) {
		$POST['message'] = getstr($POST['message'], 0, 1, 0, 1, 1);
	} else {
		$POST['message'] = checkhtml($POST['message']);
		$POST['message'] = getstr($POST['message'], 0, 1, 0, 1, 0, 1);
		$POST['message'] = preg_replace(array(
				"/\<div\>\<\/div\>/i",
				"/\<a\s+href\=\"([^\>]+?)\"\>/i"
			), array(
				'',
				'<a href="\\1" target="_blank">'
			), $POST['message']);
	}
	$message = $POST['message'];
	$message1 = $POST['message'];
	$messagecomment = $POST['messagecomment'];
	$othermessage = $POST['othermessage'];
	

	//���˷���
	if(empty($olds['classid']) || $POST['classid'] != $olds['classid']) {
		if(!empty($POST['classid']) && substr($POST['classid'], 0, 4) == 'new:') {
			//������
			$classname = shtmlspecialchars(trim(substr($POST['classid'], 4)));
			$classname = getstr($classname, 0, 1, 1, 1);
			if(empty($classname)) {
				$classid = 0;
			} else {
				$classid = getcount('classjob', array('classname'=>$classname, 'uid'=>$_SGLOBAL['supe_uid']), 'classid');
				if(empty($classid)) {
					$setarr = array(
						'classname' => $classname,
						'uid' => $_SGLOBAL['supe_uid'],
						'dateline' => $_SGLOBAL['timestamp']
					);
					$classid = inserttable('classjob', $setarr, 1);
				}
			}
		} else {
			$classid = intval($POST['classid']);

		}
	} else {
		$classid = $olds['classid'];
	}
	if($classid && empty($classname)) {
		//�Ƿ����Լ���
		$classname = getcount('class', array('classid'=>$classid, 'uid'=>$_SGLOBAL['supe_uid']), 'classname');
		if(empty($classname)) $classid = 0;
	}
	
	//����
	$jobarr = array(
		'subject' => $POST['subject'],
		'telephone' => $POST['telephone'],
		'email' => $POST['email'],
		'money' => $POST['money'],
		'classid' => $classid,
		'friend' => $POST['friend'],
		'password' => $POST['password'],
		'noreply' => empty($_POST['noreply'])?0:1
	);

	//����ͼƬ
	$titlepic = '';
	
	//��ȡ�ϴ���ͼƬ
	$uploads = array();
	if(!empty($POST['picids'])) {
		$picids = array_keys($POST['picids']);
		$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('pic')." WHERE picid IN (".simplode($picids).") AND uid='$_SGLOBAL[supe_uid]'");
		while ($value = $_SGLOBAL['db']->fetch_array($query)) {
			if(empty($titlepic) && $value['thumb']) {
				$titlepic = $value['filepath'];
				$jobarr['picflag'] = $value['remote']?2:1;
			}
			$uploads[$POST['picids'][$value['picid']]] = $value;
		}
		if(empty($titlepic) && $value) {
			$titlepic = $value['filepath'];
			$jobarr['picflag'] = $value['remote']?2:1;
		}
	}
	
	//��������
	if($uploads) {
		preg_match_all("/\<img\s.*?\_uchome\_localimg\_([0-9]+).+?src\=\"(.+?)\"/i", $message, $mathes);
		if(!empty($mathes[1])) {
			$searchs = $idsearchs = array();
			$replaces = array();
			foreach ($mathes[1] as $key => $value) {
				if(!empty($mathes[2][$key]) && !empty($uploads[$value])) {
					$searchs[] = $mathes[2][$key];
					$idsearchs[] = "_uchome_localimg_$value";
					$replaces[] = pic_get($uploads[$value]['filepath'], $uploads[$value]['thumb'], $uploads[$value]['remote'], 0);
					unset($uploads[$value]);
				}
			}
			if($searchs) {
				$message = str_replace($searchs, $replaces, $message);
				$message = str_replace($idsearchs, 'uchomelocalimg[]', $message);
				$message1 = str_replace($searchs, $replaces, $message1);
				$message1 = str_replace($idsearchs, 'uchomelocalimg[]', $message1);
			}
		}
		//δ��������
		foreach ($uploads as $value) {
			$message1.="<div class=\"uchome-message-pic\"><img src=\"../attachment/$value[filepath]\"><p>$value[title]</p></div>";
			$picurl = pic_get($value['filepath'], $value['thumb'], $value['remote'], 0);
			$message .= "<div class=\"uchome-message-pic\"><img src=\"$picurl\"><p>$value[title]</p></div>";
		}
	}
	
	//û����д�κζ���
	$ckmessage = preg_replace("/(\<div\>|\<\/div\>|\s|\&nbsp\;|\<br\>|\<p\>|\<\/p\>)+/is", '', $message);
	if(empty($ckmessage)) {
		return false;
	}
	
	//���slashes
	$message = addslashes($message);
	
	//�������ж�ȡͼƬ
	if(empty($titlepic)) {
		$titlepic = getmessagepic($message);
		$jobarr['picflag'] = 0;
	}
	$jobarr['pic'] = $titlepic;
	
	//�ȶ�
	if(checkperm('managejob')) {
		$jobarr['hot'] = intval($POST['hot']);
	}
	
	if($olds['jobid']) {
		//����
		$jobid = $olds['jobid'];
		updatetable('job', $jobarr, array('jobid'=>$jobid));
		
		$fuids = array();
		
		$jobarr['uid'] = $olds['uid'];
		$jobarr['username'] = $olds['username'];
	} else {
		//��������
		$jobarr['topicid'] = topic_check($POST['topicid'], 'job');

		$jobarr['uid'] = $_SGLOBAL['supe_uid'];
		$jobarr['username'] = $_SGLOBAL['supe_username'];
		$jobarr['dateline'] = empty($POST['dateline'])?$_SGLOBAL['timestamp']:$POST['dateline'];
		$jobid = inserttable('job', $jobarr, 1);
	}
	
	$jobarr['jobid'] = $jobid;
	$message1=str_replace("attachment","http://v5.home3d.cn/home/attachment",$message);
	$message1=str_replace("http://v5.home3d.cn/home/http://v5.home3d.cn/home/attachment","http://v5.home3d.cn/home/attachment/",$message1);	//����	
	$fieldarr = array(
		'message' => $message,
		'message1' => $message1,
		'messagecomment' => $messagecomment,
		'othermessage' => $othermessage,
		'postip' => getonlineip(),
		'target_ids' => $POST['target_ids']
	);
	
	//TAG
	$oldtagstr = addslashes(empty($olds['tag'])?'':implode(' ', unserialize($olds['tag'])));
	

	$tagarr = array();
	if($POST['tag'] != $oldtagstr) {
		if(!empty($olds['tag'])) {
			//�Ȱ���ǰ�ĸ������
			$oldtags = array();
			$query = $_SGLOBAL['db']->query("SELECT tagid, jobid FROM ".tname('tagjob')." WHERE jobid='$jobid'");
			while ($value = $_SGLOBAL['db']->fetch_array($query)) {
				$oldtags[] = $value['tagid'];
			}
			if($oldtags) {
				$_SGLOBAL['db']->query("UPDATE ".tname('tag')." SET jobnum=jobnum-1 WHERE tagid IN (".simplode($oldtags).")");
				$_SGLOBAL['db']->query("DELETE FROM ".tname('tagjob')." WHERE jobid='$jobid'");
			}
		}
		$tagarr = tag_batch($jobid, $POST['tag']);
		//���¸����е�tag
		$fieldarr['tag'] = empty($tagarr)?'':addslashes(serialize($tagarr));
	}

	if($olds) {
		//����
		updatetable('jobfield', $fieldarr, array('jobid'=>$jobid));
	} else {
		$fieldarr['jobid'] = $jobid;
		$fieldarr['uid'] = $jobarr['uid'];
		inserttable('jobfield', $fieldarr);
	}

	//�ռ����
	if($isself) {
		if($olds) {
			//�ռ����
			$_SGLOBAL['db']->query("UPDATE ".tname('space')." SET updatetime='$_SGLOBAL[timestamp]' WHERE uid='$_SGLOBAL[supe_uid]'");
		} else {
			if(empty($space['jobnum'])) {
				$space['jobnum'] = getcount('job', array('uid'=>$space['uid']));
				$jobnumsql = "jobnum=".$space['jobnum'];
			} else {
				$jobnumsql = 'jobnum=jobnum+1';
			}
			//����
			$reward = getreward('publishjob', 0);
			$_SGLOBAL['db']->query("UPDATE ".tname('space')." SET {$jobnumsql}, lastpost='$_SGLOBAL[timestamp]', updatetime='$_SGLOBAL[timestamp]', credit=credit+$reward[credit], experience=experience+$reward[experience] WHERE uid='$_SGLOBAL[supe_uid]'");
			
			//ͳ��
			updatestat('job');
		}
	}
	
	include("./source/upload.class.php");
  	$image= new upload;
  	$image->upload_file($jobid,"job");
	//����feed
	if($POST['makefeed']) {
		include_once(S_ROOT.'./source/function_feed.php');
		feed_publish($jobid, 'jobid', $olds?0:1);
	}
	
	//����
	if(empty($olds) && $jobarr['topicid']) {
		topic_join($jobarr['topicid'], $_SGLOBAL['supe_uid'], $_SGLOBAL['supe_username']);
	}

	//��ɫ�л�
	if(!empty($__SGLOBAL)) $_SGLOBAL = $__SGLOBAL;

	return $jobarr;
}

//����tag
function tag_batch($jobid, $tags) {
	global $_SGLOBAL;

	$tagarr = array();
	$tagnames = empty($tags)?array():array_unique(explode(' ', $tags));
	if(empty($tagnames)) return $tagarr;

	$vtags = array();
	$query = $_SGLOBAL['db']->query("SELECT tagid, tagname, close FROM ".tname('tag')." WHERE tagname IN (".simplode($tagnames).")");
	while ($value = $_SGLOBAL['db']->fetch_array($query)) {
		$value['tagname'] = addslashes($value['tagname']);
		$vkey = md5($value['tagname']);
		$vtags[$vkey] = $value;
	}
	$updatetagids = array();
	foreach ($tagnames as $tagname) {
		if(!preg_match('/^([\x7f-\xff_-]|\w){3,20}$/', $tagname)) continue;
		
		$vkey = md5($tagname);
		if(empty($vtags[$vkey])) {
			$setarr = array(
				'tagname' => $tagname,
				'uid' => $_SGLOBAL['supe_uid'],
				'dateline' => $_SGLOBAL['timestamp'],
				'jobnum' => 1
			);
			$tagid = inserttable('tag', $setarr, 1);
			$tagarr[$tagid] = $tagname;
		} else {
			if(empty($vtags[$vkey]['close'])) {
				$tagid = $vtags[$vkey]['tagid'];
				$updatetagids[] = $tagid;
				$tagarr[$tagid] = $tagname;
			}
		}
	}
	if($updatetagids) $_SGLOBAL['db']->query("UPDATE ".tname('tag')." SET jobnum=jobnum+1 WHERE tagid IN (".simplode($updatetagids).")");
	$tagids = array_keys($tagarr);
	$inserts = array();
	foreach ($tagids as $tagid) {
		$inserts[] = "('$tagid','$jobid')";
	}
	if($inserts) $_SGLOBAL['db']->query("REPLACE INTO ".tname('tagjob')." (tagid,jobid) VALUES ".implode(',', $inserts));

	return $tagarr;
}

//��ȡ��־ͼƬ
function getmessagepic($message) {
	$pic = '';
	$message = stripslashes($message);
	$message = preg_replace("/\<img src=\".*?image\/face\/(.+?).gif\".*?\>\s*/is", '', $message);	//�Ƴ������
	preg_match("/src\=[\"\']*([^\>\s]{25,105})\.(jpg|gif|png)/i", $message, $mathes);
	if(!empty($mathes[1]) || !empty($mathes[2])) {
		$pic = "{$mathes[1]}.{$mathes[2]}";
	}
	return addslashes($pic);
}

//����html
function checkhtml($html) {
	$html = stripslashes($html);
	if(!checkperm('allowhtml')) {
		
		preg_match_all("/\<([^\<]+)\>/is", $html, $ms);

		$searchs[] = '<';
		$replaces[] = '&lt;';
		$searchs[] = '>';
		$replaces[] = '&gt;';
		
		if($ms[1]) {
			$allowtags = 'img|a|font|div|table|tbody|caption|tr|td|th|br|p|b|strong|i|u|em|span|ol|ul|li|blockquote|object|param|embed';//����ı�ǩ
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

//��Ƶ��ǩ����
function job_bbcode($message) {
	$message = preg_replace("/\[flash\=?(media|real)*\](.+?)\[\/flash\]/ie", "job_flash('\\2', '\\1')", $message);
	return $message;
}
//��Ƶ
function job_flash($swf_url, $type='') {
	$width = '520';
	$height = '390';
	if ($type == 'media') {
		$html = '<object classid="clsid:6bf52a52-394a-11d3-b153-00c04f79faa6" width="'.$width.'" height="'.$height.'">
			<param name="autostart" value="0">
			<param name="url" value="'.$swf_url.'">
			<embed autostart="false" src="'.$swf_url.'" type="video/x-ms-wmv" width="'.$width.'" height="'.$height.'" controls="imagewindow" console="cons"></embed>
			</object>';
	} elseif ($type == 'real') {
		$html = '<object classid="clsid:cfcdaa03-8be4-11cf-b84b-0020afbbccfa" width="'.$width.'" height="'.$height.'">
			<param name="autostart" value="0">
			<param name="src" value="'.$swf_url.'">
			<param name="controls" value="Imagewindow,controlpanel">
			<param name="console" value="cons">
			<embed autostart="false" src="'.$swf_url.'" type="audio/x-pn-realaudio-plugin" width="'.$width.'" height="'.$height.'" controls="controlpanel" console="cons"></embed>
			</object>';
	} else {
		$html = '<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" width="'.$width.'" height="'.$height.'">
			<param name="movie" value="'.$swf_url.'">
			<param name="allowscriptaccess" value="always">
			<embed src="'.$swf_url.'" type="application/x-shockwave-flash" width="'.$width.'" height="'.$height.'" allowfullscreen="true" allowscriptaccess="always"></embed>
			</object>';
	}
	return $html;
}

?>
