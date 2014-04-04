<?php if(!defined('IN_UCHOME')) exit('Access Denied');?><?php subtplcheck('template/default/space_menuset_list|template/default/header|template/default/space_menu|template/default/footer', '1396507256', 'template/default/space_menuset_list');?><?php $_TPL['titles'] = array('组件'); ?>
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

<link rel="stylesheet" type="text/css" href="./template/default/jquery-mobile-fluid960.min.css">
    <link rel="stylesheet" type="text/css" href="./template/default/style1.css">
    <link rel="stylesheet" type="text/css" href="./template/default/file_beauty.css">
    <link type='text/css' href='./template/default/basic_chosen.css' rel='stylesheet' media='screen' />
    <style type="text/css">
       h3{color: #727272;margin-top: 20px;font-weight:normal;}
       .selected{ -webkit-box-shadow: 3px 3px 3px;
  -moz-box-shadow: 3px 3px 3px;
  box-shadow: 3px 3px 3px;}
  
      .bg1{ background: url("./template/default/image/chosen_bg4.png");width:360px;height:210px;box-shadow: none!important;border: none!important;}
      .open{ background: url("./template/default/image/chosen_bg3.png")!important;}
      .open .price{color:#3EB2B8!important;}
    </style>
    <script type='text/javascript' src='./source/jquery.simplemodal.js'></script>
   <script type='text/javascript' src='./source/basic.js'></script>
<?php if(!empty($_SGLOBAL['inajax'])) { ?>
<div id="space_menuset" class="feed">
<h3 class="feed_header">
<a href="cp.php?ac=menuset" class="r_option" target="_blank">发表组件</a>
组件(共 <?=$count?> 篇)
</h3>
<?php if($count) { ?>
<ul class="line_list">
<?php if(is_array($list)) { foreach($list as $value) { ?>
<li>
<span class="gray r_option"><?php echo sgmdate('m-d H:i',$value[dateline],1); ?></span>
<h4><a href="space.php?uid=<?=$space['uid']?>&do=menuset&id=<?=$value['menusetid']?>" target="_blank" <?php if($value['magiccolor']) { ?> class="magiccolor<?=$value['magiccolor']?>"<?php } ?>><?=$value['subject']?></a></h4>
<div class="detail">
<?=$value['message']?>
</div>
</li>
<?php } } ?>
</ul>
<?php if($pricount) { ?>
<div class="c_form">本页有 <?=$pricount?> 篇组件因作者的隐私设置而隐藏</div>
<?php } ?>
<div class="page"><?=$multi?></div>
<?php } else { ?>
<div class="c_form">还没有相关的组件。</div>
<?php } ?>
</div>
<?php } else { ?>

<?php if($space['self']) { ?>

<?php if($zhong1) { ?>

<div class="content" style="font-size:15px;">
          
                 <div class="indexing">
                   <span><a href="space.php?do=home">首页</a></span>><span>组件管理</span>
                   <?php if($_SN[$_SGLOBAL['supe_uid']]=='admin') { ?>
                   <a class="r_option" href="cp.php?ac=menuset">
                      发表新组件
                     </a>
                    <?php } ?>
                   
                 </div><!-- end -->
                 <div class="bread container_12">
                 	<?php if($_GET['view']=="all") { ?>
                      <div class="bread_actived grid_1" style="space.php?uid=<?=$space['uid']?>&do=<?=$do?>&view=all"style="margin-left:10px;">
                         更多组件
                     </div>
                     <a href="space.php?uid=<?=$space['uid']?>&do=<?=$do?>&view=me"  class="link_back_bread grid_3">
                      我的组件
                     </a>
                     <a href="cp.php?ac=menusetchoice"  class="link_back_bread grid_3">
                      组件套餐
                     </a>
                    
                     <?php } else { ?>
                     <a href="space.php?uid=<?=$space['uid']?>&do=<?=$do?>&view=all" class="link_back_bread grid_3" style="margin-left:-10px;">
                      更多组件
                     </a>
                     <div class="bread_actived grid_1" style="margin-left:10px;">
                      我的组件
                     </div>
                     <a href="cp.php?ac=menusetchoice"  class="link_back_bread grid_3">
                      组件套餐
                     </a>
                     <?php } ?>

                     
                      <?php if($_GET['page']) { ?>
                     <a href="space.php?do=menuset&page=<?=$_GET['page']?>&view=me&change=3" class="btn grid_2" >组件图片</a>
                     <a class="btn grid_2" href="space.php?do=menuset&page=<?=$_GET['page']?>&view=me&change=1" >排序</a>
                     <a class="btn grid_2" href="space.php?do=menuset&page=<?=$_GET['page']?>&view=me&change=2" style="margin-left:10px;">修改名称</a>
                     <?php } else { ?>
                     <a href="space.php?do=menuset&view=me&change=3" class="btn grid_2" >组件图片</a>
                     <a class="btn grid_2" href="space.php?do=menuset&view=me&change=1" >排序</a>
                     <a class="btn grid_2" href="space.php?do=menuset&view=me&change=2" style="margin-left:10px;">修改名称</a>
                     <?php } ?>
                     
                 </div>		

<?php } ?>	
<?php } else { ?>
<?php $_TPL['spacetitle'] = "组件";
	$_TPL['spacemenus'][] = "<a href=\"space.php?uid=$space[uid]&do=$do&view=me\">TA的所有组件</a>"; ?>
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
<div id="content" style="width:760px;">
<div class="content_detail_wrapper">



<?php if($searchkey) { ?>
<div class="h_status">以下是搜索组件 <span style="color:red;font-weight:bold;"><?=$searchkey?></span> 结果列表</div>
<?php } ?>
<script language="javascript" type="text/javascript" src="source/script_ajax.js"></script>
<?php if($count) { ?>
<?php if($_GET['view']!='me') { ?>
<form action = "space.php?do=menuset" method = "post">
<?php } elseif($_GET['change']=='1') { ?>
<form action = "space.php?do=orderid" method = "post">
      <?php } elseif($_GET['change']=='2') { ?>
      <form action = "space.php?do=newname" method = "post">
<?php } ?>
<div class="container_12 index_assembly_boxes" style="margin-left:10px;margin-top:20px;">
    <?php if(is_array($list)) { foreach($list as $value) { ?>
                         
        
                    
        <div class="grid_6">
                            <div class="index_assembly_box bg1" <?php if($_GET['view']!='me') { ?><?php if(!$value['money']) { ?><?php $value1=$value['zhong']; ?><?php if($value1['appstatus']=='1') { ?>style="background: url('./template/default/image/chosen_bg3.png')!important;"<?php } ?><?php } ?><?php } ?>  id="choice">
                            <div class="assembly_title">
       <?php if($_GET['change']=='2') { ?><span class="title"><input type="text" value="<?=$value['subject']?>" name="<?=$value['menusetid']?>"></span><?php } else { ?><a href="space.php?uid=<?=$value['uid']?>&do=<?=$do?>&id=<?=$value['menusetid']?>" ><span class="title"><?=$value['subject']?></span></a><?php } ?><span style="font-size:2px;"><?php if($_GET['view']!='me') { ?><?php $value2=$value['zhong']; ?><?php if($value2['cheak']=='1') { ?><a href="space.php?do=menuset&op=add&menusetid=<?=$value['menusetid']?>">（此组件未过期，请戳我重新开通）</a><?php } ?><?php } ?></span><?php if($_GET['view']=='me') { ?><a href="cp.php?ac=menuset&menusetid=<?=$value['menusetid']?>&op=delete1" class="r_option" style="padding-right:10px;padding-top:10px;" id="menuset_delete_<?=$value['menusetid']?>" onclick="ajaxmenu(event, this.id)"><img src="./template/default/image/delete1.gif"></a><?php } ?></div>
        <div id="num<?=$value['menusetid']?>">
       <div id="numh<?=$value['menusetid']?>"></div>
        
        <div class="assembly_info1">

          <p class="price2" style="color:#3EB2B8!important" <?php if($_GET['view']!='me') { ?><?php if(!$value['money']) { ?><?php $value1=$value['zhong']; ?><?php if($value1['appstatus']=='1') { ?>style="color:#3EB2B8!important;"<?php } ?><?php } ?><?php } ?> ><?php if($value['money']) { ?> 单价:<?=$value['money']?>元/年<?php } else { ?>单价:免费<?php } ?></p>
                                    <img src="<?=$value['image1url']?>">
                                   <h5 style="padding-top: 20px;"><?php if($_GET['view']=='me') { ?><?php if($_GET['change']=='1') { ?><select name="<?=$value['menusetid']?>">
                               <option value ="<?=$value['orderid']?>" selected><?=$value['orderid']?></option>
                               <?php for($i=1;$i<20;$i++){ ?>
                               <option value ="<?=$i?>"><?=$i?></option><?php } ?></select><?php } else { ?>序号:<?=$value['orderid']?><?php } ?><?php } ?></h5>
                               <?php if($_GET['view']=='me') { ?><?php if($_GET['change']=='3') { ?><h5 id="weixinhome<?=$value['menusetid']?>"><a href="javascript::void;">上传图片</a></h5><?php } ?>
                                <h5><?php if($_GET['view']!='me') { ?><?php $value1=$value['zhong']; ?><?php if($value1['num']==$value['menusetid']) { ?><?php if($value['money']) { ?>{if <?=$value1['appstatus']?>=='1'}（已订购<?=$value1['month']?>年）<br/>有效期至:<?php echo sgmdate('Y-m-d H:i:s',$value1[endtime]); ?><?php } ?><?php } ?><?php } ?><?php } ?><?php if($value['money']) { ?><?php if($_GET['view']=='me') { ?>有效期:<?php echo sgmdate('Y-m-d H:i',$value[dateline1],1); ?>--<?php echo sgmdate('Y-m-d H:i:s',$value[endtime]); ?><?php } ?><?php } ?></h5>    
                              
  								
                             </div>
          
          </div>

          </div></div>
   
          
      <?php if($_GET['view']!='me') { ?>
      <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
         <script>
         var jquery = jQuery.noConflict();
      jquery(document).ready(function()
        {
        
      jquery("#num<?=$value['menusetid']?>").toggle(
        function () {
                    jquery("#num<?=$value['menusetid']?>").parent(".index_assembly_box").addClass("open");
                    jquery("#numh<?=$value['menusetid']?>").html("<input type='hidden' name='<?=$value['menusetid']?>' value='1' style='width:20px;' />");
                  },
                  function () {
                    jquery("#num<?=$value['menusetid']?>").parent(".index_assembly_box").removeClass("open");
                    jquery("#numh<?=$value['menusetid']?>").html("");
                    }
              );
        
       
      });
      </script>
     
      <?php } ?>
       <?php if($_GET['view']=='me') { ?>
       <?php if($_GET['change']=='3') { ?>
         <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
         <script type='text/javascript' src='./source/jquery.simplemodal.js'></script>
         <script type="text/javascript">

         $(document).ready(function(){
           $('#weixin<?=$value['menusetid']?>').attr("style", "display:none;");
         
          $('#weixinhome<?=$value['menusetid']?>').click(function (e) {
        e.preventDefault();
        $('#weixin<?=$value['menusetid']?>').modal();
           });
           })
      </script>
       
      <div id="weixin<?=$value['menusetid']?>">
        <br/><p style="text-align:center;">上传图片须知：上传图片规则是不带中文的jpg格式的图片</p>
      <form action = "space.php?do=menuset" method = "post" style="margin:0 auto;text-align:center;" enctype="multipart/form-data">
    <br/>
   <h3 style="font-size:20px;color:#44B1BA;margin-left:-10px;line-height:40px;"><input type="file" id="files" name="files"></h3>
<br/>
    <input type="submit" name="submit" style="margin-left:250px;" class="btn grid_2" value="上传">
    <br/><br/>
    <p style="text-align:center;">目前图片:
    <?php if($value['imageurl']) { ?><img style="max-width:50px;max-height:50px;margin-top:20px;" src="<?=$value['image4url']?>"><?php } ?></p>
    <input type="hidden" name="menusetid" value="<?=$value['id']?>">
    <input type="hidden" name="menusetimage" value="1">
    </form>

                        </div>
                        <?php } ?>
                        <?php } ?>
    <?php } } ?>
    <br/>
    
   
    <?php if($_GET['view']!='me') { ?>
<?php if(empty($list)) { ?>
<div style="text-align:center;">系统没有为你匹配到你所属行业的相关组件，你可以通过修改行业选项。</div>

<?php } else { ?>
 <div class="confirm_btn container_12" style="width:760px;padding-left:310px;">
                           <input type="submit" name="submit1" id="wei0752" class="btn grid_2" value="提交">
                      </div>
<?php } ?>
<?php } ?>

    
</div>	
      <div class='pagination'><ul><?=$multi?></ul></div>
 <?php if($_GET['view']=='me') { ?><?php if($_GET['change']=='1') { ?>
    <div style="padding-bottom: 30px;padding-left:12px;">*如果需要更改组件顺序，请通过修改每个组件下的下拉框进行选择，系统会通过数字大小进行排列。<br/>*务必不要选择2个相同的数字</div>
    
                           <input style="margin-left:330px;margin-top: -10px;" type="submit" class="btn grid_2">
                              <?php } elseif($_GET['change']=='2') { ?>
    <div style="padding-bottom: 30px;padding-left:12px;">点击提交会对名称进行修改<br/>*提交后会以新的名字替换原来的名字，旧名字将不复存在。</div>
                          <input style="margin-left:330px;margin-top: -10px;" type="submit" class="btn grid_2">
                    <!--   <a class="btn grid_2" href="space.php?do=menuset&view=me&change=1" style="margin-top: -10px;">修改</a> -->
                      <?php } ?></form>
                      <?php } ?>




<?php } else { ?>
<div class="c_form">还没有相关的组件。</div>
<?php } ?>
</div>
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
<?php } ?>
<?php ob_out();?>