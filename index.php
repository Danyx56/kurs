<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once('./app/InfraHeaterList.php');
require_once('./app/PropertyList.php');
require_once('./app/SphereOfApplList.php');
require_once('./app/WorkPrincList.php');
$servername = "localhost";
$username = "root";
$password = "111111";
$database ='kurs_db';
$a=new WorkPrincList();
// Create connection
$conn = new mysqli($servername, $username, $password,$database);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
$sql = "SELECT * FROM workprincs";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
    $a->add($row);
  }
  $a->display();
} else {
  echo "0 results";
}
$conn->close();
?>