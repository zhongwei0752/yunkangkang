<?php
$_CACHE['apps'] = array (
  1 => 
  array (
    'appid' => '1',
    'type' => 'UCHOME',
    'name' => '个人家园',
    'url' => 'http://localhost/v5/home',
    'authkey' => '5aH1U4K1F4G1cbW7q5i9Q9c9T3heF852Vd7dz9MdQfg3V9F9Ud0fPdB3q2JbN8de',
    'ip' => '',
    'viewprourl' => '',
    'apifilename' => 'uc.php',
    'charset' => 'utf-8',
    'dbcharset' => 'utf8',
    'synlogin' => '1',
    'recvnote' => '1',
    'extra' => 
    array (
      'apppath' => '',
    ),
    'tagtemplates' => '<?xml version="1.0" encoding="ISO-8859-1"?>
<root>
 <item id="template"><![CDATA[<a href="{url}" target="_blank">{subject}</a>]]></item>
 <item id="fields">
 <item id="subject"><![CDATA[日志标题]]></item>
 <item id="uid"><![CDATA[用户 ID]]></item>
 <item id="username"><![CDATA[用户名]]></item>
 <item id="dateline"><![CDATA[日期]]></item>
 <item id="spaceurl"><![CDATA[空间地址]]></item>
 <item id="url"><![CDATA[日志地址]]></item>
 </item>
</root>',
  ),
  2 => 
  array (
    'appid' => '2',
    'type' => 'DISCUZ',
    'name' => 'Discuz!',
    'url' => 'http://localhost/upload/bbs',
    'authkey' => 'Z9r9S2u45bK8pfefT0ebx3E4Bay13fU8Sfj2L8X2mbD7Nb99L5q9AaidZ9VeA2Ef',
    'ip' => '',
    'viewprourl' => '',
    'apifilename' => 'uc.php',
    'charset' => 'utf-8',
    'dbcharset' => 'utf8',
    'synlogin' => '1',
    'recvnote' => '1',
    'extra' => '',
    'tagtemplates' => '<?xml version="1.0" encoding="ISO-8859-1"?>
<root>
 <item id="template"><![CDATA[<a href="{url}" target="_blank">{subject}</a>]]></item>
 <item id="fields">
 <item id="subject"><![CDATA[标题]]></item>
 <item id="uid"><![CDATA[用户 ID]]></item>
 <item id="username"><![CDATA[发帖者]]></item>
 <item id="dateline"><![CDATA[日期]]></item>
 <item id="url"><![CDATA[主题地址]]></item>
 </item>
</root>',
  ),
  3 => 
  array (
    'appid' => '3',
    'type' => 'ECMALL',
    'name' => 'xiaoshangcheng',
    'url' => 'http://localhost/ecmall/upload',
    'authkey' => 'odC6V7ibeeQ8A9bbD1e9i1K1A902z1icN1D8aeqaecD3zf0cx4x8l7l7528cuaz9',
    'ip' => '',
    'viewprourl' => '',
    'apifilename' => 'uc.php',
    'charset' => 'utf-8',
    'dbcharset' => 'utf-8',
    'synlogin' => '1',
    'recvnote' => '1',
    'extra' => '',
    'tagtemplates' => '<?xml version="1.0" encoding="ISO-8859-1"?>
<root>
 <item id="template"><![CDATA[<dl><dt>{goods_name}</dt><dd><a href="{url}"><img src="{image}"></a></dd><dd>{goods_price}</dd></dl>]]></item>
 <item id="fields">
 <item id="goods_name"><![CDATA[商品名称]]></item>
 <item id="uid"><![CDATA[用户ID]]></item>
 <item id="username"><![CDATA[用户名]]></item>
 <item id="dateline"><![CDATA[日期]]></item>
 <item id="url"><![CDATA[URL地址]]></item>
 <item id="image"><![CDATA[图片]]></item>
 <item id="goods_price"><![CDATA[商品价格]]></item>
 </item>
</root>',
  ),
);

?>