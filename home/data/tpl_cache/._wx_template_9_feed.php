<?php if(!defined('IN_UCHOME')) exit('Access Denied');?><?php subtplcheck('./wx/template/9/feed', '1396410263', './wx/template/9/feed');?><!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no"  />
<link rel="stylesheet" href="template/9/css/base.css" />
<link rel="stylesheet" href="template/9/css/common.css" />
<link rel="stylesheet" href="template/9/css/contentList.css" />
<link rel="stylesheet" href="template/9/css/info.css" />
<link rel="stylesheet" href="template/9/css/button.css" />
    <link rel="stylesheet" href="template/9/css/mobiscroll.custom-2.5.4.min.css" />

    <script type="text/javascript" src="template/js/jquery-v2.0.2.js"></script>
    <script type="text/javascript" src="template/js/mobiscroll.custom-2.5.4.min.js"></script>
    <script type="text/javascript" src="template/js/js/jquery.query.js"></script>
    <script type="text/javascript" src="template/js/jquery.tmpl.min.js"></script>
    <script type="text/javascript" src="template/js/feed.js"></script>

    <style type="text/css">

        li
        {
            list-style: none;
        }
        .info_span
         {
           color:  #BFBFBF;
            font-size: 14px;
         }
    </style>

    <script type="text/javascript">
        $(document).ready(function(){
            var anyTransformY = function(target, distance) {
                $(target).css("-webkit-transform", "translateY("+distance+")");
            };
            anyTransformY(".contentTitle", "40px");
            anyTransformY(".contentHide-button", "-35px");


            $('#nav').mobiscroll().select( {
                theme: 'android-ics',
                lang: 'zh',
                display: 'bottom',
                mode: 'scroller',
                inputClass: 'i-txt',
                width: 200
            });



            $('#show').click(function() {
                $('#nav').mobiscroll('show');
                return false;
            });

            $('#clearSelect').click(function() {
                $('#nav').val(1).change();
                $('#nav'+'_dummy').val(' ');
                return false;
            });
        });
    </script>


    <script id="detailTemplate" type="text/x-jquery-tmpl">
        <ul class="contentList">
        <a href = "wx.php?do=detail&id={{= <?=$_GET['idtype']?>id}}&uid={{= uid}}&idtype=<?=$_GET['idtype']?>id&type=<?=$_GET['idtype']?>&moblieclicknum=<?=$bac['moblieclicknum']?>">
            <li class="contentList-item cb">
                    <?=BLOCK_TAG_START?>if image1url<?=BLOCK_TAG_END?>
                 <div><img src = "http://v5.home3d.cn/home/{{= imageurl}}" alt="" class="fl"
                        style="margin:0;padding:0;width:70px;height:70px;margin-left:10px;margin-top:10px;" />
                   <h2 style="margin-left:90px;font-size:17px;font-weight:normal;" class="contentList-itemTitle f20 pt10 cTitle">
                       <?=BLOCK_TAG_START?>if eventid<?=BLOCK_TAG_END?>
                       {{= title}}
                       <?=BLOCK_TAG_START?>else<?=BLOCK_TAG_END?>
                       {{= subject}}
                       <?=BLOCK_TAG_START?>/if<?=BLOCK_TAG_END?>
                   </h2>

                    <?=BLOCK_TAG_START?>if goodscod<?=BLOCK_TAG_END?>
                    <?=BLOCK_TAG_START?>if listshow=='1'<?=BLOCK_TAG_END?>
                    <div class="priceText cTime fr f14"><span class="cPrice price f20">{{= curprice}}</span>元/年</div> </div>
                    <?=BLOCK_TAG_START?>/if<?=BLOCK_TAG_END?>
                    <?=BLOCK_TAG_START?>/if<?=BLOCK_TAG_END?>

                    <?=BLOCK_TAG_START?>/if<?=BLOCK_TAG_END?>

                    <?=BLOCK_TAG_START?>if eventid<?=BLOCK_TAG_END?>
                <div><img src = "http://v5.home3d.cn/home/{{= imageurl}}" alt="" class="fl"
                     style="margin:0;padding:0;width:70px;height:70px;margin-left:10px;margin-top:10px;"/>
                <h2 style="margin-left:90px;font-size:17px;font-weight:normal;" class="contentList-itemTitle f20 pt10 cTitle">
                    <?=BLOCK_TAG_START?>if eventid<?=BLOCK_TAG_END?>
                    {{= title}}
                    <?=BLOCK_TAG_START?>else<?=BLOCK_TAG_END?>
                    {{= subject}}
                    <?=BLOCK_TAG_START?>/if<?=BLOCK_TAG_END?>
                </h2>

                <?=BLOCK_TAG_START?>if goodscod<?=BLOCK_TAG_END?>
                <?=BLOCK_TAG_START?>if listshow=='1'<?=BLOCK_TAG_END?>
                <div class="priceText cTime fr f14"><span class="cPrice price f20">{{= curprice}}</span>元/年</div> </div>
                <?=BLOCK_TAG_START?>/if<?=BLOCK_TAG_END?>
                <?=BLOCK_TAG_START?>/if<?=BLOCK_TAG_END?>

                <?=BLOCK_TAG_START?>/if<?=BLOCK_TAG_END?>

                <div class="contentList-itemTime cTime f14">{{= dateline}}</div>

                <div class = "info_span subtitle">



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

            </li>
        </a>

        </ul>

    </script>


  <!--列表循环
    <script id="detailTemplate" type="text/x-jquery-tmpl">

        <ul class="contentList">
            <a href="wx.php?do=detail&id={{= <?=$_GET['idtype']?>id}}&uid={{= uid}}&idtype=<?=$_GET['idtype']?>id&type=<?=$_GET['idtype']?>&moblieclicknum=<?=$bac['moblieclicknum']?>">
                <li class="contentList-item cb">
                    <img style="margin:0;padding:0;width:70px;height:70px;margin-left:10px;margin-top:10px;"
                         src="{{= image1url}}" alt="" class="fl" />
                    <h2 style="margin-left:90px" class="contentList-itemTitle f20 pt10 cTitle">{{= subject}}</h2>
                   <!-- <p class="summary f14 cParagraph">摘要:1965年，EF英孚教育在瑞典创立，使命是『打破语言、...</p>
                    <span style="margin-left:8px" class="contentList-itemTime cTime f14">{{= dateline}}</span>
                </li>
            </a>
          </ul>


        <div class="split">
            <br />
        </div>

    </script>   -->


    <script type="text/javascript">
        $(document).ready(function(){
            $('#nav'+'_dummy').hide();
        });
    </script>









