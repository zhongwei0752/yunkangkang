<?php
		$dateline=$_GET['dateline'];
		$uid=$_GET['uid'];
		if ($dateline) {
			$query = $_SGLOBAL['db']->query("SELECT *,count(*) as wei FROM ".tname('goodscod')." WHERE viewuid='$uid' and dateline='$dateline'  group by dateline order by dateline DESC");
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
		}else{
			$query = $_SGLOBAL['db']->query("SELECT *,count(*) as wei FROM ".tname('goodscod')." WHERE viewuid='$uid'  group by dateline order by dateline DESC");
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
		}
		
		//手机模版
	$abc = $_SGLOBAL['db']->query("SELECT * FROM ".tname('space')." WHERE uid='$_COOKIE[uchome_uid]'");
	$bac = $_SGLOBAL['db']->fetch_array($abc);
	if($bac['moblieclicknum']=="0"||$bac['moblieclicknum']=="1"||$bac['moblieclicknum']=="3"||$bac['moblieclicknum']=="4"||$bac['moblieclicknum']=="5"||$bac['moblieclicknum']=="6"||$bac['moblieclicknum']=="7"){
		include_once template("./wx/template/bookinglist");
	}else{
		include_once template("./wx/template/$bac[moblieclicknum]/booking");
	}
	include_once template("./wx/template/bookinglist");
?>