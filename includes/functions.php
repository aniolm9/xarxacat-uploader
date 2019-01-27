<?php

// Max file size: 10GB
function checksize($size) {
    if ($size > 10000000000) {
        return false;
    }
    return true;
}

// Allowed types: mkv, mp4, avi.
function checktype($type) {
    if ($type != "mkv" && $type != "mp4" && $type != "avi") {
        return false;
    }
    return true;
}

// Returns true if the file does not exist.
function checkexistance($target_file) {
    if (file_exists($target_file)) {
        return false;
    }
    return true;
}

?>