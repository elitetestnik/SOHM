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
 * Modifier that creates an HTML image tag from a variable
 *
 * It automatically retrieves the width and height of the image.
 *
 * $Id: Img.php,v 1.2 2004/04/11 08:47:45 schst Exp $
 *
 * @package		patTemplate
 * @subpackage	Modifiers
 * @author		Stephan Schmidt <schst@php.net>
 */

/**
 * Modifier that creates an HTML image tag from a variable
 *
 * It automatically retrieves the width and height of the image.
 *
 * $Id: Img.php,v 1.2 2004/04/11 08:47:45 schst Exp $
 *
 * @package		patTemplate
 * @subpackage	Modifiers
 * @author		Stephan Schmidt <schst@php.net>
 */
class patTemplate_Modifier_HTML_Img extends patTemplate_Modifier
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
		$size = getimagesize( $value );
		$params['src']    = $value;
		$params['width']  = $size[0];
		$params['height'] = $size[1];
		return '<img'.$this->arrayToAttributes($params).' />';
	}

   /**
	* create an attribute list
	*
	* @access	private
	* @param	array
	* @return	string
	*/
	function arrayToAttributes( $array )
	{
		$string = '';
		foreach( $array as $key => $val )
		{
			$string .= ' '.$key.'="'.htmlspecialchars( $val ).'"';
		}
		return $string;
	}
}
?>