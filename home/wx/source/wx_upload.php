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
	$discode=$_POST['discode'];
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
		$query4 = $_SGLOBAL['db']->query("SELECT * FROM ".tname('codebuy')." WHERE codepassword='$code' and goodsid=$gid and status='0'");
		$value4 = $_SGLOBAL['db']->fetch_array($query4);
		
		if($value4){
			if($value4['tel']!=$tel){
			echo"2";
		}else{
		inserttable("goodscod",array('username'=>$username,'codestatus'=>'1','dateline'=>$_SGLOBAL['timestamp'], 'gid'=>$gid,'tel'=>$tel,'number'=>$number,'place'=>$place,'viewuid'=>$viewuid,'uid'=>$uid));	
		updatetable("codebuy",array('status'=>'1'),array('codepassword'=>$code));
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
		for($i=0;$i<3;$i++){
		while(true){
		$a=rand(100000,999999);
		$query3 = $_SGLOBAL['db']->query("SELECT * FROM ".tname('codebuy')." WHERE codepassword='$a' and status='0'");
		$value3 = $_SGLOBAL['db']->fetch_array($query3);
		if(empty($value3)){
			inserttable("codebuy",array('codepassword'=>$a,'goodsid'=>$gid,'uid'=>$viewuid,'codename'=>$username));
			break;
			}	
		}
		
		}
	}
		}else{
		echo"1";	
		}
	
		}else{
		inserttable("goodscod",array('username'=>$username,'dateline'=>$_SGLOBAL['timestamp'], 'gid'=>$gid,'tel'=>$tel,'number'=>$number,'place'=>$place,'viewuid'=>$viewuid,'uid'=>$uid));
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
		if($discode=='1'){
			for($i=0;$i<3;$i++){
		while(true){
		$a=rand(100000,999999);
		$query3 = $_SGLOBAL['db']->query("SELECT * FROM ".tname('codebuy')." WHERE codepassword='$a' and status='0'");
		$value3 = $_SGLOBAL['db']->fetch_array($query3);
		if(empty($value3)){
			inserttable("codebuy",array('codepassword'=>$a,'goodsid'=>$gid,'uid'=>$viewuid,'codename'=>$username));
			break;
			}	
		}
		
		}
	}
		
		}
	
	}
	}else{
		if($code){
		$query4 = $_SGLOBAL['db']->query("SELECT * FROM ".tname('codebuy')." WHERE codepassword='$code' and goodsid=$gid and status='0'");
		$value4 = $_SGLOBAL['db']->fetch_array($query4);
		if($value4){
		if($value4['tel']!=$tel){
			echo"2";
		}else{
		inserttable("goodscod",array('username'=>$username,'codestatus'=>'1','dateline'=>$_SGLOBAL['timestamp'], 'gid'=>$gid,'tel'=>$tel,'number'=>$number,'place'=>$place,'viewuid'=>$viewuid,'uid'=>$uid));
		updatetable("codebuy",array('status'=>'1'),array('codepassword'=>$code));
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
		if($discode=='1'){	
		for($i=0;$i<3;$i++){
		while(true){
		$a=rand(100000,999999);
		$query3 = $_SGLOBAL['db']->query("SELECT * FROM ".tname('codebuy')." WHERE codepassword='$a' and status='0'");
		$value3 = $_SGLOBAL['db']->fetch_array($query3);
		if(empty($value3)){

			inserttable("codebuy",array('codepassword'=>$a,'goodsid'=>$gid,'uid'=>$viewuid,'codename'=>$username));
			break;
			}	
		}
	}	

	}
}
	}else{
		echo"1";	
	}
	}else{
	inserttable("goodscod",array('username'=>$username,'dateline'=>$_SGLOBAL['timestamp'], 'gid'=>$gid,'tel'=>$tel,'number'=>$number,'place'=>$place,'viewuid'=>$viewuid,'uid'=>$uid));
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
	if($discode=='1'){
	for($i=0;$i<3;$i++){
		while(true){
		$a=rand(100000,999999);
		$query3 = $_SGLOBAL['db']->query("SELECT * FROM ".tname('codebuy')." WHERE codepassword='$a' and status='0'");
		$value3 = $_SGLOBAL['db']->fetch_array($query3);
		if(empty($value3)){
			inserttable("codebuy",array('codepassword'=>$a,'goodsid'=>$gid,'uid'=>$viewuid,'codename'=>$username));
			break;
			}	
		
		}
	}
	}
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
	if(eregi("^[0-9]+$",$money)){
	$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('auctionbuy')." WHERE gid='$gid' order by id DESC");
	$value = $_SGLOBAL['db']->fetch_array($query);
	if($value){
/*	$query1 = $_SGLOBAL['db']->query("SELECT * FROM ".tname('auction')." WHERE auctionid='$gid'");
	$value1 = $_SGLOBAL['db']->fetch_array($query1);
	$lastprice=$money-$value['money'];
	$trymoney=$value['money']+$value1['plusprice'];
	if($lastprice<$value1['plusprice']){
		echo"每次最低出价为$value1[plusprice],你本次出价必须高于$trymoney";
	}else{*/
	if($value['money']>$money||$value['money']==$money){
		echo"拍价失败，你拍下的当前价格已经被别人拍下，请重新刷新拍价";
		//拍价失败，你拍下的当前价格已经被别人拍下，请重新刷新拍价
	}else{
	$lasttime=$_SGLOBAL['timestamp']-$value['dateline'];
	if($lasttime>10){
			
			inserttable("auctionbuy",array('money'=>$money,'name'=>$name,'dateline'=>$_SGLOBAL['timestamp'], 'gid'=>$gid,'tel'=>$telephone,'viewuid'=>$viewuid,'uid'=>$uid));	
			updatetable("auction",array('replynum'=>$value1['replynum']+'1'),array('uid'=>$viewuid,'auctionid'=>$gid));
	}
/*	}*/
	}
	}else{

			$query1 = $_SGLOBAL['db']->query("SELECT * FROM ".tname('auction')." WHERE auctionid='$gid'");
			$value1 = $_SGLOBAL['db']->fetch_array($query1);
			inserttable("auctionbuy",array('money'=>"$value1[fristprice]",'name'=>$name,'dateline'=>$_SGLOBAL['timestamp'], 'gid'=>$gid,'tel'=>$telephone,'viewuid'=>$viewuid,'uid'=>$uid));	
			updatetable("auction",array('replynum'=>$value1['replynum']+'1'),array('uid'=>$viewuid,'auctionid'=>$gid));
			}
		}else{
			echo "1";//1代表用户输入的价格不是数字，则返回1；
		}
	
	/*echo '<script language="javascript">history.go(-1);</script>';*/
}
//微信商城列表页加入购物车处理
if($_POST['addtocar']){
	/*setcookie("id","");
	setcookie("time","");*/
	$id=$_POST['id'];
	$uid=$_COOKIE["uchome_uid"]."id";
	$array=explode(",",$_COOKIE["$uid"]);
	if(!in_array("$id",$array)){
		 if($_COOKIE["$uid"]){
	 	$arrid=$_COOKIE["$uid"].",".$id;
	 	setcookie("$uid",$arrid);
	 	$i=$_COOKIE["time"];
	 	$i++;
	 	setcookie("time",$i);
		 }else{
		 	setcookie("$uid",$id);
		 	setcookie("time",'1');
		 }
	}else{
		echo "$_COOKIE[time]";
	}
}
//在线支付poll推送
if($_POST['pull']){
				$uid=$_POST['uid'];
				$dateline=$_POST['dateline'];
				include_once(S_ROOT.'./wx/wx_common.php');
				include_once(S_ROOT.'./wx/Weixin.class.php');
				$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('space')." WHERE uid='$uid'");
				$value = $_SGLOBAL['db']->fetch_array($query);
                $fakeid=$value['goodspush'];
                if($fakeid){
                $url="http://v5.home3d.cn/home/wx/wx.php?do=booking&uid=$uid&dateline=$dateline";
                $message="亲，你有新的订单，<a href='$url'>点我瞬间查看</a>";
                $d = get_obj_by_xiaoquid($uid);
                $info = $d->sendWXSingleMsg($fakeid,$message);
                }
            }
