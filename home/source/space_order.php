<?php
/*
	[UCenter Home] (C) 2007-2008 Comsenz Inc.
	$Id: space_goods.php 13208 2009-08-20 06:31:35Z liguode $
*/
if(!defined('IN_UCHOME')) {
	exit('Access Denied');
}	
	//判断是否填入资料
	$query3 = $_SGLOBAL['db']->query("SELECT * FROM ".tname('order')." 
				WHERE uid='$_SGLOBAL[supe_uid]'");
	$cheakfororder = $_SGLOBAL['db']->fetch_array($query3);	
	//推送者账号
	$query9 = $_SGLOBAL['db']->query("SELECT s.*, f.resideprovince, f.residecity, f.note, f.spacenote, f.sex, main.gid, main.num
				FROM ".tname('friend')." main
				LEFT JOIN ".tname('space')." s ON s.uid=main.fuid
				LEFT JOIN ".tname('spacefield')." f ON f.uid=main.fuid
				WHERE main.uid='$space[uid]' AND main.status='1'
				ORDER BY main.dateline DESC");
	while ($value = $_SGLOBAL['db']->fetch_array($query9)) {
				$list1[]=$value;


		}

	$ordersubmit=$_POST['ordersubmit'];
	if($ordersubmit){
		$tel=$_POST['tel'];
	$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('goodscod')." WHERE tel='$tel'");	
	while($value = $_SGLOBAL['db']->fetch_array($query)){
		$searchlist[]=$value;
	}//待续
	$query3 = $_SGLOBAL['db']->query("SELECT * FROM ".tname('order')." 
				WHERE uid='$_SGLOBAL[supe_uid]'");
	$cheakfororder = $_SGLOBAL['db']->fetch_array($query3);
	include_once template("space_order");
	}else{
	$shop=$_POST['shop'];

	if($shop){
		$shopping=$_POST['shopping'];
		$id=$_POST['id'];
		$password=$_POST['password'];
		$yunfei=$_POST['yunfei'];
		$manyunfei=$_POST['manyunfei'];
		$username=$_POST['username'];
		$password2=$_POST['password2'];
			foreach ($shopping as $key => $value) {
				$a=$a.",".$value;
			}
		if($_POST['push1']){
		$push=$_POST['push1'];
		}
		if($_POST['push']){
			$push=$_POST['push'];
		}
		//if(empty($shopping)||empty($id)||empty($password)||empty($password2)||empty($username)||empty($push)){
		//	showmessage("选项仍有空值");
		//}
		if($cheakfororder){
		updatetable("order",array("id"=>$id,'password'=>$password,'yunfei'=>$yunfei,'manyunfei'=>$manyunfei,'password2'=>$password2,'username'=>$username,'shopping'=>$a),array('uid'=>$_SGLOBAL['supe_uid']));
		updatetable("space",array("goodspush"=>$push),array('uid'=>$_SGLOBAL['supe_uid']));	
	}else{
		inserttable("order",array("id"=>$id,'password'=>$password,'yunfei'=>$yunfei,'manyunfei'=>$manyunfei,'password2'=>$password2,'username'=>$username,'shopping'=>$a,'uid'=>$_SGLOBAL['supe_uid']));
		updatetable("space",array("goodspush"=>$push),array('uid'=>$_SGLOBAL['supe_uid']));	
	}
		
	}
	
	
	$query2 = $_SGLOBAL['db']->query("SELECT bf.message, bf.target_ids, bf.magiccolor, b.* FROM ".tname('goods')." b 
				LEFT JOIN ".tname('goodsfield')." bf ON bf.goodsid=b.goodsid
				WHERE b.uid='$_SGLOBAL[supe_uid]'");
	while($value2 = $_SGLOBAL['db']->fetch_array($query2)){
		$goodslist[]=$value2;
	}
	$page = empty($_GET['page'])?1:intval($_GET['page']);
			
	$perpage = 10;
	$perpage = mob_perpage($perpage);
	
	$start = ($page-1)*$perpage;
	if(empty($_GET['cod'])){
		$wheresql="viewuid='$_SGLOBAL[supe_uid]'";
		$theurl="space.php?do=order";
	}
	$cod=$_GET['cod'];
	$goodsid=$_GET['goodsid'];
	if($cod=='1'){
		$wheresql="viewuid='$_SGLOBAL[supe_uid]' and status='0' and buystatus='4'";
	}elseif($cod=='2'){
		$wheresql="viewuid='$_SGLOBAL[supe_uid]' and status='1' and buystatus='4'";
	}elseif($cod=='3'){
		$wheresql="viewuid='$_SGLOBAL[supe_uid]' and status='0' and buystatus!='4'";
	}elseif($cod=='4'){
		$wheresql="viewuid='$_SGLOBAL[supe_uid]' and status='1' and buystatus!='4'";
	}elseif($cod=='5'){
		$wheresql="";
	}
	$send=$_GET['send'];
	if($send){
	if($send='owen'){
		$wheresql.="and buystatus='1'";
	}
	if($send='email'){
		$wheresql.="and buystatus='3'";
		}
	}

	if($goodsid){
		$wheresql1="and gid='$goodsid'";
		if($_GET['cod']){
			$theurl="space.php?do=order&cod=$_GET[cod]";	
		}else{
			$theurl="space.php?do=order";
		}
		
	}else{
		if($cod){
			$theurl="space.php?do=order&cod=$_GET[cod]";
		}else{
			$theurl="space.php?do=order";
		}
		
	}
			if($_POST['search']){
			$username=$_POST['key'];
			$wheresql = "viewuid='$_SGLOBAL[supe_uid]' AND username LIKE '%$username%'";
			$wheresql1="";
			}
			if($cod!='5'){
	//¼ì²é¿ªÊ¼Êý
	ckstart($start, $perpage);
	$list = array();
	$query = $_SGLOBAL['db']->query("SELECT *,count(*) as wei FROM ".tname('goodscod')." WHERE viewuid='$_SGLOBAL[supe_uid]'  group by dateline order by dateline DESC");
		while($value = $_SGLOBAL['db']->fetch_array($query)){
			$query1 = $_SGLOBAL['db']->query("SELECT * FROM ".tname('goodscod')." WHERE dateline='$value[dateline]'");
			while($value1 = $_SGLOBAL['db']->fetch_array($query1)){
				$query2 = $_SGLOBAL['db']->query("SELECT * FROM ".tname('goods')." WHERE goodsid='$value1[gid]'");
				$value2 = $_SGLOBAL['db']->fetch_array($query2);
				$value1['subject']=$value2['subject'];
				$value1['curprice']=$value2['curprice'];
				$value['zhong'][]=$value1;
			}
			$count=$value['count'];
			$count=explode(",",$count);
			$count=$count[0];
			$value['count']=$count;
			$list[]=$value;
		}
	$multi = multi($count, $perpage, $page, $theurl);
		}
	$_TPL['css'] = 'goods';
	$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('order')." WHERE uid='$_SGLOBAL[supe_uid]'");
	$order = $_SGLOBAL['db']->fetch_array($query);
	include_once template("space_order");
	}




	
?>