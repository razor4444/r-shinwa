<?php
/***********************************************************************************/
/*                                                                                 */
/* XP-Weather version 1.3a(J2)                                                     */
/*         Edited by nao-pon (nao-pon@hypweb.net)                                  */
/*         http://hypweb.net/                                                      */
/* - Created Japanese Station database                                             */
/* - The addition and change of a script by having created the database.           */
/* - The Japanese display of the name of a place.                                  */
/*                                                                                 */
/* XP-Weather version 1.3a(J)                                                      */
/*         Edited by nao-pon (nao-pon@hypweb.net)                                  */
/*         http://hypweb.net/                                                      */
/* - added Japanese languege pack                                                  */
/* - and edited                                                                    */
/*    Japanese-izing of a wind direction.                                          */
/*    Wind velocity is changed into m/s from km/h.                                 */
/*    Updating time is changed at Japan Standard Time                              */
/*     (summer time consideration has not been carried out).                       */
/*                                                                                 */
/***********************************************************************************/
/*                                                                                 */
/* XP-Weather version 1.3                                                          */
/*                                                                                 */
/* 8/4/2002 - davidd                                                               */
/* - moved weather data collection to Weather class for supporting new feeds       */
/* - added proxy server support using snoopy class                                 */
/* - added unlimited value to visibility                                           */
/* - fixed flushcache test                                                         */
/* - removed hard-coded font tags for better display with dark themes              */
/* - added new unavailable messages when data is not available                     */
/*                                                                                 */
/* XP-Weather version 1.2                                                          */
/*                                                                                 */
/* 7/31/2002 - davidd                                                              */
/* msnbc.com changed weather sources from Accuweather to weather.com               */
/* - fixed forcast parsing offsets were changed                                    */
/* - added humidity and precipitation to detailed forecast                         */
/*                                                                                 */
/*                                                                                 */
/* XP-Weather version 1.1                                                          */
/* XP-Weather version 1.0                                                          */
/* XP-Weather version 0.98d                                                        */
/*         Modified again by davidd (dk@axarosenberg.com)                          */
/*         http://www.axarosenberg.com                                             */
/*                                                                                 */
/* 6/18/2002 - davidd                                                              */
/* - Added adjustable persistent cache to block and main module                    */
/* - Code Cleanup                                                                  */
/*                                                                                 */
/* 6/13/2002 - davidd                                                              */
/* - added conText weather condition text                                          */
/* - re-worked table output                                                        */
/* - added radar and percipitation map links                                       */
/* - fixed header and footer includes for template main/cblock                     */
/* - moved embeded French out to language/main.php file                            */
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

include_once("header.php");
$func = (isset($_GET['func']))? $_GET['func'] : "" ;
$flushcache = (isset($_GET['flushcache']))? (int)$_GET['flushcache'] : 0 ;
$func = (isset($_GET['loc']))? $_GET['loc'] : $func ;
$index = 0;

include(XOOPS_ROOT_PATH."/header.php");

echo "<link rel=\"stylesheet\" href=\"./style.css\" type=\"text/css\" media=\"screen\" charset=\"shift_jis\">\n";
echo "<div id=\"xp_weather_body\" class=\"xp_weather_body\">\n";
switch($func) {

	case "usedefault":
		WeatherIndex(1, $flushcache);
		break;
	case "":
		WeatherIndex(0, $flushcache);
		break;
	default:
		if (!preg_match("/^[A-Z]{4}\d{4}$/i",$func)) {$func = 0;} 
		WeatherIndex($func, $flushcache);
		break;
}
if (isset($_GET['loc']))
{
	echo "<script type=\"text/javascript\">window.location.hash = 'xp_weather_body';</script>";
}
echo "</div>\n";

include_once(XOOPS_ROOT_PATH."/footer.php");


