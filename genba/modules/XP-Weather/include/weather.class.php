<?php
if(!defined('_CLASS_WEATHER_LOADED')) {
	define('_CLASS_WEATHER_LOADED', true);

/*
// includes Snoopy class for remote file access
if (file_exists(XOOPS_ROOT_PATH."/class/snoopy.class.php")){
	//xoops 1.3
	require_once(XOOPS_ROOT_PATH."/class/snoopy.class.php");
} else {
	//xoops 2
	require_once(XOOPS_ROOT_PATH."/class/snoopy.php");
}
*/

// includes Snoopy class for remote file access
if (file_exists(XOOPS_ROOT_PATH."/class/snoopy.php")){
	//xoops 2.0
	require_once(XOOPS_ROOT_PATH."/class/snoopy.php");
} else {
	//xoops 1.3
	require_once(XOOPS_ROOT_PATH."/class/snoopy.class.php");
}

	class WeatherData {
		var $feedUrl;		// location of the source weather data feed
		var $cacheFile;		// location of the source weather cache data
		var $responseSize;	// maximum length of request data
		var $proxyHost;
		var $proxyPort;
		var $proxyUser;
		var $proxyPass;

		var $feedError		= "";		// fetch error from data feed source
		var $feedResponse	= "";		// response from data feed source
		var $results		= "";		// data results

		var $v_City		= "";
		var $v_SubDiv	= "";
		var $v_Country	= "";
		var $v_Region	= "";
		var $v_Temp		= "";
		var $v_CIcon	= "";
		var $v_WindS	= "";
		var $v_WindD	= "";
		var $v_Baro		= "";
		var $v_BaroD	= "";
		var $v_Humid	= "";
		var $v_Real		= "";
		var $v_UV		= "";
		var $v_UVT		= "";
		var $v_Vis		= "";
		var $v_LastUp	= "";
		var $v_LastUpL	= "";
		var $v_ConText	= "";
		var $v_Fore		= "";
		var $v_Acid		= "";

		var $v_Location = "";
		var $v_LatLng   = "";

		var $v_WindJ    = "";
		var $v_week_correct = "";
		var $v_links    = array();
		var $v_Zone     = 0;
		var $v_LocalTM  = 0;
		var $v_Today    = "";
		
		var $v_Local     = array();
		
		/*
		 * Object constructor
		 */
		function WeatherData() {
			$this->feedUrl = "";
			$this->cacheFile = "";
			$this->responseSize = "";
			$this->proxyHost = "";
			$this->proxyPort = 80;
			$this->proxyUser = "";
			$this->proxyPass = "";
		
			global $xoopsConfig;
			$langfile = XOOPS_ROOT_PATH."/modules/XP-Weather/language/".$xoopsConfig['language']."/point.php";
			if (file_exists($langfile))
			{
				include ($langfile);
				if (is_array($citys))
				{
					$this->v_Local['citys'] = $citys;
				}
			}
		}
		/*
		 * Data Feed Fetch
		 *
		 */
		function fetchData( $loc = "", $mode = "cc") {
			
			if (!defined('XOOPS_MD_XPWEATHER_PAR') || !XOOPS_MD_XPWEATHER_PAR || !XOOPS_MD_XPWEATHER_KEY)
			{
				$this->feedResponse = "Please setup Partner ID & License Key in admin panel.";
				$this->feedError = "Config ERROR!";
				
				return;
			}
			$source_url = "http://xoap.weather.com/weather/local/".$loc."?prod=xoap&par=".XOOPS_MD_XPWEATHER_PAR."&key=".XOOPS_MD_XPWEATHER_KEY;
			if ($mode == "dayf")
			{
				$source_url .= "&dayf=6";
				$ctime = 2;
			}
			else if ($mode == "link")
			{
				$source_url .= "&link=xoap";
				$ctime = 12;
			}
			else if ($mode == "where")
			{
				list($loc) = explode("/",$loc);
				$loc = strtolower($loc);
				$source_url = "http://xoap.weather.com/search/search?where=".rawurlencode($loc);
				$ctime = 12;
				$cacheF = XOOPS_ROOT_PATH."/modules/XP-Weather/cache/where_".md5($loc).".xml";
			}
			else
			{
				$source_url .= "&cc=*";
				$ctime = 0.5;
				$mode = "cc";
			}
			
			// キャッシュファイル名
			if (empty($cacheF))
			{
				$cacheF = XOOPS_ROOT_PATH."/modules/XP-Weather/cache/".$loc."_".$mode.".xml";
			}
			
			if (file_exists($cacheF) && filemtime($cacheF) + $ctime * 3600 > time())
			{
				$this->results = join('',file($cacheF));
            }
            else
            {
				$snoopy = new Snoopy;
	
				if ( !empty($source_url) ) { $this->feedUrl = $source_url; }
				if ( !empty($cache_file) ) { $this->cacheFile = $cache_file; }
	
				if ( !empty($this->responseSize) ) {
					$snoopy->maxlength = $this->responseSize;
				}
	
				if ( !empty($this->proxyHost) ) {
					$snoopy->proxy_host = $this->proxyHost;
					if ( !empty($this->proxyPort) ) { $snoopy->proxy_port = $this->proxyPort; }
					if ( !empty($this->proxyUser) ) { $snoopy->user = $this->proxyUser; }
					if ( !empty($this->proxyPass) ) { $snoopy->pass = $this->proxyPass; }
				}
	            if ( IsSet($this->feedUrl) && !empty($this->feedUrl) ) {
					$snoopy->fetch($this->feedUrl);
				} else {
					$snoopy->response_code = "HTTP/1.1 400 Bad Request\r\n";
					$snoopy->error = "Unable to use the Supplied URL, it is either empty or badly formatted";
				}
				$this->feedResponse = $snoopy->response_code;
				if ( IsSet($snoopy->error) && !empty($snoopy->error) ) {
					$this->feedError = $snoopy->error;
				} else {
					if ($fp = fopen($cacheF, "wb"))
					{
						fwrite($fp, $snoopy->results);
						fclose($fp);
					}
					$this->results = $snoopy->results;
				}
			}
			return;
		}
		
		function processData($mode = "cc") {
			if ( !empty($this->results) ) {
				
				include_once(XOOPS_ROOT_PATH."/modules/XP-Weather/include/hyp_common/hyp_simplexml.php");

				$xm = new HypSimpleXML();
				$dat = $xm->XMLstr_in($this->results);
				
				if ($mode == "cc")
				{
					list($this->v_City, $this->v_Country) = explode(", ",$dat['loc']['dnam']);
					$this->v_SubDiv	= $this->v_Country;
					$this->v_Region	= "";
					$this->v_Temp	= $dat['cc']['tmp'];
					$this->v_CIcon	= $dat['cc']['icon'];
					$this->v_WindS	= $dat['cc']['wind']['s'];
					$this->v_WindD	= $this->ConvWindStr($dat['cc']['wind']['t']);
					$this->v_Baro	= $dat['cc']['bar']['r'];
					$this->v_BaroD	= $dat['cc']['bar']['d'];
					$this->v_Humid	= $dat['cc']['hmid'];
					$this->v_Real	= $dat['cc']['flik'];
					$this->v_UV		= $dat['cc']['uv']['i'];
					$this->v_UVT	= $dat['cc']['uv']['t'];
					$this->v_Vis	= $dat['cc']['vis'];
					$this->v_LocalTM= $dat['loc']['tm'];
					$this->v_Zone   = $dat['loc']['zone'];
					$this->v_LastUpL= $this->ConvDateStr($dat['cc']['lsup'],$dat['loc']['zone'],1);
					$this->v_LastUp	= $this->ConvDateStr($dat['cc']['lsup'],$dat['loc']['zone']);
					$this->v_ConText= $dat['cc']['t'];
					$this->v_Acid	= $dat['loc']['id'];
					$this->v_LatLon = $dat['loc']['lat'].",".$dat['loc']['lon'];
					
					// 言語ファイルで都市名置換
					$this->v_City = $this->get_local_name($this->v_City, $this->v_Acid, "citys");
				}
				
				else if ($mode == "dayf")
				{
					$week = array(
							"Sunday" => 1,
							"Monday" => 2,
							"Tuesday" => 3,
							"Wednesday" => 4,
							"Thursday" => 5,
							"Friday" => 6,
							"Saturday" => 7 );
					$fore = array();
					for ($i = 0; $i < 6; $i++)
					{
						if (isset($dat['dayf']['day'][$i]))
						{
							$_dat = $dat['dayf']['day'][$i];
							$fore[$i]['dw'] = $week[$_dat['t']];
							$fore[$i]['date'] = $_dat['dt'];
							$fore[$i]['hi'] = $_dat['hi'];
							$fore[$i]['low'] = $_dat['low'];
							$_i = ($_dat['hi'] == "N/A")? 1 : 0;
							if ($i === 0)
							{
								$this->v_Today = ($_i)? _MD_XPW_TODAY1 : _MD_XPW_TODAY0 ;	
							}
							$fore[$i]['icon'] = $_dat['part'][$_i]['icon'];
							$fore[$i]['t'] = $_dat['part'][$_i]['t'];
							$fore[$i]['ppcp'] = (int)$_dat['part'][$_i]['ppcp'];
							$fore[$i]['wind'] = $this->ConvWindStr($_dat['part'][$_i]['wind']);
							$fore[$i]['hmid'] = $_dat['part'][$_i]['hmid'];
						}
					}
					$this->v_Fore = $fore;
				}
				
				else if ($mode == "link")
				{
					$this->v_links = $dat['lnks']['link'];
				}
				
			} else {
				$this->feedError = "No Data to Process";
			}
			return;
		}
		
		function getIcon($icon) {
			//If( $icon <= 10 ) {
			//	$icon += 20;
			//}
			//$icon .= ".gif";
			if ($icon == "-") {$icon="na";}
			$icon .= ".png";
			return $icon;
		}
		
		function getCacheData($forcecache=false) {
			if( $forcecache != true && (!file_exists($this->cacheDir.$this->cacheFile) || (filemtime($this->cacheDir.$this->cacheFile) + $this->cacheTimeout - time()) < 0))
			{
				$snoopy = new Snoopy;
				$snoopy->fetch($this->sourceUrl);
				$data = $snoopy->results;

				$fp = fopen($this->cacheDir.$this->cacheFile, "w");
				$fp($this->cacheDir.$this->cacheFile, $data);
				fclose($fp);
			}
			// fsockopen failed the last time, so force cache
			elseif ( $forcecache == true )
			{
				if (file_exists($this->cacheDir.$this->cacheFile)) {
					$data = implode('', file($this->cacheDir.$this->cacheFile));
					// set the modified time to a future time, and let the server have time to come up again
					touch($this->cacheDir.$this->cacheFile, time() + $this->cacheTimeout);
				} else {
					$data = "";
				}
			} else {
				$data = implode('', file($this->cacheDir.$this->cacheFile));
			}
			return $data;
		}
		
		function setSubDiv($subdiv) {
			$this->v_SubDiv = $subdiv;
		}
		
		function getLocation() {
			$this->v_Location = $this->v_City.", ";

			if ( $this->v_SubDiv != "" && $this->v_SubDiv != $this->v_Country && $this->v_SubDiv != $this->v_City ) {
				$this->v_Location .= $this->v_SubDiv;
			} else {
				$this->v_Location .= $this->v_Country;
			}
			return $this->v_Location;
		}
		
		function getLocation2($v_City, $mode="") {
			
			if ($mode == "simple")
			{
				list($this->v_Location) = explode("/", $v_City);
				$this->v_Location .= ", ";
			}
			else
			{
				$this->v_Location = $v_City.", ";
			}

			if ( $this->v_SubDiv != "" && $this->v_SubDiv != $this->v_Country && $this->v_SubDiv != $this->v_City ) {
				$this->v_Location .= $this->v_SubDiv;
			} else {
				$this->v_Location .= $this->v_Country;
			}
			return $this->v_Location;
		}

		function ConvWindStr($str)
		{
			if (!defined('_MD_XPW_WINDFORMAT')) {return $str;}
			return str_replace(	array("N/A","N","E","W","S","VAR","CALM"), explode('|',_MD_XPW_WINDFORMAT), $str);	
		}
		
		function ConvDateStr($str,$zone,$local=0)
		{
			global $xoopsConfig;
			if (!defined('_MD_XPW_DATEFORMAT')) {return $str;}
			
			$tz = (int)$xoopsConfig['default_TZ'];
			$td = 0 - ($tz * 3600) + ($zone * 3600);
			
			$time = strtotime (preg_replace("/(.+(?:AM|PM)).*$/si","$1",$str));
			
			if (!$local)
			{
				$time = $time - $td;
			}
			else
			{
				if ($td === 0) {return "";}
			}
			$str = date(_MD_XPW_DATEFORMAT, $time);
			
			return $str;
		}
		
		function ConvTemp($number,$tpc) {
			$number *= 1;
			if ($number == 0) { return "N/A"; }
			if ($tpc == 0) {
				$number = (5 / 9) * ($number - 32);
				$number = round ($number);
				return "$number&deg;C";
			} else {
				return "$number&deg;F";
			}
		}
		
		function ConvPress($number,$tpc) {
			$number *= 1;
			if ($number == 0) { return "N/A"; }
			if ($tpc == 2) {
				$number = $number * 33.8639;
				$number = round ($number);
				return "$number hPa";
			} else if ($tpc == 0) {
				$number = $number * 25.4;
				$number = round ($number);
				return "$number mmHg";
			} else {
				return "$number inHg";
			}
			//1 inch = 25.4 mm
		}
		
		function ConvLength($number,$tps) {
			if ( $number == "Unlimited") { return _MD_XPW_UNLIMITED; }
			if ( !is_numeric($number) ) { return $number; }
			$number *= 1;
			if ($number == 0) { return "N/A"; }
			if ($number > 998) {return _MD_XPW_UNLIMITED;}
			if ($tps == 0) {
				$number = $number * 16.09;
				$number = (round ($number)) / 10;
				if ($number > 5)
				{
					$number = round ($number);
				}
				return "$number km";
			} else {
				return "$number mi";
			}
		}
		
		function ConvSpeed($number,$tps) {
			$number *= 1;
			if ($number == 0) { return ""; }
			if ($tps == 0) {
				$number = $number * 1.609;
				$number = $number / .36;
				$number = round ($number) / 10;
				return "$number m/s";
			} else {
				return "$number mph";
			}
		}
		
		function ConvReal($number,$tpc) {
			$number *= 1;
			if ($number == 0) { return "N/A"; }
			if ($tpc == 0) {
				$number = (5 / 9) * ($number - 32);
				$number = round ($number);
				return "$number&deg;C";
			} else {
				return "$number&deg;F";
			}
		}
		
		function Fore($numbers) {
			if ($numbers == "1") {
				$date=""._MD_XPW_WSUN."";
				return "$date";
			} elseif ($numbers == "2") {
				$date=""._MD_XPW_WMON."";
				return "$date";
			} elseif ($numbers == "3") {
				$date=""._MD_XPW_WTUE."";
				return "$date";
			} elseif ($numbers == "4") {
				$date=""._MD_XPW_WWED."";
				return "$date";
			} elseif ($numbers == "5") {
				$date=""._MD_XPW_WTHU."";
				return "$date";
			} elseif ($numbers == "6") {
				$date=""._MD_XPW_WFRI."";
				return "$date";
			} else {
				$date=""._MD_XPW_WSAT."";
				return "$date";
			}
		}
		
		function get_loc_data ($loc)
		{
			global $xoopsDB;
			
			$ret = array();
			
			$result = mysql_fetch_row($xoopsDB->query("SELECT * FROM ".$xoopsDB->prefix("xpweather_station")." WHERE loc='$loc' ORDER BY `reg_id` DESC LIMIT 1"));		
			
			if ($result)
			{
				list($reg_id, $ctry_id, $id, $loc, $name) = $result;	
				list($region) = mysql_fetch_row($xoopsDB->query("SELECT `name` FROM ".$xoopsDB->prefix("xpweather_region")." WHERE `reg_id`='$reg_id' LIMIT 1"));		
				list($country) = mysql_fetch_row($xoopsDB->query("SELECT `name` FROM ".$xoopsDB->prefix("xpweather_country")." WHERE `ctry_id`='$ctry_id' LIMIT 1"));		
		
				$ret =  array(
					"region" => array("id"=>$reg_id,"name"=>$region),
					"country" => array("id"=>$ctry_id,"name"=>$country),
					"station" => array("id"=>$loc,"name"=>$name)
					);
			}
			
			return $ret;
		}
		
		function get_local_name($name, $id, $cat="citys")
		{
			// 言語ファイルでローカライズ
			if (isset($this->v_Local[$cat][$id]))
			{
				return $this->v_Local[$cat][$id];
			}
			else
			{
				return $name;	
			}
		}
		
		function setcookie($wcid, $tpc, $tps)
		{
			$timeout = time() + 30 * 86400;// 30日
			setcookie("XPW_LOC","{$wcid}|{$tpc}|{$tps}",$timeout,'/');
		}
		
		function unlink_cache($wcid)
		{
			$dir = XOOPS_ROOT_PATH.'/modules/XP-Weather/cache';
			if ($handle = opendir($dir))
			{
				while (false !== ($file = readdir($handle)))
				{
					if (substr($file,0,1) == "." || $file == "index.html" || is_dir($dir."/".$file)) {continue;}
					if (substr($file,-8) == $wcid)
					{
						unlink($dir."/".$file);
					}
					if ((filemtime($dir."/".$file) + 3600 * 12) < time())
					{
						unlink($dir."/".$file);
					}
				}
				closedir($handle);
			}
		}
	
	}
}
?>