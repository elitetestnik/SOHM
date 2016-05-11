<?php
//header("Content-Type: text/html;charset=utf-8");
session_start();

//error_reporting(E_ALL);ini_set('display_errors', 1);
/*
if (!isset($_SESSION['operator_id']))
{
    setcookie("operator_id","0");
    echo"<html><head><meta http-equiv='refresh' content='1;URL=index.php'><body>&nbsp;</body></html>";die;
}
*/
$ip=$_SERVER ['REMOTE_ADDR'];
//if (!$link=$_SERVER ['HTTP_REFERER']) $link="";
setcookie("operator_id", $_SESSION['operator_id']);
setcookie("rights", md5($_SESSION['operator_id'].$ip));
if (isset($_REQUEST['id']))$id=intval($_REQUEST['id']);
else
{
    setcookie("operator_id","0");
    echo"<html><head><meta http-equiv='refresh' content='1;URL=/index.php'><body>&nbsp;</body></html>";die;
}
require_once("../config.php");
require_once($mosConfig_absolute_path."/modules/main.php" );
require_once($mosConfig_absolute_path."/globals.php" );
require_once($mosConfig_absolute_path."/includes/mambo.php" );
require_once($mosConfig_absolute_path. '/includes/frontend.php' );
$option = trim( strtolower( mosGetParam( $_REQUEST, 'option' ) ) );
$Itemid = intval( mosGetParam( $_REQUEST, 'Itemid', null ) );
$database = new database( $mosConfig_host, $mosConfig_user, $mosConfig_password, $mosConfig_db, $mosConfig_dbprefix );
$database ->debug( $mosConfig_debug );

//if(isset($_GET['pdf_fetch']))exit('pdf_fetch');

if(($_GET['id']) && (isset($_GET['lang'])) && (!isset($_GET['pdf_fetch']))){
    $html = file_get_contents($mosConfig_live_site.'/modules/invoice.php?lang='.$_GET['lang'].'&id='. intval($_GET['id']).'&date='.$_GET['date'].'&pdf_fetch=1');
    $html = preg_replace("~<div id=\"print\">.*?</div>~SDs", '', $html);
    $html = preg_replace("~<head>.*?</head>~SDs", '', $html);
    //$html = preg_replace("~<style>.*?</style>~SDs", '', $html);
    $html = str_replace('<body>', '', $html);
    $html = str_replace('</body>', '', $html);
    
    $pdf_patch = make_pdf($html, 'invoice-'.$_GET['lang'].'_'.intval($_GET['id']).'.pdf');
    
}

$acl = new gacl_api();
include($mosConfig_absolute_path."/includes/cls_fast_template.php");
$ft = new FastTemplate($mosConfig_absolute_path."/templates");
//if ((isset($_REQUEST['lang']))&&($_REQUEST['lang']=='no')) $tpl="invoice_no.tpl";else $tpl="invoice_en.tpl";
$tpl=file_exists($mosConfig_absolute_path.'/templates/invoice_'.$_GET['lang'].'.tpl')?'invoice_'.$_GET['lang'].'.tpl':"invoice_en.tpl";
$ft->define(
    array(
        'body'    => $tpl    )
);
//global $database,$mosConfig_live_site;
		$database->setQuery( "set names utf8" );
		$database->query();

$query="select * from #__settings where id=".$_COOKIE['operator_id'];
$database->setQuery($query);
$setting = $database->loadObjectList(); foreach ($setting as $settings)     { }
if ($id>0) $database->setQuery( "SELECT *, date_format(a.contract_date,'%d/%m/%Y') as c_date, date_format(a.concert_date,'%d/%m/%Y') as a_date,coalesce(( SELECT GROUP_CONCAT( date_format(z.date,'%d/%m/%Y') ORDER BY z.date ASC SEPARATOR ', ') from #__cont_dates z where z.cont_id = a.id),' ') as ddates, coalesce(( SELECT GROUP_CONCAT( date_format(r.date,'%Y-%m-%d') ORDER BY r.date ASC SEPARATOR ', ') from #__cont_dates r where r.cont_id = a.id),' ') as edates FROM #__contracts a where a.id=".$id );
$cs =$database->loadObjectList();
$query="select p.*,(select m.name from #__countries m where p.country=m.id) as country_name from #__promoters p where p.id in (select c.id_promoter from #__contracts c where c.id=".$id.") limit 1";
$database->setQuery($query);
$pr =$database->loadObjectList();
foreach ($pr as $pd){}
foreach ($cs as $c){}
if($c->ddates>" ")$c->ddates=", ".$c->ddates;
if($c->edates>" ")$c->edates=", ".$c->edates;

