<?php
require_once("../parts/config.php");
require("functions.php");
session_start();
if (isset($_GET['product_id']) && isLoggedIn()) {
    $musteri_id = $_SESSION["musteri_id"];
    $sql = "DELETE FROM favorites WHERE urun_kodu= ? AND musteri_id = ?";
    $stmt = mysqli_prepare($baglanti, $sql);
    $urun_id = $_GET['product_id'];
    mysqli_stmt_bind_param($stmt, "ii", $urun_id, $musteri_id);

    if (mysqli_stmt_execute($stmt)) {
        exit(json_encode(["mesaj" => 1]));
    }
} else {
    header("Location: ../login.php");
}
