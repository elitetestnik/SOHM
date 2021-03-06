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
 * creates a new function alias
 *
 * $Id: Alias.php,v 1.1 2004/09/07 19:09:56 schst Exp $
 *
 * @package		patTemplate
 * @subpackage	Functions
 * @author		Stephan Schmidt <schst@php.net>
 */

/**
 * creates a new function alias
 *
 * Possible attributes:
 * - alias => new alias
 * - function => function to call
 *
 * $Id: Alias.php,v 1.1 2004/09/07 19:09:56 schst Exp $
 *
 * @package		patTemplate
 * @subpackage	Functions
 * @author		Stephan Schmidt <schst@php.net>
 */
class patTemplate_Function_Alias extends patTemplate_Function
{
   /**
	* name of the function
	* @access	private
	* @var		string
	*/
	var $_name	=	'Alias';

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
		if( !isset( $params['alias'] ) )
            return false;

		if( !isset( $params['function'] ) )
            return false;

        $this->_reader->addFunctionAlias($params['alias'], $params['function']);
        return '';
	}
}
?>