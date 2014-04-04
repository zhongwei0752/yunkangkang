<?php
/*
		一些封装好的函数
*/
@include_once('../common.php');
include_once('api/Weixin.class.php');
//当收楼状态改版时，绑定微信的用户将受到通知
function send_by_roomid($roomid , $tip){
	global $_SGLOBAL;
	$query = $_SGLOBAL['db']->query("select * from ".tname('xiaoquverify')." where roomid='$roomid' and status='2' ");
	while($value = $_SGLOBAL['db']->fetch_array($query)){
			$fakeid = $value['fakeid'];
			$xiaoquid = $value['xiaoquid'];
			if($fakeid){
				//如果$fakeid存在，即绑定了微信，则发送消息
				$d = get_obj_by_xiaoquid($xiaoquid);
				$d->sendWXSingleMsg($fakeid ,$tip);
			}

	}
}

//管理员回复短信息的时候，短信息推送通知到微信用户
function send_by_uid($uid , $msg){
	global $_SGLOBAL;
	//优先查询xiaoquverify表，没有的话再查询space表
	$query = $_SGLOBAL['db']->query("select * from ".tname('xiaoquverify')." where uid='$uid' ");
	$value = $_SGLOBAL['db']->fetch_array($query);
	$fakeid = $value['fakeid'];
	$xiaoquid = $value['xiaoquid'];

	if($fakeid){
		//如果$fakeid存在，即绑定了微信，则发送消息
		$d = get_obj_by_xiaoquid($xiaoquid);
		$d->sendWXSingleMsg($fakeid ,$msg);
	}else{
		$query = $_SGLOBAL['db']->query("select * from ".tname('space')." where uid='$uid' ");
		$value = $_SGLOBAL['db']->fetch_array($query);
		$fakeid = $value['fakeid'];
		$xiaoquid = $value['xiaoquid'];

		if($fakeid){
			//如果$fakeid存在，即绑定了微信，则发送消息
			$d = get_obj_by_xiaoquid($xiaoquid);
			$d->sendWXSingleMsg($fakeid ,$msg);
		}
	}

}

