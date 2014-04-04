<?php if(!defined('IN_UCHOME')) exit('Access Denied');?><?php subtplcheck('./wx/template/12/feed', '1386042276', './wx/template/12/feed');?><!DOCTYPE html>
<html>
<head>
<meta charset = "utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
<link rel = "stylesheet" href = "template/12/css/base.css" />
<link rel = "stylesheet" href = "template/12/css/common.css" />
<link rel = "stylesheet" href = "template/12/css/page.css" />
<link rel = "stylesheet" href = "template/12/css/mobiscroll.custom-2.5.4.min.css" />
<script type="text/javascript" src = "template/12/js/jquery-v2.0.2.js"></script>
<script type="text/javascript" src = "template/12/js/mobiscroll.custom-2.5.4.min.js"></script>
<script type="text/javascript" src = "template/12/js/main.js"></script>


        <script src="template/js/scrollbox.js"></script>
        <script src="http://code.jquery.com/jquery-1.8.2.min.js"></script>
        <script src="template/js/mobiscroll.custom-2.5.4.min.js"></script>
        <script src="template/js/js/jquery.query.js" type="text/javascript"></script>
        <script type="text/javascript" src="template/js/jquery.tmpl.min.js"></script>
        <script type="text/javascript" src="template/js/feed.js"></script><!-- 时间选择插件 -->



        <script id="detailTemplate" type="text/x-jquery-tmpl">
            <li class="itemList">
                        <a href = "wx.php?do=detail&id={{= <?=$_GET['idtype']?>id}}&uid={{= uid}}&idtype=<?=$_GET['idtype']?>id&type=<?=$_GET['idtype']?>&moblieclicknum=<?=$bac['moblieclicknum']?>">
                        <div class = "w" style="height: 150px;overflow: hidden;">
                            <?=BLOCK_TAG_START?>if image1url<?=BLOCK_TAG_END?>
                            <div class = "wrapperPic"><img src = "http://v5.home3d.cn/home/{{= imageurl}}" class = "w vb" /></div>

                            <?=BLOCK_TAG_START?>if goodscod<?=BLOCK_TAG_END?>
                            <?=BLOCK_TAG_START?>if listshow=='1'<?=BLOCK_TAG_END?>
                            <span class = "price itemPrice">售价：￥{{= curprice}}元</span>
                            <?=BLOCK_TAG_START?>/if<?=BLOCK_TAG_END?>
                            <?=BLOCK_TAG_START?>/if<?=BLOCK_TAG_END?>

                            <?=BLOCK_TAG_START?>/if<?=BLOCK_TAG_END?>
                            <?=BLOCK_TAG_START?>if eventid<?=BLOCK_TAG_END?>
                            <div class = "wrapperPic"><img src = "http://v5.home3d.cn/home/{{= imageurl}}" class = "w vb" /></div>

                            <?=BLOCK_TAG_START?>if goodscod<?=BLOCK_TAG_END?>
                            <?=BLOCK_TAG_START?>if listshow=='1'<?=BLOCK_TAG_END?>
                            <span class = "price itemPrice">售价：￥{{= curprice}}元</span>
                            <?=BLOCK_TAG_START?>/if<?=BLOCK_TAG_END?>
                            <?=BLOCK_TAG_START?>/if<?=BLOCK_TAG_END?>

                            <?=BLOCK_TAG_START?>/if<?=BLOCK_TAG_END?>
                        </div>



                        <div class = "wrapperText">
                                <?=BLOCK_TAG_START?>if eventid<?=BLOCK_TAG_END?>
                                {{= title}}
                                <?=BLOCK_TAG_START?>else<?=BLOCK_TAG_END?>
                               {{= subject}}
                                <?=BLOCK_TAG_START?>/if<?=BLOCK_TAG_END?>

                            <?=BLOCK_TAG_START?>if starttime<?=BLOCK_TAG_END?>
                            <?=BLOCK_TAG_START?>if time<?=BLOCK_TAG_END?>

                            <span style="margin-left:30px;color:red;">拍卖未开始</span>
                            <?=BLOCK_TAG_START?>/if<?=BLOCK_TAG_END?>
                            <?=BLOCK_TAG_START?>if time1<?=BLOCK_TAG_END?>

                            <span style="margin-left:30px;color:red;">拍卖进行中</span>
                            <?=BLOCK_TAG_START?>/if<?=BLOCK_TAG_END?>
                            <?=BLOCK_TAG_START?>if time2<?=BLOCK_TAG_END?>

                            <span style="margin-left:30px;color:red;">拍卖已结束</span>
                            <?=BLOCK_TAG_START?>/if<?=BLOCK_TAG_END?>
                            <?=BLOCK_TAG_START?>/if<?=BLOCK_TAG_END?>

                            </div>




                    </a>
            </li>
        </script>



        <!--列表循环
        <script id="detailTemplate" type="text/x-jquery-tmpl">
            <li class="itemList">
                <a href = "wx.php?do=detail&id={{= <?=$_GET['idtype']?>id}}&uid={{= uid}}&idtype=<?=$_GET['idtype']?>id&type=<?=$_GET['idtype']?>&moblieclicknum=<?=$bac['moblieclicknum']?>">
                    <div class = "w" style="height: 150px;overflow: hidden;">

                        <div class = "wrapperPic"><img src = "http://v5.home3d.cn/home/{{= imageurl}}" class = "w vb" /></div>

                    </div>
                    <div class = "wrapperText"> {{= subject}}</div>
                </a>
            </li>

        </script> -->




</head>
<body style="background-color: #CECECE; ">
<ul class = "p8">
            <div id="detail-panel"></div>
</ul>
<input type = "button" class = "book_btn btn mb35 more_button"  style="margin-bottom: 50px;width: 96%;margin-left: 2%"
        onclick="getComment($('#idtype').val(), $('#uid').val(), $('#page').val(), $('#perpage').val());"  value = "更多"/>

        <br><br>
<img src = "template/12/img/menu.png" class = "menu_btn" id = "show" />

        <input type="hidden" id="id" name="id" value="<?=$_GET['id']?>"/>
        <input type="hidden" id="idtype" name="idtype" value="<?=$_GET['idtype']?>"/>
        <input type="hidden" id="uid" name="uid" value="<?=$_GET['uid']?>"/>
        <input type="hidden" id="page" name="page" value="2"/>
        <input type="hidden" id="perpage" name="perpage" value="4"/>

<div style = "display: none;">
<select name="" id="demo" class="f-dd" onchange="top.location=this.value;">
                <option value="wx.php?do=home&uid=<?=$_GET['uid']?>">首页</option>
                <?php if(is_array($zhongwei)) { foreach($zhongwei as $value) { ?>
                <option value="wx.php?do=feed&uid=<?=$_GET['uid']?>&idtype=<?=$value['english']?>"><?=$value['subject']?></option>
                <?php } } ?>
                <?php if($zhongwei1) { ?>
                <?php if(is_array($zhongwei1)) { foreach($zhongwei1 as $value1) { ?>
                <option value="wx.php?do=feed&uid=<?=$_GET['uid']?>&idtype=<?=$value1['english']?>"><?=$value1['subject']?></option>
                <?php } } ?>
                <?php } ?>
</select>
</div>
</body>
</html><?php ob_out();?>