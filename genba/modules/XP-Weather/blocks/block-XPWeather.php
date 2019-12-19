<?php
/***********************************************************************************/
/*                                                                                 */
/* XP-Weather version 1.3                                                          */
/* 8/4/2002 - davidd                                                               */
/* - added unlimited to visibility                                                 */
/* - added new unavailable status                                                  */
/* XP-Weather version 1.1                                                          */
/* XP-Weather version 1.0                                                          */
/* XP-Weather version 0.99                                                         */
/*         Modified again by davidd (dk@axarosenberg.com)                          */
/*         http://www.axarosenberg.com                                             */
/*																				   */
/* 6/18/2002 - davidd															   */
/*				- Includes cleanup                                                 */
/*				- Added adjustable caching to this module						   */
/*																				   */
/* 6/13/2002 -                                                                     */
/*				- added conText weather condition text	 						   */
/*				- re-worked table output										   */
/*				- moved embeded French out to language/main.php file			   */
/*                                                                                 */
/***********************************************************************************/
/*                                                                                 */
/* XP-Weather version 0.71b                                                        */
/*         Converted by Bidou (bidou@lespace.org                                   */
/*         http://www.lespace.org                                                  */
/*                                                                                 */
/***********************************************************************************/
/*                                                                                 */
/* Based on MyWeather version 1.0                                                  */
/*         PHP and mySQL Code changes by Richard Benfield aka PcProphet            */
/*         http://www.pc-prophet.com                                               */
/*         http://www.benfield.ws                                                  */
/*                                                                                 */
/*         Html and Graphic work by Chris Myden                                    */
/*         http://www.chrismyden.com/                                              */
/*                                                                                 */
/* MyWeather version 1.0 based on World_Weather version 1.1                        */
/*         By NukeTest.com team                                                    */
/*         http://www.nuketest.com                                                 */
/*                                                                                 */
/***********************************************************************************/
/*                                                                                 */
/* Previously part of PHP-NUKE Add-On 5.0 : Weather AddOn                          */
/* ======================================================                          */
/* Brought to you by PHPNuke Add-On Team                                           */
/* Copyright (c) 2001 by Richard Tirtadji AKA King Richard (rtirtadji@hotmail.com) */
/* http://www.nukeaddon.com                                                        */
/*                                                                                 */
/***********************************************************************************/
/*                                                                                 */
/* Original code based on METEO live v1.0                                          */
/* By Martin Bolduc at martin.bolduc@littera.com                                   */
/* License : Free, do what you want, but please, let my name in reference.         */
/*                                                                                 */
/***********************************************************************************/

// Include the appropriate language file.
global $xoopsConfig; // for XOOPS Cube
if(file_exists(XOOPS_ROOT_PATH.'/modules/XP-Weather/language/'.$xoopsConfig['language'].'/main.php')){
	include_once(XOOPS_ROOT_PATH.'/modules/XP-Weather/language/'.$xoopsConfig['language'].'/main.php');
}else{
	include_once(XOOPS_ROOT_PATH.'/modules/XP-Weather/language/english/main.php');
}

include_once(XOOPS_ROOT_PATH."/modules/XP-Weather/include/config.php");
include_once(XOOPS_ROOT_PATH."/modules/XP-Weather/include/weather.class.php");

function disp_block_XPWeather($options) {
	global $xoopsUser, $xoopsConfig, $xoopsDB;

	$block = array();
	$block['title'] = _MD_XPW_BLOCKTITLE;

	if ( $xoopsUser )
	{
	    $userid = $xoopsUser->uid();
		list($wcid, $tpc, $tps) = mysql_fetch_row(mysql_query("select wcid, tpc, tps from ".$xoopsDB->prefix("xpweather_userloc")." where userid='$userid'"));
	}
	else if (!empty($_COOKIE["XPW_LOC"]))
	{
		list($wcid, $tpc, $tps) = explode("|",$_COOKIE['XPW_LOC']);
		$mywd = new WeatherData();
		$mywd->setcookie($wcid, $tpc, $tps);
		unset($mywd);
	}
	if (empty($wcid))
	{
		list($wcid, $tpc, $tps) = mysql_fetch_row(mysql_query("select wcid, tpc, tps from ".$xoopsDB->prefix("xpweather_userloc")." where userid='0'"));
	}
	
	$l_PAR = "http://www.weather.com/?prod=xoap&amp;par=".XOOPS_MD_XPWEATHER_PAR;
	$html = "<div class=\"xpweather_block\">".get_block_XPWeather($wcid, $tpc, $tps, $options[0])."</div>";
	$html .= "<div style=\"text-align:right;\"><small>Featured on <a href=\"{$l_PAR}\" target=\"_blank\">weather.com</a></small></div>";

	$block['content'] = $html;
	
	return $block;
}

