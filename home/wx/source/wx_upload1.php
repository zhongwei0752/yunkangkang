<?php
header("Content-Type:text/html;charset=utf-8");  
//购买执行代码
if($_POST['buy']){
	$username=$_POST['username'];
	$tel=$_POST['tel'];
	$place=$_POST['place'];
	$viewuid=$_POST['viewuid'];
	$number=$_POST['number'];
	$uid=$_SGLOBAL['supe_uid'];
	$gid=$_POST['gid'];
	$wxkey=$_POST['wxkey'];
	$code=$_POST['code'];

	ssetcookie('username', $username, 31536000);
	ssetcookie('tel', $tel, 31536000);
	ssetcookie('place', $place, 31536000);
	ssetcookie('number', $number, 31536000);
	
	$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('goodscod')." WHERE uid='$uid' and viewuid='$viewuid' and status='0'");
	$value = $_SGLOBAL['db']->fetch_array($query);
	if($value){
	$lasttime=$_SGLOBAL['timestamp']-$value['dateline'];
	if($lasttime>60){
		if($code){
		$query4 = $_SGLOBAL['db']->query("SELECT * FROM ".tname('codebuy')." WHERE codepassword='$code' and status='0'");
		$value4 = $_SGLOBAL['db']->fetch_array($query4);
		if($value4){
		inserttable("goodscod",array('username'=>$username,'codestatus'=>'1','dateline'=>$_SGLOBAL['timestamp'], 'gid'=>$gid,'tel'=>$tel,'number'=>$number,'place'=>$place,'viewuid'=>$viewuid,'uid'=>$uid));	
		for($i=0;$i<3;$i++){
		while(true){
		$a=rand(100000,999999);
		$query3 = $_SGLOBAL['db']->query("SELECT * FROM ".tname('codebuy')." WHERE codepassword='$a' and status='0'");
		$value3 = $_SGLOBAL['db']->fetch_array($query3);
		if(empty($value3)){
			inserttable("codebuy",array('codepassword'=>$a,'goodsid'=>$gid,'uid'=>$viewuid));
			break;
			}	
		}
		

	}
		}else{
		echo"1";	
		}
		}else{
		inserttable("goodscod",array('username'=>$username,'dateline'=>$_SGLOBAL['timestamp'], 'gid'=>$gid,'tel'=>$tel,'number'=>$number,'place'=>$place,'viewuid'=>$viewuid,'uid'=>$uid));
		for($i=0;$i<3;$i++){
		while(true){
		$a=rand(100000,999999);
		$query3 = $_SGLOBAL['db']->query("SELECT * FROM ".tname('codebuy')." WHERE codepassword='$a' and status='0'");
		$value3 = $_SGLOBAL['db']->fetch_array($query3);
		if(empty($value3)){
			inserttable("codebuy",array('codepassword'=>$a,'goodsid'=>$gid,'uid'=>$viewuid));
			break;
			}	
		}
		

	}
		}
	include_once(S_ROOT.'./wx/wx_common.php');
	include_once(S_ROOT.'./wx/Weixin.class.php');
	$query1 = $_SGLOBAL['db']->query("SELECT * FROM ".tname('goods')." WHERE goodsid='$gid'");
	$value1 = $_SGLOBAL['db']->fetch_array($query1);
	$space=getspace($viewuid);
	$fakeid=$value1['push'];
	if($fakeid){
	$url="http://v5.home3d.cn/home/wx/wx.php?do=detail&id=$gid&wxkey=".$wxkey."&uid=$viewuid&viewuid=$viewuid&idtype=goodsid&type=goods&moblieclicknum=$space[moblieclicknum]";
	$url=str_replace(" ","",$url);
	$message="亲，你的商品$value1[subject]有人下单啦，<a href='$url'>点我瞬间查看</a>";
	$d = get_obj_by_xiaoquid($viewuid);
	$info = $d->sendWXSingleMsg($fakeid,$message);
	}	
	}
	}else{
		if($code){
		$query4 = $_SGLOBAL['db']->query("SELECT * FROM ".tname('codebuy')." WHERE codepassword='$code' and status='0'");
		$value4 = $_SGLOBAL['db']->fetch_array($query4);
		if($value4){
	inserttable("goodscod",array('username'=>$username,'codestatus'=>'1','dateline'=>$_SGLOBAL['timestamp'], 'gid'=>$gid,'tel'=>$tel,'number'=>$number,'place'=>$place,'viewuid'=>$viewuid,'uid'=>$uid));
	for($i=0;$i<3;$i++){
		while(true){
		$a=rand(100000,999999);
		$query3 = $_SGLOBAL['db']->query("SELECT * FROM ".tname('codebuy')." WHERE codepassword='$a' and status='0'");
		$value3 = $_SGLOBAL['db']->fetch_array($query3);
		if(empty($value3)){
			inserttable("codebuy",array('codepassword'=>$a,'goodsid'=>$gid,'uid'=>$viewuid));
			break;
			}	
		}
		

	}
	}else{
		echo"1";	
	}
	}else{
	inserttable("goodscod",array('username'=>$username,'dateline'=>$_SGLOBAL['timestamp'], 'gid'=>$gid,'tel'=>$tel,'number'=>$number,'place'=>$place,'viewuid'=>$viewuid,'uid'=>$uid));
	for($i=0;$i<3;$i++){
		while(true){
		$a=rand(100000,999999);
		$query3 = $_SGLOBAL['db']->query("SELECT * FROM ".tname('codebuy')." WHERE codepassword='$a' and status='0'");
		$value3 = $_SGLOBAL['db']->fetch_array($query3);
		if(empty($value3)){
			inserttable("codebuy",array('codepassword'=>$a,'goodsid'=>$gid,'uid'=>$viewuid));
			break;
			}	
		}
		

	}
	}
	include_once(S_ROOT.'./wx/wx_common.php');
	include_once(S_ROOT.'./wx/Weixin.class.php');
	$query1 = $_SGLOBAL['db']->query("SELECT * FROM ".tname('goods')." WHERE goodsid='$gid'");
	$value1 = $_SGLOBAL['db']->fetch_array($query1);
	$space=getspace($viewuid);
	$fakeid=$value1['push'];
	if($fakeid){
	$url="http://v5.home3d.cn/home/wx/wx.php?do=detail&id=$gid&wxkey=".$wxkey."&uid=$viewuid&viewuid=$viewuid&idtype=goodsid&type=goods&moblieclicknum=$space[moblieclicknum]";
	$url=str_replace(" ","",$url);
	$message="亲，你的商品$value1[subject]有人下单啦，<a href='$url'>点我瞬间查看</a>";
	$d = get_obj_by_xiaoquid($viewuid);
	$info = $d->sendWXSingleMsg($fakeid,$message);
	}
	}
	
	/*echo '<script language="javascript">history.go(-1);</script>';*/
}
//拍卖执行代码
if($_POST['auctionbuy']){
	$name=$_POST['name'];
	$telephone=$_POST['telephone'];
	$auctionplace=$_POST['auctionplace'];
	$viewuid=$_POST['viewuid'];
	$uid=$_SGLOBAL['supe_uid'];
	$gid=$_POST['gid'];
	$wxkey=$_POST['wxkey'];
	$money=$_POST['money'];
	ssetcookie('name', $name, 31536000);
	ssetcookie('telephone', $telephone, 31536000);
	ssetcookie('auctionplace', $auctionplace, 31536000);
	$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('auctionbuy')." WHERE gid='$gid' order by id DESC");
	$value = $_SGLOBAL['db']->fetch_array($query);
	if($value){
	if($value['money']!=$money){
		echo"$value[money]";
	}else{
	$lasttime=$_SGLOBAL['timestamp']-$value['dateline'];
	if($lasttime>10){
			$query1 = $_SGLOBAL['db']->query("SELECT * FROM ".tname('auction')." WHERE auctionid='$gid'");
			$value1 = $_SGLOBAL['db']->fetch_array($query1);
			inserttable("auctionbuy",array('money'=>$value['money']+$value1['plusprice'],'name'=>$name,'dateline'=>$_SGLOBAL['timestamp'], 'gid'=>$gid,'tel'=>$telephone,'viewuid'=>$viewuid,'uid'=>$uid));	
			updatetable("auction",array('replynum'=>$value1['replynum']+'1'),array('uid'=>$viewuid,'auctionid'=>$gid));
	}
	}
	}else{

			$query1 = $_SGLOBAL['db']->query("SELECT * FROM ".tname('auction')." WHERE auctionid='$gid'");
			$value1 = $_SGLOBAL['db']->fetch_array($query1);
			inserttable("auctionbuy",array('money'=>"$value1[fristprice]",'name'=>$name,'dateline'=>$_SGLOBAL['timestamp'], 'gid'=>$gid,'tel'=>$telephone,'viewuid'=>$viewuid,'uid'=>$uid));	
			updatetable("auction",array('replynum'=>$value1['replynum']+'1'),array('uid'=>$viewuid,'auctionid'=>$gid));
	}
	
	/*echo '<script language="javascript">history.go(-1);</script>';*/
}
//活动执行代码
if($_POST['go']){
	$eventname=$_POST['eventname'];
	$eventtel=$_POST['eventtel'];
	$viewuid=$_POST['uid'];
	$uid=$_SGLOBAL['supe_uid'];
	$eid=$_POST['eid'];
	$wxkey=$_POST['wxkey'];
	ssetcookie('eventname', $eventname, 31536000);
	ssetcookie('eventtel', $eventtel, 31536000);
	$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('eventgo')." WHERE eid='$eid' and tel='$eventtel' order by id DESC");
	$value = $_SGLOBAL['db']->fetch_array($query);

	if($value){
	echo "1";
	}else{
	$lasttime=$_SGLOBAL['timestamp']-$value['dateline'];
	if($lasttime>10){
	inserttable("eventgo",array('username'=>$eventname,'dateline'=>$_SGLOBAL['timestamp'], 'eid'=>$eid,'tel'=>$eventtel,'uid'=>$viewuid));	
	}
	
	}
	/*echo '<script language="javascript">history.go(-1);</script>';*/
}

