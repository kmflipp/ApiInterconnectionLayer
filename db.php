<?php
if (!defined('IN_CFG')) {
    echo 'You should not be here. This attempt was logged!';
    die();
}

include("mysql.php");

$db = new sql_db($dbhost, $dbuname, $dbpass, $dbname, false);
$rs=$db->sql_query("SET NAMES utf8");
