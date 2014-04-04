<?php if(!defined('IN_UCHOME')) exit('Access Denied');?><?php subtplcheck('admin/tpl/space_manage|admin/tpl/header|admin/tpl/side|admin/tpl/footer|template/default/header|template/default/footer', '1387245910', 'admin/tpl/space_manage');?><?php $_TPL['menunames'] = array(
		'index' => '管理首页',
		'config' => '站点设置',
		'privacy' => '隐私设置',
		'usergroup' => '用户组',
		'credit' => '积分规则',
		'profilefield' => '用户栏目',
		'profield' => '群组栏目',
		'eventclass' => '活动分类',
		'magic' => '道具设置',
		'task' => '有奖任务',
		'spam' => '防灌水设置',
		'censor' => '词语屏蔽',
		'ad' => '广告设置',
		'userapp' => 'MYOP应用',
		'app' => 'UCenter应用',
		'network' => '随便看看',
		'cache' => '缓存更新',
		'log' => '系统log记录',
		'space' => '用户管理',
		'feed' => '动态(feed)',
		'share' => '分享',
		'blog' => '日志',
		'album' => '相册',
		'pic' => '图片',
		'comment' => '评论/留言',
		'thread' => '话题',
		'post' => '回帖',
		'doing' => '记录',
		'tag' => '标签',
		'mtag' => '群组',
		'poll' => '投票',
		'event' => '活动',
		'magiclog' => '道具记录',
		'report' => '举报',
		'block' => '数据调用',
		'template' => '模板编辑',
		'backup' => '数据备份',
		'stat' => '统计更新',
		'cron' => '系统计划任务',
		'click' => '表态动作',
		'ip' => '访问IP设置',
		'hotuser' => '推荐成员设置',
		'defaultuser' => '默认好友设置',
		'introduce' => '企业介绍',
		'product' => '产品介绍',
		'development' => '企业动态',
		'industry' => '行业动态',
		'cases' => '成功案例',
		'branch' => '分支机构',
		'job' => '人才招聘',
		'talk' => '在线沟通',
		'weixin' =>'微信录入',
		'image' =>'首页图片录入'
	); ?>
<?php $_TPL['nosidebar'] = 1; ?>
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


<style type="text/css">
@import url(admin/tpl/style.css);
</style>

<div id="cp_content">

  <div class="content_detail_wrapper" style="width:880px;float:right;min-height:1003px;">
                    <div class="post_wrapper" style="width:840px;margin:0 auto;">




