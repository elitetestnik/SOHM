<?php

if( isset( $_REQUEST['xajax'] ) || isset( $_POST['xajax'] ) || isset( $_GET['xajax'] ) ) {
		//вызов функций xajax. нужно инициализировать движок Joomla
if (!defined('_VALID_MOS')) define( '_VALID_MOS', 1 );

$mosConfig_absolute_path = 'c:/webservers/home/norsk/www';
//$mosConfig_absolute_path = 'e:/wwwroot/norsk';
		require_once($mosConfig_absolute_path."/globals.php" );
		require_once($mosConfig_absolute_path."/config.php");
		require_once($mosConfig_absolute_path."/includes/mambo.php" );
        require_once($mosConfig_absolute_path."/modules/calendar.php" );
		$database = new database( $mosConfig_host, $mosConfig_user, $mosConfig_password, $mosConfig_db, $mosConfig_dbprefix );
		$database->debug( $mosConfig_debug );
		$acl = new gacl_api();

} else {
		defined( '_VALID_MOS' ) or die( 'Прямой доступ к файлам по этому адресу запрещен!' );
	global $mosConfig_absolute_path, $mosConfig_live_site, $database;
}

if( !defined ('XAJAX_DEFAULT_CHAR_ENCODING') ) include_once($mosConfig_absolute_path."/includes/xajax/xajax.inc.php");