<title><?=$appname?></title>
</head>




<body>
<div class="contentHide">
        <!--列表标题-->
<div class="contentTitle cPrice f20"><?=$appname?></div>
        <!--列表展示的位置-->
        <div id="detail-panel"></div>


       <!--“更多”按钮-->
        <input style="border-radius: 0 !important;-webkit-appearance: none;
        width: 96%;margin-left:2%;color: #ffffff;font-size: 20px;font-family: '微软雅黑'"
        type = "button"
         onclick="getComment($('#idtype').val(), $('#uid').val(), $('#page').val(), $('#perpage').val());"
         value = "更&nbsp多" class = "more_button"  />

        <input type="hidden" id="id" name="id" value="<?=$_GET['id']?>"/>
        <input type="hidden" id="idtype" name="idtype" value="<?=$_GET['idtype']?>"/>
        <input type="hidden" id="uid" name="uid" value="<?=$_GET['uid']?>"/>
        <input type="hidden" id="page" name="page" value="2"/>
        <input type="hidden" id="perpage" name="perpage" value="4"/>
        <div style = "display: none;">
            <select name="" id="demo" class="f-dd">
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

<div class="contentHide-button tc w">
<a href="wx.php?do=home&uid=<?=$_GET['uid']?>"><img src="./template/9/img/btn_close.png" alt="" class="btnClose" /></a>
</div>

        <div class="split">
            <br />
        </div>

</div>

</body>
</html>
<?php ob_out();?>