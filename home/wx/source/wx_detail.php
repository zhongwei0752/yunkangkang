<?php

/*$m_auth = getAuth();


if(empty($m_auth)){
	$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('space')." WHERE wxkey='$_GET[wxkey]'");

	if ($value=$_SGLOBAL['db']->fetch_array($query)){
		updatetable('space', array('wxkey'=>''), array('uid'=>$value['uid']));
	}
	wxshowmessage('login_failure_please_re_login',  'wx.php?do=bind&wxkey='.$_GET['wxkey']);
}
*/


include_once( 'weibo/config.php' );
require_once '../common.php';
require_once 'wx_common.php';
include_once( CONNECT_ROOT.'/saetv2.ex.class.php' );
require_once CONNECT_ROOT."/common/jtee.inc.php";
require_once CONNECT_ROOT."/common/siteUserRegister.class.php";
require_once('Weixin.class.php');
	if($_GET['wxkey']){
	$rst = $_SGLOBAL['db']->query("SELECT * FROM ".tname('wxkey')." WHERE wxkey='$_GET[wxkey]'");
	$row = $_SGLOBAL['db']->fetch_array($rst);
	$rst1 = $_SGLOBAL['db']->query("SELECT * FROM ".tname('space')." WHERE wxkey='$_GET[wxkey]'");
	$row1 = $_SGLOBAL['db']->fetch_array($rst1);
	if($row){
		loaducenter();
		//include_once(S_ROOT.'./source/function_cp.php');
		//updateuserstat('hot');	
		$user = uc_get_user($row['uid'], 1); 
		uc_user_synlogin($row['uid']);
		$auth = setSession($user[0],$user[1]);
		$viewuid=$row['uid'];
		ssetcookie('viewuid',$viewuid, 31536000);			
		//showmessage($user[0]);
}elseif($row1){
		loaducenter();
		//showmessage("$row[uid]");
		//include_once(S_ROOT.'./source/function_cp.php');
		//updateuserstat('hot');	
		$user = uc_get_user($row1['uid'], 1); 
		uc_user_synlogin($row1['uid']);
		$auth = setSession($user[0],$user[1]);
		$viewuid=$row1['uid'];
		ssetcookie('viewuid',$viewuid, 31536000);		
		//showmessage($user[0]);
	}
}

$type=$_GET['type'];
$typeid=$type."id";
$field=$type."field";
$typepic=$type."pic";
$COOKIE=urldecode($_COOKIE['usernickname']); 
$uid=$_GET['uid'];
$id=$_GET['id'];
$cookuid=$_COOKIE['uchome_viewuid'];
$viewuid=$_SGLOBAL['supe_uid'];