//根据小区id获得微信类的实例对象。此函数一般是为了被其他函数调用
function get_obj_by_xiaoquid($xiaoquid){
	global $_SGLOBAL;
	$query = $_SGLOBAL['db']->query("select * from ".tname('weixin_xiaoqu')." where xiaoquid='$xiaoquid'  ");
	$value = $_SGLOBAL['db']->fetch_array($query);
	if($value){
		$d = new Weixin($value['weixin_account'], $value['weixin_pwd']);
		if($d)return $d;
	}
	return false;
}
//根据开发商的uid获得微信类的实例对象。此函数一般是为了被其他函数调用
function get_obj_by_uid($uid){
	global $_SGLOBAL;
	$query = $_SGLOBAL['db']->query("select * from ".tname('weixin_developer')." where uid='$uid'  ");
	$value = $_SGLOBAL['db']->fetch_array($query);
	if($value){
		$d = new Weixin($value['weixin_account'], $value['weixin_pwd']);
		if($d)return $d;
	}
	return false;
}
//发给小区管理员微信
function send_to_admin($xiaoquid , $msg){
	global $_SGLOBAL;
	$query = $_SGLOBAL['db']->query("select * from ".tname('weixin_xiaoqu')." where xiaoquid='$xiaoquid'  ");
	$value = $_SGLOBAL['db']->fetch_array($query) ;
	$admin_fakeid = $value['admin_fakeid'];
	if($admin_fakeid){
		$d = new Weixin($value['weixin_account'], $value['weixin_pwd']);
		$d->sendWXSingleMsg($admin_fakeid ,$msg);
		return true;
	}else{
		return -1;
	}
}
//根据uid获取uchome的头像
function get_avatar_url($uid ,  $size='' ,$type ='' ){
    $uc_url =  'http://home3d.cn/center/';
    $avatar = './data/avatar/'.get_avatar($uid, $size, $type);
    if(file_exists(S_ROOT.'/center/'.$avatar)) {
        $random = !empty($random) ? rand(1000, 9999) : '';
        $avatar_url = empty($random) ? $avatar : $avatar.'?random='.$random;
    } else {
        $size = in_array($size, array('big', 'middle', 'small')) ? $size : 'middle';
        $avatar_url = 'images/noavatar_'.$size.'.gif';
    }
    return $uc_url.$avatar_url;
}
function get_avatar($uid, $size = 'middle', $type = '') {
    $size = in_array($size, array('big', 'middle', 'small')) ? $size : 'middle';
    $uid = abs(intval($uid));
    $uid = sprintf("%09d", $uid);
    $dir1 = substr($uid, 0, 3);
    $dir2 = substr($uid, 3, 2);
    $dir3 = substr($uid, 5, 2);
    $typeadd = $type == 'real' ? '_real' : '';
    return $dir1.'/'.$dir2.'/'.$dir3.'/'.substr($uid, -2).$typeadd."_avatar_$size.jpg";
}
//微信端的写缓存
function w_cache_write($name, $var, $values) {
	$cachefile = S_ROOT.'./weixin/cache/data_'.$name.'.php';
	$cachetext = "<?php\r\n".
		'$'.$var.'='.w_arrayeval($values).";\r\n".
		'$'.$var.'_cache_time='.time().";\r\n".
		"\r\n?>";
	if(!swritefile($cachefile, $cachetext)) {
		exit("File: $cachefile write error.");
	}
}
function w_arrayeval($array, $level = 0) {
	$space = '';
	for($i = 0; $i <= $level; $i++) {
		$space .= "\t";
	}
	$evaluate = "Array\n$space(\n";
	$comma = $space;
	foreach($array as $key => $val) {
		$key = is_string($key) ? '\''.addcslashes($key, '\'\\').'\'' : $key;
		$val = !is_array($val) && (!preg_match("/^\-?\d+$/", $val) || strlen($val) > 12) ? '\''.addcslashes($val, '\'\\').'\'' : $val;
		if(is_array($val)) {
			$evaluate .= "$comma$key => ".w_arrayeval($val, $level + 1);
		} else {
			$evaluate .= "$comma$key => $val";
		}
		$comma = ",\n$space";
	}
	$evaluate .= "\n$space)";
	return $evaluate;
}
//获取菜单数组
function get_menu_array($xiaoquid){
	global $_SGLOBAL;
	$wxkey = "wxkey_to_replace";
	$query = $_SGLOBAL['db']->query("select * from ".tname('weixin_xiaoqu')." where xiaoquid='$xiaoquid'");
	$value_1 = $_SGLOBAL['db']->fetch_array($query);
	$admin_uid = $value_1['admin_uid'];
	$query = $_SGLOBAL['db']->query("select * from ".tname('communityapp')." where uid='$admin_uid'  and appused > 0 order by displayorder ASC");
	while ( $value_2 = $_SGLOBAL['db']->fetch_array($query)){ 
		$appid = $value_2['appid'];
		$query2 = $_SGLOBAL['db']->query("select * from ".tname('app_communityapp')." where appid='$appid'");
		$value2 = $_SGLOBAL['db']->fetch_array($query2);
		if($value2['appweb'] == 2 ){
		    //对$url的处理
		    if ($value2['appurl'] == "xiaoqubook.php") {
		        //如果是楼书/酒店画册
		        $query3 = $_SGLOBAL['db']->query("select * from ".tname('wapxiaoqubook')." where xiaoquid='$xiaoquid' order by displayorder ASC limit 1 ");
		        $value3 = $_SGLOBAL['db']->fetch_array($query3);
		        $siteurl = $value3['siteurl'];
		        $html = $value3['html'];
		        $url = $siteurl.$html;
		    }
		    elseif ($value2['appurl'] == "pm.php") {
		        $url = "pm.php?token={$wxkey}okokok{$admin_uid}okokok{$xiaoquid}";

		    }
		    else{

		        $url = $value2['appurl']."?token={$wxkey}okokok{$xiaoquid}";
		    }
		    $name = $value_2['appnote'] ? $value_2['appnote'] : $value2['appname'];
		    $pic =$value2['appimage'];
		    //echo '<option value="'.$url.'">'.$appname.'</option>';
		    $s[]=array(
		    		"url" => $url,
		    		"name" => $name,
		    		"pic" => $pic,
		    	);
		}
	}
	return $s;
}
//获取小区信息
function get_xiaoqu_array($xiaoquid){
	global $_SGLOBAL;
    $query = $_SGLOBAL['db']->query("select * from ".tname('community_api')." where xiaoquid='$xiaoquid' ");
    $value = $_SGLOBAL['db']->fetch_array($query);
    $value['telephone'] = $value['telephone'].' ';
    return $value;
}
//获取小区新闻
function get_xiaoqu_news($xiaoquid , $page=1 , $count=4){
	global $_SGLOBAL;
	 $start = $page - 1;
	$query = $_SGLOBAL['db']->query("select * from ".tname('xiaoqunews')." where xiaoquid='$xiaoquid' order by dateline desc limit $start , $count  ");
	while ( $new = $_SGLOBAL['db']->fetch_array($query) ){
		$query2 = $_SGLOBAL['db']->query("select * from ".tname('xiaoqunewsfield')." where newsid = '".$new['newsid']."' ");
		if($newsfield = $_SGLOBAL['db']->fetch_array($query2)){
			$new['intro'] = $newsfield['intro'];
		}
		$ary['hotspot'][] = $new;
	}
    return $ary;
}
//获取小区户型
function get_xiaoqu_style($xiaoquid){
	global $_SGLOBAL;
    $query = $_SGLOBAL['db']->query("select * from ".tname('housestyleview')." where xiaoquid='$xiaoquid' group by housestyleid order by dateline desc");
    while ( $style = $_SGLOBAL['db']->fetch_array($query) ){
        $ary['style'][] = $style;

    }
    return $ary;
}
//获取小区户型
function get_xiaoqu_style_detail($xiaoquid,$housestyleid){
	global $_SGLOBAL;
    $query = $_SGLOBAL['db']->query("select * from ".tname('housestyleview')." where xiaoquid='$xiaoquid' and housestyleid='$housestyleid'");
    if ($style = $_SGLOBAL['db']->fetch_array($query) ){
        return $style;
    }
}
//获取服务列表
function get_service_list($xiaoquid){
	global $_SGLOBAL;
	$sql = "select * from ".tname('serviceitemview')." where xiaoquid='$xiaoquid' order by dateline desc";
	$query = $_SGLOBAL['db']->query($sql);
	while($value = $_SGLOBAL['db']->fetch_array($query)){
		$itemid = $value['itemid'];
		$subject = $value['subject'];
		$message = $value['message'];
		$score = $value['score'];
		$message = strip_tags($message);
		$price = $value['price'];
		$dateline = $value['dateline'];
		$time = date("Y" , $dateline).'年'.date("m" , $dateline ).'月'.date("d" , $dateline).'日';
		$suid = $value['suid'];
		$pic = $value['ftpurl'].$value['pic'];
		//开始获取人员信息
		$sql = "select * from ".tname('serviceuser')." where uid='$suid' ";
		$query2 = $_SGLOBAL['db']->query($sql);
		$value2 = $_SGLOBAL['db']->fetch_array($query2);
		$name = $value2['name'];
		$phone = $value2['phone'];
		$classid = $value2['classid'];
		$sql = "select * from ".tname('serviceclass')." where classid='$classid' ";
		$query3 = $_SGLOBAL['db']->query($sql);
		$value3 = $_SGLOBAL['db']->fetch_array($query3);
		$classname = $value3['classname'];
		$ary[] = array(
				"itemid" =>$itemid , 
				"pic" =>$pic ,
				"subject" =>$subject ,
				"name" =>$name ,
				"score" =>$score ,
				"message" =>$message ,

			);
	}
	return $ary;
}
//更新菜单数组缓存
function menu_array_cache($xiaoquid){
	$ary = get_menu_array($xiaoquid);
	if($ary)w_cache_write("menu_array_".$xiaoquid, 'menu_array', $ary);
}
//更新小区信息缓存
function xiaoqu_array_cache($xiaoquid){
	$ary = get_xiaoqu_array($xiaoquid);
	if($ary)w_cache_write("xiaoqu_array_".$xiaoquid, 'xiaoqu_array', $ary);
}
//更新小区新闻缓存
function xiaoqu_news_cache($xiaoquid){
	$ary = get_xiaoqu_news($xiaoquid , 1 ,  100);
	w_cache_write("xiaoqu_news_".$xiaoquid, 'xiaoqu_news', $ary);
}
//更新小区新闻缓存
function xiaoqu_style_cache($xiaoquid){
	$ary = get_xiaoqu_style($xiaoquid);
	w_cache_write("xiaoqu_style_".$xiaoquid, 'xiaoqu_style', $ary);
}
function xiaoqu_style_detail_cache($xiaoquid,$housestyleid){
	$ary = get_xiaoqu_style_detail($xiaoquid,$housestyleid);
	w_cache_write("xiaoqu_style_detail_".$xiaoquid.'_'.$housestyleid, 'xiaoqu_style_detail', $ary);	
}
//更新小区新闻缓存
function service_list_cache($xiaoquid){
	$ary = get_service_list($xiaoquid);
	w_cache_write("service_list_".$xiaoquid, 'service_list', $ary);
}
//更新全景360缓存
function xiaoqu_360_cache($xiaoquid){
	$ary = get_xiaoqu_360($xiaoquid , 1 ,  100);
	w_cache_write("xiaoqu_360_".$xiaoquid, 'xiaoqu_360', $ary);
}
//获取360全景
function get_xiaoqu_360($xiaoquid , $page=1 , $count=4){
	global $_SGLOBAL;
	 $start = $page - 1;
	$query = $_SGLOBAL['db']->query("select * from ".tname('xiaoqu360')." where xiaoquid='$xiaoquid' order by dateline desc limit $start , $count  ");
	while ( $new = $_SGLOBAL['db']->fetch_array($query) ){
		$new['dateline'] = date("Y-m-d" , $new['dateline'] );
		$ary['xiaoqu360'][] = $new;
	}
    return $ary;
}
//创建自定义菜单
function creatMenuByXiaoquid($xiaoquid){
		global $_SGLOBAL;
		$query = $_SGLOBAL['db']->query("select * from ".tname('weixin_xiaoqu')." where xiaoquid='$xiaoquid' ");
		$value = $_SGLOBAL['db']->fetch_array($query);
		$appid = $value['appid'];
		$appsecret = $value['appsecret'];
		$uid = $value['admin_uid'];
		if(!$appsecret)return false;
		//var_dump($value);
		$query = $_SGLOBAL['db']->query("select * from ".tname('weixin_menuview')." where uid='$uid'  and appused > 0  and appweb = 2 and groupid > 0 and close =  0 group by appid order by displayorder ASC ");
		while( $value = $_SGLOBAL['db']->fetch_array($query)){
			//左边菜单组
			if ($value['grouporder'] == 1) {
				$l_ary[] =$value;
			}
			//中间的菜单
			elseif ($value['grouporder'] == 2) {
				$m_ary[] =$value;
			}
			//右边的菜单
			elseif ($value['grouporder'] == 3) {
				$r_ary[] =$value;
			}
		}
		//左边的菜单
		if (count($l_ary) == 1 ) {
			//左边第一个菜单
			$groupname = $l_ary[0]['groupnote'] ? $l_ary[0]['groupnote'] : $l_ary[0]['groupname'] ;
			$l_menu =array(
				"type"=>"click",
				"name"=>$groupname,
				"key"=>$l_ary[0]['appurl']
				);
		}
		elseif (count($l_ary) > 1) {
			//左边第一个菜单
				$l_menu["name"] = $l_ary[0]['groupnote'] ? $l_ary[0]['groupnote'] : $l_ary[0]['groupname'];
				foreach ($l_ary as $value) {
					$appname = $value['appnote'] ? $value['appnote'] : $value['appname'] ;
					$l_menu["sub_button"][] = array(
							"type"=>"click",
							"name"=>$appname,
							"key"=>$value['appurl'],
							);
				}
		}
		//中间的菜单
		if (count($m_ary) == 1 ) {
			$groupname = $m_ary[0]['groupnote'] ? $m_ary[0]['groupnote'] : $m_ary[0]['groupname'] ;
			$m_menu =array(
				"type"=>"click",
				"name"=>$groupname,
				"key"=>$m_ary[0]['appurl']
				);
		}
		elseif (count($m_ary) > 1) {
				$m_menu["name"] = $m_ary[0]['groupnote'] ? $m_ary[0]['groupnote'] : $m_ary[0]['groupname'];
				foreach ($m_ary as $value) {
					$appname = $value['appnote'] ? $value['appnote'] : $value['appname'] ;
					$m_menu["sub_button"][] = array(
							"type"=>"click",
							"name"=>$appname,
							"key"=>$value['appurl'],
							);
				}
		}
		//右边的菜单
		if (count($r_ary) == 1 ) {
			$groupname  = $r_ary[0]['groupnote'] ? $r_ary[0]['groupnote'] : $r_ary[0]['groupname'];
			$r_menu =array(
				"type"=>"click",
				"name"=>$groupname ,
				"key"=>$r_ary[0]['appurl']
				);
		}
		elseif (count($r_ary) > 1) {
				$r_menu["name"] = $r_ary[0]['groupnote'] ? $r_ary[0]['groupnote'] : $r_ary[0]['groupname'];
				foreach ($r_ary as $value) {
					$appname = $value['appnote'] ? $value['appnote'] : $value['appname'] ;
					$r_menu["sub_button"][] = array(
							"type"=>"click",
							"name"=>$appname,
							"key"=>$value['appurl'],
							);
				}
		}
		$menu_ary['button'][] = $l_menu;
		$menu_ary['button'][] = $m_menu;
		$menu_ary['button'][] = $r_menu;
		require_once('hotel3/Common/Weixin.class.php');
		$Weixin = new WeixinOp("1" , "1" , $appid , $appsecret );
		//var_dump($menu_ary);
		return $Weixin->creatMenu($menu_ary);
}
function deleMenuByXiaoquid($xiaoquid){
		global $_SGLOBAL;
		$query = $_SGLOBAL['db']->query("select * from ".tname('weixin_xiaoqu')." where xiaoquid='$xiaoquid' ");
		$value = $_SGLOBAL['db']->fetch_array($query);
		$appid = $value['appid'];
		$appsecret = $value['appsecret'];
		require_once('hotel3/Common/Weixin.class.php');
		$Weixin = new WeixinOp("1" , "1" , $appid , $appsecret );
		return $Weixin->deleteMenu();
}
?>
