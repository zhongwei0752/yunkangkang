<?php
$keywords = $_POST['keywords'];
if($keywords){
$query = $_SGLOBAL['db']->query("SELECT * FROM  ".tname('space')." where name like '%$keywords%' limit 0,10;"); 
	
while($value = $_SGLOBAL['db']->fetch_array($query))
 { 
     echo "<li><span style='display:none'>".$value['name'] ."</li>';
  
 }
 
}
?>