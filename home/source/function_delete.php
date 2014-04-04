<?php
/*
	[UCenter Home] (C) 2007-2008 Comsenz Inc.
	$Id: function_delete.php 13001 2009-08-05 06:18:06Z zhengqingpeng $
*/

if(!defined('IN_UCHOME')) {
	exit('Access Denied');
}

//ɾ������
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
			//�۳�����
			$_SGLOBAL['db']->query("UPDATE ".tname('space')." SET credit=credit-$reward[credit], experience=experience-$reward[experience] WHERE uid='$value[authorid]'");
		}
	}

	//����ɾ��
	$_SGLOBAL['db']->query("DELETE FROM ".tname('comment')." WHERE cid IN (".simplode($newcids).")");

	//ͳ������
	$nums = renum($blognums);
	foreach ($nums[0] as $num) {
		$_SGLOBAL['db']->query("UPDATE ".tname('blog')." SET replynum=replynum-$num WHERE blogid IN (".simplode($nums[1][$num]).")");
	}
	
	return $dels;
}


//ɾ������
function deleteblogs($blogids) {
	global $_SGLOBAL;

	//��ȡ����
	$reward = getreward('delblog', 0);
	//��ȡ������Ϣ
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
			//�۳�����
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

	//����ɾ��
	$_SGLOBAL['db']->query("DELETE FROM ".tname('blog')." WHERE blogid IN (".simplode($newblogids).")");
	$_SGLOBAL['db']->query("DELETE FROM ".tname('blogfield')." WHERE blogid IN (".simplode($newblogids).")");

	//����
	$_SGLOBAL['db']->query("DELETE FROM ".tname('comment')." WHERE id IN (".simplode($newblogids).") AND idtype='blogid'");

	//ɾ���ٱ�
	$_SGLOBAL['db']->query("DELETE FROM ".tname('report')." WHERE id IN (".simplode($newblogids).") AND idtype='blogid'");

	//ɾ��feed
	$_SGLOBAL['db']->query("DELETE FROM ".tname('feed')." WHERE id IN (".simplode($newblogids).") AND idtype='blogid'");
	
	//ɾ����ӡ
	$_SGLOBAL['db']->query("DELETE FROM ".tname('clickuser')." WHERE id IN (".simplode($newblogids).") AND idtype='blogid'");

	return $blogs;
}
function deleteintroduces($introduceids) {
	global $_SGLOBAL;

	//��ȡ����
	$reward = getreward('delintroduce', 0);
	//��ȡ������Ϣ
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
			//�۳�����
			$_SGLOBAL['db']->query("UPDATE ".tname('space')." SET credit=credit-$reward[credit], experience=experience-$reward[experience] WHERE uid='$value[uid]'");
		}

	}

	//����ɾ��
	$_SGLOBAL['db']->query("DELETE FROM ".tname('introduce')." WHERE introduceid IN (".simplode($newintroduceids).")");
	$_SGLOBAL['db']->query("DELETE FROM ".tname('introducefield')." WHERE introduceid IN (".simplode($newintroduceids).")");

	//����
	$_SGLOBAL['db']->query("DELETE FROM ".tname('comment')." WHERE id IN (".simplode($newintroduceids).") AND idtype='introduceid'");

	//ɾ���ٱ�
	$_SGLOBAL['db']->query("DELETE FROM ".tname('report')." WHERE id IN (".simplode($newintroduceids).") AND idtype='introduceid'");

	//ɾ��feed
	$_SGLOBAL['db']->query("DELETE FROM ".tname('feed')." WHERE id IN (".simplode($newintroduceids).") AND idtype='introduceid'");
	
	//ɾ����ӡ
	$_SGLOBAL['db']->query("DELETE FROM ".tname('clickuser')." WHERE id IN (".simplode($newintroduceids).") AND idtype='introduceid'");

	return $introduces;
}
function deleteproducts($productids) {
	global $_SGLOBAL;

	//��ȡ����
	$reward = getreward('delproduct', 0);
	//��ȡ������Ϣ
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
			//�۳�����
			$_SGLOBAL['db']->query("UPDATE ".tname('space')." SET credit=credit-$reward[credit], experience=experience-$reward[experience] WHERE uid='$value[uid]'");
		}
}
	//����ɾ��
	$_SGLOBAL['db']->query("DELETE FROM ".tname('product')." WHERE productid IN (".simplode($newproductids).")");
	$_SGLOBAL['db']->query("DELETE FROM ".tname('productfield')." WHERE productid IN (".simplode($newproductids).")");

	//����
	$_SGLOBAL['db']->query("DELETE FROM ".tname('comment')." WHERE id IN (".simplode($newproductids).") AND idtype='productid'");

	//ɾ���ٱ�
	$_SGLOBAL['db']->query("DELETE FROM ".tname('report')." WHERE id IN (".simplode($newproductids).") AND idtype='productid'");

	//ɾ��feed
	$_SGLOBAL['db']->query("DELETE FROM ".tname('feed')." WHERE id IN (".simplode($newproductids).") AND idtype='productid'");
	
	//ɾ����ӡ
	$_SGLOBAL['db']->query("DELETE FROM ".tname('clickuser')." WHERE id IN (".simplode($newproductids).") AND idtype='productid'");

	return $products;
}
function deletedevelopments($developmentids) {
	global $_SGLOBAL;

	//��ȡ����
	$reward = getreward('deldevelopment', 0);
	//��ȡ������Ϣ
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
			//�۳�����
			$_SGLOBAL['db']->query("UPDATE ".tname('space')." SET credit=credit-$reward[credit], experience=experience-$reward[experience] WHERE uid='$value[uid]'");
		}
}
	//����ɾ��
	$_SGLOBAL['db']->query("DELETE FROM ".tname('development')." WHERE developmentid IN (".simplode($newdevelopmentids).")");
	$_SGLOBAL['db']->query("DELETE FROM ".tname('developmentfield')." WHERE developmentid IN (".simplode($newdevelopmentids).")");

	//����
	$_SGLOBAL['db']->query("DELETE FROM ".tname('comment')." WHERE id IN (".simplode($newdevelopmentids).") AND idtype='developmentid'");

	//ɾ���ٱ�
	$_SGLOBAL['db']->query("DELETE FROM ".tname('report')." WHERE id IN (".simplode($newdevelopmentids).") AND idtype='developmentid'");

	//ɾ��feed
	$_SGLOBAL['db']->query("DELETE FROM ".tname('feed')." WHERE id IN (".simplode($newdevelopmentids).") AND idtype='developmentid'");
	
	//ɾ����ӡ
	$_SGLOBAL['db']->query("DELETE FROM ".tname('clickuser')." WHERE id IN (".simplode($newdevelopmentids).") AND idtype='developmentid'");

	return $developments;
}


