<?php if(!defined('IN_UCHOME')) exit('Access Denied');?><?php subtplcheck('./wx/template/8/detailcontent', '1386775796', './wx/template/8/detailcontent');?><!DOCTYPE html>
<html>
<head>
<meta charset = "utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
<link rel = "stylesheet" href = "./template/8/css/base.css" />
<link rel = "stylesheet" href = "./template/8/css/common.css" />
<link rel = "stylesheet" href = "./template/8/css/page.css" />

        <link rel="stylesheet" href="./template/css/base.css" />
        <link rel="stylesheet" href="./template/css/expressInfo.css" />

        <script src="http://code.jquery.com/jquery-1.8.2.min.js"></script>
        <script src="http://code.jquery.com/jquery-1.8.2.min.js"></script>
        <script type="text/javascript" src="template/js/jquery.tmpl.min.js"></script>
        <script type="text/javascript" src="./template/js/detail.js"></script>

        <style type="text/css">
            #bg,#bg2{ display: none;  position: fixed;  top: 0%;  left: 0%;  width: 100%;  height: 100%;
                background:url(./template/img/guide_bg.png);  z-index:1001;/*  -moz-opacity: 0.7;  opacity:.70;  filter: alpha(opacity=70);*/}



            ::-webkit-input-placeholder { font-size: 16px; }
            input:-moz-placeholder { font-size: 16px; }

        </style>

        <script id="commentTemplate" type="text/x-jquery-tmpl">
            <li class="itemContentList" style="list-style-type:none;">
                <div class="commentItem">
                    <span class="name cName">{{= author}}：</span>
                    <span class="commentContent cComment">{{= message}}</span>
                </div>
            </li>
        </script>

        <title><?=$zhong['subject']?></title>




</head>
<body>

    <div id="bg" onclick="hideDiv();">
        <img src="./template/img/guide.png" alt="" style="position:fixed;top:0;right:16px;">
    </div>
    <div id="bg2" onclick="hideFriendDIv();">
        <img src="./template/img/guide_firend.png" alt="" style="position:fixed;top:0;right:16px;">
    </div>

<div class="itemContentFrame">
<div class = "article p8">
<h3 style="font-weight: bold;font-size: 18px;padding-top: 4px;padding-bottom: 7px;"><?=$zhong['subject']?></h3>
<span class = "itemContentSubtitle"><!--2013-5-27--></span>
<span class = "itemContentSubtitle fr"><!--评论（37）--></span>
<span class = "itemContentSubtitle fr"><!--阅读（132）--></span>
<div class = "mt15 mb15"><!--职位性质： 全职-->
                    职位描述: <br/> <?=$zhong['message']?><br/>
                    资格要求:  <?=$zhong['messagecomment']?><br/>
                    电话:  <?=$zhong['telephone']?><br/>
                    邮箱:  <?=$zhong['email']?><br/>
                    待遇:  <?=$zhong['money']?><br/>
                    其它:  <?=$zhong['othermessage']?><br/>
</div>

                <div id="friend" class="friend_wrapper" style="width:99%;height:115px;border:1px dashed #999;
                margin:0 auto;margin-top:20px;text-align:center;">
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

<input  style="margin-top: 20px" type = "button" class = "articleBtn btn mb8" value = "拨打电话" />
</div>
<div class= "comment pt8">

                <div class="comment_2" style="border-radius: 5px;margin-top: 10px">
                    <div class = "comment_2_add">
                        <textarea style="border: 0;border-bottom: 1px dashed #999;" placeholder = "&nbsp;&nbsp;请输入评论内容" class = "comment_area_1" id="review"></textarea>
                        <textarea style="border: 0;" placeholder = "&nbsp;&nbsp;请输入呢称" class = "comment_area_2"  value="<?=$COOKIE?>" id="nickname" ></textarea>
                        <input type = "button" style="float: right;padding: 6px;padding-left:15px;padding-right:15px;margin-right: 10px;
                        font-size: 14px;margin-top: 5px;"
                               class = "btn" onclick="cpComment($('#idtype').val(), $('#id').val(), $('#review').val(),$('#nickname').val())" value = "提交评论" />
                    </div>
                </div>


<ul class = "mt15">
                    <div id="comment-panel"></div>
</ul>
</div>



</div>

    <input type = "button" style="background-color:#EFEFEF;color: #666 ;margin: 0 auto;width: 96%;margin-left: 2%;font-size: 15px;padding-top: 5px;padding-bottom: 5px;"
           onclick="getComment($('#idtype').val(),$('#id').val(), $('#uid').val(), $('#page').val(), $('#perpage').val());"
           value = "更&nbsp;&nbsp;多" class = "more_button"  />

    <input type="hidden" id="wxkey" name="wxkey" value="<?=$_GET['wxkey']?>"/>
    <input type="hidden" id="id" name="id" value="<?=$_GET['id']?>"/>
    <input type="hidden" id="idtype" name="idtype" value="<?=$_GET['idtype']?>"/>
    <input type="hidden" id="type" name="type" value="<?=$_GET['type']?>"/>
    <input type="hidden" id="uid" name="uid" value="<?=$_GET['uid']?>"/>
    <input type="hidden" id="page" name="page" value="1"/>
    <input type="hidden" id="perpage" name="perpage" value="10"/>
    </body>

    <script type="text/javascript">

        $(function(){

            $(".mt15 span").css({backgroundColor:"#240934",color:"#cccccc" });
            $("li").addClass("itemContentList");
            $("li").css("list-style-type","none")  ;

        })

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