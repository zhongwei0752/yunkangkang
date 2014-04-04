<?php
session_start();
include_once('../common.php');//uchome的公共文件
include_once('../config.php');
include_once('../../function_weixin.php');  //封装好的微信相关函数
if ($_GET['token']) {
  $token = $_GET['token'];
  $ary = explode( 'okokok' , $token);
  $wxkey = $ary[0];
  $xiaoquid = $ary[1];
  //加入session
  $_SESSION['wxkey'] = $wxkey;
  $_SESSION['xiaoquid'] = $xiaoquid;
}else{
   $wxkey = $_SESSION['wxkey'] ;
   $xiaoquid = $_SESSION['xiaoquid'] ;
}
if($_GET['xiaoquid'])$xiaoquid = $_GET['xiaoquid'] ;//如果是直接GET的方式传递过来，则也处理
if ($xiaoquid) {
  //$xiaoqu_array = get_xiaoqu_array($xiaoquid);
  if(!@include_once(S_ROOT.'./weixin/cache/data_xiaoqu_array_'.$xiaoquid.'.php')) {
    xiaoqu_array_cache($xiaoquid);
    @include_once(S_ROOT.'./weixin/cache/data_xiaoqu_array_'.$xiaoquid.'.php');
  }
  $xiaoquname = $xiaoqu_array['subject'];
}


?>