//购物车清理cookie
if($_POST['clearcookie']){
	$id=$_POST['id'];
	$id1=$_POST['id'].",";
	$id2=",".$_POST['id'];
	$uid=$_COOKIE["uchome_uid"]."id";
	$changecookie1=str_replace("$id1","","$_COOKIE[$uid]");
	$changecookie2=str_replace("$id2","","$changecookie1");
	$changecookie=str_replace("$id","","$changecookie2");
	setcookie("$uid",$changecookie);
	$i=$_COOKIE["time"];
	$i=$i-1;
	setcookie("time",$i);
	echo($i);
}
//购物车清理cookie并生成不购买的cookie
if($_POST['clearnocookie']){
	$id=$_POST['id'];
	$array=explode(",",$_COOKIE["oldid"]);
	if(!in_array("$id",$array)){
		if($_COOKIE["oldid"]){
	 	$arrid=$_COOKIE["oldid"].",".$id;
	 	setcookie("oldid",$arrid);
		}else{
		 	setcookie("oldid",$id);
		 }
	}
	$newid=$_POST['id'];
	$id1=$_POST['id'].",";
	$id2=",".$_POST['id'];
	$uid=$_COOKIE["uchome_uid"]."id";
	$changecookie1=str_replace("$id1","","$_COOKIE[$uid]");
	$changecookie2=str_replace("$id2","","$changecookie1");
	$changecookie=str_replace("$id","","$changecookie2");
	setcookie("$uid",$changecookie);
	$i=$_COOKIE["time"];
	$i=$i-1;
	setcookie("time",$i);
}
//购物车重新加入cookie
if($_POST['addnocookie']){
	$id=$_POST['id'];
	$uid=$_COOKIE["uchome_uid"]."id";
	$array=explode(",",$_COOKIE["$uid"]);
		if($_COOKIE["$uid"]){
			echo($_COOKIE["$uid"]);
		 	if(!in_array("$id",$array)){
	 	$arrid=$_COOKIE["$uid"].",".$id;
	 	setcookie("$uid",$arrid);
	 		}
		 }else{
		 	echo($_COOKIE["$uid"]);
		 	setcookie("$uid",$id);
		 }
	
}


