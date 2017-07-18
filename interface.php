<?php
define('IN_CFG', true);

require_once("config.php");
require_once("db.php");
require_once("Phpmailer/PHPMailerAutoload.php");
require_once("functions.php");
require_once("config_dynamics.php");


if ($max_wps_failed_login_attempt > intval($failed_wsp_login)) {
    $response=wsp_login();
    if ($response['response']=='error') {
        isc_log('wsp_login',$response[response],$response[error]);
        send_email($customer_name.'WSP API Interconnection Layer: wsp_login', $to, $response[response].': '.$response[error]);
        if(write_config_parameter('failed_wps_login',$failed_wsp_login,intval($failed_wsp_login)+1)) {
            isc_log('wsp_login','Login attempt','Attempt value: '.intval($failed_wsp_login)+1);
        }else{
            isc_log('wsp_login','Login attempt','Failed to set new failed login attempt value in configuration');
        }
        echo "Program terminated with errors. Please check the log table.";
        exit;
    }else{
        isc_log('wsp_login',$response[response],'');
        echo "Program logged on succesfully on WSP API.<br>";
        print_r($response);
        //$toekn=$response[token];

        if ($controlunit_type=='1') {
            require_once('Phpmodbus/ModbusMaster.php');

            // Create Modbus object
            $modbus = new ModbusMasterUdp($modbus_host);

            try {
                // Read input discretes - FC 4
                $recData = $modbus->readMultipleInputRegisters(0, 0, 2);
                isc_log('Main: modbus interrogation',$modbus_host,$recData);
                echo "Main: modbus interogation. Data stream downloaded.";
            }
            catch (Exception $e) {
                isc_log('Main: modbus interrogation',$modbus,$e);
                echo "Main: modbus interogation. Program terminated with errors. Please check the log table.";
                exit;
            }

            $json_recData= json_encode($recData);
            wsp_recData($token,$json_recData);

        }elseif ($controlunit_type=='2') {

        }elseif ($controlunit_type=='3') {

        }else{

        }
    }
}else{
    isc_log('wsp_login','Login attempt','Limit reached');
    send_email($customer_name.'WSP API Interconnection Layer: Login attempt', $to, 'Max login attempt reached, system disabled ');
    echo "Program terminated with max login attempt error. System disabled";
    exit;
}
