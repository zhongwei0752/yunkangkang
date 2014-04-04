<?php
/*
	[UCenter Home] (C) 2007-2008 Comsenz Inc.
	$Id: function_delete.php 13001 2009-08-05 06:18:06Z zhengqingpeng $
*/

if(!defined('IN_UCHOME')) {
	exit('Access Denied');
}

//删除评论
function deletecomments($cids) {
	global $_SGLOBAL;

	$deductcredit = array();
	$blognums = $spaces = $newcids = $dels = array();
	$allowmanage = checkperm('managecomment');
	$managebatch = checkperm('managebatch');
	$delnum = 0;
	$reward = getreward('delcomment', 0);
	$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('comment')." WHERE cid IN (".simplode($cids).")");
	while ($value = $_SGLOBAL['db']->fetch_array($query)) {
		if($allowmanage || $value['authorid'] == $_SGLOBAL['supe_uid'] || $value['uid'] == $_SGLOBAL['supe_uid']) {
			$dels[] = $value;
			if(!$managebatch && $value['authorid'] != $_SGLOBAL['supe_uid']) {
				$delnum++;
			}
		}
	}

	if(empty($dels) || (!$managebatch && $delnum > 1)) return array();
	
	foreach($dels as $key => $value) {
		$newcids[] = $value['cid'];
		if($value['idtype'] == 'blogid') {
			$blognums[$value['id']]++;
		}
		if($allowmanage && $value['authorid'] != $value['supe_uid']) {
			//扣除积分
			$_SGLOBAL['db']->query("UPDATE ".tname('space')." SET credit=credit-$reward[credit], experience=experience-$reward[experience] WHERE uid='$value[authorid]'");
		}
	}

	//数据删除
	$_SGLOBAL['db']->query("DELETE FROM ".tname('comment')." WHERE cid IN (".simplode($newcids).")");

	//统计数据
	$nums = renum($blognums);
	foreach ($nums[0] as $num) {
		$_SGLOBAL['db']->query("UPDATE ".tname('blog')." SET replynum=replynum-$num WHERE blogid IN (".simplode($nums[1][$num]).")");
	}
	
	return $dels;
}


//删除博客
function deleteblogs($blogids) {
	global $_SGLOBAL;

	//获取积分
	$reward = getreward('delblog', 0);
	//获取博客信息
	$spaces = $blogs = $newblogids = array();
	$allowmanage = checkperm('manageblog');
	$managebatch = checkperm('managebatch');
	$delnum = 0;
	$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('blog')." WHERE blogid IN (".simplode($blogids).")");
	while ($value = $_SGLOBAL['db']->fetch_array($query)) {
		if($allowmanage || $value['uid'] == $_SGLOBAL['supe_uid']) {
			$blogs[] = $value;
			if(!$managebatch && $value['uid'] != $_SGLOBAL['supe_uid']) {
				$delnum++;
			}
		}
	}
	if(empty($blogs) || (!$managebatch && $delnum > 1)) return array();
	
	foreach($blogs as $key => $value) {
		$newblogids[] = $value['blogid'];
		if($allowmanage && $value['uid'] != $_SGLOBAL['supe_uid']) {
			//扣除积分
			$_SGLOBAL['db']->query("UPDATE ".tname('space')." SET credit=credit-$reward[credit], experience=experience-$reward[experience] WHERE uid='$value[uid]'");
		}
		//tag
		$tags = array();
		$subquery = $_SGLOBAL['db']->query("SELECT tagid, blogid FROM ".tname('tagblog')." WHERE blogid='$value[blogid]'");
		while ($tag = $_SGLOBAL['db']->fetch_array($subquery)) {
			$tags[] = $tag['tagid'];
		}
		if($tags) {
			$_SGLOBAL['db']->query("UPDATE ".tname('tag')." SET blognum=blognum-1 WHERE tagid IN (".simplode($tags).")");
			$_SGLOBAL['db']->query("DELETE FROM ".tname('tagblog')." WHERE blogid='$value[blogid]'");
		}
	}

	//数据删除
	$_SGLOBAL['db']->query("DELETE FROM ".tname('blog')." WHERE blogid IN (".simplode($newblogids).")");
	$_SGLOBAL['db']->query("DELETE FROM ".tname('blogfield')." WHERE blogid IN (".simplode($newblogids).")");

	//评论
	$_SGLOBAL['db']->query("DELETE FROM ".tname('comment')." WHERE id IN (".simplode($newblogids).") AND idtype='blogid'");

	//删除举报
	$_SGLOBAL['db']->query("DELETE FROM ".tname('report')." WHERE id IN (".simplode($newblogids).") AND idtype='blogid'");

	//删除feed
	$_SGLOBAL['db']->query("DELETE FROM ".tname('feed')." WHERE id IN (".simplode($newblogids).") AND idtype='blogid'");
	
	//删除脚印
	$_SGLOBAL['db']->query("DELETE FROM ".tname('clickuser')." WHERE id IN (".simplode($newblogids).") AND idtype='blogid'");

	return $blogs;
}
function deleteintroduces($introduceids) {
	global $_SGLOBAL;

	//获取积分
	$reward = getreward('delintroduce', 0);
	//获取博客信息
	$spaces = $introduces = $newintroduceids = array();
	$allowmanage = checkperm('manageintroduce');
	$managebatch = checkperm('managebatch');
	$delnum = 0;
	$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('introduce')." WHERE introduceid IN (".simplode($introduceids).")");
	while ($value = $_SGLOBAL['db']->fetch_array($query)) {
		if($allowmanage || $value['uid'] == $_SGLOBAL['supe_uid']) {
			$introduces[] = $value;
			if(!$managebatch && $value['uid'] != $_SGLOBAL['supe_uid']) {
				$delnum++;
			}
		}
	}
	if(empty($introduces) || (!$managebatch && $delnum > 1)) return array();
	
	foreach($introduces as $key => $value) {
		$newintroduceids[] = $value['introduceid'];
		if($allowmanage && $value['uid'] != $_SGLOBAL['supe_uid']) {
			//扣除积分
			$_SGLOBAL['db']->query("UPDATE ".tname('space')." SET credit=credit-$reward[credit], experience=experience-$reward[experience] WHERE uid='$value[uid]'");
		}

	}

	//数据删除
	$_SGLOBAL['db']->query("DELETE FROM ".tname('introduce')." WHERE introduceid IN (".simplode($newintroduceids).")");
	$_SGLOBAL['db']->query("DELETE FROM ".tname('introducefield')." WHERE introduceid IN (".simplode($newintroduceids).")");

	//评论
	$_SGLOBAL['db']->query("DELETE FROM ".tname('comment')." WHERE id IN (".simplode($newintroduceids).") AND idtype='introduceid'");

	//删除举报
	$_SGLOBAL['db']->query("DELETE FROM ".tname('report')." WHERE id IN (".simplode($newintroduceids).") AND idtype='introduceid'");

	//删除feed
	$_SGLOBAL['db']->query("DELETE FROM ".tname('feed')." WHERE id IN (".simplode($newintroduceids).") AND idtype='introduceid'");
	
	//删除脚印
	$_SGLOBAL['db']->query("DELETE FROM ".tname('clickuser')." WHERE id IN (".simplode($newintroduceids).") AND idtype='introduceid'");

	return $introduces;
}
function deleteproducts($productids) {
	global $_SGLOBAL;

	//获取积分
	$reward = getreward('delproduct', 0);
	//获取博客信息
	$spaces = $products = $newproductids = array();
	$allowmanage = checkperm('manageproduct');
	$managebatch = checkperm('managebatch');
	$delnum = 0;
	$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('product')." WHERE productid IN (".simplode($productids).")");
	while ($value = $_SGLOBAL['db']->fetch_array($query)) {
		if($allowmanage || $value['uid'] == $_SGLOBAL['supe_uid']) {
			$products[] = $value;
			if(!$managebatch && $value['uid'] != $_SGLOBAL['supe_uid']) {
				$delnum++;
			}
		}
	}
	if(empty($products) || (!$managebatch && $delnum > 1)) return array();
	
	foreach($products as $key => $value) {
		$newproductids[] = $value['productid'];
		if($allowmanage && $value['uid'] != $_SGLOBAL['supe_uid']) {
			//扣除积分
			$_SGLOBAL['db']->query("UPDATE ".tname('space')." SET credit=credit-$reward[credit], experience=experience-$reward[experience] WHERE uid='$value[uid]'");
		}
}
	//数据删除
	$_SGLOBAL['db']->query("DELETE FROM ".tname('product')." WHERE productid IN (".simplode($newproductids).")");
	$_SGLOBAL['db']->query("DELETE FROM ".tname('productfield')." WHERE productid IN (".simplode($newproductids).")");

	//评论
	$_SGLOBAL['db']->query("DELETE FROM ".tname('comment')." WHERE id IN (".simplode($newproductids).") AND idtype='productid'");

	//删除举报
	$_SGLOBAL['db']->query("DELETE FROM ".tname('report')." WHERE id IN (".simplode($newproductids).") AND idtype='productid'");

	//删除feed
	$_SGLOBAL['db']->query("DELETE FROM ".tname('feed')." WHERE id IN (".simplode($newproductids).") AND idtype='productid'");
	
	//删除脚印
	$_SGLOBAL['db']->query("DELETE FROM ".tname('clickuser')." WHERE id IN (".simplode($newproductids).") AND idtype='productid'");

	return $products;
}
function deletedevelopments($developmentids) {
	global $_SGLOBAL;

	//获取积分
	$reward = getreward('deldevelopment', 0);
	//获取博客信息
	$spaces = $developments = $newdevelopmentids = array();
	$allowmanage = checkperm('managedevelopment');
	$managebatch = checkperm('managebatch');
	$delnum = 0;
	$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('development')." WHERE developmentid IN (".simplode($developmentids).")");
	while ($value = $_SGLOBAL['db']->fetch_array($query)) {
		if($allowmanage || $value['uid'] == $_SGLOBAL['supe_uid']) {
			$developments[] = $value;
			if(!$managebatch && $value['uid'] != $_SGLOBAL['supe_uid']) {
				$delnum++;
			}
		}
	}
	if(empty($developments) || (!$managebatch && $delnum > 1)) return array();
	
	foreach($developments as $key => $value) {
		$newdevelopmentids[] = $value['developmentid'];
		if($allowmanage && $value['uid'] != $_SGLOBAL['supe_uid']) {
			//扣除积分
			$_SGLOBAL['db']->query("UPDATE ".tname('space')." SET credit=credit-$reward[credit], experience=experience-$reward[experience] WHERE uid='$value[uid]'");
		}
}
	//数据删除
	$_SGLOBAL['db']->query("DELETE FROM ".tname('development')." WHERE developmentid IN (".simplode($newdevelopmentids).")");
	$_SGLOBAL['db']->query("DELETE FROM ".tname('developmentfield')." WHERE developmentid IN (".simplode($newdevelopmentids).")");

	//评论
	$_SGLOBAL['db']->query("DELETE FROM ".tname('comment')." WHERE id IN (".simplode($newdevelopmentids).") AND idtype='developmentid'");

	//删除举报
	$_SGLOBAL['db']->query("DELETE FROM ".tname('report')." WHERE id IN (".simplode($newdevelopmentids).") AND idtype='developmentid'");

	//删除feed
	$_SGLOBAL['db']->query("DELETE FROM ".tname('feed')." WHERE id IN (".simplode($newdevelopmentids).") AND idtype='developmentid'");
	
	//删除脚印
	$_SGLOBAL['db']->query("DELETE FROM ".tname('clickuser')." WHERE id IN (".simplode($newdevelopmentids).") AND idtype='developmentid'");

	return $developments;
}