function multi_block_XPWeather($options)
{
	global $xoopsUser, $xoopsConfig, $xoopsDB;

	$block = array();
	$block['title'] = "";

	//list($wcid, $tpc, $tps) = mysql_fetch_row(mysql_query("select wcid, tpc, tps from ".$xoopsDB->prefix("xpweather_userloc")." where userid='0'"));
	if ( $xoopsUser )
	{
	    $userid = $xoopsUser->uid();
		list($wcid, $tpc, $tps) = mysql_fetch_row(mysql_query("select wcid, tpc, tps from ".$xoopsDB->prefix("xpweather_userloc")." where userid='$userid'"));
	}
	else if (!empty($_COOKIE["XPW_LOC"]))
	{
		list($wcid, $tpc, $tps) = explode("|",$_COOKIE['XPW_LOC']);
		$mywd = new WeatherData();
		$mywd->setcookie($wcid, $tpc, $tps);
		unset($mywd);
	}
	if (empty($wcid))
	{
		list($wcid, $tpc, $tps) = mysql_fetch_row(mysql_query("select wcid, tpc, tps from ".$xoopsDB->prefix("xpweather_userloc")." where userid='0'"));
	}

	$stations = explode(",",$options[0]);
	$width = (int)$options[1];
	
	$html = "<div class=\"xpweather_block\" style=\"width:auto;margin-left:auto;margin-right:auto;\">";
	$i = 0;
	$options[2] = max((int)$options[2],1);
	
	foreach ($stations as $wcid)
	{
		$clear = 0;
		$html .= "<div style=\"float:left;width:{$width}px;border:1px gray solid;margin:3px;\">";
		$html .= get_block_XPWeather($wcid, $tpc, $tps, $options[3]);
		$html .= "</div>";
		if (++$i % $options[2] == 0)
		{
			$html .= "<div style=\"clear:left;\"></div>";	
			$clear = 1;
		}
	}
	if (!$clear) {$html .= "<div style=\"clear:left;\"></div>";}
	$l_PAR = "http://www.weather.com/?prod=xoap&amp;par=".XOOPS_MD_XPWEATHER_PAR;
	$html .= "<div style=\"text-align:right;\"><small>Featured on <a href=\"{$l_PAR}\" target=\"_blank\">weather.com</a></small></div>";
	$html .= "</div>";
	
	$block['content'] = $html;
	return $block;
}

function block_XPWeather_edit($options)
{
	$form = "";
	$form .= "<br />Template:&nbsp;<input type='text' name='options[]' value='".$options[0]."' />";	

	return $form;
}


function multi_block_XPWeather_edit($options)
{
	$form = "";
	$form .= "Location code:&nbsp;<input type='text' size='60' name='options[]' value='".$options[0]."' />";
	$form .= "<br />(Separate by comma[,])";
	$form .= "<br />A block Width:&nbsp;<input type='text' name='options[]' value='".$options[1]."' />&nbsp;px";
	$form .= "<br />Max Cols:&nbsp;<input type='text' name='options[]' value='".$options[2]."' />";	
	$form .= "<br />Template:&nbsp;<input type='text' name='options[]' value='".$options[3]."' />";	

	return $form;
}

