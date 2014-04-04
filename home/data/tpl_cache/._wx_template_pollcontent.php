<?php if(!defined('IN_UCHOME')) exit('Access Denied');?><?php subtplcheck('./wx/template/pollcontent', '1387355287', './wx/template/pollcontent');?>﻿<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no"  />
    <meta content="telephone=no" name="format-detection" />
    <meta charset="UTF-8" />

    <?php if($_GET['moblieclicknum']=='1'||$_GET['moblieclicknum']=='0') { ?>
    <link rel="stylesheet" href="./template/css/myall.css" />
    <?php } else { ?>
    <link rel="stylesheet" href="./template/<?=$_GET['moblieclicknum']?>/css/myall.css" />
    <?php } ?>


    <script type="text/javascript" src="./template/<?=$_GET['moblieclicknum']?>/js/jquery-1.10.2.js"></script>
    <script type="text/javascript" src="./template/<?=$_GET['moblieclicknum']?>/js/myall.js"></script>


    <script src="template/js/jquery-v2.0.2.js"></script>
    <script type="text/javascript" src="template/js/jquery.tmpl.min.js"></script>
    <script type="text/javascript" src="template/js/detail.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>


    <style type="text/css">
        #bg,#bg2{ display: none;  position: fixed;  top: 0%;  left: 0%;  width: 100%;  height: 100%;
            background:url(./template/img/guide_bg.png);  z-index:1001;}
    </style>

    <title><?=$appname?></title>
</head>
<body style="">

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
      投票
  </span>
</div>
<div style="clear: both"></div>

