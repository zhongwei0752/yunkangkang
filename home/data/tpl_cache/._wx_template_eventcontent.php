<?php if(!defined('IN_UCHOME')) exit('Access Denied');?><?php subtplcheck('./wx/template/eventcontent', '1387334530', './wx/template/eventcontent');?><!DOCTYPE html>
<html>
    <head>
    	<title><?=$wei['title']?></title>
<meta charset = "utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no"  />
        <meta content="telephone=no" name="format-detection" />
 <?php if($_GET['moblieclicknum']=='1'||$_GET['moblieclicknum']=='0') { ?>
        <link rel = "stylesheet" type = "text/css" href = "./template/css/main.css">
        <link rel="stylesheet" href="./template/css/base.css" />
<link rel="stylesheet" href="./template/css/expressInfo.css" />
        <link rel="stylesheet" href="./template/css/myall.css" />
        <?php } else { ?>
        <link rel = "stylesheet" type = "text/css" href = "./template/<?=$_GET['moblieclicknum']?>/css/main.css">
        <link rel="stylesheet" href="./template/<?=$_GET['moblieclicknum']?>/css/base.css" />
<link rel="stylesheet" href="./template/<?=$_GET['moblieclicknum']?>/css/expressInfo.css" />
        <link rel="stylesheet" href="./template/<?=$_GET['moblieclicknum']?>/css/myall.css" />
        <?php } ?>
        <style type="text/css">
        #bg,#bg2{ display: none;  position: fixed;  top: 0%;  left: 0%;  width: 100%;
            height: 100%;  background:url(./template/img/guide_bg.png);
            z-index:1001;/*  -moz-opacity: 0.7;  opacity:.70;  filter: alpha(opacity=70);*/}
        input
        {
            border-radius: 0 !important;
        }
        #detail-panel li .span1
        {
            width: 15em ;
            overflow: hidden ;
            display: block;
           text-overflow: ellipsis;
            white-space: nowrap;
            float: left;
            vertical-align: middle;


        }
        #detail-panel li .span2
        {
            width: 10em ;
            overflow: hidden ;
            display: block;
            text-overflow: ellipsis;
            white-space: nowrap;
            float:left;
            vertical-align: middle;
            color: #7d7b7b;

        }
        .span2
        {
            color: #7d7b7b;
        }


        </style>





<script src="template/js/jquery-v2.0.2.js"></script>
     	<script type="text/javascript" src="template/js/jquery.tmpl.min.js"></script>

     	<script type="text/javascript" src="template/js/detail.js"></script>
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


</head>
<body> 
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
      活动
  </span>
    </div> <!--feedhead-->
    <div style="clear: both"></div>


<div class = "article" style="padding-bottom: 40px">
            
<h3><?=$wei['title']?></h3>
            
<!-- <span class = "job_content_span subtitle">预约（87）</span> -->
<span class = "job_content_span subtitle" style="margin-top:5px;">阅读（<?=$wei['viewnum']?>）</span>
<div class = "article_content">
                <span style = "display:block; padding-bottom: 8px;font-size:20px;" >
                <?php if($wei['poster']) { ?>
                	<img src="../attachment/<?=$wei['poster']?>" style="width:100%;">
                	<?php } ?>
                </span>
<p>活动类型:<?=$wei1['classname']?></p>
<p>活动地点:<?=$wei['province']?> <?=$wei['city']?> <?=$wei['location']?></p>
<p>活动时间:<?php echo sgmdate("m月d日 H:i", $wei[starttime]) ?> - <?php echo sgmdate("m月d日 H:i", $wei[endtime]) ?></p>
<p>截止报名:
<?php if($wei['deadline']>=$_SGLOBAL['timestamp']) { ?>
<?php echo sgmdate("m月d日 H:i", $wei[deadline]) ?>
<?php } else { ?>
报名结束
<?php } ?>
</p>
                <p style="">
                    <?=$message?>
                </p>
