<?php
include_once('../../common.php');//uchome的公共文件
include_once('./function_weixin.php');//
require_once('./config.php');

//删除其中的点餐
if ($_POST['delsubmit']) {
	$uid=$_POST['uid'];
	$reservationid=$_POST['id'];
	$query=$_SGLOBAL['db']->query("DELETE FROM ".tname('reservationorder')." WHERE uid='$uid' AND reservationid='$reservationid'");
	if($query){echo '<script language="javascript">window.location.href = document.referrer;</script>';}
}

if($_POST['reservationsubmit'])
{
	$passwd=$_POST['reservationpassword'];
	$uid=$_POST['uid'];
	$query=$_SGLOBAL['db']->query("SELECT * FROM ".tname('reservation')." WHERE uid='$uid'");
	while($value=$_SGLOBAL['db']->fetch_array($query))
	{
		if($value['passwd']==$passwd)
		{
			$success=1;
			break;
		}
		else{$success=0;}
	}
	header("Location: ../reservationorder_list2.php");
}


if ($_GET['type'] =='reservation' ) {
	$uid=$_GET['uid'];
	$num = (int)$_GET['num'] ;
	$reservationid = $_GET['reservationid'] ;

	/*$sql = "select * from ".tname('space')." where wxkey='$wxkey' ";
	$query = $_SGLOBAL['db']->query($sql);
	$value = $_SGLOBAL['db']->fetch_array($query);
	$uid =$value['uid'];*/

	$sql = "select * from ".tname('reservationorder')." where reservationid='$reservationid' and uid ='$uid' ";
	$query = $_SGLOBAL['db']->query($sql);
	$value = $_SGLOBAL['db']->fetch_array($query);

	//如果已经存在记录
	if ($value ) {
		$sql = "update ".tname('reservationorder')." set num = num + $num , totle = totle +1    where reservationid='$reservationid' and uid ='$uid' ";
		$query = $_SGLOBAL['db']->query($sql);
		$success = 1 ;
	}
	else{
		$insert_ary['reservationid'] = $reservationid;
		$insert_ary['uid'] = $uid;
		$insert_ary['num'] =  1  ;
		$insert_ary['totle'] = 0 ;
		$insert_id = inserttable('reservationorder' , $insert_ary , 1);
		$success=0;
		if($insert_id)$success = 1 ;
	}

}
//用户提交订单
elseif ($_GET['type'] =='reservationorder') {
	$uid = $_GET['uid'] ;
	$name = $_GET['name'] ;
	$phone = $_GET['phone'] ;
	$other = $_GET['other'] ;
	$code = rand(100000,999999);
	$dateline = time();
	$sql = "select * from ".tname('reservationorder')." where  uid ='$uid' ";
	$query = $_SGLOBAL['db']->query($sql);
	while ( $value = $_SGLOBAL['db']->fetch_array($query) ){
		$inser['reservationid'] = $value['reservationid'];
		$inser['uid'] = $value['uid'];
		$inser['num'] = $value['num'];
		$inser['code'] = $code;
		$inser['dateline'] = $dateline;
		$inser['checked'] = 0 ;
		$inser['name'] = $name;
		$inser['phone'] = $phone;
		$inser['other'] = $other;
		$insert_id = inserttable('reservationorderlist' , $inser , 1);
		$inser='';
	}
	if ($insert_id) {
		//发微信消息通知管理员
		/*$url = BASE_URL."/pages/reservationorder_list2.php?token={$code}okokok{$uid}";
		$msg = "【订单{$code}】\n你好。有新的订单：\n姓名：{$name}\n电话{$phone}\n\n<a href=\"{$url}\">点击这里查看更多信息</a>";
		send_to_admin($xiaoquid , $msg);*/
		$success = 1 ;
	}
}


//审核订单  
elseif ($_GET['type'] =='reservationorder2' && $_GET['code'] ) {
	$wxkey = $_GET['wxkey'] ;
	$order_uid = $_GET['order_uid'] ;
	$code = $_GET['code'] ;
	$sql = "update  ".tname('reservationorderlist')." set checked = 1 where uid='$order_uid' and code = '$code' and num > 0 ";
	$query = $_SGLOBAL['db']->query($sql);
	if(mysql_errno()== 0){
		$success = 1 ;
		//发微信通知客户，通知他订单已经通过
		$msg = "您好，您提交的订单已经通过审核。下面是订单的详情\n订单编号：{$code}\n详情：\n";

		$sql = "select * from ".tname('reservationorder')." where uid='$order_uid'  and num > 0 ";
		$query = $_SGLOBAL['db']->query($sql);
		while ( $value = $_SGLOBAL['db']->fetch_array($query) ) {
		  $reservationid = $value['reservationid'];
		  $num = $value['num'];
		  $sql = "select * from ".tname('reservation')." where reservationid='$reservationid'  ";
		  $query2 = $_SGLOBAL['db']->query($sql);
		  $value2 = $_SGLOBAL['db']->fetch_array($query2);

		  $pic = $value2['ftpurl'].$value2['pic'].'.thumb.jpg';
		  $pic = $pic ? $pic : 'http://hotel.home3d.cn/image/nocommunitypic.jpg';
		  $msg.=$value2['subject']."  ".$num."  份/个\n";
		}
		send_by_uid($order_uid , $msg);
		//清零
		$sql = "update  ".tname('reservationorder')." set num = 0 where uid='$order_uid' and num > 0 ";
		$query = $_SGLOBAL['db']->query($sql);
	}
}

echo json_encode(array('tips' => $tips, 'success'=>$success));
?>
