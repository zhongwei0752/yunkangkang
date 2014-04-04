<?php
/**
  * wechat php test
  */
include_once './../common.php';
include_once './wx_common.php';
include_once( 'botutil.php' );

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
          $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
                $fromUsername = $postObj->FromUserName;
                $toUsername = $postObj->ToUserName;
                $keyword = trim($postObj->Content);
                $time = time();
          $dbname = "zhongwei";
          $host = "58.215.187.8";
          $user = "zhongwei";
          $pass = "623610577";
          

          //如果是新关注用户
          if($postObj->Event == 'subscribe'){
          //send_back(MENU);
                $con = mysql_connect("$host","$user","$pass");
                              if (!$con)
                                {
                                die('Could not connect: ' . mysql_error());
                                }
                              mysql_select_db("$dbname", $con);
                              $result = mysql_query("SELECT s.*,sf.* FROM uchome_space s LEFT JOIN uchome_spacefield sf ON s.uid=sf.uid  WHERE s.wxkey='".$toUsername."' ");
                              mysql_query("SET NAMES 'utf8'");
          if($row = mysql_fetch_array($result)){
            
            
            
          $v5 = mysql_query("SELECT a.*,m.* FROM uchome_appset a LEFT JOIN uchome_menuset m ON a.num=m.menusetid WHERE a.uid='$row[uid]' and a.appstatus='1'");
                          while($v52= mysql_fetch_array($v5)){
                               $a[] = "$v52[num]";
                            $b[] = "$v52[subject]";

                          }
                         
    
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
                      $zhong2 = mysql_query("SELECT * FROM uchome_recommend  WHERE uid='$row[uid]'");
                      $wei2 = mysql_fetch_array($zhong2);
                      $name=$wei2[subject];
                      $url = "http://v5.home3d.cn/home/wx/wx.php?do=home&uid=".$row[uid];
                      $pic = "http://v5.home3d.cn/home/".$wei2[imageurl];
                      $articles[] = makeArticleItem($name, $name, $pic, $url);
                      for($i=0;$i<$count;$i++){
                       $url = "http://v5.home3d.cn/home/wx/wx.php?uid=$row[uid]&do=feed&num=rand()&wxkey=".$fromUsername."&uid=".$row[uid]."&idtype=".$app_output->data->app[$i]->english;
                       if($app_output->data->app[$i]->newname){
                       $subject=$app_output->data->app[$i]->newname;
                       }else{
                       $subject=$app_output->data->app[$i]->subject;
                     }
                       $pic = "http://v5.home3d.cn/home/".$app_output->data->app[$i]->image1url;
                       $articles[] = makeArticleItem($subject, $subject, $pic, $url); 
                      } 
                      $resultStr = makeArticles($fromUsername, $toUsername, $time, $msgType, $name,$articles);  
                     echo $resultStr;

                         }else{
               $contentStr.="未填写微信id";
               $msgType = "text";
               $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
               echo $resultStr;
        }
          }

           //extract post data
          if (!empty($postStr)){
               
                $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
                $fromUsername = $postObj->FromUserName;
                $toUsername = $postObj->ToUserName;
                $keyword = trim($postObj->Content);
                $time = time();
                $eventkey=$postObj->EventKey;

                //判断是否已经有帐号
                $textTpl = "<xml>
                                   <ToUserName><![CDATA[%s]]></ToUserName>
                                   <FromUserName><![CDATA[%s]]></FromUserName>
                                   <CreateTime>%s</CreateTime>
                                   <MsgType><![CDATA[%s]]></MsgType>
                                   <Content><![CDATA[%s]]></Content>
                                   <FuncFlag>0</FuncFlag>
                                   </xml>"; 

          $con = mysql_connect("$host","$user","$pass");
                              if (!$con)
                                {
                                die('Could not connect: ' . mysql_error());
                                }
                              mysql_select_db("$dbname", $con);
                              $result = mysql_query("SELECT s.*,sf.* FROM uchome_space s LEFT JOIN uchome_spacefield sf ON s.uid=sf.uid  WHERE s.wxkey='".$toUsername."' ");
                              mysql_query("SET NAMES 'utf8'");
                            if($row = mysql_fetch_array($result)){
                              if($eventkey){
                              $msgType = "news";
                              $wei=explode(".",$eventkey);
                              if($wei[0]=="introduce"){
                              $url1 = "http://v5.home3d.cn/home/capi/space.php?do=$wei[0]&uid=$row[uid]&id=$wei[1]";
                              $app = file_get_contents($url1,0,null,null);
                              $app_output = json_decode($app);
                              $url = "http://v5.home3d.cn/home/wx/wx.php?do=detail&id=".$wei[1]."&uid=$row[uid]&idtype=".$wei[0]."id&type=".$wei[0]."&moblieclicknum=$row[moblieclicknum]";
                              $subject=$app_output->data->introduce->subject;
                              $pic = "http://v5.home3d.cn/home/".$app_output->data->introduce->imageurl;
                               $articles[] = makeArticleItem($subject, $subject, $pic, $url); 
                              $resultStr = makeArticles($fromUsername, $toUsername, $time, $msgType, $name,$articles);  
                              echo $resultStr;
                              }elseif($wei[0]=="branch"){

                              $url1 = "http://v5.home3d.cn/home/capi/space.php?do=branch&uid=$row[uid]&id=$wei[1]";
                              $app = file_get_contents($url1,0,null,null);
                              $app_output = json_decode($app);
                              $url = "http://v5.home3d.cn/home/wx/wx.php?do=detail&id=".$wei[1]."&uid=$row[uid]&idtype=branchid&type=branch&moblieclicknum=$row[moblieclicknum]";
                              $subject=$app_output->data->branch->subject;
                              $pic = "http://v5.home3d.cn/home/".$app_output->data->branch->imageurl;
                               $articles[] = makeArticleItem($subject, $subject, $pic, $url); 
                              $resultStr = makeArticles($fromUsername, $toUsername, $time, $msgType, $name,$articles);  
                              echo $resultStr;
                      } elseif($wei[0]=="industry"){

                              $url1 = "http://v5.home3d.cn/home/capi/space.php?do=industry&uid=$row[uid]&id=$wei[1]";
                              $app = file_get_contents($url1,0,null,null);
                              $app_output = json_decode($app);
                              $url = "http://v5.home3d.cn/home/wx/wx.php?do=detail&id=".$wei[1]."&uid=$row[uid]&idtype=industryid&type=industry&moblieclicknum=$row[moblieclicknum]";
                              $subject=$app_output->data->industry->subject;
                              $pic = "http://v5.home3d.cn/home/".$app_output->data->industry->imageurl;
                               $articles[] = makeArticleItem($subject, $subject, $pic, $url); 
                              $resultStr = makeArticles($fromUsername, $toUsername, $time, $msgType, $name,$articles);  
                              echo $resultStr;
                      }   elseif($wei[0]=="job"){

                              $url1 = "http://v5.home3d.cn/home/capi/space.php?do=job&uid=$row[uid]&id=$wei[1]";
                              $app = file_get_contents($url1,0,null,null);
                              $app_output = json_decode($app);
                              $url = "http://v5.home3d.cn/home/wx/wx.php?do=detail&id=".$wei[1]."&uid=$row[uid]&idtype=jobid&type=job&moblieclicknum=$row[moblieclicknum]";
                              $subject=$app_output->data->job->subject;
                            
                               $articles[] = makeArticleItem($subject, $subject, $pic, $url); 
                              $resultStr = makeArticles($fromUsername, $toUsername, $time, $msgType, $name,$articles);  
                              echo $resultStr;
                      }   elseif($wei[0]=="product"){

                              $url1 = "http://v5.home3d.cn/home/capi/space.php?do=product&uid=$row[uid]&id=$wei[1]";
                              $app = file_get_contents($url1,0,null,null);
                              $app_output = json_decode($app);
                              $url = "http://v5.home3d.cn/home/wx/wx.php?do=detail&id=".$wei[1]."&uid=$row[uid]&idtype=productid&type=product&moblieclicknum=$row[moblieclicknum]";
                              $subject=$app_output->data->product->subject;
                              $pic = "http://v5.home3d.cn/home/".$app_output->data->product->imageurl;
                               $articles[] = makeArticleItem($subject, $subject, $pic, $url); 
                              $resultStr = makeArticles($fromUsername, $toUsername, $time, $msgType, $name,$articles);  
                              echo $resultStr;
                      } elseif($wei[0]=="cases"){

                              $url1 = "http://v5.home3d.cn/home/capi/space.php?do=cases&uid=$row[uid]&id=$wei[1]";
                              $app = file_get_contents($url1,0,null,null);
                              $app_output = json_decode($app);
                              $url = "http://v5.home3d.cn/home/wx/wx.php?do=detail&id=".$wei[1]."&uid=$row[uid]&idtype=casesid&type=cases&moblieclicknum=$row[moblieclicknum]";
                              $subject=$app_output->data->cases->subject;
                              $pic = "http://v5.home3d.cn/home/".$app_output->data->cases->imageurl;
                               $articles[] = makeArticleItem($subject, $subject, $pic, $url); 
                              $resultStr = makeArticles($fromUsername, $toUsername, $time, $msgType, $name,$articles);  
                              echo $resultStr;
                      } 
                               
                              

   
             }
                         
        }else{
           $contentStr.="123";
               $msgType = "text";
               $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
               echo $resultStr;
        }
                
       
                    if(!empty( $keyword ))
                {    
                           
                         if ($keyword=='Hello2BizUser'){                             
                
                         $contentStr.="过期的通知方式";
               
          
                         
                         
                                
                       
                        
                
                        $msgType = "text";
                    
                     $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                     echo $resultStr;
                       
                         }elseif($keyword=="绑定"){
                           $msgType = "news";
                           $url = "http://v5.home3d.cn/home/wx/wx.php?uid=$row[uid]&do=bind&num=rand()&wxkey=".$fromUsername."&uid=".$row[uid]."";
                           $subject="输入帐号密码与微信进行绑定";
                           $pic = "";
                           $articles[] = makeArticleItem($subject, $subject, $pic, $url);
                           $resultStr = makeArticles($fromUsername, $toUsername, $time, $msgType, $name,$articles);  
                           echo $resultStr;
                         }elseif($keyword=="z"){
                            $msgType = "text";
                           $contentStr.="$fromUsername";
                           $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                         echo $resultStr;
                         }elseif($keyword=="w"){
                            $msgType = "text";
                           $contentStr.="$toUsername";
                           $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                         echo $resultStr;
                         }else{
                  $zhong = mysql_query("SELECT a.*,m.* FROM uchome_appset a LEFT JOIN uchome_menuset m ON a.num=m.menusetid WHERE a.uid='$row[uid]'and a.num='$keyword'");
                  $wei = mysql_fetch_array($zhong);
                 
                    
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
                       $zhong2 = mysql_query("SELECT * FROM uchome_recommend  WHERE uid='$row[uid]'");
                  $wei2 = mysql_fetch_array($zhong2);
                  $name=$wei2[subject];
                    $url = "http://v5.home3d.cn/home/wx/wx.php?do=home&uid=".$row[uid];
                    $pic = "http://v5.home3d.cn/home/".$wei2[imageurl];
                    $articles[] = makeArticleItem($name, $name, $pic, $url);
                      for($i=0;$i<$count;$i++){
                       $url = "http://v5.home3d.cn/home/wx/wx.php?uid=$row[uid]&do=feed&num=rand()&wxkey=".$fromUsername."&uid=".$row[uid]."&idtype=".$app_output->data->app[$i]->english;
                       if($app_output->data->app[$i]->newname){
                       $subject=$app_output->data->app[$i]->newname;
                       }else{
                       $subject=$app_output->data->app[$i]->subject;
                     }
                       $pic = "http://v5.home3d.cn/home/".$app_output->data->app[$i]->image1url;

                       $articles[] = makeArticleItem($subject, $subject, $pic, $url); 
                      }  
                       
                    if($app_output->data->highapp){
                      $url = "http://v5.home3d.cn/home/wx/wx.php?uid=$row[uid]&do=feed&num=rand()&wxkey=".$fromUsername."&uid=".$row[uid]."&idtype=".$app_output->data->highapp[0]->english;
                      if($app_output->data->highapp[0]->newname){
                       $subject=$app_output->data->highapp[0]->newname;
                       }else{
                       $subject=$app_output->data->highapp[0]->subject;
                     }
                      $pic = "http://v5.home3d.cn/home/".$app_output->data->highapp[0]->image1url;

                      $articles[] = makeArticleItem($subject, $subject, $pic, $url); 
                    }
                         
                         
                         
                       
                        
                
                       
                    
                      $resultStr = makeArticles($fromUsername, $toUsername, $time, $msgType, $name,$articles);  
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