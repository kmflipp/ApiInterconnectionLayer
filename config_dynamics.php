<?php
if (!defined('IN_CFG')) {
    echo 'You should not be here. This attempt was logged!';
    die();
}

//configuration from database table
$failed_wsp_login=read_config_parameter('failed_wps_login');