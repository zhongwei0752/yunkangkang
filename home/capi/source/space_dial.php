<?php
	$query = $_SGLOBAL['db']->query("SELECT d.*,db.* FROM ".tname('dialbuy')." db LEFT JOIN ".tname('dial')." d ON db.dialid=d.dialid WHERE d.subject='$_REQUEST[id]'");
	while($value = $_SGLOBAL['db']->fetch_array($query)){
		$list[]=$value;
	}
	//capi_showmessage_by_data("未购买应用，请购买后再使用！");
	capi_showmessage_by_data("rest_success", 0, array('dial'=>$list));
?>