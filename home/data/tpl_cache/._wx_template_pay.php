<?php if(!defined('IN_UCHOME')) exit('Access Denied');?><?php subtplcheck('./wx/template/pay', '1385715702', './wx/template/pay');?>	<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no"  />
    <meta content="telephone=no" name="format-detection" />
    <meta charset="UTF-8" />

    <title>选择支付方式</title>
    <style type="text/css">
        *
        {
            margin: 0;	padding: 0; border: 0;
            font-family: 'Microsoft yahei' !important;
            -webkit-tap-highlight-color: rgba(0, 0, 0 ,0);
        }
        img
        {
            max-width: 100%;
            height: auto !important;
        }
        input{ border: 0; border-radius: 0 !important; -webkit-appearance: none;}
        textarea{ -webkit-appearance: none; border-radius: 0 !important; }
        a
        {
            text-decoration: none;
        }
        li
        {
            list-style: none;
        }

        body,html
        {
            margin: 0;
            padding: 0;
            width: 100%;
        }
        body
        {
            background-color: #F0F0F0;
        }
    </style>
</head>
<body>
  <form name="alipayment" action="./../payphp/phonealipayapi.php" method=post target="_blank">
      <div style="background-color: #F0F0F0;">
          <div style=" width: 96%;margin-left: 2%;text-align: center;margin-top: 10px;">
              <ul>
                  <a href="">
                  <li style=" width: 100%;background-color: #fff;height: 80px;">
                     <span style="float: left; margin-left: 10px;" >
                       <img style=" width: 80px;margin-top: 20px;" src="./template/change/zhifubao.png">
                     </span>
                      <div style="clear: both"></div>
                      
<input type="hidden" name="WIDseller_email" value="<?=$email?>" />
<input type="hidden" name="WIDout_trade_no" value="<?=$dateline?>,<?=$_COOKIE['uchome_uid']?>" />
<input type="hidden" name="WIDsubject" value="商品" />
<input type="hidden" name="WIDtotal_fee" value="<?=$money?>" />
<input type="hidden" name="WIDbody" value="欢迎选购商品" />
<input type="hidden" name="WIDshow_url" value="欢迎选购商品" />
                     <a href="javascript:document.alipayment.submit();"><span style="color: #666;font-size: 18px;position: relative;top: -35px;" >
                         支付宝支付
                     </span></a>
                 
                  </li>
                  </a>
              </ul>
          </div>
      </div>
        </form>
</body>
</html>

<?php ob_out();?>