<div class="feedbody">



    <div class="bodycontent">
      <div class="content">

          <!--通用-->
          <p class="ctitle">
              <?=$wei['subject']?>
          </p>
          <!--投票页面专有-->
          <p class="vote_content_date"><?php echo sgmdate('Y-m-d',$wei[dateline]); ?></p>
          <div style="clear: both"></div>
          <!--通用-->
          <p class="cbody">
              <?=$wei3['message']?>
          </p>
          <!--投票页面专有-->
          <p class="vote_content_li_title">投票后显示结果</p>
          <div class="vote_content_li" style="position: relative;z-index: 200">
              <ul >
                  <?php if(is_array($option)) { foreach($option as $key => $val) { ?>
                  <li id="<?=$val['oid']?>">
                      <table>
                          <tr>
                              <td class="vote_li_td1">
                                  <img src="http://v5.home3d.cn/home/<?=$val['imageurl']?>">
                              </td>
                              <td class="vote_li_td2">
                                  <?=$val['option']?>
                              </td>
  <?php if(!$hasvoted) { ?>
                              <td class="vote_li_td3">
                                  <img src="./template/img/tick.png">
                              </td>
  <?php } else { ?>
  <td class="vote_li_td3">
                                  <P><?=$alpha1[$val['i']]?></p>
                              </td>
  <?php } ?>
                          </tr>
                      </table>
                  </li>
                  <?php } } ?>





              </ul>

          </div>
  <?php if((!$hasvoted)) { ?>
                <?php if(($wei['maxchoice']==1)) { ?>
                  <form action="wx.php?do=upload" method="post" >
                  <input type="hidden" value="<?=$_GET['id']?>" name="pollid" id="pollid" />
                  <input type="hidden" value="<?=$_COOKIE['uchome_viewuid']?>" name="uid" id="uid" />
                  <input type="hidden" value="<?=$_COOKIE['voteid']?>" name="voteid" id="voteid" />
                  <input type="hidden" value="1" name="zong0" />
                  <input  class="vote_input1" id="reservationsub" type="submit" value="我要投票" />
                  </form>
                <?php } else { ?>
                  <form action="wx.php?do=upload" method="post" >
                  <input type="hidden" value="<?=$_GET['id']?>" name="pollid" id="pollid" />
                  <input type="hidden" value="<?=$_COOKIE['uchome_viewuid']?>" name="uid" id="uid" />
                  <input type="hidden" value="<?=$_COOKIE['voteid']?>" name="voteid" id="voteid" />
                  <input type="hidden" value="1" name="zong2" />
                  <input  class="vote_input2" id="reservationsub2" type="submit" value="我要投票" />
                  </form>
                <?php } ?>
  <?php } else { ?>
  <input  class="vote_input2" type="button" value="你已经投过票了"></input>
          <p class="vote_end">投票结果</p>
          <div class="vote_end_table">
              <ul>
  <?php if(is_array($option)) { foreach($option as $key => $val) { ?>
                <li>
                    <table>
                        <tr>
                            <td class="vote_end_td1">
                                <p><?=$alpha1[$val['i']]?></p>
                            </td>
                            <td class="vote_end_td2">
                                <div class="vote_end_table_d1">
                                    <div class="vote_end_table_d2" style="width:<?=$val['width']?>px;">

                                    </div>
                                </div>
                            </td>
                            <td class="vote_end_td3">
                                <?=$val['votenum']?>人
                            </td>
                        </tr>
                    </table>
                </li>
  <?php } } ?>
              </ul>
          </div>
  <?php } ?>



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
            </div>
            <div style="clear: both"></div>
            <?php if($uidwxkey['weixinname']) { ?>
            <div style="margin:0 auto;padding:0;height: 30px;width:100%;text-align: center;margin-top: 10px">
                <h3 style="font-size:14px;">手机用户请关注微信公众账号：<?=$uidwxkey['weixinname']?></h3></div>
            <div style="clear: both"></div>
            <?php } ?>
        </div>
        <div style="clear: both"></div>



    </div>

    <div class="content_comment">
        <!--   <p class="content_comment_p">
               <span class="content_comment_p1">评论</span>
               <span class="content_comment_p2">共12条评论</span>
           </p> -->
        <div>
            <div class="comment_2" >
                <div class = "comment_2_add">
                    <textarea style="border: 0;border-bottom: 1px dashed #999;" placeholder = "&nbsp;&nbsp;请输入评论内容" class = "comment_area_1" id="review"></textarea>
                    <textarea style="border: 0" placeholder = "&nbsp;&nbsp;请输入呢称" class = "comment_area_2"  value="<?=$COOKIE?>" id="nickname" ></textarea>
                    <input type = "submit" class = "btn" id="pollsubmit" onclick="" value = "提交评论" />
                    <input type="hidden" id="pollid" name="pollid" value="<?=$_GET['id']?>" />
                    <input type="hidden" id="uid" name="uid" value="<?=$_COOKIE['uchome_viewuid']?>" />
                    <input type="hidden" id="dateline" name="dateline" value="<?=$_SGLOBAL['timestamp']?>" />
                    <input type="hidden" name="comment" value="1" />
                </div>
            </div>


            <ul class="content_ul" id="comment_ul"  >
                <?php if(is_array($list1)) { foreach($list1 as $value3) { ?>
                <li>
                        <span class="ContentCommentName">
                            <?=$value3['author']?>：
                        </span>
                        <span class="ContentCommentWord">

                        </span>
                    <p>
                        <?=$value3['message']?>
                    </p>
                </li>
                <?php } } ?>
            </ul>
            <!--   <div class="ContentCommentButton">
                   <input  type="button" value="查看更多" onclick="">
               </div>   -->
            <div style="text-align: center">
                <input type = "button" style="color: #6b6b6b;background-color: #f0f0f0;font-size: 18px;padding-top: 10px;padding-bottom: 10px"
                   onclick="getDetail($('#idtype').val(),$('#id').val(), $('#uid').val(), $('#page').val(), $('#perpage').val());"
                   value = "查看更多" class = "more_button"  />
            </div>
        </div>


    </div>




</div>


<?php if($wei['maxchoice']==1) { ?>
<script type="text/javascript" charset="utf-8">

    <!--用于提交单选投票ID-->
    $(".vote_content_li ul li").click(function(){
        var b= parseInt($(this).attr("id") );
     $(".vote_content_li ul li .vote_li_td3 img").attr("src","./template/img/tick.png");
     $(this).find('.vote_li_td3').find('img').attr("src","./template/img/tick-h.png");
     
    $.ajax({
        type: "POST",
        url: "wx.php?do=upload",
        data: "voteid="+b+"&yan0=1",//提交表单，相当于CheckCorpID.ashx?ID=XXX
        async: true,
        success: function (data) {
        } //操作成功后的操作！msg是后台传过来的值
    });
    });
    
    
    
</script>
<?php } else { ?>

 <!--投票的ID 多选  -->
<script type="text/javascript" charset="utf-8">

    $(".vote_content_li ul li").click(function(){
     //alert($(this).attr("value"));
       var b= parseInt($(this).attr("id") );

       var picchoose=parseInt($(this).attr("value") );
        if(picchoose%2==0)
        {
            $(this).find('.vote_li_td3').find('img').attr("src","./template/img/tick-h.png");
            $(this).attr("value",function(){
                var a=picchoose;
                a=a+1;
                return a;

            });
        }
        else if(picchoose%2!=0)
        {
            $(this).find('.vote_li_td3').find('img').attr("src","./template/img/tick.png");
            $(this).attr("value",function(){
                var a=picchoose;
                a=a+1;
                return a;
            });
        }
        $.ajax({
            type: "POST",
            url: "wx.php?do=upload",
            data: "voteid="+b+"&polls=1",//提交表单，相当于CheckCorpID.ashx?ID=XXX
            async: true,
            success: function (data) {
            } //操作成功后的操作！msg是后台传过来的值
        });
    });
</script>

<?php } ?>




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

