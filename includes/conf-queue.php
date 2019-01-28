<?php

function add_queue($reldir) {
    $queue_file = "queue.php";
    $line = "\n<h4><a href=https://multimedia.xarxacatala.cat/".$reldir.">".$reldir."</a></h4>";
    file_put_contents($queue_file, $line, FILE_APPEND | LOCK_EX);
}