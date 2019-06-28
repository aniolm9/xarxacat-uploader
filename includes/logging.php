<?php

function logs($user, $message) {
    date_default_timezone_set('Europe/Brussels');
    $data = date(DATE_RFC2822);
    $out_file = "/var/log/xarxacat-uploader/".date('m')."-uploader.log";
    $out_message = "[".$data."]"." The user ".$user." ".$message;

    file_put_contents($out_file, $out_message, FILE_APPEND | LOCK_EX);
}
?>