<?php if(!defined('IN_UCHOME')) exit('Access Denied');?><?php subtplcheck('./wx/template/detailcontent', '1387271032', './wx/template/detailcontent');?><!DOCTYPE html>
<html>
    <head>
    <title><?=$zhong['subject']?></title>
<meta charset = "utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no"  />
<!--<link rel = "stylesheet" type = "text/css" href = "./template/css/main.css">      -->

        <?php if($_GET['moblieclicknum']=='1'||$_GET['moblieclicknum']=='0') { ?>
        <link rel = "stylesheet" type = "text/css" href = "./template/css/main.css">
        <link rel="stylesheet" href="./template/css/myall.css" />
        <?php } else { ?>
        <link rel = "stylesheet" type = "text/css" href = "./template/<?=$_GET['moblieclicknum']?>/css/main.css">
        <link rel="stylesheet" href="./template/<?=$_GET['moblieclicknum']?>/css/myall.css" />
        <?php } ?>

<link rel="stylesheet" href="./template/css/base.css" />
<link rel="stylesheet" href="./template/css/expressInfo.css" />
<style type="text/css">
        #bg,#bg2{ display: none;  position: fixed;  top: 0%;  left: 0%;  width: 100%;  height: 100%;  background:url(./template/img/guide_bg.png);  z-index:1001;/*  -moz-opacity: 0.7;  opacity:.70;  filter: alpha(opacity=70);*/}
        </style>
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
<h3><?=$zhong['subject']?></h3>
<span class = "info_content_span subtitle"><?php echo sgmdate('m-d H:i',$zhong[dateline],1); ?></span>
<!-- <span class = "job_content_span subtitle">评论（37）</span> -->
<span class = "job_content_span subtitle">阅读（<?=$zhong['viewnum']?>）</span>
<div class = "article_content">
职位描述:  <?=$zhong['message1']?><br/>
    		 	资格要求:  <?=$zhong['messagecomment']?><br/>
     			电话:  <?=$zhong['telephone']?><br/>
     			邮箱:  <?=$zhong['email']?><br/>
     			待遇:  <?=$zhong['money']?><br/>
     			其它:  <?=$zhong['othermessage']?><br/>
<!-- 职位性质： 全职<br /> 
专业要求： 不限 <br />
招聘日期： 2013.5.24 ～ 2014.6.2<br />
工作地点： 广东-东莞市<br />
外语要求： 无<br /> 
更新日期： 2013.5.29<br />
工作经验： 五年以上<br /> 
职称要求： 中级<br />
学历要求： 不限<br />
工资待遇： 10000～14999 元/月<br /> 
招聘人数： 4人<br />
任职资格：<br />
1、1-2年以上男装设计工作经验<br />
2、熟练应用计算机软件Photoshop、CorelDraw 等绘图知识<br />
3、具有较强的审美能力和扎实的手绘服装设计基础<br />
4、具有一定的人际能力、沟通能力和计划与执行能力<br />
联系人： 汪小姐<br />
地　址： 东莞市虎门镇大宁社区麒麟东路15号<br />
邮　编： 823523<br />
电　话： 0769-8015<br />
网　址： http://www.meilife.com -->
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

            <a href="http://site.tg.qq.com/forwardToPhonePage?siteId=1&phone=<?=$zhong['telephone']?>">
              <input  style="margin-top: 40px" type = "button"
                 class = "dial_btn btn" value="一键拨号" />
            </a>

</div>
<!-- 		<div class = "comment">
<div class = "comment_add">
<textarea placeholder = "写下你的评论..." class = "comment_area" ></textarea>
<input type = "button" class = "submit_btn btn" value = "发表" />
</div>
<ul class = "comment_list">
<li>
<span>CT626: </span>
美丽人的衣服很好看啊~而且这个品牌很有内涵的说~
</li>
<li>
<span>游虾: </span>
喜欢美丽人生~
</li>
<li>
<span>天降之屎: </span>
美丽人生很垃圾很垃圾~
</li>
</ul>
</div> -->
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
</html><?php ob_out();?>