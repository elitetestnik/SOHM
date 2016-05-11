<?php
//error_reporting(E_ALL);
ini_set('memory_limit', '256M');
date_default_timezone_set('Europe/Oslo');
require_once("../config.php");
require_once ($mosConfig_absolute_path.'/includes/PHPExcel.php');
require_once($mosConfig_absolute_path."/globals.php" );
require_once($mosConfig_absolute_path."/includes/mambo.php" );
require_once($mosConfig_absolute_path. '/includes/frontend.php' );
$option = trim( strtolower( mosGetParam( $_REQUEST, 'option' ) ) );
$Itemid = intval( mosGetParam( $_REQUEST, 'Itemid', null ) );
$database = new database( $mosConfig_host, $mosConfig_user, $mosConfig_password, $mosConfig_db, $mosConfig_dbprefix );
$database->debug( $mosConfig_debug );


//$cacheMethod = PHPExcel_CachedObjectStorageFactory:: cache_to_phpTemp;
//$cacheSettings = array( ' memoryCacheSize ' => '8MB');
//PHPExcel_Settings::setCacheStorageMethod($cacheMethod, $cacheSettings);

$objPHPExcel = new PHPExcel();

$objPHPExcel->getProperties()->setCreator("Sten Olav")
							 ->setLastModifiedBy("Customer programm")
							 ->setTitle("Promoters Database Export")
							 ->setSubject("Promoters Database Export")
							 ->setDescription("Promoters Database Export from customer program")
							 ->setKeywords("office 2007 openxml php")
							 ->setCategory("Databases");
$objPHPExcel->setActiveSheetIndex(0);
$objPHPExcel->getActiveSheet()->setTitle('Promoters');
$objPHPExcel->getDefaultStyle()->getFont()->setName('Arial');
$objPHPExcel->getDefaultStyle()->getFont()->setSize(9);
$hhh=array("ID","Promoter","Contact person","Weekend number","Address 1","Address 2","City code (ZIP)","Town","Location","Country","Local phone","Cell phone","e-mail", "Website","Comments");
$i=0;
foreach ($hhh as $hh){
 $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($i,1,$hh);$i++;
}
$query="select p.id, p.name, p.contact_person, p.weeknum , p.street_addr1, p.street_addr2, p.city_code, p.town, p.location, ( select c.name from demo3_countries c where c.id= p.country) as country, p.phone1, p.phone2, p.email, p.website, p.comments FROM nor_promoters p WHERE 1=1";
$database->setQuery('SET character_set_client = utf8');
$database->query();
$database->setQuery('SET character_set_connection = utf8');
$database->query();
$database->setQuery('SET character_set_results = utf8');
$database->query();
$database->setQuery('SET collation_connection = utf8_unicode_ci');
$database->query();
///global $database;
$database->setQuery( $query );
$lists = $database->loadObjectList();
$m=2;$n=0;


foreach($lists as $list){
    foreach($list as &$value)
        {
              $value =   html_entity_decode($value, ENT_NOQUOTES, 'UTF-8');
              $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($n,$m,$value);
              $n++;
    }
    $n=0;$m++;
}
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('O')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('P')->setAutoSize(true);
//Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="promoters.xls"');
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
exit;
?>
