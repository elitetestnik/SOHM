<?php
session_start();
if (!isset($_SESSION['operator_id'])) {
    setcookie("operator_id","0");
    echo"<html><head><meta http-equiv='refresh' content='1;URL=index.php'><body>&nbsp;</body></html>";die;
}

$ip=$_SERVER ['REMOTE_ADDR'];

//if (!$link=$_SERVER ['HTTP_REFERER']) $link="";

setcookie("operator_id", $_SESSION['operator_id']);
setcookie("rights", md5($_SESSION['operator_id'].$ip));
setcookie('prev',"");
setcookie('now',"");
global $mosConfig_list_limit;

if (isset($_REQUEST['task']))$task=$_REQUEST['task'];else $task='';
if (isset($_REQUEST['module']))$module=$_REQUEST['module'];else $module='';
if (isset($_REQUEST['action']))$action=$_REQUEST['action'];else $action='';
if (isset($_REQUEST['itemId']))$itemId=$_REQUEST['itemId'];else $itemId='';
require_once("config.php");
require_once($mosConfig_absolute_path."/globals.php" );
require_once($mosConfig_absolute_path."/includes/mambo.php" );

if (file_exists(  $mosConfig_absolute_path.'/components/com_sef/sef.php' )) {
	require_once( $mosConfig_absolute_path.'/components/com_sef/sef.php' );
} else {
	require_once( $mosConfig_absolute_path.'/includes/sef.php' );
}
require_once($mosConfig_absolute_path. '/includes/frontend.php' );



/** retrieve some expected url (or form) arguments */
$option = trim( strtolower( mosGetParam( $_REQUEST, 'option' ) ) );
$Itemid = intval( mosGetParam( $_REQUEST, 'Itemid', null ) );
$database = new database( $mosConfig_host, $mosConfig_user, $mosConfig_password, $mosConfig_db, $mosConfig_dbprefix );
$database->debug( $mosConfig_debug );
mysql_set_charset("utf8");  
$acl = new gacl_api();
if ((isset($_COOKIE['operator_id']))&&($_COOKIE['operator_id']>0)){
$query=" select * from settings  where id=".$_COOKIE['operator_id'];
$database-> setQuery( $query );
$settings = $database->loadObjectList();
if (sizeof($settings)>0) {
foreach ($settings as $setting){
$_COMPANY_NAME=$setting->company_name;
$_BANKACCOUNT=$setting->bankaccount;
$_UNDERWRITER=$setting->underwriter;
$_EMAIL=$setting->email;
$_PERPAGE=$setting->perpage;
$_FOOTER1=$setting->footer1;
}
}
}else{
$_COMPANY_NAME = "Webserver";
$_BANKACCOUNT = "Please, update settings";
$_UNDERWRITER = "Please, Update Settings";
$_EMAIL = "webserver@c-parta.od.ua";
$_PERPAGE = 10;
$_FOOTER1= "<p><i>With regars, Your <b>WebServer.</b></i></p>";
}
/*<script type="text/javascript" src="includes/jquery-1.4.4.min.js"></script>
<script type="text/javascript" src="includes/jquery.flash.js"></script>
<script type="text/javascript" src="includes/jquery.jqUploader.js"></script>*/
?>
<!DOCTYPE html>
<html DIR="LTR">
 <head>
<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
<meta http-equiv="content-type" content="text/html; charset=UTF-8" />

  <title>:: Administration ::</title>
<link href="css.css" rel="stylesheet" type="text/css" />
<script LANGUAGE="JavaScript" SRC="includes/calendarpopup.js"></script>
<script LANGUAGE="JavaScript" SRC="askdate.js"></script>
<script type="text/javascript" src="includes/ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="includes/AjexFileManager/ajex.js"></script>
<script LANGUAGE="JavaScript" SRC="includes/date.js"></script>
<script LANGUAGE="JavaScript">document.write(getCalendarStyles());</script>
<script type="text/javascript">
    
