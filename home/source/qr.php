	<?php
		$uid=$_POST['uid'];
		$id=$_POST['id'];
		$qr=$_POST['qr'];
		if($qr){
			$post["message"] = "http://loaclhost/v5/home/space.php?uid=$uid&id=$id";
		}else{
			$post["message"] = "http://baidu.com";	
		}
	 	$url = "http://qrcode.cha-gang.com/index.php?action=show";
	    //$post["message"] ="";
	    $post["action"] = "show";
	    $post["submit-url"] = "1";
	    $post["fcolor"] = "000000";
	    $post["bcolor"] = "FFFFFF";
	    $post["scale"] = "undefined";
	    $post["ecc"] = "undefined";
	    $header = array(
			'Host:qrcode.cha-gang.com',
			'User-Agent:Mozilla/5.0 (Windows NT 5.1; rv:26.0) Gecko/20100101 Firefox/26.0',
			'Accept:*/*',
			'Accept-Language:zh-cn,zh;q=0.8,en-us;q=0.5,en;q=0.3',
			
			'Content-Type:application/x-www-form-urlencoded; charset=UTF-8',
			'X-Requested-With:XMLHttpRequest',
			'Referer:http://qrcode.cha-gang.com/',
			'Content-Length:110',
			'Connection:keep-alive',
			'Pragma:no-cache',
			'Cache-Control:no-cache'
		
);
	    $ch = curl_init($url);
	    //curl_setopt($ch, CURLOPT_COOKIEJAR, $this->cookie_dir);
	    curl_setopt($ch,CURLOPT_URL,$url);//抓取指定网页
	    curl_setopt($ch, CURLOPT_HEADER, 0);//设置header
	    curl_setopt($ch, CURLOPT_HTTPHEADER,$header);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
	    curl_setopt($ch, CURLOPT_POST, 1);//post提交方式
	    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
	    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.22 (KHTML, like Gecko) Chrome/25.0.1364.97 Safari/537.22');
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE); 
	    $data = curl_exec($ch);
	    echo($data);
	    curl_close($ch);
	?>