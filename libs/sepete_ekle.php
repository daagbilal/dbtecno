<?php
require_once("../parts/config.php");
require_once("../libs/functions.php");
session_start();
if (isLoggedIn()) {
    $sql = "INSERT INTO sepet (musteri_id, urun_kodu, miktar, add_time) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($baglanti, $sql);

    // Değişkenleri bağlama (bind)

    // Değişkenlere değer atama
    $musteri_id = $_SESSION["musteri_id"];
    $urun_id = safe_html($_POST['product_id']);
    $miktar = 1;
    $add_time = date('Y-m-d H:i:s');

    mysqli_stmt_bind_param($stmt, "iiis", $musteri_id, $urun_id, $miktar, $add_time);
    // Sorguyu çalıştırma
    if (mysqli_stmt_execute($stmt)) {
        header("Location: ../pages/sepet.php");
    }
} else {
    header("Location: ../login.php");
}

// Bağlantıyı kapatma
mysqli_stmt_close($stmt);
mysqli_close($baglanti);
