<?php

//评论入库

if($_POST['yan'])
{
	$uid=$_POST['uid'];
	$pollid=$_POST['pollid'];
	$message=$_POST['comment_message'];
	$dateline=$_POST['dateline'];
	$query=$_SGLOBAL['db']->query("SELECT * FROM ".tname('poll')." WHERE pollid='$pollid'");
	$value=$_SGLOBAL['db']->fetch_array($query);
	updatetable('poll',array('replynum'=>$value['replynum']+1),array('pollid'=>$pollid));
	inserttable('poll_comment',array('uid'=>$uid,'pollid'=>$pollid,'message'=>$message,'dateline'=>$dateline));
	echo '<ul id="comment_ul"><!--{avatar($value[uid],small)}-->&nbsp;&nbsp;:$message</ul>';
}


?>