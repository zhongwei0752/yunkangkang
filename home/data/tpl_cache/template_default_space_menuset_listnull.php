<?php if(!defined('IN_UCHOME')) exit('Access Denied');?><?php subtplcheck('template/default/space_menuset_listnull|template/default/footer', '1387354862', 'template/default/space_menuset_listnull');?><!DOCTYPE html>
<html>
  <head>
    <title>套餐</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">
    <!-- Bootstrap -->
   <!--  <link href="css/bootstrap.min.css" rel="stylesheet" media="screen"> -->
    <link rel="stylesheet" href="./template/default/base.css" />
    <link rel="stylesheet" href="./template/default/common.css" />
    <link rel="stylesheet" href="./template/default/nav.css" />
    <link rel="stylesheet" href="./template/default/bottomWrapper.css" />
    <link rel="stylesheet" href="./template/default/setItem.css" />
    <link rel="stylesheet" href="./template/default/set.css" />
    <script type="text/javascript" src="./source/jquery-1.10.2.js"></script>
    <script type="text/javascript" src="./source/jquery-1.9.0.min.js"></script>
    <script type="text/javascript" src="./source/set_html_effect.js"></script>
    <script type="text/javascript" src="./source/set_html_function.js"></script>
    <script type="text/javascript"></script>
  <!--[if IE 6]>
    <script type="text/javascript" src="js/DD_belatedPNG.js"></script>
        <script type="text/javascript" src="js/IEwarning.js"></script>
      <script type="text/javascript" charset="utf-8">
        DD_belatedPNG.fix(".pngFix,.pngFix:hover");      
      </script>
   <![endif]-->
        <!--[if IE 7]>
        <script type="text/javascript" src="js/IEwarning.js"></script>
        <![endif]-->
   <!-- 修复ie6透明png的bug -->
  </head>
 <!-- Bootstrap -->
   <!--  <link href="css/bootstrap.min.css" rel="stylesheet" media="screen"> -->
    <link rel="stylesheet" type="text/css" href="./template/default/jquery-mobile-fluid960.min.css">
    <link rel="stylesheet" type="text/css" href="./template/default/style1.css">
     
    <style type="text/css">
        .wrapper {
          background-color: #fff;
        }
        .companies .grid_3 span img{
             max-width:71px;max-height:71px;min-width:71px;min-height:71px;
          } 
        .companies .grid_4 img{
             max-width:172px;max-height:53px;min-width:172px;min-height:53px;
        }
        /*login hack*/
        #email,#tx,#pwd{
        margin-left:-12px\9;
        }
             </style>
  </head>
  <body>
    <div class="page bc">
  
       <div class="navbar">
            <div class="navbar-inner container_36">
                <a class="logo grid_1" href="space.php?do=home" style="background:none;"><img src="./template/default/image/logo.png"></a>
                <a href="#" class="grid_5" style="float:right;color:#BDBEBF;padding-right:10px;">帮助</a>
             </div>
         </div>
         <!-- navbar end -->

   <?php if(empty($zhong1)) { ?><div class="content" style="font-size:15px;width:760px;"><img src="./template/default/image/guide_chosen.png" style="margin:20px 20px 0px 28px;"></div><?php } ?>
     <div class="wrapper">
    <div class="setItem" id="setItem1"><br/><br/>
      <img src="./template/default/image/img/title_set01.png" alt="" class="setItem-titlePic" />
      <div class="setContent" id="set1">
        <img src="./template/default/image/img/mid_pic_01.png" alt="" class="setContent-pic" />
        <dl class="setContent-text">
          <dt class="fb">一经注册开通，免费套餐任你玩</dt>
          <dd><img src="./template/default/image/img/list_point.png" alt="" /><span class="fb">企业介绍，</span>详尽企业介绍，品牌强势进驻公众平台。</dd>
          <dd><img src="./template/default/image/img/list_point.png" alt="" /><span class="fb">企业动态，</span>动态实时更新，劲爆猛料火线速递。</dd>
          <dd><img src="./template/default/image/img/list_point.png" alt="" /><span class="fb">产品介绍，</span>完美图文展示，优质产品吸引更多关注。</dd>
          <dd><img src="./template/default/image/img/list_point.png" alt="" /><span class="fb">企业官网，</span>手机品牌官网，行业先驱非您莫属。</dd>
        </dl>
      </div>
      <form action = "space.php?do=menuset&status=taocan&id=mianfei" method = "post" name="mianfei">
      <?php if(is_array($mianfei)) { foreach($mianfei as $value) { ?>
      <input type='hidden' name='<?=$value['menusetid']?>' value='1' style='width:20px;' />
    <?php } } ?>
     <a href="javascript:document.mianfei.submit();" class="setButton" id="firstButton"><img src="./template/default/image/img/use_now3.png" alt="" /></a>
     </form>
     <br/>
    </div> <!-- setItem --> 

    <div class="setItem" id="setItem2">
      <img src="./template/default/image/img/title_set02.png" alt="" class="setItem-titlePic" />
      <div class="setContent" id="set2">
        <img src="./template/default/image/img/mid_pic_02.png" alt="" class="setContent-pic" />
        <dl class="setContent-text">
          <dt class="fb">完美补充传统官网，企业在移动互联网轻松获得更多口碑</dt>
          <dd><img src="./template/default/image/img/list_point.png" alt="" /><span class="fb">企业介绍，</span>详尽企业介绍，品牌强势进驻公众平台。</dd>
          <dd><img src="./template/default/image/img/list_point.png" alt="" /><span class="fb">企业动态，</span>动态实时更新，劲爆猛料火线速递。</dd>
          <dd><img src="./template/default/image/img/list_point.png" alt="" /><span class="fb">产品介绍，</span>完美图文展示，优质产品吸引更多关注。</dd>
          <dd><img src="./template/default/image/img/list_point.png" alt="" /><span class="fb">行业动态，</span>把握行业脉搏，与客户分享最具行业价值信息。</dd>
          <dd><img src="./template/default/image/img/list_point.png" alt="" /><span class="fb">成功案例，</span>成功是时间的积累，您的实力谁能置疑？</dd>
          <dd><img src="./template/default/image/img/list_point.png" alt="" /><span class="fb">分支机构，</span>罗列所有驻点，客户总能找到身边的您。</dd>
          <dd><img src="./template/default/image/img/list_point.png" alt="" /><span class="fb">人才招聘，</span>网罗微信时代人才，轻松开展微招聘。</dd>
          <dd><img src="./template/default/image/img/list_point.png" alt="" /><span class="fb">企业官网，</span>海量手机官网模板，改版升级轻松设置。</dd>
        </dl>
      </div>
      <form action = "space.php?do=menuset&id=putong&status=taocan" method = "post" name="putong">
      <?php if(is_array($putong)) { foreach($putong as $value) { ?>
      <input type='hidden' name='<?=$value['menusetid']?>' value='1' style='width:20px;' />
    <?php } } ?>
    <a href="javascript:document.putong.submit();" class="setButton" id="secondButton"><img src="./template/default/image/img/buy_now3.png" alt="" /></a>
     </form>
     
     <br/>
    </div> <!-- setItem --> 

    <div class="setItem"  id="setItem3">
      <img src="./template/default/image/img/title_set03.png" alt="" class="setItem-titlePic" />
      <div class="setContent" id="set3">
        <img src="./template/default/image/img/mid_pic_03.png" alt="" class="setContent-pic" />
        <dl class="setContent-text">
          <dt class="fb">摇身一变，微信app轻松获得，更低的推广成本，更高的经济效益。
                    </dt>
          <dd><img src="./template/default/image/img/list_point.png" alt="" /><span class="fb">自定义菜单，</span>微信内置app折叠菜单，更直观，更方便。</dd>
          <dd><img src="./template/default/image/img/list_point.png" alt="" /><span class="fb">微信商城，</span>开设微信商城，马上启程新渠道电商之路。</dd>
          <dd><img src="./template/default/image/img/list_point.png" alt="" /><span class="fb">焦点推荐，</span>设置醒目焦点内容推荐，锁住客户关注。</dd>
          <dd><img src="./template/default/image/img/list_point.png" alt="" /><span class="fb">微信呼叫中心，</span>多层级客服响应处理，客户一呼百应。</dd>
          <dd><img src="./template/default/image/img/list_point.png" alt="" /><span class="fb">客户管理中心，</span>沉淀转化优质客户，定点精准开展二次营销。</dd>
        </dl>
      </div>
      <form action = "space.php?do=menuset&id=gaoji&status=taocan" method = "post" name="gaoji">
      <?php if(is_array($gaoji)) { foreach($gaoji as $value) { ?>
      <input type='hidden' name='<?=$value['menusetid']?>' value='1' style='width:20px;' />
    <?php } } ?>
    <a href="javascript:document.gaoji.submit();" class="setButton" id="thirdButton"><img src="./template/default/image/img/buy_now_green5.png" alt="" /></a>
     </form>
       
      <br/>
    </div> <!-- setItem --> 

    <div class="setItem" id="setItem4">
      <img src="./template/default/image/img/title_set04.png" alt="" class="setItem-titlePic" />
      <div class="setContent" id="set4">
        <img src="./template/default/image/img/mid_pic_04.png" alt="" class="setContent-pic" />
        <dl class="setContent-text">
          <dt class="fb">囊括各大领域解决方案，业务服务开展高度契合，聚集品牌口碑，备受推崇。</dt>
          <dd><img src="./template/default/image/img/list_point.png" alt="" /><span class="fb">零售行业，</span>通过微信公众账号作为电商入口，将线下每个零售店铺搬到微信公众平台上。新货上架、活动优惠信息，借助朋友圈口碑营销的威力，促进消费。</dd>
          <dd><img src="./template/default/image/img/list_point.png" alt="" /><span class="fb">餐饮行业，</span>通过提供分支机构、预约订餐、客户信息统计、会员卡获取特权等功能，最大力度活跃客户，开始全民O2O时代。</dd>
          <dd><img src="./template/default/image/img/list_point.png" alt="" /><span class="fb">教育机构，</span>通过预约预订、客户管理、在线调查、咨询留言等功能，实现课程活动预约报名、校内选课、查看课表、课堂互动等功能，结合后台统计功能，合理展开教学安排，实现微时代的信息化管理。</dd>
          <dd><img src="./template/default/image/img/list_point.png" alt="" /><span class="fb">个人机构，</span>通过预约预订、客户管理、咨询留言等功能，依赖微信强关系的社交特质，轻松开展私密性个人服务，打造个人服务品牌。</dd>
          <dd><img src="./template/default/image/img/list_point.png" alt="" /><span class="fb">服务消费，</span>通过分支机构、预约服务、客户信息统计、会员卡获取特权等功能，让用户和商家享受到便捷的服务和管理。</dd>
        </dl>
      </div>
    </div> <!-- setItem --> 
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
<?php } ?>
    <!--<script src="js/bootstrap.min.js"></script>-->
          

      </script>



 <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
    <script type='text/javascript' src='./source/jquery.simplemodal.js'></script>
    <script type="text/javascript">
       $(document).ready(function(){

        $(".modalCloseImg").click(function(){
         $('#allbuy').hide();
        });
        $('#basic-modal-content<?=$value['menusetid']?>').attr("style", "display:none;");
          <?php if(empty($space['weixinusername'])&&empty($space['weixinpassword'])) { ?>
        $('#weixin').attr("style", "display:none;");
        $('#weixin').modal();
        $('#weixin').attr("style", "display:block;");
              <?php } ?>
           $('#basic-modal input.basic<?=$value['menusetid']?>, #basic-modal a.basic<?=$value['menusetid']?>').click(function (e) {
    e.preventDefault();
    $('#basic-modal-content<?=$value['menusetid']?>').modal();
  });

            
       })
    </script>
    {/loop}
 <div id="weixin">
    <style type="text/css">
      #simplemodal-container{height:300px;}
    </style>
  <?php if(empty($zhong1)) { ?>
  <?php if(empty($space['weixinusername'])&&empty($space['weixinpassword'])) { ?>
   <?php if(1) { ?>
  <form action = "space.php?do=goweixin" method = "post" style="margin:0 auto;text-align:center;">
    <br/>
   <h3 style="font-size:20px;color:#44B1BA;margin-left:-10px;line-height:40px;">你的微信登录名：<input type="text" name="weixinusername"></h3>
    <h3 style="font-size:20px;color:#44B1BA;margin:0;line-height:40px;padding-left:10px;">你的微信密码：<input type="text" name="weixinpassword"></h3><br/>
    <input type="submit" name="submit" style="margin-left:250px;" class="btn grid_2" value="提交">
    <input type="hidden" name="alreadyweixin" value="1">
    </form>
  <?php } else { ?>
  <?php if(!empty($newweixin['username'])) { ?>
  <form action = "space.php?do=goweixin" method = "post">
  <h3 style="font-size:20px;color:#44B1BA;background:#ECEFF1;margin:0;line-height:40px;text-align:left;padding-left:10px;">系统已自动为你生成微信公众号，如你已有微信公众号，可<a href="space.php?do=menuset&status=already">点击此处</a></h3>
  <h3 style="font-size:20px;color:#44B1BA;background:#ECEFF1;margin:0;line-height:40px;text-align:left;padding-left:10px;">你的微信id：<?=$newweixin['wxkey']?></h3>
   <h3 style="font-size:20px;color:#44B1BA;background:#ECEFF1;margin:0;line-height:40px;text-align:left;padding-left:10px;">你的微信用户名：<?=$newweixin['username']?></h3>
    <h3 style="font-size:20px;color:#44B1BA;background:#ECEFF1;margin:0;line-height:40px;text-align:left;padding-left:10px;">你的微信密码：<?=$newweixin['password']?></h3>
     <input type="hidden" name="username" value="<?=$newweixin['username']?>">
     <input type="hidden" name="password" value="<?=$newweixin['password']?>">
     <input type="hidden" name="fakeid" value="<?=$newweixin['fakeid']?>">
     <input type="hidden" name="wxkey" value="<?=$newweixin['wxkey']?>">
     <input type="hidden" name="id" value="<?=$newweixin['id']?>">
    <input type="submit" name="submit" value="使用">
    <input type="hidden" name="newweixin" value="1">
    </form>
    <?php } else { ?>
    <h3 style="font-size:20px;color:#44B1BA;background:#ECEFF1;margin:0;line-height:40px;text-align:left;padding-left:10px;">目前还未有微信公众号</h3>
     <?php } ?>
     <?php } ?>
     <?php } ?>
     <?php } ?>

</div>

 

<?php ob_out();?>