<?php
header("Content-Type: text/html;charset=utf-8");
session_start();
if (!isset($_SESSION['operator_id']))
{
    setcookie("operator_id","0");
    echo"<html><head><meta http-equiv='refresh' content='1;URL=index.php'><body>&nbsp;</body></html>";die;
}
$ip=$_SERVER ['REMOTE_ADDR'];
require_once("../config.php");
require_once($mosConfig_absolute_path."/globals.php" );
require_once($mosConfig_absolute_path."/includes/mambo.php" );
require_once($mosConfig_absolute_path."/includes/getmime.php" );
require_once($mosConfig_absolute_path."/includes/simple_html_dom.php");
require_once($mosConfig_absolute_path."/modules/calendar.php" );
require_once($mosConfig_absolute_path."/includes/cls_fast_template.php");
require_once($mosConfig_absolute_path."/includes/phpmailer/class.phpmailer.php");

$database = new database( $mosConfig_host, $mosConfig_user, $mosConfig_password, $mosConfig_db, $mosConfig_dbprefix );
$database->debug( $mosConfig_debug );
$acl = new gacl_api();

$ft = new FastTemplate($mosConfig_absolute_path."/templates");
$query="select count(*) from #__msg_queque where status=0";
$database->setQuery( $query );
//$togo=2;
$togo=$database->loadResult();
if ($togo==0)$refresh=60; else $refresh=8;
$ft->define(array('body'  => "msg.tpl"));
$ft->assign( array(
                    'REFERSH' => $refresh,
                    'STATUS' => 'working&nbsp;...&nbsp;&nbsp;&nbsp;in&nbsp;queue:&nbsp;'.$togo
                    ));
if  ($refresh>30) $ft->assign( array(
                    'REFERSH' => $refresh,
                    'STATUS' => 'no messages to send ...'
                    ));
$ft->parse('BODY', "body");
$result=$ft->FastPrint("BODY",true);
$msg = new PHPMailer();
$query="select * from #__msg_queque where status=0 limit 10";
$database->setQuery( $query );
$mesgs=$database->loadObjectList();
foreach ($mesgs as $mesg) {
$message = '<html><head><title>'.$mesg->subject.'</title><meta http-equiv="Content-Type" content="text/html; charset=utf8" /></head><body>'.$mesg->msg_body_html.'</body></html>';
$html = str_get_html($message);
foreach($html->find('img') as $element){
      $url=$element->src;
      $n=explode('/',$url);
      $filename=$n[sizeof($n)-1];
     if($n[0]=='http:') file_put_contents(dirname(__FILE__)."/cache/image/".$filename, file_get_contents($url));
     if (file_exists ( dirname(__FILE__)."/cache/image/".$filename )){
      $name=explode(".",$filename);
      $element->src = 'cid:'.md5($name[0]);
      $typ=get_mime_type_from_ext(strtolower($name[sizeof($name)-1]));
      $msg->AddEmbeddedImage(dirname(__FILE__)."/cache/image/".$filename,md5($name[0]),$filename,"base64",$typ);
      }
     }
$html=str_replace('_NAME_',$mesg->to_name, $html);
$html=str_replace('_COMPANY_',$mesg->to_company, $html);
$mesg->msg_body_txt =str_replace('_NAME_',$mesg->to_name, $mesg->msg_body_txt);
$mesg->msg_body_txt =str_replace('_COMPANY_',$mesg->to_company, $mesg->msg_body_txt);
$mesg->subject =str_replace('_NAME_',$mesg->to_name, $mesg->subject);
$mesg->subject =str_replace('_COMPANY_',$mesg->to_company, $mesg->subject);
$msg->Body = $html;
$msg->AltBody = strip_tags(htmlspecialchars_decode($mesg->msg_body_txt));
$msg->From=$mesg->from_email;
$msg->FromName=$mesg->from_name;
$msg->Sender=$mesg->from_email;
$msg->Subject='=?UTF-8?B?'.base64_encode($mesg->subject).'?=';
$msg->AddAddress($mesg->to_name." <".$mesg->to_email.">");
$msg->Mailer='mail';
$msg->Helo='www.stenolav-management.no';
$msg->isHTML(true);
$msg->Send();
$err.=$msg->ErrorInfo;
$msg->ClearAddresses();
$msg->ClearAttachments();
$msg->IsHTML(false);
$query =  "update #__msg_queque set status=1 where id=".$mesg->id;
$database->setQuery( $query );
$database->query();
}
$query =  "update #__msg_queque_header c set c.sent=(select count(*) from #__msg_queque v where v.header_id=c.id and v.status=1)";
$database->setQuery( $query );
$database->query();
echo $result;
?>


<?
exit; ?>