</div>

            <?php if($value3) { ?>
            <input style="margin-top: 20px;margin-bottom: 15px" type = "button"   class = "dial_btn btn" value = "你已报名成功" />
            <?php } else { ?>
            <input style="margin-top: 20px;margin-bottom: 15px" type = "button" id="buttonBuy"  class = "dial_btn btn" value = "我要报名" />
            <?php } ?>

            <div class="LookForPhone">
                <span class="LookForPhone_s1">已有<?=$wei['membernum']?>人报名</span>
                <span class="LookForPhone_s2" id="buttonBuy1">查看已报名人的电话</span>
                <div style="clear: both"></div>
            </div>



            <div class="event_content_people">

                <table>

                    <div id="ajax"></div>
                    <div id="detail-panel" style="width: 100%;border-collapse:collapse;"></div>
                </table>
            </div>
             <div style="clear: both"></div>


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
                </div>
                <div style="clear: both"></div>
                <?php if($uidwxkey['weixinname']) { ?>
                <div style="margin:0 auto;padding:0;height: 30px;width:100%;text-align: center;margin-top: 10px">
                    <h3 style="font-size:14px;">手机用户请关注微信公众账号：<?=$uidwxkey['weixinname']?></h3></div>
                <div style="clear: both"></div>
                <?php } ?>
            </div>
            <div style="clear: both"></div>


<!--	<div id="friend" class="friend_wrapper" style="width:100%;height:115px;border:1px dashed #999;margin:0 auto;text-align:center;">
                <div style="text-align: center;margin: 0 auto;width: 270px;height: 30px;margin-top: 20px">
                <div style="margin:0 auto;padding:0;height: 30px;width: 120px;float: left"><a id="" class="friend_btn" style="" onclick="showDIv()">
                       <img src="./template/img/repost_icon.png" alt="">
                       <span>发送给朋友</span>
             </a>  </div>
                <div style="margin:0 auto;padding:0;height: 30px;width: 120px;float: left;margin-left:20px">  <a id="" class="friend_btn" style="" onclick="showFriendDIv()">
                       <img src="./template/img/friend_circle.png" alt="">
                       <span>分享到朋友圈</span>
             </a></div>
                </div>

            <br/><br/><br/>    -->
               <?php if($uidwxkey['weixinname']) { ?>
            <!--    <div style="margin:0 auto;padding:0;height: 30px;width:100%;text-align: center;margin-top: -50px"> <h3 style="font-size:14px;">手机用户请关注微信公众账号：<?=$uidwxkey['weixinname']?></h3></div> -->
             <?php } ?>
            <!--    <div style="clear: both"></div> -->
            <!--    </div><!-- / -->




          <!--  <span style="font-size:16px;float:right;padding-top:24px;padding-bottom:0px" id="buttonBuy1"> 点击查看报名详情</span>   -->

</div>
        <div class = "comment" >




         <!-- <ul class = "comment_list" style="">
            </ul>  之前是报名列表位置-->

          <!--  <input type = "button" style="color: #6b6b6b;background-color: #f0f0f0"
            onclick="getDetail($('#idtype').val(),$('#id').val(), $('#uid').val(), $('#page').val(), $('#perpage').val());"
            value = "更多" class = "more_button"  />   -->
        </div>
<input type="hidden" id="wxkey" name="wxkey" value="<?=$_GET['wxkey']?>"/>
    	<input type="hidden" id="id" name="id" value="<?=$_GET['id']?>"/>
    	<input type="hidden" id="idtype" name="idtype" value="<?=$_GET['idtype']?>"/>
    	<input type="hidden" id="type" name="type" value="<?=$_GET['type']?>"/>
    	<input type="hidden" id="uid" name="uid" value="<?=$_GET['viewuid']?>"/>
    	<input type="hidden" id="page" name="page" value="1"/>
    	<input type="hidden" id="perpage" name="perpage" value="10"/>




    <script type="text/javascript">

        $(function(){
            $(".comment_list .commentContainer").css("display","none");
            $("#detail-panel li span").css({width:"1em",overflow:"hidden",display:"block",textOverflow:"ellipsis",whiteSpace:"nowrap"});
            var eventphone=0;

         /*   $(".LookForPhone_s2").click(function(){
                if(eventphone%2==0)
                {
                  //  $(".eventphone").css({"display":"block"}) ;
                    $(".LookForPhone_s2").html("隐藏已报名人的电话") ;
                }
                else
                {
                 //   $(".eventphone").css({"display":"none"}) ;
                    $(".LookForPhone_s2").html("查看已报名人的电话") ;
                }
                eventphone=eventphone+1;
            })    */
        })

     </script>


    	<script type="text/javascript">