//秒杀执行代码
if($_POST['seckillbuy']){
	$name=$_POST['name'];
	$telephone=$_POST['telephone'];
	$viewuid=$_POST['viewuid'];
	$uid=$_POST['uid'];
	$gid=$_POST['gid'];
	$wxkey=$_POST['wxkey'];
	ssetcookie('name', $name, 31536000);
	ssetcookie('telephone', $telephone, 31536000);
	$query=$_SGLOBAL['db']->query("SELECT * FROM ".tname('seckill')." WHERE seckillid='$gid'");
	$value=$_SGLOBAL['db']->fetch_array($query);
	$hasseckilled = $_SGLOBAL['db']->result($_SGLOBAL['db']->query("SELECT COUNT(*) FROM ".tname('seckillbuy')."  WHERE uid='$uid' AND gid='$gid' "),0);
	if($hasseckilled)
	{ 
		echo "<font color='red' size='30px;' id='sum'>&nbsp;$value[amount]&nbsp;</font>";
	}
	else{
		if($value['amount'])
		{
			inserttable('seckillbuy',array('name'=>$name,'tel'=>$telephone,'uid'=>$uid,'viewuid'=>$viewuid,'gid'=>$gid,'dateline'=>$_SGLOBAL['timestamp']));
			updatetable('seckill',array('amount'=>$value['amount']-1),array('seckillid'=>$gid));
		}
		$query=$_SGLOBAL['db']->query("SELECT * FROM ".tname('seckill')." WHERE seckillid='$gid'");
		$value=$_SGLOBAL['db']->fetch_array($query);
		echo "<font color='red' size='30px;' id='sum'>&nbsp;$value[amount]&nbsp;</font>";
	}
}

