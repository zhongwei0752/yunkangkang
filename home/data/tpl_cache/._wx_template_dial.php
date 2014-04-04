<?php if(!defined('IN_UCHOME')) exit('Access Denied');?><?php subtplcheck('./wx/template/dial', '1387333008', './wx/template/dial');?><!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="./template/dial.css" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<link rel="stylesheet" media="screen" href="./static/css/bootstrap.min.css">
<link rel="stylesheet" media="screen" href="./static/css/font-awesome.min.css">
<link rel="stylesheet" media="screen" href="./static/dialog/skins/default.css">
<link rel="stylesheet" media="screen" href="./static/css/style.css">

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no"  />
<title><?=$dial['subject']?></title>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js" type="text/javascript"></script> 
<script type="text/javascript" src="http://sandbox.runjs.cn/js/sandbox/jquery-plugins/jQueryRotate.2.2.js"></script>
        <link rel="stylesheet" href="./template/css/expressInfo.css" />
        <style type="text/css">
            .mt13
            {
                border-collapse: collapse;
            }
            .mt13 li
            {
              border: 1px solid #D6D7D6;
              background-color: #F7F7F7;
              color: #666;
            }
        </style>
</head>
<body>
  <div class="p10">

      <div class="turntable">
          <div class="t-panel"><img id="outter" src="./static/img/turntable-panel.png" /></div>
          <div class="t-button"><img id="inner" src="./static/img/inner.png" /></div>
      </div>
      <?php if(($dialbuy1)) { ?>
      <!--<div class="alert mt10 mt12">你已经参与过活动。</div> -->
      <div></div>
      <?php } ?>
    <?php if(($dialbuy1)) { ?>
    <?php if($dialbuy1['dialprice']) { ?>
    <div class='alert mt10'>你获得：<?=$dialbuy1['dialprice']?></div>
     <?php } else { ?>
     <div class='alert mt10'>谢谢参与</div>
      <?php } ?>
    <?php } ?>




        <div class="alert alert-info mt15">
       <div  class="alertinside">
            <h4 >&nbsp;&nbsp;奖项设置：</h4>
            <ul class="unstyled mt10">
                <li>一等奖:<?=$dial['fristprice']?></li>
                <li>二等奖:<?=$dial['secondprice']?></li>
                <li>三等奖:<?=$dial['thirdprice']?></li>
            </ul>
       </div>
    </div>
    <div class="alert alert-success">
        <div class="alertinside">
      <h4>&nbsp;&nbsp;活动说明：</h4>
      <p class="mt10"><?=$dial['message']?></p>
      </div>
    </div>
      <div class="alert alert-success">
          <div class="alertinside">
              <h4>&nbsp;&nbsp;温馨提示：</h4>
              <p class="mt10"></p>
              <div>1、每个微信号只能开启1次大转盘。</div>
              <div>2、为了您个人的利益，请务必填写您本人手机
                  号码，所有的需要邮寄的奖品我们有专门的工作
                  人员通过手机进行通知。</div>
              <div>3、手机充值卡仅限广州移动用户使用。</div>
              <br>
          </div>
      </div>
      <div style="clear: both"></div>
      <div class="shownumber">
          <span class="s1 shownumber1">最新10条获奖名单:</span>
          <span class="s2 shownumber2" id="buttonBuy1">查看中奖者订单详情</span>
          <div style="clear: both"></div>
          <?php if($_GET['zhong']=='1') { ?>
          <ul class="unstyled mt10 mt13">
              <?php for($i=0;$i<10;$i++){ ?>
              <?php if($dialbuy[$i]['username']) { ?>
              <li><?=$dialbuy[$i]['username']?>:<?=$dialbuy[$i]['dialprice']?>&nbsp;<?=$dialbuy[$i]['tel']?> </li>
              <?php } ?>
              <?php } ?>
          </ul>
          <?php } ?>
      </div>
      <div style="clear: both"></div>

      <?php if((empty($_COOKIE['uchome_viewuid']))) { ?>
      <div class="alert mt10 mt12">请先关注微信公众号才能进行抽奖</div>
      <?php } ?>
      <?php if((empty($dial))) { ?><div class="alert mt10 mt12">活动已经结束，下次再来吧!</div><?php } ?>



    </div>
   
  </div>
   <input type="hidden" id="dialid" name="dialid" value="<?=$dial['dialid']?>">
