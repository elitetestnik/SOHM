<?PHP

 
if( isset( $_REQUEST['xajax'] ) || isset( $_POST['xajax'] ) || isset( $_GET['xajax'] ) ) {
if (!defined('_VALID_MOS')) define( '_VALID_MOS', 1 );
require_once("../config.php");
require_once($mosConfig_absolute_path."/globals.php" );
require_once($mosConfig_absolute_path."/includes/mambo.php" );
require_once($mosConfig_absolute_path."/includes/getmime.php" );
include_once($mosConfig_absolute_path."/includes/simple_html_dom.php");
require_once($mosConfig_absolute_path."/modules/calendar.php" );
require_once($mosConfig_absolute_path."/includes/cls_fast_template.php");

$database = new database( $mosConfig_host, $mosConfig_user, $mosConfig_password, $mosConfig_db, $mosConfig_dbprefix );
$database->debug( $mosConfig_debug );
$acl = new gacl_api();
//------------------------------
if ((isset($_COOKIE['operator_id']))&&($_COOKIE['operator_id']>0)){
$query=" select * from #__settings  where id=".$_COOKIE['operator_id'];
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
$_START_ID = $setting->start_id;
}
}
}else{
$_COMPANY_NAME = "Webserver";
$_BANKACCOUNT = "please, update settings";
$_UNDERWRITER = "Please, Update Settings";
$_EMAIL = "webserver@c-parta.od.ua";
$_PERPAGE = 10;
$_FOOTER1= "<p><i>With regars, Your <b>WebServer.</b></i></p>";
$_START_ID =2;

}
//------------------------------
} else {
    defined( '_VALID_MOS' ) or die( 'Access denied!' );
	global $mosConfig_absolute_path, $mosConfig_live_site, $database;
}
if( !defined ('XAJAX_DEFAULT_CHAR_ENCODING') ) include_once($mosConfig_absolute_path."/includes/xajax/xajax.inc.php");

include($mosConfig_absolute_path. '/includes/ckeditor/ckeditor_php5.php' );

function getagentInfo($agent_id) {
$link="href='#' onclick='javascript:getagentInfo(".$agent_id.");' ";
setcookie('prev',stripslashes ($_COOKIE['now']));
setcookie('now',$link);

global $database,$mosConfig_absolute_path;$database->setQuery( "set names utf8" );$database->query();
$query=" select * from #__agents a where id=".$agent_id;
$database->setQuery( $query );
$agents = $database->loadObjectList();


foreach ($agents as $agent){
$database->setQuery( "SELECT * from #__comments  where id_source=".$agent_id."  and about='agents' order by lastupdate desc "  );
$comments = $database->loadObjectList();
$COMMENT="<table border=0 cellpadding=2 cellspacing=2 width='100%'>";

$query=" select name FROM #__agency a where id=".$agent->id_agency;
$database->setQuery( $query );
$agency_name = $database->loadResult();
if(""==$agency_name) $agency_name="<font color='red'>Undefined ...</font>";

foreach ($comments as $comment){
$COMMENT.="<tr><td width='120' align='left' class='style2 sm' nowrap>".$comment->lastupdate."</td><td align='left' class='style9 sm'>".$comment->comment."</td>
<td><a href='#' onclick='javascript:delete_our_comment(".$comment->id.");' title='Delete this comment'><img src='images/del.gif' width='10' height='10' align='absmiddle' border='0'></a></td></tr>";}
$COMMENT.="</table>";

$query='select name from #__countries where id='.$agent->country;
$database->setQuery( $query );
$country = $database->loadResult();

    $ft = new FastTemplate($mosConfig_absolute_path."/templates");
    $ft->define(array('body'  => "agent_view.tpl"));
    $ft->assign( array(
                    'ID' => $agent->id,
                    'COMPANY' => $agent->name,
                    'AGENCY' => $agency_name,
                    'CITYCODE' => $agent->city_code  ,
                    'CONTACTPERSON' => $agent->contact_person  ,
                    'TOWN' => $agent->town  ,
                    'ADDR1' => $agent->street_addr1  ,
                    'COUNTRY' => $country ,
                    'ADDR2' => $agent->street_addr2  ,
                    'PHONE1' => $agent->phone1  ,
                    'EMAIL' => $agent->email  ,
                    'PHONE2' => $agent->phone2  ,
                    'WWW' => $agent->website  ,
                    'COMMENTS' => $COMMENT,
                    'BACK' => stripslashes ($_COOKIE['now'])
                    ));
    $ft->parse('BODY', "body");
    $result=$ft->FastPrint("BODY",true);
}
$objResponse = new xajaxResponse('UTF-8');
$objResponse->addAssign( 'report_div', 'innerHTML',$result );
return $objResponse->getXML();
}

function draw_menu($id){

$result="  <table width='183' border='0' align='center' cellpadding='0' cellspacing='0'>
        <tr><td style='font-size:1px;'><img src='images/m_top.gif' width='183' height='10' border=0 alt=''></td></tr>";

$links = array (
                "<a href='#' onclick='javascript:promoter_list();'>Promoters</a>",
                "<a href='#' onclick='javascript:agency_list();'>Agencies</a>",
                "<a href='#' onclick='javascript:agent_list();'>Agents</a>",
                "<a href='#' onclick='javascript:artist_list();'>Artists</a>",
                "<a href='#' onclick='javascript:inquiry_list();'>Inquires</a>",
                "<a href='#' onclick='javascript:contract_list();'>Contracts</a>",
                "<a href='#' onclick='javascript:sch_list();'>Itinerary</a>",
                "<a href='#' onclick='javascript:messages_list();'>Messages</a>",
                "<a href='#' onclick='javascript:new_search();'>Search</a>",
                "<a href='#' onclick='javascript:links_list();'>Links</a>",
                "<a href='#' onclick='javascript:users_list();'>Users</a>",
                "<a href='#' onclick='javascript:settings();' >Settings</a>",
                "<a href='#' onclick='javascript:mass_mail();' >Message templates</a>",
                "<a href='#' onclick='javascript:sms_list();' >SMS</a>"
                );
$i=0;
foreach ($links as $link)
{
if ($id==$i)$result.="<tr><td height='30' class='active-nav'>".$link."</td></tr>";
else   $result.="<tr><td height='30' class='default-nav'>".$link."</td></tr>";
$i++;
}
$result.="<tr><td style='font-size:1px;'><img src='images/m_bot.gif' width='183' height='10'></td></tr></table>";
$objResponse = new xajaxResponse('UTF-8');
$objResponse->addAssign( 'menu_div', 'innerHTML', $result );
return $objResponse->getXML();

}


function editagentInfo($agent_id=0) {
global $database;
$database->setQuery( "set names utf8" );
$database->query();

if ($agent_id>0)
{
 	$agents = array();
        $qr="SELECT * from #__agents where id=".$agent_id ;
		$database->setQuery( $qr);
		$agents = $database->loadObjectList();
		foreach ($agents as $agent ){}
}
$alist = array();
$alist[] = mosHTML::makeOption( '0', 'undefined ...', 'value', 'text'  );
if ($agent_id>0) $database->setQuery( "SELECT id as value, name as text FROM #__agency  ORDER BY name" );
else $database->setQuery( "SELECT id as value, name as text FROM #__agency  where status >=0 ORDER BY name" );
$alist = array_merge($alist,$database->loadObjectList());
if (isset($agent->id_agency)) $agnts=$agent->id_agency; else $agnts=0;
$m=mosHTML::selectList( $alist, 'id_agency', " id='id_agency' ", 'value', 'text', $agnts );

$today  = date("d/m/Y", mktime (0,0,0,date("m")  ,date("d"),date("Y")));
$result="
<TABLE align='center' valign='middle' width='100%' height='100%' cellpadding=0 cellspacing=0 border=0>
<TR>
	<TD>
<TABLE style='border:15px white solid;background-color: #eeeeee;' align='center' valign='middle' cellpadding=0 cellspacing=0>
<TR>
	<TD>
<TABLE class='h3' style='border:1px gray solid;background-color: #eeeeee;'><TR><td colspan=2 align='right'><button onclick='javascript:hideInfo();'><IMG SRC='/images/del.gif' WIDTH='16' HEIGHT='16' BORDER='0' ALT=''></button></td></TR>
<TR><TH colspan=2 class='h2'>Agent&nbsp;info&nbsp;№&nbsp;".$agent_id."</TH>
</TR><TR>	<TD valign='top'  class='h1'>";
$result.="<FORM METHOD=POST name='agent_form' id='agent_form' onsubmit='return check_this_form(this);' ACTION=\"javascript:agent_save(xajax.getFormValues('agent_form'));\">
<INPUT TYPE='hidden' name='agent_id' id='agent_id' value='".$agent_id."'>";

//if (isset ($agent->id)) $result.=$agent->id; else $result.="0";
$result.="<TABLE class='h3'><TR><TD valign='top'  class='h1'><TABLE width='99%'><TR><TH colspan=2 align=center>Agent information</TH>
</TR><TR><TD>Agency</TD><TD>".$m."</TD></TR><TR><TD>Agent</TD><TD nowrap><INPUT TYPE='text' NAME='name' id='name' required='1'  value='";
if (isset($agent->name)) $result.=$agent->name; else $result.="";
$result.="'\">&nbsp;<a href='#' onclick=\"javascript:check_name(document.getElementById('name').value,'agents',".$agent_id.",'editagentInfo',1);\">check&nbsp;name</a><br><div id='check_results' name='check_results'></div></TD></TR>";
$result.="<!-- <TR><TD>Contact person</TD><TD>--><INPUT TYPE='hidden' NAME='contact_person' value='";
if (isset($agent->contact_person)) $result.=$agent->contact_person; else $result.="";
$result.="'><!-- </TD></TR>--><TR><TD>Street address 1</TD><TD><INPUT TYPE='text' NAME='street_addr1' value='";
if (isset($agent->street_addr1)) $result.=$agent->street_addr1; else $result.="";
$result.="'></TD></TR><TR><TD>Street address 2</TD><TD><INPUT TYPE='text' NAME='street_addr2' value='";
if (isset($agent->street_addr2)) $result.=$agent->street_addr2; else $result.="";
$result.="'></TD></TR><TR><TD>City code (ZIP)</TD><TD><INPUT TYPE='text' NAME='city_code' value='";
if (isset($agent->city_code)) $result.=$agent->city_code; else $result.="";
$result.="'></TD></TR><TR><TD>Town</TD><TD><INPUT TYPE='text' NAME='town' value='";
if (isset($agent->town)) $result.=$agent->town; else $result.="";
$result.="'></TD></TR><TR><TD>Country</TD><td>";
$clist = array();
$clist[] = mosHTML::makeOption( '0', '........', 'value', 'text'  );
$database->setQuery( "SELECT id as value, name as text FROM #__countries  ORDER BY name" );  // where  world LIKE  'europe'
$clist = array_merge($clist,$database->loadObjectList());
if (isset($agent->country)) $result.=mosHTML::selectList( $clist, 'country', " id='country' ", 'value', 'text', $agent->country );
  else  $result.=mosHTML::selectList( $clist, 'country', " id='country' ", 'value', 'text', 0);
$result.="</TD></TR><TR><TD>Local phone</TD><TD><INPUT TYPE='text' NAME='phone1' id='phone1' value='";
if (isset($agent->phone1)) $result.=$agent->phone1; else $result.="";
$result.="'></TD></TR><TR><TD>Cell phone</TD><TD><INPUT TYPE='text' NAME='phone2' id='phone2' value='";
if (isset($agent->phone2)) $result.=$agent->phone2; else $result.="";
$result.="'></TD></TR><TR><TD>e-mail</TD><TD><INPUT TYPE='text' NAME='email' required='1'  email value='";
if (isset($agent->email)) $result.=$agent->email; else $result.="";
$result.="'></TD></TR><TR><TD>Website</TD><TD><INPUT TYPE='text' NAME='website' value='";
if (isset($agent->website)) $result.=$agent->website; else $result.="";
$result.="'></TD></TR>";
$result.="</TD></TR></TABLE></TD></TR><tr><td align='center' colspan=2>";
$result.="<input type='submit' value='Save' class='button'></td></tr></TABLE></FORM>";
$result.="</TD></TR></TABLE></TD>
</TR>
</TABLE></TD>
</TR>
</TABLE>
";
$objResponse = new xajaxResponse('UTF-8');
$objResponse->addAssign( 'info_div', 'innerHTML', $result );
return $objResponse->getXML();
}


function agent_save($formdata)
{
global $database;
$result="";
$database->setQuery( "set names utf8" );
$database->query();
foreach ($formdata as $key => $value) {
	$formdata[$key] = addslashes(strip_tags($value));
//    $result.=$key.' - '.$value.'<br />';
}
if ((isset($formdata['agent_id']))&&($formdata['agent_id']>0))
{
$update="
update #__agents set
`id_agency`='".$formdata['id_agency']."',
`name` = '".$formdata['name']."',
`contact_person` = '".$formdata['contact_person']."',
`street_addr1` = '".$formdata['street_addr1']."',
`street_addr2` = '".$formdata['street_addr2']."',
`city_code` = '".$formdata['city_code']."',
`town` = '".$formdata['town']."',
`country` = '".$formdata['country']."',
`phone1` = '".$formdata['phone1']."',
`phone2` = '".$formdata['phone2']."',
 `email` = '".trim($formdata['email'])."',
 `whosupdate` = ".$_COOKIE['operator_id'].",
 `website` = '".$formdata['website']."',
 `lastupdate` = CURRENT_TIMESTAMP
where id=".$formdata['agent_id'];
}
else {
$update ="
insert into #__agents (
`id_agency`,`name`, `contact_person`, `street_addr1`, `street_addr2`, `city_code`, `town`, `country`, `phone1`, `phone2`, `email`, `website`, `status`, `lastupdate`, `whosupdate`) values
(".$formdata['id_agency'].",'".$formdata['name']."', '".$formdata['contact_person']."', '".$formdata['street_addr1']."', '".$formdata['street_addr2']."', '".$formdata['city_code']."', '".$formdata['town']."', '".$formdata['country']."', '".$formdata['phone1']."', '".$formdata['phone2']."', '".trim($formdata['email'])."', '".$formdata['website']."', 0, CURRENT_TIMESTAMP,".$_COOKIE['operator_id'].")";
}
$database->setQuery( $update );
$database->query();
$result.=agents_list(0);
$objResponse = new xajaxResponse('UTF-8');
$objResponse->addAssign( 'report_div', 'innerHTML', $result );
return $objResponse->getXML();
}

function agent_list($agent_id,$search="",$page=0,$agency_id=0) {
if ($agent_id=='undefined')$agent_id=0;
if ($agency_id=='undefined')$agency_id=0;
if ($page=='undefined')$page=0;
if ($search=='undefined')$search="";
setcookie('prev',stripslashes ($_COOKIE['now']));
setcookie('now',"href='#' onclick='javascript:agent_list(".$agent_id.",\"".$search."\",".$page.",".$agency_id.");' ");
$objResponse = new xajaxResponse('UTF-8');
$objResponse->addAssign( 'report_div', 'innerHTML', agents_list($agent_id,$search,$page,$agency_id));
return $objResponse->getXML();
}

//==============================================================================================

function agents_list($id, $search="",$page=0,$agency_id=0) {
if ($id=='undefined')$id=0;
if ($page=='undefined')$page=0;
if ($search=='undefined')$search="";
if ($agency_id=='undefined')$agency_id="";
if ($agency_id=='')$agency_id=0;

global $_PERPAGE;
$per_page=$_PERPAGE;

$result= "";
if (isset($id)) $ss=$id; else $ss=0;
global $database;
$database->setQuery( "set names utf8" );
$database->query();
switch  ($ss)
{
	case 0: $add=" where a.status >=0 "; break;
	case 1: $add=" where a.status= -1 "; break;
}
if ($search!="") $add=" where  a.name like '%".$search."%'";
 $result.= "
  <table width='95%' border='0' align='center' cellpadding='0' cellspacing='0'>
      <tr>
        <td width='53%' class='style4'>Agents ";
if ($agency_id>0){
$que=" select a.name FROM #__agency a where a.id=".$agency_id;
switch  ($id)
{
	case 0: $add=" where a.status >=0 and a.id_agency=".$agency_id; break;
	case 1: $add=" where a.status= -1 and a.id_agency=".$agency_id; break;
}
$database->setQuery($que);
$agency_name = $database->loadResult();
$result.="&nbsp;in Agency '".$agency_name."'";}
$result.="</td><td width='47%' class='style4'>".displays_search_form(1)."</td></tr></table><br />";
$query2="SELECT count(*) from #__agents a ".$add."
order by a.id desc ";
$head="";
$promoters = array();
$database->setQuery( $query2 );
$counts = $database->loadResult();
//$result.=$counts;
$pages=ceil($counts/$per_page);
if ($page==0) $page=1;
$limits=" LIMIT ".($page-1)*$per_page.",".$per_page." ";
$paginator="<select id='paginator' name='paginator' onchange='javascript:agent_list(".$id.",\"".$search."\",this.value);'>";
for ($i=1;$i<=$pages;$i++) {
$paginator.="<option value='".$i."'";
if ($page==$i)$paginator.=" selected ";
$paginator.=">".$i."</option>";}
$paginator.="</select>";
$query="SELECT * from #__agents a ".$add."
order by a.id desc
".$limits;
//$result.=$query;
$np=$page+1;$pp=$page-1;
if (1==$page)$links="<div align='center'><span class='style11'><img border=0 src='images/back-24x24.png' align='absmiddle'>&nbsp;prev&nbsp;page&nbsp;";
else $links="<div align='center'><a href='#' onclick='javascript:agent_list(".$id.",\"".$search."\",".$pp.");'><img border=0 src='images/back-24x24.png' align='absmiddle'></a>&nbsp;<a class='style11' href='#' onclick='javascript:agent_list(".$id.",\"".$search."\",".$pp.");'>prev&nbsp;page</a>&nbsp;";
$links.= $paginator;
if ($pages==$page)$links.="<span class='style11'>&nbsp;next&nbsp;page&nbsp;<img border=0 src='images/next-24x24.png' align='absmiddle'></span>";
else $links.="&nbsp;<a class='style11' href='#' onclick='javascript:agent_list(".$id.",\"".$search."\",".$np.");'>next&nbsp;page</a>&nbsp;<a href='#' onclick='javascript:agent_list(".$id.",\"".$search."\",".$np.");'><img border=0 src='images/next-24x24.png' align='absmiddle'></a>";
$agents = array();
$database->setQuery( $query );
$agents = $database->loadObjectList();
if (sizeof($agents)>0)  $result.= $head;
else {
if($search)
$result.= "<table width='95%' border='0' align='center' cellpadding='0' cellspacing='1' bgcolor='#999999'>
              <tr>
                <td bgcolor='#999999' class='style4'><table width='100%' border='0' align='center' cellpadding='0' cellspacing='1'><td height='36' colspan='3' bgcolor='#FFFFFF'>
                <span class='style5'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;You search for&nbsp;<b>".$search."</b>,&nbsp;but nobody found...</span></td></TR>
                  <tr>
                    <td height='35' bgcolor='#FFFFFF'>&nbsp;&nbsp;
                    <a href='#' onclick='javascript:editagentInfo(0);'><img src='images/comment-add-24x24.png'   align='absmiddle' border=0></a>&nbsp;&nbsp;<a href='#' onclick='javascript:editagentInfo(0);'  class='style11'>Add New Agent</a></td>
                    <td height='35' colspan='2' bgcolor='#FFFFFF'>&nbsp;</td>
                  </tr>
</table></td></tr></table>";
else {
 $result.= "<table width='95%' border='0' align='center' cellpadding='0' cellspacing='1' bgcolor='#999999'>
              <tr>
                <td bgcolor='#999999' class='style4'><table width='100%' border='0' align='center' cellpadding='0' cellspacing='1'>
                  <tr>
                    <td height='36' colspan='3' bgcolor='#FFFFFF'>&nbsp;&nbsp;<span class='style5'>Agents</span>&nbsp;&nbsp;&nbsp;";
if($search) $result.="<span class='style5'>You search for:&nbsp;<b>".$search."</b></span>";
else {
if ($ss!=0) $result.= "<A HREF='#' onclick='javascript:agent_list(0,\"".$search."\",".$page.",".$agency_id.");' class='style11'>Active</A>";else  $result.= "[<B>Active</B>]";
 $result.= "&nbsp;|&nbsp;";
if ($ss!=1) $result.= "<A HREF='#' class='style11' onclick='javascript:agent_list(1,\"".$search."\",".$page.",".$agency_id.");' >Deleted</A>";else  $result.= "[<B>Deleted</B>]";
}
$result.="</td></tr>";
$result.="<tr>
                    <td height='35' bgcolor='#FFFFFF'  colspan='3'>&nbsp;&nbsp;
                    <a href='#' onclick='javascript:editagentInfo(0);'><img src='images/comment-add-24x24.png'   align='absmiddle' border=0></a>&nbsp;&nbsp;<a href='#' onclick='javascript:editagentInfo(0);'  class='style11'>Add New Agent</a></td>
                  </tr>
                </table></td>
              </tr>
            </table>

     ";
}

return $result;
}
$result.= "<table width='95%' border='0' align='center' cellpadding='0' cellspacing='1' bgcolor='#999999'>
              <tr>
                <td bgcolor='#999999' class='style4'><table width='100%' border='0' align='center' cellpadding='0' cellspacing='1'>
                  <tr>
                    <td height='36' colspan='4' bgcolor='#FFFFFF'>&nbsp;&nbsp;<span class='style5'>Agents";
if (isset($agency_name)) $result.="&nbsp;&nbsp;in Agency '".$agency_name."'";
$result.="</span>&nbsp;&nbsp;&nbsp;";

if($search) $result.="<span class='style5'>You search for:&nbsp;<b>".$search."</b></span>";
else {
 if ($ss!=0) $result.= "<A HREF='#' onclick='javascript:agent_list(0,\"".$search."\",".$page.",".$agency_id.");' class='style11'>Active</A>";else  $result.= "[<B>Active</B>]";
 $result.= "&nbsp;|&nbsp;";
if ($ss!=1) $result.= "<A HREF='#' class='style11' onclick='javascript:agent_list(1,\"".$search."\",".$page.",".$agency_id.");' >Deleted</A>";else  $result.= "[<B>Deleted</B>]";
}
$result.="</td></tr>";
$result.="<tr><td height='36' class='style18'>Agent</td><td height='36' class='style18'>Agency</td><!--<td class='style18'>Contact&nbsp;person</td>--><td class='style18'>Id</td></tr>";
foreach ($agents as $agent)
	{
$database->setQuery( "SELECT name  FROM #__agency  where id=".$agent->id_agency );
$agency = $database->loadResult();
if (""==$agency) $agency="undefined ..."; else $agency="&nbsp;&nbsp;&nbsp;<a href='#' onclick='javascript:getagencyInfo(".$agent->id_agency.");' class='style6'><img src='images/info-24x24.png'  align='absmiddle' border='0'></a>&nbsp;&nbsp;<a class='style34' href='#' onclick='javascript:getagencyInfo(".$agent->id_agency.")'>".$agency."</a>";
$result.="
<tr><td width='30%' height='35' bgcolor='white'>&nbsp;";
if ($search)
$result.="<input type='checkbox' align='absmiddle' id='agent_".$agent->id."' prop='mail' boxtype='agent' email='".$agent->email."'>&nbsp;"  ;

$result.="
<a href='#' onclick='javascript:editagentInfo(".$agent->id.");' title='Edit info on this Agent'>
<img src='images/blog-post-edit-24x24.png'  align='absmiddle' border='0'></a>&nbsp;";

if($ss==0) $result.="<a href='#' onclick='javascript:agent_delete(".$agent->id.");' title='Delete this Agent'><img src='images/trash-empty-24x24.png'  align='absmiddle' border='0'></a>";
else { $result.="<a href='#' onclick='javascript:agent_restore(".$agent->id.");' title='Restore this Agent'><img src='images/accept-24x24.png' align='absmiddle' border='0'></a>";
$result.="&nbsp;&nbsp;<a href='#' onclick='javascript:agent_delete(".$agent->id.", 1 );' title='Delete this Agent forever!!'><img src='images/remove-24x24.png'  align='absmiddle' border='0'></a>";
}
$result.="&nbsp;&nbsp;&nbsp;<a class='style34' href='#' onclick='javascript:getagentInfo(".$agent->id.")'>".$agent->name ."</a></td>
<td width='40%' bgcolor='white'><div align='left'>".$agency."</div></td>
<!--<td width='30%' bgcolor='white'><div align='center'>".$agent->contact_person."</div></td>   -->
<td width='10%' bgcolor='white'><div align='center'>".$agent->id ."</div></td>
</tr>";
}
$result.="<tr><td height='35' bgcolor='#FFFFFF'>&nbsp;&nbsp;
<a href='#' onclick='javascript:editagentInfo(0);'><img src='images/comment-add-24x24.png'   align='absmiddle' border=0></a>&nbsp;&nbsp;<a href='#' onclick='javascript:editagentInfo(0);'  class='style11'>Add New Agent</a></td>
<td height='35' colspan='3' bgcolor='#FFFFFF'>".$links."</td>
</tr></table></td></tr></table>";
return  $result;
}

function agent_delete($id,$mode=0){
global $database;
$query="update `#__agents` set status=-1 where `id`=".$id ;
if ($mode==1) $query="delete from `#__agents` where `id`=".$id ;
//echo $query;
$database->setQuery( $query);
$database->query();
$objResponse = new xajaxResponse('UTF-8');
$objResponse->addAssign( 'report_div', 'innerHTML', agents_list(0));
return $objResponse->getXML();
}

function agent_restore($id){
global $database;
$query="update `#__agents` set status=0 where `id`=".$id ;
//echo $query;
$database->setQuery( $query);
$database->query();
$objResponse = new xajaxResponse('UTF-8');
$objResponse->addAssign( 'report_div', 'innerHTML', agents_list(0));
return $objResponse->getXML();
}

function artist_save($artist_data) {
global $database;$result="";
$database->setQuery( "set names utf8" );
$database->query();
foreach ($artist_data as $key => $value) {
	$artist_data[$key] = addslashes(strip_tags($value));
}
if ((isset($artist_data['artist_id']))&&($artist_data['artist_id']>0))
{
$update="
update #__artists set
`name` = '".$artist_data['name']."',
`contact_person` = '".$artist_data['contact_person']."',
`street_addr1` = '".$artist_data['street_addr1']."',
`street_addr2` = '".$artist_data['street_addr2']."',
`city_code` = '".$artist_data['city_code']."',
`town` = '".$artist_data['town']."',
`country` ='".$artist_data['country']."',
`phone1` = '".$artist_data['phone1']."',
`phone2` = '".$artist_data['phone2']."',
 `email` = '".trim($artist_data['email'])."',
 `website` = '".$artist_data['website']."',
 `lastupdate` = CURRENT_TIMESTAMP,
 `id_agency` = ".$artist_data['id_agency'].",
 `id_agent` = ".$artist_data['id_agent']."
where id=".$artist_data['artist_id'];

}
else {
$update ="
insert into #__artists (
`name`, `contact_person`, `street_addr1`, `street_addr2`, `city_code`, `town`, `country`, `phone1`, `phone2`, `email`, `website`, `status`, `lastupdate`, `whosupdate`,`id_agent`,`id_agency`) values
('".$artist_data['name']."', '".$artist_data['contact_person']."', '".$artist_data['street_addr1']."', '".$artist_data['street_addr2']."', '".$artist_data['city_code']."', '".$artist_data['town']."', '".$artist_data['country']."', '".$artist_data['phone1']."', '".$artist_data['phone2']."', '".trim($artist_data['email'])."', '".$artist_data['website']."', 0, CURRENT_TIMESTAMP,".$_COOKIE['operator_id'].",".$artist_data['id_agent'].",".$artist_data['id_agency'].")";

}
$database->setQuery( $update );
$database->query();

$objResponse = new xajaxResponse('UTF-8');
$objResponse->addAssign( 'report_div', 'innerHTML',artists_list(0) );
return $objResponse->getXML();

}


//==============================================================================================
function artist_list($id,$search="",$page=0) {
if ($id=='undefined')$id=0;
if ($page=='undefined')$page=0;
if ($search=='undefined')$search='';
setcookie('prev',stripslashes($_COOKIE['now']) );
setcookie('now',"href='#' onclick='javascript:artist_list(".$id.",\"".$search."\",".$page.");' ");
$objResponse = new xajaxResponse('UTF-8');
$objResponse->addAssign( 'report_div', 'innerHTML', artists_list($id,$search,$page) );
return $objResponse->getXML();
}

function artists_list($id, $search="",$page=0) {
//=================================================
if ($id=='undefined')$id=0;
global $_PERPAGE;
$per_page=$_PERPAGE;
$result="";
if (isset($id)) $ss=$id; else $ss=0;

switch  ($ss)
{
	case 0: $add=" where a.status >=0 "; break;
	case 1: $add=" where a.status= -1 "; break;
}
if ($search!="") $add=" where  a.name like '%".$search."%'";
 $result.= "
  <table width='95%' border='0' align='center' cellpadding='0' cellspacing='0'>

      <tr>
        <td width='53%' class='style4'>Artists</td>
        <td width='47%' class='style4'>".displays_search_form(2)."</td>
      </tr>
    </table><br />
";


$query2="SELECT count(*) from #__artists a ".$add."
order by a.id desc ";

$head="";
global $database;
$database->setQuery( "set names utf8" );
$database->query();
$promoters = array();
$database->setQuery( $query2 );
$counts = $database->loadResult();
//$result.=$counts;
$pages=ceil($counts/$per_page);
if ($page==0) $page=1;
$limits=" LIMIT ".($page-1)*$per_page.",".$per_page." ";
$paginator="<select id='paginator' name='paginator' onchange='javascript:artist_list(".$id.",\"".$search."\",this.value);'>";
for ($i=1;$i<=$pages;$i++) {
$paginator.="<option value='".$i."'";
if ($page==$i)$paginator.=" selected ";
$paginator.=">".$i."</option>";}
$paginator.="</select>";
$query="SELECT * from #__artists a ".$add."
order by a.id desc
".$limits;
//$result.=$query;
$np=$page+1;$pp=$page-1;
if (1==$page)$links="<div align='center'><span class='style11'><img border=0 src='images/back-24x24.png' align='absmiddle'>&nbsp;prev&nbsp;page&nbsp;";
else $links="<div align='center'><a href='#' onclick='javascript:artist_list(".$id.",\"".$search."\",".$pp.");'><img border=0 src='images/back-24x24.png' align='absmiddle'></a>&nbsp;<a class='style11' href='#' onclick='javascript:artist_list(".$id.",\"".$search."\",".$pp.");'>prev&nbsp;page</a>&nbsp;";
$links.= $paginator;
if ($pages==$page)$links.="<span class='style11'>&nbsp;next&nbsp;page&nbsp;<img border=0 src='images/next-24x24.png' align='absmiddle'></span>";
else $links.="&nbsp;<a class='style11' href='#' onclick='javascript:artist_list(".$id.",\"".$search."\",".$np.");'>next&nbsp;page</a>&nbsp;<a href='#' onclick='javascript:artist_list(".$id.",\"".$search."\",".$np.");'><img border=0 src='images/next-24x24.png' align='absmiddle'></a>";
$artists = array();
$database->setQuery( $query );
$artists = $database->loadObjectList();
if (sizeof($artists)>0)  $result.= $head; else {

if($search)
$result.= "<table width='95%' border='0' align='center' cellpadding='0' cellspacing='1' bgcolor='#999999'>
              <tr>
                <td bgcolor='#999999' class='style4'><table width='100%' border='0' align='center' cellpadding='0' cellspacing='1'><td height='36' colspan='3' bgcolor='#FFFFFF'>
                <span class='style5'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;You search for&nbsp;<b>".$search."</b>,&nbsp;but nobody found...</span></td></TR>
                  <tr>
                    <td height='35' bgcolor='#FFFFFF'>&nbsp;&nbsp;
                    <a href='#' onclick='javascript:editartistInfo(0);'><img src='images/comment-add-24x24.png'   align='absmiddle' border=0></a>&nbsp;&nbsp;<a href='#' onclick='javascript:editartistInfo(0);'  class='style11'>Add New Artist</a></td>
                    <td height='35' colspan='3' bgcolor='#FFFFFF'>&nbsp;</td>
                  </tr>
                </table></td>
                  </tr>
                </table>


";
else {

 $result.= "<table width='95%' border='0' align='center' cellpadding='0' cellspacing='1' bgcolor='#999999'>
              <tr>
                <td bgcolor='#999999' class='style4'><table width='100%' border='0' align='center' cellpadding='0' cellspacing='1'>
                  <tr>
                    <td height='36' colspan='4' bgcolor='#FFFFFF'>&nbsp;&nbsp;<span class='style5'>Artists</span>&nbsp;&nbsp;&nbsp;";

if($search) $result.="<span class='style5'>You search for:&nbsp;<b>".$search."</b></span>";
else {
                    if ($ss!=0) $result.= "<A HREF='#' onclick='javascript:artist_list(0);' class='style11'>Active</A>";else  $result.= "[<B>Active</B>]";
 $result.= "&nbsp;|&nbsp;";
if ($ss!=1) $result.= "<A HREF='#' class='style11' onclick='javascript:artist_list(1);' >Deleted</A>";else  $result.= "[<B>Deleted</B>]";
}
$result.="</td></tr>";
$result.="
                  <tr>
                    <td height='35' bgcolor='#FFFFFF'  colspan='3'>&nbsp;&nbsp;
                    <a href='#' onclick='javascript:editartistInfo(0);'><img src='images/comment-add-24x24.png'   align='absmiddle' border=0></a>&nbsp;&nbsp;<a href='#' onclick='javascript:editartistInfo(0);'  class='style11'>Add New Artist</a></td>
                  </tr>
                </table></td>
              </tr>
            </table>

     ";
}

return $result;
}
$result.= "<table width='95%' border='0' align='center' cellpadding='0' cellspacing='1' bgcolor='#999999'>
              <tr>
                <td bgcolor='#999999' class='style4'><table width='100%' border='0' align='center' cellpadding='0' cellspacing='1'>
                  <tr>
                    <td height='36' colspan='4' bgcolor='#FFFFFF'>&nbsp;&nbsp;<span class='style5'>Artists</span>&nbsp;&nbsp;&nbsp;";

if($search) $result.="<span class='style5'>You search for:&nbsp;<b>".$search."</b></span>";
else {
                    if ($ss!=0) $result.= "<A HREF='#' onclick='javascript:artist_list(0);' class='style11'>Active</A>";else  $result.= "[<B>Active</B>]";
 $result.= "&nbsp;|&nbsp;";
if ($ss!=1) $result.= "<A HREF='#' class='style11' onclick='javascript:artist_list(1);' >Deleted</A>";else  $result.= "[<B>Deleted</B>]";
}
$result.="</td></tr>";
$result.="<tr><td height='36' class='style18'>Artist</td><td class='style18'>Agency</td><td class='style18'>Agent</td><td class='style18'>Id</td></tr>";

foreach ($artists as $artist)
{
$result.="<tr>
<td width='33%' height='35' bgcolor='white' nowrap>&nbsp;";

if ($search) $result.="<input type='checkbox' align='absmiddle' id='artist_".$artist->id."' prop='mail' boxtype='artist' email='".$artist->email."'>&nbsp;"  ;

$result.="&nbsp;<a href='#' onclick='javascript:editartistInfo(".$artist->id.");' title='Get info on this Artist'><img src='images/blog-post-edit-24x24.png'  align='absmiddle' border='0'></a>&nbsp;
";
if($ss==0) $result.="<a href='#' onclick='javascript:artist_delete(".$artist->id.");' title='Delete this Artist'><img src='images/trash-empty-24x24.png'  align='absmiddle' border='0'></a>";
else {
$result.="<a href='#' onclick='javascript:artist_restore(".$artist->id.");' title='Restore this Artist'><img src='images/accept-24x24.png' align='absmiddle' border='0'></a>";
$result.="&nbsp;&nbsp;<a href='#' onclick='javascript:artist_delete(".$artist->id.", 1 );' title='Delete this Artist forever!!'><img src='images/remove-24x24.png'  align='absmiddle' border='0'></a>";
}
$result.="&nbsp;&nbsp;&nbsp;<a href='#' onclick='javascript:getArtistInfo(".$artist->id.");' title='Get info on this Artist' class='style34'>".$artist->name ."</a></td> ";

$database->setQuery( "SELECT name  from #__agents  where id=".$artist->id_agent );
$agent = $database->loadResult();

$database->setQuery( "SELECT name  FROM #__agency  where id=".$artist->id_agency );
$agency = $database->loadResult();

if ($artist->id_agent!=0)
{
	$agent= "&nbsp;&nbsp;&nbsp;<a href='#' onclick='javascript:getagentInfo(".$artist->id_agent.");' class='style6'><img src='images/info-24x24.png'  align='absmiddle' border='0'></a>&nbsp;&nbsp;<a class='style34' href='#' onclick='javascript:getagentInfo(".$artist->id_agent.")'>".$agent."</a>";
}
else $agent="&nbsp;&nbsp;&nbsp;undefined ...";

if ($artist->id_agency!=0)
{
	$agency= "&nbsp;&nbsp;&nbsp;<a href='#' onclick='javascript:getagencyInfo(".$artist->id_agency.");' class='style6'><img src='images/info-24x24.png'  align='absmiddle' border='0'></a>&nbsp;&nbsp;<a class='style34' href='#' onclick='javascript:getagencyInfo(".$artist->id_agency.")'>".$agency."</a>";
}
else $agency="&nbsp;&nbsp;&nbsp;undefined ...";

$result.="<td bgcolor='white'><div align='left'>".$agency."</div></td>
<td bgcolor='white'><div align='left'>".$agent."</div></td>
<td width='10%' bgcolor='white'><div align='center'>".$artist->id ."</div></td></tr>";

}
$result.="

                  <tr>
                    <td height='35' bgcolor='#FFFFFF'>&nbsp;&nbsp;
                    <a href='#' onclick='javascript:editartistInfo(0);'><img src='images/comment-add-24x24.png'   align='absmiddle' border=0></a>&nbsp;&nbsp;<a href='#' onclick='javascript:editartistInfo(0);'  class='style11'>Add New Artist</a></td>
                    <td height='35' colspan='3' bgcolor='#FFFFFF'>".$links."</td>
                </tr>
                </table></td>
              </tr>
            </table>

     ";

return  $result;


}



function getArtistInfo($artist_id) {
setcookie('prev',stripslashes($_COOKIE['now']) );
setcookie('now',"href='#' onclick='javascript:getArtistInfo(".$artist_id.");' ");
global $database,$mosConfig_absolute_path;$database->setQuery( "set names utf8" );$database->query();
$query=" select * from #__artists a where id=".$artist_id;
$database->setQuery( $query );
$promoters = $database->loadObjectList();

foreach ($promoters as $promoter){
$today  = date("Y-m-d", mktime (0,0,0,date("m")  ,date("d"),date("Y")));
$ft = new FastTemplate($mosConfig_absolute_path."/templates");
$ft->define(array('body'  => "artist_view.tpl"));

$database->setQuery( "select * from #__agents where id=".$promoter->id_agent );
$agents = $database->loadObjectList();

foreach ($agents as $agent){}
$database->setQuery( "SELECT * from #__comments  where id_source=".$artist_id."  and about='artists' order by lastupdate desc ");
$comments = $database->loadObjectList();
$AGENCY =" ";
$database->setQuery( "SELECT a.name FROM #__agency a where a.id=".$promoter->id_agency);
$AGENCY = $database->loadResult();
$COMMENT="<table border=0 cellpadding=2 cellspacing=2 width='100%'>";
foreach ($comments as $comment){
$COMMENT.="<tr><td width='120' align='left' class='style2 sm' nowrap>".$comment->lastupdate."</td><td align='left' class='style9 sm'>".$comment->comment."</td>
<td><a href='#' onclick='javascript:delete_our_comment(".$comment->id.");' title='Delete this comment'><img src='images/del.gif' width='10' height='10' align='absmiddle' border='0'></a></td></tr>";
}
$COMMENT.="</table>";

$query='select name from #__countries where id='.$promoter->country;
$database->setQuery( $query );
$country = $database->loadResult();


if (!isset($agent->name)) $AGENT='undefined ...'; else $AGENT=$agent->name;
            $ft->assign( array(
                    'ID' => $promoter->id,
                    'COMPANY' => $promoter->name,
                    'CITYCODE' => $promoter->city_code  ,
                    'CONTACTPERSON' => $promoter->contact_person  ,
                    'TOWN' => $promoter->town  ,
                    'ADDR1' => $promoter->street_addr1  ,
                    'COUNTRY' => $country,
                    'ADDR2' => $promoter->street_addr2  ,
                    'PHONE1' => $promoter->phone1  ,
                    'EMAIL' => $promoter->email  ,
                    'PHONE2' => $promoter->phone2  ,
                    'WWW' => $promoter->website  ,
                    'COMMENTS' => $COMMENT,
                    'AGENT' =>"<a class='style34' href='#' onclick='javascript:getagentInfo(".$promoter->id_agent.")'>".$AGENT."</a>",
                    'AGENCY' =>"<a class='style34' href='#' onclick='javascript:getagencyInfo(".$promoter->id_agency.")'>".$AGENCY."</a>",
                    'TODAY'=> $today,
                    'BACK'=> stripslashes ($_COOKIE['now'])
                    ));
            $ft->parse('BODY', "body");
            $result=$ft->FastPrint("BODY",true);
}
$objResponse = new xajaxResponse('UTF-8');
$objResponse->addAssign( 'report_div', 'innerHTML',$result );
return $objResponse->getXML();
}


function editartistInfo($artist_id) {
global $database;
$database->setQuery( "set names utf8" );
$database->query();

if ($artist_id>0)
	{

		$artists = array();
        $qr="SELECT * from #__artists where id=".$artist_id ;
		$database->setQuery( $qr);
		$artists = $database->loadObjectList();
	foreach ($artists as $artist ){}
}

$glist = array();
$glist[] = mosHTML::makeOption( '0', 'undefined ...', 'value', 'text'  );
if ($artist_id>0) $database->setQuery( "SELECT id as value, name as text FROM #__agency  ORDER BY name" );
else $database->setQuery( "SELECT id as value, name as text FROM #__agency  where status >=0 ORDER BY name" );
$glist = array_merge($glist,$database->loadObjectList());
if (isset($artist->id_agency)) $agnts=$artist->id_agency; else $agnts=0;
$m=mosHTML::selectList( $glist, 'id_agency', " id='id_agency' onchange='javascript:agency_selector(this.value); agent_selector(this.value,\"agent_selector\");' ", 'value', 'text', $agnts );


$result="";
$today  = date("d/m/Y", mktime (0,0,0,date("m")  ,date("d"),date("Y")));
$result="
<TABLE align='center' valign='middle' width='100%' height='100%' cellpadding=0 cellspacing=0 border=0>
<TR>
	<TD>
<TABLE style='border:15px white solid;background-color: #eeeeee;' align='center' valign='middle' cellpadding=0 cellspacing=0>
<TR>
	<TD>
<TABLE class='h3' style='border:1px gray solid;background-color: #eeeeee;'><TR><td colspan=2 align='right'><button onclick='javascript:hideInfo();'><IMG SRC='/images/del.gif' WIDTH='16' HEIGHT='16' BORDER='0' ALT=''></button></td></TR>
<TR><TH colspan=2 class='h2'>artist&nbsp;info&nbsp;N&deg;".$artist_id."</TH>
</TR><TR>	<TD valign='top'  class='h1'>";
$result.="<FORM METHOD=POST name='artist_form' id='artist_form' onsubmit='return check_this_form(this);' ACTION=\"javascript:artist_save(xajax.getFormValues('artist_form'));\"><INPUT TYPE='hidden' NAME='artist_id' value='";
if (isset ($artist->id)) $result.=$artist->id;
$result.="'><TABLE class='h3'><TR><TD valign='top'  class='h1'><TABLE width='99%'>
<TR><TD>Artist</TD><TD><INPUT TYPE='text' NAME='name' required='1'  value='";
if (isset($artist->name)) $result.=$artist->name;
$result.="'></TD></TR><TR style='display:none;'><TD>Contact person</TD><TD><INPUT TYPE='hidden' NAME='contact_person' value='";
if (isset($artist->contact_person)) $result.=$artist->contact_person;
$result.="'></TD></TR>";
$alist = array();
$alist[] = mosHTML::makeOption( '0', 'undefined ...', 'value', 'text'  );
if (isset($artist->id_agency))$database->setQuery( "SELECT id as value, name as text from #__agents  where id_agency=".$artist->id_agency." ORDER BY name" );
else $database->setQuery( "SELECT id as value, name as text from #__agents  where status >=0 ORDER BY name" );
$alist = array_merge($alist,$database->loadObjectList());
if (isset($artist->id_agent)) $agnts=$artist->id_agent; else $agnts=0;
$n=mosHTML::selectList( $alist, 'id_agent', " id='id_agent' ", 'value', 'text', $agnts );
$result.="<TR><TD>Agency</TD><TD>".$m."</TD><TD>";
$result.="<TR><TD>Agent</TD><TD><div id='agent_selector' name='agent_selector'>".$n."</div></TD><TD>";
$result.="<TR><TD>Street address 1</TD><TD><INPUT TYPE='text' id='street_addr1' NAME='street_addr1' value='";
if (isset($artist->street_addr1)) $result.=$artist->street_addr1;
$result.="'></TD></TR><TR><TD>Street address 2</TD><TD><INPUT TYPE='text' id='street_addr2' NAME='street_addr2' value='";
if (isset($artist->street_addr2)) $result.=$artist->street_addr2;
$result.="'></TD></TR><TR><TD>City code (ZIP)</TD><TD><INPUT TYPE='text' id='city_code' NAME='city_code' value='";
if (isset($artist->city_code)) $result.=$artist->city_code;
$result.="'></TD></TR><TR><TD>Town</TD><TD><INPUT TYPE='text' id='town' NAME='town' value='";
if (isset($artist->town)) $result.=$artist->town;
$result.="'></TD></TR><TR><TD>Country</TD><TD>";
$clist = array();
$clist[] = mosHTML::makeOption( '0', '........', 'value', 'text'  );
$database->setQuery( "SELECT id as value, name as text FROM #__countries  ORDER BY name" );   // where  world LIKE  'europe'
$clist = array_merge($clist,$database->loadObjectList());
if (isset($artist->country)) $result.=mosHTML::selectList( $clist, 'country', " id='country' ", 'value', 'text', $artist->country );
  else  $result.=mosHTML::selectList( $clist, 'country', " id='country' ", 'value', 'text', 0);
$result.="</TD></TR><TR><TD>Local phone</TD><TD><INPUT TYPE='text' id='phone1' NAME='phone1' value='";
if (isset($artist->phone1)) $result.=$artist->phone1;
$result.="'></TD></TR><TR><TD>Cell phone</TD><TD><INPUT TYPE='text' id='phone2'NAME='phone2' value='";
if (isset($artist->phone2)) $result.=$artist->phone2;
$result.="'></TD></TR><TR><TD>e-mail</TD><TD><INPUT TYPE='text' id='email' NAME='email' value='";
if (isset($artist->email)) $result.=$artist->email;
$result.="' required='1'  email='1'></TD></TR><TR><TD>Website</TD><TD><INPUT TYPE='text' id='website' NAME='website' value='";
if (isset($artist->website)) $result.=$artist->website;
$result.="'></TD></TR>";
$result.="</TD></TR></TABLE></TD></TR><tr><td align='center' colspan=2>";
$result.="<input type='submit' value='Save' class='button'></td></tr></TABLE></FORM>";
$result.="</TD></TR></TABLE></TD></TR></TABLE></TD></TR></TABLE>";
$objResponse = new xajaxResponse('UTF-8');
$objResponse->addAssign( 'info_div', 'innerHTML', $result );
return $objResponse->getXML();
}

function artist_delete($itemId,$mode=0){
global $database;
$query="update `#__artists` set status=-1 where `id`=".$itemId ;
//echo $query;
if ($mode==1) $query="delete from `#__artists` where `id`=".$itemId ;
$database->setQuery( $query);
$database->query();
$objResponse = new xajaxResponse('UTF-8');
$objResponse->addAssign( 'report_div', 'innerHTML', artists_list(0) );
return $objResponse->getXML();
}

function artist_restore($itemId){
global $database;
$query="update `#__artists` set status=0 where `id`=".$itemId ;
//echo $query;
$database->setQuery( $query);
$database->query();
$objResponse = new xajaxResponse('UTF-8');
$objResponse->addAssign( 'report_div', 'innerHTML', artists_list(0) );
return $objResponse->getXML();
}
function inquiry_delete($itemId, $mode=0){
global $database;
$query="update `#__inquiries` set status=-1 where `id`=".$itemId ;
if ($mode==1) $query="delete from `#__inquiries` where `id`=".$itemId ;
$database->setQuery( $query);
$database->query();
$objResponse = new xajaxResponse('UTF-8');
$objResponse->addAssign( 'report_div', 'innerHTML', inquirys_list(0) );
return $objResponse->getXML();
}

function inquiry_restore($itemId){
global $database;
$query="update `#__inquiries` set status=0 where `id`=".$itemId ;
//echo $query;
$database->setQuery( $query);
$database->query();
$objResponse = new xajaxResponse('UTF-8');
$objResponse->addAssign( 'report_div', 'innerHTML', inquirys_list(0) );
return $objResponse->getXML();
}

//==================================================================================================================


function editinquiryInfo($inq_id, $promoter=0)
{
global $database, $mosConfig_live_site;
$database->setQuery( "set names utf8" );$database->query();
if($inq_id>0){
$qr="SELECT * FROM #__inquiries WHERE id=".$inq_id ;
$database->setQuery( $qr);
$inqs = array();
$inqs = $database->loadObjectList();
  if (sizeof($inqs)>0)     { 	foreach ($inqs as $inq) {}   }
}
if($promoter>0){
$qr="SELECT * FROM #__promoters WHERE id=".$promoter;
$database->setQuery( $qr);
$promoters = $database->loadObjectList();
foreach ($promoters as $promoter) {}
}
$result="<TABLE align='center' valign='middle' width='100%' height='100%' cellpadding=0 cellspacing=0 border=0>
<TR>
	<TD>
<TABLE style='border:15px white solid;background-color: #eeeeee;' align='center' valign='middle' cellpadding=0 cellspacing=0>
<TR>
	<TD>
<TABLE class='h3' style='border:1px gray solid;background-color: #eeeeee;'><TR><td colspan=2 align='right'><button onclick='javascript:hideInfo2();'><IMG SRC='images/del.gif' WIDTH='20' HEIGHT='20' BORDER='0' ALT=''></button></td></TR>
<TR><TH colspan=2 class='h2'>";
if ($inq_id==0) $result.="Add Inquiry"; else $result.="Update Inquiry";
$result.="</TH>
</TR><TR><TD valign='top'  class='h1'>
<FORM METHOD=POST onsubmit='javascript:prepare_dates();' ACTION=\"javascript:save_inquiry(xajax.getFormValues('add_inq'));\" name='add_inq' id='add_inq'>
<input type='hidden' name='id' value='";
$result.=$inq_id;
$result.="'>
<input type='hidden' name='moredates' id='moredates'>
<TABLE>
<TR>
	<TD>Artist</TD><TD>";
$artists = array();
$database->setQuery( "SELECT id, name from #__artists  ORDER BY id" );
$artists = $database->loadObjectList();
if (isset($inq->id_artist)) $cnt=$inq->id_artist; else $cnt=1;
$cnt_list = mosHTML::selectList( $artists, 'id_artist', ' id="id_artist" ', 'id', 'name', $cnt );
$result.=$cnt_list;


$result.="</TD>
	<TD>Town</TD><TD><INPUT TYPE='text' NAME='town' id='town' size='20' value='";
if (isset($inq->town)) $result.=$inq->town; else $result.="";
if (isset($promoter->town)) $result.=$promoter->town; else $result.="";
$result.="'></TD>
</TR>
<TR>
	<TD valign='top' style='padding-top:6px;'>Date</TD><TD valign='top'><INPUT TYPE='text' NAME='venue_date' id='venue_date' size='20' value='";

if (isset($inq->venue_date)) $result.=substr_replace($inq->venue_date,'',16,16); else $result.="";
$result.="'>&nbsp;<a href='#' onclick='javascript:cal1xx.select(document.getElementById(\"venue_date\"),\"anchor1xx\",\"yyyy-MM-dd\");return false;'  NAME='anchor1xx' ID='anchor1xx'><img src='".$mosConfig_live_site."/images/itinerary-24x24.png' align='absmiddle' border=0></a>&nbsp;<a href='#' onclick='javascript:add_date();'><img src='images/add.gif' border='0' align='absmiddle'></a><br/><div id='date_container'>".get_inq_dated($inq_id)."</div></TD>
	<TD valign='top' style='padding-top:6px;'>Country</TD><TD valign='top'>";
$clist = array();
$clist[] = mosHTML::makeOption( '0', '......', 'value', 'text'  );
$database->setQuery( "SELECT id as value, name as text FROM #__countries   ORDER BY name" );  //where  world LIKE  'europe'
$clist = array_merge($clist,$database->loadObjectList());
if (isset($inq_id)&&$inq_id>0){
if (isset($inq->country)) $result.=mosHTML::selectList( $clist, 'country', " id='country' ", 'value', 'text', $inq->country );
else  $result.=mosHTML::selectList( $clist, 'country', " id='country' ", 'value', 'text', 0);
}else {
if (isset($promoter->country)) $result.=mosHTML::selectList( $clist, 'country', " id='country' ", 'value', 'text', $promoter->country ); else  $result.=mosHTML::selectList( $clist, 'country', " id='country' ", 'value', 'text', 0);
}
$result.="</TD></TR>";
$alist = array();
$alist[] = mosHTML::makeOption( '0', 'select promoter ...', 'value', 'text'  );
$database->setQuery( "SELECT id as value, name as text from #__promoters  where status >=0 ORDER BY name" );
$alist = array_merge($alist,$database->loadObjectList());
if (isset($inq->id_promoter)) $agnts=$inq->id_promoter; else $agnts=0;
if ($promoter->id>0) $agnts=$promoter->id;
$selector.=mosHTML::selectList( $alist, 'id_promoter', " id='id_promoter' style='width:160px;' onchange='javascript:get_promoter_data(this.value);'", 'value', 'text', $agnts );
$result.="<TR>
	<TD>Promoter</TD><TD>".$selector."<a href='#' onclick='javascript:swap_promoters(1)' id='link_new' style='margin-left:5px;'>new</a>
    <INPUT TYPE='text' NAME='company' id='company' size='20'style='display:none;' value='";
if (isset($inq->company)) $result.=$inq->company;
if (isset($promoter->company)) $result.=$promoter->name;
$result.="'><a href='#' onclick='javascript:swap_promoters(0)' id='link_old' style='margin-left:5px;display:none;'>existed</a>
<a id='check_link' style='display:none;' href='#' onclick=\"javascript:check_name(document.getElementById('company').value,'promoters',0,'get_promoter_data');\">check&nbsp;name</a><br>
<div id='check_results' name='check_results'></div>
</TD>
	<TD>Local phone</TD><TD><INPUT TYPE='text' NAME='phone1' id='phone1' size='20' value='";
if (isset($inq->phone1)) $result.=$inq->phone1; else $result.="";
if (isset($promoter->phone1)) $result.=$promoter->phone1; else $result.="";
$result.="'></TD>
</TR>
<TR>
	<TD>Contact person</TD><TD><INPUT TYPE='text' NAME='contact_person' id='contact_person' size='20' value='";
if (isset($inq->contact_person)) $result.=$inq->contact_person; else $result.="";
if (isset($promoter->contact_person)) $result.=$promoter->contact_person; else $result.="";
$result.="'></TD>
	<TD>Cell phone</TD><TD><INPUT TYPE='text' NAME='phone2' id='phone2' size='20' value='";
if (isset($inq->phone2)) $result.=$inq->phone2; else $result.="";
if (isset($promoter->phone2)) $result.=$promoter->phone2; else $result.="";
$result.="'></TD>
</TR>
<TR>
	<TD>Street address 1</TD><TD><INPUT TYPE='text' NAME='address1' id='street_addr1' size='20' value='";
if (isset($inq->address1)) $result.=$inq->address1; else $result.="";
if (isset($promoter->street_addr1)) $result.=$promoter->street_addr1; else $result.="";
$result.="'></TD>
	<TD>Email</TD><TD><INPUT TYPE='text' NAME='email' id='email' size='20' value='";
if (isset($inq->email)) $result.=$inq->email; else $result.="";
if (isset($promoter->email)) $result.=$promoter->email; else $result.="";
$result.="'></TD>
</TR>
<TR>
	<TD>Street address 2</TD><TD><INPUT TYPE='text' NAME='address2' id='street_addr2' size='20' value='";
if (isset($inq->address2)) $result.=$inq->address2; else $result.="";
if (isset($promoter->street_addr2)) $result.=$promoter->street_addr2; else $result.="";
$result.="'></TD>
	<TD>Website</TD><TD><INPUT TYPE='text' NAME='www' size='20'  id='website' value='";
if (isset($inq->www)) $result.=$inq->www; else $result.="";
if (isset($promoter->website)) $result.=$promoter->website; else $result.="";
$result.="'></TD>
</TR>
<TR>
	<TD>City code</TD><TD><INPUT TYPE='text' NAME='city_code'  id='city_code' size='20' value='";
if (isset($inq->city_code)) $result.=$inq->city_code; else $result.="";
if (isset($promoter->city_code)) $result.=$promoter->city_code; else $result.="";
$result.="'></TD>
	<TD>&nbsp;</TD><TD>&nbsp;</TD>
</TR>
<TR>
	<TD>Comments</TD><TD colspan=3><TEXTAREA NAME='comments'  id='comments' ROWS='4' COLS='48'>";
if (isset($inq->comments)) $result.=$inq->comments; else $result.="";
if (isset($promoter->comments)) $result.=$promoter->comments; else $result.="";
$result.="</TEXTAREA></TD>
</TR>

                    <tr>
                      <td>Artist fee</td>
                      <td>
                      <input name='artist_fee' id='artist_fee' required  value='";
                      if (isset($inq->artist_fee)) $result.=$inq->artist_fee;  else $result.="0";
                      $result.="' size='10' onblur='javascript:calculate_fee();' >
                      </td>
                      <td>Admin. exp.</td>
                      <td>
                      <input name='admin_exp' id='admin_exp' required  value='";
                      if (isset($inq->admin_exp)) $result.=$inq->admin_exp;  else $result.="0";
                      $result.="' size='10'  onblur='javascript:calculate_fee();'>
                      </td>
                    </tr>
                    <tr>
                      <td>Productions exp.</td>
                      <td>
                      <input name='production_exp' id='production_exp' required  value='";
                      if (isset($inq->production_exp)) $result.=$inq->production_exp; else $result.="0";
                      $result.="' size='10'  onblur='javascript:calculate_fee();'>
                      </td>
                      <td>Other exp.</td>
                      <td>
                       <input name='other_exp' id='other_exp' required  value='";
                      if (isset($inq->other_exp)) $result.=$inq->other_exp; else $result.="0";
                      $result.="' size='10'  onblur='javascript:calculate_fee();'>
                      </td></tr>
                   <tr>
                      <td>Travel exp.</td>
                      <td>
                      <input name='travel_exp' id='travel_exp' required value='";
                      if (isset($inq->travel_exp)) $result.=$inq->travel_exp;  else $result.="0";
                      $result.="' size='10'  onblur='javascript:calculate_fee();'></div></td>
                      <td>Total exp.</td>
                      <td>
                      <input name='total_exp' id='total_exp' required value='";
                      if (isset($inq->total_exp)) $result.=$inq->total_exp;  else $result.="0";
                      $result.="' size='10' ></td>
                    </tr><tr>
                      <td colspan=2>&nbsp;</td>
                      <td>Currency abbr.</td>
                      <td>
                      <input name='currency' id='currency' required value='";
                      if (isset($inq->currency)) $result.=$inq->currency;  else $result.="";
                      $result.="' size='10' ></td></TR>


<TR>
	<TD colspan=4 align='center'><INPUT TYPE='submit' value='Save' type='button'></TD>
</TR>
</TABLE></FORM>
</TD></TR></TABLE></TD></TR></TABLE></TD></TR></TABLE>";

$objResponse = new xajaxResponse('UTF-8');
$objResponse->addAssign( 'info_div', 'innerHTML', $result );
return $objResponse->getXML();
}

function save_inquiry($fdatas){
    $o="";
$objResponse = new xajaxResponse('UTF-8');
global $database;
		$database->setQuery( "set names utf8" );
		$database->query();
foreach ($fdatas as $key => $fdata) {
	$fdatas[$key] = addslashes(strip_tags($fdata));
    $o.=$key."->".$fdata."\n";
}
if (($fdatas['artist_fee']=='undefined')||($fdatas['artist_fee']=='')) $fdatas['artist_fee']=0;
if (($fdatas['admin_exp']=='undefined')||($fdatas['admin_exp']=='')) $fdatas['admin_exp']=0;
if (($fdatas['production_exp']=='undefined')||($fdatas['production_exp']=='')) $fdatas['production_exp']=0;
if (($fdatas['other_exp']=='undefined')||($fdatas['other_exp']=='')) $fdatas['other_exp']=0;
if (($fdatas['travel_exp']=='undefined')||($fdatas['travel_exp']=='')) $fdatas['travel_exp']=0;
if (($fdatas['total_exp']=='undefined')||($fdatas['total_exp']=='')) $fdatas['total_exp']=0;

if($fdatas['id']>0) {

$query="update  #__inquiries set
`id_artist`=".$fdatas['id_artist'].",
`town`=\"".$fdatas['town']."\",
`country`=".$fdatas['country'].",
`company`=\"".$fdatas['company']."\",
`contact_person`=\"".$fdatas['contact_person']."\",
`phone1`=\"".$fdatas['phone1']."\",
`phone2`=\"".$fdatas['phone2']."\",
`address1`=\"".$fdatas['address1']."\",
`address2`=\"".$fdatas['address2']."\",
`email`=\"".$fdatas['email']."\",
`artist_fee`=".$fdatas['artist_fee'].",
`admin_exp`=".$fdatas['admin_exp'].",
`production_exp`=".$fdatas['production_exp'].",
`other_exp`=".$fdatas['other_exp'].",
`travel_exp`=".$fdatas['travel_exp'].",
`total_exp`=".$fdatas['total_exp'].",
`currency`=\"".$fdatas['currency']."\",
 ";

if (isset($fdatas['id_promoter'])) $query.=" `id_promoter`=".$fdatas['id_promoter'].", ";
$query.=" `www`=\"".$fdatas['www']."\",
`city_code`=\"".$fdatas['city_code']."\",
`comments`=\"".$fdatas['comments']."\",";

if (trim($fdatas['venue_date'])=='') $query.=" venue_date=NULL, ";else $query.="venue_date=\"".$fdatas['venue_date']."\",";
$query.="
`status`=1,
`whosupdate`=".$_COOKIE['operator_id']." where id=".$fdatas['id'];
		$database->setQuery( $query );
		$database->query();
} else {
$query="insert into  #__inquiries  (";
if (isset($fdatas['id_promoter'])) $query.=" `id_promoter`, ";
$query.=" `id_artist`,
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
`currency`,
`whosupdate`,
`artist_fee`,
`admin_exp`,
`production_exp`,
`other_exp`,
`travel_exp`,
`total_exp`
)
values (
";

if (isset($fdatas['id_promoter'])) $query.=" ".$fdatas['id_promoter'].", ";
$query.="
".$fdatas['id_artist'].",".$fdatas['country'].",\"".$fdatas['town']."\",\"".$fdatas['company']."\",\"".$fdatas['phone1']."\",
\"".$fdatas['contact_person']."\",\"".$fdatas['phone2']."\",\"".$fdatas['address1']."\",\"".$fdatas['email']."\",\"".$fdatas['address2']."\",\"".$fdatas['www']."\",\"".$fdatas['city_code']."\",\"".$fdatas['comments']."\",";

if (trim($fdatas['venue_date'])=='') $query.="NULL,";else $query.="\"".$fdatas['venue_date']."\",";

$query.=" 0,\"".$fdatas['currency']."\", ".$_COOKIE['operator_id'].",".$fdatas['artist_fee'].", ".$fdatas['admin_exp'].", ".$fdatas['production_exp'].", ".$fdatas['other_exp'].", ".$fdatas['travel_exp'].", ".$fdatas['total_exp'].")";
		$database->setQuery( $query );
		$database->query();

}
if($fdatas['id']>0) {
$database->setQuery( "delete from  #__inq_dates where inq_id=".$fdatas['id']);
$database->query();
if (isset($fdatas['moredates'])) { $sd=explode("|",$fdatas['moredates']);
          for($i=0;$i<sizeof($sd);$i++){
            if($sd[$i]!='') {
            $database->setQuery( "insert into #__inq_dates (date,inq_id) values('".$sd[$i]."',".$fdatas['id'].")" );
            $database->query();
          }
    }
}
} else {
$database->setQuery( "select id from #__inquiries order by id desc limit 1");
$idd=$database->loadResult();
$sd=explode("|",$fdatas['moredates']);
          for($i=0;$i<sizeof($sd);$i++){
            if($sd[$i]!='') {
            $database->setQuery( "insert into #__inq_dates (date,inq_id) values('".$sd[$i]."',".$idd.")" );
            $database->query();
          }
    }
}
$result=inquirys_list(0);
$objResponse->addAssign( 'report_div', 'innerHTML', $result );
return $objResponse->getXML();
}


function inquiry_list($id,$search="",$page=0){
if ($id=='undefined')$id=0;
if ($search=='undefined')$search="";
if ($page=='undefined')$page=0;
if (!isset($_COOKIE['now']))setcookie('prev',"href='#'"); else setcookie('prev',stripslashes($_COOKIE['now']) );
setcookie('now',"href='#' onclick='javascript:inquiry_list(".$id.",\"".$search."\",".$page.");' ");
$objResponse = new xajaxResponse('UTF-8');
$objResponse->addAssign( 'report_div', 'innerHTML', inquirys_list($id,$search,$page) );
$objResponse->addScript( "initializemap();");
return $objResponse->getXML();
}

function get_inq_coords($inq_id) {
 global $database;
 $coords="0,0"; $vdate="not-set";
 $q="select coalesce(p.coords,'(0,0)') as coord, coalesce(i.venue_date,'not-set') as vdate from #__promoters p, #__inquiries i where i.id_promoter=p.id and i.id=".intval($inq_id)." limit 1";
 $database->setQuery($q);
 if($resp = $database->loadRow()){
        $coords=$resp[0];
        $vdate=explode(" ",$resp[1]);
        $vdate=$vdate[0];
        }
 $objResponse = new xajaxResponse('UTF-8');
 $lt = str_replace(")","",str_replace("(","",$coords));
// $objResponse->addScript( "alert('".$lt."');");
// $objResponse->addScript( "addMarker2(".$lt.",'полная хуйня');");
 $objResponse->addScript( "addTextMarker(".$lt.",'".$vdate."');");
 return $objResponse->getXML();
}
function get_inq_coords2($inq_id) {
 global $database;
 $coords="0,0";
 $q="select coalesce(p.coords,'(0,0)') from #__promoters p, #__inquiries i where i.id_promoter=p.id and i.id=".intval($inq_id)." limit 1";
 $database->setQuery($q);
 $coords = $database->loadResult();
 $objResponse = new xajaxResponse('UTF-8');
 $lt = str_replace(")","",str_replace("(","",$coords));
// $objResponse->addScript( "alert('".$lt."');");
 $objResponse->addScript( "removeMarker(".$lt.");");
 return $objResponse->getXML();
}

function inquirys_list ($id, $search="",$page=0){
 
if ($id=='undefined')$id=0;
if ($page=='undefined')$page=0;
if ($search=='undefined')$search="";

global $_PERPAGE;
$per_page=$_PERPAGE;

$result= "";
if (isset($id)) $ss=$id; else $ss=0;

switch  ($ss)
{
 	case 0: $add=" and i.status >=0 "; break;
	case 1: $add=" and i.status >=0 "; break;
	case 2: $add=" and i.status =-1 "; break;
}
if ($search!="") $add=" and ( i.company like '%".$search."%' or  i.contact_person like '%".$search."%')";
 $result.= "
  <table width='95%'  border='0' align='center' cellpadding='0' cellspacing='0'>
      <tr>
        <td width='53%' class='style4'>Inquires <span id='map_button'><button onclick='show_the_map();'>make a route</button></span></td>
        <td width='47%' class='style4'>".displays_search_form(0)."</td>
      </tr>
    </table><br />
";

$query2="SELECT count(*) from  #__inquiries i,  #__artists a where a.id=i.id_artist ".$add."
ORDER BY i.status asc, i.venue_date desc
";

$head="";
global $database;
$database->setQuery( "set names utf8" );
$database->query();
$promoters = array();
$database->setQuery( $query2 );
$counts = $database->loadResult();
//$result.=$counts;
$pages=ceil($counts/$per_page);
if ($page==0) $page=1;
$limits=" LIMIT ".($page-1)*$per_page.",".$per_page." ";
$paginator="<select id='paginator' name='paginator' onchange='javascript:inquiry_list(".$id.",\"".$search."\",this.value);'>";
for ($i=1;$i<=$pages;$i++) {
$paginator.="<option value='".$i."'";
if ($page==$i)$paginator.=" selected ";
$paginator.=">".$i."</option>";}
$paginator.="</select>";
$query="select i.*, a.name as artist_name ,p.name as promoter_name, coalesce(( SELECT GROUP_CONCAT( z.date ORDER BY z.date DESC SEPARATOR '<br/>') from #__inq_dates z where z.inq_id = i.id),' ') as ddates
 from  #__inquiries i,  #__artists a, #__promoters p where i.id_promoter=p.id and a.id=i.id_artist ".$add."
ORDER BY i.status asc, i.venue_date desc".$limits;
//$result.=$query;
$np=$page+1;$pp=$page-1;
if (1==$page)$links="<div align='center'><span class='style11'><img border=0 src='images/back-24x24.png' align='absmiddle'>&nbsp;prev&nbsp;page&nbsp;";
else $links="<div align='center'><a href='#' onclick='javascript:inquiry_list(".$id.",\"".$search."\",".$pp.");'><img border=0 src='images/back-24x24.png' align='absmiddle'></a>&nbsp;<a class='style11' href='#' onclick='javascript:inquiry_list(".$id.",\"".$search."\",".$pp.");'>prev&nbsp;page</a>&nbsp;";
$links.= $paginator;
if ($pages==$page)$links.="<span class='style11'>&nbsp;next&nbsp;page&nbsp;<img border=0 src='images/next-24x24.png' align='absmiddle'></span>";
else $links.="&nbsp;<a class='style11' href='#' onclick='javascript:inquiry_list(".$id.",\"".$search."\",".$np.");'>next&nbsp;page</a>&nbsp;<a href='#' onclick='javascript:inquiry_list(".$id.",\"".$search."\",".$np.");'><img border=0 src='images/next-24x24.png' align='absmiddle'></a>";


$head="";
$inquirys = array();
$database->setQuery( $query );
$inquirys = $database->loadObjectList();

if (sizeof($inquirys)>0)  $result.= $head; else {

if($search)
$result.= "<table width='95%' border='0' align='center' cellpadding='0' cellspacing='1' bgcolor='#999999'>
              <tr>
                <td bgcolor='#999999' class='style4'><table width='100%' border='0' align='center' cellpadding='0' cellspacing='1'><td height='36' colspan='3' bgcolor='#FFFFFF'>
                <span class='style5'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;You search for&nbsp;<b>".$search."</b>,&nbsp;but nobody found...</span></td></TR>
                  <tr>
                    <td height='35' bgcolor='#FFFFFF'>&nbsp;&nbsp;
                    <a href='#' onclick='javascript:editinquiryInfo(0);'><img src='images/comment-add-24x24.png'   align='absmiddle' border=0></a>&nbsp;&nbsp;<a href='#' onclick='javascript:editinquiryInfo(0);'  class='style11'>Add New Inquiry</a></td>
                    <td height='35' colspan='2' bgcolor='#FFFFFF'>&nbsp;</td>
                  </tr>
                </table></td>
                  </tr>
                </table>


";
else {

 $result.=" <table   id='inqlist22' width='95%' border='0' align='center' cellpadding='0' cellspacing='1' bgcolor='#999999'>
              <tr>
                <td bgcolor='#999999' class='style4'><table width='100%' border='0' align='center' cellpadding='0' cellspacing='1'>
                  <tr>
                    <td height='36' colspan='3' bgcolor='#FFFFFF'>&nbsp;&nbsp;<span class='style5'>Inquires</span>&nbsp;&nbsp;&nbsp;";

if($search) $result.="<span class='style5'>You search for:&nbsp;<b>".$search."</b></span>";
else {
if ($ss!=0) $result.= "<A HREF='#' onclick='javascript:inquiry_list(0);' class='style11'>Active</A>";else  $result.= "[<B>Active</B>]";
 $result.= "&nbsp;|&nbsp;";
if ($ss!=1) $result.= "<A HREF='#' class='style11' onclick='javascript:inquiry_list(2);' >Deleted</A>";else  $result.= "[<B>Deleted</B>]";
}
$result.="</td></tr>";
$result.="

                  <tr>
                    <td height='35' bgcolor='#FFFFFF'  colspan='3'>&nbsp;&nbsp;
                    <!--<a href='#' onclick='javascript:editinquiryInfo(0);'><img src='images/comment-add-24x24.png'   align='absmiddle' border=0></a>&nbsp;&nbsp;<a href='#' onclick='javascript:editinquiryInfo(0);'  class='style11'>Add New Inquiry</a>--></td>
                  </tr>
                </table></td>
              </tr>
            </table>

     ";
}

return $result;
}


$act_del="";
$result.= "<table id='inqlist22' width='95%' border='0' align='center' cellpadding='0' cellspacing='1' bgcolor='#999999'>
<tr><td bgcolor='#999999' class='style4'><table width='100%' border='0' align='center' cellpadding='0' cellspacing='1'>";

if($search) $result.="<tr><td height='36' colspan='4' bgcolor='#FFFFFF'>&nbsp;&nbsp;<span class='style5'>Inquires</span>&nbsp;&nbsp;&nbsp;<span class='style5'>You search for:&nbsp;<b>".$search."</b></span></td></tr>";

if ($ss!=0) $act_del.= "<A HREF='#' onclick='javascript:inquiry_list(0);' class='style11'>Active</A>";else  $act_del.= "[<B>Active</B>]";
 $act_del.= "&nbsp;|&nbsp;";
if ($ss!=1) $act_del.= "<A HREF='#' class='style11' onclick='javascript:inquiry_list(2);' >Deleted</A>";else  $act_del.= "[<B>Deleted</B>]";
$result.="";




$head1=0;$head2=0;
foreach ($inquirys as $inquiry)
{  $vd = explode(" ",$inquiry->venue_date);
    if ($inquiry->ddates>"")$inquiry->ddates="<br/>".$inquiry->ddates;
    if  ($inquiry->status==0){
    if(!$head1) $result.="<tr><td height='36' colspan='4' bgcolor='#FFFFFF'>&nbsp;&nbsp;<span class='style5'>New Inquires</span>&nbsp;&nbsp;&nbsp;".$act_del."</td></tr>
    <tr><td height='36' class='style18'>Promoter</td><td class='style18'>Artist</td><td class='style18'>Perf. date</td><td class='style18'>Id</td></tr>";
    $head1++;
    }
    if  ($inquiry->status==1){
    if(!$head2) $result.="<tr><td height='36' colspan='4' bgcolor='#FFFFFF'>&nbsp;&nbsp;<span class='style5'>Inquires (added to main base)</span>&nbsp;&nbsp;&nbsp;".$act_del."</td></tr>
    <tr><td height='36' class='style18'>Promoter</td><td class='style18'>Artist</td><td class='style18'>Perf. date</td><td class='style18'>Id</td></tr>";
    $head2++;
    }
    if  ($inquiry->status<0){
    if(!$head2) $result.="<tr><td height='36' colspan='4' bgcolor='#FFFFFF'>&nbsp;&nbsp;<span class='style5'>Deleted Inquires</span>&nbsp;&nbsp;&nbsp;".$act_del."</td></tr>
    <tr><td height='36' class='style18'>Promoter</td><td class='style18'>Artist</td><td class='style18'>Perf. date</td><td class='style18'>Id</td></tr>";
    $head2++;
    }

if (($head1>0)&&($head2==0)){
$result.="<tr><td width='48%' height='35' bgcolor='#FFCCCC'>&nbsp;&nbsp;
<a href='#' onclick='javascript:editinquiryInfo(".$inquiry->id.");' title='Get info on this Inquiry'>
<img src='images/blog-post-edit-24x24.png'  align='absmiddle' border='0'></a>&nbsp;
";

if($ss==0) {$result.="<a href='#' onclick='javascript:inquiry_delete(".$inquiry->id.");' title='Delete this Inquiry'>
            <img src='images/trash-empty-24x24.png'  align='absmiddle' border='0'></a>";}
else {
$result.="<a href='#' onclick='javascript:inquiry_restore(".$inquiry->id.");' title='Restore this Inquiry'>
          <img src='images/accept-24x24.png' align='absmiddle' border='0'></a>";}
$result.="&nbsp;&nbsp;&nbsp;
          <a class='style34' href='#' onclick='javascript:viewInquiry(".$inquiry->id.")'>".$inquiry->promoter_name ."</a>";
if ($inquiry->id_promoter==0) {$result.= "&nbsp;&nbsp;&nbsp;<span id='i".$inquiry->id."' name='i".$inquiry->id."' >
<a class='style6' href='#' onclick='add_promoter(".$inquiry->id.")' title='add customer to DB'><IMG SRC='images/user-add-24x24.png' align='absmiddle' BORDER='0' ALT='Add customer to DB'></a></span>";}

$result.="</td>
                    <td width='30%' bgcolor='#FFCCCC'><div align='center'><span class='style6'>".$inquiry->artist_name."</span></div></td>
                    <td width='12%' bgcolor='#FFCCCC'><div align='center'>".$vd[0].$inquiry->ddates."</div></td>
                    <td width='10%' bgcolor='#FFCCCC'><div align='center'>".$inquiry->id ."&nbsp;&nbsp;<input type='checkbox' id='inq_".$inquiry->id."' onchange='get_set_marker(".$inquiry->id.");' /></div></td>
                  </tr>
";
}
else {
  $result.="<tr><td width='48%' height='35' bgcolor='white'>
   &nbsp;&nbsp;&nbsp;<a href='#' onclick='javascript:editinquiryInfo(".$inquiry->id.");' title='Get info on this Inquiry'><img src='images/blog-post-edit-24x24.png'  align='absmiddle' border='0'></a>&nbsp;
";

if($ss==0) $result.="<a href='#' onclick='javascript:inquiry_delete(".$inquiry->id.");' title='Delete this Inquiry'><img src='images/trash-empty-24x24.png'  align='absmiddle' border='0'></a>";
else{ $result.="<a href='#' onclick='javascript:inquiry_restore(".$inquiry->id.");' title='Restore this Inquiry'><img src='images/accept-24x24.png' align='absmiddle' border='0'></a>";
$result.="&nbsp;&nbsp;<a href='#' onclick='javascript:inquiry_delete(".$inquiry->id.", 1 );' title='Delete this Inquiry forever!!'><img src='images/remove-24x24.png'  align='absmiddle' border='0'></a>";
}
$result.="&nbsp;&nbsp;&nbsp;<a class='style34' href='#' onclick='javascript:viewInquiry(".$inquiry->id.")'>".$inquiry->promoter_name."</a>";
if ($inquiry->id_promoter==0) { $result.= "&nbsp;&nbsp;&nbsp;<span id='i".$inquiry->id."' name='i".$inquiry->id."'>
<a class='style6' href='#' onclick='add_promoter(".$inquiry->id.")' title='add customer to DB'><IMG SRC='images/user-add-24x24.png' align='absmiddle' BORDER='0' ALT='Add customer to DB'></a></span>";
}
$result.="</td><td width='30%' bgcolor='white'><div align='center'><span class='style6'>".$inquiry->artist_name."</span></div></td>
                    <td width='12%' bgcolor='white'><div align='center'>".$vd[0].$inquiry->ddates."</div></td>
                    <td width='10%' bgcolor='white' id='box_".$inquiry->id."'><div align='center'>".$inquiry->id ."&nbsp;&nbsp;<input type='checkbox' id='inq_".$inquiry->id."' onchange='get_set_marker(".$inquiry->id.");' /></div></td>
                  </tr>
";
}
}
$result.="<tr><td height='35' bgcolor='#FFFFFF'>&nbsp;&nbsp;
                  <!--  <a href='#' onclick='javascript:editinquiryInfo(0);'><img src='images/comment-add-24x24.png'   align='absmiddle' border=0></a>&nbsp;&nbsp;<a href='#' onclick='javascript:editinquiryInfo(0);'  class='style11'>Add New Inquiry</a>--></td>
                    <td height='35' colspan='3' bgcolor='#FFFFFF'>".$links."</div></td>
                  </tr>
                </table></td>
              </tr>
            </table>

             <div id='map_canvas' style='height:600px;top:5px'></div>

";



return  $result;
}


function add_promoter($id)
{
        global $database;
		$database->setQuery( 'select * FROM #__inquiries where id='.$id );
		$inquiries = $database->loadObjectList();
        foreach ($inquiries as $inquiry){
		$update =" insert into #__promoters ( `name`, `contact_person`, `street_addr1`, `street_addr2`, `city_code`, `town`, `country`, `phone1`, `phone2`, `email`, `website`, `status`, `lastupdate`, `whosupdate`) values
(\"".$inquiry->company."\",\"".$inquiry->contact_person."\", \"".$inquiry->address1."\", \"".$inquiry->address2."\", \"".$inquiry->city_code."\", \"".$inquiry->town."\", \"".$inquiry->country."\", \"".$inquiry->phone1."\", \"".$inquiry->phone2."\", \"".$inquiry->email."\", \"".$inquiry->www."\", 0, CURRENT_TIMESTAMP,".$_COOKIE['operator_id'].")";

		global $database;
		$database->setQuery( "set names utf8" );
		$database->query();
		$database->setQuery( $update );
		$database->query();
		$update ="update #__inquiries i set i.id_promoter=(select max(p.id) from #__promoters p) where i.id=".$id;
		$database->setQuery( $update );
		$database->query();

}
$result=inquirys_list(0);
$objResponse = new xajaxResponse('UTF-8');
$objResponse->addAssign( 'report_div', 'innerHTML', $result );
return $objResponse->getXML();

}

//==================================================================================================================

function promoter_save($promoter_data) {

global $database;$result="";
$database->setQuery( "set names utf8" );
$database->query();
foreach ($promoter_data as $key => $value) {
	$promoter_data[$key] = addslashes(strip_tags($value));
}


if ((isset($promoter_data['promoter_id']))&&($promoter_data['promoter_id']>0))
{
$update="
update #__promoters set
`name` = '".$promoter_data['name']."',
`contact_person` = '".$promoter_data['contact_person']."',
`street_addr1` = '".$promoter_data['street_addr1']."',
`street_addr2` = '".$promoter_data['street_addr2']."',
`city_code` = '".$promoter_data['city_code']."',
`town` = '".$promoter_data['town']."',
`location` = '".$promoter_data['location']."',
`country` ='".$promoter_data['country']."',
`phone1` = '".$promoter_data['phone1']."',
`phone2` = '".$promoter_data['phone2']."',
 `email` = '".trim($promoter_data['email'])."',
 `weeknum` = '".$promoter_data['weeknum']."',
 `website` = '".$promoter_data['website']."',
 `comments` = '".$promoter_data['comments']."',
 `capacity` = '".$promoter_data['capacity']."',
 `priority` = '".$promoter_data['priority']."',
 `whosupdate` = ".$_COOKIE['operator_id'].",
 `lastupdate` = CURRENT_TIMESTAMP
where id=".$promoter_data['promoter_id'];

}
else {
$update ="
insert into #__promoters (
`name`, `contact_person`, `street_addr1`, `street_addr2`, `city_code`, `town`, `location`,`country`, `phone1`, `phone2`, `email`, `weeknum`, `website`, `status`, `lastupdate`, `whosupdate`, `comments`, `capacity`, `priority`) values
('".$promoter_data['name']."', '".$promoter_data['contact_person']."', '".$promoter_data['street_addr1']."', '".$promoter_data['street_addr2']."', '".$promoter_data['city_code']."', '".$promoter_data['town']."','".$promoter_data['location']."', '".$promoter_data['country']."', '".$promoter_data['phone1']."', '".$promoter_data['phone2']."', '".$promoter_data['email']."', '".$promoter_data['weeknum']."', '".$promoter_data['website']."', 0, CURRENT_TIMESTAMP,".$_COOKIE['operator_id'].", '".$promoter_data['comments']."', '".$promoter_data['capacity']."','".$promoter_data['priority']."')";

}
		$database->setQuery( $update );
		$database->query();

$objResponse = new xajaxResponse('UTF-8');
$objResponse->addAssign( 'report_div', 'innerHTML',promoters_list(0) );
return $objResponse->getXML();
}
//==================================================
function update_priority_promoter($id,$to_priority){
global $database;
$update ="update #__promoters set priority=".$to_priority." where id=".$id;
$database->setQuery( $update );
$database->query();
($to_priority<3)?$ppp=$to_priority+1:$ppp=0;
$result = "<a name='#' onclick='javascript:update_priority_promoter(".$id.",".$ppp.");return false;' title='Click to change priority to ".$to_priority."' class='pri_bt cl".$to_priority."'></a>";
$objResponse = new xajaxResponse('UTF-8');
$objResponse->addAssign( 'stat_'.$id, 'innerHTML',$result );
return $objResponse->getXML();
}

//==============================================================================================
function promoter_list($id,$search="",$page=0,$weeknum="", $country=0,$town="",$priority=0) {
if ($search=='undefined')$search="";
if ($weeknum=='undefined')$weeknum="";
if ($town=='undefined')$town="";
setcookie('prev',stripslashes($_COOKIE['now']) );
setcookie('now',"href='#' onclick='javascript:promoter_list(".$id.",\"".$search."\",".$page.",\"".$weeknum."\",\"".$country."\",\"".$town."\",\"".$priority."\");' ");
$objResponse = new xajaxResponse('UTF-8');
$objResponse->addAssign( 'report_div', 'innerHTML', promoters_list($id,$search,$page,$weeknum,$country,$town,$priority) );
return $objResponse->getXML();
}
   //case 12: {$result.=promoters_list(0,"",0,$what,$country,$town);break;}

//------------------------------------------------------------------------------
function promoters_list($id,$search="",$page=0,$weeknum="",$country=0,$town="",$priority=0) {
global $database,$mosConfig_absolute_path,$_PERPAGE;
$wnn=$wne =$weeknum; $id=intval($id);
if ($country=='undefined')$country=0;
$country_name="";
if ($town=='undefined')$town="";
$per_page=$_PERPAGE;
if (isset($id)) $ss=$id; else $ss=0;
if($weeknum!="") {
            $wn="'xx'";
            if ((strpos ($weeknum,'-'))>0){
            $numbers = split('[/,.-]', $weeknum);
            $nmin=$numbers[0];
             while ($nmin < $numbers[1]){
                       $wn.=",'".$nmin."'";
                        $nmin++;
                     }
    }else {
            if (strpos($weeknum,",")>0){
                $numbers =split('[/.-]', $weeknum);
                if (sizeof($numbers)>1){
                foreach ($numbers as $number) {
                    $wn.=",'".$number."'";
                     }
                }
                } else $weeknum="'".$weeknum."'";
       }
    }
$database->setQuery( "set names utf8" );
$database->query();
if (is_array($country)&&(sizeof($country)>0)) { $country=implode(',',$country);}
$add=" where 1=1 ";
if ($search!="")  $add .=" and (upper(a.name) like '%".mb_strtoupper(mb_convert_encoding($search,'utf8','UTF-8'))."%' or  upper(a.name) like '%".mb_strtoupper($search)."%'  or  upper(a.contact_person) like '%".mb_strtoupper(htmlentities($search,ENT_QUOTES,"UTF-8"))."%' or  upper(a.contact_person) like '%".mb_strtoupper($search)."%' or  upper(a.email) like '%".mb_strtoupper($search)."%' ) ";
if ($weeknum!="") $add .=" and a.weeknum in (".$weeknum.") ";
if ($town!="") $add .=" and upper(a.location) like '%".mb_strtoupper(mb_convert_encoding($town,'utf8','UTF-8'))."%' ";
if ((sizeof($country) >0)&&($country!=0)) {
        $add .=" and a.country in (".$country.") ";
        $database->setQuery( "select name from #__countries where id in (".$country.")") ;
        $country_names= $database->loadObjectList();
        foreach ($country_names as $cn){$country_name.= $cn->name.", ";}
}
switch ($priority){
         case 1: $add.="and a.priority = 0"; break;
         case 2: $add.="and a.priority = 1"; break;
         case 3: $add.="and a.priority = 2"; break;
         case 4: $add.="and a.priority = 3"; break;
         default: break;
}
if ($ss) $add.=" and a.status= -1"; else $add.=" and a.status >=0 ";
$query2="SELECT count(*) from #__promoters a ".$add." order by a.id desc ";
$promoters = array();
$database->setQuery( $query2 );
$counts = $database->loadResult();
$pages=ceil($counts/$per_page);
if($page>$pages)$page=$pages;
if ($page==0) $page=1;
        $limits=" LIMIT ".($page-1)*$per_page.",".$per_page." ";
        $paginator="<select id='paginator' name='paginator' onchange='javascript:promoter_list(".$id.",\"".$search."\",this.value,\"".$wnn."\",\"".$country."\",\"".$town."\");'>";
        for ($i=1;$i<=$pages;$i++) {
            $paginator.="<option value='".$i."'";
            if ($page==$i)$paginator.=" selected ";
            $paginator.=">".$i."</option>";

        }
        $paginator.="</select>";

$query="SELECT *, (select count(*) from #__select b where a.id=b.id and b.type='promoter' and b.user=".$_COOKIE['operator_id'].") as checked  from #__promoters a ".$add."
order by a.priority desc, a.id desc".$limits;
$np=$page+1;$pp=$page-1;
if (1==$page)$links="<div align='center'><span class='style11'><img border=0 src='images/back-24x24.png' align='absmiddle'>&nbsp;prev&nbsp;page&nbsp;";
else $links="<div align='center'><a href='#' onclick='javascript:promoter_list(".$id.",\"".$search."\",".$pp.",\"".$wnn."\",\"".$country."\");'><img border=0 src='images/back-24x24.png' align='absmiddle'></a>&nbsp;<a class='style11' href='#' onclick='javascript:promoter_list(".$id.",\"".$search."\",".$pp.",\"".$wnn."\",\"".$country."\",\"".$town."\");'>prev&nbsp;page</a>&nbsp;";
$links.= $paginator;
if ($pages==$page)$links.="<span class='style11'>&nbsp;next&nbsp;page&nbsp;<img border=0 src='images/next-24x24.png' align='absmiddle'></span>";
else $links.="&nbsp;<a class='style11' href='#' onclick='javascript:promoter_list(".$id.",\"".$search."\",".$np.",\"".$wnn."\",\"".$country."\");'>next&nbsp;page</a>&nbsp;<a href='#' onclick='javascript:promoter_list(".$id.",\"".$search."\",".$np.",\"".$wnn."\",\"".$country."\",\"".$town."\");'><img border=0 src='images/next-24x24.png' align='absmiddle'></a>";

$database->setQuery( $query );
$promoters = $database->loadObjectList();

$ft = new FastTemplate($mosConfig_absolute_path."/templates");
$ft->define(array(
                'head'  => "promoter_list_header.html",
                'item'  => "promoter_list_body.html",
                'foot'  => "promoter_list_footer.html"
));


$r1=$r2='';
if ((sizeof($country) >0)&&($country!=0)) $r1=' in <b>'.$country_name.'</b> ';
if ($weeknum!="") $r2=' in <b>'.$weeknum.'</b> week ';
if ($town!="") $r3=' in <b>'.$town.'</b>';
$STAT="";
if ($search||$weeknum||$country||$town) $STAT="<span class='style5'>You search for:&nbsp;<b>".$search."</b>  ".$r1.$r2.$r3."</span>";
else {
    if ($ss!=0) $STAT.= "<A HREF='#' onclick='javascript:promoter_list(0);' class='style11'>Active</A>";else  $STAT.= "[<B>Active</B>]";
                $STAT.= "&nbsp;|&nbsp;";
    if ($ss!=1) $STAT.= "<A HREF='#' class='style11' onclick='javascript:promoter_list(1);' >Deleted</A>";else $STAT.= "[<B>Deleted</B>]";
}


$ft->assign( array(
'STAT' =>  $STAT  ,
'ACT_ADD' => "<a href='#' class='topm addm' onclick='javascript:editpromoterInfo(0);'>Add New Promoter</a>",
'ACT_SEND_CHK' =>"<a href='#' class='topm sendc' onclick='javascript:checkbox_reader();'>Send emails to checked</a>" ,
'ACT_SEND_ALL' =>"<a href='#' class='topm senda' onclick='javascript:checkbox_reader(\"all_promoters\");' >Send ALL IN DB</a>" ,
'ACT_SMS_CHK' =>"<a href='#' class='topm smsc' onclick='javascript:sms_reader();'>Send SMS to checked</a>" ,
'ACT_SMS_ALL' =>"<a href='#' class='topm smsa' onclick='javascript:sms_reader(\"all_promoters\");' >Send SMS to ALL</a>" ,
'ACT_CHK_ALL' =>"<a href='#'  class='topm check' onclick='javascript:checkbox_checker();'>Check all</a>",
'ACT_UNCHK_ALL' =>"<a href='#'  class='topm uncheck' onclick='javascript:checkbox_unchecker();'>Uncheck all</a>" ,
'ACT_EXPORT' =>"<a href='#'  class='topm export'onclick='javascript:export_list(\"promoter\",".$id.",\"".$search."\",\"".$weeknum."\",\"".$country."\");' >Export all</a>" ,
'PRI1' => "<a href='#' onclick=\"javascript:promoter_list('".$id."','".$search."',".$page.",'".$weeknum."', ".$country.",'".$town."',4);\"><img src='images/square-red.png' border='0' hspace='2' >&nbsp;-&nbsp;Pri 1</a>&nbsp;&nbsp;&nbsp;",
'PRI2' => "<a href='#' onclick=\"javascript:promoter_list('".$id."','".$search."',".$page.",'".$weeknum."', ".$country.",'".$town."',3);\"><img src='images/square-yellow.png' border='0' hspace='2'>&nbsp;-&nbsp;Pri 2</a>&nbsp;&nbsp;&nbsp;",
'PRI3' => "<a href='#' onclick=\"javascript:promoter_list('".$id."','".$search."',".$page.",'".$weeknum."', ".$country.",'".$town."',2);\"><img src='images/square-green.png' border='0' hspace='2'>&nbsp;-&nbsp;Pri 3</a>&nbsp;&nbsp;&nbsp;",
'PRI4' => "<a href='#' onclick=\"javascript:promoter_list('".$id."','".$search."',".$page.",'".$weeknum."', ".$country.",'".$town."',1);\"><img src='images/square-white.png' border='0' hspace='2'>&nbsp;-&nbsp;no&nbsp;priority</a>"
                    ));
$ft->parse('HEAD', "head");
$html=$ft->FastPrint('HEAD',true);
foreach ($promoters as $promoter)
{
if ($promoter->priority==3)$to_priority=0;else $to_priority=1+$promoter->priority;
  switch ($promoter->priority){
  case 1: $img='square-red.png'; break;
  case 2: $img='square-yellow.png'; break;
  case 3: $img='square-green.png'; break;
  default: $img='square-white.png'; break;
}
($promoter->phone2)?$cell=" phone=\"".$promoter->phone2."\" ":$cell="";
if ($promoter->checked >0) $chk=" checked ";else $chk="";
($promoter->phone2)?$ph="<a href='#' onclick='javascript:send_sms_form(\"".$promoter->phone2."\",".$promoter->id.",\"".$promoter->contact_person."\",\"ajax\");'><img src='../images/n-smsa.png' style='float:left;margin:0px auto;' alt='Has cell phone ".$promoter->phone2."' />":$ph="";
       $ft->assign( array(
                    'ID' =>$promoter->id,
                    'NAME' =>$promoter->name,
                    'EMAIL' =>$promoter->email,
                    'ACT_EDIT' =>"<a href='#' onclick='javascript:editpromoterInfo(".$promoter->id.");' title='Edit info on this Promoter'><img src='images/blog-post-edit-24x24.png'  align='absmiddle' border='0'></a>",
                    'ACT_REST' =>($ss)?"<a href='#' onclick='javascript:promoter_restore(".$promoter->id.");' title='Restore this Promoter'><img src='images/accept-24x24.png' align='absmiddle' border='0'></a>":"",
                    'ACT_DEL' =>(!$ss)?"<a href='#' onclick='javascript:promoter_delete(".$promoter->id.");' title='Delete this Promoter'><img src='images/trash-empty-24x24.png'  align='absmiddle' border='0'></a>":"",
                    'ACT_DELDEL' =>($ss)?"<a href='#' onclick='javascript:promoter_delete(".$promoter->id.", 1 );' title='Delete this Promoter forever!!'><img src='images/remove-24x24.png'  align='absmiddle' border='0'></a>":"",
                    'PRI' =>$promoter->priority,
                    'TO_PRI' =>$to_priority,
                    'CHECKED' =>$chk,
                    'CELL' =>$ph,
                    'PHONE' =>$cell,
                    'CONTACT' => $promoter->contact_person
                    ));
        $ft->parse('ITEMS','.item');

}
if(sizeof($promoters)>0) $html.=$ft->FastPrint('ITEMS',true);
$ft->assign( array(
                'LINKS' => $links    ));
$ft->parse('FOOT','foot');
$html.=$ft->FastPrint('FOOT',true);
return $html;

}


function send_sms_form ($phone, $id=0,$name="", $response="ajax",$all="")
{
global $mosConfig_absolute_path, $database;
if ($all=="all_promoters"){
$database->setQuery( "set names utf8" );
$database->query();
$phones=array();
$database->setQuery( "select phone2 from #__promoters where phone2<>'' ") ;
$promomoters= $database->loadObjectList();
foreach ($promomoters as $promoter)
{$phones[]=trim($promoter->phone2);}
$phone=implode(",",$phones);
}
$ft = new FastTemplate($mosConfig_absolute_path."/templates");
$ft->define(array('item'  => "send_sms_form.html"));
$ft->assign( array(
'PHONE' =>  $phone,
'ID' =>  intval($id),
'NAME' => $name  ));
$ft->parse('ITEM', "item");
$html=$ft->FastPrint('ITEM',true);
if($response=="ajax"){
                        $objResponse = new xajaxResponse('UTF-8');
                        $objResponse->addAssign( 'info_div', 'innerHTML', $html);
                        return $objResponse->getXML();
                        }
                else { return $html; }
}


//------------------------------------------------------------------------------
function __promoters_list($id,$search="",$page=0,$weeknum="",$country=0,$town="",$priority=0) {
  global $database;
  $wnn= $weeknum;
  $wne= $weeknum;
$database->setQuery( "set names utf8" );
$database->query();
if ($id=='undefined')$id=0;
if ($country=='undefined')$country=0;
if ($town=='undefined')$town="";
global $_PERPAGE;
$per_page=$_PERPAGE;
$result="";
if (isset($id)) $ss=$id; else $ss=0;

switch  ($ss)
{
	case 0: $add=" where a.status >=0 "; break;
	case 1: $add=" where a.status= -1 "; break;
}


if  ($weeknum!="") {
$wn="'xx'";
if ((strpos ($weeknum,'-'))>0){
 $numbers = split('[/,.-]', $weeknum);
 $nmin=$numbers[0];
 while ($nmin < $numbers[1]){
   $wn.=",'".$nmin."'";
   $nmin++;
 }
}
else {
if (strpos($weeknum,",")>0){

$numbers =split('[/.-]', $weeknum);
if (sizeof($numbers)>1){
foreach ($numbers as $number) {
$wn.=",'".$number."'";
         }
    }
} else $weeknum="'".$weeknum."'";
}
}
//$result.=($country);
$country_name="";
$cc= -1;
if (is_array($country)&&(sizeof($country)>0)) {
//foreach ($country as $t){$result.= 'You selected '.$t.'<br />';
//
//}
$country=implode(',',$country);
}

$add=" where 1=1 ";
if ($search!="")  $add .=" and ( upper(a.name) like '%".mb_strtoupper(mb_convert_encoding($search,'utf8','UTF-8'))."%' or  upper(a.name) like '%".mb_strtoupper($search)."%'  or  upper(a.contact_person) like '%".mb_strtoupper(htmlentities($search,ENT_QUOTES,"UTF-8"))."%' or  upper(a.contact_person) like '%".mb_strtoupper($search)."%' ) ";
if ($weeknum!="") $add .=" and a.weeknum in (".$weeknum.") ";
if ($town!="") $add .=" and upper(a.location) like '%".mb_strtoupper(mb_convert_encoding($town,'utf8','UTF-8'))."%' ";
if ((sizeof($country) >0)&&($country!=0)) { $add .=" and a.country in (".$country.") ";

$database->setQuery( "select name from #__countries where id in (".$country.")") ;
$country_names= $database->loadObjectList();
foreach ($country_names as $cn){$country_name.= $cn->name.", ";}
}

switch ($priority){
 case 1: $add.="and a.priority = 0"; break;
 case 2: $add.="and a.priority = 1"; break;
 case 3: $add.="and a.priority = 2"; break;
 case 4: $add.="and a.priority = 3"; break;
 default: break;
}


if ($ss) $add.=" and a.status= -1"; else $add.=" and a.status >=0 ";
 $result.= "
  <table width='95%' border='0' align='center' cellpadding='0' cellspacing='0'>

      <tr>
        <td width='53%' class='style4'>Promoters</td>
        <td width='47%' align='right'><a href='#' onclick=\"javascript:promoter_list('".$id."','".$search."',".$page.",'".$weeknum."', ".$country.",'".$town."',2);\"><img src='images/square-red.png' border='0' hspace='2' >&nbsp;-&nbsp;Pri 1</a>&nbsp;&nbsp;&nbsp;<a href='#' onclick=\"javascript:promoter_list('".$id."','".$search."',".$page.",'".$weeknum."', ".$country.",'".$town."',3);\"><img src='images/square-yellow.png' border='0' hspace='2'>&nbsp;-&nbsp;Pri 2</a>&nbsp;&nbsp;&nbsp;<a href='#' onclick=\"javascript:promoter_list('".$id."','".$search."',".$page.",'".$weeknum."', ".$country.",'".$town."',4);\"><img src='images/square-green.png' border='0' hspace='2'>&nbsp;-&nbsp;Pri 3</a>&nbsp;&nbsp;&nbsp;<a href='#' onclick=\"javascript:promoter_list('".$id."','".$search."',".$page.",'".$weeknum."', ".$country.",'".$town."',1);\"><img src='images/square-white.png' border='0' hspace='2'>&nbsp;-&nbsp;no&nbsp;priority</a></td>
      </tr>
    </table><br />
";
$query2="SELECT count(*) from #__promoters a ".$add."
order by a.id desc ";
//  $result.=$query2;
$head="";

$promoters = array();
$database->setQuery( $query2 );
$counts = $database->loadResult();
//$result.=$counts;
$pages=ceil($counts/$per_page); if($page>$pages)$page=$pages;
if ($page==0) $page=1;
$limits=" LIMIT ".($page-1)*$per_page.",".$per_page." ";
$paginator="<select id='paginator' name='paginator' onchange='javascript:promoter_list(".$id.",\"".$search."\",this.value,\"".$wnn."\",\"".$country."\",\"".$town."\");'>";
for ($i=1;$i<=$pages;$i++) {
$paginator.="<option value='".$i."'";
if ($page==$i)$paginator.=" selected ";
$paginator.=">".$i."</option>";}
$paginator.="</select>";
$query="SELECT *, (select count(*) from #__select b where a.id=b.id and b.type='promoter' and b.user=".$_COOKIE['operator_id'].") as checked  from #__promoters a ".$add."
order by a.priority desc, a.id desc
".$limits;

$np=$page+1;$pp=$page-1;
if (1==$page)$links="<div align='center'><span class='style11'><img border=0 src='images/back-24x24.png' align='absmiddle'>&nbsp;prev&nbsp;page&nbsp;";
else $links="<div align='center'><a href='#' onclick='javascript:promoter_list(".$id.",\"".$search."\",".$pp.",\"".$wnn."\",\"".$country."\");'><img border=0 src='images/back-24x24.png' align='absmiddle'></a>&nbsp;<a class='style11' href='#' onclick='javascript:promoter_list(".$id.",\"".$search."\",".$pp.",\"".$wnn."\",\"".$country."\",\"".$town."\");'>prev&nbsp;page</a>&nbsp;";
$links.= $paginator;
if ($pages==$page)$links.="<span class='style11'>&nbsp;next&nbsp;page&nbsp;<img border=0 src='images/next-24x24.png' align='absmiddle'></span>";
else $links.="&nbsp;<a class='style11' href='#' onclick='javascript:promoter_list(".$id.",\"".$search."\",".$np.",\"".$wnn."\",\"".$country."\");'>next&nbsp;page</a>&nbsp;<a href='#' onclick='javascript:promoter_list(".$id.",\"".$search."\",".$np.",\"".$wnn."\",\"".$country."\",\"".$town."\");'><img border=0 src='images/next-24x24.png' align='absmiddle'></a>";
   //<div align='center'>".$paginator."&nbsp; &nbsp;next&nbsp;page&nbsp;<img border=0 src='images/next-24x24.png' align='absmiddle'></span></div>

$database->setQuery( $query );
$promoters = $database->loadObjectList();
// $result.=$query;

if (sizeof($promoters)>0)  $result.= $head; else {

if(($search)||($weeknum)||($country)||($town)){
$result.= "<table width='95%' border='0' align='center' cellpadding='0' cellspacing='1' bgcolor='#999999'>
              <tr>
                <td bgcolor='#999999' class='style4'><table width='100%' border='0' align='center' cellpadding='0' cellspacing='1'><td height='36' colspan='3' bgcolor='#FFFFFF'>
                <span class='style5'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;You search for&nbsp;<b>".$search."</b>,&nbsp;but nobody found...</span></td></TR>
                  <tr>
                    <td height='35' bgcolor='#FFFFFF'>&nbsp;&nbsp;
                    <a href='#' onclick='javascript:editpromoterInfo(0);'><img src='images/comment-add-24x24.png'   align='absmiddle' border=0></a>&nbsp;&nbsp;<a href='#' onclick='javascript:editpromoterInfo(0);'  class='style11'>Add New Promoter</a></td>
                    <td height='35' colspan='2' bgcolor='#FFFFFF'>";
$result.="<div class='style11'> <a href='#' onclick='javascript:checkbox_reader();' >
<img src='images/forward-new-mail-24x24.png' border=0 align='absmiddle'></a>
&nbsp;<a href='#' onclick='javascript:checkbox_reader();'  class='style11'>Send emails to checked</a>";
$result.="&nbsp;&nbsp;<a href='#' onclick='javascript:checkbox_checker(\"promoter\");' class='style11'>Check All</a>";
$result.="&nbsp;&nbsp;<a href='#' onclick='javascript:checkbox_unchecker(\"promoter\");' class='style11'>Uncheck All</a></div>";
$result.="</td>
                  </tr>
                </table></td>
                  </tr>
                </table>";
}else {
 $result.= "<table width='95%' border='0' align='center' cellpadding='0' cellspacing='1' bgcolor='#999999'>
              <tr>
                <td bgcolor='#999999' class='style4'><table width='100%' border='0' align='center' cellpadding='0' cellspacing='1'>
                  <tr>
                    <td height='36' colspan='3' bgcolor='#FFFFFF'>&nbsp;&nbsp;<span class='style5'>Promoters</span>&nbsp;&nbsp;&nbsp;";
if(($search)||($weeknum)||($town)||($country>0))  $result.="<span class='style5'>You search for:&nbsp;<b>".$search."</b></span>";
else {
                    if ($ss!=0) $result.= "<A HREF='#' onclick='javascript:promoter_list(0);' class='style11'>Active</A>";else  $result.= "[<B>Active</B>]";
 $result.= "&nbsp;|&nbsp;";
if ($ss!=1) $result.= "<A HREF='#' class='style11' onclick='javascript:promoter_list(1);' >Deleted</A>";else  $result.= "[<B>Deleted</B>]";
}
$result.="</td></tr>";
$result.="

                  <tr>
                    <td height='35' bgcolor='#FFFFFF'  colspan='3'>&nbsp;&nbsp;
                    <a href='#' onclick='javascript:editpromoterInfo(0);'><img src='images/comment-add-24x24.png'   align='absmiddle' border=0></a>&nbsp;&nbsp;<a href='#' onclick='javascript:editpromoterInfo(0);'  class='style11'>Add New Promoter</a>";
$result.="<div class='style11'> <a href='#' onclick='javascript:checkbox_reader(\"promoter\");' >
<img src='images/forward-new-mail-24x24.png' border=0 align='absmiddle'></a>
&nbsp;<a href='#' onclick='javascript:checkbox_reader(\"promoter\");'  class='style11'>Send emails to checked</a>";
$result.="&nbsp;&nbsp;<a href='#' onclick='javascript:checkbox_checker(\"promoter\");' class='style11'>Check All</a>";
$result.="&nbsp;&nbsp;<a href='#' onclick='javascript:checkbox_unchecker(\"promoter\");' class='style11'>Uncheck All</a></div>";

                  $result.="</td>
                  </tr>
                </table></td>
              </tr>
            </table>

     ";
}

return $result;
}
$result.= "<table width='95%' border='0' align='center' cellpadding='0' cellspacing='1' bgcolor='#999999'>
              <tr>
                <td bgcolor='#999999' class='style4'><table width='100%' border='0' align='center' cellpadding='0' cellspacing='1'>
                  <tr>
                    <td height='36' colspan='3' bgcolor='#FFFFFF'>&nbsp;&nbsp;<span class='style5'>Promoters</span>&nbsp;&nbsp;&nbsp;";
$r1=$r2='';
if ((sizeof($country) >0)&&($country!=0)) $r1=' in <b>'.$country_name.'</b> ';
if ($weeknum!="") $r2=' in <b>'.$weeknum.'</b> week ';
if ($town!="") $r3=' in <b>'.$town.'</b>';
if ($search||$weeknum||$country||$town) $result.="<span class='style5'>You search for:&nbsp;<b>".$search."</b>  ".$r1.$r2.$r3."</span>";
else {
                    if ($ss!=0) $result.= "<A HREF='#' onclick='javascript:promoter_list(0);' class='style11'>Active</A>";else  $result.= "[<B>Active</B>]";
 $result.= "&nbsp;|&nbsp;";
if ($ss!=1) $result.= "<A HREF='#' class='style11' onclick='javascript:promoter_list(1);' >Deleted</A>";else  $result.= "[<B>Deleted</B>]";
}
$result.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href='#' onclick='javascript:editpromoterInfo(0);'><img src='images/comment-add-24x24.png'   align='absmiddle' border=0></a>&nbsp;&nbsp;<a href='#' onclick='javascript:editpromoterInfo(0);'  class='style11'>Add New Promoter</a>";
$result.="&nbsp;&nbsp;<a href='#' onclick='javascript:checkbox_reader(\"checked_promoters\");' ><img src='images/forward-new-mail-24x24.png' border=0 align='absmiddle'></a> &nbsp;<a href='#' onclick='javascript:checkbox_reader(\"checked_promoters\");'  class='style11'>Send emails to checked</a>";
$result.="&nbsp;&nbsp;<a href='#' onclick='javascript:checkbox_reader(\"all_promoters\");' ><img src='images/forward-new-mail-24x24.png' border=0 align='absmiddle'></a> &nbsp;<a href='#' onclick='javascript:checkbox_reader(\"all_promoters\");'  class='style11'>Send&nbsp;ALL&nbsp;IN&nbsp;DB</a>";
$result.="&nbsp;&nbsp;<a href='#' onclick='javascript:checkbox_checker(\"promoter\");' class='style11'>Check All</a>";
$result.="&nbsp;&nbsp;<a href='#' onclick='javascript:checkbox_unchecker(\"promoter\");' class='style11'>Uncheck All</a>";
$result.="&nbsp;&nbsp;<a href='#' onclick='javascript:export_list(\"promoter\",$id,\"".$search."\",\"".$wne."\",\"".$country."\")' class='style11'>Export to mailing list</a>";

                  $result.="</td></tr>";

$result.="<tr><td height='36' class='style18'>Promoter</td><td class='style18'>Contact person</td><td class='style18'>Id</td></tr>";
foreach ($promoters as $promoter)
	{
$result.="
                  <tr>
                    <td width='50%' height='35' bgcolor='white'>&nbsp;";


 $result.="<input type='checkbox' align='absmiddle' id='promoter_".$promoter->id."' prop='mail' boxtype='promoter' email='".$promoter->email."' ";
 if ($promoter->checked >0) $result.=" checked ";
 $result.=">&nbsp;"  ;
                    $result.="&nbsp;<a href='#' onclick='javascript:editpromoterInfo(".$promoter->id.");' title='Edit info on this Promoter'><img src='images/blog-post-edit-24x24.png'  align='absmiddle' border='0'></a>&nbsp;
";

if($ss==0) $result.="<a href='#' onclick='javascript:promoter_delete(".$promoter->id.");' title='Delete this Promoter'><img src='images/trash-empty-24x24.png'  align='absmiddle' border='0'></a>";
else {$result.="<a href='#' onclick='javascript:promoter_restore(".$promoter->id.");' title='Restore this Promoter'><img src='images/accept-24x24.png' align='absmiddle' border='0'></a>";
$result.="&nbsp;&nbsp;<a href='#' onclick='javascript:promoter_delete(".$promoter->id.", 1 );' title='Delete this Promoter forever!!'><img src='images/remove-24x24.png'  align='absmiddle' border='0'></a>";

}
if ($promoter->priority==3)$to_priority=0;else $to_priority=1+$promoter->priority;
switch ($promoter->priority){
  case 1: $img='square-red.png'; break;
  case 2: $img='square-yellow.png'; break;
  case 3: $img='square-green.png'; break;
  default: $img='square-white.png'; break;
}
$result.="&nbsp;&nbsp;&nbsp;<a href='#' onclick='javascript:getpromoterInfo(".$promoter->id.");' title='Get info on this Promoter' class='style34'>".$promoter->name ."</a><div id='stat_".$promoter->id."' style='float:right;margin:2px 6px;cursor:pointer'><a name='#' onclick='javascript:update_priority_promoter(".$promoter->id.",".$to_priority.");' title='Click to change priority to ".$to_priority."'><img src='images/".$img."' ></a></div></td>
                    <td width='40%' bgcolor='white'><div align='center'>".$promoter->contact_person."</div></td>
                    <td width='10%' bgcolor='white'><div align='center'>".$promoter->id ."</div></td>
                  </tr>
";
}
$result.="

                  <tr>
                    <td height='35' bgcolor='#FFFFFF'>&nbsp;&nbsp;
                    <a href='#' onclick='javascript:editpromoterInfo(0);'><img src='images/comment-add-24x24.png'   align='absmiddle' border=0></a>&nbsp;&nbsp;<a href='#' onclick='javascript:editpromoterInfo(0);'  class='style11'>Add New Promoter</a></td>
                    <td height='35' colspan='2' bgcolor='#FFFFFF'>".$links."</td>
                  </tr>
                </table></td>
              </tr>
            </table>

     ";

return  $result;
}



function export_list($type,$id,$search,$weeknum,$country,$town='')
{
global $database,$mosConfig_absolute_path;
setcookie('prev',stripslashes($_COOKIE['now']) );
setcookie('now',"href='#' onclick=\"javascript:mm_edlist(".$id.");\" ");
$ft = new FastTemplate($mosConfig_absolute_path."/templates");
$ft->define(array('body'  => "mass_mail_list_add.tpl"));
//$es=email_selectors($to_type,$to_id,$data);

$database->setQuery( "set names utf8" );
$database->query();
$query="select id as value, name as text from #__mail_list order by name asc";
$database->setQuery( $query );
$clist = array();
$clist[] = mosHTML::makeOption( '0', 'Add to a new list', 'value', 'text'  );
$clist = array_merge($clist,$database->loadObjectList());
$subm="<div id='sendbutton'><INPUT TYPE='submit' value='Export!'></div>";
$ft->assign( array(
                    'TYPE' => $type,
                    'ID' => $id,
                    'SEARCH' => $search,
                    'WEEKNUM' => $weeknum,
                    'COUNTRY' => $country,
                    'TOWN' => $town,
                    'LIST_ID' => mosHTML::selectList( $clist, 'list_id', " id='list_id' onchange='javascript:hideopt(this.value);' ", 'value', 'text',0) ,
                    'SUBMIT'=> $subm,
                    'BACK' => stripslashes ($_COOKIE['now'])
                    ));


$ft->parse('BODY', "body");
$result=$ft->FastPrint("BODY",true);
$objResponse = new xajaxResponse('UTF-8');
$objResponse->addAssign( 'info_div', 'innerHTML', $result);
//$objResponse->addScript( 'replaceDiv("message")');
return $objResponse->getXML();
}

function export_list_save($formdata)
{
  foreach ($formdata as $key => $fdata) {
	$formdata[$key] = strip_tags($fdata);
  }
 $type = $formdata['type'];
 $id = $formdata['id'];
 $search = $formdata['search'];
 $weeknum = $formdata['weeknum'];
 $country = $formdata['country'];
 $town = $formdata['town'];
 $list_id = $formdata['list_id'];
 $list_name = $formdata['list_name'];


 global $database;
 $database->setQuery( "set names utf8" );
$database->query();
if ($list_id==0)
{
 $database->setQuery("insert into #__mail_list (name,status) values ('".$list_name."',0)");
 $database->query();
 $list_id = mysql_insert_id();
}
  $result="";
if  ($weeknum!="") { $wn="'xx'";
if ((strpos ($weeknum,'-'))>0){
 $numbers = split('[/,.-]', $weeknum);
 $nmin=$numbers[0];
 while ($nmin < $numbers[1]){
   $wn.=",'".$nmin."'";
   $nmin++;
 }
}
else {
if (strpos($weeknum,",")>0){

$numbers =split('[/.-]', $weeknum);
if (sizeof($numbers)>1){
foreach ($numbers as $number) {
$wn.=",'".$number."'";
         }
    }
} else $weeknum="'".$weeknum."'";
}
}
//$result.=($country);
$country_name="";
$cc= -1;
if (is_array($country)&&(sizeof($country)>0)) {
//foreach ($country as $t){$result.= 'You selected '.$t.'<br />';
//
//}
$country=implode(',',$country);
}

$add=" where 1=1 ";
if ($search!="")  $add .=" and ( upper(a.name) like '%".mb_strtoupper($search)."%' or  upper(a.contact_person) like '%".mb_strtoupper($search)."%' ) ";
if ($town!="")  $add .=" and ( upper(a.town) like '%".mb_strtoupper($town)."%' ) ";
if ($weeknum!="") $add .=" and a.weeknum in (".$weeknum.") ";
if ((sizeof($country) >0)&&($country!=0)) { $add .=" and a.country in (".$country.") ";  }
$add.=" and a.status >=0 ";
switch($type)
{
case 'promoter':{
                $query="SELECT * from #__promoters a ".$add." order by a.id desc ";
                $result.=$query;
                $database->setQuery( $query );
                $promoters = $database->loadObjectList();
                foreach ($promoters as $promoter)
                    {
                $query="INSERT INTO `#__mail_list_content` (`m_name`, `m_company`, `m_email`, `list_id` ) VALUES ( '".$promoter->contact_person."','".$promoter->name."','".$promoter->email."', ".$list_id." )";
                $result.=$query;
                $database->setQuery( $query );
                $database->query();
                    }
                break;
                }

}
//$objResponse = new xajaxResponse('UTF-8');
//$objResponse->addAssign( 'report_div', 'innerHTML', $result );
//return $objResponse->getXML();
return mass_mail(2,$list_id);
}

function promoter_delete($promoter_id,$mode=0){
global $database;
$query="update `#__promoters` set status=-1 where `id`=".$promoter_id ;
if ($mode==1) $query="delete from `#__promoters` where `id`=".$promoter_id ;
$database->setQuery( $query);
$database->query();
$objResponse = new xajaxResponse('UTF-8');
$objResponse->addAssign( 'report_div', 'innerHTML', promoters_list(0) );
return $objResponse->getXML();
}

function promoter_restore($promoter_id){
global $database;
$query="update `#__promoters` set status=0 where `id`=".$promoter_id ;
//echo $query;
$database->setQuery( $query);
$database->query();
$objResponse = new xajaxResponse('UTF-8');
$objResponse->addAssign( 'report_div', 'innerHTML', promoters_list(0) );
return $objResponse->getXML();
}

function getPromoterMessages($promoterId){
    global $database;
    
    $query="select * from #__messages a where to_id=".$promoterId;
    $database->setQuery($query);
    $messages = $database->loadObjectList();
    
    $result="<span style='font-size:14pt; font-weight:bold'>Messages</span><br/>";
    foreach($messages as $message){
       // $result.="<span style='color:red'>".$message->mesage_date.":</span>".$message->mesage_body;
        $result.="<p><span style='color:red'>".$message->mesage_date.":</span> <a style='cursor:pointer' class='style34' ref='#' onclick='javascript:message_form(".$message->message_id.");'>".$message->subject."</a></p>";
    }
   
    return $result;
}

function getPromoterSMSs($promoterId){
    global $database;
    
    $query="select * from #__sms a where to_id=".$promoterId;
    $database->setQuery($query);
    $messages = $database->loadObjectList();
    
    $result="<span style='font-size:14pt; font-weight:bold'>SMS Messages</span><br/>";
    foreach($messages as $message){
       // $result.="<span style='color:red'>".$message->mesage_date.":</span>".$message->mesage_body;
        $result.="<p><span style='color:red'>".$message->mesage_date.":</span> <a style='cursor:pointer' class='style34' ref='#' onclick='javascript:message_form(".$message->id.");'>".$message->mesage_body."</a></p>";
    }
   
    return $result;
}

function getpromoterInfo($promoter_id) {
setcookie('prev',stripslashes($_COOKIE['now']) );
setcookie('now',"href='#' onclick='javascript:getpromoterInfo(".$promoter_id.");' ");
global $database,$mosConfig_absolute_path;$database->setQuery( "set names utf8" );$database->query();
$result="";
$query=" select * from #__promoters a where id=".$promoter_id;
$database->setQuery( $query );
$promoters = $database->loadObjectList();
foreach ($promoters as $promoter){
$query='select name from #__countries where id='.$promoter->country;
$database->setQuery( $query );
$country = $database->loadResult();

if ($promoter->website !="")
{
  $promoter->website=str_replace ("http://","",$promoter->website);
$promoter->website ="<a href='http://".$promoter->website ."' target='_blank'>".$promoter->website ."</a>";
 }
 switch ($promoter->priority){
  case 1: $img='square-red.png';$to_priority++; break;
  case 2: $img='square-yellow.png';$to_priority++; break;
  case 3: $img='square-green.png';$to_priority=0; break;
  default: $img='square-white.png';$to_priority=1; break;
}
           $ft = new FastTemplate($mosConfig_absolute_path."/templates");
            $ft->define(array('body'  => "promoter_view.tpl"));
            $ft->assign( array(
                    'ID' => $promoter->id,
                    'COMPANY' => $promoter->name,
                    'CITYCODE' => $promoter->city_code  ,
                    'CONTACTPERSON' => $promoter->contact_person  ,
                    'TOWN' => $promoter->town,
                    'LOCATION' => $promoter->location,
                    'CAPACITY' => $promoter->capacity,
                    'ADDR1' => $promoter->street_addr1  ,
                    'COUNTRY' => $country,
                    'ADDR2' => $promoter->street_addr2  ,
                    'PHONE1' => $promoter->phone1  ,
                    'EMAIL' => $promoter->email  ,
                    'PHONE2' => $promoter->phone2  ,
                    'WWW' => $promoter->website,
                    'WEEKNUM' => $promoter->weeknum,
                    'COORDS' => $promoter->coords,
                    'COORDS_CRC' => $promoter->coords_crc,
                    'PRIORITY' => "<div id='stat_".$promoter->id."' style='float:right;margin:2px 6px;cursor:pointer'><a name='#' onclick='javascript:update_priority_promoter(".$promoter->id.",".$to_priority.");' title='Click to change priority to ".$to_priority."'><img src='images/".$img."' ></a></div>",
                    'COMMENTS' => stripslashes($promoter->comments),
                    'EMAILS' => getPromoterMessages($promoter->id),
                    'SMSS' => getPromoterSMSs($promoter->id),
                    'BACK'=> stripslashes ($_COOKIE['now'])
                    ));
            $ft->parse('BODY', "body");
            $result.=$ft->FastPrint("BODY",true);
}
$promoter->coords = str_replace(")","",str_replace("(","",$promoter->coords));
$objResponse = new xajaxResponse('UTF-8');
$objResponse->addAssign( 'report_div', 'innerHTML',$result);
if($promoter->coords !=""){
        $objResponse->addScript( "initializemap(); viewAddress(".$promoter->coords.");");
        }
   else {
        $objResponse->addScript( 'initializemap(); codeAddress();window.setTimeout("document.getElementById(\"savebutton\").click();",1500);');
        }
return $objResponse->getXML();
}

function promoter_save_geo($id_promoter, $geo)
{
global $database;
$query="update #__promoters set coords ='".$geo."' where id=".intval($id_promoter)." limit 1";
$database->setQuery( $query);
$database->query();
$objResponse = new xajaxResponse('UTF-8');
$objResponse->addScript( 'set_save_button_active();');
return $objResponse->getXML();

}

function editpromoterInfo($promoter_id) {
global $database;
$database->setQuery( "set names utf8" );
$database->query();

if ($promoter_id>0)
	{

		$promoters = array();
        $qr="SELECT * from #__promoters where id=".$promoter_id ;
		$database->setQuery( $qr);
		$promoters = $database->loadObjectList();
//		print_r($inputs);
		foreach ($promoters as $promoter ){}
}

$today  = date("d/m/Y", mktime (0,0,0,date("m")  ,date("d"),date("Y")));
$result="
<TABLE align='center' valign='middle' width='100%' height='100%' cellpadding=0 cellspacing=0 border=0>
<TR>
	<TD>
<TABLE style='border:15px white solid;background-color: #eeeeee;' align='center' valign='middle' cellpadding=0 cellspacing=0>
<TR>
	<TD>
<TABLE class='h3' style='border:1px gray solid;background-color: #eeeeee;'><TR><td colspan=2 align='right'><button onclick='javascript:hideInfo();'><IMG SRC='/images/del.gif' WIDTH='16' HEIGHT='16' BORDER='0' ALT=''></button></td></TR>
<TR><TH colspan=2 class='h2'>";
if ($promoter_id>0)$result.="Promoter&nbsp;N&deg;<b>".$promoter_id."</b>&nbsp;information";
else $result.="New Promoter information";
$result.="</TH>
</TR><TR>	<TD valign='top'  class='h1'>";
$result.="<FORM METHOD=POST name='promoter_data' id='promoter_data' onsubmit='return check_this_form(this);' ACTION=\"javascript:promoter_save(xajax.getFormValues('promoter_data'));\">
<INPUT TYPE='hidden' NAME='promoter_id' value='";
if (isset ($promoter->id)) $result.=$promoter->id; else $result.="0";
$result.="'><TABLE class='h3'><TR><TD valign='top'  class='h1'><TABLE width='99%'>
<TR><TD>Promoter</TD><TD><INPUT TYPE='text' NAME='name' id='name' required='1' value='";
if (isset($promoter->name)) $result.=$promoter->name."'>"; else $result.="'
\">&nbsp;<a href='#' onclick=\"javascript:check_name(document.getElementById('name').value,'promoters',".$promoter_id.",'editpromoterInfo',1);\">check&nbsp;name</a><br><div id='check_results' name='check_results'>
&nbsp;</div>";
$result.="</TD></TR><TR><TD>Contact person</TD><TD><INPUT TYPE='text' NAME='contact_person' required='1'  value='";
if (isset($promoter->contact_person)) $result.=$promoter->contact_person; else $result.="";
$result.="'></TD></TR><TR><TD>Weekend number</TD><TD><INPUT TYPE='text' NAME='weeknum'  required='1' week='1' value='";
if (isset($promoter->weeknum)) $result.=$promoter->weeknum; else $result.="00";
$result.="'></TD></TR><TR><TD>Address 1</TD><TD><INPUT TYPE='text' NAME='street_addr1' value='";
if (isset($promoter->street_addr1)) $result.=$promoter->street_addr1; else $result.="";
$result.="'></TD></TR><TR><TD>Address 2</TD><TD><INPUT TYPE='text' NAME='street_addr2' value='";
if (isset($promoter->street_addr2)) $result.=$promoter->street_addr2; else $result.="";
$result.="'></TD></TR><TR><TD>City code (ZIP)</TD><TD><INPUT TYPE='text' NAME='city_code' value='";
if (isset($promoter->city_code)) $result.=$promoter->city_code; else $result.="";
$result.="'></TD></TR><TR><TD>Town</TD><TD><INPUT TYPE='text' NAME='town' value='";
if (isset($promoter->town)) $result.=$promoter->town; else $result.="";
$result.="'></TD></TR><TR><TD>Location</TD><TD><INPUT TYPE='text' NAME='location' value='";
if (isset($promoter->location)) $result.=$promoter->location; else $result.="";
$result.="'></TD></TR><TR><TD>Country</TD><TD>";
$clist = array();
$clist[] = mosHTML::makeOption( '0', '........', 'value', 'text'  );
$database->setQuery( "SELECT id as value, name as text FROM #__countries  ORDER BY name" );// where  world LIKE  'europe'
$clist = array_merge($clist,$database->loadObjectList());
if (isset($promoter->country)) $result.=mosHTML::selectList( $clist, 'country', " id='country' ", 'value', 'text', $promoter->country );
  else  $result.=mosHTML::selectList( $clist, 'country', " id='country' ", 'value', 'text', 0);
$result.="</TD></TR><TR><TD>Local phone</TD><TD><INPUT TYPE='text' NAME='phone1' value='";
if (isset($promoter->phone1)) $result.=$promoter->phone1; else $result.="";
$result.="'></TD></TR><TR><TD>Cell phone</TD><TD><INPUT TYPE='text' NAME='phone2' value='";
if (isset($promoter->phone2)) $result.=$promoter->phone2; else $result.="";
$result.="'></TD></TR><TR><TD>E-mail</TD><TD><INPUT TYPE='text' NAME='email' required='1' value='";
if (isset($promoter->email)) $result.=$promoter->email; else $result.="";
$result.="'></TD></TR><TR><TD>Website</TD><TD><INPUT TYPE='text' NAME='website' value='";
if (isset($promoter->website)) $result.=$promoter->website; else $result.="";
$result.="'></TD></TR><TR><TD>Capacity</TD><TD><INPUT TYPE='text' NAME='capacity' value='";
if (isset($promoter->capacity)) $result.=$promoter->capacity; else $result.="";
$result.="'></TD></TR><TR><TD>Priority</TD><TD>";
$zlist = array();
$zlist[] = mosHTML::makeOption( '0', 'no priority', 'value', 'text'  );
$zlist[] = mosHTML::makeOption( '1', '1-st level', 'value', 'text'  );
$zlist[] = mosHTML::makeOption( '2', '2-nd level', 'value', 'text'  );
$zlist[] = mosHTML::makeOption( '3', '3-rd level', 'value', 'text'  );
$result.=mosHTML::selectList( $zlist, 'priority', " id='priority' ", 'value', 'text', $promoter->priority );
$result.="</TD></TR><TR><TD>Our comments</TD><TD><textarea NAME='comments' cols=30 rows=3>";
if (isset($promoter->comments)) $result.=$promoter->comments; else $result.="";
$result.="</textarea></TD></TR>";
$result.="</TABLE></TD></TR><tr><td align='center' colspan=2>";
$result.="<input type='submit' value='Save' class='button'></td></tr></TABLE></FORM>";
$result.="</TD></TR></TABLE></TD>
</TR>
</TABLE></TD>
</TR>
</TABLE>";
$objResponse = new xajaxResponse('UTF-8');
$objResponse->addAssign( 'info_div', 'innerHTML', $result );
return $objResponse->getXML();
}



//==============================================================================================


function sound_save($sound_data) {

$objResponse = new xajaxResponse('UTF-8');
global $database;
		$database->setQuery( "set names utf8" );
		$database->query();
foreach ($sound_data as $key => $fdata) {
	$sound_data[$key] = addslashes(strip_tags($fdata));
}

if ((isset($sound_data['main_id']))&&($sound_data['main_id']>0))
{
$update="
update #__sound_companies set
`name` = '".$sound_data['name']."',
`contact_person` = '".$sound_data['contact_person']."',
`street_addr1` = '".$sound_data['street_addr1']."',
`street_addr2` = '".$sound_data['street_addr2']."',
`city_code` = '".$sound_data['city_code']."',
`town` = '".$sound_data['town']."',
`id_country` = ".$sound_data['id_country'].",
`phone1` = '".$sound_data['phone1']."',
`phone2` = '".$sound_data['phone2']."',
 `email` = '".$sound_data['email']."',
 `website` = '".$sound_data['website']."',
 `whosupdate` = ".$_COOKIE['operator_id'].",
 `lastupdate` = CURRENT_TIMESTAMP
where id=".$sound_data['main_id'];

}
else {
$update ="
insert into #__sound_companies (
`name`, `contact_person`, `street_addr1`, `street_addr2`, `city_code`, `town`, `id_country`, `phone1`, `phone2`, `email`, `website`, `status`, `lastupdate`, `whosupdate`) values
('".$sound_data['name']."', '".$sound_data['contact_person']."', '".$sound_data['street_addr1']."', '".$sound_data['street_addr2']."', '".$sound_data['city_code']."', '".$sound_data['town']."', ".$sound_data['id_country'].", '".$sound_data['phone1']."', '".$sound_data['phone2']."', '".$sound_data['email']."', '".$sound_data['website']."', 0, CURRENT_TIMESTAMP,".$_COOKIE['operator_id'].")";

}
$database->setQuery( $update );
$database->query();
$objResponse = new xajaxResponse('UTF-8');
$objResponse->addAssign( 'report_div', 'innerHTML', sounds_list(0) );
return $objResponse->getXML();
}


function sound_list( $id ) {
$objResponse = new xajaxResponse('UTF-8');
$objResponse->addAssign( 'report_div', 'innerHTML', sounds_list($id) );
return $objResponse->getXML();

}


function sounds_list( $id, $search="" ) {
$result= "";
if (isset($id)) $ss=$id; else $ss=0;

switch  ($ss)
{
	case 0: $add=" where a.status >=0 "; break;
	case 1: $add=" where a.status= -1 "; break;
}
if ($search!="") $add=" where  a.name like '%".$search."%'";
 $result.= "
  <table width='95%' border='0' align='center' cellpadding='0' cellspacing='0'>
      <tr>
        <td width='53%' class='style4'>Sound Companies</td>
        <td width='47%' class='style4'>".displays_search_form(4)."</td>
      </tr>
    </table><br />
";

$query="SELECT * from sound_companies a ".$add."
ORDER BY 1
";
$head="";
global $database;
$database->setQuery( "set names utf8" );
$database->query();
$sounds = array();
$database->setQuery( $query );
$sounds = $database->loadObjectList();


if (sizeof($sounds)>0)  $result.= $head; else {

if($search)
$result.= "<table width='95%' border='0' align='center' cellpadding='0' cellspacing='1' bgcolor='#999999'>
              <tr>
                <td bgcolor='#999999' class='style4'><table width='100%' border='0' align='center' cellpadding='0' cellspacing='1'><td height='36' colspan='3' bgcolor='#FFFFFF'>
                <span class='style5'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;You search for&nbsp;<b>".$search."</b>,&nbsp;but nobody found...</span></td></TR>
                  <tr>
                    <td height='35' bgcolor='#FFFFFF'>&nbsp;&nbsp;
                    <a href='#' onclick='javascript:editsoundInfo(0);'><img src='images/comment-add-24x24.png'   align='absmiddle' border=0></a>&nbsp;&nbsp;<a href='#' onclick='javascript:editsoundInfo(0);'  class='style11'>Add New Sound Company</a></td>
                    <td height='35' colspan='2' bgcolor='#FFFFFF'>&nbsp;</td>
                  </tr>
                </table></td>
                  </tr>
                </table>


";
else {

 $result.= "<table width='95%' border='0' align='center' cellpadding='0' cellspacing='1' bgcolor='#999999'>
              <tr>
                <td bgcolor='#999999' class='style4'><table width='100%' border='0' align='center' cellpadding='0' cellspacing='1'>
                  <tr>
                    <td height='36' colspan='3' bgcolor='#FFFFFF'>&nbsp;&nbsp;<span class='style5'>Sound Companies</span>&nbsp;&nbsp;&nbsp;";

if($search) $result.="<span class='style5'>You search for:&nbsp;<b>".$search."</b></span>";
else {
                    if ($ss!=0) $result.= "<A HREF='#' onclick='javascript:sound_list(0);' class='style11'>Active</A>";else  $result.= "[<B>Active</B>]";
 $result.= "&nbsp;|&nbsp;";
if ($ss!=1) $result.= "<A HREF='#' class='style11' onclick='javascript:sound_list(1);' >Deleted</A>";else  $result.= "[<B>Deleted</B>]";
}
$result.="</td></tr>";
$result.="

                  <tr>
                    <td height='35' bgcolor='#FFFFFF'  colspan='3'>&nbsp;&nbsp;
                    <a href='#' onclick='javascript:editsoundInfo(0);'><img src='images/comment-add-24x24.png'   align='absmiddle' border=0></a>&nbsp;&nbsp;<a href='#' onclick='javascript:editsoundInfo(0);'  class='style11'>Add New Sound Company</a></td>
                  </tr>
                </table></td>
              </tr>
            </table>

     ";
}

return $result;
}
$result.= "<table width='95%' border='0' align='center' cellpadding='0' cellspacing='1' bgcolor='#999999'>
              <tr>
                <td bgcolor='#999999' class='style4'><table width='100%' border='0' align='center' cellpadding='0' cellspacing='1'>
                  <tr>
                    <td height='36' colspan='3' bgcolor='#FFFFFF'>&nbsp;&nbsp;<span class='style5'>Sound Companies</span>&nbsp;&nbsp;&nbsp;";

if($search) $result.="<span class='style5'>You search for:&nbsp;<b>".$search."</b></span>";
else {
                    if ($ss!=0) $result.= "<A HREF='#' onclick='javascript:sound_list(0);' class='style11'>Active</A>";else  $result.= "[<B>Active</B>]";
 $result.= "&nbsp;|&nbsp;";
if ($ss!=1) $result.= "<A HREF='#' class='style11' onclick='javascript:sound_list(1);' >Deleted</A>";else  $result.= "[<B>Deleted</B>]";
}
$result.="</td></tr>";


foreach ($sounds as $sound)
	{
$result.="
                  <tr>
                    <td width='78%' height='35' bgcolor='white'>&nbsp;&nbsp;<a href='#' onclick='javascript:editsoundInfo(".$sound->id.");' title='Get info on this sound'><img src='images/blog-post-edit-24x24.png'  align='absmiddle' border='0'></a>&nbsp;
";

if($ss==0) $result.="<a href='#' onclick='javascript:sound_delete(".$sound->id.");' title='Delete this sound'><img src='images/trash-empty-24x24.png'  align='absmiddle' border='0'></a>";
else $result.="<a href='#' onclick='javascript:sound_restore(".$sound->id.");' title='Restore this sound'><img src='images/accept-24x24.png' align='absmiddle' border='0'></a>";
$result.="&nbsp;&nbsp;&nbsp;<span class='style6'>".$sound->name ."</span></td>
                    <td width='12%' bgcolor='white'><div align='center'>".$sound->contact_person."</div></td>
                    <td width='10%' bgcolor='white'><div align='center'>".$sound->id ."</div></td>
                  </tr>
";
}
$result.="

                  <tr>
                    <td height='35' bgcolor='#FFFFFF'>&nbsp;&nbsp;
                    <a href='#' onclick='javascript:editsoundInfo(0);'><img src='images/comment-add-24x24.png'   align='absmiddle' border=0></a>&nbsp;&nbsp;<a href='#' onclick='javascript:editsoundInfo(0);'  class='style11'>Add New Sound Company</a></td>
                    <td height='35' colspan='2' bgcolor='#FFFFFF'><div align='center'><span class='style11'><img border=0 src='images/back-24x24.png' align='absmiddle'>&nbsp;prev&nbsp;page&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;next&nbsp;page&nbsp;<img border=0 src='images/next-24x24.png' align='absmiddle'></span></div></td>
                  </tr>
                </table></td>
              </tr>
            </table>

     ";

return  $result;;
}


function sound_delete($id){
global $database;
$query="update `#__sound_companies` set status=-1 where `id`=".$id ;
//echo $query;
$database->setQuery( $query);
$database->query();
$objResponse = new xajaxResponse('UTF-8');
$objResponse->addAssign( 'report_div', 'innerHTML', sounds_list(0) );
return $objResponse->getXML();
}
function sound_restore($id){
global $database;
$query="update `#__sound_companies` set status=0 where `id`=".$id ;
//echo $query;
$database->setQuery( $query);
$database->query();
$objResponse = new xajaxResponse('UTF-8');
$objResponse->addAssign( 'report_div', 'innerHTML', sounds_list(0) );
return $objResponse->getXML();
}

function getsoundInfo($id) {
global $database;$database->setQuery( "set names utf8" );$database->query();
$query=" select * from #__sound_companies a where id=".$id;
$database->setQuery( $query );
		$sound_companies = $database->loadObjectList();
		foreach ($sound_companies as $sound_companie){
$result="
<TABLE align='center' valign='middle' width='100%' height='100%' cellpadding=0 cellspacing=0 border=0>
<TR><TD><TABLE style='border:15px white solid;background-color: #eeeeee;' align='center' valign='middle' cellpadding=0 cellspacing=0>
<TR><TD><TABLE class='h3' style='border:1px gray solid;background-color: #eeeeee;'><TR><td colspan=2 align='right'><button onclick='javascript:hideInfo();'><IMG SRC='/images/del.gif' WIDTH='16' HEIGHT='16' BORDER='0' ALT=''></button></td></TR>
<TR><TH colspan=2 class='h2'>Sound company&nbsp;info&nbsp;№&nbsp;".$id."</TH>
</TR><TR>	<TD valign='top'  class='h1'>";
$result.="<TABLE width='99%'><TR><TH colspan=2 align=center>sound_companie information</TH>
</TR><TR><TD nowrap>Sound company(name)</TD><TD>";
if (isset($sound_companie->name)) $result.=$sound_companie->name; else $result.="";
$result.="</TD></TR><TR><TD>Contact person</TD><TD>";
if (isset($sound_companie->contact_person)) $result.=$sound_companie->contact_person; else $result.="";
$result.="</TD></TR><TR><TD>Street address 1</TD><TD>";
if (isset($sound_companie->street_addr1)) $result.=$sound_companie->street_addr1; else $result.="";
$result.="</TD></TR><TR><TD>Street address 2</TD><TD>";
if (isset($sound_companie->street_addr2)) $result.=$sound_companie->street_addr2; else $result.="";
$result.="</TD></TR><TR><TD>City code (ZIP)</TD><TD>";
if (isset($sound_companie->city_code)) $result.=$sound_companie->city_code; else $result.="";
$result.="</TD></TR><TR><TD>Town</TD><TD>";
if (isset($sound_companie->town)) $result.=$sound_companie->town; else $result.="";
$result.="</TD></TR><TR><TD>Country</TD><TD>";
$query='select name from #__countries where id='.$sound_companie->id_country;
$database->setQuery( $query );
$result.= $database->loadResult();
$result.="</TD></TR><TR><TD>Phone</TD><TD>";
if (isset($sound_companie->phone1)) $result.=$sound_companie->phone1; else $result.="";
$result.="</TD></TR><TR><TD>Phone 2</TD><TD>";
if (isset($sound_companie->phone2)) $result.=$sound_companie->phone2; else $result.="";
$result.="</TD></TR><TR><TD>e-mail</TD><TD>";
if (isset($sound_companie->email)) $result.="<a href='mailto:".$sound_companie->email."'>".$sound_companie->email."</a>"; else $result.="";
$result.="</TD></TR><TR><TD>Website</TD><TD>";
if (isset($sound_companie->website)) $result.="<a href='http://".$sound_companie->website."' target='_blank'>".$sound_companie->website."</a>"; else $result.="";
$result.="</TD></TR>";
$result.="</TD></TR></TABLE></TD></TR>";
$result.="</TD></TR></TABLE></TD></TR></TABLE></TD></TR></TABLE>";
}

$objResponse = new xajaxResponse('UTF-8');
$objResponse->addAssign( 'info_div', 'innerHTML', $result );
return $objResponse->getXML();
}

function editsoundInfo($id,$return_type=0) {
global $database;
$database->setQuery( "set names utf8" );
$database->query();

if ($id>0)
	{

		$sound_companies = array();
        $qr="SELECT * FROM #__sound_companies where id=".$id ;
		$database->setQuery( $qr);
		$sound_companies = $database->loadObjectList();
//		print_r($inputs);
		foreach ($sound_companies as $sound_companie ){}
}


$result="";
$today  = date("d/m/Y", mktime (0,0,0,date("m")  ,date("d"),date("Y")));
$result="
<TABLE align='center' valign='middle' width='100%' height='100%' cellpadding=0 cellspacing=0 border=0>
<TR>
	<TD>
<TABLE style='border:15px white solid;background-color: #eeeeee;' align='center' valign='middle' cellpadding=0 cellspacing=0>
<TR>
	<TD>
<TABLE class='h3' style='border:1px gray solid;background-color: #eeeeee;'><TR><td colspan=2 align='right'><button onclick='javascript:hideInfo();'><IMG SRC='/images/del.gif' WIDTH='16' HEIGHT='16' BORDER='0' ALT=''></button></td></TR>
<TR><TH colspan=2 class='h2'>Sound company&nbsp;info&nbsp;№&nbsp;".$id."</TH>
</TR><TR>	<TD valign='top'  class='h1'>";
$result.="<FORM METHOD=POST name='sound_form' id='sound_form' ACTION=\"javascript:sound_save(xajax.getFormValues('sound_form'));\"><INPUT TYPE='hidden' NAME='main_id' value='";
if (isset ($sound_companie->id)) $result.=$sound_companie->id; else $result.="0";
$result.="'><TABLE class='h3'><TR><TD valign='top'  class='h1'><TABLE width='99%'><TR><TH colspan=2 align=center>Sound company</TH>
</TR><TR><TD>Sound company company (name)</TD><TD><INPUT TYPE='text' NAME='name' value='";
if (isset($sound_companie->name)) $result.=$sound_companie->name; else $result.="";
$result.="'></TD></TR><TR><TD>Contact person</TD><TD><INPUT TYPE='text' NAME='contact_person' value='";
if (isset($sound_companie->contact_person)) $result.=$sound_companie->contact_person; else $result.="";
$result.="'></TD></TR><TR><TD>Street address 1</TD><TD><INPUT TYPE='text' NAME='street_addr1' value='";
if (isset($sound_companie->street_addr1)) $result.=$sound_companie->street_addr1; else $result.="";
$result.="'></TD></TR><TR><TD>Street address 2</TD><TD><INPUT TYPE='text' NAME='street_addr2' value='";
if (isset($sound_companie->street_addr2)) $result.=$sound_companie->street_addr2; else $result.="";
$result.="'></TD></TR><TR><TD>City code (ZIP)</TD><TD><INPUT TYPE='text' NAME='city_code' value='";
if (isset($sound_companie->city_code)) $result.=$sound_companie->city_code; else $result.="";
$result.="'></TD></TR><TR><TD>Town</TD><TD><INPUT TYPE='text' NAME='town' value='";
if (isset($sound_companie->town)) $result.=$sound_companie->town; else $result.="";
$result.="'></TD></TR><TR><TD>Country</TD><TD>";
global $database;
$countries = array();
$database->setQuery( "SELECT id, name FROM countries  ORDER BY id" );
$countries = $database->loadObjectList();
if (isset($sound_companie->id_country)) $cnt=$sound_companie->id_country; else $cnt=1;
$cnt_list = mosHTML::selectList( $countries, 'id_country', ' id="id_country" ', 'id', 'name', $cnt );
$result.=$cnt_list;
$result.="</TD></TR><TR><TD>Phone</TD><TD><INPUT TYPE='text' NAME='phone1' value='";
if (isset($sound_companie->phone1)) $result.=$sound_companie->phone1; else $result.="";
$result.="'></TD></TR><TR><TD>Phone 2</TD><TD><INPUT TYPE='text' NAME='phone2' value='";
if (isset($sound_companie->phone2)) $result.=$sound_companie->phone2; else $result.="";
$result.="'></TD></TR><TR><TD>e-mail</TD><TD><INPUT TYPE='text' NAME='email' value='";
if (isset($sound_companie->email)) $result.=$sound_companie->email; else $result.="";
$result.="'></TD></TR><TR><TD>Website</TD><TD><INPUT TYPE='text' NAME='website' value='";
if (isset($sound_companie->website)) $result.=$sound_companie->website; else $result.="";
$result.="'></TD></TR>";
$result.="</TD></TR></TABLE></TD></TR><tr><td align='center' colspan=2>";
$result.="<input type='submit' value='Save' class='button'></td></tr></TABLE></FORM>";
$result.="</TD></TR></TABLE></TD></TR></TABLE></TD></TR></TABLE>";
$objResponse = new xajaxResponse('UTF-8');
$objResponse->addAssign( 'info_div', 'innerHTML', $result );
return $objResponse->getXML();
}
//==================================================================================================================

function mass_mail_draw_menu($id)
{
 global $database,$mosConfig_absolute_path;
 $i=0; $data='';
$ft = new FastTemplate($mosConfig_absolute_path."/templates");
$ft->define(array('body'  => "mass_mail_menu.tpl"));
$links = array (
               "<a class='style11' href='#' onclick='javascript:mass_mail(0)'>Message templates</a>",
               "<a class='style11' href='#' onclick='javascript:mass_mail(1)'>Mailing lists</a>",
               "<a class='style11' href='#' onclick='javascript:mass_mail(3)'>Queue</a>"
               );
// "<a class='style11' href='#' onclick='javascript:mass_mail(3)'>Reports</a>"
foreach ($links as $link)
{
//if($id!=$i)$data.="&nbsp;".$link."&nbsp;";
//else
$data.="&nbsp;".$link."&nbsp;";
$i++;
}
    $ft->assign( array(
                    'LINKS' =>"<td class='style17' height='40' bgcolor='white'>".$data."</td>"
                    ));
    $ft->parse('BODY', "body");
    $html=$ft->FastPrint("BODY",true);
return $html;
}

function mass_mail_view_msg($id)
{
setcookie('prev',stripslashes($_COOKIE['now']) );
setcookie('now',"href='#' onclick=\"javascript:mass_mail_view_msg(".$id."');\" ");
//if ($who=='all_promoters'){$to_type=2;$to_id= -1;}
//if ($who=='checked_promoters'){$to_type=2;$to_id= -2;}
global $database,$mosConfig_absolute_path;
$database->setQuery( "set names utf8" );
$database->query();
$query=" select * from #__message_templates a where message_id=".$id;
$database->setQuery( $query );
$messages = $database->loadObjectList();
$ft = new FastTemplate($mosConfig_absolute_path."/templates");
//$es=email_selectors($to_type,$to_id,$data);
if (sizeof($messages)>0) {
foreach ($messages as $message){
 $ft->define(array('body'  => "mass_mail_msg_view.tpl"));
// $ft->define(array('body'  => "mass_mail_msg_edit.tpl"));

    $ft->assign( array(
                'ID' => $id,
                    'FROM_EMAIL' => $message->from_email,
                    'FROM_NAME' => $message->from_name,
                    'SUBJECT' => $message->subject,
                    'MESSAGE' => $message->message_body_html,
                    'MESSAGE_TEXT' => $message->message_body_text,
                    'BACK' => stripslashes ($_COOKIE['now'])
                    ));

}
}


    $ft->parse('BODY', "body");
    $result=$ft->FastPrint("BODY",true);
$objResponse = new xajaxResponse('UTF-8');
$objResponse->addAssign( 'report_div', 'innerHTML', $result);
//$objResponse->addScript( 'replaceDiv("message")');
return $objResponse->getXML();
}


function mm_edlist($id){
global $database,$mosConfig_absolute_path;
setcookie('prev',stripslashes($_COOKIE['now']) );
setcookie('now',"href='#' onclick=\"javascript:mm_edlist(".$id.");\" ");
$ft = new FastTemplate($mosConfig_absolute_path."/templates");
$ft->define(array('body'  => "mass_mail_list_edit.tpl"));
//$es=email_selectors($to_type,$to_id,$data);
if ($id!=0){
$database->setQuery( "set names utf8" );
$database->query();
$query="select * from #__mail_list where id=".$id;
$database->setQuery( $query );
$messages = $database->loadObjectList();
if (sizeof($messages)>0) {
foreach ($messages as $message){
$subm="<div id='sendbutton'><INPUT TYPE='submit' value='Save list'></div>";
$ft->assign( array(
                    'ID' => $id,
                    'LIST_NAME' => $message->name,
                    'SUBMIT'=> $subm,
                    'BACK' => stripslashes ($_COOKIE['now'])
                    ));
}
}}

else {
$subm="<div id='sendbutton'><INPUT TYPE='submit' value='Save list'></div>";
$ft->assign( array(
                    'ID' => 0,
                    'LIST_NAME' =>'',
                    'SUBMIT'=> $subm,
                    'BACK' => stripslashes ($_COOKIE['now'])
                    ));
}
$ft->parse('BODY', "body");
$result=$ft->FastPrint("BODY",true);
$objResponse = new xajaxResponse('UTF-8');
$objResponse->addAssign( 'info_div', 'innerHTML', $result);
//$objResponse->addScript( 'replaceDiv("message")');
return $objResponse->getXML();
}
function mm_edlistcont($list_id,$id){
global $database,$mosConfig_absolute_path;
setcookie('prev',stripslashes($_COOKIE['now']) );
setcookie('now',"href='#' onclick=\"javascript:mm_edlistcont(".$id.");\" ");
$ft = new FastTemplate($mosConfig_absolute_path."/templates");
$ft->define(array('body'  => "mass_mail_list_cont_edit.tpl"));
$subm="<div id='sendbutton'><INPUT TYPE='submit' value='Save'></div>";
if ($id!=0){
$database->setQuery( "set names utf8" );
$database->query();
$query="select * from #__mail_list_content where id=".$id;
$database->setQuery( $query );
$messages = $database->loadObjectList();
if (sizeof($messages)>0) {
foreach ($messages as $message){

$ft->assign( array(
                    'ID' => $id,
                    'LIST_ID' => $list_id,
                    'COMPANY' => $message->m_company,
                    'CONTACT' => $message->m_name,
                    'EMAIL' => $message->m_email,
                    'SUBMIT'=> $subm,
                    'BACK' => stripslashes ($_COOKIE['now'])
                    ));
}
}}

else {

$ft->assign( array(
                     'ID' => 0,
                    'LIST_ID' => $list_id,
                    'COMPANY' => '',
                    'CONTACT' => '',
                    'EMAIL' => '',
                    'SUBMIT'=> $subm,
                    'BACK' => stripslashes ($_COOKIE['now'])
                    ));
}
$ft->parse('BODY', "body");
$result=$ft->FastPrint("BODY",true);
$objResponse = new xajaxResponse('UTF-8');
$objResponse->addAssign( 'info_div', 'innerHTML', $result);
//$objResponse->addScript( 'replaceDiv("message")');
return $objResponse->getXML();
}
function queque_save($formdata) {
global $database, $mosConfig_absolute_path,$mosConfig_live_site ;
$database->setQuery( "set names utf8" );
$database->query();
foreach ($formdata as $key => $fdata) {
$formdata[$key] =  $fdata;
$result.="'".$key."'=>'".$formdata[$key]."'<br/>";
}
$query="INSERT INTO #__msg_queque_header (  `templ_id` , `list_id` , `qty`, `sent` )
VALUES ( ".$formdata['tmpl_id'].", ".$formdata['list_id'].", 0, 0 )";
$database->setQuery( $query );
$database->query();
$header_id= $database->insertid();

$query="select * from #__message_templates  where message_id=".$formdata['tmpl_id'];
$database->setQuery( $query );
$messages = $database->loadObjectList();
$qq=0;
foreach ($messages as $message){}

$query="select * from #__mail_list_content where list_id=".$formdata['list_id'];
$database->setQuery( $query );
$senders = $database->loadObjectList();
foreach ($senders as $sender){
$query="INSERT INTO  #__msg_queque (`header_id` ,  `from_name` ,  `from_email` ,  `to_name` ,  `to_email` , `to_company` ,  `subject` ,  `msg_body_html` ,  `msg_body_txt`  )
VALUES (
".$header_id.",'".$message->from_name."', '".$message->from_email."' , '".$sender->m_name."' , '".$sender->m_email."' , '".$sender->m_company."' , '".$message->subject."'  , '".$message->message_body_html."' ,'".addslashes($message->message_body_text)."')";
$database->setQuery( $query );
$database->query();
$q.= $query;
$qq++;
}
$query ="update #__msg_queque_header set qty=".$qq." where id=".$header_id;
$database->setQuery( $query );
$database->query();
//$objResponse = new xajaxResponse('UTF-8');
//$objResponse->addAssign( 'report_div', 'innerHTML', $q);
//return $objResponse->getXML();//
return mass_mail(3);

}





function mm_edqueque($id){
global $database,$mosConfig_absolute_path;
$database->setQuery( "set names utf8" );
$database->query();
setcookie('prev',stripslashes($_COOKIE['now']) );
setcookie('now',"href='#' onclick=\"javascript:mm_edqueque(".$id.");\" ");
$ft = new FastTemplate($mosConfig_absolute_path."/templates");
$ft->define(array('body'  => "mass_mail_queque_add.tpl"));
$subm="<div id='sendbutton'><INPUT TYPE='submit' value='Go Go Go!'></div>";
if ($id!=0){

$query="select * from #__queque_header where id=".$id;
$database->setQuery( $query );
$messages = $database->loadObjectList();
if (sizeof($messages)>0) {
foreach ($messages as $message){

$ft->assign( array(
                    'ID' => $id,
                    'LIST_ID' => $list_id,
                    'COMPANY' => $message->m_company,
                    'CONTACT' => $message->m_name,
                    'EMAIL' => $message->m_email,
                    'SUBMIT'=> $subm,
                    'BACK' => stripslashes ($_COOKIE['now'])
                    ));
}
}}

else {
$query="select id as value, name as text from #__mail_list order by name asc";
$database->setQuery( $query );
$clist=$database->loadObjectList();
$query="select message_id as value, subject as text from #__message_templates order by subject asc";
$database->setQuery( $query );
$tlist=$database->loadObjectList();

$ft->assign( array(
                     'ID' => 0,
                    'LIST_ID' =>mosHTML::selectList( $clist, 'list_id', " id='list_id' ", 'value', 'text',0) ,
                    'TMPL_ID' =>mosHTML::selectList( $tlist, 'tmpl_id', " id='tmpl_id' ", 'value', 'text',0) ,
                    'SUBMIT'=> $subm,
                    'BACK' => stripslashes ($_COOKIE['now'])
                    ));
}
$ft->parse('BODY', "body");
$result=$ft->FastPrint("BODY",true);
$objResponse = new xajaxResponse('UTF-8');
$objResponse->addAssign( 'info_div', 'innerHTML', $result);
//$objResponse->addScript( 'replaceDiv("message")');
return $objResponse->getXML();
}

function mass_mail_edit_msg($id)
{
global $_COMPANY_NAME,$_EMAIL;
setcookie('prev',stripslashes($_COOKIE['now']) );
setcookie('now',"href='#' onclick=\"javascript:mass_mail_edit_msg(".$id.");\" ");
//if ($who=='all_promoters'){$to_type=2;$to_id= -1;}
//if ($who=='checked_promoters'){$to_type=2;$to_id= -2;}
global $database,$mosConfig_absolute_path;
$database->setQuery( "set names utf8" );
$database->query();
$query=" select * from #__message_templates a where message_id=".$id;
$database->setQuery( $query );
$messages = $database->loadObjectList();
$ft = new FastTemplate($mosConfig_absolute_path."/templates");
//$es=email_selectors($to_type,$to_id,$data);
if ($message_id==0)$subm="<div id='sendbutton'><INPUT TYPE='submit' value='Save message template'></div><div id='waitsend' style='display:none;'><img src='images/wait_big.gif' border=0 vspace=3 hspace=3></div>";
else $subm='';

if (sizeof($messages)>0) {
foreach ($messages as $message){
// $ft->define(array('body'  => "mass_mail_msg_view.tpl"));
 $ft->define(array('body'  => "mass_mail_msg_edit.tpl"));

    $ft->assign( array(
                'ID' => $id,
                    'FROM_EMAIL' => $message->from_email,
                    'FROM_NAME' => $message->from_name,
                    'SUBJECT' => $message->subject,
                    'MESSAGE' => $message->message_body_html,
                    'MESSAGE_TEXT' => $message->message_body_text,
                    'SUBMIT'=> $subm,
                    'BACK' => stripslashes ($_COOKIE['now'])
                    ));

}
}else{
  $ft->define(array('body'  => "mass_mail_msg_edit.tpl"));
    $ft->assign( array(
                    'ID' => 0,
                    'FROM_EMAIL' => $_EMAIL,
                    'FROM_NAME' =>$_COMPANY_NAME,
   //                 'SUBJECT' => $message->subject,
     //               'MESSAGE' => $message->message_body_html,
       //             'MESSAGE_TEXT' => $message->message_body_text,
                     'SUBMIT'=> $subm,
                     'BACK' => stripslashes ($_COOKIE['now'])

                    ));


}


    $ft->parse('BODY', "body");
    $result=$ft->FastPrint("BODY",true);
$objResponse = new xajaxResponse('UTF-8');
$objResponse->addAssign( 'report_div', 'innerHTML', $result);
$objResponse->addScript( 'replaceDiv("message");');
return $objResponse->getXML();
}



function links_edit($id=0)
{
//global $_COMPANY_NAME,$_EMAIL;
setcookie('prev',stripslashes($_COOKIE['now']) );
setcookie('now',"href='#' onclick=\"javascript:links_edit(".$id.");\" ");
global $database,$mosConfig_absolute_path;
$database->setQuery( "set names utf8" );
$database->query();
$query=" select * from #__links a where link_id=".$id."  LIMIT 1";
$database->setQuery( $query );
$links = $database->loadObjectList();
$ft = new FastTemplate($mosConfig_absolute_path."/templates");
//$es=email_selectors($to_type,$to_id,$data);
$subm="<div id='sendbutton'><INPUT TYPE='submit' value='Save link'></div>";
if (sizeof($links)>0) {
foreach ($links as $link){
 $ft->define(array('body'  => "link_add.tpl"));

    $ft->assign( array(
                    'ID' => $id,
                    'NAME' => $link->link_name,
                    'URL' => $link->link_url,
                    'SUBMIT'=> $subm,
                    'BACK' => stripslashes ($_COOKIE['now'])
                    ));

}
}else{
  $ft->define(array('body'  => "link_add.tpl"));
    $ft->assign( array(
                  'ID' => 0,
                    'NAME' => 'Enter link name ...',
                    'URL' => 'http://',
                    'SUBMIT'=> $subm,
                    'BACK' => stripslashes ($_COOKIE['now'])
                    ));
}


 $ft->parse('BODY', "body");
$result=$ft->FastPrint("BODY",true);
$objResponse = new xajaxResponse('UTF-8');
$objResponse->addAssign( 'info_div', 'innerHTML', $result);
//$objResponse->addScript( 'replaceDiv("message");');
return $objResponse->getXML();
}

function save_message_template($formdata){
global $database, $mosConfig_absolute_path,$mosConfig_live_site,$_COMPANY_NAME, $_EMAIL, $_FOOTER1; ;
$database->setQuery( "set names utf8" );
$database->query();
$err=$result="";

foreach ($formdata as $key => $fdata) {
switch($key){
case 'message': $formdata[$key] = $fdata;break;
case 'to': $formdata[$key] = $fdata;break;
default:$formdata[$key] =  addslashes(strip_tags($fdata));break;

}
$result.="'".$key."'=>'".$formdata[$key]."'<br/>";
}

$message = $formdata['message'];
$html = str_get_html($message);
foreach($html->find('img') as $element){
      $url=$element->src;
      $url2= str_replace("=","/",$url);
      $n=explode('/',$url2); if ($n[0]=='http:'){
      $filename=$n[sizeof($n)-1];
      file_put_contents(dirname(__FILE__)."/cache/image/".$filename, file_get_contents($url));
      $element->src = "modules/cache/image/".$filename;
      }
}
if ($formdata['id']>0){
$query=" UPDATE `#__message_templates` set
`from_email` = '".$formdata['from_email']."',
`from_name` =  '".$formdata['from_name']."',
`subject` =  '".addslashes($formdata['subject'])."' ,
`message_body_text` =  '".$formdata['message_text']."',
`message_body_html`= '".$html."',
`status` = '0'
where message_id=".$formdata['id'];



}else{
$query="INSERT INTO `#__message_templates` (
`from_email` , `from_name` ,`subject` , `message_body_text`,`message_body_html`,  `status` )
VALUES ( '".$formdata['from_email']."', '".$formdata['from_name']."', '".addslashes($formdata['subject'])."' ,'".$formdata['message_text']."','".$html."',  '0'
)";

}
$database->setQuery( $query );
$database->query();
$id= $database->insertid();

return mass_mail(0);
}

function mail_list_save($formdata){
global $database, $mosConfig_absolute_path,$mosConfig_live_site ;
$database->setQuery( "set names utf8" );
$database->query();
$err=$result="";

foreach ($formdata as $key => $fdata) {
$formdata[$key] =  $fdata;
$result.="'".$key."'=>'".$formdata[$key]."'<br/>";
}

if ($formdata['list_id']>0){
$query=" UPDATE `#__mail_list` set
`name` = '".$formdata['name']."',
`status` = '0'
where id=".$formdata['list_id'];
}
else{
$query="INSERT INTO `#__mail_list` (`name`,`status` )
VALUES ( '".$formdata['name']."', 0 )";

}
$database->setQuery( $query );
$database->query();
return mass_mail(1);
}


function links_save($formdata){
global $database, $mosConfig_absolute_path,$mosConfig_live_site ;
$database->setQuery( "set names utf8" );
$database->query();
$err=$result="";
foreach ($formdata as $key => $fdata) {
$formdata[$key] = $fdata;
$result.="'".$key."'=>'".$formdata[$key]."'<br/>";
}
if ($formdata['link_id']>0){
$query=" UPDATE `#__links` set
`link_name` = '".$formdata['link_name']."',
`link_url` = '".$formdata['link_url']."'
where link_id=".$formdata['link_id'];
}
else{
$query="INSERT INTO `#__links` (`link_name`,`link_url` )
VALUES ( '".$formdata['link_name']."','".$formdata['link_url']."' )";
}
$database->setQuery( $query );
$database->query();
return links_list();
}

function mail_list_cont_save($formdata){
global $database, $mosConfig_absolute_path,$mosConfig_live_site ;
$database->setQuery( "set names utf8" );
$database->query();
$err=$result="";

foreach ($formdata as $key => $fdata) {
$formdata[$key] =  $fdata;
$result.="'".$key."'=>'".$formdata[$key]."'<br/>";
}

if ($formdata['id']>0){
$query=" UPDATE `#__mail_list_content` set
`m_company` = '".$formdata['m_company']."',
`m_name` = '".$formdata['m_name']."',
`m_email` = '".$formdata['m_email']."'
where id=".$formdata['id'];
}
else{
$query="INSERT INTO `#__mail_list_content` (`m_name`, `m_company`, `m_email`, `list_id` )
VALUES ( '".$formdata['m_name']."','".$formdata['m_company']."','".$formdata['m_email']."', ".$formdata['list_id']." )";
}
$database->setQuery( $query );
$database->query();
return mass_mail(2,$formdata['list_id']);
}

function mail_list_delete($id){
global $database, $mosConfig_absolute_path,$mosConfig_live_site ;
$query="delete from `#__mail_list_content` where list_id=".$id;
$database->setQuery( $query );
$database->query();
$query="delete from `#__mail_list` where id=".$id;
$database->setQuery( $query );
$database->query();
return mass_mail(1);
}

function mail_list_cont_delete($list_id, $id){
global $database, $mosConfig_absolute_path,$mosConfig_live_site ;
$query=" delete from `#__mail_list_content` where id=".$id;
$database->setQuery( $query );
$database->query();
return mass_mail(2,$list_id);
}

function mail_delete_msg($id){
global $database, $mosConfig_absolute_path,$mosConfig_live_site ;
$query=" delete from `#__message_templates` where message_id=".$id;
$database->setQuery( $query );
$database->query();
return mass_mail(0);
}

function mass_mail_queque_list($page=0){
setcookie('prev',stripslashes($_COOKIE['now']) );
setcookie('now',"href='#' onclick=\"javascript:mass_mail(".$page.");\" ");
global $database,$mosConfig_absolute_path;
$ft = new FastTemplate($mosConfig_absolute_path."/templates");
$ft->define(array(
                'head'  => "mass_mail_queque_list_header.tpl",
                'item'  => "mass_mail_queque_list_item.tpl",
                'foot'  => "mass_mail_queque_list_footer.tpl",
));
$ft->assign( array(
                    'ACTIONS' =>"javascript:mm_edqueque(0)"
                    ));
$ft->parse('HEAD', "head");
$html=$ft->FastPrint('HEAD',true);
$database->setQuery( "set names utf8" );
$database->query();
$select=" SELECT `id`, `templ_id`, (select t.subject from #__message_templates t where t.message_id=q.templ_id ) as tmplname, `list_id`, (select l.name from #__mail_list l where l.id=q.list_id ) as listname, `qdate`, `qty`, `sent` FROM #__msg_queque_header q WHERE 1";
$database->setQuery( $select );
$msgs = $database->loadObjectList();
foreach ($msgs as $msg){
$ft->assign( array(
                    'ID' =>$msg->id,
                //    'ACT_EDIT' =>"<a href='#' onclick='javascript:mass_mail_edit_msg(".$msg->id.")'><img src='images/blog-post-edit-24x24.png' align='absmiddle' border=0></a>",
               //     'ACT_VIEW' =>"<a href='#' onclick='javascript:mass_mail_view_msg(".$msg->message_id.")'><img src='images/blog-post-edit-24x24.png' align='absmiddle' border=0></a>",
               //    'ACT_DEL'  =>"<a href='#' onclick='javascript:mail_delete_msg(".$msg->id.")'><img src='images/trash-empty-24x24.png' align='absmiddle' border='0'></a>",
                    'TMPLNAME' =>"<a href='#' class='style34' onclick='javascript:mass_mail_view_msg(".$msg->id.")'>".$msg->tmplname."</a>",
                    'LISTNAME' =>$msg->listname,
                    'QTY' =>$msg->qty,
                    'SENT' =>$msg->sent,
                    'DATE' =>$msg->qdate
                    ));
$ft->parse('ITEMS','.item');
}
$ft->parse('FOOT','foot');
if(sizeof($msgs)>0)$html.=$ft->FastPrint('ITEMS',true);
$html.=$ft->FastPrint('FOOT',true);
return $html;
}
function links_list($page=0){
global $_PERPAGE;
$per_page=$_PERPAGE;
$html="";
$add=" LIMIT ".$page*$per_page.",".$per_page;
setcookie('prev',stripslashes($_COOKIE['now']) );
setcookie('now',"href='#' onclick=\"javascript:links_list(".$page.");\" ");
global $database,$mosConfig_absolute_path;
$ft = new FastTemplate($mosConfig_absolute_path."/templates");
$ft->define(array(
                'head'  => "links_list_header.tpl",
                'item'  => "links_list_item.tpl",
                'foot'  => "links_list_footer.tpl"
));
$ft->assign( array(
                    'ACTIONS' =>"javascript:links_edit(0)"
                    ));
$ft->parse('HEAD', "head");
$html=$ft->FastPrint('HEAD',true);
$database->setQuery( "set names utf8" );
$database->query();
$select=" SELECT * FROM #__links  order by link_id asc  ".$add;
//$html.=$select;
$database->setQuery( $select );
$links = $database->loadObjectList();
foreach ($links as $link){
$ft->assign( array(
                    'ID' =>$link->link_id,
                    'ACT_EDIT' =>"<a href='#' onclick='javascript:links_edit(".$link->link_id.")'><img src='images/blog-post-edit-24x24.png' align='absmiddle' border=0></a>",
                    'ACT_DEL'  =>"<a href='#' onclick='javascript:links_delete(".$link->link_id.")'><img src='images/trash-empty-24x24.png' align='absmiddle' border='0'></a>",
                    'NAME' =>"<a class='style34' href='".$link->link_url."' target='_blank'>".$link->link_name."</a>",
                    'LINK' =>"<a class='style34' href='".$link->link_url."' target='_blank'>".$link->link_url."</a>"
                    ));
$ft->parse('ITEMS','.item');
}
$ft->parse('FOOT','foot');
if(sizeof($links)>0)$html.=$ft->FastPrint('ITEMS',true);
$html.=$ft->FastPrint('FOOT',true);
$objResponse = new xajaxResponse('UTF-8');
$objResponse->addAssign( 'report_div', 'innerHTML', $html );
return $objResponse->getXML();
}

function mass_mail_msg_list($page=0){
setcookie('prev',stripslashes($_COOKIE['now']) );
setcookie('now',"href='#' onclick=\"javascript:mass_mail(".$page.");\" ");
global $database,$mosConfig_absolute_path;
$ft = new FastTemplate($mosConfig_absolute_path."/templates");
$ft->define(array(
                'head'  => "mass_mail_msg_list_header.tpl",
                'item'  => "mass_mail_msg_list_item.tpl",
                'foot'  => "mass_mail_msg_list_footer.tpl",
));
$ft->assign( array(
                    'ACTIONS' =>"javascript:mass_mail_edit_msg(0)"
                    ));
$ft->parse('HEAD', "head");
$html=$ft->FastPrint('HEAD',true);
$database->setQuery( "set names utf8" );
$database->query();
$select=" SELECT * FROM `#__message_templates` ".$add." order by `message_id` asc";
$database->setQuery( $select );
$msgs = $database->loadObjectList();
foreach ($msgs as $msg){
$ft->assign( array(
                    'ID' =>$msg->message_id,
                    'ACT_EDIT' =>"<a href='#' onclick='javascript:mass_mail_edit_msg(".$msg->message_id.")'><img src='images/blog-post-edit-24x24.png' align='absmiddle' border=0></a>",
               //     'ACT_VIEW' =>"<a href='#' onclick='javascript:mass_mail_view_msg(".$msg->message_id.")'><img src='images/blog-post-edit-24x24.png' align='absmiddle' border=0></a>",
                    'ACT_DEL'  =>"<a href='#' onclick='javascript:mail_delete_msg(".$msg->message_id.")'><img src='images/trash-empty-24x24.png' align='absmiddle' border='0'></a>",
                    'SUBJ' =>"<a href='#' class='style34' onclick='javascript:mass_mail_view_msg(".$msg->message_id.")'>".$msg->subject."</a>",
                    'FROM' =>$msg->from_name,
                    'EMAIL' =>$msg->from_email,
                    'DATE' =>$msg->mesage_date
                    ));
$ft->parse('ITEMS','.item');
}
$ft->parse('FOOT','foot');
if(sizeof($msgs)>0)$html.=$ft->FastPrint('ITEMS',true);
$html.=$ft->FastPrint('FOOT',true);
return $html;
}

function mass_mail_mailing_list($list_id=0,$page=0){
setcookie('prev',stripslashes($_COOKIE['now']) );
setcookie('now',"href='#' onclick=\"javascript:mass_mail(1,".$page.");\" ");
global $database,$mosConfig_absolute_path;
$ft = new FastTemplate($mosConfig_absolute_path."/templates");
$ft->define(array(
                'head'  => "mass_mail_mailing_list_header.tpl",
                'item'  => "mass_mail_mailing_list_item.tpl",
                'foot'  => "mass_mail_mailing_list_footer.tpl",
));
$ft->assign( array(
                    'ACTIONS' =>"javascript:mm_edlist(0)"
                    ));
$ft->parse('HEAD', "head");
$html=$ft->FastPrint('HEAD',true);
$database->setQuery( "set names utf8" );
$database->query();
$select=" SELECT l.id, l.name, (SELECT COUNT(*) FROM #__mail_list_content c WHERE c.list_id = l.id ) AS count
FROM #__mail_list l ORDER BY l.name asc";
$database->setQuery( $select );
$msgs = $database->loadObjectList();
foreach ($msgs as $msg){
$ft->assign( array(
                    'ID' =>$msg->id,
                    'ACT_EDIT' =>"<a href='#' onclick='javascript:mm_edlist(".$msg->id.")'><img src='images/blog-post-edit-24x24.png' align='absmiddle' border=0></a>",
                  //  'ACT_VIEW' =>"<a href='#' onclick='javascript:mass_mail_mailing_cont_list(".$msg->id.",0)'><img src='images/blog-post-edit-24x24.png' align='absmiddle' border=0></a>",
                    'ACT_DEL'  =>"<a href='#' onclick='javascript:mail_list_delete(".$msg->id.")'><img src='images/trash-empty-24x24.png' align='absmiddle' border='0'></a>",
                    'LISTNAME' =>"<a href='#' class='style34' onclick='javascript:mass_mail(2,".$msg->id.",1)'>".$msg->name."</a>",
                    'COUNT' =>$msg->count
                    ));
$ft->parse('ITEMS','.item');
}
$ft->parse('FOOT','foot');
if(sizeof($msgs)>0)$html.=$ft->FastPrint('ITEMS',true);
$html.=$ft->FastPrint('FOOT',true);
return $html;
}

function mass_mail_mailing_cont_list($list_id,$page){
setcookie('prev',stripslashes($_COOKIE['now']) );
setcookie('now',"href='#' onclick=\"javascript:mass_mail(1,".$page.");\" ");
global $database,$mosConfig_absolute_path;
$ft = new FastTemplate($mosConfig_absolute_path."/templates");
$ft->define(array(
                'head'  => "mass_mail_mailing_list_cont_header.tpl",
                'item'  => "mass_mail_mailing_list_cont_item.tpl",
                'foot'  => "mass_mail_mailing_list_cont_footer.tpl",
));

$database->setQuery( "set names utf8" );
$database->query();
$sql = 'SELECT name FROM #__mail_list where id='.$list_id;
$database->setQuery( $sql );
$list_name = $database->loadResult();
$ft->assign( array(
                    'ACTIONS' =>"javascript:mm_edlistcont(".$list_id.",0)",
                    'LIST_NAME' => $list_name
                    ));
$ft->parse('HEAD', "head");
$html=$ft->FastPrint('HEAD',true);

$select=" SELECT * FROM #__mail_list_content where list_id=".$list_id." order by m_name asc";
$database->setQuery( $select );
$msgs = $database->loadObjectList();
foreach ($msgs as $msg){
$ft->assign( array(
                    'ID' =>$msg->id,
                    'ACT_EDIT' =>"<a href='#' onclick='javascript:mm_edlistcont(".$list_id.",".$msg->id.")'><img src='images/blog-post-edit-24x24.png' align='absmiddle' border=0></a>",
                    'ACT_DEL'  =>"<a href='#' onclick='javascript:mail_list_cont_delete(".$list_id.",".$msg->id.")'><img src='images/trash-empty-24x24.png' align='absmiddle' border='0'></a>",
                    'COMPANY' =>"<a href='#' class='style34' onclick='javascript:mm_edlistcont(".$list_id.",".$msg->id.")'>".$msg->m_company."</a>",
                    'CONTACT' =>$msg->m_name,
                    'EMAIL' =>$msg->m_email
                    ));
$ft->parse('ITEMS','.item');
}
$ft->parse('FOOT','foot');
if(sizeof($msgs)>0)$html.=$ft->FastPrint('ITEMS',true);
$html.=$ft->FastPrint('FOOT',true);
return $html;
}


function mass_mail($id=0,$item=0,$page=0){

//$result=mass_mail_draw_menu($id);
switch($id)
{
case 0: $result.=mass_mail_msg_list(); break;
case 1: $result.=mass_mail_mailing_list($item); break;
case 2: $result.=mass_mail_mailing_cont_list($item,$page); break;
case 3: $result.=mass_mail_queque_list($page); break;
default: $result.=""; break;
}
//$result.=mass_mes_list();
$objResponse = new xajaxResponse('UTF-8');
$objResponse->addAssign( 'report_div', 'innerHTML', $result );
return $objResponse->getXML();

}
//==================================================================================================================



function user_list($id) {
if (isset($id)) $ss=$id; else $ss=0;

switch  ($ss)
{
	case 0: $add=" where status >0 "; break;
	case 1: $add=" where status <1 "; break;
}


$result="<h3>Users</h3>";
$result.= "<TABLE><TR><TD><button onclick='javascript:getUserInfo(0);'>Add new user</button></TD><TD>";
if ($id!=0) $result.= "<A HREF='#' onclick='javascript:users_list(0);'>Active</A>";else  $result.= "[<B>Active</B>]";
 $result.= "&nbsp;|&nbsp;";
if ($id!=1) $result.= "<A HREF='#' onclick='javascript:users_list(1);'>Blocked</A>";else  $result.= "[<B>Blocked</B>]";
 $result.= "</TD></TR></TABLE>";

global $database;
$database->setQuery( "set names utf8" );
$database->query();
$sound_companies = array();
$select=" SELECT * FROM `#__users` ".$add." order by `username` asc";
$database->setQuery( $select );
$users = $database->loadObjectList();
if (sizeof($users)>0)  $result.= "<div style='z-index:3;'><TABLE class='tt'><TR><TH>id</TH><TH>Action</TH><TH>Login</TH><TH>User name</TH><TH>Status</TH><TH>Last login</TH></TR>"; else  $result.= "<TABLE class='tt'><TR><TH>Nobody here...</TH></TR></TABLE>";

foreach ($users as $user)
	{
 $result.= "<TR><TD>".$user->user_id ."</TD><TD>";
 $result.="<button onclick='getUserInfo(".$user->user_id.")' class='bt'><IMG SRC='/ico/application.png' WIDTH='16' HEIGHT='16' BORDER='0' ALT=''></button>&nbsp;&nbsp;";
// $result.="<button onclick='editUserInfo(".$user->user_id.")' class='bt'><IMG SRC='/ico/reply.png' WIDTH='16' HEIGHT='16' BORDER='0' ALT=''></button>&nbsp;&nbsp;";
// $result.="<button onclick='deleteUserInfo(".$user->user_id.")' class='bt'><IMG SRC='/images/del.gif' WIDTH='16' HEIGHT='16' BORDER='0' ALT=''></button>";
 $result.= "</TD><TD>".$user->login ."</TD><TD>".$user->username."&nbsp;".$user->lastname."</TD><TD>".$user->status."</TD><TD>".$user->lastlogin."</TD></TR>";
}

$result.= "</table></div><BR><BR>".print_legend();

return $result;

}
function users_list($id)
{
$result= user_list($id);
$objResponse = new xajaxResponse('UTF-8');
$objResponse->addAssign( 'report_div', 'innerHTML', $result );
return $objResponse->getXML();

}
function getUserInfo($id){

$md5id=md5($id."LickMyDick");
$result="";
if ($id>0) $header="User&nbsp;info&nbsp;№&nbsp;".$id; else $header="Add new user";
global $database;
$database->setQuery( "set names utf8" );
$database->query();
$users = array();
$select=" SELECT * FROM `#__users` where `user_id`=".$id;
$database->setQuery( $select );
$users = $database->loadObjectList();
$result.="
<TABLE align='center' valign='middle' width='100%' height='100%' cellpadding=0 cellspacing=0 border=0>
<TR>
	<TD>
<TABLE style='border:15px white solid;background-color: #eeeeee;' align='center' valign='middle' cellpadding=0 cellspacing=0>
<TR>
	<TD>
<TABLE class='h3' style='border:1px gray solid;background-color: #eeeeee;'><TR><td colspan=2 align='right'><button onclick='javascript:hideInfo();'><IMG SRC='/images/del.gif' WIDTH='16' HEIGHT='16' BORDER='0' ALT=''></button></td></TR>
<TR><TH colspan=2 class='h2'>".$header."</TH>
</TR><TR>	<TD valign='top'  class='h1'>";
$result.="<form id='users_data' name='users_data' action=\"javascript:saveUsers(xajax.getFormValues('users_data'));\" method=POST>";
if (sizeof($users)>0){
foreach ($users as $user) {}
$result.="<TABLE><TR>
	<TD>Login (User ID)</TD>
	<TD><INPUT TYPE='text' NAME='login' id='login' value='".$user->login."' size=40></TD>
</TR><TR>
	<TD>Name</TD>
	<TD><INPUT TYPE='text' NAME='username' id='username' value='".$user->username."' size=40></TD>
</TR>
<TR>
	<TD>Last name</TD>
	<TD><INPUT TYPE='text' NAME='lastname' id='lastname' value='".$user->lastname."' size=40></TD>
</TR>
<TR>
	<TD>e-mail</TD>
	<TD><INPUT TYPE='text' NAME='email' id='email' value='".$user->email."' size=40></TD>
</TR>
<TR>
	<TD>New password</TD>
	<TD><INPUT TYPE='password' NAME='pass1' id='pass1'  size=40></TD>
</TR>
<TR>
	<TD>Check password</TD>
	<TD><INPUT TYPE='password' NAME='pass2' id='pass2'  size=40></TD>
</TR>
<TR>
<TD>Status</TD>
<TD>
<select name='status'>
	<option value=1 ";
if(isset($user->status)&&($user->status>0)) $result.= " selected ";
$result.= ">Active</option>
	<option value=0 style='color:red'";
if(isset($user->status)&&($user->status==0))	$result.= " selected ";
$result.= "	>Blocked</option>
	</select></TD>
</TR>
<TR>
	<TD>Last login:</TD>
	<TD>".$user->lastlogin."<input type='hidden' name='checker' id='checker' value=".$md5id.">
    <input type='hidden' name='id' id='id' value=".$id."></TD>
</TR>
";

} else {

$result.="<TABLE><TR>	<TD>Login (User ID)</TD>
	<TD><INPUT TYPE='text' NAME='login' id='login' value='' size=40></TD>
</TR><TR><TD>Name</TD><TD><INPUT TYPE='text' NAME='username' id='username' value='' size=40></TD>
</TR><TR><TD>Lastname</TD><TD><INPUT TYPE='text' NAME='lastname' id='lastname' value='' size=40></TD>
</TR><TR><TD>email</TD><TD><INPUT TYPE='text' NAME='email' id='email' value='' size=40></TD>
</TR><TR><TD>New password</TD>	<TD><INPUT TYPE='password' NAME='pass1' id='pass1'  size=40></TD>
</TR><TR><TD>Check password</TD><TD><INPUT TYPE='password' NAME='pass2' id='pass2'  size=40></TD>
</TR><TR><TD>Status</TD><TD>
<select name='status'><option value=1 >Active</option><option value=0 style='color:red'>Blocked</option>
	</select><input type='hidden' name='checker' id='checker' value=".$md5id.">
    <input type='hidden' name='id' id='id' value=".$id."></TD>
</TR>
";
}
$result.="<TR><TD colspan=2 align='center'><INPUT TYPE='submit' value='Save' type='button'></TD>
</TR></TABLE></FORM>
</TD></TR></TABLE></TD></TR></TABLE></TD></TR></TABLE>";
$objResponse = new xajaxResponse('UTF-8');
$objResponse->addAssign( 'info_div', 'innerHTML', $result );
return $objResponse->getXML();
}


function saveUsers($userdata){
global $database;
$result="";
$database->setQuery( "set names utf8" );
$database->query();
foreach ($userdata as $key => $value) {
	$userdata[$key] = addslashes(strip_tags($value));
}
if ($userdata['checker']!=md5($userdata['id']."LickMyDick")) {
$objResponse = new xajaxResponse('UTF-8');
$objResponse->addAssign( 'report_div', 'innerHTML', "Shit happens! Robots have sex." );
return $objResponse->getXML();
}
$passwd=md5($userdata['pass1']);
if ($userdata['id']>0){
$up1="update `#__users` set
`login`='".$userdata['login']."',
`username`='".$userdata['username']."',
`lastname`='".$userdata['lastname']."',
`email`='".trim($userdata['email'])."',
`status`=".$userdata['status']." ";

$up2=" where `user_id`=".$userdata['id'];
if (($userdata['pass1']!='')&&($userdata['pass1']==$userdata['pass2']))
$update=$up1." , `password`='".$passwd."' ".$up2; else $update=$up1.$up2;
//$database->setQuery( $update );
//$database->query();
} else {
 if (($userdata['pass1']!='')&&($userdata['pass1']==$userdata['pass2'])) {
$insert="insert into `#__users` (`username`,`lastname`,`login`,`password`,`status`,`email`)
values
('".$userdata['username']."','".$userdata['lastname']."','".$userdata['login']."','".$passwd."', ".$userdata['status'].", '".$userdata['email']."' ) ";
//$database->setQuery( $insert );
//echo $insert;
//$database->query();
   }
}
$result=user_list(0);
$objResponse = new xajaxResponse('UTF-8');
$objResponse->addAssign( 'report_div', 'innerHTML', $insert.$result );
return $objResponse->getXML();
}

function viewSchedule ($id_artist, $yr=2010, $date_from="",$date_to="",$week=0){
$result=viewSchedules ($id_artist, $yr, $date_from,$date_to,$week);
$objResponse = new xajaxResponse('UTF-8');
$objResponse->addAssign( 'sch_info', 'innerHTML', $result );
return $objResponse->getXML();
}
function viewSchedules ($id_artist, $yr=2012, $date_from="",$date_to="",$week=0){
$a=0;
global $database,$mosConfig_live_site;
if (($week>0)&&($week<54))
{

$date_from=date("Y-m-d", mktime(0, 0, 0, 1, ($week)*7-6, date("Y")));
$date_to=date("Y-m-d", mktime(0, 0, 0, 1, ($week+1)*7-6, date("Y")));


}
if ((isset($date_from))&&(((!isset($date_to))||($date_to=="")||($date_to=="undefined"))))$date_to=$date_from;
if ((!isset($date_from))||($date_from=="")||($date_from=="undefined"))$date_from=date("Y-m-d");
if ((!isset($date_to))||($date_to=="")||($date_to=="undefined")) $date_to=date("Y-m-d");


list($year_e,$month_e,$day_e)=explode("-", $date_to);
list($year_b,$month_b,$day_b)=explode("-", $date_from);
if ($year_b*1>$year_e*1) {$o=$year_b*1;$year_b=$year_e*1;$year_e=$o;}
if (($year_b==$year_e)&&($month_b>$month_e)){$o=$month_b*1;$month_b=$month_e*1;$month_e=$o;}
$database->setQuery( "set names utf8" );$database->query();
session_register('id_artist');
$_SESSION['id_artist']=$id_artist;
$artists = array();
        $qr="SELECT * from #__artists where id=".$id_artist ;
		$database->setQuery( $qr);
		$artists = $database->loadObjectList();
		foreach ($artists as $artist ){}
$m = new Calendar;
$m->startDay=1; // Начинаем с понедельника
$months= array (1,2,3,4,5,6,7,8,9,10,11,12);
$py=$yr-1;$ny=$yr+1;
$result="<table width='95%' border='0' align='center' cellpadding='0' cellspacing='1' bgcolor='#999999' class='tdcenter'>
<tr><td bgcolor='#999999' class='style4'><table width='100%' border='0' align='center' cellpadding='2' cellspacing='1'><tr>
<td height='67' colspan='2' bgcolor='#FFFFFF' align='center' valign='middle'><p class='style17'>".$artist->name."<br>ITINERARY&nbsp;&nbsp;&nbsp;";
$result.="<INPUT TYPE='text' NAME='venue_date' id='venue_date' size='10' value='".$date_from."'>&nbsp;<a href='#' onclick='javascript:cal1xx.select(document.getElementById(\"venue_date\"),\"anchor1xx\",\"yyyy-MM-dd\");return false;'  NAME='anchor1xx' ID='anchor1xx'><img src='".$mosConfig_live_site."/images/itinerary-24x24.png' align='absmiddle' border=0></a>&nbsp;<button  onclick=\"javascript:viewSchedule(".$id_artist.",".$yr.",document.getElementById('venue_date').value);\">Show calendar month</button>";
//$result.="<a href='#' title='previous Year' onclick=\"javascript:viewSchedule(".$id_artist.",".$py.");return false;\"><img src='images/back-24x24.png' border=0 align='absmiddle'></a>&nbsp;<b>".$yr."</b>";
//$result.="&nbsp;<a href='#'  title='next Year' onclick=\"javascript:viewSchedule(".$id_artist.",".$ny.");return false;\"><img src='images/next-24x24.png' border=0 align='absmiddle'></a>";
$result.="<input type='hidden' name='yr' id='yr' value='".$yr."'>";

$result.="</p></td></tr><tr>";
$i=0;$month=$month_b;$yr=$year_b;
while (($yr<=$year_e)&&($month<=$month_e))
{
$result.="<td bgcolor='#FFFFFF' valign='top' align='center' >".$m->getMonthView($month,$yr,$id_artist)."</td>";
$i++; if ($i==2) {$result.="</tr><tr>";$i=0;}
$month++;
if($month>12){ $month=1;$yr++; }
}
if ($i==1) $result.="<td bgcolor='#FFFFFF'>&nbsp;</td>";
$result.="</tr></table></td></tr></table>
<div id='opt_info' name='opt_info' style='display:none;'>&nbsp;</div>
<div id='perf_info' name='perf_info' style='display:none;'>&nbsp;</div>";
return $result;
}

function viewSchedule2 ($id_artist, $yr ){

global $database;
$database->setQuery( "set names utf8" );$database->query();
session_register('id_artist');
$_SESSION['id_artist']=$id_artist;
$result="";

		$artists = array();
        $qr="SELECT * from #__artists where id=".$id_artist ;
		$database->setQuery( $qr);
		$artists = $database->loadObjectList();
		foreach ($artists as $artist ){}
$m = new Calendar;
$months= array (1,2,3,4,5,6,7,8,9,10,11,12);
$py=$yr-1;$ny=$yr+1;
$result.="<table 'width=100%' border=0><tr><td nowrap><h3>".$artist->name." Schedule</h3></td><td align='right' width='100%'>";
$result.="<a href='#' title='previous Year' onclick=\"javascript:viewSchedule(".$id_artist.",".$py.");return false;\"><img src='images/back-24x24.png' border=0 align='absmiddle'></a><b>".$yr."</b>";
$result.="<a href='#'  title='next Year' onclick=\"javascript:viewSchedule(".$id_artist.",".$ny.");return false;\"><img src='images/next-24x24.png' border=0 align='absmiddle'></a>";
$result.="<input type='hidden' name='yr' id='yr' value='".$yr."'>";
$result.="</td></tr></table>";
$i=0;$result.="<table align='center' cellpadding=10><tr>";
foreach($months as $month){
$result.="<td valign='top' align='center'>".$m->getMonthView($month,$yr,$id_artist)."</td>";;
$i++; if ($i==6) $result.="</tr><tr>";
}
$result.="</table></td>

              </tr>
            </table>
<div id='opt_info' style='border:1px #DDD solid;display:none;'>&nbsp;</div>";
return $result ;
}


function sch_list( $id )
{
global $database,$mosConfig_live_site;

$result="<form name='drawschedule' id='drawschedule' method='POST' action=\"javascript:viewSchedule(document.getElementById('id_artist').value,document.getElementById('yr').value,document.getElementById('date_from').value,document.getElementById('date_to').value);\">
";
$result.="
            <table width='95%' border='0' align='center' cellpadding='0' cellspacing='1' bgcolor='#999999'>
              <tr>
                <td bgcolor='#999999' class='style4'><table width='100%' border='0' align='center' cellpadding='0' cellspacing='1'>
                  <tr>
                    <td width='122%' height='36' colspan='3' bgcolor='#F5F5F5' align='center'><p class='style5'>Artist";
$database->setQuery( "set names utf8" );
$database->query();
$countries = array();
$database->setQuery( "SELECT id, name from #__artists  ORDER BY id" );
$countries = $database->loadObjectList();
$result.= mosHTML::selectList( $countries, 'id_artist', " id='id_artist' ", 'id', 'name' );


$thisyear=date("Y", mktime (0,0,0,date("m")  ,date("d"),date("Y")));
$result.="<!--&nbsp;From&nbsp;<INPUT name='date_from' id='date_from' type=text style='WIDTH: 80px' value='' maxLength=10>";
$result.="&nbsp;<a href='#' onclick='javascript:cal1xx.select(document.getElementById(\"date_from\"),\"date_fromxx\",\"yyyy-MM-dd\");return false;'  NAME='date_fromxx' ID='date_fromxx'><img src='".$mosConfig_live_site."/images/itinerary-24x24.png'  align='absmiddle' border=0></a>";
$result.="&nbsp;&nbsp;TO&nbsp;<INPUT name='date_to' id='date_to' type=text style='WIDTH: 80px' value='' maxLength=10>";
$result.="&nbsp;<a href='#' onclick='javascript:cal1xx.select(document.getElementById(\"date_to\"),\"date_toxx\",\"yyyy-MM-dd\");return false;'  NAME='date_toxx' ID='date_toxx'><img src='".$mosConfig_live_site."/images/itinerary-24x24.png'  align='absmiddle' border=0></a>";
$result.="&nbsp;&nbsp;<input type='submit' value='View Itinerary'><input type='hidden' name='yr' id='yr' value='".$thisyear."'>";
$result.="&nbsp;&nbsp;--><button  onclick=\"javascript:get_busydays(document.getElementById('id_artist').value,".$thisyear.");return false;\">View Itinerary</button>";
$result.="</p></td></td></tr></table></td></tr></table></form>
<div id='sch_info' name='sch_info' style='border:1px #DDD solid;display:none;'></div>
";


$objResponse = new xajaxResponse('UTF-8');
$objResponse->addAssign( 'report_div', 'innerHTML', $result );
return $objResponse->getXML();
}


function getAlphaDate($date){
$monthNames = array("January", "February", "March", "April", "May", "June","July", "August", "September", "October", "November", "December");

$md=split('-',$date);
return $md[0].'&nbsp;'.$monthNames[$md[1]-1].'&nbsp;'.$md[2];
}

function getDetails($id_contract,$pid=0)
{
$result=addPerfForm($id_contract,$pid);
$objResponse = new xajaxResponse('UTF-8');
$objResponse->addAssign( 'info_div', 'innerHTML', $result );
return $objResponse->getXML();
}

function list_performs($id,$pid=0)
{
$objResponse = new xajaxResponse('UTF-8');
$objResponse->addAssign('opt_info', 'innerHTML', list_perform($id,$pid));
$objResponse->addAssign('opt_info','style.display',"block");
return $objResponse->getXML();
}



function list_perform($id,$pid=0)
{
global $database;
//$result="===$id===$pid===\n<br />";
$result="";
$database->setQuery( "set names utf8" );
$database->query();
$database->setQuery( "select id, DATE_FORMAT(date_of,'%Y-%m-%d') as date_ from #__perfomances where  contract_id=".$id." order by date_of asc");
$pd = array();
$pd = $database->loadObjectList();
$show_date="";
if (sizeof($pd)>0){ 
    $show_date.="<ul class='datelist'>";
    foreach ($pd as $p) {
    
if($p->id==$pid){     
    $show_date.="<li><a name='' class='active' onclick='list_performs(".$id.",".$p->id.");' title='show'>".$p->date_."</a></li>";
    }else{
if ($pid==0) 
{
    
    $show_date.="<li><a name='' class='active' onclick='list_performs(".$id.",".$p->id.");' title='show'>".$p->date_."</a></li>";    
    $pid=$p->id;
}else { 
    $show_date.="<li><a name='' onclick='list_performs(".$id.",".$p->id.");' title='show'>".$p->date_."</a></li>";
}
    
    }
}
    $show_date.="<li><a href='#' onclick='javascript:addPerfForms(".$id.");'><img src='images/add.gif' border='0' align='absmiddle' hspace=10> Add another day</a></li>";
    $show_date.="</ul>";
}
$q=""; if ($pid>0)$q=" and id=".$pid." ";
$database->setQuery( "select * from #__perfomances where contract_id=".$id.$q." limit 1");
$perfs = array();
$perfs = $database->loadObjectList();


if (sizeof($perfs)>0) foreach ($perfs as $perf) {
$pid=$perf->id;   
$database->setQuery( "select * from #__promoters where id=".$perf->id_promoter);
$proms = array();
$proms = $database->loadObjectList();
if ($perf->freeday >0) $FD="<div style='float:right'><b>Free day</b></div>";else $FD="";

if (strlen($perf->hotel_link)>20) $perf->hotel_link="<a href='".$perf->hotel_link."' target='_blank'>".substr($perf->hotel_link,0,20)."...</a>";
$result.="
      <table width='95%' border='0' align='center' cellpadding='0' cellspacing='1' bgcolor='#999999'>
        <tr>

          <td bgcolor='#999999' class='style4'><table width='100%' border='0' align='center' cellpadding='1' cellspacing='1'>

              <tr>
                <td height='36' colspan='4' bgcolor='#FFFFFF' class='style17'><div align='left' class='style32'>Performance schedule ".$show_date."</div></td>
              </tr>
              <tr>
                <td width='12%' height='36' bgcolor='#FFFFFF' class='style17'><div align='left'><span class='style17'>Date</span></div></td>
                <td width='39%' bgcolor='#FFFFFF' class='style17'><div align='left' class='style34'>".substr($perf->date_of,0,10)."".$FD."</div></td>

                <td height='36' bgcolor='#FFFFFF' class='style17'>Press conference</td>
                <td bgcolor='#FFFFFF' class='style17'><div align='left' class='style34'>".$perf->pressconf."</div></td>

              </tr>
              <tr>
                <td height='36' bgcolor='#FFFFFF' class='style17'><div align='left'><span class='style17'>City</span></div></td>
                <td bgcolor='#FFFFFF' class='style17'><div align='left' class='style34'>".$perf->city."</div></td>
                 <td height='36' bgcolor='#FFFFFF' class='style17'><div align='left'><span class='style17'>Dinner time</span></div></td>
                <td bgcolor='#FFFFFF' class='style34'><div align='left'>".$perf->dinner."</div></td>

              </tr>
              <tr>
                <td height='36' bgcolor='#FFFFFF' class='style17'><div align='left'><span class='style17'>Venue</span></div></td>
                <td bgcolor='#FFFFFF' class='style17'><div align='left' class='style34'>".$perf->venue."</div></td>
              <td width='14%' height='36' bgcolor='#FFFFFF' class='style17'><div align='left'><span class='style17'>Get in time</span></div></td>
                <td width='35%' bgcolor='#FFFFFF' class='style34'><div align='left'>".$perf->getintime."</div></td>


              </tr>
              <tr>
                <td height='36' bgcolor='#FFFFFF' class='style17'><div align='left'><span class='style17'>Capacity</span></div></td>
                <td bgcolor='#FFFFFF' class='style17'><div align='left' class='style34'>".$perf->capacity."</div></td>
                <td height='36' bgcolor='#FFFFFF' class='style17'><div align='left'><span class='style17'>Sound check</span></div></td>
                <td bgcolor='#FFFFFF' class='style34'><div align='left'>".$perf->soundcheck."</div></td>

              </tr>
              <tr>
                <td height='36' bgcolor='#FFFFFF' class='style17'><div align='left'><span class='style17'>Promouter</span></div></td>
                <td bgcolor='#FFFFFF' class='style17'><div align='left' class='style34'>";
               foreach ($proms as $prom) {$result.=$prom->name;}
                $result.="</div></td>
                                <td height='36' bgcolor='#FFFFFF' class='style17'><div align='left'><span class='style17'>Doors open</span></div></td>
                <td bgcolor='#FFFFFF' class='style34'><div align='left'>".$perf->doorsopen."</div></td>

              </tr>

              <tr>
                <td height='36' bgcolor='#FFFFFF' class='style17'><div align='left'><span class='style17'>Production</span></div></td>
                <td bgcolor='#FFFFFF' class='style17'><div align='left' class='style34'>".$perf->production."</div></td>
                <td height='36' bgcolor='#FFFFFF' class='style17'><div align='left'><span class='style17'>Concert start</span></div></td>
                <td bgcolor='#FFFFFF' class='style34'><div align='left'>".$perf->onstage."</div></td>
              </tr>
              <tr>
                <td height='36' bgcolor='#FFFFFF' class='style17' colspan='4'><div align='left' class='style32'>Hotel info</div></td>
              </tr>
              <tr>
                <td height='36' bgcolor='#FFFFFF' class='style17'><div align='left'><span class='style17'>Hotel name</span></div></td>
                <td bgcolor='#FFFFFF' class='style17'><div align='left' class='style34'>".$perf->hotel."</div></td>
                <td height='36' bgcolor='#FFFFFF' class='style17'><div align='left'><span class='style17'>City</span></div></td>
                <td bgcolor='#FFFFFF' class='style17'><div align='left' class='style34'>".$perf->hotel_city."</div></td>
              </tr>
              <tr>
                <td height='36' bgcolor='#FFFFFF' class='style17'><div align='left'><span class='style17'>Address</span></div></td>
                <td bgcolor='#FFFFFF' class='style17'><div align='left' class='style34'>".$perf->hotel_street."</div></td>
                <td height='36' bgcolor='#FFFFFF' class='style17'><div align='left'><span class='style17'>Phone</span></div></td>
                <td bgcolor='#FFFFFF' class='style17'><div align='left' class='style34'>".$perf->hotel_phone."</td>
              </tr>
              <tr>
                <td height='36' bgcolor='#FFFFFF' class='style17'><div align='left'><span class='style17'>E-mail</span></div></td>
                <td colspan=3 bgcolor='#FFFFFF' class='style17'><div align='left' class='style34'>".$perf->hotel_email."</div></td>
                  </tr>
              <tr>
                <td height='36' bgcolor='#FFFFFF' class='style17'><div align='left'><span class='style17'>P.S.</span></div></td>
                <td bgcolor='#FFFFFF' class='style17' colspan='3'><div align='left' class='style34'>".$perf->ps."</div></td>
              </tr>
              <tr>
                <td height='36' colspan='4' bgcolor='#FFFFFF'><div align='left'>&nbsp;&nbsp;&nbsp;&nbsp;

                <a href='#' onclick='javascript:getDetails(".$perf->contract_id.",".$pid.");'>
                <img src='images/edit.gif' width='20' height='20' align='absmiddle' border='0'></a>&nbsp;
                <a href='#' onclick='javascript:getDetails(".$perf->contract_id.",".$pid.");' class='style17'>Edit</a>
&nbsp;&nbsp;
                <a href='#' onclick='javascript:clear_perf(".$perf->contract_id.",".$pid.");'><img src='images/trash-empty-24x24.png'  align='absmiddle' border='0'></a>&nbsp;
<a href='#' onclick='javascript:clear_perf(".$perf->contract_id.",".$pid.");' class='style17'>Delete</a>


                </div></td>

              </tr>
          </table></td>
        </tr>
      </table>

";

 } else $result="
       <table width='95%' border='0' align='center' cellpadding='0' cellspacing='1' bgcolor='#999999'>
        <tr>
          <td bgcolor='#999999' class='style4'><table width='100%' border='0' align='center' cellpadding='1' cellspacing='1'>
 <tr><td height='36' colspan='5' bgcolor='#FFFFFF' class='style17'><div align='left'>&nbsp;&nbsp;&nbsp;
<a href='#' onclick='javascript:addPerf(".$perf->contract_id.");'>
<img src='images/comment-add-24x24.png'   align='absmiddle' border=0></a>&nbsp;<a href='#' onclick='javascript:getDetails(".$perf->contract_id.");' class='style17'>Add Perfomance</a>
&nbsp;&nbsp;&nbsp;<img src='images/right.gif' width='21' height='21' align='absmiddle'>Next day &nbsp;&nbsp;&nbsp;
<a href='#' onclick='javascript:clear_date(".$perf->contract_id.");'><img src='images/trash-empty-24x24.png'  align='absmiddle' border='0'></a>&nbsp;
<a href='#' onclick='javascript:clear_date(".$perf->contract_id.");' class='style17'>Clear all</a>

</div>
</td></tr></table></td></tr></table>";
return $result;
}



function addPerfForm($id_contract,$id_perf=0)
{
global $database,$mosConfig_absolute_path;
$database->setQuery( "set names utf8" );
$database->query();
 $q='select * from `#__perfomances` where contract_id='.$id_contract;
 /*if ($id_perf!=0) */$q.=" and id=".$id_perf;
$database->setQuery($q);
$perfs = array();
$perfs = $database->loadObjectList();
if (sizeof($perfs)>0){foreach ($perfs as $perf) { }  }
$q='select * from `#__contracts` where id='.$id_contract;
$database->setQuery($q);
$conts = array();
$conts = $database->loadObjectList();
if (sizeof($conts)>0){ 	foreach ($conts as $cont) { }  }
session_register('id_artist');
$id_artist=$cont->id_artist;
$today  = date("d-m-Y", mktime (0,0,0,date("d")  ,date("m"),date("Y")));
if (isset($perf->id)) $id_perf=$perf->id; else $id_perf=0;
if (isset($perf->perf_duration)) $PD=$perf->perf_duration; else  $PD=$cont->lenght_of;
if (isset($perf->concert_start)) $CS=substr_replace($perf->concert_start,'',5,5); else $CS=substr_replace($cont->concert_start,'',5,5);
if (isset($perf->doorsopen)) $DO.=substr_replace($perf->doorsopen,'',5,5); else $DO=substr_replace($cont->doors_open,'',5,5);
if (isset($perf->soundcheck)) $SC=substr_replace($perf->soundcheck,'',5,5); else  $SC=substr_replace($cont->sound_check,'',5,5);
if (isset($perf->pressconf )) $PC=$perf->pressconf; else  $PC=$cont->presconf;

$promoters = array();
$database->setQuery( "SELECT id, name from #__promoters  ORDER BY id" );
$promoters = $database->loadObjectList();
if (isset($perf->id_promoter)) $cnt=$perf->id_promoter; else $cnt=$cont->id_promoter;;
$PL = mosHTML::selectList( $promoters, 'id_promotere', ' DISABLED id="id_promotere" ', 'id', 'name', $cnt );
if (isset($perf->capacity)) $CP=$perf->capacity; else $CP=$cont->capacity;
if (isset($perf->venue)) $VE=$perf->venue; else $VE=$cont->venue;
if (isset($perf->city)) $CT=$perf->city; else $CT=$cont->town;
if (isset($perf->date_of)) $DA=substr_replace($perf->date_of,'',10,10); else $DA=substr_replace($cont->concert_date,'',10,10);
if (isset($perf->contract_id)) $CI=$perf->contract_id ; else $CI=$id_contract;
if (isset($perf->onstage )) $OS=$perf->onstage  ; else $OS=$cont->concert_start;
if (isset($perf->getintime  )) $GI=$perf->getintime    ; else $GI=$cont->acc_to_stage;
if (isset($perf->dinner  )) $DI=$perf->dinner   ; else $DI=$cont->dinner;
if ($perf->freeday ==1) $FD='checked';else $FD='';

$ft = new FastTemplate($mosConfig_absolute_path."/templates");
$ft->define(array('body'  => "performance.tpl"));
$ft->assign( array( 'ID_PROMOTER'=>  $cnt,
                    'PERF_ID' =>$id_perf,
                    'ID_ARTIST'=>$id_artist,
                    'PS'=>$perf->ps,
                    'PERF_DURATION'=>$PD,
                    'CS'=>$CS,
                    'ONSTAGE'=>$OS,
                    'DO'=>$DO,
                    'DINNER'=>$DI,
                    'SC'=>$SC,
                    'GI'=>$GI,
                    'PC'=>$PC,
                    'PR'=>$perf->production,
                    'HT'=>$perf->hotel,
                    'HTCITY'   =>$perf->hotel_city,
                    'HTSTREET' =>$perf->hotel_street,
                    'HTPHONE'  =>$perf->hotel_phone,
                    'HTEMAIL'  =>$perf->hotel_email,
                    'HTLINK'   =>"",
                    'VSTREET' =>$perf->venue_street,
                    'VPHONE'  =>$perf->venue_phone,
                    'VEMAIL'  =>$perf->venue_email,
                    'VLINK'   =>"",
                    'PL'=>$PL,
                    'CP'=>$CP,
                    'VE'=>$VE,
                    'CT'=>$CT,
                    'CO'=>$perf->country,
                    'DA'=>$DA,
                    'CI'=>$CI,
                    'FD'=>$FD,
                    'TODAY'=> $today,
                    'BACK'=> stripslashes ($_COOKIE['now'])
                    ));
            $ft->parse('BODY', "body");
$result=$ft->FastPrint("BODY",true);
return $result;
}

function addPerf($id_contract)
{
$result=addPerfForm($id_contract);
$objResponse = new xajaxResponse('UTF-8');
$objResponse->addAssign( 'info_div', 'innerHTML', $result );
return $objResponse->getXML();
}

function savePerform ($fdatas)
{
$result='';//$id_artist=$_SESSION['id_artist'];
//$objResponse = new xajaxResponse('UTF-8');
foreach ($fdatas as $key => $fdata) {
//	if (!get_magic_quotes_gpc()) {
	$fdatas[$key] = addslashes(strip_tags($fdata));
//} else {
//	$fdatas[$key] = strip_tags($fdata);
//}
//if ($fdata=='')
 $result.="'".$key."'=>'".$fdatas[$key]."'<br/>";
}
if ($fdatas['freeday']==1)$FD=1;else $FD=0;
if ($fdatas['perf_id']>0) {
$query.="update  #__perfomances set
`date_of`=\"".$fdatas['date_of']."\",
`country`=\"".$fdatas['country']."\",
`city`=\"".$fdatas['city']."\",
`venue`=\"".$fdatas['venue']."\",
`capacity`=\"".$fdatas['capacity']."\",
`id_promoter`=".$fdatas['id_promoter'].",
`id_artist`=".$fdatas['id_artist'].",


`venue_street`=\"".$fdatas['venue_street']."\",
`venue_phone`=\"".$fdatas['venue_phone']."\",
`venue_email`=\"".$fdatas['venue_email']."\",
`venue_link`=\"".$fdatas['venue_link']."\",
 `hotel`=\"".$fdatas['hotel']."\",
`hotel_street`=\"".$fdatas['hotel_street']."\",
`hotel_city`=\"".$fdatas['hotel_city']."\",
`hotel_phone`=\"".$fdatas['hotel_phone']."\",
`hotel_email`=\"".$fdatas['hotel_email']."\",
`hotel_link`=\"".$fdatas['hotel_link']."\",
`production`=\"".$fdatas['production']."\",";
if (trim($fdatas['pressconf'])=='') $query.=" pressconf=NULL, ";else $query.="`pressconf`=\"".$fdatas['pressconf']."\",";
if (trim($fdatas['getintime'])=='') $query.=" getintime=NULL, ";else $query.="`getintime`=\"".$fdatas['getintime']."\",";
if (trim($fdatas['dinner'])=='') $query.="dinner=NULL,";else $query.="dinner=\"".$fdatas['dinner']."\",";
if (trim($fdatas['doorsopen'])=='') $query.="doorsopen=NULL,";else $query.="doorsopen=\"".$fdatas['doorsopen']."\",";
if (trim($fdatas['concert_start'])=='') $query.="concert_start=NULL,";else $query.="concert_start=\"".$fdatas['concert_start']."\",";
if (trim($fdatas['onstage'])=='') $query.="onstage=NULL,";else $query.="onstage=\"".$fdatas['onstage']."\",";
if (trim($fdatas['contract_id'])=='') $query.="contract_id=NULL,";else $query.="contract_id=\"".$fdatas['contract_id']."\",";
$query.="
`perf_duration`=\"".$fdatas['perf_duration']."\",
`ps`=\"".$fdatas['ps']."\",
`status`=1,
freeday = ".$FD.",
`whosupdate`=".$_COOKIE['operator_id']." where id=".$fdatas['perf_id'];
global $database;
		$database->setQuery( "set names utf8" );
		$database->query();
		$database->setQuery( $query );
		$database->query();

$result.=$query;
} else {
$query="insert into #__perfomances  (
`date_of`,
`country`,
`city`,
`venue`,
`venue_street`,
`venue_phone`,
`venue_email`,
`venue_link`,
`capacity`,
`id_promoter`,
`id_artist`,
`hotel`,
`hotel_street`,
`hotel_city`,
`hotel_phone`,
`hotel_email`,
`hotel_link`,
`production`,
`pressconf`,
`getintime`,
`soundcheck`,
`dinner`,
`doorsopen`,
`concert_start`,
`onstage`, `contract_id`,
`perf_duration`,
`ps`,
`status`,
freeday,
`whosupdate`)
values (
\"".$fdatas['date_of']."\",\"".$fdatas['country']."\",\"".$fdatas['city']."\",\"".$fdatas['venue']."\",\"".$fdatas['venue_street']."\",\"".$fdatas['venue_phone']."\",\"".$fdatas['venue_email']."\",\"".$fdatas['venue_link']."\",\"".$fdatas['capacity']."\",".$fdatas['id_promoter'].",	".$fdatas['id_artist'].",\"".$fdatas['hotel']."\",";
$query.="\"".$fdatas['hotel_street']."\",\"".$fdatas['hotel_city']."\",\"".$fdatas['hotel_phone']."\",\"".$fdatas['hotel_email']."\",\"".$fdatas['hotel_link']."\",\"".$fdatas['production']."\",";
if (trim($fdatas['pressconf'])=='') $query.="NULL,";else $query.="\"".$fdatas['pressconf']."\",";
if (trim($fdatas['getintime'])=='') $query.="NULL,";else $query.="\"".$fdatas['getintime']."\",";
if (trim($fdatas['soundcheck'])=='') $query.="NULL,";else $query.="\"".$fdatas['soundcheck']."\",";
if (trim($fdatas['dinner'])=='') $query.="NULL,";else $query.="\"".$fdatas['dinner']."\",";
if (trim($fdatas['doorsopen'])=='') $query.="NULL,";else $query.="\"".$fdatas['doorsopen']."\",";
if (trim($fdatas['concert_start'])=='') $query.="NULL,";else $query.="\"".$fdatas['concert_start']."\",";
if (trim($fdatas['onstage'])=='') $query.="NULL,";else $query.="\"".$fdatas['onstage']."\",";
if (trim($fdatas['contract_id'])=='') $query.="NULL,";else $query.="\"".$fdatas['contract_id']."\",";

$query.="\"".$fdatas['perf_duration']."\",\"".$fdatas['ps']."\",1,".$FD.",".$_COOKIE['operator_id'].")";
$result.=$query;
global $database;
		$database->setQuery( "set names utf8" );
		$database->query();
		$database->setQuery( $query );
		$database->query();

}


/*$result=list_deparrs($fdatas['contract_id']);
$objResponse = new xajaxResponse('UTF-8');
$objResponse->addAssign( 'opt_info', 'innerHTML', "" );
$objResponse->addAssign( 'opt_info', 'innerHTML', $result );
return $objResponse->getXML();
*/ 
//return list_performs($fdatas['contract_id']);
$objResponse = new xajaxResponse('UTF-8');
//$objResponse->addAssign( 'opt_info', 'innerHTML', "" );
$objResponse->addAssign( 'opt_info', 'innerHTML', list_deparrs($fdatas['contract_id']));
return $objResponse->getXML();
}


function list_deparrs($id){
//  session_register('id_artist');
//  $_SESSION['id_artist']= $id_artist;
$result="<br />
<table width='95%' border='0' align='center' cellpadding='0' cellspacing='1' bgcolor='#999999'>
        <tr>
          <td bgcolor='#999999' class='style4'><table width='100%' border='0' align='center' cellpadding='2' cellspacing='1'>
              <tr>
                <td bgcolor='#999999' class='style30'>Date</td>
                <td height='36' bgcolor='#999999' class='style30'>Dep/Arr</td>
                <td bgcolor='#999999' class='style30'>Place</td>
                <td bgcolor='#999999' class='style30'>Time</td>
                <td bgcolor='#999999' class='style30'>Transportation</td>
                <td bgcolor='#999999' class='style30'>Flight/Train №</td>
              </tr>
";

$query="select * from #__itinerary where id_contract=".$id." order by date_of asc";
global $database;
		$database->setQuery( "set names utf8" );
		$database->query();
$database->setQuery( $query);
$perfs = array();
$perfs = $database->loadObjectList();
if (sizeof($perfs)>0){ 	foreach ($perfs as $perf) {
$result.="<tr>
<td bgcolor='#F5F5F5' class='style34'><div align='center' class='style17'>".$perf->date_of."&nbsp;&nbsp;<a href='#' onclick='javascript:add_deparr(".$id.",".$perf->id.");'><img src='images/edit.gif' width='20' height='20' align='absmiddle' border='0'></a>&nbsp;<a href='#' onclick='javascript:clear_dated(".$id.",".$perf->id.");'><img src='images/trash-empty-24x24.png' align='absmiddle' border='0'></a>
</div></td>
<td height='36' bgcolor='#F5F5F5' class='style17'>
              <div align='left'>Departure<br>Arrive</div></td>
              <td bgcolor='#F5F5F5' class='style34'><div align='center'>".$perf->place_dep."<br>".$perf->place_arr."</div></td>
              <td bgcolor='#F5F5F5' class='style34'><div align='center'>".$perf->departure."<br>".$perf->arrival."</div></td>
              <td bgcolor='#F5F5F5' class='style34'><div align='left'>".$perf->transportation."</div></td>
              <td bgcolor='#F5F5F5' class='style34'><div align='left'>".$perf->flighttrainno."</div></td>
          </tr>";
  }
}
$result.="<tr><td height='36' bgcolor='#F5F5F5' class='style17'><div align='left'>P.S.</div></td>
          <td colspan='5' bgcolor='#F5F5F5' class='style34'><div align='left'></div></td></tr>
<tr><td height='36' colspan='6' bgcolor='#FFFFFF' class='style17'><div align='left'>&nbsp;&nbsp;&nbsp;
<a href='#' onclick='javascript:add_deparr(".$id.");'>
<img src='images/comment-add-24x24.png' align='absmiddle' border=0></a>&nbsp;<a href='#' onclick='javascript:add_deparr(".$id.");' class='style17'>Add Dep/Arr</a>&nbsp;&nbsp;&nbsp;
<a href='#' onclick='javascript:clear_dated(".$id.");'><img src='images/trash-empty-24x24.png' align='absmiddle' border='0'></a>&nbsp;
<a href='#' onclick='javascript:clear_dated(".$id.");' class='style17'>Clear dep|arr</a>&nbsp;&nbsp;
<a href='#' onclick='javascript:clear_date(".$id.");'><img src='images/trash-empty-24x24.png' align='absmiddle' border='0'></a>&nbsp;
<a href='#' onclick='javascript:clear_date(".$id.");' class='style17'>Clear all</a></div>
</td></tr></table></td></tr></table><br />";
$result.=list_perform($id,0);
return $result;
}

function clear_perf($id,$pid){
    
global $database;
$q="delete from #__perfomances where contract_id=".$id." and id=".$pid;
$database->setQuery($q);
$database->query();    
$objResponse = new xajaxResponse('UTF-8');
$objResponse->addAssign( 'opt_info', 'innerHTML', list_deparrs($id));
return $objResponse->getXML();
  
}


function list_deparr($id) {

$objResponse = new xajaxResponse('UTF-8');
$objResponse->addAssign( 'opt_info', 'innerHTML', list_deparrs($id) );
return $objResponse->getXML();
}

function clear_dated($id,$pid=0){
global $database;
$add="";if($pid>0) $add=" and id=".$pid;
$database->setQuery( "delete from #__itinerary where id_contract=".$id.$add );
$database->query();
//$objResponse = new xajaxResponse('UTF-8');
//$objResponse->addAssign( 'report_div', 'innerHTML',add_contract2(0,0,$id));
//return $objResponse->getXML();
return add_contract2(0,0,$id);
}

function clear_date($id){
global $database;
$database->setQuery( "delete from #__itinerary where id_contract=".$id );
$database->query();
$database->setQuery( "delete from #__perfomances  where contract_id=".$id  );
$database->query();
//$objResponse = new xajaxResponse('UTF-8');
//$objResponse->addAssign( 'report_div', 'innerHTML',add_contract2(0,0,$id) );
//return $objResponse->getXML();
return add_contract2(0,0,$id);
}


function add_deparr($id,$did=0)
{
global $database;
		$database->setQuery( "set names utf8" );
		$database->query();
$database->setQuery( "select concert_date  from #__contracts where id=".$id);
$date_of=$database->loadResult();
$database->setQuery( "select * from #__itinerary where id=".$did." limit 1");
$dep_arrs = array();
$dep_arrs = $database->loadObjectList();
if(sizeof($dep_arrs)>0)foreach($dep_arrs as $dep_arr){}
$result="<FORM METHOD=POST name='deparr_form' id='deparr_form' ACTION=\"javascript:deparr_save(xajax.getFormValues('deparr_form'));\"><INPUT TYPE='hidden' NAME='main_id' value='";
if (isset ($dep_arr->id)) $result.=$dep_arr->id; else $result.="0";
$result.="'><INPUT TYPE='hidden' NAME='id_contract' value='".$id."'>";
//$result.="<INPUT TYPE='hidden' NAME='date_of' value='".$date_of."'>";
$result.="
<TABLE align='center' valign='middle' width='100%' height='100%' cellpadding=0 cellspacing=0 border=0>
<TR>
	<TD>
<TABLE style='border:15px white solid;background-color: #eeeeee;' align='center' valign='middle' cellpadding=0 cellspacing=0>
<TR>
	<TD >
<TABLE class='h3' style='border:1px gray solid;background-color: #eeeeee;'><TR><td colspan=2 align='right'><button onclick='javascript:hideInfo();'><IMG SRC='/images/del.gif' WIDTH='16' HEIGHT='16' BORDER='0' ALT=''></button></td></TR>
<TR>	<TD valign='top'  class='h1'>";

$result.="<TABLE class='h3'>
<tr><th>Date of</th><th>Dep/Arr</th><th>Place</th><th>Time</th><th>Transportation</th><th>Flight/Train №</th></TR>
<TR></TR>
<TR><TD rowspan='2'><INPUT TYPE='text' NAME='date_of' id='date_of' value='".$dep_arr->date_of."'>&nbsp;&nbsp;
<a href='#' onclick='javascript:cal1xx.select(document.getElementById(\"date_of\"),\"date_ofxx\",\"yyyy-MM-dd\");return false;'  NAME='date_ofxx' ID='date_ofxx'><img src='images/itinerary-24x24.png'  align='absmiddle' border=0></a></TD>
    <TD>Departure</TD><TD><INPUT TYPE='text' NAME='place_dep' id='place_dep' value='";
if (isset($dep_arr->place_dep)) $result.=$dep_arr->place_dep; else $result.="";
$result.="'></TD><TD><INPUT TYPE='text' size='6' NAME='departure' id='departure' value='";
if (isset($dep_arr->departure)) $result.=$dep_arr->departure; else $result.="";
$result.="'></TD><TD rowspan=2 valign='middle'><textarea cols='20' rows='2' NAME='transportation' id='transportation'>";
if (isset($dep_arr->transportation)) $result.=$dep_arr->transportation; else $result.="";
$result.="</textarea></TD><TD rowspan=2 valign='middle'><textarea cols='20' rows='2' NAME='flighttrainno' id='flighttrainno'>";
if (isset($dep_arr->flighttrainno)) $result.=$dep_arr->flighttrainno; else $result.="";
$result.="</textarea></TD></TR><TR><TD>Arrival</TD><TD><INPUT TYPE='text' NAME='place_arr' id='place_arr' value='";
if (isset($dep_arr->place_arr)) $result.=$dep_arr->place_arr; else $result.="";
$result.="'></TD><TD><INPUT TYPE='text' size='6' NAME='arrival' id='arrival' value='";
if (isset($dep_arr->arrival)) $result.=$dep_arr->arrival; else $result.="";

$result.="'></TD></TR></TABLE></TD></TR><tr><td align='center' colspan=2>";
$result.="<input type='submit' value='Save' class='button'></td></tr><tr><td align='center' colspan=2><div  class='style17'>Flights: <a class='style17' href='http://flyaow.com' target='_blank'>http://flyaow.com</a>&nbsp;&nbsp;Trains:&nbsp;<a href='http://fahrplan.oebb.at' target='_blank' class='style17'>http://fahrplan.oebb.at</a></div></td></tr></TABLE>";
$result.="</TD></TR></TABLE></TD></TR></TABLE></TD></TR></TABLE></FORM>";
$objResponse = new xajaxResponse('UTF-8');
$objResponse->addAssign( 'info_div', 'innerHTML', $result );
return $objResponse->getXML();

}


function deparr_save ($deparrdata) {

$objResponse = new xajaxResponse('UTF-8');

global $database;
		$database->setQuery( "set names utf8" );
		$database->query();
foreach ($deparrdata as $key => $fdata) {
	$deparrdata[$key] = addslashes(strip_tags($fdata));
}

if ((isset($deparrdata['main_id']))&&($deparrdata['main_id']>0))
{
$update="
update #__itinerary set
`id_contract`=	'".$deparrdata['id_contract']."',
 `date_of`=	'".$deparrdata['date_of']."',
 `place_dep`=	'".$deparrdata['place_dep']."',
 `place_arr`=	'".$deparrdata['place_arr']."',
 `departure`=	'".$deparrdata['departure']."',
 `arrival`=	'".$deparrdata['arrival']."',
 `transportation`=	'".$deparrdata['transportation']."',
 `flighttrainno`=	'".$deparrdata['flighttrainno']."',
 `status`=	0,
 `lastupdate`=	 CURRENT_TIMESTAMP,
 `whosupdate`=".$_COOKIE['operator_id']." where id=".$deparrdata['main_id'];

}
else {
$update ="
insert into #__itinerary (
`id_contract`, `date_of`, `place_dep`, `place_arr`, `departure`, `arrival`, `transportation`, `flighttrainno`, `status`, `lastupdate`, `whosupdate`)
values
('".$deparrdata['id_contract']."','".$deparrdata['date_of']."','".$deparrdata['place_dep']."','".$deparrdata['place_arr']."','".$deparrdata['departure']."',
'".$deparrdata['arrival']."','".$deparrdata['transportation']."','".$deparrdata['flighttrainno']."',0, CURRENT_TIMESTAMP,".$_COOKIE['operator_id'].")";
}
$database->setQuery( $update );
$database->query();
$objResponse = new xajaxResponse('UTF-8');
$objResponse->addAssign( 'opt_info', 'innerHTML',list_deparrs($deparrdata['id_contract']) );
return $objResponse->getXML();


}

function add_contract($id_promoter=0,$id_artist=0) {

$result="
<FORM METHOD=POST name='add_contract' id='add_contract' ACTION=\"javascript:add_contract2(xajax.getFormValues('add_contract'));\">
<table width='95%' border='0' align='center' cellpadding='0' cellspacing='0'>

      <tr>
        <td width='53%' class='style4'><div align='left'>Contract</div></td>

        <td width='47%' class='style4'>&nbsp;</td>
      </tr>
    </table>
            <br>
            <table width='95%' border='0' align='center' cellpadding='0' cellspacing='1' bgcolor='#999999'>
              <tr>
                <td bgcolor='#999999' class='style4'><table width='100%' border='0' align='center' cellpadding='0' cellspacing='1'>
                  <tr>
                    <td width='122%' height='36' colspan='3' bgcolor='#F5F5F5' align='center'><p class='style5'>Artist&nbsp;";
global $database;
		$database->setQuery( "set names utf8" );
		$database->query();

$alist = array();
$alist[] = mosHTML::makeOption( '0', 'chose ...', 'value', 'text'  );
$database->setQuery( "SELECT id as value, name as text from #__artists  where status =0 ORDER BY name" );
$alist = array_merge($alist,$database->loadObjectList());
if (isset($id_artist)) $agnts=$id_artist; else $agnts=0;
$result.=mosHTML::selectList( $alist, 'id_artist', " id='id_artist' ", 'value', 'text', $agnts );


                    $result.="&nbsp;Promoter&nbsp;";
$alist = array();
$alist[] = mosHTML::makeOption( '0', 'chose ...', 'value', 'text'  );
$database->setQuery( "SELECT id as value, name as text from #__promoters  where status >=0 ORDER BY name" );
$alist = array_merge($alist,$database->loadObjectList());
if (isset($id_promoter)) $agnts=$id_promoter; else $agnts=0;
$result.=mosHTML::selectList( $alist, 'id_promoter', " id='id_promoter' ", 'value', 'text', $agnts );
                    $result.="
                    &nbsp;


                    <input type='button' name='submit_button' value='next >>' onclick='javascript:check_non_empty();' /></p></td>
                  </tr>

                </table></td>
              </tr>
            </table></form>";
$objResponse = new xajaxResponse('UTF-8');
$objResponse->addAssign( 'report_div', 'innerHTML',$result);
return $objResponse->getXML();

}
function add_contract2($formdata, $id_inquiry=0, $id_contract=0)
{
setcookie('prev',stripslashes($_COOKIE['now']) );
setcookie('now',"href='#' onclick='javascript:add_contract2(".$formdata.",".$id_inquiry.",".$id_contract.");' ");


$today  = date("Y-m-d", mktime (0,0,0,date("m")  ,date("d"),date("Y")));  $result="";
global $database,$mosConfig_live_site;
$database->setQuery( "set names utf8" );
$database->query();
$database->setQuery( "SELECT MAX( id )+1 FROM  `#__contracts` WHERE 1 " );
$mid=$database->loadResult();
$has_perf=0;

$result="";
if ($id_contract>0) {
$database->setQuery( "SELECT * FROM #__contracts  where id=".$id_contract );
$cs =$database->loadObjectList();
foreach ($cs as $c){}
$database->setQuery( 'select count(*) from #__perfomances where contract_id='.$id_contract );
$has_perf = $database->loadResult();
}

if ($id_contract==0) {
   //    $result="inq=".$id_inquiry."<br />";
     if ( $id_inquiry>0) {

    $database->setQuery( "SELECT * FROM #__inquiries  where id=".$id_inquiry );
   $ii =$database->loadObjectList();
     foreach ($ii as $i){}

     }
        foreach ($formdata as $key => $fdata) {
	$formdata[$key] = addslashes(strip_tags($fdata));
            }
}

if ($id_contract==0) $database->setQuery( "SELECT * from #__artists  where id=".$formdata['id_artist'] );
else $database->setQuery( "SELECT * from #__artists  where id=".$c->id_artist );
$alists =$database->loadObjectList();

if ($id_contract==0) $database->setQuery( "SELECT * from #__promoters  where id=".$formdata['id_promoter'] );
else $database->setQuery( "SELECT * from #__promoters  where id=".$c->id_promoter );
if (isset($formdata['venue_date'])) $v=explode(" ", $formdata['venue_date']);$venue_date=$v[0];
$plists =$database->loadObjectList();
$result.=" <div>&nbsp;&nbsp;&nbsp;&nbsp;<a ".stripslashes($_COOKIE['now'])."><img src='images/back-24x24.png' align='absmiddle' border=0></a>&nbsp;<a ".stripslashes($_COOKIE['now'])." class='style17'>Back</a></div>
<form name='add_cont2' id='add_cont2' method='POST' onsubmit='javascript:prepare_dates();check_this_form(this);' ACTION=\"javascript:";
if($has_perf)$result.="add_contract4"; else $result.="add_contract3";
$result.="(xajax.getFormValues('add_cont2'));\"  >
<input type='hidden' name='id' id='id' value='".$id_contract."' />
<input type='hidden' name='moredates' id='moredates'>
<table width='95%' border='0' align='center' cellpadding='0' cellspacing='1' bgcolor='#999999'>
              <tr>
                <td bgcolor='#999999' class='style4'>
                <table width='100%' border='0' align='center' cellpadding='3' cellspacing='1'>
                    <tr>
                      <td width='20%' height='36' bgcolor='#FFFFFF' class='style17'><div align='left'>Contract date</div></td>
                      <td bgcolor='#FFFFFF' class='style17'><div align='left' class='style34'>
                      <input name='contract_date' id='contract_date' type='text' size='12' maxlength='20' readonly required value='";
                      if (isset($c->contract_date)) $result.=$c->contract_date;else $result.=$today;
                      $result.="'/>&nbsp;
                      <!--<a href='#' onclick='javascript:cal1xx.select(document.getElementById(\"contract_date\"),\"contract_datexx\",\"yyyy-MM-dd\");return false;'  NAME='contract_datexx' ID='contract_datexx'><img src='images/itinerary-24x24.png'  align='absmiddle' border=0></a>--></div></td>
                      <td width='18%' height='36' bgcolor='#FFFFFF' class='style17'><div align='left'>
                          Promoter
                      </div></td>
                      <td bgcolor='#FFFFFF' class='style17'><div align='left' class='style34'>
                      <input type='hidden' name='id_promoter' id='id_promoter' value='";
                       if (isset($c->id_promoter)) $result.=$c->id_promoter;else $result.=$formdata['id_promoter'];
                      $result.="' />
                      <input name='promoter' id='promoter'  readonly='readonly' size='30' value='";
                       if (isset($c->promoter)) $result.=$c->promoter;else foreach ($plists as $plist){$result.=$plist->name; }
                      $result.="' /></div>
                      </td>

                    </tr>

                    <tr>
                      <td width='20%' height='36' bgcolor='#FFFFFF' class='style17'><div align='left'>Contract №</div></td>
                      <td width='29%' bgcolor='#FFFFFF' class='style17'><div align='left' class='style34'><input name='contract_no' required id='contract_no'  type='text' size='10' maxlength='20'";
                      if (isset($c->contract_no)) $result.=" value='".$c->contract_no."' ";  else $result.=" value='".$mid."/".date("Y")."' ";
                      $result.=" /></div></td>
                       <td width='18%' height='36' bgcolor='#FFFFFF' class='style17'><div align='left'>
                      Contact person
                      </div></td>
                      <td bgcolor='#FFFFFF' class='style17'><div align='left' class='style34'>
                      <input name='contact_person' id='contact_person' value='";
                        if (isset($c->contact_person)) $result.=$c->contact_person;else $result.=$plist->contact_person;
                      $result.="' size=30 /></div></td>
                    </tr>
                    <tr>
                      <td bgcolor='#FFFFFF' class='style17'><div align='left'>
                          Artist
                      </div></td>
                      <td bgcolor='#FFFFFF' class='style17'><div align='left' class='style34'>
                      <input type='hidden' name='id_artist' id='id_artist' value='";
                       if (isset($c->id_artist)) $result.=$c->id_artist;else $result.=$formdata['id_artist'];
                      $result.="' />
                      <input name='artist' id='artist'  readonly size='30' value='";
                       if (isset($c->promoter)) $result.=$c->artist;else  foreach ($alists as $alist){$result.=$alist->name; }
                      $result.="' /></div></td>
                      <td width='18%' height='36' bgcolor='#FFFFFF' class='style17'><div align='left'>
                      Town
                      </div></td>
                      <td bgcolor='#FFFFFF' class='style17'><div align='left' class='style34'>
                      <input name='town' id='town' value='";
                        if (isset($c->town)) $result.=$c->town; else $result.=$plist->town;
                      $result.="' size=30 /></div></td>
                    </tr>
                    <tr>
                      <td bgcolor='#FFFFFF' class='style17'><div align='left'>
                          Concert date
                      </div></td>
                      <td bgcolor='#FFFFFF' class='style17'><div align='left' class='style34'>
                      <input name='concert_date' id='concert_date' type='text' size='20' maxlength='20'  required='1'  value='";
                      if ($id_contract==0) $rr=get_inq_dated($i->id); else $rr=get_cont_dated($id_contract);
                      if($venue_date>0){$result.=$venue_date;} else {if (isset($c->concert_date)) $result.=$c->concert_date;}
                      $result.="' />";
                    $result.="&nbsp;<a href='#' onclick='javascript:cal2xx.select(document.getElementById(\"concert_date\"),\"concert_datexx\",\"yyyy-MM-dd\");return false;'  NAME='concert_datexx' ID='concert_datexx'><img src='images/itinerary-24x24.png'  align='absmiddle' border=0></a>";
                    $result.="&nbsp;<a href='#' onclick='javascript:add_date();'><img src='images/add.gif' align='absmiddle' border=0 /></a><br/><div id='date_container'>".$rr."</div>";
                    $result.="</div><div id='date_container'></div></td>
                      <td height='36' bgcolor='#FFFFFF' class='style17' ><div align='left'>
                          Address
                      </div></td>
                      <td bgcolor='#FFFFFF' class='style17'><div align='left' class='style34'>
                        <input name='address' id='address' value='";
                     if (isset($c->address)) $result.=$c->address; else {$result.=$plist->street_addr1."&nbsp;".$plist->street_addr2;}
                      $result.="' size=30 /></div></td>
                    </tr>
                    <tr>
                      <td bgcolor='#FFFFFF' class='style17'><div align='left'>
                          Venue
                      </div></td>
                      <td bgcolor='#FFFFFF' class='style17'><div align='left' class='style34'>
                      <input name='venue' id='venue'  size='30' required value='";
                     if (isset($c->venue)) $result.=$c->venue;
                      $result.="'>
                      </div></td>
                      <td height='36' bgcolor='#FFFFFF' class='style17'><div align='left'>
                          Local phone
                      </div></td>
                      <td bgcolor='#FFFFFF' class='style17'><div align='left' class='style34'><input name='phone1' id='phone1' value='";
                     if (isset($c->phone1)) $result.=$c->phone1; else {$result.=$plist->phone1;}
                      $result.="' size=30 /></div></td>
                    </tr>

                    <tr>
                      <td height='36' bgcolor='#FFFFFF' class='style17'><div align='left'>
                          Capacity
                      </div></td>
                      <td bgcolor='#FFFFFF' class='style17'><div align='left' class='style34'>
                      <input name='capacity' id='capacity' value='";
                       if (isset($c->capacity)) $result.=$c->capacity;
                      $result.="' size='30'>
                      </div></td>
                      <td height='36' bgcolor='#FFFFFF' class='style17'><div align='left'>
                          Cell phone
                      </div></td>
                      <td bgcolor='#FFFFFF' class='style17'><div align='left' class='style34'> <input name='phone2' id='phone2' value='";
                      if (isset($c->phone2)) $result.=$c->phone2; else {$result.=$plist->phone2;}
                      $result.="' size=30 /></div></td>
                    </tr>
                    <tr>
                      <td height='36' bgcolor='#FFFFFF' class='style17'><div align='left'>
                          Art of performance
                      </div></td>
                      <td bgcolor='#FFFFFF' class='style17'><div align='left' class='style34'>
                      <input name='art_of_perf' id='art_of_perf' value='";
                       if (isset($c->art_of_perf)) $result.=$c->art_of_perf;
                      $result.="' size='30'>
                      </div></td>

                      <td height='36' bgcolor='#FFFFFF' class='style17'><div align='left'>
                          Email
                      </div></td>
                      <td bgcolor='#FFFFFF' class='style17'><div align='left' class='style34'>
                      <input name='email' id='email' value='";
                      if (isset($c->email)) $result.=$c->email; else {$result.=$plist->email;}
                      $result.="' size='30'>
                     </div></td>
                    </tr>
               </table></td>
              </tr>
            </table>";


$result.="
            <table width='95%' border='0' align='center' cellpadding='0' cellspacing='0'>
              <tr>
                <td width='53%' class='style4'><div align='left' class='style5'>Performance:</div></td>
                <td width='47%' class='style4'>&nbsp;</td>
              </tr>
            </table>
            <table width='95%' border='0' align='center' cellpadding='0' cellspacing='1' bgcolor='#999999'>

              <tr>
                <td bgcolor='#999999' class='style4'><table width='100%' border='0' align='center' cellpadding='3' cellspacing='1'>
                     <tr>
                      <td bgcolor='#FFFFFF' class='style17'><div align='left'>
                          Press conf.
                      </div></td>
                      <td bgcolor='#FFFFFF' class='style17'>
                      <div align='left' class='style34'>
                      <input name='presconf' id='presconf' value='";
                      if (isset($c->presconf)) $result.=$c->presconf;
                      $result.="' size='30'></div></td>
                       <td width='18%' height='36' bgcolor='#FFFFFF' class='style17'><div align='left'>
                          Dinner time</div></td>
                      <td bgcolor='#FFFFFF' class='style17'><div align='left' class='style34'>
                      <input name='dinner' id='dinner' value='";
                      if (isset($c->dinner)) $result.=$c->dinner;
                      $result.="' size='30'></div></td>
                    </tr>
                <tr>
                      <td width='20%' height='36' bgcolor='#FFFFFF' class='style17'><div align='left'>Get in time</div></td>
                      <td width='29%' bgcolor='#FFFFFF' class='style17'><div align='left' class='style34'>
                      <input name='acc_to_stage' id='acc_to_stage' value='";
                      if (isset($c->acc_to_stage)) $result.=$c->acc_to_stage;
                      $result.="' size='30'></div></td>
                      <td width='18%' height='36' bgcolor='#FFFFFF' class='style17'><div align='left'>
                          Sound check

                      </div></td>
                      <td bgcolor='#FFFFFF' class='style17'><div align='left' class='style34'>
                      <input name='soundcheck' id='soundcheck' value='";
                      if (isset($c->sound_check)) $result.=$c->sound_check;
                      $result.="' size='30'></div></td>
                    </tr>
                    <tr>
                      <td bgcolor='#FFFFFF' class='style17'><div align='left'>
                          Doors open
                      </div></td>
                      <td bgcolor='#FFFFFF' class='style17'><div align='left' class='style34'>
                      <input name='doorsopen' id='doorsopen' value='";
                      if (isset($c->doors_open)) $result.=$c->doors_open;
                      $result.="' size='30'>
                      </div></td>

                      <td width='18%' height='36' bgcolor='#FFFFFF' class='style17'><div align='left'>
                          Concert start
                      </div></td>
                      <td bgcolor='#FFFFFF' class='style17'><div align='left' class='style34'>
                      <input name='concert_start' id='concert_start' value='";
                      if (isset($c->concert_start)) $result.=$c->concert_start;
                      $result.="' size='30'></div></td>
                    </tr>
                    <tr>
                      <td bgcolor='#FFFFFF' class='style17'><div align='left'>
                          Perform. duration
                      </div></td>
                      <td bgcolor='#FFFFFF' class='style17'><div align='left' class='style34'>
                      <input name='perf_duration' id='perf_duration' value='";
                      if (isset($c->lenght_of)) $result.=$c->lenght_of;
                      $result.="' size='30'></div></td>
                      <td height='36' bgcolor='#FFFFFF' class='style17'><div align='left'>
                          Publicity
                      </div></td>
                      <td bgcolor='#FFFFFF' class='style17'><div align='left' class='style34'>
                      <input name='publicity' id='publicity' value='";
                      if (isset($c->publicity)) $result.=$c->publicity;
                      $result.="' size='30'></div></td>
                    </tr>

                </table></td>
              </tr>
            </table>
            <table width='95%' border='0' align='center' cellpadding='0' cellspacing='0'>
              <tr>
                <td width='53%' class='style4'><div align='left' class='style5'>The promoter have to pay for  the following:</div></td>
                <td width='47%' class='style4'>&nbsp;</td>
              </tr>

            </table>
            <table width='95%' border='0' align='center' cellpadding='0' cellspacing='1' bgcolor='#999999'>
              <tr>
                <td bgcolor='#999999' class='style4'><table width='100%' border='0' align='center' cellpadding='3' cellspacing='1'>
                    <tr>
                      <td width='20%' height='36' bgcolor='#FFFFFF' class='style17'><div align='left'>Artist fee</div></td>
                      <td width='29%' bgcolor='#FFFFFF' class='style17'><div align='left' class='style34'>
                      <input name='artist_fee' id='artist_fee' required  value='";
                      if (isset($c->artist_fee)) $result.=intval($c->artist_fee);  else $result.="";
                    //  if (isset($i->artist_fee)) $result.=intval($i->artist_fee);  else $result.="0";

                      $result.="' size='30' onblur='javascript:calculate_fee();'>
                      </div></td>
                      <td width='18%' height='36' bgcolor='#FFFFFF' class='style17'><div align='left'>
                          Administration expenses
                      </div></td>
                      <td bgcolor='#FFFFFF' class='style17'><div align='left' class='style34'>
                      <input name='admin_exp' id='admin_exp' required  value='";
                      if (isset($c->admin_exp)) $result.=intval($c->admin_exp);  else $result.="";
                    //  if (isset($i->admin_exp)) $result.=(int)$i->admin_exp;  else $result.="0";
                      $result.="' size='30'  onblur='javascript:calculate_fee();' >
                      </div></td>
                    </tr>
                    <tr>
                      <td bgcolor='#FFFFFF' class='style17'><div align='left'>
                          Productions expenses
                      </div></td>
                      <td bgcolor='#FFFFFF' class='style17'><div align='left' class='style34'>
                      <input name='production_exp' id='production_exp' required  value='";
                      if (isset($c->production_exp)) $result.=intval($c->production_exp); else $result.="";
                      //if (isset($i->production_exp)) $result.=(int)$i->production_exp; else $result.="0";
                      $result.="' size='30'  onblur='javascript:calculate_fee();'>
                      </div></td>
                      <td width='18%' height='36' bgcolor='#FFFFFF' class='style17'><div align='left'>
                          Other expenses
                      </div></td>
                      <td bgcolor='#FFFFFF' class='style17'><div align='left' class='style34'>
                       <input name='other_exp' id='other_exp' required  value='";
                      if (isset($c->other_exp)) $result.=intval($c->other_exp); else $result.="";
                      //if (isset($i->other_exp)) $result.=(int)$i->other_exp; else $result.="0";
                      $result.="' size='30'  onblur='javascript:calculate_fee();'>
                      </div></td>
                    </tr>

                    <tr>
                      <td bgcolor='#FFFFFF' class='style17'><div align='left'>
                          Travelling expenses
                      </div></td>
                      <td bgcolor='#FFFFFF' class='style17'><div align='left' class='style34'>
                      <input name='travel_exp' id='travel_exp' required value='";
                      if (isset($c->travel_exp)) $result.=intval($c->travel_exp);  else $result.="";
                    //  if (isset($i->travel_exp)) $result.=(int)$i->travel_exp;  else $result.="0";
                      $result.="' size='30'  onblur='javascript:calculate_fee();'></div></td>
                      <td height='36' bgcolor='#FFFFFF' class='style17'><div align='left'>
                       Total expenses
                      </div></td>
                      <td bgcolor='#FFFFFF' class='style17'><div align='left' class='style34'>
                      <input name='total_exp' id='total_exp' required value='";
                      if (isset($c->total_exp)) $result.=intval($c->total_exp);  else $result.="0";
                     // if (isset($i->total_exp)) $result.=$i->total_exp;  else $result.="0";
                      $result.="' size='30' >
                      </div></td>
                    </tr><tr>
                      <td bgcolor='#FFFFFF' class='style17' colspan=2></td>
                      <td height='36' bgcolor='#FFFFFF' class='style17'><div align='left'>
                       Currency abbr.
                      </div></td>
                      <td bgcolor='#FFFFFF' class='style17'><div align='left' class='style34'>
                      <input name='currency' id='currency' required value='";
                      if (isset($c->currency)) $result.=$c->currency;  else $result.="";
                    //  if (isset($i->currency)) $result.=$i->currency;  else $result.="";
                      $result.="' size='30' >
                      </div></td>
                    </tr>
                    <tr>

                      <td  height='36' bgcolor='#FFFFFF' class='style17'  colspan='2'><div align='left'>The  artist fee have to pay as follows</div></td>
                      <td  bgcolor='#FFFFFF' class='style17'  colspan='2'><div align='left' class='style34'>
                      <input name='pay_follows' id='pay_follows' value='";
                      if (isset($c->pay_follows)) $result.=$c->pay_follows;
                      $result.="' size='30'>
                     </div></td>
                    </tr>
                <!--    <tr>
                      <td height='36' bgcolor='#FFFFFF' class='style17'  colspan='2'><div align='left'>
                          Bank  account info
                      </div></td>

                      <td bgcolor='#FFFFFF' class='style17' colspan='2'><div align='left' class='style34'>
                      <input name='acc_info' id='acc_info' value='";
                      if (isset($c->acc_info)) $result.=$c->acc_info;
                      $result.="' size='30'>
                      </div></td>
                    </tr>-->
                    <tr>
                      <td height='36' bgcolor='#FFFFFF' class='style17'  colspan='2'><div align='left'>
                          Other  expenses that have to be payed by the promoter
                      </div></td>
                      <td bgcolor='#FFFFFF' class='style17' colspan='2'><div align='left' class='style34'>
                      <input name='exp_prom_other' id='exp_prom_other' value='";
                      if (isset($c->exp_prom_other)) $result.=$c->exp_prom_other;
                      $result.="' size='30'>
                      </div></td>
                    </tr>
                </table></td>
              </tr>
            </table>";
$result.="<table width='95%' border='0' align='center' cellpadding='0' cellspacing='0'>
              <tr>
                <td width='53%' class='style4' colspan=2><div align='left' class='style5'>Sound company:&nbsp;";

 $result.="</td>

              </tr>
            </table>
            <table width='95%' border='0' align='center' cellpadding='0' cellspacing='1' bgcolor='#999999'>
              <tr>
                <td bgcolor='#999999' class='style4'>
                <div id='sound_info' name='sound_info'>
                <table width='100%' border='0' align='center' cellpadding='3' cellspacing='1'>
                    <tr>
                      <td width='20%' height='36' bgcolor='#FFFFFF' class='style17'><div align='left'>Sound company</div></td>

                      <td width='29%' bgcolor='#FFFFFF' class='style17'><div align='left' class='style34'>
                      <input name='sound_name' id='sound_name' value='";
                      if (isset($c->sound_name)) $result.=$c->sound_name;
                      $result.="' size='30'>
                      </div></td>
                      <td width='18%' height='36' bgcolor='#FFFFFF' class='style17'><div align='left'>
                      Cell phone</div></td>
                      <td bgcolor='#FFFFFF' class='style17'><div align='left' class='style34'>
                      <input name='sound_phone2' id='sound_phone2' value='";
                      if (isset($c->sound_phone2)) $result.=$c->sound_phone2;
                      $result.="' size='30'>
                       </div></td>
                    </tr>
                    <tr>
                      <td bgcolor='#FFFFFF' class='style17'><div align='left'>
                      Contact person</div></td>
                      <td bgcolor='#FFFFFF' class='style17'><div align='left' class='style34'>
                      <input name='sound_contact' id='sound_contact' value='";
                      if (isset($c->sound_contact)) $result.=$c->sound_contact;
                      $result.="' size='30'>
                      </div></td>
                      <td width='18%' height='36' bgcolor='#FFFFFF' class='style17'><div align='left'>
                          Email
                      </div></td>
                      <td bgcolor='#FFFFFF' class='style17'><div align='left' class='style34'>
                      <input name='sound_email' id='sound_email' value='";
                      if (isset($c->sound_email)) $result.=$c->sound_email;
                      $result.="' size='30'></div></td>

                    </tr>
                    <tr>
                      <td bgcolor='#FFFFFF' class='style17'><div align='left'>
                          Phone
                      </div></td>
                      <td bgcolor='#FFFFFF' class='style17'><div align='left' class='style34'>
                      <input name='sound_phone1' id='sound_phone1' value='";
                      if (isset($c->sound_phone1)) $result.=$c->sound_phone1;
                      $result.="' size='30'>
                     </div></td>
                      <td height='36' bgcolor='#FFFFFF' class='style17'>&nbsp;</td>
                      <td bgcolor='#FFFFFF' class='style17'>&nbsp;</td>
                  </tr>
                </table>

";


               $result.=" </div>
                </td>
              </tr>
            </table>
      <table width='95%' border='0' align='center' cellpadding='0' cellspacing='1' bgcolor='#999999'>
              <tr>
                <td bgcolor='#999999' class='style4'><table width='100%' border='0' align='center' cellpadding='3' cellspacing='1'>
                    <tr>
                      <td width='92%' height='36' bgcolor='#FFFFFF' class='style17'>
                      <div align='left'>One signed copy should be returned in (days)</div></td>
                      <td width='8%' bgcolor='#FFFFFF' class='style17' align='center' valign='middle'>
                          <input  name='issue_date' id='issue_date'  size='10' value='";
                      if (isset($c->issue_date)) $result.=$c->issue_date; else $result.='3';
                      $result.="'>
                    </td>
                  </tr>
                </table></td>
              </tr>
            </table>
            <br>
            <table width='95%' border='0' align='center' cellpadding='0' cellspacing='1' bgcolor='#999999'>
              <tr>
                <td bgcolor='#999999' class='style4'><table width='100%' border='0' align='center' cellpadding='3' cellspacing='1'>

                    <tr>
                      <td height='36' bgcolor='#FFFFFF'>
                       <div align='left' id='savebt'>  &nbsp;&nbsp;&nbsp;
                      <input type='submit' value='Save'  class='style17' align='absmiddle' style='padding:0 0 0 30px; border:0; background-image:url(images/save-accept-24x24.png);background-repeat:no-repeat;background-color:white;text-decoration:underline;cursor:hand;'>
                      &nbsp;&nbsp;&nbsp;&nbsp;
                      &nbsp;<a href='".$mosConfig_live_site."/modules/contract.php?lang=no&id=".$id_contract."' title='Print contract' target='_blank'><img src='images/printbutton.png' border=0 align='absmiddle'  width='24' height='24'></a>
                      &nbsp;<a href='".$mosConfig_live_site."/modules/contract.php?lang=no&id=".$id_contract."' title='Print contract' target='_blank'  class='style17'>Print</a>&nbsp;&nbsp;&nbsp;&nbsp;
                      <a href='".$mosConfig_live_site."/modules/contract.php?lang=en&id=".$id_contract."' title='Print english version' target='_blank'><img src='images/printbutton.png' width='24' height='24' border=0 align='absmiddle'></a>&nbsp;<a href='".$mosConfig_live_site."/modules/contract.php?lang=en&id=".$id_contract."' title='Print english version' target='_blank'  class='style17'>Print EN</a>
                      &nbsp;&nbsp;



                      &nbsp;<a href='".$mosConfig_live_site."/modules/invoice.php?lang=no&id=".$id_contract."' title='Print contract' target='_blank'><img src='images/printbutton.png' border=0 align='absmiddle'  width='24' height='24'></a>
                      &nbsp;<a href='".$mosConfig_live_site."/modules/invoice.php?lang=no&id=".$id_contract."' title='Print contract' target='_blank'  class='style17'>Invoice</a>&nbsp;&nbsp;&nbsp;&nbsp;

                      <a href='".$mosConfig_live_site."/modules/invoice.php?lang=en&id=".$id_contract."' title='Get english version' target='_blank'  class='style17'><img src='images/printbutton.png' width='24' height='24' border=0 align='absmiddle'></a>&nbsp;<a href='".$mosConfig_live_site."/modules/invoice.php?lang=en&id=".$id_contract."' title='Get english version' target='_blank'  class='style17'>Invoice ENG</a>
                      &nbsp;&nbsp;

                        <a href='#' onclick='javascript:message_form_contract(0,2,".$c->id_promoter.",0,".$id_contract.");'><img src='images/forward-new-mail-24x24.png' border=0 align='absmiddle'></a>&nbsp; <a href='#' onclick='javascript:message_form_contract(0,2,".$c->id_promoter.",0,".$id_contract.");'  class='style17'>
                      Send via email [EN]</a>&nbsp;&nbsp;

                      <a href='#' onclick='javascript:message_form_contract(0,2,".$c->id_promoter.",1,".$id_contract.");'><img src='images/forward-new-mail-24x24.png' border=0 align='absmiddle'></a>&nbsp;<a href='#' onclick='javascript:message_form_contract(0,2,".$c->id_promoter.",1,".$id_contract.");'  class='style17' >Send via email [NO]</a>
                      &nbsp;&nbsp;&nbsp;<a href='".$mosConfig_live_site."/modules/itn.php?id=".$id_contract."' title='Print itinerary' target='_blank'><img src='images/printbutton.png' border=0 align='absmiddle'  width='24' height='24'></a>
                      &nbsp;<a href='".$mosConfig_live_site."/modules/itn.php?id=".$id_contract."' title='Print itinerary' target='_blank'  class='style17'>Print itinerary(1)</a>
                      &nbsp;&nbsp;&nbsp;<a href='".$mosConfig_live_site."/modules/itn2.php?id=".$id_contract."' title='Print itinerary' target='_blank'><img src='images/printbutton.png' border=0 align='absmiddle'  width='24' height='24'></a>
                      &nbsp;<a href='".$mosConfig_live_site."/modules/itn2.php?id=".$id_contract."' title='Print itinerary' target='_blank'  class='style17'>Print itinerary(all)</a>
                      </div></td>
                    </tr>
                </table></td>
              </tr>
            </table>
</form>
<div id='itn' name='itn'>&nbsp;&nbsp;&nbsp;&nbsp;<a ".stripslashes($_COOKIE['now']).">
<img src='images/back-24x24.png' align='absmiddle' border=0></a>&nbsp;<a ".stripslashes($_COOKIE['now'])." class='style17'>Back</a>
</div><br>
<div id='opt_info' name='opt_info'>";


if ($id_contract>0) {
if (!$has_perf) $result.="<div style='margin-left:45px;'><a href='#' onclick=\"javascript:addPerfForms(".$c->id.");\"><img src='images/note-edit-24x24.png' border='0'></a>&nbsp;&nbsp;<a href='#' onclick=\"javascript:addPerfForms(".$c->id.");\"><span class='style17'>THIS CONTRACT HASN'T ITINERARY. CLICK HERE TO&nbsp;FILL IT</span></a></div>";
else $result.=list_deparrs ($id_contract);
}
$result.="&nbsp;</div><div id='perf_info' name='perf_info' style='display:none;'>&nbsp;</div>";

$objResponse = new xajaxResponse('UTF-8');
//$objResponse->addAssign( 'report_div', 'innerHTML',"");
$objResponse->addAssign( 'report_div', 'innerHTML', $result);
return $objResponse->getXML();
}
function _add_contract2($formdata, $id_inquiry=0, $id_contract=0)
{
setcookie('prev',stripslashes($_COOKIE['now']) );
setcookie('now',"href='#' onclick='javascript:add_contract2(".$formdata.",".$id_inquiry.",".$id_contract.");' ");


$today  = date("Y-m-d", mktime (0,0,0,date("m")  ,date("d"),date("Y")));  $result="";
global $database,$mosConfig_live_site,$mosConfig_absolute_path;
$database->setQuery( "set names utf8" );
$database->query();
$database->setQuery( "SELECT MAX( id )+1 FROM  `#__contracts` WHERE 1 " );
$mid=$database->loadResult();
$has_perf=0;

$result="test";
if ($id_contract>0) {
$database->setQuery( "SELECT * FROM #__contracts  where id=".$id_contract );
$cs =$database->loadObjectList();
foreach ($cs as $c){}
$database->setQuery( 'select count(*) from #__perfomances where contract_id='.$id_contract );
$has_perf = $database->loadResult();
}

if ($id_contract==0) {
   //    $result="inq=".$id_inquiry."<br />";
     if ( $id_inquiry>0) {

    $database->setQuery( "SELECT * FROM #__inquiries  where id=".$id_inquiry );
   $ii =$database->loadObjectList();
     foreach ($ii as $i){}

     }
        foreach ($formdata as $key => $fdata) {
	$formdata[$key] = addslashes(strip_tags($fdata));
            }
}

if ($id_contract==0) $database->setQuery( "SELECT * from #__artists  where id=".$formdata['id_artist'] );
else $database->setQuery( "SELECT * from #__artists  where id=".$c->id_artist );
$alists =$database->loadObjectList();

if ($id_contract==0) $database->setQuery( "SELECT * from #__promoters  where id=".$formdata['id_promoter'] );
else $database->setQuery( "SELECT * from #__promoters  where id=".$c->id_promoter );
if (isset($formdata['venue_date'])) $v=explode(" ", $formdata['venue_date']);$venue_date=$v[0];
$plists =$database->loadObjectList();




    $ft = new FastTemplate($mosConfig_absolute_path."/templates");
    $ft->define(array('body'  => "contract_edit.tpl"));
    $ft->assign( array(
                    'ID' => $agent->id,
                    'COMPANY' => $agent->name,
                    'CITYCODE' => $agent->city_code  ,
                    'CONTACTPERSON' => $agent->contact_person  ,
                    'TOWN' => $agent->town  ,
                    'ADDR1' => $agent->street_addr1  ,
                    'COUNTRY' => $country,
                    'ADDR2' => $agent->street_addr2  ,
                    'PHONE1' => $agent->phone1  ,
                    'EMAIL' => $agent->email  ,
                    'PHONE2' => $agent->phone2  ,
                    'WWW' => $agent->website  ,
                    'COMMENTS' => $COMMENT,

                    'LINK' => stripslashes ($_COOKIE['now'])
                    ));
    $ft->parse('BODY', "body");
    $result=$ft->FastPrint("BODY",true);


/*
$result.=" <div>&nbsp;&nbsp;&nbsp;&nbsp;<a ".stripslashes($_COOKIE['now'])."><img src='images/back-24x24.png' align='absmiddle' border=0></a>&nbsp;<a ".stripslashes($_COOKIE['now'])." class='style17'>Back</a></div>
<form name='add_contract2' id='add_contract2' method='POST' onsubmit='return check_this_form(this);' ACTION=\"javascript:";
if($has_perf)$result.="add_contract4"; else $result.="add_contract3";
$result.="(xajax.getFormValues('add_contract2'));\"  >
<input type='hidden' name='id' id='id' value='".$id_contract."' />
<table width='95%' border='0' align='center' cellpadding='0' cellspacing='1' bgcolor='#999999'>
              <tr>
                <td bgcolor='#999999' class='style4'>
                <table width='100%' border='0' align='center' cellpadding='3' cellspacing='1'>
                    <tr>
                      <td width='20%' height='36' bgcolor='#FFFFFF' class='style17'><div align='left'>Contract date</div></td>
                      <td bgcolor='#FFFFFF' class='style17'><div align='left' class='style34'>
                      <input name='contract_date' id='contract_date' type='text' size='12' maxlength='20' required value='";
                      if (isset($c->contract_date)) $result.=$c->contract_date;else $result.=$today;
                      $result.="'/>&nbsp;
                      <a href='#' onclick='javascript:cal1xx.select(document.getElementById(\"contract_date\"),\"contract_datexx\",\"yyyy-MM-dd\");return false;'  NAME='contract_datexx' ID='contract_datexx'><img src='images/itinerary-24x24.png'  align='absmiddle' border=0></a></div></td>
                      <td width='18%' height='36' bgcolor='#FFFFFF' class='style17'><div align='left'>
                          Promoter 
                      </div></td>
                      <td bgcolor='#FFFFFF' class='style17'><div align='left' class='style34'>
                      <input type='hidden' name='id_promoter' id='id_promoter' value='";
                       if (isset($c->id_promoter)) $result.=$c->id_promoter;else $result.=$formdata['id_promoter'];
                      $result.="' />
                      <input name='promoter' id='promoter'  readonly='readonly' size='30' value='";
                       if (isset($c->promoter)) $result.=$c->promoter;else foreach ($plists as $plist){$result.=$plist->name; }
                      $result.="' /></div>
                      </td>

                    </tr>

                    <tr>
                      <td width='20%' height='36' bgcolor='#FFFFFF' class='style17'><div align='left'>Contract №</div></td>
                      <td width='29%' bgcolor='#FFFFFF' class='style17'><div align='left' class='style34'><input name='contract_no' required id='contract_no'  type='text' size='10' maxlength='20'";
                      if (isset($c->contract_no)) $result.=" value='".$c->contract_no."' ";  else $result.=" value='".$mid."/".date("Y")."' ";
                      $result.=" /></div></td>
                       <td width='18%' height='36' bgcolor='#FFFFFF' class='style17'><div align='left'>
                      Contact person
                      </div></td>
                      <td bgcolor='#FFFFFF' class='style17'><div align='left' class='style34'>
                      <input name='contact_person' id='contact_person' value='";
                        if (isset($c->contact_person)) $result.=$c->contact_person;else $result.=$plist->contact_person;
                      $result.="' size=30 /></div></td>
                    </tr>
                    <tr>
                      <td bgcolor='#FFFFFF' class='style17'><div align='left'>
                          Artist
                      </div></td>
                      <td bgcolor='#FFFFFF' class='style17'><div align='left' class='style34'>
                      <input type='hidden' name='id_artist' id='id_artist' value='";
                       if (isset($c->id_artist)) $result.=$c->id_artist;else $result.=$formdata['id_artist'];
                      $result.="' />
                      <input name='artist' id='artist'  readonly size='30' value='";
                       if (isset($c->promoter)) $result.=$c->artist;else  foreach ($alists as $alist){$result.=$alist->name; }
                      $result.="' /></div></td>
                      <td width='18%' height='36' bgcolor='#FFFFFF' class='style17'><div align='left'>
                      Town
                      </div></td>
                      <td bgcolor='#FFFFFF' class='style17'><div align='left' class='style34'>
                      <input name='town' id='town' value='";
                        if (isset($c->town)) $result.=$c->town; else $result.=$plist->town;
                      $result.="' size=30 /></div></td>
                    </tr>
                    <tr>
                      <td bgcolor='#FFFFFF' class='style17'><div align='left'>
                          Concert date 
                      </div></td>
                      <td bgcolor='#FFFFFF' class='style17'><div align='left' class='style34'>
                      <input name='concert_date' id='concert_date' type='text' size='12' maxlength='20'  required='1'  value='";
                      if (isset($c->concert_date)) $result.=$c->concert_date;
                      $result.="' />";
                    $result.="&nbsp;<a href='#' onclick='javascript:cal2xx.select(document.getElementById(\"concert_date\"),\"concert_datexx\",\"yyyy-MM-dd\");return false;'  NAME='concert_datexx' ID='concert_datexx'><img src='images/itinerary-24x24.png'  align='absmiddle' border=0></a>";

                    $result.="</div></td>
                      <td height='36' bgcolor='#FFFFFF' class='style17' ><div align='left'>
                          Address 
                      </div></td>
                      <td bgcolor='#FFFFFF' class='style17'><div align='left' class='style34'>
                        <input name='address' id='address' value='";
                     if (isset($c->address)) $result.=$c->address; else {$result.=$plist->street_addr1."&nbsp;".$plist->street_addr2;}
                      $result.="' size=30 /></div></td>
                    </tr>
                    <tr>
                      <td bgcolor='#FFFFFF' class='style17'><div align='left'>
                          Venue
                      </div></td>
                      <td bgcolor='#FFFFFF' class='style17'><div align='left' class='style34'>
                      <input name='venue' id='venue'  size='30' required value='";
                     if (isset($c->venue)) $result.=$c->venue;
                      $result.="'>
                      </div></td>
                      <td height='36' bgcolor='#FFFFFF' class='style17'><div align='left'>
                          Local phone
                      </div></td>
                      <td bgcolor='#FFFFFF' class='style17'><div align='left' class='style34'><input name='phone1' id='phone1' value='";
                     if (isset($c->phone1)) $result.=$c->phone1; else {$result.=$plist->phone1;}
                      $result.="' size=30 /></div></td>
                    </tr>

                    <tr>
                      <td height='36' bgcolor='#FFFFFF' class='style17'><div align='left'>
                          Capacity 
                      </div></td>
                      <td bgcolor='#FFFFFF' class='style17'><div align='left' class='style34'>
                      <input name='capacity' id='capacity' value='";
                       if (isset($c->capacity)) $result.=$c->capacity;
                      $result.="' size='30'>
                      </div></td>
                      <td height='36' bgcolor='#FFFFFF' class='style17'><div align='left'>
                          Cell phone 
                      </div></td>
                      <td bgcolor='#FFFFFF' class='style17'><div align='left' class='style34'> <input name='phone2' id='phone2' value='";
                      if (isset($c->phone2)) $result.=$c->phone2; else {$result.=$plist->phone2;}
                      $result.="' size=30 /></div></td>
                    </tr>
                    <tr>
                      <td height='36' bgcolor='#FFFFFF' class='style17'><div align='left'>
                          Art of performance 
                      </div></td>
                      <td bgcolor='#FFFFFF' class='style17'><div align='left' class='style34'>
                      <input name='art_of_perf' id='art_of_perf' value='";
                       if (isset($c->art_of_perf)) $result.=$c->art_of_perf;
                      $result.="' size='30'>
                      </div></td>

                      <td height='36' bgcolor='#FFFFFF' class='style17'><div align='left'>
                          Email 
                      </div></td>
                      <td bgcolor='#FFFFFF' class='style17'><div align='left' class='style34'>
                      <input name='email' id='email' value='";
                      if (isset($c->email)) $result.=$c->email; else {$result.=$plist->email;}
                      $result.="' size='30'>
                     </div></td>
                    </tr>
               </table></td>
              </tr>
            </table>";


$result.="
            <table width='95%' border='0' align='center' cellpadding='0' cellspacing='0'>
              <tr>
                <td width='53%' class='style4'><div align='left' class='style5'>Performance:</div></td>
                <td width='47%' class='style4'>&nbsp;</td>
              </tr>
            </table>
            <table width='95%' border='0' align='center' cellpadding='0' cellspacing='1' bgcolor='#999999'>

              <tr>
                <td bgcolor='#999999' class='style4'><table width='100%' border='0' align='center' cellpadding='3' cellspacing='1'>
                     <tr>
                      <td bgcolor='#FFFFFF' class='style17'><div align='left'>
                          Press conf.
                      </div></td>
                      <td bgcolor='#FFFFFF' class='style17'>
                      <div align='left' class='style34'>
                      <input name='presconf' id='presconf' value='";
                      if (isset($c->presconf)) $result.=$c->presconf;
                      $result.="' size='30'></div></td>
                       <td width='18%' height='36' bgcolor='#FFFFFF' class='style17'><div align='left'>
                          Dinner time</div></td>
                      <td bgcolor='#FFFFFF' class='style17'><div align='left' class='style34'>
                      <input name='dinner' id='dinner' value='";
                      if (isset($c->dinner)) $result.=$c->dinner;
                      $result.="' size='30'></div></td>
                    </tr>
                <tr>
                      <td width='20%' height='36' bgcolor='#FFFFFF' class='style17'><div align='left'>Get in time</div></td>
                      <td width='29%' bgcolor='#FFFFFF' class='style17'><div align='left' class='style34'>
                      <input name='acc_to_stage' id='acc_to_stage' value='";
                      if (isset($c->acc_to_stage)) $result.=$c->acc_to_stage;
                      $result.="' size='30'></div></td>
                      <td width='18%' height='36' bgcolor='#FFFFFF' class='style17'><div align='left'>
                          Sound check

                      </div></td>
                      <td bgcolor='#FFFFFF' class='style17'><div align='left' class='style34'>
                      <input name='soundcheck' id='soundcheck' value='";
                      if (isset($c->sound_check)) $result.=$c->sound_check;
                      $result.="' size='30'></div></td>
                    </tr>
                    <tr>
                      <td bgcolor='#FFFFFF' class='style17'><div align='left'>
                          Doors open
                      </div></td>
                      <td bgcolor='#FFFFFF' class='style17'><div align='left' class='style34'>
                      <input name='doorsopen' id='doorsopen' value='";
                      if (isset($c->doors_open)) $result.=$c->doors_open;
                      $result.="' size='30'>
                      </div></td>

                      <td width='18%' height='36' bgcolor='#FFFFFF' class='style17'><div align='left'>
                          Concert start
                      </div></td>
                      <td bgcolor='#FFFFFF' class='style17'><div align='left' class='style34'>
                      <input name='concert_start' id='concert_start' value='";
                      if (isset($c->concert_start)) $result.=$c->concert_start;
                      $result.="' size='30'></div></td>
                    </tr>
                    <tr>
                      <td bgcolor='#FFFFFF' class='style17'><div align='left'>
                          Perform. duration 
                      </div></td>
                      <td bgcolor='#FFFFFF' class='style17'><div align='left' class='style34'>
                      <input name='perf_duration' id='perf_duration' value='";
                      if (isset($c->lenght_of)) $result.=$c->lenght_of;
                      $result.="' size='30'></div></td>
                      <td height='36' bgcolor='#FFFFFF' class='style17'><div align='left'>
                          Publicity 
                      </div></td>
                      <td bgcolor='#FFFFFF' class='style17'><div align='left' class='style34'>
                      <input name='publicity' id='publicity' value='";
                      if (isset($c->publicity)) $result.=$c->publicity;
                      $result.="' size='30'></div></td>
                    </tr>

                </table></td>
              </tr>
            </table>
            <table width='95%' border='0' align='center' cellpadding='0' cellspacing='0'>
              <tr>
                <td width='53%' class='style4'><div align='left' class='style5'>The promoter have to pay for  the following:</div></td>
                <td width='47%' class='style4'>&nbsp;</td>
              </tr>

            </table>
            <table width='95%' border='0' align='center' cellpadding='0' cellspacing='1' bgcolor='#999999'>
              <tr>
                <td bgcolor='#999999' class='style4'><table width='100%' border='0' align='center' cellpadding='3' cellspacing='1'>
                    <tr>
                      <td width='20%' height='36' bgcolor='#FFFFFF' class='style17'><div align='left'>Artist fee</div></td>
                      <td width='29%' bgcolor='#FFFFFF' class='style17'><div align='left' class='style34'>
                      <input name='artist_fee' id='artist_fee' required  value='";
                      if (isset($c->artist_fee)) $result.=intval($c->artist_fee);  else $result.="";
                    //  if (isset($i->artist_fee)) $result.=intval($i->artist_fee);  else $result.="0";

                      $result.="' size='30' onblur='javascript:calculate_fee();'>
                      </div></td>
                      <td width='18%' height='36' bgcolor='#FFFFFF' class='style17'><div align='left'>
                          Administration expenses
                      </div></td>
                      <td bgcolor='#FFFFFF' class='style17'><div align='left' class='style34'>
                      <input name='admin_exp' id='admin_exp' required  value='";
                      if (isset($c->admin_exp)) $result.=intval($c->admin_exp);  else $result.="";
                    //  if (isset($i->admin_exp)) $result.=(int)$i->admin_exp;  else $result.="0";
                      $result.="' size='30'  onblur='javascript:calculate_fee();' >
                      </div></td>
                    </tr>
                    <tr>
                      <td bgcolor='#FFFFFF' class='style17'><div align='left'>
                          Productions expenses
                      </div></td>
                      <td bgcolor='#FFFFFF' class='style17'><div align='left' class='style34'>
                      <input name='production_exp' id='production_exp' required  value='";
                      if (isset($c->production_exp)) $result.=intval($c->production_exp); else $result.="";
                      //if (isset($i->production_exp)) $result.=(int)$i->production_exp; else $result.="0";
                      $result.="' size='30'  onblur='javascript:calculate_fee();'>
                      </div></td>
                      <td width='18%' height='36' bgcolor='#FFFFFF' class='style17'><div align='left'>
                          Other expenses
                      </div></td>
                      <td bgcolor='#FFFFFF' class='style17'><div align='left' class='style34'>
                       <input name='other_exp' id='other_exp' required  value='";
                      if (isset($c->other_exp)) $result.=intval($c->other_exp); else $result.="";
                      //if (isset($i->other_exp)) $result.=(int)$i->other_exp; else $result.="0";
                      $result.="' size='30'  onblur='javascript:calculate_fee();'>
                      </div></td>
                    </tr>

                    <tr>
                      <td bgcolor='#FFFFFF' class='style17'><div align='left'>
                          Travelling expenses
                      </div></td>
                      <td bgcolor='#FFFFFF' class='style17'><div align='left' class='style34'>
                      <input name='travel_exp' id='travel_exp' required value='";
                      if (isset($c->travel_exp)) $result.=intval($c->travel_exp);  else $result.="";
                    //  if (isset($i->travel_exp)) $result.=(int)$i->travel_exp;  else $result.="0";
                      $result.="' size='30'  onblur='javascript:calculate_fee();'></div></td>
                      <td height='36' bgcolor='#FFFFFF' class='style17'><div align='left'>
                       Total expenses
                      </div></td>
                      <td bgcolor='#FFFFFF' class='style17'><div align='left' class='style34'>
                      <input name='total_exp' id='total_exp' required value='";
                      if (isset($c->total_exp)) $result.=intval($c->total_exp);  else $result.="0";
                     // if (isset($i->total_exp)) $result.=$i->total_exp;  else $result.="0";
                      $result.="' size='30' >
                      </div></td>
                    </tr><tr>
                      <td bgcolor='#FFFFFF' class='style17' colspan=2></td>
                      <td height='36' bgcolor='#FFFFFF' class='style17'><div align='left'>
                       Currency abbr.
                      </div></td>
                      <td bgcolor='#FFFFFF' class='style17'><div align='left' class='style34'>
                      <input name='currency' id='currency' required value='";
                      if (isset($c->currency)) $result.=$c->currency;  else $result.="";
                    //  if (isset($i->currency)) $result.=$i->currency;  else $result.="";
                      $result.="' size='30' >
                      </div></td>
                    </tr>
                    <tr>

                      <td  height='36' bgcolor='#FFFFFF' class='style17'  colspan='2'><div align='left'>The  artist fee have to pay as follows</div></td>
                      <td  bgcolor='#FFFFFF' class='style17'  colspan='2'><div align='left' class='style34'>
                      <input name='pay_follows' id='pay_follows' value='";
                      if (isset($c->pay_follows)) $result.=$c->pay_follows;
                      $result.="' size='30'>
                     </div></td>
                    </tr>
                <!--    <tr>
                      <td height='36' bgcolor='#FFFFFF' class='style17'  colspan='2'><div align='left'>
                          Bank  account info 
                      </div></td>

                      <td bgcolor='#FFFFFF' class='style17' colspan='2'><div align='left' class='style34'>
                      <input name='acc_info' id='acc_info' value='";
                      if (isset($c->acc_info)) $result.=$c->acc_info;
                      $result.="' size='30'>
                      </div></td>
                    </tr>-->
                    <tr>
                      <td height='36' bgcolor='#FFFFFF' class='style17'  colspan='2'><div align='left'>
                          Other  expenses that have to be payed by the promoter
                      </div></td>
                      <td bgcolor='#FFFFFF' class='style17' colspan='2'><div align='left' class='style34'>
                      <input name='exp_prom_other' id='exp_prom_other' value='";
                      if (isset($c->exp_prom_other)) $result.=$c->exp_prom_other;
                      $result.="' size='30'>
                      </div></td>
                    </tr>
                </table></td>
              </tr>
            </table>";
$result.="<table width='95%' border='0' align='center' cellpadding='0' cellspacing='0'>
              <tr>
                <td width='53%' class='style4' colspan=2><div align='left' class='style5'>Sound company:&nbsp;";

 $result.="</td>

              </tr>
            </table>
            <table width='95%' border='0' align='center' cellpadding='0' cellspacing='1' bgcolor='#999999'>
              <tr>
                <td bgcolor='#999999' class='style4'>
                <div id='sound_info' name='sound_info'>
                <table width='100%' border='0' align='center' cellpadding='3' cellspacing='1'>
                    <tr>
                      <td width='20%' height='36' bgcolor='#FFFFFF' class='style17'><div align='left'>Sound company</div></td>

                      <td width='29%' bgcolor='#FFFFFF' class='style17'><div align='left' class='style34'>
                      <input name='sound_name' id='sound_name' value='";
                      if (isset($c->sound_name)) $result.=$c->sound_name;
                      $result.="' size='30'>
                      </div></td>
                      <td width='18%' height='36' bgcolor='#FFFFFF' class='style17'><div align='left'>
                      Cell phone</div></td>
                      <td bgcolor='#FFFFFF' class='style17'><div align='left' class='style34'>
                      <input name='sound_phone2' id='sound_phone2' value='";
                      if (isset($c->sound_phone2)) $result.=$c->sound_phone2;
                      $result.="' size='30'>
                       </div></td>
                    </tr>
                    <tr>
                      <td bgcolor='#FFFFFF' class='style17'><div align='left'>
                      Contact person</div></td>
                      <td bgcolor='#FFFFFF' class='style17'><div align='left' class='style34'>
                      <input name='sound_contact' id='sound_contact' value='";
                      if (isset($c->sound_contact)) $result.=$c->sound_contact;
                      $result.="' size='30'>
                      </div></td>
                      <td width='18%' height='36' bgcolor='#FFFFFF' class='style17'><div align='left'>
                          Email
                      </div></td>
                      <td bgcolor='#FFFFFF' class='style17'><div align='left' class='style34'>
                      <input name='sound_email' id='sound_email' value='";
                      if (isset($c->sound_email)) $result.=$c->sound_email;
                      $result.="' size='30'></div></td>

                    </tr>
                    <tr>
                      <td bgcolor='#FFFFFF' class='style17'><div align='left'>
                          Phone
                      </div></td>
                      <td bgcolor='#FFFFFF' class='style17'><div align='left' class='style34'>
                      <input name='sound_phone1' id='sound_phone1' value='";
                      if (isset($c->sound_phone1)) $result.=$c->sound_phone1;
                      $result.="' size='30'>
                     </div></td>
                      <td height='36' bgcolor='#FFFFFF' class='style17'>&nbsp;</td>
                      <td bgcolor='#FFFFFF' class='style17'>&nbsp;</td>
                  </tr>
                </table>

";


               $result.=" </div>
                </td>
              </tr>
            </table>
      <table width='95%' border='0' align='center' cellpadding='0' cellspacing='1' bgcolor='#999999'>
              <tr>
                <td bgcolor='#999999' class='style4'><table width='100%' border='0' align='center' cellpadding='3' cellspacing='1'>
                    <tr>
                      <td width='92%' height='36' bgcolor='#FFFFFF' class='style17'>
                      <div align='left'>One signed copy should be returned in (days)</div></td>
                      <td width='8%' bgcolor='#FFFFFF' class='style17' align='center' valign='middle'>
                          <input  name='issue_date' id='issue_date'  size='10' value='";
                      if (isset($c->issue_date)) $result.=$c->issue_date; else $result.='3';
                      $result.="'>
                    </td>
                  </tr>
                </table></td>
              </tr>
            </table>
            <br>
            <table width='95%' border='0' align='center' cellpadding='0' cellspacing='1' bgcolor='#999999'>
              <tr>
                <td bgcolor='#999999' class='style4'><table width='100%' border='0' align='center' cellpadding='3' cellspacing='1'>

                    <tr>
                      <td height='36' bgcolor='#FFFFFF'>
                       <div align='left' id='savebt'>  &nbsp;&nbsp;&nbsp;
                      <input type='submit' value='Save'  class='style17' align='absmiddle' style='padding:0 0 0 30px; border:0; background-image:url(images/save-accept-24x24.png);background-repeat:no-repeat;background-color:white;text-decoration:underline;cursor:hand;'>
                      &nbsp;&nbsp;&nbsp;&nbsp;
                      &nbsp;<a href='".$mosConfig_live_site."/modules/contract.php?lang=no&id=".$id_contract."' title='Print contract' target='_blank'><img src='images/printbutton.png' border=0 align='absmiddle'  width='24' height='24'></a>
                      &nbsp;<a href='".$mosConfig_live_site."/modules/contract.php?lang=no&id=".$id_contract."' title='Print contract' target='_blank'  class='style17'>Print</a>&nbsp;&nbsp;&nbsp;&nbsp;
                      <img src='images/printbutton.png' width='24' height='24' border=0 align='absmiddle'></a>&nbsp;<a href='".$mosConfig_live_site."/modules/contract.php?lang=en&id=".$id_contract."' title='Print english version' target='_blank'  class='style17'>Print ENG</a>
                      &nbsp;&nbsp;
                       <a href='#' onclick='javascript:message_form_contract(0,2,".$c->id_promoter.",0,".$id_contract.");'><img src='images/forward-new-mail-24x24.png' border=0 align='absmiddle'></a>&nbsp; <a href='#' onclick='javascript:message_form_contract(0,2,".$c->id_promoter.",0,".$id_contract.");'  class='style17'>
                      Send via email [EN]</a>&nbsp;&nbsp;

                      <a href='#' onclick='javascript:message_form_contract(0,2,".$c->id_promoter.",1,".$id_contract.");'><img src='images/forward-new-mail-24x24.png' border=0 align='absmiddle'></a>&nbsp;<a href='#' onclick='javascript:message_form_contract(0,2,".$c->id_promoter.",1,".$id_contract.");'  class='style17' >Send via email [NO]</a>
                      &nbsp;&nbsp;&nbsp;<a href='".$mosConfig_live_site."/modules/itn.php?id=".$id_contract."' title='Print itinerary' target='_blank'><img src='images/printbutton.png' border=0 align='absmiddle'  width='24' height='24'></a>
                      &nbsp;<a href='".$mosConfig_live_site."/modules/itn.php?id=".$id_contract."' title='Print itinerary' target='_blank'  class='style17'>Print itinerary</a>
                      </div></td>
                    </tr>
                </table></td>
              </tr>
            </table>
</form>
<div id='itn' name='itn'>&nbsp;&nbsp;&nbsp;&nbsp;<a ".stripslashes($_COOKIE['now']).">
<img src='images/back-24x24.png' align='absmiddle' border=0></a>&nbsp;<a ".stripslashes($_COOKIE['now'])." class='style17'>Back</a>
</div><br>
<div id='opt_info' name='opt_info'>";


if ($id_contract>0) {
if (!$has_perf) $result.="<div style='margin-left:45px;'><a href='#' onclick=\"javascript:addPerfForms(".$c->id.");\"><img src='images/note-edit-24x24.png' border='0'></a>&nbsp;&nbsp;<a href='#' onclick=\"javascript:addPerfForms(".$c->id.");\"><span class='style17'>THIS CONTRACT HASN'T ITINERARY. CLICK HERE TO&nbsp;FILL IT</span></a></div>";
else $result.=list_deparrs ($id_contract);
}
$result.="&nbsp;</div><div id='perf_info' name='perf_info' style='display:none;'>&nbsp;</div>";
*/
$objResponse = new xajaxResponse('UTF-8');
//$objResponse->addAssign( 'report_div', 'innerHTML',"");
$objResponse->addAssign( 'report_div', 'innerHTML', $result);
return $objResponse->getXML();
}

function add_contract3($formdata,$make_it=0)
{
$result="";
foreach ($formdata as $key => $fdata) {
$formdata[$key] = addslashes(strip_tags($fdata));
$result.="<br>[".$key."]=>".$fdata.";";
}

 $id=0;

if (!isset($formdata['id_perfomance']))$formdata['id_perfomance']=0;
//if (!isset($formdata['p60artist']))$formdata['p60artist']=0;else $formdata['p60artist']=1;
//if (!isset($formdata['p60csten']))$formdata['p60csten']=0;else $formdata['p60csten']=1;
//if (!isset($formdata['p60sten']))$formdata['p60sten']=0;else $formdata['p60sten']=1;


if ($formdata['artist_fee']=="")$formdata['artist_fee']=0;
else {  $formdata['artist_fee']=str_replace("," , ".", $formdata['artist_fee']);}
if ($formdata['admin_exp']=="")$formdata['admin_exp']=0;
else {  $formdata['admin_exp']=str_replace("," , ".", $formdata['admin_exp']);}
if ($formdata['production_exp']=="")$formdata['production_exp']=0;
else {  $formdata['production_exp']=str_replace("," , ".", $formdata['production_exp']);}
if ($formdata['other_exp']=="")$formdata['other_exp']=0;
else {  $formdata['other_exp']=str_replace("," , ".", $formdata['other_exp']);}
if ($formdata['travel_exp']=="")$formdata['travel_exp']=0;
else {  $formdata['travel_exp']=str_replace("," , ".", $formdata['travel_exp']);}
if ($formdata['total_exp']=="")$formdata['total_exp']=0;
else {  $formdata['total_exp']=str_replace("," , ".", $formdata['total_exp']);}


if ($formdata['id']==0) {
$query="
INSERT INTO `#__contracts`
(
 `contract_no`,
 `contract_date`,
 `id_artist`,
 `id_promoter`,
 `concert_date`,
 `id_perfomance`,
 `artist_fee`,
 `admin_exp`,
 `production_exp`,
 `other_exp`,
 `travel_exp`,
 `total_exp`,
 `pay_follows`, ";
// `acc_info`,
 $query.=" `sound_name`,
 `sound_contact`,
 `sound_phone1`,
 `sound_phone2`,
 `sound_email`,
 `artist`,
 `promoter`,
 `venue`,
 `capacity`,
 `contact_person`,
 `address`,
 `town`,
 `phone1`,
 `phone2`,
 `email`,
 `art_of_perf`,
 `acc_to_stage`,
 `presconf`,
 `dinner`,
 `sound_check`,
 `doors_open`,
 `lenght_of`,
 `concert_start`,
`publicity`,
`exp_prom_other`, ";
//`p60artist`,
//`p60csten`,
//`p60sten`,
$query.=" `issue_date`, `currency`
 ) VALUES
('".$formdata['contract_no']."',
 '".$formdata['contract_date']."',
  ".$formdata['id_artist'].",
  ".$formdata['id_promoter'].",
 '".$formdata['concert_date']."',
  ".$formdata['id_perfomance'].",
  ".$formdata['artist_fee'].",
  ".$formdata['admin_exp'].",
  ".$formdata['production_exp'].",
  ".$formdata['other_exp'].",
  ".$formdata['travel_exp'].",
  ".$formdata['total_exp'].",
 '".$formdata['pay_follows']."',  ";

// '".$formdata['acc_info']."',

 $query.=" '".$formdata['sound_name']."',
 '".$formdata['sound_contact']."',
 '".$formdata['sound_phone1']."',
 '".$formdata['sound_phone2']."',
 '".$formdata['sound_email']."',
 '".$formdata['artist']."',
 '".$formdata['promoter']."',
 '".$formdata['venue']."',
 '".$formdata['capacity']."',
 '".$formdata['contact_person']."',
 '".$formdata['address']."',
 '".$formdata['town']."',
 '".$formdata['phone1']."',
 '".$formdata['phone2']."',
 '".$formdata['email']."',
 '".$formdata['art_of_perf']."',
 '".$formdata['acc_to_stage']."',
 '".$formdata['presconf']."',
 '".$formdata['dinner']."',
 '".$formdata['soundcheck']."',
 '".$formdata['doorsopen']."',
 '".$formdata['perf_duration']."',
 '".$formdata['concert_start']."',
 '".$formdata['publicity']."',
 '".$formdata['exp_prom_other']."', ";
 // ".$formdata['p60artist'].",
 // ".$formdata['p60csten'].",
 // ".$formdata['p60sten']." ,

 $query.=" '".$formdata['issue_date']."', '".$formdata['currency']."'  )";
} else {  $query="
update `#__contracts` SET

 `contract_no` = '".$formdata['contract_no']."',
 `contract_date` =  '".$formdata['contract_date']."',
 `id_artist` = ".$formdata['id_artist'].",
 `id_promoter` =   ".$formdata['id_promoter'].",
 `concert_date` =  '".$formdata['concert_date']."',
 `id_perfomance` =  ".$formdata['id_perfomance'].",
 `artist_fee`=  ".$formdata['artist_fee'].",
 `admin_exp` =   ".$formdata['admin_exp'].",
 `production_exp` =  ".$formdata['production_exp'].",
 `other_exp` =    ".$formdata['other_exp'].",
 `travel_exp` =  ".$formdata['travel_exp'].",
 `total_exp`= '".$formdata['total_exp']."',
 `pay_follows`=  '".$formdata['pay_follows']."', ";
// `acc_info`= '".$formdata['acc_info']."',
 $query.=" `sound_name` = '".$formdata['sound_name']."',
 `sound_contact`= '".$formdata['sound_contact']."',
 `sound_phone1`= '".$formdata['sound_phone1']."',
 `sound_phone2`= '".$formdata['sound_phone2']."',
 `sound_email`= '".$formdata['sound_email']."',
 `artist`= '".$formdata['artist']."',
 `promoter` = '".$formdata['promoter']."',
 `venue` = '".$formdata['venue']."',
 `capacity` =  '".$formdata['capacity']."',
 `contact_person` = '".$formdata['contact_person']."',
 `address` =  '".$formdata['address']."',
 `town` =  '".$formdata['town']."',
 `phone1` = '".$formdata['phone1']."',
 `phone2` = '".$formdata['phone2']."',
 `email` = '".$formdata['email']."',
 `art_of_perf`= '".$formdata['art_of_perf']."',
 `acc_to_stage` ='".$formdata['acc_to_stage']."',
 `presconf` ='".$formdata['presconf']."',
 `dinner` ='".$formdata['dinner']."',
 `sound_check` ='".$formdata['soundcheck']."',
 `doors_open`='".$formdata['doorsopen']."',
 `lenght_of` = '".$formdata['perf_duration']."',
 `concert_start` ='".$formdata['concert_start']."',
 `publicity` ='".$formdata['publicity']."',
 `exp_prom_other` ='".$formdata['exp_prom_other']."',  ";
// `p60artist` =  ".$formdata['p60artist'].",
// `p60csten` = ".$formdata['p60csten'].",
// `p60sten` = ".$formdata['p60sten'].",
 $query.="  `issue_date` ='".$formdata['issue_date']."',
  `currency` = '".$formdata['currency']."'
 WHERE id=".$formdata['id'];

}

global $database;
$database->setQuery( "set names utf8" );
$database->query();
$database->setQuery( $query );

$database->query();
if($formdata['id']==0){$id = mysql_insert_id();}
else{
  $id=$formdata['id'];}


if($id>0) {
$database->setQuery( "delete from  #__cont_dates where cont_id=".$id);
$database->query();
if (isset($formdata['moredates'])) {
$sd=explode("|",$formdata['moredates']);
      for($i=0;$i<sizeof($sd);$i++){
            if($sd[$i]!='') {
            $database->setQuery( "insert into #__cont_dates (date,cont_id) values('".$sd[$i]."',".$id.")" );
            $database->query();
          }
    }
}
}








$objResponse = new xajaxResponse('UTF-8');
if (!$make_it) {$objResponse->addAssign( 'report_div', 'innerHTML',contracts_list(0));}
else{
$objResponse->addAppend('savebt','innerHTML','&nbsp;');
$objResponse->addAssign('id','value',$id);
$objResponse->addAssign('info_div','innerHTML',addPerfForm(0,$formdata['concert_date'],$id));
$objResponse->addAssign('info_div','style.display',"block");
 }
return $objResponse->getXML();
}

function addPerfForms($id,$pid=0){
$objResponse = new xajaxResponse('UTF-8');
//$objResponse->addAssign('id','value',$c);
$objResponse->addAssign('info_div','innerHTML',addPerfForm($id,$pid));
$objResponse->addAssign('info_div','style.display',"block");
return $objResponse->getXML();
}



function selectsSound($id){
if ($id>0) {
$query="SELECT * from sound_companies  where id=".$id;

global $database;
$database->setQuery( "set names utf8" );
$database->query();
$sounds = array();
$database->setQuery( $query );
$sounds = $database->loadObjectList();
foreach ($sounds as $sound){}
$result="


                <table width='100%' border='0' align='center' cellpadding='3' cellspacing='1'>
                    <tr>
                      <td width='20%' height='36' bgcolor='#FFFFFF' class='style17'><div align='left'>Sound company</div></td>

                      <td width='29%' bgcolor='#FFFFFF' class='style17'><div align='left' class='style34'>
                      <input name='sound_name' id='sound_name' value='".$sound->name."' size='30'>
                      </div></td>
                      <td width='18%' height='36' bgcolor='#FFFFFF' class='style17'><div align='left'>
                      <p>Fax </p></div></td>
                      <td bgcolor='#FFFFFF' class='style17'><div align='left' class='style34'>
                      <input name='sound_phone2' id='sound_phone2' value='".$sound->phone2."' size='30'>
                       </div></td>
                    </tr>
                    <tr>
                      <td bgcolor='#FFFFFF' class='style17'><div align='left'>
                      <p>Contact person</p></div></td>
                      <td bgcolor='#FFFFFF' class='style17'><div align='left' class='style34'>
                      <input name='sound_contact' id='sound_contact' value='".$sound->contact_person."' size='30'>
                      </div></td>
                      <td width='18%' height='36' bgcolor='#FFFFFF' class='style17'><div align='left'>
                          <p>Email</p>
                      </div></td>
                      <td bgcolor='#FFFFFF' class='style17'><div align='left' class='style34'>
                      <input name='sound_email' id='sound_email' value='".$sound->email."' size='30'></div></td>

                    </tr>
                    <tr>
                      <td bgcolor='#FFFFFF' class='style17'><div align='left'>
                          <p>Phone </p>
                      </div></td>
                      <td bgcolor='#FFFFFF' class='style17'><div align='left' class='style34'>
                      <input name='sound_phone1' id='sound_phone1' value='".$sound->phone1."' size='30'>
                     </div></td>
                      <td height='36' bgcolor='#FFFFFF' class='style17'>&nbsp;</td>
                      <td bgcolor='#FFFFFF' class='style17'>&nbsp;</td>
                  </tr>
                </table>
";
} else $result="   <table width='100%' border='0' align='center' cellpadding='3' cellspacing='1'>
                    <tr>
                      <td bgcolor='#FFFFFF' class='style17'>Please, select proper sound company from list above!</td>
                  </tr>
                </table>";

return $result;

}

function get_inq_dated($inq_id)
{
global $database;
$database->setQuery( "select date from #__inq_dates where inq_id=".intval($inq_id));
$inquiries = $database->loadObjectList();
$resp="";$i=0;
foreach ($inquiries as $inquiry){

$resp.="<div id='datec".$i."' style='margin:1px;clear:both;float:none;'><input type='text' value='".$inquiry->date."' size='20' name='cdateadd' id='cdat_".$i."'>&nbsp;<a href='#' onclick='javascript:cal1xx.select(document.getElementById(\"cdat_".$i."\"),\"ancho".$i."xx\",\"yyyy-MM-dd\");return false;' name='ancho".$i."xx' id='ancho".$i."xx'>";
$resp.="<img src='images/itinerary-24x24.png' border='0' align='absmiddle'></a>&nbsp;<a href='#' onclick='javascript:remove_cdat(".$i.")' style='color:red;'><img src='images/del.gif' border='0' align='absmiddle'></a></div>";
$i++;
}
return $resp;
}

function get_cont_dated($inq_id)
{
global $database;
$database->setQuery( "select date from #__cont_dates where cont_id=".intval($inq_id));
$inquiries = $database->loadObjectList();
$resp="";$i=0;
foreach ($inquiries as $inquiry){

$resp.="<div id='datec".$i."' style='margin:1px;clear:both;float:none;'><input type='text' value='".$inquiry->date."' size='20' name='cdateadd' id='cdat_".$i."'>&nbsp;<a href='#' onclick='javascript:cal1xx.select(document.getElementById(\"cdat_".$i."\"),\"ancho".$i."xx\",\"yyyy-MM-dd\");return false;' name='ancho".$i."xx' id='ancho".$i."xx'>";
$resp.="<img src='images/itinerary-24x24.png' border='0' align='absmiddle'></a>&nbsp;<a href='#' onclick='javascript:remove_cdat(".$i.")' style='color:red;'><img src='images/del.gif' border='0' align='absmiddle'></a></div>";
$i++;
}
return $resp;
}

function selectSound($id){

$objResponse = new xajaxResponse('UTF-8');
$objResponse->addAssign( 'sound_info', 'innerHTML', selectsSound($id));
return $objResponse->getXML();

}

function getInquiryComments($inquiryId){
    global $database;
    $database->setQuery( "set names utf8" );
    $database->query();
    $commentsQuery = "SELECT * FROM #__comments WHERE id_source=".$inquiryId." AND about='inquiry'";
    $database->setQuery($commentsQuery);
    $comments = $database->loadObjectList();
    
    $result="";
    
    foreach ($comments as $comment){
        $result.= "<span style='color:red'>".$comment->lastupdate.":</span> ".$comment->comment."<br/>";
    }
    return $result;
}

function viewInquiry($id)
{
setcookie('prev',stripslashes($_COOKIE['now']) );
if ($id=='undefined')$id=0;
 setcookie('now',"href='#' onclick='javascript:viewInquiry(".$id.");' ");

$result="error";
if ($id>0) {
$query="SELECT i.*, date (i.venue_date) as v_date, p.name as promoter_name, coalesce(( SELECT GROUP_CONCAT( z.date ORDER BY z.date DESC SEPARATOR '<br/>') from #__inq_dates z where z.inq_id = i.id),' ') as ddates, coalesce((select c.name from #__countries c where c.id=i.country limit 1),'undefined')as country_name FROM #__inquiries i, #__promoters p  where p.id=i.id_promoter and i.id=".$id;
global $database;
$database->setQuery( "set names utf8" );
$database->query();
$inquiries = array();
$database->setQuery( $query );
$inquiries = $database->loadObjectList();
foreach ($inquiries as $inquiry){}


$result="<table width='95%' border='0' align='center' cellpadding='0' cellspacing='1' bgcolor='#999999'>
        <tr>
          <td bgcolor='#999999' class='style4'>
          <table width='100%' border='0' align='center' cellpadding='3' cellspacing='1'>
          <tr>
                <td height='78' colspan='5' bgcolor='#FFFFFF' class='style5'><span class='style4'>".$inquiry->promoter_name."</span><br>
                  <span class='style35'>(received ".$inquiry->lastupdate.")</span></td>
              </tr>
              <tr>
                <td height='36' bgcolor='#FFFFFF' class='style17'><div align='left'><span class='style17'>Inquiry id</span></div></td>
                <td bgcolor='#FFFFFF' class='style17'><div align='left' class='style34'>".$inquiry->id."</div></td>
                <td height='36' bgcolor='#FFFFFF' class='style17'><div align='left'><p>City code </p></div></td>
                <td bgcolor='#FFFFFF' class='style17' colspan=2><div align='left' class='style34'>".$inquiry->city_code."</div></td>
              </tr>
              <tr>
                <td width='21%' height='36' bgcolor='#FFFFFF' class='style17'><div align='left'><span class='style17'>Artist</span></div></td>
                <td width='28%' bgcolor='#FFFFFF' class='style17'><div align='left' class='style34'>";
              $query="SELECT * from #__artists  where id=".$inquiry->id_artist;$database->setQuery( $query );
              $artists = $database->loadObjectList();foreach ($artists as $artist){$result.=$artist->name;}

                $result.="</div></td>
                <td width='18%' height='36' bgcolor='#FFFFFF' class='style17'><div align='left'>
                  <p>Town </p>
                </div></td>
                <td colspan='2' bgcolor='#FFFFFF' class='style17'><div align='left' class='style34'>".$inquiry->town."</div></td>
              </tr>

              <tr>
                <td height='36' bgcolor='#FFFFFF' class='style17'><div align='left'>Concert date</div></td>
                <td bgcolor='#FFFFFF' class='style17'><div align='left' class='style34'>".$inquiry->venue_date."<br />".$inquiry->ddates."</div></td>
                <td height='36' bgcolor='#FFFFFF' class='style17'><div align='left'><p>Country </p></div></td>
                <td colspan='2' bgcolor='#FFFFFF' class='style17'><div align='left' class='style34'>".$inquiry->country_name."</td>
              </tr>
              <tr>
                <td height='36' bgcolor='#FFFFFF' class='style17'><div align='left'>
                  <p>Promoter</p>
                </div></td>
                <td bgcolor='#FFFFFF' class='style17'><div align='left' class='style34'>".$inquiry->promoter_name."</div></td>
                <td height='36' bgcolor='#FFFFFF' class='style17'><div align='left'><p>Local phone </p></div></td>
                <td colspan='2' bgcolor='#FFFFFF' class='style17'><div align='left' class='style34'>".$inquiry->phone1."</div></td>
              </tr>
              <tr>
                <td height='36' bgcolor='#FFFFFF' class='style17'><div align='left'><p>Contact person </p></div></td>
                <td bgcolor='#FFFFFF' class='style17'><div align='left' class='style34'>".$inquiry->contact_person."</div></td>
                <td height='36' bgcolor='#FFFFFF' class='style17'><div align='left'><p>Cell phone </p></div></td>
                <td colspan='2' bgcolor='#FFFFFF' class='style17'><div align='left' class='style34'>".$inquiry->phone2."</div></td>
              </tr>
              <tr>
                <td height='36' bgcolor='#FFFFFF' class='style17'><div align='left'><p>Street address 1 </p></div></td>
                <td bgcolor='#FFFFFF' class='style17'><div align='left' class='style34'>".$inquiry->address1."</div></td>
                <td height='36' bgcolor='#FFFFFF' class='style17'><div align='left'><p>Email</p></div></td>
                <td width='16%' bgcolor='#FFFFFF' class='style17'><div align='left' class='style34'>".$inquiry->email."</div></td>
                <td width='17%' bgcolor='#FFFFFF' class='style17'><a href='#' onclick='javascript:message_form(0,2,".$inquiry->id_promoter.");' ><img src='images/forward-new-mail-24x24.png' border=0 width='21' height='21' align='absmiddle'></a>&nbsp;<a href='#' onclick='javascript:message_form(0,2,".$inquiry->id_promoter.");' class='style11'>Send message</a></td>
              </tr>
              <tr>
                <td height='36' bgcolor='#FFFFFF' class='style17'><div align='left'><p>Street address 2 </p></div></td>
                <td bgcolor='#FFFFFF' class='style17'><div align='left' class='style34'>".$inquiry->address2."</div></td>
                <td height='36' bgcolor='#FFFFFF' class='style17'><div align='left'><p>Website</p></div></td>
                <td colspan='2' bgcolor='#FFFFFF' class='style17'><div align='left' class='style34'>".$inquiry->www."</div></td>
              </tr>
                    <tr>
                      <td width='20%' height='36' bgcolor='#FFFFFF' class='style17'><div align='left'>Artist fee</div></td>
                      <td width='29%' bgcolor='#FFFFFF' class='style17'><div align='left' class='style34'>".$inquiry->artist_fee."
                      </div></td>
                      <td width='18%' height='36' bgcolor='#FFFFFF' class='style17'><div align='left'>
                          <p>Administration expenses</p>
                      </div></td>
                      <td  colspan='2' bgcolor='#FFFFFF' class='style17'><div align='left' class='style34'>".$inquiry->admin_exp."</div></td>
                    </tr>
                    <tr>
                      <td bgcolor='#FFFFFF' class='style17'><div align='left'>
                          <p>Productions expenses</p>
                      </div></td>
                      <td bgcolor='#FFFFFF' class='style17'><div align='left' class='style34'>".$inquiry->production_exp."</div></td>
                      <td width='18%' height='36' bgcolor='#FFFFFF' class='style17'><div align='left'>
                          <p>Other expenses </p>
                      </div></td>
                      <td colspan='2' bgcolor='#FFFFFF' class='style17'><div align='left' class='style34'>".$inquiry->other_exp."</div></td>
                    </tr>

                    <tr>
                      <td bgcolor='#FFFFFF' class='style17'><div align='left'>
                          <p>Travelling expenses</p>
                      </div></td>
                      <td bgcolor='#FFFFFF' class='style17'><div align='left' class='style34'>".$inquiry->travel_exp."</div></td>
                      <td height='36' bgcolor='#FFFFFF' class='style17'><div align='left'>
                       <p>Total expenses </p>
                      </div></td>
                      <td colspan='2' bgcolor='#FFFFFF' class='style17'><div align='left' class='style34'>".$inquiry->total_exp."</div></td>
                    </tr><tr>
                      <td bgcolor='#FFFFFF' class='style17' colspan=2></td>
                      <td height='36' bgcolor='#FFFFFF' class='style17'><div align='left'>
                       <p>Currency abbr.</p>
                      </div></td>
                      <td colspan='2' bgcolor='#FFFFFF' class='style17'><div align='left' class='style34'>".$inquiry->currency."</div></td>
                    </tr>



              <tr>
                <td height='36' bgcolor='#FFFFFF' class='style17'><p align='left'>Comments</p></td>
                <td height='36' colspan='4' bgcolor='#FFFFFF' class='style17'><div align='left'><span class='style34'>".$inquiry->comments."</span></div></td>
              </tr>
              <tr>
                <td height='36' bgcolor='#FFFFFF' class='style17'><p align='left'>Our comments</p></td>
                <td height='36' colspan='4' bgcolor='#FFFFFF' class='style17'><div align='left' id='our_comment' name='our_comment'><span class='style34'>".getInquiryComments($inquiry->id)."</span></div>
                </td>
              </tr>

              <tr>
                <td height='36' colspan='5' bgcolor='#FFFFFF'>
<form method='POST' name='add_contract' id='add_contract' ACTION=\"javascript:add_contract2(xajax.getFormValues('add_contract'),".$inquiry->id.");\">
<input type='hidden' name='id_promoter' id='id_promoter' value='".$inquiry->id_promoter."'>
<input type='hidden' name='id_artist' id='id_artist' value='".$inquiry->id_artist."'>
<input type='hidden' name='id_inquiry' id='id_inquiry' value='".$inquiry->id."'>
<input type='hidden' name='venue_date' id='venue_date' value='".$inquiry->venue_date."'>
<input type='hidden' name='town' id='town' value='".$inquiry->town."'>

                <div align='left'>&nbsp;&nbsp;&nbsp;&nbsp;
                <a href='#' onclick='javascript:add_our_comment(".$inquiry->id.",\"inquiry\");'><img src='images/comment-add-24x24.png'   align='absmiddle' border=0></a>
                <a href='#' onclick='javascript:add_our_comment(".$inquiry->id.",\"inquiry\");' class='style17'>Add our comments</a>
                &nbsp;&nbsp;&nbsp;&nbsp;
                ";

 $thisyear=date("Y", mktime (0,0,0,date("m")  ,date("d"),date("Y")));
$result.="&nbsp;&nbsp;&nbsp;<a  class='style17' href='#' onclick=\"javascript:viewSchedule(".$inquiry->id_artist.",". $thisyear.",'".$inquiry->v_date."','".$inquiry->v_date."');\"><IMG SRC='images/itinerary-24x24.png' BORDER='0' align='absmiddle'></a>
&nbsp;<a  class='style17' href='#' onclick=\"javascript:viewSchedule(".$inquiry->id_artist.",".$thisyear.",'".$inquiry->v_date."','".$inquiry->v_date."');\">
Show artist itinerary</a>&nbsp;&nbsp;&nbsp;&nbsp;
";
if ($inquiry->id_promoter>0) {
$result.="<a href='#' onclick='javascript:getpromoterInfo(".$inquiry->id_promoter.");'><img src='images/info-24x24.png' align='absmiddle' border='0'></a>&nbsp;
<a class='style17' href='#' onclick='javascript:getpromoterInfo(".$inquiry->id_promoter.");'>View&nbsp;promoter</a>";

}else {$result.= "<a href='#' onclick='add_promoter(".$inquiry->id.")' title='add promoter to DB'><IMG SRC='images/user-add-24x24.png' align='absmiddle' BORDER='0' ALT='Add promoter to DB'></a>&nbsp;
<a href='#' onclick='add_promoter(".$inquiry->id.")' title='add promoter to DB' class='style17'>Add promoter to DB</a>";}
$result.="&nbsp;&nbsp;&nbsp;";
if ((isset($inquiry->id_promoter))&&($inquiry->id_promoter>0)){
$result.="<input type='submit' class='style17' style='border:0; background-color:white;background-image:url(images/note-edit-24x24.png); background-repeat:no-repeat; padding-left:30px;' align='absmiddle' value='Sign contract'>";
}else{ $result.="<font color='red'><nowrap>Add promoter to DB to sign the contract!</nowrap></font>";}

$result.="</form></td></tr>
          </table></td>
        </tr>
      </table>
      <table width='95%' border='0' align='center' cellpadding='0' cellspacing='1'>
      <tr><td height='36'><a ".stripslashes ($_COOKIE['now'])."><img src='images/back-24x24.png' align='absmiddle' border=0></a>&nbsp;<a ".stripslashes ($_COOKIE['now'])." class='style17'>Back</a></td></tr></table>

";
}
$result.="
<br /><div id='sch_info' name='sch_info' style='display:none;'>&nbsp;</div>
<div id='opt_info' name='opt_info' style='display:none;'>&nbsp;</div>
<div id='perf_info' name='perf_info' style='display:none;'>&nbsp;</div>";
$objResponse = new xajaxResponse('UTF-8');
$objResponse->addAssign( 'report_div', 'innerHTML', $result);
return $objResponse->getXML();
}

function add_our_comment2($id)
{
global $database;
$database->setQuery( "set names utf8" );
$database->query();
$database->setQuery( "SELECT * from #__promoters  where id=".$id);
$comments = $database->loadObjectList();
$result="
<form method='POST' name='comm_form' id='comm_form' style='margin:0;' action=\"javascript:save_our_comment2(xajax.getFormValues('comm_form'));\">
<input type='hidden' id='id_source' name='id_source' value=".$id." />";
foreach ($comments as $comment){
$result.="<div><textarea name='comment' id='comment' rows='3' cols='55' maxsize='400'>".stripslashes($comment->comments)."</textarea></div>
<input type='submit' value='Save'>";
}
$result.='</form>';
$objResponse = new xajaxResponse('UTF-8');
$objResponse->addAssign( 'our_comment', 'innerHTML', $result);
return $objResponse->getXML();

}


function add_our_comment($id,$where)
{
global $database;
$database->setQuery( "set names utf8" );
$database->query();
$database->setQuery( "SELECT * from #__comments  where id_source=".$id."  and about='".$where."' order by lastupdate desc "  );
$comments = $database->loadObjectList();

$result="
<form method='POST' name='comm_form' id='comm_form' style='margin:0;' action=\"javascript:save_our_comment(xajax.getFormValues('comm_form')); \">
<input type='hidden' id='id_source' name='id_source' value=".$id." />
<input type='hidden' id='about' name='about' value='".$where."' />
<table border=0 cellpadding=2 cellspacing=2 width='100%'>
";

foreach ($comments as $comment){
$result.="<tr><td width='120' align='left' class='style2 sm' nowrap>".$comment->lastupdate."</td><td align='left' class='style9 sm'>".$comment->comment."</td>
<td><a href='#' onclick='javascript:delete_our_comment(".$comment->id.");' title='Delete this comment'><img src='images/del.gif' width='10' height='10' align='absmiddle' border='0'></a></td></tr>";
}
$result.="
<tr><td  colspan=2><div id='comment'><textarea name='comment' id='comment' rows='3' cols='55' maxsize='400'></textarea></div></td>
<td><input type='submit' value='Save' /></td></tr></table>
</form>
";


$objResponse = new xajaxResponse('UTF-8');
$objResponse->addAssign( 'our_comment', 'innerHTML', $result);
return $objResponse->getXML();

}

function save_our_comment($comm)
{
global $database;
$database->setQuery( "set names utf8" );
$database->query();
foreach ($comm as $key => $fdata) {
	$comm[$key] = addslashes(strip_tags($fdata));
}
$query="insert into #__comments (id_source, comment,  whosupdate, about)
values (".$comm['id_source'].",'".$comm['comment']."',".$_COOKIE['operator_id'].",'".$comm['about']."')";
$database->setQuery($query);

$database->query();
$qu="SELECT * from #__comments  where id_source=".$comm['id_source']." and about='".$comm['about']."' order by lastupdate desc ";
$database->setQuery($qu );
$comments = $database->loadObjectList();
$result="<table border=0 cellpadding=2 cellspacing=2  width='100%'>";
foreach ($comments as $comment){
$result.="<tr><td width='120' align='left' class='style2 sm' nowrap>".$comment->lastupdate."</td><td align='left' class='style9 sm'>".$comment->comment."</td>
<td><a href='#' onclick='javascript:delete_our_comment(".$comment->id.");' title='Delete this comment'><img src='images/del.gif' width='10' height='10' align='absmiddle' border='0'></a></td></tr>";
}
$result.="</table>";
$objResponse = new xajaxResponse('UTF-8');
$objResponse->addAssign( 'our_comment', 'innerHTML', $result);
return $objResponse->getXML();
}


function save_our_comment2($comm)
{
global $database;
$database->setQuery( "set names utf8" );$database->query();
foreach ($comm as $key => $fdata) {$comm[$key] = addslashes(strip_tags($fdata));}
$query="update #__promoters set comments = '".$comm['comment']."' where id=".$comm['id_source'];
$database->setQuery($query);
$database->query();
$result="<span onclick='javascript:add_our_comment2(".$comm['id_source'].");'>".stripslashes($comm['comment'])."</span>";
$objResponse = new xajaxResponse('UTF-8');
$objResponse->addAssign( 'our_comment', 'innerHTML', $result);
return $objResponse->getXML();
}

function delete_our_comment($id)
{
global $database;
$database->setQuery("select * from #__comments where id=".$id);
$comms = $database->loadObjectList();
foreach ($comms as $comm){ }
$database->setQuery ("delete from #__comments where id=".$id );
$database->query();
$database->setQuery( "set names utf8" );
$database->query();
$qu="SELECT * from #__comments  where id_source=".$comm->id_source." and about='".$comm->about."' order by lastupdate desc ";
$database->setQuery($qu );
$comments = $database->loadObjectList();
$result="<table border=0 cellpadding=2 cellspacing=2 width='100%'>
";
foreach ($comments as $comment){
$result.="<tr><td width='120' align='left' class='style2 sm' nowrap>".$comment->lastupdate."</td><td align='left' class='style9 sm'>".$comment->comment."</td>
<td><a href='#' onclick='javascript:delete_our_comment(".$comment->id.");' title='Delete this comment'><img src='images/del.gif' width='10' height='10' align='absmiddle' border='0'></a></td></tr>";
}
$result.="</table>";
$objResponse = new xajaxResponse('UTF-8');
$objResponse->addAssign( 'our_comment', 'innerHTML', $result);
return $objResponse->getXML();
}



function contract_list($id, $search="", $mode=0,$page=0){
setcookie('prev',stripslashes($_COOKIE['now']) );
if ($id=='undefined')$id=0;
if ($search=='undefined')$search="";
if ($mode=='undefined')$mode=0;
if ($page=='undefined')$page=0;
setcookie('now',"href='#' onclick='javascript:contract_list(".$id.",\"".$search."\",".$mode.",".$page.");' ");
$result=contracts_list($id, $search,$mode,$page);
$objResponse = new xajaxResponse('UTF-8');
$objResponse->addAssign( 'report_div', 'innerHTML', $result);
return $objResponse->getXML();
}

function contracts_list ($id, $search="", $mode=0,$page=0){

$result= "";
if ($id=='undefined')$id=0;
if ($search=='undefined')$search="";
//$result.="ss".$search;
if ($mode=='undefined')$mode=0;
if ($page=='undefined')$page=0;
if (isset($id)) $ss=$id; else $ss=0;

switch  ($ss)
{
	case 0: $add=" where a.status >=0 "; break;
	case 1: $add=" where a.status= -1 "; break;
}
if ($search!="")
{

switch ($mode)

{
case 1: $add=" where  a.id_artist in ( select p.id from #__artists p where upper(p.name) like '%".mb_strtoupper(mb_convert_encoding($search,'utf8','UTF-8'))."%') ";break;
case 2: {

$add=" where 1>0 ";
$a = explode("|",$search);
if (strlen($a[0])>0) $add.=" and a.id_artist in ( select a.id from #__artists a where upper(a.name) like '%".mb_strtoupper(mb_convert_encoding($a[0],'utf8','UTF-8'))."%') ";
if (strlen($a[1])>0) $add.=" and a.id_promoter in ( select p.id from #__promoters p where upper(p.name) like '%".mb_strtoupper(mb_convert_encoding($a[1],'utf8','UTF-8'))."%') ";
break;}
case 3:{
$add=" where 1>0 ";
$a = explode("|",$search);
if ($a[0]>0) $add.=" and a.contract_date >= '".$a[0]."' ";
if ($a[1]>0) $add.=" and a.contract_date <= '".$a[1]."' ";
break;}

default: $add=" where  a.id_promoter in ( select p.id from #__promoters p where upper(p.name) like '%".mb_strtoupper(mb_convert_encoding($search,'utf8','UTF-8'))."%') ";break;

}
}

//==============================================================
global $_PERPAGE;
$per_page=$_PERPAGE;


$query2="SELECT count(*) FROM #__contracts a ".$add."
order by a.id desc ";
$head="";
global $database;
$database->setQuery( "set names utf8" );
$database->query();
$database->setQuery( $query2 );
$counts = $database->loadResult();
//$result.=$query2;
$pages=ceil($counts/$per_page);
if ($page==0) $page=1;
$limits=" LIMIT ".($page-1)*$per_page.",".$per_page." ";
$paginator="<select id='paginator' name='paginator' onchange='javascript:contract_list(".$id.",\"".$search."\",".$mode.", this.value);'>";
for ($i=1;$i<=$pages;$i++) {
$paginator.="<option value='".$i."'";
if ($page==$i)$paginator.=" selected ";
$paginator.=">".$i."</option>";}
$paginator.="</select>";


$query="select a.*,coalesce(( SELECT GROUP_CONCAT( z.date ORDER BY z.date DESC SEPARATOR '<br/>') from #__cont_dates z where z.cont_id = a.id),' ') as ddates FROM #__contracts a ".$add." order by id desc ".$limits;

$np=$page+1;$pp=$page-1;
if (1==$page)$links="<div align='center'><span class='style11'><img border=0 src='images/back-24x24.png' align='absmiddle'>&nbsp;prev&nbsp;page&nbsp;";
else $links="<div align='center'><a href='#' onclick='javascript:contract_list(".$id.",\"".$search."\",".$mode.",".$pp.");'><img border=0 src='images/back-24x24.png' align='absmiddle'></a>&nbsp;<a class='style11' href='#' onclick='javascript:contract_list(".$id.",\"".$search."\",".$mode.",".$pp.");'>prev&nbsp;page</a>&nbsp;";
$links.= $paginator;
if ($pages==$page)$links.="<span class='style11'>&nbsp;next&nbsp;page&nbsp;<img border=0 src='images/next-24x24.png' align='absmiddle'></span>";
else $links.="&nbsp;<a class='style11' href='#' onclick='javascript:contract_list(".$id.",\"".$search."\",".$mode.",".$pp.");'>next&nbsp;page</a>&nbsp;<a href='#' onclick='javascript:contract_list(".$id.",\"".$search."\",".$mode.",".$pp.");'><img border=0 src='images/next-24x24.png' align='absmiddle'></a>";
   //<div align='center'>".$paginator."&nbsp; &nbsp;next&nbsp;page&nbsp;<img border=0 src='images/next-24x24.png' align='absmiddle'></span></div>

//==============================================================

$result.= "
  <table width='95%' border='0' align='center' cellpadding='0' cellspacing='0'>
      <tr>
        <td width='53%' class='style4'>Contracts</td>
        <td width='47%' class='style4'><!--".displays_search_form(1)."--></td>
      </tr>
    </table><br />
";

$head="";
$contracts = array();
$database->setQuery( $query );
$contracts = $database->loadObjectList();
$result.= $head;
$result.=  "<table width='95%' border='0' align='center' cellpadding='0' cellspacing='1' bgcolor='#999999'>
              <tr>
                <td bgcolor='#999999' class='style4'><table width='100%' border='0' align='center' cellpadding='0' cellspacing='1'>
                  <tr>
                    <td height='36' colspan='5' bgcolor='#FFFFFF'>&nbsp;&nbsp;<span class='style5'>Contracts</span>&nbsp;&nbsp;&nbsp;";

                    if ($ss!=0) $result.= "<A HREF='#' onclick='javascript:contract_list(0);' class='style11'>Active</A>";else  $result.= "[<B>Active</B>]";
 $result.= "&nbsp;|&nbsp;";
if ($ss!=1) $result.= "<A HREF='#' class='style11' onclick='javascript:contract_list(1);' >Deleted</A>";else  $result.= "[<B>Deleted</B>]";

$result.="</td></tr>";


$result.="
                  <tr>
                    <td width='35%' height='35' align='center' class='style18'>Promoter</td>
                    <td width='25%' height='35' align='center' class='style18'>Artist</td>
                    <td width='15%' height='35' align='center' class='style18'>Town</td>
                    <td width='15%' height='35' align='center' class='style18'>Concert date</td>
                    <td width='10%' height='35' align='center' class='style18'>Contract №</td>
                  </tr>
";


if (count($contracts)>0){
foreach ($contracts as $contract)
	{
if($contract->ddates>" ") $contract->ddates="<br />".$contract->ddates;
$result.="
                  <tr>
                    <td height='35' bgcolor='white'>&nbsp;&nbsp;<a href='#' onclick='javascript:add_contract2(0,0,".$contract->id.");' title='Get info on this Contract'><img src='images/blog-post-edit-24x24.png'  align='absmiddle' border='0'></a>&nbsp;
";

if($contract->status > -1) $result.="<a href='#' onclick='javascript:contract_delete(".$contract->id.");' title='Delete this contract'><img src='images/trash-empty-24x24.png'  align='absmiddle' border='0'></a>";
else
{
$result.="<a href='#' onclick='javascript:contract_restore(".$contract->id.");' title='Restore this contract'><img src='images/accept-24x24.png' align='absmiddle' border='0'></a>";
$result.="<a href='#' onclick='javascript:contract_deletef(".$contract->id.");' title='Delete forever this contract'><img src='images/f-off.gif' align='absmiddle' border='0'></a>";
}
$result.="&nbsp;&nbsp;&nbsp;<a class='style34' href='#' onclick='javascript:add_contract2(0,0,".$contract->id.");' title='Get info on this Contract'>".$contract->promoter ."</a></td>
                    <td bgcolor='white'><div align='center'>".$contract->artist."</div></td>
                    <td bgcolor='white'><div align='center'>".$contract->town."</div></td>
                    <td bgcolor='white'><div align='center'>".$contract->concert_date.$contract->ddates."</div></td>
                    <td bgcolor='white'><div align='center'>".$contract->id ."</div></td>
                  </tr>
";
}}
else {
 $result.="

     <tr>
                    <td height='35' bgcolor='#FFFFFF' colspan=5><span class='style11'>&nbsp;&nbsp;&nbsp;Nobody found</span></td>
                  </tr>
 ";


}
$result.="

                  <tr>
                    <td height='35' bgcolor='#FFFFFF'>&nbsp;&nbsp;
                    <!--<a href='#' onclick='javascript:add_contract(0);'><img src='images/comment-add-24x24.png'   align='absmiddle' border=0></a>&nbsp;&nbsp;<a href='#' onclick='javascript:add_contract(0);'  class='style11'>Add Contract</a>--></td>
                    <td height='35' colspan='4' bgcolor='#FFFFFF'><div align='center'>".$links."</div></td>
                  </tr>
                </table></td>
              </tr>
            </table>";

return  $result;

}



function contract_delete($id){
global $database;
$query="update `#__contracts` set status=-1 where `id`=".$id ;
//echo $query;
$database->setQuery( $query);
$database->query();
$objResponse = new xajaxResponse('UTF-8');
$objResponse->addAssign( 'report_div', 'innerHTML', contracts_list(0));
return $objResponse->getXML();
}

function contract_deletef($id){
global $database;
$query="delete from `#__contracts` where `id`=".$id." limit 1" ;
//echo $query;
$database->setQuery( $query);
$database->query();
$objResponse = new xajaxResponse('UTF-8');
$objResponse->addAssign( 'report_div', 'innerHTML', contracts_list(0));
return $objResponse->getXML();
}

function contract_restore($id){
global $database;
$query="update `#__contracts` set status=0 where `id`=".$id ;
//echo $query;
$database->setQuery( $query);
$database->query();
$objResponse = new xajaxResponse('UTF-8');
$objResponse->addAssign( 'report_div', 'innerHTML', contracts_list(0));
return $objResponse->getXML();
}


function message_form($message_id=0,$to_type=0,$to_id=0,$data="",$who="" ){
$template=''; $subm='';
setcookie('prev',stripslashes($_COOKIE['now']) );
setcookie('now',"href='#' onclick=\"javascript:message_form('".$message_id."','".$to_type."','".$to_id."');\" ");
if ($who=='all_promoters'){$to_type=2;$to_id= -1;}
if ($who=='checked_promoters'){$to_type=2;$to_id= -2;}
global $database,$mosConfig_absolute_path;

$database->setQuery( "set names utf8" );
$database->query();
$query="select * from #__messages a where message_id=".$message_id;
$database->setQuery( $query );
$messages = $database->loadObjectList();

$query="select max(message_id) from #__messages";
$database->setQuery( $query );
$msg_id = $database->loadResult();

$ft = new FastTemplate($mosConfig_absolute_path."/templates");
$es=email_selectors($to_type,$to_id,$data);
if ($message_id==0){$subm="<div id='sendbutton'><INPUT TYPE='submit' value='Send message'></div><div id='waitsend' style='display:none;'><img src='images/wait_big.gif' border=0 vspace=3 hspace=3></div>";
$alist = array();
$alist[] = mosHTML::makeOption( '0', 'without template ... or ...', 'value', 'text'  );
$query="select message_id as value, subject as text from #__message_templates order by subject asc";
$database->setQuery( $query );
$alist = array_merge($alist,$database->loadObjectList());
$m=mosHTML::selectList( $alist, 'template_id', " id='template_id' onchange='javascript:change_template(this.value);' ", 'value', 'text',0 );
$template.=$m;
}
if (sizeof($messages)>0) {
foreach ($messages as $message){
 $ft->define(array('body'  => "message_view.tpl"));
        $attnames=explode("|",$message->attaches);
        $links="<b>Attached files:</b>&nbsp;";
        foreach ($attnames as $attname) {$n=explode("/",$attname);$links.="<a href='".$attname."' target='_blank'>".$n[sizeof($n)-1]."</a>&nbsp;&nbsp;";}
        $ft->assign( array(
                    'ID' => $message->message_id,
                    'TO' => $message->to_addr,
                    'SUBJECT' => $message->subject,
                    'MESSAGE' => "<iframe id='msg_view' name='msg_view' src='message_view.php?id=".$message->message_id."' style='width:100%;height:600px;scroll:auto;'></iframe>",
                    'TO_OPTS' => "",
                    'SENT'=> $message->mesage_date,
                    'SUBMIT'=> $subm,
                    'BACK'=> stripslashes ($_COOKIE['now']),
                    'LINKS'=> $links
                    ));

}
$ft->parse('BODY', "body");
$result=$ft->FastPrint("BODY",true);
$objResponse = new xajaxResponse('UTF-8');
$objResponse->addAssign( 'report_div', 'innerHTML', $result);

//window.onload = createUploader;
//$objResponse->addAssign( 'msg_view', 'innerHTML', stripslashes($message->mesage_body));
//$objResponse->addScript('$("#example3").jqUploader({background:	"FFFFDF",barColor:	"FF00FF"});');

//$objResponse->addScript( 'replaceDiv("message")');
return $objResponse->getXML();


}else{
  $ft->define(array('body'  => "message.tpl"));
    $ft->assign( array(
                    'ID' => 0,
                    'TO' => "",
                    'SUBJECT' => "",
                    'MESSAGE' => "",
                    'TO_OPTS' => "",
                    'SUBMIT'=> $subm,
                    'SELECTOR'=> $es,
                    'TEMPLATE' => $template,
                    'MSG_ID' =>"?msg_id=".$msg_id
                    ));

$ft->parse('BODY', "body");
    $result=$ft->FastPrint("BODY",true);
$objResponse = new xajaxResponse('UTF-8');
$objResponse->addAssign( 'report_div', 'innerHTML', $result);
$objResponse->addScript( 'replaceDiv("message")');
return $objResponse->getXML();


}



}
function sms_form($message_id=0,$to_type=0,$to_id=0,$data="",$who="" ){
$template=''; $subm='';
setcookie('prev',stripslashes($_COOKIE['now']) );
setcookie('now',"href='#' onclick=\"javascript:sms_form('".$message_id."','".$to_type."','".$to_id."');\" ");
if ($who=='all_promoters'){$to_type=2;$to_id= -1;}
if ($who=='checked_promoters'){$to_type=2;$to_id= -2;}
global $database,$mosConfig_absolute_path;

$database->setQuery( "set names utf8" );
$database->query();
$query="select * from #__sms a where sms_id=".$message_id;
$database->setQuery( $query );
$messages = $database->loadObjectList();

$query="select max(message_id) from #__sms";
$database->setQuery( $query );
$msg_id = $database->loadResult();

$ft = new FastTemplate($mosConfig_absolute_path."/templates");
$es=sms_selectors($to_type,$to_id,$data);
if ($message_id==0){$subm="<div id='sendbutton'><INPUT TYPE='submit' value='Send message'></div><div id='waitsend' style='display:none;'><img src='images/wait_big.gif' border=0 vspace=3 hspace=3></div>";
}
if (sizeof($messages)>0) {
foreach ($messages as $message){
 $ft->define(array('body'  => "sms_view.tpl"));
        $ft->assign( array(
                    'ID' => $message->message_id,
                    'TO' => $message->to_name."&nbsp;&nbsp;".$message->to_addr,
                    'MESSAGE' => $message->mesage_body,
                    'TO_OPTS' => "",
                    'SENT'=> $message->mesage_date,
                    'SUBMIT'=> $subm,
                    'BACK'=> stripslashes ($_COOKIE['now'])

                    ));

}
$ft->parse('BODY', "body");
$result=$ft->FastPrint("BODY",true);
$objResponse = new xajaxResponse('UTF-8');
$objResponse->addAssign( 'report_div', 'innerHTML', $result);
return $objResponse->getXML();
}else{
  $ft->define(array('body'  => "sms.tpl"));
    $ft->assign( array(
                    'ID' => 0,
                    'TO' => "",
                    'MESSAGE' => "",
                    'TO_OPTS' => "",
                    'SUBMIT'=> $subm,
                    'SELECTOR'=> $es,
                    'MSG_ID' =>"?msg_id=".$msg_id
                    ));

$ft->parse('BODY', "body");
    $result=$ft->FastPrint("BODY",true);
$objResponse = new xajaxResponse('UTF-8');
$objResponse->addAssign( 'report_div', 'innerHTML', $result);
$objResponse->addScript( 'replaceDiv("message")');
return $objResponse->getXML();


}



}

function change_template($id)
{
  global $database,$mosConfig_absolute_path;

$database->setQuery( "set names utf8" );
$database->query();
$template="";$subject ="";
$query=" select * from #__message_templates a where message_id=".$id;
$database->setQuery( $query );
$messages = $database->loadObjectList();
if (sizeof($messages)>0) {foreach ($messages as $message){$template.= $message->message_body_html;}
$subject =$message->subject;
}
$result="<TEXTAREA NAME='message' id='message' ROWS='30' COLS='80' class='ckeditor'  >"."Hello %USERNAME%!<br/>".$template."</TEXTAREA>";
$objResponse = new xajaxResponse('UTF-8');
$objResponse->addScript('ckeditor.destroy();ckeditor=null;');
$objResponse->addAssign('message_cont', 'innerHTML', $result);
$objResponse->addAssign('subject', 'value',$subject );
$objResponse->addScript('replaceDiv("message");');
//$objResponse->addAssign( 'message', 'innerHTML',"" );

return $objResponse->getXML();

}


function message_form_contract($message_id=0,$to_type=0,$to_id=0,$data=0,$id ){

setcookie('prev',stripslashes($_COOKIE['now']) );
setcookie('now',"href='#' onclick=\"javascript:message_form('".$message_id."','".$to_type."','".$to_id."');\" ");
if ($data!=0) $tpl="contract_no.tpl";else $tpl="contract_en.tpl";

global $database,$mosConfig_absolute_path;$database->setQuery( "set names utf8" );$database->query();
$query=" select * from #__messages a where message_id=".$message_id;
$database->setQuery( $query );
$messages = $database->loadObjectList();
$ft = new FastTemplate($mosConfig_absolute_path."/templates");
$es=email_selectors($to_type,$to_id,$data);
if ($message_id==0)$subm="<INPUT TYPE='submit' value='Send message'>";else $subm='';

//$ft->define(array('body'  => "message_c.tpl",
$ft->define(array('body'  => "message.tpl",
                  'contract'    => $tpl
))
;

$query="select * from #__settings where id=".$_COOKIE['operator_id'];
//$query="select * from #__settings where id=1";
$database->setQuery($query);
$setting = $database->loadObjectList(); foreach ($setting as $settings)     { }

if ($id>0) $database->setQuery( "SELECT *, date_format(contract_date,'%d/%m/%Y') as c_date, date_format(concert_date,'%d/%m/%Y') as a_date FROM #__contracts  where id=".$id );
$cs =$database->loadObjectList();

$css_add='
<STYLE type="text/css">
@media print {
   *, BODY {font-size: 10pt; line-height: 140%; background: #FFFFFF; color:black;}
   #print { display:none; visibility:none;}
   table.cont th {font-size: 10pt;color:black;border:0;padding:2px;text-align:left;}
   table.cont td {font-size: 10pt; color:black;}
   table { width:99%;font-size:10pt;}
   p {font-size: 10pt; line-height: 140%; background: #FFFFFF; color:black;}
   .head {font-size: 12pt; text-align:center; line-height: 140%; background: #FFFFFF; color:black;}
}
@media screen {
*, BODY {font-size: 10pt; line-height: 140%; background: #FFFFFF; color:black;}
table { width:800px;}
table.cont  {border-collapse:collapse; border:0; font-size:10pt;}
table.cont th {color: black;border:0;padding:3px;color:black; font-size:10pt;text-align:left;}
table.cont td {color:black; font-size:10pt;}
p {font-size: 10pt; line-height: 140%; background: #FFFFFF; color:black;}
.head {font-size: 12pt; text-align:center; line-height: 140%; background: #FFFFFF; color:black;}
}
</STYLE>
';
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
                        'PRINTBUTTON' =>"&nbsp;"
            ) );


    $ft->parse('CONTENT', "contract");
    $content = $ft->fetch('CONTENT');



    $ft->assign( array(
                    'ID' => 0,
                    'TO' => "",
                    'SUBJECT' => "Contract ".$id,
                    'MESSAGE' => $css_add.stripslashes($content),
                    'TO_OPTS' => "",
                    'SUBMIT'=> $subm,
                    'SELECTOR'=> $es
                    ));




    $ft->parse('BODY', "body");
    $result=$ft->FastPrint("BODY",true);
$objResponse = new xajaxResponse('UTF-8');
$objResponse->addAssign( 'report_div', 'innerHTML', $result);
$objResponse->addScript( 'replaceDiv("message");');
return $objResponse->getXML();
}

function removeFromEnd($string, $stringToRemove) {
    $stringToRemoveLen = strlen($stringToRemove);
    $stringLen = strlen($string);

    $pos = $stringLen - $stringToRemoveLen;

    $out = substr($string, 0, $pos);

    return $out;
}

//function getUsername($email){
//     global $database;
//    $database->setQuery("set names utf8");
//     $database->query();
//     $database->setQuery("SELECT * FROM #__promoters");
//     $promoters = $database->loadObjectList();
//     
//     foreach($promoters as $promoter){
//         $address = $promoter->email;
//         $addressList = explode(',',$address);
//         foreach ($addressList as $entry){
//             if(trim($entry)==trim($email)){
//                 $username=$promoter->contact_person;
//                 return $username;
//             }
//         }
//     }
//return 'Customer';
//}

//15.01.2014
function getUsername($email){
   
     global $database;
     $database->setQuery("set names utf8");
     $database->query();
     $database->setQuery("SELECT * FROM #__promoters WHERE email LIKE '%".$email."%'");
     $promoters = $database->loadObjectList();
     
     foreach($promoters as $promoter){
         $address = $promoter->email;
         $addressList = explode(',',$address);
         foreach ($addressList as $entry){
             if(trim($entry)==trim($email)){
                 $username=$promoter->contact_person;
                 return $username;
             }
         }
     }
     return 'Customer';
}

//15.01.2014
function getUserId($email){
   
     global $database;
     $database->setQuery("set names utf8");
     $database->query();
     $database->setQuery("SELECT * FROM #__promoters WHERE email LIKE '%".$email."%'");
     $promoters = $database->loadObjectList();
     
     foreach($promoters as $promoter){
         $address = $promoter->email;
         $addressList = explode(',',$address);
         foreach ($addressList as $entry){
             if(trim($entry)==trim($email)){
                 $id=$promoter->id;
                 return $id;
             }
         }
     }
     return 0;
}

function send_message($formdata){
global $database, $mosConfig_absolute_path,$mosConfig_live_site,$_COMPANY_NAME, $_EMAIL, $_FOOTER1; 
$database->setQuery( "set names utf8" );
$database->query();
$err=$result="";
require_once($mosConfig_absolute_path."/includes/phpmailer/class.phpmailer.php");
$msg = new PHPMailer();
foreach ($formdata as $key => $fdata) {
switch($key){
case 'message': $formdata[$key] = $fdata;break;
case 'filenames': $formdata[$key] = $fdata;break;
case 'to': $formdata[$key] = $fdata;break;
default:$formdata[$key] =  addslashes(strip_tags($fdata));break;
}
$result.="'".$key."'=>'".$formdata[$key]."'<br/>";
}

$attlinks=$formdata['filenames'];
$attlinks=str_replace($mosConfig_absolute_path,$mosConfig_live_site,$attlinks);

$to  = $formdata['to'];
$adresses=explode(',',$to);

foreach($adresses as $to){
if (!isset($formdata['whos_id']))$formdata['whos_id']=0;
if (strlen($formdata['to_name'])>1){
    $tonn=$formdata['to_name'];
} else {
    $tonn=substr($to,0,strpos($to,"<"));
}

$username = getUsername(trim($to));
$userId = getUserId(trim($to));
$messageBody = str_replace("%USERNAME%", $username, $formdata['message']);

$message = '<html><head><title>'.$formdata['subject'].'</title><meta http-equiv="Content-Type" content="text/html; charset=utf8" /></head><body>'.$messageBody.'<br/>'.$_FOOTER1.'</body></html>';

        $query="INSERT INTO `#__messages` (
        `from` , `to_id` , `to_name` , `to_type` , `to_addr` , `subject` , `mesage_body` , `status`,`attaches`,`mesage_date` )
                      VALUES ( '1', '".$userId."', '".$formdata['to_name']."', '".$formdata['to_type']."',  '".$to."', '".addslashes($formdata['subject'])."' ,  '".$messageBody."' ,  '0','".$attlinks."', '".date('Y-m-d H:i:s')."')";
 
//2014-01-20      VALUES ( '1', '".$userId."', '".$formdata['to_name']."', '".$formdata['to_type']."',  '".$to."', '".addslashes($formdata['subject'])."' ,  '".$messageBody."' ,  '0','".$attlinks."', FROM_UNIXTIME(".  strtotime(date("y-m-d H:i:s"))."))";
        $database->setQuery( $query );
$database->query();
$id= $database->insertid();
$msg->From=$_EMAIL;
$msg->FromName=$_COMPANY_NAME;
$msg->Sender=$_EMAIL;
$html = str_get_html($message);

$attnames=explode("|",$formdata['filenames']);

foreach($html->find('img') as $element){

      $url=$element->src;
      $n=explode('/',$url);
      $filename=$n[sizeof($n)-1];

//      str_replace ($url,$filename,$message  );
     if($n[0]=='http:') file_put_contents(dirname(__FILE__)."/cache/image/".$filename, file_get_contents($url));
     if (file_exists ( dirname(__FILE__)."/cache/image/".$filename )){
      $name=explode(".",$filename);
      $element->src = 'cid:'.md5($name[0]);
     $typ=get_mime_type_from_ext(strtolower($name[sizeof($name)-1]));
     $msg->AddEmbeddedImage(dirname(__FILE__)."/cache/image/".$filename,md5($name[0]),$filename,"base64",$typ);
      }
//
     }

foreach ($attnames as $attname){
if (file_exists($attname)){
      $n=explode('/',$attname);
      $filename=$n[sizeof($n)-1];
      $e=explode('.',$filename);
$msg->AddAttachment($attname,$filename,"base64",get_mime_type_from_ext($e[sizeof($e)-1]));
//$msg->AddAttachment($attname,$filename);
}
}
$msg->Body = $html;
//$msg->AltBody = strip_tags(htmlspecialchars_decode($message));
$msg->Subject='=?UTF-8?B?'.base64_encode($formdata['subject']).'?=';
$msg->AddAddress($to);
$msg->Mailer='mail';
$msg->Helo='www.stenolav-management.no';




//echo '<a href="'.$site.'" target="_blank">'.$val.'</a><br />';


$msg->isHTML(true);
$msg->Send();
$err.=$msg->ErrorInfo;
$msg->ClearAddresses();
$msg->ClearAttachments();
$msg->IsHTML(false);
}
$objResponse = new xajaxResponse('UTF-8');
$objResponse->addScript('ckeditor.destroy();ckeditor=null;');
$objResponse->addAssign( 'report_div', 'innerHTML',message_list(0));  // $result.'<br/>errors:'.$err.
return $objResponse->getXML();
}



function do_post_request($url, $data, $optional_headers = null)
	{
	$params = array('http'      => array(
		'method'       => 'POST',
		'content'      => $data,
		       ));
	if ($optional_headers !== null) {
		$params['http']['header'] = $optional_headers;
	}

	$ctx = stream_context_create($params);
	$fp = fopen($url, 'rb', false, $ctx);

	if (!$fp) {
		print "Problem with $url, Cannot connect\n";
	}
	$response = @stream_get_contents($fp);
	if ($response === false) {
		print "Problem reading data from $url, No status returned\n";
	}

	return $response;
	}


function send_sms($formdata){
$url = 'http://bulksms.vsms.net/eapi/submission/send_sms/2/2.0';
global $database, $mosConfig_absolute_path,$mosConfig_live_site,$_COMPANY_NAME, $_EMAIL, $_FOOTER1;
global  $mosConfig_smsuser ,$mosConfig_smspaswd,$SMS_TEST_MODE;
$database->setQuery( "set names utf8" );
$database->query();
$err=$result="";
foreach ($formdata as $key => $fdata) {
switch($key){
case 'message_txt': $formdata[$key] = $fdata;break;
case 'to': $formdata[$key] = $fdata;break;
default:$formdata[$key] =  addslashes(strip_tags($fdata));break;
}
$result.="'".$key."'=>'".$formdata[$key]."'<br/>";
}
$to  = $formdata['to'];
$adresses=explode(',',$to);
$message = $formdata['message_txt'];
foreach($adresses as $to){

$to=preg_replace("/[ ()-+]/", "", $to);
if (!isset($formdata['whos_id']))$formdata['whos_id']=0;
if (strlen($formdata['to_name'])>1) $tonn=$formdata['to_name']; else $tonn=substr($to,0,strpos($to,"<"));
$message=str_replace('_NAME_',$tonn, $message);
$data = 'username='.$mosConfig_smsuser.'&password='.$mosConfig_smspaswd.'&message='.urlencode($message).'&msisdn='.$to;

if ($SMS_TEST_MODE=="no")$response = do_post_request($url, $data); else $response="ok";
$query="INSERT INTO `#__sms` ( `from` , `to_id` , `to_name` , `to_type` , `to_addr` , `mesage_body` , `status`)
VALUES ( '1', '".$formdata['whos_id']."', '".$formdata['to_name']."', '".$formdata['to_type']."',  '".$to."',  '".addslashes($message)."<br />status:".$response."' ,  '0')";
$database->setQuery( $query );
$database->query();
$id= $database->insertid();

}
$objResponse = new xajaxResponse('UTF-8');
if(!isset($formdata['formtype'])){
$objResponse->addAssign( 'report_div', 'innerHTML',sm_list(0));
}
$objResponse->addScript('hideInfo()');
return $objResponse->getXML();
}

function http_request($url)
{
    $curl_handler = curl_init($url);
    curl_setopt($curl_handler, CURLOPT_RETURNTRANSFER, 1);
    $response = curl_exec($curl_handler);
    curl_close($curl_handler);
    return $response;
}

function messages_list($id=0, $search="", $page=0){
if ($id=='undefined')$id=0;
if ($search=='undefined')$search="";
if ($page=='undefined')$page=0;
setcookie('prev',stripslashes($_COOKIE['now']) );
if ($id=='undefined')$id=0;
 setcookie('now',"href='#' onclick='javascript:messages_list(".$id.",\"".$search."\",".$page.");' ");
$objResponse = new xajaxResponse('UTF-8');
$objResponse->addAssign( 'report_div', 'innerHTML', message_list($id,$search,$page));
return $objResponse->getXML();
}
function sms_list($id=0, $search="", $page=0){
if ($id=='undefined')$id=0;
if ($search=='undefined')$search="";
if ($page=='undefined')$page=0;
setcookie('prev',stripslashes($_COOKIE['now']) );
if ($id=='undefined')$id=0;
 setcookie('now',"href='#' onclick='javascript:sms_list(".$id.",\"".$search."\",".$page.");' ");
$objResponse = new xajaxResponse('UTF-8');
$objResponse->addAssign( 'report_div', 'innerHTML', sm_list($id,$search,$page));
return $objResponse->getXML();
}
//========================================================================================
function message_list($id=0, $search="",$page=0){

setcookie('prev',stripslashes($_COOKIE['now']) );
if ($id=='undefined')$id=0;
if ($search=='undefined')$search="";
if ($page=='undefined')$page=0;
setcookie('now',"href='#' onclick='javascript:messages_list(".$id.",\"".$search."\",".$page.");' ");
if (isset($id)) $ss=$id; else $ss=0;
global $_PERPAGE;
$per_page=$_PERPAGE;
$result= "";

switch  ($ss)
{
	case 0: $add=" where status >=0 "; break;
	case 1: $add=" where status= -1 "; break;
}
if ($search!="") $add=" where  a.to_name like '%".$search."%'  OR a.to_addr like '%".$search."%'";

$query2="SELECT count(*) from #__messages a ".$add." order by a.message_id desc ";
$head="";
global $database;
$database->setQuery( "set names utf8" );
$database->query();
$database->setQuery( $query2 );
$counts = $database->loadResult();
//$result.=$query2;
$pages=ceil($counts/$per_page);
if ($page==0) $page=1;

$limits=" LIMIT ".($page-1)*$per_page.",".$per_page." ";
$paginator="<select id='paginator' name='paginator' onchange='javascript:messages_list(".$id.",\"".$search."\", this.value);'>";
for ($i=1;$i<=$pages;$i++) {
$paginator.="<option value='".$i."'";
if ($page==$i)$paginator.=" selected ";
$paginator.=">".$i."</option>";}
$paginator.="</select>";
$np=$page+1;$pp=$page-1;
if (1==$page)$links="<div align='center'><span class='style11'><img border=0 src='images/back-24x24.png' align='absmiddle'>&nbsp;prev&nbsp;page&nbsp;";
else $links="<div align='center'><a href='#' onclick='javascript:messages_list(".$id.",\"".$search."\",".$pp.");'><img border=0 src='images/back-24x24.png' align='absmiddle'></a>&nbsp;<a class='style11' href='#' onclick='javascript:messages_list(".$id.",\"".$search."\",".$pp.");'>prev&nbsp;page</a>&nbsp;";
$links.= $paginator;
if ($pages==$page)$links.="<span class='style11'>&nbsp;next&nbsp;page&nbsp;<img border=0 src='images/next-24x24.png' align='absmiddle'></span>";
else $links.="&nbsp;<a class='style11' href='#' onclick='javascript:messages_list(".$id.",\"".$search."\",".$np.");'>next&nbsp;page</a>&nbsp;<a href='#' onclick='javascript:messages_list(".$id.",\"".$search."\",".$np.");'><img border=0 src='images/next-24x24.png' align='absmiddle'></a>";
   //<div align='center'>".$paginator."&nbsp; &nbsp;next&nbsp;page&nbsp;<img border=0 src='images/next-24x24.png' align='absmiddle'></span></div>


$head="";
$messages = array();
$query="select * from #__messages a ".$add." order by a.message_id desc ".$limits;
$database->setQuery( $query );
$messages = $database->loadObjectList();
$result.= "
  <table width='95%' border='0' align='center' cellpadding='0' cellspacing='0'>
      <tr>
        <td width='53%' class='style4'>Messages</td>
        <td width='47%' class='style4'><!--".displays_search_form(1)."--></td>
      </tr>
    </table><br />
";
$result.= "<table width='95%' border='0' align='center' cellpadding='0' cellspacing='1' bgcolor='#999999'>
              <tr>
                <td bgcolor='#999999' class='style4'><table width='100%' border='0' align='center' cellpadding='0' cellspacing='1'>
                  <tr>
                    <td height='36' colspan='1' bgcolor='#FFFFFF'>&nbsp;&nbsp;<span class='style5'>Messages</span></td><td height='36' colspan='2' bgcolor='#FFFFFF'>&nbsp;&nbsp;<a href='#' onclick='javascript:message_form(0);'><img src='images/comment-add-24x24.png' align='absmiddle' border=0></a>&nbsp;&nbsp;<a href='#' onclick='javascript:message_form(0);'  class='style11'>New message</a></td></tr><tr>
                    <td width='33%' height='35' align='center' class='style18'>To</td>
                    <td width='33%' height='35' align='center' class='style18'>Subj</td>
                    <td width='33%' height='35' align='center' class='style18'>Date</td>
                  </tr>
";


foreach ($messages as $message)
	{
$link="";
if ($message->to_id !=0){
switch ($message->to_type){
case "#__promoters": {$link = "<a href='#msg".$message->message_id."' onclick='javascript:getpromoterInfo(".$message->to_id.");'>[promoter info]</a>";
                   break;}
default: $link ="";
 }
}
$result.="
                  <tr>
                    <td width='40%' height='35' bgcolor='white' nowrap>&nbsp;&nbsp;<a href='#' onclick='javascript:message_form(".$message->message_id.");' title='Get info on this message'><img src='images/blog-post-edit-24x24.png'  align='absmiddle' border='0'></a>&nbsp;
";

if($ss==0) $result.="<a href='#' onclick='javascript:delete_message(".$message->message_id.");' title='Delete this message'><img src='images/trash-empty-24x24.png'  align='absmiddle' border='0'></a>";
else $result.="<a href='#' onclick='javascript:message_restore(".$message->message_id.");' title='Restore this message'><img src='images/accept-24x24.png' align='absmiddle' border='0'></a>";
 $result.="&nbsp;&nbsp;&nbsp;<a class='style34' href='#' onclick='javascript:message_form(".$message->message_id.");' title='Get info on this message'>".substr($message->to_name,0,50)."&nbsp;&lt;".substr($message->to_addr,0,50)."...&gt;&nbsp;</a>".$link."</td>
  <td width='33%' bgcolor='white'><div align='center'>".$message->subject."</div></td>
  <td width='33%' bgcolor='white'><div align='center'>".$message->mesage_date."</div></td>
                  </tr>
";
}
$result.="
<tr>
<td height='35' bgcolor='#FFFFFF'>&nbsp;&nbsp;
<a href='#' onclick='javascript:message_form(0);'><img src='images/comment-add-24x24.png' align='absmiddle' border=0></a>&nbsp;&nbsp;<a href='#' onclick='javascript:message_form(0);'  class='style11'>New message</a></td>
<td height='35' colspan='2' bgcolor='#FFFFFF'><div align='center'>".$links."</div></td>
</tr></table></td></tr></table>";

return $result;
}

function sm_list($id=0, $search="",$page=0){

setcookie('prev',stripslashes($_COOKIE['now']) );
if ($id=='undefined')$id=0;
if ($search=='undefined')$search="";
if ($page=='undefined')$page=0;
setcookie('now',"href='#' onclick='javascript:sms_list(".$id.",\"".$search."\",".$page.");' ");
if (isset($id)) $ss=$id; else $ss=0;
global $_PERPAGE;
$per_page=$_PERPAGE;
$result= "";

switch  ($ss)
{
	case 0: $add=" where status >=0 "; break;
	case 1: $add=" where status= -1 "; break;
}
if ($search!="") $add=" where  a.to_name like '%".$search."%'  OR a.to_addr like '%".$search."%'";

$query2="SELECT count(*) from #__sms a ".$add." order by a.sms_id desc ";
$head="";
global $database;
$database->setQuery( "set names utf8" );
$database->query();
$database->setQuery( $query2 );
$counts = $database->loadResult();
//$result.=$query2;
$pages=ceil($counts/$per_page);
if ($page==0) $page=1;

$limits=" LIMIT ".($page-1)*$per_page.",".$per_page." ";
$paginator="<select id='paginator' name='paginator' onchange='javascript:sms_list(".$id.",\"".$search."\", this.value);'>";
for ($i=1;$i<=$pages;$i++) {
$paginator.="<option value='".$i."'";
if ($page==$i)$paginator.=" selected ";
$paginator.=">".$i."</option>";}
$paginator.="</select>";
$np=$page+1;$pp=$page-1;
if (1==$page)$links="<div align='center'><span class='style11'><img border=0 src='images/back-24x24.png' align='absmiddle'>&nbsp;prev&nbsp;page&nbsp;";
else $links="<div align='center'><a href='#' onclick='javascript:sms_list(".$id.",\"".$search."\",".$pp.");'><img border=0 src='images/back-24x24.png' align='absmiddle'></a>&nbsp;<a class='style11' href='#' onclick='javascript:sms_list(".$id.",\"".$search."\",".$pp.");'>prev&nbsp;page</a>&nbsp;";
$links.= $paginator;
if ($pages==$page)$links.="<span class='style11'>&nbsp;next&nbsp;page&nbsp;<img border=0 src='images/next-24x24.png' align='absmiddle'></span>";
else $links.="&nbsp;<a class='style11' href='#' onclick='javascript:sms_list(".$id.",\"".$search."\",".$np.");'>next&nbsp;page</a>&nbsp;<a href='#' onclick='javascript:sms_list(".$id.",\"".$search."\",".$np.");'><img border=0 src='images/next-24x24.png' align='absmiddle'></a>";
   //<div align='center'>".$paginator."&nbsp; &nbsp;next&nbsp;page&nbsp;<img border=0 src='images/next-24x24.png' align='absmiddle'></span></div>


$head="";
$messages = array();
$query="select * from #__sms a ".$add." order by a.sms_id desc ".$limits;
$database->setQuery( $query );
$messages = $database->loadObjectList();
$result.= "
  <table width='95%' border='0' align='center' cellpadding='0' cellspacing='0'>
      <tr>
        <td width='53%' class='style4'>SMS</td>
        <td width='47%' class='style4'><!--".displays_search_form(1)."--></td>
      </tr>
    </table><br />
";
$result.= "<table width='95%' border='0' align='center' cellpadding='0' cellspacing='1' bgcolor='#999999'>
              <tr>
                <td bgcolor='#999999' class='style4'><table width='100%' border='0' align='center' cellpadding='0' cellspacing='1'>
                  <tr>
                    <td height='36' colspan='1' bgcolor='#FFFFFF'>&nbsp;&nbsp;<span class='style5'>SMS Messages</span></td><td height='36' colspan='2' bgcolor='#FFFFFF'>&nbsp;&nbsp;<a href='#' onclick='javascript:sms_form(0);'><img src='images/comment-add-24x24.png' align='absmiddle' border=0></a>&nbsp;&nbsp;<a href='#' onclick='javascript:sms_form(0);'  class='style11'>New SMS</a></td></tr><tr>
                    <td width='33%' height='35' align='center' class='style18'>To</td>
                    <td width='33%' height='35' align='center' class='style18'>Subj</td>
                    <td width='33%' height='35' align='center' class='style18'>Date</td>
                  </tr>
";


foreach ($messages as $message)
	{
$link="";
if ($message->to_id !=0){
switch ($message->to_type){
case "#__promoters": {$link = "<a href='#msg".$message->sms_id."' onclick='javascript:getpromoterInfo(".$message->to_id.");'>[promoter info]</a>";
                   break;}
default: $link ="";
 }
}
$result.="
                  <tr>
                    <td width='40%' height='35' bgcolor='white' nowrap>&nbsp;&nbsp;<a href='#' onclick='javascript:sms_form(".$message->sms_id.");' title='Get info on this SMS'><img src='images/blog-post-edit-24x24.png'  align='absmiddle' border='0'></a>&nbsp;
";

if($ss==0) $result.="<a href='#' onclick='javascript:delete_sms(".$message->sms_id.");' title='Delete this message'><img src='images/trash-empty-24x24.png'  align='absmiddle' border='0'></a>";
else $result.="<a href='#' onclick='javascript:sms_restore(".$message->sms_id.");' title='Restore this message'><img src='images/accept-24x24.png' align='absmiddle' border='0'></a>";
 $result.="&nbsp;&nbsp;&nbsp;<a class='style34' href='#' onclick='javascript:sms_form(".$message->sms_id.");' title='Get info on this SMS'>".substr($message->to_name,0,50)."&nbsp;&lt;".substr($message->to_addr,0,50)."...&gt;&nbsp;</a>".$link."</td>
  <td width='33%' bgcolor='white'><div align='center'>".substr($message->mesage_body,0,30)."...</div></td>
  <td width='33%' bgcolor='white'><div align='center'>".$message->mesage_date."</div></td>
                  </tr>
";
}
$result.="
<tr>
<td height='35' bgcolor='#FFFFFF'>&nbsp;&nbsp;
<a href='#' onclick='javascript:sms_form(0);'><img src='images/comment-add-24x24.png' align='absmiddle' border=0></a>&nbsp;&nbsp;<a href='#' onclick='javascript:sms_form(0);'  class='style11'>New SMS</a></td>
<td height='35' colspan='2' bgcolor='#FFFFFF'><div align='center'>".$links."</div></td>
</tr></table></td></tr></table>";

return $result;
}


function email_selector ($type=0,$whos_id=0) {
$objResponse = new xajaxResponse('UTF-8');
$objResponse->addAssign( 'selector_div', 'innerHTML',email_selectors ($type,$whos_id));
return $objResponse->getXML();
}

function sms_selector ($type=0,$whos_id=0) {
$objResponse = new xajaxResponse('UTF-8');
$objResponse->addAssign( 'selector_div', 'innerHTML',sms_selectors ($type,$whos_id));
return $objResponse->getXML();
}

function email_selectors($type=0,$whos_id=0,$data=""){
$ee="";
global $database;
$database->setQuery( "set names utf8" );
 $database->query();
$i=0;
$typs= array ('other email','#__artists','#__promoters','#__agents','#__agency');
$typs_literal= array ('other email'=>'Other','#__artists'=>'Artists','#__promoters'=>'Promoters','#__agents'=>'Agents','#__agency'=>'Agency');
$result="To:&nbsp;&nbsp;&nbsp;<select name='selector' id='selector' onchange='javascript:email_selector(this.value,0);'>";
foreach ($typs as $typ){
 if ($type==$i) $s=" selected ";else $s="";
 $result.="<option value=".$i.$s.">".$typs_literal{$typ}."</option>";
 $i++;
}
$result.="</select>";
if (0!=$type) {

$result.="<INPUT TYPE='hidden' name='to_type' id='to_type' value='".$typs[$type]."'>";
$alist = array();
$alist[] = mosHTML::makeOption( '0', 'please, select ...', 'value', 'text'  );
$database->setQuery( "SELECT id as value, name as text FROM ".$typs[$type]."  where status >=0 ORDER BY name" );
$alist = array_merge($alist,$database->loadObjectList());
$m=mosHTML::selectList( $alist, 'whos_id', " id='whos_id' onchange='javascript:email_selector(".$type.",this.value);' ", 'value', 'text', $whos_id );
$result.=$m;
}
else $result.="<INPUT TYPE='hidden' name='to_type' id='to_type' value=''>";
$nn="";
if (0!=$whos_id){
$query="
select * from ".$typs[$type]." where id=".$whos_id;
$database->setQuery( $query );$ttt=$query;
$emails = $database->loadObjectList();
foreach ($emails as $email){}
$ee=$email->email;
$nn=$email->name;
}




if ($whos_id == -1){
$query="
select * from ".$typs[$type]." where status > 0";
$database->setQuery( $query );
$ems = $database->loadObjectList();
foreach ($ems as $em){
$ee .= $em->email.", ";
}
$ee=substr($ee,0,strlen($ee)-2);
}
if ($whos_id == -2) {
$query="select * from #__promoters p where p.id in(select s.id from #__select s where s.type='promoter' and s.value=1 and s.user=".$_COOKIE['operator_id'].")";
$database->setQuery( $query );
$promoters = $database->loadObjectList();
$ee="";
foreach($promoters as $promoter){
$ee.=" ".$promoter->name." <".$promoter->email.">, ";
}
$ee=(substr($ee,0,strlen($ee)-2));
}
if ((strlen($data)>11))$ee=$data;
$result.="&nbsp;&nbsp;<textarea name='to' rows='2' id='to' cols='70' required='1'>".$ee."</textarea>
<INPUT TYPE='hidden' name='to_name' id='to_name' value='".$nn."'>";

return $result;

}

function sms_selectors($type=0,$whos_id=0,$data=""){
$ee="";
global $database;
$database->setQuery( "set names utf8" );
 $database->query();
$i=0;
$typs= array ('other phone','#__artists','#__promoters','#__agents','#__agency',);
$result="To:&nbsp;&nbsp;&nbsp;<select name='selector' id='selector' onchange='javascript:sms_selector(this.value,0);'>";
foreach ($typs as $typ){
 if ($type==$i) $s=" selected ";else $s="";
 $result.="<option value=".$i.$s.">".$typ."</option>";
 $i++;
}
$result.="</select>";
if (0!=$type) {
$result.="<INPUT TYPE='hidden' name='to_type' id='to_type' value='".$typs[$type]."'>";
$alist = array();
$alist[] = mosHTML::makeOption( '0', 'please, select ...', 'value', 'text'  );
$database->setQuery( "SELECT id as value, name as text FROM ".$typs[$type]."  where status >=0 ORDER BY name" );
$alist = array_merge($alist,$database->loadObjectList());
$m=mosHTML::selectList( $alist, 'whos_id', " id='whos_id' onchange='javascript:sms_selector(".$type.",this.value);' ", 'value', 'text', $whos_id );
$result.=$m;
}
else $result.="<INPUT TYPE='hidden' name='to_type' id='to_type' value=''>";
$nn="";
if (0!=$whos_id){
$query="
select * from ".$typs[$type]." where id=".$whos_id;
$database->setQuery( $query );$ttt=$query;
$emails = $database->loadObjectList();
foreach ($emails as $email){}
if (strlen($email->phone2)>1) $ee .= preg_replace("/[ ()-]/", "", $email->phone2); else  $ee .= preg_replace("/[ ()-]/", "", $email->phone1);
$nn=$email->name;
}

if ($whos_id == -1){
$query="
select * from ".$typs[$type]." where status > 0";
$database->setQuery( $query );
$ems = $database->loadObjectList();
foreach ($ems as $em){
if ((strlen($em->phone2)>1)) $ee .= preg_replace("/[ ()-]/", "", $em->phone2).", "; else  $ee .= preg_replace("/[ ()-]/", "", $em->phone1).", ";
}
$ee=substr($ee,0,strlen($ee)-2);
}
if ($whos_id == -2) {
$query="select * from #__promoters p where p.id in(select s.id from #__select s where s.type='promoter' and s.value=1 and s.user=".$_COOKIE['operator_id'].")";
$database->setQuery( $query );
$promoters = $database->loadObjectList();
$ee="";
foreach($promoters as $promoter){
if ((strlen($promoter->phone2)>1)) $ee.=" ".$promoter->name." <".preg_replace("/[ ()-]/", "", $promoter->phone2).">, ";else  $ee.=" ".$promoter->name." <".preg_replace("/[ ()-]/", "", $promoter->phone1).">, ";
}
$ee=(substr($ee,0,strlen($ee)-2));
}
if ((strlen($data)>11))$ee=$data;
$result.="&nbsp;&nbsp;<textarea name='to' rows='2' id='to' cols='70' required='1'>".$ee."</textarea>
<INPUT TYPE='hidden' name='to_name' id='to_name' value='".$nn."'>";
return $result;
}

function delete_message( $id=0 ){
if(0<$id){
global $database;
$database->setQuery( "delete from #__messages where message_id=".$id );
$database->query();
}
$objResponse = new xajaxResponse('UTF-8');
$objResponse->addAssign( 'report_div', 'innerHTML', message_list(0,0));
return $objResponse->getXML();
}

function delete_sms( $id=0 ){
if(0<$id){
global $database;
$database->setQuery( "delete from #__sms where sms_id=".$id );
$database->query();
}
$objResponse = new xajaxResponse('UTF-8');
$objResponse->addAssign( 'report_div', 'innerHTML', sm_list(0,0));
return $objResponse->getXML();
}
function get_debug()
{   $result="";
// after the page reloads, print them out
if (isset($_COOKIE)) {
    foreach ($_COOKIE as $name => $value) {
     $result.= "$name : $value <br />\n";
    }
     $result.="<hr />\n";
     $result.= "sessoin :".count($_REQUEST)."<br />\n";
     $result.="<hr />\n";
     foreach ($_REQUEST as $name => $value) {
     $result.= "$name : $value <br />\n";

    }

}
$objResponse = new xajaxResponse('UTF-8');
$objResponse->addAssign( 'debug', 'innerHTML',$result);
return $objResponse->getXML();

}

function new_search($mode=0){
global $mosConfig_live_site;
setcookie('prev',stripslashes($_COOKIE['now']) );
if ($mode=='undefined')$mode=0;
setcookie('now',"href='#' onclick='javascript:new_search(".$mode.");' ");

 global $database;
		$database->setQuery( "set names utf8" );
		$database->query();

$nam= array ("Everywhere","Agent","Artist","Promoter","Itinerary", "Inquiry","Messages","Contract by promoter","Contract by artist", "Contract by artist & promoter","Contract by date","Agencies","Promoter by week number &amp; country");
$result="
<form method=post name='search_form' id='search_form'  onsubmit='return check_this_form(this);' action=\"javascript:startsearch(xajax.getFormValues('search_form'));\">

<table width='95%' border='0' align='center' cellpadding='0' cellspacing='1'>
   <tr>
        <td width='53%' class='style4'><div align='left'>Search</div></td>
        <td width='47%' class='style4'>&nbsp;</td>
    </tr>
    </table>
            <br>
      <table border='0' align='left' cellpadding='3' cellspacing='10'>
        <tr>
          <td bgcolor='#999999' class='style4'><table border='0' align='left' cellpadding='10' cellspacing='1'>
          <tr valign='top'>
            <td width='65%' bgcolor='white' valign='middle'>";
  switch ($mode)
{
case 4:{
$result.="Week N&deg;&nbsp;<input type='text' name='week_number' id='week_number' size='2' maxlenght='2'>&nbsp;&nbsp;&nbsp;";

$result.="Artist:&nbsp;";
$alist = array();
$alist[] = mosHTML::makeOption( '0', 'chose ...', 'value', 'text'  );
$database->setQuery( "SELECT id as value, name as text from #__artists  where status =0 ORDER BY name" );
$alist = array_merge($alist,$database->loadObjectList());
if (isset($id_artist)) $agnts=$id_artist; else $agnts=0;
$result.=mosHTML::selectList( $alist, 'id_artist', " id='id_artist' ", 'value', 'text', $agnts );
$result.="</td><td bgcolor='white' rowspan=2  nowrap>";
break;
}

case 7:{
$result.="Promoter:&nbsp;";
$result.="<input name='promoter_name' type='text' id='promoter_name' size='25'/>";
$result.="</td><td bgcolor='white' rowspan=2  nowrap>";
break;
}
case 8:{
$result.="Artist:&nbsp;";
$result.="<input name='artist_name' type='text' id='artist_name' size='25'/>";
$result.="</td><td bgcolor='white' rowspan=2  nowrap>";

break;
}
      /*               artist_name
case 8:{
$result.="Artist:&nbsp;";
$alist = array();
$alist[] = mosHTML::makeOption( '0', 'chose ...', 'value', 'text'  );
$database->setQuery( "SELECT id as value, name as text from #__artists  where status =0 ORDER BY name" );
$alist = array_merge($alist,$database->loadObjectList());
if (isset($id_artist)) $agnts=$id_artist; else $agnts=0;
$result.=mosHTML::selectList( $alist, 'id_artist', " id='id_artist' ", 'value', 'text', $agnts );
$result.="</td><td bgcolor='white' rowspan=2  nowrap>";
break;
}       */
case 9:{
$result.="Artist:&nbsp;";
$result.="<input name='artist_name' type='text' id='artist_name' size='25'/>";
$result.="</td><td bgcolor='white' rowspan=2  nowrap  valign='middle'>";
$result.="Promoter:&nbsp;";
$result.="<input name='promoter_name' type='text' id='promoter_name' size='25'/>";
$result.="</td><td bgcolor='white' rowspan=2  nowrap>";
/*
$result.="Artist:&nbsp;";
$alist = array();
$alist[] = mosHTML::makeOption( '0', 'chose ...', 'value', 'text'  );
$database->setQuery( "SELECT id as value, name as text from #__artists  where status =0 ORDER BY name" );
$alist = array_merge($alist,$database->loadObjectList());
if (isset($id_artist)) $agnts=$id_artist; else $agnts=0;
$result.=mosHTML::selectList( $alist, 'id_artist', " id='id_artist' ", 'value', 'text', $agnts );
$result.="</td><td bgcolor='white' rowspan=2  nowrap>";
$result.="Promoter:&nbsp;";
$alist = array();
$alist[] = mosHTML::makeOption( '0', 'chose ...', 'value', 'text'  );
$database->setQuery( "SELECT id as value, name as text from #__promoters  where status =0 ORDER BY name" );
$alist = array_merge($alist,$database->loadObjectList());
if (isset($id_artist)) $agnts=$id_artist; else $agnts=0;
$result.=mosHTML::selectList( $alist, 'id_promoter', " id='id_promoter' ", 'value', 'text', $agnts );
$result.="</td><td bgcolor='white' rowspan=2  nowrap>";
 */
break;
}

case 10:{
$result.="&nbsp;From&nbsp;<INPUT name='date_from' id='date_from' type=text style='WIDTH: 80px' value='' maxLength=10>";
$result.="&nbsp;<a href='#' onclick='javascript:cal1xx.select(document.getElementById(\"date_from\"),\"date_fromxx\",\"yyyy-MM-dd\");return false;'  NAME='date_fromxx' ID='date_fromxx'><img src='".$mosConfig_live_site."/images/itinerary-24x24.png'  align='absmiddle' border=0></a>";
$result.="</td><td bgcolor='white' rowspan=2  nowrap>";
$result.="&nbsp;&nbsp;TO&nbsp;<INPUT name='date_to' id='date_to' type=text style='WIDTH: 80px' value='' maxLength=10>";
$result.="&nbsp;<a href='#' onclick='javascript:cal1xx.select(document.getElementById(\"date_to\"),\"date_toxx\",\"yyyy-MM-dd\");return false;'  NAME='date_toxx' ID='date_toxx'><img src='".$mosConfig_live_site."/images/itinerary-24x24.png'  align='absmiddle' border=0></a>";
$result.="</td><td bgcolor='white' rowspan=2  nowrap>";
break;
}



case 12:{
  $result.="<table><td><input type='hidden' name='search_term' id='search_term' size='40' maxlenght='40' value=''>";
$result.="Week N&deg;&nbsp;<input type='text' name='weeknum' id='weeknum' size='10' maxlenght='20'>&nbsp;&nbsp;&nbsp;";
$clist = array();
$clist[] = mosHTML::makeOption( '0', '.......', 'value', 'text'  );
$database->setQuery( "SELECT id as value, name as text FROM #__countries  where  world LIKE  'europe'  ORDER BY name" );//where  world LIKE  'europe'
$clist = array_merge($clist,$database->loadObjectList());
//$m=mosHTML::selectList( $clist, 'country[]', " id='country[]' multiple='multiple' size=10  style='width:300px'", 'value', 'text', 0 );
$m=mosHTML::selectList( $clist, 'country', " id='country'  size=10  style='width:300px'", 'value', 'text', 0 );
$result.="Country</td><td rowspan='2' ><div id='countrybox'>".$m;
$result.="</div><br/><input type='checkbox' name='onlyeurope' id='onlyeurope' checked='checked' onchange='goeurope(this.checked);'> only Europe</td></tr><tr valing='bottom'><td>Location&nbsp;<input type='text' name='town' id='town' size='20' maxlenght='50'></td></tr></table></div></td><td bgcolor='white' rowspan=2  nowrap>";
break;
}

default:{
$result.="
 <input type='text' name='search_term' id='search_term' size='40' maxlenght='40' required='1'>
            </span></div></td><td bgcolor='white' nowrap  valign='middle'>";


break;}
}
     $result.="&nbsp;in&nbsp;<select name='what_find' id='what_find' onchange='javascript:new_search(this.value);'>
           ";

for ($i=0;$i<count($nam);$i++)
{
if ($mode!=$i)$result.="<option value='".$i."'>".$nam[$i]."</option>";else $result.="<option value='".$i."' selected>".$nam[$i]."</option>";
}

$result.="</select></td>";
$result.="
<td bgcolor='white'><input type='submit' value=Search align='absmiddle'></td>
</tr>";




$result.="</table></td></tr></table></form><br><div id='sch_info' name='sch_info'></div>";



$objResponse = new xajaxResponse('UTF-8');
$objResponse->addAssign( 'report_div', 'innerHTML',$result);
return $objResponse->getXML();


}
function country_box($p=0){
 global $database;
$clist = array();
$clist[] = mosHTML::makeOption( '0', '.......', 'value', 'text'  );
if($p=='false') $database->setQuery( "SELECT id as value, name as text FROM #__countries   ORDER BY name" );//where  world LIKE  'europe'
else $database->setQuery( "SELECT id as value, name as text FROM #__countries  where  world LIKE  'europe' ORDER BY name" );
$clist = array_merge($clist,$database->loadObjectList());
$m=mosHTML::selectList( $clist, 'country[]', " id='country[]' multiple='multiple' size=10 style='width:300px'", 'value', 'text', 0 );
$objResponse = new xajaxResponse('UTF-8');
$objResponse->addAssign( 'countrybox', 'innerHTML',$m);
return $objResponse->getXML();
}

function displays_search_form( $id ){

$nam= array ("EveryThing","Agent","Artist","Promoter","Sound company");
$result="
<form method=post name='search_form' id='search_form' action=\"javascript:startsearch(xajax.getFormValues('search_form'));\">
<table width='399' border='0' align='right' cellpadding='0' cellspacing='0'>
          <tr>
            <td width='65%'><div align='right'><span style='WIDTH: 150px'>
            <input type='text' name='search_term' id='search_term' size='20' maxlenght='20'>
            </span></div></td>
            <td><div align='left'>&nbsp;<a href='#' class='style2' onclick='javascript:search_form.submit();'>Search</a></div></td>
            <td>&nbsp;<span class='style2'>".$nam[$id]."</span></td>
          </tr>
        </table>
   <input type='hidden' name='xdfg' id='xdfg'>
   <input type='hidden' name='what_find' id='what_find' value='".$id."'>
</form>
";

/*
<select name='what_find' id='what_find'>
    <option value='1' selected>Agent</option>
    <option value='2'>Artist</option>
    <option value='3'>Promoter</option>
    <option value='4'>Sound company</option>
    <option value='0'>EveryThing</option>
    </select>
*/

//return $result;
return "&nbsp;";
}

function display_search_form( $id ){
$result=displays_search_form( $id );
$objResponse = new xajaxResponse('UTF-8');
$objResponse->addAssign( 'search_div', 'innerHTML', $result );
return $objResponse->getXML();

}


function startsearch($fdatas)
{
$m=1;
foreach ($fdatas as $key => $fdata) {
if(!is_array($fdatas[$key])) $fdatas[$key] = addslashes(strip_tags($fdata));
else  $fdatas[$key] = $fdata;
//$result.="'".$key."'=>'".$fdatas[$key]."'<br/>";
}
$m=$fdatas['what_find'];
if(($m!=4)&&(($m<7))){
setcookie('prev',stripslashes($_COOKIE['now']) );
setcookie('now',"href='#' onclick='javascript:startsearchs(\"".$fdatas['search_term']."\",".$fdatas['what_find'].");' ");
}


$result="";
if ($m!=4){
$result.="<div class='style11'>
<a href='#' onclick='javascript:checkbox_reader();' >
<img src='images/forward-new-mail-24x24.png' border=0 align='absmiddle'></a>
&nbsp;<a href='#' onclick='javascript:checkbox_reader();'  class='style11'>Send emails to checked</a>";
$result.="&nbsp;&nbsp;<a href='#' onclick='javascript:checkbox_checker();' class='style11'>Check All</a>";
$result.="&nbsp;&nbsp;<a href='#' onclick='javascript:checkbox_unchecker();' class='style11'>Uncheck All</a></div>";
}//$result="<div id='sss' name='sss'><h3>Search results:</h3>";
/*if ($m==12)
{
setcookie('prev',stripslashes($_COOKIE['now']) );
setcookie('now',"href='#' onclick='javascript:startsearchs(\"".$fdatas['weeknum']."\",".$fdatas['what_find'].");' ");
}
*/
if ($m==12)
{
setcookie('prev',stripslashes($_COOKIE['now']) );
setcookie('now',"href='#' onclick='javascript:startsearchs(\"".$fdatas['weeknum']."\",".$fdatas['what_find'].",\"".$fdatas['country']."\",\"".$fdatas['town']."\");' ");
}
//
//$nam= array ("Everywhere","Agent","Artist","Promoter","Itinerary", "Inquiry","Messages","Contract by promoter","Contract by artist", "Contract by artist & promoter","Contract by date");

switch ($m){
case 1: {$result.=agents_list(0,$fdatas['search_term']);break;}
case 2: {$result.=artists_list(0,$fdatas['search_term']);break;}
case 3: {$result.=promoters_list(0,$fdatas['search_term']);break;}
//case 4: {$result.=viewSchedules($fdatas['id_artist'],date("Y"),"","",$fdatas['week_number']);break;}
case 4: {$result.=get_busyday($fdatas['id_artist'],date("Y"));break;}
case 5: {$result.=inquirys_list(0,$fdatas['search_term']);break;}
case 6: {$result.=message_list(0,$fdatas['search_term']);break;}
case 7: {$result.=contracts_list(0,$fdatas['promoter_name'],0);break;}
case 8: {$result.=contracts_list(0,$fdatas['artist_name'],1);break;}
case 9: {$result.=contracts_list(0,$fdatas['artist_name']."|".$fdatas['promoter_name'],2);break;}
case 10: {$result.=contracts_list(0,$fdatas['date_from']."|".$fdatas['date_to'],3);break;}
case 11: {$result.=agencys_list(0,$fdatas['search_term']);break;}
case 12: {$result.=promoters_list(0,$fdatas['search_term'],0,$fdatas['weeknum'],$fdatas['country'],$fdatas['town']);break;}
case 0: {
$result.=agencys_list(0,$fdatas['search_term']);
$result.=agents_list(0,$fdatas['search_term']);
$result.=artists_list(0,$fdatas['search_term']);
$result.=promoters_list(0,$fdatas['search_term']);
$result.=inquirys_list(0,$fdatas['search_term']);
$result.=message_list(0,$fdatas['search_term']);
break;}
default: break;
}
//$result.="</div>";
if ($m!=4){
$result.="<div class='style11'>
<a href='#' onclick='javascript:checkbox_reader();' >
<img src='images/forward-new-mail-24x24.png' border=0 align='absmiddle'></a>
&nbsp;<a href='#' onclick='javascript:checkbox_reader();'  class='style11'>Send emails to checked</a>";
$result.="&nbsp;&nbsp;<a href='#' onclick='javascript:checkbox_checker();' class='style11'>Check All</a>";
$result.="&nbsp;&nbsp;<a href='#' onclick='javascript:checkbox_unchecker();' class='style11'>Uncheck All</a></div>";
}
$objResponse = new xajaxResponse('UTF-8');
$objResponse->addAssign( 'report_div', 'innerHTML', $result );
return $objResponse->getXML();

}

function startsearchs($what,$where,$country=0,$town="")
{
setcookie('prev',stripslashes($_COOKIE['now']) );
if($country=="Array")$country=0;
setcookie('now',"href='#' onclick='javascript:startsearchs(\"".$what."\",".$where.",".$country.",\"".$town."\");' ");
$result="";
switch ($where){
case 1: {$result.=agents_list(0,$what);break;}
case 2: {$result.=artists_list(0,$what);break;}
case 3: {$result.=promoters_list(0,$what);break;}
//case 4: {$result.=viewSchedules($fdatas['id_artist'],date("Y"),"","",$fdatas['week_number']);break;}
case 5: {$result.=inquirys_list(0,$what);break;}
case 6: {$result.=message_list(0,$what);break;}
case 12: {$result.=promoters_list(0,"",0,$what,$country,$town);break;}
//case 13: {$result.=promoters_list(0,"",0,$what);break;}

case 0: {
$result.=agents_list(0,$what);
$result.=artists_list(0,$what);
$result.=promoters_list(0,$what);
$result.=inquirys_list(0,$what);
break;}
default: break;
}
//$result.="</div>";
$objResponse = new xajaxResponse('UTF-8');
$objResponse->addAssign( 'report_div', 'innerHTML', $result );
return $objResponse->getXML();
}
function settings($id=0){
$objResponse = new xajaxResponse('UTF-8');
$objResponse->addAssign( 'report_div', 'innerHTML', setting($id) );
return $objResponse->getXML();
}
function setting($id=0){
$links = array ("Promoters",
                "Artists",
                "Agents",
                "Inquires",
                "Users",
                "Itinerary",
                "Contracts",
                "Settings",
                "Messages",
                "Search",
                "Agencies");

global $database,$mosConfig_absolute_path;$database->setQuery( "set names utf8" );$database->query();
$query=" select * from #__settings  where id=".$_COOKIE['operator_id'];
$database-> setQuery( $query );
$settings = $database->loadObjectList();
$ft = new FastTemplate($mosConfig_absolute_path."/templates");
$subm="<INPUT TYPE='submit' value='Save settings'>";
$sel="";

if (sizeof($settings)>0) {
foreach ($settings as $setting){
 $ft->define(array('body'  => "settings.tpl"));
  for ($i=0;$i<sizeof($links);$i++){
if ((isset($setting->start_id) )&&($setting->start_id ==$i)) $sel.="<option value='".$i."' selected>".$links[$i]."</option>";
else
$sel.="<option value='".$i."'>".$links[$i]."</option>";
}
    $ft->assign( array(
                    'COMPANY_NAME' => $setting->company_name,
                    'UNDERWRITER' => $setting->underwriter,
                    'BANKACCOUNT' => $setting->bankaccount,
                    'EMAIL' => $setting->email,
                    'PERPAGE' => $setting->perpage,
                    'FOOTER1'=> $setting->footer1,
                    'FOOTER2'=> $setting->footer2,
                    'SUBMIT'=> $subm,
                    'START_ID'=> $sel,
                    'ID'=> stripslashes ($_COOKIE['operator_id'])
                    ));

}
}else{
  for ($i=0;$i<sizeof($links);$i++){
if ((isset($setting->start_id) )&&($setting->start_id ==$i)) $sel.="<option value='".$i."' selected>".$links[$i]."</option>";
else
$sel.="<option value='".$i."'>".$links[$i]."</option>";
}
  $ft->define(array('body'  => "settings.tpl"));
    $ft->assign( array(
                 'COMPANY_NAME' => "",
                    'UNDERWRITER' => "",
                    'BANKACCOUNT' => "",
                    'EMAIL' => "",
                    'PERPAGE' => 10,
                    'FOOTER1'=> "",
                    'FOOTER2'=> "Haugesund, den&nbsp;___________________________<BR>",
                    'SUBMIT'=> $subm,
                    'START_ID'=> $sel,
                    'ID'=> stripslashes ($_COOKIE['operator_id'])
                    ));

}
$ft->parse('BODY', "body");
return $ft->FastPrint("BODY",true);
}

function get_settings (){
global  $database;
		$database->setQuery( "set names utf8" );
		$database->query();
$query="select * from #__settings where id=".$_COOKIE['operator_id'];
$database->setQuery($query);
$settings = $database->loadResult();
return $settings;
}

function save_settings($fdatas){

global  $database;
		$database->setQuery( "set names utf8" );
		$database->query();
foreach ($fdatas as $key => $fdata) {
//	$fdatas[$key] = addslashes(strip_tags($fdata));
	$fdatas[$key] = ($fdata);
}


$exist=0;
$query="select count(*) from #__settings";
$database->setQuery($query);
$exist = $database->loadResult();
if ($exist){
$query="
update #__settings set
                    `company_name`='".$fdatas['company_name']."',
                    `underwriter`='".$fdatas['underwriter']."',
                    `bankaccount`='".$fdatas['bankaccount']."',
                    `email`='".trim($fdatas['email'])."',
                    `footer1`='".$fdatas['footer1']."',
                    `footer2`='".$fdatas['footer2']."',
                    `perpage`=".$fdatas['perpage'].",
                    `start_id`=".$fdatas['start_id']."
                     where id=".$_COOKIE['operator_id'];
}else {
$query="
insert into #__settings ( `company_name`,
                    `underwriter`,
                    `bankaccount`,
                    `email`,
                    `footer1`, `footer2`,
                    `perpage`,
                    `start_id`,
                    `id` ) values (
                    '".$fdatas['company_name']."',
                    '".$fdatas['underwriter']."',
                    '".$fdatas['bankaccount']."',
                    '".$fdatas['email']."',
                    '".$fdatas['footer1']."',
                    '".$fdatas['footer2']."',
                    ".$fdatas['perpage'].",
                    ".$fdatas['start_id'].",
                    ".$_COOKIE['operator_id']." )";
}
$database->setQuery( $query );
$database->query();
$objResponse = new xajaxResponse('UTF-8');
$objResponse->addAssign( 'report_div', 'innerHTML',setting(0) );
return $objResponse->getXML();
}

function check_name($susp,$inn,$id=0,$link,$silent=0){
$result=""; if  ($link=='undefined')$link="";
$susp= mb_convert_encoding($susp,'utf8',"UTF-8");
$objResponse = new xajaxResponse('UTF-8');
global $database;
$database->setQuery( "set names utf8" );
$database->query();
$add="";
$add2="";

$maybe_names=explode(" ",$susp);
if (count($maybe_names)>1){
$maybe_names_exposed = array();
$add.=" ( 2 < 1 ";
foreach ($maybe_names as $maybe_name){
array_push($maybe_names_exposed, "<span style='color:red;'><b>".$maybe_name."</b></span>");
if (strlen($maybe_name)>1) $add.=" OR a.name like '%".$maybe_name."%' ";
    }
$add.=") ";
} else {
  $maybe_names=$susp;
  $maybe_names_exposed="<span style='color:red;'>".$susp."</span>";
  $add.=" a.name like '%".$susp."%' ";
}
if($id>0)$add2=" and a.id <>".$id;
$query="select count(*) from #__".$inn." a where a.status >-1 and ( ".$add." ) ".$add2;
$query2="select a.id, a.name from #__".$inn." a where a.status >-1 and ( ".$add." )".$add2;
$database->setQuery( $query );
$counts = $database->loadResult();
$suspects = array();
if ($counts>0){
if ($silent) $objResponse->addScript("if (!(confirm('We have some dupplicates! Do you want to continue?'))) hideInfo();");
$result.="<font color='red'>Possible duplicates:</font><br /><div id='check'>";
  $database->setQuery( $query2 );
  $suspects=$database->loadObjectList();
  foreach  ($suspects as $suspect){

  $suspect->name=str_ireplace($maybe_names,$maybe_names_exposed,$suspect->name);
  $result.="<a href='#' onclick='javascript:".$link."(".$suspect->id.");'>".$suspect->name."</a>&nbsp;[".$suspect->id."]<br />";
  }
  $result.="</div>";
}else   $result.="<div id='check'><font color='green'>No matches found!</font></div>";

//$result="<div id='check'><font color='green'>No matches found!</font></div>";


$objResponse->addAssign( 'check_results', 'innerHTML',$result );

return $objResponse->getXML();
}
function start_link(){
global $database;
$database->setQuery( "select start_id from #__settings where id=".$_COOKIE['operator_id'] );
$id = $database->loadResult();
global $_START_ID;
$links = array ("promoter_list();",
                "artist_list();",
                "agent_list();",
                "inquiry_list();",
                "users_list();",
                "sch_list();",
                "contract_list();",
                "settings();",
                "messages_list();",
                "new_search();",
                "agency_list();"
                );

$link="<script language='Javascript'>setTimeout('".$links[$id]."',700);</script>";
return $link;
}

function agency_list($agent_id,$search="",$page=0) {
if ($agent_id=='undefined')$agent_id=0;
if ($page=='undefined')$page=0;
if ($search=='undefined')$search="";setcookie('prev',stripslashes ($_COOKIE['now']));
setcookie('now',"href='#' onclick='javascript:agency_list(".$agent_id.",\"".$search."\",".$page.");' ");
$objResponse = new xajaxResponse('UTF-8');
$objResponse->addAssign( 'report_div', 'innerHTML', agencys_list($agent_id,$search,$page));
return $objResponse->getXML();

}
//==============================================================================================

function agencys_list($id, $search="",$page=0) {
if ($id=='undefined')$id=0;
if ($page=='undefined')$page=0;
if ($search=='undefined')$search="";

global $_PERPAGE;
$per_page=$_PERPAGE;

$result= "";
if (isset($id)) $ss=$id; else $ss=0;

switch  ($ss)
{
	case 0: $add=" where a.status >=0 "; break;
	case 1: $add=" where a.status= -1 "; break;
}
if ($search!="") $add=" where  a.name like '%".$search."%'";
 $result.= "
  <table width='95%' border='0' align='center' cellpadding='0' cellspacing='0'>
      <tr>
        <td width='53%' class='style4'>Agencies</td>
        <td width='47%' class='style4'>".displays_search_form(1)."</td>
      </tr>
    </table><br />
";

$query2="SELECT count(*) FROM #__agency a ".$add."
order by a.id desc ";

$head="";
global $database;
$database->setQuery( "set names utf8" );
$database->query();
$promoters = array();
$database->setQuery( $query2 );
$counts = $database->loadResult();
//$result.=$counts;
$pages=ceil($counts/$per_page);
if ($page==0) $page=1;
$limits=" LIMIT ".($page-1)*$per_page.",".$per_page." ";
$paginator="<select id='paginator' name='paginator' onchange='javascript:agency_list(".$id.",\"".$search."\",this.value);'>";
for ($i=1;$i<=$pages;$i++) {
$paginator.="<option value='".$i."'";
if ($page==$i)$paginator.=" selected ";
$paginator.=">".$i."</option>";}
$paginator.="</select>";
$query="SELECT * FROM #__agency a ".$add."
order by a.id desc
".$limits;
//$result.=$query;
$np=$page+1;$pp=$page-1;
if (1==$page)$links="<div align='center'><span class='style11'><img border=0 src='images/back-24x24.png' align='absmiddle'>&nbsp;prev&nbsp;page&nbsp;";
else $links="<div align='center'><a href='#' onclick='javascript:agency_list(".$id.",\"".$search."\",".$pp.");'><img border=0 src='images/back-24x24.png' align='absmiddle'></a>&nbsp;<a class='style11' href='#' onclick='javascript:agency_list(".$id.",\"".$search."\",".$pp.");'>prev&nbsp;page</a>&nbsp;";
$links.= $paginator;
if ($pages==$page)$links.="<span class='style11'>&nbsp;next&nbsp;page&nbsp;<img border=0 src='images/next-24x24.png' align='absmiddle'></span>";
else $links.="&nbsp;<a class='style11' href='#' onclick='javascript:agency_list(".$id.",\"".$search."\",".$np.");'>next&nbsp;page</a>&nbsp;<a href='#' onclick='javascript:agency_list(".$id.",\"".$search."\",".$np.");'><img border=0 src='images/next-24x24.png' align='absmiddle'></a>";
   //<div align='center'>".$paginator."&nbsp; &nbsp;next&nbsp;page&nbsp;<img border=0 src='images/next-24x24.png' align='absmiddle'></span></div>


$agents = array();
$database->setQuery( $query );
$agents = $database->loadObjectList();


if (sizeof($agents)>0)  $result.= $head;
else {
if($search)
$result.= "<table width='95%' border='0' align='center' cellpadding='0' cellspacing='1' bgcolor='#999999'>
              <tr>
                <td bgcolor='#999999' class='style4'><table width='100%' border='0' align='center' cellpadding='0' cellspacing='1'><td height='36' colspan='3' bgcolor='#FFFFFF'>
                <span class='style5'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;You search for&nbsp;<b>".$search."</b>,&nbsp;but nobody found...</span></td></TR>
                  <tr>
                    <td height='35' bgcolor='#FFFFFF'>&nbsp;&nbsp;
                    <a href='#' onclick='javascript:editagencyInfo(0);'><img src='images/comment-add-24x24.png'   align='absmiddle' border=0></a>&nbsp;&nbsp;<a href='#' onclick='javascript:editagencyInfo(0);'  class='style11'>Add New Agent</a></td>
                    <td height='35' colspan='3' bgcolor='#FFFFFF'>&nbsp;</td>
                  </tr>
                </table></td>
                  </tr>
                </table>


";
else {

 $result.= "<table width='95%' border='0' align='center' cellpadding='0' cellspacing='1' bgcolor='#999999'>
              <tr>
                <td bgcolor='#999999' class='style4'><table width='100%' border='0' align='center' cellpadding='0' cellspacing='1'>
                  <tr>
                    <td height='36' colspan='4' bgcolor='#FFFFFF'>&nbsp;&nbsp;<span class='style5'>Agencies</span>&nbsp;&nbsp;&nbsp;";

if($search) $result.="<span class='style5'>You search for:&nbsp;<b>".$search."</b></span>";
else {
                    if ($ss!=0) $result.= "<A HREF='#' onclick='javascript:agency_list(0);' class='style11'>Active</A>";else  $result.= "[<B>Active</B>]";
 $result.= "&nbsp;|&nbsp;";
if ($ss!=1) $result.= "<A HREF='#' class='style11' onclick='javascript:agency_list(1);' >Deleted</A>";else  $result.= "[<B>Deleted</B>]";
}
$result.="</td></tr>";
$result.="

                  <tr>
                    <td height='35' bgcolor='#FFFFFF'  colspan='3'>&nbsp;&nbsp;
                    <a href='#' onclick='javascript:editagencyInfo(0);'><img src='images/comment-add-24x24.png'   align='absmiddle' border=0></a>&nbsp;&nbsp;<a href='#' onclick='javascript:editagencyInfo(0);'  class='style11'>Add New Agency</a></td>
                  </tr>
                </table></td>
              </tr>
            </table>

     ";
}

return $result;
}
$result.= "<table width='95%' border='0' align='center' cellpadding='0' cellspacing='1' bgcolor='#999999'>
              <tr>
                <td bgcolor='#999999' class='style4'><table width='100%' border='0' align='center' cellpadding='0' cellspacing='1'>
                  <tr>
                    <td height='36' colspan='4' bgcolor='#FFFFFF'>&nbsp;&nbsp;<span class='style5'>Agencies</span>&nbsp;&nbsp;&nbsp;";

if($search) $result.="<span class='style5'>You search for:&nbsp;<b>".$search."</b></span>";
else {
                    if ($ss!=0) $result.= "<A HREF='#' onclick='javascript:agency_list(0);' class='style11'>Active</A>";else  $result.= "[<B>Active</B>]";
 $result.= "&nbsp;|&nbsp;";
if ($ss!=1) $result.= "<A HREF='#' class='style11' onclick='javascript:agency_list(1);' >Deleted</A>";else  $result.= "[<B>Deleted</B>]";
}
$result.="</td></tr>";
$result.="<tr><td height='36' class='style18'>Agency</td><td class='style18'>Agents</td><td class='style18'>Contact&nbsp;person</td><td class='style18'>Id</td></tr>";
foreach ($agents as $agent)
	{

$database->setQuery( "select count(*) from #__agents where id_agency=".$agent->id);
$agent_count = $database->loadResult();
$result.="
<tr><td width='45%' height='35' bgcolor='white'>&nbsp;";
if ($search) $result.="<input type='checkbox' align='absmiddle' id='agency_".$agent->id."' prop='mail' boxtype='agency' email='".$agent->email."'>&nbsp;"  ;
$result.="
<a href='#' onclick='javascript:editagencyInfo(".$agent->id.");' title='Edit info on this Agency'>
<img src='images/blog-post-edit-24x24.png'  align='absmiddle' border='0'></a>&nbsp;";

if($ss==0) $result.="<a href='#' onclick='javascript:agency_delete(".$agent->id.");' title='Delete this Agency'><img src='images/trash-empty-24x24.png'  align='absmiddle' border='0'></a>";
else { $result.="<a href='#' onclick='javascript:agency_restore(".$agent->id.");' title='Restore this Agency'><img src='images/accept-24x24.png' align='absmiddle' border='0'></a>";
$result.="&nbsp;&nbsp;<a href='#' onclick='javascript:agency_delete(".$agent->id.", 1 );' title='Delete this Agency forever!!'><img src='images/remove-24x24.png'  align='absmiddle' border='0'></a>";
}
$result.="&nbsp;&nbsp;&nbsp;<a class='style34' href='#' onclick='javascript:getagencyInfo(".$agent->id.")'>".$agent->name ."</a></td>

<td width='8%' bgcolor='white'><div align='center'><a class='style34' href='#' onclick='javascript:agent_list(0,\"\",0,".$agent->id.")'>".$agent_count."</a></div></td>
<td width='40%' bgcolor='white'><div align='center'>".$agent->contact_person."</div></td>
<td width='15%' bgcolor='white'><div align='center'>".$agent->id ."</div></td>
</tr>";
}
$result.="<tr><td height='35' bgcolor='#FFFFFF'>&nbsp;&nbsp;
<a href='#' onclick='javascript:editagencyInfo(0);'><img src='images/comment-add-24x24.png'   align='absmiddle' border=0></a>&nbsp;&nbsp;<a href='#' onclick='javascript:editagencyInfo(0);'  class='style11'>Add New Agency</a></td>
<td height='35' colspan='3' bgcolor='#FFFFFF'>".$links."</td>
</tr></table></td></tr></table>";
return  $result;
}



function agency_selector($agent_id) {
global $database,$mosConfig_absolute_path;$database->setQuery( "set names utf8" );$database->query();
$query=" select * FROM #__agency a where id=".$agent_id;
$database->setQuery( $query );
$agents = $database->loadObjectList();
$objResponse = new xajaxResponse('UTF-8');
foreach ($agents as $agent){
 $objResponse->addAssign( 'street_addr1', 'value',html_entity_decode($agent->street_addr1, ENT_NOQUOTES, 'UTF-8'));
 $objResponse->addAssign( 'street_addr2', 'value',html_entity_decode($agent->street_addr2, ENT_NOQUOTES, 'UTF-8'));
 $objResponse->addAssign( 'city_code', 'value',html_entity_decode($agent->city_code, ENT_NOQUOTES, 'UTF-8'));
 $objResponse->addAssign( 'town', 'value',html_entity_decode($agent->town, ENT_NOQUOTES, 'UTF-8'));
 $objResponse->addAssign( 'country', 'value',$agent->country);
 $objResponse->addAssign( 'phone1', 'value',$agent->phone1);
 $objResponse->addAssign( 'phone2', 'value',$agent->phone2);
 $objResponse->addAssign( 'email', 'value',$agent->email);
 $objResponse->addAssign( 'website', 'value',$agent->website);
}
return $objResponse->getXML();
}


function getagencyInfo($agent_id) {
$link="href='#' onclick='javascript:getagentInfo(".$agent_id.");' ";
setcookie('prev',stripslashes ($_COOKIE['now']));
setcookie('now',$link);

global $database,$mosConfig_absolute_path;$database->setQuery( "set names utf8" );$database->query();
$query=" select * FROM #__agency a where id=".$agent_id;
$database->setQuery( $query );
$agents = $database->loadObjectList();
foreach ($agents as $agent){
$database->setQuery( "SELECT * from #__comments  where id_source=".$agent_id."  and about='agency' order by lastupdate desc "  );
$comments = $database->loadObjectList();
$COMMENT="<table border=0 cellpadding=2 cellspacing=2 width='100%'>";
foreach ($comments as $comment){
$COMMENT.="<tr><td width='120' align='left' class='style2 sm' nowrap>".$comment->lastupdate."</td><td align='left' class='style9 sm'>".$comment->comment."</td>
<td><a href='#' onclick='javascript:delete_our_comment(".$comment->id.");' title='Delete this comment'><img src='images/del.gif' width='10' height='10' align='absmiddle' border='0'></a></td></tr>";}
$COMMENT.="</table>";

$query='select name from #__countries where id='.$agent->country;
$database->setQuery( $query );
$country = $database->loadResult();


    $ft = new FastTemplate($mosConfig_absolute_path."/templates");
    $ft->define(array('body'  => "agency_view.tpl"));
    $ft->assign( array(
                    'ID' => $agent->id,
                    'COMPANY' => $agent->name,
                    'CITYCODE' => $agent->city_code  ,
                    'CONTACTPERSON' => $agent->contact_person  ,
                    'TOWN' => $agent->town  ,
                    'ADDR1' => $agent->street_addr1  ,
                    'COUNTRY' => $country,
                    'ADDR2' => $agent->street_addr2  ,
                    'PHONE1' => $agent->phone1  ,
                    'EMAIL' => $agent->email  ,
                    'PHONE2' => $agent->phone2  ,
                    'WWW' => $agent->website  ,
                    'COMMENTS' => $COMMENT,
                    'BACK' => stripslashes ($_COOKIE['now'])
                    ));
    $ft->parse('BODY', "body");
    $result=$ft->FastPrint("BODY",true);
}
$objResponse = new xajaxResponse('UTF-8');
$objResponse->addAssign( 'report_div', 'innerHTML',$result );
return $objResponse->getXML();
}

function editagencyInfo($agent_id=0) {
global $database;
$database->setQuery( "set names utf8" );
$database->query();

if ($agent_id>0)
{
 	$agents = array();
        $qr="SELECT * FROM #__agency where id=".$agent_id ;
		$database->setQuery( $qr);
		$agents = $database->loadObjectList();
		foreach ($agents as $agent ){}
}
$today  = date("d/m/Y", mktime (0,0,0,date("m")  ,date("d"),date("Y")));
$result="
<TABLE align='center' valign='middle' width='100%' height='100%' cellpadding=0 cellspacing=0 border=0>
<TR>
	<TD>
<TABLE style='border:15px white solid;background-color: #eeeeee;' align='center' valign='middle' cellpadding=0 cellspacing=0>
<TR>
	<TD>
<TABLE class='h3' style='border:1px gray solid;background-color: #eeeeee;'><TR><td colspan=2 align='right'><button onclick='javascript:hideInfo();'><IMG SRC='/images/del.gif' WIDTH='16' HEIGHT='16' BORDER='0' ALT=''></button></td></TR>
<TR><TH colspan=2 class='h2'>Agency&nbsp;info&nbsp;№&nbsp;".$agent_id."</TH>
</TR><TR>	<TD valign='top'  class='h1'>";
$result.="<FORM METHOD=POST name='agent_form' id='agent_form' onsubmit='return check_this_form(this);' ACTION=\"javascript:agency_save(xajax.getFormValues('agent_form'));\">
<INPUT TYPE='hidden' NAME='agent_id' value='";
if (isset ($agent->id)) $result.=$agent->id; else $result.="0";
$result.="'><TABLE class='h3'><TR><TD valign='top'  class='h1'><TABLE width='99%'><TR><TH colspan=2 align=center>Agency information</TH>
</TR><TR><TD>Agency</TD><TD nowrap><INPUT TYPE='text' NAME='name' id='name' required='1'  value='";
if (isset($agent->name)) $result.=$agent->name; else $result.="";
$result.="' \">&nbsp;<a href='#' onclick=\"javascript:check_name(document.getElementById('name').value,'agency',".$agent_id.",'editagencyInfo',1);\">check&nbsp;name</a><br><div id='check_results' name='check_results'></div></TD></TR><TR><TD>Agent</TD><TD><INPUT TYPE='text' NAME='contact_person' required='1' value='";
if (isset($agent->contact_person)) $result.=$agent->contact_person; else $result.="";
$result.="'></TD></TR><TR><TD>Street address 1</TD><TD><INPUT TYPE='text' NAME='street_addr1' value='";
if (isset($agent->street_addr1)) $result.=$agent->street_addr1; else $result.="";
$result.="'></TD></TR><TR><TD>Street address 2</TD><TD><INPUT TYPE='text' NAME='street_addr2' value='";
if (isset($agent->street_addr2)) $result.=$agent->street_addr2; else $result.="";
$result.="'></TD></TR><TR><TD>City code (ZIP)</TD><TD><INPUT TYPE='text' NAME='city_code' value='";
if (isset($agent->city_code)) $result.=$agent->city_code; else $result.="";
$result.="'></TD></TR><TR><TD>Town</TD><TD><INPUT TYPE='text' NAME='town' value='";
if (isset($agent->town)) $result.=$agent->town; else $result.="";
$result.="'></TD></TR><TR><TD>Country</TD><TD>";
$clist = array();
$clist[] = mosHTML::makeOption( '0', '........', 'value', 'text'  );
$database->setQuery( "SELECT id as value, name as text FROM #__countries  ORDER BY name" );// where  world LIKE  'europe'
$clist = array_merge($clist,$database->loadObjectList());
if (isset($agent->country)) $result.=mosHTML::selectList( $clist, 'country', " id='country' ", 'value', 'text', $agent->country );
  else  $result.=mosHTML::selectList( $clist, 'country', " id='country' ", 'value', 'text', 0);
$result.="</TD></TR><TR><TD>Local phone</TD><TD><INPUT TYPE='text' NAME='phone1' id='phone1' value='";
if (isset($agent->phone1)) $result.=$agent->phone1; else $result.="";
$result.="'></TD></TR><TR><TD>Cell phone</TD><TD><INPUT TYPE='text' NAME='phone2' id='phone2' value='";
if (isset($agent->phone2)) $result.=$agent->phone2; else $result.="";
$result.="'></TD></TR><TR><TD>e-mail</TD><TD><INPUT TYPE='text' NAME='email' required='1'  email value='";
if (isset($agent->email)) $result.=$agent->email; else $result.="";
$result.="'></TD></TR><TR><TD>Website</TD><TD><INPUT TYPE='text' NAME='website' value='";
if (isset($agent->website)) $result.=$agent->website; else $result.="";
$result.="'></TD></TR>";
$result.="</TD></TR></TABLE></TD></TR><tr><td align='center' colspan=2>";
$result.="<input type='submit' value='Save' class='button'></td></tr></TABLE></FORM>";
$result.="</TD></TR></TABLE></TD>
</TR>
</TABLE></TD>
</TR>
</TABLE>
";


$objResponse = new xajaxResponse('UTF-8');
$objResponse->addAssign( 'info_div', 'innerHTML', $result );
return $objResponse->getXML();
}


function agency_save($formdata)
    {
global $database;$result="";
$database->setQuery( "set names utf8" );
$database->query();
foreach ($formdata as $key => $value) {
	$formdata[$key] = addslashes(strip_tags($value));
}
if ((isset($formdata['agent_id']))&&($formdata['agent_id']>0))
{
$update="
update #__agency set
`name` = '".$formdata['name']."',
`contact_person` = '".$formdata['contact_person']."',
`street_addr1` = '".$formdata['street_addr1']."',
`street_addr2` = '".$formdata['street_addr2']."',
`city_code` = '".$formdata['city_code']."',
`town` = '".$formdata['town']."',
`country` = '".$formdata['country']."',
`phone1` = '".$formdata['phone1']."',
`phone2` = '".$formdata['phone2']."',
 `email` = '".trim($formdata['email'])."',
 `whosupdate` = ".$_COOKIE['operator_id'].",
 `website` = '".$formdata['website']."',
 `lastupdate` = CURRENT_TIMESTAMP
where id=".$formdata['agent_id'];

}
else {

$update ="
insert into #__agency (
`name`, `contact_person`, `street_addr1`, `street_addr2`, `city_code`, `town`, `country`, `phone1`, `phone2`, `email`, `website`, `status`, `lastupdate`, `whosupdate`) values
('".$formdata['name']."', '".$formdata['contact_person']."', '".$formdata['street_addr1']."', '".$formdata['street_addr2']."', '".$formdata['city_code']."', '".$formdata['town']."', '".$formdata['country']."', '".$formdata['phone1']."', '".$formdata['phone2']."', '".trim($formdata['email'])."', '".$formdata['website']."', 0, CURRENT_TIMESTAMP,".$_COOKIE['operator_id'].")";

}

$database->setQuery( $update );
$database->query();
$result=agencys_list(0);
$objResponse = new xajaxResponse('UTF-8');
$objResponse->addAssign( 'report_div', 'innerHTML', $result );
return $objResponse->getXML();
}

function agency_delete($id,$mode=0){
global $database;
$query="update `#__agency` set status=-1 where `id`=".$id ;
if ($mode==1) $query="delete from `#__agency` where `id`=".$id ;
//echo $query;
$database->setQuery( $query);
$database->query();
$objResponse = new xajaxResponse('UTF-8');
$objResponse->addAssign( 'report_div', 'innerHTML', agencys_list(0));
return $objResponse->getXML();
}

function links_delete($id){
global $database;
$query="delete from #__links where link_id=".$id ;
$database->setQuery( $query);
$database->query();
return links_list(0);
}

function agency_restore($id){
global $database;
$query="update `#__agency` set status=0 where `id`=".$id ;
//echo $query;
$database->setQuery( $query);
$database->query();
$objResponse = new xajaxResponse('UTF-8');
$objResponse->addAssign( 'report_div', 'innerHTML', agencys_list(0));
return $objResponse->getXML();
}


function check_box_emails($boxtype)
{
global $database;
$query="select * from #__promoters p where p.id in(select s.id from #__select s where s.type='promoter' and s.value=1 and s.user=".$_COOKIE['operator_id'].")";
$database->setQuery( $query );
$promoters = $database->loadObjectList();
$result="";
foreach($promoters as $promoter){
$result.=", \"".$promoter->name."\" <".$promoter->email.">";

}
$objResponse = new xajaxResponse('UTF-8');
$objResponse->addScript(" return(".addslashes($result).");");
return $objResponse->getXML();
}

function checkbox_eraser($boxtype) {
global $database;
$query="delete from #__select where type='".$boxtype."'  and user=".$_COOKIE['operator_id'];
$database->setQuery( $query);
$database->query();
$objResponse = new xajaxResponse('UTF-8');
//$objResponse->addScript("alert('".addslashes($query)."');");
return $objResponse->getXML();
}

function check_box_saver($what,$tid,$tvalues){
global $database;
$fl=strlen($what)+1;
$ids=explode(',',$tid);

$values=explode(',',$tvalues);
$add='0'; foreach ($ids as $id){if (strlen($id)>$fl){$add.=','.substr($id,$fl);}}
$query="delete from #__select where type='".$what."' and id in (".$add.") and user=".$_COOKIE['operator_id'];
$database->setQuery( $query);
$database->query();
 $result=addslashes($query);
for ($i=0;$i<sizeof($ids);$i++) {
if (strlen($ids[$i])>$fl){
  $id=substr($ids[$i],$fl);
  $value=$values[$i]*1;
if($value>0){
$query=" insert into #__select (type,id,value,user) values ('".$what."',".$id.",".$value.",".$_COOKIE['operator_id'].")";
$database->setQuery( $query);
$database->query();
}
}

}

//$query="update `#__agency` set status=0 where `id`=".$id ;

//$result=addslashes($query);
$objResponse = new xajaxResponse('UTF-8');
//$objResponse->addScript("alert('".$result."');");
return $objResponse->getXML();
}
function get_busydays($artist_id,$year) {
$objResponse = new xajaxResponse('UTF-8');
$objResponse->addAssign( 'report_div', 'innerHTML',get_busyday($artist_id,$year));
return $objResponse->getXML();
}
function get_busyday($artist_id,$year) {
global $database;
$database->setQuery( "set names utf8" );
if ($year=='')$year=date("Y");
$database->query();
$nyear=$year+1;
$query="SELECT p.*, r.name as promoter_name  FROM #__perfomances p, #__promoters r  WHERE p.id_promoter=r.id and p.id_artist=".$artist_id." and p.date_of > '".$year."' and p.date_of < '".$nyear."' order by date_of asc";
$database->setQuery( $query);
$database->query();
$busydays = $database->loadObjectList();
//$result= $query;


$result.="<table width='95%' border='0' align='center' cellpadding='0' cellspacing='1' bgcolor='#999999'>
        <tr>
          <td bgcolor='#999999' class='style4'>
          <table width='100%' border='0' align='center' cellpadding='3' cellspacing='1'>
          <tr><th  bgcolor='#FFFFFF' class='style17'>DATE</th><th  bgcolor='#FFFFFF' class='style17'>TOWN</th><th bgcolor='#FFFFFF' class='style17'>PROMOTER</th></tr>
";

$result.="";
foreach ($busydays as $busyday ){
$vdate=explode(" ",$busyday->date_of);
if ($busyday->freeday >0){$busyday->promoter_name="<B>FREE DAY</B>";}
$result.="<tr>
                <td bgcolor='#FFFFFF' width='200' ><div style='float:left;'><a class='style17' href='#' onclick='javascript:list_performs(".$busyday->contract_id.",0);return false;'>".$vdate[0]."</a></div>";
if ($busyday->status<0) $result.= "<div style='float:right;'><sup><font color='red'>[deleted inquiry]</font></sup></div>";
$result.=                "</div></td><td bgcolor='#FFFFFF' class='style34'><div align='left'>".$busyday->city."</div></td>
                <td bgcolor='#FFFFFF' class='style34'><div align='left'>".$busyday->promoter_name."</div></td>
              </tr>";
}
$result.="</table></td></tr></table>
<div id='opt_info' name='opt_info' style='display:none;'>&nbsp;</div>
<div id='perf_info' name='perf_info' style='display:none;'>&nbsp;</div>";

return  $result;
}
function agent_selector($id_agency,$where){
global $database;
$database->setQuery( "set names utf8" );
$database->query();
$alist = array();
$alist[] = mosHTML::makeOption( '0', 'undefined ...', 'value', 'text'  );
$database->setQuery( "SELECT id as value, name as text from #__agents  where id_agency=".$id_agency." ORDER BY name" );
$alist = array_merge($alist,$database->loadObjectList());
$n=mosHTML::selectList( $alist, 'id_agent', " id='id_agent' ", 'value', 'text', $id_agency);
$objResponse = new xajaxResponse('UTF-8');
$objResponse->addAssign( $where, 'innerHTML', $n);
return $objResponse->getXML();
}
function promoter_selector($id)
{
global $database;
$database->setQuery( "set names utf8" );
$database->query();
$database->setQuery( "SELECT * from #__promoters where id=".$id );
$objResponse = new xajaxResponse('UTF-8');
if ($datas=$database->loadObjectList()) {
foreach ($datas as $data){}

$objResponse->addAssign( 'check_results', 'innerHTML','');
$objResponse->addAssign( 'company', 'value', $data->name);

$objResponse->addAssign( 'contact_person', 'value', $data->contact_person);
$objResponse->addAssign( 'street_addr1', 'value', $data->street_addr1);
$objResponse->addAssign( 'street_addr2', 'value', $data->street_addr2);
$objResponse->addAssign( 'city_code', 'value', $data->city_code);
$objResponse->addAssign( 'town', 'value', $data->town);
$objResponse->addAssign( 'country', 'value', $data->country);
$objResponse->addAssign( 'phone1', 'value', $data->phone1);
$objResponse->addAssign( 'phone2', 'value', $data->phone2);
$objResponse->addAssign( 'email', 'value', $data->email);
$objResponse->addAssign( 'website', 'value', $data->website);
$objResponse->addAssign( 'id_promoter', 'value', $id);

}
else {
$objResponse->addAssign( 'check_results', 'innerHTML','');
$objResponse->addAssign( 'contact_person', 'value', '');
$objResponse->addAssign( 'street_addr1', 'value', '');
$objResponse->addAssign( 'street_addr2', 'value', '');
$objResponse->addAssign( 'city_code', 'value', '');
$objResponse->addAssign( 'town', 'value', '');
$objResponse->addAssign( 'country', 'value', '');
$objResponse->addAssign( 'phone1', 'value', '');
$objResponse->addAssign( 'phone2', 'value', '');
$objResponse->addAssign( 'email', 'value', '');
$objResponse->addAssign( 'website', 'value','');
$objResponse->addAssign( 'id_promoter', 'value','0');


}

return $objResponse->getXML();
}



//==================================================================================================================

	$objAjax = new xajax($mosConfig_live_site."/modules/main.php","main_","utf-8", false);
	$objAjax->registerFunction('getagentInfo');
	$objAjax->registerFunction('editagentInfo');
	$objAjax->registerFunction('editartistInfo');
	$objAjax->registerFunction('getArtistInfo');
	$objAjax->registerFunction('agent_list');
	$objAjax->registerFunction('mass_mail');
	$objAjax->registerFunction('agent_save');
	$objAjax->registerFunction('artist_list');
	$objAjax->registerFunction('artist_save');
    $objAjax->registerFunction('agent_delete');
    $objAjax->registerFunction('change_template');
    $objAjax->registerFunction('list_performs');
    $objAjax->registerFunction('links_edit');
    $objAjax->registerFunction('mass_mail_queque_list');
    $objAjax->registerFunction('agent_restore');
	$objAjax->registerFunction('editinquiryInfo');
	$objAjax->registerFunction('save_inquiry');
	$objAjax->registerFunction('editinquiryInfo2');
	$objAjax->registerFunction('save_inquiry2');
	$objAjax->registerFunction('delete_Inquiry');
	$objAjax->registerFunction('add_promoter');
	$objAjax->registerFunction('inquiry_list');
	$objAjax->registerFunction('promoter_list');
	$objAjax->registerFunction('promoter_delete');
	$objAjax->registerFunction('inquiry_restore');
	$objAjax->registerFunction('inquiry_delete');
	$objAjax->registerFunction('promoter_restore');
  	$objAjax->registerFunction('mass_mail_edit_msg');
	$objAjax->registerFunction('mail_delete_msg');
 	$objAjax->registerFunction('mm_edlist');
 	$objAjax->registerFunction('mm_edqueque');

 	$objAjax->registerFunction('mm_edlistcont');
  	$objAjax->registerFunction('artist_delete');
	$objAjax->registerFunction('artist_restore');
	$objAjax->registerFunction('getpromoterInfo');
	$objAjax->registerFunction('editpromoterInfo');
	$objAjax->registerFunction('startsearch');
	$objAjax->registerFunction('startsearchs');
	$objAjax->registerFunction('save_message_template');
  	$objAjax->registerFunction('export_list_save');
	$objAjax->registerFunction('sound_list');
    $objAjax->registerFunction('sound_delete');
	$objAjax->registerFunction('sound_restore');
    $objAjax->registerFunction('users_list');
	$objAjax->registerFunction('getUserInfo');
   	$objAjax->registerFunction('mail_list_delete');
   	$objAjax->registerFunction('mail_list_cont_delete');
   	$objAjax->registerFunction('mail_list_cont_save');
	$objAjax->registerFunction('getsoundInfo');
   	$objAjax->registerFunction('editsoundInfo');
	$objAjax->registerFunction('saveUsers');
	$objAjax->registerFunction('promoter_save');
	$objAjax->registerFunction('promoter_save_geo');
	$objAjax->registerFunction('sound_save');
	$objAjax->registerFunction('display_search_form');
	$objAjax->registerFunction('viewSchedule');
	$objAjax->registerFunction('sch_list');
	$objAjax->registerFunction('getDetails');
	$objAjax->registerFunction('addPerf');
	$objAjax->registerFunction('draw_menu');
 	$objAjax->registerFunction('savePerform');
	$objAjax->registerFunction('list_deparr');
	$objAjax->registerFunction('add_deparr');
	$objAjax->registerFunction('deparr_save');
	$objAjax->registerFunction('clear_date');
	$objAjax->registerFunction('clear_dated');
 	$objAjax->registerFunction('add_contract');
  	$objAjax->registerFunction('add_contract2');
  	$objAjax->registerFunction('links_delete');
 	$objAjax->registerFunction('add_contract3');
    $objAjax->registerFunction('selectSound');
    $objAjax->registerFunction('country_box');
 	$objAjax->registerFunction('viewInquiry');
 	$objAjax->registerFunction('add_our_comment');
 	$objAjax->registerFunction('add_our_comment2');
 	$objAjax->registerFunction('mail_list_save');
 	$objAjax->registerFunction('save_our_comment');
 	$objAjax->registerFunction('save_our_comment2');
    $objAjax->registerFunction('delete_our_comment');
  	$objAjax->registerFunction('contract_list');
  	$objAjax->registerFunction('contract_delete');
  	$objAjax->registerFunction('contract_deletef');
  	$objAjax->registerFunction('contract_restore');
  	$objAjax->registerFunction('message_form');
  	$objAjax->registerFunction('sms_form');
  	$objAjax->registerFunction('message_form_contract');
  	$objAjax->registerFunction('mass_mail_view_msg');
  	$objAjax->registerFunction('send_message');
  	$objAjax->registerFunction('send_sms');
  	$objAjax->registerFunction('messages_list');
  	$objAjax->registerFunction('sms_list');
  	$objAjax->registerFunction('email_selector');
  	$objAjax->registerFunction('sms_selector');
  	$objAjax->registerFunction('delete_message');
  	$objAjax->registerFunction('delete_sms');
  	$objAjax->registerFunction('get_debug');
  	$objAjax->registerFunction('new_search');
  	$objAjax->registerFunction('settings');
  	$objAjax->registerFunction('save_settings');
  	$objAjax->registerFunction('check_name');
  	$objAjax->registerFunction('agency_list');
	$objAjax->registerFunction('getagencyInfo');
	$objAjax->registerFunction('editagencyInfo');
   	$objAjax->registerFunction('agency_save');
   	$objAjax->registerFunction('agency_delete');
   	$objAjax->registerFunction('agency_restore');
   	$objAjax->registerFunction('agent_selector');
   	$objAjax->registerFunction('agency_selector');
   	$objAjax->registerFunction('update_priority_promoter');
    $objAjax->registerFunction('links_save');
    $objAjax->registerFunction('queque_save');
    $objAjax->registerFunction('export_list');
    $objAjax->registerFunction('get_inq_coords');
    $objAjax->registerFunction('get_inq_coords2');


    $objAjax->registerFunction('links_list');
   	$objAjax->registerFunction('promoter_selector');
   	$objAjax->registerFunction('get_busydays');
   	$objAjax->registerFunction('check_box_saver');
   	$objAjax->registerFunction('check_box_emails');
   	$objAjax->registerFunction('checkbox_eraser');
   	$objAjax->registerFunction('addPerfForms');
        $objAjax->registerFunction('clear_perf');
   	$objAjax->registerFunction('send_sms_form');
    $objAjax->processRequests();
	$objAjax->printJavascript( $mosConfig_live_site."/includes/xajax/" );
?>
	<script language="javascript" type="text/javascript">
		var itemids = new Array;
        var cal_dates = 0;
          	function getagentInfo( agent_id ) {
			try {
				document.getElementById('report_div').style.display='block';
				xajaxRequestUri= '<?php echo $mosConfig_live_site; ?>/modules/main.php';
				xajaxDebug=false,xajaxStatusMessages=false,xajaxWaitCursor=true,xajaxDefinedGet=0,xajaxDefinedPost=1;
				main_getagentInfo( agent_id );
			} catch( e ) {
				alert( e );
			}
		}
        function getagencyInfo( agent_id ) {
			try {
				document.getElementById('report_div').style.display='block';
				xajaxRequestUri= '<?php echo $mosConfig_live_site; ?>/modules/main.php';
				xajaxDebug=false,xajaxStatusMessages=false,xajaxWaitCursor=true,xajaxDefinedGet=0,xajaxDefinedPost=1;
				main_getagencyInfo( agent_id );
			} catch( e ) {
				alert( e );
			}
		}



     	function editagentInfo( agent_id ) {
			try {
				document.getElementById('info_div').style.display='block';
				document.getElementById('info_div').style.width=document.body.clientWidth + 'px';
				document.getElementById('info_div').style.height=document.body.clientHeight + 'px';
                xajaxRequestUri= '<?php echo $mosConfig_live_site; ?>/modules/main.php';
				xajaxDebug=false,xajaxStatusMessages=false,xajaxWaitCursor=true,xajaxDefinedGet=0,xajaxDefinedPost=1;
				main_editagentInfo( agent_id );
			} catch( e ) {
				alert( e );
			}
		}


     	function links_edit( id ) {
			try {
				document.getElementById('info_div').style.display='block';
				document.getElementById('info_div').style.width=document.body.clientWidth + 'px';
				document.getElementById('info_div').style.height=document.body.clientHeight + 'px';
                xajaxRequestUri= '<?php echo $mosConfig_live_site; ?>/modules/main.php';
				xajaxDebug=false,xajaxStatusMessages=false,xajaxWaitCursor=true,xajaxDefinedGet=0,xajaxDefinedPost=1;
				main_links_edit( id );
			} catch( e ) {
				alert( e );
			}
		}
        function goeurope( p ) {
			try {
                xajaxRequestUri= '<?php echo $mosConfig_live_site; ?>/modules/main.php';
				xajaxDebug=false,xajaxStatusMessages=false,xajaxWaitCursor=true,xajaxDefinedGet=0,xajaxDefinedPost=1;
				main_country_box( p );
			} catch( e ) {
				alert( e );
			}
		}
        function editagencyInfo( agent_id ) {
			try {
				document.getElementById('info_div').style.display='block';
				document.getElementById('info_div').style.width=document.body.clientWidth + 'px';
				document.getElementById('info_div').style.height=document.body.clientHeight + 'px';
                xajaxRequestUri= '<?php echo $mosConfig_live_site; ?>/modules/main.php';
				xajaxDebug=false,xajaxStatusMessages=false,xajaxWaitCursor=true,xajaxDefinedGet=0,xajaxDefinedPost=1;
				main_editagencyInfo( agent_id );
			} catch( e ) {
				alert( e );
			}
		}

		function agent_list( agent_id,search,page,id_agent ) {
			try {
			  draw_menu(2);
				document.getElementById('report_div').style.display='block';
                xajaxRequestUri= '<?php echo $mosConfig_live_site; ?>/modules/main.php';
				xajaxDebug=false,xajaxStatusMessages=false,xajaxWaitCursor=true,xajaxDefinedGet=0,xajaxDefinedPost=1;
				main_agent_list( agent_id,search,page,id_agent  );
 		} catch( e ) {
				alert( e );
			}
		}


    	function getArtistInfo( artist_id ) {
			try {
                xajaxRequestUri= '<?php echo $mosConfig_live_site; ?>/modules/main.php';
				xajaxDebug=false,xajaxStatusMessages=false,xajaxWaitCursor=true,xajaxDefinedGet=0,xajaxDefinedPost=1;
                main_getArtistInfo( artist_id )
 		} catch( e ) {
				alert( e );
			}
		}
	function editartistInfo( artist_id ) {
			try {
				document.getElementById('info_div').style.display='block';
				document.getElementById('info_div').style.width=document.body.clientWidth + 'px';
				document.getElementById('info_div').style.height=document.body.clientHeight + 'px';
                xajaxRequestUri= '<?php echo $mosConfig_live_site; ?>/modules/main.php';
				xajaxDebug=false,xajaxStatusMessages=false,xajaxWaitCursor=true,xajaxDefinedGet=0,xajaxDefinedPost=1;
                main_editartistInfo( artist_id );
 		} catch( e ) {
				alert( e );
			}
		}


		function artist_list( id, search, page ) {
			try {
			    draw_menu(3);
				document.getElementById('report_div').style.display='block';
                xajaxRequestUri= '<?php echo $mosConfig_live_site; ?>/modules/main.php';
				xajaxDebug=false,xajaxStatusMessages=false,xajaxWaitCursor=true,xajaxDefinedGet=0,xajaxDefinedPost=1;
				main_artist_list( id, search, page);
 		} catch( e ) {
				alert( e );
			}
		}



		function  export_list(type,id,search,weeknum,country) {
			try {
    		document.getElementById('info_div').style.display='block';
				document.getElementById('info_div').style.width=document.body.clientWidth + 'px';
				document.getElementById('info_div').style.height=document.body.clientHeight + 'px';
                xajaxRequestUri= '<?php echo $mosConfig_live_site; ?>/modules/main.php';
				main_export_list(type,id,search,weeknum,country);
 		} catch( e ) {
				alert( e );
			}
		}


        function agency_list( id, search, page ) {
			try {
			    draw_menu(1);
				document.getElementById('report_div').style.display='block';
                xajaxRequestUri= '<?php echo $mosConfig_live_site; ?>/modules/main.php';
				xajaxDebug=false,xajaxStatusMessages=false,xajaxWaitCursor=true,xajaxDefinedGet=0,xajaxDefinedPost=1;
				main_agency_list( id, search, page);
 		} catch( e ) {
				alert( e );
			}
		}


		function promoter_list( id , search, page, weeknum, country,town, priority) {
        checkbox_writer('promoter');
        try {
			    draw_menu(0);
				document.getElementById('report_div').style.display='block';

                xajaxRequestUri= '<?php echo $mosConfig_live_site; ?>/modules/main.php';
				xajaxDebug=false,xajaxStatusMessages=false,xajaxWaitCursor=true,xajaxDefinedGet=0,xajaxDefinedPost=1;

				main_promoter_list( id, search, page, weeknum, country,town, priority );
 		} catch( e ) {
				alert( e );
			}
		}


		function selectSound( id ) {
			try {
                xajaxRequestUri= '<?php echo $mosConfig_live_site; ?>/modules/main.php';
				xajaxDebug=false,xajaxStatusMessages=false,xajaxWaitCursor=true,xajaxDefinedGet=0,xajaxDefinedPost=1;
				if(id>0) main_selectSound( id );
 		} catch( e ) {
				alert( e );
			}
		}

 		function mail_delete_msg( id ) {
			try {
			  if (confirm("Are you sure to delete this message template??")) {
				document.getElementById('report_div').style.display='block';
                xajaxRequestUri= '<?php echo $mosConfig_live_site; ?>/modules/main.php';
				xajaxDebug=false,xajaxStatusMessages=false,xajaxWaitCursor=true,xajaxDefinedGet=0,xajaxDefinedPost=1;
	            main_mail_delete_msg(id);
                }
			} catch( e ) {
				alert( e );
			}
		}

 		function links_delete( id ) {
			try {
			  if (confirm("Are you sure to delete this link??")) {
				document.getElementById('report_div').style.display='block';
                xajaxRequestUri= '<?php echo $mosConfig_live_site; ?>/modules/main.php';
				xajaxDebug=false,xajaxStatusMessages=false,xajaxWaitCursor=true,xajaxDefinedGet=0,xajaxDefinedPost=1;
	            main_links_delete(id);
                }
			} catch( e ) {
				alert( e );
			}
		}

 		function agent_delete( id, mode ) {
			try {
			  if (confirm("Are you sure to delete this agent??")) {
				document.getElementById('report_div').style.display='block';
                xajaxRequestUri= '<?php echo $mosConfig_live_site; ?>/modules/main.php';
				xajaxDebug=false,xajaxStatusMessages=false,xajaxWaitCursor=true,xajaxDefinedGet=0,xajaxDefinedPost=1;
	            if (mode == 1){
				  if (confirm("Are you sure to finally delete agent with ID="+id+" ??")) main_agent_delete(id, mode );
				} else   main_agent_delete( id, 0 );
                }
			} catch( e ) {
				alert( e );
			}
		}
 		function agency_delete( id, mode ) {
			try {
			  if (confirm("Are you sure to delete this agency??")) {
				document.getElementById('report_div').style.display='block';
                xajaxRequestUri= '<?php echo $mosConfig_live_site; ?>/modules/main.php';
				xajaxDebug=false,xajaxStatusMessages=false,xajaxWaitCursor=true,xajaxDefinedGet=0,xajaxDefinedPost=1;
	            if (mode == 1){
				  if (confirm("Are you sure to finally delete Agency with ID="+id+" ??")) main_agency_delete(id, mode );
				} else   main_agency_delete( id, 0 );
                }
			} catch( e ) {
				alert( e );
			}
		}



 	   	function update_priority_promoter( id,to_priority ) {
			try {
			    xajaxRequestUri= '<?php echo $mosConfig_live_site; ?>/modules/main.php';
				xajaxDebug=false,xajaxStatusMessages=false,xajaxWaitCursor=true,xajaxDefinedGet=0,xajaxDefinedPost=1;
				main_update_priority_promoter(id,to_priority);
			} catch( e ) {
				alert( e );
			}
		}
    	function agent_restore( id ) {
			try {
				document.getElementById('report_div').style.display='block';
                xajaxRequestUri= '<?php echo $mosConfig_live_site; ?>/modules/main.php';
				xajaxDebug=false,xajaxStatusMessages=false,xajaxWaitCursor=true,xajaxDefinedGet=0,xajaxDefinedPost=1;
				main_agent_restore( id );
			} catch( e ) {
				alert( e );
			}
		}
    	function agency_restore( id ) {
			try {
				document.getElementById('report_div').style.display='block';
                xajaxRequestUri= '<?php echo $mosConfig_live_site; ?>/modules/main.php';
				xajaxDebug=false,xajaxStatusMessages=false,xajaxWaitCursor=true,xajaxDefinedGet=0,xajaxDefinedPost=1;
				main_agency_restore( id );
			} catch( e ) {
				alert( e );
			}
		}


      	function get_inq_coords( id) {
			try {
                 xajaxRequestUri= '<?php echo $mosConfig_live_site; ?>/modules/main.php';
				 xajaxDebug=false,xajaxStatusMessages=false,xajaxWaitCursor=true,xajaxDefinedGet=0,xajaxDefinedPost=1;
                 main_get_inq_coords(id);

			} catch( e ) {
				alert( e );
			}
		}
      	function get_inq_coords2( id) {
			try {
                 xajaxRequestUri= '<?php echo $mosConfig_live_site; ?>/modules/main.php';
				 xajaxDebug=false,xajaxStatusMessages=false,xajaxWaitCursor=true,xajaxDefinedGet=0,xajaxDefinedPost=1;
                 main_get_inq_coords2(id);

			} catch( e ) {
				alert( e );
			}
		}

 		function mail_list_cont_delete(list_id, id) {
			try {
			  if (confirm("Are you sure to delete this recipient??")) {
				document.getElementById('report_div').style.display='block';
                xajaxRequestUri= '<?php echo $mosConfig_live_site; ?>/modules/main.php';
				xajaxDebug=false,xajaxStatusMessages=false,xajaxWaitCursor=true,xajaxDefinedGet=0,xajaxDefinedPost=1;
                 main_mail_list_cont_delete(list_id, id);
                }
			} catch( e ) {
				alert( e );
			}
		}

 		function mail_list_delete(id) {
			try {
			  if (confirm("Are you sure to delete this mailing list and all addresses in??")) {
				document.getElementById('report_div').style.display='block';
                xajaxRequestUri= '<?php echo $mosConfig_live_site; ?>/modules/main.php';
				xajaxDebug=false,xajaxStatusMessages=false,xajaxWaitCursor=true,xajaxDefinedGet=0,xajaxDefinedPost=1;
                 main_mail_list_delete( id);
                }
			} catch( e ) {
				alert( e );
			}
		}

        function inquiry_delete( id, mode) {
			try {
			  if (confirm("Are you sure to delete this inquiry??")) {
				document.getElementById('report_div').style.display='block';
                xajaxRequestUri= '<?php echo $mosConfig_live_site; ?>/modules/main.php';
				xajaxDebug=false,xajaxStatusMessages=false,xajaxWaitCursor=true,xajaxDefinedGet=0,xajaxDefinedPost=1;
                if (mode == 1){
				  if (confirm("Are you sure to finally delete inquiry with ID="+id+" ??")) main_inquiry_delete(id, mode );
				} else   main_inquiry_delete( id, 0 );
                }
			} catch( e ) {
				alert( e );
			}
		}
 		function inquiry_restore( id ) {
			try {
				document.getElementById('report_div').style.display='block';
                xajaxRequestUri= '<?php echo $mosConfig_live_site; ?>/modules/main.php';
				xajaxDebug=false,xajaxStatusMessages=false,xajaxWaitCursor=true,xajaxDefinedGet=0,xajaxDefinedPost=1;
				main_inquiry_restore( id );
			} catch( e ) {
				alert( e );
			}
		}
		function promoter_delete( promoter_id, mode ) {
			try {
			  if (confirm("Are you sure to delete this promoter??")) {
				document.getElementById('report_div').style.display='block';
                xajaxRequestUri= '<?php echo $mosConfig_live_site; ?>/modules/main.php';
				xajaxDebug=false,xajaxStatusMessages=false,xajaxWaitCursor=true,xajaxDefinedGet=0,xajaxDefinedPost=1;
	            if (mode == 1){
				  if (confirm("Are you sure to finally delete promoter with ID="+promoter_id+" ??")) main_promoter_delete(promoter_id, mode );
				} else   main_promoter_delete( promoter_id, 0 );
                }
			} catch( e ) {
				alert( e );
			}
		}
		function promoter_restore( promoter_id ) {
			try {
				document.getElementById('report_div').style.display='block';
                xajaxRequestUri= '<?php echo $mosConfig_live_site; ?>/modules/main.php';
				xajaxDebug=false,xajaxStatusMessages=false,xajaxWaitCursor=true,xajaxDefinedGet=0,xajaxDefinedPost=1;
				main_promoter_restore( promoter_id );
			} catch( e ) {
				alert( e );
			}
		}
		function artist_delete( artist_id , mode) {
			try {

                if (confirm("Are you sure to delete this artist??")) {
				document.getElementById('report_div').style.display='block';
                xajaxRequestUri= '<?php echo $mosConfig_live_site; ?>/modules/main.php';
				xajaxDebug=false,xajaxStatusMessages=false,xajaxWaitCursor=true,xajaxDefinedGet=0,xajaxDefinedPost=1;
				if (mode == 1){
				  if (confirm("Are you sure to finally delete artist with ID="+artist_id+" ??")) main_artist_delete( artist_id, mode );
				} else   main_artist_delete( artist_id, 0 );
                }
			} catch( e ) {
				alert( e );
			}
		}
		function artist_restore( artist_id ) {
			try {
				document.getElementById('report_div').style.display='block';
                xajaxRequestUri= '<?php echo $mosConfig_live_site; ?>/modules/main.php';
				xajaxDebug=false,xajaxStatusMessages=false,xajaxWaitCursor=true,xajaxDefinedGet=0,xajaxDefinedPost=1;
				main_artist_restore( artist_id );
			} catch( e ) {
				alert( e );
			}
		}
		function sound_delete( id ) {
			try {
			  if (confirm("Are you sure to delete this sound company??")) {
				document.getElementById('report_div').style.display='block';
                xajaxRequestUri= '<?php echo $mosConfig_live_site; ?>/modules/main.php';
				xajaxDebug=false,xajaxStatusMessages=false,xajaxWaitCursor=true,xajaxDefinedGet=0,xajaxDefinedPost=1;
				main_sound_delete( id );
                }
			} catch( e ) {
				alert( e );
			}
		}
		function sound_restore( id ) {
			try {
				document.getElementById('report_div').style.display='block';
                xajaxRequestUri= '<?php echo $mosConfig_live_site; ?>/modules/main.php';
				xajaxDebug=false,xajaxStatusMessages=false,xajaxWaitCursor=true,xajaxDefinedGet=0,xajaxDefinedPost=1;
				main_sound_restore( id );
			} catch( e ) {
				alert( e );
			}
		}

		function inquiry_list( id , search, page) {
			try {
   			     draw_menu(4);
				document.getElementById('report_div').style.display='block';
                xajaxRequestUri= '<?php echo $mosConfig_live_site; ?>/modules/main.php';
				xajaxDebug=false,xajaxStatusMessages=false,xajaxWaitCursor=true,xajaxDefinedGet=0,xajaxDefinedPost=1;
				main_inquiry_list( id , search, page);
  			} catch( e ) {
				alert( e );
			}
		}
   	function mass_mail(id,item,page) {
			try {
   			    draw_menu(12);
				document.getElementById('report_div').style.display='block';
                xajaxRequestUri= '<?php echo $mosConfig_live_site; ?>/modules/main.php';
				xajaxDebug=false,xajaxStatusMessages=false,xajaxWaitCursor=true,xajaxDefinedGet=0,xajaxDefinedPost=1;
				main_mass_mail(id,item,page);
  			} catch( e ) {
				alert( e );
			}
		}






	     function send_sms_form( phone, id , name,response, type,all ) {
			try {
	   			var s=screen.width;
				document.getElementById('info_div').style.display='block';
				document.getElementById('info_div').style.width=document.body.clientWidth + 'px';
				document.getElementById('info_div').style.height=document.body.clientHeight + 'px';
    			xajaxRequestUri= '<?php echo $mosConfig_live_site; ?>/modules/main.php';
				xajaxDebug=false,xajaxStatusMessages=false,xajaxWaitCursor=true,xajaxDefinedGet=0,xajaxDefinedPost=1;
				main_send_sms_form(  phone, id , name,response, type,all );
			} catch( e ) {
				alert( e );
			}
		}

	     function editinquiryInfo( id , promoter ) {
			try {
	   			var s=screen.width;
				document.getElementById('info_div').style.display='block';
				document.getElementById('info_div').style.width=document.body.clientWidth + 'px';
				document.getElementById('info_div').style.height=document.body.clientHeight + 'px';
    			xajaxRequestUri= '<?php echo $mosConfig_live_site; ?>/modules/main.php';
				xajaxDebug=false,xajaxStatusMessages=false,xajaxWaitCursor=true,xajaxDefinedGet=0,xajaxDefinedPost=1;
				main_editinquiryInfo( id,  promoter );
			} catch( e ) {
				alert( e );
			}
		}


        function mm_edqueque( id ) {
			try {
    			var s=screen.width;
				document.getElementById('info_div').style.display='block';
				document.getElementById('info_div').style.width=document.body.clientWidth + 'px';
				document.getElementById('info_div').style.height=document.body.clientHeight + 'px';
    			xajaxRequestUri= '<?php echo $mosConfig_live_site; ?>/modules/main.php';
				xajaxDebug=false,xajaxStatusMessages=false,xajaxWaitCursor=true,xajaxDefinedGet=0,xajaxDefinedPost=1;
				main_mm_edqueque( id );
			} catch( e ) {
				alert( e );
			}
		  }

			function editinquiryInfo2( id ) {
			try {
    			var s=screen.width;
				document.getElementById('info_div').style.display='block';
				document.getElementById('info_div').style.width=document.body.clientWidth + 'px';
				document.getElementById('info_div').style.height=document.body.clientHeight + 'px';
    			xajaxRequestUri= '<?php echo $mosConfig_live_site; ?>/modules/main.php';
				xajaxDebug=false,xajaxStatusMessages=false,xajaxWaitCursor=true,xajaxDefinedGet=0,xajaxDefinedPost=1;
				main_editinquiryInfo2( id );
			} catch( e ) {
				alert( e );
			}
		}

	  	function export_list_save(  pdate ) {
			try {
				document.getElementById('info_div').innerHTML="&nbsp;";
				document.getElementById('info_div').style.display ='none';
				xajaxRequestUri= '<?php echo $mosConfig_live_site; ?>/modules/main.php';
				xajaxDebug=false,xajaxStatusMessages=false,xajaxWaitCursor=true,xajaxDefinedGet=0,xajaxDefinedPost=1;
				main_export_list_save( pdate  );
			} catch( e ) {
				alert( e );
			}
		}
        function remove_cdate(id){
        var r = document.getElementById('datecc'+id);
        r.parentNode.removeChild(r);
        }
        function remove_cdat(id){
        var r = document.getElementById('datec'+id);
        r.parentNode.removeChild(r);
        }


        function prepare_dates(){
            var s="";
            var dates = document.getElementsByName("cdateadd");
            if (dates.length >0){
                for (var i = 0; i < dates.length; i++) {
                 if(dates[i].value != 'undefined') s = s +"|"+ dates[i].value;
                }
            document.getElementById("moredates").value=s;
           // alert(s);
 }
        }

        function add_date()
        {
       // p=Math.ceil(random()*10000);
        var add_date ="<div id='datecc"+cal_dates+"' style='margin:1px;clear:both;float:none;'><input type='text' size=20 name='cdateadd' id='cdate_"+cal_dates+"'>&nbsp;";
        add_date = add_date + "<a href='#' onclick='javascript:cal1xx.select(document.getElementById(\"cdate_"+cal_dates+"\"),\"anchor0"+cal_dates+"xx\",\"yyyy-MM-dd\");return false;' name='anchor0"+cal_dates+"xx' id='anchor0"+cal_dates+"xx'><img src='images/itinerary-24x24.png' border='0' align='absmiddle'></a>&nbsp;<a href='#' onclick='javascript:remove_cdate("+cal_dates+")' style='color:red;'><img src='images/del.gif' border='0' align='absmiddle'></a></div>";
        document.getElementById('date_container').innerHTML=document.getElementById('date_container').innerHTML+add_date;
        cal_dates = cal_dates + 1;
        }

	    function links_save( pdate ) {
			try {
				document.getElementById('info_div').innerHTML="&nbsp;";
				document.getElementById('info_div').style.display ='none';
				xajaxRequestUri= '<?php echo $mosConfig_live_site; ?>/modules/main.php';
				xajaxDebug=false,xajaxStatusMessages=false,xajaxWaitCursor=true,xajaxDefinedGet=0,xajaxDefinedPost=1;
				main_links_save( pdate );
			} catch( e ) {
				alert( e );
			}
		}


         function queque_save(  fdata ) {
			try {
				document.getElementById('info_div').innerHTML="&nbsp;";
				document.getElementById('info_div').style.display ='none';
		   		xajaxRequestUri= '<?php echo $mosConfig_live_site; ?>/modules/main.php';
				xajaxDebug=false,xajaxStatusMessages=false,xajaxWaitCursor=true,xajaxDefinedGet=0,xajaxDefinedPost=1;
				main_queque_save( fdata  );
			} catch( e ) {
				alert( e );
			}
		}
	     function save_inquiry(  pdate ) {
			try {
				document.getElementById('info_div').innerHTML="&nbsp;";
				document.getElementById('info_div').style.display ='none';
		   		xajaxRequestUri= '<?php echo $mosConfig_live_site; ?>/modules/main.php';
				xajaxDebug=false,xajaxStatusMessages=false,xajaxWaitCursor=true,xajaxDefinedGet=0,xajaxDefinedPost=1;
				main_save_inquiry( pdate  );
			} catch( e ) {
				alert( e );
			}
		}
	      function artist_save(  artist_data ) {
			try {
				document.getElementById('info_div').innerHTML="&nbsp;";
				document.getElementById('info_div').style.display ='none';
		  		xajaxRequestUri= '<?php echo $mosConfig_live_site; ?>/modules/main.php';
				xajaxDebug=false,xajaxStatusMessages=false,xajaxWaitCursor=true,xajaxDefinedGet=0,xajaxDefinedPost=1;
				main_artist_save( artist_data  );
			} catch( e ) {
				alert( e );
			}
		}



		function save_inquiry2(  pdate ) {
			try {
				document.getElementById('info_div').innerHTML="&nbsp;";
				document.getElementById('info_div').style.display ='none';
				xajaxRequestUri= '<?php echo $mosConfig_live_site; ?>/modules/main.php';
				xajaxDebug=false,xajaxStatusMessages=false,xajaxWaitCursor=true,xajaxDefinedGet=0,xajaxDefinedPost=1;
				main_save_inquiry2( pdate  );
			} catch( e ) {
				alert( e );
			}
		}
      function  change_template  (  id ) {
              try {
				if (confirm("Are you sure to change template?? All edits will be lost!")) {
			  //	document.getElementById('message').innerHTML="&nbsp;";
				xajaxRequestUri= '<?php echo $mosConfig_live_site; ?>/modules/main.php';
				xajaxDebug=false,xajaxStatusMessages=false,xajaxWaitCursor=true,xajaxDefinedGet=0,xajaxDefinedPost=1;
				main_change_template( id  );
				}
			} catch( e ) {
				alert( e );
			}
		}
		function delete_Inquiry(  id ) {
			try {
				if (confirm("Are you sure to delete this inquiry??")) {
				document.getElementById('report_div').style.display='block';
				xajaxRequestUri= '<?php echo $mosConfig_live_site; ?>/modules/main.php';
				xajaxDebug=false,xajaxStatusMessages=false,xajaxWaitCursor=true,xajaxDefinedGet=0,xajaxDefinedPost=1;
				main_delete_Inquiry( id  );
				}
			} catch( e ) {
				alert( e );
			}
		}
       function clear_date(id  ) {
			try {
				if (confirm("Are you sure to clear this date??")) {
			    xajaxRequestUri= '<?php echo $mosConfig_live_site; ?>/modules/main.php';
				xajaxDebug=false,xajaxStatusMessages=false,xajaxWaitCursor=true,xajaxDefinedGet=0,xajaxDefinedPost=1;
				main_clear_date(id );
				}
			} catch( e ) {
				alert( e );
			}
		}

    function clear_dated( id,pid ) {
			try {
				if (confirm("Are you sure to clear this date??")) {
			    xajaxRequestUri= '<?php echo $mosConfig_live_site; ?>/modules/main.php';
				xajaxDebug=false,xajaxStatusMessages=false,xajaxWaitCursor=true,xajaxDefinedGet=0,xajaxDefinedPost=1;
				main_clear_dated( id,pid );
				}
			} catch( e ) {
				alert( e );
			}
		}





     	function add_promoter(  id ) {
			try {
				document.getElementById('report_div').style.display='block';
				xajaxRequestUri= '<?php echo $mosConfig_live_site; ?>/modules/main.php';
				xajaxDebug=false,xajaxStatusMessages=false,xajaxWaitCursor=true,xajaxDefinedGet=0,xajaxDefinedPost=1;
				main_add_promoter( id  );
			} catch( e ) {
				alert( e );
			}
		}

        function add_our_comment(  id , where ) {
			try {
		   	xajaxRequestUri= '<?php echo $mosConfig_live_site; ?>/modules/main.php';
				xajaxDebug=false,xajaxStatusMessages=false,xajaxWaitCursor=true,xajaxDefinedGet=0,xajaxDefinedPost=1;
				main_add_our_comment( id , where );
			} catch( e ) {
				alert( e );
			}

          }

          function list_performs(id,pid) {
			try {
		   	xajaxRequestUri= '<?php echo $mosConfig_live_site; ?>/modules/main.php';
				xajaxDebug=false,xajaxStatusMessages=false,xajaxWaitCursor=true,xajaxDefinedGet=0,xajaxDefinedPost=1;
				main_list_performs(id,pid);
			} catch( e ) {
				alert( e );
			}
		}

       function add_our_comment2(id) {
			try {
		   	xajaxRequestUri= '<?php echo $mosConfig_live_site; ?>/modules/main.php';
				xajaxDebug=false,xajaxStatusMessages=false,xajaxWaitCursor=true,xajaxDefinedGet=0,xajaxDefinedPost=1;
				main_add_our_comment2(id);
			} catch( e ) {
				alert( e );
			}
		}

        function save_our_comment(  id ) {
			try {
		   	xajaxRequestUri= '<?php echo $mosConfig_live_site; ?>/modules/main.php';
				xajaxDebug=false,xajaxStatusMessages=false,xajaxWaitCursor=true,xajaxDefinedGet=0,xajaxDefinedPost=1;
				main_save_our_comment( id  );
			} catch( e ) {
				alert( e );
			}
		}

        function save_our_comment2(  id ) {
			try {
		   	xajaxRequestUri= '<?php echo $mosConfig_live_site; ?>/modules/main.php';
				xajaxDebug=false,xajaxStatusMessages=false,xajaxWaitCursor=true,xajaxDefinedGet=0,xajaxDefinedPost=1;
				main_save_our_comment2( id  );
			} catch( e ) {
				alert( e );
			}
		}
        function delete_our_comment(  id ) {
			try {
           if (confirm ('Are you sure to delete this comment?')){
		   	xajaxRequestUri= '<?php echo $mosConfig_live_site; ?>/modules/main.php';
				xajaxDebug=false,xajaxStatusMessages=false,xajaxWaitCursor=true,xajaxDefinedGet=0,xajaxDefinedPost=1;

				main_delete_our_comment( id  ); }
			} catch( e ) {
				alert( e );
			}
		}





    function  add_contract(id_promoter,id_artist)  {
			try {
			    draw_menu(5);
                document.getElementById('report_div').innerHTML='&nbsp;';
				document.getElementById('report_div').style.display='block';
				xajaxRequestUri= '<?php echo $mosConfig_live_site; ?>/modules/main.php';
				xajaxDebug=false,xajaxStatusMessages=false,xajaxWaitCursor=true,xajaxDefinedGet=0,xajaxDefinedPost=1;
				main_add_contract(id_promoter,id_artist);
			} catch( e ) {
				alert( e );
			}
		}



 function getpromoterInfo( id ) {
			try {
				xajaxRequestUri= '<?php echo $mosConfig_live_site; ?>/modules/main.php';
				xajaxDebug=false,xajaxStatusMessages=false,xajaxWaitCursor=true,xajaxDefinedGet=0,xajaxDefinedPost=1;
				main_getpromoterInfo( id );
			} catch( e ) {
				alert( e );
			}
		}
		function editpromoterInfo( id ) {
			try {
				document.getElementById('info_div').style.display='block';
				document.getElementById('info_div').style.width=document.body.clientWidth + 'px';
				document.getElementById('info_div').style.height=document.body.clientHeight + 'px';
                xajaxRequestUri= '<?php echo $mosConfig_live_site; ?>/modules/main.php';
				xajaxDebug=false,xajaxStatusMessages=false,xajaxWaitCursor=true,xajaxDefinedGet=0,xajaxDefinedPost=1;
				main_editpromoterInfo( id );
			} catch( e ) {
				alert( e );
			}
		}

		function startsearch( fdatas ) {
			try {
                document.getElementById('report_div').innerHTML="&nbsp;";
				document.getElementById('report_div').style.display='block';
	            xajaxRequestUri= '<?php echo $mosConfig_live_site; ?>/modules/main.php';
				xajaxDebug=false,xajaxStatusMessages=false,xajaxWaitCursor=true,xajaxDefinedGet=0,xajaxDefinedPost=1;
				main_startsearch( fdatas );
			} catch( e ) {
				alert( e );
			}
		}
		function startsearchs( what, where,country,town ) {
			try {
                document.getElementById('report_div').innerHTML="&nbsp;";
				document.getElementById('report_div').style.display='block';
	            xajaxRequestUri= '<?php echo $mosConfig_live_site; ?>/modules/main.php';
				xajaxDebug=false,xajaxStatusMessages=false,xajaxWaitCursor=true,xajaxDefinedGet=0,xajaxDefinedPost=1;
				main_startsearchs( what, where,country,town  );
			} catch( e ) {
				alert( e );
			}
		}
		function sound_list( id ) {
			try {
			    draw_menu(4);
				document.getElementById('report_div').style.display='block';
                xajaxRequestUri= '<?php echo $mosConfig_live_site; ?>/modules/main.php';
				xajaxDebug=false,xajaxStatusMessages=false,xajaxWaitCursor=true,xajaxDefinedGet=0,xajaxDefinedPost=1;
				main_sound_list( id );
			} catch( e ) {
				alert( e );
			}
		}


		function getsoundInfo(id ) {
			try {
				var s=screen.width;
				document.getElementById('info_div').style.display='block';
				document.getElementById('info_div').style.width=document.body.clientWidth + 'px';
				document.getElementById('info_div').style.height=document.body.clientHeight + 'px';
				xajaxRequestUri= '<?php echo $mosConfig_live_site; ?>/modules/main.php';
				xajaxDebug=false,xajaxStatusMessages=false,xajaxWaitCursor=true,xajaxDefinedGet=0,xajaxDefinedPost=1;
				main_getsoundInfo(id );
			} catch( e ) {
				alert( e );
			}
		}

     	function mm_edlist( id ) {
			try {
				document.getElementById('info_div').style.display='block';
				document.getElementById('info_div').style.width=document.body.clientWidth + 'px';
				document.getElementById('info_div').style.height=document.body.clientHeight + 'px';
                xajaxRequestUri= '<?php echo $mosConfig_live_site; ?>/modules/main.php';
				xajaxDebug=false,xajaxStatusMessages=false,xajaxWaitCursor=true,xajaxDefinedGet=0,xajaxDefinedPost=1;
				main_mm_edlist( id );
			} catch( e ) {
				alert( e );
			}
		}
	function mm_edlistcont( list_id, id ) {
			try {
				document.getElementById('info_div').style.display='block';
				document.getElementById('info_div').style.width=document.body.clientWidth + 'px';
				document.getElementById('info_div').style.height=document.body.clientHeight + 'px';
                xajaxRequestUri= '<?php echo $mosConfig_live_site; ?>/modules/main.php';
				xajaxDebug=false,xajaxStatusMessages=false,xajaxWaitCursor=true,xajaxDefinedGet=0,xajaxDefinedPost=1;
				main_mm_edlistcont( list_id, id );
			} catch( e ) {
				alert( e );
			}
		}

		function editsoundInfo( id ) {
			try {
				document.getElementById('info_div').style.display='block';
				document.getElementById('info_div').style.width=document.body.clientWidth + 'px';
				document.getElementById('info_div').style.height=document.body.clientHeight + 'px';
                xajaxRequestUri= '<?php echo $mosConfig_live_site; ?>/modules/main.php';
				xajaxDebug=false,xajaxStatusMessages=false,xajaxWaitCursor=true,xajaxDefinedGet=0,xajaxDefinedPost=1;
				main_editsoundInfo(id );
			} catch( e ) {
				alert( e );
			}
		}

		function add_deparr( date_of,id_artist) {
			try {
				document.getElementById('info_div').style.display='block';
				document.getElementById('info_div').style.width=document.body.clientWidth + 'px';
				document.getElementById('info_div').style.height=document.body.clientHeight + 'px';
                xajaxRequestUri= '<?php echo $mosConfig_live_site; ?>/modules/main.php';
				xajaxDebug=false,xajaxStatusMessages=false,xajaxWaitCursor=true,xajaxDefinedGet=0,xajaxDefinedPost=1;
				main_add_deparr(date_of,id_artist);
			} catch( e ) {
				alert( e );
			}
		}


   		function mass_mail_queque_list( id ) {
		try {

				document.getElementById('report_div').style.display='block';
                xajaxRequestUri= '<?php echo $mosConfig_live_site; ?>/modules/main.php';
				xajaxDebug=false,xajaxStatusMessages=false,xajaxWaitCursor=true,xajaxDefinedGet=0,xajaxDefinedPost=1;
				main_mass_mail_queque_list( id );
 		} catch( e ) {
				alert( e );
			}
		}
        function users_list( id ) {
			try {
			  draw_menu(10);
				document.getElementById('report_div').style.display='block';
                xajaxRequestUri= '<?php echo $mosConfig_live_site; ?>/modules/main.php';
				xajaxDebug=false,xajaxStatusMessages=false,xajaxWaitCursor=true,xajaxDefinedGet=0,xajaxDefinedPost=1;
				main_users_list( id );
 		} catch( e ) {
				alert( e );
			}
		}
        function links_list( id ) {
			try {
			  draw_menu(9);
				document.getElementById('report_div').style.display='block';
                xajaxRequestUri= '<?php echo $mosConfig_live_site; ?>/modules/main.php';
				xajaxDebug=false,xajaxStatusMessages=false,xajaxWaitCursor=true,xajaxDefinedGet=0,xajaxDefinedPost=1;
				main_links_list( id );
 		} catch( e ) {
				alert( e );
			}
		}


   		function viewSchedule( id_artist, yr, date_from, date_to, week ) {
			try {
				document.getElementById('report_div').style.display='block';
                xajaxRequestUri= '<?php echo $mosConfig_live_site; ?>/modules/main.php';
				xajaxDebug=false,xajaxStatusMessages=false,xajaxWaitCursor=true,xajaxDefinedGet=0,xajaxDefinedPost=1;
				main_viewSchedule( id_artist, yr, date_from, date_to, week );
                setTimeout('window.scrollTo(0,1500);',1400);
                document.getElementById('sch_info').style.display='block';

 		} catch( e ) {
				alert( e );
			}
		}
   		function sch_list( id ) {
			try {
			  draw_menu(6);
			  	document.getElementById('report_div').style.display='block';
                 setTimeout('window.scrollTo(0,1500);',1400);
                xajaxRequestUri= '<?php echo $mosConfig_live_site; ?>/modules/main.php';
				xajaxDebug=false,xajaxStatusMessages=false,xajaxWaitCursor=true,xajaxDefinedGet=0,xajaxDefinedPost=1;
				main_sch_list( id );
 		} catch( e ) {
				alert( e );
			}
		}
   		function list_deparr(date_of,id_artist ) {
			try {
			    draw_menu(6);
                setTimeout('window.scrollTo(0,1500);',1400);
                document.getElementById('opt_info').style.display='block';
                xajaxRequestUri= '<?php echo $mosConfig_live_site; ?>/modules/main.php';
				xajaxDebug=false,xajaxStatusMessages=false,xajaxWaitCursor=true,xajaxDefinedGet=0,xajaxDefinedPost=1;
				main_list_deparr( date_of, id_artist  );


 		} catch( e ) {
				alert( e );
			}
		}




		function saveUsers( userdata ) {
			try {
  			    document.getElementById('info_div').innerHTML="&nbsp;";
				document.getElementById('info_div').style.display ='none';
				document.getElementById('report_div').style.display='block';
                xajaxRequestUri= '<?php echo $mosConfig_live_site; ?>/modules/main.php';
				xajaxDebug=false,xajaxStatusMessages=false,xajaxWaitCursor=true,xajaxDefinedGet=0,xajaxDefinedPost=1;
				main_saveUsers( userdata );
			} catch( e ) {
				alert( e );
			}
		}
		function deparr_save( deparrdata ) {
			try {
  			    document.getElementById('info_div').innerHTML="&nbsp;";
				document.getElementById('info_div').style.display ='none';
				document.getElementById('opt_info').style.display='block';
                xajaxRequestUri= '<?php echo $mosConfig_live_site; ?>/modules/main.php';
				xajaxDebug=false,xajaxStatusMessages=false,xajaxWaitCursor=true,xajaxDefinedGet=0,xajaxDefinedPost=1;
				main_deparr_save( deparrdata );
			} catch( e ) {
				alert( e );
			}
		}
        function promoter_save( promoter_data ) {
			try {
  			    document.getElementById('info_div').innerHTML="&nbsp;";
				document.getElementById('info_div').style.display ='none';
				document.getElementById('report_div').style.display='block';
                xajaxRequestUri= '<?php echo $mosConfig_live_site; ?>/modules/main.php';
				xajaxDebug=false,xajaxStatusMessages=false,xajaxWaitCursor=true,xajaxDefinedGet=0,xajaxDefinedPost=1;
				main_promoter_save( promoter_data );
			} catch( e ) {
				alert( e );
			}
		}
        function promoter_save_geo( id_promoter, geo ) {
			try {
			    document.getElementById("savebutton").disabled = true;
                xajaxRequestUri= '<?php echo $mosConfig_live_site; ?>/modules/main.php';
				xajaxDebug=false,xajaxStatusMessages=false,xajaxWaitCursor=true,xajaxDefinedGet=0,xajaxDefinedPost=1;
				main_promoter_save_geo( id_promoter, geo );
			} catch( e ) {
				alert( e );
			}
		}


        function add_contract2(formdata, id_inquiry, id_contract)
        {
         	try {
         	 //  alert("!");
             //   document.getElementById('report_div').innerHTML="&nbsp;";

                xajaxRequestUri= '<?php echo $mosConfig_live_site; ?>/modules/main.php';
				xajaxDebug=false,xajaxStatusMessages=false,xajaxWaitCursor=true,xajaxDefinedGet=0,xajaxDefinedPost=1;
				main_add_contract2( formdata, id_inquiry, id_contract );
              //  document.getElementById('report_div').style.display='block';
			} catch( e ) {
				alert( e );
			}

        }
        function add_contract3(formdata)
        {
         	try {
                xajaxRequestUri= '<?php echo $mosConfig_live_site; ?>/modules/main.php';
				xajaxDebug=false,xajaxStatusMessages=false,xajaxWaitCursor=true,xajaxDefinedGet=0,xajaxDefinedPost=1;
             //  if (confirm("Make itinerary?"))
               //{main_add_contract3( formdata,1 );} else {
               main_add_contract3( formdata,0 );
               /*}*/
			} catch( e ) {
				alert( e );
			}

        }
        function add_contract4(formdata)
        {
         	try {
                xajaxRequestUri= '<?php echo $mosConfig_live_site; ?>/modules/main.php';
				xajaxDebug=false,xajaxStatusMessages=false,xajaxWaitCursor=true,xajaxDefinedGet=0,xajaxDefinedPost=1;
                main_add_contract3( formdata,0 );
			} catch( e ) {
				alert( e );
			}

        }
	function agent_save( formdata ) {
			try {
  			    document.getElementById('info_div').innerHTML="&nbsp;";
				document.getElementById('info_div').style.display ='none';
				document.getElementById('report_div').style.display='block';
                xajaxRequestUri= '<?php echo $mosConfig_live_site; ?>/modules/main.php';
				xajaxDebug=false,xajaxStatusMessages=false,xajaxWaitCursor=true,xajaxDefinedGet=0,xajaxDefinedPost=1;
				main_agent_save( formdata );
			} catch( e ) {
				alert( e );
			}
		}
	function agency_save( formdata ) {
			try {
  			    document.getElementById('info_div').innerHTML="&nbsp;";
				document.getElementById('info_div').style.display ='none';
				document.getElementById('report_div').style.display='block';
                xajaxRequestUri= '<?php echo $mosConfig_live_site; ?>/modules/main.php';
				xajaxDebug=false,xajaxStatusMessages=false,xajaxWaitCursor=true,xajaxDefinedGet=0,xajaxDefinedPost=1;
				main_agency_save( formdata );
			} catch( e ) {
				alert( e );
			}
		}
	function sound_save( sound_data ) {
			try {
  			    document.getElementById('info_div').innerHTML="&nbsp;";
				document.getElementById('info_div').style.display ='none';
				document.getElementById('report_div').style.display='block';
                xajaxRequestUri= '<?php echo $mosConfig_live_site; ?>/modules/main.php';
				xajaxDebug=false,xajaxStatusMessages=false,xajaxWaitCursor=true,xajaxDefinedGet=0,xajaxDefinedPost=1;
				main_sound_save( sound_data );
			} catch( e ) {
				alert( e );
			}
		}
 	function getUserInfo( id ) {
			try {
				var s=screen.width;
				xajaxRequestUri= '<?php echo $mosConfig_live_site; ?>/modules/main.php';
				xajaxDebug=false,xajaxStatusMessages=false,xajaxWaitCursor=true,xajaxDefinedGet=0,xajaxDefinedPost=1;
				main_getUserInfo(id );
				document.getElementById('info_div').style.display='block';
				document.getElementById('info_div').style.width=document.body.clientWidth + 'px';
				document.getElementById('info_div').style.height=document.body.clientHeight + 'px';
 		} catch( e ) {
				alert( e );
			}
		}
	function getDetails( artist_id, tdate, cont_id ) {
			try {
				var s=screen.width;
				xajaxRequestUri= '<?php echo $mosConfig_live_site; ?>/modules/main.php';
				xajaxDebug=false,xajaxStatusMessages=false,xajaxWaitCursor=true,xajaxDefinedGet=0,xajaxDefinedPost=1;
				main_getDetails( artist_id, tdate, cont_id  );
				document.getElementById('info_div').style.display='block';
				document.getElementById('info_div').style.width=document.body.clientWidth + 'px';
				document.getElementById('info_div').style.height=document.body.clientHeight + 'px';

			} catch( e ) {
				alert( e );
			}
		}
  	function addPerf( pdate ) {
			try {
				xajaxRequestUri= '<?php echo $mosConfig_live_site; ?>/modules/main.php';
				xajaxDebug=false,xajaxStatusMessages=false,xajaxWaitCursor=true,xajaxDefinedGet=0,xajaxDefinedPost=1;
				main_addPerf( pdate );
				document.getElementById('info_div').style.display='block';
				document.getElementById('info_div').style.width=document.body.clientWidth + 'px';
				document.getElementById('info_div').style.height=document.body.clientHeight + 'px';

			} catch( e ) {
				alert( e );
			}
		}
  	function addPerfForms(a,b){
			try {
				xajaxRequestUri= '<?php echo $mosConfig_live_site; ?>/modules/main.php';
				xajaxDebug=false,xajaxStatusMessages=false,xajaxWaitCursor=true,xajaxDefinedGet=0,xajaxDefinedPost=1;
				main_addPerfForms(a,b);
				document.getElementById('info_div').style.display='block';
				document.getElementById('info_div').style.width=document.body.clientWidth + 'px';
				document.getElementById('info_div').style.height=document.body.clientHeight + 'px';

			} catch( e ) {
				alert( e );
			}
		}

  	function clear_perf(a,b){
			try {
                        if (confirm("Are you sure to delete this date???")) {    
				xajaxRequestUri= '<?php echo $mosConfig_live_site; ?>/modules/main.php';
				xajaxDebug=false,xajaxStatusMessages=false,xajaxWaitCursor=true,xajaxDefinedGet=0,xajaxDefinedPost=1;
				main_clear_perf(a,b);}
			} catch( e ) {
				alert( e );
			}
		}



        function mail_list_cont_save( fdatas ) {
			try {
				xajaxRequestUri= '<?php echo $mosConfig_live_site; ?>/modules/main.php';
				xajaxDebug=false,xajaxStatusMessages=false,xajaxWaitCursor=true,xajaxDefinedGet=0,xajaxDefinedPost=1;
				main_mail_list_cont_save( fdatas );
		      document.getElementById('info_div').innerHTML="&nbsp;";
			 	document.getElementById('info_div').style.display ='none';

			} catch( e ) {
				alert( e );
			}
		}

        function mail_list_save( fdatas ) {
			try {
				xajaxRequestUri= '<?php echo $mosConfig_live_site; ?>/modules/main.php';
				xajaxDebug=false,xajaxStatusMessages=false,xajaxWaitCursor=true,xajaxDefinedGet=0,xajaxDefinedPost=1;
				main_mail_list_save( fdatas );
		      document.getElementById('info_div').innerHTML="&nbsp;";
			 	document.getElementById('info_div').style.display ='none';

			} catch( e ) {
				alert( e );
			}
		}

  	function savePerform( fdatas ) {
			try {
				xajaxRequestUri= '<?php echo $mosConfig_live_site; ?>/modules/main.php';
				xajaxDebug=false,xajaxStatusMessages=false,xajaxWaitCursor=true,xajaxDefinedGet=0,xajaxDefinedPost=1;
		                document.getElementById('info_div').innerHTML="&nbsp;";
			 	document.getElementById('info_div').style.display ='none';
                                main_savePerform( fdatas );

			} catch( e ) {
				alert( e );
			}
		}

 	function display_search_form( id ) {
      		try {
    			xajaxRequestUri= '<?php echo $mosConfig_live_site; ?>/modules/main.php';
				xajaxDebug=false,xajaxStatusMessages=false,xajaxWaitCursor=true,xajaxDefinedGet=0,xajaxDefinedPost=1;
				main_display_search_form( id );
                document.getElementById('search_div').style.display='block';
 		} catch( e ) {
				alert( e );
			}
		}

  	function  viewInquiry( id ) {
      		try {
    			xajaxRequestUri= '<?php echo $mosConfig_live_site; ?>/modules/main.php';
				xajaxDebug=false,xajaxStatusMessages=false,xajaxWaitCursor=true,xajaxDefinedGet=0,xajaxDefinedPost=1;
				main_viewInquiry( id );
                document.getElementById('report_div').style.display='block';
 		} catch( e ) {
				alert( e );
			}
		}
  	function  contract_list( id ) {
      		try {
      		    draw_menu(5);
    			xajaxRequestUri= '<?php echo $mosConfig_live_site; ?>/modules/main.php';
				xajaxDebug=false,xajaxStatusMessages=false,xajaxWaitCursor=true,xajaxDefinedGet=0,xajaxDefinedPost=1;
				main_contract_list( id );
                document.getElementById('report_div').style.display='block';
 		} catch( e ) {
				alert( e );
			}
		}
  	function  get_busydays( artist_id, year ) {
      		try {
      		   // draw_menu(5);
    			xajaxRequestUri= '<?php echo $mosConfig_live_site; ?>/modules/main.php';
				xajaxDebug=false,xajaxStatusMessages=false,xajaxWaitCursor=true,xajaxDefinedGet=0,xajaxDefinedPost=1;
				main_get_busydays(  artist_id, year );
                document.getElementById('sch_info').style.display='block';
 		} catch( e ) {
				alert( e );
			}
		}


   	function  messages_list( id, search, page ) {
      		try {
      		    draw_menu(7);
    			xajaxRequestUri= '<?php echo $mosConfig_live_site; ?>/modules/main.php';
				xajaxDebug=false,xajaxStatusMessages=false,xajaxWaitCursor=true,xajaxDefinedGet=0,xajaxDefinedPost=1;
				main_messages_list( id, search, page );
                document.getElementById('report_div').style.display='block';
 		} catch( e ) {
				alert( e );
			}
		}

 	function  sms_list( id, search, page ) {
      		try {
      		    draw_menu(13);
    			xajaxRequestUri= '<?php echo $mosConfig_live_site; ?>/modules/main.php';
				xajaxDebug=false,xajaxStatusMessages=false,xajaxWaitCursor=true,xajaxDefinedGet=0,xajaxDefinedPost=1;
				main_sms_list( id, search, page );
                document.getElementById('report_div').style.display='block';
 		} catch( e ) {
				alert( e );
			}
		}



	function  mass_mail_view_msg(id) {
     		try {
    			xajaxRequestUri= '<?php echo $mosConfig_live_site; ?>/modules/main.php';
				xajaxDebug=false,xajaxStatusMessages=false,xajaxWaitCursor=true,xajaxDefinedGet=0,xajaxDefinedPost=1;
				main_mass_mail_view_msg(id);
                document.getElementById('report_div').style.display='block';
 		} catch( e ) {
				alert( e );
			}
	}

    function  mass_mail_edit_msg(id) {
     		try {
    			xajaxRequestUri= '<?php echo $mosConfig_live_site; ?>/modules/main.php';
				xajaxDebug=false,xajaxStatusMessages=false,xajaxWaitCursor=true,xajaxDefinedGet=0,xajaxDefinedPost=1;
				main_mass_mail_edit_msg(id);
                document.getElementById('report_div').style.display='block';
 		} catch( e ) {
				alert( e );
			}
	}
  	function  message_form( message_id, to_type, to_id, data, who ) {
      		try {
      		    draw_menu(7);
    			xajaxRequestUri= '<?php echo $mosConfig_live_site; ?>/modules/main.php';
				xajaxDebug=false,xajaxStatusMessages=false,xajaxWaitCursor=true,xajaxDefinedGet=0,xajaxDefinedPost=1;
				main_message_form( message_id, to_type, to_id ,data,who );
                document.getElementById('report_div').style.display='block';
 		} catch( e ) {
				alert( e );
			}
		}
	function  sms_form( message_id, to_type, to_id, data, who ) {
      		try {
      		    draw_menu(12);
    			xajaxRequestUri= '<?php echo $mosConfig_live_site; ?>/modules/main.php';
				xajaxDebug=false,xajaxStatusMessages=false,xajaxWaitCursor=true,xajaxDefinedGet=0,xajaxDefinedPost=1;
				main_sms_form( message_id, to_type, to_id ,data,who );
                document.getElementById('report_div').style.display='block';
 		} catch( e ) {
				alert( e );
			}
		}

	function  message_form_contract( message_id, to_type, to_id, data, id ) {
      		try {
      		    draw_menu(7);
    			xajaxRequestUri= '<?php echo $mosConfig_live_site; ?>/modules/main.php';
				xajaxDebug=false,xajaxStatusMessages=false,xajaxWaitCursor=true,xajaxDefinedGet=0,xajaxDefinedPost=1;
				main_message_form_contract( message_id, to_type, to_id, data, id );
                document.getElementById('report_div').style.display='block';
 		} catch( e ) {
				alert( e );
			}
		}


 function  save_message_template(formdata) {
      		try {
      		    draw_menu(8);
    			xajaxRequestUri= '<?php echo $mosConfig_live_site; ?>/modules/main.php';
				xajaxDebug=false,xajaxStatusMessages=false,xajaxWaitCursor=true,xajaxDefinedGet=0,xajaxDefinedPost=1;
             //   document.getElementById('sendbutton').style.display='none';
               // document.getElementById('waitsend').style.display='block';
                main_save_message_template(formdata);
                document.getElementById('report_div').style.display='block';
 		} catch( e ) {
				alert( e );
			}
		}

	function  send_message(formdata) {
      		try {
      		    draw_menu(8);
    			xajaxRequestUri= '<?php echo $mosConfig_live_site; ?>/modules/main.php';
				xajaxDebug=false,xajaxStatusMessages=false,xajaxWaitCursor=true,xajaxDefinedGet=0,xajaxDefinedPost=1;
                if(document.getElementById('waitsend')){
                document.getElementById('sendbutton').style.display='none';
                document.getElementById('waitsend').style.display='block';}
                main_send_message(formdata);
                document.getElementById('report_div').style.display='block';
 		} catch( e ) {
				alert( e );
			}
		}

	function  send_sms(formdata) {
      		try {
      		    draw_menu(12);
    			xajaxRequestUri= '<?php echo $mosConfig_live_site; ?>/modules/main.php';
				xajaxDebug=false,xajaxStatusMessages=false,xajaxWaitCursor=true,xajaxDefinedGet=0,xajaxDefinedPost=1;
                if(document.getElementById('waitsend')){
                document.getElementById('sendbutton').style.display='none';
                document.getElementById('waitsend').style.display='block';}
                main_send_sms(formdata);
                document.getElementById('report_div').style.display='block';
 		} catch( e ) {
				alert( e );
			}
		}
 	function  contract_delete( id ) {
      		try {

                if (confirm("Are you sure to delete this contract??")) {
    			xajaxRequestUri= '<?php echo $mosConfig_live_site; ?>/modules/main.php';
				xajaxDebug=false,xajaxStatusMessages=false,xajaxWaitCursor=true,xajaxDefinedGet=0,xajaxDefinedPost=1;
				main_contract_delete( id );
                document.getElementById('report_div').style.display='block';
                }
 		} catch( e ) {
				alert( e );
			}
		}
 	function  contract_deletef( id ) {
      		try {

                if (confirm("Are you sure to delete this contract FOREVER!!??")) {
    			xajaxRequestUri= '<?php echo $mosConfig_live_site; ?>/modules/main.php';
				xajaxDebug=false,xajaxStatusMessages=false,xajaxWaitCursor=true,xajaxDefinedGet=0,xajaxDefinedPost=1;
				main_contract_deletef( id );
                document.getElementById('report_div').style.display='block';
                }
 		} catch( e ) {
				alert( e );
			}
		}
 	function  contract_restore( id ) {
      		try {
      		    draw_menu(6);
    			xajaxRequestUri= '<?php echo $mosConfig_live_site; ?>/modules/main.php';
				xajaxDebug=false,xajaxStatusMessages=false,xajaxWaitCursor=true,xajaxDefinedGet=0,xajaxDefinedPost=1;
				main_contract_restore( id );
                document.getElementById('report_div').style.display='block';
 		} catch( e ) {
				alert( e );
			}
		}
    function hideInfo( ) {
			try {
                document.getElementById('info_div').innerHTML="&nbsp;";
			 	document.getElementById('info_div').style.display ='none';
			} catch( e ) {
				alert( e );
			}
		}

	function hideInfo2( ) {
			try {
                document.getElementById('info_div').innerHTML="&nbsp;";
			 	document.getElementById('info_div').style.display ='none';
                main_inquiry_list( 0 );
			} catch( e ) {
				alert( e );
			}
		}


function replaceDiv( div )
{
if (CKEDITOR.instances[div]){
//CKEDITOR.instances.message.destroy();

CKEDITOR.remove(CKEDITOR.instances[div]);
}
ckeditor = CKEDITOR.replace(div);
AjexFileManager.init({
	returnTo: 'ckeditor',
	editor: ckeditor,
	skin: 'light',
        lang: 'en'
});
}
  function agent_selector(id_agency,where)
    {
 	try {
    			xajaxRequestUri= '<?php echo $mosConfig_live_site; ?>/modules/main.php';
				xajaxDebug=false,xajaxStatusMessages=false,xajaxWaitCursor=true,xajaxDefinedGet=0,xajaxDefinedPost=1;
				main_agent_selector(id_agency,where);
			} catch( e ) {
				alert( e );
			}
    }
  function agency_selector(id_agency)
    {
 	try {
    			xajaxRequestUri= '<?php echo $mosConfig_live_site; ?>/modules/main.php';
				xajaxDebug=false,xajaxStatusMessages=false,xajaxWaitCursor=true,xajaxDefinedGet=0,xajaxDefinedPost=1;
				main_agency_selector(id_agency);
			} catch( e ) {
				alert( e );
			}
    }

  function email_selector(type,whos_id)
    {
 	try {
    			xajaxRequestUri= '<?php echo $mosConfig_live_site; ?>/modules/main.php';
				xajaxDebug=false,xajaxStatusMessages=false,xajaxWaitCursor=true,xajaxDefinedGet=0,xajaxDefinedPost=1;
				main_email_selector(type,whos_id);
			} catch( e ) {
				alert( e );
			}
    }
  function sms_selector(type,whos_id)
    {
 	try {
    			xajaxRequestUri= '<?php echo $mosConfig_live_site; ?>/modules/main.php';
				xajaxDebug=false,xajaxStatusMessages=false,xajaxWaitCursor=true,xajaxDefinedGet=0,xajaxDefinedPost=1;
				main_sms_selector(type,whos_id);
			} catch( e ) {
				alert( e );
			}
    }
   		function delete_message(id) {
			try {
				if (confirm("Are you sure to delete this message??")) {
				xajaxRequestUri= '<?php echo $mosConfig_live_site; ?>/modules/main.php';
				xajaxDebug=false,xajaxStatusMessages=false,xajaxWaitCursor=true,xajaxDefinedGet=0,xajaxDefinedPost=1;
				main_delete_message(id);
				}
			} catch( e ) {
				alert( e );
			}
		}

		function delete_sms(id) {
			try {
				if (confirm("Are you sure to delete this message??")) {
				xajaxRequestUri= '<?php echo $mosConfig_live_site; ?>/modules/main.php';
				xajaxDebug=false,xajaxStatusMessages=false,xajaxWaitCursor=true,xajaxDefinedGet=0,xajaxDefinedPost=1;
				main_delete_sms(id);
				}
			} catch( e ) {
				alert( e );
			}
		}


 function draw_menu(id)
    {
 	try {
    			xajaxRequestUri= '<?php echo $mosConfig_live_site; ?>/modules/main.php';
				xajaxDebug=false,xajaxStatusMessages=false,xajaxWaitCursor=true,xajaxDefinedGet=0,xajaxDefinedPost=1;
				main_draw_menu( id );
			} catch( e ) {
				alert( e );
			}
    }
 function get_debug( )
    {
 	try {
    			xajaxRequestUri= '<?php echo $mosConfig_live_site; ?>/modules/main.php';
				xajaxDebug=false,xajaxStatusMessages=false,xajaxWaitCursor=true,xajaxDefinedGet=0,xajaxDefinedPost=1;
				main_get_debug( );
			} catch( e ) {
				alert( e );
			}
    }
 function swap_promoters(mode) {
  	try {
    if(mode){
    document.getElementById('id_promoter').style.display='none';
    document.getElementById('link_new').style.display='none';
    document.getElementById('link_old').style.display='';
    document.getElementById('company').style.display='';
    document.getElementById('check_link').style.display='';

    get_promoter_data (0);
    }else{
    document.getElementById('id_promoter').style.display='';
    document.getElementById('link_new').style.display='';
    document.getElementById('link_old').style.display='none';
    document.getElementById('company').style.display='none';
    document.getElementById('check_link').style.display='none';

    get_promoter_data (document.getElementById('id_promoter').value);

    }
   	} catch( e ) {
				alert( e );
			}

 }
 function get_promoter_data(id) {
 try {
   // alert(id);
   main_promoter_selector(id);
 } catch( e ) {
				alert( e );
			}
 }

 function new_search( mode )
    {
 	try {
 	            draw_menu(8);
    			xajaxRequestUri= '<?php echo $mosConfig_live_site; ?>/modules/main.php';
				xajaxDebug=false,xajaxStatusMessages=false,xajaxWaitCursor=true,xajaxDefinedGet=0,xajaxDefinedPost=1;
                document.getElementById('report_div').innerHTML="&nbsp;";
				main_new_search( mode );
			} catch( e ) {
				alert( e );
			}
    }
 function settings( id )
    {
 	try {
 	            draw_menu(11);
    			xajaxRequestUri= '<?php echo $mosConfig_live_site; ?>/modules/main.php';
				xajaxDebug=false,xajaxStatusMessages=false,xajaxWaitCursor=true,xajaxDefinedGet=0,xajaxDefinedPost=1;
                document.getElementById('report_div').innerHTML="&nbsp;";
				main_settings( id );
			} catch( e ) {
				alert( e );
			}
    }
function save_settings( fdatas )
    {
 	try {
 	            xajaxRequestUri= '<?php echo $mosConfig_live_site; ?>/modules/main.php';
				xajaxDebug=false,xajaxStatusMessages=false,xajaxWaitCursor=true,xajaxDefinedGet=0,xajaxDefinedPost=1;
                document.getElementById('report_div').innerHTML="&nbsp;";
				main_save_settings( fdatas );
			} catch( e ) {
				alert( e );
			}
    }
function check_name( susp, inn, id, link, silent)
    {
 	try {
 	            xajaxRequestUri= '<?php echo $mosConfig_live_site; ?>/modules/main.php';
				xajaxDebug=false,xajaxStatusMessages=false,xajaxWaitCursor=true,xajaxDefinedGet=0,xajaxDefinedPost=1;
                document.getElementById('check_results').innerHTML="&nbsp;";
                main_check_name( susp, inn ,id, link, silent);
			} catch( e ) {
				alert( e );
			}
    }
function hideopt(val) {
try {
   if (val==0) {
                document.getElementById('newlistname').style.display="";
                } else {
                document.getElementById('newlistname').style.display="none";
               }
    } catch( e ) {
				alert( e );
	}
}
function check_this_form(f){
  var errMSG = "";

  var reg_mail = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,4})+$/;
  var reg_week = /^\d{1,2}$/;

//  var reg_mail = /((?>[a-zA-Z\d!#$%&'*+\-/=?^_`{|}~]+\x20*|"((?=[\x01-\x7f])[^"\\]|\\[\x01-\x7f])*"\x20*)*(?<angle><))?((?!\.)(?>\.?[a-zA-Z\d!#$%&'*+\-/=?^_`{|}~]+)+|"((?=[\x01-\x7f])[^"\\]|\\[\x01-\x7f])*")@(((?!-)[a-zA-Z\d\-]+(?<!-)\.)+[a-zA-Z]{2,}|\[(((?(?<!\[)\.)(25[0-5]|2[0-4]\d|[01]?\d?\d)){4}|[a-zA-Z\d\-]*[a-zA-Z\d]:((?=[\x01-\x7f])[^\\\[\]]|\\[\x01-\x7f])+)\])(?(angle)>)$/i;
/*
 unction checK(f) {
  if (!(/^\d{2}\.?\d{2}\.?\d{2}$/.test(f.dater.value))) {
       alert('Дата в формате дд.мм.гг.\nисправляем');
       f.dater.select()
       return false
  }
  if (!(/^\D{2,10}\b\D{2,10}$/.test(f.fio.value))) {
       alert('Имя и Фамилия - 2 слова без цифр \от 2 до 10 символов\nисправляем');f.fio.select();
       return false;
  }
  if (f.email.value=='') {alert("не... мыло надо написать");f.email.focus();return false}
  if (!(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,4})+$/.test(f.email.value))) {
       alert('такое мыло не пойдет.\nисправляем');f.email.select()
       return false
  }
  if (!(/^\d{6}$/.test(f.chip.value))) {
       alert('Номер  состоит из 6 цифр.\nисправляем');
       f.chip.select();
       return false;
  }


*/

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
       if ((null!=f.elements[i].getAttribute("week"))&&(reg_week.exec(f.elements[i].value) == null))    //&&((f.elements[i].value * 1 ) > 54)
            {
                  errMSG += " Invalid week number  " + f.elements[i].name + "\n";
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


function checkbox_reader(who) {
var email='';
checkbox_writer('promoter');

try {
var boxes = document.getElementsByTagName("input");
var email="";
var num = boxes.length;
for (i=0; i<boxes.length; i++){
if (boxes[i].checked == true)
{
  if (boxes[i].getAttribute("email")!="undefined")
  {   if (!email) email = boxes[i].getAttribute("email");
      else   email =  email + ", " + boxes[i].getAttribute("email");
  }

}
}

 main_message_form(0,0,0,email,who);
 //alert(email)
} catch( e ) {
				alert( e );
			}
}

function sms_reader(who) {
checkbox_writer('promoter');
try {
var boxes = document.getElementsByTagName("input");
var sms="";
var num = boxes.length;
for (i=0; i<boxes.length; i++){
if (boxes[i].checked == true)
//alert(boxes[i].getAttribute("phone"));
{
  if ((boxes[i].getAttribute("phone")!="undefined")&&(boxes[i].getAttribute("phone")!=null))
  {   if (!sms) {
         sms = boxes[i].getAttribute("phone");}
      else   sms =  sms + ", " + boxes[i].getAttribute("phone");
  }

}
}
send_sms_form(sms,0,0,'ajax',who);
//alert(sms)
} catch( e ) {
				alert( e );
			}
}


function checkbox_checker(boxtype){

var boxes = document.getElementsByTagName("input");
for (i=0; i<boxes.length; i++){
  boxes[i].checked = true
}
checkbox_writer(boxtype)
}

function checkbox_writer(boxtype){
var ids="-1";
var values="0";
var boxes = document.getElementsByTagName("input");
for (i=0; i<boxes.length; i++){
 if (boxes[i].getAttribute("id")!="undefined"){
 if (boxes[i].getAttribute(boxtype)!="undefined")
{
ids = ids + ',' + boxes[i].getAttribute("id");
if  (boxes[i].checked != true ){values=values+',0';} else{ values = values + ',1';}
}

}

}
return check_box_saver(boxtype,ids,values);
}

var MAX_lat=160;
var MAX=MAX_lat;

function isCorrectLatinChar(code) {
    return (code < 128 || code == 160);
}

function checkStr() {
	str=document.getElementById('message_txt').value;

	if(document.getElementById('message_txt').value.length > MAX)	{
		str = str.substring(0, MAX);
	}

	if (str!=document.getElementById('message_txt').value){
		document.getElementById('message_txt').value=str;
	}

	document.getElementById('symbols').innerHTML = MAX-document.getElementById ('message_txt').value.length;
}


function isChar(event){
	return event.charCode>31 || event.keyCode==13 || event.keyCode>31;
}

function checkSymbol(event) {



		if (event.charCode>128 || event.keyCode>128){
			if (document.all){
				event.returnValue=false;
			}else{
				event.preventDefault();
			}
		}

	if(isChar(event) && document.getElementById('message_txt').value.length >= MAX)	{
		if (document.all){
			event.returnValue=false;
		}else{
			event.preventDefault();
		}
	}

	checkStr();
}

function check_box_saver (boxtype,ids,values)
{
 // alert (boxtype + ' | ' + ids + ' | ' + values);
try { main_check_box_saver(boxtype,ids,values) }
catch( e ) {
				alert( e );
			}


}
function check_box_emails (boxtype){
 // alert (boxtype + ' | ' + ids + ' | ' + values);
try { main_check_box_emails(boxtype) }
catch( e ) {
				alert( e );
			}
}

function checkbox_updater (boxtype,ids,values)
{
 alert (boxtype + ' | ' + ids + ' | ' + values); return false;
}


function get_set_marker(id)
{
var m = document.getElementById('inq_'+id);
var c = markersArray.length;
if(c > 15){ c =0 };
if (m.checked) {
  get_inq_coords(id);
  $('#box_'+id).removeClass('mc16').addClass('mc'+c);
// $('#box_'+id);
}
 else {
   for (i=0;i<16;i++) {$('#box_'+id).removeClass('mc'+i);}
     $('#box_'+id).addClass('mc16');

      get_inq_coords2(id);
 // alert('uncheck!')
 }


}


function checkbox_unchecker(boxtype){
var boxes = document.getElementsByTagName("input");
for (i=0; i<boxes.length; i++){
  boxes[i].checked = false
}
checkbox_eraser(boxtype);
}
function checkbox_eraser(boxtype){
try { main_checkbox_eraser(boxtype) }
catch( e ) {
				alert( e );
			}

}

function startUpload(){
      document.getElementById('f1_upload_process').style.visibility = 'visible';
      document.getElementById('f1_upload_form').style.visibility = 'hidden';
      return true;
}

function showAttach(fname,attname){
   // alert(fname)
     document.getElementById('filenames').value = document.getElementById('filenames').value + "|" +attname;
     document.getElementById('attachedfiles').innerHTML = document.getElementById('attachedfiles').innerHTML + "&nbsp;&nbsp;&nbsp;<b>"+fname+"</b>";
    // document.getElementById('attachedfiles').style.visibility = 'visible';
    return true;
}
function stopUpload(success){
      var result = '';
      if (success == 1){
         result = '<span class="msg">The file was uploaded successfully!<\/span><br/><br/>';
      }
      else {
         result = '<span class="emsg">There was an error during file upload!<\/span><br/><br/>';
      }
      document.getElementById('f1_upload_process').style.visibility = 'hidden';
      document.getElementById('f1_upload_form').innerHTML = result + '<label>File: <input name="myfile" type="file" size="30" /><\/label><label><input type="submit" name="submitBtn" class="sbtn" value="Upload" /><\/label>';
      document.getElementById('f1_upload_form').style.visibility = 'visible';
      return true;
}

function check_non_empty(){

var m = document.getElementById('id_artist').value;
var n = document.getElementById('id_promoter').value;


if (((m*1)*(n*1))>0 ) {
                   document.add_contract.submit();
                   return true;
            } else {

           alert ('please, select artist & promoter from list above'); return false;


}


}


function calculate_fee ()
{

  if(document.getElementById('artist_fee').value == '' ) var a=0; else var a = FTS((document.getElementById('artist_fee').value),0)*1;
  //document.getElementById('artist_fee').value= FTS(a,0)*1;
if(document.getElementById('admin_exp').value == '') var b=0; else var b = FTS((document.getElementById('admin_exp').value),0)*1;
 //document.getElementById('admin_exp').value= FTS(b,0)*1
if(document.getElementById('production_exp').value == '') var c=0; else var c = FTS((document.getElementById('production_exp').value),0)*1;
 //document.getElementById('production_exp').value= FTS(c,0)*1
if(document.getElementById('other_exp').value == '') var d=0; else var d = FTS((document.getElementById('other_exp').value),0)*1;
 //document.getElementById('other_exp').value= FTS(d,0)*1
if(document.getElementById('travel_exp').value == '') var e=0; else var e = FTS((document.getElementById('travel_exp').value),0)*1;
 //document.getElementById('travel_exp').value= FTS(e,0)*1
 var f = FTS((a + b +c + d + e),0);
/* alert (f); */

document.getElementById('total_exp').value= f;//FTS(f,0) ;

return true;
}
function set_save_button_active(){
window.setTimeout(a=function(){document.getElementById("savebutton").disabled = false;},1500);
}



function FTS(_number,_decimal,_separator)
{
var decimal=(typeof(_decimal)!='undefined')?_decimal:2;
var separator=(typeof(_separator)!='undefined')?_separator:'';
var r=parseFloat(_number)
var exp10=Math.pow(10,decimal);// приводим к правильному множителю
r=Math.round(r*exp10)/exp10;// округляем до необходимого числа знаков после запятой
rr=Number(r).toFixed(decimal).toString().split('.');
b=rr[0].replace(/(\d{1,3}(?=(\d{3})+(?:\.\d|\b)))/g,"\$1"+separator);
if (decimal !=0) {r=b+'.'+rr[1];} else {r=b;}
return r;// возвращаем результат
}

</script>