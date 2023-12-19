<?php
require_once("../parts/config.php");
require("../libs/functions.php");
session_start();
if (isLoggedIn()) {
    $sql = "DELETE FROM favorites WHERE urun_kodu= ?";
    $stmt = mysqli_prepare($baglanti, $sql);
    $urun_id = $_POST['product_id'];
    mysqli_stmt_bind_param($stmt, "i", $urun_id);

    if (mysqli_stmt_execute($stmt)) {
        mysqli_stmt_close($stmt);
        mysqli_close($baglanti);
        header("Location: ../pages/urun_detay.php?kod=$urun_id");
        exit();
    }
} else {
    header("Location: ../login.php");
}
