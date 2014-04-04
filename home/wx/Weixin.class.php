<?php
/**
*   微信操作独立类。
*/
class Weixin {
	private $username;  //用户名
	private $password;  //密码
	private $cookie_dir;  //cookies 文件保存路径
	private $apptoken;  //apptoken
	function __construct($username = '',$password = '')
	{
		# code...
		$this->username = $username ? $username :'2899164581@qq.com'; 
		$this->password = $password ? $password :'123456a';
		$cookie_dir = dirname(__FILE__).'/'.$this->username.'_cookies.txt';
		$this->cookie_dir =$cookie_dir;
		$this->tokenfile  = dirname(__FILE__).'/tmp_cookies/'.$this->username.'_token.txt';
		return $this->username;
	}

	//模拟数据登录网页版微信
	function loginwx(){
	 	$url = "https://mp.weixin.qq.com/cgi-bin/login?lang=zh_CN";
	    $post["username"] =$this->username ;
	    $post["pwd"] = md5($this->password);
	    $post["f"] = "json";
	    $post["imgcode"] = "";
	    $header = array(
			'Host:mp.weixin.qq.com',
			'User-Agent:Mozilla/5.0 (Windows NT 6.1; WOW64; rv:24.0) Gecko/20100101 Firefox/24.0',
			'Accept:application/json, text/javascript, */*; q=0.01',
			'Accept-Language:zh-cn,zh;q=0.8,en-us;q=0.5,en;q=0.3',
			'Accept-Encoding:gzip, deflate',
			'Content-Type:application/x-www-form-urlencoded; charset=UTF-8',
			'X-Requested-With:XMLHttpRequest',
			'Referer:https://mp.weixin.qq.com/',
			'Content-Length:80',
			'Connection:keep-alive',
			'Pragma:no-cache',
			'Cache-Control:no-cache'
		
);
	    $ch = curl_init($url);
	    curl_setopt($ch, CURLOPT_COOKIEJAR, $this->cookie_dir);
	    curl_setopt($ch,CURLOPT_URL,$url);//抓取指定网页
	    curl_setopt($ch, CURLOPT_HEADER, 1);//设置header
	    curl_setopt($ch, CURLOPT_HTTPHEADER,$header);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
	    curl_setopt($ch, CURLOPT_POST, 1);//post提交方式
	    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
	    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.22 (KHTML, like Gecko) Chrome/25.0.1364.97 Safari/537.22');
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE); 
	    $data = curl_exec($ch);
	    $data = curl_exec($ch);
	    //var_dump($data);		
	    curl_close($ch);
		//把写好的cookies重新读出来，去掉多余的'#HttpOnly_'字符
		$cooky = file_get_contents($this->cookie_dir);
		$cooky = str_replace('#HttpOnly_', '', $cooky);
		file_put_contents($this->cookie_dir, $cooky);

