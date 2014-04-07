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
$_EMAIL = "webserver@back-track.biz";
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

$result.="<td bgcolor='whi