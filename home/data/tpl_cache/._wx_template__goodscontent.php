<?php if(!defined('IN_UCHOME')) exit('Access Denied');?><?php subtplcheck('./wx/template//goodscontent', '1387357230', './wx/template//goodscontent');?><!DOCTYPE html>
<html>
    <head>
    	<title><?=$wei['subject']?></title>
<meta charset = "utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no"  />
        <meta content="telephone=no" name="format-detection" />
 <?php if($_GET['moblieclicknum']=='1'||$_GET['moblieclicknum']=='0') { ?>
        <link rel = "stylesheet" type = "text/css" href = "./template/css/main.css">
        <link rel="stylesheet" href="./template/css/base.css" />
<link rel="stylesheet" href="./template/css/expressInfo.css" />
        <link rel="stylesheet" href="./template/change/css/goodsshoping.css" />
        <script type="text/javascript" src="./template/change/js/myall.js"></script>
        <?php } else { ?>
        <link rel = "stylesheet" type = "text/css" href = "./template/<?=$_GET['moblieclicknum']?>/css/main.css">
        <link rel="stylesheet" href="./template/<?=$_GET['moblieclicknum']?>/css/base.css" />
 <link rel="stylesheet" href="./template/<?=$_GET['moblieclicknum']?>/css/expressInfo.css" />
        <link rel="stylesheet" href="./template/<?=$_GET['moblieclicknum']?>/change/css/goodsshoping.css" />
        <script type="text/javascript" src="./template/change/js/myall.js"></script>
        <?php } ?>
        <style type="text/css">
        #bg,#bg2{ display: none;  position: fixed;  top: 0%;  left: 0%;  width: 100%;
            height: 100%;  background:url(./template/img/guide_bg.png);
            z-index:1001;/*  -moz-opacity: 0.7;  opacity:.70;  filter: alpha(opacity=70);*/}
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
              <li >
                    <span class="span1" style="padding-right:40px;">{{= username}}&nbsp;&nbsp;&nbsp;购买数:{{= number}}<div style="clear: both"></div></span><span class="span2" style="float: left;"><p style="color:#7d7b7b">{{= dateline}}</p></span><div style="clear: both"></div>
                    <?=BLOCK_TAG_START?>if codestatus!='0'<?=BLOCK_TAG_END?>
                    <span style="color:red">优惠码(已正确填写):优惠{{= code.code}}元<br/></span>
                    <?=BLOCK_TAG_START?>/if<?=BLOCK_TAG_END?>
                    <?php if($_GET['zhong']=='1') { ?>
                    <span>购买物品:"{{= more.subject}}"</span>,<br/>
                    <span>地址:{{= place}}<br/></span>
                    <span>联系电话:{{= tel}}</span>
                    <?=BLOCK_TAG_START?>if buystatus=='PayOnDelivery'<?=BLOCK_TAG_END?>
                    <span>货到付款</span>
                    <?=BLOCK_TAG_START?>/if<?=BLOCK_TAG_END?>
                    <?=BLOCK_TAG_START?>if buystatus=='PayOnLine'<?=BLOCK_TAG_END?>
                    <span>在线支付</span>
                    <?=BLOCK_TAG_START?>/if<?=BLOCK_TAG_END?>
                    <?=BLOCK_TAG_START?>if buystatus=='PayOnShop'<?=BLOCK_TAG_END?>
                    <span>到店提货</span>
                    <?=BLOCK_TAG_START?>/if<?=BLOCK_TAG_END?>
                    <br/>
                      <a href="wx.php?do=upload&calluid={{= uid}}&questionuid=<?=$_GET['uid']?>&dialuid=<?=$_COOKIE['uchome_viewuid']?>" style="float:left;"><input type="button" style="width:60px;" class="add_btn" value="私信"> </input></a>
                      <form action="wx.php?do=upload" method="post"><input type="submit" class="add_btn" value="确认发货"> </input><input type="hidden" class="add_btn" name="goodscodid" value="{{= id}}"> </input><input type="hidden" class="add_btn" name="uid" value="{{= uid}}"> </input><input type="hidden" class="add_btn" name="gid" value="{{= gid}}"> </input><input type="hidden" class="add_btn" name="viewuid" value="{{= viewuid}}"></input><input type="hidden" id="wxkey" name="wxkey" value="<?=$_GET['wxkey']?>"/></form>
                    <?php } ?> 
                   
                </li>  
                    
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
      <?=$appname?>
  </span>
    </div> <!--feedhead-->
    <div style="clear: both"></div>


<div class = "article" style="padding-bottom: 70px">
            <img src="http://v5.home3d.cn/home/<?=$wei['imageurl']?>" style="width:100%;">
