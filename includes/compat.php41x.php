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
<?php
/**
* PHP 4.1.x Compatibility functions
* @version $Id: compat.php41x.php,v 1.1 2005/02/04 15:32:39 eddieajau Exp $
* @package Mambo
* @copyright (C) 2000 - 2005 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

if (!function_exists( 'array_change_key_case' )) {
	if (!defined('CASE_LOWER')) {
	    define('CASE_LOWER', 0);
	}
	if (!defined('CASE_UPPER')) {
	    define('CASE_UPPER', 1);
	}
	function array_change_key_case( $input, $case=CASE_LOWER ) {
	    if (!is_array( $input )) {
	        return false;
		}
		$array = array();
		foreach ($input as $k=>$v) {
			if ($case) {
			    $array[strtoupper( $k )] = $v;
			} else {
			    $array[strtolower( $k )] = $v;
			}
		}
		return $array;
	}
}
?>