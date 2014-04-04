<?php if(!defined('IN_UCHOME')) exit('Access Denied');?><?php subtplcheck('template/default/space_order|template/default/header|template/default/footer', '1393407160', 'template/default/space_order');?><?php $_TPL['titles'] = array(货到付款内容); ?>
<?php $friendsname = array(1 => '仅好友可见',2 => '指定好友可见',3 => '仅自己可见',4 => '凭密码可见'); ?>
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

<link rel="stylesheet" type="text/css" href="template/default/jquery-mobile-fluid960.min.css">
<link rel="stylesheet" type="text/css" href="template/default/style1.css">
<link rel="stylesheet" type="text/css" href="template/default/file_beauty.css">
<?php if(!empty($_SGLOBAL['inajax'])) { ?>
<div id="space_blog" class="feed">
<h3 class="feed_header">
<a href="cp.php?ac=introduce" class="r_option" target="_blank">发布</a>
</h3>
<?php if($count) { ?>
<ul class="line_list">
<?php if(is_array($list)) { foreach($list as $value) { ?>
<li>
<span class="gray r_option"><?php echo sgmdate('m-d H:i',$value[dateline],1); ?></span>
<h4><a href="space.php?uid=<?=$space['uid']?>&do=introduce&id=<?=$value['introduceid']?>" target="_blank" <?php if($value['magiccolor']) { ?> class="magiccolor<?=$value['magiccolor']?>"<?php } ?>><?=$value['subject']?></a></h4>
<div class="detail">
<?=$value['message1']?>
</div>
</li>
<?php } } ?>
</ul>
<div class="page"><?=$multi?></div>
<?php } else { ?>
<div class="c_form">还没有相关的货到付款内容。</div>
<?php } ?>
</div>
<?php } else { ?>

<?php if($space['self']) { ?>
<div class="content" style="font-size:15px;">
          
                 <div class="indexing">
                   <span><a href="space.php?do=home">首页</a></span>><span>订单管理系统</span>
                 </div><!-- end -->
                 <div class="bread container_12">
                     <a href="space.php?do=order"  class="link_back_bread grid_3">
                        全部
                     </a>
         
                     <a href="#" id="weizhong" class="btn grid_2">
                      更改订单配置
                     </a>
                 </div>	

 

<?php } ?>

<div id="content" style="width:760px;">
<script type="text/javascript" charset="<?=$_SC['charset']?>" src="source/script_calendar.js"></script>
<div class="content_detail_wrapper" style="min-height: 1024px;">

 <?php if($_GET['cod']!='5') { ?>
 		<?php if($list) { ?>
<?php if(is_array($list)) { foreach($list as $value) { ?>
                     <div class="content_list container_12" >
                         
                          <div class="grid_2" >
                             <div class="list_test ">
                                  
                                  <a href="space.php?uid=<?=$value['viewuid']?>&do=<?=$do?>&id=<?=$value['gid']?>" style="float:left;">
                                  
                                  <h3><?=$value['username']?>的订单</h3></a>
                                  <br/><br/>
                                   <?php $list1 = $value[zhong]; ?>
                                    <?php if(is_array($list1)) { foreach($list1 as $value2) { ?>
                                     <div class="bookinglistproduct">
                                         <?=$value2['subject']?><span style="float:right;color:red;">单价:<?=$value2['curprice']?></span>
                                         <div style="clear:both;"></div>
                                     </div>
                                     <div class="bookinglistproduct">
                                         数量：<?=$value2['number']?>
                                     </div>
                                      <?php } } ?>
                                       <div class="bookinglistprice">
                                       <span class="bookinglistprice_s2">
                                           总价：<?=$value['count']?>元
                                       </span>
                                       <div style="clear: both"></div>
                                        </div>
                                      <br/>
                                      <br/>

                                  <div style="padding-left: 10px;padding-right: 10px">
                               <span class="customdiatel_s1">收件人：</span><span class="customdiatel_s2"><?=$value['username']?></span>
                               <br>
                               <span class="customdiatel_s1">联系电话：</span><span class="customdiatel_s2"><?=$value['tel']?></span>
                               <br>
                               <span class="customdiatel_s1">收件地址：</span><span class="customdiatel_s2"><?=$value['place']?></span>
                               <br>
                               <span class="customdiatel_s1">购买方式：</span><span class="customdiatel_s2">
                               <?php if($value['buystatus']=='payonline') { ?>
                               在线支付
                               <?php } elseif($value['buystatus']=='PayOnDelivery') { ?>
                               货到付款
                               <?php } elseif($value['buystatus']=='PayOnShop') { ?>
                               到店提货
                               <?php } ?>
                               </span>
                               <br/>
                               <span class="customdiatel_s1">下单时间：</span><span class="customdiatel_s2"><?php echo sgmdate('Y-m-d',$value[dateline]); ?></span>
                           </div>
                             </div>
                          </div>
                     </div><!-- list end -->
                     <br/>
                   <?php } } ?>
<?php } else { ?>
<div class="c_form">还没有相关的货到付款内容。</div>
<?php } ?>
    <?php } else { ?>
    <form method="post" action="space.php?do=order&cod=5" style="margin-left:20px;">
    <div style="text-align:center;margin:0 auto;width:100%;">
      <br/><br/><br/><h3 style="color:#02B4AB">请输入电话查询<h3><br/>
      <input type="text" name="cheakorder" id="cheakorder" size="60"></input><br/><br/>
      <input type="hidden" name="ordersubmit" value="1"/>
      <input type="submit" value="提交" id="submit">
    </div>
  </form>
  <div id="searchlist">
    12312
  <?php if(is_array($searchlist)) { foreach($searchlist as $value1) { ?>
  <?=$value1['tel']?>
  <?php } } ?>
  </div>
    <?php } ?>      
</div>

<div class='pagination'><ul><?=$multi?></ul></div>



</div>
      <!--<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
      <script type="text/javascript">
      $(document).ready(function(){
      $("#submit").click(function(){
      $.ajax({
      //dataType:"jsonp",
      url:"http://localhost/v5/home/space.php?do=order",
      type: "POST",
      data: "tel="+$("#cheakorder").val()+"&ordersubmit=1",
      success:function(data){
        $("#searchlist").html(data);
      },
          });
       });
    });
    </script>-->
    
<?php } ?>
 <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
    <script type='text/javascript' src='./source/jquery.simplemodal.js'></script>
    <script type="text/javascript">
     
       $(document).ready(function(){
         $("#weizhong").click(function(){
         $('#weixin').attr("style", "display:none;");
        $('#weixin').modal();
         })
         <?php if(!$cheakfororder) { ?>
          $('#weixin').attr("style", "display:none;");
        $('#weixin').modal();
           <?php } ?>
       })
    </script>


    <style>
    #simplemodal-container{
      height:600px;
    }
    </style>
      <div id="weixin">
     <form action = "space.php?do=order" method = "post" style="margin:0 auto;text-align:center;">
    <br/>
   <h3 style="font-size:20px;color:#44B1BA;margin-left:-10px;line-height:40px;">支付宝信息</h3>
    <span style="color:red">请填写申请支付宝成功后返回的合作身份者id和安全检验码</span>
                           <div>
                            合作身份者id(必填)：<input type="text" style="margin-left:10px;"  class="t_input" id="id" autocomplete = "off" name="id"   size="40" value="<?=$order['id']?>"/><br/>
                            安全检验码(必填)：<input type="text" style="margin-left:20px;"  class="t_input" id="password" autocomplete = "off" name="password"   size="40" value="<?=$order['password']?>"/><br/>
                            签约用户账号(必填)：<input type="text" style="margin-left:20px;"  class="t_input" id="username" autocomplete = "off" name="username"   size="40" value="<?=$order['username']?>"/> <br/> 
                            管理员查看密码(必填)：<input type="text" style="margin-left:20px;"  class="t_input" id="password2" autocomplete = "off" name="password2"   size="40" value="<?=$order['password2']?>"/> <br/><br/>
                            运费设置（<span style="color:red;">选填,不填则自动不实现</span>）：运费:<input type="text" name="yunfei"/> 元<br/><br/>
                                              (购买金额满&nbsp;<input type="text" name="manyunfei"/>&nbsp;元,则免运费。)
                            </div>


      <h3 style="font-size:20px;color:#44B1BA;margin-left:-10px;line-height:40px;">设置送货方式(必填)</h3>
      <span style="color:red">多选项，这将会显示给用户选择，请勾选你能够提供的</span><br/>
      <input name="shopping[]" type="checkbox" value="1" />在线支付
      <input name="shopping[]" type="checkbox" value="2" />货到付款 
      <input name="shopping[]" type="checkbox" value="3" />到店自提
      <br/>
      <h3 style="font-size:20px;color:#44B1BA;margin-left:-10px;line-height:40px;">推送者:</h3>
                           <!-- <input type="text" class="t_input" id="taobaourl" name="taobaourl" value="<?=$goods['taobaourl']?>"  onblur="relatekw();" placeholder="注意输入有效的url" style = "margin-left:20px;"/> -->
                           <select  name="push" >
                           <option value="0">未选择</option>
                           <?php if(is_array($list1)) { foreach($list1 as $value) { ?>
                           <option value="<?=$value['fakeid']?>"><?=$value['name']?></option>
                           <?php } } ?>
                           </select><br/><span style="color:red">(以下2项两者选一进行填写，若2项都填写，默认选择第一项)</span><br/>
                           <span >or</span><br/>
                           <div>
                           <input type="text"  class="t_input" id="subject1" autocomplete = "off" name="subject1"   size="40" />
                            <div class="list_box" style="border:1px solid #999;width:257px;margin-left:180px;">
                            <div class="keywords_list" ></div>
                            <input type="hidden" name="push1" id="push1">
                            </div>
                            </div>
                            <br/>
    <input type="submit" name="submit" style="margin-left:220px;margin-right:20px;" class="btn grid_2" value="提交">
    <input type="submit" name="submit" style="display: inline-block;width: 94px;height: 32px;line-height: 32px;text-align: center;color: white;background: url('./template/default/image/btn_normal.png') no-repeat;margin: 0;padding: 0;border: 0;float: left;" class="modalCloseImg simplemodal-close"  value="取消">
    <input type="hidden" name="shop" value="1">
    </form>

    </div>
 	
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js" type="text/javascript"></script>
<script language="javascript">var jquery = jQuery.noConflict(); </script>
<script type="text/javascript">
jquery(document).ready(function() {
 jquery('.list_box').hide();
 jquery('#subject1').keyup(function(){
  var keywords = jquery('#subject1').val();

  jquery.ajax({
   type:"POST",
   url:"space.php?do=ajax1",
   data:{keywords:keywords},
   success:function(html) {
   jquery('.list_box').show();
   jquery('.keywords_list').html(html);
   jquery('li').click(function(){
  jquery('.list_box').hide();
    var update = new Array(); 
    update = jquery(this).text().split('|');
     jquery('#subject1').val(update[1]);
     jquery('#push1').val(update[0]);
                    jquery('.list_box').hide();
                })
  }

})
    });
  });
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