//ɾ������
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

	//��ȡ����
	$reward = getreward('delindustry', 0);
	//��ȡ������Ϣ
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
			//�۳�����
			$_SGLOBAL['db']->query("UPDATE ".tname('space')." SET credit=credit-$reward[credit], experience=experience-$reward[experience] WHERE uid='$value[uid]'");
		}
}
	//����ɾ��
	$_SGLOBAL['db']->query("DELETE FROM ".tname('industry')." WHERE industryid IN (".simplode($newindustryids).")");
	$_SGLOBAL['db']->query("DELETE FROM ".tname('industryfield')." WHERE industryid IN (".simplode($newindustryids).")");

	//����
	$_SGLOBAL['db']->query("DELETE FROM ".tname('comment')." WHERE id IN (".simplode($newindustryids).") AND idtype='industryid'");

	//ɾ���ٱ�
	$_SGLOBAL['db']->query("DELETE FROM ".tname('report')." WHERE id IN (".simplode($newindustryids).") AND idtype='industryid'");

	//ɾ��feed
	$_SGLOBAL['db']->query("DELETE FROM ".tname('feed')." WHERE id IN (".simplode($newindustryids).") AND idtype='industryid'");
	
	//ɾ����ӡ
	$_SGLOBAL['db']->query("DELETE FROM ".tname('clickuser')." WHERE id IN (".simplode($newindustryids).") AND idtype='industryid'");

	return $industrys;
}

function deletebranchs($branchids) {
	global $_SGLOBAL;

	//��ȡ����
	$reward = getreward('delbranch', 0);
	//��ȡ������Ϣ
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
			//�۳�����
			$_SGLOBAL['db']->query("UPDATE ".tname('space')." SET credit=credit-$reward[credit], experience=experience-$reward[experience] WHERE uid='$value[uid]'");
		}
}
	//����ɾ��
	$_SGLOBAL['db']->query("DELETE FROM ".tname('branch')." WHERE branchid IN (".simplode($newbranchids).")");
	$_SGLOBAL['db']->query("DELETE FROM ".tname('branchfield')." WHERE branchid IN (".simplode($newbranchids).")");

	//����
	$_SGLOBAL['db']->query("DELETE FROM ".tname('comment')." WHERE id IN (".simplode($newbranchids).") AND idtype='branchid'");

	//ɾ���ٱ�
	$_SGLOBAL['db']->query("DELETE FROM ".tname('report')." WHERE id IN (".simplode($newbranchids).") AND idtype='branchid'");

	//ɾ��feed
	$_SGLOBAL['db']->query("DELETE FROM ".tname('feed')." WHERE id IN (".simplode($newbranchids).") AND idtype='branchid'");
	
	//ɾ����ӡ
	$_SGLOBAL['db']->query("DELETE FROM ".tname('clickuser')." WHERE id IN (".simplode($newbranchids).") AND idtype='branchid'");

	return $branchs;
}

function deletejobs($jobids) {
	global $_SGLOBAL;

	//��ȡ����
	$reward = getreward('deljob', 0);
	//��ȡ������Ϣ
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
			//�۳�����
			$_SGLOBAL['db']->query("UPDATE ".tname('space')." SET credit=credit-$reward[credit], experience=experience-$reward[experience] WHERE uid='$value[uid]'");
		}
}
	//����ɾ��
	$_SGLOBAL['db']->query("DELETE FROM ".tname('job')." WHERE jobid IN (".simplode($newjobids).")");
	$_SGLOBAL['db']->query("DELETE FROM ".tname('jobfield')." WHERE jobid IN (".simplode($newjobids).")");

	//����
	$_SGLOBAL['db']->query("DELETE FROM ".tname('comment')." WHERE id IN (".simplode($newjobids).") AND idtype='jobid'");

	//ɾ���ٱ�
	$_SGLOBAL['db']->query("DELETE FROM ".tname('report')." WHERE id IN (".simplode($newjobids).") AND idtype='jobid'");

	//ɾ��feed
	$_SGLOBAL['db']->query("DELETE FROM ".tname('feed')." WHERE id IN (".simplode($newjobids).") AND idtype='jobid'");
	
	//ɾ����ӡ
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

	//��ȡ����
	$reward = getreward('delcases', 0);
	//��ȡ������Ϣ
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
			//�۳�����
			$_SGLOBAL['db']->query("UPDATE ".tname('space')." SET credit=credit-$reward[credit], experience=experience-$reward[experience] WHERE uid='$value[uid]'");
		}
}
	//����ɾ��
	$_SGLOBAL['db']->query("DELETE FROM ".tname('cases')." WHERE casesid IN (".simplode($newcasesids).")");
	$_SGLOBAL['db']->query("DELETE FROM ".tname('casesfield')." WHERE casesid IN (".simplode($newcasesids).")");

	//����
	$_SGLOBAL['db']->query("DELETE FROM ".tname('comment')." WHERE id IN (".simplode($newcasesids).") AND idtype='casesid'");

	//ɾ���ٱ�
	$_SGLOBAL['db']->query("DELETE FROM ".tname('report')." WHERE id IN (".simplode($newcasesids).") AND idtype='casesid'");

	//ɾ��feed
	$_SGLOBAL['db']->query("DELETE FROM ".tname('feed')." WHERE id IN (".simplode($newcasesids).") AND idtype='casesid'");
	
	//ɾ����ӡ
	$_SGLOBAL['db']->query("DELETE FROM ".tname('clickuser')." WHERE id IN (".simplode($newcasesids).") AND idtype='casesid'");

	return $casess;
}

