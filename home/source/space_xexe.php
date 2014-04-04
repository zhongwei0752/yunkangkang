<?php
/*$file=file_get_contents("http://www.gzevergrandefc.com/team.aspx?target=first");
preg_match('/<div[^>]*class="jifenbang"[^>]*>(.*?) <\/div>/si',$file,$match);

//$a="<meta charset='UTF-8'>
	//<meta name='viewport' content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no'  /><link href='http://cs.sports.163.com/css/csl.css?r=1' rel='stylesheet' type='text/css'><style>body{background: #fff url() repeat-x left 30px;}.contentbottom{display:none;}.content1{display:none;}.dataTB2{width:100%;}</style>";
$a=$match[0];
print_r($file);*/
$abc=array(
	"action"=>'bang',
	"from"=>'other',
	"id"=>'170'
	);
$data = getHttpResponsePOST_m("http://www.gzevergrandefc.com/ajax/handler.ashx",$abc);

//echo json_encode($data);


function getHttpResponsePOST_m($url, $para = array('data2'=>'data2')){
$curl = curl_init($url);
curl_setopt($curl, CURLOPT_HEADER, 0 ); // 过滤HTTP头
curl_setopt($curl,CURLOPT_RETURNTRANSFER, 1);// 显示输出结果
curl_setopt($curl,CURLOPT_POST,true); // post传输数据
curl_setopt($curl,CURLOPT_POSTFIELDS,$para);// post传输数据
$responseText = curl_exec($curl);
//var_dump( curl_error($curl) );//如果执行curl过程中出现异常，可打开此开关，以便查看异常内容
curl_close($curl);

return $responseText;
}
include_once template("space_xexe");

?>