<?php
if (!defined('IN_CFG')) {
    echo 'You should not be here. This attempt was logged!';
    die();
}

$active=1;

if ($active==1) {
    //main configuration
    $controlunit_type="wildix";
    $customer_name="Peppino salumi SA";

    //wildix configuration
    $wildix_apiEndPoint = "https://10.120.7.30/api/v1";
    $wildix_user = "franco.deludicibus";
    $wildix_passwd = "Ab8adaixp%";

    //mail receiver
    $to = "dp@danielepierini.ch";
}