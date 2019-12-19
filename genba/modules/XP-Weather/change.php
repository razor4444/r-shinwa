<?php
/***********************************************************************************/
/*                                                                                 */
/* XP-Weather version 1.3                                                          */
/*		8/4/2002 - davidd, integrated wmo_stations table data into city query      */
/*                                                                                 */
/* XP-Weather version 1.1                                                          */
/* XP-Weather version 1.0                                                          */
/* XP-Weather version 0.98                                                         */
/*         Converted by Davidd (http://www.axarosenberg.com)                       */
/* 6/19/2002 -		Fixed module includes                                          */
/*                                                                                 */
/***********************************************************************************/
/*                                                                                 */
/* PNWeather version 0.71c                                                         */
/*         Converted by JNJ (jnj@infobin.com                                       */
/*         http://www.infobin.com                                                  */
/*    A bug with the user infos were detected and killed by Fred Blastov 2002/05/23*/
/*  This is why the c of 0.71 that I decided by myself....			   */
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

if (!defined('XOOPS_MD_XPWEATHER_PAR') || !XOOPS_MD_XPWEATHER_PAR || !XOOPS_MD_XPWEATHER_KEY)
{
	header("Location: ".XOOPS_URL."/modules/XP-Weather/");
	exit();	
}

include_once(XOOPS_ROOT_PATH."/modules/XP-Weather/include/hyp_common/hyp_simplexml.php");

//error_reporting(E_ALL);

