<?php
/*
	[UCenter Home] (C) 2007-2008 Comsenz Inc.
	$Id: space_wall.php 12880 2009-07-24 07:20:24Z liguode $
*/

if(!defined('IN_UCHOME')) {
	exit('Access Denied');
}

if($_POST['fristsubmit']){
		if(empty($_POST['button1'])||empty($_POST['button2'])||empty($_POST['button3'])){
		showmessage("请先填好三个一级菜单在做其他操作！");
	}
	if(strlen($_POST['button1'])>16||strlen($_POST['button2'])>16||strlen($_POST['button3'])>16){
	showmessage("一级菜单文字过长");
}
		if(strlen($_POST['sub_button1'])>16||strlen($_POST['sub_button2'])>16||strlen($_POST['sub_button3'])>16||strlen($_POST['sub_button4'])>16||strlen($_POST['sub_button5'])>16){
	showmessage("一级菜单文字过长");
}
	if($_FILES["file1"]["name"]){
			include("./source/upload4.class.php");
  			$image= new upload;
  			$image->upload_file($_SGLOBAL['supe_uid'],"weixinmenutop");
  		}
  	if($_POST['focusname']){
  		$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('weixinmenutop')." where uid='$_SGLOBAL[supe_uid]' and type='image'");
		$value = $_SGLOBAL['db']->fetch_array($query);
					if($value){
  					updatetable("weixinmenutop", array('name'=>$_POST['focusname']), array('uid'=>$_SGLOBAL['supe_uid'],'type'=>'image'));
  					}else{
  					inserttable("weixinmenutop",array('name'=>$_POST['focusname'],'uid'=>$_SGLOBAL['supe_uid'],'type'=>'image'));	
  					}
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
		'uid'        => $_SGLOBAL['supe_uid']

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
		'uid'        => $_SGLOBAL['supe_uid']
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
		'uid'        => $_SGLOBAL['supe_uid']

	);	
	inserttable("weixinmenu",$dataarr3);
	}
	showmessage("提交成功","space.php?do=weixinmenu");
}

if($_POST['functionweixin']){
	
	if(empty($_POST['province'])&&empty($_POST['link'])){
		showmessage("推送信息不能全为空");
	}
	if($_POST['province']){
	$function=$_POST['province'].".".$_POST['city'];	
	}
	if($_POST['link']){
	$function="url#".$_POST['link'];
	}
	if($function){
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
}

if($_POST['appweixin']){
	$appid=$_POST['appid'];
	$appsecret=$_POST['appsecret'];
	if($appid && $appsecret){
		updatetable("space",array('appid'=>$appid,'appsecret'=>$appsecret),array('uid'=>$_SGLOBAL['supe_uid']));
		showmessage("发布成功","space.php?do=weixinmenu");
	}else{
		showmessage("appid和appsecret不能为空","space.php?do=weixinmenu");
	}
}

if($_POST['secondsubmit']){
	if($_FILES["file1"]["name"]){
			include("./source/upload4.class.php");
  			$image= new upload;
  			$image->upload_file($_SGLOBAL['supe_uid'],"weixinmenutop");
  		}
  	if($_POST['focusname']){
  		$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('weixinmenutop')." where uid='$_SGLOBAL[supe_uid]' and type='image'");
		$value = $_SGLOBAL['db']->fetch_array($query);
					if($value){
  					updatetable("weixinmenutop", array('name'=>$_POST['focusname']), array('uid'=>$_SGLOBAL['supe_uid'],'type'=>'image'));
  					}else{
  					inserttable("weixinmenutop",array('name'=>$_POST['focusname'],'uid'=>$_SGLOBAL['supe_uid'],'type'=>'image'));	
  					}
  	}
	$dataarr1=array(
		'button'     => $_POST['button1'],
		'sub_button1'=> $_POST['1sub_button1'],
		'sub_button2'=> $_POST['1sub_button2'],
		'sub_button3'=> $_POST['1sub_button3'],
		'sub_button4'=> $_POST['1sub_button4'],
		'sub_button5'=> $_POST['1sub_button5']
	);	
	//中间菜单情况
	$dataarr2=array(
		'button'     => $_POST['button2'],
		'sub_button1'=> $_POST['2sub_button1'],
		'sub_button2'=> $_POST['2sub_button2'],
		'sub_button3'=> $_POST['2sub_button3'],
		'sub_button4'=> $_POST['2sub_button4'],
		'sub_button5'=> $_POST['2sub_button5']
	);	
	//右侧菜单情况
	$dataarr3=array(
		'button'     => $_POST['button3'],
		'sub_button1'=> $_POST['3sub_button1'],
		'sub_button2'=> $_POST['3sub_button2'],
		'sub_button3'=> $_POST['3sub_button3'],
		'sub_button4'=> $_POST['3sub_button4'],
		'sub_button5'=> $_POST['3sub_button5'],


	);
	if(empty($_POST['1sub_button1'])){
		updatetable("weixinmenu",array('sub_function1'=>""),array('fathernum'=>'1','uid'=>$_SGLOBAL['supe_uid']));
	}
	if(empty($_POST['1sub_button2'])){
		updatetable("weixinmenu",array('sub_function2'=>""),array('fathernum'=>'1','uid'=>$_SGLOBAL['supe_uid']));
	}
	if(empty($_POST['1sub_button3'])){
		updatetable("weixinmenu",array('sub_function3'=>""),array('fathernum'=>'1','uid'=>$_SGLOBAL['supe_uid']));
	}
	if(empty($_POST['1sub_button4'])){
		updatetable("weixinmenu",array('sub_function4'=>""),array('fathernum'=>'1','uid'=>$_SGLOBAL['supe_uid']));
	}
	if(empty($_POST['1sub_button5'])){
		updatetable("weixinmenu",array('sub_function5'=>""),array('fathernum'=>'1','uid'=>$_SGLOBAL['supe_uid']));
	}
	if(empty($_POST['2sub_button1'])){
		updatetable("weixinmenu",array('sub_function1'=>""),array('fathernum'=>'2','uid'=>$_SGLOBAL['supe_uid']));
	}
	if(empty($_POST['2sub_button2'])){
		updatetable("weixinmenu",array('sub_function2'=>""),array('fathernum'=>'2','uid'=>$_SGLOBAL['supe_uid']));
	}
	if(empty($_POST['2sub_button3'])){
		updatetable("weixinmenu",array('sub_function3'=>""),array('fathernum'=>'2','uid'=>$_SGLOBAL['supe_uid']));
	}
	if(empty($_POST['2sub_button4'])){
		updatetable("weixinmenu",array('sub_function4'=>""),array('fathernum'=>'2','uid'=>$_SGLOBAL['supe_uid']));
	}
	if(empty($_POST['2sub_button5'])){
		updatetable("weixinmenu",array('sub_function5'=>""),array('fathernum'=>'2','uid'=>$_SGLOBAL['supe_uid']));
	}
	if(empty($_POST['3sub_button1'])){
		updatetable("weixinmenu",array('sub_function1'=>""),array('fathernum'=>'3','uid'=>$_SGLOBAL['supe_uid']));
	}
	if(empty($_POST['3sub_button2'])){
		updatetable("weixinmenu",array('sub_function2'=>""),array('fathernum'=>'3','uid'=>$_SGLOBAL['supe_uid']));
	}
	if(empty($_POST['3sub_button3'])){
		updatetable("weixinmenu",array('sub_function3'=>""),array('fathernum'=>'3','uid'=>$_SGLOBAL['supe_uid']));
	}
	if(empty($_POST['3sub_button4'])){
		updatetable("weixinmenu",array('sub_function4'=>""),array('fathernum'=>'3','uid'=>$_SGLOBAL['supe_uid']));
	}
	if(empty($_POST['3sub_button5'])){
		updatetable("weixinmenu",array('sub_function5'=>""),array('fathernum'=>'3','uid'=>$_SGLOBAL['supe_uid']));
	}	
	updatetable("weixinmenu",$dataarr1,array('fathernum'=>'1','uid'=>$_SGLOBAL['supe_uid']));
	updatetable("weixinmenu",$dataarr2,array('fathernum'=>'2','uid'=>$_SGLOBAL['supe_uid']));
	updatetable("weixinmenu",$dataarr3,array('fathernum'=>'3','uid'=>$_SGLOBAL['supe_uid']));
	}



