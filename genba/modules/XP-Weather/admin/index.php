<?php
//
// Created on 2006/09/16 by nao-pon http://hypweb.net/
// $Id: index.php,v 1.6 2006/09/27 06:47:40 nao-pon Exp $
//

if (isset($_GET['func']))
{
	require '../../../mainfile.php';
	require XOOPS_ROOT_PATH . "/include/cp_functions.php";
	$moduleperm_handler = & xoops_gethandler( 'groupperm' );
	if ( $xoopsUser ) {
		$url_arr = explode('/',strstr($xoopsRequestUri,'/modules/'));
		$module_handler =& xoops_gethandler('module');
		$xoopsModule =& $module_handler->getByDirname($url_arr[2]);
		unset($url_arr);
		
		if ( !$moduleperm_handler->checkRight( 'module_admin', $xoopsModule->getVar( 'mid' ), $xoopsUser->getGroups() ) ) {
			exit();
		} 
	} else {
		exit();
	}
	xpw_check_db();	
}
else
{
	$_GET['func'] = "";
	require_once('../../../include/cp_header.php');

	xoops_cp_header();
	include('./mymenu.php');
	echo "<h4>Admin menu of XP-Weather module.</h4>";
	//echo "<p><a href='./set_suggest.php?mode=set'>"._AM_SET_SUGGEST."</a></p>";

	xpw_check_db();

	xoops_cp_footer();
}

function xpw_check_db()
{
	global $xoopsDB;
	
	//古いDBテーブルの確認->存在するなら削除
	$tables = array("city","country","region","subdiv","wmo_stations","xpweather_city_jp");
	foreach ($tables as $table)
	{
		$table = $xoopsDB->prefix($table);
		$sql = "SHOW TABLE STATUS LIKE '{$table}'";
		$result = $xoopsDB->queryF($sql);
		if (mysql_fetch_row($result))
		{
			$sql = "DROP TABLE `{$table}`";
			$xoopsDB->queryF($sql);
			echo "Deleted a table '{$table}'<br />";
		}		
	}
	
	//古いDBテーブルのリネーム
	$table = $xoopsDB->prefix("userweather");
	$sql = "SHOW TABLE STATUS LIKE '{$table}'";
	$result = $xoopsDB->queryF($sql);
	if (mysql_fetch_row($result))
	{
		$sql = "ALTER TABLE `".$table."` DROP `accid`, DROP `station_type`, DROP `station_name`";
		$xoopsDB->queryF($sql);
		echo "Droped fields 'accid', 'station_type' & 'station_name' from {$table}.<br />";
		$sql = "ALTER TABLE `".$table."` RENAME `".$xoopsDB->prefix("xpweather_userloc")."`";
		$xoopsDB->queryF($sql);
		echo "Renamed a table '{$table}' to '".$xoopsDB->prefix("xpweather_userloc")."'.<br />";
	}
	
	// xpweather_station が存在して内容が空ならインポートする
	$table = $xoopsDB->prefix("xpweather_station");
	$sql = "SHOW TABLE STATUS LIKE '{$table}'";
	$result = $xoopsDB->queryF($sql);
	if (mysql_fetch_row($result))
	{
		// LOAD DATA LOCAL が使えない場合のプロセス
		if ($_GET['func'] == "ins_station")
		{
			// 出力をバッファリングしない
			@ini_set('mbstring.encoding_translation','0');
			ob_end_clean();
			echo str_pad('',256);//for IE
			ob_implicit_flush(true);
			
			echo "<html><body>Now insrting station data. Please wait.<br />";
						
			xpw_sql_do("station.sql",3000);
			
			echo "<hr />Inport process finished.</body></html>";
		}
		else if ($_GET['func'] == "showlink_station")
		{
			echo "<html><body>" .
					"<a href=\"?func=ins_station\" onClick=\"this.style.visibility='hidden';document.getElementById('prc_msg').style.visibility='visible';return true;\">" .
					"Click to insert data in `xpweather_sration`. Please wait.</a><br />" .
					"<span id=\"prc_msg\" style=\"visibility:hidden;\">Now insrting station data. Please wait.</span>" .
					"</body></html>";
		}
		else
		{
			$sql = "SELECT * FROM `{$table}`";
			$result = $xoopsDB->query($sql);
			if (!mysql_fetch_row($result))
			{
				inport_xpweather_station();
			}
		}
	}	
	
	//新しいDBテーブルの確認->存在しないなら作成
	$table = $xoopsDB->prefix("xpweather_country");
	$sql = "SHOW TABLE STATUS LIKE '{$table}'";
	$result = $xoopsDB->queryF($sql);
	if (!mysql_fetch_row($result))
	{
		if ($_GET['func'] == "docreate")
		{
			// 出力をバッファリングしない
			@ini_set('mbstring.encoding_translation','0');
			ob_end_clean();
			echo str_pad('',256);//for IE
			ob_implicit_flush(true);
			
			echo "<html><body>Now creating new DB tables. Please wait.<br />";
						
			xpw_sql_do("mysql.sql");
			
			inport_xpweather_station();
			
			echo "<hr />All processes finished.</body></html>";
		}
		else if ($_GET['func'] == "showlink")
		{
			echo "<html><body>" .
					"<a href=\"?func=docreate\" onClick=\"this.style.visibility='hidden';document.getElementById('prc_msg').style.visibility='visible';return true;\">" .
					"Click to insert data in `xpweather_sration`. Please wait.</a><br />" .
					"<span id=\"prc_msg\" style=\"visibility:hidden;\">Now creating new DB tables. Please wait.</span>" .
					"</body></html>";		}
		else
		{
			echo "<iframe src=\"?func=showlink\"></iframe>";	
		}
	}
}

function inport_xpweather_station()
{
	global $xoopsDB;

	echo "Inporting to 'xpweather_station' ... ";
	
	$table = $xoopsDB->prefix("xpweather_station");
	$sql = "LOAD DATA LOCAL INFILE '".XOOPS_ROOT_PATH."/modules/XP-Weather/sql/stations.txt' INTO TABLE `{$table}` FIELDS TERMINATED BY ',' ENCLOSED BY '\"' LINES TERMINATED BY '\n'";
	$result = $xoopsDB->queryF($sql);
	if ($result)
	{
		echo "OK.";
	}
	else
	{
		echo "<br /><iframe src=\"?func=showlink_station\"></iframe>";
	}
}

function xpw_sql_do ($file,$signinterval = 1)
{
	error_reporting(E_ALL);
	
	global $xoopsDB;
	
	$file = XOOPS_ROOT_PATH."/modules/XP-Weather/sql/".$file;
	if (!file_exists($file)) {echo $file;return;}

	$sql = file($file);
	$sql = str_replace(array("CREATE TABLE `","INSERT INTO `"),array("CREATE TABLE `".XOOPS_DB_PREFIX."_","INSERT INTO `".XOOPS_DB_PREFIX."_"),$sql);
	
	$_sql = "";
	foreach($sql as $line)
	{
		$line = trim($line);
		if (strpos($line,"--") !== FALSE)
		{
			continue;
		}
		$_sql .= $line;
	}
	
	$i = 1;
	foreach(explode(";",$_sql) as $sql)
	{
		if ($sql)
		{
			$result = $xoopsDB->queryF($sql);
			if (++$i > $signinterval && ($i % $signinterval) === 0)
			{
				echo "*";
			}
		}
	}
	
	echo "<br />";
}
?>