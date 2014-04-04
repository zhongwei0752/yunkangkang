<?php
$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('menuset')." ");
	while ($value = $_SGLOBAL['db']->fetch_array($query)) {
		
			$list[] = $value;
		}
include_once template("space_text");
?>