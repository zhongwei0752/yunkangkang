<?php
include_once('./common.php');
	 $xmldata = file_get_contents("php://input"); 
	 $c=explode("|",$xmldata);
	inserttable("blog",array("test"=>$c['0'],'subject'=>$c['1']));
	?>