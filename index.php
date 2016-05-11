<?php
session_start();
setcookie('prev', "");
setcookie('now', "");
require_once("config.php");
if (!DEFINED('config_loaded')){
    die('direct access not allowed');
}
if (isset($_REQUEST['xajax']) || isset($_POST['xajax']) || isset($_GET['xajax'])) {
    define('_VALID_MOS', 1);
    require_once( $mosConfig_absolute_path . "/globals.php" );
    require_once( $mosConfig_absolute_path . "/includes/mambo.php" );
    $database = new database($mosConfig_host, $mosConfig_user, $mosConfig_password, $mosConfig_db, $mosConfig_dbprefix);
    $database->debug($mosConfig_debug);
    $acl = new gacl_api();
} else {
    defined('_VALID_MOS') or die('Прямой доступ к файлам по этому адресу запрещен!');
    global $mosConfig_absolute_path, $mosConfig_live_site, $database;
}
if (!defined('XAJAX_DEFAULT_CHAR_ENCODING'))
    include_once($mosConfig_absolute_path . "/includes/xajax/xajax.inc.php");
if (isset($_REQUEST['exit'])) {
    $_SESSION['operator_name'] = '';
    $_SESSION['operator_id'] = -1;
    $_SESSION['login'] = '';
}
//include "config.php";
//session_register('operator_id');
//session_register('operator_name');
//session_register('login');
$all_ok = 0;
$block = 0;
if (isset($_POST['login_']) && (isset($_POST['password_']))) {
//if (!defined('_VALID_MOS')) define( '_VALID_MOS', 1 );
//require_once("config.php");
    require_once($mosConfig_absolute_path . "/globals.php" );
    require_once($mosConfig_absolute_path . "/includes/mambo.php" );
    $database = new database($mosConfig_host, $mosConfig_user, $mosConfig_password, $mosConfig_db, $mosConfig_dbprefix);
    $database->debug($mosConfig_debug);
    $acl = new gacl_api();
    $database->setQuery("set names utf8");
    $database->query();

    $query = " SELECT * FROM `#__users` where  `login`='" . strip_tags(trim($_POST['login_'])) . "' and  `password`='" . md5($_POST['password_']) . "' LIMIT 1 ";
//echo $query;
    $database->setQuery($query);
    $users = $database->loadObjectList();
//print_r ($user);
    foreach ($users as $user) {
        $_SESSION['operator_name'] = $user->username;
        $_SESSION['operator_id'] = $user->user_id;
        $_SESSION['login'] = $user->login;
        $all_ok = 1;
        if (!$user->status) {
            $block = 1;
            $all_ok = 1;
        }
        $database->setQuery("update `#__users` set `lastlogin`=NOW() where user_id=" . $_SESSION['operator_id']);
        $database->query();
    }

    if ($all_ok && !$block) {
        echo"<html><head><meta http-equiv='refresh' content='1;URL=index2.php'>
<body>&nbsp;</body></html>";
        die;
    }
}
?>
<!doctype html public "-//W3C//DTD HTML 4.0 Transitional//EN">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Administration</title>
        <style type="text/css">
            <!--
            body {
                background-color: #3e3830;
                margin-left: 1%;
                margin-right: 1%;
                margin-top: 0px;
                margin-bottom: 0px;
            }
            body,td,th {
                color: #333;
                font-family: Tahoma, Arial, sans-serif;
                font-size: 13px;
            }
            a:link {
                color: #4369ac;
            }
            -->
        </style>
    </head>
    <body><form name="login" method='POST' id='login' action="<?php echo $mosConfig_live_site; ?>/index.php">
            <table width=100% style="height:100%" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                    <td bgcolor="#E5E5E5">
                        <TABLE border="1" align="center" cellPadding=0 cellSpacing=0 bordercolor="#999999" bgcolor="#999999" style="WIDTH: 250px; MARGIN-BOTTOM: 12%">
                            <TR>
                                <TD>
                                    <TABLE border="0" align="center" cellPadding=3 cellSpacing=1 bordercolor="#999999" style="WIDTH: 250px;">
                                        <THEAD>
                                            <TR>
                                                <TD colSpan=2 align=left background="images/bg_tfoot.gif" bgcolor="#FFFFFF" style="HEIGHT: 28px"><div align="center"><IMG src="images/login.gif"
                                                                                                                                                                          alt="" width=23 height=23 align="absmiddle"> &nbsp; Authorization</div></TD>
                                            </TR>
                                        </THEAD>
                                        <TBODY>
                                            <TR>
                                                <TD bgcolor="#FFFFFF">Login</TD>
                                                <TD bgcolor="#FFFFFF" style="WIDTH: 150px"><INPUT style="WIDTH: 100%" maxLength='30' type='text' name='login_' id='login_'></TD>
                                            </TR>
                                            <TR>
                                                <TD bgcolor="#FFFFFF">Password</TD>
                                                <TD bgcolor="#FFFFFF" style="WIDTH: 150px"><INPUT style="WIDTH: 100%" maxLength='30' type='password' name='password_' id='password_'></TD>
                                            </TR> <TR>
                                                <TD colSpan=2 align=right background="images/bg_tfoot.gif" bgcolor="#FFFFFF">
                                                    <div align="center">
                                                        <INPUT value=Enter type=submit>
                                                    </div></TD></TR></TBODY></TABLE></TD></TR></TABLE></td></tr></table></form>
<?php
include 'modules/info.php';
if ((!$all_ok) && (!isset($_REQUEST['exit'])))
    echo "<script>alert('Incorrect user id or password!')</script>";
if ($block)
    echo "<script>alert('Your account was blocked, call support')</script>";
?>
        <div id='inq_info' style='border: 1px gray solid;background-image:url("/ico/overlay.png");background-repeat:repeat;
             width:100%;height:100%;z-index:90;display:none;position:absolute;top:0;left:0;text-align:center;vertical-align:middle;'>&nbsp;&nbsp;</div>
        <DIV ID="testdiv1" STYLE="position:absolute;visibility:hidden;background-color:white;layer-background-color:white;z-index:99;"></DIV>
    </body></html>

