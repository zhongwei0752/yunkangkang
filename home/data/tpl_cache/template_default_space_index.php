<?php if(!defined('IN_UCHOME')) exit('Access Denied');?><?php subtplcheck('template/default/space_index|template/default/header|template/default/space_feed_li|template/default/footer', '1396518846', 'template/default/space_index');?><?php if(empty($_SGLOBAL['inajax'])) { ?>
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


<?php if($narrowlist || $widelist) { ?>
<script type="text/javascript" src="source/script_swfobject.js"></script>
<?php } ?>
 <script type="application/javascript" src="./template/default/awesomechart.js"> </script>

    <head>

        <style>
   
.progressbar{
    position:relative;
    display:block;
    width:400px;
    height:20px;
    padding:10px 20px;
    border-bottom:1px solid rgba(255,255,255,0.25);
    border-radius:16px;
    margin:5px;
    margin-left:100px;

}
.progressbar:before{
    position:absolute;
    display:block;
    content:"";
    width:400px;
    height:18px;
    top:10px;
    left:20px;
-webkit-border-radius:20px;
    border-radius:20px;
    
-webkit-box-shadow: inset 0px 0px 2px 0px rgba(90, 86, 86, 0.85);
}
.bar {
position:absolute;
display:block;
width:0px;
height:15px;
top:11px;
left:22px;
background: rgb(126,234,25);
background: -moz-linear-gradient(top,  rgba(126,234,25,1) 0%, rgba(83,173,0,1) 100%);
background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,rgba(126,234,25,1)), color-stop(100%,rgba(83,173,0,1)));
background: -webkit-linear-gradient(top,  rgba(126,234,25,1) 0%,rgba(83,173,0,1) 100%);
background: -o-linear-gradient(top,  rgba(126,234,25,1) 0%,rgba(83,173,0,1) 100%);
background: -ms-linear-gradient(top,  rgba(126,234,25,1) 0%,rgba(83,173,0,1) 100%);
background: linear-gradient(to bottom,  rgba(126,234,25,1) 0%,rgba(83,173,0,1) 100%);
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#7eea19', endColorstr='#53ad00',GradientType=0 );
-webkit-border-radius:16px;
border-radius:16px;
-webkit-box-shadow: 0px 0px 12px 0px rgba(126, 234, 25, 1),inset 0px 1px 0px 0px rgba(255, 255, 255, 0.45),inset 1px 0px 0px 0px rgba(255, 255, 255, 0.25),inset -1px 0px 0px 0px rgba(255, 255, 255, 0.25);
box-shadow: 0px 0px 12px 0px rgba(126, 234, 25, 1),inset 0px 1px 0px 0px rgba(255, 255, 255, 0.45),inset 1px 0px 0px 0px rgba(255, 255, 255, 0.25),inset -1px 0px 0px 0px rgba(255, 255, 255, 0.25);
overflow:hidden;
}
.bar.color2 {
background: rgb(229,195,25);
background: -moz-linear-gradient(top,  rgba(229,195,25,1) 0%, rgba(168,140,0,1) 100%);
background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,rgba(229,195,25,1)), color-stop(100%,rgba(168,140,0,1)));
background: -webkit-linear-gradient(top,  rgba(229,195,25,1) 0%,rgba(168,140,0,1) 100%);
background: -o-linear-gradient(top,  rgba(229,195,25,1) 0%,rgba(168,140,0,1) 100%);
background: -ms-linear-gradient(top,  rgba(229,195,25,1) 0%,rgba(168,140,0,1) 100%);
background: linear-gradient(to bottom,  rgba(229,195,25,1) 0%,rgba(168,140,0,1) 100%);
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#e5c319', endColorstr='#a88c00',GradientType=0 );
-webkit-box-shadow: 0px 0px 12px 0px rgba(229, 195, 25, 1),inset 0px 1px 0px 0px rgba(255, 255, 255, 0.45),inset 1px 0px 0px 0px rgba(255, 255, 255, 0.25),inset -1px 0px 0px 0px rgba(255, 255, 255, 0.25);
box-shadow: 0px 0px 12px 0px rgba(229, 195, 25, 1),inset 0px 1px 0px 0px rgba(255, 255, 255, 0.45),inset 1px 0px 0px 0px rgba(255, 255, 255, 0.25),inset -1px 0px 0px 0px rgba(255, 255, 255, 0.25);
}
.bar.color3 {
background: rgb(232,25,87);
background: -moz-linear-gradient(top,  rgba(232,25,87,1) 0%, rgba(170,0,51,1) 100%);
background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,rgba(232,25,87,1)), color-stop(100%,rgba(170,0,51,1)));
background: -webkit-linear-gradient(top,  rgba(232,25,87,1) 0%,rgba(170,0,51,1) 100%);
background: -o-linear-gradient(top,  rgba(232,25,87,1) 0%,rgba(170,0,51,1) 100%);
background: -ms-linear-gradient(top,  rgba(232,25,87,1) 0%,rgba(170,0,51,1) 100%);
background: linear-gradient(to bottom,  rgba(232,25,87,1) 0%,rgba(170,0,51,1) 100%);
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#e81957', endColorstr='#aa0033',GradientType=0 );
-webkit-box-shadow: 0px 0px 12px 0px rgba(232, 25, 87, 1),inset 0px 1px 0px 0px rgba(255, 255, 255, 0.45),inset 1px 0px 0px 0px rgba(255, 255, 255, 0.25),inset -1px 0px 0px 0px rgba(255, 255, 255, 0.25);
box-shadow: 0px 0px 12px 0px rgba(232, 25, 87, 1),inset 0px 1px 0px 0px rgba(255, 255, 255, 0.45),inset 1px 0px 0px 0px rgba(255, 255, 255, 0.25),inset -1px 0px 0px 0px rgba(255, 255, 255, 0.25);
}
.bar.color4 {
background: rgb(24,109,226);
background: -moz-linear-gradient(top,  rgba(24,109,226,1) 0%, rgba(0,69,165,1) 100%);
background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,rgba(24,109,226,1)), color-stop(100%,rgba(0,69,165,1)));
background: -webkit-linear-gradient(top,  rgba(24,109,226,1) 0%,rgba(0,69,165,1) 100%);
background: -o-linear-gradient(top,  rgba(24,109,226,1) 0%,rgba(0,69,165,1) 100%);
background: -ms-linear-gradient(top,  rgba(24,109,226,1) 0%,rgba(0,69,165,1) 100%);
background: linear-gradient(to bottom,  rgba(24,109,226,1) 0%,rgba(0,69,165,1) 100%);
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#186de2', endColorstr='#0045a5',GradientType=0 );
-webkit-box-shadow: 0px 0px 12px 0px rgba(24, 109, 226, 1),inset 0px 1px 0px 0px rgba(255, 255, 255, 0.45),inset 1px 0px 0px 0px rgba(255, 255, 255, 0.25),inset -1px 0px 0px 0px rgba(255, 255, 255, 0.25);
box-shadow: 0px 0px 12px 0px rgba(24, 109, 226, 1),inset 0px 1px 0px 0px rgba(255, 255, 255, 0.45),inset 1px 0px 0px 0px rgba(255, 255, 255, 0.25),inset -1px 0px 0px 0px rgba(255, 255, 255, 0.25);
}
.bar.color5 {
background: rgb(124,149,6);

filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#186de2', endColorstr='#0045a5',GradientType=0 );
-webkit-box-shadow: 0px 0px 12px 0px rgba(24, 109, 226, 1),inset 0px 1px 0px 0px rgba(255, 255, 255, 0.45),inset 1px 0px 0px 0px rgba(255, 255, 255, 0.25),inset -1px 0px 0px 0px rgba(255, 255, 255, 0.25);
box-shadow: 0px 0px 12px 0px rgba(24, 109, 226, 1),inset 0px 1px 0px 0px rgba(255, 255, 255, 0.45),inset 1px 0px 0px 0px rgba(255, 255, 255, 0.25),inset -1px 0px 0px 0px rgba(255, 255, 255, 0.25);
}
.bar.color6 {
background: rgb(214,179,6);

filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#186de2', endColorstr='#0045a5',GradientType=0 );
-webkit-box-shadow: 0px 0px 12px 0px rgba(24, 109, 226, 1),inset 0px 1px 0px 0px rgba(255, 255, 255, 0.45),inset 1px 0px 0px 0px rgba(255, 255, 255, 0.25),inset -1px 0px 0px 0px rgba(255, 255, 255, 0.25);
box-shadow: 0px 0px 12px 0px rgba(24, 109, 226, 1),inset 0px 1px 0px 0px rgba(255, 255, 255, 0.45),inset 1px 0px 0px 0px rgba(255, 255, 255, 0.25),inset -1px 0px 0px 0px rgba(255, 255, 255, 0.25);
}
.bar:before {
position:absolute;
display:block;
content:"";
width:606px;
height:150%;
top:-25%;
left:-25px;

}
.bar:after {
position:absolute;
display:block;
content:"";
width:64px;
height:16px;
right:0;
top:0;
-webkit-border-radius: 0px 16px 16px 0px;
border-radius: 0px 16px 16px 0px;

}
.bar span {
position:absolute;
display:block;
width:100%;
height:64px;
-webkit-border-radius:16px;
border-radius:16px;
top:0;
left:0;
background:url("data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAG4AAABACAYAAAD7/UK9AAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAyJpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuMC1jMDYxIDY0LjE0MDk0OSwgMjAxMC8xMi8wNy0xMDo1NzowMSAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENTNS4xIFdpbmRvd3MiIHhtcE1NOkluc3RhbmNlSUQ9InhtcC5paWQ6MjdFQ0M2MzdDQThBMTFFMUE3NzJFNzY4M0ZDMTA3MTIiIHhtcE1NOkRvY3VtZW50SUQ9InhtcC5kaWQ6MjdFQ0M2MzhDQThBMTFFMUE3NzJFNzY4M0ZDMTA3MTIiPiA8eG1wTU06RGVyaXZlZEZyb20gc3RSZWY6aW5zdGFuY2VJRD0ieG1wLmlpZDoyN0VDQzYzNUNBOEExMUUxQTc3MkU3NjgzRkMxMDcxMiIgc3RSZWY6ZG9jdW1lbnRJRD0ieG1wLmRpZDoyN0VDQzYzNkNBOEExMUUxQTc3MkU3NjgzRkMxMDcxMiIvPiA8L3JkZjpEZXNjcmlwdGlvbj4gPC9yZGY6UkRGPiA8L3g6eG1wbWV0YT4gPD94cGFja2V0IGVuZD0iciI/PoTG0pMAABr+SURBVHjavJ1nj1zX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") 0 0;
-webkit-animation: sparkle 1500ms linear infinite;
    -moz-animation: sparkle 1500ms linear infinite;
    -o-animation: sparkle 1500ms linear infinite;
    animation: sparkle 1500ms linear infinite;
opacity:0.2;
}
.label {
font-family: 'Aldrich', sans-serif;
position:absolute;
display:block;
width:40px;
height:30px;
line-height:30px;
top:5px;
left:20px;

filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#4c4c4c', endColorstr='#262626',GradientType=0 );
font-weight:bold;
font-size:12px;
color:#fff;
text-align:center;
-webkit-border-radius:6px;

text-shadow: 0px -1px 0px #000000,0px 1px 1px #000000;
    filter: dropshadow(color=#000000, offx=0, offy=-1);
}
.label span {
position:absolute;
display:block;
width:12px;
height:9px;
top:-9px;
left:14px;
background:transparent;
overflow:hidden;
}
.label span:before {
position:absolute;
display:block;
content:"";


filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#565656', endColorstr='#4c4c4c',GradientType=1 );
-webkit-box-shadow: 0px -1px 2px 0px rgba(0, 0, 0, 0.15);
box-shadow: 0px -1px 2px 0px rgba(0, 0, 0, 0.15);
-moz-transform:rotate(45deg);
-webkit-transform:rotate(45deg);
-o-transform:rotate(45deg);
-ms-transform:rotate(45deg);
transform:rotate(45deg);
}
@-webkit-keyframes sparkle {
from {background-position: 0 0;}
to {background-position: 0 -64px;}
}
@-moz-keyframes sparkle {
from {background-position: 0 0;}
to {background-position: 0 -64px;}
}
@-o-keyframes sparkle {
from {background-position: 0 0;}
to {background-position: 0 -64px;}
}
@keyframes sparkle {
from {background-position: 0 0;}
to {background-position: 0 -64px;}
}
          
        </style>
    </head>
    <body>

        

     	  



<div id="content" style="width:1024px;">

<div class="content_detail_wrapper">
<div id="space_page" >
<br/>


<div id="content" style="width:1024px;">


<div id="maincontent" style="margin:0 auto;width:760px;">
<h3 class="feed_header">
<?php if($space['name']) { ?><?=$space['name']?><?php } else { ?><?=$space['username']?><?php } ?>活跃度统计
</h3>
<table cellspacing="0" cellpadding="0" class="formtable">

<tr><td>
<div class="borderbox" style="width:520px;">
<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,45,0" width="500" height="300">
  <param name="movie" value="image/stat.swf?<?=$statuspara?>" />
  <param name="quality" value="high" />
  <embed src="image/stat.swf?<?=$statuspara?>" quality="high" pluginspage="http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash" type="application/x-shockwave-flash" width="500" height="300"></embed>
</object>
</div>
</td></tr>
</table>

<h3 class="feed_header">
<?php if($space['name']) { ?><?=$space['name']?><?php } else { ?><?=$space['username']?><?php } ?>组件使用统计
</h3>
<script id="jquery_183" type="text/javascript" class="library" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<?php if(is_array($myself)) { foreach($myself as $value) { ?>

<div class="progressbar" data-perc="<?=$c[$value['english']]?>">
<div style="margin-left:-130px;"><?=$value['subject']?>(查看:<?=$a[$value['english']]?>)</div>
<?php $abc=$value[abc]; ?>
<div class="bar color<?=$abc?>"><span></span></div>
<div class="label"><span></span></div>
</div>
<?php } } ?>		

<br/>
<h3 class="feed_header">
<?php if($space['name']) { ?><?=$space['name']?><?php } else { ?><?=$space['username']?><?php } ?>评论统计
</h3>
<script id="jquery_183" type="text/javascript" class="library" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<?php if(is_array($myself)) { foreach($myself as $value) { ?>

<div class="progressbar" data-perc="<?=$d[$value['english']]?>">
<div style="margin-left:-130px;"><?=$value['subject']?>(评论:<?=$b[$value['english']]?>)</div>
<?php $abc=$value[abc]; ?>
<div class="bar color<?=$abc?>"><span></span></div>
<div class="label"><span></span></div>
</div>
<?php } } ?>

<br/>



<?php if($feedlist) { ?>
<?php $_TPL['hidden_hot']=1; ?>
<div id="space_feed" class="feed">
<h3 class="feed_header">
<span class="entry-title">最新动态</span>
</h3>
<div class="box_content">
<ul>
<?php if(is_array($feedlist)) { foreach($feedlist as $value) { ?>
<li class="s_clear <?=$value['magic_class']?>" id="feed_<?=$value['feedid']?>_li" onmouseover="feed_menu(<?=$value['feedid']?>,1);" onmouseout="feed_menu(<?=$value['feedid']?>,0);">
<div style="width:100%;overflow:hidden;" <?=$value['style']?>>
<?php if($value['uid'] && empty($_TPL['hidden_more'])) { ?>
<a href="cp.php?ac=feed&op=menu&feedid=<?=$value['feedid']?>" class="float_more" id="a_feed_menu_<?=$value['feedid']?>"  onmouseover="feed_menu(<?=$value['feedid']?>,1);" onmouseout="feed_menu(<?=$value['feedid']?>,0);" onclick="ajaxmenu(event, this.id)" title="显示更多选项" style="display:none;">菜单</a>
<?php } ?>
<a class="type" href="space.php?uid=<?=$_GET['uid']?>&do=feed&view=<?=$_GET['view']?>&appid=<?=$value['appid']?>&icon=<?=$value['icon']?>" title="只看此类动态"><img src="<?=$value['icon_image']?>" /></a>
<?=$value['title_template']?> 

<?php if(empty($_TPL['hidden_time'])) { ?>
<span class="gray"><?php echo sgmdate('m-d H:i',$value[dateline],1); ?></span>
<?php } ?>

<?php if(empty($_TPL['hidden_menu'])) { ?>
<?php if($value['idtype']=='doid') { ?>
(<a href="javascript:;" onclick="docomment_get('docomment_<?=$value['id']?>', 1);" id="do_a_op_<?=$value['id']?>">回复</a>)
<?php } elseif(in_array($value['idtype'], array('blogid','picid','sid','pid','eventid'))) { ?>
(<a href="javascript:;" onclick="feedcomment_get(<?=$value['feedid']?>);" id="feedcomment_a_op_<?=$value['feedid']?>">评论</a>)
<?php } ?>
<?php } ?>

<div class="feed_content">

<?php if(empty($_TPL['hidden_hot']) && $value['hot']) { ?>
<div class="hotspot"><a href="cp.php?ac=feed&feedid=<?=$value['feedid']?>"><?=$value['hot']?></a></div>
<?php } ?>	

<?php if($value['image_1']) { ?>
<a href="<?=$value['image_1_link']?>"<?=$value['target']?>><img src="<?=$value['image_1']?>" class="summaryimg" /></a>
<?php } ?>
<?php if($value['image_2']) { ?>
<a href="<?=$value['image_2_link']?>"<?=$value['target']?>><img src="<?=$value['image_2']?>" class="summaryimg" /></a>
<?php } ?>
<?php if($value['image_3']) { ?>
<a href="<?=$value['image_3_link']?>"<?=$value['target']?>><img src="<?=$value['image_3']?>" class="summaryimg" /></a>
<?php } ?>
<?php if($value['image_4']) { ?>
<a href="<?=$value['image_4_link']?>"<?=$value['target']?>><img src="<?=$value['image_4']?>" class="summaryimg" /></a>
<?php } ?>

<?php if($value['body_template']) { ?>
<div class="detail"<?php if($value['image_3']) { ?> style="clear: both;"<?php } ?>>
<?=$value['body_template']?>
</div>
<?php } ?>

<?php if($value['thisapp'] && !empty($value['body_data']['flashvar'])) { ?>
<div class="media">
<img src="image/vd.gif" alt="点击播放" onclick="javascript:showFlash('<?=$value['body_data']['host']?>', '<?=$value['body_data']['flashvar']?>', this, '<?=$value['feedid']?>');" style="cursor:pointer;" />
</div>
<?php } elseif($value['thisapp'] && !empty($value['body_data']['musicvar'])) { ?>
<div class="media">
<img src="image/music.gif" alt="点击播放" onclick="javascript:showFlash('music', '<?=$value['body_data']['musicvar']?>', this, '<?=$value['feedid']?>');" style="cursor:pointer;" />
</div>
<?php } elseif($value['thisapp'] && !empty($value['body_data']['flashaddr'])) { ?>
<div class="media">
<img src="image/flash.gif" alt="点击查看" onclick="javascript:showFlash('flash', '<?=$value['body_data']['flashaddr']?>', this, '<?=$value['feedid']?>');" style="cursor:pointer;" />
</div>
<?php } ?>

<?php if($value['body_general']) { ?>
<div class="quote"><span class="q"><?=$value['body_general']?></span></div>
<?php } ?>
</div>
</div>

<?php if($value['idtype']=='doid') { ?>
<div id="docomment_<?=$value['id']?>" style="display:none;"></div>
<?php } elseif($value['idtype']) { ?>
<div id="feedcomment_<?=$value['feedid']?>" style="display:none;"></div>
<?php } ?>

<?php if(!empty($hiddenfeed_num[$value['icon']])) { ?>
<div id="appfeed_open_<?=$value['feedid']?>"><a href="javascript:;" id="feed_a_more_<?=$value['feedid']?>" onclick="feed_more_show('<?=$value['feedid']?>');">&raquo; 更多动态(<?=$hiddenfeed_num[$value['icon']]?>)</a></div>
<div id="feed_more_<?=$value['feedid']?>" style="display:none;">
<ol>
<?php if(is_array($hiddenfeed_list[$value['icon']])) { foreach($hiddenfeed_list[$value['icon']] as $appvalue) { ?>
<?php $appvalue = mkfeed($appvalue); ?>
<li>
<?=$appvalue['title_template']?>
<div class="feed_content" style="width:100%;overflow:hidden;">
<?php if($appvalue['image_1']) { ?>
<a href="<?=$appvalue['image_1_link']?>"<?=$appvalue['target']?>><img src="<?=$appvalue['image_1']?>" class="summaryimg" /></a>
<?php } ?>
<?php if($appvalue['image_2']) { ?>
<a href="<?=$appvalue['image_2_link']?>"<?=$appvalue['target']?>><img src="<?=$appvalue['image_2']?>" class="summaryimg" /></a>
<?php } ?>
<?php if($appvalue['image_3']) { ?>
<a href="<?=$appvalue['image_3_link']?>"<?=$appvalue['target']?>><img src="<?=$appvalue['image_3']?>" class="summaryimg" /></a>
<?php } ?>
<?php if($appvalue['image_4']) { ?>
<a href="<?=$appvalue['image_4_link']?>"<?=$appvalue['target']?>><img src="<?=$appvalue['image_4']?>" class="summaryimg" /></a>
<?php } ?>
<?php if($appvalue['body_template']) { ?>
<div class="detail"<?php if($appvalue['image_3']) { ?> style="clear: both;"<?php } ?>>
<?=$appvalue['body_template']?>
</div>
<?php } ?>
<?php if($appvalue['body_general']) { ?>
<div class="quote"><span class="q"><?=$appvalue['body_general']?></span></div>
<?php } ?>
</div>
</li>
<?php } } ?>
</ol>
</div>
<?php } ?>
</li>
<?php } } ?>
</ul>
</div>
</div>
<?php } ?>



<?php if(is_array($widelist)) { foreach($widelist as $value) { ?>
<?php if($value['myml']) { ?>
<div id="space_app_<?=$value['appid']?>" class="appbox">
<h3 class="feed_header">
<?php if($space['self']) { ?>
<a href="cp.php?ac=space&op=delete&appid=<?=$value['appid']?>" id="user_app_<?=$value['appid']?>" class="r_option float_del" onclick="ajaxmenu(event, this.id)" title="删除">删除</a>
<?php } ?>
<a href="<?=$value['appurl']?>"><?=$value['appname']?></a>
</h3>
<div class="box" style="margin: 0 0 20px;">
<?php eval($value[myml]); ?>
</div>
</div>
<?php } ?>
<?php } } ?>

</div>


</div>


</div>
</div>
</div>



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

<script>
function getindex(type) {
var plus = '';
if(type == 'event') plus = '&type=self';
ajaxget('space.php?uid=<?=$space['uid']?>&do=development&view=me'+plus+'&ajaxdiv=maincontent', 'maincontent');
}

//彩虹炫
var elems = selector('div[class~=magicflicker]'); 
for(var i=0; i<elems.length; i++){
magicColor(elems[i]);
}

</script>
<script>
$(function() {

$('.progressbar').each(function(){
var t = $(this),
dataperc = t.attr('data-perc'),
barperc = Math.round(dataperc*3.98);
t.find('.bar').animate({width:barperc}, dataperc*25);
t.find('.label').append('<div class="perc"></div>');

function perc() {
var length = t.find('.bar').css('width'),
perc = Math.round(parseInt(length)/3.98),
labelpos = (parseInt(length)-2);

t.find('.perc').text(perc+'%');
}
perc();
setInterval(perc, 0); 
});
});
</script>

        <script type="application/javascript">
        
            var chart1 = new AwesomeChart('chartCanvas1');
            chart1.title ="";
            chart1.data = [<?php if(is_array($myself)) { foreach($myself as $value) { ?><?=$b[$value['english']]?>,<?php } } ?>];
            chart1.labels = [<?php if($myself1['0']['subject']) { ?>"<?=$myself1['0']['subject']?>",<?php } ?><?php if($myself1['1']['subject']) { ?>"<?=$myself1['1']['subject']?>",<?php } ?><?php if($myself1['2']['subject']) { ?>"<?=$myself1['2']['subject']?>",<?php } ?><?php if($myself1['3']['subject']) { ?>"<?=$myself1['3']['subject']?>",<?php } ?><?php if($myself1['4']['subject']) { ?>"<?=$myself1['4']['subject']?>",<?php } ?><?php if($myself1['5']['subject']) { ?>"<?=$myself1['5']['subject']?>",<?php } ?><?php if($myself1['6']['subject']) { ?>"<?=$myself1['6']['subject']?>",<?php } ?><?php if($myself1['7']['subject']) { ?>"<?=$myself1['7']['subject']?>",<?php } ?><?php if($myself1['8']['subject']) { ?>"<?=$myself1['8']['subject']?>",<?php } ?>];
            chart1.colors = ['#006CFF', '#FF6600', '#34A038', '#945D59', '#93BBF4', '#F493B8'];
            chart1.randomColors = true;
            chart1.animate = true;
            chart1.animationFrames = 30;
            chart1.draw();
             var chart2 = new AwesomeChart('chartCanvas2');
            chart2.title = "";
            chart2.data = [<?php if($myself1['0']['subject']) { ?><?=$a[$myself1['0']['english']]?>,<?php } ?><?php if($myself1['1']['subject']) { ?><?=$a[$myself1['1']['english']]?>,<?php } ?><?php if($myself1['2']['subject']) { ?><?=$a[$myself1['2']['english']]?>,<?php } ?><?php if($myself1['3']['subject']) { ?><?=$a[$myself1['3']['english']]?>,<?php } ?><?php if($myself1['4']['subject']) { ?><?=$a[$myself1['4']['english']]?>,<?php } ?><?php if($myself1['5']['subject']) { ?><?=$a[$myself1['5']['english']]?>,<?php } ?><?php if($myself1['6']['subject']) { ?><?=$a[$myself1['6']['english']]?>,<?php } ?><?php if($myself1['7']['subject']) { ?><?=$a[$myself1['7']['english']]?>,<?php } ?>];
            chart2.labels = [<?php if($myself1['0']['subject']) { ?>"<?=$myself1['0']['subject']?>",<?php } ?><?php if($myself1['1']['subject']) { ?>"<?=$myself1['1']['subject']?>",<?php } ?><?php if($myself1['2']['subject']) { ?>"<?=$myself1['2']['subject']?>",<?php } ?><?php if($myself1['3']['subject']) { ?>"<?=$myself1['3']['subject']?>",<?php } ?><?php if($myself1['4']['subject']) { ?>"<?=$myself1['4']['subject']?>",<?php } ?><?php if($myself1['5']['subject']) { ?>"<?=$myself1['5']['subject']?>",<?php } ?><?php if($myself1['6']['subject']) { ?>"<?=$myself1['6']['subject']?>",<?php } ?><?php if($myself1['7']['subject']) { ?>"<?=$myself1['7']['subject']?>",<?php } ?><?php if($myself1['8']['subject']) { ?>"<?=$myself1['8']['subject']?>",<?php } ?>];
            chart2.barFillStyle = chart1.colors[0];
            chart2.labelFillStyle = chart1.colors[0];
            chart2.randomColors = true;
            chart2.animate = true;
            chart2.animationFrames = 30;
            chart2.draw();
            
          
        </script>
 <?php ob_out();?>