<?php if(!defined('IN_UCHOME')) exit('Access Denied');?><?php subtplcheck('./wx/template/8/goodscontent', '1386912703', './wx/template/8/goodscontent');?><!DOCTYPE html>
<html>
<head>
<meta charset = "utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
<link rel = "stylesheet" href = "./template/8/css/base.css" />
<link rel = "stylesheet" href = "./template/8/css/common.css" />
<link rel = "stylesheet" href = "./template/8/css/page.css" />

        <link rel="stylesheet" href="./template/css/base.css" />
        <link rel="stylesheet" href="./template/css/expressInfo.css" />

        <style type="text/css">
            #bg,#bg2{ display: none;  position: fixed;  top: 0%;  left: 0%;  width: 100%;
                height: 100%;  background:url(./template/img/guide_bg.png);
                z-index:1001;/*  -moz-opacity: 0.7;  opacity:.70;  filter: alpha(opacity=70);*/}

            .btn8
            {
                padding-top: 5px;
                padding-bottom: 5px;
            }

            #ajax li
            {
                list-style: none;
                font-size: 16px;
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

            .wrapperPic img ,.goodmessage  img
            {
                max-width: 100% !important;
                height: auto; !important;
            }

            .span2
            {
                color: #7d7b7b;
            }
            .uchome-message-pic img
            {
                width: 100%;
                display: block;
                padding-top: 5px;
            }


            ::-webkit-input-placeholder { font-size: 16px; }

            input:-moz-placeholder { font-size: 16px; }
        </style>

        <script src="template/js/jquery-v2.0.2.js"></script>
        <script type="text/javascript" src="template/js/jquery.tmpl.min.js"></script>
        <script type="text/javascript" src="template/js/detail.js"></script>

        <script id="detailTemplate" type="text/x-jquery-tmpl">
            <li class="itemContentList" style="list-style-type:none;">
                <span class="span1" style="padding-right:40px;">{{= username}}&nbsp;&nbsp;&nbsp;购买数:{{= number}}<div style="clear: both"></div></span><span class="span2" style="float: left;"><p style="color:#7d7b7b">{{= dateline}}</p></span><div style="clear: both"></div><br/>
                <?php if($_GET['zhong']=='1') { ?>
                <span>购买物品:"{{= more.subject}}"</span>,<br/>
                <span>地址:{{= place}}<br/></span>
                <span>联系电话:{{= tel}}</span>
                <br/>
                <form action="wx.php?do=upload" method="post"><input type="submit" class="add_btn" value="确认发货"> </input><input type="hidden" class="add_btn" name="goodscodid" value="{{= id}}"> </input><input type="hidden" class="add_btn" name="uid" value="{{= uid}}"> </input><input type="hidden" class="add_btn" name="gid" value="{{= gid}}"> </input><input type="hidden" class="add_btn" name="viewuid" value="{{= viewuid}}"> </input><input type="hidden" id="wxkey" name="wxkey" value="<?=$_GET['wxkey']?>"/></form>
                <?php } ?>
            </li>
        </script>

        <title><?=$appname?></title>

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
<h3 style="font-weight: bold;font-size: 18px;padding-top: 4px;padding-bottom: 7px;"><?=$wei['subject']?></h3>
<span class = "itemContentSubtitle"><!--2013-5-27--></span>
<span class = "itemContentSubtitle fr">评论（<?=$wei['replynum']?>）</span>
<span class = "itemContentSubtitle fr">阅读（<?=$wei['viewnum']?>）</span>
<div class="wrapperPic mb8 mt8">
                  <!--  <img src = "img/exam2.jpg" class = "w vb" />  -->
                </div>
<div class = "mt10 mb10" style="margin: 0;width: 150px;margin-left: -10px;margin-top: -10px;margin-bottom: 10px">
<span class = "ml10 lt"><!--原价：￥87--></span><span class = "colour ml35" style="margin-left: 0;">
                    现价：￥ <?=$wei['curprice']?>
                    </span>
</div>
                <div class="goodmessage">
                    <?=$message?>
                </div>

                <div id="friend" class="friend_wrapper" style="
                 ;width:99%;height:115px;border:1px dashed #999;margin:0 auto;margin-bottom:30px;margin-top:20px;text-align:center;">
                    <div style="text-align: center;margin: 0 auto;width: 270px;height: 30px;margin-top: 20px">
                        <div style="margin:0 auto;padding:0;height: 30px;width: 120px;float: left">
                            <a id="" class="friend_btn" style="" onclick="showDIv()">
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
                    <div style="margin:0 auto;padding:0;height: 30px;width:100%;text-align: center;margin-top: -50px">
                        <h3 style="font-size:14px;">手机用户请关注微信公众账号：<?=$uidwxkey['weixinname']?></h3></div>
                    <?php } ?>
                    <div style="clear: both"></div>
                </div><!-- / -->

                <div style="margin-bottom:50px;">
                    <?php if($wei['taobaourl']) { ?>
                    <input  style="margin-top: 0px;width: 96%;margin-left: 2%" type = "button" onclick='gototaobao("<?=$wei['taobaourl']?>")' class = "dial_btn btn btn8" value = "购买" />
                    <?php } ?>
                    <?php if($wei['goodscod']&&$wei['taobaourl']) { ?>
                    <input style="margin-top: 20px;width: 96%;margin-left: 2%" type = "button" id="buttonBuy"  class = "dial_btn btn btn8" value = "货到付款" />
                    <a href="wx.php?uid=<?=$_GET['uid']?>&do=feed&wxkey=<?=$_GET['wxkey']?>&idtype=goods">
                        <input style="margin-top: 20px;width: 96%;margin-left: 2%" type = "button"  class = "dial_btn btn btn8" value = "更多商品" /></a>
                    <span style="font-size:16px;float:right;padding-top:12px;padding-bottom:0px" id="buttonBuy1"> 点击输入密码查看订单详情</span>
                    <?php } else { ?>
                    <input style="margin-top: 20px;width: 96%;margin-left: 2%" type = "button" id="buttonBuy"  class = "dial_btn btn btn8" value = "货到付款" />
                    <a href="wx.php?uid=<?=$_GET['uid']?>&do=feed&wxkey=<?=$_GET['wxkey']?>&idtype=goods">
                        <input style="margin-top: 20px;width: 96%;margin-left: 2%" type = "button"  class = "dial_btn btn btn8" value = "更多商品" /></a>
                    <span style="font-size:16px;float:right;padding-top:24px;padding-bottom:0px;" id="buttonBuy1"> 点击输入密码查看订单详情</span>
                    <?php } ?>
                </div>


