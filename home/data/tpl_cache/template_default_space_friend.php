<?php if(!defined('IN_UCHOME')) exit('Access Denied');?><?php subtplcheck('template/default/space_friend|template/default/header|template/default/space_menu|template/default/space_list|template/default/footer', '1387336300', 'template/default/space_friend');?><?php $_TPL['titles'] = array('客户'); ?>
<?php if(empty($_SGLOBAL['inajax'])) { ?>
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

    <link rel="stylesheet" type="text/css" href="./template/default/jquery-mobile-fluid960.min.css">
    <link rel="stylesheet" type="text/css" href="./template/default/style1.css">
    <link rel="stylesheet" type="text/css" href="./template/default/file_beauty.css">
    <link type='text/css' href='./template/default/basic_chosen.css' rel='stylesheet' media='screen' />
    <style type="text/css">
       h3{color: #727272;margin-top: 20px;font-weight:normal;}
       .selected{ -webkit-box-shadow: 3px 3px 3px;
  -moz-box-shadow: 3px 3px 3px;
  box-shadow: 3px 3px 3px;}
  
      .bg1{ background: url("./template/default/image/chosen_bg.png");}
      .open{ background: url("./template/default/image/chosen_bg2.png")!important;}
      .open .price{color:#3EB2B8!important;}

      #simplemodal-container a {
color:#02B4AB;
}
    </style>

<?php if(!empty($_SGLOBAL['inajax'])) { ?>
<div id="space_friend">
<h3 class="feed_header">
<a href="cp.php?ac=friend&op=search" class="r_option" target="_blank">寻找客户</a>
客户(共 <?=$count?> 个)
</h3><br>

<?php if($list) { ?>
<div id="friend_ul">
<ul class="line_list">
<?php if(is_array($list)) { foreach($list as $key => $value) { ?>
<li>
<table width="100%">
<tr>
<td width="70">
<div class="avatar48"><a href="space.php?uid=<?=$value['uid']?>"><?php echo avatar($value[uid],small); ?></a></div>
</td>
<td>
<div class="thumbTitle"><p<?php if($ols[$value['uid']]) { ?> class="online_icon_p"<?php } ?>><a href="space.php?uid=<?=$value['uid']?>"<?php g_color($value[groupid]); ?>><?=$_SN[$value['uid']]?></a> <?php g_icon($value[groupid]); ?></p></div>

<?php if($value['note']) { ?><div><?=$value['note']?></div><?php } ?>

<?php if($ols[$value['uid']]) { ?><div class="gray"><?php echo sgmdate('H:i',$ols[$value[uid]],1); ?></div><?php } ?>
<div class="setti">

<?php if(!$value['isfriend']) { ?>
<a href="cp.php?ac=friend&op=add&uid=<?=$value['uid']?>" id="a_friend_<?=$key?>" onclick="ajaxmenu(event, this.id, 1)">加为客户</a>
<?php } ?>
</div>
</td></tr></table>
</li>
<?php } } ?>
</ul>
</div>
<div class="page"><?=$multi?></div>

<?php } else { ?>
<div class="c_form">
没有相关用户列表。
</div>
<?php } ?>
</div><br />

<?php } else { ?>

<?php if($space['self']) { ?>

<div class="content" style="font-size:15px;width:760px;">
<div class="bread container_12">
<?php if($_GET['view']=='me'||$_GET['view']=='lastlogin'||$_GET['view']=='hot') { ?>
 <div class="bread_actived grid_1" >
                         客户列表
                     </div>
                     <?php } else { ?>
                     
                     <a href="space.php?do=friend" style="margin-left:-20px;" class="link_back_bread grid_3">
                     客户列表
                     </a>
                     <?php } ?>
                     <?php if($count2) { ?>
                     <?php if($_GET['view']=='free') { ?>
                     <div class="bread_actived grid_1" style="margin-left:20px;">
                      普通版套餐客户
                     </div>
                     <?php } else { ?>
                     <a href="space.php?do=friend&view=free" style="margin-left:20px;" class="link_back_bread grid_3">
                      普通版套餐客户
                     </a>
                      <?php } ?>
                      <?php if($_GET['view']=='case') { ?>
                     <div class="bread_actived grid_1" style="margin-left:20px;">
                      增强版套餐用户
                     </div>
                     <?php } else { ?>
                     <a href="space.php?do=friend&view=case" style="margin-left:20px;" class="link_back_bread grid_3">
                      增强版套餐用户
                     </a>
                      <?php } ?>  
                      <?php if($_GET['view']=='highcase') { ?>
                     <div class="bread_actived grid_1" style="margin-left:20px;">
                      高级版套餐用户
                     </div>
                     <?php } else { ?> 
                     <a href="space.php?do=friend&view=highcase" style="margin-left:20px;" class="link_back_bread grid_3">
                     高级版套餐用户
                     </a>
                      <?php } ?> 
                    <?php } ?>   
                 </div>		

 <div class="content_detail_wrapper">
<?php if($_GET['view']=='me'||$_GET['view']=='lastlogin'||$_GET['view']=='hot') { ?>
  <div id="nav" style="margin-top:20px;margin-left:180px;">
<a href="space.php?do=friend" style="<?php if($_GET['view']=='me') { ?>color:#02B4AB<?php } ?>">最新关注排序</a><a href="space.php?do=friend&view=lastlogin" style="padding-left:20px;<?php if($_GET['view']=='lastlogin') { ?>color:#02B4AB<?php } ?>">最后登陆时间排序</a><a href="space.php?do=friend&view=hot" style="padding-left:20px;<?php if($_GET['view']=='hot') { ?>color:#02B4AB<?php } ?>">活跃度排序</a>

 	</div>
<?php } ?>  


<?php if($list) { ?>
<div class="thumb_list" id="friend_ul">
<ul style="margin-top:30px;">

<?php if(is_array($list)) { foreach($list as $key => $value) { ?>
<li id="friend_<?=$value['uid']?>_li" style="width:250px;margin-left:50px;height:80px;">
<?php if($value['username'] == '') { ?>
<div class="avatar48"><img src="image/magic/hidden.gif" alt="匿名" /></div>
<div class="thumbTitle"><p>匿名</p></div>
<?php } else { ?>
<div class="avatar48"><a href="space.php?uid=<?=$value['uid']?>"><?php echo avatar($value[uid],small); ?></a></div>
<div class="thumbTitle">
<p<?php if($ols[$value['uid']]) { ?> class="online_icon_p"<?php } ?>>
<a style="color:#02B4AB;" href="space.php?uid=<?=$value['uid']?>"<?php g_color($value[groupid]); ?>><?=$_SN[$value['uid']]?></a> 
<?php g_icon($value[groupid]); ?>
<?php if($value['videostatus']) { ?>
<img src="image/videophoto.gif" align="absmiddle">
<?php } ?>
</p></div>
<?php if($value['note']) { ?><div><?=$value['note']?></div><?php } ?>
<?php } ?>

<?php if($_GET['view']=='blacklist') { ?>
<div class="gray"><a href="cp.php?ac=friend&op=blacklist&subop=delete&uid=<?=$value['uid']?>&start=<?=$_GET['start']?>">黑名单除名</a></div>
<?php } elseif($_GET['view']=='visitor' || $_GET['view'] == 'trace') { ?>
<div class="gray"><?php echo sgmdate('n月j号',$value[dateline],1); ?></div>
<?php } elseif($_GET['view']=='online') { ?>
<div class="gray"><?php echo sgmdate('H:i',$ols[$value[uid]],1); ?></div>
<?php } else { ?>
<?php if($ols[$value['uid']]) { ?><div class="gray"><?php echo sgmdate('H:i',$ols[$value[uid]],1); ?></div><?php } ?>
<div class="gray">
<?php if(!empty($value['fakeid'])) { ?>
<a href="javascript:void;" id="a_talk_<?=$value['uid']?>" >私信</a>
<?php } ?>
<a href="cp.php?ac=friend&op=ignore&uid=<?=$value['uid']?>" id="a_ignore_<?=$key?>" onclick="ajaxmenu(event, this.id)">删除</a>
</div>
<?php } ?>
</li>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
    <script type='text/javascript' src='./source/jquery.simplemodal.js'></script>
    <script type="text/javascript">
    var jquery = jQuery.noConflict();
      jquery(document).ready(function(){
       jquery('#talk<?=$value['uid']?>').attr("style", "display:none;");
      
          jquery('#a_talk_<?=$value['uid']?>').click(function (e) {
    		e.preventDefault();
   jquery('#talk<?=$value['uid']?>').modal();
  });


            
       })
    </script>

<?php } } ?>
</ul>
</div>
<div class='pagination'><ul><?=$multi?></ul></div>

<?php } else { ?>
<div class="c_form" style="margin:0 auto;text-align:center;">
没有相关用户列表。
</div>
<?php } ?>

</div>
</div>


<div id="sidebar" style="width: 150px;">
<?php if($_SCONFIG['my_status']) { ?>
<!-- 同步客户至Manyou 开始 -->
<script type="text/javascript">
function my_sync_tip(msg, close_time) {;
var my_tip = document.getElementById("my_tip");
if (!my_tip) {
my_tip = document.createElement("div");
document.getElementsByTagName("body")[0].appendChild(my_tip);
my_tip.id = "my_tip";
}
my_tip.style.display = 'block';
my_tip.innerHTML = '<div class="popupmenu_centerbox" style="position: absolute; top: 200px; right: 500px; padding: 20px; width: 300px; height: 15px; z-index:9999;">' + msg + '</div>';
if (close_time) {
setTimeout("document.getElementById('my_tip').style.display = 'none';", close_time);
}
}
function my_sync_friend() {
my_sync_tip('正在同步客户信息...', 0);
var my_scri = document.createElement("script");
document.getElementsByTagName("head")[0].appendChild(my_scri);
my_scri.charset = "UTF-8";
my_scri.src = "http://uchome.manyou.com/user/syncFriends?sId=<?=$_SCONFIG['my_siteid']?>&uUchId=<?=$space['uid']?>&ts=<?=$_SGLOBAL['timestamp']?>&key=<?php echo md5($_SCONFIG[my_siteid] . $_SCONFIG[my_sitekey] . $space[uid] . $_SGLOBAL[timestamp]); ?>";
}
</script>

<div class="c_mgs"><div class="ye_r_t"><div class="ye_l_t"><div class="ye_r_b"><div class="ye_l_b">
<p>在游戏中找不到自己的客户？请点击下面的的按钮，将客户信息同步到里面。</p>
<p style="text-align: center;padding: 20px 0 0;"> <a href="#" onclick="my_sync_friend(); return false;" title="将客户关系同步至Manyou平台，以便在应用里看到他们"><img alt="刷新客户信息" src="image/syncfriend.gif"/></a> </p>
</div></div></div></div></div>
<!-- 同步客户至Manyou 结束 -->
<?php } ?>

<?php } else { ?>
<?php $_TPL['spacetitle'] = "客户";
	$_TPL['spacemenus'][] = "<a href=\"space.php?uid=$space[uid]&do=friend&view=me\">TA的客户列表</a>"; ?>
<div class="c_header a_header">
<div class="avatar48"><a href="space.php?uid=<?=$space['uid']?>"><?php echo avatar($space[uid],small); ?></a></div>
<?php if($_SGLOBAL['refer']) { ?>
<a class="r_option" href="<?=$_SGLOBAL['refer']?>">&laquo; 返回上一页</a>
<?php } ?>
<p style="font-size:14px"><?=$_SN[$space['uid']]?>的<?=$_TPL['spacetitle']?></p>
<a href="space.php?uid=<?=$space['uid']?>" class="spacelink"><?=$_SN[$space['uid']]?>的主页</a>
<?php if($_TPL['spacemenus']) { ?>
<?php if(is_array($_TPL['spacemenus'])) { foreach($_TPL['spacemenus'] as $value) { ?> <span class="pipe">&raquo;</span> <?=$value?><?php } } ?>
<?php } ?>
</div>

<div class="h_status">共有 <?=$space['friendnum']?> 个客户</div>
<div class="space_list">
<?php if($list) { ?>
<?php if(is_array($list)) { foreach($list as $key => $value) { ?>
<table cellspacing="0" cellpadding="0" width="100%">
<tr>
<td width="65"><div class="avatar48"><a href="space.php?uid=<?=$value['uid']?>"><?php echo avatar($value[uid],small); ?></a></div></td>
<td>
<h2>
<?php if($ols[$value['uid']]) { ?><img src="image/online_icon.gif" align="absmiddle"> <?php } ?>
<a href="space.php?uid=<?=$value['uid']?>" title="<?=$_SN[$value['uid']]?>"<?php g_color($value[groupid]); ?>><?=$_SN[$value['uid']]?></a>
<?php if($value['username'] && $_SN[$value['uid']]!=$value['username']) { ?><span class="gray">(<?=$value['username']?>)</span><?php } ?>
<?php g_icon($value[groupid]); ?>
<?php if($value['videostatus']) { ?>
<img src="image/videophoto.gif" align="absmiddle">
<?php } ?>
</h2>
<?php if($value['sex']==2) { ?><p>美女</p><?php } elseif($value['sex']==1) { ?><p>帅哥</p><?php } ?></p>
<p>
<?php if($_GET['view']=='show') { ?>竞价<?php } ?>积分：<?=$value['credit']?> / <?php if($value['experience']) { ?>经验：<?=$value['experience']?> / <?php } ?>人气：<?=$value['viewnum']?> / 好友：<?=$value['friendnum']?></p>
<?php if($value['note']) { ?><?=$value['note']?><?php } ?>
</td>
<td width="100">
<ul class="line_list">
<li><a href="space.php?uid=<?=$value['uid']?>">去串个门</a></li>
<li><a href="cp.php?ac=poke&op=send&uid=<?=$value['uid']?>" id="a_poke_<?=$key?>" onclick="ajaxmenu(event, this.id, 1)" title="打招呼">打个招呼</a></li>
<?php if(isset($value['isfriend']) && !$value['isfriend']) { ?><li><a href="cp.php?ac=friend&op=add&uid=<?=$value['uid']?>" id="a_friend_<?=$key?>" onclick="ajaxmenu(event, this.id, 1)" title="加好友">加为好友</a></li><?php } ?>	
</ul>
</td>
</tr>
</table>
<?php } } ?>
<div class="page"><?=$multi?></div>
<?php } else { ?>
<div class="c_form">没有相关成员。</div>
<?php } ?>
</div>



<?php } ?>

<?php } ?>


<?php if(is_array($list)) { foreach($list as $key => $value) { ?>

    <div id="talk<?=$value['uid']?>">
  <h3 style="font-size:20px;color:#44B1BA;background:#ECEFF1;margin:0;line-height:40px;text-align:left;padding-left:10px;">私信</h3>
  <div style="width:600px;background:#fff;margin:20px auto;text-align:center;"><form action = "space.php?do=friend" method = "post"><input type="text" name="message" style="width:300px;"><input type="hidden" name="fakeid" value="<?=$value['fakeid']?>"><input type="hidden" name="uid" value="<?=$space['uid']?>"> <br/><br/><input type="submit" style="margin-left:250px;" class="btn grid_2" name="friendreply"></form></div>

</div>
<?php } } ?>

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
<?php } ?>
<?php ob_out();?>