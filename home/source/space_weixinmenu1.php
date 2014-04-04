<?php
/*
	[UCenter Home] (C) 2007-2008 Comsenz Inc.
	$Id: space_wall.php 12880 2009-07-24 07:20:24Z liguode $
*/

if(!defined('IN_UCHOME')) {
	exit('Access Denied');
}
if($_POST['fristsubmit']){
	if(empty($_POST['button1'])&&empty($_POST['button2'])||empty($_POST['button2'])&&empty($_POST['button3'])||empty($_POST['button1'])&&empty($_POST['button3'])){
		showmessage("至少填写2项一级菜单");
	}
	if(strlen($_POST['button1'])>16||strlen($_POST['button2'])>16||strlen($_POST['button3'])>16){
	showmessage("一级菜单文字过长");
}
		if(strlen($_POST['sub_button1'])>16||strlen($_POST['sub_button2'])>16||strlen($_POST['sub_button3'])>16||strlen($_POST['sub_button4'])>16||strlen($_POST['sub_button5'])>16){
	showmessage("一级菜单文字过长");
}
	//左侧菜单情况
	if($_POST['button1']){
	$dataarr1=array(
		'button'     => $_POST['button1'],
		'sub_button1'=> $_POST['1sub_button1'],
		'sub_button2'=> $_POST['1sub_button2'],
		'sub_button3'=> $_POST['1sub_button3'],
		'sub_button4'=> $_POST['1sub_button4'],
		'sub_button5'=> $_POST['1sub_button5'],
		'fathernum'  => '1',
		'uid'        => $_SGLOBAL['supe_uid'],
		'function'  => $_POST['function1'],
		'sub_function1'=> $_POST['1sub_function1'],
		'sub_function2'=> $_POST['1sub_function2'],
		'sub_function3'=> $_POST['1sub_function3'],
		'sub_function4'=> $_POST['1sub_function4'],
		'sub_function5'=> $_POST['1sub_function5']

	);	
	inserttable("weixinmenu",$dataarr1);
	}
	//中间菜单情况
	if($_POST['button2']){
	$dataarr2=array(
		'button'     => $_POST['button2'],
		'sub_button1'=> $_POST['2sub_button1'],
		'sub_button2'=> $_POST['2sub_button2'],
		'sub_button3'=> $_POST['2sub_button3'],
		'sub_button4'=> $_POST['2sub_button4'],
		'sub_button5'=> $_POST['2sub_button5'],
		'fathernum'  => '2',
		'uid'        => $_SGLOBAL['supe_uid'],
		'function'  => $_POST['function2'],
		'sub_function1'=> $_POST['2sub_function1'],
		'sub_function2'=> $_POST['2sub_function2'],
		'sub_function3'=> $_POST['2sub_function3'],
		'sub_function4'=> $_POST['2sub_function4'],
		'sub_function5'=> $_POST['2sub_function5']
	);	
	inserttable("weixinmenu",$dataarr2);
	}
	//右侧菜单情况
		if($_POST['button3']){
	$dataarr3=array(
		'button'     => $_POST['button3'],
		'sub_button1'=> $_POST['3sub_button1'],
		'sub_button2'=> $_POST['3sub_button2'],
		'sub_button3'=> $_POST['3sub_button3'],
		'sub_button4'=> $_POST['3sub_button4'],
		'sub_button5'=> $_POST['3sub_button5'],
		'fathernum'  => '3',
		'uid'        => $_SGLOBAL['supe_uid'],
		'function'  => $_POST['function3'],
		'sub_function1'=> $_POST['3sub_function1'],
		'sub_function2'=> $_POST['3sub_function2'],
		'sub_function3'=> $_POST['3sub_function3'],
		'sub_function4'=> $_POST['3sub_function4'],
		'sub_function5'=> $_POST['3sub_function5']
	);	
	inserttable("weixinmenu",$dataarr3);
	}
	showmessage("提交成功","space.php?do=weixinmenu");
}

