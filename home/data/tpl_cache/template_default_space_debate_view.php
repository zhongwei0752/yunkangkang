<?php if(!defined('IN_UCHOME')) exit('Access Denied');?><?php subtplcheck('template/default/space_debate_view|template/default/header|template/default/space_menu|template/default/space_debateobcomment_li|template/default/space_debaterecomment_li|template/default/footer', '1386055724', 'template/default/space_debate_view');?><?php $_TPL['titles'] = array($debate['loupan'],$debate['subject'], '大擂台'); ?>
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
<script type="text/javascript" charset="<?=$_SC['charset']?>" src="source/script_calendar.js"></script>
<div  style="padding:0 0 10px;">
            <div class="content" style="font-size:15px;">
            	<div class="indexing" style="margin-bottom:15px;">
                  <span><a href="space.php?do=home">首页</a></span>><span><a href="space.php?do=debate">大擂台</a></span>
                 </div>
     <div class="bread container_12">
        <div class="bread_actived grid_1">
        	查看辩论
        </div>
    </div>
<?php } else { ?>
<?php $_TPL['spacetitle'] = "辩论";
	$_TPL['spacemenus'][] = "<a href=\"space.php?uid=$space[uid]&do=$do&view=me\">查看全部辩论</a>"; ?>
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
<style type="text/css">
/*其他主题类型样式*/
.r_one{color:#555;}
.s8,.s8 a,.s8 a:hover{color:#1bb9ea;}
.s7,.s7 a{color:#ff00a2;}
.s1{color:#008000;} /*绿色*/
.s3{color:#ff6600;} /*橙色*/
.s9{line-height:25px;padding:0 .8em;}
.dig2{height:25px;line-height:25px;display: inline-block;font-size:12px;background:#ffffee;width:80px;cursor: pointer;margin:.5em 0;color:#666;border:1px solid #ffd0a8;}
.dig2:hover{text-decoration:none;border:1px solid #f5a25c;color:#ff6600;}
.gogo{height:35px;line-height:30px;color:#777; text-align:center}
.tab2{background:#e4e4e4;margin-top:4px;height:100px;}
.tab2 .one{background:url(image/tab-one.gif) left center repeat-y;width:50px;}
.tab2 .two{background:url(image/tab-two.gif) left center repeat-y;width:50px;}

.dig3{border:1px solid #ee6821;margin:.5em 2em}
.dig3 span{background:#ee6821;color:#fff;height:25px;line-height:25px;padding:0 .5em;}
.dig3 div{cursor:pointer;height:25px;line-height:25px;padding:0 .5em;background:#fff;}
.dig4{border:1px solid #23bceb;margin:.5em 2em}
.dig4 span{background:#23bceb;color:#fff;height:25px;line-height:25px;padding:0 .5em;}
.dig4 div{cursor:pointer;height:25px;line-height:25px;padding:0 .5em;background:#fff;}
.dig5{background:#ffffee;height:25px;line-height:25px;border:1px solid #f5a25c;color:#ff6600;width:80px;margin:.5em 2em;}

.vote{margin:10px auto;background:<?=$bgcolor?>;width:90%;padding:5px 8px;border:1px solid #f9f9f9;line-height:22px;}

.vs-new{background:url(image/vs-new.png) no-repeat;width:110px;height:110px;}
.vs-old{background:url(image/vs-old.png) no-repeat;width:110px;height:110px;}
/*伪类按钮*/
.bta{cursor:pointer;color:#333333;padding:2px 8px;background:#f9f9f9;margin:2px;white-space:nowrap;border:1px solid #dbe4e9;}
</style>
                 <div class="content_detail_wrapper">
                      <div class="content_page_detail">
                           <div class="content_title"><?=$debate['subject']?></div>
                           <div class="content_text_detail" style="text-align: center;margin-bottom:10px;margin-top:10px;font-size:12px;">作者 : <?=$debate['umpire']?>&nbsp;|&nbsp;发布时间 : <?php echo sgmdate('Y-m-d H:i:s',$debate[dateline]); ?></div>
                           <div class="content_text_detail"style="overflow:hidden">
                               <p><?=$debate['message']?></p>
                           </div>
   	<div style="margin:auto;width:700px;padding-top:30px; background-color: white;">
<div class="gogo tac">
<?php if($debate['judge']) { ?>
此辩论已结束，裁判 <b><a href="space.php?username=<?=$debate['umpire']?>" style="color:#1DB8AE;"><?=$debate['umpire']?></a></b> 宣布：
<?php if($debate['judge']==1) { ?>
<b class="s3" style="color:#1DB8AE;">正方胜</b>
<?php } elseif($debate['judge']==3) { ?>
<b class="s8" style="color:#1DB8AE;">反方胜</b>
<?php } else { ?>
<b class="s1" style="color:#1DB8AE;">平局</b>
<?php } ?>
，最佳辩手：<a href="space.php?username=<?=$debate['debater']?>" target="_blank"><b class="s7"><?=$debate['debater']?></b></a>
<?php } elseif($debate['endtime'] < $_SGLOBAL['timestamp'] ) { ?>
此辩论已结束，等待裁判宣布辩论结果。。。
<?php } else { ?>

辩论结束时间 <b><?php echo sgmdate('Y-m-d H:i',$debate[endtime]); ?></b> -- 裁判：<b><a href="space.php?username=<?=$debate['umpire']?>" style="color:#1DB8AE;"><?=$debate['umpire']?></a></b>
<?php } ?>
<?php if($_SGLOBAL['supe_username']==$debate['umpire'] ) { ?>
<a href="cp.php?ac=debate&debateid=<?=$debate['debateid']?>&op=judgedebate" id="debate_judge_<?=$debate['debateid']?>" onclick="ajaxmenu(event, this.id)" class="dig2" style="color:white; background-color:#1DB8AE; ">裁判点评</a>
<?php } ?>
<?php if($debate['obvote'] || $debate['revote']) { ?>
<?php $tmpVotes = $debate[revote]+$debate[obvote] ?>
<?php $tmpob = round($debate[obvote]/$tmpVotes,2)*100; ?>
<?php $tmpre = round($debate[revote]/$tmpVotes,2)*100; ?>
<?php } ?>
</div>
<table border="0" cellspacing="0" cellpadding="0" width="100%;" style="padding-top:5px;">
<tr><td width="40%">
<table border="0" cellspacing="0" cellpadding="0" width="100%;">
<tr>
<td style="width:100px;" class="tac">
<center>
<div>- <b><span id="obvote" class="s3"><?=$debate['obvote']?></span></b> 票 -</div>
<table class="tab2" border="0" cellspacing="0" cellpadding="0" width="50">
<tr><td id="obimgre" class="no" height="<?=$tmpre?>%"></td></tr>
<tr><td id="obimgob" class="one tac" height="<?=$tmpob?>%"></td></tr>
</table>
<div class="c"></div>
<a href="cp.php?ac=debate&debateid=<?=$debate['debateid']?>&op=opvote" id="debate_opvote_<?=$debate['debateid']?>" onclick="ajaxmenu(event, this.id)" class="dig2" style="color:white; background-color:#1DB8AE; ">支持正方</a> </center>
</td><td valign="top">
<div class="vote">
<span class="s8">正方观点：</span><br /> <?=$debate['obtitle']?>
</div>
<span class="gray" style="margin-left:1em;">辩手：<?=$obvotenum?> 人</span>
</td></tr>
</table>
</td>
<td width="10%">
<?php if($debate['judge'] ) { ?>
<div class="vs-old"></div>
<?php } else { ?>
<div class="vs-new"></div>
<?php } ?>
</td>
<td width="40%">
<table border="0" cellspacing="0" cellpadding="0" width="100%;" >
<tr>
<td valign="top">
<div class="vote">
<span class="s8">反方观点：</span><br /> <?=$debate['retitle']?>
</div>
<span class="gray" style="margin-left:1em;">辩手：<?=$revotenum?> 人</span>
</td>
<td style="width:100px;" class="tac">
<center>
<div>- <b><span id="revote" class="s8"><?=$debate['revote']?></span></b> 票 -</div>
<table class="tab2" border="0" cellspacing="0" cellpadding="0" width="50">
<tr><td id="reimgob" class="no" height="<?=$tmpob?>%"></td></tr>
<tr><td id="reimgre" class="two tac" height="<?=$tmpre?>%"></td></tr>
</table>
<div class="c"></div>
<a href="cp.php?ac=debate&debateid=<?=$debate['debateid']?>&op=revote" id="debate_revote_<?=$debate['debateid']?>" onclick="ajaxmenu(event, this.id)" class="dig2" style="color:white; background-color:#1DB8AE; ">支持反方</a>
 </center>
</td></tr>
</table>
</td>
</tr>
</table>
<?php if($debate['judge'] && $debate['umpirepoint'] ) { ?>
<div class="vote"><span class="s1" style="color:#1DB8AE;">裁判点评 ：</span><?=$debate['umpirepoint']?></div>
<?php } ?>

</div>
<div class="feed_action">
  	<ul>
        <li>阅览（<?=$debate['viewnum']?>）</li>
        <?php if($debate['replynum']) { ?><li>评论（<?=$debate['replynum']?>）</li>
        <?php } else { ?><li>评论（0）</li><?php } ?>
        <?php if($_SGLOBAL['supe_uid'] == $debate['uid'] || checkperm('managedebate')) { ?>
        <li><a href="cp.php?ac=debate&debateid=<?=$debate['debateid']?>&op=edit">修改</a></li>
        <li><a href="cp.php?ac=debate&debateid=<?=$debate['debateid']?>&op=delete" id="debate_delete_<?=$debate['debateid']?>" onclick="ajaxmenu(event, this.id)">删除</a></li>
        <?php } ?>
  	</ul>
</div>
            <div class="comments" id="div_main_content">


<?php if(!$debate['noreply']) { ?>
<form id="quickcommentform_<?=$id?>" name="quickcommentform_<?=$id?>" action="cp.php?ac=debatecomment" method="post" class="quickpost">

<table cellpadding="0" cellspacing="0">
<tr>
<td><?php if(!in_array($_SGLOBAL['supe_uid'],$obvoteuids) && !in_array($_SGLOBAL['supe_uid'],$revoteuids)) { ?><select name="debatetype"><option value="0">支持正方</option><option value="1">支持反方</option></select><br><?php } ?>
</td>
</tr>
<tr>
<td>
<input type="hidden" name="refer" value="space.php?uid=<?=$debate['uid']?>&do=<?=$do?>&id=<?=$id?>" />
<input type="hidden" name="id" value="<?=$id?>">
<input type="hidden" name="commentsubmit" value="true" />
                         <?php if(in_array($_SGLOBAL['supe_uid'],$obvoteuids)) { ?>
                        <input type="button" id="commentsubmit_btn" name="commentsubmit_btn"  value="支持正方" style="background:#1DB8AE;color:white;width:100px;height:36px;font-size:18px;" />
                        <input type="hidden" name="debatetype" value="0">
                      <?php } elseif(in_array($_SGLOBAL['supe_uid'],$revoteuids)) { ?>   
                        <input type="button" id="commentsubmit_btn" name="commentsubmit_btn" class="submit" value="支持反方" style="background:#1DB8AE;color:white;width:100px;height:36px;font-size:18px;" />  <input type="hidden" name="debatetype" value="1">
                       <?php } else { ?>
                        <?php } ?>

<div id="__quickcommentform_<?=$id?>"></div>
</td>
</tr>
<tr>
<td>
<a href="###" id="comment_face" title="插入表情" onclick="showFace(this.id, 'comment_message');return false;"><img src="image/facelist.gif" align="absmiddle" /></a>
<?php if($_SGLOBAL['magic']['doodle']) { ?>
<a id="a_magic_doodle" href="magic.php?mid=doodle&showid=comment_doodle&target=comment_message" onclick="ajaxmenu(event, this.id, 1)"><img src="image/magic/doodle.small.gif" class="magicicon" />涂鸦板</a>
<?php } ?>
<br />
<textarea id="comment_message" onkeydown="ctrlEnter(event, 'commentsubmit_btn');" name="message" rows="5" style="width:560px;height:105px;float:left;"></textarea>
<div class="comment_wrapper container_12" style="margin:0px;">
<input type="hidden" name="refer" value="space.php?uid=<?=$debate['uid']?>&do=<?=$do?>&id=<?=$id?>" />
<input type="hidden" name="id" value="<?=$id?>">
<input type="hidden" name="commentsubmit" value="true" />
                         <?php if(in_array($_SGLOBAL['supe_uid'],$obvoteuids)) { ?>
                        <input type="submit" id="commentsubmit_btn" name="commentsubmit_btn" class="submit"  onclick="validate(this);" value="发布" style="font-size:26px;width:123px;height:107px;float:left;margin-left:24px;"/>
                        <input type="hidden" name="debatetype" value="0">
                      <?php } elseif(in_array($_SGLOBAL['supe_uid'],$revoteuids)) { ?>   
                        <input type="submit" id="commentsubmit_btn" name="commentsubmit_btn" class="submit"  onclick="validate(this);" value="发布" style="font-size:26px;width:123px;height:107px;float:left;margin-left:24px;" />  
<input type="hidden" name="debatetype" value="1">
                       <?php } else { ?>
                       <input type="submit" id="commentsubmit_btn" name="commentsubmit_btn" class="submit"  onclick="validate(this);" value="发布" style="font-size:26px;width:123px;height:107px;float:left;margin-left:24px;"/>
                        <?php } ?>

<div id="__quickcommentform_<?=$id?>"></div>
</div>
</td>
</tr>
<tr>
<td>
<input type="hidden" name="refer" value="space.php?uid=<?=$debate['uid']?>&do=<?=$do?>&id=<?=$id?>" />
<input type="hidden" name="id" value="<?=$id?>">
<input type="hidden" name="idtype" value="debateid">
<input type="hidden" name="commentsubmit" value="true" />

<div id="__quickcommentform_<?=$id?>"></div>
</td>
</tr>
</table>
<input type="hidden" name="formhash" value="<?php echo formhash(); ?>" /></form>
<br />
<?php } ?>
</div>
<?php if(($debate['replynum'])) { ?>
<div style="width:100%;">
<div class="comments_list" id="comment" style="float:left;width:48%;">
<?php if($cid) { ?>
<div class="notice">
当前只显示与你操作相关的单个评论，<a href="space.php?uid=<?=$introduce['uid']?>&do=debate&id=<?=$debate['debateid']?>">点击此处查看全部评论</a>
</div>
<?php } ?>
<h3 align="center">正方辩论</h3>
<ul id="comment_ul">
<?php if(is_array($oblist)) { foreach($oblist as $value) { ?>

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
<div style="float:right;font-size:14px;padding-right:20px;">
<?php if($value['authorid']==$_SGLOBAL['supe_uid']) { ?>
<a href="cp.php?ac=debatecomment&op=obedit&cid=<?=$value['cid']?>" id="c_<?=$value['cid']?>_edit" onclick="ajaxmenu(event, this.id, 1)">编辑</a>
<?php } ?>
<?php if($value['authorid']==$_SGLOBAL['supe_uid'] || $value['uid']==$_SGLOBAL['supe_uid']) { ?>
<a href="cp.php?ac=debatecomment&op=obdelete&cid=<?=$value['cid']?>" id="c_<?=$value['cid']?>_delete" onclick="ajaxmenu(event, this.id)">删除</a>
<?php } ?>
<?php if($value['authorid']!=$_SGLOBAL['supe_uid'] && ($value['idtype'] != 'uid' || $space['self'])) { ?>
            <?php if(!in_array($_SGLOBAL['supe_uid'],$revoteuids)) { ?>
<a href="cp.php?ac=debatecomment&op=obreply&cid=<?=$value['cid']?>" id="c_<?=$value['cid']?>_reply" onclick="ajaxmenu(event, this.id, 1)">回复</a>
            <?php } ?>
<?php } ?>
</div>
<span class="comment_text"><?=$value['message']?></span></h6>
        <span class="comment_time"><?php echo sgmdate('Y-m-d H:i',$value[dateline],1); ?></span>

        </div>
 </div> <br/></div>

<?php } } ?>
</ul>
<div class='pagination'><ul><?=$obmulti?></ul></div>
</div>

<div class="comments_list" id="comment" style="float:right;width:48%;">
<?php if($cid) { ?>
<div class="notice">
当前只显示与你操作相关的单个评论，<a href="space.php?uid=<?=$introduce['uid']?>&do=debate&id=<?=$debate['debateid']?>">点击此处查看全部评论</a>
</div>
<?php } ?>
<h3  align="center">反方辩论</h3>
<ul id="comment_ul">
<?php if(is_array($relist)) { foreach($relist as $value) { ?>

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
<div style="float:right;font-size:14px;padding-right:20px;">
<?php if($value['authorid']==$_SGLOBAL['supe_uid']) { ?>
<a href="cp.php?ac=debatecomment&op=obedit&cid=<?=$value['cid']?>" id="c_<?=$value['cid']?>_edit" onclick="ajaxmenu(event, this.id, 1)">编辑</a>
<?php } ?>
<?php if($value['authorid']==$_SGLOBAL['supe_uid'] || $value['uid']==$_SGLOBAL['supe_uid']) { ?>
<a href="cp.php?ac=debatecomment&op=obdelete&cid=<?=$value['cid']?>" id="c_<?=$value['cid']?>_delete" onclick="ajaxmenu(event, this.id)">删除</a>
<?php } ?>
<?php if($value['authorid']!=$_SGLOBAL['supe_uid'] && ($value['idtype'] != 'uid' || $space['self'])) { ?>
            <?php if(!in_array($_SGLOBAL['supe_uid'],$revoteuids)) { ?>
<a href="cp.php?ac=debatecomment&op=obreply&cid=<?=$value['cid']?>" id="c_<?=$value['cid']?>_reply" onclick="ajaxmenu(event, this.id, 1)">回复</a>
            <?php } ?>
<?php } ?>
</div>
<span class="comment_text"><?=$value['message']?></span></h6>
        <span class="comment_time"><?php echo sgmdate('Y-m-d H:i',$value[dateline],1); ?></span>

        </div>
 </div> <br/></div>

<?php } } ?>
</ul>
<div class='pagination'><ul><?=$remulti?></ul></div>
</div>
</div><?php } ?>
<div id="bottom"></div>




                           </div>
                      </div>
                 </div>
                 
                </div>
     
              






<script type="text/javascript">
<!--
function closeSide2(oo) {
if($('sidebar').style.display == 'none'){
$('content').style.cssText = '';
$('sidebar').style.display = 'block';
oo.innerHTML = '&raquo; 关闭侧边栏';
}
else{
$('content').style.cssText = 'margin: 0pt; width: 810px;';
$('sidebar').style.display = 'none';
oo.innerHTML = '&laquo; 打开侧边栏';
}
}
function addFriendCall(){
var el = $('friendinput');
if(!el || el.value == "")	return;
var s = '<input type="checkbox" name="fusername[]" value="'+el.value+'" id="'+el.value+'" checked>';
s += '<label for="'+el.value+'">'+el.value+'</label>';
s += '<br />';
$('friends').innerHTML += s;
el.value = '';
}
resizeImg('introduce_article','700');
resizeImg('div_main_content','450');

//彩虹炫
var elems = selector('div[class~=magicflicker]'); 
for(var i=0; i<elems.length; i++){
magicColor(elems[i]);
}

-->
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
<?php } ?>








<?php ob_out();?>