//查看密码执行代码
if($_POST['password1']){
	$password=trim($_POST['password']);
	$uid=$_POST['viewuid'];
	$gid=$_POST['gid'];
	$moblieclicknum=$_POST['moblieclicknum'];
	$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('goods')." WHERE uid='$uid' and goodsid='$gid'");
	$value = $_SGLOBAL['db']->fetch_array($query);
	$value['password']=trim($value['password']);
	if($value['password']==$password){
		$url_forward="$_SERVER[HTTP_REFERER]"."&zhong=1";
		header("HTTP/1.1 301 Moved Permanently");
		header("Location: $url_forward");	

	}else{	
	echo '<script charset="utf8" type="text/javascript" language="javascript">alert("密码错误");</script>';
	echo '<script language="javascript">history.go(-1);</script>';	
	}
	
}
//查看拍卖密码执行代码
if($_POST['auctionpassword1']){
	$auctionpassword=trim($_POST['auctionpassword']);
	$uid=$_POST['viewuid'];
	$gid=$_POST['gid'];
	$moblieclicknum=$_POST['moblieclicknum'];
	$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('auction')." WHERE uid='$uid' and auctionid='$gid'");
	$value = $_SGLOBAL['db']->fetch_array($query);
	$value['auctionpassword']=trim($value['auctionpassword']);
	if($value['auctionpassword']==$auctionpassword){
		$url_forward="$_SERVER[HTTP_REFERER]"."&zhong=1";
		header("HTTP/1.1 301 Moved Permanently");
		header("Location: $url_forward");	

	}else{	
	echo '<script charset="utf8" type="text/javascript" language="javascript">alert("密码错误");</script>';
	echo '<script language="javascript">history.go(-1);</script>';	
	}
	
}
//查看活动密码执行代码
if($_POST['eventpassword']){
	$password=trim($_POST['password']);
	$uid=$_POST['uid'];
	$eid=$_POST['eid'];
	$moblieclicknum=$_POST['moblieclicknum'];
	$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('event')." WHERE uid='$uid' and eventid='$eid'");
	$value = $_SGLOBAL['db']->fetch_array($query);
	$value['password']=trim($value['password']);
	if($value['password']==$password){
		$url_forward="$_SERVER[HTTP_REFERER]"."&zhong=1";
		header("HTTP/1.1 301 Moved Permanently");
		header("Location: $url_forward");	

	}else{	
	echo '<script charset="utf8" type="text/javascript" language="javascript">alert("密码错误");</script>';
	echo '<script language="javascript">history.go(-1);</script>';	
	}
	
}

