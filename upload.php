<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Uploader | Xarxa Català</title>
    <h1>Uploader de Xarxa Català</h1>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css" />
    <link rel="stylesheet" href="bootstrap/css/bootstrap-theme.css" />
    <link rel="stylesheet" href="css/style.css" />
</head>

<?php

include "includes/functions.php";
include_once "includes/logging.php";
include "includes/encode.php";

if (!isset($_POST['submit'])) {
    logs("didn't upload any file.\n");
    exit("No s'ha pujat cap fitxer.");
}

$base = "/var/www/multimedia/";

// Inici variables del formulari
$size = htmlspecialchars($_FILES["fileToUpload"]["size"]);
$tmp_name = htmlspecialchars($_FILES["fileToUpload"]["tmp_name"]);
$type = htmlspecialchars(strtolower(pathinfo(basename($_FILES["fileToUpload"]["name"]),PATHINFO_EXTENSION)));
$show = htmlspecialchars($_POST["show"]);

// Temporada
if ($show === "Class") {
    $temporada = str_replace(' ', '', htmlspecialchars($_POST["ClassMulti"]));
}
elseif ($show === "DW") {
    $temporada = str_replace(' ', '', htmlspecialchars($_POST["DWmulti"]));
}
elseif ($show === "OP") {
    $temporada = str_replace(' ', '', htmlspecialchars($_POST["OPmulti"]));
}
elseif ($show === "TSJA") {
    $temporada = str_replace(' ', '', htmlspecialchars($_POST["TSJAmulti"]));
}
elseif ($show === "TW") {
    $temporada = str_replace(' ', '', htmlspecialchars($_POST["TWmulti"]));
}
else {
    logs("didn't select a valid TV show.\n");
    exit("La sèrie seleccionada no és correcta.");
}
if ($temporada === "---") {
    logs("didn't select a valid season.\n");
    exit("La temporada seleccionada no és correcta.");
}

// Nom del fitxer
if ($show === "OP") {
    $episode = sprintf("%03s", $_POST["episode"]);
    $filename = "op_cat-".$episode.".".$type;
}
else {
    $episode = sprintf("%02s", $_POST["episode"]);
    $temporada_num = sprintf("%02s", filter_var($temporada, FILTER_SANITIZE_NUMBER_INT));
    $filename = $show."-".$temporada_num."x".$episode.".".$type;
}

// Encodar i subs
if (isset($_POST["subs"])) {
    $subs = true;
    $encodar = true;
}
elseif (isset($_POST["encodar"])) {
    $subs = false;
    $encodar = true;
}
else {
    $subs = false;
    $encodar = false;
}
// Final variables formulari

// Directori on es copiarà el fitxer pujat.
if ($show === "OP") {
    $reldir = "one-piece/serie/".$temporada."/".$filename;
}
else {
    $reldir = $show."/".$temporada."/".$filename;
}
$target_dir = $base.$reldir;

// Comprovacions
if (!checkexistance($target_dir) || !checksize($size) || !checktype($type)) {
    logs("tried to upload a file that didn't satisfy the conditions.\n");
    exit("No se satisfan les condicions per pujar el fitxer.");
}

// Puja el fitxer
if (move_uploaded_file($tmp_name, $target_dir)) {
    logs("has successfully uploaded the file ".$target_dir.".\n");
    if ($encodar) encode($subs, $reldir, $base);
    echo "<h4>El fitxer s'ha pujat correctament.</h4>";
    echo "<h4>Enllaç del fitxer: <a href=https://multimedia.xarxacatala.cat/".htmlspecialchars($reldir).">https://multimedia.xarxacatala.cat/".$reldir."</a></h4>";
    echo "<h4><a href='/'>Torna'm a l'inici.</a></h4>";
    echo "<h4><a href='queue.php'>Veure la cua.</a></h4>";
}
else {
    logs("tried to upload ".$target_dir." but it failed.\n");
    echo "<h4>Ha fallat alguna cosa. Si us plau, contacta amb l'administrador.</h4>";
}
?>

</html>