<?php if(!defined('IN_UCHOME')) exit('Access Denied');?><?php subtplcheck('./wx/template/debatecontent', '1387355005', './wx/template/debatecontent');?>﻿<!DOCTYPE html>
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


    <script src="template/js/jquery-v2.0.2.js"></script>
    <script type="text/javascript" src="template/js/jquery.tmpl.min.js"></script>
    <script type="text/javascript" src="template/js/detail.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
    <script type="text/javascript">
        $(function(){
            $('.debateshow_sidespic img').css("height", $('.debateshow_sidespic img').css("width"));
            window.onresize = function(){
                $('.debateshow_sidespic img').css("height", $('.debateshow_sidespic img').css("width"));
            }
            var a1=parseInt($('.support_price').html());
            var a2=parseInt($('.oppose_price').html());
            $('.support img').click(function(){
             //  alert("ok")
                a1=a1+1;
                $('.support_price').html(a1);
                $('.support0').html("<img src='./template/img/support2active.png'>");
                $('.oppose0').html("<img src='./template/img/oppose2.png'>");
                $.ajax({
                    type: "POST",
                    url: "wx.php?do=upload",
                    data: "id="+'<?=$_GET['id']?>'+"&support=1",//提交表单，相当于CheckCorpID.ashx?ID=XXX
                    async: true,
                    success: function (data) {
                    } //操作成功后的操作！msg是后台传过来的值
                });
            })
            $('.oppose img').click(function(){
             //   alert("ko")
                a2=a2+1;
                $('.oppose_price').html(a2);
                $('.support0').html("<img src='./template/img/support2.png'>");
                $('.oppose0').html("<img src='./template/img/oppose2active.png'>");

            })
            $('.sup_comment_s1').click(function(){
                 //alert("ok1")
                $('.comment_area_1').attr("placeholder","  支持正方评论") ;

                $('.comment_area_1').addClass('supportchoose');
                $('.comment_area_1').removeClass('opposechoose');
                $('.sup_comment_s1').css({"backgroundColor":"#DD2355"}) ;
                $('.sup_comment_s2').css({"backgroundColor":"#B3B3B3"});
                $.ajax({
                    type: "POST",
                    url: "wx.php?do=upload",
                    data: "debatetype=0&yan2=1",//提交表单，相当于CheckCorpID.ashx?ID=XXX
                    async: true,
                    success: function (data) {
                      $("#debatetype").val(0);
                    } //操作成功后的操作！msg是后台传过来的值
                });
            })
            $('.sup_comment_s2').click(function(){
               // alert("ok2")
                $('.comment_area_1').attr("placeholder","  支持反方评论") ;

                $('.comment_area_1').addClass('opposechoose');
                $('.comment_area_1').removeClass('supportchoose');
                $('.sup_comment_s1').css({"backgroundColor":"#B3B3B3"}) ;
                $('.sup_comment_s2').css({"backgroundColor":"#4CB9B3"});
                $.ajax({
                    type: "POST",
                    url: "wx.php?do=upload",
                    data: "debatetype=1&yan2=1",//提交表单，相当于CheckCorpID.ashx?ID=XXX
                    async: true,
                    success: function (data) {
                      $("#debatetype").val(1);
                    } //操作成功后的操作！msg是后台传过来的值
                });
            })
        })
    </script>

    <style type="text/css">
        #bg,#bg2{ display: none;  position: fixed;  top: 0%;  left: 0%;  width: 100%;  height: 100%;
            background:url(./template/img/guide_bg.png);  z-index:1001;}
        .cbody img
        {
            width: 100%;
        }
        .supportchoose::-webkit-input-placeholder {
            color: #DD2355;
        }
        .opposechoose::-webkit-input-placeholder {
            color: #4CB9B3;
        }

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
      大擂台
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
          <!--大擂台专有-->
          <div class="debatetime">
            <div>
             <span class="debatetime_s1">活动开始时间：<?php echo sgmdate('Y-m-d',$wei[dateline]); ?></span>&nbsp;&nbsp;
             <?php if($wei['endtime'] >= $_SGLOBAL['timestamp'] ) { ?>
             <span class="debatetime_s2">进行中</span>
             <?php } else { ?>
             <span class="debatetime_s2">已结束</span>
             <?php } ?>
            </div>
            <?php if($wei['judge']) { ?>
              <div>
               <span class="debatetime_s1">裁判：</span><span class="debatetime_s2"><?=$wei['umpire']?>，</span>
               <span class="debatetime_s1">宣布：</span>
                  <span class="debatetime_s2">     
                    <?php if($wei['judge']==1) { ?>
                      正方胜
                    <?php } elseif($wei['judge']==3) { ?>
                      反方胜
                    <?php } else { ?>
                      平局
                    <?php } ?>
                  </span>
               <span class="debatetime_s1">最佳辩手：</span><span class="debatetime_s2"><?=$wei['debater']?></span>
              </div>
            <?php } else { ?>
              <?php if($wei['uid']==$_COOKIE['uchome_viewuid']) { ?>
              <div class="btn" id="feedcontent" style="width: 90px;text-align: center;font-size: 16px">宣布结果</div>
              <?php } else { ?>
              <div></div>
              <?php } ?>
            <?php } ?>
          </div><!--debatetime-->
          <!--通用-->
          <div class="cbody">
              <p style="color:  #3AA09B;font-size: 16px">活动详情</p>
              <?=$wei['message1']?>
          </div><!--cbody-->
          <!--大擂台专有-->
          <div class="debateshow">
              <div class="debateshow_vspic">
                  <img src="./template/img/vs.png">
              </div>
               <div class="debateshow_sidespic">
                <?php if(empty($wei['obimageurl'])&&empty($wei['reimageurl'])) { ?>
                  <img src="./template/img/sidepic1.png">
                  <img src="./template/img/sidepic2.png">
                <?php } else { ?>
                  <img src="http://v5.home3d.cn/home/<?=$wei['obimageurl']?>">
                  <img src="http://v5.home3d.cn/home/<?=$wei['reimageurl']?>">
                <?php } ?>
               </div>
          </div>  <!--debateshow-->
          <div style="clear: both"></div>
          <?php if(!in_array($_COOKIE['uchome_viewuid'],$revoteuids)&&!in_array($_COOKIE['uchome_viewuid'],$obvoteuids)) { ?>
          <div class="debatebotton">
              <span class="debatebotton_s1">
                <div class="support0">
                  <div class="support">
                      <img src="./template/img/support2.png">
                  </div>
                </div>
                  <span class="debatetime_s1">正方观点：</span><span class="debatetime_s2"><?=$wei['obtitle']?></span>
                  <br/>
                  <span class="debatetime_s1" style="margin-left: -50px">票数：</span><span class="debatetime_s2 support_price"><?=$wei['obvote']?></span>

              </span>
              <span class="debatebotton_s2">
                <div class="oppose0">
                   <div class="oppose">
                        <img src="./template/img/oppose2.png">
                   </div>
                </div>
                  <span class="debatetime_s1">反方观点：</span><span class="debatetime_s2"><?=$wei['retitle']?></span>
                  <br/>
                  <span class="debatetime_s1" style="margin-left: -50px">票数：</span><span class="debatetime_s2 oppose_price"><?=$wei['revote']?></span>

              </span>
          </div> 
          <?php } else { ?>
          <div class="debatebotton">
              <span class="debatebotton_s1">
                <div class="support0">
                      <img src="./template/img/support2.png">
                </div>
                  <span class="debatetime_s1">正方观点：</span><span class="debatetime_s2" style="color:#DD2355;"><?=$wei['obtitle']?></span>
                  <br/>
                  <span class="debatetime_s1" style="margin-left: -50px">票数：</span><span class="debatetime_s2 support_price" style="color:#DD2355;"><?=$wei['obvote']?></span>

              </span>
              <span class="debatebotton_s2">
                <div class="oppose0">
                        <img src="./template/img/oppose2.png">
                </div>
                  <span class="debatetime_s1">反方观点：</span><span class="debatetime_s2" style="color:#4CB9B3;"><?=$wei['retitle']?></span>
                  <br/>
                  <span class="debatetime_s1" style="margin-left: -50px">票数：</span><span class="debatetime_s2 oppose_price" style="color:#4CB9B3;"><?=$wei['revote']?></span>

              </span>
          </div>
          <?php } ?>
          <!--debatebotton-->
          <div style="clear: both"></div>
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

    <div class="content_comment">
        <div>
            <!--大擂台专有-->
            <div class="sup_comment">
               <span class="sup_comment_s1">
                   <span><img src="./template/img/support.png" style="position: relative;top: 2px"></span>
                   <span style="position: relative;top: -2px">支持正方</span>
               </span>
                <span class="sup_comment_s2">
                   <span><img src="./template/img/oppose.png" style="position: relative;top: 4px"></span>
                   <span style="position: relative;top: -2px">支持反方</span>
               </span>
            </div>
            <div style="clear: both"></div>
            <!--通用-->
            <div class="comment_2" >
                <div class = "comment_2_add">
                    <textarea style="border: 0;border-bottom: 1px dashed #999;" placeholder = "&nbsp;&nbsp;请输入评论内容" class = "comment_area_1" id="review"></textarea>
                    <textarea style="border: 0" placeholder = "&nbsp;&nbsp;请输入呢称" class = "comment_area_2"  value="<?=$COOKIE?>" id="nickname" ></textarea>
                    <input type = "button" class = "btn" id="debatesubmit" value = "提交评论" />
                    <input type="hidden" id="debateid" name="debateid" value="<?=$_GET['id']?>" />
                    <input type="hidden" id="uid" name="uid" value="<?=$_COOKIE['uchome_viewuid']?>" />
                    <input type="hidden" id="debatetype" name="debatetype" value="3" />
                    <input type="hidden" id="dateline" name="dateline" value="<?=$_SGLOBAL['timestamp']?>" />
                    <input type="hidden" name="debatecomment" value="1" />
                </div>
            </div><!--comment_2-->
            <br/>
            <p style="margin-left: 10px;color: #DD2355;font-size: 16px;font-weight: 600">正方辩论</p>
            <ul class="content_ul" id="comment_ul" style="margin-top: 0px" >
            <?php if(is_array($list1)) { foreach($list1 as $value3) { ?>
                <li>
                    <div>
                        <span class="ContentCommentName" style="color:#DD2355;">
                            <?=$value3['author']?>：
                        </span>
                        <span class="ContentCommentWord">
                            <?php echo sgmdate('Y-m-d',$value3[dateline]); ?>
                        </span>
                    <div style="clear: both"></div>
                    </div>
                    <div>
                    <p>
                        <?=$value3['message']?>
                    </p>
                    </div>
                </li>
            <?php } } ?>
            </ul>
            <br/>
            <p style="margin-left: 10px;color:#4CB9B3;font-size: 16px;font-weight: 600">反方辩论</p>
            <ul class="content_ul" id="comment_ul0" style="margin-top: 0px" >
              <?php if(is_array($list2)) { foreach($list2 as $value4) { ?>
                <li>
                    <div>
                        <span class="ContentCommentName" style="color:#4CB9B3;">
                            <?=$value4['author']?>：
                        </span>
                        <span class="ContentCommentWord">
                            <?php echo sgmdate('Y-m-d',$value4[dateline]); ?>
                        </span>
                        <div style="clear: both"></div>
                    </div>
                    <div>
                    <p>
                        <?=$value4['message']?>
                    </p>
                    </div>
                </li>
              <?php } } ?>
            </ul>
            <div style="text-align: center">
                <input type = "button" style="color: #6b6b6b;background-color: #f0f0f0;font-size: 18px;padding-top: 10px;padding-bottom: 10px"
                       onclick="getComment($('#idtype').val(),$('#id').val(), $('#uid').val(), $('#page').val(), $('#perpage').val());"
                       value = "查看更多" class = "more_button"  />
            </div><!--查看更多-->
        </div>
    </div> <!--content_comment-->

