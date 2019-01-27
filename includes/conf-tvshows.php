<?php

function getTemporades($tvshow) {
    $base = "https://multimedia.xarxacatala.cat";
    if ($tvshow === "Class") {
        $url = $base."/Class";
    }
    elseif ($tvshow === "DW") {
        $url = $base."/DW";
    }
    elseif ($tvshow === "OP") {
        $url = $base."/one-piece/serie";
    }
    elseif ($tvshow === "TSJA") {
        $url = $base."/TSJA";
    }
    elseif ($tvshow === "TW") {
        $url = $base."/Torchwood";
    }

    $html = file_get_contents($url);
    $dom = new DOMDocument;

    @$dom->loadHTML($html);
    $links = $dom->getElementsByTagName('a');

    return $links;
}

function getClassConfig() {
    $links = getTemporades("Class");

    $config = '<div id="Class">
	<h5>Temporades Class:</h5>
	<select id="classMulti" name="classMulti" required>
	<option selected="selected">---</option>';

    foreach ($links as $link) {
        $text = $link->getAttribute('href');
        if ($text !== "../" && strpos($text, '.') === false) {
            $temporada = substr_replace($text ,"",-1);
            $config .= '<option value="'. $temporada.' ">' . $temporada . '</option>';
        }
    }
    $config .= '</select>
		</div>';

    return $config;
}

function getDWConfig() {
    $links = getTemporades("DW");

    $config = '<div id="DW">
	<h5>Temporades Doctor Who:</h5>
	<select id="DWmulti" name="DWmulti" required>
	<option selected="selected">---</option>';

    foreach ($links as $link) {
        $text = $link->getAttribute('href');
        if ($text !== "../" && strpos($text, '.') === false) {
            $temporada = substr_replace($text ,"",-1);
            $config .= '<option value="'. $temporada.' ">' . $temporada . '</option>';
        }
    }
    $config .= '</select>
		</div>';

    return $config;
}

function getOPConfig() {
    $links = getTemporades("OP");

    $config = '<div id="OP">
	<h5>Sagues One Piece:</h5>
	<select id="OPmulti" name="OPmulti" required>
	<option selected="selected">---</option>';

    foreach ($links as $link) {
        $text = $link->getAttribute('href');
        if ($text !== "../" && strpos($text, '.') === false) {
            $temporada = substr_replace($text ,"",-1);
            $config .= '<option value="'. $temporada.' ">' . $temporada . '</option>';
        }
    }
    $config .= '</select>
		</div>';

    return $config;
}

function getTSJAConfig() {
    $links = getTemporades("TSJA");

    $config = '<div id="TSJA">
	<h5>Temporades The Sarah Jane Adventures:</h5>
	<select id="TSJAmulti" name="TSJAmulti" required>
	<option selected="selected">---</option>';

    foreach ($links as $link) {
        $text = $link->getAttribute('href');
        if ($text !== "../" && strpos($text, '.') === false) {
            $temporada = substr_replace($text ,"",-1);
            $config .= '<option value="'. $temporada.' ">' . $temporada . '</option>';
        }
    }
    $config .= '</select>
		</div>';

    return $config;
}

function getTWConfig() {
    $links = getTemporades("TW");

    $config = '<div id="TW">
	<h5>Temporades Torchwood:</h5>
	<select id="TWmulti" name="TWmulti" required>
	<option selected="selected">---</option>';

    foreach ($links as $link) {
        $text = $link->getAttribute('href');
        if ($text !== "../" && strpos($text, '.') === false) {
            $temporada = substr_replace($text ,"",-1);
            $config .= '<option value="'. $temporada.' ">' . $temporada . '</option>';
        }
    }
    $config .= '</select>
		</div>';

    return $config;
}