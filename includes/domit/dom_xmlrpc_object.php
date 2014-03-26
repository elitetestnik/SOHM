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
//*******************************************************************
//dom_xmlrpc_object wraps a native PHP object 
//*******************************************************************
//by John Heinstein
//johnkarl@nbnet.nb.ca
//*******************************************************************
//Version 0.1
//copyright 2004 Engage Interactive
//http://www.engageinteractive.com/dom_xmlrpc/
//All rights reserved
//*******************************************************************
//Licensed under the GNU General Public License (GPL)
//http://www.gnu.org/copyleft/gpl.html
//*******************************************************************
class dom_xmlrpc_object {
	var $myObject;
	
	function dom_xmlrpc_object($myObject) {
		$this->myObject =& $myObject;
	} //dom_xmlrpc_object
	
	function &getObject() {
		return $this->myObject;
	} //getObject
} //dom_xmlrpc_object
?>