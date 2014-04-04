<?php if(!defined('IN_UCHOME')) exit('Access Denied');?><?php subtplcheck('template/default/space_showmenuset1|template/default/header|template/default/footer', '1386640974', 'template/default/space_showmenuset1');?><?php $_TPL['titles'] = array('应用'); ?>
<?php $friendsname = array(1 => '仅好友可见',2 => '指定好友可见',3 => '仅自己可见',4 => '凭密码可见'); ?>

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

<mce:style type="text/css"><!--  
/* css document */ body {  
    font: normal 11px auto "trebuchet ms", verdana, arial, helvetica, sans-serif;  
    color: #4f6b72;  
    background: #e6eae9;  
}  
a {  
    color: #c75f3e;  
}  
#mytable {  
    width: 700px;  
    padding: 0;  
    margin: 0;  
}  
caption {  
    padding: 0 0 5px 0;  
    width: 700px;  
    font: italic 11px "trebuchet ms", verdana, arial, helvetica, sans-serif;  
    text-align: right;  
}  
th {  
    font: bold 11px "trebuchet ms", verdana, arial, helvetica, sans-serif;  
    color: #4f6b72;  
    border-right: 1px solid #c1dad7;  
    border-bottom: 1px solid #c1dad7;  
    border-top: 1px solid #c1dad7;  
    letter-spacing: 2px;  
    text-transform: uppercase;  
    text-align: left;  
    padding: 6px 6px 6px 12px;  
    background: #cae8ea url(images/bg_header.jpg) no-repeat;  
}  
td {  
    border-right: 1px solid #c1dad7;  
    border-bottom: 1px solid #c1dad7;  
    background: #fff;  
    font-size:11px;  
    padding: 6px 6px 6px 12px;  
    color: #4f6b72;  
}  
td.alt {  
    background: #f5fafa;  
    color: #797268;  
}  
th.spec {  
    border-left: 1px solid #c1dad7;  
    border-top: 0;  
    background: #fff url(images/bullet1.gif) no-repeat;  
    font: bold 10px "trebuchet ms", verdana, arial, helvetica, sans-serif;  
}  
th.specalt {  
    border-left: 1px solid #c1dad7;  
    border-top: 0;  
    background: #f5fafa url(images/bullet2.gif) no-repeat;  
    font: bold 10px "trebuchet ms", verdana, arial, helvetica, sans-serif;  
    color: #797268;  
} /*-----for ie 5.x bug*/  
html>body td {  
    font-size:11px;  
}  
--></mce:style><style type="text/css" mce_bogus="1">/* css document */ body {  
    font: normal 11px auto "trebuchet ms", verdana, arial, helvetica, sans-serif;  
    color: #4f6b72;  
    background: #e6eae9;  
}  
a {  
    color: #c75f3e;  
}  
#mytable {  
    width: 700px;  
    padding: 0;  
    margin: 0;  
}  
caption {  
    padding: 0 0 5px 0;  
    width: 700px;  
    font: italic 11px "trebuchet ms", verdana, arial, helvetica, sans-serif;  
    text-align: right;  
}  
th {  
    font: bold 11px "trebuchet ms", verdana, arial, helvetica, sans-serif;  
    color: #4f6b72;  
    border-right: 1px solid #c1dad7;  
    border-bottom: 1px solid #c1dad7;  
    border-top: 1px solid #c1dad7;  
    letter-spacing: 2px;  
    text-transform: uppercase;  
    text-align: left;  
    padding: 6px 6px 6px 12px;  
    background: #cae8ea url(images/bg_header.jpg) no-repeat;  
}  
td {  
    border-right: 1px solid #c1dad7;  
    border-bottom: 1px solid #c1dad7;  
    background: #fff;  
    font-size:11px;  
    padding: 6px 6px 6px 12px;  
    color: #4f6b72;  
}  
td.alt {  
    background: #f5fafa;  
    color: #797268;  
}  
th.spec {  
    border-left: 1px solid #c1dad7;  
    border-top: 0;  
    background: #fff url(images/bullet1.gif) no-repeat;  
    font: bold 10px "trebuchet ms", verdana, arial, helvetica, sans-serif;  
}  
th.specalt {  
    border-left: 1px solid #c1dad7;  
    border-top: 0;  
    background: #f5fafa url(images/bullet2.gif) no-repeat;  
    font: bold 10px "trebuchet ms", verdana, arial, helvetica, sans-serif;  
    color: #797268;  
} /*-----for ie 5.x bug*/  
html>body td {  
    font-size:11px;  
}</style>

  <link rel="stylesheet" href="./template/default/base.css" />
    <link rel="stylesheet" href="./template/default/common.css" />
    <link rel="stylesheet" href="./template/default/nav.css" />
    <link rel="stylesheet" href="./template/default/bottomWrapper.css" />
    <link rel="stylesheet" href="./template/default/setItem.css" />
    <link rel="stylesheet" href="./template/default/set.css" />
    <script type="text/javascript" src="./source/jquery-1.10.2.js"></script>
    <script type="text/javascript" src="./source/jquery-1.9.0.min.js"></script>
    <script type="text/javascript" src="./source/set_html_effect.js"></script>
    <script type="text/javascript" src="./source/set_html_function.js"></script>
    <script type="text/javascript"></script>
  <!--[if IE 6]>
    <script type="text/javascript" src="js/DD_belatedPNG.js"></script>
        <script type="text/javascript" src="js/IEwarning.js"></script>
      <script type="text/javascript" charset="utf-8">
        DD_belatedPNG.fix(".pngFix,.pngFix:hover");      
      </script>
   <![endif]-->
        <!--[if IE 7]>
        <script type="text/javascript" src="js/IEwarning.js"></script>
        <![endif]-->
   <!-- 修复ie6透明png的bug -->
  </head>
 <!-- Bootstrap -->
   <!--  <link href="css/bootstrap.min.css" rel="stylesheet" media="screen"> -->
    <link rel="stylesheet" type="text/css" href="./template/default/jquery-mobile-fluid960.min.css">
    <link rel="stylesheet" type="text/css" href="./template/default/style1.css">
     
    <style type="text/css">
        .wrapper {
          background-color: #fff;
        }
        #setItem2 {
        margin-top: 20px;
        }
        .companies .grid_3 span img{
             max-width:71px;max-height:71px;min-width:71px;min-height:71px;
          } 
        .companies .grid_4 img{
             max-width:172px;max-height:53px;min-width:172px;min-height:53px;
        }
        /*login hack*/
        #email,#tx,#pwd{
        margin-left:-12px\9;
        }

        body{
          color:#fff;
          background:#fff; 
        }
             </style>
