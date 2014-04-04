<?php
/*
	[UCenter Home] (C) 2007-2008 Comsenz Inc.
	$Id: space_menuset.php 13208 2009-08-20 06:31:35Z liguode $
*/

if(!defined('IN_UCHOME')) {
	exit('Access Denied');
}


if($_POST['booking'])
{
//分页
if($_POST['getpage'])
{
	//showmessage($_POST[page1]);
	$page = empty($_POST['page'])?1:intval($_POST['page']);
	if($page<1) $page=1;

	
	$perpage = $_POST['perpage'];
	$perpage = mob_perpage($perpage);

	
	if(empty($perpage)) $perpage=5;
	
	$start = ($page-1) * $perpage;
	
	
	$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('bookingjoin')." ORDER BY id DESC LIMIT $start,$perpage");
	while ($value = $_SGLOBAL['db']->fetch_array($query)) {
			$list[]=$value;

	}
	echo json_encode($list);
}elseif ($_POST['id']) {
	
	$id = $_POST['id'];
	updatetable('bookingjoin',array('contact'=>'1'), array('id'=>$id));
	echo "success";
	//showmessage("更改成功","space.php?do=explain&view=me");
}

}elseif($_POST['explaining'])
{
	if($_POST['getpage'])
{
	//showmessage($_POST[page1]);
	$page = empty($_POST['page'])?1:intval($_POST['page']);
	if($page<1) $page=1;

	
	$perpage = $_POST['perpage'];
	$perpage = mob_perpage($perpage);

	
	if(empty($perpage)) $perpage=5;
	
	$start = ($page-1) * $perpage;
	
	
	$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('explainingjoin')." ORDER BY id DESC LIMIT $start,$perpage");
	while ($value = $_SGLOBAL['db']->fetch_array($query)) {
			$list[]=$value;

	}
	echo json_encode($list);
}elseif ($_POST['id']) {
	
	$id = $_POST['id'];
	updatetable('explainingjoin',array('contact'=>'1'), array('id'=>$id));
	echo "success";
	//showmessage("更改成功","space.php?do=explain&view=me");
}

}

?>