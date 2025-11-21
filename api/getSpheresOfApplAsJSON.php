<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
header('Content-Type: application/json; charset=utf-8');
require_once('../app/SphereOfApplList.php');
$a=new SphereOfApplList();
$a->readFromCSV('../data/SpheresOfAppl.csv');
echo $a->getAsJSON();
?>