//删除菜肴
function deletereservations($reservationids) {
	global $_SGLOBAL;

	
	$reservation = $newreservationids = array();
	$allowmanage = checkperm('manageblog');
	$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('reservation')." WHERE reservationid IN (".simplode($reservationids).")");
	while ($value = $_SGLOBAL['db']->fetch_array($query)) {
		if($allowmanage || $value['uid'] == $_SGLOBAL['supe_uid']) {
			$reservation[] = $value;
			$newreservationids[] = $value['reservationid'];
			//??????????
			//???
			//tag
		}
	}
	if(empty($reservation)) return array();
	 
	 
	//??????
	$_SGLOBAL['db']->query("DELETE FROM ".tname('reservation')." WHERE reservationid IN (".simplode($newreservationids).")");
	$_SGLOBAL['db']->query("DELETE FROM ".tname('reservationfield')." WHERE reservationid IN (".simplode($newreservationids).")");

	//????
	$_SGLOBAL['db']->query("DELETE FROM ".tname('comment')." WHERE id IN (".simplode($newreservationids).") AND idtype='reservid'");
	
	//?????
	$_SGLOBAL['db']->query("DELETE FROM ".tname('reservationorder')." WHERE reservationid IN (".simplode($newreservationids).")");
	//$_SGLOBAL['db']->query("DELETE FROM ".tname('reservationorderlist')." WHERE reservationid IN (".simplode($newreservationids).")");

	return $reservation;
}


function deleteindustrys($industryids) {
	global $_SGLOBAL;

	//获取积分
	$reward = getreward('delindustry', 0);
	//获取博客信息
	$spaces = $industrys = $newindustryids = array();
	$allowmanage = checkperm('manageindustry');
	$managebatch = checkperm('managebatch');
	$delnum = 0;
	$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('industry')." WHERE industryid IN (".simplode($industryids).")");
	while ($value = $_SGLOBAL['db']->fetch_array($query)) {
		if($allowmanage || $value['uid'] == $_SGLOBAL['supe_uid']) {
			$industrys[] = $value;
			if(!$managebatch && $value['uid'] != $_SGLOBAL['supe_uid']) {
				$delnum++;
			}
		}
	}
	if(empty($industrys) || (!$managebatch && $delnum > 1)) return array();
	
	foreach($industrys as $key => $value) {
		$newindustryids[] = $value['industryid'];
		if($allowmanage && $value['uid'] != $_SGLOBAL['supe_uid']) {
			//扣除积分
			$_SGLOBAL['db']->query("UPDATE ".tname('space')." SET credit=credit-$reward[credit], experience=experience-$reward[experience] WHERE uid='$value[uid]'");
		}
}
	//数据删除
	$_SGLOBAL['db']->query("DELETE FROM ".tname('industry')." WHERE industryid IN (".simplode($newindustryids).")");
	$_SGLOBAL['db']->query("DELETE FROM ".tname('industryfield')." WHERE industryid IN (".simplode($newindustryids).")");

	//评论
	$_SGLOBAL['db']->query("DELETE FROM ".tname('comment')." WHERE id IN (".simplode($newindustryids).") AND idtype='industryid'");

	//删除举报
	$_SGLOBAL['db']->query("DELETE FROM ".tname('report')." WHERE id IN (".simplode($newindustryids).") AND idtype='industryid'");

	//删除feed
	$_SGLOBAL['db']->query("DELETE FROM ".tname('feed')." WHERE id IN (".simplode($newindustryids).") AND idtype='industryid'");
	
	//删除脚印
	$_SGLOBAL['db']->query("DELETE FROM ".tname('clickuser')." WHERE id IN (".simplode($newindustryids).") AND idtype='industryid'");

	return $industrys;
}

function deletebranchs($branchids) {
	global $_SGLOBAL;

	//获取积分
	$reward = getreward('delbranch', 0);
	//获取博客信息
	$spaces = $branchs = $newbranchids = array();
	$allowmanage = checkperm('managebranch');
	$managebatch = checkperm('managebatch');
	$delnum = 0;
	$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('branch')." WHERE branchid IN (".simplode($branchids).")");
	while ($value = $_SGLOBAL['db']->fetch_array($query)) {
		if($allowmanage || $value['uid'] == $_SGLOBAL['supe_uid']) {
			$branchs[] = $value;
			if(!$managebatch && $value['uid'] != $_SGLOBAL['supe_uid']) {
				$delnum++;
			}
		}
	}
	if(empty($branchs) || (!$managebatch && $delnum > 1)) return array();
	
	foreach($branchs as $key => $value) {
		$newbranchids[] = $value['branchid'];
		if($allowmanage && $value['uid'] != $_SGLOBAL['supe_uid']) {
			//扣除积分
			$_SGLOBAL['db']->query("UPDATE ".tname('space')." SET credit=credit-$reward[credit], experience=experience-$reward[experience] WHERE uid='$value[uid]'");
		}
}
	//数据删除
	$_SGLOBAL['db']->query("DELETE FROM ".tname('branch')." WHERE branchid IN (".simplode($newbranchids).")");
	$_SGLOBAL['db']->query("DELETE FROM ".tname('branchfield')." WHERE branchid IN (".simplode($newbranchids).")");

	//评论
	$_SGLOBAL['db']->query("DELETE FROM ".tname('comment')." WHERE id IN (".simplode($newbranchids).") AND idtype='branchid'");

	//删除举报
	$_SGLOBAL['db']->query("DELETE FROM ".tname('report')." WHERE id IN (".simplode($newbranchids).") AND idtype='branchid'");

	//删除feed
	$_SGLOBAL['db']->query("DELETE FROM ".tname('feed')." WHERE id IN (".simplode($newbranchids).") AND idtype='branchid'");
	
	//删除脚印
	$_SGLOBAL['db']->query("DELETE FROM ".tname('clickuser')." WHERE id IN (".simplode($newbranchids).") AND idtype='branchid'");

	return $branchs;
}

function deletejobs($jobids) {
	global $_SGLOBAL;

	//获取积分
	$reward = getreward('deljob', 0);
	//获取博客信息
	$spaces = $jobs = $newjobids = array();
	$allowmanage = checkperm('managejob');
	$managebatch = checkperm('managebatch');
	$delnum = 0;
	$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('job')." WHERE jobid IN (".simplode($jobids).")");
	while ($value = $_SGLOBAL['db']->fetch_array($query)) {
		if($allowmanage || $value['uid'] == $_SGLOBAL['supe_uid']) {
			$jobs[] = $value;
			if(!$managebatch && $value['uid'] != $_SGLOBAL['supe_uid']) {
				$delnum++;
			}
		}
	}
	if(empty($jobs) || (!$managebatch && $delnum > 1)) return array();
	
	foreach($jobs as $key => $value) {
		$newjobids[] = $value['jobid'];
		if($allowmanage && $value['uid'] != $_SGLOBAL['supe_uid']) {
			//扣除积分
			$_SGLOBAL['db']->query("UPDATE ".tname('space')." SET credit=credit-$reward[credit], experience=experience-$reward[experience] WHERE uid='$value[uid]'");
		}
}
	//数据删除
	$_SGLOBAL['db']->query("DELETE FROM ".tname('job')." WHERE jobid IN (".simplode($newjobids).")");
	$_SGLOBAL['db']->query("DELETE FROM ".tname('jobfield')." WHERE jobid IN (".simplode($newjobids).")");

	//评论
	$_SGLOBAL['db']->query("DELETE FROM ".tname('comment')." WHERE id IN (".simplode($newjobids).") AND idtype='jobid'");

	//删除举报
	$_SGLOBAL['db']->query("DELETE FROM ".tname('report')." WHERE id IN (".simplode($newjobids).") AND idtype='jobid'");

	//删除feed
	$_SGLOBAL['db']->query("DELETE FROM ".tname('feed')." WHERE id IN (".simplode($newjobids).") AND idtype='jobid'");
	
	//删除脚印
	$_SGLOBAL['db']->query("DELETE FROM ".tname('clickuser')." WHERE id IN (".simplode($newjobids).") AND idtype='jobid'");

	return $jobs;
}
	
	function deletedialog($dialogid){
	global $_SGLOBAL;
	$DB = $_SGLOBAL['db'];
	$cnt = $DB->query("SELECT COUNT( * ) from ".tname("dialog")." WHERE did = $dialogid");
	if($cnt > 0){
		$DB->query("delete from ".tname("dialog")." where did = $dialogid");
		return true;
	}else {
		return false;
	}
}

