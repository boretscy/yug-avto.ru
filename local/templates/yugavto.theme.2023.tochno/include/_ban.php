<?php
    $ips = array_keys( json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'].'/about/log_request/ips.json'), true) );
    if ( in_array( $_SERVER['REMOTE_ADDR'], $ips ) ) {
        header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500); die;
    }
?>