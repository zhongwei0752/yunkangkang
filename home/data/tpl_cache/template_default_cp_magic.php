<?php if(!defined('IN_UCHOME')) exit('Access Denied');?><?php subtplcheck('template/default/cp_magic|template/default/header|template/default/footer', '1386745400', 'template/default/cp_magic');?><?php if(empty($_SGLOBAL['inajax'])) { ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=<?=$_SC['charset']?>" />
<meta http-equiv="x-ua-compatible" content="ie=7"/>
<title><?php if($_TPL['titles']) { ?><?php if(is_array($_TPL['titles'])) { foreach($_TPL['titles'] as $value) { ?><?php if($value) { ?><?=$value?> - <?php } ?><?php } } ?><?php } ?><?php if($_SN[$space['uid']]) { ?><?=$_SN[$space['uid']]?> - <?php } ?><?=$_SCONFIG['sitename']?></title>
 <script src="./source/jquery.js"></script>
 <script src="./source/back_top.js" ></script>
<script language="javascript" type="text/javascript" src="source/script_cookie.js"></script>

<script language="javascript" type="text/javascript" src="source/script_common.js"></script>

<script language="javascript" type="text/javascript" src="source/script_menu.js"></script>
<script language="javascript" type="text/javascript" src="source/script_ajax.js"></script>
<script language="javascript" type="text/javascript" src="source/script_face.js"></script>
<script language="javascript" type="text/javascript" src="source/script_manage.js"></script>


 <!-- Bootstrap -->
   <!--  <link href="css/bootstrap.min.css" rel="stylesheet" media="screen"> -->
<link rel="stylesheet" type="text/css" href="template/default/jquery-mobile-fluid960.min.css">
<link rel="stylesheet" type="text/css" href="template/default/style1.css">

<style type="text/css">

@import url(template/default/network.css);
@import url(template/default/style.css);
<?php if($_TPL['css']) { ?>
@import url(template/default/<?=$_TPL['css']?>.css);
<?php } ?>
<?php if(!empty($_SGLOBAL['space_theme'])) { ?>
@import url(theme/<?=$_SGLOBAL['space_theme']?>/style.css);
<?php } elseif($_SCONFIG['template'] != 'default') { ?>
@import url(template/<?=$_SCONFIG['template']?>/style.css);
<?php } ?>
<?php if(!empty($_SGLOBAL['space_css'])) { ?>
<?=$_SGLOBAL['space_css']?>
<?php } ?>
</style>
<link rel="shortcut icon" href="image/favicon.ico" />
<link rel="edituri" type="application/rsd+xml" title="rsd" href="xmlrpc.php?rsd=<?=$space['uid']?>" />
</head>
<body>

<div id="append_parent"></div>
<div id="ajaxwaitid"></div>
<div id="header">
<?php if($_SGLOBAL['ad']['header']) { ?><div id="ad_header"><?php adshow('header'); ?></div><?php } ?>
 <div class="wrapper">
 <div class="navbar">
            <div class="navbar-inner container_36">
                
                <a class="logo grid_1" href="space.php?do=home"><img src="./template/default/image/logo.png"></a>
                <?php if($_SGLOBAL['supe_uid']) { ?>
                <a href="space.php?do=home" class="grid_2"><?php if($_GET['do']=="home") { ?><p class="nav_actived">首页</p> <?php } else { ?>首页<?php } ?></a>
                

                <?php } else { ?>
                 <a href="index.php" class="grid_2">首页</a>
                <?php } ?>
                <?php if($_SGLOBAL['supe_uid']) { ?>	
                <?php if($space['pmnum']) { ?>
<?php if($space['pmnum']) { ?><a class="grid_2" href="space.php?do=pm&filter=newpm"><p>短消息</p><a href="space.php?do=pm" alt="短消息"><div class="message_pawpaw"><?=$space['pmnum']?></div></a><?php } ?>
                 <?php } else { ?>
                <a class="grid_2" href="space.php?do=pm<?php if(!empty($_SGLOBAL['member']['newpm'])) { ?>&filter=newpm<?php } ?>"><?php if($_GET['do']=="pm") { ?><p class="nav_actived">消息</p> <?php } else { ?>消息<?php } ?></a>

<?php } ?>
<a href="space.php?do=friend" class="grid_2"><?php if($_GET['do']=="friend") { ?><p class="nav_actived">客户统计</p> <?php } else { ?>客户统计<?php } ?></a>
<?php } else { ?>
<div class="grid_3" style="width:400px;display:inline-block;"></div>
<?php } ?>

                <?php if($_SGLOBAL['supe_uid']) { ?>
               
                <div class="grid_3"></div>
                <div class="grid_4">
                   <a href="cp.php?ac=profile"  style="float:left;padding-right:10px;"><?php echo avatar($_SGLOBAL[supe_uid]); ?></a>
                   <span class="company_name"><?=$_SN[$_SGLOBAL['supe_uid']]?></span><br/>
                   <a href="cp.php" class="header_btn setting_btn">设置</a> &nbsp;&nbsp;&nbsp;&nbsp;<a href="cp.php?ac=common&op=logout&uhash=<?=$_SGLOBAL['uhash']?>"  class="header_btn quit_btn">退出</a> 
                </div>
         <?php } else { ?>
<div class="grid_7"></div>

                <div class="grid_4">
                   <a href="do.php?ac=<?=$_SCONFIG['register_action']?>"  style="float:left;padding-right:10px;"><?php echo avatar($_SGLOBAL[supe_uid]); ?></a>
                   <span class="company_name">欢迎您</span><br/>
                   <a href="do.php?ac=<?=$_SCONFIG['login_action']?>" class="header_btn setting_btn">登录</a> &nbsp;&nbsp;&nbsp;&nbsp;<a href="do.php?ac=<?=$_SCONFIG['register_action']?>"  class="header_btn quit_btn">注册</a> 
                </div>
<?php } ?>
  </div>
         </div>


<div id="wrap" style="width:1024px;">

<div>
<div id="main">

<?php if(empty($_TPL['nosidebar'])) { ?>

<?php if($zhong1) { ?>
<div id="app_sidebar">


<?php if($_SGLOBAL['supe_uid']) { ?>

<div class="side_bar" >
              <div class="side_bar_inner" >
                    <ul>
                        <li class="side_header"><span class="title">基本组件</span><!-- <a href="space.php?do=menuset&view=me" class="manage_btn">管理</a --></li>
  						
                        <?php if(is_array($zhongwei)) { foreach($zhongwei as $value) { ?>
 <?php if($value['english']==$_GET['do']||$value['english']==$_GET['ac']) { ?><li class="actived"><?php } else { ?><li class="side_option"><?php } ?><a href="<?=$value['url']?>"><?=$value['subject']?></a></li>
<?php } } ?>

                       <!-- <li class="side_option actived"><a href="">企业介绍</a></li>-->
                       
                        <li class="side_header"><span class="title">高级组件</span><!-- <a href="space.php?do=menuset&view=me" class="manage_btn">管理</a> --></li>
                        <?php if(is_array($zhongwei1)) { foreach($zhongwei1 as $value) { ?>
 <?php if($value['english']==$_GET['do']||$value['english']==$_GET['ac']) { ?><li class="actived"><?php } else { ?><li class="side_option"><?php } ?><a href="<?=$value['url']?>"><?=$value['subject']?></a></li>
<?php } } ?>
<!--                         <li class="side_option"><a href="">客户管理</a></li>
                        <li class="side_option"><a href="space.php?do=goods&view=me">商品管理</a></li>
                        <li class="side_option"><a href="">订单管理</a></li>
                        <li class="side_option"><a href="space.php?do=book">预约预定管理</a></li>
                        <li class="side_option"><a href="space.php?do=recommend&view=me">焦点推荐</a></li>
                        <li class="side_option"><a href="">群发</a></li>
                        <li class="side_option"><a href="space.php?do=moblie&view=all">选择手机模板</a></li> -->
                    </ul>
              </div>
         </div>

<!--<div class="app_m">
<ul>
<?php if($_SN[$_SGLOBAL['supe_uid']]=="admin") { ?>
<!--<li><img src="image/app_add.gif"><a href="cp.php?ac=menuset" class="addApp">添加应用</a></li>
<?php } ?>
<!--<li><img src="image/app_set.gif"><a href="space.php?do=menuset&view=me" class="myApp">管理应用</a></li>
</ul>
</div>-->

<?php } else { ?>
<div class="bar_text">
<form id="loginform" name="loginform" action="do.php?ac=<?=$_SCONFIG['login_action']?>&ref" method="post">
<input type="hidden" name="formhash" value="<?php echo formhash(); ?>" />
<p class="title">登录站点</p>
<p>用户名</p>
<p><input type="text" name="username" id="username" class="t_input" size="15" value="" /></p>
<p>密码</p>
<p><input type="password" name="password" id="password" class="t_input" size="15" value="" /></p>
<p><input type="checkbox" id="cookietime" name="cookietime" value="315360000" checked /><label for="cookietime">记住我</label></p>
<p>
<input type="submit" id="loginsubmit" name="loginsubmit" value="登录" class="submit" />
<input type="button" name="regbutton" value="注册" class="button" onclick="urlto('do.php?ac=<?=$_SCONFIG['register_action']?>');">
</p>
</form>
</div>
<?php } ?>

</div>
<?php } ?>
<div id="mainarea" style="margin-left:10px;margin-top:10px;width:800px;">

<?php if($_SGLOBAL['ad']['contenttop']) { ?><div id="ad_contenttop"><?php adshow('contenttop'); ?></div><?php } ?>
<?php } ?>

<?php } ?>


