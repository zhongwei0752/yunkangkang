<?php if(!defined('IN_UCHOME')) exit('Access Denied');?><?php subtplcheck('./wx/template/9/detailcontent', '1387354618', './wx/template/9/detailcontent');?><!DOCTYPE html>
<html lang="zh">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no"  />
    <link rel = "stylesheet" type = "text/css" href = "./template/9/css/main.css">
    <link rel="stylesheet" href="./template/css/base.css" />
    <link rel="stylesheet" href="./template/css/expressInfo.css" />

<link rel="stylesheet" href="./template/9/css/base.css" />
<link rel="stylesheet" href="./template/9/css/common.css" />
<link rel="stylesheet" href="./template/9/css/pageTitle.css" />
<link rel="stylesheet" href="./template/9/css/pageComment.css" />
<link rel="stylesheet" href="./template/9/css/button.css" />
<link rel="stylesheet" href="./template/9/css/jobTable.css" />

    <script src="http://code.jquery.com/jquery-1.8.2.min.js"></script>
    <script src="http://code.jquery.com/jquery-1.8.2.min.js"></script>
    <script type="text/javascript" src="template/js/jquery.tmpl.min.js"></script>
    <script type="text/javascript" src="template/js/detail.js"></script>



<title><?=$zhong['subject']?></title>

    <style type="text/css">
        #bg,#bg2{ display: none;  position: fixed;  top: 0%;  left: 0%;  width: 100%;  height: 100%;
        background:url(./template/img/guide_bg.png);  z-index:1001;/*  -moz-opacity: 0.7;  opacity:.70;  filter: alpha(opacity=70);*/}

        ::-webkit-input-placeholder { font-size: 16px; }
        input:-moz-placeholder { font-size: 16px; }

    </style>

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
        <img src="./template/img/guide.png" alt="" style="position:fixed;top:0;right:16px;width:134px;height:97px;">
    </div>
    <div id="bg2" onclick="hideFriendDIv();">
        <img src="./template/img/guide_firend.png" alt="" style="position:fixed;top:0;right:16px;width:134px;height:97px;">
    </div>

    <div class="content paddingContent">
<div class="head pt20">
<h1 class="cTitle f20"><?=$zhong['subject']?></h1>
<div class="cTime pt15">
<span class="time"></span>  <!--原来日期的位置-->
<span id="countComment" class="fr"></span><!--原来评论数的位置-->
<span id="countRead" class="fr pr5">浏览(<?=$zhong['viewnum']?>)</span>
</div>
</div> <!-- head --> 

<table class="jobTable cParagraph mt10">

            职位描述: <br/> <?=$zhong['message']?><br/>
            资格要求:  <?=$zhong['messagecomment']?><br/>
            电话:  <?=$zhong['telephone']?><br/>
            邮箱:  <?=$zhong['email']?><br/>
            待遇:  <?=$zhong['money']?><br/>
            其它:  <?=$zhong['othermessage']?><br/>


</table>

        <div id="friend" class="friend_wrapper" style="width:100%;height:115px;border:1px dashed #999;margin:0 auto;margin-top:20px;text-align:center;">
            <div style="text-align: center;margin: 0 auto;width: 270px;height: 30px;margin-top: 20px">
                <div style="margin:0 auto;padding:0;height: 30px;width: 120px;float: left"><a id="" class="friend_btn" style="" onclick="showDIv()">
                    <img src="./template/img/repost_icon.png" alt="">
                    <span>发送给朋友</span>
                </a>  </div>
                <div style="margin:0 auto;padding:0;height: 30px;width: 120px;float: left;margin-left:20px">
                    <a id="" class="friend_btn" style="" onclick="showFriendDIv()">
                    <img src="./template/img/friend_circle.png" alt="">
                    <span>分享到朋友圈</span>
                </a></div>
            </div>
            <br/><br/><br/>
            <?php if($uidwxkey['weixinname']) { ?>
            <div style="margin:0 auto;padding:0;height: 30px;width:100%;text-align: center;margin-top: -50px"> <h3 style="font-size:14px;">手机用户请关注微信公众账号：<?=$uidwxkey['weixinname']?></h3></div>
            <?php } ?>
            <div style="clear: both"></div>
        </div><!-- / -->

<div class="button myMargin">
<!--<a href="" class="f20 cWhite">立即拨打电话</a> -->
            <a href="tel:+<?=$zhong['telephone']?>" class="f20 cWhite" id="colorButton" onmouseover="deeper()"
               onmouseout="shallower()" tel="<?=$zhong['telephone']?>">立即拨打电话</a>
</div>

</div> <!-- content --> 

<div class="comment">
        <div class="commentContainer" style="height: 180px">
            <div class="commentPublish" style="">


                <div class="comment_2" style="border-radius: 5px;margin-top: 10px">
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
            <div id="comment-panel"></div>
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