if(!isset($_REQUEST['date'])){ $script=" onload='javascript:ask_date();return false;'"; 
$script2= "<script>
ask_date=function() {
 var date=prompt(\"Please enter terms date\",\"".date('Y-m-d')."\");
 window.location='".$_SERVER['REQUEST_URI']."&date='+date;
}
</script>";
$script3="<script>
ask_date=function(){var date=prompt(\"Forfall dato\",\"".date('Y-m-d')."\");window.location='".$_SERVER['REQUEST_URI']."&date='+date;}
</script>";
}else $script=$script2=$script3="";



$ft->assign( array(
//$c->id      $c->contract_date   $c->id_artist   $c->id_promoter      $c->id_perfomance
  //    $c->acc_info   $c->id_sound          $c->sound_phone2                               $c->status        $c->p60artist   $c->p60csten   $c->p60sten
                       'TITLE'       =>  " Contract N&deg;".$c->contract_no,
                       'URL'=>$_SERVER['REQUEST_URI'],
                       'CONTRACT_NO' => $c->contract_no,
                       'CONTRACT_DATE' => $c->contract_date,
                       'A_DATE' => $c->a_date.$c->ddates,
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
                       'CONCERT_DATE' =>$c->concert_date.$c->edates,
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
                       'ISSUE_DATE' => $c->issue_date,
                       'CURRENCY' => $c->currency,
                       'PNAME' => $pd->name,
                       'PPERS' => $pd->contact_person,
                       'PADR1' => $pd->street_addr1,
                       'PADR2' => $pd->street_addr2,
                       'PADR3'  => $pd->city_code."&nbsp;&nbsp;".$pd->town,
                       'PCOUNTRY'  => $pd->country_name,
                       'SCRIPT' => $script,
                       'LOGO_PATCH' => $mosConfig_live_site.'/modules',
  'SCRIPT2' =>  $script2,
  'SCRIPT3' =>  $script3,
                       'TERMS'=>$_REQUEST['date'],
                       'BANK_ACC_MAIN' => $settings->bankaccount,
                       'FOOTER2' => $settings->footer2,
                       'PRINTBUTTON' => '<a href="#" onclick="javascript:window.print(); return false;" title="Print this contract">
<img src="'.$mosConfig_live_site.'/images/printbutton.png"  alt="Print this contract" name="Print this contract" align="right" border="0" />
</a>',
                       'SENDBUTTON' => '<a href="'.$mosConfig_live_site.'/index2.php?newmaildocid='. $id . '&newmailpromouter='.$c->id_promoter.'&lang='.$_REQUEST['lang'].'&doctype=invoice&date='.$_REQUEST['date'].'doctype=invoice" title="send by email">
<img src="'.$mosConfig_live_site.'/images/forward-new-mail-24x24.png"  alt="" name="Print this contract" align="right" border="0" />
</a>
<!--
<label for = "include_reder">
  Include Rider <input type = "checkbox" id ="include_reder"/>
</label>
-->
',
                      'LINKBUTTON' => '<a href="'.$mosConfig_live_site.'/attachments/pdf/invoice-'.$_REQUEST['lang'].'_'.$id.'.pdf"  title="Invoice in PDF">
<img src="'.$mosConfig_live_site.'/images/pdf-24x24.png"  alt="Invoice in PDF" name="Invoice in PDF" align="right" border="0" />
</a>' 
            ) );
 
//onclick="javascript:message_form_contract(0,2,'.$c->promoter.',1,'.$id.'); return false;"
$ft->parse('BODY', "body");
$ft->FastPrint("BODY");


exit; ?>