function deletegoods($goodsids) {
	global $_SGLOBAL;

	//��ȡ����
	$reward = getreward('delgoods', 0);
	//��ȡ������Ϣ
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
			//�۳�����
			$_SGLOBAL['db']->query("UPDATE ".tname('space')." SET credit=credit-$reward[credit], experience=experience-$reward[experience] WHERE uid='$value[uid]'");
		}
}
	//����ɾ��
	$_SGLOBAL['db']->query("DELETE FROM ".tname('goods')." WHERE goodsid IN (".simplode($newgoodsids).")");
	$_SGLOBAL['db']->query("DELETE FROM ".tname('goodsfield')." WHERE goodsid IN (".simplode($newgoodsids).")");

	//����
	$_SGLOBAL['db']->query("DELETE FROM ".tname('comment')." WHERE id IN (".simplode($newgoodsids).") AND idtype='goodsid'");

	//ɾ���ٱ�
	$_SGLOBAL['db']->query("DELETE FROM ".tname('report')." WHERE id IN (".simplode($newgoodsids).") AND idtype='goodsid'");

	//ɾ��feed
	$_SGLOBAL['db']->query("DELETE FROM ".tname('feed')." WHERE id IN (".simplode($newgoodsids).") AND idtype='goodsid'");
	
	//ɾ����ӡ
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

	//��ȡ����
	$reward = getreward('delauction', 0);
	//��ȡ������Ϣ
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
			//�۳�����
			$_SGLOBAL['db']->query("UPDATE ".tname('space')." SET credit=credit-$reward[credit], experience=experience-$reward[experience] WHERE uid='$value[uid]'");
		}
}
	//����ɾ��
	$_SGLOBAL['db']->query("DELETE FROM ".tname('auction')." WHERE auctionid IN (".simplode($newauctionids).")");
	$_SGLOBAL['db']->query("DELETE FROM ".tname('auctionfield')." WHERE auctionid IN (".simplode($newauctionids).")");

	//����
	$_SGLOBAL['db']->query("DELETE FROM ".tname('comment')." WHERE id IN (".simplode($newauctionids).") AND idtype='auctionid'");

	//ɾ���ٱ�
	$_SGLOBAL['db']->query("DELETE FROM ".tname('report')." WHERE id IN (".simplode($newauctionids).") AND idtype='auctionid'");

	//ɾ��feed
	$_SGLOBAL['db']->query("DELETE FROM ".tname('feed')." WHERE id IN (".simplode($newauctionids).") AND idtype='auctionid'");
	
	//ɾ����ӡ
	$_SGLOBAL['db']->query("DELETE FROM ".tname('clickuser')." WHERE id IN (".simplode($newauctionids).") AND idtype='auctionid'");

	return $auctions;
}

function deleterecommends($recommendids) {
	global $_SGLOBAL;

	//��ȡ����
	$reward = getreward('delrecommend', 0);
	//��ȡ������Ϣ
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
			//�۳�����
			$_SGLOBAL['db']->query("UPDATE ".tname('space')." SET credit=credit-$reward[credit], experience=experience-$reward[experience] WHERE uid='$value[uid]'");
		}
}
	//����ɾ��
	$_SGLOBAL['db']->query("DELETE FROM ".tname('recommend')." WHERE recommendid IN (".simplode($newrecommendids).")");
	$_SGLOBAL['db']->query("DELETE FROM ".tname('recommendfield')." WHERE recommendid IN (".simplode($newrecommendids).")");

	//����
	$_SGLOBAL['db']->query("DELETE FROM ".tname('comment')." WHERE id IN (".simplode($newrecommendids).") AND idtype='recommendid'");

	//ɾ���ٱ�
	$_SGLOBAL['db']->query("DELETE FROM ".tname('report')." WHERE id IN (".simplode($newrecommendids).") AND idtype='recommendid'");

	//ɾ��feed
	$_SGLOBAL['db']->query("DELETE FROM ".tname('feed')." WHERE id IN (".simplode($newrecommendids).") AND idtype='recommendid'");
	
	//ɾ����ӡ
	$_SGLOBAL['db']->query("DELETE FROM ".tname('clickuser')." WHERE id IN (".simplode($newrecommendids).") AND idtype='recommendid'");

	return $recommends;
}

function deletemoblies($moblieids) {
	global $_SGLOBAL;

	//��ȡ����
	$reward = getreward('delmoblie', 0);
	//��ȡ������Ϣ
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
			//�۳�����
			$_SGLOBAL['db']->query("UPDATE ".tname('space')." SET credit=credit-$reward[credit], experience=experience-$reward[experience] WHERE uid='$value[uid]'");
		}
}
	//����ɾ��
	$_SGLOBAL['db']->query("DELETE FROM ".tname('moblie')." WHERE moblieid IN (".simplode($newmoblieids).")");
	$_SGLOBAL['db']->query("DELETE FROM ".tname('mobliefield')." WHERE moblieid IN (".simplode($newmoblieids).")");

	//����
	$_SGLOBAL['db']->query("DELETE FROM ".tname('comment')." WHERE id IN (".simplode($newmoblieids).") AND idtype='moblieid'");

	//ɾ���ٱ�
	$_SGLOBAL['db']->query("DELETE FROM ".tname('report')." WHERE id IN (".simplode($newmoblieids).") AND idtype='moblieid'");

	//ɾ��feed
	$_SGLOBAL['db']->query("DELETE FROM ".tname('feed')." WHERE id IN (".simplode($newmoblieids).") AND idtype='moblieid'");
	
	//ɾ����ӡ
	$_SGLOBAL['db']->query("DELETE FROM ".tname('clickuser')." WHERE id IN (".simplode($newmoblieids).") AND idtype='moblieid'");

	return $moblies;
}