function getInq2($inq_id)
{
global $database;$database->setQuery( "set names cp1251" );$database->query(); 
if($inq_id>0){
$qr="SELECT * FROM inquiries WHERE id=".$inq_id ;
$database->setQuery( $qr);
$inqs = array();
$inqs = $database->loadObjectList();
  if (sizeof($inqs)>0)     { 	foreach ($inqs as $inq) { 
  
       $database->setQuery( "update inquiries set status=1 WHERE id=".$inq_id );
		$database->query();
			}  
   }
}
$result="
<TABLE align='center' valign='middle' width='100%' height='100%' cellpadding=0 cellspacing=0 border=0>
<TR>
	<TD>
<TABLE style='border:15px white solid;background-color: #eeeeee;' align='center' valign='middle' cellpadding=0 cellspacing=0>
<TR>
	<TD>
<TABLE class='h3' style='border:1px gray solid;background-color: #eeeeee;'><TR><td colspan=2 align='right'><button onclick='javascript:hideInfo2();'><IMG SRC='/ico/action_delete.png' WIDTH='16' HEIGHT='16' BORDER='0' ALT=''></button></td></TR>
<TR><TH colspan=2 class='h2'>";
if ($inq_id==0) $result.="Add Inquiry"; else $result.="Update Inquiry";
$result.="</TH>
</TR><TR><TD valign='top'  class='h1'>
<FORM METHOD=POST onsubmit='return check_this_form(this);' ACTION=\"javascript:getFormData2(xajax.getFormValues('add_inq'));\" name='add_inq' id='add_inq'>
<input type='hidden' name='id' value='";
$result.=$inq_id;
$result.="'>
<TABLE>
<TR>
	<TD>Artist</TD><TD>";
$artists = array();
$database->setQuery( "SELECT id, name FROM artists  where status >= 0 ORDER BY id" );
$artists = $database->loadObjectList();
if (isset($inq->id_artist)) $cnt=$inq->id_artist; else $cnt=1;
$cnt_list = mosHTML::selectList( $artists, 'id_artist', ' id="id_artist" ', 'id', 'name', $cnt );
$result.=$cnt_list;


$result.="</TD>
	<TD>Town</TD><TD><INPUT TYPE='text' NAME='town' size='20'  required='1' value='";
if (isset($inq->town)) $result.=$inq->town; else $result.="";
$result.="'></TD>
</TR>
<TR>
	<TD>Venue date</TD><TD nowrap><INPUT TYPE='text' NAME='venue_date'  required='1' id='venue_date' size='20' value='";

if (isset($inq->venue_date)) $result.=substr_replace($inq->venue_date,'',16,16); else $result.="";
$result.="'>&nbsp; <a href='#' onclick='javascript:cal1xx.select(document.getElementById(\"venue_date\"),\"anchor1xx\",\"yyyy-MM-dd\");return false;'  NAME='anchor1xx' ID='anchor1xx'><img src='/images/calendar.gif' border=0> </a></TD>
	<TD>Country</TD><TD><INPUT TYPE='text' NAME='country' size='20' value='";
if (isset($inq->country)) $result.=$inq->country; else $result.="";
$result.="'></TD>
</TR>
<TR>
	<TD>Company</TD><TD><INPUT TYPE='text' NAME='company' size='20' required='1' value='";
if (isset($inq->company)) $result.=$inq->company; else $result.="";
$result.="'></TD>
	<TD>Local phone</TD><TD><INPUT TYPE='text' NAME='phone1' size='20'  required='1' value='";
if (isset($inq->phone1)) $result.=$inq->phone1; else $result.="";
$result.="'></TD>
</TR>
<TR>
	<TD>Contact person</TD><TD><INPUT TYPE='text' NAME='contact_person' size='20'  required='1' value='";
if (isset($inq->contact_person)) $result.=$inq->contact_person; else $result.="";
$result.="'></TD>
	<TD>Cell phone</TD><TD><INPUT TYPE='text' NAME='phone2' size='20' value='";
if (isset($inq->phone2)) $result.=$inq->phone2; else $result.="";
$result.="'></TD>
</TR>
<TR>
	<TD>Street address 1</TD><TD><INPUT TYPE='text' NAME='address1' size='20' value='";
if (isset($inq->address1)) $result.=$inq->address1; else $result.="";
$result.="'></TD>
	<TD>Email</TD><TD><INPUT TYPE='text' NAME='email' size='20'  required='1' email='1' value='";
if (isset($inq->email)) $result.=$inq->email; else $result.="";
$result.="'></TD>
</TR>
<TR>
	<TD>Street address 2</TD><TD><INPUT TYPE='text' NAME='address2' size='20' value='";
if (isset($inq->caddress2ity)) $result.=$inq->address2; else $result.="";
$result.="'></TD>
	<TD>Website</TD><TD><INPUT TYPE='text' NAME='www' size='20' value='";
if (isset($inq->www)) $result.=$inq->www; else $result.="";
$result.="'></TD>
</TR>
<TR>
	<TD>City code</TD><TD><INPUT TYPE='text' NAME='city_code' size='20' value='";
if (isset($inq->city_code)) $result.=$inq->city_code; else $result.="";
$result.="'></TD>
	<TD>&nbsp;</TD><TD>&nbsp;</TD>
</TR>
<TR>
	<TD>Comments</TD><TD colspan=3><TEXTAREA NAME='comments' ROWS='4' COLS='48'>";
if (isset($inq->comments)) $result.=$inq->comments; else $result.="";
$result.="</TEXTAREA></TD>
</TR>
<TR>
	<TD colspan=4 align='center'><INPUT TYPE='submit' value='Save' type='button'></TD>
</TR>
</TABLE></FORM>
</TD></TR></TABLE></TD></TR></TABLE></TD></TR></TABLE>";

$objResponse = new xajaxResponse('windows-1251');
$objResponse->addAssign( 'inq_info', 'innerHTML', $result );
return $objResponse->getXML();
}


