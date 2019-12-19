<?php
/***********************************************************************************/
/* XP-Weather version 1.3                                                          */
/*		davidd - added proxy_* variables to configure snoopy proxy server support  */
/*																				   */
/* XP-Weather version 1.1                                                          */
/*		removed $pnwconfig variable it broke the block rendering (don't know why)  */
/*																				   */
/* XP-Weather version 1.0                                                          */
/* XP-Weather version 0.98d                                                        */
/*         Modified again by davidd (dk@axarosenberg.com)                          */
/*         http://www.axarosenberg.com                                             */
/*																				   */
/* 6/18/2002 - davidd															   */
/*				- Added adjustable persistent cache to block and main module	   */
/*				- Code Cleanup  												   */
/*																				   */
/* 6/13/2002 - davidd                                                              */
/*				- added conText weather condition text							   */
/*				- re-worked table output										   */
/*				- added radar and percipitation map links						   */
/*				- fixed header and footer includes for template main/cblock	   	   */
/*				- moved embeded French out to language/main.php file			   */
/*                                                                                 */
/***********************************************************************************/
/*                                                                                 */
/* PNWeather version 0.71b                                                          */
/*         Converted by JNJ (jnj@infobin.com                                       */
/*         http://www.infobin.com                                                  */
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

/*********************************************************************************************************/
/* General Module Configuration                                                                          */
/*                                                                                                       */
/* $module_name:    Directory name of the module                                                         */
/* $bgifdir:        Directory name /modules/XP-Weather/images/ which contains weather images for block */
/* $gifdir:         Directory under /modules/XP-Weather/images/ which contains weather images          */
/* $cache_time:     Cache Time                                                                           */
/*                  This allows seamless compatibility with both PHP-Nuke 5.2 & 5.3                      */
/* $pnwusermod:     1 -- Allow Users to Change Settings, 0 -- Disallow Settings Changes                  */
/* (THIS FEATURE NOT YET IMPLEMENTED.)                                                                   */
/*                                                                                                       */
/*********************************************************************************************************/
include_once(XOOPS_ROOT_PATH."/class/xoopsmodule.php");
$XP_Module = XoopsModule::getByDirname("XP-Weather");
if (method_exists($XP_Module,'loadInfo')) // For XOOPS 2
	$XP_Module->loadInfo("XP-Weather");
$xp_weather_var = $XP_Module->modinfo['version'];
$config_handler =& xoops_gethandler('config');
$XP_ModuleConfig =& $config_handler->getConfigsByCat(0, $XP_Module->mid());
define("XOOPS_MD_XPWEATHER_PAR", empty($XP_ModuleConfig['dev_id'])? "" : trim($XP_ModuleConfig['dev_id']));
define("XOOPS_MD_XPWEATHER_KEY", empty($XP_ModuleConfig['dev_key'])? "" : trim($XP_ModuleConfig['dev_key']));
unset($XP_Module);

$GLOBALS['XPWEATHER_CONFIG'] = array(
	"module_name" => ((defined("_XP_WEATHER_NAME"))? _XP_WEATHER_NAME : "XP-Weather"),
	"proxy_host"  => "",
	"proxy_port"  => "",
	"proxy_user"  => "",
	"proxy_pwd"   => "",
	"bgifdir"     => "fresh",
	"gifdir"      => "fresh",
	"cache_time"  => 600
);

?>