<?php

include "conf-queue.php";
include_once "logging.php";

function encode($subs, $reldir, $base) {
    logs("started encoding ".$base.$reldir.".\n");
    exec("perl scripts/encode.pl \"".$base."\" \"".$reldir."\" ".$subs." > /dev/null 2>&1 &");
    add_queue($reldir);
}
?>
