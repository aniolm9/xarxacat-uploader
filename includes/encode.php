<?php

include "conf-queue.php";

function encode($subs, $reldir, $base) {
    if ($subs) {
        exec("bash scripts/subs_encode ".$base." ".$reldir." > /dev/null 2>&1 &");
        add_queue($reldir);
    }
    else {
        exec("bash scripts/encode ".$base." ".$reldir." > /dev/null 2>&1 &");
        add_queue($reldir);
    }
}