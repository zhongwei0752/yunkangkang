<?php if(!defined('IN_UCHOME')) exit('Access Denied');?><?php subtplcheck('./wx/template/bookcontent', '1396422588', './wx/template/bookcontent');?><!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no"  />
    <meta content="telephone=no" name="format-detection" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

    <link rel="stylesheet" href="template/css/yunkangbase.css">
    <link rel="stylesheet" href="template/css/yunkangmain.css">

    <script src="template/js/jquery-1.9.1.min.js"></script>
    <script src="template/js/jquery-v2.0.2.js"></script>

    <script src="template/js/scrollbox.js"></script>

    <script src="template/js/jquery-1.9.1.min.js"></script>
    <script src="template/js/mobiscroll.custom-2.5.4.min.js"></script>
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
                    <div class="rightpic"><img src="img/logo.png"></div>
                    <div class="clear"></div>
                 </div>
                 <div class="listcontentbody">
                     <div class="listtil"><?=$bookingvalue['subject']?></div>
                     <div class="listcon">
                         <div class="l1">
                             <span class="l1_s1">接种地点：</span>
                             <span class="l1_s2"><?=$bookingvalue['location']?></span>
                         </div>
                         <div class="l1">
                             <span class="l1_s1">接种时间：</span>
                             <span class="l1_s2">3月25日 早上9:30-11:30</span>
                         </div>
                         <div class="l1">
                             <span class="l1_s1">接种名额：</span>
                             <span class="l1_s2"><?=$bookingvalue['people']?></span>
                         </div>
                         <form action="wx.php?do=upload" method="POST">
                         <div class="l1">
                             <span class="l1_s1">预&nbsp;&nbsp;约&nbsp;&nbsp;人：</span>
                             <span class="l1_s2"><input type="text" name="username" value="<?=$joinvalue['username']?>" placeholder="请输入名字"></span>
                         </div>
                         <div class="l1">
                             <span class="l1_s1">联系电话：</span>
                             <span class="l1_s2"><input type="text" name="telnumber" value="<?=$joinvalue['telnumber']?>" placeholder="请输入号码"></span>
                         </div>
                     </div>
                 </div>
                 <br>
             </div>
             <div class="listdownpic"></div>
        </div>
        <?php if($joinvalue) { ?>
         <div class="btnbox" id="reserve">
             <span>你已成功预约</span>
         </div>
         <?php } else { ?>
         <div class="btnbox" id="reserve">
             <input type="submit" name="reserve" value="确定预约"/>
         </div>
         <?php } ?>
         <input type="hidden" name="id" value="<?=$_GET['id']?>"/>
         <input type="hidden" name="uid" value="<?=$_GET['uid']?>">
         <input type="hidden" name="submitcheck" value="true"/>
         </form>
     </div>

<!-- <script>
function uploadreserve(username,telnumber)
{
if(username==""||telnumber=="")
{
alert("姓名或电话号码不能为空");

}else
{
$.ajax({

                type: "POST",
                url: "wx.php?do=upload",
                data: "username="+username+"&telnumber="+telnumber+"&explain=1",//提交表单，相当于CheckCorpID.ashx?ID=XXX
                async: true,
                
                success: function (data) {
                 alert("预约成功");
                }
              });
               
}
}

</script> -->
</body>
</html>
<?php ob_out();?>