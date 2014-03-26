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
 * patTemplate modifier that quotes LaTeX special chars
 *
 * $Id: QuoteLatex.php,v 1.1 2005/01/03 15:56:52 schst Exp $
 *
 * @package		patTemplate
 * @subpackage	Modifiers
 * @author		Stephan Schmidt <schst@php.net>
 */

/**
 * patTemplate modifier that quotes LaTeX special chars
 *
 * This is useful when creating PDF documents with patTemplate
 *
 * @package		patTemplate
 * @subpackage	Modifiers
 * @author		Stephan Schmidt <schst@php.net>
 * @link		http://www.php.net/manual/en/function.strftime.php
 */
class patTemplate_Modifier_QuoteLatex extends patTemplate_Modifier
{
    /**
     *
     *
     */
    var $_chars = array(
                        '%' => '\%',
                        '&' => '\&',
                        '_' => '\_',
                        '$' => '\$'
                    );
    
   /**
	* modify the value
	*
	* @access	public
	* @param	string		value
	* @return	string		modified value
	*/
	function modify( $value, $params = array() )
	{
	    return strtr($value, $this->_chars);
	}
}
?>