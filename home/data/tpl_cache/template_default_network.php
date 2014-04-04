<?php if(!defined('IN_UCHOME')) exit('Access Denied');?><?php subtplcheck('template/default/network|template/default/footer', '1396269534', 'template/default/network');?><!DOCTYPE html>


<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <title>微伍v5</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE8">
      <script src="./source/jquery.js" type="text/javascript"></script>
      <script type="text/javascript" src="./source/network.js"></script>
      <script type="text/javascript"></script>
    <!-- Bootstrap -->
   <!--  <link href="css/bootstrap.min.css" rel="stylesheet" media="screen"> -->
    <link rel="stylesheet" type="text/css" href="./template/default/jquery-mobile-fluid960.min.css">
    <link rel="stylesheet" type="text/css" href="./template/default/style1.css">
 <link rel="stylesheet" type="text/css" href="./template/default/adItem.css">

     
    <style type="text/css">
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
    
    <div class="wrapper">
        <div class="navbar">
            <div class="navbar-inner container_36">
                <a class="logo grid_1"><img src="./template/default/image/logo.png"></a>
                <a href="home.php" class="grid_2">首页</a>
                <a href="buy.php" class="grid_2">套餐</a>
                <a href="cases.php" class="grid_2">成功案例</a>
                <a href="myhelp.php" class="grid_2">帮助</a>

                    <div class="zz">
                        <a href="network.php?id=1"><div class="zhuce_1"><img src="./template/default/image/zhuceleft.fw.png"></div></a>
                        <a href="network.php?id=2"><div class="zhuce_2"><img src="./template/default/image/zhuceright.fw.png"></div></a>
                        <div style="clear: both"></div>
                    </div>

             </div>
         </div>
         <!-- navbar end -->
         <div class="login_wrapper container_12">
            <div class="grid_1">
                 <img src="<?=$bigimage['imageurl']?>">
            </div>
            <div class="grid_2 sign_window" id="log">
                   <ul>
                     <li style="float:left">登陆账号</li>
                  </ul>
                
               <form name="loginform" action="do.php?ac=<?=$_SCONFIG['login_action']?>&<?=$url_plus?>&ref" method="post">
              <input type="text" name="username" id="username"  value="<?=$membername?>" />
              <input type="password" name="password" id="password"  />
              <p class="submitrow">
                <input type="hidden" name="refer" value="space.php?do=home" />
                <input type="submit" id="loginsubmit" style="border:none;" class="sign_btn" name="loginsubmit" value="登录" class="submit" />
                <input type="hidden" name="formhash" value="<?php echo formhash(); ?>" />
              </p>
            </form>
            </div>
         </div>

          <p class="login_page_company_title"><span><b>企业名称</b></span></p>
          <div class="companies_wrapper">
          <div class="companies container_12">
            <?php if(is_array($openlist)) { foreach($openlist as $key => $value) { ?>
            <?php if($_SN[$value['uid']]!="admin") { ?>
            <div class="grid_3">
                   <span style="float:left;padding-right:10px;max-width:71px;max-height:71px;min-width:71px;min-height:71px;overflow:hidden;margin-bottom:20px;"><?php echo avatar($value[uid],middle); ?></span>
                   <span class="company_name"><?=$_SN[$value['uid']]?></span><br>
                    <span><a  class="fans"><?=$value['friendnum']?>客户</a></span> 
              </div>
              <?php } ?>
      
      <?php } } ?>
             
            
          </div>
    
      </div><!-- 无类div结束 -->


      <p class="login_page_company_title"><span><b>品牌合作企业</b></span></p>
               <div class="companies_wrapper">
          <div class="companies container_12">
              <div class="grid_4">
                  <img src="<?=$logoimage['0']['imageurl']?>">
              </div>
               <div class="grid_4">
                  <img src="<?=$logoimage['1']['imageurl']?>">
              </div>
               <div class="grid_4">
               <img src="<?=$logoimage['2']['imageurl']?>">
              </div>
               <div class="grid_4">
               <img src="<?=$logoimage['3']['imageurl']?>">
              </div>
               <div class="grid_4">
              <img src="<?=$logoimage['4']['imageurl']?>">
              </div>
               
          </div>
          
            <div class="companies container_12">
               <div class="grid_4">
                <img src="<?=$logoimage['5']['imageurl']?>">
              </div>
               <div class="grid_4">
                <img src="<?=$logoimage['6']['imageurl']?>">
              </div>
               <div class="grid_4">
               <img src="<?=$logoimage['7']['imageurl']?>">
              </div>
               <div class="grid_4">
               <img src="<?=$logoimage['8']['imageurl']?>">
              </div>
               <div class="grid_4">
               <img src="<?=$logoimage['9']['imageurl']?>">
              </div>
          </div>
      </div><!-- 无类div结束 -->
    </div><!-- wrraper end -->


     <script src="./source/jquery.js" type="text/javascript"></script> 
     <script type="text/javascript" src="./source/placeholder.js"></script>

    <script type="text/javascript">

    //跳转去注册或者登陆页面的控制函数
      function getUrlPara(paraName){
          var sUrl  =  location.href;
          var sReg  =  "(?:\\?|&){1}"+paraName+"=([^&]*)"
          var re=new RegExp(sReg,"gi");
          re.exec(sUrl);
          return RegExp.$1;
      }
      //应用实例：test_para.html?a=11&b=22&c=33
      //alert(getUrlPara("id"));
      //alert(getUrlPara("b"));
      if(getUrlPara("id")==2)
      {
               $('#log').animate({ opacity: '0'
               },200);
               $('#sign').animate({right:'0'
               },200);
      }
      else if(getUrlPara("id")==1)
      {
          $('#sign').animate({ right:'-1000px'
          },200);
          $('#log').animate({opacity: '1'
          },200);
      }





      $('#btna').click(function(){
    $('#log').animate({ opacity: '0'
},200);  
     $('#sign').animate({right:'0'
},200);  
    // $('#log').slideToggle("medium","linear");
    // $('#sign').slideToggle("medium","linear");
   });
    $('#btnb').click(function(){
    $('#sign').animate({ right:'-1000px'
},200);  
     $('#log').animate({opacity: '1'
},200);  
    // $('#log').slideToggle("medium","linear");
    // $('#sign').slideToggle("medium","linear");
   })