function deletedialogs($dialogids) {
	global $_SGLOBAL;
	$_SGLOBAL['db']->query("DELETE FROM ".tname('dialog')." WHERE dialogid='$dialogids'");
	$_SGLOBAL['db']->query("DELETE FROM ".tname('questions')." WHERE id='$dialogids'");
	return true;
}

function deletecasess($casesids) {
	global $_SGLOBAL;

	//获取积分
	$reward = getreward('delcases', 0);
	//获取博客信息
	$spaces = $casess = $newcasesids = array();
	$allowmanage = checkperm('managecases');
	$managebatch = checkperm('managebatch');
	$delnum = 0;
	$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('cases')." WHERE casesid IN (".simplode($casesids).")");
	while ($value = $_SGLOBAL['db']->fetch_array($query)) {
		if($allowmanage || $value['uid'] == $_SGLOBAL['supe_uid']) {
			$casess[] = $value;
			if(!$managebatch && $value['uid'] != $_SGLOBAL['supe_uid']) {
				$delnum++;
			}
		}
	}
	if(empty($casess) || (!$managebatch && $delnum > 1)) return array();
	
	foreach($casess as $key => $value) {
		$newcasesids[] = $value['casesid'];
		if($allowmanage && $value['uid'] != $_SGLOBAL['supe_uid']) {
			//扣除积分
			$_SGLOBAL['db']->query("UPDATE ".tname('space')." SET credit=credit-$reward[credit], experience=experience-$reward[experience] WHERE uid='$value[uid]'");
		}
}
	//数据删除
	$_SGLOBAL['db']->query("DELETE FROM ".tname('cases')." WHERE casesid IN (".simplode($newcasesids).")");
	$_SGLOBAL['db']->query("DELETE FROM ".tname('casesfield')." WHERE casesid IN (".simplode($newcasesids).")");

	//评论
	$_SGLOBAL['db']->query("DELETE FROM ".tname('comment')." WHERE id IN (".simplode($newcasesids).") AND idtype='casesid'");

	//删除举报
	$_SGLOBAL['db']->query("DELETE FROM ".tname('report')." WHERE id IN (".simplode($newcasesids).") AND idtype='casesid'");

	//删除feed
	$_SGLOBAL['db']->query("DELETE FROM ".tname('feed')." WHERE id IN (".simplode($newcasesids).") AND idtype='casesid'");
	
	//删除脚印
	$_SGLOBAL['db']->query("DELETE FROM ".tname('clickuser')." WHERE id IN (".simplode($newcasesids).") AND idtype='casesid'");

	return $casess;
}

function deletegoods($goodsids) {
	global $_SGLOBAL;

	//获取积分
	$reward = getreward('delgoods', 0);
	//获取博客信息
	$spaces = $goodss = $newgoodsids = array();
	$allowmanage = checkperm('managegoods');
	$managebatch = checkperm('managebatch');
	$delnum = 0;
	$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('goods')." WHERE goodsid IN (".simplode($goodsids).")");
	while ($value = $_SGLOBAL['db']->fetch_array($query)) {
		if($allowmanage || $value['uid'] == $_SGLOBAL['supe_uid']) {
			$goodss[] = $value;
			if(!$managebatch && $value['uid'] != $_SGLOBAL['supe_uid']) {
				$delnum++;
			}
		}
	}
	if(empty($goodss) || (!$managebatch && $delnum > 1)) return array();
	
	foreach($goodss as $key => $value) {
		$newgoodsids[] = $value['goodsid'];
		if($allowmanage && $value['uid'] != $_SGLOBAL['supe_uid']) {
			//扣除积分
			$_SGLOBAL['db']->query("UPDATE ".tname('space')." SET credit=credit-$reward[credit], experience=experience-$reward[experience] WHERE uid='$value[uid]'");
		}
}
	//数据删除
	$_SGLOBAL['db']->query("DELETE FROM ".tname('goods')." WHERE goodsid IN (".simplode($newgoodsids).")");
	$_SGLOBAL['db']->query("DELETE FROM ".tname('goodsfield')." WHERE goodsid IN (".simplode($newgoodsids).")");

	//评论
	$_SGLOBAL['db']->query("DELETE FROM ".tname('comment')." WHERE id IN (".simplode($newgoodsids).") AND idtype='goodsid'");

	//删除举报
	$_SGLOBAL['db']->query("DELETE FROM ".tname('report')." WHERE id IN (".simplode($newgoodsids).") AND idtype='goodsid'");

	//删除feed
	$_SGLOBAL['db']->query("DELETE FROM ".tname('feed')." WHERE id IN (".simplode($newgoodsids).") AND idtype='goodsid'");
	
	//删除脚印
	$_SGLOBAL['db']->query("DELETE FROM ".tname('clickuser')." WHERE id IN (".simplode($newgoodsids).") AND idtype='goodsid'");

	return $goodss;
}

function deletestratchs($stratchids) {
	global $_SGLOBAL;
	
	$spaces = $stratchs = $newstratchids = array();
	$allowmanage = checkperm('managestratch');
	$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('stratch')." WHERE stratchid IN (".simplode($stratchids).")");
	while ($value = $_SGLOBAL['db']->fetch_array($query)) {
		if($allowmanage || $value['uid'] == $_SGLOBAL['supe_uid']) {
			$stratchs[] = $value;
			$newstratchids[] = $value['stratchid'];
			$spaces[$value['uid']]++;
		}
	}
	
	if(empty($stratchs)) return array();

	//updatespaces($spaces, 'debate');

	$_SGLOBAL['db']->query("DELETE FROM ".tname('stratch')." WHERE stratchid IN (".simplode($newstratchids).")");

	return $stratchs;
}

function deletedebates($debateids) {
	global $_SGLOBAL;
	
	$spaces = $debates = $newdebateids = array();
	$allowmanage = checkperm('managedebate');
	$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('debate')." WHERE debateid IN (".simplode($debateids).")");
	while ($value = $_SGLOBAL['db']->fetch_array($query)) {
		if($allowmanage || $value['uid'] == $_SGLOBAL['supe_uid']) {
			$debates[] = $value;
			$newdebateids[] = $value['debateid'];
			$spaces[$value['uid']]++;
		}
	}
	
	if(empty($debates)) return array();

	//updatespaces($spaces, 'debate');

	$_SGLOBAL['db']->query("DELETE FROM ".tname('debate')." WHERE debateid IN (".simplode($newdebateids).")");

	return $debates;
}

function deletedials($dialids) {
	global $_SGLOBAL;
	
	$spaces = $dials = $newdialids = array();
	$allowmanage = checkperm('managedial');
	$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('dial')." WHERE dialid IN (".simplode($dialids).")");
	while ($value = $_SGLOBAL['db']->fetch_array($query)) {
		if($allowmanage || $value['uid'] == $_SGLOBAL['supe_uid']) {
			$dials[] = $value;
			$newdialids[] = $value['dialid'];
			$spaces[$value['uid']]++;
		}
	}
	
	if(empty($dials)) return array();

	//updatespaces($spaces, 'debate');

	$_SGLOBAL['db']->query("DELETE FROM ".tname('dial')." WHERE dialid IN (".simplode($newdialids).")");

	return $dials;
}

function deleteauctions($auctionids) {
	global $_SGLOBAL;

	//获取积分
	$reward = getreward('delauction', 0);
	//获取博客信息
	$spaces = $auctions = $newauctionids = array();
	$allowmanage = checkperm('manageauction');
	$managebatch = checkperm('managebatch');
	$delnum = 0;
	$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('auction')." WHERE auctionid IN (".simplode($auctionids).")");
	while ($value = $_SGLOBAL['db']->fetch_array($query)) {
		if($allowmanage || $value['uid'] == $_SGLOBAL['supe_uid']) {
			$auctions[] = $value;
			if(!$managebatch && $value['uid'] != $_SGLOBAL['supe_uid']) {
				$delnum++;
			}
		}
	}
	if(empty($auctions) || (!$managebatch && $delnum > 1)) return array();
	
	foreach($auctions as $key => $value) {
		$newauctionids[] = $value['auctionid'];
		if($allowmanage && $value['uid'] != $_SGLOBAL['supe_uid']) {
			//扣除积分
			$_SGLOBAL['db']->query("UPDATE ".tname('space')." SET credit=credit-$reward[credit], experience=experience-$reward[experience] WHERE uid='$value[uid]'");
		}
}
	//数据删除
	$_SGLOBAL['db']->query("DELETE FROM ".tname('auction')." WHERE auctionid IN (".simplode($newauctionids).")");
	$_SGLOBAL['db']->query("DELETE FROM ".tname('auctionfield')." WHERE auctionid IN (".simplode($newauctionids).")");

	//评论
	$_SGLOBAL['db']->query("DELETE FROM ".tname('comment')." WHERE id IN (".simplode($newauctionids).") AND idtype='auctionid'");

	//删除举报
	$_SGLOBAL['db']->query("DELETE FROM ".tname('report')." WHERE id IN (".simplode($newauctionids).") AND idtype='auctionid'");

	//删除feed
	$_SGLOBAL['db']->query("DELETE FROM ".tname('feed')." WHERE id IN (".simplode($newauctionids).") AND idtype='auctionid'");
	
	//删除脚印
	$_SGLOBAL['db']->query("DELETE FROM ".tname('clickuser')." WHERE id IN (".simplode($newauctionids).") AND idtype='auctionid'");

	return $auctions;
}

