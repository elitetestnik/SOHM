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
$ft->define(
    array(
        'header'  => "header2.tpl",
        'body'    => "itn2.tpl",
        'footer'  => "footer.tpl"
    )
);

global $database,$mosConfig_live_site;
		$database->setQuery( "set names utf8" );
		$database->query();

$query="select * from #__settings where id=".$_COOKIE['operator_id'];
$database->setQuery($query);
$setting = $database->loadObjectList(); foreach ($setting as $settings)     { }

$database->setQuery( "SELECT *, date_format(contract_date,'%d/%m/%Y') as c_date, date_format(concert_date,'%d/%m/%Y') as a_date FROM #__contracts  where id=".$id );
$cs =$database->loadObjectList();
$database->setQuery( "SELECT * FROM #__perfomances  where contract_id=".$id );
$pf =$database->loadObjectList();
$database->setQuery( "SELECT * FROM #__itinerary  where id_contract=".$id." order by id asc" );
$if =$database->loadObjectList();
foreach ($cs as $c){}
$database->setQuery( "SELECT * FROM #__promoters  where id=".$c->id_promoter);
$pd =$database->loadObjectList();
foreach ($pd as $pp){}
foreach ($pf as $p){}
$itt="";
foreach ($if as $i){
$itt.="	<tr>
							<td>
								Dep.</td>
							<td>
								".$i->place_dep."</td>
							<td>
								".$i->departure."</td>
							<td rowspan='2'>
								".$i->transportation."</td>
							<td rowspan='2'>
								".$i->flighttrainno."</td>
						</tr>
						<tr>
							<td>
								Arr.</td>
							<td>".$i->place_arr."</td>
							<td>
								".$i-> arrival."</td>

						</tr>";


}

//  print_r($p);
$ft->assign( array(
                      'TITLE'       =>  "Itinerary for contract N&deg;".$c->contract_no,
                       'CONTRACT_NO' => $c->contract_no,
                       'CONTRACT_DATE' => $c->contract_date,
                       'A_DATE' => $c->a_date,
                       'ID' => $c->id,
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
                       'ACCESS_TO_STAGE' =>   $p->getintime,
                       'SOUND_CHECK' =>$p->soundcheck ,
                       'DOORS_OPEN' =>$p->doorsopen ,
                       'CONCERT_START' =>$p->onstage,
                       'DINNER' =>$p->dinner,
                       'LENGTH' =>$p->perf_duration,
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
 	  				   'HOTEL'   => $p->hotel,
	  				   'HOTEL_ADDR' => $p->hotel_street,
	  				   'HOTEL_PHONE' => $p->hotel_phone,
	  				   'HOTEL_CITY' => $p->hotel_city,
      	      		   'HOTEL_EMAIL' => $p->hotel_email,

                       'V_ADDR' => $p->venue_street,
	  				   'V_PHONE' => $p->venue_phone,
	  				   'V_CITY' => $p->city,
      	      		   'V_COUNTRY' => $p->country,
                       'V_EMAIL' => $p->venue_email,
      	      		   'PRESSCONF' => $p->pressconf,
                       'ITT' => $itt,
                       'BANK_ACC_MAIN' => $settings->bankaccount,
                       'FOOTER2' => $settings->footer2,
                       'PR_ADD1' => $pp->street_addr1,
                       'PR_ADD2' => $pp->street_addr2,
                       'PR_TOWN' => $pp->town,
                       'PR_CCODE' => $pp->city_code
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