<?php if($uid) { ?>
<form method="post" action="admincp.php?ac=space&uid=<?=$uid?>" enctype="multipart/form-data">
<input type="hidden" name="formhash" value="<?php echo formhash(); ?>" />

<div class="bdrcontent">
<div class="title">
<h3><?=$member['username']?> 基本信息</h3>
</div>
<table cellspacing="0" cellpadding="0" class="formtable">
<tr><th style="width:12em;">用户名</th>
<td><a href="space.php?uid=<?=$member['uid']?>" target="_blank"><?=$member['username']?></a></td></tr>


<tr><th>开通时间</th><td><?php echo sgmdate('Y-m-d H:i',$member[dateline]); ?></td></tr>
<tr><th>更新时间</th><td><?php if($member['updatetime']) { ?><?php echo sgmdate('Y-m-d H:i',$member[updatetime]); ?><?php } else { ?>-<?php } ?></td></tr>
<tr><th>上次登录</th><td><?php echo sgmdate('Y-m-d H:i',$member[lastlogin]); ?></td></tr>
<tr><th>注册IP</th><td><?=$member['regip']?></td></tr>
<tr><th>好友数</th><td><?=$member['friendnum']?></td></tr>
<tr><th>查看数</th><td><?=$member['viewnum']?></td></tr>
<tr><th>批量管理</th>
<td>
<a href="admincp.php?ac=introduce&uid=<?=$member['uid']?>&searchsubmit=1" target="_blank">企业介绍(<?=$member['introducenum']?>)</a> | 
<a href="admincp.php?ac=product&uid=<?=$member['uid']?>&searchsubmit=1" target="_blank">产品介绍(<?=$member['productnum']?>)</a> | 
<a href="admincp.php?ac=development&uid=<?=$member['uid']?>&searchsubmit=1" target="_blank">企业动态(<?=$member['developmentnum']?>)</a> | 
<a href="admincp.php?ac=industry&uid=<?=$member['uid']?>&searchsubmit=1" target="_blank">行业动态(<?=$member['industrynum']?>)</a> | 
<a href="admincp.php?ac=cases&uid=<?=$member['uid']?>&searchsubmit=1" target="_blank">成功案例(<?=$member['casesnum']?>)</a> | 
<a href="admincp.php?ac=branch&uid=<?=$member['uid']?>&searchsubmit=1" target="_blank">分支机构(<?=$member['branchnum']?>)</a> | 
<a href="admincp.php?ac=job&uid=<?=$member['uid']?>&searchsubmit=1" target="_blank">人才招聘(<?=$member['jobnum']?>)</a> | 
<a href="admincp.php?ac=talk&uid=<?=$member['uid']?>&searchsubmit=1" target="_blank">在线沟通(<?=$member['talknum']?>)</a> | 
<a href="admincp.php?ac=pic&uid=<?=$member['uid']?>&searchsubmit=1" target="_blank">图片</a> | 
<a href="admincp.php?ac=comment&authorid=<?=$member['uid']?>&searchsubmit=1" target="_blank">评论</a> | 
<a href="admincp.php?ac=post&uid=<?=$member['uid']?>&searchsubmit=1" target="_blank">回帖</a>
</td></tr>

<tr><th>&nbsp;</th>
<td>

<?php if($member['flag'] != 1 && checkperm('managedelspace')) { ?>
<a href="admincp.php?ac=space&op=close&uid=<?=$member['uid']?>" <?php if($member['flag']!=-1) { ?> onclick="return confirm('锁定后该空间将被禁止访问，确认锁定吗？');" <?php } ?> class="submit"><?php if($member['flag']!=-1) { ?>锁定空间(不会删除数据)<?php } else { ?>解除锁定状态<?php } ?></a> &nbsp;
<a href="admincp.php?ac=space&op=delete&uid=<?=$member['uid']?>" onclick="return confirm('危险，这将删除该空间所有数据，并且本操作不可恢复，确认删除？');">删除该空间(删除数据并不可恢复)</a>&nbsp;&nbsp;&nbsp;
<?php } else { ?>
本用户被保护，不能删除、不能锁定
<?php } ?>
</td>
</tr>

</table>
</div>

<?php if($managespaceinfo) { ?>
<br>
<div class="bdrcontent">
<div class="title">
<h3><?=$member['username']?> 实名验证</h3>
</div>
<table cellspacing="0" cellpadding="0" class="formtable">
<tr><th style="width:12em;">姓名</th><td><input type="text" class="t_input" name="name" value="<?=$member['name']?>">
<input type="radio" name="namestatus" value="0"<?php if($member['namestatus']==0) { ?> checked<?php } ?>> 认证失败
<input type="radio" name="namestatus" value="1"<?php if($member['namestatus']==1) { ?> checked<?php } ?>> 认证通过
</td></tr>
<tr><th style="width:12em;">头像</th><td><a href="space.php?uid=<?=$member['uid']?>" target="_blank"><?php echo avatar($member[uid],big); ?></a>
<br>[<a href="admincp.php?ac=space&op=deleteavatar&uid=<?=$uid?>">删除头像</a>]
</td></tr>

<?php if($_SCONFIG['videophoto']) { ?>
<tr><th>视频认证</th><td>
<p>
<input type="radio" name="videostatus" value="0"<?=$videostatusarr['0']?>>未通过
<input type="radio" name="videostatus" value="1"<?=$videostatusarr['1']?>>已通过(需要有视频照片)
</p>
<?php if($videopic) { ?><img src="<?=$videopic?>" width="400"><br><?php } ?>
上传一张该用户照片，更新视频认证照片:<br>
<input type="file" name="newvideopic" value="">
</td></tr>
<?php } ?>

<tr>
<th style="width:12em;">常用邮箱</th>
<td>
<input type="text" id="email" class="t_input" name="email" value="<?=$member['email']?>" />
<input type="radio" name="emailcheck" value="0"<?php if($member['emailcheck']==0) { ?> checked<?php } ?>> 未激活
<input type="radio" name="emailcheck" value="1"<?php if($member['emailcheck']==1) { ?> checked<?php } ?>> 已经验证激活
</td>
</tr>
<?php if($_SCONFIG['allowdomain'] && $_SCONFIG['domainroot']) { ?>
<tr><th style="width:12em;">二级域名</th><td><input type="text" class="t_input" name="domain" value="<?=$member['domain']?>" size="10">.<?=$_SCONFIG['domainroot']?></td></tr>
<?php } ?>
<tr><th style="width:12em;">额外好友数</th><td><input type="text" class="t_input" name="addfriend" value="<?=$member['addfriend']?>" size="10"> 个</td></tr>


<tr><th>清空自定义CSS</th><td>
<input type="radio" name="clearcss" value="0" checked> 不处理
<input type="radio" name="clearcss" value="1"> 清空
<p>用户自定义的CSS如果存在恶意代码，可以选择清空。</p>
</td></tr>
<tr><th style="width:12em;">联系人</th><td><input type="text" class="t_input" name="linkman" value="<?=$member['linkman']?>" size="10"></td></tr>
<tr><th style="width:12em;">联系人身份证</th><td><input type="text" class="t_input" name="idcard" value="<?=$member['idcard']?>" size="30"></td></tr>
<tr><th style="width:12em;">身份证扫描件</th><td><img src="<?=$member['image1url']?>"/></td></tr>
<tr>
<tr><th style="width:12em;">营业执照注册号</th><td><input type="text" class="t_input" name="businessnum" value="<?=$member['businessnum']?>" size="30"></td></tr>
<tr><th style="width:12em;">营业执照扫描件</th><td><img src="<?=$member['image4url']?>"/></td></tr>
<tr><th style="width:12em;">公司名称</th><td><input type="text" class="t_input" name="companyname" value="<?=$member['companyname']?>" size="30"></td></tr>
<tr><th style="width:12em;">联系人电话</th><td><input type="text" class="t_input" name="mobile" value="<?=$member['mobile']?>" size="30"></td></tr>
<tr>
<th>QQ</th>
<td>
<input type="text" class="t_input" name="qq" value="<?=$member['qq']?>" /> 
</td>
</tr>
<tr>


<?php if(is_array($profilefields)) { foreach($profilefields as $value) { ?>
<tr>
<th><?=$value['title']?><?php if($value['required']) { ?>*<?php } ?></th>
<td>
<?=$value['formhtml']?>
<?php if($value['note']) { ?><br><?=$value['note']?><?php } ?>
</td>
</tr>
<?php } } ?>



</table>
</div>
<?php } ?>
<?php if($managename) { ?>
<br>
<div class="bdrcontent">
<div class="title">
<h3><?=$member['username']?> 企业资料</h3>
</div>
<table cellspacing="0" cellpadding="0" class="formtable">
<tr><th style="width:12em;">微信公众号</th><td><input type="text" class="t_input" name="weixin" value="<?=$member['weixin']?>" size="20"></td></tr>
<tr><th style="width:12em;">企业地址</th><td><input type="text" class="t_input" name="businessaddress" value="<?=$member['businessaddress']?>" size="60"></td></tr>
<tr><th style="width:12em;">行业</th><td><input type="text" class="t_input" name="business" value="<?=$member['business']?>" size="10"></td></tr>
<tr><th style="width:12em;">运营地区</th><td><input type="text" class="t_input" name="resideprovince" value="<?=$member['resideprovince']?>" size="10">-<input type="text" class="t_input" name="residecity" value="<?=$member['residecity']?>" size="10"></td></tr>
<tr><th style="width:12em;">固话</th><td><input type="text" class="t_input" name="telephone" value="<?=$member['telephone']?>" size="20"></td></tr>
<tr><th style="width:12em;">企业logo</th><td><img src="<?=$member['smalllogourl']?>"></td></tr>
<tr><th style="width:12em;">企业介绍</th><td><textarea rows="4" cols="100" name="companyintroduce"><?=$member['companyintroduce']?></textarea></td></tr>
</table>
</div>
<?php } ?>
<?php if($managename) { ?>
<br>
<div class="bdrcontent">
<div class="title">
<h3><?=$member['username']?>组件管理</h3>
</div>
<table cellspacing="0" cellpadding="0" class="formtable">
当前定制等待开通的组件<br/>
<?php if(is_array($menuset1)) { foreach($menuset1 as $value2) { ?>
<?=$value2['subject']?>，
<?php } } ?>
当前开通的组件<br/>
<?php if(is_array($menuset2)) { foreach($menuset2 as $value3) { ?>
<?=$value3['subject']?>，
<?php } } ?>
<?php if(is_array($menuset)) { foreach($menuset as $value1) { ?>
<tr><th style="width:12em;"><?=$value1['subject']?></th><td><a href="admincp.php?ac=space&op=zujian&action=open&id=<?=$value1['menusetid']?>&uid=<?=$_GET['uid']?>">开通</a>&nbsp;&nbsp;<a href="admincp.php?ac=space&op=zujian&action=close&id=<?=$value1['menusetid']?>&uid=<?=$_GET['uid']?>">关闭</a></td></tr>
<?php } } ?>
</table>
</div>
<?php } ?>
<?php if($managespacecredit) { ?>
<br>
<div class="bdrcontent">
<div class="title">
<h3><?=$member['username']?> 积分、经验值、空间大小管理</h3>
</div>
<table cellspacing="0" cellpadding="0" class="formtable">
<tr><th style="width:12em;">额外空间大小</th><td><input type="text" class="t_input" name="addsize" value="<?=$member['addsize']?>" size="10"> M</td></tr>
<tr><th>积分数</th><td><input type="text" name="credit" class="t_input" value="<?=$member['credit']?>" size="10"></td></tr>
<tr><th>经验值</th><td><input type="text" class="t_input" name="experience" value="<?=$member['experience']?>" size="10"></td></tr>
</table>
</div>
<?php } ?>
<?php if($managespacegroup) { ?>
<br>
<div class="bdrcontent">
<div class="title">
<h3><?=$member['username']?> 保护信息</h3>
</div>
<table cellspacing="0" cellpadding="0" class="formtable">

<tr><th style="width:12em;">用户组</th><td>
<select name="groupid" onchange="showDateSet(this.value);">
<option value="0">普通用户组</option>
<?php $show=true; ?>
<?php if(is_array($usergroups)) { foreach($usergroups as $value) { ?>
<?php if($groupidarr[$value['gid']]) { ?><?php $show=false; ?><?php } ?>
<option value="<?=$value['gid']?>"<?=$groupidarr[$value['gid']]?>><?=$value['grouptitle']?></option>
<?php } } ?>
</select>
<p>普通用户组，会自动根据用户经验数目的多少进行自动升级/降级<br>系统用户组，用户的身份不受经验值影响</p></td></tr>
<tr id="expirationtr" <?php if($show) { ?>style="display:none;"<?php } ?>><th>用户组过期时间</th><td>
<input type="text" class="t_input" name="expiration" value="<?=$member['expiration']?>" size="20">(格式：2009-8-8 00:00)
<p>为空则永久有效</p>
</td></tr>
<tr><th>代理人数</th><td>
<input type="text" class="t_input" name="limitnum" value="<?=$member['limitnum']?>" size="20">
</td></tr>
<?php if($member['flag'] != -1) { ?>
<tr><th>删除保护</th><td>
<input type="radio" name="flag" value="0"<?php if($member['flag']==0) { ?> checked<?php } ?>> 不保护
<input type="radio" name="flag" value="1"<?php if($member['flag']==1) { ?> checked<?php } ?>> 保护
<p>保护状态下，该用户将不能够在UCenter、以及本应用中删除。</p>
</td></tr>
</td></tr>
<?php } ?>
</table>
<script type="text/javascript">
function showDateSet(val) {
var expObj = $("expirationtr");
expObj.style.display = parseInt(val) ? '' : 'none';
}
</script>
</div>
<?php } ?>

<div class="footactions">
<input type="hidden" name="refer" value="<?=$_SGLOBAL['refer']?>">
<input type="submit" name="usergroupsubmit" value="提交" class="submit">
</div>
</form>
<?php } elseif($_POST['optype'] == 4) { ?>

<form method="post" action="<?=$url?>">
<input type="hidden" name="formhash" value="<?php echo formhash(); ?>" />
<div class="bdrcontent">
<div class="title">
<h3>批量发送邮件</h3>
<p>您可以对选定的用户进行批量发送邮件。注意，本操作将会增加服务器负载。</p>
</div>
<table cellspacing="0" cellpadding="0" class="formtable">
<tr>
<th style="width:8em;">收件人(UID)</th>
<td><input type="text" name="uids" value="<?=$uids?>" size="60"> 多个UID间用 "," 分隔</td>
</tr>
<tr>
<th>邮件标题</th>
<td><input type="text" name="subject" value="" size="60"></td>
</tr>
<tr>
<th>邮件内容</th>
<td><textarea name="message" cols="80" rows="10"></textarea><br>邮件内容支持html代码</td>
</tr>
</table>
</div>

<div class="footactions">		
<input type="hidden" name="refer" value="<?=$_SGLOBAL['refer']?>">
<input type="submit" name="sendemailsubmit" value="发送邮件" class="submit">
</div>
</form>

<?php } elseif($_POST['optype'] == 5) { ?>

<form method="post" action="<?=$url?>">
<input type="hidden" name="formhash" value="<?php echo formhash(); ?>" />
<div class="bdrcontent">
<div class="title">
<h3>批量打招呼</h3>
<p>您可以对选定的用户进行批量打招呼，以对其简单说明一些事情。注意，本操作将会增加服务器负载。</p>
</div>
<table cellspacing="0" cellpadding="0" class="formtable">
<tr>
<th style="width:8em;">收件人(UID)</th>
<td><input type="text" name="uids" value="<?=$uids?>" size="60"> 多个UID间用 "," 分隔</td>
</tr>
<tr>
<th>招呼内容</th>
<td><input type="text" name="note" value="" size="60"> （不要超过50个字符）</td>
</tr>
</table>
</div>

<div class="footactions">		
<input type="hidden" name="refer" value="<?=$_SGLOBAL['refer']?>">
<input type="submit" name="pokesubmit" value="打招呼" class="submit">
</div>
</form>	

<?php } elseif($_POST['optype'] == 7) { ?>

<form method="post" action="<?=$url?>" onsubmit="return checkPresent()">
<input type="hidden" name="formhash" value="<?php echo formhash(); ?>" />
<div class="bdrcontent">
<div class="title">
<h3>批量赠送道具</h3>
<p>您可以给选定的用户批量赠送道具。注意，本操作将会增加服务器负载。</p>
</div>
<table cellspacing="0" cellpadding="0" class="formtable">
<tr>
<th style="width:8em;">受赠者(UID)</th>
<td><input type="text" name="uids" value="<?=$uids?>" size="60"> 多个UID间用 "," 分隔</td>
</tr>
<tr>
<th>赠送道具</th>
<td>
<select id="newmagicaward">
<?php if(is_array($_SGLOBAL['magic'])) { foreach($_SGLOBAL['magic'] as $key => $value) { ?>
<option value="<?=$key?>"><?=$value?></option>
<?php } } ?>
</select>
<input type="text" id="newmagicawardnum" value="1" />
<input class="button" type="button" onclick="addMagicAward()" value="添加" />
<ul id="magicawards"></ul>
<script type="text/javascript">
function addMagicAward(){
var mid = $('newmagicaward').value;
var id = "magicaward_" + mid;
var num = $('newmagicawardnum').value;
var name = $('newmagicaward').options[$('newmagicaward').selectedIndex].text;
if($(id)) {
removeMagicAward($(id).getElementsByTagName("a")[0]);
}
var s = '<li id="' + id + '">';
s += '<input type="hidden" name="magicaward[]" value="' + mid + ',' + num + '" />';
s += name + ' &nbsp;&nbsp;' + "\n";
s += num + ' &nbsp;&nbsp;' + "\n";
s += '<a href="#" onclick="removeMagicAward(this);return false;">删除</a>';
s += '</li>';
$('magicawards').innerHTML += s;
}
function removeMagicAward(o) {
$('magicawards').removeChild(o.parentNode);
}
function checkPresent(){
if($('magicawards').getElementsByTagName("li").length) {
return true;
} else {
alert('请至少选择一种道具并点击“添加”按钮');
return false;
}
}
</script>
</td>
</tr>
</table>
</div>

<div class="footactions">
<input type="hidden" name="refer" value="<?=$_SGLOBAL['refer']?>">
<input type="submit" name="magicsubmit" value="赠送道具" class="submit">
</div>
</form>
<?php } ?>

