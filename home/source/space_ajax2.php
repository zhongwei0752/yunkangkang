<?php
$keywords = $_POST['keywords'];
if($keywords){
$query = $_SGLOBAL['db']->query("SELECT s.*,f.limitnum,f.dailinum, f.resideprovince, f.residecity, f.note, f.spacenote, f.sex
				FROM  ".tname('space')." s LEFT JOIN ".tname('spacefield')." f ON f.uid=s.uid
				WHERE  s.groupid='10' and s.name like '%$keywords%'
				ORDER BY s.dateline DESC"); 
	
while($value = $_SGLOBAL['db']->fetch_array($query))
 { 
 		if($value['limitnum']>$value['dailinum']){//如果限制的数量大于代理所代理的个数，则不出现。
     echo "<li style='list-style:none'><span style='display:none'>".$value['uid']."|</span>".$value['name'] ."</li>";
 			}
 	
  
 }
 
}
?>