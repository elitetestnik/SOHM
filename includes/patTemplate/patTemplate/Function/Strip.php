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
 * patTemplate function that strips whitespace from a text
 * block. This is an implementation of Smarty's strip function.
 *
 * $Id: Strip.php,v 1.1 2004/05/13 21:27:27 schst Exp $
 *
 * @package		patTemplate
 * @subpackage	Functions
 * @author		Stephan Schmidt <schst@php.net>
 */

/**
 * patTemplate function that strips whitespace from a text
 * block. This is an implementation of Smarty's strip function.
 *
 * $Id: Strip.php,v 1.1 2004/05/13 21:27:27 schst Exp $
 *
 * @package		patTemplate
 * @subpackage	Functions
 * @author		Stephan Schmidt <schst@php.net>
 */
class patTemplate_Function_Strip extends patTemplate_Function
{
   /**
	* name of the function
	* @access	private
	* @var		string
	*/
	var $_name	=	'Strip';

   /**
	* call the function
	*
	* @access	public
	* @param	array	parameters of the function (= attributes of the tag)
	* @param	string	content of the tag
	* @return	string	content to insert into the template
	*/ 
	function call( $params, $content )
	{
		return preg_replace( '/\s+/m', ' ', $content );
	}
}
?>