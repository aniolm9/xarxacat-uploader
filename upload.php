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

if (!isset($_POST['submit'])) {
    exit("No s'ha pujat cap fitxer.");
}

$base = "/var/www/multimedia/";

// Inici variables del formulari
$size = htmlspecialchars($_FILES["fileToUpload"]["size"]);
$filename = str_replace(" ", "_", htmlspecialchars(basename($_FILES["fileToUpload"]["name"])));
$tmp_name = htmlspecialchars($_FILES["fileToUpload"]["tmp_name"]);
$type = htmlspecialchars(strtolower(pathinfo($filename,PATHINFO_EXTENSION)));
$show = htmlspecialchars($_POST["show"]);

// Temporada
if ($show === "Class") {
    $temporada = str_replace(' ', '', htmlspecialchars($_POST["classMulti"]));
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
    exit("La sèrie seleccionada no és correcta.");
}
if ($temporada === "---") exit("La temporada seleccionada no és correcta.");

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
    $reldir = "one-piece/serie/".$temporada.$filename;
}
elseif ($show === "TW") {
    $reldir = "Torchwood/".$temporada.$filename;
}
else {
    $reldir = $show."/".$temporada."/".$filename;
}
$target_dir = $base.$reldir;

// Comprovacions
if (checkexistance($target_dir) === false || checksize($size) === false || checktype($type) === false) exit("No se satisfan les condicions per pujar el fitxer.");

// Puja el fitxer
if (move_uploaded_file($tmp_name, $target_dir)) {
    echo "<h4>El fitxer s'ha pujat correctament.</h4>";
    echo "<h4>Enllaç del fitxer: <a href=https://multimedia.xarxacatala.cat/".$reldir.">https://multimedia.xarxacatala.cat/".$reldir."</a></h4>";
    echo "<h4><a href='/'>Torna'm a l'inici.</a></h4>";
}
else {
    echo "<h4>Ha fallat alguna cosa. Si us plau, contacta amb l'administrador.</h4>";
}
?>

</html>