function deleterecommends($recommendids) {
	global $_SGLOBAL;

	//获取积分
	$reward = getreward('delrecommend', 0);
	//获取博客信息
	$spaces = $recommends = $newrecommendids = array();
	$allowmanage = checkperm('managerecommend');
	$managebatch = checkperm('managebatch');
	$delnum = 0;
	$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('recommend')." WHERE recommendid IN (".simplode($recommendids).")");
	while ($value = $_SGLOBAL['db']->fetch_array($query)) {
		if($allowmanage || $value['uid'] == $_SGLOBAL['supe_uid']) {
			$recommends[] = $value;
			if(!$managebatch && $value['uid'] != $_SGLOBAL['supe_uid']) {
				$delnum++;
			}
		}
	}
	if(empty($recommends) || (!$managebatch && $delnum > 1)) return array();
	
	foreach($recommends as $key => $value) {
		$newrecommendids[] = $value['recommendid'];
		if($allowmanage && $value['uid'] != $_SGLOBAL['supe_uid']) {
			//扣除积分
			$_SGLOBAL['db']->query("UPDATE ".tname('space')." SET credit=credit-$reward[credit], experience=experience-$reward[experience] WHERE uid='$value[uid]'");
		}
}
	//数据删除
	$_SGLOBAL['db']->query("DELETE FROM ".tname('recommend')." WHERE recommendid IN (".simplode($newrecommendids).")");
	$_SGLOBAL['db']->query("DELETE FROM ".tname('recommendfield')." WHERE recommendid IN (".simplode($newrecommendids).")");

	//评论
	$_SGLOBAL['db']->query("DELETE FROM ".tname('comment')." WHERE id IN (".simplode($newrecommendids).") AND idtype='recommendid'");

	//删除举报
	$_SGLOBAL['db']->query("DELETE FROM ".tname('report')." WHERE id IN (".simplode($newrecommendids).") AND idtype='recommendid'");

	//删除feed
	$_SGLOBAL['db']->query("DELETE FROM ".tname('feed')." WHERE id IN (".simplode($newrecommendids).") AND idtype='recommendid'");
	
	//删除脚印
	$_SGLOBAL['db']->query("DELETE FROM ".tname('clickuser')." WHERE id IN (".simplode($newrecommendids).") AND idtype='recommendid'");

	return $recommends;
}

function deletemoblies($moblieids) {
	global $_SGLOBAL;

	//获取积分
	$reward = getreward('delmoblie', 0);
	//获取博客信息
	$spaces = $moblies = $newmoblieids = array();
	$allowmanage = checkperm('managemoblie');
	$managebatch = checkperm('managebatch');
	$delnum = 0;
	$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('moblie')." WHERE moblieid IN (".simplode($moblieids).")");
	while ($value = $_SGLOBAL['db']->fetch_array($query)) {
		if($allowmanage || $value['uid'] == $_SGLOBAL['supe_uid']) {
			$moblies[] = $value;
			if(!$managebatch && $value['uid'] != $_SGLOBAL['supe_uid']) {
				$delnum++;
			}
		}
	}
	if(empty($moblies) || (!$managebatch && $delnum > 1)) return array();
	
	foreach($moblies as $key => $value) {
		$newmoblieids[] = $value['moblieid'];
		if($allowmanage && $value['uid'] != $_SGLOBAL['supe_uid']) {
			//扣除积分
			$_SGLOBAL['db']->query("UPDATE ".tname('space')." SET credit=credit-$reward[credit], experience=experience-$reward[experience] WHERE uid='$value[uid]'");
		}
}
	//数据删除
	$_SGLOBAL['db']->query("DELETE FROM ".tname('moblie')." WHERE moblieid IN (".simplode($newmoblieids).")");
	$_SGLOBAL['db']->query("DELETE FROM ".tname('mobliefield')." WHERE moblieid IN (".simplode($newmoblieids).")");

	//评论
	$_SGLOBAL['db']->query("DELETE FROM ".tname('comment')." WHERE id IN (".simplode($newmoblieids).") AND idtype='moblieid'");

	//删除举报
	$_SGLOBAL['db']->query("DELETE FROM ".tname('report')." WHERE id IN (".simplode($newmoblieids).") AND idtype='moblieid'");

	//删除feed
	$_SGLOBAL['db']->query("DELETE FROM ".tname('feed')." WHERE id IN (".simplode($newmoblieids).") AND idtype='moblieid'");
	
	//删除脚印
	$_SGLOBAL['db']->query("DELETE FROM ".tname('clickuser')." WHERE id IN (".simplode($newmoblieids).") AND idtype='moblieid'");

	return $moblies;
}

//删除事件
function deletefeeds($feedids) {
	global $_SGLOBAL;

	$allowmanage = checkperm('managefeed');
	$managebatch = checkperm('managebatch');
	
	$delnum = 0;
	$feeds = $newfeedids = array();
	$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('feed')." WHERE feedid IN (".simplode($feedids).")");
	while ($value = $_SGLOBAL['db']->fetch_array($query)) {
		if($allowmanage || $value['uid'] == $_SGLOBAL['supe_uid']) {//管理员/作者
			$newfeedids[] = $value['feedid'];
			if(!$managebatch && $value['uid'] != $_SGLOBAL['supe_uid']) {
				$delnum++;
			}
			$feeds[] = $value;
		}
	}

	if(empty($newfeedids) || (!$managebatch && $delnum > 1)) return array();

	$_SGLOBAL['db']->query("DELETE FROM ".tname('feed')." WHERE feedid IN (".simplode($newfeedids).")");

	return $feeds;
}


//删除分享
function deleteshares($sids) {
	global $_SGLOBAL;

	$allowmanage = checkperm('manageshare');
	$managebatch = checkperm('managebatch');
	$delnum = 0;
	//获取积分
	$reward = getreward('delshare', 0);
	$spaces = $shares = $newsids = array();
	$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('share')." WHERE sid IN (".simplode($sids).")");
	while ($value = $_SGLOBAL['db']->fetch_array($query)) {
		if($allowmanage || $value['uid'] == $_SGLOBAL['supe_uid']) {//管理员/作者
			$shares[] = $value;
			if(!$managebatch && $value['uid'] != $_SGLOBAL['supe_uid']) {
				$delnum++;
			}
		}
	}
	if(empty($shares) || (!$managebatch && $delnum > 1)) return array();
	
	foreach($shares as $key => $value) {
		$newsids[] = $value['sid'];
		if($allowmanage && $value['uid'] != $_SGLOBAL['supe_uid']) {
			//扣除积分
			$_SGLOBAL['db']->query("UPDATE ".tname('space')." SET credit=credit-$reward[credit], experience=experience-$reward[experience] WHERE uid='$value[uid]'");
		}
	}

	$_SGLOBAL['db']->query("DELETE FROM ".tname('share')." WHERE sid IN (".simplode($newsids).")");

	//评论
	$_SGLOBAL['db']->query("DELETE FROM ".tname('comment')." WHERE id IN (".simplode($newsids).") AND idtype='sid'");
	
	//删除feed
	$_SGLOBAL['db']->query("DELETE FROM ".tname('feed')." WHERE id IN (".simplode($newsids).") AND idtype='sid'");

	//删除举报
	$_SGLOBAL['db']->query("DELETE FROM ".tname('report')." WHERE id IN (".simplode($newsids).") AND idtype='sid'");
	
	return $shares;
}


//删除记录
function deletedoings($ids) {
	global $_SGLOBAL;

	$allowmanage = checkperm('managedoing');
	$managebatch = checkperm('managebatch');
	$delnum = 0;
	//获取积分
	$reward = getreward('deldoing', 0);
	$spaces = $doings = $newdoids = array();
	$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('doing')." WHERE doid IN (".simplode($ids).")");
	while ($value = $_SGLOBAL['db']->fetch_array($query)) {
		if($allowmanage || $value['uid'] == $_SGLOBAL['supe_uid']) {//管理员/作者
			$doings[] = $value;
			if(!$managebatch && $value['uid'] != $_SGLOBAL['supe_uid']) {
				$delnum++;
			}
		}
	}
	
	if(empty($doings) || (!$managebatch && $delnum > 1)) return array();
	
	foreach($doings as $key => $value) {
		$newdoids[] = $value['doid'];
		if($allowmanage && $value['uid'] != $_SGLOBAL['supe_uid']) {
			//扣除积分
			$_SGLOBAL['db']->query("UPDATE ".tname('space')." SET credit=credit-$reward[credit], experience=experience-$reward[experience] WHERE uid='$value[uid]'");
		}
	}
	$_SGLOBAL['db']->query("DELETE FROM ".tname('doing')." WHERE doid IN (".simplode($newdoids).")");
	//删除评论
	$_SGLOBAL['db']->query("DELETE FROM ".tname('docomment')." WHERE doid IN (".simplode($newdoids).")");
	
	//删除feed
	$_SGLOBAL['db']->query("DELETE FROM ".tname('feed')." WHERE id IN (".simplode($newdoids).") AND idtype='doid'");

	return $doings;
}