<h3><?=$wei['subject']?><?php if($code) { ?>&nbsp;&nbsp;<span style="color:red;">下单赠送优惠码</span><?php } ?></h3> 
            
<!-- <span class = "job_content_span subtitle">预约（87）</span> -->
<span class = "job_content_span subtitle" style="margin-top:5px;">阅读（<?=$wei['viewnum']?>）</span>
<div class = "article_content">
                <span style = "display:block; padding-bottom: 8px;font-size:20px;" >
                	<span>价    格:<b class="colour"> <?=$wei['curprice']?>元</b></span><br />
                	
                </span>
                <p>
                     <?=$message?>
                </p>
</div>


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



         	<?php if($wei['taobaourl']) { ?>
<input  style="margin-top: 40px" type = "button" onclick='gototaobao("<?=$wei['taobaourl']?>")' class = "dial_btn btn" value = "购买" />
<?php } ?>
<?php if($wei['goodscod']&&$wei['taobaourl']) { ?>
      <?php if($wei['goodscod']) { ?>
<!-- <input style="margin-top: 20px" type = "button" id="buttonBuy"  class = "dial_btn btn" value = "货到付款" /> -->
      <?php } ?>
            <!-- <a href="wx.php?uid=<?=$_GET['viewuid']?>&do=feed&wxkey=<?=$_GET['wxkey']?>&idtype=goods"><input style="margin-top: 20px" type = "button"  class = "dial_btn btn" value = "更多商品" /></a>
            <div class="ViewOrder" id="buttonBuy1">商家查看订单详情</div> -->
            <?php } else { ?>
             <?php if($wei['goodscod']) { ?>
            <!-- <input style="margin-top: 20px" type = "button" id="buttonBuy"  class = "dial_btn btn" value = "货到付款" /> -->
             <?php } ?>
            <!-- <a href="wx.php?uid=<?=$_GET['viewuid']?>&do=feed&wxkey=<?=$_GET['wxkey']?>&idtype=goods"><input style="margin-top: 20px" type = "button"  class = "dial_btn btn" value = "更多商品" /></a>
            <div class="ViewOrder" id="buttonBuy1">商家查看订单详情</div> -->

            <?php } ?>
</div>
        <div class = "comment" style="margin-bottom: 40px">

          <ul class = "comment_list" style="">
            <div id="ajax"></div>
           <div id="detail-panel"></div>
            </ul>
             <br/>
            <input type = "button" style="color: #6b6b6b;background-color: #f0f0f0 !important;"
                   onclick="getDetail($('#idtype').val(),$('#id').val(), $('#uid').val(), $('#page').val(), $('#perpage').val());" value = "------更多------" class = "more_button"  />
        </div>
        <div class="goods_content_bottom">
       <table>
           <tr>
               <td class="goods_bottom_td1">
                 <span><img src="./template/change/img/money2.png"></span>
                 <span class="goods_bottom_span" id="buynow">立即购买</span>
               </td>
               <td class="goods_bottom_td1" id="add">
                 <span><img src="./template/change/img/shoppingcar3.png"></span>
                 <span class="goods_bottom_span" id="addtocar">加入购物车</span>
               </td>
               <td class="goods_bottom_td2">
                 <a href="wx.php?do=car&uid=<?=$_GET['uid']?>"><img src="./template/change/img/shoppingcar4.png"></a>

               </td>
           </tr>
       </table>
      </div>
