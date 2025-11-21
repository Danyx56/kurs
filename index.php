<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once('./app/InfraHeaterList.php');
require_once('./app/PropertyList.php');
require_once('./app/SphereOfApplList.php');
require_once('./app/WorkPrincList.php');
$c=new InfraHeaterList();
$c->readFromCSV('data\InfraHeaters1.csv');
$c->display();
$c->update(
	[
		'id'=>'2',
		'model'=>'WETAIR WQH-2020',
		'vendor'=>'WetAir',
		'price'=>'1000',
		'workPrinc'=>'Електричний',
		'sphereOfAppl'=>'Побутовий',
		'properties'=>'{"Потужність": "1200 Вт", "Площа обігріву": "20 м<sup>2</sup>", "Спосіб монтажу": "підлоговий", "Тип обігрівального елемента": "кварцовий"}'
	]
);
$c->writeToCSV('data\InfraHeaters1.csv');
$c->display();
/* $c->delete(1);
$c->display(); */
?>