//删除记录
function deletetalks($talkids) {
	global $_SGLOBAL;

	//获取积分
	$reward = getreward('deltalk', 0);
	//获取博客信息
	$spaces = $talks = $newtalkids = array();
	$allowmanage = checkperm('managetalk');
	$managebatch = checkperm('managebatch');
	$delnum = 0;
	$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('talk')." WHERE talkid IN (".simplode($talkids).")");
	while ($value = $_SGLOBAL['db']->fetch_array($query)) {
		if($allowmanage || $value['uid'] == $_SGLOBAL['supe_uid']) {
			$talks[] = $value;
			if(!$managebatch && $value['uid'] != $_SGLOBAL['supe_uid']) {
				$delnum++;
			}
		}
	}
	if(empty($talks) || (!$managebatch && $delnum > 1)) return array();
	
	foreach($talks as $key => $value) {
		$newtalkids[] = $value['talkid'];
		if($allowmanage && $value['uid'] != $_SGLOBAL['supe_uid']) {
			//扣除积分
			$_SGLOBAL['db']->query("UPDATE ".tname('space')." SET credit=credit-$reward[credit], experience=experience-$reward[experience] WHERE uid='$value[uid]'");
		}
}
	//数据删除
	$_SGLOBAL['db']->query("DELETE FROM ".tname('talk')." WHERE talkid IN (".simplode($newtalkids).")");
	$_SGLOBAL['db']->query("DELETE FROM ".tname('talkfield')." WHERE talkid IN (".simplode($newtalkids).")");

	//评论
	$_SGLOBAL['db']->query("DELETE FROM ".tname('comment')." WHERE id IN (".simplode($newtalkids).") AND idtype='talkid'");

	//删除举报
	$_SGLOBAL['db']->query("DELETE FROM ".tname('report')." WHERE id IN (".simplode($newtalkids).") AND idtype='talkid'");

	//删除feed
	$_SGLOBAL['db']->query("DELETE FROM ".tname('feed')." WHERE id IN (".simplode($newtalkids).") AND idtype='talkid'");
	
	//删除脚印
	$_SGLOBAL['db']->query("DELETE FROM ".tname('clickuser')." WHERE id IN (".simplode($newtalkids).") AND idtype='talkid'");

	return $talks;
}

//删除记录
function deletemenusets($menusetids) {
	global $_SGLOBAL;

	//获取积分
	$reward = getreward('delmenuset', 0);
	//获取博客信息
	$spaces = $menusets = $newmenusetids = array();
	$allowmanage = checkperm('managemenuset');
	$managebatch = checkperm('managebatch');
	$delnum = 0;
	$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('menuset')." WHERE menusetid IN (".simplode($menusetids).")");
	while ($value = $_SGLOBAL['db']->fetch_array($query)) {
		if($allowmanage || $value['uid'] == $_SGLOBAL['supe_uid']) {
			$menusets[] = $value;
			if(!$managebatch && $value['uid'] != $_SGLOBAL['supe_uid']) {
				$delnum++;
			}
		}
	}
	if(empty($menusets) || (!$managebatch && $delnum > 1)) return array();
	
	foreach($menusets as $key => $value) {
		$newmenusetids[] = $value['menusetid'];
		if($allowmanage && $value['uid'] != $_SGLOBAL['supe_uid']) {
			//扣除积分
			$_SGLOBAL['db']->query("UPDATE ".tname('space')." SET credit=credit-$reward[credit], experience=experience-$reward[experience] WHERE uid='$value[uid]'");
		}
}
	//数据删除
	$_SGLOBAL['db']->query("DELETE FROM ".tname('menuset')." WHERE menusetid IN (".simplode($newmenusetids).")");
	$_SGLOBAL['db']->query("DELETE FROM ".tname('menusetfield')." WHERE menusetid IN (".simplode($newmenusetids).")");
	$_SGLOBAL['db']->query("DELETE FROM ".tname('appset')." WHERE num IN (".simplode($newmenusetids).") and uid = $_SGLOBAL[supe_uid]");

	//评论
	$_SGLOBAL['db']->query("DELETE FROM ".tname('comment')." WHERE id IN (".simplode($newmenusetids).") AND idtype='menusetid'");

	//删除举报
	$_SGLOBAL['db']->query("DELETE FROM ".tname('report')." WHERE id IN (".simplode($newmenusetids).") AND idtype='menusetid'");

	//删除feed
	$_SGLOBAL['db']->query("DELETE FROM ".tname('feed')." WHERE id IN (".simplode($newmenusetids).") AND idtype='menusetid'");
	
	//删除脚印
	$_SGLOBAL['db']->query("DELETE FROM ".tname('clickuser')." WHERE id IN (".simplode($newmenusetids).") AND idtype='menusetid'");

	return $menusets;
}

//删除话题
function deletethreads($tagid, $tids) {
	global $_SGLOBAL;

	$tnums = $pnums = $delthreads = $newids = $spaces = array();
	$ismanager = $allowmanage = checkperm('managethread');

	$managebatch = checkperm('managebatch');
	$delnum = 0;

	//群主
	$wheresql = '';
	if(empty($allowmanage) && $tagid) {
		$mtag = getmtag($tagid);
		if($mtag['grade'] >=8) {
			$allowmanage = 1;
			$managebatch = 1;
			$wheresql = " AND t.tagid='$tagid'";
		}
	}
	//获取积分
	$reward = getreward('delthread', 0);
	$query = $_SGLOBAL['db']->query("SELECT t.* FROM ".tname('thread')." t WHERE t.tid IN(".simplode($tids).") $wheresql");
	while ($value = $_SGLOBAL['db']->fetch_array($query)) {
		if($allowmanage || $value['uid'] == $_SGLOBAL['supe_uid']) {
			$delthreads[] = $value;
			if(!$managebatch && $value['uid'] != $_SGLOBAL['supe_uid']) {
				$delnum++;
			}
		}
	}
	if(empty($delthreads) || (!$managebatch && $delnum > 1)) return array();

	foreach($delthreads as $key => $value) {
		$newids[] = $value['tid'];
		$value['isthread'] = 1;
		if($ismanager && $value['uid'] != $_SGLOBAL['supe_uid']) {
			//扣除积分
			$_SGLOBAL['db']->query("UPDATE ".tname('space')." SET credit=credit-$reward[credit], experience=experience-$reward[experience] WHERE uid='$value[uid]'");
		}
	}
	
	//删除
	$_SGLOBAL['db']->query("DELETE FROM ".tname('thread')." WHERE tid IN(".simplode($newids).")");
	$_SGLOBAL['db']->query("DELETE FROM ".tname('post')." WHERE tid IN(".simplode($newids).")");

	//删除feed
	$_SGLOBAL['db']->query("DELETE FROM ".tname('feed')." WHERE id IN (".simplode($newids).") AND idtype='tid'");
	
	//删除举报
	$_SGLOBAL['db']->query("DELETE FROM ".tname('report')." WHERE id IN (".simplode($newids).") AND idtype='tid'");
	
	//删除脚印
	$_SGLOBAL['db']->query("DELETE FROM ".tname('clickuser')." WHERE id IN (".simplode($newids).") AND idtype='tid'");

	return $delthreads;
}

//删除讨论
function deleteposts($tagid, $pollids) {
	global $_SGLOBAL;

	//统计
	$postnums = $mpostnums = $tids = $delposts = $newids = $spaces = array();
	$ismanager = $allowmanage = checkperm('managethread');
	$managebatch = checkperm('managebatch');
	$delnum = 0;

	//群主
	$wheresql = '';
	if(empty($allowmanage) && $tagid) {
		$mtag = getmtag($tagid);
		if($mtag['grade'] >=8) {
			$allowmanage = 1;
			$managebatch = 1;
			$wheresql = " AND p.tagid='$tagid'";
		}
	}
	//获取积分
	$reward = getreward('delcomment', 0);
	$query = $_SGLOBAL['db']->query("SELECT p.* FROM ".tname('post')." p WHERE p.pollid IN (".simplode($pollids).") $wheresql ORDER BY p.isthread DESC");
	while ($value = $_SGLOBAL['db']->fetch_array($query)) {
		if($allowmanage || $value['uid'] == $_SGLOBAL['supe_uid']) {
			if(!$managebatch && $value['uid'] != $_SGLOBAL['supe_uid']) {
				$delnum++;
			}
			$postarr[] = $value;
		}
	}
	if(!$managebatch && $delnum > 1) return array();
	
	foreach($postarr as $key => $value) {
		if($value['isthread']) {
			$tids[] = $value['tid'];
		} else {
			if(!in_array($value['tid'], $tids)) {
				$newids[] = $value['pollid'];
				$delposts[] = $value;
				$postnums[$value['tid']]++;
				if($ismanager && $value['uid'] != $_SGLOBAL['supe_uid']) {
					//扣除积分
					$_SGLOBAL['db']->query("UPDATE ".tname('space')." SET credit=credit-$reward[credit], experience=experience-$reward[experience] WHERE uid='$value[uid]'");
				}
			}
		}
	}
	$delthreads = array();
	if($tids) {
		$delthreads = deletethreads($tagid, $tids);
	}
	if(empty($delposts)) {
		return $delthreads;
	}

	//整理
	$nums = renum($postnums);
	foreach ($nums[0] as $pnum) {
		$_SGLOBAL['db']->query("UPDATE ".tname('thread')." SET replynum=replynum-$pnum WHERE tid IN (".simplode($nums[1][$pnum]).")");
	}

	//删除
	$_SGLOBAL['db']->query("DELETE FROM ".tname('post')." WHERE pollid IN (".simplode($newids).")");

	return $delposts;
}

