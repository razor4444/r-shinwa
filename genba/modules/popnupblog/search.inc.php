<?php
// $Id: search.inc.php,v 1.1.1.1 2005/08/28 02:13:08 yoshis Exp $
if(!defined('XOOPS_ROOT_PATH')){
	exit();
}
global $xoopsConfig;
include_once XOOPS_ROOT_PATH.'/modules/popnupblog/class/popnupblog.php';
include_once XOOPS_ROOT_PATH.'/modules/popnupblog/class/PopnupBlogUtils.php';

function popnupblog_search($queryarray, $andor, $limit, $offset, $userid = -1){
	global $xoopsDB, $xoopsUser;
	$sql = 'select b.blogid, b.title, b.postid, UNIX_TIMESTAMP(b.last_update) ';
	$sql .= ' from '.$xoopsDB->prefix('popnupblog').' b,'.$xoopsDB->prefix('popnupblog_comment').' c,'.$xoopsDB->prefix('popnupblog_info').' info ';
	
	$i = 0;
	if($userid > 0){
		$sql .= " where b.uid = ".$userid." and info.blogid = b.blogid and c.postid = b.postid";
		$sql .= " order by b.last_update desc ";
	}else{
		$sql .= ' where info.blogid = b.blogid and c.postid = b.postid';
		foreach ( $queryarray as $ql ) {
			$sql .= " $andor ";
			$sql .= ' (b.post_text like '.'\'%'.str_replace('\\"', '"', addslashes($ql))
				.'%\' or c.post_text like '.'\'%'.str_replace('\\"', '"', addslashes($ql))
				.'%\' or b.title like '.'\'%'.str_replace('\\"', '"', addslashes($ql)).'%\') ' ;
			$i++;
		}
	}
	// print_r($queryarray);
	$sqlLimit = $limit+$offset;
	$sql = $sql." limit ".$sqlLimit;
	$result = $xoopsDB->query($sql);
	$i = 0;
	$counter = 0;
	$ret = array();
	while( list($blogid, $title, $postid, $last_update) = $xoopsDB->fetchRow($result) ){
		if($counter >= $offset){
			// $ret[$i]['link'] = 'view.php?&blogid='.$blogid.'&year='.$year.'&month='.$month.'&date='.$date;
			$ret[$i]['link'] = "index.php?postid=".$postid;
			$ret[$i]['title'] = (empty($title) || (strlen($title) == 0)) ? "&lt;empty title&gt;" : $title;
			$ret[$i]['time'] = $last_update;
			$ret[$i]['blogid'] = $blogid;
			$i++;
		}
		$counter++;
	}
	return $ret;
}
?>