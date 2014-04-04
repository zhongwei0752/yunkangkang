<?php if(!defined('IN_UCHOME')) exit('Access Denied');?><?php subtplcheck('./wx/template/good', '1387358205', './wx/template/good');?><!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no"  />
    <meta content="telephone=no" name="format-detection" />
    <meta charset="UTF-8" />
    <link rel="stylesheet" href="./template/change/css/myall.css" />
    <link rel = "stylesheet" type = "text/css" href = "template/css/main.css">
    <link rel="stylesheet" href="./template/css/expressInfo.css" />
    <link rel="stylesheet" href="template/css/mobiscroll.custom-2.5.4.min.css">
    <script src="template/js/jquery-v2.0.2.js"></script>
    <script type="text/javascript" src="./template/change/js/myall.js"></script>
    <script src="template/js/mobiscroll.custom-2.5.4.min.js"></script>
    <script src="template/js/scrollbox.js"></script>
    <script src="template/js/mobiscroll.custom-2.5.4.min.js"></script>
    <script src="template/js/js/jquery.query.js" type="text/javascript"></script>
    <script type="text/javascript" src="template/js/jquery.tmpl.min.js"></script>
    <script type="text/javascript" src="template/js/feed.js"></script><!-- 时间选择插件 -->
    <title><?=$appname?></title>
    <script id="detailTemplate" type="text/x-jquery-tmpl">
        <li>
               
                <table>
                    <tr>
                        <td class="shoppinglist_td1">
                         <?=BLOCK_TAG_START?>if askid<?=BLOCK_TAG_END?>
                        <a href = "wx.php?do=detail&id={{= id}}&uid={{= q_uid}}&idtype=<?=$_GET['idtype']?>id&type=<?=$_GET['idtype']?>&viewuid=<?=$uid?>&wxkey=<?=$_GET['wxkey']?>&moblieclicknum=<?=$bac['moblieclicknum']?>&cheak=1">
                        <?=BLOCK_TAG_START?>else<?=BLOCK_TAG_END?>
                        <a href = "wx.php?do=detail&id={{= <?=$_GET['idtype']?>id}}&uid={{= uid}}&idtype=<?=$_GET['idtype']?>id&type=<?=$_GET['idtype']?>&viewuid=<?=$uid?>&wxkey=<?=$_GET['wxkey']?>&moblieclicknum=<?=$bac['moblieclicknum']?>&cheak=1">
                        <?=BLOCK_TAG_START?>/if<?=BLOCK_TAG_END?>
                         <div class="shoppinglist_title">
                            <?=BLOCK_TAG_START?>if eventid<?=BLOCK_TAG_END?>
                            <h4>{{= title}}</h4>
                            <?=BLOCK_TAG_START?>else<?=BLOCK_TAG_END?>
                            <h4>{{= subject}}</h4>
                            <?=BLOCK_TAG_START?>/if<?=BLOCK_TAG_END?>
                         </div>
                         <div>
                             <span class="shoppinglist_price1">特价：￥{{= curprice}}</span>
                             <span class="shoppinglist_price2">原价：￥{{= oldprice}}</span>
                         </div>
                         </a>
                         <input class="addshoppingcar" id="{{= <?=$_GET['idtype']?>id}}" type="button" value="加入购物车" onclick="addtocar({{= <?=$_GET['idtype']?>id}})">
                        </td>
                        <td class="shoppinglist_td2">
                        <?=BLOCK_TAG_START?>if image1url<?=BLOCK_TAG_END?>
                        <img src = "{{= image1url}}" />
                        <?=BLOCK_TAG_START?>/if<?=BLOCK_TAG_END?>
                        <?=BLOCK_TAG_START?>if eventid<?=BLOCK_TAG_END?>
                        <img src = "../{{= pic}}" />
                        <?=BLOCK_TAG_START?>/if<?=BLOCK_TAG_END?>
                         
                        </td>
                    </tr>
                </table>
                
            </li>

            
    </script>