//ɾ���¼�
function deletefeeds($feedids) {
	global $_SGLOBAL;

	$allowmanage = checkperm('managefeed');
	$managebatch = checkperm('managebatch');
	
	$delnum = 0;
	$feeds = $newfeedids = array();
	$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('feed')." WHERE feedid IN (".simplode($feedids).")");
	while ($value = $_SGLOBAL['db']->fetch_array($query)) {
		if($allowmanage || $value['uid'] == $_SGLOBAL['supe_uid']) {//����Ա/����
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


//ɾ������
function deleteshares($sids) {
	global $_SGLOBAL;

	$allowmanage = checkperm('manageshare');
	$managebatch = checkperm('managebatch');
	$delnum = 0;
	//��ȡ����
	$reward = getreward('delshare', 0);
	$spaces = $shares = $newsids = array();
	$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('share')." WHERE sid IN (".simplode($sids).")");
	while ($value = $_SGLOBAL['db']->fetch_array($query)) {
		if($allowmanage || $value['uid'] == $_SGLOBAL['supe_uid']) {//����Ա/����
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
			//�۳�����
			$_SGLOBAL['db']->query("UPDATE ".tname('space')." SET credit=credit-$reward[credit], experience=experience-$reward[experience] WHERE uid='$value[uid]'");
		}
	}

	$_SGLOBAL['db']->query("DELETE FROM ".tname('share')." WHERE sid IN (".simplode($newsids).")");

	//����
	$_SGLOBAL['db']->query("DELETE FROM ".tname('comment')." WHERE id IN (".simplode($newsids).") AND idtype='sid'");
	
	//ɾ��feed
	$_SGLOBAL['db']->query("DELETE FROM ".tname('feed')." WHERE id IN (".simplode($newsids).") AND idtype='sid'");

	//ɾ���ٱ�
	$_SGLOBAL['db']->query("DELETE FROM ".tname('report')." WHERE id IN (".simplode($newsids).") AND idtype='sid'");
	
	return $shares;
}


//ɾ����¼
function deletedoings($ids) {
	global $_SGLOBAL;

	$allowmanage = checkperm('managedoing');
	$managebatch = checkperm('managebatch');
	$delnum = 0;
	//��ȡ����
	$reward = getreward('deldoing', 0);
	$spaces = $doings = $newdoids = array();
	$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('doing')." WHERE doid IN (".simplode($ids).")");
	while ($value = $_SGLOBAL['db']->fetch_array($query)) {
		if($allowmanage || $value['uid'] == $_SGLOBAL['supe_uid']) {//����Ա/����
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
			//�۳�����
			$_SGLOBAL['db']->query("UPDATE ".tname('space')." SET credit=credit-$reward[credit], experience=experience-$reward[experience] WHERE uid='$value[uid]'");
		}
	}
	$_SGLOBAL['db']->query("DELETE FROM ".tname('doing')." WHERE doid IN (".simplode($newdoids).")");
	//ɾ������
	$_SGLOBAL['db']->query("DELETE FROM ".tname('docomment')." WHERE doid IN (".simplode($newdoids).")");
	
	//ɾ��feed
	$_SGLOBAL['db']->query("DELETE FROM ".tname('feed')." WHERE id IN (".simplode($newdoids).") AND idtype='doid'");

	return $doings;
}

//ɾ����¼
function deletetalks($talkids) {
	global $_SGLOBAL;

	//��ȡ����
	$reward = getreward('deltalk', 0);
	//��ȡ������Ϣ
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
			//�۳�����
			$_SGLOBAL['db']->query("UPDATE ".tname('space')." SET credit=credit-$reward[credit], experience=experience-$reward[experience] WHERE uid='$value[uid]'");
		}
}
	//����ɾ��
	$_SGLOBAL['db']->query("DELETE FROM ".tname('talk')." WHERE talkid IN (".simplode($newtalkids).")");
	$_SGLOBAL['db']->query("DELETE FROM ".tname('talkfield')." WHERE talkid IN (".simplode($newtalkids).")");

	//����
	$_SGLOBAL['db']->query("DELETE FROM ".tname('comment')." WHERE id IN (".simplode($newtalkids).") AND idtype='talkid'");

	//ɾ���ٱ�
	$_SGLOBAL['db']->query("DELETE FROM ".tname('report')." WHERE id IN (".simplode($newtalkids).") AND idtype='talkid'");

	//ɾ��feed
	$_SGLOBAL['db']->query("DELETE FROM ".tname('feed')." WHERE id IN (".simplode($newtalkids).") AND idtype='talkid'");
	
	//ɾ����ӡ
	$_SGLOBAL['db']->query("DELETE FROM ".tname('clickuser')." WHERE id IN (".simplode($newtalkids).") AND idtype='talkid'");

	return $talks;
}

