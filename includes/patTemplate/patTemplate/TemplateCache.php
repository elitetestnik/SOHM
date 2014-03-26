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
 * Base class for patTemplate template cache
 *
 * $Id: TemplateCache.php,v 1.6 2004/05/25 20:38:38 schst Exp $
 *
 * A template cache is used to cache the data after
 * the template has been read, but before the variables
 * have been added.
 *
 * Data is normally stored in serialized format. This
 * will increase performance.
 *
 * This is not related to an output cache!
 *
 * @package		patTemplate
 * @subpackage	Caches
 * @author		Stephan Schmidt <schst@php.net>
 */

/**
 * Base class for patTemplate template cache
 *
 * $Id: TemplateCache.php,v 1.6 2004/05/25 20:38:38 schst Exp $
 *
 * A template cache is used to cache the data after
 * the template has been read, but before the variables
 * have been added.
 *
 * Data is normally stored in serialized format. This
 * will increase performance.
 *
 * This is not related to an output cache!
 *
 * @abstract
 * @package		patTemplate
 * @subpackage	Caches
 * @author		Stephan Schmidt <schst@php.net>
 */
class patTemplate_TemplateCache extends patTemplate_Module
{
   /**
	* load template from cache
	*
	* @access	public
	* @param	string			cache key
	* @param	integer			modification time of original template
	* @return	array|boolean	either an array containing the templates or false cache could not be loaded
	*/
	function load( $key, $modTime = -1 )
	{
		return false;
	}
	
   /**
	* write template to cache
	*
	* @access	public
	* @param	string		cache key
	* @param	array		templates to store
	*/
	function write( $key, $templates )
	{
		return true;
	}

   /**
    * get the cache key for the input
	*
	* @param	mixed	input to read from.
	*					This can be a string, a filename, a resource or whatever the derived class needs to read from
	* @param	array	options
	* @return	string	key
	*/
	function getKey( $input, $options = array() )
	{
		return	md5( $input . serialize( $options ) );
	}
}
?>