<?php
session_start();
if(!$_SESSION['user']){
    header('HTTP/1.0 401 Unauthorized');
}
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
header('Content-Type: application/json; charset=utf-8');
require_once('../app/WorkPrincList.php');
$a=new WorkPrincList();
$a->readFromCSV('../data/WorkPrincs.csv');
if($_SERVER['REQUEST_METHOD']=='POST'){
    $json_data = file_get_contents('php://input');
    $data=json_decode($json_data,true);
    $a->add(['name'=>$data['name']]);
    $a->writeToCSV('../data/WorkPrincs.csv');
    echo "OK!";
}
if($_SERVER['REQUEST_METHOD']=='UPDATE'){
    $json_data = file_get_contents('php://input');
    $data=json_decode($json_data,true);
    $a->update(['id'=>$data['id'],'name'=>$data['name']]);
    $a->writeToCSV('../data/WorkPrincs.csv');
    echo "OK!";
}
else if($_SERVER['REQUEST_METHOD']=='DELETE'){
    $a->delete($_REQUEST['id']);
    $a->writeToCSV('../data/WorkPrincs.csv');
} 
else if($_SERVER['REQUEST_METHOD']=='GET'){
    if(isset($_GET['id'])){
        echo json_encode($a->getById($_GET['id']));
    } else{
        echo $a->getAsJSON();
    }
    
}
?>