<input type="hidden" id="wxkey" name="wxkey" value="<?=$_GET['wxkey']?>"/>
    	<input type="hidden" id="id" name="id" value="<?=$_GET['id']?>"/>
    	<input type="hidden" id="idtype" name="idtype" value="<?=$_GET['idtype']?>"/>
    	<input type="hidden" id="type" name="type" value="<?=$_GET['type']?>"/>
    	<input type="hidden" id="uid" name="uid" value="<?=$_GET['viewuid']?>"/>
      <input type="hidden" id="viewuid" name="viewuid" value="<?=$_GET['viewuid']?>"/>
    	<input type="hidden" id="page" name="page" value="1"/>
    	<input type="hidden" id="perpage" name="perpage" value="10"/>

      <script type="text/javascript">
        $(document).ready(function () {
            var id=$("#id").val();
            var uid=$('#uid').val();
          $("#buynow").click(function () {
            $.ajax({
            //dataType:"jsonp",
            url:"wx.php?do=upload",
            type: "POST",
            data:{
                "addtocar":'1',
                "id":id,
            },
            success:function(data){
             window.location.href="wx.php?do=car&uid="+uid+""; 
              },
            });
          });
          $("#addtocar").click(function () {
             $.ajax({
            //dataType:"jsonp",
            url:"wx.php?do=upload",
            type: "POST",
            data:{
                "addtocar":'1',
                "id":id,
            },
            success:function(data){
             $("#add").css({background:"red"});
             $("#addtocar").html("已加入购物车");
              },
            });
          });
        });

      </script>
    <script type="text/javascript">

        $(function(){
            $(".comment_list .commentContainer").css("display","none");
            $("#detail-panel li span").css({width:"1em",overflow:"hidden",display:"block",textOverflow:"ellipsis",whiteSpace:"nowrap"});
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
          var tel=$('#tel').val();
          if(tel.length!=11){
            alert("手机号码填写长度不对");
          }else{
          if($("#username").val()==""||$("#tel").val()==""||$("#place").val()==""||$("#number").val()==""){
            alert("邮寄信息中存在空值");
          }else{
          $.ajax({
                 type: "POST",
                 url: "wx.php?do=upload",
                 data: "uid="+$('#uid').val()+"&gid="+$('#gid').val()+" &viewuid="+$('#viewuid').val()+" &moblieclicknum="+$('#moblieclicknum').val()+"&wxkey="+$('#wxkey').val()+"&username="+$('#username').val()+"&tel="+$('#tel').val()+"&number="+$('#number').val()+"&code="+$('#code').val()+"&discode="+$('#discode').val()+"&place="+$('#place').val()+"&buy=1",//提交表单，相当于CheckCorpID.ashx?ID=XXX
                  async: true,                    
                    success: function (data) {
                      if(data=='1'){
                        alert("优惠码填写错误");
                      }else if(data=='2'){
                        alert("此优惠码与你绑定信息不符合");
                      }else{

                      $("#zhong").html("<p style='width:210px;text-align:center;margin:0 auto;'>你已提交订单，若想继续下单，请刷新页面</p>");
                      $(".expressInfo").fadeOut();
                       $('#ajax').append("<li><span style='padding-right:40px;'>"+$('#username').val()+"</span>购买数:"+$('#number').val()+"<p style='float:right;'>现在</p><br/></li>");//输出提交的表表单
                       <?php if($code) { ?>
                       top.location="wx.php?do=upload&codename="+$('#username').val()+"&id=<?=$_GET['id']?>&uid=<?=$_GET['uid']?>";
                       <?php } ?>
                     }
                    },  //操作成功后的操作！msg是后台传过来的值
                });
                } 
              }
                 });
              });
  </script>

<div class="expressInfo">
<div class="formContainer bc tc" <?php if($code) { ?>style="height:380px;"<?php } ?>>
<form method="post" action="wx.php?do=upload" name="buyform">
<h1 id="formTitle">邮寄信息</h1>
<input type="text" placeholder="姓名" id="username" name="username" value="<?=$_COOKIE['uchome_username']?>" class="inputContainer" />
<br />
<input type="text" placeholder="电话"id="tel" name="tel" value="<?=$_COOKIE['uchome_tel']?>" class="inputContainer" />
<br />
<input type="text" placeholder="购买数量" id="number" name="number" value="<?=$_COOKIE['uchome_number']?>" class="inputContainer" />
<br />
<textarea  name="place" rows="3" class="inputContainer" id="place"  placeholder="地址" ><?=$_COOKIE['uchome_place']?></textarea>
<br />
      <?php if($code) { ?>
      <input type="text" placeholder="优惠码" id="code" name="code" class="inputContainer" />
      <input type="hidden" name="discode" id="discode" value="1">
      <br />
        <?php } else { ?>
       <input type="hidden" name="code" id="code" value="">

      <?php } ?>
            <div id="zhong">
      <input type="button" id="submit" class="buttonSubmit"   value="提交">
                  <input type="button" id="buttonSubmit"  class="buttonSubmit" style="margin-left:30px;" value="取消">
            </div>
       <input type="hidden" id="uid" name="uid" value="<?=$_SGLOBAL['supe_uid']?>"/>
            <input type="hidden" id="gid" name="gid" value="<?=$_GET['id']?>"/>
      <input type="hidden" id="viewuid" name="viewuid" value="<?=$_GET['viewuid']?>"/>
            <input type="hidden" name="buy" value="1">
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
            <input type="hidden" id="gid" name="gid" value="<?=$_GET['id']?>"/>
            <input type="hidden" id="viewuid" name="viewuid" value="<?=$_GET['viewuid']?>"/>
            <input type="hidden" name="moblieclicknum" value="<?=$_GET['moblieclicknum']?>">
            <input type="hidden" name="password1" value="1">
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