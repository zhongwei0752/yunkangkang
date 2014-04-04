<?php

$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('weixinmenu')."  WHERE uid='$_SGLOBAL[supe_uid]' order by fathernum ASC");
while ($value = $_SGLOBAL['db']->fetch_array($query)) {
    $list[]=$value;
    }
    $name1=$list[0]['button'];
    $name2=$list[1]['button'];
    $name3=$list[2]['button'];
    $zwname1=$list[0]['function'];
    $zwname2=$list[1]['function'];
    $zwname3=$list[2]['function'];
    $wei1=$list[0]['sub_button1'];
    $wei2=$list[0]['sub_button2'];
    $wei3=$list[0]['sub_button3'];
    $wei4=$list[0]['sub_button4'];
    $wei5=$list[0]['sub_button5'];
    $wei6=$list[1]['sub_button1'];
    $wei7=$list[1]['sub_button2'];
    $wei8=$list[1]['sub_button3'];
    $wei9=$list[1]['sub_button4'];
    $wei10=$list[1]['sub_button5'];
    $wei11=$list[2]['sub_button1'];
    $wei12=$list[2]['sub_button2'];
    $wei13=$list[2]['sub_button3'];
    $wei14=$list[2]['sub_button4'];
    $wei15=$list[2]['sub_button5'];
    $zw1=$list[0]['sub_function1'];
    $zw2=$list[0]['sub_function2'];
    $zw3=$list[0]['sub_function3'];
    $zw4=$list[0]['sub_function4'];
    $zw5=$list[0]['sub_function5'];
    $zw6=$list[1]['sub_function1'];
    $zw7=$list[1]['sub_function2'];
    $zw8=$list[1]['sub_function3'];
    $zw9=$list[1]['sub_function4'];
    $zw10=$list[1]['sub_function5'];
    $zw11=$list[2]['sub_function1'];
    $zw12=$list[2]['sub_function2'];
    $zw13=$list[2]['sub_function3'];
    $zw14=$list[2]['sub_function4'];
    $zw15=$list[2]['sub_function5'];
    if(empty($wei1)&&empty($wei2)&&empty($wei3)&&empty($wei4)&&empty($wei5)){
        $zhong="1";
    }else{
        $zhong="0";
    }
    if($zhong=="1"){
    $ex1=explode('#', $zwname1);
    if($ex1[0]=='url'){
        $zhong=array(
                "type"=>"view",
                "name"=>"$name1",
                "url"=>"$ex1[1]"
                );

         }else{
    $zhong=array(
                "type"=>"click",
                "name"=>"$name1",
                "key"=>"$zwname1"
                );
        }
    }
   if($zhong=="0"){
if($wei1){
    $ex1=explode('#', $zw1);
    if($ex1[0]=='url'){
     $arraywei1=array(
                            "type"=>"view",
                            "name"=>"$wei1",
                            "url"=>"$ex1[1]"
                            );
    }else{
    $arraywei1=array(
                            "type"=>"click",
                            "name"=>"$wei1",
                            "key"=>"$zw1"
                            );
    }
}
if($wei2){
    $ex2=explode('#', $zw2);
    if($ex2[0]=='url'){
    $arraywei2=array(
                            "type"=>"view",
                            "name"=>"$wei2",
                            "url"=>"$ex2[1]"
                            );
    }else{
     $arraywei2=array(
                            "type"=>"click",
                            "name"=>"$wei2",
                            "key"=>"$zw2"
                            );   
    }
}
if($wei3){
     $ex3=explode('#', $zw3);
    if($ex3[0]=='url'){
         $arraywei3=array(
                            "type"=>"view",
                            "name"=>"$wei3",
                            "url"=>"$ex3[1]"
                            );
     }else{
       $arraywei3=array(
                            "type"=>"click",
                            "name"=>"$wei3",
                            "key"=>"$zw3"
                            ); 
     }
    
}
if($wei4){
    $ex4=explode('#', $zw4);
    if($ex4[0]=='url'){
    $arraywei4=array(
                            "type"=>"view",
                            "name"=>"$wei4",
                            "url"=>"$ex4[1]"
                            );
    }else{
       $arraywei4=array(
                            "type"=>"click",
                            "name"=>"$wei4",
                            "key"=>"$zw4"
                            );  
    }
   
}
if($wei5){
     $ex5=explode('#', $zw5);
    if($ex5[0]=='url'){
        $arraywei5=array(
                            "type"=>"view",
                            "name"=>"$wei5",
                            "url"=>"$ex5[1]"
                            );
    }else{
        $arraywei5=array(
                            "type"=>"click",
                            "name"=>"$wei5",
                            "key"=>"$zw5"
                            );
    }
    
}


    $weiarray=array(

                    $arraywei1,
                    $arraywei2,
                    $arraywei3,
                    $arraywei4,
                    $arraywei5,
                     );
    $weiarray=array_filter($weiarray);
     $zhong=array(
                "name"=>"$name1",
                "sub_button" =>$weiarray,

                );
 }
     if(empty($wei6)&&empty($wei7)&&empty($wei8)&&empty($wei9)&&empty($wei10)){
        $zhong1="1";
    }else{
        $zhong1="0";
    }
    if($zhong1=="1"){
    $ex6=explode('#', $zwname2);
    if($ex6[0]=='url'){
     $zhong1=array(
                "type"=>"view",
                "name"=>"$name2",
                "url"=>"$ex6[1]"
                );
    }else{
     $zhong1=array(
                "type"=>"click",
                "name"=>"$name2",
                "key"=>"$zwname2"
                );   
        }
    
    }
   if($zhong1=="0"){
if($wei6){
    $ex6=explode('#', $zw6);
    if($ex6[0]=='url'){
        $arraywei6=array(
                            "type"=>"view",
                            "name"=>"$wei6",
                            "url"=>"$ex6[1]"
                            );
    }else{
     $arraywei6=array(
                            "type"=>"click",
                            "name"=>"$wei6",
                            "key"=>"$zw6"
                            );   
    }
    
}
if($wei7){
    $ex7=explode('#', $zw7);
    if($ex7[0]=='url'){
        $arraywei7=array(
                            "type"=>"view",
                            "name"=>"$wei7",
                            "url"=>"$ex7[1]"
                            );
    }else{
     $arraywei7=array(
                            "type"=>"click",
                            "name"=>"$wei7",
                            "key"=>"$zw7"
                            );   
    }
    
}
if($wei8){
    $ex8=explode('#', $zw8);
    if($ex8[0]=='url'){
        $arraywei8=array(
                            "type"=>"view",
                            "name"=>"$wei8",
                            "url"=>"$ex8[1]"
                            );
    }else{
     $arraywei8=array(
                            "type"=>"click",
                            "name"=>"$wei8",
                            "key"=>"$zw8"
                            );   
    }
    
}
if($wei9){
    $ex9=explode('#', $zw9);
    if($ex9[0]=='url'){
     $arraywei9=array(
                            "type"=>"view",
                            "name"=>"$wei9",
                            "url"=>"$ex9[1]"
                            );   
    }else{
       $arraywei9=array(
                            "type"=>"click",
                            "name"=>"$wei9",
                            "key"=>"$zw9"
                            );  
    }
   
}
if($wei10){
    $ex10=explode('#', $zw10);
    if($ex10[0]=='url'){
        $arraywei10=array(
                            "type"=>"view",
                            "name"=>"$wei10",
                            "url"=>"$ex10[1]"
                            );
    }else{
        $arraywei10=array(
                            "type"=>"click",
                            "name"=>"$wei10",
                            "key"=>"$zw10"
                            );  
    }
  
}


    $weiarray1=array(

                    $arraywei6,
                    $arraywei7,
                    $arraywei8,
                    $arraywei9,
                    $arraywei10,
                     );
    $weiarray1=array_filter($weiarray1);
     $zhong1=array(
                "name"=>"$name2",
                "sub_button" =>$weiarray1,

                );
 }
  if(empty($wei11)&&empty($wei12)&&empty($wei13)&&empty($wei14)&&empty($wei15)){
        $zhong2="1";
    }else{
        $zhong2="0";
    }
    if($zhong2=="1"){
     $ex11=explode('#', $zwname3);
    if($ex11[0]=='url'){
         $zhong2=array(
                "type"=>"view",
                "name"=>"$name3",
                "url"=>"$ex11[1]"
                ); 
    }else{
      $zhong2=array(
                "type"=>"click",
                "name"=>"$name3",
                "key"=>"$zwname3"
                );  
        }
    
    }
   if($zhong2=="0"){
if($wei11){
     $ex11=explode('#', $zw11);
    if($ex11[0]=='url'){
        $arraywei11=array(
                            "type"=>"view",
                            "name"=>"$wei11",
                            "url"=>"$ex11[1]"
                            );
    }else{
       $arraywei11=array(
                            "type"=>"click",
                            "name"=>"$wei11",
                            "key"=>"$zw11"
                            ); 
    }
    
}
if($wei12){
     $ex12=explode('#', $zw12);
    if($ex12[0]=='url'){
        $arraywei12=array(
                            "type"=>"view",
                            "name"=>"$wei12",
                            "url"=>"$ex12[1]"
                            );
    }else{
       $arraywei12=array(
                            "type"=>"click",
                            "name"=>"$wei12",
                            "key"=>"$zw12"
                            ); 
    }
    
}
if($wei13){
    $ex13=explode('#', $zw13);
    if($ex13[0]=='url'){
         $arraywei13=array(
                            "type"=>"view",
                            "name"=>"$wei13",
                            "url"=>"$ex13[1]"
                            );
    }else{
        $arraywei13=array(
                            "type"=>"click",
                            "name"=>"$wei13",
                            "key"=>"$zw13"
                            );
    }

    
}
if($wei14){
    $ex14=explode('#', $zw14);
    if($ex14[0]=='url'){
        $arraywei14=array(
                            "type"=>"view",
                            "name"=>"$wei14",
                            "url"=>"$ex14[1]"
                            );
    }else{
      $arraywei14=array(
                            "type"=>"click",
                            "name"=>"$wei14",
                            "key"=>"$zw14"
                            );  
    }
    
}
if($wei15){
    $ex15=explode('#', $zw15);
    if($ex15[0]=='url'){
       $arraywei15=array(
                            "type"=>"view",
                            "name"=>"$wei15",
                            "url"=>"$ex15[1]"
                            ); 
    }else{
        $arraywei15=array(
                            "type"=>"click",
                            "name"=>"$wei15",
                            "key"=>"$zw15"
                            ); 
    }
   
}


    $weiarray2=array(

                    $arraywei11,
                    $arraywei12,
                    $arraywei13,
                    $arraywei14,
                    $arraywei15,
                     );
    $weiarray2=array_filter($weiarray2);
     $zhong2=array(
                "name"=>"$name3",
                "sub_button" =>$weiarray2,

                );
 }
$menu_ary   = array(
    "button"=>array(
            //左边第一个菜单
            $zhong,
            //中间的菜单
            $zhong1,
            //右边的菜单
            $zhong2,
        )
    );
require 'creatmenu.php';
$Weixin = new WeixinOp("$space[appid]" , "$space[appsecret]");
$weixinstatus=$Weixin->creatMenu($menu_ary);
if($weixinstatus['errcode']=="0"){
    showmessage("菜单生成成功。");
}else{
    showmessage("菜单生成失败，可能原因是菜单格式不对，请按要求填写！"); 
}
?>
