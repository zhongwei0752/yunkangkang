<?php
if($_POST){
	foreach($_POST as $p => $o){
		updatetable("appset", array('orderid'=>$o),array('uid'=>$_SGLOBAL['supe_uid'],'num'=>$p));
	}
	showmessage("修改成功","space.php?do=menuset&view=me");
	}

?>