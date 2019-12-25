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
include "includes/conn.php";

if (!isset($_POST['submit'])) {
    logs("didn't upload any file.\n");
    exit("No s'ha pujat cap fitxer.");
}

$base = "/var/www/multimedia/";
$base_url = "https://multimedia.xarxacatala.cat/";

// Inici variables del formulari
$size = mysqli_real_escape_string($conn, $_FILES["fileToUpload"]["size"]);
$tmp_name = mysqli_real_escape_string($conn, $_FILES["fileToUpload"]["tmp_name"]);
$type = mysqli_real_escape_string($conn, strtolower(pathinfo(basename($_FILES["fileToUpload"]["name"]),PATHINFO_EXTENSION)));
$filename = mysqli_real_escape_string($conn, preg_replace('/[^A-Za-z0-9\-]/', '', pathinfo($_FILES["fileToUpload"]["name"],PATHINFO_FILENAME)));
$show = mysqli_real_escape_string($conn, $_POST["show"]);
$content = mysqli_real_escape_string($conn, $_POST["tipus"]);
$number = mysqli_real_escape_string($conn, $_POST["num"]);
$name = mysqli_real_escape_string($conn, $_POST["name"]);
$year = mysqli_real_escape_string($conn, $_POST["year"]);

// Temporada
if ($show === "Class") {
    $temporada = str_replace(' ', '', mysqli_real_escape_string($conn, $_POST["ClassMulti"]));
}
elseif ($show === "DW") {
    $temporada = str_replace(' ', '', mysqli_real_escape_string($conn, $_POST["DWMulti"]));
}
elseif ($show === "OP") {
    $temporada = str_replace(' ', '', mysqli_real_escape_string($conn, $_POST["OPMulti"]));
}
elseif ($show === "TSJA") {
    $temporada = str_replace(' ', '', mysqli_real_escape_string($conn, $_POST["TSJAMulti"]));
}
elseif ($show === "TW") {
    $temporada = str_replace(' ', '', mysqli_real_escape_string($conn, $_POST["TWMulti"]));
}
else {
    logs("didn't select a valid TV show.\n");
    exit("La sèrie seleccionada no és correcta.");
}
if ($temporada === "---") {
    logs("didn't select a valid season.\n");
    exit("La temporada seleccionada no és correcta.");
}

// Encodar i subs
$subs = "no-subs";
$encodar = false;
if (isset($_POST["subs"])) {
    $subs = "with-subs";
    $encodar = true;
    $filename = $filename.".mp4";
}
elseif (isset($_POST["encodar"])) {
    $encodar = true;
    $filename = $filename.".mp4";
}
else {
    $filename = $filename.".".$type;
}
// Final variables formulari

// Preparar variables per moure i inserir.
$show_id = mysqli_fetch_row(mysqli_query($conn,'SELECT id FROM shows WHERE name="'.$show.'"'))[0];
$season_id = mysqli_fetch_row(mysqli_query($conn,'SELECT id FROM seasons WHERE name="'.$temporada.'" AND show_id='.$show_id))[0];

if ($show === "OP") {
    $reldir = "one-piece/";
    $temporada = "serie/".$temporada;
}
else {
    $reldir = $show."/";
}

if ($content == "capitol") {
    $reldir .= $temporada."/".$filename;
    $url = $base_url.$reldir;
    $order = "INSERT INTO episodes (number,name,season_id,show_id,url) VALUES ($number,'$name',$season_id,$show_id,'$url')";
}
elseif ($content == "peli") {
    $reldir .= "Pelis/".$filename;
    $url = $base_url.$reldir;
    $order = "INSERT INTO films (name,year,show_id,url) VALUES ('$name',$year,$show_id,'$url')";
}
elseif ($content == "minisodi") {
    $reldir .= $temporada."/minisodes/".$filename;
    $url = $base_url.$reldir;
    $order = "INSERT INTO minisodes (number,name,season_id,show_id,url) VALUES ($number,'$name',$season_id,$show_id,'$url')";
}
elseif ($content == "prequel") {
    $reldir .= $temporada."/prequels/".$filename;
    $url = $base_url.$reldir;
    $order = "INSERT INTO prequels (name,episode_id,season_id,show_id,url) VALUES ('$name',$number,$season_id,$show_id,'$url')";
}
elseif ($content == "sequel") {
    $reldir .= $temporada."/sequels/".$filename;
    $url = $base_url.$reldir;
    $order = "INSERT INTO sequels (name,episode_id,season_id,show_id,url) VALUES ('$name',$number,$season_id,$show_id,'$url')";
}
elseif ($content == "extra") {
    $reldir .= "Extres/".$filename;
    $url = $base_url.$reldir;
    $order = "INSERT INTO extras (name,show_id,url) VALUES ('$name',$show_id,'$url')";
}
$target_dir = $base.$reldir;

// Comprovacions
if (!checkexistance($target_dir) || !checksize($size) || !checktype($type)) {
    logs("tried to upload a file that didn't satisfy the conditions.\n");
    exit("No se satisfan les condicions per pujar el fitxer.");
}

// Puja el fitxer i insereix
if (move_uploaded_file($tmp_name, $target_dir) && mysqli_query($conn, $order)) {
    logs("has successfully uploaded the file ".$target_dir.".\n");
    if ($encodar) encode($subs, $reldir, $base);
    echo "<h4>El fitxer s'ha pujat correctament.</h4>";
    echo "<h4>Enllaç del fitxer: <a href=".$url.">".$url."</a></h4>";
    echo "<h4><a href='/'>Torna'm a l'inici.</a></h4>";
    echo "<h4><a href='queue.php'>Veure la cua.</a></h4>";
}
else {
    logs("tried to upload ".$target_dir." but it failed.\n");
    echo "<h4>Ha fallat alguna cosa. Si us plau, contacta amb l'administrador.</h4>";
}
?>

</html>
