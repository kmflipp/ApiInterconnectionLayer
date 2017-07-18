<?php
if (!defined('IN_CFG')) {
    echo 'You should not be here. This attempt was logged!';
    die();
}


function send_email($subject,$to,$message){
    global $smtp, $smtp_port, $smtp_username, $smtp_password;

    $mail = new PHPMailer;
    $mail->isSMTP();
    $mail->SMTPDebug = 0;
    $mail->Debugoutput = 'html';
    $mail->Host = $smtp;
    $mail->Port = $smtp_port;
    $mail->SMTPAuth = true;
    $mail->Username = $smtp_username;
    $mail->Password = $smtp_password;
    $mail->setFrom($smtp_username, 'Api Interconnection Layer');

    $mail->addAddress($to, 'Api Interconnection Layer');
    $mail->Subject = $subject;
    $mail->msgHTML("<b>".$subject."</b><br><br>".$message);
    $mail->AltBody = $message;

    if (!$mail->send()) {
        isc_log('mail module',"Mailer error",$mail->ErrorInfo);
    } else {
        isc_log('mail module',"Mailer","Message Sent");
    }
}

function isc_log($field,$title,$description) {
    global $db;

    $sql=sprintf("INSERT INTO log (`timestamp`,field,title,description) VALUES (now(),'%s','%s','%s')",$field,$title,$description);
    $res=$db->sql_query($sql);

    return $res;
}

function read_config_parameter($param) {
    global $db;

    $sql=sprintf("SELECT * FROM config WHERE param='%s' ",$param);
    $rs=$db->sql_query($sql);
    $res=$db->sql_fetchrow($rs);

    return $res[value];
}

function write_config_parameter($param,$actual_value,$new_value) {
    global $db;

    $sql=sprintf("UPDATE config set value='%s' where param='%s' and value='%s' ",$new_value,$param,$actual_value);
    $res=$db->sql_query($sql);

    $saved_value=read_config_parameter($param);
    if($saved_value==$new_value) {
        return true;
    }else{
        return false;
    }
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

function wsp_logdeviceinformation($timestamp,$customer_name,$device,$ip_address){
    global $apiEndPoint, $key, $email;
    $cmd = 'logDeviceInformation';

    $params = http_build_query(array("cmd" => $cmd, "key" => $key, "user_login" => $email, "timestamp" => $timestamp, "customer_name" => $customer_name, "device" => $device, "ip_address" => $ip_address));
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

function wsp_registration(){
    global $apiEndPoint, $key;
    $cmd = 'user_registration';

    $params = http_build_query(array("cmd" => $cmd, "key" => $key, "email" => 'dp@danielepierini.ch', "nome" => 'Rodney', "cognome" => 'McKay', "codice_azienda" => 'UR2566', "codice_utente" => '37'));
    var_dump($params);
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
