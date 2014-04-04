<?php
/*
	[UCenter Home] (C) 2007-2008 Comsenz Inc.
	$Id: cp_comment.php 8338 2008-08-04 06:09:51Z liguode $
*/
if(!defined('IN_UCHOME')) {
	exit('Access Denied');
}

include_once(S_ROOT.'./source/function_bbcode.php');


//进行订餐表单传入
if($_POST['commentsubmit'])
{
	$uid=$_POST['uid'];
	$reservationid=$_POST['id'];
	$author=$_POST['author'];
	$message=$_POST['message'];
	$dateline=$_POST['dateline'];
	$query=$_SGLOBAL['db']->query("SELECT * FROM ".tname('reservation')." WHERE reservationid='$reservationid'");
	$value=$_SGLOBAL['db']->fetch_array($query);
	updatetable('reservation',array('replynum'=>$value['replynum']+1),array('reservationid'=>$reservationid));
	inserttable('reservation_comment',array('uid'=>$uid,'reservationid'=>$reservationid,'message'=>$message,'dateline'=>$dateline,'author'=>$author));
	echo '<script language="javascript">window.location.href = document.referrer;</script>';
}

?>
