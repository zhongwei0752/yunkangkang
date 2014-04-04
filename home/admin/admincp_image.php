<?php
/*
	[UCenter Home] (C) 2007-2008 Comsenz Inc.
	$Id: admincp_space.php 13174 2009-08-14 08:41:39Z zhengqingpeng $
*/

if(!defined('IN_UCHOME') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
include_once(S_ROOT.'./admin/upload.class.php');
if(submitcheck('bigimagesubmit')) {
  	$image= new upload;
  	$image->upload_file("image","bigimage");

	
	cpmessage("录入成功");
	
}
if(submitcheck('logoimagesubmit')) {
	$url=$_POST['url'];
  	$image= new upload;
  	$image->upload_file("image","logoimage","$url");
	
	cpmessage("录入成功");
	
}


	include template('admin/tpl/image');


?>