</div>
</div>

<div class="side">
<?php if($menus['0']) { ?>
<div class="block style1">
<h2>基本设置</h2>
<ul class="folder">
<?php if(is_array($acs['0'])) { foreach($acs['0'] as $value) { ?>
<?php if($menus['0'][$value]) { ?>
<?php if($ac==$value) { ?><li class="active"><?php } else { ?><li><?php } ?><a href="admincp.php?ac=<?=$value?>"><?=$_TPL['menunames'][$value]?></a></li>
<?php } ?>
<?php } } ?>
</ul>
</div>
<?php } ?>

<div class="block style1">
<h2>批量管理</h2>
<ul class="folder">
<?php if(is_array($acs['4'])) { foreach($acs['4'] as $value) { ?>
<?php if($ac==$value) { ?><li class="active"><?php } else { ?><li><?php } ?><a href="admincp.php?ac=<?=$value?>"><?=$_TPL['menunames'][$value]?></a></li>
<?php } } ?>
<?php if(is_array($acs['1'])) { foreach($acs['1'] as $value) { ?>
<?php if($menus['1'][$value]) { ?>
<?php if($ac==$value) { ?><li class="active"><?php } else { ?><li><?php } ?><a href="admincp.php?ac=<?=$value?>"><?=$_TPL['menunames'][$value]?></a></li>
<?php } ?>
<?php } } ?>
</ul>
</div>

<?php if($menus['2']) { ?>
<div class="block style1">
<h2>高级设置</h2>
<ul class="folder">
<?php if(is_array($acs['2'])) { foreach($acs['2'] as $value) { ?>
<?php if($menus['2'][$value]) { ?>
<?php if($ac==$value) { ?><li class="active"><?php } else { ?><li><?php } ?><a href="admincp.php?ac=<?=$value?>"><?=$_TPL['menunames'][$value]?></a></li>
<?php } ?>
<?php } } ?>
<?php if($menus['0']['config']) { ?><li><a href="<?=UC_API?>" target="_blank">UCenter</a></li><?php } ?>
</ul>
</div>
<?php } ?>
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