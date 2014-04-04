		<?php
		include_once(S_ROOT.'./wx/wx_common.php');
		include_once(S_ROOT.'./wx/Weixin.class.php');

		$fakeid='22479295';
		if($fakeid){

		$message="测试";
		$d = get_obj_by_xiaoquid('1');
		$info = $d->sendWXSingleMsg($fakeid,$message);
	}
	echo"2";
		?>