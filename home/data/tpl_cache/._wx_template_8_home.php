<?php if(!defined('IN_UCHOME')) exit('Access Denied');?><?php subtplcheck('./wx/template/8/home', '1387334175', './wx/template/8/home');?><!DOCTYPE html>
<html>
<head>
<meta charset = "utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
<link rel = "stylesheet" href = "./template/8/css/base.css" />
<link rel = "stylesheet" href = "./template/8/css/common.css" />
<link rel = "stylesheet" href = "./template/8/css/page.css" />
<script type="text/javascript" src = "./template/8/js/jquery-v2.0.2.js"></script>
<script type="text/javascript" src = "./template/8/js/main.js"></script>
        <title><?=$home1['subject']?></title>
</head>
<body>
<div class = "indexFrame">
<div class = "wrapperPic">
<img src = "http://v5.home3d.cn/home/<?=$home1['imageurl']?>" class = "w vb" id="bannerPic" />
</div>


<div class="banner">
<span class="bannerText"><?=$home1['subject']?></span>
</div>
<div class="wrapperPic h4">
<img src = "./template/8/img/dot0.png" class = "h w vt" id="borderPic" />
</div>


<div class = "indexMenu">

                <?php if(is_array($zhongwei)) { foreach($zhongwei as $value) { ?>
<a href = "wx.php?do=feed&uid=<?=$_GET['uid']?>&idtype=<?=$value['english']?>">
<div class = "mainBlock fl">
<div class = "wrapperImg">
                            <?php if($bac['moblieclicknum']=='1'||$bac['moblieclicknum']=='0') { ?>
                            <img src = "http://v5.home3d.cn/home/wx/template/img/<?=$value['icon']?>" />
                            <?php } else { ?>
                            <img src = "http://v5.home3d.cn/home/wx/template/<?=$bac['moblieclicknum']?>/img/<?=$value['icon']?>" />
                            <?php } ?>
                        </div>
<span><?=$value['subject']?></span>
</div>
</a>
                <?php } } ?>
                <?php if(is_array($zhongwei1)) { foreach($zhongwei1 as $value) { ?>
                <a href = "wx.php?do=feed&uid=<?=$_GET['uid']?>&idtype=<?=$value['english']?>">
                    <div class = "mainBlock fl">
                        <div class = "wrapperImg">
                            <?php if($bac['moblieclicknum']=='1'||$bac['moblieclicknum']=='0') { ?>
                            <img src = "http://v5.home3d.cn/home/wx/template/img/<?=$value['icon']?>" />
                            <?php } else { ?>
                            <img src = "http://v5.home3d.cn/home/wx/template/<?=$bac['moblieclicknum']?>/img/<?=$value['icon']?>" />
                            <?php } ?>
                        </div>
                        <span><?=$value['subject']?></span>
                    </div>
                </a>
                <?php } } ?>

</div>

            <?php if($list['0']) { ?>
<div class="recommend">
<div class="recommendHeader">
<span class="recommendTitle pr5">精彩推荐</span>
<hr class="line" />
</div>
                <?php if($list['0']) { ?>
<img src="../<?=$list['0']['imageurl']?>" class="fl mt10">
<div class="recommendText fr mt10 blue"><?=$list['0']['subject']?></div>
                <?php } ?>
                <?php if($list['1']) { ?>
<div class="recommendText fl mt10 green"><?=$list['1']['subject']?></div>
<img src="../<?=$list['1']['imageurl']?>" class="fr mt10">
                <?php } ?>
</div>
            <?php } ?>

            <?php if($list2['0']) { ?>
<div class="recommend">
<div class="recommendHeader">
<span class="recommendTitle pr5">精彩推荐</span>
<hr class="line" />
</div>
</div>
            <?php } ?>
            <?php if($list2['0']) { ?>
<ul class = "mt2 indexLists">
                <?php if($list2['0']) { ?>
<li class="itemList mb10">
<a href = "wx.php?do=detail&id=<?=$list2['0']['goodsid']?>&uid=<?=$list2['0']['uid']?>&idtype=goodsid&type=goods&moblieclicknum=<?=$bac['moblieclicknum']?>">
<div class = "w">
<img src = "../<?=$list2['0']['image1url']?>" class = "vb fl" />
<h4 class="mb3"><?=$list2['0']['subject']?></h4>
<span class = "ml15 itemSubtitle" style="font-size: 17px"><?=$list2['0']['curprice']?> 元</span>
</div>
</a>
</li>

                <?php } ?>

                <?php if($list2['1']) { ?>
                <li class="itemList mb10">
                    <a href = "wx.php?do=detail&id=<?=$list2['1']['goodsid']?>&uid=<?=$list2['1']['uid']?>&idtype=goodsid&type=goods&moblieclicknum=<?=$bac['moblieclicknum']?>">
                        <div class = "w">
                            <img src = "../<?=$list2['1']['image1url']?>" class = "vb fl" />
                            <h4 class="mb3"><?=$list2['1']['subject']?></h4>
                            <span class = "ml15 itemSubtitle" style="font-size: 17px"><?=$list2['1']['curprice']?> 元</span>
                        </div>
                    </a>
                </li>

                <?php } ?>
</ul>
            <?php } ?>
<img src="./template/8/img/toTop.png" id="btn_top" />
</div>
</body>

    <script type="text/javascript">
        $(function () {
            $("#btn_top").fadeOut(0);
            $(window).scroll(function () {
                var scrollTopValue = $(window).scrollTop();
                if (scrollTopValue > 100) {
                    $("#btn_top").fadeIn();
                } else {
                    $("#btn_top").fadeOut();
                }
            })
            $("#btn_top").click(function () {
                $("html, body").animate({scrollTop:0}, 600);
                return false;
            })
        })
    </script>
</html><?php ob_out();?>