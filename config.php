<?php
if (!defined('IN_CFG')) {
    echo 'You should not be here. This attempt was logged!';
    die();
}

$apiEndPoint='https://www.wsplatform.com/v1/?page=api';

$email='test@email.ch';
$password='donotopenpandoravase';

$dbhost="localhost";
$dbuname="root";
$dbpass="Rodney8472";
$dbname="isc";

$key = strtoupper(substr(md5('W7E7INJX2V-'.md5(date('Ymd'))),0,20));



$controlunit_type="1";
$controlunit_ip="";
$controlunit_name="";