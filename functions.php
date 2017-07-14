<?php


if (!defined('IN_CFG')) {
    echo 'You should not be here. This attempt was logged!';
    die();
}

function isc_log($field,$title,$description) {
    global $db;

    $sql=sprintf("INSERT INTO log (`timestamp`,field,title,description) VALUES (now(),'%s','%s','%s')",$field,$title,$description);
    $res=$db->sql_query($sql);

    $to      = 'dp@danielepierini.ch';
    $subject = 'WSP API Interconnection Layer: '.$field;
    $message = $title.': '.$description;
    $headers = 'From: testapi@garytechnology.ch' . "\r\n" .
        'Reply-To: testapi@garytechnology.ch' . "\r\n" .
        'X-Mailer: PHP/' . phpversion();

    mail($to, $subject, $message, $headers);

    return $res;
}

function wsp_login(){
    global $apiEndPoint, $key, $email, $password;
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

    return $response;
}

function wsp_recData($token,$json_recData){
    global $apiEndPoint;
    $cmd = 'recData';

    $params = http_build_query(array("cmd" => $cmd, "token" => $token, "json" => $json_recData));
    $curl = curl_init($apiEndPoint);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/x-www-form-urlencoded'));
    curl_setopt($curl, CURLOPT_POSTFIELDS, $params);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

    $response = json_decode(curl_exec($curl),true);
    $err = curl_error($curl);
    $errorCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    curl_close($curl);

    return $response;
}
