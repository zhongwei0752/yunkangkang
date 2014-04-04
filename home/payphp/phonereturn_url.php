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
require_once("phonealipay.config.php");
require_once("lib/alipay_notify.class.php");

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
    $a=explode(",",$out_trade_no);
    $b=$a['0'];
    $c=$a['1'];
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
                $sql="update uchome_goodscod set moneystatus='1'  where dateline = '$b'";
                mysql_query($sql,$conn);
                /*require_once("../wx/wx_common.php");
                require_once("../wx/Weixin.class.php");
                $sql="select * from uchome_space where uid = '1'";
                $value=mysql_query($sql,$conn);
                $sql1="select * from uchome_space where uid = '1175'";
                $value1=mysql_query($sql1,$conn);
                $fakeid=$value1['fakeid'];
                if($fakeid){
                $url="http://v5.home3d.cn/home/wx/wx.php?do=booking&uid=$c&dateline=$b";
                $message="亲，你有新的订单，<a href='$url'>点我瞬间查看</a>";
                $d = get_obj_by_xiaoquid('1');
                $info = $d->sendWXSingleMsg($fakeid,$message);
                }*/
    /*$conn = mysql_connect('58.215.187.8','zhongwei','623610577');
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
		*/
		
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
       
<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no"  />
    <meta content="telephone=no" name="format-detection" />
    <meta charset="UTF-8" />


    <title>付款成功</title>
    <style type="text/css">
        *
        {
            margin: 0;  padding: 0; border: 0;
            font-family: 'Microsoft yahei' !important;
            -webkit-tap-highlight-color: rgba(0, 0, 0 ,0);
        }
        img
        {
            max-width: 100%;
            height: auto !important;
        }
        input{ border: 0; border-radius: 0 !important; -webkit-appearance: none;}
        textarea{ -webkit-appearance: none; border-radius: 0 !important; }
        a
        {
            text-decoration: none;
        }
        li
        {
            list-style: none;
        }

        body,html
        {
            margin: 0;
            padding: 0;
            width: 100%;
        }
        body
        {
            background-color: #F0F0F0;
        }
    </style>

</head>
<body>
      <div style="background-color: #F0F0F0;">
          <div style=" width: 96%;margin-left: 2%;text-align: center;margin-top: 10px;">
             <p>
                恭喜你，你已经付款成功！
             </p>
              <br>
          </div>
      </div>
      <input type="hidden" id="dateline" name="dateline" value="<?php echo $b ?>"/>
      <input type="hidden" id="uid" name="uid" value="<?php echo $c ?>"/>
       
</body>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js" type="text/javascript"></script>
<script>
 $(document).ready(function () {
          $.ajax({
                 type: "POST",
                 url: "http://v5.home3d.cn/home/wx/wx.php?do=upload",
                 data: "uid="+$('#uid').val()+"&dateline="+$('#dateline').val()+"&pull=1",//提交表单，相当于CheckCorpID.ashx?ID=XXX
                  async: true,                    
                    success: function (data) {
                    },  //操作成功后的操作！msg是后台传过来的值
                });
             });  
  </script>
</html>
