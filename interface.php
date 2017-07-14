<?php

require_once('config.php');
require_once("db.php");
require_once("function.php");


$cmd = 'login';

$params = http_build_query(array("cmd" => $cmd, "key" => $key, "email" => $email, "password" => $password));
$curl = curl_init($apiEndPoint);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/x-www-form-urlencoded'));
curl_setopt($curl, CURLOPT_POSTFIELDS, $params);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

$response = json_decode(curl_exec($curl),true);
$err = curl_error($curl);
$errorCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
curl_close($curl);

if ($response['response']=='error') {
}


if ($controlunit_type=='1') {
    require_once('Phpmodbus/ModbusMaster.php');

    // Create Modbus object
    $modbus = new ModbusMasterUdp("192.192.15.51");

    try {
        // Read input discretes - FC 4
        $recData = $modbus->readMultipleInputRegisters(0, 0, 2);
    }
    catch (Exception $e) {
        // Print error information if any
        echo $modbus;
        echo $e;
    }

    var_dump($recData);

    $cmd = 'login';

    $params = http_build_query(array("cmd" => $cmd, "key" => $key, "email" => $email, "password" => $password));
    $curl = curl_init($apiEndPoint);

    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/x-www-form-urlencoded'));
    curl_setopt($curl, CURLOPT_POSTFIELDS, $params);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($curl);
    $err = curl_error($curl);
    $errorCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    curl_close($curl);

    echo $response;

}elseif ($controlunit_type=='2') {

}elseif ($controlunit_type=='3') {

}else{

}
