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
 * patTemplate Module base class
 *
 * $Id: Module.php,v 1.4 2004/05/25 20:38:38 schst Exp $
 *
 * The patTemplate_Module is the base class for all patTemplate
 * modules like readers, dumpers, filters, etc.
 *
 * @package		patTemplate
 * @author		Stephan Schmidt <schst@php.net>
 */

/**
 * patTemplate Module base class
 *
 * $Id: Module.php,v 1.4 2004/05/25 20:38:38 schst Exp $
 *
 * The patTemplate_Module is the base class for all patTemplate
 * modules like readers, dumpers, filters, etc.
 *
 * @abstract
 * @package		patTemplate
 * @author		Stephan Schmidt <schst@php.net>
 * @abstract
 */
class patTemplate_Module
{
   /**
    * module name
	*
	* This has to be set in the final
	* module classes.
	*
	* @access	protected
	* @var		string
	*/
	var	$_name = null;

   /**
    * module parameters
	*
	* @access	protected
	* @var		array
	*/
	var	$_params = array();

   /**
	* get the name of the module
	*
	* @access	public
	* @return	string	name of the module
	*/
	function getName()
	{
		return $this->_name;
	}

   /**
	* sets parameters of the module
	*
	* @access	public
	* @param	array	assoc array containing parameters
	* @param	boolean	flag to indicate, whether previously set parameters should be cleared
	*/
	function setParams( $params, $clear = false )
	{
		if( $clear === true )
			$this->_params = array();
		$this->_params = array_merge( $this->_params, $params );
	}

   /**
	* gets a parameter of the module
	*
	* @access	public
	* @param	string	name of the parameter
	* @return	mixed	value of the parameter
	*/
	function getParam( $name )
	{
		if( isset( $this->_params[$name] ) )
			return $this->_params[$name];
		return false;
	}
}
?>