<input type="hidden" id="wxkey" name="wxkey" value="<?=$_GET['wxkey']?>"/>
<input type="hidden" id="id" name="id" value="<?=$_GET['id']?>"/>
<input type="hidden" id="idtype" name="idtype" value="<?=$_GET['idtype']?>"/>
<input type="hidden" id="type" name="type" value="<?=$_GET['type']?>"/>
<input type="hidden" id="uid" name="uid" value="<?=$_GET['uid']?>"/>
<input type="hidden" id="page" name="page" value="1"/>
<input type="hidden" id="perpage" name="perpage" value="10"/>




<script type="text/javascript">
    <?php if(!$hasvoted) { ?>
        var maxSelect = <?=$poll['maxchoice']?>;
        var alreadySelect = 0;
        function checkSelect(sel) {
            if(sel) {
                alreadySelect++;
                if(alreadySelect == maxSelect) {
                    var oObj = document.getElementsByName("option[]");
                    for(i=0; i < oObj.length; i++) {
                        if(!oObj[i].checked) {
                            oObj[i].disabled = true;
                        }
                    }
                }
            } else {
                alreadySelect--;
                if(alreadySelect < maxSelect) {
                    var oObj = document.getElementsByName("option[]");
                    for(i=0; i < oObj.length; i++) {
                        if(oObj[i].disabled) {
                            oObj[i].disabled = false;
                        }
                    }
                }
            }
        }
        <?php } ?>



        //效查
        var optionNum = <?php echo count($option) ?>;
        var maxLength = [0,1, 2, 3, 4, 5, 6, 7, 8, 9, 10,11,12,13,14,15,16,17,18,19];

        var timer;
        var length = 0;
        for(i = 0; i < optionNum; i++) {
            maxLength[i] = $("bar_" + i).getAttribute('len');
        }
        timer = setInterval(function(){
            setLength();
        }, 40);
        function setLength(){
            for (i = 0; i < optionNum; i++) {
                if (length - 1 >= maxLength[i]) {
                    $('bar_' + i).style.width = maxLength[i] + "px";
                } else {
                    $('bar_' + i).style.width = length + "px";
                }
                length = length + 1;
                if (length > 300) {
                    clearInterval(timer);
                }
            }
        }
        function showVoter(filtrate) {
            $('newvoter').className = '';
            $('wevoter').className = '';
            $(filtrate+'voter').className = 'active';
            ajaxget('cp.php?ac=poll&op=get&pollid=<?=$poll['pollid']?>&filtrate='+filtrate, 'showvoter');
        }
        showVoter('new')
</script>
<script type="text/javascript">
    $(function(){
        $(".comment_list .commentContainer").css("display","none");
        $("#detail-panel li span").css({width:"1em",overflow:"hidden",display:"block",textOverflow:"ellipsis",whiteSpace:"nowrap"});
        $(".messagetext span").css({backgroundColor:"#240934",color:"#cccccc" });

    })

</script>
<script type="text/javascript">

    $(document).ready(function(){
        $("#feedcontent").click(function(){
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

        $("#feedcontent").click(function(){
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

    /*******************************评论上传******************************************************/
    $(document).ready(function () {
            $("#pollsubmit").click(function () {
                var polltype=$('#polltype').val();
                if($('#review').val()==""||$('#nickname').val()=="")
                {
                    alert("存在空值，请填好信息再提交！");
                }
                else {
                    $.ajax({
                    type: "POST",
                    url: "wx.php?do=upload",
                    data: "uid="+$('#uid').val()+"&id="+$('#id').val()+" &viewuid="+$('#viewuid').val()+" &moblieclicknum="+$('#moblieclicknum').val()+"&polltype="+$('#polltype').val()+"&dateline="+$('#dateline').val()+"&nickname="+$('#nickname').val()+"&pollid="+$('#id').val()+"&review="+$('#review').val()+"&zong=1",//提交表单，相当于CheckCorpID.ashx?ID=XXX
                    async: true,
                    success: function (data) {
                        $('#pollsubmit').val("发表成功");
                        $("#comment_ul").prepend(data);
                    } //操作成功后的操作！msg是后台传过来的值
                });
                }
            });
        });
</script>


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