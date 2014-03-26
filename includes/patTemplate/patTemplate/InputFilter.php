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
 * Base class for patTemplate input filter
 *
 * $Id: InputFilter.php,v 1.2 2004/05/25 20:38:38 schst Exp $
 *
 * An input filter is used to modify the stream
 * before it has been processed by patTemplate_Reader.
 *
 * @package		patTemplate
 * @subpackage	Filters
 * @author		Stephan Schmidt <schst@php.net>
 */

/**
 * Base class for patTemplate input filter
 *
 * $Id: InputFilter.php,v 1.2 2004/05/25 20:38:38 schst Exp $
 *
 * An input filter is used to modify the stream
 * before it has been processed by patTemplate_Reader.
 *
 * @abstract
 * @package		patTemplate
 * @subpackage	Filters
 * @author		Stephan Schmidt <schst@php.net>
 */
class patTemplate_InputFilter extends patTemplate_Module
{
   /**
	* apply the filter
	*
	* @access	public
	* @param	string		data
	* @return	string		filtered data
	*/
	function apply( $data )
	{
		return $data;
	}
}
?>