//ɾ����¼
function deletemenusets($menusetids) {
	global $_SGLOBAL;

	//��ȡ����
	$reward = getreward('delmenuset', 0);
	//��ȡ������Ϣ
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
			//�۳�����
			$_SGLOBAL['db']->query("UPDATE ".tname('space')." SET credit=credit-$reward[credit], experience=experience-$reward[experience] WHERE uid='$value[uid]'");
		}
}
	//����ɾ��
	$_SGLOBAL['db']->query("DELETE FROM ".tname('menuset')." WHERE menusetid IN (".simplode($newmenusetids).")");
	$_SGLOBAL['db']->query("DELETE FROM ".tname('menusetfield')." WHERE menusetid IN (".simplode($newmenusetids).")");
	$_SGLOBAL['db']->query("DELETE FROM ".tname('appset')." WHERE num IN (".simplode($newmenusetids).") and uid = $_SGLOBAL[supe_uid]");

	//����
	$_SGLOBAL['db']->query("DELETE FROM ".tname('comment')." WHERE id IN (".simplode($newmenusetids).") AND idtype='menusetid'");

	//ɾ���ٱ�
	$_SGLOBAL['db']->query("DELETE FROM ".tname('report')." WHERE id IN (".simplode($newmenusetids).") AND idtype='menusetid'");

	//ɾ��feed
	$_SGLOBAL['db']->query("DELETE FROM ".tname('feed')." WHERE id IN (".simplode($newmenusetids).") AND idtype='menusetid'");
	
	//ɾ����ӡ
	$_SGLOBAL['db']->query("DELETE FROM ".tname('clickuser')." WHERE id IN (".simplode($newmenusetids).") AND idtype='menusetid'");

	return $menusets;
}

//ɾ������
function deletethreads($tagid, $tids) {
	global $_SGLOBAL;

	$tnums = $pnums = $delthreads = $newids = $spaces = array();
	$ismanager = $allowmanage = checkperm('managethread');

	$managebatch = checkperm('managebatch');
	$delnum = 0;

	//Ⱥ��
	$wheresql = '';
	if(empty($allowmanage) && $tagid) {
		$mtag = getmtag($tagid);
		if($mtag['grade'] >=8) {
			$allowmanage = 1;
			$managebatch = 1;
			$wheresql = " AND t.tagid='$tagid'";
		}
	}
	//��ȡ����
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
			//�۳�����
			$_SGLOBAL['db']->query("UPDATE ".tname('space')." SET credit=credit-$reward[credit], experience=experience-$reward[experience] WHERE uid='$value[uid]'");
		}
	}
	
	//ɾ��
	$_SGLOBAL['db']->query("DELETE FROM ".tname('thread')." WHERE tid IN(".simplode($newids).")");
	$_SGLOBAL['db']->query("DELETE FROM ".tname('post')." WHERE tid IN(".simplode($newids).")");

	//ɾ��feed
	$_SGLOBAL['db']->query("DELETE FROM ".tname('feed')." WHERE id IN (".simplode($newids).") AND idtype='tid'");
	
	//ɾ���ٱ�
	$_SGLOBAL['db']->query("DELETE FROM ".tname('report')." WHERE id IN (".simplode($newids).") AND idtype='tid'");
	
	//ɾ����ӡ
	$_SGLOBAL['db']->query("DELETE FROM ".tname('clickuser')." WHERE id IN (".simplode($newids).") AND idtype='tid'");

	return $delthreads;
}

//ɾ������
function deleteposts($tagid, $pollids) {
	global $_SGLOBAL;

	//ͳ��
	$postnums = $mpostnums = $tids = $delposts = $newids = $spaces = array();
	$ismanager = $allowmanage = checkperm('managethread');
	$managebatch = checkperm('managebatch');
	$delnum = 0;

	//Ⱥ��
	$wheresql = '';
	if(empty($allowmanage) && $tagid) {
		$mtag = getmtag($tagid);
		if($mtag['grade'] >=8) {
			$allowmanage = 1;
			$managebatch = 1;
			$wheresql = " AND p.tagid='$tagid'";
		}
	}
	//��ȡ����
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
					//�۳�����
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

	//����
	$nums = renum($postnums);
	foreach ($nums[0] as $pnum) {
		$_SGLOBAL['db']->query("UPDATE ".tname('thread')." SET replynum=replynum-$pnum WHERE tid IN (".simplode($nums[1][$pnum]).")");
	}

	//ɾ��
	$_SGLOBAL['db']->query("DELETE FROM ".tname('post')." WHERE pollid IN (".simplode($newids).")");

	return $delposts;
}

