<?php
// $Id: index.php,v 2.42 2006/05/22 14:59:56 yoshis Exp $

require('header.php');
require_once XOOPS_ROOT_PATH.'/modules/popnupblog/class/PopnupBlogUtils.php';

/*
$param = isset($_GET['param']) ? intval($_GET['param']) : 0;
if($param == 0){
	redirect_header(XOOPS_URL.'/',1,_MD_POPNUPBLOG_INTERNALERROR);
	exit();
}
*/
$params = PopnupBlogUtils::getDateFromHttpParams();
$start = PopnupBlogUtils::getStartFromHttpParams();
$view = $BlogCNF['default_view'];
//print_r($params);
if($params['trackback']) {
	$blog = new PopnupBlog($params['blogid'],$params['postid']);
	$tb = $blog->useTrackBack();
	if($tb == false){
		redirect_header(XOOPS_URL.'/',1,_MD_POPNUPBLOG_INTERNALERROR);
		exit();
	}
	$result = $blog->getBlogData($params['postid'],$params['year'],$params['month'],$params['date']);
	$xoopsOption['template_main'] = 'popnupblog_trackback.html';
	$xoopsTpl->assign('url', "index.php?postid=".$params['postid']);
	$xoopsTpl->assign('mt_tb_url', PopnupBlogUtils::makeTrackBackURL($params['postid']));
	$xoopsTpl->assign('xoops_module_header', '<link rel="alternate" type="application/rss+xml" title="RSS" href="'.PopnupBlogUtils::createRssURL($params['blogid']).'">');
} elseif($params) {
	$xoopsTpl->assign('popimg',PopnupBlogUtils::mail_popimg());		// get email
	$blog = new PopnupBlog($params['blogid'],$params['postid']);
	// init
	if (!$params['blogid']) $params['blogid'] = $blog->blogid;
	$xoopsTpl->assign('popnupblog_editable', false);
	$xoopsTpl->assign('popnupblog_commentable', false);
	$xoopsTpl->assign('params', $params['params']);
	$result = array();
	$result_max_num = (
		PopnupBlogUtils::isCompleteDate($params) && array_key_exists('month', $params) ) ? 31 : POPNUPBLOG_VIEW_LIST_NUM;
	$vote = isset($params['vote']) ? $params['vote'] : 0;
	$result = $blog->getBlogData($params['postid'],$params['year'],$params['month'],$params['date'],$params['command'],$start,$vote);
	if(!empty($result['blog']))
		$xoopsTpl->assign('popnupblog_blogdata', $result['blog']);
	if (!empty($xoopsUser))
		$xoopsTpl->assign('popnupblog_admin', $xoopsUser->isAdmin());
	$xoopsTpl->assign('popnupblog', $result);
	$xoopsTpl->assign('blog_title', $blog->getTitle());
	$xoopsTpl->assign('blog_desc',str_replace('{X_SITEURL}',XOOPS_URL,$blog->getBlogdesc()));
	$xoopsTpl->assign('blog_uname', $blog->getTargetUname());
	$xoopsTpl->assign('popnupblog_targetUid', isset($params['uid']) ? $params['uid'] : 0);
	$xoopsTpl->assign('popnupblog_targetBid', $blog->blogid);
	$xoopsTpl->assign('popnupblog_index', $blog->getBlogIndex());
	if(!empty($result['jump_url']))
		$xoopsTpl->assign('jump_url', $result['jump_url']);
	if(!empty($result['today']))
		$xoopsTpl->assign('popnupblog_today', $result['today']);
	if($blog->canRead()){
		$xoopsTpl->assign('popnupblog_user_rss', PopnupBlogUtils::createRssURL($params['blogid']));
	}
	if (!empty($xoopsUser)){
		if($blog->canWrite($params['blogid']) || $xoopsUser->isAdmin()){
			$xoopsTpl->assign('popnupblog_editable', true);
		}
	}
	$show_name = PopnupBlogUtils::getXoopsModuleConfig('show_name');
	if ($xoopsUser){
		if ( $show_name==1 && (trim(users::realname($xoopsUser->uid()))!='') )
			$uname = users::realname($xoopsUser->uid());
		else
			$uname = $xoopsUser->uname();
	}
	if($blog->canComment($params['blogid'])){
		$xoopsTpl->assign('popnupblog_commentable', true);
		if($xoopsUser){
			$xoopsTpl->assign('popnupblog_uid', $xoopsUser->uid());
			$xoopsTpl->assign('popnupblog_uname', $uname);
		}
	}
	if($blog->canVote($params['blogid'])){
		$xoopsTpl->assign('popnupblog_votable', true);
		if($xoopsUser){
			$xoopsTpl->assign('popnupblog_uid', $xoopsUser->uid());
			$xoopsTpl->assign('popnupblog_uname', $uname);
		}
	}
	$blog->recieve_trackback_ping($params);
	if($params['postid']){
		$xoopsTpl->assign('trackbacks', $blog->getTrackBack($params['postid']));
	}
	if (isset($_GET['view'])) $view = $_GET['view'];
	$xoopsOption['template_main'] = 'popnupblog_view.html';
	$mh = '';
	$mh .= '<link rel="alternate" type="application/rss+xml" title="RSS" href="'.PopnupBlogUtils::createRssURL($params['blogid']).'">'."\n";
	$mh .= '<link rel="start" href="'.PopnupBlogUtils::createUrl($params['blogid']).'" title="Home" />'."\n";
	$xoopsTpl->assign('xoops_module_header', $mh);
	// $xoopsTpl->assign('xoops_module_header', '<link rel="alternate" type="application/rss+xml" title="RSS" href="'.PopnupBlogUtils::createRssURL($params['blogid']).'">');
	// <link rel="start" href="http://el30.sub.jp/" title="Home" />
	// $xoopsTpl->assign('popnupblog_home_url', PopnupBlogUtils::createUrl($params['blogid']));
}else{
//	$popimg = PopnupBlogUtils::mail_popimg();
//	print($popimg);
	$xoopsTpl->assign('popimg',PopnupBlogUtils::mail_popimg());		// get email
	$cat_id=0;
	if (isset($_GET['cat_id'])) $cat_id = $_GET['cat_id'];
	if (isset($_POST['cat_id'])) $cat_id = $_POST['cat_id'];
	$xoopsTpl->assign('popnupblog', PopnupBlogUtils::get_blog_list($start,$cat_id));
	if (isset($_GET['view'])) $view = $_GET['view'];
	if (isset($_POST['view'])) $view = $_POST['view'];
	$xoopsTpl->assign('view',$view);
	$rssUrl = XOOPS_URL.'/modules/popnupblog/rss.php';
	$xoopsTpl->assign('popnupblog_rss_url', $rssUrl);
	$categories = category::get_categories();
	$xoopsTpl->assign('categories', PopnupBlogUtils::mkselect('cat_id',$categories,$cat_id));
	$jump_url = PopnupBlogUtils::mk_list_url($cat_id,$view);
	$xoopsTpl->assign('jump_url', $jump_url);
	$xoopsOption['template_main'] = 'popnupblog_list.html';
	$xoopsTpl->assign('xoops_module_header', '<link rel="alternate" type="application/rss+xml" title="RSS" href="'.$rssUrl.'">');
}

//include XOOPS_ROOT_PATH.'/include/comment_view.php';
require('footer.php');

?>