function frmCitySearch($utype,$selection="")
{
	global $xoopsTpl;
	//$selection = preg_replace("/[^\w&; \/\-]+/","",$selection);
	
	$xoops_mod_add_header = '<script src="./js/prototype/prototype.js" type="text/javascript"></script>
<script src="./js/log.js" type="text/javascript"></script>
<script src="./js/XPWeather.js" type="text/javascript"></script>
<script type="text/javascript">
<!--
var XPWeather_obj = null;
var onLoadHandler = function(){
	XPWeather_obj = new XPWeather(\''.XOOPS_URL.'\');
};
if (window.addEventListener) {
    window.addEventListener("load", onLoadHandler, true);
} else {
    window.attachEvent("onload", onLoadHandler);
}
//-->
</script>';
	
	if (is_object($xoopsTpl))
	{
		$xoopsTpl->assign("xoops_module_header",$xoops_mod_add_header . $xoopsTpl->get_template_vars("xoops_module_header"));
	}
	
	echo "<tr><td colspan=\"2\"><hr /></td></tr>";
	echo "<form action=\"change.php\" method=\"post\"><td><b>"._MD_XPW_WCITY."Search: </b><br /></td>\n";
	echo "<td><input type=\"hidden\" name=\"weatherop\" value=\"{$utype}Station\">";
	echo "<input type=\"hidden\" name=\"reg_id\" value=\"99\">";
	echo "<input type=\"text\" size=\"30\" id=\"XPWeather_input\" autocomplete=\"off\" name=\"Selection\" value=\"$selection\">";
	echo "<input type=\"button\" value=\"City Search\" onClick='submit()'>";
	echo "<div id=\"XPWeather_suggest_list\" class=\"auto_complete\"></div>";
	echo "</td></form>\n";
}

function frmRegion($utype, $regionid = 0) {
	global $xoopsDB;

	echo "<form action=\"change.php\" method=\"post\"><td><b>"._MD_XPW_REG.": </b><br /></td>\n";

	echo "<td><input type=\"hidden\" name=\"weatherop\" value=\"$utype"."Country\">";

	$rlist = $xoopsDB->query("SELECT name, reg_id from ".$xoopsDB->prefix("xpweather_region")." ORDER BY name");

	echo "<select name=\"Selection\" onChange='submit()'>\n";

	if ($regionid == 0) {

		echo "<option selected value=\"0\">"._MD_XPW_WSELECT._MD_XPW_REG."</option>\n";

		$regionid='';
	}
	echo $regionid;
	while(list($wregionl, $wregionidl) = mysql_fetch_row($rlist)) {

		$sel = ($wregionidl==$regionid)? " selected" : "" ;

		echo "<option$sel value=\"$wregionidl\">$wregionl</option>\n";

	}
	echo "<option>----------</option>\n";
	$sel = ($regionid == 99)? "selected " : "" ;
	echo "<option $sel value=\"99\">City Search</option>\n";
	echo "</select><br /></td></form>\n";
}

function frmCountry($utype, $regionid, $countryid = 0) {
	global $xoopsDB;

	echo "<form action=\"change.php\" method=\"post\"><td><b>"._MD_XPW_WCNTRY.": </b><br /></td>\n";

	echo "<td><input type=\"hidden\" name=\"weatherop\" value=\"$utype"."Station\">";

	$clist = $xoopsDB->query("SELECT name, ctry_id from ".$xoopsDB->prefix("xpweather_country")." where reg_id='$regionid' ORDER BY name");

	echo "<select name=\"Selection\" onChange='submit()'>\n";

	if ($countryid == 0) {

		echo "<option selected value=\"0\">"._MD_XPW_WSELECT._MD_XPW_WCNTRY."</option>\n";

		$countryid='';
	}
	while(list($wcountryl, $wcountryidl) = mysql_fetch_row($clist)) {

		$sel = ($wcountryidl==$countryid)? "selected " : "" ;

		echo "<option $sel value=\"$wcountryidl\">$wcountryl</option>\n";

		$sel = "";

	}

	echo "</select><br /></td></form>\n";
}

function frmCity($utype, $reg_id, $ctry_id, $loc = 'NA') {
	global $xoopsDB;

	echo "<form action=\"change.php\" method=\"post\"><td><b>"._MD_XPW_WCITY.": </b><br /></td>\n";

	echo "<td><input type=\"hidden\" name=\"weatherop\" value=\"$utype"."PreSave\">";
	
	$ctylist = $xoopsDB->query("SELECT name,loc from ".$xoopsDB->prefix("xpweather_station")." where ctry_id='$ctry_id' ORDER BY name");
	
	echo "<select name=\"Selection\" onChange='submit()'>\n";

	if ($loc == 'NA') {

		echo "<option selected value=\"0\">"._MD_XPW_WSELECT._MD_XPW_WCITY."</option>\n";

	}
	
	$wc = new WeatherData();
	
	while(list($name,$newloc) = mysql_fetch_row($ctylist)) {

		if ($loc==$newloc) { $sel = "selected "; }
		
		$_name = $wc->get_local_name($name, $newloc, $cat="citys");
		if ($name != $_name)
		{
			$name .= " [{$_name}]";	
		}
		$name = htmlspecialchars($name);
		
		echo "<option $sel value=\"$newloc\">$name</option>\n";

		$sel = "";
	}
	echo "</select><br /></td></form>\n";
}

function frmStation($utype, $reg_id, $ctry_id, $loc='NA') {
	global $xoopsDB;

	$_node="loc";
	$_locid="id";
	$_name="content";

    $simpleXML = new HypSimpleXML();

	echo "<form action=\"change.php\" method=\"post\"><td><b>"._MD_XPW_WSTATION.": </b><br /></td>\n";

	echo "<td><input type=\"hidden\" name=\"weatherop\" value=\"$utype"."PreSave\">";

	if ($reg_id == 99)
	{
		$city_title = $ctry_id;
	}
	else
	{
		list($city_title) = mysql_fetch_row($xoopsDB->query("SELECT name from ".$xoopsDB->prefix("xpweather_station")." where loc='$loc'"));
	}
	
	echo "<select name=\"Selection\" onChange='submit()'>\n";

	if ($loc == 'NA') {

		$op_title = "<option selected value=\"0\">"._MD_XPW_WSELECT._MD_XPW_WSTATION."</option>\n";

		$wcid='';
	}
	$failuremessag = "";
	
	$mywd = new WeatherData;

	if ( !empty($GLOBALS['XPWEATHER_CONFIG']['proxy_host']) ) {
		$mywd->proxyHost = $GLOBALS['XPWEATHER_CONFIG']['proxy_host'];
		if ( !empty($GLOBALS['XPWEATHER_CONFIG']['proxy_port']) ) { $mywd->proxyPort = $GLOBALS['XPWEATHER_CONFIG']['proxy_port']; }
		if ( !empty($GLOBALS['XPWEATHER_CONFIG']['proxy_user']) ) { $mywd->User = $GLOBALS['XPWEATHER_CONFIG']['proxy_user']; }
		if ( !empty($GLOBALS['XPWEATHER_CONFIG']['proxy_pwd']) ) { $mywd->Pass = $GLOBALS['XPWEATHER_CONFIG']['proxy_pwd']; }
	}
	
	// 正規化
	$city_title = preg_replace("/[^\w&; \/\-]+/","",$city_title);
	
	$mywd->fetchData($city_title,"where");
	
	if ( IsSet($mywd->feedError) && !empty($mywd->feedError) ) {
		$failuremessage = _MD_XPW_UNAVAIL.": $mywd->feedResponse ($mywd->feedError)\n";
	}
	
	if ( !isSet($failuremessage) || empty($failuremessage) || $failuremessag == "") {
		$failuremessage = "";
		$xml = $simpleXML->XMLstr_in($mywd->results);
		
		if (is_array($xml[$_node][1]))
		{
			$xmlcount = count($xml[$_node]);
		}
		else
		{
			$xmlcount = (empty($xml[$_node]))? 0 : 1;
			if (!$xmlcount) $op_title = "<option selected value=\"0\">"._MD_XPW_NOTFOUND."</option>\n";
		}
		
		echo $op_title;
		
		if ( $xmlcount == 1 ) {
			$wcidl= $xml[$_node][$_locid];
			$wcityl = $xml[$_node][$_name];

			$sel = ($wcidl==$wcid)? "selected " : "" ;

			echo "<option $sel value=\"$wcidl\">$wcityl</option>\n";

			$sel = "";
		} else {
			for($index=0; $index<$xmlcount; $index++) {
				$wcidl= $xml[$_node][$index][$_locid];
				$wcityl = $xml[$_node][$index][$_name];

				if ($wcidl==$wcid) { $sel = "selected "; }

				echo "<option $sel value=\"$wcidl\">$wcityl</option>\n";

				$sel = "";
			}
		}
	}
	echo "</select><br />";
	echo "</td></form>$failuremessage\n";
}

function SelRegion($utype, $wuid=0) {
	global $xoopsDB, $xoopsUser;
	global $weatherop,$wcity,$Selection,$newtpc,$newtps;
	
	if ($utype=="Anon") {

		echo "<h4><b>{$GLOBALS['XPWEATHER_CONFIG']['module_name']} "._MD_XPW_SETTINGS."</b></h4>";

		echo "<li type=\"square\"> "._MD_XPW_WNOTLOGGEDON." &nbsp;[<a href=\"../../user.php\">"._MD_XPW_WLOGIN."</a>]<br /><br />\n";

		echo ""._MD_XPW_IFYOU." <a href=\"../../register.php\">"._MD_XPW_WREGISTER."</a>.<br /><br />\n";

		echo "<a href=\"../../register.php\">"._MD_XPW_WJOIN."</a><br /><br />\n";
	} else {
		
		if ( $xoopsUser )
		{
			list($saved_wcid, $saved_tpc, $saved_tps) = mysql_fetch_row(mysql_query("select wcid, tpc, tps from ".$xoopsDB->prefix("xpweather_userloc")." where userid='$wuid'"));
		}
		else if (!empty($_COOKIE["XPW_LOC"]))
		{
			list($saved_wcid, $saved_tpc, $saved_tps) = explode("|",$_COOKIE['XPW_LOC']);
		}
		if (empty($saved_wcid) || $utype == "Admin")
		{
			list($saved_wcid, $saved_tpc, $saved_tps) = mysql_fetch_row(mysql_query("select wcid, tpc, tps from ".$xoopsDB->prefix("xpweather_userloc")." where userid='0'"));
		}

		$mywd = new WeatherData;
		$point = $mywd->get_loc_data ($saved_wcid);
		$regionid = $point['region']['id'];
		$countryid = $point['country']['id'];
		
		xpw_show_point($point,$saved_tpc,$saved_tps);
				
		echo "<br /><table><tr>\n";
		
		frmRegion($utype, $regionid);

		echo "</tr><tr>";
		
		frmCountry($utype, $regionid, $countryid);
		
		echo "</tr><tr>";

		frmCity($utype, $regionid, $countryid, $saved_wcid);
		
		echo "</tr><tr>";

		frmCitySearch($utype, "");
		
		echo "</tr></table><br />\n";
		
		echo "<form action=\"change.php\" method=\"post\"><b>"._MD_XPW_WVIEWPREF."</b><br /><br />\n";

		echo ""._MD_XPW_WTEMP." "._MD_XPW_IN.": <br />\n";
		echo "<input type=\"radio\" ";

		if ($saved_tpc == 0) { echo "checked ";}

		echo "name=\"newtpc\" value=0> "._MD_XPW_CELSIUS."<br />\n";

		echo "<input type=\"radio\" ";

		if ($saved_tpc == 1) { echo "checked ";}

		echo "name=\"newtpc\" value=1> "._MD_XPW_FAHREN."<br /><br />\n";

		echo ""._MD_XPW_WINDSPD." "._MD_XPW_IN.": <br />\n";

		echo "<input type=\"radio\" ";

		if ($saved_tps == 0) { echo "checked ";}

		echo "name=\"newtps\" value=0> m/s ("._MD_XPW_KPH.")<br />\n";

		echo "<input type=\"radio\" ";

		if ($saved_tps == 1) { echo "checked ";}

		echo "name=\"newtps\" value=1> mph ("._MD_XPW_MPH.")<br />\n";
		echo "<br />";
		echo "<input type=\"hidden\" name=\"wcid\" value=\"$saved_wcid\">\n";
		echo "<input type=\"hidden\" name=\"weatherop\" value=\"$utype"."Save\">\n";

		echo "<input type=\"submit\" value=\""._MD_XPW_SAVECHGS."\">\n";

		echo "</form>\n";
	}
}


function SelCountry($utype, $regionid, $wuid = 0) {
	global $xoopsDB;

	if ($utype=="Anon") {

		echo ""._MD_XPW_WNOTLOGGEDON."<br />\n";

		echo ""._MD_XPW_IFYOU."<a href=\"../../user.php\">"._MD_XPW_WMEMBER."</a>"._MD_XPW_UCANCHNG."<br />\n";

		echo ""._MD_XPW_SOWHATRU."<a href=\"../../user.php\">"._MD_XPW_WJOIN."</a>"._MD_XPW_ALREADY."<br />\n";
	} else {
		list($wregion) = mysql_fetch_row($xoopsDB->query("select name from ".$xoopsDB->prefix("xpweather_region")." where reg_id='$regionid'"));

		$result1 = $xoopsDB->query("SELECT ctry_id from ".$xoopsDB->prefix("xpweather_country")." where reg_id='$regionid'");

		if(mysql_num_rows($result1) > 1) {

			echo "<h4><b>{$GLOBALS['XPWEATHER_CONFIG']['module_name']} "._MD_XPW_SETTINGS."</b></h4>";

			echo "<li type=\"square\"> "._MD_XPW_WSELECT._MD_XPW_WCNTRY."<br />\n";

			echo "<br /><table><tr>\n";

			frmRegion($utype, $regionid);

			echo "</tr><tr>";

			frmCountry($utype, $regionid, 0);

			echo "</tr></table><br />\n";
		} else {
			list($countryid) = mysql_fetch_row($result1);

			echo "<h4><b>{$GLOBALS['XPWEATHER_CONFIG']['module_name']} "._MD_XPW_SETTINGS."</b></h4>";

			echo "<li type=\"square\">"._MD_XPW_WSELECT._MD_XPW_WSUBDIV."<br />\n";

			echo "<br /><table><tr>\n";

			frmRegion($utype, $regionid);

			echo "</tr><tr>";
			
			if ($regionid == 99)
			{
				frmCitySearch($utype);
			}
			else
			{
				frmCountry($utype, $regionid, $countryid);

				echo "</tr><tr>";

				frmCity($utype, $regionid, $countryid, 0);
			}
			
			echo "</tr><tr>";
			echo "</tr></table><br />\n";
		}
	}
}


function SelSubDiv($utype, $countryid, $wuid = 0) {
	global $xoopsDB;

	if ($utype=="Anon") {

		echo ""._MD_XPW_WNOTLOGGEDON."<br />\n";

		echo ""._MD_XPW_IFYOU."<a href=\"../../user.php\">"._MD_XPW_WMEMBER."</a>"._MD_XPW_UCANCHNG."<br />\n";

		echo ""._MD_XPW_SOWHATRU."<a href=\"../../user.php\">"._MD_XPW_WJOIN."</a>"._MD_XPW_ALREADY."<br />\n";
	} else {
		list($wcountry, $regionid) = mysql_fetch_row($xoopsDB->query("select country_title, region_id from ".$xoopsDB->prefix("country")." where country_id='$countryid'"));

		list($wregion) = mysql_fetch_row($xoopsDB->query("select region_title from ".$xoopsDB->prefix("region")." where region_id='$regionid'"));

		$result1 = $xoopsDB->query("SELECT subdiv_id from ".$xoopsDB->prefix("subdiv")." where country_id='$countryid'");

		if(mysql_num_rows($result1) > 1) {

			echo ""._MD_XPW_WSELECT._MD_XPW_WSUBDIV."<br />\n";

			echo "<br /><table><tr>\n";

			frmRegion($utype, $regionid);

			echo "</tr><tr>";

			frmCountry($utype, $regionid, $countryid);

			echo "</tr></table><br />\n";
		} else {
			echo "<h4><b>{$GLOBALS['XPWEATHER_CONFIG']['module_name']} "._MD_XPW_SETTINGS."</b></h4>";

			echo "<li type=\"square\"> "._MD_XPW_WSELECT._MD_XPW_WCITY."<br />\n";

			list($subdivid) = mysql_fetch_row($result1);

			echo "<br /><table><tr>\n";

			frmRegion($utype, $regionid);

			echo "</tr><tr>";

			frmCountry($utype, $regionid, $countryid);

			echo "</tr></table><br />\n";
		}
	}
}

function SelStation($utype, $ctry_id, $wuid = 0) {
	global $xoopsDB, $xoopsConfig;

	if ($utype=="Anon") {

		echo ""._MD_XPW_WNOTLOGGEDON."<br />\n";

		echo ""._MD_XPW_IFYOU."<a href=\"../../user.php\">"._MD_XPW_WMEMBER."</a>"._MD_XPW_UCANCHNG."<br />\n";

		echo ""._MD_XPW_SOWHATRU."<a href=\"../../user.php\">"._MD_XPW_WJOIN."</a>"._MD_XPW_ALREADY."<br />\n";
	} else {
		if (empty($_POST['reg_id']))
		{
	 		list($reg_id) = mysql_fetch_row($xoopsDB->query("select reg_id from ".$xoopsDB->prefix("xpweather_country")." where ctry_id='$ctry_id' LIMIT 1"));
		}
		else
		{
			$reg_id = 99;
		}
		echo "<h4><b>{$GLOBALS['XPWEATHER_CONFIG']['module_name']} "._MD_XPW_SETTINGS."</b></h4>";

		echo "<li type=\"square\"> "._MD_XPW_WSELECT._MD_XPW_WSTATION."<br />\n";

		echo "<br /><table><tr>\n";

		frmRegion($utype, $reg_id);
		
		echo "</tr><tr>";
		if ($reg_id == 99)
		{
			// ローマ字に変換してみる？
			if ($xoopsConfig['language'] == "japanese" && preg_match("/[^\w&; \/\-]+/",$ctry_id))
			{
				include_once(XOOPS_ROOT_PATH."/modules/XP-Weather/include/hyp_common/hyp_kakasi.php");
				$kakasi = new Hyp_KAKASHI();
				$kakasi->add_dict(XOOPS_ROOT_PATH."/modules/XP-Weather/include/kakasi_dic.txt");
				$kakasi->get_roma($ctry_id);
			}
			frmCitySearch($utype,$ctry_id);
			echo "</tr><tr>";
			frmStation($utype, $reg_id, $ctry_id, "NA");
		}
		else
		{
			frmCountry($utype, $reg_id, $ctry_id);
			echo "</tr><tr>";
			frmCity($utype, $reg_id, $ctry_id, "NA");
		}
		echo "</tr><tr>";

		echo "</tr></table><br />\n";
	}
}

function PreSave($utype, $wcid, $wuid=0) {
	global $xoopsDB, $xoopsUser;
	global $weatherop,$wcity,$Selection,$newtpc,$newtps;
	
	if ($utype=="Anon") {

		echo ""._MD_XPW_WNOTLOGGEDON."<br />\n";

		echo ""._MD_XPW_IFYOU."<a href=\"user.php\">"._MD_XPW_WMEMBER."</a>"._MD_XPW_UCANCHNG."<br />\n";

		echo ""._MD_XPW_SOWHATRU."<a href=\"user.php\">"._MD_XPW_WJOIN."</a>"._MD_XPW_ALREADY."<br />\n";
	} else {
		if ( $xoopsUser )
		{
			list($saved_wcid, $saved_tpc, $saved_tps) = mysql_fetch_row(mysql_query("select wcid, tpc, tps from ".$xoopsDB->prefix("xpweather_userloc")." where userid='$wuid'"));
		}
		else if (!empty($_COOKIE["XPW_LOC"]))
		{
			list($saved_wcid, $saved_tpc, $saved_tps) = explode("|",$_COOKIE['XPW_LOC']);
		}
		if (empty($saved_wcid) || $utype == "Admin")
		{
			list($saved_wcid, $saved_tpc, $saved_tps) = mysql_fetch_row(mysql_query("select wcid, tpc, tps from ".$xoopsDB->prefix("xpweather_userloc")." where userid='0'"));
		}
		
		$mywd = new WeatherData;
		$point = $mywd->get_loc_data ($saved_wcid);
		xpw_show_point($point,$saved_tpc,$saved_tps);

		$wcity = "";
		$subdivid = 0;

		$point = $mywd->get_loc_data ($wcid);
		$regionid = $point['region']['id'];
		$countryid = $point['country']['id'];

		echo ""._MD_XPW_NEWSET.":<br />\n";

		echo "<br /><table><tr>\n";

		frmRegion($utype, $regionid);

		echo "</tr><tr>";

		frmCountry($utype, $regionid, $countryid);

		echo "</tr><tr>";
		frmCity($utype, $regionid, $countryid, $wcid);

		echo "</tr></table><br />\n";

		echo "<form action=\"change.php\" method=\"post\"><b>"._MD_XPW_WVIEWPREF."</b><br /><br />\n";

		echo ""._MD_XPW_WTEMP." "._MD_XPW_IN.": <br />\n";

		echo "<input type=\"radio\" ";

		if ($saved_tpc == 0) { echo "checked ";}

		echo "name=\"newtpc\" value=0> "._MD_XPW_CELSIUS."<br />\n";

		echo "<input type=\"radio\" ";

		if ($saved_tpc == 1) { echo "checked ";}

		echo "name=\"newtpc\" value=1> "._MD_XPW_FAHREN."<br /><br />\n";

		echo ""._MD_XPW_WINDSPD." "._MD_XPW_IN.": <br />\n";

		echo "<input type=\"radio\" ";

		if ($saved_tps == 0) { echo "checked ";}

		echo "name=\"newtps\" value=0> m/s ("._MD_XPW_KPH.")<br />\n";

		echo "<input type=\"radio\" ";

		if ($saved_tps == 1) { echo "checked ";}

		echo "name=\"newtps\" value=1> mph ("._MD_XPW_MPH.")<br />\n";
		echo "<br />";
		echo "<input type=\"hidden\" name=\"wcid\" value=\"$wcid\">\n";
		echo "<input type=\"hidden\" name=\"weatherop\" value=\"$utype"."Save\">\n";

		echo "<input type=\"submit\" value=\""._MD_XPW_SAVECHGS."\">\n";

		echo "</form>\n";
	}
}

function SaveSet($utype, $tpc, $tps, $wcid, $wuid=0) {
	global $xoopsDB, $userid, $admin, $xoopsUser;
	global $weatherop,$wcity,$Selection,$newtpc,$newtps;

	$err = "";
	// 登録データ値のチェック
	$tpc = (empty($tpc))? "0" : "1";
	$tps = (empty($tps))? "0" : "1";
	$wuid = (int)$wuid;
	
	if (!preg_match("/^[a-zA-Z]{4}[\d]{4}$/",$wcid))
	{
		$err = "Invalid Data.";
	}
	
	if (!$err)
	{
		if (!$xoopsUser)
		{
			// cookie に保存
			$mywd = new WeatherData;
			$mywd->setcookie($wcid, $tpc, $tps);
		}
		else
		{
			if (!$xoopsUser->isAdmin() and $utype=="Admin")
			{
				$err = _MD_XPW_SORRYNOTADMIN."<br />"._MD_XPW_ENSURELOGGEDON;
			}
			else
			{
				list($testwcid) = mysql_fetch_row($xoopsDB->query("select wcid from ".$xoopsDB->prefix("xpweather_userloc")." where userid='$wuid'"));
	
				if(!$testwcid)
				{
					$newquery = "INSERT ".$xoopsDB->prefix("xpweather_userloc")." set wcid='$wcid', tpc='$tpc', tps='$tps', userid='$wuid'";
				}
				else
				{
					$newquery = "UPDATE ".$xoopsDB->prefix("xpweather_userloc")." set wcid='$wcid', tpc='$tpc', tps='$tps' where userid='$wuid'";
				}
				if(!$xoopsDB->query($newquery))
				{
					$err = mysql_errno().": ".mysql_error()."<br />"._MD_XPW_ERRORCADMIN;
				}
			}
		}
	}
	
	if ($err)
	{
		$msg = "<br />".$err;
	}
	else
	{
		$msg = _MD_XPW_SETSAVED;
	}
	
	redirect_header(XOOPS_URL."/modules/XP-Weather/?loc=".$wcid,1,$msg);
	exit();
}


function checkadmin() {
	global $userid, $admin, $xoopsUser, $xoopsDB;
	
	if ( $xoopsUser ) {

		if ( $xoopsUser->isAdmin() ) {

			echo "<h4>{$GLOBALS['XPWEATHER_CONFIG']['module_name']} "._MD_XPW_WADMINMENU."</h4>";

			echo "<li type=\"square\"><font face=\"Arial\" color=\"red\" size=\"\">"._MD_XPW_NOTESTATION."</font><br /><br />";

			echo "<li type=\"square\"> "._MD_XPW_WANT2CHNG.":<br /><br />\n";

			echo "<a href=\"change.php?weatherop=AdminRegion\"><b>"._MD_XPW_WDEFAULTSET."<br /><br />"._MD_XPW_OR."<br /><br />\n";

			echo "<a href=\"change.php?weatherop=UserRegion\"><b>"._MD_XPW_WYOURSET."<br /><br />\n";

		}else {

			SelRegion("User", $userid);

		}

	}
	if ( !$xoopsUser ) {
		//SelRegion("Anon");
		SelRegion("User");
	}
}

function xpw_show_point($point,$tpc,$tps)
{
	echo "<h4><b>{$GLOBALS['XPWEATHER_CONFIG']['module_name']} "._MD_XPW_SETTINGS."</b></h4>";

	echo "<li type=\"square\">"._MD_XPW_PLSCHNGLOC."<br /><br />\n";

	echo "<b>"._MD_XPW_CURSETT.":</b>\n";

	echo "<table cellspacing=\"1\" cellpadding=\"1\" class=\"bg2\">\n";

	echo "<tr class=\"bg3\"><td><b>"._MD_XPW_REG.":</b></td><td>{$point['region']['name']}</td></tr><tr class=\"bg3\"><td>\n";

	echo "<b>"._MD_XPW_WCNTRY.":</b></td><td>{$point['country']['name']}</td></tr><tr class=\"bg3\"><td>\n";

	echo "<b>"._MD_XPW_WCITY.":</b></td><td>{$point['station']['name']} ({$point['station']['id']})</td></tr><tr class=\"bg3\"><td>\n";

	if ($tpc == 0) {
		echo "<b>"._MD_XPW_WTEMP.":</b></td><td>&deg;C </td></tr><tr class=\"bg3\"><td>\n";
	} else {
		echo "<b>"._MD_XPW_WTEMP.":</b></td><td>&deg;F </td></tr><tr class=\"bg3\"><td>\n";
	}
	if ($tps == 0) {
		echo "<b>"._MD_XPW_WINDSPD.":</b></td><td>m/s </td></tr></table>\n";
	} else {
		echo "<b>"._MD_XPW_WINDSPD.":</b></td><td>mph </td></tr></table>\n";
	}
	echo "<hr />";
}

$vers = array_merge($_GET,$_POST);

$weatherop = (isset($vers['weatherop']))? htmlspecialchars($vers['weatherop']) : "";
$wcity = (isset($vers['wcity']))? htmlspecialchars($vers['wcity']) : "";
$Selection = (isset($vers['Selection']))? htmlspecialchars($vers['Selection']) : "";
$newtpc = (isset($vers['newtpc']))? htmlspecialchars($vers['newtpc']) : "";
$newtps = (isset($vers['newtps']))? htmlspecialchars($vers['newtps']) : "";
$wcid = (isset($vers['wcid']))? htmlspecialchars($vers['wcid']) : "";
$stype = (isset($vers['stype']))? htmlspecialchars($vers['stype']) : "";
$wstype = (isset($vers['wstype']))? htmlspecialchars($vers['wstype']) : "";
$wstation = (isset($vers['wstation']))? htmlspecialchars($vers['wstation']) : "";

$userid = 0;
if ($xoopsUser) {
	$userid = $xoopsUser->uid();
}

$xoopsOption['show_rblock'] =0;

if ($weatherop != "AdminSave" && $weatherop != "UserSave")
{
	include(XOOPS_ROOT_PATH."/header.php");
	
	//OpenTable();
	echo "<link rel=\"stylesheet\" href=\"./style.css\" type=\"text/css\" media=\"screen\" charset=\"shift_jis\">\n";
	echo "<div id=\"xp_weather_body\" class=\"xp_weather_body\">\n";
}

switch($weatherop) {


	case "AdminRegion":

	SelRegion("Admin", 0);

	break;


	case "UserRegion":

	SelRegion("User", $userid);

	break;


	case "AdminCountry":

	SelCountry("Admin", $Selection, 0);

	break;


	case "UserCountry":

	SelCountry("User", $Selection, $userid);

	break;


	case "AdminSubDiv":

	SelSubDiv("Admin", $Selection, 0);

	break;


	case "UserSubDiv":

	SelSubDiv("User", $Selection, $userid);

	break;

	case "AdminStation":

	SelStation("Admin", $Selection, 0);

	break;


	case "UserStation":

	SelStation("User", $Selection, $userid);

	break;


	case "AdminPreSave":

	PreSave("Admin", $Selection, $userid);

	break;


	case "UserPreSave":

	PreSave("User", $Selection, $userid);

	break;


	case "AdminSave":
	SaveSet("Admin", $newtpc, $newtps, $wcid, 0);

	break;


	case "UserSave":

	SaveSet("User", $newtpc, $newtps, $wcid, $userid);

	break;


	default:

	checkadmin();

	break;

}
echo "<script type=\"text/javascript\">window.location.hash = 'xp_weather_body';</script>";
echo "</div>";
//CloseTable();

include(XOOPS_ROOT_PATH."/footer.php");

?>