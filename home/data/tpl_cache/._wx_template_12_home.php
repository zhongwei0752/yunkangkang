<?php if(!defined('IN_UCHOME')) exit('Access Denied');?><?php subtplcheck('./wx/template/12/home', '1386841790', './wx/template/12/home');?><!DOCTYPE html>
<html>
<head>
<meta charset = "utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
<link rel = "stylesheet" href = "./template/12/css/base.css" />
<link rel = "stylesheet" href = "./template/12/css/common.css" />
<link rel = "stylesheet" href = "./template/12/css/page.css" />
        <link rel = "stylesheet" href = "./template/12/css/template12myadd.css" />
<script type="text/javascript" src = "./template/12/js/jquery-v2.0.2.js"></script>
<script type="text/javascript" src = "./template/12/js/main.js"></script>
        <title><?=$home1['subject']?></title>
</head>
<body style="background-color: #CECECE;">
<div class = "wrapperPic logo">
<img src = "http://v5.home3d.cn/home/<?=$home1['imageurl']?>" class = "w vb" id = "pic0" />
<img src = "http://v5.home3d.cn/home/<?=$home1['imageurl']?>" class = "w vb" id = "pic1" />
<img src = "http://v5.home3d.cn/home/<?=$home1['imageurl']?>" class = "w vb" id = "pic2" />
<img src = "http://v5.home3d.cn/home/<?=$home1['imageurl']?>" class = "w vb" id = "pic3" />
</div>
<div class = "wrapperPic bannerPic">
<img src = "./template/12/img/bar.png" class = "w vb" />
</div>
<div class = "bannerText"><?=$home1['subject']?></div>
<div class = "bannerDot">
<ul>
<li><img src = "./template/12/img/selected_dot.png" /></li>
<li><img src = "./template/12/img/unselected_dot.png" /></li>
<li><img src = "./template/12/img/unselected_dot.png" /></li>
<li><img src = "./template/12/img/unselected_dot.png" /></li>
</ul>
</div>
        <div class="mainMenu mt15 mb8">
            <?php if(is_array($zhongwei)) { foreach($zhongwei as $value) { ?>
            <div class="menu_choice" onclick="location.href= 'wx.php?do=feed&uid=<?=$_GET['uid']?>&idtype=<?=$value['english']?>'">
                <?php if($bac['moblieclicknum']=='1'||$bac['moblieclicknum']=='0') { ?>
                <img src="http://v5.home3d.cn/home/wx/template/img/<?=$value['icon']?>" alt="" />
                <?php } else { ?>
                <img src="http://v5.home3d.cn/home/wx/template/<?=$bac['moblieclicknum']?>/img/<?=$value['icon']?>" alt="" />
                <?php } ?>
                <div class="menu_choice_name"><?=$value['subject']?></div>
            </div>
            <?php } } ?>
            <?php if(is_array($zhongwei1)) { foreach($zhongwei1 as $value) { ?>
            <div class="menu_choice" onclick="location.href= 'wx.php?do=feed&uid=<?=$_GET['uid']?>&idtype=<?=$value['english']?>'">
                <?php if($bac['moblieclicknum']=='1'||$bac['moblieclicknum']=='0') { ?>
                <img src="http://v5.home3d.cn/home/wx/template/img/<?=$value['icon']?>" alt="" />
                <?php } else { ?>
                <img src="http://v5.home3d.cn/home/wx/template/<?=$bac['moblieclicknum']?>/img/<?=$value['icon']?>" alt="" />
                <?php } ?>
               <div class="menu_choice_name"><?=$value['subject']?></div>
            </div>
            <?php } } ?>



        </div>
<!--<table class = "mainMenu mt15 mb8">
<tbody>
<tr>
<td class = "clearBL clearBT" onclick="location = 'info.html'"><img src = "img/info.png">企业介绍</td>
<td class = "clearBT" onclick="location = 'product.html'"><img src = "img/product.png">产品介绍</td>
<td class = "clearBR clearBT" onclick="location = 'feed.html'"><img src = "img/business_movement.png">企业动态</td>
</tr>
<tr>
<td class = "clearBL" onclick="location = 'trends.html'"><img src = "img/industry_trends.png">行业动态</td>
<td onclick="location = 'indent.html'"><img src = "img/indent.png">订单管理</td>
<td class = "clearBR" onclick="location = 'client.html'"><img src = "img/client.png">客户管理</td>
</tr>
<tr>
<td class = "clearBL clearBB" onclick="location = 'job.html'"><img src = "img/job.png">人才招聘</td>
<td class = "clearBB" onclick="location = 'book.html'"><img src = "img/book.png">预约预订</td>
<td class = "clearBB" onclick="location = 'book.html'"><img src = "img/success.png">成功案例</td>
</tr>
<tr>
<td class = "clearBL clearBB" onclick="location = 'job.html'"><img src = "img/branch.png">分支结构</td>
<td class = "clearBB" onclick="location = 'commodity.html'"><img src = "img/commodity.png">商品管理</td>
<td class = "clearBB" onclick="location = 'book.html'"><img src = "img/contact.png">在线沟通</td>
</tr>
<tr>
<td class = "clearBL clearBB" onclick="location = 'job.html'"><img src = "img/focus.png">焦点推荐</td>
<td class = "clearBB" onclick="location = 'book.html'"><img src = "img/send.png">群发</td>
<td class = "clearBB" onclick="location = 'book.html'"><img src = "img/template.png">选择手机模板</td>
</tr>
</tbody>
</table>    -->
</body>

</html><?php ob_out();?>