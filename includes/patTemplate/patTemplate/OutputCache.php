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
 * Base class for patTemplate output cache
 *
 * $Id: OutputCache.php,v 1.3 2004/05/25 20:38:38 schst Exp $
 *
 * An output cache is used to cache the data before
 * the template has been read.
 *
 * It stores the HTML (or any other output) that is
 * generated to increase performance.
 *
 * This is not related to a template cache!
 *
 * @package		patTemplate
 * @subpackage	Caches
 * @author		Stephan Schmidt <schst@php.net>
 */

/**
 * Base class for patTemplate output cache
 *
 * $Id: OutputCache.php,v 1.3 2004/05/25 20:38:38 schst Exp $
 *
 * An output cache is used to cache the data before
 * the template has been read.
 *
 * It stores the HTML (or any other output) that is
 * generated to increase performance.
 *
 * This is not related to a template cache!
 *
 * @abstract
 * @package		patTemplate
 * @subpackage	Caches
 * @author		Stephan Schmidt <schst@php.net>
 */
class patTemplate_OutputCache extends patTemplate_Module
{
}
?>