//删除空间
function deletespace($uid, $force=0) {
	global $_SGLOBAL, $_SC, $_SCONFIG;

	$delspace = array();
	$allowmanage = checkperm('managedelspace');
	$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('space')." WHERE uid='$uid'");
	if($value = $_SGLOBAL['db']->fetch_array($query)) {
		if($force || $allowmanage && $value['uid'] != $_SGLOBAL['supe_uid']) {
			$delspace = $value;
			//如果不是强制删除则入删除记录表
			if(!$force) {
				$setarr = array(
					'uid' => $value['uid'],
					'username' => saddslashes($value['username']),
					'opuid' => $_SGLOBAL['supe_uid'],
					'opusername' => $_SGLOBAL['supe_username'],
					'flag' => '-1',
					'dateline' => $_SGLOBAL['timestamp']
				);
				inserttable('spacelog', $setarr, 0, true);
			}
		}
	}
	if(empty($delspace)) return array();
	
	//履盖权限设置
	$_SGLOBAL['usergroup'][$_SGLOBAL['member']['groupollid']]['managebatch'] = 1;

	//space
	$_SGLOBAL['db']->query("DELETE FROM ".tname('space')." WHERE uid='$uid'");
	//spacefield
	$_SGLOBAL['db']->query("DELETE FROM ".tname('spacefield')." WHERE uid='$uid'");

	//feed
	$_SGLOBAL['db']->query("DELETE FROM ".tname('feed')." WHERE uid='$uid' OR (id='$uid' AND idtype='uid')");

	//记录
	$doids =array();
	$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('doing')." WHERE uid='$uid'");
	while ($value = $_SGLOBAL['db']->fetch_array($query)) {
		$doids[$value['doid']] = $value['doid'];
	}
	
	$_SGLOBAL['db']->query("DELETE FROM ".tname('doing')." WHERE uid='$uid'");

	//删除记录回复
	$_SGLOBAL['db']->query("DELETE FROM ".tname('docomment')." WHERE doid IN (".simplode($doids).") OR uid='$uid'");

	//分享
	$_SGLOBAL['db']->query("DELETE FROM ".tname('share')." WHERE uid='$uid'");

	//数据
	$_SGLOBAL['db']->query("DELETE FROM ".tname('album')." WHERE uid='$uid'");
	
	//删除积分记录
	$_SGLOBAL['db']->query("DELETE FROM ".tname('creditlog')." WHERE uid='$uid'");

	//删除通知
	$_SGLOBAL['db']->query("DELETE FROM ".tname('notification')." WHERE (uid='$uid' OR authorid='$uid')");

	//删除打招呼
	$_SGLOBAL['db']->query("DELETE FROM ".tname('poke')." WHERE (uid='$uid' OR fromuid='$uid')");
	
	//删除他仓建的投票
	$pollid = array();
	$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('poll')." WHERE uid='$uid'");
	while ($value = $_SGLOBAL['db']->fetch_array($query)) {
		$pollid[$value['pollid']] = $value['pollid'];
	}
	deletepolls($pollid);
	//删除他参与的投票
	$pollid = array();
	$query = $_SGLOBAL['db']->query("SELECT pollid FROM ".tname('polluser')." WHERE uid='$uid'");
	while ($value = $_SGLOBAL['db']->fetch_array($query)) {
		$pollid[$value['pollid']] = $value['pollid'];
	}
	//扣除投票数
	if($pollid) {
		$_SGLOBAL['db']->query("UPDATE ".tname('poll')." SET voternum=voternum-1 WHERE pollid IN (".simplode($pollid).")");
	}
	$_SGLOBAL['db']->query("DELETE FROM ".tname('polluser')." WHERE uid='$uid'");
	
	//活动
	$ids = array();
	$query = $_SGLOBAL['db']->query('SELECT eventid FROM '.tname('event')." WHERE uid = '$uid'");
	while($value = $_SGLOBAL['db']->fetch_array($query)) {
		$ids[] = $value['eventid'];
	}
	deleteevents($ids);
	//删除他参加的活动
	$ids = $ids1 = $ids2 = array();
	$query = $_SGLOBAL['db']->query('SELECT * FROM '.tname('userevent')." WHERE uid = '$uid'");
	while($value = $_SGLOBAL['db']->fetch_array($query)) {
		if($value['status'] == 1) {
			$ids1[] = $value['eventid'];//关注
		} elseif($value['status'] > 1) {
			$ids2[] = $value['eventid'];//参加
		}
		$ids[] = $value['eventid'];
	}
	if($ids1) {
		$_SGLOBAL['db']->query('UPDATE '.tname('event').' SET follownum = follownum - 1 WHERE eventid IN ('.simplode($ids1).')');
	}
	if($ids2) {
		$_SGLOBAL['db']->query('UPDATE '.tname('event').' SET membernum = membernum - 1 WHERE eventid IN ('.simplode($ids2).')');// to to: 最好还要检查并减去他携带的人数
	}
	if($ids) {
		$_SGLOBAL['db']->query('DELETE FROM '.tname('userevent').' WHERE eventid IN ('.simplode($ids).") AND uid = '$uid'");
	}
	//删除相关活动邀请
	$_SGLOBAL['db']->query('DELETE FROM '.tname('eventinvite')." WHERE uid = '$uid' OR touid = '$uid'");
	//删除上传的活动图片
	$_SGLOBAL['db']->query('DELETE FROM '.tname('eventpic')." WHERE picid = '$uid'");//to do: 最好同时更新活动图片数和活动话题数
	
	//道具
	$_SGLOBAL['db']->query('DELETE FROM '.tname('usermagic')." WHERE uid = '$uid'");
	$_SGLOBAL['db']->query('DELETE FROM '.tname('magicinlog')." WHERE uid = '$uid'");
	$_SGLOBAL['db']->query('DELETE FROM '.tname('magicuselog')." WHERE uid = '$uid'");
	
	//pic
	//删除图片附件
	$pics = array();
	$query = $_SGLOBAL['db']->query("SELECT filepath FROM ".tname('pic')." WHERE uid='$uid'");
	while ($value = $_SGLOBAL['db']->fetch_array($query)) {
		$pics[] = $value;
	}
	//数据
	$_SGLOBAL['db']->query("DELETE FROM ".tname('pic')." WHERE uid='$uid'");

	//blog
	$blogids = array();
	$query = $_SGLOBAL['db']->query("SELECT blogid FROM ".tname('blog')." WHERE uid='$uid'");
	while ($value = $_SGLOBAL['db']->fetch_array($query)) {
		$blogids[$value['blogid']] = $value['blogid'];
		//tag
		$tags = array();
		$subquery = $_SGLOBAL['db']->query("SELECT tagid, blogid FROM ".tname('tagblog')." WHERE blogid='$value[blogid]'");
		while ($tag = $_SGLOBAL['db']->fetch_array($subquery)) {
			$tags[$tag['tagid']] = $tag['tagid'];
		}
		if($tags) {
			$_SGLOBAL['db']->query("UPDATE ".tname('tag')." SET blognum=blognum-1 WHERE tagid IN (".simplode($tags).")");
			$_SGLOBAL['db']->query("DELETE FROM ".tname('tagblog')." WHERE blogid='$value[blogid]'");
		}
	}
	//数据删除
	$_SGLOBAL['db']->query("DELETE FROM ".tname('blog')." WHERE uid='$uid'");
	$_SGLOBAL['db']->query("DELETE FROM ".tname('blogfield')." WHERE uid='$uid'");

	//评论
	$_SGLOBAL['db']->query("DELETE FROM ".tname('comment')." WHERE (uid='$uid' OR authorid='$uid' OR (id='$uid' AND idtype='uid'))");

	//访客
	$_SGLOBAL['db']->query("DELETE FROM ".tname('visitor')." WHERE (uid='$uid' OR vuid='$uid')");

	//删除任务记录
	$_SGLOBAL['db']->query("DELETE FROM ".tname('usertask')." WHERE uid='$uid'");

	//class
	$_SGLOBAL['db']->query("DELETE FROM ".tname('class')." WHERE uid='$uid'");

	//friend
	//好友
	$_SGLOBAL['db']->query("DELETE FROM ".tname('friend')." WHERE (uid='$uid' OR fuid='$uid')");

	//member
	$_SGLOBAL['db']->query("DELETE FROM ".tname('member')." WHERE uid='$uid'");

	//删除脚印
	$_SGLOBAL['db']->query("DELETE FROM ".tname('clickuser')." WHERE uid='$uid'");

	//删除黑名单
	$_SGLOBAL['db']->query("DELETE FROM ".tname('blacklist')." WHERE (uid='$uid' OR buid='$uid')");

	//删除邀请记录
	$_SGLOBAL['db']->query("DELETE FROM ".tname('invite')." WHERE (uid='$uid' OR fuid='$uid')");

	//删除邮件队列
	$_SGLOBAL['db']->query("DELETE FROM ".tname('mailcron').", ".tname('mailqueue')." USING ".tname('mailcron').", ".tname('mailqueue')." WHERE ".tname('mailcron').".touid='$uid' AND ".tname('mailcron').".cid=".tname('mailqueue').".cid");

	//漫游邀请
	$_SGLOBAL['db']->query("DELETE FROM ".tname('myinvite')." WHERE (touid='$uid' OR fromuid='$uid')");
	$_SGLOBAL['db']->query("DELETE FROM ".tname('userapp')." WHERE uid='$uid'");
	$_SGLOBAL['db']->query("DELETE FROM ".tname('userappfield')." WHERE uid='$uid'");

	//mtag
	//thread
	$tids = array();
	$query = $_SGLOBAL['db']->query("SELECT tid, tagid FROM ".tname('thread')." WHERE uid='$uid'");
	while ($value = $_SGLOBAL['db']->fetch_array($query)) {
		$tids[$value['tagid']][] = $value['tid'];
	}
	foreach ($tids as $tagid => $v_tids) {
		deletethreads($tagid, $v_tids);
	}

	//post
	$pollids = array();
	$query = $_SGLOBAL['db']->query("SELECT pollid, tagid FROM ".tname('post')." WHERE uid='$uid'");
	while ($value = $_SGLOBAL['db']->fetch_array($query)) {
		$pollids[$value['tagid']][] = $value['pollid'];
	}
	foreach ($pollids as $tagid => $v_pollids) {
		deleteposts($tagid, $v_pollids);
	}
	$_SGLOBAL['db']->query("DELETE FROM ".tname('thread')." WHERE uid='$uid'");
	$_SGLOBAL['db']->query("DELETE FROM ".tname('post')." WHERE uid='$uid'");

	//session
	$_SGLOBAL['db']->query("DELETE FROM ".tname('session')." WHERE uid='$uid'");

	//排行榜
	$_SGLOBAL['db']->query("DELETE FROM ".tname('show')." WHERE uid='$uid'");

	//群组
	$mtagids = array();
	$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('tagspace')." WHERE uid='$uid'");
	while ($value = $_SGLOBAL['db']->fetch_array($query)) {
		$mtagids[$value['tagid']] = $value['tagid'];
	}
	if($mtagids) {
		$_SGLOBAL['db']->query("UPDATE ".tname('mtag')." SET membernum=membernum-1 WHERE tagid IN (".simplode($mtagids).")");
		$_SGLOBAL['db']->query("DELETE FROM ".tname('tagspace')." WHERE uid='$uid'");
	}

	$_SGLOBAL['db']->query("DELETE FROM ".tname('mtaginvite')." WHERE (uid='$uid' OR fromuid='$uid')");

	//删除图片
	deletepicfiles($pics);//删除图片
	
	//删除举报
	$_SGLOBAL['db']->query("DELETE FROM ".tname('report')." WHERE id='$uid' AND idtype='uid'");
	
	
	//变更记录
	if($_SCONFIG['my_status']) inserttable('userlog', array('uid'=>$uid, 'action'=>'delete', 'dateline'=>$_SGLOBAL['timestamp']), 0, true);

	return $delspace;
}

