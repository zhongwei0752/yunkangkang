<?php if(!defined('IN_UCHOME')) exit('Access Denied');?><?php subtplcheck('template/default/cp_stratch|template/default/header|template/default/footer', '1386228118', 'template/default/cp_stratch');?>﻿<?php if(empty($_SGLOBAL['inajax'])) { ?>
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


<link rel="stylesheet" type="text/css" href="template/default/jquery-mobile-fluid960.min.css">
<link rel="stylesheet" type="text/css" href="template/default/style1.css">
<link rel="stylesheet" type="text/css" href="template/default/file_beauty.css">

<?php if($_GET['op'] == 'delete') { ?>

<div <?php if(!$_SGLOBAL['inajax']) { ?>class="inpage"<?php } ?>>
<form method="post" action="cp.php?ac=stratch&op=delete&stratchid=<?=$stratchid?>">
<h1>确定删除指定的活动吗？</h1>
<a href="javascript:hideMenu();" class="float_del" title="关闭">关闭</a>
<p class="btn_line">
<input type="hidden" name="refer" value="<?=$_SGLOBAL['refer']?>" />
<input type="hidden" name="deletesubmit" value="true" />
<input type="submit" name="btnsubmit" value="确定" class="submit" />
<?php if($_SGLOBAL['inajax']) { ?><input type="button" name="btnclose" value="取消" onclick="hideMenu();" class="button" /><?php } ?>
</p>
<input type="hidden" name="formhash" value="<?php echo formhash(); ?>" />
</form>
</div>

<?php } elseif($_GET['op'] == 'open') { ?>
<div class="inpage">
<form method="post" action="space.php?do=stratch">
<h1>确定要开启该活动么？</h1>
<a href="javascript:hideMenu();" class="float_del" title="关闭">关闭</a>
<p class="btn_line">
<input type="hidden" name="refer" value="<?=$_SGLOBAL['refer']?>" />
<input type="hidden" name="opensubmit" value="true" />
<input type="submit" name="btnsubmit" value="确定" class="submit" />
<input type="button" name="btnclose" value="取消" onclick="hideMenu();" class="button" />
</p>
<input type="hidden" name="formhash" value="<?php echo formhash(); ?>" />
</form>
</div>
<?php } elseif($_GET['op'] == 'close') { ?>
<div class="inpage">
<form method="post" action="cp.php?ac=stratch&op=close&stratchid=<?=$stratchid?>">
<h1>确定要关闭该活动么？</h1>
<a href="javascript:hideMenu();" class="float_del" title="关闭">关闭</a>
<p class="btn_line">
<input type="hidden" name="refer" value="<?=$_SGLOBAL['refer']?>" />
<input type="hidden" name="closesubmit" value="true" />
<input type="submit" name="btnsubmit" value="确定" class="submit" />
<?php if($_SGLOBAL['inajax']) { ?><input type="button" name="btnclose" value="取消" onclick="hideMenu();" class="button" /><?php } ?>
</p>
<input type="hidden" name="formhash" value="<?php echo formhash(); ?>" />
</form>
</div>
<?php } else { ?>

<script language="javascript" src="image/editor/editor_function.js"></script>
<script language="javascript" src="source/date.js"></script>
<script type="text/javascript">
function validate(obj) {
    var subject = $('subject');
    var chance=$('chance');
var joinsum = $('joinsum');
var winsum = $('winsum');
    if (subject) {
    	var slen = strlen(subject.value);
        if (slen < 1 || slen > 150) {
            alert("标题长度(1~150字符)不符合要求");
            subject.focus();
            return false;
        }
    }

    if (chance1) {
    	var slen = strlen(chance1.value);
        if (slen < 1 ) {
            alert("获奖概率1不可以为空");
            chance1.focus();
            return false;
        }
    }

if (chance2) {
    	var slen = strlen(chance2.value);
        if (slen < 1 ) {
            alert("获奖概率2不可以为空");
            chance2.focus();
            return false;
        }
    }

if (chance3) {
    	var slen = strlen(chance3.value);
        if (slen < 1 ) {
            alert("获奖概率3不可以为空");
            chance3.focus();
            return false;
        }
    }


    if($('seccode')) {
var code = $('seccode').value;
var x = new Ajax();
x.get('cp.php?ac=common&op=seccode&code=' + code, function(s){
s = trim(s);
if(s.indexOf('succeed') == -1) {
alert(s);
$('seccode').focus();
           		return false;
} else {
uploadEdit(obj);
return true;
}
});
    } else {
    	uploadEdit(obj);
    	return true;
    }
}
function edit_album_show(id) {
var obj = $('uchome-edit-'+id);
if(id == 'album') {
$('uchome-edit-pic').style.display = 'none';
}
if(id == 'pic') {
$('uchome-edit-album').style.display = 'none';
}
if(obj.style.display == '') {
obj.style.display = 'none';
} else {
obj.style.display = '';
}
}
</script>






<div class="content" style="font-size:15px;">
          
                 <div class="indexing">
                   <span><a href="space.php?do=home">首页</a></span>><span><a href="space.php?do=stratch">刮刮卡</a></span>><span>发起活动</span>
                 </div><!-- end -->
                 <div class="bread container_12">
                     <div class="bread_actived grid_1">
                         发起活动
                     </div>
                     <a href="space.php?do=stratch" class="link_back_bread grid_3">
                      刮刮卡
                     </a>
                 </div>

  <div class="content_detail_wrapper">
                    <div class="post_wrapper">
<form method="post" action="cp.php?ac=stratch&stratchid=<?=$stratch['stratchid']?>"  enctype="multipart/form-data" >
<table cellspacing="4" cellpadding="4" width="100%" class="infotable">
<tr>
<td>
<div class="post_list container_12">
                         <span class="select_title grid_1">活动主题&nbsp;&nbsp;:&nbsp;&nbsp;</span>
                         <input type="text" class="text" id="subject" name="subject" value="<?=$stratch['subject']?>" size="70" placeholder="主题长度不超过60字符"/>
                    </div>
<div class="post_list container_12">
                         <span class="select_title grid_1">结束时间&nbsp;&nbsp;:&nbsp;&nbsp;</span>
                           <input name="endtime" type="text"  id="endtime" value="<?=$stratch['endtime']?>" onClick="javascript:ShowCalendar(this.id,1)" size="25" placeholder="点击获取时间"/>
                            </div>
                            <div class="post_list container_12">
                         <span class="select_title grid_1">一等奖人数&nbsp;&nbsp;:&nbsp;&nbsp;</span>
                         <input name="winsum1" type="text" id="winsum1" value="<?=$stratch['winsum1']?>" size="50" placeholder="填写获得一等奖的人数">
                            </div>
                            <div class="post_list container_12">
                         <span class="select_title grid_1">一等奖概率&nbsp;&nbsp;:&nbsp;&nbsp;</span>
                         <input name="chance1" type="text" id="chance1" value="<?=$stratch['chance1']?>" size="10" placeholder="一等奖概率">
 &nbsp;/&nbsp;<select name="fenmu">
 <option value="0">1000</option><option value="1">10000</option><option value="2">100000</option><option value="3">1000000</option><option value="4">10000000</option>
 </select>
                            </div>
                            <div class="post_list container_12">
                         <span class="select_title grid_1">一等奖奖项&nbsp;&nbsp;:&nbsp;&nbsp;</span>
                         <input name="award1" type="text" id="award1" value="<?=$stratch['award1']?>" size="50" placeholder="填写一等奖的奖项">
                            </div>
                            <div class="post_list container_12">
                         <span class="select_title grid_1">二等奖人数&nbsp;&nbsp;:&nbsp;&nbsp;</span>
                         <input name="winsum2" type="text" id="winsum2" value="<?=$stratch['winsum2']?>" size="50" placeholder="填写获得二等奖的人数">
                            </div>
                            <div class="post_list container_12">
                         <span class="select_title grid_1">二等奖概率&nbsp;&nbsp;:&nbsp;&nbsp;</span>
                         <input name="chance2" type="text" id="chance2" value="<?=$stratch['chance2']?>" size="10" placeholder="二等奖概率">
                         &nbsp;/&nbsp;<select name="fenmu1">
 <option value="0">1000</option><option value="1">10000</option><option value="2">100000</option><option value="3">1000000</option><option value="4">10000000</option>
 </select>
</div>
                            <div class="post_list container_12">
                         <span class="select_title grid_1">二等奖奖项&nbsp;&nbsp;:&nbsp;&nbsp;</span>
                         <input name="award2" type="text" id="award2" value="<?=$stratch['award2']?>" size="50" placeholder="填写二等奖的奖项">
                            </div>
                            <div class="post_list container_12">
                         <span class="select_title grid_1">三等奖人数&nbsp;&nbsp;:&nbsp;&nbsp;</span>
                         <input name="winsum3" type="text" id="winsum3" value="<?=$stratch['winsum3']?>" size="50" placeholder="填写获得三等奖的人数">
</div>
                            <div class="post_list container_12">
                         <span class="select_title grid_1">三等奖概率&nbsp;&nbsp;:&nbsp;&nbsp;</span>
                         <input name="chance3" type="text" id="chance3" value="<?=$stratch['chance3']?>" size="10" placeholder="三等奖概率">
                            &nbsp;/&nbsp;<select name="fenmu2">
 <option value="0">1000</option><option value="1">10000</option><option value="2">100000</option><option value="3">1000000</option><option value="4">10000000</option>
 </select>
 </div>
                            <div class="post_list container_12">
                         <span class="select_title grid_1">三等奖奖项&nbsp;&nbsp;:&nbsp;&nbsp;</span>
                         <input name="award3" type="text" id="award3" value="<?=$stratch['award3']?>" size="50" placeholder="填写三等奖的奖项">
                            </div>
<span style="color:red;margin-left:81px;margin-bottom:20px;">请确保概率中的分母是全部一致的，如果不是，可能会出现BUG!</span>
                            <div class="post_list container_12">
                         <span class="select_title grid_1">参与次数&nbsp;&nbsp;:&nbsp;&nbsp;</span>
                         <select name="times"><option value="1" >一次</option><!--<option value="2">每天两次</option><option value="3">每天三次</option><option value="4">每天四次</option><option value="5">每天五次</option>--></select>
                            </div>
<div class="post_list container_12">
                         <span class="select_title grid_1">设置密码&nbsp;&nbsp;:&nbsp;&nbsp;</span>
                         <input name="passwd" type="text" id="passwd" value="<?=$stratch['passwd']?>" size="50" placeholder="填写密码">
                        	</div>
</td>

</tr>
<tr>
<td>
 <div class="post_list container_12">
                         <span class="select_title grid_1">活动内容&nbsp;&nbsp;:&nbsp;&nbsp;</span>
  <textarea class="userData" name="message" id="uchome-ttHtmlEditor" style="height:100%;width:100%;display:none;border:0px"><?=$stratch['message']?></textarea>
  <iframe src="editor.php?charset=<?=$_SC['charset']?>&allowhtml=<?=$allowhtml?>&doodle=<?php if(isset($_SGLOBAL['magic']['doodle'])) { ?>1<?php } ?>" name="uchome-ifrHtmlEditor" id="uchome-ifrHtmlEditor" scrolling="no" border="0" frameborder="0" style="width:550px;height:350px;border: 1px solid #C5C5C5;" height="200"></iframe>
                            </div>
</td>
</tr>
</table>
<input type="hidden" name="stratchsubmit" value="true" />
<input type="button" id="stratchbutton" name="stratchbutton" value="提交发布" onclick="validate(this);" style="display: none;" />
<input type="hidden" name="topicid" value="<?=$_GET['topicid']?>" />
<input type="hidden" name="formhash" value="<?php echo formhash(); ?>" />
</form>
<style>
.infotable th{
padding-right: 0em;
}
</style>
<?php if(!$_SGLOBAL['inajax'] && (!$introduce['uid'] || $introduce['uid']==$_SGLOBAL['supe_uid'])) { ?>
<table cellspacing="4" cellpadding="4" width="100%" class="infotable" style="margin-left:55px;">
<tr><th width="100" style="margin-left:50px;">图片&nbsp;&nbsp;:</th><td>
<div class="pic_submit container_12">
<input type="button" class="btn grid_3" style="margin-right:-20px;" name="clickbutton[]" value="上传图片" class="button" style="float:left;" onclick="edit_album_show('pic')">

</div>
</td></tr>
</table>
<?php } ?>

<table cellspacing="4" cellpadding="4" width="100%" id="uchome-edit-pic" class="infotable" style="display:none;">
<tr>
<th width="100">&nbsp;</th>
<td>
<strong>选择图片</strong>: 
<table summary="Upload" cellspacing="2" cellpadding="0">
<tbody id="attachbodyhidden" style="display:none">
<tr>
<td>
<form method="post" id="upload" action="cp.php?ac=upload" enctype="multipart/form-data" target="uploadframe" style="background: transparent;">
<input type="file" name="attach" style="border: 1px solid #CCC;" />
<span id="localfile"></span>
<input type="hidden" name="uploadsubmit" id="uploadsubmit" value="true" />
<input type="hidden" name="albumid" id="albumid" value="0" />
<input type="hidden" name="formhash" value="<?php echo formhash(); ?>" />
</form>
</td>
</tr>
</tbody>
<tbody id="attachbody"></tbody>
</table>
<table cellspacing="2" cellpadding="0">
<tr>
<td>
<input type="hidden" name="albumid" id="uploadalbum" value="-1"/>
<font color="#02B4AB">*此上传图片将会出现在正文底部，且会出现在微信详情页面头部。</font>
<script src="source/script_upload.js" type="text/javascript"></script>
<iframe id="uploadframe" name="uploadframe" width="0" height="0" marginwidth="0" frameborder="0" src="about:blank"></iframe>
</td>
</tr>
</table>
</td>
</tr>
</table>
<table cellspacing="4" cellpadding="4" width="100%" class="infotable" id="uchome-edit-album" style="display:none;">
<tr>
<th width="100">&nbsp;</th>
<td>
选择相册: <select name="view_albumid" onchange="picView(this.value)">
<option value="none">选择一个相册</option>
<option value="0">默认相册</option>
<?php if(is_array($albums)) { foreach($albums as $value) { ?>
<option value="<?=$value['albumid']?>"><?=$value['albumname']?></option>
<?php } } ?>
</select> (点击图片可以插入到内容中)
<div id="albumpic_body"></div>
</td>
</tr>
</table>
<table cellspacing="4" cellpadding="4" width="100%" class="infotable">
<tr>
<th width="100">&nbsp;</th>
<td>
<div class="confirm_btn container_12" style="margin-left:-20px;">
                           <a href="space.php?do=home" class="cancle_btn grid_1">取消</a>
                        <input type="button" class="btn grid_2" id="stratchbutton" onclick="document.getElementById('stratchbutton').click();" value="保存发布" class="submit" />
                      </div>
</td>
</tr>
</table>
</div>
</div>

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