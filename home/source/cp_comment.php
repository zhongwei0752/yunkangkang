<?php
/*
	[UCenter Home] (C) 2007-2008 Comsenz Inc.
	$Id: cp_comment.php 13000 2009-08-05 05:58:30Z liguode $
*/

if(!defined('IN_UCHOME')) {
	exit('Access Denied');
}

include_once(S_ROOT.'./source/function_bbcode.php');

//¹²ÓÃ±äÁ¿
$tospace = $pic = $blog = $album = $share = $event = $poll=$product=$introduce=$goods=$development=$industry=$cases=$branch=$job= array();

if(submitcheck('commentsubmit')) {

	$idtype = $_POST['idtype'];
	
	if(!checkperm('allowcomment')) {
		ckspacelog();
		showmessage('no_privilege');
	}

	//ÊµÃûÈÏÖ¤
	ckrealname('comment');

	//ÐÂÓÃ»§¼ûÏ°
	cknewuser();

	//ÅÐ¶ÏÊÇ·ñ·¢²¼Ì«¿ì
	$waittime = interval_check('post');
	if($waittime > 0) {
		showmessage('operating_too_fast','',1,array($waittime));
	}

	$message = getstr($_POST['message'], 0, 1, 1, 1, 2);
	if(strlen($message) < 2) {
		showmessage('content_is_too_short');
	}

	//ÕªÒª
	$summay = getstr($message, 150, 1, 1, 0, 0, -1);

	$id = intval($_POST['id']);

	//ÒýÓÃÆÀÂÛ
	$cid = empty($_POST['cid'])?0:intval($_POST['cid']);
	$comment = array();
	if($cid) {
		$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('comment')." WHERE cid='$cid' AND id='$id' AND idtype='$_POST[idtype]'");
		$comment = $_SGLOBAL['db']->fetch_array($query);
		if($comment && $comment['authorid'] != $_SGLOBAL['supe_uid']) {
			//ÊµÃû
			if($comment['author'] == '') {
				$_SN[$comment['authorid']] = lang('hidden_username');
			} else {
				realname_set($comment['authorid'], $comment['author']);
				realname_get();
			}
			$comment['message'] = preg_replace("/\<div class=\"quote\"\>\<span class=\"q\"\>.*?\<\/span\>\<\/div\>/is", '', $comment['message']);
			//bbcode×ª»»
			$comment['message'] = html2bbcode($comment['message']);
			$message = addslashes("<div class=\"quote\"><span class=\"q\"><b>".$_SN[$comment['authorid']]."</b>: ".getstr($comment['message'], 150, 0, 0, 0, 2, 1).'</span></div>').$message;
			if($comment['idtype']=='uid') {
				$id = $comment['authorid'];
			}
		} else {
			$comment = array();
		}
	}

	$hotarr = array();
	$stattype = '';

	//¼ì²éÈ¨ÏÞ
	switch ($idtype) {
		case 'uid':
			//¼ìË÷¿Õ¼ä
			$tospace = getspace($id);
			$stattype = 'wall';//Í³¼Æ
			break;
		case 'picid':
			//¼ìË÷Í¼Æ¬
			$query = $_SGLOBAL['db']->query("SELECT p.*, pf.hotuser
				FROM ".tname('pic')." p
				LEFT JOIN ".tname('picfield')." pf
				ON pf.picid=p.picid
				WHERE p.picid='$id'");
			$pic = $_SGLOBAL['db']->fetch_array($query);
			//Í¼Æ¬²»´æÔÚ
			if(empty($pic)) {
				showmessage('view_images_do_not_exist');
			}

			//¼ìË÷¿Õ¼ä
			$tospace = getspace($pic['uid']);

			//»ñÈ¡Ïà²á
			$album = array();
			if($pic['albumid']) {
				$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('album')." WHERE albumid='$pic[albumid]'");
				if(!$album = $_SGLOBAL['db']->fetch_array($query)) {
					updatetable('pic', array('albumid'=>0), array('albumid'=>$pic['albumid']));//Ïà²á¶ªÊ§
				}
			}
			//ÑéÖ¤ÒþË½
			if(!ckfriend($album['uid'], $album['friend'], $album['target_ids'])) {
				showmessage('no_privilege');
			} elseif(!$tospace['self'] && $album['friend'] == 4) {
				//ÃÜÂëÊäÈëÎÊÌâ
				$cookiename = "view_pwd_album_$album[albumid]";
				$cookievalue = empty($_SCOOKIE[$cookiename])?'':$_SCOOKIE[$cookiename];
				if($cookievalue != md5(md5($album['password']))) {
					showmessage('no_privilege');
				}
			}
			
			$hotarr = array('picid', $pic['picid'], $pic['hotuser']);
			$stattype = 'piccomment';//Í³¼Æ
			break;
		case 'blogid':
			//¶ÁÈ¡ÈÕÖ¾
			$query = $_SGLOBAL['db']->query("SELECT b.*, bf.target_ids, bf.hotuser
				FROM ".tname('blog')." b
				LEFT JOIN ".tname('blogfield')." bf ON bf.blogid=b.blogid
				WHERE b.blogid='$id'");
			$blog = $_SGLOBAL['db']->fetch_array($query);
			//ÈÕÖ¾²»´æÔÚ
			if(empty($blog)) {
				showmessage('view_to_info_did_not_exist');
			}
			
			//¼ìË÷¿Õ¼ä
			$tospace = getspace($blog['uid']);
			
			//ÑéÖ¤ÒþË½
			if(!ckfriend($blog['uid'], $blog['friend'], $blog['target_ids'])) {
				//Ã»ÓÐÈ¨ÏÞ
				showmessage('no_privilege');
			} elseif(!$tospace['self'] && $blog['friend'] == 4) {
				//ÃÜÂëÊäÈëÎÊÌâ
				$cookiename = "view_pwd_blog_$blog[blogid]";
				$cookievalue = empty($_SCOOKIE[$cookiename])?'':$_SCOOKIE[$cookiename];
				if($cookievalue != md5(md5($blog['password']))) {
					showmessage('no_privilege');
				}
			}

			//ÊÇ·ñÔÊÐíÆÀÂÛ
			if(!empty($blog['noreply'])) {
				showmessage('do_not_accept_comments');
			}
			if($blog['target_ids']) {
				$blog['target_ids'] .= ",$blog[uid]";
			}
			
			$hotarr = array('blogid', $blog['blogid'], $blog['hotuser']);
			$stattype = 'blogcomment';//Í³¼Æ
			break;
		case 'introduceid':
			//¶ÁÈ¡ÈÕÖ¾
			$query = $_SGLOBAL['db']->query("SELECT b.*, bf.target_ids, bf.hotuser
				FROM ".tname('introduce')." b
				LEFT JOIN ".tname('introducefield')." bf ON bf.introduceid=b.introduceid
				WHERE b.introduceid='$id'");
			$introduce = $_SGLOBAL['db']->fetch_array($query);
			//ÈÕÖ¾²»´æÔÚ
			if(empty($introduce)) {
				showmessage('view_to_info_did_not_exist');
			}
			
			//¼ìË÷¿Õ¼ä
			$tospace = getspace($introduce['uid']);
			
			//ÑéÖ¤ÒþË½
			if(!ckfriend($introduce['uid'], $introduce['friend'], $introduce['target_ids'])) {
				//Ã»ÓÐÈ¨ÏÞ
				showmessage('no_privilege');
			} elseif(!$tospace['self'] && $introduce['friend'] == 4) {
				//ÃÜÂëÊäÈëÎÊÌâ
				$cookiename = "view_pwd_introduce_$introduce[introduceid]";
				$cookievalue = empty($_SCOOKIE[$cookiename])?'':$_SCOOKIE[$cookiename];
				if($cookievalue != md5(md5($introduce['password']))) {
					showmessage('no_privilege');
				}
			}

			//ÊÇ·ñÔÊÐíÆÀÂÛ
			if(!empty($introduce['noreply'])) {
				showmessage('do_not_accept_comments');
			}
			if($introduce['target_ids']) {
				$introduce['target_ids'] .= ",$introduce[uid]";
			}
			
			$hotarr = array('introduceid', $introduce['introduceid'], $introduce['hotuser']);
			$stattype = 'introducecomment';//Í³¼Æ
			break;
		case 'productid':
			//¶ÁÈ¡ÈÕÖ¾
			$query = $_SGLOBAL['db']->query("SELECT b.*, bf.target_ids, bf.hotuser
				FROM ".tname('product')." b
				LEFT JOIN ".tname('productfield')." bf ON bf.productid=b.productid
				WHERE b.productid='$id'");
			$product = $_SGLOBAL['db']->fetch_array($query);
			//ÈÕÖ¾²»´æÔÚ
			if(empty($product)) {
				showmessage('view_to_info_did_not_exist');
			}
			
			//¼ìË÷¿Õ¼ä
			$tospace = getspace($product['uid']);
			
			//ÑéÖ¤ÒþË½
			if(!ckfriend($product['uid'], $product['friend'], $product['target_ids'])) {
				//Ã»ÓÐÈ¨ÏÞ
				showmessage('no_privilege');
			} elseif(!$tospace['self'] && $product['friend'] == 4) {
				//ÃÜÂëÊäÈëÎÊÌâ
				$cookiename = "view_pwd_product_$product[productid]";
				$cookievalue = empty($_SCOOKIE[$cookiename])?'':$_SCOOKIE[$cookiename];
				if($cookievalue != md5(md5($product['password']))) {
					showmessage('no_privilege');
				}
			}

			//ÊÇ·ñÔÊÐíÆÀÂÛ
			if(!empty($product['noreply'])) {
				showmessage('do_not_accept_comments');
			}
			if($product['target_ids']) {
				$product['target_ids'] .= ",$product[uid]";
			}
			
			$hotarr = array('productid', $product['productid'], $product['hotuser']);
			$stattype = 'productcomment';//Í³¼Æ
			break;
		case 'developmentid':
			//¶ÁÈ¡ÈÕÖ¾
			$query = $_SGLOBAL['db']->query("SELECT b.*, bf.target_ids, bf.hotuser
				FROM ".tname('development')." b
				LEFT JOIN ".tname('developmentfield')." bf ON bf.developmentid=b.developmentid
				WHERE b.developmentid='$id'");
			$development = $_SGLOBAL['db']->fetch_array($query);
			//ÈÕÖ¾²»´æÔÚ
			if(empty($development)) {
				showmessage('view_to_info_did_not_exist');
			}
			
			//¼ìË÷¿Õ¼ä
			$tospace = getspace($development['uid']);
			
			//ÑéÖ¤ÒþË½
			if(!ckfriend($development['uid'], $development['friend'], $development['target_ids'])) {
				//Ã»ÓÐÈ¨ÏÞ
				showmessage('no_privilege');
			} elseif(!$tospace['self'] && $development['friend'] == 4) {
				//ÃÜÂëÊäÈëÎÊÌâ
				$cookiename = "view_pwd_development_$development[developmentid]";
				$cookievalue = empty($_SCOOKIE[$cookiename])?'':$_SCOOKIE[$cookiename];
				if($cookievalue != md5(md5($development['password']))) {
					showmessage('no_privilege');
				}
			}

			//ÊÇ·ñÔÊÐíÆÀÂÛ
			if(!empty($development['noreply'])) {
				showmessage('do_not_accept_comments');
			}
			if($development['target_ids']) {
				$development['target_ids'] .= ",$development[uid]";
			}
			
			$hotarr = array('developmentid', $development['developmentid'], $development['hotuser']);
			$stattype = 'developmentcomment';//Í³¼Æ
			break;
		case 'industryid':
			//¶ÁÈ¡ÈÕÖ¾
			$query = $_SGLOBAL['db']->query("SELECT b.*, bf.target_ids, bf.hotuser
				FROM ".tname('industry')." b
				LEFT JOIN ".tname('industryfield')." bf ON bf.industryid=b.industryid
				WHERE b.industryid='$id'");
			$industry = $_SGLOBAL['db']->fetch_array($query);
			//ÈÕÖ¾²»´æÔÚ
			if(empty($industry)) {
				showmessage('view_to_info_did_not_exist');
			}
			
			//¼ìË÷¿Õ¼ä
			$tospace = getspace($industry['uid']);
			
			//ÑéÖ¤ÒþË½
			if(!ckfriend($industry['uid'], $industry['friend'], $industry['target_ids'])) {
				//Ã»ÓÐÈ¨ÏÞ
				showmessage('no_privilege');
			} elseif(!$tospace['self'] && $industry['friend'] == 4) {
				//ÃÜÂëÊäÈëÎÊÌâ
				$cookiename = "view_pwd_industry_$industry[industryid]";
				$cookievalue = empty($_SCOOKIE[$cookiename])?'':$_SCOOKIE[$cookiename];
				if($cookievalue != md5(md5($industry['password']))) {
					showmessage('no_privilege');
				}
			}

			//ÊÇ·ñÔÊÐíÆÀÂÛ
			if(!empty($industry['noreply'])) {
				showmessage('do_not_accept_comments');
			}
			if($industry['target_ids']) {
				$industry['target_ids'] .= ",$industry[uid]";
			}
			
			$hotarr = array('industryid', $industry['industryid'], $industry['hotuser']);
			$stattype = 'industrycomment';//Í³¼Æ
			break;
		case 'casesid':
			//¶ÁÈ¡ÈÕÖ¾
			$query = $_SGLOBAL['db']->query("SELECT b.*, bf.target_ids, bf.hotuser
				FROM ".tname('cases')." b
				LEFT JOIN ".tname('casesfield')." bf ON bf.casesid=b.casesid
				WHERE b.casesid='$id'");
			$cases = $_SGLOBAL['db']->fetch_array($query);
			//ÈÕÖ¾²»´æÔÚ
			if(empty($cases)) {
				showmessage('view_to_info_did_not_exist');
			}
			
			//¼ìË÷¿Õ¼ä
			$tospace = getspace($cases['uid']);
			
			//ÑéÖ¤ÒþË½
			if(!ckfriend($cases['uid'], $cases['friend'], $cases['target_ids'])) {
				//Ã»ÓÐÈ¨ÏÞ
				showmessage('no_privilege');
			} elseif(!$tospace['self'] && $cases['friend'] == 4) {
				//ÃÜÂëÊäÈëÎÊÌâ
				$cookiename = "view_pwd_cases_$cases[casesid]";
				$cookievalue = empty($_SCOOKIE[$cookiename])?'':$_SCOOKIE[$cookiename];
				if($cookievalue != md5(md5($cases['password']))) {
					showmessage('no_privilege');
				}
			}

			//ÊÇ·ñÔÊÐíÆÀÂÛ
			if(!empty($cases['noreply'])) {
				showmessage('do_not_accept_comments');
			}
			if($cases['target_ids']) {
				$cases['target_ids'] .= ",$cases[uid]";
			}
			
			$hotarr = array('casesid', $cases['casesid'], $cases['hotuser']);
			$stattype = 'casescomment';//Í³¼Æ
			break;
			case 'branchid':
			//¶ÁÈ¡ÈÕÖ¾
			$query = $_SGLOBAL['db']->query("SELECT b.*, bf.target_ids, bf.hotuser
				FROM ".tname('branch')." b
				LEFT JOIN ".tname('branchfield')." bf ON bf.branchid=b.branchid
				WHERE b.branchid='$id'");
			$branch = $_SGLOBAL['db']->fetch_array($query);
			//ÈÕÖ¾²»´æÔÚ
			if(empty($branch)) {
				showmessage('view_to_info_did_not_exist');
			}
			
			//¼ìË÷¿Õ¼ä
			$tospace = getspace($branch['uid']);
			
			//ÑéÖ¤ÒþË½
			if(!ckfriend($branch['uid'], $branch['friend'], $branch['target_ids'])) {
				//Ã»ÓÐÈ¨ÏÞ
				showmessage('no_privilege');
			} elseif(!$tospace['self'] && $branch['friend'] == 4) {
				//ÃÜÂëÊäÈëÎÊÌâ
				$cookiename = "view_pwd_branch_$branch[branchid]";
				$cookievalue = empty($_SCOOKIE[$cookiename])?'':$_SCOOKIE[$cookiename];
				if($cookievalue != md5(md5($branch['password']))) {
					showmessage('no_privilege');
				}
			}

			//ÊÇ·ñÔÊÐíÆÀÂÛ
			if(!empty($branch['noreply'])) {
				showmessage('do_not_accept_comments');
			}
			if($branch['target_ids']) {
				$branch['target_ids'] .= ",$branch[uid]";
			}
			
			$hotarr = array('branchid', $branch['branchid'], $branch['hotuser']);
			$stattype = 'branchcomment';//Í³¼Æ
			break;
		case 'jobid':
			//¶ÁÈ¡ÈÕÖ¾
			$query = $_SGLOBAL['db']->query("SELECT b.*, bf.target_ids, bf.hotuser
				FROM ".tname('job')." b
				LEFT JOIN ".tname('jobfield')." bf ON bf.jobid=b.jobid
				WHERE b.jobid='$id'");
			$job = $_SGLOBAL['db']->fetch_array($query);
			//ÈÕÖ¾²»´æÔÚ
			if(empty($job)) {
				showmessage('view_to_info_did_not_exist');
			}
			
			//¼ìË÷¿Õ¼ä
			$tospace = getspace($job['uid']);
			
			//ÑéÖ¤ÒþË½
			if(!ckfriend($job['uid'], $job['friend'], $job['target_ids'])) {
				//Ã»ÓÐÈ¨ÏÞ
				showmessage('no_privilege');
			} elseif(!$tospace['self'] && $job['friend'] == 4) {
				//ÃÜÂëÊäÈëÎÊÌâ
				$cookiename = "view_pwd_job_$job[jobid]";
				$cookievalue = empty($_SCOOKIE[$cookiename])?'':$_SCOOKIE[$cookiename];
				if($cookievalue != md5(md5($job['password']))) {
					showmessage('no_privilege');
				}
			}

			//ÊÇ·ñÔÊÐíÆÀÂÛ
			if(!empty($job['noreply'])) {
				showmessage('do_not_accept_comments');
			}
			if($job['target_ids']) {
				$job['target_ids'] .= ",$job[uid]";
			}
			
			$hotarr = array('jobid', $job['jobid'], $job['hotuser']);
			$stattype = 'jobcomment';//Í³¼Æ
			break;
			case 'menusetid':
			//¶ÁÈ¡ÈÕÖ¾
			$query = $_SGLOBAL['db']->query("SELECT b.*, bf.target_ids, bf.hotuser
				FROM ".tname('menuset')." b
				LEFT JOIN ".tname('menusetfield')." bf ON bf.menusetid=b.menusetid
				WHERE b.menusetid='$id'");
			$menuset = $_SGLOBAL['db']->fetch_array($query);
			//ÈÕÖ¾²»´æÔÚ
			if(empty($menuset)) {
				showmessage('view_to_info_did_not_exist');
			}
			
			//¼ìË÷¿Õ¼ä
			$tospace = getspace($menuset['uid']);
			
			//ÑéÖ¤ÒþË½
			if(!ckfriend($menuset['uid'], $menuset['friend'], $menuset['target_ids'])) {
				//Ã»ÓÐÈ¨ÏÞ
				showmessage('no_privilege');
			} elseif(!$tospace['self'] && $menuset['friend'] == 4) {
				//ÃÜÂëÊäÈëÎÊÌâ
				$cookiename = "view_pwd_menuset_$menuset[menusetid]";
				$cookievalue = empty($_SCOOKIE[$cookiename])?'':$_SCOOKIE[$cookiename];
				if($cookievalue != md5(md5($menuset['password']))) {
					showmessage('no_privilege');
				}
			}

			//ÊÇ·ñÔÊÐíÆÀÂÛ
			if(!empty($menuset['noreply'])) {
				showmessage('do_not_accept_comments');
			}
			if($menuset['target_ids']) {
				$menuset['target_ids'] .= ",$menuset[uid]";
			}
			
			$hotarr = array('menusetid', $menuset['menusetid'], $menuset['hotuser']);
			$stattype = 'menusetcomment';//Í³¼Æ
			break;
		case 'goodsid':
			//¶ÁÈ¡ÈÕÖ¾
			$query = $_SGLOBAL['db']->query("SELECT b.*, bf.target_ids, bf.hotuser
				FROM ".tname('goods')." b
				LEFT JOIN ".tname('goodsfield')." bf ON bf.goodsid=b.goodsid
				WHERE b.goodsid='$id'");
			$goods = $_SGLOBAL['db']->fetch_array($query);
			//ÈÕÖ¾²»´æÔÚ
			if(empty($goods)) {
				showmessage('view_to_info_did_not_exist');
			}
		
			//¼ìË÷¿Õ¼ä
			$tospace = getspace($goods['uid']);
			
			//ÑéÖ¤ÒþË½
			if(!ckfriend($goods['uid'], $goods['friend'], $goods['target_ids'])) {
				//Ã»ÓÐÈ¨ÏÞ
				showmessage('no_privilege');
			} elseif(!$tospace['self'] && $goods['friend'] == 4) {
				//ÃÜÂëÊäÈëÎÊÌâ
				$cookiename = "view_pwd_goods_$goods[goodsid]";
				$cookievalue = empty($_SCOOKIE[$cookiename])?'':$_SCOOKIE[$cookiename];
				if($cookievalue != md5(md5($goods['password']))) {
					showmessage('no_privilege');
				}
			}

			//ÊÇ·ñÔÊÐíÆÀÂÛ
			if(!empty($goods['noreply'])) {
				showmessage('do_not_accept_comments');
			}
			if($goods['target_ids']) {
				$goods['target_ids'] .= ",$goods[uid]";
			}
			
			$hotarr = array('goodsid', $goods['goodsid'], $goods['hotuser']);
			$stattype = 'goodscomment';//Í³¼Æ
			break;	
		case 'sid':
			//¶ÁÈ¡ÈÕÖ¾
			$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('share')." WHERE sid='$id'");
			$share = $_SGLOBAL['db']->fetch_array($query);
			//ÈÕÖ¾²»´æÔÚ
			if(empty($share)) {
				showmessage('sharing_does_not_exist');
			}

			//¼ìË÷¿Õ¼ä
			$tospace = getspace($share['uid']);
			
			$hotarr = array('sid', $share['sid'], $share['hotuser']);
			$stattype = 'sharecomment';//Í³¼Æ
			break;
		case 'pid':
			$query = $_SGLOBAL['db']->query("SELECT p.*, pf.hotuser
				FROM ".tname('poll')." p
				LEFT JOIN ".tname('pollfield')." pf ON pf.pid=p.pid
				WHERE p.pid='$id'");
			$poll = $_SGLOBAL['db']->fetch_array($query);
			if(empty($poll)) {
				showmessage('voting_does_not_exist');
			}
			//ÊÇ·ñÔÊÐíÆÀÂÛ
			$tospace = getspace($poll['uid']);
			if($poll['noreply']) {
				//ÊÇ·ñºÃÓÑ
				if(!$tospace['self'] && !in_array($_SGLOBAL['supe_uid'], $tospace['friends'])) {
					showmessage('the_vote_only_allows_friends_to_comment');
				}
			}
			
			$hotarr = array('pid', $poll['pid'], $poll['hotuser']);
			$stattype = 'pollcomment';//Í³¼Æ
			break;
		case 'eventid':
		    // ¶ÁÈ¡»î¶¯
		    $query = $_SGLOBAL['db']->query("SELECT e.*, ef.* FROM ".tname('event')." e LEFT JOIN ".tname("eventfield")." ef ON e.eventid=ef.eventid WHERE e.eventid='$id'");
			$event = $_SGLOBAL['db']->fetch_array($query);

			if(empty($event)) {
				showmessage('event_does_not_exist');
			}
			
			if($event['grade'] < -1){
				showmessage('event_is_closed');//»î¶¯ÒÑ¾­¹Ø±Õ
			} elseif($event['grade'] <= 0){
				showmessage('event_under_verify');//»î¶¯Î´Í¨¹ýÉóºË
			}
			
			if(!$event['allowpost']){
				$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname("userevent")." WHERE eventid='$id' AND uid='$_SGLOBAL[supe_uid]' LIMIT 1");
				$value = $_SGLOBAL['db']->fetch_array($query);
				if(empty($value) || $value['status'] < 2){
					showmessage('event_only_allows_members_to_comment');//Ö»ÓÐ»î¶¯³ÉÔ±ÔÊÐí·¢±íÁôÑÔ
				}
			}

			//¼ìË÷¿Õ¼ä
			$tospace = getspace($event['uid']);
			
			$hotarr = array('eventid', $event['eventid'], $event['hotuser']);
			$stattype = 'eventcomment';//Í³¼Æ
			break;
		default:
			showmessage('non_normal_operation');
			break;
	}
	
	if(empty($tospace)) {
		showmessage('space_does_not_exist');
	}
	
	//ÊÓÆµÈÏÖ¤
	if($tospace['videostatus']) {
		if($idtype == 'uid') {
			ckvideophoto('wall', $tospace);
		} else {
			ckvideophoto('comment', $tospace);
		}
	}
	
	//ºÚÃûµ¥
	if(isblacklist($tospace['uid'])) {
		showmessage('is_blacklist');
	}
	
	//ÈÈµã
	if($hotarr && $tospace['uid'] != $_SGLOBAL['supe_uid']) {
		hot_update($hotarr[0], $hotarr[1], $hotarr[2]);
	}

	//ÊÂ¼þ
	$fs = array();
	$fs['icon'] = 'comment';
	$fs['target_ids'] = $fs['friend'] = '';

	switch ($_POST['idtype']) {
		case 'uid':
			//ÊÂ¼þ
			$fs['icon'] = 'wall';
			$fs['title_template'] = cplang('feed_comment_space');
			$fs['title_data'] = array('touser'=>"<a href=\"space.php?uid=$tospace[uid]\">".$_SN[$tospace['uid']]."</a>");
			$fs['body_template'] = '';
			$fs['body_data'] = array();
			$fs['body_general'] = '';
			$fs['images'] = array();
			$fs['image_links'] = array();
			break;
		case 'picid':
			//ÊÂ¼þ
			$fs['title_template'] = cplang('feed_comment_image');
			$fs['title_data'] = array('touser'=>"<a href=\"space.php?uid=$tospace[uid]\">".$_SN[$tospace['uid']]."</a>");
			$fs['body_template'] = '{pic_title}';
			$fs['body_data'] = array('pic_title'=>$pic['title']);
			$fs['body_general'] = $summay;
			$fs['images'] = array(pic_get($pic['filepath'], $pic['thumb'], $pic['remote']));
			$fs['image_links'] = array("space.php?uid=$tospace[uid]&do=album&picid=$pic[picid]");
			$fs['target_ids'] = $album['target_ids'];
			$fs['friend'] = $album['friend'];
			break;
		case 'blogid':
			//¸üÐÂÆÀÂÛÍ³¼Æ
			$_SGLOBAL['db']->query("UPDATE ".tname('blog')." SET replynum=replynum+1 WHERE blogid='$id'");
			//ÊÂ¼þ
			$fs['title_template'] = cplang('feed_comment_blog');
			$fs['title_data'] = array('touser'=>"<a href=\"space.php?uid=$tospace[uid]\">".$_SN[$tospace['uid']]."</a>", 'blog'=>"<a href=\"space.php?uid=$tospace[uid]&do=blog&id=$id\">$blog[subject]</a>");
			$fs['body_template'] = '';
			$fs['body_data'] = array();
			$fs['body_general'] = '';
			$fs['target_ids'] = $blog['target_ids'];
			$fs['friend'] = $blog['friend'];
			break;
		case 'introduceid':
			//¸üÐÂÆÀÂÛÍ³¼Æ
			$_SGLOBAL['db']->query("UPDATE ".tname('introduce')." SET replynum=replynum+1 WHERE introduceid='$id'");
			//ÊÂ¼þ
			$fs['title_template'] = cplang('feed_comment_introduce');
			$fs['title_data'] = array('touser'=>"<a href=\"space.php?uid=$tospace[uid]\">".$_SN[$tospace['uid']]."</a>", 'blog'=>"<a href=\"space.php?uid=$tospace[uid]&do=introduce&id=$id\">$introduce[subject]</a>");
			$fs['body_template'] = '';
			$fs['body_data'] = array();
			$fs['body_general'] = '';
			$fs['target_ids'] = $introduce['target_ids'];
			$fs['friend'] = $introduce['friend'];
			break;
		case 'productid':
			//¸üÐÂÆÀÂÛÍ³¼Æ
			$_SGLOBAL['db']->query("UPDATE ".tname('product')." SET replynum=replynum+1 WHERE productid='$id'");
			//ÊÂ¼þ
			$fs['title_template'] = cplang('feed_comment_product');
			$fs['title_data'] = array('touser'=>"<a href=\"space.php?uid=$tospace[uid]\">".$_SN[$tospace['uid']]."</a>", 'blog'=>"<a href=\"space.php?uid=$tospace[uid]&do=product&id=$id\">$product[subject]</a>");
			$fs['body_template'] = '';
			$fs['body_data'] = array();
			$fs['body_general'] = '';
			$fs['target_ids'] = $product['target_ids'];
			$fs['friend'] = $product['friend'];
			break;
		case 'developmentid':
			//¸üÐÂÆÀÂÛÍ³¼Æ
			$_SGLOBAL['db']->query("UPDATE ".tname('development')." SET replynum=replynum+1 WHERE developmentid='$id'");
			//ÊÂ¼þ
			$fs['title_template'] = cplang('feed_comment_development');
			$fs['title_data'] = array('touser'=>"<a href=\"space.php?uid=$tospace[uid]\">".$_SN[$tospace['uid']]."</a>", 'blog'=>"<a href=\"space.php?uid=$tospace[uid]&do=development&id=$id\">$development[subject]</a>");
			$fs['body_template'] = '';
			$fs['body_data'] = array();
			$fs['body_general'] = '';
			$fs['target_ids'] = $development['target_ids'];
			$fs['friend'] = $development['friend'];
			break;
		case 'industryid':
			//¸üÐÂÆÀÂÛÍ³¼Æ
			$_SGLOBAL['db']->query("UPDATE ".tname('industry')." SET replynum=replynum+1 WHERE industryid='$id'");
			//ÊÂ¼þ
			$fs['title_template'] = cplang('feed_comment_industry');
			$fs['title_data'] = array('touser'=>"<a href=\"space.php?uid=$tospace[uid]\">".$_SN[$tospace['uid']]."</a>", 'blog'=>"<a href=\"space.php?uid=$tospace[uid]&do=industry&id=$id\">$industry[subject]</a>");
			$fs['body_template'] = '';
			$fs['body_data'] = array();
			$fs['body_general'] = '';
			$fs['target_ids'] = $industry['target_ids'];
			$fs['friend'] = $industry['friend'];
			break;
		case 'casesid':
			//¸üÐÂÆÀÂÛÍ³¼Æ
			$_SGLOBAL['db']->query("UPDATE ".tname('cases')." SET replynum=replynum+1 WHERE casesid='$id'");
			//ÊÂ¼þ
			$fs['title_template'] = cplang('feed_comment_cases');
			$fs['title_data'] = array('touser'=>"<a href=\"space.php?uid=$tospace[uid]\">".$_SN[$tospace['uid']]."</a>", 'blog'=>"<a href=\"space.php?uid=$tospace[uid]&do=cases&id=$id\">$cases[subject]</a>");
			$fs['body_template'] = '';
			$fs['body_data'] = array();
			$fs['body_general'] = '';
			$fs['target_ids'] = $cases['target_ids'];
			$fs['friend'] = $cases['friend'];
			break;
		case 'branchid':
			//¸üÐÂÆÀÂÛÍ³¼Æ
			$_SGLOBAL['db']->query("UPDATE ".tname('branch')." SET replynum=replynum+1 WHERE branchid='$id'");
			//ÊÂ¼þ
			$fs['title_template'] = cplang('feed_comment_branch');
			$fs['title_data'] = array('touser'=>"<a href=\"space.php?uid=$tospace[uid]\">".$_SN[$tospace['uid']]."</a>", 'blog'=>"<a href=\"space.php?uid=$tospace[uid]&do=branch&id=$id\">$branch[subject]</a>");
			$fs['body_template'] = '';
			$fs['body_data'] = array();
			$fs['body_general'] = '';
			$fs['target_ids'] = $branch['target_ids'];
			$fs['friend'] = $branch['friend'];
			break;
		case 'jobid':
			//¸üÐÂÆÀÂÛÍ³¼Æ
			$_SGLOBAL['db']->query("UPDATE ".tname('job')." SET replynum=replynum+1 WHERE jobid='$id'");
			//ÊÂ¼þ
			$fs['title_template'] = cplang('feed_comment_job');
			$fs['title_data'] = array('touser'=>"<a href=\"space.php?uid=$tospace[uid]\">".$_SN[$tospace['uid']]."</a>", 'blog'=>"<a href=\"space.php?uid=$tospace[uid]&do=job&id=$id\">$job[subject]</a>");
			$fs['body_template'] = '';
			$fs['body_data'] = array();
			$fs['body_general'] = '';
			$fs['target_ids'] = $job['target_ids'];
			$fs['friend'] = $job['friend'];
			break;
		case 'menusetid':
			//¸üÐÂÆÀÂÛÍ³¼Æ
			$_SGLOBAL['db']->query("UPDATE ".tname('menuset')." SET replynum=replynum+1 WHERE menusetid='$id'");
			//ÊÂ¼þ
			$fs['title_template'] = cplang('feed_comment_menuset');
			$fs['title_data'] = array('touser'=>"<a href=\"space.php?uid=$tospace[uid]\">".$_SN[$tospace['uid']]."</a>", 'blog'=>"<a href=\"space.php?uid=$tospace[uid]&do=menuset&id=$id\">$menuset[subject]</a>");
			$fs['body_template'] = '';
			$fs['body_data'] = array();
			$fs['body_general'] = '';
			$fs['target_ids'] = $menuset['target_ids'];
			$fs['friend'] = $menuset['friend'];
			break;
		case 'goodsid':
			//¸üÐÂÆÀÂÛÍ³¼Æ
			$_SGLOBAL['db']->query("UPDATE ".tname('goods')." SET replynum=replynum+1 WHERE goodsid='$id'");
			//ÊÂ¼þ
			$fs['title_template'] = cplang('feed_comment_goods');
			$fs['title_data'] = array('touser'=>"<a href=\"space.php?uid=$tospace[uid]\">".$_SN[$tospace['uid']]."</a>", 'blog'=>"<a href=\"space.php?uid=$tospace[uid]&do=menuset&id=$id\">$menuset[subject]</a>");
			$fs['body_template'] = '';
			$fs['body_data'] = array();
			$fs['body_general'] = '';
			$fs['target_ids'] = $menuset['target_ids'];
			$fs['friend'] = $menuset['friend'];
			break;	
		case 'sid':
			//ÊÂ¼þ
			$fs['title_template'] = cplang('feed_comment_share');
			$fs['title_data'] = array('touser'=>"<a href=\"space.php?uid=$tospace[uid]\">".$_SN[$tospace['uid']]."</a>", 'share'=>"<a href=\"space.php?uid=$tospace[uid]&do=share&id=$id\">".str_replace(cplang('share_action'), '', $share['title_template'])."</a>");
			$fs['body_template'] = '';
			$fs['body_data'] = array();
			$fs['body_general'] = '';
			break;
		case 'eventid':
		    // »î¶¯
		    $fs['title_template'] = cplang('feed_comment_event');
			$fs['title_data'] = array('touser'=>"<a href=\"space.php?uid=$tospace[uid]\">".$_SN[$tospace['uid']]."</a>", 'event'=>'<a href="space.php?do=event&id='.$event['eventid'].'">'.$event['title'].'</a>');
			$fs['body_template'] = '';
			$fs['body_data'] = array();
			$fs['body_general'] = '';
			break;
		case 'pid':
			// Í¶Æ±
			//¸üÐÂÆÀÂÛÍ³¼Æ
			$_SGLOBAL['db']->query("UPDATE ".tname('poll')." SET replynum=replynum+1 WHERE pid='$id'");
			$fs['title_template'] = cplang('feed_comment_poll');
			$fs['title_data'] = array('touser'=>"<a href=\"space.php?uid=$tospace[uid]\">".$_SN[$tospace['uid']]."</a>", 'poll'=>"<a href=\"space.php?uid=$tospace[uid]&do=poll&pid=$id\">$poll[subject]</a>");
			$fs['body_template'] = '';
			$fs['body_data'] = array();
			$fs['body_general'] = '';
			$fs['friend'] = '';
			break;
	}

	$setarr = array(
		'uid' => $tospace['uid'],
		'id' => $id,
		'idtype' => $_POST['idtype'],
		'authorid' => $_SGLOBAL['supe_uid'],
		'author' => $_SGLOBAL['supe_username'],
		'dateline' => $_SGLOBAL['timestamp'],
		'message' => $message,
		'ip' => getonlineip()
	);
	//Èë¿â
	$cid = inserttable('comment', $setarr, 1);
	$action = 'comment';
	$becomment = 'getcomment';
	switch ($_POST['idtype']) {
		case 'uid':
			$n_url = "space.php?uid=$tospace[uid]&do=wall&cid=$cid";
			$note_type = 'wall';
			$note = cplang('note_wall', array($n_url));
			$q_note = cplang('note_wall_reply', array($n_url));
			if($comment) {
				$msg = 'note_wall_reply_success';
				$magvalues = array($_SN[$tospace['uid']]);
				$becomment = '';
			} else {
				$msg = 'do_success';
				$magvalues = array();
				$becomment = 'getguestbook';
			}
			$msgtype = 'comment_friend';
			$q_msgtype = 'comment_friend_reply';
			$action = 'guestbook';
			break;
		case 'picid':
			$n_url = "space.php?uid=$tospace[uid]&do=album&picid=$id&cid=$cid";
			$note_type = 'piccomment';
			$note = cplang('note_pic_comment', array($n_url));
			$q_note = cplang('note_pic_comment_reply', array($n_url));
			$msg = 'do_success';
			$magvalues = array();
			$msgtype = 'photo_comment';
			$q_msgtype = 'photo_comment_reply';
			break;
		case 'blogid':
			//Í¨Öª
			$n_url = "space.php?uid=$tospace[uid]&do=blog&id=$id&cid=$cid";
			$note_type = 'blogcomment';
			$note = cplang('note_blog_comment', array($n_url, $blog['subject']));
			$q_note = cplang('note_blog_comment_reply', array($n_url));
			$msg = 'do_success';
			$magvalues = array();
			$msgtype = 'blog_comment';
			$q_msgtype = 'blog_comment_reply';
			break;
		case 'introduceid':
			//Í¨Öª
			$n_url = "space.php?uid=$tospace[uid]&do=introduce&id=$id&cid=$cid";
			$note_type = 'introducecomment';
			$note = cplang('note_introduce_comment', array($n_url, $introduce['subject']));
			$q_note = cplang('note_introduce_comment_reply', array($n_url));
			$msg = 'do_success';
			$magvalues = array();
			$msgtype = 'introduce_comment';
			$q_msgtype = 'introduce_comment_reply';
			break;
		case 'productid':
			//Í¨Öª
			$n_url = "space.php?uid=$tospace[uid]&do=product&id=$id&cid=$cid";
			$note_type = 'productcomment';
			$note = cplang('note_product_comment', array($n_url, $product['subject']));
			$q_note = cplang('note_product_comment_reply', array($n_url));
			$msg = 'do_success';
			$magvalues = array();
			$msgtype = 'product_comment';
			$q_msgtype = 'product_comment_reply';
			break;
		case 'developmentid':
			//Í¨Öª
			$n_url = "space.php?uid=$tospace[uid]&do=development&id=$id&cid=$cid";
			$note_type = 'developmentcomment';
			$note = cplang('note_development_comment', array($n_url, $development['subject']));
			$q_note = cplang('note_development_comment_reply', array($n_url));
			$msg = 'do_success';
			$magvalues = array();
			$msgtype = 'development_comment';
			$q_msgtype = 'development_comment_reply';
			break;
		case 'industryid':
			//Í¨Öª
			$n_url = "space.php?uid=$tospace[uid]&do=industry&id=$id&cid=$cid";
			$note_type = 'industrycomment';
			$note = cplang('note_industry_comment', array($n_url, $industry['subject']));
			$q_note = cplang('note_industry_comment_reply', array($n_url));
			$msg = 'do_success';
			$magvalues = array();
			$msgtype = 'industry_comment';
			$q_msgtype = 'industry_comment_reply';
			break;
		case 'casesid':
			//Í¨Öª
			$n_url = "space.php?uid=$tospace[uid]&do=cases&id=$id&cid=$cid";
			$note_type = 'casescomment';
			$note = cplang('note_cases_comment', array($n_url, $cases['subject']));
			$q_note = cplang('note_cases_comment_reply', array($n_url));
			$msg = 'do_success';
			$magvalues = array();
			$msgtype = 'cases_comment';
			$q_msgtype = 'cases_comment_reply';
			break;
		case 'branchid':
			//Í¨Öª
			$n_url = "space.php?uid=$tospace[uid]&do=branch&id=$id&cid=$cid";
			$note_type = 'branchcomment';
			$note = cplang('note_branch_comment', array($n_url, $branch['subject']));
			$q_note = cplang('note_branch_comment_reply', array($n_url));
			$msg = 'do_success';
			$magvalues = array();
			$msgtype = 'branch_comment';
			$q_msgtype = 'branch_comment_reply';
			break;
		case 'jobid':
			//Í¨Öª
			$n_url = "space.php?uid=$tospace[uid]&do=job&id=$id&cid=$cid";
			$note_type = 'jobcomment';
			$note = cplang('note_job_comment', array($n_url, $job['subject']));
			$q_note = cplang('note_job_comment_reply', array($n_url));
			$msg = 'do_success';
			$magvalues = array();
			$msgtype = 'job_comment';
			$q_msgtype = 'job_comment_reply';
			break;
		case 'menusetid':
			//Í¨Öª
			$n_url = "space.php?uid=$tospace[uid]&do=menuset&id=$id&cid=$cid";
			$note_type = 'menusetcomment';
			$note = cplang('note_menuset_comment', array($n_url, $menuset['subject']));
			$q_note = cplang('note_menuset_comment_reply', array($n_url));
			$msg = 'do_success';
			$magvalues = array();
			$msgtype = 'menuset_comment';
			$q_msgtype = 'menuset_comment_reply';
			break;
		case 'goodsid':
			//Í¨Öª
			$n_url = "space.php?uid=$tospace[uid]&do=goods&id=$id&cid=$cid";
			$note_type = 'goodscomment';
			$note = cplang('note_goods_comment', array($n_url, $goods['subject']));
			$q_note = cplang('note_goods_comment_reply', array($n_url));
			$msg = 'do_success';
			$magvalues = array();
			$msgtype = 'goods_comment';
			$q_msgtype = 'goods_comment_reply';
			break;
		case 'sid':
			//·ÖÏí
			$n_url = "space.php?uid=$tospace[uid]&do=share&id=$id&cid=$cid";
			$note_type = 'sharecomment';
			$note = cplang('note_share_comment', array($n_url));
			$q_note = cplang('note_share_comment_reply', array($n_url));
			$msg = 'do_success';
			$magvalues = array();
			$msgtype = 'share_comment';
			$q_msgtype = 'share_comment_reply';
			break;
		case 'pid':
			$n_url = "space.php?uid=$tospace[uid]&do=poll&pid=$id&cid=$cid";
			$note_type = 'pollcomment';
			$note = cplang('note_poll_comment', array($n_url, $poll['subject']));
			$q_note = cplang('note_poll_comment_reply', array($n_url));
			$msg = 'do_success';
			$magvalues = array();
			$msgtype = 'poll_comment';
			$q_msgtype = 'poll_comment_reply';
			break;
		case 'eventid':
		    // »î¶¯
		    $n_url = "space.php?do=event&id=$id&view=comment&cid=$cid";
		    $note_type = 'eventcomment';
		    $note = cplang('note_event_comment', array($n_url));
		    $q_note = cplang('note_event_comment_reply', array($n_url));
		    $msg = 'do_success';
		    $magvalues = array();
		    $msgtype = 'event_comment';
		    $q_msgtype = 'event_comment_reply';
		    break;
	}

	if(empty($comment)) {
		//·ÇÒýÓÃÆÀÂÛ
		if($tospace['uid'] != $_SGLOBAL['supe_uid']) {
			//ÊÂ¼þ·¢²¼
			if(ckprivacy('comment', 1)) {
				feed_add($fs['icon'], $fs['title_template'], $fs['title_data'], $fs['body_template'], $fs['body_data'], $fs['body_general'],$fs['images'], $fs['image_links'], $fs['target_ids'], $fs['friend'],'','',$_POST['idtype'] );
			}
			
			//·¢ËÍÍ¨Öª
			notification_add($tospace['uid'], $note_type, $note);
			
			//ÁôÑÔ·¢ËÍ¶ÌÏûÏ¢
			if($_POST['idtype'] == 'uid' && $tospace['updatetime'] == $tospace['dateline']) {
				include_once S_ROOT.'./uc_client/client.php';
				uc_pm_send($_SGLOBAL['supe_uid'], $tospace['uid'], cplang('wall_pm_subject'), cplang('wall_pm_message', array(addslashes(getsiteurl().$n_url))), 1, 0, 0);
				
			}
			if($_POST['idtype']=='introduceid'){
				include_once S_ROOT.'./uc_client/client.php';
				uc_pm_send($_SGLOBAL['supe_uid'], $tospace['uid'], cplang('wall_pm_subject'), cplang('introduce_pm_message', array($message)), 1, 0, 0);
			}
			if($_POST['idtype']=='productid'){
				include_once S_ROOT.'./uc_client/client.php';
				uc_pm_send($_SGLOBAL['supe_uid'], $tospace['uid'], cplang('wall_pm_subject'), cplang('product_pm_message', array($message)), 1, 0, 0);
			}
			if($_POST['idtype']=='developmentid'){
				include_once S_ROOT.'./uc_client/client.php';
				uc_pm_send($_SGLOBAL['supe_uid'], $tospace['uid'], cplang('wall_pm_subject'), cplang('development_pm_message', array($message)), 1, 0, 0);
			}
			if($_POST['idtype']=='industryid'){
				include_once S_ROOT.'./uc_client/client.php';
				uc_pm_send($_SGLOBAL['supe_uid'], $tospace['uid'], cplang('wall_pm_subject'), cplang('industry_pm_message', array($message)), 1, 0, 0);
			}
			if($_POST['idtype']=='casesid'){
				include_once S_ROOT.'./uc_client/client.php';
				uc_pm_send($_SGLOBAL['supe_uid'], $tospace['uid'], cplang('wall_pm_subject'), cplang('cases_pm_message', array($message)), 1, 0, 0);
			}
			if($_POST['idtype']=='branchid'){
				include_once S_ROOT.'./uc_client/client.php';
				uc_pm_send($_SGLOBAL['supe_uid'], $tospace['uid'], cplang('wall_pm_subject'), cplang('branch_pm_message', array($message)), 1, 0, 0);
			}
			if($_POST['idtype']=='jobid'){
				include_once S_ROOT.'./uc_client/client.php';
				uc_pm_send($_SGLOBAL['supe_uid'], $tospace['uid'], cplang('wall_pm_subject'), cplang('job_pm_message', array($message)), 1, 0, 0);
			}
			if($_POST['idtype']=='goodsid'){
				include_once S_ROOT.'./uc_client/client.php';
				uc_pm_send($_SGLOBAL['supe_uid'], $tospace['uid'], cplang('wall_pm_subject'), cplang('goods_pm_message', array($message)), 1, 0, 0);
			}
			//·¢ËÍÓÊ¼þÍ¨Öª
			smail($tospace['uid'], '', cplang($msgtype, array($_SN[$space['uid']], shtmlspecialchars(getsiteurl().$n_url))), '', $msgtype);
		}
		
	} elseif($comment['authorid'] != $_SGLOBAL['supe_uid']) {
		
		//·¢ËÍÓÊ¼þÍ¨Öª
		smail($comment['authorid'], '', cplang($q_msgtype, array($_SN[$space['uid']], shtmlspecialchars(getsiteurl().$n_url))), '', $q_msgtype);
		notification_add($comment['authorid'], $note_type, $q_note);
		
	}
	
	//Í³¼Æ
	if($stattype) {
		updatestat($stattype);
		updateuserstat('hot');
	}

	//»ý·Ö
	if($tospace['uid'] != $_SGLOBAL['supe_uid']) {
		$needle = $id;
		if($_POST['idtype'] != 'uid') {
			$needle = $_POST['idtype'].$id;
		} else {
			$needle = $tospace['uid'];
		}
		//½±ÀøÆÀÂÛ·¢ÆðÕß
		getreward($action, 1, 0, $needle);
		//½±Àø±»ÆÀÂÛÕß
		if($becomment) {
			if($_POST['idtype'] == 'uid') {
				$needle = $_SGLOBAL['supe_uid'];
			}
			getreward($becomment, 1, $tospace['uid'], $needle, 0);
		}
	}

	showmessage($msg, $_POST['refer'], 0, $magvalues);
}

$cid = empty($_GET['cid'])?0:intval($_GET['cid']);

//±à¼­
if($_GET['op'] == 'edit') {

	$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('comment')." WHERE cid='$cid' AND authorid='$_SGLOBAL[supe_uid]'");
	if(!$comment = $_SGLOBAL['db']->fetch_array($query)) {
		showmessage('no_privilege');
	}

	//Ìá½»±à¼­
	if(submitcheck('editsubmit')) {

		$message = getstr($_POST['message'], 0, 1, 1, 1, 2);
		if(strlen($message) < 2) showmessage('content_is_too_short');

		updatetable('comment', array('message'=>$message), array('cid'=>$comment['cid']));

		showmessage('do_success', $_POST['refer'], 0);
	}

	//bbcode×ª»»
	$comment['message'] = html2bbcode($comment['message']);//ÏÔÊ¾ÓÃ

} elseif($_GET['op'] == 'delete') {

	if(submitcheck('deletesubmit')) {
		include_once(S_ROOT.'./source/function_delete.php');
		if(deletecomments(array($cid))) {
			showmessage('do_success', $_POST['refer'], 0);
		} else {
			showmessage('no_privilege');
		}
	}

} elseif($_GET['op'] == 'reply') {

	$query = $_SGLOBAL['db']->query("SELECT * FROM ".tname('comment')." WHERE cid='$cid'");
	if(!$comment = $_SGLOBAL['db']->fetch_array($query)) {
		showmessage('comments_do_not_exist');
	}

} else {

	showmessage('no_privilege');
}

include template('cp_comment');

?>