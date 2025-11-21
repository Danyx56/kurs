<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
header('Content-Type: text/xml; charset=utf-8');
require_once('../app/InfraHeaterList.php');
$a=new InfraHeaterList();
$a->readFromCSV('../data/InfraHeaters.csv');
echo '<?xml version="1.0" encoding="UTF-8"?>';
echo $a->getAsXML();
?>