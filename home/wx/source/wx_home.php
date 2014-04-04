<?php
	
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
	$uid=$_GET['uid'];
	$home=$_SGLOBAL['db']->query("SELECT * FROM ".tname('recommend')."  WHERE uid='$uid'");
	$home1=$_SGLOBAL['db']->fetch_array($home);
	$god1=$_SGLOBAL['db']->query("SELECT s.* ,sf.* FROM ".tname('space')." s LEFT JOIN ".tname('spacefield')." sf ON s.uid=sf.uid WHERE s.uid='$uid'");
	$god=$_SGLOBAL['db']->fetch_array($god1);
	 if($god['name']){
                        $name=$god['name'];
                      }else{
                        $name=$god['username'];
                      }
	$zhong = $_SGLOBAL['db']->query("SELECT bf.*, b.* FROM ".tname('appset')." bf 
				LEFT JOIN ".tname('menuset')." b ON bf.num=b.menusetid
				WHERE bf.uid='$uid' and bf.appstatus='1' and b.style='1'
				ORDER BY bf.orderid ASC ");
while ($wei = $_SGLOBAL['db']->fetch_array($zhong)) {
	$wei['icon']=$wei['english'].".png";
	if($wei['newname']){
		$wei['subject']=$wei['newname'];
	}
	$zhongwei[]=$wei;

}
	$zhong1 = $_SGLOBAL['db']->query("SELECT bf.*, b.* FROM ".tname('appset')." bf 
				LEFT JOIN ".tname('menuset')." b ON bf.num=b.menusetid
				WHERE bf.uid='$uid' and bf.appstatus='1' and b.style='2' and b.english='goods'
				ORDER BY bf.orderid ASC ");
	while ($wei1 = $_SGLOBAL['db']->fetch_array($zhong1)) {
	$wei1['icon']="goods.png";
	if($wei1['newname']){
		$wei1['subject']=$wei1['newname'];
	}
	$zhongwei1[]=$wei1;
	}

//读产品列表语句
    $query2=$_SGLOBAL['db']->query("SELECT * FROM ".tname('product')." WHERE uid='$uid' ORDER BY 'dateline' DESC LIMIT 5");
	while($wei2=$_SGLOBAL['db']->fetch_array($query2))
	{
		$wei3['image1url']=$wei2['image1url'];
		$wei3['imageurl']=$wei2['imageurl'];
		$wei3['subject']=$wei2['subject'];
		$wei3['money']=$wei2['money'];
		$wei3['uid']=$wei2['uid'];
		$wei3['productid']=$wei2['productid'];
		$list[]=$wei3;
	}
//读商城的语句
     $k=0;
	 $query3=$_SGLOBAL['db']->query("SELECT * FROM ".tname('goods')." WHERE uid='$uid' ORDER BY 'dateline' DESC LIMIT 5");
	while($wei4=$_SGLOBAL['db']->fetch_array($query3))
	{
		$wei5['image1url']=$wei4['image1url'];
		$wei5['subject']=$wei4['subject'];
		$wei5['money']=$wei4['money'];
		$wei5['uid']=$wei4['uid'];
		$wei5['goodsid']=$wei4['goodsid'];
		$wei5['curprice']=$wei4['curprice'];
		$k++;
		$wei5['k']=$k;
		$list2[]=$wei5;
	}



$abc = $_SGLOBAL['db']->query("SELECT * FROM ".tname('space')." WHERE uid='$uid'");
	$bac = $_SGLOBAL['db']->fetch_array($abc);
	if($bac['moblieclicknum']=="0"||$bac['moblieclicknum']=="1"||$bac['moblieclicknum']=="3"||$bac['moblieclicknum']=="4"||$bac['moblieclicknum']=="5"||$bac['moblieclicknum']=="6"||$bac['moblieclicknum']=="7"){
		
		include_once template("./wx/template/home");
		
	}else{
	include_once template("./wx/template/$bac[moblieclicknum]/home");
}

	
?>