<br/><br/>
  <?php if($list) { ?>
<table id="mytable" cellspacing="0" summary="the technical specifications of the apple powermac g5 series" style="margin:0 auto;">  
  <caption>  
  </caption>  
   <?php if($_GET['moblienum']) { ?>
   <tr>  
    <th scope="col" abbr="configurations">应用名称</th>    
    <th scope="col" abbr="dual 2">单价(单位:元)</th> 
     <th scope="col" abbr="dual 2">总价(单位:元)</th>   
  </tr> 
    <?php } else { ?>
  <tr>  
    <th scope="col" abbr="configurations">套餐名称</th>  
    <th scope="col" abbr="dual 1.8">购买年份(单位:年)</th>  
    <th scope="col" abbr="dual 2">单价(单位:元)</th> 
     <th scope="col" abbr="dual 2">操作</th>   
  </tr>  
   <?php } ?>
 <?php if($_GET['moblienum']) { ?>
 <tr>  
    <th scope="row" abbr="model" class="spec"><?=$list['subject']?></th>  
    <td><?=$list['money']?></td>  
    <td></td>   
   
  </tr>  
 <?php } else { ?>
  <?php if($_GET['id']=='mianfei') { ?>
  <tr>  
    <th scope="row" abbr="model" class="spec">普通套餐</th>  
    <td>1</td>  
    <td>1000</td>   
    <td><a href="space.php?do=showmenuset&op=delete&id=<?=$value['menusetid']?>">删除</td>   
  </tr> 
<?php } ?>
 <?php if($_GET['id']=='putong') { ?>
  <tr>  
    <th scope="row" abbr="model" class="spec">增强套餐</th>  
    <td>1</td>  
    <td>4800</td>   
    <td><a href="space.php?do=showmenuset&op=delete&id=<?=$value['menusetid']?>">删除</td>   
  </tr> 
<?php } ?>
 <?php if($_GET['id']=='gaoji') { ?>
 <tr>  
    <th scope="row" abbr="model" class="spec">高级套餐</th>  
    <td>1</td>  
    <td>9800</td>   
    <td><a href="space.php?do=showmenuset&op=delete&id=<?=$value['menusetid']?>">删除</td>   
  </tr> 
<?php } ?>
 <?php } ?>
  <?php if($_GET['moblienum']) { ?>
  <tr>  
    <th scope="row" abbr="model" class="spec"></th>  
    <td></td>   
    <td>总计:<?=$list['money']?></td>  
  </tr> 
  <?php } else { ?>
   <?php if($_GET['id']=='mianfei') { ?> 
  <tr>  
    <th scope="row" abbr="model" class="spec"></th>  
    <td></td>
    <td></td>    
    <td>总计:1000</td>  
  </tr>
  <?php } ?>  
  <?php if($_GET['id']=='putong') { ?>
  <tr>  
    <th scope="row" abbr="model" class="spec"></th>  
    <td></td>
    <td></td>    
    <td>总计:4800</td>  
  </tr> 
  <?php } ?> 
  <?php if($_GET['id']=='gaoji') { ?> 
  <tr>  
    <th scope="row" abbr="model" class="spec"></th>  
    <td></td>
    <td></td>    
    <td>总计:9800</td>  
  </tr>
  <?php } ?>  
   <?php } ?> 

    <tr>  
    <th scope="row" abbr="model" class="spec"></th>  
    <td>  
    <?php if($_GET['moblienum']) { ?>
<form name="alipayment" action="./payphp/mobliealipayapi.php" method=post target="_blank">
<input type="hidden" name="WIDseller_email" value="huangjb@koalac.com" />
<input type="hidden" name="WIDout_trade_no" value="<?=$number?>.<?=$zfbuid?>" />
<input type="hidden" name="WIDsubject" value="微伍手机模版" />
<input type="hidden" name="WIDtotal_fee" value="<?=$list['money']?>" />
<input type="hidden" name="WIDbody" value="欢迎选购微伍手机模版" />
<input type="hidden" name="WIDshow_url" value="欢迎选购微伍手机模版" />
    <?php } else { ?>
<form name="alipayment" action="./payphp/alipayapi.php" method=post target="_blank">
<input type="hidden" name="WIDseller_email" value="huangjb@koalac.com" />
<input type="hidden" name="WIDout_trade_no" value="<?=$number?>.<?=$zfbuid?>" />
<input type="hidden" name="WIDsubject" value="微伍应用" />
<?php if($_GET['id']=='mianfei') { ?>
<input type="hidden" name="WIDtotal_fee" value="1000" />
<?php } ?>
<?php if($_GET['id']=='putong') { ?>
<input type="hidden" name="WIDtotal_fee" value="4800" />
<?php } ?>
<?php if($_GET['id']=='gaoji') { ?>
<input type="hidden" name="WIDtotal_fee" value="9800" />
 <?php } ?>
<input type="hidden" name="WIDbody" value="欢迎选购微伍应用" />
<input type="hidden" name="WIDshow_url" value="欢迎选购微伍应用" />
 <?php } ?> 
<input type="submit" class="btn grid_2" value="购买"  name="buy">

</form>
</td>
    <td>
    <form action = "space.php?do=showmenuset" method = "post">
<input type="submit" class="btn grid_2" value="暂不购买"  name="cancel">
</form>
</td> 
    <?php if(!$_GET['moblienum']) { ?>   
    <td></td>  
     <?php } ?> 
  </tr> 
  </table>  


 <?php } else { ?>
没有需要购买的应用或手机模版
<?php } ?>