//秒杀密码验证
if($_POST['seckillpassword1'])
{
	$seckillpassword=trim($_POST['seckillpassword']);
	$seckillid=$_POST['gid'];
	$uid=$_POST['viewuid'];
	$moblieclicknum=$_POST['moblieclicknum'];
	$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('seckill')." WHERE uid='$uid' and seckillid='$seckillid'");
	$value = $_SGLOBAL['db']->fetch_array($query);
	$value['seckillpassword']=trim($value['seckillpassword']);
	if($value['seckillpassword']==$seckillpassword){
		$url_forward="$_SERVER[HTTP_REFERER]"."&zhong=1";
		header("HTTP/1.1 301 Moved Permanently");
		header("Location: $url_forward");
	}else{
	echo '<script charset="utf8" type="text/javascript" language="javascript">alert("密码错误");</script>';
	echo '<script language="javascript">history.go(-1);</script>';	
	}
}



//投票评论入库
if($_POST['zong'])
{
	$nickname=$_POST['nickname'];
	$review=$_POST['review'];
	$pollid=$_POST['pollid'];
	$uid=$_POST['uid'];
	$dateline=$_POST['dateline'];
	$query=$_SGLOBAL['db']->query("SELECT * FROM ".tname('poll')." WHERE pollid='$pollid'");
	$value=$_SGLOBAL['db']->fetch_array($query);
	updatetable('poll',array('replynum'=>$value['replynum']+1),array('pollid'=>$pollid));
	inserttable('poll_comment',array('uid'=>$uid,'pollid'=>$pollid,'message'=>$review,'dateline'=>$dateline,'author'=>$nickname));
	echo '<li>
                        <span class="ContentCommentName">
                            '.$nickname.'：
                        </span>
                        <span class="ContentCommentWord">

                        </span>
                        <p>
                            '.$review.'
                        </p>
                   </li>';
}

//获取投票单选的id
$voteid=0;

if($_POST['yan0'])
{
	$voteid=$_POST['voteid'];
	setcookie("voteid",$voteid);
}


//投票多选ID

if($_POST['polls'])
{
	$voteid=$_POST['voteid'];
	$votearr=explode(",",$_COOKIE['olds']);
	if(!in_array("$voteid",$votearr))
	{
		if($_COOKIE["olds"])
		{
		 	$arrid=$_COOKIE["olds"].",".$voteid;
		 	setcookie("olds",$arrid);
		}
		else
		{
		 	setcookie("olds",$voteid);
		}
	}
	else
	{
		$voteid1=$_POST['voteid'].",";
		$voteid2=",".$_POST['voteid'];
		$changecookie1=str_replace("$voteid1","","$_COOKIE[olds]");
		$changecookie2=str_replace("$voteid2","","$changecookie1");
		$changecookie=str_replace("$voteid","","$changecookie2");
		setcookie("olds",$changecookie);
	}
}

//将参与单选投票的人的信息传进poll、polloption和polluser
if($_POST['zong0'])
{
	$voteid=$_COOKIE['voteid'];
	$uid=$_POST['uid'];
	$pollid=$_POST['pollid'];
	//读取poll表中的数据
	$query=$_SGLOBAL['db']->query("SELECT * FROM ".tname('poll')." WHERE pollid=$pollid");
	$value=$_SGLOBAL['db']->fetch_array($query);
	//读取polloption表中的数据
	$query1=$_SGLOBAL['db']->query("SELECT * FROM ".tname('polloption')." WHERE oid='$voteid'");
	$value1=$_SGLOBAL['db']->fetch_array($query1);
	//读取space表中的数据
	$query2=$_SGLOBAL['db']->query("SELECT * FROM ".tname('space')." WHERE uid=$uid");
	$value2=$_SGLOBAL['db']->fetch_array($query2);
	//更新poll表和polloption表
	updatetable('poll',array('voternum'=>$value['voternum']+1,'lastvote'=>$_SGLOBAL[timestamp]),array('pollid'=>$pollid));
	updatetable('polloption',array('votenum'=>$value1['votenum']+1),array('oid'=>$voteid));
	//插入polluser表
	$setarr = array(
		'uid' => $uid,
		'username' => $value2['username'],
		'pollid' => $pollid,
		'option' => saddslashes('"'.$value1['option'].'"'),
		'dateline' => $_SGLOBAL['timestamp']
	);
	inserttable('polluser', $setarr);
	$url_forward="$_SERVER[HTTP_REFERER]"."&zong1=1";
	header("HTTP/1.1 301 Moved Permanently");
	header("Location: $url_forward");
}