</body>

    <script type="text/javascript">
        $(document).ready(function(){
            $("#buttonBuy1").click(function(){
                $(".expressInfo1").fadeIn();
                });

            //点击表格外的地方时消失
            $(".expressInfo").click(function(){
                $(".expressInfo").fadeOut();
                });

            $(".formContainer").click(function(event){
                event.stopPropagation();
                });
            $("#submit").click(function () {
                 $.ajax({
                 type: "POST",
                 url: "wx.php?do=dial",
                 data: "uid="+$('#uid').val()+"&viewuid="+$('#viewuid').val()+"&dialprice="+$('#dialprice').val()+"&diallevel="+$('#diallevel').val()+"&username="+$('#username').val()+"&dialid="+$('#dialid').val()+"&tel="+$('#tel').val()+"&dial=1",//提交表单，相当于CheckCorpID.ashx?ID=XXX
                  async: true,                    
                    success: function (data) {
                      $(".t-button").hide();
                      $(".expressInfo").fadeOut();
                        alert("请等待工作人员确认，到时会以电话确认");
                    }
                })
             })
       

           
           
            });
            
    </script>
     <?php if(($_COOKIE['uchome_viewuid'])) { ?>
    <?php if(($dial)) { ?>
    <?php if((empty($dialbuy1))) { ?>
<script>
$(function() {

$(".t-button").click(function() {
 $.ajax({ 
        type: 'POST', 
        url: "wx.php?do=dial&uid=<?=$_GET['uid']?>&viewuid=<?=$_COOKIE['uchome_viewuid']?>&dialid="+$('#dialid').val()+"", 
        dataType: 'json', 
        cache: false, 
        error: function(){ 
            alert('出错了！'); 
            return false; 
        }, 
        success:function(json){ 
            $(".t-panel").unbind('click').css("cursor","default"); 
            var a = json.angle; //角度 
            var p = json.prize; //奖项 
            var id = json.id; //奖项等级 
            $(".t-panel").rotate({ 
                duration:3000, //转动时间 
                angle: 0, 
                animateTo:1800+a, //转动角度 
                easing: $.easing.easeOutSine, 
                callback: function(){ 
                   // var con = confirm('抽到'+p+'');
                   if(p!='123abc'){
                    $(".expressInfo").fadeIn();
                    $("#dialprice").val(p);
                    $("#diallevel").val(id);
                    $(".turntable").hide();
                    $(".turntable").after("<div class='alert mt10'>你获得"+p+"</div>");
                }else{
                  $(".turntable").hide();
                  $(".turntable").after("<div class='alert mt10'>谢谢参与</div>");
                  alert("谢谢参与");
                } 
                     
                    
                } 
            }); 
        } 
    }); 


})

});
</script>
    <?php } ?>
    <?php } ?>
    <?php } ?>

    <div class="expressInfo">
        <div class="formContainer bc tc" style="height:200px;">
        <form method="post" action="wx.php?do=dial" name="buyform">
            <h1 id="formTitle">中奖确认信息</h1>
            <input type="text" placeholder="姓名" id="username" name="username" value="<?=$_COOKIE['uchome_username']?>" class="inputContainer" />
            <br />
            <input type="text" placeholder="电话"id="tel" name="tel" value="<?=$_COOKIE['uchome_tel']?>" class="inputContainer" />
            <br />
            填写信息，管理员会在7个工作日内与你联系。
            <div id="zhong">
                  <input type="button" id="submit" class="buttonSubmit"   value="提交">
                  <input type="button" id="buttonSubmit"  class="buttonSubmit" style="margin-left:30px;" value="取消">
            </div>
                  <input type="hidden" id="dialid" name="dialid" value="<?=$dial['dialid']?>">
                  <input type="hidden" id="uid" name="uid" value="<?=$_GET['uid']?>"/>
                  <input type="hidden" id="viewuid" name="viewuid" value="<?=$_COOKIE['uchome_viewuid']?>"/>
                  <input type="hidden" name="dial" value="1">
                  <input type="hidden" id="dialprice" name="dialprice" value="">
                  <input type="hidden" id="diallevel" name="diallevel" value="">
        </div> <!-- formContainer -->
        </form> 
    </div> <!-- expressInfo --> 
     <div class="expressInfo1">
        <div class="formContainer1 bc tc">
        <form method="post" action="wx.php?do=dial">
            <h1 id="formTitle">密码确认</h1>
            <input type="text" placeholder="密码" name="password"  class="inputContainer" />
            <br />

            <input type="submit" class="buttonSubmit" value="提交">
            <input type="hidden" id="uid" name="uid" value="<?=$_GET['uid']?>"/>
            <input type="hidden" id="gid" name="gid" value="<?=$_GET['id']?>"/>
            <input type="hidden" id="viewuid" name="viewuid" value="<?=$_GET['viewuid']?>"/>
            <input type="hidden" name="moblieclicknum" value="<?=$_GET['moblieclicknum']?>">
            <input type="hidden" name="password1" value="1">
            <input type="hidden" id="wxkey" name="wxkey" value="<?=$_GET['wxkey']?>"/>
        </div> <!-- formContainer -->
        </form> 
    </div> <!-- expressInfo --> 
</html><?php ob_out();?>