		preg_match_all('({([\w\W]*?)})',trim($data),$matches); 
		$data = json_decode($matches[0][0]);
		$data = (array)$data;
		parse_str($data['ErrMsg'], $output);
		$this->apptoken = $output['token'];
		//保存token到文件
		if($this->apptoken){
			$ex_time = time()+12*60*60;
			$string = $this->apptoken."\r\n".$ex_time;
			file_put_contents($this->tokenfile,$string);
		}
	    return $data;
	}

	//检测微信登录状态，如果未登录则调用this->loginwx();
	function checkwxlogin(){
		$string = @file_get_contents($this->tokenfile);
		$ary = explode("\r\n", $string);
		$token = $ary[0];
		$time = $ary[1];
		if ($time > time() ) {
			return $this->apptoken = $token ? $token  : '';
		}
		else return $this->loginwx();
	}

	//主动推送文本消息
	function sendWXSingleMsg($tofakeid, $msg){
	    $this->checkwxlogin();
	    $url = "https://mp.weixin.qq.com/cgi-bin/singlesend?t=ajax-response&lang=zh_CN&token=".$this->apptoken;
	    $post = array();
		$post['tofakeid'] = $tofakeid;
		$post['type'] = 1;
		$post['content'] = $msg;
		$post['ajax'] = 1;
		$post['error'] = 'false';
		$post['t'] = 'ajax-response';
		$post['lang'] = 'zh_CN';
		$post['token'] = $this->apptoken;
		$header = array(
			'Accept: */*',
			'Accept-Charset: GBK,utf-8;q=0.7,*;q=0.3',
			'Accept-Encoding: gzip,deflate,sdch',
			'Accept-Language: zh-CN,zh;q=0.8',
			'Connection: keep-alive',
			'Content-Type: application/x-www-form-urlencoded; charset=UTF-8',
			'Host: mp.weixin.qq.com',
			'Origin: https://mp.weixin.qq.com',
			'Referer:https://mp.weixin.qq.com/cgi-bin/singlesendpage?tofakeid='.$tofakeid.'&t=message/send&action=index&token='.$this->apptoken.'&lang=zh_CN',
			'X-Requested-With: XMLHttpRequest'  
		);
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_COOKIEFILE, $this->cookie_dir);
		curl_setopt($ch,CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_HTTPHEADER,$header);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 		//Tell curl to write the response to a variable   
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
		curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.22 (KHTML, like Gecko) Chrome/25.0.1364.97 Safari/537.22');
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		$data = curl_exec($ch);
		curl_close($ch);
		$ary = json_decode($data, true);
		return $ary;
	}
	//根据fakeid获取用户信息
	function get_userinfo_by_fakeid($fakeid){
	    $this->checkwxlogin();
		$url = "https://mp.weixin.qq.com/cgi-bin/getcontactinfo?t=ajax-getcontactinfo&lang=zh_CN&fakeid={$fakeid}&token=".$this->apptoken;
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_COOKIEFILE, $this->cookie_dir);
		curl_setopt($ch,CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 		//Tell curl to write the response to a variable 
		curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.22 (KHTML, like Gecko) Chrome/25.0.1364.97 Safari/537.22');
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE); 
		$data = curl_exec($ch);
		$ary = json_decode($data, true);
		return $ary;
	}
	//获取最新关注的一个用户的信息
	function getNewWXUser(){
		$this->checkwxlogin();
		$url = "https://mp.weixin.qq.com/cgi-bin/contactmanage?t=user/index&pagesize=1&pageidx=0&type=0&groupid=0&token={$this->apptoken}&lang=zh_CN";
		$ch = curl_init();    
		curl_setopt($ch, CURLOPT_URL,$url);     
		curl_setopt($ch, CURLOPT_HEADER, 0);    
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
		curl_setopt($ch, CURLOPT_COOKIEFILE, $this->cookie_dir);
		curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.22 (KHTML, like Gecko) Chrome/25.0.1364.97 Safari/537.22');
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);  
		$data = curl_exec($ch);      
		curl_close($ch);
		$tmp=explode('"contacts":[',$data);
		$tmp=explode("]})",$tmp[1]);
		$row=json_decode($tmp[0] , 1 );
		return $row;
	}

	//获取最新关注的一个用户的信息
	/*function getNewWXUser(){
		$this->checkwxlogin();
		$url = "https://mp.weixin.qq.com/cgi-bin/contactmanagepage?t=wxm-friend&lang=zh_CN&pagesize=1&pageidx=0&type=0&groupid=0&token=".$this->apptoken;
		$ch = curl_init();    
		curl_setopt($ch, CURLOPT_URL,$url);     
		curl_setopt($ch, CURLOPT_HEADER, 0);    
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
		curl_setopt($ch, CURLOPT_COOKIEFILE, $this->cookie_dir);
		curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.22 (KHTML, like Gecko) Chrome/25.0.1364.97 Safari/537.22');
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);  
		$data = curl_exec($ch);      
		curl_close($ch);
		preg_match_all('(<script id="json-friendList" type="json/text">([\w\W]*?)</script>)',trim($data),$matches); 
		$data = $matches[1];
		$data = json_decode($data[0]);
		$data = (array)$data[0];
		return $data;
	}*/
	//网上抓取fakeid
	function getUser(){
		$this->checkwxlogin();
		$url = "https://mp.weixin.qq.com/cgi-bin/home?t=home/index&lang=zh_CN&token=".$this->apptoken;
		$ch = curl_init();    
		curl_setopt($ch, CURLOPT_URL,$url);     
		curl_setopt($ch, CURLOPT_HEADER, 0);    
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
		curl_setopt($ch, CURLOPT_COOKIEFILE, $this->cookie_dir);
		curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:24.0) Gecko/20100101 Firefox/24.0');
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);  
		$data = curl_exec($ch);      
		curl_close($ch);
		preg_match_all("/<img src=\"\/cgi-bin\/getheadimg\?fakeid=(.*)&/isU",trim($data),$matches);
        preg_match_all('/<img[^>]*>/Ui', $matches[1], $match2);
		//preg_match_all('/<img[^>]*>/Ui', $matches[1], $match2);
		//preg_match_all('/<img[ ]*src=["\']?([^"\' ><]+)/i',$matches[1],$matches1);  
		//print_r($matches[1]);
		$data = $matches[1];

		//$data = json_decode($data[0]);
		  $data = json_decode($data[0]);
          $data=json_decode($data);
		//$data=$this->apptoken;

		//$data = (array)$data[0];
		return $data;
	}
	//本地抓取slave_user
	function GetId(){
		$url = "https://mp.weixin.qq.com/cgi-bin/getcontactinfo?t=ajax-getcontactinfo&lang=zh_CN&fakeid=&token=".$this->apptoken;
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_COOKIEFILE, $this->cookie_dir);
		curl_setopt($ch,CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_HEADER, 0);//设置header
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
		curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.22 (KHTML, like Gecko) Chrome/25.0.1364.97 Safari/537.22');
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE); 
		$data = curl_exec($ch);
		curl_close($ch);
		$result = json_decode($data,1);
		
				$data = $this->loginwx();
				//把写好的cookies重新读出来，去掉多余的'#HttpOnly_'字符
				$cooky = file_get_contents($this->cookie_dir);
				preg_match_all("/	TRUE	0	slave_user(.*)/",trim($cooky),$matches);
				$data = $matches[1];
				return $data;
		
	}


}
?>