//将参与多选投票的人的信息传进poll、polloption和polluser
if($_POST['zong2'])
{
	$voteid=$_COOKIE['olds'];
	$uid=$_POST['uid'];
	$pollid=$_POST['pollid'];
	//读取poll表中的数据
	$query=$_SGLOBAL['db']->query("SELECT * FROM ".tname('poll')." WHERE pollid=$pollid");
	$value=$_SGLOBAL['db']->fetch_array($query);
	//读取space表中的数据
	$query2=$_SGLOBAL['db']->query("SELECT * FROM ".tname('space')." WHERE uid=$uid");
	$value2=$_SGLOBAL['db']->fetch_array($query2);
	//更新poll表和polloption表
	updatetable('poll',array('voternum'=>$value['voternum']+1,'lastvote'=>$_SGLOBAL[timestamp]),array('pollid'=>$pollid));
	$votes=explode(",", $voteid);
	for ($i=0; $i <count($votes) ; $i++) { 
		updatetable('polloption',array('votenum'=>$value1['votenum']+1),array('oid'=>$votes[$i]));
	}
	//读取polloption表中的数据
	$query3=$_SGLOBAL['db']->query("SELECT * FROM ".tname('polloption')." WHERE oid='$votes[0]'");
	$value3=$_SGLOBAL['db']->fetch_array($query3);
	//插入polluser表
	$setarr = array(
		'uid' => $uid,
		'username' => $value2['username'],
		'pollid' => $pollid,
		'option' => saddslashes('"'.$value3['option'].'"'),
		'dateline' => $_SGLOBAL['timestamp']
	);
	inserttable('polluser', $setarr);
	$url_forward="$_SERVER[HTTP_REFERER]"."&zong1=1";
	header("HTTP/1.1 301 Moved Permanently");
	header("Location: $url_forward");
}


//将参加活动的人的信息传进stratchment
if($_POST['infor']){
	$username=$_POST['name'];
	$wxkey=$_POST['wxkey'];
	$uid=$_POST['uid'];
	$number=$_POST['number'];
	$stratchid=$_POST['stratchid'];
	$dateline=$_SGLOBAL['timestamp'];
	updatetable("stratchment",array('number'=>$number,'username'=>$username,'dateline'=>$dateline),array('stratchid'=>$stratchid,'uid'=>$uid));
	echo '<script language="javascript">window.location.href = document.referrer;</script>';
}

//进行中奖信息验证
if($_POST['password4']){
	$password=trim($_POST['password']);
	$uid=$_POST['uid'];
	$stratchid=$_POST['stratchid'];
	$query4 = $_SGLOBAL['db']->query("SELECT * FROM ".tname('stratch')." WHERE stratchid='$stratchid'");
	$value4 = $_SGLOBAL['db']->fetch_array($query4);
	if($value4['passwd']==$password){
		$url_forward="$_SERVER[HTTP_REFERER]"."&zhong=1";
		header("HTTP/1.1 301 Moved Permanently");
		header("Location: $url_forward");	

	}else{	
	echo '<script charset="utf8" type="text/javascript" language="javascript">alert("密码错误");</script>';
	echo '<script language="javascript">history.go(-1);</script>';	
	}
	
}


//进行大擂台密码验证
if($_POST['password2']){
	$password=trim($_POST['password']);
	$uid=$_POST['uid'];
	$debateid=$_POST['debateid'];
	$query4 = $_SGLOBAL['db']->query("SELECT * FROM ".tname('debate')." WHERE uid='$uid' AND debateid='$debateid'");
	$value4 = $_SGLOBAL['db']->fetch_array($query4);
	if($value4['passwd']==$password){
		$url_forward="$_SERVER[HTTP_REFERER]"."&zhong=1";
		header("HTTP/1.1 301 Moved Permanently");
		header("Location: $url_forward");	

	}else{	
	echo '<script charset="utf8" type="text/javascript" language="javascript">alert("密码错误");</script>';
	echo '<script language="javascript">history.go(-1);</script>';	
	}
	
}