$(document).ready(function(){
$("#buttonBuy").click(function(){
$(".expressInfo").fadeIn();
});

//点击表格外的地方时消失
$(".expressInfo").click(function(){
$(".expressInfo").fadeOut();
});

//阻止事件冒泡
$(".formContainer").click(function(event){
event.stopPropagation();
});

$("#buttonBuy1").click(function(){
                $(".expressInfo1").fadeIn();
                });

            //点击表格外的地方时消失
            $(".expressInfo1").click(function(){
                $(".expressInfo1").fadeOut();
                });
            
            $("#buttonSubmit").click(function(){
                $(".expressInfo").fadeOut();
                });
            //阻止事件冒泡
            $(".formContainer1").click(function(event){
                event.stopPropagation();
                });

            });
            
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
        var tel=$("#eventtel").val();
        if(tel.length!=11)
        {
          alert("手机长度不对");
        }
        else
        { 
          if($("#eventname").val()==""||$("#eventtel").val()==""){
            alert("报名信息中存在空值")
          }else{
          $.ajax({
                 type: "POST",
                 url: "wx.php?do=upload",
                 data: "uid="+$('#uid').val()+"&eid="+$('#eid').val()+" &viewuid="+$('#viewuid').val()+" &moblieclicknum="+$('#moblieclicknum').val()+"&wxkey="+$('#wxkey').val()+"&eventname="+$('#eventname').val()+"&eventtel="+$('#eventtel').val()+"&go=1",//提交表单，相当于CheckCorpID.ashx?ID=XXX
                  async: true,                    
                    success: function (data) {
                      $("#submit").attr("disabled", true);
                      $("#zhong").html("<p style='width:210px;text-align:center;margin:0 auto;'>你已报名成功。</p>");
                      $(".expressInfo").fadeOut();
                      $("#buttonBuy").val("你已经成功报名");
                       $('#ajax').prepend("<li><span style='padding-right:40px;'>"+$('#eventname').val()+"<p style='float:right;'>现在</p><br/></li>");//输出提交的表表单
                    },  //操作成功后的操作！msg是后台传过来的值
                });
                } 
              }
                 });
              });
  </script>

<div class="expressInfo">
<div class="formContainer bc tc">
<form method="post" action="wx.php?do=upload" name="buyform">
<h1 id="formTitle">填写信息</h1>
<input type="text" placeholder="姓名" id="eventname" name="eventname" value="<?=$_COOKIE['uchome_eventname']?>" class="inputContainer" />
<br />
<input type="text" placeholder="电话"id="eventtel" name="eventtel" value="<?=$_COOKIE['uchome_eventtel']?>" class="inputContainer" />
<br />

            <div id="zhong">
     <input type="button" id="submit" class="buttonSubmit"   value="提交">
                  <input type="button" id="buttonSubmit"  class="buttonSubmit" style="margin-left:30px;" value="取消">
            </div>
<input type="hidden" id="uid" name="uid" value="<?=$_GET['uid']?>"/>
            <input type="hidden" id="eid" name="eid" value="<?=$_GET['id']?>"/>
            <input type="hidden" name="go" value="1">
            <input type="hidden" id="wxkey" name="wxkey" value="<?=$_GET['wxkey']?>"/>
</div> <!-- formContainer -->
</form> 
</div> <!-- expressInfo --> 

    <div class="expressInfo1">
        <div class="formContainer1 bc tc">
        <form method="post" action="wx.php?do=upload">
            <h1 id="formTitle">密码确认</h1>
            <input type="text" placeholder="密码" name="password"  class="inputContainer" />
            <br />

            <input type="submit" class="buttonSubmit" value="提交">
            <input type="hidden" id="uid" name="uid" value="<?=$_GET['uid']?>"/>
            <input type="hidden" id="eid" name="eid" value="<?=$_GET['id']?>"/>
            <input type="hidden" id="viewuid" name="viewuid" value="<?=$_GET['viewuid']?>"/>
            <input type="hidden" name="moblieclicknum" value="<?=$_GET['moblieclicknum']?>">
            <input type="hidden" name="eventpassword" value="1">
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