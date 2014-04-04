<?php if(!defined('IN_UCHOME')) exit('Access Denied');?><?php subtplcheck('./wx/template/booking_success', '1396512768', './wx/template/booking_success');?><!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no"  />
    <meta content="telephone=no" name="format-detection" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

    <link rel="stylesheet" href="template/css/yunkangbase.css">
    <link rel="stylesheet" href="template/css/yunkangmain.css">

    <script src="js/jquery-1.9.1.min.js"></script>
   <!-- <script src="js/jquery.mobile.min.js"></script>  -->
    <title>接种预约</title>
</head>
<body>
     <div class="mainbody">
        <div class="listbox">
             <div class="listuppic"></div>
             <div class="listcontent">
                 <div class="logotitle">
                    <div class="leftcol"></div>
                    <div class="rightpic"><img src="images/logo.png"></div>
                    <div class="clear"></div>
                 </div>
                 <div class="listcontentbody">
                     <div class="numshowbox">
                         <h1><?=$number?></h1>
                        <img src="images/successlist.png">
                     </div>
                     <div class="showmessage">
                         您的接种流水号为<em><?=$number?></em>，预计接种时间为<em>3月27日 上午10：05</em>，请提前到达现场
                     </div>
                 </div>
                 <br>
             </div>
             <div class="listdownpic"></div>
        </div>
        <form action="wx.php?do=upload" method="POST">
         <div class="btnbox">
            <input type="submit" name="bookingcancel" value="取消预约">
            <input type="hidden" name="numberid" value="<?=$number?>">
            <input type="hidden" name="id" value="<?=$id?>">
            
         </div>
         </form>
       <div class="btnbox">
            <a href="http://localhost/yunkang/yunkang/home/wx/wx.php?
do=detail&id=<?=$id?>&uid=<?=$uid?>&idtype=bookingid&type=booking&viewuid=&wxkey=&moblieclicknum=&cheak=1&ij=1">返回</a>        
         </div>  
     </div>
</body>
</html><?php ob_out();?>