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
 * patTemplate Reader that reads from a string
 *
 * $Id: String.php,v 1.4 2004/04/23 22:01:02 schst Exp $
 *
 * @package		patTemplate
 * @subpackage	Readers
 * @author		Stephan Schmidt <schst@php.net>
 */

/**
 * patTemplate Reader that reads from a string
 *
 * @package		patTemplate
 * @subpackage	Readers
 * @author		Stephan Schmidt <schst@php.net>
 */
class patTemplate_Reader_String extends patTemplate_Reader
{
   /**
    * Read templates from a string
	*
	* @final
	* @access	public
	* @param	string	string to parse
	* @param	array	options, not implemented in current versions, but future versions will allow passing of options
	* @return	array	templates
	*/
	function readTemplates( $input )
	{
		$this->_currentInput = $input;

		$templates	=	$this->parseString( $input );
		
		return	$templates;
	}
}
?>