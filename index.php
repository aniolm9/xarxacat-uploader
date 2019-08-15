<!DOCTYPE html>
<?php
include "includes/conf-tvshows.php";
include "includes/conn.php";
?>
<html>
<head>
    <title>Uploader | Xarxa Català</title>
    <meta charset="UTF-8">

    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css" />
    <link rel="stylesheet" href="bootstrap/css/bootstrap-theme.css" />
    <link rel="stylesheet" href="css/style.css" />

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/tvshows.js" async></script>
    <script type="text/javascript" src="js/type.js" async></script>
    <script type="text/javascript" src="js/encode.js" async></script>
    <script type="text/javascript" src="js/amaga.js" async></script>

</head>
<body>

<div class="container margin-v-big">
    <h1>Uploader de Xarxa Català</h1>
    <h6>Mida màxima: 10 GB.</h6>
    <h6>Formats permesos: mkv, mp4, avi.</h6>
    <br>

    <form method="post" action="upload.php" id="uploader" name="uploader" enctype="multipart/form-data">
        <h5>Sèrie:</h5>
        <select id="show" name="show" required>
            <option value="none" selected="selected">---</option>
            <option value="Class">Class</option>
            <option value="DW">Doctor Who</option>
            <option value="OP">One Piece</option>
            <option value="TSJA">The Sarah Jane Adventures</option>
            <option value="TW">Torchwood</option>
        </select>

        <!-- Config temporades -->
        <?php
        $sql = mysqli_query($conn, "SELECT name FROM shows");
        $shows = array();
        while ($row = $sql->fetch_assoc()) {
            $shows[] = $row['name'];
        }
        foreach ($shows as $show) {
            $sql = mysqli_query($conn, 'SELECT seasons.name FROM seasons INNER JOIN shows ON shows.name = "'.$show.'" AND seasons.show_id = shows.id');
            echo getTemporades($sql, $show);
        }
        mysqli_close($conn);
        ?>
        <!-- Fi config temporades-->

        <h5>Tipus:</h5>
        <select id="tipus" name="tipus" required>
            <option value="none" selected="selected">---</option>
            <option value="episodes">Capítol</option>
            <option value="films">Pel·lícula</option>
            <option value="minisodes">Minisodi</option>
            <option value="prequels">Preqüela</option>
            <option value="sequels">Seqüela</option>
            <option value="extras">Extra</option>
        </select>

        <div id="numero">
            <h5>Número:</h5>
            <input type="text" name="num">
        </div>

        <div id="any">
            <h5>Any:</h5>
            <input type="text" name="year">
        </div>

        <h5>Nom:</h5>
        <input type="text" name="name" required>

        <br>
        Cremar subtítols: <input type="checkbox" name="subs" value="subs">

        <br>
        Encodar: <input type="checkbox" name="encodar" value="encodar">

        <br>
        <br>
        <h5>Selecciona un fitxer:</h5>
        <input type="file" name="fileToUpload" id="fileToUpload" required>

        <br>
        <br>

        <div>
            <input type="submit" name="submit" value="Enviar" >
            <input type="reset" value="Reiniciar" onClick="amaga();">
            <h5><a href='queue.php'>Veure la cua.</a></h5>
        </div>
    </form>
</div>
</body>
</html>