function get_block_XPWeather($wcid, $tpc, $tps, $template="default")
{
	global $xoopsConfig;

	$wcid = trim($wcid);
	$template = trim($template);
	$tpc = (empty($tpc))? "0" : "1";
	$tps = (empty($tps))? "0" : "1";
	
	$mywd = new WeatherData;
	$language = $xoopsConfig['language'];
	$content = "";
	
	if (!$template) {$template = "default";}
	$cache_file = "".XOOPS_ROOT_PATH."/modules/XP-Weather/cache/block_{$language}_{$tpc}{$tps}_{$template}.{$wcid}";
	if ( !file_exists($cache_file) || filemtime($cache_file) + $GLOBALS['XPWEATHER_CONFIG']['cache_time'] < time() ) {
		$loc = $wcid;

		if ( !empty($GLOBALS['XPWEATHER_CONFIG']['proxy_host']) ) {
			$mywd->proxyHost = $GLOBALS['XPWEATHER_CONFIG']['proxy_host'];
			if ( !empty($GLOBALS['XPWEATHER_CONFIG']['proxy_port']) ) { $mywd->proxyPort = $GLOBALS['XPWEATHER_CONFIG']['proxy_port']; }
			if ( !empty($GLOBALS['XPWEATHER_CONFIG']['proxy_user']) ) { $mywd->User = $GLOBALS['XPWEATHER_CONFIG']['proxy_user']; }
			if ( !empty($GLOBALS['XPWEATHER_CONFIG']['proxy_pwd']) ) { $mywd->Pass = $GLOBALS['XPWEATHER_CONFIG']['proxy_pwd']; }
		}

		$mywd->fetchData($loc);
		if ( IsSet($mywd->feedError) && !empty($mywd->feedError) ) {
			$failuremessage = _MD_XPW_UNAVAIL.": $mywd->feedResponse ($mywd->feedError)\n";
		} else {
			$mywd->processData();
			$v_City    = $mywd->v_City;
			$v_SubDiv  = $mywd->v_SubDiv;
			$v_Country = $mywd->v_Country;
			$v_Region  = $mywd->v_Region;
			$v_Temp    = $mywd->v_Temp;
			$v_CIcon   = $mywd->getIcon($mywd->v_CIcon);
			$v_WindS   = $mywd->v_WindS;
			$v_WindD   = $mywd->v_WindD;
			$v_Baro    = $mywd->v_Baro;
			$v_Humid   = $mywd->v_Humid;
			$v_Real    = $mywd->v_Real;
			$v_UV      = $mywd->v_UV;
			$v_Vis     = $mywd->v_Vis;
			$v_LastUp  = $mywd->v_LastUp;
			$v_ConText = $mywd->v_ConText;
			$v_Fore    = explode("|", $mywd->v_Fore);
			$v_Acid    = $mywd->v_Acid;
			$v_LastUpL = $mywd->v_LastUpL;
			
			if ($v_Temp == "" and $v_CIcon == "") {
				$failuremessage = "<center><a href=\"".XOOPS_URL."/modules/XP-Weather/change.php\">";
				$failuremessage .= "<small>"._MD_XPW_CHNGSET."</small></A></center><br />\n";
				if ( $v_City != "" ) {
					$failuremessage .= "<center><b>$v_City</b></center>\n<center>"._MD_XPW_UNAVAIL."</center>\n";
				} else {
					$failuremessage .= "<center><b>$v_City</b></center>\n<center>"._MD_XPW_UNAVAIL."</center> \n<center>"._MD_XPW_NODATA."</center>\n";
				}
			} else {
				if ($v_Temp == "" || $v_Temp == "0") {
					$v_Temp = $mywd->ConvTemp($v_Fore[20],$tpc);
					$v_CIcon = $mywd->getIcon($v_Fore[10]);
					$v_WindS = "n/a";
					$v_WindD = "n/a";
					$v_Baro = "n/a";
					$v_Humid = "n/a";
					$v_Real = $v_Temp;
					$v_UV = "n/a";
					$v_Vis = "n/a";
				}
				$fpwrite = fopen($cache_file, 'w');
				if(!$fpwrite) {
					$failuremessage = _MD_XPW_WRITEFAIL." ".$cache_file;
				} else {
					// ?????????
					$l_loc = XOOPS_URL."/modules/XP-Weather/?loc={$v_Acid}";
					$l_change = XOOPS_URL."/modules/XP-Weather/change.php";
					$l_icon = XOOPS_URL."/modules/XP-Weather/images/{$GLOBALS['XPWEATHER_CONFIG']['bgifdir']}/".$v_CIcon;
					$t_WDETAILED = _MD_XPW_WDETAILED;
					$t_CHNGSET = _MD_XPW_CHNGSET;
					$t_CURCOND = _MD_XPW_CURCOND;
					$t_WIND = _MD_XPW_WIND;
					$t_REFE = _MD_XPW_REFE;
					$t_LASTUP = _MD_XPW_LASTUP;
					
					$v_Temp = $mywd->ConvTemp($v_Temp, $tpc);
					$v_WindS = $mywd->ConvSpeed($v_WindS, $tps);
					$v_Real = $mywd->ConvReal($v_Real, $tpc);
					if ( $v_Vis == "" ) {
						$v_Vis = _UNLIMITED;
					}
					if ($v_LastUpL)
					{
						$v_LastUpL = htmlspecialchars(_MD_XPW_LOCAL.": ".$v_LastUpL);
					}
					
					// ??????????
					$f_temp = XOOPS_ROOT_PATH."/modules/XP-Weather/blocks/template/{$template}.html";
					if (!file_exists($f_temp))
					{
						$f_temp = XOOPS_ROOT_PATH."/modules/XP-Weather/blocks/template/default.html";
					}
					$temp_html = join('',file($f_temp));
					$temp_html = preg_replace('/{(\$[^}]+)}/e',"$1",$temp_html);
					
					$content .= $temp_html;
					
					fputs($fpwrite, $content);
				}
				fclose($fpwrite);
			}
		}
	} else {
		if (file_exists($cache_file)) {
			$wfread	= fopen($cache_file, 'r');
			if(!$wfread) {
				$failuremessage = _MD_XPW_READFAIL ." ". $cache_file;
			} else {
				$content .= fread($wfread,filesize($cache_file));
				fclose($wfread);
			}
		}
	}
	if (isset($failuremessage)) {
		$content = $failuremessage;
	}
	return $content;
}
?>