<?php

include "conf-queue.php";
include_once "logging.php";

function encode($subs, $reldir, $base) {
    if ($subs) {
        logs("started encoding with subtitles ".$base.$reldir.".\n");
        exec("perl scripts/subs_encode.pl \"".$base."\" \"".$reldir."\" > /dev/null 2>&1 &");
        add_queue($reldir);
    }
    else {
        logs("started encoding ".$base.$reldir.".\n");
        exec("perl scripts/encode.pl \"".$base."\" \"".$reldir."\" > /dev/null 2>&1 &");
        add_queue($reldir);
    }
}
?>