<div class="expressInfo1">
    <div class="formContainer1 bc tc">
        <form method="post" action="wx.php?do=upload">
            <h1 id="formTitle">选择最佳辩手</h1>
            <h3><font color="red">(只能选择正方或反方的一人)</font></h3>
              <div style="text-align: center">
              <select onChange="if(this.value)$('obauthor').value=this.value;" id="judge" name="judge" style="height: 30px;width: 90%">
                  <option value="1" >正方胜(支持数：<?=$wei['obvote']?>&nbsp;辩手：<?=$wei['obreplynum']?>)</option>
                  <option value="2" selected>平局</option>
                  <option value="3" >反方胜(支持数：<?=$wei['revote']?>&nbsp;辩手：<?=$wei['rereplynum']?>)</option>
              </select>
              </div>
              <div style="text-align: center;margin-top: 15px">
                  <select name="obauthor" onChange="if(this.value)$('obauthor').value=this.value;" id="obauthor" style="height: 30px;width: 90%">
                      <option value="">选择正方辩手</option>
                      <?php if(is_array($dlist)) { foreach($dlist as $value3) { ?>
                        <option value="<?=$value3['author']?>"><?=$value3['author']?></option>
                      <?php } } ?>
                  </select>
              </div>
              <div style="text-align: center;margin-top: 15px">
                  <select name="reauthor" onChange="if(this.value)$('reauthor').value=this.value;" id="reauthor" style="height: 30px;width: 90%">
                      <option value="">选择反方辩手</option>
                      <?php if(is_array($dlist1)) { foreach($dlist1 as $value3) { ?>
                        <option value="<?=$value3['author']?>"><?=$value3['author']?></option>
                      <?php } } ?>
                  </select>
              </div>
            <div style="clear: both"></div>
            <!-- <input type="text" placeholder="密码" name="password"  class="inputContainer" />    -->
            <br />

            <input type="hidden" name="refer" value="<?=$_SGLOBAL['refer']?>" />
            <input type="hidden" name="judgedebatesubmit" value="true" />
            <input type="hidden" name="debateid" value="<?=$_GET['id']?>" />
            <input type = "submit" id="feedsubmit3" class = "submit_btn btn" value = "发表" />
    </div> <!-- formContainer -->
    </form>
</div> <!-- expressInfo -->



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


    /*******************************大擂台评论上传******************************************************/
    $(document).ready(function () {
            $("#debatesubmit").click(function () {
                if($('#review').val()==""||$('#nickname').val()=="")
                {
                    alert("存在空值，请填好信息再提交！");
                }
                else {
                    $.ajax({
                    type: "POST",
                    url: "wx.php?do=upload",
                    data: "uid="+'<?=$_COOKIE['uchome_viewuid']?>'+"&id="+$('#debateid').val()+"&dateline="+$('#dateline').val()+"&nickname="+$('#nickname').val()+"&review="+$('#review').val()+"&debatetype="+$('#debatetype').val()+"&yan=1",//提交表单，相当于CheckCorpID.ashx?ID=XXX
                    async: true,
                    success: function (data) {
                        if($('#debatetype').val()==0)
                        {
                          $("#comment_ul").prepend(data);
                          $('#debatesubmit').val("发表成功");
                        }
                        else if($('#debatetype').val()==1)
                        {
                          $("#comment_ul0").prepend(data);
                          $('#debatesubmit').val("发表成功");
                        }
                        else
                        {
                          alert("请先选择你支持的观点！");
                        }
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