<br/>
<?php if($_GET['id']=='mianfei') { ?>
  <div class="setItem" id="setItem1"><br/><br/>
      <img src="./template/default/image/img/title_set01.png" alt="" class="setItem-titlePic" />
      <div class="setContent" id="set1">
        <img src="./template/default/image/img/mid_pic_01.png" alt="" class="setContent-pic" />
        <dl class="setContent-text">
          <dt class="fb">一经注册开通，免费套餐任你玩</dt>
          <dd><img src="./template/default/image/img/list_point.png" alt="" /><span class="fb">企业介绍，</span>详尽企业介绍，品牌强势进驻公众平台。</dd>
          <dd><img src="./template/default/image/img/list_point.png" alt="" /><span class="fb">企业动态，</span>动态实时更新，劲爆猛料火线速递。</dd>
          <dd><img src="./template/default/image/img/list_point.png" alt="" /><span class="fb">产品介绍，</span>完美图文展示，优质产品吸引更多关注。</dd>
          <dd><img src="./template/default/image/img/list_point.png" alt="" /><span class="fb">企业官网，</span>手机品牌官网，行业先驱非您莫属。</dd>
        </dl>
      </div>
     
     <br/>
    </div> <!-- setItem --> 
 <?php } ?>
<?php if($_GET['id']=='putong') { ?>
  <div class="setItem" id="setItem2">
      <img src="./template/default/image/img/title_set02.png" alt="" class="setItem-titlePic" />
      <div class="setContent" id="set2">
        <img src="./template/default/image/img/mid_pic_02.png" alt="" class="setContent-pic" />
        <dl class="setContent-text">
          <dt class="fb">完美补充传统官网，企业在移动互联网轻松获得更多口碑</dt>
          <dd><img src="./template/default/image/img/list_point.png" alt="" /><span class="fb">企业介绍，</span>详尽企业介绍，品牌强势进驻公众平台。</dd>
          <dd><img src="./template/default/image/img/list_point.png" alt="" /><span class="fb">企业动态，</span>动态实时更新，劲爆猛料火线速递。</dd>
          <dd><img src="./template/default/image/img/list_point.png" alt="" /><span class="fb">产品介绍，</span>完美图文展示，优质产品吸引更多关注。</dd>
          <dd><img src="./template/default/image/img/list_point.png" alt="" /><span class="fb">行业动态，</span>把握行业脉搏，与客户分享最具行业价值信息。</dd>
          <dd><img src="./template/default/image/img/list_point.png" alt="" /><span class="fb">成功案例，</span>成功是时间的积累，您的实力谁能置疑？</dd>
          <dd><img src="./template/default/image/img/list_point.png" alt="" /><span class="fb">分支机构，</span>罗列所有驻点，客户总能找到身边的您。</dd>
          <dd><img src="./template/default/image/img/list_point.png" alt="" /><span class="fb">人才招聘，</span>网罗微信时代人才，轻松开展微招聘。</dd>
          <dd><img src="./template/default/image/img/list_point.png" alt="" /><span class="fb">企业官网，</span>海量手机官网模板，改版升级轻松设置。</dd>
        </dl>
      </div>
     
     <br/>
    </div> <!-- setItem --> 
 <?php } ?>
 <?php if($_GET['id']=='gaoji') { ?>
   <div class="setItem"  id="setItem3">
      <img src="./template/default/image/img/title_set03.png" alt="" class="setItem-titlePic" />
      <div class="setContent" id="set3">
        <img src="./template/default/image/img/mid_pic_03.png" alt="" class="setContent-pic" />
        <dl class="setContent-text">
          <dt class="fb">摇身一变，微信app轻松获得，更低的推广成本，更高的经济效益。
                    </dt>
          <dd><img src="./template/default/image/img/list_point.png" alt="" /><span class="fb">自定义菜单，</span>微信内置app折叠菜单，更直观，更方便。</dd>
          <dd><img src="./template/default/image/img/list_point.png" alt="" /><span class="fb">微信商城，</span>开设微信商城，马上启程新渠道电商之路。</dd>
          <dd><img src="./template/default/image/img/list_point.png" alt="" /><span class="fb">焦点推荐，</span>设置醒目焦点内容推荐，锁住客户关注。</dd>
          <dd><img src="./template/default/image/img/list_point.png" alt="" /><span class="fb">微信呼叫中心，</span>多层级客服响应处理，客户一呼百应。</dd>
          <dd><img src="./template/default/image/img/list_point.png" alt="" /><span class="fb">客户管理中心，</span>沉淀转化优质客户，定点精准开展二次营销。</dd>
        </dl>
      </div>
    </div> <!-- setItem --> 
     
     <br/>
    </div> <!-- setItem --> 
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