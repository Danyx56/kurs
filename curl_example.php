<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// Initialize a cURL session
$ch = curl_init();

// Set the URL to which the request will be made
$url = "http://localhost/php/kurs/api/getInfraHeatersAsJSON.php"; 
curl_setopt($ch, CURLOPT_URL, $url);

// Set CURLOPT_RETURNTRANSFER to true to get the response as a string
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Execute the cURL request and store the response
$response = curl_exec($ch);

// Check for cURL errors
if (curl_errno($ch)) {
    $error_msg = curl_error($ch);
    echo "cURL Error: " . $error_msg;
} else {
    // Process the response
    $data=json_decode($response,TRUE)['infraHeaters'];
    for($i=0;$i<count($data);$i++){
        echo $data[$i]['id'].". ".$data[$i]['vendor']." ".$data[$i]['model']."</br>";
        echo "Принцип роботи: <i>".$data[$i]['workPrinc']."</i></br>";
        echo "Сфера застосування: <i>".$data[$i]['sphereOfAppl']."</i></br>";
        echo "Ціна: <b>".$data[$i]['price']."</b> грн</br>";
        echo "<b>Характеристики:</b></br>";
        foreach ($data[$i]['properties'] as $propertyName => $propertyValue) {
            echo $propertyName . ": " . $propertyValue . "</br>";
        }
    }
}

// Close the cURL session
curl_close($ch);

?>