$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('weixinmenu')."  WHERE uid='$_SGLOBAL[supe_uid]' order by fathernum ASC");
while ($value = $_SGLOBAL['db']->fetch_array($query)) {
	$list[]=$value;
	}
$query1 = $_SGLOBAL['db']->query("SELECT * FROM ".tname('menuset')." ");
	while ($value1 = $_SGLOBAL['db']->fetch_array($query1)) {
		
			$list1[] = $value1;
		}
$query2 = $_SGLOBAL['db']->query("SELECT * FROM ".tname('weixinmenutop')." where uid='$_SGLOBAL[supe_uid]' and type='image'");
$value2 = $_SGLOBAL['db']->fetch_array($query2);
$query3 = $_SGLOBAL['db']->query("SELECT * FROM ".tname('weixinmenutop')." where uid='$_SGLOBAL[supe_uid]' and type='frist'");
$value3 = $_SGLOBAL['db']->fetch_array($query3);
if($value3){
	$cheak= is_int(strpos("$value3[number]","url"));
	if($cheak){
		$newvalue3['subject']="链接";
		}else{	
$wei3=explode(".",$value3['number']);
$wei3id=$wei3['0']."id";
$newquery3=$_SGLOBAL['db']->query("SELECT * FROM ".tname("$wei3[0]")." where uid='$_SGLOBAL[supe_uid]'and $wei3id='$wei3[1]'");
$newvalue3 = $_SGLOBAL['db']->fetch_array($newquery3);
$newvalue3['subject']=getstr($newvalue3['subject'], 25, 0, 0, 0, 0, -1)."...";
	}
}
$query4 = $_SGLOBAL['db']->query("SELECT * FROM ".tname('weixinmenutop')." where uid='$_SGLOBAL[supe_uid]' and type='second'");
$value4 = $_SGLOBAL['db']->fetch_array($query4);
if($value4){
	$cheak=is_int(strpos("$value4[number]","url"));
	if($cheak){
	$newvalue4['subject']="链接";	
	}else{
$wei4=explode(".",$value4['number']);
$wei4id=$wei4['0']."id";
$newquery4=$_SGLOBAL['db']->query("SELECT * FROM ".tname("$wei4[0]")." where uid='$_SGLOBAL[supe_uid]'and $wei4id='$wei4[1]'");
$newvalue4 = $_SGLOBAL['db']->fetch_array($newquery4);
$newvalue4['subject']=getstr($newvalue4['subject'], 25, 0, 0, 0, 0, -1)."...";
	}
}
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