<?php if(!defined('IN_UCHOME')) exit('Access Denied');?><?php subtplcheck('./wx/template/9/feedcontent', '1396509335', './wx/template/9/feedcontent');?><!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no"  />
    <link rel="stylesheet" href="./template/9/css/base.css" />
    <link rel="stylesheet" href="./template/9/css/common.css" />
    <link rel="stylesheet" href="./template/9/css/feed.css" />
    <link rel="stylesheet" href="./template/9/css/pageTitle.css" />
    <link rel="stylesheet" href="./template/9/css/pageComment.css" />
    <link rel="stylesheet" href="./template/css/main.css" />
    <link rel="stylesheet" href="./template/9/css/myall.css" />
         <script src="http://code.jquery.com/jquery-1.8.2.min.js"></script>
        <script src="http://code.jquery.com/jquery-1.8.2.min.js"></script>
        <script type="text/javascript" src="template/js/jquery.tmpl.min.js"></script>
        <script type="text/javascript" src="template/js/detail.js"></script>
     <style type="text/css">
        #bg,#bg2{ display: none;  position: fixed;  top: 0%;  left: 0%;  width: 100%;  height: 100%;
            background:url(./template/img/guide_bg.png);  z-index:1001;/*  -moz-opacity: 0.7;  opacity:.70;  filter: alpha(opacity=70);*/}

         .content-text img
         {
             max-width: 100% !important;
             height: auto; !important;

         }

        .btn{
            color: white;
            background-color: #133F5F;
            font-size: large;
            cursor: pointer;
        }

        .btn:hover{
            background-color: #046FA9;
        }

        ::-webkit-input-placeholder { font-size: 16px; }

        input:-moz-placeholder { font-size: 16px; }

     </style>
    <title>企业介绍</title>
    <script id="detailTemplate" type="text/x-jquery-tmpl">
         <div class="head pt20">
            <h1 class="cTitle f20">
            <?=BLOCK_TAG_START?>if industry<?=BLOCK_TAG_END?>
                 <p> {{= industry.subject}}</p>
                 <?=BLOCK_TAG_START?>/if<?=BLOCK_TAG_END?>
                  <?=BLOCK_TAG_START?>if branch<?=BLOCK_TAG_END?>
                 <p> {{= branch.subject}}</p>
                 <?=BLOCK_TAG_START?>/if<?=BLOCK_TAG_END?>
                    <?=BLOCK_TAG_START?>if development<?=BLOCK_TAG_END?>
                 <p> {{= development.subject}}</p>
                 <?=BLOCK_TAG_START?>/if<?=BLOCK_TAG_END?>
                 <?=BLOCK_TAG_START?>if product<?=BLOCK_TAG_END?>
                 <p> {{= product.subject}}</p>
                 <?=BLOCK_TAG_START?>/if<?=BLOCK_TAG_END?>
                 <?=BLOCK_TAG_START?>if introduce<?=BLOCK_TAG_END?>
                 <p> {{= introduce.subject}}</p>
                 <?=BLOCK_TAG_START?>/if<?=BLOCK_TAG_END?>
                 <?=BLOCK_TAG_START?>if cases<?=BLOCK_TAG_END?>
                 <p> {{= cases.subject}}</p>
                 <?=BLOCK_TAG_START?>/if<?=BLOCK_TAG_END?>
                 <?=BLOCK_TAG_START?>if talk<?=BLOCK_TAG_END?>
                 <p> {{= branch.subject}}</p>
                 <?=BLOCK_TAG_START?>/if<?=BLOCK_TAG_END?>
                 <?=BLOCK_TAG_START?>if job<?=BLOCK_TAG_END?>
                 <p> {{= job.subject}}</p>
                 <?=BLOCK_TAG_START?>/if<?=BLOCK_TAG_END?>
                 <?=BLOCK_TAG_START?>if goods<?=BLOCK_TAG_END?>
                 <p> {{= goods.subject}}</p>
                 <?=BLOCK_TAG_START?>/if<?=BLOCK_TAG_END?>
            </h1>
            <div class="cTime pt15">
                <span class="time">
                <?=BLOCK_TAG_START?>if industry<?=BLOCK_TAG_END?>
                 <p> {{= industry.dateline}}</p>
                 <?=BLOCK_TAG_START?>/if<?=BLOCK_TAG_END?>
                  <?=BLOCK_TAG_START?>if branch<?=BLOCK_TAG_END?>
                 <p> {{= branch.dateline}}</p>
                 <?=BLOCK_TAG_START?>/if<?=BLOCK_TAG_END?>
                    <?=BLOCK_TAG_START?>if development<?=BLOCK_TAG_END?>
                 <p> {{= development.dateline}}</p>
                 <?=BLOCK_TAG_START?>/if<?=BLOCK_TAG_END?>
                 <?=BLOCK_TAG_START?>if product<?=BLOCK_TAG_END?>
                 <p> {{= product.dateline}}</p>
                 <?=BLOCK_TAG_START?>/if<?=BLOCK_TAG_END?>
                 <?=BLOCK_TAG_START?>if introduce<?=BLOCK_TAG_END?>
                 <p> {{= introduce.dateline}}</p>
                 <?=BLOCK_TAG_START?>/if<?=BLOCK_TAG_END?>
                 <?=BLOCK_TAG_START?>if cases<?=BLOCK_TAG_END?>
                 <p> {{= cases.dateline}}</p>
                 <?=BLOCK_TAG_START?>/if<?=BLOCK_TAG_END?>
                 <?=BLOCK_TAG_START?>if talk<?=BLOCK_TAG_END?>
                 <p> {{= branch.dateline}}</p>
                 <?=BLOCK_TAG_START?>/if<?=BLOCK_TAG_END?>
                 <?=BLOCK_TAG_START?>if job<?=BLOCK_TAG_END?>
                 <p> {{= job.dateline}}</p>
                 <?=BLOCK_TAG_START?>/if<?=BLOCK_TAG_END?>
                 <?=BLOCK_TAG_START?>if goods<?=BLOCK_TAG_END?>
                 <p> {{= goods.dateline}}</p>
                 <?=BLOCK_TAG_START?>/if<?=BLOCK_TAG_END?></span>
                </span>
            </div>
            
        </script>
          <script id="commentTemplate" type="text/x-jquery-tmpl">
           <li>
                <div class="commentItem">
                    <span class="name cName">{{= author}}：</span>
                    <span class="commentContent cComment">{{= message}}</span>
                </div>
            </li>            
