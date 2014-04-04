<?php
include_once('./common_inc.php');
$reservationid = $_GET['reservationid'] ? $_GET['reservationid'] : 0;
$uid=$_COOKIE[uchome_viewuid];
if ($reservationid) {
  $sql = "select * from ".tname('reservation')." where reservationid='$reservationid' ";
  $query = $_SGLOBAL['db']->query($sql);
  $value = $_SGLOBAL['db']->fetch_array($query);
  $subject = $value['subject'];
  $message = $value['message'];
  $uid=$value['uid'];
  $price = $value['price'] ? $value['price'] : '(暂缺)';
  $userprice = $value['userprice'] ? $value['userprice'] : '(暂缺)';
  $dateline = $value['dateline'];
  $time = date("Y" , $dateline).'年'.date("m" , $dateline ).'月'.date("d" , $dateline).'日'.date("H" , $dateline).'时'.date("i" , $dateline).'分';
  $suid = $value['suid'];
  $pic = $value['ftpurl'].$value['pic'];
  $sql = "select * from ".tname('reservationfield')." where reservationid='$reservationid' ";
  $query = $_SGLOBAL['db']->query($sql);
  $value = $_SGLOBAL['db']->fetch_array($query);
  $message = $value['message'];
  $copyfrom = $value['copyfrom'];
  $intro=$value['intro'];

}
require('./common_header.php'); 
?>
	 	<!--{if $bac['moblieclicknum']=='1'||$bac['moblieclicknum']=='0'}-->
	<link rel = "stylesheet" type = "text/css" href = "template/css/main.css">
	<link rel="stylesheet" href="template/css/mobiscroll.custom-2.5.4.min.css">
	<!--{else}-->
	<link rel = "stylesheet" type = "text/css" href = "template/$bac['moblieclicknum']/css/main.css">
	<link rel="stylesheet" href="template/$bac['moblieclicknum']/css/mobiscroll.custom-2.5.4.min.css">
	<!--{/if}-->
<div class = "navigation">
		<span>点餐</span>
		<a href = "#" id = "show" class = "menu_btn"><img src = "./template/img/menu_btn.png" id = "show" /></a>
	</div>
 <div class="wrapper">
      <div class="main_menu" >
        <div style="margin-left:10px;">
        <div class="detail_list">
         <h4 class="detail_list_name">菜名</h4>
         <p class="detail_text"><?php echo $subject; ?></p>
      </div>
        <div class="detail_list">
         <h4 class="detail_list_name">简介</h4>
         <?php  if($copyfrom){ ?><p class="detail_text">主厨：<?php echo $copyfrom; ?></p><?php  } ?>
         <p class="detail_text"><?php echo $intro; ?></p>
      </div>
      <div class="detail_list">
        <h4 class="detail_list_name">价格</h4>
        <p class="detail_text">市场价：<font color="#42B8B1"><?php echo $price; ?></font>元</p>
        <p class="detail_text">会员价：<font color="red"><?php echo $userprice; ?></font>元</p>
      </div>

        <div class="detail_list">
         <h4 class="detail_list_name">详情：</h4>
         <p class="detail_text"><?php echo $message; ?></p>
      </div>

      <div class="detail_list" style="height:60px;">
         <a href="javascript:order()" title="" class="apply_btn2" style="">点餐</a><div style="float:left;margin-top: -30px;margin-left: 100px;">点餐数量：<input size="2" type="text" name='num' value='1' id="num" style="background-color:#42B8B1;">份</div>
         <div class="clear"></div>
      </div>
      <a href="wx.php?do=feed&idtype=reservation&uid=<?php echo $uid; ?>" class="more" style="margin-top:30px;">返回</a>
    </div>
	</div>
	</div>
    
  </body>
</html>
 <script src="./template/js/jquery0.js"></script>
 <script type="text/javascript" >

  //订餐
  function order(){
    var num = $("#num").val();
    $.get(
      './ajax/Reservation.php', 
       { "reservationid":"<?php echo $reservationid ;?>" ,  "wxkey":"<?php echo $wxkey ;?>" ,"uid":"<?php echo $uid;?>",'type':'reservation' ,'num': num} ,
       function(data) {
        if(data.success==1){
          alert('订餐成功！');
        }else{
          alert('订餐失败！');
        }
      },
      'json'
    );
  }

  </script>