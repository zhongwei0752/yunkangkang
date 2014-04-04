<?php
header("Content-Type:text/html;charset=utf-8");
	//print_r($_POST);
	/*if($_POST['buyid']){
		foreach ($_POST['buyid'] as $key => $value) {
		
			if($value){
			inserttable("goodscod",array('gid'=>$value,'viewuid'=>$_POST['uid'],'number'=$value1));
			}
		
	}*/
	if($_POST['click']){
		$uid=$_COOKIE["uchome_uid"]."id";
		$cookieid=$_COOKIE['$uid'];
		$count=$_POST['sum'];
		$i=$_COOKIE["time"];

		foreach ($_POST['click'] as $key => $value) {
			if($value){
				$clickstr=explode(".",$value);
				//print_r($clickstr);
				$what=$clickstr[0];
				$what1=$clickstr[0].",";
				$what2=",".$clickstr[0];
				if($changecookie){
					$cookieid=$changecookie;
				}
				$changecookie1=str_replace("$what1","","$cookieid");
				$changecookie2=str_replace("$what2","","$changecookie1");
				$changecookie=str_replace("$what","","$changecookie2");
				if($_COOKIE["oldid"]){
					if($changecookie){
						$changecookie=$changecookie.",".$_COOKIE["oldid"];	
					}else{
						$changecookie=$_COOKIE["oldid"];
					}
					
				}
				$i=$i-1;
			$id[]=inserttable("goodscod",array('gid'=>$clickstr[0],'count'=>$count,'uid'=>$_COOKIE['uchome_viewuid'],'viewuid'=>$_POST['uid'],'number'=>$clickstr[1]),1);
			}
		}
		setcookie("time",$i);
		setcookie("$uid",$changecookie);
		setcookie("oldid","");
	}
	$dateline=$_SGLOBAL['timestamp'];
	if($_POST['paystatus']){
		if(empty($_POST['recive'])||empty($_POST['tel'])||empty($_POST['place'])||empty($_POST['paystatus'])){
			echo '<script charset="utf8" type="text/javascript" language="javascript">alert("选项有空值");</script>';
		}
		if($_POST['goodsid']){
			if($_POST['paystatus']=='PayOnDelivery'||$_POST['paystatus']=='PayOnShop'){
				include_once(S_ROOT.'./wx/wx_common.php');
				include_once(S_ROOT.'./wx/Weixin.class.php');
				$space=getspace($_COOKIE['uchome_uid']);
				$fakeid=$space['goodspush'];
				if($fakeid){
				$url="http://v5.home3d.cn/home/wx/wx.php?do=booking&uid=$_COOKIE[uchome_uid]&dateline=$dateline";
				$message="亲，你有新的订单，<a href='$url'>点我瞬间查看</a>";
				$d = get_obj_by_xiaoquid($_COOKIE['uchome_uid']);
				$info = $d->sendWXSingleMsg($fakeid,$message);
				}
			}
			foreach ($_POST['goodsid'] as $key1 => $value1) {
			if($value1){
			updatetable("goodscod",array('username'=>$_POST['recive'],'dateline'=>$dateline,'buystatus'=>$_POST['paystatus'],'tel'=>$_POST['tel'],'place'=>$_POST['place']),array('id'=>$value1));
			if($_POST['paystatus']=='PayOnDelivery'||$_POST['paystatus']=='PayOnShop'){
				updatetable("goodscod",array('moneystatus'=>'1'),array('id'=>$value1));
				$url_forward="wx.php?do=feed&wxkey=$_COOKIE[uchome_wxkey]&uid=$_COOKIE[uchome_uid]&idtype=goods&status=tanchuan";
				header("HTTP/1.1 301 Moved Permanently");
				header("Location: $url_forward");
			}elseif($_POST['paystatus']=='PayOnLine'){
				//更换按钮，跳转到支付宝
				$sum=$_GET['count'];
				$status=$dateline.",".$sum;
				$url_forward="wx.php?do=pay&status=$status";
				header("HTTP/1.1 301 Moved Permanently");
				header("Location: $url_forward");

			}
			}

			}
			}	

	}
	

//}
		
//}	
	$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('order')." WHERE uid='$_COOKIE[uchome_uid]'");
	$value = $_SGLOBAL['db']->fetch_array($query);
	$array=explode(",",$value["shopping"]);
	//在线支付
	if(in_array("1",$array)){
		$a='1';
	}
	//货到付款
	if(in_array("2",$array)){
		$b='1';
	}
	//到店自提
	if(in_array("3",$array)){
		$c='1';
	}
	//print_r($_POST);
	//手机模版
	$abc = $_SGLOBAL['db']->query("SELECT * FROM ".tname('space')." WHERE uid='$_COOKIE[uchome_uid]'");
	$bac = $_SGLOBAL['db']->fetch_array($abc);
	if($bac['moblieclicknum']=="0"||$bac['moblieclicknum']=="1"||$bac['moblieclicknum']=="3"||$bac['moblieclicknum']=="4"||$bac['moblieclicknum']=="5"||$bac['moblieclicknum']=="6"||$bac['moblieclicknum']=="7"){
		include_once template("./wx/template/place");
	}else{
		include_once template("./wx/template/$bac[moblieclicknum]/place");
	}
?>