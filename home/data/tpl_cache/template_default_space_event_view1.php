<?php if(!defined('IN_UCHOME')) exit('Access Denied');?><?php subtplcheck('template/default/space_event_view1|template/default/header|template/default/space_comment_li|template/default/footer', '1387334257', 'template/default/space_event_view1');?><?php $_TPL['titles'] = array($event['title'], '活动'); ?>
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
.event-list-center{margin-left:auto;margin-right: auto;}
.event-list-header{border: 1px solid #ddd;width:660px;padding:20px;margin-top:20px;}
.event-list-content{padding-top:28px;padding-left:28px;}
.event-list-table td{padding-right:18px;padding-top: 10px;}
.event-list-td-word{color:#00A69E;font-size:13px;padding-right:10px;}

.event-list-h1{padding-bottom:10px;font-size:20px;color:#00A69E;}
.dec-content{padding-bottom:20px;border-bottom: 1px dotted #ddd;}

.event-cp-table th{text-align:left;}
.clearfloat{clear:both;}
/*活动页面详情页css*/
.event-view-header{text-align:center;margin-top: 20px;}
.event-view-header h1{font-size:20px;color:#00A69E;}
.event-view-con{padding:20px;font-size:14px;}
.event-view-con-header{padding:10px;color:#02B4AB;font-size:medium;}
.event-view-con-content{padding:10px;font-size:14px;}
.spacing-left{padding-left:20px;}
.spacing-right{padding-right:20px;}
.event-font{}
.submit:hover{background: #02B4AB;}
a:hover{color:black;}
</style>
<div class="content" style="font-size:15px;">

    <div class="bread container_12">
    	<div class="bread_actived grid_1"> 活动详情</div>
    	
    	<?php if(empty($_SGLOBAL['supe_userevent']) && $event['deadline'] > $_SGLOBAL['timestamp']) { ?>
<?php if($event['limitnum']==0 || $event['membernum']<$event['limitnum']) { ?>
<a id="a_join" href="cp.php?ac=event&op=join&id=<?=$eventid?>" onclick="ajaxmenu(event, this.id)" class="btn grid_2">我要参加</a>
<?php } ?>
<?php } elseif(!empty($_SGLOBAL['supe_userevent']) && $_SGLOBAL['supe_userevent']['status'] == 0) { ?>
<a id="a_quit" href="cp.php?ac=event&id=<?=$eventid?>&op=quit" onclick="ajaxmenu(event, this.id)" class="btn grid_2">不参加了</a>
<?php } elseif($_SGLOBAL['supe_userevent']['status'] == 1) { ?>
<?php if($event['deadline'] > $_SGLOBAL['timestamp'] && ($event['limitnum']==0 || $event['membernum']<$event['limitnum'])) { ?>
<a id="a_join" href="cp.php?ac=event&op=join&id=<?=$eventid?>" onclick="ajaxmenu(event, this.id)" class="btn grid_2">我要参加</a>
<?php } ?>
<?php } elseif($_SGLOBAL['supe_userevent']['status'] > 1) { ?>
<?php if($_SGLOBAL['supe_uid'] != $event['uid']) { ?>
<a id="a_quit" href="cp.php?ac=event&id=<?=$eventid?>&op=quit" onclick="ajaxmenu(event, this.id)" class="btn grid_2">不参加了</a>
<?php } ?>
<?php } ?>
    </div>
<div id="content" style="width:760px;">
<div class="content_detail_wrapper">
<div class = "event-view-header" style="margin-top: 40px;">
<h1 style="color: black; margin-top: 30px;"><?=$event['title']?></h1>
</div>
<div class="content_text_detail" style="text-align: center;margin-bottom:10px;margin-top:15px;font-size:12px;">作者 : <?=$_SN[$event['uid']]?>&nbsp;|&nbsp;发布时间 : <?php echo sgmdate('Y-m-d H:i:s',$event[dateline]); ?></div>
<div class = "event-view-con">
<div class = "event-view-con-header">
基本情况
</div>
<div class = "event-view-con-content">
<div class="grid_1">
                    	<img src="<?=$event['pic']?>" class="list_pic" width="200px" height="150px">
                    </div>
                    <div class="grid_2 spacing-left">
<table class="">

<tr>
<th class ="spacing-right">活动类型:</th><td><?=$_SGLOBAL['eventclass'][$event['classid']]['classname']?></td>
</tr>
<tr>
<th class ="spacing-right">活动地点:</th><td><?=$event['province']?> <?=$event['city']?> <?=$event['location']?></td>
</tr>
<tr>
<th class ="spacing-right">活动时间:</th><td><?php echo sgmdate("m月d日 H:i", $event[starttime]) ?> - <?php echo sgmdate("m月d日 H:i", $event[endtime]) ?></td>
</tr>
<tr>
<th class ="spacing-right">截止报名:</th><td><?php if($event['deadline']>=$_SGLOBAL['timestamp']) { ?>
<?php echo sgmdate("m月d日 H:i", $event[deadline]) ?>
<?php } else { ?>
报名结束
<?php } ?></td>
</tr>


</table>
</div>
</div>
</div>
<div class = "clearfloat"></div>
<div class = "event-view-con">
<div class="event-view-con-header">
活动介绍
</div>
<div class = "event-view-con-content">
<?=$event['detail']?>
</div>
</div>
<div class = "event-view-con">
<div class = "event-view-con-header">
活动成员
<a href="cp.php?ac=event&id=<?=$eventid?>&op=members" style="margin-left: 40px;">成员管理</a>
</div>
<div class = "event-view-con-content">
<?php if($members) { ?>
<ul class="avatar_list1">
<?php if(is_array($members)) { foreach($members as $key => $userevent) { ?>
<li>
<p style="margin-top:8px;">
<?=$userevent['username']?>&nbsp;:&nbsp;<?=$userevent['tel']?>
</p>
<?php if($event['allowfellow']) { ?>
<p><?php if($userevent['fellow']) { ?>携带 <?=$userevent['fellow']?> 人<?php } ?></p>
<?php } ?>
</li>
<?php } } ?>
</ul>
<?php } else { ?>
<p style="text-align:center;">还没有活动成员。
<?php if($event['grade']>0 && $_SGLOBAL['timestamp']<= $event['deadline'] && ($event['limitnum'] <= 0 || $event['membernum'] < $event['limitnum']) && ($_SGLOBAL['supe_userevent']['status'] >= 3 || ($event['allowinvite'] && $_SGLOBAL['supe_userevent']['status']==2))) { ?>
<a href="cp.php?ac=event&id=<?=$eventid?>&op=invite">邀请好友参加</a>
<?php } ?>
</p>
<?php } ?>
</div>
</div>

<div class = "event-view-con">

<div class = "event-view-con-content">
<ul class="menu_list" style="width: 700px;">
<li style="width: 10%;float: right;"><a id="a_close" onclick="ajaxmenu(event, this.id)" href="cp.php?ac=event&id=<?=$eventid?>&op=close">取消</a></li>
<li style="width: 10%;float: right;"><a href="cp.php?ac=event&id=<?=$eventid?>&op=edit">修改</a></li>

<?php } ?>

<?php if($event['grade']>0 && $_SGLOBAL['timestamp']<= $event['deadline'] && ($event['template'] || $event['allowfellow'])) { ?>
<li style="width: 10%;float: right;"><a id="a_join" href="cp.php?ac=event&id=<?=$eventid?>&op=join" onclick="ajaxmenu(event, this.id)">报名信息</a></li>
<?php } ?>

<?php if($_SGLOBAL['supe_userevent']['uid'] == $event['uid']) { ?>
<?php if($event['grade']>0 && $_SGLOBAL['timestamp']>$event['endtime']) { ?>

<?php } ?>
<?php if($event['grade']==-2 && $_SGLOBAL['timestamp']>$event['endtime']) { ?>
<li style="width: 10%;float: right;"><a id="a_open" onclick="ajaxmenu(event, this.id)" href="cp.php?ac=event&id=<?=$eventid?>&op=open">开启活动</a></li>
<?php } ?>
<li style="width: 10%;float: right;"><a id="a_delete" onclick="ajaxmenu(event, this.id)" href="cp.php?ac=event&id=<?=$eventid?>&op=delete">删除</a></li>
<?php } elseif($_SGLOBAL['endtime']<= $_SGLOBAL['timestamp']) { ?>
<li style="width: 10%;float: right;"><a id="a_quit2" onclick="ajaxmenu(event, this.id)" href="cp.php?ac=event&id=<?=$eventid?>&op=quit">退出活动</a></li>
<?php } ?>
<li style="width: 15%;float: right;">阅读&nbsp;（&nbsp;<?=$event['viewnum']?>&nbsp;）&nbsp;</li>
<li style="width: 15%;float: right;">评论&nbsp;（&nbsp;<?=$event['replynum']?>&nbsp;）&nbsp;</li>

</ul>
<?php if($event['grade']>0 && ($event['allowpost'] || $_SGLOBAL['supe_userevent']['status'] > 1)) { ?>
<div class="space_wall_post" style="width: 800px;">
<form action="cp.php?ac=comment" id="commentform_<?=$space['uid']?>" name="commentform_<?=$space['uid']?>" method="post">
<a href="###" id="message_face" onclick="showFace(this.id, 'comment_message');return false;"><img src="image/facelist.gif" align="absmiddle" /></a>
<?php if($_SGLOBAL['magic']['doodle']) { ?>
<a id="a_magic_doodle" href="magic.php?mid=doodle&showid=comment_doodle&target=comment_message" onclick="ajaxmenu(event, this.id, 1)"><img src="image/magic/doodle.small.gif" class="magicicon" />涂鸦板</a>
<?php } ?>
<br />
<textarea name="message" id="comment_message" rows="5" cols="111" onkeydown="ctrlEnter(event, 'commentsubmit_btn');" style="width: 560px; float: left; margin-right: 20px; height: 105px;"></textarea>
<input type="hidden" name="refer" value="space.php?do=event&id=<?=$eventid?>" />
<input type="hidden" name="id" value="<?=$eventid?>" />
<input type="hidden" name="idtype" value="eventid" />
<input type="hidden" name="commentsubmit" value="true" />
<input type="button" style=" width: 123px; height: 107px; font-size: 26px; border-radius: 2px;" id="commentsubmit_btn" name="commentsubmit_btn" class="submit" value="留言" onclick="ajaxpost('commentform_<?=$space['uid']?>', 'wall_add')" />
<input type="hidden" name="formhash" value="<?php echo formhash(); ?>" />
</form>
</div>
<br>
<?php } elseif($event['grade']>0) { ?>
<textarea name="message" id="comment_message" rows="5" cols="60" readonly="">只有活动成员才能发布留言</textarea>
<?php } ?>
<?php if($cid) { ?>
<div class="notice">
当前只显示与你操作相关的单个评论，<a href="space.php?do=event&id=<?=$eventid?>&view=comment">点击此处查看全部评论</a>
</div>
<?php } ?>
<div class="page"><?=$multi?></div>
<div class="comments_list" id="comment">
<input type="hidden" value="1" name="comment_prepend" id="comment_prepend" />
<ul id="comment_ul">
<?php if(is_array($comments)) { foreach($comments as $value) { ?>
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
<div class="page"><?=$multi?></div>
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
<?php } ?><?php ob_out();?>