//进行大擂台裁判表单传入
if($_POST['judgedebatesubmit'])
{
	$judge=$_POST['judge'];
	$debater1=$_POST['obauthor'];
	$bedater2=$_POST['reauthor'];
	if(empty($debater1))
	{
		$debater=$bedater2;
	}
	else {
		$debater=$debater1;
	}
	$umpirepoint=$_POST['umpirepoint'];
	$debateid=$_POST['debateid'];
	updatetable('debate',array('debater'=>$debater,'umpirepoint'=>$umpirepoint,'judge'=>$judge),array('debateid'=>$debateid));
	echo '<script language="javascript">window.location.href = document.referrer;</script>';
}


//大擂台评论入库
if($_POST['yan'])
{
	$nickname=$_POST['nickname'];
	$review=$_POST['review'];
	$debatetype=$_POST['debatetype'];
	$debateid=$_POST['id'];
	$uid=$_POST['uid'];
	$dateline=$_POST['dateline'];
	$query=$_SGLOBAL['db']->query("SELECT * FROM ".tname('debate')." WHERE debateid='$debateid'");
	$value=$_SGLOBAL['db']->fetch_array($query);
	if($debatetype==0)
	{
		updatetable('debate',array('obreplynum'=>$value['obreplynum']+1),array('debateid'=>$debateid));
	}
	else 
	{
		updatetable('debate',array('rereplynum'=>$value['rereplynum']+1),array('debateid'=>$debateid));
	}
	inserttable('debate_comment',array('uid'=>$uid,'author'=>$nickname,'message'=>$review,'dateline'=>$dateline,'debatetype'=>$debatetype,'debateid'=>$debateid));
	echo '<li>
                        <span class="ContentCommentName">
                            '.$nickname.'：
                        </span>
                        <span class="ContentCommentWord">
						     当前                            
                        </span>
                    <p>
                     '.$review.' 
                    </p>
                </li>';
}



//大擂台投票传入数据库
if($_POST['support'])
{
	$debateid=$_POST['id'];
	$uid=$_COOKIE['uchome_viewuid'];
	$query=$_SGLOBAL['db']->query("SELECT * FROM ".tname('debate')." WHERE debateid='$debateid'");
	$value=$_SGLOBAL['db']->fetch_array($query);
	$obvoteuids=explode(",", $value['obvoteuids']);
	if(!in_array($uid,$obvoteuids)){
	 if(!$value['obvote'])
	 { 
     $obvoteuids=$uid;
     updatetable('debate', array('obvoteuids'=>$obvoteuids,'obvote'=>$value['obvote']+1),array('debateid'=>$debateid));
     }
     else
     {
     	array_push($obvoteuids,$uid);
     updatetable('debate', array('obvoteuids'=>implode(',',$obvoteuids),'obvote'=>$value['obvote']+1),array('debateid'=>$debateid));
     }
	}
}


//活动执行代码
if($_POST['go']){
	$eventname=trim($_POST['eventname']);
	$eventtel=$_POST['eventtel'];
	$viewuid=$_POST['uid'];
	$uid=$_SGLOBAL['supe_uid'];
	$eid=$_POST['eid'];
	$wxkey=$_POST['wxkey'];
	ssetcookie('eventname', $eventname, 31536000);
	ssetcookie('eventtel', $eventtel, 31536000);
	$lasttime=$_SGLOBAL['timestamp']-$value['dateline'];
	if($lasttime>10){
	inserttable("eventgo",array('username'=>$eventname,'dateline'=>$_SGLOBAL['timestamp'], 'eid'=>$eid,'tel'=>$eventtel,'uid'=>$_COOKIE['uchome_viewuid']));
	$_SGLOBAL['db']->query("UPDATE ".tname('eventfield')." SET limitnum=limitnum+1 WHERE eventid='$eid'");
	$query4=$_SGLOBAL['db']->result($_SGLOBAL['db']->query("SELECT COUNT(*) FROM ".tname('eventgo')."  WHERE eid='$eid' "));
	$_SGLOBAL['db']->query("UPDATE ".tname('event')." SET membernum=$query4 WHERE eventid='$eid'");
	}
	/*echo '<script language="javascript">history.go(-1);</script>';*/
}

