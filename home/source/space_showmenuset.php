<?php
/*
	[UCenter Home] (C) 2007-2008 Comsenz Inc.
	$Id: space_menuset.php 13208 2009-08-20 06:31:35Z liguode $
*/

if(!defined('IN_UCHOME')) {
	exit('Access Denied');
}

$id=$_GET['id'];

//删除
if($_GET['op']=="delete"){
		$query2 = $_SGLOBAL['db']->query("delete  FROM ".tname('appset')." WHERE appstatus='0' and num=$id and uid=$_SGLOBAL[supe_uid]");
		$value2 = $_SGLOBAL['db']->fetch_array($query2);
		$query3 = $_SGLOBAL['db']->query("select *  FROM ".tname('appset')." WHERE appstatus='1' and num=$id and addmonth!='0' and uid=$_SGLOBAL[supe_uid]");
		$value3 = $_SGLOBAL['db']->fetch_array($query3);
		if($value3){
			updatetable("appset", array('addmonth'=>'0'),array('uid'=>$_SGLOBAL['supe_uid'],'num'=>$id));
		}
	
		showmessage("删除成功","space.php?do=showmenuset");
}
$number=rand();
$zfbuid=$_SGLOBAL['supe_uid'];
if($_GET['status']=="moblie"){
	if($space['mobliestatus']!="0"){
	$num=$_GET['moblienum'];
	$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('moblie')." WHERE num=$num");
	$value = $_SGLOBAL['db']->fetch_array($query);
	$list=$value;
}


}else{
	
	
	$query = $_SGLOBAL['db']->query("SELECT bf.*, b.* FROM ".tname('appset')." bf 
				LEFT JOIN ".tname('menuset')." b ON bf.num=b.menusetid WHERE bf.uid=$_SGLOBAL[supe_uid] and b.money!='0'");
	while($value = $_SGLOBAL['db']->fetch_array($query)){
		if($value['appstatus']=='0'){
			$value['cost']=$value['month']*$value['money'];
			$costid=$value['id'];
			$addmonth=$value['addmonth'];
			$allcost1[]=$value['month']*$value['money'];
			if($value['month']){
				if($value['newname']){
					$value['subject']=$value['newname'];
				}
			$list[]=$value;
		}
		}else{
			$value['cost']=$value['addmonth']*$value['money'];		
			$allcost1[]=$value['addmonth']*$value['money'];
			if($value['addmonth']){
				if($value['newname']){
					$value['subject']=$value['newname'];
				}
			$list[]=$value;
		}
		}
			

	}
	
	if($_POST['cancel']){
		$query = $_SGLOBAL['db']->query("delete  FROM ".tname('appset')." WHERE appstatus='0' and uid=$_SGLOBAL[supe_uid]");
		$value = $_SGLOBAL['db']->fetch_array($query);
		$query1 = $_SGLOBAL['db']->query("select *  FROM ".tname('appset')." WHERE appstatus='1' and addmonth!='0' and uid=$_SGLOBAL[supe_uid]");
		while($value1 = $_SGLOBAL['db']->fetch_array($query1)){
		if($value1){
			updatetable("appset", array('addmonth'=>'0'),array('uid'=>$_SGLOBAL['supe_uid'],'num'=>$value1['num']));
		}
	}
		showmessage("正在为你跳转到首页","space.php?do=home");
	}
}
	include_once template("space_showmenuset");


?>