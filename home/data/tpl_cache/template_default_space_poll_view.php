<?php if(!defined('IN_UCHOME')) exit('Access Denied');?><?php subtplcheck('template/default/space_poll_view|template/default/header|template/default/space_menu|template/default/space_comment_li|template/default/footer', '1386749329', 'template/default/space_poll_view');?><?php $_TPL['titles'] = array($poll['subject'], '投票'); ?>
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


<?php if($space['self']) { ?>
<style type="text/css">
.submit:hover{background: #02B4AB;}
</style>
<div class="content" style="font-size:15px;">
          
                 <div class="indexing">
                  <span><a href="space.php?do=home">首页</a></span>><span><a href="space.php?do=poll">查看投票</a></span>
                 </div><!-- end -->
                 <div class="bread container_12">
                     <div class="bread_actived grid_1">
                         查看投票
                     </div>
                
                     
                   
</div>	
<?php } else { ?>
<?php $_TPL['spacetitle'] = "投票";
	$_TPL['spacemenus'][] = "<a href=\"space.php?uid=$space[uid]&do=$do&view=me\">TA的所有投票</a>";
	$_TPL['spacemenus'][] = "<a href=\"space.php?uid=$space[uid]&do=poll&pollid=$pollid\">查看投票详情</a>"; ?>
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

<?php } ?>
<div id="content" style="width: 762px; background: white; border: solid 1px #e3e3e3; min-height: 1000px">

<div class="poll_title" style="margin-top: 30px;">
<?php if($expiration) { ?>
<div class="print overtime">[过期]</div>
<?php } elseif($poll['percredit']) { ?>
<div class="print guerdon">[悬赏]</div>
<?php } ?>
<?php if($poll['hot']) { ?><span class="hot"><em>热</em><?=$poll['hot']?></span><?php } ?><h3 style="font-size: 20px;"><?=$poll['subject']?></h3><?php if($poll['sex'] && $poll['sex'] != $_SGLOBAL['member']['sex'] || $poll['multiple']) { ?> (<?php if($poll['sex'] && $poll['sex'] != $_SGLOBAL['member']['sex']) { ?>仅限<strong><?php if($poll['sex']==1) { ?>男<?php } else { ?>女<?php } ?></strong>性参与 <?php } ?><?php if($poll['multiple']) { ?>最多可选<?=$poll['maxchoice']?>项<?php } ?>) <?php } ?>
<?php if($_GET['reward']) { ?>
<p style="color: #F30">恭喜您获得  <strong><?=$_GET['reward']?></strong> 个积分</p>
<?php } elseif($poll['percredit']) { ?>
<p style="color: #F30">投票将获得 <strong><?=$poll['percredit']?></strong> 个积分</p>
<?php } ?>
</div>
<div class="content_text_detail" style="text-align: center;margin-bottom:10px;margin-top:15px;font-size:12px;">作者 : <?=$_SN[$poll['uid']]?>&nbsp;|&nbsp;发布时间 : <?php echo sgmdate('Y-m-d H:i:s',$poll[dateline]); ?></div>
                           
<?php if($poll['message']) { ?><p class="poll_depiction" style="line-height:23px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=$poll['message']?></p><?php } ?>
<div class="content_text_detail" style="max-width: 710px;diplay:block;margin:0 auto;">
<img src="<?=$poll['imageurl']?>" style="width:600px;height:420px;"/>
    </div>

<form name="poll" method="post" action="cp.php?ac=poll&pollid=<?=$poll['pollid']?>&op=vote">

<ol class="poll_item_list">
<?php $bcid = rand(0, 19); ?>
<?php if(is_array($option)) { foreach($option as $key => $val) { ?>
<li>
<label class="poll_item" style="width: 250px;margin-left: 10px;"><?=$val['option']?>:</label>
<?php if($bcid>19) { ?>
<?php $bcid=$bcid-19 ?>
<?php } ?>
<div class="bar_bg bc_<?=$bcid?>">
<div class="bar_left"></div>
<div class="bar_middle" id="bar_<?=$key?>" len="<?=$val['width']?>"></div>
<div class="bar_right"></div>
</div>
<?php $bcid++; ?>
<div class="poll_percent" style="width: 80px;"><?=$val['votenum']?> (<?=$val['percent']?>%)</div>
<div class="floatleft">
<?php if($allowedvote && !$hasvoted) { ?>
<input type="<?php if($poll['multiple']) { ?>checkbox<?php } else { ?>radio<?php } ?>" name="option[]" value="<?=$val['oid']?>" <?php if($poll['multiple']) { ?>onclick="checkSelect(this.checked)"<?php } ?>/>
<?php } ?>
</div>
</li>
<?php } } ?>
</ol>
<div class="poll_submit">
<?php if($allowedvote && !$hasvoted) { ?>
<input type="hidden" name="votesubmit" value="true" />
<input type="submit"  class="btn" id="votebutton" name="votebutton" value="投票" style="width: 94px; height: 32px; font-size: 12px; margin: 0; border: 0; padding: 0;font-size: 20px;float: right; margin-right: 200px;"/><br />
<input type="hidden" name="formhash" value="<?php echo formhash(); ?>" />
<?php } ?>
</div>

</form>

<?php if($poll['summary']) { ?>
<div class="poll_summary">
<h3 class="poll_sumuptitle"><?=$_SN[$poll['uid']]?>对该投票的总结</h3>
<p class="poll_sumup"><?=$poll['summary']?></p>
</div>
<?php } ?>

<div id="showvoter"></div>
<script type="text/javascript">
<?php if(!$hasvoted) { ?>
var maxSelect = <?=$poll['maxchoice']?>;
var alreadySelect = 0;
function checkSelect(sel) {
if(sel) {
alreadySelect++;
if(alreadySelect == maxSelect) {
var oObj = document.getElementsByName("option[]");
for(i=0; i < oObj.length; i++) {
if(!oObj[i].checked) {
oObj[i].disabled = true;
}
}
}
} else {
alreadySelect--;
if(alreadySelect < maxSelect) {
var oObj = document.getElementsByName("option[]");
for(i=0; i < oObj.length; i++) {
if(oObj[i].disabled) {
oObj[i].disabled = false;
}
}
}
}
}
<?php } ?>




//效查
var optionNum = <?php echo count($option) ?>;
var maxLength = [0,1, 2, 3, 4, 5, 6, 7, 8, 9, 10,11,12,13,14,15,16,17,18,19];

var timer;
var length = 0;
for(i = 0; i < optionNum; i++) {
maxLength[i] = $("bar_" + i).getAttribute('len');
}
timer = setInterval(function(){
setLength();
}, 40);
function setLength(){
for (i = 0; i < optionNum; i++) {
if (length - 1 >= maxLength[i]) {
$('bar_' + i).style.width = maxLength[i] + "px";
} else {
$('bar_' + i).style.width = length + "px";
}
length = length + 1;
if (length > 300) {
clearInterval(timer);
}
}
}
function showVoter(filtrate) {
$('newvoter').className = '';
$('wevoter').className = '';
$(filtrate+'voter').className = 'active';
ajaxget('cp.php?ac=poll&op=get&pollid=<?=$poll['pollid']?>&filtrate='+filtrate, 'showvoter');
}
showVoter('new')
</script>
<div class="comments" id="div_main_content" style="padding: 0 0 20px;">
<div class="r_option" style="margin-right: 30px; font-size: 14px;"><a href="cp.php?ac=poll&pollid=<?=$poll['pollid']?>&op=delete" id="poll_delete_<?=$poll['pollid']?>" onclick="ajaxmenu(event, this.id)">删除</a></div>
<div class="r_option" style="margin-right: 30px; font-size: 14px;"><a href="cp.php?ac=poll&pollid=<?=$poll['pollid']?>&op=modify" id="poll_modify_<?=$poll['pollid']?>" onclick="ajaxmenu(event, this.id)">修改时间</a></div>
<div class="r_option" style="margin-right: 30px; font-size: 14px;">评论&nbsp;(&nbsp;<span id="comment_replynum"><?=$poll['replynum']?></span>&nbsp;)&nbsp; </div>

<div class="comments" id="div_main_content">
<form id="quickcommentform_<?=$id?>" name="quickcommentform_<?=$id?>" action="cp.php?ac=pollcomment" method="post" class="quickpost">
<table cellpadding="0" cellspacing="0">
<tr>
<td>
<a href="###" id="comment_face" title="插入表情" onclick="showFace(this.id, 'comment_message');return false;"><img src="image/facelist.gif" align="absmiddle" /></a>
<?php if($_SGLOBAL['magic']['doodle']) { ?>
<a id="a_magic_doodle" href="magic.php?mid=doodle&showid=comment_doodle&target=comment_message" onclick="ajaxmenu(event, this.id, 1)"><img src="image/magic/doodle.small.gif" class="magicicon" />涂鸦板</a>
<?php } ?>
<br />
<textarea id="comment_message" onkeydown="ctrlEnter(event, 'commentsubmit_btn');" name="message" rows="5" style="width:560px;height:105px;float:left;"></textarea>
<div class="comment_wrapper container_12" style="margin:0px;">
<input type="hidden" name="refer" value="space.php?uid=<?=$poll['uid']?>&do=<?=$do?>&id=<?=$id?>" />
<input type="hidden" name="commentsubmit" value="true" />
<input type="hidden" id="id" name="id" value="<?=$_GET['pollid']?>" />
<input type="hidden" id="uid" name="uid" value="<?=$_COOKIE['uchome_viewuid']?>" />
<input type="hidden" id="dateline" name="dateline" value="<?=$_SGLOBAL['timestamp']?>" />
                        <input type="submit" id="commentsubmit_btn" name="commentsubmit_btn" class="submit"  onclick="validate(this);" value="发布" style="font-size:26px;width:123px;height:107px;float:left;margin-left:24px;"/>

<div id="__quickcommentform_<?=$id?>"></div>
</div>
</td>
</tr>
<tr>
<td>
<input type="hidden" name="refer" value="space.php?uid=<?=$poll['uid']?>&do=<?=$do?>&id=<?=$id?>" />
<input type="hidden" name="id" value="<?=$_GET['pollid']?>">
<input type="hidden" id="dateline" name="dateline" value="<?=$_SGLOBAL['timestamp']?>" />
<input type="hidden" id="uid" name="uid" value="<?=$_GET['uid']?>" />
<input type="hidden" name="author" value="<?=$_SGLOBAL['supe_username']?>" />
<input type="hidden" name="idtype" value="pollid">
<input type="hidden" name="commentsubmit" value="true" />

<div id="__quickcommentform_<?=$id?>"></div>
</td>
</tr>
</table>
<input type="hidden" name="formhash" value="<?php echo formhash(); ?>" /></form>
<br />
</div>
<div class="comments_list" id="comment" style="margin-left: 20px;margin-right: 20px;">
<?php if($cid) { ?>
<div class="notice">
当前只显示与你操作相关的单个评论，<a href="space.php?uid=<?=$poll['uid']?>&do=poll&pollid=<?=$poll['pollid']?>">点击此处查看全部评论</a>
</div>
<?php } ?>
<?php if(is_array($list)) { foreach($list as $value) { ?>
<div style="border-bottom:1px dashed #999;margin-top:10px;">
<div class="comment_list container_12" style="margin-left:60px;">
<?php if($value['author']) { ?>
<div class="avatar48"><a href="space.php?uid=<?=$value['authorid']?>"><?php echo avatar($value[authorid],small); ?></a></div>
<?php } else { ?>
 <img src="image/magic/hidden.gif" class="grid_1">
<?php } ?>
     <div class="grid_2">
                                      <h6><span class="commenter">
                                      	<?php if($value['author']) { ?>
<a href="space.php?uid=<?=$value['authorid']?>" id="author_<?=$value['cid']?>"  style="color:#02B4AB;"><?=$_SN[$value['authorid']]?></a> 
<?php } else { ?>
匿名
<?php } ?>:</span>
<span class="comment_text"><?=$value['message']?></span></h6>
        <span class="comment_time"><?php echo sgmdate('Y-m-d H:i',$value[dateline],1); ?></span>
        </div>
 </div> <br/></div>


<?php } } ?>
</ul>
</div>
</div>

</div>


<script type="text/javascript">
//发表评论
$(document).ready(function () {
$("#submit1").click(function () {
if($('#comment_message').val()=="")
{
alert("评论为空，请填好信息再提交！");
}
else {
$.ajax({
type: "POST",
url: "source/function_poll.php",
data: "uid="+$('#uid').val()+" &viewuid="+$('#viewuid').val()+" &moblieclicknum="+$('#moblieclicknum').val()+"&pollid="+$('#id').val()+"&comment_message="+$('#comment_message').val()+"&dateline="+$('#dateline').val()+"&yan=1",//提交表单，相当于CheckCorpID.ashx?ID=XXX
async: true,
success: function (data) {
$('#submit1').val("发表成功");
$('#comment').before(data);
} //操作成功后的操作！msg是后台传过来的值
});
}
});
});
//彩虹炫
var elems = selector('div[class~=magicflicker]'); 
for(var i=0; i<elems.length; i++){
magicColor(elems[i]);
}
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