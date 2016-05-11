<?php
header("Content-Type: text/html;charset=utf-8");
session_start();
if ((!isset($_SESSION['operator_id']))||(!isset($_REQUEST['id'])))
{
    setcookie("operator_id","0");
    echo"<html><head><meta http-equiv='refresh' content='1;URL=index.php'><body>&nbsp;</body></html>";die;
}else  $id=strip_tags($_REQUEST['id']);
require_once("config.php");
require_once($mosConfig_absolute_path."/globals.php" );
require_once($mosConfig_absolute_path."/includes/mambo.php" );
require_once($mosConfig_absolute_path.'/includes/frontend.php' );
$option = trim( strtolower( mosGetParam( $_REQUEST, 'option' ) ) );
$Itemid = intval( mosGetParam( $_REQUEST, 'Itemid', null ) );
$database = new database( $mosConfig_host, $mosConfig_user, $mosConfig_password, $mosConfig_db, $mosConfig_dbprefix );
$database->debug( $mosConfig_debug );
$acl = new gacl_api();
global $database,$mosConfig_live_site;
$database->setQuery( "set names utf8" );
$database->query();
$query="select * from #__messages where message_id=".$id;
$database->setQuery($query);
$messages = $database->loadObjectList(); foreach($messages as $message){}
echo '<html xmlns="http://www.w3.org/1999/xhtml">
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<META HTTP-EQUIV="Expires" CONTENT="-1">
<TITLE>'.$message->subject.'</TITLE></head><body>';
echo $message->mesage_body;
echo "</body></html>";
exit; ?>