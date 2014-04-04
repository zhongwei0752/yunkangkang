<?php if(!defined('IN_UCHOME')) exit('Access Denied');?><?php subtplcheck('template/default/myhelp|template/default/footer', '1387352996', 'template/default/myhelp');?><!DOCTYPE html>


<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <title>微伍V5-帮助</title>
      <meta charset="UTF-8" />

    <meta name="description" content="微伍——企业移动互联网解决方案" />
    <meta name="keywords" content="微伍, 微信, 移动互联, 企业" />
    <meta charset="utf-8">

      <style type="text/css">
          #contenttext2 p b
          {
              color: #000000;
              font-size: 10px;
              text-align: left;
              font-weight: normal;

          }

          #contenttext2 p img
          {
              max-width: 100% !important;
              height: auto!important;
              text-align: center;
              margin: 0 auto;

          }

       /*   #contenttext2 img
          {
              float: left;
          }
          #contenttext2 p
          {
              margin-top: 20px;
          }  */



      </style>


      <link rel="stylesheet" href="./template/default/base.css" />
      <link rel="stylesheet" href="./template/default/common.css" />
      <link rel="stylesheet" href="./template/default/nav.css" />

      <link rel="stylesheet" href="./template/default/success.css" />
      <link rel="stylesheet" href="./template/default/bottomWrapper.css" />

      <link rel="stylesheet" href="./template/default/helpCenter.css" />
      <script type="text/javascript" src="./source/jquery-1.9.0.min.js"></script>
      <script type="text/javascript" src="./source/jquery-1.10.2.js"></script>
      <script type="text/javascript" src="./source/helpCenter_effect.js"></script>
      <script type="text/javascript" src="./source/helpCenter_function.js"></script>



      <!-- myAll.js 文件包含我写的所有js函数。 lrx-->
      <script type="text/javascript" src="./source/myAll.js"></script>
      <script type="text/javascript"></script>
      <!--[if IE 6]>
      <script type="text/javascript" src="js/DD_belatedPNG.js"></script>
      <script type="text/javascript" src="js/IEwarning.js"></script>
      <script type="text/javascript" charset="utf-8">
          DD_belatedPNG.fix(".pngFix,.pngFix:hover");
      </script>
      <![endif]-->
    <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE8">  
    <!-- Bootstrap -->
   <!--  <link href="css/bootstrap.min.css" rel="stylesheet" media="screen"> -->
    <link rel="stylesheet" type="text/css" href="./template/default/jquery-mobile-fluid960.min.css">
    <link rel="stylesheet" type="text/css" href="./template/default/style1.css">
      <script type="text/javascript">
          $(function(){
              $("#detailTemplate").appendTo('#detail-panel');
          })

      </script>
     
    <style type="text/css">
        .companies .grid_3 span img{
             max-width:71px;max-height:71px;min-width:71px;min-height:71px;
          } 
        .companies .grid_4 img{
             max-width:172px;max-height:53px;min-width:172px;min-height:53px;
        }
        /*login hack*/
        #email,#tx,#pwd{
        margin-left:-12px;
        }

        body{
          color:#fff;
          background:#fff; 
        }
             </style>





      <script id="detailTemplate" type="text/x-jquery-tmpl">
          <a href="#">
              <table>
                  <tr>

                      <td class="info_text">
                          <div class="list_item_text">
                              <span class="list_item_title"><?=$value1['message1']?></span>
                              <br />

                          </div>
                      </td>
                  </tr>
              </table><!-- one -->
          </a>




      </script>




  </head>
  <body>

    <div class="wrapper"  style="background-color: white">
    <div class="navbar">
            <div class="navbar-inner container_36">
                <a class="logo grid_1" href="space.php?do=home"><img src="./template/default/image/logo.png"></a>
                <a href="home.php" class="grid_2">首页</a>
                <a href="buy.php" class="grid_2">套餐</a>
                <a href="cases.php" class="grid_2">成功案例</a>
                <a href="myhelp.php" class="grid_2"><p class="nav_actived">帮助</p></a>
                <div class="zz">
                    <a href="network.php?id=1"><div class="zhuce_1"><img src="./template/default/image/zhuceleft.fw.png"></div></a>
                    <a href="network.php?id=2"><div class="zhuce_2"><img src="./template/default/image/zhuceright.fw.png"></div></a>
                    <div style="clear: both"></div>
                </div>
             </div>
         </div>
    <!-- navbar end -->




        <div class="helpCenterBody" style="outline: snow;outline-color: white;outline-style: hidden">

            <div class="menubox">
                <div class="menuboxhelp"><span>帮 &nbsp;助</span></div>
                <div class="list2">
                    <ul>
                        <li><span>使用帮助</span></li>
                        <?php if($value['developmentid']==60) { ?>  <li class="HaveChoose">· 开通流程
                            <img src="./template/default/image/buttom2.png" class="buttom" style="left: 120px;top: 2px" ></li>
                        <?php } else { ?>  <li class="choose">· 开通流程
                            <img src="./template/default/image/buttom1_1.png" class="buttom" style="left: 120px;top: 2px" ></li>  <?php } ?>
                        <?php if($value['developmentid']==70) { ?>   <li class="HaveChoose">· 管理员手册
                            <img src="./template/default/image/buttom2.png" class="buttom" style="left: 104px;top: 2px"></li>
                        <?php } else { ?>   <li class="choose">· 管理员手册
                            <img src="./template/default/image/buttom1_1.png" class="buttom" style="left: 104px;top: 2px"></li> <?php } ?>
                        <?php if($value['developmentid']==69) { ?>    <li class="HaveChoose">· 用户手册
                            <img src="./template/default/image/buttom2.png" class="buttom" style="left: 120px;top: 2px"></li>
                        <?php } else { ?>    <li class="choose">· 用户手册
                            <img src="./template/default/image/buttom1_1.png" class="buttom" style="left: 120px;top: 2px"></li>  <?php } ?>
                    </ul>
                    <ul>
                        <li ><span>投诉与建议</span></li>
                        <?php if($value['developmentid']==61) { ?>   <li class="HaveChoose">· 在线客服
                            <img src="./template/default/image/buttom2.png" class="buttom" style="left: 120px;top: 2px"></li>
                        <?php } else { ?>  <li class="choose">· 在线客服
                            <img src="./template/default/image/buttom1_1.png" class="buttom" style="left: 120px;top: 2px"></li>  <?php } ?>
                        <?php if($value['introduceid']==59) { ?>   <li class="HaveChoose">· 留言板
                            <img src="./template/default/image/buttom2.png" class="buttom" style="left: 136px;top: 2px"></li>
                        <?php } else { ?>    <li class="choose">· 留言板
                            <img src="./template/default/image/buttom1_1.png" class="buttom" style="left: 136px;top: 2px"></li>   <?php } ?>
                    </ul>
                    <ul>
                        <li><span>合作</span></li>
                        <?php if($value['developmentid']==62) { ?>   <li class="HaveChoose">· 品牌企业合作
                            <img src="./template/default/image/buttom2.png" class="buttom" style="left: 88px;top: 2px"></li>
                        <?php } else { ?>   <li class="choose">· 品牌企业合作
                            <img src="./template/default/image/buttom1_1.png" class="buttom" style="left: 88px;top: 2px"></li>  <?php } ?>
                        <?php if($value['developmentid']==63) { ?>   <li class="HaveChoose">· 媒体合作
                            <img src="./template/default/image/buttom2.png" class="buttom" style="left: 120px;top: 2px"></li>
                        <?php } else { ?>   <li class="choose">· 媒体合作
                            <img src="./template/default/image/buttom1_1.png" class="buttom" style="left: 120px;top: 2px"></li><?php } ?>
                        <?php if($value['developmentid']==72) { ?>   <li class="HaveChoose">· 收费细节
                            <img src="./template/default/image/buttom2.png" class="buttom" style="left: 120px;top: 2px"></li>
                        <?php } else { ?>  <li class="choose">· 收费细节
                            <img src="./template/default/image/buttom1_1.png" class="buttom" style="left: 120px;top: 2px"></li> <?php } ?>
                    </ul>
                    <ul>
                        <li><span>关于我们</span></li>
                        <?php if($value['productid']==49||$value==null) { ?> <li class="HaveChoose">· 产品介绍
                            <img src="./template/default/image/buttom2.png" class="buttom" style="left: 120px;top: 2px"></li>
                        <?php } else { ?> <li class="choose">· 产品介绍
                        <img src="./template/default/image/buttom1_1.png" class="buttom" style="left: 120px;top: 2px"></li> <?php } ?>
                        <?php if($value['introduceid']==48) { ?>   <li class="HaveChoose">· 联系方式
                        <img src="./template/default/image/buttom2.png" class="buttom" style="left: 120px;top: 2px"></li>
                        <?php } else { ?> <li class="choose">· 联系方式
                            <img src="./template/default/image/buttom1_1.png" class="buttom" style="left: 120px;top: 2px"></li><?php } ?>
                        <?php if($value['developmentid']==71) { ?>  <li class="HaveChoose">· 人才招聘
                            <img src="./template/default/image/buttom2.png" class="buttom" style="left: 120px;top: 2px"></li>
                        <?php } else { ?>  <li class="choose">· 人才招聘
                            <img src="./template/default/image/buttom1_1.png" class="buttom" style="left: 120px;top: 2px"></li> <?php } ?>
                    </ul>
                </div>
                <div style="clear: both"></div>
            </div>

            <!-----------------------------------------------------功能分隔----------------------------------------------------->
            <div class="searchbox">
                <div class="search_pic"><img src="./template/default/image/helpCenterSearch.fw_r2_c4.png"></div>
                <div class="search_text">
                    <textarea rows="1" style="resize: none;outline: none">请输入问题关键字</textarea>
                </div>
                <div class="search_buttom"></div>
                <div style="clear: both"></div>
            </div>
            <!-----------------------------------------------------功能分隔----------------------------------------------------->
            <div class="contentbox">
                <div class="contenttitle"><span><?=$value['subject']?></span></div>
                <div class="content_pic"></div>
                <div class="contenttext">
                <!--    <div id="detail-panel"></div>  -->
                    <div id="contenttext2"><?=$value['message1']?><div style="clear: both"></div> </div>
                    <div id="contenttext3"><?=$value1['message1']?></div>
                    <!--     <p><?=$value1['industryid']?></p>
                         <p><?=$value1['message1']?></p>  -->

                </div>
                <div style="clear: both"></div>
            </div>
            <div style="clear: both"></div>
        </div>
        <!-- 你的代码end -->

     </div>
    <div style="clear: both"></div>


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
  </body>
</html>

<?php ob_out();?>