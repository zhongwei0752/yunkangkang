<?php
header("Content-Type:text/html;charset=utf-8");
	$uid=$_COOKIE["uchome_uid"]."id";
	$array=$_COOKIE["$uid"];
	if($array[0]==','){
		setcookie($uid,"");
		setcookie("time","0");
	}
	if($array){
	$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('goods')." WHERE goodsid IN (".$array.")");
		while ($value = $_SGLOBAL['db']->fetch_array($query)) {
			$car[]=$value;
		}
		$count=count($car);
		foreach ($car as $key => $value ){
		 $sum += $car[$key]['curprice'];
		}

	}
	//获取运费
	$query1 = $_SGLOBAL['db']->query("SELECT * FROM ".tname('order')." WHERE uid='$_COOKIE[uchome_uid]'");
	$yunfei = $_SGLOBAL['db']->fetch_array($query1);
	if(empty($yunfei['manyunfei'])||$sum<$yunfei['manyunfei']){
		if($yunfei['yunfei']){
		 $sum += $yunfei['yunfei'];
		}
	}
	//手机模版
	$abc = $_SGLOBAL['db']->query("SELECT * FROM ".tname('space')." WHERE uid='$_COOKIE[uchome_uid]'");
	$bac = $_SGLOBAL['db']->fetch_array($abc);
	if($bac['moblieclicknum']=="0"||$bac['moblieclicknum']=="1"||$bac['moblieclicknum']=="3"||$bac['moblieclicknum']=="4"||$bac['moblieclicknum']=="5"||$bac['moblieclicknum']=="6"||$bac['moblieclicknum']=="7"){
		include_once template("./wx/template/car");
	}else{
		include_once template("./wx/template/$bac[moblieclicknum]/car");
	}
?>