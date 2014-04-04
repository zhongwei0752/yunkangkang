<?php if(!defined('IN_UCHOME')) exit('Access Denied');?><?php subtplcheck('template/default/space_feed|template/default/header|template/default/footer', '1396586057', 'template/default/space_feed');?><?php if(empty($_TPL['getmore'])) { ?>	
<?php $_TPL['titles'] = array('首页'); ?>
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

    <link rel="stylesheet" type="text/css" href="./template/default/jquery-mobile-fluid960.min.css">
    <link rel="stylesheet" type="text/css" href="./template/default/style1.css">
    <link rel="stylesheet" type="text/css" href="./template/default/file_beauty.css">
    <link type='text/css' href='./template/default/basic_chosen.css' rel='stylesheet' media='screen' />
    <style type="text/css">
       h3{color: #727272;margin-top: 20px;font-weight:normal;}
       .selected{ -webkit-box-shadow: 3px 3px 3px;
  -moz-box-shadow: 3px 3px 3px;
  box-shadow: 3px 3px 3px;}
  
      .bg1{ background: url("./template/default/image/chosen_bg.png");}
      .open{ background: url("./template/default/image/chosen_bg2.png")!important;}
      .open .price{color:#3EB2B8!important;}
      #simplemodal-container{height:230px;}
      #alpha{
      	position: relative;
      	z-index: 10000;

      	
      	display: none;
      	margin-top: -128px;
      	
      	width: 128px;
      	height: 128px;
      	line-height: 128px;
      	text-align: center;
      	font-size: 18px;
      	color: #fff;
        background-color:rgba(73,65,65,0.5);
        cursor: pointer;
      }
    </style>
<style type="text/css">
.navbar-inner .grid_4 a img{max-width: 40px;}
</style>
<div id="content" style="width:762px;margin-left:20px;margin-top:10px;">

<?php if($space['uid'] && $space['self']) { ?>
<table cellpadding="0" cellspacing="0" border="0" width="100%">
<tr>
<td valign="top" width="150" id="avata_img">
<div class="ar_r_t">
  <div class="ar_l_t">
    <div class="ar_r_b">
      <div class="ar_l_b">
        <a href="cp.php?ac=avatar"><?php echo avatar($_SGLOBAL[supe_uid],middle); ?></a><div id="alpha"  onclick=window.open("cp.php?ac=avatar")>修改头像</div>	
      </div>
    </div>
  </div>
</div>
</td>
<td valign="top">
<h3 class="index_name" style="margin-top:-4px;border:0px;margin-bottom:-4px;">
<span style="color:#999;font-size:18px;"<?php g_color($space[groupid]); ?> ><?=$_SN[$space['uid']]?></span>

<span style="color:#43B8B0;font-size:18px;">VIP</span>
</h3>
<br/>
 <div class="company_avata_box container_12"  style="margin-top:-30px;">
                   <div class="grid_2">
                       <h5 style="margin-top:0px;">已有<?=$space['viewnum']?>人访问,<?=$space['experience']?>个信用</h5>
                       <div id="weixinhome" style="margin-top:-18px;"><a href="#" class="company_setting">微信公众号修改</a></div>
                      	<div id="weixinone"><a href="space.php?uid=<?=$space['uid']?>" style="margin-top:12px;" class="company_setting">查看统计数据</a></div>
                       <!--<a href="cp.php?ac=profile" style="margin-top:12px;" class="company_setting">企业设置</a>-->
                   </div>
                 </div>
    		

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
    <script type='text/javascript' src='./source/jquery.simplemodal.js'></script>
    <script type="text/javascript">
       $(document).ready(function(){
        
        $('#weixin').attr("style", "display:none;");
       
        $('#weixinhome').click(function (e) {
    	e.preventDefault();
    	$('#weixin').modal();
         });
  
           $("#avata_img").hover(
           	function(){
    	     $("#alpha").show();
           },
           function(){
           	 $("#alpha").hide();
           }
           )
           
            
       })
    </script>





</td>
</tr>
</table>



<div class="mgs_list">
    <?php if($namestatus) { ?><div><img src="image/icon/profile.gif" alt="" /><a href="admincp.php?ac=space"><strong><?=$namestatus?></strong> 个待认证用户</a></div>
    <?php } else { ?>
    <?php if($space['namestatusnum']) { ?><div><img src="image/icon/profile.gif" alt="" /><a href="admincp.php?ac=space&perpage=20&namestatus=0&searchsubmit=1"><strong><?=$space['namestatusnum']?></strong> 个待认证用户</a></div><?php } ?>
    <?php } ?>
</div>
 <div style="width:100%;background:#C2C2C2;height:1px;width:100%;margin:0px 0 30px 0;"></div>
                <div class="container_12 index_assembly_boxes">

                    <div class="grid_6">
                        <div class="index_assembly_box">
                            <div class="assembly_title">
                                   <span class="title">社区卫生中心微信服务号</span>
                             </div>
                             <div class="assembly_info">
                                <img src="http://v5.home3d.cn/home/image/gray/introduce.jpg" style="width:120px;height:120px;">
                                
                                <h5 style="padding-top: 20px;">向居民提供标准化服务为主；</h5>
                                <h5>偏向以微信应用功能实现医民互动；</h5>
                                <a href="#" id="weixinhome1" class="quick_post">新建</a>
                             </div>
                        </div>
                    </div><!-- end -->   
                     <div class="grid_6">
                        <div class="index_assembly_box">
                            <div class="assembly_title">
                                   <span class="title">GP服务号</span>
                             </div>
                             <div class="assembly_info">
                                <img src="http://v5.home3d.cn/home/image/gray/introduce.jpg" style="width:120px;height:120px;">
                                
                                <h5 style="padding-top: 20px;">向居民提供个性化服务为主；</h5>
                                <h5>偏向以微信沟通及资讯推送功能实现医民互动；</h5>
                                <a href="#" id="weixinhome2" class="quick_post">新建</a>
                             </div>
                        </div>
                    </div><!-- end -->   

                    </div>
                    </div>                                                         

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
    <script type='text/javascript' src='./source/jquery.simplemodal.js'></script>
    <script type="text/javascript">
       $(document).ready(function(){
           $('#weixin1').attr("style", "display:none;");
       
              $('#weixinhome1').click(function (e) {
            e.preventDefault();
            $('#weixin1').modal();
               });
                 $('#weixin2').attr("style", "display:none;");
             
              $('#weixinhome2').click(function (e) {
            e.preventDefault();
            $('#weixin2').modal();
         });
       })
    </script>

<?php } ?>	










</div>
<!--/content-->













<script type="text/javascript">

var next = <?=$start?>;
function feed_more() {
var x = new Ajax('XML', 'ajax_wait');
var html = '';
next = next + <?=$perpage?>;
x.get('cp.php?ac=feed&op=get&start='+next+'&view=<?=$_GET['view']?>&appid=<?=$_GET['appid']?>&icon=<?=$_GET['icon']?>&filter=<?=$_GET['filter']?>&day=<?=$_GET['day']?>', function(s){
html = '<h4 class="feedtime">以下是新读取的动态</h4>' + s;
$('feed_div').innerHTML += html;
});
}

function filter_more(id) {
if($('feed_filter_div_'+id).style.display == '') {
$('feed_filter_div_'+id).style.display = 'none';
$('feed_filter_notice_'+id).style.display = '';
} else {
$('feed_filter_div_'+id).style.display = '';
$('feed_filter_notice_'+id).style.display = 'none';
}
}

function close_feedbox() {
var x = new Ajax();
x.get('cp.php?ac=common&op=closefeedbox', function(s){
$('feed_box').style.display = 'none';
});
}

var elems = selector('li[class~=magicthunder]', $('feed_div')); 
for(var i=0; i<elems.length; i++){		
magicColor(elems[i]); 
}
    
 
</script>
 <div id="weixin">
                    <form action = "space.php?do=feed" method = "post" style="margin:0 auto;text-align:center;">
    <br/>
   <h3 style="font-size:20px;color:#44B1BA;margin-left:-10px;line-height:40px;">你的微信登录名：<input type="text" name="weixinusername" value="<?=$space['weixinusername']?>"></h3>
    <h3 style="font-size:20px;color:#44B1BA;margin:0;line-height:40px;padding-left:10px;">你的微信密码：<input type="text" name="weixinpassword" value="<?=$space['weixinpassword']?>"></h3><br/>
    <input type="submit" name="submit" style="margin-left:250px;" class="btn grid_2" value="修改">
    <input type="hidden" name="alreadyweixin" value="1">
    </form>

   </div>
     <div id="weixin1">
    <form action = "space.php?do=feed" method = "post" style="margin:0 auto;text-align:center;">
    <br/>
   <h3 style="font-size:20px;color:#44B1BA;margin-left:-10px;line-height:40px;">注册用户名：<input type="text" name="username" ></h3>
    <h3 style="font-size:20px;color:#44B1BA;margin:0;line-height:40px;padding-left:10px;">注册密码：<input type="text" name="password" ></h3><br/>
    <input type="submit" name="submit" style="margin-left:250px;" class="btn grid_2" value="创建">
    <input type="hidden" name="sq" value="1">
    </form>

    </div>
     <div id="weixin2">
    <form action = "space.php?do=feed" method = "post" style="margin:0 auto;text-align:center;">
    <br/>
   <h3 style="font-size:20px;color:#44B1BA;margin-left:-10px;line-height:40px;">注册用户名：<input type="text" name="username" ></h3>
    <h3 style="font-size:20px;color:#44B1BA;margin:0;line-height:40px;padding-left:10px;">注册密码：<input type="text" name="password" ></h3><br/>
    <input type="submit" name="submit" style="margin-left:250px;" class="btn grid_2" value="创建">
    <input type="hidden" name="gp" value="1">
    </form>

    </div>

<?php my_checkupdate(); ?>
<?php my_showgift(); ?>

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
<?php } ?><?php ob_out();?>