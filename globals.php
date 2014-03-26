<?php
////////////////////////////////////////
//  Файл из пакета дистрибутива:
//  CMS "Mambo 4.5.2.3 Paranoia"
//  Дата выпуска: 06.08.2005
//  Исправленная и доработанная версия
//  Локализация и сборка дистрибутива:
//  - AndyR - mailto:andyr@mail.ru
//////////////////////////////////////
// Не удаляйте строку ниже:
$andyr_signature='Mambo_4523_Patanoia_012';
?>
<?php
/**
* @version $Id: globals.php,v 1.7 2005/01/24 17:48:18 troozers Exp $
* @package Mambo
* @copyright (C) 2000 - 2005 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

$raw = phpversion();
list($v_Upper,$v_Major,$v_Minor) = explode(".",$raw);

if (($v_Upper == 4 && $v_Major < 1) || $v_Upper < 4) {
	$_FILES = $HTTP_POST_FILES;
	$_ENV = $HTTP_ENV_VARS;
	$_GET = $HTTP_GET_VARS;
	$_POST = $HTTP_POST_VARS;
	$_COOKIE = $HTTP_COOKIE_VARS;
	$_SERVER = $HTTP_SERVER_VARS;
	$_SESSION = $HTTP_SESSION_VARS;
	$_FILES = $HTTP_POST_FILES;
}

if (!ini_get('register_globals')) {
	while(list($key,$value)=each($_FILES)) $GLOBALS[$key]=$value;
	while(list($key,$value)=each($_ENV)) $GLOBALS[$key]=$value;
	while(list($key,$value)=each($_GET)) $GLOBALS[$key]=$value;
	while(list($key,$value)=each($_POST)) $GLOBALS[$key]=$value;
	while(list($key,$value)=each($_COOKIE)) $GLOBALS[$key]=$value;
	while(list($key,$value)=each($_SERVER)) $GLOBALS[$key]=$value;
	while(list($key,$value)=@each($_SESSION)) $GLOBALS[$key]=$value;
	foreach($_FILES as $key => $value){
		$GLOBALS[$key]=$_FILES[$key]['tmp_name'];
		foreach($value as $ext => $value2){
			$key2 = $key . '_' . $ext;
			$GLOBALS[$key2] = $value2;
		}
	}
}

function print_legend ($id=0) { $result='';
if ($id==0){
$result="
<TABLE align='left' style='background-color:#eeeeee;border: 1px gray solid; text-align:center;'>
<TR><TD><IMG SRC='/ico/application.png' WIDTH='16' HEIGHT='16' BORDER='0' ALT=''></TD><TD>- get full info</TD>
	<TD><IMG SRC='/ico/reply.png' WIDTH='16' HEIGHT='16' BORDER='0' ALT=''></TD><TD>- edit</TD><TD><IMG SRC='/ico/action_check.png' WIDTH='16' HEIGHT='16' BORDER='0' ALT=''></TD><TD>- accept</TD><TD><IMG SRC='/ico/action_delete.png' WIDTH='16' HEIGHT='16' BORDER='0' ALT=''></TD><TD>- delete</TD></TR></TABLE>";

}
if ($id==1){
$result="<TABLE align='left' style='background-color:#eeeeee;border: 1px gray solid; text-align:center;'>
<TR><TD><IMG SRC='/ico/application.png' WIDTH='16' HEIGHT='16' BORDER='0' ALT=''></TD><TD>- get full info</TD>
	<TD><IMG SRC='/ico/reply.png' WIDTH='16' HEIGHT='16' BORDER='0' ALT=''></TD><TD>- edit</TD><TD><IMG SRC='/ico/action_check.png' WIDTH='16' HEIGHT='16' BORDER='0' ALT=''></TD><TD>- accept</TD><TD><IMG SRC='/ico/action_delete.png' WIDTH='16' HEIGHT='16' BORDER='0' ALT=''></TD><TD>-delete</TD><TD><IMG SRC='/ico/arrow_next.png' WIDTH='16' HEIGHT='16' BORDER='0' ALT=''></TD><TD>-add info to promoters db</TD><TD><IMG SRC='/ico/50.png' WIDTH='16' HEIGHT='16' BORDER='0' ALT=''></TD><TD>- new !!!</TD>
	<TD><IMG SRC='/ico/44.png' WIDTH='16' HEIGHT='16' BORDER='0' ALT=''></TD><TD>- seen</TD>	
	</TR></TABLE>";
}
return $result;
}


?>
