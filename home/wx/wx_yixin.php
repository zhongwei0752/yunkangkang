<?php
/**
  * wechat php test
  */

//define your token
define("TOKEN", "weixin");
$wechatObj = new wechatCallbackapiTest();
if($_GET["echostr"]){
$wechatObj->valid();
}else{
$wechatObj->responseMsg();
}

class wechatCallbackapiTest
{
	public function valid()
    {
        $echoStr = $_GET["echostr"];

        //valid signature , option
        if($this->checkSignature()){
        	echo $echoStr;
        	exit;
        }
    }

    public function responseMsg()
    {
		//get post data, May be due to the different environments
		$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];

      	//extract post data
		if (!empty($postStr)){
                
              	$postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
                $fromUsername = $postObj->FromUserName;
                $toUsername = $postObj->ToUserName;
                $keyword = trim($postObj->Content);
                $time = time();
                $dbname = "zhongwei";
                $host = "58.215.187.8";
                $user = "zhongwei";
                $pass = "623610577";
                $textTpl = "<xml>
							<ToUserName><![CDATA[%s]]></ToUserName>
							<FromUserName><![CDATA[%s]]></FromUserName>
							<CreateTime>%s</CreateTime>
							<MsgType><![CDATA[%s]]></MsgType>
							<Content><![CDATA[%s]]></Content>
							<FuncFlag>0</FuncFlag>
							</xml>";             
				if(!empty( $keyword ))
                {   
                     $con = mysql_connect("$host","$user","$pass");
                              if (!$con)
                                {
                                die('Could not connect: ' . mysql_error());
                                }
                              mysql_select_db("$dbname", $con);
                              $result = mysql_query("SELECT s.*,sf.* FROM uchome_space s LEFT JOIN uchome_spacefield sf ON s.uid=sf.uid  WHERE s.wxkey='".$toUsername."' ");
                              mysql_query("SET NAMES 'utf8'");
          if($row = mysql_fetch_array($result)){
                      $msgType = "news";
                      if($row[name]){
                        $name=$row[name];
                      }else{
                        $name=$row[username];
                      }
                      $appurl = "http://v5.home3d.cn/home/capi/space.php?do=app&uid=$row[uid]";
                      $app = file_get_contents($appurl,0,null,null);
                      $app_output = json_decode($app);
                      $count=$app_output->data->count;
              		  $zhong2 = mysql_query("SELECT * FROM uchome_weixinmenutop  WHERE uid='$row[uid]' and type='image'");
                      $wei2 = mysql_fetch_array($zhong2);
                      if($wei2){
                      $name=$wei2[name];
                      if($wei2['recommendlink']){
                      $url = "$wei2[recommendlink]"; 
                      }else{
                      $url = "http://v5.home3d.cn/home/wx/wx.php?do=home&uid=".$row[uid];
                    }
                      $pic = "http://v5.home3d.cn/home/".$wei2[imageurl];
                      $articles[] = makeArticleItem($name, $name, $pic, $url);
                      $result1 = mysql_query("SELECT * FROM uchome_weixinmenutop  WHERE uid='$row[uid]' and type='frist' ");
                      $result2 = mysql_query("SELECT * FROM uchome_weixinmenutop  WHERE uid='$row[uid]' and type='second' ");
                      mysql_query("SET NAMES 'utf8'");
                            if($weixin = mysql_fetch_array($result1)){
                              $wei=explode(".",$weixin['number']);
                              $url1 = "http://v5.home3d.cn/home/capi/space.php?do=$wei[0]&uid=$row[uid]&id=$wei[1]";
                              $app = file_get_contents($url1,0,null,null);
                              $app_output = json_decode($app);
                              $url = "http://v5.home3d.cn/home/wx/wx.php?do=detail&id=".$wei[1]."&wxkey=".$fromUsername."&uid=$row[uid]&idtype=".$wei[0]."id&type=".$wei[0]."&moblieclicknum=$row[moblieclicknum]";
                               if($wei[0]=="introduce"){
                              $subject=$app_output->data->introduce->subject;
                              $pic = "http://v5.home3d.cn/home/".$app_output->data->introduce->image1url;
                            }elseif($wei[0]=="product"){
                              $subject=$app_output->data->product->subject;
                              $pic = "http://v5.home3d.cn/home/".$app_output->data->product->image1url;
                            }elseif($wei[0]=="industry"){
                              $subject=$app_output->data->industry->subject;
                              $pic = "http://v5.home3d.cn/home/".$app_output->data->industry->image1url;
                            }elseif($wei[0]=="cases"){
                              $subject=$app_output->data->cases->subject;
                              $pic = "http://v5.home3d.cn/home/".$app_output->data->cases->image1url;
                            }elseif($wei[0]=="job"){
                              $subject=$app_output->data->job->subject;
                              $pic = "http://v5.home3d.cn/home/".$app_output->data->job->image1url;
                            }elseif($wei[0]=="development"){
                              $subject=$app_output->data->development->subject;
                              $pic = "http://v5.home3d.cn/home/".$app_output->data->development->image1url;
                            }elseif($wei[0]=="branch"){
                              $subject=$app_output->data->branch->subject;
                              $pic = "http://v5.home3d.cn/home/".$app_output->data->branch->image1url;
                            }elseif($wei[0]=="goods"){
                              $subject=$app_output->data->goods->subject;
                              $pic = "http://v5.home3d.cn/home/".$app_output->data->goods->image1url;
                            }
                              $articles[] = makeArticleItem($subject, $subject, $pic, $url); 
                            }
                          
                            if($weixin = mysql_fetch_array($result2)){
                              $wei=explode(".",$weixin['number']);
                              $url1 = "http://v5.home3d.cn/home/capi/space.php?do=$wei[0]&uid=$row[uid]&id=$wei[1]";
                              $app = file_get_contents($url1,0,null,null);
                              $app_output = json_decode($app);
                              $url = "http://v5.home3d.cn/home/wx/wx.php?do=detail&wxkey=".$fromUsername."&id=".$wei[1]."&uid=$row[uid]&idtype=".$wei[0]."id&type=".$wei[0]."&moblieclicknum=$row[moblieclicknum]";
                               if($wei[0]=="introduce"){
                              $subject=$app_output->data->introduce->subject;
                              $pic = "http://v5.home3d.cn/home/".$app_output->data->introduce->image1url;
                            }elseif($wei[0]=="product"){
                              $subject=$app_output->data->product->subject;
                              $pic = "http://v5.home3d.cn/home/".$app_output->data->product->image1url;
                            }elseif($wei[0]=="industry"){
                              $subject=$app_output->data->industry->subject;
                              $pic = "http://v5.home3d.cn/home/".$app_output->data->industry->image1url;
                            }elseif($wei[0]=="cases"){
                              $subject=$app_output->data->cases->subject;
                              $pic = "http://v5.home3d.cn/home/".$app_output->data->cases->image1url;
                            }elseif($wei[0]=="job"){
                              $subject=$app_output->data->job->subject;
                              $pic = "http://v5.home3d.cn/home/".$app_output->data->job->image1url;
                            }elseif($wei[0]=="development"){
                              $subject=$app_output->data->development->subject;
                              $pic = "http://v5.home3d.cn/home/".$app_output->data->development->image1url;
                            }elseif($wei[0]=="branch"){
                              $subject=$app_output->data->branch->subject;
                              $pic = "http://v5.home3d.cn/home/".$app_output->data->branch->image1url;
                            }elseif($wei[0]=="goods"){
                              $subject=$app_output->data->goods->subject;
                              $pic = "http://v5.home3d.cn/home/".$app_output->data->goods->image1url;
                            }
                              $articles[] = makeArticleItem($subject, $subject, $pic, $url); 
                              
                             }
                	$contentStr = "$count";
                	$resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                	echo $resultStr;
                }else{
                    $msgType = "text";
                    $contentStr = "Welcome to wechat world!";
                    $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                    echo $resultStr;
                }
                }else{
                	echo "Input something...";
                }

        }else {
        	echo "";
        	exit;
        }
    }
		
	private function checkSignature()
	{
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];	
        		
		$token = TOKEN;
		$tmpArr = array($token, $timestamp, $nonce);
		sort($tmpArr);
		$tmpStr = implode( $tmpArr );
		$tmpStr = sha1( $tmpStr );
		
		if( $tmpStr == $signature ){
			return true;
		}else{
			return false;
		}
	}
}

?>