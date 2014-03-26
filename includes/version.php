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
* @version $Id: version.php,v 1.12 2005/02/19 02:06:44 eddieajau Exp $
* @package Mambo
* @copyright (C) 2000 - 2005 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** Version information */
class version {
	/** @var string Product */
	var $PRODUCT = 'Mambo';
	/** @var int Main Release Level */
	var $RELEASE = '4.5';
	/** @var string Development Status */
	var $DEV_STATUS = 'Stable';
	/** @var int Sub Release Level */
	var $DEV_LEVEL = '2.3';
	/** @var string Codename */
	var $CODENAME = 'Paranoia';
	/** @var string Date */
	var $RELDATE = '06 августа 2005';
	/** @var string Time */
	var $RELTIME = '00:00';
	/** @var string Timezone */
	var $RELTZ = 'GMT';
	/** @var string Copyright Text */
	var $COPYRIGHT = 'Copyright 2000 - 2005 Miro International Pty Ltd.  Все права защищены.';
	/** @var string URL */
	var $URL = '<a href="http://www.mamboserver.com">Mambo</a>свободно распространяемое программное обеспечение по GNU/GPL лицензии.<br />Локализация © 2005 AndyR - <a href="mailto:andyr@mail.ru">andyr@mail.ru</a>';
}
$_VERSION =& new version();

$version = $_VERSION->PRODUCT .' '. $_VERSION->RELEASE .'.'. $_VERSION->DEV_LEVEL .' '
. $_VERSION->DEV_STATUS
.' [ '.$_VERSION->CODENAME .' ] '. $_VERSION->RELDATE .' '
. $_VERSION->RELTIME .' '. $_VERSION->RELTZ;
?>
