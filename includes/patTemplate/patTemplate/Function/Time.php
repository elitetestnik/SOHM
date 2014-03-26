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
 * patTemplate function that calculates the current time
 * or any other time and returns it in the specified format.
 *
 * $Id: Time.php,v 1.2 2004/04/06 18:50:25 schst Exp $
 *
 * @package		patTemplate
 * @subpackage	Functions
 * @author		Stephan Schmidt <schst@php.net>
 */

/**
 * patTemplate function that calculates the current time
 * or any other time and returns it in the specified format.
 *
 * $Id: Time.php,v 1.2 2004/04/06 18:50:25 schst Exp $
 *
 * @package		patTemplate
 * @subpackage	Functions
 * @author		Stephan Schmidt <schst@php.net>
 */
class patTemplate_Function_Time extends patTemplate_Function
{
   /**
	* name of the function
	* @access	private
	* @var		string
	*/
	var $_name	=	'Time';

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
		if( !empty( $content ) )
		{
			$params['time'] = $content;
		}
		
		if( isset( $params['time'] ) )
		{
			$params['time'] = strtotime( $params['time'] );
		}
		else
		{
			$params['time'] = time();
		}
		
		
		return date( $params['format'], $params['time'] );
	}
}
?>