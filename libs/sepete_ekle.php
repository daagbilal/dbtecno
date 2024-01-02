<?php
require_once("../parts/config.php");
require("functions.php");
session_start();
if (isLoggedIn()) {
    $sql = "INSERT INTO sepet (musteri_id, urun_kodu, miktar, add_time) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($baglanti, $sql);
    $musteri_id = $_SESSION["musteri_id"];
    $urun_id = safe_html($_POST['product_id']);
    $miktar = 1;
    $add_time = date('Y-m-d H:i:s');
    mysqli_stmt_bind_param($stmt, "iiis", $musteri_id, $urun_id, $miktar, $add_time);

    if (mysqli_stmt_execute($stmt)) {
        mysqli_stmt_close($stmt);
        mysqli_close($baglanti);
        header("Location: ../pages/sepet.php");
    }
} else {
    header("Location: ../login.php");
}
