<?php
/*
	[UCenter Home] (C) 2007-2008 Comsenz Inc.
	$Id: function_stratch.php 10978 2009-01-14 02:39:06Z mak $
*/

if(!defined('IN_UCHOME')) {
	exit('Access Denied');
}

//添加活动
function stratch_post($POST, $olds=array()) {
	global $_SGLOBAL, $_SC;
	//操作者角色切换
	if(!empty($olds['uid'])) {
		$__SGLOBAL = $_SGLOBAL;
		$_SGLOBAL['supe_uid'] = $olds['uid'];
		$_SGLOBAL['supe_username'] = addslashes($olds['username']);
	}

	//标题
	$POST['subject'] = getstr(trim($POST['subject']), 80, 1, 1, 1);
	if(strlen($POST['subject'])<1) $POST['subject'] = sgmdate('Y-m-d');
	$POST['endtime'] = sstrtotime($POST['endtime']);
	$POST['passwd']=getstr(trim($POST['passwd']), 80, 1, 1, 1);
	$POST['chance1']=getstr(trim($POST['chance1']), 80, 1, 1, 1);
	$POST['chance2']=getstr(trim($POST['chance2']), 80, 1, 1, 1);
	$POST['chance3']=getstr(trim($POST['chance3']), 80, 1, 1, 1);
	$POST['fenmu']=getstr(trim($POST['fenmu']), 80, 1, 1, 1);
	$POST['winsum']=getstr(trim($POST['winsum']), 80, 1, 1, 1);
	$POST['times']=getstr(trim($POST['times']), 80, 1, 1, 1);
	$POST['winsum1']=getstr(trim($POST['winsum1']), 80, 1, 1, 1);
	$POST['award1']=getstr(trim($POST['award1']), 80, 1, 1, 1);
	$POST['winsum2']=getstr(trim($POST['winsum2']), 80, 1, 1, 1);
	$POST['award2']=getstr(trim($POST['award2']), 80, 1, 1, 1);
	$POST['winsum3']=getstr(trim($POST['winsum3']), 80, 1, 1, 1);
	$POST['award3']=getstr(trim($POST['award3']), 80, 1, 1, 1);

	//内容
	$POST['message'] = checkhtml($POST['message']);
	$POST['message'] = getstr($POST['message'], 0, 1, 0, 1, 0, 1);
	$POST['message'] = preg_replace("/\<div\>\<\/div\>/i", '', $POST['message']);	
	$message = $POST['message'];
	
	//主表
	$stratcharr = array(
		'subject' => $POST['subject'],
		'passwd' => $POST['passwd'],
		'endtime' => $POST['endtime'],
		'winsum' => $POST['winsum'],
		'chance1' => $POST['chance1'],
		'chance2' => $POST['chance2'],
		'chance3' => $POST['chance3'],
		'fenmu' => $POST['fenmu'],
		'winsum1' => $POST['winsum1'],
		'award1' => $POST['award1'],
		'winsum2' => $POST['winsum2'],
		'award2' => $POST['award2'],
		'winsum3' => $POST['winsum3'],
		'award3' => $POST['award3'],
		'times' => $POST['times']
	);

	//标题图片
	$titlepic = '';
	//获取上传的图片
	$uploads = array();
	if(!empty($POST['picids'])) {
		$picids = array_keys($POST['picids']);
		$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('pic')." WHERE picid IN (".simplode($picids).")");
		while ($value = $_SGLOBAL['db']->fetch_array($query)) {
			if(empty($titlepic) && $value['thumb']) {
				$titlepic = $value['filepath'];
				$stratcharr['picflag'] = $value['remote']?2:1;
			}
			$uploads[$POST['picids'][$value['picid']]] = $value;
		}
		if(empty($titlepic) && $value) {
			$titlepic = "attachment".$value['filepath'];
			$stratcharr['picflag'] = $value['remote']?2:1;
		}
	}
	//插入文章
	if($uploads) {
		preg_match_all("/\<img\s.*?\_uchome\_localimg\_([0-9]+).+?src\=\"(.+?)\"/i", $message, $mathes);
		preg_match_all("/\<img\s.*?\_uchome\_localimg\_([0-9]+).+?src\=\"(.+?)\"/i", $message1, $mathes);
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
		//未插入文章
		foreach ($uploads as $value) {
			$message1.="<div class=\"uchome-message-pic\"><img src=\"../attachment/$value[filepath]\"><p>$value[title]</p></div>";
			$picurl = pic_get($value['filepath'], $value['thumb'], $value['remote'], 0);
			$message .= "<div class=\"uchome-message-pic\"><img src=\"$picurl\"><p>$value[title]</p></div>";
		}
	}
	
	//没有填写任何东西
	$ckmessage = preg_replace("/(\<div\>|\<\/div\>|\s|\&nbsp\;|\<br\>|\<p\>|\<\/p\>)+/is", '', $message);
	if(empty($ckmessage)) {
		return false;
	}
	//添加slashes
	$message = addslashes($message);
	
	//从内容中读取图片
	if(empty($titlepic)) {
		$titlepic = getmessagepic($message);
		$stratcharr['picflag'] = 0;
	}
	$stratcharr['pic'] = $titlepic;
	$stratcharr['message']=$message;                       ///////////////////
	$message1=str_replace("attachment","http://v5.home3d.cn/home/attachment",$message);
	$message1=str_replace("http://v5.home3d.cn/home/http://v5.home3d.cn/home/attachment",													"http://v5.home3d.cn/home/attachment/",$message1);	
	/*$fieldarr = array(
		'message' => $message,
		'message1' =>$message,
		'postip' => getonlineip(),
		'target_ids' => $POST['target_ids']
	);*/
	$stratcharr['message1']=$message1;
	

	if($olds['stratchid']) {
		//更新
		
		$stratchid = $olds['stratchid'];
		updatetable('stratch', $stratcharr, array('stratchid'=>$stratchid));
		$stratcharr['uid'] = $olds['uid'];
		$stratcharr['username'] = $olds['username'];
		
	} else {
	//新建
		$stratcharr['uid'] = $_SGLOBAL['supe_uid'];
		$stratcharr['username'] = $_SGLOBAL['supe_username'];
		$stratcharr['dateline'] = empty($POST['dateline'])?$_SGLOBAL['timestamp']:$POST['dateline'];
		$stratchid = inserttable('stratch', $stratcharr, 1);
		$image1url="attachment/".$stratcharr['pic'];
		updatetable('stratch',array('image1url'=>$image1url),array('stratchid'=>$stratchid));
		inserttable('stratch_content',array('stratchid'=>$stratchid,'username'=>$stratcharr['username']));
	}
	
	$stratcharr['stratchid'] = $stratchid;
	
	//空间更新
	/*if($olds) {
		//空间更新
		$_SGLOBAL['db']->query("UPDATE INTO".tname('space')." SET updatetime='$_SGLOBAL[timestamp]' WHERE uid='$_SGLOBAL[supe_uid]'");
	} else {
		//财富
		updatespacestatus('get', 'stratch');
	}*/
	
	
	//feed
	if(empty($olds)) {
		//事件feed
		$fs = array();
		$fs['icon'] = 'stratch';
		$fs['title_data'] = array();
		$fs['images'] = $fs['image_links'] = array();
			if($stratcharr['pic']) {
				//$fs['images'] = array(mkpicurl($stratcharr));
				$fs['image_links'] = array("space.php?uid=$_SGLOBAL[supe_uid]&do=stratch&id=$stratchid");
			}
			$fs['title_template'] =cplang('feed_stratch');
			$fs['title_data'] = array(
				'subject' => "<a href=\"space.php?uid=$_SGLOBAL[supe_uid]&do=stratch&id=$stratchid\">$blogarr[subject]</a>"
			);
			$fs['body_template'] = '<b>{subject}</b><br>{summary}';
			$fs['title_data'] = array(
				'subject' => "<a href=\"space.php?uid=$_SGLOBAL[supe_uid]&do=stratch&id=$stratchid\">$blogarr[subject]</a>"
			);
			$fs['body_data'] = array(
				'subject' => "<a href=\"space.php?uid=$_SGLOBAL[supe_uid]&do=stratch&id=$stratchid\">$stratcharr[subject]</a>",
				'summary' => getstr($message, 150, 1, 1, 0, 0, -1)
			);
		$fs['body_general'] = '';
		if(ckprivacy('blog', 1)) {
			include_once(S_ROOT.'./source/function_cp.php');
			feed_add($fs['icon'], $fs['title_template'], $fs['title_data'], $fs['body_template'], $fs['body_data'], $fs['body_general'],$fs['images'], $fs['image_links'], $fs['target_ids'], $fs['friend']);
		}
	}

	//角色切换
	if(!empty($__SGLOBAL)) $_SGLOBAL = $__SGLOBAL;
	return $stratcharr;
}


