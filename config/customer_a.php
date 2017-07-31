<?php
if (!defined('IN_CFG')) {
    echo 'You should not be here. This attempt was logged!';
    die();
}

$active=0;

if ($active==1) {
    //main configuration
    $controlunit_type="modbus";
    $customer_name="Latte Maremma SA";

    //modbus configuration
    $modbus_host="192.192.15.51";

    //mail receiver
    $to = "dp@danielepierini.ch";
}