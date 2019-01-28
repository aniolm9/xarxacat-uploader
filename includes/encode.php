<?php

function encode($subs, $file) {
    if ($subs) {
        shell_exec("../scripts/subs_encode ".$file." &");
    }
    else {
        shell_exec("../scripts/encode ".$file." &");
    }
}