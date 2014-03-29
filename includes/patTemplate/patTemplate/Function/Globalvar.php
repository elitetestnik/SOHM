<?php
////////////////////////////////////////
//  ���� �� ������ ������������:
//  CMS "Mambo 4.5.2.3 Paranoia"
//  ���� �������: 06.08.2005
//  ������������ � ������������ ������
//  ����������� � ������ ������������:
//  - AndyR - mailto:andyr@mail.ru
//////////////////////////////////////
// �� �������� ������ ����:
$andyr_signature='Mambo_4523_Patanoia_012';
?>
<?PHP
/**
 * patTemplate function that enables adding global variables
 * from within a template.
 *
 * $Id: Globalvar.php,v 1.2 2004/05/28 15:45:08 schst Exp $
 *
 * @package		patTemplate
 * @subpackage	Functions
 * @author		Sebastian Mordziol <argh@php-tools.net>
 * @author		Stephan Schmidt <schst@php.net>
 */

/**
 * patTemplate function that enables adding global variables
 * from within a template.
 *
 * Available attributes:
 *
 * name     >  name of the variable
 * default  >  default value of the variable
 * hidden   >  whether to output the content of the variable: yes|no
 *
 * $Id: Globalvar.php,v 1.2 2004/05/28 15:45:08 schst Exp $
 *
 * @package		patTemplate
 * @subpackage	Functions
 * @author		Sebastian Mordziol <argh@php-tools.net>
 * @author		Stephan Schmidt <schst@php.net>
 */
class patTemplate_Function_Globalvar extends patTemplate_Function
{
   /**
	* name of the function
	* @access	private
	* @var		string
	*/
	var $_name	=	'Globalvar';

   /**
    * reference to the patTemplate object that instantiated the module
	*
	* @access	protected
	* @var	object
	*/
	var	$_tmpl;

   /**
    * set a reference to the patTemplate object that instantiated the reader
	*
	* @access	public
	* @param	object		patTemplate object
	*/
	function setTemplateReference( &$tmpl )
	{
		$this->_tmpl		=	&$tmpl;
	}

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
		if( isset( $params['default'] ) )
		{
			$this->_tmpl->addGlobalVar( $params['name'], $params['default'] );
		}
		
		if( !isset( $params['hidden'] ) )
		{
			$params['hidden'] = 'no';
		}
		
		if( $params['hidden'] != 'yes' )
			return $this->_tmpl->getOption('startTag').strtoupper($params['name']).$this->_tmpl->getOption('endTag');
			
		return '';
	}
}
?>