//优惠码执行代码
if($_POST['discount']){
	$code=$_POST['code'];
	$tel=$_POST['tel'];
	if($code&&$tel){
	updatetable("codebuy",array('tel'=>$tel,'status1'=>'1'),array('codepassword'=>$code));
	}

}

//查看密码执行代码
if($_POST['password1']){
	$password=trim($_POST['password']);
	$uid=$_POST['viewuid'];
	$gid=$_POST['gid'];
	$moblieclicknum=$_POST['moblieclicknum'];
	$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('order')." WHERE uid='$_COOKIE[uchome_uid]'");
	$value = $_SGLOBAL['db']->fetch_array($query);
	$value['password2']=trim($value['password2']);
	if($value['password2']==$password){
		$url_forward="wx.php?do=booking&uid=$_COOKIE[uchome_uid]";
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
if($_GET['calluid']&&$_GET['dialuid']&&$_GET['questionuid']){
		$id=inserttable("questions",array('subject'=>'私信','q_uid'=>$_GET['calluid'],'status'=>'sixin','askid'=>$_GET['questionuid'],'q_dateline'=>$_SGLOBAL['timestamp']),1);
		//重定向浏览器
		echo '<script charset="utf8" language="javascript">alert("$id");</script>';  
		header("Location:http://v5.home3d.cn/home/wx/wx.php?do=detail&id=$id&uid=$_GET[questionuid]&viewuid=$_GET[calluid]&cheak=1&idtype=dialogid&type=dialog");   
		//确保重定向后，后续代码不会被执行   
		exit; 


}

if($_POST['submitcheck'])//预约报名
{
	//
	$username = $_POST['username'];
	$telnumber = $_POST['telnumber'];
	$id = $_POST['id'];
	$uid = $_POST['uid'];
	//$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('bookingjoin')." WHERE bookingid='$uid' and uid='0'");
	//$value = $_SGLOBAL['db']->fetch_array($query)

	$number=inserttable("bookingjoin",array('username'=>$username, 'uid'=>$uid,'bookingid'=>$id,'telnumber'=>$telnumber,'contact'=>'0'),1);
	//$_SGLOBAL['db']->query("UPDATE ".tname('booking')." SET join=join+1 WHERE bookingid='$id'");
    $query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('booking')." WHERE bookingid='$id'");
    $value = $_SGLOBAL['db']->fetch_array($query);
    updatetable('booking', array('join'=>$value['join']+1),array('bookingid'=>$id));


	header("Location:http://localhost/yunkang/yunkang/home/wx/wx.php?do=detail&type=bookingsuccess&id=$id&number=$number&uid=$uid");
	//http://localhost/yunkang/yunkang/home/wx/wx.php?do=detail&id=19&uid=1&idtype=bookingid&type=booking&viewuid=&wxkey=&moblieclicknum=&cheak=1
	
}

if($_POST['explainingsubmit'])//解读报名
{
	//
	$username = $_POST['username'];
	$telnumber = $_POST['telnumber'];
	$id = $_POST['id'];
	$uid = $_POST['uid'];
	//$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('bookingjoin')." WHERE bookingid='$uid' and uid='0'");
	//$value = $_SGLOBAL['db']->fetch_array($query)

	$number=inserttable("explainingjoin",array('username'=>$username, 'uid'=>$uid,'explainingid'=>$id,'telnumber'=>$telnumber,'contact'=>'0'),1);
	//$_SGLOBAL['db']->query("UPDATE ".tname('explaining')." SET join=join+1 WHERE explainingid='$id'");
    $query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('explaining')." WHERE explainingid='$id'");
    $value = $_SGLOBAL['db']->fetch_array($query);
    updatetable('explaining', array('join'=>$value['join']+1),array('explainingid'=>$id));


	header("Location:http://localhost/yunkang/yunkang/home/wx/wx.php?do=detail&type=explainingsuccess&id=$id&uid=$uid&number=$number");
	//http://localhost/yunkang/yunkang/home/wx/wx.php?do=detail&id=19&uid=1&idtype=bookingid&type=booking&viewuid=&wxkey=&moblieclicknum=&cheak=1
	
}

