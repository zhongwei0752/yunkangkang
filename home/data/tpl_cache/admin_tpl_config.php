<?php if(!defined('IN_UCHOME')) exit('Access Denied');?><?php subtplcheck('admin/tpl/config|admin/tpl/header|admin/tpl/side|admin/tpl/footer|template/default/header|template/default/footer', '1386147680', 'admin/tpl/config');?><?php $_TPL['menunames'] = array(
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




<div class="tabs_header">
<ul class="tabs">
<li><a href="#base"><span>基本设置</span></a></li>
<li><a href="#register"><span>注册显示</span></a></li>
<li><a href="#uch"><span>系统功能</span></a></li>
<li><a href="#name"><span>实名认证设置</span></a></li>
<li><a href="#video"><span>视频认证设置</span></a></li>
<li><a href="#upload"><span>上传图片设置</span></a></li>
<li><a href="#remote"><span>远程上传设置</span></a></li>
<li><a href="#email"><span>邮件设置</span></a></li>
</ul>
</div>

<form method="post" action="admincp.php?ac=config">
<input type="hidden" name="formhash" value="<?php echo formhash(); ?>" />

<div class="bdrcontent">

<table class="formtable">
<tr>
<th style="width:15em;">站点名称</th>
<td><input type="text" name="config[sitename]" value="<?=$configs['sitename']?>" size="50"></td>
</tr>
<tr>
<th>站点访问URL地址</th>
<td>
<input type="text" name="config[siteallurl]" value="<?=$configs['siteallurl']?>" size="50"><br>开启二级域名时需要使用，例如：http://u.discuz.net/ ，末尾要加“/”
</td>
</tr>
<tr>
<th>站点模板</th>
<td>
<select name="config[template]">
<?php if(is_array($templatearr)) { foreach($templatearr as $value) { ?>
<option value="<?=$value?>"<?=$templateselect[$value]?>><?=$value?></option>
<?php } } ?>
</select>
<br>站点模板目录存放在 ./template 下面。其中 default 目录为默认风格，不能删除。
</td>
</tr>
<tr>
<th>站点联系邮箱</th>
<td><input type="text" name="config[adminemail]" value="<?=$configs['adminemail']?>" size="50"></td>
</tr>
<tr>
<th>服务器时区设置</th>
<td>
<select name="config[timeoffset]">
<option value="-12" <?=$toselect['-12']?>>(GMT -12:00) Eniwetok, Kwajalein</option>
<option value="-11" <?=$toselect['-11']?>>(GMT -11:00) Midway Island, Samoa</option>
<option value="-10" <?=$toselect['-10']?>>(GMT -10:00) Hawaii</option>
<option value="-9" <?=$toselect['-9']?>>(GMT -09:00) Alaska</option>
<option value="-8" <?=$toselect['-8']?>>(GMT -08:00) Pacific Time (US &amp; Canada), Tijuana</option>
<option value="-7" <?=$toselect['-7']?>>(GMT -07:00) Mountain Time (US &amp; Canada), Arizona</option>
<option value="-6" <?=$toselect['-6']?>>(GMT -06:00) Central Time (US &amp; Canada), Mexico City</option>
<option value="-5" <?=$toselect['-5']?>>(GMT -05:00) Eastern Time (US &amp; Canada), Bogota, Lima, Quito</option>
<option value="-4" <?=$toselect['-4']?>>(GMT -04:00) Atlantic Time (Canada), Caracas, La Paz</option>
<option value="-3.5" <?=$toselect['-3.5']?>>(GMT -03:30) Newfoundland</option>
<option value="-3" <?=$toselect['-3']?>>(GMT -03:00) Brassila, Buenos Aires, Georgetown, Falkland Is</option>
<option value="-2" <?=$toselect['-2']?>>(GMT -02:00) Mid-Atlantic, Ascension Is., St. Helena</option>
<option value="-1" <?=$toselect['-1']?>>(GMT -01:00) Azores, Cape Verde Islands</option>
<option value="0"  <?=$toselect['0']?>>(GMT) Casablanca, Dublin, Edinburgh, London, Lisbon, Monrovia</option>
<option value="1" <?=$toselect['1']?>>(GMT +01:00) Amsterdam, Berlin, Brussels, Madrid, Paris, Rome</option>
<option value="2" <?=$toselect['2']?>>(GMT +02:00) Cairo, Helsinki, Kaliningrad, South Africa</option>
<option value="3" <?=$toselect['3']?>>(GMT +03:00) Baghdad, Riyadh, Moscow, Nairobi</option>
<option value="3.5" <?=$toselect['3.5']?>>(GMT +03:30) Tehran</option>
<option value="4" <?=$toselect['4']?>>(GMT +04:00) Abu Dhabi, Baku, Muscat, Tbilisi</option>
<option value="4.5" <?=$toselect['4.5']?>>(GMT +04:30) Kabul</option>
<option value="5" <?=$toselect['5']?>>(GMT +05:00) Ekaterinburg, Islamabad, Karachi, Tashkent</option>
<option value="5.5" <?=$toselect['5.5']?>>(GMT +05:30) Bombay, Calcutta, Madras, New Delhi</option>
<option value="5.75" <?=$toselect['5.75']?>>(GMT +05:45) Katmandu</option>
<option value="6" <?=$toselect['6']?>>(GMT +06:00) Almaty, Colombo, Dhaka, Novosibirsk</option>
<option value="6.5" <?=$toselect['6.5']?>>(GMT +06:30) Rangoon</option>
<option value="7" <?=$toselect['7']?>>(GMT +07:00) Bangkok, Hanoi, Jakarta</option>
<option value="8" <?=$toselect['8']?>>(GMT +08:00) Beijing, Hong Kong, Perth, Singapore, Taipei</option>
<option value="9" <?=$toselect['9']?>>(GMT +09:00) Osaka, Sapporo, Seoul, Tokyo, Yakutsk</option>
<option value="9.5" <?=$toselect['9.5']?>>(GMT +09:30) Adelaide, Darwin</option>
<option value="10" <?=$toselect['10']?>>(GMT +10:00) Canberra, Guam, Melbourne, Sydney, Vladivostok</option>
<option value="11" <?=$toselect['11']?>>(GMT +11:00) Magadan, New Caledonia, Solomon Islands</option>
<option value="12" <?=$toselect['12']?>>(GMT +12:00) Auckland, Wellington, Fiji, Marshall Island</option>
</select>
<br>根据服务器的时区配置进行选择，一般国内服务器为 GMT +08:00</td>
</tr>
<tr>
<th>显示授权信息链接</th>
<td>
<input type="radio" name="config[licensed]" value="1"<?php if($configs['licensed'] == '1') { ?> checked<?php } ?>>是
<input type="radio" name="config[licensed]" value="0"<?php if($configs['licensed'] != '1') { ?> checked<?php } ?>>否
</td>
</tr>

<tr>
<th>显示程序执行信息</th>
<td>
<input type="radio" name="config[debuginfo]" value="1"<?php if($configs['debuginfo'] == '1') { ?> checked<?php } ?>>是
<input type="radio" name="config[debuginfo]" value="0"<?php if($configs['debuginfo'] != '1') { ?> checked<?php } ?>>否
</td>
</tr>
<tr>
<th>ICP/IP/域名备案</th>
<td><input type="text" name="config[miibeian]" value="<?=$configs['miibeian']?>" size="20"> (例如 京ICP备04000001号，显示在所有页面的最下面)</td>
</tr>
<tr>
<th>强制使用默认字符集</th>
<td><input type="radio" name="config[headercharset]" value="1"<?php if($configs['headercharset'] == 1) { ?> checked<?php } ?>>是
<input type="radio" name="config[headercharset]" value="0"<?php if($configs['headercharset'] != '1') { ?> checked<?php } ?>>否
<br>可避免部分服务器空间页面出现乱码，一般无需开启</td>
</tr>
<tr>
<th>URL Rewrite</th>
<td>
<input type="radio" name="config[allowrewrite]" value="1"<?php if($configs['allowrewrite'] == '1') { ?> checked<?php } ?>>是
<input type="radio" name="config[allowrewrite]" value="0"<?php if($configs['allowrewrite'] != '1') { ?> checked<?php } ?>>否
<br>开启本功能需要对 Web 服务器增加相应的 Rewrite 规则
<br>且会轻微增加服务器负担，相应规则请参考帮助文档
</td>
</tr>
<tr>
<th style="width:15em;">记录在线时间</th>
<td><input type="text" name="config[onlinehold]" value="<?=$configs['onlinehold']?>" size="5"> (单位 秒)</td>
</tr>

<tr>
<th>开启站点概况统计</th>
<td>
<input type="radio" name="config[updatestat]" value="1"<?php if($configs['updatestat'] == '1') { ?> checked<?php } ?>>是
<input type="radio" name="config[updatestat]" value="0"<?php if($configs['updatestat'] != '1') { ?> checked<?php } ?>>否
<br>建议开启，记录站点每日的登录人数、发表数、互动数等重点参数，可为站点运营发展提供重要数据依据
</td>
</tr>

<tr>
<th>用户头像体系</th>
<td>
<input type="radio" name="config[avatarreal]" value="0"<?php if($configs['avatarreal'] != '1') { ?> checked<?php } ?>>使用头像体系1
<input type="radio" name="config[avatarreal]" value="1"<?php if($configs['avatarreal'] == '1') { ?> checked<?php } ?>>使用头像体系2
<br>UCenter用户头像分为两套体系(默认为体系1)，您可以选择在本系统内使用的头像体系，而在其他应用（比如Discuz!论坛）中使用相同或者不同的头像体系。<br>注意：修改本选项后，用户需要上传与体系对应的新头像。
</td>
</tr>

<tr>
<th>UCenter的物理路径</th>
<td><input type="text" name="config[uc_dir]" value="<?=$configs['uc_dir']?>" size="40">
<br>默认为空。如果本系统可以读取UCenter的程序目录，推荐填写该路径值。
<br>请输入以 “./” “../”开头的相对路径，或者绝对路径，末尾加 "/"，例如填写：../ucenter/。
</td>
</tr>

<tr>
<th>MYOP的IP</th>
<td><input type="text" name="config[my_ip]" value="<?=$configs['my_ip']?>" size="40">
<br>默认为空。如果您的服务器因DNS解析问题无法使用MYOP服务，请填写MYOP的IP地址。
</td>
</tr>

<tr>
<th>站点关闭访问</th>
<td>
<input type="radio" name="config[close]" value="1"<?php if($configs['close'] == '1') { ?> checked<?php } ?>>是
<input type="radio" name="config[close]" value="0"<?php if($configs['close'] != '1') { ?> checked<?php } ?>>否
</td>
</tr>
<tr>
<th>站点关闭说明</th>
<td>
<textarea name="config[closereason]" cols="80" rows="4"><?=$configs['closereason']?></textarea>
</td>
</tr>
<tr>
<th>举报可选理由</th>
<td>
<textarea name="dataset[reason]" cols="80" rows="4"><?=$datasets['reason']?></textarea>
<br>预设举报可选理由，每行一个
</td>
</tr>

</table>

<br />
<div class="title" id="register">
<a class="r_option" href="javascript:;" onclick="window.scrollTo(0,0);" id="a_top" title="TOP">TOP</a>
<h3>注册和显示</h3>
</div>
<table class="formtable">
<tr>
<th style="width:15em;">关闭新用户注册</th>
<td>
<input type="radio" name="config[closeregister]" value="1"<?php if($configs['closeregister'] == '1') { ?> checked<?php } ?>>是
<input type="radio" name="config[closeregister]" value="0"<?php if($configs['closeregister'] != '1') { ?> checked<?php } ?>>否
</td>
</tr>
<tr>
<th>关闭邀请注册功能</th>
<td>
<input type="radio" name="config[closeinvite]" value="1"<?php if($configs['closeinvite'] == '1') { ?> checked<?php } ?>>是
<input type="radio" name="config[closeinvite]" value="0"<?php if($configs['closeinvite'] != '1') { ?> checked<?php } ?>>否
</td>
</tr>
<tr>
<th>一个邮箱只能注册一个账号</th>
<td>
<input type="radio" name="config[checkemail]" value="1"<?php if($configs['checkemail'] == '1') { ?> checked<?php } ?>>是
<input type="radio" name="config[checkemail]" value="0"<?php if($configs['checkemail'] != '1') { ?> checked<?php } ?>>否
</td>
</tr>
<tr>
<th>同一IP注册时间间隔</th>
<td>
<input type="text" name="config[regipdate]" value="<?=$configs['regipdate']?>" size="5"> (单位：小时)
<br>限制同一个ip，在多长时间内只能注册一个账号
</td>
</tr>
<tr>
<th>注册服务条款</th>
<td>
<textarea name="dataset[registerrule]" cols="80" rows="4"><?=$datasets['registerrule']?></textarea>
<br>用户注册的时候会显示并需要接受的服务条款。（支持html语言，换行使用&lt;br&gt;）
</td>
</tr>
<tr>
<th>列表最大分页数</th>
<td><input type="text" name="config[maxpage]" value="<?=$configs['maxpage']?>" size="5"> (默认为 100)<br>允许用户查看的最大分页数。当用户查看的分页数越大的时候，对服务器的负载压力就越大。</td>
</tr>
<tr>
<th>动态保留天数</th>
<td><input type="text" name="config[feedday]" value="<?=$configs['feedday']?>" size="5"> (默认为 7)<br>个人动态的保留天数。超过该天数的个人动态会被清理掉，从而可以保证MySQL的效率。建议不要设置太长。</td>
</tr>
<tr>
<th>首页动态显示数</th>
<td><input type="text" name="config[feedmaxnum]" value="<?=$configs['feedmaxnum']?>" size="5"> (默认为 100)<br>首页显示的好友动态将从这些数目的事件中进行合并显示。建议不要设置太多，从而可以保证MySQL的效率，但最少不能低于50。</td>
</tr>
<tr>
<th>首页动态默认标签设置</th>
<td>
好友数小于 <input type="text" name="config[showallfriendnum]" value="<?=$configs['showallfriendnum']?>" size="5"> 个的时候显示所有人的动态，超过这个数值显示好友动态。<br>在日志、相册列表页面，该参数同样生效。
</td>
</tr>
<tr>
<th>首页动态折叠设置</th>
<td>
<input type="text" name="config[feedhiddenicon]" value="<?=$configs['feedhiddenicon']?>" size="60"><br>
请输入要折叠显示的动态类型（icon），多个类型之间用半角逗号 "," 隔开。<br>
将某些动态折叠后，可以适当减少首页的动态噪音。<br>
动态类型的获取方法：<br>
在查看好友动态的时候，点击每条动态前面的小图标（例如 <img src="image/icon/blog.gif" align="absmiddle">），<br>
浏览器的网址会变为类似如下的链接：<br>
http://xxx.com/space.php?uid=&do=feed&view=we&appid=3&<b>icon=blog</b>，<br>
其中，icon=blog，就表示该动态类型为 blog<br>
MYOP应用的icon为 7位数字。你可以用英文单词 <b>myop</b> 来表示所有MYOP应用的动态类型。
</td>
</tr>
<tr>
<th>首页显示热点的数目</th>
<td><input type="text" name="config[feedhotnum]" value="<?=$configs['feedhotnum']?>" size="5"> (默认为 3)<br>为0，则首页不显示热点推荐。最大不要超过10个。<br>系统会自动获取10个热点，其中，排名第一的热点会固定显示，其余热点会随机显示。</td>
</tr>

<tr>
<th>首页欢迎新成员选项</th>
<td>
显示 <input type="text" name="config[newspacenum]" value="<?=$configs['newspacenum']?>" size="5"> 个新成员(0为不显示)<br>
显示的新成员条件:<br>
<input type="checkbox" name="config[newspaceavatar]" value="1"<?php if($configs['newspaceavatar']) { ?> checked<?php } ?>> 已经上传头像<br>
<?php if($_SCONFIG['realname']) { ?>
<input type="checkbox" name="config[newspacerealname]" value="1"<?php if($configs['newspacerealname']) { ?> checked<?php } ?>> 已经实名认证<br>
<?php } ?>
<?php if($_SCONFIG['videophoto']) { ?>
<input type="checkbox" name="config[newspacevideophoto]" value="1"<?php if($configs['newspacevideophoto']) { ?> checked<?php } ?>> 已经视频认证
<?php } ?>
</td>
</tr>

<tr>
<th>热点推荐的天数范围</th>
<td><input type="text" name="config[feedhotday]" value="<?=$configs['feedhotday']?>" size="5"> (单位天，默认为 2天)<br>设置首页热点推荐选择的天数范围。</td>
</tr>
<tr>
<th>热点推荐的最小热度值</th>
<td><input type="text" name="config[feedhotmin]" value="<?=$configs['feedhotmin']?>" size="5"> <br>设置当发布的信息热度值超过多少后，才会显示在推荐里面。</td>
</tr>
<tr>
<th>动态链接打开模式</th>
<td>
<input type="radio" name="config[feedtargetblank]" value="1"<?php if($configs['feedtargetblank'] == '1') { ?> checked<?php } ?>>新窗口打开
<input type="radio" name="config[feedtargetblank]" value="0"<?php if($configs['feedtargetblank'] != '1') { ?> checked<?php } ?>>同一窗口打开
<br>如果选择是，用户阅读动态的时候，所有的链接都会在新窗口打开。
</td>
</tr>
<tr>
<th>记录动态阅读状态</th>
<td>
<input type="radio" name="config[feedread]" value="1"<?php if($configs['feedread'] == '1') { ?> checked<?php } ?>>是
<input type="radio" name="config[feedread]" value="0"<?php if($configs['feedread'] != '1') { ?> checked<?php } ?>>否
<br>如果选择是，该条动态被点击的时候，会变成灰色，以表示已经阅读。(注意，该功能对热点动态无效)
</td>
</tr>
<tr>
<th>关闭MYOP的更新提示</th>
<td>
<input type="radio" name="config[my_closecheckupdate]" value="1"<?php if($configs['my_closecheckupdate'] == '1') { ?> checked<?php } ?>>是
<input type="radio" name="config[my_closecheckupdate]" value="0"<?php if($configs['my_closecheckupdate'] != '1') { ?> checked<?php } ?>>否
<br>您的站点开启了MYOP多应用服务后，当平台有了新的信息的时候MYOP会自动提示给管理员。关闭本功能后，您将不再获取更新提示。
</td>
</tr>

<tr>
<th>首页调用推荐礼物提示</th>
<td>
<input type="radio" name="config[my_showgift]" value="1"<?php if($configs['my_showgift'] == '1') { ?> checked<?php } ?>>是
<input type="radio" name="config[my_showgift]" value="0"<?php if($configs['my_showgift'] != '1') { ?> checked<?php } ?>>否
<br>如果您开启了MYOP平台的礼物应用后，可以在首页显示“推荐礼物”。
</td>
</tr>

<tr>
<th>成员排行榜允许分页浏览</th>
<td>
<input type="radio" name="config[networkpage]" value="1"<?php if($configs['networkpage']==1) { ?> checked<?php } ?>>是
<input type="radio" name="config[networkpage]" value="0"<?php if($configs['networkpage'] != '1') { ?> checked<?php } ?>>否
<br>该设置只对排行榜中的竞价排行、在线成员、全部成员有效。
</td>
</tr>


<tr>
<th>成员排行榜缓存时间</th>
<td>
<input type="text" name="config[topcachetime]" value="<?=$configs['topcachetime']?>" size="5"> (单位分钟)
<br>用户排行榜中，除竞价排行、在线成员、全部成员外，其余排行榜是缓存处理的。
<br>请根据服务器的负载情况，设置合理的更新时间间隔。最少不能低于5分钟。
</td>
</tr>

<tr>
<th>外部链接显示导航条</th>
<td>
<input type="radio" name="config[linkguide]" value="1"<?php if($configs['linkguide']==1) { ?> checked<?php } ?>>是
<input type="radio" name="config[linkguide]" value="0"<?php if($configs['linkguide'] != '1') { ?> checked<?php } ?>>否
</td>
</tr>
<tr>
<th>星星经验阀值</th>
<td><input type="text" name="config[starcredit]" value="<?=$configs['starcredit']?>" size="5"> (默认为 100)<br>当用户经验数到此阀值时，增加一个星星。最小为2，否则此功能无效，不显示星星数。</td>
</tr>
<tr>
<th>星星升级阀值</th>
<td><input type="text" name="config[starlevelnum]" value="<?=$configs['starlevelnum']?>" size="5"> (默认为 5)<br>星星数在达到此阀值时，会升级为高级别的图标。最小为2，否则此项功能无效，始终以星星显示</td>
</tr>
</table>

<br />
<div class="title" id="uch">
<a class="r_option" href="javascript:;" onclick="window.scrollTo(0,0);" id="a_top" title="TOP">TOP</a>
<h3>系统功能</h3>
</div>
<table class="formtable">
<tr>
<th style="width:15em;">好友用户组个数</th>
<td><input type="text" name="config[groupnum]" value="<?=$configs['groupnum']?>" size="5"> (默认为 8)
<br>设置每个用户最多拥有的好友用户组个数。
</td>
</tr>
<tr>
<th>日志单次导入最大数</th>
<td><input type="text" name="config[importnum]" value="<?=$configs['importnum']?>" size="5"> (默认 100)<br>允许用户单次导入日志的条数</td>
</tr>
<tr>
<th>投票单次最高悬赏</th>
<td><input type="text" name="config[maxreward]" value="<?=$configs['maxreward']?>" size="5"> (默认 10)<br>允许用户创建悬赏投票时平均单次投票悬赏额度</td>
</tr>
<tr>
<th>邮件通知更新天数</th>
<td><input type="text" name="config[sendmailday]" value="<?=$configs['sendmailday']?>" size="5">(默认 0)<br> 单位：天，当用户多少天没有登陆站点的时候才会给其发送邮件通知；<br>设置为0，则不启用邮件通知功能；<br>启用本功能将会轻微增加服务器负载</td>
</tr>
<tr>
<th>开启XMLPRC协议接口</th>
<td>
<input type="radio" name="config[openxmlrpc]" value="1"<?php if($configs['openxmlrpc'] == '1') { ?> checked<?php } ?>>是
<input type="radio" name="config[openxmlrpc]" value="0"<?php if($configs['openxmlrpc'] != '1') { ?> checked<?php } ?>>否
<br>用户可以通过本协议接口，使用客户端发布日志。但是，也可能会增加恶意灌水的可能。
</td>
</tr>
<tr>
<th>UCenter应用标签相关信息</th>
<td>
<table>
<tr>
<td width="150">是否启用</td>
<td>
<input type="radio" name="config[uc_tagrelated]" value="1"<?php if($configs['uc_tagrelated'] == '1') { ?> checked<?php } ?>>是
<input type="radio" name="config[uc_tagrelated]" value="0"<?php if($configs['uc_tagrelated'] != '1') { ?> checked<?php } ?>>否
<br>开启本功能，则系统会通过UCenter，获取到站内其他应用的标签相关信息
<br>否则，只显示本站内的标签相关日志
</td>
</tr>
<tr>
<td>缓存更新间隔</td>
<td>
<input type="text" name="config[uc_tagrelatedtime]" value="<?=$configs['uc_tagrelatedtime']?>" size="10"> (单位:秒, 默认为: 86400 即，24小时)
<br>设置标签关联信息多长时间更新一次，建议设置1小时（3600秒）以上，减轻对服务器的压力。为0则不更新。
</td>
</tr>
</table>
</td>
</tr>

<tr>
<th>模块缓存</th>
<td>
<table>
<tr>
<td width="150">是否启用</td>
<td><input type="radio" name="config[allowcache]" value="1"<?php if($configs['allowcache'] == 1) { ?> checked<?php } ?>>是
<input type="radio" name="config[allowcache]" value="0"<?php if($configs['allowcache'] != '1') { ?> checked<?php } ?>>否
<br>推荐开启，这样在使用模块调用数据的时候，可以大幅度降低MYSQL服务器负载
</td></tr>
<tr>
<td>缓存模式</td>
<td>
<input type="radio" name="config[cachemode]" value="file"<?php if($configs['cachemode'] == 'file') { ?> checked<?php } ?>>存储到文本
<input type="radio" name="config[cachemode]" value="database"<?php if($configs['cachemode'] == 'database') { ?> checked<?php } ?>>存储到数据库
</td></tr>
<tr>
<td>缓存分表等级</td>
<td>
<select name="config[cachegrade]">
<option value="0"<?php if($configs['cachegrade'] == '0') { ?> selected<?php } ?>>只用一个表(或目录)</option>
<option value="1"<?php if($configs['cachegrade'] == '1') { ?> selected<?php } ?>>分散到15个子表(或目录)</option>
<option value="2"<?php if($configs['cachegrade'] == '2') { ?> selected<?php } ?>>分散到225个子表(或目录)</option>
</select>
<br>分表(或目录)越多效率越高，但建立的数据表(或目录)越多
</td></tr>
</table>
</td>
</tr>

<tr>
<th>二级域名功能</th>
<td>
<table>
<tr>
<td width="150">是否启用</td>
<td>
<input type="radio" name="config[allowdomain]" value="1"<?php if($configs['allowdomain'] == '1') { ?> checked<?php } ?>>是
<input type="radio" name="config[allowdomain]" value="0"<?php if($configs['allowdomain'] != '1') { ?> checked<?php } ?>>否
<br>二级域名功能需要服务器配置支持
</td></tr>
<tr>
<td>保留二级域名</td><td>
<input type="text" name="config[holddomain]" value="<?=$configs['holddomain']?>" size="50">
<br>多个之间用 | 隔开，可以使用通配符*
</td></tr>
<tr>
<td>二级域名根域名</td>
<td>
<input type="text" name="config[domainroot]" value="<?=$configs['domainroot']?>" size="50">
</td></tr>
</table>
</td>
</tr>

</table>


<br />
<div class="title" id="name">
<a class="r_option" href="javascript:;" onclick="window.scrollTo(0,0);" id="a_top" title="TOP">TOP</a>
<h3>实名认证设置</h3>
</div>

<table class="formtable">
<tr>
<th style="width:15em;">开启实名</th>
<td><input type="radio" name="config[realname]" value="1"<?php if($configs['realname'] == '1') { ?> checked<?php } ?>>是
<input type="radio" name="config[realname]" value="0"<?php if($configs['realname'] != '1') { ?> checked<?php } ?>>否
<br>以下设置只有在开启实名机制后有效；
<br>注意，开启实名认证会增加服务器负担。
</td>
</tr>
<tr>
<th>实名需手工认证</th>
<td><input type="radio" name="config[namecheck]" value="1"<?php if($configs['namecheck'] == '1') { ?> checked<?php } ?>>是
<input type="radio" name="config[namecheck]" value="0"<?php if($configs['namecheck'] != '1') { ?> checked<?php } ?>>否
<br>设置为“是”，则用户填写的姓名只有在被管理者手工认证后才算有效。否则，则自动为认证有效。
</td>
</tr>
<tr>
<th>认证实名可再修改</th>
<td><input type="radio" name="config[namechange]" value="1"<?php if($configs['namechange'] == '1') { ?> checked<?php } ?>>是
<input type="radio" name="config[namechange]" value="0"<?php if($configs['namechange'] != '1') { ?> checked<?php } ?>>否
<br>填写的姓名经认证有效后，是否允许用户再次修改姓名。<br>如果允许修改且手工认证，那么用户修改的新姓名需要再次手工认证后方可有效。
</td>
</tr>
<tr>
<th>未认证实名权限</th>
<td>
<table>
<tr>
<td width="150">允许查看实名用户主页</td>
<td>
<input type="radio" name="config[name_allowviewspace]" value="1"<?php if($configs['name_allowviewspace'] == 1) { ?> checked<?php } ?>>是
<input type="radio" name="config[name_allowviewspace]" value="0"<?php if($configs['name_allowviewspace'] != '1') { ?> checked<?php } ?>>否
</td></tr>
<tr>
<td width="150">允许加好友</td>
<td>
<input type="radio" name="config[name_allowfriend]" value="1"<?php if($configs['name_allowfriend'] == 1) { ?> checked<?php } ?>>是
<input type="radio" name="config[name_allowfriend]" value="0"<?php if($configs['name_allowfriend'] != '1') { ?> checked<?php } ?>>否
</td></tr>
<tr>
<td width="150">允许打招呼</td>
<td>
<input type="radio" name="config[name_allowpoke]" value="1"<?php if($configs['name_allowpoke'] == 1) { ?> checked<?php } ?>>是
<input type="radio" name="config[name_allowpoke]" value="0"<?php if($configs['name_allowpoke'] != '1') { ?> checked<?php } ?>>否
</td></tr>
<tr>
<td width="150">允许发记录</td>
<td>
<input type="radio" name="config[name_allowdoing]" value="1"<?php if($configs['name_allowdoing'] == 1) { ?> checked<?php } ?>>是
<input type="radio" name="config[name_allowdoing]" value="0"<?php if($configs['name_allowdoing'] != '1') { ?> checked<?php } ?>>否
</td></tr>
<tr>
<td width="150">允许发日志</td>
<td>
<input type="radio" name="config[name_allowblog]" value="1"<?php if($configs['name_allowblog'] == 1) { ?> checked<?php } ?>>是
<input type="radio" name="config[name_allowblog]" value="0"<?php if($configs['name_allowblog'] != '1') { ?> checked<?php } ?>>否
</td></tr>
<tr>
<td width="150">允许使用相册</td>
<td>
<input type="radio" name="config[name_allowalbum]" value="1"<?php if($configs['name_allowalbum'] == 1) { ?> checked<?php } ?>>是
<input type="radio" name="config[name_allowalbum]" value="0"<?php if($configs['name_allowalbum'] != '1') { ?> checked<?php } ?>>否
</td></tr>
<tr>
<td width="150">允许发话题</td>
<td>
<input type="radio" name="config[name_allowthread]" value="1"<?php if($configs['name_allowthread'] == 1) { ?> checked<?php } ?>>是
<input type="radio" name="config[name_allowthread]" value="0"<?php if($configs['name_allowthread'] != '1') { ?> checked<?php } ?>>否
</td></tr>
<tr>
<td width="150">允许发投票</td>
<td>
<input type="radio" name="config[name_allowpoll]" value="1"<?php if($configs['name_allowpoll'] == 1) { ?> checked<?php } ?>>是
<input type="radio" name="config[name_allowpoll]" value="0"<?php if($configs['name_allowpoll'] != '1') { ?> checked<?php } ?>>否
</td></tr>
<tr>
<td width="150">允许发活动</td>
<td>
<input type="radio" name="config[name_allowevent]" value="1"<?php if($configs['name_allowevent'] == 1) { ?> checked<?php } ?>>是
<input type="radio" name="config[name_allowevent]" value="0"<?php if($configs['name_allowevent'] != '1') { ?> checked<?php } ?>>否
</td></tr>
<tr>
<td width="150">允许分享</td>
<td>
<input type="radio" name="config[name_allowshare]" value="1"<?php if($configs['name_allowshare'] == 1) { ?> checked<?php } ?>>是
<input type="radio" name="config[name_allowshare]" value="0"<?php if($configs['name_allowshare'] != '1') { ?> checked<?php } ?>>否
</td></tr>
<tr>
<td width="150">允许留言/评论</td>
<td>
<input type="radio" name="config[name_allowcomment]" value="1"<?php if($configs['name_allowcomment'] == 1) { ?> checked<?php } ?>>是
<input type="radio" name="config[name_allowcomment]" value="0"<?php if($configs['name_allowcomment'] != '1') { ?> checked<?php } ?>>否
</td></tr>
<tr>
<td width="150">允许群组回帖</td>
<td>
<input type="radio" name="config[name_allowpost]" value="1"<?php if($configs['name_allowpost'] == 1) { ?> checked<?php } ?>>是
<input type="radio" name="config[name_allowpost]" value="0"<?php if($configs['name_allowpost'] != '1') { ?> checked<?php } ?>>否
</td></tr>
<tr>
<td width="150">允许使用MYOP应用</td>
<td>
<input type="radio" name="config[name_allowuserapp]" value="1"<?php if($configs['name_allowuserapp'] == 1) { ?> checked<?php } ?>>是
<input type="radio" name="config[name_allowuserapp]" value="0"<?php if($configs['name_allowuserapp'] != '1') { ?> checked<?php } ?>>否
</td></tr>
</table>
</td>
</tr>
</table>


<br />
<div class="title" id="video">
<a class="r_option" href="javascript:;" onclick="window.scrollTo(0,0);" id="a_top" title="TOP">TOP</a>
<h3>视频认证设置</h3>
</div>

<table class="formtable">
<tr>
<th style="width:15em;">开启视频认证</th>
<td>
<?php if($_SCONFIG['my_status']) { ?>
<input type="radio" name="config[videophoto]" value="1"<?php if($configs['videophoto'] == '1') { ?> checked<?php } ?>>是
<input type="radio" name="config[videophoto]" value="0"<?php if($configs['videophoto'] != '1') { ?> checked<?php } ?>>否
<?php } else { ?>
您没有开启MYOP，所以无法使用视频认证功能
<?php } ?>
<br>以下设置只有在开启视频认证后有效
</td>
</tr>
<tr>
<th>未视频认证用户权限</th>
<td>
<table>
<tr>
<td width="150">允许查看视频用户的照片</td>
<td>
<input type="radio" name="config[video_allowviewphoto]" value="1"<?php if($configs['video_allowviewphoto'] == 1) { ?> checked<?php } ?>>是
<input type="radio" name="config[video_allowviewphoto]" value="0"<?php if($configs['video_allowviewphoto'] != '1') { ?> checked<?php } ?>>否
</td></tr>
<tr>
<td width="150">允许加视频用户为好友</td>
<td>
<input type="radio" name="config[video_allowfriend]" value="1"<?php if($configs['video_allowfriend'] == 1) { ?> checked<?php } ?>>是
<input type="radio" name="config[video_allowfriend]" value="0"<?php if($configs['video_allowfriend'] != '1') { ?> checked<?php } ?>>否
</td></tr>
<tr>
<td width="150">允许向视频用户打招呼</td>
<td>
<input type="radio" name="config[video_allowpoke]" value="1"<?php if($configs['video_allowpoke'] == 1) { ?> checked<?php } ?>>是
<input type="radio" name="config[video_allowpoke]" value="0"<?php if($configs['video_allowpoke'] != '1') { ?> checked<?php } ?>>否
</td></tr>

<tr>
<td width="150">允许向视频用户留言</td>
<td>
<input type="radio" name="config[video_allowwall]" value="1"<?php if($configs['video_allowwall'] == 1) { ?> checked<?php } ?>>是
<input type="radio" name="config[video_allowwall]" value="0"<?php if($configs['video_allowwall'] != '1') { ?> checked<?php } ?>>否
</td></tr>

<tr>
<td width="150">允许向视频用户评论</td>
<td>
<input type="radio" name="config[video_allowcomment]" value="1"<?php if($configs['video_allowcomment'] == 1) { ?> checked<?php } ?>>是
<input type="radio" name="config[video_allowcomment]" value="0"<?php if($configs['video_allowcomment'] != '1') { ?> checked<?php } ?>>否
</td></tr>

<tr>
<td width="150">允许发记录</td>
<td>
<input type="radio" name="config[video_allowdoing]" value="1"<?php if($configs['video_allowdoing'] == 1) { ?> checked<?php } ?>>是
<input type="radio" name="config[video_allowdoing]" value="0"<?php if($configs['video_allowdoing'] != '1') { ?> checked<?php } ?>>否
</td></tr>
<tr>
<td width="150">允许发日志</td>
<td>
<input type="radio" name="config[video_allowblog]" value="1"<?php if($configs['video_allowblog'] == 1) { ?> checked<?php } ?>>是
<input type="radio" name="config[video_allowblog]" value="0"<?php if($configs['video_allowblog'] != '1') { ?> checked<?php } ?>>否
</td></tr>
<tr>
<td width="150">允许使用相册</td>
<td>
<input type="radio" name="config[video_allowalbum]" value="1"<?php if($configs['video_allowalbum'] == 1) { ?> checked<?php } ?>>是
<input type="radio" name="config[video_allowalbum]" value="0"<?php if($configs['video_allowalbum'] != '1') { ?> checked<?php } ?>>否
</td></tr>
<tr>
<td width="150">允许发话题</td>
<td>
<input type="radio" name="config[video_allowthread]" value="1"<?php if($configs['video_allowthread'] == 1) { ?> checked<?php } ?>>是
<input type="radio" name="config[video_allowthread]" value="0"<?php if($configs['video_allowthread'] != '1') { ?> checked<?php } ?>>否
</td></tr>
<tr>
<td width="150">允许发投票</td>
<td>
<input type="radio" name="config[video_allowpoll]" value="1"<?php if($configs['video_allowpoll'] == 1) { ?> checked<?php } ?>>是
<input type="radio" name="config[video_allowpoll]" value="0"<?php if($configs['video_allowpoll'] != '1') { ?> checked<?php } ?>>否
</td></tr>
<tr>
<td width="150">允许发活动</td>
<td>
<input type="radio" name="config[video_allowevent]" value="1"<?php if($configs['video_allowevent'] == 1) { ?> checked<?php } ?>>是
<input type="radio" name="config[video_allowevent]" value="0"<?php if($configs['video_allowevent'] != '1') { ?> checked<?php } ?>>否
</td></tr>
<tr>
<td width="150">允许分享</td>
<td>
<input type="radio" name="config[video_allowshare]" value="1"<?php if($configs['video_allowshare'] == 1) { ?> checked<?php } ?>>是
<input type="radio" name="config[video_allowshare]" value="0"<?php if($configs['video_allowshare'] != '1') { ?> checked<?php } ?>>否
</td></tr>
<tr>
<td width="150">允许群组回帖</td>
<td>
<input type="radio" name="config[video_allowpost]" value="1"<?php if($configs['video_allowpost'] == 1) { ?> checked<?php } ?>>是
<input type="radio" name="config[video_allowpost]" value="0"<?php if($configs['video_allowpost'] != '1') { ?> checked<?php } ?>>否
</td></tr>
<tr>
<td width="150">允许使用MYOP应用</td>
<td>
<input type="radio" name="config[video_allowuserapp]" value="1"<?php if($configs['video_allowuserapp'] == 1) { ?> checked<?php } ?>>是
<input type="radio" name="config[video_allowuserapp]" value="0"<?php if($configs['video_allowuserapp'] != '1') { ?> checked<?php } ?>>否
</td></tr>
</table>
</td>
</tr>
</table>


<br />
<div class="title" id="upload">
<a class="r_option" href="javascript:;" onclick="window.scrollTo(0,0);" id="a_top" title="TOP">TOP</a>
<h3>上传图片设置</h3>
</div>

<table class="formtable">
<tr>
<th style="width:15em;">预览缩略图大小</th>
<td>宽<input type="text" name="data[thumbwidth]" value="<?=$datas['thumbwidth']?>" size="5">px &nbsp;
高<input type="text" name="data[thumbheight]" value="<?=$datas['thumbheight']?>" size="5">px
<br>本功能需要PHP环境支持GD才生效
<br>缩略图按原图比例缩小，宽高不会超过本设定。比如设置为 宽：100px，高：100px，但都不能小于60px</td>
</tr>
<tr>
<th style="width:15em;">图片最大尺寸</th>
<td>宽<input type="text" name="data[maxthumbwidth]" value="<?=$datas['maxthumbwidth']?>" size="5">px &nbsp;
高<input type="text" name="data[maxthumbheight]" value="<?=$datas['maxthumbheight']?>" size="5">px
<br>本功能需要PHP环境支持GD才生效
<br>如果用户上传一些尺寸很大的数码图片，则程序会按照本设置进行缩小该图片并显示，比如可以设置为 宽：1024px，高：768px，但都不能小于300px。设置为0，则不做任何处理。</td>
</tr>
<tr>
<th>图片水印</th>
<td>
<table>
<tr>
<td width="150">是否启用</td>
<td>
<input type="radio" name="config[allowwatermark]" value="1"<?php if($configs['allowwatermark'] == 1) { ?> checked<?php } ?>>是
<input type="radio" name="config[allowwatermark]" value="0"<?php if($configs['allowwatermark'] != '1') { ?> checked<?php } ?>>否
<br>本功能需要PHP环境支持GD才生效
<br>注意，开启水印功能后，图片的EXIF信息将无法获取
</td></tr>
<tr>
<td>水印图片地址</td>
<td>
<input type="text" name="data[watermarkfile]" value="<?=$datas['watermarkfile']?>">
<br>默认为image/watermark.png，只支持JPG/GIF/PNG格式，推荐用透明的png图片
</td></tr>
<tr>
<td>水印位置</td>
<td>
<input type="radio" name="data[watermarkpos]" value="1"<?php if($datas['watermarkpos'] == 1) { ?> checked<?php } ?>>顶端居左
<input type="radio" name="data[watermarkpos]" value="2"<?php if($datas['watermarkpos'] == 2) { ?> checked<?php } ?>>顶端居右
<input type="radio" name="data[watermarkpos]" value="3"<?php if($datas['watermarkpos'] == 3) { ?> checked<?php } ?>>底端居左
<input type="radio" name="data[watermarkpos]" value="4"<?php if($datas['watermarkpos'] == 4) { ?> checked<?php } ?>>底端居右
</td></tr>
</table>
</td>
</tr>
</table>

<br />
<div class="title" id="remote">
<a class="r_option" href="javascript:;" onclick="window.scrollTo(0,0);" id="a_top" title="TOP">TOP</a>
<h3>远程上传设置</h3>
</div>

<table class="formtable">
<tr>
<th style="width:15em;">启用远程附件</th>
<td><input type="radio" name="config[allowftp]" value="1"<?php if($configs['allowftp'] == 1) { ?> checked<?php } ?>>是
<input type="radio" name="config[allowftp]" value="0"<?php if($configs['allowftp'] != '1') { ?> checked<?php } ?>>否
</td>
</tr>
<tr>
<th>启用 SSL 连接</th>
<td>
<input type="radio" name="data[ftpssl]" value="1"<?php if($datas['ftpssl'] == 1) { ?> checked<?php } ?>>是
<input type="radio" name="data[ftpssl]" value="0"<?php if($datas['ftpssl'] != '1') { ?> checked<?php } ?>>否
</td>
</tr>
<tr>
<th>FTP连接信息</th>
<td>
<table>
<tr><td width="150">FTP 服务器地址</td>
<td><input type="text" name="data[ftphost]" value="<?=$datas['ftphost']?>"> (FTP 服务器的 IP 地址或域名)</td>
</tr>
<tr><td>FTP 服务器端口</td>
<td><input type="text" name="data[ftpport]" value="<?=$datas['ftpport']?>" size="5"> (默认为 21)</td>
</tr>
<tr><td>FTP 帐号</td>
<td><input type="text" name="data[ftpuser]" value="<?=$datas['ftpuser']?>"></td>
</tr>
<tr><td>FTP 密码</td>
<td><input type="password" name="data[ftppassword]" value="<?=$datas['ftppassword']?>"></td>
</tr>
<tr><td>被动模式(pasv)连接</td>
<td><input type="radio" name="data[ftppasv]" value="1"<?php if($datas['ftppasv'] == 1) { ?> checked<?php } ?>>是
<input type="radio" name="data[ftppasv]" value="0"<?php if($datas['ftppasv'] != '1') { ?> checked<?php } ?>>否 (一般情况下非被动模式即可)</td>
</tr>
<tr><td>远程附件目录</td>
<td><input type="text" name="data[ftpdir]" value="<?=$datas['ftpdir']?>">
<br>远程附件目录的绝对路径或相对于 FTP 主目录的相对路径<br>“.”表示 FTP 主目录，例如填写：./attachment</td>
</tr>
<tr><td>远程访问 URL</td>
<td><input type="text" name="config[ftpurl]" value="<?=$configs['ftpurl']?>">
<br>支持 HTTP 和 FTP 协议，结尾要加斜杠“/”</td>
</tr>
<tr><td>FTP 传输超时时间</td>
<td><input type="text" name="data[ftptimeout]" value="<?=$datas['ftptimeout']?>" size="5"> (单位：秒，0 为服务器默认)</td>
</tr>
</table>
</td>
</tr>
</table>


<br />
<div class="title" id="email">
<a class="r_option" href="javascript:;" onclick="window.scrollTo(0,0);" id="a_top" title="TOP">TOP</a>
<h3>邮件设置</h3>
</div>

<table class="formtable">
<tr>
<th style="width:15em;">邮件发送方式</th>
<td><input class="radio" name="mail[mailsend]" value="1"<?php if($mails['mailsend'] == 1) { ?> checked<?php } ?> onclick="$('tb_smtp1').style.display = 'none';$('tb_smtp2').style.display = 'none';" type="radio"> 通过 PHP 函数的 sendmail 发送(推荐此方式)<br>
<input class="radio" name="mail[mailsend]" value="2"<?php if($mails['mailsend'] == 2) { ?> checked<?php } ?> onclick="$('tb_smtp1').style.display = '';$('tb_smtp2').style.display = '';" type="radio"> 通过 SOCKET 连接 SMTP 服务器发送(支持 ESMTP 验证)<br>
<input class="radio" name="mail[mailsend]" value="3"<?php if($mails['mailsend'] == 3) { ?> checked<?php } ?> onclick="$('tb_smtp1').style.display = '';$('tb_smtp2').style.display = 'none';" type="radio"> 通过 PHP 函数 SMTP 发送 Email(仅 Windows 主机下有效, 不支持 ESMTP 验证)
</td>
</tr><tr>
<th>邮件头的分隔符</th>
<td><input class="radio" name="mail[maildelimiter]" value="0"<?php if($mails['maildelimiter'] == 0) { ?> checked<?php } ?> type="radio"> 使用 LF 作为分隔符(通常为 Unix/Linux 主机)<br>
<input class="radio" name="mail[maildelimiter]" value="1"<?php if($mails['maildelimiter'] == 1) { ?> checked<?php } ?> type="radio"> 使用 CRLF 作为分隔符(通常为 Windows 主机)<br>
<input class="radio" name="mail[maildelimiter]" value="2"<?php if($mails['maildelimiter'] == 2) { ?> checked<?php } ?> type="radio"> 使用 CR 作为分隔符(通常为 Mac 主机)
</td>
</tr><tr>
<th>收件人显示用户名</th>
<td><input class="radio" name="mail[mailusername]" value="1"<?php if($mails['mailusername'] == 1) { ?> checked<?php } ?> type="radio"> 是 &nbsp; &nbsp;
<input class="radio" name="mail[mailusername]" value="0"<?php if($mails['mailusername'] != '1') { ?> checked<?php } ?> type="radio"> 否
</td>
</tr>

<tbody id="tb_smtp1"<?php if($mails['mailsend'] < 2) { ?> style="display:none;"<?php } ?>>
<th>&nbsp;</th>
<td>
<table>
<tr>
<td width="150">SMTP 服务器</td>
<td><input type="text" name="mail[server]" value="<?=$mails['server']?>"></td>
</tr><tr>
<td>SMTP 端口</td>
<td><input type="text" name="mail[port]" value="<?=$mails['port']?>" size="5"> 默认为 25</td>
</tr>
</tbody>

<tbody id="tb_smtp2"<?php if($mails['mailsend'] != 2) { ?> style="display:none;"<?php } ?>>
<tr>
<td>要求身份验证</td>
<td><input class="radio" name="mail[auth]" value="1"<?php if($mails['auth'] == 1) { ?> checked<?php } ?> type="radio"> 是 &nbsp; &nbsp;
<input class="radio" name="mail[auth]" value="0"<?php if($mails['auth'] != '1') { ?> checked<?php } ?> type="radio"> 否</td>
</tr><tr>
<td>发信人邮件地址</td>
<td><input type="text" name="mail[from]" value="<?=$mails['from']?>"><br>格式为“username &lt;user@domain.com&gt;”，也可以只填地址</td>
</tr><tr>
<td>SMTP 用户名</td>
<td><input type="text" name="mail[auth_username]" value="<?=$mails['auth_username']?>"></td>
</tr><tr>
<td>SMTP 密码</td>
<td><input type="password" name="mail[auth_password]" value="<?=$mails['auth_password']?>"></td>
</tr>
</table>
</td></tr>
</tbody>

</tr>

</table>
</div>

<div class="footactions">
<input type="submit" name="thevaluesubmit" value="提交" class="submit">
</div>

</form>
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