<?php if(!defined('IN_UCHOME')) exit('Access Denied');?><?php subtplcheck('./wx/template/stratchcontent', '1387354886', './wx/template/stratchcontent');?>﻿<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no"  />
    <meta content="telephone=no" name="format-detection" />
    <meta charset="UTF-8" />
    <link rel="stylesheet" href="./template/css/expressInfo.css" />
    <?php if($_GET['moblieclicknum']=='1'||$_GET['moblieclicknum']=='0') { ?>
    <link rel="stylesheet" href="./template/css/myall.css" />
    <?php } else { ?>
    <link rel="stylesheet" href="./template/<?=$_GET['moblieclicknum']?>/css/myall.css" />
    <?php } ?>


  <!--  <script type="text/javascript" src="./template/<?=$_GET['moblieclicknum']?>/js/jquery-1.10.2.js"></script>
    <script type="text/javascript" src="./template/<?=$_GET['moblieclicknum']?>/js/myall.js"></script> -->
    <script type="text/javascript" src="./template/js/jquery-1.10.2.js"></script>
    <script type="text/javascript" src="./template/js/myall.js"></script>


    <script src="./template/js/jquery-v2.0.2.js"></script>
    <script type="text/javascript" src="./template/js/jquery.tmpl.min.js"></script>
    <script type="text/javascript" src="./template/js/detail.js"></script>

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>

    <style type="text/css">
        #bg,#bg2{ display: none;  position: fixed;  top: 0%;  left: 0%;  width: 100%;  height: 100%;
            background:url(./template/img/guide_bg.png);  z-index:1001;}

        .ward
        {
            width:100px;
            float:left;
        }
        .guagua
        {
            margin:0px auto;
            margin-top: -50px;
            width:100%;
        }
        #prize
        {
            padding-top:8px;
            background:#CCCCCC;
            text-align:center;
            font-size:20px;
            color:#1DB8AE;
            margin-top:10px;
            margin-bottom: 10px;
            width:110px;
            height:28px;
            border: 1px dashed #999999;
        }

    </style>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
    <script type="text/javascript" src="template/js/jquery.tmpl.min.js"></script>
    <script type="text/javascript" src="template/js/detail.js"></script>
    <script type="text/javascript" src="template/js/wScratchPad.js"></script>
    <script id="detailTemplate" type="text/x-jquery-tmpl">


        <tr >
            <td class="event_people_td" style="width:5000px;background-color:#F7F7F7;">
                <span class="event_people_sp1">{{= username}}</span><span class="event_people_sp2">{{= dateline}}</span>
                <div style="clear:both"></div>
                <?php if($_GET['zhong']=='1') { ?>
                <p  class="eventphone" >联系电话:{{= tel}}</p>
                <?php } ?>
            </td>

        </tr>

    </script>

    <title><?=$appname?></title>
</head>
<body style="" onload="myfunction()">

<div id="bg" onclick="hideDiv();">
    <img src="./template/img/guide.png" alt="" style="position:fixed;top:0;right:16px;">
</div>
<div id="bg2" onclick="hideFriendDIv();">
    <img src="./template/img/guide_firend.png" alt="" style="position:fixed;top:0;right:16px;">
</div>

<div class="feedhead">
    <a href="javascript:history.back(-1)">
        <span class="back1">
            <img src="./template/img/back1.png">
        </span>
    </a>
    <a href="wx.php?do=home&uid=<?=$_GET['uid']?>">
        <span class="home1">
        <img src="./template/img/home1.png">
        </span>
    </a>
  <span class="feedheadspan2 feedheadspan2_1">
      刮刮乐
  </span>
</div> <!--feedhead-->
<div style="clear: both"></div>