//确认收货执行代码
if($_POST['goodscodid']){
	$goodscodid=trim($_POST['goodscodid']);
	$uid=trim($_POST['uid']);
	$gid=trim($_POST['gid']);
	$wxkey=$_POST['wxkey'];
	$viewuid=trim($_POST['viewuid']);
	$space=getspace($uid);
	$space1=getspace($viewuid);
	$fakeid=$space['fakeid'];
	
	
	if($goodscodid){
		updatetable("goodscod",array('status'=>'1','dateline1'=>$_SGLOBAL['timestamp']),array('id'=>$goodscodid));
		if($fakeid){
			$query1 = $_SGLOBAL['db']->query("SELECT * FROM ".tname('goods')." WHERE goodsid='$gid'");
	$value1 = $_SGLOBAL['db']->fetch_array($query1);
	$message="亲，你购买的商品$value1[subject]已经发货，请做好收货准备。<a href='http://v5.home3d.cn/home/wx/wx.php?do=detail&wxkey=".$wxkey."&id=$gid&uid=$viewuid&viewuid=$viewuid&idtype=goodsid&type=goods&moblieclicknum=$space1[moblieclicknum]'>点我瞬间查看</a>";
	$d = get_obj_by_xiaoquid($viewuid);
	$info = $d->sendWXSingleMsg($fakeid,$message);
	}
	echo '<script charset="utf8" language="javascript">alert("已发货确认成功");</script>';
	echo '<script language="javascript">history.go(-1);</script>';	
	}else{
		echo '<script charset="utf8" language="javascript">alert("获取id出错，请联系技术人员。");</script>';
	}
	
}
$codename=$_GET['codename'];
if($codename){
	$uid=$_GET['uid'];
	$id=$_GET['id'];
	$query2 = $_SGLOBAL['db']->query("SELECT * FROM ".tname('codebuy')." WHERE goodsid='$id' and uid='$uid'");
	while($value2 = $_SGLOBAL['db']->fetch_array($query2)){
		$code[]=$value2;
	}
include_once template("./wx/template/upload");
}
?>