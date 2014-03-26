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
 * patTemplate StripWhitespace output filter
 *
 * $Id: StripWhitespace.php,v 1.4 2004/04/08 16:11:28 schst Exp $
 *
 * Will remove all whitespace and replace it with a single space.
 *
 * @package		patTemplate
 * @subpackage	Filters
 * @author		Stephan Schmidt <schst@php.net>
 */

/**
 * patTemplate StripWhitespace output filter
 *
 * $Id: StripWhitespace.php,v 1.4 2004/04/08 16:11:28 schst Exp $
 *
 * Will remove all whitespace and replace it with a single space.
 *
 * @package		patTemplate
 * @subpackage	Filters
 * @author		Stephan Schmidt <schst@php.net>
 */
class patTemplate_OutputFilter_StripWhitespace extends patTemplate_OutputFilter
{
   /**
    * filter name
	*
	* @access	protected
	* @abstract
	* @var	string
	*/
	var	$_name	=	'StripWhitespace';

   /**
	* remove all whitespace from the output
	*
	* @access	public
	* @param	string		data
	* @return	string		data without whitespace
	*/
	function apply( $data )
	{
		$data = str_replace( "\n", ' ', $data );
        $data = preg_replace( '/\s\s+/', ' ', $data );
	
		return $data;
	}
}
?>