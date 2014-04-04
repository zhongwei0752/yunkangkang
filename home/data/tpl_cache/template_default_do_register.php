<?php if(!defined('IN_UCHOME')) exit('Access Denied');?><?php subtplcheck('template/default/do_register|template/default/header|template/default/footer', '1387358061', 'template/default/do_register');?><?php $_TPL['nosidebar']=1; ?>
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


<script>
function register(id, result) {
if(result) {
$('registersubmit').disabled = true;
window.location.href = "<?=$jumpurl?>";
} else {
updateseccode();
}
}
</script>

<form id="registerform" name="registerform" action="do.php?ac=<?=$_SCONFIG['register_action']?>&<?=$url_plus?>&ref" method="post" class="c_form">
<table cellpadding="0" cellspacing="0" class="formtable">
<caption>
<h2>注册本站帐号</h2>
<p>请完整填写以下信息进行注册。<br>注册完成后，该帐号将作为您在本站的通行帐号，您可以享受本站提供的各种服务。</p>
</caption>
<?php if($invitearr) { ?>
<tr>
<th width="100">好友邀请</th>
<td>
<a href="space.php?<?=$url_plus?>" target="_blank"><?php echo avatar($invitearr[uid],small); ?></a>
<a href="space.php?<?=$url_plus?>" target="_blank"><?=$_SN[$invitearr['uid']]?></a>
</td>
</tr>
<?php } ?>



