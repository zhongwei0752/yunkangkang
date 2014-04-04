<?php
/*
	[Ucenter Home] (C) 2007-2008 Comsenz Inc.
	$Id: config.new.php 9293 2008-10-30 06:44:42Z liguode $
*/

//Ucenter Home配置参数
$_SC = array();
$_SC['dbhost']  		= '58.215.187.8'; //服务器地址
$_SC['dbuser']  		= 'zhongwei'; //用户
$_SC['dbpw'] 	 		= '623610577'; //密码
$_SC['dbcharset'] 		= 'utf8'; //字符集
$_SC['pconnect'] 		= 0; //是否持续连接
$_SC['dbname']  		= 'zhongwei'; //数据库
$_SC['tablepre'] 		= 'uchome_'; //表名前缀
$_SC['charset'] 		= 'utf-8'; //页面字符集

$_SC['gzipcompress'] 	= 0; //启用gzip

$_SC['cookiepre'] 		= 'uchome_'; //COOKIE前缀
$_SC['cookiedomain'] 	= ''; //COOKIE作用域
$_SC['cookiepath'] 		= '/'; //COOKIE作用路径

$_SC['attachdir']		= './attachment/'; //附件本地保存位置(服务器路径, 属性 777, 必须为 web 可访问到的目录, 相对目录务必以 "./" 开头, 末尾加 "/")
$_SC['attachurl']		= 'attachment/'; //附件本地URL地址(可为当前 URL 下的相对地址或 http:// 开头的绝对地址, 末尾加 "/")

$_SC['siteurl']			= ''; //站点的访问URL地址(http:// 开头的绝对地址, 末尾加 "/")，为空的话，系统会自动识别。

$_SC['tplrefresh']		= 0; //判断模板是否更新的效率等级，数值越大，效率越高; 设置为0则永久不判断

//Ucenter Home安全相关
$_SC['founder'] 		= '1'; //创始人 UID, 可以支持多个创始人，之间使用 “,” 分隔。部分管理功能只有创始人才可操作。
$_SC['allowedittpl']	= 0; //是否允许在线编辑模板。为了服务器安全，强烈建议关闭

//应用的UCenter配置信息(可以到UCenter后台->应用管理->查看本应用->复制里面对应的配置信息进行替换)
define('UC_CONNECT', 'mysql');
define('UC_DBHOST', '58.215.187.8');
define('UC_DBUSER', 'zhongwei');
define('UC_DBPW', '623610577');
define('UC_DBNAME', 'zhongwei');
define('UC_DBCHARSET', 'utf8');
define('UC_DBTABLEPRE', '`zhongwei`.uc_');
define('UC_DBCONNECT', '0');
define('UC_KEY', '5aH1U4K1F4G1cbW7q5i9Q9c9T3heF852Vd7dz9MdQfg3V9F9Ud0fPdB3q2JbN8de');
define('UC_API', 'http://v5.home3d.cn/ucenter');
define('UC_CHARSET', 'utf-8');
define('UC_IP', '');
define('UC_APPID', '1');
define('UC_PPP', '20');

?>