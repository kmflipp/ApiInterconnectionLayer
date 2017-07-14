<?php
define('IN_CFG', true);

require_once('config.php');
require_once("db.php");
require_once("functions.php");


$response=wsp_login();
if ($response['response']=='error') {
    isc_log('wsp_login',$response[response],$response[error]);
    echo "Program terminated with errors. Please check the log table.";
    exit;
}else{
    isc_log('wsp_login',$response[response],'');
    echo "Program logged on succesfully on WSP API.";
    $toekn=$response[token];

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
