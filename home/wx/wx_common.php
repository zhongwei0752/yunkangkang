<?php
require_once('Weixin.class.php');
//根据小区id获得微信类的实例对象。此函数一般是为了被其他函数调用
function get_obj_by_xiaoquid($xiaoquid){
	global $_SGLOBAL;
	$query = $_SGLOBAL['db']->query("select * from ".tname('space')." where uid='$xiaoquid'  ");
	$value = $_SGLOBAL['db']->fetch_array($query);
	if($value){
		$d = new Weixin("$value[weixinusername]", "$value[weixinpassword]");
		if($d)return $d;
	}
	return false;
}



//¶Ô»°¿ò

function wxshowmessage($msgkey, $url_forward='', $second=1, $values=array()) {
	global $_SGLOBAL, $_SC, $_SCONFIG, $_TPL, $space, $_SN;

	obclean();

	//È¥µô¹ã¸æ
	$_SGLOBAL['ad'] = array();
	
	//ÓïÑÔ
	include_once(S_ROOT.'./language/lang_showmessage.php');
	if(isset($_SGLOBAL['msglang'][$msgkey])) {
		$message = lang_replace($_SGLOBAL['msglang'][$msgkey], $values);
	} else {
		$message = $msgkey;
	}
	//ÊÖ»ú
	if($_SGLOBAL['mobile']) {
		include template('./wx/template/showmessage');
		exit();
	}
	//ÏÔÊ¾
	if(empty($_SGLOBAL['inajax']) && $url_forward && empty($second)) {
		header("HTTP/1.1 301 Moved Permanently");
		header("Location: $url_forward");
	} else {
		if($_SGLOBAL['inajax']) {
			if($url_forward) {
				$message = "<a href=\"$url_forward\">$message</a><ajaxok>";
			}
			//$message = "<h1>".$_SGLOBAL['msglang']['box_title']."</h1><a href=\"javascript:;\" onclick=\"hideMenu();\" class=\"float_del\">X</a><div class=\"popupmenu_inner\">$message</div>";
			echo $message;
			ob_out();
		} else {
			if($url_forward) {
				$message = "<a href=\"$url_forward\">$message</a><script>setTimeout(\"window.location.href ='$url_forward';\", ".($second*1000).");</script>";
			}
			include template('./wx/template/showmessage');
		}
	}
	exit();
}
?>