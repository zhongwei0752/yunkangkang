<?php
session_start();
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
        .select_box{border: 0px;}
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
	$query=$_SGLOBAL['db']->query("SELECT DISTINCT uid,name,phone,other FROM ".tname('reservationorderlist')." ORDER BY uid ASC");
	while($value=$_SGLOBAL['db']->fetch_array($query))
	{
		$str='<a   rel="external" class="news_link">
				<table>
					<tr>
						<td class="news_info">
							<span class="other_span"><font color="#42B8B1;">姓名：</font><font color="red">'.$value['name'].'    </font></span>
							<span class="other_span"><font color="#42B8B1;">电话：</font><font color="red">'.$value['phone'].'    </font></span>
							<span class="other_span"><font color="#42B8B1;">地址：</font><font color="red">'.$value['other'].'    </font></span><br/>
						</td>
					</tr>';
		echo $str;
		$uid=$value['uid'];
		$query1=$_SGLOBAL['db']->query("SELECT * FROM ".tname('reservationorderlist')." WHERE uid='$uid'");
		while($value1=$_SGLOBAL['db']->fetch_array($query1))
		{
			$query2=$_SGLOAL['db']->query("SELECT * FROM ".tname('reservation')." WHERE reservationid='$value1[reservationid]'");
			$value2=$_SGLOBAL['db']->fetch_array($query2);
			$str1='	<tr>
					<td class="news_info">
							<span class="other_span"><font color="#42B8B1;">菜肴名称：</font><font color="red">'.$value2['subject'].'    </font></span>
							<span class="other_span"><font color="#42B8B1;">数量：</font><font color="red">'.$value1['num'].'    </font></span><br/>
					</td>
					</tr>
					</table>
			    </a>';
			echo $str1;
		}
	}
?>
 </div>
 </div>
</body>
</html>
<script type="text/javascript" >
  //订餐
  function send_form(){
    $.get(
      './ajax/Reservation.php', 
       { "wxkey":"<?php echo $wxkey ;?>" ,'type':'reservationorder2' , "order_uid":<?php echo $order_uid ;?> , "code":<?php echo $code ;?>} ,
       function(data) {
        if(data.success==1){
          alert('订单已经通过');
        }else{
          alert('订单未能通过');
        }
      },
      'json'
    );
  }
</script>