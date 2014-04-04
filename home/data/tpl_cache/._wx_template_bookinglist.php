<?php if(!defined('IN_UCHOME')) exit('Access Denied');?><?php subtplcheck('./wx/template/bookinglist', '1396511759', './wx/template/bookinglist');?>﻿<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no"  />
    <meta content="telephone=no" name="format-detection" />
    <meta charset="UTF-8" />

   <!-- <link rel="stylesheet" href="./template/change/css/myall2.css" />  -->
    <?php if($bac['moblieclicknum']=='1'||$bac['moblieclicknum']=='0') { ?>
    <link rel="stylesheet" href="./template/change/css/goodsshoping.css" />
    <?php } else { ?>
    <link rel="stylesheet" href="./template/<?=$bac['moblieclicknum']?>/change/css/goodsshoping.css" />
    <?php } ?>

    <script type="text/javascript" src="./template/change/js/jquery-1.10.2.js"></script>
    <script type="text/javascript" src="./template/change/js/myall.js"></script>

    <style type="text/css">
        #bg,#bg2{ display: none;  position: fixed;  top: 0%;  left: 0%;  width: 100%;  height: 100%;
            background:url(img/guide_bg.png);  z-index:1001;}

    </style>
    <script type="text/javascript">
        $(function(){
           $(".bookinglist li").click(function(){
               var a=parseInt($(this).val())
               if(a%2==0)
               {
                 //  $(".bookingdiatel").appendTo(this);
                  $(this).find(".bookingdiatel").css({"display":"block"});
                   a=a+1;
                   $(this).attr("value",function(){
                       return a;
                   })
               }
               else
               {
                   $(this).find(".bookingdiatel").css({"display":"none"});
                   a=a+1;
                   $(this).attr("value",function(){
                       return a;
                   })
               }

           })
        })
    </script>


    <title><?=$appname?></title>
</head>
<body style="background-color: #F0F0F0;">

<div id="bg" onclick="hideDiv();">
    <img src="./template/change/img/guide.png" alt="" style="position:fixed;top:0;right:16px;">
</div>
<div id="bg2" onclick="hideFriendDIv();">
    <img src="./template/change/img/guide_firend.png" alt="" style="position:fixed;top:0;right:16px;">
</div>

<div class="feedhead">
    <a href="javascript:history.back(-1)">
        <span class="back1">
            <img src="./template/change/img/back1.png">
        </span>
    </a>
    <a href="wx.php?do=home&uid=<?=$_GET['uid']?>">
        <span class="home1">
        <img src="./template/change/img/home1.png">
        </span>
    </a>
  <span class="feedheadspan2 feedheadspan2_1">
      订单详情
  </span>
</div> <!--feedhead-->
<div style="clear: both"></div>

<div class="feedbody">
      <div class="bookinglist">
           <ul>
              <?php if(is_array($list)) { foreach($list as $value) { ?>
               <li value="0">
                 <div class="bookinglistname">
                    <span style="float: left;padding-left: 10px"><?=$value['username']?>的订单</span>
                    <span style="float: right;padding-right: 10px">
                        <img style="width: 20px;position: relative;top: 5px" src="./template/change/img/arrow1.png">
                    </span>
                     <div style="clear: both"></div>
                 </div>
                  <?php $list1 = $value[zhong]; ?>
                  <?php if(is_array($list1)) { foreach($list1 as $value2) { ?>
                   <div class="bookinglistproduct">
                       <?=$value2['subject']?><span style="float:right;color:red;">单价:<?=$value2['curprice']?></span>
                       <div style="clear:both;"></div>
                   </div>
                   <div class="bookinglistproduct">
                       数量：<?=$value2['number']?>
                   </div>
                    <?php } } ?>
                   <div class="bookinglistprice">
                       <span class="bookinglistprice_s2">
                           总价：<?=$value['count']?>元
                       </span>
                       <div style="clear: both"></div>
                   </div>
                   <div style="clear: both"></div>

                   <div class="bookingdiatel" style="display: none">
                       <div class="customdiatel">
                           <br>
                           <div style="padding-left: 10px;padding-right: 10px">
                               <span class="customdiatel_s1">收件人：</span><span class="customdiatel_s2"><?=$value['username']?></span>
                               <br>
                               <span class="customdiatel_s1">联系电话：</span><span class="customdiatel_s2"><?=$value['tel']?></span>
                               <br>
                               <span class="customdiatel_s1">收件地址：</span><span class="customdiatel_s2"><?=$value['place']?></span>
                               <br>
                               <span class="customdiatel_s1">购买方式：</span><span class="customdiatel_s2">
                               <?php if($value['buystatus']=='payonline') { ?>
                               在线支付
                               <?php } elseif($value['buystatus']=='PayOnDelivery') { ?>
                               货到付款
                               <?php } elseif($value['buystatus']=='PayOnShop') { ?>
                               到店提货
                               <?php } ?>
                               </span>
                           </div>
                           <br>
                       </div><!--customdiatel-->
                       <div class="bookingstate">
                           <div class="bookingstate_d1">
                               可操作功能
                           </div> <!--bookingstate_d1-->
                           <br/>
                           <div class="bookingstate_d2">
                               <a href="wx.php?do=upload&calluid=<?=$value['uid']?>&questionuid=<?=$value['viewuid']?>&dialuid=<?=$_COOKIE['uchome_viewuid']?>" target="_blank">
                <span class="bookingstate_d2_s1">
                  <span><img style="width: 25px;margin-right: 2px" src="./template/change/img/communiteonline.png"></span><span style="position: relative;top: -5px">在线沟通</span>
                </span>
                               </a>
                               <a href="http://site.tg.qq.com/forwardToPhonePage?siteId=1&phone=<?=$value['tel']?>">
                <span class="bookingstate_d2_s2">
                    <span><img style="width: 25px;margin-right: 2px" src="./template/change/img/communitephone.png"></span><span style="position: relative;top: -5px">电话联系</span>
                </span>
                               </a>
                               <div style="clear: both"></div>
                               <br>
                           </div> <!--bookingstate_d2-->
                       </div> <!--bookingstate-->
                       <div class="customdiatel">
                           <div class="bookingstate_d1">
                            订单详情
                           </div> <!--bookingstate_d1-->
                           <br>
                           <div style="padding-left: 10px;padding-right: 10px">
                               
                               <span class="customdiatel_s1">创建时间：</span><span class="customdiatel_s2"><?php echo sgmdate('y-m-d H:i',$value[dateline],1); ?></span>
                               <br>
                               
                           </div>
                           <br>
                       </div><!--customdiatel-->
                       <br>
                   </div><!--bookingdiatel-->

               </li>
               <?php } } ?>
           </ul>
      </div><!--bookinglist-->



</div> <!--feedbody-->

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


</body>

</html><?php ob_out();?>