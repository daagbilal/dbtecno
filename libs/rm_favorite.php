<?php
require_once("../parts/config.php");
require("functions.php");
session_start();
if (isLoggedIn()) {
    $musteri_id = $_SESSION["musteri_id"];
    $sql = "DELETE FROM favorites WHERE urun_kodu= ? AND musteri_id = ?";
    $stmt = mysqli_prepare($baglanti, $sql);
    $urun_id = $_POST['product_id'];
    mysqli_stmt_bind_param($stmt, "ii", $urun_id, $musteri_id);

    if (mysqli_stmt_execute($stmt)) {
        mysqli_stmt_close($stmt);
        mysqli_close($baglanti);
        header("Location: ../pages/urun_detay.php?kod=$urun_id");
        exit();
    }
} else {
    header("Location: ../login.php");
}
