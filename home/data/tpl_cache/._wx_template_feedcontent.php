<?php if(!defined('IN_UCHOME')) exit('Access Denied');?><?php subtplcheck('./wx/template/feedcontent', '1387358073', './wx/template/feedcontent');?><!DOCTYPE html>
<html>
    <head>
    <title><?=$wei['subject']?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no"  />
        <?php if($_GET['moblieclicknum']=='1'||$_GET['moblieclicknum']=='0') { ?>
        <link rel = "stylesheet" type = "text/css" href = "./template/css/main.css">
        <link rel="stylesheet" href="./template/css/myall.css" />
        <?php } else { ?>
        <link rel = "stylesheet" type = "text/css" href = "./template/<?=$_GET['moblieclicknum']?>/css/main.css">
        <link rel="stylesheet" href="./template/<?=$_GET['moblieclicknum']?>/css/myall.css" />
        <?php } ?>
        <style type="text/css">
        #bg,#bg2{ display: none;  position: fixed;  top: 0%;  left: 0%;  width: 100%;  height: 100%;  background:url(./template/img/guide_bg.png);  z-index:1001;/*  -moz-opacity: 0.7;  opacity:.70;  filter: alpha(opacity=70);*/}
        </style>
<script src="http://code.jquery.com/jquery-1.8.2.min.js"></script>
<script src="http://code.jquery.com/jquery-1.8.2.min.js"></script>
     	<script type="text/javascript" src="template/js/jquery.tmpl.min.js"></script>
     	<script type="text/javascript" src="template/js/detail.js"></script>
     	<script id="detailTemplate" type="text/x-jquery-tmpl">
     	<h3>
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
                 </h3>
<span class = "info_content_span subtitle">
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
     	</script>
     	  <script id="commentTemplate" type="text/x-jquery-tmpl">
     	  <li>
<span>{{= author}}: </span>
{{= message}}
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


<div class = "article">
<div id="detail-panel">

       		</div>
<div class = "article_content">
<?=$message?>
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


</div>
<div class = "comment">
<!--<div class = "comment_add" style="height: 162px;">
                <input type="text" name="nickname" placeholder = "你的昵称" value="<?=$COOKIE?>" id="nickname" style="width:200px;height:30px;border: 1px solid #DDDDDD;">
<textarea placeholder = "写下你的评论..." class = "comment_area" id="review" style="margin-top:-40px;"></textarea>
<input type = "button" id="feedsubmit1" style="margin-top:-40px;" class = "submit_btn btn" value = "发表" onclick="cpComment($('#idtype').val(), $('#id').val(), $('#review').val(),$('#nickname').val())"/>
</div>   -->
            <br>
            <div class="comment_2" style="border-radius: 5px">
                <div class = "comment_2_add">
                    <textarea placeholder = "&nbsp;&nbsp;请输入评论内容" class = "comment_area_1" id="review"></textarea>
                    <textarea placeholder = "&nbsp;&nbsp;请输入呢称" class = "comment_area_2"  value="<?=$COOKIE?>" id="nickname" ></textarea>
                    <input type = "button" style="float: right;padding: 6px;padding-left:15px;padding-right:15px;margin-right: 10px;
                        font-size: 14px;margin-top: 5px;"
                           class = "btn" onclick="cpComment($('#idtype').val(), $('#id').val(), $('#review').val(),$('#nickname').val())" value = "提交评论" />
                </div>
            </div>
            <br>

<ul class = "comment_list">
   <div id="comment-panel">

       		</div>
</ul>
            <br/>
            <input type = "button" onclick="getComment($('#idtype').val(),$('#id').val(), $('#uid').val(), $('#page').val(), $('#perpage').val());" value = "更多" class = "more_button"  />

</div>
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

</html><?php ob_out();?>