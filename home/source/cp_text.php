<?php
/*
	[UCenter Home] (C) 2007-2008 Comsenz Inc.
	$Id: space_product.php 13208 2009-08-20 06:31:35Z liguode $
*/

if(!defined('IN_UCHOME')) {
	exit('Access Denied');
}


if(!empty($_POST['updatesubmit'])) {
$table=$_POST['data'];
$table1="uchome_".$table;
$table2="uchome_".$table."field";
$table3=$table."comment";
$table4="uchome_class".$table;
$table5="uchome_tag".$table;
//showmessage($table4);
$table1id=$table."id";
$tablenum=$table."num";
$_SGLOBAL['db']->query("CREATE TABLE $table1 (
  $table1id mediumint(8) unsigned NOT NULL auto_increment,
  topicid mediumint(8) unsigned NOT NULL default '0',
  uid mediumint(8) unsigned NOT NULL default '0',
  username char(15) NOT NULL default '',
  `subject` char(80) NOT NULL default '',
  classid smallint(6) unsigned NOT NULL default '0',
  viewnum mediumint(8) unsigned NOT NULL default '0',
  replynum mediumint(8) unsigned NOT NULL default '0',
  hot mediumint(8) unsigned NOT NULL default '0',
  dateline int(10) unsigned NOT NULL default '0',
  pic char(120) NOT NULL default '',
  picflag tinyint(1) NOT NULL default '0',
  noreply tinyint(1) NOT NULL default '0',
  friend tinyint(1) NOT NULL default '0',
  `password` char(10) NOT NULL default '',
  PRIMARY KEY  ($table1id),
  KEY uid (uid,dateline),
  KEY topicid (topicid,dateline),
  KEY dateline (dateline)
) ENGINE=MyISAM;");
$_SGLOBAL['db']->query("CREATE TABLE $table2 (
  $table1id mediumint(8) unsigned NOT NULL default '0',
  uid mediumint(8) unsigned NOT NULL default '0',
  tag varchar(255) NOT NULL default '',
  message mediumtext NOT NULL,
  postip varchar(20) NOT NULL default '',
  related text NOT NULL,
  relatedtime int(10) unsigned NOT NULL default '0',
  target_ids text NOT NULL,
  hotuser text NOT NULL,
  magiccolor tinyint(6) NOT NULL default '0',
  magicpaper tinyint(6) NOT NULL default '0',
  magiccall tinyint(1) NOT NULL default '0',
  PRIMARY KEY  ($table1id)
) ENGINE=MyISAM;");
$_SGLOBAL['db']->query("ALTER TABLE uchome_stat
ADD  $table smallint(6) unsigned NOT NULL default '0'");
$_SGLOBAL['db']->query("ALTER TABLE uchome_stat
ADD  $table3 smallint(6) unsigned NOT NULL default '0'");
$_SGLOBAL['db']->query("CREATE TABLE $table4 (
  classid mediumint(8) unsigned NOT NULL auto_increment,
  classname char(40) NOT NULL default '',
  uid mediumint(8) unsigned NOT NULL default '0',
  dateline int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (classid),
  KEY uid (uid)
) ENGINE=MyISAM;");
$_SGLOBAL['db']->query("ALTER TABLE uchome_tag
ADD   $tablenum smallint(6) unsigned NOT NULL default '0'");
$_SGLOBAL['db']->query("CREATE TABLE $table5 (
  tagid mediumint(8) unsigned NOT NULL default '0',
  $table1id mediumint(8) unsigned NOT NULL default '0',
  PRIMARY KEY  (tagid,$table1id)
) ENGINE=MyISAM;");
$_SGLOBAL['db']->query("ALTER TABLE uchome_space
ADD   $tablenum smallint(6) unsigned NOT NULL default '0'");
showmessage(成功);
}
if(!empty($_POST['stringsubmit'])) {
  $string1=$_POST['string1'];
  $string2=$_POST['string2'];
  $string3=$_POST['string3'];
  $string4=$_POST['string4'];

$content = file_get_contents("./source/$string1");
$content = str_replace("$string3","$string4",$content);
file_put_contents("./source/$string2",$content);
	showmessage(成功);
}
if(!empty($_POST['string1submit'])) {
  $string1=$_POST['string1'];
  $string2=$_POST['string2'];
  $string3=$_POST['string3'];
  $string4=$_POST['string4'];

$content = file_get_contents("./template/default/$string1");
$content = str_replace("$string3","$string4",$content);
file_put_contents("./template/default/$string2",$content);
  showmessage(成功);
}

?>