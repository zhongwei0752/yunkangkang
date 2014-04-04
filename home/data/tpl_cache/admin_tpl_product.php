<?php if(!defined('IN_UCHOME')) exit('Access Denied');?><?php subtplcheck('admin/tpl/product|admin/tpl/header|admin/tpl/side|admin/tpl/footer|template/default/header|template/default/footer', '1386840374', 'admin/tpl/product');?><?php $_TPL['menunames'] = array(
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





<form method="get" action="admincp.php">
<div class="block style4">

<table cellspacing="3" cellpadding="3">
<?php if($allowmanage) { ?>
<tr><th>作者UID</th><td><input type="text" name="uid" value="<?=$_GET['uid']?>"></td>
<th>作者名</th><td><input type="text" name="username" value="<?=$_GET['username']?>"></td>
</tr>
<?php } ?>
<tr><th>标题*</th><td><input type="text" name="subject" value="<?=$_GET['subject']?>"></td>
<th>内容*</th><td><input type="text" name="message" value="<?=$_GET['message']?>">*表示支持模糊查询</td>
</tr>
<tr>
<th>公开性质</th><td>
<select name="friend">
<option value="">不限</option>
<option value="0"<?php if($_GET['friend'] == '0') { ?> selected<?php } ?>>全站用户可见</option>
<option value="1"<?php if($_GET['friend'] == '1') { ?> selected<?php } ?>>全好友可见</option>
<option value="2"<?php if($_GET['friend'] == '2') { ?> selected<?php } ?>>仅指定的好友可见</option>
<option value="3"<?php if($_GET['friend'] == '3') { ?> selected<?php } ?>>仅自己可见</option>
<option value="4"<?php if($_GET['friend'] == '4') { ?> selected<?php } ?>>凭密码查看</option>
</select>
</td>
<th>发布IP</th><td colspan="3"><input type="text" name="postip" value="<?=$_GET['postip']?>"></td>
</tr>
<tr>
<th>指定日志ID</th>
<td colspan="3">
<input type="text" name="productid" value="<?=$_GET['productid']?>" />
</td>
</tr>
<tr><th>查看数</th><td colspan="3">
<input type="text" name="viewnum1" value="<?=$_GET['viewnum1']?>" size="10"> ~
<input type="text" name="viewnum2" value="<?=$_GET['viewnum2']?>" size="10">
</td></tr>
<tr><th>回复数</th><td colspan="3">
<input type="text" name="replynum1" value="<?=$_GET['replynum1']?>" size="10"> ~
<input type="text" name="replynum2" value="<?=$_GET['replynum2']?>" size="10">
</td></tr>
<tr><th>热度</th><td colspan="3">
<input type="text" name="hot1" value="<?=$_GET['hot1']?>" size="10"> ~
<input type="text" name="hot2" value="<?=$_GET['hot2']?>" size="10">
</td></tr>
<tr><th>发布时间</th><td colspan="3">
<input type="text" name="dateline1" value="<?=$_GET['dateline1']?>" size="10"> ~
<input type="text" name="dateline2" value="<?=$_GET['dateline2']?>" size="10"> (YYYY-MM-DD)
</td></tr>

<tr><th>结果排序</th>
<td colspan="3">
<select name="orderby">
<option value="">默认排序</option>
<option value="dateline"<?=$orderby['dateline']?>>发布时间</option>
<option value="viewnum"<?=$orderby['viewnum']?>>查看数</option>
<option value="replynum"<?=$orderby['replynum']?>>回复数</option>
<option value="hot"<?=$orderby['hot']?>>热度</option>
</select>
<select name="ordersc">
<option value="desc"<?=$ordersc['desc']?>>递减</option>
<option value="asc"<?=$ordersc['asc']?>>递增</option>
</select>
<select name="perpage">
<option value="20"<?=$perpages['20']?>>每页显示20个</option>
<option value="50"<?=$perpages['50']?>>每页显示50个</option>
<option value="100"<?=$perpages['100']?>>每页显示100个</option>
<option value="1000"<?=$perpages['1000']?>>一次处理1000个</option>
</select>
<input type="hidden" name="ac" value="product">
<input type="submit" name="searchsubmit" value="搜索" class="submit">
</td>
</tr>
</table>

</div>
</form>

<?php if($list) { ?>

<form method="post" id="batchform" action="admincp.php?ac=product">
<input type="hidden" name="formhash" value="<?php echo formhash(); ?>" />
<div class="bdrcontent">

<?php if($perpage>100) { ?>
<p>总共有满足条件的数据 <strong><?=$count?></strong> 个</p>
<?php if(is_array($list)) { foreach($list as $value) { ?>
<input type="hidden" name="ids[]" value="<?=$value['productid']?>">
<?php } } ?>

<?php } else { ?>
<table cellspacing="0" cellpadding="0" class="formtable">
<tr><td width="25">&nbsp;</td><th>标题</th><th width="80">操作</th></tr>
<?php if(is_array($list)) { foreach($list as $value) { ?>
<tr>
<td>
<input type="<?php if($allowbatch) { ?>checkbox<?php } else { ?>radio<?php } ?>" name="ids[]" value="<?=$value['productid']?>">
</td>
<td>
<a href="space.php?uid=<?=$value['uid']?>&do=product&id=<?=$value['productid']?>" target="_blank"><?=$value['subject']?></a>
<?php if($value['friend']) { ?>[<a href="admincp.php?ac=product&friend=<?=$value['friend']?>"><?=$value['friend']?></a>]<?php } ?>
<p class="gray">
<a href="admincp.php?ac=product&uid=<?=$value['uid']?>"><?=$value['username']?></a><?php if($value['postip']) { ?>(<a href="admincp.php?ac=product&postip=<?=$value['postip']?>"><?=$value['postip']?></a>)<?php } ?>
&nbsp; <?php echo sgmdate('Y-m-d H:i',$value[dateline]); ?>
<br>热度(<?=$value['hot']?>) / 回复(<?=$value['replynum']?>) / 查看(<?=$value['viewnum']?>)
</p>
</td>
<td>
<a href="cp.php?ac=product&op=edit&productid=<?=$value['productid']?>" target="_blank">编辑</a>&nbsp;
<a href="admincp.php?ac=comment&id=<?=$value['productid']?>&idtype=productid">评论</a>
</td>
</tr>
<?php } } ?>
</table>
<?php } ?>
</div>

<div class="footactions">
<?php if($allowbatch && $perpage<=100) { ?><input type="checkbox" id="chkall" name="chkall" onclick="checkAll(this.form, 'ids')">全选<?php } ?>
<input type="hidden" name="mpurl" value="<?=$mpurl?>">
<input type="submit" name="batchsubmit" value="批量删除" onclick="return confirm('本操作不可恢复，确认删除？');" class="submit">

<div class="pages"><?=$multi?></div>
</div>
</form>
<?php } else { ?>
<div class="bdrcontent">
<p>指定条件下还没有数据</p>
</div>
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