if($_POST['bookingcancel'])//预约取消
{
	$id = $_POST['numberid'];
	$bookingid = $_POST['id'];
	$query = $_SGLOBAL['db']->query("DELETE  FROM ".tname('bookingjoin')." WHERE id='$id'");
	$value = $_SGLOBAL['db']->fetch_array($query);
	$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('booking')." WHERE bookingid='$bookingid'");
    $value = $_SGLOBAL['db']->fetch_array($query);
    updatetable('booking', array('join'=>$value['join']-1),array('bookingid'=>$bookingid));
	//$_SGLOBAL['db']->query("UPDATE ".tname('booking')." SET join=join-1 WHERE bookingid='$id'");
	header("Location:http://localhost/yunkang/yunkang/home/wx/wx.php?do=detail&type=booking&id=$bookingid");
	
}
if($_POST['explainingcancel'])//解读取消
{
	$id = $_POST['numberid'];
	$explainingid = $_POST['id'];
	$query = $_SGLOBAL['db']->query("DELETE  FROM ".tname('explainingjoin')." WHERE id='$id'");
	$value = $_SGLOBAL['db']->fetch_array($query);
	$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('explaining')." WHERE explainingid='$explainingid'");
    $value = $_SGLOBAL['db']->fetch_array($query);
    updatetable('explaining', array('join'=>$value['join']-1),array('explainingid'=>$explainingid));
	//$_SGLOBAL['db']->query("UPDATE ".tname('explaining')." SET join=join-1 WHERE explainingid='$id'");
	header("Location:http://localhost/yunkang/yunkang/home/wx/wx.php?do=detail&type=explaining&id=$explainingid");
	
}


$codename=$_GET['codename'];
$id=$_GET['id'];
$uid=$_GET['uid'];
if($codename){
$count = $_SGLOBAL['db']->result($_SGLOBAL['db']->query("SELECT COUNT(*) FROM ".tname('codebuy')." WHERE codename='$codename' and status1='0' order by id DESC"),0);
	
$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('codebuy')." WHERE codename='$codename' and status1='0' and goodsid in (0,$id) order by id DESC limit 0,6");
while($value = $_SGLOBAL['db']->fetch_array($query)){
	$query1 = $_SGLOBAL['db']->query("SELECT * FROM ".tname('goods')." WHERE goodsid='$value[goodsid]'");
	$value1 = $_SGLOBAL['db']->fetch_array($query1);
	$value['subject']=$value1['subject'];

	$code[]=$value;
}
$zhong = $_SGLOBAL['db']->query("SELECT bf.*, b.* FROM ".tname('appset')." bf 
				LEFT JOIN ".tname('menuset')." b ON bf.num=b.menusetid
				WHERE bf.uid='$uid' and bf.appstatus='1' and b.style='1'
				ORDER BY bf.orderid ASC ");
while ($wei = $_SGLOBAL['db']->fetch_array($zhong)) {
	if($wei['newname']){
		$wei['subject']=$wei['newname'];
	}
	$zhongwei[]=$wei;

}
$zhong1 = $_SGLOBAL['db']->query("SELECT bf.*, b.* FROM ".tname('appset')." bf 
				LEFT JOIN ".tname('menuset')." b ON bf.num=b.menusetid
				WHERE bf.uid='$uid' and bf.appstatus='1' and b.english='goods' and b.style='2'
				ORDER BY bf.orderid ASC ");
while ($wei1 = $_SGLOBAL['db']->fetch_array($zhong1)) {
	if($wei1['newname']){
		$wei1['subject']=$wei1['newname'];
	}
	$zhongwei1[]=$wei1;

}
$query3 = $_SGLOBAL['db']->query("SELECT * FROM ".tname('space')." WHERE uid='$uid'");
$uidwxkey=$_SGLOBAL['db']->fetch_array($query3);
$query2 = $_SGLOBAL['db']->query("SELECT * FROM ".tname('goods')." WHERE goodsid='$id'");
$goods= $_SGLOBAL['db']->fetch_array($query2);
include_once template("./wx/template/upload");
}
?>