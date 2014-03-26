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
<?PHP
/**
 * Base class for patTemplate functions
 *
 * $Id: Function.php,v 1.4 2004/10/27 13:52:20 schst Exp $
 *
 * @package		patTemplate
 * @subpackage	Functions
 * @author		Stephan Schmidt <schst@php.net>
 */

/**
 * function is executed, when template is compiled (preg_match)
 */
define('PATTEMPLATE_FUNCTION_COMPILE', 1);

/**
 * function is executed, when template parsed
 */
define('PATTEMPLATE_FUNCTION_RUNTIME', 2);
 
/**
 * Base class for patTemplate functions
 *
 * $Id: Function.php,v 1.4 2004/10/27 13:52:20 schst Exp $
 *
 * @abstract
 * @package		patTemplate
 * @subpackage	Functions
 * @author		Stephan Schmidt <schst@php.net>
 */
class patTemplate_Function extends patTemplate_Module
{
   /**
	* reader object
	*
	* @access private
	* @var	  object
	*/
	var $_reader;
	
   /**
	* function type
	*
	* @access public
	* @var	  integer
	*/
	var $type = PATTEMPLATE_FUNCTION_COMPILE;
	
   /**
	* set the reference to the reader object
	*
	* @access	public
	* @param	object patTemplate_Reader
	*/ 
	function setReader( &$reader )
	{
		$this->_reader = &$reader;
	}

   /**
	* call the function
	*
	* @abstract
	* @access	public
	* @param	array	parameters of the function (= attributes of the tag)
	* @param	string	content of the tag
	* @return	string	content to insert into the template
	*/ 
	function call( $params, $content )
	{
	}
}
?>