</script>

             <script type="text/javascript">
<!--
  $('username').focus();
  var lastUserName = lastPassword = lastEmail = lastSecCode = '';
  function checkUserName() {
    var userName = $('username').value;
    if(userName == lastUserName) {
      return;
    } else {
      lastUserName = userName;
    }
    var cu = $('checkusername');
    var unLen = userName.replace(/[^\x00-\xff]/g, "**").length;

    if(unLen < 3 || unLen > 150) {
      warning(cu, unLen < 3 ? '用户名小于3个字符' : '用户名超过 15 个字符');
      return;
    }
    ajaxresponse('checkusername', 'op=checkusername&username=' + (is_ie && document.charset == 'utf-8' ? encodeURIComponent(userName) : userName));
  }
  function checkPassword(confirm) {
    var password = $('password').value;
    if(!confirm && password == lastPassword) {
      return;
    } else {
      lastPassword = password;
    }
    var cp = $('checkpassword');
    if(password == '' || /[\'\"\\]/.test(password)) {
      warning(cp, '密码空或包含非法字符');
      return false;
    } else {
      cp.style.display = '';
      cp.innerHTML = '<img src="image/check_right.gif" width="13" height="13">';
      if(!confirm) {
        checkPassword2(true);
      }
      return true;
    }
  }
  </script>
  <script type="text/javascript">
       $("input").change(function(){
        $(this).css("color","#333")
       })
  </script>
  <script type="text/javascript">
      $(".login_hover").mouseover(function(){
          $(".login_png").attr("src","./template/default/image/login_btn_hover.png")
      });
      $(".login_hover").mouseout(function(){
          $(".login_png").attr("src","./template/default/image/login_btn.png")
      });

  </script>

             <script>
  function register(id, result) {
    if(result) {
      $('registersubmit').disabled = true;
      window.location.href = "<?=$jumpurl?>";
    } else {
      updateseccode();
    }
  }
</script>

  
    <script type="text/javascript">
var tx = document.getElementById("tx"), pwd = document.getElementById("pwd");
tx.onfocus = function(){
if(this.value != "密码") return;
this.style.display = "none";
pwd.style.display = "";
pwd.value = "";
pwd.focus();
}
pwd.onblur = function(){
if(this.value != "") return;
this.style.display = "none";
tx.style.display = "";
tx.value = "密码";
}

</script>
<!-- 以上为ie不兼容placeholder而写的 -->

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
<?php ob_out();?>