//获取日志图片
function getmessagepic($message) {
	$pic = '';
	$message = stripslashes($message);
	$message = preg_replace("/\<img src=\".*?image\/face\/(.+?).gif\".*?\>\s*/is", '', $message);	//移除表情符
	preg_match("/src\=[\"\']*([^\>\s]{25,105})\.(jpg|gif|png)/i", $message, $mathes);
	if(!empty($mathes[1]) || !empty($mathes[2])) {
		$pic = "{$mathes[1]}.{$mathes[2]}";
	}
	return addslashes($pic);
}

////屏蔽html
//function checkhtml($html) {
//	$html = stripslashes($html);
//	if(!checkperm('allowhtml')) {
//		
//		preg_match_all("/\<([^\<]+)\>/is", $html, $ms);
//
//		$searchs[] = '<';
//		$replaces[] = '&lt;';
//		$searchs[] = '>';
//		$replaces[] = '&gt;';
//		
//		if($ms[1]) {
//			$allowtags = 'img|a|font|div|table|tbody|caption|tr|td|br|p|b|strong|i|u|em|span|ol|ul|li|blockquote|object|param|embed';//允许的标签
//			$ms[1] = array_unique($ms[1]);
//			foreach ($ms[1] as $value) {
//				$searchs[] = "&lt;".$value."&gt;";
//				$value = shtmlspecialchars($value);
//				$value = str_replace(array('\\','/*'), array('.','/.'), $value);
//				$value = preg_replace(array("/(javascript|script|eval|behaviour|expression)/i", "/(\s+|&quot;|')on/i"), array('.', ' .'), $value);
//				if(!preg_match("/^[\/|\s]?($allowtags)(\s+|$)/is", $value)) {
//					$value = '';
//				}
//				$replaces[] = empty($value)?'':"<".str_replace('&quot;', '"', $value).">";
//			}
//		}
//		$html = str_replace($searchs, $replaces, $html);
//	}
//	$html = addslashes($html);
//	
//	return $html;
//}

//视频标签处理
function stratch_bbcode($message) {
	$message = preg_replace("/\[flash\=?(media|real)*\](.+?)\[\/flash\]/ie", "stratch_flash('\\2', '\\1')", $message);
	return $message;
}
//视频
function stratch_flash($swf_url, $type='') {
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
			<param name="wmode" value="transparent">
			<embed src="'.$swf_url.'" type="application/x-shockwave-flash" width="'.$width.'" height="'.$height.'" allowfullscreen="true" wmode="transparent" allowscriptaccess="always"></embed>
			</object>';
	}
	return $html;
}

?>
