<?php

//数据库前缀(不需要加横杠，后面会自动补上)，一般是当前目录名字.框架模板默认使用‘weixin’。
define(DOCNAME, 'uchome_weixin');
//基本地址
define(BASE_URL, 'http://hotel.home3d.cn/weixin/hotel3');
//中文名
define(CNINESEAME, '天下楼盘');

//关于
define(ABOUT, "【关于本工具】\n" );
//用户最开始时，默认进行哪个模块
define(DEFAULT_MODE, 'FinalMode' );
//用户状态的有效期，单位是秒
define(EXPIRES_TIME, 3*24*60*60);
//每个模块的关键字定义
define(MODE_KEYWORDS, 
		json_encode(array(
			//详情
			'Details' => array(
				'详情',
				),
			//
			'News' => array(
				'新闻',
				),
			//
			'Style' => array(
				'房型',
				),
			//
			'Book' => array(
				'留言',
				),
			//
			'Oauth' => array(
				'check',
				),
			//
			'Reserve' => array(
				'预订',
				),
			//
			'Book' => array(
				'画册',
				),
			'Message' => array(
				'咨询',
				),
			'Bangding' => array(
				'绑定',
				),
			'Service' => array(
				'服务',
				),
			'Jituan' => array(
				'集团',
				),
			//假如指令没有进入前面的模块，则最后进入此模块
			'FinalMode' => array(
				'管理','菜单','关于','校庆','?','help','帮助','彩蛋',
				),
				
			))
		);

//菜单
define(MENU, 
"请输入【】内的指令，进入不同的功能模式：
【详情】：查看楼盘详情
【新闻】：查看楼盘新闻
【类型】：查看楼盘类型
【服务】：社区服务列表
【咨询】：咨询留言
【楼书】：查看楼书
【进度】：合同产证进度
【认证】：业主认证
【绑定】：绑定账号
	 ");
//每次操作成功后，返回的消息尾巴（会随机返回数组中的一条）
define(TIPS_TAILS, 
		json_encode(array(

			))
		);



//数据库信息定义
define(DB_HOST, 'localhost');
define(DB_USER, 'hotel');
define(DB_PWD, 'hotel#@!');
define(DB_NAME, '_hotel');


?>