<?php
if (!defined('IN_CFG')) {
    echo 'You should not be here. This attempt was logged!';
    die();
}

//main configuration
$controlunit_type="1"; //1 modbus     2 web services      3 TecnoOut
$customer_name="Peppino salumi SA";
$failed_wsp_login=9999;
$max_wps_failed_login_attempt=5;

//mail configuration data
$smtp="asmtp.mail.hostpoint.ch";
$smtp_port="587";
$smtp_username="testapi@graytechnology.ch";
$smtp_password="_ISC_GRAY_000000";

//configurable by the customer
$to = "dp@danielepierini.ch";


//WPS API configuration data
$apiEndPoint='https://www.wsplatform.com/v1/?page=api';
$key = strtoupper(substr(md5('W7E7INJX2V-'.md5(date('Ymd'))),0,20));
$email='daniele.petrini@dbme.it';
$password='EDE8s2ntbaTw9fmY';

//database configuration
$dbhost="localhost";
$dbuname="root";
$dbpass="Rodney8472";
$dbname="isc";

//modbus configuration
//configurable by th custmer
$modbus_host="192.192.15.51";

