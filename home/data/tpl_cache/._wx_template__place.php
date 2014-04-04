<?php if(!defined('IN_UCHOME')) exit('Access Denied');?><?php subtplcheck('./wx/template//place', '1387357039', './wx/template//place');?><!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no"  />
    <meta content="telephone=no" name="format-detection" />
    <meta charset="UTF-8" />
    <!-- <link rel="stylesheet" href="./template/change/css/myall.css" /> -->
    <?php if($bac['moblieclicknum']=='1'||$bac['moblieclicknum']=='0') { ?>
    <link rel="stylesheet" href="./template/change/css/goodsshoping.css" />
    <?php } else { ?>
    <link rel="stylesheet" href="./template/<?=$bac['moblieclicknum']?>/change/css/goodsshoping.css" />
    <?php } ?>


    <script type="text/javascript" src="./template/change/js/jquery-1.10.2.js"></script>
    <script type="text/javascript" src="./template/change/js/myall.js"></script>



    <title>加入购物车</title>
</head>
<body style="background-color: #fff">
   <!--  <div class="goods_diatel_body1">
     <table class="goods_diatel_table1">
         <tr>
             <td class="goods_diatel_td1">
              <img src="img/exam1.jpg">
             </td>
             <td class="goods_diatel_td2">
                 <p class="shoppinglist_title goods_diatel_title">雪纺黑白衬衣</p>
                 <p>
                     <span class="shoppinglist_price1">特价：￥79</span>
                     <span class="shoppinglist_price2">特价：￥79</span>
                 </p>
             </td>
         </tr>
     </table>
     <p class="chooseclass">选择分类：</p>
     <div class="goodstype1">
         <ul>
             <li>
                 咖啡色
             </li>
             <li>
                 黑色
             </li>
             <li>
                 红色
             </li>
             <li>
                 卡其色
             </li>

         </ul>
     </div>
        <div style="clear: both"></div>
        <div class="goodstype2">
            <ul>
                <li>
                    S码
                </li>
                <li>
                    L码
                </li>
                <li>
                    M码
                </li>
                <li>
                    XL码
                </li>

            </ul>
        </div>
        <div style="clear: both"></div>

     <p class="chooseclass">数量：</p>
     <table class="goods_diatel_table3">
         <tr>
             <td class="goods_diatel_td3 reduce">
               <input type="button" value="-">
             </td>
             <td class="goods_diatel_td4">
                <p>0</p>
             </td>
             <td class="goods_diatel_td3 add">
                 <input type="button" value="+">
             </td>
         </tr>

     </table>
     <p class="subprice0">
         <span class="subprice1">总价：</span>
         <span class="subprice2">￥240</span>
     </p>
        <div style="clear: both"></div>
    </div> -->
  <form method="post" action="wx.php?do=place&count=<?=$count?>" name="placeform">
  <div class="surepay">
        <div class="addressee">
            <span class="addressee_s1">
                收件人：
            </span>
             <span>
               <input type="text" name="recive">
            </span>
        </div>
        <div class="contact">
            <span class="contact_s1">
               联系电话：
            </span>
             <span>
               <input type="text" name="tel">
            </span>
        </div>
        <div class="ShippingAddress">
            <span class="ShippingAddress_s1">
               收货地址：
            </span>
             <!-- <span>
               <select>
                   <option value="selected">省</option>
                   <option>山东</option>
                   <option>广东</option>
                   <option>江西</option>
                   <option>四川</option>
               </select>
            </span>
             <span>
                <select>
                    <option value="selected">市</option>
                    <option>北京</option>
                    <option>广州</option>
                    <option>上海</option>
                    <option>香港</option>
                </select>
            </span> -->
        </div>
        <div class="ShippingAddressDiatel">

            <textarea placeholder="&nbsp;&nbsp;具体地址" name="place"></textarea>
        </div>
      <div class="ShippingMethod">
            <span class="ShippingMethod_s1">
               送货方式：
            </span>
            <span>
                <?php if($a) { ?>
                <input type="button" value="在线支付" id="PayOnLine" >
               
               <?php } ?>
               <?php if($b) { ?>
               <input type="button" value="货到付款" id="PayOnDelivery" >
               <?php } ?>
               <?php if($c) { ?>
               <input type="button" class="ShippingMethod_s2_3" value="到店提货" id="PayOnShop">
               <?php } ?>
               
               
            </span>

      </div>
        <input type="hidden" id="paystatus" name="paystatus" value="PayOnDelivery"/>
        <div id="zhong">
        <a href="javascript:document.placeform.submit();"><input class="surepaybotton" type="button" value="确认付款"></a>
    </div>
    </div>

    <?php if(is_array($id)) { foreach($id as $value) { ?>
    <input type="hidden" name="goodsid[]" value="<?=$value?>"/>
    <?php } } ?>

</form>

</body>



</html><?php ob_out();?>