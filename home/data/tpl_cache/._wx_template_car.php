<?php if(!defined('IN_UCHOME')) exit('Access Denied');?><?php subtplcheck('./wx/template/car', '1387358198', './wx/template/car');?><!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no"  />
    <meta content="telephone=no" name="format-detection" />
    <meta charset="UTF-8" />
    <link rel="stylesheet" href="./template/change/css/myall.css" />
    <script type="text/javascript" src="./template/change/js/jquery-1.10.2.js"></script>
    <script type="text/javascript" src="./template/change/js/myall.js"></script>



    <title>购物车</title>
</head>
<body>
<form method="post" action="wx.php?do=place" name="carform">
<div class="carbody">
    <ul>
        <?php if(is_array($car)) { foreach($car as $value) { ?>
        <li class="zhong">
           <table class="wei">
               <tr>
                   <td class="carbody_li_td1">
                    <img src="./template/change/img/okbuy1.png" id="0">
                   </td>
                   <td class="carbody_li_td2">
                      <img src="http://v5.home3d.cn/home/<?=$value['image1url']?>">
                   </td>
                   <td class="carbody_li_td3">
                       <p class="carbody_td3_p1"><?=$value['subject']?></p>
                       <p class="carbody_td3_p2">
                           <span>现价: ￥<?=$value['curprice']?>元</span> <span>原价: ￥<?=$value['oldprice']?>元</span>
                       </p>
                       <!-- <p class="carbody_td3_p2">
                          <span>选择分类:</span>
                          <span>咖啡色</span>
                          <span>XL码</span>
                       </p> -->
                       <p class="carbody_td3_p2">数量: </p>
                       <table class="goods_diatel_table3 goods_car3_choose">
                           <tr>
                               <td class="goods_diatel_td3 reduce">
                                   <input type="button" value="-">
                               </td>
                               <input type="hidden" name="money" id="money" value="<?=$value['curprice']?>">
                               <td class="goods_diatel_td4">
                                   <p>1</p>
                               </td>
                               <td class="goods_diatel_td3 add">
                                   <input type="button" value="+">
                               </td>
                           </tr>
                       </table>
                   </td>
               </tr>
           </table>

            <div class="carbody_sumprice">
                <span class="carbody_sumprice_s1">
                    <img src="./template/change/img/delete.png">
                    <input type="hidden" name="listid" id="listid" value="<?=$value['goodsid']?>">
                </span>
              <span class="carbody_sumprice_s3"><?=$value['curprice']?>元</span><span class="carbody_sumprice_s2">小计：</span>
            </div>
            <div style="clear: both"></div>
<!--         <input type="hidden" name="buyid[]" id="buyid" value="<?=$value['goodsid']?>"> -->
        <input type="hidden" name="click[]" id="click" value="<?=$value['goodsid']?>.1">
        </li>
        <?php } } ?>
    </ul>
</div>  <!--carbody-->
<input type="hidden" name="carbuy" id="carbuy" value="1">
<input type="hidden" name="yunfei" id="yunfei" value="<?=$yunfei['yunfei']?>">
<input type="hidden" name="manyunfei" id="manyunfei" value="<?=$yunfei['manyunfei']?>">
<?php if($sum<$yunfei['manyunfei']) { ?>
<input type="hidden" name="yunfeistatus" id="yunfeistatus" value="0">
<?php } ?>
<div class="goods_car3_bottommenu">
     <table>
         <tr>
             <td class="car3_bottommenu_td1">
                <img src="./template/change/img/nobuy2.png">
             </td>
             <td class="car3_bottommenu_td2">
                <p>
                    <span class="car3_bottommenu_td2_s1">总金额</span>
                    <span class="car3_bottommenu_td2_s2"><?=$sum?></span>
                    <?php if(empty($yunfei['manyunfei'])||$sum>$yunfei['manyunfei']) { ?>
                    <?php if($yunfei['yunfei']) { ?>
                    <br/>
                    <span class="car3_bottommenu_td2_s3">运费:<?=$yunfei['yunfei']?></span>
                    <input type="hidden" name="yunfeistatus" id="yunfeistatus" value="1">
                    <?php } ?>
                    <?php } ?>
                    <input type="hidden" name="sum" id="sum" value="<?=$sum?>">
                </p>
             </td>
             <td class="car3_bottommenu_td3">
                 <div class="sumprice">
                  <?php if($car) { ?>
                     <a href="javascript:document.carform.submit();" style='text-decoration: none;color:#FFF;'><span>结算(</span><span><?=$count?></span><span>)</span></a>
                  <?php } else { ?>
                     <span>结算(</span><span>空</span><span>)</span>
                   <?php } ?>
                 </div>
             </td>
             <input type="hidden" name="time" id="time" value="<?=$count?>">
             <input type="hidden" name="uid" id="uid" value="<?=$_GET['uid']?>">
         </tr>
     </table>
</div>    <!--goods_car3_bottommenu-->
</form>

</body>
</html><?php ob_out();?>