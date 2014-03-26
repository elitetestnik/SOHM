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
 * Base class for patTemplate variable modifiers
 *
 * $Id: Modifier.php,v 1.2 2004/05/25 20:38:38 schst Exp $
 *
 * A modifier is used to modify a variable when it's parsed
 * into the template.
 *
 * @package		patTemplate
 * @subpackage	Modifiers
 * @author		Stephan Schmidt <schst@php.net>
 */

/**
 * Base class for patTemplate variable modifiers
 *
 * $Id: Modifier.php,v 1.2 2004/05/25 20:38:38 schst Exp $
 *
 * A modifier is used to modify a variable when it's parsed
 * into the template.
 *
 * @abstract
 * @package		patTemplate
 * @subpackage	Modifiers
 * @author		Stephan Schmidt <schst@php.net>
 */
class patTemplate_Modifier extends patTemplate_Module
{
   /**
	* modify the value
	*
	* @access	public
	* @param	string		value
	* @return	string		modified value
	*/
	function modify( $value, $params = array() )
	{
		return $value;
	}
}
?>