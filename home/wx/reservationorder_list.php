<?php
include_once('common_inc.php');
?>
<!DOCTYPE html>
<html>
  <head>
     <title>        <?php echo $web_title ? $web_title : $xiaoquname; ?></title>
     <meta charset="utf-8">
     <meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0"/>
     <link rel="stylesheet" type="text/css" href="./template/css/vincent_reset.css">
     <link rel="stylesheet" type="text/css" href="./template/css/style0.css">
	 	<!--{if $bac['moblieclicknum']=='1'||$bac['moblieclicknum']=='0'}-->
	<link rel = "stylesheet" type = "text/css" href = "template/css/main.css">
	<link rel="stylesheet" href="template/css/mobiscroll.custom-2.5.4.min.css">
	<!--{else}-->
	<link rel = "stylesheet" type = "text/css" href = "template/$bac['moblieclicknum']/css/main.css">
	<link rel="stylesheet" href="template/$bac['moblieclicknum']/css/mobiscroll.custom-2.5.4.min.css">
	<!--{/if}-->
     <script src="./template/js/jquery0.js"></script>
      <script type="text/javascript" charset="utf-8">
               $(document).ready(function(){
                  var length=$(".loupan_name").text().length;
                  if(length>5){
                    $(".loupan_name").attr("style","font-size:22px");
                  }
               })
      </script>
        <style type="text/css">
        .apply_btn3{
            border-radius: 3px;
            display: block;
            background: #7AD0CD;
            width: 30px;
            height: 20px;
            font-size: 12px;
            text-decoration: none;
            text-align: center;
            line-height: 20px;
            color: white;
            margin-top: 10px;
            float: right;
            margin-right: 20px;
        }
        </style>
  </head>
<body>
<div class = "navigation">
		<span>点餐</span>
		<a href = "#" id = "show" class = "menu_btn"><img src = "./template/img/menu_btn.png" id = "show" /></a>
	</div>
 <div class="wrapper">
      <div class="main_menu"  style="margin-top:64px;">
<?php
  $uid = $_COOKIE[uchome_viewuid];
  $sql = "select * from ".tname('reservationorder')." where uid='$uid' and num > 0 ORDER BY reservationid ASC ";
  $query = $_SGLOBAL['db']->query($sql);
  while ( $value = $_SGLOBAL['db']->fetch_array($query) ) {
      $reservationid = $value['reservationid'];
      $num = $value['num'];
      $sql = "select * from ".tname('reservation')." where reservationid='$reservationid'  ";
      $query2 = $_SGLOBAL['db']->query($sql);
      $value2 = $_SGLOBAL['db']->fetch_array($query2);
      $pic = $value2['imageurl'];
      $str='<a   rel="external" class="news_link">
                <table>
                  <tr>
                    <td class="news_pic">
                        <img src="../'.$pic.'" alt="菜肴图片" >
                    </td>
                    <td class="news_info">
                        <span class="main_span">'.$value2['subject'].'</span><br>
                        <span class="other_span">数量：'.$num.'</span>
                    </td>
                    <td>
						<form method="post" action="./ajax/Reservation.php" >
							<input type="hidden" class="id" name="id" value="'.$value2['reservationid'].'" />
							<input type="hidden" class="uid" name="uid" value="'.$_COOKIE[uchome_viewuid].'" />
							<input type="hidden" class="del" name="delsubmit" value="1" />
							<input  class="delete" style="background-color:#42B8B1;color:white;" type="submit" value="删除" />
						</form>
                    </td>
                  </tr>
                </table>
           </a>';
		   echo $str;
      }
?>
         <div id="" class="select_box">
                 <input type="text" class="id_input"  placeholder="姓名" name="name" id="name" >
         </div><!-- / -->
         <div id="" class="select_box">
                  <input type="text" class="id_input"  placeholder="电话" name="phone" id="phone">
         </div><!-- / -->
         <div id="" class="select_box">
                  <input type="text" class="id_input"  placeholder="地址" name="other" id="other">
         </div><!-- / -->
         <a href="javascript:send_form()" class="more" style="margin-top:30px;">提交</a>
         <a href="wx.php?do=feed&idtype=reservation&uid=<?php echo 1; ?>" class="more" style="margin-top:30px;">返回</a>
 </div>
</body>
</html>
<script type="text/javascript" >
  //订餐
  function send_form(){
    var name = $("#name").val();
    var phone = $("#phone").val();
    var other = $("#other").val();
	if(phone.length!=11)
	{
		alert("手机号码长度不对！");
	}
	else{
		if(name==""||other=="")
		{
			alert("信息中存在空值！");
		}
		else{
			$.get(
			  './ajax/Reservation.php', 
			   { "name":name ,  "phone":phone , "other":other ,  "uid":"<?php echo $_COOKIE[uchome_viewuid];?>" ,'type':'reservationorder'} ,
			   function(data) {
				if(data.success==1){
				  alert('提交订单成功');
				  window.location.href=document.referrer;
				}else{
				  alert('提交订单失败');
				}
			  },
			  'json'
			);
		}
	}
  }
  

</script>





<script type="text/javascript" >
  
 function delete()
  {
	var reservationid=$("#id").val();
	$.get(
			  './ajax/Reservation.php', 
			   { "id":reservationid , "uid":"<?php echo $_COOKIE[uchome_viewuid];?>" ,'type':'reservationdelete'} ,
			   function(data) {
				if(data.success==1){
				  alert('删除成功');
				   history.go(0);
				}else{
				  alert('删除失败');
				}
			  },
			  'json'
			);
  }
  </script>