<?php
/*
	[UCenter Home] (C) 2007-2008 Comsenz Inc.
	$Id: space_job.php 13208 2009-08-20 06:31:35Z liguode $
*/
include_once('./common.php');
if($_POST['type']=='ly'){
	$username=$_POST['userName'];
	$telephone=$_POST['telephone'];
	$count=$_POST['count'];
	inserttable("xitie",array('type'=>$_POST['type'],'username'=>$username,'telephone'=>$telephone,'count'=>$count));
	echo "提交成功";
}
if($_POST['type']=='zf'){
	$username=$_POST['userName'];
	$telephone=$_POST['telephone'];
	$content=$_POST['content'];
	inserttable("xitie",array('type'=>$_POST['type'],'username'=>$username,'telephone'=>$telephone,'content'=>$content));
	echo "提交成功";
}


?>