//ɾ���ռ�
function deletespace($uid, $force=0) {
	global $_SGLOBAL, $_SC, $_SCONFIG;

	$delspace = array();
	$allowmanage = checkperm('managedelspace');
	$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('space')." WHERE uid='$uid'");
	if($value = $_SGLOBAL['db']->fetch_array($query)) {
		if($force || $allowmanage && $value['uid'] != $_SGLOBAL['supe_uid']) {
			$delspace = $value;
			//�������ǿ��ɾ������ɾ����¼��
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
	
	//�ĸ�Ȩ������
	$_SGLOBAL['usergroup'][$_SGLOBAL['member']['groupollid']]['managebatch'] = 1;

	//space
	$_SGLOBAL['db']->query("DELETE FROM ".tname('space')." WHERE uid='$uid'");
	//spacefield
	$_SGLOBAL['db']->query("DELETE FROM ".tname('spacefield')." WHERE uid='$uid'");

	//feed
	$_SGLOBAL['db']->query("DELETE FROM ".tname('feed')." WHERE uid='$uid' OR (id='$uid' AND idtype='uid')");

	//��¼
	$doids =array();
	$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('doing')." WHERE uid='$uid'");
	while ($value = $_SGLOBAL['db']->fetch_array($query)) {
		$doids[$value['doid']] = $value['doid'];
	}
	
	$_SGLOBAL['db']->query("DELETE FROM ".tname('doing')." WHERE uid='$uid'");

	//ɾ����¼�ظ�
	$_SGLOBAL['db']->query("DELETE FROM ".tname('docomment')." WHERE doid IN (".simplode($doids).") OR uid='$uid'");

	//����
	$_SGLOBAL['db']->query("DELETE FROM ".tname('share')." WHERE uid='$uid'");

	//����
	$_SGLOBAL['db']->query("DELETE FROM ".tname('album')." WHERE uid='$uid'");
	
	//ɾ�����ּ�¼
	$_SGLOBAL['db']->query("DELETE FROM ".tname('creditlog')." WHERE uid='$uid'");

	//ɾ��֪ͨ
	$_SGLOBAL['db']->query("DELETE FROM ".tname('notification')." WHERE (uid='$uid' OR authorid='$uid')");

	//ɾ�����к�
	$_SGLOBAL['db']->query("DELETE FROM ".tname('poke')." WHERE (uid='$uid' OR fromuid='$uid')");
	
	//ɾ�����ֽ���ͶƱ
	$pollid = array();
	$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('poll')." WHERE uid='$uid'");
	while ($value = $_SGLOBAL['db']->fetch_array($query)) {
		$pollid[$value['pollid']] = $value['pollid'];
	}
	deletepolls($pollid);
	//ɾ���������ͶƱ
	$pollid = array();
	$query = $_SGLOBAL['db']->query("SELECT pollid FROM ".tname('polluser')." WHERE uid='$uid'");
	while ($value = $_SGLOBAL['db']->fetch_array($query)) {
		$pollid[$value['pollid']] = $value['pollid'];
	}
	//�۳�ͶƱ��
	if($pollid) {
		$_SGLOBAL['db']->query("UPDATE ".tname('poll')." SET voternum=voternum-1 WHERE pollid IN (".simplode($pollid).")");
	}
	$_SGLOBAL['db']->query("DELETE FROM ".tname('polluser')." WHERE uid='$uid'");
	
	//�
	$ids = array();
	$query = $_SGLOBAL['db']->query('SELECT eventid FROM '.tname('event')." WHERE uid = '$uid'");
	while($value = $_SGLOBAL['db']->fetch_array($query)) {
		$ids[] = $value['eventid'];
	}
	deleteevents($ids);
	//ɾ�����μӵĻ
	$ids = $ids1 = $ids2 = array();
	$query = $_SGLOBAL['db']->query('SELECT * FROM '.tname('userevent')." WHERE uid = '$uid'");
	while($value = $_SGLOBAL['db']->fetch_array($query)) {
		if($value['status'] == 1) {
			$ids1[] = $value['eventid'];//��ע
		} elseif($value['status'] > 1) {
			$ids2[] = $value['eventid'];//�μ�
		}
		$ids[] = $value['eventid'];
	}
	if($ids1) {
		$_SGLOBAL['db']->query('UPDATE '.tname('event').' SET follownum = follownum - 1 WHERE eventid IN ('.simplode($ids1).')');
	}
	if($ids2) {
		$_SGLOBAL['db']->query('UPDATE '.tname('event').' SET membernum = membernum - 1 WHERE eventid IN ('.simplode($ids2).')');// to to: ��û�Ҫ��鲢��ȥ��Я��������
	}
	if($ids) {
		$_SGLOBAL['db']->query('DELETE FROM '.tname('userevent').' WHERE eventid IN ('.simplode($ids).") AND uid = '$uid'");
	}
	//ɾ����ػ����
	$_SGLOBAL['db']->query('DELETE FROM '.tname('eventinvite')." WHERE uid = '$uid' OR touid = '$uid'");
	//ɾ���ϴ��ĻͼƬ
	$_SGLOBAL['db']->query('DELETE FROM '.tname('eventpic')." WHERE picid = '$uid'");//to do: ���ͬʱ���»ͼƬ���ͻ������
	
	//����
	$_SGLOBAL['db']->query('DELETE FROM '.tname('usermagic')." WHERE uid = '$uid'");
	$_SGLOBAL['db']->query('DELETE FROM '.tname('magicinlog')." WHERE uid = '$uid'");
	$_SGLOBAL['db']->query('DELETE FROM '.tname('magicuselog')." WHERE uid = '$uid'");
	
	//pic
	//ɾ��ͼƬ����
	$pics = array();
	$query = $_SGLOBAL['db']->query("SELECT filepath FROM ".tname('pic')." WHERE uid='$uid'");
	while ($value = $_SGLOBAL['db']->fetch_array($query)) {
		$pics[] = $value;
	}
	//����
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
	//����ɾ��
	$_SGLOBAL['db']->query("DELETE FROM ".tname('blog')." WHERE uid='$uid'");
	$_SGLOBAL['db']->query("DELETE FROM ".tname('blogfield')." WHERE uid='$uid'");

	//����
	$_SGLOBAL['db']->query("DELETE FROM ".tname('comment')." WHERE (uid='$uid' OR authorid='$uid' OR (id='$uid' AND idtype='uid'))");

	//�ÿ�
	$_SGLOBAL['db']->query("DELETE FROM ".tname('visitor')." WHERE (uid='$uid' OR vuid='$uid')");

	//ɾ�������¼
	$_SGLOBAL['db']->query("DELETE FROM ".tname('usertask')." WHERE uid='$uid'");

	//class
	$_SGLOBAL['db']->query("DELETE FROM ".tname('class')." WHERE uid='$uid'");

	//friend
	//����
	$_SGLOBAL['db']->query("DELETE FROM ".tname('friend')." WHERE (uid='$uid' OR fuid='$uid')");

	//member
	$_SGLOBAL['db']->query("DELETE FROM ".tname('member')." WHERE uid='$uid'");

	//ɾ����ӡ
	$_SGLOBAL['db']->query("DELETE FROM ".tname('clickuser')." WHERE uid='$uid'");

	//ɾ��������
	$_SGLOBAL['db']->query("DELETE FROM ".tname('blacklist')." WHERE (uid='$uid' OR buid='$uid')");

	//ɾ�������¼
	$_SGLOBAL['db']->query("DELETE FROM ".tname('invite')." WHERE (uid='$uid' OR fuid='$uid')");

	//ɾ���ʼ�����
	$_SGLOBAL['db']->query("DELETE FROM ".tname('mailcron').", ".tname('mailqueue')." USING ".tname('mailcron').", ".tname('mailqueue')." WHERE ".tname('mailcron').".touid='$uid' AND ".tname('mailcron').".cid=".tname('mailqueue').".cid");

	//��������
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

	//���а�
	$_SGLOBAL['db']->query("DELETE FROM ".tname('show')." WHERE uid='$uid'");

	//Ⱥ��
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

	//ɾ��ͼƬ
	deletepicfiles($pics);//ɾ��ͼƬ
	
	//ɾ���ٱ�
	$_SGLOBAL['db']->query("DELETE FROM ".tname('report')." WHERE id='$uid' AND idtype='uid'");
	
	
	//�����¼
	if($_SCONFIG['my_status']) inserttable('userlog', array('uid'=>$uid, 'action'=>'delete', 'dateline'=>$_SGLOBAL['timestamp']), 0, true);

	return $delspace;
}