function WeatherIndex($usedefault=0, $flushcache=0) {
	global $xoopsConfig, $xoopsModule, $xoopsUser, $xoopsDB, $xp_weather_var;
	global $proxy_host, $proxy_port, $proxy_user, $proxy_pwd;

	$language = $xoopsConfig['language'];
	$outbuf = "";
	$mywd = new WeatherData;
	
	if ( $xoopsUser )
	{
	    $userid = $xoopsUser->uid();
		list($wcid, $tpc, $tps) = mysql_fetch_row(mysql_query("select wcid, tpc, tps from ".$xoopsDB->prefix("xpweather_userloc")." where userid='$userid'"));
	}
	else if (!empty($_COOKIE["XPW_LOC"]))
	{
		list($wcid, $tpc, $tps) = explode("|",$_COOKIE['XPW_LOC']);
		$mywd->setcookie($wcid, $tpc, $tps);
	}
	if ($usedefault === 0 || empty($wcid))
	{
		list($wcid, $tpc, $tps) = mysql_fetch_row(mysql_query("select wcid, tpc, tps from ".$xoopsDB->prefix("xpweather_userloc")." where userid='0'"));
	}

	$tpc = (empty($tpc))? "0" : "1";
	$tps = (empty($tps))? "0" : "1";
	
	// loc が URLにて指定されている？
	if ($usedefault !== 0 && $usedefault !== 1)
	{
		$accid = $wcid = $usedefault;
	}
	
	if ( !IsSet($wcid) ) {
		if ( $xoopsUser->isAdmin() ) {
			echo "<br />"._MD_XPW_UNAVAIL.""._MD_XPW_RAISON."<br /><br />\n";
			echo ""._MD_XPW_INSTALL." <a href=\"install.php\">"._MD_XPW_ICI."</a>.";
		} else {
			echo "<br />"._MD_XPW_UNAVAIL._MD_XPW_ERRORTRYAGAIN;
		}
	} else {
		$cache_file = "".XOOPS_ROOT_PATH."/modules/".$xoopsModule->dirname()."/cache/main_{$language}_{$tpc}{$tps}.{$wcid}";
		
		if ( $flushcache == 1 ) {
			$mywd->unlink_cache($wcid);
		}
		if ( !file_exists($cache_file) || filemtime($cache_file) + $GLOBALS['XPWEATHER_CONFIG']['cache_time'] < time() )
		{
			$saved_stationid = $wcid;

			if ( !empty($GLOBALS['XPWEATHER_CONFIG']['proxy_host']) ) {
				$mywd->proxyHost = $GLOBALS['XPWEATHER_CONFIG']['proxy_host'];
				if ( !empty($GLOBALS['XPWEATHER_CONFIG']['proxy_port']) ) { $mywd->proxyPort = $GLOBALS['XPWEATHER_CONFIG']['proxy_port']; }
				if ( !empty($GLOBALS['XPWEATHER_CONFIG']['proxy_user']) ) { $mywd->User = $GLOBALS['XPWEATHER_CONFIG']['proxy_user']; }
				if ( !empty($GLOBALS['XPWEATHER_CONFIG']['proxy_pwd']) ) { $mywd->Pass = $GLOBALS['XPWEATHER_CONFIG']['proxy_pwd']; }
			}
			$mywd->fetchData($saved_stationid);
			if ( IsSet($mywd->feedError) && !empty($mywd->feedError) ) {
				$failuremessage = "<h4><b>{$GLOBALS['XPWEATHER_CONFIG']['module_name']}</b></h4>\n"._MD_XPW_UNAVAIL.": $mywd->feedResponse ($mywd->feedError)\n";
			} else {
				$mywd->processData();
				$v_City    = $mywd->v_City;
				$v_SubDiv  = $mywd->v_SubDiv;
				$v_Country = $mywd->v_Country;
				$v_Temp    = $mywd->v_Temp;
				$v_CIcon   = $mywd->getIcon($mywd->v_CIcon);
				$v_WindS   = $mywd->v_WindS;
				$v_WindD   = $mywd->v_WindD;
				$v_Baro    = $mywd->v_Baro;
				$v_Humid   = $mywd->v_Humid;
				$v_Real    = $mywd->v_Real;
				$v_UV      = (int)$mywd->v_UV;
				$v_Vis     = $mywd->v_Vis;
				$v_LastUp  = $mywd->v_LastUp;
				$v_ConText = $mywd->v_ConText;
				$v_Acid    = $mywd->v_Acid;
				$v_LocalTM = $mywd->v_LocalTM;
				$v_LastUpL = $mywd->v_LastUpL;
				
				$loc_data = $mywd->get_loc_data($v_Acid);
				$v_Region  = $loc_data['region']['name'];
				
				$mywd->fetchData($saved_stationid, "dayf");
				$mywd->processData("dayf");
				$v_Fore    = $mywd->v_Fore;
				$v_Today   = $mywd->v_Today;
				
				// prmo links
				$mywd->fetchData($saved_stationid, "link");
				$mywd->processData("link");
				$v_links = "";
				foreach($mywd->v_links as $_link)
				{
					$v_links .= "<a href=\"{$_link['l']}&amp;par=".XOOPS_MD_XPWEATHER_PAR."\" target=\"_blank\">{$_link['t']}</a><br />";	
				}
				
				if ($v_City != "" and ($v_Temp == "" and $v_CIcon == "")) {
					$failuremessage = "<h4><b>{$GLOBALS['XPWEATHER_CONFIG']['module_name']}</b></h4>\n"._MD_XPW_UNAVAIL.": $str_error ($num_error)\n";
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
					$fpwrite = fopen($cache_file, 'wb');
					if(!$fpwrite) {
						$failuremessage = _MD_XPW_WRITEFAIL ." ".$cache_file;
					} else {
						if ( $v_Vis == "" ) {
							$v_Vis = _MD_XPW_UNLIMITED;
						}
						if ($v_LastUpL)
						{
							$v_LastUpL = " ( "._MD_XPW_LOCAL.": ".$v_LastUpL." )";
						}
						$outbuf .= "<h4><b>{$GLOBALS['XPWEATHER_CONFIG']['module_name']} "._MD_XPW_WDETAILED."</b></h4>\n"
						._MD_XPW_REG.": $v_Region<br />\n"
						."<b>".$mywd->getLocation2($v_City)."</b> "
						."[<a href=\"change.php\"><small>"._MD_XPW_CHNGSET."</small></a>]\n"
						._MD_XPW_LASTUP. " " .$v_LastUp.$v_LastUpL."<br />"
						."<a href=\"http://www.weather.com/outlook/travel/local/".$saved_stationid."\" target=\"_blank\">More Detail....</a>"
						."&nbsp;[ <a href=\"http://maps.google.com/?q=".rawurlencode("loc: ".$mywd->getLocation2($v_City,"simple"))."&amp;ie="._CHARSET."&amp;z=11&amp;ll=".$mywd->v_LatLon."&amp;t=h\" target=\"_blank\">Google Map</a> ]"
						."<hr><table cellpadding=\"4\" cellspacing=\"0\" border=\"0\" style=\"width:auto;\"><tr><td style=\"vertical-align:top;\">\n"
						."<img src=\"images/{$GLOBALS['XPWEATHER_CONFIG']['gifdir']}/current_cond.gif\" align=\"top\" alt=\""._MD_XPW_CURCOND."\">\n"
						."<font face=\"Arial\" style=\"color:red;font-size:24px;\">".$mywd->ConvTemp($v_Temp, $tpc)."</font> \n"
						."<img src=\"images/{$GLOBALS['XPWEATHER_CONFIG']['gifdir']}/".$v_CIcon."\" class=\"xp_forecast\">\n"
						."</td><td><table cellpadding=\"4\" cellspacing=\"5\" border=\"0\"><tr><td>\n"
						._MD_XPW_WIND.": ".$v_WindD." ".$mywd->ConvSpeed($v_WindS,$tps)."</td><td>\n"
						._MD_XPW_BARO.": ".$mywd->ConvPress($v_Baro,$tps)." </td><td>\n"
						._MD_XPW_HUMID.": ".$v_Humid."%</td></tr><tr><td>".$v_ConText."</td><td>\n"
						._MD_XPW_BARO_PRES.": ".$mywd->ConvPress($v_Baro,2)." (".$mywd->v_BaroD.")</td></tr><tr><td>\n"
						._MD_XPW_UV.": ".$v_UV." (".$mywd->v_UVT.")</td><td>\n"
						._MD_XPW_REFE.": ".$mywd->ConvTemp($v_Real,$tpc)."</td><td>\n"
						._MD_XPW_VIS.": ".$mywd->ConvLength($v_Vis,$tps)."</td></tr>\n"
						."</table></td></tr></table><br /><table cellpadding=\"4\" cellspacing=\"0\" border=\"0\" style=\"width:auto;\">\n"
						."<tr><td valign=\"top\" class=\"xp_forecast\">"
						."<img src=\"images/{$GLOBALS['XPWEATHER_CONFIG']['gifdir']}/forecast.gif\" alt=\""._MD_XPW_FOREC."\">"
						."</td><td>&nbsp;</td><td class=\"xp_forecast\">\n"
						.$v_Today."<br />{$v_Fore[0]['date']}<br /><img src=\"images/{$GLOBALS['XPWEATHER_CONFIG']['gifdir']}/".$mywd->getIcon($v_Fore[0]['icon'])."\"><br /><small>{$v_Fore[0]['t']}</small></td><td class=\"xp_forecast\">\n"
						.$mywd->Fore($v_Fore[1]['dw'])."<br />{$v_Fore[1]['date']}<br /><img src=\"images/{$GLOBALS['XPWEATHER_CONFIG']['gifdir']}/".$mywd->getIcon($v_Fore[1]['icon'])."\"><br /><small>{$v_Fore[1]['t']}</small></td><td class=\"xp_forecast\">\n"
						.$mywd->Fore($v_Fore[2]['dw'])."<br />{$v_Fore[2]['date']}<br /><img src=\"images/{$GLOBALS['XPWEATHER_CONFIG']['gifdir']}/".$mywd->getIcon($v_Fore[2]['icon'])."\"><br /><small>{$v_Fore[2]['t']}</small></td><td class=\"xp_forecast\">\n"
						.$mywd->Fore($v_Fore[3]['dw'])."<br />{$v_Fore[3]['date']}<br /><img src=\"images/{$GLOBALS['XPWEATHER_CONFIG']['gifdir']}/".$mywd->getIcon($v_Fore[3]['icon'])."\"><br /><small>{$v_Fore[3]['t']}</small></td><td class=\"xp_forecast\">\n"
						.$mywd->Fore($v_Fore[4]['dw'])."<br />{$v_Fore[4]['date']}<br /><img src=\"images/{$GLOBALS['XPWEATHER_CONFIG']['gifdir']}/".$mywd->getIcon($v_Fore[4]['icon'])."\"><br /><small>{$v_Fore[4]['t']}</small></td><td class=\"xp_forecast\">\n"
						.$mywd->Fore($v_Fore[5]['dw'])."<br />{$v_Fore[5]['date']}<br /><img src=\"images/{$GLOBALS['XPWEATHER_CONFIG']['gifdir']}/".$mywd->getIcon($v_Fore[5]['icon'])."\"><br /><small>{$v_Fore[5]['t']}</small></td></tr>\n"
						."<tr><td>&nbsp;</td><td colspan=\"7\"><hr></td></tr>\n"
						."<tr><td>&nbsp;</td><td><font face=\"Arial\" color=\"red\" size=\"\">"._MD_XPW_WHIGH.":</font></td><td class=\"xp_forecast\">\n"
						."<font face=\"Arial\" color=\"red\">".$mywd->ConvTemp($v_Fore[0]['hi'],$tpc)."</font></td><td class=\"xp_forecast\">\n"
						."<font face=\"Arial\" color=\"red\">".$mywd->ConvTemp($v_Fore[1]['hi'],$tpc)."</font></td><td class=\"xp_forecast\">\n"
						."<font face=\"Arial\" color=\"red\">".$mywd->ConvTemp($v_Fore[2]['hi'],$tpc)."</font></td><td class=\"xp_forecast\">\n"
						."<font face=\"Arial\" color=\"red\">".$mywd->ConvTemp($v_Fore[3]['hi'],$tpc)."</font></td><td class=\"xp_forecast\">\n"
						."<font face=\"Arial\" color=\"red\">".$mywd->ConvTemp($v_Fore[4]['hi'],$tpc)."</font></td><td class=\"xp_forecast\">\n"
						."<font face=\"Arial\" color=\"red\">".$mywd->ConvTemp($v_Fore[5]['hi'],$tpc)."</font></td></tr>\n"
						."<tr><td>&nbsp;</td><td colspan=\"7\"><hr></td></tr>\n"
						."<tr><td>&nbsp;</td><td>"._MD_XPW_WLOW.":</td><td class=\"xp_forecast\">\n"
						."<font face=\"Arial\">".$mywd->ConvTemp($v_Fore[0]['low'],$tpc)."</td><td class=\"xp_forecast\">\n"
						."<font face=\"Arial\">".$mywd->ConvTemp($v_Fore[1]['low'],$tpc)."</td><td class=\"xp_forecast\">\n"
						."<font face=\"Arial\">".$mywd->ConvTemp($v_Fore[2]['low'],$tpc)."</td><td class=\"xp_forecast\">\n"
						."<font face=\"Arial\">".$mywd->ConvTemp($v_Fore[3]['low'],$tpc)."</td><td class=\"xp_forecast\">\n"
						."<font face=\"Arial\">".$mywd->ConvTemp($v_Fore[4]['low'],$tpc)."</td><td class=\"xp_forecast\">\n"
						."<font face=\"Arial\">".$mywd->ConvTemp($v_Fore[5]['low'],$tpc)."</td</tr>\n"

						."<tr><td>&nbsp;</td><td colspan=\"7\"><hr></td></tr>\n"
						."<tr><td>&nbsp;</td><td>"._MD_XPW_PRECIP.":</td><td class=\"xp_forecast\">\n"
						."{$v_Fore[0]['ppcp']}%</td><td class=\"xp_forecast\">\n"
						."{$v_Fore[1]['ppcp']}%</td><td class=\"xp_forecast\">\n"
						."{$v_Fore[2]['ppcp']}%</td><td class=\"xp_forecast\">\n"
						."{$v_Fore[3]['ppcp']}%</td><td class=\"xp_forecast\">\n"
						."{$v_Fore[4]['ppcp']}%</td><td class=\"xp_forecast\">\n"
						."{$v_Fore[5]['ppcp']}%</td></tr>\n"

						."<tr><td>&nbsp;</td><td colspan=\"7\"><hr></td></tr>\n"
						."<tr><td>&nbsp;</td><td>"._MD_XPW_WIND.":</td><td class=\"xp_forecast\">\n"
						."{$v_Fore[0]['wind']['t']}<br />".$mywd->ConvSpeed($v_Fore[0]['wind']['s'],$tps)."</td><td class=\"xp_forecast\">\n"
						."{$v_Fore[1]['wind']['t']}<br />".$mywd->ConvSpeed($v_Fore[1]['wind']['s'],$tps)."</td><td class=\"xp_forecast\">\n"
						."{$v_Fore[2]['wind']['t']}<br />".$mywd->ConvSpeed($v_Fore[2]['wind']['s'],$tps)."</td><td class=\"xp_forecast\">\n"
						."{$v_Fore[3]['wind']['t']}<br />".$mywd->ConvSpeed($v_Fore[3]['wind']['s'],$tps)."</td><td class=\"xp_forecast\">\n"
						."{$v_Fore[4]['wind']['t']}<br />".$mywd->ConvSpeed($v_Fore[4]['wind']['s'],$tps)."</td><td class=\"xp_forecast\">\n"
						."{$v_Fore[5]['wind']['t']}<br />".$mywd->ConvSpeed($v_Fore[5]['wind']['s'],$tps)."</td></tr>\n"

						."<tr><td>&nbsp;</td><td colspan=\"7\"><hr></td></tr>\n"
						."<tr><td>&nbsp;</td><td>"._MD_XPW_HUMID.":</td><td class=\"xp_forecast\">\n"
						."{$v_Fore[0]['hmid']}%</td><td class=\"xp_forecast\">\n"
						."{$v_Fore[1]['hmid']}%</td><td class=\"xp_forecast\">\n"
						."{$v_Fore[2]['hmid']}%</td><td class=\"xp_forecast\">\n"
						."{$v_Fore[3]['hmid']}%</td><td class=\"xp_forecast\">\n"
						."{$v_Fore[4]['hmid']}%</td><td class=\"xp_forecast\">\n"
						."{$v_Fore[5]['hmid']}%</td></tr></table>\n"

						."<hr><table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" style=\"width:auto;\">"
						."<tr>"
						
						."<td class=\"xp_forecast\">\n"
						."<table cellspacing=\"1\" cellpadding=\"0\" class='property'>"
						."<tr class=\"bg3\"><td class='property'>\n"
						."<b><small>Info</small></b>\n"
						."<td class='property'><a href=\"change.php\"><small>"._MD_XPW_CHNGSET."</small></a></td>\n"
						."<tr class=\"bg3\"><td class='property'><b><small>"._MD_XPW_REG.":</small></b></td><td class='property'><small>$v_Region</small></td></tr>"
						."<tr class=\"bg3\"><td class='property'>\n"
						."<b><small>"._MD_XPW_WCNTRY.":</small></b></td><td class='property'><small>$v_Country</small></td></tr>"
						."<tr class=\"bg3\"><td class='property'>\n"
						."<b><small>"._MD_XPW_WCITY.":</small></b></td><td class='property'><small>$v_City</small></td></tr>"
						."<tr class=\"bg3\"><td class='property'>\n"
						."<b><small>Loc:</small></b></td><td class='property'><small>$v_Acid</small></td></tr>"
						."</table>"
						."</td>"
						
						."<td width=\"72\" style=\"vertical-align:bottom;text-align:center;\">"._MD_XPW_RADAR."<br /><a href=\"http://www.wni.co.jp/cww/docs/radar.html\" target=\"_blank\"><img src=\"images/radar.gif\" width=\"62\" height=\"64\" alt="._MD_XPW_RADAR."></a></td>\n"
						."<td width=\"72\" style=\"vertical-align:bottom;text-align:center;\">"._MD_XPW_SATELL."<br /><a href=\"http://www.wni.co.jp/cww/docs/gms/index.html\" target=\"_blank\"><img src=\"images/satellite.gif\" width=\"62\" height=\"64\" alt="._MD_XPW_SATELL."></a></td>\n"
						."<td width=\"72\" style=\"vertical-align:bottom;text-align:center;\">"._MD_XPW_PRECIP."<br /><a href=\"http://www.wni.co.jp/cww/docs/amedas.html\" target=\"_blank\"><img src=\"images/precipitation.gif\" width=\"62\" height=\"64\" alt="._MD_XPW_PRECIP."></a></td>\n"
						."<td style=\"vertical-align:bottom;\"><a href=\"http://www.weather.com/?prod=xoap&par=".XOOPS_MD_XPWEATHER_PAR."\"><img src=\"images/TWClogo_64px.png\" alt=\"\"></a></td>\n"
						."<td style=\"vertical-align:bottom;\">{$v_links}</td>\n"
						."</tr></table>\n"
						
						."<div style=\"text-align:right\"><a href=\"http://hypweb.net/xoops/wiki/81.html\"><small>XP-Weather $xp_weather_var</small></a></div>";
						
						fputs($fpwrite, $outbuf);
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
					$outbuf = fread($wfread,filesize($cache_file));
					fclose($wfread);
				}
    		}
    	}
        if (isset($failuremessage)) {
			$outbuf = $failuremessage;
    	}
	}
    echo $outbuf;
}
?>