<?php
// Name of the file
require("config.php");
$filename = '1.sql';

// MySQL host
$mysql_host = $cfg['hostname'];
// MySQL username
$mysql_username = $cfg['username'];
// MySQL password
$mysql_password = $cfg['password'];
// Database name
$mysql_database = $cfg['database'];

//////////////////////////////////////////////////////////////////////////////////////////////

// Connect to MySQL server
mysql_connect($mysql_host, $mysql_username, $mysql_password) or die('Error connecting to MySQL server: ' . mysql_error());
// Select database
mysql_select_db($mysql_database) or die('Error selecting MySQL database: ' . mysql_error());

// Temporary variable, used to store current query
$templine = '';
// Read in entire file
$lines = file($filename);
// Loop through each line
foreach ($lines as $line_num => $line) {
// Only continue if it's not a comment
if (substr($line, 0, 2) != '--' && $line != '') {
// Add this line to the current segment
$templine .= $line;
echo $line;
// If it has a semicolon at the end, it's the end of the query
if (substr(trim($line), -1, 1) == ';') {
// Perform the query
mysql_query($templine) or print('Error performing query \'<b>' . $templine . '</b>\': ' . mysql_error() . '<br /><br />');
// Reset temp variable to empty
$templine = '';
}
}
}

?>