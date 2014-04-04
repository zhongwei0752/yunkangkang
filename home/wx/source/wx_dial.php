<?php
$dial=$_POST['dial'];

if($dial){
    $uid=$_POST['uid'];
    $username=$_POST['username'];
    $tel=$_POST['tel'];
    $viewuid=$_POST['viewuid'];
    $dialprice=$_POST['dialprice'];
    $diallevel=$_POST['diallevel'];
    $dateline=$_SGLOBAL['timestamp'];
    $space=getspace($uid);
    $service=$space['service'];
    $dialid=$_POST['dialid'];
    $space1=getspace($service);
    $fakeid=$space1['fakeid'];
    if($diallevel=='1'){
        $message=$username."在大转盘抽到一等奖，请及时联系，联系电话:".$tel;
        $d = get_obj_by_xiaoquid($uid);
        $info = $d->sendWXSingleMsg($fakeid,$message);
    }
    if($diallevel=='2'){
        $message=$username."在大转盘抽到二等奖，请及时联系，联系电话:".$tel;
        $d = get_obj_by_xiaoquid($uid);
        $info = $d->sendWXSingleMsg($fakeid,$message);
    }
    if($diallevel=='3'){
        $message=$username."在大转盘抽到三等奖，请及时联系，联系电话:".$tel;
        $d = get_obj_by_xiaoquid($uid);
        $info = $d->sendWXSingleMsg($fakeid,$message);
    }
    
    updatetable("dialbuy",array('uid'=>$uid,'username'=>$username,'tel'=>$tel,'diallevel'=>$diallevel,'dateline'=>$dateline,'dialprice'=>$dialprice),array('dialid'=>$dialid,'viewuid'=>$viewuid));  
}
//查看密码执行代码
if($_POST['password1']){
    $password=trim($_POST['password']);
    $uid=$_POST['uid'];
    $moblieclicknum=$_POST['moblieclicknum'];
    $query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('dial')." WHERE uid='$uid' and status='1'");
    $value = $_SGLOBAL['db']->fetch_array($query);
    $value['password']=trim($value['password']);
    if($value['password']==$password){
        $url_forward="$_SERVER[HTTP_REFERER]"."&zhong=1";
        header("HTTP/1.1 301 Moved Permanently");
        header("Location: $url_forward");   

    }else{  
    echo '<script charset="utf8" type="text/javascript" language="javascript">alert("密码错误");</script>';
    echo '<script language="javascript">history.go(-1);</script>';  
    }
    
}
header("Content-type: text/html; charset=utf-8");
    $uid=$_GET['uid'];
    if($uid){
    $viewuid=$_GET['viewuid'];
    $dialid=$_GET['dialid'];
    inserttable("dialbuy",array('viewuid'=>$viewuid,'uid'=>$uid,'dialid'=>$dialid,'dateline'=>$_SGLOBAL['timestamp']));
    $query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('dial')." WHERE uid= '$uid' and status='1'");
    $dial = $_SGLOBAL['db']->fetch_array($query); 
    $lastrand=$dial['frequencynum']-$dial['fristrand']-$dial['secondrand']-$dial['thirdrand'];
    $fristprice=$dial['fristprice'];
    $fristrand=$dial['fristrand'];
    $secondprice=$dial['secondprice'];
    $secondrand=$dial['secondrand'];
    $thirdprice=$dial['thirdprice'];
    $thirdrand=$dial['thirdrand'];
$prize_arr = array( 
    '0' => array('id'=>1,'min'=>array(0,344,165),'max'=>array(17,360,193),'prize'=>$fristprice,'v'=>$fristrand), 
    '1' => array('id'=>2,'min'=>array(50,222),'max'=>array(80,251),'prize'=>$secondprice,'v'=>$secondrand), 
    '2' => array('id'=>3,'min'=>array(110,282),'max'=>array(138,312),'prize'=>$thirdprice,'v'=>$thirdrand), 
    '3' => array('id'=>4,'min'=>array(18,81,139,194,252,314), 
            'max'=>array(48,108,164,221,280,344),'prize'=>'123abc','v'=>$lastrand)
); 
/*'3' => array('id'=>4,'min'=>270, 'max'=>359,'prize'=>'123abc','v'=>$lastrand)*/
function getRand($proArr) { 
    $result = ''; 
 
    //概率数组的总概率精度 
    $proSum = array_sum($proArr); 
 
    //概率数组循环 
    foreach ($proArr as $key => $proCur) { 
        $randNum = mt_rand(1, $proSum); 
        if ($randNum <= $proCur) { 
            $result = $key; 
            break; 
        } else { 
            $proSum -= $proCur; 
        } 
    } 
    unset ($proArr); 
 
    return $result; 
} 
foreach ($prize_arr as $key => $val) { 
    $arr[$val['id']] = $val['v']; 
} 
 
$rid = getRand($arr); //根据概率获取奖项id 
 
$res = $prize_arr[$rid-1]; //中奖项 
$min = $res['min']; 
$max = $res['max']; 
if($res['id']==4){ //七等奖 
    $i = mt_rand(0,5); 
    $result['angle'] = mt_rand($min[$i],$max[$i]); 
}
if($res['id']==1){
    $i = mt_rand(0,2); 
    $result['angle'] = mt_rand($min[$i],$max[$i]); 
}
if($res['id']==2||$res['id']==3){
    $i = mt_rand(0,1); 
    $result['angle'] = mt_rand($min[$i],$max[$i]); 
}
$result['prize'] = $res['prize']; 
$result['id'] = $res['id']; 
 
echo json_encode($result); 
}
?>