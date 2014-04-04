<?php
/*
	[UCenter myhelp] (C) 2007-2008 Comsenz Inc.
	$Id: myhelp.php 12078 2009-05-04 08:28:37Z zhengqingpeng $
*/

if(!defined('IN_UCHOME')) {
	exit('Access Denied');
}


$id=$_GET['id'];

if($id==49)
	{
        $query = $_SGLOBAL['db']->query("SELECT pro.*, prof.* 
		         FROM ".tname('product')." pro
		         LEFT JOIN ".tname('productfield')." prof ON pro.productid=prof.productid
		         WHERE pro.uid='178' and pro.productid='$id';
		          ");
        $value = $_SGLOBAL['db']->fetch_array($query);
    }
else if($id==null)
	{
        $query = $_SGLOBAL['db']->query("SELECT pro.*, prof.* 
		         FROM ".tname('product')." pro
		         LEFT JOIN ".tname('productfield')." prof ON pro.productid=prof.productid
		         WHERE pro.uid='178' and pro.productid='49';
		          ");
        $value = $_SGLOBAL['db']->fetch_array($query);
    }

else if($id==60)
	{
        $query = $_SGLOBAL['db']->query("SELECT dev.*, devf.* 
		         FROM ".tname('development')." dev
		         LEFT JOIN ".tname('developmentfield')." devf ON dev.developmentid=devf.developmentid
		         WHERE dev.uid='389' and dev.developmentid='$id';
		          ");
        $value = $_SGLOBAL['db']->fetch_array($query);
    }
else if($id==61)
	{
        $query = $_SGLOBAL['db']->query("SELECT dev.*, devf.* 
		         FROM ".tname('development')." dev
		         LEFT JOIN ".tname('developmentfield')." devf ON dev.developmentid=devf.developmentid
		         WHERE dev.uid='389' and dev.developmentid='$id';
		          ");
        $value = $_SGLOBAL['db']->fetch_array($query);
    }
else if($id==62)
	{
        $query = $_SGLOBAL['db']->query("SELECT dev.*, devf.* 
		         FROM ".tname('development')." dev
		         LEFT JOIN ".tname('developmentfield')." devf ON dev.developmentid=devf.developmentid
		         WHERE dev.uid='389' and dev.developmentid='$id';
		          ");
        $value = $_SGLOBAL['db']->fetch_array($query);
    }
else if($id==63)
	{
        $query = $_SGLOBAL['db']->query("SELECT dev.*, devf.* 
		         FROM ".tname('development')." dev
		         LEFT JOIN ".tname('developmentfield')." devf ON dev.developmentid=devf.developmentid
		         WHERE dev.uid='389' and dev.developmentid='$id';
		          ");
        $value = $_SGLOBAL['db']->fetch_array($query);
    }
else if($id==69)
	{
        $query = $_SGLOBAL['db']->query("SELECT dev.*, devf.* 
		         FROM ".tname('development')." dev
		         LEFT JOIN ".tname('developmentfield')." devf ON dev.developmentid=devf.developmentid
		         WHERE dev.uid='389' and dev.developmentid='$id';
		          ");
        $value = $_SGLOBAL['db']->fetch_array($query);
    }
else if($id==70)
	{
        $query = $_SGLOBAL['db']->query("SELECT dev.*, devf.* 
		         FROM ".tname('development')." dev
		         LEFT JOIN ".tname('developmentfield')." devf ON dev.developmentid=devf.developmentid
		         WHERE dev.uid='389' and dev.developmentid='$id';
		          ");
        $value = $_SGLOBAL['db']->fetch_array($query);
    }
else if($id==72)
	{
        $query = $_SGLOBAL['db']->query("SELECT dev.*, devf.* 
		         FROM ".tname('development')." dev
		         LEFT JOIN ".tname('developmentfield')." devf ON dev.developmentid=devf.developmentid
		         WHERE dev.uid='389' and dev.developmentid='$id';
		          ");
        $value = $_SGLOBAL['db']->fetch_array($query);
    }
else if($id==71)
	{
        $query = $_SGLOBAL['db']->query("SELECT dev.*, devf.* 
		         FROM ".tname('development')." dev
		         LEFT JOIN ".tname('developmentfield')." devf ON dev.developmentid=devf.developmentid
		         WHERE dev.uid='389' and dev.developmentid='$id';
		          ");
        $value = $_SGLOBAL['db']->fetch_array($query);
    }
else if($id==48)
	{
        $query = $_SGLOBAL['db']->query("SELECT intr.*, intrf.* 
		         FROM ".tname('introduce')." intr
		         LEFT JOIN ".tname('introducefield')." intrf ON intr.introduceid=intrf.introduceid
		         WHERE intr.uid='389' and intr.introduceid='$id';
		          ");
        $value = $_SGLOBAL['db']->fetch_array($query);
    }
else if($id==57||$id==58||$id==59)
	{
        $query = $_SGLOBAL['db']->query("SELECT intr.*, intrf.* 
		         FROM ".tname('introduce')." intr
		         LEFT JOIN ".tname('introducefield')." intrf ON intr.introduceid=intrf.introduceid
		         WHERE intr.uid='389' and intr.introduceid='$id';
		          ");
        $value = $_SGLOBAL['db']->fetch_array($query);
    }
else if($id==17)
	{
        $query = $_SGLOBAL['db']->query("SELECT jo.*, jof.* 
		         FROM ".tname('job')." jo
		         LEFT JOIN ".tname('jobfield')." jof ON jo.jobid=jof.jobid
		         WHERE jo.uid='389' and jo.jobid='$id';
		          ");
        $value = $_SGLOBAL['db']->fetch_array($query);
    }


include_once template("myhelp");
?>