//删除图片
function deletepics($picids) {
	global $_SGLOBAL, $_SC;

	$delpics = $albumnums = $newids = $sizes = $auids = $spaces = array();
	$allowmanage = checkperm('managealbum');
	$managebatch = checkperm('managebatch');
	$delnum = 0;

	$pics = array();
	
	$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('pic')." WHERE picid IN (".simplode($picids).")");
	while ($value = $_SGLOBAL['db']->fetch_array($query)) {
		if($allowmanage || $value['uid'] == $_SGLOBAL['supe_uid']) {
			//删除文件
			$pics[] = $value;
			$newids[] = $value['picid'];
			$delpics[] = $value;
			$allsize = $allsize + $value['size'];
			$sizes[$value['uid']] = $sizes[$value['uid']] + $value['size'];
			if($value['albumid']) {
				$auids[$value['albumid']] = $value['uid'];
				$albumnums[$value['albumid']]++;
			}
			if($value['uid'] != $_SGLOBAL['supe_uid']) {
				if(!$managebatch) {
					$delnum++;
				}
				$spaces[$value['uid']]++;
			}
			
		}
	}
	if(empty($delpics) || (!$managebatch && $delnum > 1)) return array();

	//获取积分
	$reward = getreward('delimage', 0);
	foreach ($spaces as $uid => $picnum) {
		$attachsize = intval($sizes[$uid]);
		$setsql = '';
		if($allowmanage) {
			$setsql = $reward['credit']?(",credit=credit-".($picnum*$reward['credit'])):"";
			$setsql .= $reward['experience']?(",experience=experience-".($picnum*$reward['experience'])):"";
		}
		$_SGLOBAL['db']->query("UPDATE ".tname('space')." SET attachsize=attachsize-$attachsize $setsql WHERE uid='$uid'");
	}

	if($newids) {
		$_SGLOBAL['db']->query("DELETE FROM ".tname('pic')." WHERE picid IN (".simplode($newids).")");
		$_SGLOBAL['db']->query("DELETE FROM ".tname('comment')." WHERE id IN (".simplode($newids).") AND idtype='picid'");
		$_SGLOBAL['db']->query("DELETE FROM ".tname('feed')." WHERE id IN (".simplode($newids).") AND idtype='picid'");

		//删除举报
		$_SGLOBAL['db']->query("DELETE FROM ".tname('report')." WHERE id IN (".simplode($newids).") AND idtype='picid'");
			
		//删除脚印
		$_SGLOBAL['db']->query("DELETE FROM ".tname('clickuser')." WHERE id IN (".simplode($newids).") AND idtype='picid'");
	}
	if($albumnums) {
		include_once(S_ROOT.'./source/function_cp.php');
		foreach ($albumnums as $id => $num) {
			$thepic = getalbumpic($auids[$id], $id);
			$_SGLOBAL['db']->query("UPDATE ".tname('album')." SET pic='$thepic', picnum=picnum-$num WHERE albumid='$id'");
		}
	}

	//删除图片
	deletepicfiles($pics);

	return $delpics;
}

//删除图片文件
function deletepicfiles($pics) {
	global $_SGLOBAL, $_SC;
	$remotes = array();
	foreach ($pics as $pic) {
		if($pic['remote']) {
			$remotes[] = $pic;
		} else {
			$file = $_SC['attachdir'].'./'.$pic['filepath'];
			if(!@unlink($file)) {
				runlog('PIC', "Delete pic file '$file' error.", 0);
			}
			if($pic['thumb']) {
				if(!@unlink($file.'.thumb.jpg')) {
					runlog('PIC', "Delete pic file '{$file}.thumb.jpg' error.", 0);
				}
			}
		}
	}
	//删除远程附件
	if($remotes) {
		include_once(S_ROOT.'./data/data_setting.php');
		include_once(S_ROOT.'./source/function_ftp.php');
		$ftpconnid = sftp_connect();
		foreach ($remotes as $pic) {
			$file = $pic['filepath'];
			if($ftpconnid) {
				if(!sftp_delete($ftpconnid, $file)) {
					runlog('FTP', "Delete pic file '$file' error.", 0);
				}
				if($pic['thumb'] && !sftp_delete($ftpconnid, $file.'.thumb.jpg')) {
					runlog('FTP', "Delete pic file '{$file}.thumb.jpg' error.", 0);
				}
			} else {
				runlog('FTP', "Delete pic file '$file' error.", 0);
				if($pic['thumb']) {
					runlog('FTP', "Delete pic file '{$file}.thumb.jpg' error.", 0);
				}
			}
		}
	}
}

//删除相册
function deletealbums($albumids) {
	global $_SGLOBAL, $_SC;

	$dels = $newids = $sizes = $spaces = array();
	$allowmanage = checkperm('managealbum');
	$managebatch = checkperm('managebatch');
	$delnum = 0;

	$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('album')." WHERE albumid IN (".simplode($albumids).")");
	while ($value = $_SGLOBAL['db']->fetch_array($query)) {
		if($allowmanage || $value['uid'] == $_SGLOBAL['supe_uid']) {
			$dels[] = $value;
			$newids[] = $value['albumid'];
			if(!$managebatch && $value['uid'] != $_SGLOBAL['supe_uid']) {
				$delnum++;
			}
		}
	}
	if(empty($dels) || (!$managebatch && $delnum > 1)) return array();
	//获取积分
	$reward = getreward('delimage', 0);
	$pics = array();
	$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('pic')." WHERE albumid IN (".simplode($newids).")");
	while ($value = $_SGLOBAL['db']->fetch_array($query)) {
		$sizes[$value['uid']] = $sizes[$value['uid']] + $value['size'];
		$pics[] = $value;
		$setsql = '';
		if($allowmanage && $value['uid'] != $_SGLOBAL['supe_uid']) {
			//扣除积分
			$setsql = $reward['credit']?(",credit=credit-$reward[credit]"):"";
			$setsql .= $reward['experience']?(",experience=experience-$reward[experience]"):"";
		}
		$_SGLOBAL['db']->query("UPDATE ".tname('space')." SET attachsize=attachsize-$value[size] $setsql WHERE uid='$value[uid]'");
	}

	if($sizes) {
		$_SGLOBAL['db']->query("DELETE FROM ".tname('pic')." WHERE albumid IN (".simplode($newids).")");
	}

	$_SGLOBAL['db']->query("DELETE FROM ".tname('album')." WHERE albumid IN (".simplode($newids).")");
	$_SGLOBAL['db']->query("DELETE FROM ".tname('feed')." WHERE id IN (".simplode($newids).") AND idtype='albumid'");
	
	//删除举报
	$_SGLOBAL['db']->query("DELETE FROM ".tname('report')." WHERE id IN (".simplode($newids).") AND idtype='albumid'");

	//删除图片
	if($pics) {
		deletepicfiles($pics);//删除图片
	}

	return $dels;
}

//删除tag
function deletetags($tagids) {
	global $_SGLOBAL;
	
	if(!checkperm('managetag')) return false;

	//数据
	$_SGLOBAL['db']->query("DELETE FROM ".tname('tagblog')." WHERE tagid IN (".simplode($tagids).")");
	$_SGLOBAL['db']->query("DELETE FROM ".tname('tag')." WHERE tagid IN (".simplode($tagids).")");

	return true;
}