var cal1xx = new CalendarPopup('testdiv1');
cal1xx.setWeekStartDay(1);
cal1xx.showNavigationDropdowns();
var cal2xx = new CalendarPopup('testdiv2');
cal2xx.setWeekStartDay(1);
cal2xx.showNavigationDropdowns();
var ckeditor;
</SCRIPT>
<?php
require_once ($mosConfig_absolute_path.'/modules/main.php');
?>
<?    /*
$f = fsockopen("code.jquery.com", 80, $errno, $errstr, 30);
if(!$f){
echo '<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js" type="text/javascript"></script>'; }
else {
echo '<script src="http://code.jquery.com/jquery-1.6.4.min.js" type="text/javascript"></script>'; }
*/
?>
 <script src="http://code.jquery.com/jquery-latest.js"></script>
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
<script type="text/javascript" src="label.js"></script>
<script type="text/javascript">
  var geocoder;
  var map;
  var markersArray = [];
  var poly =[];

  function initializemap() {


   var polyOptions = {
    strokeColor: '#FF3333',
    strokeOpacity: 1.0,
    strokeWeight: 2
  }

    markersArray = [];
    geocoder = new google.maps.Geocoder();
    var latlng = new google.maps.LatLng(-34.397, 150.644);
    var myOptions = {
      zoom: 11,
      center: latlng,
      mapTypeId: google.maps.MapTypeId.ROADMAP
    }
    map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
    poly = new google.maps.Polyline(polyOptions);
    poly.setMap(map);

  }

  function codeAddress() {
    var address = document.getElementById("address").value;
    geocoder.geocode( { 'address': address}, function(results, status) {
      if (status == google.maps.GeocoderStatus.OK) {
        map.setCenter(results[0].geometry.location);
        var marker = new google.maps.Marker({
            map: map,
            position: results[0].geometry.location
        });
        document.getElementById("geocode").value=results[0].geometry.location;
      } else {
        alert("Geocode was not successful for the following reason: " + status);
      }
    });
  }
 function viewAddress(lt,lg)
 {          //alert("22");

        var ltlg = new google.maps.LatLng(lt,lg);
      //  latlng = coords;
        map.setCenter(ltlg);
        var marker = new google.maps.Marker({
             zoom: 11,
            map: map,
            position: ltlg
        });
 }

//      var marker2 = new ({

function show_the_map(){


  $('#inqlist22').toggle();
  if ($('#inqlist22').is(":hidden")== false ){
  $('#map_canvas').height('500px');

  }else{
  $('#map_canvas').height('800px');
    }
//document.getElementById('inqlist22').style='display:none';
set_zoomc();
return false;
}

function addMarker(lt,lg) {
 var location = new google.maps.LatLng(lt,lg);
  marker = new google.maps.Marker({
    position: location,
    map: map
  });
  markersArray.push(marker);
  set_zoomc();
}

function addTextMarker(lt,lg,text) {
// if((text=="")||(text=="undefined")||(text=="NaN")){text="not set";}
 var n = markersArray.length;
 if ( n>15){ n=15; }
 var location = new google.maps.LatLng(lt,lg);
  marker = new MarkerWithLabel({
    position: location,
    map: map,
    labelContent: text,
    labelAnchor: new google.maps.Point(32, 0),
    labelClass: "labels" + " lc"+n, // the CSS class for the label
    labelStyle: {opacity: 0.8}

  });
  markersArray.push(marker);
  set_zoomc();
 var path = poly.getPath();
 path.push(location);
// Draw_Line_On_Map();
}

function addMarker2(lt,lg,text) {
  var myInfoWindowOptions;
var infoWindow;
 var location = new google.maps.LatLng(lt,lg);
  marker = new google.maps.Marker({
    position: location,
    map: map

  });
  markersArray.push(marker);
 myInfoWindowOptions = {
		content: '15-22-33',
		maxWidth: 200
	};

	infoWindow = new google.maps.InfoWindow(myInfoWindowOptions);
    infoWindow.open(map,marker);
  set_zoomc();
}


function removeMarker(lt,lg){
 var location = new google.maps.LatLng(lt,lg);
 var path = poly.getPath();
  for ( var i=0; i< markersArray.length; i++ ){
   path.pop(markersArray[i].getPosition());
  }

//  path.pop(location);
   //       alert(location);
 for ( var i=0; i< markersArray.length; i++ ){
   //alert(location);
   // markersArray[i].setMap(null);
    //alert(markersArray[i].position);
   // alert(markersArray[i].getPosition().toString()+location.toString());
    if(location.toString()==markersArray[i].getPosition().toString()){
     markersArray[i].setMap(null);
   //  map.markersArray[i].position(0,0);
   //  alert(location);
    markersArray.splice(i,1);
     }

 }
  var path = poly.getPath();
  for ( var i=0; i< markersArray.length; i++ ){
   path.push(markersArray[i].getPosition());
  }
  //map.refresh();
  set_zoomc();

}


function set_zoomc(){
var latlngbounds = new google.maps.LatLngBounds();
for ( var i=0; i< markersArray.length; i++ ){
    latlngbounds.extend(markersArray[i].position);
  //  alert(markersArray[i].position);
//  latlngbounds.extend(markersArray[i].position);
}

if(markersArray.length<2){map.setCenter(markersArray[0].position)}else{
map.setCenter( latlngbounds.getCenter(), map.fitBounds(latlngbounds));
}
/*


}
alert(markersArray.length);    */
//
}

</script>
<style type="text/css">
html, body {
  height: 100%;
  margin: 0;
  padding: 0;
}

#map_canvas {
  height: 100%;
}