</div>
<div class= "comment pt8">
<!--<textarea placeholder = "写下你的评论..." class = "comment_area ml8 mt8" ></textarea>
<input type = "button" class = "submitBtn btn mt8" value = "发表" />    -->
<ul class = "mt15">
                    <div id="ajax"></div>
                    <div id="detail-panel"></div>
</ul>
</div>

            <input type = "button" style="background-color:#EFEFEF;color: #666 ;margin: 0 auto;width: 96%;margin-left: 2%;font-size: 15px;padding-top: 5px;padding-bottom: 5px;"
                   onclick="getDetail($('#idtype').val(),$('#id').val(), $('#uid').val(), $('#page').val(), $('#perpage').val());"
                   value = "更&nbsp;&nbsp;多" class = "more_button"  />

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
            $(".messagetext span").css({backgroundColor:"#240934",color:"#cccccc" });

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

            /*     $(".buttonSubmit").click(function(){
             $(".expressInfo").fadeOut();
             });  */
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
                }else{ /*if_tel_else*/
                    if($("#username").val()==""||$("#tel").val()==""||$("#place").val()==""||$("#number").val()==""){
                        alert("邮寄信息中存在空值")
                    }else{
                        $.ajax({
                            type: "POST",
                            url: "wx.php?do=upload",
                            data: "uid="+$('#uid').val()+"&gid="+$('#gid').val()+" &viewuid="+$('#viewuid').val()+" &moblieclicknum="+$('#moblieclicknum').val()+"&wxkey="+$('#wxkey').val()+"&username="+$('#username').val()+"&tel="+$('#tel').val()+"&number="+$('#number').val()+"&place="+$('#place').val()+"&buy=1",//提交表单，相当于CheckCorpID.ashx?ID=XXX
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

    <div class="expressInfo">
        <div class="formContainer bc tc">
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
                <div id="zhong">
                    <input type="button" id="submit" class="buttonSubmit" onclick="javascript:{this.disabled=true;}"  value="提交">
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
            </form>
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


</html>
<?php ob_out();?>