if($_POST['functionweixin']){
	$function=$_POST['province'].".".$_POST['city'];
	$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('weixinmenutop')."  WHERE uid='$_SGLOBAL[supe_uid]' and type='$_POST[type]'");
	$value = $_SGLOBAL['db']->fetch_array($query);
	if($value){
		if($_POST['fathernum']){
		updatetable("weixinmenu",array("$_POST[button]"=>$function),array('uid'=>$_SGLOBAL['supe_uid'],'fathernum'=>"$_POST[fathernum]"));	
		}else{
		updatetable("weixinmenutop",array('number'=>$function),array('uid'=>$_SGLOBAL['supe_uid'],'type'=>"$_POST[type]"));
	}
	}else{
		inserttable("weixinmenutop",array('number'=>$function,'uid'=>$_SGLOBAL['supe_uid'],'type'=>"$_POST[type]"));
	}
}

if($_POST['secondsubmit']){

	$dataarr1=array(
		'button'     => $_POST['button1'],
		'sub_button1'=> $_POST['1sub_button1'],
		'sub_button2'=> $_POST['1sub_button2'],
		'sub_button3'=> $_POST['1sub_button3'],
		'sub_button4'=> $_POST['1sub_button4'],
		'sub_button5'=> $_POST['1sub_button5'],
		'function'  => $_POST['function1']
	);	
	//中间菜单情况
	$dataarr2=array(
		'button'     => $_POST['button2'],
		'sub_button1'=> $_POST['2sub_button1'],
		'sub_button2'=> $_POST['2sub_button2'],
		'sub_button3'=> $_POST['2sub_button3'],
		'sub_button4'=> $_POST['2sub_button4'],
		'sub_button5'=> $_POST['2sub_button5'],
		'function'  => $_POST['function2']
	);	
	//右侧菜单情况
	$dataarr3=array(
		'button'     => $_POST['button3'],
		'sub_button1'=> $_POST['3sub_button1'],
		'sub_button2'=> $_POST['3sub_button2'],
		'sub_button3'=> $_POST['3sub_button3'],
		'sub_button4'=> $_POST['3sub_button4'],
		'sub_button5'=> $_POST['3sub_button5'],
		'function'  => $_POST['function3']

	);	
	updatetable("weixinmenu",$dataarr1,array('fathernum'=>'1','uid'=>$_SGLOBAL['supe_uid']));
	updatetable("weixinmenu",$dataarr2,array('fathernum'=>'2','uid'=>$_SGLOBAL['supe_uid']));
	updatetable("weixinmenu",$dataarr3,array('fathernum'=>'3','uid'=>$_SGLOBAL['supe_uid']));
	}

$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('weixinmenu')."  WHERE uid='$_SGLOBAL[supe_uid]' order by fathernum ASC");
while ($value = $_SGLOBAL['db']->fetch_array($query)) {
	$list[]=$value;
	}
$query1 = $_SGLOBAL['db']->query("SELECT * FROM ".tname('menuset')."");
	while ($value1 = $_SGLOBAL['db']->fetch_array($query1)) {
		
			$list1[] = $value1;
		}

$query2 = $_SGLOBAL['db']->query("SELECT * FROM ".tname('weixinmenutop')." where uid='$_SGLOBAL[supe_uid]' and type='image'");
$value2 = $_SGLOBAL['db']->fetch_array($query2);
$query3 = $_SGLOBAL['db']->query("SELECT * FROM ".tname('weixinmenutop')." where uid='$_SGLOBAL[supe_uid]' and type='frist'");
$value3 = $_SGLOBAL['db']->fetch_array($query3);
$query4 = $_SGLOBAL['db']->query("SELECT * FROM ".tname('weixinmenutop')." where uid='$_SGLOBAL[supe_uid]' and type='second'");
$value4 = $_SGLOBAL['db']->fetch_array($query4);
$count='1';
	for($i='0';$i<'6';$i++){
		$name="sub_button".$i;
		if($list[0]["$name"]){
			$count++;
		}
	}
$count1='1';
	for($i='0';$i<'6';$i++){
		$name="sub_button".$i;
		if($list[1]["$name"]){
			$count1++;
		}
	}
$count2='1';
	for($i='0';$i<'6';$i++){
		$name="sub_button".$i;
		if($list[2]["$name"]){
			$count2++;
		}
	}		
include_once template("space_weixinmenu");

?>