@media print {
  html, body {
    height: auto;
  }

  #map_canvas {
    height: 650px;
  }
}
.labels {
     color: #000;
     font-family: "Lucida Grande", "Arial", sans-serif;
     font-size: 11px;
     font-weight: 400;
     text-align: center;
     padding:2px;
     width: 70px auto;


     white-space: nowrap;
}
#inqlist {  display: block;
padding: 2px;
width: auto;
height: auto;
  }
</style>
</HEAD>
<BODY style='z-index:1;'>

<table width=100% style="height:100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="36" colspan="3" bgcolor="#000000">
    <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="UP">
      <tr>
        <td width="20%"><div align="center" class="style1">Management panel</div></td>
        <td width="50%"><div align="center"><iframe src='modules/msg.php' style='width:300px;height:30px; overflow: hidden;border:0;' scrolling="none" ></iframe></div></td>
        <td><div align="center"><span class="style1">Logged as&nbsp;<?php  echo $_SESSION['operator_name'];?></span></div></td>
        <td width="10%"><div align="center" ><A HREF="index.php?exit=1" class="style2">Log off</a></div></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td width="20%" valign="top" background="images/bg_menu_div2.gif" bgcolor="#E5E5E5"><div align="center" id="leftmenu"> <br>
        <br>
        <div id='menu_div' name='menu_div'>
        <table width="183" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr><td style='font-size:1px;'><img src="images/m_top.gif" width="183" height="10"></td></tr>
        <tr><td height="30" class="default-nav"><a href='#' onclick='javascript:promoter_list();'>Promoters</a></td></tr>
        <tr><td height="30" class="default-nav"><a href='#' onclick='javascript:agency_list();'>Agencies</a></td></tr>
        <tr><td height="30" class="default-nav"><a href='#' onclick='javascript:agent_list();'>Agents</a></td></tr>
        <tr><td height="30" class="default-nav"><a href='#' onclick='javascript:artist_list();'>Artists</a></td></tr>
        <tr><td height="30" class="active-nav"><a href='#' onclick='javascript:inquiry_list();'>Inquires</a></td></tr>
        <tr><td height="30" class="default-nav"><a href='#' onclick='javascript:contract_list();'>Contracts</a></td></tr>
        <tr><td height="30" class="default-nav"><a href='#' onclick='javascript:sch_list();'>Itinerary</a></td></tr>
        <tr><td height="30" class="default-nav"><a href='#' onclick='javascript:messages_list();'>Messages</a></td></tr>
        <tr><td height="30" class="default-nav"><a href='#' onclick='javascript:new_search();'>Search</a></td></tr>
        <tr><td height="30" class="default-nav"><a href='#' onclick='javascript:links_list();'>Links</a></td></tr>
        <tr><td height="30" class="default-nav"><a href='#' onclick='javascript:users_list();'>Users</a></td></tr>
        <tr><td height="30" class="default-nav"><a href='#' onclick='javascript:settings();'>Settings</a></td></tr>
        <tr><td height="30" class="default-nav"><a href='#' onclick='javascript:mass_mail();' >Message templates</a></td></tr>
        <tr><td height="30" class="default-nav"><a href='#' onclick='javascript:sms_list();' >SMS messages</a></td></tr>
         <tr>
          <td style='font-size:1px;'><img src="images/m_bot.gif" width="183" height="10"></td>
        </tr>

      </table></div>
      <br>
      <?php// ini_set("magic_quotes_gpc","0"); echo "magic_quotes_gpc=".ini_get("magic_quotes_gpc");?>
      <!--<div><a href='#' onclick='javascript:get_debug();'>get cookies</a></div> -->
      <div id='debug' name='debug'>
      </div>

    </div></td>
    <td bgcolor="#BFBFBF">&nbsp;</td>
    <td width="80%" valign="top" bgcolor="#E5E5E5"><br>
        <br>
<div id='report_div' name='report_div' style='overflow: hidden;'>
<?php
//echo inquirys_list(0);
?>
</div>

<div id='search_results' name='search_results' style='display:none;'></div>
<div id='info_div' name='info_div' style='border:1px gray solid;background-image:url("/ico/overlay.png");background-repeat:repeat;
width:100%;height:100%;z-index:90;display:none;position:absolute;top:0;left:0;text-align:center;vertical-align:middle;'>&nbsp;&nbsp;</div>
<div id='bottom_ancor' name='bottom_ancor'><a name='bottom'>&nbsp;</a></div>
</td>
  </tr>
</table>
<DIV ID="testdiv1" name="testdiv1" STYLE="position:absolute;visibility:hidden;background-color:white;layer-background-color:white;z-index:99;"></DIV>
<DIV ID="testdiv2" name="testdiv2" STYLE="position:absolute;visibility:hidden;background-color:white;layer-background-color:white;z-index:99;"></DIV>
<?php echo start_link();?>
</BODY>
</HTML>
