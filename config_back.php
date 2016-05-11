<?PHP
// config.php  18.02.2008

$cfg['database']='backtrackno';
$cfg['username']='backtrackno';
$cfg['password']='PRUFIRI58';
$cfg['hostname']='sql27.webhuset.no';
$cfg['debug']=true;

//include ('modules/xajax/xajaxResponse.inc.php');
$current_continent='Europe';
$mosConfig_offline = '0';
$mosConfig_host = 'sql27.webhuset.no';
$mosConfig_user = 'backtrackno';
$mosConfig_password = 'PRUFIRI58';
$mosConfig_db = 'backtrackno';
$mosConfig_dbprefix = 'nor_';
$mosConfig_lang = 'russian';
$mosConfig_absolute_path = '/home/B/backtrackno/www/sohm';
$mosConfig_live_site = 'http://back-track.no/sohm';
$mosConfig_sitename = 'Classified Database';
$mosConfig_shownoauth = '0';
$mosConfig_useractivation = '1';
$mosConfig_uniquemail = '1';
$mosConfig_offline_message = '���� �������� ������.<br />����������, ������� �����.';
$mosConfig_error_message = '���� ����������.<br />����������, �������� �� ���� ��������������';
$mosConfig_debug = '0';
$mosConfig_lifetime = '900';
$mosConfig_MetaDesc = 'Classified database';
$mosConfig_MetaKeys = '';
$mosConfig_MetaAuthor = '1';
$mosConfig_MetaTitle = '1';
$mosConfig_locale = 'ru_RU.CP1251';
$mosConfig_offset = '0';
$mosConfig_hideAuthor = '1';
$mosConfig_hideCreateDate = '0';
$mosConfig_hideModifyDate = '1';
$mosConfig_hidePdf = '1';
$mosConfig_hidePrint = '1';
$mosConfig_hideEmail = '1';
$mosConfig_enable_log_items = '1';
$mosConfig_enable_log_searches = '1';
$mosConfig_enable_stats = '1';
$mosConfig_sef = '0';
$mosConfig_vote = '0';
$mosConfig_gzip = '0';
$mosConfig_multipage_toc = '1';
$mosConfig_allowUserRegistration = '1';
$mosConfig_link_titles = '0';
$mosConfig_error_reporting = '-1';
$mosConfig_list_limit = '15';
$mosConfig_caching = '0';
$mosConfig_cachepath = '/home/B/backtrackno/www/sohm/cache';
$mosConfig_cachetime = '900';
$mosConfig_mailer = 'mail';
$mosConfig_mailfrom = '';
$mosConfig_fromname = 'Classified database';
$mosConfig_sendmail = '/usr/sbin/sendmail';
$mosConfig_smtpauth = '0';
$mosConfig_smtpuser = '';
$mosConfig_smtppass = '';
$mosConfig_smtphost = 'localhost';
$mosConfig_back_button = '1';
$mosConfig_item_navigation = '1';
$mosConfig_secret = 'UWnX1Zch6sZRVKsk';
$mosConfig_pagetitles = '1';
$mosConfig_readmore = '1';
$mosConfig_hits = '1';
$mosConfig_icons = '0';
$mosConfig_favicon = 'favicon.ico';
$mosConfig_fileperms = '';
$mosConfig_dirperms = '';
$mosConfig_mbf_content = '0';
$mosConfig_helpurl = 'http://help.ru-mambo.ru';
$SMS_TEST_MODE="no";
//$mosConfig_smsuser = 'stenolav';
//$mosConfig_smspaswd = 'helgeland';
$mosConfig_smsuser = 'stenolavhelgeland';
$mosConfig_smspaswd = 'olav1954';
$mosConfig_sender = '4797711025';


date_default_timezone_set('Europe/Oslo');
 
setlocale (LC_TIME, $mosConfig_locale);
if (!defined('config_loaded')) DEFINE('config_loaded',TRUE);
if (!defined('_VALID_MOS')) DEFINE('_VALID_MOS',TRUE);
//include ('modules/xajax/xajax.inc.php');

function data_convert ($data, $year, $time, $second, $direction=1){
$res = "";
$part = explode(" " , $data);
if ($direction) $ymd = explode ("/", $part[0]);else  $ymd = explode ("-", $part[0]);
if (isset($part[1]))$hms = explode (":", $part[1]); else $hms = explode (":", "00:00:00");
if ($year == 1)
	{	if($direction) {$res .= $ymd[2]; $res .= "-".$ymd[1]; $res .= "-".$ymd[0];}
				  else {$res .= $ymd[2]; $res .= "/".$ymd[1]; $res .= "/".$ymd[0];}
}
if ($time == 1) {$res .= " ".$hms[0]; $res .= ":".$hms[1]; if ($second == 1) $res .= ":".$hms[2];}
return $res;
}


?>