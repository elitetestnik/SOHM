<?php
//error_reporting(E_ALL);
date_default_timezone_set('Europe/Oslo');
require_once("../config.php");
require_once($mosConfig_absolute_path."/globals.php" );
require_once($mosConfig_absolute_path."/includes/mambo.php" );
require_once($mosConfig_absolute_path. '/includes/frontend.php' );
$database = new database( $mosConfig_host, $mosConfig_user, $mosConfig_password, $mosConfig_db, $mosConfig_dbprefix );
$database->debug( $mosConfig_debug );

$query="select p.id, p.name, p.contact_person, p.weeknum , p.street_addr1, p.street_addr2, p.city_code, p.town, ( select c.name from nor_countries c where c.id= p.country) as country, p.phone1, p.phone2, p.email, p.website, p.comments FROM nor_promoters p WHERE 1=1";
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

foreach($lists as $list){
 $q="update nor_promoters set
  name ='".html_entity_decode($list->name, ENT_NOQUOTES, 'UTF-8')."',
  contact_person ='".html_entity_decode($list->contact_person, ENT_NOQUOTES, 'UTF-8')."',
  street_addr1 ='".html_entity_decode($list->street_addr1, ENT_NOQUOTES, 'UTF-8')."',
  street_addr2 ='".html_entity_decode($list->street_addr2, ENT_NOQUOTES, 'UTF-8')."',
  town ='".html_entity_decode($list->town, ENT_NOQUOTES, 'UTF-8')."'  where id=".$list->id;
  echo $q;
  $database->setQuery( $q );
   $database->query();
}
echo $q;
exit;
?>
