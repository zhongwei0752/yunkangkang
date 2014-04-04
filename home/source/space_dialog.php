<?php
	/*
	 * 在线沟通组件
	 * 这里处理两个页面：All dialog list    Dialog in detail and chat 
	 * ?do=dialog       ?do=dialog&dialog=
	 * 
	 * */
	 
	 //处理   URL 信息
	 $do = $_GET['do'];
	 $dialogid = empty($_GET['dialog'])?0:intval($_GET['dialog']);
	 
	 //绑定客服
	$query2 = $_SGLOBAL['db']->query("SELECT s.* FROM  ".tname('friend')." main LEFT JOIN ".tname('space')." s ON s.uid=main.fuid where s.name like '%$keywords%' and main.uid='$space[uid]' AND main.status='1' ORDER BY main.dateline DESC"); 

	while ($value = $_SGLOBAL['db']->fetch_array($query2)) {
				$list1[]=$value;


		}
		if($_POST['recomendweixin']){
			$recomendman=$_POST['recomendman'];
			$push1=$_POST['push1'];
			
		if($push1){
			$query = $_SGLOBAL['db']->query("select * from ".tname("space")."  where fakeid='$push1'");
			$value = $_SGLOBAL['db']->fetch_array($query);
			updatetable("space",array('service'=>$value['uid']),array('uid'=>$_SGLOBAL['supe_uid']));
		}
		if($recomendman){
			updatetable("space",array('service'=>$recomendman),array('uid'=>$_SGLOBAL['supe_uid']));
		}
			
			showmessage("提交成功","space.php?do=dialog");
		}
	 //alias
	 $DB = $_SGLOBAL['db'];
	 //var_dump($dialogid);
	 $not_in_space = 0;
	 //处理主要页面逻辑
	 if ($dialogid) {
		//Dialog in detail and chat
		$query = $DB->query("SELECT * FROM ".tname("dialog")." as d left  join ".tname("space")." as s on d.uid =s.uid where d.dialogid = $dialogid order by d.dialog_dateline DESC");
		
		while($value = $DB->fetch_array($query)){
			$value['dialog_dateline'] = date('Y-m-d H:i:s', $value['dialog_dateline']);
			$res[] = $value;
			
		}
		
		$list = $res;
		$query = $DB->query("select * from ".tname("questions")." as q left join ".tname("space")." as s on q.q_uid=s.uid where q.id = $dialogid");
		while($value = $DB->fetch_array($query)){
			$value['q_dateline'] = date('Y-m-d H:i:s', $value['q_dateline']);
			$q = $value;
		}
		
		include_once template("space_dialog_view");
		
	 }else {
	 	//All dialog list
	 	$query = $DB->query("select * from ".tname("questions")." d where d.askid='$space[uid]' ORDER BY d.q_dateline DESC");
		$cnt = 0;
		while($value = $DB->fetch_array($query)){
			$value['num'] = $cnt++;
			$res[] = $value;
			
			$res1 = array();
			$q = $DB->query("select * from ".tname("dialog")." as d left join ".tname("space")." as s on d.uid = s.uid where d.dialogid = '$value[id]' order by d.dialog_dateline DESC limit 0,2");
			while($val = $DB->fetch_array($q)){
				$res1[] = $val;
			}
			$clist[] = $res1;
		}
		$list = $res;
		
		
		//var_dump($clist);
	 	include_once template("space_dialog_list");
	 }
	 
?>