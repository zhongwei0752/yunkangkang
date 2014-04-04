<?php if(!defined('IN_UCHOME')) exit('Access Denied');?><?php subtplcheck('./wx/template/9/home', '1396408156', './wx/template/9/home');?><!DOCTYPE html>
<html lang="zh">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no"  />
<link rel="stylesheet" href="./template/9/css/base.css" />
<link rel="stylesheet" href="./template/9/css/common.css" />
<link rel="stylesheet" href="./template/9/css/index.css" />
<script type="text/javascript" src="./template/9/js/jquery-v2.0.2.js"></script>
<title><?=$home1['subject']?></title>

<script type="text/javascript">
$(document).ready(function(){
//此版本使用了css3动画

//定义css3 transform动画，动画速度在index.css中的-webkit-transition-duration属性定义为1000ms
var anyTransformY = function(target, distance) {
$(target).css("-webkit-transform", "translateY("+distance+")");
};
//页面加载时三大块分别调用动画函数（页面表现为上下合）
anyTransformY(".wrapperPicture", "500px");
anyTransformY(".titlePic","500px");
anyTransformY(".itemList", "-500px");
//列表中任意一项点击后触发的函数
$("tr").click(function(){

//goLocation变量是把点击项的id与跳转页面的地址联系起来，id+.html
var goLocation = "wx.php?do=feed&uid=<?=$_GET['uid']?>&idtype="+$(this).attr('id');
//点击任意一项，三大块调用动画函数（页面表现为上下分）
anyTransformY(".wrapperPicture", "-500px");
anyTransformY(".titlePic","-500px");
anyTransformY(".itemList", "500px");
//css3动画不自带回调函数，所以只能通过setTimeout来等动画执行完后再跳转页面
//通过闭包来访问外部变量goLocation
setTimeout(
(function(k){
return function(){
window.location = k;
}
})(goLocation), 800);
});
});
</script>
</head>
<body>
<div class="wrapperPicture">
<img src="http://v5.home3d.cn/home/<?=$home1['imageurl']?>" alt="" id="pic0" />
</div> <!-- wrapperPicture -->  
<div class="titlePic bgTranslucent">
<span class="titleText cWhite"><?=$home1['subject']?></span>
<div class="dots fr">
<img src="./template/9/img/dot_white.png" alt="" id="dot0" />
<img src="./template/9/img/dot_gray.png" alt="" id="dot1" />
<img src="./template/9/img/dot_gray.png" alt="" id="dot2" />
<img src="./template/9/img/dot_gray.png" alt="" id="dot3" />
<img src="./template/9/img/dot_gray.png" alt="" id="dot4" />
</div> <!-- dots --> 
</div> <!-- titlePic --> 

<table class="itemList">
<!--注意各个tr标签的id都与相关的页面跳转联系起来--> 
<?php if(is_array($zhongwei)) { foreach($zhongwei as $value) { ?>
<tr class="itemList-item" id="<?=$value['english']?>">
             <?php if($bac['moblieclicknum']=='1'||$bac['moblieclicknum']=='0') { ?>
<td class="iconTd"><img src="http://v5.home3d.cn/home/wx/template/img/<?=$value['icon']?>" alt="" /></td>	
              <?php } else { ?>
              <td class="iconTd"><img src="http://v5.home3d.cn/home/wx/template/<?=$bac['moblieclicknum']?>/img/<?=$value['icon']?>" alt="" /></td>
              <?php } ?>
<td class="textTd"><span class="itemTitle"><?=$value['subject']?></span></td>
<td class="arrowTd"><img src="./template/9/img/arrow_down.png" alt="" /></td>
</tr>		
<?php } } ?>
<?php if($zhongwei1) { ?>
        <?php if(is_array($zhongwei1)) { foreach($zhongwei1 as $value1) { ?>
       <tr class="itemList-item" id="<?=$value1['english']?>">
             <?php if($bac['moblieclicknum']=='1'||$bac['moblieclicknum']=='0') { ?>
<td class="iconTd"><img src="http://v5.home3d.cn/home/wx/template/img/<?=$value1['icon']?>" alt="" /></td>	
              <?php } else { ?>
              <td class="iconTd"><img src="http://v5.home3d.cn/home/wx/template/<?=$bac['moblieclicknum']?>/img/<?=$value1['icon']?>" alt="" /></td>
              <?php } ?>
<td class="textTd"><span class="itemTitle"><?=$value1['subject']?></span></td>
<td class="arrowTd"><img src="./template/9/img/arrow_down.png" alt="" /></td>
</tr>	
        <?php } } ?>
<?php } ?>


</table>
</body>
</html>
<?php ob_out();?>