</script>
</head>
<body style="background-color: #ffffff">
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

    <div class="content" style="background-color: #ffffff">
        <div id="detail-panel">

            </div> 

        <div class="content-text mb20" style="background-color: #ffffff">
                <?=$message?>
        </div> <!-- content-text --> 
    </div> <!-- content --> 
    <br/>

     <div style="width: 96%;margin-left: 2%">
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
     </div>

     <?php if($_GET['type']=="product") { ?>
     <input style="margin-top: 20px;margin-bottom: 20px;width: 96%;margin-left: 2%" type = "button" id="buttonBook"  class = "dial_btn btn" value = "预定" />
     <?php } ?>

    <div class="comment">
        <div class="commentContainer" style="height: 180px">
            <div class="commentPublish" style="margin-top: 10px">


                <div class="comment_2" style="border-radius: 5px">
                    <div class = "comment_2_add">
                        <textarea placeholder = "&nbsp;&nbsp;请输入评论内容" class = "comment_area_1" id="review"></textarea>
                        <textarea placeholder = "&nbsp;&nbsp;请输入呢称" class = "comment_area_2"  value="<?=$COOKIE?>" id="nickname" ></textarea>
                        <input type = "button" style="float: right;padding: 6px;padding-left:15px;padding-right:15px;margin-right: 10px;
                        font-size: 14px;margin-top: 5px;"
                               class = "btn" onclick="cpComment($('#idtype').val(), $('#id').val(), $('#review').val(),$('#nickname').val())" value = "提交评论" />
                    </div>
                </div>


            </div> <!-- comment_publish --> 
        </div><!-- comment_container --> 

        <ul class="commentList" style="background-color: #f0f0f0">
             <div id="comment-panel">

            </div>
        </ul>
         <br/>
            <input type = "button" style="color: #6b6b6b;background-color: #f0f0f0"
             onclick="getComment($('#idtype').val(),$('#id').val(), $('#uid').val(), $('#page').val(), $('#perpage').val());"
             value = "更多" class = "more_button"  />
    </div> <!-- comment --> 
    <input type="hidden" id="wxkey" name="wxkey" value="<?=$_GET['wxkey']?>"/>
        <input type="hidden" id="id" name="id" value="<?=$_GET['id']?>"/>
        <input type="hidden" id="idtype" name="idtype" value="<?=$_GET['idtype']?>"/>
        <input type="hidden" id="type" name="type" value="<?=$_GET['type']?>"/>
        <input type="hidden" id="uid" name="uid" value="<?=$_GET['uid']?>"/>
        <input type="hidden" id="page" name="page" value="1"/>
        <input type="hidden" id="perpage" name="perpage" value="10"/>

</body>
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
  </script>
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
function joinMember(wxid){
         WeixinJSBridge.invoke('addContact',{
                            "webtype" : "1", // 添加联系人的场景，1表示企业联系人。
                            "username" : wxid,　// 需要添加的联系人username
                    },function(res){
                        // 关注成功提交表单
                       
                    })
        }

   if(document.addEventListener){
   document.addEventListener('WeixinJSBridgeReady', onBridgeReady, false);
}else if(document.attachEvent){
   document.attachEvent('WeixinJSBridgeReady'   , onBridgeReady);
   document.attachEvent('onWeixinJSBridgeReady' , onBridgeReady);
}

})();
</script>
</html>

<?php ob_out();?>