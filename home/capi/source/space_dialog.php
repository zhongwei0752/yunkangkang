<?php
	/*
	 * 在线沟通组件
	 * 这里处理两个页面：All dialog list    Dialog in detail and chat 
	 * ?do=communicate       ?do=communicate&dialog=
	 * capi
	 * 
	 * */
	 
	 //处理   URL 信息
	 $do = $_REQUEST['do'];
	 $dialogid = empty($_REQUEST['dialog'])?0:intval($_REQUEST['dialog']);
	 
	 
	 //alias
	 $DB = $_SGLOBAL['db'];
	 //var_dump($dialogid);
	 $not_in_space = 0;
	 //处理主要页面逻辑
	 if ($dialogid) {
		//Dialog in detail and chat
		$query = $DB->query("SELECT * FROM ".tname("dialog")."  where dialogid = $dialogid order by dialog_dateline desc");
		
		while($value = $DB->fetch_array($query)){
			$value['dialog_dateline'] = date('Y-m-d H:i:s', $value['dialog_dateline']);
			$uid=$value['nameuid'];
			$space=getspace($uid);
			$value['name']=$space['name'];
			$value['image1url']=$space['image1url'];
			$res[] = $value;
			
		}
		
		$list = $res;
		
		$query = $DB->query("select * from ".tname("questions")." as q left join ".tname("space")." as s on q.q_uid=s.uid where q.id = $dialogid and q.status!='sixin'");
		while($value = $DB->fetch_array($query)){
			$value['q_dateline'] = date('Y-m-d H:i:s', $value['q_dateline']);
			$q = $value;
		}
		capi_showmessage_by_data("rest_success", 0, array('list'=>$list,'q'=>$q));
		include_once template("space_dialog_view");
		
	 }else {
	 	//All dialog list
	 	$query = $DB->query("select * from ".tname("questions")." d where d.askid='$space[uid]' and d.status!='sixin' order by d.q_dateline DESC LIMIT 0,30");
		$cnt = 0;
		while($value = $DB->fetch_array($query)){
			$value['num'] = $cnt++;
			$value['newdateline'] = date('Y-m-d H:i:s', $value['q_dateline']);
			$space=getspace($value['q_uid']);
			
			if(empty($space['name'])){
				$value['name'] = $space['username'];
			}else{
				$value['name'] = $space['name'];
			}
			$res[] = $value;
			
			$res1 = array();
			$q = $DB->query("select * from ".tname("dialog")." as d left join ".tname("space")." as s on d.uid = s.uid where d.dialogid = '$value[id]' order by d.dialog_dateline desc limit 0,2");
			while($val = $DB->fetch_array($q)){
				$res1[] = $val;
			}
			$clist[] = $res1;
		}
		$list = $res;
		capi_showmessage_by_data("rest_success", 0, array('list'=>$list,'clist'=>$clist));
		
		//var_dump($clist);
	 	include_once template("space_dialog_list");
	 }
	 
?>