<div class="feedbody">
    <div class="bodycontent">
      <div class="content">

          <!--通用-->
          <p class="ctitle">
              <?=$wei['subject']?>
          </p>
          <!--大擂台专有，刮刮乐共用-->
          <div class="debatetime">
            <div>
             <span class="debatetime_s1">活动开始时间：<?php echo sgmdate('Y-m-d H:i:s',$wei[dateline]); ?></span>
            </div>
              <div>
                  <span class="debatetime_s1">活动结束时间：<?php echo sgmdate('Y-m-d H:i:s',$wei[endtime]); ?></span>
              </div>

          </div><!--debatetime-->
          <!--通用-->
          <div class="cbody">
              <p style="color:  #3AA09B;font-size: 16px">活动介绍</p>
              <?=$wei['message1']?>
          </div><!--cbody-->


          <!--刮刮乐专有-->
          <div class="Lottery">
            <h1>刮奖区</h1>
            <?php if($wei['endtime'] < $_SGLOBAL['timestamp'] ) { ?>
              <?php if(empty($wei2)) { ?>
            <div id="prize"><?=$res['yes']?></div>

              <div class="guagua">
                  <div id="wScratchPad" style="display:inline-block;/* position:absolute; left:18px; top:192px;position:relative;top: -228px;*/border:none;">
                      <?php if(!empty($wei2)) { ?>
                      <div style="width: 120px;height: 40px"></div>
                      <?php } ?>
                  </div><!--wScratchPad-->
                  <input type="hidden" id="prize_id" value="<?=$wei3['award_id']?>" />


                  <?php if(empty($wei2)) { ?>
                  <script type="text/javascript" src="./template/js/wScratchPad.js"></script>
                  <script type="text/javascript">
                      var sp = $("#wScratchPad").wScratchPad({
                          scratchDown: function(e, percent){$("#percent_scratched").html(percent)},
                          scratchMove: function(e, percent){$("#percent_scratched").html(percent)},
                          scratchUp: function(e, percent){
                              if (percent>30) {
                                  if($("#prize_id").val()<4){
                                      $(".expressInfo").fadeIn();
                                  }
                              }
                          }
                      });
                      function set_image_bg() {
                          sp.wScratchPad('image', './images/slide2.jpg');
                          sp.wScratchPad('reset');
                      }
                      function set_image_overlay() {
                          sp.wScratchPad('image2', './images/slide3.jpg');
                          sp.wScratchPad('reset');
                      }
                      function enabled(toggle) {
                          sp.wScratchPad('enabled', toggle);
                      }
                  </script>
                  <?php } ?>
              </div> <!--guagua-->
            

            <p>请涂抹上面的灰色块刮奖</p>
              <?php } else { ?>
              <p><font color="red" font-size="24px">活动已结束，下次请早...</font></p>
              <?php } ?>
            <br>
              <?php } else { ?>
              <?php if(($wei3['award_id']=='1')) { ?>
              <div id="prize">一等奖</div>
              <p style="color:red;">您已经参加活动</p>
              <p style="color:#1DB8AE;margin-bottom: 10px;">您获得的奖品是<?=$wei['award1']?></p>
              <?php } else { ?>
              <?php if(($wei3['award_id']=='2')) { ?>
              <div id="prize">二等奖</div>
              <p style="color:red;">您已经参加活动</p>
              <p style="color:#1DB8AE;margin-bottom: 10px;">您获得的奖品是<?=$wei['award2']?></p>
              <?php } else { ?>
              <?php if(($wei3['award_id']=='3')) { ?>
              <div id="prize">三等奖</div>
              <p style="color:red;">您已经参加活动</p>
              <p style="color:#1DB8AE;margin-bottom: 10px;">您获得的奖品是<?=$wei['award3']?></p>
              <?php } else { ?>
              <?php if(($wei3['award_id']=='4')) { ?>
              <div id="prize">谢谢参与</div>
              <p style="color:red;">您已经参加活动</p>
              <p style="color:#1DB8AE;margin-bottom: 10px;">谢谢你的参与！！</p>
              <?php } ?>
              <?php } ?>
              <?php } ?>
              <?php } ?>
              <?php } ?>
            <h1>活动奖励</h1>
            <p>一等奖(<?=$wei['winsum1']?>名)：<?=$wei['award1']?></p>
            <p>二等奖(<?=$wei['winsum2']?>名)：<?=$wei['award2']?></p>
            <p>三等奖(<?=$wei['winsum3']?>名)：<?=$wei['award3']?></p>
            <br>
            <h1>活动参与</h1>
            <p>每次参与人数：<?=$wei['times']?>次</p>
            <p>最多参与人数：不限制</p>
          </div><!--Lottery-->

          <div class="LookForPhone">
              <span class="LookForPhone_s1">已有<?=$wei['joinsum']?>人参加抽奖</span>
              <span class="LookForPhone_s2" id="check">查看获奖者信息</span>

              <div style="clear: both"></div>
          </div>

          <script type="text/javascript">
             /* <?php if($wei['uid']==$_COOKIE['uchome_viewuid']) { ?>
              <span class="LookForPhone_s2" id="check">查看获奖者信息</span>
                  <?php } ?>    */
              $(document).ready(function(){
                  //点击表格外的地方时消失
                  $(".expressInfo").click(function(){
                      $(".expressInfo").fadeOut();
                  });
                  //阻止事件冒泡
                  $(".formContainer").click(function(event){
                      event.stopPropagation();
                  });

                  $("#check").click(function(){
                      $(".expressInfo1").fadeIn();
                  });

                  //点击表格外的地方时消失
                  $(".expressInfo1").click(function(){
                      $(".expressInfo1").fadeOut();
                  });

                  $("#buttonSubmit").click(function(){
                      $(".expressInfo").fadeOut();
                  });
                  $("#buttonSubmit1").click(function(){
                      $(".expressInfo1").fadeOut();
                  });
                  //阻止事件冒泡
                  $(".formContainer1").click(function(event){
                      event.stopPropagation();
                  });

              });
          </script>

          <!--查看抽奖中奖者名单列表-->
          <div class="event_content_people">
          <?php if($haswined) { ?>
          <!--	<h2 align="center"><font color="#1DB8AE">中奖名单</font></h2>   -->
          <?php } ?>
              <table>
              <?php if(is_array($list)) { foreach($list as $value) { ?>
                  <tr >
                      <td class="event_people_td" style="background-color:#F7F7F7;">
                          <span class="event_people_sp1"><?=$value['username']?></span><span class="event_people_sp2"><?php echo sgmdate('Y-m-d',$value['dateline']); ?></span>
                          <div style="clear:both"></div>
                          <?php if($_GET['zhong']) { ?>
                          <p  class="eventphone" >联系电话:<?=$value['number']?></p>
                          <?php } ?>
                      </td>
                  </tr>
              <?php } } ?>
              </table>
          </div><!--event_content_people-->
          <div style="clear: both"></div>

      </div> <!--content-->



        <!--通用-->
        <div class="share_send">
            <div class="button2_button3">
                <a onclick="showDIv()">
                  <span class="button2">
                    <img src="./template/img/transmit.png"><span class="button_word">发送给朋友</span>
                  </span>
                </a>
                <a onclick="showFriendDIv()">
                    <span class="button3">
                        <img src="./template/img/vitasphere.png"><span class="button_word">分享到朋友圈</span>
                    </span>
                </a>
            </div><!--button2_button3-->
            <div style="clear: both"></div>
            <?php if($uidwxkey['weixinname']) { ?>
            <div style="margin:0 auto;padding:0;height: 30px;width:100%;text-align: center;margin-top: 10px">
                <h3 style="font-size:14px;">手机用户请关注微信公众账号：<?=$uidwxkey['weixinname']?></h3></div>
            <div style="clear: both"></div>
            <?php } ?>
        </div> <!--share_send-->
        <div style="clear: both"></div>
        </div><!--content-->
      </div> <!--bodycontent-->
