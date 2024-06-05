<?php
require_once("../parts/config.php");
require("../libs/functions.php");
session_start();

if (isset($_GET["product_id"]) && isLoggedIn()) {
    $urun_kodu = $_GET["product_id"];
    $musteri_id = $_SESSION["musteri_id"];

    $sql = "DELETE FROM evaluations WHERE urun_kodu = ? AND musteri_id = ?;";

    $stmt = mysqli_prepare($baglanti, $sql);
    mysqli_stmt_bind_param($stmt, "ii", $urun_kodu, $musteri_id);
    $mesaj = "";
    if (mysqli_stmt_execute($stmt)) {
        $mesaj = "Ürün Silindi.";
    } else {
        $mesaj = "Ürün silme işlemi başarısız!";
    }
    exit(json_encode(['mesaj' => $mesaj]));
} else {
    header("location: ../login.php");
}

mysqli_close($baglanti);
