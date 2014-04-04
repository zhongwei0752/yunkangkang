<?php
/*
	[UCenter Home] (C) 2007-2008 Comsenz Inc.
	$Id: space_app.php 13003 2009-08-05 06:46:06Z liguode $
	用户购买应用数据输出
*/	
	$page = empty($_REQUEST['page'])?1:intval($_REQUEST['page']);
	if($page<1) $page=1;
	$perpage = $_REQUEST['perpage'];
	$perpage = mob_perpage($perpage);
	
	$start = ($page-1)*$perpage;
	if(empty($start)||empty($perpage)){
		$query = $_SGLOBAL['db']->query("SELECT bf.*, b.* FROM ".tname('appset')." bf $f_index
				LEFT JOIN ".tname('menuset')." b ON bf.num=b.menusetid
				WHERE bf.uid='$_REQUEST[uid]' and bf.appstatus='1' and b.style='1'
				ORDER BY bf.orderid ASC ");
	}else{
		$query = $_SGLOBAL['db']->query("SELECT bf.*, b.* FROM ".tname('appset')." bf $f_index
				LEFT JOIN ".tname('menuset')." b ON bf.num=b.menusetid
				WHERE bf.uid='$_REQUEST[uid]' and bf.appstatus='1' and b.style='1'
				ORDER BY bf.orderid ASC limit $start,$perpage");
		
	}
	
	while ($value = $_SGLOBAL['db']->fetch_array($query)) {
			$count1 = $_SGLOBAL['db']->result($_SGLOBAL['db']->query("SELECT COUNT(*) FROM ".tname($value['english'])." WHERE uid='$_REQUEST[uid]'"),0);
			$value['count']=$count1;
			$list[]=$value;

	}
	$query1 = $_SGLOBAL['db']->query("SELECT bf.*, b.* FROM ".tname('appset')." bf $f_index
				LEFT JOIN ".tname('menuset')." b ON bf.num=b.menusetid
				WHERE bf.uid='$_REQUEST[uid]' and bf.appstatus='1' and b.english='goods'
				ORDER BY bf.orderid ASC");
	while ($value1 = $_SGLOBAL['db']->fetch_array($query1)) {
			$count2 = $_SGLOBAL['db']->result($_SGLOBAL['db']->query("SELECT COUNT(*) FROM ".tname($value1['english'])." WHERE uid='$_REQUEST[uid]'"),0);
			$value1['count']=$count2;
			$list1[]=$value1;

	}
	$count =count($list);
	capi_showmessage_by_data("rest_success", 0, array('app'=>$list,'highapp'=>$list1, 'count'=>$count));
?>