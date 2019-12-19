<?php
$xoopsOption['nocommon'] = 1;
require '../../mainfile.php';

error_reporting(0);

$q = (isset($_GET['q']))? $_GET['q'] : "";

$dats = array();
$oq = $q = str_replace("\0","",$q);

if ($q !== "")
{
	$q = addslashes($q);

	$where1 = " WHERE `name` LIKE '".$q."%'";
	$where2 = " WHERE `name` LIKE '%".$q."%' AND `name` NOT LIKE '".$q."%'";
	$order = " ORDER BY `name` ASC";
	$limit = 50;

	mysql_connect(XOOPS_DB_HOST, XOOPS_DB_USER, XOOPS_DB_PASS) or die(mysql_error());
	mysql_select_db(XOOPS_DB_NAME); 
	
	$query = "SELECT Distinct(`name`) FROM `".XOOPS_DB_PREFIX."_xpweather_station`".$where1.$order." LIMIT ".$limit;
	
	$suggests = $tags = array();
	if ($result = mysql_query($query))
	{
		while($dat = mysql_fetch_array($result))
		{
			$tags[] = '"'.str_replace('"','\"',$dat[0]).'"';
		}
	}
	
	$count = count($tags);
	if ($count < $limit)
	{
		$query = "SELECT Distinct(`name`) FROM `".XOOPS_DB_PREFIX."_xpweather_station`".$where2.$order." LIMIT ".($limit-$count);
		if ($result = mysql_query($query))
		{
			while($dat = mysql_fetch_array($result))
			{
				$tags[] = '"'.str_replace('"','\"',$dat[0]).'"';
			}
		}		
	}
}

$oq = '"'.str_replace('"','\"',$oq).'"';
$ret = "this.setSuggest($oq,new Array(".join(", ",$tags)."));";

header ("Content-Type: text/html; charset=UTF-8");
header ("Content-Length: ".strlen($ret));
echo $ret;

?>
