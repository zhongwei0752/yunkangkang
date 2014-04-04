<?php
$keywords = $_POST['keywords'];
if($keywords){
$query = $_SGLOBAL['db']->query("SELECT s.* FROM  ".tname('friend')." main LEFT JOIN ".tname('space')." s ON s.uid=main.fuid where s.name like '%$keywords%' and main.uid='$space[uid]' AND main.status='1' ORDER BY main.dateline DESC limit 0,10;"); 
	
while($value = $_SGLOBAL['db']->fetch_array($query))
 { 
 	if($value['fakeid']){
     echo "<li style='list-style:none'><span style='display:none'>".$value['fakeid']."|</span>".$value['name'] ."</li>";
 	}
  
 }
 
}
?>