function getFormData2($fdatas){

$result='';
$objResponse = new xajaxResponse('windows-1251');
foreach ($fdatas as $key => $fdata) {
$fdatas[$key] = addslashes(strip_tags(mb_convert_encoding($fdata,'windows-1251',"UTF-8")));
//$result.="'".$key."'=>'".$fdatas[$key]."'<br/>";
}

$query="insert into  inquiries  (
`id_artist`,
`country`,
`town`,
`company`,
`phone1`,
`contact_person`,
`phone2`,
`address1`,
`email`,
`address2`,
`www`,
`city_code`,
`comments`,
`venue_date`,
`status`, 
`whosupdate`,
`inq_date`
)
values (
".$fdatas['id_artist'].",\"".$fdatas['country']."\",\"".$fdatas['town']."\",\"".$fdatas['company']."\",\"".$fdatas['phone1']."\",
\"".$fdatas['contact_person']."\",\"".$fdatas['phone2']."\",\"".$fdatas['address1']."\",\"".$fdatas['email']."\",\"".$fdatas['address2']."\",\"".$fdatas['www']."\",\"".$fdatas['city_code']."\",\"".$fdatas['comments']."\",";

if (trim($fdatas['venue_date'])=='') $query.="NULL,";else $query.="\"".$fdatas['venue_date']."\",";

$query.=" 0,-1,CURRENT_TIMESTAMP)";
$result.=$query;
global $database;
		$database->setQuery( "set names cp1251" );
		$database->query();
		$database->setQuery( $query );
		$database->query();
$result="<font color='white'>Your inquiry was saved! We will call you a.s.a.p!</font>";
$objResponse->addAssign( 'banner', 'innerHTML', $result );
$objResponse->addAlert( 'Saved successfully!' );
return $objResponse->getXML();
}



	$objAjax = new xajax($mosConfig_live_site."/modules/info.php","inf_","windows-1251", false);
	$objAjax->registerFunction('getInq2');
	$objAjax->registerFunction('getFormData2');
	$objAjax->processRequests();
	$objAjax->printJavascript( $mosConfig_live_site."/includes/xajax/" );


?>

<script language="javascript" type="text/javascript">
		var itemids = new Array;
			function getInq2( id ) {
			try {

				document.getElementById('inq_info').style.display='block';
				xajaxRequestUri= '<?php echo $mosConfig_live_site; ?>/modules/info.php';
				xajaxDebug=false,xajaxStatusMessages=false,xajaxWaitCursor=true,xajaxDefinedGet=0,xajaxDefinedPost=1;
				inf_getInq2( id );
			} catch( e ) {
				alert( e );
			}
		}
		function getFormData2(  pdate ) {
			try {
				document.getElementById('inq_info').innerHTML="&nbsp;";
				document.getElementById('inq_info').style.display ='none';
				xajaxRequestUri= '<?php echo $mosConfig_live_site; ?>/modules/info.php';
				xajaxDebug=false,xajaxStatusMessages=false,xajaxWaitCursor=true,xajaxDefinedGet=0,xajaxDefinedPost=1;
				inf_getFormData2( pdate  );
			} catch( e ) {
				alert( e );
			}
		}
		function hideInfo2( ) {
			try {
			    document.getElementById('inq_info').innerHTML="&nbsp;";
				document.getElementById('inq_info').style.display ='none';
			} catch( e ) {
				alert( e );
			}
		}
function check_this_form(f){
  var errMSG = "";

  var reg_mail = /[0-9a-z_]+@[0-9a-z_^.]+.[a-z]{2,3}/i;
  for (var i = 0; i<f.elements.length; i++){
       if (null!=f.elements[i].getAttribute("required")) {
       if (isEmpty(f.elements[i].value)) {
         errMSG += "  " + f.elements[i].name + "\n";
            f.elements[i].style.border='1px red solid';
         }
       if ((null!=f.elements[i].getAttribute("email"))&&(reg_mail.exec(f.elements[i].value) == null))
            {
                  errMSG += " Invalid e-mail address  " + f.elements[i].name + "\n";
             f.elements[i].style.border='1px red solid';
             f.elements[i].focus();
                }
          }
        }
        if ("" != errMSG) {
               alert("Please, complete required fields:\n" + errMSG);
               return false;
       }
        return true;
}

function isEmpty(str){
   for (var i = 0; i < str.length; i++) if (" " != str.charAt(i)) return false;
   return true;
}

</script>