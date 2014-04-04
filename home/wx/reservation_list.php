<?php
include_once('common_inc.php');
$uid = $_GET['uid'] ? $_GET['uid'] : 0;


?>
<!DOCTYPE html>
<html>
  <head>
     <title>菜肴列表</title>
     <meta charset="utf-8">
     <meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0"/>
     <link rel="stylesheet" type="text/css" href="./template/css/vincent_reset.css">
     <link rel="stylesheet" type="text/css" href="./template/css/style0.css">
	 <link rel = "stylesheet" type = "text/css" href = "./template/css/main.css">
     <link rel="stylesheet" href="./template/css/base.css" />
	 <link rel="stylesheet" href="./template/css/expressInfo.css" />
	<!--{if $bac['moblieclicknum']=='1'||$bac['moblieclicknum']=='0'}-->
	<link rel = "stylesheet" type = "text/css" href = "template/css/main.css">
	<link rel="stylesheet" href="template/css/mobiscroll.custom-2.5.4.min.css">
	<!--{else}-->
	<link rel = "stylesheet" type = "text/css" href = "template/$bac['moblieclicknum']/css/main.css">
	<link rel="stylesheet" href="template/$bac['moblieclicknum']/css/mobiscroll.custom-2.5.4.min.css">
	<!--{/if}-->
     <script src="./ajax/jquery.js"></script>
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
            width: 60px;
            height: 30px;
            font-size: 14px;
            text-decoration: none;
            text-align: center;
            line-height: 28px;
            color: white;
            margin-top: 10px;
        }
        </style>
  </head>
<body>
	<div class = "navigation">
		<span>点餐</span>
		<a href = "#" id = "show" class = "menu_btn"><img src = "./template/img/menu_btn.png" id = "show" /></a>
	</div>
 <div class="wrapper">
      <div class="main_menu" style="margin-top:64px;">
	  <?php
		$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('reservation')."  where uid='$uid' ORDER BY dateline DESC ");
		while ($value = $_SGLOBAL['db']->fetch_array($query)) {
				$query2 = $_SGLOBAL['db']->query("select * from ".tname('reservationfield')." where reservationid='$value[reservationid]'");
				$value2 = $_SGLOBAL['db']->fetch_array($query2);
				$value0['imageurl'] = $value['imageurl'];
				$value0['subject']=$value['subject'];
				$value0['message']=$value2['message'];
				$value0['id']=$value2['reservationid'];
				$list[]=$value0;
				$s='<a   rel="external" class="news_link" href="reservation_detail.php?reservationid='.$value2['reservationid'].'">
				  <table>
					<tr>
					  <td class="news_pic">
						  <img src="../'.$value['imageurl'].'" alt="">
					  </td>
					  <td class="news_info">
						  <span class="main_span">'.$value['subject'].'</span><br>
						  <span class="other_span">'.$value2['message'].'</span>
					  </td>
					  <td>
						  <a href="javascript:order('.$value2['reservationid'].')" title="" class="apply_btn3" style="">点餐</a>
					  </td>
					</tr>
				  </table>
				</a>';
				echo $s;
				
		}
				
	  ?>
	  </div>
	  <a style="float:right;" id="reservationbuy">管理员点击查看订单</a>
      <a href="reservationorder_list.php" class="more" style="margin-top:30px;">去提交订单</a>
	   <div class="expressInfo1">
        <div class="formContainer1 bc tc" style="margin-top:64px;">
        <form method="post" action="./ajax/Reservation.php">
            <h1 id="formTitle">密码确认</h1>
            <input type="text" placeholder="密码" name="reservationpassword"  class="inputContainer" />
            <br />

            <input type="submit" class="buttonSubmit" value="提交">
            <input type="hidden" id="uid" name="uid" value="$_COOKIE['uchome_viewuid']"/>
            <input type="hidden" name="reservationsubmit" value="1">
        </form> 
        </div> <!-- formContainer -->
    </div> <!-- expressInfo --> 
 </div>
 
    
</html>
<script type="text/javascript" >
  //菜肴列表
  getServiceList();
  function getServiceList(){
    $.get(
      './ajax/ReservationList.php',
      {"wxkey" : "<?php echo $wxkey; ?>" ,"type" :"menu" , 'uid' : <?php echo $_COOKIE[uchome_viewuid]; ?> } ,
       function(data) {
        strJosn = eval(data);
        if(strJosn !=null){
          for(var i=0; i<strJosn.length; i++)
          {
            $('.main_menu').append(strJosn[i]);
          }
        }else{
          $('.more').html('没有更多了');
        }
   
      }
    );
  };
  //订餐
  function order(reservationid){
    var num = 1 ;
    $.get(
      './ajax/Reservation.php', 
       { "reservationid":reservationid ,  "uid":"<?php echo $_COOKIE[uchome_viewuid] ;?>" ,'type':'reservation' ,'num': num} ,
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

<script type="text/javascript">
		$(document).ready(function(){
			$("#buttonBuy").click(function(){
				$(".expressInfo").fadeIn();
				});

			//点击表格外的地方时消失
			$(".expressInfo").click(function(){
				$(".expressInfo").fadeOut();
				});

			//阻止事件冒泡
			$(".formContainer").click(function(event){
				event.stopPropagation();
				});

			$("#reservationbuy").click(function(){
                $(".expressInfo1").fadeIn();
                });

            //点击表格外的地方时消失
            $(".expressInfo1").click(function(){
                $(".expressInfo1").fadeOut();
                });
            
            $("#buttonSubmit").click(function(){
                $(".expressInfo").fadeOut();
                });
            //阻止事件冒泡
            $(".formContainer1").click(function(event){
                event.stopPropagation();
                });

            });
            
	</script>