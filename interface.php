<?php
/**
 * Created by PhpStorm.
 * User: kmflipp
 * Date: 10.07.17
 * Time: 12:14
 */

require_once('config.php');


if ($controlunit_type=='1') {

}elseif ($controlunit_type=='2') {

}elseif ($controlunit_type=='3') {

}else{

}



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
