<?php

include "conf-queue.php";

function encode($subs, $reldir, $base) {
    if ($subs) {
        exec("perl scripts/subs_encode.pl ".$base." ".$reldir." > /dev/null 2>&1 &");
        add_queue($reldir);
    }
    else {
        exec("perl scripts/encode.pl ".$base." ".$reldir." > /dev/null 2>&1 &");
        add_queue($reldir);
    }
}