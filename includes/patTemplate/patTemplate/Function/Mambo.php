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
<?php
/**
* @version $Id: Mambo.php,v 1.1 2004/12/24 04:06:30 eddieajau Exp $
* @package Mambo
* @copyright (C) 2000 - 2005 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

class patTemplate_Function_Mambo extends patTemplate_Function
{
   /**
	* name of the function
	* @access	private
	* @var		string
	*/
	var $_name	=	'Mambo';

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
		if( !isset( $params['macro'] ) ) {
            return false;
		}

        $macro = strtolower( $params['macro'] );
		$page =& $GLOBALS['mainframe']->getPage();

        switch ($macro) {

        	case 'initeditor':
        		return initEditor( true );
        		break;

        	case 'mainbody':
        		return $page->showMainBody();
        		break;

        	case 'loadcomponent':
        		// deprecated ??
				if( !isset( $params['component'] ) ) {
		            return false;
				} else {
					return $page->showComponent( $params['component'] );
				}
        		break;

			case 'hasmodules':
				$position = mosGetParam( $params, 'position', '' );

				if ($page->countModules( $position ) > 0) {
					return $content;
				} else {
					return false;
				}
        		break;

         	case 'loadmodule':
				$name = mosGetParam( $params, 'name', '' );
				$style = mosGetParam( $params, 'style', 0 );
				ob_start();
				$page->showModule( $name, $style );
				$html = ob_get_contents();
				ob_end_clean();
				return $html;
        		break;

        	case 'loadmodules':
				$position = mosGetParam( $params, 'position', '' );
				$style = mosGetParam( $params, 'style', 0 );
				ob_start();
				$page->showModules( $position, $style );
				$html = ob_get_contents();
				ob_end_clean();
				return $html;
        		break;

	       	case 'showhead':
        		return $page->showHead();
        		break;

        	case 'pathway':
				$Itemid = mosGetParam( $_REQUEST, 'Itemid', '' );
				ob_start();
				require $GLOBALS['_CONFIG']->SITEPATH . '/includes/pathway.php';
				$html = ob_get_contents();
				ob_end_clean();
				return $html;
        		break;
		}

		return false;
	}
}
?>