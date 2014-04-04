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
                      $zhong2 = mysql_query("SELECT * FROM uchome_weixinmenutop  WHERE uid='$row[uid]' and type='image'");
                      $wei2 = mysql_fetch_array($zhong2);
                      if($wei2){
                      $name=$wei2[name];
                      if($wei2['recommendlink']){
                      $url = "$wei2[recommendlink]"; 
                      }else{
                      $url = "http://v5.home3d.cn/home/wx/wx.php?do=home&wxkey=".$fromUsername."&uid=".$row[uid];
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
                           }else{
                            $appurl = "http://v5.home3d.cn/home/capi/space.php?do=app&uid=$row[uid]";
                            $app = file_get_contents($appurl,0,null,null);
                            $app_output = json_decode($app);
                            $count=$app_output->data->count;
                            $zhong2 = mysql_query("SELECT * FROM uchome_recommend  WHERE uid='$row[uid]'");
                            $wei2 = mysql_fetch_array($zhong2);
                            $name=$wei2[subject];
                            if($wei2['recommendlink']){
                            $url = "$wei2[recommendlink]"; 
                            }else{
                            $url = "http://v5.home3d.cn/home/wx/wx.php?do=home&wxkey=".$fromUsername."&uid=".$row[uid];
                            }
                            $pic = "http://v5.home3d.cn/home/".$wei2['imageurl'];
                            $articles[] = makeArticleItem($name, $name, $pic, $url);
                            for($i=0;$i<$count;$i++){
                              if($app_output->data->app[$i]->english=='dialog'&&$row['uid']=='7136'){
                              $url ="http://wx.wsq.qq.com/196713929";
                              }else{
                              $url = "http://v5.home3d.cn/home/wx/wx.php?uid=$row[uid]&do=feed&num=rand()&wxkey=".$fromUsername."&uid=".$row[uid]."&idtype=".$app_output->data->app[$i]->english;  
                              }
                              if($app_output->data->app[$i]->english=='dialog'&&$row['uid']=='7136'){
                                  $subject="微医社区";
                              }else{
                                if($app_output->data->app[$i]->newname){
                                 $subject=$app_output->data->app[$i]->newname;
                                 }else{
                                 $subject=$app_output->data->app[$i]->subject;
                                 }
                              }
                             
                              if($app_output->data->app[$i]->image4url){
                               $pic = "http://v5.home3d.cn/home/".$app_output->data->app[$i]->image4url; 
                             }else{
                               $pic = "http://v5.home3d.cn/home/".$app_output->data->app[$i]->image1url; 
                             }
                               

                               $articles[] = makeArticleItem($subject, $subject, $pic, $url); 
                              }  
                       
                              if($app_output->data->highapp){
                                $url = "http://v5.home3d.cn/home/wx/wx.php?uid=$row[uid]&do=feed&num=rand()&wxkey=".$fromUsername."&uid=".$row[uid]."&idtype=".$app_output->data->highapp[0]->english;
                                if($app_output->data->highapp[0]->newname){
                                 $subject=$app_output->data->highapp[0]->newname;
                                 }else{
                                 $subject=$app_output->data->highapp[0]->subject;
                               }
                                if($app_output->data->highapp[0]->image4url){
                               $pic = "http://v5.home3d.cn/home/".$app_output->data->highapp[0]->image4url; 
                             }else{
                               $pic = "http://v5.home3d.cn/home/".$app_output->data->highapp[0]->image1url; 
                             }
                            

                                $articles[] = makeArticleItem($subject, $subject, $pic, $url); 
                              }
                           }
                              $resultStr = makeArticles($fromUsername, $toUsername, $time, $msgType, $name,$articles);  
                              echo $resultStr;
                            include_once( 'weibo/config.php' );
                            require_once '../common.php';
                            require_once 'wx_common.php';
                            include_once( CONNECT_ROOT.'/saetv2.ex.class.php' );
                            require_once CONNECT_ROOT."/common/jtee.inc.php";
                            require_once CONNECT_ROOT."/common/siteUserRegister.class.php";
                            require_once('Weixin.class.php');
                            $rst = mysql_query("SELECT * FROM uchome_wxkey WHERE wxkey='$fromUsername'");
                            $row1 = mysql_fetch_array($rst);
                            $rst1 = mysql_query("SELECT * FROM uchome_space WHERE wxkey='$fromUsername'");
                            $row2 = mysql_fetch_array($rst1);
                            if($row1||$row2){
                              loaducenter();
                              //showmessage("$row[uid]");
                              //include_once(S_ROOT.'./source/function_cp.php');
                              //updateuserstat('hot');
                              if($row1){
                              $user = uc_get_user($row1['uid'], 1); 
                              uc_user_synlogin($row1['uid']); 
                              }
                              if($row2){
                              $user = uc_get_user($row2['uid'], 1); 
                              uc_user_synlogin($row2['uid']);   
                              }  
                              
                              $auth = setSession($user[0],$user[1]);
                              $weixinuid=$row['uid'];
                              $m_auth=rawurlencode($auth);
                              $friendurl = "http://v5.home3d.cn/home/capi/cp.php?ac=friend&op=add&uid=$weixinuid&gid=0&addsubmit=true&note=微信用户关注&m_auth=$m_auth";
                              $friend = file_get_contents($friendurl,0,null,null);
                              $friend_output = json_decode($friend);
                              
                              
                          }else{
                            //include_once(S_ROOT.'./source/function_cp.php');
                            //updateuserstat('hot');
                              $nextuid=$row['uid'];
                              $d = get_obj_by_xiaoquid($nextuid);
                              $info = $d->getNewWXUser(); 
                              $fakeid=$info['id'];
                              $query = mysql_query("SELECT * FROM uchome_space WHERE fakeid='$fakeid'");
                              $value = mysql_fetch_array($query);
                              if($value){
                              loaducenter();
                              //include_once(S_ROOT.'./source/function_cp.php');
                              //updateuserstat('hot');  
                              $user = uc_get_user($value['uid'], 1); 
                              uc_user_synlogin($value['uid']);
                              $auth = setSession($user[0],$user[1]);
                              $weixinuid=$row['uid'];
                              $m_auth=rawurlencode($auth);
                              $friendurl = "http://v5.home3d.cn/home/capi/cp.php?ac=friend&op=add&uid=$weixinuid&gid=0&addsubmit=true&note=微信用户关注&m_auth=$m_auth";
                                  $friend = file_get_contents($friendurl,0,null,null);
                                  $friend_output = json_decode($friend);
                                  inserttable("wxkey",array('wxkey'=>$fromUsername,'fakeid'=>$fakeid,'uid'=>$value['uid']));

                            }else{
                              $username =$fromUsername;
                              $name = $fromUsername;
                              $password = "weixin";
                              $email = isemail($_REQUEST['email']) ? $_REQUEST['email'] : $username."@v.com.cn";
                              $data = array();
                              require_once CONNECT_ROOT."/common/siteUserRegister.class.php";
                              $regClass = new siteUserRegister();
                              $uid = $regClass->reg($username, $email, $password);
                              
                                      $nextuid=$row['uid'];
                                      $d = get_obj_by_xiaoquid($nextuid);
                                      $info = $d->getNewWXUser(); 
                                      $setarr = array(
                                        'name' => $info['nick_name'],
                                        'fakeid'=>$info['id'],
                                        'namestatus' => '1',
                                        'wxkey' => $fromUsername,
                                        'fatheruid'=>$nextuid
                                      );
                                      updatetable('space', $setarr, array('uid'=>$uid ));
                                      loaducenter();
                                      $user = uc_get_user($uid, 1); 
                                      uc_user_synlogin($uid);
                                      $weixinuid=$row['uid'];
                                      $auth = setSession($user[0],$user[1]);
                                      $friendurl = "http://v5.home3d.cn/home/capi/cp.php?ac=friend&op=add&uid=$nextuid&gid=0&addsubmit=true&note=微信用户关注&m_auth=$m_auth";
                                      $friend = file_get_contents($friendurl,0,null,null);
                                      $friend_output = json_decode($friend);
                            }
                          }
                             

                              
                                    
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
                $MsgType1=$postObj->MsgType;
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
                                if($wei[1]=='0'){
                                  $zhong2 = mysql_query("SELECT * FROM uchome_recommend  WHERE uid='$row[uid]'");
                                  $wei2 = mysql_fetch_array($zhong2);
                                  $name=$wei2[subject];
                                    if($wei2['recommendlink']){
                                      $url = "$wei2[recommendlink]"; 
                                      }else{
                                      $url = "http://v5.home3d.cn/home/wx/wx.php?do=home&wxkey=".$fromUsername."&uid=".$row[uid];
                                    }
                                    $pic = "http://v5.home3d.cn/home/".$wei2[imageurl];
                                    $articles[] = makeArticleItem($name, $name, $pic, $url);
                                    $table="uchome_introduce";
                                    $query = mysql_query("SELECT * FROM ".$table." WHERE uid=$row[uid] order by dateline DESC limit 0,3");
                                    while($value = mysql_fetch_array($query)){
                                       $subject=$value['subject'];
                                        $pic ="http://v5.home3d.cn/home/".$value['image1url'];
                                        $url = "http://v5.home3d.cn/home/wx/wx.php?do=detail&id=$value[introduceid]&uid=$row[uid]&viewuid=$row[uid]&wxkey=".$fromUsername."&idtype=introduceid&type=introduce&moblieclicknum=$row[moblieclicknum]"; 
                                       $articles[] = makeArticleItem($subject, $subject, $pic, $url); 
                                    }
                                }else{
                              $url1 = "http://v5.home3d.cn/home/capi/space.php?do=$wei[0]&uid=$row[uid]&id=$wei[1]";
                              $app = file_get_contents($url1,0,null,null);
                              $app_output = json_decode($app);
                              $url = "http://v5.home3d.cn/home/wx/wx.php?do=detail&id=".$wei[1]."&uid=$row[uid]&viewuid=$row[uid]&wxkey=".$fromUsername."&idtype=".$wei[0]."id&type=".$wei[0]."&moblieclicknum=$row[moblieclicknum]";
                              $subject=$app_output->data->introduce->subject;
                              $message1=$app_output->data->introduce->message1;
                              //$message1=strtolower($message1);
                              preg_match_all("<img src=\"(.*)\">",$message1,$matches);
                               $message2=strip_tags($message1);
                              $message2 = str_replace("&nbsp;","",$message2);
                               $arr = explode("。",$message2);
                              $message2 =$arr[0]."...";
                            /* $pic = $matches[1][0];*/
                             /* if($app_output->data->introduce->pic){
                              $pic ="http://v5.home3d.cn/home/attachment/".$app_output->data->introduce->pic;
                              $pic = str_replace("http://v5.home3d.cn/home/http://v5.home3d.cn/home/attachment/","http://v5.home3d.cn/home/attachment/",$pic);
                               $pic = str_replace("http://v5.home3d.cn/home/attachment/http://v5.home3d.cn/home/","http://v5.home3d.cn/home/",$pic);
                               $pic = str_replace("http://v5.home3d.cn/home/attachment/attachment/","http://v5.home3d.cn/home/attachment/",$pic);
                            }else{
                              $pic="";
                            }*/
                              $pic="http://v5.home3d.cn/home/".$app_output->data->introduce->imageurl;
                              $pic = str_replace(" ","%20",$pic);
                               $articles[] = makeArticleItem($subject, $message2, $pic, $url); 
                             }
                              $resultStr = makeArticles($fromUsername, $toUsername, $time, $msgType, $name,$articles);  
                              echo $resultStr;
                              }elseif($wei[0]=="branch"){
                                if($wei[1]=='0'){
                                  $zhong2 = mysql_query("SELECT * FROM uchome_recommend  WHERE uid='$row[uid]'");
                                  $wei2 = mysql_fetch_array($zhong2);
                                  $name=$wei2[subject];
                                    if($wei2['recommendlink']){
                                      $url = "$wei2[recommendlink]"; 
                                      }else{
                                      $url = "http://v5.home3d.cn/home/wx/wx.php?do=home&wxkey=".$fromUsername."&uid=".$row[uid];
                                    }
                                    $pic = "http://v5.home3d.cn/home/".$wei2[imageurl];
                                    $articles[] = makeArticleItem($name, $name, $pic, $url);
                                    $table="uchome_branch";
                                    $query = mysql_query("SELECT * FROM ".$table." WHERE uid=$row[uid] order by dateline DESC limit 0,3");
                                    while($value = mysql_fetch_array($query)){
                                       $subject=$value['subject'];
                                        $pic ="http://v5.home3d.cn/home/".$value['image1url'];
                                        $url = "http://v5.home3d.cn/home/wx/wx.php?do=detail&viewuid=$row[uid]&id=$value[branchid]&uid=$row[uid]&wxkey=".$fromUsername."&idtype=branchid&type=branch&moblieclicknum=$row[moblieclicknum]"; 
                                       $articles[] = makeArticleItem($subject, $subject, $pic, $url); 
                                    }
                                }else{
                              $url1 = "http://v5.home3d.cn/home/capi/space.php?do=branch&uid=$row[uid]&id=$wei[1]";
                              $app = file_get_contents($url1,0,null,null);
                              $app_output = json_decode($app);
                              $url = "http://v5.home3d.cn/home/wx/wx.php?do=detail&id=".$wei[1]."&wxkey=".$fromUsername."&uid=$row[uid]&viewuid=$row[uid]&idtype=branchid&type=branch&moblieclicknum=$row[moblieclicknum]";
                              $subject=$app_output->data->branch->subject;
                              $message1=$app_output->data->branch->message1;
                              preg_match_all("<img src=\"(.*)\">",$message1,$matches);
                               $message2=strip_tags($message1);
                              $message2 = str_replace("&nbsp;","",$message2);
                               $arr = explode("。",$message2);
                               $message2 =$arr[0]."...";
                              //$pic = $matches[1][0];
                              /*if($app_output->data->branch->pic){
                              $pic ="http://v5.home3d.cn/home/".$app_output->data->branch->pic;
                              $pic = str_replace("http://v5.home3d.cn/home/http://v5.home3d.cn/home/","http://v5.home3d.cn/home/",$pic);
                            }else{
                              $pic="";
                            }*/
                            $pic ="http://v5.home3d.cn/home/".$app_output->data->branch->imageurl;
                            $pic = str_replace(" ","%20",$pic);
                              /* if($app_output->data->branch->pic){
                              $pic ="http://v5.home3d.cn/home/".$app_output->data->branch->pic;
                            }else{
                              $pic="";
                            }*/
                               $articles[] = makeArticleItem($subject, $message2, $pic, $url); 
                             }
                              $resultStr = makeArticles($fromUsername, $toUsername, $time, $msgType, $name,$articles);  
                              echo $resultStr;
                              } elseif($wei[0]=="industry"){
                              if($wei[1]=='0'){
                                  $zhong2 = mysql_query("SELECT * FROM uchome_recommend  WHERE uid='$row[uid]'");
                                  $wei2 = mysql_fetch_array($zhong2);
                                  $name=$wei2[subject];
                                    if($wei2['recommendlink']){
                                      $url = "$wei2[recommendlink]"; 
                                      }else{
                                      $url = "http://v5.home3d.cn/home/wx/wx.php?do=home&wxkey=".$fromUsername."&uid=".$row[uid];
                                    }
                                    $pic = "http://v5.home3d.cn/home/".$wei2[imageurl];
                                    $articles[] = makeArticleItem($name, $name, $pic, $url);
                                    $table="uchome_industry";
                                    $query = mysql_query("SELECT * FROM ".$table." WHERE uid=$row[uid] order by dateline DESC limit 0,3");
                                    while($value = mysql_fetch_array($query)){
                                       $subject=$value['subject'];
                                        $pic ="http://v5.home3d.cn/home/".$value['image1url'];
                                        $url = "http://v5.home3d.cn/home/wx/wx.php?do=detail&viewuid=$row[uid]&id=$value[industryid]&uid=$row[uid]&wxkey=".$fromUsername."&idtype=industryid&type=industry&moblieclicknum=$row[moblieclicknum]"; 
                                       $articles[] = makeArticleItem($subject, $subject, $pic, $url); 
                                    }
                                }else{
                              $url1 = "http://v5.home3d.cn/home/capi/space.php?do=industry&wxkey=".$fromUsername."&uid=$row[uid]&id=$wei[1]";
                              $app = file_get_contents($url1,0,null,null);
                              $app_output = json_decode($app);
                              $url = "http://v5.home3d.cn/home/wx/wx.php?do=detail&id=".$wei[1]."&uid=$row[uid]&viewuid=$row[uid]&idtype=industryid&type=industry&moblieclicknum=$row[moblieclicknum]";
                              $subject=$app_output->data->industry->subject;
                              $message1=$app_output->data->industry->message1;
                              $message1=strtolower($message1);
                              preg_match_all("<img src=\"(.*)\">",$message1,$matches);
                               $message2=strip_tags($message1);
                              $message2 = str_replace("&nbsp;","",$message2);
                               $arr = explode("。",$message2);
                               $message2 =$arr[0]."...";
                              //$pic = $matches[1][0];
                             /* if($app_output->data->industry->pic){
                              $pic ="http://v5.home3d.cn/home/".$app_output->data->industry->pic;
                              $pic = str_replace("http://v5.home3d.cn/home/http://v5.home3d.cn/home/","http://v5.home3d.cn/home/",$pic);
                            }else{
                              $pic="";
                            }*/
                            $pic ="http://v5.home3d.cn/home/".$app_output->data->industry->imageurl;
                            $pic = str_replace(" ","%20",$pic);
                              /* if($app_output->data->industry->pic){
                              $pic ="http://v5.home3d.cn/home/".$app_output->data->industry->pic;
                            }else{
                              $pic="";
                            }*/
                               $articles[] = makeArticleItem($subject, $message2, $pic, $url);
                               } 
                              $resultStr = makeArticles($fromUsername, $toUsername, $time, $msgType, $name,$articles);  
                              echo $resultStr;
                              }   elseif($wei[0]=="job"){
                              if($wei[1]=='0'){
                                  $zhong2 = mysql_query("SELECT * FROM uchome_recommend  WHERE uid='$row[uid]'");
                                  $wei2 = mysql_fetch_array($zhong2);
                                  $name=$wei2[subject];
                                    if($wei2['recommendlink']){
                                      $url = "$wei2[recommendlink]"; 
                                      }else{
                                      $url = "http://v5.home3d.cn/home/wx/wx.php?do=home&wxkey=".$fromUsername."&uid=".$row[uid];
                                    }
                                    $pic = "http://v5.home3d.cn/home/".$wei2[imageurl];
                                    $articles[] = makeArticleItem($name, $name, $pic, $url);
                                    $table="uchome_job";
                                    $query = mysql_query("SELECT * FROM ".$table." WHERE uid=$row[uid] order by dateline DESC limit 0,3");
                                    while($value = mysql_fetch_array($query)){
                                       $subject=$value['subject'];
                                        $pic ="http://v5.home3d.cn/home/".$value['image1url'];
                                        $url = "http://v5.home3d.cn/home/wx/wx.php?do=detail&viewuid=$row[uid]&id=$value[jobid]&uid=$row[uid]&wxkey=".$fromUsername."&idtype=jobid&type=job&moblieclicknum=$row[moblieclicknum]"; 
                                       $articles[] = makeArticleItem($subject, $subject, $pic, $url); 
                                    }
                                }else{
                              $url1 = "http://v5.home3d.cn/home/capi/space.php?do=job&uid=$row[uid]&id=$wei[1]";
                              $app = file_get_contents($url1,0,null,null);
                              $app_output = json_decode($app);
                              $url = "http://v5.home3d.cn/home/wx/wx.php?do=detail&viewuid=$row[uid]&id=".$wei[1]."&wxkey=".$fromUsername."&uid=$row[uid]&idtype=jobid&type=job&moblieclicknum=$row[moblieclicknum]";
                              $subject=$app_output->data->job->subject;
                              $message1=$app_output->data->industry->message1;
                              $message1=strtolower($message1);
                              $message2=strip_tags($message1);
                              $message2 = str_replace("&nbsp;","",$message2);
                               $arr = explode("。",$message2);
                               $message2 =$arr[0]."...";
                             }
                              $resultStr = makeArticles($fromUsername, $toUsername, $time, $msgType, $name,$articles);  
                              echo $resultStr;
                              }   elseif($wei[0]=="product"){
                                if($wei[1]=='0'){
                                  $zhong2 = mysql_query("SELECT * FROM uchome_recommend  WHERE uid='$row[uid]'");
                                  $wei2 = mysql_fetch_array($zhong2);
                                  $name=$wei2[subject];
                                    if($wei2['recommendlink']){
                                      $url = "$wei2[recommendlink]"; 
                                      }else{
                                      $url = "http://v5.home3d.cn/home/wx/wx.php?do=home&wxkey=".$fromUsername."&uid=".$row[uid];
                                    }
                                    $pic = "http://v5.home3d.cn/home/".$wei2[imageurl];
                                    $articles[] = makeArticleItem($name, $name, $pic, $url);
                                    $table="uchome_product";
                                    $query = mysql_query("SELECT * FROM ".$table." WHERE uid=$row[uid] order by dateline DESC limit 0,3");
                                    while($value = mysql_fetch_array($query)){
                                       $subject=$value['subject'];
                                        $pic ="http://v5.home3d.cn/home/".$value['image1url'];
                                        $url = "http://v5.home3d.cn/home/wx/wx.php?do=detail&viewuid=$row[uid]&id=$value[productid]&uid=$row[uid]&wxkey=".$fromUsername."&idtype=productid&type=product&moblieclicknum=$row[moblieclicknum]"; 
                                       $articles[] = makeArticleItem($subject, $subject, $pic, $url); 
                                    }
                                }else{
                              $url1 = "http://v5.home3d.cn/home/capi/space.php?do=product&uid=$row[uid]&id=$wei[1]";
                              $app = file_get_contents($url1,0,null,null);
                              $app_output = json_decode($app);
                              $url = "http://v5.home3d.cn/home/wx/wx.php?do=detail&viewuid=$row[uid]&id=".$wei[1]."&wxkey=".$fromUsername."&uid=$row[uid]&idtype=productid&type=product&moblieclicknum=$row[moblieclicknum]";
                              $subject=$app_output->data->product->subject;
                              $message1=$app_output->data->product->message1;
                             preg_match_all("<src=\"(.*)\">",$message1,$matches);
                               $message2=strip_tags($message1);
                              $message2 = str_replace("&nbsp;","",$message2);
                               $arr = explode("。",$message2);
                              $message2 =$arr[0]."...";
                              //$pic = $matches[1][0];
                              /*if($app_output->data->product->pic){
                              $pic ="http://v5.home3d.cn/home/".$app_output->data->product->pic;
                              $pic = str_replace("http://v5.home3d.cn/home/http://v5.home3d.cn/home/","http://v5.home3d.cn/home/",$pic);
                            }else{
                              $pic="";
                            }*/
                              $pic ="http://v5.home3d.cn/home/".$app_output->data->product->imageurl;
                              $pic = str_replace(" ","%20",$pic);
                               $articles[] = makeArticleItem($subject, $message2, $pic, $url); 
                             }
                              $resultStr = makeArticles($fromUsername, $toUsername, $time, $msgType, $name,$articles);  
                              echo $resultStr;
                              }elseif($wei[0]=="dialog"){
                                  $name="在线沟通";
                                $url = "http://v5.home3d.cn/home/wx/wx.php?do=feed&idtype=dialog&wxkey=".$fromUsername."&uid=".$row[uid];
                                $pic = "http://v5.home3d.cn/home/upload/menuset/small/menuset1379386329communicate.jpg";
                                $articles[] = makeArticleItem($name, $name, $pic, $url);
                                $resultStr = makeArticles($fromUsername, $toUsername, $time, $msgType, $name,$articles);  
                                echo $resultStr;
                              }elseif($wei[0]=="event"){
                                
                                 $name="最新活动";

                                  $url = "http://v5.home3d.cn/home/wx/wx.php?uid=$row[uid]&do=feed&num=rand()&wxkey=".$fromUsername."&uid=".$row[uid]."&idtype=event"; 
                                  
                                  $pic = "http://v5.home3d.cn/home/upload/menuset/small/menuset1381552148huodong.jpg";
                                $articles[] = makeArticleItem($name, $name, $pic, $url);
                                $resultStr = makeArticles($fromUsername, $toUsername, $time, $msgType, $name,$articles);  
                                echo $resultStr;
                            }elseif($wei[0]=="dial"){
                              $name="大转盘";
                                 $url = "http://v5.home3d.cn/home/wx/wx.php?uid=$row[uid]&do=feed&num=rand()&wxkey=".$fromUsername."&uid=".$row[uid]."&idtype=dial"; 
                                  $pic = "http://v5.home3d.cn/home/upload/menuset/small/menuset1381552148huodong.jpg";
                                $articles[] = makeArticleItem($name, $name, $pic, $url);
                                $resultStr = makeArticles($fromUsername, $toUsername, $time, $msgType, $name,$articles);  
                                echo $resultStr;

                            }elseif($wei[0]=="development"){
                                if($wei[1]=='0'){
                                  $zhong2 = mysql_query("SELECT * FROM uchome_recommend  WHERE uid='$row[uid]'");
                                  $wei2 = mysql_fetch_array($zhong2);
                                  $name=$wei2[subject];
                                    if($wei2['recommendlink']){
                                      $url = "$wei2[recommendlink]"; 
                                      }else{
                                      $url = "http://v5.home3d.cn/home/wx/wx.php??do=home&wxkey=".$fromUsername."&uid=".$row[uid];
                                    }
                                    $pic = "http://v5.home3d.cn/home/".$wei2[imageurl];
                                    $articles[] = makeArticleItem($name, $name, $pic, $url);
                                    $table="uchome_development";
                                    $query = mysql_query("SELECT * FROM ".$table." WHERE uid=$row[uid] order by dateline DESC limit 0,3");
                                    while($value = mysql_fetch_array($query)){
                                       $subject=$value['subject'];
                                        $pic ="http://v5.home3d.cn/home/".$value['image1url'];
                                        $url = "http://v5.home3d.cn/home/wx/wx.php?do=detail&viewuid=$row[uid]&id=$value[developmentid]&uid=$row[uid]&wxkey=".$fromUsername."&idtype=developmentid&type=development&moblieclicknum=$row[moblieclicknum]"; 
                                       $articles[] = makeArticleItem($subject, $subject, $pic, $url); 
                                    }
                                }else{
                              $url1 = "http://v5.home3d.cn/home/capi/space.php?do=development&uid=$row[uid]&id=$wei[1]";
                              $app = file_get_contents($url1,0,null,null);
                              $app_output = json_decode($app);
                              $url = "http://v5.home3d.cn/home/wx/wx.php?do=detail&viewuid=$row[uid]&id=".$wei[1]."&wxkey=".$fromUsername."&uid=$row[uid]&idtype=developmentid&type=development&moblieclicknum=$row[moblieclicknum]";
                              $message1=$app_output->data->development->message1;
                              preg_match_all("<img src=\"(.*)\">",$message1,$matches);
                              $message2=strip_tags($message1);
                              $message2 = str_replace("&nbsp;","",$message2);
                               $arr = explode("。",$message2);
                               $message2 =$arr[0]."...";
                              //$pic = $matches[1][0];
                              /*if($app_output->data->development->pic){
                              $pic ="http://v5.home3d.cn/home/".$app_output->data->development->pic;
                              $pic = str_replace("http://v5.home3d.cn/home/http://v5.home3d.cn/home/","http://v5.home3d.cn/home/",$pic);
                            }else{
                              $pic="";
                            }*/
                            $pic ="http://v5.home3d.cn/home/".$app_output->data->development->imageurl;
                            $pic = str_replace(" ","%20",$pic);
                               $subject=$app_output->data->development->subject;
                               $articles[] = makeArticleItem($subject, $message2, $pic, $url); 
                             }
                              $resultStr = makeArticles($fromUsername, $toUsername, $time, $msgType, $name,$articles);  
                              echo $resultStr;
                            }elseif($wei[0]=="goods"){
                              if($wei[1]=='0'){
                                  $zhong2 = mysql_query("SELECT * FROM uchome_recommend  WHERE uid='$row[uid]'");
                                  $wei2 = mysql_fetch_array($zhong2);
                                  $name=$wei2[subject];
                                    if($wei2['recommendlink']){
                                      $url = "$wei2[recommendlink]"; 
                                      }else{
                                      $url = "http://v5.home3d.cn/home/wx/wx.php?do=home&wxkey=".$fromUsername."&uid=".$row[uid];
                                    }
                                    $pic = "http://v5.home3d.cn/home/".$wei2[imageurl];
                                    $articles[] = makeArticleItem($name, $name, $pic, $url);
                                    $table="uchome_goods";
                                    $query = mysql_query("SELECT * FROM ".$table." WHERE uid=$row[uid] order by dateline DESC limit 0,3");
                                    while($value = mysql_fetch_array($query)){
                                       $subject=$value['subject'];
                                        $pic ="http://v5.home3d.cn/home/".$value['image1url'];
                                        $url = "http://v5.home3d.cn/home/wx/wx.php?do=detail&viewuid=$row[uid]&id=$value[goodsid]&uid=$row[uid]&wxkey=".$fromUsername."&idtype=goodsid&type=goods&moblieclicknum=$row[moblieclicknum]"; 
                                       $articles[] = makeArticleItem($subject, $subject, $pic, $url); 
                                    }
                                }else{
                              $url1 = "http://v5.home3d.cn/home/capi/space.php?do=goods&uid=$row[uid]&id=$wei[1]";
                              $app = file_get_contents($url1,0,null,null);
                              $app_output = json_decode($app);
                              $url = "http://v5.home3d.cn/home/wx/wx.php?do=detail&viewuid=$row[uid]&id=".$wei[1]."&wxkey=".$fromUsername."&uid=$row[uid]&idtype=goodsid&type=goods&moblieclicknum=$row[moblieclicknum]";
                              $subject=$app_output->data->goods->subject;
                              $message1=$app_output->data->goods->message1;
                              preg_match_all("<img src=\"(.*)\">",$message1,$matches);
                              $message2=strip_tags($message1);
                              $message2 = str_replace("&nbsp;","",$message2);
                               $arr = explode("。",$message2);
                              $message2 =$arr[0]."...";
                              /*$pic = $matches[1][0];*/
                             /* if($app_output->data->goods->pic){
                              $pic ="http://v5.home3d.cn/home/".$app_output->data->goods->pic;
                              $pic = str_replace("http://v5.home3d.cn/home/http://v5.home3d.cn/home/","http://v5.home3d.cn/home/",$pic);
                            }else{
                              $pic="";
                            }*/
                            $pic ="http://v5.home3d.cn/home/".$app_output->data->goods->imageurl;
                            $pic = str_replace(" ","%20",$pic);
                               /*if($app_output->data->goods->pic){
                              $pic ="http://v5.home3d.cn/home/".$app_output->data->goods->pic;
                            }else{
                              $pic="";
                            }*/
                               $articles[] = makeArticleItem($subject, $message2, $pic, $url); 
                             }
                              $resultStr = makeArticles($fromUsername, $toUsername, $time, $msgType, $name,$articles);  
                              echo $resultStr;
                            } elseif($wei[0]=="cases"){
                              if($wei[1]=='0'){
                                  $zhong2 = mysql_query("SELECT * FROM uchome_recommend  WHERE uid='$row[uid]'");
                                  $wei2 = mysql_fetch_array($zhong2);
                                  $name=$wei2[subject];
                                    if($wei2['recommendlink']){
                                      $url = "$wei2[recommendlink]"; 
                                      }else{
                                      $url = "http://v5.home3d.cn/home/wx/wx.php?do=home&wxkey=".$fromUsername."&uid=".$row[uid];
                                    }
                                    $pic = "http://v5.home3d.cn/home/".$wei2[imageurl];
                                    $articles[] = makeArticleItem($name, $name, $pic, $url);
                                    $table="uchome_cases";
                                    $query = mysql_query("SELECT * FROM ".$table." WHERE uid=$row[uid] order by dateline DESC limit 0,3");
                                    while($value = mysql_fetch_array($query)){
                                       $subject=$value['subject'];
                                        $pic ="http://v5.home3d.cn/home/".$value['image1url'];
                                        $url = "http://v5.home3d.cn/home/wx/wx.php?do=detail&viewuid=$row[uid]&id=$value[casesid]&uid=$row[uid]&wxkey=".$fromUsername."&idtype=casesid&type=cases&moblieclicknum=$row[moblieclicknum]"; 
                                       $articles[] = makeArticleItem($subject, $subject, $pic, $url); 
                                    }
                                }else{
                              $url1 = "http://v5.home3d.cn/home/capi/space.php?do=cases&uid=$row[uid]&id=$wei[1]";
                              $app = file_get_contents($url1,0,null,null);
                              $app_output = json_decode($app);
                              $url = "http://v5.home3d.cn/home/wx/wx.php?do=detail&viewuid=$row[uid]&id=".$wei[1]."&wxkey=".$fromUsername."&uid=$row[uid]&idtype=casesid&type=cases&moblieclicknum=$row[moblieclicknum]";
                              $subject=$app_output->data->cases->subject;
                              $message1=$app_output->data->cases->message1;
                              preg_match_all("<img src=\"(.*)\">",$message1,$matches);
                              $message2=strip_tags($message1);
                              $message2 = str_replace("&nbsp;","",$message2);
                               $arr = explode("。",$message2);
                               $message2 =$arr[0]."...";
                             /* $pic = $matches[1][0];*/
                             /*if($app_output->data->cases->pic){
                              $pic ="http://v5.home3d.cn/home/".$app_output->data->cases->pic;
                              $pic = str_replace("http://v5.home3d.cn/home/http://v5.home3d.cn/home/","http://v5.home3d.cn/home/",$pic);
                            }else{
                              $pic="";
                            }*/
                            $pic ="http://v5.home3d.cn/home/".$app_output->data->cases->imageurl;

                            $pic = str_replace(" ","%20",$pic); 
                              $articles[] = makeArticleItem($subject, $message2, $pic, $url); 
                            }
                              $resultStr = makeArticles($fromUsername, $toUsername, $time, $msgType, $name,$articles);  
                              echo $resultStr;
                             } else{
                              if($row['uid']=='3520'){


                              $subject="测试";
                              $url="http://115.29.7.132/jqm?wxkey=".$fromUsername."";
                              $articles[] = makeArticleItem($subject, $message2, $pic, $url); 
                              $resultStr = makeArticles($fromUsername, $toUsername, $time, $msgType, $name,$articles);
                               echo $resultStr; 
                                 } 
                             }   
                               
                              

   
             }
                         
        }else{
           $contentStr.="$toUsername";
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
                         }elseif($keyword=="查询"){
                              if($row['uid']=='319'){
                             $msgType = "news";
                             $subject="查询你的订单";
                             $url="http://115.29.7.132/v5";
                              $articles[] = makeArticleItem($subject, $message2, $pic, $url); 
                              $resultStr = makeArticles($fromUsername, $toUsername, $time, $msgType, $name,$articles);
                              echo $resultStr;
                              } 

                         }else{
                  $zhong = mysql_query("SELECT a.*,m.* FROM uchome_appset a LEFT JOIN uchome_menuset m ON a.num=m.menusetid WHERE a.uid='$row[uid]'and a.num='$keyword'");
                  $wei = mysql_fetch_array($zhong);
                 
                    $result = mysql_query("SELECT s.*,sf.* FROM uchome_space s LEFT JOIN uchome_spacefield sf ON s.uid=sf.uid  WHERE s.wxkey='".$toUsername."' ");
                    $row = mysql_fetch_array($result);
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
                    if($wei2['recommendlink']){
                      $url = "$wei2[recommendlink]"; 
                      }else{
                      $url = "http://v5.home3d.cn/home/wx/wx.php?do=home&wxkey=".$fromUsername."&uid=".$row[uid];
                    }
                    $pic = "http://v5.home3d.cn/home/".$wei2[imageurl];
                    $articles[] = makeArticleItem($name, $name, $pic, $url);
                    if($count>7){
                      $count='7';
                      $more='1';
                    }else{
                      $more='2';
                    }
                      for($i=0;$i<$count;$i++){   
                      
                       //$url = "http://v5.home3d.cn/home/wx/wx.php?uid=$row[uid]&do=feed&num=rand()&wxkey=".$fromUsername."&uid=".$row[uid]."&idtype=".$app_output->data->app[$i]->english;
                        $menusetcount=$app_output->data->app[$i]->count;
                        $idtype=$app_output->data->app[$i]->english;
                        $idtypeid=$idtype."id";
                        if($menusetcount=='1'&&$idtype!='dialog'&&$idtype!='dial'&&$idtype!='event'){
                        
                        $table="uchome_".$idtype;
                        $query = mysql_query("SELECT * FROM ".$table." WHERE uid=$row[uid]");
                        $value = mysql_fetch_array($query);
                        $id=$value["$idtypeid"];
                       $url = "http://v5.home3d.cn/home/wx/wx.php?do=detail&viewuid=$row[uid]&id=$id&uid=$row[uid]&wxkey=".$fromUsername."&idtype=$idtypeid&type=$idtype&moblieclicknum=$row[moblieclicknum]"; 
                        }elseif($idtype=='dialog'&&$row['uid']=='7136'){
                          $url ="http://wx.wsq.qq.com/196713929";
                        }else{
                          $url = "http://v5.home3d.cn/home/wx/wx.php?uid=$row[uid]&do=feed&num=rand()&wxkey=".$fromUsername."&uid=".$row[uid]."&idtype=".$app_output->data->app[$i]->english; 
                        }
                       /* if($menusetcount=='1'){
                       $url = "http://v5.home3d.cn/home/wx/wx.php?uid=$row[uid]&do=feed&num=rand()&wxkey=".$fromUsername."&uid=".$row[uid]."&idtype=".$app_output->data->app[$i]->english;
                       }else{
                        $id=$app_output->data->app[$i]->id;
                        $idtype=$app_output->data->app[$i]->english;
                        $idtypeid=$idtype."id";
                       $url = "http://v5.home3d.cn/home/wx/wx.php?do=detail&id=$id&uid=$row[uid]&idtype=$idtypeid&type=$idtype&moblieclicknum=$row[moblieclicknum]"; 
                       }*/
                       if($idtype=='dialog'&&$row['uid']=='7136'){
                           $subject="微医社区";
                       }else{
                          if($app_output->data->app[$i]->newname){
                           $subject=$app_output->data->app[$i]->newname;
                           }else{
                           $subject=$app_output->data->app[$i]->subject;
                         }
                       }
                       
                       if($app_output->data->app[$i]->image4url){
                       $pic="http://v5.home3d.cn/home/".$app_output->data->app[$i]->image4url;
                       }else{
                       $pic="http://v5.home3d.cn/home/".$app_output->data->app[$i]->image1url;
                     }

                       $articles[] = makeArticleItem($subject, $subject, $pic, $url); 
                      }
                      
                        
                    if($app_output->data->highapp){
                        $menusetcount=$app_output->data->highapp[$i]->count;
                        if($menusetcount=='1'){
                        $idtype=$app_output->data->highapp[$i]->english;
                        $idtypeid=$idtype."id";
                        $table="uchome_".$idtype;
                        $query = mysql_query("SELECT * FROM ".$table." WHERE uid=$row[uid]");
                        $value = mysql_fetch_array($query);
                        $id=$value["$idtypeid"];
                       $url = "http://v5.home3d.cn/home/wx/wx.php?do=detail&viewuid=$row[uid]&id=$id&uid=$row[uid]&wxkey=".$fromUsername."&idtype=$idtypeid&type=$idtype&moblieclicknum=$row[moblieclicknum]"; 
                        }else{
                       $url = "http://v5.home3d.cn/home/wx/wx.php?uid=$row[uid]&do=feed&num=rand()&wxkey=".$fromUsername."&uid=".$row[uid]."&idtype=".$app_output->data->highapp[0]->english;
                        }
                      
                      if($app_output->data->highapp[0]->newname){
                       $subject=$app_output->data->highapp[0]->newname;
                       }else{
                       $subject=$app_output->data->highapp[0]->subject;
                     }
                     if($app_output->data->highapp[0]->image4url){
                       $pic="http://v5.home3d.cn/home/".$app_output->data->highapp[0]->image4url;
                       }else{
                       $pic = "http://v5.home3d.cn/home/".$app_output->data->highapp[0]->image1url;
                     }
                      

                      $articles[] = makeArticleItem($subject, $subject, $pic, $url); 
                    }
                    if($more=='1'){
                        $subject="更多";
                        $url="http://v5.home3d.cn/home/wx/wx.php?uid=$row[uid]&do=home&num=rand()&wxkey=".$fromUsername;
                        $pic="http://v5.home3d.cn/home/./upload/menuset/small/menuset1379386329communicate.jpg";
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