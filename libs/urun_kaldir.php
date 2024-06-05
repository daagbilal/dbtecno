<?php
session_start();
require_once("../parts/config.php");
require("functions.php");

if (isset($_GET["product_id"]) && isLoggedIn()) {
    $urun_kodu = $_GET["product_id"];
    $musteri_id = $_SESSION["musteri_id"];

    $sql = "DELETE FROM sepet WHERE urun_kodu = ? AND musteri_id = ?;";

    $stmt = mysqli_prepare($baglanti, $sql);
    mysqli_stmt_bind_param($stmt, "ii", $urun_kodu, $musteri_id);

    if (mysqli_stmt_execute($stmt)) {
        exit(json_encode(['mesaj' => 1]));
    }
} else {
    header("location: ../login.php");
}

mysqli_close($baglanti);