</head>
<body>
    <div class = "navigation">
        <span><?=$appname?></span>
        <a href = "#" id = "show" class = "menu_btn"><img src = "./template/img/menu_btn.png" id = "show" /></a>
    </div>   <!--navigation-->
    <div class="shoppinglist">
        <ul>
            <div id="detail-panel"></div>   
        </ul>

    </div>   <!--shoppinglist-->
     <input type="button" value="查看更多" onclick="getComment($('#idtype').val(), $('#uid').val(), $('#page').val(), $('#perpage').val());" class="more_button">
            <input type="hidden" id="id" name="id" value="<?=$_GET['id']?>"/>
            <input type="hidden" id="idtype" name="idtype" value="<?=$_GET['idtype']?>"/>
            <input type="hidden" id="uid" name="uid" value="<?=$_GET['uid']?>"/>
            <input type="hidden" id="page" name="page" value="2"/>
            <input type="hidden" id="perpage" name="perpage" value="10"/>
     <div class="shoppingcar1">
         <!-- <a href="wx.php?do=booking&uid=<?=$_COOKIE['uchome_uid']?>"> --><span style="background-image: url('./template/change/img/background1.png');background-repeat:repeat-x;float: left;
        padding: 2px;border-radius: 5px;position: relative;left: -10px;width:38px;" id="buttonBuy1">
            <img style="position: relative;top: 2px" src="./template/change/img/book.png">
        </span><!-- </a> -->
        <span><img class="buynum" src="./template/change/img/buynum.png"></span><span id="buynum11" class="buynum1"><?=$_COOKIE['time']?></span>
        <a href="wx.php?do=car&uid=<?=$_GET['uid']?>"><img src="./template/change/img/shoppingcar1.png"></a>
     </div>
     <div style = "display: none;">
            <select name="" id="demo" class="f-dd">
                <option value="wx.php?do=home&uid=<?=$_GET['uid']?>&wxkey=<?=$_GET['wxkey']?>">首页</option>
                <?php if(is_array($zhongwei)) { foreach($zhongwei as $value) { ?>
                <option value="wx.php?do=feed&uid=<?=$_GET['uid']?>&idtype=<?=$value['english']?>&wxkey=<?=$_GET['wxkey']?>"><?=$value['subject']?></option>
                <?php } } ?>
                <?php if($zhongwei1) { ?>
                <?php if(is_array($zhongwei1)) { foreach($zhongwei1 as $value1) { ?>
                <option value="wx.php?do=feed&uid=<?=$_GET['uid']?>&idtype=<?=$value1['english']?>&wxkey=<?=$_GET['wxkey']?>"><?=$value1['subject']?></option>
                <?php } } ?>
                <?php } ?>
            </select>
    </div>
    <input type="hidden" id="time" name="time" value="<?=$_COOKIE['time']?>"/>
     <script type="text/javascript" charset="utf-8">
     var time=$("#time").val();
     if(!time){
        time=='1';
     }
       function addtocar(id){
        
        $.ajax({
        //dataType:"jsonp",
        url:"wx.php?do=upload",
        type: "POST",
        data:{
            "addtocar":'1',
            "id": id,
        },
        success:function(data){
            time=Number(time)+Number(1);

            $("#buynum11").html(time);
            $("#"+id+"").css({"backgroundColor":"#FF9326"});
            $("#"+id+"").val("已加入购物车");
            

        },
    });

        }
     </script>
        <script type="text/javascript">
        $(document).ready(function(){
            $(".expressInfo2").hide();
            <?php if($_GET['status']=='tanchuan') { ?>
                $(".expressInfo2").fadeIn();
                <?php } ?>
            $("#buttonBuy1").click(function(){
                $(".expressInfo1").fadeIn();
                });
            <?php if($_GET['status']=='tanchuan') { ?>
            $("#queren").click(function(){
                $(".expressInfo2").fadeOut();
                });
            <?php } ?>
            //点击表格外的地方时消失
            $(".expressInfo1").click(function(){
                $(".expressInfo1").fadeOut();
                });
            <?php if($_GET['status']=='tanchuan') { ?>
            $(".expressInfo2").click(function(){
                $(".expressInfo2").fadeOut();
                });
            <?php } ?>
            $("#buttonSubmit").click(function(){
                $(".expressInfo").fadeOut();
                });
            //阻止事件冒泡
            $(".formContainer1").click(function(event){
                event.stopPropagation();
                });

            });
            
    </script>  
    <div class="expressInfo1">
        <div class="formContainer1 bc tc">
        <form method="post" action="wx.php?do=upload">
            <h1 id="formTitle">密码确认</h1>
            <input type="text" placeholder="密码" name="password"  class="inputContainer" />
            <br />

            <input type="submit" class="buttonSubmit" value="提交">
            <input type="hidden" id="uid" name="uid" value="<?=$_GET['uid']?>"/>
            <input type="hidden" id="gid" name="gid" value="<?=$_GET['id']?>"/>
            <input type="hidden" id="viewuid" name="viewuid" value="<?=$_GET['viewuid']?>"/>
            <input type="hidden" name="moblieclicknum" value="<?=$_GET['moblieclicknum']?>">
            <input type="hidden" name="password1" value="1">
            <input type="hidden" id="wxkey" name="wxkey" value="<?=$_GET['wxkey']?>"/>
        </div> <!-- formContainer -->
        </form> 
    </div> <!-- expressInfo -->   
    <div class="expressInfo2" style="margin-top:50px;">
        <div class="formContainer1 bc tc" style="height:180px;margin-top:10px;">

            <h1 id="formTitle">订单确认</h1>
            <br />
            亲，你已下单成功。<br/><br/>
            <input type="button" class="buttonSubmit" id="queren" value="确认"/>
        </div> <!-- formContainer -->

    </div> <!-- expressInfo -->   

</body>   
   
</html><?php ob_out();?>