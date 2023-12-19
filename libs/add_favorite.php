<?php
require_once("../parts/config.php");
require("../libs/functions.php");
session_start();
if (isLoggedIn()) {
    $sql = "INSERT INTO favorites (musteri_id, urun_kodu, add_time) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($baglanti, $sql);
    $musteri_id = $_SESSION["musteri_id"];
    $urun_id = $_POST['product_id'];
    $add_time = date('Y-m-d H:i:s');
    mysqli_stmt_bind_param($stmt, "iis", $musteri_id, $urun_id, $add_time);

    if (mysqli_stmt_execute($stmt)) {
        mysqli_stmt_close($stmt);
        mysqli_close($baglanti);
        header("Location: ../pages/urun_detay.php?kod=$urun_id");
        exit();
    }
} else {
    header("Location: ../login.php");
}
