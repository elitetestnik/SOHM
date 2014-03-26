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
* @version $Id: footer.php,v 1.4 2005/01/06 01:13:29 eddieajau Exp $
* @package Mambo
* @copyright (C) 2000 - 2005 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** ensure this file is being included by a parent file */

defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );
global $_VERSION;
?>
<!--
<div align="center"><?php echo $_VERSION->COPYRIGHT; ?><?php echo ' '.$_VERSION->URL; ?></div>
<div align="center"></div>
<div align="center">
Локализация и выпуск дистрибутива: <a href="mailto:andyr@mail.ru">AndyR</a>
</div>
-->
<?
defined("_BBC_PAGE_NAME") ? _BBC_PAGE_NAME : define("_BBC_PAGE_NAME", $mainframe->_head['title']);
defined("_BBCLONE_DIR") ? _BBCLONE_DIR : define("_BBCLONE_DIR", $mosConfig_absolute_path."/administrator/components/com_bbclone/");
define("COUNTER", $mosConfig_absolute_path."/administrator/components/com_bbclone/mark_page.php");
if (is_readable(COUNTER)) include_once(COUNTER);
?>