<?php if($op == "buy") { ?>

<h1>购买道具</h1>
<a class="float_del" title="关闭" href="javascript:hideMenu();">关闭</a>
<div class="toolly" id="__magicbuy_<?=$mid?>">
<?php if($ac=='magic') { ?>	
<form id="magicbuy_<?=$mid?>" action="cp.php?ac=magic&mid=<?=$mid?>&op=buy" method="post">
<?php } else { ?>		
<form id="magicbuy_<?=$mid?>" action="magic.php?mid=<?=$mid?>&op=buy&idtype=<?=$idtype?>&id=<?=$id?><?=$extra?>" method="post">
<?php } ?>
<div class="magic_img">
<img src="image/magic/<?=$mid?>.gif" alt="<?=$magic['name']?>" />
</div>
<div class="magic_info">
<h3><?=$magic['name']?></h3>
<p class="gray"><?=$magic['description']?></p>
<?php if($magic['experience']) { ?>
<p>增加经验: <span><?=$magic['experience']?></span></p>
<?php } ?>
<p>
道具单价: <span><?=$magic['charge']?></span> 积分
<?php if($discount > 0) { ?>
（享受 <?=$discount?> 折优惠 <span><?=$charge?></span> 积分 ）
<?php } elseif($discount < 0) { ?>
（享受 <span>免费</span> 折扣 ）
<?php } ?>				
</p>
<p>现有库存: <span><?=$magicstore['storage']?></span> 个</p>
<p>购买数量: <input class="t_input" type="text" name="buynum" value="1" style="width:40px;" /> 个（当前最多可购买 <?=$magicstore['maxbuy']?> 个）</p>
<?php if($coupon['count']) { ?>
<p>用代金券: <input class="t_input" type="text" name="coupon" value="0" style="width:40px;" /> 张（每张抵用 100 积分，拥有 <?=$coupon['count']?> 张）</p>
<?php } ?>
<p class="btn_line">
<input type="hidden" name="formhash" value="<?php echo formhash() ?>" />
<input type="hidden" name="refer" value="<?=$_SGLOBAL['refer']?>"/>
<input type="hidden" name="buysubmit" value="1" />
<?php if($_SGLOBAL['inajax']) { ?>
<?php if($ac=='magic') { ?>
<input type="button" class="submit" id="buysubmit_btn" value="购买" onclick="ajaxpost('magicbuy_<?=$mid?>', 'magicBought', 2000)" />
<?php } else { ?>
<input type="button" class="submit" id="buysubmit_btn" value="购买" onclick="ajaxpost('magicbuy_<?=$mid?>')" />
<?php } ?>
<?php } else { ?>
<input type="submit" class="submit" id="buysubmit_btn" value="购买">
<?php } ?>
</p>
</div>
</form>
</div>

<?php } elseif($op == "present") { ?>

<h1>赠送道具</h1>
<a class="float_del" title="关闭" href="javascript:hideMenu();">关闭</a>
<div class="popupmenu_inner" id="__magicpresent_<?=$mid?>">
<form id="magicpresent_<?=$mid?>" action="cp.php?ac=magic&mid=<?=$mid?>" method="post">
<p>
要赠送的道具：<?=$magic['name']?>
</p>
<p>
好友的用户名：
<input type="text" name="fusername" />
</p>
<p class="btn_line">
<input type="hidden" name="formhash" value="<?php echo formhash() ?>" />
<input type="hidden" name="refer" value="<?=$_SGLOBAL['refer']?>"/>
<input type="hidden" name="presentsubmit" value="1" />
<?php if($_SGLOBAL['inajax']) { ?>
<input type="button" class="submit" name="presentsubmit_btn" value="赠送" onclick="ajaxpost('magicpresent_<?=$mid?>', 'magicPresent', 2000)" />
<?php } else { ?>
<input type="submit" class="submit" name="presentsubmit_btn" value="赠送">
<?php } ?>
</p>
</form>
</div>
<?php } elseif($op == "showusage") { ?>

<h1>道具使用示例图</h1>
<a class="float_del" title="关闭" href="javascript:hideMenu();">关闭</a>
<div class="popupmenu_inner">
<img src="image/magic/usage/<?=$mid?>.gif" />		
</div>

<?php } elseif($op == 'appear') { ?>

<h1>恢复在线状态</h1>
<a class="float_del" title="关闭" href="javascript:hideMenu();">关闭</a>
<div class="popupmenu_inner" id="__appearform">
<form action="cp.php?ac=magic&op=<?=$op?>" method="post" id="appearform">
<p>
您确定要取消隐身效果，恢复在线状态吗？
</p>
<p class="btn_line">
<input type="hidden" name="formhash" value="<?php echo formhash() ?>" />
<input type="hidden" name="refer" value="<?=$_SGLOBAL['refer']?>"/>
<input type="hidden" name="appearsubmit" value="1" />
<input type="submit" class="submit" value="确定" />
</p>
</form>
</div>

<?php } elseif($op == 'retrieve') { ?>

<h1>回收红包</h1>
<a class="float_del" title="关闭" href="javascript:hideMenu();">关闭</a>
<div class="popupmenu_inner" id="__retrieveform">
<form action="cp.php?ac=magic&op=<?=$op?>" method="post" id="retrieveform">
<p>
红包当前剩余积分 <?=$leftcredit?> ，您确定要回收吗？
</p>
<p class="btn_line">
<input type="hidden" name="formhash" value="<?php echo formhash() ?>" />
<input type="hidden" name="refer" value="<?=$_SGLOBAL['refer']?>"/>
<input type="hidden" name="retrievesubmit" value="1" />
<input type="submit" class="submit" value="确定" />
</p>
</form>
</div>

<?php } elseif(in_array($op, array('cancelsuperstar', 'cancelflicker', 'cancelcolor', 'cancelframe', 'cancelbgimage'))) { ?>

<h1>取消道具效果</h1>
<a class="float_del" title="关闭" href="javascript:hideMenu();">关闭</a>
<div class="popupmenu_inner" id="__cancelform">
<form action="cp.php?ac=magic&op=<?=$op?>&id=<?=$_GET['id']?>&idtype=<?=$_GET['idtype']?>" method="post" id="cancelform">
<p>
您确定要取消道具 <?=$_SGLOBAL['magic'][$mid]?> 的效果吗？
</p>
<p class="btn_line">
<input type="hidden" name="formhash" value="<?php echo formhash() ?>" />
<input type="hidden" name="refer" value="<?=$_SGLOBAL['refer']?>"/>
<input type="hidden" name="cancelsubmit" value="1" />
<input type="submit" class="submit" value="确定" />
</p>
</form>
</div>

<?php } else { ?>

<h2 class="title"><img src="image/icon/magic.gif">道具中心</h2>
<div class="tabs_header">
<ul class="tabs">
<li<?=$actives['store']?>><a href="cp.php?ac=magic&view=store"><span>道具商店</span></a></li>
<li<?=$actives['me']?>><a href="cp.php?ac=magic&view=me"><span>我的道具</span></a></li>
<li<?=$actives['log']?>><a href="cp.php?ac=magic&view=log"><span>道具记录</span></a></li>
</ul>
</div>

<div style="float:none;">

<?php if($_GET['view'] == "me") { ?>

<?php if($mid) { ?>
<p class="notice">
当前只显示与你操作相关的单个道具，
<a href="cp.php?ac=magic&view=<?=$_GET['view']?>">点击此处查看全部道具</a>
</p>
<p>&nbsp;</p>
<?php } ?>

<?php if($list) { ?>
<ul id="magiclist" class="magic_list">
<?php if(is_array($list)) { foreach($list as $key=>$value) { ?>
<li id="magic_<?=$key?>">
<div class="magic_img">
<img src="image/magic/<?=$key?>.gif" alt="<?=$magics[$key]['name']?>" />
</div>
<div class="magic_info">
<h3><?=$magics[$key]['name']?></h3>
<p class="gray">
<?=$magics[$key]['description']?>
</p>
<p>
<a id="a_present_<?=$key?>" href="cp.php?ac=magic&op=present&mid=<?=$key?>" onclick="ajaxmenu(event, this.id, 1)" class="m_button<?php if($key=='license') { ?> m_off<?php } ?>">赠送</a>
拥有 <span id="magiccount_<?=$key?>"><?=$value['count']?></span> 个
</p>
</div>
</li>
<?php } } ?>
</ul>
<?php } else { ?>
<p>您还没有购买任何道具，<a href="cp.php?ac=magic&view=store">去道具商店看看</a></p>
<?php } ?>
<?php } elseif($_GET['view'] == 'log') { ?>

<div class="h_status">
查看：
<a <?=$types['in']?> href="cp.php?ac=magic&view=<?=$_GET['view']?>&type=in">获得记录</a>
<span class="pipe">|</span>
<a <?=$types['present']?> href="cp.php?ac=magic&view=<?=$_GET['view']?>&type=present">赠送记录</a>
<span class="pipe">|</span>
<a <?=$types['out']?> href="cp.php?ac=magic&view=<?=$_GET['view']?>&type=out">使用记录</a>
</div>

<?php if($_GET['type'] == 'in') { ?>
<?php if($list) { ?>
<ul class="line_list">
<?php if(is_array($list)) { foreach($list as $value) { ?>
<li>

<?php if($value['type'] == '3') { ?>
升级获得
<?php } elseif($value['type'] == '2') { ?>
获得了
<?php if($value['fromid']) { ?>
<a href="space.php?uid=<?=$value['fromid']?>" target="_blank"><?=$_SN[$value['fromid']]?></a>
<?php } else { ?>
管理员
<?php } ?>
赠送的
<?php } else { ?>
购买了
<?php } ?>
<a href="cp.php?ac=magic&view=store&mid=<?=$value['mid']?>" target="_blank">
<?=$_SGLOBAL['magic'][$value['mid']]?>
</a>
<?=$value['count']?>
个
<span class="gray">(<?php echo sgmdate('m-d H:i', $value[dateline], true) ?>)</span>
</li>
<?php } } ?>
</ul>
<div class="page"><?=$multi?></div>
<?php } else { ?>
<p>您近期没有道具收入记录</p>
<?php } ?>
<?php } elseif($_GET['type'] == 'present') { ?>
<?php if($list) { ?>
<ul class="line_list">
<?php if(is_array($list)) { foreach($list as $value) { ?>
<li>
向
<a href="space.php?uid=<?=$value['uid']?>"><?=$_SN[$value['uid']]?></a>
赠送了
<a href="cp.php?ac=magic&view=store&mid=<?=$value['mid']?>" target="_blank">
<?=$_SGLOBAL['magic'][$value['mid']]?>
</a>
<span class="gray">(<?php echo sgmdate('m-d H:i', $value[dateline], true) ?>)</span>
</li>
<?php } } ?>
</ul>
<div class="page"><?=$multi?></div>
<?php } else { ?>
<p>您近期没有向他人赠送道具的记录</p>
<?php } ?>		
<?php } else { ?>
<?php if($list) { ?>
<ul class="line_list">
<?php if(is_array($list)) { foreach($list as $value) { ?>
<li>
使用了
<a href="cp.php?ac=magic&view=store&mid=<?=$value['mid']?>" target="_blank">
<?=$_SGLOBAL['magic'][$value['mid']]?>
</a>
<?=$value['count']?> 次
<?php if($value['mid'] == 'invisible') { ?>
; &nbsp;失效时间：<?php echo sgmdate('m-d H:i', $value[expire]) ?>
<?php } elseif($value['mid'] == 'gift') { ?>
; &nbsp;剩余积分数：<?=$value['data']['left']?>
<?php } elseif($value['mid'] == 'superstar') { ?>
; &nbsp;失效时间：<?php echo sgmdate('m-d H:i', $value[expire]) ?>
<?php } ?>
<span class="gray">(<?php echo sgmdate('m-d H:i', $value[dateline], true) ?>)</span>
</li>
<?php } } ?>
</ul>
<div class="page"><?=$multi?></div>
<?php } else { ?>
<p>您近期没有道具使用记录</p>
<?php } ?>
<?php } ?>

<?php } else { ?>
<div class="h_status">
排序：
<a <?=$orders['default']?> href="cp.php?ac=magic&view=<?=$view?>&order=defalut">默认</a>
<span class="pipe">|</span>
<a <?=$orders['hot']?> href="cp.php?ac=magic&view=<?=$view?>&order=hot">热门</a>
</div>

<?php if($mid) { ?>
<p class="notice">
当前只显示与你操作相关的单个道具，
<a href="cp.php?ac=magic&view=<?=$_GET['view']?>">点击此处查看全部道具</a>
</p>
<p>&nbsp;</p>
<?php } ?>

<ul id="magiclist" class="magic_list">
<?php if(is_array($list)) { foreach($list as $key=>$value) { ?>
<li id="magic_<?=$key?>">
<div class="magic_img">
<a id="a_i_buy_<?=$key?>" href="cp.php?ac=magic&op=buy&mid=<?=$key?>" onclick="ajaxmenu(event, this.id, 1)">
<img src="image/magic/<?=$key?>.gif" alt="<?=$magics[$key]['name']?>" />
</a>
</div>
<div class="magic_info">
<h3>
<?=$magics[$key]['name']?>
<?php if($_GET['order'] == 'hot') { ?>
<small class="gray" style="margin-left:10px;">已售出 <?=$value['sellcount']?> 件</small>
<?php } ?>
</h3>
<p class="gray"><?=$magics[$key]['description']?></p>
<p>
<?php if(in_array($space['groupid'], $magics[$key]['forbiddengid']) || in_array($mid, $blacklist)) { ?>
<a id="a_buy_<?=$key?>" href="cp.php?ac=magic&op=buy&mid=<?=$key?>" onclick="ajaxmenu(event, this.id, 1)" class="m_button m_off">不能购买</a><span><?=$magics[$key]['charge']?></span> 积分/个
<?php } else { ?>
<a id="a_buy_<?=$key?>" href="cp.php?ac=magic&op=buy&mid=<?=$key?>" onclick="ajaxmenu(event, this.id, 1)" class="m_button">购买</a><span><?=$magics[$key]['charge']?></span> 积分/个
<?php } ?>
</p>
</div>
</li>
<?php } } ?>
</ul>
<?php } ?>

</div><!--//<div id="content" style="float:none;width:690px;">//-->
<script type="text/javascript">
<!--
function magicBought(id, result) {
var ids = explode('_', id);
var mid = ids[1];
if($('a_buy_'+mid)) {
$('a_buy_'+mid).innerHTML = '继续购买';
}
}
function magicPresent(id, result) {
var ids = explode('_', id);
var mid = ids[1];
if($('a_present_'+mid)) {
$('a_present_'+mid).innerHTML = '继续赠送';
}
if($('magiccount_'+mid)) {
$('magiccount_'+mid).innerHTML = parseInt($('magiccount_'+mid).innerHTML) - 1;
}
}
-->
</script>

<?php } ?>


    <link rel="stylesheet" href="./template/default/bottomWrapper.css" />
    <script type="text/javascript" src="./source/footer.js"></script>
   <?php if(empty($_SGLOBAL['inajax'])) { ?>
  <?php if(empty($_TPL['nosidebar'])) { ?>
    <?php if($_SGLOBAL['ad']['contentbottom']) { ?><br style="line-height:0;clear:both;"/><div id="ad_contentbottom"><?php adshow('contentbottom'); ?></div><?php } ?>
    </div>

    <!--/mainarea-->
    <?php if($zhong1) { ?>
    <div id="bottom"></div>
    <?php } ?>
  </div>
  <!--/main-->
  <?php } ?>
    </div>
    </div>
      <div id="backtop">
      <a href="">
        <img src="./template/default/image/back_top.png">
      </a>
    </div>
        </div>


   <!-- 修复ie6透明png的bug -->
   <div class="footer">
        <div class="bottomWrapper">
      <div class="contactUs">
        <ul>
          <li class="listTitle">
            <img src="./template/default/image/img/arrow_circle_right.png" alt="" class="pngFix" />
            使用帮助：
          </li>
          <a href="http://v5.home3d.cn/home/myhelp.php?id=60"><li class="listItem" style="font-size: 16px">开通流程</li></a>
          <a href="http://v5.home3d.cn/home/myhelp.php?id=70"><li class="listItem" style="font-size: 16px">管理员手册</li></a>
          <a href="http://v5.home3d.cn/home/myhelp.php?id=69"><li class="listItem" style="font-size: 16px">用户手册</li></a>
        </ul>

        <ul>
          <li class="listTitle">
            <img src="./template/default/image/img/arrow_circle_right.png" alt="" class="pngFix" />
            投诉与建议：
          </li>
          <a href="http://v5.home3d.cn/home/myhelp.php?id=61"><li class="listItem" style="font-size: 16px">在线客服</li></a>
          <a href="http://v5.home3d.cn/home/myhelp.php?id=59"><li class="listItem" style="font-size: 16px">留言板</li></a>

        </ul>

        <ul>
          <li class="listTitle">
            <img src="./template/default/image/img/arrow_circle_right.png" alt="" class="pngFix" />
            合作：
          </li>
          <a href="http://v5.home3d.cn/home/myhelp.php?id=62"><li class="listItem" style="font-size: 16px">品牌企业合作</li></a>
          <a href="http://v5.home3d.cn/home/myhelp.php?id=63"><li class="listItem" style="font-size: 16px">媒体合作</li></a>
          <a href="http://v5.home3d.cn/home/myhelp.php?id=72"><li class="listItem" style="font-size: 16px">收费细节</li></a>
        </ul>

        <ul class="last">
          <li class="listTitle">
            <img src="./template/default/image/img/arrow_circle_right.png" alt="" class="pngFix" />
            关于我们：
          </li>
          <a href="http://www.koalac.com/help/koalacpage_help.php?koa_help_id=26"><li class="listItem" style="font-size: 16px">企业介绍</li></a>
          <a href="http://v5.home3d.cn/home/myhelp.php?id=48"><li class="listItem" style="font-size: 16px">联系方式</li></a>
          <a href="http://v5.home3d.cn/home/myhelp.php?id=71"><li class="listItem" style="font-size: 16px">人才招聘</li></a>
        </ul>

        <img src="./template/default/image/img/QRcode.png" alt="" id="QRcode" />
      </div> <!-- contact_us --> 

      <div class="declaration">
        <span class="copyright">版权所有：广州市树袋熊网络科技有限公司</span>
        <span class="ICP">ICP：粤ICP备08132436号</span>
      </div> <!-- declaration --> 
    </div> <!-- bottom_wrapper --> 
</div>
<!--/wrap-->

    <!--<script src="js/bootstrap.min.js"></script>-->
<?php if($_SGLOBAL['appmenu']) { ?>
<ul id="ucappmenu_menu" class="dropmenu_drop" style="display:none;">
  <li><a href="<?=$_SGLOBAL['appmenu']['url']?>" title="<?=$_SGLOBAL['appmenu']['name']?>" target="_blank"><?=$_SGLOBAL['appmenu']['name']?></a></li>
  <?php if(is_array($_SGLOBAL['appmenus'])) { foreach($_SGLOBAL['appmenus'] as $value) { ?>
  <li><a href="<?=$value['url']?>" title="<?=$value['name']?>" target="_blank"><?=$value['name']?></a></li>
  <?php } } ?>
</ul>
<?php } ?>

<?php if($_SGLOBAL['supe_uid']) { ?>
<ul id="membernotemenu_menu" class="dropmenu_drop" style="display:none;">
  <?php $member = $_SGLOBAL['member']; ?>
  <?php if($member['notenum']) { ?><li><img src="image/icon/notice.gif" width="16" alt="" /> <a href="space.php?do=notice"><strong><?=$member['notenum']?></strong> 个新通知</a></li><?php } ?>
  <?php if($member['pokenum']) { ?><li><img src="image/icon/poke.gif" alt="" /> <a href="cp.php?ac=poke"><strong><?=$member['pokenum']?></strong> 个新招呼</a></li><?php } ?>
  <?php if($member['addfriendnum']) { ?><li><img src="image/icon/friend.gif" alt="" /> <a href="cp.php?ac=friend&op=request"><strong><?=$member['addfriendnum']?></strong> 个好友请求</a></li><?php } ?>
  <?php if($member['mtaginvitenum']) { ?><li><img src="image/icon/mtag.gif" alt="" /> <a href="cp.php?ac=mtag&op=mtaginvite"><strong><?=$member['mtaginvitenum']?></strong> 个群组邀请</a></li><?php } ?>
  <?php if($member['eventinvitenum']) { ?><li><img src="image/icon/event.gif" alt="" /> <a href="cp.php?ac=event&op=eventinvite"><strong><?=$member['eventinvitenum']?></strong> 个活动邀请</a></li><?php } ?>
  <?php if($member['myinvitenum']) { ?><li><img src="image/icon/userapp.gif" alt="" /> <a href="space.php?do=notice&view=userapp"><strong><?=$member['myinvitenum']?></strong> 个应用消息</a></li><?php } ?>
</ul>
<?php } ?>

<?php if($_SGLOBAL['supe_uid']) { ?>
<?php if(!isset($_SCOOKIE['checkpm'])) { ?>
<script language="javascript"  type="text/javascript" src="cp.php?ac=pm&op=checknewpm&rand=<?=$_SGLOBAL['timestamp']?>"></script>
<?php } ?>
<?php if(!isset($_SCOOKIE['synfriend'])) { ?>
<script language="javascript"  type="text/javascript" src="cp.php?ac=friend&op=syn&rand=<?=$_SGLOBAL['timestamp']?>"></script>
<?php } ?>
<?php } ?>
<?php if(!isset($_SCOOKIE['sendmail'])) { ?>
<script language="javascript"  type="text/javascript" src="do.php?ac=sendmail&rand=<?=$_SGLOBAL['timestamp']?>"></script>
<?php } ?>

<?php if($_SGLOBAL['ad']['couplet']) { ?>
<script language="javascript" type="text/javascript" src="source/script_couplet.js"></script>
<div id="uch_couplet" style="z-index: 10; position: absolute; display:none">
  <div id="couplet_left" style="position: absolute; left: 2px; top: 60px; overflow: hidden;">
    <div style="position: relative; top: 25px; margin:0.5em;" onMouseOver="this.style.cursor='hand'" onClick="closeBanner('uch_couplet');"><img src="image/advclose.gif"></div>
    <?php adshow('couplet'); ?>
  </div>
  <div id="couplet_rigth" style="position: absolute; right: 2px; top: 60px; overflow: hidden;">
    <div style="position: relative; top: 25px; margin:0.5em;" onMouseOver="this.style.cursor='hand'" onClick="closeBanner('uch_couplet');"><img src="image/advclose.gif"></div>
    <?php adshow('couplet'); ?>
  </div>
  <script type="text/javascript">
    lsfloatdiv('uch_couplet', 0, 0, '', 0).floatIt();
  </script>
</div>
<?php } ?>
<?php if($_SCOOKIE['reward_log']) { ?>
<script type="text/javascript">
showreward();
</script>
<?php } ?>
</body>
</html>
<?php } ?><?php ob_out();?>