<tr><th width="100">用户名</th><td><input type="text" id="username" name="username" value="" class="t_input" onBlur="checkUserName()" tabindex="2" />&nbsp;<span id="checkusername">&nbsp;</span></td></tr>
<tr>
<th>注册密码</th>
<td>
<input type="password" name="password" id="password" value="" class="t_input" onBlur="checkPassword()" onkeyup="checkPwd(this.value);" tabindex="3" />&nbsp;<span id="checkpassword">&nbsp;</span><br/>
<style>
.psdiv0,.psdiv1,.psdiv2,.psdiv3,.psdiv4{position:relative;height:30px;color:#666}/*密码强度容器*/
.strongdepict{position:absolute; width:300px;left:0px;top:3px}/*密码强度固定文字*/
.strongbg{position:absolute;left:0px;top:22px;width:235px!important;width:234px;height:10px;background-color:#E0E0E0; font-size:0px;line-height:0px}/*灰色强度背景*/
.strong{float:left;font-size:0px;line-height:0px;height:10px}/*色块背景*/

.psdiv0 span{display:none}
.psdiv1 span{display:inline;color:#F00}
.psdiv2 span{display:inline;color:#C48002}
.psdiv3 span{display:inline;color:#2CA4DE}
.psdiv4 span{display:inline;color:#063}

.psdiv0 .strong{ width:0px}
.psdiv1 .strong{ width:25%;background-color:#F00}
.psdiv2 .strong{ width:50%;background-color:#F90}
.psdiv3 .strong{ width:75%;background-color:#2CA4DE}
.psdiv4 .strong{ width:100%;background-color:#063}
</style>
<div class="psdiv0" id="chkpswd">
<div class="strongdepict">密码安全程度：<span id="chkpswdcnt">太短</span></div>
<div class="strongbg">
<div class="strong"></div>			
</div>		
</div>
</td>
</tr>
<tr><th>再次输入密码</th><td><input type="password" id="password2" name="password2" value="" class="t_input"  onBlur="checkPassword2()" tabindex="4" />&nbsp;<span id="checkpassword2">&nbsp;</span></td></tr>
<tr><th>邮箱</th><td><input type="text" id="email" name="email" value="@" class="t_input" tabindex="5" />
<br>请准确填入您的邮箱，在忘记密码，或者您使用邮件通知功能时，会发送邮件到该邮箱。</td></tr>
<?php if($_SCONFIG['seccode_register']) { ?>
<?php if($_SCONFIG['questionmode']) { ?>
<tr>
<th style="vertical-align: top;">请先回答问题</th>
<td>
<p><?php question(); ?></p>
<input type="text" id="seccode" name="seccode" value="" class="t_input" onBlur="checkSeccode()" tabindex="1" autocomplete="off" />&nbsp;<span id="checkseccode">&nbsp;</span>
</td>
</tr>
<?php } else { ?>
<tr>
<th style="vertical-align: top;">验证码</th>
<td>
<script>seccode();</script>
<p>请输入上面的4位字母或数字，看不清可<a href="javascript:updateseccode()">更换一张</a></p>
<input type="text" id="seccode" name="seccode" value="" class="t_input" onBlur="checkSeccode()" tabindex="1" autocomplete="off" />&nbsp;<span id="checkseccode">&nbsp;</span>
</td>
</tr>
<?php } ?>
<?php } ?>

<?php if($register_rule) { ?>
<tr><th>服务条款</th>
<td><div name="rule" style="border:1px solid #C3C3C3;width:500px;height:100px;overflow:auto;padding:5px;"><?=$register_rule?></div>
<input type="checkbox" name="accede" id="accede" value="1">我已阅读，并同意以上服务条款
<script type="text/javascript">
function checkClause() {
if($('accede').checked) {
return true;
} else {
alert("您必须同意服务条款后才能注册");
return false;
}
}
</script>
</td>
</tr>
<?php } ?>

<tr><th>&nbsp;</th>
<td>
<input type="hidden" name="refer" value="space.php?do=home" />
<input type="submit" id="registersubmit" name="registersubmit" value="注册新用户" class="submit" onclick="<?php if($register_rule) { ?>if(!checkClause()){return false;}<?php } ?>ajaxpost('registerform', 'register');" tabindex="6" />
</td>
</tr>
<tr><th>&nbsp;</th><td id="__registerform" style="color:red; font-weight:bold;"></td></tr>
</table>
<input type="hidden" name="formhash" value="<?php echo formhash(); ?>" /></form>

<script type="text/javascript">
<!--
$('username').focus();
var lastUserName = lastPassword = lastEmail = lastSecCode = '';
function checkUserName() {
var userName = $('username').value;
if(userName == lastUserName) {
return;
} else {
lastUserName = userName;
}
var cu = $('checkusername');
var unLen = userName.replace(/[^\x00-\xff]/g, "**").length;

if(unLen < 3 || unLen > 150) {
warning(cu, unLen < 3 ? '用户名小于3个字符' : '用户名超过 15 个字符');
return;
}
ajaxresponse('checkusername', 'op=checkusername&username=' + (is_ie && document.charset == 'utf-8' ? encodeURIComponent(userName) : userName));
}
function checkPassword(confirm) {
var password = $('password').value;
if(!confirm && password == lastPassword) {
return;
} else {
lastPassword = password;
}
var cp = $('checkpassword');
if(password == '' || /[\'\"\\]/.test(password)) {
warning(cp, '密码空或包含非法字符');
return false;
} else {
cp.style.display = '';
cp.innerHTML = '<img src="image/check_right.gif" width="13" height="13">';
if(!confirm) {
checkPassword2(true);
}
return true;
}
}
function checkPassword2(confirm) {
var password = $('password').value;
var password2 = $('password2').value;
var cp2 = $('checkpassword2');
if(password2 != '') {
checkPassword(true);
}
if(password == '' || (confirm && password2 == '')) {
cp2.style.display = 'none';
return;
}
if(password != password2) {
warning(cp2, '两次输入的密码不一致');
} else {
cp2.style.display = '';
cp2.innerHTML = '<img src="image/check_right.gif" width="13" height="13">';
}
}
function checkSeccode() {
var seccodeVerify = $('seccode').value;
if(seccodeVerify == lastSecCode) {
return;
} else {
lastSecCode = seccodeVerify;
}
ajaxresponse('checkseccode', 'op=checkseccode&seccode=' + (is_ie && document.charset == 'utf-8' ? encodeURIComponent(seccodeVerify) : seccodeVerify));
}
function ajaxresponse(objname, data) {
var x = new Ajax('XML', objname);
x.get('do.php?ac=<?=$_SCONFIG['register_action']?>&' + data, function(s){
var obj = $(objname);
s = trim(s);
if(s.indexOf('succeed') > -1) {
obj.style.display = '';
obj.innerHTML = '<img src="image/check_right.gif" width="13" height="13">';
obj.className = "warning";
} else {
warning(obj, s);
}
});
}
function warning(obj, msg) {
if((ton = obj.id.substr(5, obj.id.length)) != 'password2') {
$(ton).select();
}
obj.style.display = '';
obj.innerHTML = '<img src="image/check_error.gif" width="13" height="13"> &nbsp; ' + msg;
obj.className = "warning";
}

function checkPwd(pwd){

if (pwd == "") {
$("chkpswd").className = "psdiv0";
$("chkpswdcnt").innerHTML = "";
} else if (pwd.length < 3) {
$("chkpswd").className = "psdiv1";
$("chkpswdcnt").innerHTML = "太短";
} else if(!isPassword(pwd) || !/^[^%&]*$/.test(pwd)) {
$("chkpswd").className = "psdiv0";
$("chkpswdcnt").innerHTML = "";
} else {
var csint = checkStrong(pwd);
switch(csint) {
case 1:
$("chkpswdcnt").innerHTML = "很弱";
$( "chkpswd" ).className = "psdiv"+(csint + 1);
break;
case 2:
$("chkpswdcnt").innerHTML = "一般";
$( "chkpswd" ).className = "psdiv"+(csint + 1);
break;
case 3:		
$("chkpswdcnt").innerHTML = "很强";
$("chkpswd").className = "psdiv"+(csint + 1);
break;
}
}
}
function isPassword(str){
if (str.length < 3) return false;
var len;
var i;
len = 0;
for (i=0;i<str.length;i++){
if (str.charCodeAt(i)>255) return false;
}
return true;
}
function charMode(iN){ 
if (iN>=48 && iN <=57) //数字 
return 1; 
if (iN>=65 && iN <=90) //大写字母 
return 2; 
if (iN>=97 && iN <=122) //小写 
return 4; 
else 
return 8; //特殊字符 
} 
//计算出当前密码当中一共有多少种模式 
function bitTotal(num){ 
modes=0; 
for (i=0;i<4;i++){ 
if (num & 1) modes++; 
num>>>=1; 
} 
return modes; 
} 

//返回密码的强度级别 
function checkStrong(pwd){ 
modes=0; 
for (i=0;i<pwd.length;i++){ 
//测试每一个字符的类别并统计一共有多少种模式. 
modes|=charMode(pwd.charCodeAt(i)); 
} 
return bitTotal(modes);
}
//-->
</script>


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