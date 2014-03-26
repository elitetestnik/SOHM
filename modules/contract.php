<?php
header("Content-Type: text/html;charset=utf-8");
session_start();
if (!isset($_SESSION['operator_id']))
{
    setcookie("operator_id","0");
    echo"<html><head><meta http-equiv='refresh' content='1;URL=index.php'><body>&nbsp;</body></html>";die;
}
$ip=$_SERVER ['REMOTE_ADDR'];
//if (!$link=$_SERVER ['HTTP_REFERER']) $link="";
setcookie("operator_id", $_SESSION['operator_id']);
setcookie("rights", md5($_SESSION['operator_id'].$ip));
if (isset($_REQUEST['task']))$task=$_REQUEST['task'];else $task='';
if (isset($_REQUEST['module']))$module=$_REQUEST['module'];else $module='';
if (isset($_REQUEST['action']))$action=$_REQUEST['action'];else $action='';
if (isset($_REQUEST['itemId']))$itemId=$_REQUEST['itemId'];else $itemId='';
if (isset($_REQUEST['id']))$id=$_REQUEST['id'];
else
{
    setcookie("operator_id","0");
    echo"<html><head><meta http-equiv='refresh' content='1;URL=/index.php'><body>&nbsp;</body></html>";die;
}
//$mosConfig_absolute_path = '/sata1/home/users/c-parta/www/www.c-parta.od.ua/norsk';
//$mosConfig_absolute_path = 'e:/wwwroot/norsk';
require_once("../config.php");
require_once($mosConfig_absolute_path."/globals.php" );
require_once($mosConfig_absolute_path."/includes/mambo.php" );
require_once($mosConfig_absolute_path. '/includes/frontend.php' );
$option = trim( strtolower( mosGetParam( $_REQUEST, 'option' ) ) );
$Itemid = intval( mosGetParam( $_REQUEST, 'Itemid', null ) );
$database = new database( $mosConfig_host, $mosConfig_user, $mosConfig_password, $mosConfig_db, $mosConfig_dbprefix );
$database->debug( $mosConfig_debug );
$acl = new gacl_api();
include($mosConfig_absolute_path."/includes/cls_fast_template.php");
$ft = new FastTemplate($mosConfig_absolute_path."/templates");
//$start = $ft->utime();     // Benchmarking






if ((isset($_REQUEST['lang']))&&($_REQUEST['lang']=='no')) $tpl="contract_no.tpl";else $tpl="contract_en.tpl";
$ft->define(
    array(
        'header'  => "header.tpl",
        'body'    => $tpl,
        'footer'  => "footer.tpl"
    )
);

global $database,$mosConfig_live_site;
		$database->setQuery( "set names utf8" );
		$database->query();

$query="select * from #__settings where id=".$_COOKIE['operator_id'];
$database->setQuery($query);
$setting = $database->loadObjectList(); foreach ($setting as $settings)     { }

if ($id>0) $database->setQuery( "SELECT *, date_format(contract_date,'%d/%m/%Y') as c_date, date_format(concert_date,'%d/%m/%Y') as a_date FROM #__contracts  where id=".$id );
$cs =$database->loadObjectList();
foreach ($cs as $c){}

if($c->p60artist==1)$c->p60artist="<img src='".$mosConfig_live_site."/images/y.gif' />";else $c->p60artist="<img src='".$mosConfig_live_site."/images/n.gif' />";
if($c->p60csten==1)$c->p60csten="<img src='".$mosConfig_live_site."/images/y.gif' />";else $c->p60csten="<img src='".$mosConfig_live_site."/images/n.gif' />";
if($c->p60sten==1)$c->p60sten="<img src='".$mosConfig_live_site."/images/y.gif' />";else $c->p60sten="<img src='".$mosConfig_live_site."/images/n.gif' />";

$ft->assign( array(
//$c->id      $c->contract_date   $c->id_artist   $c->id_promoter      $c->id_perfomance
  //    $c->acc_info   $c->id_sound          $c->sound_phone2                               $c->status        $c->p60artist   $c->p60csten   $c->p60sten
                       'TITLE'       =>  " Contract N&deg;".$c->contract_no,
                       'CONTRACT_NO' => $c->contract_no,
                       'CONTRACT_DATE' => $c->contract_date,
                       'A_DATE' => $c->a_date,
                       'C_DATE' => $c->c_date,
                       'ARTIST' =>      $c->artist  ,
                       'PROMOTER' =>  $c->promoter,
                       'VENUE' =>  $c->venue,
                       'CAPACITY' =>  $c->capacity,
                       'CONTACT_PERSON' =>$c->contact_person,
                       'ADDRESS' =>$c->address,
                       'TOWN' =>$c->town,
                       'PHONE1' =>$c->phone1 ,
                       'PHONE2' =>$c->phone2 ,
                       'EMAIL' => $c->email ,
                       'CONCERT_DATE' =>$c->concert_date,
                       'ART_OF' =>$c->art_of_perf ,
                       'ACCESS_TO_STAGE' =>   $c->acc_to_stage,
                       'SOUND_CHECK' =>$c->sound_check ,
                       'DOORS_OPEN' =>$c->doors_open ,
                       'CONCERT_START' =>$c->concert_start,
                       'LENGTH' =>$c->lenght_of,
                       'PUBLICITY' =>$c->publicity ,
                       'ARTIST_FEE' =>number_format( $c->artist_fee, 0, ',', '.'),
                       'TRAVEL_EXP' =>number_format( $c->travel_exp, 0, ',', '.'),
                       'PROD_EXP' =>number_format( $c->production_exp, 0, ',', '.'),
                       'ADMIN_EXP' =>number_format( $c->admin_exp, 0, ',', '.'),
                       'OTHER_EXP' =>number_format( $c->other_exp, 0, ',', '.'),
                       'TOTAL_EXP' =>number_format( $c->total_exp, 0, ',', '.'),
                       'FOLLOWS' =>$c->pay_follows,
                       'PAYED' =>$c->exp_prom_other,
                       'SOUND' =>$c->sound_name ,
                       'SOUND_CONTACT' =>$c->sound_contact,
                       'SOUND_EMAIL' =>  $c->sound_email,
                       'SOUND_PHONE1' =>  $c->sound_phone1,
                       'SOUND_PHONE2' =>  $c->sound_phone2,
                       'P601' => $c->p60artist,
                       'P602' => $c->p60csten,
                       'P603' => $c->p60sten,
                       'ISSUE_DATE' => $c->issue_date,
                       'CURRENCY' => $c->currency,
                       'BANK_ACC_MAIN' => $settings->bankaccount,
                       'FOOTER2' => $settings->footer2,
                       'PRINTBUTTON' => '<a href="#" onclick="javascript:window.print(); return false;" title="Print this contract">
<img src="/norsk/images/printbutton.png"  alt="Print this contract" name="Print this contract" align="right" border="0" />
</a>'
            ) );

$ft->parse('HEAD', "header");
$ft->parse('BODY', "body");
$ft->parse('FOOT', "footer");

// $ft->clear(array("HEAD","BODY"));   // Uncomment this to see how
                                        // the class handles errors

    $ft->showDebugInfo(2);
$ft->FastPrint("HEAD");
$ft->FastPrint("BODY");
$ft->FastPrint("FOOT");

//$end = $ft->utime();
//$runtime = ($end - $start) * 1000;
//echo "Completed in $runtime seconds<BR>\n";

exit; ?>