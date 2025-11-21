<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
header('Content-Type: application/json; charset=utf-8');
require_once('../app/WorkPrincList.php');
$a=new WorkPrincList();
$a->readFromCSV('../data/WorkPrincs.csv');
echo $a->getAsJSON();
?>