<?php
if (!defined('IN_CFG')) {
    echo 'You should not be here. This attempt was logged!';
    die();
}


function log($timestamp,$title,$description) {
    global $db;
    $sql="INSERT INTO log (`timestamp`,title,description) VALUES (now(),'$title','$description')";
    $db->sql_query($sql);
}
