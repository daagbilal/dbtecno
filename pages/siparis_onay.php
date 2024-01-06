<?php require_once("../parts/config.php"); ?>
<?php require("../libs/functions.php") ?>
<?php session_start(); ?>
<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Siparişi Onayla</title>
    <link rel="stylesheet" href="../css/index.css">
</head>

<body style="background-color: #daddd678;">
    <?php include("../parts/index_header.php"); ?>

    <?php mysqli_close($baglanti) ?>
</body>

</html>