</div> <!--feedbody-->









<input type="hidden" id="wxkey" name="wxkey" value="<?=$_GET['wxkey']?>"/>
<input type="hidden" id="id" name="id" value="<?=$_GET['id']?>"/>
<input type="hidden" id="idtype" name="idtype" value="<?=$_GET['idtype']?>"/>
<input type="hidden" id="type" name="type" value="<?=$_GET['type']?>"/>
<input type="hidden" id="uid" name="uid" value="<?=$_GET['uid']?>"/>
<input type="hidden" id="page" name="page" value="1"/>
<input type="hidden" id="perpage" name="perpage" value="10"/>

<script type="text/javascript">

    $(function(){
        $(".comment_list .commentContainer").css("display","none");
        $("#detail-panel li span").css({width:"1em",overflow:"hidden",display:"block",textOverflow:"ellipsis",whiteSpace:"nowrap"});
    })

</script>



<script>

    function gototaobao(url){
        window.open(url);
    }
</script>

<script type="text/javascript" charset="utf-8">
    function showDIv(){
        document.getElementById('bg').style.display = "block";
    }
    function hideDiv(){
        document.getElementById('bg').style.display = "none";
    }
    function showFriendDIv(){
        document.getElementById('bg2').style.display = "block";
    }
    function hideFriendDIv(){
        document.getElementById('bg2').style.display = "none";
    }


    $(document).ready(function () {
        $("#submit").click(function () {
            var tel=$('#tel').val();
            if(tel.length!=11){
                alert("手机号码填写长度不对");
            }else{ /*if_tel_else*/
                if($("#username").val()==""||$("#tel").val()==""||$("#place").val()==""||$("#number").val()==""){
                    alert("邮寄信息中存在空值")
                }else{
                    $.ajax({
                        type: "POST",
                        url: "wx.php?do=upload",
                        data: "uid="+$('#uid').val()+"&stratchid="+$('#stratchid').val()+" &viewuid="+$('#viewuid').val()+" &moblieclicknum="+$('#moblieclicknum').val()+"&wxkey="+$('#wxkey').val()+"&username="+$('#username').val()+"&tel="+$('#tel').val()+"&number="+$('#number').val()+"&place="+$('#place').val()+"&infor=1",//提交表单，相当于CheckCorpID.ashx?ID=XXX
                        async: true,
                        success: function (data) {
                            // $("#submit").attr("disabled", true);
                            $("#zhong").html("<p style='width:210px;text-align:center;margin:0 auto;'>你已提交订单，若想继续下单，请刷新页面</p>");
                            $(".expressInfo").fadeOut();
                            $('#ajax').append("<li><span style='padding-right:40px;'>"+$('#username').val()+"</span>购买数:"+$('#number').val()+"<p style='float:right;'>现在</p><br/></li>");//输出提交的表表单
                        } //操作成功后的操作！msg是后台传过来的值
                    });
                }
            }   /*if_tel_else*/
        });
    });