//ɾ��ͼƬ
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
			//ɾ���ļ�
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

	//��ȡ����
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

		//ɾ���ٱ�
		$_SGLOBAL['db']->query("DELETE FROM ".tname('report')." WHERE id IN (".simplode($newids).") AND idtype='picid'");
			
		//ɾ����ӡ
		$_SGLOBAL['db']->query("DELETE FROM ".tname('clickuser')." WHERE id IN (".simplode($newids).") AND idtype='picid'");
	}
	if($albumnums) {
		include_once(S_ROOT.'./source/function_cp.php');
		foreach ($albumnums as $id => $num) {
			$thepic = getalbumpic($auids[$id], $id);
			$_SGLOBAL['db']->query("UPDATE ".tname('album')." SET pic='$thepic', picnum=picnum-$num WHERE albumid='$id'");
		}
	}

	//ɾ��ͼƬ
	deletepicfiles($pics);

	return $delpics;
}

//ɾ��ͼƬ�ļ�
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
	//ɾ��Զ�̸���
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

//ɾ�����
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
	//��ȡ����
	$reward = getreward('delimage', 0);
	$pics = array();
	$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('pic')." WHERE albumid IN (".simplode($newids).")");
	while ($value = $_SGLOBAL['db']->fetch_array($query)) {
		$sizes[$value['uid']] = $sizes[$value['uid']] + $value['size'];
		$pics[] = $value;
		$setsql = '';
		if($allowmanage && $value['uid'] != $_SGLOBAL['supe_uid']) {
			//�۳�����
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
	
	//ɾ���ٱ�
	$_SGLOBAL['db']->query("DELETE FROM ".tname('report')." WHERE id IN (".simplode($newids).") AND idtype='albumid'");

	//ɾ��ͼƬ
	if($pics) {
		deletepicfiles($pics);//ɾ��ͼƬ
	}

	return $dels;
}

//ɾ��tag
function deletetags($tagids) {
	global $_SGLOBAL;
	
	if(!checkperm('managetag')) return false;

	//����
	$_SGLOBAL['db']->query("DELETE FROM ".tname('tagblog')." WHERE tagid IN (".simplode($tagids).")");
	$_SGLOBAL['db']->query("DELETE FROM ".tname('tag')." WHERE tagid IN (".simplode($tagids).")");

	return true;
}

//ɾ��mtag
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

	//����
	$_SGLOBAL['db']->query("DELETE FROM ".tname('tagspace')." WHERE tagid IN (".simplode($newids).")");
	$_SGLOBAL['db']->query("DELETE FROM ".tname('mtag')." WHERE tagid IN (".simplode($newids).")");
	$_SGLOBAL['db']->query("DELETE FROM ".tname('thread')." WHERE tagid IN (".simplode($newids).")");
	$_SGLOBAL['db']->query("DELETE FROM ".tname('post')." WHERE tagid IN (".simplode($newids).")");
	$_SGLOBAL['db']->query("DELETE FROM ".tname('mtaginvite')." WHERE tagid IN (".simplode($newids).")");

	//ɾ���ٱ�
	$_SGLOBAL['db']->query("DELETE FROM ".tname('report')." WHERE id IN (".simplode($newids).") AND idtype='tagid'");
	return $dels;
}

//ɾ���û���Ŀ
function deleteprofilefield($fieldids) {
	global $_SGLOBAL;

	if(!checkperm('manageprofilefield')) return false;

	//ɾ������
	$_SGLOBAL['db']->query("DELETE FROM ".tname('profilefield')." WHERE fieldid IN (".simplode($fieldids).")");
	//���ı�ṹ
	foreach ($fieldids as $id) {
		$_SGLOBAL['db']->query("ALTER TABLE ".tname('spacefield')." DROP `field_$id`", 'SILENT');
	}

	return true;
}

//ɾ����Ŀ
function deleteprofield($fieldids, $newfieldid) {
	global $_SGLOBAL;

	if(!checkperm('manageprofield')) return false;

	//ɾ������
	$_SGLOBAL['db']->query("DELETE FROM ".tname('profield')." WHERE fieldid IN (".simplode($fieldids).")");

	//������Ŀ
	$_SGLOBAL['db']->query("UPDATE ".tname('mtag')." SET fieldid='$newfieldid' WHERE fieldid IN (".simplode($fieldids).")");

	return true;
}

