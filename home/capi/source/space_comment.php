<?php
	$page = empty($_REQUEST['page'])?1:intval($_REQUEST['page']);
	if($page<1) $page=1;
	$perpage = $_REQUEST['perpage'];
	$perpage = mob_perpage($perpage);
	
	if(empty($perpage)) $perpage=10;
	$start = ($page-1)*$perpage;

	$count = $_SGLOBAL['db']->result($_SGLOBAL['db']->query("SELECT COUNT(*) FROM ".tname('comment')." WHERE id='$_REQUEST[id]' AND idtype='$_REQUEST[idtype]'"), 0);
	$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('comment')." WHERE id='$_REQUEST[id]' AND idtype='$_REQUEST[idtype]' ORDER BY dateline DESC LIMIT $start,$perpage");
	while ($value = $_SGLOBAL['db']->fetch_array($query)) {
			$value["authoravatar"] = capi_avatar($value["authorid"]);
		    $value["message"] = capi_fhtml($value["message"]);
			$list[]=$value;

	}
	capi_showmessage_by_data("rest_success", 0, array('comment'=>$list, 'commentcount'=>$count));
?>