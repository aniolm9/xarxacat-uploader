<?php

function getTemporades($sql, $tvshow) {
    $temporades = array();
    while ($row = $sql->fetch_assoc()) {
        $temporades[] = $row['name'];
    }

    $config = '<div id="'.$tvshow.'">
	<h5>Temporades '.$tvshow.':</h5>
	<select id="'.$tvshow.'Multi" name="'.$tvshow.'Multi" required>
    <option selected="selected">---</option>';

    foreach ($temporades as $temporada) {
        $config .= '<option value="'. $temporada.' ">' . $temporada . '</option>';
    }

    $config .= '</select>
		</div>';

    return $config;
}