//���ɾ��
function deleteads($adids) {
	global $_SGLOBAL;

	if(!checkperm('managead')) return false;

	$dels = $newids = array();
	$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('ad')." WHERE adid IN (".simplode($adids).")");
	while ($value = $_SGLOBAL['db']->fetch_array($query)) {
		//ɾ��ģ����ģ������ļ�
		$tpl = S_ROOT."./data/adtpl/$value[adid].htm";//ԭʼ
		swritefile($tpl, ' ');

		$newids[] = $value['adid'];
		$dels[] = $value;
	}
	if(empty($dels)) return array();

	//����
	$_SGLOBAL['db']->query("DELETE FROM ".tname('ad')." WHERE adid IN (".simplode($newids).")");

	return $dels;
}

//ģ��ɾ��
function deleteblocks($bids) {
	global $_SGLOBAL;

	if(!checkperm('managead')) return false;

	$dels = $newids = array();
	$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('block')." WHERE bid IN (".simplode($bids).")");
	while ($value = $_SGLOBAL['db']->fetch_array($query)) {
		//ɾ��ģ����ģ������ļ�
		$tpl = S_ROOT."./data/blocktpl/$value[bid].htm";//ԭʼ
		swritefile($tpl, ' ');

		$newids[] = $value['bid'];
		$dels[] = $value;
	}
	if(empty($dels)) return array();

	//����
	$_SGLOBAL['db']->query("DELETE FROM ".tname('block')." WHERE bid IN (".simplode($newids).")");

	return $dels;
}

//ɾ������
function deletetopics($ids) {
	global $_SGLOBAL;
	
	//����
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

//ɾ��ͶƱ
function deletepolls($pollids) {
	global $_SGLOBAL;
	//��ȡͶƱ��Ϣ
	$sparecredit = $spaces = $polls = $newpollids = array();
	//��ȡ����
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
			//�۳�����
			$_SGLOBAL['db']->query("UPDATE ".tname('space')." SET credit=credit-$reward[credit], experience=experience-$reward[experience] WHERE uid='$value[uid]'");
		}
		//�黹δ������Ļ���
		if($value['credit'] > 0) {
			$sparecredit = intval($value['credit']);
			$_SGLOBAL['db']->query("UPDATE ".tname('space')." SET credit=credit+$sparecredit WHERE uid='$value[uid]'");
		}
	}

	//����ɾ��
	$_SGLOBAL['db']->query("DELETE FROM ".tname('poll')." WHERE pollid IN (".simplode($newpollids).")");
	$_SGLOBAL['db']->query("DELETE FROM ".tname('pollfield')." WHERE pollid IN (".simplode($newpollids).")");
	$_SGLOBAL['db']->query("DELETE FROM ".tname('polloption')." WHERE pollid IN (".simplode($newpollids).")");
	$_SGLOBAL['db']->query("DELETE FROM ".tname('polluser')." WHERE pollid IN (".simplode($newpollids).")");
	//����
	$_SGLOBAL['db']->query("DELETE FROM ".tname('comment')." WHERE id IN (".simplode($newpollids).") AND idtype='pollid'");
	
	$_SGLOBAL['db']->query("DELETE FROM ".tname('feed')." WHERE id IN (".simplode($newpollids).") AND idtype='pollid'");
	
	//ɾ���ٱ�
	$_SGLOBAL['db']->query("DELETE FROM ".tname('report')." WHERE id IN (".simplode($newpollids).") AND idtype='pollid'");
	
	return $polls;
	
}

// ɾ���
function deleteevents($eventids){
    global $_SGLOBAL;
    
	$allowmanage = checkperm('manageevent');
	$managebatch = checkperm('managebatch');
	$delnum = 0;
	$eventarr = $neweventids = $note_ids = $note_inserts = array();
    //��ȡ����
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
		// [to do: ����μ��߷�֪ͨ��������̫���������ȼ�����]
		if($value['uid'] != $_SGLOBAL['supe_uid']) {
			if($allowmanage) {
	        	//�۳�����
	        	$_SGLOBAL['db']->query("UPDATE ".tname('space')." SET credit=credit-$reward[credit], experience=experience-$reward[experience] WHERE uid='$value[uid]'");
	        }
	        $note_ids[] = $value['uid'];
			$note_msg = cplang('event_set_delete', array($value['title']));
			$note_inserts[] = "('$value[uid]', 'event', '1', '$_SGLOBAL[supe_uid]', '$_SGLOBAL[supe_username]', '".addslashes($note_msg)."', '$_SGLOBAL[timestamp]')";
		}
	}

    //����ɾ��
	$_SGLOBAL['db']->query("DELETE FROM ".tname('event')." WHERE eventid IN (".simplode($neweventids).")");
	$_SGLOBAL['db']->query("DELETE FROM ".tname('eventpic')." WHERE eventid IN (".simplode($neweventids).")");
	$_SGLOBAL['db']->query("DELETE FROM ".tname('eventinvite')." WHERE eventid IN (".simplode($neweventids).")");

	//��û�
	$_SGLOBAL['db']->query("DELETE FROM ".tname('userevent')." WHERE eventid IN (".simplode($neweventids).")");

	//����
	$_SGLOBAL['db']->query("DELETE FROM ".tname('comment')." WHERE id IN (".simplode($neweventids).") AND idtype='eventid'");

	$_SGLOBAL['db']->query("DELETE FROM ".tname('feed')." WHERE id IN (".simplode($neweventids).") AND idtype='eventid'");
	
	//ɾ���ٱ�
	$_SGLOBAL['db']->query("DELETE FROM ".tname('report')." WHERE id IN (".simplode($neweventids).") AND idtype='eventid'");

	//����֪ͨ
	if($note_inserts){
		$_SGLOBAL['db']->query("INSERT INTO ".tname('notification')." (`uid`, `type`, `new`, `authorid`, `author`, `note`, `dateline`) VALUES ".implode(',', $note_inserts));
		$_SGLOBAL['db']->query("UPDATE ".tname('space')." SET notenum=notenum+1 WHERE uid IN (".simplode($note_ids).")");
	}
	return $eventarr;
}

?>