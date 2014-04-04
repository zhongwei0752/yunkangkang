<?php
/* * 
 * 功能：支付宝页面跳转同步通知页面
 * 版本：3.3
 * 日期：2012-07-23
 * 说明：
 * 以下代码只是为了方便商户测试而提供的样例代码，商户可以根据自己网站的需要，按照技术文档编写,并非一定要使用该代码。
 * 该代码仅供学习和研究支付宝接口使用，只是提供一个参考。

 *************************页面功能说明*************************
 * 该页面可在本机电脑测试
 * 可放入HTML等美化页面的代码、商户业务逻辑程序代码
 * 该页面可以使用PHP开发工具调试，也可以使用写文本函数logResult，该函数已被默认关闭，见alipay_notify_class.php中的函数verifyReturn
 */
require_once("alipay.config.php");
require_once("lib/alipay_notify.class.php");
?>
<!DOCTYPE HTML>
<html>
    <head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<?php
//计算得出通知验证结果
$alipayNotify = new AlipayNotify($alipay_config);
$verify_result = $alipayNotify->verifyReturn();
if($verify_result) {//验证成功
	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//请在这里加上商户的业务逻辑程序代码
	
	//——请根据您的业务逻辑来编写程序（以下代码仅作参考）——
    //获取支付宝的通知返回参数，可参考技术文档中页面跳转同步通知参数列表

	//商户订单号

	$out_trade_no = $_GET['out_trade_no'];
	$a=explode(".",$out_trade_no);
	$b=$a['1'];
	//支付宝交易号

	$trade_no = $_GET['trade_no'];

	//交易状态
	$trade_status = $_GET['trade_status'];


    if($_GET['trade_status'] == 'TRADE_FINISHED' || $_GET['trade_status'] == 'TRADE_SUCCESS') {
		//判断该笔订单是否在商户网站中已经做过处理
			//如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
			//如果有做过处理，不执行商户的业务程序
    $conn = mysql_connect('58.215.187.8','zhongwei','623610577');
        mysql_select_db('zhongwei', $conn);
        $sql1="select * from uchome_space where uid = $b";
        $value=mysql_query($sql1,$conn);
        while($row = mysql_fetch_array($value)){
        $moblieclicknum=$row['mobliestatus'];
        $sql="update uchome_space set moblieclicknum='$moblieclicknum'  where uid = $b";
        mysql_query($sql,$conn);
        $sql1="INSERT INTO uchome_mobliechoice(moblieid,uid) VALUES ($moblieclicknum,$b)"; 
        mysql_query($sql1,$conn);
        $sql2="update uchome_space set mobliestatus='0'  where uid = $b";
        mysql_query($sql2,$conn);
      }
		
		
    	//updatetable("appset", array('appstatus'=>'1'),array('uid'=>$uid));
		
    }
    else {
      echo "trade_status=".$_GET['trade_status'];
    }
		
	

	//——请根据您的业务逻辑来编写程序（以上代码仅作参考）——
	
	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}else {
    //验证失败
    //如要调试，请看alipay_notify.php页面的verifyReturn函数
}

?>
        <title>支付成功</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">
    <!-- Bootstrap -->
   <!--  <link href="css/bootstrap.min.css" rel="stylesheet" media="screen"> -->
    <link rel="stylesheet" type="text/css" href="../template/default/jquery-mobile-fluid960.min.css">
    <link rel="stylesheet" type="text/css" href="../template/default/style1.css">
    <link rel="stylesheet" type="text/css" href="../template/default/file_beauty.css">
    <style type="text/css">
       h3{color: #727272;margin-top: 20px;font-weight:normal;}
    </style>
  </head>

  <body>

    <div class="wrapper">
      <div class="navbar">
            <div class="navbar-inner container_36">
                <a class="logo grid_1" href="#" style="background:none;"><img src="../template/default/image/logo.png"></a>
                <a href="#" class="grid_5" style="float:right;color:#BDBEBF;padding-right:10px;">帮助</a>
             </div>
         </div>
         <!-- navbar end -->
          <div class="content_wrapper" style="margin-left:auto;margin-right:auto;text-align:center;">
             <img src="../template/default/image/guide_all_complete.png" style="margin:20px auto;">
             <div style="width:750px;height:200px;border:1px solid #D9D9DA;background:#fff;margin:20px auto;color:#999999;padding-top:70px;">
                 <img src="../template/default/image/submit_success.png" style="vertical-align:-14px;"><span style="font-size:20px;color:#48B0BA;line-height:40px;"><?php if($_GET['trade_status'] == 'TRADE_FINISHED' || $_GET['trade_status'] == 'TRADE_SUCCESS'){echo"手机模版选择成功";}else{echo"手机模版选择失败";} ?></span>
                 <p><a href="../space.php?do=home" style="color:#999999">点击马上进入>></a><span id="seconds" style="color:red">5</span>秒</p>
                
             </div>
              
          </div><!-- content_wrapper end -->
    </div><!-- wrraper end -->
    <div class="footer">
        <div class="footer_map container_12">
           <ul class="grid_3">
                <li class="map_title"><img src="../template/default/image/ff.png">使用帮助:</li>
                <li><a href="">开通流程</a></li>
                <li><a href="">管理员手册</a></li>
                <li><a href="">用户手册</a></li>
           </ul>

            <ul class="grid_3">
                <li class="map_title"><img src="../template/default/image/ff.png">投诉与建议:</li>
                <li><a href="">在线客服</a></li>
                <li><a href="">留言板</a></li>
           </ul>

            <ul class="grid_3">
                <li class="map_title"><img src="../template/default/image/ff.png"><span>合作:</span></li>
                <li><a href="">品牌企业合作</a></li>
                <li><a href="">媒体合作</a></li>
                <li><a href="">收费细节</a></li>
           </ul>

            <ul class="grid_3">
                <li class="map_title"><img src="../template/default/image/ff.png">关于我们:</li>
                <li><a href="">企业介绍</a></li>
                <li><a href="">联系方式</a></li>
                <li><a href="">人才招聘</a></li>
           </ul>
          
        </div><!-- map end -->
        <div class="footer_info">
             版权所有：广州市宏门网络科技有限公司&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ICP:&nbsp;&nbsp; 粤AXXXXXXXXXXXXX
        </div>
    </div>


    <script language="javascript" type="">
        function countDown(secs){
       document.getElementById('seconds').innerText=secs;
         if(--secs>0){
              setTimeout("countDown("+secs+")",1000);
            }else{
                location.href="../space.php?do=home"
            }
            }

       countDown(5);
</script>

    <!--<script src="js/bootstrap.min.js"></script>-->
  </body>
</html>


