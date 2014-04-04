<?php if(!defined('IN_UCHOME')) exit('Access Denied');?><?php subtplcheck('template/default/cp_poll|template/default/header|template/default/cp_topic_menu|template/default/footer|template/default/space_topic_inc', '1386748986', 'template/default/cp_poll');?><?php if(empty($_SGLOBAL['inajax'])) { ?>
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


<?php if($op == 'addopt') { ?>

<h1>添加投票项</h1>
<a href="javascript:hideMenu();" class="float_del" title="关闭">关闭</a>
<div class="popupmenu_inner" id="<?=$pollid?>">
<form id="add_option_<?=$pollid?>" name="add_option_<?=$pollid?>" method="post" action="cp.php?ac=poll&op=addopt&pollid=<?=$pollid?>">
<div id="__add_option_<?=$pollid?>">
<table>
<tr>
<td>

<label for="newoption">请输入新增的投票候选项：</label><br />
<input type="text" class="t_input" id="newoption" name="newoption" value="" size="50"/>
</td>
</tr>
<tr>
<td>
<input type="hidden" name="refer" value="<?=$_SGLOBAL['refer']?>" />
<input type="hidden" name="addopt" value="true" />
<input type="submit" name="addopt_btn" id="addopt_btn" value="提交" class="submit" />
</td>
</tr>
</table>
<input type="hidden" name="formhash" value="<?php echo formhash(); ?>" />
</div>
</form>
</div>

<?php } elseif($op=='delete') { ?>

<h1>删除投票</h1>
<a href="javascript:hideMenu();" class="float_del" title="关闭">关闭</a>
<div class="popupmenu_inner">
<form method="post" action="cp.php?ac=poll&op=delete&pollid=<?=$_GET['pollid']?>">
<p>确定删除指定的投票吗？</p>
<p class="btn_line">
<input type="hidden" name="refer" value="<?=$_SGLOBAL['refer']?>" />
<input type="hidden" name="deletesubmit" value="true" />
<input type="submit" name="btnsubmit" value="确定" class="submit" />
</p>
<input type="hidden" name="formhash" value="<?php echo formhash(); ?>" />
</form>
</div>

<?php } elseif($op=='endreward') { ?>

<h1>终止悬赏</h1>
<a href="javascript:hideMenu();" class="float_del" title="关闭">关闭</a>
<div class="popupmenu_inner">
<form method="post" action="cp.php?ac=poll&op=endreward&pollid=<?=$pollid?>">
<p>终止悬赏后，剩余的积分打回您的帐户<br>确定继续吗？</p>
<p class="btn_line">
<input type="hidden" name="refer" value="<?=$_SGLOBAL['refer']?>" />
<input type="hidden" name="endrewardsubmit" value="true" />
<input type="submit" name="btnsubmit" value="确定" class="submit" />
</p>
<input type="hidden" name="formhash" value="<?php echo formhash(); ?>" />
</form>
</div>

<?php } elseif($op == 'edithot') { ?>

<h1>调整热度</h1>
<a href="javascript:hideMenu();" class="float_del" title="关闭">关闭</a>
<div class="popupmenu_inner">
<form method="post" action="cp.php?ac=poll&op=edithot&pollid=<?=$pollid?>">
<p class="btn_line">
新的热度：<input type="text" name="hot" value="<?=$poll['hot']?>" size="5"> 
<input type="hidden" name="refer" value="<?=$_SGLOBAL['refer']?>" />
<input type="hidden" name="hotsubmit" value="true" />
<input type="submit" name="btnsubmit" value="确定" class="submit" />
</p>
<input type="hidden" name="formhash" value="<?php echo formhash(); ?>" />
</form>
</div>

<?php } elseif($op == 'addreward') { ?>

<h1>追加投票悬赏</h1>
<a href="javascript:hideMenu();" class="float_del" title="关闭">关闭</a>
<div class="popupmenu_inner" id="<?=$pollid?>">
<form id="add_addreward_<?=$pollid?>" name="add_addreward_<?=$pollid?>" method="post" action="cp.php?ac=poll&op=addreward&pollid=<?=$pollid?>">
<div id="__add_addreward_<?=$pollid?>">
<table>
<tr>
<td>

<label for="addcredit">追加悬赏总额：</label>
<input type="text" class="t_input" id="addcredit" name="addcredit" value="" size="10"/> 范围：0~<?=$space['credit']?>
</td>
</tr>
<?php if($maxreward) { ?>
<tr>
<td>
<label for="addpercredit">追加每人悬赏：</label>
<input type="text" class="t_input" id="addpercredit" name="addpercredit" value="" size="10"/> 范围：0~<?=$maxreward?>
</td>
</tr>
<?php } ?>
<tr>
<td>
<input type="hidden" name="refer" value="<?=$_SGLOBAL['refer']?>" />
<input type="hidden" name="addrewardsubmit" value="true" />
<input type="submit" name="addopt_btn" id="addopt_btn" value="提交" class="submit" />
</td>
</tr>
</table>
<input type="hidden" name="formhash" value="<?php echo formhash(); ?>" />
</div>
</form>
</div>

<?php } elseif($op=='modify') { ?>


<h1>修改投票结束时间</h1>
<a href="javascript:hideMenu();" class="float_del" title="关闭">关闭</a>
<div class="popupmenu_inner" id="expiration_<?=$pollid?>">
<form id="modify_expiration_<?=$pollid?>" name="modify_expiration_<?=$pollid?>" method="post" action="cp.php?ac=poll&op=modify&pollid=<?=$pollid?>">
<table>
<tr>
<td>
<label for="expiration">请输入新的结束时间：</label><br />
<script type="text/javascript" src="source/script_calendar.js" charset="<?=$_SC['charset']?>"></script>
<input type="text" class="t_input" size="30" id="expiration" readonly name="expiration" value="<?php echo sgmdate('Y-m-d', $poll[expiration]?$poll[expiration]:$_SGLOBAL[timestamp]+2592000); ?>" onclick="showcalendar(event, this, 0, '<?php echo sgmdate('Y-m-d',$_SGLOBAL[timestamp]); ?>')" />
</td>
</tr>
<tr>
<td>
<input type="hidden" name="refer" value="<?=$_SGLOBAL['refer']?>" />
<input type="hidden" name="modifysubmit" value="true" />
<input type="hidden" name="pollid" value="<?=$_GET['pollid']?>" />
<input type="submit" name="modifysubmit_btn" id="modifysubmit_btn" value="提交" class="submit" />
</td>
</tr>
</table>
<input type="hidden" name="formhash" value="<?php echo formhash(); ?>" />
</form>
</div>

<?php } elseif($op=='summary') { ?>


<h1>投票总结</h1>
<a href="javascript:hideMenu();" class="float_del" title="关闭">关闭</a>
<div class="popupmenu_inner" id="summary_<?=$pollid?>">
<form id="edit_summary_<?=$pollid?>" name="edit_summary_<?=$pollid?>" method="post" action="cp.php?ac=poll&op=summary&pollid=<?=$pollid?>">
<table>
<tr>
<td>

<label for="message">请输入对此次投票的总结：</label>
<a href="###" id="editface_<?=$pollid?>" onclick="showFace(this.id, 'summary');return false;"><img src="image/facelist.gif" align="absmiddle" /></a>
<img src="image/zoomin.gif" onmouseover="this.style.cursor='pointer'" onclick="zoomTextarea('summary', 1)">

<img src="image/zoomout.gif" onmouseover="this.style.cursor='pointer'" onclick="zoomTextarea('summary', 0)">

<br />
<textarea id="summary" name="summary" cols="70" onkeydown="ctrlEnter(event, 'summarysubmit_btn');" rows="8"><?=$poll['summary']?></textarea></td>
</tr>
<tr>
<td>
<input type="hidden" name="refer" value="<?=$_SGLOBAL['refer']?>" />
<input type="hidden" name="summarysubmit" value="true" />
<input type="submit" name="summarysubmit_btn" id="summarysubmit_btn" value="提交" class="submit" />
</td>
</tr>
</table>
<input type="hidden" name="formhash" value="<?php echo formhash(); ?>" />
</form>
</div>

<?php } elseif($op == 'get') { ?>
<ul id="vote_list" class="voter_list">
<?php if($voteresult) { ?>
<?php if(is_array($voteresult)) { foreach($voteresult as $value) { ?>
<li>
<?php if($value['uid']==$_SGLOBAL['supe_uid']) { ?>
<img class="meicon" alt="我自己的" src="image/arrow.gif"/>
<?php } ?>
<?php if(empty($value['username'])) { ?>
匿名
<?php } else { ?>
<a href="space.php?uid=<?=$value['uid']?>"><?=$_SN[$value['uid']]?></a>
<?php } ?>
<?php echo sgmdate('Y-m-d H:i:s',$value[dateline],1); ?> 投票给 <?=$value['option']?>
</li>
<?php } } ?>
<?php } else { ?>
<li>暂时没有相关<?php if($_GET['filtrate']=='we') { ?>好友<?php } ?>投票记录</li>
<?php } ?>
</ul>
<?php if($multi) { ?><div class="page"><?=$multi?></div><br/><?php } ?>

<?php } elseif($op == 'invite') { ?>

<form id="inviteform" name="inviteform" method="post" action="cp.php?ac=poll&op=invite&pollid=<?=$poll['pollid']?>&uid=<?=$_GET['uid']?>&grade=<?=$_GET['grade']?>&group=<?=$_GET['group']?>&page=<?=$_GET['page']?>&start=<?=$_GET['start']?>">

<h2 class="title"><img src="image/app/poll.gif" />投票</h2>
<div class="tabs_header">
<ul class="tabs">
<li><a href="cp.php?ac=poll"><span>发起新投票</span></a></li>
<li class="active"><a href="cp.php?ac=poll&op=invite&pollid=<?=$poll['pollid']?>"><span>邀请好友</span></a></li>
<li><a href="space.php?uid=<?=$poll['uid']?>&do=poll&pollid=<?=$poll['pollid']?>"><span>返回投票</span></a></li>
</ul>
</div>
<div id="content" style="width: 640px;">
<div class="h_status">
您可以邀请下列好友来参与<a href="space.php?uid=<?=$poll['uid']?>&do=poll&pollid=<?=$poll['pollid']?>">《<?=$poll['subject']?>》</a>投票
</div>

<div class="h_status">
<?php if($list) { ?>
<ul class="avatar_list">
<?php if(is_array($list)) { foreach($list as $value) { ?>
<li><div class="avatar48"><a href="space.php?uid=<?=$value['fuid']?>" title="<?=$_SN[$value['fuid']]?>"><?php echo avatar($value[fuid],small); ?></a></div>
<p>
<a href="space.php?uid=<?=$value['fuid']?>" title="<?=$_SN[$value['fuid']]?>"><?=$_SN[$value['fuid']]?></a>
</p>
<p><?php if(empty($invitearr[$value['fuid']])) { ?><input type="checkbox" name="ids[]" value="<?=$value['fuid']?>">选定<?php } else { ?>已邀请<?php } ?></p>
</li>
<?php } } ?>
</ul>
<div class="page"><?=$multi?></div>
<?php } else { ?>
<div class="c_form">还没有好友。</div>
<?php } ?>
</div>
<p>
<input type="checkbox" id="chkall" name="chkall" onclick="checkAll(this.form, 'ids')">全选 &nbsp;
<input type="submit" name="invitesubmit" value="邀请" class="submit" />
</p>
</div>

<div id="sidebar" style="width: 150px;">
<div class="cat">
<h3>好友分类</h3>
<ul class="post_list line_list">
<li<?php if($_GET['group']==-1) { ?> class="current"<?php } ?>><a href="cp.php?ac=poll&pollid=<?=$poll['pollid']?>&op=invite&group=-1">全部好友</a></li>
<?php if(is_array($groups)) { foreach($groups as $key => $value) { ?>
<li<?php if($_GET['group']==$key) { ?> class="current"<?php } ?>><a href="cp.php?ac=poll&pollid=<?=$poll['pollid']?>&op=invite&group=<?=$key?>"><?=$value?></a></li>
<?php } } ?>
</ul>
</div>
</div>
<input type="hidden" name="formhash" value="<?php echo formhash(); ?>" />
</form>
<?php } else { ?>

<script language="javascript" src="image/editor/editor_function.js"></script>
<script language="javascript" src="source/script_blog.js"></script>

<?php if($topic) { ?>
<h2 class="title">
<img src="image/app/topic.gif" />热闹 - <a href="space.php?do=topic&topicid=<?=$topicid?>"><?=$topic['subject']?></a>
</h2>
<div class="tabs_header">
<ul class="tabs">
<li class="active"><a href="javascript:;"><span>凑个热闹</span></a></li>
<li><a href="space.php?do=topic&topicid=<?=$topicid?>"><span>查看热闹</span></a></li>
</ul>
<?php if(checkperm('managetopic') || $topic['uid']==$_SGLOBAL['supe_uid']) { ?>
<div class="r_option">
<a href="cp.php?ac=topic&op=edit&topicid=<?=$topic['topicid']?>">编辑</a> | 
<a href="cp.php?ac=topic&op=delete&topicid=<?=$topic['topicid']?>" id="a_delete_<?=$topic['topicid']?>" onclick="ajaxmenu(event,this.id);">删除</a>
</p>
</div>
<?php } ?>
</div>


<div class="affiche">
<table width="100%">
<tr>
<?php if($topic['pic']) { ?>
<td width="160" id="event_icon" valign="top">
<img src="<?=$topic['pic']?>" width="150">
</td>
<?php } ?>
<td valign="top">
<h2>
<a href="space.php?do=topic&topicid=<?=$topic['topicid']?>"><?=$topic['subject']?></a>
</h2>

<div style="padding:5px 0;"><?=$topic['message']?></div>
<ul>
<li class="gray">发起作者: <a href="space.php?uid=<?=$topic['uid']?>"><?=$_SN[$topic['uid']]?></a></li>
<li class="gray">发起时间: <?=$topic['dateline']?></li>
<?php if($topic['endtime']) { ?><li class="gray">参与截止: <?=$topic['endtime']?></li><?php } ?>
<?php if($topic['joinnum']) { ?>
<li class="gray">参与人次: <?=$topic['joinnum']?></li>
<?php } ?>
<li class="gray">最后参与: <?=$topic['lastpost']?></li>
</ul>

<?php if($topic['allowjoin']) { ?>
<a href="<?=$topic['joinurl']?>" class="feed_po" id="hot_add" onmouseover="showMenu(this.id)">凑个热闹</a>
<ul id="hot_add_menu" class="dropmenu_drop" style="display:none;">
<?php if(in_array('blog', $topic['jointype'])) { ?>
<li><a href="cp.php?ac=blog&topicid=<?=$topicid?>">发表日志</a></li>
<?php } ?>
<?php if(in_array('pic', $topic['jointype'])) { ?>
<li><a href="cp.php?ac=upload&topicid=<?=$topicid?>">上传图片</a></li>
<?php } ?>
<?php if(in_array('thread', $topic['jointype'])) { ?>
<li><a href="cp.php?ac=thread&topicid=<?=$topicid?>">发起话题</a></li>
<?php } ?>
<?php if(in_array('poll', $topic['jointype'])) { ?>
<li><a href="cp.php?ac=poll&topicid=<?=$topicid?>">发起投票</a></li>
<?php } ?>
<?php if(in_array('event', $topic['jointype'])) { ?>
<li><a href="cp.php?ac=event&topicid=<?=$topicid?>">发起活动</a></li>
<?php } ?>
<?php if(in_array('share', $topic['jointype'])) { ?>
<li><a href="cp.php?ac=share&topicid=<?=$topicid?>">添加分享</a></li>
<?php } ?>
</ul>
<?php } else { ?>
<p class="r_option">该热闹已经截止</p>
<?php } ?>
</td>
</tr></table>
</div>

<?php } else { ?>
<div class="content" style="font-size:15px;">
          
                 <div class="indexing">
                  <span><a href="space.php?do=home">首页</a></span>><span>发起投票</span>
                 </div><!-- end -->
                 <div class="bread container_12">
                     <div class="bread_actived grid_1">
                         发起投票
                     </div>
                     
                   
</div>	
<?php } ?>


<div class="c_form" style="background: white; border: solid 1px #e3e3e3; min-height: 782px;">

<form id="addnewpoll" name="addnewpoll" method="post" action="cp.php?ac=poll" enctype="multipart/form-data">
<table cellspacing="4" cellpadding="4" width="100%" class="infotable">
<tr style="height: 25px;"></tr>
<tr>
<th width="80" >投票主题&nbsp;:</th>
<td>
<input placeholder="标题长度不少于2个字符且不超过80字符" type="text" class="t_input" style="width:250px; height: 20px;" id="subject" name="subject" value=""> <br/>

</td>
</tr>
<tr style="height: 25px;"></tr>
<tr id="intropoll">

<th>详细说明&nbsp;:</th>
<td>
<textarea  name="message"  style="height:100%;width:100%;"><?=$poll['message']?></textarea>
</td>	
</tr>

<tr style="height: 25px;"></tr>
<tr class="post_list container_12">
<th>封面图片&nbsp;:</th>
<td>
<input type="file" name="files" value="<?=$poll['imageurl']?>"/>
</td>
            </tr>
            <tr style="height: 25px;"></tr>
<?php $option=array(1,2,3,4); ?>
<?php if(is_array($option)) { foreach($option as $key => $val) { ?>
<tr>
<th>候选项<?=$val?></th>
<td>
<input type="text" class="t_input"  style="width:250px;" name="option[]" value="" maxlength="120">
<input type="file" name="option<?=$val?>"  style = "margin-left:20px;"/>
</td>
</tr>
<?php } } ?>
</tbody>
<tbody id="moreoption">
</tbody>
<tr>
<th></th>
<td>
<div><a id="moretip" href="javascript:" onclick="showMoreOption();" onfocus="this.blur();">增加更多选项</a></div>
</td>
</tr>
<tr>
<th>可投选项</th>
<td>
<select name="maxchoice">
<option value="1">
单选
</option>
<option value="2">
任选
</option>
</select>
</td>
</tr>
<tr>
<th>截止时间</th>
<td>
<script type="text/javascript" src="source/script_calendar.js" charset="<?=$_SC['charset']?>"></script>
<input type="text" class="t_input" size="16" id="expiration" readonly name="expiration" value="" placeholder="点击获取时间" onclick="showcalendar(event, this, 0, '<?php echo sgmdate('Y-m-d',$_SGLOBAL[timestamp]); ?>')" />
</td>
</tr>
<tr>
<th>投票限制</th>
<td>
<input type="radio" name="sex" value="0" checked />不限制 
<input type="radio" name="sex" value="1" />男
<input type="radio" name="sex" value="2" />女 
</td>
</tr>
<tr>
<th>悬赏投票</th>
<td>
<input type="radio" name="reward" value="0" checked onclick="initReward(this.value);" />否
<input type="radio" name="reward" value="1" onclick="initReward(this.value);" />是
</td>
</tr>
<tbody id="rewardlist" style="display: none;">
<tr>
<th>悬赏总额</th>
<td>
<input type="text" class="t_input" size="16" id="credit" name="credit" value="" maxlength="60"> 范围：1~<?=$space['credit']?>
</td>
</tr>
<tr>
<th>每人悬赏</th>
<td>
<input type="text" class="t_input" size="16" id="percredit" name="percredit" value="" maxlength="60"> 范围：1~<?=$_SCONFIG['maxreward']?>
</td>
</tr>
</tbody>
<?php if(checkperm('seccode')) { ?>
<?php if($_SCONFIG['questionmode']) { ?>
<tr>
<th style="vertical-align: top;" width="90">请回答验证问题</th>
<td>
<p><?php question(); ?></p>
<input type="text" id="seccode" name="seccode" value="" size="15" class="t_input" />
</td>
</tr>
<?php } else { ?>
<tr>
<th style="vertical-align: top;" width="90">请填写验证码</th>
<td>
<script>seccode();</script>
<p>请输入上面的4位字母或数字，看不清可<a href="javascript:updateseccode()">更换一张</a></p>
<input type="text" id="seccode" name="seccode" value="" size="15" class="t_input" />
</td>
</tr>
<?php } ?>
<?php } ?>



<tr>
<th></th>
<td>
<input type="hidden" name="pollsubmit" id="pollsubmit" value="true" />
<input type="hidden" name="topicid" value="<?=$_GET['topicid']?>" />
<input type="hidden" name="formhash" value="<?php echo formhash(); ?>" />
<input type="submit" name="addpollsubmit" id="addpollsubmit" value="发起投票"  onclick="validate(this);" class="btn" style="width: 94px; height: 32px; font-size: 12px; margin: 0; border: 0; padding: 0;"/>
<div id="__addnewpoll"></div>
</td>
</tr>
</table>
</form>
<script type="text/javascript" src="image/editor/editor_function.js" charset="<?=$_SC['charset']?>"></script>
<script type="text/javascript" charset="<?=$_SC['charset']?>">

var maxnum = 4;
function initIntro() {
var introObj = $('intropoll');
var tipObj = $('addtip');
if(introObj.style.display == 'none') {
introObj.style.display = '';

tipObj.innerHTML = "隐藏投票详细说明";
} else {
if (($('message').value.length == 0) || (confirm("详细说明将被清空，你确定要隐藏吗？"))) {
introObj.style.display = 'none';
$('message').value = '';
tipObj.innerHTML = "添加投票详细说明";
}
}
}
function initReward(status) {
var rewardObj = $('rewardlist');
if(status == 1) {
rewardObj.style.display = '';
} else {
rewardObj.style.display = 'none';
$("credit").value = '';
$("percredit").value = '';
}
}
function showMoreOption() {
var TextBoxParent = document.getElementById("moreoption");
if(maxnum==10)
{
TextBoxParent.innerHTML +="<th></th><td style='font-size: 15px; color: red;'>不能再添加候选项了！</td>";
$("moretip").style.display='none';
return;
}
maxnum = maxnum +1;
TextBoxParent.innerHTML +="<th>候选项"+maxnum+"</th><td><input type='text' class='t_input'  style='width:250px;' name='option[]' value='' maxlength='120'><input type='file' name='option"+maxnum+"' style ='margin-left:20px;'/></td>";
}
function validate(obj) {
    var subject = $('subject');
    if (subject) {
    	var slen = strlen(subject.value);
        if (slen < 1 || slen > 80) {
            alert("标题长度(1~80字符)不符合要求");
            subject.focus();
            return false;
        }
    }
    
    var makefeed = $('makefeed');
    if(makefeed) {
    	if(makefeed.checked == false) {
    		if(!confirm("友情提醒：您确定此次发布不产生动态吗？\n有了动态，好友才能及时看到你的更新。")) {
    			return false;
    		}
    	}
    }
    
var optionCount = 0;
var optionObj = document.getElementsByName("option[]");
for(var i=0;i<optionObj.length;i++) {
if(optionObj[i].value.Trim()!="") {
optionCount++;
}
}
if(optionCount<2) {
alert('请至少添加两个候选项！');
return false;
}
var maxCredit = <?=$space['credit']?>;
var maxPercredit = <?=$_SCONFIG['maxreward']?>;
//验证悬赏投票设置
var credit = parseInt($('credit').value.Trim());
var percredit = parseInt($('percredit').value.Trim());
if(credit || percredit) {
if(!credit) {
alert("请正确填写悬赏总额");
return false;
} else if(!percredit) {
alert("请正确填写每人悬赏积分");
return false;
} else if(credit > maxCredit) {
alert("悬赏总额应在:1~"+maxCredit+"之间取值");
return false;
} else if(maxPercredit && percredit > maxPercredit) {
alert("每人悬赏应在:1~"+maxPercredit+"之间取值");
return false;
} else if(credit < percredit) {
alert("每人悬赏不能高于悬赏总额");
return false;
}
}
var nowDate = parsedate("<?php echo sgmdate('Y-m-d',$_SGLOBAL[timestamp]); ?>");


if($('expiration').value.Trim() != "") {
var expiration = parsedate($('expiration').value.Trim());
if(expiration < nowDate) {
alert("过期时间不能小于当前时间");
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
}
});
    }
    //ajaxpost('addnewpoll', 'poll_post_result');
}
String.prototype.Trim = function() { 
return this.replace(/(^\s*)|(\s*$)/g, ""); 
}
</script>
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