</script>

<script type="text/javascript" charset="utf-8">
    $(".buttonSubmit").click(function () {
        var num=$('#number').val();
        if(num.length!=11)
        {
            alert("手机号码填写长度不对");
        }
    });
</script>

<div class="expressInfo">
    <div class="formContainer bc tc">
        <form method="post" action="wx.php?do=upload">
            <h1 id="formTitle">请填写您的中奖信息</h1>
            <input type="text" placeholder="姓名" name="name"  id="name" class="inputContainer" />
            <input type="text" placeholder="手机号码" name="number"  id="number" class="inputContainer" />
            <br />

            <input type="submit" class="buttonSubmit" value="提交">
            <input type="hidden" id="uid" name="uid" value="<?=$_COOKIE['uchome_viewuid']?>"/>
            <input type="hidden" id="stratchid" name="stratchid" value="<?=$_GET['id']?>"/>
            <input type="hidden" name="moblieclicknum" value="<?=$_GET['moblieclicknum']?>">
            <input type="hidden" name="infor" value="1">
            <input type="hidden" id="wxkey" name="wxkey" value="<?=$_GET['wxkey']?>"/>

        </form>
    </div> <!-- formContainer -->
</div> <!-- expressInfo -->

<div class="expressInfo1">
    <div class="formContainer1 bc tc">
        <form method="post" action="wx.php?do=upload">
            <h1 id="formTitle">密码确认</h1>
            <input type="text" placeholder="密码" name="password"  class="inputContainer" />
            <br />

            <input type="submit" class="buttonSubmit" value="提交">
            <input type="hidden" id="uid" name="uid" value="<?=$_GET['uid']?>"/>
            <input type="hidden" id="stratchid" name="stratchid" value="<?=$_GET['id']?>"/>
            <input type="hidden" name="moblieclicknum" value="<?=$_GET['moblieclicknum']?>">
            <input type="hidden" name="password4" value="1">
            <input type="hidden" id="wxkey" name="wxkey" value="<?=$_GET['wxkey']?>"/>
    </div> <!-- formContainer -->
    </form>
</div> <!-- expressInfo -->


</body>

<script>
    var dataForWeixin={
        appId:"",
        MsgImg:"<?=$pic?>",
        TLImg:"<?=$pic?>",
        url:"<?=$url?>",
        title:"<?=$wei['subject']?>",
        desc:"<?=$wei['subject']?>",
        fakeid:"",
        callback:function(){}
    };
    (function(){
        var onBridgeReady=function(){
            WeixinJSBridge.on('menu:share:appmessage', function(argv){
                WeixinJSBridge.invoke('sendAppMessage',{
                    "appid":dataForWeixin.appId,
                    "img_url":dataForWeixin.MsgImg,
                    "img_width":"120",
                    "img_height":"120",
                    "link":dataForWeixin.url,
                    "desc":dataForWeixin.desc,
                    "title":dataForWeixin.title
                }, function(res){(dataForWeixin.callback)();});
            });
            WeixinJSBridge.on('menu:share:timeline', function(argv){
                (dataForWeixin.callback)();
                WeixinJSBridge.invoke('shareTimeline',{
                    "img_url":dataForWeixin.TLImg,
                    "img_width":"120",
                    "img_height":"120",
                    "link":dataForWeixin.url,
                    "desc":dataForWeixin.desc,
                    "title":dataForWeixin.title
                }, function(res){});
            });
            WeixinJSBridge.on('menu:share:weibo', function(argv){
                WeixinJSBridge.invoke('shareWeibo',{
                    "content":dataForWeixin.title,
                    "url":dataForWeixin.url
                }, function(res){(dataForWeixin.callback)();});
            });
            WeixinJSBridge.on('menu:share:facebook', function(argv){
                (dataForWeixin.callback)();
                WeixinJSBridge.invoke('shareFB',{
                    "img_url":dataForWeixin.TLImg,
                    "img_width":"120",
                    "img_height":"120",
                    "link":dataForWeixin.url,
                    "desc":dataForWeixin.desc,
                    "title":dataForWeixin.title
                }, function(res){});
            });
        };
        if(document.addEventListener){
            document.addEventListener('WeixinJSBridgeReady', onBridgeReady, false);
        }else if(document.attachEvent){
            document.attachEvent('WeixinJSBridgeReady'   , onBridgeReady);
            document.attachEvent('onWeixinJSBridgeReady' , onBridgeReady);
        }
    })();
</script>




</html><?php ob_out();?>