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
* dom_xmlrpc_object wraps a PHP associative array as an XML-RPC struct
* @package dom-xmlrpc
* @copyright (C) 2004 John Heinstein. All rights reserved
* @license http://www.gnu.org/copyleft/lesser.html LGPL License
* @author John Heinstein <johnkarl@nbnet.nb.ca>
* @link http://www.engageinteractive.com/dom_xmlrpc/ DOM XML-RPC Home Page
* DOM XML-RPC is Free Software
**/

/**
* Wraps a PHP associative array as an XML-RPC struct
*
* @package dom-xmlrpc
* @author John Heinstein <johnkarl@nbnet.nb.ca>
*/
class dom_xmlrpc_struct {
	/** @var object A numeric associative array holding the data */
	var $numericAssociativeArray;
	
	/**
	* Constructor
	* @param object A reference to the associative array
	*/
	function dom_xmlrpc_struct($numericAssociativeArray) {
		$this->numericAssociativeArray = $numericAssociativeArray;
	} //dom_xmlrpc_struct
	
	/**
	* Returns the wrapped associative array
	* @return array A reference to the associative array
	*/
	function getStruct() {
		return $this->numericAssociativeArray;
	} //getStruct
} //dom_xmlrpc_struct
?>