//删除mtag
function deletemtag($tagids) {
	global $_SGLOBAL;

	if(!checkperm('manageprofield') && !checkperm('managemtag')) return array();

	$dels = $newids = array();
	$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('mtag')." WHERE tagid IN (".simplode($tagids).")");
	while ($value = $_SGLOBAL['db']->fetch_array($query)) {
		$newids[] = $value['tagid'];
		$dels[] = $value;
	}
	if(empty($newids)) return array();

	//数据
	$_SGLOBAL['db']->query("DELETE FROM ".tname('tagspace')." WHERE tagid IN (".simplode($newids).")");
	$_SGLOBAL['db']->query("DELETE FROM ".tname('mtag')." WHERE tagid IN (".simplode($newids).")");
	$_SGLOBAL['db']->query("DELETE FROM ".tname('thread')." WHERE tagid IN (".simplode($newids).")");
	$_SGLOBAL['db']->query("DELETE FROM ".tname('post')." WHERE tagid IN (".simplode($newids).")");
	$_SGLOBAL['db']->query("DELETE FROM ".tname('mtaginvite')." WHERE tagid IN (".simplode($newids).")");

	//删除举报
	$_SGLOBAL['db']->query("DELETE FROM ".tname('report')." WHERE id IN (".simplode($newids).") AND idtype='tagid'");
	return $dels;
}

//删除用户栏目
function deleteprofilefield($fieldids) {
	global $_SGLOBAL;

	if(!checkperm('manageprofilefield')) return false;

	//删除数据
	$_SGLOBAL['db']->query("DELETE FROM ".tname('profilefield')." WHERE fieldid IN (".simplode($fieldids).")");
	//更改表结构
	foreach ($fieldids as $id) {
		$_SGLOBAL['db']->query("ALTER TABLE ".tname('spacefield')." DROP `field_$id`", 'SILENT');
	}

	return true;
}

//删除栏目
function deleteprofield($fieldids, $newfieldid) {
	global $_SGLOBAL;

	if(!checkperm('manageprofield')) return false;

	//删除数据
	$_SGLOBAL['db']->query("DELETE FROM ".tname('profield')." WHERE fieldid IN (".simplode($fieldids).")");

	//更新栏目
	$_SGLOBAL['db']->query("UPDATE ".tname('mtag')." SET fieldid='$newfieldid' WHERE fieldid IN (".simplode($fieldids).")");

	return true;
}

//广告删除
function deleteads($adids) {
	global $_SGLOBAL;

	if(!checkperm('managead')) return false;

	$dels = $newids = array();
	$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('ad')." WHERE adid IN (".simplode($adids).")");
	while ($value = $_SGLOBAL['db']->fetch_array($query)) {
		//删除模板与模板编译文件
		$tpl = S_ROOT."./data/adtpl/$value[adid].htm";//原始
		swritefile($tpl, ' ');

		$newids[] = $value['adid'];
		$dels[] = $value;
	}
	if(empty($dels)) return array();

	//数据
	$_SGLOBAL['db']->query("DELETE FROM ".tname('ad')." WHERE adid IN (".simplode($newids).")");

	return $dels;
}

//模块删除
function deleteblocks($bids) {
	global $_SGLOBAL;

	if(!checkperm('managead')) return false;

	$dels = $newids = array();
	$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('block')." WHERE bid IN (".simplode($bids).")");
	while ($value = $_SGLOBAL['db']->fetch_array($query)) {
		//删除模板与模板编译文件
		$tpl = S_ROOT."./data/blocktpl/$value[bid].htm";//原始
		swritefile($tpl, ' ');

		$newids[] = $value['bid'];
		$dels[] = $value;
	}
	if(empty($dels)) return array();

	//数据
	$_SGLOBAL['db']->query("DELETE FROM ".tname('block')." WHERE bid IN (".simplode($newids).")");

	return $dels;
}

//删除热闹
function deletetopics($ids) {
	global $_SGLOBAL;
	
	//数据
	$newids = array();
	$managetopic = checkperm('managetopic');
	$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('topic')." WHERE topicid IN (".simplode($ids).")");
	while ($value = $_SGLOBAL['db']->fetch_array($query)) {
		if($managetopic || $value['uid'] == $_SGLOBAL['supe_uid']) {
			$newids[] = $value['topicid'];
		}
		
	}
	if($newids) {
		$_SGLOBAL['db']->query("DELETE FROM ".tname('topic')." WHERE topicid IN (".simplode($newids).")");
		return true;
	} else {
		return false;
	}
}

//删除投票
function deletepolls($pollids) {
	global $_SGLOBAL;
	//获取投票信息
	$sparecredit = $spaces = $polls = $newpollids = array();
	//获取积分
	$reward = getreward('delpoll', 0);
	$allowmanage = checkperm('managepoll');
	$managebatch = checkperm('managebatch');
	$delnum = 0;
	$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('poll')." WHERE pollid IN (".simplode($pollids).")");
	while ($value = $_SGLOBAL['db']->fetch_array($query)) {
		if($allowmanage || $value['uid'] == $_SGLOBAL['supe_uid']) {
			$polls[] = $value;
			if(!$managebatch && $value['uid'] != $_SGLOBAL['supe_uid']) {
				$delnum++;
			}
		}
	}
	if(empty($polls) || (!$managebatch && $delnum > 1)) return array();

	foreach($polls as $key => $value) {
		$newpollids[] = $value['pollid'];
		if($allowmanage && $value['uid'] != $_SGLOBAL['supe_uid']) {
			//扣除积分
			$_SGLOBAL['db']->query("UPDATE ".tname('space')." SET credit=credit-$reward[credit], experience=experience-$reward[experience] WHERE uid='$value[uid]'");
		}
		//归还未悬赏完的积分
		if($value['credit'] > 0) {
			$sparecredit = intval($value['credit']);
			$_SGLOBAL['db']->query("UPDATE ".tname('space')." SET credit=credit+$sparecredit WHERE uid='$value[uid]'");
		}
	}

	//数据删除
	$_SGLOBAL['db']->query("DELETE FROM ".tname('poll')." WHERE pollid IN (".simplode($newpollids).")");
	$_SGLOBAL['db']->query("DELETE FROM ".tname('pollfield')." WHERE pollid IN (".simplode($newpollids).")");
	$_SGLOBAL['db']->query("DELETE FROM ".tname('polloption')." WHERE pollid IN (".simplode($newpollids).")");
	$_SGLOBAL['db']->query("DELETE FROM ".tname('polluser')." WHERE pollid IN (".simplode($newpollids).")");
	//评论
	$_SGLOBAL['db']->query("DELETE FROM ".tname('comment')." WHERE id IN (".simplode($newpollids).") AND idtype='pollid'");
	
	$_SGLOBAL['db']->query("DELETE FROM ".tname('feed')." WHERE id IN (".simplode($newpollids).") AND idtype='pollid'");
	
	//删除举报
	$_SGLOBAL['db']->query("DELETE FROM ".tname('report')." WHERE id IN (".simplode($newpollids).") AND idtype='pollid'");
	
	return $polls;
	
}

// 删除活动
function deleteevents($eventids){
    global $_SGLOBAL;
    
	$allowmanage = checkperm('manageevent');
	$managebatch = checkperm('managebatch');
	$delnum = 0;
	$eventarr = $neweventids = $note_ids = $note_inserts = array();
    //获取积分
	$reward = getreward('delevent', 0);
	$query = $_SGLOBAL['db']->query("SELECT * FROM ". tname("event") . " WHERE eventid IN (" . simplode($eventids).")");
	while($value=$_SGLOBAL['db']->fetch_array($query)){
	    if($allowmanage || $value['uid'] == $_SGLOBAL['supe_uid']){
	    	$eventarr[] = $value;
		    if(!$managebatch && $value['uid'] != $_SGLOBAL['supe_uid']) {
				$delnum++;
			}
	    }
	}

	if(empty($eventarr) || (!$managebatch && $delnum > 1))    return array();
	
	foreach($eventarr as $key => $value) {
		$neweventids[] = $value['eventid'];
		// [to do: 给活动参加者发通知。操作量太大，所以优先级：低]
		if($value['uid'] != $_SGLOBAL['supe_uid']) {
			if($allowmanage) {
	        	//扣除积分
	        	$_SGLOBAL['db']->query("UPDATE ".tname('space')." SET credit=credit-$reward[credit], experience=experience-$reward[experience] WHERE uid='$value[uid]'");
	        }
	        $note_ids[] = $value['uid'];
			$note_msg = cplang('event_set_delete', array($value['title']));
			$note_inserts[] = "('$value[uid]', 'event', '1', '$_SGLOBAL[supe_uid]', '$_SGLOBAL[supe_username]', '".addslashes($note_msg)."', '$_SGLOBAL[timestamp]')";
		}
	}

    //数据删除
	$_SGLOBAL['db']->query("DELETE FROM ".tname('event')." WHERE eventid IN (".simplode($neweventids).")");
	$_SGLOBAL['db']->query("DELETE FROM ".tname('eventpic')." WHERE eventid IN (".simplode($neweventids).")");
	$_SGLOBAL['db']->query("DELETE FROM ".tname('eventinvite')." WHERE eventid IN (".simplode($neweventids).")");

	//活动用户
	$_SGLOBAL['db']->query("DELETE FROM ".tname('userevent')." WHERE eventid IN (".simplode($neweventids).")");

	//评论
	$_SGLOBAL['db']->query("DELETE FROM ".tname('comment')." WHERE id IN (".simplode($neweventids).") AND idtype='eventid'");

	$_SGLOBAL['db']->query("DELETE FROM ".tname('feed')." WHERE id IN (".simplode($neweventids).") AND idtype='eventid'");
	
	//删除举报
	$_SGLOBAL['db']->query("DELETE FROM ".tname('report')." WHERE id IN (".simplode($neweventids).") AND idtype='eventid'");

	//发送通知
	if($note_inserts){
		$_SGLOBAL['db']->query("INSERT INTO ".tname('notification')." (`uid`, `type`, `new`, `authorid`, `author`, `note`, `dateline`) VALUES ".implode(',', $note_inserts));
		$_SGLOBAL['db']->query("UPDATE ".tname('space')." SET notenum=notenum+1 WHERE uid IN (".simplode($note_ids).")");
	}
	return $eventarr;
}

?>