$query1 = $_SGLOBAL['db']->query("SELECT * FROM ".tname('menuset')." WHERE english='$type'");
$appsubject = $_SGLOBAL['db']->fetch_array($query1);
if($_COOKIE["uchome_view_".$type]!= $id) {
	$_SGLOBAL['db']->query("UPDATE ".tname($type)." SET viewnum=viewnum+1 WHERE $typeid='$id'");
	ssetcookie("view_$type",$id);
	}
	if($_COOKIE["uchome_view_".$typeid]!= $typeid) {
include_once(S_ROOT.'./source/function_feed.php');

feed_publish($type, 'viewid',$viewuid,$uid,$id);
$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('credit')."  WHERE uid=$_SGLOBAL[supe_uid] AND fatheruid='$uid'");
$value = $_SGLOBAL['db']->fetch_array($query);
if($value){
	$value['credit']=$value['credit']+"10";
	updatetable("credit",array('credit'=>$value['credit']),array('uid'=>$_SGLOBAL['supe_uid'],'fatheruid'=>$uid));	
}else{
	inserttable("credit",array('credit'=>"10",'uid'=>$_SGLOBAL['supe_uid'],'fatheruid'=>$uid));
}


}
ssetcookie("view_$typeid",$typeid);
ssetcookie("view_$type",$id);
if($_GET['type']=="job"){
	$query = $_SGLOBAL['db']->query("SELECT bf.*, b.* FROM ".tname('job')." b LEFT JOIN ".tname('jobfield')." bf ON bf.jobid=b.jobid WHERE b.jobid='$id' AND b.uid='$uid'");
	$zhong = $_SGLOBAL['db']->fetch_array($query);
	require_once '../source/function_common.php';
	$uidwxkey=getspace($uid);

		if($uidwxkey['moblieclicknum']=="0"||$uidwxkey['moblieclicknum']=="1"||$uidwxkey['moblieclicknum']=="3"||$uidwxkey['moblieclicknum']=="4"||$uidwxkey['moblieclicknum']=="5"||$uidwxkey['moblieclicknum']=="6"||$uidwxkey['moblieclicknum']=="7"){
		include_once template("./wx/template/detailcontent");
		
		}else{
		include_once template("./wx/template/$uidwxkey[moblieclicknum]/detailcontent");	
		}
}elseif($_GET['type']=="dialog"){
		require_once '../source/function_common.php';
		$uidwxkey=getspace($uid);
		$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('questions')."  WHERE q_uid='$_GET[viewuid]' AND id='$_GET[id]'");
		$dialog = $_SGLOBAL['db']->fetch_array($query);
		if($uidwxkey['moblieclicknum']=="0"||$uidwxkey['moblieclicknum']=="1"||$uidwxkey['moblieclicknum']=="3"||$uidwxkey['moblieclicknum']=="4"||$uidwxkey['moblieclicknum']=="5"||$uidwxkey['moblieclicknum']=="6"||$uidwxkey['moblieclicknum']=="7"){
		include_once template("./wx/template/dialogcontent");

		
	}else{
	include_once template("./wx/template/$uidwxkey[moblieclicknum]/dialogcontent");
	
	}
}elseif($_GET['type']=="event"){
    $query = $_SGLOBAL['db']->query("SELECT bf.*, b.* FROM ".tname($type)." b LEFT JOIN ".tname($field)." bf ON bf.$typeid=b.$typeid WHERE b.$typeid='$id' AND b.uid='$uid'");
	$wei = $_SGLOBAL['db']->fetch_array($query);
	$query1 = $_SGLOBAL['db']->query("SELECT bf.*, b.* FROM ".tname($type)." b LEFT JOIN ".tname('eventclass')." bf ON bf.classid=b.classid");
	$wei1 = $_SGLOBAL['db']->fetch_array($query1);
	$query2 = $_SGLOBAL['db']->query("SELECT bf.*, b.* FROM ".tname('eventgo')." b LEFT JOIN ".tname($type)." bf ON b.eid=bf.$typeid WHERE bf.$typeid='$id' AND b.uid='$uid'");
	$wei2 = $_SGLOBAL['db']->fetch_array($query2);
	$message=$wei['message1'];
	$message = preg_replace("'width[^>]*?;'si", "", $message);
	$message = preg_replace("'height[^>]*?;'si", "", $message);
	if($wei['pic']){
	$typepic="<img src='../attachment/$wei[pic]'>";
	$pic ="http://v5.home3d.cn/home/attachment/".$wei['pic'];
    $pic = str_replace("http://v5.home3d.cn/home/http://v5.home3d.cn/home/attachment/","http://v5.home3d.cn/home/attachment/",$pic);
    $pic = str_replace("http://v5.home3d.cn/home/attachment/http://v5.home3d.cn/home/","http://v5.home3d.cn/home/",$pic);
    $pic = str_replace("http://v5.home3d.cn/home/attachment/attachment/","http://v5.home3d.cn/home/attachment/",$pic);
	}else{
	$typepic="";
	}
	$url="http://v5.home3d.cn/home/wx/wx.php?do=detail&id=$_GET[id]&uid=$_GET[uid]&idtype=$_GET[idtype]&type=$_GET[type]&viewuid=$_GET[uid]&moblieclicknum=$_GET[moblieclicknum]";
	$uidwxkey=getspace($uid);
	$query3 = $_SGLOBAL['db']->query("SELECT * FROM ".tname('eventgo')." WHERE eid='$id' and uid='$_COOKIE[uchome_viewuid]'");
    $value3 = $_SGLOBAL['db']->fetch_array($query3);

     
    if($_GET['moblieclicknum']=="0"||$_GET['moblieclicknum']=="1"||$_GET['moblieclicknum']=="3"||$_GET['moblieclicknum']=="4"||$_GET['moblieclicknum']=="5"||$_GET['moblieclicknum']=="6"||$_GET['moblieclicknum']=="7"){
	include_once template("./wx/template/eventcontent");	
	}else{
	
	include_once template("./wx/template/$_GET[moblieclicknum]/eventcontent");}

}elseif($_GET['type']=="seckill"){
		$query = $_SGLOBAL['db']->query("SELECT bf.*, b.* FROM ".tname($type)." b LEFT JOIN ".tname($field)." bf ON bf.$typeid=b.$typeid WHERE b.$typeid='$id' AND b.uid='$uid'");
	$wei = $_SGLOBAL['db']->fetch_array($query);
	$message=$wei['message1'];
	$message = preg_replace("'width[^>]*?;'si", "", $message);
	$message = preg_replace("'height[^>]*?;'si", "", $message);
	if($wei['pic']){
	$typepic="<img src='../attachment/$wei[pic]'>";
	$pic ="http://v5.home3d.cn/home/attachment/".$wei['pic'];
    $pic = str_replace("http://v5.home3d.cn/home/http://v5.home3d.cn/home/attachment/","http://v5.home3d.cn/home/attachment/",$pic);
    $pic = str_replace("http://v5.home3d.cn/home/attachment/http://v5.home3d.cn/home/","http://v5.home3d.cn/home/",$pic);
    $pic = str_replace("http://v5.home3d.cn/home/attachment/attachment/","http://v5.home3d.cn/home/attachment/",$pic);
	}else{
	$typepic="";
	}
	$url="http://v5.home3d.cn/home/wx/wx.php?do=detail&id=$_GET[id]&uid=$_GET[uid]&idtype=$_GET[idtype]&type=$_GET[type]&viewuid=$_GET[uid]&moblieclicknum=$_GET[moblieclicknum]";

	$query1 = $_SGLOBAL['db']->query("SELECT bf.*, b.* FROM ".tname('space')." b LEFT JOIN ".tname('spacefield')." bf ON bf.uid=b.uid WHERE  b.uid='$uid'");
	$space = $_SGLOBAL['db']->fetch_array($query1);
	require_once '../source/function_common.php';
	$uidwxkey=getspace($uid);
	//$count2 = $_SGLOBAL['db']->result($_SGLOBAL['db']->query("SELECT COUNT(*) FROM ".tname('seckillbuy')."  WHERE viewuid='$uid'"),0);
	//$query2 = $_SGLOBAL['db']->query("SELECT * FROM ".tname('seckillbuy')." WHERE viewuid='$uid'");
	//while($value2=$_SGLOBAL['db']->fetch_array($query2)){
	//	$wei2[]=$value2;
	//}
	$time=$wei['starttime0']*1000-$_SGLOBAL['timestamp']*1000;
	$time1=$wei['endtime']*1000-$_SGLOBAL['timestamp']*1000;
	//查看是否已经参与秒杀
	$hasseckilled = $_SGLOBAL['db']->result($_SGLOBAL['db']->query("SELECT COUNT(*) FROM ".tname('seckillbuy')."  WHERE uid='$_COOKIE[uchome_viewuid]' AND gid='$id' "),0);
	
	$query2 = $_SGLOBAL['db']->query("SELECT * FROM ".tname('seckillbuy')." WHERE  gid='$id' order by id DESC LIMIT 5");
	while($seckillbuy = $_SGLOBAL['db']->fetch_array($query2))
	{
		$query3=$_SGLOBAL['db']->query("SELECT * FROM ".tname('seckillbuy')." WHERE  id='$seckillbuy[id]'");
		$value3=$_SGLOBAL['db']->fetch_array($query3);
		$seckillbuy['name']=$value3['name'];
		$seckillbuy['tel']=$value3['tel'];
		$seclist[]=$seckillbuy;
	}
	if($_GET['moblieclicknum']=="0"||$_GET['moblieclicknum']=="1"||$_GET['moblieclicknum']=="3"||$_GET['moblieclicknum']=="4"||$_GET['moblieclicknum']=="5"||$_GET['moblieclicknum']=="6"||$_GET['moblieclicknum']=="7"){
	include_once template("./wx/template/seckillcontent");	
	}else{
	
	include_once template("./wx/template/$_GET[moblieclicknum]/seckillcontent");
}
}
elseif($_GET['type']=="booking")//预约
{
	$query=$_SGLOBAL['db']->query("SELECT * FROM ".tname('booking')." WHERE $typeid='$id'");
	$bookingvalue=$_SGLOBAL['db']->fetch_array($query);

	$query1=$_SGLOBAL['db']->query("SELECT * FROM ".tname('bookingjoin')." WHERE $typeid='$id' and uid='$uid'");
	$joinvalue=$_SGLOBAL['db']->fetch_array($query1);

	include_once template("./wx/template/bookingcontent");

}
elseif($_GET['type']=="explaining")//报读
{
	$query=$_SGLOBAL['db']->query("SELECT * FROM ".tname('explaining')." WHERE $typeid='$id'");
	$explainingvalue=$_SGLOBAL['db']->fetch_array($query);

	$query1=$_SGLOBAL['db']->query("SELECT * FROM ".tname('explainingjoin')." WHERE $typeid='$id' and uid='$uid'");
	$joinvalue=$_SGLOBAL['db']->fetch_array($query1);

	include_once template("./wx/template/explainingcontent");

}
elseif($_GET['type']=="bookingsuccess")
{
	$number = $_GET['number'];
	$id = $_GET['id'];
	$uid = $_GET['uid'];
	include_once template("./wx/template/booking_success");


}
elseif($_GET['type']=="explainingsuccess")
{
	$number = $_GET['number'];
	$id = $_GET['id'];
	include_once template("./wx/template/explaining_success");


}
elseif($_GET['type']=="auction"){
	$query = $_SGLOBAL['db']->query("SELECT bf.*, b.* FROM ".tname($type)." b LEFT JOIN ".tname($field)." bf ON bf.$typeid=b.$typeid WHERE b.$typeid='$id' AND b.uid='$uid'");
	$wei = $_SGLOBAL['db']->fetch_array($query);
	$yan = $_SGLOBAL['db']->result($_SGLOBAL['db']->query("SELECT COUNT(*) FROM ".tname('auctionbuy')."  WHERE gid='$wei[auctionid]'"),0);
	$wei['yan']=$yan;
	$message=$wei['message1'];
	$message = preg_replace("'width[^>]*?;'si", "", $message);
	$message = preg_replace("'height[^>]*?;'si", "", $message);
	if($wei['pic']){
	$typepic="<img src='../attachment/$wei[pic]'>";
	$pic ="http://v5.home3d.cn/home/attachment/".$wei['pic'];
    $pic = str_replace("http://v5.home3d.cn/home/http://v5.home3d.cn/home/attachment/","http://v5.home3d.cn/home/attachment/",$pic);
    $pic = str_replace("http://v5.home3d.cn/home/attachment/http://v5.home3d.cn/home/","http://v5.home3d.cn/home/",$pic);
    $pic = str_replace("http://v5.home3d.cn/home/attachment/attachment/","http://v5.home3d.cn/home/attachment/",$pic);
	}else{
	$typepic="";
	}
	$url="http://v5.home3d.cn/home/wx/wx.php?do=detail&id=$_GET[id]&uid=$_GET[uid]&idtype=$_GET[idtype]&type=$_GET[type]&viewuid=$_GET[uid]&moblieclicknum=$_GET[moblieclicknum]";

	$query1 = $_SGLOBAL['db']->query("SELECT bf.*, b.* FROM ".tname('space')." b LEFT JOIN ".tname('spacefield')." bf ON bf.uid=b.uid WHERE  b.uid='$uid'");
	$space = $_SGLOBAL['db']->fetch_array($query1);
	require_once '../source/function_common.php';
	$uidwxkey=getspace($uid);
	//$count2 = $_SGLOBAL['db']->result($_SGLOBAL['db']->query("SELECT COUNT(*) FROM ".tname('auctionbuy')."  WHERE viewuid='$uid'"),0);
	//$query2 = $_SGLOBAL['db']->query("SELECT * FROM ".tname('auctionbuy')." WHERE viewuid='$uid'");
	//while($value2=$_SGLOBAL['db']->fetch_array($query2)){
	//	$wei2[]=$value2;
	//}
	$time=$wei['starttime0']*1000-$_SGLOBAL['timestamp']*1000;
	$time1=$wei['endtime']*1000-$_SGLOBAL['timestamp']*1000;
	$query2 = $_SGLOBAL['db']->query("SELECT * FROM ".tname('auctionbuy')." WHERE  gid='$id' order by id DESC");
	$auctionbuy = $_SGLOBAL['db']->fetch_array($query2);
	$money=$auctionbuy['money'];
	if(empty($money)){
		$trymoney=$wei['fristprice'];
	}else{
		$trymoney=$auctionbuy['money']+$wei['plusprice'];
	}
	if($_GET['moblieclicknum']=="0"||$_GET['moblieclicknum']=="1"||$_GET['moblieclicknum']=="3"||$_GET['moblieclicknum']=="4"||$_GET['moblieclicknum']=="5"||$_GET['moblieclicknum']=="6"||$_GET['moblieclicknum']=="7"){
	include_once template("./wx/template/auctioncontent");	
	}else{
	
	include_once template("./wx/template/$_GET[moblieclicknum]/auctioncontent");
}
}elseif($_GET['type']=="debate"){
	$query0=$_SGLOBAL['db']->query("SELECT * FROM ".tname('space')." WHERE uid='$_GET[viewuid]'");
	$yan=$_SGLOBAL['db']->fetch_array($query0);
	$query=$_SGLOBAL['db']->query("SELECT * FROM ".tname('debate')." WHERE $typeid='$id'");
	$wei=$_SGLOBAL['db']->fetch_array($query);
	$message=$wei['message'];
	$message = preg_replace("'width[^>]*?;'si", "", $message);
	$message = preg_replace("'height[^>]*?;'si", "", $message);
	//读取已经投票的id
	$obvoteuids=empty($wei['obvoteuids'])?array():explode(',',$wei['obvoteuids']);
	$revoteuids=empty($wei['revoteuids'])?array():explode(',',$wei['revoteuids']);
	$query1=$_SGLOBAL['db']->query("SELECT * FROM ".tname('debate_comment')." WHERE debatetype=0 AND $typeid='$id' ORDER BY cid DESC LIMIT 5");
	while($wei1=$_SGLOBAL['db']->fetch_array($query1))
	{
		$query3=$_SGLOBAL['db']->query("SELECT * FROM ".tname('debate_comment')." WHERE cid='$wei1[cid]'");
		$wei3=$_SGLOBAL['db']->fetch_array($query3);
		$wei1['author']=$wei3['author'];
		$wei1['message']=$wei3['message'];
		$list1[]=$wei1;
	}
	$yan0=$_SGLOBAL['db']->query("SELECT * FROM ".tname('debate_comment')." WHERE debatetype=0 AND $typeid='$id' ORDER BY cid DESC ");
	while($zong0=$_SGLOBAL['db']->fetch_array($yan0))
	{
		$yan1=$_SGLOBAL['db']->query("SELECT * FROM ".tname('debate_comment')." WHERE cid='$zong0[cid]'");
		$zong1=$_SGLOBAL['db']->fetch_array($yan1);
		$zong0['author']=$zong1['author'];
		$dlist[]=$zong0;
	}
	$query2=$_SGLOBAL['db']->query("SELECT * FROM ".tname('debate_comment')." WHERE debatetype=1 AND $typeid='$id'  ORDER BY cid DESC LIMIT 5");
	while($wei2=$_SGLOBAL['db']->fetch_array($query2))
	{
		$query4=$_SGLOBAL['db']->query("SELECT * FROM ".tname('debate_comment')." WHERE cid='$wei2[cid]'");
		$wei4=$_SGLOBAL['db']->fetch_array($query4);
		$wei2['author']=$wei4['author'];
		$wei2['message']=$wei4['message'];
		$list2[]=$wei2;
	}
	$yan2=$_SGLOBAL['db']->query("SELECT * FROM ".tname('debate_comment')." WHERE debatetype=1 AND $typeid='$id' ORDER BY cid DESC ");
	while($zong2=$_SGLOBAL['db']->fetch_array($yan2))
	{
		$yan3=$_SGLOBAL['db']->query("SELECT * FROM ".tname('debate_comment')." WHERE cid='$zong2[cid]'");
		$zong3=$_SGLOBAL['db']->fetch_array($yan3);
		$zong2['author']=$zong3['author'];
		$dlist1[]=$zong2;
	}


	include_once template("./wx/template/debatecontent");
		
}
elseif($_GET['type']=="poll"){
	$query0=$_SGLOBAL['db']->query("SELECT * FROM ".tname('space')." WHERE uid='$_GET[uid]'");
	$yan=$_SGLOBAL['db']->fetch_array($query0);
	//读取poll表中的作者，
	$query=$_SGLOBAL['db']->query("SELECT * FROM ".tname('poll')." WHERE $typeid='$id'");
	$wei=$_SGLOBAL['db']->fetch_array($query);
	//提取评论内容
	$query1=$_SGLOBAL['db']->query("SELECT * FROM ".tname('poll_comment')." WHERE $typeid='$id' ORDER BY cid DESC LIMIT 5");
	while($wei1=$_SGLOBAL['db']->fetch_array($query1))
	{
		$query2=$_SGLOBAL['db']->query("SELECT * FROM ".tname('poll_comment')." WHERE cid='$wei1[cid]'");
		$wei2=$_SGLOBAL['db']->fetch_array($query2);
		$wei1['author']=$wei2['author'];
		$wei1['message']=$wei2['message'];
		$list1[]=$wei1;
	}
	//设置投票后的点击图标
	$alpha="A B C D E F G H I J K L M N";
	$alpha1=explode(" ",$alpha);
	//提取message内容
	$query3=$_SGLOBAL['db']->query("SELECT * FROM ".tname('pollfield')." WHERE $typeid='$id'");
	$wei3=$_SGLOBAL['db']->fetch_array($query3);
	$message=$wei3['message'];
	$message = preg_replace("'width[^>]*?;'si", "", $message);
	$message = preg_replace("'height[^>]*?;'si", "", $message);
	//提取投票选项里面的东西
	$query4= $_SGLOBAL['db']->query("SELECT * FROM ".tname('polloption')." WHERE pollid='$id' ORDER BY oid");
	while($value4= $_SGLOBAL['db']->fetch_array($query4)) {
		$allvote += intval($value4['votenum']);
		$option[] = $value4;
	}
	$i=0;
	foreach($option as $key => $value) {
		if($value['votenum'] && $allvote) {
			$value['percent'] = round($value['votenum']/$allvote, 2);
			$value['width'] = round($value['percent']*160);
			$value['percent'] = $value['percent']*100;
			$value['i']=$i++;
		} else {
			$value['width'] = $value['percent'] = 0;
			$value['i']=$i++;
		}
		$option[$key] = $value;
		
	}
	//查看该人有没有参加投票
	$hasvoted = $_SGLOBAL['db']->result($_SGLOBAL['db']->query("SELECT COUNT(*) FROM ".tname('polluser')."  WHERE uid='$_COOKIE[uchome_viewuid]' AND pollid='$id' "),0);
	/*while($yan1=$_SGLOBAL['db']->fetch_array($hasvote))
	{
		$query5=$_SGLOBAL['db']->query("SELECT uid FROM ".tname('polluser')."  WHERE pollid='$yan1['pollid']' "));
		$value5=$_SGLOBAL['db']->fetch_array($query5);
		$hasvoted[]=$value5['uid'];
	}*/
	include_once template("./wx/template/pollcontent");
		
}
elseif($_GET['type']=="stratch"){
	$query0=$_SGLOBAL['db']->query("SELECT * FROM ".tname('space')." WHERE uid='$_GET[uid]'");
	$yan=$_SGLOBAL['db']->fetch_array($query0);
	$yan1=$_SGLOBAL['db']->query("SELECT * FROM ".tname('space')." WHERE uid='$_COOKIE[uchome_viewuid]'");
	$zong=$_SGLOBAL['db']->fetch_array($yan1);
	$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname($type)." WHERE $typeid='$id'");
	$wei = $_SGLOBAL['db']->fetch_array($query);
	$message=$wei['message'];
	$message = preg_replace("'width[^>]*?;'si", "", $message);
	$message = preg_replace("'height[^>]*?;'si", "", $message);
	$query1 = $_SGLOBAL['db']->query("SELECT * FROM ".tname('stratch_content')." WHERE open='1'");
	$wei1 = $_SGLOBAL['db']->fetch_array($query1);
	/*获奖信息*/
	function get_rand($proArr) { 
		$result = ''; 
		//概率数组的总概率精度 
		$proSum = array_sum($proArr); 
	 
		//概率数组循环 
		foreach ($proArr as $key => $proCur) { 
			$randNum = mt_rand(1, $proSum); 
			if ($randNum <= $proCur) { 
				$result = $key; 
				break; 
			} else { 
				$proSum -= $proCur; 
			} 
		} 
		return $result; 
	} 
	//获得该有的总数
	if($wei[fenmu]==0)
	{$sum=1000;}
	else if($wei[fenmu]==1)
	{$sum=10000;}
	else if($wei[fenmu]==2)
	{$sum=100000;}
	else if($wei[fenmu]==3)
	{$sum=1000000;}
	else if($wei[fenmu]==4)
	{$sum=10000000;}
	//奖励数组
	$prize_arr = array( 
		'0' => array('id'=>1,'prize'=>'一等奖','v'=>$wei[chance1]), 
		'1' => array('id'=>2,'prize'=>'二等奖','v'=>$wei[chance2]), 
		'2' => array('id'=>3,'prize'=>'三等奖','v'=>$wei[chance3]), 
		'3' => array('id'=>4,'prize'=>'谢谢参与','v'=>($sum-$wei[chance1]-$wei[chance2]-$wei[chance3])),	
	); 
	//showmessage($wei[chance3]);
	foreach ($prize_arr as $key => $val) { 
    $arr[$val['id']] = $val['v']; 
	} 
	 
	//$rid = get_rand($arr); //根据概率获取奖项id 
	//查询此人参与该活动次数
	//$query2 = $_SGLOBAL['db']->query("SELECT * FROM ".tname('stratchment')." WHERE stratchid='$id' AND username='$_GET[wxkey]'");
	$query2 = $_SGLOBAL['db']->query("SELECT * FROM ".tname('stratchment')." WHERE stratchid='$id' AND uid='$_COOKIE[uchome_viewuid]'");
	$wei2 = $_SGLOBAL['db']->fetch_array($query2);
	//stratchment插入数据
	if(empty($wei2))
	{
		$rid = get_rand($arr);
		inserttable('stratchment',array('uid'=>$_COOKIE['uchome_viewuid'],'stratchid'=>$id,'award_id'=>$rid,'username'=>$zong['name']));
		updatetable('stratch',array('joinsum'=>$wei['joinsum']+1),array('stratchid'=>$id));
	}
	//查询此人是否参加该活动
	$query3 = $_SGLOBAL['db']->query("SELECT * FROM ".tname('stratchment')." WHERE stratchid='$id' AND uid='$_COOKIE[uchome_viewuid]'");
	$wei3 = $_SGLOBAL['db']->fetch_array($query3);

	//读取获得奖项的人的数据
	$query4=$_SGLOBAL['db']->query("SELECT * FROM ".tname('stratchment')." WHERE stratchid='$id' AND award_id<4");
	while ($value4=$_SGLOBAL['db']->fetch_array($query4)) 
	{
		$query5=$_SGLOBAL['db']->query("SELECT * FROM ".tname('stratchment')." WHERE cid='$value4[cid]'");
		$value5=$_SGLOBAL['db']->fetch_array($query5);
		$value4['username']=$value5['username'];
		$value4['number']=$value5['number'];
		$value4['dateline']=$value5['dateline'];
		$list[]=$value4;
	}
	if($rid==1)
	{
		if($wei1['win1']<($wei['winsum1']-1)){
			updatetable('stratch_content', array('win1'=>$wei1['win1']+1),array('stratchid'=>$id));
		}
		else{
			updatetable('stratch_content', array('win1'=>$wei1['win1']+1),array('stratchid'=>$id));
			updatetable('stratch',array('chance1'=>0),array('stratchid'=>$id));
		}
	}else if($rid==2)
	{	
		if($wei1['win2']<($wei['winsum2']-1)){
			updatetable('stratch_content', array('win2'=>$wei1['win2']+1),array('stratchid'=>$id));
		}
		else{
			updatetable('stratch_content', array('win2'=>$wei1['win2']+1),array('stratchid'=>$id));
			updatetable('stratch',array('chance2'=>0),array('stratchid'=>$id));
		}
	}else if($rid==3)
	{
		if($wei1['win3']<($wei['winsum3']-1)){
			updatetable('stratch_content', array('win3'=>$wei1['win3']+1),array('stratchid'=>$id));
		}
		else{
			updatetable('stratch_content', array('win3'=>$wei1['win3']+1),array('stratchid'=>$id));
			updatetable('stratch',array('chance3'=>0),array('stratchid'=>$id));
		}
	}
	$res['yes'] = $prize_arr[$rid-1]['prize']; //中奖项
	//unset($prize_arr[$rid-1]); //将中奖项从数组中剔除，剩下未中奖项 	
	shuffle($prize_arr); //打乱数组顺序 
	for($i=0;$i<count($prize_arr);$i++){ 
		$pr[] = $prize_arr[$i]['prize']; 
	} 
	$res['no'] = $pr;
	if($wei['pic']){
	$typepic="<img src='../$wei[pic]'>";
	$pic ="http://v5.home3d.cn/home/".$wei['pic'];
    $pic = str_replace("http://v5.home3d.cn/home/attachment/http://v5.home3d.cn/home/attachment/","http://v5.home3d.cn/home/attachment/",$pic);
    $pic = str_replace("http://v5.home3d.cn/home/attachment/http://v5.home3d.cn/home/attachment/","http://v5.home3d.cn/home/attachment/",$pic);
    $pic = str_replace("http://v5.home3d.cn/home/attachment/attachment/","http://v5.home3d.cn/home/attachment/",$pic);
	}else{
	$typepic="";
	}
	$url="http://v5.home3d.cn/home/wx/wx.php?do=detail&id=$_GET[id]&uid=$_GET[uid]&idtype=$_GET[idtype]&type=$_GET[type]&viewuid=$_GET[uid]&moblieclicknum=$_GET[moblieclicknum]";
	$haswined = $_SGLOBAL['db']->result($_SGLOBAL['db']->query("SELECT COUNT(*) FROM ".tname('stratchment')."  WHERE stratchid='$id' AND award_id<4 "),0);

	include_once template("./wx/template/stratchcontent");	

}elseif($_GET['type']=="goods"){
	$query = $_SGLOBAL['db']->query("SELECT bf.*, b.* FROM ".tname($type)." b LEFT JOIN ".tname($field)." bf ON bf.$typeid=b.$typeid WHERE b.$typeid='$id' AND b.uid='$uid'");
	$wei = $_SGLOBAL['db']->fetch_array($query);
	$query2 = $_SGLOBAL['db']->query("SELECT * FROM ".tname('code')." WHERE uid='$uid'");
	while($value2=$_SGLOBAL['db']->fetch_array($query2)){
		if($value2['push']=='0'){
			$code='1';
		}
		if($value2['push']==$id){
			$code='1';
		}
	}
	
	$message=$wei['message1'];
	$message = preg_replace("'width[^>]*?;'si", "", $message);
	$message = preg_replace("'height[^>]*?;'si", "", $message);
	if($wei['pic']){
	$typepic="<img src='../attachment/$wei[pic]'>";
	$pic ="http://v5.home3d.cn/home/attachment/".$wei['pic'];
    $pic = str_replace("http://v5.home3d.cn/home/http://v5.home3d.cn/home/attachment/","http://v5.home3d.cn/home/attachment/",$pic);
    $pic = str_replace("http://v5.home3d.cn/home/attachment/http://v5.home3d.cn/home/","http://v5.home3d.cn/home/",$pic);
    $pic = str_replace("http://v5.home3d.cn/home/attachment/attachment/","http://v5.home3d.cn/home/attachment/",$pic);
	}else{
	$typepic="";
	}
	$url="http://v5.home3d.cn/home/wx/wx.php?do=detail&id=$_GET[id]&uid=$_GET[uid]&idtype=$_GET[idtype]&type=$_GET[type]&viewuid=$_GET[uid]&moblieclicknum=$_GET[moblieclicknum]";

	$query1 = $_SGLOBAL['db']->query("SELECT bf.*, b.* FROM ".tname('space')." b LEFT JOIN ".tname('spacefield')." bf ON bf.uid=b.uid WHERE  b.uid='$uid'");
	$space = $_SGLOBAL['db']->fetch_array($query1);
	require_once '../source/function_common.php';
	$uidwxkey=getspace($uid);
	$count2 = $_SGLOBAL['db']->result($_SGLOBAL['db']->query("SELECT COUNT(*) FROM ".tname('goodscod')."  WHERE viewuid='$uid'"),0);
	$query2 = $_SGLOBAL['db']->query("SELECT * FROM ".tname('goodscod')." WHERE viewuid='$uid'");
	while($value2=$_SGLOBAL['db']->fetch_array($query2)){
		$wei2[]=$value2;
	}
	if($_GET['moblieclicknum']=="0"||$_GET['moblieclicknum']=="1"||$_GET['moblieclicknum']=="3"||$_GET['moblieclicknum']=="4"||$_GET['moblieclicknum']=="5"||$_GET['moblieclicknum']=="6"||$_GET['moblieclicknum']=="7"){
	include_once template("./wx/template/goodscontent");	
	}else{
	
	include_once template("./wx/template/$_GET[moblieclicknum]/goodscontent");
}

}elseif($_GET['type']=="explain")
{
	include_once template("./wx/template/explaincontent");

}
else{
	$query = $_SGLOBAL['db']->query("SELECT bf.*, b.* FROM ".tname($type)." b LEFT JOIN ".tname($field)." bf ON bf.$typeid=b.$typeid WHERE b.$typeid='$id' AND b.uid='$uid'");
	$wei = $_SGLOBAL['db']->fetch_array($query);
	$message=$wei['message1'];
	$message = preg_replace("'width[^>]*?;'si", "", $message);
	$message = preg_replace("'height[^>]*?;'si", "", $message);
	if($wei['pic']){
	$typepic="<img src='../attachment/$wei[pic]'>";
	$pic ="http://v5.home3d.cn/home/attachment/".$wei['pic'];
    $pic = str_replace("http://v5.home3d.cn/home/http://v5.home3d.cn/home/attachment/","http://v5.home3d.cn/home/attachment/",$pic);
    $pic = str_replace("http://v5.home3d.cn/home/attachment/http://v5.home3d.cn/home/","http://v5.home3d.cn/home/",$pic);

     $table=$_GET['type'];
     $query10 = $_SGLOBAL['db']->query("SELECT bf.*, b.* FROM ".tname('appset')." bf 
				LEFT JOIN ".tname('menuset')." b ON bf.num=b.menusetid
				WHERE b.english='$table' and bf.uid='$uid'");
			$value1 = $_SGLOBAL['db']->fetch_array($query10);
			if($value1['newname']){
			$appname=$value1['newname'];
			}else{
			$appname=$value1['subject'];

			}


}else{
	$typepic="";
}
$url="http://v5.home3d.cn/home/wx/wx.php?do=detail&id=$_GET[id]&uid=$_GET[uid]&idtype=$_GET[idtype]&type=$_GET[type]&viewuid=$_GET[uid]&moblieclicknum=$_GET[moblieclicknum]";
require_once '../source/function_common.php';
$uidwxkey=getspace($uid);



$abc = $_SGLOBAL['db']->query("SELECT * FROM ".tname('space')." WHERE uid='$uid'");
	$bac = $_SGLOBAL['db']->fetch_array($abc);
	
	if($bac['moblieclicknum']=="0"||$bac['moblieclicknum']=="1"||$bac['moblieclicknum']=="3"||$bac['moblieclicknum']=="4"||$bac['moblieclicknum']=="5"||$bac['moblieclicknum']=="6"||$bac['moblieclicknum']=="7"){
		include_once template("./wx/template/feedcontent");
	}else{
		include_once template("./wx/template/$bac[moblieclicknum]/feedcontent");
	
}
}

?>