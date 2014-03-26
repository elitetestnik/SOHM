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
 * Base class for patTemplate Stat
 *
 * $Id: Stat.php,v 1.1 2004/05/17 18:40:54 schst Exp $
 *
 * A stat component should be implemented for each reader
 * to support caching. Stats return information about the
 * template source.
 *
 * @package		patTemplate
 * @subpackage	Stat
 * @author		Stephan Schmidt <schst@php.net>
 */

/**
 * Base class for patTemplate Stat
 *
 * $Id: Stat.php,v 1.1 2004/05/17 18:40:54 schst Exp $
 *
 * A stat component should be implemented for each reader
 * to support caching. Stats return information about the
 * template source.
 *
 * @package		patTemplate
 * @subpackage	Stat
 * @author		Stephan Schmidt <schst@php.net>
 * @abstract
 */
class patTemplate_Stat extends patTemplate_Module
{
   /**
	* options, are identical to those of the corresponding reader
	*
	* @access	private
	* @var		array
	*/
	var $_options = array();

   /**
    * get the modification time of a template
	*
	* Needed, if a template cache should be used, that auto-expires
	* the cache.
	*
	* @abstract	must be implemented in the template readers
	* @param	mixed	input to read from.
	*					This can be a string, a filename, a resource or whatever the derived class needs to read from
	* @return	integer	unix timestamp
	*/
	function getModificationTime( $input )
	{
		return	-1;
	}

   /**
	* set options
	*
	* @access	public
	* @param	array	array containing options
	*/
	function setOptions( $options )
	{
		$this->_options		=	$options;
	}
}
?>