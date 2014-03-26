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
// $Id: pdf.php,v 1.17 2004/04/07 11:56:02 rcastley Exp $
/**
* PDF code
* @package Mambo Open Source
* @Copyright (C) 2000 - 2003 Miro International Pty Ltd
* @ All rights reserved
* @ Mambo Open Source is Free Software
* @ Released under GNU/GPL License : http://www.gnu.org/copyleft/gpl.html
* @version $Revision: 1.17 $
* Created by Phil Taylor me@phil-taylor.com
* Support file to display PDF Text Only using class from - http://www.ros.co.nz/pdf/readme.pdf
* HTMLDoc is available from: http://www.easysw.com/htmldoc and needs installing on the server for better HTML to PDF conversion
**/

// THIS IS NOT A STANDARD MAMBO CORE FILE BY HAS BEEN MODIFIED BY PHIL TAYLOR <mambo@phil-taylor.com>

// ensure this file is being included by a parent file
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

global $mosConfig_offset, $mosConfig_hideAuthor, $mosConfig_hideModifyDate, $mosConfig_hideCreateDate, $mosConfig_live_site;

$safe="0";
if (get_php_setting('safe_mode') == 'ON') {
	$safe="1";
}

if ($safe == "0") {

	if (@file_exists( "/usr/bin/htmldoc" )) {
		$id = strtolower( trim( mosGetParam( $_REQUEST, 'id',1 ) ) );
		$article = $mosConfig_live_site . '/index2.php?option=content&task=view&pop=1&page=0&hide_js=1&pdf=1&id=' . $id;
		header( "Content-Type: application/pdf" );
		header( "Content-Disposition: inline; filename=\"pdf-mambo.pdf\"" );
		flush();
		//following line for Linux only - windows may need the path as well...
		passthru( "/usr/bin/htmldoc --no-localfiles --no-compression -t pdf14 --jpeg --webpage --header t.D --footer ./. --size letter --left 0.5in '$article'" );
	} else {
		dofreePDF ($database);
	}
} else {

	dofreePDF ($database);
}

function dofreePDF ($database) {
	global $mosConfig_live_site, $mosConfig_sitename, $mosConfig_offset, $mosConfig_hideCreateDate,
   $mosConfig_hideAuthor, $mosConfig_hideModifyDate, $mosConfig_absolute_path;

	$id = strtolower( trim( mosGetParam( $_REQUEST, 'id',1 ) ) );
	$row = new mosContent( $database );
	$row->load($id);
  $row->text = $row->introtext . $row->fulltext;
	// Ugly but needed to do all the stuff the PDF class cant handle
  ob_start();
  ?>
  <?php echo "<?xml version=\"1.0\" encoding=\"iso-8859-1\"?".">"; ?>
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
	<title><?php echo $mosConfig_sitename; ?> :: <?php echo $row->title; ?></title>
	<link rel="stylesheet" href="templates/<?php echo $cur_template;?>/css/template_css.css" type="text/css" />
	<meta http-equiv="Content-Type" content="text/html; <?php echo _ISO; ?>" />
	</head>
	<body class="contentpane">
	<P>
	<?
  $row->html = ob_get_contents();
  ob_end_clean();
	$row->html .= PDF_mosimage($row);
	$row->html .= "</body></html>";
  
        require($mosConfig_absolute_path."/includes/fpdf/fpdf_include.php" );

        $pdf = new PDF();
        $pdf->Open();
        $pdf->AddFont('Tahoma','','tahoma.php');
        $pdf->SetFont('Tahoma','',12);
        $pdf->AddPage();
        $pdf->WriteHTML($row->html);
        //save and redirect
       // name, dest
       // dest can be, (I = Inline, D = download, F = Save to local file, S = return as string)
        $pdf->Output("mambo.pdf","I");


}
function decodeHTML($string) {
	$string = strtr($string, array_flip(get_html_translation_table(HTML_ENTITIES)));
	$string = preg_replace("/&#([0-9]+);/me", "chr('\\1')", $string);
	return $string;
}

function get_php_setting($val) {
	$r =  (ini_get($val) == '1' ? 1 : 0);
	return $r ? 'ON' : 'OFF';
}

function PDF_mosimage( $row ) {
	global $mosConfig_live_site, $mosConfig_absolute_path;

	$row->images = explode( "\n", $row->images );
	$images = array();

	foreach ($row->images as $img) {
		$img = trim( $img );
		if ($img) {
			$temp = explode( '|', trim( $img ) );
			if (!isset( $temp[1] )) {
				$temp[1] = "left";
			}
			if (!isset( $temp[2] )) {
				$temp[2] = "Image";
			} else {
				$temp[2] = htmlspecialchars( $temp[2] );
			}
			if (!isset( $temp[3] )) {
				$temp[3] = "0";
			}
			$size = '';
			if (function_exists( 'getimagesize' )) {
				$size = @getimagesize( "$mosConfig_absolute_path/images/stories/$temp[0]" );
				if (is_array( $size )) {
					$size = "width=\"$size[0]\" height=\"$size[1]\"";
				}
			}
			$images[] = "<img src=\"$mosConfig_live_site/images/stories/$temp[0]\" $size align=\"$temp[1]\"  hspace=\"6\" alt=\"$temp[2]\" border=\"$temp[3]\" />";
		}
	}

	$text = explode( '{mosimage}', $row->text );

	$row->text = $text[0];

	for ($i=0, $n=count( $text )-1; $i < $n; $i++) {
		if (isset( $images[$i] )) {
			$row->text .= $images[$i];
		}
		if (isset( $text[$i+1] )) {
			$row->text .= $text[$i+1];
		}
	}
	unset( $text );
	return $row->text;
}
?>
